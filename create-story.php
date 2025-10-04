<?php
include_once 'config.php';

// Function to handle file uploads
function handle_image_upload($file, $uploadDir = "uploads_blog/") {
    if ($file["error"] !== UPLOAD_ERR_OK) {
        return ["error" => "No file uploaded or an error occurred."]; // Return error
    }

    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/bmp', 'image/tiff', 'image/svg+xml'];
    $maxSize = 5 * 1024 * 1024; // 5MB

    $imageType = mime_content_type($file["tmp_name"]);
    if (!in_array($imageType, $allowedTypes)) {
        return ["error" => "Invalid image type. Only JPG, PNG, GIF, etc., are allowed."]; // Return error
    }

    if ($file["size"] > $maxSize) {
        return ["error" => "File size exceeds the 5MB limit."]; // Return error
    }

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $imageName = uniqid() . "_" . basename($file["name"]);
    $imagePath = $uploadDir . $imageName;

    if (move_uploaded_file($file["tmp_name"], $imagePath)) {
        return $imagePath;
    }

    return null; // Failed to move file
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Delete a post
    if (isset($_POST["delete"])) {
        $id = $_POST["delete"];
        try {
            $stmt = $pdo->prepare("DELETE FROM posts WHERE id = :id");
            $stmt->execute([":id" => $id]);
            echo json_encode(["success" => "Post deleted successfully"]);
        } catch (PDOException $e) {
            echo json_encode(["error" => "Database error: " . $e->getMessage()]);
        }
        exit;
    }

    // Common fields
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $author = $_POST['author'] ?? 'hayatu';

    // Handle main image upload
    $main_image_path = null;
    if (isset($_FILES["image"])) {
        $upload_result = handle_image_upload($_FILES["image"]);
        if (isset($upload_result["error"])) {
            echo json_encode(["error" => $upload_result["error"]]);
            exit;
        }
        $main_image_path = $upload_result;
    }

    // Handle additional images
    $additional_images_paths = [];
    if (isset($_FILES["images"])) {
        $files = $_FILES["images"];
        $num_files = count($files['name']);
        if ($num_files > 6) {
            echo json_encode(["error" => "You can upload a maximum of 6 additional images."]);
            exit;
        }
        for ($i = 0; $i < $num_files; $i++) {
            if ($files['error'][$i] === UPLOAD_ERR_OK) {
                $file = [
                    'name' => $files['name'][$i],
                    'type' => $files['type'][$i],
                    'tmp_name' => $files['tmp_name'][$i],
                    'error' => $files['error'][$i],
                    'size' => $files['size'][$i]
                ];
                $upload_result = handle_image_upload($file);
                if (isset($upload_result["error"])) {
                    echo json_encode(["error" => $upload_result["error"]]);
                    exit;
                }
                if ($upload_result) {
                    $additional_images_paths[] = $upload_result;
                }
            }
        }
    }

    // Serialize additional image paths into a JSON string
    $serialized_additional_images = json_encode($additional_images_paths);

    // Create a new post
    if (!isset($_POST["id"])) {
        if (empty($title) || empty($content)) {
            die("Title and content are required.");
        }

        try {
            $stmt = $pdo->prepare("INSERT INTO posts (title, content, author, banner_img, image_1, date_edited) VALUES (:title, :content, :author, :banner_img, :img1, NOW())");
            $stmt->execute([
                ':title' => $title,
                ':content' => $content,
                ':author' => $author,
                ':banner_img' => $main_image_path,
                ':img1' => $serialized_additional_images,
            ]);
            echo json_encode(["success" => "Blog post created successfully."]);
        } catch (PDOException $e) {
            echo json_encode(["error" => "Database error: " . $e->getMessage()]);
        }
    } else { // Update an existing post
        $id = $_POST["id"];
        if (empty($title) || empty($content)) {
            die("Title and content are required.");
        }

        $sql = "UPDATE posts SET title = :title, content = :content";
        $params = [
            ':title' => $title,
            ':content' => $content,
            ':id' => $id
        ];

        if ($main_image_path) {
            $sql .= ", banner_img = :banner_img";
            $params[':banner_img'] = $main_image_path;
        }

        // Only update additional images if new ones are provided
        if (!empty($additional_images_paths)) {
            $sql .= ", image_1 = :img1, image_2 = NULL, image_3 = NULL, image_4 = NULL";
            $params[':img1'] = $serialized_additional_images;
        }

        $sql .= " WHERE id = :id";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            echo json_encode(["success" => "Blog post updated successfully.", "serialized_images" => $serialized_additional_images]);
        } catch (PDOException $e) {
            echo json_encode(["error" => "Database error: " . $e->getMessage()]);
        }
    }
} else {
    echo json_encode(["error" => "Invalid request method."]);
}
?>
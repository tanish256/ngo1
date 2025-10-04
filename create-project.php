<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

require_once 'config.php'; //TODO change this on site migrating

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_FILES["image"]) || !isset($_POST["title"]) || !isset($_POST["content"])) {
        if (isset($_POST["del"])) {
            $ide =$_POST["del"];
            try {
                // Prepare the DELETE query
                $stmt = $pdo->prepare("DELETE FROM projects WHERE id = :id");
            
                // Execute the query with the provided id
                $stmt->execute([
                    ":id" => $ide // The ID of the project to delete
                ]);
            
                echo json_encode(["success" => "Project deleted successfully"]);
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }else{
            die(json_encode(["error" => "Missing required fields"]));
        }
    }elseif (!isset($_POST["id"])) {
        $title = trim($_POST["title"]);
    $content = trim($_POST["content"]);

    // Validate input
    if (empty($title) || empty($content)) {
        die(json_encode(["error" => "Title and content cannot be empty"]));
    }

    // Allow specific HTML tags for content
    $allowed_tags = '<i><b><u><br><strong><em>';
    $content = strip_tags($content, $allowed_tags);

    // Handle image upload
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $imageFile = $_FILES["image"];
    $imageName = time() . "_" . basename($imageFile["name"]);
    $targetFilePath = $targetDir . $imageName; 

    if (move_uploaded_file($imageFile["tmp_name"], $targetFilePath)) {
        $imageUrl = $targetFilePath;

        // Insert into database using prepared statement
        $currentTimestamp = date("Y-m-d H:i:s");
        try {
            $stmt = $pdo->prepare("INSERT INTO projects (title, image, description, date_uploaded) VALUES (:title, :image, :content, :created_at)");
            $stmt->execute([
                ":title" => $title,
                ":image" => $imageUrl,
                ":content" => $content,
                ":created_at" => $currentTimestamp // Bind the current timestamp to the query
            ]);

            echo json_encode(["success" => "Project created successfully"]);
        } catch (PDOException $e) {
            echo json_encode(["error" => "Database error: " . $e->getMessage()]);
        }
    } else {
        echo json_encode(["error" => "Image upload failed"]);
    }
}elseif (isset($_POST["del"])) {
    $ide =$_POST["id"];
    try {
        // Prepare the DELETE query
        $stmt = $pdo->prepare("DELETE FROM projects WHERE id = :id");
    
        // Execute the query with the provided id
        $stmt->execute([
            ":id" => $ide // The ID of the project to delete
        ]);
    
        echo json_encode(["success" => "Project deleted successfully"]);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    
}else {
    $title = trim($_POST["title"]);
    $content = trim($_POST["content"]);
    $ide =$_POST["id"];
    $allowed_tags = '<i><b><u><br><strong><em>';
    $content = strip_tags($content, $allowed_tags);

    $currentTimestamp = date("Y-m-d H:i:s");
        try {
            $stmt = $pdo->prepare("UPDATE projects SET title = :title, description = :content WHERE id = :id");

    // Execute the query with the provided values, including the ID
            $stmt->execute([
                ":title" => $title,
                ":content" => $content,
                ":id" => $ide // The ID of the project to update
            ]);

            echo json_encode(["success" => "Project eddited successfully"]);
        } catch (PDOException $e) {
            echo json_encode(["error" => "Database error: " . $e->getMessage()]);
        }

}
    }
    
?>

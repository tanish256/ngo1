<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $image_id = $_POST['image_id'] ?? '';

    if (empty($image_id)) {
        echo json_encode(["success" => false, "message" => "Image ID is missing."]);
        exit;
    }

    if (!isset($_FILES["image"]) || $_FILES["image"]["error"] !== UPLOAD_ERR_OK) {
        echo json_encode(["success" => false, "message" => "No image uploaded or an error occurred."]);
        exit;
    }

    $file = $_FILES["image"];
    $uploadDir = "../images/"; // Relative to this script

    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/bmp', 'image/tiff', 'image/svg+xml'];
    $maxSize = 5 * 1024 * 1024; // 5MB

    $imageType = mime_content_type($file["tmp_name"]);
    if (!in_array($imageType, $allowedTypes)) {
        echo json_encode(["success" => false, "message" => "Invalid image type. Only JPG, PNG, GIF, etc., are allowed."]);
        exit;
    }

    if ($file["size"] > $maxSize) {
        echo json_encode(["success" => false, "message" => "File size exceeds the 5MB limit."]);
        exit;
    }

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Use the original file name to maintain consistency, but sanitize it
    $imageName = basename($file["name"]);
    $imagePath = $uploadDir . $imageName;

    // If the file already exists, overwrite it
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }

    if (move_uploaded_file($file["tmp_name"], $imagePath)) {
        // Update banner_images.json
        $jsonFilePath = "../banner_images.json"; // Relative to this script
        $jsonData = file_get_contents($jsonFilePath);
        $images = json_decode($jsonData, true);

        // Store path relative to the root of the website
        $images[$image_id] = "images/" . $imageName;

        file_put_contents($jsonFilePath, json_encode($images, JSON_PRETTY_PRINT));

        echo json_encode(["success" => true, "message" => "Image uploaded and updated successfully.", "new_path" => "images/" . $imageName]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to move uploaded file."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}

?>
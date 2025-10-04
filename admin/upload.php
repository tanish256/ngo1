<?php
require_once 'config.php';

$target_dir = "../uploads/";
$target_dir2 = "uploads/";
$allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

if (!empty($_FILES['files']['name'][0])) {
    foreach ($_FILES['files']['name'] as $key => $file_name) {
        $file_tmp = $_FILES['files']['tmp_name'][$key];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $new_file_name = uniqid() . '_' . basename($file_name);
        $target_file = $target_dir . $new_file_name;
        $db_file_path = $target_dir2 . $new_file_name;

        if (in_array($file_ext, $allowed_types)) {
            if (move_uploaded_file($file_tmp, $target_file)) {
                try {
                    $stmt = $pdo->prepare("INSERT INTO gallery (file_path, alt_text) VALUES (?, ?)");
                    $stmt->execute([$db_file_path, '']);
                    echo "$file_name uploaded successfully!\n";
                } catch (PDOException $e) {
                    echo "Error inserting into database: " . $e->getMessage() . "\n";
                }
            } else {
                echo "Error uploading $file_name.\n";
            }
        } else {
            echo "$file_name is not a valid image file.\n";
        }
    }
} else {
    echo "No files selected.";
}
?>


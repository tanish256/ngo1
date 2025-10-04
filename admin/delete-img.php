<?php
require_once 'config.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    try {
        // Get the file path before deleting from the database
        $stmt = $pdo->prepare("SELECT file_path FROM gallery WHERE id = ?");
        $stmt->execute([$id]);
        $image = $stmt->fetch();

        if ($image) {
            // Delete the file from the server
            if (unlink("../" . $image['file_path'])) {
                // Delete the record from the database
                $delete_stmt = $pdo->prepare("DELETE FROM gallery WHERE id = ?");
                $delete_stmt->execute([$id]);
                echo "Image deleted successfully!";
            } else {
                echo "Error deleting file from server.";
            }
        } else {
            echo "Image not found in database.";
        }
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>
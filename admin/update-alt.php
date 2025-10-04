<?php
require_once 'config.php';

if (isset($_POST['id']) && isset($_POST['alt'])) {
    $id = $_POST['id'];
    $alt = $_POST['alt'];

    try {
        $stmt = $pdo->prepare("UPDATE gallery SET alt_text = ? WHERE id = ?");
        $stmt->execute([$alt, $id]);
        echo "Alt text updated successfully!";
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>
<?php
require_once 'admin/config.php';

$images_per_page = 20;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $images_per_page;

try {
    // Get total number of images
    $total_stmt = $pdo->query("SELECT COUNT(*) FROM gallery");
    $total_images = $total_stmt->fetchColumn();
    $total_pages = ceil($total_images / $images_per_page);

    // Get images for the current page
    $stmt = $pdo->prepare("SELECT * FROM gallery ORDER BY uploaded_at DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':limit', $images_per_page, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $images = $stmt->fetchAll();

    header('Content-Type: application/json');
    echo json_encode(['images' => $images, 'totalPages' => $total_pages]);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
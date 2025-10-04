<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['error' => 'Access denied']);
    exit();
}

header('Content-Type: application/json');

if (!isset($_POST['action'], $_POST['id'])) {
    echo json_encode(['error' => 'Invalid request']);
    exit();
}

$action = $_POST['action'];
$id = intval($_POST['id']);

if (!in_array($action, ['approve', 'reject'])) {
    echo json_encode(['error' => 'Invalid action']);
    exit();
}

try {
    require 'config.php';

    $status = $action === 'approve' ? 'approved' : 'rejected';

    $stmt = $pdo->prepare("UPDATE scholarship_subscribers SET status = ? WHERE id = ?");
    $stmt->execute([$status, $id]);

    echo json_encode(['success' => true]);

} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

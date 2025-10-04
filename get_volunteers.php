<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("HTTP/1.1 403 Forbidden");
    echo json_encode(['error' => 'Access denied']);
    exit();
}

include('config.php');

header('Content-Type: application/json');

try {
    // Get specific volunteer if ID is provided
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $stmt = $pdo->prepare("SELECT * FROM volunteers WHERE id = ?");
        $stmt->execute([$id]);
        $volunteer = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($volunteer) {
            echo json_encode(['volunteer' => $volunteer]);
        } else {
            echo json_encode(['error' => 'Volunteer not found']);
        }
    } else {
        // Get all volunteers
        $stmt = $pdo->query("SELECT * FROM volunteers ORDER BY created_at DESC");
        $volunteers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['volunteers' => $volunteers]);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
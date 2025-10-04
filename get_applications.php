<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("HTTP/1.1 403 Forbidden");
    echo json_encode(['error' => 'Access denied']);
    exit();
}

header('Content-Type: application/json');
require 'config.php';

try {

        if (isset($_GET['id'])) {
        $stmt = $pdo->prepare("SELECT * FROM scholarship_subscribers WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        $application = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$application) {
            echo json_encode(['error' => 'Application not found']);
            exit();
        }
        echo json_encode(['application' => $application]);
    }else{
            // Fetch all applications
    $stmt = $pdo->query("
        SELECT *
        FROM scholarship_subscribers
        ORDER BY created_at DESC
    ");

    $applications = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['applications' => $applications]);
    }

} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

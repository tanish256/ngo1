<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once 'config.php'; // Load database connection

if (!isset($_GET["id"])) {
    try {
        $stmt = $pdo->query("SELECT * FROM projects ORDER BY date_uploaded DESC");
        $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        echo json_encode($projects);
    } catch (PDOException $e) {
        echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    }
} else {
    // Sanitize and handle the 'id' parameter as a single value
    $id = $_GET["id"];
    
    try {
        // Use a prepared statement to select the project with the given id
        $stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
        $stmt->execute([$id]); // Bind the id to the query
    
        $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        echo json_encode($projects);
    } catch (PDOException $e) {
        echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    }
}
?>

<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
include_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
    
        try {
            $stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
            $stmt->execute([$id]);
            $blog = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($blog && !empty($blog['image_1'])) {
                $blog['additional_images'] = json_decode($blog['image_1'], true);
            } else {
                $blog['additional_images'] = [];
            }
            
            echo json_encode($blog);
        } catch (PDOException $e) {
            echo json_encode(["error" => "Database error: " . $e->getMessage()]);
        }
    } else {
        try {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmt = $pdo->query("SELECT * FROM posts ORDER BY date_edited DESC");
            $blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($blogs as &$blog) {
                if (!empty($blog['image_1'])) {
                    $blog['additional_images'] = json_decode($blog['image_1'], true);
                } else {
                    $blog['additional_images'] = [];
                }
            }
            
            echo json_encode(["status" => "success", "blogs" => $blogs]);
        } catch (PDOException $e) {
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
    }
}
?>
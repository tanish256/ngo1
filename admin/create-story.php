<?php
require '../config.php'; // Database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get input from the form
    $title = htmlspecialchars($_POST['title']); // Sanitize title (no HTML allowed)
    $content = $_POST['content']; // Raw content

    // Allowed HTML tags
    $allowed_tags = '<i><b><u><br><strong><em>';
    
    // Strip unwanted tags but allow specific ones
    $content = strip_tags($content, $allowed_tags);

    // Convert newlines to <br> for proper formatting
    $content = nl2br($content, false); // 'false' prevents duplicate <br> tags

    // Insert into the database
    $sql = "INSERT INTO story (title, text) VALUES (:title, :content)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':content', $content);

    if ($stmt->execute()) {
        echo "✅ Post added successfully!";
    } else {
        echo "❌ Error adding post.";
    }
}
?>

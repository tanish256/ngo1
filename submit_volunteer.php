<?php
header('Content-Type: application/json');

// Database credentials
require 'config.php';
// Get POST data (JSON expected)
$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
    exit;
}

// Sanitize inputs
$first_name = trim($input['firstName'] ?? '');
$last_name  = trim($input['lastName'] ?? '');
$email      = filter_var($input['email'] ?? '', FILTER_VALIDATE_EMAIL);
$phone      = trim($input['phone'] ?? '');
$motivation = trim($input['motivation'] ?? '');
$availability = trim($input['availability'] ?? '');
$terms_accepted = !empty($input['terms']) ? 1 : 0;

// Areas of interest as JSON array
$areas = [];
if (!empty($input['areas'])) {
    foreach ($input['areas'] as $area) {
        $areas[] = $area;
    }
}
$areas_json = json_encode($areas);

// Basic validation
if (!$first_name || !$last_name || !$email || !$phone || !$motivation || !$terms_accepted) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Please fill all required fields']);
    exit;
}

// Check if user already exists before inserting
$check_sql = "SELECT id FROM volunteers WHERE email = :email";
$check_stmt = $pdo->prepare($check_sql);
$check_stmt->execute([':email' => $email]);

if ($check_stmt->fetch()) {
    http_response_code(409); // Conflict
    echo json_encode(['status' => 'error', 'message' => 'User already exists']);
    exit;
}

// Insert into database
$sql = "INSERT INTO volunteers 
        (first_name, last_name, email, phone, areas_of_interest, availability, motivation, terms_accepted)
        VALUES 
        (:first_name, :last_name, :email, :phone, :areas, :availability, :motivation, :terms_accepted)";
$stmt = $pdo->prepare($sql);

try {
    $stmt->execute([
        ':first_name' => $first_name,
        ':last_name' => $last_name,
        ':email' => $email,
        ':phone' => $phone,
        ':areas' => $areas_json,
        ':availability' => $availability,
        ':motivation' => $motivation,
        ':terms_accepted' => $terms_accepted
    ]);
    echo json_encode(['status' => 'success', 'message' => 'Application submitted successfully']);
} catch(PDOException $e) {
    // Fallback constraint error check
    if ($e->getCode() == '23000' || str_contains($e->getMessage(), 'Duplicate')) {
        http_response_code(409);
        echo json_encode(['status' => 'error', 'message' => 'User already exists']);
    } else {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Failed to save application']);
    }
}
?>
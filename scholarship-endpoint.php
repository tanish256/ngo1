<?php
// scholarship-endpoint.php

header('Content-Type: application/json');

include 'config.php';

// Create uploads folder if it doesn't exist
$uploadDir = __DIR__ . '/uploads';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Helper function to save uploaded files
function handleUploads($files) {
    global $uploadDir;
    $savedFiles = [];

    foreach ($files['name'] as $key => $name) {
        $tmpName = $files['tmp_name'][$key];
        $ext = pathinfo($name, PATHINFO_EXTENSION);
        $safeName = uniqid() . '-' . preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $name);
        $destination = $uploadDir . '/' . $safeName;

        if (move_uploaded_file($tmpName, $destination)) {
            $savedFiles[] = $safeName;
        }
    }

    return $savedFiles;
}

// Get POST data
$firstName = trim($_POST['firstName'] ?? '');
$lastName = trim($_POST['lastName'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$dateOfBirth = trim($_POST['dateOfBirth'] ?? '');
$gender = $_POST['gender'] ?? null;
$nationality = trim($_POST['nationality'] ?? '');
$address = trim($_POST['address'] ?? '');

$currentGrade = $_POST['currentGrade'] ?? '';
$schoolName = trim($_POST['schoolName'] ?? '');
$gpa = trim($_POST['gpa'] ?? '');
$previousGrades = trim($_POST['previousGrades'] ?? '');
$achievements = trim($_POST['achievements'] ?? '');

$parentName = trim($_POST['parentName'] ?? '');
$parentOccupation = trim($_POST['parentOccupation'] ?? '');
$familyIncome = $_POST['familyIncome'] ?? '';
$siblings = $_POST['siblings'] ?? null;
$challenges = trim($_POST['challenges'] ?? '');

$scholarshipType = $_POST['scholarshipType'] ?? '';
$requestedAmount = $_POST['requestedAmount'] ?? null;
$reason = trim($_POST['reason'] ?? '');
$goals = trim($_POST['goals'] ?? '');
$extracurriculars = trim($_POST['extracurriculars'] ?? '');

$terms = isset($_POST['terms']) ? 1 : 0;
$consent = isset($_POST['consent']) ? 1 : 0;

// Handle file uploads
$uploadedFiles = [];
if (isset($_FILES['documents'])) {
    $uploadedFiles = handleUploads($_FILES['documents']);
}
$documentsJson = json_encode($uploadedFiles);

// Insert data into database
try {
    $stmt = $pdo->prepare("
        INSERT INTO scholarship_subscribers (
            first_name, last_name, email, phone, date_of_birth, gender, nationality, address,
            current_grade, school_name, gpa, previous_grades, achievements,
            parent_name, parent_occupation, family_income, siblings, challenges,
            scholarship_type, requested_amount, reason, goals, extracurriculars,
            documents, terms_accepted, consent_given
        ) VALUES (
            :first_name, :last_name, :email, :phone, :date_of_birth, :gender, :nationality, :address,
            :current_grade, :school_name, :gpa, :previous_grades, :achievements,
            :parent_name, :parent_occupation, :family_income, :siblings, :challenges,
            :scholarship_type, :requested_amount, :reason, :goals, :extracurriculars,
            :documents, :terms_accepted, :consent_given
        )
    ");

    try {
    $stmt->execute([
        ':first_name' => $firstName,
        ':last_name' => $lastName,
        ':email' => $email,
        ':phone' => $phone,
        ':date_of_birth' => $dateOfBirth ?: null,
        ':gender' => $gender,
        ':nationality' => $nationality,
        ':address' => $address,
        ':current_grade' => $currentGrade,
        ':school_name' => $schoolName,
        ':gpa' => $gpa,
        ':previous_grades' => $previousGrades,
        ':achievements' => $achievements,
        ':parent_name' => $parentName,
        ':parent_occupation' => $parentOccupation,
        ':family_income' => $familyIncome,
        ':siblings' => $siblings,
        ':challenges' => $challenges,
        ':scholarship_type' => $scholarshipType,
        ':requested_amount' => $requestedAmount,
        ':reason' => $reason,
        ':goals' => $goals,
        ':extracurriculars' => $extracurriculars,
        ':documents' => $documentsJson,
        ':terms_accepted' => $terms,
        ':consent_given' => $consent
    ]);

    http_response_code(201); // Created
    echo json_encode(['success' => true, 'message' => 'Application submitted successfully!']);

} catch (PDOException $e) {
    // Check for duplicate email
    if ($e->getCode() == 23000) { // SQLSTATE for integrity constraint violation
        http_response_code(409); // Conflict
        echo json_encode(['error' => 'User already submitted.']);
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(['error' => 'Failed to save application: ' . $e->getMessage()]);
    }
}
} catch (PDOException $e) {
    echo json_encode(['error' => 'Failed to save application: ' . $e->getMessage()]);
}

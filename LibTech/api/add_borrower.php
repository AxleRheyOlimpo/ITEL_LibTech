<?php
// ========================================
// api/add_borrower.php
// ========================================
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit();
}

$studentName = trim($_POST['student_name'] ?? '');
$studentId = trim($_POST['student_id'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');

if (empty($studentName) || empty($studentId) || empty($email)) {
    echo json_encode(['success' => false, 'message' => 'Name, ID, and email are required']);
    exit();
}

$database = new Database();
$db = $database->getConnection();

// Check if student ID already exists
$query = "SELECT borrower_id FROM borrowers WHERE student_id = :student_id";
$stmt = $db->prepare($query);
$stmt->bindParam(':student_id', $studentId);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    echo json_encode(['success' => false, 'message' => 'Student ID already exists']);
    exit();
}

$query = "INSERT INTO borrowers (student_name, student_id, email, phone) 
          VALUES (:student_name, :student_id, :email, :phone)";
$stmt = $db->prepare($query);
$stmt->bindParam(':student_name', $studentName);
$stmt->bindParam(':student_id', $studentId);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':phone', $phone);

if ($stmt->execute()) {
    echo json_encode([
        'success' => true,
        'message' => 'Borrower added successfully',
        'borrower_id' => $db->lastInsertId()
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to add borrower']);
}
?>
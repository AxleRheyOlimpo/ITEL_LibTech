<?php
// ========================================
// api/get_borrowers.php
// ========================================
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit();
}

$database = new Database();
$db = $database->getConnection();

$query = "SELECT borrower_id, student_name, student_id, email, phone, created_at 
          FROM borrowers ORDER BY student_name ASC";
$stmt = $db->prepare($query);
$stmt->execute();

$borrowers = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    'success' => true,
    'borrowers' => $borrowers
]);
?>
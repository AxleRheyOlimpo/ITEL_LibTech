<?php
// ========================================
// api/delete_borrower.php
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

$borrowerId = intval($_POST['borrower_id'] ?? 0);

$database = new Database();
$db = $database->getConnection();

$query = "DELETE FROM borrowers WHERE borrower_id = :borrower_id";
$stmt = $db->prepare($query);
$stmt->bindParam(':borrower_id', $borrowerId);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Borrower deleted successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to delete borrower']);
}
?>
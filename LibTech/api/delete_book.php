<?php
// ========================================
// api/delete_book.php
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

$bookId = intval($_POST['book_id'] ?? 0);

$database = new Database();
$db = $database->getConnection();

// Check if book has active transactions
$query = "SELECT COUNT(*) as count FROM book_transactions 
          WHERE book_id = :book_id AND status = 'issued'";
$stmt = $db->prepare($query);
$stmt->bindParam(':book_id', $bookId);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result['count'] > 0) {
    echo json_encode(['success' => false, 'message' => 'Cannot delete book with active loans']);
    exit();
}

$query = "DELETE FROM books WHERE book_id = :book_id";
$stmt = $db->prepare($query);
$stmt->bindParam(':book_id', $bookId);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Book deleted successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to delete book']);
}
?>
<?php
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
$bookTitle = trim($_POST['book_title'] ?? '');
$issueDate = $_POST['issue_date'] ?? '';
$dueDate = $_POST['due_date'] ?? '';

$database = new Database();
$db = $database->getConnection();
$userId = $_SESSION['user_id'];

// Find book
$query = "SELECT book_id, available_copies FROM books WHERE title = :title";
$stmt = $db->prepare($query);
$stmt->bindParam(':title', $bookTitle);
$stmt->execute();

if ($stmt->rowCount() === 0) {
    echo json_encode(['success' => false, 'message' => 'Book not found']);
    exit();
}

$book = $stmt->fetch(PDO::FETCH_ASSOC);

if ($book['available_copies'] <= 0) {
    echo json_encode(['success' => false, 'message' => 'Book not available']);
    exit();
}

// Start transaction
$db->beginTransaction();

try {
    // Create transaction record
    $query = "INSERT INTO book_transactions (user_id, book_id, student_name, issue_date, due_date, status) 
              VALUES (:user_id, :book_id, :student_name, :issue_date, :due_date, 'issued')";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':user_id', $userId);
    $stmt->bindParam(':book_id', $book['book_id']);
    $stmt->bindParam(':student_name', $studentName);
    $stmt->bindParam(':issue_date', $issueDate);
    $stmt->bindParam(':due_date', $dueDate);
    $stmt->execute();
    
    $transactionId = $db->lastInsertId();
    
    // Decrease available copies
    $query = "UPDATE books SET available_copies = available_copies - 1 WHERE book_id = :book_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':book_id', $book['book_id']);
    $stmt->execute();
    
    $db->commit();
    
    echo json_encode([
        'success' => true,
        'message' => 'Book issued successfully',
        'transaction_id' => $transactionId
    ]);
} catch (Exception $e) {
    $db->rollBack();
    echo json_encode(['success' => false, 'message' => 'Failed to issue book']);
}
?>
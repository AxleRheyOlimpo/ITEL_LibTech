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

$transactionId = $_POST['transaction_id'] ?? 0;

$database = new Database();
$db = $database->getConnection();

// Start transaction
$db->beginTransaction();

try {
    // Get transaction details
    $query = "SELECT book_id FROM book_transactions WHERE transaction_id = :id AND status = 'issued'";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $transactionId);
    $stmt->execute();
    
    if ($stmt->rowCount() === 0) {
        throw new Exception('Transaction not found or already returned');
    }
    
    $transaction = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Update transaction
    $query = "UPDATE book_transactions SET status = 'returned', return_date = CURDATE() 
              WHERE transaction_id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $transactionId);
    $stmt->execute();
    
    // Increase available copies
    $query = "UPDATE books SET available_copies = available_copies + 1 WHERE book_id = :book_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':book_id', $transaction['book_id']);
    $stmt->execute();
    
    $db->commit();
    
    echo json_encode(['success' => true, 'message' => 'Book returned successfully']);
} catch (Exception $e) {
    $db->rollBack();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit();
}

$database = new Database();
$db = $database->getConnection();
$userId = $_SESSION['user_id'];

// Get total available books
$query = "SELECT SUM(available_copies) as total FROM books";
$stmt = $db->prepare($query);
$stmt->execute();
$availableBooks = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

// Get books checked out by this user
$query = "SELECT COUNT(*) as total FROM book_transactions 
          WHERE user_id = :user_id AND status = 'issued'";
$stmt = $db->prepare($query);
$stmt->bindParam(':user_id', $userId);
$stmt->execute();
$checkedOut = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

// Get books returned by this user
$query = "SELECT COUNT(*) as total FROM book_transactions 
          WHERE user_id = :user_id AND status = 'returned'";
$stmt = $db->prepare($query);
$stmt->bindParam(':user_id', $userId);
$stmt->execute();
$returned = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

// Get user info
$user = getCurrentUser();

echo json_encode([
    'success' => true,
    'data' => [
        'availableBooks' => $availableBooks,
        'checkedOut' => $checkedOut,
        'returned' => $returned,
        'user' => $user
    ]
]);
?>
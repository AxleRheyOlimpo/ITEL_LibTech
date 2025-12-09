<?php
// api/get_transactions.php
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

$type = $_GET['type'] ?? 'all'; // all, issued, returned

$whereClause = "WHERE bt.user_id = :user_id";
if ($type === 'issued') {
    $whereClause .= " AND bt.status = 'issued'";
} elseif ($type === 'returned') {
    $whereClause .= " AND bt.status = 'returned'";
}

$query = "SELECT 
            bt.transaction_id,
            bt.student_name,
            bt.issue_date,
            bt.due_date,
            bt.return_date,
            bt.status,
            b.title as book_title,
            b.author as book_author
          FROM book_transactions bt
          JOIN books b ON bt.book_id = b.book_id
          $whereClause
          ORDER BY bt.created_at DESC
          LIMIT 50";

$stmt = $db->prepare($query);
$stmt->bindParam(':user_id', $userId);
$stmt->execute();

$transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    'success' => true,
    'transactions' => $transactions
]);
?>
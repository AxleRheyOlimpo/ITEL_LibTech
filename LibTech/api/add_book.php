<?php
// ========================================
// api/add_book.php
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

$title = trim($_POST['title'] ?? '');
$author = trim($_POST['author'] ?? '');
$isbn = trim($_POST['isbn'] ?? '');
$totalCopies = intval($_POST['total_copies'] ?? 1);
$availableCopies = intval($_POST['available_copies'] ?? 1);

if (empty($title) || empty($author)) {
    echo json_encode(['success' => false, 'message' => 'Title and author are required']);
    exit();
}

$database = new Database();
$db = $database->getConnection();

$query = "INSERT INTO books (title, author, isbn, total_copies, available_copies) 
          VALUES (:title, :author, :isbn, :total_copies, :available_copies)";
$stmt = $db->prepare($query);
$stmt->bindParam(':title', $title);
$stmt->bindParam(':author', $author);
$stmt->bindParam(':isbn', $isbn);
$stmt->bindParam(':total_copies', $totalCopies);
$stmt->bindParam(':available_copies', $availableCopies);

if ($stmt->execute()) {
    echo json_encode([
        'success' => true,
        'message' => 'Book added successfully',
        'book_id' => $db->lastInsertId()
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to add book']);
}

?>
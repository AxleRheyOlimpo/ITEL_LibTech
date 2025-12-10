<?php
// ========================================
// api/get_books.php
// ========================================
require_once __DIR__ . '/../config/database.php';

header('Content-Type: application/json');

$database = new Database();
$db = $database->getConnection();

$query = "SELECT book_id, title, author, isbn, cover_image, total_copies, available_copies 
          FROM books ORDER BY title ASC";
$stmt = $db->prepare($query);
$stmt->execute();

$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    'success' => true,
    'books' => $books
]);
?>
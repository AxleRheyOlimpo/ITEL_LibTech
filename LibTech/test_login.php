<?php
require_once 'config/database.php';

$username = "Axle429";
$password_to_test = "your_password_here"; // Put the actual password you're trying

$database = new Database();
$db = $database->getConnection();

$query = "SELECT user_id, username, password FROM users WHERE username = :username";
$stmt = $db->prepare($query);
$stmt->bindParam(':username', $username);
$stmt->execute();

if ($stmt->rowCount() === 0) {
    echo "User '$username' NOT FOUND in database<br>";
} else {
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "User found!<br>";
    echo "Username: " . $user['username'] . "<br>";
    echo "Password hash: " . $user['password'] . "<br><br>";
    
    if (password_verify($password_to_test, $user['password'])) {
        echo "✓ Password is CORRECT!";
    } else {
        echo "✗ Password is WRONG!";
    }
}
?>
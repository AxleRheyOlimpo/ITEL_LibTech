<?php
require_once 'config/database.php';

$username = "Axle429";
$new_password = "Axlerhey07"; // Your actual password

$hashed = password_hash($new_password, PASSWORD_DEFAULT);

$database = new Database();
$db = $database->getConnection();

$query = "UPDATE users SET password = :password WHERE username = :username";
$stmt = $db->prepare($query);
$stmt->bindParam(':password', $hashed);
$stmt->bindParam(':username', $username);

if ($stmt->execute()) {
    echo "Password updated successfully! You can now login with username: Axle429 and password: Axlerhey07";
} else {
    echo "Failed to update password.";
}
?>
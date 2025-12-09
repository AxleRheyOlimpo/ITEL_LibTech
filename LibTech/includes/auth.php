<?php
// includes/auth.php
session_start();
require_once __DIR__ . '/../config/database.php';

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Get current user data
function getCurrentUser() {
    if (!isLoggedIn()) {
        return null;
    }
    
    $database = new Database();
    $db = $database->getConnection();
    
    $query = "SELECT user_id, username, email, first_name, last_name FROM users WHERE user_id = :user_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':user_id', $_SESSION['user_id']);
    $stmt->execute();
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Require login - redirect if not logged in
function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: LoginPage.php");
        exit();
    }
}

// Check remember me token
function checkRememberMe() {
    if (isset($_COOKIE['remember_token']) && !isLoggedIn()) {
        $database = new Database();
        $db = $database->getConnection();
        
        $query = "SELECT rt.user_id FROM remember_tokens rt 
                  WHERE rt.token = :token AND rt.expires_at > NOW()";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':token', $_COOKIE['remember_token']);
        $stmt->execute();
        
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $_SESSION['user_id'] = $row['user_id'];
            return true;
        } else {
            // Token expired or invalid
            setcookie('remember_token', '', time() - 3600, '/');
        }
    }
    return false;
}

// Logout function
function logout() {
    // Remove remember me token if exists
    if (isset($_COOKIE['remember_token'])) {
        $database = new Database();
        $db = $database->getConnection();
        
        $query = "DELETE FROM remember_tokens WHERE token = :token";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':token', $_COOKIE['remember_token']);
        $stmt->execute();
        
        setcookie('remember_token', '', time() - 3600, '/');
    }
    
    // Destroy session
    session_unset();
    session_destroy();
    
    header("Location: ../LoginPage.php");
    exit();
}

// Generate random token
function generateToken($length = 32) {
    return bin2hex(random_bytes($length));
}
?>
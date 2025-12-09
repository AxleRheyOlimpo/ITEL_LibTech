<?php
// api/forgot_password.php
require_once __DIR__ . '/../config/database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit();
}

$email = trim($_POST['email'] ?? '');

if (empty($email)) {
    echo json_encode(['success' => false, 'message' => 'Email is required']);
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email format']);
    exit();
}

$database = new Database();
$db = $database->getConnection();

// Check if email exists
$query = "SELECT user_id, username FROM users WHERE email = :email";
$stmt = $db->prepare($query);
$stmt->bindParam(':email', $email);
$stmt->execute();

if ($stmt->rowCount() === 0) {
    // For security, don't reveal if email exists or not
    echo json_encode(['success' => true, 'message' => 'If the email exists, a reset code will be sent']);
    exit();
}

$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Generate 6-digit code
$code = sprintf("%06d", mt_rand(0, 999999));
$expires = date('Y-m-d H:i:s', strtotime('+15 minutes'));

// Delete old tokens for this email
$query = "DELETE FROM password_reset_tokens WHERE email = :email";
$stmt = $db->prepare($query);
$stmt->bindParam(':email', $email);
$stmt->execute();

// Store new token
$query = "INSERT INTO password_reset_tokens (email, token, expires_at) VALUES (:email, :token, :expires_at)";
$stmt = $db->prepare($query);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':token', $code);
$stmt->bindParam(':expires_at', $expires);
$stmt->execute();

// Send email via Brevo
$brevoApiKey = 'YOUR_BREVO_API_KEY'; // Replace with your actual Brevo API key
$url = 'https://api.brevo.com/v3/smtp/email';

$data = [
    'sender' => [
        'name' => 'LibTech',
        'email' => 'noreply@libtech.com' // Replace with your verified sender email
    ],
    'to' => [
        ['email' => $email, 'name' => $user['username']]
    ],
    'subject' => 'LibTech - Password Reset Code',
    'htmlContent' => "
        <html>
        <body style='font-family: Arial, sans-serif; padding: 20px;'>
            <h2 style='color: #1f5c70;'>Password Reset Request</h2>
            <p>Hello {$user['username']},</p>
            <p>You requested to reset your password for your LibTech account.</p>
            <p>Your password reset code is:</p>
            <h1 style='background: #f0f0f0; padding: 15px; text-align: center; letter-spacing: 5px;'>{$code}</h1>
            <p>This code will expire in 15 minutes.</p>
            <p>If you didn't request this, please ignore this email.</p>
            <br>
            <p>Best regards,<br>LibTech Team</p>
        </body>
        </html>
    "
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'accept: application/json',
    'api-key: ' . $brevoApiKey,
    'content-type: application/json'
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 201) {
    echo json_encode(['success' => true, 'message' => 'Reset code sent to your email']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to send email. Please try again later.']);
}
?>
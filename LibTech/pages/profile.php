<?php /* pages/profile.php */ ?>
<?php
require_once '../includes/auth.php';
requireLogin();
$user = getCurrentUser();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Profile - LibTech</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../CSS/Dashboard.css">
  <style>
    .profile-container {
      max-width: 800px;
      margin: 50px auto;
      padding: 40px;
      background: white;
      border-radius: 12px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .profile-header {
      text-align: center;
      margin-bottom: 40px;
    }
    .profile-avatar-large {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      background: linear-gradient(135deg, #1f5c70 0%, #2a7a92 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 48px;
      font-weight: 700;
      margin: 0 auto 20px;
      box-shadow: 0 4px 15px rgba(31, 92, 112, 0.3);
    }
    .profile-info {
      margin-top: 30px;
    }
    .info-row {
      display: flex;
      padding: 15px;
      border-bottom: 1px solid #eee;
    }
    .info-label {
      font-weight: 600;
      color: #1f5c70;
      width: 150px;
    }
    .info-value {
      color: #333;
    }
    .back-btn {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 20px;
      background: #1f5c70;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      transition: 0.3s;
    }
    .back-btn:hover {
      background: #2a7a92;
    }
  </style>
</head>
<body>
  <header style="padding: 15px 80px; background: white; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
    <div style="display: flex; align-items: center; gap: 10px;">
      <img src="../IMAGES/BGBGBG.png" alt="LibTech Logo" style="height: 80px;">
      <h1 style="color: #1f5c70; font-size: 28px;">LibTech</h1>
    </div>
  </header>

  <div class="profile-container">
    <div class="profile-header">
      <div class="profile-avatar-large">
        <?php echo strtoupper(substr($user['first_name'], 0, 1)); ?>
      </div>
      <h1 style="color: #1f5c70; margin-bottom: 5px;">My Profile</h1>
      <p style="color: #666;">Your account information</p>
    </div>

    <div class="profile-info">
      <div class="info-row">
        <div class="info-label">Username:</div>
        <div class="info-value"><?php echo htmlspecialchars($user['username']); ?></div>
      </div>
      <div class="info-row">
        <div class="info-label">Email:</div>
        <div class="info-value"><?php echo htmlspecialchars($user['email']); ?></div>
      </div>
      <div class="info-row">
        <div class="info-label">First Name:</div>
        <div class="info-value"><?php echo htmlspecialchars($user['first_name']); ?></div>
      </div>
      <div class="info-row">
        <div class="info-label">Last Name:</div>
        <div class="info-value"><?php echo htmlspecialchars($user['last_name']); ?></div>
      </div>
      <div class="info-row">
        <div class="info-label">Member Since:</div>
        <div class="info-value">
          <?php 
          $database = new Database();
          $db = $database->getConnection();
          $query = "SELECT created_at FROM users WHERE user_id = :id";
          $stmt = $db->prepare($query);
          $stmt->bindParam(':id', $user['user_id']);
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
          echo date('F d, Y', strtotime($result['created_at']));
          ?>
        </div>
      </div>
    </div>

    <a href="../Dashboard.php" class="back-btn">← Back to Dashboard</a>
  </div>
</body>
</html>
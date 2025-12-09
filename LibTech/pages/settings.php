<!-- ================================== -->
<!-- pages/settings.php -->
<!-- ================================== -->
<?php /* pages/settings.php */ ?>
<?php
require_once '../includes/auth.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Settings - LibTech</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../CSS/Dashboard.css">
  <style>
    .settings-container {
      max-width: 800px;
      margin: 50px auto;
      padding: 40px;
      background: white;
      border-radius: 12px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      text-align: center;
    }
    .settings-icon {
      font-size: 64px;
      margin-bottom: 20px;
    }
    .back-btn {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 20px;
      background: #1f5c70;
      color: white;
      text-decoration: none;
      border-radius: 5px;
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

  <div class="settings-container">
    <div class="settings-icon">⚙️</div>
    <h1 style="color: #1f5c70; margin-bottom: 15px;">Settings</h1>
    <p style="color: #666; margin-bottom: 30px;">
      Settings page is under construction.<br>
      This will include preferences, notifications, and account management options.
    </p>
    <a href="../Dashboard.php" class="back-btn">← Back to Dashboard</a>
  </div>
</body>
</html>
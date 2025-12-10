<?php
require_once 'includes/auth.php';
checkRememberMe();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LibTech | About Us</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }

    body {
      background-color: #fff;
      color: #333;
    }

    /* Hero Section */
    .hero {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 50px 80px 40px;
      background: #f5fcff;
      flex-wrap: wrap;
    }

    .hero-text {
      flex: 1;
      margin-left: 50px;
      min-width: 300px;
      max-width: 500px;
    }

    .hero-text h2 {
      font-size: 42px;
      color: #1f5c70;
      margin-bottom: 15px;
    }

    .hero-text p {
      font-size: 16px;
      color: #444;
      line-height: 1.6;
      margin-bottom: 25px;
    }

    .hero img {
      flex: 1;
      margin-right: 40px;
      max-width: 600px;
      height: auto;
      object-fit: contain;
    }

    /* Mission & Vision Cards */
    .mission-vision {
      display: flex;
      gap: 30px;
      justify-content: center;
      flex-wrap: wrap;
      padding: 50px 8%;
    }

    .mission-vision .card {
      background-color: #1f5c70;
      color: #fff;
      padding: 30px;
      border-radius: 15px;
      max-width: 300px;
      text-align: center;
      box-shadow: 0 6px 15px rgba(0,0,0,0.1);
      transition: transform 0.3s;
    }

    .mission-vision .card:hover {
      transform: translateY(-10px);
    }

    .mission-vision .card h3 {
      margin-bottom: 15px;
      font-size: 22px;
    }

    .mission-vision .card p {
      font-size: 15px;
      line-height: 1.6;
    }

    /* Team Section */
    .team {
      padding: 60px 8%;
      text-align: center;
    }

    .team h3 {
      font-size: 28px;
      color: #1f5c70;
      margin-bottom: 10px;
    }

    .team-desc {
      font-size: 13px;
      color: #555;
      margin-bottom: 50px;
      max-width: 800px;
      margin-left: auto;
      margin-right: auto;
      line-height: 1.6;
    }

    .team-grid {
      display: flex;
      justify-content: center;
      gap: 20px;
      flex-wrap: wrap;
    }

    .team-member {
      text-align: center;
      flex: 1 1 200px;
      max-width: 220px;
    }

    .team-member img {
      width: 220px;
      height: 220px;
      border-radius: 12px;
      object-fit: cover;
      margin-bottom: 10px;
      transition: transform 0.3s;
    }

    .team-member img:hover {
      transform: scale(1.03);
    }

    .team-member h4 {
      font-size: 18px;
      color: #1f5c70;
      margin-bottom: 5px;
    }

    .team-member p {
      font-size: 14px;
      color: #555;
      margin: 0 0 10px 0;
    }

    .team-socials {
      display: flex;
      justify-content: center;
      gap: 8px;
      margin-bottom: 10px;
    }

    .team-socials a img {
      width: 22px;
      height: 22px;
      object-fit: contain;
      filter: grayscale(100%);
      transition: transform 0.3s, filter 0.3s;
    }

    .team-socials a:hover img {
      transform: scale(1.2);
      filter: grayscale(0%);
    }

    /* Footer */
    footer {
      background: #1f5c70;
      color: #fff;
      padding: 30px 80px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 15px;
    }

    .footer-links {
      display: flex;
      gap: 15px;
      flex-wrap: wrap;
    }

    .footer-links a {
      color: #fff;
      text-decoration: none;
      transition: 0.3s;
    }

    .footer-links a:hover {
      text-decoration: underline;
    }

    @media (max-width: 900px) {
      .hero {
        flex-direction: column;
        text-align: center;
        padding: 50px 20px;
      }

      .hero img {
        width: 450px;
        height: auto;
      }

      footer {
        flex-direction: column;
        text-align: center;
        gap: 15px;
      }
    }

    @media (max-width: 480px) {
      .team-grid {
        flex-direction: column;
        align-items: center;
        gap: 25px;
      }

      .team-member img {
        width: 150px;
        height: 150px;
      }
    }
  </style>
</head>

<body>

<?php include 'includes/header.php'; ?>

<!-- Hero Section -->
<section class="hero">
  <div class="hero-text">
    <h2>About Us</h2>
    <p>LibTech is a modern library management system built to simplify and automate everyday library operations. We aim to make book organization, borrower management, and transaction tracking more efficient through smart and user-friendly technology.</p>
    <p>With LibTech, librarians can easily record new books, manage borrower information, issue and return books, and monitor all activities through a centralized dashboard. Designed for convenience and reliability, it ensures accuracy and saves valuable time.</p>
    <p>Our mission is to empower libraries through innovation, connecting people with knowledge in a faster and more efficient way. Whether for schools, institutions, or community libraries, LibTech is your partner in building a smarter digital library.</p>
  </div>
  <img src="IMAGES/About Us.png" alt="Library Illustration">
</section>

<!-- Mission & Vision -->
<section class="mission-vision">
  <div class="card">
    <h3>Our Mission</h3>
    <p>To empower libraries and librarians through innovative and user-friendly technology, making information accessible to everyone.</p>
  </div>
  <div class="card">
    <h3>Our Vision</h3>
    <p>To create smarter, more efficient digital libraries that inspire learning, creativity, and exploration for all communities.</p>
  </div>
</section>

<!-- Team Section -->
<section class="team">
  <h3>Meet Our Team</h3>
  <p class="team-desc">Meet the students behind LibTech! We love coding, designing, and finding creative ways to make library management simple and efficient.</p>
  <div class="team-grid">

    <div class="team-member">
      <img src="IMAGES/jaron.jpg" alt="Jaron Altares">
      <h4>Jaron Altares</h4>
      <p>Member</p>
      <div class="team-socials">
        <a href="https://www.facebook.com/jrn.altares" target="_blank"><img src="IMAGES/FB logo.png" alt="Facebook"></a>
        <a href="#" target="_blank"><img src="IMAGES/IG logo.png" alt="Instagram"></a>
        <a href="#" target="_blank"><img src="IMAGES/X or twitter logo.png" alt="Twitter"></a>
      </div>
    </div>

    <div class="team-member">
      <img src="IMAGES/fred.jpg" alt="Fredrick Sapinoro">
      <h4>Fredrick Sapinoro</h4>
      <p>Member</p>
      <div class="team-socials">
        <a href="https://www.facebook.com/fredrick.sapinoro.96" target="_blank"><img src="IMAGES/FB logo.png" alt="Facebook"></a>
        <a href="#" target="_blank"><img src="IMAGES/IG logo.png" alt="Instagram"></a>
        <a href="#" target="_blank"><img src="IMAGES/X or twitter logo.png" alt="Twitter"></a>
      </div>
    </div>

    <div class="team-member">
      <img src="IMAGES/clark.jpg" alt="Clark">
      <h4>Clark</h4>
      <p>Member</p>
      <div class="team-socials">
        <a href="https://www.facebook.com/clarkangel.deleon.19" target="_blank"><img src="IMAGES/FB logo.png" alt="Facebook"></a>
        <a href="#" target="_blank"><img src="IMAGES/IG logo.png" alt="Instagram"></a>
        <a href="#" target="_blank"><img src="IMAGES/X or twitter logo.png" alt="Twitter"></a>
      </div>
    </div>

    <div class="team-member">
      <img src="IMAGES/Axle1.jpg" alt="Axle Olimpo">
      <h4>Axle Olimpo</h4>
      <p>Member</p>
      <div class="team-socials">
        <a href="https://www.facebook.com/xelrei" target="_blank"><img src="IMAGES/FB logo.png" alt="Facebook"></a>
        <a href="#" target="_blank"><img src="IMAGES/IG logo.png" alt="Instagram"></a>
        <a href="#" target="_blank"><img src="IMAGES/X or twitter logo.png" alt="Twitter"></a>
      </div>
    </div>

  </div>
</section>

<!-- Footer -->
<footer>
  <div class="footer-left">© 2025 LibTech | All Rights Reserved</div>
  <div class="footer-links">
    <a href="DiscoverBooks.php">Discover</a>
    <a href="AboutUs.php">About Us</a>
    <a href="Dashboard.php">Account</a>
  </div>
</footer>

</body>
</html>

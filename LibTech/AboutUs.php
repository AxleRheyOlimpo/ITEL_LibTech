<?php
require_once 'includes/auth.php';
checkRememberMe(); // Auto-login if remember me token exists
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LibTech | Home</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="CSS/AboutUs.css">
</head>

<body class="about-page">


<hr id="thckoutline">


<!--=================== Hero Section ===================-->
  <section class="hero">
    <div class="hero-text">
      <h2>About Us</h2>
      <p>LibTech is a modern library management system built to simplify and automate everyday library operations. We aim to make book organization, borrower management, and transaction tracking more efficient through smart and user-friendly technology.</p>
      <p>With LibTech, librarians can easily record new books, manage borrower information, issue and return books, and monitor all activities through a centralized dashboard. Designed for convenience and reliability, it ensures accuracy and saves valuable time.</p>
      <p>Our mission is to empower libraries through innovation, connecting people with knowledge in a faster and more efficient way. Whether for schools, institutions, or community libraries, LibTech is your partner in building a smarter digital library.</p>
    </div>
    <img src="IMAGES/About Us.png" alt="Library Illustration">
  </section>

  <!-- ===================Mission & Vision ======================================-->
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


  <!-- ===================Team Section====================================== -->
 
<section class="team">
  <h3>Meet Our Team</h3>
   <p class="team-desc">Meet the students behind LibTech! We love coding, designing, and finding creative ways to make library management simple and efficient.</p>
  <div class="team-grid">

    <!-- Member 1 -->
    <div class="team-member">
      <img src="IMAGES/jaron.jpg" alt="Jaron Altares">
      <h4>Jaron Altares</h4>
      <p>member</p>
      <div class="team-socials">
        <a href="#" target="_blank"><img src="IMAGES/FB logo.png" alt="Facebook"></a>
        <a href="#" target="_blank"><img src="IMAGES/IG logo.png" alt="Instagram"></a>
        <a href="#" target="_blank"><img src="IMAGES/X or twitter logo.png" alt="Twitter"></a>
      </div>
    </div>

    <!-- Member 2 -->
    <div class="team-member">
      <img src="IMAGES/fred.jpg" alt="Fredrick Sapinor">
      <h4>Fredrick Sapinoro</h4>
      <p>member</p>
      <div class="team-socials">
        <a href="#" target="_blank"><img src="IMAGES/FB logo.png" alt="Facebook"></a>
        <a href="#" target="_blank"><img src="IMAGES/IG logo.png" alt="Instagram"></a>
        <a href="#" target="_blank"><img src="IMAGES/X or twitter logo.png" alt="Twitter"></a>
      </div>
    </div>

    <!-- Member 3 -->
    <div class="team-member">
      <img src="IMAGES/clark.jpg" alt="Clark ">
      <h4>Clark </h4>
      <p>member</p>
      <div class="team-socials">
        <a href="#" target="_blank"><img src="IMAGES/FB logo.png" alt="Facebook"></a>
        <a href="#" target="_blank"><img src="IMAGES/IG logo.png" alt="Instagram"></a>
        <a href="#" target="_blank"><img src="IMAGES/X or twitter logo.png" alt="Twitter"></a>
      </div>
    </div>

    <!-- Member 4 -->
    <div class="team-member">
      <img src="IMAGES/axle.jpg" alt="Axle Olimpo">
      <h4>Axle Olimpo</h4>
      <p>member</p>
      <div class="team-socials">
        <a href="#" target="_blank"><img src="IMAGES/FB logo.png" alt="Facebook"></a>
        <a href="#" target="_blank"><img src="IMAGES/IG logo.png" alt="Instagram"></a>
        <a href="#" target="_blank"><img src="IMAGES/X or twitter logo.png" alt="Twitter"></a>
      </div>
    </div>

  </div>
</section>


  <!-- =================== Footer ====================================== -->

  <footer>
    <div class="footer-left">
      © 2025 LibTech | All Rights Reserved
    </div>

    <div class="footer-links">
      <a href="BookEntry.php">Discover</a>
      <a href="AboutUs.php">About Us</a>
      <a href="Dashboard.php">Account</a>
    </div>

    <div class="socials">
      <a href="https://youtu.be/dQw4w9WgXcQ?si=UZ_sGkBnUkLYToFJ" target="_blank" class="social-btn facebook" aria-label="Facebook">
        <img src="IMAGES/FB logo.png" alt="Facebook Logo">
      </a>
      <a href="https://youtu.be/dQw4w9WgXcQ?si=UZ_sGkBnUkLYToFJ" target="_blank" class="social-btn google" aria-label="Google">
        <img src="IMAGES/IG logo.png" alt="Google Logo">
      </a>
      <a href="https://youtu.be/dQw4w9WgXcQ?si=UZ_sGkBnUkLYToFJ" target="_blank" class="social-btn twitter" aria-label="Twitter">
        <img src="IMAGES/X or twitter logo.png" alt="Twitter Logo">
      </a>
    </div>
  </footer>



</body>
</html>
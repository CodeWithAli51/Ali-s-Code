<?php 
require('connection.php'); 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style1.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <section class="header">
        <nav>
          <a href="index.html"><img src="logo4.png" alt="Logo"></a>
           <div class="nav-links">
             <ul>
                <li><a href="index.php">HOME</a></li>
                <li><a href="#footer">ABOUT</a></li>
                <li class="dropdown">
                  <a href="#" class="dropbtn">COURSES</a> <!-- Main Dropdown -->
                  <div class="dropdown-content">
                    <!-- Microsoft Office -->
                    <div class="nested-dropdown">
                      <a href="#">Microsoft Office</a> <!-- Category -->
                      <div class="nested-dropdown-content">
                        <a href="#" onclick="onClickShow()">Word</a> <!-- Subcategory -->
                        <a href="#" onclick="onClickShow()">Excel</a>
                        <a href="#" onclick="onClickShow()">Advanced Excel</a>
                        <a href="#" onclick="onClickShow()">PowerPoint</a>
                      </div>
                    </div>
                
                    <!-- Web Development -->
                    <div class="nested-dropdown">
                      <a href="#">Web Development</a> <!-- Category -->
                      <div class="nested-dropdown-content">
                        <a href="#" onclick="onClickShow()">HTML & CSS</a> <!-- Subcategory -->
                        <a href="#" onclick="onClickShow()">JavaScript</a>
                        <a href="#" onclick="onClickShow()">Bootstrap</a>
                      </div>
                    </div>
                
                    <!-- App Development -->
    <div class="nested-dropdown">
      <a href="#">App Development</a>
      <div class="nested-dropdown-content">
        <a href="#" onclick="onClickShow()">Kotlin</a>
        <a href="#" onclick="onClickShow()">Java</a>
        <a href="#" onclick="onClickShow()">Swift</a>
      </div>
    </div>

    <!-- Data Analysis -->
    <div class="nested-dropdown">
      <a href="#">Data Analysis</a>
      <div class="nested-dropdown-content">
        <a href="#" onclick="onClickShow()">Python</a>
        <a href="#" onclick="onClickShow()">R</a>
      </div>
    </div>

    <!-- Backend Languages -->
    <div class="nested-dropdown">
      <a href="#">Backend Languages</a>
      <div class="nested-dropdown-content">
        <a href="#" onclick="onClickShow()">Python</a>
        <a href="#" onclick="onClickShow()">Java</a>
        <a href="#" onclick="onClickShow()">C++</a>
        <a href="#" onclick="onClickShow()">JavaScript</a>
        <a href="#" onclick="onClickShow()">PHP</a>
        <a href="#" onclick="onClickShow()">Ruby</a>
        <a href="#" onclick="onClickShow()">C#/.NET</a>
      </div>
    </div>

    <!-- DSA -->
    <a href="#" onclick="onClickShow()">DSA</a>

    <!-- DBMS -->
    <div class="nested-dropdown">
      <a href="#">DBMS</a>
      <div class="nested-dropdown-content">
        <a href="#" onclick="onClickShow()">SQL</a>
        <a href="#" onclick="onClickShow()">MySQL</a>
        <a href="#" onclick="onClickShow()">PostgreSQL</a>
        <a href="#" onclick="onClickShow()">Oracle</a>
                  </div>
                </li>
                <li><a href="#" onclick="onClickShow()">FACULTY</a></li>
             </ul>
           </div>
           <div class="auth-buttons">
            <a href="login.html"><button class="login">Login</button></a>
            <a href="register.html"><button class="register">Register</button></a>
           </div>
        </nav>
    </section>

    <main>
      <section id="about" class="tagline">
      </section>
        <section class="content">
          <div class="content-left">
            <img src="sidepic.png" alt="Website Preview">
          </div>
          <div class="content-right">
            <h1>About Us!</h1>
            <p>At Tech Astra, we are dedicated to empowering aspiring tech enthusiasts and professionals by providing cutting-edge courses, expert guidance, and a vibrant community of learners. Whether you're taking your first steps into the world of IT or aiming to advance your skills, Tech Astra is your trusted partner in achieving your dreams. Explore opportunities, unlock your potential, and shape your future in the dynamic field of technology with us.</p>
          </div>
        </section>
      </main>      
      <footer class="footer-bar" id="footer">
        <div class="footer-content">
          <p>Contact us: <a href="mailto:teamtechashtra@hmail.com">teamtechastra@gmail.com</a></p>
          <p><a href="terms.html">Terms & Conditions</a></p>
          <p>© 2025 Tech Astra | All Rights Reserved</p>
        </div>
      </footer>      
</body>
<script>
  function onClickShow() {
      alert('Please login or register to access this feature.');
  }
</script>
</html>
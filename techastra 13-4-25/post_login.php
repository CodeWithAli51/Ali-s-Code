<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location:login.html");
    exit();
}
?>
<!DOCTYPE html><html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechAstra</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* General Styles */
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background-image: url('Image.jpg');
            color: white;
            text-align: center;
        }/* Navbar */
    .navbar {
        display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 6%;
    background: rgb(0, 7, 20);
    box-shadow: 0 4px 8px rgba(75, 73, 73, 0.5);
    position: sticky;
    top: 0;
    z-index: 1000;
    }

    /* Navigation Menu */
    .nav-menu {
        display: flex;
        gap: 25px;
    }

    .nav-menu a {
        color: white;
        text-decoration: none;
        font-size: 16px;
        font-weight: 600;
        transition: color 0.3s;
    }

    .nav-menu a:hover {
        color: #4d5b9b;
    }

    .nav-menu ::after {
    content: '';
    width: 0;
    height: 2px;
    background: #5e64a1;
    display: block;
    margin: auto;
    transition: width 0.3s;
    }

    .nav-menu :hover::after {
    width: 100%;
    }

    /* Profile Section */
    .profile {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: 10px;
        margin-right: 20px;
    }

    .profile img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 2px solid white;
        object-fit: cover;
        cursor: pointer;
    }
    /* Clickable Buttons and Links */
    .nav-menu a, {
        cursor: pointer;
    }

    .nav-menu a:hover {
    }

    /* Header Section */
    .header {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 40vh;
        margin-top: 80px; /* Adjusted for navbar */
    }

    .logo img {
        max-width: 280px;
        animation: fadeIn 1.5s ease-in-out;
    }

    /* Tagline Styling */
    .tagline {
        font-size: 22px;
        font-weight: 600;
        margin-top: 10px;
        color: #00d4ff;
        text-shadow: 2px 2px 10px rgba(0, 212, 255, 0.5);
    }

    .tagline span {
        color: #ffffff;
        font-weight: 700;
    }

    /* Content Section */
    .content {
        margin: 20px auto;
        width: 75%;
        font-size: 18px;
        line-height: 1.6;
        text-shadow: 2px 2px 10px rgba(255, 255, 255, 0.3);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .navbar {
            flex-direction: column;
            gap: 10px;
            padding: 15px;
        }

        .nav-menu {
            flex-direction: column;
            text-align: center;
            gap: 10px;
        }
    }

    /* Keyframe Animation */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    .block {
    margin: 20px auto;
    width: 50%;
    text-align: center;
}

.toggle-btn {
    width: 100%;
    padding: 10px;
    background-color: black;
    color: white;
    border: none;
    font-size: 18px;
    cursor: pointer;
}

.sub-blocks {
    display: none;
    background: rgba(0, 0, 0, 0.8);
    padding: 10px;
}

.sub-blocks a {
    display: block;
    padding: 5px;
    color: #00d4ff;
    text-decoration: none;
}

.sub-blocks a:hover {
    text-decoration: underline;
}
</style>
<!-- Font Awesome for Search Icon -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

</head>
<body><!-- Top Navbar -->
<div class="navbar">
    <div class="nav-menu">
        <a href="#">Home</a>
        <a href="#">About</a>
        <a href="privacy.html">Policy</a>
        <a href="mailto:teamtechashtra@hmail.com">Contact Us</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="profile">
        <img src='profile icon.jpeg' alt="Profile Image"> 
    </div>
</div>

<!-- Header Section -->
<div class="header">
    <div class="logo">
        <img src="logo4 (1).png" alt="TechAstra Logo">  
        <h2 class="tagline">Your Gateway To The <span>Future Technology</span></h2>
    </div>
</div>

<!-- Content Section -->
<div class="content">
    <p>Tech Astra is an online platform that helps beginners learn coding from scratch with interactive tutorials, video lessons, and coding challenges. It covers a wide range of topics, including web development, programming languages, and data science. The platform also provides video lectures from popular YouTubers, offering insights and tips for mastering coding concepts and improving skills.

        The website focuses on hands-on learning with real-time coding environments where users can write, test, and debug their code. You’ll also find ideas for projects to practice and build your portfolio. As you progress, Tech Astra guides you toward practical applications, such as job opportunities that align with the programming languages you learn. For example, mastering JavaScript and React can help you land web developer roles at companies like Google or Facebook, while Python and data science skills open doors for data analyst positions in firms like Amazon or Netflix.
        
        Tech Astra also fosters a supportive community where you can interact with fellow learners, ask questions, and share your progress. With personalized learning paths and access to valuable resources, this platform helps you gain the skills needed for real-world tech jobs and stay ahead in a competitive job market.</p>
</div>

<!-- Microsoft Office Block -->
<div class="block">
<button class="toggle-btn" onclick="toggleBlock('subBlocks1')">Microsoft Office</button>
    <div class="sub-blocks" id="subBlocks1">
        <a href="#">Word</a>
        <a href="#">Excel</a>
        <a href="#">Advanced Excel</a>
        <a href="#">PowerPoint</a>
    </div>
</div>

<!-- App Development Block -->
<div class="block">
<button class="toggle-btn" onclick="toggleBlock('subBlocks2')">App Development</button>
    <div class="sub-blocks" id="subBlocks2">
        <a href="/techastraa/appdevelopment/kotlin.html" target="_blank">Kotlin</a>
        <a href="#" target="_blank">Java</a>
        <a href="/techastraa/appdevelopment/swift.html" target="_blank">Swift</a>
    </div>
</div>

<!-- Web Development Block -->
<div class="block">
    <button class="toggle-btn" onclick="toggleBlock('subBlocks3')">Web Development</button>
    <div class="sub-blocks" id="subBlocks3">
        <a href="/techastraa/webdev/ht.html" target="_blank">HTML</a>
        <a href="/techastraa/webdev/css.html" target="_blank">CSS</a>
        <a href="#" target="_blank">JavaScript</a>
        <a href="/techastraa/webdev/bootstrap/bootstrap.html" target="_blank">Bootstrap</a>
    </div>
</div>
    <!-- Data Analysis Block -->
<div class="block">
    <button class="toggle-btn" onclick="toggleBlock('subBlocks4')">Data Analysis</button>
    <div class="sub-blocks" id="subBlocks4">
        <a href="/techastraa/dataanalysis/python/python.html" target="_blank">Python</a>
        <a href="/techastraa/dataanalysis/r.htm" target="_blank">R</a>
    </div>
</div>
    <!-- Backened Language Block -->
<div class="block">
    <button class="toggle-btn" onclick="toggleBlock('subBlocks5')">Back-end Languages</button>
    <div class="sub-blocks" id="subBlocks5">
        <a href="/techastraa/backend/python.htm" target="_blank">Python</a>
        <a href="/techastraa/backend/C++.htm" target="_blank">C++</a>
        <a href="/techastraa/backend/java.htm" target="_blank">Java</a>
        <a href="/techastraa/backend/javascript.htm" target="_blank">JS</a>
        <a href="/techastraa/clarisse.html" target="_blank">Php</a>
        <a href="/techastraa/clarisse.html" target="_blank">Ruby</a>
        <a href="/techastraa/clarisse.html" target="_blank">C#(.NET)</a>
    </div>
</div>
    <!-- DSA Block -->
<div class="block">
    <a href="DSA.htm" target="_blank"><button class="toggle-btn" onclick="toggleBlock('subBlocks6')">DSA</button></a>
    </div>
    <!-- Database Block -->
<div class="block">
    <button class="toggle-btn" onclick="toggleBlock('subBlocks7')">Database</button>
    <div class="sub-blocks" id="subBlocks7">
        <a href="/techastraa/clarisse.html" target="_blank">SQL</a>
        <a href="/techastraa/clarisse.html" target="_blank">MySQL</a>
        <a href="/techastraa/clarisse.html" target="_blank">PostgreSQL</a>
        <a href="/techastraa/clarisse.html" target="_blank">Oracle</a>
    </div>
</div>
<!-- Networking Block -->
<div class="block">
    <button class="toggle-btn" onclick="toggleBlock('subBlocks8')">Networking</button>
    <div class="sub-blocks" id="subBlocks8">
        <a href="/techastraa/clarisse.html" target="_blank">Cisco Packet</a>   
    </div>
</div>

</div>

<script>
    function toggleBlock(id) {
        var subBlocks = document.getElementById(id);
        if (subBlocks.style.display === "none" || subBlocks.style.display === "") {
            subBlocks.style.display = "block";
        } else {
            subBlocks.style.display = "none";
        }
    }
</script>

</body>
</html>
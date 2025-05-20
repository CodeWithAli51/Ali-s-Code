<?php
require('connection.php');
session_start();

// Registration Logic
if (isset($_POST['register'])) {
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validate password match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match'); window.location.href='register.html';</script>";
        exit();
    }

    // Check if email is already registered
    $stmt = $con->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Email already registered'); window.location.href='register.html';</script>";
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    var_dump($hashed_password); // Debugging: check hashed password

    // Insert user into the database
    $stmt = $con->prepare("INSERT INTO users (firstname, lastname, email, phone, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $firstname, $lastname, $email, $phone, $hashed_password);

    if ($stmt->execute()) {
        echo "<script>alert('Registration Successful'); window.location.href='login.html';</script>";
    } else {
        echo "<script>alert('Error during registration'); window.location.href='register.html';</script>";
    }
}
// Login Logic
if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check if user exists
    $stmt = $con->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc(); // Fetch user details

        // Debugging: Output the password entered and the password stored in the database
        echo "<pre>";
        echo "Entered Password: " . $password . "<br>";
        echo "Stored Hashed Password: " . $user['password'] . "<br>";

        // Verify password using password_verify() and compare against the stored hashed password
        $password_verified = password_verify($password, $user['password']);
        echo "Password Verified: " . ($password_verified ? 'Yes' : 'No') . "<br>";

        if ($password_verified) {
            // Set session variables after successful login
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $user['firstname']; // You can change this to 'username' if your database stores that

            // Redirect to the post-login page (or wherever you want)
            header("location: post_login.php");
            exit();
        } else {
            echo "<script>alert('Incorrect Password'); window.location.href='login.html';</script>";
        }
    } else {
        echo "<script>alert('Email not registered'); window.location.href='register.html';</script>";
    }
}

?>


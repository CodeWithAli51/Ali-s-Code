<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Update</title>
    <style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    text-decoration: none;
    font-family: 'Poppins', sans-serif;
}

form {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #f0f0f0;
    width: 350px;
    border-radius: 5px;
    padding: 28px 25px 30px;
    text-align: center;
}

form h3 {
    margin-bottom: 15px;
    color: #30475e;
    font-size: 18px;
    font-weight: 600;
}

.input-container {
    position: relative;
    width: 100%;
    margin-bottom: 20px;
}

.input-container input {
    width: 100%;
    background-color: transparent;
    border: none;
    border-bottom: 2px solid #30475e;
    padding: 5px 30px 5px 0;
    font-weight: 550;
    font-size: 14px;
    outline: none;
}

.toggle-password {
    position: absolute;
    right: 5px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    font-size: 16px;
    color: #30475e;
}

form button {
    font-weight: 550;
    font-size: 15px;
    color: white;
    background-color: #30475e;
    padding: 6px 15px;
    border: none;
    outline: none;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

form button:hover {
    background-color: #6c7d8c;
}
</style>

</head>
<body>
<?php 
    require("connection.php");
    if(isset($_GET['email']) && isset($_GET['reset_token'])) {
        date_default_timezone_set('Asia/Kolkata');
        $date = date("Y-m-d");
        $query = "SELECT * FROM `users` WHERE `email`='$_GET[email]' AND `resettoken`='$_GET[reset_token]' AND `resettokenexpire`='$date'";
        $result = mysqli_query($con, $query);
        if($result) {
            if(mysqli_num_rows($result) == 1) {
                echo "
                    <form method='POST'>
                        <h3>Create New Password</h3>
                        <div class='input-container'>
                            <input type='password' placeholder='New Password' name='Password' id='password'>
                            <span class='toggle-password' onclick='togglePassword()'>👁️</span>
                        </div>
                        <button type='submit' name='updatepassword'>UPDATE</button>
                        <input type='hidden' name='email' value='$_GET[email]'>
                    </form>
                ";
            } else {
                echo "
                    <script>
                        alert('Invalid Or Expired Link');
                        window.location.href='index.php';
                    </script>
                ";  
            }
        } else {
            echo "
                <script>
                    alert('Email Not Found');
                    window.location.href='index.php';
                </script>
            ";
        }
    }
?>
<?php 
   if(isset($_POST['updatepassword'])) {
      $pass = password_hash($_POST['Password'], PASSWORD_BCRYPT);
      $update = "UPDATE `registered_users` SET `password`='$pass', `resettoken`= NULL, `resettokenexpire`= NULL WHERE `email`='$_POST[email]'";
      if(mysqli_query($con, $update)) {
        echo "
            <script>
                alert('Password Updated Successfully');
                window.location.href='index.php';
            </script>
        ";
      } else {
        echo "
            <script>
                alert('Email Not Found');
                window.location.href='index.php';
            </script>
        ";
      }
   } 
?>
<script>
    function togglePassword() {
        let passwordField = document.getElementById('password');
        let toggleIcon = document.querySelector('.toggle-password');
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            toggleIcon.textContent = '🙈';
        } else {
            passwordField.type = 'password';
            toggleIcon.textContent = '👁️';
        }
    }
</script>
</body>
</html>

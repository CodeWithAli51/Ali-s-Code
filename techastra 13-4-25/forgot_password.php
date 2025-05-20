




<?php
    require("connection.php");

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    function sendMail($email,$reset_token)
    {
      require('PHPMailer/PHPMailer.php');
      require('PHPMailer/SMTP.php'); 
      require('PHPMailer/Exception.php'); 
      
      $mail = new PHPMailer(true);
       

      try {
        //Server settings
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'alishaikhemail51@gmail.com';                     //SMTP username
        $mail->Password   = 'cscx qarn cqnu zybl';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom('alishaikhemail51@gmail.com', 'TechAstra');
        $mail->addAddress($email);     //Add a recipient
       
    
        
    
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Password Reset Link From TechAstra';
        $mail->Body    = "We got a request from you to reset your password! <br>
            Click the link below: <br>
            <a href='http://localhost/Sumehra_s Hardwork/updatepassword.php?email=$email&reset_token=$reset_token'>Reset Password 
            </a>";
        
    
        $mail->send();
        return true;
        } 
         catch (Exception $e) {
            return false;  
        }

    }



    if(isset($_POST['send-reset-link']))
    {
       $query="SELECT * FROM `users` WHERE `email`='$_POST[email]'";
       $result=mysqli_query($con,$query);
       if($result)
       {
          if(mysqli_num_rows($result)==1)
          {
            //*email found */
            $reset_token=bin2hex(random_bytes(16));
            date_default_timezone_set('Asia/kolkata');
            $date=date("Y-m-d");
            $query= "UPDATE `users` SET `resettoken`='$reset_token',`resettokenexpire`='$date' WHERE `email`='$_POST[email]'";
            if(mysqli_query($con,$query) && sendMail($_POST['email'],$reset_token))
            {
                echo "
                    <script>
                        alert('Password Reset Link Sent to Mail');
                        window.location.href='index.php';
                    </script>
                ";  
            }
            else
            {
                echo "
                    <script>
                        alert('Server Down! Try Again Later');
                        window.location.href='index.php';
                    </script>
                ";
            }
          }
          else
          {
            echo "
                <script>
                    alert(' Email Not Found');
                    window.location.href='index.php';
                </script>
            ";
          }
        }
       else
       {
            echo "
                <script>
                    alert('cannot run query');
                    window.location.href='index.php';
                </script>
            ";
        }


    }























































?>
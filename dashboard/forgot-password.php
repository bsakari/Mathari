<?php
    use PHPMailer\PHPMailer\PHPMailer;
    require 'conn.php';
    if (isset($_POST['btn_reset'])){
        $email = $_POST['email'];
        $selectQuery = "SELECT * FROM `users` WHERE Email='$email'";
        $select = mysqli_query($conn,$selectQuery);
        if (mysqli_num_rows($select)>0){
            $token = "hdbhasdhaHJDGfsfs21245342";
            $token = str_shuffle($token);
            $token = substr($token,0,10);
            $update_token_query = "UPDATE `users` SET `Token`='$token', `TokenExpire`=DATE_ADD(NOW(), INTERVAL 5 MINUTE) WHERE Email='$email'";
            $update_token = mysqli_query($conn,$update_token_query);


            require_once "PHPMailer/PHPMailer.php";
            require_once "PHPMailer/Exception.php";

            $mail = new PHPMailer();
            //To
            $mail->addAddress($email);
            //From
            $mail->setFrom("abc@gmail.com","KPDSPACE LAB");
            $mail->Subject = "Reset Password";
            $mail->isHTML(true);
            $mail->Body = "
                            Hi,<br><br>
                            In order to reset your password, click on the link 
                            below<br>
                            <a href='http://localhost/mpesa_api_code/dashboard/forgot-password.php?email=$email&token=$token'>
                            http://localhost/mpesa_api_code/dashboard/forgot-password.php?email=$email&token=$token</a><br><br>
                            Kind regards,<br><br>
                            KODSPACE LAB.  
                          ";
            if ($mail->send()){
                header("location:index.php") ;
            }else{
                echo "Sending email failed";
            }





        }else{
            echo "Email was not found";
        }



    }

    if (isset($_GET['email']) && isset($_GET['token'])){
            $email = $_GET['email'];
            $token = $_GET['token'];
            $selectQuery = "SELECT * FROM `users` WHERE Email='$email' AND Token='$token' AND Token!='' AND TokenExpire>NOW()";
            $rstPwd = mysqli_query($conn,$selectQuery);
            if (mysqli_num_rows($rstPwd)>0){
                $token = "hdbhasdhaHJDGfsfs21245342";
                $token = str_shuffle($token);
                $token = substr($token,0,10);

                $newPass = $token;
                $newPassEncrptd = password_hash($newPass);
                $update_token_query = "UPDATE `users` SET `Token`='', `Password`='$newPassEncrptd' WHERE Email='$email'";
                mysqli_query($conn,$update_token_query);
                echo "Your new password is $newPassEncrptd <a href='login.php'>Click here to login</a>";



            }else{
                header("location:login.php");
                exit();
            }
    }

//    else{
//        header("location:login.php");
//        exit();
//    }
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Admin - Forgot Password</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body class="bg-dark">

  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Reset Password</div>
      <div class="card-body">
        <div class="text-center mb-4">
          <h4>Forgot your password?</h4>
          <p>Enter your email address and we will send you instructions on how to reset your password.</p>
        </div>
        <form method="post" action="forgot-password.php">
          <div class="form-group">
            <div class="form-label-group">
              <input type="email" id="inputEmail" class="form-control" name="email" placeholder="Enter email address" required="required" autofocus="autofocus">
              <label for="inputEmail">Enter email address</label>
            </div>
          </div>
          <input type="submit" class="btn btn-primary btn-block" name="btn_reset">Reset Password</input>
        </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="register.php">Register an Account</a>
          <a class="d-block small" href="login.php">Login Page</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

</body>

</html>

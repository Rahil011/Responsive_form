<?php
$showerror=false;
$showsuccess=false;
$showemail=false;
$verification_otp = random_int(100000, 999999);
if(isset($_POST['submit'])){

 
    $email=$_POST["email"];
    $name=$_POST["name"];
    $password=$_POST["password"]; 

    $conn=mysqli_connect("localhost","root","","form");
    if(!$conn){
        die("Not connect to database".mysqli_connect_error());
    }

    $nameErr = $emailErr = "";   

    if(empty($_POST["email"]) && empty($_POST["password"])  && empty($_POST["name"])){
      $nameErr = $emailErr = "REQUIRED";
    }
    else{
       
      $exists="SELECT * FROM `newuser` WHERE email='$email'";
      $resultesists=mysqli_query($conn,$exists);
      $exnum=mysqli_num_rows($resultesists);
  
      if($exnum>0){
          $showemail=true;
      }
      else{
          $hash=password_hash($password,PASSWORD_DEFAULT);
          $sql= "INSERT  INTO `newuser` (`email`, `name`, `password`,`otp` ) VALUES ('$email', '$name', '$hash','$verification_otp')";
          $result=mysqli_query($conn,$sql);
  
          if($result){
              $showsuccess=true;
          }
          else{
              $showerror=true;
          }
      }


    }

   
}


?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="registration.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="login.php">LOGIN</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">CONTACT US</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
    </div>

    <?php
      
      if($showsuccess){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success</strong> Registration Successfull.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
      }
      if($showerror){
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>ERROR!</strong> Sign-up Fail!!!.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
      }
      if($showemail){
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>ERROR!</strong> Email Already exists!!!.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
      }

    ?>


    <div class="container my-5">
    <form action="registration.php" method="post">
  <div class="mb-3">
    <label for="email" class="form-label">Email address</label>
    <span class="error text-danger">* </span>
    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
    
  </div>
  <div class="mb-3">
    <label for="name" class="form-label">NAME</label>
    <span class="error text-danger">* </span>
    <input type="text" class="form-control" id="name" name="name">
    
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" id="password" name="password">
  </div>
  <button type="submit" class="btn btn-primary" name="submit">Register</button>
</form>
    </div>

      
      <?php

// To Remove unwanted errors
error_reporting(0);

// Add your connection Code

// Important Files (Please check your file path according to your folder structure)

// require "./PHPMailer-master/src/PHPMailer.php";
// require "./PHPMailer-master/src/SMTP.php";
// require "./PHPMailer-master/src/Exception.php";

require "./src/PHPMailer.php";
require "./src/SMTP.php";
require "./src/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

// Email From Form Input
$send_to_email = $_POST["email"];

// Generate Random 6-Digit OTP
// $verification_otp = random_int(100000, 999999);


// Full Name of User
$send_to_name = $_POST["name"];

function sendMail($send_to, $otp, $name) {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "tls";
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Enter your email ID
    $mail->Username = "bbe.ctf@gmail.com";
    $mail->Password = "zersmdgittpcywcw";

    // Your email ID and Email Title
    $mail->setFrom("bbe.ctf@gmail.com", "BBE CTF");

    $mail->addAddress($send_to);

    // You can change the subject according to your requirement!
    $mail->Subject = "Account Activation";

    // You can change the Body Message according to your requirement!
    $mail->Body = "Hello, {$name}\nYour account registration is successfully done! Now activate your account with OTP {$otp}.";
    $mail->send();
}

    sendMail($send_to_email, $verification_otp, $send_to_name);
    // $statusmail= sendMail($send_to_email, $verification_otp, $send_to_name);
    


   // Message to print email success!
    echo "Email Sent Successfully!";

    session_start();
    $_SESSION['email']=$email;
    header("location: modal.php")
    // if(sendMail($send_to_email, $verification_otp, $send_to_name)){
    //   echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    //   <strong>Success</strong> OTP SEND SUCCESSFULLY.
    //   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    // </div>';
    // }

    // $sql= "INSERT INTO `newuser` ( `otp`) VALUES ('$verification_otp');";
    // $result=mysqli_query($conn,$sql);
    // if($result){
    //   header("location: modal.php");
    // }
      




?>

   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  </body>
</html>
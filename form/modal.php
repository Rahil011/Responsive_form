<?php
session_start();
$showerr=false;
if(isset($_POST['submit'])){

    $user_otp=$_POST['otp'];
    $email=$_SESSION['email'];
    
    $conn=mysqli_connect("localhost","root","","form");
    if(!$conn){
        die("Not connect to database".mysqli_connect_error());
    }
    else{
        
        $sql= "SELECT * FROM newuser WHERE email='$email'";
        $result=mysqli_query($conn,$sql);
        $num=mysqli_num_rows($result);
        if($num==1){
            while($rows=mysqli_fetch_assoc($result)){
                if($user_otp==$rows['otp']){
                    echo "otp verify";
                    session_unset();
                    session_destroy();
                    header("location: login.php");

                }
                else{
                    $showerr=true;
                }
            }
        }
    }
      
   
       
       
}
    

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <style>
        body {
            background-color: red
        }

        .height-100 {
            height: 100vh
        }

        .card {
            width: 400px;
            border: none;
            height: 300px;
            box-shadow: 0px 5px 20px 0px #d2dae3;
            z-index: 1;
            display: flex;
            justify-content: center;
            align-items: center
        }

        .card h6 {
            color: red;
            font-size: 20px
        }

        .inputs input {
            width: 240px;
            height: 40px
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            margin: 0
        }

        .card-2 {
            background-color: #fff;
            padding: 10px;
            width: 350px;
            height: 100px;
            bottom: -50px;
            left: 20px;
            position: absolute;
            border-radius: 5px
        }

        .card-2 .content {
            margin-top: 50px
        }

        .card-2 .content a {
            color: red
        }

        .form-control:focus {
            box-shadow: none;
            border: 2px solid red
        }

        .validate {
            border-radius: 20px;
            height: 40px;
            background-color: red;
            border: 1px solid red;
            width: 140px
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="container height-100 d-flex justify-content-center align-items-center">
            <div class="position-relative">
                <div class="card p-2 text-center">
                    <h6>Please enter the one time password <br> to verify your account</h6>
                    <div> <span>A code has been sent to</span> <small> <?php $email?></small> </div>
                    <div><?php
                     if($showerr){
                        echo' <strong>ERROR!</strong> Enter correct otp';
                     } ?></div>
                    <form action="modal.php" method="post">
                    <div id="otp" class="inputs d-flex flex-row justify-content-center mt-2"> <input
                             class="m-2 text-center form-control rounded" type="text" id="first" name="otp" />
                         </div> 
                    <div class="mt-4"> <button class="btn btn-danger px-4 validate" name="submit" type="submit">Validate</button> </div>
                    </form>
                   
                </div>
            </div>
        </div>

        <script>
           
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
            crossorigin="anonymous"></script>

</body>

</html>
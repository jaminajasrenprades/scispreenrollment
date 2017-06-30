<?php 
    require 'classes/UserAccount.php';
?>

<!DOCTYPE html>
<html class="no-js">
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Login Page</title>
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/login.css">
        <link rel="stylesheet" href="css/login.css">
        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">

        <!-- FontAwesome -->
        <link rel="stylesheet" href="css/font-awesome.min.css">
</head>
<body>

    <?php
    $errMsg = "";
  if(isset($_POST['submit'])){
    //username and password sent from Form
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if($username == '')
      $errMsg .= 'You must enter your Username<br>';

    if($password == '')
      $errMsg .= 'You must enter your Password<br>';

    //if($errMsg == ''){
        if($username && $password){
            require "dbcon.php";
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $loginAdmin = "SELECT * FROM pre_enrollment.users WHERE username= '$username' AND password='$password' and type = 4"; //admin login
            $loginNonEnrollee = "SELECT * FROM pre_enrollment.users WHERE username='$username' AND password='$password' and type= 2"; //non-enrolle            
            $loginPreEnrollee = "SELECT * FROM pre_enrollment.users WHERE username='$username' AND password='$password' and type = 1"; //pre-enrolle
            $loginFail = "SELECT * FROM pre_enrollment.users where username='$username' AND password='$password'"; //non user
            
            $loginAd = $pdo->query($loginAdmin);
            $loginAd->execute();
            $countAd = $loginAd->rowCount();
            
            $loginNon = $pdo->query($loginNonEnrollee);
            $loginNon->execute();
            $countNon = $loginNon->rowCount();
            
            $loginPre = $pdo->query($loginPreEnrollee);
            $loginPre->execute();
            $countPre = $loginPre->rowCount();
            
            $faillogin = $pdo->query($loginFail);
            $faillogin->execute();
            $countFail = $faillogin->rowCount();
            
            if ($countFail == 0) {
                $message = "User Account does not exists";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }
            if($countAd != 0){
                while($rows = $loginAd->fetch(PDO::FETCH_ASSOC)){
                    $dbuser = $rows["username"];
                    $dbpass = $rows["password"];
                    if($username == $dbuser && $password == $dbpass ) {
                        session_start();
                           $userid=$rows['userid'];
                           $name = $rows['name'];
                           $email = $rows['email'];
                           $idnumber=$rows['idnumber'];
                           $type = $rows['type'];
                           
                           $userAccount = new UserAccount($userid, $dbuser, '', $name, $type, $email, $idnumber);
                           $_SESSION["userAccount"] = $userAccount;
                           
                           $_SESSION["username"]=$dbuser;
                     //   header('location:Pre-enrollment.php');

                    }else{
                       $errMsg .= "User Credentials Not Found!";
                    }
                }
            }
            
            if($countNon != 0){
                while($rows = $loginNon->fetch(PDO::FETCH_ASSOC)){
                    $dbuser = $rows["username"];
                    $dbpass = $rows["password"];
                    if($username == $dbuser && $password == $dbpass ) {
                        session_start();
                        $userid=$rows['userid'];
                           $name = $rows['name'];
                           $email = $rows['email'];
                           $idnumber=$rows['idnumber'];
                           $type = $rows['type'];
                           
                           $userAccount = new UserAccount($userid, $dbuser, '', $name, $type, $email, $idnumber);
                           $_SESSION["userAccount"] = $userAccount;
                           
                           $_SESSION["username"]=$dbuser;
                        header('location:Pre-enrollment.php');

                    }else{
                       $errMsg .= "User Credentials Not Found!";
                    }
                }
            }
            if($countPre != 0){
                while($rows = $loginPre->fetch(PDO::FETCH_ASSOC)){
                    $dbuser = $rows["username"];
                    $dbpass = $rows["password"];
                    if($username == $dbuser && $password == $dbpass ) {
                        session_start();
                        $userid=$rows['userid'];
                           $name = $rows['name'];
                           $email = $rows['email'];
                           $idnumber=$rows['idnumber'];
                           $type = $rows['type'];
                           
                           $userAccount = new UserAccount($userid, $dbuser, '', $name, $type, $email, $idnumber);
                           $_SESSION["userAccount"] = $userAccount;
                           
                           $_SESSION["username"]=$dbuser;
                        header('location:Pre-enrollment.php');

                    }else{
                       $errMsg .= "User Credentials Not Found!";
                    }
                }
            }

    }

  }

?>
     <?php
    $errMsg = "";
  if(isset($_GET['submit'])){
    //username and password sent from Form
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if($username == '')
      $errMsg .= 'You must enter your Username<br>';

    if($password == '')
      $errMsg .= 'You must enter your Password<br>';

    //if($errMsg == ''){
        if($username && $password){
            require "dbcon.php";
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $loginAdmin = "SELECT * FROM pre_enrollment.` users` WHERE username= '$username' AND password='$password' and type = 4"; //admin login
            $loginNonEnrollee = "SELECT * FROM pre_enrollment.` users` WHERE username='$username' AND password='$password' and type= 2"; //non-enrolle            
            $loginPreEnrollee = "SELECT * FROM pre_enrollment.` users` WHERE username='$username' AND password='$password' and type = 1"; //pre-enrolle
            $loginFail = "SELECT * FROM pre_enrollment.` users` where username='$username' AND password='$password'"; //non user
            
            $loginAd = $pdo->query($loginAdmin);
            $loginAd->execute();
            $countAd = $loginAd->rowCount();
            
            $loginNon = $pdo->query($loginNonEnrollee);
            $loginNon->execute();
            $countNon = $loginNon->rowCount();
            
            $loginPre = $pdo->query($loginPreEnrollee);
            $loginPre->execute();
            $countPre = $loginPre->rowCount();
            
            $faillogin = $pdo->query($loginFail);
            $faillogin->execute();
            $countFail = $faillogin->rowCount();
            
            if ($countFail == 0) {
                $message = "User Account does not exists";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }
            if($countAd != 0){
                while($rows = $loginAd->fetch(PDO::FETCH_ASSOC)){
                    $dbuser = $rows["username"];
                    $dbpass = $rows["password"];
                    if($username == $dbuser && $password == $dbpass ) {
                        session_start();
                           $userid=$rows['userid'];
                           $name = $rows['name'];
                           $email = $rows['email'];
                           $idnumber=$rows['idnumber'];
                           $type = $rows['type'];
                           
                           $userAccount = new UserAccount($userid, $dbuser, $password, $name, $type, $email, $idnumber);
                           $_SESSION['userAccount'] = $userAccount;
                           $_SESSION["username"]=$dbuser;
                        header('location:Pre-enrollment.php');

                    }else{
                       $errMsg .= "User Credentials Not Found!";
                    }
                }
            }
            
            if($countNon != 0){
                while($rows = $loginNon->fetch(PDO::FETCH_ASSOC)){
                    $dbuser = $rows["username"];
                    $dbpass = $rows["password"];
                    if($username == $dbuser && $password == $dbpass ) {
                        //session_start();

                        $_SESSION["username"]=$dbuser;
                        //header('location:FromEnrollment.php');

                    }else{
                       $errMsg .= "User Credentials Not Found!";
                    }
                }
            }
            if($countPre != 0){
                while($rows = $loginPre->fetch(PDO::FETCH_ASSOC)){
                    $dbuser = $rows["username"];
                    $dbpass = $rows["password"];
                    if($username == $dbuser && $password == $dbpass ) {
                       // session_start();

                        $_SESSION["username"]=$dbuser;
                       // header('location:FromEnrollment.php');

                    }else{
                       $errMsg .= "User Credentials Not Found!";
                    }
                }
            }
    }

  }

?>
 
<div class="container">
  <div class="row" style="margin-top:20px">
    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
        <form name="form_login" method="post" action="">
        <fieldset>
            <div class="text-center">
                <img class="logoLogin" src="images/SCIS%20Logo.png">
                <p class="titleLogo">School of Computing and Information Sciences</p>
                <p class="subTitle">Pre - Enrollment System</p>
            </div>
          
          <hr class="colorgraph">
          <div class="form-group">
            <input name="username" type="text" id="username" class="form-control input-lg" placeholder="ID Number">
          </div>
          <div class="form-group">
            <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password">
          </div>
          <hr class="colorgraph">
            <!-- Add login URL in index.php -->
            <a class="btn btn-block btn-social btn-google-plus" href="#">
            <i class="fa fa-google-plus"></i>
            </a>
            
            <div class="row">
                <div>
                  <input type="submit" name="submit" value="Login" class="btn btn-success btn-block">
                </div>
            </div>
        </fieldset>
      </form>
    </div>
  </div>
</div>
   
</body>
</html>
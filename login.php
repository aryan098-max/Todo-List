<?php

include "configure/config.php";
// using session to login the user so we need to start the session

session_start();

// If user is already logged in he will be redirected to todos.php if he tries login
// This will prevent the hassale of logging again again using $_SESSION
if(isset($_SESSION["user_email"])){
  header("Location:todos.php");
  die();

}


// checking whether the POST method in form is ready or not 
// We will use the name attribute for checking so you must include name attribute in the form
if(isset($_POST["submit"])){
    // sql injection md5 for password protection
    $email = mysqli_real_escape_string($conn,$_POST["email"]);
    $password = mysqli_real_escape_string($conn,md5($_POST["password"]));

    // Logging in and being redirected to todos.php
    if (isemailValid($email)){
       if(checkLoginDetail($email, $password)){
        $_SESSION["user_email"] = $email; 
        header("Location: todos.php");
        die();
       }
       else{
         echo "<script>alert('Login details is invalid'); window.location.replace('index.php');</script>";

        }
    }

    // Registraion and logged in so header is required for both 
    else{
        $user_registration = createUser($email, $password);
        if($user_registration){
          $_SESSION["user_email"] = $email; 
          header("Location: todos.php");
          die();
        }
        else{
            echo "User registration failed. Please try again later";
            die();
        }
    }

}else{
    // If user tries to go to login.php without signing in he will be redirected to login.php 
    // Trying to login without submitting the form redirected to index.php
    header("Location:index.php");
}
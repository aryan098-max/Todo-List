<?php
// To establish the connection 
include "configure/config.php"; 

// If user is logged in ones even if he tries to go to login.php or index he will be redirected to todos.php 
session_start();
if(isset($_SESSION["user_email"])){
  header("Location:todos.php");
  die();
}


?>

<!doctype html>
<html lang="en">
  <head>
    <?php getHead();?>
    
  </head>
  <body >
    <h1>Create your own TodoList</h1>
    <div class="container col-xl-10 col-xxl-8 px-4 py-5">
    <div class="row align-items-center g-lg-5 py-5">
      <div class="col-lg-7 text-center text-lg-start">
        <h1 class="display-4 fw-bold lh-1 mb-3">Sign in for using TodoList</h1>
        <p class="col-lg-10 fs-4">Never ever miss the task you need to do</p>
      </div>
      <div class="col-md-10 mx-auto col-lg-5">
        <form action="login.php" method="POST" class="p-4 p-md-5 border rounded-3 bg-light">
          <div class="form-floating mb-3">
            <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Email address</label>
          </div>
          <div class="form-floating mb-3">
            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">Password</label>
          </div>
    
          <button name="submit" class="w-100 btn btn-lg btn-primary" type="submit">Login/singup</button>
          <hr class="my-4">
          <small class="text-muted">If you are the user you will be logged in else you will registered as a new user</small>
        </form>
      </div>
    </div>
  </div>

   
  </body>
</html>
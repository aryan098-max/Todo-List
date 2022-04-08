<?php
// To use getHeader();
include "configure/config.php"; 

session_start();
if(!isset($_SESSION["user_email"])){
    header("Location:index.php");
    die();
}

?>


<!doctype html>
<html lang="en">
    <head>
    <?php getHead();?>

   </head>
  <body style="background-color: #8EC5FC;
background-image: linear-gradient(62deg, #8EC5FC 0%, #E0C3FC 100%);
" >

    <?php getHeader();?>
    <div class="container">
        <h1 class="mb-4 text-center fw-bold"> Your Todos List </h1>
        <div class="row">
        <?php
                 
                 $sql = "SELECT id FROM users WHERE email='{$_SESSION["user_email"]}' ";
                 $result = mysqli_query($conn, $sql);
                 $count = mysqli_num_rows($result);
                 if($count>0){
                     $row = mysqli_fetch_assoc($result);
                     $user_id = $row["id"];
                     //same id as the user id in the user database echo $user_id;
                 }else{
                     $user_id = 0;
                 }
                 $sql1 = "SELECT * FROM todos WHERE user_id='{$user_id}'ORDER BY id DESC" ;
                 $result1 = mysqli_query($conn, $sql1);
                 if(mysqli_num_rows($result1)>0){
                 foreach($result1 as $todo){
                ?>
            <div class="col-lg-3 col-md-6 mb-4">
                
                 <?php getTodo($todo); ?> 
                   
            </div>
            <?php   }}else {echo'
            <div class="text-center fw-bold" >
            <h1 class="text-danger ">Start Creatting your todos now</h1>
            <a href="addtodos.php" class="btn btn-info">Click Here to Addtodos</a>
            </div>

            ';}?>
            

        </div>
    </div>
    <?php getFooter();?>
  </body>

</html>
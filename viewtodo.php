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
    <head >
    <?php getHead();?>
     
   </head>
  <body style="background-color: #8EC5FC;
background-image: linear-gradient(62deg, #8EC5FC 0%, #E0C3FC 100%);
">

    <?php getHeader();?>
    <div class="container">
        <div class="row">
        <?php
        $todoId = mysqli_real_escape_string($conn, $_GET["id"]);
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
         $sql1 = "SELECT * FROM todos WHERE id='{$todoId}' AND user_id='{$user_id}'" ;
         $result1 = mysqli_query($conn, $sql1);
         if(mysqli_num_rows($result1)>0){
         foreach($result1 as $todo){
        ?>
        <main>
                    <h4><?php echo $todo["title"]?></h4>
                    <p class="fs-5 col-md-8"><?php echo $todo["deadline"]?> </p>
                    <p class="fs-5 col-md-8"><?php echo $todo["description"]?> </p>

                    <div class="mb-5">
                    <!-- Redirecting to edittodo.php -->
                    <a href="<?php echo 'edittodo.php?id='.$todo['id'];?>" class="btn btn-primary btn-lg px-4 me-2">Edit</a>
                    <a href="<?php echo 'deletetodo.php?id='.$todo['id'];?>" class="btn btn-danger btn-lg px-4">Delete</a>

                    </div>
                </main>
    
       <?php   }}else{
           header("Location:todos.php");
           die();
       } ?>
        </div>
    </div>
    <?php getFooter();?>
  </body>
</html>
<?php
// To use getHeader();
include "configure/config.php"; 

session_start();
if(!isset($_SESSION["user_email"])){
    header("Location:index.php");
    die();
}

// If url is not set to id we will be redirected to todos.php which is our homepage
// url with id=27- http://localhost/todoList/edittodo.php?id=27
if(isset($_GET["id"])){
    $todoId = mysqli_real_escape_string($conn, $_GET["id"]);

        // Get the Id based on user email
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

    //Deleting todo on the basis of todoId and user_id
    $sql = "DELETE FROM todos WHERE id='{$todoId}' AND user_id='{$user_id}'";
    mysqli_query($conn, $sql);
    header("Location:todos.php");
    


}else{
    header("Location: todos.php");
}

?>

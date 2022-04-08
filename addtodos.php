<?php
// To use getHeader();
include "configure/config.php"; 

session_start();
if(!isset($_SESSION["user_email"])){
    header("Location:index.php");
    die();
}

$msg ="";
// When submit button is clicked our changes are going to be saved in the database using inputs in the title , description and
// we are getting the user_id from the user tables to store the data inside that particular user 
if(isset($_POST["addTodo"])){

    $title = mysqli_real_escape_string($conn, $_POST["title"]);
    $deadline = mysqli_real_escape_string($conn, $_POST["deadline"]);
    $description = mysqli_real_escape_string($conn, $_POST["description"]);


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

    $sql = null;

    // Inserting into 
    $sql = "INSERT INTO todos (title, deadline, description, user_id) VALUES ('$title', '$deadline','$description', '$user_id')";
    $result = mysqli_query($conn,$sql);
    if($result){

        $_POST["title"] = "";
        $_POST["deadline"] = "";
        $_POST["description"] = "";

        $msg = "<div class='alert alert-success'>Your Todo task is create</div>";
    }else{
        $msg = "<div class='alert alert-success'>Your Todo task isn't created</div>";

    }
    //-> To keep the existing the from data when we reload our when we add to our todo we will use
    //value="<?php if(isset($_POST["addTodo"])){echo $_POST["title"];}

}
?>

<!doctype html>
<html lang="en">
    <head>
    <?php getHead();?>
   </head>
   <body style="background-color: #8BC6EC;
background-image: linear-gradient(135deg, #8BC6EC 0%, #9599E2 100%);
">

    <?php getHeader();?>

    <div class="container py-5">
        <div class="row"> 
            <div class="col-md-5 mx-auto"> 
                <div class="card bg-white rounded border shadow px-4 py-3"> 
                    <div class="card-header"> 
                        <h4 class="card-title"> Add Todo</h4>
                    </div>
                    <div class="card-body p-4">
                        <?php echo $msg; ?>
                        <form action="" method="POST"> 
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input class="form-control" id="title" name="title" placeholder="Complete php project"  required>
                            </div>
                            <div class="mb-3">
                            <label for="deadline" class="form-label">Deadline</label>
                            <input class="form-control" id="deadline" name="deadline"rows="3" required>
                            <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description"rows="3" required></textarea>
                            </div>
                            <div> 
                                <button type="submit" name="addTodo" class="btn btn-primary me-3">Add Todo</button>
                                <button type="reset" class="btn btn-danger">Reset</button>
                            </div>
                        </form>
                   </div>
                </div>
            </div> 
       </div> 
    </div>
     
  </body>
</html>
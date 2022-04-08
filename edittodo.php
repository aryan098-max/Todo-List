<?php
// To use getHeader();
include "configure/config.php"; 

session_start();
if(!isset($_SESSION["user_email"])){
    header("Location:index.php");
    die();
}

// If url is set to different id of another todos user than it will be redicted to todos.php again
// url with id=27- http://localhost/todoList/edittodo.php?id=27
if(isset($_GET["id"])){
    $todoId = mysqli_real_escape_string($conn, $_GET["id"]);
}else{
    header("Location: todos.php");
}

$msg ="";
// When submit button is clicked our changes are going to be saved in the database using inputs in the title , description and
// we are getting the user_id from the user tables to store the data inside that particular user 
if(isset($_POST["updateaddTodo"])){

    $title = mysqli_real_escape_string($conn, $_POST["title"]);
    $deadline = mysqli_real_escape_string($conn, $_POST["deadline"]);
    $description = mysqli_real_escape_string($conn, $_POST["description"]);


    $sql = null;

    // Updating todo 
    $sql = "UPDATE todos SET title='{$title}', deadline='{$deadline}', description='{$description}', date=CURRENT_TIMESTAMP WHERE id='{$todoId}'";
    $result = mysqli_query($conn,$sql);
    if($result){

        $_POST["title"] = "";
        $_POST["deadline"] = "";
        $_POST["description"] = "";

        $msg = "<div class='alert alert-success'>Your Todo task is Updated</div>";
    }else{
        $msg = "<div class='alert alert-success'>Your Todo task isn't Updated</div>";

    }
}

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

$sql = "SELECT * FROM todos WHERE id='{$todoId}' AND user_id='{$user_id}' ";
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result)>0){
    $todoData = mysqli_fetch_assoc($result);
}else{
    header("Location: todos.php");
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

    <div  class="container py-5">
        <div class="row"> 
            <div class="col-md-5 mx-auto"> 
                <div class="card bg-white rounded border shadow px-4 py-3"> 
                    <div class="card-header"> 
                        <h4 class="card-title">Edit Todo</h4>
                    </div>
                    <div class="card-body p-4">
                        <?php echo $msg; ?>
                        <form action="" method="POST"> 
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input class="form-control" id="title" name="title" value= "<?php echo $todoData['title']; ?>"placeholder="Complete php project"  required>
                            </div>
                            <div class="mb-3">
                            <label for="deadline" class="form-label">Deadline</label>
                            <input class="form-control" id="deadline" name="deadline"  value= "<?php echo $todoData['deadline']; ?>" rows="3" required>
                            <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description"rows="3"   required> <?php echo $todoData['description'];?></textarea>
                            </div>
                            <div> 
                                <button type="submit" name="updateaddTodo" class="btn btn-primary me-3">Update Todo</button>
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
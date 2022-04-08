<?php

// Creating Database connection function 

function dbConnect(){
$hostname = "localhost";
$email= "root";
$password = "";
// Name of the our database
$database = "todoList";

// Establishing the connection 
$conn = mysqli_connect($hostname, $email, $password, $database) or die("Database connection failed");
return $conn;
}

$conn = dbConnect(); 



// Creating function for checking whether email is valid or not from database
                                                
function isemailValid($email){

    $conn = dbConnect();
    $sql = "SELECT email FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);
    if($count>0){
        return true;
    }
    else{
        return false;
    }

}

// Check login detials is correct or not 

function checkLoginDetail($email, $password){

    $conn = dbConnect();
    $sql = "SELECT email FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);
    if($count>0){
        return true;
    }
    else{
        return false;
    }

}

function getHead(){

    $pageTitle = dynamicTitle();

    $output = '

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> 
     
    <title>'.$pageTitle.'</title>';
    
    echo $output;

}


// Create user if user doesn't exist

function createUser($email, $password){

    $conn = dbConnect();
    $sql = "INSERT INTO users (email, password) VALUES ('$email', '$password')";
    $result = mysqli_query($conn, $sql);
   return $result;

}


function getHeader(){
    $output = 
    '
    <header style="background-color: #8EC5FC;
    background-image: linear-gradient(62deg, #8EC5FC 0%, #E0C3FC 100%);
    "class=" py-3 mb-4 border-bottom bg-white">
      <div class=" d-flex flex-wrap justify-content-center container">
      <a href="todos.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
        <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
        <span class="fs-4">Todo List</span>
      </a>

      <ul class="nav nav-pills">
        <li class="nav-item"><a href="todos.php" class="nav-link active" aria-current="page">Home</a></li>
        <li class="nav-item"><a href="addtodos.php" class="nav-link">Add Todos</a></li>
        <li class="nav-item"><a href="logout.php" class="btn btn-secondary" class=" nav-link">Logout</a></li>  
      </ul> 
    </div>
    </header>';
   

    // otherwise changes won't be visible 
    echo $output;


}


function getFooter(){
  $output ='

 <div style="
  
  position:absolute;
  bottom:0;
  width:100%;
  height:60px;   /* Height of the footer */ 
 ">
  <footer  class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
    <p class="col-md-4 mb-0 text-muted">© 2021 Company, Inc</p>

    <a href="/" class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
      <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
    </a>

    <ul class="nav col-md-4 justify-content-end">
      <li class="nav-item"><a href="todos.php" class="nav-link px-2 text-muted">Home</a></li>
      <li class="nav-item"><a href="addtodos.php" class="nav-link px-2 text-muted">Add Todos</a></li>
    </ul>
  </footer>
  </div>';
  echo $output;
}


// Get todo 

function getTodo($todo){
    $output =
    '
    <div class="card shadow-sm">
    <div class="card-body">
    <h4 class="card-title">'.$todo['title'].'</h4>
      <p class="card-text">'.$todo['deadline'].'</p>
      <p class="card-text">'.$todo['description'].'</p>
      <div class="d-flex justify-content-between align-items-center">
        <div class="btn-group">
          <a href="viewtodo.php?id='.$todo['id'].'" class="btn btn-sm btn-outline-secondary">View</a>
          <a href="edittodo.php?id='.$todo['id'].'" class="btn btn-sm btn-outline-secondary">Edit</a>
        </div>
        <small class="text-muted">'.$todo['date'].'</small>
      </div>
    </div>
  </div>';
    echo $output;

} 



function dynamicTitle(){
    global $conn; 
    $filename = basename($_SERVER["PHP_SELF"]);
    $pageTitle =" ";
    switch ($filename) {
        case 'index.php':
             $pageTitle = "login";
            break;
        
        case 'todos.php':
               $pageTitle = "Home";
               break;

        case 'addtodos.php':
                $pageTitle = "Add Todo";
               break;

        case 'edittodo.php':
                $pageTitle = "Edit Todo";
               break;

        case 'viewtodo.php':    
            $todoId = mysqli_real_escape_string($conn, $_GET["id"]);
             $sql = "SELECT * FROM todos WHERE id='{$todoId}'";
             $result1 = mysqli_query($conn, $sql);             
             if(mysqli_num_rows($result1)>0){
             foreach($result1 as $todo){
                 $pageTitle = $todo["title"];

               }
              }
            break;
            
        default:
            $pageTitle = "Todo List";
            break;
    }

    return $pageTitle;
}
















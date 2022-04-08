<?php

session_start();

// we are not going to unset all the session only the paritcular session i.e; user_email
unset($_SESSION["user_email"]);
session_destroy();

// redirect
header("Location:index.php");
?> 
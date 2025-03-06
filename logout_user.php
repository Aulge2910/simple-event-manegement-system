<?php  session_start();      
  session_start();
  include('connection.php');  
  session_unset();
  session_destroy();
  header("Location:sign_in.html");
?>  

<?php  session_start(); ?>      

<?php     

  include('connection.php');  
  $email = $_POST['email'];  
  $password = $_POST['password'];  
    
  //to prevent from mysqli injection  
  $email = stripcslashes($email);  
  $password = stripcslashes($password);  
  $email = mysqli_real_escape_string($con, $email);  
  $password = mysqli_real_escape_string($con, $password);  

  $sql = "select * from user_information where user_email = '$email' and user_password = '$password'";  
  $result = mysqli_query($con, $sql);  
  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
  
  $count = mysqli_num_rows($result);  
    
  if($count == 1){      
    $_SESSION['user_id']= $row['user_info_id'];
    $_SESSION['user_email']= $row['user_email'];
    $_SESSION['admin_status']= $row['admin_status'];
    $_SESSION['user_logged']= 1;
    $_SESSION['user_name']=ucfirst($row["user_name"]);

    echo"<script> alert('Login Successful'); </script>";
    echo"<script> window.location.assign('event_paginate.php'); </script>";
  }  
  
  else{ 
    $_SESSION['user_id']="";
    $_SESSION['user_email']="";
    $_SESSION['user_name']="";
    echo"<script> alert('Invalid Login'); window.location.assign('sign_in.html');  </script>";
  }     
?>  

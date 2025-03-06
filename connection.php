<?php      
    $host = "localhost";  
    $user = "root";  
    $password ="";  
    $dbname = "icats-ems";  
      
    $con = mysqli_connect($host, $user, $password, $dbname);  
    if(mysqli_connect_error()) {  
        die("Failed to connect with MySQL: ". mysqli_connect_error());  
    }  
?>  

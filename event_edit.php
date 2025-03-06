<?php
 
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname="icats-ems";

	$conn = mysqli_connect($servername, $username, $password, $dbname);
	
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

    $name = $_POST['name'];
    $gender = $_POST['gender'];
	$email = $_POST['email'];
	$password = $_POST['password'];

	$sql_check_customer_is_exist ="SELECT * from user_information WHERE user_name ='$name' AND user_email = '$email'";
	$result_check_customer_is_exist = mysqli_query($conn, $sql_check_customer_is_exist);  
	$row = mysqli_fetch_array($result_check_customer_is_exist, MYSQLI_ASSOC);  
	
	$count = mysqli_num_rows($result_check_customer_is_exist);  
		
	if($count > 1){  
		echo"<script> alert('User Already Exist. Please Login In'); window.location.assign('sign_in.html');</script>";
	}

	else {
		$sql = "INSERT INTO user_information (user_name, user_gender,user_email, user_password) 
		VALUES ('$name','$gender','$email','$password');";
		
		if (mysqli_query($conn, $sql)) {
			echo"<script> alert('Record Created'); window.location.assign('sign_in.html')  </script>";
		} 
	
		else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
		
	};

	mysqli_close($conn);

?>

<?php
 
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname="icats-ems";

	$conn = mysqli_connect($servername, $username, $password, $dbname);
	
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

	$contact_query = $_POST['contact_query'];
	$contact_email = $_POST['contact_email'];
	
	$sql = "INSERT INTO query (user_email, user_query) VALUES ('$contact_email','$contact_query');";

	if (mysqli_query($conn, $sql)) {
		echo"<script> alert('You Have Send Your Inquiry.'); window.location.assign('index.php')  </script>";
	} 
	
	else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
			
	mysqli_close($conn);

?>

<?php
 
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname="icats-ems";

	$conn = mysqli_connect($servername, $username, $password, $dbname);
	
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

	$feedback = $_POST['feedback'];
	$event_id = $_POST['event_id'];
	$user_id = $_POST['user_id'];
 
	$sql_check_clash ="SELECT * from feedback WHERE user_info_id ='$user_id' AND event_id = '$event_id'";
	$result_check_clash = mysqli_query($conn, $sql_check_clash);  
	$row = mysqli_fetch_array($result_check_clash, MYSQLI_ASSOC);  
	
	$count = mysqli_num_rows($result_check_clash);  
		
	if($count >= 1){  
		echo"<script> alert('You Have Fill In Your Feedback Previously.'); window.location.assign('event_agenda.php');</script>";
	}

	else {
		$sql = "INSERT INTO feedback (feedback, event_id, user_info_id) VALUES ('$feedback','$event_id', '$user_id');";

		if (mysqli_query($conn, $sql)) {
			echo"<script> alert('You Have Send Your Feedback.') </script>";

			$sql2 = "UPDATE event_record SET feedback ='1' where event_id = '$event_id' and user_info_id = '$user_id' ";      
			if (mysqli_query($conn, $sql2)) {
				echo"<script> alert('Feedback Updated'); window.location.assign('event_agenda.php')</script>";
			}
			else {
				echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
			}
			
		} 
	
		else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
		
	};
 
	mysqli_close($conn);

?>

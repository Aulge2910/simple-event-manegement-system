<?php
 
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname="icats-ems";

	$conn = mysqli_connect($servername, $username, $password, $dbname);
	
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

    $user_id= $_GET['user_id'];
    $event_id= $_GET['event_id'];
    $check_in_date = date("Y-m-d h:i:sa");

    $sql_check_status= "Select * from event_record WHERE event_id ='$event_id' AND user_info_id ='$user_id' ";
    $result_check_status = mysqli_query($conn, $sql_check_status);

    if (mysqli_num_rows($result_check_status) >=1) {
        echo'
        <script>
          alert("You have checkin previously.");window.location.assign("event_paginate.php");
        </script>
      ';
    }
    else if (mysqli_num_rows($result_check_status) == 0){
	
	$sql = "INSERT INTO event_record (event_id, user_info_id, check_in_date) VALUES ('$event_id','$user_id','$check_in_date');";

	if (mysqli_query($conn, $sql)) {
		echo"<script> alert('Check In Done'); window.location.assign('event_paginate.php')  </script>";
	} 
	
	else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
};
	mysqli_close($conn);

?>

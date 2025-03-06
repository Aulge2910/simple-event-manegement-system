<?php
session_start();
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "icats-ems";

// Create connection
$conn       = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

date_default_timezone_set("Asia/Kuching");
$current_date = new DateTime("now", new DateTimeZone('Asia/Kuching') );


$sql    = 'select * from event ';
$result = $conn->query($sql);
$event_status = "";

if ($result->num_rows > 0) {

    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $datetime1 = $row['event_start_datime'];
 
        $datetime2 = $row['event_end_date'];
        $event_id = $row['event_id'];

        $datetime1 = new DateTime($datetime1); //4pm
        $datetime2 = new DateTime($datetime2); //5pm
        
        if($current_date <$datetime1 ) {       
            $event_status="onhold";
        }

        else if($current_date >$datetime1 && $current_date <$datetime2 ) {
            $event_status="ongoing";
        }
        else if ($current_date >$datetime2) {
            $event_status="completed";
        }

        $sql_update_event_status=  "UPDATE event SET event_status = '$event_status' WHERE event_id = '$event_id'";
        $result_update_event_status = mysqli_query($conn, $sql_update_event_status);  
    }
} else {
    echo "<br>" . "\n0 results\n";
}


$conn->close();

?>
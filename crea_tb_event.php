<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname="icats-ems";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "CREATE TABLE event (

    event_id int(10) AUTO_INCREMENT NOT NULL UNIQUE,	
	event_start_date 	date, 		
	event_end_date 	datetime 	,	
	event_title 	varchar(50) 	,
	event_description 	varchar(500) ,
	event_venue_name 	varchar(50) 	,
	event_image 	varchar(100) 	,
	slot 	varchar(100) 	,
	event_start_time 	time 		,	
	event_end_time 	time 		,
	time_range 	varchar(100) 	,
	user_info_id int(10)		,
	event_status 	varchar(50) 	,

    PRIMARY KEY (event_id),
    FOREIGN KEY (user_info_id) REFERENCES user_information(user_info_id) on update cascade on delete cascade
    )";

    if (mysqli_query($conn, $sql)) {
        echo "Table created successfully\n";
    } 
    
    else {
        echo "Error creating table: " . $conn->error;
    }

    mysqli_close($conn);
?>

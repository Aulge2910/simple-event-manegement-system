<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname="icats-ems";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "CREATE TABLE event_record (
    event_record_id int(10) AUTO_INCREMENT NOT NULL UNIQUE,
    event_id int(10),
    user_info_id int(10),
    check_in_date datetime,
    
    PRIMARY KEY (event_record_id),
    FOREIGN KEY (event_id) REFERENCES event(event_id) on update cascade on delete cascade,
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

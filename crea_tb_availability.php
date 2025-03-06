<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname="icats-ems";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "CREATE TABLE venue_availability (
    venue_availability_id int(10) AUTO_INCREMENT NOT NULL UNIQUE,
    venue_name varchar(100),
    selected_range varchar(100),
    selected_date date,
    PRIMARY KEY (venue_availability_id)
    )";

    if (mysqli_query($conn, $sql)) {
        echo "Table created successfully\n";
    } 
    
    else {
        echo "Error creating table: " . $conn->error;
    }

    mysqli_close($conn);
?>

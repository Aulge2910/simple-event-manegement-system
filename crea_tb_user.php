<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname="icats-ems";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "CREATE TABLE user_information (
    user_id int(10) AUTO_INCREMENT NOT NULL UNIQUE,
    user_name VARCHAR(50) NOT NULL,
    user_gender VARCHAR(20) NOT NULL,
    user_email VARCHAR(50) NOT NULL,
    user_password varchar(50) NOT NULL,
    PRIMARY KEY (user_id)
    )";

    if (mysqli_query($conn, $sql)) {
        echo "Table created successfully\n";
    } 
    
    else {
        echo "Error creating table: " . $conn->error;
    }

    mysqli_close($conn);
?>

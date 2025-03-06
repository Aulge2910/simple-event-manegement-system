<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname="icats-ems";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "CREATE TABLE query (
    query_id int(10) AUTO_INCREMENT NOT NULL UNIQUE,
    user_email VARCHAR(50) NOT NULL,
    user_query varchar(5000) NOT NULL,
    PRIMARY KEY (query_id)
    )";

    if (mysqli_query($conn, $sql)) {
        echo "Table created successfully\n";
    } 
    
    else {
        echo "Error creating table: " . $conn->error;
    }

    mysqli_close($conn);
?>

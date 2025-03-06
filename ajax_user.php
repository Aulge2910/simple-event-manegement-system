<?php
include 'connection.php';

$request = 1;
if(isset($_POST['request'])){
    $request = $_POST['request'];
}

// DataTable data
if($request == 1){
    ## Read value
    $draw = $_POST['draw'];
    $row = $_POST['start'];
    $rowperpage = $_POST['length']; // Rows display per page
    $columnIndex = $_POST['order'][0]['column']; // Column index
    $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
    $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc

    $searchValue = mysqli_escape_string($con,$_POST['search']['value']); // Search value

    ## Search 
    $searchQuery = " ";
    if($searchValue != ''){
        $searchQuery = " and (user_info_id like '%".$searchValue."%' or 
		user_name like '%".$searchValue."%' or 
		user_gender like'%".$searchValue."%' ) ";
    }

    ## Total number of records without filtering
    $sel = mysqli_query($con,"select count(*) as allcount from user_information");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];

    ## Total number of records with filtering
    $sel = mysqli_query($con,"select count(*) as allcount from user_information WHERE 1 ".$searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];

    ## Fetch records
    $empQuery = "select * from user_information WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
    $empRecords = mysqli_query($con, $empQuery);
    $data = array();

    while ($row = mysqli_fetch_assoc($empRecords)) {

        // Update Button
        $updateButton = "<button class='btn btn-sm btn-info updateUser' data-id='".$row['user_info_id']."' data-toggle='modal' data-target='#updateModal' >Update</button>";

        // Delete Button
        $deleteButton = "<button class='btn btn-sm btn-danger deleteUser' data-id='".$row['user_info_id']."'>Delete</button>";
        
        $action = $updateButton." ".$deleteButton;

        $data[] = array(
			"user_info_id"=>$row['user_info_id'],
			"user_name"=>$row['user_name'],
			"user_gender"=>$row['user_gender'],
			"user_email"=>$row['user_email'],
            "user_password"=>$row['user_password'],
 

                "action" => $action
            );
    }

    ## Response
    $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordwithFilter,
        "aaData" => $data
    );

    echo json_encode($response);
    exit;
}

// Fetch user details
if($request == 2){
    $user_info_id = 0;

    if(isset($_POST['user_info_id'])){
        $user_info_id = mysqli_escape_string($con,$_POST['user_info_id']);
    }

    $record = mysqli_query($con,"SELECT * FROM user_information WHERE user_info_id=".$user_info_id);

    $response = array();

    if(mysqli_num_rows($record) > 0){
        $row = mysqli_fetch_assoc($record);
        $response = array(
			"user_info_id"=>$row['user_info_id'],
			"user_name"=>$row['user_name'],
			"user_gender"=>$row['user_gender'],
			"user_email"=>$row['user_email'],
            "user_password"=>$row['user_password'],
 
        );

        echo json_encode( array("status" => 1,"data" => $response) );
        exit;
    }else{
        echo json_encode( array("status" => 0) );
        exit;
    }
}

// Update user
if($request == 3){
    $user_info_id = 0;

    if(isset($_POST['user_info_id'])){
        $user_info_id = mysqli_escape_string($con,$_POST['user_info_id']);
    }

    // Check id
    $record = mysqli_query($con,"SELECT user_info_id FROM user_information WHERE user_info_id=".$user_info_id);
    if(mysqli_num_rows($record) > 0){


        $user_name = mysqli_escape_string($con,trim($_POST['user_name']));
    
        $user_password = mysqli_escape_string($con,trim($_POST['user_password']));
        $user_email = mysqli_escape_string($con,trim($_POST['user_email']));


        if( $user_name != '' && $user_password != '' && $user_email != '' ){

			mysqli_query($con,"UPDATE user_information SET user_name='".$user_name."', user_password='".$user_password."' ,user_email='".$user_email."' WHERE user_info_id=".$user_info_id);

            echo json_encode( array("status" => 1,"message" => "Record updated.") );
            exit;
        }else{
            echo json_encode( array("status" => 0,"message" => "Please fill all fields.") );
            exit;
        }
        
    }else{
        echo json_encode( array("status" => 0,"message" => "Invalid  ID.") );
        exit;
    }
}

// Delete User
if($request == 4){
    $user_info_id = 0;

    if(isset($_POST['user_info_id'])){
        $event_id = mysqli_escape_string($con,$_POST['user_info_id']);
    }

    // Check id
    $record = mysqli_query($con,"SELECT user_info_id FROM user WHERE user_info_id=".$user_info_id);
    if(mysqli_num_rows($record) > 0){

        mysqli_query($con,"DELETE FROM user WHERE user_info_id=".$user_info_id);

        echo 1;
        exit;
    }else{
        echo 0;
        exit;
    }
}
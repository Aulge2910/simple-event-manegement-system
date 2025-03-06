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
        $searchQuery = " and (event_title like '%".$searchValue."%' or 
		event_description like '%".$searchValue."%' or 
		event_id like'%".$searchValue."%' ) ";
    }

    ## Total number of records without filtering
    $sel = mysqli_query($con,"select count(*) as allcount from event");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];

    ## Total number of records with filtering
    $sel = mysqli_query($con,"select count(*) as allcount from event WHERE 1 ".$searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];

    ## Fetch records
    $empQuery = "select * from event WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
    $empRecords = mysqli_query($con, $empQuery);
    $data = array();

    while ($row = mysqli_fetch_assoc($empRecords)) {

        // Update Button
        $updateButton = '<a role="button" href="edit_event.php?event_id='.$row['event_id'].'" class="btn btn-sm btn-info disabled" aria-disabled="true" >Update</a>';

        // Delete Button
        $deleteButton = "<a role='button'  class='btn btn-sm btn-danger deleteUser' data-id='".$row['event_id']."'>Delete</a>";
        
        $action = $updateButton." ".$deleteButton;

        $data[] = array(
			"event_id"=>$row['event_id'],
			"event_title"=>$row['event_title'],
			"event_description"=>$row['event_description'],
			"event_venue_name"=>$row['event_venue_name'],
			"event_start_date"=>$row['event_start_date'],
			"event_end_date"=>$row['event_end_date'],
			"event_start_time"=>$row['event_start_time'],
			"event_end_time"=>$row['event_end_time'],
			"time_range"=>$row['time_range'],
			"slot"=>$row['slot'],
			"user_info_id"=>$row['user_info_id'],
	 

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
    $event_id = 0;

    if(isset($_POST['event_id'])){
        $event_id = mysqli_escape_string($con,$_POST['event_id']);
    }

    $record = mysqli_query($con,"SELECT * FROM event WHERE event_id=".$event_id);

    $response = array();

    if(mysqli_num_rows($record) > 0){
        $row = mysqli_fetch_assoc($record);
        $response = array(
			"event_id"=>$row['event_id'],
			"event_title"=>$row['event_title'],
			"event_description"=>$row['event_description'],
			"event_venue_name"=>$row['event_venue_name'],
			"event_start_date"=>$row['event_start_date'],
			"event_end_date"=>$row['event_end_date'],
			"event_start_time"=>$row['event_start_time'],
			"event_end_time"=>$row['event_end_time'],
			"time_range"=>$row['time_range'],
			"slot"=>$row['slot'],
			"user_info_id"=>$row['user_info_id'],
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
 
    
    $event_id = 0;

    if(isset($_POST['event_id'])){
        $event_id = mysqli_escape_string($con,$_POST['event_id']);
    }

    // Check id
    $record = mysqli_query($con,"SELECT event_id FROM event WHERE event_id=".$event_id);
    if(mysqli_num_rows($record) > 0){


        $event_title = mysqli_escape_string($con,trim($_POST['event_title']));
        $event_description = mysqli_escape_string($con,trim($_POST['event_description']));


        if( $event_title != '' && $event_description != '' ){

			mysqli_query($con,"UPDATE event SET event_title='".$event_title."',event_description='".$event_description."' WHERE event_id=".$event_id);

            echo json_encode( array("status" => 1,"message" => "Record updated.") );
            exit;
        }else{
            echo json_encode( array("status" => 0,"message" => "Please fill all fields.") );
            exit;
        }
        
    }else{
        echo json_encode( array("status" => 0,"message" => "Invalid Event ID.") );
        exit;
    }

    
}

// Delete User
if($request == 4){
    $event_id = 0;

    if(isset($_POST['event_id'])){
        $event_id = mysqli_escape_string($con,$_POST['event_id']);
    }

    // Check id
    $record = mysqli_query($con,"SELECT event_id FROM event WHERE event_id=".$event_id);
    if(mysqli_num_rows($record) > 0){

        mysqli_query($con,"DELETE FROM event WHERE event_id=".$event_id);

        echo 1;
        exit;
    }else{
        echo 0;
        exit;
    }
}
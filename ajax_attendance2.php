<?php
session_start();
include 'connection.php';

$user_id = $_POST['user_id'];
$event_id = $_POST['event_id'];
$event_status = $_POST['event_status'];


## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = mysqli_real_escape_string($con,$_POST['search']['value']); // Search value


## Search 
$searchQuery = " ";
if($searchValue != ''){
	$searchQuery = " and (event_title like '%".$searchValue."%' or 
    event_description like '%".$searchValue."%' or 
    event_start_date like'%".$searchValue."%' ) ";
}



    ## Total number of records without filtering
$sel = mysqli_query($con,"select count(*) as allcount from event_record");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel = mysqli_query($con,"select count(*) as allcount from event_record WHERE 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "select * from event_record 
INNER JOIN user_information 
ON event_record.user_info_id = user_information.user_info_id
INNER JOIN event 
ON event_record.event_id = event.event_id
WHERE event_record.event_id = '$event_id' 
 
".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage; 



$empRecords = mysqli_query($con, $empQuery);
$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {
    $data[] = array(
        "event_title"=>$row['event_title'],
 
 
        "user_name"=>$row['user_name'],
        "user_gender"=>$row['user_gender'],
        "user_email"=>$row['user_email'],
        "check_in_date"=>$row['check_in_date'],
        
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

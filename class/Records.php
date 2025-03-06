<?php
class Records {	
   
	private $recordsTable = 'event';
	public $event_id;
    public $event_title;
    public $event_description;
    public $time_range;
	public $event_start_date;
    public $event_end_date;
	public $slot;
    public $event_start_time;
    public $event_end_time;
	private $conn;
	
	public function __construct($db){
        $this->conn = $db;
    }	    
	
	public function listRecords(){
		
		$sqlQuery = "SELECT * FROM ".$this->recordsTable." ";
		if(!empty($_POST["search"]["value"])){
			$sqlQuery .= 'where(event_id LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR event_title LIKE "%'.$_POST["search"]["value"].'%" ';			
			$sqlQuery .= ' OR event_description LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR time_range LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR event_start_date LIKE "%'.$_POST["search"]["value"].'%") ';			
            $sqlQuery .= ' OR event_end_date LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR slot LIKE "%'.$_POST["search"]["value"].'%") ';	
            $sqlQuery .= ' OR event_start_time LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR event_end_time LIKE "%'.$_POST["search"]["value"].'%") ';	
		}
		
		if(!empty($_POST["order"])){
			$sqlQuery .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		} else {
			$sqlQuery .= 'ORDER BY id DESC ';
		}
		
		if($_POST["length"] != -1){
			$sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}
		
		$stmt = $this->conn->prepare($sqlQuery);
		$stmt->execute();
		$result = $stmt->get_result();	
		
		$stmtTotal = $this->conn->prepare("SELECT * FROM ".$this->recordsTable);
		$stmtTotal->execute();
		$allResult = $stmtTotal->get_result();
		$allRecords = $allResult->num_rows;
		
		$displayRecords = $result->num_rows;
		$records = array();		
		while ($record = $result->fetch_assoc()) { 				
			$rows = array();			
			$rows[] = $record['event_id'];
			$rows[] = ($record['event_title']);
			$rows[] = $record['event_description'];		
			$rows[] = $record['time_range'];	
			$rows[] = $record['event_start_date'];
			$rows[] = $record['event_end_date'];	
            $rows[] = $record['slot'];	
            $rows[] = $record['event_start_time'];	
            $rows[] = $record['event_end_time'];					
 
			$records[] = $rows;
		}
		
		$output = array(
			"draw"	=>	intval($_POST["draw"]),			
			"iTotalRecords"	=> 	$displayRecords,
			"iTotalDisplayRecords"	=>  $allRecords,
			"data"	=> 	$records
		);
		
		echo json_encode($output);
	}
	
	public function getRecord(){
		if($this->event_id) {
			$sqlQuery = "
				SELECT * FROM ".$this->recordsTable." 
				WHERE event_id = ?";			
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->bind_param("i", $this->event_id);	
			$stmt->execute();
			$result = $stmt->get_result();
			$record = $result->fetch_assoc();
			echo json_encode($record);
		}
		}
	}
 
?>
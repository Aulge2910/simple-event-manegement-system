<?php  session_start(); 
if( isset($_SESSION['user_id'])){
  $user_id = $_SESSION['user_id'];

};
if( isset($_SESSION['user_name'])){
  $user_name = $_SESSION['user_name'];
};

?>      

<?php     

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname="icats-ems";
  $conn = mysqli_connect($servername, $username, $password, $dbname);

  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }


  /***retrieved post data */
  $event_id_get =$_POST['event_id'];
  $event_title = $_POST['event_title'];  
  $event_description = $_POST['event_description'];  
  $event_start_date = $_POST['event_start_date'];  
  $result_start = $_POST['result_start'];  
  $result_end = $_POST['result_end'];  
  $event_venue = $_POST['event_venue'];  
  $slot = $_POST['slot'];  
  $time_range = $_POST['time_range'];  
  $filename = $_FILES["event_poster"]["name"];
  $tempname = $_FILES["event_poster"]["tmp_name"];
  $folder = "./images/" . $filename;

  date_default_timezone_set("Asia/Kuching");

  $current_date = new DateTime("now", new DateTimeZone('Asia/Kuching') );
  $current_date = $current_date->format('Y-m-d H:i:sa');

  $result_start=$result_start.":00:00";  
  $result_end=$result_end.":00:00";

  $event_start_date_time = date("Y-m-d H:i:s a", strtotime("$event_start_date $result_start"));
  $event_end_date = date("Y-m-d H:i:s a", strtotime("$event_start_date $result_end"));
  $event_start_date = strtotime ( $event_start_date ); 
  $event_start_date = date ( 'Y-m-d' , $event_start_date ); 
  
  /*** convert time range to array */
  $time_range_result_a= $time_range; 
  $time_range = (explode(",",$time_range));
  /*** convert time range to array */

  /*** get each key value of time range */
  $first_element_a = $time_range[0];
  $length = count($time_range);
  $last_element_a = $time_range[$length-1];
  /*** get each key value of time range */
  $current_event_status = "onhold";
  
             // retrieve old event
             $sql_old_event = "SELECT * FROM event WHERE event_id = '$event_id_get'";  

             $result_old_event = mysqli_query($conn, $sql_old_event);  
           
             //if there is venue booked with selected date 
             if (mysqli_num_rows($result_old_event) ==1 ) {
           
               while($row = mysqli_fetch_assoc($result_old_event)) { 
                 $old_event_id = $row['event_id'];
                 $old_event_time_range= $row['time_range'];
                 $old_event_venue= $row['event_venue_name'];
                 $old_event_selected_date= $row['event_start_date'];  
                 $old_event_time_range= (explode(",",$old_event_time_range));
               }
             };
           
             //retrieve old venue availability
             $sql_old_venue = "SELECT * FROM venue_availability WHERE venue_name = '$old_event_venue' AND selected_date = '$old_event_selected_date'";  
             
             $result_old_venue = mysqli_query($conn, $sql_old_venue);  
           
             //if there is venue booked with selected date 
             if (mysqli_num_rows($result_old_venue) ==1 ) {
           
               while($row = mysqli_fetch_assoc($result_old_venue)) { 
                 $old_venue_time_range= $row['selected_range'];
                 $old_venue_time_range= (explode(",",$old_venue_time_range));
                 $old_length = count($old_event_time_range);
                 $old_found_status ="";
                 $old_exist_value = "";

                
                 $old_event_length = count($old_event_time_range);
                 $old_venue_length = count($old_venue_time_range);


                 $z=0;

                 //last dont delete
                 if($old_event_time_range[$z] == $old_venue_time_range[$z]){   
                  for($a = 0; $a!=$old_event_length-1; $a++){
                    $old_exist_value = $old_event_time_range[$a];  
                    if(($key = array_search($old_exist_value, $old_venue_time_range)) !== false) {
                      unset($old_venue_time_range[$key]);
                    }   
                  }
                 }

                 //first dont delete
                 else if($old_event_time_range[$old_event_length-1] == $old_venue_time_range[$old_venue_length-1]){
                  
                  for($a = $old_event_length-1; $a !=0; $a--){
                    $old_exist_value = $old_event_time_range[$a];   
                    if(($key = array_search($old_exist_value, $old_venue_time_range)) !== false) {
                      unset($old_venue_time_range[$key]);
                    }    
                  }
                 }

                 else {
                  for($x = 0; $x<=$old_length-1; $x++ ) {
                    if (in_array($old_event_time_range[$x], $old_venue_time_range)){
                      $old_exist_value = $old_event_time_range[$x];    
                    }
                    if(($key = array_search($old_exist_value, $old_venue_time_range)) !== false) {
                      unset($old_venue_time_range[$key]);
                    } 
                  }
                 }
                      
                         //merge the array
                         $new_range_updated = $old_venue_time_range;
                         //sort the array
                         sort($new_range_updated);
                         //conver new array to string
                         $new_range_updated2 = $new_range_updated;
                         $new_range_updated = implode(",",$new_range_updated);
           

               }
             };
           
 
  
  //sql check venue availability
  $sql_check_clash = 
  "SELECT * FROM venue_availability 
  WHERE selected_date = '$event_start_date' 
  AND venue_name = '$event_venue'
  ";  

  $result_check_clash = mysqli_query($conn, $sql_check_clash);  

  //if there is venue booked with selected date 
  if (mysqli_num_rows($result_check_clash) ==1 ) {

    while($row = mysqli_fetch_assoc($result_check_clash)) { 
      //get the time_range_b in database
      //convert time_range_b to array
      $time_range_b = $row['selected_range'];
      $time_range_b= (explode(",",$time_range_b));

      //get the first/last element of time_range_b
      $first_element_b = $time_range_b[0];
      $last_element_b = $time_range_b[count($time_range_b)-1];

      $first_element_a = $time_range[0];
      $last_element_a = $time_range[count($time_range)-1];


      $text = "";
      $clash = "";

      //compare input_time_range and database_time_range
      for($x = 0; $x< count($time_range); $x++ ){
        if (in_array($time_range[$x], $time_range_b)){
          //if input time range exist in database time range, text +=Y
          $text.="Y ";
        }
        else {
          $text.="N ";
        }
      }

      $input_string = $text; 

      //sub string to be checked 
      $sub = "Y"; 
      $result ="";

      
      //check if Y exist in text or inputstring
      if (strpos($input_string, $sub) !== false){ 
        $result.="true";
      
      } 
      else { 
        $result.="false";
      } 
      

      $my_count = substr_count($input_string,"Y");

      //if y exist, that is result == true, clash ==true, else clash == false
      if($result =="true"){
        $clash = "true";

        if($last_element_a == $first_element_b || $first_element_a == $last_element_b 
        ||( $my_count == 1 && substr($input_string, -2) =="Y" ) ||
        ( $my_count == 1 && substr($input_string,0,1) =="Y" ) 
        ){
          $clash="false";
        }
      }

      else if($result == "false"){
        $clash = "false";
      };

      //check the clash status
      if( $clash == "true"){
        echo"<script> alert('Record Clash ');window.location.assign('manage_event.php') </script>;  ";
      }

      //if not clash, can add the record the venue availability and create event
      else if( $clash == "false" ){

        //get the time range from database
        $time_range_b = $row['selected_range'];
        $time_range_b= (explode(",",$time_range_b)); //change to array

        $length = count($time_range);
        $found_status ="";
        $exist_value = "";

        //try to get the time range and merge the range

        for($x = 0; $x<=$length-1; $x++ ) {
          if (in_array($time_range[$x], $time_range_b)){
            $found_status.="F";
            $exist_value = $time_range[$x];
          }
          else {
            $found_status.="N";
          }
        }

        //if found same element, unset either one, else dont unset
        if(($key = array_search($exist_value, $time_range)) !== false) {
          unset($time_range[$key]);
        }
        
        //merge the array
        $new_range = array_merge($time_range,$time_range_b);  
        $final_range = array_merge($new_range_updated2,$time_range);
        //sort the array
       
        sort($final_range);

        $final_range = implode(",",$final_range); 
        sort($new_range);
        //conver new array to string
        $new_range = implode(",",$new_range);

  
        $range_removed_old = $new_range_updated;
        $range_merge = array_merge($time_range,$new_range_updated2);
        sort($range_merge);
        $range_merge = implode(",",$range_merge); 

        
        //get the venue_id
        $venue_id = $row['venue_availability_id'];
        $time_range_b = $row['selected_range'];


        $sql_insert = "
        UPDATE venue_availability SET selected_range ='$range_merge' where venue_name ='$event_venue' and selected_date 
        ='$event_start_date' 
        ";
  

        if (mysqli_query($conn, $sql_insert)) {
          echo"<script> alert('Record Updated'); </script>";
          $sql_insert2 = 
          "UPDATE event SET 
          event_start_date ='$event_start_date' , 
          event_end_date ='$event_end_date', 
          event_title ='$event_title',
          event_description  ='$event_description',
          event_venue_name ='$event_venue',
          event_image ='$filename',
          slot ='$slot',
          event_start_time ='$result_start',
          event_end_time ='$result_end',
          time_range ='$time_range_result_a',
          event_status  ='$current_event_status', 
          event_start_datime = '$event_start_date_time'
          where event_id ='$event_id_get'
          ";

          if (mysqli_query($conn, $sql_insert2)) {
            echo"<script> alert('Event Updated'); window.location.assign('manage_event.php')</script>";
 
        }
          else {
            echo "Error: " . $sql_insert2 . "<br>" . mysqli_error($conn);
          }
        }
        else {
          echo "Error: " . $sql_insert . "<br>" . mysqli_error($conn);
        }
      }
    }
  }

  else if (mysqli_num_rows($result_check_clash) == 0 ) {
 
 
    $sql_event = 
    "UPDATE event SET 
    event_start_date ='$event_start_date', 
    event_end_date ='$event_end_date', 
    event_title ='$event_title',
    event_description  ='$event_description',
    event_venue_name ='$event_venue',
    event_image ='$filename',
    slot ='$slot',
    event_start_time ='$result_start',
    event_end_time ='$result_end',
    time_range ='$time_range_result_a',
    event_status  ='$current_event_status',
    event_start_datime = '$event_start_date_time'
    where event_id ='$event_id_get'";


if (mysqli_query($conn, $sql_event)) {
  echo"<script> alert('Event Record Inserted'); </script>";
  $sql_insert = " INSERT INTO venue_availability (venue_name, selected_date,	selected_range) VALUES
  ('$event_venue','$event_start_date','$time_range_result_a')";


  if (mysqli_query($conn, $sql_insert)) {
    echo"<script> alert('Venue Availability Record Inserted'); </script>";


    $sql_update_old ="
    
    update venue_availability set selected_range = '$new_range_updated' 
    where venue_name='$old_event_venue'
    and selected_date ='$old_event_selected_date'";

    if (mysqli_query($conn, $sql_update_old)) {
      echo"<script> alert('Venue Availability Record Updated');  window.location.assign('manage_event.php') </script>";

    }
    else {
      echo "Error: " . $sql_insert . "<br>" . mysqli_error($conn);
    }

  }
  else {
    echo "Error: " . $sql_insert . "<br>" . mysqli_error($conn);
  }
}

else {
  echo "Error: " . $sql_event . "<br>" . mysqli_error($conn);
}		
};
mysqli_close($conn);
  
?>  
 

 
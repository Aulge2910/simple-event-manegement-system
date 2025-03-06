<?php  session_start(); 

  if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
  };

  if(isset($_SESSION['user_name'])){
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
  $new_event_time_range = $_POST['time_range'];  
  $filename = $_FILES["event_poster"]["name"];
  $tempname = $_FILES["event_poster"]["tmp_name"];
  $folder = "./images/" . $filename;
  $time_range_insert = $_POST['time_range'];
 
  date_default_timezone_set("Asia/Kuching");

  $current_date = new DateTime("now", new DateTimeZone('Asia/Kuching') );
  $current_date = $current_date->format('Y-m-d H:i:sa');

  $result_start=$result_start.":00:00";  
  $result_end=$result_end.":00:00";

  $event_start_date_time = date("Y-m-d H:i:s a", strtotime("$event_start_date $result_start"));
  $event_end_date = date("Y-m-d H:i:s a", strtotime("$event_start_date $result_end"));
  $event_start_date = strtotime ( $event_start_date ); 
  $event_start_date = date ( 'Y-m-d' , $event_start_date ); 
  
  $new_event_time_range = explode(",",$new_event_time_range);

  $sql_old_event = "SELECT * FROM event WHERE event_id = '$event_id_get'";
  $result_old_event = mysqli_query($conn, $sql_old_event);  
    
  if (mysqli_num_rows($result_old_event) ==1 ) {

    while($row = mysqli_fetch_assoc($result_old_event)) { 
      $old_event_id = $row['event_id'];
      $old_event_time_range= $row['time_range'];
      $old_event_venue= $row['event_venue_name'];
      $old_event_selected_date= $row['event_start_date'];  
      $old_event_time_range= (explode(",",$old_event_time_range));        
      $old_event_length = count($old_event_time_range);
    }
  };

  $sql_old_venue = "SELECT * FROM venue_availability WHERE venue_name = '$old_event_venue' AND selected_date = '$old_event_selected_date'";  
  $result_old_venue = mysqli_query($conn, $sql_old_venue);  

  if (mysqli_num_rows($result_old_venue) ==1 ) {

    while($row = mysqli_fetch_assoc($result_old_venue)) { 
      $old_venue_id = $row['venue_availability_id'];
      $old_venue_name = $row['venue_name'];
      $old_selected_date = $row['selected_date'];
      $old_venue_time_range= $row['selected_range'];
      $old_venue_time_range= (explode(",",$old_venue_time_range));

      $old_v_r_t= $old_venue_time_range;
      $old_event_length = count($old_event_time_range);
      $old_found_status ="";
      $old_exist_value = "";
      $old_venue_length = count($old_venue_time_range);
    }
  }

  
  /*** get each key value of time range */
  
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
        $venue_availability_id = $row['venue_availability_id'];
        $time_range_in_table = $row['selected_range'];
        $time_range_in_table= (explode(",",$time_range_in_table));
  
        //get the first/last element of time_range_in_table
        $first_element_b = $time_range_in_table[0];
        $last_element_b = $time_range_in_table[count($time_range_in_table)-1];
        
        $time_range_input = (explode(",",$time_range));
        $first_element_a = $time_range_input[0];
        $last_element_a = $time_range_input[count($time_range_input)-1];
  
        $found_or_not = "";
        $clash = "";

        //check clash
        for($x = 0; $x< count($time_range_input); $x++ ){
          if (in_array($time_range_input[$x], $time_range_in_table)){
            //if input time range exist in database time range, text +=Y
            $found_or_not.="Y ";
          }
          else {
            $found_or_not.="N ";
          }
        }

        $input_string = $found_or_not; 
        $find_Y_in_text = "Y"; 
        $check_clash_result ="";
  
        //check if Y exist in text or inputstring
        if (strpos($input_string, $find_Y_in_text) !== false){ 
          $check_clash_result.="true";
        } 
  
        else { 
          $check_clash_result.="false";
        } 
     
        $count_times_of_Y = substr_count($input_string,"Y");
        $first_char = substr($input_string,0,1);    
        $last_char = substr($input_string,-2,1);

        //if y exist, that is result == true, clash ==true, else clash == false
        if($check_clash_result =="true"){
          if(
            $last_element_a == $first_element_b || 
            $first_element_a == $last_element_b ||
            ( $count_times_of_Y == 1 && $last_char=="Y" ) ||
            ( $count_times_of_Y == 1 && $first_char =="Y" ) ||
            ( $count_times_of_Y == 2 && $first_char =="Y" && $last_char=="Y"))
          {
            $clash="false";
          }

          else {
            $clash = "true";
          }
        }

        else if($check_clash_result == "false"){
          $clash = "false";
        }
  

        //check the clash status
        if( $clash == "true"){
          echo"<script> alert('Record Clash ');window.location.assign('manage_event.php')  </script>;  ";
        }

        /****
         * 
         * 
         * 
         * 
         * 
         * 
         * 
         * 
         */

        else if( $clash == "false" ){

        //get the time range from database
        $time_range_in_table = $row['selected_range'];
        $time_range_in_table= (explode(",",$time_range_in_table)); //change to array

        $old_event_range_length = count($old_event_time_range);

        $found_status ="";
        $exist_value = "";


        //used to insert the venue data, 
        //try to get the time range and merge the range
        /*** */
        for($x = 0; $x<=$old_event_range_length-1; $x++ ) {
          if (in_array($time_range[$x], $time_range_in_table)){
            $found_status.="F";
            $exist_value = $time_range[$x];
                    //if found same element, unset either one, else dont unset
              if(($key = array_search($exist_value, $time_range)) !== false) {
                unset($time_range[$key]);
              }
          }
          else {
            $found_status.="N";
          }
        }

 

      // check the old event input to remove it
        if($clash == "false"){
       
          $new_event_time_range = $_POST['time_range'];
          $new_event_time_range = explode(",",$new_event_time_range);
  
          $z = 0;
  
          $last_element_plus1 = (int)($old_event_time_range[$old_event_length-1])+1;
          $first_element_minus1 = (int)($old_event_time_range[$old_event_length-$old_event_length])-1;
  
          $last_element_plus1 = (string)$last_element_plus1;
          $first_element_minus1 = (string)$first_element_minus1;
  

          // array delete except last index element
          if (in_array($last_element_plus1, $old_venue_time_range)  && $last_element_plus1!="13"){
            for($x = 0; $x!=$old_event_length-1; $x++ ) {
              $old_exist_value = $old_event_time_range[$x];
              if(($key = array_search($old_exist_value, $old_venue_time_range)) !== false) {
                unset($old_venue_time_range[$key]);
              }  
            } 
          }

          // array delete except first index element
          else if(in_array($first_element_minus1, $old_venue_time_range)&& $first_element_minus1!="12"){
            for($x = $old_event_length-1; $x!=0; $x-- ) {
              $old_exist_value = $old_event_time_range[$x];
              if(($key = array_search($old_exist_value, $old_venue_time_range)) !== false) {
                unset($old_venue_time_range[$key]);
              }  
            } 
          }          
          
          else if (in_array($last_element_plus1, $old_venue_time_range) && $last_element_plus1=="13"){
            for($x = 0; $x<=$old_event_length-1; $x++ ) {
              $old_exist_value = $old_event_time_range[$x];
              if(($key = array_search($old_exist_value, $old_venue_time_range)) !== false) {
                unset($old_venue_time_range[$key]);
              }  
            } 
          }
          // array delete except all index element
          else if(in_array($first_element_minus1, $old_venue_time_range)&& $first_element_minus1=="12"){
            for($x = 0; $x<=$old_event_length-1; $x++ ) {
              $old_exist_value = $old_event_time_range[$x];
              if(($key = array_search($old_exist_value, $old_venue_time_range)) !== false) {
                unset($old_venue_time_range[$key]);
              }  
            } 
          }
        
        else if(!in_array($first_element_minus1, $old_venue_time_range)&& !in_array($last_element_plus1, $old_venue_time_range)){
          for($x = 0; $x<=$old_event_length-1; $x++ ) {
            $old_exist_value = $old_event_time_range[$x];
            if(($key = array_search($old_exist_value, $old_venue_time_range)) !== false) {
              unset($old_venue_time_range[$key]);
            }  
          } 
        }
      }
      

        sort($old_venue_time_range);

        /*** 
        echo " <br>first : ".$old_venue_time_range[0];
        echo " <br>second : ".$old_venue_time_range[1];
        echo " <br>third : ".$old_venue_time_range[2];

        echo " <br>a : ".$new_event_time_range[0];
        echo " <br>b : ".$new_event_time_range[1];
        echo " <br>c : ".$new_event_time_range[2];
    */

        //inser to old venue timerange 
        $insert_old_venue_range = $old_venue_time_range;


        //check for new event time range input 
        
        $new_event_time_range_length = count($new_event_time_range);
        
        for($x = 0; $x<=$new_event_time_range_length-1; $x++ ) {
          if (in_array($new_event_time_range[$x], $old_venue_time_range)){ 
            $exist_value = $new_event_time_range[$x];
                    //if found same element, unset either one, else dont unset
              if(($key = array_search($exist_value, $new_event_time_range)) !== false) {
                unset($new_event_time_range[$key]);
              }
          }
        }

        $insert_new_venue_range = array_merge($insert_old_venue_range, $new_event_time_range);
        sort($insert_new_venue_range);

   
        $insert_new_venue_range = implode(",",$insert_new_venue_range);
        $insert_old_venue_range = implode(",",$insert_old_venue_range);


      $new_time_range2 = $_POST['time_range'];
      $old_v_r_t;
      for($x = 0; $x<=count($old_v_r_t)-1; $x++ ) {
        if (in_array($new_time_range2[$x], $old_v_r_t)){
          $exist_value = $new_time_range2[$x];
                  //if found same element, unset either one, else dont unset
            if(($key = array_search($exist_value, $new_time_range2)) !== false) {
              unset($new_time_range2[$key]);
            }
        }
      }

      $insert_new3 = array_merge($new_time_range2,$old_v_r_t);
      sort($insert_new3);
      $insert_new3 = implode(",",$insert_new3);



//change to same date
    if($old_venue_id == $venue_availability_id){
      $sql_update_new_venue = 
      "UPDATE venue_availability SET selected_range = '$insert_new_venue_range' WHERE venue_availability_id='$venue_availability_id'";
      if (mysqli_query($conn, $sql_update_new_venue)){
        echo"<script> alert('Same Date Venue'); </script>";    
      }
      else {
        echo "Error: " . $sql_update_new_venue ."<br>" . mysqli_error($conn);
      }
    }

    //change to new date 
    else {
      $sql_update_old =
      "UPDATE venue_availability SET selected_range = '$insert_old_venue_range' WHERE venue_availability_id='$old_venue_id'";

      $sql_update_new_venue = 
      "UPDATE venue_availability SET selected_range = '$insert_new_venue_range' WHERE venue_availability_id='$venue_availability_id'";      
      
      if (mysqli_query($conn, $sql_update_old)) {
        echo"<script> alert('Diff Venue Updated'); </script>";      
        if(mysqli_query($conn, $sql_update_new_venue)){
          echo"<script> alert('Diff Event & Venue Updated');</script>";
        }
        else {
          echo "<br>Error: ".$sql_update_old."<br>" . mysqli_error($conn);
        }
      }    
      else {
        echo "<br>Error: ".$sql_update_new_venue."<br>" . mysqli_error($conn);
      }
    }



      $sql_update_new_event =
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
      time_range ='$time_range_insert',
      event_start_datime = '$event_start_date_time'
      where event_id ='$event_id_get'
      ";

      if (mysqli_query($conn, $sql_update_new_event)){
        echo"<script> alert('Event Updated');window.location.assign('manage_event.php') </script>";    

      }   
      else {
        echo "Error: " . $sql_update_new_event ."<br>" . mysqli_error($conn);
      }
    }
  }
}
      


// window.location.assign('manage_event.php')

//change to new date, new place
  else if (mysqli_num_rows($result_check_clash) == 0 ) {
    $new_event_time_range = $_POST['time_range'];
    $new_event_time_range = explode(",",$new_event_time_range);

    $z = 0;

    $last_element_plus1 = (int)($old_event_time_range[$old_event_length-1])+1;
    $first_element_minus1 = (int)($old_event_time_range[$old_event_length-$old_event_length])-1;

    $last_element_plus1 = (string)$last_element_plus1;
    $first_element_minus1 = (string)$first_element_minus1;


    // array delete except last index element
    if (in_array($last_element_plus1, $old_venue_time_range)  && $last_element_plus1!="13"){
      for($x = 0; $x!=$old_event_length-1; $x++ ) {
        $old_exist_value = $old_event_time_range[$x];
        if(($key = array_search($old_exist_value, $old_venue_time_range)) !== false) {
          unset($old_venue_time_range[$key]);
        }  
      } 
    }

    // array delete except first index element
    else if(in_array($first_element_minus1, $old_venue_time_range)&& $first_element_minus1!="12"){
      for($x = $old_event_length-1; $x!=0; $x-- ) {
        $old_exist_value = $old_event_time_range[$x];
        if(($key = array_search($old_exist_value, $old_venue_time_range)) !== false) {
          unset($old_venue_time_range[$key]);
        }  
      } 
    }          
    
    else if (in_array($last_element_plus1, $old_venue_time_range) && $last_element_plus1=="13"){
      for($x = 0; $x<=$old_event_length-1; $x++ ) {
        $old_exist_value = $old_event_time_range[$x];
        if(($key = array_search($old_exist_value, $old_venue_time_range)) !== false) {
          unset($old_venue_time_range[$key]);
        }  
      } 
    }
    // array delete except all index element
    else if(in_array($first_element_minus1, $old_venue_time_range)&& $first_element_minus1=="12"){
      for($x = 0; $x<=$old_event_length-1; $x++ ) {
        $old_exist_value = $old_event_time_range[$x];
        if(($key = array_search($old_exist_value, $old_venue_time_range)) !== false) {
          unset($old_venue_time_range[$key]);
        }  
      } 
    }
  
  else if(!in_array($first_element_minus1, $old_venue_time_range)&& !in_array($last_element_plus1, $old_venue_time_range)){
    for($x = 0; $x<=$old_event_length-1; $x++ ) {
      $old_exist_value = $old_event_time_range[$x];
      if(($key = array_search($old_exist_value, $old_venue_time_range)) !== false) {
        unset($old_venue_time_range[$key]);
      }  
    } 
  }



  sort($old_venue_time_range);
 

  //inser to old venue timerange 
  $insert_old_venue_range = $old_venue_time_range;


  //check for new event time range input 
  
  $new_event_time_range_length = count($new_event_time_range);
  
  for($x = 0; $x<=$new_event_time_range_length-1; $x++ ) {
    if (in_array($new_event_time_range[$x], $old_venue_time_range)){ 
      $exist_value = $new_event_time_range[$x];
              //if found same element, unset either one, else dont unset
        if(($key = array_search($exist_value, $new_event_time_range)) !== false) {
          unset($new_event_time_range[$key]);
        }
    }
  }

  $insert_new_venue_range = array_merge($insert_old_venue_range, $new_event_time_range);
  sort($insert_new_venue_range);


  $insert_new_venue_range = implode(",",$insert_new_venue_range);
  $insert_old_venue_range = implode(",",$insert_old_venue_range);

 
    $sql_update_old ="UPDATE venue_availability SET selected_range = '$insert_old_venue_range' WHERE venue_availability_id='$old_venue_id'";
    $sql_insert_new = " INSERT INTO venue_availability (venue_name, selected_date,	selected_range) VALUES
    ('$event_venue','$event_start_date','$time_range_insert')";


    $sql_update_new_event =
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
    time_range ='$time_range_insert',
    event_start_datime = '$event_start_date_time'
    where event_id ='$event_id_get'
    ";

  if ((mysqli_query($conn, $sql_update_old)) && (mysqli_query($conn, $sql_insert_new)) && (mysqli_query($conn, $sql_update_new_event)) ){
    echo"<script> alert('New Event & Venue Updated'); window.location.assign('manage_event.php')</script>";

}
  else {
    echo "Error: " . $sql_update_old ."Error: ".$sql_insert_new."Error: ".$sql_update_new_event."<br>" . mysqli_error($conn);
  }
};
mysqli_close($conn);
  
?>  
 

 
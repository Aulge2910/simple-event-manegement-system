<!DOCTYPE html>
<?php

session_start();

if( isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    $user_name= $_SESSION['user_name'];
};



require_once __DIR__ . './lib/perpage.php';
require_once __DIR__ . './lib/DataSource.php';
$database = new DataSource();

$event_search_title= "";
$event_search_id = "";

//$queryCondition = "WHERE user_info_id ='$user_id'";
if (! empty($_POST["search"])) {
    foreach ($_POST["search"] as $k => $v) {
        if (! empty($v)) {

            $queryCases = array(
                "event_search_title",
                "event_search_id"
            );
            if (in_array($k, $queryCases)) {
                if (! empty($queryCondition)) {
                    $queryCondition .= " AND ";
                } else {
                    $queryCondition .= " WHERE ";
                }
            }
            switch ($k) {
                case "event_search_title":
                    $event_search_title = $v;
                    $queryCondition .= "event_title LIKE '" . $v . "%'";
                    break;
                case "event_search_id":
                    $event_search_id = $v;
                    $queryCondition .= "event_id LIKE '" . $v . "%'";
                    break;
            }
        }
    }
}


if(isset($_POST['sort_by_date'])) {
    $sort_by_date = $_POST['sort_by_date'];
    $orderby=   "ORDER BY event.event_start_date asc";
}
else if(isset($_POST['sort_by_time'])) {
    $sort_by_time = $_POST['sort_by_time'];
    $orderby=   "ORDER BY event.event_start_time asc";
}
else if(isset($_POST['sort_by_id'])) {
    $sort_by_id = $_POST['sort_by_id'];
    $orderby=   "ORDER BY event.event_id asc";
}
 else {
    $orderby = " ORDER BY event.event_id asc";
}


if(isset($_POST['attended_event'])) {
    $event_status="attended";
    $queryCondition = " where event_record.user_info_id = '$user_id'";
    $sql = "SELECT *
    FROM event_record

    INNER JOIN event
        ON event_record.event_id = event.event_id
    INNER JOIN user_information
        ON event_record.user_info_id = user_information.user_info_id

" . $queryCondition;

}
else if(isset($_POST['own_event'])) {
    $event_status="own";

    $queryCondition = "WHERE event.user_info_id ='$user_id'";
    $sql = "SELECT * FROM event 
    INNER JOIN user_information
    ON  event.user_info_id = user_information.user_info_id
    
    " . $queryCondition;
}

else {

    $event_status="own";
    $queryCondition = "WHERE event.user_info_id ='$user_id'";
    $sql = "SELECT * FROM event 
    INNER JOIN user_information
    ON  event.user_info_id = user_information.user_info_id
    
    " . $queryCondition;
}

 


$href = 'event_paginate.php';

$perPage = 9;
$page = 1;
if (isset($_POST['page'])) {
    $page = $_POST['page'];
}
$start = ($page - 1) * $perPage;
if ($start < 0)
    $start = 0;

$query = $sql . $orderby . " limit " . $start . "," . $perPage;
$result = $database->select($query);

if (! empty($result)) {
    $result["perpage"] = showperpage($sql, $perPage, $href);
}


?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> <!-- jquery-->
        <script src="js/script.js" defer></script>
        <script src="js/bootstrap.min.js"></script><!-- bootstrap min js -->

        <link rel="stylesheet" href="css/bootstrap.min.css"> <!-- bootstrap min css -->
        <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900" rel="stylesheet"> <!-- font -->
        <link rel="stylesheet" href="css/icon-font.css"> <!-- icon-font -->
        <link rel="stylesheet" href="css/style.css"> <!-- style.css -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> <!-- font awesome-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">  <!-- bootstrap5 icon -->
        <link rel="shortcut icon" type="image/png" href="img/favicon.png">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/> <!-- font awesome-->
        
        <title>i-CATS EMS</title>
        <script>
    
        function fetchdata(){ 
            $.ajax({ 
                url: 'check_event_status.php', 
                type: 'post', 
                complete:function(data){ 
                    setTimeout(fetchdata,2000); 
                } 
            }); 
            } 
        $(window).on('load', function(){
            setTimeout(fetchdata,2000); 
        });

        </script>
    </head>
    <body>
        <!-- header -->
        <header class="container-fluid my-header">
            <div class="container mx-auto">
                <div class="row">
                <!-- header logo -->
                    <div class="col-sm-3 my-header__logo-box">
                        <a href="index.php"><img src="img/icats-logo.png" alt="brand logo" class="my-header__logo"></a>
                    </div>
                <!--header overlay navbar -->
                    <div class="col-sm my-header__navbar ">
                        <div class="my-header__navbar-navigation">

                            <!-- nav checkbox hack -->
                            <input type="checkbox" class="my-header__navbar-checkbox" id="navi-toggle">
                            <label for="navi-toggle" class="my-header__navbar-button">
                                <span class="my-header__navbar-icon">&nbsp;</span>
                            </label>
                
                            <!-- overlay background on toggle -->
                            <div class="my-header__navbar-background">&nbsp;</div>
                
                            <!-- nav list item -->
                            <nav class="my-header__navbar-nav">
                                <ul class="my-header__navbar-list">
                                    <li class="my-header__navbar-item"><a href="index.php" class="my-header__navbar-link"><span>01</span>Home</a></li>
                                    <li class="my-header__navbar-item"><a href="index.php#about_us" class="my-header__navbar-link"><span>02</span>About Us</a></li>
                                    <li class="my-header__navbar-item"><a href="index.php#contact_us" class="my-header__navbar-link"><span>03</span>Contact Us</a></li>
                                    <li class="my-header__navbar-item"><a href="event_paginate.php" class="my-header__navbar-link"><span>04</span>Events</a></li>
                                    <li class="my-header__navbar-item"><a href="sign_up.html" class="my-header__navbar-link"><span>05</span>Sign Up</a></li>
                                    <?php 
                                    if(isset($_SESSION['user_logged'])){
                                        echo '<li class="my-header__navbar-item"><a href="logout_user.php" class="my-header__navbar-link"><span>05</span>Log Out</a></li>';
                                    }
                                    ?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        
        <section class="container-fluid ">
            <div class="container ">
            <form name="frmSearch" method="post" action="">
                       
                <div class="row u-margin-big d-flex justify-content-center">
                    <div class="col-xl-10 p-4" >
                        <div class="row">
                            <div class="col-lg col-md-3 col-sm-3 text-center p-2">
                                <button name ="sort_by_date" class="btn my-btn disabled fw-bold">Sort By</button>
                            </div>
                            <div class="col-lg col-md-3 col-sm-3 text-center p-2">
                                <button name ="sort_by_date" class="btn my-btn btn-outline-dark border">Date</button>
                            </div>
                            <div class="col-lg col-md-3 col-sm-3 text-center p-2">
                                <button name ="sort_by_time" class="btn my-btn btn-outline-dark border">Time</button>
                            </div>
                            <div class="col-lg col-md-3 col-sm-3 text-center p-2" >
                                <button name ="sort_by_id" class="btn my-btn btn-outline-dark border">Id</button>
                            </div>
                            <div class="col-lg col-md-6 col-sm-6 text-center p-2">
                                <button name ="own_event" class="btn my-btn border" style="background-color: #FFD966">Own Event</button>
                            </div>
                            <div class="col-lg col-md-6 col-sm-6 text-center p-2">
                                <button name ="attended_event" class="btn my-btn border p-4" style="background-color: #7F6000">Attended Event</button>
                            </div>
                        </div>
                    </div>
                    <div class="w-100"></div>
                </div>

                <?php
                if (! empty($result)) {
                    foreach ($result as $key => $value) {
                        if (is_numeric($key)) {
                ?>
                <?php echo '
                    <div class="row border u-margin-big d-flex justify-content-center align-item-center" style="border-radius: 15px; ">
                        <div class="col-lg-4 col-md p-2 d-flex justify-content-center align-item-center   " style="border-radius: 15px;" >  
                    ';
                ?><img style="width:100%; height:100%; border-radius:10px; object-fit: cover" src="./images/<?php echo $result[$key]["event_image"]?>">
               
                                
                <?php
                    echo '
                        </div>
                            
                        <div class="col-lg-5 col-md p-5 " style="border-radius: 15px;">
                            <h2 class="fw-bold">Event Id: </h2> <span>';?><?php echo $result[$key]["event_id"]; ?><?php echo'</span>
                            <h2 class="fw-bold">Event Title: </h2> <span>';?><?php echo $result[$key]["event_title"]; ?><?php echo'</span>
                            <h2 class="fw-bold">Event Description: </h2><span>';?><?php echo $result[$key]["event_description"]; ?><?php echo'</span>
                            <h2 class="fw-bold">Event Venue: </h2><span>';?><?php echo $result[$key]["event_venue_name"]; ?><?php echo'</span>
                            <h2 class="fw-bold">Event Start Date: </h2><span>';?><?php echo $result[$key]["event_start_date"]; ?><?php echo'</span>
                            <h2 class="fw-bold">Event End Date: </h2><span>';?><?php echo $result[$key]["event_end_date"]; ?><?php echo'</span>
                        </div>

                        <div class="col-lg-3 col-md p-5 " style="border-radius: 15px;">   
        
                        ';
                             
                            if($event_status=="own") { 
                                echo '     
                                <a href="event_agenda_report.php?event_status='.$event_status.'&event_id='.$result[$key]["event_id"].'&user_id='.$user_id.'" id="event_report" class="btn m-2 my-btn btn-outline-dark">Event Report</a>
                                <a href="event_agenda_attendance2.php?event_status='.$event_status.'&event_id='.$result[$key]["event_id"].'&user_id='.$user_id.'" id="attendance_report"class="btn m-2 my-btn btn-outline-dark">Attendance Report</a>
                                <a href="event_agenda_feedback.php?event_status='.$event_status.'&event_id='.$result[$key]["event_id"].'&user_id='.$user_id.'" id="feedback_report"class="btn m-2 my-btn btn-outline-dark">Feedback Report</a>
                                   ';  
                                   
                            }
                            else if($event_status=="attended") { 
                                echo '
                                <a href="event_agenda_report.php?event_status='.$event_status.'&event_id='.$result[$key]["event_id"].'&user_id='.$user_id.'" id="event_report" class="btn m-2 my-btn btn-outline-dark">Event Report</a>
                                <a href="event_agenda_feedback_fill.php?event_status='.$event_status.'&event_id='.$result[$key]["event_id"].'&user_id='.$user_id.'" id="feedback_form"class="btn m-2 my-btn btn-outline-dark">Fill Feedback</a>
                                  ';
                            }
                            echo'
                        </div>
                    </div>           
                ';
            
                        }
                    } 
                };
                
                ?><?php         
                    if (isset($result["perpage"])) {
                        echo '
                    <div class="row d-flex text-center">
                        <span class="" style="">';?><?php echo $result["perpage"]; ?><?php echo'</span>
                    </div>
                    ';
                    };
                ?> 
            </form> 
        </div>
    </section>
        <!-- footer -->
        <footer class="container-fluid my-footer">
            <div class="row p-4">
                <!-- col 1 -> logo+address -->
                <div class="col-lg-4 p-4">
                    <div class="my-footer__logo-box d-flex">
                        <img src="img/icats-logo.png" alt="brand logo" class="my-footer__logo">
                    </div>
                    <h3 class="u-margin-huge">
                        <span class="text-white text-center d-block">
                            Jalan Stampin Timur, 93350 Kuching, Sarawak
                        </span>
                    </h3>
                </div>
                <!-- col 2 -> navlink -->
                <div class="col-lg-4 p-4">
                    <h3 class="u-margin-big">
                        <span class="display-2 fw-bold my-text--linear-light my-text--skewed text-center d-block">About Us</span>
                    </h3>
                    <h3>
                        <ul class="my-footer__navigation-list text-center">
                            <li class="my-footer__navigation-item"><a class="my-footer__navigation-link" href="#about_us">About Us</a></li>
                            <li class="my-footer__navigation-item"><a class="my-footer__navigation-link" href="#contact_us">Contact Us</a></li>
                            <li class="my-footer__navigation-item"><a class="my-footer__navigation-link" href="#">Events</a></li>
                            <li class="my-footer__navigation-item"><a class="my-footer__navigation-link" href="sign_up.html">Sign Up</a></li>
                        </ul>
                    </h3>
                </div>
                <!-- col 3 map-location-->
                <div class="col-lg-4 p-4">
                    <h3 class="u-margin-big">
                        <span class="display-2 fw-bold my-text--linear-light my-text--skewed d-block text-center">Location</span>
                    </h3>
                  
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7106.540389587955!2d110.3515659075162!3d1.5218468193526187!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31fba7695c4218c1%3A0xcf2852a18e05065!2si-CATS%20UNIVERSITY%20COLLEGE!5e0!3m2!1sen!2smy!4v1694423820499!5m2!1sen!2smy"
                     height="300px" style="border:0;" allowfullscreen="" width="100%" 
                     loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                 
                    </iframe>
                </div>
            </div>
        </footer>
    </body>
</html>
    

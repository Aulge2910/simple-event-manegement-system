<?php 

session_start();
date_default_timezone_set('Asia/Kuching');
$current = new DateTime();
if( isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    $user_name = $_SESSION['user_name'];
    $admin_status = $_SESSION['admin_status'];
}

else if( !isset($_SESSION['user_id'])){
    echo"<script> alert('Please Login To Proceed'); window.location.assign('sign_in.html');  </script>";
};

require_once __DIR__ . './lib/perpage.php';
require_once __DIR__ . './lib/DataSource.php';
$database = new DataSource();

$event_search_title= "";
$event_search_id = "";

$queryCondition = "Where (event_status = 'onhold' or  event_status = 'ongoing')";
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
                    $queryCondition .= " AND ";
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
$orderby = " ORDER BY event_id asc";
$sql = "SELECT * FROM event " . $queryCondition;
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
<html>    
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
    </head>
 
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

        <section class="container-fluid u-margin-huge">
            <div class="container u-margin-big" style="background: rgba(205,205,205, 0.3)">
                <div class="row p-4">
                    <div class="col-xl-6 col-md-12 p-4">
                        <h1><span class="display-2 fw-bold">Events</span></h1>
                    </div>
                </div>
                <div class="row p-4">
                    <div class="my-divider"></div>
                </div>
                <div class="row p-4">
                    <div class="col-md-10 col-sm-12 d-flex justify-content-center flex-wrap mx-auto">
                        <?php echo'
                            <a href="event_agenda.php?user_name='.$user_name.'&user_id='.$user_id.'" rolel="button"  style=" " class=" btn my-btn border m-2 my-btn--dark-blue">Event Agenda</a>
                            <a href="create_event.php?user_name='.$user_name.'&user_id='.$user_id.'" rolel="button" style=" "class=" btn my-btn border m-2 my-btn--dark-blue">Create Event</a>
                        ';?>
                            
                        <?php if($admin_status == 1) {
                        echo'
                            <a href="manage_event.php?user_name='.$user_name.'&user_id='.$user_id.'" rolel="button"  style=" " class=" btn my-btn border m-2 my-btn--dark-blue">Manage Event</a>
                            <a href="manage_user.php?user_name='.$user_name.'&user_id='.$user_id.'" rolel="button" style=" "class=" btn my-btn border m-2 my-btn--dark-blue">Manage User</a>
                        ';
                        }?>
                    </div>   
                </div>

                <form name="frmSearch" method="post" action="">
                    <div class="row p-4">
                        <div class="col-6">
                            <input type="text" placeholder="Event Title" class="my-form__input "
                                name="search[event_search_title]"
                                value="<?php echo $event_search_title; ?>" /> 
                        </div>
                        <div class="col-6">
                            <input
                                type="text" placeholder="Event Id"  class="my-form__input "
                                name="search[event_search_id]"
                                value="<?php echo $event_search_id; ?>" /> 
                        </div>
                    </div>
                    <div class="row d-flex p-4">
                        <div class="col">
                            <input
                                    type="submit" name="go" class="btnSearch btn my-btn btn-outline-dark " 
                                    value="Search"> 
                                    
                            <input type="reset"
                                class="btnReset btn my-btn btn-outline-dark" value="Reset"
                                onclick="window.location='event_paginate.php'">
                        </div>
                    </div>
                    <div class="container u-margin-big ">
                        <div class="row">
                        <?php 
                        
                        if (! empty($result)) {
                            foreach ($result as $key => $value) {
                                if (is_numeric($key)) {
                                    $event_start_date = ( $result[$key]["event_start_date"] ); 

                                    $event_before = $result[$key]["event_start_date"]." ".$result[$key]["event_start_time"];
                                    $event_before = new DateTime($event_before);
                                    //$event_before = $event_before->format('Y-m-d H:i:s A');

                                    $event_after = $result[$key]["event_end_date"];
                                    $event_after = new DateTime($event_after);
                                    //$event_after = $event_after->format('Y-m-d H:i:s A');
  
                                    $day = date('d', strtotime($event_start_date));
                                    $month = date('M', strtotime($event_start_date));

                                ?>
                        <?php echo'
                            <div class="col-xl-4  col-lg-6 p-5" style="position:relative; border-radius:20px">         
                            <a href="event_detail.php?event_id='.$result[$key]["event_id"].'&user_id='.$user_id.'" style="position: absolute; top:30%; left:50%; transform: translate( -50%, -50%); "class="btn my-btn  btn-outline-dark">View Detail</a>
                        ';


                            if ($current >= $event_before && $current <= $event_after) {
                                echo '  
                                <a href="event_checkin.php?event_id='.$result[$key]["event_id"].'&user_id='.$user_id.'" id="check_in"style="position: absolute; top:30%; left:50%; transform: translate( -50%, 70%);"
                                class="btn my-btn  btn-outline-secondary" >Check In</a>';
                            }
                            else {
                                echo '  
                                <a href="event_checkin.php?event_id='.$result[$key]["event_id"].'&user_id='.$user_id.'" id="check_in"style="position: absolute; top:30%; left:50%; transform: translate( -50%, 70%);"
                                class="btn my-btn  btn-outline-secondary disabled" >Check In</a>';
                            }
                                    
                            echo'

                                <div class="border  d-flex flex-column justify-content-center align-items-center shadow" style=" background: white; border; color: black; position:absolute; min-width: 100px; max-width:120px; height:50px; border-radius: 20px; margin: 10px">';?>
                                <?php echo  "<span>".$day."</span><span>".$month."</span>" ?>
                                <?php echo'</div>
                                <div class="border"style="height:250px; border-radius:10px" style="position:relative">';
                                ?><img style="width:100%; height:100%; border-radius:10px; object-fit: cover" src="./images/<?php echo $result[$key]["event_image"]?>">;
                                <?php
                                
                            echo '
                                </div>
                                <div class="">
                                    <h2><span>';?><?php echo $result[$key]["event_title"]; ?><?php echo'</span></h2>
                                    <i class="bi bi-clock-fill"></i><span>';?><?php echo $result[$key]["event_start_date"] .", ". $result[$key]["event_start_time"]; ?><?php echo'</span>    
                                </div>
                            </div>
                            ';
                   
                                }
                            }
                           
                        };
                     
                    ?>
                                
                        <?php 
                        
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
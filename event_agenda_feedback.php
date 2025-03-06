<?php
session_start();
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname="icats-ems";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if( isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
        $user_name= $_SESSION['user_name'];
    };

    $user_id = $_GET['user_id'];
    $event_id = $_GET['event_id'];
    $event_status = $_GET['event_status'];

    $_SESSION['user_id'] =  $user_id  ;
    $_SESSION['event_id']  =   $event_id ;
    $_SESSION['event_status']  = $event_status ;

?>


<!DOCTYPE html>
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
        
        <link href="css/datatables.min.css" rel="stylesheet">
        <script src="js/datatables.min.js"></script>

        <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" rel="stylesheet">
        <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

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
        <title>i-CATS EMS</title>
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
        
        <section>
            <div class="container u-margin-big">
                <div class="row p-4" style="background-color: #A5A5A5; color:white">
                    <div class="col p-4">     
                        <h2 class="display-5 fw-bold" style="display:inline-block"> Feedback Report </h2>&nbsp;<span style="display:inline-block"></span>
                     </div>
                </div>
                <div class="row u-margin-big">
                    <div >
                        <table id='example2' class='display dataTable table table-striped'>
                            <thead>
                                <tr>
                                    <th>Feedback ID</th>
                                    <th>Feedback Detail</th>
                                    <th>User ID</th>
                                    <th>Event ID</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <script>
                              
        var event_id = '<?php echo $event_id; ?>';
        var user_id = '<?php echo $user_id; ?>';
        var event_status = '<?php echo $event_status; ?>';
        $(document).ready(function(){
            $('#example2').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                            'copyHtml5',
                            'excelHtml5',
                            'csvHtml5',
                            'pdfHtml5'
                            ],
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'ajax_feedback.php',
                    "type": "POST",
                    "data": {
                        "user_id": user_id,
                        "event_id": event_id ,
                        "event_status": event_status,
                    }
                },           
                'columns': [
                    { data: 'feedback_id' },
                    { data: 'feedback' },
                    { data: 'user_id' },
                    { data: 'event_id' },
                ],
            });
        });
    </script>

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
    

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
                                        echo '
                                        <li class="my-header__navbar-item"><a href="logout_user.php" class="my-header__navbar-link"><span>05</span>Log Out</a></li>
                                        ';
                                    }
                                    ?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- home page intro -->
        <section class="container u-margin-huge u-background-grey-light">
            <div class="row p-4 d-flex">
                <!-- col left -->
                <div class="col-lg flex-column justify-content-between p-xl-5 p-sm-2 u-margin-big">
                    <!-- brand intro -->
                    <h1><span class="display-1 fw-bold">i-CATS Events Management System</span></h1>
                    <div class="u-margin-big my-divider "></div>
                    <h3><span>Event management is the process of planning and monitoring various public and private events for social, business, or academic purposes.</span></h3>
                    <div class="col-md-6 p-4">
                        <a href="event_paginate.php" role="button" class="btn my-btn my-btn--animated my-btn--shadow u-margin-big my-btn--dark-blue my-btn--block">view more</a>
                    </div>
                </div>

                <!-- col right -->
                <div class="col-lg d-lg-flex flex-sm-row justify-content-sm-center p-xl-5 p-sm-2 u-margin-big align-items-sm-center my-section-intro__events">
                    <!-- hover card-->
                    <div class="my-card">
                        <div class="my-card__content">
                            <div class="my-card__content-upper">
                                <div class="my-card__content-upper-img">
                                    <img src="img/event2.jpg" class="">
                                </div>
                                <div class="my-card__content-lower">
                                    <h3>Plan<br><span>Your Events</span></h3>
                                </div>
                            </div>
                            <ul class="my-card__content-lower-text">
                                <li><span class="my-text--skewed">Training</span></li>
                                <li><span class="my-text--skewed">Seminar</span></li>
                                <li><span class="my-text--skewed">Meeting</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- section about us -->
        <section class="container u-margin-huge w-75" id="about_us">
            <!-- first row -->
            <div class="row d-flex flex-column">    
                <!-- title -->
                <h2 class="display-2 text-center u-margin-big fw-bold">
                    <span class="my-text--skewed my-text--linear-dark">About Us</span>
                </h2>
            </div>
            <!-- second row -> section story -->
                <div class="row u-margin-huge my-section-story">
                    <!-- section story left -->
                    <div class="col-xl-3 p-4"> 
                        <figure class="p-4 my-section-story__shape ">
                            <img src="img/system.jpg" alt="Person on a tour" class="my-section-story__image">
                            <figcaption class="my-section-story__caption">System</figcaption>
                        </figure>
                    </div>
                    <!-- section story right -->
                    <div class="my-section-story__image-description col-xl-9 p-5">
                        <h2>
                            <span class="text-capitalize fw-bold">
                                Create more efficient administrative process and minimize administration efforts.
                            </span>
                        </h2>
                        <p>
                            Simply create and manage the event in a software application that 
                            caters to several core features like event agenda, guest list, calendar, etc
                        </p>
                    </div>
                </div>

                <!-- section story 2 -->
                <div class="row my-section-story u-margin-huge">
                    <div class="col-xl-3 p-4"> 
                        <figure class="my-section-story__shape p-4">
                            <img src="img/people.jpg" alt="Person on a tour" class="my-section-story__image">
                            <figcaption class="my-section-story__caption">Staff</figcaption>
                        </figure>
                    </div>
                    <div class="my-section-story__image-description col-xl-9 p-5">
                        <h2>
                            <span class="text-capitalize fw-bold">
                                Keep track every event detail.
                            </span>
                        </h2>
                        <p>
                            Every event's progress is visible to you.
                            Allows you to stay informed about the current status of the event.
                        </p>
                    </div>
                </div>

                <!-- section story 3 -->
                <div class="row my-section-story u-margin-huge">
                    <div class="col-xl-3 p-4"> 
                        <figure class="my-section-story__shape p-4">
                            <img src="img/user2.jpg" alt="Person on a tour" class="my-section-story__image">
                            <figcaption class="my-section-story__caption">User</figcaption>
                        </figure>
                    </div>
                    <div class="my-section-story__image-description col-xl-9 p-5">
                        <h2>
                            <span class="text-capitalize fw-bold">
                                Checkin Via Single Click
                            </span>
                        </h2>
                        <p>
                            Save your time in planning future events.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- section contact us-->
        <section class="my-section-contact-us container-fluid d-flex flex-column align-items-center justify-content-center" id="contact_us">
            <!-- title -->
            <div class="row d-flex flex-column w-75 u-margin-big">
                <h2 class="display-2 text-center u-margin-big fw-bold">
                    <span class="my-text--linear-dark my-text--skewed">Contact Us</span>
                </h2>
            </div>
            
            <!-- contact form -->
            <div class="row border my-section-contact-us__background h-100 w-75 u-margin-huge" >
                <!-- title -->
                <div class="col-lg-6 p-5">
                    <h2 class="display-3 u-margin-big text-center fw-normal">
                        <span class="text-capitalize">We are ready to hear from you!</span>
                    </h2>
                    <!-- form input -->
                    <form class="my-form w-100 u-margin-huge" method="post" action="new_query.php" enctype= "multipart/form-data"> 
                        <div class="form__group p-2">
                            <input type="email" class="my-form__input" placeholder="Email " id="email" name="contact_email" required>
                            <label for="contact_email" class="my-form__label">Email</label>
                        </div>

                        <div class="form__group p-2">
                            <input type="text" class="my-form__input" placeholder="Query" id="query" name="contact_query" required>
                            <label for="contact_query" class="my-form__label">Query</label>
                        </div>  
                        
                        <div class="form__group d-flex">
                            <button type="submit" class="btn btn-dark my-btn--large my-btn--block shadow">Submit</button>
                            <button type="reset" class="btn btn-light my-btn--large my-btn--block shadow">Reset</button>
                        </div>
                    </form>
                </div>
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
    

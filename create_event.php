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

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/css/datepicker.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/datepicker.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/i18n/datepicker.en.js"></script>
        <title>i-CATS EMS</title>
    </head>

    <style> 

    #morning_time , #evening_time {
        display:none;
    }

    </style>

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
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </header>
   
        <!-- section contact us-->
        <section class=" container-fluid d-flex flex-column align-items-center justify-content-center" id="contact_us">
            <!-- title -->
            <div class="row d-flex flex-column w-75 u-margin-big ">
                <h2 class="display-2 text-center u-margin-big fw-bold">
                    <span class="my-text--linear-dark my-text--skewed">Create Event</span>
                </h2>
            </div>
            <div class="row d-flex flex-column w-75 u-margin-big justify-content-center align-items-center">
                <div class="col-xl-6 col-md-12 border" style="border-radius:10px">
                <form method="post" class="" action="new_event.php" enctype= "multipart/form-data"> 
                        <div class="form__group p-4">
                   
                            <input type="text" class="my-form__input" placeholder="Event Title " id="event_title" name="event_title" required>
                            <label for="event_title" class="my-form__label">Event Title</label>
                        </div>

                        <div class="form__group p-4">
                      
                            <input type="text" class="my-form__input" placeholder="Event Description" id="event_description" name="event_description" required>
                            <label for="event_description" class="my-form__label">Event Description</label>
                        </div>  

                        <div class="form__group p-4">
                        <h3>Event Poster</h3>
                            <input type="file" class="my-form__input" placeholder="event_poster" id="event_poster" name="event_poster" required>
                            <label for="event_poster" class="my-form__label"></label>
                        </div>  
                        
                        <div class="form__group p-4">
                            <h3>Event Start Date</h3>
                            <input type='text' 
                            class="datepicker-here" id="event_start_date" name="event_start_date"  
                            data-language='en' autocomplete="off">
                          
                        </div>  
                        <script>
                            $('#event_start_date').datepicker({
                                language: 'en',
                                minDate: new Date()
                            })
                        </script>

                        <div class="form__group p-4">
                            <label for="event_venue">Choose Venue</label>
                                <select id="event_venue" name="event_venue">
                                    <option value="101">101</option selected>
                                    <option value="102">102</option>
                                    <option value="103">103</option>
                                    <option value="201">201</option>
                                    <option value="202">202</option>
                                    <option value="203">203</option>
                                    <option value="301">301</option>
                                    <option value="302">302</option>
                                    <option value="303">303</option>
                                    <option value="Android Lab">Android Lab</option>
                                    <option value="Se Lab 2">Se Lab 2</option>
                                    <option value="Se Lab 1">Se Lab 1</option>
                                    <option value="IT Lecture 1">IT Lecture 1</option>
                                    <option value="IT Lecture 2">IT Lecture 2</option>
                                </select>                          
                        </div>

                        <div class="form__group p-4">
                            <h3>Choose Your Slot</h3>
                            <input type="radio" id="morning" name="slot" value="morning" onchange="check_slot()">
                            <label for="morning">Morning</label><br>
                            <input type="radio" id="evening" name="slot" value="evening" onchange="check_slot()">
                            <label for="css">Evening</label><br>
                        </div>

                        <div class="form__group p-4" id="morning_time">
                            <label for="morning_start">Choose Your Start Time</label>
                                <select id="morning_start" name="start_time" onchange="check_slot()">
                                    <option value="8">8</option selected>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                </select>
                                <span>&nbsp;</span>
                            <label for="morning_end">Choose Your End Time</label>
                                <select id="morning_end"  name="end_time" onchange="check_slot()">
                                    <option value="">None</option selected>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                </select>
                        </div>

                        <div class="form__group p-4" id="evening_time">
                            <label for="evening_start">Choose Your Start Time</label>
                                <select id="evening_start" name="evening_time" onchange="check_slot()">
                                    <option value="13">1</option selected>
                                    <option value="14">2</option>
                                    <option value="15">3</option>
                                    <option value="16">4</option>
                                    <option value="17">5</option>
                                    <option value="18">6</option>
                                </select>
                                <span>&nbsp;</span>
                            <label for="evening_end">Choose Your End Time</label>
                                <select id="evening_end"  name="evening_time" onchange="check_slot()">
                                    <option value="">None</option>
                                    <option value="13">1</option>
                                    <option value="14">2</option>
                                    <option value="15">3</option>
                                    <option value="16">4</option>
                                    <option value="17">5</option>
                                    <option value="18">6</option>
                                </select>
                        </div>
            
                        <p>Result Appear Here: </p>
                        <p id="demo1"></p>
                        <p id="demo2"></p>
        
                        <input type="hidden" id="result_end" name="result_end">
                        <input type="hidden" id="result_start" name="result_start">
                        <input type="hidden" id="time_range" name="time_range">

                        <div class="form__group d-flex">
                            <button type="submit" class="btn btn-dark my-btn--large my-btn--block shadow">Submit</button>
                            <button type="reset" class="btn btn-light my-btn--large my-btn--block shadow">Reset</button>
                        </div>
                    </form>
                </div>
            </div>

<script>

function check_slot() {
    
    let morning = document.getElementById('morning');
    let evening = document.getElementById('evening');

    let demo1 = document.getElementById('demo1');
    let demo2 = document.getElementById('demo2');

    let morning_time_div = document.getElementById("morning_time");
    let evening_time_div = document.getElementById("evening_time");


    let morning_start_input = document.getElementById("morning_start");
    let morning_end_input = document.getElementById("morning_end");

    let evening_start_input = document.getElementById("evening_start");
    let evening_end_input = document.getElementById("evening_end");

    
    let time_range_result = document.getElementById("time_range");

    let selected_ms = morning_start_input.selectedIndex;
    let selected_me = morning_end_input.selectedIndex;
    let selected_es = evening_start_input.selectedIndex;
    let selected_en = evening_end_input.selectedIndex;
 
    let start_range_A = morning_start_input.length;
    let end_range_A = morning_end_input.length;

    let start_range_B = evening_start_input.length;
    let end_range_B = evening_end_input.length;
    
    let result_start =document.getElementById('result_start');
    let result_end =document.getElementById('result_end');
    let counter;

    if(morning.checked==true){
        evening_start_input.value="";
        evening_end_input.value="";
        morning_time_div.style.display="block";
        evening_time_div.style.display="none";

        morning_start_input.setAttribute('required', '');
        morning_end_input.setAttribute('required', '');
        evening_start_input.removeAttribute('required', '');
        evening_end_input.removeAttribute('required', '');

        
        for(counter = 0; counter <= end_range_A-1; counter++){
            morning_end_input[counter].disabled = false;
        };
        for(counter = 0; counter <= selected_ms+1; counter++){
            morning_end_input[counter].disabled = true;
        }
        result_start.value = morning_start_input.value;
        result_end.value = morning_end_input.value;

        let selected_index_start = morning_start_input.selectedIndex;
        let selected_index_end = morning_end_input.selectedIndex;
        let time_range= "";
        let  selected_index_option = morning_start_input.options;

        for(selected_index_start = morning_start_input.selectedIndex; selected_index_start<selected_index_end; selected_index_start++){
        let selected_index_result = selected_index_option[selected_index_start].index;
      
            if(selected_index_result != selected_index_end-1) {
                time_range+=morning_start_input[selected_index_start].value+",";
            }
            else {
                time_range+=morning_start_input[selected_index_start].value;
            }
       
        }
        demo1.innerHTML="You selected: "+result_start.value+" AND "+result_end.value;
        demo2.innerHTML=time_range;

        time_range_result.value=time_range;

    }

    else if(evening.checked==true){
        morning_start_input.value="";
        morning_end_input.value="";
        evening_time_div.style.display="block";
        morning_time_div.style.display="none";

        morning_start_input.removeAttribute('required', '');
        morning_end_input.removeAttribute('required', '');
        
        evening_start_input.setAttribute('required', '');
        evening_end_input.setAttribute('required', '');

        for(counter = 0; counter <= end_range_B-1; counter++){
            evening_end_input[counter].disabled = false;
        };
        for(counter = 0; counter <= selected_es+1; counter++){
            evening_end_input[counter].disabled = true;
        }
   
        result_start.value = evening_start_input.value;
        result_end.value = evening_end_input.value;

        let selected_index_start = evening_start_input.selectedIndex;
        let selected_index_end = evening_end_input.selectedIndex;


        let time_range= "";
        let selected_index_option = evening_start_input.options;
          

        for(selected_index_start = evening_start_input.selectedIndex; selected_index_start<selected_index_end; selected_index_start++){
        let selected_index_result = selected_index_option[selected_index_start].index;
      
            if(selected_index_result != selected_index_end-1) {
                time_range+=evening_start_input[selected_index_start].value+",";
            }
            else {
                time_range+=evening_start_input[selected_index_start].value;
            }

        }
        demo1.innerHTML="You selected: "+result_start.value+" AND "+result_end.value;
        demo2.innerHTML=time_range;
        time_range_result.value=time_range;
    }
}

</script>
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
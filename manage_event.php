<!doctype html>
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

        <link rel="stylesheet" href="bootstrap.min.css"> <!-- bootstrap min css -->
        <script src="DataTables/datatables.min.js"></script>       
            
        <!-- Bootstrap JS -->
        <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
      
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

    </head>

    <body>
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

        <div class='container'>
            <div class="row">
                <div class="col">
                    <div id="updateModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Update</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="event_title" >Title</label>
                                        <input type="text" class="form-control" id="event_title"   placeholder="Enter Title" required>            
                                    </div>
                                    <div class="form-group">
                                        <label for="event_description" >Description</label>    
                                        <input type="text" class="form-control" id="event_description"  placeholder="Enter Description" required>                          
                                    </div>      
                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" id="event_id" value="0">
                                    <button type="button" class="btn btn-success btn-sm" id="btn_save">Save</button>
                                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
            <!-- Modal -->


            <div class="row">
                <div class="col p-4  table-responsive">
                    <table id='userTable' class='display dataTable' width='100%'>
                        <thead>
                            <tr>
                                <th>Event ID</th>
                                <th>Event Title</th>
                                <th>Event Description</th>  
                                <th>Event Venue</th>
                                <th>Event Start Date</th>               
                                <th>Event End Date</th>
                                <th>Event Start Time</th>
                                <th>Event End Time</th>
                                <th>Time Range</th>
                                <th>Slot</th>
                                <th>User Info Id</th>
                                <th>Action</th>
                            </tr>
                        </thead>                      
                    </table>
                </div>
            </div>
        </div>
        

        <!-- Script -->
        <script>

        $(document).ready(function(){

            // DataTable
            var userDataTable = $('#userTable').DataTable({
                'processing': true,
				  dom: 'Bfrtip',
                    buttons: [
                            'copyHtml5',
                            'excelHtml5',
                            'csvHtml5',
                            'pdfHtml5'
                            ],
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'ajax_manage.php'
                },
                'columns': [
                    { data: 'event_id' },  
                    { data: 'event_title' },
                    { data: 'event_description' },
                    { data: 'event_venue_name' },   
                    { data: 'event_start_date' },
                    { data: 'event_end_date' },
                    { data: 'event_start_time' },
                    { data: 'event_end_time' },
                    { data: 'time_range' },
                    { data: 'slot' },
                    { data: 'user_info_id' },
                    { data: 'action' }
                ]
            });

            // Update record
            $('#userTable').on('click','.updateUser',function(){
                var event_id = $(this).data('id');

                $('#event_id').val(event_id);

                // AJAX request
                $.ajax({
                    url: 'ajax_manage.php',
                    type: 'post',
                    data: {request: 2, event_id: event_id},
                    dataType: 'json',
                    success: function(response){
                        if(response.status == 1){

                            $('#event_title').val(response.data.event_title);
                            $('#event_description').val(response.data.event_description);
            
                        }else{
                            alert("Invalid Test ID.");
                        }
                    }
                });
            });


            // Save user 
            $('#btn_save').click(function(){
                var event_id = $('#event_id').val();

                var event_title = $('#event_title').val().trim();
                var event_description = $('#event_description').val().trim();
   
                if( event_title != '' && event_description != ''){

                    // AJAX request
                    $.ajax({
                        url: 'ajax_manage.php',
                        type: 'post',                
			
                        data: {request: 3, event_id: event_id,event_title: event_title, event_description: event_description},
                        dataType: 'json',
						dom: 'Bfrtip',

                        success: function(response){
                            if(response.status == 1){
                                alert(response.message);

                                // Empty the fields
                                $('#event_title','#event_description').val('');
                                $('#event_id').val(0);

                                // Reload DataTable
                                userDataTable.ajax.reload();

                                // Close modal
                                $('#updateModal').modal('toggle');
                            }else{
                                alert(response.message);
                            }
                        }
                    });
                }else{
                    alert('Please fill all fields.');
                }
            });


            // Delete record
            $('#userTable').on('click','.deleteUser',function(){
                var event_id = $(this).data('id');

                var deleteConfirm = confirm("Are you sure?");
                if (deleteConfirm == true) {
                    // AJAX request
                    $.ajax({
                        url: 'ajax_manage.php',
                        type: 'post',
                        data: {request: 4, event_id: event_id},
                        success: function(response){

                            if(response == 1){
                                alert("Record deleted.");

                                // Reload DataTable
                                userDataTable.ajax.reload();
                            }else{
                                alert("Invalid ID.");
                            }
                        }
                    });
                } 
            });
        });

        </script>

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

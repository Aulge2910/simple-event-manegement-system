

$(document).ready(function() {
    $(".my-header__navbar-link").click(function() {
        $(".my-header__navbar-checkbox").prop( "checked", false );
      });
  });
 

 
 /***
        $('document').ready(function(){
            $('#myP').load('check_event_status.php');//load the script immediately 
            setInterval(function(){setUpdates()}, 1000);

        });

        function setUpdates(){
            $('#myP').load('php-script.php');
        }
 */

        /***
        $('document').ready(function(){
            setInterval(function(){fetchdata()}, 2000);

        });
 */


        /*** 
        $(document).ready(function() {

            
            function fetchdata(){  
            $.ajax({ 
              url: 'check_event_status.php', 
              type: 'post', 
              success: function(response){ 
                // Perform operation on the return value 
                alert(response); 
              } , 
              complete:function(data){ 
                setTimeout(fetchdata,2000); 
              } 
             }); 
           };

        });
          $(document).ready(function(){ 
            setInterval(fetchdata,2000); 
          });
*/


/***
 * 
 * 
 * 
 * 
 * 
 $(window).load(function () {
    $.ajax({
        url: "check_event_status.php",
        type: 'post',  
    });
});
      setInterval(function(){setUpdates()}, 1000);
    alert("window is loaded");
    
    function setUpdates(){
    $.ajax({ 
        url: 'check_event_status.php', 
        type: 'post',       
       }); 
     };
 */

/*** 
$(window).on('load', function(){
    window.ajax({
        url: "check_event_status.php",
        type: 'post', 
        success:function(){
            alert("Success!");
        }
    });

});
*/
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
   


              // Script.js 
// create a new QRCode instance 
let qrcode = new QRCode( 
  document.querySelector(".qrcode") 
); 

// Initial QR code generation 
// with a default message 
qrcode.makeCode("Why did you scan me?"); 

// Function to generate QR 
// code based on user input 
function generateQr() { 
  if ( 
      document.querySelector("input") 
          .value === "" || 
      document.querySelector("input") 
          .value === " ") { 
      alert( 
          "Input Field Can not be blank!"
      );}  
  else { 
      qrcode.makeCode( 
          document.querySelector( 
              "input"
          ).value); 
}}
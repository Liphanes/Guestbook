<?php
    require_once 'vendor/autoload.php';
    require_once 'connect.php';
    
?>


<html>
 <head>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-grid.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-grid.min.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-reboot.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-reboot.min.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link href="css/mdb.min.css" rel="stylesheet">
    <script src="js/jquery-3.3.1.min.js"></script>
    
 </head>
 <body>
        <header>

        <nav class="navbar fixed-top navbar-expand-lg navbar-dark blue scrolling-navbar">
        <a class="navbar-brand" href="#"><strong>Гостевая книга</strong></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Send Message<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="messlist.php">Message list</a>
            </li>
            </ul>
        </div>
        </nav>

        </header>

    
    <div class="middlecontent">
             <table class="table table-hover" id="restbl">
                <thead>
                   <tr>
                        <th><input type="text" class="form-control" id="finduname" onchange="getSearch()"></th>
                        <th><input type="text" class="form-control" id="findeml" onchange="getSearch()"></th>
                        <th><input type="text" class="form-control" id="findtags" onchange="getSearch()"></th>
                        <th></p><input type="date" class="form-control" id="finddate" onchange="getSearch()"></th>
                        <th><input type="button" class="btn btn-primary" value="Search" onclick="search()"></th>
                   </tr>
                </thead>
            </table>
         <div id="result_table">
            
         </div>

    </div>
    <footer class="page-footer font-small blue fixed-bottom">

        <!-- Copyright -->
        <div class="footer-copyright text-center py-3">© 2018 Copyright:
            <span>Тестовое задание</span>
        </div>
        <!-- Copyright -->

    </footer>
 </body>

 <script>
     var findun="";
     var findem="";
     var findtg="";
     var finddt="";

     $(document).ready(function(){


            $.ajax({
                url:     'datalist.php', 
                type:     'POST', 
                data: {action: 'getdata', check: 'checked'},
                dataType: 'html', 
                success: function(response) { 
                   //$('#result_table')[0].reset();
                   $('#result_table').html(response);
                   //$('#result_table').empty();  
                },
                error: function(response) {
                //$('').html('Ошибка. Данные не отправлены.');
                }
            });	 

      
            
               

     });

     function getSearch(){
        findun = $("#finduname").val();
        findem = $("#findeml").val();
        findtg = $("#findtags").val();
        finddt = $("#finddate").val();
        
        if(findun != "" || findem != "" || findtg != "" || finddt != "" ){
           /* $.ajax({
                    url:     'datalist.php', 
                    type:     'POST', 
                    data: {check: 'unchecked'},
                    dataType: 'html', 
                    success: function(response) { 
                    //$('#result_table')[0].reset();
                    $('#result_table').html(response);
                    //$('#result_table').empty();  
                    },
                    error: function(response) {
                    //$('').html('Ошибка. Данные не отправлены.');
                    }
            });	*/
        }else{
            $.ajax({
                    url:     'datalist.php', 
                    type:     'POST', 
                    data: {action: 'getdata', check: 'checked'},
                    dataType: 'html', 
                    success: function(response) { 
                    //$('#result_table')[0].reset();
                    $('#result_table').html(response);
                    //$('#result_table').empty();  
                    },
                    error: function(response) {
                    //$('').html('Ошибка. Данные не отправлены.');
                    }
            });	
        } 

     }

     
     function search(){
        
        $.ajax({
                url:     'datalist.php', 
                type:     'POST', 
                data: {action: 'search', searchstring: window.findun+','+window.findem+','+window.findtg+','+window.finddt},
                dataType: 'html', 
                success: function(response) { 
                    //$('#result_table')[0].reset();
                   // $('#result_table').empty();
                    $('#result_table').html(response);
                },
                error: function(response) {
                //$('').html('Ошибка. Данные не отправлены.');
                }
        });
    }
    
     

     function setPage(val){
   
            $.ajax({
                    url:     'datalist.php', 
                    type:     'POST', 
                    data: {action: 'getdata', searchstring: window.findun+','+window.findem+','+window.findtg+','+window.finddt, Page: val, check: 'checked'},
                    dataType: 'html', 
                    success: function(response) { 
                     // $('#ajax_form')[0].reset(); 
                        $('#result_table').html(response);
                    },
                    error: function(response) {
                    //$('').html('Ошибка. Данные не отправлены.');
                    }
            });

     }


     function setPagesearch(val){

        $.ajax({
                url:     'datalist.php', 
                type:     'POST', 
                data: {action: 'search', searchstring: window.findun+','+window.findem+','+window.findtg+','+window.finddt, Page: val},
                dataType: 'html', 
                success: function(response) { 
                // $('#ajax_form')[0].reset(); 
                    $('#result_table').html(response);
                },
                error: function(response) {
                //$('').html('Ошибка. Данные не отправлены.');
                }
        });

    }

 </script>
  <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="js/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="js/mdb.min.js"></script>


</html>

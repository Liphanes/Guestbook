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

<nav class="navbar fixed-top navbar-expand-lg navbar-dark pink scrolling-navbar">
<a class="navbar-brand" href="#"><strong>Гостевая книга</strong></a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
    <li class="nav-item active">
        <a class="nav-link" href="index.php">Send Message <span class="sr-only">(current)</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="messlist.php">Message list</a>
    </li>
    </ul>
</div>
<input type="button" class="btn btn-danger" value="Заполнить БД" onclick="sendStatusSet()">
</nav>

</header>

    <div class="middlecontent">
    <form action="go.php" method="post" id="ajax_form" enctype="multipart/form-data">
         <p>Имя пользователя<br><input id="uname" class="form-control field" name="Username" type="text"></p>
		 <p>Домашняя страница<br><input id="homme" class="form-control field" name="Homeurl" type="url" ></p>
		 <p>Email<br><input id="emaail" class="form-control field" name="Email" type="email"></p>
		 <p>Текст сообщения<br><input id="mssags" class="form-control field" name="Text" type="text"></p>
         <p>Tags<br><input id="tagsss" class="form-control field" name="Tags" type="text"></p>
         
         <img src='captcha.php' id='capcha-image'>
         <a href="javascript:void(0);" class="btn btn-primary" onclick="document.getElementById('capcha-image').src='captcha.php?rid=' + Math.random();">Обновить капчу</a>
         <span>Введите капчу:</span>
         <input id="cptc" type="text" class="field" name="code">       
         
         <p><input type="submit" class="btn btn-primary lbac" name="go" id="send" value="Отправить"></p>
   </form>
    </div>

    <footer class="page-footer font-small pink fixed-bottom">

<!-- Copyright -->
        <div class="footer-copyright text-center py-3">© 2019 Copyright:
            <span>Тестовое задание</span>
            
        </div>
        <!-- Copyright -->
        
    </footer>
 </body>

<script>



$(document).ready(function(){

// Устанавливаем обработчик потери фокуса для всех полей ввода текста
$('input#uname,  input#emaail, input#mssags, input#tagsss, input#cptc').unbind().blur( function(){

//input#uname, input#homme, input#emaail, input#mssags, input#emaail, input#cptc
   // Для удобства записываем обращения к атрибуту и значению каждого поля в переменные
    var id = $(this).attr('id');
    var val = $(this).val();

  // После того, как поле потеряло фокус, перебираем значения id, совпадающие с id данного поля
  switch(id)
  {
        // Проверка поля "Имя"
        case 'uname':
           var rv_name = /^[a-zA-Zа-яА-Я]+$/; // используем регулярное выражение

           // Eсли длина имени больше 2 символов, оно не пустое и удовлетворяет рег. выражению,
           // то добавляем этому полю класс .not_error,
           // и ниже в контейнер для ошибок выводим слово " Принято", т.е. валидация для этого поля пройдена успешно

           if(val.length > 2 && val != '' && rv_name.test(val))
           {
              $(this).addClass('not_error');
              $(this).next('.error-box').text('Принято')
                                        .css('color','green')
                                        .animate({'paddingLeft':'10px'},400)
                                        .animate({'paddingLeft':'5px'},400);
           }

         // Иначе, мы удаляем класс not-error и заменяем его на класс error, говоря о том что поле содержит ошибку валидации,
         // и ниже в наш контейнер выводим сообщение об ошибке и параметры для верной валидации

           else
           {
              $(this).removeClass('not_error').addClass('error');
              $(this).next('.error-box').html('поле "Имя пользователя" обязательно для заполнения<br>, длина имени должна составлять не менее 2 символов<br>, поле должно содержать только русские или латинские буквы')
                                         .css('color','red')
                                         .animate({'paddingLeft':'10px'},400)
                                         .animate({'paddingLeft':'5px'},400);
           }
       break;



      // Проверка email
      case 'emaail':
          var rv_email = /^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
          if(val != '' && rv_email.test(val))
          {
             $(this).addClass('not_error');
             $(this).next('.error-box').text('Принято')
                                       .css('color','green')
                                       .animate({'paddingLeft':'10px'},400)
                                       .animate({'paddingLeft':'5px'},400);
          }
          else
          {
             $(this).removeClass('not_error').addClass('error');
             $(this).next('.error-box').html('поле "Email" обязательно для заполнения<br>, поле должно содержать правильный email-адрес<br>')
                                        .css('color','red')
                                        .animate({'paddingLeft':'10px'},400)
                                        .animate({'paddingLeft':'5px'},400);
          }
      break;


     // Проверка поля "Сообщение"
     case 'mssags':
         if(val != '' && val.length < 5000)
         {
            $(this).addClass('not_error');
            $(this).next('.error-box').text('Принято')
                                      .css('color','green')
                                      .animate({'paddingLeft':'10px'},400)
                                      .animate({'paddingLeft':'5px'},400);
         }
         else
         {
            $(this).removeClass('not_error').addClass('error');
            $(this).next('.error-box').html('поле "Текст сообщения" обязательно для заполнения')
                                      .css('color','red')
                                      .animate({'paddingLeft':'10px'},400)
                                      .animate({'paddingLeft':'5px'},400);
         }
     break;

     case 'tagsss':
         if(val != '' && val.length < 5000)
         {
            $(this).addClass('not_error');
            $(this).next('.error-box').text('Принято')
                                      .css('color','green')
                                      .animate({'paddingLeft':'10px'},400)
                                      .animate({'paddingLeft':'5px'},400);
         }
         else
         {
            $(this).removeClass('not_error').addClass('error');
            $(this).next('.error-box').html('поле "Tags" обязательно для заполнения')
                                      .css('color','red')
                                      .animate({'paddingLeft':'10px'},400)
                                      .animate({'paddingLeft':'5px'},400);
         }
     break;

     case 'cptc':
         if(val != '' && val.length < 5000)
         {
            $(this).addClass('not_error');
            $(this).next('.error-box').text('Принято')
                                      .css('color','green')
                                      .animate({'paddingLeft':'10px'},400)
                                      .animate({'paddingLeft':'5px'},400);
         }
         else
         {
            $(this).removeClass('not_error').addClass('error');
            $(this).next('.error-box').html('поле "Капча" обязательно для заполнения')
                                      .css('color','red')
                                      .animate({'paddingLeft':'10px'},400)
                                      .animate({'paddingLeft':'5px'},400);
         }
     break;

  } 

}); 

$('form#ajax_form').submit(function(e){

    
    e.preventDefault();

    if($('.not_error').length == 5)
    {

            $.ajax({
                    url: 'go.php',
                    type: 'post',
                    data: $(this).serialize(),

                    beforeSend: function(xhr, textStatus){ 
                         $('form#ajax_form :input').attr('disabled','disabled');
                    },

                   success: function(response){
                        $('form#ajax_form :input').removeAttr('disabled');
                        $('form#ajax_form :text, textarea').val('').removeClass().next('.error-box').text('');
                        
                   }
            });
  }

  else
  {
     return false;
  }

}); 

}); 



function sendStatusSet() {
    $.ajax({
        url:     'dbupd.php', 
        type:     'POST', 
        dataType: 'html', 
        data: {setdb:'true'},  
        success: function(response) { 
			alert('База данных успешно заполнена.');
    	},
    	error: function(response) {
           alert('Ошибка. Данные не отправлены.');
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





<META http-equiv=content-type content="text/html; charset=UTF-8">
<?php
include("random.php");
include("connect.php");

$cap = $_COOKIE["captcha"]; 


function check_code($code, $cookie) 
{


	$code = trim($code); 
    $code = md5($code);
   

    if ($code == $cookie){
        return TRUE;
    }
    else{
        return FALSE;
    } 
}

// Обрабатываем полученный код
	if (isset($_POST['code'])) 
	{
		
			if ($_POST['code'] == '')
			{
				exit("Ошибка: введите капчу!"); 
			}

			if (check_code($_POST['code'], $cap))
			{

                    
                  moderate($_POST['Username'],$_POST['Homeurl'],$_POST['Email'],$_POST['Text'],$_POST['Tags'],$_POST['code']);
    

			}
		
			else 
			{
				exit("Ошибка: капча введена неверно!"); 
			}
		}
	else 
	{
        exit("Access denied"); 
        
    }
    

    function moderate($username, $hpage, $mail, $text, $tags){
            $email="";
            $homeurl="";
            $atags= "";
            if($tags != ""){
                $taglist = explode(",", $tags);
            }else{
                $taglist = array();
            }
            for($i = 0; $i < count($taglist); $i++){
                $atags .=" ".$taglist[$i]." ";
            }


            $prg = array("https://","http://");

            $uname = strip_tags ($username);

            $homeurl = str_replace($prg, "", $hpage);

            if (filter_var(strip_tags ($mail), FILTER_VALIDATE_EMAIL)) {
                $email = strip_tags ($mail);
            }else{
                
            }

            $message = strip_tags ($text);

            $query = "INSERT INTO `GuestBook` (`Username`,`Homepage`,`Email`,`Text`,`Tags`,`CreatedAt`) VALUES ('".$uname."','".$homeurl."','".$email."','".$message."','".$atags."',NOW())";

            $link = mysqli_connect('127.0.0.1', 'root', '', 'TestWork') or die ("Ошибка " . mysqli_error($link));
            if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
            }
  
            echo "<pre>Debug: $query</pre>\m";
            $result = mysqli_query($link, $query);
            if ( false===$result ) {
                printf("error: %s\n", mysqli_error($con));
            }
            else {
                echo 'done.';
            }

    }
    
    

    mysqli_close($link);
?>
<?php
include ("vendor/autoload.php");



$faker = Faker\Factory::create();


function randomtags(){
    $rnd = rand(1, 5);
    $string="";
    $firsttag="";

    $symbols = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z','A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z','а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ь', 'ы', 'ъ', 'э', 'ю', 'я','А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ь', 'Ы', 'Ъ', 'Э', 'Ю', 'Я',1, 2, 3, 4, 5, 6, 7, 8, 9, 0,'@', '#'];

    for($l = 0; $l < $rnd;$l++){
        $rndlenght = rand(3, 15);
        for($f = 0; $f < $rndlenght;$f++){
                $rnd_num = rand(0,count($symbols));
                $smbl = $symbols[$rnd_num];
                $firsttag.=$smbl;
        }
        $firsttag .= " ";
    }

    return $firsttag;

}


if(isset($_POST['setdb'])){
    




    for($z=0;$z<300;$z++){

        $vms = randomtags();

        /*echo $vms." "."</br>";
        echo $faker->name;
        echo $faker->text;
        echo $faker->url;              
        echo $faker->email;
        echo $faker->date($format = 'Y-m-d', $min = 'now', $max = 'now');*/
        $dates = $faker->date($format = 'Y-m-d', $min = 'now', $max = 'now');

        $query = "INSERT INTO `GuestBook` (`Username`,`Homepage`,`Email`,`Text`,`Tags`,`CreatedAt`) VALUES ('".$faker->name."','".$faker->url."','".$faker->email."','".$faker->text."','".$vms."','".$dates."');";

    

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



}else{
    die();
}






















?>
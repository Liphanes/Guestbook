<?php
include("findgb.php");
include("table.php");
include("datalist.php");


public function getdata($pages){
    $link = mysqli_connect('127.0.0.1', 'root', '', 'TestWork') or die ("Ошибка " . mysqli_error($link));
    $datas=array();
    if($pages == "" || $pages == null){
        $pages = 0;
    }else{
        $pages = $pages - 1;
    }

    $np = $pages * 30;
    
    $qwithoutfind="SELECT *  FROM `GuestBook` LIMIT ".$np.", 30";

    
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }

   
    $result = mysqli_query($link, $qwithoutfind) or trigger_error(mysqli_error()." in ". $qwithoutfind);
    $i=0;
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        $datas[$i] = $row;
        $i++;
    }

    
    genresult($datas);
}


?>
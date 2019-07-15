<?php
include("defaultgb.php");
include("table.php");
include("datalist.php");



public function search($strs, $pages){
    $datas=array();
    if($pages == "" || $pages == null){
        $pages = 0;
    }else{
        $pages = $pages;
    }
    
    if($strs){
        $cname="";
       $findings = explode(",",$strs);
        
       for($d = 0; $d < count($findings);$d++){
            switch($d){
                case 0:
                    $cname="`Username`";
                    break;
                case 1:
                    $cname="`Email`";
                    break;
                case 2:
                    $cname="`Tags`";
                    break;
                case 3:
                    $cname="`CreatedAt`";
                    break;
            }
           if($findings[$d] != ""){
                $str .=" ".$cname." LIKE '%".$findings[$d]."%' AND";
           }else{

           }
       }
       
       
       $allque = substr($str, 0, -3);

       $np = $pages * 30;
       $link = mysqli_connect('127.0.0.1', 'root', '', 'TestWork') or die ("Ошибка " . mysqli_error($link));
       $qwifind="SELECT *  FROM `GuestBook`  WHERE ".$allque." LIMIT ".$np.", 30";

      
       if (mysqli_connect_errno()) {
           printf("Connect failed: %s\n", mysqli_connect_error());
           exit();
       }

   
       $result = mysqli_query($link, $qwifind) or trigger_error(mysqli_error()." in ". $qwithoutfind);
       $i=0;
       while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
           $datas[$i] = $row;
           $i++;
           
       }
       
       genresult($datas);
    }
       
    
}

?>
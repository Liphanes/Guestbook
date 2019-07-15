<?php
ini_set('error_reporting', 0);
ini_set('display_errors', 0);

  $page = $_POST['Page'];
  $perpage = 15;
 
  $string = $_POST['searchstring'];

  $check="";

  

  $cookietime = time()+220;
  if($page != ""){
    $cookie = $page; // Можно указать любое другое время
    setcookie("page", $cookie, $cookietime);
  }

  if($string != ""){
    $cooe = $string;
    setcookie("fstring", $cooe, $cookietime);
  }else{
    setcookie("fstring", "", $cookietime);
  }
 
  $pg = $_POST['Page'];
  $sst =  $_POST['searchstring'];

  
if(isset($_POST['action']) == 'getdata'){
    if(isset($_POST['check']) == 'checked'){
        getdata($pg);  
    }else{

    }
}else{

}

if(isset($_POST['action']) == 'search'){ 
    if($sst != ",,,"){
        search($sst, $pg);
    }else{

    }
}else{

}

function getdata($pages){
    $datas=array();
    if($pages == "" || $pages == null){
        $pages = 0;
    }else{
        $pages = $pages - 1;
    }

    $np = $pages * 15;
    $linkz = mysqli_connect('127.0.0.1', 'root', '', 'TestWork') or die ("Ошибка " . mysqli_error($link));
    $qwithoutfind="SELECT *  FROM `GuestBook` ORDER BY `CreatedAt` LIMIT ".$np.", 30";
    
    if (mysqli_connect_errno()) {
        exit();
    }

    $result = mysqli_query($linkz, $qwithoutfind) or trigger_error(mysqli_error()." in ". $qwithoutfind);;
    $i=0;
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        $datas[$i] = $row;
        $i++;
    }

    $link = mysqli_connect('127.0.0.1', 'root', '', 'TestWork') or die ("Ошибка " . mysqli_error($link));
    $q="SELECT count(*) as Count FROM `GuestBook`";

        
    if (mysqli_connect_errno()) {
        exit();
    }

    $result = mysqli_query($link, $q);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    $scount = $row['Count'];

    
    mysqli_close($link);

    if($datas){
        genresult($datas,$scount,$pages);
     }else{
    
     } 

    mysqli_close($linkz);
}

function search($strs, $pages){
    
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
                $manytagslist="";
                if($findings[2] != ""){
                   $tlfromstr = explode(" ", $findings[2]);
                }
                for($zh=0;$zh<count($tlfromstr);$zh++){
                    $manytagslist .= " ".$cname." LIKE '%".$tlfromstr[$zh]."%' AND";
                    $mtl = substr($manytagslist, 0, -3);
                    
                }
                    if($d != 2){
                        $str .=" ".$cname." LIKE '%".$findings[$d]."%' AND";
                    }else{
                        if($d!=2){
                            $str .= $mtl." AND ".$cname." LIKE '%".$findings[$d]."%' AND";
                        }else{
                            $str .= $mtl." AND";
                        }

                    }
                    
           }else{

           }
       }
     
       $allque = substr($str, 0, -3);
       
       $np = $pages * 15;
       $link2 = mysqli_connect('127.0.0.1', 'root', '', 'TestWork') or die ("Ошибка " . mysqli_error($link));
       $qwifind="SELECT * FROM `GuestBook`  WHERE ".$allque." ORDER BY `CreatedAt` LIMIT ".$np.", 30";

       
      
       if (mysqli_connect_errno()) {
           exit();
       }

       $result = mysqli_query($link2, $qwifind) or trigger_error(mysqli_error()." in ". $qwifind);;
       $i=0;
       while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
           $datas[$i] = $row;
           $i++;
           
       }
       mysqli_close($link2);
       
    }

    $linkd = mysqli_connect('127.0.0.1', 'root', '', 'TestWork') or die ("Ошибка " . mysqli_error($link));
    $qr="SELECT count(*) as Count FROM `GuestBook` WHERE ".$allque." ORDER BY `CreatedAt`";

        
    if (mysqli_connect_errno()) {
        exit();
    }

    $result = mysqli_query($linkd, $qr);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    $scounts = $row['Count'];
    

    //$num_pages=ceil($scount/$perpage);
    mysqli_close($linkd);

     if($datas){
        genresultsearch($datas,$scounts,$pages);
     }else{
    
     } 
    
}

function genresult($data,$md,$pgg){
    $perpage = 15;
    $l = 0;
    $ht = explode(",",$_POST['searchstring']);
    echo'<div class="usor">';
    echo'<table class="table table-bordered" id="restbl">'; 
    echo'<thead class="thead-dark">'; 
    echo'<tr>';
    
    echo'<th><p>Username</p>';
   
    echo'</th>';
    

    echo'<th><p>Email</p>';

    echo'</th>';

    echo'<th><p>Tags</p>';

    echo'</th>';

    echo'<th><p>Date create</p>';

    echo'</th>';

    echo'<th><p>Message</p>';

    echo'</th>';
    echo'</tr>';

  echo'</thead>';
  echo'<tbody>';  
  while($l <= $perpage){

    $taglist = explode(" ",$data[$l]['Tags']);
    $newtl="";
    $datatime = "";
  
    if($data[$l]['CreatedAt']!=""){
        $datatime = date("d.m.Y", strtotime($data[$l]['CreatedAt']));
    }
    for($tl = 0;$tl < count($taglist); $tl++){
        if($taglist[$tl]!=""){
         $newtl = $newtl.'<div class="tag-box"><span class="sps">'.$taglist[$tl].'</span></div>';
        }
    }

    echo'<tr><td>'.$data[$l]['Username'].'</td><td>'.$data[$l]['Email'].'</td><td>'.$newtl.'</td><td>'.$datatime.'</td><td>'.$data[$l]['Text'].'</td></tr>'; 
    $l++;
  }
  echo'</tbody>';  
  echo'</table>'; 
  $p=1;
  $ct = count($data);
  $pp = ceil($md/$perpage);
 
  $cdd="";
  while($p < $pp){
      //$v=$p+1;
      $v=$p;
        $k=$v-1;
        if($pgg == $k){
            echo'<input type="button" value="'.$v.'" id="page" class="btn btn-success" onclick="setPage(this.value)">';
        }else{
            echo'<input type="button" value="'.$v.'" id="page" class="btn btn-primary" onclick="setPage(this.value)">';
        }
     
      
      $p++;
  }

  echo'</div>';


}


function genresultsearch($data,$mp,$pgs){
    $perpage = 15;
    $l = 0;
    $ht = explode(",",$_POST['searchstring']);
    echo'<div class="usor">';
    echo'<table class="table table-bordered" id="restbl">'; 
    echo'<thead class="thead-dark">'; 
    echo'<tr>';
    
    echo'<th><p>Username</p>';
   
    echo'</th>';
    

    echo'<th><p>Email</p>';

    echo'</th>';

    echo'<th><p>Tags</p>';

    echo'</th>';

    echo'<th><p>Date create</p>';

    echo'</th>';

    echo'<th><p>Message</p>';

    echo'</th>';
    echo'</tr>';
  
  echo'</thead>';
  echo'<tbody>';  
  while($l <= $perpage){

    $taglist = explode(" ",$data[$l]['Tags']);
    $newtl="";
    $datatime = "";
  
    if($data[$l]['CreatedAt']!=""){
        $datatime = date("d.m.Y", strtotime($data[$l]['CreatedAt']));
    }
    for($tl = 0;$tl < count($taglist); $tl++){
        if($taglist[$tl]!=""){
         $newtl = $newtl.'<div class="tag-box"><span class="sps">'.$taglist[$tl].'</span></div>';
        }
    }

    echo'<tr><td>'.$data[$l]['Username'].'</td><td>'.$data[$l]['Email'].'</td><td>'.$newtl.'</td><td>'.$datatime.'</td><td>'.$data[$l]['Text'].'</td></tr>'; 
    $l++;
  }
  echo'</tbody>';  
  echo'</table>'; 
  $p=1;
  $ct = count($data);
  $pp = ceil($mp/$perpage);
  $cll="";
  while($p < $pp){
      //$v=$p+1;
      $v=$p;
      $k=$v;
      if($pgs == $k){
        echo'<input type="button" value="'.$v.'" id="page" class="btn btn-success" onclick="setPagesearch(this.value)">';
      }else{
        echo'<input type="button" value="'.$v.'" id="page" class="btn btn-primary" onclick="setPagesearch(this.value)">';
      }

      
      $p++;
   }
  
   echo'</div>';

}




?>
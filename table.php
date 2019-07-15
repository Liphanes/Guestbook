<?php
include("defaultgb.php");
include("findgb.php");
include("datalist.php");

function genresult($data){
    $perpage =15;
    $l = 0;
    $ht = explode(",",$_POST['searchstring']);
    
  echo'<table class="table table-bordered" id="restbl">'; 
  echo'<thead>'; 
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
    echo'<tr>';
    
    echo'<th><input type="text" class="form-control" id="finduname" onchange="getSearch()" value="'.$ht[0].'">';
    
    echo'</th>';
    

    echo'<th><input type="text" class="form-control" id="findeml" onchange="getSearch()" value="'.$ht[1].'">';

    echo'</th>';

    echo'<th><input type="text" class="form-control" id="findtags" onchange="getSearch()" value="'.$ht[2].'">';

    echo'</th>';

    echo'<th></p><input type="date" class="form-control" id="finddate" onchange="getSearch()" value="'.$ht[3].'">';

    echo'</th>';

    echo'<th><input type="button" value="Search" onclick="search()">';

    echo'</th>';
    echo'</tr>';
  echo'</thead>';
  echo'<tbody>';  
  while($l <= $perpage){

    $taglist = explode(",",$data[$l]['Tags']);
    $newtl="";
    $datatime = "";
  
    if($data[$l]['CreatedAt']!=""){
        $datatime = date("d.m.Y", strtotime($data[$l]['CreatedAt']));
    }
    for($tl = 0;$tl < count($taglist); $tl++){
        if($taglist[$tl]!=""){
         $newtl = $newtl.'<div class="tag-box"><div class="eddcl"><span>'.$taglist[$tl].'</span></div></div>';
        }
    }

    
    echo'<tr><td>'.$data[$l]['Username'].'</td><td>'.$data[$l]['Email'].'</td><td>'.$newtl.'</td><td>'.$datatime.'</td><td>'.$data[$l]['Text'].'</td></tr>'; 
    $l++;
  }
  echo'</tbody>';  
  echo'</table>'; 
  $p=0;
  $ct = count($data);
  $pp = ceil($ct/$perpage);
 
  while($p < $pp){
      $v=$p+1;
      echo'<input type="button" value="'.$v.'" id="page" onclick="setPage(this.value)">';
      
      $p++;
  }
  //exit;
}

?>
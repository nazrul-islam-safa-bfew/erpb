<?php
$folder="../includes/";
include($folder."config.inc.php");
$db=mysqli_connect($SESS_DBHOST,$SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

$sql="select iowId from iowback where iowProjectCode>=200 and iowId not in (select iowId from iow) group by iowId";
// echo $sql;
$q=mysqli_query($db,$sql);
while($row=mysqli_fetch_array($q)){
$revSql="SELECT revisionNo FROM `iowback` WHERE iowId=$row[iowId] order by revisionNo desc limit 1";
 $revQ=mysqli_query($db,$revSql);
 $revR=mysqli_fetch_array($revQ);
 $revisionNo=$revR["revisionNo"];
  
  $iowDel=mysqli_query($db,"delete from iow where iowId=$row[iowId] and revisionNo<$revisionNo limit 1");
 
 $sql2="insert into iow (SELECT * FROM `iowback` WHERE iowId=$row[iowId] and revisionNo=$revisionNo)";
//   echo $sql2;
  
 mysqli_query($db,$sql2);
 if(mysqli_affected_rows($db)>0){ //if iow inserted
   
     
  $iowDel=mysqli_query($db,"delete from siow where iowId=$row[iowId] and revisionNo<$revisionNo limit 30");
   
   
   $sql_s="insert into siow (select * from siowback where iowId=$row[iowId] and revisionNo=$revisionNo)";
   mysqli_query($db,$sql_s);
   
   if(mysqli_affected_rows($db)>0){ //if siow inserted
     
          
  $dmaDel=mysqli_query($db,"delete from dma where dmaiow=$row[iowId] and revisionNo<$revisionNo and revisionNo!='' and dmaiow!=''");
     
     $sql_r="insert into dma (select * from dmaback where dmaiow=$row[iowId] and revisionNo=$revisionNo)";
     mysqli_query($db,$sql_r);
     if(mysqli_affected_rows($db)>0){
       echo "<br>Iow: $row[iowId], Revision: $revisionNo has been returned into approved";
     }
   }
 }
}
?>
<?php
$folder="../includes/";
include($folder."config.inc.php");
$db=mysqli_connect($SESS_DBHOST,$SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

$allCol="200,201,202,203,204,205,206,207,208,209,210,211,212,002,004";
foreach(explode(",",$allCol) as $col){
  $sql="alter table issue$col ";
  $sql.="add column eqID varchar(20)";
  $sql.=", add column km_h_qty varchar(20)";
  $sql.=", add column unit varchar(5)";
  mysqli_query($db,$sql);
  echo "<br>".mysqli_error($db).$col."<br>";
  
  $sql="alter table store$col ";
  $sql.=" add column receiveQtyTemp varchar(20)";
  $sql.=", add column pdf_files varchar(2000)";  
  mysqli_query($db,$sql);
  echo "<br>".mysqli_error($db).$col."<br>";
  
  $sql="alter table storet$col ";
  $sql.=" add column receiveQtyTemp varchar(20)";
  $sql.=", add column pdf_files varchar(2000)";  
  mysqli_query($db,$sql);
  echo "<br>".mysqli_error($db).$col."<br>";  
  
  
//   ==============================================Maintenance========================
  
  
  $iowSpec[]=["Equipment Maintenance Works","888.000.000.000"];
  $iowSpec[]=["Breakdown","888.001.000.000"];
  $iowSpec[]=["Overhauling","888.002.000.000"];
  $iowSpec[]=["Preventive","888.003.000.000"];
  
  
  foreach($iowSpec as $iowSp){
    $sql="insert into iowtemp (iowProjectCode,iowCode,iowDes,iowStatus,position) values ('$col','$iowSp[1]','$iowSp[0]','noStatus','$iowSp[1]')";
  mysqli_query($db,$sql);
    echo "<br>".mysqli_error($db).$sql."<br>";
    
    $sql="insert into iow (iowProjectCode,iowCode,iowDes,iowStatus,position) values ('$col','$iowSp[1]','$iowSp[0]','noStatus','$iowSp[1]')";
  mysqli_query($db,$sql);
    echo "<br>".mysqli_error($db).$sql."<br>";
  }
}


?>
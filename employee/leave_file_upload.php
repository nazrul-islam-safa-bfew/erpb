<?php
include("../includes/session.inc.php");
include("../includes/config.inc.php");


$db=mysqli_connect($SESS_DBHOST,$SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

$l_id=$_GET["leave_id"];
$file=$_FILES["upload"];
$folder_name="../leave_pdf/";
if($file){
  $file_name=$folder_name.strtotime(date("Y-m-d"))."_".$l_id.".pdf";
  if(move_uploaded_file($file["tmp_name"],$file_name)){
    $sql="update `leave` set `status`='3',pdf='$file_name' where id='$l_id'";
    $q=mysqli_query($db,$sql);
    
    $sql="select * from `leave` where id='$l_id'";
    $q=mysqli_query($db,$sql);
    $row=mysqli_fetch_array($q);
    
    $sql="update `attendance` set `action`='L' where empId='$row[empId]' and edate>='$row[sdate]' and  edate<='$row[edate]' limit $row[leavePeriod] ";
    mysqli_query($db,$sql);
//     echo mysqli_error($db);
    echo ("<meta http-equiv=\"refresh\" content=\"0;URL='/erp/bfew/index.php?keyword=all+staff+leave+report&status=0'\" />");
  }
}else
  echo "error";
?>
<?php
$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
include($localPath."/includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

if($_GET['des']){
  $_GET['des']=urldecode($_GET['des']);
  $sql="select * from iowtemp where iowDes='$_GET[des]'";
}
if($_GET['iowId'])
$sql="select * from iowtemp where iowId='$_GET[iowId]'";

$q=mysqli_query($db,$sql);
$row=mysqli_fetch_array($q);

echo $row['iowDes']."=====================>";


if(mysqli_affected_rows($db)==1){
$iowDes=$row["iowDes"];
$iowProjectCode=$row["iowProjectCode"];
$position=$row["position"];

	$sqliow = "insert into iow SET iowDes='$iowDes', iowProjectCode='$iowProjectCode',  position='$position', 	iowCode='$position', iowStatus='noStatus', siow=''";	//save as iow description
  
  $q=mysqli_query($db,$sqliow);



 if(mysqli_affected_rows($db)>0){
   echo "done"; 
}
  else
    echo "<br><small style='color:red'><h3>#501</h3> <i>".mysqli_error($db)."</i></small>";
}

?>
<?
$todat=date("Y-m-d");
 include("../includes/config.inc.php");
 include("../includes/empFunction.inc.php");
 
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
	

$empId=$_POST['empId'];
$iow=$_GET['iow'];	
	
$sql22="SELECT * from employee where empId='$empId'";	
//echo "$sql22<br>";
$q=mysqli_query($db, $sql22);	
$re=mysqli_fetch_array($q);
//echo "**$re[empId],$re[designation]**";

$supervisor=empId($re[empId],$re[designation]);	
$userFullName=$re[name];
$projectCode=$re[location];
$sid=$re[empId].rand(100000000,9999999999);
/********************/



 $sql="INSERT INTO `user` (`id`, `uname`, `password`, `fullName`, `designation`, `projectCode`,`permission`, `datet`) 
  VALUES ('$sid', '$supervisor','123', '$userFullName', 'Task Supervisor','$projectCode', '$permission','$todat')";
// echo "$sql<br>";
 $adduserdb = mysqli_query($db, $sql);
	
/******************/	
	
 $sql="UPDATE iow set supervisor='$supervisor' WHERE iowId='$iow'";	
//echo "$sql<br>";
$sqlq=mysqli_query($db, $sql);

 $sql="UPDATE iowtemp set supervisor='$supervisor' WHERE iowId='$iow'";	
//echo "$sql<br>";
$sqlq=mysqli_query($db, $sql);

echo "Task Supervisor assigned.";
echo "<meta http-equiv=\"refresh\" content=\"1; URL=../index.php?keyword=site+iow+detail\"/>";
exit;
?>

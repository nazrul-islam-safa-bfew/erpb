<?
include("../includes/session.inc.php");
$loginUname=$_SESSION['loginUname'];
$poid=$_GET['poid'];
if($loginUname){
 include("../includes/config.inc.php");

$db=mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$vendor = "update porder set qty='0' WHERE poid='$poid' AND posl LIKE 'EP_%'";
//echo $vendor;
mysqli_query($db, $vendor);

echo "Purchase Order deleted";
echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=site+item+required\">";
}?>

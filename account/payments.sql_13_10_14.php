<?
error_reporting(0);
include("../includes/session.inc.php");
include("../includes/config.inc.php");
include_once("../includes/myFunction.php");
include_once("../includes/myFunction1.php");
include_once("../includes/accFunction.php");
include_once("../includes/empFunction.inc.php");
include_once("../includes/eqFunction.inc.php");
include_once("../includes/subFunction.inc.php");
include_once("../includes/matFunction.inc.php");
include_once('../includes/vendoreFunction.inc.php');
$toDate=todat();


  if(!empty($exfor) & $loginProject!='000')
	  $loginProject=$exfor;
	


$db = @mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
if (!$db) {
   die('Please try later..' );
}
	
$sql = "SELECT paymentSL, ROUND(sum(receiveQty*rate),3) as amount FROM `store220` group by paymentSL";
$query=mysqli_query($db, $sql);
while($row= mysqli_fetch_array($query)){
	if($row['paidAmount'] < 0)continue;
	echo $sql1 = "update purchase set paidAmount = '$row[amount]' where paymentSL='$row[paymentSL]'";
	mysqli_query($db, $sql1);
	echo mysqli_affected_rows($db);
	echo "<br>";
}

?>
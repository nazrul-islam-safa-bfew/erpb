<?
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
$db = @mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
if (!$db) {
   die('Please try later..' );
}
	
	
mysqli_query($db, "SET AUTOCOMMIT=0");
mysqli_query($db, "START TRANSACTION");	
$hcash_balance=balance_hcash('000', '2013-01-01',$toDate);
//created 23 no. line by salma
$hcash_balance=$hcash_balance+baseOpening('5501000','000');

if($hcash_balance<=0 AND 
($account=='5501000-000' OR $ct_from_account=='5501000-000')) {
echo wornMsg("No balance in head office cash!");
echo "<a href='../index.php?keyword=payments&w=$w'><--Go Back</a>";
exit;
}

if($hcash_balance<=0 AND 
($account=='5501000-000' OR $ct_from_account=='5501000-000')) {

//echo "$hcash_balance < $total";
echo wornMsg( "STOP!!! You cannot spend from negative balance");
 echo "<a href='../index.php?keyword=payments&w=$w'><--Go Back</a>";
 exit;
 }
//exit;
?>
<?
$paymentSL=generatePaymentSL($w,$loginProject,$paymentDate);

?>
<?
$
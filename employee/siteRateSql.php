<? 
include("../includes/session.inc.php");
include("../includes/myFunction.php");
?>

<?
include("../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

$itemcode = $_POST['itemcode'];
$amount = $_POST['amount'];

$sqlitem = "INSERT INTO siterate (itemcode, amount)".
"VALUES ('$itemcode', '$amount')";
// echo $sqlitem;
// exit;
$sqlrunItem= mysqli_query($db, $sqlitem);
$row=mysqli_affected_rows($db);
//echo $row;

if($row<1)
{
	$msg= "Your informations can't be saved...<br> <font >Please check the inputes May be Employee Id conflict ";

	echo errMsg($msg);
echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=site+rate\">";	
}
else {
	echo "Your informations are saving...<br> Wait Please...... ";
	echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=site+rate\">";
	}
?> 

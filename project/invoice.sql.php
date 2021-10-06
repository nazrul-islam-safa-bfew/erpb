<? 
if($approve){
include("../includes/config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
	
$sql11 = "UPDATE invoice set invoiceStatus=2 where invoiceNo='$invoiceNo'";
//echo $sql11.'<br>';
$sqlrunp11= mysql_query($sql11);
 }//if
else if($return){
include("../includes/config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
	
$sql11 = "UPDATE invoice set invoiceStatus=0 where invoiceNo='$invoiceNo'";
//echo $sql11.'<br>';
$sqlrunp11= mysql_query($sql11);
 }//if

echo "information updating.....";
echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=view+invoice\">";

?>

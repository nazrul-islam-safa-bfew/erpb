<? 
include("../includes/session.inc.php");
include("../includes/config.inc.php");
include("../includes/myFunction.php");

$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$edate=formatDate($edate, 'Y-m-d');
$todat = todat();
for($i=1;$i<$n;$i++){
			$sqlitem1 = "INSERT INTO `storet$project` (rsid,itemCode, receiveQty,currentQty, rate, paymentSL, reference, remark,todat)".
						 "VALUES ('','${itemCode.$i}', '${dqty.$i}','${dqty.$i}', '${rate.$i}', '$posl', '$eqtsl', '$remark', '$edate')";

						echo '<br>'.$sqlitem1.'<br>';
						
			$query= mysql_query($sqlitem1);	 
}			
?>
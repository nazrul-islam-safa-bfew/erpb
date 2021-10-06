 <? // send purchase order for Revision
 include("../../includes/config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);

$sql11="select * from porder WHERE posl not LIKE 'EP_%' ORDER by poid ASC";
//echo $sql11.'<br>';
$sq=mysql_query($sql11);
while($r=mysql_fetch_array($sq)){

$sql="UPDATE  poschedule set posl='$r[posl]', itemCode='$r[itemCode]' where posl=$r[poid]";
//echo "<br>$sql";
mysql_query($sql);
}

?>
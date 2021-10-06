<? include("../includes/config.inc.php");
include("../includes/myFunction.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);

/*$sql=mysql_query("select * from project");
while($r=mysql_fetch_array($sql)){
//mysql_query("ALTER TABLE `issue$r[pcode]` ADD `supervisor` VARCHAR( 20 ) NOT NULL") ;
//mysql_query("ALTER TABLE `issue$r[pcode]` ADD `reference` VARCHAR( 200 ) NOT NULL AFTER `issueDate`") ;

//echo "ALTER TABLE `issue$r[pcode]` ADD `supervisor` VARCHAR( 20 ) NOT NULL<br>";
}*/

$sql="select * from porder where vid='105' and location='143'";
echo "$sql<br>";
$sqlq=mysql_query($sql);
while($r=mysql_fetch_array($sqlq)){

$sql2="UPDATE store143 set rate='$r[rate]' where paymentSL='$r[posl]' and itemCode='$r[itemCode]'";
echo "$sql2<br>";
mysql_query($sql2);
}
?>
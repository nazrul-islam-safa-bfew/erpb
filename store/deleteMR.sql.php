<?
include("../includes/session.inc.php");
include("../includes/config.inc.php");
include("../includes/myFunction.php");

$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
	
$sql="DELETE from store$p where rsid=$rsid and receiveQty=currentQty";
echo "$sql";
mysql_query($sql);
$ac=mysql_affected_rows();
echo "* $ac**";
if($ac>0){
echo "MR deleted. ";
//echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=store+transfer\">";	

}
else {
$m="informations can't be deleted...<br> maybe quantity issued Please check again......... ";
echo wornMsg($m);
}
?>
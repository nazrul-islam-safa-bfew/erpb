<?php
include('../config.inc.php');


$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
	
$q=mysql_query("SELECT * FROM porder WHERE posl = 'PO_193_07033_965'");
$row=mysql_fetch_row($q);
echo $row[2].mysql_affected_rows();

?>
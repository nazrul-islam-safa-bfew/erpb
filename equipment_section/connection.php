<?php
$db_name = "bfew";
$connection = @mysql_connect("mysql.bfew.net","bfew","bfew007") 
	or die("Couldn't connect.");

$db = @mysql_select_db($db_name, $connection)
	or die("Couldn't select database.");

?>

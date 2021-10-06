<?php
							$db_equip = "equipment_section";
$connection_equip = @mysql_connect("mysqleq.bfew.net","eqsection","eqsection") 
	or die("Couldn't connect.");

$conn = @mysql_select_db($db_equip, $connection_equip)
	or die("Couldn't select database.");

?>

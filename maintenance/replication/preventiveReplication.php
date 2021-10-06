<?php
include("../../includes/config.inc.php");
$db=mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
include("eqMaintenance.php");


if($_GET["deleteOld"]){
  
}
else
  preventiveReplication();




$time_end = microtime(true);
//dividing with 60 will give the execution time in minutes other wise seconds
$execution_time = ($time_end - $_SERVER["REQUEST_TIME_FLOAT"]);
//execution time of the script
echo '<b>Total Execution Time:</b> '.$execution_time.' Sec';


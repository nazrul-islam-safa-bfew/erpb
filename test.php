<?php
$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
include($localPath."/includes/config.inc.php"); //datbase_connection
include($localPath."/includes/session.inc.php");
include($localPath."/includes/myFunction.php"); // some general function
//echo "erp";
if($_GET["S"])
	$_SESSION["S"]=1;
// echo $_SESSION["S"];
// log work
$sql="insert into log values ('','IP:".$_SERVER['REMOTE_ADDR'].", Proxy:".$_SERVER['HTTP_X_FORWARDED_FOR']."','123')";
mysqli_query($db,$sql);
// end log work

include_once($localPath."/includes/myFunction1.php"); // some general function
include_once($localPath."/includes/accFunction.php"); //all accounts function
include_once($localPath."/includes/empFunction.inc.php"); //manpower function
include_once($localPath."/includes/eqFunction.inc.php"); // equipment function

include_once($localPath."/includes/subFunction.inc.php"); // sub contracts function

include_once($localPath."/includes/matFunction.inc.php"); // material function

include_once($localPath.'/includes/vendoreFunction.inc.php'); // vendor related function
require_once($localPath."/keys.php"); // created and powered by function and link






echo remainQty6($posl,$typel12[itemCode],$loginProject); 




?>
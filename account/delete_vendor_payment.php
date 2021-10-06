<?php
if($_GET['qqq']){
$qqq=$_GET['qqq'];

include("../includes/config.inc.php");
$db = @mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
		

for($qq1=0;$qq1<=count($vpa);$qq1++)
	$qqq=$vpa[$qq1].", ".$qqq;
	
mysqli_query($db, "delete from vendorPaymentApproval where vpa in (".trim($qqq,", ").")");
}
echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=payments&w=$w&year=$year&month=$month&vid=$vid&exfor=$exfor\">";
?>
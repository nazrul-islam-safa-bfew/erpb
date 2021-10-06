<?php
include("common.php");
CreateConnection();
$vendor_id = $_GET['vend_id'];
$qry2="SELECT vendor_address FROM vendor_setup WHERE vendor_id='$vendor_id'";
$qryexecute2=mysqli_query($db, $qry2);
$vend_contact=mysql_result($qryexecute2,0,0);
echo"$vend_contact";
 ?>
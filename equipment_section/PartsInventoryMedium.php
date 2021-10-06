<?php 
include("common.php");
CreateConnection();
$hidden=$_POST['hidField'];
$hidPartNo=$_POST['hidPartid'];
//creating session for the part which nwill be edited or deleted
session_start();
$_SESSION['partno']=$hidPartNo;
//echo("$hidPartNo");


if($hidden==4)
{

$qry="SELECT part_name,part_desc,part_manufacturer,vendor,part_category,part_unit_cost,unit_type,part_warranty,upc,location_stored,bin,location_assign,part_picture FROM parts_inventory WHERE part_number='$hidPartNo'";
$qryexecute=mysqli_query($db, $qry);

while($rs=mysql_fetch_row($qryexecute))
{
$part_name=$rs[0];
$part_desc=$rs[1];
$part_manufacturer=$rs[2];
$vendor=$rs[3];
$part_category=$rs[4];
$part_unit_cost=$rs[5];
$unit_type=$rs[6];
$part_warranty=$rs[7];
$upc=$rs[8];
$location_stored=$rs[9];
$bin=$rs[10];
$location_assign=$rs[11];
$part_picture=$rs[12];
}

header("Location: EditInventoryPart.php?hidPartNo=$hidPartNo&part_name=$part_name&part_desc=$part_desc&part_manufacturer=$part_manufacturer&vendor=$vendor&part_category=$part_category&part_unit_cost=$part_unit_cost&unit_type=$unit_type&part_warranty=$part_warranty&upc=$upc&location_stored=$location_stored&bin=$bin&location_assign=$location_assign&part_picture=$part_picture");
}

?>
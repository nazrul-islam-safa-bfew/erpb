<?php
include("common.php");
CreateConnection();
//------------------------Hidden Field Value Association------------------
$Part_ID=$_POST['hid_part_id'];
$hidden=$_POST['hidField'];
//------------------------------END----------------


//----------------------Tracking SelectPartNumber Menue's OnChange Event------------------------
if($hidden==1)
{
									  include("connection.php");

$qry="SELECT itemDes,itemSpec FROM itemlist WHERE itemCode='$Part_ID'";
$qryexecute=mysqli_query($db, $qry,$connection);
$rs=mysql_fetch_row($qryexecute);
$itemDes=$rs[0];
$itemSpec=$rs[1];
//echo $Part_ID;
//SELECT ITEM RATE FROM quotation TABLE BASED ON SELECTED ITEMCODE...
$rate1="SELECT MAX(rate) FROM quotation WHERE itemCode='$Part_ID'";
$rate_execute=mysqli_query($db, $rate1,$connection);
$rs_rate=mysql_fetch_row($rate_execute);
$rate=$rs_rate[0];
header("Location: Edit_preventive_services_AddPartsUsed.php?Part_ID=$Part_ID&part_name=$itemDes&part_desc=$itemSpec&part_unit_cost=$rate");
}

//----------------------Tracking Save Buttons OnClick Event------------------------
else if($hidden==2)
{
//---Assining Session value which store the Work Order Id initiated at the NewWorkOrder.php page--
session_start();
$work_order_id=$_SESSION['workorder_id'];
//-------------------------------------------------END-----------------------------------

//---Assining Session value which store the PM Service Id initiated at the NewWorkOrder_Add_PM_Entry.php page--
session_start();
$pm_service_id=$_SESSION['pm_service_id'];
//echo"$pm_service_id";
//-------------------------------------------------END-----------------------------------


$part_num=$_POST['SelectPartNumber'];
$txtName=$_POST['txtName'];
$txtDesc=$_POST['txtDesc'];
$txtWarrenty=$_POST['txtWarrenty'];
$txtQuantity=$_POST['txtQuantity'];
$txtUnitCost=$_POST['txtUnitCost'];
$txtExtendedCost=$_POST['txtExtendedCost'];
$qry="INSERT INTO new_work_order_part_used(work_order_id,pm_service_id,part_num,part_name,part_desc,part_warrenty,part_quantity,part_unit_cost,part_extended_cost) VALUES ('$work_order_id','$pm_service_id','$part_num','$txtName','$txtDesc','$txtWarrenty','$txtQuantity','$txtUnitCost','$txtExtendedCost')";

$qryexecute=mysqli_query($db, $qry);

header("Location: Edit_preventive_services.php?count=1");


//--Accessing javascript from PHP---------
/*
echo '<script type="text/javascript">
window.close();
</script>';
*/
}
//-------------------------------Tracking Close Buttons onClick Event--------------------------
else if($hidden==3)
{
header("Location: Edit_preventive_services.php?count=1");
}

?>
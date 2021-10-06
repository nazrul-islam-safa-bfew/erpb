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
$qry="SELECT part_name,part_desc,part_warranty,part_unit_cost FROM parts_inventory WHERE part_number='$Part_ID'";
$qryexecute=mysqli_query($db, $qry);
$rs=mysql_fetch_row($qryexecute);
$part_name=$rs[0];
$part_desc=$rs[1];
$part_warranty=$rs[2];
$part_unit_cost=$rs[3];

header("Location: Edit_Delete_PartsUsed.php?Part_ID=$Part_ID&part_name=$part_name&part_desc=$part_desc&part_warranty=$part_warranty&part_unit_cost=$part_unit_cost");
}
//---------------------------------------Updating the records(Using Edit_Delete_PartsUsed.php page)------------------------
else if($hidden==2)
{
$part_num=$_POST['SelectPartNumber'];
$txtName=$_POST['txtName'];
$txtDesc=$_POST['txtDesc'];
$txtWarrenty=$_POST['txtWarrenty'];
$txtQuantity=$_POST['txtQuantity'];
$txtUnitCost=$_POST['txtUnitCost'];
$txtExtendedCost=$_POST['txtExtendedCost'];
//---Assining Session value which store the Work Order Id initiated at the NewWorkOrder.php page--
session_start();
$work_order_id=$_SESSION['workorder_id'];
//echo"$work_order_id<br>";
//-------------------------------------------------END-----------------------------------


//---Assining Session value which store the PM Service Id  initiated at the NewWorkWorder_Add_PM_Entry.php page--
$pm_service_id=$_SESSION['pm_service_id'];
//echo"$pm_service_id<br>";
//-------------------------------------------------END-----------------------------------

//---Assining Session value which store the Part_num initiated at the NewWorkOrder_Repair_EntryMedium.php page when a row is clicked--
$part_id=$_SESSION['part_num'];
//echo"$part_id<br>";
//-------------------------------------------------END-----------------------------------


$qry="UPDATE new_work_order_part_used SET part_num='$part_num',part_name='$txtName',part_desc='$txtDesc',part_warrenty='$txtWarrenty',part_quantity='$txtQuantity',part_unit_cost='$txtUnitCost',part_extended_cost='$txtExtendedCost' WHERE work_order_id='$work_order_id' AND pm_service_id='$pm_service_id' AND part_num='$part_id'";
$qryexecute=mysqli_query($db, $qry);
header("Location: NewWorkWorder_Add_PM_Entry.php?count=1");
}

//-------------------------------Tracking Delete Buttons onClick Event--------------------------

else if($hidden==3)
{

//---Assining Session value which store the Work Order Id initiated at the NewWorkOrder.php page--
session_start();
$work_order_id=$_SESSION['workorder_id'];
//echo"$work_order_id";
//-------------------------------------------------END-----------------------------------


//---Assining Session value which store the Repair Type initiated at the NewWorkOrder_Repair_entry.php page--
session_start();
$pm_service_id=$_SESSION['pm_service_id'];
//echo"$work_order_id";
//-------------------------------------------------END-----------------------------------

//---Assining Session value which store the Part_num initiated at the NewWorkOrder_Repair_EntryMedium.php page when a row is clicked--
session_start();
$part_id=$_SESSION['part_num'];
//echo"$part_id";
//-------------------------------------------------END-----------------------------------
$qry1="DELETE FROM new_work_order_part_used WHERE work_order_id='$work_order_id' AND pm_service_id='$pm_service_id' AND part_num='$part_id'";
$qryexecute1=mysqli_query($db, $qry1);
header("Location: NewWorkWorder_Add_PM_Entry.php?count=1");
}

//-------------------------------Tracking Close Buttons onClick Event--------------------------
else if($hidden==4)
{
header("Location: NewWorkWorder_Add_PM_Entry.php?count=1");
}

?>
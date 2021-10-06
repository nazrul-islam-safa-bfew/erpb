<?php 
include("common.php");
CreateConnection();
$hid=$_POST['hidField'];

//echo("$pm_service_id");
//----------------------Calling AddPartsUsed.php page for part association-----------------
if($hid==1)
{
header("Location: Edit_repair_services_AddRepairPartsUsed.php");
}
//---For Edit
else if($hid==2)
{
$part_id=$_POST['hidPartNo'];

//------------------------STORING THE PART NUMBER IN SESSION---------------
session_start();
$_SESSION['part_num']=$part_id;

//--------------------Retreiving Work_order number---------------
$work_order_id=$_SESSION['workorder_id'];

//-Assining Session value which store the Repair Name  initiated at the NewWorkOrder_Repair_Entry.php(by calling-server.php) page--
$repair_type=$_SESSION['repair'];

//echo("$part_id");
//echo("$pm_service_id");
//echo("$work_order_id");

//----------------Query to retrieving data based on these session value...............

$qry="SELECT part_name,part_desc,part_warrenty,part_quantity,part_unit_cost,part_extended_cost FROM new_work_order_repair_parts_used WHERE work_order_id='$work_order_id' AND repair_type='$repair_type' AND part_num='$part_id'";

$qryexecute=mysqli_query($db, $qry);
$rs=mysql_fetch_row($qryexecute);
$part_name=$rs[0];
$part_desc=$rs[1];
$part_warrenty=$rs[2];
$part_quantity=$rs[3];
$part_unit_cost=$rs[4];
$part_extended_cost=$rs[5];

header("Location: EditWorkOrder_Edit_Delete_Repair_PartsUsed.php?Part_ID=$part_id&part_name=$part_name&part_desc=$part_desc&part_warranty=$part_warrenty&part_quantity=$part_quantity&part_unit_cost=$part_unit_cost&part_extended_cost=$part_extended_cost");


//echo"$part_name";
//echo"$part_desc";
}


//----------------------Saving the entry of Edit_repair_services.php Page.................


else if($hid==3)
{
//-----------------------Assigning Posted value from NewWorkOrder_Add_PM_Entry.php page to the variable----
//assigning SYSTEM DATE----===
$pm_date=date("Y-m-d");
$part_cost=$_POST['txt_part_cost'];
$labor_cost=$_POST['txt_labor_cost'];
$total_cost=$_POST['txt_total_cost'];

//--------------------Retreiving Repair Type number---------------
session_start();
$repair_type=$_SESSION['repair'];

//--------------------Retreiving Work_order number---------------
session_start();
$work_order_id=$_SESSION['workorder_id'];



//check wheather  the requeted REPAIR service is already added or not to the corresponding work order
$check="SELECT * FROM new_work_order_repairs_info WHERE work_order_id='$work_order_id' AND repair_type='$repair_type'";
$execute_check=mysqli_query($db, $check);
$count=mysql_num_rows($execute_check);

//if the repair service is not exist..
if($count==0)
{
$qry="INSERT INTO new_work_order_repairs_info (work_order_id,repair_type,pm_date,parts_cost,labor_cost,total_cost) VALUES ('$work_order_id','$repair_type','$pm_date','$part_cost','$labor_cost','$total_cost')";

$qryexecute=mysqli_query($db, $qry);

header("Location: Edit_work_order.php?count=1&t=7");
}
//if the repair service is exist....
else
{
//then update the existing repair service...
$update="UPDATE new_work_order_repairs_info SET pm_date='$pm_date',parts_cost='$part_cost',labor_cost='$labor_cost',total_cost='$total_cost' WHERE work_order_id='$work_order_id' AND repair_type='$repair_type'";
$execute_update=mysqli_query($db, $update);

header("Location: Edit_work_order.php?count=1&t=7");
}

}

//-------------------------------Tracking Close Buttons onClick Event--------------------------
else if($hid==4)
{
header("Location: Edit_work_order.php?count=1&t=7");
}
//-------------Tracking ADD(Labor section) Buttons onClick Event(Edit_repair_services.php page----For add labor details)------
else if($hid==5)
{
header("Location: Edit_repair_services_Add_Repair_LaborUsed.php");
}
// For labor section edit
else if($hid==6)
{
$labor_id=$_POST['hidLaborid'];

//------------------------STORING THE LABOR ID  IN SESSION---------------
session_start();
$_SESSION['labor_id']=$labor_id;
//---------------Retreiving pm_service_id---------
session_start();
$pm_service_id=$_SESSION['pm_service_id'];

//--------------------Retreiving Work_order number---------------
$work_order_id=$_SESSION['workorder_id'];
//echo("$part_id");
//echo("$pm_service_id");
//echo("$work_order_id");

//----------------Query to retrieving data based on these session value...............

$qry="SELECT desc_of_work,emp_labor_rate,work_hour,lobor_cost FROM new_work_order_pm_labor_used WHERE work_order_id='$work_order_id' AND pm_service_id='$pm_service_id' AND emp_id='$labor_id'";

$qryexecute=mysqli_query($db, $qry);
$rs=mysql_fetch_row($qryexecute);
$desc_of_work=$rs[0];
$emp_labor_rate=$rs[1];
$work_hour=$rs[2];
$lobor_cost=$rs[3];

header("Location: Edit_Delete_PM_LaborUsed.php?desc_of_work=$desc_of_work&emp_labor_rate=$emp_labor_rate&work_hour=$work_hour&lobor_cost=$lobor_cost");

}


?>

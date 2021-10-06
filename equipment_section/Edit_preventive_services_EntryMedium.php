<?php 
include("common.php");
CreateConnection();
$hid=$_POST['hidField'];

//echo("$pm_service_id");
//----------------------Calling Edit_preventive_services_AddPartsUsed.php page for part association-----------------
if($hid==1)
{
session_start();
$pm_service_id=$_SESSION['pm_service_id'];
//echo"$pm_service_id";

header("Location: Edit_preventive_services_AddPartsUsed.php");
}
//----------------------Saving the entry of NewWorkOrder_Add_PM_Entry.php Page.................


else if($hid==3)
{
//-----------------------Assigning Posted value from Edit_preventive_services.php page to the variable----
//assigning SYSTEM DATE----===
$pm_date=date("Y-m-d");
$part_cost=$_POST['txt_part_cost'];
$labor_cost=$_POST['txt_labor_cost'];
$total_cost=$_POST['txt_total_cost'];

//---------------Retreiving pm_service_id---------
session_start();
$pm_service_id=$_SESSION['pm_service_id'];

//--------------------Retreiving Work_order number---------------
session_start();
$work_order_id=$_SESSION['workorder_id'];

//check wheather  the requeted PM service is already added or not to the corresponding work order
$check="SELECT * FROM new_work_order_parts_info WHERE work_order_id='$work_order_id' AND pm_service_id='$pm_service_id'";
$execute_check=mysqli_query($db, $check);
$count=mysql_num_rows($execute_check);
//if the pm service is already exist..

if($count==0)
{
//insert a new record....
$qry="INSERT INTO new_work_order_parts_info (work_order_id,pm_service_id,pm_date,parts_cost,labor_cost,total_cost) VALUES ('$work_order_id','$pm_service_id','$pm_date','$part_cost','$labor_cost','$total_cost')";
$qryexecute=mysqli_query($db, $qry);
}
else
{
//update the existing preventive maintenance...
$update="UPDATE new_work_order_parts_info SET pm_date='$pm_date',parts_cost='$part_cost',labor_cost='$labor_cost',total_cost='$total_cost' WHERE work_order_id='$work_order_id' AND pm_service_id='$pm_service_id'";
$execute_update=mysqli_query($db, $update);
}

header("Location: Edit_work_order.php?count=1");
}

//-------------------------------Tracking Close Buttons onClick Event(Edit_preventive_services.php page)-----------------------
else if($hid==4)
{
header("Location: Edit_work_order.php?count=1");
}
//-------------------------------Add Labour Details to the edited work order...------
else if($hid==5)
{
header("Location: Edit_work_order_PM_LaborUsed.php?count=1");
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
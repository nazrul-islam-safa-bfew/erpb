<?php 
include("common.php");
CreateConnection();

//.......assigning the hidden variable value to the variable for executing a paritucular block of code depending upon  which button is clicked in NewWorkWorder.php page............................
$hid=$_POST['hidField'];


//----------------------Opening Pages Based Upon Hidden Field's Value Posted Form the NewWorkWorder.php page  ---------------------
//----For PM Entry-----//
if($hid==1)
{
header("Location: NewWorkWorder_Add_PM_Entry.php");
}
//----For Repair Entry-----//
else if($hid==2)
{
header("Location: NewWorkWorder_Repair_Entry.php");
} 
//----------Saving the record----------//
else if($hid==4)
{
//assigning system date for tracking which work order is created on which date...
$work_order_Entry_Date=date("Y-m-d");

//Rendering Session Values...............
session_start();
$equipment_id=$_SESSION['equip_id'];
$work_order_id=$_SESSION['workorder_id'];
//echo"$equipment_id";
//echo"$work_order_id";

//----------Assigning posted value to the variable...................
$txt_issued=$_POST['txt_issued'];
$txt_complete=$_POST['txt_complete'];
$txtMeter=$_POST['txtMeter'];
$selectStatus=$_POST['selectStatus'];
$selectVendor=$_POST['selectVendor'];
$selectAssigned=$_POST['selectAssigned'];
$PO=$_POST['txtPO'];
$Invoice=$_POST['txtInvoice'];
$txt_workOrder_notes=$_POST['txt_workOrder_notes'];
//---all cost variables---//
$pm_total=$_POST['txt_pm_total'];
$repair_total=$_POST['txt_repair_total'];
$txtPartCost=$_POST['txtPartCost'];
$txt_labor_cost=$_POST['txt_labor_cost'];
$external_service_total=$_POST['txt_external_service_total'];
$udf_cost=$_POST['txt_udf_cost'];
$sub_total=$_POST['txt_sub_total'];
$discount=$_POST['txt_discount'];
$pre_tax=$_POST['txt_pre_tax'];
$tax_amount=$_POST['txt_tax_amount'];
$grand_total=$_POST['txt_grand_total'];

mysqli_query($db, "BEGin;"); 
//BEGIN TRANSACTION
//----------Inserting Data To the Table "new_work_order_main" .................//

$qry="INSERT INTO new_work_order_main(item_id,work_order_id,issued_date,closed_date,equipment_meter,work_order_status,vendor,assigned_to,purchase_order,invoice,pm_cost,repair_cost,parts_cost,labor_cost,external_service_cost,udf_cost,sub_total,discount_amt,pre_tax_amt,tax_amt,grand_total,work_order_comment,entry_date)VALUES('$equipment_id','$work_order_id','$txt_issued','$txt_complete','$txtMeter','$selectStatus','$selectVendor','$selectAssigned','$PO','$Invoice','$pm_total','$repair_total','$txtPartCost','$txt_labor_cost','$external_service_total','$udf_cost','$sub_total','$discount','$pre_tax','$tax_amount','$grand_total','$txt_workOrder_notes','$work_order_Entry_Date')";
$qryexecute=mysqli_query($db, $qry);

//UPDATE THE METER READING OF THE EQUIPMENT TO SET THE NEXT PLANNED MAINTENANCE DATE...(UPDATEING track_equipments TABLE)
$qry_track="UPDATE track_equipments SET item_curr_kilometer='$txtMeter',item_base_kilometer='$txtMeter',update_curr_meter_date='$work_order_Entry_Date',item_base_date='$work_order_Entry_Date' WHERE itm_track_id='$equipment_id'";
$qry_track_execute=mysqli_query($db, $qry_track);

//CHECK TO SEE IF THE EQUIPMENT CORRESPONDING TO THE WORK ORDER HAS THE MAINTENANCE BASED on FIXED DATE...
$test="SELECT fixed_date FROM add_pm_service WHERE pm_service_id=(SELECT pm_service_id FROM add_equipment_maintenance WHERE itm_track_id='$equipment_id')";
$execute_test=mysqli_query($db, $test);
$rs=mysql_fetch_row($execute_test);
$track=$rs[0];
//if the equipment is not fixed date based then set the wo_status=0 i.e.though the work order is issued but the next planned maintenance date is added to the equipment...
if($track=="0000-00-00")
{
//note: "0000-00-00" means the date is blank.
$qry_equip_maintenance="UPDATE add_equipment_maintenance SET item_curr_kilometer='$txtMeter',update_curr_meter_date='$work_order_Entry_Date' WHERE itm_track_id='$equipment_id'";
$qry_equip_maintenance_execute=mysqli_query($db, $qry_equip_maintenance);
}
//if the equipment is fixed date based then set the field wo_status=0.i.e. Work order aginst this equipment is issued and it no longer due for maintenance and will not appear on the main screen...
else
{
$qry_equip_maintenance="UPDATE add_equipment_maintenance SET item_curr_kilometer='$txtMeter',update_curr_meter_date='$work_order_Entry_Date',wo_status='1' WHERE itm_track_id='$equipment_id'";
$qry_equip_maintenance_execute=mysqli_query($db, $qry_equip_maintenance);
}

mysqli_query($db, "COMMIT;"); 
//END TRANSACTION
header("Location: NewWorkWorder_print.php");
} 
//----For External Service Entry-----//
else if($hid==3)
{
header("Location: NewWorkWorder_ExternalService_Entry.php");
} 
//this will delete the record associated with the work order id from all the tables deal with work order if the user close the NewWorkWorder.php page without save it...
else if($hid==5)
{
//Rendering Session Values...............
session_start();
$work_order_id=$_SESSION['workorder_id'];

//DELETE RECORDS FROM THE new_work_order_parts_info TABLE...
$qry_pm_info="DELETE FROM new_work_order_parts_info WHERE work_order_id='$work_order_id'";
$qryexecute_pm_info=mysqli_query($db, $qry_pm_info);

//DELETE RECORDS FROM THE new_work_order_part_used TABLE...
$qry_part_used="DELETE FROM new_work_order_part_used WHERE work_order_id='$work_order_id'";
$qryexecute_part_used=mysqli_query($db, $qry_part_used);

//DELETE RECORDS FROM THE new_work_order_pm_labor_used TABLE...
$qry_labor_used="DELETE FROM new_work_order_pm_labor_used WHERE work_order_id='$work_order_id'";
$qryexecute_labor_used=mysqli_query($db, $qry_labor_used);

//DELETE RECORDS FROM THE new_work_order_repairs_info TABLE...
$qry_repair_info="DELETE FROM new_work_order_repairs_info WHERE work_order_id='$work_order_id'";
$qryexecute_repair_info=mysqli_query($db, $qry_repair_info);

//DELETE RECORDS FROM THE new_work_order_repair_labor_used TABLE...
$qry_repair_labor="DELETE FROM new_work_order_repair_labor_used WHERE work_order_id='$work_order_id'";
$qryexecute_repair_labor=mysqli_query($db, $qry_repair_labor);

//DELETE RECORDS FROM THE new_work_order_repair_parts_used TABLE...
$qry_repair_parts="DELETE FROM new_work_order_repair_parts_used WHERE work_order_id='$work_order_id'";
$qryexecute_repair_parts=mysqli_query($db, $qry_repair_parts);

//DELETE RECORDS FROM THE new_work_order_external_service_entry TABLE...
$qry_external="DELETE FROM new_work_order_external_service_entry WHERE work_order_id='$work_order_id'";
$qryexecute_external=mysqli_query($db, $qry_external);

} 


?>
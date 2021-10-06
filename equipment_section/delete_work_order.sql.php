<?php
include("common.php");
CreateConnection();
//assign the work order id which needs to be deleted to the variable
$work_order_id=$_GET['id'];
//echo"$work_order_id";

//QUERY TO DELETE THE RECORD FROM THE ASSOCIATED TABLE CORRESPONDING TO THE WORK ORDER ID
mysqli_query($db, "BEGin;");

//delete record from the new_work_order_main table
$qry_main="DELETE FROM new_work_order_main WHERE work_order_id='$work_order_id'";
$qryexecute_main=mysqli_query($db, $qry_main);

//delete record from the new_work_order_parts_info table
$qry_parts_info="DELETE FROM new_work_order_parts_info WHERE work_order_id='$work_order_id'";
$qryexecute_parts_info=mysqli_query($db, $qry_parts_info);

//delete record from the new_work_order_part_used table
$qry_part_used="DELETE FROM new_work_order_part_used WHERE work_order_id='$work_order_id'";
$qryexecute_part_used=mysqli_query($db, $qry_part_used);

//delete record from the new_work_order_pm_labor_used table
$qry_pm_labor_used="DELETE FROM new_work_order_pm_labor_used WHERE work_order_id='$work_order_id'";
$qryexecute_pm_labor_used=mysqli_query($db, $qry_pm_labor_used);

//delete record from the new_work_order_repairs_info table
$qry_repairs_info="DELETE FROM new_work_order_repairs_info WHERE work_order_id='$work_order_id'";
$qryexecute_repairs_info=mysqli_query($db, $qry_repairs_info);

//delete record from the new_work_order_repair_labor_used table
$qry_repair_labor_used="DELETE FROM new_work_order_repair_labor_used WHERE work_order_id='$work_order_id'";
$qryexecute_repair_labor_used=mysqli_query($db, $qry_repair_labor_used);

//delete record from the new_work_order_repair_parts_used table
$qry_repair_parts_used="DELETE FROM new_work_order_repair_parts_used WHERE work_order_id='$work_order_id'";
$qryexecute_repair_parts_used=mysqli_query($db, $qry_repair_parts_used);

//delete record from the new_work_order_external_service_entry table
$qry_external_service_entry="DELETE FROM new_work_order_external_service_entry WHERE work_order_id='$work_order_id'";
$qryexecute_external_service_entry=mysqli_query($db, $qry_external_service_entry);

mysqli_query($db, "COMMIT;");

//redirecting to the WorkOrderManagment.php page after deleting record
header("Location: WorkOrderManagment.php");
?>

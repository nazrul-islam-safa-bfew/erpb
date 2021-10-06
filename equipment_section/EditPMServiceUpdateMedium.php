<?php 
include("common.php");
CreateConnection();

//-------------------------------------Assigning Header Value from "MediumPMService.php"-------------------------------//

$pm_id=$_GET['pm_id'];
$schedule_id=$_GET['scheduleid'];
$s_name=$_GET['s_name'];
$s_pm_type=$_GET['s_pm_type'];
$enable=$_GET['enable'];
$priority=$_GET['priority'];
$day=$_GET['day'];
$cmbperiod=$_GET['cmbperiod'];
$cmbfixeddate=$_GET['cmbfixeddate'];
$txtnotifyday=$_GET['txtnotifyday'];
$txteveryhour=$_GET['txteveryhour'];
$txtfixedhour=$_GET['txtfixedhour'];
$txtnotifyhour=$_GET['txtnotifyhour'];
$cmbstart_date=$_GET['cmbstart_date'];
$cmbend_date=$_GET['cmbend_date'];
$cmbdate=$_GET['cmbdate'];
$cmbhour=$_GET['cmbhour'];



$qry="UPDATE add_pm_service SET pm_service_name='$s_name',item_pm_type='$s_pm_type',pm_service_enabled='$enable',pm_service_priority='$priority',number_of_day='$day', day_period='$cmbperiod',fixed_date='$cmbfixeddate',notify_day_advance='$txtnotifyday',hour_number='$txteveryhour',fixed_hour='$txtfixedhour',notify_hour_advance='$txtnotifyhour',season_start_date='$cmbstart_date',season_end_date='$cmbend_date', terminate_task_date='$cmbdate',terminate_task_hour='$cmbhour' WHERE pm_service_id='$pm_id'";

$qryexecute=mysqli_query($db, $qry);
//mysql_close();

if($qryexecute)
{
header("Location: PMScheduleSetup.php?schedule_id=$schedule_id");
}


?>
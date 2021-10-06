<?php
include("common.php");
CreateConnection();

//---------------------------------Generating ID Number for SCHEDULE---------------------------------------------------------//

$query = "SELECT MAX(pm_service_id) FROM add_pm_service";
$db_result = mysqli_query($db, $query);
$datapoint = mysql_result($db_result, 0, 0);

if($datapoint==0)
{
$pm_service_id=100;
//echo("$vendor_id");
}
else
{
$pm_service_id=$datapoint+1;
//echo("$vendor_id");
}

//-------------------------------------Assigning Posted Value from "AddPMService.php"-------------------------------//

$s_name=$_POST['txtservice'];
$s_pm_type=$_POST['txttype'];
$enable=$_POST['txtenable'];
$priority=$_POST['txtpriority'];
$day=$_POST['txtday'];
$cmbperiod=$_POST['cmbperiod'];
$cmbfixeddate=$_POST['loaddate'];
$txtnotifyday=$_POST['txtnotifyday'];
$txteveryhour=$_POST['txteveryhour'];
$txtfixedhour=$_POST['txtfixedhour'];
$txtnotifyhour=$_POST['txtnotifyhour'];
$cmbstart_date=$_POST['loadstart'];
$cmbend_date=$_POST['loadend'];
$cmbdate=$_POST['loadterminatedate'];
$cmbhour=$_POST['cmbhour'];
$select_task_based=$_POST['select_task_based'];
//echo("$cmbfixeddate");
//------------------------------------END---------------------------------------------------------

//---------------------------------------Inserting Record into new_schedule_type Table............. 


$ins_record="INSERT INTO add_pm_service (pm_service_id,pm_service_name,item_pm_type,pm_service_enabled,pm_service_priority,number_of_day, day_period,fixed_date,notify_day_advance,hour_number,fixed_hour,notify_hour_advance,season_start_date,season_end_date, terminate_task_date,terminate_task_hour,task_base)VALUES ('$pm_service_id','$s_name','$s_pm_type','$enable','$priority','$day','$cmbperiod','$cmbfixeddate','$txtnotifyday', '$txteveryhour','$txtfixedhour','$txtnotifyhour','$cmbstart_date','$cmbend_date','$cmbdate','$cmbhour','$select_task_based')";
$record_inserted=mysqli_query($db, $ins_record);

if($ins_record)
{

header("Location: PMScheduleSetup.php");

}
?>




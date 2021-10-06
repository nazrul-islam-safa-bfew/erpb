<?php 
include("common.php");
CreateConnection();
$pm_service_id=$_GET['pm_id'];

$ins_record="SELECT pm_service_id,schedule_id,pm_service_name,item_pm_type,pm_service_enabled,pm_service_priority,number_of_day,  day_period,fixed_date,notify_day_advance,hour_number,fixed_hour,notify_hour_advance,season_start_date,season_end_date, terminate_task_date,terminate_task_hour FROM add_pm_service WHERE pm_service_id='$pm_service_id'";

$record_selected=mysqli_query($db, $ins_record);

$rs=mysql_fetch_row($record_selected);

//-------------------------------------------Assigning values to the variables returned by the "$ins_record " Query--------------
$pm_service_id=$rs[0];
$schedule_id=$rs[1];
$pm_service_name=$rs[2];
$item_pm_type=$rs[3];
$pm_service_enabled=$rs[4];
$pm_service_priority=$rs[5];
$number_of_day=$rs[6];
$day_period=$rs[7];

$fixed_date=$rs[8];
$notify_day_advance=$rs[9];
$hour_number=$rs[10];
$fixed_hour=$rs[11];
$notify_hour_advance=$rs[12];
$season_start_date=$rs[13];
$season_end_date=$rs[14];
$terminate_task_date=$rs[15];
$terminate_task_hour=$rs[16];

//echo("$pm_service_id");
//echo("$pm_service_name");
//echo("$terminate_task_hour");
//echo("$day_period");
//mysql_close();

if($record_selected)
{
header("Location: DeletePMService.php?pm_service_id=$pm_service_id&schedule_id=$schedule_id&pm_service_name=$pm_service_name&item_pm_type=$item_pm_type&pm_service_enabled=$pm_service_enabled&pm_service_priority=$pm_service_priority&number_of_day=$number_of_day&day_period=$day_period&fixed_date=$fixed_date&notify_day_advance=$notify_day_advance&hour_number=&hour_number&fixed_hour=$fixed_hour&notify_hour_advance=$notify_hour_advance&season_start_date=$season_start_date&season_end_date=$season_end_date&terminate_task_date=$terminate_task_date&terminate_task_hour=$terminate_task_hour");
}



?>

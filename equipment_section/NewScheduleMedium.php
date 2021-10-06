<?php
include("common.php");
CreateConnection();

//---------------------------------Generating ID Number for SCHEDULE---------------------------------------------------------//

$query = "SELECT MAX(schedule_id) FROM new_schedule_type";
$db_result = mysqli_query($db, $query);
$datapoint = mysql_result($db_result, 0, 0);

if($datapoint==0)
{
$schedule_id=100;
//echo("$vendor_id");
}
else
{
$schedule_id=$datapoint+1;
//echo("$vendor_id");
}


//-------------------------------------Assigning Posted Value from "NewScheduleTypeSetup.php"-------------------------------//

$s_schedule=$_POST['txtschedule'];
$s_date=$_POST['sdate'];
$s_meter=$_POST['smeter'];


//------------------------------------END---------------------------------------------------------

//---------------------------------------Inserting Record into new_schedule_type Table............. 
$ins_record="INSERT INTO new_schedule_type(schedule_id,schedule_name,schedule_by_date,schedule_by_unit) VALUES ('$schedule_id','$s_schedule','$s_date','$s_meter')";

$record_inserted=mysqli_query($db, $ins_record);

mysql_close();
if($ins_record)
{

	header("Location: PMScheduleSetup.php?schedule_id=$schedule_id");

}
?>




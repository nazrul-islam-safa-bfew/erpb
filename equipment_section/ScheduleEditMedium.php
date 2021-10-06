<?php
include("common.php");
CreateConnection();

//-------------------------------------Assigning Posted Value from "NewScheduleTypeEdit.php"-------------------------------//
//assign the schedule id which is edited..
$sid=$_POST['hidField'];
//echo("$sid");
//echo("$schID");
$s_schedule=$_POST['txtschedule'];
$s_date=$_POST['sdate'];
$s_meter=$_POST['smeter'];


/*echo("$s_schedule");
echo("$s_date");
echo("$sch_id");
echo("$s_meter");
*/
//------------------------------------END---------------------------------------------------------------------------------//

//-------------------------------------------updating Values-------------------------------------------------------------//
//startting transaction
mysqli_query($db, "BEGin;"); 
$ins_record="UPDATE new_schedule_type SET schedule_name='$s_schedule',schedule_by_date='$s_date',schedule_by_unit='$s_meter' WHERE schedule_id='$sid'";
$record_inserted=mysqli_query($db, $ins_record);
mysqli_query($db, "COMMIT;"); 
if($ins_record)
{
//echo("Record has been successfully added to the database.");
	header("Location: PMScheduleSetup.php?schedule_id=$sid");

}
?>




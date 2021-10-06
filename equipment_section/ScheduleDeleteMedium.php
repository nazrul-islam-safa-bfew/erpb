<?php
include("common.php");
CreateConnection();

//-------------------------------------Assigning Posted Value from "NewScheduleType Delete.php"-------------------------------// 
$sid=$_POST['hidField'];
//echo("$sid");
//-------------------------------------------Deleting Records-------------------------------------------------------------//
//starting transaction
mysqli_query($db, "BEGin;"); 
//delete record from new_schedule_type(which contain schedule related info) table based on selected schedule.. 
$ins_record="DELETE FROM new_schedule_type WHERE schedule_id='$sid'";
$record_inserted=mysqli_query($db, $ins_record);

//delete record from add_pm_service(which contain service related info of a particular schedule) table based on selected schedule.. 
$ins_record1="DELETE FROM add_pm_service WHERE schedule_id='$sid'";
$record_inserted1=mysqli_query($db, $ins_record1);
mysqli_query($db, "COMMIT;"); 

header("Location: PMScheduleSetup.php");

?>




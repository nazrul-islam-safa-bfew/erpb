<?php
include("common.php");
CreateConnection();
$pm_id=$_GET['pm_id'];
$scheduleID=$_GET['scheduleid'];
$qry="DELETE FROM add_pm_service WHERE pm_service_id='$pm_id'";
$qryexecute=mysqli_query($db, $qry);
mysql_close();
if($qryexecute)
{
header("Location: PMScheduleSetup.php?schedule_id=$scheduleID");
}

?>
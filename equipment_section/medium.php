<?php  
$hidden=$_POST['hidField'];
$scheduleID=$_POST['schName'];
$sid=$_POST['hidSchedule'];
//$hiddenSchedule=$_POST['hidSchedule'];
//echo("$hiddenSchedule");
//---------------------Retriving Schedule ID----------------------

/*session_start();
$_SESSION['sid']=$scheduleID;
*/
//----------------------------END---------------------------------
$sch_id=$_SESSION['sid'];
//echo("$sch_id");
//echo("$scheduleID");
if($hidden==1)
{
header("Location: NewScheduleTypeSetup.php");
}
else if($hidden==2)
{
header("Location: ScheduleTypeEdit.php?scheduleid=$scheduleID");
}
else if($hidden==3)
{
header("Location: ScheduleTypeDelete.php?scheduleid=$scheduleID");
}
else if($hidden==4)
{
header("Location: AddPMService.php?scheduleid=$scheduleID");
}
else if($hidden==5)
{

header("Location: PMScheduleSetup.php?schedule_id=$sid");
}

else if($hidden==6)
{
header("Location: EditPMService.php?scheduleid=$scheduleID");
}
else if($hidden==7)
{
header("Location: DeletePMService.php?scheduleid=$scheduleID");
}

?>
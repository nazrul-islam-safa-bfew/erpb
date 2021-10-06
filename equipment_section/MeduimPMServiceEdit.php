<?php
include("common.php");
CreateConnection();
//---------------------------------------------Starting Session to get Schedule ID----------------------------
session_start();
$scheduleid=$_SESSION['sid'];
  
$hidden=$_POST['hidField'];
$pm_id=$_POST['txtpmid'];
$scheduleID=$_POST['schID'];
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


//------------------------------------END---------------------------------------------------------

if($hidden==1)
{
header("Location: EditPMServiceMedium.php?pm_id=$pm_id&scheduleid=$scheduleID");
}
else if($hidden==2)
{

header("Location: EditPMServiceUpdateMedium.php?pm_id=$pm_id&scheduleid=$scheduleID&s_name=$s_name&s_pm_type=$s_pm_type&enable=$enable&priority=$priority&day=$day&cmbperiod=$cmbperiod&cmbfixeddate=$cmbfixeddate&txtnotifyday=$txtnotifyday&txteveryhour=$txteveryhour&txtfixedhour=$txtfixedhour&txtnotifyhour=$txtnotifyhour&cmbstart_date=$cmbstart_date&cmbend_date=$cmbend_date&cmbdate=$cmbdate&cmbhour=$cmbhour");
}
if($hidden==3)
{
header("Location: PMScheduleSetup.php?schedule_id=$scheduleid");
}
?>
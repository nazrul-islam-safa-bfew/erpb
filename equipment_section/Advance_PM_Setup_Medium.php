<?php
include("common.php");
CreateConnection();
//receiving hidField value to check which event is occured...
$hid=$_POST['hidField'];
//add parts...
if($hid==2)
{
header("Location: Advance_PM_Setup_part_used.php");
}
//save the total record for an equipment's ADVANCED pm SETUP..(ICLUDES..EQUIPMENT'S ASSOCIATED PM SERVICE,PMSCHEDULE)
else if($hid==4)
{
//ASSIGNINF POSTED VALUE FROM Advance_PM_Setup.php PAGE...
$cost=$_POST['txtcost'];
//retreiving session values..
session_start();
$part_association_id=$_SESSION['p_association_id'];
$equip_id=$_SESSION['equipment_id'];
$pm_s_id=$_SESSION['pm_service_id'];

//query to SAVE RECORD...
$qry3="INSERT INTO part_association_main(part_association_id,item_id,pm_service_id,total_cost) VALUES ('$part_association_id','$equip_id','$pm_s_id','$cost')";
$qryexecute3=mysqli_query($db, $qry3);

//check whether the query is successful or not..
if($qryexecute3)
{
//accessing javascript from php to close the window....
echo '<script type="text/javascript">
window.close();
</script>';
}
else
{
echo"Couldn't Connect To The Database.";
}

}
//used to retreive equipments under the selected pm service... 
else if($hid==5)
{
$pm_s_id=$_POST['hid_pmService_id'];
//creating session to hold pm_service_id selected at the Advance_PM_Setup.php page..
session_start();
$_SESSION['pm_service_id']=$pm_s_id;
header("Location: Advance_PM_Setup.php");
}
?>

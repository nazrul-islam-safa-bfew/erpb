<?php 
include("common.php");
CreateConnection();
//holds itm_track_id value
$itm_id=$_POST['hid_item_id'];
$hidden=$_POST['hidField'];
//session_start();
//$_SESSION['item_code']=$itm_id;
//echo"$itm_id";
//echo"$hidden";
$qry="SELECT year,item_make,item_model,item_identification,item_serial_no,item_type,pm_service_id,item_meter_type,item_curr_kilometer,item_base_kilometer,item_base_date,item_status,item_assigned_to,item_photo,lbl_current_meter,lbl_base_meter FROM add_equipment_maintenance WHERE itm_track_id='$itm_id'";

if($hidden==1)
{
//creating session to hold itm_track_id(for tracking individual items) which needs to be edited....
session_start();
$_SESSION['item_code']=$itm_id;
$qryexecute=mysqli_query($db, $qry);
while($rs=mysql_fetch_row($qryexecute))
{
$year=$rs[0];
$item_make=$rs[1];
$item_model=$rs[2];
$item_identification=$rs[3];
$item_serial_no=$rs[4];
$item_type=$rs[5];
$pm_service_id=$rs[6];
$item_meter_type=$rs[7];
$item_curr_kilometer=$rs[8];
$item_base_kilometer=$rs[9];
$item_base_date=$rs[10];
$item_status=$rs[11];
$item_assigned_to=$rs[12];
$item_photo=$rs[13];
$lbl_current_meter=$rs[14];
$lbl_base_meter=$rs[15];
}
header("Location:EditNewEquipment.php?item_desc=$year&item_make=$item_make&item_model=$item_model&item_identification=$item_identification&item_serial_no=$item_serial_no&item_type=$item_type&pm_service_id=$pm_service_id&item_meter_type=$item_meter_type&item_curr_kilometer=$item_curr_kilometer&item_base_kilometer=$item_base_kilometer&item_base_date=$item_base_date&item_status=$item_status&item_assigned_to=$item_assigned_to&item_photo=$item_photo&lbl_current_meter=$lbl_current_meter&lbl_base_meter=$lbl_base_meter");
}
else if($hidden==2)
{
session_start();
$item_id=$_SESSION['item_code'];
$item_desc=$_POST['txtspecification'];
$item_make=$_POST['selectMake'];
$item_model=$_POST['selectModel'];
$item_identification=$_POST['txtidentification'];
$item_serial_no=$_POST['txtserial'];
$item_type=$_POST['selectType'];
$item_maintenance_schedule_id=$_POST['selectMaintenance'];
$item_meter_type=$_POST['selectMeter'];
$item_curr_kilometer=$_POST['txtcurrent'];
$item_base_kilometer=$_POST['txtbase'];
$item_base_date=$_POST['basedate'];
$item_status=$_POST['selectStatus'];
$item_assigned_to=$_POST['selectAssignedTo'];
$item_photo=$_POST['txtphoto'];
$lbl_current=$_POST['lbl_current'];
$lbl_base=$_POST['lbl_base'];

//-----------------------------Query,updating date to the add_equipment_maintenance + track_equipments table----------

mysqli_query($db, "BEGin;"); 

//UPDATE add_equipment_maintenance TABLE

$qryUpdate="UPDATE add_equipment_maintenance Set year='$item_desc',item_make='$item_make',item_model='$item_model',item_identification='$item_identification',item_serial_no='$item_serial_no',item_type='$item_type',pm_service_id='$item_maintenance_schedule_id',item_meter_type='$item_meter_type',item_curr_kilometer='$item_curr_kilometer',item_base_kilometer='$item_base_kilometer',item_base_date='$item_base_date',item_status='$item_status',item_assigned_to='$item_assigned_to',item_photo='$item_photo',lbl_current_meter='$lbl_current',lbl_base_meter='$lbl_base' WHERE itm_track_id='$item_id'";
$qryExecute=mysqli_query($db, $qryUpdate);

//UPDATE track_equipments TABLE
$qry_track="UPDATE track_equipments SET pm_service_id='$item_maintenance_schedule_id',item_meter_type='$item_meter_type',item_curr_kilometer='$item_curr_kilometer',item_base_kilometer='$item_base_kilometer',item_base_date='$item_base_date' WHERE itm_track_id='$item_id'";
$qryexecute_track=mysqli_query($db, $qry_track);

mysqli_query($db, "COMMIT;"); 

header("Location: EditNewEquipmentPurchase.php");
}
else if($hidden==3)
{
header("Location: index.php");
}
?>
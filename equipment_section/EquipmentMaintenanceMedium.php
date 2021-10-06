<?php 
include("common.php");
CreateConnection();
//---------------------------------Assigning posted value fro New Equipment Entry form to the variable-------------------- -----------------------------
$hidden=$_POST['hidField'];
$txtitemid=$_POST['item_id'];
$txtdesc=$_POST['txtspecification'];
$selectMake=$_POST['selectMake'];
$selectModel=$_POST['selectModel'];
$txtidentification=$_POST['txtidentification'];
$txtserial=$_POST['txtserial'];
$selectType=$_POST['selectType'];
$selectMaintenance=$_POST['selectMaintenance'];
$selectMeter=$_POST['selectMeter'];
$txtcurrent=$_POST['txtcurrent'];
$txtbase=$_POST['txtbase'];
$basedate=$_POST['basedate'];
$selectStatus=$_POST['selectStatus'];
$selectAssignedTo=$_POST['selectAssignedTo'];
$txtphoto=$_POST['txtphoto'];

$entry_date=date("Y-m-d");
//echo("$entry_date");
//echo("$selectType");
/*echo("$txtitemid<br>");
echo("$selectMake<br>");
echo("$selectMaintenance<br>");
echo("$txtidentification<br>");
echo("$txtserial<br>");
echo("$selectMeter<br>");
echo("$txtbase<br>");
echo("$selectModel<br>");
echo("$selectModel<br>");
echo("$selectModel<br>");
echo("$selectModel<br>");
echo("$selectModel<br>");
*/
//echo("$txtidentification<br>");
//-----------------------------Query,Inserting date to the add_equipment_maintenance table----------

$qry="INSERT INTO add_equipment_maintenance(item_id,item_desc,item_make,item_model,item_identification,item_serial_no,item_type,item_maintenance_schedule_id,item_meter_type,item_curr_kilometer,item_base_kilometer,item_base_date,item_status,item_assigned_to,item_photo,created_date) VALUES ('$txtitemid','$txtdesc','$selectMake','$selectModel','$txtidentification','$txtserial','$selectType','$selectMaintenance','$selectMeter','$txtcurrent','$txtbase','$basedate','$selectStatus','$selectAssignedTo','$txtphoto','$entry_date')";


if($hidden==1)
{
$qryexecute=mysqli_query($db, $qry);
mysql_close();
if($qryexecute)
{
session_start();
$_SESSION['itm_id']=$txtitemid;
header("Location: NewEquipmentPurchase.php");
}
else
{
header("Location: AddNewEquipment.php");
}
}


else if($hidden==2)
{
header("Location: index.php");
}


?>
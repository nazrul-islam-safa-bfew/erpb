<?php
include("common.php");

//-Assigning value to the variable to see which function is call from which page--------

$chk_func=intval($_GET['chk_id']);

if($chk_func==1)
{
// .........................Get PM Service ID..............................

$pmtaskID=intval($_GET['pmTask']);

// .....................setting up the session for PM Service............

session_start();
$_SESSION['pm_service_id']=$pmtaskID;

//..........................END..............................................
}
else if($chk_func==2)
{
// .........................Get Equipment tracking ID from NewWorkWorder.php page .......................

//$itm_id=intval($_GET['equipment_id']);
$itm_trk_id=$_GET['equipment_id'];
// .....................setting up the session to hold the equipment's track_id for further tracking............

session_start();
$_SESSION['equip_id']=$itm_trk_id;

//..........................END..............................................
}
else if($chk_func==3)
{
// .........................Get Repair Type from NewWorkWorder_Repair_Entry.php page .......................

$repair_type=$_GET['repair'];
// .....................setting up the session for PM Service............

session_start();
$_SESSION['repair']=$repair_type;

//..........................END..............................................
}
?>

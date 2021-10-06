<?php
include("common.php");

//-Assigning value to the variable to see which combo is selected at the Advance_PM_Setup.php page--------

$equip_id=$_GET['equipment_id'];

//creating session to hold equipment id...
session_start();
$_SESSION['equipment_id']=$equip_id;
?>

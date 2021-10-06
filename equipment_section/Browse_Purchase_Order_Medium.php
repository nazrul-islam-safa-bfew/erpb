<?php
include("common.php");
CreateConnection();
//assigning hidStatus value to the variable which has the status value..
$status_value=$_POST['hidStatus'];
//assigning PO number to variable 
$hidPO=$_POST['hidPO'];
//this varible will be used to determine which event occur at the Browse_Purchase_order.php page....
$hid_check=$_POST['hidChk'];

//this code will be executed when an status is selected.
if($hid_check==1)
{
header("Location: Browse_Purchase_Order.php?status=$status_value");
}
//--EDIT a REcord
else if($hid_check==2)
{
//creating session for the PO number..
session_start();
$_SESSION['PO']=$hidPO;
//echo"$hidPO";
//------end---//

header("Location: purchaseOrderEdit.php");
}
?>
<?php 
include("common.php");
CreateConnection();
$hidden=$_POST['hidField'];
session_start();
$item_id=$_SESSION['item_code'];
//echo("$item_id");
//echo("$hidden");

//--------------------------------assigning Posted value to the variables-----------------------------

$txtdealer=$_POST['txtdealer'];
$txtPurchaseDate=$_POST['txtPurchaseDate'];
$txtPurchaseKilometer=$_POST['txtPurchaseKilometer'];
$txtprice=$_POST['txtprice'];
$txtPurchaseComment=$_POST['txtPurchaseComment'];
$inServiceDate=$_POST['inServiceDate'];
$outServiceDate=$_POST['outServiceDate'];
$transferDate=$_POST['transferDate'];
$soldDate=$_POST['soldDate'];
$txtSoldTo=$_POST['txtSoldTo'];
$txtStatusComment=$_POST['txtStatusComment'];
//-------------------------------------------------END--------------------------------------------

//-----------------------------------Query to update add_equipment_maintenance table--------

$qry="UPDATE add_equipment_maintenance SET item_purchase_dealer='$txtdealer',item_purchase_date='$txtPurchaseDate', item_purchase_kilometer='$txtPurchaseKilometer',item_purchase_price='$txtprice',item_purchase_comment='$txtPurchaseComment',item_purchase_in_service_date='$inServiceDate',item_purchase_out_service_date='$outServiceDate',item_purchase_transfer_date='$transferDate',item_purchase_sold_date='$soldDate',item_purchase_sold_to='$txtSoldTo',item_purchase_status_comment='$txtStatusComment' WHERE itm_track_id='$item_id'";

//-------------------------------------END--------------------------------------


//-------------------------Tracking Buttons Click Event-------------------------------
if($hidden==1)
{
$qryexecute=mysqli_query($db, $qry);
mysql_close();
if($qryexecute)
{
header("Location: EditNewEquipmentLoan.php");
}
}
else if($hidden==2)
{
header("Location: EditNewEquipmentLoan.php");
}

?>
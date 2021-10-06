<?php 
include("common.php");
CreateConnection();
$hidden=$_POST['hidField'];
session_start();
$item_id=$_SESSION['itm_id'];
//echo("$item_id");
//echo("$hidden");

//--------------------------------assigning Posted value to the variables-----------------------------

$txtInsuranceCompany=$_POST['txtInsuranceCompany'];
$txtInsurancePolicy=$_POST['txtInsurancePolicy'];
$txtInsuranceStartDate=$_POST['txtInsuranceStartDate'];
$txtInsuranceEndDate=$_POST['txtInsuranceEndDate'];
$txtInsurancePayment=$_POST['txtInsurancePayment'];
$txtInsuranceDeductible=$_POST['txtInsuranceDeductible'];
$txtInsuranceNote=$_POST['txtInsuranceNote'];
//-------------------------------------------------END--------------------------------------------

//-----------------------------------Query to update add_equipment_maintenance table--------

$qry="UPDATE add_equipment_maintenance SET item_insurance_company='$txtInsuranceCompany',item_insurance_policy='$txtInsurancePolicy', item_insurance_start_date='$txtInsuranceStartDate',item_insurance_end_date='$txtInsuranceEndDate',item_insurance_payment='$txtInsurancePayment',item_insurance_deductible='$txtInsuranceDeductible',item_insurance_notes='$txtInsuranceNote' WHERE itm_track_id='$item_id'";

//-------------------------------------END--------------------------------------


//-------------------------Tracking Buttons Click Event-------------------------------
if($hidden==1)
{
$qryexecute=mysqli_query($db, $qry);
mysql_close();
header("Location: index.php");
}
else if($hidden==2)
{
header("Location: index.php");
}

?>
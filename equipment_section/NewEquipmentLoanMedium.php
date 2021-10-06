<?php 
include("common.php");
CreateConnection();
$hidden=$_POST['hidField'];
session_start();
$item_id=$_SESSION['item_code'];
//echo("$item_id");
//echo("$hidden");

//--------------------------------assigning Posted value to the variables-----------------------------

$txtLoanCompany=$_POST['txtLoanCompany'];
$txtLoanAccount=$_POST['txtLoanAccount'];
$LoanstartDate=$_POST['LoanstartDate'];
$loanEndDate=$_POST['loanEndDate'];
$txtLoanPayment=$_POST['txtLoanPayment'];
$txtLoanBal=$_POST['txtLoanBal'];
$txtLoanNote=$_POST['txtLoanNote'];
//-------------------------------------------------END--------------------------------------------

//-----------------------------------Query to update add_equipment_maintenance table--------

$qry="UPDATE add_equipment_maintenance SET item_loan_company='$txtLoanCompany',item_loan_account='$txtLoanAccount', item_loan_start_date='$LoanstartDate',item_loan_end_date='$loanEndDate',item_loan_payment='$txtLoanPayment',item_loan_balance='$txtLoanBal',item_loan_notes='$txtLoanNote' WHERE itm_track_id='$item_id'";

//-------------------------------------END--------------------------------------


//-------------------------Tracking Buttons Click Event-------------------------------
//for SAVE BUTTON 
if($hidden==1)
{
$qryexecute=mysqli_query($db, $qry);
mysql_close();
header("Location: NewEquipmentInsurance.php");
}
//FOR EXIT BUTTON
else if($hidden==2)
{
header("Location: NewEquipmentInsurance.php");
}

?>
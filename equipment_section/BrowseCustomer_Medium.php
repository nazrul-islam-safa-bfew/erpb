<?php  
include("common.php");
CreateConnection();
//assigning posted hidden value to the variable...

//holds value which is needed to check which button is prassed at the BrowseCustomer.php page...
$hid=$_POST['hidField'];
//will be execited based on  which button is prassed at the BrowseCustomer.php page...

if($hid==1)
{
//EDIT Button

//holds id of the customer which needs to be edited
$cust_id=$_POST['hid_cust_id'];
//CREATING SESSION TO HOLD ID OF THE CUSTOMER.....
session_start();
$_SESSION['CUSTOMER_ID']=$cust_id;
//------------------------END---------------------

header("Location: Edit_NewCustomer.php");
}

?>

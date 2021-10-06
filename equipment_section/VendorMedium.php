<?php
include("common.php");
CreateConnection();
//--------------------------------------Generating Vendor Code---------------------------------------//
$vendor_Entry_Date=date("Y-m-d");

$strSQL = "select ifnull(count(vendor_id),0)+1 as Cvendor_id from vendor_setup where entry_date ='$vendor_Entry_Date'";

$rs = mysqli_query($db, $strSQL);
$vendor_id=ThiryTwoBaseNumber(date("d")).ThiryTwoBaseNumber(date("m")).ThiryTwoBaseNumber(date("y")).ThiryTwoBaseNumber(mysql_result($rs,0,'Cvendor_id'));





//-----------------------------------END-----------------------------------------------------------//


//--------------------Assigning Posted value of "VendorSetup.php" to the variable---------------------//

$vendor_name=$_POST['txtname'];
$vendor_contact=$_POST['txtcontact'];
$vendor_address=$_POST['txtaddress'];
$vendor_city=$_POST['txtcity'];
$vendor_state=$_POST['txtstate'];
$vendor_postal=$_POST['txtpostal'];
$vendor_country=$_POST['txtcountry'];
$vendor_phone=$_POST['txtphone'];
$vendor_mobile=$_POST['txtmobile'];
$vendor_fax=$_POST['txtfax'];
$vendor_mail=$_POST['txtemail'];
$vendor_comment=$_POST['txtcomment'];

//--------------------END------------------------------------------------------------------------------//





//----------------------------Inserting Recod & Validating Wheather The Query is Successful----------------------------------//


$item_insert="INSERT INTO vendor_setup (vendor_id,vendor_name,vendor_contact,vendor_address,vendor_city,vendor_state,vendor_postal_code, vendor_country,vendor_phone,vendor_mobile,vendor_fax,vendor_email,vendor_comment,entry_date) VALUES ('$vendor_id','$vendor_name', '$vendor_contact', '$vendor_address', '$vendor_city', '$vendor_state', '$vendor_postal', '$vendor_country', '$vendor_phone', '$vendor_mobile', '$vendor_fax', '$vendor_mail', '$vendor_comment','$vendor_Entry_Date')";

$execute=mysqli_query($db, $item_insert);


	if ($execute)
	{
 /*		header("location: VendorSetupSuccessful.php?vendor_id=".$vendor_id."&vendor_name=".$vendor_name."&vendor_contact=".$vendor_contact."&vendor_address=".$vendor_address."&vendor_city=".$vendor_city."&vendor_state=".$vendor_state."&vendor_postal=".$vendor_postal."&vendor_country=".$vendor_country."&vendor_phone=".$vendor_phone."&vendor_mobile=".$vendor_mobile."&vendor_fax=".vendor_fax."&vendor_mail=".$vendor_mail."&vendor_comment=".$vendor_comment."&vendor_comment=".$vendor_comment."&vendor_Entry_Date=".$vendor_Entry_Date);
	
*/

header("Location:  BrowseVendor.php?count=1");
	
	
	}
	
//--------------------------------------END------------------------------------------------//


?>










<?php 
include("Common.php");
CreateConnection();
//----------------Retreiving employee id from session AND ASSIGNING TO THE VARIABLE----------------------//
session_start();
$emp_id=$_SESSION['employee_id'];


//---Assigning Posted value from AddNewEmployeeContact.php to the variable---//
$emp_address1=$_POST['txtContactAddress1'];
$emp_address2=$_POST['txtContactAddress2'];
$emp_city=$_POST['txtContactCity'];
$emp_state=$_POST['txtContactState'];
$emp_postal_code=$_POST['txtContactPostal'];
$emp_home_phone=$_POST['txtContactHomePhone'];
$emp_mobile=$_POST['txtContactMobile'];
$emp_pager=$_POST['txtContactPager'];
$emp_email=$_POST['txtContactEmail'];
$emp_contact_notes=$_POST['txtContactNotes'];

//---Query to Update record in add_new_employee table record in the ----//

$qry="UPDATE add_new_employee SET emp_contact_address1='$emp_address1',emp_contact_address2='$emp_address2',emp_contact_city='$emp_address1',emp_contact_district='$emp_city',emp_contact_postal_code='$emp_postal_code',emp_contact_home_phone='$emp_home_phone',emp_contact_mobile='$emp_mobile',emp_contact_pager='$emp_pager',emp_contact_email='$emp_email',emp_contact_notes='$emp_contact_notes' WHERE emp_id='$emp_id'";
$qryexecute=mysqli_query($db, $qry);

if($qryexecute)
{
header("Location: EmployeeManagment.php");
}
else
{
echo"Could Not Connect to The Database...<p><a href=AddNewEmployeeContact.php>Back</a>";
}


?>

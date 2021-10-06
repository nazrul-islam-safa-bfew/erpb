<?php													
include("common.php");
CreateConnection();
//Assigning Posted  hidden value to the variable//
$hid=$_POST['hidField'];

//----Checking hid value....//.
//---Add a new employee category........
if($hid==1)
{
header("Location: AddNewEmployee_Email.php");
}
//-------------Edit/Delete an Employee e-mail Information......................//
else if($hid==2)
{
$employee_mail_id=$_POST['hidEmail_id'];
//Creating session to hold email ID 
session_start();
$_SESSION['email_id']=$employee_mail_id;
/*
$qry="SELECT emp_mail_address FROM add_new_employee_email_address WHERE emp_mail_id='$employee_mail_id'";
$qryexecute=mysqli_query($db, $qry);
$rs=mysql_result($qryexecute,0,0);
//echo($rs); */
header("Location: AddNewEmployee_Email_Edit_Delete.php");
}

?>
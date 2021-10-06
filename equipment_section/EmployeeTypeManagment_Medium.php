<?php													
include("common.php");
CreateConnection();
//Assigning Posted  hidden value to the variable//
$hid=$_POST['hidField'];

//----Checking hid value....//.
//---Add a new employee category........
if($hid==1)
{
header("Location: AddNewEmployee_type.php");
}
//-------------Edit/Delete an Employee Type Information......................//
else if($hid==2)
{
$employee_type_id=$_POST['hidTypeid'];
//Creating session to hold ID of the Type
session_start();
$_SESSION['emp_type_id']=$employee_type_id;

$qry="SELECT emp_type_name FROM add_new_employee_type WHERE emp_type_id='$employee_type_id'";
$qryexecute=mysqli_query($db, $qry);
$rs=mysql_result($qryexecute,0,0);
//echo($rs);
header("Location: AddNewEmployee_type_Edit_Delete.php?emp_type=$rs");
}

?>
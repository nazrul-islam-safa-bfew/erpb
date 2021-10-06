<?php													
include("common.php");
CreateConnection();
//Assigning Posted  hidden value to the variable//
$hid=$_POST['hidField'];

//----Checking hid value....//.
//---Add a new employee category........
if($hid==1)
{
header("Location: AddNewEmployee_Category_type.php");
}
//-------------Edit/Delete an Employee Category Information......................//
else if($hid==2)
{
$employee_category_id=$_POST['hidCategoryID'];
//Creating session to hold ID of the category
session_start();
$_SESSION['category_id']=$employee_category_id;

$qry="SELECT emp_category_type FROM add_new_employee_category WHERE emp_category_id='$employee_category_id'";
$qryexecute=mysqli_query($db, $qry);
$rs=mysql_result($qryexecute,0,0);
//echo($rs);
header("Location: AddNewEmployee_Category_type_Edit_Delete.php?catagory_type=$rs");
}

?>
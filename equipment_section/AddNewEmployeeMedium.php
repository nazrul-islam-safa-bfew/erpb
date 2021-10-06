<?php 
include("Common.php");
CreateConnection();
//---Assigning Posted value from AddNewEmployee.php to the variable---//
$create_date=date("y-m-d");
$emp_name=$_POST['txt_emp_name'];
$emp_status=$_POST['select_emp_status'];
$emp_location=$_POST['selectLocation'];
$emp_category=$_POST['selectCategory'];
$emp_type=$_POST['selectType'];
$emp_labor_rate=$_POST['txt_labor_rate'];
$emp_ssn=$_POST['txt_emp_ssn'];
$emp_hire_date=$_POST['txt_hire_date'];
$emp_last_date=$_POST['txt_last_date'];
$emp_dob=$_POST['txt_dob'];
$emp_leave_date=$_POST['txt_leave_date'];
$emp_physical_due_date=$_POST['txt_due_date'];
$emp_driving_license_number=$_POST['txt_license_number'];
$emp_license_class=$_POST['txt_license_class'];
$emp_license_city=$_POST['txt_license_city'];
$emp_license_espire_date=$_POST['txt_license_espire_date'];
$emp_license_note=$_POST['txt_license_note'];
/*echo"$emp_name<br>";
echo"$emp_status<br>";
echo"$emp_location<br>";
echo"$emp_category<br>";
echo"$emp_type<br>";
echo"$emp_labor_rate<br>";
echo"$emp_ssn<br>";
echo"$emp_hire_date<br>";
echo"$emp_last_date<br>";
echo"$emp_dob<br>";
echo"$emp_leave_date<br>";
echo"$emp_physical_due_date<br>";
echo"$emp_driving_license_number<br>";
echo"$emp_license_class<br>";
echo"$emp_license_city<br>";
echo"$emp_license_espire_date<br>";
echo"$emp_license_note<br>";
*/
//----------------Retreiving employee id from session AND ASSIGNING TO THE VARIABLE----------------------//
session_start();
$emp_id=$_SESSION['employee_id'];

//---Query to insert record in the ----//
$qry="INSERT INTO add_new_employee(emp_id,emp_Name,emp_status,emp_location,emp_category,emp_type,emp_labor_rate,emp_ssn,emp_hire_date,emp_physical_date,emp_dob,emp_leave_date,emp_physical_due_date,emp_driver_license_number,emp_driver_license_class,emp_driver_license_state,emp_driver_license_expire_date,emp_driver_license_note,created_date)VALUES('$emp_id','$emp_name','$emp_status','$emp_location','$emp_category','$emp_type','$emp_labor_rate','$emp_ssn','$emp_hire_date','$emp_last_date','$emp_dob','$emp_leave_date','$emp_physical_due_date','$emp_driving_license_number','$emp_license_class','$emp_license_city','$emp_license_espire_date','$emp_license_note','$create_date')";

$qryexecute=mysqli_query($db, $qry);

if($qryexecute)
{
header("Location: AddNewEmployeeContact.php");
}
else
{
echo"Could Not Connect to The Database...<p><a href=AddNewEmployee.php>Back</a>";
}


?>

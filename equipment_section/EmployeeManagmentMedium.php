<?php 
include("common.php");
CreateConnection();
//assigning posted hidden value to execute a bock of code depend upon the Button clicked at the EmployeeManagment.php page
$hid=$_POST['hidField'];
//echo("$hid");

//----------------------For Add Button.....................
if($hid==1)
{
header("Location: AddNewEmployee.php");
}
//----For Editing the record--Add//
else if($hid==2)
{
//--assigning posted hidden value(contains emp_id) to the variable--Edit//
$emp_id=$_POST['hid_emp_id'];
//Generating session to hold the value of the employee that needs to be edited......//
session_start();
$_SESSION['$edit_emp_id']=$emp_id;
//echo("$emp_id"); 

//------------Fetching record from the add_new_employee table based on the $emp_id value----//
$qry="SELECT emp_Name,emp_status,emp_location,emp_category,emp_type,emp_labor_rate,emp_ssn,emp_hire_date,emp_physical_date,emp_dob,emp_leave_date,emp_physical_due_date,emp_driver_license_number,emp_driver_license_class,emp_driver_license_state,emp_driver_license_expire_date,emp_driver_license_note FROM add_new_employee WHERE emp_id='$emp_id'"; 
$qryexecute=mysqli_query($db, $qry);
if($qryexecute)
{
$rs=mysql_fetch_row($qryexecute);
$emp_Name=$rs[0];
$emp_status=$rs[1];
$emp_location=$rs[2];
$emp_category=$rs[3];
$emp_type=$rs[4];
$emp_labor_rate=$rs[5];
$emp_ssn=$rs[6];
$emp_hire_date=$rs[7];
$emp_physical_date=$rs[8];
$emp_dob=$rs[9];
$emp_leave_date=$rs[10];
$emp_physical_due_date=$rs[11];
$emp_driver_license_number=$rs[12];
$emp_driver_license_class=$rs[13];
$emp_driver_license_state=$rs[14];
$emp_driver_license_expire_date=$rs[15];
$emp_driver_license_note=$rs[16];

header("Location: EditNewEmployee.php?emp_name=$emp_Name&emp_status=$emp_status&emp_location=$emp_location&emp_category=$emp_category&emp_type=$emp_type&emp_labor_rate=$emp_labor_rate&emp_ssn=$emp_ssn&emp_hire_date=$emp_hire_date&emp_physical_date=$emp_physical_date&emp_dob=$emp_dob&emp_leave_date=$emp_leave_date&emp_physical_due_date=$emp_physical_due_date&emp_driver_license_number=$emp_driver_license_number&emp_driver_license_class=$emp_driver_license_class&emp_driver_license_state=$emp_driver_license_state&emp_driver_license_expire_date=$emp_driver_license_expire_date&emp_driver_license_note=$emp_driver_license_note");
}
else
{
echo"Could Not Connect to The Database...<p><a href=EmployeeManagment.php>Back</a>";
}

}//END OF THE IF LOOP
?>
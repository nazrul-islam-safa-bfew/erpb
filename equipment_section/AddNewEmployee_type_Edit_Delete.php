<?php													
include("common.php");
CreateConnection();
//Assigning Posted value to the variable ....//
$hid=$_POST['hidField'];
$employee_type=$_POST['txtEmpType'];
//---Update record in add_new_employee_type table---//
//-----For UPDATE Button...............
if($hid==1)
{
//ASSIGNING SESSION VALUE WHICH CONTAINS THE EMPLOYEE Type ID
session_start();
$employeeType_id=$_SESSION['emp_type_id'];

$qry="UPDATE add_new_employee_type SET emp_type_name='$employee_type' WHERE emp_type_id='$employeeType_id'";
$qryexecute=mysqli_query($db, $qry);
if($qryexecute)
{
header("Location: EmployeeTypeManagment.php");
}
else
{
echo("Employee Category Exist...");

}
}
//-----For DELETE Button...............
else if($hid==2)
{
//ASSIGNING SESSION VALUE WHICH CONTAINS THE EMPLOYEE Type ID
session_start();
$employeeType_id=$_SESSION['emp_type_id'];

$qry="DELETE FROM add_new_employee_type WHERE emp_type_id='$employeeType_id'";
$qryexecute=mysqli_query($db, $qry);
header("Location: EmployeeTypeManagment.php");

}

//.............Receiving posted value and assigning to the variable and update or delete record base on that----------//
$employee_type_name=$_GET['emp_type'];
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Add Employee Category</title>

<script language="javascript">

//validating Form Input
function validate(frm)
{
if(frm.txtEmpType.value=="")
{
alert("Please Enter Employee Category Type.");
frm.txtEmpType.focus();
return false;
}
else if(isNaN(frm.txtEmpType.value)==false)
{
alert("Invalid Name For The Employee Category Type.Please Enter Character Data.");
frm.txtEmpType.focus();
return false;
}

return true;
}

function doFinish(frm)
{
if(validate(frm)==true)
{
document.form1.hidField.value=1;
document.form1.submit();
}
}

//For Delete Button//
function goDelete()
{
document.form1.hidField.value=2;
document.form1.submit();
}

</script>
<style type="text/css">
<!--
@import url("common.css");
-->
</style>
<link href="common.css" rel="stylesheet" type="text/css" />
</head>
<body>
<form id="form1" name="form1" method="post" action="AddNewEmployee_type_Edit_Delete.php">
  <input name="hidField" type="hidden" id="hidField" />
  <table width="328" border="0" align="left" cellpadding="0" cellspacing="0">
  <tr>
      <td colspan="3" bgcolor="#33CC33">Update / Delete Employee Type </td>
    </tr>
    <tr bgcolor="#FF99FF">
      <td width="164">Enter Employee Type</td>
<td width="157" colspan="2"><input name="txtEmpType" type="text" id="txtEmpType" value="<?php echo"$employee_type_name";  ?>"/>    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    
    <tr bgcolor="#990000">
      <td><label>
       <center><input name="update" type="button" id="update" value="   Update   " onclick="doFinish(form1)"/>
       </center>
      </label></td>
      <td><input name="Delete" type="button" id="Delete" value="   Delete   " onclick="goDelete()"/></td>
      <td>
	  <center><input name="close" type="button" id="close" value="   Close   " onclick="javascript:window.close();"/>
	  </center>	  </td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</form>
</body>
</html>

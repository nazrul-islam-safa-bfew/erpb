<?php													
include("common.php");
CreateConnection();
//Assigning Posted value to the variable ....//
$hid=$_POST['hidField'];
$status_type=$_POST['txtStatus'];
//---Update record in add_new_employee_status table---//
//-----For UPDATE Button...............
if($hid==1)
{
//ASSIGNING SESSION VALUE WHICH CONTAINS THE EMPLOYEE status ID
session_start();
$employee_status_id=$_SESSION['status'];

$qry="UPDATE add_new_employee_status SET emp_status_type='$status_type' WHERE emp_status_id='$employee_status_id'";
$qryexecute=mysqli_query($db, $qry);
if($qryexecute)
{
header("Location: EmployeeStatusManagment.php");
}
else
{
echo("Employee Category Exist...");

}
}
//-----For DELETE Button...............
else if($hid==2)
{
//ASSIGNING SESSION VALUE WHICH CONTAINS THE EMPLOYEE CATEGORY ID
session_start();
$employee_status_id=$_SESSION['status'];

$qry="DELETE FROM add_new_employee_status WHERE emp_status_id='$employee_status_id'";
$qryexecute=mysqli_query($db, $qry);
header("Location: EmployeeStatusManagment.php");
}



//.............Receiving value send by Header and assigning to the variable and update or delete record base on that----------//
$status_type=$_GET['status_type'];

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Edit / Delete  Employee Status</title>

<script language="javascript">

//validating Form Input
function validate(frm)
{
if(frm.txtStatus.value=="")
{
alert("Please Enter Employee Status Type.");
frm.txtStatus.focus();
return false;
}
else if(isNaN(frm.txtStatus.value)==false)
{
alert("Invalid Name For The Employee Status Type.Please Enter Character Data.");
frm.txtStatus.focus();
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
body,td,th {
	font-family: Georgia, Times New Roman, Times, serif;
	font-size: 16px;
	color: #3300CC;
}
-->
</style>



</head>
<body>
<form id="form1" name="form1" method="post" action="AddNewEmployee_Status_type_Edit_Delete.php">
  <input name="hidField" type="hidden" id="hidField" />
  <table width="328" border="0" align="left" cellpadding="0" cellspacing="0">
  <tr>
      <td colspan="3" bgcolor="#33CC33">Update / Delete Employee Status </td>
    </tr>
    <tr bgcolor="#FF99FF">
      <td width="164">Enter Employee Status </td>
      <td width="157" colspan="2"><input name="txtStatus" type="text" id="txtStatus" value="<?php echo"$status_type";  ?>"/></td>
    </tr>
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

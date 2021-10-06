<?php													
include("common.php");
CreateConnection();
$emp_status=$_POST['txtStatus'];
$hid=$_POST['hidField'];
$ins_date=date("Y-m-d");
//echo("$emp_status<br>");
//echo("$hid<br>");
//echo("$ins_date<br>");


//--checking the maximum value emp_status_id in add_new_employee_status table-----
$qry1="SELECT MAX(emp_status_id) FROM add_new_employee_status";
$qryexecute1=mysqli_query($db, $qry1);
$rs=mysql_result($qryexecute1,0,0);
if($rs==0)
{
$id=1;
}
else
{
$id=$rs+1;
}

//---insert record to add_new_employee_category table---//
if($hid==1)
{
$qry="INSERT INTO add_new_employee_status(emp_status_id,emp_status_type,created_date) VALUES ('$id','$emp_status','$ins_date')";
$qryexecute=mysqli_query($db, $qry);
if($qryexecute)
{
header("Location: EmployeeStatusManagment.php");
}
else
{
echo("Employee Status Exist...");
}
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Add Employee Status</title>

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
<form id="form1" name="form1" method="post" action="AddNewEmployee_Status_type.php">
  <p>
    <input name="hidField" type="hidden" id="hidField" />
  </p>
  <p>&nbsp;</p>
  <table width="328" border="0" align="left" cellpadding="0" cellspacing="0">
  <tr>
      <td colspan="2" bgcolor="#33CC33">Add New Employee Status </td>
    </tr>
    <tr bgcolor="#FF99FF">
      <td width="164">Enter Employee Status </td>
      <td width="157"><input name="txtStatus" type="text" id="txtStatus" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#990000">
      <td>
	  <center>
	    <input name="statusAdd" type="button" id="statusAdd" accesskey="A" value="    Add    "  onclick="doFinish(form1)"/>
	  </center>	  </td>
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

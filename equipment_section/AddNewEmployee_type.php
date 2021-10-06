<?php													
include("common.php");
CreateConnection();
$emp_type=$_POST['txtEmpType'];
$hid=$_POST['hidField'];
$ins_date=date("Y-m-d");
//echo("$emp_category<br>");
//echo("$hid<br>");
//echo("$ins_date<br>");


//--checking the maxium value of emp_type_id in add_new_employee_type table-----
$qry1="SELECT MAX(emp_type_id) FROM add_new_employee_type";
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
$qry="INSERT INTO add_new_employee_type(emp_type_id,emp_type_name,created_date) VALUES ('$id','$emp_type','$ins_date')";
$qryexecute=mysqli_query($db, $qry);
if($qryexecute)
{
header("Location: EmployeeTypeManagment.php");
}
else
{
echo("Employee Type Exist...");
}
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Add Employee Type</title>

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

</script>
<style type="text/css">
<!--
@import url("common.css");
-->
</style>
</head>
<body>
<form id="form1" name="form1" method="post" action="AddNewEmployee_type.php">
  <p>
    <input name="hidField" type="hidden" id="hidField" /></p>
  <table width="328" border="0" align="left" cellpadding="0" cellspacing="0">
  <tr bgcolor="#33CC33">
      <td colspan="2" bgcolor="#33CC33">Add New Employee Type </td>
    </tr>
    <tr bgcolor="#FF99FF">
      <td width="164">Enter Employee Type </td>
      <td width="157"><input name="txtEmpType" type="text" class="tableData" id="txtEmpType" /></td>
    </tr>
    <tr>
      <td class="tableHeading">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="tableHeading">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#990000">
      <td>
	  <center><input name="typeAdd" type="button" id="typeAdd" accesskey="A" value="    Add    "  onclick="doFinish(form1)"/>
	  </center>	  </td>
      <td>
	  <center><input name="close" type="button" id="close" accesskey="C" onclick="javascript:window.close()" value="   Close  "/>
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

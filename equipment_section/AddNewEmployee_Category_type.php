<?php													
include("common.php");
CreateConnection();
$emp_category=$_POST['txtCategory'];
$hid=$_POST['hidField'];
$ins_date=date("Y-m-d");
//echo("$emp_category<br>");
//echo("$hid<br>");
//echo("$ins_date<br>");


//--checking the maximum value of emp_category_id in add_new_employee_category table-----
$qry1="SELECT MAX(emp_category_id) FROM add_new_employee_category";
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
$qry="INSERT INTO add_new_employee_category(emp_category_id,emp_category_type,created_date) VALUES ('$id','$emp_category','$ins_date')";
$qryexecute=mysqli_query($db, $qry);
if($qryexecute)
{
header("Location: EmployeeCategoryManagment.php");
}
else
{
echo("Employee Category Exist...");
}
}
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
if(frm.txtCategory.value=="")
{
alert("Please Enter Employee Category Type.");
frm.txtCategory.focus();
return false;
}
else if(isNaN(frm.txtCategory.value)==false)
{
alert("Invalid Format For The Category Name.Please Enter Character Data.");
frm.txtCategory.focus();
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
<form id="form1" name="form1" method="post" action="AddNewEmployee_Category_type.php">
  <p>
    <input name="hidField" type="hidden" id="hidField" />
  </p>
  <p>&nbsp;</p>
  <table width="338" border="0" align="left" cellpadding="0" cellspacing="0">
  <tr>
      <td colspan="2" bgcolor="#33CC33">Add New Employee Category </td>
    </tr>
    <tr bgcolor="#FF99FF">
      <td width="184" bgcolor="#FF99FF">Enter Employee Category </td>
      <td width="144"><input name="txtCategory" type="text" id="txtCategory" /></td>
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
      <td bgcolor="#990000">
	  <center><input name="categoryAdd" type="button" id="categoryAdd" accesskey="A" value="    Add    "  onclick="doFinish(form1)"/></center>	  </td>
      <td bgcolor="#990000">
	  <center>
	    <input type="button" name="Button" value="  Close  " accesskey="C" onclick="javascript:location.href='EmployeeCategoryManagment.php'"/>
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

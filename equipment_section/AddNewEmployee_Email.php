<?php													
include("common.php");
CreateConnection();
//assigin posted value
$employee_id=$_POST['emp_id'];
$emp_mail_address=$_POST['txtMail'];
$hid=$_POST['hidField'];
$ins_date=date("Y-m-d");
//echo("$emp_category<br>");
//echo("$hid<br>");
//echo("$ins_date<br>");


//---insert record to add_new_employee_category table---//
if($hid==1)
{
$qry="INSERT INTO add_new_employee_email_address(emp_id,emp_mail_address,created_date) VALUES ('$employee_id','$emp_mail_address','$ins_date')";
$qryexecute=mysqli_query($db, $qry);
if($qryexecute)
{
header("Location: EmployeeEmailManagment.php");
}
else
{
echo("Employee's E-mail id Exist...Please add different E-mail id.");}
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Add Employee E-mail address</title>

<script language="javascript">

//validation function for e-mail address format 
function validate(form)
{
var returnVal = true;
var emailaddress=form.txtMail.value;
var emailFormat = /^\w(\.?[\w-])*@\w(\.?[\w-])*\.[a-zA-Z]{2,6}(\.[a-zA-Z]{2})?$/i;
// begin email format validation

if (emailaddress.search(emailFormat) == -1)
{
alert("Please specify your email address in the following format: email@emailaddress.com");
returnVal = false;
}
return returnVal;
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

<link href="common.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {
	font-size: 16px;
	font-family: Arial, Helvetica, sans-serif;
}
-->
</style>
</head>
<body>
<form id="form1" name="form1" method="post" action="AddNewEmployee_Email.php">
  <p>
    <input name="hidField" type="hidden" id="hidField" />
  </p>
  <table width="328" border="1" align="left" cellpadding="0" cellspacing="0">
  <tr>
      <th colspan="2" bgcolor="#33CC33"><div align="left" class="style1">Add  Employee E - mail Address </div></th>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr bgcolor="#FF99FF">
      <td bgcolor="#FF99FF"><strong>Select Employee id</strong> </td>
      <td><label>
        <select name="emp_id" id="emp_id">
			<?php
				//fetch employee id from add_new_employee...
				
				$qry="SELECT emp_id FROM add_new_employee";
				$qryexecute=mysqli_query($db, $qry);
				
				while($rs=mysql_fetch_row($qryexecute))
				{
					$emp_id=$rs[0];
					echo"<option value='$emp_id'>$emp_id</option>";
				}
			 ?>
        </select>
      </label></td>
    </tr>
    <tr bgcolor="#FF99FF">
      <td width="164" bgcolor="#FF99FF"><strong>Enter E - mail Address </strong></td>
      <td width="157"><input name="txtMail" type="text" id="txtMail" /></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    
    <tr bgcolor="#0099CC">
      <td>
	  <center><input name="typeAdd" type="button" id="typeAdd" accesskey="A" value="    Add    "  onclick="doFinish(form1)"/>
	  </center>	  </td>
      <td bgcolor="#0099CC">
	  <center>
	    <input name="close" type="button" id="close" accesskey="C" onclick="javascript:window.close()" value="   Close  "/>
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

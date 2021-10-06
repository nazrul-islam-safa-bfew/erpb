<?php													
include("common.php");
CreateConnection();
//ASSIGNING SESSION VALUE WHICH CONTAINS THE EMPLOYEE Email ID which needs to be edited initiated at EmployeeEmailManagment_Medium.php page 
session_start();
$employeeEmail_id=$_SESSION['email_id'];
//echo $employeeEmail_id;

//Assigning Posted value to the variable ....//
$hid=$_POST['hidField'];
$employee_id=$_POST['emp_id'];
$employee_mail_address=$_POST['txtMail'];
//---Update record in add_new_employee_type table---//
//-----For UPDATE Button...............
if($hid==1)
{
//ASSIGNING SESSION VALUE WHICH CONTAINS THE EMPLOYEE Email ID which needs to be edited
$employeeEmail_id=$_SESSION['email_id'];

$qry="UPDATE add_new_employee_email_address SET emp_id='$employee_id',emp_mail_address='$employee_mail_address' WHERE emp_mail_address='$employeeEmail_id'";
$qryexecute=mysqli_query($db, $qry);
if($qryexecute)
{
header("Location: EmployeeEmailManagment.php");
}
else
{
echo("Employee's E-mail id Exist...Please add different E-mail id.");
}
}
//-----For DELETE Button...............
else if($hid==2)
{
$qry="DELETE FROM add_new_employee_email_address WHERE emp_mail_address='$employeeEmail_id'";
$qryexecute=mysqli_query($db, $qry);
header("Location: EmployeeEmailManagment.php");
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Edit/Delete Employee E-mail address</title>

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

//For Delete Button//
function goDelete()
{
document.form1.hidField.value=2;
document.form1.submit();
}

</script>
<style type="text/css">
<!--
.style1 {
	font-size: 16px;
	font-weight: bold;
	font-family: Arial, Helvetica, sans-serif;
}
-->
</style>
</head>
<body>
<form id="form1" name="form1" method="post" action="AddNewEmployee_Email_Edit_Delete.php">
  <input name="hidField" type="hidden" id="hidField" />
  <table width="328" border="1" align="left" cellpadding="0" cellspacing="0">
  <tr>
      <td colspan="3" bgcolor="#33CC33"><span class="style1">Edit/Delete Employee E-mail address</span></td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;    </td>
    </tr>
    <tr bgcolor="#FF99FF">
      <td><strong>Select Employee id</strong></td>
      <td colspan="2"><select name="emp_id" id="emp_id">
        <?php
		
				//*****************************FOR EDIT SECTION**************************************//
				//ASSIGNING SESSION VALUE WHICH CONTAINS THE EMPLOYEE Email ID which needs to be edited initiated at 		EmployeeEmailManagment_Medium.php page 
							session_start();
							$employeeEmail_id=$_SESSION['email_id'];

					//FETCH EMPLOYEE ID FOR SPECIFIC E-MAIL ADDRESS
				$qry_spec="SELECT emp_id FROM add_new_employee_email_address WHERE emp_mail_address='$employeeEmail_id'";
				$qryexecute_spec=mysqli_query($db, $qry_spec);
				$rs=mysql_fetch_row($qryexecute_spec);
				$emp=$rs[0];
				
				//*****************************END**************************************//
				
				//fetch employee id from add_new_employee...
				
				$qry="SELECT emp_id FROM add_new_employee";
				$qryexecute=mysqli_query($db, $qry);
				
				while($rs=mysql_fetch_row($qryexecute))
				{
					$emp_id=$rs[0];
					echo"<option value='$emp_id'"; if($emp_id==$emp) echo ' SELECTED '; echo">$emp_id</option>";
				}
			 ?>
      </select>    </tr>
    <tr bgcolor="#FF99FF">
      <td width="164"><strong>E-mail Address </strong></td>
    <td width="157" colspan="2"><input name="txtMail" type="text" id="txtMail" value="<?php echo"$employeeEmail_id";  ?>"/>    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    
    <tr bgcolor="#0099CC">
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
</form>
</body>
</html>

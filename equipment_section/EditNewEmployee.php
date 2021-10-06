<?php 
include("common.php");
CreateConnection();
//-------------Assigning header value to the variable---//
//Retreving value from the session.....//
session_start();
$emp_id=$_SESSION['$edit_emp_id'];

//$emp_Name=$_GET['emp_name'];
//echo"$emp_Name";
$emp_status=$_GET['emp_status'];
$emp_location=$_GET['emp_location'];
$emp_category=$_GET['emp_category'];
$emp_type=$_GET['emp_type'];
//$emp_labor_rate=$_GET['emp_labor_rate'];
//$emp_ssn=$_GET['emp_ssn'];
//$emp_hire_date=$_GET['emp_hire_date'];
//$emp_physical_date=$_GET['emp_physical_date'];
//$emp_dob=$_GET['emp_dob'];
//$emp_leave_date=$_GET['emp_leave_date'];
//$emp_physical_due_date=$_GET['emp_physical_due_date'];
//$emp_driver_license_number=$_GET['emp_driver_license_number'];
//$emp_driver_license_class=$_GET['emp_driver_license_class'];
//$emp_driver_license_state=$_GET['emp_driver_license_state'];
//$emp_driver_license_expire_date=$_GET['emp_driver_license_expire_date'];
//$emp_driver_license_note=$_GET['emp_driver_license_note'];

/*//Checking Maximum Employee ID.....//
$qry = "SELECT MAX(emp_id) FROM add_new_employee";
$qryexecute=mysqli_query($db, $qry);
$rs=mysql_result($qryexecute,0,0);
//echo("$rs");
if($rs==0)
{
$emp_id=1;
//echo("$work_order_id");
}
else
{
$emp_id=$rs+1;
//echo("$work_order_id");
}
//----------------Generating session to hold employee id----------------------//
session_start();
$_SESSION['employee_id']=$emp_id;
*/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Edit Employee - General Information Entry Form</title>

<!-- Javascript For The Date Retreival  -->
<script type="text/javascript" language="JavaScript1.2" src="stm32.js"></script>
<script language="javascript" type="text/javascript" src="datetimepicker.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" type="text/javascript" SRC="timepicker.js"></SCRIPT>
<!-- END  -->

<script language="javascript">
/*
<!-- Javascript For Openning A New Window For Contact Information  -->
function openpopupContact(){
var centerWidth=(screen.width/2)-(300/2);
var centerHeight=(screen.height/2)-(300/2);
winpops=window.open("AddNewEmployeeContact.php","","height=230,width=500,top="+centerHeight+",left="+centerWidth+",toolbar=0,location=0,directories=0,status=0,scrollbars=0,menubar=0,resizable=0,");
}
*/

<!-- Validating Form's input -->
function validate(frm)
{
if(frm.txt_emp_name.value=="")
{
alert("Please Enter Employee Name.");
frm.txt_emp_name.focus();
return false;
}

else if(frm.txt_dob.value=="")
{
alert("Please Enter Employe's Date-of-Birth.");
frm.txt_dob.focus();
return false;
}
return true;
}



function doFinish(frm)
{
if(validate(frm)==true)
{
document.form1.submit();
}
}
//------------------For Close Button------------//
function goClose()
{
location.href="EmployeeManagment.php"
}
</script>

<link href="common.css" rel="stylesheet" type="text/css" />
</head>

<body>
<center>
<form id="form1" name="form1" method="post" action="EditNewEmployeeMedium.php">
  <br />
  <table width="600" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
    <tr bgcolor="#33CC33">
      <td colspan="4">General Information </td>
    </tr>
    <tr>
      <td>Employee #: </td>
	 <td><label>
	   <input name="txt_emp_id" type="text" id="txt_emp_id" READONLY value="<?php echo"$emp_id"; ?>"/>
	 </label></td>
      <td>Category:</td>
      <td>
	  <select name="selectCategory" id="selectCategory">
	  
	  									<?php  
			
									$rs="SELECT emp_category_id,emp_category_type FROM add_new_employee_category";
																																								
									$result = mysqli_query($db, $rs);
									while ($name_row = mysql_fetch_row($result)) {
									$emp_category_id=$name_row[0];
									$emp_category_type=$name_row[1];
									echo"<option value='$emp_category_id'"; if($emp_category_id==$emp_category) echo ' SELECTED ';echo">-> $emp_category_type</option>";		
									}
									
											
									
									
									?>
      </select>	  </td>
    </tr>
    <tr>
      <td>Name:</td>
      <td><input name="txt_emp_name" type="text" id="txt_emp_name" value="<?php echo $_GET['emp_name']; ?>"/></td>
      <td>Type:</td>
      <td>
	  <select name="selectType" id="selectType">
      
	  											  									<?php  
			
									$rs="SELECT emp_type_id,emp_type_name FROM add_new_employee_type";
																																								
									$result = mysqli_query($db, $rs);
									while ($name_row = mysql_fetch_row($result)) {
									$emp_type_id=$name_row[0];
									$emp_type_name=$name_row[1];
									echo"<option value='$emp_type_name'";if($emp_type_name==$emp_type) echo ' SELECTED ';echo">-> $emp_type_name</option>";		
									}
									
											
									
									
									?>
	  </select>	  </td>
    </tr>
    <tr>
      <td>Status</td>
      <td><select name="select_emp_status" id="select_emp_status">
        <?php  
			
									
									CreateConnection();
			
									$rs="SELECT emp_status_id,emp_status_type FROM add_new_employee_status";
																																								
									$result = mysqli_query($db, $rs);
									while ($name_row = mysql_fetch_row($result)) {
									$emp_status_id=$name_row[0];
									$emp_status_type=$name_row[1];
									echo"<option value='$emp_status_id'"; if($emp_status_id==$emp_status) echo ' SELECTED '; echo">-> $emp_status_type</option>";		
									}
									
											
									
									
									?>
      </select></td>
      <td>Labor Rate: </td>
      <td><input name="txt_labor_rate" type="text" id="txt_labor_rate" size="15" value="<?php echo $_GET['emp_labor_rate']; ?>"/></td>
    </tr>
    <tr>
      <td>Location:</td>
      <td><label>
      <select name="selectLocation" id="selectLocation">
	  <option value="1"<?php if($emp_location=="1") echo ' SELECTED '; ?>>-> Equipment</option>
	  <option value="2"<?php if($emp_location=="2") echo ' SELECTED '; ?>>-> Facilities</option>
	  <option value="3"<?php if($emp_location=="3") echo ' SELECTED '; ?>>-> Tools</option>
	  <option value="4"<?php if($emp_location=="4") echo ' SELECTED '; ?>>-> Vassels</option>
      </select>
      </label></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <br />
  <table width="600" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
    <tr bgcolor="#33CC33">
      <td colspan="4">Personnel Information </td>
    </tr>
    <tr>
      <td>SSN:</td>
      <td><label>
        <input name="txt_emp_ssn" type="text" id="txt_emp_ssn" value="<?php echo $_GET['emp_ssn']; ?>"/>
      </label></td>
      <td>DOB:</td>
      <td><input name="txt_dob" type="text" id="txt_dob" value="<?php echo $_GET['emp_dob']; ?>" size="15" />
        <a href="javascript:NewCal('txt_dob','yyyymmdd','true',12)"><img src="cal.gif" width="16" height="16" border="0" /></a></td>
    </tr>
    <tr>
      <td>Hire Date </td>
      <td><input name="txt_hire_date" type="text" id="txt_hire_date" value="<?php echo $_GET['emp_hire_date']; ?>" size="15" />
      <a href="javascript:NewCal('txt_hire_date','yyyymmdd','true',12)"><img src="cal.gif" width="16" height="16" border="0" /></a></td>
      <td>Date Of Leave: </td>
      <td><input name="txt_leave_date" type="text" id="txt_leave_date" value="<?php echo $_GET['emp_leave_date']; ?>" size="15" />
        <a href="javascript:NewCal('txt_leave_date','yyyymmdd','true',12)"><img src="cal.gif" width="16" height="16" border="0" /></a></td>
    </tr>
    <tr>
      <td>Last Physical: </td>
      <td><input name="txt_last_date" type="text" id="txt_last_date" value="<?php echo $_GET['emp_physical_date']; ?>" size="15" />
        <a href="javascript:NewCal('txt_last_date','yyyymmdd','true',12)"><img src="cal.gif" width="16" height="16" border="0" /></a></td>
      <td>Physical Due: </td>
      <td><input name="txt_due_date" type="text" id="txt_due_date" value="<?php echo $_GET['emp_physical_due_date']; ?>" size="15" />
        <a href="javascript:NewCal('txt_due_date','yyyymmdd','true',12)"><img src="cal.gif" width="16" height="16" border="0" /></a></td>
    </tr>
  </table>
  <br />
  <table width="600" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
    <tr>
      <td colspan="4" bgcolor="#33CC33">Driver License Information </td>
    </tr>
    <tr>
      <td>Number:</td>
      <td><label>
        <input name="txt_license_number" type="text" id="txt_license_number" value="<?php echo $_GET['emp_driver_license_number']; ?>"/>
      </label></td>
      <td>Expire Date :</td>
      <td><input name="txt_license_espire_date" type="text" id="txt_license_espire_date" value="<?php echo $_GET['emp_driver_license_expire_date']; ?>" size="15" />
        <a href="javascript:NewCal('txt_license_espire_date','yyyymmdd','true',12)"><img src="cal.gif" width="16" height="16" border="0" /></a></td>
    </tr>
    <tr>
      <td>Class:</td>
      <td><input name="txt_license_class" type="text" id="txt_license_class" value="<?php echo $_GET['emp_driver_license_class']; ?>"/></td>
      <td>Notes:</td>
      <td><a href="javascript:NewCal('txt_leave','yyyymmdd','true',12)">
        <input name="txt_license_note" type="text" id="txt_license_note" value="<?php echo $_GET['emp_name']; ?>"/>
      </a></td>
    </tr>
    <tr>
      <td>City/State:</td>
      <td><input name="txt_license_city" type="text" id="txt_license_city" value="<?php echo $_GET['emp_driver_license_state']; ?>"/></td>
      <td>&nbsp;</td>
      <td><a href="javascript:NewCal('txt_issued','yyyymmdd','true',12)"></a></td>
    </tr>
  </table>
  <br />
  <table width="600" border="0" cellspacing="0" cellpadding="0">
    <tr bgcolor="#33CC33">
      <td width="167"><label>
        <input name="save" type="button" id="save" value="Edit Contact Information" onclick="doFinish(form1)"/>
      </label></td>
      <td width="318">&nbsp;&nbsp;&nbsp;<input name="clear2" type="reset" id="clear2" value="Edit Certificate Information" />
		 &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
          <input name="clear" type="reset" id="clear" value="      Clear     " />
        </td>
      <td width="115"><center><input name="exit" type="button" id="exit" value="     Close     " onclick="goClose()"/>
      </center></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</form>
</center>
</body>
</html>

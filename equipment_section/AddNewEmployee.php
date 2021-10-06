<?php 
include("common.php");
CreateConnection();
//Checking Maximum Employee ID.....//
$qry = "SELECT MAX(emp_id) FROM add_new_employee";
$qryexecute=mysqli_query($db, $qry);
$rs=mysql_result($qryexecute,0,0);
//echo("$rs");
if($rs==0)
{
$emp_id=101;
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

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Add New Employee - General Information Entry Form</title>

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

</head>

<body>
<center>
<form id="form1" name="form1" method="post" action="AddNewEmployeeMedium.php">
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
									echo"<option value='$emp_category_id'>-> $emp_category_type</option>";		
									}
									
											
									
									
									?>
						
	  
      </select>
	  </td>
    </tr>
    <tr>
      <td>Name:</td>
      <td><input name="txt_emp_name" type="text" id="txt_emp_name"/></td>
      <td>Type:</td>
      <td>
	  <select name="selectType" id="selectType">
      
	  											  									<?php  
			
									$rs="SELECT emp_type_id,emp_type_name FROM add_new_employee_type";
																																								
									$result = mysqli_query($db, $rs);
									while ($name_row = mysql_fetch_row($result)) {
									$emp_type_id=$name_row[0];
									$emp_type_name=$name_row[1];
									echo"<option value='$emp_type_name'>-> $emp_type_name</option>";		
									}
									
											
									
									
									?>

	  
	  </select>
	  </td>
    </tr>
    <tr>
      <td>Status</td>
      <td>
	  
	  <select name="select_emp_status" id="select_emp_status">
      										
									<?php  
			
									
									CreateConnection();
			
									$rs="SELECT emp_status_id,emp_status_type FROM add_new_employee_status";
																																								
									$result = mysqli_query($db, $rs);
									while ($name_row = mysql_fetch_row($result)) {
									$emp_status_id=$name_row[0];
									$emp_status_type=$name_row[1];
									echo"<option value='$emp_status_id'>-> $emp_status_type</option>";		
									}
									
											
									
									
									?>

	  
	  </select>
	  
	  </td>
      <td>Labor Rate: </td>
      <td><input name="txt_labor_rate" type="text" id="txt_labor_rate" size="15"/></td>
    </tr>
    <tr>
      <td>Location:</td>
      <td><label>
      <select name="selectLocation" id="selectLocation">
	  <option value="1">-> Equipment</option>
	  <option value="2">-> Facilities</option>
	  <option value="3">-> Tools</option>
	  <option value="4">-> Vassels</option>

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
        <input name="txt_emp_ssn" type="text" id="txt_emp_ssn"/>
      </label></td>
      <td>DOB:</td>
      <td><input name="txt_dob" type="text" id="txt_dob" size="15" READONLY/>
        <a href="javascript:NewCal('txt_dob','yyyymmdd','true',12)"><img src="cal.gif" width="16" height="16" border="0" /></a></td>
    </tr>
    <tr>
      <td>Hire Date </td>
      <td><input name="txt_hire_date" type="text" id="txt_hire_date" size="15" READONLY/>
      <a href="javascript:NewCal('txt_hire_date','yyyymmdd','true',12)"><img src="cal.gif" width="16" height="16" border="0" /></a></td>
      <td>Date Of Leave: </td>
      <td><input name="txt_leave_date" type="text" id="txt_leave_date" size="15" READONLY/>
        <a href="javascript:NewCal('txt_leave_date','yyyymmdd','true',12)"><img src="cal.gif" width="16" height="16" border="0" /></a></td>
    </tr>
    <tr>
      <td>Last Physical: </td>
      <td><input name="txt_last_date" type="text" id="txt_last_date" size="15" READONLY/>
        <a href="javascript:NewCal('txt_last_date','yyyymmdd','true',12)"><img src="cal.gif" width="16" height="16" border="0" /></a></td>
      <td>Physical Due: </td>
      <td><input name="txt_due_date" type="text" id="txt_due_date" size="15" READONLY/>
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
        <input name="txt_license_number" type="text" id="txt_license_number"/>
      </label></td>
      <td>Expire Date :</td>
      <td><input name="txt_license_espire_date" type="text" id="txt_license_espire_date" size="15" READONLY/>
        <a href="javascript:NewCal('txt_license_espire_date','yyyymmdd','true',12)"><img src="cal.gif" width="16" height="16" border="0" /></a></td>
    </tr>
    <tr>
      <td>Class:</td>
      <td><input name="txt_license_class" type="text" id="txt_license_class"/></td>
      <td>Notes:</td>
      <td><a href="javascript:NewCal('txt_leave','yyyymmdd','true',12)">
        <input name="txt_license_note" type="text" id="txt_license_note"/>
      </a></td>
    </tr>
    <tr>
      <td>City/State:</td>
      <td><input name="txt_license_city" type="text" id="txt_license_city"/></td>
      <td>&nbsp;</td>
      <td><a href="javascript:NewCal('txt_issued','yyyymmdd','true',12)"></a></td>
    </tr>
  </table>
  <br />
  <table width="600" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="167"><label>
        <input name="save" type="button" id="save" value=" Add Contact Information" onclick="doFinish(form1)"/>
      </label></td>
      <td width="318">&nbsp;&nbsp;&nbsp;<input name="clear2" type="reset" id="clear2" value="Add Certificate Information" />
		 &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
          <input name="clear" type="reset" id="clear" value="      Clear     " />
        </td>
      <td width="115"><center><input name="exit" type="button" id="exit" value="      Exit      " onclick="goClose()"/>
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

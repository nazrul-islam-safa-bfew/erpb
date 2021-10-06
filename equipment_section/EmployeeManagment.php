<?php 
include("common.php");
CreateConnection();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Employee Managment Screen</title>

<!-- Script to catch Buttons Click Event -->

<script language="javascript">
//---For Rows onClick(To Edit) Event
function goEdit(m)
{
document.form1.hid_emp_id.value=m;
document.form1.hidField.value=2;
document.form1.submit();
}

//---For Save Button
function goAdd()
{
document.form1.hidField.value=1;
document.form1.submit();
}

//---For Delete Button
function goDelete()
{
//----Opens a sepere window to load EmployeeCategoryManagment.php page.....
/*var centerWidth=(screen.width/2)-(300/2);
var centerHeight=(screen.height/2)-(300/2);
winpops=window.open("DeleteNewEmployee.php","","height=250,width=350,top="+centerHeight+",left="+centerWidth+",toolbar=0,location=0,directories=0,status=0,scrollbars=1,menubar=0,resizable=0,");
*/
}

//---For Save Button
/*function goPrint()
{
window.print();
}*/
</script>


<link href="common.css" rel="stylesheet" type="text/css" />
</head>

<body onload="MyReload()">
<form id="form1" name="form1" method="post" action="EmployeeManagmentMedium.php">
  <input name="hidField" type="hidden" id="hidField" />
  <input name="hid_emp_id" type="hidden" id="hid_emp_id" />
  <br />
  <table width="4000" border="1" cellpadding="0" cellspacing="0">
    <tr bgcolor="#33CC33">
      <th width="127">Employee # </th>
      <th width="125">Name</th>
      <th width="224">Address #1</th>
      <th width="226">Address #2</th>
      <th width="85">City</th>
      <th width="87">District</th>
      <th width="115">Postal Code </th>
      <th width="113">Phone #1 </th>
      <th width="102">Mobile # </th>
      <th width="98">Pager  </th>
      <th width="186">E-mail</th>
      <th width="276">Notes</th>
      <th width="100">SSN</th>
      <th width="156">Driver License # </th>
      <th width="183">Driver License State </th>
      <th width="172">Driver License Class </th>
      <th width="197">Driver License Expires </th>
      <th width="428">Driver License Notes </th>
      <th width="108">Hire Date </th>
      <th width="104">Leave Date </th>
      <th width="94">DOB</th>
      <th width="115">Last Physical </th>
      <th width="125">Next Physical</th>
      <th width="168">Type</th>
      <th width="116">Rate(TK.)</th>
      <th width="116">Status</th>
    </tr>
	
									<?php 
											$qry="SELECT emp_id,emp_Name,emp_contact_address1,emp_contact_address2,emp_contact_city,emp_contact_district,emp_contact_postal_code,emp_contact_home_phone,emp_contact_mobile,emp_contact_pager,emp_contact_email,emp_contact_notes,emp_ssn,emp_driver_license_number,emp_driver_license_state,emp_driver_license_class,emp_driver_license_expire_date,emp_driver_license_note,emp_hire_date,emp_leave_date,emp_dob,emp_physical_date,emp_physical_due_date,emp_type,emp_labor_rate,emp_status FROM add_new_employee";							
											
											$qryexecute = mysqli_query($db, $qry);
												while ($name = mysql_fetch_row($qryexecute)) 
												{
														$emp_id=$name[0];
														$emp_Name=$name[1];
														$emp_contact_address1=$name[2];
														$emp_contact_address2=$name[3];
														$emp_contact_city=$name[4];
														$emp_contact_district=$name[5];
														$emp_contact_postal_code=$name[6];
														$emp_contact_home_phone=$name[7];
														$emp_contact_mobile=$name[8];
														$emp_contact_pager=$name[9];
														$emp_contact_email=$name[10];
														$emp_contact_notes=$name[11];
														$emp_ssn=$name[12];
														$emp_driver_license_number=$name[13];
														$emp_driver_license_state=$name[14];
														$emp_driver_license_class=$name[15];							
														$emp_driver_license_expire_date1=$name[16];
														$emp_driver_license_note=$name[17];
														$emp_hire_date1=$name[18];
														$emp_leave_date1=$name[19];
														$emp_dob=$name[20];
														$emp_physical_date1=$name[21];
														$emp_physical_due_date1=$name[22];
														$emp_type=$name[23];
														$emp_labor_rate1=$name[24];
														$emp_status=$name[25];
														
														//formatting $emp_labor_rate1 to currency formar...
														$emp_labor_rate=number_format($emp_labor_rate1,2);
														
														
														//formatting DATES...
												//FORMTTING emp_hire_date
												if($emp_hire_date1=="0000-00-00")
												{
													$emp_hire_date="";
												}
												else
												{
												$dates = array($emp_hire_date1);
												foreach ($dates as $timestamp) {
												  $emp_hire_date = explode("-",$timestamp);
												}
												}

												//FORMTTING emp_leave_date
												if($emp_leave_date1=="0000-00-00")
												{
													$emp_leave_date="";
												}
												else
												{
												$dates = array($emp_leave_date1);
												foreach ($dates as $timestamp) {
												  $emp_leave_date = explode("-",$timestamp);
												}
												}

												//FORMTTING emp_physical_date1
												if($emp_physical_date1=="0000-00-00")
												{
													$emp_physical_date="";
												}
												else
												{
												$dates = array($emp_physical_date1);
												foreach ($dates as $timestamp) {
												  $emp_physical_date = explode("-",$timestamp);
												}
												}

												//FORMTTING emp_physical_due_date1
												if($emp_physical_due_date1=="0000-00-00")
												{
													$emp_physical_due_date="";
												}
												else
												{
												$dates = array($emp_physical_due_date1);
												foreach ($dates as $timestamp) {
												  $emp_physical_due_date = explode("-",$timestamp);
												}
												}

														
													//FORMTTING emp_driver_license_expire_date1
												if($emp_driver_license_expire_date1=="0000-00-00")
												{
													$emp_driver_license_expire_date="";
												}
												else
												{
												$dates = array($emp_driver_license_expire_date1);
												foreach ($dates as $timestamp) {
												  $emp_driver_license_expire_date = explode("-",$timestamp);
												}
												}
													
									/*//----RETREIVING EMY_TYPE_NAME FROM add_new_employee_type TABLE
										$qry1="SELECT emp_type_name FROM add_new_employee_type WHERE emp_type_id='$emp_type'";
										$qryexecute1=mysqli_query($db, $qry1);
										$emp_typ_name=mysql_result($qryexecute1,0,0);
										*/
									//----RETREIVING emp_status_type FROM add_new_employee_status TABLE
									$qry2="SELECT emp_status_type FROM add_new_employee_status WHERE emp_status_id='$emp_status'";
									$qryexecute2=mysqli_query($db, $qry2);
									$emp_stat_type=mysql_result($qryexecute2,0,0);
												
		
									//--GENERATING ROWS DYNAMICALLY FOR THE RETORN RECORD SET...//
											echo"<tr onclick='goEdit($emp_id)'>
											<td>$emp_id</td>
											<td>$emp_Name</td>
											<td>$emp_contact_address1</td>
											<td>$emp_contact_address2</td>
											<td>$emp_contact_city</td>
											<td>$emp_contact_district</td>
											<td>$emp_contact_postal_code</td>
											<td>$emp_contact_home_phone</td>
											<td>$emp_contact_mobile</td>
											<td>$emp_contact_pager</td>
											<td>$emp_contact_email</td>
											<td>$emp_contact_notes</td>
											<td>$emp_ssn</td>
											<td>$emp_driver_license_number</td>
											<td>$emp_driver_license_state</td>
											<td>$emp_driver_license_class</td>
				<td>$emp_driver_license_expire_date[2]-$emp_driver_license_expire_date[1]-$emp_driver_license_expire_date[0]</td>
											<td>$emp_driver_license_note</td>
											<td>$emp_hire_date[2]-$emp_hire_date[1]-$emp_hire_date[0]</td>
											<td>$emp_leave_date[2]-$emp_leave_date[1]-$emp_leave_date[0]</td>
											<td>$emp_dob</td>
											<td>$emp_physical_date[2]-$emp_physical_date[1]-$emp_physical_date[0]</td>
											<td>$emp_physical_due_date[2]-$emp_physical_due_date[1]-$emp_physical_due_date[0]</td>
											<td>$emp_type</td>
											<td>$emp_labor_rate</td>
											<td>$emp_stat_type</td>";
												}
				
													
									?>
  </table>
  <p>&nbsp;</p>
  <table width="971" border="0" cellpadding="0" cellspacing="0" bgcolor="#33CC33">
    <tr>
      <td width="217"><input name="add" type="button" id="add" accesskey="A" value="    Add    " onclick="goAdd()" /></td>
      <td width="234"><input name="delete" type="button" id="delete" accesskey="A" value="   Delete  " onclick="javascript:location.href='DeleteNewEmployee.php'" /></td>
      <td width="257"><input name="print" type="button" id="print" accesskey="A" value="     Print    " onclick="javascript:window.print()" /></td>
      <td width="263"><input name="close" type="button" id="close" accesskey="A" value="    Close   " onclick="javascript:window.close()" /></td>
    </tr>
  </table>
  <br />
</form>
</body>
</html>

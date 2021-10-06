<?php 
include("common.php");
CreateConnection();
//---Assining Session value which store the Work Order Id initiated at the NewWorkOrder.php page--
session_start();
$work_order_id=$_SESSION['workorder_id'];
//echo"$work_order_id<br>";
//-------------------------------------------------END-----------------------------------
//---Assining Session value which store the PM Service Id initiated at the NewWorkOrder_Add_PM_Entry.php page--
$pm_service_id=$_SESSION['pm_service_id'];
//echo"$pm_service_id<br>";
//-------------------------------------------------END-----------------------------------
$hid=$_POST['hidField'];
//--this portion will be executed wheen the form is submitted to itself.....
if($hid==1)
{
include("modified_common.php");

$tech_id=$_POST['selectTech'];
$desc_of_work=$_POST['textarea'];
$labor_rate=$_POST['txtLaborRate'];
$work_Hour=$_POST['txtHour'];
$total_cost=$_POST['txtTotal'];
/*echo"$tech_name<br>";
echo"$desc_of_work<br>";
echo"$labor_rate<br>";
echo"$work_Hour<br>";
echo"$total_cost<br>";*/
//---query to insert data to the new_work_order_pm_labor_used table---//
$qry="INSERT INTO new_work_order_pm_labor_used (work_order_id,pm_service_id,emp_id,desc_of_work,emp_labor_rate,work_hour,lobor_cost) VALUES ('$work_order_id', '$pm_service_id', '$tech_id', '$desc_of_work', '$labor_rate', '$work_Hour', '$total_cost')";
$qryexecute=mysqli_query($db, $qry,$connection_equip);
if($qryexecute)
{
header("Location: NewWorkWorder_Add_PM_Entry.php?count=1");
}
else
{
echo"couldn't connect to the database.";
}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Work Worder ( #<?php echo"$work_order_id"; ?>) - PM Labor Entry Form</title>
<!-- For Creting the Equipment Session ID by calling server.php file  -->
<script src="script.js" type="text/javascript"></script>

<script language="javascript">
//---Function to track combo's onChange event---//
function goChange(m)
{
var emp_id=m;
xmlhttp.open("GET", 'server1.php?empployee_id=' + emp_id);

xmlhttp.onreadystatechange = function() {
if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
document.form1.txtLaborRate.value = xmlhttp.responseText;}
}
xmlhttp.send(null);
}


//-----------------------For tracking txtHour change event-----//
function goCalculate(l)
{
/*var num=parseInt(l);
if(isNaN(num))
{
alert("OK");
}
*/
var m=document.form1.txtLaborRate.value;
var calculate=m*l
//alert(calculate);
document.form1.txtTotal.value=calculate;
}


//-------------------------Validating Form Imput & Then Save & Exit------------------------------

function validate(frm)
{
if(frm.selectTech.value=="")
{
alert("Please Select A Technician.");
frm.selectTech.focus();
return false;
}
else if(frm.txtHour.value=="")
{
alert("Please Enter Hour.");
frm.txtHour.focus();
return false;
}
else if(isNaN(frm.txtTotal.value))
{
alert("Please Enter Integer Number.");
frm.txtHour.focus();
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

</head>
<body>
<form id="form1" name="form1" method="post" action="NewWorkWorder_Add_PM_LaborUsed.php">
  <p>
    <input name="hidField" type="hidden" id="hidField" />
  </p>
  <p>&nbsp;</p>
  <table width="384" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr bgcolor="#33CC33">
      <td colspan="2" bgcolor="#33CC33">Labor Information </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#FF99FF">
      <td width="130">Technician:		</td>
      <td width="254" bgcolor="#FF99FF"><label>
        <select name="selectTech" id="selectTech" onchange="">
          <option value="" selected></option>
          <?php  
									  include("connection.php");
													$rs="SELECT empId,name FROM employee";
																			
														$result = mysqli_query($db, $rs,$connection);
														while ($name_row = mysql_fetch_row($result)) {
														$emp_id=$name_row[0];
														$emp_Name=$name_row[1];
														echo"<option value='$emp_id'>->$emp_id - $emp_Name</option>";
														}
														
																
														
														
									?>
        </select>
      </label></td>
    </tr>
    <tr bgcolor="#FF99FF">
      <td bgcolor="#FF99FF">Description of work performed: </td>
      <td><label>
        <textarea name="textarea"></textarea>
      </label></td>
    </tr>
    <tr bgcolor="#FF99FF">
      <td bgcolor="#FF99FF">Labor Rate </td>
      <td><label>
        <input name="txtLaborRate" type="text" id="txtLaborRate"/>
      Per Hour </label></td>
    </tr>
    <tr bgcolor="#FF99FF">
      <td>Hours:</td>
      <td><input name="txtHour" type="text" id="txtHour" onchange="goCalculate(this.value)"/></td>
    </tr>
    <tr bgcolor="#FF99FF">
      <td>Total Cost </td>
      <td><input name="txtTotal" type="text" id="txtTotal" READONLY/></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#33CC33">
      <td bgcolor="#33CC33"><label>
        <input name="save" type="button" id="save" value="      Save     " onclick="doFinish(form1)"/>
      </label></td>
      <td bgcolor="#33CC33">
        <div align="center">
          <input name="close" type="button" id="close" value="      Close     " onclick="javascript:location.href='NewWorkWorder_Add_PM_Entry.php'"/>
        </div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</form>
</body>
</html>

<?php
include("common.php");
CreateConnection();
//---Assining Session value which store the Work Order Id initiated at the NewWorkOrder.php page--
session_start();
$work_order_id=$_SESSION['workorder_id'];
//---Assining Session value which store the Equipment id initiated at the NewWorkOrder.php(created in server.php) page--
$equipment_id=$_SESSION['equip_id'];
//-----------------------END-------------------------//
$hid=$_POST['hidField'];
//--this portion will be executed wheen the form is submitted to itself(SAVE RECORD).....
if($hid==1)
{
$external_date=$_POST['txtDate'];
$vend_id=$_POST['cmbVendor'];
$desc=$_POST['txtDesc'];
$cost=$_POST['txtTotal'];
/*echo"$work_order_id<br>";
echo"$equipment_id<br>";

echo"$external_date<br>";
echo"$vend_id<br>";
echo"$desc<br>";
echo"$cost<br>";*/
//---query to insert data to the new_work_order_pm_labor_used table---//
$qry="INSERT INTO new_work_order_external_service_entry (work_order_id,item_id,date,vendor_id,description,cost) VALUES ('$work_order_id', '$equipment_id', '$external_date', '$vend_id', '$desc', '$cost')";
$qryexecute=mysqli_query($db, $qry);
if($qryexecute)
{
header("Location: NewWorkWorder.php?count=1");
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
<title>Work Worder ( #<?php echo"$work_order_id"; ?>) - External Service Entry Form</title>

<!-- Javascript For The Date Retreival  -->
<script type="text/javascript" language="JavaScript1.2" src="stm32.js"></script>
<script language="javascript" type="text/javascript" src="datetimepicker.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" type="text/javascript" SRC="timepicker.js"></SCRIPT>
<!-- END  -->

<script language="javascript">

//-------------------------Validating Form Imput & Then Save & Exit------------------------------
function validate(frm)
{
if(frm.txtDate.value=="")
{
alert("Please Select Date.");
frm.txtDate.focus();
return false;
}
else if(frm.cmbVendor.value=="")
{
alert("Please Select Vendor.");
frm.cmbVendor.focus();
return false;
}
else if(frm.txtTotal.value=="")
{
alert("Please Enter Price.");
frm.txtTotal.focus();
return false;
}
else if(isNaN(frm.txtTotal.value))
{
alert("Please Enter Integer Number.");
frm.txtTotal.focus();
return false;
}
return true;
}

function doFinish(frm)
{
if(validate(frm)==true)
{
document.form1.hidField.value=1;
//alert(document.form1.hidField.value);
document.form1.submit();
}
}

</script>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <p>&nbsp;</p>
  <p>
    <input name="hidField" type="hidden" id="hidField" />
  </p>
  <table width="384" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr bgcolor="#33CC33">
      <td colspan="2" bgcolor="#33CC33">Add Externel Service Entry </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#FF99FF">
      <td width="130">Date </td>
      <td><input name="txtDate" type="text" id="txtDate" size="15" />
        <a href="javascript:NewCal('txtDate','yyyymmdd','true',12)"><img src="cal.gif" alt="calender" width="16" height="16" border="0" /></a></td>
    </tr>
    <tr bgcolor="#FF99FF">
      <td bgcolor="#FF99FF">Vendor</td>
      <td><label>
							<select name="cmbVendor" id="cmbVendor">
					
										 <?php 
							 
													 CreateConnection();
													$qry2="SELECT vendor_id,vendor_name FROM vendor_setup";
													$qryexecute2=mysqli_query($db, $qry2);
											
											while($rs=mysql_fetch_row($qryexecute2))
											{
												$vendor_id=$rs[0];
												$vendor_name=$rs[1];
																															
												echo"<option value='$vendor_id'>$vendor_name</option>";
												}
							 
										 ?>

							
							
							</select>
      </label></td>
    </tr>
    <tr bgcolor="#FF99FF">
      <td bgcolor="#FF99FF">Description</td>
      <td><label>
        <textarea name="txtDesc" id="txtDesc"></textarea>
      </label></td>
    </tr>
    
    <tr bgcolor="#FF99FF">
      <td>Cost </td>
      <td><input name="txtTotal" type="text" id="txtTotal" size="15" />
        TK.</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#33CC33">
      <td bgcolor="#33CC33"><label>
        <input name="save" type="button" id="save" value="      Save     " onclick="doFinish(form1)"/>
      </label></td>
      <td bgcolor="#33CC33"><div align="center">
          <input name="close" type="button" id="close" value="      Close     " onclick="javascript:location.href='NewWorkWorder.php'"/>
      </div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
</body>
</html>

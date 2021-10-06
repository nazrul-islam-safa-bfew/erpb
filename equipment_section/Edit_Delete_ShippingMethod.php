<?php													
include("common.php");
CreateConnection();
//assigning posted serial number of the method type(By header) to the variable..
$method_serial=$_GET['m_serial'];
//retreiving method_type name based based on the serisl numvber...
$qry_method="SELECT method_type FROM shipping_method WHERE serial_no='$method_serial'";
$qryexecute_method=mysqli_query($db, $qry_method);
$rs=mysql_fetch_row($qryexecute_method);
$method_type=$rs[0];
//creating session to hold the serial number which needs to be edited..
session_start();
$_SESSION['serial']=$method_serial;
//Assigning Posted value to the variable ....//
$hid=$_POST['hidField'];

//---Update record in add_new_employee_type table---//
//-----For UPDATE Button...............
if($hid==1)
{
$method_name=$_POST['txt_method'];
//RETREIVING SESSION VALUE WHICH CONTAINS THE METHOD TYPE
session_start();
$method_serial_no=$_SESSION['serial'];

$qry="UPDATE shipping_method SET method_type='$method_name' WHERE serial_no='$method_serial_no'";
$qryexecute=mysqli_query($db, $qry);
if($qryexecute)
{
header("Location: shippingMethod.php?type=$method_serial_no");
}
else
{
echo("Shipping Method Type Exist...");
}
}
//-----For DELETE Button...............
else if($hid==2)
{
//ASSIGNING SESSION VALUE WHICH CONTAINS THE EMPLOYEE Type ID
session_start();
$method_serial_no=$_SESSION['serial'];

$qry="DELETE FROM shipping_method WHERE serial_no='$method_serial_no'";
$qryexecute=mysqli_query($db, $qry);
header("Location: shippingMethod.php");
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Edit/Delete Shipping Method</title>

<script language="javascript">

//validating Form Input
function validate(frm)
{
if(frm.txt_method.value=="")
{
alert("Please Enter Shipping Method Type.");
frm.txt_method.focus();
return false;
}
else if(isNaN(frm.txt_method.value)==false)
{
alert("Invalid Name For The Shipping Method Type.Please Enter Character Data.");
frm.txt_method.focus();
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

//For Delete Button//
function goDelete()
{
document.form1.hidField.value=2;
document.form1.submit();
}

</script>
<style type="text/css">
<!--
@import url("common.css");
-->
</style>
<link href="common.css" rel="stylesheet" type="text/css" />
</head>
<body>
<form id="form1" name="form1" method="post" action="">
  <input name="hidField" type="hidden" id="hidField" />
  <table width="328" border="0" align="left" cellpadding="0" cellspacing="0">
  <tr>
      <td colspan="3" bgcolor="#0099CC">Update / Delete Employee Type </td>
    </tr>
    <tr bgcolor="#FF99FF">
      <td width="164">Enter Employee Type</td>
<td width="157" colspan="2"><input name="txt_method" type="text" id="txt_method" value="<?php echo"$method_type";  ?>"/></tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
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
	  <center>
	    <label><img src="Images/Cancel.gif" alt="Cancel" width="78" height="20" onclick="javascript:location.href='shippingMethod.php'"/></label>
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

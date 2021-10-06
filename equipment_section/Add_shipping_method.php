<?php													
include("common.php");
CreateConnection();
//assign poted method type name...
$method_type=$_POST['txt_method'];
$hid=$_POST['hidField'];

//assigning system date
$ins_date=date("Y-m-d");

//---insert record to shipping_method table---//
if($hid==1)
{
$qry="INSERT INTO shipping_method(method_type,created_date) VALUES ('$method_type','$ins_date')";
$qryexecute=mysqli_query($db, $qry);
if($qryexecute)
{
header("Location: shippingMethod.php");
}
else
{
echo("Shipping Method Type Exist...");
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
  <p>
    <input name="hidField" type="hidden" id="hidField" /></p>
  <table width="328" border="0" align="left" cellpadding="0" cellspacing="0">
  <tr bgcolor="#33CC33">
      <th colspan="2" bgcolor="#0099CC"><div align="left">Add New Shipping Method </div></th>
    </tr>
    <tr bgcolor="#FF99FF">
      <td width="164">Enter Method Type </td>
      <td width="157"><input name="txt_method" type="text" class="tableData" id="txt_method" /></td>
    </tr>
    <tr>
      <td class="tableHeading">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="tableHeading">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#0099CC">
      <td>
	  <center><input name="typeAdd" type="button" id="typeAdd" accesskey="A" value="    Add    "  onclick="doFinish(form1)"/>
	  </center>	  </td>
      <td>
	  <center><input name="close" type="button" id="close" accesskey="C" onclick="javascript:location.href='shippingMethod.php'" value="   Close  "/>
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

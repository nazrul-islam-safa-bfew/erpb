<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style1 {
	font-family: "Courier New", Courier, monospace;
	color: #669933;
	font-size: 18px;
	font-weight: bold;
}
-->
</style>
</head>


<?php 

require('common.php');
CreateConnection();


?>




<script>

function validate(frmEquipment)
{
if(frmEquipment.itmCode.value=="")
{
alert("Please Enter Item Code.");
frmEquipment.itmCode.focus();
return false;
}
else if(frmEquipment.itmDesc.value=="")
{
alert("Please Enter Item Description.");
frmEquipment.itmDesc.focus();
return false;
}

return true;

}

function doFinish(frmEquipment)
	{
	if (validate(frmEquipment)==true)
		{
			frmEquipment.submit();
		}
		
	}
</script>


<body>
<form id="frmEquipment" name="frmEquipment" method="post" action="ETSetupSuccessful.php">
  <center>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <table width="534" border="1">
    <tr>
      <td width="524" bgcolor="#003366"><div align="center"><span class="style1">EQUIPMENT TYPE SETUP</span> </div></td>
    </tr>
  </table></center>
  <center><table width="534" border="1">
    <tr>
      <td width="258"><label>
        <div align="right">Item Code
          <input name="itmCode" type="text" id="itmCode" />
        </div>
      </label></td>
      <td width="260"><label>
        <div align="right">Item Description
          <input name="itmDesc" type="text" id="itmDesc" />
        </div>
      </label></td>
    </tr>
    <tr>
      <td><div align="right">Item Specification
          <input name="itmSpec" type="text" id="itmSpec" />
      </div></td>
      <td><div align="right">Item Unit
          <input name="itmUnit" type="text" id="itmUnit" />
      </div></td>
    </tr>
    <tr>
      <td><label>
                <input type="button" name="Button" value="Save" accesskey="S" onclick="doFinish(frmEquipment)" />
      </label></td>
      <td><label>
      <input type="reset" name="Reset" value="Clear" accesskey="C" />
      </label></td>
    </tr>
  </table>
  </center>
  <p>&nbsp;</p>
</form>
</body>
</html>

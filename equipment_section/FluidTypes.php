
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Fluid Type Entry Form</title>



<script language="javascript">


function validate(frmmake)
{

if(frmmake.txtfluid.value=="")
{
alert("Please Enter Fluid Name.");
frmmake.txtfluid.focus();
return false;
}
return true;
}

function doFinish(frmmake)
{
if(validate(frmmake)==true)
{
frmmake.submit();
}
}
</script>
</head>

<body>
<form id="frmmake" name="frmmake" method="post" action="FluidTypeSuccessful.php">
  <table width="368" border="0" align="left" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="2" bgcolor="#33CC33">Fluid Type  Entry Form</td>
    </tr>
    <tr bgcolor="#FF99FF">
      <td width="210">Enter Fluid Type </td>
      <td width="290"><input name="txtfluid" type="text" id="txtfluid" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#990000">
      <td><input name="itemadd" type="button" id="itemadd" accesskey="A" value="             Add                "  onclick="doFinish(frmmake)"/></td>
      <td><input type="button" name="Button" value="            Close           " accesskey="C" onclick="javascript:window.close()"/></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</form>
</body>
</html>

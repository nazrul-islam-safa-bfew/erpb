
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PM Type Entry Form</title>



<script language="javascript">


function validate(frmmake)
{
if(frmmake.txtpmtype.value=="")
{
alert("Please Enter PM Sevice Name.");
frmmake.txtpmtype.focus();
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
<link href="common.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form id="frmmake" name="frmmake" method="post" action="PMTypeSetupSuccessful.php">
<table width="363" border="0" align="left" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" bgcolor="#33CC33">Equipment PM Type - Entry Form</td>
  </tr>
  <tr bgcolor="#FF99FF">
    <td width="198">Enter PM  Type </td>
    <td width="231"><input name="txtpmtype" type="text" id="txtpmtype" /></td>
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
    <td><input name="itemadd" type="button" id="itemadd" accesskey="A" value="         Add          "  onclick="doFinish(frmmake)"/></td>
    <td><input type="button" name="Button" value="            Close           " accesskey="C" onclick="javascript:window.close()"/></td>
  </tr>
</table>
<p>
<p>
<p>
</form>
</body>
</html>

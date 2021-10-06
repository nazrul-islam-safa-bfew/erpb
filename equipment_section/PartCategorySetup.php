
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Parts Category Entry Form</title>



<script language="javascript">


function validate(frmmake)
{
if(frmmake.txtpart.value=="")
{
alert("Please Enter Part's Category Name.");
frmmake.txtpart.focus();
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
<form id="frmmake" name="frmmake" method="post" action="PartCategorySetupSuccessful.php">
<table width="363" border="0" align="left" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" bgcolor="#33CC33">Equipment  Part's Category  - Entry Form</td>
  </tr>
  <tr bgcolor="#FF99FF">
    <td width="198">Enter Part's Category </td>
    <td width="231"><input name="txtpart" type="text" id="txtpart" /></td>
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
    <td><input type="button" name="Button" value="       Close      " accesskey="C" onclick="javascript:window.close()"/></td>
  </tr>
</table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  </form>
</body>
</html>

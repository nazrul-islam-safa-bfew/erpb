<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Add New Employee - Contact Information Entry Form</title>

<script language="javascript">
<!-- Validating Form's input -->
function validate(frm)
{
if(frm.txtContactAddress1.value=="")
{
alert("Please Enter Address.");
frm.txtContactAddress1.focus();
return false;
}

else if(frm.txtContactCity.value=="")
{
alert("Please Enter City Name.");
frm.txtContactCity.focus();
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



</script>

<link href="common.css" rel="stylesheet" type="text/css" />
</head>

<body>
<center>
<form id="form1" name="form1" method="post" action="AddNewEmployeeContactMedium.php">
<br />
  <table width="726" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
    <tr bgcolor="#33CC33">
      <td colspan="6" bgcolor="#33CC33">Address</td>
    </tr>
    <tr>
      <td width="84">Address 1: </td>
      <td colspan="5"><label>
        <input name="txtContactAddress1" type="text" id="txtContactAddress1" size="103"/>
      </label></td>
    </tr>
    
    <tr>
      <td>Address 2: </td>
      <td colspan="5"><input name="txtContactAddress2" type="text" id="txtContactAddress2" size="103"/></td>
    </tr>
    
    <tr>
      <td>City : </td>
      <td width="144"><input name="txtContactCity" type="text" id="txtContactCity" /></td>
      <td width="80">Stae/Prov:</td>
      <td width="157"><input name="txtContactState" type="text" id="txtContactState" /></td>
      <td width="100">Postal Code: </td>
      <td width="161"><input name="txtContactPostal" type="text" id="txtContactPostal" /></td>
    </tr>
	<tr>
      <td>&nbsp;</td>
      <td width="144">&nbsp;</td>
      <td width="80">&nbsp;</td>
      <td width="157">&nbsp;</td>
      <td width="100">&nbsp;</td>
      <td width="161">&nbsp;</td>
	</tr>
  </table>
  <br />
  <table width="726" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
    <tr bgcolor="#33CC33">
      <td colspan="4">Phone Numbers / E-mail </td>
    </tr>
    <tr>
      <td width="48">Home:</td>
      <td width="161"><input name="txtContactHomePhone" type="text" id="txtContactHomePhone" /></td>
      <td width="123">Pager:</td>
      <td width="404"><input name="txtContactPager" type="text" id="txtContactPager" size="30"/></td>
    </tr>
    <tr>
      <td>Cell</td>
      <td><input name="txtContactMobile" type="text" id="txtContactMobile" /></td>
      <td>E-mail:</td>
      <td><input name="txtContactEmail" type="text" id="txtContactEmail" size="30"/></td>
    </tr>
	<tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
	</tr>
  </table>
  <br />
  <table width="726" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
    <tr>
      <td bgcolor="#33CC33">Notes</td>
    </tr>
    <tr>
      <td><label>
        <center><textarea name="txtContactNotes" cols="82.5" rows="3" id="txtContactNotes"></textarea></center>
      </label></td>
    </tr>
  </table>
  <br />  
  <table width="726" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
    <tr bgcolor="#33CC33">
      <td width="231" bgcolor="#33CC33"><label>
        <center><input name="contactSave" type="button" id="contactSave" value="        Save        " onclick="doFinish(form1)"/>
        </center>
      </label></td>
      <td width="295">
	 <center> <input name="contactClose" type="submit" id="contactClose" value="         Close         " /></center>
	  </td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</form>
</center>
</body>
</html>

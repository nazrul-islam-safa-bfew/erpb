<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Add New Employee - Certification Information Managment Screen</title>

<script language="javascript">
//----------Executed when Add Button is clicked--------------
function goAdd()
{
document.form1.hidField.value=1;
document.form1.submit();
}


</script>

</head>

<body>
<form id="form1" name="form1" method="post" action="AddNewEmployeeCertificationInformationManagment_Medium.php">
  <input name="hidField" type="hidden" id="hidField" />
  <br />
  <table width="453" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>Certification Name </td>
      <td>Issued</td>
      <td>Expires</td>
      <td>Notes</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><label>
        <input name="CertificationAdd" type="submit" id="CertificationAdd" value="    Add    " onclick="goAdd()" />
      </label></td>
      <td><label>
        <input name="certificationClose" type="submit" id="certificationClose" value="   Close   " />
      </label></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</form>
</body>
</html>

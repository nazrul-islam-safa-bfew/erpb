<?php 
include("common.php");
CreateConnection();
//----------------Retreiving employee id from session AND ASSIGNING TO THE VARIABLE----------------------//
session_start();
$emp_id=$_SESSION['$edit_emp_id'];
//----------To retreive data from the add_new_employee table for edit---// 
$qry="SELECT emp_contact_address1,emp_contact_address2,emp_contact_city,emp_contact_district,emp_contact_postal_code,emp_contact_home_phone,emp_contact_mobile,emp_contact_pager,emp_contact_email,emp_contact_notes FROM add_new_employee WHERE emp_id='$emp_id'";
$qryexecute=mysqli_query($db, $qry);
$rs=mysql_fetch_row($qryexecute);
//-----Assigning to the variable(the returned attribute's values)-------//
$emp_contact_address1=$rs[0];
$emp_contact_address2=$rs[1];
$emp_contact_city=$rs[2];
$emp_contact_district=$rs[3];
$emp_contact_postal_code=$rs[4];
$emp_contact_home_phone=$rs[5];
$emp_contact_mobile=$rs[6];
$emp_contact_pager=$rs[7];
$emp_contact_email=$rs[8];
$emp_contact_notes=$rs[9];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Edit Employee - Contact Information Entry Form</title>

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

//------------------For Close Button------------//
function goClose()
{
location.href="EmployeeManagment.php"
}
</script>


</script>

</head>

<body>
<center>
<form id="form1" name="form1" method="post" action="EditNewEmployeeContactMedium.php">
<br />
  <table width="692" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
    <tr bgcolor="#33CC33">
      <td colspan="6" bgcolor="#33CC33">Address</td>
    </tr>
    <tr>
      <td width="82">Address 1: </td>
      <td colspan="5"><label>
        <input name="txtContactAddress1" type="text" id="txtContactAddress1" size="100" value="<?php echo"$emp_contact_address1"; ?>"/>
      </label></td>
    </tr>
    
    <tr>
      <td>Address 2: </td>
      <td colspan="5"><input name="txtContactAddress2" type="text" id="txtContactAddress2" value="<?php echo"$emp_contact_address2"; ?>" size="100"/></td>
    </tr>
    
    <tr>
      <td>City : </td>
      <td width="144"><input name="txtContactCity" type="text" id="txtContactCity" value="<?php echo"$emp_contact_city"; ?>" /></td>
      <td width="68">District:</td>
      <td width="155"><input name="txtContactState" type="text" id="txtContactState" value="<?php echo"$emp_contact_district"; ?>" /></td>
      <td width="84">Postal Code: </td>
      <td width="159"><input name="txtContactPostal" type="text" id="txtContactPostal" value="<?php echo"$emp_contact_postal_code"; ?>" size="24" /></td>
    </tr>
	<tr>
      <td>&nbsp;</td>
      <td width="144">&nbsp;</td>
      <td width="68">&nbsp;</td>
      <td width="155">&nbsp;</td>
      <td width="84">&nbsp;</td>
      <td width="159">&nbsp;</td>
	</tr>
  </table>
  <br />
  <table width="692" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
    <tr bgcolor="#33CC33">
      <td colspan="4">Phone Numbers / E-mail </td>
    </tr>
    <tr>
      <td width="48">Home:</td>
      <td width="161"><input name="txtContactHomePhone" type="text" id="txtContactHomePhone" value="<?php echo"$emp_contact_home_phone"; ?>" /></td>
      <td width="123">Pager:</td>
      <td width="404"><input name="txtContactPager" type="text" id="txtContactPager" value="<?php echo"$emp_contact_pager"; ?>" size="30"/></td>
    </tr>
    <tr>
      <td>Cell</td>
      <td><input name="txtContactMobile" type="text" id="txtContactMobile" value="<?php echo"$emp_contact_mobile"; ?>" /></td>
      <td>E-mail:</td>
      <td><input name="txtContactEmail" type="text" id="txtContactEmail" value="<?php echo"$emp_contact_email"; ?>" size="30"/></td>
    </tr>
	<tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
	</tr>
  </table>
  <br />
  <table width="692" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
    <tr>
      <td bgcolor="#33CC33">Notes</td>
    </tr>
    <tr>
      <td><label>
        <center><textarea name="txtContactNotes" cols="82.5" rows="3" id="txtContactNotes"><?php echo"$emp_contact_notes"; ?></textarea>
        </center>
      </label></td>
    </tr>
  </table>
  <br />  
  <table width="692" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
    <tr bgcolor="#33CC33">
      <td width="231" bgcolor="#33CC33"><label>
        <center><input name="contactSave" type="button" id="contactSave" value="        Save        " onclick="doFinish(form1)"/>
        </center>
      </label></td>
      <td width="295">
	 <center> <input name="contactClose" type="button" id="contactClose" value="         Close         " onclick="goClose()"/>
	 </center>
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

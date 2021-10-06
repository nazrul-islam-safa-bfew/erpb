<?php
include("common.php");
CreateConnection();
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Employee E-mail AddressManagment Screen</title>

<script language="javascript">

//---------------For Add Button-----------------//
function goAdd()
{
document.form1.hidField.value=1;
document.form1.submit();
}

//----------------For Rows Double Click Event to Edit records....
function goEditDelete(m)
{
document.form1.hidEmail_id.value=m;
//alert(m);
document.form1.hidField.value=2;
document.form1.submit();
}

</script>

<link href="common.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form id="form1" name="form1" method="post" action="EmployeeEmailManagment_Medium.php">
  <p>
  <input name="hidField" type="hidden" id="hidField" />
  <input name="hidEmail_id" type="hidden" id="hidEmail_id" />
  </p>
  <table width="300" border="1" cellpadding="0" cellspacing="0" >
    <tr bgcolor="#0099CC">
      <td width="53">Serial No </td>
      <td width="115">Employee id </td>
      <td width="124" colspan="2"><div align="center">Employee E-mail Addresses </div></td>
    </tr>
    
    								
									<?php
											//Fetching records from the add_new_employee_email_address table
											$qry="SELECT emp_id,emp_mail_address FROM add_new_employee_email_address";
											$qryexecute=mysqli_query($db, $qry);

											//--Counting number of records return by the above query---//
											$count=mysql_num_rows($qryexecute);
											//dislay record as table rows//
											
											//initialize serial number...
											   $serial=1;
											while($rs=mysql_fetch_row($qryexecute))
											{
												$emp_identification=$rs[0];
												$emp_mail_address=$rs[1];
												
												echo"<tr ondblclick=goEditDelete('$emp_mail_address')>
													<td>$serial</td>
													<td>$emp_identification</td>
													<td>$emp_mail_address</td>
													</tr>";
													$serial=$serial+1;
											}		
										
									?>
	
                                    <tr>
                                      <td>&nbsp;</td>
                                      <td>&nbsp;</td>
                                      <td colspan="2">&nbsp;</td>
                                    </tr>
    <tr>
      <td colspan="4" bgcolor="#0099CC"><?php echo"$count Items Listed"; ?></td>
    </tr>
  </table>
  <br />
  <table width="300" border="0" cellpadding="0" cellspacing="0" bgcolor="#FF6633">
    <tr bgcolor="#0099CC">
      <td width="143">
	  <center>
	  <input name="add" type="button" id="add" onclick="goAdd()" value="Add Email Address"/>
	  <center>	  </td>
      <td width="157">
	  <center><input name="close" type="submit" id="close" value="    Close    " onclick="javascript:window.close()"/></center>	  </td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</form>
</body>
</html>

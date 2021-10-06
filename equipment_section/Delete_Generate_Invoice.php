<?php
include("common.php");
CreateConnection();
//assigning posted hidden value to the variable to track delete event
$hid=$_POST['hidField'];
if($hid==1)
{
//assigning posted invoice number to the variable  which needs to be deleted
$inv_num=$_POST['select_Invoice_num'];
//Start Transaction
mysqli_query($db, "BEGin;");
//query to delete data from the invoice_main table...
$qry1="DELETE FROM invoice_main WHERE invoice_num='$inv_num'";
$qryexecute1=mysqli_query($db, $qry1);
//query to delete data from the invoice_sub table...
$qry2="DELETE FROM invoice_sub WHERE invoice_num='$inv_num'";
$qryexecute2=mysqli_query($db, $qry2);
mysqli_query($db, "COMMIT;");
//End Transaction

//check wheather the queryis successful or not...
if($qryexecute1)
{
header("Location: BrowseInvoice.php");
}
else
{
echo("Couln't Connect To the Database..");
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<script>
function goDelete()
{
if(confirm("Do You Want To Delete The Record?")==true)
{
document.form1.hidField.value=1;
document.form1.submit();
}
}
</script>
<style type="text/css">
<!--
body,td,th {
	font-family: Georgia, Times New Roman, Times, serif;
	font-size: 16px;
	color: #3300CC;
}
-->
</style></head>

<body>
<form id="form1" name="form1" method="post" action="">
  <p>
    <input name="hidField" type="hidden" id="hidField" />
  </p>
  <p>&nbsp;</p>
  <table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr bgcolor="#33CC33">
      <th bgcolor="#33CC33" scope="col"><div align="left">Delete Invoice </div></th>
      <td scope="col">&nbsp;</td>
    </tr>
    <tr bgcolor="#FF99FF">
      <td width="136" scope="col"><div align="left">Select Invoice</div></td>
      <td width="135" scope="col"><select name="select_Invoice_num" id="select_Invoice_num">
        <?php 
											//select invoice number from the invoice_main table...
											$qry="SELECT invoice_num FROM invoice_main";
											$qryexecute=mysqli_query($db, $qry);
											while($rs=mysql_fetch_row($qryexecute))
											{
												$inv_num=$rs[0];
										
										//..generating dynamic option value...//
												echo"<option value='$inv_num'>$inv_num</option>";
												
											}
										
										
										
										?>
      </select></td>
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
      <td><label>
        
        <center>  <input name="Bdelete" type="button" id="Bdelete" value="   Delete   " onclick="goDelete()"/></center>
      </label></td>
      <td>
          <input name="Bclose" type="button" id="Bclose" value="    Close    " onclick="javascript:location.href='BrowseInvoice.php'"/>
      </td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</form>
</body>
</html>

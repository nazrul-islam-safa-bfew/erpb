<?php  
include("common.php");
CreateConnection();
//DELETE RECORD....//
$hid=$_POST['hidField'];
if($hid==1)
{
//assign posted customer id which needs to be deleted...//
$customer_id=$_POST['select_Cust_id'];
$qry1="DELETE FROM customer_setup WHERE cust_id='$customer_id'";
$qryexecute1=mysqli_query($db, $qry1);
//GO TO THE BrowseCustomer.php page if the record is successfully deleted....
if($qryexecute1)
{
header("Location: BrowseCustomer.php");
}

}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Delete Customer Record</title>

<script language="javascript">
function goDelete()
{
document.form1.hidField.value=1;
}



</script>


<link href="common.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <p>
    <input name="hidField" type="hidden" id="hidField" />
  </p>
  <p>&nbsp;</p>
  <table width="470" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr bgcolor="#33CC33">
      <td width="233">Select Customer </td>
      <td width="567"><label>
		<select name="select_Cust_id" id="select_Cust_id">
										<?php
											//Show data from the  customer_setup table
											$qry="SELECT cust_id,cust_name FROM customer_setup";
											$qryexecute=mysqli_query($db, $qry);
											
											while($rs=mysql_fetch_row($qryexecute))
											{
											$cust_id=$rs[0];
											$cust_name=$rs[1];
											echo"<option value='$cust_id'>$cust_id -> $cust_name</option>";
											}
										
										?>

					
					
					
		</select>
      </label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#33CC33">
      <td><label>
        <center><input name="BDelete" type="submit" id="BDelete" value="    Delete    " onclick="goDelete()"/>
        </center>
      </label></td>
      <td>
	  <center><input name="Bclose" type="submit" id="Bclose" value="    Close    " />
	  </center>
	  </td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</form>
</body>
</html>

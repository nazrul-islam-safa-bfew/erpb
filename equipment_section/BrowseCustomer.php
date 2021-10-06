<?php  
include("common.php");
CreateConnection();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Customer Database Managment</title>

<script language="javascript">

//Editing the record..//
function goEdit(m)
{
//holds id of the customer which needs to be edited
document.form1.hid_cust_id.value=m;
document.form1.hidField.value=1;
document.form1.submit();
}


</script>
<link href="common.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form id="form1" name="form1" method="post" action="BrowseCustomer_Medium.php">
  <table width="2766" height="21" border="1" cellpadding="0" cellspacing="0">
    <tr bgcolor="#33CC33">
      <th width="66">ID</th>
      <th width="204">Name</th>
      <th width="231">Contact</th>
      <th width="319">Address #1 </th>
      <th width="296" bordercolor="#FF99FF">Address #2 </th>
      <th width="168">City</th>
      <th width="176">State/Province/Dist.</th>
      <th width="168">Zip</th>
      <th width="155">Country</th>
      <th width="152">Phone #1 </th>
      <th width="135">Mobile  #2 </th>
      <th width="139">Fax</th>
      <th width="214">E-mail</th>
      <th width="313">Comments</th>
    </tr>
	
										<?php 
											//Show data from the  customer_setup table
											$qry="SELECT * FROM customer_setup";
											$qryexecute=mysqli_query($db, $qry);
											
											//count number of record returned by the above query..
												$count=mysql_num_rows($qryexecute);

											while($rs=mysql_fetch_row($qryexecute))
											{
											$cust_id=$rs[0];
											$cust_name=$rs[1];
											$cust_contact=$rs[2];
											$cust_add1=$rs[3];
											$cust_add2=$rs[4];
											$cust_city=$rs[5];
											$cust_state=$rs[6];
											$cust_postal_code=$rs[7];
											$cust_country=$rs[8];
											$cust_phone=$rs[9];
											$cust_mobile=$rs[10];
											$cust_fax=$rs[11];
											$cust_Email=$rs[12];
											$cust_comment=$rs[13];
											
											//generating table row dynamically
											echo"<tr ondblclick='goEdit($cust_id)'>
											<td>$cust_id</td>
											<td>$cust_name</td>
											<td>$cust_contact</td>
											<td>$cust_add1</td>
											<td>$cust_add2</td>
											<td>$cust_city</td>
											<td>$cust_state</td>
											<td>$cust_postal_code</td>
											<td>$cust_country</td>
											<td>$cust_phone</td>
											<td>$cust_mobile</td>
											<td>$cust_fax</td>
											<td>$cust_Email</td>
											<td>$cust_comment</td>
											</tr>";
											}

										
										
										?>
  </table>
  <p>
    <input name="hidField" type="hidden" id="hidField" />
    <input name="hid_cust_id" type="hidden" id="hid_cust_id" />
  </p>
  <table width="2764" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
    
    <tr bgcolor="#33CC33">
      <th><?php echo("$count"); ?> Customers Listed</th>
      <th width="194"><input name="add" type="button" id="add" value="     Add     " onclick="javascript:location.href='AddNewCustomer.php'"/></th>
      <th width="181"><label>
        <input name="Bdelete" type="button" id="Bdelete" value="   Delete   " onclick="javascript:location.href='Delete_NewCustomer.php'"/>
      </label></th>
      <th width="176"><input name="Close" type="button" id="Close" value="     Close   " onclick="javascript:window.close()"/></th>
      <th width="179"><input name="Print" type="button" id="Print" value="    Print    " onclick="javascript:window.print()"/></th>
      <th width="1830" bgcolor="#33CC33">&nbsp;</th>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</form>
</body>
</html>

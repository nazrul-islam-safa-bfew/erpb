<?php
include("common.php");
CreateConnection();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Vendor Database Managment</title>
<script language="javascript">
//Editing Record
function goEdit(m)
{
location.href='VendorSetup_Edit.php?vend_id=' + m;
}
</script>
<style type="text/css">
<!--
@import url("common.css");
-->
</style>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="2499" height="22" border="1" cellpadding="0" cellspacing="0">
    <tr bgcolor="#0099CC">
      <th width="77" height="20" scope="col">Id</th>
      <th width="187" scope="col">Name</th>
      <th width="171" scope="col">Contact</th>
      <th width="348" scope="col">Address  </th>
      <th width="171" scope="col">City</th>
      <th width="191" scope="col">State/Provinance</th>
      <th width="123" scope="col">Zip</th>
      <th width="197" scope="col">Country</th>
      <th width="147" scope="col">Phone</th>
      <th width="183" scope="col">Mobile</th>
      <th width="205" scope="col">Fax</th>
      <th width="186" scope="col">E-mail</th>
      <th width="285" scope="col">Comment</th>
    </tr>
												
												<?php 
														//fetch vendor informations from vendor_setup table..
													$qry="SELECT * FROM vendor_setup";
													$qryexecute=mysqli_query($db, $qry);
													//count number of rows returned by the query...
													$count=mysql_num_rows($qryexecute);
													while($rs=mysql_fetch_row($qryexecute))
													{
														$vendor_id=$rs[0];
														$vendor_name=$rs[1];
														$vendor_contact=$rs[2];
														$vendor_address=$rs[3];
														$vendor_city=$rs[4];
														$vendor_state=$rs[5];
														$vendor_postal_code=$rs[6];
														$vendor_country=$rs[7];
														$vendor_phone=$rs[8];
														$vendor_mobile=$rs[9];
														$vendor_fax=$rs[10];
														$vendor_email=$rs[11];
														$vendor_comment=$rs[12];
													
													//highlighiting the edited record(Executed when a record was edited ....
															$vend_id=$_GET['vnd_id'];
															if($vendor_id==$vend_id)
															{
																	echo"<tr ondblclick=goEdit('$vendor_id') bgcolor=#FFFF00>
																			<td>$vendor_id</td>
																			<td>$vendor_name</td>
																			<td>$vendor_contact</td>
																			<td>$vendor_address</td>
																			<td>$vendor_city</td>
																			<td>$vendor_state</td>
																			<td>$vendor_postal_code</td>
																			<td>$vendor_country</td>
																			<td>$vendor_phone</td>
																			<td>$vendor_mobile</td>
																			<td>$vendor_fax</td>
																			<td>$vendor_email</td>
																			<td>$vendor_comment</td>
		
																	</tr>";

															
															}
															else
															{
															
														//generating table rows dynamically(Executed in normaal case..  
																echo"<tr ondblclick=goEdit('$vendor_id')>
																			<td>$vendor_id</td>
																			<td>$vendor_name</td>
																			<td>$vendor_contact</td>
																			<td>$vendor_address</td>
																			<td>$vendor_city</td>
																			<td>$vendor_state</td>
																			<td>$vendor_postal_code</td>
																			<td>$vendor_country</td>
																			<td>$vendor_phone</td>
																			<td>$vendor_mobile</td>
																			<td>$vendor_fax</td>
																			<td>$vendor_email</td>
																			<td>$vendor_comment</td>
		
																	</tr>";
															}

													}
												
												
												?>
	
  </table>
  <p>&nbsp;</p>
  <table width="800" border="1" cellpadding="0" cellspacing="0" bgcolor="#33CC33">
    <tr bgcolor="#0099CC">
      <th width="172" scope="col"><?php echo $count; ?> Vendors Listed </th>
      <th width="133" scope="col"><label>
        <input name="Badd" type="button" id="Badd" value="   Add..." onclick="javascript:location.href='VendorSetup.php'"/>
      </label></th>
      <th width="156" scope="col"><input name="Bclose" type="button" id="Bclose" value="   Close..." onclick="javascript:window.close()"/></th>
      <th width="158" scope="col"><input name="Bprint" type="button" id="Bprint" value="   Print...   " onclick="javascript:window.print()"/></th>
      <th width="169" scope="col"><input name="Bsearch" type="button" id="Bsearch" value="   Search..." /></th>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</form>
</body>
</html>

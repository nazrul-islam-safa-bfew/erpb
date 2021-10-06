<?php
include("common.php");
CreateConnection();
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Shipping Methods Database  Managment</title>

<script language="javascript">
function goEditDelete(m)
{
//alert(n);
location.href='Edit_Delete_ShippingMethod.php?m_serial=' + m;
}
</script>

<link href="common.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
//this value is used to track the method type that is being deleted..
$method_name=$_GET['type'];
 ?>
<form id="form1" name="form1" method="post" action="">
  <p>&nbsp;</p>
  <table width="300" border="1" cellpadding="0" cellspacing="0">
    <tr>
      <td width="294" colspan="2" bgcolor="#0099CC"><div align="center">Shipping Method Type </div></td>
    </tr>
    
    								
									<?php
											//Fetching records from the shipping_method table
											$qry="SELECT serial_no,method_type FROM shipping_method";
											$qryexecute=mysqli_query($db, $qry);

											//--Counting number of records return by the above query---//
											$count=mysql_num_rows($qryexecute);
											
											//dislay record as table rows//
											while($rs=mysql_fetch_row($qryexecute))
											{
												$serial_no=$rs[0];
												$method_type=$rs[1];
												
												//highlighting edited record..
												if($serial_no==$method_name)
												{
													echo"<tr bgcolor='#FFFF00' ondblclick=goEditDelete($serial_no)>
													<td>$method_type</td>
													</tr>";
												}
												else
												{
													echo"<tr ondblclick=goEditDelete($serial_no)>
													<td>$method_type</td>
													</tr>";
												}
											}		
										
									?>
	
<tr>
      <td colspan="2" bgcolor="#0099CC"><?php echo"$count Items Listed"; ?></td>
    </tr>
  </table>
  <br />
  <table width="300" border="0" cellpadding="0" cellspacing="0" bgcolor="#0099CC">
    <tr>
      <td width="143">
	  <center>
	  <input name="type" type="button" id="type" onclick="javascript:location.href='Add_shipping_method.php'" value="Add Type"/>
	  <center>
	  </td>
      <td width="157">
	  <center><input name="close" type="button" id="close" value="    Close    " onclick="javascript:window.close()"/>
	  </center>
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

<?php 
include("common.php");
CreateConnection();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="common.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style11 {font-size: 16px; font-weight: bold; }
-->
</style>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="3000" border="1" cellspacing="0" cellpadding="0">
    
    <tr bgcolor="#0099CC">
      <td width="242" scope="col"><span class="style11">Make</span></td>
      <td width="165" scope="col"><span class="style11">Model</span></td>
      <td width="199" scope="col"><span class="style11">Serial</span></td>
      <td width="177" scope="col"><span class="style11">Size</span></td>
      <td width="253" scope="col"><span class="style11">Tread</span></td>
      <td width="263" scope="col"><span class="style11">Load</span></td>
      <td width="248" scope="col"><span class="style11">Traction</span></td>
      <td width="191" scope="col"><span class="style11">Vendor</span></td>
      <td width="153" scope="col"><span class="style11">Invoice</span></td>
      <td width="141" scope="col"><span class="style11">Price (Tk.) </span></td>
      <td width="125" scope="col"><span class="style11">Date Purchased </span></td>
      <td width="317" scope="col"><span class="style11">Notes</span></td>
      <td width="124" scope="col"><span class="style11">Under Warrenty? </span></td>
      <td width="129" scope="col"><span class="style11">Warr Date </span></td>
      <td width="152" scope="col"><span class="style11">Warr Meter </span></td>
      <td width="121" scope="col"><span class="style11">Type</span></td>
    </tr>
													<?php 
													//fetching rows dynamically from the tire_inventory table to show tire records
													$qry="SELECT serial_no, make, model, size, tread, transaction, tire_load, type, vendor_id, invoice, price, purchase_date, under_warrenty, warrenty_day, warrenty_meter, notes FROM tire_inventory";
													$qryexecute=mysqli_query($db, $qry);
													while($rs=mysql_fetch_row($qryexecute))
													{
														$serial_no=$rs[0];
														$make=$rs[1];
														$model=$rs[2];
														$size=$rs[3];
														$tread=$rs[4];
														$transaction=$rs[5];
														$tire_load=$rs[6];
														$type=$rs[7];
														$vendor_id=$rs[8];
														$invoice=$rs[9];
														$price=$rs[10];
														$purchase_date=$rs[11];
														$under_warrenty=$rs[12];
														$warrenty_day=$rs[13];
														$warrenty_meter=$rs[14];
														$notes=$rs[15];
														
														//retreiving vendor name acoording to the vendor_id...
														$qry1="SELECT vendor_name FROM vendor_setup WHERE vendor_id='$vendor_id'";
														$qryexecute1=mysqli_query($db, $qry1);
														$rs1=mysql_fetch_row($qryexecute1);
														$vendor_name=$rs1[0];
														
										//check wheather the purchase date is blank or not and then format it in D-M-Y format ...
														if($purchase_date=="0000-00-00")
															{
																 $formatted_purchase_date="";
															}
														else
															{
																	$dates = array($purchase_date);
																foreach ($dates as $timestamp) {
																  $formatted_purchase_date = explode("-",$timestamp);
																}
															}
															

															
															//formatting price..
															$formatted_price=number_format($price);
															
														//check wheather tire is under warrenty or not...
															if($under_warrenty==1)
															{
																$under_warrenty="Yes";
															}
															else
															{
																$under_warrenty="No";
															}

														echo"<tr>
																<td>$make</td>
																<td>$model</td>
																<td>$serial_no</td>
																<td>$size</td>
																<td>$tread</td>
																<td>$tire_load</td>
																<td>$transaction</td>
																<td>$vendor_name</td>
																<td>$invoice</td>
																<td>$formatted_price</td>
																<td>$formatted_purchase_date[2]-$formatted_purchase_date[1]-$formatted_purchase_date[0]</td>
																<td>$notes</td>
																<td>$under_warrenty</td>
																<td>$warrenty_day</td>
																<td>$warrenty_meter</td>
																<td>$type</td>
															</tr>";
													}
													
													?>
										
	
	
    <tr>
      <td colspan="16" scope="col">&nbsp;</td>
    </tr>
    <tr bgcolor="#0099CC">
      <th scope="col"><div align="left">Item Listed </div></th>
      <th scope="col"><label>
        <input type="button" name="Button" value="   Add   " onclick="javascript:location.href='Tire_Inventory_Tire_Add.php'"/>
      </label></th>
      <th scope="col"><input name="Bclose" type="button" id="Bclose" value="   Close   " onclick="javascript:window.close()"/></th>
      <th scope="col"><input name="Bprint" type="button" id="Bprint" value="   Print   " onclick="javascript:window.print()"/></th>
      <th scope="col"><input name="BFilter" type="button" id="BFilter" value="   Filter   " /></th>
      <th scope="col"><input name="Bsearch" type="button" id="Bsearch" value="  Search  " /></th>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
  </tr>  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</form>
</body>
</html>

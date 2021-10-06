<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Parts Inventory Managment</title>

<script language="javascript">

//-------------------------------Tracking Table Row's onClick Event----------------------

function goClick(m)
{
document.form1.hidPartid.value=m;
document.form1.hidField.value=4;
document.form1.submit();
//alert(m);
}


/*//---------------------------------Tracking Buttons ON CLICK event--------------------------------
function goAdd()
{
document.form1.hidField.value=1;
}



function goDelete()
{
document.form1.hidField.value=3;
}


function goPrint()
{
window.print();
}
*/

</script>


<link href="common.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form id="form1" name="form1" method="post" action="PartsInventoryMedium.php">
  <input name="hidField" type="hidden" id="hidField" />
  <input name="hidPartid" type="hidden" id="hidPartid" />

  <table width="2500" border="1" cellpadding="0" cellspacing="0">
    
    <tr bgcolor="#33CC33">
      <th width="153" height="20">Part#</th>
      <th width="214">Name</th>
      <th width="297">Description</th>
      <th width="269">Manufacturer</th>
      <th width="235">Vendor</th>
      <th width="187">Category</th>
      <th width="145">Unit Cost </th>
      <th width="173">Warrenty(Years)</th>
      <th width="237">UPC</th>
      <th width="243">Location Stored </th>
      <th width="158">Bin#</th>
      <th width="163">LoactionAssign</th>
    </tr>
    
							
							<?php 
							 
								include("common.php");
								CreateConnection();
								
								$part_select="SELECT part_number, part_name, part_desc, part_manufacturer, vendor, part_category, part_unit_cost, unit_type, part_warranty, upc, location_stored, bin, location_assign FROM parts_inventory";
							
							$qryexecute=mysqli_query($db, $part_select);
							//cout number of rows selected by the query..
							$count=mysql_num_rows($qryexecute);
							
							while($rs=mysql_fetch_row($qryexecute))
							{
								$part_no=$rs[0];
								$part_name=$rs[1];
								$part_desc=$rs[2];
								$part_manufacturer=$rs[3];
								$vendor=$rs[4];
								$part_category=$rs[5];
								$part_unit_cost=$rs[6];
								$unit_type=$rs[7];
								$part_warranty=$rs[8];
								$upc=$rs[9];
								$location_stored=$rs[10];
								$bin=$rs[11];
								$location_assign=$rs[12];
								
								$rs="SELECT vendor_name FROM vendor_setup WHERE vendor_id='$vendor'";
								$rsexecute=mysqli_query($db, $rs);
								while($vendname=mysql_fetch_row($rsexecute))
								{
									$name=$vendname[0];
								
								}
									
																	
								//highlighiting the edited record(Executed when a record was edited ....)
										$part_number=$_GET['part_num'];
										
									if($part_no==$part_number)
										{
											
												echo"<tr ondblclick=goClick('$part_no') bgcolor=#FFFF00>
												
													<td>$part_no</td>
													<td>$part_name</td>
													<td>$part_desc</td>
													<td>$part_manufacturer</td>
													<td>$name</td>
													<td>$part_category</td>
													<td>$part_unit_cost Tk. per $unit_type </td>
													<td>$part_warranty</td>
													<td>$upc</td>
													<td>$location_stored</td>
													<td>$bin</td>
													<td>$location_assign</td>
													</tr>";
										}
									else
										{
									//generating table rows dynamically(Executed in normaal case..  										
												echo"<tr ondblclick=goClick('$part_no')>
													<td>$part_no</td>
													<td>$part_name</td>
													<td>$part_desc</td>
													<td>$part_manufacturer</td>
													<td>$name</td>
													<td>$part_category</td>
													<td>$part_unit_cost Tk. per $unit_type </td>
													<td>$part_warranty</td>
													<td>$upc</td>
													<td>$location_stored</td>
													<td>$bin</td>
													<td>$location_assign</td>
													</tr>";

										}	
								
								}
							
							
							?>
  </table>
  <p>&nbsp;</p>
  <table width="800" border="1" cellpadding="0" cellspacing="0" bgcolor="#33CC33">
    <tr>
      <th width="135" scope="col"><?php echo $count; ?> Parts Listed </th>
      <th width="115" scope="col"><label>
      <input name="add" type="button" id="add" accesskey="A" value="    Add    " onclick="javascript:location.href='AddInventoryPart.php'" />
      </label></th>
      <th width="128" scope="col"><input name="Bclose" type="button" id="Bclose" value="   Close..." onclick="javascript:window.close()"/></th>
      <th width="129" scope="col"><input name="Bprint" type="button" id="Bprint" value="   Print...   " onclick="javascript:window.print()"/></th>
      <th width="136" scope="col"><input name="Bsearch" type="button" id="Bsearch" value="   Search..." /></th>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
</body>
</html>

<?php 
include("common.php");
CreateConnection();
//retreive session value to chech the selected vale of selectEquipment and work_order_id
session_start();
$work_order_id=$_SESSION['workorder_id'];
$equip_id=$_SESSION['equip_id'];

//-------------------------Fetching equipments id+Description---------------------------------------------------------//
//select itm_track_id from the new_work_order_main table which is defined as item_id in the table
$qry="SELECT item_id FROM new_work_order_main WHERE work_order_id='$work_order_id'";
$qry_execute = mysqli_query($db, $qry);
$rs=mysql_fetch_row($qry_execute);	
$itm_trk_id=$rs[0];	
//select itemCode,items description from add_equipment_maintenance table...corresponds to the 	itm_track_id											
$rs="SELECT itemCode,teqSpec FROM equipment WHERE eqid='$itm_trk_id'";
$result = mysqli_query($db, $rs);
$name_row = mysql_fetch_row($result);
$item_id=$name_row[0];
$rs_des=$rs_return[0];
//---------------------------------END----------------------------------------------------------------------------------//

//--------------------------fetching eqipment information from new_work_order_main table
$qry_equipinfo_all="SELECT issued_date, closed_date, equipment_meter, work_order_status, vendor, assigned_to, purchase_order, invoice, pm_cost, repair_cost, parts_cost, labor_cost, external_service_cost, udf_cost, sub_total, discount_amt, pre_tax_amt, tax_amt, grand_total, work_order_comment from new_work_order_main where work_order_id='$work_order_id'";
$qry_execute_equipinfo_all=mysqli_query($db, $qry_equipinfo_all);
$rs=mysql_fetch_row($qry_execute_equipinfo_all);
$issued_date=$rs[0];
$closed_date=$rs[1];
$equipment_meter=$rs[2];
$work_order_status=$rs[3];
$vendor=$rs[4];
$assigned_to=$rs[5];
$purchase_order=$rs[6];
$invoice=$rs[7];
$pm_cost=$rs[8];
$repair_cost=$rs[9];
$parts_cost=$rs[10];
$labor_cost=$rs[11];
$external_service_cost=$rs[12];
$udf_cost=$rs[13];
$sub_total=$rs[14];
$discount_amt=$rs[15];
$pre_tax_amt=$rs[16];
$tax_amt=$rs[17];
$grand_total=$rs[18];
$work_order_comment=$rs[19];
/*//retreive vendor name from the vendor_setup table based on vendor_id value
$rs_vend="SELECT item_id FROM add_equipment_maintenance WHERE itm_track_id='$itm_trk_id'";
$ven_result = mysqli_query($db, $rs_vend);
$vend_row = mysql_fetch_row($ven_result);
$vend_name=$vend_row[0];*/
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Work Order (#<?php echo"$work_order_id"; ?>) Issue Form</title>
<style type="text/css">
<!--
@import url("common.css");
.style4 {font-size: 16; font-weight: bold; }
-->
</style>
<link href="common.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style5 {
	font-size: 16px;
	font-weight: bold;
}
.style7 {font-size: 18px; font-weight: bold; }
-->
</style>
<script language="javascript">
function doprint()
{
window.print();
window.close();
}
</script>

</head>

<body onbeforeunload="javascript:well()">
<?php
//retreive session value to chech the selected vale of selectEquipment and work_order_id
session_start();
$work_order_id=$_SESSION['workorder_id'];
$equip_id=$_SESSION['equip_id'];
//echo("$work_order_id<br>");
//echo("$equip_id");


//fetch meter reading and meter type from the track_equipments table based on the selected equipment_id for tracking the equipments status
$rs="SELECT item_curr_kilometer,item_meter_type FROM track_equipments WHERE itm_track_id='$equip_id'";
$result = mysqli_query($db, $rs);
$rs_result=mysql_fetch_row($result);
$rs_item_meter=$rs_result[0];
$item_meter_type=$rs_result[1];
?>
<form id="form1" name="form1" method="post" action="NewWorkOrderMedium.php">
    <input name="hidField" type="hidden" id="hidField" />
      <input name="hidEquipment" type="hidden" id="hidEquipment" />
  <table width="767" border="0" align="center" cellpadding="0" cellspacing="2">
    <tr bgcolor="#33CC33">
      <td colspan="2" bgcolor="#33CC33"><span class="style7">New Work Order</span> - #<?php echo"$work_order_id"; ?> </td>
      <td colspan="2"><div align="center" class="style4">Total</div></td>
    </tr>
    
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="140"><span class="style4">Equipment:</span></td>
      <td width="376"><?php echo("$item_id - $rs_des") ?></td>
      <td width="105"><span class="style4">PM Task : </span></td>
      <td width="146"><?php echo(number_format("$pm_cost",2)); ?> Tk.</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><span class="style4">Repairs :</span></td>
      <td> <?php echo(number_format($repair_cost,2)); ?> Tk.</td>
    </tr>
    <tr>
      <td class="style4">WO #: </td>
      <td><?php echo"$work_order_id"; ?></td>
      <td><span class="style4">Ext Services : </span></td>
      <td> <?php echo(number_format($external_service_cost,2)); ?> Tk.</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><span class="style4">UDF Cost : </span></td>
      <td>      <?php echo(number_format($udf_cost,2)); ?>Tk.</td>
    </tr>
    <tr>
      <td class="style4">Date Issued </td>
      <td><?php echo"$issued_date"; ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><span class="style4">Subtotal</span></td>
      <td>      <?php echo(number_format($sub_total,2)); ?>Tk.</td>
    </tr>
    <tr>
      <td><label><?php echo"$item_meter_type"; ?></label></td>
      <td><?php echo"$equipment_meter"; ?></td>
      <td><span class="style4">Discount Amt: </span></td>
      <td>      <?php echo(number_format($discount_amt)); ?>Tk.</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="style4">Status:</td>
      <td><?php echo"$work_order_id"; ?></td>
      <td><span class="style4">Pre-tax Amt: </span></td>
      <td>      <?php echo(number_format($pre_tax_amt,2)); ?>Tk.</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><span class="style4">Taxes</span></td>
      <td>      <?php echo(number_format($tax_amt,2)); ?>Tk.</td>
    </tr>
    <tr>
      <td class="style4">Date Complete </td>
      <td><a href="javascript:NewCal('txt_complete','yyyymmdd','true',12)"><?php echo"$closed_date"; ?></a></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><span class="style4">Total Cost </span></td>
      <td>      <?php echo(number_format($grand_total,2)); ?>Tk.</td>
    </tr>
  </table>
  <br />
   <table width="767" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr bgcolor="#999999">
      <td colspan="2"><span class="style5">Preventive Miantenance </span></td>
      <td width="198">&nbsp;</td>
    </tr>
    <tr bgcolor="#CCCCCC" class="style4">
      <td width="172">Date </td>
      <td width="387">PM Service </td>
      <td><div align="right">Cost(TK.)</div></td>
    </tr>
    
								<?php 
								//---Fetchimg Records Form the new_work_order_parts_info table---//
								
										
												
												CreateConnection();
												$qry="SELECT pm_service_id,pm_date,total_cost FROM new_work_order_parts_info WHERE work_order_id='$work_order_id'";
												
												
												$qryexecute=mysqli_query($db, $qry);
							
							while($rs=mysql_fetch_row($qryexecute))
							{
								$pm_service_id=$rs[0];
								$pm_date=$rs[1];
								$total_cost1=$rs[2];
								//formatting cost in currency
								$total_cost=number_format($total_cost1,2);
								//...Query to retreive Pm service Name based on pm_service_id from add_pm_service table...
								
								$qry1="SELECT pm_service_name FROM add_pm_service WHERE pm_service_id='$pm_service_id'";
								$qryexecute1=mysqli_query($db, $qry1);
								$pm_service_name=mysql_result($qryexecute1,0,0);
																								
								echo"<tr>
								
									<td>$pm_date</td>
									<td>$pm_service_name</td>
									<td align='right'>$total_cost</td>
									</tr>";
								
								}
							


											?>
	
    <tr>
      <td height="20"><label></label></td>
      <td><div align="right"><strong>Total</strong></div></td>
      <td><div align="right"><?php echo(number_format("$pm_cost",2)); ?>    </div></td>
    </tr>
  </table>
   <br />
   <table width="767" border="1" align="center" cellpadding="0" cellspacing="0">
     <tr bgcolor="#999999" class="style5">
       <td width="172">Repairs</td>
       <td width="387">&nbsp;</td>
       <td width="198">&nbsp;</td>
     </tr>
     <tr bgcolor="#CCCCCC" class="style4">
       <td>Date </td>
       <td>Repair</td>
       <td><div align="right">Cost(TK.)</div></td>
     </tr>
     
	 										<?php 
								//---Fetchimg Records Form the new_work_order_repairs_info table---//
								
										
												
												CreateConnection();
												$qry="SELECT repair_type,pm_date,total_cost FROM new_work_order_repairs_info WHERE work_order_id='$work_order_id'";
												
												
												$qryexecute=mysqli_query($db, $qry);
							
							while($rs=mysql_fetch_row($qryexecute))
							{
								$repair_type=$rs[0];
								$pm_date=$rs[1];
								$total_cost1=$rs[2];
								//formatting totalcost1 into currency
								$total_cost=number_format($total_cost1,2);
																															
								echo"<tr>
								
									<td>$pm_date</td>
									<td>$repair_type</td>
									<td align='right'>$total_cost</td>
									</tr>";
								
								}
							


											?>

	 
     <tr>
       <td><label></label></td>
       <td><div align="right"><strong>Total</strong></div></td>
       <td>
           <label>
           <div align="right">
				<?php echo(number_format($repair_cost,2)); ?>
         </div>
         </label></td>
     </tr>
  </table>
   <br />
   <table width="767" border="1" align="center" cellpadding="0" cellspacing="0">
     <tr bgcolor="#999999" class="style5">
       <td width="238">Parts Used </td>
       <td width="137">&nbsp;</td>
       <td width="137">&nbsp;</td>
       <td width="137">&nbsp;</td>
       <td width="137">&nbsp;</td>
     </tr>
     <tr bgcolor="#CCCCCC" class="style4">
       <td>Part</td>
       <td>Name</td>
       <td>Used</td>
       <td>Cost</td>
       <td><div align="right">Extended(TK.)</div></td>
     </tr>
	 
	 											<?php 
								//---Fetchimg Records Form the new_work_order_part_used table---//
								
								//Rendering Session Values...............
								session_start();
								$work_order_id=$_SESSION['workorder_id'];
								
												
												CreateConnection();
												$qry="SELECT part_num,part_name,part_quantity,part_unit_cost,part_extended_cost FROM new_work_order_part_used WHERE work_order_id='$work_order_id'";
												
												
												$qryexecute=mysqli_query($db, $qry);
							
							while($rs=mysql_fetch_row($qryexecute))
							{
								$part_num=$rs[0];
								$part_name=$rs[1];
								$part_quantity=$rs[2];
								$part_unit_cost=$rs[3];
								$part_extended_cost_pm1=$rs[4];
								//formatting part_extended_cost1
								$part_extended_cost_pm=number_format($part_extended_cost_pm1,2);
								
								echo"<tr>
								
									<td>$part_num</td>
									<td>$part_name</td>
									<td>$part_quantity</td>
									<td>$part_unit_cost</td>
									<td align='right'>$part_extended_cost_pm</td>
									</tr>";
								
								}
							


											?>
											
											
											
													<?php 
								//---Fetchimg Records Form the new_work_order_repair_parts_used table---//
								
								//Rendering Session Values...............
								session_start();
								$work_order_id=$_SESSION['workorder_id'];
								
												
												CreateConnection();
												$qry="SELECT part_num,part_name,part_quantity,part_unit_cost,part_extended_cost FROM new_work_order_repair_parts_used WHERE work_order_id='$work_order_id'";
												
												
												$qryexecute=mysqli_query($db, $qry);
							
							while($rs=mysql_fetch_row($qryexecute))
							{
								$part_num=$rs[0];
								$part_name=$rs[1];
								$part_quantity=$rs[2];
								$part_unit_cost=$rs[3];
								$part_extended_cost_labor1=$rs[4];
								//formatting part_extended_cost1
								$part_extended_cost_labor=number_format($part_extended_cost_labor1,2);
																																
								echo"<tr>
								
									<td>$part_num</td>
									<td>$part_name</td>
									<td>$part_quantity</td>
									<td>$part_unit_cost</td>
									<td align='right'>$part_extended_cost_labor</td>
									</tr>";
								
								}
							


											?>

	 
	 
     <tr>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td><div align="right"><strong>Total</strong></div></td>
       <td>
	   						
	   
	   <label>
         
        <div align="right">
			<?php echo(number_format($parts_cost,2));  ?>
		</div>
	   </label></td>
     </tr>
	 
  </table>
   <br />
   <table width="767" border="1" align="center" cellpadding="0" cellspacing="0">
     <tr bgcolor="#999999" class="style5">
       <td width="144">Labor Details </td>
       <td width="217">&nbsp;</td>
       <td width="135">&nbsp;</td>
       <td width="130">&nbsp;</td>
       <td width="139">&nbsp;</td>
     </tr>
     <tr bgcolor="#CCCCCC" class="style4">
       <td>Technician</td>
       <td>Description of Work </td>
       <td>Rate</td>
       <td>Hours</td>
       <td><div align="right">Extended(TK.)</div></td>
     </tr>
	 									
											<?php 
								//---Fetchimg Records Form the new_work_order_pm_labor_used(For-PM Task) table---//

												CreateConnection();
												$qry="SELECT emp_id,desc_of_work,emp_labor_rate,work_hour,lobor_cost FROM new_work_order_pm_labor_used WHERE work_order_id='$work_order_id'";
												
												
												$qryexecute=mysqli_query($db, $qry);
							
							while($rs=mysql_fetch_row($qryexecute))
							{
								$emp_id=$rs[0];
								$desc_of_work=$rs[1];
								$emp_labor_rate=$rs[2];
								$work_hour=$rs[3];
								$lobor_cost1=$rs[4];
								//formatting labor cost...
								$lobor_cost_pm=number_format($lobor_cost1,2);
								
								//retreiving employee name from add_new_employee table based on $emp_Name value
								$qry1="SELECT name FROM employee WHERE empId='$emp_id'";
								$qryexecute1=mysqli_query($db, $qry1);
								$employe_name=mysql_result($qryexecute1,0,0);
																								
								echo"<tr>
								
									<td>$employe_name</td>
									<td>$desc_of_work</td>
									<td>$emp_labor_rate</td>
									<td>$work_hour</td>
									<td align='right'>$lobor_cost_pm</td>
									</tr>";
								
								}
							


											?>



												 									
											<?php 
								//---Fetchimg Records Form the new_work_order_repair_labor_used(For-Repair Task) table---//

												CreateConnection();
												$qry="SELECT emp_id,desc_of_work,emp_labor_rate,work_hour,lobor_cost FROM new_work_order_repair_labor_used WHERE work_order_id='$work_order_id'";
												
												
												$qryexecute=mysqli_query($db, $qry);
							
							while($rs=mysql_fetch_row($qryexecute))
							{
								$emp_id=$rs[0];
								$desc_of_work=$rs[1];
								$emp_labor_rate=$rs[2];
								$work_hour=$rs[3];
								$lobor_cost1=$rs[4];
								
								//formatting labor cost...
								$lobor_cost_repair=number_format($lobor_cost1,2);
								//retreiving employee name from add_new_employee table based on $emp_Name value
								$qry1="SELECT name FROM employee WHERE empId='$emp_id'";
								$qryexecute1=mysqli_query($db, $qry1);
								$employe_name=mysql_result($qryexecute1,0,0);
																								
								echo"<tr>
								
									<td>$employe_name</td>
									<td>$desc_of_work</td>
									<td>$emp_labor_rate</td>
									<td>$work_hour</td>
									<td align='right'>$lobor_cost_repair</td>
									</tr>";
								
								}
							


											?>

											
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td><div align="right"><strong>Total</strong></div></td>
       <td><div align="right">
			<?php echo(number_format($labor_cost,2));  ?>
       </div></td>
     </tr>
	 
  </table>
   <br />
   <table width="767" border="1" align="center" cellpadding="0" cellspacing="0">
     <tr bgcolor="#999999" class="style5">
       <td width="238">External Services  </td>
       <td width="137">&nbsp;</td>
       <td width="137">&nbsp;</td>
       <td width="137">&nbsp;</td>
     </tr>
     <tr bgcolor="#CCCCCC" class="style4">
       <td>Date</td>
       <td>Vendor</td>
       <td>Description</td>
       <td><div align="right">Cost(TK.)</div></td>
     </tr>
     
	 
	 								<?php
								//---Fetchimg Records Form the new_work_order_external_service_entry table---//
												
				$qry="SELECT date,vendor_id,description,cost FROM new_work_order_external_service_entry WHERE work_order_id='$work_order_id'";
												
												
				$qryexecute=mysqli_query($db, $qry);
							
							while($rs=mysql_fetch_row($qryexecute))
							{
								$date=$rs[0];
								$vendor_id=$rs[1];
								$description=$rs[2];
								$cost1=$rs[3];
								//formatting cost...
								$cost=number_format($cost1,2);
						//select vendor name acoording to $vendor_id from vendor_setup table
								$qry2="SELECT vendor_name FROM vendor_setup WHERE vendor_id='$vendor_id'";
								$qryexecute2=mysqli_query($db, $qry2);
  								$vend_name=mysql_result($qryexecute2,0,0);																	
								echo"<tr>
								
									<td>$date</td>
									<td>$vend_name</td>
									<td>$description</td>
									<td align='right'>$cost</td>
									</tr>";
								
								}
							


											?>

									
     <tr>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td><div align="right"><strong>Total</strong></div></td>
       <td>

	   						<div align="right">
								<?php echo(number_format($external_service_cost,2)); ?>
 					        </div>
	   </div></td>
     </tr>
  </table>
   <table width="767" align="center" cellpadding="0" cellspacing="2">
     <tr bgcolor="#999999" class="style5">
       <td colspan="2">Optional Information </td>
       <td width="104">&nbsp;</td>
       <td width="163">&nbsp;</td>
     </tr>
     <tr>
       <td colspan="2">&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
     </tr>
     <tr class="style4">
       <td width="144">Vendor : </td>
       <td width="346"><?php echo $vend_name; ?></td>
       <td>PO #: </td>
       <td><?php echo $purchase_order; ?></td>
     </tr>
     <tr>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
     </tr>
     <tr class="style4">
       <td>Assigned To : </td>
       <td><?php echo"$assigned_to"; ?></td>
       <td>Invoice : </td>
       <td><?php echo"$invoice"; ?></td>
     </tr>
     <tr>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
     </tr>
     <tr class="style4">
       <td> Notes : </td>
       <td colspan="3"><?php echo"$work_order_comment"; ?></td>
     </tr>
  </table>
<br />
   <table width="767" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#33CC33">
     <tr>
       <td width="35">&nbsp;</td>
       <td width="121"><center>
       </center></td>
       <td width="418"><center>
         <input name="BPrint" type="button" id="BPrint" value="Print Work Order" onclick="doprint()"/>
       </center></td>
       <td width="193">&nbsp;</td>
     </tr>
  </table>
</form>
</body>
</html>

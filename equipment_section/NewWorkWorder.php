<?php 
include("common.php");
CreateConnection();
//--------------------------------------Generating work_order_id ---------------------------------------//
$work_order_Entry_Date=date("Y-m-d");

$strSQL = "select ifnull(count(work_order_id),0)+1 as Cwork_order_id from new_work_order_main where entry_date ='$work_order_Entry_Date'";

$rs = mysqli_query($db, $strSQL);

$work_order_id=ThiryTwoBaseNumber(date("d")).ThiryTwoBaseNumber(date("m")).ThiryTwoBaseNumber(date("y")).ThiryTwoBaseNumber(mysql_result($rs,0,'Cwork_order_id'));

//genearating session to hold work_order_id...
session_start();
$_SESSION['workorder_id']=$work_order_id;
//-----------------------------------------FOR CALCULATION---------------------------------------------------------------------//

	//...........Calculating Total cost(For Parts + For Labor + For Both(Part+Labor) ) for preventive maintenance for an equipment.....//
$qry4="SELECT parts_cost,labor_cost,total_cost FROM new_work_order_parts_info WHERE work_order_id='$work_order_id'";

$qryexecute4=mysqli_query($db, $qry4);

while($rs=mysql_fetch_row($qryexecute4))
{
	$pm_cost_part=$rs[0];
	$pm_cost_labor=$rs[1];
	$pm_cost_part_labor=$rs[2];
	
/*--calculating total cost caused by part--*/ $total_part_cost_PM=$total_part_cost_PM+$pm_cost_part;

/*--calculating total cost caused by both labor--*/	$total_labor_cost_pm=$total_labor_cost_pm+$pm_cost_labor;

/*--calculating total cost caused by both part+labor--*/$total_parts_labor_cost_PM=$total_parts_labor_cost_PM+$pm_cost_part_labor;
}






//...........Calculating Total cost(For Parts + For Labor + For Both(Part+Labor) ) for Repair of an equipment.....//
$qry5="SELECT parts_cost,labor_cost,total_cost FROM new_work_order_repairs_info WHERE work_order_id='$work_order_id'";

$qryexecute5=mysqli_query($db, $qry5);

while($rs=mysql_fetch_row($qryexecute5))
{
	$repair_cost_part=$rs[0];
	$repair_cost_labor=$rs[1];
	$repair_cost_part_labor=$rs[2];

/*--calculating total cost caused by part--*/ $total_part_cost_repair=$total_part_cost_repair+$repair_cost_part;

/*--calculating total cost caused by both labor--*/	$total_labor_cost_repair=$total_labor_cost_repair+$repair_cost_labor;

/*--calculating total cost caused by both part+labor--*/$total_parts_labor_cost_repair=$total_parts_labor_cost_repair+$repair_cost_part_labor;

}
	
	


	//...........Calculating External Service cost for an equipment.....//
$qry="SELECT cost FROM new_work_order_external_service_entry WHERE work_order_id='$work_order_id'";

$qryexecute=mysqli_query($db, $qry);

while($rs=mysql_fetch_row($qryexecute))
{
	$external_cost=$rs[0];
	$total_external_cost+=$external_cost;
}
	
//------CALCULATING TOTAL COST(PM+REPAIR+EXTERNAL)------//
$total_pm_repair_external_cost=$total_parts_labor_cost_PM+$total_parts_labor_cost_repair+$total_external_cost;	

	
//------CALCULATING TOTAL PARTS COST FOR PM & REPAIR FOR AN EQUIPMENT------//
$total_pm_repair_parts_cost=$total_part_cost_PM+$total_part_cost_repair;

//------CALCULATING TOTAL LABOR COST FOR PM & REPAIR FOR AN EQUIPMENT------//
$total_pm_repair_labor_cost=$total_labor_cost_pm+$total_labor_cost_repair;

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Work Order (#<?php echo"$work_order_id"; ?>) Issue Form</title>

<!-- Javascript For The Date Retreival  -->
<script type="text/javascript" language="JavaScript1.2" src="stm32.js"></script>
<script language="javascript" type="text/javascript" src="datetimepicker.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" type="text/javascript" SRC="timepicker.js"></SCRIPT>
<!-- END  -->

<!-- Javascript for using xmlhttp obsects -->
<script src="script.js" type="text/javascript"></script>
<!--  END -->

<!-- Javascript for the page -->
<script>
//this will delete the record associated with the work order id from all the tables deal with work order if the user close the page without save it...
function well()
{
document.form1.hidField.value=5;
document.form1.submit();
}


//--------------------------This Function Will be run when the page is loaded---------------
function addLoadEvent(func) {
  var oldonload = window.onload;
  if (typeof window.onload != 'function') {
    window.onload = func;
  } else {
    window.onload = function() {
      if (oldonload) {
        oldonload();
      }
      func();
    }
  }
}

addLoadEvent(function() {
var counter='<?php echo $_GET['count']; ?>';
if(counter==1)
{
document.form1.selectEquipment.disabled=true;
}

});


//--------Checking wheather an Equipment is chossed or not---//
function validate1(frm)
{
if(frm.selectEquipment.value=="")
{
alert("Please Select An Equipment.");
frm.selectEquipment.focus();
return false;
}
return true
}

//--------------------------Tracking Buttons Click Event----------------------

function goPreventive(form1)
{
if(validate1(form1)==true)
{
document.form1.hidField.value=1;
document.form1.submit();
}
}

function goRepair(form1)
{
if(validate1(form1)==true)
{
document.form1.hidField.value=2;
document.form1.submit();
}
}

function goExternelService(form1)
{
if(validate1(form1)==true)
{
document.form1.hidField.value=3;
document.form1.submit();
}
}

//-------------------------Executed when a item is selected from the equipmet combo box.................

function goDisable()
{
//-----------For checking which function is call form which form------------------
document.form1.hidEquipment.value=2;
var chk_id=document.form1.hidEquipment.value;
//alert(chk_id);
equip_id=document.getElementById("selectEquipment").value;
//alert(equip_id);
xmlhttp.open("GET", 'server.php?chk_id=' + chk_id + '&equipment_id=' + equip_id);
//xmlhttp.onreadystatechange = function() {
//if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
//document.form1.txtMeter.value=parseInt(xmlhttp.responseText);
//}
//}
 xmlhttp.send(null);

//document.form1.selectEquipment.disabled=true;
}


//-------------------------Validating Form Imput & Then Save & Exit------------------------------

function validate(form1)
{
if(form1.selectEquipment.value=="")
{
alert("Cannot Save The Record.You Should Select An Equipment First.");
form1.selectEquipment.focus();
return false;
}
else if(form1.txt_issued.value=="")
{
alert("Cannot Save The Record.You Should Select The Work Wroder Isuue Date First.");
form1.txt_issued.focus();
return false;
}
return true;
}


function doFinish(form1)
{
if(validate(form1)==true)
{
document.form1.hidField.value=4;
document.form1.submit();
}
}


//--------------Calculating UDFCOST and update(txt_sub_total,txt_grand_total,txt_pre_tax)field-----
function goUDFcost(m)
{
var udf_cost=m;
if(isNaN(udf_cost))
{
alert("Please Enter Number.");
document.form1.txt_udf_cost.focus();
}
else if(udf_cost=="")
{
alert("UDF Cost Can't Be Left Blank.Please Enter Number 0 OR Other Number.");
document.form1.txt_udf_cost.focus();
}
else{
var total_pm_repair_external_cost='<?php echo"$total_pm_repair_external_cost"; ?>';
var grand_total=parseFloat(total_pm_repair_external_cost)+parseFloat(udf_cost)+parseFloat(document.form1.txt_tax_amount.value)-parseFloat(document.form1.txt_discount.value);
document.form1.txt_sub_total.value=parseFloat(grand_total);
document.form1.txt_pre_tax.value=parseFloat(grand_total);
document.form1.txt_grand_total.value=parseFloat(grand_total);
}
//alert(udf_cost);
//alert(total_pm_repair_external_cost);
}


//-----------------Calculating Discount Amount--------
function goDiscount(m)
{
var discount=m;
if(isNaN(discount))
{
alert("Please Enter Number.");
document.form1.txt_discount.focus();
}
else if(discount=="")
{
alert("Discount Amount Can't Be Left Blank.Please Enter 0 Or Other Number.");
document.form1.txt_discount.focus();
}
else
{
var total_pm_repair_external_cost='<?php echo"$total_pm_repair_external_cost"; ?>';
var grand_total=parseFloat(total_pm_repair_external_cost)+parseFloat(document.form1.txt_udf_cost.value)+parseFloat(document.form1.txt_tax_amount.value);
var grand_total_afetr_discount=parseFloat(grand_total)-parseFloat(discount);
document.form1.txt_pre_tax.value=parseFloat(grand_total_afetr_discount);
document.form1.txt_grand_total.value=parseFloat(grand_total_afetr_discount);
}
}



//-----------------Calculating amount after paying tax--------
function goTax(m)
{
//alert(m);
var tax=m;
//alert(m);
if(isNaN(tax))
{
alert("Please Enter Number.");
document.form1.txt_tax_amount.focus();
}
else if(tax=="")
{
alert("Tax Amount Can't Be Left Blank.Please Enter 0 Or Other Number.");
document.form1.txt_tax_amount.focus();
}
else
{
var total_pm_repair_external_cost='<?php echo"$total_pm_repair_external_cost"; ?>';
var grand_total=parseFloat(total_pm_repair_external_cost)+parseFloat(document.form1.txt_udf_cost.value)-parseFloat(document.form1.txt_discount.value);
var grand_total_afetr_tax_payement=parseFloat(grand_total)+parseFloat(tax);
document.form1.txt_grand_total.value=parseFloat(grand_total_afetr_tax_payement);
}
}



//------------Tracking selectStatus onchange event and based on 'm' s value enable or disable txt_complete text box.

function goStatus(m)
{
if(m==0)
{
/* enable the text box to enter Work Order Complete Date  */
document.form1.txt_complete.disabled=false;
}
else
{
//disable text box
document.form1.txt_complete.disabled=true;
}
}
</script>
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
      <td width="376"><select name="selectEquipment" id="selectEquipment" onchange="goDisable()">
        <option value="" selected="selected"></option>
        <?php  
								
														$rs="SELECT itm_track_id FROM add_equipment_maintenance WHERE wo_status='0'";
																																														
														$result = mysqli_query($db, $rs);
														while ($name_row = mysql_fetch_row($result)) {
														$itm_track_id=$name_row[0];
											//select items description from the equipment  table corresponds to the itemCode.
														$qry_itm="SELECT itemCode FROM equipment where eqid='$itm_track_id'";
														$qryexec=mysqli_query($db, $qry_itm);
														$rs_return=mysql_fetch_row($qryexec);
														$rs_des=$rs_return[0];
														echo"<option value='$itm_track_id'";if($itm_track_id==$equip_id) echo' SELECTED '; echo"> -> $rs_des</option>";		
														}
														
																
														
														
									?>
      </select></td>
      <td width="105"><span class="style4">PM Task : </span></td>
      <td width="146"><input name="txt_pm_total" type="text" id="txt_pm_total" size="15" value="<?php echo $total_parts_labor_cost_PM; ?>" READONLY style="text-align:right"/>
      Tk.</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><span class="style4">Repairs :</span></td>
      <td><input name="txt_repair_total" type="text" id="txt_repair_total" size="15" value="<?php echo $total_parts_labor_cost_repair; ?>" READONLY style="text-align:right"/>
      Tk.</td>
    </tr>
    <tr>
      <td class="style4">WO #: </td>
      <td><input name="txtWorkWorder" type="text" id="txtWorkWorder" value="<?php echo"$work_order_id"; ?>" size="15" readonly="READONLY"/></td>
      <td><span class="style4">Ext Services : </span></td>
      <td><input name="txt_external_service_total" type="text" id="txt_external_service_total" size="15" value="<?php echo $total_external_cost;  ?>" READONLY style="text-align:right"/>
      Tk.</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><span class="style4">UDF Cost : </span></td>
      <td><input name="txt_udf_cost" type="text" id="txt_udf_cost" onchange="goUDFcost(txt_udf_cost.value)" value="0" size="15" style="text-align:right"/>
      Tk.</td>
    </tr>
    <tr>
      <td class="style4">Date Issued </td>
      <td><input name="txt_issued" type="text" id="txt_issued" size="15" READONLY/>
      <a href="javascript:NewCal('txt_issued','yyyymmdd','true',12)"><img src="cal.gif" alt="calender" width="16" height="16" border="0" /></a></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><span class="style4">Subtotal</span></td>
      <td><input name="txt_sub_total" type="text" id="txt_sub_total" value="<?php echo $total_pm_repair_external_cost; ?>" size="15" READONLY style="text-align:right"/>
      Tk.</td>
    </tr>
    <tr>
      <td><label><?php echo"$item_meter_type"; ?></label></td>
      <td><input name="txtMeter" type="text" id="txtMeter" size="15" value="<?php echo $rs_item_meter; ?>" READONLY/></td>
      <td><span class="style4">Discount Amt: </span></td>
      <td><input name="txt_discount" type="text" id="txt_discount" size="15" value="0" onchange="goDiscount(this.value)" style="text-align:right"/>
      Tk.</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="style4">Status:</td>
      <td><select name="selectStatus" id="selectStatus" onchange="goStatus(this.value)">
        <option value="1" selected="selected">Open</option>
        <option value="0">Closed</option>
      </select></td>
      <td><span class="style4">Pre-tax Amt: </span></td>
      <td><input name="txt_pre_tax" type="text" id="txt_pre_tax" value="0" size="15" READONLY style="text-align:right"/>
      Tk.</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><span class="style4">Taxes</span></td>
      <td><input name="txt_tax_amount" type="text" id="txt_tax_amount" size="15" value="0" onchange="goTax(this.value)" style="text-align:right"/>
      Tk.</td>
    </tr>
    <tr>
      <td class="style4">Date Complete </td>
      <td><input name="txt_complete" type="text" id="txt_complete" size="15" disabled="disabled" style="border:none"/>
      <a href="javascript:NewCal('txt_complete','yyyymmdd','true',12)"><img src="cal.gif" alt="calender" width="16" height="16"border="0"/></a></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><span class="style4">Total Cost </span></td>
      <td><input name="txt_grand_total" type="text" id="txt_grand_total" size="15" value="<?php echo $total_pm_repair_external_cost; ?>" READONLY style="text-align:right"/>
      Tk.</td>
    </tr>
  </table>
  <br />
   <table width="767" align="center" cellpadding="0" cellspacing="0">
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
																								
								echo"<tr bgcolor=#FF99FF ondblclick='goClick($part_num)'>
								
									<td>$pm_date</td>
									<td>$pm_service_name</td>
									<td align='right'>$total_cost</td>
									</tr>";
								
								}
							


											?>
	
    <tr>
      <td><label>
      <input name="BPreventiveMaintenance" type="button" id="BPreventiveMaintenance" value="       Add      " onclick="goPreventive(form1)"/>
      </label></td>
      <td><div align="right">Total</div></td>
      <td>
	  								  
	  								  
	  								  
	  								  <label>
                                      <div align="right">
                                        <input name="txtPMCost" type="text" id="txtPMCost" value="<?php echo(number_format("$total_parts_labor_cost_PM",2)); ?>" size="15" align="right" READONLY style="text-align:right"/>
        </div>
                                                                      </div>
      </label></td>
    </tr>
  </table>
   <br />
   <table width="767" align="center" cellpadding="0" cellspacing="0">
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
																															
								echo"<tr bgcolor=#CCCC66 ondblclick='goClick($part_num)'>
								
									<td>$pm_date</td>
									<td>$repair_type</td>
									<td align='right'>$total_cost</td>
									</tr>";
								
								}
							


											?>

	 
     <tr>
       <td><label>
         <input name="BRepairs" type="button" id="BRepairs" value="       Add      " onclick="goRepair(form1)"/>
       </label></td>
       <td><div align="right">Total</div></td>
       <td>
           <label>
           <div align="right">
             <input name="txtRepairCost" type="text" id="txtRepairCost" value="<?php echo(number_format($total_parts_labor_cost_repair,2)); ?>" size="15" align="right" READONLY style="text-align:right"/>
         </div>
         </label></td>
     </tr>
  </table>
   <br />
   <table width="767" align="center" cellpadding="0" cellspacing="0">
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
								$part_extended_cost=$rs[4];
																																
								echo"<tr bgcolor=#FF99FF ondblclick='goClick($part_num)'>
								
									<td>$part_num</td>
									<td>$part_name</td>
									<td>$part_quantity</td>
									<td>$part_unit_cost</td>
									<td align='right'>$part_extended_cost</td>
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
								$part_extended_cost1=$rs[4];
								//formatting part_extended_cost1
								$part_extended_cost=number_format($part_extended_cost1,2);
																																
								echo"<tr bgcolor=#CCCC66 ondblclick='goClick($part_num)'>
								
									<td>$part_num</td>
									<td>$part_name</td>
									<td>$part_quantity</td>
									<td>$part_unit_cost</td>
									<td align='right'>$part_extended_cost</td>
									</tr>";
								
								}
							


											?>

	 
	 
     <tr>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td><div align="right">Total</div></td>
       <td>
	   						
							<?php 
									//----CAlculating Total cost for parts ---------------//
									$total_parts_cost=$total+$repair_total;
									//---formatting total cost into currency...//
									//$total_parts_cost=number_format($total_parts_cost1,2);
							
							?>
	   
	   <label>
         
        <div align="right">
          <input name="txtPartCost" type="text" id="txtPartCost" value="<?php echo $total_pm_repair_parts_cost;  ?>" size="15" align="right" READONLY style="text-align:right"/>
        </div>
	   </label></td>
     </tr>
	 
  </table>
   <br />
   <table width="767" align="center" cellpadding="0" cellspacing="0">
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
								$lobor_cost=number_format($lobor_cost1);
								
								//retreiving employee name from add_new_employee table based on $emp_Name value
								$qry1="SELECT name FROM employee WHERE empId='$emp_id'";
								$qryexecute1=mysqli_query($db, $qry1);
								$employe_name=mysql_result($qryexecute1,0,0);
																								
								echo"<tr bgcolor=#FF99FF ondblclick='goClick1($emp_id)'>
								
									<td>$employe_name</td>
									<td>$desc_of_work</td>
									<td>$emp_labor_rate</td>
									<td>$work_hour</td>
									<td align='right'>$lobor_cost</td>
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
								$lobor_cost=$rs[4];
								
								//retreiving employee name from add_new_employee table based on $emp_Name value
								$qry1="SELECT name FROM employee WHERE empId='$emp_id'";
								$qryexecute1=mysqli_query($db, $qry1);
								$employe_name=mysql_result($qryexecute1,0,0);
																								
								echo"<tr bgcolor=#CCCC66 ondblclick='goClick1($emp_id)'>
								
									<td>$employe_name</td>
									<td>$desc_of_work</td>
									<td>$emp_labor_rate</td>
									<td>$work_hour</td>
									<td align='right'>$lobor_cost</td>
									</tr>";
								
								}
							


											?>

											
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td><div align="right">Total</div></td>
       <td><div align="right">
         <input name="txt_labor_cost" type="text" id="txt_labor_cost" value="<?php echo $total_pm_repair_labor_cost;  ?>" size="15" align="right" READONLY style="text-align:right"/>
       </div></td>
     </tr>
	 
  </table>
   <br />
   <table width="767" align="center" cellpadding="0" cellspacing="0">
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
								echo"<tr bgcolor=#FF99FF ondblclick='goClick($part_num)'>
								
									<td>$date</td>
									<td>$vend_name</td>
									<td>$description</td>
									<td align='right'>$cost</td>
									</tr>";
								
								}
							


											?>

									
     <tr>
       <td><input name="AddExternelServices" type="button" id="AddExternelServices" value="       Add      " onclick="goExternelService(form1)"/></td>
       <td>&nbsp;</td>
       <td><div align="right">Total</div></td>
       <td>

	   						<div align="right">
	   						  
	   						  
	   						  <input name="txtTotalExternalCost" type="text" id="txtTotalExternalCost" value="<?php echo $total_external_cost;  ?>" size="15" align="right" READONLY style="text-align:right"/>
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
       <td width="346"><label>
									 <select name="selectVendor" id="selectVendor">
									 <option value="" selected="selected"></option>
									 
									 <?php 
									 
									 CreateConnection();
									$qry2="SELECT vendor_id,vendor_name FROM vendor_setup";
									$qryexecute2=mysqli_query($db, $qry2);
							
							while($rs=mysql_fetch_row($qryexecute2))
							{
								$vendor_id=$rs[0];
								$vendor_name=$rs[1];
																											
								echo"<option value='$vendor_id'>$vendor_name</option>";
								}
									 
									 ?>
	    </select>
       </label></td>
       <td>PO #: </td>
       <td><label>
         <input name="txtPO" type="text" id="txtPO" size="15" />
       </label></td>
     </tr>
     <tr>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
     </tr>
     <tr class="style4">
       <td>Assigned To : </td>
       <td><input name="selectAssigned" type="text" id="selectAssigned" /></td>
       <td>Invoice : </td>
       <td><input name="txtInvoice" type="text" id="txtInvoice" size="15" /></td>
     </tr>
     <tr>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
     </tr>
     <tr class="style4">
       <td> Notes : </td>
       <td colspan="3"><input name="txt_workOrder_notes" type="text" id="txt_workOrder_notes" size="100" /></td>
     </tr>
  </table>
<br />
   <table width="767" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#33CC33">
     <tr>
       <td width="35">&nbsp;</td>
       <td width="196"><center>
       </center></td>
       <td width="343"><center>
         <input name="BSave" type="button" id="BSave" onclick="doFinish(form1)" value="    Issue Work Order   "/>
       </center></td>
       <td width="193">&nbsp;</td>
     </tr>
  </table>
</form>
</body>
</html>

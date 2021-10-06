<?php 
include("common.php");
CreateConnection();
//assign hidden variable value to check which event is occured...
$track=$_POST['hidField'];
//executed when a work order is selected(i.e.work order combo's change event)
if($track==5)
{
//assigning work order id which needs to be edited...
$Work_order=$_POST['selectWork_order'];
//creating session to hold the work order id..
session_start();
$_SESSION['workorder_id']=$Work_order;
//query to retreive value corresponding to the selected work order ...
$qry="SELECT item_id,issued_date, closed_date, equipment_meter, work_order_status, vendor, assigned_to, purchase_order, invoice, pm_cost, repair_cost, parts_cost, labor_cost, external_service_cost, udf_cost, sub_total, discount_amt, pre_tax_amt, tax_amt, grand_total, work_order_comment FROM new_work_order_main WHERE work_order_id='$Work_order'";
$qryexecute=mysqli_query($db, $qry);
$rs=mysql_fetch_row($qryexecute);
$item_id=$rs[0];
$issued_date=$rs[1];
$closed_date=$rs[2];
$equipment_meter=$rs[3];
$work_order_status=$rs[4];
$vendor=$rs[5];
$assigned_to=$rs[6];
$purchase_order=$rs[7];
$invoice=$rs[8];
$pm_cost=$rs[9];
$repair_cost=$rs[10];
$parts_cost=$rs[11];
$labor_cost=$rs[12];
$external_service_cost=$rs[13];
$udf_cost=$rs[14];
$sub_total=$rs[15];
$discount_amt=$rs[16];
$pre_tax_amt=$rs[17];
$tax_amt=$rs[18];
$grand_total=$rs[19];
$work_order_comment=$rs[20];

//echo $pm_cost;
//creting session to hold the equipment id(here item_id reperesents the itm_track_id for tracking individual item)
$_SESSION['equip_id']=$item_id;

//retreive item identification based on the item_id...
$qry_identification="SELECT item_identification FROM add_equipment_maintenance WHERE itm_track_id='$item_id'";
$qryexecute_identification=mysqli_query($db, $qry_identification);
$rs_identification=mysql_fetch_row($qryexecute_identification);
$item_identification=$rs_identification[0];

//fetch meter type from the track_equipments table based on the selected equipment_id 
$rs="SELECT item_meter_type FROM track_equipments WHERE itm_track_id='$item_id'";
$result = mysqli_query($db, $rs);
$rs_result=mysql_fetch_row($result);
$item_meter_type=$rs_result[0];


//-----------------------------------------FOR CALCULATION---------------------------------------------------------------------//

	//...........Calculating Total cost(For Parts + For Labor + For Both(Part+Labor) ) for preventive maintenance for an equipment.....//
$qry4="SELECT parts_cost,labor_cost,total_cost FROM new_work_order_parts_info WHERE work_order_id='$Work_order'";

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
$qry5="SELECT parts_cost,labor_cost,total_cost FROM new_work_order_repairs_info WHERE work_order_id='$Work_order'";

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
$qry="SELECT cost FROM new_work_order_external_service_entry WHERE work_order_id='$Work_order'";

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

//------------------------------------------------------END CALCULATION-------------------------------------------//
}
//SAVE RECORD...AFTER ADDING SERVICES TO THE WORK ORDER....
else if($track==4)
{
//assigning system date for tracking which work order is MODIFIED ON which date...
$work_order_Entry_Date=date("Y-m-d");

//Rendering Session Values...............
session_start();
$work_order_id=$_SESSION['workorder_id'];
$item_orig_id=$_SESSION['equip_id'];
//echo"$work_order_id";
//echo"$item_orig_id";

//----------Assigning posted value to the variable...................
$txt_issued=$_POST['txt_issued'];
$txt_complete=$_POST['txt_complete'];
$txtMeter=$_POST['txtMeter'];
$selectStatus=$_POST['selectStatus'];
$selectVendor=$_POST['selectVendor'];
$selectAssigned=$_POST['selectAssigned'];
$PO=$_POST['txtPO'];
$Invoice=$_POST['txtInvoice'];
$txt_workOrder_notes=$_POST['txt_workOrder_notes'];
//---all cost variables---//
$pm_total=$_POST['txt_pm_total'];
$repair_total=$_POST['txt_repair_total'];
$txtPartCost=$_POST['txtPartCost'];
$txt_labor_cost=$_POST['txt_labor_cost'];
$external_service_total=$_POST['txt_external_service_total'];
$udf_cost=$_POST['txt_udf_cost'];
$sub_total=$_POST['txt_sub_total'];
$discount=$_POST['txt_discount'];
$pre_tax=$_POST['txt_pre_tax'];
$tax_amount=$_POST['txt_tax_amount'];
$grand_total=$_POST['txt_grand_total'];

mysqli_query($db, "BEGin;"); 
//BEGIN TRANSACTION
//----------UPDATE Data in the Table "new_work_order_main" .................//

$qry="UPDATE new_work_order_main SET issued_date='$txt_issued',closed_date='$txt_complete',equipment_meter='$txtMeter',work_order_status='$selectStatus',vendor='$selectVendor',assigned_to='$selectAssigned',purchase_order='$PO',invoice='$Invoice',pm_cost='$pm_total',repair_cost='$repair_total',parts_cost='$txtPartCost',labor_cost='$txt_labor_cost',external_service_cost='$external_service_total',udf_cost='$udf_cost',sub_total='$sub_total',discount_amt='$discount',pre_tax_amt='$pre_tax',tax_amt='$tax_amount',grand_total='$grand_total',work_order_comment='$txt_workOrder_notes',entry_date='$work_order_Entry_Date' WHERE work_order_id='$work_order_id' AND item_id='$item_orig_id'";
$qryexecute=mysqli_query($db, $qry);


/*
//UPDATE THE METER READING OF THE EQUIPMENT TO SET THE NEXT PLANNED MAINTENANCE DATE...(UPDATEING track_equipments TABLE)
$qry_track="UPDATE track_equipments SET item_curr_kilometer='$txtMeter',item_base_kilometer='$txtMeter',update_curr_meter_date='$work_order_Entry_Date',item_base_date='$work_order_Entry_Date' WHERE item_id='$equipment_id'";
$qry_track_execute=mysqli_query($db, $qry_track);

//CHECK TO SEE IF THE EQUIPMENT CORRESPONDING TO THE WORK ORDER HAS THE MAINTENANCE BASED OF FIXED DATE...
$test="SELECT fixed_date FROM add_pm_service WHERE pm_service_id=(SELECT pm_service_id FROM add_equipment_maintenance WHERE item_id='$equipment_id')";
$execute_test=mysqli_query($db, $test);
$rs=mysql_fetch_row($execute_test);
$track=$rs[0];
//if the equipment is not fixed date based then set the wo_status=0 i.e.though the work order is issued but the next planned maintenance date is added to the equipment...
if($track=="0000-00-00")
{
//note: "0000-00-00" means the date is blank.
$qry_equip_maintenance="UPDATE add_equipment_maintenance SET item_curr_kilometer='$txtMeter',update_curr_meter_date='$work_order_Entry_Date' WHERE item_id='$equipment_id'";
$qry_equip_maintenance_execute=mysqli_query($db, $qry_equip_maintenance);
}
//if the equipment is fixed date based then set the field wo_status=0.i.e. Work order aginst this equipment is issued and it no longer due for maintenance and will not appear on the main screen...
else
{
$qry_equip_maintenance="UPDATE add_equipment_maintenance SET item_curr_kilometer='$txtMeter',update_curr_meter_date='$work_order_Entry_Date',wo_status='1' WHERE item_id='$equipment_id'";
$qry_equip_maintenance_execute=mysqli_query($db, $qry_equip_maintenance);
}

*/
mysqli_query($db, "COMMIT;"); 
//END TRANSACTION
header("Location: NewWorkWorder_print.php");
} 
//THIS SECTION IS FOR DISPLAY RECORD AFTER SERVICES ADDED TO THE WORK ORDER........
else 
{
//Rendering Session Values...............
session_start();
$work_order_id=$_SESSION['workorder_id'];
$item_orig_id=$_SESSION['equip_id'];

//query to retreive value corresponding to the selected work order ...
$qry="SELECT item_id,issued_date, closed_date, equipment_meter, work_order_status, vendor, assigned_to, purchase_order, invoice, pm_cost, repair_cost, parts_cost, labor_cost, external_service_cost, udf_cost, sub_total, discount_amt, pre_tax_amt, tax_amt, grand_total, work_order_comment FROM new_work_order_main WHERE work_order_id='$work_order_id'";
$qryexecute=mysqli_query($db, $qry);
$rs=mysql_fetch_row($qryexecute);
$item_id=$rs[0];
$issued_date=$rs[1];
$closed_date=$rs[2];
$equipment_meter=$rs[3];
$work_order_status=$rs[4];
$vendor=$rs[5];
$assigned_to=$rs[6];
$purchase_order=$rs[7];
$invoice=$rs[8];
$pm_cost=$rs[9];
$repair_cost=$rs[10];
$parts_cost=$rs[11];
$labor_cost=$rs[12];
$external_service_cost=$rs[13];
$udf_cost=$rs[14];
$sub_total=$rs[15];
$discount_amt=$rs[16];
$pre_tax_amt=$rs[17];
$tax_amt=$rs[18];
$grand_total=$rs[19];
$work_order_comment=$rs[20];


//retreive item identification based on the item_id...
$qry_identification="SELECT teqSpec FROM equipment WHERE eqid='$item_orig_id'";
$qryexecute_identification=mysqli_query($db, $qry_identification);
$rs_identification=mysql_fetch_row($qryexecute_identification);
$item_identification=$rs_identification[0];

//fetch meter type from the track_equipments table based on the selected equipment_id 
$rs="SELECT item_meter_type FROM track_equipments WHERE itm_track_id='$item_orig_id'";
$result = mysqli_query($db, $rs);
$rs_result=mysql_fetch_row($result);
$item_meter_type=$rs_result[0];

//----------FOR CALCULATION AFTER ADDING NEW SERVIVES(PM OR REPAIR OR EXTERNAL) TO THE WORK ORDER-----//

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

//------------------------------------------------------END CALCULATION-------------------------------------------//

}

//Rendering Session Values...............
session_start();
$work_order_id=$_SESSION['workorder_id'];
$item_orig_id=$_SESSION['equip_id'];

//assign status velue to check wheather it is open or close
$status=$_POST['work_order_status'];
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Edit Work Order (#<?php echo"$work_order_id"; ?>) Issue Form</title>
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
document.form1.selectWork_order.disabled=true;
//document.form1.BUpdate.disabled=false;
}

});


//-------------------------Executed when a work order is selected from the combo box.................

function goChange(id)
{
if(id=="")
{

}
else
{
//alert(id);
//setting hidden varible value to specify that combos change event is occured..
document.form1.hidField.value=5;
//submitthe form to retreive the record corresponding to the selectde work order id...
document.form1.submit();
}
}

//submitting form..(SAVE RECORD)
function doFinish()
{
if(document.form1.txt_grand_total.value==0)
{
alert("Please Select a Work Order!");
document.form1.selectWork_order.focus();
}
else
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

//ADD PREVENTIVE SERVICES....TO THE EDITED WORK ORDER
function check_previntive()
{
if(document.form1.txt_grand_total.value=="")
{
alert("Please Select a Work Order!");
document.form1.selectWork_order.focus();
}
else
{
location.href='Edit_preventive_services.php';
}
}

//ADD REPAIR SERVICES....TO THE EDITED WORK ORDER
function check_repair()
{
if(document.form1.txt_grand_total.value=="")
{
alert("Please Select a Work Order!");
document.form1.selectWork_order.focus();
}
else
{
location.href='Edit_repair_services.php';
}
}


//ADD EXTERNAL SERVICES....TO THE EDITED WORK ORDER
function check_external()
{
if(document.form1.txt_grand_total.value=="")
{
alert("Please Select a Work Order!");
document.form1.selectWork_order.focus();
}
else
{
location.href='Edit_external_services.php';
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

<body>
<form id="form1" name="form1" method="post" action="">
    <input name="hidField" type="hidden" id="hidField" />
      <input name="hidEquipment" type="hidden" id="hidEquipment" />
  <table width="767" border="0" align="center" cellpadding="0" cellspacing="2">
    <tr bgcolor="#33CC33">
      <td colspan="2" bgcolor="#33CC33"><span class="style7">Edit Work Order</span> - #<?php echo"$work_order_id"; ?> </td>
      <td colspan="2"><div align="center" class="style4">Total</div></td>
    </tr>
    
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="165"><span class="style4">Select WO :</span></td>
      <td width="342"><select name="selectWork_order" id="selectWork_order" onchange="goChange(this.value)" >
        <option value="" selected="selected"></option>
        <?php  
								
														$rs="SELECT work_order_id FROM new_work_order_main";
																																														
														$result = mysqli_query($db, $rs);
														while ($name_row = mysql_fetch_row($result)) {
														$work_or_id=$name_row[0];
														echo"<option value='$work_or_id'"; if($work_or_id==$work_order_id) echo ' SELECTED '; echo">$work_or_id</option>";		
														}
														
																
														
														
									?>
      </select></td>
      <td width="103"><span class="style4">PM Task : </span></td>
      <td width="147"><input name="txt_pm_total" type="text" id="txt_pm_total" size="15" value="<?php echo $total_parts_labor_cost_PM; ?>" style="text-align:right" READONLY/>
      Tk.</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><span class="style4">Repairs :</span></td>
      <td><input name="txt_repair_total" type="text" id="txt_repair_total" size="15" value="<?php echo $total_parts_labor_cost_repair; ?>" style="text-align:right" READONLY/>
      Tk.</td>
    </tr>
    <tr>
      <td class="style4">Equipment Identification: </td>
      <td><input name="txt_equipment" type="text" id="txt_equipment" value="<?php echo $item_identification; ?>" size="30" READONLY/></td>
      <td><span class="style4">Ext Services : </span></td>
      <td><input name="txt_external_service_total" type="text" id="txt_external_service_total" size="15" value="<?php echo $total_external_cost;  ?>" style="text-align:right" READONLY/>
      Tk.</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><span class="style4">UDF Cost : </span></td>
      <td><input name="txt_udf_cost" type="text" id="txt_udf_cost" onchange="goUDFcost(txt_udf_cost.value)" value="<?php echo $udf_cost;  ?>" size="15" style="text-align:right"/>
      Tk.</td>
    </tr>
    <tr>
      <td class="style4">Date Issued </td>
      <td><input name="txt_issued" type="text" id="txt_issued" size="15" value="<?php echo $issued_date; ?>" READONLY/>
      <a href="javascript:NewCal('txt_issued','yyyymmdd','true',12)"><img src="cal.gif" alt="calender" width="16" height="16" border="0" /></a></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><span class="style4">Subtotal</span></td>
      <td><input name="txt_sub_total" type="text" id="txt_sub_total" value="<?php echo $total_pm_repair_external_cost; ?>" size="15" style="text-align:right" READONLY/>
      Tk.</td>
    </tr>
    <tr>
      <td><label><?php echo"$item_meter_type"; ?></label></td>
      <td><input name="txtMeter" type="text" id="txtMeter" size="15" value="<?php echo $equipment_meter; ?>" READONLY/></td>
      <td><span class="style4">Discount Amt: </span></td>
      <td><input name="txt_discount" type="text" id="txt_discount" size="15" value="<?php echo $discount_amt;  ?>" onchange="goDiscount(this.value)" style="text-align:right"/>
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
        <option value="1" selected="selected" <?php if($work_order_status==1) echo ' SELECTED '; ?>>Open</option>
        <option value="0" <?php if($work_order_status==0) echo ' SELECTED '; ?>>Closed</option>
      </select></td>
      <td><span class="style4">Pre-tax Amt: </span></td>
      <td><input name="txt_pre_tax" type="text" id="txt_pre_tax" value="<?php echo $pre_tax_amt;  ?>" size="15" style="text-align:right" READONLY/>
      Tk.</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><span class="style4">Taxes</span></td>
      <td><input name="txt_tax_amount" type="text" id="txt_tax_amount" size="15" value="<?php echo $tax_amt;  ?>" onchange="goTax(this.value)" style="text-align:right"/>
      Tk.</td>
    </tr>
    <tr>
      <td class="style4">Date Complete </td>
      <td><input name="txt_complete" type="text" id="txt_complete" size="15" disabled="disabled" value="<?php echo $closed_date; ?>">
      <a href="javascript:NewCal('txt_complete','yyyymmdd','true',12)"><img src="cal.gif" alt="calender" width="16" height="16"border="0"/></a></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><span class="style4">Total Cost </span></td>
      <td><input name="txt_grand_total" type="text" id="txt_grand_total" size="15" value="<?php echo $total_pm_repair_external_cost; ?>" style="text-align:right" READONLY/>
      Tk.</td>
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
      <input name="BPreventiveMaintenance" type="button" id="BPreventiveMaintenance" value="       Add      " onclick="check_previntive()"/>
      </label></td>
      <td><div align="right">Total</div></td>
      <td>
        <div align="right">
		<!--showing total pm cost caused by Part_labour -->
		<input name="txtPMCost" type="text" id="txtPMCost" value="<?php echo $total_parts_labor_cost_PM; ?>" size="15" style="text-align:right" readonly="readonly"/>
        </div>
      </label></td>
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
																															
								echo"<tr bgcolor=#CCCC66 ondblclick='goClick($part_num)'>
								
									<td>$pm_date</td>
									<td>$repair_type</td>
									<td align='right'>$total_cost</td>
									</tr>";
								
								}
							


											?>

	 
     <tr>
       <td><label>
         <input name="BRepairs" type="button" id="BRepairs" value="       Add      " onclick="check_repair()"/>
       </label></td>
       <td><div align="right">Total</div></td>
       <td>
           <label>
           <div align="right">
             <input name="txtRepairCost" type="text" id="txtRepairCost" value="<?php echo $total_parts_labor_cost_repair; ?>" size="15" style="text-align:right" READONLY/>
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
								
												
												$qry="SELECT part_num,part_name,part_quantity,part_unit_cost,part_extended_cost FROM new_work_order_part_used WHERE work_order_id='$work_order_id'";
												
												
												$qryexecute=mysqli_query($db, $qry);
							
							while($rs=mysql_fetch_row($qryexecute))
							{
								$part_num=$rs[0];
								$part_name=$rs[1];
								$part_quantity=$rs[2];
								$part_unit_cost1=$rs[3];
								$part_extended_cost1=$rs[4];
								
								//formatting part_extended_cost1+part_unit_cost1
								$part_extended_cost=number_format($part_extended_cost1,2);
								$part_unit_cost=number_format($part_unit_cost1,2);
								
																								
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
								
												$qry="SELECT part_num,part_name,part_quantity,part_unit_cost,part_extended_cost FROM new_work_order_repair_parts_used WHERE work_order_id='$work_order_id'";
												
												
												$qryexecute=mysqli_query($db, $qry);
							
							while($rs=mysql_fetch_row($qryexecute))
							{
								$part_num=$rs[0];
								$part_name=$rs[1];
								$part_quantity=$rs[2];
								$part_unit_cost1=$rs[3];
								$part_extended_cost1=$rs[4];
								//formatting part_extended_cost1+part_unit_cost1
								$part_extended_cost=number_format($part_extended_cost1,2);
								$part_unit_cost=number_format($part_unit_cost1,2);
								
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
		<div align="right">
          <input name="txtPartCost" type="text" id="txtPartCost" value="<?php echo $total_pm_repair_parts_cost;  ?>" size="15" style="text-align:right" READONLY/>
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
								$lobor_cost=number_format($lobor_cost1,2);
								
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
								$lobor_cost1=$rs[4];
								//formatting labor cost...
								$lobor_cost=number_format($lobor_cost1,2);
								
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
         <input name="txt_labor_cost" type="text" id="txt_labor_cost" value="<?php echo $total_pm_repair_labor_cost;  ?>" size="15" style="text-align:right" READONLY/>
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
								echo"<tr bgcolor=#FF99FF ondblclick='goClick($part_num)'>
								
									<td>$date</td>
									<td>$vend_name</td>
									<td>$description</td>
									<td align='right'>$cost</td>
									</tr>";
								
								}
							


											?>

									
     <tr>
       <td><input name="AddExternelServices" type="button" id="AddExternelServices" value="       Add      " onclick="check_external()"/>
	   </td>
       <td>&nbsp;</td>
       <td><div align="right">Total</div></td>
       <td>

	   						<div align="right">
	   						  
	   						  
	   						  <input name="txtTotalExternalCost" type="text" id="txtTotalExternalCost" value="<?php echo $total_external_cost;  ?>" size="15" style="text-align:right" READONLY/>
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
																											
								echo"<option value='$vendor_id'"; if($vendor_id==$vendor) echo ' SELECTED '; echo">$vendor_name</option>";
								}
									 
									 ?>
	    </select>
       </label></td>
       <td>PO #: </td>
       <td><label>
       <input name="txtPO" type="text" id="txtPO" value="<?php echo $purchase_order; ?>" size="15" />
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
       <td><input name="selectAssigned" type="text" id="selectAssigned" value="<?php echo $assigned_to; ?>"/></td>
       <td>Invoice : </td>
       <td><input name="txtInvoice" type="text" id="txtInvoice" value="<?php echo $invoice; ?>" size="15" /></td>
     </tr>
     <tr>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
     </tr>
     <tr class="style4">
       <td> Notes : </td>
       <td colspan="3"><input name="txt_workOrder_notes" type="text" id="txt_workOrder_notes" value="<?php echo $work_order_comment; ?>" size="100" /></td>
     </tr>
  </table>
   <label></label>
   <label></label>
  <br />
   <table width="767" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#33CC33">
     <tr>
       <td width="35">&nbsp;</td>
       <td width="155"><center>
       </center></td>
       <td width="384"><center>
         <input name="BUpdate" type="button" id="BUpdate" onclick="doFinish()" value="    Update Work Order   "/>
       </center></td>
       <td width="193">&nbsp;</td>
     </tr>
  </table>
</form>
</body>
</html>

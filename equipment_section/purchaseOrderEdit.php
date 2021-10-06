<?php 
include("common.php");
CreateConnection();
//retreiving PO number from the session iniotiated at Browse_Purchase_Order_Medium.php page
session_start();
$po_num=$_SESSION['PO'];
//------------------query for retreiving data based on PO number.....
$qry="SELECT po_issued_date, po_closed_date, date_required, buyer_name, ship_via, purchase_form, ship_to, po_status, po_terms, po_quote, order_number, po_notes, parts_ordered, Freight, Tax, total_cost FROM purchaseorder_main WHERE po='$po_num'";

$qryexecute=mysqli_query($db, $qry);
$rs=mysql_fetch_row($qryexecute);
//---assigning retreived value to the variable//
$po_issued_date=$rs[0];
$po_closed_date=$rs[1];
$date_required=$rs[2];
$buyer_name=$rs[3];
$ship_via=$rs[4];
$purchase_form=$rs[5];
$ship_to=$rs[6];
$po_status=$rs[7];
$po_terms=$rs[8];
$po_quote=$rs[9];
$order_number=$rs[10];
$po_notes=$rs[11];
$parts_ordered=$rs[12];
$Freight=$rs[13];
$Tax=$rs[14];
$total_cost=$rs[15];
/*
echo"$po_issued_date<br>";
echo"$po_closed_date<br>";
echo"$date_required<br>";
echo"$buyer_name<br>";
echo"$ship_via<br>";
echo"$ship_to<br>";
echo"$po_status<br>";
echo"$po_terms<br>";
echo"$po_quote<br>";
echo"$order_number<br>";
echo"$po_notes<br>";
echo"$parts_ordered<br>";
echo"$Freight<br>";
echo"$Tax<br>";
echo"$total_cost<br>";
*/


/*//---generating purchase order number---//
$qry = "SELECT MAX(po) FROM purchaseorder_main";
$qryexecute=mysqli_query($db, $qry);
$rs=mysql_result($qryexecute,0,0);
//echo("$rs");
if($rs==0)
{
$purchase_order=100;
//echo("$work_order_id");
}
else
{
$purchase_order=$rs+1;
//echo("$work_order_id");
}
//generating session to hold purchase order number..//
session_start();
$_SESSION['purchase_order']=$purchase_order;

*/
//Calculating total parts cost for a purchase order
$qry="SELECT part_extended_cost FROM purchaseorder_parts_info WHERE po='$po_num'";
$qryexecute=mysqli_query($db, $qry);
while($rs=mysql_fetch_row($qryexecute))
{
$cost=$cost+$rs[0];
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Purchase Order (#<?php echo $po_num; ?>) Edit Form</title>
<!-- Javascript for using xmlhttp obsects -->
<script src="script.js" type="text/javascript"></script>
<!--  END -->

<!-- Javascript For The Date Retreival(calender)  -->
<script type="text/javascript" language="JavaScript1.2" src="stm32.js"></script>
<script language="javascript" type="text/javascript" src="datetimepicker.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" type="text/javascript" SRC="timepicker.js"></SCRIPT>
<!-- END  -->

<script language="javascript">

//------FORMATING NUMBER USING JAVASCRIPT---//

//this function converts the floting point presentation of a number to currency format....
fmtMoney = function( n, c, d, t ) {
	var m = ( c = Math.abs( c ) + 1 ? c : 2, d = d || ",", t = t || ".", /(\d+)(?:(\.\d+)|)/.exec( n + "" ) ), x = m[1].length % 3;
	return ( x ? m[1].substr( 0, x ) + t : "" ) + m[1].substr( x ).replace( /(\d{3})(?=\d)/g, "$1" + t ) + ( c ? d + ( +m[2] ).toFixed( c ).substr( 2 ) : "" );
};






//----------------this function converts a number to floating point equivalent by appending .00 at the end ....
function CurrencyFormatted(amount)
{
	var i = parseFloat(amount);
	if(isNaN(i)) { i = 0.00; }
	var minus = '';
	if(i < 0) { minus = '-'; }
	i = Math.abs(i);
	i = parseInt((i + .005) * 100);
	i = i / 100;
	s = new String(i);
	if(s.indexOf('.') < 0) { s += '.00'; }
	if(s.indexOf('.') == (s.length - 2)) { s += '0'; }
	s = minus + s;
	return s;
}

//--------------------------------END-----//

//Check wheather a part is added or not.If added,then enable the EDIT,DELETE and Save button.
/*function addLoadEvent()
{
var counter='<?php //echo $_GET['count']; ?>';
if(counter==1)
{
document.form1.save.disabled=false;
document.form1.PO_print.disabled=false;
}
}
*/
//-- edit parts used for the Purchase Order--//
function partEdit()
{
document.form1.hidField.value=1;
document.form1.submit();
}

//Validating form input...
function validate(frm)
{
if(frm.txt_po_issued_date.value=="")
{
alert("Please Select PO Date.");
form1.txt_po_issued_date.focus();
return false;
}
else if(frm.txt_parts_cost.value=="")
{
alert("You Must Enter At Least One Part To This Purchase Order Before Saving.");
form1.txt_po_issued_date.focus();
return false;
}
return true;
}
///Update the record...
function goUpdate(frm)
{
if(validate(frm)==true)
{
document.form1.hidField.value=2;
document.form1.submit();
}
}
//display information entered at txt_ship_to textbox 
function goShip(m)
{
document.form1.txt_ship_notes.value=m;
} 

//retreiving vendor address by using xmlhttp
function goVendor_contact(id)
{
var vend_id=id;
xmlhttp.open("GET", 'vend_server.php?vend_id=' + vend_id);
xmlhttp.onreadystatechange = function() {
if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
document.form1.txt_vendor_notes.value=xmlhttp.responseText;
}
}
 xmlhttp.send(null);

}

//Enable txt_closed_date+image text box for date entry...///
function goVisible()
{
document.form1.txt_closed_date.disabled=false;
document.form1.calcu.style.visibility='visible';
}

//disable txt_closed_date text box as well as the image for date entry...///
function goInvisible()
{
document.form1.txt_closed_date.disabled=true;
document.form1.calcu.style.visibility='hidden';
}

//----------------calculating freight cost-------------//
function goFreight(m)
{
if(isNaN(m))
{
alert("Please Enter Number");
document.form1.txt_freight_cost.focus();
}
else if(document.form1.txt_freight_cost.value=="")
{
alert("Freight Cost Can't Be Left Blank.Please Enter 0 OR Other Number.");
document.form1.txt_freight_cost.focus();
}
else
{
var total_part_cost='<?php echo $cost; ?>';
var grandTotal=parseFloat(total_part_cost)+parseFloat(m)+parseFloat(document.form1.txt_tax_cost.value);
var result = CurrencyFormatted(grandTotal);
document.form1.txt_total_cost.value=fmtMoney(result, 2, '.', ',' );
}
}


//----------------calculating TAX -------------//
function goTax(m)
{
if(isNaN(m))
{
alert("Please Enter Number");
document.form1.txt_tax_cost.focus();
}
else if(document.form1.txt_tax_cost.value=="")
{
alert("Tax Can't Be Left Blank.Please Enter 0 OR Other Number.");
document.form1.txt_tax_cost.focus();
}
else
{
var total_part_cost='<?php echo $cost; ?>';
var grandTotal=parseFloat(total_part_cost)+parseFloat(m)+parseFloat(document.form1.txt_freight_cost.value);
var result = CurrencyFormatted(grandTotal);
document.form1.txt_total_cost.value=fmtMoney(result, 2, '.', ',' );
}
}
</script>
<link href="common.css" rel="stylesheet" type="text/css" />
</head>

<body onload="javascript:addLoadEvent()" >
<?php 
//Editing the record(value is send from Browse_Purchase_Order_Medium.php page)--//
$ven_id=$_GET['purchase_form'];
?>
<form id="form1" name="form1" method="post" action="purchaseOrderEdit_Medium.php">
  <input name="hidField" type="hidden" id="hidField" />
  <table width="800" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td bgcolor="#33CC33">New Purchase Order - #<?php echo"$purchase_order"; ?> </td>
    </tr>
  </table>
<br />  <table width="800" border="0" cellspacing="0" cellpadding="0">
    
    <tr>
      <td width="472" bgcolor="#33CC33"><table width="300" border="0" cellpadding="0" cellspacing="0" bgcolor="#FF99FF">
        
        <tr>
          <td width="138">PO Date : </td>
          <td width="245"><input name="txt_po_issued_date" type="text" id="txt_po_issued_date" size="15" READONLY value="<?php echo $po_issued_date ?>"/>
            <a href="javascript:NewCal('txt_po_issued_date','yyyymmdd','true',12)"><img src="cal.gif" alt="calender" width="16" height="16" border="0" /></a></td>
        </tr>
        <tr>
          <td>PO # : </td>
          <td><input name="txt_po" type="text" id="txt_po" size="15" value="<?php echo $po_num; ?>"/></td>
        </tr>
        <tr>
          <td>Date Required </td>
          <td><input name="txt_required_date" type="text" id="txt_required_date" size="15" READONLY value="<?php echo $date_required ?>"/>
            <a href="javascript:NewCal('txt_required_date','yyyymmdd','true',12)"><img src="cal.gif" alt="calender" width="16" height="16" border="0" /></a></td>
        </tr>
        <tr>
          <td>Buyer Name </td>
          <td><input name="txt_buyer_name" type="text" id="txt_buyer_name" size="15" value="<?php echo $buyer_name ?>"/></td>
        </tr>
        <tr>
          <td>Ship Via </td>
          <td><label>
          <input name="txt_ship" type="text" id="txt_ship" size="15" value="<?php echo $ship_via ?>"/>
          </label></td>
        </tr>
      </table></td>
      <td width="328"><table width="341" border="0" cellpadding="0" cellspacing="0" bgcolor="#FF99FF">
        <tr>
          <td width="101">PO Status </td>
          <td width="240">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"><table width="354" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="193"><label>
</label>
     <input name="RadioGroup1" type="radio" value="1" checked="checked" onclick="goInvisible()" <?php if($po_status==1) echo ' CHECKED '; ?>/>
                    Outstanding</label>
                  <label>
       <input type="radio" name="RadioGroup1" value="0" onclick="goVisible()" <?php if($po_status==0) echo ' CHECKED ';?>/>
                    Closed</label>
                <label></label></td>
              <td width="161"><input name="txt_closed_date" type="text" id="txt_closed_date" size="15" disabled="disabled" value="<?php echo $po_closed_date; ?>"/>
                <a href="javascript:NewCal('txt_closed_date','yyyymmdd','true',12)"><img src="cal.gif" name="calcu"alt="calender" width="16" height="16" border="0" style="visibility:hidden"/></a></td>
            </tr>
          </table></td>
          </tr>
        <tr>
          <td>Terms</td>
          <td><select name="selectTerms" id="selectTerms">
            <option value="0" selected="selected"<?php if($po_terms==0) echo ' SELECTED '; ?>>COD</option>
            <option value="1"<?php if($po_terms==0) echo ' SELECTED '; ?>>NET 30</option>
            <option value="2"<?php if($po_terms==0) echo ' SELECTED '; ?>>Prepaid</option>
            <option value="3"<?php if($po_terms==0) echo ' SELECTED '; ?>>Wire X-Fer</option>
                    </select></td>
        </tr>
        <tr>
          <td>Inv / Quote </td>
          <td><input name="txtQuote" type="text" id="txtQuote" size="15" value="<?php echo $po_quote ?>"/></td>
        </tr>
        <tr>
          <td>Order Number </td>
          <td><input name="txt_order_number" type="text" id="txt_order_number" size="15" value="<?php echo $order_number ?>"/></td>
        </tr>
        
      </table></td>
    </tr>
  </table>
<br />  
  <table width="800" border="0" cellpadding="0" cellspacing="0" bgcolor="#33CC33">
    <tr>
      <td width="347"><table width="300" border="0" cellpadding="0" cellspacing="0" bgcolor="#FF99FF">
        <tr>
          <td bgcolor="#33CC33">Purchase From Vendor </td>
        </tr>
        <tr>
          <td>
						  <select name="selectVendor" id="selectVendor" onchange="goVendor_contact(this.value)">
						  
						  	 <?php 
									 
									$qry2="SELECT vendor_id,vendor_name FROM vendor_setup";
									$qryexecute2=mysqli_query($db, $qry2);
							
							while($rs=mysql_fetch_row($qryexecute2))
							{
								$vendor_id=$rs[0];
								$vendor_name=$rs[1];
								echo"<option value='$vendor_id'"; if($vendor_id==$purchase_form) echo ' SELECTED '; echo">$vendor_name</option>";
								}
									 
									 ?>
						  
						  </select>
		  </td>
        </tr>
        <tr>
          <td><label>
		  <?php
		  		//display vendor address based on vendor id
				$qry2="SELECT vendor_address FROM vendor_setup WHERE vendor_id='$purchase_form'";
				$qryexecute2=mysqli_query($db, $qry2);
				$rs=mysql_fetch_row($qryexecute2);
				$result=$rs[0];
		   ?>
            <textarea name="txt_vendor_notes" id="txt_vendor_notes"><?php echo $result; ?></textarea>
          </label></td>
        </tr>
      </table></td>
      <td width="123">&nbsp;</td>
      <td width="330"><table width="330" border="0" cellpadding="0" cellspacing="0" bgcolor="#FF99FF">
        <tr>
          <td width="330" bgcolor="#33CC33">Ship To </td>
        </tr>
        <tr>
          <td><label>
            <input name="txt_ship_to" type="text" id="txt_ship_to" size="40" onchange="goShip(this.value)" value="<?php echo $ship_to ?>"/>
          </label></td>
        </tr>
        <tr>
          <td><textarea name="txt_ship_notes" id="txt_ship_notes" READONLY ><?php echo $ship_to ?></textarea></td>
        </tr>
      </table></td>
    </tr>
  </table>
<br />
  <table width="800" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td bgcolor="#33CC33">Notes</td>
    </tr>
    <tr>
      <td bgcolor="#FF99FF"><label>
        <textarea name="txt_purchase_note" cols="80" rows="5" id="txt_purchase_note"><?php echo $po_notes ?></textarea>
      </label></td>
    </tr>
  </table>
<br />  <table width="800" border="0" cellspacing="0" cellpadding="0">
    <tr bgcolor="#33CC33">
      <td width="117">Totals (Tk.) </td>
      <td width="117">&nbsp;</td>
      <td width="70">&nbsp;</td>
      <td width="126" bgcolor="#33CC33">&nbsp;</td>
      <td width="44">&nbsp;</td>
      <td width="117">&nbsp;</td>
      <td width="88">&nbsp;</td>
      <td width="121">&nbsp;</td>
    </tr>
    <tr bgcolor="#FF99FF">
      <td>Parts Ordered : </td>
      <td>
	  <input name="txt_parts_cost" type="text" id="txt_parts_cost" size="15" value="<?php $formatted =number_format($cost,2); echo"$formatted"; ?>" READONLY/>
	  </td>
      <td>Freight : </td>
      <td><input name="txt_freight_cost" type="text" id="txt_freight_cost" onchange="goFreight(this.value)" value="<?php $formatted1 =number_format($Freight,2); echo"$formatted1"; ?>" size="15"/></td>
      <td>Tax : </td>
      <td><input name="txt_tax_cost" type="text" id="txt_tax_cost" value="<?php $formatted2 =number_format($Tax,2); echo"$formatted2"; ?>" size="15" onchange="goTax(this.value)"/></td>
      <td>Total Cost </td>
      <td><input name="txt_total_cost" type="text" id="txt_total_cost" size="15" value="<?php $formatted3 =number_format($total_cost,2); echo"$formatted3"; ?>" READONLY/></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="800" border="0" cellspacing="0" cellpadding="0">
    <tr bgcolor="#33CC33">
      <td width="205"><label>
        <input name="edit_part" type="button" id="edit_part" value="   Edit Parts   " onclick="partEdit()"/>
      </label></td>
      <td width="217"><input name="Update" type="button" id="Update" value=" Update Record  " onclick="goUpdate(form1)"/></td>
      <td width="205"><input name="close" type="button" id="close" value="   Close   " onclick="javascript:window.close()"/></td>
      <td width="80"><input name="PO_print" type="button" id="PO_print" value="   Print   "/></td>
      <td width="22">&nbsp;</td>
      <td width="22">&nbsp;</td>
      <td width="22">&nbsp;</td>
      <td width="27">&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>

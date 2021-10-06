<?php
include("common.php");
CreateConnection();
//retreive session value which conatins the invoice number...
session_start();
$invoice_num=$_SESSION['invoice_number'];

//calculating payments received...

$qry1="SELECT amount_receive FROM invoice_sub WHERE invoice_num='$invoice_num'";
$qryexecute1=mysqli_query($db, $qry1);
while($rs1=mysql_fetch_row($qryexecute1))
{
$total_amount_receive=$total_amount_receive+$rs1[0];

}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Add Invoice - #<?php echo"$invoice_num"; ?></title>

<!-- Javascript for using xmlhttp obects -->
<script src="script.js" type="text/javascript"></script>
<!--  END -->

<!-- Javascript For The Date Retreival(calender)  -->
<script type="text/javascript" language="JavaScript1.2" src="stm32.js"></script>
<script language="javascript" type="text/javascript" src="datetimepicker.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" type="text/javascript" SRC="timepicker.js"></SCRIPT>
<!-- END  -->
<script language="javascript">
//this will delete the record from the invoice_sub if the user close the page without save it...
function well()
{
//alert("ok");
document.form1.hidField.value=2;
document.form1.submit();
}

//EXECUTED WHEN THE FORM IS LOADED----Check wheather a payent is added for the invoice or not.If added,then enable the EDIT,DELETE and Save button.
function addLoadEvent()
{
var counter='<?php echo $_GET['count']; ?>';
if(counter==1)
{
document.form1.Bsave.disabled=false;
document.form1.invoice_print.disabled=false;
//store unformmated payments received value for further usage(such as..insert into database)..
document.form1.hid_payment_receive_amt.value='<?php echo $total_amount_receive; ?>';
}
}
//---------------------END..............//

//this function converts the floting point presentation of a number to currency format....
fmtMoney = function( n, c, d, t ) {
	var m = ( c = Math.abs( c ) + 1 ? c : 2, d = d || ",", t = t || ".", /(\d+)(?:(\.\d+)|)/.exec( n + "" ) ), x = m[1].length % 3;
	return ( x ? m[1].substr( 0, x ) + t : "" ) + m[1].substr( x ).replace( /(\d{3})(?=\d)/g, "$1" + t ) + ( c ? d + ( +m[2] ).toFixed( c ).substr( 2 ) : "" );
};

//-----------------------------END------------------------------------------------------//



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


//---Fetch grand total for an work order selected...
function goWorkOrder(m)
{
//this value is used to track..which block of code will be executed on invoice_wo_server.php page...
var s=1;
xmlhttp.open("GET", 'invoice_wo_server.php?wo_id=' + m + '&hidField=' + s);
xmlhttp.onreadystatechange = function() {
if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
var workOrder_amount=xmlhttp.responseText;
//store unformmated grand total for further usage(such as..insert into database..
document.form1.hid_invoice_amt.value=workOrder_amount;
if(workOrder_amount<100)
{
//only floating point format of the grand total..
document.form1.txt_inv_amount.value=CurrencyFormatted(workOrder_amount);
}
else
{
//floating point+currency format of the grand total..
document.form1.txt_inv_amount.value=fmtMoney(CurrencyFormatted(workOrder_amount),2, '.', ',');
}
//CurrencyFormatted function converts the xmlhttp response text to floating point number and then the fmtMoney function format the number to currency format......///
}
}
 xmlhttp.send(null);
}

//---Fetch address for a customer selected...
function goAddress(m)
{
//this value is used to track..which event is occured...
var l=2;
xmlhttp.open("GET", 'invoice_wo_server.php?cust_id=' + m + '&hidField=' + l);
xmlhttp.onreadystatechange = function() {
if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
document.forms[0].elements['txt_area_bill'].value=xmlhttp.responseText;
}
}
 xmlhttp.send(null);
}

//validating form input before submission....//
function validate(form1)
{
if(form1.txt_invoice_date.value=="")
{
alert("Please Select Invoice Issue Date.");
return false;
}
else if(form1.txt_inv_amount.value=="")
{
alert("You must enter WO # before this data can be saved.Required fields: Invoice#, Invoice Date and Work Order #..");
document.form1.wo_num.focus();
return false;
}
return true;
}

//submit form after validation is done...
function doFinish(form1)
{
if(validate(form1)==true)
{
document.form1.hidField.value=1;
document.form1.submit();
}
}


</script>
<link href="common.css" rel="stylesheet" type="text/css" />
</head>

<body onload="addLoadEvent()" onbeforeunload="javascript:well()">
<form id="form1" name="form1" method="post" action="GenerateInvoice_Medium.php">
  <table width="800" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td bgcolor="#33CC33">Add Invoice # : Details </td>
    </tr>
  </table>
  <input name="hidField" type="hidden" id="hidField" />
  <br />  <table width="800" cellpadding="0" cellspacing="0" bgcolor="#999999">
    <tr>
      <td width="104">Invoice Date : </td>
      <td width="223"><input name="txt_invoice_date" type="text" id="txt_invoice_date" size="15" READONLY/>
      <a href="javascript:NewCal('txt_invoice_date','yyyymmdd','true',12)"><img src="cal.gif" alt="calender" width="16" height="16" border="0" /></a></td>
      <td width="50">&nbsp;</td>
      <td width="148">Notes</td>
      <td width="273" rowspan="2"><textarea name="txt_invoice_note" id="txt_invoice_note"></textarea></td>
    </tr>
    <tr>
      <td>Invoice # : </td>
      <td><label>
        <input name="txt_invoice_num" type="text" id="txt_invoice_num" value="<?php echo"$invoice_num"; ?>" size="15" READONLY/>
      </label></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>WO # : </td>
      <td><label>
							<select name="wo_num" id="wo_num" onchange="goWorkOrder(this.value)">
												<option value="" selected="selected"></option>
												
												<?php 
													//fetch work worder from the  new_work_order_main table
													
													$qry="SELECT work_order_id FROM new_work_order_main";
													$qryexecute=mysqli_query($db, $qry);
													while($rs=mysql_fetch_row($qryexecute))
													{
														$work_id=$rs[0];
														echo"<option value='$work_id'>$work_id</option>";
														
													}
												
												
												
												
												
												?>
							
							
							</select>
      </label></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Terms : </td>
      <td><select name="invoice_terms" id="invoice_terms">
        <option value="Net 30">Net 30</option>
        <option value="Prepaid">Prepaid</option>
        <option value="Wire X-Fer">Wire X-Fer</option>
            </select></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Pay Due Date : </td>
      <td><input name="txt_due_date" type="text" id="txt_due_date" size="15"/>
        <a href="javascript:NewCal('txt_due_date','yyyymmdd','true',12)"><img src="cal.gif" alt="calender" width="16" height="16" border="0" /></a></td>
      <td>&nbsp;</td>
      <td>Invoice Amount : </td>
      <td><input name="txt_inv_amount" type="text" id="txt_inv_amount" size="15" READONLY/>
        Tk.. </td>
    </tr>
    <tr>
      <td>PO #: </td>
      <td><input name="txt_po_num" type="text" id="txt_po_num" size="15" /></td>
      <td>&nbsp;</td>
      <td>Payments Received </td>
      <td>
	  <input name="txt_payments_receive" type="text" id="txt_payments_receive" size="15" value="<?php $formatted=number_format($total_amount_receive,2); echo"$formatted"; ?>" READONLY />
        Tk.</td>
    </tr>
    <tr>
      <td>Bill To : </td>
      <td><label>
	    <select name="select_customer" id="select_customer" onchange="goAddress(this.value)">
							  
							  <option value="" selected="selected"></option>
												
												<?php 
													//fetch work worder from the  new_work_order_main table
													
													$qry1="SELECT cust_id,cust_name FROM customer_setup";
													$qryexecute1=mysqli_query($db, $qry1);
													while($rs1=mysql_fetch_row($qryexecute1))
													{
														$cust_id=$rs1[0];
														$cust_name=$rs1[1];
														echo"<option value='$cust_id'>$cust_id -> $cust_name</option>";
														
													}
												
												
												
												
												
												?>

							  
	    </select>
      </label></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><textarea name="txt_area_bill" cols="23" disabled="disabled" id="txt_area_bill"></textarea></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <input name="hid_invoice_amt" type="hidden" id="hid_invoice_amt" />
  <input name="hid_payment_receive_amt" type="hidden" id="hid_payment_receive_amt" />
  <br />  <table width="800" border="0" cellspacing="0" cellpadding="0">
    <tr bgcolor="#33CC33">
      <td width="205"><label>
        <input name="add_part" type="button" id="add_part" value="  Add Payments Received " onclick="javascript:location.href='GenerateInvoice_Payment_Browse.php'"/>
      </label></td>
      <td width="217"><input name="Bsave" type="button" id="Bsave" value=" Save Record  " disabled="disabled" onclick="doFinish(form1)"/></td>
      <td width="205"><input name="close" type="button" id="close" value="   Close   " onclick="javascript:window.close()"/></td>
      <td width="80"><input name="invoice_print" type="button" id="invoice_print" value="   Print   " disabled="disabled"/></td>
      <td width="22">&nbsp;</td>
      <td width="22">&nbsp;</td>
      <td width="22">&nbsp;</td>
      <td width="27">&nbsp;</td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</form>
</body>
</html>

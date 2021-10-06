<?php
include("common.php");
CreateConnection();
//retreive session value which conatins the invoice number which needs to be edited...
session_start();
$e_invoice_num=$_SESSION['edit_invoice_number'];

//fetching record from the invoice_main table based on edited invoice number..
$qry="SELECT * FROM invoice_main where invoice_num='$e_invoice_num'";
$qryexecute=mysqli_query($db, $qry);
$rs=mysql_fetch_row($qryexecute);
	$invoice_num=$rs[0];
	$invoice_date=$rs[1];
	$work_order_id=$rs[2];
	$terms=$rs[3];
	$invoice_pay_due_date1=$rs[4];
	$po=$rs[5];
	$bill_to=$rs[6];
	$invoice_amt=$rs[7];
	//$payment_receive_amt=$rs[8];
	$invoice_notes=$rs[9];
	$closed=$rs[10];
	
	//if invoice_pay_due_date is 0000-00-00(i.e..Null) then set it to blank
	if($invoice_pay_due_date1="0000-00-00")
	{
		$invoice_pay_due_date="";
	}
	
	//format invoice_amt to currency format
	$format_invoice_amt=number_format($invoice_amt,2);
	$format_payment_receive_amt=number_format($payment_receive_amt,2);
	

//calculating payments received...

$qry1="SELECT amount_receive FROM invoice_sub WHERE invoice_num='$e_invoice_num'";
$qryexecute1=mysqli_query($db, $qry1);
while($rs1=mysql_fetch_row($qryexecute1))
{
$total_amount_receive=$total_amount_receive+$rs1[0];

}
	//format payment_receive_amt to currency format
	$format_payment_receive_amt=number_format($total_amount_receive,2);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Edit Invoice - #<?php echo"$invoice_num"; ?></title>

<!-- Javascript for using xmlhttp obects -->
<script src="script.js" type="text/javascript"></script>
<!--  END -->

<!-- Javascript For The Date Retreival(calender)  -->
<script type="text/javascript" language="JavaScript1.2" src="stm32.js"></script>
<script language="javascript" type="text/javascript" src="datetimepicker.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" type="text/javascript" SRC="timepicker.js"></SCRIPT>
<!-- END  -->
<script language="javascript">
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

//store unformmated work order amount(i.e..invoice amount) for further usage(such as..insert into database)..
document.form1.hid_invoice_amt.value='<?php echo $invoice_amt; ?>';

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
</head>

<body onload="addLoadEvent()">
<form id="form1" name="form1" method="post" action="Edit_GenerateInvoice_Medium.php">
  <table width="800" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td bgcolor="#33CC33">Add Invoice # : Details </td>
    </tr>
  </table>
  <input name="hidField" type="hidden" id="hidField" />
  <br />  <table width="800" cellpadding="0" cellspacing="0" bgcolor="#999999">
    <tr>
      <td width="104">Invoice Date : </td>
      <td width="223"><input name="txt_invoice_date" type="text" id="txt_invoice_date" value="<?php echo"$invoice_date"; ?>" size="15" READONLY/>
      <a href="javascript:NewCal('txt_invoice_date','yyyymmdd','true',12)"><img src="cal.gif" alt="calender" width="16" height="16" border="0" /></a></td>
      <td width="50">&nbsp;</td>
      <td width="148">Notes</td>
      <td width="273" rowspan="2"><textarea name="txt_invoice_note" id="txt_invoice_note"><?php echo"$invoice_notes"; ?>
      </textarea></td>
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
														echo"<option value='$work_id'";if($work_id==$work_order_id) echo ' SELECTED ';echo">$work_id</option>";
														
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
        <option value="Net 30" <?php if($terms=='Net 30') echo ' SELECTED '; ?>>Net 30</option>
        <option value="Prepaid" <?php if($terms=='Prepaid') echo ' SELECTED '; ?>>Prepaid</option>
        <option value="Wire X-Fer" <?php if($terms=='Wire X-Fer') echo ' SELECTED '; ?>>Wire X-Fer</option>
            </select></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Pay Due Date : </td>
      <td><input name="txt_due_date" type="text" id="txt_due_date" value="<?php echo"$invoice_pay_due_date"; ?>" size="15"/>
        <a href="javascript:NewCal('txt_due_date','yyyymmdd','true',12)"><img src="cal.gif" alt="calender" width="16" height="16" border="0" /></a></td>
      <td>&nbsp;</td>
      <td>Invoice Amount : </td>
      <td><input name="txt_inv_amount" type="text" id="txt_inv_amount" value="<?php echo"$format_invoice_amt"; ?>" size="15" READONLY/>
        Tk.. </td>
    </tr>
    <tr>
      <td>PO #: </td>
      <td><input name="txt_po_num" type="text" id="txt_po_num" value="<?php echo"$po"; ?>" size="15" /></td>
      <td>&nbsp;</td>
      <td>Payments Received </td>
      <td>
	  <input name="txt_payments_receive" type="text" id="txt_payments_receive" size="15" value="<?php echo("$format_payment_receive_amt"); ?>" READONLY />
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
														echo"<option value='$cust_id'"; if($cust_id==$bill_to) echo ' SELECTED '; echo">$cust_id -> $cust_name</option>";
														
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
      <input name="add_part" type="button" id="add_part" value="  Edit Payments Received " onclick="javascript:location.href='Edit_GenerateInvoice_Payment_Browse.php'"/>
      </label></td>
      <td width="217"><input name="Bsave" type="button" id="Bsave" value=" Save Record  " disabled="disabled" onclick="doFinish(form1)"/></td>
      <td width="205"><input name="close" type="button" id="close" value="   Close   " onclick="javascript:location.href='BrowseInvoice.php'"/></td>
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

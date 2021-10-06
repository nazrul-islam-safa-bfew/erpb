<?php 
include("common.php");
CreateConnection();

// this value is used for tracking which event is occured..
$hid=$_POST['hidField'];
//this code will be executed when the form is submitted to itself.....
//Save Record..//
if($hid==1)
{
$inv_num=$_POST['select_Invoice'];

//holds the current receive amount  
$txt_invoice_amount=$_POST['hid_amount_receive'];

$txt_invoice_receive_date=$_POST['txt_invoice_receive_date'];
$txt_check=$_POST['txt_check'];
$txt_credit_card_no=$_POST['txt_credit_card_no'];
$txt_credit_card_name=$_POST['txt_credit_card_name'];
$select_credit_card_month=$_POST['select_credit_card_month'];
$select_credit_card_year=$_POST['select_credit_card_year'];
$select_credit_card_transaction=$_POST['select_credit_card_transaction'];
$RadioPayment=$_POST['RadioPayment'];
$txt_other=$_POST['txt_other'];

//holds the previous receive amount  before update..
$amount_receive_before_update=$_POST['hid_amount_receive_before_update'];

//calculating total(previous+current) receive amount 
$update_receive_amt=$amount_receive_before_update+$txt_invoice_amount;

//HOLDS invoice_amount of the chosen invoice_num from the INVOICE_MAIN TABLE..
$invoice_amt=$_POST['hid_invoice_amt'];

/*echo"$inv_num<br>";
echo"$txt_invoice_amount<br>";
echo"$txt_invoice_receive_date<br>";
echo"$txt_check<br>";
echo"$txt_credit_card_no<br>";
echo"$txt_credit_card_name<br>";
echo"$select_credit_card_month<br>";
echo"$select_credit_card_year<br>";
echo"$select_credit_card_transaction<br>";
echo"$RadioPayment<br>";
echo"$txt_other<br>";
echo"$amount_receive_before_update<br>";
echo"$update_receive_amt<br>";
*/
//------------------------------start transaction-----------------
mysqli_query($db, "BEGin;"); 
// Update data in the invoice_main table corresponding to the selected invoice number..
$qry1="UPDATE invoice_main SET payment_receive_amt='$update_receive_amt' WHERE invoice_num='$inv_num'";
$qryexecute1=mysqli_query($db, $qry1);

//check wheather the invoice_amt and the payment_receive_amt is equal in the invoice_main table after update is done.if so then set closed(in invoice_main table) field value to 1.i.e invoice is closed now.
if($invoice_amt=$update_receive_amt)
{
$qry2="UPDATE invoice_main SET closed='1' WHERE invoice_num='$inv_num'";
$qryexecute2=mysqli_query($db, $qry2);
}

//insert data into invoice_sub table
$qry="INSERT INTO invoice_sub(invoice_num, amount_receive, date_receive, payment_method, check_num, credit_card_num, credit_card_name, credit_card_expire_mo,credit_card_expire_year, credit_card_transaction, other_mode_of_payment) VALUES ('$inv_num','$txt_invoice_amount','$txt_invoice_receive_date','$RadioPayment','$txt_check','$txt_credit_card_no','$txt_credit_card_name','$select_credit_card_month','$select_credit_card_year','$select_credit_card_transaction','$txt_other')";
$qryexecute=mysqli_query($db, $qry);

mysqli_query($db, "COMMIT;");  
mysqli_query($db, "ROLLBACK;");

//--------------END TRANSACTION----------------------------
 
header("Location: Browse_invoice_Payments.php?count=1");
}
//select records corresponding the selected invoice number from invoice_main table
else if($hid==2)
{
$inv_number=$_POST['select_Invoice'];
$qry="SELECT invoice_amt,payment_receive_amt FROM invoice_main WHERE invoice_num='$inv_number'";
$qryexecute=mysqli_query($db, $qry);
$rs=mysql_fetch_row($qryexecute);
$invoice_amt=$rs[0];
$payment_receive_amt=$rs[1];
$due_payment=$invoice_amt-$payment_receive_amt;
}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Add Payment </title>
<!-- Javascript For The Date Retreival(calender)  -->
<script type="text/javascript" language="JavaScript1.2" src="stm32.js"></script>
<script language="javascript" type="text/javascript" src="datetimepicker.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" type="text/javascript" SRC="timepicker.js"></SCRIPT>
<!-- END  -->

<script language="javascript">
//this function will be executed when the form is loaded...
function goHold()
{
//holds unformatted due payment..in the case if the user don't change the payment receive text box's value..
document.form1.hid_amount_receive.value='<?php echo($due_payment); ?> ';

//HOLDS PAYMENTS RECEIVE AMOUNT BEFORE A PARTICULAR INVOICE IS UPDATED IN THE INVOICE_MAIN TABLE..
document.form1.hid_amount_receive_before_update.value='<?php echo($payment_receive_amt); ?> ';

//HOLDS invoice_amount of the chosen invoice_num from the INVOICE_MAIN TABLE..
document.form1.hid_invoice_amt.value='<?php echo($invoice_amt); ?> ';


}

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



function validate(form1)
{
if(form1.txt_invoice_amount.value=="")
{
alert("Please Enter Amount For Invoice.");
document.form1.txt_invoice_amount.focus();
return false;
}
else if(form1.txt_invoice_receive_date.value=="")
{
alert("Please Enter Receive Date.");
document.form1.txt_invoice_receive_date.focus();
return false;
}
else if(form1.select_Invoice.value=="")
{
alert("You have to select an invoice number befor the data can be saved.");
document.form1.select_Invoice.focus();
return false;
}
/*else if(isNaN(form1.txt_credit_card_name.value)==false)
{
alert("Invalid Name!Please Enter Valid Name For The Credit Card Holder.");
document.form1.txt_credit_card_name.focus();
return false;
}
*/
return true;
}

//submiting form
function doFinish(form1)
{
if(validate(form1)==true)
{
document.form1.hidField.value=1;
document.form1.submit();
}

}

//  ENEBLE CREDIT CARD OPTION'S CONTROLS..//
function goCredit()
{
//enable controls under credit card option
document.form1.txt_credit_card_no.disabled=false;
document.form1.txt_credit_card_name.disabled=false;
document.form1.select_credit_card_month.disabled=false;
document.form1.select_credit_card_year.disabled=false;
document.form1.select_credit_card_transaction.disabled=false;
//focusing txt_credit_card_no text box
document.form1.txt_credit_card_no.focus();
//Disable others control under payment method...//
document.form1.txt_check.disabled=true;
document.form1.txt_other.disabled=true;
}

//  ENEBLE CHECK OPTION'S CONTROLS..//
function goCheck()
{
//enable controls under check option
document.form1.txt_check.disabled=false;
//focusing txt_check text box
document.form1.txt_check.focus();

//Disable others control under payment method...//
document.form1.txt_credit_card_no.disabled=true;
document.form1.txt_credit_card_name.disabled=true;
document.form1.select_credit_card_month.disabled=true;
document.form1.select_credit_card_year.disabled=true;
document.form1.select_credit_card_transaction.disabled=true;
document.form1.txt_other.disabled=true;
}

//FOR ELECTRONIC PAYMENT OPTION
function goElectronic()
{
//Disable all control under payment method...//
document.form1.txt_check.disabled=true;
document.form1.txt_credit_card_no.disabled=true;
document.form1.txt_credit_card_name.disabled=true;
document.form1.select_credit_card_month.disabled=true;
document.form1.select_credit_card_year.disabled=true;
document.form1.select_credit_card_transaction.disabled=true;
document.form1.txt_other.disabled=true;
}

//  ENEBLE other OPTION'S CONTROLS..//
function goOther()
{
//enable controls under other option
document.form1.txt_other.disabled=false;
//focusing txt_other text box
document.form1.txt_other.focus();

//Disable others control under payment method...//
document.form1.txt_credit_card_no.disabled=true;
document.form1.txt_credit_card_name.disabled=true;
document.form1.select_credit_card_month.disabled=true;
document.form1.select_credit_card_year.disabled=true;
document.form1.select_credit_card_transaction.disabled=true;
}
//--------------------------------END----------------------------//


//format inserted invoice amount...
function goAmtChange(m)
{ 
if(isNaN(m))
{
alert("Invalid Invoice Amount!Please Enter Number.");
document.form1.txt_invoice_amount.focus();
}
//if amount receive is less than hundred then only floating point conversion is done
else if(m<100)
{
//holds unformatted invoice amount for inserting into database..
document.form1.hid_amount_receive.value=m;
//display formated invoice amount..
document.form1.txt_invoice_amount.value=CurrencyFormatted(m);;
}
//both floating point+currencyformat is done
else
{
//holds unformatted invoice amount for inserting into database..
document.form1.hid_amount_receive.value=m;
//display formated invoice amount..
document.form1.txt_invoice_amount.value=fmtMoney(CurrencyFormatted(m), 2, '.', ',' );
}
}

// check wheather the entered credit card name is character data or not...
function go_check_name()
{
if(isNaN(form1.txt_credit_card_name.value)==false)
{
alert("Invalid Name!Please Enter Valid Name For The Credit Card Holder.");
document.form1.txt_credit_card_name.focus();
}
}

//select records corresponding the selected invoice number from invoice_main table
function goSelect(m)
{
//submitting form....
document.form1.hidField.value=2;
document.form1.submit();
}
</script>
<link href="common.css" rel="stylesheet" type="text/css" />
</head>

<body onload="goHold()">
<form id="form1" name="form1" method="post" action="">
  <table width="434" border="0" cellpadding="0" cellspacing="0" bgcolor="#999999">
    <tr>
      <td width="141">Invoice #: </td>
      <td width="293"><label>
		<select name="select_Invoice" id="select_Invoice" onchange="goSelect(this.value)">
		  <option value=""></option>
						
								<?php 
									//fetch invoice from invoice_mail table...
									$qry="SELECT invoice_num FROM invoice_main";
									$qryexecute=mysqli_query($db, $qry);
									while($rs=mysql_fetch_row($qryexecute))
									{
										$inv_num=$rs[0];
										
										//creating option's dynamically....
										echo"<option value='$inv_num'"; if($inv_num==$inv_number) echo ' SELECTED '; echo">$inv_num</option>";
									}
								
								?>
						
						
		</select>
      </label></td>
    </tr>
    <tr>
      <td>Amount Received: </td>
      <td><input name="txt_invoice_amount" type="text" id="txt_invoice_amount" size="40" value="<?php $formatted=number_format($due_payment); echo $formatted; ?>" onchange="goAmtChange(this.value)"/></td>
    </tr>
    <tr>
      <td>Date Received: </td>
      <td><input name="txt_invoice_receive_date" type="text" id="txt_invoice_receive_date" size="40" READONLY/>
        <a href="javascript:NewCal('txt_invoice_receive_date','yyyymmdd','true',12)"><img src="cal.gif" alt="calender" width="16" height="16" border="0" /></a></td>
    </tr>
  </table>
  <input name="hidField" type="hidden" id="hidField" />
  <br />
  <table width="419" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th width="419" bgcolor="#33CC33" scope="col"><div align="left">Payment Method </div></th>
    </tr>
    <tr bgcolor="#990000">
      <td><table width="434" border="0" cellpadding="0" cellspacing="0" bgcolor="#999999">
        
        <tr>
          <td width="167"><p>
            <label></label>
            <label>
            <input name="RadioPayment" type="radio" value="Check" onclick="goCheck()"/>
            Check #:            </label>
            <label></label>
            <br />
            <label></label>
            <label></label>
            <br />
          </p></td>
          <td colspan="3"><input name="txt_check" type="text" id="txt_check" size="35" disabled="disabled"/></td>
          </tr>
        <tr>
          <td><label></label></td>
          <td width="108">&nbsp;</td>
          <td width="33">&nbsp;</td>
          <td width="109">&nbsp;</td>
          </tr>
        <tr>
          <td><input type="radio" name="RadioPayment" value="Credit Card" onclick="goCredit()"/>
          Credit Card #: </td>
          <td colspan="3"><input name="txt_credit_card_no" type="text" id="txt_credit_card_no" size="35" disabled="disabled"/></td>
          </tr>
        <tr>
          <td><div align="right">Name On Card: </div></td>
          <td colspan="3"><input name="txt_credit_card_name" type="text" id="txt_credit_card_name" size="35" disabled="disabled" onchange="go_check_name()"/></td>
          </tr>
        <tr>
          <td><div align="right">Expiration Mo: </div></td>
          <td><label>
            <select name="select_credit_card_month" disabled="disabled" id="select_credit_card_month">
              <option value="" selected="selected"></option>
              <option value="January">January</option>
              <option value="February">February</option>
              <option value="March">March</option>
              <option value="April">April</option>
              <option value="May">May</option>
              <option value="June">June</option>
              <option value="July">July</option>
              <option value="August">August</option>
              <option value="September">September</option>
              <option value="Octobar">Octobar</option>
              <option value="November">November</option>
              <option value="December">December</option>
            </select>
          </label></td>
          <td>Year</td>
          <td><select name="select_credit_card_year" disabled="disabled" id="select_credit_card_year">
              <option value="" selected="selected"></option>
            <option value="2007">2007</option>
            <option value="2008">2008</option>
            <option value="2009">2009</option>
            <option value="2010">2010</option>
            <option value="2011">2011</option>
            <option value="2012">2012</option>
            <option value="2013">2013</option>
            <option value="2014">2014</option>
            <option value="2015">2015</option>
            <option value="2016">2016</option>
            <option value="2017">2017</option>
            <option value="2018">2018</option>
            <option value="2019">2019</option>
            <option value="2020">2020</option>
            <option value="2021">2021</option>
            <option value="2022">2022</option>
            <option value="2023">2023</option>
            <option value="2024">2024</option>
            <option value="2025">2025</option>
                              </select></td>
          </tr>
        <tr>
          <td><div align="right">Transaction</div></td>
          <td colspan="3"><input name="select_credit_card_transaction" type="text" id="select_credit_card_transaction" size="35" disabled="disabled"/></td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td><label>
            <input type="radio" name="RadioPayment" value="Electronic Transfer" onclick="goElectronic()"/>
            Electronic Transfer: 
          </label></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td><label>
            <input type="radio" name="RadioPayment" value="Other" onclick="goOther()"/>
            Other:
          </label></td>
          <td colspan="3"><input name="txt_other" type="text" id="txt_other" size="35" disabled="disabled"/></td>
          </tr>
		   <tr bgcolor="#33CC33">
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
      </table></td>
    </tr>
  </table>
  <input name="hid_amount_receive" type="hidden" id="hid_amount_receive" />
  <input name="hid_amount_receive_before_update" type="hidden" id="hid_amount_receive_before_update" />
  <input name="hid_invoice_amt" type="hidden" id="hid_invoice_amt" />
  <br />
  <table width="434" border="0" cellpadding="0" cellspacing="0" bgcolor="#990000">
    <tr>
      <th scope="col">&nbsp;</th>
      <th scope="col"><label>
        <input name="Bsave" type="button" id="Bsave" value="    Save    " onclick="doFinish(form1)"/>
      </label></th>
      <th scope="col">&nbsp;</th>
      <th scope="col"><label>
      <input name="Bclose" type="button" id="Bclose" value="    Close    " onclick="javascript:location.href='Browse_invoice_Payments.php?count=' + 1"/>
      </label></th>
    </tr>
  </table>
</form>
</body>
</html>

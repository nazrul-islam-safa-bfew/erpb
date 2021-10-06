<?php 
include("common.php");
CreateConnection();
//retreive session value which conatins the invoice number which needs to be edited...
session_start();
$e_invoice_num=$_SESSION['edit_invoice_number'];

//this portion of code will be executed when the form is loaded to display individual payment record of the invoice which is needed to be changed...
$transaction_id=$_GET['trans_id'];
session_start();
$_SESSION['trans_id']=$transaction_id;


$qry="SELECT amount_receive, date_receive, payment_method, check_num, credit_card_num, credit_card_name, credit_card_expire_mo, credit_card_expire_year, credit_card_transaction, other_mode_of_payment FROM invoice_sub WHERE trans_id='$transaction_id' ";
$qryexecute=mysqli_query($db, $qry);
$rs=mysql_fetch_row($qryexecute);
$amount_receive1=$rs[0];
$date_receive=$rs[1];
$payment_method=$rs[2];
$check_num=$rs[3];
$credit_card_num=$rs[4];
$credit_card_name=$rs[5];
$credit_card_expire_mo=$rs[6];
$credit_card_expire_year=$rs[7];
$credit_card_transaction=$rs[8];
$other_mode_of_payment=$rs[9];

//formating amount receive to currency format.....
$amount_receive=number_format($amount_receive1,2);
//--------------------------------------------END....................................................//
//assign hidden value to check wheather it is Update or DElete..
$hid=$_POST['hidField'];
//this code will be executed when the form is submitted to itself.....

//......UPDATE RECORD..............//
if($hid==1)
{
//retreiving transaction id from the session...///
session_start();
$trans_id=$_SESSION['trans_id'];

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

/*echo"$trans_id<br>";
echo"$invoice_num<br>";
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
*/
$qry="UPDATE invoice_sub SET amount_receive='$txt_invoice_amount',date_receive='$txt_invoice_receive_date',payment_method='$RadioPayment',check_num='$txt_check',credit_card_num='$txt_credit_card_no',credit_card_name='$txt_credit_card_name',credit_card_expire_mo='$select_credit_card_month',credit_card_expire_year='$select_credit_card_year',credit_card_transaction='$select_credit_card_transaction',other_mode_of_payment='$txt_other' WHERE trans_id='$trans_id'";

$qryexecute=mysqli_query($db, $qry);
//check wheather the query is executed or not...
if($qryexecute)
{
header("Location: Edit_GenerateInvoice_Payment_Browse.php?count=1");
}
}
//------DELETE RECORD-----//
else if($hid==2)
{
//retreiving transaction id from the session...///
session_start();
$trans_id=$_SESSION['trans_id'];
$qry1="DELETE FROM invoice_sub WHERE trans_id='$trans_id'";
$qryexecute1=mysqli_query($db, $qry1);
if($qryexecute1)
{
header("Location: Edit_GenerateInvoice_Payment_Browse.php?count=1");
}
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Edit - Invoice#<?php echo"$e_invoice_num"; ?></title>
<!-- Javascript For The Date Retreival(calender)  -->
<script type="text/javascript" language="JavaScript1.2" src="stm32.js"></script>
<script language="javascript" type="text/javascript" src="datetimepicker.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" type="text/javascript" SRC="timepicker.js"></SCRIPT>
<!-- END  -->

<script language="javascript">
//  this function executed when the form is loaded to hold the unformatted amount receive which is used to insert into database..
function set_receive_amount()
{
document.form1.hid_amount_receive.value='<?php echo $amount_receive1; ?>';
//alert(document.form1.hid_amount_receive.value);
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
	//if(isNaN(i)) { i = 0.00; }
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
/*else if(isNaN(form1.txt_invoice_amount.value))
{
alert("Invalid Invoice Amount!Please Enter Number.");
document.form1.txt_invoice_amount.focus();
return false;
}*/
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

function goAmtChange(m)
{ 
if(isNaN(m))
{
alert("Invalid Invoice Amount!Please Enter Number.");
document.form1.txt_invoice_amount.focus();
}
//if amount receive is less than 100 then only format it to floating point format not currency format..
else if(m<100)
{
//store the unformatted(i.e without  and .00) amount receive cost in hidden variable for inserting into dtabase
document.form1.hid_amount_receive.value=m;
//display formatted freight cost...
document.form1.txt_freight_cost.value=CurrencyFormatted(m);
}
//floating+currency format...
else
{
//store the unformatted(i.e without  and .00) amount receive cost in hidden variable for inserting into dtabase
document.form1.hid_amount_receive.value=m;
// converts integer number to floating point number...
var formatted=CurrencyFormatted(m);
//format floating point number to currency format...
var amount=fmtMoney(formatted, 2, '.', ',' );
document.form1.txt_invoice_amount.value=amount;
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

//USED TO DELETE RECORD
function goDelete()
{
if(confirm("Do You Want To Delete The Record?")==true)
{
document.form1.hidField.value=2;
document.form1.submit();
}
}


</script>
</head>

<body onload="set_receive_amount()">
<form id="form1" name="form1" method="post" action="">
  <table width="434" border="0" cellpadding="0" cellspacing="0" bgcolor="#999999">
    <tr>
      <td width="141">Invoice #: </td>
      <td width="293"><input name="txt_invoice_no" type="text" id="txt_invoice_no" value="<?php echo"$e_invoice_num"; ?>" size="40" READONLY/></td>
    </tr>
    <tr>
      <td>Amount Received: </td>
      <td><input name="txt_invoice_amount" type="text" id="txt_invoice_amount" onchange="goAmtChange(this.value)" value="<?php echo"$amount_receive"; ?>" size="40"/></td>
    </tr>
    <tr>
      <td>Date Received: </td>
      <td><a href="javascript:NewCal('txt_invoice_receive_date','yyyymmdd','true',12)">
            <input name="txt_invoice_receive_date" type="text" id="txt_invoice_receive_date" value="<?php echo"$date_receive"; ?>" size="40" readonly/>
      <img src="cal.gif" alt="calender" width="16" height="16" border="0" /></a></td>
    </tr>
  </table>
  <input name="hidField" type="hidden" id="hidField" />
  <input name="hid_amount_receive" type="hidden" id="hid_amount_receive" />
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
            <input name="RadioPayment" type="radio" onclick="goCheck()" value="Check" <?php if($payment_method=="Check") echo ' checked '; ?>/>
            Check #:            </label>
            <label></label>
            <br />
            <label></label>
            <label></label>
            <br />
          </p></td>
          <td colspan="3"><input name="txt_check" type="text" id="txt_check" value="<?php echo"$check_num"; ?>" size="35"/></td>
        </tr>
        <tr>
          <td><label></label></td>
          <td width="108">&nbsp;</td>
          <td width="33">&nbsp;</td>
          <td width="109">&nbsp;</td>
          </tr>
        <tr>
          <td><input name="RadioPayment" type="radio" onclick="goCredit()" value="Credit Card" <?php if($payment_method=="Credit Card") echo ' checked '; ?>/>
          Credit Card #: </td>
          <td colspan="3"><input name="txt_credit_card_no" type="text" id="txt_credit_card_no" value="<?php echo"$credit_card_num"; ?>" size="35"/></td>
          </tr>
        <tr>
          <td><div align="right">Name On Card: </div></td>
          <td colspan="3"><input name="txt_credit_card_name" type="text" id="txt_credit_card_name" onchange="go_check_name()" value="<?php echo"$credit_card_name"; ?>" size="35"/></td>
          </tr>
        <tr>
          <td><div align="right">Expiration Mo: </div></td>
          <td><label>
            <select name="select_credit_card_month" id="select_credit_card_month">
              <option value="" selected="selected"></option>
              <option value="January" <?php if($credit_card_expire_mo=="January") echo ' SELECTED '; ?>>January</option>
              <option value="February" <?php if($credit_card_expire_mo=="February") echo ' SELECTED '; ?>>February</option>
              <option value="March" <?php if($credit_card_expire_mo=="March") echo ' SELECTED '; ?>>March</option>
              <option value="April" <?php if($credit_card_expire_mo=="April") echo ' SELECTED '; ?>>April</option>
              <option value="May" <?php if($credit_card_expire_mo=="May") echo ' SELECTED '; ?>>May</option>
              <option value="June" <?php if($credit_card_expire_mo=="June") echo ' SELECTED '; ?>>June</option>
              <option value="July" <?php if($credit_card_expire_mo=="July") echo ' SELECTED '; ?>>July</option>
              <option value="August" <?php if($credit_card_expire_mo=="August") echo ' SELECTED '; ?>>August</option>
              <option value="September" <?php if($credit_card_expire_mo=="September") echo ' SELECTED '; ?>>September</option>
              <option value="Octobar" <?php if($credit_card_expire_mo=="Octobar") echo ' SELECTED '; ?>>Octobar</option>
              <option value="November" <?php if($credit_card_expire_mo=="November") echo ' SELECTED '; ?>>November</option>
              <option value="December" <?php if($credit_card_expire_mo=="December") echo ' SELECTED '; ?>>December</option>
            </select>
          </label></td>
          <td>Year</td>
          <td><select name="select_credit_card_year" id="select_credit_card_year">
              <option value="" selected="selected"></option>
            <option value="2007" <?php if($credit_card_expire_year=="2007") echo ' SELECTED '; ?>>2007</option>
            <option value="2008" <?php if($credit_card_expire_year=="2008") echo ' SELECTED '; ?>>2008</option>
            <option value="2009" <?php if($credit_card_expire_year=="2009") echo ' SELECTED '; ?>>2009</option>
            <option value="2010" <?php if($credit_card_expire_year=="2010") echo ' SELECTED '; ?>>2010</option>
            <option value="2011" <?php if($credit_card_expire_year=="2011") echo ' SELECTED '; ?>>2011</option>
            <option value="2012" <?php if($credit_card_expire_year=="2012") echo ' SELECTED '; ?>>2012</option>
            <option value="2013" <?php if($credit_card_expire_year=="2013") echo ' SELECTED '; ?>>2013</option>
            <option value="2014" <?php if($credit_card_expire_year=="2014") echo ' SELECTED '; ?>>2014</option>
            <option value="2015" <?php if($credit_card_expire_year=="2015") echo ' SELECTED '; ?>>2015</option>
            <option value="2016" <?php if($credit_card_expire_year=="2016") echo ' SELECTED '; ?>>2016</option>
            <option value="2017" <?php if($credit_card_expire_year=="2017") echo ' SELECTED '; ?>>2017</option>
            <option value="2018" <?php if($credit_card_expire_year=="2018") echo ' SELECTED '; ?>>2018</option>
            <option value="2019" <?php if($credit_card_expire_year=="2019") echo ' SELECTED '; ?>>2019</option>
            <option value="2020" <?php if($credit_card_expire_year=="2020") echo ' SELECTED '; ?>>2020</option>
            <option value="2021" <?php if($credit_card_expire_year=="2021") echo ' SELECTED '; ?>>2021</option>
            <option value="2022" <?php if($credit_card_expire_year=="2022") echo ' SELECTED '; ?>>2022</option>
            <option value="2023" <?php if($credit_card_expire_year=="2023") echo ' SELECTED '; ?>>2023</option>
            <option value="2024" <?php if($credit_card_expire_year=="2024") echo ' SELECTED '; ?>>2024</option>
            <option value="2025" <?php if($credit_card_expire_year=="2025") echo ' SELECTED '; ?>>2025</option>
                              </select></td>
          </tr>
        <tr>
          <td><div align="right">Transaction</div></td>
          <td colspan="3"><input name="select_credit_card_transaction" type="text" id="select_credit_card_transaction" value="<?php echo"$credit_card_transaction"; ?>" size="35"/></td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td><label>
            <input type="radio" name="RadioPayment" value="Electronic Transfer" onclick="goElectronic()" <?php if($payment_method=="Electronic Transfer") echo ' checked '; ?>/>
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
            <input type="radio" name="RadioPayment" value="Other" onclick="goOther()" <?php if($payment_method=="Other") echo ' checked '; ?>/>
            Other:
          </label></td>
          <td colspan="3"><input name="txt_other" type="text" id="txt_other" value="<?php echo"$other_mode_of_payment"; ?>" size="35"/></td>
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
 <br />
  <table width="434" border="0" cellpadding="0" cellspacing="0" bgcolor="#990000">
    <tr>
      <th width="23" scope="col">&nbsp;</th>
      <th width="94" scope="col"><label>
        <input name="Bupdate" type="button" id="Bupdate" value="    Update    " onclick="doFinish(form1)"/>
      </label></th>
      <th width="188" scope="col"><label>
        <center><input name="Bdelete" type="button" id="Bdelete" value="   Delete   " onclick="goDelete()"/></center>
      </label></th>
      <th width="129" scope="col"><label>
      <input name="Bclose" type="button" id="Bclose" value="    Close    " onclick="javascript:location.href='GenerateInvoice_Payment_Browse.php'"/>
      </label></th>
    </tr>
  </table>
</form>
</body>
</html>

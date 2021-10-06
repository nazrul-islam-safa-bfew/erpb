<?php 
include("common.php");
CreateConnection();
//retreiving invoice number from the session...//
session_start();
$invoice_num=$_SESSION['invoice_number'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Add  Invoice - #<?php echo"$invoice_num"; ?></title>
<script language="javascript">

//EXECUTED WHEN THE FORM IS LOADED----Check wheather a payent is added for the invoice or not.If added,then enable the EDIT,DELETE and Save button.
function addLoadEvent()
{
var counter='<?php echo $_GET['count']; ?>';
if(counter==1)
{
document.form1.Bsave.disabled=false;
document.form1.Bprint.disabled=false;
}
}
//---------------------END..............//

//Edit Record..//
function goEdit(m)
{
location.href='GenerateInvoice_Payment_Edit.php?trans_id=' + m;
}


//Tracking save button click event and go to the GenerateInvoice.php page Record..//
function goSave(m)
{
var l=1;
location.href='GenerateInvoice.php?count=' + l;
}

</script>
</head>

<body onload="addLoadEvent()">
<form id="form1" name="form1" method="post" action="">
  <table width="1200" border="1" cellspacing="0" cellpadding="0">
    <tr bgcolor="#33CC33">
      <td width="124">Date Received </td>
      <td width="132">Amount Received </td>
      <td width="141">Payment Method </td>
      <td width="108">Check # </td>
      <td width="113">Card No </td>
      <td width="145">Card Name </td>
      <td width="131">Expiration Month </td>
      <td width="125">Expiration Year </td>
      <td width="161">Transaction # </td>
    </tr>
	
										<?php 
										
										/*(, amount_receive, date_receive, payment_method, check_num, credit_card_num, credit_card_name, credit_card_expire_mo,credit_card_expire_year, credit_card_transaction, other_mode_of_payment*/
										
											//DISPLAING RECORD FOR THE CURRENT INVOICE FROM THE  TABLE invoice_sub.../
											$qry="SELECT * FROM invoice_sub WHERE invoice_num='$invoice_num'";
											$qryexecute=mysqli_query($db, $qry);
											while($rs=mysql_fetch_row($qryexecute))
												{
													$trans_id=$rs[0];
													$invoice_num=$rs[1];
													$amount_receive=$rs[2];
													$date_receive=$rs[3];
													$payment_method=$rs[4];
													$check_num=$rs[5];
													$credit_card_num=$rs[6];
													$credit_card_name=$rs[7];
													$credit_card_expire_mo=$rs[8];
													$credit_card_expire_year=$rs[9];
													$credit_card_transaction=$rs[10];
													
													//fomating $amount_receive value to currency format
													$formatted_amount_receive=number_format($amount_receive,2);
													echo"<tr ondblclick='goEdit($trans_id)'>
															<td>$date_receive</td>
															<td>$formatted_amount_receive</td>
															<td>$payment_method</td>
															<td>$check_num</td>
															<td>$credit_card_num</td>
															<td>$credit_card_name</td>
															<td>$credit_card_expire_mo</td>
															<td>$credit_card_expire_year</td>
															<td>$credit_card_transaction</td>
														</tr>";

												}
										
										?>
	
  </table>
  <p>&nbsp;</p>
  <table width="1200" cellspacing="0" cellpadding="0">
    <tr bgcolor="#33CC33">
      <td width="98">&nbsp;</td>
      <td width="110"><label>
      <input name="Badd" type="button" id="Badd" value="Add Payment" onclick="javascript:location.href='GenerateInvoice_Payment_Add.php'"/>
      </label></td>
      <td width="199">&nbsp;</td>
      <td width="76"><label>
      <input name="Bsave" type="button" id="Bsave" value="    Save    " disabled="disabled" onclick="goSave()"/>
      </label></td>
      <td width="92">&nbsp;</td>
      <td width="100"><label></label></td>
      <td width="31">&nbsp;</td>
      <td width="162"><label>
      <input name="Bprint" type="submit" id="Bprint" value="    Print    " disabled="disabled"/>
      </label></td>
      <td width="330">&nbsp;</td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</form>
</body>
</html>

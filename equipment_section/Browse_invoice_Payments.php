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
<title>Payments Received</title>
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
location.href='Browse_invoice_Payments_Edit.php?trans_id=' + m;
}



</script>
<link href="common.css" rel="stylesheet" type="text/css" />
</head>

<body onload="addLoadEvent()">
<form id="form1" name="form1" method="post" action="">
  <table width="1564" border="1" cellspacing="0" cellpadding="0">
    <tr bgcolor="#33CC33">
      <th width="124" height="26">Date Received </th>
      <th width="132">Invoice # </th>
      <th width="100">Amount</th>
      <th width="149">Payment Method </th>
      <th width="113">Check # </th>
      <th width="145">Card</th>
      <th width="186">Name On Card </th>
      <th width="114">Exp Month </th>
      <th width="117">Exp Year </th>
      <th width="161">Transaction # </th>
      <th width="199">Other Payment Method </th>
    </tr>
	
										<?php 
										
										/*(, amount_receive, date_receive, payment_method, check_num, credit_card_num, credit_card_name, credit_card_expire_mo,credit_card_expire_year, credit_card_transaction, other_mode_of_payment*/
										
											//DISPLAING RECORD FOR THE CURRENT INVOICE FROM THE  TABLE invoice_sub.../
											$qry="SELECT * FROM invoice_sub";
											$qryexecute=mysqli_query($db, $qry);
											
											//count number of record returned by the above query..
												$count=mysql_num_rows($qryexecute);
											
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
													$other_mode_of_payment=$rs[11];
													//fomating $amount_receive value to currency format
													$formatted_amount_receive=number_format($amount_receive,2);
													echo"<tr ondblclick='goEdit($trans_id)'>
															<td>$date_receive</td>
															<td>$invoice_num</td>
															<td>$formatted_amount_receive</td>
															<td>$payment_method</td>
															<td>$check_num</td>
															<td>$credit_card_num</td>
															<td>$credit_card_name</td>
															<td>$credit_card_expire_mo</td>
															<td>$credit_card_expire_year</td>
															<td>$credit_card_transaction</td>
															<td>$other_mode_of_payment</td>
														</tr>";

												}
										
										?>
  </table>
  <p>&nbsp;</p>
  <table width="1200" cellspacing="0" cellpadding="0">
    <tr bgcolor="#33CC33">
      <th width="298"><?php echo("$count"); ?> Invoice Payments Listed</th>
      <th width="159"><label>
      <input name="Badd" type="button" id="Badd" value="Add Payment" onclick="javascript:location.href='Browse_invoice_Payments_Add.php'"/>
      </label></th>
      <th width="192"><label>
      <input name="Bclose" type="button" id="Bclose" value="    Close    "  onclick="javascript:window.close()"/>
      </label></th>
      <th width="236"><label>
      <input name="Bprint" type="button" id="Bprint" value="    Print    " onclick="javascript:window.print()"/>
      </label></th>
      <th width="313">&nbsp;</th>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</form>
</body>
</html>

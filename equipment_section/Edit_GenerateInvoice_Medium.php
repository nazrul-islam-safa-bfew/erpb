<?php
include("common.php");
CreateConnection();
//receiving posted hidden value
$hid=$_POST['hidField'];
//............UPDATE the edited record in the invoice_main table...
if($hid==1)
{
//retreive session value which conatins the invoice number which needs to be edited...
session_start();
$e_invoice_num=$_SESSION['edit_invoice_number'];

//assigning posted value to the variable..
$txt_invoice_date=$_POST['txt_invoice_date'];
$wo_num=$_POST['wo_num'];
$invoice_terms=$_POST['invoice_terms'];
$txt_due_date=$_POST['txt_due_date'];
$txt_po_num=$_POST['txt_po_num'];
$select_customer=$_POST['select_customer'];
$txt_purchase_note=$_POST['txt_purchase_note'];
$txt_invoice_note=$_POST['txt_invoice_note'];
//assigning hidden variable value which contains unformateed values
$txt_inv_amount=$_POST['hid_invoice_amt'];
$txt_payments_receive=$_POST['hid_payment_receive_amt'];
/*
echo"$txt_invoice_date<br>";
echo"$wo_num<br>";
echo"$invoice_terms<br>";
echo"$txt_due_date<br>";
echo"$txt_po_num<br>";
echo"$select_customer<br>";
echo"$txt_purchase_note<br>";
echo"$txt_invoice_note<br>";
echo"$txt_invoice_date<br>";
echo"Invoice:$txt_inv_amount<br>";
echo"Receive:$txt_payments_receive<br>";
*/
//check wheathe a full payment or partial payment is done.if full payment then the closed field(in invoice_main table) value is set to 1(i.e..close==true).if partial payment then the closed field value is set to 0(i.e..close==false)
if($txt_inv_amount==$txt_payments_receive)
{
$closed=1;
}
else
{
$closed=0;
}
 
$qry="UPDATE invoice_main SET invoice_date='$txt_invoice_date', work_order_id='$wo_num', terms='$invoice_terms', invoice_pay_due_date='$txt_due_date', po='$txt_po_num', bill_to='$select_customer', invoice_amt='$txt_inv_amount', payment_receive_amt='$txt_payments_receive',invoice_notes='$txt_invoice_note',closed='$closed' WHERE invoice_num='$e_invoice_num'"; 

$qryexecute=mysqli_query($db, $qry);
if($qryexecute)
{
header("Location: BrowseInvoice.php");
}
else
{
echo("Could Not Connect To The Database.");
}
}

?>
<?php
include("common.php");
CreateConnection();
//receiving posted hidden value
$hid=$_POST['hidField'];
//Insert record to the invoice_main table...
if($hid==1)
{
//retreive session value which conatins the invoice number...
session_start();
$invoice_num=$_SESSION['invoice_number'];

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

//check wheathe a full payment or partial payment is done.if full payment then the closed field(in invoice_main table) value is set to 1(i.e..close==true).if partial payment then the closed field value is set to 0(i.e..close==false)
if($txt_inv_amount==$txt_payments_receive)
{
$closed=1;
}
else
{
$closed=0;
}

$qry="INSERT INTO invoice_main(invoice_num, invoice_date, work_order_id, terms, invoice_pay_due_date, po, bill_to, invoice_amt, payment_receive_amt,invoice_notes,closed) VALUES ('$invoice_num','$txt_invoice_date','$wo_num','$invoice_terms','$txt_due_date','$txt_po_num','$select_customer','$txt_inv_amount','$txt_payments_receive','$txt_invoice_note','$closed')";
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
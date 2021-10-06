<?php 
include("common.php");
CreateConnection();
//retreiving PO number from the session initiated at Browse_Purchase_Order_Medium.php page
session_start();
$po_num=$_SESSION['PO'];
//------------------------Hidden Field Value Association------------------
$hidden=$_POST['hidField'];
//--Validating which button is clicked//
//EDit Parts already added to the purchase order
if($hidden==1)
{
header("Location: purchaseOrder_Parts_Managment_Edit.php");
}
 //--Update THE RECORD--//
else if($hidden==2)
{
//---Assigning posted value to the variable--//
$txt_po_issued_date=$_POST['txt_po_issued_date']; 
$txt_po=$_POST['txt_po']; 
$txt_required_date=$_POST['txt_required_date']; 
$txt_buyer_name=$_POST['txt_buyer_name']; 
$txt_ship=$_POST['txt_ship']; 
$RadioGroup1=$_POST['RadioGroup1']; 
$txt_closed_date=$_POST['txt_closed_date']; 
$selectTerms=$_POST['selectTerms']; 
$txtQuote=$_POST['txtQuote']; 
$txt_order_number=$_POST['txt_order_number']; 
$selectVendor=$_POST['selectVendor']; 
$txt_ship_to=$_POST['txt_ship_to']; 
$txt_purchase_note=$_POST['txt_purchase_note']; 
$txt_parts_cost=$_POST['txt_parts_cost']; 
$txt_freight_cost=$_POST['txt_freight_cost']; 
$txt_tax_cost=$_POST['txt_tax_cost']; 
$txt_total_cost=$_POST['txt_total_cost']; 
/*
echo"$txt_po_issued_date<br><br>";
echo"$txt_po<br><br>";
echo"$txt_required_date<br><br>";
echo"$txt_buyer_name<br><br>";
echo"$txt_ship<br><br>";
echo"$RadioGroup1<br><br>";
echo"$txt_closed_date<br><br>";
echo"$selectTerms<br><br>";
echo"$txtQuote<br><br>";
echo"$selectVendor<br><br>";
echo"$txt_ship_to<br><br>";
echo"$txt_purchase_note<br><br>";
echo"$txt_parts_cost<br><br>";
echo"$txt_freight_cost<br><br>";
echo"$txt_tax_cost<br><br>";
echo"$txt_total_cost<br><br>";
*/
//-----------------------------------------------------

$qry="UPDATE purchaseorder_main SET po_issued_date='$txt_po_issued_date', po_closed_date='$txt_closed_date', date_required='$txt_required_date', buyer_name='$txt_buyer_name', ship_via='$txt_ship', purchase_form='$selectVendor', ship_to='$txt_ship_to', po_status='$RadioGroup1', po_terms='$selectTerms', po_quote='$txtQuote', order_number='$txt_order_number', po_notes='$txt_purchase_note', parts_ordered='$txt_parts_cost', Freight='$txt_freight_cost', Tax='$txt_tax_cost', total_cost='$txt_total_cost'WHERE po='$po_num'";

$qryexecute=mysqli_query($db, $qry);
if($qryexecute)
{
header("Location: Browse_Purchase_Order.php");
}
}
?>
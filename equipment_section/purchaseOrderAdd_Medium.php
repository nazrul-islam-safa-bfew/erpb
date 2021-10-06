<?php 
include("common.php");
CreateConnection();
//------------------------Hidden Field Value Association------------------
$hidden=$_POST['hidField'];
//--Validating which button is clicked//
if($hidden==1)
{
/*
//---Assining Session value which store the Purchase Order Id initiated at the purchaseOrderAdd.php page--
session_start();
$purchase_order_number=$_SESSION['purchase_order'];
//insert record in the purchaseorder_main table//
$qry="INSERT INTO purchaseorder_main(po)VALUES('$purchase_order_number')";
$qryexecute=mysqli_query($db, $qry);
*/
header("Location: purchaseOrder_Parts_Managment.php");
}
 //--SAVE THE RECORD--//
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
//store hidden value(unformatted) 
$txt_parts_cost=$_POST['hid_part_cost']; 
$txt_freight_cost=$_POST['hid_fright_cost']; 
$txt_tax_cost=$_POST['hid_tax_cost']; 
$txt_total_cost=$_POST['hid_total_cost']; 
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

$qry="INSERT INTO purchaseorder_main(po, po_issued_date, po_closed_date, date_required, buyer_name, ship_via, purchase_form, ship_to, po_status, po_terms, po_quote, order_number, po_notes, parts_ordered, Freight, Tax, total_cost) VALUES('$txt_po','$txt_po_issued_date','$txt_closed_date','$txt_required_date','$txt_buyer_name','$txt_ship','$selectVendor','$txt_ship_to','$RadioGroup1','$selectTerms','$txtQuote','$txt_order_number','$txt_purchase_note','$txt_parts_cost','$txt_freight_cost','$txt_tax_cost','$txt_total_cost')";

$qryexecute=mysqli_query($db, $qry);
if($qryexecute)
{
header("Location: Browse_Purchase_Order.php");
}
else
{
header("Location: purchaseOrderAdd.php");
}
}
//this will delete the record from the purchaseorder_parts_info if the user close/Exit the page(purchaseOrderAdd.php) without save it...
else if($hidden==3)
{
//---Assining Session value which store the Purchase Order Id initiated at the purchaseOrderAdd.php page--
session_start();
$purchase_order_number=$_SESSION['purchase_order'];
$qry="DELETE FROM purchaseorder_parts_info WHERE po='$purchase_order_number'";
$qryexecute=mysqli_query($db, $qry);
}

?>
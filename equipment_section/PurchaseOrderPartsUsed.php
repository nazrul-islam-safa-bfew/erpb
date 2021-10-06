<?php 
include("common.php");
CreateConnection();
//---Assining Session value which store the Purchase Order Id initiated at the purchaseOrderAdd.php page--
session_start();
$purchase_order_number=$_SESSION['purchase_order'];
//------------------------Hidden Field Value Association------------------
$Part_ID=$_POST['hid_part_id'];
$hidden=$_POST['hidField'];
//------------------------------END----------------

//Check whether a part is added to a new purchase order or to a edited purchase order..
$check=$_GET['counter'];
//--------Tracking SelectPartNumber Menue's OnChange Event(Fetching records from the database based on Part nUmber--
if($hidden==1)
{
$qry="SELECT part_name,part_warranty,part_unit_cost FROM parts_inventory WHERE part_number='$Part_ID'";
$qryexecute=mysqli_query($db, $qry);
$rs=mysql_fetch_row($qryexecute);
$part_name=$rs[0];
$part_warranty=$rs[1];
$part_unit_cost=$rs[2];
}
//----------------------Save the record------------------------
else if($hidden==2)
{
//-------------------------------------------------END-----------------------------------
$part_num=$_POST['SelectPartNumber'];
$part_name=$_POST['txtName'];
$part_Warrenty=$_POST['txtWarrenty'];
$part_Quantity=$_POST['txtQuantity'];
$part_UnitCost=$_POST['txtUnitCost'];
$part_ExtendedCost=$_POST['txtExtendedCost'];
$part_Notes=$_POST['txtNotes'];

//Check whether a part is added to a new purchase order or to a edited purchase order..
//Edited Purchase order
if($check==1)
{
//retreiving PO number from the session initiated at Browse_Purchase_Order_Medium.php page
session_start();
$po_num=$_SESSION['PO'];

$qry1="INSERT INTO purchaseorder_parts_info(po,part_number,part_name,part_warranty,part_order_quantity,part_unit_cost,part_extended_cost,notes)VALUES('$po_num','$part_num','$part_name','$part_Warrenty','$part_Quantity','$part_UnitCost','$part_ExtendedCost','$part_Notes')";
$qryexecute1=mysqli_query($db, $qry1);

header("Location: purchaseOrder_Parts_Managment_Edit.php?count=1");
}
//New Purchase Order
else
{
$qry="INSERT INTO purchaseorder_parts_info(po,part_number,part_name,part_warranty,part_order_quantity,part_unit_cost,part_extended_cost,notes)VALUES('$purchase_order_number','$part_num','$part_name','$part_Warrenty','$part_Quantity','$part_UnitCost','$part_ExtendedCost','$part_Notes')";
$qryexecute=mysqli_query($db, $qry);
header("Location: purchaseOrder_Parts_Managment.php?count=1");
}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Add Part To Purchase Order(#<?php echo"$purchase_order_number"; ?>)</title>

<script language="javascript">

function goChange(m)
{

var n=m;
document.form1.hid_part_id.value=n;
document.form1.hidField.value=1;
document.form1.submit();
//alert(document.form1.hid_item_id.value);
}

function goCalculate(l)
{
var m=document.form1.txtUnitCost.value;
var calculate=m*l
//alert(calculate);
document.form1.txtExtendedCost.value=calculate;
}

//-------------------------Validating Form Imput & Then Save & Exit------------------------------

function validate(form1)
{

if(form1.SelectPartNumber.value=="")
{
alert("Please Select Part.");
form1.SelectPartNumber.focus();
return false;
}
if(form1.txtQuantity.value=="")
{
alert("Please Enter Quantity.");
form1.txtQuantity.focus();
return false;
}
else if(form1.txtExtendedCost.value=="")
{
alert("Please Calulate Extended Cost.");
form1.txtExtendedCost.focus();
return false;
}
else if(isNaN(form1.txtExtendedCost.value))
{
alert("Please Enter Integer Number.");
form1.txtQuantity.focus();
return false;
}
return true;
}




function doFinish(form1)
{
if(validate(form1)==true)
{
document.form1.hidField.value=2;
document.form1.submit();
}
}


</script>


<link href="common.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <table width="491" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#FF6633" style="border-color:#FF0000">
    <tr>
      <td colspan="2" bgcolor="#33CC33">Part's Information ... </td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr bgcolor="#FF99FF">
      <td width="145" bgcolor="#FF99FF">Part Number : </td>
      <td width="346"><label>
	  
								<select name="SelectPartNumber" id="SelectPartNumber" onchange="goChange(SelectPartNumber.value)">
								 <option value="" selected="selected"></option>
								
								 <?php  
								
														
														CreateConnection();
								
														$rs="SELECT part_number FROM parts_inventory";
																			
														$result = mysqli_query($db, $rs);
														while ($name_row = mysql_fetch_row($result)) {
														$part_number=$name_row[0];
														echo"<option value='$part_number'";
														if($part_number==$Part_ID) echo ' SELECTED ';
														echo">$part_number</option>";	
														}
														
																
														
														
									?>
								</select>
								
								
      </label></td>
    </tr>
    <tr bgcolor="#FF99FF">
      <td>Name : </td>
      <td><label>
        <input name="txtName" type="text" id="txtName" size="55" value="<?php echo"$part_name"; ?>"/>
      </label></td>
    </tr>
    
    <tr bgcolor="#FF99FF">
      <td>Warrenty (Year): </td>
      <td><input name="txtWarrenty" type="text" id="txtWarrenty" size="55" value="<?php echo"$part_warranty"; ?>" READONLY/></td>
    </tr>
    <tr bgcolor="#FF99FF">
      <td>Quantity Used : </td>
      <td><label>
        <input name="txtQuantity" type="text" id="txtQuantity" onchange="goCalculate(txtQuantity.value)"/>
      </label></td>
    </tr>
    <tr bgcolor="#FF99FF">
      <td>Unit Cost : </td>
      <td><input name="txtUnitCost" type="text" id="txtUnitCost" value="<?php echo"$part_unit_cost"; ?>" READONLY/></td>
    </tr>
    
    <tr bgcolor="#FF99FF">
      <td>Extended Cost : </td>
      <td><input name="txtExtendedCost" type="text" id="txtExtendedCost" readonly="READONLY"/></td>
    </tr>
    
    <tr bgcolor="#FF99FF">
      <td>Notes:</td>
      <td><label>
        <textarea name="txtNotes" cols="40" id="txtNotes"></textarea>
      </label></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr bgcolor="#33CC33">
    <td colspan="2"><center><input name="save" type="button" id="save" value="         Save          " onclick="doFinish(form1)"/></center></td>
	</tr>
  </table>
  <p>
    <input name="hid_part_id" type="hidden" id="hid_part_id" />
    <input name="hidField" type="hidden" id="hidField" />
  </p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</form>
</body>
</html>

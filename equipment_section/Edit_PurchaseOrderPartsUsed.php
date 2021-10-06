<?php 
include("common.php");
CreateConnection();
//---Assining Session value which store the Purchase Order Id initiated at the purchaseOrderAdd_MEDIUM.php page--
session_start();
$purchase_order_number=$_SESSION['purchase_order'];
//------------------------Hidden Field Value Association------------------
$Part_ID=$_POST['hid_part_id'];
$hidden=$_POST['hidField'];
//------------------------------END----------------


//--------Tracking SelectPartNumber Menue's OnChange Event(Fetching records from the database based on Part nUmber--
if($hidden==1)
{
//fetching part information from the parts_inventory
$qry="SELECT `part_name`, `part_warranty`, `part_order_quantity`, `part_unit_cost`, `part_extended_cost`, `notes` FROM purchaseorder_parts_info WHERE part_number='$Part_ID'";
$qryexecute=mysqli_query($db, $qry);
while($rs=mysql_fetch_row($qryexecute))
{
$part_name=$rs[0];
$part_warranty=$rs[1];
$part_order_quantity=$rs[2];
$part_unit_cost=$rs[3];
$part_extended_cost=$rs[4];
$m_notes=$rs[5];
}
//------------------END------------------//
}
//----------------------Update the record------------------------
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
$qry="UPDATE purchaseorder_parts_info SET part_name='$part_name',part_warranty='$part_Warrenty',part_order_quantity='$part_Quantity',part_unit_cost='$part_UnitCost',part_extended_cost='$part_ExtendedCost',notes='$part_Notes' WHERE po='$purchase_order_number' AND part_number='$part_num'";
$qryexecute=mysqli_query($db, $qry);
header("Location: purchaseOrder_Parts_Managment.php?count=1");
}
//---------Delete the record---//
else if($hidden==3)
{
$part_num=$_POST['SelectPartNumber'];
$qry2="DELETE FROM purchaseorder_parts_info WHERE po='$purchase_order_number' AND part_number='$part_num'";
$qryexecute2=mysqli_query($db, $qry2);
header("Location: purchaseOrder_Parts_Managment.php?count=1");
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


//Deleting the record 
function goDelete()
{
document.form1.hidField.value=3;
document.form1.submit();
}
</script>


</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <table width="475" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#FF6633" style="border-color:#FF0000">
    <tr>
      <td colspan="4" bgcolor="#33CC33">Part's Information ... </td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr bgcolor="#FF99FF">
      <td width="105" bgcolor="#FF99FF">Part Number : </td>
      <td colspan="3"><label>
	  
								<select name="SelectPartNumber" id="SelectPartNumber" onchange="goChange(SelectPartNumber.value)">
								 <option value="" selected="selected"></option>
								
								 <?php  
										$rs="SELECT part_number FROM purchaseorder_parts_info WHERE po='$purchase_order_number'";
																			
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
      <td colspan="3"><label>
        <input name="txtName" type="text" id="txtName" size="55" value="<?php echo"$part_name"; ?>"/>
      </label></td>
    </tr>
    
    <tr bgcolor="#FF99FF">
      <td>Warrenty (Year): </td>
      <td colspan="3"><input name="txtWarrenty" type="text" id="txtWarrenty" size="55" value="<?php echo"$part_warranty"; ?>" READONLY/></td>
    </tr>
    <tr bgcolor="#FF99FF">
      <td>Quantity Used : </td>
      <td colspan="3"><label>
        <input name="txtQuantity" type="text" id="txtQuantity" onchange="goCalculate(txtQuantity.value)" value="<?php echo"$part_order_quantity"; ?>"/>
      </label></td>
    </tr>
    <tr bgcolor="#FF99FF">
      <td>Unit Cost : </td>
      <td colspan="3"><input name="txtUnitCost" type="text" id="txtUnitCost" value="<?php echo"$part_unit_cost"; ?>" READONLY/></td>
    </tr>
    
    <tr bgcolor="#FF99FF">
      <td>Extended Cost : </td>
      <td colspan="3"><input name="txtExtendedCost" type="text" id="txtExtendedCost" value="<?php echo"$part_extended_cost"; ?>" readonly="READONLY"/></td>
    </tr>
    
    <tr bgcolor="#FF99FF">
      <td>Notes:</td>
      <td colspan="3"><label>
        <textarea name="txtNotes" cols="40" id="txtNotes"><?php echo"$m_notes"; ?>

</textarea>
      </label></td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr bgcolor="#33CC33">
      <td><label>
        <center>
        </center>
      </label></td>
      <td width="88"><input name="save" type="button" id="save" value="     Update   " onclick="doFinish(form1)"/></td>
      <td width="173"><label>
        <center><input name="BDelete" type="button" id="BDelete" value="   Delete   " onclick="goDelete()"/></center>
      </label></td>
      <td width="109"><input name="Close" type="button" id="Close" value="   Close  " onclick="javascript:location.href='purchaseOrder_Parts_Managment.php?count=1'"/></td>
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

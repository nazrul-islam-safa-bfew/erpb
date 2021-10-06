<?php 
session_start();
$work_order_id=$_SESSION['workorder_id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Work Order (#<?php echo"$work_order_id"; ?>)Repair - Parts Entry Form</title>

<script language="javascript">

function goClose()
{
document.form1.hidField.value=3;
document.form1.submit();
}


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
<?php 
$Part_ID=$_GET['Part_ID'];
$part_name=$_GET['part_name'];
$part_desc=$_GET['part_desc'];
$part_warranty=$_GET['part_warranty'];
$part_unit_cost=$_GET['part_unit_cost'];

?>
<form id="form1" name="form1" method="post" action="AddRepairPartsUsedMedium.php">
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <table width="475" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#FF6633" style="border-color:#FF0000">
    <tr bgcolor="#33CC33">
      <td colspan="4" bgcolor="#33CC33">Part's Information ... </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td width="152" bgcolor="#FF99FF">Part Number : </td>
      <td colspan="3" bgcolor="#FF99FF"><label>
      <select name="SelectPartNumber" id="SelectPartNumber" onchange="goChange(SelectPartNumber.value)">
        <option selected="selected"></option>
        <?php  
								
									  include("connection.php");
								
														$rs="SELECT itemCode,itemDes FROM itemlist";
																			
														$result = mysqli_query($db, $rs,$connection);
														while ($name_row = mysql_fetch_row($result)) {
														$part_number=$name_row[0];
														$itemDes=$name_row[1];
														echo"<option value='$part_number'";
														if($part_number==$Part_ID) echo ' SELECTED ';
														echo">->$part_number : $itemDes</option>";	
														}
														
																
														
														
									?>
      </select>
      </label></td>
    </tr>
    <tr>
      <td bgcolor="#FF99FF">Name : </td>
      <td colspan="3" bgcolor="#FF99FF"><label>
        <input name="txtName" type="text" id="txtName" size="55" value="<?php echo"$part_name"; ?>"/>
      </label></td>
    </tr>
    <tr>
      <td bgcolor="#FF99FF">Description : </td>
      <td colspan="3" bgcolor="#FF99FF"><input name="txtDesc" type="text" id="txtDesc" size="55" value="<?php echo"$part_desc"; ?>"/></td>
    </tr>
    <tr>
      <td bgcolor="#FF99FF">Warrenty (Year): </td>
      <td colspan="3" bgcolor="#FF99FF"><input name="txtWarrenty" type="text" id="txtWarrenty" size="55" value="<?php echo"$part_warranty"; ?>"/></td>
    </tr>
    <tr>
      <td bgcolor="#FF99FF">Quantity Used : </td>
      <td colspan="3" bgcolor="#FF99FF"><label>
        <input name="txtQuantity" type="text" id="txtQuantity" onchange="goCalculate(txtQuantity.value)"/>
      </label></td>
    </tr>
    <tr>
      <td bgcolor="#FF99FF">Unit Cost : </td>
      <td colspan="3" bgcolor="#FF99FF"><input name="txtUnitCost" type="text" id="txtUnitCost" value="<?php echo"$part_unit_cost"; ?>"/></td>
    </tr>
    <tr>
      <td bgcolor="#FF99FF">Extended Cost : </td>
      <td colspan="3" bgcolor="#FF99FF"><input name="txtExtendedCost" type="text" id="txtExtendedCost" /></td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr bgcolor="#33CC33">
      <td><label>
        <center>
        </center>
      </label></td>
      <td width="80"><input name="save" type="button" id="save" value="     Save    " onclick="doFinish(form1)"/></td>
      <td width="64">&nbsp;</td>
      <td width="179"><input name="Close" type="button" id="Close" value="   Close  " onclick="goClose()"/></td>
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

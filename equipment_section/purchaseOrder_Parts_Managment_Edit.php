<?php 
include("common.php");
CreateConnection();
//retreiving PO number from the session initiated at Browse_Purchase_Order_Medium.php page
session_start();
$po_num=$_SESSION['PO'];

//------------------------Hidden Field Value Association------------------
$hidden=$_POST['hidField'];
//check which button is clicked//
//Add a new parts to the edited purchase order
if($hidden==1)
{
header("Location: PurchaseOrderPartsUsed.php?counter=1");
}
//Edit parts already added to the purchase order(which needs to be edited)
else if($hidden==2)
{
header("Location: PurchaseOrderPartsUsed_Edit.php");
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Edit Parts Added To Purchase Order(#<?php echo"$po_num"; ?>)</title>

<script language="javascript">
//Check wheather an equipment edited or added or not.If so,then enable the Save button.
function addLoadEvent()
{
var counter='<?php echo $_GET['count']; ?>';
if(counter==1)
{
//document.form1.equipEdit.disabled=false;
document.form1.Bsave.disabled=false;
}
}


//  add new part
function goAdd()
{
document.form1.hidField.value=1;
document.form1.submit();
}


//   Editing the parts   ///
function goEdit()
{
document.form1.hidField.value=2;
document.form1.submit();
}
</script>
<link href="common.css" rel="stylesheet" type="text/css" />
</head>

<body onload="javascript:addLoadEvent()">
<form id="form1" name="form1" method="post" action="">
  <table width="883" border="1" cellspacing="0" cellpadding="0">
    <tr bgcolor="#33CC33">
      <td width="58">Qty</td>
      <td width="121">Part # </td>
      <td width="162">Name</td>
      <td width="116">Unit Cost </td>
      <td width="127">Extended Cost</td>
      <td width="299" bgcolor="#33CC33">Comments</td>
    </tr>
    

												    			
											<?php 
												
												$qry="SELECT part_order_quantity,part_number,part_name,part_unit_cost,part_extended_cost,notes FROM purchaseorder_parts_info WHERE po='$po_num'";
												
												
												$qryexecute=mysqli_query($db, $qry);
							
							while($rs=mysql_fetch_row($qryexecute))
							{
								$part_order_quantity=$rs[0];
								$part_number=$rs[1];
								$part_name=$rs[2];
								$part_unit_cost=$rs[3];
								$part_extended_cost=$rs[4];
								$notes=$rs[5];
								echo"<tr bgcolor=#FF99FF>
								
									<td>$part_order_quantity</td>
									<td>$part_number</td>
									<td>$part_name</td>
									<td>$part_unit_cost</td>
									<td>$part_extended_cost</td>
									<td>$notes</td>
									</tr>";
								
								}
							


											?>
				

												

    <tr bgcolor="#33CC33">
      <td>&nbsp;</td>
      <td><label>
        <input name="Add" type="button" id="Add" value="Add Part..." onclick="goAdd()"/>
      </label></td>
      <td><label>
      <input name="equipEdit" type="button" id="equipEdit" value="Edit Part / Delete..." onclick="goEdit()"/>
      </label></td>
      <td><label></label></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <p>
    <input name="hidField" type="hidden" id="hidField" />
  </p>
  <table width="883" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="50">&nbsp;</td>
      <td width="392">&nbsp;</td>
      <td width="207"><input name="Bsave" type="button" id="Bsave" value="    Save    " disabled="disabled" onclick="javascript:location.href='purchaseOrderEdit.php?count=1'"/></td>
      <td width="234">&nbsp;</td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</form>
</body>
</html>

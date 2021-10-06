<?php
include("common.php");
CreateConnection(); 
session_start();
$itm_id=$_SESSION['item_code']; 
//echo("$itm_id");
$qry="SELECT item_purchase_dealer,item_purchase_date,item_purchase_kilometer,item_purchase_price,item_purchase_comment,item_purchase_in_service_date,item_purchase_out_service_date,item_purchase_transfer_date,item_purchase_sold_date,item_purchase_sold_to,item_purchase_status_comment FROM add_equipment_maintenance WHERE itm_track_id='$itm_id'";
$qryexecute=mysqli_query($db, $qry);
$rs=mysql_fetch_row($qryexecute);
$item_purchase_dealer=$rs[0];
$item_purchase_date=$rs[1];
$item_purchase_kilometer=$rs[2];
$item_purchase_price=$rs[3];
$item_purchase_comment=$rs[4];
$item_purchase_in_service_date=$rs[5];
$item_purchase_out_service_date=$rs[6];
$item_purchase_transfer_date=$rs[7];
$item_purchase_sold_date=$rs[8];
$item_purchase_sold_to=$rs[9];
$item_purchase_status_comment=$rs[10];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Equipment Purchase Information Edit Form</title>
<script type="text/javascript" language="JavaScript1.2" src="stm32.js"></script>
<script language="javascript" type="text/javascript" src="datetimepicker.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" type="text/javascript" SRC="timepicker.js"></SCRIPT>

<script language="javascript">

//---------------------------Validating Form Input------------------------------------------

function goNext()
{
document.form1.hidField.value=2;
document.form1.submit();
}

function validate(frm)
{
if(frm.txtdealer.value=="")
{
alert("Please Enter Dealer Name");
frm.txtdealer.focus();
return false;
}
else if(frm.txtprice.value=="")
{
alert("Please Enter Price.");
frm.txtprice.focus();
return false;
}
return true;
}

function doFinish(frm)
{
if(validate(frm)==true)
{
document.form1.hidField.value=1;
frm.submit();
}
}


</script>
<style type="text/css">
<!--
.style1 {
	font-size: 16px;
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
<link href="common.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form id="form1" name="form1" method="post" action="EditNewEquipmentPurchaseMedium.php">
  <p>
    <input name="hidField" type="hidden" id="hidField" />
  </p>
  <table width="920" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
    
    <tr>
      <td colspan="4" bgcolor="#33CC33"> Edit Equipment PurchaseInformation </td>
    </tr>
    <tr>
      <td width="155">&nbsp;</td>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4"><span class="style1">Purchase Information
          <label></label>
      </span>        <label></label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td>Dealer:</td>
      <td colspan="3"><label>
      <input name="txtdealer" type="text" id="txtdealer" size="80" value="<?php echo"$item_purchase_dealer"; ?>"/>
      </label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td>Purchase Date: </td>
      <td colspan="3"><input name="txtPurchaseDate" type="text" id="txtPurchaseDate" size="15" value="<?php echo"$item_purchase_date"; ?>" READONLY/>
      <a href="javascript:NewCal('txtPurchaseDate','yyyymmdd','true',12)"><img src="cal.gif" width="16" height="16" border="0" /></a></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td>Purchase Kilometers: </td>
      <td colspan="3"><input name="txtPurchaseKilometer" type="text" id="txtPurchaseKilometer" size="15" value="<?php echo"$item_purchase_kilometer"; ?>"/>
      Tk.</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td>Price</td>
      <td colspan="3"><input name="txtprice" type="text" id="txtprice" size="15" value="<?php echo"$item_purchase_price"; ?>"/>
     Tk.</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td>Comments:</td>
      <td colspan="3"><label>
        <input name="txtPurchaseComment" type="text" id="txtPurchaseComment" size="120" value="<?php echo"$item_purchase_comment"; ?>"/>
      </label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3">&nbsp;</td>
    </tr>
    
    <tr>
      <td>&nbsp;</td>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4">Equipment Status </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td>In Service: </td>
      <td width="254"><input name="inServiceDate" type="text" id="inServiceDate" size="15" value="<?php echo"$item_purchase_in_service_date"; ?>" READONLY/>
      <a href="javascript:NewCal('inServiceDate','yyyymmdd','true',12)"><img src="cal.gif" width="16" height="16" border="0" /></a></td>
      <td width="117">Date Sold : </td>
      <td width="394"><input name="soldDate" type="text" id="soldDate" size="15" value="<?php echo"$item_purchase_sold_date"; ?>" READONLY/>
      <a href="javascript:NewCal('soldDate','yyyymmdd','true',12)"><img src="cal.gif" width="16" height="16" border="0" /></a></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td>Out of Service: </td>
      <td><input name="outServiceDate" type="text" id="outServiceDate" size="15" value="<?php echo"$item_purchase_out_service_date"; ?>" READONLY/>
      <a href="javascript:NewCal('outServiceDate','yyyymmdd','true',12)"><img src="cal.gif" width="16" height="16" border="0" /></a></td>
      <td>Sold To: </td>
      <td><input name="txtSoldTo" type="text" id="txtSoldTo" size="60" value="<?php echo"$item_purchase_sold_to"; ?>"/></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td>Transfer Date: </td>
      <td><input name="transferDate" type="text" id="transferDate" size="15" value="<?php echo"$item_purchase_transfer_date"; ?>" READONLY/>
      <a href="javascript:NewCal('transferDate','yyyymmdd','true',12)"><img src="cal.gif" width="16" height="16" border="0" /></a></td>
      <td>Comments: </td>
      <td><input name="txtStatusComment" type="text" id="txtStatusComment" size="60" value="<?php echo"$item_purchase_status_comment"; ?>"/></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr bgcolor="#33CC33">
      <td>&nbsp;</td>
      <td><input name="save" type="button" id="save" accesskey="S" onclick="doFinish(form1)" value=" Update &amp; Go Next"/></td>
      <td>&nbsp;</td>
      <td><input name="next" type="button" id="next" accesskey="C" value="      Go Next      " onclick="goNext()" /></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</form>
</body>
</html>

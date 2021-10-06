<?php 
include("common.php");
CreateConnection();
//assigning hidStatus value to the variable which has the status value,can be found only when the form is submitted to itself on Selectstatus onchane event..
$status_value=$_POST['hidStatus'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Work Order Managment</title>

<script language="javascript">
//tracking SelectStatus on change event(i.e-retreive all the row from new_work_order_main where work_order_status=selectStatus value//
function goSelect(m)
{
document.form1.hidStatus.value=m;
document.form1.submit();
}

//edit the work order to enter the work order complete data
function goDelete(wo_id)
{
if(confirm("Do You Want To Delete The Work Order?")==true)
{
location.href='delete_work_order.sql.php?id=' +wo_id;
}
}
</script>
<style type="text/css">
<!--
@import url("common.css");
.style1 {
	color: #FF0000;
	font-family: Georgia, "Times New Roman", Times, serif;
}
-->
</style>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="3000" border="1" cellpadding="0" cellspacing="0">
    
    <tr bgcolor="#33CC33">
      <td width="92">WO # </td>
      <td width="318" bgcolor="#33CC33">Identification</td>
      <td width="127">Date Issued </td>
      <td width="97">Status</td>
      <td width="118">Date Complete</td>
      <td width="106">Meter</td>
      <td width="276">Work Performed </td>
      <td width="226">Employee Assignment </td>
      <td width="164">Vendor Name</td>
      <td width="89">Invoice</td>
      <td width="83">PO # </td>
      <td width="419">Comments</td>
      <td width="105">PM Cost(Tk.) </td>
      <td width="97">Repair Cost(Tk.) </td>
      <td width="103">Parts Cost(Tk.) </td>
      <td width="98">Labor Cost(Tk.) </td>
      <td width="116">External Cost(Tk.) </td>
      <td width="110">Taxes(Tk.)</td>
      <td width="98">TotalCost(Tk.)</td>
      <td width="116">UDF Cost(Tk.) </td>
    </tr>
	
										<?php 
										//fetching all work order from new_work_order_main table..
										//--For ""ALL" option value
										if($status_value==0)
										{
										$qry="SELECT * FROM new_work_order_main";
										$qryexecute=mysqli_query($db, $qry);
										}
										//For "OPEN" option value
										else if($status_value==1)
										{
										$qry="SELECT * FROM new_work_order_main where work_order_status='1'";
										$qryexecute=mysqli_query($db, $qry);										
										}
										//For "CLose" Option value
										else
										{
										$qry="SELECT * FROM new_work_order_main where work_order_status='0'";
										$qryexecute=mysqli_query($db, $qry);
										}
										
										while($rs=mysql_fetch_row($qryexecute))
										{
										$item_id=$rs[0];
										$work_order_id=$rs[1];
										$issued_date=$rs[2];
										$closed_date=$rs[3];
										$equipment_meter=$rs[4];
										$work_order_status=$rs[5];
										$vendor=$rs[6];
										$assigned_to=$rs[7];
										$purchase_order=$rs[8];
										$invoice=$rs[9];
										$pm_cost=$rs[10];
										$repair_cost=$rs[11];
										$parts_cost=$rs[12];
										$labor_cost=$rs[13];
										$external_service_cost=$rs[14];
										$udf_cost=$rs[15];
										$sub_total=$rs[16];
										$discount_amt=$rs[17];
										$pre_tax_amt=$rs[18];
										$tax_amt=$rs[19];
										$grand_total=$rs[20];
										$work_order_comment=$rs[21];
										
										//Retreiving Item identification from the add_equipment_maintenance table base on $item_id value
										$qry1="SELECT itemCode,teqSpec FROM equipment WHERE eqid='$item_id'";
										$qryexecute1=mysqli_query($db, $qry1);
										$item_name1=mysql_fetch_row($qryexecute1);
										$item_name=$item_name1[0];
										
										//check the work order status.i.e wheather the work order is "OPEN" or "CLOSED".
											if($work_order_status=='1')
												{
													$status="Open";
												}
											else
												{
													$status="Close";
												} 

										//FORMATTING DATES DAY-MONTH-YEAR FORMAT
										
										//FOR ISSUE DATE.....
										if($issued_date=="0000-00-00")
										{
											$issued_date="";
										}
										else
											{
											$dates1 = array($issued_date);
											
													foreach ($dates1 as $timestamp) {
													  $issued_date1 = explode("-",$timestamp);
													}
	
											}
											
										//FOR CLOSED DATE......
										if($closed_date=="0000-00-00")
											{
												$closed_date1="";
											}
										else
											{
											$dates1 = array($closed_date);
											
													foreach ($dates1 as $timestamp) {
													  $closed_date1 = explode("-",$timestamp);
													}
	
											}
										//creting rows dynamically//
										echo"<tr ondblclick=goDelete('$work_order_id')>
										<td>$work_order_id</td>
										<td>$item_name</td>
										<td>$issued_date1[2]-$issued_date1[1]-$issued_date1[0]</td>
										<td>$status</td>
										<td>$closed_date1[2]-$closed_date1[1]-$closed_date1[0]</td>
										<td>$equipment_meter</td>
										<td>$work_performed</td>
										<td>$assigned_to</td>
										<td>$vendor_name</td>
										<td>$invoice</td>
										<td>$purchase_order</td>
										<td>$work_order_comment</td>
										<td>$pm_cost</td>
										<td>$repair_cost</td>
										<td>$parts_cost</td>
										<td>$labor_cost</td>
										<td>$external_service_cost</td>
										<td>$tax_amt</td>
										<td>$grand_total</td>
										<td>$udf_cost</td>
										</tr>";
										}
										
										
										?>
  </table>
  <p>&nbsp;</p>
  <table width="1012" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
    <tr bgcolor="#33CC33">
      <td width="92">&nbsp;</td>
      <td width="143"><center><input name="add" type="button" id="add" value="   Add   " onclick="javascript:location.href='NewWorkWorder.php'"/>
      </center></td>
      <td width="138"><center><input name="edit" type="button" id="edit" value="   Edit   " onclick="javascript:location.href='Edit_work_order.php'"/>
      </center></td>
      <td width="146"><center><input name="delete" type="button" id="delete" value="  Delete  " />
      </center></td>
      <td width="197"><center>
        <input name="Close" type="button" id="Close" value="   Close  " onclick="javascript:window.close()"/>
      </center></td>
      <td width="133"><input name="Print" type="button" id="Print" value="   Print   " onclick="javascript:window.print()"/></td>
      <td width="163">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr bgcolor="#33CC33">
      <td colspan="2">View Options </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="3">&nbsp;</td>
    </tr>
    
    <tr bgcolor="#FF99FF">
      <td>status</td>
      <td><label>
        <select name="selectStatus" id="selectStatus" onchange="goSelect(this.value)">
	    <option value="0" selected="selected" <?php if($status_value==0) echo ' SELECTED '; ?>>All</option>
        <option value="1" <?php if($status_value==1) echo ' SELECTED '; ?>>Open</option>
        <option value="2"<?php if($status_value==2) echo ' SELECTED '; ?>>Closed</option>
        </select>
      </label></td>
      <td colspan="2" bgcolor="#FF99FF"><label>
        <input type="checkbox" name="checkbox" value="checkbox" />
      Highlight outstanding work orders.</label></td>
      <td colspan="3">&nbsp;</td>
    </tr>
  </table>
  <p>
    <input name="hidStatus" type="hidden" id="hidStatus" />
  <span class="style1">*Double click on the Work Order to delete it.  </span></p>
</form>
</body>
</html>

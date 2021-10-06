<?php
include("common.php");
CreateConnection();
$hid=$_POST['hidField'];
//---generating purchase order number---//
if($hid==1)
{
$qry="SELECT MAX(invoice_num) FROM invoice_main";
$qryexecute=mysqli_query($db, $qry);
$rs_result=mysql_fetch_row($qryexecute);
$rs=$rs_result[0];
//echo("$rs");
if($rs==0)
{
$invoice_num=101;
}
else
{
$invoice_num=$rs+1;
}
//generating session to hold invoice number..//
session_start();
$_SESSION['invoice_number']=$invoice_num;
//if the purchase order number creation is successful then go to GenerateInvoice.php page...
if($qryexecute)
{
header("Location: GenerateInvoice.php");
}
else
{
echo("Couldn't Connect To The Database.");
}
}
//Editing the record
else if($hid==2)
{
$invoice_num_edit=$_POST['hid_invoice_num'];
//generating session for the invvoice number 
session_start();
$_SESSION['edit_invoice_number']=$invoice_num_edit;
//echo"$invoice_num_edit";
header("Location:Edit_Generate_Invoice.php");
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Invoice Managment</title>
<script language="javascript">
//add new invoice..
function goAdd()
{
document.form1.hidField.value=1;
document.form1.submit();
}


//tracking SelectStatus(i.e..select combo control) on change event(i.e-retreive all the row from invoice_main where closed=selectStatus value//
function goSelect(m)
{
//will be used to track selectStatus value
document.form1.hidStatus.value=m;
//this varible will be used to determine which event occur 
//document.form1.hidField.value=2;
document.form1.submit();
}

//------Editing invoice----//
function goEdit(m)
{
//this variable is used to hold the invoice number when click on the particular row.
document.form1.hid_invoice_num.value=m;
//this hidden variable is used to check wheather the row,s doubleClick event is occur for the reccord edit..
document.form1.hidField.value=2;
document.form1.submit();
//alert(m);
}

</script>
<link href="common.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php 
//--assigning posted value send this page to itself... 
$status_value=$_POST['hidStatus'];
?>

<form id="form1" name="form1" method="post" action="">
  <table width="1500" border="1" cellpadding="0" cellspacing="0">
    <tr bgcolor="#33CC33">
      <th width="142">Invoice # </th>
      <th width="142" bgcolor="#33CC33">Invoice Date </th>
      <th width="133">WO # </th>
      <th width="167" bordercolor="#FF99FF">Pay Due Date </th>
      <th width="145">Total Cost </th>
      <th width="171">Payments Received </th>
      <th width="148">Customer</th>
      <th width="154">Notes</th>
      <th width="99">Closed?</th>
      <th width="82">Terms</th>
      <th width="93">PO # </th>
    </tr>
	
										<?php
										
								//Generating table records dynamically from invoice_main table//
									
										//--For ""ALL" option value
										if($status_value==0)
										{
											$qry="SELECT * FROM invoice_main";
											$qryexecute=mysqli_query($db, $qry);
										//count number of record returned by the above query..
												$count=mysql_num_rows($qryexecute);

										}
										//For "OUTSTANDING" option value(i.e invoice is not closed yet)
										else if($status_value==1)
										{
											$qry="SELECT * FROM invoice_main WHERE closed='0'";
											$qryexecute=mysqli_query($db, $qry);
											//count number of record returned by the above query..
												$count=mysql_num_rows($qryexecute);
										
										}
										//For "CLosed" Option value(i.e invoice is closed now)
										else
										{
											$qry="SELECT * FROM invoice_main WHERE closed='1'";
											$qryexecute=mysqli_query($db, $qry);										
											//count number of record returned by the above query..
												$count=mysql_num_rows($qryexecute);

										}

										
											//display data as table rows...
											while($rs=mysql_fetch_row($qryexecute))
											{
												$invoice_num=$rs[0];
												$invoice_date=$rs[1];
												$work_order_id=$rs[2];
												$terms=$rs[3];
												$invoice_pay_due_date=$rs[4];
												$po=$rs[5];
												$bill_to=$rs[6];
												$invoice_amt=$rs[7];
												$payment_receive_amt=$rs[8];
												$invoice_notes=$rs[9];
												$closed=$rs[10];
												
												//format invoice_amt,payment_receive_amt to currency format
												$format_invoice_amt=number_format($invoice_amt,2);
												$format_payment_receive_amt=number_format($payment_receive_amt,2);
												
												
												//retreiving customer name from the database
												$qry1="SELECT cust_name FROM customer_setup WHERE cust_id='$bill_to'";
												$qryexecute1=mysqli_query($db, $qry1);
												$rs1=mysql_fetch_row($qryexecute1);
												$cust_name=$rs1[0];
	//check $closed value.if 0 then print false(i.e..invoice is not closed yet) otherwise print 1(i.e..invoice is closed)....
													if($closed==0)
													{
														$print_close="False";
													}
													else if($closed==1)
													{
														$print_close="True";
													}
									//................END..................................//
									
												
									//conversion of dates to day-month-hour format
										//for invoice_date
											if($invoice_date=="0000-00-00")
												{
													$parts="";
												
												}
												else
												{
										$dates1 = array($invoice_date);
										
												foreach ($dates1 as $timestamp) {
												  $parts = explode("-",$timestamp);
												}
												}
										
										//for invoice_pay_due_date
										
										//check wheather invoice_pay_due_date is blank or not
												if($invoice_pay_due_date=="0000-00-00")
												{
													$parts1="";
												
												}
												else
												{
										$dates = array($invoice_pay_due_date);
										
												foreach ($dates as $timestamp) {
												  $parts1 = explode("-",$timestamp);
												}
												}
												

											echo"<tr ondblclick=goEdit($invoice_num)>
													<td>$invoice_num</td>
													<td>$parts[2]-$parts[1]-$parts[0]</td>
													<td>$work_order_id</td>
													<td>$parts1[2]-$parts1[1]-$parts1[0]</td>
													<td>$format_invoice_amt</td>
													<td>$format_payment_receive_amt</td>
													<td>$cust_name</td>
													<td>$invoice_notes</td>
													<td>$print_close</td>
													<td>$terms</td>
													<td>$po</td>
											</tr>";
											
											}
										
										
										?>
  </table>
  <p>
    <input name="hidField" type="hidden" id="hidField" />
    <input name="hidStatus" type="hidden" id="hidStatus" />
    <input name="hid_invoice_num" type="hidden" id="hid_invoice_num" />
  </p>
  <table width="800" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
    <tr bgcolor="#33CC33">
      <th colspan="2">
	  <?php echo("$count"); ?> Invoices Listed     </th>
      <th width="177">
        <input name="add" type="button" id="add" value="     Add     " onclick="goAdd()"/>      </th>
      <th width="131"><label>
        <input name="Bdelete" type="button" id="Bdelete" value="   Delete   " onclick="javascript:location.href='Delete_Generate_Invoice.php'"/>
      </label></th>
      <th width="137"><center>
        <input name="Close" type="button" id="Close" value="     Close   " onclick="javascript:window.close()"/>
      </center></th>
      <th width="52">&nbsp;</th>
      <th width="99"><input name="Print" type="button" id="Print" value="    Print    " onclick="javascript:window.print()"/></th>
    </tr>
    <tr>
      <td width="73">&nbsp;</td>
      <td width="131">&nbsp;</td>
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
          <option value="1" <?php if($status_value==1) echo ' SELECTED '; ?>>Outstanding</option>
          <option value="2" <?php if($status_value==2) echo ' SELECTED '; ?>>Paid In Full</option>
        </select>
      </label></td>
      <td colspan="5" bgcolor="#FF99FF"><label>
        <input type="checkbox" name="checkbox" value="checkbox"/>
        Highlight outstanding work orders.</label></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</form>
</body>
</html>

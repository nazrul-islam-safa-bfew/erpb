<?php 
include("common.php");
CreateConnection();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Browse Purchase Orders</title>
<script language="javascript">
//tracking SelectStatus on change event(i.e-retreive all the row from purchaseorder_main where po_status=selectStatus value//
function goSelect(m)
{
//will be used to track selectStatus value
document.form1.hidStatus.value=m;
//this varible will be used to determine which event occur 
document.form1.hidChk.value=1;
document.form1.submit();
}


//------Editing Purchase Order----//
function goEdit(m)
{
//this variable is used to hold the PO number when click on the particular row.
document.form1.hidPO.value=m;
//this hidden variable is used to check wheather the row,s doubleClick event is occur for the reccord edit..
document.form1.hidChk.value=2;
document.form1.submit();

//alert(m);
}
</script>

<link href="common.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php 
//--assigning posted value send from the Browse_Purchase_Order_Medium.php page 
$status_value=$_GET['status'];
?>

<form id="form1" name="form1" method="post" action="Browse_Purchase_Order_Medium.php">
  <table width="800" border="1" cellpadding="0" cellspacing="0">
    <tr bgcolor="#33CC33">
      <th>PO # </th>
      <th>PO Date </th>
      <th bgcolor="#33CC33">Date Expected </th>
      <th>Status</th>
      <th>Date Closed </th>
      <th>Vendor</th>
    </tr>
								
								<?php
									//Generating table records dynamically from purchaseorder_main table//
									
									//fetching  PO order from purchaseorder_main table..
										//--For ""ALL" option value
										if($status_value==0)
										{
					$qry="SELECT po,po_issued_date,date_required,po_status,po_closed_date,purchase_form FROM purchaseorder_main ";
										$qryexecute=mysqli_query($db, $qry);
											
											//count number of record returned by the above query..
												$count=mysql_num_rows($qryexecute);

										}
										//For "OUTSTANDING" option value
										else if($status_value==1)
										{
					$qry="SELECT po,po_issued_date,date_required,po_status,po_closed_date,purchase_form FROM purchaseorder_main WHERE po_status='1'";
										$qryexecute=mysqli_query($db, $qry);
											//count number of record returned by the above query..
												$count=mysql_num_rows($qryexecute);
										
										}
										//For "CLoseD" Option value
										else
										{
					$qry="SELECT po,po_issued_date,date_required,po_status,po_closed_date,purchase_form FROM purchaseorder_main WHERE po_status='0'";
										$qryexecute=mysqli_query($db, $qry);
											//count number of record returned by the above query..
												$count=mysql_num_rows($qryexecute);

										}

									while($rs=mysql_fetch_row($qryexecute))
									{
										$po=$rs[0];
										$po_issued_date=$rs[1];
										$date_required=$rs[2];
										$po_status=$rs[3];
										$po_closed_date=$rs[4];
										$purchase_form=$rs[5];
										
										//conversion of dates to day-month-hour format
										//for PO Issue date
										$dates = array($po_issued_date);
										
												foreach ($dates as $timestamp) {
												  $parts = explode("-",$timestamp);
												}
										//if po DAte REquired is blank(i.e 0000-00-00)
										if($date_required=="0000-00-00")
										{
											$parts1="";
										}
										else
										{		
										//for PO Date Required date
										$dates1 = array($date_required);
										
												foreach ($dates1 as $timestamp) {
												  $parts1 = explode("-",$timestamp);
												}
										
										}
											
										//if po Closed date is blank(i.e 0000-00-00)
										if($po_closed_date=="0000-00-00")
										{
											$parts2="";
										}
										else
										{		
	
										//for PO Closed date
										$dates2 = array($po_closed_date);
										
												foreach ($dates2 as $timestamp) {
												  $parts2 = explode("-",$timestamp);
												}
										}
		
		
		//Checking PO Status-----
		if($po_status==0)
		{
		$po_status_name="Closed";
		}
		else if($po_status==1)
		{
		$po_status_name="Outstanding";
		}
		
		
		
								//Check vendor name
								$qry1="SELECT vendor_name FROM vendor_setup WHERE vendor_id='$purchase_form'";
								$qryexecute1=mysqli_query($db, $qry1);
								$vendor_name=mysql_result($qryexecute1,0,0);
					
													echo"<tr ondblclick=goEdit($po)>
													<td>$po</td>
													<td>$parts[2]-$parts[1]-$parts[0]</td>
													<td>$parts1[2]-$parts1[1]-$parts1[0]</td>
													<td>$po_status_name</td>
													<td>$parts2[2]-$parts2[1]-$parts2[0]</td>
													<td>$vendor_name</td>
													</tr>";
													

									}
								
								
								 ?>
  </table>
  <p>
    <input name="hidStatus" type="hidden" id="hidStatus" />
    <input name="hidPO" type="hidden" id="hidPO" />
    <input name="hidChk" type="hidden" id="hidChk" />
  </p>
  <table width="800" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
    <tr bgcolor="#33CC33">
      <th colspan="2" bgcolor="#33CC33"><?php echo"$count"; ?>
      Purchase Order Listed </th>
      <th width="121"><center>
        <input name="add" type="button" id="add" value="   Add   " onclick="javascript:location.href='purchaseOrderAdd.php'"/>
      </center></th>
      <th width="155"><center>
        <input name="Close" type="button" id="Close" value="   Close  " onclick="javascript:window.close()"/>
      </center></th>
      <th width="58"><center>
      </center></th>
      <th width="111"><input name="Print" type="button" id="Print" value="   Print   " onclick="javascript:window.print()"/></th>
      <th width="120">&nbsp;</th>
    </tr>
    <tr>
      <td width="105">&nbsp;</td>
      <td width="130">&nbsp;</td>
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
          <option value="2"<?php if($status_value==2) echo ' SELECTED '; ?>>Closed</option>
        </select>
      </label></td>
      <td colspan="5" bgcolor="#FF99FF"><label>
        <input type="checkbox" name="checkbox" value="checkbox" />
        Highlight outstanding work orders.</label></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</form>
</body>
</html>

<?php 
include("common.php");
CreateConnection();
session_start();
$item_id=$_SESSION['item_code'];
$qry="SELECT item_loan_company,item_loan_account, item_loan_start_date,item_loan_end_date,item_loan_payment,item_loan_balance,item_loan_notes FROM add_equipment_maintenance WHERE itm_track_id='$item_id'";
$qryexecute=mysqli_query($db, $qry);
$rs=mysql_fetch_row($qryexecute);
$item_loan_company=$rs[0];
$item_loan_account=$rs[1];
$item_loan_start_date=$rs[2];
$item_loan_end_date=$rs[3];
$item_loan_payment=$rs[4];
$item_loan_balance=$rs[5];
$item_loan_notes=$rs[6];
//echo("$item_loan_company");
//echo("$item_id");
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Equipment Loan / Lease Edit Form</title>
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
if(frm.txtLoanCompany.value=="")
{
alert("Please Enter Company Name");
frm.txtLoanCompany.focus();
return false;
}
else if(frm.txtLoanAccount.value=="")
{
alert("Please Enter Account Information.");
frm.txtLoanAccount.focus();
return false;
}
else if(frm.LoanstartDate.value=="")
{
alert("Please Mention Starting Date.");
frm.LoanstartDate.focus();
return false;
}
else if(frm.loanEndDate.value=="")
{
alert("Please Mention End Date.");
frm.loanEndDate.focus();
return false;
}
else if(frm.txtLoanPayment.value=="")
{
alert("Please Enter Price.");
frm.txtLoanPayment.focus();
return false;
}
else if(frm.txtLoanBal.value=="")
{
alert("Please Mention Balance.");
frm.txtLoanBal.focus();
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

<link href="common.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form id="form1" name="form1" method="post" action="EditNewEquipmentLoanMedium.php">
    <input name="hidField" type="hidden" id="hidField" />
  <table width="868" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
    
    <tr>
      <td colspan="5" bgcolor="#33CC33">Edit  Equipment's Loan / Lease Information </td>
    </tr>
    <tr>
      <td width="141">&nbsp;</td>
      <td colspan="4">&nbsp;</td>
    </tr>
    
    <tr>
      <td>Company:</td>
      <td colspan="4"><label>
      <input name="txtLoanCompany" type="text" id="txtLoanCompany" size="80" value="<?php echo("$item_loan_company"); ?>"/>
      </label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td>Account #: </td>
      <td colspan="4"><input name="txtLoanAccount" type="text" id="txtLoanAccount" size="80" value="<?php echo("$item_loan_account"); ?>"/></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td>Start Date: </td>
      <td colspan="4"><input name="LoanstartDate" type="text" id="LoanstartDate" size="15" value="<?php echo("$item_loan_start_date"); ?>" READONLY/>
      <a href="javascript:NewCal('LoanstartDate','yyyymmdd','true',12)"><img src="cal.gif" width="16" height="16" border="0" /></a></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td>End Date: </td>
      <td colspan="4"><input name="loanEndDate" type="text" id="loanEndDate" size="15" value="<?php echo("$item_loan_end_date"); ?> " READONLY/>
      <a href="javascript:NewCal('loanEndDate','yyyymmdd','true',12)"><img src="cal.gif" width="16" height="16" border="0" /></a></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td>Payment</td>
      <td colspan="4"><label>
        <input name="txtLoanPayment" type="text" id="txtLoanPayment" size="15" value="<?php echo("$item_loan_payment"); ?>"/>
      Tk.</label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td>Res / Bal: </td>
      <td colspan="4"><label>
        <input name="txtLoanBal" type="text" id="txtLoanBal" size="15" value="<?php echo("$item_loan_balance"); ?>"/>
      Tk.</label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td>Notes:</td>
      <td colspan="4"><label>
        <input name="txtLoanNote" type="text" id="txtLoanNote" size="120" value="<?php echo("$item_loan_notes"); ?>"/>
      </label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr bgcolor="#33CC33">
      <td>&nbsp;</td>
      <td width="224"><label>
        <center>
          <input name="save" type="button" id="save" accesskey="S" onclick="doFinish(form1)" value="Update &amp; Go Next"/>
        </center>
      </label></td>
      <td width="97"><label></label></td>
      <td width="248"><input name="next" type="button" id="next" accesskey="C" value="      Go Next      " onclick="goNext()" /></td>
      <td width="158">&nbsp;</td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</form>
</body>
</html>

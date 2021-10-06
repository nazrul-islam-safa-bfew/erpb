<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Equipment Insurance Entry Form</title>
<script type="text/javascript" language="JavaScript1.2" src="stm32.js"></script>
<script language="javascript" type="text/javascript" src="datetimepicker.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" type="text/javascript" SRC="timepicker.js"></SCRIPT>

<script language="javascript">

//---------------------------Validating Form Input------------------------------------------

function goExit()
{
document.form1.hidField.value=2;
document.form1.submit();
}

function validate(frm)
{
if(frm.txtInsuranceCompany.value=="")
{
alert("Please Enter Company Name");
frm.txtInsuranceCompany.focus();
return false;
}
else if(frm.txtInsurancePolicy.value=="")
{
alert("Please Enter Policy Information.");
frm.txtInsurancePolicy.focus();
return false;
}
else if(frm.txtInsuranceStartDate.value=="")
{
alert("Please Mention Starting Date.");
frm.LoanstartDate.focus();
return false;
}
else if(frm.txtInsuranceEndDate.value=="")
{
alert("Please Mention End Date.");
frm.txtInsuranceEndDate.focus();
return false;
}
else if(frm.txtInsurancePayment.value=="")
{
alert("Please Enter Price.");
frm.txtInsurancePayment.focus();
return false;
}
else if(frm.txtInsuranceDeductible.value=="")
{
alert("Please Mention Balance.");
frm.txtInsuranceDeductible.focus();
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
<style type="text/css">
<!--
.style1 {
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<form id="form1" name="form1" method="post" action="NewEquipmentInsuranceMedium.php">
  <p>
    <input name="hidField" type="hidden" id="hidField" />
  </p>
  <table width="894" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
    
    <tr>
      <td colspan="5" bgcolor="#33CC33">Add New Equiptment - Insurance Information </td>
    </tr>
    <tr>
      <td width="136">&nbsp;</td>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="5"><span class="style1">Policy Information</span>        <label></label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td>Company:</td>
      <td colspan="4"><label>
      <input name="txtInsuranceCompany" type="text" id="txtInsuranceCompany" size="80" />
      </label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td>Policy #: </td>
      <td colspan="4"><input name="txtInsurancePolicy" type="text" id="txtInsurancePolicy" size="80" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td>Start Date: </td>
      <td colspan="4"><input name="txtInsuranceStartDate" type="text" id="txtInsuranceStartDate" size="15" />
      <a href="javascript:NewCal('txtInsuranceStartDate','yyyymmdd','true',12)"><img src="cal.gif" width="16" height="16" border="0" /></a></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td>End Date: </td>
      <td colspan="4"><input name="txtInsuranceEndDate" type="text" id="txtInsuranceEndDate" size="15" />
      <a href="javascript:NewCal('txtInsuranceEndDate','yyyymmdd','true',12)"><img src="cal.gif" width="16" height="16" border="0" /></a></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td>Payment</td>
      <td colspan="4"><label>
        <input name="txtInsurancePayment" type="text" id="txtInsurancePayment" size="15" />
      </label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td>Deductible</td>
      <td colspan="4"><label>
        <input name="txtInsuranceDeductible" type="text" id="txtInsuranceDeductible" size="15" />
      </label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td>Notes:</td>
      <td colspan="4"><label>
        <input name="txtInsuranceNote" type="text" id="txtInsuranceNote" size="120" />
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
      <td width="214"><label>
        <center>
          <input name="save" type="button" id="save" accesskey="S" onclick="doFinish(form1)" value=" Save &amp; Exit"/>
        </center>
      </label></td>
      <td width="93"><label></label></td>
      <td width="238"><input name="next" type="button" id="next" accesskey="C" value="      Exit      " onclick="goExit()" /></td>
      <td width="213">&nbsp;</td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</form>
</body>
</html>

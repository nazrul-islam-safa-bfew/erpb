
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>New Schedule Type Entry Form</title>
</head>


<script language="javascript">

//------------------------Disable MEter Combo Box---Enable Date Combo Box----------------------
function goDate()
{
document.form1.sdate.disabled =false;
document.form1.smeter.disabled =true;
}

//-----------------------------Enable MEter Combo Box---Disable Date Combo --------------------------

function goMeter()
{
document.form1.sdate.disabled =true;
document.form1.smeter.disabled =false;
}

//-------------------------------------------------------------------------------
function validate(frm)
{
if(frm.txtschedule.value=="")
{
alert("Please Enter Schedule Name.");
frm.txtschedule.focus()
return false;
}
return true;
}


function doFinish(frm)
{

if(validate(frm)==true)
{
frm.submit();
frm.close();
}
}


//---------Validating CheckBox----------------------------//

</script>



<body>
<form id="form1" name="form1" method="post" action="NewScheduleMedium.php">
  <table width="434" border="0" cellpadding="0" cellspacing="0" bgcolor="#999999">
    <tr>
      <th width="197" scope="col"><div align="left">Enter Schedule Name </div></th>
      <th width="237" scope="col"><div align="left">
          <input name="txtschedule" type="text" id="txtschedule" width="200" />
      </div></th>
    </tr>
    <tr>
      <td><label>
        <input type="radio" name="RadioGroup1" value="date" onclick="goDate()"/>
        </label>
        Track By Date
        <label></label>
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><label>
          <div align="right">Default Tracking By </div>
        </label></td>
      <td><select name="sdate" id="sdate" disabled="disabled">
          <option value="Days">Days</option>
          <option value="Weeks">Weeks</option>
          <option value="Months">Months</option>
          <option value="Years">Years</option>
      </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><input type="radio" name="RadioGroup1" value="meter" onclick="goMeter()"/>
        Track By Meter</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><div align="right">Unit Type </div></td>
      <td><select name="smeter" id="smeter" disabled="disabled">
          <option value="Mileage">Mileage</option>
          <option value="Hours">Hours</option>
          <option value="Kilometers">Kilometers</option>
          <option value="(No Meter Tracking)">(No Meter Tracking)</option>
      </select></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="434" border="0" cellspacing="0" cellpadding="0">
    <tr bgcolor="#33CC33">
      <th scope="col"><input type="button" name="Button" value="      Add      " accesskey="A"  onclick="doFinish(form1)"/></th>
      <th scope="col"><label>
        <input type="button" name="Button" value="    Close    " onclick="javascript:location.href='PMScheduleSetup.php'"/>
      </label></th>
    </tr>
  </table>
  </form>
</body>
</html>

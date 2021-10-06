<?php
include("common.php");
CreateConnection();
//receiving schedule id which needs to be edited...
$schID=$_GET['scheduleid'];
//echo("$schID");
//fetching record which will be edited..
$qry="SELECT schedule_name,schedule_by_date,schedule_by_unit FROM new_schedule_type WHERE schedule_id='$schID'";
$exeqry=mysqli_query($db, $qry);
$rs=mysql_fetch_row($exeqry); 
$schedule_name=$rs[0];
$schedule_by_date=$rs[1];
$schedule_by_unit=$rs[2];

// ---------Assigning Poted Schedule ID ---------------------------//

//-------------------------------------------------------------------------------
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>New Schedule Type Entry Form</title>
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


</head>
<body>
<form id="form1" name="form1" method="post" action="ScheduleEditMedium.php">
  <p>
    <?php echo"<input name='hidField' type='hidden' value='$schID' />"; ?>  </p>
  <table width="434" border="0" cellpadding="0" cellspacing="0" bgcolor="#999999">
    <tr>
      <th width="197" scope="col"><div align="left">Enter Schedule Name </div></th>
      <th width="237" scope="col"><div align="left">
        <input name="txtschedule" type="text" id="txtschedule" width="200" value="<?php echo $schedule_name; ?>" />
      </div></th>
    </tr>
    <tr>
      <td><label>
        <input type="radio" name="RadioGroup1" value="date" onclick="goDate()" <?php if($schedule_by_date!="") echo ' CHECKED '; ?>/>
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
      <td><select name="sdate" id="sdate">
        <option selected="selected"></option>
        <option value="Days" <?php if($schedule_by_date=="Days") echo ' SELECTED '; ?>>Days</option>
        <option value="Weeks" <?php if($schedule_by_date=="Weeks") echo ' SELECTED '; ?>>Weeks</option>
        <option value="Months" <?php if($schedule_by_date=="Months") echo ' SELECTED '; ?>>Months</option>
        <option value="Years" <?php if($schedule_by_date=="Years") echo ' SELECTED '; ?>>Years</option>
                  </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><input type="radio" name="RadioGroup1" value="meter" onclick="goMeter()" <?php if($schedule_by_unit!="") echo ' CHECKED '; ?>/>
        Track By Meter</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><div align="right">Unit Type </div></td>
      <td><select name="smeter" id="smeter">
        <option selected="selected"></option>
        <option value="Mileage" <?php if($schedule_by_unit=="Mileage") echo ' SELECTED '; ?>>Mileage</option>
        <option value="Hours" <?php if($schedule_by_unit=="Hours") echo ' SELECTED '; ?>>Hours</option>
        <option value="Kilometers" <?php if($schedule_by_unit=="Kilometers") echo ' SELECTED '; ?>>Kilometers</option>
        <option value="(No Meter Tracking)" <?php if($schedule_by_unit=="(No Meter Tracking)") echo ' SELECTED '; ?>>(No Meter Tracking)</option>
      </select></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="434" border="0" cellspacing="0" cellpadding="0">
    <tr bgcolor="#33CC33">
      <th scope="col"><input type="button" name="Button" value="     Update    " accesskey="U"  onclick="doFinish(form1)"/></th>
      <th scope="col"><label>
        <input type="button" name="Button2" value="    Close    " onclick="javascript:location.href='PMScheduleSetup.php'"/>
      </label></th>
    </tr>
  </table>
  </form>
</body>
</html>

<?php 
$pm_id=$_GET['pm_service_id'];
$schedule_id=$_GET['schedule_id'];
$pm_service=$_GET['pm_service_name'];
//echo("$pm_service");
//echo("$schedule_id");
$item_pm_type=$_GET['item_pm_type'];
$pm_service_enabled=$_GET['pm_service_enabled'];
$pm_service_priority=$_GET['pm_service_priority'];
$number_of_day=$_GET['number_of_day'];
$day_period=$_GET['day_period'];
//echo("$day_period");
$fixed_date=$_GET['fixed_date'];
$notify_day_advance=$_GET['notify_day_advance'];
$hour_number=$_GET['hour_number'];
$fixed_hour=$_GET['fixed_hour'];
$notify_hour_advance=$_GET['notify_hour_advance'];
$season_start_date=$_GET['season_start_date'];
$season_end_date=$_GET['season_end_date'];
$terminate_task_date=$_GET['terminate_task_date'];
$terminate_task_hour=$_GET['terminate_task_hour'];

if($pm_id=="")
{
echo("Record doesn't Exist.Please Enter Valid PM Services ID");
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PM Services Delete Form</title>


<script type="text/javascript" language="JavaScript1.2" src="stm32.js"></script>
<script language="javascript" type="text/javascript" src="datetimepicker.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" type="text/javascript" SRC="timepicker.js"></SCRIPT>


<script language="javascript">
//---------------------------------------Checking Date Based Task----------------------
/*function checkState()
{
document.form1.radioevery.disabled = !document.form1.radioevery.disabled;
document.form1.radiofixed.disabled = !document.form1.radiofixed.disabled;
}


function chk1()
{
document.form1.txtday.disabled = !document.form1.txtday.disabled;
document.form1.cmbperiod.disabled = !document.form1.cmbperiod.disabled;
}

function chk2()
{
document.form1.cmbfixeddate.disabled = !document.form1.cmbfixeddate.disabled;
}

function goEnable()
{
document.form1.txtnotifyday.disabled = !document.form1.txtnotifyday.disabled;
}

//--------------------------------------------------END--------------------------------


//-----------------------------------------Checking HOUR Based Task------------------------------------------
function hour1()
{
document.form1.radiohour.disabled = !document.form1.radiohour.disabled;
document.form1.radiofixedhour.disabled = !document.form1.radiofixedhour.disabled;
}

function hour2()
{
document.form1.txteveryhour.disabled = !document.form1.txteveryhour.disabled;
//document.form1.radiofixedhour.disabled = document.form1.cmbperiod.disabled;
//document.form1.txtfixedhour.disabled = document.form1.txtfixedhour.disabled;

}

function hour3()
{
document.form1.txtfixedhour.disabled = !document.form1.txtfixedhour.disabled;
//document.form1.txteveryhour.disabled = document.form1.txteveryhour.disabled;
}

function goAdvance()
{
document.form1.txtnotifyhour.disabled = !document.form1.txtnotifyhour.disabled;
}
*/
//--------------------------------------------------END--------------------------------

//---------------------------------------------Checking Button's Click Event--------------------------


function goSubmit()
{
document.form1.hidField.value=1;
document.form1.submit();
}

function goCancel()
{
document.form1.hidField.value=3;
document.form1.submit();

}

//-------------------------------------------------Validating Form Entry------------------------------

function validate(frm)
{
if(frm.txtservice.value=="")
{
alert("You Must Enter Service Name Before This Data Can Be Saved.");
frm.txtservice.focus();
return false;
}
return true;
}


function doFinish(frm)
{
if(validate(frm)==true)
{
document.form1.hidField.value=2;
frm.submit();
}
}


</script>

</head>

<body>
<form id="form1" name="form1" method="post" action="DeleteMedium.php">
  <p>
    <input name="hidField" type="hidden" id="hidField" />
  </p>
  <table width="905" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
    <tr>
      <td>&nbsp;</td>
      <td><?php echo"<input name='schID' type='hidden' value='$schedule_id' />"; ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Enter PM Services ID </td>
      <td><input name="txtpmid" type="text" id="txtpmid" value="<?php echo("$pm_id"); ?>"/></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="15">&nbsp;</td>
      <td width="173">&nbsp;</td>
      <td width="158">&nbsp;</td>
      <td width="99">&nbsp;</td>
      <td width="135">&nbsp;</td>
      <td width="66">&nbsp;</td>
      <td width="259">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Service Name </td>
      <td><label>
        <input name="txtservice" type="text" id="txtservice" value="<?php echo("$pm_service"); ?>" />
      </label></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Type</td>
      <td><label>
        <select name="txttype" id="txttype">
		
          <?php 
		  echo"<option value=$item_pm_type>$item_pm_type</option>";
				include("common.php");
				CreateConnection();
				
				$qry="SELECT item_pm_type FROM equipment_pm_type";
				$qryexecute=mysqli_query($db, $qry);
				
				while($rs=mysql_fetch_row($qryexecute))
				{
				$rs1=$rs[0];
				echo"<option value=$rs[0]>$rs[0]</option>";
				} 
				
				?>
        </select>
      </label></td>
      <td>Enabled</td>
      <td><label>
        <select name="txtenable" id="txtenable">
		<?php echo"<option value=$pm_service_enabled>$pm_service_enabled</option>"; ?>
          <option value="Yes">Yes</option>
          <option value="No">No</option>
        </select>
      </label></td>
      <td>Priority</td>
      <td><label>
        <select name="txtpriority" id="txtpriority">
		<?php echo"<option value=$pm_service_priority>$pm_service_priority</option>"; ?>
          <option value="High">High</option>
          <option value="Medium">Medium</option>
          <option value="Low">Low</option>
        </select>
      </label></td>
    </tr>
    <tr>
      <td height="19">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="19">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <table width="905" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
    <tr>
      <td colspan="4">  Frequency Settings </td>
      <td width="8">&nbsp;</td>
      <td width="8">&nbsp;</td>
      <td width="211">&nbsp;</td>
      <td width="144">&nbsp;</td>
      <td width="42">&nbsp;</td>
    </tr>
    <tr>
      <td width="4">&nbsp;</td>
      <td width="211"><label>
        <input type="checkbox" name="checkbox" value="checkbox"/>
      Task is date based: </label></td>
      <td width="185">&nbsp;</td>
      <td width="92">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="chkhour" type="checkbox" id="chkhour" value="checkbox"/>
Task is Hour based:</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Notify task is due: </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Notify task is due: </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><label>
        <input name="radioevery" type="radio" value="radiobutton" />
      Every</label></td>
      <td><label>
        <input name="txtday" type="text" id="txtday" value="<?php echo"$number_of_day"; ?>"/>
      </label></td>
      <td><label>
        <select name="cmbperiod" id="cmbperiod">
		<?php echo"<option value=$day_period>$day_period</option>"; ?>
          <option value="Day(s)">Day(s)</option>
          <option value="Week(s)">Week(s)</option>
          <option value="Month(s)">Month(s)</option>
          <option value="Year(s)">Year(s)</option>
        </select>
      </label></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="radiohour" type="radio" value="radiobutton" /> 
      Every</td>
      <td><label>
        <input name="txteveryhour" type="text" id="txteveryhour" value="<?php echo("$hour_number"); ?>" />
      </label></td>
      <td>Hours</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><label>
        <input name="radiofixed" type="radio" value="radiobutton" />
      Fixed date(s) </label></td>
      <td><label>
      <input name="loaddate" type="text" id="loaddate" value="<?php echo("$fixed_date"); ?>" size="15" />
      <a href="javascript:NewCal('loaddate','yyyymmdd','true',12)"><img src="cal.gif" width="16" height="16" border="0" /></a></label></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="radiofixedhour" type="radio" value="radiobutton"/>
Fixed Hours(s) </td>
      <td><input name="txtfixedhour" type="text" id="txtfixedhour" value="<?php echo("$fixed_hour"); ?>" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><label>
        <input name="chkenable" type="checkbox" id="chkenable" value="checkbox" onclick="goEnable()" />
      </label>
      Enable Advanced Notification </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="chkadvance" type="checkbox" id="chkadvance" value="checkbox"/>
      Enable Advanced Notification</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Notify
        <label>
        <input name="txtnotifyday" type="text" id="txtnotifyday" value="<?php echo("$notify_day_advance"); ?>"/>
      </label></td>
      <td>days in advance </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Notify
        <label>
        <input name="txtnotifyhour" type="text" id="txtnotifyhour" value="<?php echo("$notify_hour_advance"); ?>"/>
        </label></td>
      <td> hours in advance </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Advanced Option </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><label>
        <input type="checkbox" name="checkbox3" value="checkbox" />
      Seasonal Task-Task will be </label></td>
      <td>ignored during thefollowing  </td>
      <td>date period </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Season Start Date: </td>
      <td><label>
      <input name="loadstart" type="text" id="loadstart" value="<?php echo("$season_start_date"); ?>" size="15" />
      <a href="javascript:NewCal('loadstart','yyyymmdd','true',12)"><img src="cal.gif" width="16" height="16" border="0" /></a></label></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Season End Date: </td>
      <td><input name="loadend" type="text" id="loadend" value="<?php echo("$season_end_date"); ?>" size="15" />
      <a href="javascript:NewCal('loadend','yyyymmdd','true',12)"><img src="cal.gif" width="16" height="16" border="0" /></a></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="checkbox" name="checkbox32" value="checkbox" />
        Termination 
      task tracking   </td>
      <td>on (date): </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="checkbox" name="checkbox322" value="checkbox" />
Termination 
      task tracking </td>
      <td>at (Hours) </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Date: 
        <label>
        <input name="loadterminatedate" type="text" id="loadterminatedate" value="<?php echo("$terminate_task_date"); ?>" size="15" />
        <a href="javascript:NewCal('loadterminatedate','yyyymmdd','true',12)"><img src="cal.gif" width="16" height="16" border="0" /></a></label></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Hours 
        <label>
        <input name="cmbhour" type="text" id="cmbhour" value="<?php echo("$terminate_task_hour"); ?>" />
      </label></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><label>
      <input name="Button" type="button" id="Submit" value="   Submit   " onClick="goSubmit()"/>
      </label></td>
      <td><input type="button" name="Button" value="    Delete    " onclick="doFinish(form1)"/></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><label>
        <input type="reset" name="Submit2" value="   Cancel   " onclick="goCancel()"/>
      </label></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>

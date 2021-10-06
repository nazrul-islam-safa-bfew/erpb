<?php 
include("common.php");
CreateConnection();
//Assigning posted pm service id which needs to be edited....
$pm_id=$_GET['pm_service_id'];
//CRETING SESSION TO HOLD PM SERVICE ID...
session_start();
$_SESSION['pm_s_id']=$pm_id;

//fetching record from add_pm_service table based on the selected pm service.. 
$ins_record="SELECT pm_service_name,item_pm_type,pm_service_enabled,pm_service_priority,number_of_day,  day_period,fixed_date,notify_day_advance,hour_number,fixed_hour,notify_hour_advance,season_start_date,season_end_date, terminate_task_date,terminate_task_hour,task_base FROM add_pm_service WHERE pm_service_id='$pm_id'";

$record_selected=mysqli_query($db, $ins_record);

$rs=mysql_fetch_row($record_selected);

//-------------------------------------------Assigning values to the variables returned by the "$ins_record " Query--------------
$pm_service_name=$rs[0];
$item_pm_type=$rs[1];
$pm_service_enabled=$rs[2];
$pm_service_priority=$rs[3];
$number_of_day=$rs[4];
$day_period=$rs[5];
$fixed_date=$rs[6];
$notify_day_advance=$rs[7];
$hour_number=$rs[8];
$fixed_hour=$rs[9];
$notify_hour_advance=$rs[10];
$season_start_date=$rs[11];
$season_end_date=$rs[12];
$terminate_task_date=$rs[13];
$terminate_task_hour=$rs[14];
$task_base=$rs[15];
//formatting dates..(i.e if dates are blank 0000-00-00 then set it ot blank)..
if($fixed_date=="0000-00-00")
{
$fixed_date='';
}
if($season_start_date=="0000-00-00")
{
$season_start_date='';
}
if($season_end_date=="0000-00-00")
{
$season_end_date='';
}
if($terminate_task_date=="0000-00-00")
{
$terminate_task_date='';
}

//assigning posted hidden value to check wheather update or delete button is clicked value 
$hid=$_POST['hidField'];

//UPDATING RECORD...
if($hid==1)
{
//retreivng  SESSION which holds PM SERVICE ID...
session_start();
$pm_service_id=$_SESSION['pm_s_id'];

//assigning posted value...
$pm_service=$_POST['txtservice'];
$item_pm_type=$_POST['txttype'];
$pm_service_enabled=$_POST['txtenable'];
$pm_service_priority=$_POST['txtpriority'];
$number_of_day=$_POST['txtday'];
$day_period=$_POST['cmbperiod'];
$fixed_date=$_POST['loaddate'];
$notify_day_advance=$_POST['txtnotifyday'];
$hour_number=$_POST['txteveryhour'];
$fixed_hour=$_POST['txtfixedhour'];
$notify_hour_advance=$_POST['txtnotifyhour'];
$season_start_date=$_POST['loadstart'];
$season_end_date=$_POST['loadend'];
$terminate_task_date=$_POST['loadterminatedate'];
$terminate_task_hour=$_POST['terminate_task_hour'];
$task_base=$_POST['select_task_based'];
//UPDATING RECORD
$qry1="UPDATE add_pm_service SET pm_service_name='$pm_service',item_pm_type='$item_pm_type',pm_service_enabled='$pm_service_enabled',pm_service_priority='$pm_service_priority',number_of_day='$number_of_day',day_period='$day_period',fixed_date='$fixed_date',notify_day_advance='$notify_day_advance',hour_number='$hour_number',fixed_hour='$fixed_hour',notify_hour_advance='$notify_hour_advance',season_start_date='$season_start_date',season_end_date='$season_end_date', terminate_task_date='$terminate_task_date',terminate_task_hour='$terminate_task_hour',task_base='$task_base' WHERE pm_service_id='$pm_service_id'";
$qryexecute1=mysqli_query($db, $qry1);
if($qryexecute1)
{
header("Location: PMScheduleSetup.php?pm_service_id=$pm_service_id");
}
}
//DELETE RECORD..
else if($hid==2)
{
//retreivng  SESSION which holds PM SERVICE ID...
session_start();
$pm_service_id=$_SESSION['pm_s_id'];

//query to delete the record regarding pm_service_id
$qry1="DELETE FROM add_pm_service WHERE pm_service_id='$pm_service_id'"; 
$qryexecute1=mysqli_query($db, $qry1);
//check wheather the query is successfully executed or not...
if($qryexecute1)
{
header("Location: PMScheduleSetup.php");
}

}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Edit PM Service</title>


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


/*function goSubmit()
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


//for seasonal task...
function goSeasonalTask()
{
document.form1.loadstart.disabled = !document.form1.loadstart.disabled;
document.form1.loadend.disabled = !document.form1.loadend.disabled;
}


//for termination by date task...goTermination_by_hour()
function goTerminationTask()
{
document.form1.loadterminatedate.disabled = !document.form1.loadterminatedate.disabled;
}


//for termination by hour task...
function goTermination_by_hour()
{
document.form1.cmbhour.disabled = !document.form1.cmbhour.disabled;
}
*/


function every_day()
{
//enable control for every day option...
document.form1.txtday.disabled=false;
document.form1.cmbperiod.disabled = false;

//disable control for fixed date option...
document.form1.loaddate.disabled=true;
}

function fixed_date()
{
//enable control for fixed date option...
document.form1.loaddate.disabled = false;

//disable control for every day option...
document.form1.txtday.disabled = true;
document.form1.cmbperiod.disabled = true;
}

function goEnable()
{
document.form1.txtnotifyday.disabled = !document.form1.txtnotifyday.disabled;
}

//--------------------------------------------------END--------------------------------


//-----------------------------------------Checking HOUR Based Task------------------------------------------
//for every hour option...
function every_hour()
{
//enable control for every hour option...
document.form1.txteveryhour.disabled = false;

//disable control for fixed hour option...
document.form1.txtfixedhour.disabled=true;
}
//for fixed hour option...
function fixed_hour()
{
//enable control for fixed hour option...
document.form1.txtfixedhour.disabled=false;

//disable control for every hour option...
document.form1.txteveryhour.disabled = true;
}


function goAdvance()
{
document.form1.txtnotifyhour.disabled = !document.form1.txtnotifyhour.disabled;
}

//--------------------------------------------------END--------------------------------


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
document.form1.hidField.value=1;
frm.submit();
}
}

//for seasonal task...
function goSeasonalTask()
{
document.form1.loadstart.disabled = !document.form1.loadstart.disabled;
document.form1.loadend.disabled = !document.form1.loadend.disabled;
}


//for termination by date task...goTermination_by_hour()
function goTerminationTask()
{
document.form1.loadterminatedate.disabled = !document.form1.loadterminatedate.disabled;
}


//for termination by hour task...
function goTermination_by_hour()
{
document.form1.cmbhour.disabled = !document.form1.cmbhour.disabled;
}

//delete record (tracking delete button onClick event...
function goDelete()
{
if(confirm("Do You Want To Delete The Pm Service?")==true)
{
document.form1.hidField.value=2;
document.form1.submit();
}
}



//change label according to the selected Task type..
function go_lbl_change(m)
{
document.form1.lbl_current.value=m+":";
document.form1.lbl_base.value=m+":";
}

</script>

<link href="common.css" rel="stylesheet" type="text/css" />
</head>

<body onload="goHide()">
<form id="form1" name="form1" method="post" action="">
    <input name="hidField" type="hidden" id="hidField" />
  <table width="830" border="0" cellpadding="0" cellspacing="0" bgcolor="#999999">
      <tr>
        <td colspan="6" bgcolor="#0099CC" scope="col">Add Pm Service Information </td>
      </tr>
      <tr>
        <td width="144" scope="col">Service Name </td>
        <td colspan="5" scope="col"><input name="txtservice" type="text" id="txtservice" value="<?php echo $pm_service_name; ?>" size="90" /></td>
      </tr>
      <tr>
        <td>Type</td>
        <td width="117"><select name="txttype" id="txttype">
          <option selected="selected"></option>
          <?php 
				$qry="SELECT item_pm_type FROM equipment_pm_type";
				$qryexecute=mysqli_query($db, $qry);
				
				while($rs=mysql_fetch_row($qryexecute))
				{
				$rs1=$rs[0];
				echo"<option value=$rs[0]"; if($rs[0]==$item_pm_type) echo ' SELECTED '; echo">$rs[0]</option>";
				} 
				
				?>
        </select></td>
        <td width="65">Enabled?</td>
        <td width="248"><select name="txtenable" id="txtenable">
          <option selected="selected"></option>
          <option value="Yes" <?php if($pm_service_enabled=="Yes")echo 'SELECTED '; ?>>Yes</option>
          <option value="No" <?php if($pm_service_enabled=="No") echo 'SELECTED '; ?>>No</option>
        </select></td>
        <td width="58">Priority</td>
        <td width="83"><select name="txtpriority" id="txtpriority">
          <option selected="selected"></option>
		  <option value="High" <?php if($pm_service_priority=="High") echo 'SELECTED '; ?>>High</option>
          <option value="Medium" <?php if($pm_service_priority=="Medium") echo 'SELECTED '; ?>>Medium</option>
          <option value="Low" <?php if($pm_service_priority=="Low") echo 'SELECTED '; ?>>Low</option>
        </select></td>
      </tr>
  </table>
  	<br />
  	<table width="830" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="373" bgcolor="#0099CC" scope="col">Frequency Settings        </td>
        <th width="62" scope="col">&nbsp;</th>
        <td width="384" bgcolor="#0099CC" scope="col">Frequency Settings </td>
      </tr>
      <tr>
        <td>
				<div style="display:marker" id="ListList1">

		<table width="373" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
          <tr>
            <td colspan="3" scope="col"><label>
<input type="checkbox" name="checkbox" value="checkbox" onclick="checkState()"/>            
Task is date based </label></td>
          </tr>
          <tr>
            <td width="105"><label></label></td>
            <td width="127">&nbsp;</td>
            <td width="141">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3">Notify tsk is due </td>
          </tr>
          <tr>
            <td><p>
              <label>
                <input type="radio" name="Radiogroup1" value="day" onclick="every_day()"/>
                Every</label>
              <br />
              <label></label>
              <br />
            </p></td>
            <td><label>
              <input name="txtday" type="text" id="txtday" value="<?php echo $number_of_day; ?>" size="15"/>
            </label></td>
            <td><select name="cmbperiod" id="cmbperiod">
              <option selected="selected"></option>
              <option value="Day(s)" <?php if($day_period=="Day(s)") echo ' SELECTED '; ?>>Day(s)</option>
              <option value="Week(s)" <?php if($day_period=="Week(s)") echo ' SELECTED '; ?>>Week(s)</option>
              <option value="Month(s)" <?php if($day_period=="Month(s)") echo ' SELECTED '; ?>>Month(s)</option>
              <option value="Year(s)" <?php if($day_period=="Year(s)") echo ' SELECTED '; ?>>Year(s)</option>
            </select></td>
          </tr>
          <tr>
            <td><input type="radio" name="Radiogroup1" value="date" onclick="fixed_date()"/>
Fixed Date</td>
            <td colspan="2"><input name="loaddate" type="text" id="loaddate" value="<?php echo $fixed_date; ?>" size="15"/>
              <a href="javascript:NewCal('loaddate','yyyymmdd','true',12)"><img src="cal.gif" alt="Calender" width="16" height="16" border="0" /></a></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3"><label>
              </label>              Advanced Notification </td>
          </tr>
          <tr>
            <td>Notify</td>
            <td colspan="2"><input name="txtnotifyday" type="text" id="txtnotifyday" value="<?php echo $notify_day_advance; ?>"/>
            days in advance </td>
          </tr>
        </table>
		</div>
		</td>
        <td>&nbsp;</td>
        <td><table width="430" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
          <tr>
            <td scope="col"><label>
              <input name="chk_hour" type="checkbox" id="chk_hour" value="checkbox" onclick="go_chk_hour()"/>
Task is </label></td>
            <td scope="col"><select name="select_task_based" id="select_task_based" onchange="go_lbl_change(this.value)">
              <option value="" selected="selected"></option>
              <option value="Miles" <?php if($task_base=="Miles") echo ' SELECTED '; ?>>Miles</option>
              <option value="Kilometers" <?php if($task_base=="Kilometers") echo ' SELECTED '; ?>>Kilometers</option>
              <option value="Meters" <?php if($task_base=="Meters") echo ' SELECTED '; ?>>Meters</option>
              <option value="Feets" <?php if($task_base=="Feets") echo ' SELECTED '; ?>>Feets</option>
              <option value="Hours" <?php if($task_base=="Hours") echo ' SELECTED '; ?>>Hours</option>
            </select></td>
            <td scope="col">based:</td>
            <td scope="col">&nbsp;</td>
          </tr>
          <tr>
            <td width="137" colspan="2"><label></label></td>
            <td width="178">&nbsp;</td>
            <td width="77">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4">Notify tsk is due </td>
          </tr>
          <tr>
            <td colspan="2"><p>
                <label>
                <input type="radio" name="RadioGroup2" value="every" onclick="every_hour()"/>
                  Every</label>
                <br />
                <label></label>
                <br />
            </p></td>
            <td><label>
            <input name="txteveryhour" type="text" id="txteveryhour" value="<?php echo $hour_number; ?>" />
            </label></td>
            <td><input name="lbl_current" type="text" class="ar" id="lbl_current" style="border:none" value="<?php echo $task_base; ?>" size="10" readonly="READONLY"/></td>
          </tr>
          <tr>
            <td colspan="2"><input type="radio" name="RadioGroup2" value="fixed" onclick="fixed_hour()"/>
Fixed
<input name="lbl_base" type="text" class="ar" id="lbl_base" style="border:none" value="<?php echo $task_base; ?>" size="12" readonly="READONLY"/>
</td>
            <td colspan="2">
              <input name="txtfixedhour" type="text" id="txtfixedhour" value="<?php echo $fixed_hour; ?>" />
            </td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4">Advanced Notification</td>
          </tr>
          <tr>
            <td colspan="2">Notify
            <label></label></td>
            <td colspan="2">
              <input name="txtnotifyhour" type="text" id="txtnotifyhour" value="<?php echo $notify_hour_advance; ?>"/>
            hours in advance</td>
          </tr>
        </table></td>
      </tr>
    </table>
  	<br />
  	<table width="831" border="0" cellpadding="0" cellspacing="0" bgcolor="#999999">
      <tr bgcolor="#0099CC">
        <td width="136" scope="col">Advanced Option </td>
        <th width="398" bgcolor="#0099CC" scope="col">&nbsp;</th>
        <th width="151" scope="col">&nbsp;</th>
        <th width="146" scope="col">&nbsp;</th>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4"><input type="checkbox" name="checkbox3" value="checkbox" onclick="goSeasonalTask()" disabled="disabled"/>
Seasonal Task-Task will be ignored during thefollowing  date period </td>
      </tr>
      <tr>
        <td>Season Start Date: </td>
        <td><input name="loadstart" type="text" id="loadstart" value="<?php echo $season_start_date; ?>" size="15" disabled="disabled"/>
          <a href="javascript:NewCal('loadstart','yyyymmdd','true',12)"><img src="cal.gif" alt="Calender" width="16" height="16" border="0" /></a></td>
        <td>Season End Date: </td>
        <td><input name="loadend" type="text" id="loadend" value="<?php echo $season_end_date; ?>" size="15" disabled="disabled"/>
          <a href="javascript:NewCal('loadend','yyyymmdd','true',12)"><img src="cal.gif" alt="Calender" width="16" height="16" border="0" /></a></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"><input type="checkbox" name="checkbox32" value="checkbox" onclick="goTerminationTask()" disabled="disabled"/>
Termination 
      task tracking on (date): </td>
        <td colspan="2"><input type="checkbox" name="checkbox322" value="checkbox" onclick="goTermination_by_hour()" disabled="disabled"/>
Termination 
      task tracking at (Hours) </td>
      </tr>
      <tr>
        <td>Date:
        <label></label></td>
        <td><input name="loadterminatedate" type="text" id="loadterminatedate" value="<?php echo $terminate_task_date; ?>" size="15" disabled="disabled"/>
          <a href="javascript:NewCal('loadterminatedate','yyyymmdd','true',12)"><img src="cal.gif" alt="Calender" width="16" height="16" border="0" /></a></td>
        <td>Hours
        <label></label></td>
        <td><input name="cmbhour" type="text" id="cmbhour" value="<?php echo $terminate_task_hour; ?>" disabled="disabled"/></td>
      </tr>
    </table>
  	<br />
  	<table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <th width="121" scope="col"><input name="Bupdate" type="button" id="Bupdate" onclick="doFinish(form1)" value="  Update   "/></th>
        <th width="113" scope="col"><label>
          <input name="Bdelete" type="button" id="Bdelete" value="   Delete   " onclick="goDelete()"/>
        </label></th>
        <th width="129" scope="col"><img src="Images/Cancel.gif" alt="Cancle" width="78" height="20" onclick="javascript:location.href='PMScheduleSetup.php'"/></th>
        <th width="37" scope="col">&nbsp;</th>
      </tr>
    </table>

</form>
</body>
</html>

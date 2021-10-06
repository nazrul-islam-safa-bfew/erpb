<?php
include("common.php");
CreateConnection();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PM Services Entry Form</title>


<script type="text/javascript" language="JavaScript1.2" src="stm32.js"></script>
<script language="javascript" type="text/javascript" src="datetimepicker.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" type="text/javascript" SRC="timepicker.js"></SCRIPT>


<script language="javascript">

//this function will be executed when the form is loaded to check wheather the schedule is date baed or meter based...
function goHide()
{
//disabling controls connected with date..
document.form1.txtday.disabled=true;
document.form1.cmbperiod.disabled=true; 
document.form1.loaddate.disabled=true; 
document.form1.Radiogroup1[0].disabled=true; 
document.form1.Radiogroup1[1].disabled=true; 
document.form1.loadstart.disabled=true; 
document.form1.loadend.disabled=true; 
document.form1.loadterminatedate.disabled=true;
document.form1.txtnotifyday.disabled=true; 
//disabling controols connected with meter...
document.form1.RadioGroup2[0].disabled=true; 
document.form1.RadioGroup2[1].disabled=true;
document.form1.txteveryhour.disabled=true;
document.form1.txtfixedhour.disabled=true;
document.form1.txtnotifyhour.disabled=true;
document.form1.cmbhour.disabled=true;
}





//---------------------------------------Enable+Disable  Date Based Task----------------------
function checkState()
{

document.form1.Radiogroup1[0].disabled=!document.form1.Radiogroup1[0].disabled;
document.form1.Radiogroup1[1].disabled=!document.form1.Radiogroup1[1].disabled;
document.form1.txtnotifyday.disabled=!document.form1.txtnotifyday.disabled;
}


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

// Enable disable all option under Task is Hour Based check box..
function go_chk_hour()
{
//alert("HI");
document.form1.select_task_based.disabled=!document.form1.select_task_based.disabled;
document.form1.RadioGroup2[0].disabled=!document.form1.RadioGroup2[0].disabled;
document.form1.RadioGroup2[1].disabled=!document.form1.RadioGroup2[1].disabled;
document.form1.txtnotifyhour.disabled=!document.form1.txtnotifyhour.disabled;
}


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


/*function goAdvance()
{
document.form1.txtnotifyhour.disabled = !document.form1.txtnotifyhour.disabled;
}
*/
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
<form id="form1" name="form1" method="post" action="AddPMServiceMedium.php">
  	<table width="830" border="0" cellpadding="0" cellspacing="0" bgcolor="#999999">
      <tr>
        <td colspan="6" bgcolor="#0099CC" scope="col">Add Pm Service Information </td>
      </tr>
      <tr>
        <td width="144" scope="col">Service Name </td>
        <td colspan="5" scope="col"><input name="txtservice" type="text" id="txtservice" size="90" /></td>
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
				echo"<option value=$rs[0]>$rs[0]</option>";
				} 
				
				?>
        </select></td>
        <td width="65">Enabled?</td>
        <td width="248"><select name="txtenable" id="txtenable">
              <option selected="selected"></option>
          <option value="Yes">Yes</option>
          <option value="No">No</option>
        </select></td>
        <td width="58">Priority</td>
        <td width="83"><select name="txtpriority" id="txtpriority">
              <option selected="selected"></option>
          <option value="High" selected="selected">High</option>
          <option value="Medium">Medium</option>
          <option value="Low">Low</option>
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
        <td><table width="373" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
          <tr>
            <td colspan="3" scope="col"><label>
<input name="chk_task" type="checkbox" id="chk_task" onclick="checkState()" value="checkbox"/>            
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
              <input name="txtday" type="text" id="txtday" size="15" />
            </label></td>
            <td><select name="cmbperiod" id="cmbperiod">
              <option selected="selected"></option>
              <option value="Day(s)">Day(s)</option>
              <option value="Week(s)">Week(s)</option>
              <option value="Month(s)">Month(s)</option>
              <option value="Year(s)">Year(s)</option>
            </select></td>
          </tr>
          <tr>
            <td><input type="radio" name="Radiogroup1" value="date" onclick="fixed_date()"/>
Fixed Date</td>
            <td colspan="2"><input name="loaddate" type="text" id="loaddate" size="15"/>
              <a href="javascript:NewCal('loaddate','yyyymmdd','true',12)"><img src="cal.gif" alt="Calender" width="16" height="16" border="0" /></a></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3"><label></label>
Advanced Notification </td>
          </tr>
          <tr>
            <td>Notify</td>
            <td colspan="2"><input name="txtnotifyday" type="text" id="txtnotifyday"/>
            days in advance </td>
          </tr>
        </table></td>
        <td>&nbsp;</td>
        <td><table width="430" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
          <tr>
            <td width="75" scope="col"><label>
<input name="chk_hour" type="checkbox" id="chk_hour" value="checkbox" onclick="go_chk_hour()"/>
Task is 
 
</label></td>
            <td width="103" scope="col"><select name="select_task_based" id="select_task_based" onchange="go_lbl_change(this.value)" disabled="disabled">
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
            <td colspan="2"><label></label></td>
            <td width="146">&nbsp;</td>
            <td width="106">&nbsp;</td>
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
            <input name="txteveryhour" type="text" id="txteveryhour" />
            </label></td>
            <td><input name="lbl_current" type="text" class="ar" id="lbl_current" style="border:none" size="10" readonly="READONLY"/></td>
          </tr>
          <tr>
            <td colspan="2"><input type="radio" name="RadioGroup2" value="fixed" onclick="fixed_hour()"/>
Fixed <a href="javascript:NewCal('loaddate','yyyymmdd','true',12)">
<input name="lbl_base" type="text" class="ar" id="lbl_base" style="border:none" size="12" readonly="READONLY"/>
</a></td>
            <td>
              <input name="txtfixedhour" type="text" id="txtfixedhour"/>
            </td>
            <td></td>
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
              <input name="txtnotifyhour" type="text" id="txtnotifyhour"/>
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
        <td colspan="4"><input name="chk_sesonal_service" type="checkbox" id="chk_sesonal_service" onclick="goSeasonalTask()" value="True" disabled="disabled"/>
Seasonal Task-Task will be ignored during thefollowing  date period </td>
      </tr>
      <tr>
        <td>Season Start Date: </td>
        <td><input name="loadstart" type="text" id="loadstart" size="15" disabled="disabled"/>
        <a href="javascript:NewCal('loadstart','yyyymmdd','true',12)"><img src="cal.gif" alt="Calender" width="16" height="16" border="0" /></a></td>
        <td>Season End Date: </td>
        <td><input name="loadend" type="text" id="loadend" size="15" disabled="disabled"/>
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
        <td><input name="loadterminatedate" type="text" id="loadterminatedate" size="15" disabled="disabled">
          <a href="javascript:NewCal('loadterminatedate','yyyymmdd','true',12)"><img src="cal.gif" alt="Calender" width="16" height="16" border="0" /></a></td>
        <td>Hours
        <label></label></td>
        <td><input name="cmbhour" type="text" id="cmbhour" size="15" disabled="disabled"/></td>
      </tr>
    </table>
  	<br />
  	<table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <th width="51" scope="col">&nbsp;</th>
        <th width="149" scope="col"><img src="Images/Save.gif" alt="Save" width="78" height="20" onclick="doFinish(form1)"/></th>
        <th width="160" scope="col"><img src="Images/Cancel.gif" alt="Cancle" width="78" height="20" onclick="javascript:location.href='PMScheduleSetup.php'"/></th>
        <th width="40" scope="col">&nbsp;</th>
      </tr>
    </table>
</form>
</body>
</html>

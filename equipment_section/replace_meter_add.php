<?php
include("connection.php");
include("modified_common.php");
//assigning posted hidden value to the varible
$hid=$_POST['hid'];
//executes codes depend upon the hidden value
if($hid==1)
{
//SAve record in the replace_meter_reading table

//assigning poted value to the variable
$itm_track_id=$_POST['item_track_id'];
$txt_issued=$_POST['txt_issued'];
$txt_curr=$_POST['txt_curr'];
$txt_replace=$_POST['txt_replace'];
$txt_desc=$_POST['txt_desc'];
//RETREIVE itemCode FROM THE equipment TABLE BASED ON THE itm_track_id
$qry="SELECT itemCode FROM equipment WHERE eqid='$itm_track_id'";
$qry_execute=mysqli_query($db, $qry,$connection);
$rs=mysql_fetch_row($qry_execute);
$itm_code=$rs[0];
//echo $itm_code;
//Saving...
mysqli_query($db, "BEGin;");
 
$qry_ins="INSERT INTO replace_meter_reading VALUE('$itm_track_id','$itm_code','$txt_issued','$txt_curr','$txt_replace','$txt_desc')";
$qry_ins_exec=mysqli_query($db, $qry_ins,$connection_equip);

//update meter readings in the add_equipment_maintenance+track_equipments table
//UPDATE  track_equipments TABLE which isused to track equipment...
$qry="UPDATE track_equipments SET item_curr_kilometer='$txt_replace',update_curr_meter_date='$txt_issued' WHERE itm_track_id='$itm_track_id'";
$executeqry=mysqli_query($db, $qry,$connection_equip);

//UPDATE  add_equipment_maintenance TABLE...
$qry_update="UPDATE add_equipment_maintenance SET item_curr_kilometer='$txt_replace',update_curr_meter_date='$txt_issued' WHERE itm_track_id='$itm_track_id'";
$execute_qry_update=mysqli_query($db, $qry_update,$connection_equip);

mysqli_query($db, "COMMIT;"); 
//check wheather the query is succefully executed or not
if($qry_ins_exec)
{
header("Location: replace_meter_reading.php");
}
else
{
echo"Duplicate entry for the Item!Please select other item.";
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Add Meter Replacement</title>
<!-- Javascript for using xmlhttp obsects -->
<script src="script.js" type="text/javascript"></script>
<!--  END -->

<!-- Javascript For The Date Retreival  -->
<script type="text/javascript" language="JavaScript1.2" src="stm32.js"></script>
<script language="javascript" type="text/javascript" src="datetimepicker.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" type="text/javascript" SRC="timepicker.js"></SCRIPT>
<!-- END  -->

<script language="javascript">
//saving record
function goSave()
{
if(document.form1.txt_issued.value=="")
{
alert("Date can't be left blank.Please select date.");
document.form1.txt_issued.focus();
}
else if(document.form1.txt_replace.value=="")
{
alert("Meter replacement reading can't be left blank.Please enter meter replacement reading.");
document.form1.txt_issued.focus();
}
//if the entered replacement reading character data..
else if(isNaN(document.form1.txt_replace.value))
{
alert("Invalid entry.Please enter numeric data for meter replacement reading.");
document.form1.txt_issued.focus();
}
else
{
document.form1.hid.value=1;
document.form1.submit();
}
}

//implementing AJAX technology to retreive items meter reading from track_equipments table
function goChange(m)
{
//alert(m);
xmlhttp.open("GET", 'meter_reading_server.php?item_trk=' + m);
xmlhttp.onreadystatechange = function() {
if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
document.form1.txt_curr.value=xmlhttp.responseText;
}
}
 xmlhttp.send(null);
}
</script>
<link href="common.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="418" cellpadding="0" cellspacing="0">
    <tr>
      <td width="131">Identification</td>
      <td width="369"><label>
        <select name="item_track_id" id="item_track_id" onchange="goChange(this.value)">
		<option value="" selected="selected"></option>
									<?php
include("modified_common.php");
										//retreive meter replace ment information from the replace_meter_reading table 
										$qry="SELECT itm_track_id FROM add_equipment_maintenance";
										$qryexecute=mysqli_query($db, $qry,$connection_equip);
										while($rs=mysql_fetch_row($qryexecute))
										{
											$itm_track_id=$rs[0];
								//select teqSpec from the equipment table base on the selected itm_track_id from bfewdb database
									$qry_tech="select itemCode,teqSpec from equipment where eqid='$itm_track_id'";
									$qrytech_execute=mysqli_query($db, $qry_tech,$connection);
									$rs_tech=mysql_fetch_row($qrytech_execute);
									$item_code=$rs_tech[0];
									$item_identification=$rs_tech[1];
											echo"<option value='$itm_track_id'>-> $item_code : $item_identification</option>";
										}
									?>
		
        </select>
      </label></td>
    </tr>
    <tr>
      <td>Date</td>
      <td><input name="txt_issued" type="text" id="txt_issued" size="15" readonly="READONLY"/>
        <a href="javascript:NewCal('txt_issued','yyyymmdd','true',12)"><img src="cal.gif" alt="calender" width="16" height="16" border="0" /></a></td>
    </tr>
    <tr>
      <td>Current Reading</td>
      <td><label>
        <input name="txt_curr" type="text" id="txt_curr" READONLY/>
      </label></td>
    </tr>
    <tr>
      <td>Replacement</td>
      <td><input name="txt_replace" type="text" id="txt_replace" />
      <input name="hid" type="hidden" id="hid" /></td>
    </tr>
    <tr>
      <td>Description</td>
      <td><input name="txt_desc" type="text" id="txt_desc" size="40" /></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="Images/Save.gif" alt="Save" width="78" height="20" onclick="goSave()"/>&nbsp;&nbsp;</label>
      <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="Images/Cancel.gif" alt="Cancel" width="78" height="20" onclick="javascript:location.href='replace_meter_reading.php'"/></label></td>
    </tr>
  </table>
</form>
</body>
</html>

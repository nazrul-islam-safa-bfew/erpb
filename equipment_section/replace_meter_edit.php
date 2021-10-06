<?php
include("connection.php");
include("modified_common.php");
//assigning posted hidden value to the varible
$hid=$_POST['hid'];
//executes codes depend upon the hidden value
if($hid==1)
{
//SAve record in the replace_meter_reading table
//retreiving session value which hold item_track_id of the equipment that is being edited..
session_start();
$itm_trking_id=$_SESSION['trk_id'];
//assigning poted value to the variable
$txt_issued=$_POST['txt_issued'];
$txt_curr=$_POST['txt_curr'];
$txt_replace=$_POST['txt_replace'];
$txt_desc=$_POST['txt_desc'];

/*//RETREIVE ITEM_ID FROM THE add_equipment_maintenance TABLE BASED ON THE itm_track_id
$qry="SELECT item_id FROM add_equipment_maintenance WHERE itm_track_id='$itm_track_id'";
$qry_execute=mysqli_query($db, $qry);
$rs=mysql_fetch_row($qry_execute);
$itm_code=$rs[0];
//echo $itm_code;*/

//Saving...
mysqli_query($db, "BEGin;");
 
$qry_ins="UPDATE replace_meter_reading SET date_replaced='$txt_issued',current_reading='$txt_curr',replace_reading='$txt_replace',description='$txt_desc' WHERE itm_track_id='$itm_trking_id'";
$qry_ins_exec=mysqli_query($db, $qry_ins,$connection_equip);

//update meter readings in the add_equipment_maintenance+track_equipments table
//UPDATE  track_equipments TABLE which isused to track equipment...
$qry="UPDATE track_equipments SET item_curr_kilometer='$txt_replace',update_curr_meter_date='$txt_issued' WHERE itm_track_id='$itm_trking_id'";
$executeqry=mysqli_query($db, $qry,$connection_equip);

//UPDATE  add_equipment_maintenance TABLE...
$qry_update="UPDATE add_equipment_maintenance SET item_curr_kilometer='$txt_replace',update_curr_meter_date='$txt_issued' WHERE itm_track_id='$itm_trking_id'";
$execute_qry_update=mysqli_query($db, $qry_update,$connection_equip);

mysqli_query($db, "COMMIT;"); 
//check wheather the query is succefully executed or not
if($qry_ins_exec)
{
header("Location: replace_meter_reading.php");
}
else
{
echo"Error occured while replacing meter!";
}
}
else if($hid==2)
{
//assigning posted hidden value..
$itm_trk_id=$_POST['item_track_id'];
//echo $itm_trk_id;
//creating session to hold item_track_id of the equipment that needs to be edited..
session_start();
$_SESSION['trk_id']=$itm_trk_id;
//fetch selected item's related information from replace_meter_reading table...
$qry_replace="SELECT date_replaced,current_reading,replace_reading,description FROM replace_meter_reading WHERE itm_track_id='$itm_trk_id'";
$qry_replace_execute=mysqli_query($db, $qry_replace,$connection_equip);
$rs=mysql_fetch_row($qry_replace_execute);
$date_replaced=$rs[0];
$current_reading=$rs[1];
$replace_reading=$rs[2];
$description=$rs[3];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Edit Equipment For Meter Replacement</title>
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

//executed when an equipment is selected from the list
function goChange(m)
{
//alert(m);
document.form1.hid.value=2;
document.form1.submit();
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
									//retreiving session value which hold item_track_id of the equipment that is being edited..
									session_start();
										$itm_trking_id=$_SESSION['trk_id'];

										//retreive meter replace ment information from the replace_meter_reading table 
										$qry="SELECT itm_track_id FROM replace_meter_reading";
										$qryexecute=mysqli_query($db, $qry,$connection_equip);
										while($rs=mysql_fetch_row($qryexecute))
										{
											$item_track_id=$rs[0];
											//fetch item identification corresponds to the itm_track_id..
						$qry_trk="SELECT itemCode,teqSpec FROM equipment WHERE eqid='$item_track_id'";
						$qry_trk_execute=mysqli_query($db, $qry_trk,$connection);
						$rs1=mysql_fetch_row($qry_trk_execute);	
						$itm_cd=$rs1[0];				
						$itm_identification=$rs1[1];
						echo"<option value='$item_track_id'"; if($item_track_id==$itm_trking_id)echo ' SELECTED '; echo">->$itm_cd : $itm_identification</option>";
										}
									?>
		
        </select>
      </label></td>
    </tr>
    <tr>
      <td>Date</td>
      <td><input name="txt_issued" type="text" id="txt_issued" size="15" readonly="READONLY" value="<?php echo $date_replaced; ?>"/>
        <a href="javascript:NewCal('txt_issued','yyyymmdd','true',12)"><img src="cal.gif" alt="calender" width="16" height="16" border="0" /></a></td>
    </tr>
    <tr>
      <td>Current Reading</td>
      <td><label>
        <input name="txt_curr" type="text" id="txt_curr" value="<?php echo $current_reading; ?>" READONLY/>
      </label></td>
    </tr>
    <tr>
      <td>Replacement</td>
      <td><input name="txt_replace" type="text" id="txt_replace" value="<?php echo $replace_reading; ?>" />
      <input name="hid" type="hidden" id="hid" /></td>
    </tr>
    <tr>
      <td>Description</td>
      <td><input name="txt_desc" type="text" id="txt_desc" value="<?php echo $description; ?>" size="40" /></td>
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

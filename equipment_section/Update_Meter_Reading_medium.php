<?php  
include("common.php");
CreateConnection();
//retreiving system date..
$date=date('Y-m-d');
//assigning equipment id,equipment identification and meter reading send by header..
$equip_id=$_GET['equip_id'];
//creating session to hold equipment id for further implemantation..
session_start();
$_SESSION['equipment_id']=$equip_id;

// fetch equipment identification and current meter reading based on the selected  item_track_id
									$qry_tech="select teqSpec from equipment where eqid='$equip_id'";
									$qrytech_execute=mysqli_query($db, $qry_tech);
									$rs_tech=mysql_fetch_row($qrytech_execute);
									$equip_identificaton=$rs_tech[0];

								$qry_tech1="select item_curr_kilometer from add_equipment_maintenance where itm_track_id='$equip_id'";
									$qrytech_execute1=mysqli_query($db, $qry_tech1);
									$rs_tech1=mysql_fetch_row($qrytech_execute1);
									$curr_m_reading=$rs_tech1[0];

//Used to track wheather the record is saved or not...
$hid=$_POST['hidField'];
//SAVE RECORD...
if($hid==1)
{
$itm_current_kilometer=$_POST['txt_reading'];
//RETREIVING SESSION VALUE..WHICH HOLDS THE EQUIPMENT ID..
session_start();
$equip_id=$_SESSION['equipment_id'];
//echo $equip_id;

mysqli_query($db, "BEGin;"); 
//UPDATE  track_equipments TABLE used to track equipment...
$qry="UPDATE track_equipments SET item_curr_kilometer='$itm_current_kilometer',update_curr_meter_date='$date' WHERE itm_track_id='$equip_id'";
$executeqry=mysqli_query($db, $qry);


//UPDATE  add_equipment_maintenance TABLE...
$qry_update="UPDATE add_equipment_maintenance SET item_curr_kilometer='$itm_current_kilometer',update_curr_meter_date='$date' WHERE itm_track_id='$equip_id'";
$execute_qry_update=mysqli_query($db, $qry_update);
mysqli_query($db, "COMMIT;"); 

if($execute_qry_update)
{
header("Location: Update_Meter_Reading.php");
}
else
{
echo"Couldn't Connect To The Database.";
}

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Update Meter Reading For <?php echo $equip_identificaton; ?>...</title>
<script language="javascript">
//saving Record..
function goUpdate()
{
document.form1.hidField.value=1;
document.form1.submit();
}
</script>


</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="348" border="0" cellpadding="0" cellspacing="0" bgcolor="#999999">
    <tr bgcolor="#999999">
      <th width="145" scope="col"><div align="left">Identification</div></th>
      <th width="203" scope="col"><div align="left">
        <label>
        <input name="txt_identification" type="text" id="txt_identification" value="<?php echo $equip_identificaton; ?>" size="30" READONLY/>
        </label>
      </div></th>
    </tr>
    
    <tr>
      <th height="2">&nbsp;</th>
      <td height="2">&nbsp;</td>
    </tr>
    <tr bgcolor="#999999">
      <th><div align="left">Current Reading </div></th>
      <td><input name="txt_reading" type="text" id="txt_reading" value="<?php echo $curr_m_reading; ?>" size="15" /></td>
    </tr>
  </table>
  <input name="hidField" type="hidden" id="hidField" />
  <br />
  <table width="348" border="0" cellspacing="0" cellpadding="0">
    <tr bgcolor="#0099CC">
      <th width="190" scope="col"><label>
        <input name="Bupdate" type="button" id="Bupdate" value="Update Meter Reading" onclick="goUpdate()"/>
      </label></th>
      <th width="158" scope="col"><input name="Bcancle" type="button" id="Bcancle" value="    Cancel    " onclick="javascript:location.href='Update_Meter_Reading.php'"/></th>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
</body>
</html>

<?php 
include("modified_common.php");
//retreiving session value which hold the itm_track_id for the item that we are editing 
session_start();
$itm_id=$_SESSION['item_code']; 
//echo"$itm_id";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Equipment Information Edit Form</title>
<style type="text/css">
<!--
.style1 {
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 18px;
	color: #CC0000;
}
.style2 {
	color: #669933;
	font-family: "Courier New", Courier, monospace;
}
.style13 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
}
.style14 {font-family: "Courier New", Courier, monospace; font-weight: bold; font-size: 18px; color: #669933; }
.style16 {font-weight: bold; color: #000; font-family: Verdana, Arial, Helvetica, sans-serif;}
.style18 {	font-size: 16px;
	font-weight: bold;
	color: #FF0000;
}
.style19 {	color: #FF0000;
	font-weight: bold;
}
-->
</style>

<script type="text/javascript" language="JavaScript1.2" src="stm32.js"></script>
<script language="javascript" type="text/javascript" src="datetimepicker.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" type="text/javascript" SRC="timepicker.js"></SCRIPT>




<script language="javascript">

//--------------------------------------------Traking Button's Click Event------------------------------
function goChange(m)
{

document.form1.hid_item_id.value=m;
document.form1.hidField.value=1;
document.form1.submit();
//alert(document.form1.hid_item_id.value);
}

function goChange1(l,k)
{
//alert(l);
//alert(k);
var d=k+' - '+l;
document.form1.txtidentification.value=d;
}


function goClose()
{
document.form1.hidField.value=3;
document.form1.submit();
}

function goUpdate()
{
document.form1.hidField.value=2;
document.form1.submit();
}

//----------------------------------------------------END---------------------------

//change label according to the selected meter type..
function go_lbl_change(m)
{
document.form1.lbl_current.value="Curr. "+m+":";
document.form1.lbl_base.value="Base "+m+":";
}

</script>
<link href="common.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
	  $itm_make=$_GET['item_make']; 
	  $itm_model=$_GET['item_model']; 
	  $itm_type=$_GET['item_type']; 
	  $pm_srv_id=$_GET['pm_service_id']; 
	  $itm_meter_type=$_GET['item_meter_type']; 
	  $itm_status=$_GET['item_status']; 
	  $itm_assigned_to=$_GET['item_assigned_to']; 
	  
//echo("$itm_id");
?>
<form id="form1" name="form1" method="post" action="EditNewEquipmentMedium.php">
    <input name="hidField" type="hidden" id="hidField" />
    <input name="hid_item_id" type="hidden" id="hid_item_id" />
  <table width="705" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
    <tr>
      <td colspan="5" bgcolor="#33CC33">Edit Equiptment - General Information </td>
    </tr>
    <tr>
      <td><span class="style18">Identification</span></td>
      <td colspan="2">&nbsp;</td>
      <td><span class="style19">PM Tracking</span></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="132">Select Item Code :</td>
      <td colspan="2"><label>
      <select name="item_id" id="item_id" onchange="goChange(item_id.value)">
        <option selected="selected"></option>
        <?php 
											$rs="SELECT itm_track_id FROM add_equipment_maintenance";
																			
														$result = mysqli_query($db, $rs,$connection_equip);
														while ($name_row = mysql_fetch_row($result))
														{
															$itm_track_id=$name_row[0];
									  include("connection.php");
								//fetch equipment information from the equipment table....
								$shw_equip="SELECT itemCode,teqSpec FROM equipment where eqid='$itm_track_id'";
										$result1 = mysqli_query($db, $shw_equip,$connection);
										$rs1=mysql_fetch_row($result1);
										$itm_code=$rs1[0];
										$teqSpec=$rs1[1];
														echo"<option value='$itm_track_id'";
														if($itm_track_id==$itm_id) echo ' SELECTED ';
														echo">-> $itm_code : $teqSpec</option>";		
														}
														
																
														
														
									?>
      </select>
      </label></td>
      <td width="145">Maintenance Service:</td>
      <td width="152"><select name="selectMaintenance" id="selectMaintenance">
        <option value="" selected="selected"></option>
        <?php  
include("modified_common.php");

							
													$rs="SELECT pm_service_id,pm_service_name FROM add_pm_service";
																		
													$result = mysqli_query($db, $rs);
													while ($name_row = mysql_fetch_row($result)) {
													$pm_service_id=$name_row[0];
													$pm_service_name=$name_row[1];
													echo"<option value='$pm_service_id'"; if($pm_service_id==$pm_srv_id) echo ' SELECTED '; echo">$pm_service_name</option>";		
													}
													
															
													
													
										?>
                              </select></td>
    </tr>
    <tr>
      <td>Year :</td>
      <td colspan="2"><input name="txtspecification" type="text" id="txtspecification" onchange="goChange1(txtspecification.value,item_id.value)" value="<?php echo $_GET['item_desc']; ?>"/></td>
      <td>Meter Type :</td>
      <td><select name="selectMeter" id="selectMeter" onchange="go_lbl_change(this.value)">
        <option value="" selected="selected"></option>
        <?php  
							
include("modified_common.php");
							
													$rs="SELECT meter_type FROM equipment_meter_type";
																		
													$result = mysqli_query($db, $rs);
													while ($name_row = mysql_fetch_row($result)) {
													$meter_type=$name_row[0];
													echo"<option value='$meter_type'";
													if($meter_type==$itm_meter_type) echo ' SELECTED ';
													echo">$meter_type</option>";		
													}
													
															
													
													
										?>
      </select></td>
    </tr>
    <tr>
      <td>Make :</td>
      <td colspan="2"><select name="selectMake" id="selectMake">
        <option value="" selected="selected"></option>
        <?php  
							
include("modified_common.php");
							
													$rs="SELECT item_make FROM equipment_make";
																		
													$result = mysqli_query($db, $rs);
													while ($name_row = mysql_fetch_row($result)) {
													$rs_item_make=$name_row[0];
													echo"<option value='$rs_item_make'";
													if($rs_item_make==$itm_make) echo ' SELECTED ';
													echo">$rs_item_make</option>";		
													}
													
															
													
													
										?>
      </select></td>
      <td><input name="lbl_current" type="text" class="ar" id="lbl_current" style="border:none" value="<?php echo $_GET['lbl_current_meter']; ?>" readonly="READONLY"/></td>
      <td><input name="txtcurrent" type="text" id="txtcurrent" value="<?php echo $_GET['item_curr_kilometer']; ?>"/></td>
    </tr>
    <tr>
      <td>Model :</td>
      <td colspan="2"><select name="selectModel" id="selectModel">
        <option value="" selected="selected"></option>
        <?php  
							
include("modified_common.php");
							
													$rs="SELECT item_model FROM equipment_model_type";
																		
													$result = mysqli_query($db, $rs);
													while ($name_row = mysql_fetch_row($result)) {
													$item_model=$name_row[0];
													echo"<option value='$item_model'";
													if($item_model==$itm_model) echo ' SELECTED ';
													echo">$item_model</option>";		
													}
													
															
													
													
										?>
      </select></td>
      <td><input name="lbl_base" type="text" class="ar" id="lbl_base" style="border:none" value="<?php echo $_GET['lbl_base_meter']; ?>" readonly="READONLY"/></td>
      <td><input name="txtbase" type="text" id="txtbase" value="<?php echo $_GET['item_base_kilometer']; ?>"/></td>
    </tr>
    <tr>
      <td>Identification :</td>
      <td colspan="2"><input name="txtidentification" type="text" id="txtidentification" value="<?php echo $_GET['item_identification']; ?>"/></td>
      <td>Base Date : </td>
      <td><a href="javascript:NewCal('basedate','yyyymmdd','true',12)">
        <input name="basedate" type="text" id="basedate" size="15" value="<?php echo $_GET['item_base_date']; ?>" READONLY/>
        <img src="cal.gif" alt="Calender" width="16" height="16" border="0" /></a></td>
    </tr>
    <tr>
      <td>Serial# :</td>
      <td colspan="2"><input name="txtserial" type="text" id="txtserial" value="<?php echo $_GET['item_serial_no']; ?>"/></td>
      <td>Status : </td>
      <td><select name="selectStatus" id="selectStatus">
        <option value="" selected="selected"></option>
        <?php  
							
include("modified_common.php");
							
													$rs="SELECT item_status FROM equipment_status ";
																		
													$result = mysqli_query($db, $rs);
													while ($name_row = mysql_fetch_row($result)) {
													$item_status=$name_row[0];
													echo"<option value='$item_status'";
													if($item_status==$itm_status) echo ' SELECTED ';
													echo">$item_status</option>";		
													}
													
															
													
													
										?>
      </select></td>
    </tr>
    <tr>
      <td>Type : </td>
      <td colspan="2"><select name="selectType" id="selectType">
        <option value="" selected="selected"></option>
        <?php  
													
									include("modified_common.php");

			
									$rs="SELECT item_type FROM equipment_type ";
														
									$result = mysqli_query($db, $rs);
									while ($name_row = mysql_fetch_row($result)) {
									$item_type=$name_row[0];
									echo"<option value='$item_type'";
									if($item_type==$itm_type) echo ' SELECTED ';
									echo">$item_type</option>";		
									}
									
																					
																			
																			
								?>
      </select></td>
      <td>Assigned To :</td>
      <td><select name="selectAssignedTo" id="selectAssignedTo">
        <option value="" selected="selected"></option>
      </select></td>
    </tr>
    <tr>
      <td>Photo : </td>
      <td width="159"><input name="txtphoto" type="text" id="txtphoto" value="<?php echo $_GET['item_photo']; ?>"/></td>
      <td width="117"><input type="button" name="Submit42" value="Browse" accesskey="B" /></td>
      <td>&nbsp;</td>
      <td><a href="javascript:NewCal('txt_issued','yyyymmdd','true',12)">
        <label></label>
      </a></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="705" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr bgcolor="#33CC33">
      <td width="66"><label></label></td>
      <td width="178">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
      <input name="cmbSave" type="button" id="cmbSave" accesskey="S" value="   Update Information   " onclick="goUpdate()" /></td>
      <td width="199"><center>
        <input type="reset" name="Submit6" value="    Clear Form    " accesskey="C" />
      </center></td>
      <td width="157"><input name="cmbClose" type="button" id="cmbClose" accesskey="l" value="     Close Form    " onclick="goClose()" /></td>
    </tr>
  </table>
</form>
</body>
</html>

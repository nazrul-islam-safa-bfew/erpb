<?php 
include("modified_common.php");
//assigning posted hidden variable value to check which event is occur...
$hidden=$_POST['hidField'];

//echo("$entry_date");
//echo("$selectType");
/*echo("$txtitemid<br>");
echo("$selectMake<br>");
echo("$selectMaintenance<br>");
echo("$txtidentification<br>");
echo("$txtserial<br>");
echo("$selectMeter<br>");
echo("$txtbase<br>");
echo("$selectModel<br>");
echo("$selectModel<br>");
echo("$selectModel<br>");
echo("$selectModel<br>");
echo("$selectModel<br>");
*/
//echo("$txtidentification<br>");

//ADD NEW RECORD..
if($hidden==1)
{
include("modified_common.php");

//assigning posted value.....
$txtitemid=$_POST['item_id'];
$txtdesc=$_POST['txtspecification'];
$selectMake=$_POST['selectMake'];
$selectModel=$_POST['selectModel'];
$txtidentification=$_POST['txtidentification'];
$txtserial=$_POST['txtserial'];
$selectType=$_POST['selectType'];
$selectMaintenance=$_POST['selectMaintenance'];
$selectMeter=$_POST['selectMeter'];
$txtcurrent=$_POST['txtcurrent'];
$txtbase=$_POST['txtbase'];
$basedate=$_POST['basedate'];
$selectStatus=$_POST['selectStatus'];
$selectAssignedTo=$_POST['selectAssignedTo'];
$txtphoto=$_POST['txtphoto'];

//assigning label text field value...
$lbl_current=$_POST['lbl_current'];
$lbl_base=$_POST['lbl_base'];

//assigning system date...
$entry_date=date("Y-m-d");

//-----------------------------Query,Inserting date to the add_equipment_maintenance + track_equipments table----------

mysqli_query($db, "BEGin;"); 

//INSERT INTO add_equipment_maintenance
$qry="INSERT INTO add_equipment_maintenance(itm_track_id,year,item_make,item_model,item_identification,item_serial_no,item_type,pm_service_id,item_meter_type,item_curr_kilometer,update_curr_meter_date,item_base_kilometer,item_base_date,item_status,item_assigned_to,item_photo,lbl_current_meter,lbl_base_meter,created_date) VALUES ('$txtitemid','$txtdesc','$selectMake','$selectModel','$txtidentification','$txtserial','$selectType','$selectMaintenance','$selectMeter','$txtcurrent','','$txtbase','$basedate','$selectStatus','$selectAssignedTo','$txtphoto','$lbl_current','$lbl_base','$entry_date')";
$qryexecute=mysqli_query($db, $qry,$connection_equip);

//INSERT INTO track_equipments
$qry_track="INSERT INTO track_equipments(itm_track_id,pm_service_id,item_meter_type,item_curr_kilometer,item_base_kilometer,item_base_date) VALUES('$txtitemid','$selectMaintenance','$selectMeter','$txtcurrent','$txtbase','$basedate')";
$qryexecute_track=mysqli_query($db, $qry_track,$connection_equip);

mysqli_query($db, "COMMIT;"); 

//CHECK WHEATHER THE QUERY IS SUCCESSFULLY EXECUTED OR NOT...
if($qryexecute and $qryexecute_track)
{
//CREATED SESSION TO HOLD ITEM ID...
session_start();
$_SESSION['itm_id']=$txtitemid;
header("Location: NewEquipmentPurchase.php");
}
else
{
echo("Equipment Exist.Please Add Different Equipment For Maintenance...");
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>New Equipment Information Entry Form</title>
<script type="text/javascript" language="JavaScript1.2" src="stm32.js"></script>
<script language="javascript" type="text/javascript" src="datetimepicker.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" type="text/javascript" SRC="timepicker.js"></SCRIPT>




<script language="javascript">

//executed when change ocuur in the unit text box to reflect change in the txtidentification text box 
function goChange(m)
{
document.form1.txtidentification.value=m;
}

//executed when change ocuur in the year text box to reflect change in the txtidentification text box 
function goChange1(l,k)
{
//alert(l);
//alert(k);
//var d=k+' - '+l;
document.form1.txtidentification.value=k+'-'+l;;
}

//executed when change ocuur in the year make combo box to reflect change in the txtidentification text box  
function goSelectMake(m,n,o)
{
//var d=m+' - '+n+' - '+o;
document.form1.txtidentification.value=m+'-'+n+'-'+o;
}

function goSelectModel(m,n,o,p)
{
//var d=m+' - '+n+' - '+o+' - '+p;
document.form1.txtidentification.value=m+'-'+n+'-'+o+'-'+p;
}
//--------------------------------------------Traking Button's Click Event------------------------------

/*function goClose()
{
document.form1.hidField.value=2;
document.form1.submit();
}*/

//--###########*****************validating form input********************************##############################$$$$$$$$$$$--//


function validate(form1)
{
if(form1.item_id.value=="")
{
alert("Improper Save!Please Select Item Code.");
form1.item_id.focus();
return false;
}
if(form1.selectMaintenance.value=="")
{
alert("Improper Save!Please Select Maintenance Type.");
form1.selectMaintenance.focus();
return false;
}
if(form1.selectMeter.value=="")
{
alert("Improper Save!Please Select Meter Type.");
form1.selectMeter.focus();
return false;
}
if(form1.txtcurrent.value=="")
{
alert("Improper Save!Please Enter Meter's Current Reading.");
form1.txtcurrent.focus();
return false;
}
if(form1.txtbase.value=="")
{
alert("Improper Save!Please Enter Meter's Base Reading.");
form1.txtbase.focus();
return false;
}
//checking wheather the data entered for meter's current and base reading is numeric or not.....
if(isNaN(form1.txtcurrent.value))
{
alert("Invalid Data for Current Meter Reading!Please Enter Number.");
form1.txtcurrent.focus();
return false;
}
if(isNaN(form1.txtbase.value))
{
alert("Invalid Data for Base Meter Reading!Please Enter Number.");
form1.txtbase.focus();
return false;
}
return true;
}


//submitting form
function goSave(form1)
{
if(validate(form1)==true)
{
document.form1.hidField.value=1;
document.form1.submit();
}
}

//--###########*****************-----------END---------------**********************##############################$$$$$$$$$$$--//

//change label according to the selected meter type..
function go_lbl_change(m)
{
document.form1.lbl_current.value="Curr. "+m+":";
document.form1.lbl_base.value="Base "+m+":";
}

</script>
<style type="text/css">
<!--
@import url("common.css");
.style18 {
	font-size: 16px;
	font-weight: bold;
	color: #FF0000;
}
.style19 {
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
<link href="common.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <p>
    <input name="hidField" type="hidden" id="hidField" />
    <input name="hid_itm_code" type="hidden" id="hid_itm_code" />
  </p>
  <table width="705" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
    <tr>
      <td colspan="5" bgcolor="#33CC33">Add New Equiptment - General Information </td>
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
      <td width="132">Item Code  #:</td>
      <td colspan="2"><label>
      <select name="item_id" id="item_id" onchange="goChange(this.value)">
        <option value="" selected="selected"></option>
	  					
						<?php
									  include("connection.php");
								//fetch equipment information from the equipment table....
								$shw_equip="SELECT eqid,itemCode,teqSpec FROM equipment";
															
										$result = mysqli_query($db, $shw_equip,$connection)
										or die("Couldn't execute query.");
										
										while ($name_row = mysql_fetch_row($result)) 
										{
										$eqid=$name_row[0];
										$itemCode=$name_row[1];
										$teqSpec=$name_row[2];
										echo"<option value='$eqid'>$itemCode - $teqSpec</option>";
										}

						
						 ?>
	  
      </select>
      </label></td>
      <td width="229">Maintenance Service:</td>
      <td width="150">
	  
	  <select name="selectMaintenance" id="selectMaintenance">
        <option value="" selected="selected"></option>
	  								
									  <?php  
include("modified_common.php");

													$rs="SELECT pm_service_id,pm_service_name FROM add_pm_service";
																		
													$result = mysqli_query($db, $rs,$connection_equip);
													while ($name_row = mysql_fetch_row($result)) {
													$pm_service_id=$name_row[0];
													$pm_service_name=$name_row[1];
													echo"<option value='$pm_service_id'>$pm_service_name</option>";		
													}
													
															
													
													
										?>
      </select></td>
    </tr>
    <tr>
      <td>Year :</td>
      <td colspan="2"><input name="txtspecification" type="text" id="txtspecification" onchange="goChange1(txtspecification.value,item_id.value)" /></td>
      <td>Meter Type :
        <label></label></td>
      <td>
	  <select name="selectMeter" id="selectMeter" onchange="go_lbl_change(this.value)">
        <option value="" selected="selected"></option>
        <?php  
include("modified_common.php");

													$rs="SELECT meter_type FROM equipment_meter_type";
																		
													$result = mysqli_query($db, $rs);
													while ($name_row = mysql_fetch_row($result)) {
													$meter_type=$name_row[0];
													echo"<option value='$meter_type'>$meter_type</option>";		
													}
													
															
													
													
										?>
      </select></td>
    </tr>
    <tr>
      <td>Make :</td>
      <td colspan="2">
	  <select name="selectMake" id="selectMake" onchange="goSelectMake(item_id.value,txtspecification.value,this.value)">
        <option value="" selected="selected"></option>
	  
	  									  <?php  
include("modified_common.php");

							
													$rs="SELECT item_make FROM equipment_make";
																		
													$result = mysqli_query($db, $rs,$connection_equip);
													while ($name_row = mysql_fetch_row($result)) {
													$rs_item_make=$name_row[0];
													echo"<option value=$rs_item_make>$rs_item_make</option>";		
													}
													
															
													
													
										?>
      </select></td>
      <td><input name="lbl_current" type="text" class="ar" id="lbl_current" style="border:none" readonly="READONLY"/></td>
      <td><input name="txtcurrent" type="text" id="txtcurrent" /></td>
    </tr>
    <tr>
      <td>Model :</td>
      <td colspan="2">
 				
				<select name="selectModel" id="selectModel" onchange="goSelectModel(item_id.value,txtspecification.value,selectMake.value,this.value)">
        <option value="" selected="selected"></option>
							
							        <?php  
include("modified_common.php");

							
							
													$rs="SELECT item_model FROM equipment_model_type";
																		
													$result = mysqli_query($db, $rs,$connection_equip);
													while ($name_row = mysql_fetch_row($result)) {
													$item_model=$name_row[0];
													echo"<option value=$item_model>$item_model</option>";		
													}
													
															
													
													
										?>
      </select></td>
      <td><input name="lbl_base" type="text" class="ar" id="lbl_base" style="border:none" readonly="READONLY"/></td>
      <td><input name="txtbase" type="text" id="txtbase" /></td>
    </tr>
    <tr>
      <td>Identification :</td>
      <td colspan="2"><input name="txtidentification" type="text" id="txtidentification" /></td>
      <td>Base Date : </td>
      <td><input name="basedate" type="text" id="basedate" size="15" READONLY/>
        <a href="javascript:NewCal('basedate','yyyymmdd','true',12)"><img src="cal.gif" alt="Calender" width="16" height="16" border="0" /></a></td>
    </tr>
    <tr>
      <td>Serial# :</td>
      <td colspan="2"><input name="txtserial" type="text" id="txtserial" /></td>
      <td>Status : </td>
      <td>
	  <select name="selectStatus" id="selectStatus">
        <option value="" selected="selected"></option>
									<?php 
include("modified_common.php");
							
													$rs="SELECT item_status FROM equipment_status ";
																		
													$result = mysqli_query($db, $rs,$connection_equip);
													while ($name_row = mysql_fetch_row($result)) {
													$item_status=$name_row[0];
													echo"<option value=$item_status>$item_status</option>";		
													}
													
															
													
													
										?>
      </select></td>
    </tr>
    <tr>
      <td>Type : </td>
      <td colspan="2">
	  <select name="selectType" id="selectType">
        <option value="" selected="selected"></option>
							
							 <?php  
													
include("modified_common.php");
									$rs="SELECT item_type FROM equipment_type ";
														
									$result = mysqli_query($db, $rs,$connection_equip);
									while ($name_row = mysql_fetch_row($result)) {
									$item_type=$name_row[0];
									echo"<option value='$item_type'>$item_type</option>";	
									//echo"item_type";	
									}
									
																					
																			
																			
								?>
      </select></td>
      <td>Assigned To :</td>
      <td><select name="selectAssignedTo" id="selectAssignedTo">
      </select></td>
    </tr>
    <tr>
      <td>Photo : </td>
      <td width="144"><input name="txtphoto" type="text" id="txtphoto" /></td>
      <td width="132"><input type="button" name="Submit4" value="Browse" accesskey="B" /></td>
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
      <input name="cmbSave" type="button" id="cmbSave" accesskey="S" value="   Save Information   " onclick="goSave(form1)" /></td>
      <td width="199"><center>
          <input type="reset" name="Submit2" value="   Clear Entry   " accesskey="C" />
      </center></td>
      <td width="157"><img src="Images/Cancel.gif" alt="Cancel" width="78" height="20" onclick="javascript:location.href='index.php'"/></td>
    </tr>
  </table>
</form>
</body>
</html>

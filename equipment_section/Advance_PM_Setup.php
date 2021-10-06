<?php
include("common.php");
CreateConnection();
//Checking Maximum part_association_id.....//
$qry = "SELECT MAX(part_association_id) FROM part_association_main";
$qryexecute=mysqli_query($db, $qry);
$rs1=mysql_fetch_row($qryexecute);
$rs=$rs1[0];
if($rs==0)
{
$part_association_id=101;
//echo("$work_order_id");
}
else
{
$part_association_id=$rs+1;
//echo("$work_order_id");
}
//----------------Generating session to hold part_association_id----------------------//
session_start();
$_SESSION['p_association_id']=$part_association_id;



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<!-- Javascript for using xmlhttp obsects -->
<script src="script.js" type="text/javascript"></script>
<!--  END -->

<script language="javascript">
//this function will be executed if the page is closed unexpectedly
/*function goUnexpectedDelete()
{
if(confirm("Do You Want To Close The Window Without Saving The Record?")==true)
{
document.form1.hidField.value=5;
document.form1.submit();
}
}
*/


//this function will be executed when the form is loaded....
function goLoad()
{
var i='<?php echo $_GET['count']; ?>';
if(i==1)
{
//i.e if the form is reloaded after a parts association,disable all the combo box unless the selected pm service information is saved...
document.form1.select_equipment.disabled=true;
document.form1.select_pm_service.disabled=true;
//enable Save button..
document.form1.Bsave.disabled=false;
}
}


//validating form inputs..
function validate(form1)
{
if(form1.txtcost.value=="")
{
alert("Please Enter Cost For The Selected PM Service.");
document.form1.txtcost.focus();
return false;
}
else if(isNaN(form1.txtcost.value))
{
alert("Invalid Cost Amount.Please Enter Number.");
document.form1.txtcost.focus();
return false;
}
return true;
}

//submitting form ...save the total record for an equipment's ADVANCED pm SETUP..(After adding parts for the selected pm service..)

function doFinish(form1)
{
if(validate(form1)==true)
{
document.form1.hidField.value=4;
document.form1.submit();
}
}


//add parts to the equipment under a PM Service...
function goParts(n)
{
//check wheather a service is selected or not...
if(document.form1.select_pm_service.value=="")
{
alert("Please Select PM Service First.");
document.form1.select_pm_service.focus();
}
else if(document.form1.select_equipment.value=="")
{
alert("Please Select Equipment.");
document.form1.select_equipment.focus();
}
else
{
document.form1.hidField.value=2;
document.form1.submit();
}
}

//creating session for selected equipment id 
function go_select_equip(m)
{
xmlhttp.open("GET", 'server2.php?equipment_id=' + m);
xmlhttp.send(null);
}


//assign selected equipment id to the hidden variable
function go_select_pm_service(n)
{
document.form1.hid_pmService_id.value=n;
document.form1.hidField.value=5;
document.form1.submit();
}

</script>


<link href="common.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {color: #993300}
-->
</style>
</head>

<body onload="goLoad()">
<?php
//retreiving part association id against which a new part is added ..
session_start();
$part_association_id=$_SESSION['p_association_id'];

//retreiving PM_SERVICE_ID against which a new part is added values..
$pm_s_id=$_SESSION['pm_service_id'];

//RETREIVING equipment_id against which a new part is added..
$equip_id=$_SESSION['equipment_id'];

?>
<form id="form1" name="form1" method="post" action="Advance_PM_Setup_Medium.php">
  <table width="800" border="0" cellpadding="0" cellspacing="0" bgcolor="#0099CC">
    <tr>
      <td width="150" scope="col">PM Service </td>
      <td width="126" scope="col"><label>
      <select name="select_pm_service" id="select_pm_service" onchange="go_select_pm_service(this.value)">
        <option value="" selected="selected"></option>
        <?php 
													
													//display pm_services from the add_pm_service table 
													$qry2="SELECT pm_service_id,pm_service_name FROM add_pm_service";
													$qryexecute2=mysqli_query($db, $qry2);
													while($rs2=mysql_fetch_row($qryexecute2))
													{
														$pm_service_id=$rs2[0];
														$pm_service_name=$rs2[1];
														echo"<option value='$pm_service_id'"; if($pm_service_id==$pm_s_id) echo ' SELECTED '; echo">$pm_service_name</option>";
													}
												?>
            </select>
      </label></td>
      <td width="174" scope="col">Equipment In Schedule </td>
      <td width="135" scope="col">
								  <select name="select_equipment" id="select_equipment" onchange="go_select_equip(this.value)">
												<option selected="selected"></option>
						
												<?php 


													//display equipments from the add_equipment_maintenance table where the equipments associated schedule id is qual to the selected schedule id(i.e select_schedule control's value)...
													$qry1="SELECT item_id,item_identification FROM add_equipment_maintenance  WHERE pm_service_id='$pm_s_id'";
													$qryexecute1=mysqli_query($db, $qry1);
													while($rs1=mysql_fetch_row($qryexecute1))
													{
														$item_id=$rs1[0];
														$item_identification=$rs1[1];
														echo"<option value='$item_id'"; if($item_id==$equip_id) echo ' SELECTED '; echo">$item_identification</option>";
													}
												?>
						
						
								  </select>
													
						
	  </td>
      <td width="93" scope="col">&nbsp;</td>
      <td width="122" scope="col">&nbsp;</td>
    </tr>
  </table>
  <input name="hid_pmService_id" type="hidden" id="hid_pmService_id" />
  <input name="hidField" type="hidden" id="hidField" />
  <br />
  <table width="800" border="1" cellspacing="0" cellpadding="0">
    <tr bgcolor="#0099CC">
      <th width="155" scope="col"><div align="left">Part Associations </div></th>
      <th width="183" scope="col">&nbsp;</th>
      <th width="376" scope="col">&nbsp;</th>
      <th width="76" scope="col">&nbsp;</th>
    </tr>
    <tr>
      <td>Part # </td>
      <td>Name</td>
      <td>Description</td>
      <td>Qty</td>
    </tr>
									<?php 
										//fetching records from the part_association_sub_detail table corresponds to the selected schedule_id,pm_service_id and equipment_id...
										$qry3="SELECT part_number,part_name,part_desc,part_quantity FROM part_association_sub_detail WHERE part_association_id='$part_association_id'";
										$qryexecute3=mysqli_query($db, $qry3);
										while($rs3=mysql_fetch_row($qryexecute3))
										{
											$part_number=$rs3[0];
											$part_name=$rs3[1];
											$part_desc=$rs3[2];
											$part_quantity=$rs3[3];

											//generating table row dynamically based on returned record set...
											echo"<tr>
												<td>$part_number</td>
												<td>$part_name</td>
												<td>$part_desc</td>
												<td>$part_quantity</td>
											</tr>";
										}
									
									?>
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td><label></label></td>
      <td><input name="Badd" type="button" id="Badd" value="  Add Parts  " style="font: Georgia, "times="Times" new="New" roman="Roman"", Times, serif="serif"" onclick="goParts(select_pm_service.value)"/></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <p class="style1">Note : Double Click on the parts to &quot;Edit&quot; or &quot;Delete&quot; it. </p>
  <table width="800" border="0" cellspacing="0" cellpadding="0">
    <tr bgcolor="#0099CC">
      <th colspan="2" bgcolor="#0099CC" scope="col"><div align="left">Cost Associations </div></th>
    </tr>
    <tr>
      <td colspan="2">Note : If Desired, enter a cost value for the selected PM service.This will automatically entered when the PM service is chosen while entering maintenance performed or generating a work order. </td>
    </tr>
    <tr>
      <td width="78">Cost</td>
      <td width="722"><label>
        <input name="txtcost" type="text" id="txtcost" size="15" />
      Tk.</label></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="800" border="0" cellspacing="0" cellpadding="0">
    <tr bgcolor="#0099CC">
      <th scope="col"><div align="left">Special Instruction </div></th>
    </tr>
    <tr>
      <td>Note : Describe any special instructions for performing the selected PM service. These Instructions can be included in the maintenance check report when the PM service is due. </td>
    </tr>
    <tr>
      <td><label>
        <textarea name="text_special_instruction" cols="100" rows="4" id="text_special_instruction"></textarea>
      </label></td>
    </tr>
  </table>
 <br />
  <table width="800" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="col"><label></label></th>
      <th scope="col"><label>
      <input name="Bsave" type="button" id="Bsave" value="     Save    " onclick="doFinish(form1)"/>
      </label></th>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</form>
</body>
</html>

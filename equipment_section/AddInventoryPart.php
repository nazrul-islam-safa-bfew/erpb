<?php  
include("common.php");
CreateConnection();
//store hidden value to check wheater add Save part information button is clicked..
$hidden=$_POST['hidfield'];
//add new record..
if($hidden==1)
{
$part_no=$_POST['txtpartno'];
$part_name=$_POST['txtpartname'];
$part_description=$_POST['txtpartdesc'];
$part_manu=$_POST['selectmenu'];
$part_vendor=$_POST['selectvendor'];
$part_category=$_POST['selectcategory'];
$part_cost=$_POST['txtcost'];
$part_unit_type=$_POST['selectunit'];
$part_warrenty=$_POST['txtwarrenty'];
$part_upc=$_POST['txtupc'];
$txt_storage=$_POST['txt_storage'];
$part_location_stored=$_POST['txtlocation'];
$part_bin=$_POST['txtbin'];
$part_location_assign=$_POST['selectlocation'];
$part_photo=$_POST['textphoto'];

//inserting new record...
$part_insert="INSERT INTO parts_inventory(part_number,part_name,part_desc,part_manufacturer,vendor,part_category,part_unit_cost,unit_type,part_warranty, upc,location_storage,location_stored,bin,location_assign,part_picture)VALUES('$part_no','$part_name', '$part_description', '$part_manu', '$part_vendor', '$part_category', '$part_cost', '$part_unit_type', '$part_warrenty', '$part_upc', '$txt_storage', '$part_location_stored', '$part_bin', '$part_location_assign','$part_photo')";

$qryexecute=mysqli_query($db, $part_insert);

if($qryexecute)
{
header("Location: PartsInventory.php?part_no=$part_no");
}
else
{
echo("Duplicate Part Entry.This Part Exist In The The Database.Please Check The Part Number...");
}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Add New Part</title>
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>




<script language="javascript">


//-------------------------------------------Validating Form--------------------------------------------
function validate(frm)
{
if(frm.txtpartno.value=="")
{
alert("Please Enter Part's Number.");
frm.txtpartno.focus();
return false;
}

else if(frm.txtpartname.value=="")
{
alert("Please Enter Part's Address.");
frm.txtpartname.focus();
return false;
}
return true;
}



function doFinish(frm)
{
if(validate(frm)==true)
{
document.form1.hidfield.value=1;
frm.submit();
}

}

//-------------------------Tracking Combo's Value----------------------------------------------------------
/*
function gomenu()
{
alert(document.form1.selectmenu.value);
}


function govend()
{
alert(document.form1.selectvendor.value);
}
*/

</script>

<link href="common.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <input name="hidfield" type="hidden" id="hidfield" />
  <table width="766" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
    <tr>
      <td colspan="5" bgcolor="#33CC33">Add New Part Information </td>
    </tr>
    <tr>
      <td width="124">Part Number :</td>
      <td colspan="2"><label>
      <input name="txtpartno" type="text" id="txtpartno" />
      </label></td>
      <td width="159"> Warrenty:</td>
      <td width="223"><input name="txtwarrenty" type="text" id="txtwarrenty" />
Years </td>
    </tr>
    <tr>
      <td>Name:</td>
      <td colspan="2"><input name="txtpartname" type="text" id="txtpartname" /></td>
      <td>UPC:</td>
      <td><input name="txtupc" type="text" id="txtupc" /></td>
    </tr>
    <tr>
      <td>Description:</td>
      <td colspan="2"><input name="txtpartdesc" type="text" id="txtpartdesc" /></td>
      <td>Location (Storage ) :</td>
      <td><input name="txt_storage" type="text" id="txt_storage" /></td>
    </tr>
    <tr>
      <td>Manufacturer:</td>
      <td colspan="2"><select name="selectmenu" id="selectmenu">
        <option value="" selected="selected"></option>
        <?php  
						$rs="SELECT part_manu FROM parts_manu";
											
						$result = mysqli_query($db, $rs);
						while ($name_row = mysql_fetch_row($result)) {
						$rs_schedule_id=$name_row[0];
						echo"<option value=$rs_schedule_id>$rs_schedule_id</option>";		
						}
						
								
						
						
			?>
      </select></td>
      <td>Location Stored :</td>
      <td><input name="txtlocation" type="text" id="txtlocation" /></td>
    </tr>
    <tr>
      <td>Vendor:</td>
      <td colspan="2"><select name="selectvendor" id="selectvendor">
        <option value="" selected="selected"></option>
        <?php  
					
											$rs="SELECT  vendor_id,vendor_name FROM vendor_setup";
																
											$result = mysqli_query($db, $rs);
											while ($name_row = mysql_fetch_row($result)) {
											$rs_vendor_id=$name_row[0];
											$rs_vendor_name=$name_row[1];
											echo"<option value='$rs_vendor_id'>$rs_vendor_id -> $rs_vendor_name</option>";		
											}
											
													
											
											
								?>
      </select></td>
      <td>Bin#</td>
      <td><input name="txtbin" type="text" id="txtbin" /></td>
    </tr>
    <tr>
      <td>Category:</td>
      <td colspan="2"><select name="selectcategory" id="selectcategory">
        <option value="" selected="selected"></option>
        <?php  
					
											$rs="SELECT part_category FROM parts_category";
																
											$result = mysqli_query($db, $rs);
											while ($name_row = mysql_fetch_row($result)) {
											$rs_schedule_id=$name_row[0];
											echo"<option value=$rs_schedule_id>$rs_schedule_id</option>";		
											}
											
													
											
											
								?>
      </select></td>
      <td>Location Assign </td>
      <td><select name="selectlocation" id="selectlocation">
        <option value="" selected="selected"></option>
        <option value="All Location"> All Location</option>
        <option value="Equipment"> Equipment</option>
        <option value="Facilities"> Facilities</option>
        <option value="Tools"> Tools</option>
        <option value="Vessels">Vessels</option>
      </select></td>
    </tr>
    <tr>
      <td>Unit Cost: </td>
      <td width="162"><input name="txtcost" type="text" id="txtcost" size="15" /> 
      Tk. </td>
      <td width="98"><select name="selectunit" id="selectunit">
        <option value="" selected="selected"></option>
        <?php  
					
											$rs="SELECT part_unit_type FROM parts_unit_types ";
																
											$result = mysqli_query($db, $rs);
											while ($name_row = mysql_fetch_row($result)) {
											$rs_schedule_id=$name_row[0];
											echo"<option value=$rs_schedule_id>$rs_schedule_id</option>";		
											}
											
													
											
											
								?>
      </select></td>
      <td>Photo:</td>
      <td><a href="javascript:NewCal('txt_issued','yyyymmdd','true',12)">
        <input name="textphoto" type="text" id="textphoto" READONLY/>
        <label>
        <input type="button" name="Button2" value="Browse" accesskey="B" />
        </label>
      </a></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="766" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr bgcolor="#33CC33">
      <td width="66"><label></label></td>
      <td width="178">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
      <input type="button" name="Button" value="Save Part Information" accesskey="S" onclick="doFinish(form1)" /></td>
      <td width="199"><center>
        <input type="reset" name="Submit2" value="   Clear Entry   " accesskey="C" />
      </center></td>
      <td width="157"><input type="button" name="Submit3" value="    Close    " accesskey="l" onclick="javascript:location.href='PartsInventory.php'"/></td>
    </tr>
  </table>
  </form>
</body>
</html>

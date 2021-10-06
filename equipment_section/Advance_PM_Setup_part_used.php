<?php 
include("common.php");
CreateConnection();
session_start();
//$work_order_id=$_SESSION['workorder_id'];
//retreiving session values..
session_start();
$part_association_id=$_SESSION['p_association_id'];
$pm_s_id=$_SESSION['pm_service_id'];
$equip_id=$_SESSION['equipment_id'];

/*echo"Ass: $part_association_id <br>";
echo"Sch: $sch_id <br>";
echo"Service: $pm_s_id <br>";
echo"Equipment: $equip_id <br>";
*/
//------------------------Hidden Field Value Association------------------
//trcking which part is selscted....
$Part_ID=$_POST['hid_part_id'];
//this value is to track which event occured...
$hidden=$_POST['hidField'];
//------------------------------END----------------


//----------------------Tracking SelectPartNumber Menue's OnChange Event------------------------
if($hidden==1)
{
$qry="SELECT part_name,part_desc FROM parts_inventory WHERE part_number='$Part_ID'";
$qryexecute=mysqli_query($db, $qry);
$rs=mysql_fetch_row($qryexecute);
$part_name=$rs[0];
$part_desc=$rs[1];
}
//saving record..
else if($hidden==2)
{
//ASSIGNING POSTED VALUES....
$part_num=$_POST['SelectPartNumber'];
$part_name=$_POST['txtName'];
$part_desc=$_POST['txtDesc'];
$part_quantity=$_POST['txtQuantity'];
//------END.....................

$qry="INSERT INTO part_association_sub_detail VALUES('$part_association_id','$pm_s_id','$part_num','$part_name','$part_desc','$part_quantity')";
$qryexecute=mysqli_query($db, $qry);
header("Location: Advance_PM_Setup.php?count=1");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Add Part Association For (#<?php echo"$equip_id"; ?>)...</title>

<script language="javascript">


function goChange(m)
{

var n=m;
document.form1.hid_part_id.value=n;
document.form1.hidField.value=1;
document.form1.submit();
//alert(document.form1.hid_item_id.value);
}

//-------------------------Validating Form Imput & Then Save & Exit------------------------------

function validate(form1)
{
if(form1.txtQuantity.value=="")
{
alert("Please Enter Quantity.");
form1.txtQuantity.focus();
return false;
}
else if(isNaN(form1.txtQuantity.value))
{
alert("Please Enter Integer Number.");
form1.txtQuantity.focus();
return false;
}
return true;
}




function doFinish(form1)
{
if(validate(form1)==true)
{
document.form1.hidField.value=2;
document.form1.submit();
}
}


</script>


<link href="common.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <table width="475" border="0" align="center" cellpadding="0" cellspacing="0" style="border-color:#FF0000">
    <tr>
      <td colspan="4" bgcolor="#0099CC">Part's Information ... </td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr bgcolor="#FF99FF">
      <td width="132" bgcolor="#999999">Part Number : </td>
      <td colspan="3" bgcolor="#999999"><label>
	  
								<select name="SelectPartNumber" id="SelectPartNumber" onchange="goChange(SelectPartNumber.value)">
								 <option selected="selected"></option>
								
								 <?php  
														$rs="SELECT part_number FROM parts_inventory";
																			
														$result = mysqli_query($db, $rs);
														while ($name_row = mysql_fetch_row($result)) {
														$part_number=$name_row[0];
														echo"<option value='$part_number'";
														if($part_number==$Part_ID) echo ' SELECTED ';
														echo">$part_number</option>";	
														}
														
																
														
														
									?>
								</select>
								
								
      </label></td>
    </tr>
    <tr bgcolor="#FF99FF">
      <td bgcolor="#999999">Name : </td>
      <td colspan="3" bgcolor="#999999"><label>
        <input name="txtName" type="text" id="txtName" size="55" value="<?php echo"$part_name"; ?>" READONLY/>
      </label></td>
    </tr>
    <tr bgcolor="#FF99FF">
      <td bgcolor="#999999">Description : </td>
      <td colspan="3" bgcolor="#999999"><input name="txtDesc" type="text" id="txtDesc" size="55" value="<?php echo"$part_desc"; ?>"READONLY/></td>
    </tr>
    
    <tr bgcolor="#FF99FF">
      <td bgcolor="#999999">Quantity Used : </td>
      <td colspan="3" bgcolor="#999999"><label>
        <input name="txtQuantity" type="text" id="txtQuantity" onchange="goCalculate(txtQuantity.value)"/>
      </label></td>
    </tr>
    
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr bgcolor="#0099CC">
      <td><label>
        <center>
        </center>
      </label></td>
      <td width="45">&nbsp;</td>
      <td width="117"><img src="Images/Save.gif" alt="Save" width="78" height="20" onclick="doFinish(form1)"/></td>
      <td width="181">&nbsp;</td>
    </tr>
  </table>
  <p>
    <input name="hid_part_id" type="hidden" id="hid_part_id" />
    <input name="hidField" type="hidden" id="hidField" />
  </p>
  <p>&nbsp;</p>
</form>
</body>
</html>

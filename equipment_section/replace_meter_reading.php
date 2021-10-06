<?php
include("connection.php");
//assigning posted hidden value to the varible for checking which button is clicked on the form
$hid=$_POST['hidField'];
//executes codes depend upon the hidden value
if($hid==1)
{
//add button is clicked
header("Location: replace_meter_add.php");
}
else if($hid==2)
{
//edit button is clicked..
header("Location: replace_meter_edit.php");
}
else if($hid==3)
{
include("modified_common.php");
//executed when double click event occured..
//assigning posted itm_track_id
$hid_trk=$_POST['hid_itm_id'];
$qry_del="Delete from replace_meter_reading WHERE itm_track_id='$hid_trk'";
$qrydel_execute=mysqli_query($db, $qry_del,$connection_equip);
//checks wheather the query is successfully executed or not...
if($qrydel_execute)
{
header("Location: replace_meter_reading.php");
}
else
{
echo("Error Deleting Record! Please Try Again.");
}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Meter Replacement</title>
<link href="common.css" rel="stylesheet" type="text/css" />

<script language="javascript">
function goAdd()
{
document.form1.hidField.value=1;
//alert(document.form1.hidField.value);
document.form1.submit();
}

//Edit Record...
function goEdit()
{
document.form1.hidField.value=2;
document.form1.submit();
}

//delete record...
function goDelete(m)
{
if(confirm("Do You Want To Delete The Record")==true)
{
document.form1.hidField.value=3;
document.form1.hid_itm_id.value=m;
document.form1.submit();
}
}

</script>

<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="846" border="1" cellpadding="0" cellspacing="0">
    <tr bgcolor="#0099CC">
      <td width="124">Item Code </td>
      <td width="190">Identification</td>
      <td width="105">Date Replaced </td>
      <td width="98">Current Reading </td>
      <td width="107">Replacement Reading </td>
      <td width="208">Description</td>
    </tr>
	
									<?php
include("modified_common.php");
										//retreive meter replace ment information from the replace_meter_reading table 
										$qry="SELECT * FROM replace_meter_reading";
										$qryexecute=mysqli_query($db, $qry,$connection_equip);
										//counting total number of records returned by the query
										$count=mysql_num_rows($qryexecute);


										
										while($rs=mysql_fetch_row($qryexecute))
										{
											$itm_track_id=$rs[0];
											$item_id=$rs[1];
											$date_replaced=$rs[2];
											$current_reading=$rs[3];
											$replace_reading=$rs[4];
											$desc=$rs[5];
include("connection.php");
								//select teqSpec from the equipment table base on the selected itm_track_id from bfewdb database
									$qry_tech="select teqSpec from equipment where eqid='$itm_track_id'";
									$qrytech_execute=mysqli_query($db, $qry_tech,$connection);
									$rs_tech=mysql_fetch_row($qrytech_execute);
									$item_identification=$rs_tech[0];
									
											//generate table rows dynamically
											echo"<tr ondblclick=goDelete('$itm_track_id')>
											<td>$item_id</td>
											<td>$item_identification</td>
											<td>$date_replaced</td>
											<td>$current_reading</td>
											<td>$replace_reading</td>
											<td>$desc</td>
											";
										}
									?>
	
    <tr>
      <td height="24" colspan="6"><input name="hidField" type="hidden" id="hidField" />
      <input name="hid_itm_id" type="hidden" id="hid_itm_id" /></td>
    </tr>
    <tr bgcolor="#0099CC">
      <td><?php echo $count; ?> item Listed </td>
      <td><label>
        <input name="BAdd" type="button" id="BAdd" value="    Add ..." onclick="goAdd()"/>
      </label></td>
      <td><input type="button" name="Submit2" value="    Edit ... " onclick="goEdit()"/></td>
      <td>&nbsp;</td>
      <td><input type="button" name="Submit4" value="    Print ..." onclick="javascript:window.print()"/></td>
      <td><input type="button" name="Submit5" value="  Search  " /></td>
    </tr>
  </table>
  <p class="style1">Notes: Double Click on the record to delete it. </p>
</form>
</body>
</html>

<?php
include("connection.php");
//assigning posted hidden value to check which event occur on the page...
$hid=$_POST['hidField'];
//assigning posted equipment category type...
$category_type=$_POST['hid_category'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Update Current Meter Readings For Your Equipment</title>
<link href="common.css" rel="stylesheet" type="text/css" />

<script language="javascript">

//this fuction is used to select records based on the selected category..
function go_select_category(m)
{
document.form1.hid_category.value=m;
//document.form1.hidField.value=1;
document.form1.submit();
//alert(m);
}


//UPDATE METER READINGS...
function goUpdate(n,r,l)
{
location.href='Update_Meter_Reading_medium.php?equip_id=' + n ;
//document.form1.hid_category.value=n;
//document.form1.hidField.value=1;
//document.form1.submit();
//alert(n);
//alert(l);

}


</script>




<style type="text/css">
<!--
.style1 {color: #FF9933}
.style2 {
	font-size: 12px;
	color: #FF0000;
}
-->
</style>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="800" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th width="89" scope="col"><div align="left" class="style1">Location</div></th>
      <td width="214" scope="col"><label>
          <select name="select_location" id="select_location">
            <option>All Locations</option>
        </select>
      </label></td>
      <th width="119" scope="col"><div align="left" class="style1">Category</div></th>
      <th width="378" scope="col"><div align="left">
		  <select name="select_category" id="select_category" onchange="go_select_category(this.value)">
		    <option selected="selected" value="" <?php if($category_type=="") echo ' SELECTED '; ?>>All Categories</option>
							  
		    <?php 
include("modified_common.php");
							  	//select all equipment types...
								$qry="SELECT item_type FROM add_equipment_maintenance";
								$qryexecute=mysqli_query($db, $qry,$connection_equip);
								while($rs=mysql_fetch_row($qryexecute))
								{
									$item_type=$rs[0];
									echo"<option value='$item_type'"; if($item_type==$category_type) echo ' SELECTED '; echo">$item_type</option>";
								}
								
								
							  
							  ?>
							  
		  </select>
      </div></th>
    </tr>
  </table>
  <input name="hidField" type="hidden" id="hidField" />
  <input name="hid_category" type="hidden" id="hid_category" />
  <br />
  <table width="800" border="1" cellspacing="0" cellpadding="0">
    
    
    <tr bgcolor="#0099CC">
      <th bgcolor="#0099CC" scope="col"><div align="left">Identification</div></th>
      <th width="216" scope="col"><div align="left">
        <div align="left">Current Reading        </div>
      <label>      </label></th>
      <th width="203" scope="col"><div align="left">Last Update </div></th>
    </tr>
	
										<?php
									
include("modified_common.php");
											//generating table row dynamically based on the selected category
											if($category_type=="")
												{
			$qry1="select itm_track_id,item_curr_kilometer,update_curr_meter_date,item_meter_type from add_equipment_maintenance";
								$qryexecute1=mysqli_query($db, $qry1,$connection_equip);
												}
											else
												{
			$qry1="select itm_track_id,item_curr_kilometer,update_curr_meter_date,item_meter_type from add_equipment_maintenance where item_type='$category_type'";
								$qryexecute1=mysqli_query($db, $qry1,$connection_equip);
												}
												
												//COUNTS NUMBER OF RECORDS RETURNED BY THE QUERY...
													$count=mysql_num_rows($qryexecute1);
												
												while($rs1=mysql_fetch_row($qryexecute1))
												{
													$itm_track_id=$rs1[0];
													$item_curr_kilometer=$rs1[1];
													$update_curr_meter_date=$rs1[2];
													$item_meter_type=$rs1[3];
													
								//select teqSpec from the equipment table base on the selected itm_track_id from bfewdb database
									$qry_tech="select itemCode,teqSpec from equipment where eqid='$itm_track_id'";
									$qrytech_execute=mysqli_query($db, $qry_tech,$connection);
									$rs_tech=mysql_fetch_row($qrytech_execute);
									$item_code=$rs_tech[0];
									$item_identification=$rs_tech[1];
								
													echo"<tr ondblclick=goUpdate('$itm_track_id')>
																<td>$item_code : $item_identification</td>
																<td>$item_curr_kilometer $item_meter_type</td>
																<td>$update_curr_meter_date</td>
														</tr>";
												}
										?>
                                        <tr>
                                          <th colspan="3" scope="col">&nbsp;</th>
                                        </tr>
                                        
    <tr>
      <th scope="col"><div align="left">
        <label><span class="style1">Equipment Listed = <?php echo $count; ?></span></label>
      </div></th>
      <th scope="col"><input name="Bprint" type="button" id="Bprint" value="   Print   " onclick="javascript:window.print()"/></th>
      <th scope="col"><input name="BClose" type="button" id="BClose" value="   Close   " onclick="javascript:window.close()"/></th>
    </tr>										
  </table>
  <p class="style2">Note: Double Click On The Table Row To Edit Meter Readings...</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</form>
</body>
</html>

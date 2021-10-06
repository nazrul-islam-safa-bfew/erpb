<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style1 {color: #FF9933}
-->
</style>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="1000" border="1" cellspacing="0" cellpadding="0">
    <tr bgcolor="#0099CC">
      <th width="306" bgcolor="#0099CC" scope="col"><div align="left">Identification</div></th>
      <th width="131" scope="col"><div align="left">Date Replaced </div></th>
      <th width="145" scope="col"><div align="left">
          <div align="left">Current Reading </div>
        <label> </label></th>
      <th width="151" scope="col">Replacement Reading </th>
      <th width="255" scope="col"><div align="left">Description</div></th>
    </tr>
    <?php
											//generating table row dynamically based on the selected category
											if($category_type=="")
												{
			$qry1="select item_id,item_identification,item_curr_kilometer,update_curr_meter_date,item_meter_type from add_equipment_maintenance";
								$qryexecute1=mysqli_query($db, $qry1);
												}
												
											else
												{
			$qry1="select item_id,item_identification,item_curr_kilometer,update_curr_meter_date,item_meter_type from add_equipment_maintenance where item_type='$category_type'";
								$qryexecute1=mysqli_query($db, $qry1);
												}
												
												//COUNTS NUMBER OF RECORDS RETURNED BY THE QUERY...
													$count=mysql_num_rows($qryexecute1);
												
												while($rs1=mysql_fetch_row($qryexecute1))
												{
													$item_id=$rs1[0];
													$item_identification=$rs1[1];
													$item_curr_kilometer=$rs1[2];
													$update_curr_meter_date=$rs1[3];
													$item_meter_type=$rs1[4];
												
													echo"<tr ondblclick=goUpdate('$item_id','$item_identification','$item_curr_kilometer')>
																<td>$item_identification</td>
																<td>$item_curr_kilometer $item_meter_type</td>
																<td>$update_curr_meter_date</td>
														</tr>";
												}
										?>
    <tr>
      <th colspan="5" scope="col">&nbsp;</th>
    </tr>
    <tr>
      <th scope="col"><div align="left">
          <label><span class="style1">Equipment Listed = <?php echo $count; ?></span></label>
      </div></th>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
      <th scope="col"><input name="BClose" type="button" id="BClose" value="   Close   " onclick="javascript:window.close()"/></th>
      <th scope="col"><input name="Bprint" type="button" id="Bprint" value="   Print   " onclick="javascript:window.print()"/></th>
    </tr>
  </table>
</form>
</body>
</html>

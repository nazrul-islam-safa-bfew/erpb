<?php 
include("../Common.php");
CreateConnection();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>

<script language="javascript">
function goEdit(m)
{
alert(m);
}
</script>
<style type="text/css">
<!--
.style3 {font-family: Georgia, "Times New Roman", Times, serif}
-->
</style>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="625" border="1" cellpadding="0" cellspacing="0">
    <tr bgcolor="#0099CC">
      <td width="211"><span class="style3">Employee ID </span></td>
      <td width="248"><span class="style3">Employee Name </span></td>
      <td width="158"><span class="style3">Detail</span></td>
    </tr>
						
						<?php 
							$qry="SELECT emp_id,emp_Name FROM add_new_employee";							
							$qryexecute = mysqli_query($db, $qry);
							//count number of records returned by the query...
								$count=mysql_num_rows($qryexecute);
								while ($name = mysql_fetch_row($qryexecute)) 
								{
										$emp_id=$name[0];
										$emp_Name=$name[1];
										
										echo"<tr>
										<td><span class='style3'>$emp_id</span></td>
										<td><span class='style3'>$emp_Name</span></td>
										<td onclick='goEdit($emp_id)' bgcolor='#FFFFCC' style='text-decoration:underline'><span class='style3'>View Report</span></td>";
								}
						
						?>
	                    <tr>
	                      <td>&nbsp;</td>
	                      <td>&nbsp;</td>
	                      <td>&nbsp;</td>
    </tr>
        <tr bgcolor="#0099CC">
      <td bgcolor="#0099CC"><?php echo $count; ?> <span class="style3">Employee Listed</span></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>

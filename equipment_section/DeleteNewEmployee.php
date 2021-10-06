<?php 
include("common.php");
CreateConnection();
//----Delete record based on the combos selected balue...
$employye_id=$_POST['select_emp_id'];
//echo"$employye_id";
$qry1="DELETE FROM add_new_employee WHERE emp_id='$employye_id'";
$qryexecute=mysqli_query($db, $qry1);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Delete Emploee - Information</title>
<link href="common.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form id="form1" name="form1" method="post" action="DeleteNewEmployee.php">
  <table width="306" border="0" cellspacing="0" cellpadding="0">
    <tr bgcolor="#33CC33">
      <th colspan="2" bgcolor="#33CC33"><div align="left">Delete Employee Information </div></th>
    </tr>
    <tr bgcolor="#FF99FF">
      <td width="138">Select Employee </td>
      <td width="168"><label>
							<select name="select_emp_id" id="select_emp_id" style="size:auto">
									<?php
									
										$qry="SELECT emp_id,emp_Name FROM add_new_employee";
										$qryexecute=mysqli_query($db, $qry);
										while($rs=mysql_fetch_row($qryexecute))
											{
												$emp_id=$rs[0];
												$emp_Name=$rs[1];
												echo"<option value='$emp_id'>>$emp_id - $emp_Name</option>";
											}
									 
									?>
		</select>
      </label></td>
    </tr>
    
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#990000">
      <td><label>
        <input name="delete" type="submit" id="delete" value="   Delete   " />
      </label></td>
      <td><input name="close" type="button" id="close" value="   Close   " onclick="javascript:window.close()"/></td>
    </tr>
  </table>
</form>
</body>
</html>

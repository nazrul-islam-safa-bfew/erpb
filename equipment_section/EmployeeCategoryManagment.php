<?php
include("common.php");
CreateConnection();
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Employee Category Managment Screen</title>

<script language="javascript">

//---------------For Add Button-----------------//
function goAdd()
{
document.form1.hidField.value=1;
document.form1.submit();
}

//----------------For Rows Double Click Event to Edit records....
function goEditDelete(m)
{
document.form1.hidCategoryID.value=m;
//alert(m);
document.form1.hidField.value=2;
document.form1.submit();
}

</script>

<link href="common.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form id="form1" name="form1" method="post" action="EmployeeCategoryManagment_Medium.php">
  <p>
  <input name="hidField" type="hidden" id="hidField" />
  <input name="hidCategoryID" type="hidden" id="hidCategoryID" /></p>
  <table width="300" border="1" cellpadding="0" cellspacing="0">
    <tr bgcolor="#33CC33">
      <td width="294" colspan="2" bgcolor="#33CC33"><div align="center">Employee Category </div></td>
    </tr>
    
    								
									<?php
											//Fetching records from the add_new_employee_category table
											$qry="SELECT emp_category_id,emp_category_type FROM add_new_employee_category";
											$qryexecute=mysqli_query($db, $qry);
											//--Counting number of records return by the above query---//
											$count=mysql_num_rows($qryexecute);

											//dislay record as table rows//
											while($rs=mysql_fetch_row($qryexecute))
											{
												$emp_category_id=$rs[0];
												$category_type=$rs[1];
												
												echo"<tr ondblclick='goEditDelete($emp_category_id)'>
													<td>$category_type</td>
													</tr>";
											}		
										
									?>
	
<tr bgcolor="#00CC99">
      <td colspan="2" bgcolor="#33CC33"><?php echo"$count Items Listed"; ?></td>
    </tr>
  </table>
  <br />
  <table width="300" border="0" cellpadding="0" cellspacing="0" bgcolor="#33CC33">
    <tr>
      <td width="143">
	  <center>
	  <input type="button" name="Button" value="Add Category " onclick="goAdd()"/>
	  <center>	  </td>
      <td width="157">
	  <center><input name="close" type="submit" id="close" value="    Close    " onclick="javascript:window.close()"/></center>	  </td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</form>
</body>
</html>

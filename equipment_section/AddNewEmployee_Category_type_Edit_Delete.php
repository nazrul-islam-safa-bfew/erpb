<?php													
include("common.php");
CreateConnection();
//Assigning Posted value to the variable ....//
$hid=$_POST['hidField'];
$category_type=$_POST['txtCategory'];
//---Update record in add_new_employee_category table---//
//-----For UPDATE Button...............
if($hid==1)
{
//ASSIGNING SESSION VALUE WHICH CONTAINS THE EMPLOYEE CATEGORY ID
session_start();
$employee_category_id=$_SESSION['category_id'];

$qry="UPDATE add_new_employee_category SET emp_category_type='$category_type' WHERE emp_category_id='$employee_category_id'";
$qryexecute=mysqli_query($db, $qry);
if($qryexecute)
{
header("Location: EmployeeCategoryManagment.php");
}
else
{
echo("Employee Category Exist...");

}
}
//-----For DELETE Button...............
else if($hid==2)
{
//ASSIGNING SESSION VALUE WHICH CONTAINS THE EMPLOYEE CATEGORY ID
session_start();
$employee_category_id=$_SESSION['category_id'];

$qry="DELETE FROM add_new_employee_category WHERE emp_category_id='$employee_category_id'";
$qryexecute=mysqli_query($db, $qry);
header("Location: EmployeeCategoryManagment.php");

}



//.............Receiving posted value and assigning to the variable and update or delete record base on that----------//
$catagory_type=$_GET['catagory_type'];

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Add Employee Category</title>

<script language="javascript">

//validating Form Input
function validate(frm)
{
if(frm.txtCategory.value=="")
{
alert("Please Enter Employee Category Type.");
frm.txtCategory.focus();
return false;
}
else if(isNaN(frm.txtCategory.value)==false)
{
alert("Invalid Format For The Category Name.Please Enter Character Data.");
frm.txtCategory.focus();
return false;
}
return true;
}

function doFinish(frm)
{
if(validate(frm)==true)
{
document.form1.hidField.value=1;
document.form1.submit();
}
}

//For Delete Button//
function goDelete()
{
document.form1.hidField.value=2;
document.form1.submit();
}

</script>
<style type="text/css">
<!--
body,td,th {
	font-family: Georgia, Times New Roman, Times, serif;
	font-size: 16px;
	color: #3300CC;
}
-->
</style>

</head>
<body>
<form id="form1" name="form1" method="post" action="AddNewEmployee_Category_type_Edit_Delete.php">
  <input name="hidField" type="hidden" id="hidField" />
  <table width="349" border="0" align="left" cellpadding="0" cellspacing="0">
  <tr>
      <td colspan="3" bgcolor="#33CC33">Update Delete Employee Category </td>
    </tr>
    
    <tr bgcolor="#FF99FF">
      <td width="183">Enter Employee Category </td>
      <td colspan="2"><input name="txtCategory" type="text" id="txtCategory" value="<?php echo"$catagory_type";  ?>"/></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
    
    <tr bgcolor="#990000">
      <td><label>
       <center><input name="update" type="button" id="update" value="   Update   " onclick="doFinish(form1)"/>
       </center>
      </label></td>
      <td width="82"><input name="Delete" type="button" id="Delete" value="   Delete   " onclick="goDelete()"/></td>
      <td width="84">
	  <center><input name="close" type="button" id="close" value="   Close   " onclick="javascript:location.href='EmployeeCategoryManagment.php'"/>
	  </center>	  </td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</form>
</body>
</html>

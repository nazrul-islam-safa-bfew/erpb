<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Successful</title>
</head>




<?php 
require('common.php');
CreateConnection();

$txt_manu=$_POST['txtunit'];


$itmlistqry="INSERT INTO  parts_unit_types( part_unit_type)VALUES ('$txt_manu')";
$itmEntry=mysqli_query($db, $itmlistqry);

if($itmEntry==true)
{
echo("$txt_manu has been successfully added to the database.");
}
else
{
echo("$txt_manu Exist...Please Enter Different Unit Type.");
}
?>



<body>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="400" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2"><div align="center">
      <p>&nbsp;</p>
    </div></td>
  </tr>
  <tr>
    <td width="291"><div align="center"><a href="PartUnitsSetup.php">BACK</a></div></td>
<td width="435"><div align="center"><a href="javascript:window.close()">CLOSE </a></div></td>  </tr>
  </tr>
</table>
</body>
</html>

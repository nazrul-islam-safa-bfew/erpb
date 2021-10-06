<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>




<?php 
require('common.php');
CreateConnection();


$itmCode=$_POST['itmCode'];
$itmDesc=$_POST['itmDesc'];
$itmSpec=$_POST['itmSpec'];
$itmUnit=$_POST['itmUnit'];


$itmlistqry="INSERT INTO  equipment_list(item_code,item_des,item_spec,item_unit )VALUES ('$itmCode', '$itmDesc','$itmSpec','$itmUnit')";
$itmEntry=mysqli_query($db, $itmlistqry);

if($itmDesc==true)
{

echo("$itmDesc has been successfully added to the database.");

}

?>



<body>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="726" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2"><div align="center">
      <p>&nbsp;</p>
    </div></td>
  </tr>
  <tr>
    <td width="291"><div align="center"><a href="ETSetup.php">BACK</a></div></td>
    <td width="435"><div align="center"><a href="index.php">GO TO HOME PAGE </a></div></td>
  </tr>
</table>
</body>
</html>

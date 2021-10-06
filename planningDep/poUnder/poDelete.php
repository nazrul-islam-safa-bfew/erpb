<?php
include("../../includes/session.inc.php");
include("../../includes/config.inc.php");

echo $posl=$_GET['posl'];	
echo $status=$_GET['status'];
echo $loginUname=$_SESSION['loginUname'];
echo $open=$_GET['open'];


$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);


if($loginUname){
if($open){
$vendor = "UPDATE porder set status=1 WHERE posl='$posl'";
//echo $vendor;
mysqli_query($db, $vendor);
 echo "Purchase Order opend...";
 $status=2;
}
else{
$vendor = "DELETE FROM poscheduletemp  WHERE posl='$posl'";
//echo $vendor;
 mysqli_query($db, $vendor);

$vendor = "DELETE FROM poschedule  WHERE posl='$posl'";
//echo $vendor;
 mysqli_query($db, $vendor);

$vendor = "DELETE FROM pordertemp  WHERE posl='$posl'";
// echo $vendor;
mysqli_query($db, $vendor);

$vendor = "DELETE FROM porder  WHERE posl='$posl'";
// echo $vendor;
mysqli_query($db, $vendor);

$vendor1 = "DELETE FROM popaymentstemp  WHERE posl='$posl'";
//echo $vendor;
 mysqli_query($db, $vendor1);
$vendor1 = "DELETE FROM popayments  WHERE posl='$posl'";
//echo $vendor;
 mysqli_query($db, $vendor1);

$vendor1 = "DELETE FROM pconditiontemp  WHERE posl='$posl'";
//echo $vendor1;
 mysqli_query($db, $vendor1);
$vendor1 = "DELETE FROM pcondition  WHERE posl='$posl'";
//echo $vendor1;
 mysqli_query($db, $vendor1);
 
 $vendor1 = "DELETE FROM subut  WHERE posl='$posl'";
//echo $vendor1;
 mysqli_query($db, $vendor1);
 
 echo "Purchase Order deleted";
 }
 echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"5; URL=../../index.php?keyword=purchase+order+report&s=$status\">";
 exit;
}?>

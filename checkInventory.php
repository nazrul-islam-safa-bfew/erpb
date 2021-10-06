<?php
include("./includes/session.inc.php");
include("./includes/global_hack.php");
include("./includes/config.inc.php");

$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

$sql="select * from itemlist where itemCode like '98-__-%' order by itemCode	desc limit 1";
$q=mysqli_query($db,$sql);
$row=mysqli_fetch_array($q);
$fullCode=$row[itemCode];
$codeArray=explode("-",$fullCode);
$lastTwoCode=($codeArray[1].$codeArray[2])+1;
if($lastTwoCode<=99999){
  $formatlastTwoPart=substr($lastTwoCode,0,2)."-".substr($lastTwoCode,2,3);
  $fullFormatCode=$codeArray[0]."-".$formatlastTwoPart;
}
else
  $fullFormatCode="Error product code";
?>
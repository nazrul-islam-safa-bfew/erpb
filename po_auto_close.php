<?php
include("./includes/config.inc.php"); 
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

$posl=$_GET["posl"];
$po=explode("_",$posl);

$check="select sum(p.qty) qty,p.itemCode as itemCode from porder p where p.posl='$posl'";
// echo "$check<br>";
$q=mysqli_query($db,$check);
$row=mysqli_fetch_array($q);
// print_r($row);

$check1="select sum(s.receiveQty) as receiveQty from store$po[1] s where s.paymentSL='$posl'";
// echo "$check1<br>";
$q1=mysqli_query($db,$check1);
$row1=mysqli_fetch_array($q1);
// print_r($row1);

//echo "$row[receiveQty]==$row[qty]";
if($row1[receiveQty] == $row[qty]){
  $sql="update porder set `status`=2 where posl='$posl'";
  mysqli_query($db,$sql);
  $sql= "update pordertemp set `status`=2 where posl='$posl'";
  mysqli_query($db,$sql);
if(mysqli_affected_rows($db)>0)
 echo "Done";
}else
  echo "Receive qty and po qty are not equal";
?>
<script type="text/javascript">
setTimeout(function(){window.close();},10000);
</script>
<style>
  body{margin:0;padding:0;}
</style>
<?php
$max=15;
include("../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	$gproject=$_GET["gproject"];

$sql1 = mysqli_query($db, "SELECT * FROM iow WHERE iowProjectCode='$gproject' AND iowStatus not in ('Not Ready')");
$total_iow=mysqli_affected_rows($db);
// echo $total_iow."<br>";
// for($i=0;$i<=$total_iow;$i+=$max){
//    echo '<img src="./alliow.g.php?gproject='.$gproject.'&start='.$i.'" style="border:none;">';  
// }
// $i-=$max;
// if($total_iow>$i)
   echo '<img src="./alliow.g.php?gproject='.$gproject.'&start='.$i.'">'; //if it has more lessthen maximum quantity in last term

?>
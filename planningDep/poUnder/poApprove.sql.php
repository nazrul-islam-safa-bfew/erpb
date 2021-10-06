<? // send purchase order for Revision
session_start();
 include("../../includes/config.inc.php");
$loginDesignation=$_SESSION['loginDesignation'];
 
$posl=$_GET[posl];
$status=$_GET[status];
$revision=$_GET[revision];
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

if($posl && $loginDesignation=='Procurement Manager'){

mysqli_query($db, " UPDATE pordertemp set `status`='0' WHERE posl='$posl'");
// echo " UPDATE pordertemp set `status`='-2' WHERE posl='$posl'";
// exit;

echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../../index.php?keyword=purchase+order+report&s=-2\">";	
}

if($posl && $loginDesignation=='Chairman & Managing Director'){
$tt=explode('_',$posl);
$vid=$tt[3];
$project=$tt[1];
/* Revision*/
	
/* end */
/*------------------------DELETE before UPDATE-----------------------------*/
mysqli_query($db, "DELETE from porder where posl='$posl'");
mysqli_query($db, "DELETE from poschedule where posl='$posl'");
mysqli_query($db, "DELETE from popayments where posl='$posl'");
mysqli_query($db, "DELETE from pcondition where posl='$posl'");

/*----------------------END--DELETE before UPDATE-----------------------------*/
$sql11="INSERT INTO porder (select * from pordertemp WHERE posl='$posl')";
//echo $sql11.'<br>';
mysqli_query($db, $sql11);
$r1=mysqli_affected_rows($db);

	
$vendor ="INSERT INTO poschedule (select * from poscheduletemp WHERE posl='$posl')";
//echo $vendor.'<br>';
mysqli_query($db, $vendor);
$r2=mysqli_affected_rows($db);

$vendor1 = "INSERT INTO popayments (select * from popaymentstemp  WHERE posl='$posl')";
//echo $vendor1.'<br>';
$sqlr1= mysqli_query($db, $vendor1);
$r3=mysqli_affected_rows($db);

$vendor1 = "INSERT INTO pcondition (select * from pconditiontemp  WHERE posl='$posl')";
//echo $vendor1.'<br>';
$sqlr1= mysqli_query($db, $vendor1);
$r4=mysqli_affected_rows($db);

$vendor = "UPDATE porder SET status='1',dat='$todat' WHERE posl='$posl'";
//echo $vendor;
$sqlr= mysqli_query($db, $vendor);
$r5=mysqli_affected_rows($db);

if($r1>0 && $r2>0 && $r3>0 && $r4>0 && $r5>0)
{
	mysqli_query($db, "UPDATE pordertemp SET status='1',dat='$todat' WHERE posl='$posl'");
	echo "Your Information is Updating.......";
}
else{
}



echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../../index.php?keyword=purchase+order+report&s=0\">";



}
?>
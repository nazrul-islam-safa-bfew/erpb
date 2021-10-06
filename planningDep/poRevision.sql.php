 <? // send purchase order for Revision
 include("../includes/config.inc.php");
if($posl){
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

$tt=explode('_',$posl);
$vid=$tt[3];
$project=$tt[1];
/* Revision*/
$vendor = "UPDATE porder SET status='3',dat='$todat' WHERE posl='$posl'";
//echo $vendor;
$sqlr= mysql_query($vendor);
	
/*-----------------------START DELETE all information from temp------------------------------*/
mysql_query("DELETE from pordertemp where posl='$posl'");
mysql_query("DELETE from poscheduletemp where posl='$posl'");
mysql_query("DELETE from popaymentstemp where posl='$posl'");
mysql_query("DELETE from pconditiontemp where posl='$posl'");

/*-----------------------END DELETE all information from temp------------------------------*/

$sql11="INSERT INTO pordertemp (select * from porder WHERE posl='$posl')";
//echo $sql11.'<br>';
mysql_query($sql11);	

$vendor ="INSERT INTO poscheduletemp (select * from poschedule WHERE posl='$posl')";
//echo $vendor.'<br>';
mysql_query($vendor);


$vendor1 = "INSERT INTO popaymentstemp (select * from popayments  WHERE posl='$posl')";
//echo $vendor1.'<br>';
$sqlr1= mysql_query($vendor1);

$vendor1 = "INSERT INTO pconditiontemp (select * from pcondition  WHERE posl='$posl')";
//echo $vendor1.'<br>';
$sqlr1= mysql_query($vendor1);

mysql_query("UPDATE porder SET revision=revision+1 WHERE posl='$posl'");

/* BACk up start*********************************/
$sql11="INSERT INTO porderback (select * from porder WHERE posl='$posl')";
//echo $sql11.'<br>';
mysql_query($sql11);	

$vendor ="INSERT INTO poscheduleback (select * from poschedule WHERE posl='$posl')";
//echo $vendor.'<br>';
mysql_query($vendor);


$vendor1 = "INSERT INTO popaymentsback (select * from popayments  WHERE posl='$posl')";
//echo $vendor1.'<br>';
$sqlr1= mysql_query($vendor1);

$vendor1 = "INSERT INTO pconditionback (select * from pcondition  WHERE posl='$posl')";
//echo $vendor1.'<br>';
$sqlr1= mysql_query($vendor1);

/**************************************** BACk up end*/

echo "Your Information is Updating.......";
echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=purchase+order+report&s=0\">";



}
?>
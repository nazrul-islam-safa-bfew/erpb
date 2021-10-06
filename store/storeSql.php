<? 
include('../includes/session.inc.php');
include('../includes/global_hack.php');

if($_POST['save']){


include("../config.inc.php");

//$todat = date("Y-m-d",time());
$todat="2006-07-01";

$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
	
//$itemCode= $itemCode1.'-'.$itemCode2.'-'.$itemCode3;	
$sqlitem = "INSERT INTO `store` (rsid,itemCode, receiveQty,currentQty, rate, receiveFrom, reference, remark,sdate)".
 "VALUES ('','$itemCode', '$receiveQty','$receiveQty', '$rate', '$receiveFrom', '$reference', '$remark', '$todat')";
// echo $sqlitem;
$sqlrunItem= mysql_query($sqlitem);
echo "Your informations are saving...<br> wait Please.. ";
echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=store+entry\">";
}

?>
<? if($_POST['update']){
//include('../session.inc.php');
include("../config.inc.php");
$time=mktime(0,0,0, date("m"),date("d"),date("y"));
$todat = date("Y-m-d",$time);

$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
	
//$itemCode= $itemCode1.'-'.$itemCode2.'-'.$itemCode3;	
$sqlitem = "UPDATE `store` SET itemCode='$itemCode', receiveQty='$receiveQty', rate='$rate',".
" receiveFrom='$receiveFrom', reference='$reference', remark='$remark',sdate='$todat' WHERE rsid=$rsid";
 //echo $sqlitem;
$sqlrunItem= mysql_query($sqlitem);
echo "Your informations are saving...<br> wait Please.. ";
echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=store+entry\">";
}

?>


<? if($_POST['transfer']){
//include('../session.inc.php');
include("../config.inc.php");
$time=mktime(0,0,0, date("m"),date("d"),date("y"));
$todat = date("Y-m-d",$time);

$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
	
for($i=1; $i<$t;$i++){	
$rsid=${rsid.$i};
$transferQty=${transferQty.$i};
$quantity=${quantity.$i}-$transferQty;
if($transferQty)
 {

	/*$sql="SET AUTOCOMMIT=0";
	echo $sql.'<br>';
	$sqlrun= mysql_query($sql);

	$sql="START TRANSACTION";
	echo $sql.'<br>';
	$sqlrun= mysql_query($sql);
	$sql="UPDATE store set currentQty=$quantity WHERE rsid=$rsid ";
		echo $sql.'<br>';
	$sqlrun= mysql_query($sql);
	$rowno=mysql_affected_rows();
	if($rowno){
			$sql=" INSERT INTO `storetransfer` (stid11,transferTo,transferRef, transferQty, rsid,tdate)".
				 "VALUES ('','$transferTo','$transferRef', '$transferQty', '$rsid', '$todat')";
				 	echo $sql.'<br>';
			$sqlrun= mysql_query($sql);
	        $rowno1=mysql_affected_rows();
		 }

	echo "$rowno and $rowno1 ";
			 
	if($rowno == $rowno1 AND $rowno!=-1)	{$sql=" COMMIT"; 	echo $sql.'<br>'; $sqlrun= mysql_query($sql);}
	 else {$sql="ROLLBACK"; 	echo $sql.'<br>'; $sqlrun= mysql_query($sql);}
	//echo $sql;
	//$sqlrun= mysql_query($sql);
	*/	

	$sql = "UPDATE store set currentQty=$quantity WHERE rsid=$rsid";
	 //echo $sql.'<br>';
	$sqlrun= mysql_query($sql);
	
	
	$sqlitem = "INSERT INTO `storetransfer` (stid,transferTo,transferRef, transferQty, rsid,tdate,stn)".
	 "VALUES ('','$transferTo','$transferRef', '$transferQty', '$rsid', '$todat','$stn')";
	 //echo $sqlitem.'<br>';
	$sqlrunItem= mysql_query($sqlitem);

	}// if
}
echo "Your informations are saving...<br> wait Please.. ";
echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=store+entry\">";


}
?>
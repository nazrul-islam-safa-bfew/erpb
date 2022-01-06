<?
$revisionTxt=trim($_GET[revisionTxt]);
if(strlen($revisionTxt)<15 && 1==2){ //stop checking closed text 
	echo "<h1>Closed text should not be less than 15 letter.</h1>";
	echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=./index.php?keyword=purchase+order+report&s=1\">";
	exit;
}

include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);	 

$project=poProject($posl);

// closed text addition
$updateSql="update porder set closedTxt='$revisionTxt' where posl='$posl'";
mysqli_query($db,$updateSql);
$updateSql="update pordertemp set closedTxt='$revisionTxt' where posl='$posl'";
mysqli_query($db,$updateSql);
echo "<br>Closed text has been added successfully.<br>";
//closed text addition end

$poSQL="select itemCode,rate,qty from porder where posl='$posl'";
$poQ=mysqli_query($db,$poSQL);
while($poRow=mysqli_fetch_array($poQ)){
	$itemCode=$poRow[itemCode];
	$rate=$poRow[rate];
	$qty=$poRow[qty];
	$potype=poType($posl);
	$totalReceive=0;
	$subTotalQty=0;
	$deQty=0;
	if($potype==1)$totalReceive=totalReceive('9999-00-00',$project,$posl,$itemCode);
	else if($potype=3)$totalReceive=subWork_Po($itemCode,$posl);

	$deQty=$qty-$totalReceive;
	// echo "totalReceive=$totalReceive -- $deQty<br>"; exit;
	$subTotalQty=$totalReceive;
	$sql="select * from poschedule where posl LIKE '$posl' AND itemCode='$itemCode' ORDER by pos ASC";
	// echo "$sql<br>";
	// exit;
	$sqlq=mysqli_query($db, $sql);
	while($r=mysqli_fetch_array($sqlq)){
	$qt=$r[qty];
	// echo "###$subTotalQty===$r[sdate]==$qt<br>";
	// exit;
	if($qt>=$subTotalQty){
			$sql="UPDATE poschedule set qty='$subTotalQty' where pos=$r[pos]";
			$sql2="UPDATE poscheduletemp set qty='$subTotalQty' where pos=$r[pos]";
			 //echo "** $sql ****<br>"; 
			 echo "UPDATing.... purchase order schedule<br>";
			$subTotalQty=0;
			mysqli_query($db, $sql);
			mysqli_query($db, $sql2);	
	}
	else if($qt<$subTotalQty)$subTotalQty=$subTotalQty-$qt;
	}

	$sql="UPDATE porder set qty=$totalReceive,status='2',fClosed='1' where posl='$posl' and itemCode='$itemCode'";
	$sql2="UPDATE pordertemp set qty=$totalReceive,status='2',fClosed='1' where posl='$posl' and itemCode='$itemCode'";
	echo "UPDATing.... purchase order <br>";
	//echo "$sql<br>";
	mysqli_query($db, $sql);
	mysqli_query($db, $sql2);
	$deTotal=$deQty*$rate;
	$sql="UPDATE popayments set totalAmount=totalAmount-$deTotal where posl='$posl'";
	$sql2="UPDATE popaymentstemp set totalAmount=totalAmount-$deTotal where posl='$posl'";
	//echo "$sql<br>";
	mysqli_query($db, $sql);
	mysqli_query($db, $sql2);
	$sql="UPDATE popayments set receiveAmount=totalAmount where posl='$posl'";
	$sql2="UPDATE popaymentstemp set receiveAmount=totalAmount where posl='$posl'";
	//echo "$sql<br>";
	mysqli_query($db, $sql);
	mysqli_query($db, $sql2);
	echo "UPDATing.... purchase order payment<br>";
} //porder close

echo "Please wait.....";
echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=./index.php?keyword=purchase+order+report&s=1\">";

?>
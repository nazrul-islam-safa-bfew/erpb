<?
if($cashReceive){
$receiveDate1=formatDate($receiveDate,"Y-m-d");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
if($cashReceive){
	$receiveFrom=$client;
	
	$receiveSL1=receiveSL($receiveSL,$w);

}
for($i=1;$i<$n;$i++){
if(${receiveAmount.$i}>0){
	$sql2="select invoiceStatus from invoice where invoiceNo='${reff.$i}'";
	$sqlq2=mysqli_query($db, $sql2);
	$re=mysqli_fetch_array($sqlq2);
	if($re[invoiceStatus]=='1')
	{
		$sql="INSERT INTO receivecash (rid,receiveSL,receiveDate,receiveFrom,receiveAccount,receiveAmount,reff)
		VALUES('','$receiveSL1','$receiveDate1','5000000-$receiveFrom','$receiveAccount','${receiveAmount.$i}','${reff.$i}')";
// 		echo $sql.'<br>';
		$sqlq=mysqli_query($db, $sql);
		
		$sql1="UPDATE invoice set receiveAmount=${receiveAmount.$i},invoiceStatus='2' WHERE invoiceNo='${reff.$i}'";
// 		echo $sql1.'<br>';
		$sqlq=mysqli_query($db, $sql1);
	 }//if($re[invoiceStatus]=='1')
	} //if(${receiveAmount.$i}){
	}//for
 $w='';
}

?>

<?
if($lendercashReceive){
$receiveDate1=formatDate($receiveDate,"Y-m-d");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

	$receiveFrom=$lender;
	$receiveSL1=receiveSL($receiveSL,$w);


	$sql="INSERT INTO receivecash (rid,receiveSL,receiveDate,receiveFrom,receiveAccount,receiveAmount,reff)".
		 " VALUES('','$receiveSL1','$receiveDate1','$receiveFrom','$receiveAccount','${receiveAmount.$i}','$reff')";
// 	echo $sql.'<br>';
	$sqlq=mysqli_query($db, $sql);
}
?>

<?
if($othercashReceive){
$receiveDate1=formatDate($receiveDate,"Y-m-d");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

	$receiveFrom=$incomeAccount;
	$receiveSL1=receiveSL($receiveSL,$w);


	$sql="INSERT INTO receivecash (rid,receiveSL,receiveDate,receiveFrom,receiveAccount,receiveAmount,reff)".
		 " VALUES('','$receiveSL1','$receiveDate1','$receiveFrom','$receiveAccount','${receiveAmount.$i}','$reff')";
// 	echo $sql.'<br>';
	$sqlq=mysqli_query($db, $sql);

}
?>
<? 
include("../includes/session.inc.php");
include("../includes/config.inc.php");
include("../includes/myFunction.php");
$supervisor=$loginUname;

$db =  mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);



//echo "edate=$edate";
$edate=formatDate($edate, 'Y-m-j');

//echo "edate=$edate";
$totalQty=0;
//echo "N$n<br>";

//echo "qtyatHand<br>$qtyatHand";
//if($qtyatHand<=0) {echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=issue\">"; exit;}

for($i=1;$i<$n;$i++){
 if(${issuedQty.$i}>0){
	 

	$qtyatHand=qtyatHand(${itemCode.$i},$loginProject,$edate);

	if($qtyatHand==0) {echo "Not available"; exit;}

	$qtyissued= qtyissued(${itemCode.$i},$loginProject,$iow,$siow);	
	///echo "<br>$qtyissued==${dmaQty.$i}<br>";
	$remainQty=${dmaQty.$i}-$qtyissued;
	//echo "<br>remainQty=$remainQty<br>";
  if($remainQty<=0){ echo "IOW has no remaining Qty!!"; exit;}

	$sqls = "SELECT * from store$loginProject where itemCode ='${itemCode.$i}' AND currentQty <> 0 ORDER by rsid ASC";
		//echo "$sqls<br>";
		$sqlsq=mysqli_query($db,$sqls);
		while($sr=mysqli_fetch_array($sqlsq) AND ${issuedQty.$i}>0){
		  if(${issuedQty.$i} <= $sr[currentQty]){
				$sqlp = "INSERT INTO issue$loginProject (issueSL, itemCode, iowId, siowId, issuedQty,issueRate, issueDate,supervisor)".
					 "VALUES ('', '${itemCode.$i}', '$iow', '$siow', '${issuedQty.$i}', $sr[rate],'$edate','$supervisor')";
				//echo $sqlp.'<br>';
				$sqlrunp= mysqli_query($db,$sqlp);
				
			$sql= "UPDATE store$loginProject set currentQty=($sr[currentQty]-${issuedQty.$i}) where rsid=$sr[rsid] ";
			//echo $sql.'<br>';
			$sqlqq=mysqli_query($db,$sql);
			${issuedQty.$i}=0;			
		 }//if
		  else if(${issuedQty.$i} > $sr[currentQty])
		  {
			$sqlp = "INSERT INTO issue$loginProject (issueSL, itemCode, iowId, siowId, issuedQty,issueRate, issueDate,supervisor)".
			"VALUES ('', '${itemCode.$i}', '$iow', '$siow', '$sr[currentQty]', $sr[rate],'$edate','$supervisor')";
			//echo $sqlp.'<br>';
			$sqlrunp= mysqli_query($db,$sqlp);
			${issuedQty.$i}=${issuedQty.$i}-$sr[currentQty];
			
			$sql= "UPDATE store$loginProject set currentQty=0 where rsid=$sr[rsid] ";
			//echo $sql.'<br>';
			$sqlqq=mysqli_query($db,$sql);	
 		  }//else if
		}//while
		
		}//if
}//for
//echo 'here';
echo "Please wait... Updating............";
echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=issue\">";

?>


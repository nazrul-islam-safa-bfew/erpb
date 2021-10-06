 <? // send purchase order for Revision
 include("../../includes/config.inc.php");
 $todat=date("Y-m-d");

 $posl=$_GET[posl];
 $status=$_GET[status];
 $revision=$_GET[revision];
 $actionType=$_GET[actionType]; //a = accept || b= back for revision
 
if($posl){
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
$tt=explode('_',$posl);
$vid=$tt[3];
$project=$tt[1];
/* Revision*/
if($actionType=="a"){
	$rSql="select * from po_revision where posl='$posl' and revisionNo='$revision'";
	$rQ=mysqli_query($db,$rSql);
	$ii=0;
	while($rRow=mysqli_fetch_array($rQ)){

		$vendor="update poschedule set sdate='$rRow[sdate]' where posl='$posl' and itemCode='$rRow[itemCode]'";
		mysqli_query($db, $vendor);
		
		/* // popayments work should be work next time while fetch any payment problem
		$vendor1 = "INSERT INTO popayments (select * from popaymentstemp  WHERE posl='$posl')";
		//echo $vendor1.'<br>';
		$sqlr1= mysqli_query($db, $vendor1);
		*/
		
	} 
$revisionStatus="accepted";
} //if accepted
else{ //else rejected
$revisionStatus="rejected";
}

/*  po_revisoin revision status change   */
if($revisionStatus){
	 $rSql="update po_revision set revisionStatus='$revisionStatus',acceptDate='$todat' where posl='$posl' and revisionNo='$revision'";
	$rQ=mysqli_query($db,$rSql);
}



/* end */

	






// 	mysqli_query($db, "UPDATE pordertemp SET status='1',dat='$todat' WHERE posl='$posl'");
	echo "Your Information is Updating.......";




echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../../index.php?keyword=purchase+order+report&s=0\">";


exit;
} //if posl

	echo "Error while information is updating!";

echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../../index.php?keyword=purchase+order+report&s=0\">";
?>
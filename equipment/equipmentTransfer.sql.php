<? include("../includes/session.inc.php");?>
<? include("../includes/myFunction.php");?>
<? 
//echo 'NNNNN'.$n;
include("../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$edate= formatDate($edate,"Y-m-d");	
for($i=1;$i<$n;$i++){
//  echo '<br>MMMM'.${m.$i};
  for($j=1; $j<${m.$i}; $j++){
	
	 if(${pch.$i.'_'.$j}){
        $assetId = ${assetId.$i.'_'.$j};   
        $itemCode = ${itemCode.$i};   		
    	$sql="INSERT INTO `eqproject` ( `id` , `itemCode` , `assetId` , `pCode` , `sdate` , `edate` , `receiveDate` , `posl` , `reff`,status,dispatch,dispatchDate )".
		" VALUES ('', '$itemCode', '$assetId', '$pCode', '0000-00-00', '0000-00-00', '$edate', '$posl', '$eqtsl','0','','')";
	 
	//echo '<br>'.$sql.'<br>';
	  mysqli_query($db, $sql);
	  
	  $sql="update equipment set location='$pCode' WHERE assetId='$assetId' AND ItemCode='$itemCode'";
	  //echo $sql;
	  $sqlq=mysqli_query($db, $sql);
	}//if

	}//for i
}//for j

	echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=equipment+transfer\">";
?>
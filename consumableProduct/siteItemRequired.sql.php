<?
 if($_POST['approved']){
//echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=site+item+required\">";
 include("config.inc.php");
$db11 = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
for($j=1;$j<$n;$j++){
 $qty = ${currentQty.$j};
 $itemCode = ${itemCode.$j};
//  echo "<br> The qty: ".$qty. " >> $itemCode<br>";	
 if(${currentQty.$j}>0)
 {
 $sql="SELECT dmaRate from dma  WHERE dmaItemCode ='${itemCode.$j}'";

	$sqlquery=mysqli_query($db, $sql);
	while($sqlresult=mysqli_fetch_array($sqlquery))
	{
	$rate=$sqlresult[dmaRate];
	}
  $sqlp = "INSERT INTO porder (poid, posl, poacc,location, itemCode, qty, rate,vid,status,qref,deliveryDetails,dstart,dat) VALUES ('','$posl','','$loginProject','${itemCode.$j}','${currentQty.$j}','$rate', '5','1','','','$d','$todat')";
//echo $sqlp.'<br>';
mysqli_query($db, $sqlp);
}//if currentQty

}
//$approved=0;
}//if
?>
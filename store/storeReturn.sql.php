<?
include("../includes/session.inc.php");
include("../includes/config.inc.php");
include("../includes/myFunction.php");

$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);
	
if($save=='Save'){
$edate=formatDate($edate, 'Y-m-d');
//echo "N=$n";	
for($i=1;$i<$n;$i++){
//echo ${rqty.$i}."**<br>";
	if(${rqty.$i}>0){
		
		$sql="SELECT * FROM store$loginProject where itemCode='${itemCode.$i}' AND currentQty > 0 ORDER by rsid ASC";
		//echo $sql.'<br>';
		$sqlq=mysqli_query($db, $sql);
		while($r=mysqli_fetch_array($sqlq)){
		  if($r[currentQty]==${rqty.$i}){
		    $sql2="UPDATE store$loginProject set currentQty=0 where rsid='$r[rsid]'";
			mysqli_query($db, $sql2);
			$sql3="INSERT INTO storet (id,itemCode,receiveQty,currentQty,rate,returnFrom,rsl,remark,edate,delivery)".
			" VALUES('','${itemCode.$i}','${rqty.$i}','${rqty.$i}','${rate.$i}','$loginProject','$rsl','${quality.$i}','$edate','$delivery')";
			mysqli_query($db, $sql3);
			//echo $sql3.'<br>';
			break;
		  }
		  elseif($r[currentQty]>${rqty.$i}){
		    $sql2="UPDATE store$loginProject set currentQty=currentQty-${rqty.$i} where rsid='$r[rsid]'";
			mysqli_query($db, $sql2);
			$sql3="INSERT INTO storet (id,itemCode,receiveQty,currentQty,rate,returnFrom,rsl,remark,edate,delivery)".
			" VALUES('','${itemCode.$i}','${rqty.$i}','${rqty.$i}','${rate.$i}','$loginProject','$rsl','${quality.$i}','$edate','$delivery')";
			mysqli_query($db, $sql3);
			//echo $sql3.'<br>';
			break;
		  }
		  elseif($r[currentQty]<${rqty.$i}){
		    $sql2="UPDATE store$loginProject set currentQty=0 where rsid='$r[rsid]'";
			mysqli_query($db, $sql2);
			$sql3="INSERT INTO storet (id,itemCode,receiveQty,currentQty,rate,returnFrom,rsl,remark,edate,delivery)".
			" VALUES('','${itemCode.$i}','$r[currentQty]','$r[currentQty]','${rate.$i}','$loginProject','$rsl','${quality.$i}','$edate','$delivery')";
			mysqli_query($db, $sql3);
			${rqty.$i}=${rqty.$i}-$r[currentQty];
			//echo $sql3.'<br>';
		  }
		
		}//while
	}

}
}
else if($save=='Update'){
//echo "N=$n";
for($i=1;$i<$n;$i++){
$sql="UPDATE storet set remark='${quality.$i}' WHERE itemCode='${itemCode.$i}' AND rsl='$rsl'";
//echo "$sql<br>";
mysqli_query($db, $sql);
}

}
//echo $sql;
echo "Your informations are saving...<br> wait Please.. ";
echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=store+return\">";

?>

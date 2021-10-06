<? 
include("../includes/config.inc.php");
//include("../includes/session.inc.php");
include("../includes/myFunction.php");
include("../includes/empFunction.inc.php");

$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$format="Y-m-j";
$edat = formatDate($edat,$format);
//echo $edat;	
$todat=todat();	




if($_GET["auto"]==1){
	 $sqlquery="SELECT * FROM eqproject where  status='1' ORDER by itemcode ASC ";
//echo $sqlquery;
 $sql= mysqli_query($db, $sqlquery);
						echo "Equipment founds: ".mysqli_affected_rows($db)." Nos<br>";
	while($row=mysqli_fetch_array($sql)){
		
		$loginProject=$row["pCode"];
		$eqId=$row["assetId"];
		$itemCode=$row["itemCode"];
		$edat=$todat;
		$action="P";
		$posl=$row["posl"];
		
		 $sql1="INSERT INTO eqattendance(id, eqId,itemCode, edate, action, stime,etime, todat,location,posl )"."
  VALUES ('', '$eqId','$itemCode', '$edat', '$action', '08:00','16:59','$todat','$loginProject','$posl' )";
	 mysqli_query($db, $sql1);
		
		echo "Equipment present: 
	<br>	=> Equipment Id:".$eqId.
	"<br>	=> Item Code:".$itemCode.
	"<br>	=> Posl:".$posl.
	"<br>	=> Location:".$loginProject.
	"<br> => Trying to present:".mysqli_affected_rows($db)." || ".mysqli_error($db);
		
	 if(mysqli_affected_rows($db)){

		$sql1="UPDATE eqattendance set action='$action', location='$loginProject' WHERE eqId='$eqId' AND itemCode='$itemCode' AND edate='$edat' AND posl='$posl'";
		mysqli_query($db, $sql1);
		 
	echo "<br> => Retrying to present:".mysqli_affected_rows($db)." || ".mysqli_error($db);
	 }
	echo "<br>======================================<br>";
	}
	exit();
}





 for($i=1;$i<$m;$i++){
	
if(${ch.$i}) $action="P";
 else $action="A";
				
 $sql="INSERT INTO eqattendance(id, eqId,itemCode, edate, action, stime,etime, todat,location,posl )"."
  VALUES ('', '${eqId.$i}','${itemCode.$i}', '$edat', '$action', '08:00','16:59','$todat','$loginProject','${posl.$i}' )";
  
echo $sql.'<br>';
 $sqlq1=mysqli_query($db, $sql);

if(mysqli_affected_rows($db)<=0){
	$sql="UPDATE eqattendance set action='$action' 
	WHERE eqId='${eqId.$i}' AND itemCode='${itemCode.$i}' AND edate='$edat' AND posl='${posl.$i}'";
	echo "$sql<br>";
	 $sqlq1=mysqli_query($db, $sql);
	}//if

 }

echo "UPDATING .......... please wait";
echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=eq+out\">";
?>

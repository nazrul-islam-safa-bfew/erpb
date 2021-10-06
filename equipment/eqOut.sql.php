<? 
include("../includes/session.inc.php");
include("../includes/config.inc.php");
include("../includes/myFunction.php");
include("../includes/eqFunction.inc.php");
include("../includes/empFunction.inc.php");

$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);
	

$format="Y-m-j";
$edat = formatDate($edat,$format);
//echo $edat;	
$todat=todat();	


	$supervisor=$loginUname;

 for($i=1;$i<$m;$i++){
	 $sql="select * from equt  where `eqId`='${eqId.$i}' and `itemCode`='${itemCode.$i}' and `stime`='13:00:00
' and `etime`='13:59:00' and `details`='Lunch' and pcode='$loginProject' and supervisor='$supervisor' and edate='$edat'";
	 	mysqli_query($db, $sql);

if(${ch.$i}){
	$action="P";
	if(mysqli_affected_rows($db)<1){
	$sql = "INSERT INTO `equt` (`eqId`,`itemCode`,`iow` ,`siow` ,`stime`,`etime`,`details`,
		`edate`,pcode,posl,supervisor)
		VALUES ('${eqId.$i}','${itemCode.$i}', '0', '0', '13:00:00', '13:59:00', 'Lunch','$edat','$loginProject','','$supervisor')";
//echo $sql;
	mysqli_query($db, $sql);
//echo mysqli_error($db);
	}
}else{
	$action="A";
	$sql = "delete from `equt` where `eqId`='${eqId.$i}' and `itemCode`='${itemCode.$i}' and `stime`='13:00:00
	' and `etime`='13:59:00' and `details`='Lunch' and pcode='$loginProject' and supervisor='$supervisor' and edate='$edat'";
	mysqli_query($db, $sql);
 }
	
	
	$eqFullID=${eqId.$i}."_".${itemCode.$i}; //sample 2_50-02-000
	$eqFullIdDesc=$_POST["desc_".$eqFullID]; //sample desc_2_50-02-000
	$eqCondition=$_POST["condition_".$eqFullID]; //sample condition_2_50-02-000
	
	$allConditions=getEquipmentConditions(null,true);
//"running","idle","breakdown","trubledRunning"
//print_r($_POST);
//echo $eqFullID;

	if($eqCondition!=$allConditions[0] && $action=="P"){
		if(strlen($eqFullIdDesc)<10){
			echo "Description at least 10 letters.";
			exit;
		}
	}else{
		$eqFullIdDesc="";
	}
	
 if($eqCondition==$allConditions[2] or $eqCondition==$allConditions[3]){
	 $startTime=$_POST["h1_".$eqFullID] ? $_POST["h1_".$eqFullID] : "08";
	 $startTime.=":";
	 $startTime.=$_POST["m1_".$eqFullID] ? $_POST["m1_".$eqFullID] : "00";

	 $endTime=$_POST["h2_".$eqFullID] ? $_POST["h2_".$eqFullID] : "16";
	 $endTime.=":";
	 $endTime.=$_POST["m2_".$eqFullID] ? $_POST["m2_".$eqFullID] : "59";
	 
	 
	 equipmentChangeCondition(${eqId.$i},${itemCode.$i},$eqCondition);
	 
	 
	 $sql="delete from equt where eqId='${eqId.$i}' and itemCode='${itemCode.$i}' and iow='-1' and siow='-1' and edate='$edat' and pcode='$loginProject'";
	 mysqli_query($db, $sql);
	 

$sql="INSERT INTO equt(eqId, itemCode,iow, siow, stime,etime, details, edate, pcode, posl, supervisor) VALUES ('${eqId.$i}','${itemCode.$i}','-1','-1','$startTime','$endTime','$eqFullIdDesc','$edat','$loginProject','${posl.$i}','$supervisor')";
// 	 echo $sql;
	 mysqli_query($db, $sql);
 }
	
$sql="INSERT INTO eqattendance(id, eqId,itemCode, edate, action, stime,etime, todat,location,posl,details,type) VALUES ('','${eqId.$i}','${itemCode.$i}','$edat', '$action', '08:00','16:59','$todat','$loginProject','${posl.$i}','$eqFullIdDesc','$eqCondition')";

// if(mysqli_affected_rows($db)<1)
// 	 echo $sql.'<br>';
// else
// 	echo mysqli_insert_id($db);

 $sqlq1=mysqli_query($db, $sql);

if(mysqli_affected_rows($db)<=0){
	$sql="UPDATE eqattendance set action='$action',details='$eqFullIdDesc',type='$eqCondition'
	WHERE eqId='${eqId.$i}' AND itemCode='${itemCode.$i}' AND edate='$edat' AND posl='${posl.$i}'";
//	echo "$sql<br>";
	 $sqlq1=mysqli_query($db, $sql);
	}//if
 }

//  
$sql="delete from eqattendance where action='A'";
mysqli_query($db,$sql);
//


echo "UPDATING .......... please wait";
echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=eq+out\">";
?>

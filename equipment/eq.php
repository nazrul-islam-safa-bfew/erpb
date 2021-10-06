<? 
/*
include("../includes/config.inc.php");
include("../includes/myFunction.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$sql="select * from equipment order by assetId";
$sqlqm=mysqli_query($db, $sql);
while($re=mysqli_fetch_array($sqlqm)){
	 
	// $sql1="UPDATE attendance set  empId='$re[id]' WHERE empId='$re[empId]' ";
	$temp=explode('-',$re[assetId]);
	$assetId=$temp[2];
	
	$itemCode = "$temp[0]-$temp[1]-000";
    $sql1="UPDATE equipment set  assetId='$assetId',itemCode='$itemCode' WHERE eqid='$re[eqid]' ";	
   //  $sql1="UPDATE equipment set  itemCode='$itemCode' WHERE eqid='$re[eqid]' ";		
    // $sql1="UPDATE equipment set  assetId='$assetId' WHERE eqid='$re[eqid]' ";		
	 
	 echo $sql1.'<br>';
    $sqlq1=mysqli_query($db, $sql1);

	}

*/

include("../includes/config.inc.php");
include("../includes/myFunction.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
/*
$sql="select edate,eqId,itemCode from eqattendance WHERE edate between '2006-01-01' AND '2006-08-01' order by edate ASC";
//echo "$sql<br>";
$sqlq=mysqli_query($db, $sql);
while($r1=mysqli_fetch_array($sqlq)){

 $sq="SELECT * from equt where edate='$r1[edate]' AND eqId='$r1[eqId]' AND  itemCode='$r1[itemCode]' AND stime='13:00:00'";
 //echo "$sq<br>";
 
  $sqq=mysqli_query($db, $sq);
  $num_rows = mysql_num_rows($sqq);
  if($num_rows>1){
   $i=1; 
   while($d=mysqli_fetch_array($sqq) AND $i<$num_rows)
   {
    $sa="DELETE from equt where id=$d[id]";
	//echo "**$sa**<br>";
    mysqli_query($db, $sa); 
	$i++;
	}
  
  }

  

}
*/
/*

$sql="select * from eqproject order by assetId ASC";
echo $sql.'<br>';
$sqlqm=mysqli_query($db, $sql);
while($re=mysqli_fetch_array($sqlqm)){
//if($re[itemCode]=='50-02-000'){

if($re[assetId]{0}=='A')  { $type='L';}
		else { $type='H'; }

		
$sql="select edate from eqattendance WHERE eqId='$re[assetId]' order by edate ASC";
$sqlq=mysqli_query($db, $sql);
$r1=mysqli_fetch_array($sqlq);
$sdate=$r1[edate];
$sql="select edate from eqattendance WHERE eqId='$re[assetId]' order by edate DESC";
$sqlq=mysqli_query($db, $sql);
$r1=mysqli_fetch_array($sqlq);
$edate=$r1[edate];

$edate='2006-09-01';
$sdate=$re[receiveDate];


$duration=((strtotime($edate)-strtotime($sdate))/86400)+1;
echo "$duration=$duration";
for($i=1;$i<=$duration;$i++){

$edat=date("Y-m-d",strtotime($sdate)+(86400*$i));

	$sql="INSERT INTO eqattendance(id, eqId,itemCode,eqType, edate, action, text, over1,over2,over3,over4, todat,location )"."
	VALUES ('', '$re[assetId]','$re[itemCode]','$type', '$edat', 'P', '', '08','00','16','59','2006-08-01','$re[pCode]' )";
	
	echo $sql.'<br>';
	$sqlq1=mysqli_query($db, $sql);
	if(mysqli_affected_rows()>=1){
	
	$sql2 = "INSERT INTO `equt` ( `id` , `eqId` ,`eqType`,`itemCode`, `iow` , `siow` , `stime` , `etime` , `details` , `edate`,pcode ) ".
	"VALUES ('', '$re[assetId]','$type','$re[itemCode]', '', '', '13:00', '13:59', 'Lunch', '$edat','$re[pCode]')";
	
	//echo $sql2.'<br>';
	$sqlq2=mysqli_query($db, $sql2);
        }
}//for
//}//if
}*/


$sql="select * from eqproject WHERE posl LIKE 'EQ_130_%'  order by assetId ASC";
echo $sql.'<br>';
$sqlqm=mysqli_query($db, $sql);
while($re=mysqli_fetch_array($sqlqm)){
//if($re[itemCode]=='50-02-000'){

if($re[assetId]{0}=='A')  { $type='L';}
		else { $type='H'; }

putenv ('TZ=Asia/Dacca'); 
//$edate=date("Y-m-d");
$duration=((strtotime($edate)-strtotime($re[receiveDate]))/86400)+1;
//echo "$re[posl]#$re[receiveDate]>>$re[edate]=duration=$duration<br>";
echo "$re[posl]#$re[receiveDate]>>$edate=duration=$duration<br>";

for($i=0;$i<$duration;$i++){
putenv ('TZ=Asia/Dacca'); 
$edat=date("Y-m-d",strtotime($re[receiveDate])+(86400*$i));

	$sql="INSERT INTO eqattendance(id, eqId,itemCode,eqType, edate, action, text, over1,over2,over3,over4, todat,location )"."
	VALUES ('', '$re[assetId]','$re[itemCode]','$type', '$edat', 'P', '', '08','00','16','59','2006-08-01','$re[pCode]' )";
	
	//echo $sql.'<br>';
	$sqlq1=mysqli_query($db, $sql);
	if(mysqli_affected_rows()>=1){
	
	$sql2 = "INSERT INTO `equt` ( `id` , `eqId` ,`eqType`,`itemCode`, `iow` , `siow` , `stime` , `etime` , `details` , `edate`,pcode ) ".
	"VALUES ('', '$re[assetId]','$type','$re[itemCode]', '', '', '13:00', '13:59', 'Lunch', '$edat','$re[pCode]')";
	
	//echo $sql2.'<br>';
	$sqlq2=mysqli_query($db, $sql2);
        }
	}//for	
}//while
?>
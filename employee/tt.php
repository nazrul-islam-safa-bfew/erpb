<? include("../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
?>
<? 
/*
include("../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$sql="select * from leave";
$sqlqm=mysqli_query($db, $sql);
while($re=mysqli_fetch_array($sqlqm)){

	   
    		   $duration=1+(strtotime($re[edate])-strtotime($re[sdate]))/86400;
			   echo $duration.'<br>';
		 for($i=1;$i<=$duration; $i++){  
		 $edate=date('Y-m-d',strtotime($re[sdate])+(84600*$i));
		 $sql0="INSERT INTO attendance(id, empId, edate, action, text, over1,over2,over3,over4, todat,location )".
		 					" VALUES ('', '$re[empId]', '$edate', 'L', '', '','','','','$todat','$re[location]' )";
		 echo $sql0.'<br>';
		 $sqlq0=mysqli_query($db, $sql0);
		 $ro=mysqli_affected_rows();
		if($ro='-1'){
			 $sql1="UPDATE attendance set  action='L' WHERE empId='$re[empId]' AND edate='re[$edate]'";
 		     $sqlq1=mysqli_query($db, $sql1);
			 		 echo $sqlq1.'<br>';
			}
		     
}
}
*/
/*
include("../includes/config.inc.php");
include("../includes/myFunction.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$sql="select * from attendance";
$sqlqm=mysqli_query($db, $sql);
while($re=mysqli_fetch_array($sqlqm)){
if(isHoliday($re[edate])){
	 $sql1="UPDATE attendance set  action='HP' WHERE empId='$re[empId]' AND edate='$re[edate]' AND action='p'";
	 echo $sql1.'<br>';
     $sqlq1=mysqli_query($db, $sql1);
	 
	 $sql1="UPDATE attendance set  action='HA' WHERE empId='$re[empId]' AND edate='$re[edate]' AND action='A'";
	 echo $sql1.'<br>';
     $sqlq1=mysqli_query($db, $sql1);

	}

}
*/
?>

<? 
/*
include("../includes/config.inc.php");
include("../includes/myFunction.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$sql="select * from employee";
$sqlqm=mysqli_query($db, $sql);
while($re=mysqli_fetch_array($sqlqm)){
	 
	// $sql1="UPDATE attendance set  empId='$re[id]' WHERE empId='$re[empId]' ";
    $sql1="UPDATE leave set  empId='$re[id]' WHERE empId='$re[empId]' ";	
	 echo $sql1.'<br>';
     $sqlq1=mysqli_query($db, $sql1);
	}
*/
?>

<? 
/*
include("../includes/config.inc.php");
include("../includes/myFunction.php");
include("../includes/myFunction1.php");

$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$sql="select * from employee";
$sqlqm=mysqli_query($db, $sql);
while($re=mysqli_fetch_array($sqlqm)){	 
   $sql1="DELETE FROM attendance WHERE empId='$re[empId]' AND edate< '$re[empDate]' ";	
	 echo $sql1.'<br>';
     $sqlq1=mysqli_query($db, $sql1);
	}
/*include_once("../includes/empFunction.inc.php");
check('2006-05-17');
*/

$sql="select * from attendance ";	
$sqlq=mysqli_query($db, $sql);
while($r=mysqli_fetch_array($sqlq)){

$stime="$r[over1]:$r[over2]:00";
$etime="$r[over3]:$r[over4]:00";

$sql2="INSERT INTO `attendancetemp`
 ( `id` , `empId`, `edate` ,`action` , `stime` , `etime` , `todat` , `location`)   
VALUES 
('$r[id]', '$r[empId]', '$r[edate]', '$r[action]','$stime', '$etime', '$r[todat]', '$r[location]')";

//echo "$sql2<br>";
mysqli_query($db, $sql2);

	if($r[remarks]){$sql3="INSERT INTO attremarks (attId,remarks) values('$r[id]','$r[remarks]')";
	echo "$sql3<br>";
	mysqli_query($db, $sql3);
	}//$r[remarks]
}
?>
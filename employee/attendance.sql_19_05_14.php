<? 
include("../includes/session.inc.php");
include("../includes/config.inc.php");
include("../includes/myFunction.php");

$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$todat=date('Y-m-j');
$format="Y-m-j";
$edate = formatDate($_POST['d'],$format);

$n=$_POST['n']."<br>";

for($i=0;$i<$n;$i++){
if($_POST[action.$i]=='A' OR $_POST[action.$i]== 'HA'){$_POST[eh.$i]='00'; $_POST[em.$i]='00';}

 $sql="INSERT INTO attendance(`id` , `empId`, `edate` ,`action` , `stime` , `etime` , `todat` , `location` )".
 " VALUES ('', '".$_POST[empId.$i]."', '".$edate."', '".$_POST[action.$i]."', 
 '".$_POST[eh.$i].":".$_POST[em.$i].":00', '".$_POST[xh.$i].":".$_POST[xm.$i].":00' ,'".$todat."','".$_POST[project]."' )";
//echo $sql.'<br>';



//'${empId.$i}', '$edate', '${action.$i}', '${eh.$i}:${em.$i}:00','${xh.$i}:${xm.$i}:00','$todat','$project' )";
 $sqlq=mysqli_query($db, $sql);
 $ro=mysqli_affected_rows();
 if($ro!='-1'){
	  if($_POST[remarks.$i]){
	  $attId=mysql_insert_id();
	  $sql12="INSERT INTO attremarks (attId,remarks) values('$attId','".$_POST[remarks.$i]."')";
	  // $sql12="INSERT INTO attremarks (attId,remarks) values('$attId','${remarks.$i}')";
	  mysqli_query($db, $sql12);
	  }
  }
 
 if($ro='-1'){
 $sq="SELECT id from attendance where empId='".$_POST[empId.$i]."' AND edate='$edate'";
 //$sq="SELECT id from attendance where empId='${empId.$i}' AND edate='$edate'";
 $sqlq=mysqli_query($db, $sq);
 $re=mysqli_fetch_array($sqlq);
 $attId=$re[id];

//echo "++${eh.$i}=${em.$i}++";
if($location) //condition add by suvro 19-05-14 
 $sql1="UPDATE attendance set  action='".$_POST[action.$i]."',location='".$location."',stime='".$_POST[eh.$i].":".$_POST[em.$i].":00',etime='".$_POST[xh.$i].":".$_POST[xm.$i].":00' WHERE id='$re[id]' AND action in ('HA','HP','P','A')";
 else
 $sql1="UPDATE attendance set  action='".$_POST[action.$i]."',stime='".$_POST[eh.$i].":".$_POST[em.$i].":00',etime='".$_POST[xh.$i].":".$_POST[xm.$i].":00' WHERE id='$re[id]' AND action in ('HA','HP','P','A')";
 // end of condition 19-05-14 
/* $sql1="UPDATE attendance set  action='${action.$i}',stime='${eh.$i}:${em.$i}:00',etime='${xh.$i}:${xm.$i}:00'
  WHERE id='$re[id]' AND action in ('HA','HP','P','A')"; */
  
  
 $sqlq=mysqli_query($db, $sql1);
//echo "$sql1<br>";
 
	 if($_POST[remarks.$i]){
		$sql12="INSERT INTO attremarks (attId,remarks) values('$attId','".$_POST[remarks.$i]."')";
		//$sql12="INSERT INTO attremarks (attId,remarks) values('$attId','${remarks.$i}')";
		mysqli_query($db, $sql12);

		 $sql13="UPDATE attremarks set  remarks='".$_POST[remarks.$i]."' where attId='$attId'";
		 // $sql13="UPDATE attremarks set  remarks='${remarks.$i}' where attId='$attId'";
		// echo "$sql13<br>";
		 mysqli_query($db, $sql13);
	 }
 
  }
 }

 echo "Updating.....<br>wait please.........";
echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=attendance\">";

?>
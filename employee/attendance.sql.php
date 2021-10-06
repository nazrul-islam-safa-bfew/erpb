<? 
$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
include($localPath."/includes/config.inc.php"); //datbase_connection
include($localPath."/includes/session.inc.php");
include($localPath."/includes/myFunction.php"); // some general function
include($localPath."/includes/empFunction.inc.php"); //manpower function
include($localPath."/employee/wages_calc.php"); //manpower function

// include("../includes/session.inc.php");
// include("../includes/config.inc.php");
// $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);	
// include("../includes/myFunction.php");
// include("../includes/empFunction.inc.php");
// include("./wages_calc.php");


$todat=date('Y-m-j');
$format="Y-m-j";
$edate = formatDate($_POST['d'],$format);
$_SESSION["nextDateUrl"]="<a style='text-align:center; padding:10px;' href='./index.php?keyword=attendance&d=".date("d/m/Y",strtotime($edate."+1 day"))."&project=".$_POST[project]."'>Jump to Next day</a>";
$n=$_POST['n']."<br>";

for($i=0;$i<$n;$i++){
	if($_POST[action.$i]=='A' OR $_POST[action.$i]== 'HA'){$_POST[eh.$i]='00'; $_POST[em.$i]='00';}

	 $sql="INSERT INTO attendance(`id` , `empId`, `edate` ,`action` , `stime` , `etime` , `todat` , `location` )".
	 " VALUES ('', '".$_POST[empId.$i]."', '".$edate."', '".$_POST[action.$i]."', 
	 '".$_POST[eh.$i].":".$_POST[em.$i].":00', '".$_POST[xh.$i].":".$_POST[xm.$i].":00' ,'".$todat."','".$_POST[project]."' )";
	// echo $sql.'<br>';
	if($_POST[action.$i]=='HA' || $_POST[action.$i]=='P'){
		$designation=empId2Designation($_POST[empId.$i]);
		
		$breakSql="insert into emput (empId,empType,designation,iow,siow,stime,etime,edate,pcode,supervisor) values (
		'".$_POST[empId.$i]."','H','$designation','','','13:00','13:59','$edate','$_POST[project]','$loginDesignation')";
		$sqlq=mysqli_query($db, $breakSql);
	// 	echo $breakSql;
}else{
	
}

//'${empId.$i}', '$edate', '${action.$i}', '${eh.$i}:${em.$i}:00','${xh.$i}:${xm.$i}:00','$todat','$project' )";
 
 $sqlq=mysqli_query($db, $sql);
 $ro=mysqli_affected_rows($db);
 if($ro!='-1'){
	  if($_POST[remarks.$i]){
	  $attId=mysqli_insert_id($db);
	  $sql12="INSERT INTO attremarks (attId,remarks) values('$attId','".$_POST[remarks.$i]."')";
	  // $sql12="INSERT INTO attremarks (attId,remarks) values('$attId','${remarks.$i}')";
	  mysqli_query($db, $sql12);
	  }
  }
 
 if($ro=='-1'){
 $sq="SELECT id from attendance where empId='".$_POST[empId.$i]."' AND edate='$edate'";
 //$sq="SELECT id from attendance where empId='${empId.$i}' AND edate='$edate'";
 $sqlq=mysqli_query($db, $sq);
 $re=mysqli_fetch_array($sqlq);
 $attId=$re[id];

//echo "++${eh.$i}=${em.$i}++";
 $sql1="UPDATE attendance set  action='".$_POST[action.$i]."',stime='".$_POST[eh.$i].":".$_POST[em.$i].":00',etime='".$_POST[xh.$i].":".$_POST[xm.$i].":00',location='$_POST[project]' WHERE id='$re[id]' AND action in ('HA','HP','P','A')";
  
/* $sql1="UPDATE attendance set  action='${action.$i}',stime='${eh.$i}:${em.$i}:00',etime='${xh.$i}:${xm.$i}:00'
  WHERE id='$re[id]' AND action in ('HA','HP','P','A')"; */
  
  
 $sqlq=mysqli_query($db, $sql1);
// echo "$sql1<br>";
 
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
	
	
	if($_POST[empId.$i] && $edate && $_POST[project]){ //wages calculation start
		$_GET["empID"]=$_GET["start"]=$_GET["debug"]=$_GET["pcode"]=$_GET["edate"]=$_GET["toDate"]=null;	
		//automation for wages calculation
		$_GET["edate"]=$_GET["toDate"]=$edate;
		$_GET["pcode"]=$_POST[project];
		$_GET["debug"]=1;
		$_GET["start"]=0;
		$_GET["empID"]=$_POST[empId.$i];
		
// 		echo "$_GET[empID] && $_GET[edate] && $_GET[start] && $_GET[debug] && $_GET[pcode] && $_GET[toDate]";
		
		if($_GET["empID"] && $_GET["edate"] && isset($_GET["start"]) && $_GET["debug"] && $_GET["pcode"] && $_GET["toDate"])
			{
				// if(function_exists("getWagesAmount"))
					// getWagesAmount($edate,$edate,$loginProject);
// 				echo "<p>Wages has been calculated.</p>";
			}
} //wages calculation end
	
	
 }

 echo "Updating.....<br>wait please.........";
echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=attendance\">";

?>
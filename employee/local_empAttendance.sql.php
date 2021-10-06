<?
include("../includes/session.inc.php");
include("../includes/myFunction.php");
include("../includes/empFunction.inc.php");
include("../includes/config.inc.php");

$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);	

$format="Y-m-j";
$edat1=$edat;
$edat = formatDate($edat,$format);
//echo $edat;
$todat=todat();
$etime=0;
$xtime=0;
    

for($i=1;$i<$m;$i++){
	if(${ch.$i}){
	//if($action !="L" || ${empId.$i}!=""){
  if(isHoliday($edat)) $action="HP";	else $action="P";

	$sql="INSERT INTO attendance(`id` , `empId`, `edate` ,`action` , `stime` , `etime` , `todat` , `location` )
	VALUES ( '', '${empId.$i}', '$edat', '$action', '08:00:00','16:59:00','$todat','$project1' )";
	
	//echo $sql.'<br>';
	$sqlq1=mysqli_query($db, $sql);
	$ro=mysqli_affected_rows($db);
	//echo " ** $ro **";	
	
// 	$sql2 = "INSERT INTO `emput` ( `id` , `empId` ,`empType`,`designation`, `iow` , `siow` , `stime` , `etime` , `details` ,
// 	 `edate`,pcode ) VALUES ('', '${empId.$i}','H','${designation.$i}', '', '', '13:00', '13:59', 'Lunch', '$edat','$project1')";
// 	$sqlq2=mysqli_query($db, $sql2);
// 	echo $sql2.'<br>';exit;
		
		
	if($ro>0 AND ${remarks.$i}){
	$attId=mysql_insert_id();
	$sql12="INSERT INTO attremarks (attId,remarks) values('$attId','${remarks.$i}')";
	//echo "$sql12<br>";
	mysqli_query($db, $sql12);
	} //if($ro AND ${remarks.$i})

	if($ro=='-1'){
	$squ="select id from attendance where empId='${empId.$i}' AND edate='$edat'";
	$squq=mysqli_query($db, $squ);
	$squr=mysqli_fetch_array($squq);
	$attId=$squr[id];
	
	$sql1="UPDATE `attendance` set  action='$action',`stime`='08:00:00',`etime`='16:59:00',`location`='$project1' 
	WHERE `id`='$attId'";
	 //echo $sql1.'<br>';
	$sqlq=mysqli_query($db, $sql1);
	if(${remarks.$i}){
		$sql12="INSERT INTO attremarks (attId,remarks) values('$attId','${remarks.$i}')";
		//echo "$sql12<br>";
		mysqli_query($db, $sql12);
  }//if(${remarks.$i})
	$sql2 = "INSERT INTO `emput` ( `id` , `empId` ,`empType`,`designation`, `iow` , `siow` , `stime` , `etime` , `details` ,
	 `edate`,`pcode` ) VALUES ('', '${empId.$i}','H','${designation.$i}', '', '', '13:00', '13:59', 'Lunch', '$edat','$project1')";
	
	//echo $sql2.'<br>';
	$sqlq2=mysqli_query($db, $sql2);
	}//if($ro=='-1')
  }//if(${ch.$i})
  
  
  else  {if(isHoliday($edat)) $action="HA"; else $action="A";
				 
	if($action=="A"){
			//echo $sql1.'<br>';
			//$sqlq=mysqli_query($db, $sql1);
			$sql3="DELETE from `emput` where `empId`='${empId.$i}' AND `edate`='$edat' ";
			echo $sql3.'<br>';
			$sqlq2=mysqli_query($db, $sql3);
	}
               
 	$sql="INSERT INTO `attendance`(`id` , `empId`, `edate` ,`action` , `stime` , `etime` , `todat` , `location` )
	VALUES ( '', '${empId.$i}', '$edat', '$action', '08:00:00','16:59:00','$todat','$project1' )";
	
	//echo $sql.'<br>';
	$sqlq1=mysqli_query($db, $sql);
	$ro=mysqli_affected_rows($db);

		if($ro=='-1'){
			$squ="select id from `attendance` where `empId`='${empId.$i}' AND `edate`='$edat' and `action`<>'L'";
			$squq=mysqli_query($db, $squ);
			$squr=mysqli_fetch_array($squq);
			$attId=$squr[id];
			
			$sql1="UPDATE `attendance` set  `action`='$action',`stime`='00:00:00',`etime`='00:00:00',`location`='$project1'	WHERE `id`='$attId'";
			//echo $sql1.'<br>';
			$sqlq=mysqli_query($db, $sql1);
			$sql12="DELETE from  `attremarks` WHERE `attId`='$attId'";
			//echo "$sql12<br>";
			mysqli_query($db, $sql12);
			
			// echo $sql1.'<br>';
			//$sqlq=mysqli_query($db, $sql1);
			$sql3 = "DELETE from `emput` where `empId`='${empId.$i}' AND `edate`='$edat' ";
			//echo $sql2.'<br>';
			$sqlq2=mysqli_query($db, $sql3);
		}//if($ro=='-1')  
	}//else
  
 }//}

 //echo "<br>M:$m<br>";
// echo "<br>N:$n<br>"; 
echo "INFORMATION UPDATING................";
echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=local+emp+attendance&edat=$edat1&project=$project\">";
exit;
?>
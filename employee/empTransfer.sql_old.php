<? 
include("../session.inc.php");
include("../includes/myFunction.php");
include("../includes/config.inc.php");

$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	




$format="Y-m-j";
$reportDate = formatDate($reportDate,$format);
$stayDate = formatDate($stayDate,$format);	

//echo $reportDate11;
$todat=date("Y-m-d");	
	echo $_POST['n'];
for($i=1;$i<$n;$i++){
		if(${ech.$i})
		{ 
		echo ${ech.$i};
		
		  if(${plocation.$i}==$transferTo){
			$sql="UPDATE emptransfer set stayDate='$stayDate' WHERE tid=${tid.$i}";
			echo "<br>$sql<br>";
			$ssq=mysqli_query($db, $sql);
		  }else{
			$sqlquery="Insert INTO emptransfer (tid, empId, designation,transferFrom, transferTo, reportDate, stayDate,transferRef,status)".
			" VALUES ('', '${ech.$i}','${designation.$i}' ,'$transferFrom', '$transferTo', '$reportDate','$stayDate', '$transferRef','0')";
			echo $sqlquery.'<br>';
			$sql= mysqli_query($db, $sqlquery);	
			
			$sql="select * from emptransfer where empId=${ech.$i} AND status=2 ORDER BY tid DESC";
			echo "<br>$sql<br>";
			$sqlq=mysqli_query($db, $sql);
			$sqlr=mysqli_fetch_array($sqlq);
			
			$sql="UPDATE emptransfer set stayDate='$reportDate' WHERE tid=$sqlr[tid]";
			echo "<br>$sql<br>";
			$ssq=mysqli_query($db, $sql);
			}
		  }//if		  
 }
 echo "Transfer Will Take effect at 1 AM<br>";
 if($tid){
 echo "Transfer DELETED";
 mysqli_query($db, " DELETE from emptransfer where tid=$tid");
 }
//echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=employee+Transfer\">";
?>
	

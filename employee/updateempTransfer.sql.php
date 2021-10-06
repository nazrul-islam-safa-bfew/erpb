<? 
include("../includes/config.inc.php");
include("../includes/myFunction.php");

$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
//$format="Y-m-j";
//$reportDate = formatDate($reportDate,$format);	
$todat=todat();	
$sql="Select * FROM emptransfer WHERE reportDate<='$todat' AND status='0'";
echo '<br>'.$sql.'<br>';
$sqlq= mysqli_query($db, $sql);
while($re=mysqli_fetch_array($sqlq)){
$sql1="UPDATE emptransfer set status=2 WHERE tId=$re[tid]";
echo '<br>'.$sql1.'<br>';
$sqlq1 = mysqli_query($db, $sql1);

$sql2="UPDATE employee set location='$re[transferTo]' WHERE empId='$re[empId]'";
echo '<br>'.$sql2.'<br>';
$sqlq2 = mysqli_query($db, $sql2);

}
// echo "Transfer Will Take effect after 24 hours<br>";
// echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=employee+Transfer\">";

/*
$sql= "select * from employee";
echo $sql;
$sqlq=mysqli_query($db, $sql);
while($rr=mysqli_fetch_array($sqlq)){

$ss="Insert INTO emptransfer (tid, empId, transferFrom, transferTo, reportDate, transferRef,status)".
" VALUES ('', '$rr[empId]', '000', '$rr[location]', '$2006-01-01', '','0')";
echo $ss.'<br>';
$sq=mysqli_query($db, $ss);
}
*/
?>
	

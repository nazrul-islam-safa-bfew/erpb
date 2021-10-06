<? 
include("../includes/session.inc.php");
include("../includes/config.inc.php");
include("../includes/myFunction.php");

$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
/*$format="Y-m-j";
$edate = formatDate($reportDate,$format);	
$todat=date("Y-m-j");
*/
for($i=1;$i<$n;$i++){
	if(${etimeh.$i}>0 OR ${etimem.$i}>0){
		$hour=${etimeh.$i}.':'.${etimem.$i}.':00';
		$hour=abs(strtotime("00:00:00")-strtotime($hour))/3600;
		$sql="INSERT INTO emput (id,empId,iow,siow,hours,details,edate) values ('','$empId','${iow.$i}','${siow.$i}','$hour','${details.$i}','$edate')";
		//echo '<br>'.$sql.'<br>';
		$sqlq= mysqli_query($db, $sql);
	}//if
} //for
// echo "Transfer Will Take effect after 24 hours<br>";
 echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=employee+att+report\">";
?>
	

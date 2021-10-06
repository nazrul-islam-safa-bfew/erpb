<? 
include("../includes/session.inc.php");
include("../includes/myFunction.php");
include("../includes/empFunction.inc.php");
include("../includes/config.inc.php");

$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$format="Y-m-j";
$edat = formatDate($edat,$format);
//echo $edat;	
$todat=todat();	



 for($i=1;$i<$m;$i++){
 	if(${ch.$i}){ 
		if(isHoliday($edat)) $action="HP";
			else $action="P";
	
 $sql="INSERT INTO eqattendance(id, eqId,itemCode, edate, action, stime,etime, todat,location,posl )"."
  VALUES ('', '${eqId.$i}','${itemCode.$i}', '$edat', '$action', '08:00','16:59','$todat','$project','${posl.$i}' )";
  
//echo $sql.'<br>';
 $sqlq1=mysqli_query($db, $sql);

  }
 }


echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=eq+attendance\">";
?>

<?
include("../session.inc.php");
include("../includes/myFunction.php");

include("../includes/config.inc.php");

$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$format="Y-m-j";
$edat = formatDate($edat,$format);
$todat=date("Y-m-j");
	$etime=0;
	$xtime=0;

for($i=0;$i<=$n;$i++){
	if(${etime01.$i})$etime=${etime01.$i}.':'.${etime02.$i}.':00';
	if(${xtime01.$i}) $xtime=${xtime01.$i}.':'.${xtime02.$i}.':00';

		if(${lname.$i})
		{
		$sqlquery="Insert INTO labouratt (id, name, designation,rate,etime, xtime, edat, todat) VALUES ('', '${lname.$i}', '${designation.$i}', '${rate.$i}', '$etime', '$xtime', '$edat', '$todat')";
		 echo $sqlquery.'<br>';
		 $sql= mysqli_query($db, $sqlquery);
		 //$row=mysqli_affected_rows();

		  }//if
	$etime=0;
	$xtime=0;	 

 }//for


 echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=employee+att+report\">";
?>

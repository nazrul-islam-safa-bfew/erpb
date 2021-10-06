<? 
include("../session.inc.php");
include("../includes/myFunction.php");

include("../includes/config.inc.php");

$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$format="Y-m-j";
$edat = formatDate($edat,$format);
echo $edat;	
$todat=date("Y-m-j");	
	$etime=0;
	$xtime=0;	 

for($i=0;$i<$n;$i++){
echo "Time $i:".${etimeH.$i};
	if(${etimeH.$i}>0 or ${etimeM.$i}>0){
	  $etime=${etimeH.$i}.':'.${etimeM.$i}.':00';
      $xtime=${xtimeH.$i}.':'.${xtimeM.$i}.':00';

		$sqlquery="Insert INTO empatt (id, empId, etime, xtime,lunch, dinner, edat, todat,location) VALUES ('', '${empId.$i}', '$etime', '$xtime', '${ch1.$i}', '${ch2.$i}', '$edat', '$todat','$loginProject')";
		 echo $sqlquery.'<br>';
		 $sql= mysqli_query($db, $sqlquery);	
		 $row=mysqli_affected_rows();
		 if($row<1){
		  $sqlquery="UPDATE empatt SET xtime='$xtime', lunch='${ch1.$i}', dinner='${ch2.$i}' WHERE id=${id.$i}"; 
  		 $sql= mysqli_query($db, $sqlquery);	
 //		 echo $sqlquery.'<br>';
		  
		 }//if
	$etime=0;
	$xtime=0;	 
	}//if
 }
 
 echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=employee+att+report\">";
?>

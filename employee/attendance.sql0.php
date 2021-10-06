<? include("../includes/config.inc.php");
include("../includes/myFunction.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$todat=date('Y-m-j');
$format="Y-m-j";
$edate = formatDate($d,$format);

for($i=0;$i<$n;$i++){
	

	$t1=${half1action.$i};
	$t2=${half2action.$i};
	$t3=${action.$i};
	
	if($t3!=3){
      if($t3==1) $present=1;	   
	  if($t1 And $t3==1) {overtime+=.5;}	
      if($t2 And $t3==1) {overtime+=.5; }
	 
	  if($t3==2 AND $t1 AND $t1) {overtime=1.5;}
	  elseif($t3==2 AND $t1) {overtime=1;}	  
	  elseif($t3==2 AND $t2) {overtime=1;}	  	  
 

	 
	 $sql="INSERT INTO attendance(id, empId, edate, action, text, todat,half1, half2,overtime ) VALUES ('', '${empId.$i}', '$edate', '$present', '${text.$i}', '$todat', ${half1action.$i},${half2action.$i}, '$overtime' )";
	 echo $sql.'<br>';
	 //$sqlq=mysqli_query($db, $sql);
	 }
 } 
?>
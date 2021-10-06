<?php

session_start();
$supervisor=$_SESSION[loginUname];
//echo "<br>Supervisor Id:$supervisor<br>$loginDesignation";

error_reporting(1);

require('./includes/myFunction.php'); 
require('./includes/empFunction.inc.php'); 
require('./includes/eqFunction.inc.php'); 
require('./project/siteMaterialReport.f.php');
require('./project/siteDailyReport.f.php'); 



include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

?>
<?php
$edate=$ed=todat(); 
$sqlp = "SELECT * from `iow` where 
 '$ed' BETWEEN iowSdate AND iowCdate 
AND iowStatus <> 'Not Ready' ";


$sqlrunp= mysqli_query($db, $sqlp);
$btn_sql2=$sqlp;
	$i=0;
while($re=mysqli_fetch_array($sqlrunp)){
  $some_code=iowActualProgress($re[iowId],$re["iowProjectCode"],$ed,$re[iowQty],$re[iowUnit],0);
	$some_code=strip_tags($some_code);
  $some_code=str_replace(")","",$some_code);
  $some_code=explode("(",$some_code);
	
  $some_code[1]=str_replace(" ","",$some_code[1]);
	
	$formated_date=date("M d,Y",strtotime($edate));
  $some_note[1]=$formated_date.": R".$re["revisionNo"]." Planned Progress: ".iowProgress_return_val($edate,$re[iowId]).", Actual Progress: ".strip_tags($some_code[1])." (".$some_code[0].")";

	
	 $sqlp = "INSERT INTO iowdaily (iowId, edate, todat,supervisor,auto_save_info)".
		" values ('$re[iowId]','$edate','$edate','$supervisor','$some_note[1]')";
	$q=mysqli_query($db,$sqlp);
	$i++;
	echo mysqli_error($db);

}
echo "Total: ".$i;
?> 

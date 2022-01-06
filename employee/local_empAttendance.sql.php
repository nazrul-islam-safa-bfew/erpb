<?
include("../includes/session.inc.php");
include("../includes/myFunction.php");
include("../includes/empFunction.inc.php");
include("../includes/config.inc.php");

$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);	

$format="Y-m-j";
$edat1=$edat;
echo "ddd". $edat = formatDate($edat,$format);
//echo $edat;
$todat=todat();
$etime=0;
$xtime=0;

$dateFormat = $year."-".$month."-01";


	//if($action !="L" || ${empId.$i}!=""){
		
		
  //if(isHoliday($edat)) $action="HP";	else $action="P";
  echo "weekend".weekend($edat,'008');
  echo "holiday". isHoliday($edat);
  exit;

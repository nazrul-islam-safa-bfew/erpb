<?
session_start();
$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";

include($localPath."/includes/session.inc.php");
include($localPath."/includes/myFunction.php"); // some general function
include_once($localPath."/includes/myFunction1.php"); // some general function
include_once($localPath."/includes/eqFunction.inc.php"); // equipment function
require_once($localPath."/keys.php");

// include("../includes/session.inc.php");
// include_once("../includes/myFunction.php");
// include_once("../includes/myFunction1.php");
// include_once("../includes/eqFunction.inc.php");
// require_once("../keys.php");
//echo "<!----".$au."---->";
/*$time=mktime(0,0,0, date("m"),date("d"),date("y"));
$todat = date("Y-m-d",$time);
*/
$todat=todat();
//echo $todat;
?>
<html>

<head>
<SCRIPT language=JavaScript src="../js/shimul.js" type=text/JavaScript></SCRIPT>
<link href="../style/basestyles.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Language" content="en-us">
<meta name="author" content="<? echo $mauthor;?>">
<meta name="copyright" content="<? echo $tt;?>">
<meta name="keywords" content="<? echo $kword;?>">
<META NAME="description" CONTENT="<? echo $des;?>">

<title>BFEW :: employee utilization </title>

</head>
<body  topmargin="1" leftmargin="5" rightmargin="5" bgcolor="#FFFFFF" >

<table align="center" width="700" border="3" bgcolor="#FFFFFF"  bordercolor="CC9999" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td colspan="5" align="right" valign="top"><font class='englishhead'>equipment utilization report of <? echo myDate($edate);?></font></td>
</tr>
<tr>
 <th>From</th>
 <th>To</th> 
 <th>IOW Name</th>
 <th>SIOW Name</th>
</tr>
<? $t=eqExTime($eqId,$itemCode,$eqType,$edate);
      $eh= $t['eh'];
      $em= $t['em'];
      $xh= $t['xh'];
      $xm= $t['xm'];	  	  	  
  ?>
<tr bgcolor="#FFFFCC">
  <td align="center"><? echo "$eh:$em:00";?></td>
  <td align="center"><? echo "$xh:$xm:00";?></td>  
  <td ><? echo "Total Present";?></td>  
  <td ><? echo "";?></td>    
</tr>  
<? 
include("../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

session_start();
$loginProject = $_SESSION["loginProject"];	
	

//echo $sqlut = "SELECT * FROM equt WHERE eqId='$eqId' AND itemCode='$itemCode' AND edate='$edate' AND pcode='$loginProject' ORDER by stime ASC";
echo $sqlut = "SELECT * FROM equt WHERE eqId='$eqId' AND itemCode='$itemCode' AND edate='$edate' ORDER by stime ASC";
//echo $sqlut;
$sqlqut= mysqli_query($db, $sqlut);
$i=1;
 while($reut= mysqli_fetch_array($sqlqut))
{?>
<tr <? if($reut['iow']) echo "bgcolor=#FFFFFF"; else echo "bgcolor=#FFCCFF";?> >
  <td align="center"> <? echo $reut['stime']?> </td>
  <td align="center"> <? echo $reut['etime']?> </td>
  <td align="left"> <? 
  if($reut['iow']){
  echo '<font color=006600>'.iowCode($reut['iow']).'</font> ';
  echo iowName($reut['iow']);
  } else echo 'Work Break';?> </td>
  <td align="left"> <? 
  if($reut['siow']){
  echo '<font color=006600>'.viewsiowCode($reut['siow']).'</font> ';
  echo siowName($reut['siow']);
  }else echo $reut['details'];?> </td>
 </tr>
 <? $i++;}?>
</table>
<p align="center">
<? 



// function eq_dailywork($eqId,$itemCode,$d,$eqType,$pcode){
// 	$work=0;

//  //include("session.inc.php"); 
//  $localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
//  include($localPath."/includes/config.inc.php"); //datbase_connection
//  $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);	 

//  echo $sql1="SELECT  SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as total from  `equt`".
//  " where  eqId ='$eqId' AND itemCode='$itemCode'  AND edate ='$d' AND pcode=220 AND iow>='1' ";
// // echo $sql1;
//  $sqlQuery1=mysqli_query($db, $sql1);
//  $remainQty1=mysqli_fetch_array($sqlQuery1);
//  if($remainQty1['total']) 
//  $work= $remainQty1['total'];
//  return $work;
// }




	$dailyworkBreakt=eq_dailyworkBreak($eqId,$itemCode,$edate,'H',$loginProject);
	
	$toDaypresent=eq_toDaypresent($eqId,$itemCode,$edate,'H',$loginProject);
	
  $toDaypresent=$toDaypresent-$dailyworkBreakt;	
	
echo	$workt= eq_dailywork($eqId,$itemCode,$edate,'H',$loginProject);
if(date('D',strtotime($edate))=='Fri')
 $overtimet = $toDaypresent-(4*3600);
else 
	$overtimet = $toDaypresent-(8*3600);

	if($overtimet<0) $overtimet=0;
	$idlet=$toDaypresent-$workt;
	  if($idlet<0) $idlet=0;
?>
 Present: <?   echo sec2hms($toDaypresent/3600,$padHours=false).' Hrs.   ';?>;
 Worked: <?   $work= sec2hms($workt/3600,$padHours=false);   echo $work.' Hrs.    ';  ?>;
 Overtime: <?  $overtime=sec2hms($overtimet/3600,$padHours=false);  echo $overtime.' Hrs.   ';  ?>; 
 Idle: <?  $idle=sec2hms($idlet/3600,$padHours=false);  echo $idle.' Hrs.'; ?>
 </p>
</body>
</html>
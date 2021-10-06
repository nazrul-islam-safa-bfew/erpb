<?
error_reporting(0);

include_once("../includes/myFunction1.php");
include("../includes/config.inc.php");
include_once("../includes/myFunction.php");
include_once("../includes/empFunction.inc.php");
include_once("../includes/eqFunction.inc.php");
include_once("../includes/subFunction.inc.php");
include_once("../includes/matFunction.inc.php");

$todat=todat();
?>
<html>
<head>

<LINK href="../style/print.css" type=text/css rel=stylesheet>



<meta http-equiv="Content-Language" content="en-us">
<meta name="author" content="<? echo $mauthor;?>">
<meta name="copyright" content="<? echo $tt;?>">
<meta name="keywords" content="<? echo $kword;?>">
<META NAME="description" CONTENT="<? echo $des;?>">
<title>BFEW :: Print </title>
</head>
<body  topmargin="1" leftmargin="5" rightmargin="5" bgcolor="#FFFFFF" >
<a name="top"></a>
<table width="500" border="0"  align="center" cellpadding="5" cellspacing="5">
<tr>
 <th>Bangladesh Foundry and Engineering Works Ltd.</th>
</tr>
<tr>
 <th>Equipment Report of &nbsp;<? echo myProjectName($project);?>&nbsp; at &nbsp; <? echo $edat;?></th>
</tr>
</table>
<br>
<br>


<table align="center" width="98%" border="3"  bordercolor="CC9999" cellpadding="2" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#EEEEEE"> 
 <td align="right" colspan="5" ><font class='englishheadBlack'>equipment utilization</font></td>
</tr>
<tr>
  <th height="30" width="100">Equipment Id</th>
  <th >Equipment Name</th>  
  <th width="121" >at <? echo $edat;?></th>  
 <th width="288"  >Monthly total <br>till <? echo $edat;?></th>    
 <th width="260"  >Project total <br>till <? echo $edat;?></th>    
</tr>
<? $format="Y-m-j";
$edat1 = formatDate($edat,$format);
if($project=='') $project=$loginProject;
?>


<? 
//Head office employee

include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);


$sqlquery="SELECT eqattendance.* FROM eqattendance".
" where eqattendance.location='$project' AND eqattendance.edate='$edat1'".
" AND action in('P','HP') ORDER by itemCode ASC ";
//echo $sqlquery;
 $sql= mysql_query($sqlquery);
 $i=1;

 $month=date('m',strtotime($edat1));
$year=date('Y');
$from="$year-$month-01";

 while($re=mysql_fetch_array($sql)){
 ?>
 <tr <? if($i%2==0) echo "bgcolor=#EEEEEE";?> >
      <td width="100">	 <?  echo eqpId($re[eqId],$re[itemCode]); ?>   </td>
      <td width="151"><?  $temp=itemDes($re[itemCode]); echo $temp[des].', '.$temp[spc]; ?> 
		<?  $totalPresent = eqTotalPresentHr('2006-01-01',$edat1,$re[eqId],$re[itemCode],'H',$project);
	   echo "<p align=right>Worked : <font class='out'>$totalPresent </font>days</p>";
	   ?>	  
	  </td>  

	<td>
   <? 
	$dailyworkBreakt=eq_dailyworkBreak($re[eqId],$re[itemCode],$edat1,'H',$project);
	
	$toDaypresent=eq_toDaypresent($re[eqId],$re[itemCode],$edat1,'H',$project);
	
    $toDaypresent=$toDaypresent-$dailyworkBreakt;	
	
	$workt= eq_dailywork($re[eqId],$re[itemCode],$edat1,'H',$project);
	$overtimet = $toDaypresent-8*3600;
	if($overtimet<0) $overtimet=0;
	$idlet=$toDaypresent-$workt;
	  if($idlet<0) $idlet=0;
      
    ?>
	<? echo ' Present: '.sec2hms($toDaypresent/3600,$padHours=true).' hrs.';?><br>
	<? echo '  Worked: '.sec2hms($workt/3600,$padHours=true).' hrs.';?><br>
	<? echo ' Overtime: '.sec2hms($overtimet/3600,$padHours=true).' hrs.';?><br>	
    <? echo ' Idle '.sec2hms($idlet/3600,$padHours=true).' hrs.';?>
	</td>
	<td>	
<? 
$presentTotal=0;
$overtimeTotal=0;
$workedTotal=0;
$idleTotal=0;
$idleTotalp=0;
$overtimeTotalp=0;
$workedTotalp=0;

$sqlquery1="SELECT eqattendance.* FROM eqattendance".
" where eqattendance.location='$project'".
"AND eqattendance.edate BETWEEN '$from' AND '$edat1'".
" AND action in('P','HP')  AND eqattendance.eqId=$re[eqId]  AND eqattendance.itemCode='$re[itemCode]'";
//echo $sqlquery1;

 $sql1= mysql_query($sqlquery1);
 while($re1=mysql_fetch_array($sql1)){

  $dailyworkBreakt=eq_dailyworkBreak($re[eqId],$re[itemCode],$re1[edate],'H',$project);
	
	$toDaypresent=eq_toDaypresent($re[eqId],$re[itemCode],$re1[edate],'H',$project);
	
    $toDaypresent=$toDaypresent-$dailyworkBreakt;	
	
	$workt= eq_dailywork($re[eqId],$re[itemCode],$re1[edate],'H',$project);

if(date('D',strtotime($re1[edate]))=='Fri')
 $overtimet = $toDaypresent-(4*3600);
else 
	$overtimet = $toDaypresent-(8*3600);


	if($overtimet<0) $overtimet=0;
	$idlet=$toDaypresent-$workt;
	  if($idlet<0) $idlet=0;	  

$presentTotal=$presentTotal+$toDaypresent;   
$overtimeTotal=$overtimeTotal+$overtimet;
$workedTotal=$workedTotal+$workt;
$idleTotal=$idleTotal+$idlet; 

//echo "<br>date:$re1[edate]= Present:$toDaypresent--worked:$workt--overtime:$overtimet--idle:$idlet***presentTotal:$presentTotal **<br>";
$toDaypresent=0;
$overtimet=0;
$workt=0;
$idlet=0;

 }
?>	

	<? 
	if($presentTotal){
	$workedTotalp=number_format(($workedTotal*100)/($presentTotal));
	$overtimeTotalp=number_format(($overtimeTotal*100)/($presentTotal));
	$idleTotalp=number_format(($idleTotal*100)/($presentTotal));
}
	//echo "<br>presentTotal:$presentTotal--idleTotal:$idleTotal<br>";		
		
	$presentTotal=sec2hms($presentTotal/3600,$padHours=false);
	$overtimeTotal=sec2hms($overtimeTotal/3600,$padHours=false);
	$workedTotal=sec2hms($workedTotal/3600,$padHours=false);
	$idleTotal=sec2hms($idleTotal/3600,$padHours=false);
	//echo "<br>presentTotal:$presentTotal--idleTotal:$idleTotal<br>";		
	?>


	<? echo 'Present: '.$presentTotal.' hrs.';
	//   echo " (<font class=out>$presentTotalp %</font>) "; 
	?><br>	

	<? echo 'Worked: '.$workedTotal.' hrs.';
	   echo " (<font class=out>$workedTotalp %</font>) "; 
	?><br>	
	<? echo 'Overtime: '.$overtimeTotal.' hrs.';
	   echo " (<font class=out>$overtimeTotalp %</font>)"; 
	?> <br>
    <? echo 'Idle: '.$idleTotal.' hrs.';
	   echo " (<font class=out>$idleTotalp %</font>)"; 	
	?>
	</td>
	<td>	
<? 
$presentTotal=0;
$overtimeTotal=0;
$workedTotal=0;
$idleTotal=0;
$idleTotalp=0;
$overtimeTotalp=0;
$workedTotalp=0;

$sqlquery1="SELECT eqattendance.* FROM eqattendance".
" where eqattendance.location='$project'".
"AND eqattendance.edate <='$edat1'".
" AND action in('P','HP')  AND eqattendance.eqId=$re[eqId]  AND eqattendance.itemCode='$re[itemCode]'";
//echo $sqlquery1;

 $sql1= mysql_query($sqlquery1);
 while($re1=mysql_fetch_array($sql1)){

  $dailyworkBreakt=eq_dailyworkBreak($re[eqId],$re[itemCode],$re1[edate],'H',$project);
	
	$toDaypresent=eq_toDaypresent($re[eqId],$re[itemCode],$re1[edate],'H',$project);
	
    $toDaypresent=$toDaypresent-$dailyworkBreakt;	
	
	$workt= eq_dailywork($re[eqId],$re[itemCode],$re1[edate],'H',$project);

if(date('D',strtotime($re1[edate]))=='Fri')
 $overtimet = $toDaypresent-(4*3600);
else 
	$overtimet = $toDaypresent-(8*3600);


	if($overtimet<0) $overtimet=0;
	$idlet=$toDaypresent-$workt;
	  if($idlet<0) $idlet=0;	  

$presentTotal=$presentTotal+$toDaypresent;   
$overtimeTotal=$overtimeTotal+$overtimet;
$workedTotal=$workedTotal+$workt;
$idleTotal=$idleTotal+$idlet; 

//echo "<br>date:$re1[edate]= Present:$toDaypresent--worked:$workt--overtime:$overtimet--idle:$idlet***presentTotal:$presentTotal **<br>";
$toDaypresent=0;
$overtimet=0;
$workt=0;
$idlet=0;

 }
?>	

	<? 
	if($presentTotal){
	$workedTotalp=number_format(($workedTotal*100)/($presentTotal));
	$overtimeTotalp=number_format(($overtimeTotal*100)/($presentTotal));
	$idleTotalp=number_format(($idleTotal*100)/($presentTotal));
}
	//echo "<br>presentTotal:$presentTotal--idleTotal:$idleTotal<br>";		
		
	$presentTotal=sec2hms($presentTotal/3600,$padHours=false);
	$overtimeTotal=sec2hms($overtimeTotal/3600,$padHours=false);
	$workedTotal=sec2hms($workedTotal/3600,$padHours=false);
	$idleTotal=sec2hms($idleTotal/3600,$padHours=false);
	//echo "<br>presentTotal:$presentTotal--idleTotal:$idleTotal<br>";		
	?>


	<? echo 'Present: '.$presentTotal.' hrs.';
	//   echo " (<font class=out>$presentTotalp %</font>) "; 
	?><br>	

	<? echo 'Worked: '.$workedTotal.' hrs.';
	   echo " (<font class=out>$workedTotalp %</font>) "; 
	?><br>	
	<? echo 'Overtime: '.$overtimeTotal.' hrs.';
	   echo " (<font class=out>$overtimeTotalp %</font>)"; 
	?> <br>
    <? echo 'Idle: '.$idleTotal.' hrs.';
	   echo " (<font class=out>$idleTotalp %</font>)"; 	
	?>
	</td>

 </tr>
 <? $i++;
 
$overtimeTotal=0;
$workedTotal=0;
$idleTotal=0;

 } //while?>

<!-- -->

</table>
  <br>
  <br>
<? include('../bottom.php');?>
</body>

</html>

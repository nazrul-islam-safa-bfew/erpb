<? include_once("../includes/myFunction1.php");
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
 <th>Labour Report of &nbsp;<? echo myProjectName($project);?>&nbsp; at &nbsp; <? echo date('D',strtotime($edate)).'  '; echo mydate($edate); ?></th>
</tr>
</table>
<br>
<br>

<? $format="Y-m-j";
$edat1 = formatDate($edat,$format);
if($project=='') $project=$loginProject;
?>
<table align="center" width="98%" border="3"  bordercolor="CC9999" cellpadding="2" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#E4E4E4"> 
 <td align="right" colspan="5" ><font class='englishheadblack'>human utilization</font></td>
</tr>
<tr>
  <th height="30">Employee Id</th>
  <th>Employee Name</th>  
  <th >at <? echo $edat;?></th>  
  <th >Monthly total <br>till <? echo $edat;?></th>    
  <th>Project total <br>till <? echo $edat;?></th>    
</tr>

<? //local Employee
/*
include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);

 $sqlquery="SELECT * FROM emplocalatt where location='$project' AND edat<='$edat1'";
//echo $sqlquery;
 $sql= mysql_query($sqlquery);
 while($re=mysql_fetch_array($sql)){
 ?>
 <tr bgcolor="#FFFFdd">
      <td>	 <? echo local_empId($re[empId],$re[designation]); echo ', '.hrDesignation($re[designation]); ?>      </td>
   <td><? echo local_empName($re[empId]);?>  </td>  
   <? 

   $workedt=dailywork( $re[empId],$edat1,'L',$project);
   $worked=sec2hms($workedt/3600,$padHours=false);
   
   $overtimet=$workedt-(9*3600);
   if($overtimet<0) $overtimet=0;
   $overtime=sec2hms($overtimet/3600,$padHours=false);
   
   $idlet=(3600*8)-$workedt;
   
   if($idlet<0)  $idlet=0;
   $idle=sec2hms($idlet/3600,$padHours=false);

    ?>
	  <td> <? echo ' Overtime: '.$overtime;?><br>
	<? echo '  Worked: '.$worked;?><br>	
	Idle: <? echo $idle;?>
	</td>
	<td>	
<? 

$month=date('m',strtotime($edat1));
$year=date('Y');
$from="$year-$month-01";

$sqlquery1="SELECT * FROM emplocalatt".
" where emplocalatt.location='$project' AND emplocalatt.edate BETWEEN '$from' AND '$edat1'".
" AND emplocalatt.empId= $re[empId]";
//echo $sqlquery1;

 $sql1= mysql_query($sqlquery1);
 while($re1=mysql_fetch_array($sql1)){
    $worked=dailywork( $re[empId],$re1[edate],'H',$project);
   //$worked=sec2hms($workedt/3600,$padHours=false);   

   $overtimet=$workedt-(9*3600);
   if($overtimet<0) $overtimet=0;
   //$overtime=sec2hms($overtimet/3600,$padHours=false);
   
   $idle=(3600*8)-$worked;

   if($idle<0)  $idle=0;
   //$idle=sec2hms($idlet/3600,$padHours=false);
$overtimeTotal=$overtimeTotal+$overtime;
$workedTotal=$workedTotal+$worked;
$idleTotal=$idleTotal+$idle; 

//echo "<br>date:$re1[edate]= worked:$worked--overtime:$overtime--idle:$idle<br>";
 }
?>	
	<? 
	$workedTotalp=number_format(($workedTotal*100)/($totalPresent*8*3600));
	$overtimeTotalp=number_format(($overtimeTotal*100)/($totalPresent*8*3600));
	$idleTotalp=number_format(($idleTotal*100)/($totalPresent*8*3600));
	
	$overtimeTotal=sec2hms($overtimeTotal/3600,$padHours=false);
	$workedTotal=sec2hms($workedTotal/3600,$padHours=false);
	$idleTotal=sec2hms($idleTotal/3600,$padHours=false);		
	?>

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
$sqlquery1="SELECT * FROM emplocalatt".
" where emplocalatt.location='$project' AND emplocalatt.edate<='$edat1'".
" AND emplocalatt.empId= $re[empId]";
//echo $sqlquery1;

 $sql1= mysql_query($sqlquery1);
 while($re1=mysql_fetch_array($sql1)){
    $worked=dailywork( $re[empId],$re1[edate],'H',$project);
   //$worked=sec2hms($workedt/3600,$padHours=false);   

   $overtimet=$workedt-(9*3600);
   if($overtimet<0) $overtimet=0;
   //$overtime=sec2hms($overtimet/3600,$padHours=false);
   
   $idle=(3600*8)-$worked;

   if($idle<0)  $idle=0;
   //$idle=sec2hms($idlet/3600,$padHours=false);
$overtimeTotal=$overtimeTotal+$overtime;
$workedTotal=$workedTotal+$worked;
$idleTotal=$idleTotal+$idle; 

//echo "<br>date:$re1[edate]= worked:$worked--overtime:$overtime--idle:$idle<br>";
 }
?>	
	<? 
	$workedTotalp=number_format(($workedTotal*100)/($totalPresent*8*3600));
	$overtimeTotalp=number_format(($overtimeTotal*100)/($totalPresent*8*3600));
	$idleTotalp=number_format(($idleTotal*100)/($totalPresent*8*3600));
	
	$overtimeTotal=sec2hms($overtimeTotal/3600,$padHours=false);
	$workedTotal=sec2hms($workedTotal/3600,$padHours=false);
	$idleTotal=sec2hms($idleTotal/3600,$padHours=false);		
	?>

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
 <? } //while
 */
 ?>

<? 
//Head office employee

include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);


$sqlquery="SELECT DISTINCT attendance.empId,employee.designation FROM attendance,employee".
" where attendance.location='$project' AND attendance.edate<='$edat1'".
" AND action in('P','HP') AND attendance.empId=employee.empId".
" AND employee.salaryType LIKE 'Wages%' ORDER by designation,empId ASC";// limit 0,3";
//echo $sqlquery;

 $sql= mysql_query($sqlquery);
 $i=1;

 $month=date('m',strtotime($edat1));
$year=date('Y');
$from="$year-$month-01";

 while($re=mysql_fetch_array($sql)){


 ?>
 <tr <? if($i%2==0) echo "bgcolor=#EfEfEf";?> >
      <td>	 <? 
	  $designation =$re[designation];

	  echo empId($re[empId],$designation);
echo "<p align=right>";
	   echo hrDesignation($designation);
	   echo "</p>";
	    ?>      
	   </td>
      <td><? echo empName($re[empId]);?> <br>
	   <? 
	   $totalPresent = local_TotalPresentHr('2006-01-01',$edat1,$re[empId],'H',$project);

	   echo "<p align=right>Present: <font class='out'>$totalPresent </font>days</p>";?>
	  </td>  


	<td>
   <? 
   if(isPresent($re[empId],$edat1) OR isHPresent($re[empId],$edat1)){
   
   
   	$dailyworkBreakt=dailyworkBreak($re[empId],$edat1,'H',$project);
	
	$toDaypresent=toDaypresent($re[empId],$edat1,'H',$project);
	
    $toDaypresent=$toDaypresent-$dailyworkBreakt;	
	
	$workt= dailywork($re[empId],$edat1,'H',$project);

if(date('D',strtotime($edat1))=='Fri')
 $overtimet = $toDaypresent-(4*3600);
else 
	$overtimet = $toDaypresent-(8*3600);

//	$overtimet = $toDaypresent-8*3600;
	if($overtimet<0) $overtimet=0;
	$idlet=$toDaypresent-$workt;
	  if($idlet<0) $idlet=0;
	  }
	     else {
   $toDaypresent='';
   $workt='';
   $overtimet='';
   $idlet='';
   }


    ?>	
	<? echo 'Present: '.sec2hms($toDaypresent/3600,$padHours=false).' hrs.';?><br>
	<? echo 'Worked: '.sec2hms($workt/3600,$padHours=false).' hrs.';?><br>	
	<? echo 'Overtime: '.sec2hms($overtimet/3600,$padHours=false).' hrs.';?> <br>
    <? echo 'Idle: '.sec2hms($idlet/3600,$padHours=false).' hrs.';?>
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

$sqlquery1="SELECT * FROM attendance".
" where attendance.location='$project' ".
"AND attendance.edate BETWEEN '$from' AND '$edat1'".
" AND action in('P','HP') AND attendance.empId= $re[empId]";
//echo $sqlquery1;

 $sql1= mysql_query($sqlquery1);
 while($re1=mysql_fetch_array($sql1)){
 
   	$dailyworkBreakt=dailyworkBreak($re[empId],$re1[edate],'H',$project);
	
	$toDaypresent=toDaypresent($re[empId],$re1[edate],'H',$project);
	
    $toDaypresent=$toDaypresent-$dailyworkBreakt;	

//echo "<br>toDaypresent:$toDaypresent<br>";
	
	$workt= dailywork($re[empId],$re1[edate],'H',$project);
	
if(date('D',strtotime($re1[edate]))=='Fri')
 $overtimet = $toDaypresent-(4*3600);
else 
	$overtimet = $toDaypresent-(8*3600);

//	$overtimet = $toDaypresent-8*3600;
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


$sqlquery1="SELECT * FROM attendance".
" where attendance.location='$project' ".
"AND attendance.edate<='$edat1'".
" AND action in('P','HP') AND attendance.empId= $re[empId]";
//echo $sqlquery1;

 $sql1= mysql_query($sqlquery1);
 while($re1=mysql_fetch_array($sql1)){
 
   	$dailyworkBreakt=dailyworkBreak($re[empId],$re1[edate],'H',$project);
	
	$toDaypresent=toDaypresent($re[empId],$re1[edate],'H',$project);
	
    $toDaypresent=$toDaypresent-$dailyworkBreakt;	

//echo "<br>toDaypresent:$toDaypresent<br>";
	
	$workt= dailywork($re[empId],$re1[edate],'H',$project);
	
if(date('D',strtotime($re1[edate]))=='Fri')
 $overtimet = $toDaypresent-(4*3600);
else 
	$overtimet = $toDaypresent-(8*3600);

//	$overtimet = $toDaypresent-8*3600;
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
	$workedTotalp=number_format(($workedTotal*100)/($presentTotal));
	$overtimeTotalp=number_format(($overtimeTotal*100)/($presentTotal));
	$idleTotalp=number_format(($idleTotal*100)/($presentTotal));

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
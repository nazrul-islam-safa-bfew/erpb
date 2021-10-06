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
 <th>Equipment Report of &nbsp;<? echo myProjectName($project);?>&nbsp; at &nbsp;<? echo $edat;?></th>
</tr>
</table>
<br>
<br>

<table align="center" width="98%" border="3"  bordercolor="CC9999" cellpadding="2" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999"> 
 <td align="right" colspan="7" ><font class='englishhead'>equipment utilization</font></td>
</tr>
<? $format="Y-m-j";
$edat1 = formatDate($edat,$format);
if($project=='') $project=$loginProject;
?>
<?
$itemCode=explode('_',$itemCode);
for($k=0;$k<=sizeof($itemCode);$k++)
{
$itemCode1=$itemCode[$k];
 if($itemCode1){
 $perDayQtyTotal=0;
 $siowdmaPerDayTotal=0;
 $perDayQtyTotal0=0;
 $siowdmauptoTotal0=0;
 $perDayQtyTotal=0;
 $siowdmauptoTotal=0;
 $worktat=0;
 $workat=0;
 $normalDayAmountTotal=0;
 $mworkedgTotal=0;
 $workedgTotal=0;
 $normalDayAmountgTotalup=0;
 $regularAmountTotalat=0;
 $mpresentasReggAmountTotal=0;
 $toDaypresentat=0;
 $idletat=0;
 $overtimeAmountTotal=0;
 $presentgTotal=0;
 $overtimegAmountTotal=0;
 $mnormalDayAmountgTotalup=0;
$presentasReggAmountTotal=0; 
$presentasReggTotal=0;
$mpresentasReggTotal=0;
$midlegTotal=0;
$movertimegAmountTotal=0;
$idlegTotal=0;
$mpresentgTotal=0;
$overtimegTotal=0;
$tem=itemDes($itemCode1);
 ?>
<tr>
  <th><? echo $itemCode1.', '.$tem[des].', '.$tem[spc];?></th>
  <th colspan="2" >at <? echo $edat;?></th>  
  <th colspan="2" >Monthly Total till <? echo $edat;?></th>    
  <th colspan="2">Project Total till <? echo $edat;?></th>    
</tr>
<tr >
 <td align="left"><font color="#336666">Planned Consumption (Approved)</font></td>
 <td align="right"><?
$sqls = "SELECT * from `dma` WHERE dmaProjectCode='$project' AND dmaItemCode ='$itemCode1' ";
//echo $sqls;
$sql1=mysql_query($sqls); 
while($dmar=mysql_fetch_array($sql1)){
$siowDuration=siowDuration($dmar[dmasiow]);

$siowDaysRem=siowDaysRem($dmar[dmasiow],$edat1);
$siowDaysGan=siowDaysGan($dmar[dmasiow],$edat1);
if($siowDaysGan)
{ 
 if($siowDaysRem){
  $siowdmaPerDay =siowdmaPerDay($siowDuration,$dmar[dmaQty])*$siowDaysGan;

  $eqTotalWorkhrsiow= (eqTotalWorkhrsiow($itemCode,$edat1,$dmar[dmasiow])/3600);
  $remainQty=$siowdmaPerDay-$eqTotalWorkhrsiow;
  $perdayRemainQty= $remainQty/$siowDaysRem;
  }
  else {
  $siowdmaPerDay =$dmar[dmaQty]; 
     
  $eqTotalWorkhrsiow= (eqTotalWorkhrsiow($itemCode,$edat1,$dmar[dmasiow])/3600);
  

  $remainQty=$siowdmaPerDay-$eqTotalWorkhrsiow;
  $perdayRemainQty=$remainQty;
  }
  $perDayAmount=($perdayRemainQty)*($dmar[dmaRate]);  
}
else {$perDayAmount =0;$perdayRemainQty;}
$perDayQtyTotal = $perDayQtyTotal+$perdayRemainQty;
$siowdmaPerDayTotal=$siowdmaPerDayTotal+$perDayAmount;
$perdayRemainQty=0;
$perDayAmount=0;
 }//while
 ?>
<font color="#336666"> <? echo sec2hms($perDayQtyTotal,$padHours=false).' hrs.';?></font>
 </td>
 <td align="right"><font color="#336666">Tk. <? echo number_format($siowdmaPerDayTotal);?></font></td>
 <td align="right">
 
 <?
 $perDayQtyTotal=0;
 $siowdmaPerDayTotal=0;
 $perdayRemainQty=0;
 $perDayAmount=0;
 $siowDuration=0;
 $siowDaysRem=0;
 $siowDaysGan=0;
 $siowdmaPerDay=0; 
 $perDayQtyTotal=0;
$siowdmauptoTotal=0;
$perDayQtyTotal0=0;
$siowdmauptoTotal=0;
$sqls = "SELECT * from `dma` WHERE dmaProjectCode='$project' AND dmaItemCode ='$itemCode1' ";
//echo $sqls;
$sql1=mysql_query($sqls); 
while($dmar=mysql_fetch_array($sql1)){
$siowDuration=siowDuration($dmar[dmasiow]);

$siowDaysRem=siowDaysRem($dmar[dmasiow],$edat1);
$siowDaysGan=siowDaysGan($dmar[dmasiow],$edat1);

if($siowDaysGan)
{ 
 if($siowDaysRem){
  $siowdmaPerDay =siowdmaPerDay($siowDuration,$dmar[dmaQty])*$siowDaysGan;
  }
  else {  $siowdmaPerDay =$dmar[dmaQty];     }
  
  $perDayAmount=($siowdmaPerDay)*($dmar[dmaRate]);  
}
else {$perDayAmount =0;$siowdmaPerDay=0;}

$perDayQtyTotal = $perDayQtyTotal+$siowdmaPerDay;
$siowdmauptoTotal=$siowdmauptoTotal+$perDayAmount;
$perdayRemainQty=0;
$perDayAmount=0;
 }//while


 $perdayRemainQty=0;
 $perDayAmount=0;
 $siowDuration=0;
 $siowDaysRem=0;
 $siowDaysGan=0;
 $siowdmaPerDay=0; 


$yesterday  = mktime(0, 0, 0, date("m",strtotime($from))  , date("d",strtotime($from))-1, date("Y",strtotime($from)));
$from1=date("Y-m-d",$yesterday);


$sqls = "SELECT * from `dma` WHERE dmaProjectCode='$project' AND dmaItemCode ='$itemCode1' ";
//echo $sqls;
$sql1=mysql_query($sqls); 
while($dmar=mysql_fetch_array($sql1)){
$siowDuration=siowDuration($dmar[dmasiow]);

$siowDaysRem=siowDaysRem($dmar[dmasiow],$from1);
$siowDaysGan=siowDaysGan($dmar[dmasiow],$from1);

if($siowDaysGan)
{ 
 if($siowDaysRem){
  $siowdmaPerDay =siowdmaPerDay($siowDuration,$dmar[dmaQty])*$siowDaysGan;
  }
  else {
  $siowdmaPerDay =$dmar[dmaQty];      
  }
  $perDayAmount=($siowdmaPerDay)*($dmar[dmaRate]);  
}
else {$perDayAmount =0;$siowdmaPerDay=0;}

$perDayQtyTotal1 = $perDayQtyTotal1+$siowdmaPerDay;

$siowdmauptoTotal1=$siowdmauptoTotal1+$perDayAmount;
$siowdmaPerDay=0;
$perDayAmount=0;
 }//while
$perDayQtyTotal0=$perDayQtyTotal-$perDayQtyTotal1;
//echo "****$perDayQtyTotal-$perDayQtyTotal1;*****";
$siowdmauptoTotal0=$siowdmauptoTotal-$siowdmauptoTotal1;

 ?>
 <font color="#336666">
 <? echo sec2hms($perDayQtyTotal0,$padHours=false).' hrs.';
 $perDayQtyTotal=0;
 $perDayQtyTotal1=0;
 $perDayQtyTotal0=0;
 $siowdmauptoTotal=0;
 $siowdmauptoTotal1=0;
 ?></font>
 </td>

 <td align="right"><font color="#336666">Tk. <? echo number_format($siowdmauptoTotal0)?></font></td>
 <td align="right">
 <?
 $perDayQtyTotal=0;
 $siowdmaPerDayTotal=0;
 $perdayRemainQty=0;
 $perDayAmount=0;
 $siowDuration=0;
 $siowDaysRem=0;
 $siowDaysGan=0;
 $siowdmaPerDay=0; 
 $perDayQtyTotal=0;
$siowdmauptoTotal=0;

$sqls = "SELECT * from `dma` WHERE dmaProjectCode='$project' AND dmaItemCode ='$itemCode' ";
//echo $sqls;
$sql1=mysql_query($sqls); 
while($dmar=mysql_fetch_array($sql1)){
$siowDuration=siowDuration($dmar[dmasiow]);

$siowDaysRem=siowDaysRem($dmar[dmasiow],$edat1);
$siowDaysGan=siowDaysGan($dmar[dmasiow],$edat1);

if($siowDaysGan)
{ 
 if($siowDaysRem){
  $siowdmaPerDay =siowdmaPerDay($siowDuration,$dmar[dmaQty])*$siowDaysGan;
  }
  else {  $siowdmaPerDay =$dmar[dmaQty];  }
  
  $perDayAmount=($siowdmaPerDay)*($dmar[dmaRate]);  
}
else {$perDayAmount =0;$siowdmaPerDay=0;}

$perDayQtyTotal = $perDayQtyTotal+$siowdmaPerDay;
$siowdmauptoTotal=$siowdmauptoTotal+$perDayAmount;
$perdayRemainQty=0;
$perDayAmount=0;
 }//while
 
 ?>
 <font color="#336666">
 <? echo sec2hms($perDayQtyTotal,$padHours=false).' hrs.';?></font>
 </td>
 <td align="right"><font color="#336666">Tk. <? echo number_format($siowdmauptoTotal);?></font></td>

</tr>

<tr bgcolor="#FFFFCC">
 <td>Actual Consumption in Item Of Work</td>
 <td align="right"><? 
  $month=date('m',strtotime($edat1));
$year=date('Y');
$from="$year-$month-01";

 $sqlquery="SELECT eqattendance.* FROM eqattendance".
" where eqattendance.location='$project' AND eqattendance.edate='$edat1' AND itemCode='$itemCode1'".
" AND action in('P','HP') ORDER by itemCode ASC ";
//echo $sqlquery;
 $sql= mysql_query($sqlquery);
 $i=1;

 while($re=mysql_fetch_array($sql)){

	$dailyworkBreakt=eq_dailyworkBreak($re[eqId],$re[itemCode],$edat1,'H',$project);
	$dailyBreakDown=eq_dailyBreakDown($eqId,$itemCode,$edate1,$eqType,$loginProject);
	$toDaypresent=eq_toDaypresent($re[eqId],$re[itemCode],$edat1,'H',$project);
    $workt= eq_dailywork($re[eqId],$re[itemCode],$edat1,'H',$project);
	
    $toDaypresent=$toDaypresent-$dailyworkBreakt;	
	$toDaypresentat=$toDaypresentat+$toDaypresent;
	
	$workt=$workt-$dailyworkBreakt;
	$workat=$workat+$workt;
	if($workat<0)
	$workat=0;
	$overtimet = $toDaypresent-8*3600;
	if($overtimet<0) $overtimet=0;
	$overtimetat=$overtimetat+$overtimet;
	
	$idlet=$toDaypresent-$workt-$dailyBreakDown;
	  if($idlet<0) $idlet=0;
	$idletat=$idletat+$idlet; 
      
}

/*monthly start*/
 $sqlquery="SELECT eqattendance.* FROM eqattendance".
" where eqattendance.location='$project' AND eqattendance.edate  BETWEEN '$from' AND '$edat1' AND itemCode='$itemCode1'".
" AND action in('P','HP') ORDER by itemCode ASC ";
//echo $sqlquery;
 $sql= mysql_query($sqlquery);
 $i=1;


 while($re=mysql_fetch_array($sql)){

	$dailyworkBreakt=eq_dailyworkBreak($re[eqId],$re[itemCode],$edat1,'H',$project);
	
	$toDaypresent=eq_toDaypresent($re[eqId],$re[itemCode],$edat1,'H',$project);
	$dailyBreakDown=eq_dailyBreakDown($eqId,$itemCode,$edate1,$eqType,$loginProject);

    $toDaypresent=$toDaypresent-$dailyworkBreakt;	
	$mpresentgTotal=$mpresentgTotal+$toDaypresent;
	
	$workt= eq_dailywork($re[eqId],$re[itemCode],$edat1,'H',$project);
	$mworkedgTotal=$mworkedgTotal+$workt;
	if($mworkedgTotal<0)
	$mworkedgTotal=0;
	$overtimet = $toDaypresent-8*3600;
	if($overtimet<0) $overtimet=0;
	$movertimegTotal=$movertimegTotal+$overtimet;
	
	$idlet=$toDaypresent-$workt-$dailyBreakDown;
	  if($idlet<0) $idlet=0;
	$midlegTotal=$midlegTotal+$idlet; 

$mpresentasReggTotal=$mpresentasReggTotal+($toDaypresent-$overtimet);
      
}
/*monthly end*/

/* till todate start*/
 $sqlquery="SELECT eqattendance.* FROM eqattendance".
" where eqattendance.location='$project' AND eqattendance.edate  BETWEEN '$from' AND '$edat1' AND itemCode='$itemCode1'".
" AND action in('P','HP') ORDER by itemCode ASC ";
//echo $sqlquery;
 $sql= mysql_query($sqlquery);
 $i=1;


 while($re=mysql_fetch_array($sql)){

	$dailyworkBreakt=eq_dailyworkBreak($re[eqId],$re[itemCode],$edat1,'H',$project);
	
	$toDaypresent=eq_toDaypresent($re[eqId],$re[itemCode],$edat1,'H',$project);
	$dailyBreakDown=eq_dailyBreakDown($eqId,$itemCode,$edate1,$eqType,$loginProject);

    $toDaypresent=$toDaypresent-$dailyworkBreakt;	
	$presentgTotal=$presentgTotal+$toDaypresent;
	
	$workt= eq_dailywork($re[eqId],$re[itemCode],$edat1,'H',$project);
	$workedgTotal=$workedgTotal+$workt;
	if($workedgTotal<0)
	$workedgTotal=0;
	$overtimet = $toDaypresent-8*3600;

	if($overtimet<0) $overtimet=0;
	$overtimegTotal=$overtimegTotal+$overtimet;
	
	if($overtimet<0) $overtimet=0;
	$idlet=$toDaypresent-$workt-$dailyBreakDown;
	
	  if($idlet<0) $idlet=0;
	$idlegTotal=$idlegTotal+$idlet; 
		

$presentasReggTotal=$presentasReggTotal+($toDaypresent-$overtimet);
      
}
/* till todate end*/
/* rate*/
$sqls = "SELECT MAX(dmaRate) as rate from `dma` WHERE dmaProjectCode='$project' AND dmaItemCode ='$itemCode1' ";
//echo $sqls;
$sql1=mysql_query($sqls); 
$sqlr=mysql_fetch_array($sql1);
$rate=$sqlr[rate];
/*  */
$normalDayAmountTotal=($workat/3600)*$rate; 
$mnormalDayAmountgTotalup=($mworkedgTotal/3600)*$rate;
$normalDayAmountgTotalup=($workedgTotal/3600)*$rate;

  $work= sec2hms($workat/3600,$padHours=false);   echo $work.' Hrs.    '; ?></td>
 <td align="right">Tk. <? echo number_format($normalDayAmountTotal);?> </td> 
 <td align="right"><? echo sec2hms($mworkedgTotal/3600,$padHours=false).' hrs.';?></td>
 <td align="right">Tk. <? echo number_format($mnormalDayAmountgTotalup);?></td>
 <td align="right"><? echo sec2hms($workedgTotal/3600,$padHours=false).' hrs.';?></td>
 <td align="right">Tk. <? echo number_format($normalDayAmountgTotalup);?></td>

</tr>

<tr>
 <td align="right">Present as Regular</td>
 <td align="right">
 <? 
 $regularAmountTotalat=(($toDaypresentat-$overtimetat)/3600)*$rate;
 $mpresentasReggAmountTotal=($mpresentasReggTotal/3600)*$rate;
 $presentasReggAmountTotal=($presentasReggTotal/3600)*$rate;
 
 echo $present=sec2hms($toDaypresentat/3600,$padHours=false).' Hrs.';?></td>
 <td align="right">Tk. <? echo number_format($regularAmountTotalat); ?></td>
 <td align="right"><? echo sec2hms($mpresentasReggTotal/3600,$padHours=false).' hrs.';?></td>
 <td align="right">Tk. <? echo number_format($mpresentasReggAmountTotal);?></td> 
 <td align="right"><? echo sec2hms($presentasReggTotal/3600,$padHours=false).' hrs.';?></td>
 <td align="right">Tk. <? echo number_format($presentasReggAmountTotal);?></td> 
<? $mpresentasReggTotal=0;?>
</tr>
<tr>
 <td align="right">Present as Overtime</td>
 <td align="right"><? 
 $overtimeAmountTotal=($overtimetat/3600)*$rate;
 $movertimegAmountTotal=($movertimegTotal/3600)*$rate;
 $overtimegAmountTotal=($overtimegTotal/3600)*$rate;
 
 echo $overtime=sec2hms($overtimetat/3600,$padHours=false). ' Hrs.';?></td>
 <td align="right">Tk. <? echo number_format($overtimeAmountTotal);?> </td>
 <td align="right"><? echo sec2hms($movertimegTotal/3600,$padHours=false).' hrs.';?></td>
 <td align="right">Tk. <? echo number_format($movertimegAmountTotal)?></td> 
 <td align="right"><? echo sec2hms($overtimegTotal/3600,$padHours=false).' hrs.';?></td>
 <td align="right">Tk. <? echo number_format($overtimegAmountTotal)?></td> 
<? $movertimegTotal=0;$overtimetat=0;?>
</tr>

<tr bgcolor="#FFFFCC">
 <td >Total Present</td>
 <td align="right"><? 
 
  echo sec2hms($toDaypresentat/3600,$padHours=false).' hrs.';?></td>
 <td align="right">Tk. <? echo number_format($overtimeAmountTotal+$regularAmountTotalat);?> </td>
 <td align="right"> <?  echo sec2hms($mpresentgTotal/3600,$padHours=false).' hrs.';?> </td>
 <td align="right">Tk. <? echo number_format($mpresentasReggAmountTotal+$movertimegAmountTotal);?> </td>
 <td align="right"> <?  echo sec2hms($presentgTotal/3600,$padHours=false).' hrs.';?> </td>
 <td align="right">Tk. <? echo number_format($overtimegAmountTotal+$presentasReggAmountTotal);?> </td>

</tr>
<tr >
 <td align="center"><font class="out">IDLE</font></td>
 <td align="right"><font class="out"><? $idle=sec2hms($idletat/3600,$padHours=false);  echo $idle.' Hrs.   ';?></font></td>
 <td align="right"><font class="out">Tk. <? echo number_format((($overtimeAmountTotal+$regularAmountTotalat) -$normalDayAmountTotal));?> </font></td>
 <td align="right"><font class="out"><? echo sec2hms($midlegTotal/3600,$padHours=false).' hrs.';?></font></td>
 <td align="right"><font class="out">Tk. <? echo number_format((($movertimegAmountTotal+$mpresentasReggAmountTotal) -$mnormalDayAmountgTotalup));?> </font></td>
      <td align="right"><font class="out"><? echo sec2hms($idlegTotal/3600,$padHours=false).' hrs.';?></font></td>
 <td align="right"><font class="out">Tk. <? echo number_format((($overtimegAmountTotal+$presentasReggAmountTotal) -$normalDayAmountgTotalup));?> </font></td>

</tr>

<tr><td colspan="7" height="30"></td></tr>
<? }
}//designation
?>
</table>
  <br>
  <br>
<? include('../bottom.php');?>
</body>

</html>

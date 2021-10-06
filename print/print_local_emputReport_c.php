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

<table align="center" width="98%" border="3"  bordercolor="CC9999" cellpadding="2" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#EEEEEE"> 
 <td align="right" colspan="7" ><font class='englishheadBlack'>human utilization</font></td>
</tr>
<? $format="Y-m-j";
$edat1 = formatDate($edat,$format);

?>

<?
$designationall=explode('_',$designationall);
for($k=0;$k<=sizeof($designationall);$k++)
{

$designation=$designationall[$k];
$godesignation=$godesignation.'_'.$designation;
 if($designation){
 $perDayQtyTotal=0;
 $siowdmaPerDayTotal=0;
 $perDayQtyTotal0=0;
 $siowdmauptoTotal0=0;
 $perDayQtyTotal=0;
 $siowdmauptoTotal=0;
 $worktat=0;
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
 ?>
<tr>
  <th><? echo $designation.', '.hrDesignation($designation);?></th>
  <th colspan="2" >at <? echo $edat;?></th>  
  <th colspan="2" >Monthly Total till <? echo $edat;?></th>    
  <th colspan="2">Project Total till <? echo $edat;?></th>    
</tr>
    <? $sqlquery="SELECT DISTINCT attendance.empId,employee.designation,employee.salary,employee.allowance".
		" FROM attendance,employee".
" where attendance.location='$project' AND attendance.edate='$edat1'".
" AND action in('P','HP') AND attendance.empId=employee.empId".
" AND employee.designation='$designation' ORDER by designation,empId ASC";// limit 0,3";
//echo $sqlquery;

 $sql= mysql_query($sqlquery);
 $i=1;
 while($re=mysql_fetch_array($sql)){
 $toDaypresent=0;

	if(isPresent($re[empId],$edat1) OR isHPresent($re[empId],$edat1)){
	
		$dailyworkBreakt=dailyworkBreak($re[empId],$edat1,'H',$project);
		$toDaypresent=toDaypresent($re[empId],$edat1,'H',$project);

		$toDaypresent=$toDaypresent-$dailyworkBreakt;
        
		$normalDayRate= normalDayAmountSec($re[salary],$re[allowance],$edat1);

		$otRate = otRateSec($re[salary],$edat1);

		$toDaypresentat=$toDaypresentat+$toDaypresent;//total present hour
		
		
		$workt= dailywork($re[empId],$edat1,'H',$project);
		$worktat=$worktat+$workt; //total work Hour

if(date('D',strtotime($edat1))=='Fri'){
        if($workt>4*3600){
		$workafter8hour=$workt-(4*3600);
		$workin8hour=$workt-$workafter8hour;
		$otAmount=$workafter8hour*$otRate;
		}
		 else $workin8hour=$workt;
	    $normalDayAmount =$normalDayRate*$workin8hour;
}
        else{
			if($workt>8*3600){
			$workafter8hour=$workt-(8*3600);
			$workin8hour=$workt-$workafter8hour;
			$otAmount=$workafter8hour*$otRate;
			}
			 else $workin8hour=$workt;
			$normalDayAmount =$normalDayRate*$workin8hour;
		}
		$normalDayAmountTotal=$normalDayAmountTotal+$normalDayAmount+$otAmount; 
		$normalDayAmount=0;
		$otAmount=0;
		if(date('D',strtotime($edat1))=='Fri')
		$overtimet = $toDaypresent-(4*3600);
		else 
		$overtimet = $toDaypresent-(8*3600);
		
		if($overtimet<0) $overtimet=0;
		$overtimeAmount=$overtimet*$otRate;

		$overtimeAmountTotal=$overtimeAmountTotal+$overtimeAmount;

		$overtimetat=$overtimetat+$overtimet; //total over time
		$regularat =  $toDaypresent-$overtimet;
		$regularAmountat = $regularat*$normalDayRate;

		$regularAmountTotalat = $regularAmountTotalat+$regularAmountat;
		$regularAmountat=0;
		
		$idlet=$toDaypresent-$workt;

		if($idlet<0) $idlet=0;
		$idletat=$idletat+$idlet; //total idle Hour		
		} //is present
		else {
		$toDaypresent=0;
		$workt=0;
		$overtimet=0;
		$idlet=0;
		}$toDaypresent=0;
		}//while
		?>
<? 
$sqlquery="SELECT DISTINCT attendance.empId,employee.designation,employee.salary,employee.allowance FROM attendance,employee".
" where attendance.location='$project' AND attendance.edate<='$edat1'".
" AND action in('P','HP') AND attendance.empId=employee.empId".
" AND employee.designation='$designation' ORDER by designation,empId ASC";// limit 0,3";
//echo $sqlquery;

 $sql= mysql_query($sqlquery);

 while($re=mysql_fetch_array($sql)){
$presentasReg=0;
$presentTotal=0;
$overtimeTotal=0;
$workedTotal=0;
$idleTotal=0;

		$normalDayRate= normalDayAmountSec($re[salary],$re[allowance],$edat1);
		//echo "<br>normalRate:$normalDayAmount";
		$otRate = otRateSec($re[salary],$edat1);


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
	
	$workt= dailywork($re[empId],$re1[edate],'H',$project);

if(date('D',strtotime($re1[edate]))=='Fri'){
        if($workt>4*3600){
		$workafter8hour=$workt-(4*3600);
		$workin8hour=$workt-$workafter8hour;
		$otAmount=$workafter8hour*$otRate;
		}
		 else $workin8hour=$workt;
	    $normalDayAmount =$normalDayRate*$workin8hour;
}
        else{
			if($workt>8*3600){
			$workafter8hour=$workt-(8*3600);
			$workin8hour=$workt-$workafter8hour;
			$otAmount=$workafter8hour*$otRate;
			}
			 else $workin8hour=$workt;
			$normalDayAmount =$normalDayRate*$workin8hour;
		}

		$normalDayAmountTotalup=$normalDayAmountTotalup+$normalDayAmount+$otAmount; 
         $normalDayAmount=0; 
		 $otAmount=0;
	
if(date('D',strtotime($re1[edate]))=='Fri')
 $overtimet = $toDaypresent-(4*3600);
else 
	$overtimet = $toDaypresent-(8*3600);

	if($overtimet<0) $overtimet=0;
	$idlet=$toDaypresent-$workt;
	  if($idlet<0) $idlet=0;

$presentTotal=$presentTotal+$toDaypresent;   
$overtimeTotal=$overtimeTotal+$overtimet;
$presentasReg=$presentasReg+($toDaypresent-$overtimet);

$workedTotal=$workedTotal+$workt;
$idleTotal=$idleTotal+$idlet; 

$toDaypresent=0;
$overtimet=0;
$workt=0;
$idlet=0;

 }
?>	
 <?
$presentgTotal=$presentgTotal+$presentTotal; 
$presentasReggTotal=$presentasReggTotal+$presentasReg;
//if($presentasReg)
//echo " <br>$re[empId]=$presentasReg";
$presentasReggAmountTotal=$presentasReggAmountTotal+$presentasReg*$normalDayRate;

$overtimegTotal=$overtimegTotal+$overtimeTotal;
$overtimegAmountTotal=$overtimegAmountTotal+$overtimeTotal*$otRate;
$workedgTotal=$workedgTotal+$workedTotal;
$idlegTotal=$idlegTotal+$idleTotal;


$normalDayAmountgTotalup=$normalDayAmountgTotalup+$normalDayAmountTotalup;
$normalDayAmountTotalup=0;
$presentTotal=0;
$overtimeTotal=0;
$workedTotal=0;
$idleTotal=0;
$presentasReg=0;
$normalDayRate=0;
 } //while
 ?>
<? //till month--start

$month=date('m',strtotime($edat1));
$year=date('Y');
$from="$year-$month-01";

$sqlquery="SELECT DISTINCT attendance.empId,employee.designation,employee.salary,employee.allowance FROM attendance,employee".
" where attendance.location='$project' AND attendance.edate <='$edat1'".
" AND action in('P','HP') AND attendance.empId=employee.empId".
" AND employee.designation='$designation' ORDER by designation,empId ASC";// limit 0,3";
//echo $sqlquery;

 $sql= mysql_query($sqlquery);

 //echo "totalPresent:$totalPresent";
 $i=1;
 
 while($re=mysql_fetch_array($sql)){
$presentasReg=0;
$presentTotal=0;
$overtimeTotal=0;
$workedTotal=0;
$idleTotal=0;

		$normalDayRate= normalDayAmountSec($re[salary],$re[allowance],$edat1);
		//echo "<br>normalRate:$normalDayAmount";
		$otRate = otRateSec($re[salary],$edat1);


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

	$workt= dailywork($re[empId],$re1[edate],'H',$project);

if(date('D',strtotime($re1[edate]))=='Fri'){
        if($workt>4*3600){
		$workafter8hour=$workt-(4*3600);
		$workin8hour=$workt-$workafter8hour;
		$otAmount=$workafter8hour*$otRate;
		}
		 else $workin8hour=$workt;
	    $mnormalDayAmount =$normalDayRate*$workin8hour;
}
        else{
			if($workt>8*3600){
			$workafter8hour=$workt-(8*3600);
			$workin8hour=$workt-$workafter8hour;
			$otAmount=$workafter8hour*$otRate;
			}
			 else $workin8hour=$workt;
			$mnormalDayAmount =$normalDayRate*$workin8hour;
		}
		$mnormalDayAmountTotalup=$mnormalDayAmountTotalup+$mnormalDayAmount+$otAmount; 
         $normalDayAmount=0; 
		 $otAmount=0;
	
if(date('D',strtotime($re1[edate]))=='Fri')
 $overtimet = $toDaypresent-(4*3600);
else 
	$overtimet = $toDaypresent-(8*3600);

	if($overtimet<0) $overtimet=0;
	$idlet=$toDaypresent-$workt;
	  if($idlet<0) $idlet=0;

$mpresentTotal=$mpresentTotal+$toDaypresent;   
$movertimeTotal=$movertimeTotal+$overtimet;
$mpresentasReg=$mpresentasReg+($toDaypresent-$overtimet);

$mworkedTotal=$mworkedTotal+$workt;
$midleTotal=$midleTotal+$idlet; 

$toDaypresent=0;
$overtimet=0;
$workt=0;
$idlet=0;

 }
$mpresentgTotal=$mpresentgTotal+$mpresentTotal; 
$mpresentasReggTotal=$mpresentasReggTotal+$mpresentasReg;
$mpresentasReggAmountTotal=$mpresentasReggAmountTotal+$mpresentasReg*$normalDayRate;

$movertimegTotal=$movertimegTotal+$movertimeTotal;
$movertimegAmountTotal=$movertimegAmountTotal+$movertimeTotal*$otRate;
$mworkedgTotal=$mworkedgTotal+$mworkedTotal;
$midlegTotal=$midlegTotal+$midleTotal;


$mnormalDayAmountgTotalup=$mnormalDayAmountgTotalup+$mnormalDayAmountTotalup;
$mnormalDayAmountTotalup=0;
$mpresentTotal=0;
$movertimeTotal=0;
$mworkedTotal=0;
$midleTotal=0;
$mpresentasReg=0;
$mnormalDayRate=0;

 } //while
 ?>

<tr >
 <td align="left"><font color="#336666">Planned Consumption (Approved)</font></td>
 <td align="right"><?
$sqls = "SELECT * from `dma` WHERE dmaProjectCode='$project' AND dmaItemCode ='$designation' ";
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

  $empTotalWorkhrsiow= (empTotalWorkhrsiow($designation,$edat1,$dmar[dmasiow])/3600);
  $remainQty=$siowdmaPerDay-$empTotalWorkhrsiow;
  $perdayRemainQty= $remainQty/$siowDaysRem;
  }
  else {
  $siowdmaPerDay =$dmar[dmaQty]; 
     
  $empTotalWorkhrsiow= (empTotalWorkhrsiow($designation,$edat1,$dmar[dmasiow])/3600);
  

  $remainQty=$siowdmaPerDay-$empTotalWorkhrsiow;
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
$sqls = "SELECT * from `dma` WHERE dmaProjectCode='$project' AND dmaItemCode ='$designation' ";
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


$sqls = "SELECT * from `dma` WHERE dmaProjectCode='$project' AND dmaItemCode ='$designation' ";
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
$siowdmauptoTotal0=$siowdmauptoTotal-$siowdmauptoTotal1;

 ?>
 <font color="#336666">
 <? echo sec2hms($perDayQtyTotal0,$padHours=false).' hrs.';
 $perDayQtyTotal=0;
 $perDayQtyTotal1=0;
 $perDayQtyTotal0=0;
 $siowdmauptoTotal=0;
 $siowdmauptoTotal1=0
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

$sqls = "SELECT * from `dma` WHERE dmaProjectCode='$project' AND dmaItemCode ='$designation' ";
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
 <td align="right"><? echo sec2hms($worktat/3600,$padHours=false).' hrs.';?></td>
 <td align="right">Tk. <? echo number_format($normalDayAmountTotal);?> </td> 
 <td align="right"><? echo sec2hms($mworkedgTotal/3600,$padHours=false).' hrs.';?></td>
 <td align="right">Tk. <? echo number_format($mnormalDayAmountgTotalup);?></td>
 <td align="right"><? echo sec2hms($workedgTotal/3600,$padHours=false).' hrs.';?></td>
 <td align="right">Tk. <? echo number_format($normalDayAmountgTotalup);?></td>

</tr>

<tr>
 <td align="right">Present as Regular</td>
 <td align="right">
 <?  echo sec2hms(($toDaypresentat-$overtimetat)/3600,$padHours=false).' hrs.';?></td>
 <td align="right">Tk. <? echo number_format($regularAmountTotalat); ?></td>
 <td align="right"><? echo sec2hms($mpresentasReggTotal/3600,$padHours=false).' hrs.';?></td>
 <td align="right">Tk. <? echo number_format($mpresentasReggAmountTotal);?></td> 
 <td align="right"><? echo sec2hms($presentasReggTotal/3600,$padHours=false).' hrs.';?></td>
 <td align="right">Tk. <? echo number_format($presentasReggAmountTotal);?></td> 
<? $mpresentasReggTotal=0;?>
</tr>
<tr>
 <td align="right">Present as Overtime</td>
 <td align="right"><? echo sec2hms($overtimetat/3600,$padHours=false).' hrs.';?></td>
 <td align="right">Tk. <? echo number_format($overtimeAmountTotal);?> </td>
 <td align="right"><? echo sec2hms($movertimegTotal/3600,$padHours=false).' hrs.';?></td>
 <td align="right">Tk. <? echo number_format($movertimegAmountTotal)?></td> 
 <td align="right"><? echo sec2hms($overtimegTotal/3600,$padHours=false).' hrs.';?></td>
 <td align="right">Tk. <? echo number_format($overtimegAmountTotal)?></td> 
<? $movertimegTotal=0;$overtimetat=0;?>
</tr>

<tr bgcolor="#FFFFCC">
 <td >Total Present</td>
 <td align="right"> <?  echo sec2hms($toDaypresentat/3600,$padHours=false).' hrs.';?> </td>
 <td align="right">Tk. <? echo number_format($overtimeAmountTotal+$regularAmountTotalat);?> </td>
 <td align="right"> <?  echo sec2hms($mpresentgTotal/3600,$padHours=false).' hrs.';?> </td>
 <td align="right">Tk. <? echo number_format($mpresentasReggAmountTotal+$movertimegAmountTotal);?> </td>
 <td align="right"> <?  echo sec2hms($presentgTotal/3600,$padHours=false).' hrs.';?> </td>
 <td align="right">Tk. <? echo number_format($overtimegAmountTotal+$presentasReggAmountTotal);?> </td>

</tr>
<tr >
 <td align="center"><font class="out">IDLE</font></td>
 <td align="right"><font class="out"><? echo sec2hms($idletat/3600,$padHours=false).' hrs.';?></font></td>
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
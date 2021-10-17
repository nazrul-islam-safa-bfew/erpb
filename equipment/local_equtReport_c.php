<? 
$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
include($localPath."/includes/config.inc.php"); //datbase_connection
//include($localPath."/includes/myFunction.php"); // some general function
include_once($localPath."/includes/myFunction1.php"); // some general function
include_once($localPath."/includes/empFunction.inc.php"); //manpower function
include_once($localPath."/includes/eqFunction.inc.php"); // equipment function
include_once($localPath."/includes/subFunction.inc.php"); // sub contracts function
include_once($localPath."/includes/matFunction.inc.php"); // material function
$todat=todat();

// include_once("../includes/myFunction1.php");
// include("../includes/config.inc.php");
// include_once("../includes/myFunction.php");
// include_once("../includes/empFunction.inc.php");
// include_once("../includes/eqFunction.inc.php");
// include_once("../includes/subFunction.inc.php");
// include_once("../includes/matFunction.inc.php");

//$todat=todat();
?>

<? if($loginProject=='000' || $loginProject=='004'){?>
<form name="pro" method="post" >
<select name="project" onChange="location.href='index.php?keyword=local+eq+ut+report+c&project='+pro.project.options[document.pro.project.selectedIndex].value";>
<option value="">Select Project</option>
<?
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sql="select * from project order by pcode";
$sqlq=mysqli_query($db, $sql);
while($sqlr=mysqli_fetch_array($sqlq)){
echo "<option value=$sqlr[pcode]";
if($project==$sqlr[pcode]) echo " SELECTED ";
 echo ">";
echo "$sqlr[pcode]--$sqlr[pname]</option>";
}
?>
</select>
</form>
<? } //loginProject?>
<br>
<br>
<? if($loginDesignation!='Site Equipment Co-ordinator'){?>
<table width="90%" align="center">
	
		<tr>
<td><input type="radio" onClick="location.href='./index.php?keyword=local+eq+ut+report+b&project=<?php echo $project; ?>&edat=<?php echo $edat; ?>'" >Details by date</td>
<td><input type="radio" onClick="location.href='./index.php?keyword=local+eq+ut+report+dd&project=<?php echo $project; ?>&edat=<?php echo $edat; ?>'">Uptodate Summery</td>
<!-- <td><input type="radio" onClick="location.href='./index.php?keyword=local+eq+ut+report+d&project=<?php echo $project; ?>&edat=<?php echo $edat; ?>'">Details by Equipment</td> -->
<td><input type="radio" checked>Summary by Equipment Group</td>
</tr>
	
</table>
<? }?>
	<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>

<? $format="Y-m-j";
$edat1 = formatDate($edat,$format);

$month=date('m',strtotime($edat1));
$year=date('Y');
$from="$year-$month-01";

if($project=='') $project=$loginProject;
?>
<form name="att" action="./index.php?keyword=local+eq+ut+report+c&project=<? echo $project;?>" method="post">

<table align="center" width="600" border="3"  bgcolor="#CCCCCC" cellpadding="2" cellspacing="0" style="border-collapse:collapse">
<tr>	
   <td width=250>Group</td>
      <td >
	  
<select name='itemCode[]' size='3' multiple id="equipmentsCollection">
<option value="" onClick="$(document).ready(function(){$('#equipmentsCollection').find('option').each(function(){$(this).prop('selected',true);});});">All Equipment</option>
<? 
include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT DISTINCT itemlist.itemCode,itemlist.itemDes,itemlist.itemSpec  from".
" eqattendance,`itemlist` Where itemlist.itemCode >= '50-00-000' AND itemlist.itemCode < '70-00-000'".
" AND itemlist.itemCode=eqattendance.itemCode AND location='$project' ORDER by itemlist.itemCode,eqId ASC";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

 while($typel= mysqli_fetch_array($sqlrunp))
{

 echo "<option value='".$typel[itemCode]."'";
 echo ">".$typel[itemCode]."--$typel[itemDes]--$typel[itemSpec]</option>  ";
 }
 ?>
</select>
  <? //echo $eqresult[designation];?>
      </td>
</tr>

<tr> 
<td>Select Date</td>
<td align="left">
	<SCRIPT LANGUAGE="JavaScript">
	var now = new Date(); 
	var cal = new CalendarPopup("testdiv1");
    	//cal.showNavigationDropdowns();
		cal.setWeekStartDay(6); // week is Monday - Sunday
		//cal.addDisabledDates(null,formatDate(now,"yyyy-MM-dd")); 
		cal.setCssPrefix("TEST");		
		cal.offsetX = 0;
		cal.offsetY = 0;
	</SCRIPT>
      <input type="text" maxlength="10" name="edat" value="<? echo $edat;?>"> <a id="anchor" href="#"
   onClick="cal.select(document.forms['att'].edat,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
      <input type="submit" name="go" value="Go" >
	  </td> 	  
</tr>
</table>
<br>
<br>
<table align="center" width="98%" border="3"  bordercolor="CC9999" cellpadding="2" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999"> 
 <td align="right" colspan="7" ><font class='englishhead'>equipment utilization</font></td>
</tr>

<?
if(sizeof($itemCode)>0) //if any of them has been selected.
for($k=0;$k<=sizeof($itemCode);$k++)
{

$itemCode1=$itemCode[$k];
$goitemCode=$goitemCode.'_'.$itemCode1;
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

$totalDay=0;
$totalMonth=0;
$totalProject=0;
$tem=itemDes($itemCode1);
 ?>
<tr>
  <th><? echo $itemCode1.', '.$tem[des].', '.$tem[spc];?></th>
  <th colspan="2" >at <? echo $edat;?></th>  
  <th colspan="2" >Monthly Total till <? echo $edat;?></th>    
  <th colspan="2">Project Total till <? echo $edat;?></th>    
</tr>
<tr>
 <td align="left"><font color="#336666">Planned Consumption (Approved)</font></td>
 <td align="right"><?
$sqls = "SELECT * from `dma` WHERE dmaProjectCode='$project' AND dmaItemCode ='$itemCode1' ";
//echo $sqls;
$sql1=mysqli_query($db, $sqls); 
while($dmar=mysqli_fetch_array($sql1)){
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
   <font color="#336666"> <? echo sec2hms($perDayQtyTotal,$padHours=false).' hrs.';?></font></td>
 <td align="right"><font color="#336666">Tk. <? echo number_format($siowdmaPerDayTotal);?></font></td>
 <td align="right"><?
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
$sql1=mysqli_query($db, $sqls); 
while($dmar=mysqli_fetch_array($sql1)){
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
$sql1=mysqli_query($db, $sqls); 
while($dmar=mysqli_fetch_array($sql1)){
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
   <font color="#336666"> <? echo sec2hms($perDayQtyTotal0,$padHours=false).' hrs.';
 $perDayQtyTotal=0;
 $perDayQtyTotal1=0;
 $perDayQtyTotal0=0;
 $siowdmauptoTotal=0;
 $siowdmauptoTotal1=0;
 ?></font></td>

 <td align="right"><font color="#336666">Tk.<? echo number_format($siowdmauptoTotal0)?> </font></td>
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

$sqls = "SELECT * from `dma` WHERE dmaProjectCode='$project' AND dmaItemCode ='$itemCode1' ";
//echo $sqls;
$sql1=mysqli_query($db, $sqls); 
while($dmar=mysqli_fetch_array($sql1)){
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
   <font color="#336666"> <? echo sec2hms($perDayQtyTotal,$padHours=false).' hrs.';?></font></td>
 <td align="right"><font color="#336666">Tk.<? echo number_format($siowdmauptoTotal);?> </font></td>

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
 $sql= mysqli_query($db, $sqlquery);
 $i=1;

 while($re=mysqli_fetch_array($sql)){

	$dailyworkBreakt=eq_dailyworkBreak($re[eqId],$re[itemCode],$edat1,'H',$project);
	$dailyBreakDown=eq_dailyBreakDown($eqId,$itemCode,$edate1,$eqType,$loginProject);

	$toDaypresent=eq_toDaypresent($re[eqId],$re[itemCode],$edat1,'H',$project);
	
    $toDaypresent=$toDaypresent-$dailyworkBreakt;	
	$toDaypresentat=$toDaypresentat+$toDaypresent;
	
	$workt= eq_dailywork($re[eqId],$re[itemCode],$edat1,'H',$project);
	$workt= eq_dailywork($re[eqId],$re[itemCode],$edat1,'H',$project);
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
 $sql= mysqli_query($db, $sqlquery);
 $i=1;


 while($re=mysqli_fetch_array($sql)){

	$dailyworkBreakt=eq_dailyworkBreak($re[eqId],$re[itemCode],$re[edate],'H',$project);
	
	$toDaypresent=eq_toDaypresent($re[eqId],$re[itemCode],$re[edate],'H',$project);
	
    $toDaypresent=$toDaypresent-$dailyworkBreakt;	
	$mpresentgTotal=$mpresentgTotal+$toDaypresent;
	
	$workt= eq_dailywork($re[eqId],$re[itemCode],$re[edate],'H',$project)-$dailyworkBreakt;
//	$workt= eq_dailywork($re[eqId],$re[itemCode],$edat1,'H',$project)-$dailyworkBreakt;
	$mworkedgTotal=$mworkedgTotal+$workt;
	if($mworkedgTotal<0)
	$mworkedgTotal=0;
	
	$overtimet = $toDaypresent-8*3600;
	if($overtimet<0) $overtimet=0;
	$movertimegTotal=$movertimegTotal+$overtimet;
	
	$idlet=$toDaypresent-$workt;
	  if($idlet<0) $idlet=0;
	$midlegTotal=$midlegTotal+$idlet; 
	
$mpresentasReggTotal=$mpresentasReggTotal+($toDaypresent-$overtimet);
      
}
/*monthly end*/

/* till todate start*/
 $sqlquery="SELECT eqattendance.* FROM eqattendance".
" where eqattendance.location='$project' AND eqattendance.edate BETWEEN '2013-01-01' AND '$edat1' AND itemCode='$itemCode1'".
" AND action in('P','HP') ORDER by itemCode ASC ";
//echo $sqlquery;
 $sql= mysqli_query($db, $sqlquery);
 $i=1;


 while($re=mysqli_fetch_array($sql)){

	$dailyworkBreakt=eq_dailyworkBreak($re[eqId],$re[itemCode],$re[edate],'H',$project);
	
	$toDaypresent=eq_toDaypresent($re[eqId],$re[itemCode],$re[edate],'H',$project);
	
    $toDaypresent=$toDaypresent-$dailyworkBreakt;	
	$presentgTotal=$presentgTotal+$toDaypresent;
	
	$workt= eq_dailywork($re[eqId],$re[itemCode],$re[edate],'H',$project)-$dailyworkBreakt;
//	$workt= eq_dailywork($re[eqId],$re[itemCode],$edat1,'H',$project)-$dailyworkBreakt;
	$workedgTotal=$workedgTotal+$workt;
	if($workedgTotal<0)
	$workedgTotal=0;
	
	$overtimet = $toDaypresent-8*3600;
	if($overtimet<0) $overtimet=0;
	$overtimegTotal=$overtimegTotal+$overtimet;
	
	$idlet=$toDaypresent-$workt;
	  if($idlet<0) $idlet=0;
	$idlegTotal=$idlegTotal+$idlet; 
	
$presentasReggTotal=$presentasReggTotal+($toDaypresent-$overtimet);
      
}
/* till todate end*/
/* rate*/
$sqls = "SELECT MAX(dmaRate) as rate from `dma` WHERE dmaProjectCode='$project' AND dmaItemCode ='$itemCode1' ";
//echo $sqls;
$sql1=mysqli_query($db, $sqls); 
$sqlr=mysqli_fetch_array($sql1);
$rate=$sqlr[rate];
/*  */
$normalDayAmountTotal=($workat/3600)*$rate; 
$mnormalDayAmountgTotalup=($mworkedgTotal/3600)*$rate;
$normalDayAmountgTotalup=($workedgTotal/3600)*$rate;

 echo sec2hms($workat/3600,$padHours=false).' hrs.';?></td>
 <td align="right">Tk.<? echo number_format($normalDayAmountTotal); $totalDay=$totalDay+$normalDayAmountTotal;?> </td> 
 <td align="right"><? echo sec2hms($mworkedgTotal/3600,$padHours=false).' hrs.';?></td>
 <td align="right">Tk.<? echo number_format($mnormalDayAmountgTotalup); $totalMonth=$totalMonth+$mnormalDayAmountgTotalup;?> </td>
 <td align="right"><? echo sec2hms($workedgTotal/3600,$padHours=false).' hrs.';?></td>
 <td align="right">Tk.<? echo number_format($normalDayAmountgTotalup); $totalProject=$totalProject+$normalDayAmountgTotalup;?></td>
</tr>

<tr>
 <td align="right">Present as Regular</td>
 <td align="right"><? 
 $regularAmountTotalat=(($toDaypresentat-$overtimetat)/3600)*$rate;

 $presentasReggAmountTotal=($presentasReggTotal/3600)*$rate;
 
  echo sec2hms($toDaypresentat/3600,$padHours=false).' hrs.';?></td>
 <td align="right">Tk.<? echo number_format($regularAmountTotalat); ?></td>
 <td align="right"><? echo sec2hms($mpresentasReggTotal/3600,$padHours=false).' hrs.';?></td>

 <td align="right"><?  $mpresentasReggAmountTotal=($mpresentasReggTotal/3600)*$rate;?>Tk.<? echo number_format($mpresentasReggAmountTotal);?></td> 
 <td align="right"><? echo sec2hms($presentasReggTotal/3600,$padHours=false).' hrs.';?></td>
 <td align="right">Tk.<? echo number_format($presentasReggAmountTotal);?></td> 
</tr>
<tr>
 <td align="right">Present as Overtime</td>
 <td align="right"><? 
 $overtimeAmountTotal=($overtimetat/3600)*$rate;
 $movertimegAmountTotal=($movertimegTotal/3600)*$rate;
 $overtimegAmountTotal=($overtimegTotal/3600)*$rate;
 
 echo sec2hms($overtimetat/3600,$padHours=false).' hrs.';?></td>
 <td align="right">Tk.<? echo number_format($overtimeAmountTotal);?></td>
 <td align="right"><? echo sec2hms($movertimegTotal/3600,$padHours=false).' hrs.';?></td>
 <td align="right">Tk.<? echo number_format($movertimegAmountTotal)?></td> 
 <td align="right"><? echo sec2hms($overtimegTotal/3600,$padHours=false).' hrs.';?></td>
 <td align="right">Tk.<? echo number_format($overtimegAmountTotal)?></td> 
 <? $movertimegTotal=0;$overtimetat=0;?>
</tr> 

<tr bgcolor="#FFFFCC">
 <td >Total Present</td>
 <td align="right"><? 
 
  echo sec2hms($toDaypresentat/3600,$padHours=false).' hrs.';?></td>
 <td align="right">Tk.<? echo number_format($overtimeAmountTotal+$regularAmountTotalat);?></td>
 <td align="right"><?  echo sec2hms($mpresentgTotal/3600,$padHours=false).' hrs.';?></td>
 <td align="right">Tk.<? echo number_format($mpresentasReggAmountTotal+$movertimegAmountTotal);?></td> 
 <td align="right"><?  echo sec2hms($presentgTotal/3600,$padHours=false).' hrs.';?></td>
 <td align="right">Tk.<? echo number_format($overtimegAmountTotal+$presentasReggAmountTotal);?></td> 
</tr>
<tr >
 <td align="center"><font class="out">IDLE</font></td>
 <td align="right"><font class="out"><? echo sec2hms($idletat/3600,$padHours=false).' hrs.';?></font></td>
 <td align="right">Tk.<font class="out"><? echo number_format((($overtimeAmountTotal+$regularAmountTotalat) -$normalDayAmountTotal));?></font></td>
 <td align="right"><font class="out"><? echo sec2hms($midlegTotal/3600,$padHours=false).' hrs.';?></font></td>
 <td align="right">Tk.<font class="out"><? echo number_format((($movertimegAmountTotal+$mpresentasReggAmountTotal) -$mnormalDayAmountgTotalup));?></font></td> 
 <td align="right"><font class="out"><? echo sec2hms($idlegTotal/3600,$padHours=false).' hrs.';?></font></td>
 <td align="right">Tk.<font class="out"><? echo number_format((($overtimegAmountTotal+$presentasReggAmountTotal) -$normalDayAmountgTotalup));?></font></td> 
</tr>

<tr><td colspan="7" height="30"></td></tr>
<? }
}//designation
?>
</table>
</form>
<?php // print "Day Total: ".$totalDay." Month Total: ".$totalMonth." Project Total:".$totalProject." of Actual Consumption"; ?>
<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
<a href="./print/print_local_equtReport_c.php?project=<? echo $project;?>&edat=<? echo $edat;?>&itemCode=<? echo $goitemCode;?>" target="_blank"><br />
Print</a>
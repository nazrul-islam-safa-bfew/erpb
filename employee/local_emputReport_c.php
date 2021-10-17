<? 
error_reporting(E_ERROR | E_PARSE);
if($loginProject=='000'){?>
<form name="pro" method="post" >
<select name="project" onChange="location.href='index.php?keyword=local+emp+ut+report+c&project='+pro.project.options[document.pro.project.selectedIndex].value";>
<option value="">Select Project</option>
<?
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sql="select * from project order by pcode ASC";
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
<? if($loginDesignation!='Site Engineer'){?>
<table width="90%" align="center">
<tr>
	<td><input type="radio" onClick="location.href='./index.php?keyword=local+emp+ut+report+dd&project=<?php echo $project; ?>&edat=<?php echo $edat; ?>'" >Details by Date</td> 
<!-- 	<td><input type="radio" onClick="location.href='./index.php?keyword=local+emp+ut+report+l&project=<?php echo $project; ?>&edat=<?php echo $edat; ?>'" >Log Report</td> -->
<td><input type="radio"  onClick="location.href='./index.php?keyword=local+emp+ut+report+b&project=<?php echo $project; ?>&edat=<?php echo $edat; ?>'">Uptodate Summary</td>
<td><input type="radio" onClick="location.href='./index.php?keyword=local+emp+ut+report+d&project=<?php echo $project; ?>&edat=<?php echo $edat; ?>'">Details by Employee</td>
<td><input type="radio" checked>Summary by Designation</td>
</tr>
</table>
<? }?>
	<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>

<? $format="Y-m-j";
$edat1 = formatDate($edat,$format);
if($project=='') $project=$loginProject;
?>
<form name="att" action="./index.php?keyword=local+emp+ut+report+c&project=<? echo $project;?>" method="post">

<table align="center" width="50%" border="3"  bgcolor="#CCCCCC" cellpadding="2" cellspacing="0" style="border-collapse:collapse">
<tr>	
   <td width=250>Designation</td>
      <td > <select name='designationall[]' size='3' multiple id="equipmentsCollection" >
				<option  onClick="$(document).ready(function(){$('#equipmentsCollection').find('option').each(function(){$(this).prop('selected',true);});});">All Designation</option>
          <? 
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT DISTINCT employee.designation,itemlist.* from `itemlist`,employee Where itemCode >= '87-00-000' AND itemCode < '98-00-000'".
" AND employee.designation=itemlist.itemCode AND employee.location='$project' ORDER by employee.designation ASC";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

 while($typel= mysqli_fetch_array($sqlrunp))
{
 echo "<option value='".$typel[itemCode]."'";
 if($designationall[0]==$typel[itemCode]) echo "SELECTED";
 echo ">$typel[itemCode]--$typel[itemDes]</option>  ";
 }
 ?>
        </select> 
        <? //echo $sqlp;?>
      </td>
</tr>

<tr > 
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
 <td align="right" colspan="9" ><font class='englishhead'>human utilization</font></td>
</tr>

<?
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
  <th colspan="3" >Monthly Total till <? echo $edat;?></th>    
  <th colspan="3">Project Total till <? echo $edat;?></th>    
</tr>
    <? $sqlquery="SELECT DISTINCT attendance.empId,employee.designation,employee.salary,employee.allowance".
		" FROM attendance,employee".
" where attendance.location='$project' AND attendance.edate='$edat1'".
" AND action in('P','HP') AND attendance.empId=employee.empId".
" AND employee.designation='$designation' ORDER by designation,empId ASC";// limit 0,3";
//echo $sqlquery;

 $sql= mysqli_query($db, $sqlquery);
 $i=1;
 while($re=mysqli_fetch_array($sql)){
	 
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

 $sql= mysqli_query($db, $sqlquery);

 while($re=mysqli_fetch_array($sql)){
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

 $sql1= mysqli_query($db, $sqlquery1);
 while($re1=mysqli_fetch_array($sql1)){
 
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

 $sql= mysqli_query($db, $sqlquery);

 //echo "totalPresent:$totalPresent";
 $i=1;
 
 while($re=mysqli_fetch_array($sql)){
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

 $sql1= mysqli_query($db, $sqlquery1);
 while($re1=mysqli_fetch_array($sql1)){
 
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
$sql1=mysqli_query($db, $sqls); 
while($dmar=mysqli_fetch_array($sql1)){
$siowDuration=siowDuration($dmar[dmasiow]);

$siowDaysRem=siowDaysRem($dmar[dmasiow],$edat1);
$siowDaysGan=siowDaysGan($dmar[dmasiow],$edat1);
//echo "*$dmar[dmasiow]==$siowDaysRem==$siowDaysGan*";
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
if($perdayRemainQty>0)$perDayQtyTotal = $perDayQtyTotal+$perdayRemainQty;
//if($perdayRemainQty<0)echo "*$dmar[dmasiow]=$siowdmaPerDay#$empTotalWorkhrsiow==$perdayRemainQty**$siowDaysRem=$siowDaysGan##";
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


$sqls = "SELECT * from `dma` WHERE dmaProjectCode='$project' AND dmaItemCode ='$designation' ";
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
$hour100parcent_monthly=$perDayQtyTotal0=$perDayQtyTotal-$perDayQtyTotal1;
$siowdmauptoTotal0=$siowdmauptoTotal-$siowdmauptoTotal1;
$amount100parcent_monthly=$siowdmauptoTotal0;
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

 <td align="right"><font color="#336666">100%</font></td>
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

$hour100parcent_project=$perDayQtyTotal = $perDayQtyTotal+$siowdmaPerDay;
$siowdmauptoTotal=$siowdmauptoTotal+$perDayAmount;
$perdayRemainQty=0;
$perDayAmount=0;
 }//while
 
 ?>
 <font color="#336666">
 <? echo sec2hms($perDayQtyTotal,$padHours=false).' hrs.';?></font>
 </td>
 <td align="right">100%</td>
 <td align="right"><font color="#336666">Tk. <? echo number_format($siowdmauptoTotal);?></font></td>

</tr>

<tr bgcolor="#FFFFCC">
 <td>Actual Consumption in Item Of Work</td>
 <td align="right"><? echo sec2hms($worktat/3600,$padHours=false).' hrs.';?></td>
 <td align="right">Tk. <? echo number_format($normalDayAmountTotal);?> </td> 
 <td align="right"><? echo sec2hms($mworkedgTotal/3600,$padHours=false).' hrs.';?></td>
 <td align="right"><? echo number_format(($mworkedgTotal/3600)/($hour100parcent_monthly/100));?>%</td>
 <td align="right">Tk. <? echo number_format($mnormalDayAmountgTotalup);?></td>
 <td align="right"><? echo sec2hms($workedgTotal/3600,$padHours=false).' hrs.';?></td>
 <td align="right"><? echo number_format(($workedgTotal/3600)/($hour100parcent_project/100));?>%</td>
 <td align="right">Tk. <? echo number_format($normalDayAmountgTotalup);?></td>
</tr>

<tr>
 <td align="right">Present as Regular</td>
 <td align="right">
 <?  echo sec2hms(($toDaypresentat-$overtimetat)/3600,$padHours=false).' hrs.';?></td>
 <td align="right">Tk. <? echo number_format($regularAmountTotalat); ?></td>
 <td align="right"><? echo sec2hms($mpresentasReggTotal/3600,$padHours=false).' hrs.';?></td>
 <td align="right"><? echo number_format(($mpresentasReggTotal/3600)/($hour100parcent_monthly/100));?>%</td> 
 <td align="right">Tk. <? echo number_format($mpresentasReggAmountTotal);?></td> 
 <td align="right"><? echo sec2hms($presentasReggTotal/3600,$padHours=false).' hrs.';?></td>
 <td align="right"><? echo number_format(($presentasReggTotal/3600)/($hour100parcent_project/100));?>%</td>
 <td align="right">Tk. <? echo number_format($presentasReggAmountTotal);?></td> 
<? $mpresentasReggTotal=0;?>
</tr>
<tr>
 <td align="right">Present as Overtime</td>
 <td align="right"><? echo sec2hms($overtimetat/3600,$padHours=false).' hrs.';?></td>
 <td align="right">Tk. <? echo number_format($overtimeAmountTotal);?> </td>
 <td align="right"><? echo sec2hms($movertimegTotal/3600,$padHours=false).' hrs.';?></td>
 <td align="right"><? echo number_format(($movertimegTotal/3600)/($hour100parcent_monthly/100))?>%</td> 
 <td align="right">Tk. <? echo number_format($movertimegAmountTotal)?></td> 
 <td align="right"><? echo sec2hms($overtimegTotal/3600,$padHours=false).' hrs.';?></td>
 <td align="right"><? echo number_format(($overtimegTotal/3600)/($hour100parcent_project/100));?>%</td>
 <td align="right">Tk. <? echo number_format($overtimegAmountTotal)?></td> 
<? $movertimegTotal=0;$overtimetat=0;?>
</tr>

<tr bgcolor="#FFFFCC">
 <td >Total Present</td>
 <td align="right"> <?  echo sec2hms($toDaypresentat/3600,$padHours=false).' hrs.';?> </td>
 <td align="right">Tk. <? echo number_format($overtimeAmountTotal+$regularAmountTotalat);?> </td>
 <td align="right"> <?  echo sec2hms($mpresentgTotal/3600,$padHours=false).' hrs.';?> </td>
 <td align="right"><? echo number_format(($mpresentgTotal/3600)/($hour100parcent_monthly/100));?>%</td>
 <td align="right">Tk. <? echo number_format($mpresentasReggAmountTotal+$movertimegAmountTotal);?> </td>
 <td align="right"> <?  echo sec2hms($presentgTotal/3600,$padHours=false).' hrs.';?> </td>
 <td align="right"><? echo number_format(($presentgTotal/3600)/($hour100parcent_project/100));?>%</td>
 <td align="right">Tk. <? echo number_format($overtimegAmountTotal+$presentasReggAmountTotal);?> </td>

</tr>
<tr >
 <td align="center"><font class="out">IDLE</font></td>
 <td align="right"><font class="out"><? echo sec2hms($idletat/3600,$padHours=false).' hrs.';?></font></td>
 <td align="right"><font class="out">Tk. <? echo number_format((($overtimeAmountTotal+$regularAmountTotalat) -$normalDayAmountTotal));?> </font></td>
 <td align="right"><font class="out"><? echo sec2hms($midlegTotal/3600,$padHours=false).' hrs.';?></font></td>
 <td align="right"><font class="out"><? echo number_format(($midlegTotal/3600)/($hour100parcent_monthly/100));?>%</font></td>
 <td align="right"><font class="out">Tk. <? echo number_format((($movertimegAmountTotal+$mpresentasReggAmountTotal) -$mnormalDayAmountgTotalup));?> </font></td>
<td align="right"><font class="out"><? echo sec2hms($idlegTotal/3600,$padHours=false).' hrs.';?></font></td>
 <td align="right"><? echo number_format(($idlegTotal/3600)/($hour100parcent_project/100));?>%</td>
 <td align="right"><font class="out">Tk. <? echo number_format((($overtimegAmountTotal+$presentasReggAmountTotal) -$normalDayAmountgTotalup));?> </font></td>
</tr>

<tr><td colspan="9" height="30"></td></tr>
<? }
}//designation
?>
</table>
</form>
<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
<a href="./print/print_local_emputReport_c.php?project=<? echo $project;?>&edat=<? echo $edat;?>&designationall=<? echo $godesignation;?>" target="_blank">Print</a>
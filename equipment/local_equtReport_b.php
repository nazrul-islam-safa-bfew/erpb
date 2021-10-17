<?
error_reporting(E_ERROR | E_PARSE);
if($loginProject=='000' || $loginProject=='004'){?>
<form name="pro" method="post" >
<select name="project" onChange="location.href='index.php?keyword=local+eq+ut+report+b&project='+pro.project.options[document.pro.project.selectedIndex].value";>
<option value="">Select Project</option>
<?
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

$sql="select * from project";
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
<td><input type="radio" checked>Details by date</td>
<td><input type="radio" onClick="location.href='./index.php?keyword=local+eq+ut+report+dd&project=<?php echo $project; ?>&edat=<?php echo $edat; ?>'">Uptodate Summery</td>
<!-- <td><input type="radio" onClick="location.href='./index.php?keyword=local+eq+ut+report+d&project=<?php echo $project; ?>&edat=<?php echo $edat; ?>'">Details by Equipment</td> -->
<td><input type="radio" onClick="location.href='./index.php?keyword=local+eq+ut+report+c&project=<?php echo $project; ?>&edat=<?php echo $edat; ?>'">Summary by Equipment Group</td>
</tr>
</table>
<? }?>
	<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>

<? $format="Y-m-j";
$edat1 = formatDate($edat,$format);
if($project=='') $project=$loginProject;
?>
<form name="att" action="./index.php?keyword=local+eq+ut+report+b&e=<? echo $e;?>&project=<? echo $project;?>&a=<? echo $a;?>" method="post">
<table align="center" width="98%" border="3"  bordercolor="CC9999" cellpadding="2" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999"> 
<td align="left" colspan="2">
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
         
	From: <input type="text" maxlength="10" name="fDate" value="<? echo $fDate;?>"> <a id="anchor" href="#"
   onClick="cal.select(document.forms['att'].fDate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
     
	To: <input type="text" maxlength="10" name="tDate" value="<? echo $tDate;?>"> <a id="anchor" href="#"
   onClick="cal.select(document.forms['att'].tDate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
	
   <input type="hidden" name="a" value="<? echo $a;?>">
	
	<label for="sortBy">Sort by: <select name="sortBy">
		<option value="equipment" <?php echo $sortBy=="equipment" ? "selected" : ""; ?>>Equipment</option>
		<option value="task" <?php echo $sortBy=="task" ? "selected" : ""; ?>>Task</option>
		</select></label>
	
  <input type="submit" name="go" value="Go">
	  </td> 
 <td align="right" colspan="3" ><font class='englishhead'>equipment utilization</font></td>
</tr>

	<style>
		li{list-style:none;}
	</style>

<? 
//Head office employee

include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

	
	//======================== day =============================
	$lastMonth=1;
	$todat=todat();
	
	$dateExplodeF=explode("/",$fDate);
	$fDate1=$dateExplodeF[2]."-".$dateExplodeF[1]."-".$dateExplodeF[0];
	$dateExplodeT=explode("/",$tDate);
	$tDate1=$dateExplodeT[2]."-".$dateExplodeT[1]."-".$dateExplodeT[0];

	$fDate2=strtotime($fDate1);
	$tDate2=strtotime($tDate1);
	
				$fullMonth=date("Y-m-d",strtotime($year."-".$startMonth."-01"));
				$lastDay=date("t",strtotime($fullMonth));
	if($fDate && $tDate)
				for($fDate2;$fDate2<=$tDate2;$tDate2-=86400){
					$edat1=date("Y-m-d",$tDate2);
					echo '<tr bgcolor="#ff8080" style="border: 2px solid #fff;">
					<td colspan="5" align="center"><font class="englishhead" style="font-size:12px; font-weight:800;">'.date("D d/m/Y",$tDate2).'</font></td>
					</tr>';
if($sortBy=="equipment"){
	
$sqlquery="SELECT e.itemCode,i.itemDes,e.eqId FROM eqattendance as e,itemlist as i  where e.location='$project' AND e.edate='$edat1' AND action in('P','HP') and e.itemCode=i.itemCode group by e.itemCode,e.eqId";
$allItemQ= mysqli_query($db, $sqlquery);
while($allItemRow=mysqli_fetch_array($allItemQ)){
$eqID=$allItemRow[eqId];

if($re[eqId]{0}=='A'){$eqIDitemCode=eqpId_local($allItemRow[eqId],$allItemRow[itemCode]); $type='L';}
else { $eqIDitemCode=eqpId($allItemRow[eqId],$allItemRow[itemCode]); $type='H'; }
	
$eqDesc=$allItemRow[itemDes];
$total_result=mysql_num_rows($sql);
$total_per_page=10; 

if($eqDesc!=$oldEqDes){
$oldEqDes=$eqDesc;?>
<tr bgcolor="#CC9999" style="    border: 2px solid #fff;">
	<td align="" colspan="5" ><font class='englishhead' style="font-size:12px;">Equipment: <?php echo $allItemRow[itemCode]." - ".$eqDesc; ?></font></td>
</tr>
<?php }
	
	 if($page<=0)
{
	$page=1;
}
$curr=($page-1)*$total_per_page;
$sqlquery="SELECT eqattendance.* FROM eqattendance".
" where eqattendance.location='$project' AND eqattendance.edate='$edat1' and eqattendance.itemCode='$allItemRow[itemCode]' and eqattendance.eqId='$allItemRow[eqId]' ".
" AND action in('P','HP') ORDER by eqattendance.itemCode ASC LIMIT $curr,$total_per_page";
$sql= mysqli_query($db, $sqlquery);
// echo $sqlquery; exit;
 $i=1;

$month=date('m',strtotime($edat1));
$year=date('Y');
$from="$year-$month-01";

 while($re=mysqli_fetch_array($sql)){

	$dailyworkBreakt=eq_dailyworkBreak($re[eqId],$re[itemCode],$edat1,$type,$project);
    $dailyBreakDownt=eq_dailyBreakDown($re[eqId],$re[itemCode],$edat1,$type,$project);
	$toDaypresent=eq_toDaypresent($re[eqId],$re[itemCode],$edat1,$type,$project);
	
    $toDaypresent=$toDaypresent-$dailyworkBreakt;	
	
	$workt= eq_dailywork($re[eqId],$re[itemCode],$edat1,$type,$project);
	$overtimet = $toDaypresent-8*3600;
	if($overtimet<0) $overtimet=0;
	$idlet=$toDaypresent-$workt-$dailyBreakDownt;
	  if($idlet<0) $idlet=0;
	 
  $totalPresent = eqTotalPresentHr($edat1,$edat1,$re[eqId],$re[itemCode],$type,$project);    
	$presentHour=sec2hms($toDaypresent/3600,$padHours=true);
	$workHour=sec2hms($workt/3600,$padHours=true);
	$overtimeHour=sec2hms($overtimet/3600,$padHours=true);
	$breakdownHour=sec2hms($dailyBreakDownt/3600,$padHours=true);
	$idleHour=sec2hms($idlet/3600,$padHours=true);
	$dailyworkBreakHour=sec2hms($dailyworkBreakt/3600,$padHours=true);
	 
	 
	$utSql="select ut.stime, ut.etime, ut.details, i.iowCode, s.siowCode, s.siowName from equt as ut,iow as i, siow as s where eqId='$eqID' and ut.itemCode='$re[itemCode]' AND ut.pcode='$project' and (''!=ut.iow and ''!=ut.siow and i.iowId=ut.iow and s.siowId=ut.siow )  and ut.edate='$edat1' order by ut.stime asc  ";
	 
	 	
	$workBreakSql="select ut.stime, ut.etime, ut.details from equt as ut where ut.eqId='$eqID' and ut.itemCode='$re[itemCode]' AND ut.pcode='$project' and (''=ut.iow and ''=ut.siow )  and ut.edate='$edat1' order by ut.stime desc  ";
	 
	 $UTquery=mysqli_query($db,$utSql);
			while($UTrow=mysqli_fetch_array($UTquery)){ 
				if($UTrow[iowCode] && $UTrow[siowCode]){
					$startTime=timeConvert($UTrow[stime]);
					$endTime=timeConvert($UTrow[etime]);
 					$presentArray[]=$startTime."-".$endTime;
					$utArray[]="<tr><td>$UTrow[iowCode]: <span style='color:#00f;'>$UTrow[siowCode]</span> - $UTrow[siowName]</td>
					<td>$startTime-$endTime</td>
					<td><i>$UTrow[details]</i></td></tr>";
				}		
			}
	 
	 			$workBreakQ=mysqli_query($db,$workBreakSql);
			while($workBreakRow=mysqli_fetch_array($workBreakQ)){
				$workedBreakArray[]=timeConvert($workBreakRow[stime])."-".timeConvert($workBreakRow[etime]);
			}
				
	 
	 $presentRow=implode(", ",$presentArray);
	 $workedBreakRow=implode(", ",$workedBreakArray);
	 
	 unset($presentArray);
	 unset($workedBreakArray);
	 
	 $presentArray=array();
	 $workedBreakArray=array();?>

	
	
	<tr><td colspan="4" height="5"></td></tr>
	
	
			<tr>
				<td colspan="4" style="font-size:10px;" rowspan="<?php echo $rowCounter; ?>">
					ID: <span style="color: #f00; font-weight: 700; font-size: 10px;"><?php echo $eqIDitemCode; ?></span>, <span style="color:#00f"><?php $temp=itemDes($re[itemCode]); echo $temp[des].', '.$temp[spc];
	 echo '</span>';
	$eqROW=getEquipmentRow($eqID,$re[itemCode]);
	if($eqROW){
	$eqData=explode("_",$eqROW[teqSpec]);
	echo ", Brand: <span style='color:#00f'>$eqData[1]</span>,
	Model: <span style='color:#00f'>$eqData[0]</span>,
	Year of Manufacture: <span style='color:#00f'>$eqData[7]</span>, 
	Design Capacity: <span style='color:#00f'>$eqData[4]</span>";
	}
					?></span><br>
					
					Present: <span style="color:#00f"><?php echo $presentHour.' Hrs'; echo $presentRow ? " ($presentRow)" : ""; ?></span>, Work: <span style="color:#00f"><?php echo $workHour.' Hrs'; ?></span>,
					
				 Idle: <span style="color:#00f"><?php echo $idleHour.' Hrs'; ?></span>, Overtime: <span style="color:#00f"><?php echo $overtimeHour.' Hrs'; ?></span>, Workbreak: <span style="color:#00f"><?php echo $dailyworkBreakHour.' Hrs';echo $workedBreakRow ? " ($workedBreakRow)" : ""; ?></span>, Breakdown: <span style="color:#00f"><?php echo $breakdownHour.' Hrs'; ?></span>
				</td>
		</tr>
	
	<?php	 
	 $mRow=getTheMeasureRow($eqID,$re[itemCode],$edat1,$project);
	 if($mRow){		  
 $eqAr=explode("_",$mRow[eqID]);
 $eqID_A=$eqAr[0];
 if($eqID_A){
	 $last_usage_report=$mRow[unit]=="ue" ? getUsageofEQ($eqAr[1],$eqAr[0],$edat1) : getLastUsageofEQbyDate($eqAr[0],$project,$eqAr[1],$edat1) ; //conditional item value
	 $last_usage_report=$mRow[unit]!="km" ? sec2hms($last_usage_report) : $last_usage_report; //hour convert if not km
	 $last_usage_report.=$mRow[unit]=="ue" ? " Hr. " : ""; //add hr if utilization in erp
 }?>

	<tr><td colspan="4" height="5">Usage: <?php 
     $c = measuerUnti();
     $b = $mRow[unit];
     $a= $c[$b];
	 echo "<font color='#00f'>".$last_usage_report."</font>".$a;
	 //echo "<font color='#00f'>".$last_usage_report."</font> ".(measuerUnti()[$mRow[unit]]);
		 
	 echo "; Fuel: <font color='#00f'>"."XX Ltr"."</font> Diesel;"; ?>
		
		</td></tr>
	<?php } ?>
	
	
	
 <? foreach($utArray as $workRow){
				echo $workRow;
			}
	 
	 unset($utArray);
	 $utArray=array();
	
	 
 } //while
	
} //all equipment row
}
	
	elseif($sortBy=="task"){
		$allIowSiow="select i.iowCode, s.siowCode, i.iowId, s.siowId, s.siowName from iow as i,siow as s where i.iowProjectCode='$project' and i.iowId=s.iowId and iowSdate<='$edat1'";
		$isQuery=mysqli_query($db,$allIowSiow);
		while($isRow=mysqli_fetch_array($isQuery)){  ?>
	
<tr bgcolor="#CC9999" style="    border: 2px solid #fff;">
	<td align="" colspan="5" ><font class='englishhead' style="font-size:12px;">Task: <?php echo $isRow[iowCode].": ".$isRow[siowCode]." - ".$isRow[siowName]; ?></font></td>
</tr>
	
	
	<?php
$itemCodesql="SELECT distinct e.itemCode,e.eqId FROM eqattendance as e, equt as ut".
" where e.location='$project' AND e.edate='$edat1'
and ut.eqId=e.eqId and ut.itemCode=e.itemCode and ut.edate=e.edate  ".
" AND e.action in('P','HP')  and ut.pcode= e.location and '$isRow[iowId]'=ut.iow and '$isRow[siowId]'=ut.siow";
	$itemQuery=mysqli_query($db,$itemCodesql);
while($itemRow=mysqli_fetch_array($itemQuery)){
	
// 																							 echo $itemCodesql."<br>";
	$eqID=$itemRow[eqId];
	 
	$utSql="select ut.stime, ut.etime, ut.details, i.iowCode, s.siowCode, s.siowName from equt as ut,iow as i, siow as s where ut.eqId='$eqID' and ut.itemCode='$itemRow[itemCode]' AND ut.pcode='$project' and ('$isRow[iowId]'=ut.iow and '$isRow[siowId]'=ut.siow and i.iowId=ut.iow and s.siowId=ut.siow )  and ut.edate='$edat1' order by ut.stime asc   ";		
	
	$workBreakSql="select ut.stime, ut.etime, ut.details from equt as ut where ut.eqId='$eqID' and ut.itemCode='$itemRow[itemCode]' AND ut.pcode='$project' and (''=ut.iow and ''=ut.siow )  and ut.edate='$edat1' order by ut.stime desc  ";
	$rowCounter=1;
	$utQuery=mysqli_query($db,$utSql);
	while($UTrow=mysqli_fetch_array($utQuery)){ 
				if($UTrow[iowCode] && $UTrow[siowCode]){					
					$startTime=timeConvert($UTrow[stime]);
					$endTime=timeConvert($UTrow[etime]);
 					$presentArray[]=$startTime."-".$endTime;
					$workDetailsRows[]="<tr style=\"font-size:10px;\"><td align='center'>$startTime-$endTime</td>
					<td><i>$UTrow[details]</i></td></tr>";
					$rowCounter++;
				}	
		
	}
			$workBreakQ=mysqli_query($db,$workBreakSql);
			while($workBreakRow=mysqli_fetch_array($workBreakQ)){
				$workedBreakArray[]=timeConvert($workBreakRow[stime])."-".timeConvert($workBreakRow[etime]);
			}
				
			$presentRow=implode(", ",$presentArray);
			$workedBreakRow=implode(", ",$workedBreakArray);
			unset($presentArray);
			unset($workedBreakArray);
			$presentArray=array();
			$workedBreakArray=array();
	
	
	if($itemRow[eqId]{0}=='A'){$eqIDitemCode=eqpId_local($itemRow[eqId],$itemRow[itemCode]); $type='L';}
else { $eqIDitemCode=eqpId($itemRow[eqId],$itemRow[itemCode]); $type='H'; }
	
$eqDesc=$itemRow[itemDes];
	
	
		$dailyworkBreakt=eq_dailyworkBreak($eqID,$itemRow[itemCode],$edat1,$type,$project);
    $dailyBreakDownt=eq_dailyBreakDown($eqID,$itemRow[itemCode],$edat1,$type,$project);
	$toDaypresent=eq_toDaypresent($eqID,$itemRow[itemCode],$edat1,$type,$project);
	
    $toDaypresent=$toDaypresent-$dailyworkBreakt;	
	
	$workt= eq_dailywork($eqID,$itemRow[itemCode],$edat1,$type,$project);
	$overtimet = $toDaypresent-8*3600;
	if($overtimet<0) $overtimet=0;
	$idlet=$toDaypresent-$workt-$dailyBreakDownt;
	  if($idlet<0) $idlet=0;
	 
  $totalPresent = eqTotalPresentHr($edat1,$edat1,$eqID,$itemRow[itemCode],$type,$project);    
	$presentHour=sec2hms($toDaypresent/3600,$padHours=true);
	$workHour=sec2hms($workt/3600,$padHours=true);
	$overtimeHour=sec2hms($overtimet/3600,$padHours=true);
	$breakdownHour=sec2hms($dailyBreakDownt/3600,$padHours=true);
	$idleHour=sec2hms($idlet/3600,$padHours=true);
	$dailyworkBreakHour=sec2hms($dailyworkBreakt/3600,$padHours=true);
	
?>
	
	
	
	<tr><td colspan="4" height="5"></td></tr>
			<tr>
				<td colspan="1" style="font-size:10px;" rowspan="<?php echo $rowCounter; ?>">
					<li>ID: <span style="color:#00f"><?php echo $eqIDitemCode; ?></span>, Description: <span style="color:#00f"><?php $temp=itemDes($itemRow[itemCode]); echo $temp[des].', '.$temp[spc]; ?></span>
					
						

	<?php	 
	 $mRow=getTheMeasureRow($eqID,$itemRow[itemCode],$edat1,$project);
	 if($mRow){		  
 $eqAr=explode("_",$mRow[eqID]);
 $eqID_A=$eqAr[0];
 if($eqID_A){
	 $last_usage_report=$mRow[unit]=="ue" ? getUsageofEQ($eqAr[1],$eqAr[0],$edat1) : getLastUsageofEQbyDate($eqAr[0],$project,$eqAr[1],$edat1) ; //conditional item value
	 $last_usage_report=$mRow[unit]!="km" ? sec2hms($last_usage_report) : $last_usage_report; //hour convert if not km
	 $last_usage_report.=$mRow[unit]=="ue" ? " Hr. " : ""; //add hr if utilization in erp
 }?>
	<span>Usage: <?php 
	  $c = measuerUnti();
	  $b = $mRow[unit];
	  $a= $c[$b];
	  echo "<font color='#00f'>".$last_usage_report."</font>".$a;
	 //echo "<font color='#00f'>".$last_usage_report."</font> ".(measuerUnti()[$mRow[unit]]); ?></span>
	<?php } ?>
					
					</li>
					
					<li>Present: <span style="color:#00f"><?php echo $presentHour.' Hrs'; echo $presentRow ? " ($presentRow)" : ""; ?></span>, Work: <span style="color:#00f"><?php echo $workHour.' Hrs'; ?></span></li>
					
					<li>Idle: <span style="color:#00f"><?php echo $idleHour.' Hrs'; ?></span>, Overtime: <span style="color:#00f"><?php echo $overtimeHour.' Hrs'; ?></span>, Workbreak: <span style="color:#00f"><?php echo $dailyworkBreakHour.' Hrs';echo $workedBreakRow ? " ($workedBreakRow)" : ""; ?></span></li>
				</td>
		</tr>
	
	
	
	

	
			<?php foreach($workDetailsRows as $workRow){
				echo $workRow;
			}
		?>
	
	
	<?php 
	$i++;
unset($workDetailsRows);
$workDetailsRows=array();
		}//task query		
} //item sql while
	}// sort by task
} // sort date
	?>
	


<!-- -->

</table>
</form>
<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
<?php

       include("./includes/PageNavigation.php");

        $totalResults= $total_result;
        $resultsPerPage= $total_per_page;
        $page= $_GET[page];
        $startHTML= "<b>Showing Page <font class=out>{page}</font> of {pages}</b>: Go to Page ";
        $appendSearch= "&a=$a";
        $range= 5;
		$rootLink="./index.php?keyword=local+eq+ut+report+b&edat=$edat";
        $link_on= "<a href='$rootLink&page={num}{appendSearch}'><b><font class=larg>{num}</larg></b></a>";
        $link_off= "<a href='$rootLink&page={num}{appendSearch}'>{num}</a>";
        $back= " <a href='$rootLink&page=1{appendSearch}'><<</a> ";
        $forward= " <a href='$rootLink&page={pages}{appendSearch}'>>></a> ";

        $myNavigation = New PageNavigation($totalResults, $resultsPerPage, $page, $startHTML, $appendSearch, $range, $link_on, $link_off, $back, $forward);

        echo $myNavigation->getHTML();

?>
<a href="./print/print_local_equtReport_b.php?project=<? echo $project;?>&edat=<? echo $edat;?>" target="_blank">Print</a>
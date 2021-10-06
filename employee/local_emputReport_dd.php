<?
ini_set("max_execution_time","96000000");

if($loginProject=='000'){ ?>
<form name="pro" method="post" >
<select name="project" onChange="location.href='index.php?keyword=local+emp+ut+report+dd&project='+pro.project.options[document.pro.project.selectedIndex].value";>
<option value="">Select Project</option>
<?
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sql="select * from project ORDER by pcode ASC";
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
	<td><input type="radio" checked>Details by Date</td> 
<!-- 	<td><input type="radio" onClick="location.href='./index.php?keyword=local+emp+ut+report+l&project=<?php echo $project; ?>&edat=<?php echo $edat; ?>'" >Log Report</td> -->
	<td><input type="radio"  onClick="location.href='./index.php?keyword=local+emp+ut+report+b&project=<?php echo $project; ?>&edat=<?php echo $edat; ?>'">Uptodate Summary</td>
	<td><input type="radio" onClick="location.href='./index.php?keyword=local+emp+ut+report+d&project=<?php echo $project; ?>&edat=<?php echo $edat; ?>'">Details by Employee</td>
	<td><input type="radio" onClick="location.href='./index.php?keyword=local+emp+ut+report+c&project=<?php echo $project; ?>&edat=<?php echo $edat; ?>'">Summary by Designation</td>
</tr>
</table>
<? }?>
	<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>

<? $format="Y-m-j";
$edat1 = formatDate($edat,$format);
if($project=='') $project=$loginProject;
?>
<form name="att" action="./index.php?keyword=local+emp+ut+report+dd&e=<? echo $e;?>&project=<? echo $project;?>" method="post">
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
	<label for="sortBy">Sort by: <select name="sortBy">
		<option value="designation" <?php echo $sortBy=="designation" ? "selected" : ""; ?>>Designation</option>
		<option value="task" <?php echo $sortBy=="task" ? "selected" : ""; ?>>Task</option>
		</select></label>
	
	
	  <input type="submit" name="go" value="Go">
	  </td> 
 <td align="right" colspan="3" ><font class='englishhead'>human utilization report</font></td>
</tr>

	<style>
		li{list-style:none;}
	</style>


	<?php 
	
	
	// 			========================day
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
	
	
// 	========================================================= Designation =============
if($sortBy=="designation"){	
	$sqlp = "SELECT DISTINCT employee.designation,itemlist.* from `itemlist`,employee Where itemCode >= '87-00-000' AND itemCode < '98-00-000'".
" AND employee.designation=itemlist.itemCode AND employee.location='$project' ORDER by employee.designation ASC";
// echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

 while($typel= mysqli_fetch_array($sqlrunp))
{
	
	?>
<tr bgcolor="#CC9999" style="    border: 2px solid #fff;">
	<td align="" colspan="5" ><font class='englishhead' style="font-size:12px;">Designation: <?php echo $typel[itemCode]."-".$typel[itemDes]; ?></font></td>
</tr>
 <?php 
//Head office employee

include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

	
$sqlquery="SELECT DISTINCT attendance.empId,employee.designation FROM attendance,employee 
where attendance.location='$project' AND attendance.edate<='$edat1' 
AND action in('P','HP') AND attendance.empId=employee.empId and employee.designation='$typel[itemCode]' 
AND employee.salaryType LIKE 'Wages%' ORDER by designation,empId ASC";// limit 0,3";
// echo $sqlquery;

 $sql= mysqli_query($db, $sqlquery);
 $i=1;

 $month=date('m',strtotime($edat1));
$year=date('Y');
$from="$year-$month-01";

 while($re=mysqli_fetch_array($sql)){
	 
		if(isPresent($re[empId],$edat1) OR isHPresent($re[empId],$edat1)){


		$empId=$re[empId];
		$empName=empName($re[empId]);
		$overTime="";
		$idleTime="";
		$edate1=$edat1;
		$empType="H";
		$empDesignation=empId($empId,$re[designation]);

		$totalPresent=local_TotalPresentHr('2006-01-01',$edat1,$re[empId],'H',$project);
		$totalBreak="";	
			
// echo "empID:$empId, edate:$edate1, empType:$empType, loginProject:$project";
$dailyworkBreakt=dailyworkBreak($empId,$edate1,$empType,$project);
$toDaypresent=toDaypresent($empId,$edate1,$empType,$project)-$dailyworkBreakt;
$workt= dailywork($empId,$edate1,$empType,$project);
if(date('D',strtotime($edate1))=='Fri')
 $overtimet = $toDaypresent-(4*3600);
else 
	$overtimet = $toDaypresent-(8*3600);

if($overtimet<0) $overtimet=0;
$idlet=$toDaypresent-$workt;
if($idlet<0) $idlet=0;

   $totalPresent= sec2hms($toDaypresent/3600,$padHours=false);
   $work= sec2hms($workt/3600,$padHours=false);     
  $overtime=sec2hms($overtimet/3600,$padHours=false); 
  $idleTime=sec2hms($idlet/3600,$padHours=false); 
  $totalBreak=sec2hms($dailyworkBreakt/3600,$padHours=false); 
			
			
	
			
//		utilization & present information
			$utSql="select ut.stime, ut.etime, ut.details, i.iowCode, s.siowCode, s.siowName
			from emput as ut,iow as i,siow as s
			where ut.empId='$empId' and ut.edate='$edate1' 
			AND ut.empType='$empType'  AND ut.pcode='$project'
			 and (i.iowId=ut.iow and s.siowId=ut.siow)
			";
			
			$workBreakSql="select ut.stime, ut.etime, ut.details from emput as ut
			where ut.empId='$empId' and ut.edate='$edate1' 
			AND ut.empType='$empType'  AND ut.pcode='$project' and (''=ut.iow and ''=ut.siow)";
// 			echo $utSql."<br>";
			$UTquery=mysqli_query($db,$utSql);
			while($UTrow=mysqli_fetch_array($UTquery)){
				if($UTrow[iowCode] && $UTrow[siowCode]){
					$startTime=timeConvert($UTrow[stime]);
					$endTime=timeConvert($UTrow[etime]);
 					$presentArray[]=$startTime."-".$endTime;
					$siowRows[]="<td>$UTrow[iowCode]: <span style='color:#00f;'>$UTrow[siowCode]</span> - $UTrow[siowName]</td>
					<td>$startTime-$endTime</td>
					<td><i>$UTrow[details]</i></td>";
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
?>
	<tr><td colspan="4" height="5"></td></tr>
			<tr>
				<td colspan="4" style="font-size:10px;">
					Present: <span style="color:#00f"><?php echo $totalPresent.' Hrs'; echo $presentRow ? " ($presentRow)" : ""; ?></span>, Work: <span style="color:#00f"><?php echo $work.' Hrs'; ?></span>, Idle: <span style="color:#00f"><?php echo $idleTime.' Hrs'; ?></span>, Overtime: <span style="color:#00f"><?php echo $overtime.' Hrs,'; ?></span>, Workbreak: <span style="color:#00f"><?php echo $totalBreak.' Hrs';echo $workedBreakRow ? " ($workedBreakRow)" : ""; ?></span>,	ID: <span style="color:#00f"><?php echo $empDesignation; ?></span>, Name: <span style="color:#00f"><?php echo $empName; ?></span>
				</td>
		</tr>

	<?php foreach($siowRows as $siow){ ?>
	<tr style="font-size:10px;">
				<?php echo $siow; ?>
	</tr>
<?php } ?>

	 <? $i++;
unset($siowRows);
$siowRows=array();
	 }
 } 
} //while
	
} 
	//===================================== end of designation ===================
	//===================================== Task =================================
	elseif($sortBy=="task"){
		$allIowSiow="select i.iowCode, s.siowCode, i.iowId, s.siowId, s.siowName from iow as i,siow as s where i.iowProjectCode='$project' and i.iowId=s.iowId and iowSdate<'$edat1'";
		$isQuery=mysqli_query($db,$allIowSiow);
		while($isRow=mysqli_fetch_array($isQuery)){ ?>
<tr bgcolor="#CC9999" style="    border: 2px solid #fff;">
	<td align="" colspan="5" ><font class='englishhead' style="font-size:12px;">Task: <?php echo $isRow[iowCode].": ".$isRow[siowCode]." - ".$isRow[siowName]; ?></font></td>
</tr>
	
	<?
			$empType="H";
			$empSql="select ut.empId
			from emput as ut,iow as i,siow as s
			where  ut.edate='$edat1' 
			AND ut.empType='$empType' AND ut.pcode='$project'
			 and (i.iowId=ut.iow and s.siowId=ut.siow) 
			 and ut.siow='$isRow[siowId]' group by ut.empId";
$empQuery=mysqli_query($db,$empSql);
while($empRow=mysqli_fetch_array($empQuery)){
	$empId=$empRow[empId];	
	$empInfo=empID2empInfo($empId);
	$empName=$empInfo["name"];
	$empDesignation=empId($empId,$empInfo[designation]);
	
	
	



		$overTime="";
		$idleTime="";
		$edate1=$edat1;
		$empType="H";
	
	
	
		$totalPresent=local_TotalPresentHr('2006-01-01',$edat1,$re[empId],'H',$project);
		$totalBreak="";	
			
// echo "empID:$empId, edate:$edate1, empType:$empType, loginProject:$project";
$dailyworkBreakt=dailyworkBreak($empId,$edate1,$empType,$project);
$toDaypresent=toDaypresent($empId,$edate1,$empType,$project)-$dailyworkBreakt;
$workt= dailywork($empId,$edate1,$empType,$project);
if(date('D',strtotime($edate1))=='Fri')
 $overtimet = $toDaypresent-(4*3600);
else 
	$overtimet = $toDaypresent-(8*3600);

if($overtimet<0) $overtimet=0;
$idlet=$toDaypresent-$workt;
if($idlet<0) $idlet=0;

   $totalPresent= sec2hms($toDaypresent/3600,$padHours=false);
   $work= sec2hms($workt/3600,$padHours=false);     
  $overtime=sec2hms($overtimet/3600,$padHours=false); 
  $idleTime=sec2hms($idlet/3600,$padHours=false); 
  $totalBreak=sec2hms($dailyworkBreakt/3600,$padHours=false); 
			
	
	
//		utilization & present information
			$utSql="select ut.stime, ut.etime, ut.details, i.iowCode, s.siowCode, s.siowName
			from emput as ut,iow as i,siow as s
			where  ut.edate='$edat1' 
			and ut.empId='$empId' 
			AND ut.empType='$empType'  AND ut.pcode='$project'
			 and (i.iowId=ut.iow and s.siowId=ut.siow) 
			 and ut.siow='$isRow[siowId]'
			";
// 			echo $utSql; exit;
			$workBreakSql="select ut.stime, ut.etime, ut.details from emput as ut
			where ut.edate='$edat1'
			and ut.empId='$empId'  
			AND ut.empType='$empType'  AND ut.pcode='$project' and (''=ut.iow and ''=ut.siow)";
// 			echo $utSql."<br>";
	$rowCounter=1;
			$UTquery=mysqli_query($db,$utSql);
			while($UTrow=mysqli_fetch_array($UTquery)){
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
?>
	<tr><td colspan="4" height="5"></td></tr>
			<tr>
				<td colspan="1" style="font-size:10px;" rowspan="<?php echo $rowCounter; ?>">
					<li>ID: <span style="color:#00f"><?php echo $empDesignation; ?></span>, Name: <span style="color:#00f"><?php echo $empName; ?></span></li>
					
					<li>Present: <span style="color:#00f"><?php echo $totalPresent.' Hrs'; echo $presentRow ? " ($presentRow)" : ""; ?></span>, Work: <span style="color:#00f"><?php echo $work.' Hrs'; ?></span></li>
					
					<li>Idle: <span style="color:#00f"><?php echo $idleTime.' Hrs'; ?></span>, Overtime: <span style="color:#00f"><?php echo $overtime.' Hrs,'; ?></span>, Workbreak: <span style="color:#00f"><?php echo $totalBreak.' Hrs';echo $workedBreakRow ? " ($workedBreakRow)" : ""; ?></span></li>
				</td>
		</tr>


	
		<?php foreach($workDetailsRows as $workRow){
				echo $workRow;
			}
		?>



	 <? $i++;
unset($workDetailsRows);
$workDetailsRows=array();
	} //while emp sql
		} //task while
	} //sort by task
} //date

	?>


</table>
</form>
<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>

<a href="./print/print_local_emputReport_b.php?project=<? echo $project;?>&edat=<? echo $edat;?>" target="_blank">Print</a>

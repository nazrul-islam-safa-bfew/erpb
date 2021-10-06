<? if($loginProject=='000'){?>
<form name="pro" method="post" >
<select name="project" id="project" onChange="location.href='index.php?keyword=local+emp+ut+report+l&project='+pro.project.options[document.pro.project.selectedIndex].value";>
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
<? } //loginProject

function printPresentRow($empId,$designation,$project,$edat1){
	global $db;
	if(isPresent($empId,$edat1) OR isHPresent($empId,$edat1)){


		$empName=empName($empId);
		$overTime="";
		$idleTime="";
		$edate1=$edat1;
		$empType="H";
		$empDesignation=empId($empId,$designation);

		$totalPresent=local_TotalPresentHr('2006-01-01',$edat1,$empId,'H',$project);
		$totalBreak="";	
			
// echo "empID:$empId, edate:$edate1, empType:$empType, loginProject:$project";
$dailyworkBreakt=dailyworkBreak($empId,$edate1,$empType,$project);
$toDaypresent=toDaypresent($empId,$edate1,$empType,$project)-$dailyworkBreakt;
$workt=dailywork($empId,$edate1,$empType,$project);
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
// 			echo $utSql."<br>"; exit;
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
					Present: <span style="color:#00f"><?php echo $totalPresent.' Hrs'; echo $presentRow ? " ($presentRow)" : ""; ?></span>, Work: <span style="color:#00f"><?php echo $work.' Hrs'; ?></span>, Idle: <span style="color:#00f"><?php echo $idleTime.' Hrs'; ?></span>, Overtime: <span style="color:#00f"><?php echo $overtime.' Hrs,'; ?></span>, Workbreak: <span style="color:#00f"><?php echo $totalBreak.' Hrs';echo $workedBreakRow ? " ($workedBreakRow)" : ""; ?></span>
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


if($project=='') $project=$loginProject;
?>
<? if($loginDesignation!='Site Engineer'){?>
<table width="90%" align="center">
<tr>	
	<td><input type="radio" onClick="location.href='./index.php?keyword=local+emp+ut+report+dd&project=<?php echo $project; ?>&edat=<?php echo $edat; ?>'" >Details by Date</td> 
	<td><input type="radio" checked>Log Report</td>
	<td><input type="radio"  onClick="location.href='./index.php?keyword=local+emp+ut+report+b&project=<?php echo $project; ?>&edat=<?php echo $edat; ?>'">Uptodate Summary</td>
	<td><input type="radio" onClick="location.href='./index.php?keyword=local+emp+ut+report+d&project=<?php echo $project; ?>&edat=<?php echo $edat; ?>'">Details by Employee</td>
	<td><input type="radio" onClick="location.href='./index.php?keyword=local+emp+ut+report+c&project=<?php echo $project; ?>&edat=<?php echo $edat; ?>'">Summary by Designation</td>
</tr>
</table>
<? }?>

<table align="center" width="95%" border="3" bgcolor="#FFFFFF"  bordercolor="CC9999" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td colspan="3"> 
 <form action="./index.php?keyword=local+emp+ut+report+l&project=<? echo $project;?>"  method="post">
 <select name="year" id="year">
	 <?php
	 $yearSelector=date("Y");
	 $showingYears=$yearSelector-3;
	 while($yearSelector > $showingYears){
		 echo '<option value="'.$yearSelector.'"';
		 if($year==$yearSelector)
			 echo ' selected ';
		 echo '>'.$yearSelector.'</option>';
		 $yearSelector--;
	 }
	 
	 ?>

 </select>
  <select name="month" size="1" id="monthSelector" >
   <option value="" multiple >All Month</option>
   <option value="01" <? if($month=='01') echo 'selected';?> >January</option>
   <option value="02" <? if($month=='02') echo 'selected';?>>February</option>
   <option value="03" <? if($month=='03') echo 'selected';?>>March</option>
   <option value="04" <? if($month=='04') echo 'selected';?>>April</option>
   <option value="05" <? if($month=='05') echo 'selected';?>>May</option>
   <option value="06" <? if($month=='06') echo 'selected';?>>June</option>
   <option value="07" <? if($month=='07') echo 'selected';?>>July</option>
   <option value="08" <? if($month=='08') echo 'selected';?>>August</option>
   <option value="09" <? if($month=='09') echo 'selected';?>>September</option>
   <option value="10" <? if($month=='10') echo 'selected';?>>October</option>
   <option value="11" <? if($month=='11') echo 'selected';?>>November</option>
   <option value="12" <? if($month=='12') echo 'selected';?>>December</option>
</select>
	 Sort by 
	 <select name="sortBy" id="sortBy">
	 	 <option value="employee" <?php echo $sortBy=="employee" ? " selected " : ""; ?>>Employee</option>
		 <option value="designation" <?php echo $sortBy=="designation" ? " selected " : ""; ?>>Designation</option>
		 <option value="task" <?php echo $sortBy=="task" ? " selected " : ""; ?>>Task</option>
		 <option value="date" <?php echo $sortBy=="date" ? " selected " : ""; ?>>Date</option>
	 </select>

<select size='1' id="TheSelector">
	
</select>
	 <script>
		 $(document).ready(function(){
			 var empRow='<option value="">All Employee</option>';
			 var desRow='<option value="">All Designation</option>';
			 var taskRow='<option value="">All Task</option>';
			 
			 var year=$("#year");
			 var url="./employee/empSort.php";
			 var projectCode=$("#project");
			 var sortByCode=$("#sortBy");
			 var selectorCode=$("#TheSelector");
			 var monthSelectorCode=$("#monthSelector");
			 
			 sortByCode.change(function(){
				 
			 	 var theDate=year.val()+"-"+monthSelectorCode.val()+"-%";
			 	 if(!monthSelectorCode.val())theDate=""; //blank if selected all month
 				 if(sortByCode.val()=="employee")selectorCode.attr("name",'empId').html(empRow);
 				 if(sortByCode.val()=="designation")selectorCode.attr("name",'desId').html(desRow);
 				 if(sortByCode.val()=="task")selectorCode.attr("name",'taskId').html(taskRow);
				 
				 selectorCode.find("option[value!='']").each(function(){$(this).remove();});
				 		$.get(url,{project:projectCode.val(),sortBy:sortByCode.val(),employeeSelector:selectorCode.val(),monthSelector:theDate},function(data){
					  if(data){
						  selectorCode.append(data);
						}
					 });
			 });
			 
			 sortByCode.trigger("change");
		 });
	 </script>
<input type="submit" value="Go">
	 <span><i>Use Ctrl to choose multiple items.</i></span>
</form>
	 


 </td>
 <td colspan="2" align="right" valign="top"><font class='englishhead'>employee utilization report</font></td>
</tr>
	

<?php 
	$lastMonth=1;
	$todat=todat();
	$currentYear=date("Y");
	$currentDay=date("d");
	$currentMonth=date("m");
if($sortBy=="employee"){
	$empSQL="select a.empId,e.designation,i.itemDes,e.name,a.stime,a.etime from attendance as a,employee as e,itemlist as i where e.empId=a.empId and e.location='$project' and i.itemCode=e.designation  AND i.itemCode >= '87-00-000' AND i.itemCode < '98-01-000'   ";
		
	if($empId!=""){$empSQL.=" and e.empId='$empId' ";}
		
	$empSQL.=" group by a.empId,e.designation";
	
	$empQ=mysqli_query($db,$empSQL);
	while($empRow=mysqli_fetch_array($empQ)){
		$empId=$empRow[empId];
		$designation=$empRow[designation];
		$designationDes=$empRow[itemDes];
		$empDesignation=empId($empId,$empRow[designation]);	
		echo '<tr bgcolor="#CC9999" style="border: 2px solid #fff;">
			<td align="center" colspan="5" height="40"><font class="englishhead" style="font-size: 15px;color: #000;font-weight: 800;">ID: '.$empDesignation." ".$empRow[name].", ".$designationDes.'</font></td>
		</tr>';
		if($month==""){$startMonth=12;}
		else{$startMonth=$month;$lastMonth=$month;}
			
			for($startMonth;$startMonth>=$lastMonth;$startMonth--){ //month loop
				
// 					month locking
					if($currentYear==$year){
						if($currentMonth<$startMonth)
							continue;
					}
				
				$fullMonth=date("Y-m-d",strtotime($year."-".$startMonth."-01"));
				echo '<tr bgcolor="#ff9797" style="border: 2px solid #fff;">
				<td align="center" colspan="5"><font class="englishhead" style="font-size:13px; font-weight:800;">'.date("F",strtotime($fullMonth)).'</font></td>
				</tr>';

// 			========================day
				$lastDay=date("t",strtotime($fullMonth));
				for($ld=$lastDay;$ld>=1;$ld--){
					
// 					day locking
					if($currentYear==$year){
						if($currentMonth>$month)
							if($currentDay<$ld)
								continue;
					}
					
					$theDate=date("Y-m-$ld",strtotime($fullMonth));
					echo '<tr bgcolor="#ff8080" style="border: 2px solid #fff;">
					<td colspan="5"><font class="englishhead" style="font-size:11px;">'.date("D d/m/Y",strtotime($theDate)).'</font></td>
					</tr>';
					printPresentRow($empId,$designation,$project,$theDate);
				} // day
			} //12 month for 
	} // month selected
	
	
	
	
	
	
	
	
	
	
	
	
// 	===========================================designation
	
}elseif($sortBy=="designation"){
		
	$desSQL="select e.designation,i.itemDes from attendance as a,employee as e,itemlist as i where e.empId=a.empId and e.location='$project' and i.itemCode=e.designation  AND itemCode >= '87-00-000' AND itemCode < '98-01-000'  ";
		
	if($desId!=""){$desSQL.=" and e.designation='$desId' ";}
		
	$desSQL.=" group by e.designation";
	
	$desQ=mysqli_query($db,$desSQL);
	while($desRow=mysqli_fetch_array($desQ)){
		$designation=$desRow[designation];
		$designationDsc=$desRow[itemDes];
		echo '<tr bgcolor="#CC9999" style="border: 2px solid #fff;">
			<td align="center" colspan="5" height="40"><font class="englishhead" style="font-size: 15px;color: #000;font-weight: 800;">DESIGNATION: '.$designation." ".$designationDsc.'</font></td>
		</tr>';
// 		============================================== employee 
	$empSQL="select a.empId,e.designation,i.itemDes,e.name from attendance as a,employee as e,itemlist as i where e.empId=a.empId and e.location='$project' and i.itemCode=e.designation group by a.empId,e.designation";
		
	$empQ=mysqli_query($db,$empSQL);
	while($empRow=mysqli_fetch_array($empQ)){	
		
		$empId=$empRow[empId];
		$designation=$empRow[designation];
		$empDesignation=empId($empId,$empRow[designation]);	
		if($month==""){$startMonth=12;}
		else{$startMonth=$month;$lastMonth=$month;}
			
			for($startMonth;$startMonth>=$lastMonth;$startMonth--){ //month loop
				
// 					month locking
					if($currentYear==$year){
						if($currentMonth<$startMonth)
							continue;
					}
				
				$fullMonth=date("Y-m-d",strtotime($year."-".$startMonth."-01"));
				echo '<tr bgcolor="#ff9797" style="border: 2px solid #fff;">
				<td align="center" colspan="5"><font class="englishhead" style="font-size:13px; font-weight:800;">'.date("F",strtotime($fullMonth)).'</font></td>
				</tr>';

// 			========================day
				$lastDay=date("t",strtotime($fullMonth));
				for($ld=$lastDay;$ld>=1;$ld--){
					
// 					day locking
						if($currentMonth>$month)
							if($currentDay<$ld)
								continue;
					
					$theDate=date("Y-m-$ld",strtotime($fullMonth));
					echo '<tr bgcolor="#ff8080" style="border: 2px solid #fff;">
					<td colspan="5"><font class="englishhead" style="font-size:11px;">'.date("D d/m/Y",strtotime($theDate)).'</font></td>
					</tr>';
					printPresentRow($empId,$designation,$project,$theDate);
				} // day
			} //12 month for 
		}//Employee sql
	} // month selected
	
	
	
	
	
	
// 	=======================================================task
}elseif($sortBy=="task"){
			
	$taskSQL="select iowId,iowDes from iow where iowProjectCode='$project'  ";
		
	if($desId!=""){$taskSQL.=" and iowId='$taskId' ";}
		
	$taskSQL.=" group by iowId";
	
	$taskQ=mysqli_query($db,$taskSQL);
	while($taskRow=mysqli_fetch_array($taskQ)){
		$taskID=$taskRow[iowId];
		$taskDsc=$taskRow[iowDes];
		echo '<tr bgcolor="#CC9999" style="border: 2px solid #fff;">
			<td align="center" colspan="5" height="40"><font class="englishhead" style="font-size: 15px;color: #000;font-weight: 800;">TASK: '.$taskID." ".$taskDsc.'</font></td>
		</tr>';
// 		============================================== employee 
	$empSQL="select a.empId,e.designation,i.itemDes,e.name from attendance as a,employee as e,itemlist as i where e.empId=a.empId and e.location='$project' and i.itemCode=e.designation group by a.empId,e.designation";
		
	$empQ=mysqli_query($db,$empSQL);
	while($empRow=mysqli_fetch_array($empQ)){	
		
		$empId=$empRow[empId];
		$designation=$empRow[designation];
		$empDesignation=empId($empId,$empRow[designation]);	
		if($month==""){$startMonth=12;}
		else{$startMonth=$month;$lastMonth=$month;}
			
			for($startMonth;$startMonth>=$lastMonth;$startMonth--){ //month loop
				
// 					month locking
					if($currentYear==$year){
						if($currentMonth<$startMonth)
							continue;
					}
				
				$fullMonth=date("Y-m-d",strtotime($year."-".$startMonth."-01"));
				echo '<tr bgcolor="#ff9797" style="border: 2px solid #fff;">
				<td align="center" colspan="5"><font class="englishhead" style="font-size:13px; font-weight:800;">'.date("F",strtotime($fullMonth)).'</font></td>
				</tr>';

// 			========================day
				$lastDay=date("t",strtotime($fullMonth));
				for($ld=$lastDay;$ld>=1;$ld--){
					
// 					day locking
						if($currentMonth>$month)
							if($currentDay<$ld)
								continue;
					
					$theDate=date("Y-m-$ld",strtotime($fullMonth));
					echo '<tr bgcolor="#ff8080" style="border: 2px solid #fff;">
					<td colspan="5"><font class="englishhead" style="font-size:11px;">'.date("D d/m/Y",strtotime($theDate)).'</font></td>
					</tr>';
					printPresentRow($empId,$designation,$project,$theDate);
				} // day
			} //12 month for 
		}//Employee sql
	} // month selected
} //else if task
?>
	
	



</table>
<a href="./charts/mycharts.php?project=<? echo $project;?>&month=<? echo $month;?>&empId=<? echo $empId;?>" target="_blank">Graph</a>
<a href="./print/print_local_emputReport_d.php?project=<? echo $project;?>&month=<? echo $month;?>&empId=<? echo $empId;?>" target="_blank">Print</a>
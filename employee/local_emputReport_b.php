<? if($loginProject=='000'){?>
<form name="pro" method="post" >
<select name="project" onChange="location.href='index.php?keyword=local+emp+ut+report+b&project='+pro.project.options[document.pro.project.selectedIndex].value";>
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
	<td><input type="radio" onClick="location.href='./index.php?keyword=local+emp+ut+report+dd&project=<?php echo $project; ?>&edat=<?php echo $edat; ?>'" >Details by Date</td> 
<!-- 	<td><input type="radio" onClick="location.href='./index.php?keyword=local+emp+ut+report+l&project=<?php echo $project; ?>&edat=<?php echo $edat; ?>'" >Log Report</td> -->
<td><input type="radio" checked>Uptodate Summary</td>
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
<form name="att" action="./index.php?keyword=local+emp+ut+report+b&e=<? echo $e;?>&project=<? echo $project;?>" method="post">
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
      <input type="text" maxlength="10" name="edat" value="<? echo $edat;?>"> <a id="anchor" href="#"
   onClick="cal.select(document.forms['att'].edat,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
	  <input type="submit" name="go" value="Go">
	  </td> 
 <td align="right" colspan="3" ><font class='englishhead'>human utilization</font></td>
</tr>
<tr>
  <th height="30">Employee Id</th>
  <th>Employee Name</th>  
  <th >at <? echo $edat;?></th>  
  <th >Monthly total <br>till <? echo $edat;?></th>    
  <th>Project total <br>till <? echo $edat;?></th>    
</tr>
<? 
//Head office employee

include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	


$sqlquery="SELECT DISTINCT attendance.empId,employee.designation FROM attendance,employee 
where attendance.location='$project' AND attendance.edate<='$edat1' 
AND action in('P','HP') AND attendance.empId=employee.empId 
AND employee.salaryType LIKE 'Wages%' ORDER by designation,empId ASC";// limit 0,3";
//echo $sqlquery;

 $sql= mysqli_query($db, $sqlquery);
 $i=1;

 $month=date('m',strtotime($edat1));
$year=date('Y');
$from="$year-$month-01";

 while($re=mysqli_fetch_array($sql)){


 ?>
 <tr <? if($i%2==0) echo "bgcolor=#EEEEEE";?> >
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

$sqlquery1="SELECT * FROM attendance 
where attendance.location='$project' 
AND attendance.edate BETWEEN '$from' AND '$edat1' 
AND action in('P','HP') AND attendance.empId= $re[empId]";
//echo $sqlquery1;

 $sql1= mysqli_query($db, $sqlquery1);
 while($re1=mysqli_fetch_array($sql1)){
 
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

 $sql1= mysqli_query($db, $sqlquery1);
 while($re1=mysqli_fetch_array($sql1)){
 
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
</form>
<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>

<a href="./print/print_local_emputReport_b.php?project=<? echo $project;?>&edat=<? echo $edat;?>" target="_blank">Print</a>

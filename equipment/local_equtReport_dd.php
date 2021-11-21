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
<td><input type="radio" onClick="location.href='./index.php?keyword=local+eq+ut+report+b&project=<?php echo $project; ?>&edat=<?php echo $edat; ?>'" >Details by date</td>
<td><input type="radio" checked>Uptodate Summery</td>
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
<form name="att" action="./index.php?keyword=local+eq+ut+report+dd&e=<? echo $e;?>&project=<? echo $project;?>&a=<? echo $a;?>" method="post">
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
      <input type="text" maxlength="10" name="edat" value="<? echo $edat;?>"> <a id="anchor" href="#"   onClick="cal.select(document.forms['att'].edat,'anchor','dd/MM/yyyy'); return false;"   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
   <input type="hidden" name="a" value="<? echo $a;?>">
  <input type="submit" name="go" value="Go">
	  </td> 
 <td align="right" colspan="3" ><font class='englishhead'>equipment utilization</font></td>
</tr>
<tr>
	<th height="30" width="100">Equipment Id</th>
	<th >Equipment Name</th>  
	<th  >at <? echo $edat;?></th>  
	<th  >Monthly total <br>till <? echo $edat;?></th>    
	<th  >Project total <br>till <? echo $edat;?></th>    
</tr>

<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>


<? 
//Head office employee

include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);



$sqlquery="SELECT itemCode FROM eqattendance where location='$project' AND eqattendance.edate='$edat1' AND action in('P','HP')";
$sql= mysqli_query($db, $sqlquery);
$total_result=mysql_num_rows($sql);
$total_per_page=10;

if($page<=0)
	{
	$page=1;
	}
$curr=($page-1)*$total_per_page;

$sqlquery="SELECT eqattendance.* FROM eqattendance".
" where eqattendance.location='$project' AND eqattendance.edate='$edat1'".
" AND action in('P','HP') /*and  eqattendance.itemCode='54-15-000'*/ ORDER by itemCode ASC
/*LIMIT $curr,$total_per_page*/";
// 	echo $sqlquery;
 $sql= mysqli_query($db, $sqlquery);

 $i=1;

$month=date('m',strtotime($edat1));
$year=date('Y');
$from="$year-$month-01";

	
if($project!='000' || $project!='002' || $project!='007' || $project!='004')
 while($re=mysqli_fetch_array($sql)){
 ?>
 <tr <? if($i%2==0) echo "bgcolor=#EEEEEE";?> >
      <td width="100">
	  <?
 if($re[eqId]{0}=='A')  { echo $eqIdFull=eqpId_local($re[eqId],$re[itemCode]); $type='L';}
		else {echo $eqIdFull=eqpId($re[eqId],$re[itemCode]); $type='H'; }?>
		</td>
  <td><?
	$temp=itemDes($re[itemCode]); echo $temp[des].', '.$temp[spc];
	
	$itemSpec=getEquipmentDetails($re[eqId],$re[itemCode]);
	echo "<br>";
	
	$gED6=getEquipmentDetailsByRquirement(null,null,6,$itemSpec);
	if($gED6)echo $gED6."; ";
	 
	$gED0=getEquipmentDetailsByRquirement(null,null,0,$itemSpec);
	if($gED0)echo $gED0."; ";
	 
	$gED7=getEquipmentDetailsByRquirement(null,null,7,$itemSpec);
	if($gED7)echo " YoM: ".$gED7;
	?>
	<?  $totalPresent = eqTotalPresentHr('2013-01-01',$edat1,$re[eqId],$re[itemCode],$type,$project);
	   echo "<p align=right style='margin:0;'>Worked : <font class='out'>$totalPresent </font>days<br>";
	 /* 
	 Equipment Meter: 50:00 hrs
	 ERP Meter: hrs.
	 Milage: km.*/
	 
	$measuringUnit=getEQmeasureUnit($re[itemCode]);
	
	if($measuringUnit=="km" || $measuringUnit=="mh"){
		
		$accd30=getEqAccConsumtion($edat1,30,$re[itemCode],$re[eqId]); //km 
		$accd90=getEqAccConsumtion($edat1,90,$re[itemCode],$re[eqId]); //km 
		$accd180=getEqAccConsumtion($edat1,180,$re[itemCode],$re[eqId]); //km 

		
		
		if($accd30){
			$rateMode=true;
			$d30=get_machine_km_hr($edat1,30,$project,$re[itemCode],$re[eqId],$rateMode); //km
		}
		else{
			$rateMode=false;
			$d30=get_machine_km_hr($edat1,30,$project,$re[itemCode],$re[eqId]); //km
		}
			
		if($accd30 && $d30)
			$d30=($accd30+$d30)/2;
		elseif($accd30 && !$d30)
			$d30=$accd30;
		
		if($accd90){
			$rateMode=true;
			$d90=get_machine_km_hr($edat1,90,$project,$re[itemCode],$re[eqId],$rateMode); //km
		}
		else{
			$rateMode=false;
			$d90=get_machine_km_hr($edat1,90,$project,$re[itemCode],$re[eqId]); //km
		}
			
		if($accd90 && $d90)
			$d90=($accd90+$d90)/2;
		elseif($accd90 && !$d90)
			$d90=$accd90;
		
		
		
		if($accd180){
			$rateMode=true;
			$d180=get_machine_km_hr($edat1,180,$project,$re[itemCode],$re[eqId],$rateMode); //km
		}
		else{
			$rateMode=false;
			$d180=get_machine_km_hr($edat1,180,$project,$re[itemCode],$re[eqId]); //km
		}
			
		if($accd180 && $d180)
			$d180=($accd180+$d180)/2;
		elseif($accd180 && !$d180)
			$d180=$accd180;
		
	
	 if($measuringUnit=="mh"){

		
			$d30=sec2hms($d30);
			$d90=sec2hms($d90);
			$d180=sec2hms($d180);
		 
	   echo " <b>Average Fuel Consumption:</b> <a href='./equipment/eqReport.php?month=1&assetID=$re[eqId]&itemCode=$re[itemCode]&pcode=$project' target='_blank'>1 month</a>: <font color='#00f'>$d30</font> $MesureUnit/hrs.<br> <a href='./equipment/eqReport.php?month=3&assetID=$re[eqId]&itemCode=$re[itemCode]&pcode=$project' target='_blank'>3 months</a>: <font color='#00f'>$d90</font> $MesureUnit/hrs.<br> <a href='./equipment/eqReport.php?month=6&assetID=$re[eqId]&itemCode=$re[itemCode]&pcode=$project' target='_blank'>6 months</a>: <font color='#00f'>$d180</font> $MesureUnit/hrs.</p>";		
	}else{
		 	$MesureUnit=$rateMode ? "Tk." : "Ltr.";  //depend upto amount or ltr or tk.
	   echo " <b>Average Fuel Consumption:</b> <a href='./equipment/eqReport.php?month=1&assetID=$re[eqId]&itemCode=$re[itemCode]&pcode=$project' target='_blank'>1 month</a>: <font color='#00f'>$d30</font> $MesureUnit/$measuringUnit.<br> <a href='./equipment/eqReport.php?month=3&assetID=$re[eqId]&itemCode=$re[itemCode]&pcode=$project' target='_blank'>3 months</a>: <font color='#00f'>$d90</font> $MesureUnit/$measuringUnit.<br> <a href='./equipment/eqReport.php?month=6&assetID=$re[eqId]&itemCode=$re[itemCode]&pcode=$project' target='_blank'>6 months</a>: <font color='#00f'>$d180</font> $MesureUnit/$measuringUnit.</p>"; 
	 }
	}elseif($measuringUnit=="ue"){
		
		$accd30=getEqAccConsumtion($edat1,30,$re[itemCode],$re[eqId],$measuringUnit); //ue 
		$accd90=getEqAccConsumtion($edat1,90,$re[itemCode],$re[eqId],$measuringUnit); //ue 
		$accd180=getEqAccConsumtion($edat1,180,$re[itemCode],$re[eqId],$measuringUnit); //ue 
		
		if($accd30){
			$rateMode=true;
			$d30=get_erp_per_hr_ltr($re[eqId],$re[itemCode],$edat1,30,$project,$rateMode); //issue and erp hr
		}
		else{
			$rateMode=false;
			$d30=get_erp_per_hr_ltr($re[eqId],$re[itemCode],$edat1,30,$project); //issue and erp hr
		}
			
		if($accd30 && $d30)
			$d30=($accd30+$d30)/2;
		elseif($accd30 && !$d30)
			$d30=$accd30;
		
		
		
		
		if($accd90){
			$rateMode=true;
			$d90=get_erp_per_hr_ltr($re[eqId],$re[itemCode],$edat1,90,$project,$rateMode); //issue and erp hr
		}
		else{
			$rateMode=false;
			$d90=get_erp_per_hr_ltr($re[eqId],$re[itemCode],$edat1,90,$project); //issue and erp hr
		}
		if($accd90 && $d90)
			$d90=($accd90+$d90)/2;
		elseif($accd90 && !$d90)
			$d90=$accd90;
		

		
		if($accd180){
			$rateMode=true;
			$d180=get_erp_per_hr_ltr($re[eqId],$re[itemCode],$edat1,180,$project,$rateMode); //issue and erp hr
		}
		else{
			$rateMode=false;
			$d180=get_erp_per_hr_ltr($re[eqId],$re[itemCode],$edat1,180,$project); //issue and erp hr
		}
			
		if($accd180 && $d180)
			$d180=($accd180+$d180)/2;
		elseif($accd180 && !$d180)
			$d180=$accd180;
		  
		 	$MesureUnit=$rateMode ? "Tk." : "Ltr.";  //depend upto amount or ltr or tk.
		
			$d30=sec2hms($d30);
			$d90=sec2hms($d90);
			$d180=sec2hms($d180);
		
	   echo " <b>Average Fuel Consumption:</b> <a href='./equipment/eqReport.php?month=1&assetID=$re[eqId]&itemCode=$re[itemCode]&pcode=$project' target='_blank'>1 month</a>: <font color='#00f'>$d30</font> $MesureUnit/hrs.<br> <a href='./equipment/eqReport.php?month=3&assetID=$re[eqId]&itemCode=$re[itemCode]&pcode=$project' target='_blank'>3 months</a>: <font color='#00f'>$d90</font> $MesureUnit/hrs.<br> <a href='./equipment/eqReport.php?month=6&assetID=$re[eqId]&itemCode=$re[itemCode]&pcode=$project' target='_blank'>6 months</a>: <font color='#00f'>$d180</font> $MesureUnit/hrs.</p>";
	}
	 
	 		$d30="";
			$d90="";
			$d180="";

	   ?>	  
	  </td>  
	<td>
   <? 
	$dailyworkBreakt=eq_dailyworkBreak($re[eqId],$re[itemCode],$edat1,$type,$project);
    $dailyBreakDownt=eq_dailyBreakDown($re[eqId],$re[itemCode],$edat1,$type,$project);
	$toDaypresent=eq_toDaypresent($re[eqId],$re[itemCode],$edat1,$type,$project);
	
    $toDaypresent=$toDaypresent-$dailyworkBreakt;	
	
	$workt= eq_dailywork($re[eqId],$re[itemCode],$edat1,$type,$project);
	$overtimet = $toDaypresent-8*3600;
	if($overtimet<0) $overtimet=0;
	$idlet=$toDaypresent-$workt-$dailyBreakDownt;
	  if($idlet<0) $idlet=0;
      
    ?>
	<? echo ' Present: '.sec2hms($toDaypresent/3600,$padHours=true).' hrs.';?><br>
	<? echo '  Worked: '.sec2hms($workt/3600,$padHours=true).' hrs.';?><br>
	<? echo ' Overtime: '.sec2hms($overtimet/3600,$padHours=true).' hrs.';?><br>
	<? echo ' BreakDown: '.sec2hms($dailyBreakDownt/3600,$padHours=true).' hrs.';?><br>		
    <? echo ' Idle '.sec2hms($idlet/3600,$padHours=true).' hrs.';?>
	</td>
	<td>
<? 
$presentTotal=0;
$overtimeTotal=0;
$workedTotal=0;
$idleTotal=0;
$idleTotalp=0;
$breakDownTotal=0;
$breakDownTotalp=0;
$overtimeTotalp=0;
$workedTotalp=0;

$sqlquery1="SELECT eqattendance.* FROM eqattendance".
" where eqattendance.location='$project'".
"AND eqattendance.edate BETWEEN '$from' AND '$edat1'".
" AND action in('P','HP')  AND eqattendance.eqId='$re[eqId]'  AND eqattendance.itemCode='$re[itemCode]'";
//echo $sqlquery1;

 $sql1= mysqli_query($db, $sqlquery1);
 while($re1=mysqli_fetch_array($sql1)){

  $dailyworkBreakt=eq_dailyworkBreak($re[eqId],$re[itemCode],$re1[edate],$type,$project);
  $dailyBreakDownt=eq_dailyBreakDown($re[eqId],$re[itemCode],$re1[edate],$type,$project);	
	$toDaypresent=eq_toDaypresent($re[eqId],$re[itemCode],$re1[edate],$type,$project);
	
  $toDaypresent=$toDaypresent-$dailyworkBreakt;
	
	$workt= eq_dailywork($re[eqId],$re[itemCode],$re1[edate],$type,$project);

if(date('D',strtotime($re1[edate]))=='Fri')
 $overtimet = $toDaypresent-(4*3600);
else 
	$overtimet = $toDaypresent-(8*3600);


	if($overtimet<0) $overtimet=0;
	$idlet=$toDaypresent-$workt-$dailyBreakDownt;
	if($idlet<0) $idlet=0;  

$presentTotal=$presentTotal+$toDaypresent;   
$overtimeTotal=$overtimeTotal+$overtimet;
$workedTotal=$workedTotal+$workt;
$breakDownTotal=$breakDownTotal+$dailyBreakDownt; 
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
	$breakDownTotalp=number_format(($breakDownTotal*100)/($presentTotal));
	$idleTotalp=number_format(($idleTotal*100)/($presentTotal));
}
	//echo "<br>presentTotal:$presentTotal--idleTotal:$idleTotal<br>";
		
	$presentTotal=sec2hms($presentTotal/3600,$padHours=false);
	$overtimeTotal=sec2hms($overtimeTotal/3600,$padHours=false);
	$workedTotal=sec2hms($workedTotal/3600,$padHours=false);
	$breakDownTotal=sec2hms($breakDownTotal/3600,$padHours=false);	
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
	<? echo 'BreakDown: '.$breakDownTotal.' hrs.';
	   echo " (<font class=out>$breakDownTotalp %</font>)"; 
	?> <br>
    <? echo 'Idle: '.$idleTotal.' hrs.';
	   echo " (<font class=out>$idleTotalp %</font>)"; 	
	?>
	</td>
	<td>	
<? 
$presentTotal=0;
$workedTotal=0;
$workedTotalp=0;
$idleTotal=0;
$idleTotalp=0;
$breakDownTotal=0;
$breakDownTotalp=0;
$overtimeTotal=0;
$overtimeTotalp=0;


$sqlquery1="SELECT eqattendance.* FROM eqattendance".
" where eqattendance.location='$project'".
"AND eqattendance.edate <='$edat1'".
" AND action in('P','HP')  AND eqattendance.eqId='$re[eqId]'  AND eqattendance.itemCode='$re[itemCode]'";
//echo $sqlquery1;

 $sql1= mysqli_query($db, $sqlquery1);
 while($re1=mysqli_fetch_array($sql1)){

  $dailyworkBreakt=eq_dailyworkBreak($re[eqId],$re[itemCode],$re1[edate],$type,$project);
  $dailyBreakDownt=eq_dailyBreakDown($re[eqId],$re[itemCode],$re1[edate],$type,$project);	
	$toDaypresent=eq_toDaypresent($re[eqId],$re[itemCode],$re1[edate],$type,$project);
	
    $toDaypresent=$toDaypresent-$dailyworkBreakt;	
	
	$workt= eq_dailywork($re[eqId],$re[itemCode],$re1[edate],$type,$project);
//echo $workt.">>";
if(date('D',strtotime($re1[edate]))=='Fri')
 $overtimet = $toDaypresent-(4*3600);
else 
	$overtimet = $toDaypresent-(8*3600);


	if($overtimet<0) $overtimet=0;
	$idlet=$toDaypresent-$workt-$dailyBreakDownt;
	  if($idlet<0) $idlet=0;	  
//echo $idlet."::>>".$re[itemCode]."//";
$presentTotal=$presentTotal+$toDaypresent;   
$overtimeTotal=$overtimeTotal+$overtimet;
$workedTotal=$workedTotal+$workt;
$breakDownTotal=$breakDownTotal+$dailyBreakDownt; 
$idleTotal=$idleTotal+$idlet; 

//echo "<br>date:$re1[edate]= Present:$toDaypresent--worked:$workt--overtime:$overtimet--idle:$idlet***presentTotal:$presentTotal **<br>";
$toDaypresent=0;
$overtimet=0;
$workt=0;
$idlet=0;
$breakDownt=0;

}
?>	

	<? 
if($presentTotal){
	$workedTotalp=number_format(($workedTotal*100)/($presentTotal));
	$overtimeTotalp=number_format(($overtimeTotal*100)/($presentTotal));
	$breakDownTotalp=number_format(($breakDownTotal*100)/($presentTotal));
	$idleTotalp=number_format(($idleTotal*100)/($presentTotal));
}
//echo "<br>presentTotal:$presentTotal--idleTotal:$idleTotal<br>";

	$presentTotal=sec2hms($presentTotal/3600,$padHours=false);
	$overtimeTotal=sec2hms($overtimeTotal/3600,$padHours=false);
	$workedTotal=sec2hms($workedTotal/3600,$padHours=false);
	$breakDownTotal=sec2hms($breakDownTotal/3600,$padHours=false);	
	$idleTotal=sec2hms($idleTotal/3600,$padHours=false);
	//echo "<br>presentTotal:$presentTotal--idleTotal:$idleTotal<br>";
	?>


	<? echo 'Present: '.$presentTotal.' hrs.';
	//   echo " (<font class=out>$presentTotalp %</font>) ";
	?><br>
	<? echo 'Worked: '.$workedTotal.' hrs.';
	   echo " (<font class=out>$workedTotalp %</font>)"; 
	?><br>
	<? echo 'Overtime: '.$overtimeTotal.' hrs.';
	   echo " (<font class=out>$overtimeTotalp %</font>)";
	?> <br>
	<? echo 'BreakDown: '.$breakDownTotal.' hrs.';
	   echo " (<font class=out>$breakDownTotalp %</font>)"; 
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

 } //while
	
	if($project=='000' || $project=='002' || $project=='007' || $project=='004')
	include("./equipment/local_equtReport_dd_ho.php");
	
	?>

<!-- -->
	
	

</table>
</form>
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
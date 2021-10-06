	<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>

<?
$format="Y-m-j";
$edat1 = formatDate($edat,$format);
?>
<form name="att" action="./employee/employeeAttendance.sql.php" method="post">
<table align="center" width="98%" border="3"  bordercolor="CC9999" cellpadding="2" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999"> 
<td align="left">
	<select name="pcode">
		<?php
		$loginDesignation=$_SESSION['loginDesignation'];	 	
		
		if($loginDesignation!="Chairman & Managing Director")
			$project=$loginProject;
		else
			$project=$pcode;
		
		if($loginDesignation=="Chairman & Managing Director"){
			$pcodeSql="select pcode,pname from project order by pcode asc";
			$q=mysqli_query($db,$pcodeSql);
			while($pcodeRow=mysqli_fetch_array($q))
				echo '<option '.($project==$pcodeRow[pcode] ? " selected " : "").' value="'.$pcodeRow[pcode].'">'.$pcodeRow[pcode].' - '.$pcodeRow[pname].'</option>';
		}			
		?>
	</select>
	
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
      <input type="button" name="go" value="Go" onClick="location.href='./index.php?keyword=eq+utilization+report+ws&e=<? echo $e;?>&edat='+document.att.edat.value+'&pcode='+document.att.pcode.value">
	  </td> 
 <td align="right" colspan="7" ><font class='englishhead'>equipment utilization</font></td>
</tr>
<? if($edat){?>
<tr>
  <th>Equipment Id</th>
  <th>Equipment Details</th>  
  <th colspan="5">Today</th>  
</tr>

<? 


include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	



if($loginDesignation=="Chairman & Managing Director")
	$sqlquery="SELECT eqattendance.* FROM eqattendance".
	" where eqattendance.location='$pcode' AND eqattendance.edate='$edat1'".
	" AND action in('P','HP') ORDER by itemCode ASC ";
else
	$sqlquery="SELECT eqattendance.* FROM eqattendance".
	" where eqattendance.location='002' AND eqattendance.edate='$edat1'".
	" AND action in('P','HP') ORDER by itemCode ASC ";

/*
$sqlquery="SELECT * from eqproject where pCode='$loginProject'".
" AND  status>=1 AND (('$edat1' BETWEEN receiveDate AND edate) OR ('$edat1' >= receiveDate AND edate='0000-00-00' ))".
" ORDER by itemCode,assetId ASC ";
*/
//echo $sqlquery;
 $sql= mysqli_query($db, $sqlquery);
 while($re=mysqli_fetch_array($sql)){ 
//  $type=eqType($re[assetId]);
  $type='H'
?>
<tr  <? echo " bgcolor=$bg";?>>
      <td align="center"><?  
			echo eqpId($re[eqId],$re[itemCode]);?> 
		</td>
      <td><?  $temp=itemDes($re[itemCode]); echo $temp[des].', '.$temp[spc];?>
		<? if($t==1)echo '<br><font class=out>Dispatch on '.myDate($planDispatchDate).'</font>';?>	  
	   </td>  
   <? 

//   echo "Pcode:$project,eqID:$re[eqId],edate:$edat1,type:$type<br>";
	$dailyworkBreakt=eq_dailyworkBreak($re[eqId],$re[itemCode],$edat1,$type,$project);
    $dailyBreakDown=eq_dailyBreakDown($re[eqId],$re[itemCode],$edat1,$type,$project);
	
	$toDaypresent=eq_toDaypresent($re[eqId],$re[itemCode],$edat1,$type,$project);
	
    $toDaypresent=$toDaypresent-$dailyworkBreakt;	
	
	$workt= eq_dailywork($re[eqId],$re[itemCode],$edat1,$type,$project);
	$overtimet = $toDaypresent-8*3600;
	if($overtimet<0) $overtimet=0;
	$idlet=$toDaypresent-$workt-$dailyBreakDown;
	  if($idlet<0) $idlet=0;
  
    ?>
	  <td><? echo ' Present: '.sec2hms($toDaypresent/3600,$padHours=true);?></td>
	  <td><? echo ' Overtime: '.sec2hms($overtimet/3600,$padHours=true);?></td>
	<?
	 if($loginDesignation!="Chairman & Managing Director")
	 if($e==1){ ?>
	<td><a target="_blank" href="./employee/empUtilizationReport.php?&empId=<? echo $re[empId];?>&empD=<? echo $re[designation];?>&empType=H&edate=<? echo $edat;?>"><? echo '  Worked: '.sec2hms($workt/3600,$padHours=true);?></a></td>	
	 <? } else{?>
	  <td><a target="_blank" href="./equipment/eqUtilization_ws.php?&eqId=<? echo $re[assetId];?>&itemCode=<? echo $re[itemCode];?>&eqType=<? echo $type;?>&edate=<? echo $edat;?>&posl=<? echo $re[posl];?>"><? echo '  Worked: '.sec2hms($workt/3600,$padHours=true);?></a></td>
     <? }
	else{
		echo ' <td> Worked: '.sec2hms($workt/3600,$padHours=true)."</td>";
	}
	?>
	<td>Breakdown: <? echo sec2hms($dailyBreakDown/3600,$padHours=true);?></td>
	<td>Idle: <? echo sec2hms($idlet/3600,$padHours=true);?></td>

 </tr>
 <? 
 } //while
 
 ?>
 
<? }//if edate?>
<!-- -->

</table>
</form>
<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
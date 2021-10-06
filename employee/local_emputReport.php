	<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>

<? $format="Y-m-j";
$edat1 = formatDate($edat,$format);
?>
<form name="att" action="#" method="post">
<table align="center" width="98%" border="3"  bordercolor="CC9999" cellpadding="2" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999"> 
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
      <input type="button" name="go" value="Go" onClick="location.href='./index.php?keyword=local+emp+ut+report&e=<? echo $e;?>&edat='+document.att.edat.value">
	  </td> 
 <td align="right" colspan="7" ><font class='englishhead'>human utilization</font></td>
</tr>
<tr>
  <th>Employee Id</th>
  <th>Employee Name</th>  
  <th colspan="5">Today</th>  
</tr>

<? //local Employee
if($edat){
include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	


//Head office employee

include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

//$sqlquery="SELECT * FROM attendance where location='$loginProject' AND edate='$edat1' AND action in('P','HP') ORDER by empId";
$sqlquery="SELECT attendance.*,employee.designation FROM attendance,employee".
" where attendance.location='$loginProject' AND attendance.edate='$edat1'".
" AND action in('P','HP') AND attendance.empId=employee.empId".
" AND employee.designation>'86-99-999' ORDER by designation ASC ";
//echo $sqlquery;
 $sql= mysqli_query($db, $sqlquery);
 while($re=mysqli_fetch_array($sql)){


 ?>
 <tr>
      <td>	 <? 
	  
	  $designation =$re[designation];// hrDesignationCode($re[empId]);
 // echo "<a href='./employee/local_empAtendanceReport.php?empId=$re[empId]&empD=$designation&empType=H' target='_blank'>";	  
	  echo empId($re[empId],$designation); 
 // echo "</a>";	  
	  echo ', '.hrDesignation($designation); ?>      </td>
      <td><? echo empName($re[empId]);?> </td>  
   <? 
   
	$dailyworkBreakt=dailyworkBreak($re[empId],$edat1,'H',$loginProject);
	
	$toDaypresent=toDaypresent($re[empId],$edat1,'H',$loginProject);
	
    $toDaypresent=$toDaypresent-$dailyworkBreakt;	
	
	$workt= dailywork($re[empId],$edat1,'H',$loginProject);
if(date('D',strtotime($edat1))=='Fri')
 $overtimet = $toDaypresent-(4*3600);
else 
	$overtimet = $toDaypresent-(8*3600);

if($overtimet<0) $overtimet=0;
//	$overtimet = $toDaypresent-8*3600;
	if($overtimet<0) $overtimet=0;
	$idlet=$toDaypresent-$workt;
	  if($idlet<0) $idlet=0;
    ?>
	  <td><? echo ' Present: '.sec2hms($toDaypresent/3600,$padHours=true);?></td>
	  <td><? echo ' Overtime: '.sec2hms($overtimet/3600,$padHours=true);?></td>
	<?  if($e==1){ ?>
	<td><a target="_blank" href="./employee/empUtilizationReport.php?&empId=<? echo $re[empId];?>&empD=<? echo $re[designation];?>&empType=H&edate=<? echo $edat;?>"><? echo '  Worked: '.sec2hms($workt/3600,$padHours=true);?></a></td>	
	 <? } else{?>

	  <td><a target="_blank" href="./employee/empUtilization.php?&empId=<? echo $re[empId];?>&empD=<? echo $re[designation];?>&empType=H&edate=<? echo $edat;?>"><? echo '  Worked: '.sec2hms($workt/3600,$padHours=true);?></a></td>
     <? }?>
	<td><!--<a target="_blank" href="./employee/empIdle.php?&empId=<? echo $re[empId];?>&edate=<? echo $edat;?>"></a>:-->
	Idle: <? echo sec2hms($idlet/3600,$padHours=true);?></td>

 </tr>
 <? } //while?>

<!-- -->
<? }?>
</table>
</form>
<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
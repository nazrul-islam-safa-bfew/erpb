	<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>


<form name="att" action="./employee/employeeAttendance.sql.php" method="post">
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
      <input type="button" name="go" value="Go" onClick="location.href='./index.php?keyword=employee+att+report&edat='+document.att.edat.value">
	  </td> 
 <td align="right" colspan="7" ><font class='englishhead'>human utilization</font></td>
</tr>
<tr>
  <th>Employee Id</th>
  <th>Employee Name</th>  
  <th>Uptodate</th>  
  <th colspan="4">Today</th>  
</tr>
<? 
$format="Y-m-j";
$edat = formatDate($edat,$format);

include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

 $sqlquery="SELECT * FROM empatt where location='$loginProject' AND edat='$edat'";
 //echo $sqlquery;
 $sql= mysqli_query($db, $sqlquery);
 while($re=mysqli_fetch_array($sql)){


 ?>
 <tr>
      <td>
        <?
   
    if(stristr( $re[empId], 'L') === FALSE) {
      $temp = hrName($re[empId]);
      }
     else $temp = hrLocal($re[empId]);
     echo $re[empId].' '.$temp[designation]; ?>
      </td>
   <td><? echo $temp[name];?>  </td>  
   <td></td>
   <td><? $dailyPresent=dailyPresent($re[etime],$re[xtime]); // total hour present in report date

   $worked=sec2hms(dailywork( $re[empId],$edat),$padHours=false);
   $overtime=$dailyPresent-9;
   if($overtime<0) $overtime=0;
   $idle=$dailyPresent-$worked;
      
    echo 'Total: '.sec2hms($dailyPresent,$padHours=false);	
    ?>
	</td>
	<td><? echo ' Overtime: '.sec2hms($overtime,$padHours=true);?></td>
	<td><? echo '  Worked: '.$worked;?></td>
	<td><a target="_blank" href="./index.php?keyword=emp+utilization&empId=<? echo $re[empId];?>&totalPresent=<? echo $idle;?>&edate=<? echo $edat;?>">Idle</a>:
	<? echo sec2hms($idle,$padHours=true);?></td>
 </tr>
 <? } //while?>

</table>
</form>
<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
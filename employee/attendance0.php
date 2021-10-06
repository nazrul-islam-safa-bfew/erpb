	<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>

<form name="attendance" action="./employee/attendance.sql.php" method="post">
<table align="center" width="700" border="3"  bordercolor="CC9999" cellpadding="3" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
	<SCRIPT LANGUAGE="JavaScript">
	var now = new Date(); 
	var cal = new CalendarPopup("testdiv1");
    	//cal.showNavigationDropdowns();
		cal.setWeekStartDay(6); // week is Monday - Sunday
		//cal.addDisabledDates(null,formatDate(now,"yyyy-MM-dd")); 
		cal.setCssPrefix("TEST");		
		cal.offsetX = 25;
		cal.offsetY = -120;
		
	</SCRIPT>
 <td colspan="2"><input type="text" maxlength="10" name="d" value="<? echo $d;?>" > <a id="anchor" href="#"
   onClick="cal.select(document.forms['attendance'].d,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
   <input type="button" name="go" value="Go" onClick="location.href='./index.php?keyword=attendance&d='+document.attendance.d.value">
  </td> 

  <td align="right" valign="top" ><font class='englishhead'>attendance</font></td>
</tr>
<tr>
 <th width="106">Emp Id</th>
 <th width="405">Name</th>
 <th width="20">Remarks</th>
</tr>

<? include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

 $sql=mysqli_query($db, "SELECT * FROM employee WHERE location='$loginProject' ORDER by designation ");
 $i=0;
 while($typel= mysqli_fetch_array($sql)){?>
<tr <? if($i%2==0) echo 'bgcolor=#FFFFCC';?>>
 <td valign="top"><? echo $typel[empId];?>
     <input type="hidden" name="empId<? echo $i;?>" value="<? echo $typel[empId];?>"  >
   <br><? echo $typel[name];?></td>

<? /*if($d){ 
$format="Y-m-j";
$dd = formatDate($d,$format);

$sql1="select * from attendance WHERE empId='$typel[empId]' and edate='$dd'";
 //echo $sql1;
 $sqlqq=mysqli_query($db, $sql1);
 $sqlq1=mysqli_fetch_array($sqlqq);
 $act= $sqlq1[action] ;
 if($act==1) $t=" CHECKED ";
 else if($act==2) $t1=" CHECKED ";
 }*/
?>
 <td>
 	<input type="checkbox" name="half1action<? echo $i;?>" value=".5" <? echo $t;?> disabled >Half night (from 12pm)
 	<input type="radio" name="action<? echo $i;?>" value="1" <? echo $t;?> onClick="half1action<? echo $i;?>.disabled=false;half2action<? echo $i;?>.disabled=false"  >Full Day
 	<input type="checkbox" name="half2action<? echo $i;?>" value=".5" <? echo $t1;?> disabled>Half night (upto 12pm)<br>
 	<? 
	$dd = formatDate($d,"Y-m-j");
	if(isHoliday($dd)){?><input type="radio" name="action<? echo $i;?>" value="2" <? echo $t1;?> onClick="half1action<? echo $i;?>.disabled=false;half2action<? echo $i;?>.disabled=false"  >Half day
	  <? }?>
	<input type="radio" name="action<? echo $i;?>" value="3" <? echo $t;?> checked onClick="half1action<? echo $i;?>.disabled=true;half2action<? echo $i;?>.disabled=true"  >Absent
	
 </td>
 <td><input type="text" name="text<? echo $i;?>" size="20"></td>
</tr>

<? $i++;}?>
<input type="hidden" name="n" value="<? echo $i;?>">
<tr><td colspan="3" align="center"><input type="submit" name="save" value="Save"></td></tr>

</table>
</form>
<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
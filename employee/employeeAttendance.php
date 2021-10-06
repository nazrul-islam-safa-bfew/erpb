	<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>

<? 

include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
	$todat='2005-12-30';
 $sqlquery="SELECT * FROM employee where location=$loginProject AND salaryType='Wages'";
 //echo $sqlquery;
 $sql= mysqli_query($db, $sqlquery);
?>
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
      <input type="button" name="go" value="Go" onClick="location.href='./index.php?keyword=employee+attendance&edat='+document.att.edat.value">
	  </td> 
 <td align="right" colspan="7" ><font class='englishhead'>human resource attendance</font></td>
</tr>
<tr>
  <th width="200">Employee ID</th>
  <th>Name</th> 
  <th width="150">Arrival</th>  
  <th width="150">Departure</th>  
</tr>
<?
$i=1;
 while($emp=mysqli_fetch_array($sql)){

$temp = hrName($emp[empId]);
 $sql1="SELECT * FROM empatt WHERE empId='$emp[empId]' AND edat='$edat'";
 $sqlQ1=mysqli_query($db, $sql1);
 $sqlr1=mysqli_fetch_array($sqlQ1);
 
 $etime=explode(':',$sqlr1[etime]);
 $etime1=$etime[0];
 $etime2=$etime[1]; 

 $etime=explode(':',$sqlr1[xtime]);
 $xtime1=$etime[0];
 $xtime2=$etime[1]; 

?>
<tr>
  <td ><input  type="checkbox" name="ch<? echo $i;?>"><? echo $emp[empId];?>  
  <input type="hidden" name="empId<? echo $i;?>" value="<? echo $emp[empId];?>">
  <input type="hidden" name="id<? echo $i;?>" value="<? echo $sqlr1[id];?>">  
<? echo $temp[designation];?>  </td>  
  <td><? echo $temp[name];?>  </td>    
  <td align="center">
   <select name="etimeH<? echo $i?>" size="1">
     <option value="00">12 PM</option>	 	 
     <option value="1">1 AM</option>
     <option value="2">2 AM</option>	 
     <option value="3">3 AM</option>	 	 
     <option value="4">4 AM</option>	 	 
     <option value="5">5 AM</option>	 	 
     <option value="6">6 AM</option>	 	 
     <option value="7">7 AM</option>	 	 
     <option value="8">8 AM</option>	 	 
     <option value="9">9 AM</option>	 	 
     <option value="10">10 AM</option>	 	 
     <option value="11">11 AM</option>	 	 
     <option value="12">12 AM</option>	 	 
     <option value="13">1 PM</option>
     <option value="14">2 PM</option>	 
     <option value="15">3 PM</option>	 	 
     <option value="16">4 PM</option>	 	 
     <option value="17">5 PM</option>	 	 
     <option value="18">6 PM</option>	 	 
     <option value="19">7 PM</option>	 	 
     <option value="20">8 PM</option>	 	 
     <option value="21">9 PM</option>	 	 
     <option value="22">10 PM</option>	 	 
     <option value="23">11 PM</option>	 	 


   </select>
   <select name="etimeM<? echo $i?>" size="1">
     <option value="0">00</option>
     <option value="15">15</option>	 
     <option value="30">30</option>	 
     <option value="45">45</option>	 
   </select>
  </td>
  <td align="center">
   <select name="xtimeH<? echo $i?>" size="1">
     <option value="00">12 PM</option>	 	 
     <option value="1">1 AM</option>
     <option value="2">2 AM</option>	 
     <option value="3">3 AM</option>	 	 
     <option value="4">4 AM</option>	 	 
     <option value="5">5 AM</option>	 	 
     <option value="6">6 AM</option>	 	 
     <option value="7">7 AM</option>	 	 
     <option value="8">8 AM</option>	 	 
     <option value="9">9 AM</option>	 	 
     <option value="10">10 AM</option>	 	 
     <option value="11">11 AM</option>	 	 
     <option value="12">12 AM</option>	 	 
     <option value="13">1 PM</option>
     <option value="14">2 PM</option>	 
     <option value="15">3 PM</option>	 	 
     <option value="16">4 PM</option>	 	 
     <option value="17">5 PM</option>	 	 
     <option value="18">6 PM</option>	 	 
     <option value="19">7 PM</option>	 	 
     <option value="20">8 PM</option>	 	 
     <option value="21">9 PM</option>	 	 
     <option value="22">10 PM</option>	 	 
     <option value="23">11 PM</option>	 	 
   </select>
   <select name="xtimeM<? echo $i?>" size="1">
     <option value="0">00</option>
     <option value="15">15</option>	 
     <option value="30">30</option>	 
     <option value="45">45</option>	 
   </select>
  </td>
</tr>
<? $i++;} //while

?>
<?
include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
	$todat='2005-12-30';
 $format="Y-m-j";
$edat1 = formatDate($edat,$format);
	
 $sqlquery1="SELECT * FROM localemp where location=$loginProject AND gdate<='$edat1'";
//echo $sqlquery1;
 $sql1= mysqli_query($db, $sqlquery1);

 while($emp1=mysqli_fetch_array($sql1)){
 $temp0 = itemDes($emp1[designation]);
?>
<tr>
  <td ><input  type="checkbox" name="ch<? echo $i;?>"><? echo $emp1[empId];?>  
  <input type="hidden" name="empId<? echo $i;?>" value="<? echo $emp1[empId];?>">
<? echo $temp0[des];?>  </td>  
  <td><? echo $emp1[name];?>  </td>    
  <td align="center">
   <select name="etimeH<? echo $i?>" size="1">
     <option value="00">12 PM</option>	 	 
     <option value="1">1 AM</option>
     <option value="2">2 AM</option>	 
     <option value="3">3 AM</option>	 	 
     <option value="4">4 AM</option>	 	 
     <option value="5">5 AM</option>	 	 
     <option value="6">6 AM</option>	 	 
     <option value="7">7 AM</option>	 	 
     <option value="8">8 AM</option>	 	 
     <option value="9">9 AM</option>	 	 
     <option value="10">10 AM</option>	 	 
     <option value="11">11 AM</option>	 	 
     <option value="12">12 AM</option>	 	 
     <option value="13">1 PM</option>
     <option value="14">2 PM</option>	 
     <option value="15">3 PM</option>	 	 
     <option value="16">4 PM</option>	 	 
     <option value="17">5 PM</option>	 	 
     <option value="18">6 PM</option>	 	 
     <option value="19">7 PM</option>	 	 
     <option value="20">8 PM</option>	 	 
     <option value="21">9 PM</option>	 	 
     <option value="22">10 PM</option>	 	 
     <option value="23">11 PM</option>	 	 


   </select>
   <select name="etimeM<? echo $i?>" size="1">
     <option value="0">00</option>
     <option value="15">15</option>	 
     <option value="30">30</option>	 
     <option value="45">45</option>	 
   </select>
  </td>
  <td align="center">
   <select name="xtimeH<? echo $i?>" size="1">
     <option value="00">12 PM</option>	 	 
     <option value="1">1 AM</option>
     <option value="2">2 AM</option>	 
     <option value="3">3 AM</option>	 	 
     <option value="4">4 AM</option>	 	 
     <option value="5">5 AM</option>	 	 
     <option value="6">6 AM</option>	 	 
     <option value="7">7 AM</option>	 	 
     <option value="8">8 AM</option>	 	 
     <option value="9">9 AM</option>	 	 
     <option value="10">10 AM</option>	 	 
     <option value="11">11 AM</option>	 	 
     <option value="12">12 AM</option>	 	 
     <option value="13">1 PM</option>
     <option value="14">2 PM</option>	 
     <option value="15">3 PM</option>	 	 
     <option value="16">4 PM</option>	 	 
     <option value="17">5 PM</option>	 	 
     <option value="18">6 PM</option>	 	 
     <option value="19">7 PM</option>	 	 
     <option value="20">8 PM</option>	 	 
     <option value="21">9 PM</option>	 	 
     <option value="22">10 PM</option>	 	 
     <option value="23">11 PM</option>	 	 
   </select>
   <select name="xtimeM<? echo $i?>" size="1">
     <option value="0">00</option>
     <option value="15">15</option>	 
     <option value="30">30</option>	 
     <option value="45">45</option>	 
   </select>
  </td>
</tr>
<? $i++;} //while
$n=$i;
?>

<tr>
  <td align="center" colspan="7"><input type="submit" name="attendance" value="Save"></td>
</tr>
</table>
<input type="hidden" name="n" value="<? echo $n;?>">
</form>

<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
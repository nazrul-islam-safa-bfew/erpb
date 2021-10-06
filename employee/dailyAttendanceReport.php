	<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>

<form name="attendance" method="post">
<table align="center" width="90%" border="3"  bordercolor="CC9999" cellpadding="3" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
	<SCRIPT LANGUAGE="JavaScript">
	var now = new Date(); 

	//now.setDate(now.getDate()-2);
	//alert(now);
	var cal = new CalendarPopup("testdiv1");
    	//cal.showNavigationDropdowns();
		cal.setWeekStartDay(6); // week is Monday - Sunday
	//	cal.addDisabledDates(null,formatDate(now,"yyyy-MM-dd")); 
		cal.setCssPrefix("TEST");		
		cal.offsetX = 0;
		cal.offsetY = 30;		
	</SCRIPT>
 <td colspan="4"><input type="text" maxlength="10" name="d" value="<? echo $d?>"  > <a id="anchor" href="#"
   onClick="cal.select(document.forms['attendance'].d,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
   <? 
if($loginProject=='000'){
$ex = array('Select one','');
echo selectPlist('project',$ex,$project);
?>
   <input type="button" name="go" value="Go" onClick="this.form.submit();">
  <!-- <input type="button" name="go" value="Go" onClick="location.href='./index.php?keyword=daily+attendance+report&d='+document.attendance.d.value+'&project='+document.attendance.project.value">-->
<? }
else { echo "<input type=hidden name=project value=$loginProject>";
?>
   <input type="button" name="go" value="Go" onClick="this.form.submit();">
<!--   <input type="button" name="go" value="Go" 
   onClick="location.href='./index.php?keyword=daily+attendance+report&d='+document.attendance.d.value">
   -->
   <? }?>
  </td> 

  <td width="160" align="right" valign="top" ><font class='englishhead'>attendance</font></td>
</tr>
<tr bgcolor="#CC9999">
	<td colspan="5" >
		<input type="radio" name="type" value="sal" <? if($type=='sal') echo " checked ";?> >Salary 
		<input type="radio" name="type" value="wag" <? if($type=='wag') echo " checked ";?>>Wages 
	</td>
</tr>
<? if($d){
?>
<tr>
 <th width='10'>SL No.</th>
 <th width="44">Name</th>
 <th width="100">Designation</th>
 <th width="147">Attendance</th>
 <th>Remarks</th>
</tr>

<? 
$format="Y-m-j";
$dd = formatDate($d,$format);

include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
if($loginProject!='000') $project=$loginProject;
 $sqlq="SELECT * FROM employee WHERE  location='$project' AND status=0 ";
 if($type=='sal') {$sqlq.= " AND  salaryType in ('Salary') "; }
 if($type=='wag') {$sqlq.= " AND  salaryType in ('Wages Monthly Master Roll','Wages Monthly') "; }
 $sqlq.=" and designation not like '70-%' ORDER by designation";
//  echo $sqlq;
 $sql=mysqli_query($db, $sqlq);
 $i=1;
 while($typel= mysqli_fetch_array($sql)){?>
<?
$sql1="select * from attendance WHERE empId='$typel[empId]' and edate='$dd'";
// echo $sql1;
 $sqlqq=mysqli_query($db, $sql1);
 $sqlq1=mysqli_fetch_array($sqlqq);
 if($sqlq1){
 if( $pre!=$typel[designation])
 echo "<tr><td height=3 colspan=5 bgcolor=#FFCCCC></td></tr>";
?>

<tr >
 <td align='center'><? echo $i;?></td>
 <td><? echo $typel[name];?></td>
 <td>
   <?  echo hrDesignation($typel[designation]);?><div align="right" ><? echo empId($typel[empId],$typel[designation]);?></div>
 </td>
 <td align="center">

 <? if($sqlq1[action]=='P' OR $sqlq1[action]=='HP' ) echo 'Present<br>'.$sqlq1[stime];
 elseif($sqlq1[action]=='A' OR $sqlq1[action]=='HA' ) echo '<b><font color=#ff0000>Absent</font><b>';
  else if($sqlq1[action]=='L' ) echo 'Leave';
 ?>
 
 </td>
 <td ><?php

$sql22q="select * from attremarks where attId='$sqlq1[id]' ";
$q1=mysqli_query($db,$sql22q);
$row22=mysqli_fetch_array($q1);

echo $row22[remarks];

 ?></td>
</tr>

<? $i++;} //if
 
 $pre=$typel[designation];
 }//while?>

<? }//if d?>
</table>
</form>
<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
<a href="./print/print_dailyAttendanceReport.php?dd=<? echo $dd;?>&project=<? echo $project;?>&type=<? echo $type;?>" target="_blank">Print</a> 
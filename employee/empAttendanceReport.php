
<table align="center" width="700" border="3"  bordercolor="CC9999" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
<form name="attReport" action="#">
 <td colspan="7">
 <!--
  <select name="empId" size="1" onChange="location.href='index.php?keyword=attendance+report&empId='+attReport.empId.options[document.attReport.empId.selectedIndex].value";>
  <option value="0">Select One</option>
<? include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

 $sql=@mysqli_query($db, "SELECT * FROM employee WHERE location='$loginProject' ORDER by empId") or die('Please try later!!');
 while($typel= mysqli_fetch_array($sql)){
  $temp=hrName($typel[empId]);
  $designation=$temp[designation];
 $plist.= "<option value='".$typel[empId]."'";
 if($empId==$typel[empId]) $plist.=" SELECTED ";
 $plist.= ">$typel[empId]--$typel[name],  $designation</option>  ";
 }
 echo $plist;
?>
</select>
-->
<? echo empName($empId);
   echo ', <b>'.hrDesignation(hrDesignationCode($empId)).'</b>';?>
</td>
</form>
  <td align="right" valign="top" colspan="6" ><font class='englishhead'>attendance report <? echo $year;?></font></td>
</tr>
<tr>
 <th width="10">Date</th>
 <th>Jan</th>
 <th>Feb</th>
 <th>Mar</th>
 <th>Apr</th>
 <th>May</th>
 <th>Jun</th>
 <th>Jul</th>
 <th>Aug</th>
 <th>Sep</th>
 <th>Oct</th>
 <th>Nov</th>
 <th>Dec</th>
</tr>

<?
//$year=thisYear();
$hrJoinDate=hrJoinDate($empId,$d);
 for($i=1;$i<=31;$i++){?>
<tr>
 <td bgcolor="#EECCCC" align="center" ><? echo $i;?></td>
<?
 for($j=1;$j<=12;$j++){
 $daysofmonth = daysofmonth("$year-$j-01");
 $d=date("Y-m-d", mktime(0, 0, 0, $j, $i, $year));
 
 ?>
    <td align="center" width="50"
	 <?    
	 
	// echo '>> '.isHoliday($d)."=$i<=$daysofmonth";
	  if(isHoliday($d)==1 AND $i<=$daysofmonth) {echo "bgcolor=#FFFFCC"; } ?>>
      <?

 if($i<=$daysofmonth AND $d<=$todat){
   $action=emp_daily_att($empId,$d);
   //echo "$d";
   if($action=='P') {echo 'P'; }
    elseif($action=='HP') {echo 'P';  $holidayWorked++;   }   
  	elseif($action=='L') {echo 'L'; $leave++; }
	 elseif($action=='A') {echo 'A';  $absent++; }
  }
   else echo "-";
  
   ?>
    </td>
<? } //for j?>
</tr>
<? }?>
<? 
$fromDate="$year-01-01";
$toDate="$year-12-31";
?>
<tr><td colspan="13" align="right">Leave Taken <font class="out"><? echo totalLeave($empId,$fromDate,$toDate);?> </font>days; Absent <font class="out"> <? echo $absent;?></font> days; Holiday Worked <font class="out"> <? echo $holidayWorked;?></font> days</td></tr>
</table>



<br><br><br>

<table align="center" width="700" border="3"  bordercolor="CC9999" cellpadding="3" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
  <td align="right" valign="top" colspan="6" ><font class='englishhead'>leave report <? echo $year;?></font></td>
</tr>
<?
$leaveApp= array('1'=>'CASUAL','2'=>'SICK', '3'=>'EARNED');
 include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	


$sql="SELECT * FROM `leave` WHERE empId='$empId' AND edate between '$fromDate' AND '$toDate' AND status='3' ORDER by edate";
//echo "$sql<br>";
 $sql11=mysqli_query($db, $sql);
 while($typel11= mysqli_fetch_array($sql11)){
?>
<tr>
    <td> <? echo $leaveApp[$typel11[leaveApplied]];?> <font class="out"> <? echo myDate($typel11[sdate]);?></font> 
      to <font class="out"><? echo myDate($typel11[edate]);?></font>; Cause: <? echo $typel11[cause];?> 
      <? if($typel11[pay]==1) echo "; <font class=out>Without Pay <b>$typel11[withoutPay]</b> days</font>";?>

     <span>PDF:</span>
     <?php
      	$pdf=$typel11["pdf"];
      	if($pdf){
      		echo "<a href='./leave_pdf/$pdf' target='_blank'>#$typel11[id]</a>";
      	}
      ?>
    </td>
</tr>
<? }// while?>
</table>
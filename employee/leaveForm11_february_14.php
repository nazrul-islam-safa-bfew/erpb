<?



if($_POST['save']){
	include("config.inc.php");
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
	
	$format="Y-m-j";
	$sdate = formatDate($d1,$format);
	$edate = formatDate($d2,$format);
	$todat=date("Y-m-j");
	
	$leavePeriod=((strtotime($edate)-strtotime($sdate))/86400)+1; // leave taken
	
	//if(strtotime($empDate)<=strtotime($sdate))
	//echo "<br>";
	//echo checkAttandance($empId,$sdate,$edate);
	if(checkAttandance($empId,$sdate,$edate)=='ok')
	{
	$sql="INSERT INTO `leave` (id, empId, leaveApplied, leavePeriod, sdate, edate, cause, leaveAddress, recommended, approveBy,pay, withoutPay, todat,status,pcode) VALUES ".
	" ('','$empId', '$leaveApplied', '$leavePeriod', '$sdate', '$edate', '$cause', '$leaveAddress', '$recommended', '','','0','$todat','0','$loginProject')";
	//echo $sql.'<br>';
	$sql=mysqli_query($db, $sql); 
	echo "Entry Sucessful";
	}
	else {echo "ERROR <br> Please check the Dates"; showCheckedAttandanceEmp($empId,$sdate,$edate);}
}
?>
	<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
	
<form name="leaveForm" onsubmit="return checkrequired(this);" action="index.php?keyword=leave+form" method="post">
<table align="center" width="500" border="3"  bordercolor="CC9999" cellpadding="3" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td align="right" valign="top" colspan="2"><font class='englishhead'>leave form</font></td>
</tr>
<tr>
 <td>Select Employee</td>
  <td>
   <select name="empId" size="1" onChange="location.href='index.php?keyword=leave+form&amp;empId='+leaveForm.empId.options[document.leaveForm.empId.selectedIndex].value";>
 
<? include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

 $sql=@mysqli_query($db, "SELECT * FROM employee WHERE (salaryType='Salary' OR salaryType='Salaried' OR salaryType='Consolidated' OR salaryType='Wages Monthly' )
  AND location='000' AND status='0' ORDER by designation") or die('Please try later!!');
 while($typel= mysqli_fetch_array($sql)){
 $plist.= "<option value='".$typel[empId]."'";
 if($empId==$typel[empId]) $plist.=" SELECTED ";
 $plist.= ">".empId($typel[empId],$typel[designation])."--$typel[name]</option>  ";
 }
 echo $plist;
?>
</select>


</td>
</tr>
<tr>
  <td>Leave applied for</td>
  <td><input type="radio" name="leaveApplied" value="1" checked>CASUAL
     <input type="radio" name="leaveApplied" value="2">SICK
	 <input type="radio" name="leaveApplied" value="3">EARNED
  </td>
</tr>
<? include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

 $sql1="SELECT * FROM employee WHERE empId='$empId'";
 //echo $sql1;
 $sqlq1=@mysqli_query($db, $sql1) or die('Please try later!!');
 $emp= mysqli_fetch_array($sqlq1);
 
?>

<tr>
 <td>Name</td>
 <td><? echo $emp[name];?>
 <input type="hidden" name="empDate" value="<? echo $emp[empDate]; ?>">
  </td> 
</tr>
<tr>
 <td>Designation</td>
 <td><? 
$designation=$emp[designation];
 echo hrDesignation($emp[designation]);
 ?></td> 
</tr>
<tr>
 <td>Leave status</td>
 <td>Leave taken <? 
 $year=thisYear(); 
 $fromdat="$year-01-01";
 $todat="$year-12-31";
 
 $leaveTaken=totalLeave($empId,$fromdat,$todat);
    echo '<font class=out>'.$leaveTaken.'</font>'; $balance=29-$leaveTaken;?> days, 
 Due <? echo '<font class=out>'.$balance.'</font>';?> days</td> 
</tr>
	<SCRIPT LANGUAGE="JavaScript">
	var now = new Date(); 
	var cal = new CalendarPopup("testdiv1");
    	//cal.showNavigationDropdowns();
		cal.setWeekStartDay(6); // week is Monday - Sunday
		//cal.addDisabledDates(null,formatDate(now,"yyyy-MM-dd")); 
		cal.setCssPrefix("TEST");		
		cal.offsetX = -300;
		cal.offsetY = -80;
		
	</SCRIPT>
<tr>
 <td>From </td>
 <td><input type="text" maxlength="10" name="d1" readonly="" alt="req" title="From Date"  > <a id="anchor" href="#"
   onClick="cal.select(document.forms['leaveForm'].d1,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
  </td> 
 
</tr>
<tr>
 <td>To</td>
 <td><input type="text" maxlength="10" name="d2" readonly="" alt="req" title="To Date" > <a id="anchor1" href="#"
   onClick="cal.select(document.forms['leaveForm'].d2,'anchor1','dd/MM/yyyy'); return false;"
   name="anchor1" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
  </td> 
</tr>
<tr>
 <td>Cause of Leave </td>
 <td><input type="text" size="50" name="cause"></td>
</tr>
<tr>
 <td>Leave address</td>
 <td><input type="text" size="50" name="leaveAddress"></td>
</tr>
<tr>
 <td>Recommendation Details (if any)</td>
 <td><textarea cols="50" rows="3" name="recommended"></textarea></td>
</tr>
<!--
<tr>
 <td>Approve by</td>
 <td>
 <? //echo $sql1;
if($balance<=0)
 echo "Mr. K. Rahmatullah, Managing Director";
 else {
?>

     <select name="approveBy" size="1" >
 
<? include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$temp= explode('_',$designation);

if($temp[0]>= 75 AND $temp[0]<= 76){$s="70-00-000"; $e="74-99-999";}
elseif($temp[0]>= 77 AND $temp[0]<= 98){$s="75-00-000"; $e="76-99-999";}

 $sql1="SELECT * FROM employee WHERE designation BETWEEN '$s' AND '$e' AND salaryType='Salary' ORDER by designation";
 
 $sql11=mysqli_query($db, $sql1); 
 while($elist= mysqli_fetch_array($sql11)){
 $plist1.= "<option value='".$elist[empId]."'";
 $plist1.= ">".empId($elist[empId],$elist[designation])."--$elist[name]</option>  ";
 }
 echo $plist1;
?>
</select>
<? 
//echo $sql1;
}?>
 </td>
</tr>
<? //if($balance<=0){?>

<tr>
  <td>Holiday Worked</td>
  <td> days</td>
</tr>

<tr>
 <td>Payment Condition</td>
<td><input type="radio" name="pay" value="1" >Without Pay   <input type="radio" name="pay" value="0" checked>With Pay</td>
</tr>
-->
<? //}?>
<tr><td colspan="2" align="center"><input type="submit" name="save" value="Submit"></td></tr>
 </table>
 <input type="hidden" name="balance" value="<? echo $balance;?>" >
<input type="hidden"  name="project" value="<? echo $emp[location];?>">
</form>
<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>

* Annual Leave is 29 Days.<br>
* Managers are authorised to grant leave to employees working under them<br>
* Managing Director and Directores are authorised to grant leave to Managers.<br>
* Only Managing Director can approve leave when there in no leave day in balance.<br>
* Leave at Provision Period will be without payment.

<? // include("./includes/handler.php");?>
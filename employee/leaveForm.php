<?
$format="Y-m-j";
$sdate1 = formatDate($d1,$format);
$year1=date("Y",strtotime($sdate1));

if($_POST['save']){
	include("config.inc.php");
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

	$sdate = formatDate($d1,$format);
	$edate = formatDate($d2,$format);
	$todat=date("Y-m-j");

	echo $year1=date("Y",strtotime($sdate));

	$leavePeriod=((strtotime($edate)-strtotime($sdate))/86400)+1; // leave taken

	//if(strtotime($empDate)<=strtotime($sdate))
	//echo "<br>";
	//echo checkAttandance($empId,$sdate,$edate);
	if(checkAttandance($empId,$sdate,$edate)=='ok' && $appdate)
	{
	$resp_sql="select * from employee where empId='$repsponsible_person'";
	$resp_q=mysqli_query($db,$resp_sql);
	$resp_row=mysqli_fetch_array($resp_q);
		$responsible_emp_id=$resp_row[empId];
		$responsible_emp_des="$resp_row[designation]$resp_row[empId] $resp_row[name]";

	$sql="INSERT INTO `leave` (id, empId, leaveApplied, leavePeriod, sdate, edate, cause, leaveAddress, recommended, approveBy,pay, withoutPay, todat,status,pcode, app_date, responsible_emp_id, responsible_emp_des) VALUES ".
	" ('','$empId', '$leaveApplied', '$leavePeriod', '$sdate', '$edate', '$cause', '$leaveAddress', '$recommended', '','','0','$todat','1','$loginProject','$appdate','$responsible_emp_id','$responsible_emp_des')";
	// echo $sql.'<br>';
	// exit;
	$sql=mysqli_query($db, $sql); 
	echo "<center><h1><font color='#f00'>Entry Sucessful</font></h1></center>";
	echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=./index.php?keyword=leave+form\">";
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
		 <select name="empId" size="1">

	<? include("config.inc.php");
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);


	 $sql=@mysqli_query($db, "SELECT * FROM employee WHERE (salaryType like 'Salar%' OR salaryType='Consolidated' OR salaryType='Wages Monthly' )
		AND location='$loginProject' AND status='0' AND designation>='71-00-000' AND designation<='81-99-999'  ORDER by designation") or die('Please try later!!');
	 while($typel= mysqli_fetch_array($sql)){
	//  $sql=@mysqli_query($db, "SELECT * FROM employee WHERE (salaryType like 'Salar%' OR salaryType='Consolidated' OR salaryType='Wages Monthly' )
	// 	AND location='$loginProject' AND status='0' AND designation!='70-01-000' ORDER by designation") or die('Please try later!!');
	//  while($typel= mysqli_fetch_array($sql)){
	 $plist.= "<option value='".$typel[empId]."'";
	 if($empId==$typel[empId]) $plist.=" SELECTED ";
   $des=itemDes($typel[designation]);
	 $plist.= ">".empId($typel[empId],$typel[designation]).": $des[des]--$typel[name]</option>  ";
	 }
	 echo $plist;
	?>
	</select>
	</td>
</tr>

<tr>
  <td>Application Date</td>
  <td>
    <input type="text" maxlength="10" name="appdate" id="appdate" readonly="" alt="req" title="Application Date" value="<?php echo $appdate; ?>"><a id="anchor" href="#"
   onClick="cal.select(document.forms['leaveForm'].appdate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a>    
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

<!-- <tr>
 <td>Name</td>
 <td><? echo $emp[name];?>
 <input type="hidden" name="empDate" value="<? echo $emp[empDate]; ?>">
  </td> 
</tr> -->
<tr>
 <td>Designation</td>
 <td><? 
     if($emp[designation]){
      $designation=$emp[designation];
      echo hrDesignation($emp[designation]);
   }
 ?></td> 
</tr>
	
	
<tr>
 <td>From </td>
 <td><input type="text" maxlength="10" name="d1" id="d1" readonly="" alt="req" title="From Date" value="<?php echo $d1; ?>"><a id="anchor" href="#"
   onClick="cal.select(document.forms['leaveForm'].d1,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a>
  </td>
</tr>
<tr>
 <td>To</td>
 <td><input type="text" maxlength="10" name="d2" id="d2" readonly="" alt="req" title="To Date"  onChange="location.href='index.php?keyword=leave+form&amp;empId='+leaveForm.empId.options[document.leaveForm.empId.selectedIndex].value" value="<?php echo $d2; ?>"><a id="anchor1" href="#"
   onClick="cal.select(document.forms['leaveForm'].d2,'anchor1','dd/MM/yyyy'); return false;"
   name="anchor1" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
 </td> 
</tr>
	
<tr>
 <td>Leave status</td>
 <td><? 
 $year=$year1; 
 $fromdat="$year-01-01";
 $todat="$year-12-31";
 
 $CasualleaveTaken=LeaveSplitly($empId,$fromdat,$todat,1);
 $SickleaveTaken=LeaveSplitly($empId,$fromdat,$todat,2);
	 ?>
	
	 	 <table>
		 <tr><td>Leave taken <font class=out><?php echo $CasualleaveTaken+$SickleaveTaken; ?></font> days, 
			 Due <font class=out><?php echo $balance=29-($CasualleaveTaken+$SickleaveTaken); ?></font>  days (out of 29 days)</td></tr>
		 <tr>
			 <td>Casual <font class=out><?php echo $CasualleaveTaken; ?></font> days (out of 14 days)</td>
		 </tr>
		 <tr>
			 <td>Sick <font class=out><?php echo $SickleaveTaken; ?></font> days (out of 15 days)</td>
		 </tr>
	 </table>
	</td> 
</tr>
	<SCRIPT LANGUAGE="JavaScript">
	var now = new Date(); 
	var cal = new CalendarPopup("testdiv1");
    	//cal.showNavigationDropdowns();
		cal.setWeekStartDay(6); // week is Monday - Sunday
		//cal.addDisabledDates(null,formatDate(now,"yyyy-MM-dd")); 
		cal.setCssPrefix("TEST");
		cal.offsetX = -10;
		cal.offsetY = -10;
	</SCRIPT>
<tr>
 <td>Cause of Leave </td>
 <td><input type="text" size="50" name="cause" value="<?php echo $cause; ?>"></td>
</tr>
<tr>
 <td>Work responsibility will be taken care by:</td>
 <td>
 	<select name="repsponsible_person"  size="1">
 		<option>Select an employee.</option>
 		<?php
 			$sql="select * from employee where location='$loginProject' and designation not like '70%' order by designation asc";
 			$q=mysqli_query($db,$sql);
 			while($row=mysqli_fetch_array($q)){ ?> 				
					<option value="<?= $row[empId] ?>" <?= $repsponsible_person==$row[empId] ? ' selected ' : '' ?>><?= $row["designation"] ?> - <?= $row["name"] ?></option>
 				<?php
 			}

 		?>
 		


 	</select>
 </td>
</tr>
<tr>
 <td>Leave address</td>
 <td><input type="text" size="50" name="leaveAddress" value="<?php echo $leaveAddress; ?>"></td>
</tr>
<!-- <tr>
 <td>Recommendation Details (if any)</td>
 <td><textarea cols="50" rows="3" name="recommended"><?php echo $recommended; ?></textarea></td>
</tr> -->
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
<tr>
	<td colspan="2" align="center">
		<input type="button" id="check" class="check" value="Check">
		<input type="submit" name="save" id="save" class="save" value="Submit" disabled>
	</td>
</tr>
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

<script>
$(document).ready(function(){
		
  
	$("#check").click(function(){
    var appdate=$("#appdate").val();
    if(!appdate){
      alert("Please input application data");
      return;
    }
		var url="index.php?keyword=leave+form&empId="+leaveForm.empId.options[document.leaveForm.empId.selectedIndex].value+"&d1="+leaveForm.d1.value+"&d2="+leaveForm.d2.value+"&cause="+leaveForm.cause.value+"&leaveAddress="+leaveForm.leaveAddress.value+"&appdate="+leaveForm.appdate.value+"&repsponsible_person="+leaveForm.repsponsible_person.value;
	
<?php 
		if(!$d1 || !$d2){
			echo 'window.location.href=url;';
		}
?>
		
		var d1=$("#d1").val();
		var d2=$("#d2").val();
		var year1=d1.split("/")[2];
		var year2=d2.split("/")[2];
		
		if(d1>d2 || year1!=year2){
			alert("Year is not same");
			return;
		}
			$("#save").attr("disabled",false);
	});
	
	$("input,select").change(function(){
		if($(this).hasClass("check")==false && $(this).hasClass("save")==false){
			$("#save").attr("disabled",true);
		}
	});
	
	
});
</script>

<? // include("./includes/handler.php");?>
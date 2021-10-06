<?
error_reporting(0);
function leaveStatus($s){
	if($s==0) return 'Applied';
	if($s==1) return 'Forwarded';
	if($s==3) return 'Approved';
	if($s==-1) return 'Disapproved';
}

if(!$year)$year=date("Y");
?>

<form action='./index.php?keyword=staff+leave+report&status=0' method=post>
	<table style='width:300px; margin:auto; margin-bottom:50px; border:1px solid'>
		<tr bgcolor="#CC9999" align='center'><td colspan=2><font class='englishhead'>leave report <? echo $year;?></font></td></tr>
		<tr>
			<td width=100>Select Year:</td>
	<td><select name='year' style='width:100%'>
	<?php
	$current_year=date("Y");
	$final_year=date("Y")-5;

	for($current_year;$current_year>$final_year;$current_year--){
		echo "<option value='$current_year' ".($year==$current_year ? "selected" : "") ." >$current_year</option>";
	}
	?>
	</select></td>
		</tr>
		<tr align=center>
			<td colspan=2><input type='submit'>
			<br>
			</td>
		</tr>
	</table>
</form>


<table align="center" width="98%" border="3"  bordercolor="CC9999" cellpadding="3" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
  <td align="right" valign="top" colspan="7" ><font class='englishhead'>leave report <? echo date("Y");?></font></td>
</tr>
<tr>
  <th>Application No.</th>
  <th>Name</th>  
  <th>Designation</th>    
  <th>Remarks</th>    
  <th>Applied for</th>  
  <th>Status</th>    
</tr>
<?
$leaveApp= array('1'=>'CASUAL','2'=>'SICK', '3'=>'EARNED');
 include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
if($_SESSION[loginDesignation]=="Procurement Manager"){
	$getItemDesCode=getItemDesCode("coordinator, Procurement");
}else{
	echo $getItemDesCode=getItemDesCode($_SESSION[loginDesignation]);
}

	
// $sql11=mysqli_query($db, "SELECT * FROM leave WHERE empId='$empId' ORDER by edate");
if($loginDesignation=='Chairman & Managing Director'){
	if(isset($status))
		$sql="SELECT `leave`.*,employee.empId,employee.name,employee.designation FROM `leave`,employee WHERE leave.empId=employee.empId /*AND leave.status='$status'*/";
	else
		$sql="SELECT `leave`.*,employee.empId,employee.name,employee.designation FROM `leave`,employee WHERE leave.empId=employee.empId";
	
	$sql.=" and (employee.designation between '73-10-001' and '73-19-999' or leave.status=1) ";
	
	$sql.=" and leave.sdate like '$year-%' ";
	
	$sql.=" ORDER by field(leave.status,1) desc,leave.edate asc";
	$t=1;
}
elseif($loginDesignation=='Project Manager' OR $loginDesignation=='Site Cashier'  OR $loginDesignation=='Site Engineer'){
	$sql="SELECT `leave`.*,employee.empId,employee.name,employee.designation FROM `leave`,employee 
	 WHERE leave.empId=employee.empId AND location='$loginProject' AND leave.status like '$status' 
	  ORDER by leave.edate DESC";
}elseif($loginDesignation=='Human Resource Manager'){
	if($getItemDesCode){
			$sql="SELECT `leave`.*,employee.empId,employee.name,employee.designation FROM `leave`,employee
	 WHERE ((leave.empId=employee.empId AND leave.status like '$status') OR 
	 (leave.empId=employee.empId AND leave.status like '1'))  and employee.ccr='$getItemDesCode'
	ORDER by leave.edate DESC";
	}
	$t=1;
}elseif($getItemDesCode && managerList($getItemDesCode)){
	$managerFound=true;
// 	$getItemDesCode='';
	$managerPcode=$_SESSION[loginProject];
	$sql="SELECT `leave`.*,employee.empId,employee.name,employee.designation,employee.ccr FROM `leave`,employee
	 WHERE ((leave.empId=employee.empId AND leave.status like '$status') OR 
	 (leave.empId=employee.empId AND leave.status like '1')) and employee.ccr='$getItemDesCode'
	 and employee.location='$managerPcode' ";
	$sql.=" and leave.sdate like '$year-%' ";
	$sql.=" ORDER by leave.edate DESC";
	$t=1;
}elseif($loginDesignation=='Human Resource Executive'){
	$sql="SELECT `leave`.*,employee.empId,employee.name,employee.designation FROM `leave`,employee
	 WHERE leave.empId=employee.empId and employee.location='$loginProject' ORDER by leave.edate DESC limit 20";
}
/*else {$sql="SELECT leave.*,employee.empId,employee.name,employee.designation,employee.location".
" FROM leave,employee WHERE leave.empId=employee.empId ".
"   AND (leave.status BETWEEN '0' AND '2') ORDER by leave.edate DESC";
$t=1;
}*/
// echo $getItemDesCode.$sql;

 $sql11=mysqli_query($db, $sql);
 $ik=1;
 while($typel11=mysqli_fetch_array($sql11)){
// 	 print_r($typel11);
?>
<tr>
  <td align="center"><? echo $typel11[id];?></td>
  <td>
  <? if(($typel11[status]==1 AND $loginDesignation=='Chairman & Managing Director') OR ($typel11[status]==0 AND $loginDesignation=='Project Manager')
   OR ($loginDesignation=='Human Resource Manager') OR $managerFound){?>
  <a href="index.php?keyword=update+staff+leave+form&id=<? echo $typel11[id];?>&empId=<? echo $typel11[empId];?>" target="_blank">
	  <? echo $typel11[name];?></a>
	  <? }else echo $typel11[name];?>
	  <br>
	  <? echo empId($typel11[empId],$typel11[designation]);?>
  </td>  
  <td><? echo hrDesignation($typel11[designation]);?></td>   
	
<td>
<?php
 $fromdat="$year-01-01";
 $todat="$year-12-31";
?>

	<? 
 $sqlf="SELECT DISTINCT location from attendance where empId='$typel11[empId]' AND 
  edate BETWEEN '$fromdat' AND  '$todat' ORDER by location ASC ";
// echo $sqlf.'<br>';
$sqlQ=mysqli_query($db, $sqlf);
$rows=mysqli_num_rows($sqlQ);

if($rows){
	$i=0;
while($rr=mysqli_fetch_array($sqlQ)){
	$valid=1;
	$loc[$i]=$rr[location];
	for($mon=1;$mon<=12;$mon++){
		$pre[$i]+=emp_monthlyPresent_project($typel11[empId],$mon,$year,$rr[location]);
		$leave[$i]+=emp_monthlyLeave_project($typel11[empId],$mon,$year,$rr[location]);
		$absent[$i]+=emp_monthlyAbsent_project($typel11[empId],$mon,$year,$rr[location]);
		$holiday[$i]+=emp_monthlyHoliday_project($typel11[empId],$mon,$year,$rr[location]);
		$withoutPay[$i]+=withoutPay($typel11[empId],$mon,$year,$rr[location]);
		$withPay[$i]+=withoutPay($typel11[empId],$mon,$year,$rr[location],"1");
		$tp+=$pre[$i];
		$ta+=$absent[$i];
	}

	echo "$loc[$i]-$pre[$i] P, $leave[$i] L, $holiday[$i] HP, <font class=out>$absent[$i] A</font>"; 
	if($withoutPay[$i]) echo ", <font class=out>$withoutPay[$i] NoPay</font>";echo "<br>";
	$i++;
	unset($pre);
	unset($leave);
	unset($absent);
	unset($holiday);
	unset($withoutPay);
	unset($withPay);
}

 }//if size of loc
//}
if($empStatus=='-1') echo '<font class=outi>Terminate on '.myDate($typel11[jobTer]).'</font>';
if(getReleasedDate($typel11[empId]))
	echo "<span style='background: #f00;
    color: #fff;
    border-radius: 5px;
    padding: 1px 2px;'>Released from job</span>";
 ?>
	
</td>	
	<td><? echo $leaveApp[$typel11[leaveApplied]];?> <font class="out"> <? echo myDate($typel11[sdate]);?></font> 
		to <font class="out"><? echo myDate($typel11[edate]);?></font> 
		<? if($typel11[pay]==1) echo "<br><font class=out>Without Pay <b>$typel11[withoutPay]</b> days</font>";
			 if($t==1)echo '<br>Location '.$typel11[pcode];
	?>
	</td>
  <td align="center"><? echo leaveStatus($typel11[status]);
		 if($typel11[pdf])
		 		echo "<br><a href='./test/$typel11[pdf]' target='_blank'>PDF</a>";
  
   ?></td>  
</tr>
<? $i++;}// while?>
</table>

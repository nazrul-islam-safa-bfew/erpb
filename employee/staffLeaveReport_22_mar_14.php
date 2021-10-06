<? function leaveStatus($s){
if($s==0) return 'Applied';
if($s==1) return 'Forwarded to MD';
if($s==3) return 'Approved';
if($s==-1) return 'Disapproved';
}?>
<table align="center" width="98%" border="3"  bordercolor="CC9999" cellpadding="3" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
  <td align="right" valign="top" colspan="7" ><font class='englishhead'>leave report <? echo date("Y");?></font></td>
</tr>
<tr>
  <th>SL NO.</th>
  <th>Name</th>  
  <th>Designation</th>    
  <th>Details</th>  
  <th>Status</th>    
</tr>
<?
$leaveApp= array('1'=>'CASUAL','2'=>'SICK', '3'=>'EARNED');
 include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

// $sql11=mysqli_query($db, "SELECT * FROM leave WHERE empId='$empId' ORDER by edate");
if($loginDesignation=='Managing Director') {
	if($status)
	$sql="SELECT `leave`.*,employee.empId,employee.name,employee.designation FROM `leave`,employee WHERE leave.empId=employee.empId AND leave.status='$status' ORDER by leave.edate DESC";
	else 
	$sql="SELECT `leave`.*,employee.empId,employee.name,employee.designation FROM `leave`,employee WHERE leave.empId=employee.empId  ORDER by leave.edate DESC";
$t=1;
}
elseif($loginDesignation=='Project Manager' OR $loginDesignation=='Site Cashier'  OR $loginDesignation=='Site Engineer') 
{ $sql="SELECT `leave`.*,employee.empId,employee.name,employee.designation FROM `leave`,employee 
	 WHERE leave.empId=employee.empId AND location='$loginProject' AND leave.status like '$status' 
	  ORDER by leave.edate DESC";
}
elseif($loginDesignation=='Human Resource Manager') 
{ $sql="SELECT `leave`.*,employee.empId,employee.name,employee.designation FROM `leave`,employee
	 WHERE (leave.empId=employee.empId AND location='$loginProject' AND leave.status like '$status') OR 
	 (leave.empId=employee.empId AND location<>'$loginProject' AND leave.status like '1') 
	ORDER by leave.edate DESC";
$t=1;	
}

/*else {$sql="SELECT leave.*,employee.empId,employee.name,employee.designation,employee.location".
" FROM leave,employee WHERE leave.empId=employee.empId ".
"   AND (leave.status BETWEEN '0' AND '2') ORDER by leave.edate DESC";
$t=1;
}*/
//echo $sql;

 $sql11=mysqli_query($db, $sql);
 $i=1;
 while($typel11= mysqli_fetch_array($sql11)){
?>
<tr>
  <td align="center"><? echo $i;?></td>
  <td>
  <? if(($typel11[status]==1 AND $loginDesignation=='Managing Director') OR ($typel11[status]==0 AND $loginDesignation=='Project Manager')
   OR ($loginDesignation=='Human Resource Manager')){?>
  <a href="index.php?keyword=update+staff+leave+form&id=<? echo $typel11[id];?>&empId=<? echo $typel11[empId];?>">
	  <? echo $typel11[name];?></a>
	  <? } else echo $typel11[name];?>
	  <br>
	  <? echo empId($typel11[empId],$typel11[designation]);?>
  </td>  
  <td><? echo hrDesignation($typel11[designation]);?></td>    
    <td> <? echo $leaveApp[$typel11[leaveApplied]];?> <font class="out"> <? echo myDate($typel11[sdate]);?></font> 
      to <font class="out"><? echo myDate($typel11[edate]);?></font> 
      <? if($typel11[pay]==1) echo "<br><font class=out>Without Pay <b>$typel11[withoutPay]</b> days</font>";
	  	   if($t==1)echo '<br>Location '.$typel11[pcode];
	  ?>
    </td>
  <td align="center"><? echo leaveStatus($typel11[status]);
  
   ?></td>  
</tr>
<? $i++;}// while?>
</table>

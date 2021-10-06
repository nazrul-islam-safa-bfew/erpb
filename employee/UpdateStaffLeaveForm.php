			 <script type="text/jscript">
			 function ShowDiv(divName){
			 var divmain = document.getElementById(divName);
			   divmain.className= "visible";
			   //document.getElementById('av1').checked=true;
			 }
			 function hidDiv(divName){
			 var divmain = document.getElementById(divName);
			    divmain.className= "hidden";
			 }
			</script>
<?
if($action){
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
 if($action==3){
 if($pay=='') {$pay=0; if($pay==0) $withoutPayDays=0;}
	 $sql="UPDATE `leave` SET recommended='$recommended',approveBy='$loginUid',
	  status='4',pay=$pay,withoutPay='$withoutPayDays' WHERE id=$id";
	// echo $sql.'<br>';
    $sql=mysqli_query($db, $sql); 

		 for($i=0;$i<$leavePeriod; $i++){
		 $edate=date('Y-m-d',strtotime($sdate)+(86400*$i));
		 $sql="INSERT INTO attendance(`id` , `empId`, `edate` ,`action` , `stime` , `etime` , `todat` , `location`)
		  VALUES ('', '$empId', '$edate', 'L', '', '','$todat','$project' )";
		// echo $sql.'<br>';
		$sqlq=mysqli_query($db, $sql);
		$ro=mysqli_affected_rows($db);
		if($ro='-1'){
		 $sql1="UPDATE attendance set  action='L' WHERE empId='$empId' AND edate='$edate'";
		// echo $sql1.'<br>';		 
		  $sqlq=mysqli_query($db, $sql1);
			}
           }//for 
	  }// if action==1
 elseif($action==1){
	 $sql="UPDATE `leave` SET recommended='$recommended', status=1 WHERE id=$id";
	echo $sql.'<br>';
    $sql=mysqli_query($db, $sql); 
 }
 elseif($action==-1){
	 $sql="UPDATE `leave` SET recommended='$recommended', status='-1' WHERE id=$id";
	// echo $sql.'<br>';
    $sql=mysqli_query($db, $sql); 
 }
	   
  echo $action." Leave in process.";
	echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=./index.php?keyword=staff+leave+report&status=0\">";
}
else{
?>
<? 
 $sql="SELECT `leave`.*,employee.empId,employee.name,employee.designation,employee.ccr FROM `leave`,employee WHERE leave.empId=employee.empId  AND leave.id=$id";
// echo $sql;
 $sql11=mysqli_query($db, $sql);
 $i=1;
$typel11= mysqli_fetch_array($sql11);

$status=1;

?>	
<form name="leaveForm" action="index.php?keyword=update+staff+leave+form&empId=<? echo $typel11[empId];?>&id=<? echo $typel11[id];?>&status=<? echo $status;?>" method="post">
<table align="center" width="500" border="3"  bordercolor="CC9999" cellpadding="3" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td align="right" valign="top" colspan="2"><font class='englishhead'>leave form</font></td>
</tr>
<tr>
  <td>Leave applied for</td>
  <td><? if($typel11[leaveApplied]==1) echo 'CASUAL'; else if($typel11[leaveApplied]==2) echo 'SICK'; else echo 'EARNED';?>  
  </td>
</tr>
<tr>
 <td>Name</td>
 <td><? echo $typel11[name];?>
 <input type="hidden" name="project" value="<? echo $typel11[pcode];?>">
 </td> 
</tr>
<tr>
 <td>Designation</td>
 <td><? 
  echo hrDesignation($typel11[designation]);
 ?></td> 
</tr>
<tr>
 <td>Leave status</td>
 <td><?php
 $fromdat=$typel11[sdate];
 $the_dateof_year=explode("-",$fromdat);
 // $year=thisYear(); //Stoped
 $year=$the_dateof_year[0]; 
 $fromdat="$year-01-01";
 $todat="$year-12-31";
 
 $CasualleaveTaken=LeaveSplitly($empId,$fromdat,$todat,1);
 $SickleaveTaken=LeaveSplitly($empId,$fromdat,$todat,2);
 $casual_without_pay=withoutPay_yearly($empId,"%",$year,1);
 $sick_without_pay=withoutPay_yearly($empId,"%",$year,2);
 $casual_without_pay=$casual_without_pay>0 ? $casual_without_pay : 0;
 $sick_without_pay=$sick_without_pay>0 ? $sick_without_pay : 0;
 ?>
	 <table>
		 <tr><td>Leave taken <font class=out><?php echo $CasualleaveTaken+$SickleaveTaken; ?></font> days, 
		Due <font class=out><?php echo $balance=29-($CasualleaveTaken+$SickleaveTaken); ?></font>  days (out of 29 days)</td></tr>
				<?php 
				$total_hp=totalHolidatWork($empId, $fromdat, $todat);				
			
			if($total_hp>0){	?>	
		 <tr>
			<td>HP <font class=out>
				<?= $total_hp ?>				
				</font> days</td>
		 </tr>
		<?php } ?>
		 <tr>
		<td>Casual <font class=out><?php echo $CasualleaveTaken; ?></font> days (out of 14 days) <?php if($casual_without_pay>0)  { ?> (Without pay <?= $casual_without_pay ?> days) <?php } ?></td>
		 </tr>
		 <tr>
		<td>Sick <font class=out><?php echo $SickleaveTaken; ?></font> days (out of 15 days) <?php if($sick_without_pay>0) { ?> (Without pay <?= $sick_without_pay ?> days) <?php } ?></td>
		 </tr>
	 </table>
	
	
	</td> 
</tr>
<tr>
 <td>From </td>
 <td><? echo myDate($typel11[sdate]);?>
 <input type="hidden" name="sdate" value="<? echo $typel11[sdate];?>">
 </td> 
 
</tr>
<tr>
 <td>To</td>
 <td><? echo myDate($typel11[edate]);?>
 	<?php
 		$str_diff=strtotime($typel11[edate])-strtotime($typel11[sdate]);
 		$day_found=$str_diff/86400;
 	?>
 	 (<?= $day_found+1 ?> days)
 </td> 
</tr>
<tr>
 <td>Cause of Leave </td>
 <td><? echo $typel11[cause];?></td> 
</tr>
<tr>
 <td>Leave address</td>
 <td><? echo $typel11[leaveAddress];?></td> 
</tr>
<tr>
 <td>Comments</td>
 <td><textarea cols="50" rows="3" name="recommended"><? echo $typel11[recommended];?></textarea></td>
</tr>
<? if($loginDesignation=='Chairman & Managing Director' OR $loginDesignation=='Human Resource Manager') {?>
<tr>
 <td>Payment Condition</td>
<td>
  <input type="radio" name="pay" id="pay1" value="1" onClick="ShowDiv('div1');ShowDiv('div2');" >Without Pay 
<input type="text"  id="div1" class="hidden" name="withoutPayDays" value="" size="3" width="3" maxlength="2" style=" background:#FFFFCC">
<label id="div2" class="hidden"> days</label>
  <input type="radio" name="pay" id="pay2" value="0" checked onClick="hidDiv('div1');hidDiv('div2');">With Pay</td>
</tr>
<? }?>
<tr>
	<td colspan="2" align="center">
	<input type="hidden" name="leavePeriod" value="<? echo $typel11[leavePeriod];?>">
<?
// 	echo "$balance>$typel11[leavePeriod]";
	if($balance>$typel11[leavePeriod] OR $loginDesignation=='Chairman & Managing Director' OR $loginDesignation=='Human Resource Manager'){?>
	<input type="button" name="Approve" value="Approve" style="color:#009900" onClick="leaveForm.action.value=3;leaveForm.submit();"  > &nbsp;&nbsp;&nbsp;&nbsp;
	<? }?>
	<input type="button" name="Disapprove" value="Disapprove" style="color:#990000" onClick="leaveForm.action.value=-1;leaveForm.submit();"> &nbsp;&nbsp;&nbsp;&nbsp;
	<? if($loginDesignation!='Chairman & Managing Director') /* Stoped */{?><input type="button" name="Forword" value="Forward to MD" onClick="leaveForm.action.value=1;leaveForm.submit();"><? }?>
	<input type="hidden"  name="action" value="">
	</td>
</tr>
 </table>
</form>
<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>

* Annual Leave is 29 Days.<br>
* Managers are authorised to grant leave to employees working under them<br>
* Managing Director and Directores are authorised to grant leave to Managers.<br>
* Only Managing Director can approve leave when there in no leave day in balance.<br>
* Leave at Provision Period will be without payment.
<? }?>
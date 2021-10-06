<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>

<?
$format="Y-m-j";
$edat1 = formatDate($edat,$format);

?>

<form name="att" action="./employee/employeeAttendance.sql.php" method="post">
<table align="center" width="98%" border="3"  bordercolor="CC9999" cellpadding="2" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999"> 
<td align="left" colspan="2">
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
      <input type="text" maxlength="10" name="edat" value="<? echo $edat;?>"><a id="anchor" href="#"
   onClick="cal.select(document.forms['att'].edat,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
      <input type="button" name="go" value="Go" onClick="location.href='./index.php?keyword=eq+utilization+report&e=<? echo $e;?>&edat='+document.att.edat.value">
	  </td> 
 <td align="right" colspan="5" ><font class='englishhead'>equipment utilization</font></td>
</tr>
<? if($edat){?>
<tr>
  <th>Equipment Id</th>
  <th>Equipment Details</th>  
  <th colspan="5">Today</th>  
</tr>

<? 
$errorProject=207;

include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

/*
$sqlquery="SELECT eqattendance.* FROM eqattendance".
" where eqattendance.location='$loginProject' AND eqattendance.edate='$edat1'".
" AND action in('P','HP') ORDER by itemCode ASC ";
*/
	//==================================iow
	$sqlp = "SELECT iowId,`iowCode`,iowDes from `iow` WHERE iowStatus <> 'Not Ready' AND '$edat1' BETWEEN iowSdate AND iowCdate and supervisor!='' and iowProjectCode='$loginProject'";
	
if($errorProject)
	$sqlp = "SELECT iowId,`iowCode`,iowDes from `iow` WHERE iowStatus <> 'Not Ready' AND '$edat1' BETWEEN iowSdate AND iowCdate and supervisor!='' and iowProjectCode='$loginProject'";
// echo $sqlp;
	
$sqlrunp= mysqli_query($db, $sqlp);
 while($typel= mysqli_fetch_array($sqlrunp))
{	
		//==================================siow
$sqlp1="SELECT siowId,siowCode,siowName,siowQty,siowUnit,siowCdate,siowSdate
  from `siow` where `iowId` = $typel[iowId] AND '$edat1' BETWEEN siowSdate AND siowCdate ORDER by  siowCode ASC";
//echo $sqlp1;
$btn_sql3=$sqlp1;
$sqlrunp1= mysqli_query($db, $sqlp1);
$i=1;
while($res=mysqli_fetch_array($sqlrunp1)){
				//============================================find dma
				$sql_dma="select * from dma where dmaProjectCode='$loginProject' AND dmasiow='$res[siowId]'  AND dmaItemCode BETWEEN '50-00-000' AND '69-99-999'";
				$dma_q=mysqli_query($db,$sql_dma);
				while($dma_row=mysqli_fetch_array($dma_q)){
				//============================================find eqproject


	
	
	
	
	

$sqlquery="SELECT * from eqproject where pCode='$loginProject' and itemCode='$dma_row[dmaItemCode]'".
" AND  status>=1 AND (('$edat1' BETWEEN receiveDate AND edate) OR ('$edat1' >= receiveDate AND edate='0000-00-00' ))  ORDER by itemCode,assetId ASC ";	
	

	if($errorProject)
		$sqlquery="SELECT * from eqproject where pCode='$loginProject' and itemCode='$dma_row[dmaItemCode]'".
" AND  (('$edat1' BETWEEN receiveDate AND edate) OR ('$edat1' >= receiveDate AND edate='0000-00-00' ))  ORDER by itemCode,assetId ASC ";
// echo "$sqlquery<br>";
 $sql= mysqli_query($db, $sqlquery);
 while($re=mysqli_fetch_array($sql)){ 
  $type=eqType($re[assetId]);
 if(eq_isPresent($re[assetId],$re[itemCode],$edat1)>=1){
 
	$planDispatchDate=planDispatchDate($re[posl],$re[itemCode]); 

$remanDate=(strtotime($planDispatchDate)-strtotime($edat1))/86400;
//echo "remanDate=$remanDate";
 if($remanDate<=10) {$t=1;$bg="#FFFFCC";}
   else  {$bg="#FFFFFF";	$t=0;	}

?> 
<tr  <? echo " bgcolor=$bg";?>>
      <td align="center"><?php
	 
$invoiceLock=isEqPresentRequiredToLock($re[posl],$edat1); // true=lock
	 
if($invoiceLock)
	echo eqpId_local($re[assetId],$re[itemCode])."<br><span style='color: #fff;background: #00f;border-radius: 10px;    display: inline-block;padding: 2px;'>Invoice Verified</span>";
else
	if($type=='L'){
		
		echo "<a href='".
			 "./equipment/eqUtilization.php?siow=".$dma_row[dmasiow]."&eqId=".$re[assetId]."&itemCode=".$re[itemCode]."&eqType=L&edate=".$edat1."&posl=".$re[posl]."' target='_blank'>".
			 eqpId_local($re[assetId],$re[itemCode]).
			 "</a>"
			 ; $type='L';
		}else {
			
			
			
			echo 
			 "<a href='".
			 "./equipment/eqUtilization.php?siow=".$dma_row[dmasiow]."&eqId=".$re[assetId]."&itemCode=".$re[itemCode]."&eqType=H&edate=".$edat1."&posl=".$re[posl]."' target='_blank'>".
				
				eqpId($re[assetId],$re[itemCode]).	
				
				
				 "</a>";
			$type='H'; 
										 }
							
							
							?> 
		</td>
      <td><?  $temp=itemDes($re[itemCode]); echo $temp[des].', '.$temp[spc];?>
		<? if($t==1)echo '<br><font class=out>Dispatch on '.myDate($planDispatchDate).'</font>';?>	  
	   </td>  
  
	
	
	
	
	
	
	
	
	
	
	 <? 
//   echo "Pcode:$loginProject,eqID:$re[assetId],edate:$edat1,type:$type<br>";
	$dailyworkBreakt=eq_dailyworkBreak($re[assetId],$re[itemCode],$edat1,$type,$loginProject);
    $dailyBreakDown=eq_dailyBreakDown($re[assetId],$re[itemCode],$edat1,$type,$loginProject);
	 
	$getEqPresentRow=getEqPresentRow($re[assetId],$re[itemCode],$edat1,$type,$loginProject);
    $getUtilizationRow=getUtilizationRow($re[assetId],$re[itemCode],$edat1,$type,$loginProject);
	
	$toDaypresent=eq_toDaypresent($re[assetId],$re[itemCode],$edat1,$type,$loginProject);
	
    $toDaypresent=$toDaypresent-$dailyworkBreakt;	
	
	$workt= eq_dailywork($re[assetId],$re[itemCode],$edat1,$type,$loginProject);
	$overtimet = $toDaypresent-8*3600;
	if($overtimet<0) $overtimet=0;
	$idlet=$toDaypresent-$workt-$dailyBreakDown;
	  if($idlet<0) $idlet=0;
  
    ?>
	  <td><? echo ' Present: '.sec2hms($toDaypresent/3600,$padHours=true);?><br><small><?php echo $getEqPresentRow[stime]." - ".$getEqPresentRow[etime]; ?></small></td>
	  <td><? echo ' Overtime: '.sec2hms($overtimet/3600,$padHours=true);?></td>
		<td><? echo '  Worked: '.sec2hms($workt/3600,$padHours=true). "<small>"; 
			foreach($getUtilizationRow as $utiSingle)
				echo "<br>".$utiSingle;
			?></small></td>	
		<td>Breakdown: <? echo sec2hms($dailyBreakDown/3600,$padHours=true);?></td>
		<td>Idle: <? echo sec2hms($idlet/3600,$padHours=true);?></td>

 </tr>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
 <? 
 }//ispresent
 } //while eqproject
				}//while dma
				}//while siow
	}//iow while
 ?>
 
<? }//if edate?>
<!-- -->

</table>
</form>
<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
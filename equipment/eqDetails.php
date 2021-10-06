<?php
$sdat=$_POST[sdat] ? datFormat($_POST[sdat]) : "";
$fdat=$_POST[fdat] ? datFormat($_POST[fdat]) : "";
$todat=todat();

function itemCodeMarge($itemC,$assetId){	
					$itemArray=explode("-",$itemC);
					return $itemCode=$itemArray[0]."-".$itemArray[1]."-".$assetId;
}
?>

<table align="center" width="98%" border="3" bordercolor="CC9999" cellpadding="2" cellspacing="0" style="border-collapse:collapse">
  
		<form action="" method="post">
  <tr bgcolor="#CC9999"> 
			
		
    <td>
      Equipment:
      <select name="eqID">
				<option value="all">All</option>
				<?php
				
				$sql="SELECT e.*,i.itemDes FROM eqproject as e, itemlist as i WHERE e.posl LIKE 'EQ_206_%' AND e.status='1' and i.itemCode=e.itemCode and e.pCode='$loginProject' group by e.assetId";
				$q=mysqli_query($db,$sql);
				while($row=mysqli_fetch_array($q)){
				$itemCode=itemCodeMarge($row[itemCode],$row[assetId]);
				echo "<option value='$row[assetId]' ";
				echo $row[assetId]==$eqID ? " selected " : " ";
 				echo ">$itemCode $row[itemDes]</option>";	
				}
				 ?>
        
      </select>
			Sort by
			<select name="sortBy">
				<option value="dt" <?php echo $sortBy=="dt" ? "selected" : ""; ?> >Date</option>
				<option value="eq" <?php echo $sortBy=="eq" ? "selected" : ""; ?>>Equipment</option>
			</select>
    </td>
<td align="left">
	<script language="JavaScript">
	var now = new Date(); 
	var cal = new CalendarPopup("testdiv1");
    	//cal.showNavigationDropdowns();
		cal.setWeekStartDay(6); // week is Monday - Sunday
		//cal.addDisabledDates(null,formatDate(now,"yyyy-MM-dd")); 
		cal.setCssPrefix("TEST");		
		cal.offsetX = 0;
		cal.offsetY = 0;
	</script> From:
      <input type="text" maxlength="10" size='10' name="sdat" value="<?php echo $_POST[sdat] ? $_POST[sdat] : "01/01/2016"; ?>"> <a id="anchor" href="#" onclick="cal.select(document.forms['att'].edat,'anchor','dd/MM/yyyy'); return false;" name="anchor"><img src="./images/b_calendar.png" alt="calender" border="0"></a> </td><td>
      To: 
      <input type="text" maxlength="10" size='10' name="fdat" value="<?php echo $_POST[fdat] ? $_POST[fdat] : "01/01/2016"; ?>"> <a id="anchor" href="#" onclick="cal.select(document.forms['att'].edat,'anchor','dd/MM/yyyy'); return false;" name="anchor"><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
      <input type="submit" name="go" value="Go" onclick="location.href='./index.php?keyword=eq+utilization+report&amp;e=&amp;edat='+document.att.edat.value">
	  </td> 
 <td align="right" colspan="5"><font class="englishhead">equipment usage details</font></td>
</tr>
			</form>
  
<?php
if($sdat && $fdat)	{
	if($eqID && $eqID!="all"){
		if($sortBy=="dt"){

			//date shorting			
				 $sql_date="select e.eqId,e.itemCode,e.edate from equt as e where e.pcode='$loginProject' and e.eqId!='' and e.eqId='$eqID' and e.edate>='$sdat' and  e.edate<='$fdat' group by e.edate order by e.edate desc";
				$q_date=mysqli_query($db,$sql_date);
				while($date_row=mysqli_fetch_array($q_date)){?>
	
	<tr>
		<td colspan="4" style="text-align:center; height: 50px; font-weight: 700; color: #00f; background: #ffd2c1;"><?php echo date("D d-m-Y",strtotime($date_row[edate])); ?></td>
	</tr>
	
		<?php
//equipment shorting
	$sql="select e.eqId,i.itemDes,i.itemCode from equt as e,itemlist as i where e.pcode='$loginProject'  and e.edate='$date_row[edate]' and e.eqId!='' and e.eqId='$eqID' and i.itemCode=e.itemCode group by e.eqId  ";
			$qq=mysqli_query($db,$sql);
			while($q_row=mysqli_fetch_array($qq)){ ?>
  <tr style="background:#feffba;"> 
    <td colspan="4">
			<?php 
					echo itemCodeMarge($q_row[itemCode],$q_row[eqId]);
					echo " ";
					echo $q_row[itemDes];
			?>
		</td>  
  </tr>
	<?
			$sql_eq="select e.* from equt as e where e.pcode='$loginProject' and e.eqId='$q_row[eqId]' and e.eqId!='' and e.edate='$date_row[edate]'  group by e.etime order by e.itemCode,e.stime asc";			
			$q=mysqli_query($db,$sql_eq);
			while($row=mysqli_fetch_array($q)){?>
	<tr>
		<td><?php echo $row[stime]; ?> - <?php echo $row[etime]; ?></td>
		<td colspan=3><?php echo $row[details]; ?></td>
	</tr>
<?
	 $eqId=$row[eqId]; $itemCode=$row[itemCode]; $edate1=$row[edate]; $eqType=eqType($row[assetId]); 
}
																				 

		echo '<tr style="border-bottom: 4px solid #c99;">
	<td colspan=4><p align="center" style="margin:0;">';
		
$dailyworkBreakt=eq_dailyworkBreak($eqId,$itemCode,$edate1,$eqType,$loginProject);
$dailyBreakDown=eq_dailyBreakDown($eqId,$itemCode,$edate1,$eqType,$loginProject);

$toDaypresent=eq_toDaypresent($eqId,$itemCode,$edate1,$eqType,$loginProject)-$dailyworkBreakt;

$workt= eq_dailywork($eqId,$itemCode,$edate1,$eqType,$loginProject);
if(date('D',strtotime($edate1))=='Fri')
 $overtimet = $toDaypresent-(4*3600);
else 
	$overtimet = $toDaypresent-(8*3600);

if($overtimet<0) $overtimet=0;
$idlet=$toDaypresent-$workt-$dailyBreakDown;
  if($idlet<0) $idlet=0;
?>
Present: <?   echo sec2hms($toDaypresent/3600,$padHours=false);?>
 Worked: <?   $work= sec2hms($workt/3600,$padHours=false);   echo $work.' Hrs.,    ';  ?>
 Break Down: <font class=out><?   $dailyBreakDown= sec2hms($dailyBreakDown/3600,$padHours=false);  
  echo $dailyBreakDown.' Hrs.,    ';  ?> </font>
 Overtime: <?  $overtime=sec2hms($overtimet/3600,$padHours=false);  echo $overtime;  ?>; 
 Idle: <?  $idle=sec2hms($idlet/3600,$padHours=false);  echo $idle.' Hrs.,   ';  
 echo '</p>'; 

		?>
	
	
	
	
	</td>
	</tr>
	
			<?php  } } //while
			
		}
		elseif($sortBy=="eq"){

			
			
			 $sql="select e.eqId,i.itemDes,i.itemCode from equt as e,itemlist as i where e.pcode='$loginProject'  and e.edate>='$sdat' and  e.edate<='$fdat' and e.eqId!='' and e.eqId='$eqID' and i.itemCode=e.itemCode group by e.eqId  ";
			$qq=mysqli_query($db,$sql);
			while($q_row=mysqli_fetch_array($qq)){ ?>
  <tr style="background:#feffba;    height: 50px;"> 
    <td colspan="4">
			<?php 
					echo itemCodeMarge($q_row[itemCode],$q_row[eqId]);
					echo " ";
					echo $q_row[itemDes];
			?>
		</td>  
  </tr>
	<?php 
			
				 $sql_date="select e.eqId,e.itemCode,e.edate from equt as e where e.pcode='$loginProject' and e.eqId='$eqID' and e.eqId!='' and e.edate>='$sdat' and  e.edate<='$fdat' group by e.eqId,e.edate order by e.eqId,e.edate desc";
				$q_date=mysqli_query($db,$sql_date);
				while($date_row=mysqli_fetch_array($q_date)){?>
	
	<tr>
		<td colspan="4" style="text-align: center;
    font-weight: 700;
    color: #00f;
    background: #ffd2c1;"><?php echo date("D d-m-Y",strtotime($date_row[edate])); ?></td>
	</tr>
				
				<?
			$sql_eq="select e.* from equt as e where e.pcode='$loginProject' and e.itemCode='$q_row[itemCode]' and e.eqId!='' and e.edate='$date_row[edate]'  group by e.etime order by e.itemCode,e.stime asc";			
			$q=mysqli_query($db,$sql_eq);
			while($row=mysqli_fetch_array($q)){?>
	<tr>
		<td><?php echo $row[stime]; ?> - <?php echo $row[etime]; ?></td>
		<td colspan=3><?php echo $row[details]; ?></td>
	</tr>
<?
	 $eqId=$row[eqId]; $itemCode=$row[itemCode]; $edate1=$row[edate]; $eqType=eqType($row[assetId]); 
}
																				 

		echo '<tr style="border-bottom: 4px solid #c99;">
	<td colspan=4><p align="center" style="margin:0;">';
		
$dailyworkBreakt=eq_dailyworkBreak($eqId,$itemCode,$edate1,$eqType,$loginProject);
$dailyBreakDown=eq_dailyBreakDown($eqId,$itemCode,$edate1,$eqType,$loginProject);

$toDaypresent=eq_toDaypresent($eqId,$itemCode,$edate1,$eqType,$loginProject)-$dailyworkBreakt;

$workt= eq_dailywork($eqId,$itemCode,$edate1,$eqType,$loginProject);
if(date('D',strtotime($edate1))=='Fri')
 $overtimet = $toDaypresent-(4*3600);
else 
	$overtimet = $toDaypresent-(8*3600);

if($overtimet<0) $overtimet=0;
$idlet=$toDaypresent-$workt-$dailyBreakDown;
  if($idlet<0) $idlet=0;
?>
Present: <?   echo sec2hms($toDaypresent/3600,$padHours=false);?>
 Worked: <?   $work= sec2hms($workt/3600,$padHours=false);   echo $work.' Hrs.,    ';  ?>
 Break Down: <font class=out><?   $dailyBreakDown= sec2hms($dailyBreakDown/3600,$padHours=false);  
  echo $dailyBreakDown.' Hrs.,    ';  ?> </font>
 Overtime: <?  $overtime=sec2hms($overtimet/3600,$padHours=false);  echo $overtime;  ?>; 
 Idle: <?  $idle=sec2hms($idlet/3600,$padHours=false);  echo $idle.' Hrs.,   ';  
 echo '</p>'; 

		?>
	
	
	
	
	</td>
	</tr>
	
			<?php  } } //while
			
			
			
			
		}
		
		
	}
	elseif($eqID=="all"){
		if($sortBy=="dt"){
		//date shorting			
				 $sql_date="select e.eqId,e.itemCode,e.edate from equt as e where e.pcode='$loginProject' and e.eqId!='' and e.edate>='$sdat' and  e.edate<='$fdat' group by e.edate order by e.edate desc";
				$q_date=mysqli_query($db,$sql_date);
				while($date_row=mysqli_fetch_array($q_date)){	?>	
	
	<tr>
		<td colspan="4" style="text-align: center;     height: 50px;
    font-weight: 700;
    color: #00f;
    background: #ffd2c1;"><?php echo date("D d-m-Y",strtotime($date_row[edate])); ?></td>
	</tr>
	
		<?php
//equipment shorting
	$sql="select e.eqId,i.itemDes,i.itemCode from equt as e,itemlist as i where e.pcode='$loginProject'  and e.edate='$date_row[edate]' and e.eqId!='' and i.itemCode=e.itemCode group by e.eqId  ";
			$qq=mysqli_query($db,$sql);
			while($q_row=mysqli_fetch_array($qq)){ ?>
  <tr style="background:#feffba;"> 
    <td colspan="4">
			<?php 
					echo itemCodeMarge($q_row[itemCode],$q_row[eqId]);
					echo " ";
					echo $q_row[itemDes];
			?>
		</td>  
  </tr>
	<?
			$sql_eq="select e.* from equt as e where e.pcode='$loginProject' and e.eqId='$q_row[eqId]' and e.eqId!='' and e.edate='$date_row[edate]'  group by e.etime order by e.itemCode,e.stime asc";			
			$q=mysqli_query($db,$sql_eq);
			while($row=mysqli_fetch_array($q)){?>
	<tr>
		<td><?php echo $row[stime]; ?> - <?php echo $row[etime]; ?></td>
		<td colspan=3><?php echo $row[details]; ?></td>
	</tr>
<?
	 $eqId=$row[eqId]; $itemCode=$row[itemCode]; $edate1=$row[edate]; $eqType=eqType($row[assetId]); 
}
																				 

		echo '<tr style="border-bottom: 4px solid #c99;">
	<td colspan=4><p align="center" style="margin:0;">';
		
$dailyworkBreakt=eq_dailyworkBreak($eqId,$itemCode,$edate1,$eqType,$loginProject);
$dailyBreakDown=eq_dailyBreakDown($eqId,$itemCode,$edate1,$eqType,$loginProject);

$toDaypresent=eq_toDaypresent($eqId,$itemCode,$edate1,$eqType,$loginProject)-$dailyworkBreakt;

$workt= eq_dailywork($eqId,$itemCode,$edate1,$eqType,$loginProject);
if(date('D',strtotime($edate1))=='Fri')
 $overtimet = $toDaypresent-(4*3600);
else 
	$overtimet = $toDaypresent-(8*3600);

if($overtimet<0) $overtimet=0;
$idlet=$toDaypresent-$workt-$dailyBreakDown;
  if($idlet<0) $idlet=0;
?>
Present: <?   echo sec2hms($toDaypresent/3600,$padHours=false);?>
 Worked: <?   $work= sec2hms($workt/3600,$padHours=false);   echo $work.' Hrs.,    ';  ?>
 Break Down: <font class=out><?   $dailyBreakDown= sec2hms($dailyBreakDown/3600,$padHours=false);  
  echo $dailyBreakDown.' Hrs.,    ';  ?> </font>
 Overtime: <?  $overtime=sec2hms($overtimet/3600,$padHours=false);  echo $overtime;  ?>; 
 Idle: <?  $idle=sec2hms($idlet/3600,$padHours=false);  echo $idle.' Hrs.,   ';  
 echo '</p>'; 

		?>
	
	
	
	
	</td>
	</tr>
	
			<?php  } } //while
			
		
		}
		elseif($sortBy=="eq"){
			 $sql="select e.eqId,i.itemDes,i.itemCode from equt as e,itemlist as i where e.pcode='$loginProject'  and e.edate>='$sdat' and  e.edate<='$fdat' and e.eqId!='' and i.itemCode=e.itemCode group by e.eqId  ";
			$qq=mysqli_query($db,$sql);
			while($q_row=mysqli_fetch_array($qq)){ ?>
  <tr style="background:#feffba;    height: 50px;"> 
    <td colspan="4">
			<?php 
					echo itemCodeMarge($q_row[itemCode],$q_row[eqId]);
					echo " ";
					echo $q_row[itemDes];
			?>
		</td>  
  </tr>
	<?php 
			
				 $sql_date="select e.eqId,e.itemCode,e.edate from equt as e where e.pcode='$loginProject' and e.eqId='$q_row[eqId]' and e.eqId!='' and e.edate>='$sdat' and  e.edate<='$fdat' group by e.eqId,e.edate order by e.eqId,e.edate desc";
				$q_date=mysqli_query($db,$sql_date);
				while($date_row=mysqli_fetch_array($q_date)){?>
	
	<tr>
		<td colspan="4" style="text-align: center;
    font-weight: 700;
    color: #00f;
    background: #ffd2c1;"><?php echo date("D d-m-Y",strtotime($date_row[edate])); ?></td>
	</tr>
				
				<?
			$sql_eq="select e.* from equt as e where e.pcode='$loginProject' and e.itemCode='$q_row[itemCode]' and e.eqId!='' and e.edate='$date_row[edate]'  group by e.etime order by e.itemCode,e.stime asc";			
			$q=mysqli_query($db,$sql_eq);
			while($row=mysqli_fetch_array($q)){?>
	<tr>
		<td><?php echo $row[stime]; ?> - <?php echo $row[etime]; ?></td>
		<td colspan=3><?php echo $row[details]; ?></td>
	</tr>
<?
	 $eqId=$row[eqId]; $itemCode=$row[itemCode]; $edate1=$row[edate]; $eqType=eqType($row[assetId]); 
}
																				 

		echo '<tr style="border-bottom: 4px solid #c99;">
	<td colspan=4><p align="center" style="margin:0;">';
		
$dailyworkBreakt=eq_dailyworkBreak($eqId,$itemCode,$edate1,$eqType,$loginProject);
$dailyBreakDown=eq_dailyBreakDown($eqId,$itemCode,$edate1,$eqType,$loginProject);

$toDaypresent=eq_toDaypresent($eqId,$itemCode,$edate1,$eqType,$loginProject)-$dailyworkBreakt;

$workt= eq_dailywork($eqId,$itemCode,$edate1,$eqType,$loginProject);
if(date('D',strtotime($edate1))=='Fri')
 $overtimet = $toDaypresent-(4*3600);
else 
	$overtimet = $toDaypresent-(8*3600);

if($overtimet<0) $overtimet=0;
$idlet=$toDaypresent-$workt-$dailyBreakDown;
  if($idlet<0) $idlet=0;
?>
Present: <?   echo sec2hms($toDaypresent/3600,$padHours=false);?>
 Worked: <?   $work= sec2hms($workt/3600,$padHours=false);   echo $work.' Hrs.,    ';  ?>
 Break Down: <font class=out><?   $dailyBreakDown= sec2hms($dailyBreakDown/3600,$padHours=false);  
  echo $dailyBreakDown.' Hrs.,    ';  ?> </font>
 Overtime: <?  $overtime=sec2hms($overtimet/3600,$padHours=false);  echo $overtime;  ?>; 
 Idle: <?  $idle=sec2hms($idlet/3600,$padHours=false);  echo $idle.' Hrs.,   ';  
 echo '</p>'; 

		?>
	
	
	
	
	</td>
	</tr>
	
			<?php  } } //while
			
		}		
	}
}
?>
  
</table>
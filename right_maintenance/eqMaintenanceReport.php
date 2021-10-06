<?php
$positionExp=explode(".",$resultiow[position]);
if($positionExp[0]=="888" && $resultiow[iowStatus]!="noStatus" && $positionExp[0].$positionExp[1]!="888003")
//if($diagonosis_info[dt]>0)
{
  $mSql="select * from diagonosis_info where dia='$diagonosis_info[dt]'";
  $mQ=mysqli_query($db,$mSql);
  $mRow=mysqli_fetch_array($mQ);
?>
<style>
	.strip-table{}
	.strip-table tr:nth-child(odd){background:#efefef;}
	.color-blue{color:#00f;}
</style>

<table width="98%"  align="center" border="1" bordercolor="#9999CC" cellpadding="0" cellspacing="0" style="border-collapse:collapse" class="strip-table" >
	<tr><td colspan="2" bgcolor="#9999CC" height="20" align="center">
		<b><font color="#FFFFFF">Diagnosis &amp; Treatment</font></b></td></tr>

<!--   <tr><td width="30%">Complaint Details: <font class="out"></font></td><td><font class="out"><?php echo $mRow[problemFound]; ?></font></td></tr> -->
  
  <tr><td width="30%">Equipment Details: <font class="out"></font></td>
		<td><?php
			$eqDetails=getEqDetailsByEQID($diagonosis_info[eqItemCode],$diagonosis_info[eqID]);
			$tExp=explode("_",$eqDetails[teqSpec]);
			?>
			<font class="color-blue"><?php echo $eqDetails[itemCode].$eqDetails[assetId]; ?>; </font>
			<br><font class="color-blue"><?php echo $tExp[0]; ?>; </font>
			<br>Capacity: <font class="color-blue"><?php echo $eqDetails[exp]; ?>; </font>
			<br>Purchase Price: <font class="color-blue"><?php echo number_format($eqDetails[price],2); ?>; </font>
			<br>Life: <font class="color-blue"><?php echo $eqDetails[life]; ?> Years; </font>
			<br>Current Price: <font class="color-blue">Tk. <?php
	$life=$eqDetails[life];
	$salaveValue=$eqDetails[salvageValue];
	$price=$eqDetails[price];
	$procurementDate=$eqDetails[edate];
	$todat=todat();
	$daysDiffer=(strtotime($todat)-strtotime($procurementDate))/84600;
	$perDayTk=(($price-$salaveValue)/$life)/365;
	$equipmentLife=$life*365;
	$lifeLeft=$equipmentLife-$daysDiffer;
	echo number_format(($perDayTk*$lifeLeft)+$salaveValue ,2);
	?>; </font>
			<br>Procurement Date: <font class="color-blue"><?php echo date("d-m-Y",strtotime($eqDetails[edate])); ?>; </font>
			<br>Measurement Unit: <font class="color-blue"><?php echo measuerUnti2Des($eqDetails[measureUnit]); ?>; </font>
		</td></tr>  
	
  <tr><td width="30%">Operator: <font class="out"></font></td><td><font class="out">
<?php 
	if($mRow[driverID]){
		$driverInfo=empID2empInfo($mRow[driverID]);
		echo "".local_empId($driverInfo[empId],$driverInfo[designation]).": ";
		echo $driverInfo[name];
	}
?></font></td></tr>
  
  <tr><td width="30%">Operator's description of the problem: <font class="out"></font></td><td><font class="out"><?php 
$eqMaintenance=diagonosis2Eqmaintenance(null,null,$resultiow[iowCode]);
if($eqMaintenance[maintenanceType]=="b")
	$type="breakdown";
elseif($eqMaintenance[maintenanceType]=="tr")
	$type="troubledRunning";
	
	$lastAllReasons=getLastReason($eqMaintenance[eqID],$eqMaintenance[eqItemCode],$type);
foreach($lastAllReasons as $singleReason){
	echo date("d-m-Y",strtotime($singleReason[0])).": $singleReason[1]<br>";
}
?></font></td></tr>
  
  <tr><td width="30%">Technician: <font class="out"></font></td><td><font class="out"><?php echo $mRow[technicianName]; ?></font></td></tr>
  
  <tr>
		<td width="30%">Is this a repeat Failure: 
			<font class="out"></font></td>
		<td>
<!-- 			<font class="out"><?php echo $mRow[repeatFailure]; ?></font>   -->
			<?php if($mRow[repeatFailure]=="yes"){ ?>
		<font class="out"><?php echo $mRow[repeatFailureTxt] ? "<small><b>".$mRow[repeatFailureTxt]."</b></small>: ".getIOWinfo($mRow[repeatFailureTxt]) : ""; ?></font>
			<?php } ?>
    </td>
	</tr>
  
  <tr><td width="30%">Diagnosis Plan: <font class="out"></font></td><td><font class="out"><?php echo $mRow[diagonosisPlan]; ?></font></td></tr>
  
  <tr><td width="30%">Complete Description of the Failure/Findings: <font class="out"></font></td><td><font class="out"><?php echo $mRow[descFailureFindings]; ?></font></td></tr>
  
  <tr><td width="30%">Causes of Failure: <font class="out"></font></td><td><font class="out"><?php echo $mRow[casesFailure]; ?></font></td></tr>  
	
  <tr><td width="30%">Details Observations on the Failed Parts: <font class="out"></font></td><td><font class="out"><a href="<?php echo $mRow[attachIMG] ? $mRow[attachIMG] : "#"; ?>" target1="_blank">Image</a>, <a href="<?php echo $mRow[attachPDF] ? $mRow[attachPDF] : "#";?>" target1="_blank">PDF</a></font></td></tr>
  
  <tr><td width="30%">Corrective Action Rocommanded: <font class="out"></font></td><td><font class="out"><?php echo $mRow[correctiveAction]; ?></font></td></tr>
  
  <tr><td width="30%">Estimated Life of Repairing or Servicing: <font class="out"></font></td><td><font class="out"><?php echo $mRow[estimatedLifeRepairing];
//print_r($mRow);
?></font> days</td></tr>

</table>
<?php } ?>
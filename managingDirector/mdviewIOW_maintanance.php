<?php
error_reporting(E_ERROR | E_PARSE);
?>
<form name="searchIOW" action="./index.php?keyword=mdview+IOW+maintenance" method="post">
<table width="90%"  align="center" class="dblue">
<tr>
	<td bgcolor="#0066FF" colspan="5" align="center">
 		<font class="englishhead">Maintanance Item of Work (IOW) details</font>
	</td>
</tr>
<tr>
 <?

		$theSelectedPcode=$selectedPcode;
	 	$selectedPcode="004";
	 
 if($status=='Forward to MD') $r1='checked';
 else if($status=='Raised by PM') $r2='checked'; 
  else if($status=='Approved') $r3='checked';  
    else if($status=='Completed') $r4='checked'; 
      else if($status=='Not Ready') $r5='checked';  

// Approved by MD Approved by Mngr P&C
 ?>
     <td><input type="radio" name="status" <? echo $r1;?> value="Forward to MD">Waiting for MD's Approval (<font color="#f00"><? echo countiow_maintenance("Forward to MD",$selectedPcode);?></font> nos)</td>
    <td><input type="radio" name="status" <? echo $r3;?> value="Approved">Approved (<font color="#f00"><? echo countapviow_maintenance("Approved",$selectedPcode);?></font> nos)</td>
    <td><input type="radio" name="status" <? echo $r4;?> value="Completed">Completed (<font color="#f00"><? echo countapviow_maintenance("Completed",$selectedPcode);?></font> nos)</td>

</tr>
<tr>
     <td><input type="radio" name="status" <? echo $r2;?> value="Raised by PM">Waiting for Mngr. P&C's Checking (<font color="#f00"><? echo countiow_maintenance("Raised by PM",$selectedPcode);?></font> nos)</td>
     <td><input type="radio" name="status" <? echo $r5;?> value="Not Ready">Under Preparation (<font color="#f00"><? echo countiow_maintenance("Not Ready",$selectedPcode);?></font> nos)</td>
</tr>

	<style>
		.selectedPcode option:nth-child(odd){background:#fee;}
	</style>

 <tr><td colspan="2">
	 Select Project: <select name="selectedPcode" class="selectedPcode">

<?
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);
	 


function apv($pcode, $iow)
{
	global $db;
$sqliow = "SELECT * from `iowtemp` where `iowProjectCode` = '$pcode'  AND `iowId` = '$iow'";
//echo $sqliow;
$sqlruniow= mysqli_query($db, $sqliow);
$resultiow=mysqli_fetch_array($sqlruniow);
$iocode=$resultiow['iowCode'];

$sqlsiow = "SELECT * from `siowtemp` where `iowId` = '$iow' ORDER BY siowId ASC";
//echo $sqlsiow;
$sqlrunsiow= mysqli_query($db, $sqlsiow);
$i=1;
while($siow=mysqli_fetch_array($sqlrunsiow))
{
	$approvedtotalcost=0;
	//echo $siow[siowId];
	$sqlp ="SELECT * FROM `dmatemp` WHERE  `dmasiow` LIKE '$siow[siowId]' order by dmaItemCode ASC";
	//echo $sqlp;
	$sqlrunp= mysqli_query($db, $sqlp);
	$totalAmount='';
	while($iowResult=mysqli_fetch_array($sqlrunp))
	  	{
	  	$approvedAmount=0;
	  	$test=explode("-",$iowResult['dmaItemCode']);
	  	if($test[0]>='50' AND $test[0]<='98'){	$itemCode="$test[0]-$test[1]-000";}
      	else {$itemCode=$iowResult['dmaItemCode'];}

		$approvedQty=approvedQty($siow['siowId'],$itemCode); 
	    $approvedRate=approvedRate($siow['siowId'],$itemCode); //echo number_format($approvedRate,2);
		 $approvedAmount=$approvedQty*$approvedRate;// echo number_format($approvedAmount,2);
		 if($test[0]>='01' AND $test[0]<'35'){$approvedmaterialCost+=$approvedAmount;}
		 elseif($test[0]>='35' AND $test[0]<'70'){$approvedequipmentCost+=$approvedAmount;}
		 elseif($test[0]>='70'){$approvedhumanCost+=$approvedAmount;}
		 $approveddirectCost+=$approvedAmount;	 	 
		 $approvedtotalcost=$approvedtotalcost+$approvedAmount;
		$totalCost=$resultiow['iowQty']*$resultiow['iowPrice'];
 
		$rate=$iowResult['dmaRate'];
		$amount=$rate*$iowResult['dmaQty'];
		if($test[0]>='01' AND $test[0]<'35'){$materialCost+=$amount;}
	 	elseif($test[0]>='35' AND $test[0]<'70'){$equipmentCost+=$amount;}
	 	elseif($test[0]>='70'){$humanCost+=$amount;}
	 	$directCost+=$amount;	 
	 	if($amount==0) {$tt=1; }
	 	$totalAmount+= $amount;
	 	$i++; 
	 }
	//echo "Sub Total Amount: Tk.".number_format($approvedtotalcost,2);
	//echo "Sub Total Amount: Tk.".number_format($totalAmount,2);
}
$approvedtotalcost=approvedtotalcost($iow);
if($directCost>0)
{
echo number_format(($directCost/$totalCost)*100);
}
 else
 {
 echo "0";
 }    
}
	


$sqlp = "SELECT `pcode`,pname from `project` where pcode='004' order by pcode ASC";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

while($typel= mysqli_fetch_array($sqlrunp))
{
		$itemCounter=the_iow_counter_eqMaintenance($r3,$typel['pcode'],$iow,$status,true);
	  echo "<option value='".$typel['pcode']."'";
	  if($itemCounter)echo " style='font-weight:600;  color:#f00;'";
	  if($theSelectedPcode==$typel['pcode']) echo ' SELECTED';
	  echo ">$typel[pcode]--$typel[pname]  (".$itemCounter." Nos)</option>  ";
 }
?> </select> </td><td>
&nbsp;&nbsp;<input type="submit" name="search" value="Search"></td></tr>
</table>

</form>
<?
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 
	//===================================================== iow sql =====================================================
	
if($r3){
	$sqlp = "SELECT * from `iow` WHERE 1";
	if($selectedPcode) $sqlp.= " AND iowProjectCode= '$selectedPcode'";else  $sqlp.= " AND iowProjectCode= '000'";
	if($iow) $sqlp.= " AND iowCode= '$iow'";
	if($status) $sqlp.= " AND `position` LIKE '888.%' AND (iowStatus LIKE '%$status%' or iowStatus='noStatus')";
	$sqlp.= "  ORDER By position ASC";
	//echo $sqlp;
	$sqlrunp= mysqli_query($db, $sqlp);

}
else {
	$sqlp = "SELECT * from `iowtemp` WHERE 1";
	if($selectedPcode) $sqlp.= " AND iowProjectCode= '$selectedPcode'";else  $sqlp.= " AND iowProjectCode= '000'";
	if($iow) $sqlp.= " AND iowCode= '$iow'";
	if($status) $sqlp.= " AND `position` LIKE '888.%' AND (iowStatus LIKE '%$status%' or iowStatus='noStatus')";
	$sqlp.= "  ORDER By position ASC";
	//echo $sqlp;
	$sqlrunp= mysqli_query($db, $sqlp);
}
// echo $sqlp;	
	
	//========================================================end iow sql=====================================================
?>

<table  align="center" width="98%" border="0" bordercolor="#E0E0E0" cellpadding="5" cellspacing="1" style="border-collapse:collapse">
<tr bgcolor="#0066FF">
 <th height="30" class="th1">Location</th> 
 <th class="th1">IOW Code</th>
 <th class="th1">Item of Work Description</th>
 <th class="th1">Qty</th>
 <th class="th1">Unit</th> 
 <th class="th1">Rate</th>  
 <th class="th1">Amount</th>
</tr>

<? 
$i=1;
while($iow=mysqli_fetch_array($sqlrunp)){
if($iow["iowStatus"]!='noStatus')
	if(!getEqmaintenancePcode($iow['iowCode'],$theSelectedPcode))continue;
	$i++;
?>

<?php if($iow["iowStatus"]!='noStatus'){ ?>
	
<tr <?  echo trColor($i);?>>
 <td width="10"><?php echo getEqmaintenancePcode($iow['iowCode']); ?></td>
 <td width="100">
 <?
  if($status=='Approved')
	echo "<a href='./index.php?keyword=mdview+dma&selectedPcode=$iow[iowProjectCode]&iow=$iow[iowId]&iowStatus=$iow[iowStatus]'>";
 else echo "<a href='./index.php?keyword=pmview+temp+dma&selectedPcode=$iow[iowProjectCode]&iow=$iow[iowId]'>";

	$selectedPcode=$iow['iowProjectCode'];
	$iowid=$iow['iowId'];
 ?>
 
 
 <? echo $iow['iowCode'].' (R:'.$iow['revisionNo'].')';?> </a></td>
 <td width="200"><? echo $iow['iowDes'];?></td> 
 <td align="right"><? echo number_format($iow['iowQty']);?></td> 
 <td align="right"><? echo $iow['iowUnit'];?></td>  
 <td align="right"><? echo number_format($iow['iowPrice'],2);?></td> 
 <td align="right"><? echo number_format($iow['iowQty']*$iow['iowPrice'],2);?>
 <? 
echo " [ ";
if($status=="Approved"){echo "<a href='./print/print_approvedSIOW.php?selectedPcode=$iow[iowProjectCode]&iow=$iow[iowId]' target=_blank>Print</a>";} 
	elseif($status=="Not Ready"){echo "<a href='./print/print_underSIOW.php?selectedPcode=$iow[iowProjectCode]&iow=$iow[iowId]' target=_blank>Print</a>";}
	else{echo "<a href='./print/print_tempSIOW.php?selectedPcode=$iow[iowProjectCode]&iow=$iow[iowId]' target=_blank>Print</a>";}	
   echo " ] ";

$materialCost=materialCost($iow['iowId']);
$equipmentCost=equipmentCost($iow['iowId']);
$humanCost=humanCost($iow['iowId']);
$totalCost=$iow['iowQty']*$iow['iowPrice'];
$directCost=$materialCost+$equipmentCost+$humanCost;

 ?>
 <? //created by salma
/*$tt=0;
 print $sqlsiow = "SELECT * from `siowtemp` where `iowId` = '$iow[iowId]' ORDER BY siowId ASC";
//echo $sqlsiow;
$sqlrunsiow= mysqli_query($db, $sqlsiow);
$siow=mysqli_fetch_array($sqlrunsiow);
print $sqliow = "SELECT * from `iowtemp` where `iowProjectCode` = '$iow[iowProjectCode]'  AND `iowId` = '$iow[iowId]'";
$sqlruniow= mysqli_query($db, $sqliow);
$resultiow=mysqli_fetch_array($sqlruniow);
$totalCost1=$resultiow[iowQty]*$resultiow[iowPrice];

print $sqlp ="SELECT * FROM `dmatemp` WHERE  `dmasiow` LIKE '$siow[siowId]' order by dmaItemCode ASC";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
$totalAmount='';
while($iowResult=mysqli_fetch_array($sqlrunp))
{ 
   $approvedAmount=0;
  
  $test=explode("-",$iowResult[dmaItemCode]);
   $amount=$iowResult[rate]*$iowResult[dmaQty];
	 if($test[0]>='01' AND $test[0]<'35'){$materialCost+=$amount;}
	 elseif($test[0]>='35' AND $test[0]<'70'){$equipmentCost+=$amount;}
	 elseif($test[0]>='70'){$humanCost+=$amount;}
	 $directCost1+=$amount;	 
	 if($amount==0) {$tt=1; }
	 $totalAmount+= $amount;
}*/
?>

 <br>
 Estimated Dir. Exp. <font class="out"><? apv($theSelectedPcode,$iowid)//echo number_format(($directCost1/$totalCost1)*100);?>%,</font> Approved  <font class="out"><? echo number_format(($directCost/$totalCost)*100);?>%</font> </td> 
</tr>
<? 
																		} //nostatus
																		else{
	 $position=count_dot_number($iow['position'])-1; //change position to one position left
  $positionVal=md_IOW_headerFormat($position);
?>
																			<tr  <? if($iow["iowStatus"]=='noStatus')echo "style='background:#ffc;font-weight: bold; border:1px solid #A99600;'";?>>
 <td width="10"><? //echo $iow[iowProjectCode];?></td>
 <td width="100" >

  </td>
 <td <? if($iow["iowStatus"]=='noStatus')echo " colspan='6'";?>><? echo  "<span style='    color: #f00;
    font-weight: normal;
    font-size: 14px;'>".$positionVal."</span> ".$iow['iowDes'];?></td> 

</tr> 																																		
	<?php  }//nostatus
	} ?>
</table>
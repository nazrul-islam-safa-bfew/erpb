<?
$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
include($localPath."/project/siteDailyReport.f.php");
if($Save){
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);

$time=mktime(0,0,0, date("m"),date("d"),date("y"));

$updatetime = date('d-m-Y',strtotime(todat()));

if($check=='Forward to MD' || $check=='Forward to PM'){
	$Checked="<b>Checked </b> at $updatetime by $loginFullName [$loginDesignation]";
	$sqlup=" UPDATE iowtemp SET Checked='$Checked',Approved='$approve', iowStatus='$check'";
	$sqlup.=" WHERE iowId='$iow' AND iowProjectCode='$selectedPcode' ";
	$sqlupdate=mysqli_query($db, $sqlup);
}
elseif($check=='Forward to PM' && 1==2){
	$Checked="<b>Checked </b> at $updatetime by $loginFullName [$loginDesignation]";
	$sqlup=" UPDATE iowtemp SET Checked='$Checked',Approved='$approve', iowStatus='$check'";
	$sqlup.=" WHERE iowId='$iow' AND iowProjectCode='$selectedPcode' ";
	$sqlupdate=mysqli_query($db, $sqlup);
}
elseif($check=='Approved by Mngr P&C'){
	$approve="<b>Approved at</b> $updatetime by $loginFullName [$loginDesignation]" ;
	$sqlup=" UPDATE iowtemp SET Checked='$Checked',Approved='$approve', iowStatus='$check'";
	$sqlup.=" WHERE iowId='$iow' AND iowProjectCode='$selectedPcode' ";
	$sqlupdate=mysqli_query($db, $sqlup);
}
elseif($check=='Not Ready'){
	$sqldma=" UPDATE dmatemp SET dmaRate='' WHERE dmaiow=$iow ";
	mysqli_query($db, $sqldma);

	$sqlup=" UPDATE iowtemp SET Checked='',Approved='', iowStatus='Not Ready',Prepared=''";
	$sqlup.=" WHERE iowId='$iow' AND iowProjectCode='$selectedPcode' ";
	$sqlupdate=mysqli_query($db, $sqlup);
}

//echo $sqlup;

echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=index.php?keyword=pmview+IOW&selectedPcode=$selectedPcode&status=Raised+by+PM\">";
}//save
?>
<?

if($check){
	$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
	include($localPath."/includes/config.inc.php"); 
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);

$updatetime = date('d-m-Y',strtotime(todat()));
//echo $check;
if($check=='Back to Planning Department'){
	if(!$revisionTxt){die("<h1>Revision reason not found!</h1>");}
	$revisionTxt=date("d/m/Y")." ".$revisionTxt;
	if($loginDesignation=='Chairman & Managing Director')
		$colName="mdRevisionTxt";
		if($loginDesignation=='Manager Planning & Control'){
			$colName="revisionTxt";
				$deg="PM";
			}
			if($loginDesignation=='Construction Manager'){
				$colName="revisionTxt";
				$deg="CM";
			}
	
		
	$status="Not Ready" ; $approve="";
	$sqlup=" UPDATE iowtemp SET Approved='$approve', iowStatus='$status',Checked='',$colName='{\"$deg\":\"$revisionTxt\"}' WHERE iowId=$iow ";
	$sqlupdate=mysqli_query($db, $sqlup);
}
elseif($check=='Approve'){
$status="Approved by MD" ; $approve="<b>Approved at</b> $updatetime by $loginFullName [$loginDesignation]";

$sqlup=" UPDATE iowtemp SET Approved='$approve', iowStatus='$status',revision='0' WHERE iowId=$iow ";
//echo $sqlup;
$sqlupdate=mysqli_query($db, $sqlup);

$sql="DELETE from iow where iowId=$iow";
$sqlq=mysqli_query($db, $sql);

$sql="DELETE from siow where iowId=$iow";
$sqlq=mysqli_query($db, $sql);

$sql="DELETE from dma where dmaiow=$iow";
$sqlq=mysqli_query($db, $sql);

$sql="INSERT INTO iow (select * from iowtemp where iowId=$iow)";
$sqlq=mysqli_query($db, $sql);
$t1=mysqli_affected_rows($db);

$sql="INSERT INTO siow (select * from siowtemp where iowId=$iow)";
$sqlq=mysqli_query($db, $sql);
$t2=mysqli_affected_rows($db);

$sql="INSERT INTO dma (select * from dmatemp where dmaiow=$iow)";
$sqlq=mysqli_query($db, $sql);
$t3=mysqli_affected_rows($db);

if($t1>=1 AND $t2>=1 AND $t3>=1){
	$del=0;
$sql="INSERT INTO iowback (select * from iowtemp where iowId=$iow)";
$sqlq=mysqli_query($db, $sql);
if(mysqli_affected_rows($db)>0)$del++;
$sql="INSERT INTO siowback (select * from siowtemp where iowId=$iow)";
$sqlq=mysqli_query($db, $sql);
if(mysqli_affected_rows($db)>0)$del++;
$sql="INSERT INTO dmaback (select * from dmatemp where dmaiow=$iow)";
$sqlq=mysqli_query($db, $sql);
if(mysqli_affected_rows($db)>0)$del++;

if($del!=3){echo "<H1>Error while create backup iow</H1>";}
if($t1<1 AND $t2<1 AND $t3<1){echo "<H1>Error while copy to iow approved. Please try again.</H1>"; exit();}

$sql="DELETE from iowtemp where iowId=$iow";
$sqlq=mysqli_query($db, $sql);

$sql="DELETE from siowtemp where iowId=$iow";
$sqlq=mysqli_query($db, $sql);

$sql="DELETE from dmatemp where dmaiow=$iow";
$sqlq=mysqli_query($db, $sql);
 }//if

}
	   /*for($i=1; $i<$tid; $i++)
	      {
		   $rate=${"rate".$i};
		   $id=${"id".$i};
		   $sql="UPDATE dma SET dmaRate='$rate' WHERE dmaId='$id' ";
		   //echo $sql."<br>";
		   $sqlrun=mysqli_query($db, $sql);
		  }*/


//echo $sqlup;

if($loginDesignation=='Chairman & Managing Director')
		echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=index.php?keyword=mdview+IOW&selectedPcode=$selectedPcode&status=Forward%20to%20MD\">";
	else
		echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=index.php?keyword=pmview+IOW&selectedPcode=$selectedPcode&status=Forward%20to%20MD\">";
}//save
?>

<? 
if($check)exit();
$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
include($localPath."/includes/config.inc.php"); 
$db=mysqli_connect($SESS_DBHOST, $SESS_DBUSER, $SESS_DBPASS, $SESS_DBNAME);

$sqliow="SELECT * from `iowtemp` where `iowProjectCode`='$selectedPcode'  AND `iowId` = '$iow'";
//echo $sqliow;
$sqlruniow= mysqli_query($db, $sqliow);
$resultiow=mysqli_fetch_array($sqlruniow);

//iow date
$revisedSDate=$resultiow['iowSdate'];
$revisedCDate=$resultiow['iowCdate'];

$sqlApproved="select iowSdate,iowCdate from iow where iowId=$iow";
$qApproved=mysqli_query($db,$sqlApproved);
$rowApproved=mysqli_fetch_array($qApproved);

$approvedSDate=$rowApproved['iowSdate'];
$approvedCDate=$rowApproved['iowCdate'];

if($revisedSDate!=$approvedSDate)
	$sDateChangedS="class='changedClass'";
if($revisedCDate!=$approvedCDate)
	$sDateChangedC="class='changedClass'";
?>
<table width="600"  align="center" border="1" bordercolor="#9999CC" bgcolor="#9999CC" cellpadding="0" cellspacing="0" style="border-collapse:collapse" >
 <tr > <td >
<table width="100%"  align="center"  bgcolor="#FFFFFF" border="0" cellpadding="5" cellspacing="0">
<tr>
  <td colspan="4" bgcolor="#9999CC" align="center"><b><font color="#FFFFFF"> Details of Item Of Work (IOW)</font></b> </td>
</tr>

<tr>
  <td colspan="4">Project:  <font class="out"><? echo myprojectName($selectedPcode);?></font></td>
</tr>
	<?php
	if($selectedPcode=="004"){
		$eqFreq=getEquipmentFrequencyEqCode($resultiow['iowCode']);
		if($eqFreq){
		$des=itemDes($eqFreq['eqItemCode']);
	?>
<tr>
  <td colspan="4">Equipment: <font class="out"><? echo "$eqFreq[eqItemCode]; $des[des]; $des[spc]";?></font></td>  
</tr>
<tr>
  <td colspan="4">Maintenance Frequency: <font class="out"><? echo "$eqFreq[maintenanceFrequency]</font>.measuerUnti()[$eqFreq[measureUnit]]";?> </td>  
</tr>
	<?php } }
	?>
	
<tr>
  <td colspan="4">Item of Work:<font class="out"><? echo "$resultiow[iowCode]</b> [ <i>$resultiow[iowDes]</i>]";?></font></td>  
</tr>
	
	
	
<tr>
  <td width="21%">Quantity:<font class="out"><? echo number_format($resultiow['iowQty']);?></font> <? echo $resultiow['iowUnit'];?></td>
	
	<? 
$materialCost=materialCost($resultiow['iowId'],"temp");
$equipmentCost=equipmentCost($resultiow['iowId'],"temp");
$humanCost=humanCost($resultiow['iowId'],"temp");

$directCost=$materialCost+$equipmentCost+$humanCost;
if($resultiow['iowType']!=1){
	$totalCost=$directCost;
	$resultiow['iowPrice']=$totalCost/$resultiow['iowQty'];
}?>
	
  <td width="24%">Rate:<font class="out">Tk. <? echo number_format($resultiow['iowPrice'],2); ?></font></td>
	
  <td width="42%">Quotation Price:<font class="out"><? echo number_format($resultiow['iowQty']*$resultiow['iowPrice'],2); $totalCost=$resultiow['iowQty']*$resultiow['iowPrice'];?></font></td>
</tr>
<tr>
  <td colspan="2">Date of Starting: <font class="out"><? echo date("j-m-Y", strtotime($resultiow['iowSdate']));?></font></td>
  <td colspan="2">Expected Date of Completion: <font class="out"><? echo date("j-m-Y", strtotime($resultiow['iowCdate']));?></font></td>
</tr>
<tr>
<td colspan="4"><? echo 'Rev. '.$resultiow['revisionNo'];?> <b>Raised at</b> <? echo $resultiow['Prepared'];?><br>
<? echo 'Rev. '.$resultiow['revisionNo'];?> <? echo $resultiow['Checked'];?><br>
<? echo 'Rev. '.$resultiow['revisionNo'];?> <? echo $resultiow['Approved'];?>
</td>
</tr>

</table>
</td></tr>
</table>
<br>
<?php

$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
include($localPath."/planningDep/revisionHistory.php"); 
//include("revisionHistory.php"); ?>
<br>

<?


if($resultiow['iowProjectCode']!="004"){
$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
include($localPath."/project/auxiliary_iow_report.php"); 
}
else{
	$diagonosis_info=getIowItemCode2EqMaintenanceInfo($resultiow['iowCode'],$selected="*");
	$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
include($localPath."/maintenance/eqMaintenanceReport.php");
	
}


$tt=0;
$sqlsiow = "SELECT * from `siowtemp` where `iowId` = '$iow' ORDER BY siowId ASC";
//echo $sqlsiow;
$sqlrunsiow= mysqli_query($db, $sqlsiow);
?>
<form name="dma" action="./index.php?keyword=pmview+temp+dma&selectedPcode=<? echo $selectedPcode?>&iow=<? echo $iow;?>&revisionTxt=" method="post">
<table  align="center" width="98%" border="1" bordercolor="#E4E4E4" cellpadding="0" cellspacing="0" style="border-collapse:collapse">

  <?
   $i=1;
   $approvedmaterialCost = 0;
   while($siow=mysqli_fetch_array($sqlrunsiow)){
$approvedtotalcost=0;
   ?>
<a name="go<? echo $siow['siowId'];?>"></a>
  <tr bgcolor="#EEEEEE">
    <td height="30"   align="left"><b>SIOW: </b><a href="./graphReport.php?siow=<? echo $siow['siowId'];?>"><? echo $siow['siowName'];?></a>
    <?php if($loginDesignation!='Chairman & Managing Director') {?>
	[ <a href="index.php?keyword=edit+sub+item+work&iow=<? echo $iow;?>&siow=<? echo $siow['siowId'];?>"> edit</a>]
	<!--[ <a href="./consumableProduct/deleteSIOW.php?iow=<? echo $iow;?>&siowId=<? echo $siow['siowId'];?>&project=<? echo $selectedPcode;?>"> delete</a>]-->	
    <?php }?>
    <br>
	Start: <? echo myDate($siow['siowSdate']);?>; Finish: <? echo myDate($siow['siowCdate']);?>; Duration:
	<? echo round((strtotime($siow['siowCdate'])-strtotime($siow['siowSdate']))/86400)+1;?> days
	</td>
    <td width="100" align="right">Qty: <? echo number_format($siow['siowQty']);?> <? echo $siow['siowUnit'];?>
	
	</td>
    <td><? if($resultiow['iowStatus']=='revision' || $resultiow['iowStatus']=='Hold by MD'){?>
	<a href="./consumableProduct/saveItem.php?iow=<? echo $iow;?>&siow=<? echo $siow['siowId'];?>&ana=<? echo $siow['siowQty']/$siow['analysis'];?>" target="_blank">Add Resources</a><? }?>
	</td>	
  </tr>
  <tr>
  <td colspan="6">
<?
$sqlp ="SELECT * FROM `dmatemp` WHERE  `dmasiow` LIKE '$siow[siowId]' order by dmaItemCode ASC";
// echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
$totalAmount='';
?>

<table  align="center" width="98%" border="1" bordercolor="#666666" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr bgcolor="#E0E0E0">
    <td height="10" width="100" align="center" rowspan="2"><b>Code</b></td>
    <td width="300" align="center" rowspan="2"><b>Item Description</b></td>
    <td align="center" rowspan="2"><b>Unit</b></td>
    <td align="center"><b>Approved</b></td>
    <td align="center" rowspan="2"><b>Work Progress</b><br> 
		<?php
 			echo siowActualProgress($siow['siowId'],$siow['siowPcode'],$todat,$siow['siowQty'],$siow['siowUnit'],0);
		?>
		</td>
    <td align="center"><font color="#FF0000" ><b>Revised</b></font></td>		
  </tr>

  <tr bgcolor="#E0E0E0">
    <td align="center">
	 <table border="1" width="100%" bordercolor="#AAAAAA" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
	   <tr>
	   <th width="25%">Qty </th>
	   <th width="25%">Rate </th>
	   <th width="50%">Amount </th>	   	   
	   </tr>
	 </table>
	</td>
    <td align="center">
	 <table border="1" width="100%" bordercolor="#AAAAAA" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
	   <tr>
	   <th width="25%">Qty </th>
	   <th width="25%">Rate </th>
	   <th width="50%">Amount </th>	   	   
	   </tr>
	 </table>
	</td>
  </tr>

  <? while($iowResult=mysqli_fetch_array($sqlrunp))
  {  $approvedAmount=0;
  
  $test=explode("-",$iowResult['dmaItemCode']);
    if( $test[0]>=35 AND  $test[0]<70) $bg=" bgcolor=#FFFFCC"; 
	else if( $test[0]>=70 AND  $test[0]<=99) $bg=" bgcolor=#F0FEE0";
	 else $bg=" bgcolor=#FFFFFF";
	 
   	if($test[0]>='50' AND $test[0]<='98'){	$itemCode="$test[0]-$test[1]-$test[2]";}
     else {$itemCode=$iowResult['dmaItemCode'];}

  ?>
  <tr <? echo $bg; ?>>
    <td align="center"><? echo $itemCode;?></td>
    <td align="left" width="300"><? $temp=itemDes($itemCode); echo $temp['des'].', '.$temp['spc'];?></td>
    <td align="center"><?
	 if($test[0]>='35' AND $test[0]<'99') echo "Hr";
	  else  echo $temp['unit'];?>
	  </td>

	     <td align="center">
	 <table border="1" width="100%" bordercolor="#AAAAAA" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
	   <tr>
	   <td width="25%" align="right">	<? $approvedQty=approvedQty($siow['siowId'],$itemCode); 
	   if($test[0]>='35' AND $test[0]<'99')  echo sec2hms($approvedQty,$padHours=false);
	   else  echo number_format($approvedQty); ?> </td>
	   <td width="25%" align="right">	<? $approvedRate =approvedRate($siow['siowId'],$itemCode); echo number_format($approvedRate,2); ?> </td>
	   <td width="50%" align="right"><?
		 $approvedAmount=$approvedQty*$approvedRate; echo number_format($approvedAmount,2);
		 if($test[0]>='01' AND $test[0]<'35'){$approvedmaterialCost+=$approvedAmount;}
		 elseif($test[0]>='35' AND $test[0]<'70'){$approvedequipmentCost+=$approvedAmount;}
		 elseif($test[0]>='70'){$approvedhumanCost+=$approvedAmount;}
		 $approveddirectCost+=$approvedAmount;
		 $approvedtotalcost=$approvedtotalcost+$approvedAmount;
		 ?></td>
	   
	   	   	   
	   </tr>
	 </table>
	</td>	

    <td align="right">
<?  $issuedQtyp=0;$issuedQty=0; 
		if($test[0]>='01' AND $test[0]<'50'){
	 $issuedQty=0; 
	 $issuedQtyp=0;
	 $issuedQty=issuedQty1($siow['siowId'],$itemCode,$selectedPcode); 
	 $issuedQtyp=$issuedQty;
	 }
	 else if($test[0]>='50' AND $test[0]<'69'){
	 $issuedQty=0; $issuedQty=eqTotalWorksiow($itemCode,$siow['siowId'],$todat,0)/3600;
     $issuedQtyp=sec2hms($issuedQty,$padHours=false);
	 }
	 else if($test[0]>='70' AND $test[0]<'98'){
	 $issuedQty=0; $issuedQty=empTotalWorksiow($itemCode,$siow['siowId'],$todat,0)/3600;
     $issuedQtyp=sec2hms($issuedQty,$padHours=false);
	 }
	 else if($test[0]=='99'){
	 $issuedQty=0; $issuedQty=subWork_issued($itemCode,$siow['siowId']);
     $issuedQtyp=$issuedQty;
	 }	 
 ?>
			
					<table width="100%">
			<tr>
			<td width="50%" align="right" style="border-right:1px solid #999"><?php echo round($issuedQtyp,3); ?></td>
			<td width="50%" align="right"><?php 
	
if(!$approvedQty)$approvedQty=0;
	$perPercent=$approvedQty/100;
if($issuedQty)
	echo round($issuedQty/$perPercent) . "%";
else
	echo "0%";
	
				?></td>
			</tr>
			</table>
		
		</td>
	 <td>
	 <table border="1" width="100%" bordercolor="#AAAAAA" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
		 <?php
if($approvedQty!=$iowResult['dmaQty'])
	$lineExtra=" color:#f00; font-weight:800; font-size: 12px;";
else
	$lineExtra="";
?>
	   <tr>
       <td align="right"  width="25%" style=" <?php echo $lineExtra; ?>"><? echo $iowResult['dmaQty'];?></td>		
    <td align="right" width="25%"><? 
	$rate=$iowResult['dmaRate'];
	echo number_format($rate,2);
	//echo $rate;
	?>
	<input type="hidden" name="dmaRate<? echo $i;?>" value="<? echo $rate?>">
	<!--<input type="hidden" name="dmaVid<? echo $i;?>" value="<? echo $vid?>">-->
	<input type="hidden" name="dmaId<? echo $i?>" value="<? echo $iowResult['dmaId'];?>"	>
	</td>''

    <td align="right" width="50%"><?
	 $amount=$rate*$iowResult['dmaQty']; echo number_format($amount,2);
	 if($test[0]>='01' AND $test[0]<'35'){$materialCost+=$amount;}
	 elseif($test[0]>='35' AND $test[0]<'70'){$equipmentCost+=$amount;}
	 elseif($test[0]>='70'){$humanCost+=$amount;}
	 $directCost+=$amount;	 
	 if($amount==0) {$tt=1; }
	 $totalAmount+= $amount;
	 ?></td>

	   </tr>
	 </table>
	 </td>
  </tr>
  <? 
 $i++; } ?>
  <tr bgcolor="#AAAADD"><td colspan="2" align="center" >SIOW Direct Expenses Rate Tk. 
  <? if($approvedtotalcost) echo number_format($approvedtotalcost/$siow['siowQty'],2).'/'.$siow['siowUnit']."</b>";?></td>
     <td colspan="2" align="right" ><? echo "Sub Total Amount: Tk.".number_format($approvedtotalcost,2);?></td>
	 <td colspan="2" bgcolor="#FFCC99" ></td>
 </tr>
 
  <tr bgcolor="#FFCC99"><td colspan="2" align="center" >SIOW Direct Expenses Rate Tk. 
  <? if($totalAmount)echo number_format($totalAmount/$siow['siowQty'],2).'/'.$siow['siowUnit']."</b>";?></td>
     <td colspan="4" align="right" ><? echo "Sub Total Amount: Tk.".number_format($totalAmount,2);?></td>
 </tr>

</table><br>
  <? }?>
  </td></tr> 
  <tr>
      <td colspan="7"> 
	  <table width="100%">
	 <?	
			
			if($resultiow["iowType"]==1){
$approvedtotalcost=approvedtotalcost($iow);
$materialCost=materialCost($resultiow['iowId']);
$equipmentCost=equipmentCost($resultiow['iowId']);
$humanCost=humanCost($resultiow['iowId']);
$totalCost=$resultiow['iowQty']*$resultiow['iowPrice'];
$directCost=$materialCost+$equipmentCost+$humanCost;

$pmaterialCost=($materialCost/$totalCost)*100;
$pequipmentCost=($equipmentCost/$totalCost)*100;
$phumanCost=($humanCost/$totalCost)*100;

$approvedtotalcostArr=calculateDirectCost($resultiow['iowProjectCode'],$iow,true);

			}
			elseif($resultiow["iowType"]==2){
				$approvedtotalcostArr=calculateDirectCost($resultiow['iowProjectCode'],$iow,true);
				$approvedtotalcostM=calculateDirectCost($resultiow['iowProjectCode'],$iow,true,"m");
				$approvedtotalcostE=calculateDirectCost($resultiow['iowProjectCode'],$iow,true,"e");
				$approvedtotalcostH=calculateDirectCost($resultiow['iowProjectCode'],$iow,true,"h");
			}
			
		if($approvedtotalcost>0 || $resultiow["iowType"]==2){?>
          <tr>
            <td  colspan="3">Approved Direct Expenses: Total Tk. <? echo number_format($approveddirectCost);?>
			(<font class="out"><? echo $resultiow["iowType"]==1 ? number_format(($approveddirectCost/$totalCost)*100) : $approvedtotalcostArr[1];?>%</font>)
						</td>
          </tr>
          <tr>
            <td>Material Tk. <? echo number_format($approvedmaterialCost);?>
			(<font class="out"><? 
			if($resultiow["iowType"]==1 ){
				echo number_format((($approvedmaterialCost / $totalCost) * 100));
			}
			else {
				echo $approvedtotalcostM[1];
			}
			// echo $resultiow["iowType"]==1 ? number_format(
			// 		(
			// 			(($approvedmaterialCost / $totalCost) * 100) ?? 0
			// 		)
			// 	) : $approvedtotalcostM[1];?>%</font>); 
            </td>
            <td>Equipment and Tools Tk. <? echo number_format($approvedequipmentCost);?> 
              (<font class="out"><? echo $resultiow["iowType"]==1 ? number_format($pequipmentCost) : $approvedtotalcostE[1];?>%</font>); 
            </td>
            <td>Labour Tk.<? echo number_format($approvedhumanCost);?> (<font class="out"><? echo $resultiow["iowType"]==1 ? number_format($phumanCost) :  $approvedtotalcostH[1];?>%</font>) 
            </td>
          </tr>
          <tr>
            <td colspan="3">Estimated Item of Work Direct Expense is 
							<font class="out">Tk.<? echo  number_format($approveddirectCost/$resultiow['iowQty'],2).'/'.$resultiow['iowUnit']; ?> 
              </font>
						</td>
          </tr>
          <tr>
<td colspan="3">
<?php
	echo "<span>Date of Starting: ".date("d/m/Y",strtotime($approvedSDate))."</span>;";
	echo "<span>Expected Date of Completion: ".date("d/m/Y",strtotime($approvedCDate))."</span>";
?>
</td>
          </tr>
		  <? }?>
<? 
$materialCost=materialCost($resultiow['iowId'],"temp");
$equipmentCost=equipmentCost($resultiow['iowId'],"temp");
$humanCost=humanCost($resultiow['iowId'],"temp");

if($resultiow["iowType"]==2){
				$approvedtotalcostArr=calculateDirectCost($resultiow['iowProjectCode'],$iow,true,null,"temp");
				$approvedtotalcostM=calculateDirectCost($resultiow['iowProjectCode'],$iow,true,"m","temp");
				$approvedtotalcostE=calculateDirectCost($resultiow['iowProjectCode'],$iow,true,"e","temp");
				$approvedtotalcostH=calculateDirectCost($resultiow['iowProjectCode'],$iow,true,"h","temp");

$totalAmountP=$approvedtotalcostArr[1];
$materialCostP=$approvedtotalcostM[1];
$equipmentCostP=$approvedtotalcostE[1];
$humanCostP=$approvedtotalcostH[1];
			}

$directCost=$materialCost+$equipmentCost+$humanCost;
if($resultiow['iowType']!=1){
	$totalCost=$directCost;
	$resultiow['iowPrice']=$totalCost/$resultiow['iowQty'];
}?>
          <tr>
            <td height="30"></td>
          </tr>
          <tr bgcolor="#FFCC99">
            <td colspan="3"><b>Revised Estimated Direct Expenses</b>: Total Tk. <? echo number_format($directCost); if($resultiow['iowType']==1){?>(<font class="outr"><? echo number_format(($directCost/$totalCost)*100);?>%</font>)<?php }else {?>(<font class="outr"><? echo $totalAmountP;?>%</font>)<?php } ?></td>
          </tr>
          <tr bgcolor="#FFCC99">
            <td>Material Tk. <? echo number_format($materialCost);?>(<font class="outr"><? echo !$materialCostP ? number_format(($materialCost/$totalCost)*100) : $materialCostP;?>%</font>); 
            </td>
            <td>Equipment and Tools Tk. <? echo number_format($equipmentCost);?> 
              (<font class="outr"><? echo !$equipmentCostP ? number_format(($equipmentCost/$totalCost)*100) : $equipmentCostP;?>%</font>); 
            </td>
            <td>Labour Tk.<? echo number_format($humanCost);?> (<font class="outr"><? echo !$humanCostP ? number_format(($humanCost/$totalCost)*100) : $humanCostP;?>%</font>) 
            </td>
          </tr>
          <tr bgcolor="#FFCC99">
            <td colspan="3">Estimated Item of Work Direct Expense is <font class="outr">Tk.<? echo number_format($directCost/$resultiow['iowQty'],2).'/'.$resultiow['iowUnit']; ?> 
              </font></td>
          </tr>
          <tr bgcolor="#FFCC99">
						<td>
<?php
	echo "<span>Date of Starting: <span $sDateChangedS>".date("d/m/Y",strtotime($revisedSDate))."</span></span>; ";
	echo "<span >Expected Date of Completion: <span $sDateChangedC>".date("d/m/Y",strtotime($revisedCDate))."</span></span>";
?>
						</td>
          </tr>
        </table></td>
    </tr>

  <?
  
  if( $resultiow['iowStatus']=='Raised by CM' AND ($loginDesignation=='Construction Manager' && 1==2)){?>
  <tr><td align="center" colspan="7"> 
     <? 
	 $localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
	 include($localPath."/planningDep/actionCM.php");?>
  </td></tr>
	<? } if( ($resultiow['iowStatus']=='Forward to PM' || $resultiow['iowStatus']=='Raised by CM') AND ($loginDesignation=='Manager Planning & Control' || $loginDesignation=='Construction Manager') ){?>
  <tr><td align="center" colspan="7"> 
     <?
	 $localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
	include($localPath."/planningDep/action.php");?>
  </td></tr>
<? }?>
  <? if($resultiow['iowStatus']=='Forward to MD' AND $loginDesignation=='Chairman & Managing Director'){?>
  <tr>
 <td align="center"><input type="submit" name="check" value="Approve"  style="width:200; color:006633; font-size:16px; font-weight:bold"></td>
	<?php }
		if($loginDesignation=='Chairman & Managing Director' || $loginDesignation=='Manager Planning & Control' || $loginDesignation=='Construction Manager'){
	?>		
 <td align="center" ><br><input type="submit" name="check" value="Back to Planning Department"  style="width:300; color:FF0000; font-size:16px; font-weight:bold" id="revisionBTN"></td>
</tr>
			<script>
			$(document).ready(function(){
				var revisionBTN=$("input#revisionBTN");
				var fullScreenBlack=$("div.fullScreenBlack");
				var dialog=$("div#dialog");
				var closeBTN=$("button#closeBTN");
				var revSubmitBTN=$("input#revSubmitBTN");
				var revisionTxt=$("textarea#revisionTxt");
				var errorMsg=$("div.errorMsg");
				var form=$("form[name='dma']");
				var Revision2=$("#Revision2");
				revisionBTN.click(function(){
					fullScreenBlack.fadeIn();
					return false;
				});
				closeBTN.click(function(){
					fullScreenBlack.hide();
				});
				
				revSubmitBTN.click(function(){
					var revisionData=revisionTxt.val();
					if(revisionData.length>15){
						errorMsg.html("");
						Revision2.val("1");
						form.attr("action",form.attr("action")+revisionData+"&check=Back to Planning Department");
						form.submit();
					}else{
						var msg="Revision reason should be minimum 15 character."
						errorMsg.html(msg);
					}
				});
			});
			</script>
			<div class="fullScreenBlack" style="background:rgba(0,0,0,.8); width:100%; height:100%; left:0;top:0;position:fixed; overflow:hidden; display:none">
				<div style="display: block;    width: 320px;    height: 240px;    background: white;
    margin: auto;    margin-top: 20vh;    padding: 3px;    border-radius: 4px;">
					<div id="dialog" title="Reason of back revision">
						<div class="ui-dialog-titlebar ui-corner-all ui-widget-header ui-helper-clearfix ui-draggable-handle"><span id="ui-id-1" class="ui-dialog-title">Reason of back revision</span><button type="button" class="ui-button ui-corner-all ui-widget ui-button-icon-only ui-dialog-titlebar-close" title="Close" style="    float: right;" id="closeBTN"><span class="ui-button-icon ui-icon ui-icon-closethick"></span><span class="ui-button-icon-space"> </span>Close</button></div>
						<div class="">
						<div class="errorMsg" style=" color: #f00;    font-size: 12px;    font-weight: 800;">
							
						</div>
							<textarea name="revisionTxt" id="revisionTxt" style="margin: 0px; width: 98%; height: 117px; 1px solid rgb(176, 174, 174)"></textarea>
							<input type="button" value="submit" id="revSubmitBTN">
						</div>
						
					</div>
				</div>
			</div>	
  <? }?>
  
  <br><br>
  </td></tr> 
  </table>
  <input type="hidden" name="n" value="<? echo $i;?>">
 </form>
<style>
span.changedClass {
    color: #f00;
    font-weight: 800;
}
</style>

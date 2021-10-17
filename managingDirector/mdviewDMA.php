<?
error_reporting(E_ERROR | E_PARSE);
if($check){

include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$updatetime = date('d-m-Y',strtotime(todat()));
//echo $check;
if($check=='Back to Planning Department'){
$status="Raised by PM" ; $approve="" ; 
$sqlup=" UPDATE iowtemp SET Approved='$approve', iowStatus='$status',Checked='' WHERE iowId=$iow ";
$sqlupdate=mysqli_query($db, $sqlup);
}
else{
$status="Approved by MD" ; $approve="<b>Approved by Managing Director at</b> $updatetime by $loginFullName [$loginDesignation]" ;

$sqlup=" UPDATE iowtemp SET Approved='$approve', iowStatus='$status' WHERE iowId=$iow ";
$sqlupdate=mysqli_query($db, $sqlup);

$sql="INSERT INTO iow (select * from iowtemp where iowId=$iow)";
$sqlq=mysqli_query($db, $sql);

$sql="INSERT INTO siow (select * from siowtemp where iowId=$iow)";
$sqlq=mysqli_query($db, $sql);

$sql="INSERT INTO dma (select * from dmatemp where dmaiow=$iow)";
$sqlq=mysqli_query($db, $sql);

/*$sql="DELETE from iowtemp where iowId=$iow";
$sqlq=mysqli_query($db, $sql);

$sql="DELETE from siowtemp where iowId=$iow";
$sqlq=mysqli_query($db, $sql);

$sql="DELETE from dmatemp where dmaiow=$iow";
$sqlq=mysqli_query($db, $sql);
*/

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


echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=index.php?keyword=mdview+IOW&status=Forward%20to%20MD\">";
}//save

include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

if($iowStatus=='Approved by MD')
 $sqliow = "SELECT * from `iow` where `iowProjectCode` = '$selectedPcode'  AND `iowId` = '$iow'";
else 
 $sqliow = "SELECT * from `iowtemp` where `iowProjectCode` = '$selectedPcode'  AND `iowId` = '$iow'";
//echo $sqliow;
$sqlruniow= mysqli_query($db, $sqliow);
$resultiow=mysqli_fetch_array($sqlruniow);
//print_r($resultiow);
?>
<table width="600"  align="center" border="1" bordercolor="#9999CC" bgcolor="#9999CC" cellpadding="0" cellspacing="0" style="border-collapse:collapse" >
 <tr > <td >
<table width="100%"  align="center"  bgcolor="#FFFFFF" border="0" cellpadding="5" cellspacing="0">
<tr>
  <td colspan="4" bgcolor="#9999CC" align="center" class="englishhead">Details of 
  <i><u><? if($resultiow['iowType']=='2') echo "Non Invoiceable"; else echo "Invoiceable";?></u></i> Item Of Work (IOW) </td>
</tr>

<tr>
  <td colspan="4">Project: <font class="out"> <? echo $selectedPcode;?></font></td>
</tr>
<tr>
  <td colspan="4">Iow Type: <font class="out"> <? 
 $pos= $resultiow[position];
 $explode= (explode(".",$pos));
 $positionNumber = $explode[1];
  if($positionNumber==001){
    echo "Breakdown";
  }
  elseif($positionNumber==002){
    echo "Overhauling";
  }
  elseif($positionNumber==003){
    echo "Preventive";
  }
  elseif($positionNumber==004){
    echo "Troubled Running";
  }
  ?></font></td>
</tr>

<tr>
  <td colspan="4">Item of Work:<font class="out"> <? echo "$resultiow[iowCode]</b> [ <i>$resultiow[iowDes]</i>]";?></font></td>
</tr>
<tr>
  <td width="21%">
	<?php
	if(is_iow_qty_changed($resultiow['iowId'])){
		echo "<b><font color='#f00'>New</font></b> ";
	}
	?>Quantity:<font class="out"><? echo $resultiow['iowQty'];?></font> <? echo $resultiow['iowUnit'];?></td>
  <td width="21%">Rate:<font class="out"><? echo number_format($resultiow['iowPrice'],2);?></font></td>
  <td width="42%">IOW Total:<font class="out"><? echo  number_format($resultiow['iowQty']*$resultiow['iowPrice'],2);?></font> Taka</td>
</tr>
<? 
$materialCost=materialCost($resultiow['iowId']);
$equipmentCost=equipmentCost($resultiow['iowId']);
$humanCost=humanCost($resultiow['iowId']);
$totalCost=$resultiow['iowQty']*$resultiow['iowPrice'];
$directCost=$materialCost+$equipmentCost+$humanCost;

$pmaterialCost=($materialCost/$totalCost)*100;
$pequipmentCost=($equipmentCost/$totalCost)*100;
$phumanCost=($humanCost/$totalCost)*100;

?>
<tr><td colspan="4" bgcolor="#DDDDFF">Estimated Direct Expenses: Total Tk. <? echo number_format($directCost);?>(<font class="out"><? echo number_format(($directCost/$totalCost)*100);?>%</font>)
</td></tr>
<tr><td colspan="4" bgcolor="#DDDDFF" ><p style="margin-left:10px">- Material Tk. <? echo number_format($materialCost);?>(<font class="out"><? echo number_format($pmaterialCost);?>%</font>); Equipment Tk. <? echo number_format($equipmentCost);?> (<font class="out"><? echo number_format($pequipmentCost);?>%</font>); Labour Tk.<? echo number_format($humanCost);?> (<font class="out"><? echo number_format($phumanCost);?>%</font>)</td></tr>
<tr><td colspan="4" bgcolor="#FFFFCC">Unit Direct Expense <font class="out">Tk. <? echo number_format($directCost/$resultiow['iowQty'],2).'/'.$resultiow['iowUnit'];?></font>
</td></tr>

<tr>
  <td colspan="2">Date of Starting: <font class="out"><? echo date('j-m-Y',strtotime($resultiow['iowSdate']));?></font></td>
  <td colspan="2">Date of Completion: <font class="out"><? echo date('j-m-Y',strtotime($resultiow['iowCdate']));?></font></td>
</tr>
<tr>
<td colspan="4"><b>Raised at</b> <? echo $resultiow['Prepared'];?><br>
<? echo $resultiow['Checked'];?><br>
<? echo $resultiow['Approved'];?>
</td>
</tr>

</table>
</td></tr>
</table>
<br>
<?php include("./planningDep/revisionHistory.php"); ?>
<br>
<?php


if($resultiow['iowProjectCode']!="004")
	include("./project/auxiliary_iow_report.php");
else{
	$diagonosis_info=getIowItemCode2EqMaintenanceInfo($resultiow['iowCode'],$selected="*");
	include("./maintenance/eqMaintenanceReport.php");
}
?>

<a href="./graph/viewGraph.php?iowId=<? echo $resultiow['iowId'];?>" target="_blank" title="Click For View Graphical Presentation">[ GRAPH ]</a>
<?
if($iowStatus=='Approved by MD')
 $sqlsiow = "SELECT * from `siow` where `iowId` = '$iow' ";
else 
$sqlsiow = "SELECT * from `siowtemp` where `iowId` = '$iow' ";
//echo $sqlsiow;
$sqlrunsiow= mysqli_query($db, $sqlsiow);
?>
<form name="check" action="./index.php?keyword=mdview+dma&selectedPcode=<? echo $selectedPcode;?>&iow=<? echo $iow;?>" method="post">
<table  align="center" width="98%" border="1" bordercolor="#E4E4E4" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <? while($siow=mysqli_fetch_array($sqlrunsiow)){?>
  <tr bgcolor="#EEEEEE">
    <td height="30"  width="300" align="left"><b>SIOW: </b><a href="./graphReport.php?siow=<? echo $siow['siowId'];?>"><? echo $siow['siowName'];?></a><br>
		Start: <? echo myDate($siow['siowSdate']);?>; Finish: <? echo myDate($siow['siowCdate']);?>; Duration: <? echo siowDuration($siow['siowId']);?> days
	</td>
    <td width="200" align="left">Total Qty: <? echo number_format($siow['siowQty']);?> <? echo $siow['siowUnit'];?></td>
  </tr>
  <tr>
  <td colspan="6">
<?
if($iowStatus=='Approved by MD')
$sqlp ="SELECT * FROM `dma` WHERE `dmasiow` = '$siow[siowId]' order by dmaItemCode ASC";
else
$sqlp ="SELECT * FROM `dmatemp` WHERE `dmasiow` = '$siow[siowId]' order by dmaItemCode ASC";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
?>

<table  align="center" width="98%" border="1" bordercolor="#CCCCCC" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr bgcolor="#DDDDDD">
    <td height="10" width="100" align="center"><b>Item Code</b></td>
    <td width="300" align="center"><b>Item Description</b></td>
    <td align="center"><b>Unit</b></td>
    <td align="center"><b>Qty</b></td>
    <td align="center"><b>Rate</b></td>
    <td align="center"><b>Amount</b></td>
  </tr>

  <? $i=1;$totalAmount=0;
   while($iowResult=mysqli_fetch_array($sqlrunp))
  {
    $temp=itemDes($iowResult['dmaItemCode']);
  
  $ii=explode("-",$iowResult['dmaItemCode']);
    //if($ii[0]>=35 AND $ii[0]<70) {$bg=" bgcolor=#FFFFBB"; $unit='Hr.';}
	if($ii[0]>=35 AND $ii[0]<99) {$bg=" bgcolor=#F0FEE4";$unit='Hr.';}
	 else {$bg=" bgcolor=#FFFFFF";$unit=$temp['unit'];}

  ?>
  <tr <? echo $bg;?>>
    <td align="center"><? echo $iowResult['dmaItemCode'];?></td>
    <td align="left" width="300"><? 
	echo "$temp[des], $temp[spc]";?></td>
    <td align="center"><? echo $unit;?></td>
    <td align="right"><? echo number_format($iowResult['dmaQty'],3);?></td>
    <td align="right"><? echo number_format($iowResult['dmaRate'],2);?></td>
    <td align="right"><? $amount=$iowResult['dmaRate']*$iowResult['dmaQty']; echo number_format($amount,2);?></td>
  </tr>
  <? $totalAmount+= $amount; $i++; } ?>
  <tr><td colspan="3" align="center" bgcolor="#AAAADD"><? echo "SIOW Unit Rate: Tk.".number_format($totalAmount/$siow['siowQty'],2).$siow['siowUnit'];?></td>
     <td colspan="4" align="right" bgcolor="#AAAADD"><? echo "Sub Total Amount: Tk.".number_format($totalAmount,2);?></td>
 </tr>
<!--   <tr><td  colspan="6">
   <img src="./graphReport.php?siow=<? echo $siow['siowId'];?>">
  </td></tr>
-->
</table><br>

  <? } ?>
<input type="hidden" name="tid" value="<? echo $i;?>">
					   
  </td></tr>
  <? if( $resultiow['iowStatus']=='Forward to MD'){?>
  <tr>
  <td align="center" ><input type="submit" name="check" value="Approve"  style="width:200; color:006633; font-size:16px; font-weight:bold" ></td>
  <td align="center" ><input type="submit" name="check" value="Back to Planning Department"  style="width:300; color:FF0000; font-size:16px; font-weight:bold" ></td>
</tr>
  <? }?>

  </table>
</form>
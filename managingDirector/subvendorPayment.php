<table width="100%" border="1"  bordercolor="#CCCCFF" cellpadding="0" cellspacing="0" style=" border-collapse:collapse">
<? if(poAdvance($re[posl])){?>
	<tr>
	  <td width="100">Payment <? echo $sl++;?>: </td>
      <td width="300">
		  <table width="100%" height="100%" cellspacing="5">
			<tr>
			 <td >Advance Payable</td>
			 <td  align="right"><?  $poAdvance=poAdvance($re[posl]);
			  echo '(<font class=out>'.number_format($poAdvance,2).'</font>)';?></td>
			</tr>
			<!--
			<tr>
			 <td>Panelty</td>
			 <td></td>
			</tr>
			-->
			 <tr><td height="2" bgcolor="#0099FF" colspan="2"></td></tr>	
			 <tr>
                <td height="21">Payable at 
                  <?    echo myDate($re[activeDate]);?>
                </td>
                <td align="right"><? $payableAmount=$poAdvance;
				 echo '(<font class=out>'.number_format($payableAmount,2).'</font>)';?></td>
				 </tr>
				
		  </table>
	</td>
	
      <td width="300">
		  <table width="100%" height="100%" cellspacing="5">
			<!--
			<tr>
			 <td width="100">Advance Paid</td>
			 <td  align="right"><?  $poAdvance=poAdvance($re[posl]); echo number_format($poAdvance,2);?></td>
			</tr>
			-->
			<!--
			<tr>
			 <td>Panelty</td>
			 <td></td>
			</tr>
            -->
				<tr>
				  <td>Advance Paid</td>
				  <td align="right"><? 
	  if($popaymentPaid){
	  $popaymentPaid0=$popaymentPaid-$poAdvance;
	 // echo "** $popaymentPaid-$amountGt**";
	  if($popaymentPaid0>=0) $popaymentPaid0=$poAdvance;
		  else $popaymentPaid0=$popaymentPaid;
		  echo '(<font class=out>'.number_format($popaymentPaid0,2).'</font>)';		  
	  $popaymentPaid=$popaymentPaid-$poAdvance;		 
	  }
	  else echo "00,00";
	  ?></td>
				</tr>
			
			 <tr><td height="2" bgcolor="#0099FF" colspan="2"></td></tr>	
			 <? if($payableAmount==$popaymentPaid0){?>	
			<tr bgcolor="#FFFFCC"><th colspan="2"> Payment Completed</th></tr>
			<? } else {?>
			 <tr><td>Matured on <?    echo myDate($re[activeDate]);?></td>
			 <td align="right"><? //$payableAmount=$poAdvance;
			 $payableAmount=$payableAmount-$popaymentPaid0;
			  echo '(<font class=out>'.number_format($payableAmount,2).'</font>)';?>
			 </td></tr>
			<? }?>
		  </table>
	</td>

	</tr>

<? }//advance?>	
<? include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 
$sqlp = "SELECT * from  `porder` WHERE posl='$re[posl]'";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

$totalAmount=0;
$i;
$poids="'0'";
$i=1;
$poidl=array();
 while($typel1= mysqli_fetch_array($sqlrunp))
{ $poids = $poids.",'".$typel1[poid]."'";
$itemp[$i]=$typel1[itemCode];
$itempRate[$i]=$typel1[rate];
$poidl[$i]=$typel1[poid];
$i++;
}



?>	
<? 
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 
$sqlp1 = "SELECT distinct sdate from  `poschedule` WHERE posl ='$re[posl]' AND invoice=1 ORDER by sdate ASC; ";
//echo $sqlp1;
$sqlrunp1= mysqli_query($db, $sqlp1);
$j=1;
$dd=array();
$dd[0]=$typel1[dstart];

 while($typel2= mysqli_fetch_array($sqlrunp1))
{
$dd[$j]=$typel2[sdate];
$j++;
} //
?>
<? for($i=1;$i<sizeof($dd);$i++){
$amountGtp=0;
?>
<tr>
 <td width="100"> Payment <? echo $sl++; $amount=0;?>:  </td>
 <td width="300">
  <table width="100%" height="100%" cellspacing="2">

    <tr>
	  <td>Item Receivable</td>
	  <td align="right">
   <? 
 for($k=1;$k<=sizeof($poidl);$k++){
 if(scheduleReceiveperInvoice($poidl[$k],$dd[$i])){
 $amount=scheduleReceiveperInvoice($poidl[$k],$dd[$i])*$itempRate[$k];
 $amountGt+=$amount;
 }
 
 }
 echo number_format($amountGt,2);
 
${amountGt.$i}=$amountGt;
 ?>
 </td>
 </tr>
 <?  ${poAdvanceCut.$i} = poAdvanceCut($j,$poAdvance); 
		 if(${poAdvanceCut.$i}>0) 
		 {
		 ?>
    <tr>
	 <td >Advance Adjustment</td>
	 <td  align="right"><? echo '(<font class=out>'.number_format(${poAdvanceCut.$i},2).'</font>)'; ?>
	 </td>
	</tr>
	<? }?>
	<!--
    <tr>
	 <td>Security Amount</td>
	 <td></td>
	</tr>

    <tr>
	 <td>Panelty Amount</td>
	 <td></td>
	</tr>
	    -->
<? ${retentionAmount.$i}=retentionAmount($amountGt,$re[posl]);
if(${retentionAmount.$i}){
?>	
    <tr>
	 <td>Retention Amount</td>
	 <td align="right"><?  if(${retentionAmount.$i}>0) 
	 echo '(<font class=out>'.number_format(${retentionAmount.$i},2).'</font>)';
	 else echo '00.00';?>
	 </td>
	</tr> 
<? }?>	
<? ${foodingAmount.$i}=foodingAmount($amountGt,$re[posl]);
if(${foodingAmount.$i}){
?>	
    <tr>
	 <td>Fooding Payable</td>
	 <td align="right"><?  	 echo  '(<font class=out>'.number_format(${foodingAmount.$i},2).'</font>)'; ?>
	 </td>
	</tr> 
<? }?>	

 <tr><td height="2" bgcolor="#0099FF" colspan="2"></td></tr>	
 <tr><td>Payable at <?    echo myDate($dd[$i]);?></td><td align="right">
 <? $payableAmount=$amountGt-${poAdvanceCut.$i}-${retentionAmount.$i}; 
 $payableAmountTotal+=$payableAmount;
// echo "**$payableAmount-${foodingAmount.$i}**";
 echo '(<font class=out>'.number_format(($payableAmount-${foodingAmount.$i}),2).'</font>)';?></td></tr>
   </table>

</td>
<? $amount=0;
$amountGt=0;
${popaymentPaid.$i}=0;?>
 <td width="300">
  <table width="100%" height="100%" cellspacing="2">

    <tr>
	  <td>Item Received</td>
	            <td align="right"> 
                  <? 
 for($k=1;$k<=sizeof($poidl);$k++){
 if(scheduleReceiveperInvoice($poidl[$k],$dd[$i])){
 $amount=scheduleReceiveperInvoice($poidl[$k],$dd[$i])*$itempRate[$k];
 $amountGt+=$amount;
 } 
 }
 //echo number_format($amountGt,2).'***'.number_format($actualReceivePO,2).'--';
if($actualReceivePO>0){
  ${amountRec.$i}=$actualReceivePO-$amountGt;
  if(${amountRec.$i}>0)
  ${amountRec.$i}=$amountGt;
  else ${amountRec.$i}=$actualReceivePO;
  echo number_format(${amountRec.$i},2);
  $actualReceivePO=$actualReceivePO-$amountGt;
  }
  else echo '00.00';
 ?>
                </td>
 </tr>
 <?  ${poAdvanceCut.$i} = poAdvanceCut($j,$poAdvance);
	  if(${poAdvanceCut.$i}>0)
	  {
	  
	  ?>
    <tr>
	 <td >Advance Adjusted</td>
	 <td  align="right"><? 
	 if(${poAdvanceCut.$i}==$popaymentPaid0)
	  echo '(<font class=out>'.number_format(${poAdvanceCut.$i},2).'</font>)';
	  else echo '(<font class=out>'.number_format($popaymentPaid0,2).'</font>)';
	   ?>
	  
	  </td>
	</tr>
	<? }?>
	<!--
    <tr>
	 <td>Security Received</td>
	 <td></td>
	</tr>
   
    <tr>
	 <td>Panelty Adjusted</td>
	 <td></td>
	</tr>
 -->
<? ${retentionAmount.$i}=retentionAmount($amountGt,$re[posl]);
if(${retentionAmount.$i}){
?>	
    <tr>
	 <td>Retention Adjusted</td>
	 <td align="right"><?  if(${retentionAmount.$i}>0) 
	 echo '(<font class=out>'.number_format(${retentionAmount.$i},2).'</font>)'; 
	 else echo '00.00';?></td>
	</tr> 
<? }?>

<? //${retentionAmount.$i}=retentionAmount($amountGt,$re[posl]);
$fooding_paid=fooding_paid($re[posl],$project);
if($fooding_paid){
$popaymentPaid=$popaymentPaid-$fooding_paid;
?>	
    <tr>
	 <td>Fooding Adv. Paid</td>
	 <td align="right"><? echo '(<font class=out>'.number_format($fooding_paid,2).'</font>)'; ?></td>
	</tr> 
<? }?>
	
<?
$payableAmount=$amountGt-${poAdvanceCut.$i}-${retentionAmount.$i};
 $mdata=PO_submaturityDate($re[posl], $payableAmountTotal,$p);
//echo "<br>mdata=$mdata<br>";
if($i>=1){
$m=$i-1;
$amountGtp=0;
$amountGtp=${amountGt.$m};
if($mdata=='') $mdata1=todat();
else $mdata1=$mdata;
//echo ">>".todat();
$overPayment=overPayment($mdata1,$re[posl]);
if($overPayment)$overPayment=$overPayment-$amountGtp;
if($overPayment<0)$overPayment=0;
$popaymentPaid=$popaymentPaid-$overPayment;
}
else $overPayment=overPayment($mdata,$re[posl]);
//echo "<br>$i===overPayment=$overPayment-$amountGtp<br>";
if($popaymentPaid0 OR $fooding_paid){
//echo "$overPayment-$popaymentPaid0-$fooding_paid<br>";
$overPayment=$overPayment-$popaymentPaid0-$fooding_paid;
$popaymentPaid0=0;
}

if($overPayment>0){
if($popaymentPaid0){$overPayment=$overPayment-$popaymentPaid0;
if($overPayment<0)$overPayment=0;
$popaymentPaid0=0;
}


?>
	<tr bgcolor="#FF0000" class="outw">
	  <td>Paid before Maturity</td>
	  <td align="right"><? 
		 echo number_format($overPayment,2);
		//$popaymentPaid=$popaymentPaid-$amountGt;		 		  	  
	  ?></td>
	</tr>
<? }?>	

	  <? 
	  if($popaymentPaid>0){
	  ${popaymentPaid.$i}=$popaymentPaid-$amountGt;
	 // echo "** $popaymentPaid-$amountGt**";
	  if(${popaymentPaid.$i}>=0) ${popaymentPaid.$i}=$amountGt;
		  else ${popaymentPaid.$i}=$popaymentPaid;
	if((${popaymentPaid.$i}-$overPayment)>0){
	  ?>
 	<tr>
	  <td>Paid after Maturity</td>
       <td align="right">
		  <? 
		 // echo "**${popaymentPaid.$i}-$overPayment**";
		   echo '(<font class=out>'.number_format(${popaymentPaid.$i}-$overPayment,2).'</font>)';
			$popaymentPaid=$popaymentPaid-$amountGt;?>
	   </td>
	</tr>
	<? }
	 }?>
 <tr><td height="2" bgcolor="#0099FF" colspan="2"></td></tr>
<?  if($mdata=PO_submaturityDate($re[posl], $payableAmountTotal,$p)){
$payableAmount=$amountGt-${poAdvanceCut.$i}-${retentionAmount.$i};
 if($payableAmount==${popaymentPaid.$i}){?>
 <tr bgcolor="#FFFFCC"><th colspan="2"> Payment Completed</th></tr>
 <? }
 else if(${amountRec.$i}>=$payableAmount){
?>
 <tr><td>Matured on <? 
  if(strtotime($dd[$i])>strtotime($mdata)){
 $mdata=$dd[$i];
 }

    echo myDate($mdata);?></td>
	<td align="right"><?  
	$payableAmount_temp=$payableAmount-${popaymentPaid.$i};
	 echo '(<font class=out>'.number_format($payableAmount_temp,2).'</font>)';?>
	 </td>
	 </tr>
	
<? }
 $overPayment=0;}//else
?>	

   </table>

</td>

</tr>
 <? $amount=0;
$amountGt=0; }?>

</table>
<table width="100%" border="1" bordercolor="#99CC66" cellpadding="" cellspacing="0" style=" border-collapse:collapse">
<? 
echo "popaymentPaid=".number_format($popaymentPaid,2);
if(poAdvance($re[posl])){ 
?>
	<tr>
	  <td width="100">Payment <? echo $sl++;?>: </td>
      <td width="300">
		  <table width="100%" height="100%" cellspacing="0" cellpadding="0">
			<tr>
			 <td >Advance Payable</td>
			 <td  align="right"><?  $poAdvance=poAdvance($re[posl]); echo number_format($poAdvance,2);?></td>
			</tr>
			 <tr><td height="2" bgcolor="#0099FF" colspan="2"></td></tr>	
			 <tr>
                <td height="21">Payable at <? echo myDate($re[activeDate]);?>
                </td>
                <td align="right"><? $payableAmount=$poAdvance; echo number_format($payableAmount,2);?></td></tr>
				
		  </table>
	</td>
	
      <td width="300">
		  <table width="100%" height="100%" cellspacing="0" cellpadding="0">
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
			 <tr><td>Matured on <?    echo myDate($re[activeDate]);?></td><td align="right"><? $payableAmount=$poAdvance; echo number_format($payableAmount,2);?>
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
$itempQty[$i]=$typel1[qty];
$poidl[$i]=$typel1[poid];
$planRecDate[$i]=$typel1[dstart];

$sqlp1 = "SELECT sdate from  `poschedule` WHERE posl='$re[posl]'";
//echo $sqlp1;
$sqlrunp1= mysqli_query($db, $sqlp1);
$sqlf=mysqli_fetch_array($sqlrunp1);
$planDisDate[$i]=$sqlf[sdate];

$i++;
}
putenv ('TZ=Asia/Dacca'); 
$emonth= date('m',strtotime($planDisDate[1]));
$smonth= date('m',strtotime($planRecDate[1]));

$month=($emonth-$smonth)+1;
$sdate=$planRecDate[1];
//echo "##$sdate#";
$edate=$planDisDate[1];
$rate=$itempRate[1]/8;
$qty=$itempQty[1];
$itemCode=$itemp[1];
?>	
<? for($e=1;$e<=$month;$e++){

$tdate="2006-$smonth-01";
if($e==$month){
$inDate=$edate;
$inDate_print=date('d-m-Y',strtotime($edate));
$k=3;
}
else {
$k=2;
//echo "$edate";
$inDate=date('Y-m-t',strtotime($tdate));
$inDate_print=date('t-m-Y',strtotime($tdate));
}
if($e==1)$k=1;
$eqPlanReceiveAmount=eqPlanReceiveAmount($sdate,$inDate,$rate,$qty);
${eqActualReceiveAmount.$e}=eqActualReceiveAmount($sdate,$inDate,$rate,$re[posl],$itemCode,$project);
?>
<tr>
 <td width="100">Payment <? echo $e;?> </td>
  <td width="300">
  <table width="100%" height="100%" cellspacing="1" cellpadding="1">
    <tr>
	  <td>Item Receivable</td>
      <td align="right"><? echo number_format($eqPlanReceiveAmount,2);?></td>
   </tr>
  <tr><td height="2" bgcolor="#0099FF" colspan="2"></td></tr>   
   <tr>
      <td>Payable at <? echo $inDate_print;?> </td>
	  <td align="right"><? echo number_format($eqPlanReceiveAmount,2);?></td>	   
  </tr>
   </table>
 </td>
  <td width="300">
  <table width="100%" height="100%" cellspacing="0" cellpadding="0">
    <tr>
	  <td>Item Received </td>
       <td align="right">
	   <?
	    echo number_format(${eqActualReceiveAmount.$e},2);	   
	   ${pamentRemain.$e}=${eqActualReceiveAmount.$e};
	   ?>
	   </td>
   </tr>
<? 
$paidAfter=0;
$remainAmount=${eqActualReceiveAmount.$e};

$receiveAmount=$receiveAmount+${eqActualReceiveAmount.$e};
if($e>1)$ee=$e-1;
else {$ee=1;${t.$ee}=1;}
//echo "##${t.$ee}##";

if(${t.$ee}==1 ){?>
<? ${PaidBeforeMaturity.$e}=PaidBeforeMaturity($sdate,$inDate,$re[posl],${paidAfterMaturity.$ee},$k); ?>
<? if(${PaidBeforeMaturity.$e}>$receiveAmount){

  if(${PaidBeforeMaturity.$e}>${eqActualReceiveAmount.$e}){$paidbefore=${eqActualReceiveAmount.$e}; $remainAmount=0;}
   else {$paidbefore=${PaidBeforeMaturity.$e}; $remainAmount=${eqActualReceiveAmount.$e}-$paidbefore;}
?>	
	<tr bgcolor="#FF0000" class="outw">
	  <td>Paid before Maturity</td>
	  <td align="right"><? echo number_format($paidbefore,2);?></td></tr>
	  <? }?>
<? 

 ${PaidAfterMaturity.$e}=PaidAfterMaturity($sdate,$inDate,$re[posl],${paidAfterMaturity.$ee},$k);
 
 if(${PaidAfterMaturity.$e}>=$receiveAmount){
  // echo "**${PaidAfterMaturity.$e}>$receiveAmount **";
  if(${PaidAfterMaturity.$e}>$remainAmount) $paidAfter=$remainAmount;
   else  $paidAfter=$paidAfter;
 }//${PaidAfterMaturity.$e}
 else {
 // echo "****$popaymentPaid-$preceiveAmount**";
 $paidAfter=$popaymentPaid-$preceiveAmount;}
 ?>
	
	<? if($paidAfter>0){?>
 	<tr>
	  <td>Paid after Maturity</td>
       <td align="right"> <? echo number_format($paidAfter,2); ?></td>
	</tr>
     <? } //${paidAfterMaturity.$e}?>
<? }//ee?>
  <tr><td height="2" bgcolor="#0099FF" colspan="2"></td></tr>   
<? 
${pamentRemain.$e}=${eqActualReceiveAmount.$e}-($paidbefore+$paidAfter);
if(${pamentRemain.$e}>0){ ${t.$e}=0;?>
   <tr>
       <td>Matured on <? echo $inDate_print;?></td>
	  <td align="right"> <? echo number_format(${pamentRemain.$e},2); ?> 
	  </td>	   
  </tr>
  <? } else { ${t.$e}=1;?>
  <tr bgcolor="#FFFFCC"><th colspan="2"> Payment Completed</th></tr>
  <? 
  $preceiveAmount=$receiveAmount;}?>
   </table>
 </td>
</tr>
<? $smonth++;
putenv ('TZ=Asia/Dacca'); 

$sdate=date('Y-m-d',strtotime($inDate)+86400);
}// month for?>
</table>
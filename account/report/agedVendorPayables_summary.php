<? if($search=1){
if($vid=='') $vid='%';
if($pcode=='') $pcode='%';



$sql="SELECT DISTINCT posl,location,vid,poType,activeDate,cc from porder 
WHERE location LIKE '$pcode' 
AND vid LIKE '$vid' AND posl NOT Like 'EP_%' ";


if($Status=="Short by vendor")$sql="SELECT DISTINCT porder.posl,porder.location,porder.vid,porder.poType,porder.activeDate,porder.cc from porder left join vendor on porder.vid=vendor.vid  WHERE porder.location LIKE '$pcode' 
AND porder.vid LIKE '$vid' AND porder.posl NOT Like 'EP_%' ";

//if($Status=="Short by item")$sql.=" ORDER by porder.vid asc";
	if($_SESSION["loginDesignation"]=="Accounts Executive")$sql.=" and porder.cc!='2' ";

//debuging mode
	$debuging=0;
	if($debuging){
		$sql.=" and posl like 'EQ_207_00407_1048%'  ";
	}
//debuging mode end
	

	
	
if($Status=="Short by vendor")$sql.=" ORDER by field(porder.vid, '99','85') asc ,vendor.vname ASC";

else $sql.="  ORDER by field(porder.vid, '99','85'), posl ASC"; //if($Status=="Short by date")
// echo $sql.'<br>';
$sqlq=mysqli_query($db, $sql); // find all vendor and posl form porder table
$ii=1;
while($mr=mysqli_fetch_array($sqlq)){
if(isFullpaid($mr[posl])) continue; //if po amount full paid.

 $potype=poType($mr[posl]);  //get po type
$data=array();

$tt=1;
 $location=$mr[location]; 
 $vid=$mr[vid]; 
 $posl=$mr[posl]; 
 $poType=$mr[poType]; 

// echo "<br>===================$posl=======================<br>"; 
 
$dat=poInvoiceDate($posl); // get all invoice date into $dat array
// 	print_r($dat);
$fromDate='0000-00-00';
$this_item_is_not_complete=null;
for($i=1,$k=0;$i<=sizeof($dat);$i++,$k++){ // all invoice date in loop
// 	echo $i."------<br><br>";

	
	
if($poType=='2'){
$pdate=$dat[$i];
	
// 	echo poPayableAmount($posl,$pdate,$pototalAmount,$paidAmount,$exfor,$poType);
// 	echo "<br>";

$diff=(strtotime($todat)-strtotime($pdate))/86400;

 $data[$i][0]=$pdate;
 $data[$i][1]=eqpoActualReceiveAmount_date($posl,$fromDate,$dat[$i]);
//  echo "=======". $data[$i][1]."========"; 
 

 if($diff>=91) $st6+=$data[$i][1]; 
 elseif($diff>=61) $st5+=$data[$i][1];
  elseif($diff>=31) $st4+=$data[$i][1];
    elseif($diff>=16) $st3+=$data[$i][1];
	  elseif($diff>=8) $st2+=$data[$i][1];
	    else $st1+=$data[$i][1];
 $fromDate=$pdate;
}else{
 $invtemp=scheduleReceiveperInvoice($posl,$dat[$i]);
 $pdate='0000-00-00';
 for($j=1;$j<=sizeof($invtemp);$j++){ // check all receive service
 $itemPOArray[$j-1][]="";
 if($invtemp[$j][1]==0) continue;
//  echo $invtemp[$j][0];
//  echo '='.$invtemp[$j][1];
 if($poType=='1')$rdate=mat_receive($invtemp[$j][0],$invtemp[$j][1],$posl,$location);
 if($poType=='3')$rdate=sub_Receive_Po($invtemp[$j][0],$invtemp[$j][1],$posl,$location);

//  print_r($rdate);
// echo "<br>$posl == ".mat_receive($invtemp[$j][0],$invtemp[$j][1],$posl,$location)."<br>";
// echo "========poType=$poType // sub_Receive_Po===".$rdate."===========<br><br>";

 if($rdate=='0000-00-00'){
 	$this_item_is_not_complete[]=$invtemp[$j][0]; //item code
 	//$invtemp[$j][1]; //po quantity
	//echo "==error receiving===".$posl." // ".$pdate."=====";
 	break;
 }
// echo '='.$rdate; 
 if($rdate>$pdate)$pdate=$rdate; //return the final date of receive service.
//echo '='.$pdate; 
//echo "<br><br>";
 }//for j

 if(count($this_item_is_not_complete)>0){
     $item_receiving_completation=0; //flag say item not receiving completed.
 }
 else{
      $item_receiving_completation=1;
 }
 
// 	echo "<br>posl=$posl   rdate=$rdate item_receiving_completation=$item_receiving_completation && $pdate<br>";

if($pdate!='0000-00-00'){ //if receive some things then paid.
// 	print_r($dat);
// 	echo "<br>$pdate && $item_receiving_completation --> $posl <br>";
  $diff=(strtotime($todat)-strtotime($pdate))/86400;
	$receiveAmount=subWorkTotalReceive_Po($posl);
	$haveReceiveAmount=scheduleReceiveperInvoiceAmount($posl,$dat[$i]);
	$allInvoiceAmount[$pdate]=$haveReceiveAmount;
}
	
 $itemPOArray[$j-1][]=$item_receiving_completation;
 $itemPOArray[$j-1][]=$haveReceiveAmount;
 $itemPOArray[$j-1][]=$pdate;
	
if($item_receiving_completation==1){
 $data[$i][0]=$pdate;
 $data[$i][1]=$haveReceiveAmount; 
// echo "=====scheduleReceiveperInvoiceAmount===<<".$data[$i][1]."====".$data[$i][0]."====>>";

 if($diff>=91) $st6+=$data[$i][1];
 elseif($diff>=61) $st5+=$data[$i][1];
  elseif($diff>=31) $st4+=$data[$i][1];
    elseif($diff>=16) $st3+=$data[$i][1];
	  elseif($diff>=8) $st2+=$data[$i][1];
	    else $st1+=$data[$i][1]; 
}
}//else
	
	

//  echo "=====================$diff=====================<br><br>";
//   echo $data[$i][0].' = '.$data[$i][1];
// echo "<br>==========================================<br>";
}//for i
//print_r($data);
	
//   echo "<br>poPaidAmount=$poPaidAmount; posl=$posl<br>";
 if($poPaidAmount>0){
 if($st6>0){
	if( $poPaidAmount>=$st6) {$poPaidAmount-=$st6;$st6=0;}
	 else{$st6-=$poPaidAmount;$poPaidAmount=0;}
 }//if($st6>0)
  if($st5>0 AND $poPaidAmount>0){
	if( $poPaidAmount>=$st5) {$poPaidAmount-=$st5;$st5=0;}
	 else  {$st5-=$poPaidAmount;$poPaidAmount=0;}
 }//if($st5>0)
  if($st4>0 AND $poPaidAmount>0){
	if( $poPaidAmount>=$st4) {$poPaidAmount-=$st4;$st4=0;}
	 else  {$st4-=$poPaidAmount;$poPaidAmount=0;}
 }//if($st4>0)
  if($st3>0 AND $poPaidAmount>0){
	if( $poPaidAmount>=$st3) {$poPaidAmount-=$st3;$st3=0;}
	 else  {$st3-=$poPaidAmount;$poPaidAmount=0;}
 }//if($st3>0)
  if($st2>0 AND $poPaidAmount>0){
	if( $poPaidAmount>=$st2) {$poPaidAmount-=$st2;$st2=0;}
	 else  {$st2-=$poPaidAmount;$poPaidAmount=0;}
 }//if($st2>0)
  if($st1>0 AND $poPaidAmount>0){
	if( $poPaidAmount>=$st1) {$poPaidAmount-=$st1;$st1=0;}
	 else  {$st1-=$poPaidAmount;$poPaidAmount=0;}
 }//if($st1>0)
}

?>




   
 <br>PO Amount: <? echo  number_format(poTotalAmount($mr[posl]),2).' dated '.mydate($mr[activeDate]); ?>
<div class="invoiceList">
<?php
	
$sqlp1="SELECT s.itemCode,sum(s.qty) qty,p.rate rate, sum(s.qty)*sum(p.rate) total,s.sdate, s.invoice,p.advanceType FROM poschedule s, porder p  where p.posl='$posl' and s.posl=p.posl and p.itemCode=s.itemCode group by s.sdate  ORDER by s.sdate,s.itemCode DESC";
// 	echo "$sqlp1";
$sqlrunp1= mysqli_query($db, $sqlp1);
$fromDate="0000-00-00";
$totalInvoiceAmount=0;
$itemCodeAmount=0;
$blankRowData="<p>&nbsp;</p>";
$st1=$st2=$st3=$st4=$st5=$st6=$poPaidAmount=$totalPoPaidAmount=null;
$totalPoPaidAmount=$poPaidAmount=poPaidAmount($posl);

//advance info
	$poAdvanceArr=getPOadvanceinfo($posl);
	$advancePayableAmount=$poAdvanceArr["amount"]-$totalPoPaidAmount;
	
	if($advancePayableAmount>0 && $poAdvanceArr["parcent"]>0){
		$InvoiceDiff=(strtotime($todat)-strtotime($mr[activeDate]))/86400;
		$visualDate=mydate($mr[activeDate]);
		$poAdvanceParcent=$poAdvanceArr[parcent];
		
		echo "<p>Advance <font color='#00f'>$poAdvanceParcent%</font>: Raised on <span>$visualDate</span></p>";
		
		$advancePayableAmount=number_format($advancePayableAmount,2);
		$RowData=$advancePayableAmount>0 ? "<p><font color='#00f'>$advancePayableAmount</font></p>" : "<p>&nbsp;</p>";
		
if($InvoiceDiff>=91) {$st6.=$RowData;	$st5.=$blankRowData;$st4.=$blankRowData;$st3.=$blankRowData;$st2.=$blankRowData;$st1.=$blankRowData;}
 elseif($InvoiceDiff>=61) {$st5.=$RowData;
$st6.=$blankRowData;$st4.=$blankRowData;$st3.=$blankRowData;$st2.=$blankRowData;$st1.=$blankRowData;}
  elseif($InvoiceDiff>=31) {$st4.=$RowData;
$st6.=$blankRowData;$st5.=$blankRowData;$st3.=$blankRowData;$st2.=$blankRowData;$st1.=$blankRowData;}
    elseif($InvoiceDiff>=16) {$st3.=$RowData;
$st6.=$blankRowData;$st5.=$blankRowData;$st4.=$blankRowData;$st2.=$blankRowData;$st1.=$blankRowData;}
	  elseif($InvoiceDiff>=8) {$st2.=$RowData;
$st6.=$blankRowData;$st5.=$blankRowData;$st4.=$blankRowData;$st3.=$blankRowData;$st1.=$blankRowData;}
	    else {$st1.=$RowData;
$st6.=$blankRowData;$st5.=$blankRowData;$st4.=$blankRowData;$st3.=$blankRowData;$st2.=$blankRowData;}
	}
	//advance info end
	
// if($advancePayableAmount>0 && $poAdvanceArr["parcent"]>0) //only advance payment
while($typel2=mysqli_fetch_array($sqlrunp1)){
	$i=0;
	$edate=$typel2[sdate];
	$indate=$mr[activeDate]; 
	$itemCode=$typel2[itemCode]; 
	
	
  $InvoiceDiff=(strtotime($todat)-strtotime($edate))/86400;
	if($poType==1 || $poType==3){
$InvoiceDiff-=creditFacilityDays($posl);
		$i++;
		$visualDate=date("d-m-Y",strtotime($edate));

		$invoiceActualAmount=round(floatval($itemPOArray[$i][1]),2);
		unset($itemPOArray);

		$poIsClosedQty=poIsClosedQty($posl,$itemCode);
		if($poIsClosedQty>0 && $poType==1)
			echo $itemCodeAmount+=po_mat_receiveExt($itemCode,$posl,$location);
		
 if($poPaidAmount>0){
	 if($invoiceActualAmount>0){
		if( $poPaidAmount>=$invoiceActualAmount) {$poPaidAmount-=$invoiceActualAmount;$invoiceActualAmount=0;}
		 else{$invoiceActualAmount-=$poPaidAmount;$poPaidAmount=0;}
	 }
	}
	$invoiceActualAmount-=$poAdvanceParcent>0 ? pOAdvanceAdjustment($invoiceActualAmount,$poAdvanceParcent,$poAdvanceArr["amount"],$typel2[advanceType]) : 0; //advance adjustment

		$totalInvoiceAmount+=$invoiceActualAmount; //total amount collection

		echo "<p>Invoice $i: Raised on <span>$visualDate</span>";
		
	vendorpayable_approved_function($posl,$indate,$mr,$location);
		
		$formatedInvoiceActualAmount=number_format($invoiceActualAmount,2);
		$RowData=$invoiceActualAmount>0 ? "<p><font color='#00f'>$formatedInvoiceActualAmount</font></p>" : "<p>&nbsp;</p>";


if($InvoiceDiff>=91) {$st6.=$RowData;	$st5.=$blankRowData;$st4.=$blankRowData;$st3.=$blankRowData;$st2.=$blankRowData;$st1.=$blankRowData; $ct91+=$invoiceActualAmount;}
 elseif($InvoiceDiff>=61) {$st5.=$RowData;
$st6.=$blankRowData;$st4.=$blankRowData;$st3.=$blankRowData;$st2.=$blankRowData;$st1.=$blankRowData; $ct60+=$invoiceActualAmount;}
  elseif($InvoiceDiff>=31) {$st4.=$RowData;
$st6.=$blankRowData;$st5.=$blankRowData;$st3.=$blankRowData;$st2.=$blankRowData;$st1.=$blankRowData; $ct30+=$invoiceActualAmount;}
    elseif($InvoiceDiff>=16) {$st3.=$RowData;
$st6.=$blankRowData;$st5.=$blankRowData;$st4.=$blankRowData;$st2.=$blankRowData;$st1.=$blankRowData; $ct15+=$invoiceActualAmount;}
	  elseif($InvoiceDiff>=8) {$st2.=$RowData;
$st6.=$blankRowData;$st5.=$blankRowData;$st4.=$blankRowData;$st3.=$blankRowData;$st1.=$blankRowData; $ct7+=$invoiceActualAmount;}
	    else {$st1.=$RowData;
$st6.=$blankRowData;$st5.=$blankRowData;$st4.=$blankRowData;$st3.=$blankRowData;$st2.=$blankRowData; $ct+=$invoiceActualAmount;}
			
		
	}elseif($poType==2){
		$poIsClosedQty=poIsClosedQty($posl,$itemCode);
		if($poIsClosedQty>0)
			$itemCodeAmount+=eqpoActualReceiveAmountItemCode($posl,$itemCode);
		
		while($indate<$edate){
			$i++;
			$indateTemp=strtotime($indate);
			$indate=date("Y-m-d",mktime(0, 0, 0, date("m",$indateTemp)+1, '01',  date("Y",$indateTemp)));
			$visualDate=date("d-m-Y",strtotime($indate));
			if(strtotime($todat)<strtotime($indate))continue; //if end date exceed the current date
			$invoiceActualAmount=round(eqpoActualReceiveAmount_date($posl,$fromDate,$indate),2);
			echo "<p>Invoice $i: Raised on <span>$visualDate</span>"; 
// 			echo $invoiceActualAmount>0 ? "<font style='float:right'>Tk. <font color='#00f'>$invoiceActualAmount</font></font></p>" : "</p>";			

 if($poPaidAmount>0){
	 if($invoiceActualAmount>0){
		if( $poPaidAmount>=$invoiceActualAmount){$poPaidAmount-=$invoiceActualAmount;$invoiceActualAmount=0;}
		 else{$invoiceActualAmount-=$poPaidAmount;$poPaidAmount=0;}
	 }
}
			
			$invoiceActualAmount-=$poAdvanceParcent>0 ? pOAdvanceAdjustment($invoiceActualAmount,$poAdvanceParcent,$poAdvanceArr["amount"],$typel2[advanceType]) : 0; //advance adjustment

			$totalInvoiceAmount+=$invoiceActualAmount; //total amount collection

			vendorpayable_approved_function($posl,$indate,$mr,$location);

$InvoiceDiff=(strtotime($todat)-strtotime($indate))/86400;
$InvoiceDiff-=creditFacilityDays($posl);


$ct+=$invoiceActualAmount;
			

			$fromDate=$indate;
		}//while
	} //equipment if
	$actualPoAmount=actualPOreceiveAmount($posl,$poType,$location);
	$closingAmount=$actualPoAmount-$totalPoPaidAmount-$poAdvanceArr["amount"];
	$FinalAmount=$closingAmount;
}
?>

<?

$sqlp = "SELECT * from `popayments` WHERE (posl LIKE '". $mr[posl]."') AND (paidAmount < totalAmount) order by popID ASC ";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
//echo mysql_error();
while($re_s=mysqli_fetch_array($sqlrunp)){
if($pcode AND $vid){
$potype=poType($re_s[posl]);
$t=explode('_',$re_s[posl]);
if($potype==1) $receiveAmount=poTotalreceive($re_s[posl],$t[1]);
if($potype==2) $receiveAmount=eqpoActualReceiveAmount($re_s[posl]);
if($potype==3) $receiveAmount=subWorkTotalReceive_Po($re_s[posl]);
$paid=poPaidAmount($re_s[posl]);
	
		$currentPayable=foodinfAmount($re_s[totalAmount],$receiveAmount,$paid,$re_s[posl]); 
		$currentPayable=round($currentPayable,2);
} 
  
$payableSummery+=$currentPayable;
}?> 

	
	<?php
		
// 	Total Amount Information
	

	
	if($poIsClosedQty>0 && ($itemCodeAmount>0 || $poType==3)){
		
		if($poType==3){
			$itemCodeAmount+=subWorkTotalReceive_Po($posl);
		}
		
		$isClosingVerified=isClosingVerified($posl);
		if($isClosingVerified || 1==1){
			vendorpayable_approved_function($posl,"",$mr,$location,"c");
		}		
		$forcedClosedAmount=$FinalAmount;
	}
	else{
		$FinalAmountRow=$blankRowData;
	} ?>
	
<?
	$st1=$st2=$st3=$st4=$st5=$st6=0;$poPaidAmount=0;
$ii++;
 }//while?>
	

<?php	echo $ct+$ct7+$ct15+$ct30+$ct60+$ct91+$payableSummery;?>


<? }//if?>
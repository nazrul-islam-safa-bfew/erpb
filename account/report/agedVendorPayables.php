<!-- <h1>
	Under construction!
</h1> -->
<form name="searchBy" action="./index.php?keyword=aged+vendor+payables" method="post">

<table width="600" align="center" class="ablue">
<tr><td colspan="3" align="right" class="ablueAlertHd">Aged vendor payables</td></tr>
<?
	if($Status=='Short by date')$r1='checked';
	else if($Status=='Short by vendor')$r2='checked';
?>
	<tr>
		 <td colspan="3">
			 Shrot by date<input type="radio"  name="Status" checked="checked" <? echo $r1;?>  value="Short by date"/> 
			 Short by  
			 Vendor
			 <input type="radio"  name="Status" <? echo $r2;?> value="Short by vendor"/>
		 </td>
	 </tr>
 <tr>
   <th width="200">Select Vendor</th>
<td>
	<select name="vid">
 		<option value="">All Vendor</option>
<?
		$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
		include($localPath."/includes/config.inc.php"); //datbase_connection
		$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

		$sqlp = "SELECT distinct vendor.vid,vendor.vname,porder.vid from `vendor`,porder WHERE vendor.vid=porder.vid ORDER by vendor.vname ASC";
		//echo $sqlp;
		$sqlrunp= mysqli_query($db, $sqlp);

		 while($typel= mysqli_fetch_array($sqlrunp))
		 {
		 echo "<option value='".$typel['vid']."'";
		 if($vid==$typel['vid']) echo " SELECTED ";
		 echo ">$typel[vname]</option>";
		 }
?>
	</select>
</td>
<td rowspan="2"><input type="submit" name="search" value="Search" style="height:50px;width:100"></td>
 </tr>
  <tr>
   <th width="200">Select Project</th>
 <td>

<select name="pcode">
<?php if(!$loginProject){?>
 <option value="">All Project</option>
<?
}
$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
include($localPath."/includes/config.inc.php"); //datbase_connection
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT `pcode`,pname from `project` ORDER by pcode ASC";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

if($loginProject=='000')// && $_SESSION["loginDesignation"]=="Accounts Executive")
 while($typel= mysqli_fetch_array($sqlrunp)){
	 echo "<option value='".$typel['pcode']."'";
	 if($pcode==$typel['pcode'])  echo " SELECTED ";
	 echo ">$typel[pcode]--$typel[pname]</option>  ";
}
else{
	while($typel= mysqli_fetch_array($sqlrunp)){
			if($loginProject==$typel['pcode']){
				echo "<option value='".$loginProject."'";
				if($pcode==$loginProject)  echo " SELECTED";
					echo ">$typel[pcode]--$typel[pname]</option>";
			}
		}
 }
?>
</select>
</td>
</tr>
</table>
</form>
<? if($search){
if($_SESSION["TWP"])
clear_aged_vendor_payment_aux($pcode);
if($vid=='') $vid='%';
if($pcode=='') $pcode='%';
?>
<table class="ablue" width="90%" border="1"  cellpadding="0" cellspacing="0"> 
<tr class="ablueAlertHd">
 <td height="30" >Vendor</td>
 <td><7 days </td>
 <td>8-15 days</td> 
 <td>16-30 days</td>
 <td>31-60 days</td> 
 <td>61-90 days</td>
 <td>>91 days</td> 
 <td>Progress Payable
 <br>from Site</td> 
</tr>
	 <style>
		 .pdf_class{padding-left: 5px; padding-right: 5px;   background: #fff;text-decoration: none; border: none; transition:background .5s; margin-left:5px;}
		 .pdf_class:hover{background:#c1c1c1; border:none;}
		 
		 .invoiceList p{margin: 0; padding-left: 10px;}
		 .invoiceList p:nth-child(odd){background:#e5e5e5;}
		 .invoiceList p {
				height: 16px;
				margin-bottom: 2px;
			}
		 .invoiceList p span{color:#00f;}
		 
		 td.invoiceList{vertical-align:bottom;}
		 a.pdf_class img {
				width: 16px;
			}
		 .verifyClass{
background: #077900;color: #fff !important;display: inline-block;padding: 1px;border-radius: 5px; font-size: 12px; margin-top:2px;
			}
		 .verifyBTN{
			 margin-left:5px;
			 color:#f00;
		 }
		 .closedClass{
    background: #00f !important;
    color: #fff;
    display: inline-block;
    padding: 1px;
    border-radius: 5px;
    font-size: 12px;
    font-weight: 800;
    margin-right: 10px !important;
		 }
	 </style>
<? 

$todat=todat();
$sdate[1][0]=$todat;
$sdate[1][1]=date("Y-m-d",(strtotime($todat)-(8*24*3600)));
$sdate[2][0]=date("Y-m-d",(strtotime($todat)-(9*24*3600)));
$sdate[2][1]=date("Y-m-d",(strtotime($todat)-(16*24*3600)));
$sdate[3][0]=date("Y-m-d",(strtotime($todat)-(17*24*3600)));
$sdate[3][1]=date("Y-m-d",(strtotime($todat)-(30*24*3600)));
$sdate[4][0]=date("Y-m-d",(strtotime($todat)-(31*24*3600)));
$sdate[4][1]=date("Y-m-d",(strtotime($todat)-(60*24*3600)));
$sdate[5][0]=date("Y-m-d",(strtotime($todat)-(61*24*3600)));
$sdate[5][1]=date("Y-m-d",(strtotime($todat)-(90*24*3600)));
$sdate[6][0]=date("Y-m-d",(strtotime($todat)-(91*24*3600)));
$sdate[6][1]='0000-00-00';

//===============make a diffreente in sdate variable.=============
//print_r($sdate);
//AND posl like 'PO_142_00302_208'

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
		$sql.=" and posl like 'EQ_207_00509_1048%' ";
	}
//debuging mode end
	
if($Status=="Short by vendor")$sql.=" ORDER by field(porder.vid, '99','85') asc ,vendor.vname ASC";

else $sql.="  ORDER by field(porder.vid, '99','85'), posl ASC"; //if($Status=="Short by date")
// echo $sql.'<br>';
$sqlq=mysqli_query($db, $sql); // find all vendor and posl form porder table
$ii=1;
while($mr=mysqli_fetch_array($sqlq)){
if(isFullpaid($mr['posl'])) continue; //if po amount full paid.
// 	echo $mr[posl];
$potype=poType($mr['posl']);  //get po type
$data=array();

 $tt=1;
 $location=$mr['location']; 
 $vid=$mr['vid']; 
 $posl=$mr['posl']; 
 $poType=$mr['poType']; 

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

	

 

 if($diff>=91) $st6+=$data[$i][1]; 
 elseif($diff>=61) $st5+=$data[$i][1];
  elseif($diff>=31) $st4+=$data[$i][1];
    elseif($diff>=16) $st3+=$data[$i][1];
	  elseif($diff>=8) $st2+=$data[$i][1];
	    else $st1+=$data[$i][1];
 $fromDate=$pdate;
}else{
 $invtemp=scheduleReceiveperInvoice($posl,$dat[$i]);
//   echo "<br><br>=====".$posl."=====invoice temp:==";
//    print_r($invtemp);
//   echo "==========<br><br>";

 $pdate='0000-00-00';
 for($j=1;$j<=sizeof($invtemp);$j++){ // check all receive service
 $itemPOArray[$j-1][]="";
 if($invtemp[$j][1]==0) continue;
//  echo $invtemp[$j][0];
//  echo '='.$invtemp[$j][1];
 if($poType=='1')$rdate=mat_receive($invtemp[$j][0],$invtemp[$j][1],$posl,$location);
 if($poType=='3')$rdate=sub_Receive_Po($invtemp[$j][0],$invtemp[$j][1],$posl,$location);

// print_r($rdate);
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
 }else{
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

// 	echo "$item_receiving_completation;
//  $haveReceiveAmount;
//  $pdate; $posl<br>";
// 	if($kkk++>0)
// 		exit;

if($item_receiving_completation==1){
 $data[$i][0]=$pdate;
 $data[$i][1]=$haveReceiveAmount; 
//echo "=====scheduleReceiveperInvoiceAmount===<<".$data[$i][1]."====".$data[$i][0]."====>>";

 if($diff>=91) $st6+=$data[$i][1];
 elseif($diff>=61) $st5+=$data[$i][1];
  elseif($diff>=31) $st4+=$data[$i][1];
    elseif($diff>=16) $st3+=$data[$i][1];
	  elseif($diff>=8) $st2+=$data[$i][1];
	    else $st1+=$data[$i][1]; 
}
}//else

// echo "=====================$diff=====================<br><br>";
// echo $data[$i][0].' = '.$data[$i][1];
// echo "<br>==========================================<br>";
}//for i
// print_r($data);
	
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
<tr><td colspan="8" height="10" bgcolor="#FFFFE8"></td></tr>
<tr><td colspan="8" height="2" bgcolor="#0099FF"></td></tr>
<tr>
 <td> 

<?

 echo $ii.")";?> [<a target="_blank" href="./planningDep/printpurchaseOrder1.php?posl=<? echo $mr['posl'];?>"><? echo viewPosl($mr['posl']);?></a>]
 <?php
	$vtemp=vendorName($vid);
  echo $vtemp['vname']; ?>
 [<a target="_blank" href="./print/print_poLedger.php?posl=<? echo $mr['posl'];?>&project=<? echo $location;?>&potype=<? echo $poType;?>&vname=<? echo $vtemp['vname'];?>">Detail</a>]
<?php
//if(is_vendor_payable_approved($posl) && ($_SESSION["loginDesignation"]=="Accounts Executive" || $_SESSION["loginDesignation"]=="Chairman & Managing Director")){
// 	echo "<a href='".vendor_payable_approval_pdf($posl)."' target='_blank' class='pdf_class'><img src='./images/pdf.png'></a>";
// 	echo "<div style='background: #077900;color: #fff;display: inline-block;padding: 3px;border-radius: 5px;float: right;font-size: 12px; margin-top:2px;'>Verified</div>";
//}
?>

   
 <br>PO Amount: <? echo  number_format(poTotalAmount($mr['posl']),2).' dated '.mydate($mr['activeDate']); ?>
<div class="invoiceList">
<?php

$sqlp1="SELECT s.itemCode,sum(s.qty) qty,p.rate rate, sum(s.qty)*sum(p.rate) total,s.sdate, s.invoice,p.advanceType FROM poschedule s, porder p where p.posl='$posl' and s.posl=p.posl and p.itemCode=s.itemCode group by s.sdate ORDER by s.sdate,s.itemCode DESC";
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
		$InvoiceDiff=(strtotime($todat)-strtotime($mr['activeDate']))/86400;
		$visualDate=mydate($mr['activeDate']);
		$poAdvanceParcent=$poAdvanceArr['parcent'];
		
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
	$edate=$typel2['sdate'];
	$indate=$mr['activeDate']; 
	$itemCode=$typel2['itemCode'];

  $InvoiceDiff=(strtotime($todat)-strtotime($edate))/86400;
	if($poType==1 || $poType==3){
	$InvoiceDiff-=creditFacilityDays($posl);
		$i++;
		$visualDate=date("d-m-Y",strtotime($edate));
		$invoiceLegalDate=$edate;
//		print_r($itemPOArray);
		$invoiceAmount=0;
		foreach(array($itemPOArray) as $itemPOa){
			//$invoiceAmount+=$itemPOa[1];
			$invoiceAmount=$itemPOa[1];
		}
		$invoiceActualAmount=round(floatval($invoiceAmount),2);
		
		unset($itemPOArray);

		$poIsClosedQty=poIsClosedQty($posl,$itemCode);
		if($poIsClosedQty>0 && $poType==1)
			echo $itemCodeAmount+=po_mat_receiveExt($itemCode,$posl,$location);

  if($poPaidAmount>0){
	 if($invoiceActualAmount>0){
		if( $poPaidAmount>=$invoiceActualAmount){$poPaidAmount-=$invoiceActualAmount;$invoiceActualAmount=0;}
		 else{$invoiceActualAmount-=$poPaidAmount;$poPaidAmount=0;}
	 }
	}
		
	$invoiceActualAmount-=$poAdvanceParcent>0 ? pOAdvanceAdjustment($invoiceActualAmount,$poAdvanceParcent,$poAdvanceArr["amount"],$typel2['advanceType']) : 0; //advance adjustment

		$totalInvoiceAmount+=$invoiceActualAmount; //total amount collection

echo "<p>Invoice $i: Raised on <span>$visualDate</span>";

vendorpayable_approved_function($posl,$indate,$mr,$location);
		$formatedInvoiceActualAmount=number_format($invoiceActualAmount,2);
		$RowData=$invoiceActualAmount>0 ? "<p><font color='#00f'>$formatedInvoiceActualAmount</font></p>" : "<p>&nbsp;</p>";
		
		
if($InvoiceDiff>=91){$st6.=$RowData;	$st5.=$blankRowData;$st4.=$blankRowData;$st3.=$blankRowData;$st2.=$blankRowData;$st1.=$blankRowData; $ct91+=$invoiceActualAmount;}
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

if($_SESSION["TWP"])
insert_aged_vendor_payment_aux($posl,$invoiceActualAmount,$invoiceLegalDate);

}elseif($poType==2){
		$poIsClosedQty=poIsClosedQty($posl,$itemCode);
		if($poIsClosedQty>0)
			$itemCodeAmount+=eqpoActualReceiveAmountItemCode($posl,$itemCode);
			$poTotallyClosedQty=poIsClosedQty($posl,null); //po totally closed
		while($indate<$edate){
			$i++;
			$indateTemp=strtotime($indate);
			$indate=date("Y-m-d",mktime(0, 0, 0, date("m",$indateTemp)+1, '01',  date("Y",$indateTemp)));
			$previousDate=date("Y-m-t",mktime(0, 0, 0, date("m",$indateTemp), '01',  date("Y",$indateTemp)));
			$visualDate=date("d-m-Y",strtotime($indate));
			if(strtotime($todat)<strtotime($indate))continue; //if end date exceed the current date
			$invoiceActualAmount=round(eqpoActualReceiveAmount_date($posl,$fromDate,$indate),2);
			
// 			$month=date("Y-m",strtotime($indate));
// 			$amount=eq_monthlyWorkBreak("%","%",$month,$location,$posl);
// 			$invoiceActualAmount-=$amount;
			
			echo "<p>Invoice $i: Raised upto <span>$previousDate</span>"; 
// 		echo $invoiceActualAmount>0 ? "<font style='float:right'>Tk. <font color='#00f'>$invoiceActualAmount</font></font></p>" : "</p>";			
// echo "<br>$poPaidAmount</p>";
echo "<script>console.log($poPaidAmount);</script>";
 if($poPaidAmount>0){
	 if($invoiceActualAmount>0){
		if( $poPaidAmount>=$invoiceActualAmount){$poPaidAmount-=$invoiceActualAmount;$invoiceActualAmount=0;}
		 else{$invoiceActualAmount-=$poPaidAmount;$poPaidAmount=0;}
	 }
}

$invoiceActualAmount-=$poAdvanceParcent>0 ? pOAdvanceAdjustment($invoiceActualAmount,$poAdvanceParcent,$poAdvanceArr["amount"],$typel2['advanceType']) : 0; //advance adjustment
				
	$month=date("Y-m",strtotime($previousDate));
	$rate=eqpoRate($itemCode,$posl);	
			
	
	$Mbreak=eq_monthlyWorkBreak("%","%",$month,$location,$posl);
	$invoiceActualAmount-=$Mbreak;
			
			
			
// echo "<font color='#f00'>$amount</font>";
	$totalInvoiceAmount+=$invoiceActualAmount; //total amount collection

	vendorpayable_approved_function($posl,$indate,$mr,$location);
if($_SESSION["TWP"])
insert_aged_vendor_payment_aux($posl,$invoiceActualAmount,$indate);



			$formatedInvoiceActualAmount=number_format($invoiceActualAmount,2);
			$RowData=$invoiceActualAmount>0 ? "<p><font color='#00f'>$formatedInvoiceActualAmount</font></p>" : "<p>&nbsp;</p>";


$InvoiceDiff=(strtotime($todat)-strtotime($indate))/86400;
$InvoiceDiff-=creditFacilityDays($posl);

if($InvoiceDiff>=91) {$st6.=$RowData;	$st5.=$blankRowData;$st4.=$blankRowData;$st3.=$blankRowData;$st2.=$blankRowData;$st1.=$blankRowData; if(!$poTotallyClosedQty)$ct91+=$invoiceActualAmount;}
 elseif($InvoiceDiff>=61) {$st5.=$RowData;
$st6.=$blankRowData;$st4.=$blankRowData;$st3.=$blankRowData;$st2.=$blankRowData;$st1.=$blankRowData; if(!$poTotallyClosedQty)$ct60+=$invoiceActualAmount;}
  elseif($InvoiceDiff>=31) {$st4.=$RowData;
$st6.=$blankRowData;$st5.=$blankRowData;$st3.=$blankRowData;$st2.=$blankRowData;$st1.=$blankRowData; if(!$poTotallyClosedQty)$ct30+=$invoiceActualAmount;}
    elseif($InvoiceDiff>=16) {$st3.=$RowData;
$st6.=$blankRowData;$st5.=$blankRowData;$st4.=$blankRowData;$st2.=$blankRowData;$st1.=$blankRowData; if(!$poTotallyClosedQty)$ct15+=$invoiceActualAmount;}
	  elseif($InvoiceDiff>=8) {$st2.=$RowData;
$st6.=$blankRowData;$st5.=$blankRowData;$st4.=$blankRowData;$st3.=$blankRowData;$st1.=$blankRowData; if(!$poTotallyClosedQty)$ct7+=$invoiceActualAmount;}
	    else {$st1.=$RowData;
$st6.=$blankRowData;$st5.=$blankRowData;$st4.=$blankRowData;$st3.=$blankRowData;$st2.=$blankRowData; if(!$poTotallyClosedQty)$ct+=$invoiceActualAmount;}

			$fromDate=$indate;
		}//while
	} //equipment if
	$actualPoAmount=actualPOreceiveAmount($posl,$poType,$location);
	$closingAmount=$actualPoAmount-$totalPoPaidAmount-$poAdvanceArr["amount"];
	$FinalAmount=($closingAmount) > 0 ? $closingAmount : "<font color='#f00'>($closingAmount)</font>";	
	$ctClosingAmount+=$closingAmount;
	
// 	echo "$posl po receive=$actualPoAmount c/l $closingAmount f/l $FinalAmount<br>";
}
?>
</div>
	</td>
 <td align="right" class="invoiceList"><? if($st1)echo $st1;?></td>
 <td align="right" class="invoiceList"><? if($st2)echo $st2;?></td>
 <td align="right" class="invoiceList"><? if($st3)echo $st3;?></td>
 <td align="right" class="invoiceList"><? if($st4)echo $st4;?></td>
 <td align="right" class="invoiceList"><? if($st5)echo $st5;?></td>
 <td align="right" class="invoiceList"><? if($st6)echo $st6;?></td>
 <td align="right" bgcolor="#FFCC99"> 
<?

$sqlp = "SELECT * from `popayments` WHERE (posl LIKE '". $mr['posl']."') AND (paidAmount < totalAmount) order by popID ASC ";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
//echo mysql_error();
while($re_s=mysqli_fetch_array($sqlrunp)){
if($pcode AND $vid){
	$potype=poType($re_s['posl']);
	$t=explode('_',$re_s['posl']);
	if($potype==1) $receiveAmount=poTotalreceive($re_s['posl'],$t[1]);
	if($potype==2) $receiveAmount=eqpoActualReceiveAmount($re_s['posl']);
	if($potype==3) $receiveAmount=subWorkTotalReceive_Po($re_s['posl']);
	$paid=poPaidAmount($re_s['posl']);
	
	$currentPayable=foodinfAmount($re_s['totalAmount'],$receiveAmount,$paid,$re_s['posl']); 
	$currentPayable=round($currentPayable,2);
}
if($_SESSION["TWP"])
insert_aged_vendor_payment_aux($posl,$currentPayable,""); 
	
$payableSummery+=$currentPayable;
 echo number_format($currentPayable,2)."<br>";
}
	 ?> 
 </td>
</tr>
<tr>
	<td colspan="6" align="right">
	
<?php
// Total Amount Information
	

	
	if($poIsClosedQty>0 && ($itemCodeAmount>0 || $poType==3)){
		
		if($poType==3){
			$itemCodeAmount+=subWorkTotalReceive_Po($posl);
		}
		
		echo "<p class='closedClass'>Forced Closed</p>"; //closing row
		$isClosingVerified=isClosingVerified($posl);
		if($isClosingVerified || 1==1){
			vendorpayable_approved_function($posl,"",$mr,$location,"c");
		}
		if($_SESSION["TWP"])
		insert_aged_vendor_payment_aux($posl,$FinalAmount,"Forced Closed");
		$FinalAmountRow="<p><b><font color='#00f'>".number_format($FinalAmount,2)."</font></b></p>";
	}
	else{
		$FinalAmountRow=$blankRowData;
	}
		
		?></td>
	<td align=right><?php	echo $FinalAmountRow; ?></td>
	<td></td>
	</tr>
	
<tr><td colspan="8" height="2" bgcolor="#0099FF"></td></tr>
<?
$st1=$st2=$st3=$st4=$st5=$st6=0;$poPaidAmount=0;
$ii++;
 }//while?>
	
<tr>
	<td align=right><b>Column Total: </b> &nbsp;</td>
	<td align="right"><b><?php echo number_format($ct,2); ?></b></td>
	<td align="right"><b><?php echo number_format($ct7,2); ?></b></td>
	<td align="right"><b><?php echo number_format($ct15,2); ?></b></td>
	<td align="right"><b><?php echo number_format($ct30,2); ?></b></td>
	<td align="right"><b><?php echo number_format($ct60,2); ?></b></td>
	<td align="right"><b><?php echo number_format($ct91,2); ?></b><br>
	</td>
	<td align="right"><b><?php echo number_format($payableSummery,2); ?></b></td>
</tr>
	<tr>
	<td align=right><b>Forced Closing Total: </b> &nbsp;</td>
		<td colspan="6"><?php echo $ctClosingAmount; ?></td>
	
	</tr>
	
</table>
<? }//if?>
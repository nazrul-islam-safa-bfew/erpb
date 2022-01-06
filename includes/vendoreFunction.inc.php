<? 
function poCredit($vid){
	 include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	global $db; 
$sql="SELECT camount,cduration from vendor where vid='$vid'";
$sqlq=mysqli_query($db, $sql);
$r=mysqli_fetch_array($sqlq);
if($r[camount])return $r[camount].'_'.$r[cduration];
else return '0';
}

function isClosingVerified($posl,$rowCounter=true){
	global $db;
	
	$selection="*";
	if($rowCounter)
		$selection="count(*) as row";
	
	$sql="select $selection from verify_vendor_payable where posl='$posl' and invoiceDate='' and type='c'";
// 	echo $sql;
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	
	if($rowCounter)
		return $row[row] > 0 ? true : false;
	else
		return $row;
}



function vendorpayable_approved_function($posl,$indate,$mr,$location,$type=null){
//print_r($mr);
global $db;
if(is_vendor_payable_approved($posl,$indate) && ($_SESSION["loginDesignation"]=="Accounts Executive" || $_SESSION["loginDesignation"]=="Chairman & Managing Director")){
				echo "<span><a href='".vendor_payable_approval_pdf($posl,$indate,$type)."' target='_blank' class='pdf_class'><img src='./images/pdf.png'></a></span>";
				echo "<span class='verifyClass'>Verified</span>";
			}
	if($_SESSION["loginDesignation"]=="Accounts Executive" && $mr[cc]!="2"){
		echo '<a href="./vendor/verify_aged_vendor_payable.php?posl='.$mr[posl]."&pcode=".$location.'&invoiceDate='.$indate.'&type='.$type.'" target="_blank" class="verifyBTN">[Verify]</a>';
	}elseif($mr[cc]==2){
		echo '<div style="background: #077900;color: #fff;display: inline-block;padding: 3px;border-radius: 5px;float: right;font-size: 12px; margin-top:2px;">Verified</div>';
	}
	
}


function actualPOreceiveAmount($posl,$type,$pcode){
	if(!$pcode || !$posl || !$type)return false;
	global $db;
	if($type==1)//if material
		$sql="select sum(receiveQty*rate) totalReceive from store$pcode where paymentSL='$posl'";
	elseif($type==3) //else subcontactor
		$sql="select sum(qty*rate) totalReceive from subut where posl='$posl' and pcode='$pcode'";
	elseif($type==2){ //else equipment
		return eqpoActualReceiveAmount($posl);
	}
	
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $totalReceive=$row["totalReceive"];
}


function poIsClosedQty($posl,$itemCode=null){
	global $db;
	$sql="select count(*) as total from porder where posl='$posl'";
	if($itemCode)$sql.=" and itemCode='$itemCode'"; //itemcode selected
	$sql.=" and fClosed='1' and status='2' ";
// 	echo $sql;
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row["total"];
}
?>

<? 
function viewpoCredit($posl){
	 include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	global $db; 
$sql="SELECT poRef from popaymentstemp where posl='$posl'";
$sqlq=mysqli_query($db, $sql);
$r=mysqli_fetch_array($sqlq);
return $r[poRef];

}
?>

<?
function overPayment($d,$posl){
	 include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	global $db; 

$sqlf="SELECT SUM(paidAmount) as totalOver from vendorpayment WHERE paymentDate < '$d' AND `posl` LIKE '$posl'";
//echo $sqlf.'<br>';
$sqlq=mysqli_query($db, $sqlf);
$r=mysqli_fetch_array($sqlq);
return $r[totalOver];
}
?>
<?
function PaidBeforeMaturity($d1,$d2,$posl,$paidAfterMaturity,$k){
/*if($k==1){
   $sqlf="SELECT SUM(paidAmount) as totalOver from vendorpayment".
         " WHERE paymentDate <= '$d2'".
		 " AND `posl` LIKE '$posl'";
$sqlq=mysqli_query($db, $sqlf);
$r=mysqli_fetch_array($sqlq);

$paid=$r[totalOver];
}
elseif($k>=2){		 
   $sqlf="SELECT SUM(paidAmount) as totalOver from vendorpayment".
         " WHERE paymentDate BETWEEN  '$d1' AND '$d2'".
		 " AND `posl` LIKE '$posl'";

$sqlq=mysqli_query($db, $sqlf);
$r=mysqli_fetch_array($sqlq);

//$reamount=$r[totalOver]-$paidAfterMaturity;
//echo "<br>$reamount==$r[totalOver]=$paidAfterMaturity;<br>";
}
*/
   $sqlf="SELECT SUM(paidAmount) as totalOver from vendorpayment".
         " WHERE paymentDate < '$d2'".
		 " AND `posl` LIKE '$posl'";
$sqlq=mysqli_query($db, $sqlf);
$r=mysqli_fetch_array($sqlq);

$paid=$r[totalOver];
return $paid;

/*if($reamount>0)
return $reamount;
else return 0;
*/
}
?>

<?
function PaidAfterMaturity($d1,$d2,$posl,$paidAfterMaturity,$k){
	 include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	global $db; 

   $sqlf="SELECT SUM(paidAmount) as totalOver from vendorpayment".
         " WHERE paymentDate >= '$d2'".
		 " AND `posl` LIKE '$posl'";
//echo $sqlf.'<br>';		 
$sqlq=mysqli_query($db, $sqlf);
$r=mysqli_fetch_array($sqlq);

$paid=$r[totalOver];
return $paid;

/*if($reamount>0)
return $reamount;
else return 0;
*/
}
?>

<?
function vendorRating($v,$t){
	if($t=='1'){
	if($v=='-10') $out='Opportunist company/person/lobbyest';
	else if($v=='0') $out='Local Plyer: Retailer/ Local Vendor/ Local contractor';
	else if($v=='5') $out='Regional Player: Distributor/ Wholeseller/ 2nd class & regional contractor';
	else if($v=='10') $out='National Player: Manufacture/ Importer/ 1st Class national contractor';
	}
	if($t=='2'){
	if($v=='0') $out='Leader';
	else if($v=='5') $out='Challenger';
	else if($v=='10') $out='Follower';
	}
	if($t=='5'){
	if($v=='-10') $out='Do not meet the requirements';
	else if($v=='0') $out='Meet the requirements';
	else if($v=='10') $out='Brand items that gives us competiteve advantage';
	}	
	if($t=='3'){
	if($v=='-10') $out='No Experience';
	else if($v=='0') $out='Less then 2 year';
	else if($v=='5') $out='Above 2 years';
	else if($v=='10') $out='Above 5 years';
	}
	if($t=='4'){
	if($v=='0') $out='Bill-to-Bill';
	else if($v>'0') $out='Yes';
	}
	if($t=='6'){
	if($v=='-10') $out='Insufficient ability to meet supply schedule';
	else if($v=='0') $out='Able to meet supply schedule, limited ability to meet contingency events';
	else if($v=='10') $out='Able to meet supply schedule, able to meet contingency events';
	}
	if($t=='7'){
	if($v=='-10') $out='Record of quality problem with BFEW in last 10 years (Failed to maintain delivery schedule in terms of quantity or quality for materials, equipment, work  or labor; BFEW was forced to support the vendor with equipment, materials, labor or working capital to complete the work on time).';
	else if($v=='0') $out='No Experience';
	else if($v=='5') $out='Less then 3 years';
	else if($v=='10') $out='Above 3 years';
	}

	return $out;
}
?>
<?
function payableAmount($posl,$activation,$rdate,$r){
include("./includes/config.inc.php");

$pototalAmount=poTotalAmount($posl);
$popaidAmount=poPaidAmount($posl);
$poReceiveAmount=poReceiveAmount($posl);

$remainingAmount = $pototalAmount-$popaidAmount; // total remaining amount
$amountPayable = $poReceiveAmount-$popaidAmount; // due amount

$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 
$sqlp1 = "SELECT * from  `pcondition` WHERE posl='$posl'";
//echo $sqlp1;
$sqlrunp1= mysqli_query($db, $sqlp1);
$typel2= mysqli_fetch_array($sqlrunp1);
//echo $typel2[condition];
$extra=$typel2[extra];
$temp=explode('_',$typel2[condition]);
$ch1=0;$ch2=0;$ch3=0;$ch4=0;$ch5=0;
$ch6=0;$ch7=0;$ch8=0;$ch9=0;$ch10=0;
$ch11=0;$ch12=0;$ch13=0;$ch14=0;$ch15=0;
$ch16=0;$ch17=0;$ch18=0;$ch19=0;$ch20=0;
$ch21=0;$ch22=0;

for($k=0;$k<sizeof($temp);$k++){
  if($temp[$k]=='ch1') {$ch1=1;}
  else if($temp[$k]=='ch2') {$ch2=1;}
  else if($temp[$k]=='ch3') {$ch3=1;}
  else if($temp[$k]=='ch4') {$ch4=1;}
  else if($temp[$k]=='ch5') {$ch5=1;}
  else if($temp[$k]=='ch6') {$ch6=1;}
  else if($temp[$k]=='ch7') {$ch7=1;}
  else if($temp[$k]=='ch8') {$ch8=1;}
  else if($temp[$k]=='ch9') {$ch9=1;}                
  else if($temp[$k]=='ch10') {$ch10=1;}  
  else if($temp[$k]=='ch11') {$ch11=1;}
  else if($temp[$k]=='ch12') {$ch12=1;}
  else if($temp[$k]=='ch13') {$ch13=1;}
  else if($temp[$k]=='ch14') {$ch14=1;}                
  else if($temp[$k]=='ch15') {$ch15=1;}  
  else if($temp[$k]=='ch16') {$ch16=1;}  
  else if($temp[$k]=='ch17') {$ch17=1;}
  else if($temp[$k]=='ch18') {$ch18=1;}
  else if($temp[$k]=='ch19') {$ch19=1;}
  else if($temp[$k]=='ch20') {$ch20=1;}                
  else if($temp[$k]=='ch21') {$ch21=1;}  
  else if($temp[$k]=='ch22') {$ch22=1;}
}
//$tch51=$temp[23];
$tch51=$temp[22];
$tch81=$temp[24];
$tch82=$temp[25];
$tch111=$temp[26];
$tch112=$temp[27];
$tch121=$temp[28];
$tch122=$temp[29];
$tch13=$temp[30];
$tch15=$temp[31];
$tch16=$temp[32];

$advancePymentDate=$activation;
$failureCut = $tch51;
//echo "failureCut = $tch51;";
//print_r($temp);
if($r==22) return $failureCut;
$advancePayment = $tch112;

if(strtotime($advancePymentDate)<=strtotime($rdate))
$amountPayable+=$advancePayment;
return $amountPayable;
}
?>


<?
function poPaidAmount($posl){
	 include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	global $db; 

$sqlp11 = "SELECT SUM(paidAmount) as paidAmount from `vendorpayment` WHERE posl='$posl'";
//echo $sqlp11;
$sqlrunp11= mysqli_query($db, $sqlp11);
$typel21= mysqli_fetch_array($sqlrunp11);
$amount = $typel21[paidAmount];
return $amount;
}
?>
<?
function poReceiveAmount($posl){
	 include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	global $db; 
$sqlp11 = "SELECT receiveAmount from  `popayments` WHERE posl='$posl'";
//echo $sqlp11;
$sqlrunp11= mysqli_query($db, $sqlp11);
$typel21= mysqli_fetch_array($sqlrunp11);
$amount = $typel21[receiveAmount];
return $amount;
}
?>

<?
function perDayPayment($posl,$poid,$itemCode,$rate,$receiveDate,$location){
$scheduleReceive =scheduleReceive($poid,$receiveDate);
$actualReceive =totalReceive($receiveDate,$location,$posl,$itemCode);
echo "<br>scheduleReceive:$scheduleReceive<br>actualReceive:$actualReceive<br>";
if($actualReceive>=$scheduleReceive) {
$amount=$scheduleReceive*$rate;
//return "<font color=#009900>".$amount."</font>";
return $amount;
}
else {
$cutRate = payableAmount($posl,$activation,$rdate,22);
echo "cutRate:$cutRate<br>";
$remainQty=$scheduleReceive-$actualReceive;
$amountD=$remainQty*$rate;
$amountCut=($amountD*$cutRate)/100;
echo "amountCut:$amountCut<br>";
$amount=$actualReceive*$rate+$amountD-$amountCut;
return $amount;
//return "<font color=#DD0000>".$amount."</font>";
}
 //return $scheduleReceive*$rate;
 return 0;
}
?>
<?
function scheduleReceive($poid,$sdate){
	 include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	global $db; 

$sqlp11 = "SELECT SUM(qty) as qty from  `poschedule` WHERE poid='$poid' AND sdate<='$sdate'";
//$sqlp11 = "SELECT qty from  `poschedule` WHERE poid='$poid' AND sdate='$sdate'";
//echo $sqlp11;
$sqlrunp11= mysqli_query($db, $sqlp11);
$typel21= mysqli_fetch_array($sqlrunp11);
$qty = $typel21[qty];

return $qty;
}
?>

<?
function scheduleReceiveperDay($poid,$sdate){
	 include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	global $db; 

//$sqlp11 = "SELECT SUM(qty) as qty from  `poschedule` WHERE poid='$poid' AND sdate<='$sdate'";
$sqlp11 = "SELECT qty from  `poschedule` WHERE poid='$poid' AND sdate='$sdate'";
//echo $sqlp11;
$sqlrunp11= mysqli_query($db, $sqlp11);
$typel21= mysqli_fetch_array($sqlrunp11);
$qty = $typel21[qty];


return $qty;
}
?>

<? 
function actualReceivePO($posl,$p){
	 include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	global $db; 
$amountTotal=0;
$sql="select * from store$p WHERE paymentSL='$posl' ORDER by todat";
//echo '<br>--'.$sql.'--<br>';
$sqlq=mysqli_query($db, $sql);
while($r=mysqli_fetch_array($sqlq)){
$amountTotal+=$r[receiveQty]*$r[rate];
//echo "**$amountTotal**";
//if($amountTotal>=$amount) break;
}
return $amountTotal;

}
?>
<? 
function PO_maturityDate($posl,$amount,$p){
	 include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	global $db; 
$amountTotal=0;
$sql="select * from store$p WHERE paymentSL='$posl' ORDER by todat";
//echo '<br>--'.$sql.'--<br>';
$sqlq=mysqli_query($db, $sql);
	while($r=mysqli_fetch_array($sqlq)){
		$amountTotal+=$r[receiveQty]*$r[rate];
	//	echo "**=$amountTotal==$amount**";
		if($amountTotal>=$amount){ return $r[todat];}
	}

	//return todat();
}
?>

<? 
function PO_submaturityDate($posl,$amount){
	 include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	global $db; 
$amountTotal=0;
//echo "++$posl,$amount++";
$sql="SELECT * from subut WHERE posl='$posl'";
//echo "<br>$sql<br>";
$sqlq=mysqli_query($db, $sql);
	while($r=mysqli_fetch_array($sqlq)){
		$amountTotal+=$r[qty]*$r[rate];
	//	echo "**=$amountTotal==$amount**";
		if($amountTotal>=$amount){ return $r[edate];}
	}
	return 0;
}
?>

<?
function scheduleReceiveperInvoice_under($posl,$sdate){

	 include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	global $db; 
$sqlp11 = "SELECT SUM(qty) as qty,itemCode from  `poscheduletemp`".
" WHERE posl='$posl' AND sdate<='$sdate' GROUP by itemCode ORDER by itemCode ASC ";
//echo '<br>'.$sqlp11.'here---------------<br>';
$sqlrunp11= mysqli_query($db, $sqlp11);
$i=1;
while($re= mysqli_fetch_array($sqlrunp11)){
//echo "--$typel21[qty]--";
$qt[$i][0]=$re[itemCode];
$qt[$i][1]=$re[qty];
$i++;
}
//print_r($qt);
return $qt;
}
?> 

<?
function scheduleReceiveperInvoice($posl,$sdate){
global $db;
$sqlp11 = "SELECT SUM(qty) as qty,itemCode from  `poschedule`".
" WHERE posl='$posl' AND sdate<='$sdate' GROUP by itemCode ORDER by itemCode ASC ";
//echo '<br>'.$sqlp11.'here---------------<br>';
$sqlrunp11= mysqli_query($db, $sqlp11);
$i=1;
while($re= mysqli_fetch_array($sqlrunp11)){
//echo "--$typel21[qty]--";
$qt[$i][0]=$re[itemCode];
$qt[$i][1]=$re[qty];
$i++;
}
//print_r($qt);

return $qt;
}
?>
<?
function scheduleReceiveperInvoiceAmount($posl,$sdate){
	include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	global $db;
//if($sdate1=='') $sdate1='0000-00-00';
//echo "<br>***$sdate1 == $sdate ***<br>";
$sqlp11 = "SELECT SUM(qty) as qty,itemCode from  `poschedule` 
 WHERE posl='$posl' AND sdate ='$sdate' GROUP by itemCode HAVING qty>0 ORDER by itemCode ASC";
// echo '<br>'.$sqlp11.'<br>';
$sqlrunp11= mysqli_query($db, $sqlp11);
$i=1;
while($re= mysqli_fetch_array($sqlrunp11)){
$sql="select ROUND($re[qty]*rate,2) as amount from porder where posl='$posl' AND itemCode='$re[itemCode]'";
// echo "<br> >>> $sql<br>";
$sqlq=mysqli_query($db, $sql);
$r=mysqli_fetch_array($sqlq);
//echo "--$typel21[qty]--";
//$qt[$i][0]=$re[itemCode];
//$qt[$i][1]=
//echo "==qty===".$r[amount]."=====";
//$i++;

$amount+=$r[amount];
}
//print_r($qt);
return $amount."po//amount";
}
?>
<?
function scheduleReceiveperInvoiceAmount_by_sub_ut($posl,$sdate){
	 include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	global $db; 
//if($sdate1=='') $sdate1='0000-00-00';
//echo "<br>***$sdate1 == $sdate ***<br>";
$sqlp11 = "SELECT SUM(qty) as qty,itemCode from  `poschedule` 
 WHERE posl='$posl' AND sdate ='$sdate' GROUP by itemCode HAVING qty>0 ORDER by itemCode ASC ";
//echo '<br>'.$sqlp11.'<br>';
$sqlrunp11= mysqli_query($db, $sqlp11);
$i=1;
while($re= mysqli_fetch_array($sqlrunp11)){
$sql="select ROUND($re[qty]*rate,2) as amount from porder where posl='$posl' AND itemCode='$re[itemCode]'";
//echo "<br> >>> $sql<br>";
$sqlq=mysqli_query($db, $sql);
$r=mysqli_fetch_array($sqlq);
//echo "--$typel21[qty]--";
//$qt[$i][0]=$re[itemCode];
//$qt[$i][1]=$re[qty];
//$i++;

$amount+=$r[amount];
}
//print_r($qt);
return $amount;
}
?>
<?
function poAdvance($posl){
	 include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	global $db; 

$sqlp1 = "SELECT * from  `pcondition` WHERE posl='$posl'";
//echo $sqlp1;
$sqlrunp1= mysqli_query($db, $sqlp1);
$typel2= mysqli_fetch_array($sqlrunp1);
$temp=explode('_',$typel2[condition]);

if(poType($posl)=='3')$advancePaymentAmount = $temp[30];//amount
if(poType($posl)=='1')$advancePaymentAmount = $temp[30];//amount
if(poType($posl)=='2')$advancePaymentAmount = $temp[25];//amount
return $advancePaymentAmount;
}
?>

<?
function poAdvanceCut($inVoiceNO,$advanceAmount){
$inVoiceNO=$inVoiceNO-1;
$advanceCut=$advanceAmount/$inVoiceNO;
return $advanceCut;
}
?>
<? 
function retentionAmount($amountGt,$posl){
	 include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	global $db; 
$sqlp1 = "SELECT * from  `pcondition` WHERE posl='$posl'";
//echo $sqlp1;
$sqlrunp1= mysqli_query($db, $sqlp1);
$typel2= mysqli_fetch_array($sqlrunp1);

$temp=explode('_',$typel2[condition]);

$retention = $temp[33];//amount
//echo "**$retention**$amountGt**";
if($retention){
$retentionAmount=($amountGt*$retention)/100;
//echo '++'.$retentionAmount.'++';
return $retentionAmount;
}
else return 0;
}
?>

<? 
function foodingAmount($amountGt,$posl){
	 include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	global $db; 
$sqlp1 = "SELECT * from  `pcondition` WHERE posl='$posl'";
//echo $sqlp1;
$sqlrunp1= mysqli_query($db, $sqlp1);
$typel2= mysqli_fetch_array($sqlrunp1);

$temp=explode('_',$typel2[condition]);

$fooding = $temp[37];//amount
//echo "**$retention**$amountGt**";
if($fooding){
$foodingAmount=($amountGt*$fooding)/100;
//echo '++'.$retentionAmount.'++';
return $foodingAmount;
}
else return 0;
}

?>

<? 
function poVid($posl){

$p=explode('_',$posl);
return $p[3];
}
?>


<? 
function poType($posl){
 include("config.inc.php");
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

 $sql="SELECT poType From pordertemp where posl LIKE '$posl' ";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 return $rr[poType];

}
?>

<? 
function poProject($posl){

$p=explode('_',$posl);
return $p[1];
}
?>

<? 
function poVendorName($posl){
	 include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	global $db; 

$p=explode('_',$posl);
$v=$p[3];
$vendor = "SELECT * FROM vendor WHERE vid=$v";
// echo '<br>'.$vendor.'<br>';
$sqlrunvendor= mysqli_query($db, $vendor);
$ven= mysqli_fetch_array($sqlrunvendor);

return $ven[vname];
}
?>

<? 
function poQty_under($posl,$itemCode){
//$d=formatDate($d,'Y-m-d');
//echo "******$posl,$itemCode********";
 include("config.inc.php");
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

 $sql="SELECT qty From pordertemp where posl LIKE '$posl' AND itemCode='$itemCode'";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 return $rr[qty];
}
?>


<? 
function poreceiveStart_under($posl){
//$d=formatDate($d,'Y-m-d');
 include("config.inc.php");
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

 $sql="SELECT dstart From pordertemp where posl='$posl'";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 return $rr[dstart];
}
?>
<? 
function poreceiveActiveDate_under($posl){
 global $db;
 $sql="SELECT activeDate From pordertemp where posl='$posl'";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 return $rr[activeDate];
}
?>

<? 
function poScheduleDate_under($posl){
//$d=formatDate($d,'Y-m-d');
 include("config.inc.php");
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

 $sql="SELECT DISTINCT sdate From poscheduletemp   where posl='$posl' ORDER by sdate ASC";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $i=1;
 while($rr=mysqli_fetch_array($sqlQuery)){
 $dat[$i]=$rr[sdate];
 $i++;
 }
 //print_r($dat);
 return $dat;
}
?>

<? 
function poInvoiceDate_under($posl){
//$d=formatDate($d,'Y-m-d');

	 include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	global $db; 	 

 $sql="SELECT DISTINCT sdate From poscheduletemp where posl='$posl' AND invoice='1' ORDER by sdate ASC";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $i=1;
 while($rr=mysqli_fetch_array($sqlQuery)){
 $dat[$i]=$rr[sdate];
 $i++;
 }
 //print_r($dat);
 return $dat;
}
?>
<? 
function poInvoiceDate($posl){
//$d=formatDate($d,'Y-m-d');

 include("config.inc.php");
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 
if(poType($posl)=='2'){

$sqlp1 = "SELECT sdate from  `poschedule` WHERE posl='$posl' ORDER by sdate DESC";
// echo '-------'.$sqlp1.'----------';
$sqlrunp1= mysqli_query($db, $sqlp1);
$typel2= mysqli_fetch_array($sqlrunp1);
 $edate=strtotime($typel2[sdate]);
 $edate=date("Y-m-d",mktime(0, 0, 0, date("m",$edate)+1, '01',   date("Y",$edate)));
 
$podate1=poreceiveActiveDate_under($posl);
$indate=$podate1; 
$i=1;
while($podate1<=$indate AND $indate<$edate){

$indateTemp=strtotime($indate);

$indate=date("Y-m-d",mktime(0, 0, 0, date("m",$indateTemp)+1, '01',   date("Y",$indateTemp)));
// echo "<br>$indate=$podate1=$edate;<br>";
//echo '>>>>>>> '.$indate;
//exit;
$dat[$i]=$indate;
$i++;
}

}else {
 $sql="SELECT DISTINCT sdate From poschedule   where posl='$posl' AND invoice='1' ORDER by sdate ASC";
// echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $i=1;
 while($rr=mysqli_fetch_array($sqlQuery)){
 $dat[$i]=$rr[sdate];
 $i++;
 }
 //print_r($dat);
 }
  return $dat;
}
?>
<? 
function poScheduleDateQty_under($posl,$sdate,$itemCode){
//$d=formatDate($d,'Y-m-d');
 include("config.inc.php");
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

 $sql="SELECT qty From poscheduletemp   where posl='$posl' AND sdate='$sdate' AND itemCode='$itemCode' ORDER by sdate ASC";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $i=1;
$rr=mysqli_fetch_array($sqlQuery);
 return $rr[qty];
}
?>

<? 
function totalReceivePo($d,$p,$posl){
 //$d=formatDate($d,'Y-m-d');
 include("config.inc.php");
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

$t=explode('_',$posl);
//print_r($t);
if($t[3]=='99'){
 $sql="SELECT SUM(receiveQty) as totalReceive from storet$p WHERE todat<='$d' AND  reference='$posl'";
 echo "$sql";
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $totalReceive=$rr[totalReceive];
 if($totalReceive>0) return $totalReceive;
 else return 0;
 }else{
	 $sql="SELECT SUM(receiveQty) as totalReceive From store$p 
	 where todat<='$d' AND paymentSL='$posl'";
	echo $sql;
	 $sqlQuery=mysqli_query($db, $sql);
	 $rr=mysqli_fetch_array($sqlQuery);
	 $totalReceive=$rr[totalReceive];
	 if($totalReceive>0) return $totalReceive;
	 else return 0;
 }
}

function totalReceive($d,$p,$posl,$itemCode){
 //$d=formatDate($d,'Y-m-d');
 include("config.inc.php");
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

$t=explode('_',$posl);
//print_r($t);
if($t[3]=='99'){
 $sql="SELECT SUM(receiveQty) as totalReceive from storet$p WHERE todat<='$d' AND  reference='$posl' AND itemCode='$itemCode'";
 //echo "$sql";
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $totalReceive=$rr[totalReceive];
 if($totalReceive>0) return $totalReceive;
 else return 0;
 }else{
	 $sql="SELECT SUM(receiveQty) as totalReceive From store$p 
	 where todat<='$d' AND paymentSL='$posl' AND itemCode='$itemCode'";
	//echo $sql;
	 $sqlQuery=mysqli_query($db, $sql);
	 $rr=mysqli_fetch_array($sqlQuery);
	 $totalReceive=$rr[totalReceive];
	 if($totalReceive>0) return $totalReceive;
	 else return 0;
 }
}
?>

<?
function poPayableAmount($posl,$sdate,$pototalAmount,$paidAmount,$exfor,$poType){
	include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	global $db; 
//echo "poType=$poType";
$ad=poAdvance($posl);
$advanceAmountPayable=($pototalAmount*$ad)/100;

//echo "$advanceAmountPayable=($pototalAmount*$ad)/100;";
 $sql2="SELECT distinct sdate from poschedule where posl='$posl' AND sdate<='$sdate' AND invoice='1' order by sdate DESC";
// echo "<br>$sql2";
 $sqlq2=mysqli_query($db, $sql2);
$ree=mysqli_fetch_array($sqlq2);
$invoiceDate=$ree[sdate];

$sql="SELECT * FROM porder where posl='$posl' AND qty>0 ORDER by itemCode ASC";
//echo "$sql";
$sqlq=mysqli_query($db, $sql);
while($re=mysqli_fetch_array($sqlq)){
if($poType==1 OR $poType==3){
$rate=$re[rate];
 $sql2="SELECT SUM(qty) as qty from poschedule where
  posl='$posl' AND itemCode='$re[itemCode]' AND sdate<='$invoiceDate'";
//echo "<br>$sql2<br>";
 $sqlq2=mysqli_query($db, $sql2);
  $ree=mysqli_fetch_array($sqlq2);
    $planReceiveQty=$ree[qty];
	if($poType==1)$actualReceiveQty=totalReceive('9999-0-0',$exfor,$posl,$re[itemCode]);
	else if($poType==3)$actualReceiveQty=subWork_Po($re[itemCode],$posl);
	//echo "$re[itemCode]<br>=$planReceiveQty==$actualReceiveQty<br>";
	if($actualReceiveQty>=$planReceiveQty){$totalAmount+=$planReceiveQty*$rate; }
     else {
			$totalAmount=0; //echo "***$actualReceiveQty>=$planReceiveQty***";
	    break;
		}
	}

}//while

if($poType==2) {   
/*$qty=$re[qty];
$rate=$re[rate]/8;	

$eqActualReceiveAmount=eqpoActualReceiveAmount($posl);
if($eqPlanReceiveAmount==$eqActualReceiveAmount) {$totalAmount+=$eqActualReceiveAmount;}
 else {$totalAmount=0;break;}
 */
$eqActualReceiveAmount=eqpoActualReceiveAmount($posl); 
 $totalAmount+=$eqActualReceiveAmount;
// echo "***$totalAmount*$eqActualReceiveAmount*";
 }

$cutAdvance=($totalAmount*$ad)/100;
$payableTotalAmount=$totalAmount-$cutAdvance;
//echo "<br>***PP=$payableTotalAmount=$totalAmount-$cutAdvance;<br>";
$actualPayable=round((($payableTotalAmount+$advanceAmountPayable)-$paidAmount),2);
//echo "**AA==$payableTotalAmount+$advanceAmountPayable)-$paidAmount**<br>";
if($actualPayable>0)
return $actualPayable;
else return '0';
}
?>

<?
function vendorPaymentAmount($posl){
	global $db;
$sqlp11 = "SELECT round(paidAmount,2) as paidAmount 
from  `vendorpayment` WHERE posl='$posl'";
// echo $sqlp11;
$sqlrunp11= mysqli_query($db, $sqlp11);
$typel21= mysqli_fetch_array($sqlrunp11);
	return $typel21[paidAmount];
}

function isFullpaid($posl){
global $db;
$sqlp11 = "SELECT round(totalAmount,2) as totalAmount,round(paidAmount,2) as paidAmount 
from `popayments` WHERE posl='$posl'";
// echo $sqlp11;
$sqlrunp11= mysqli_query($db, $sqlp11);
$typel21= mysqli_fetch_array($sqlrunp11);
if(!$typel21[paidAmount])
$typel21[paidAmount]+=vendorPaymentAmount($posl)+1;
// echo "$posl: $typel21[paidAmount]>=$typel21[totalAmount]<br>";
if($typel21[paidAmount]>=$typel21[totalAmount]){ return 1;}
else return 0;
}
?>
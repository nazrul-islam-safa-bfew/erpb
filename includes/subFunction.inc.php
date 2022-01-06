<?

/* */
/*
function fooding_paid($posl,$project){

$sql="SELECT Sum(paidAmount) As totalAmount 
FROM purchase 
where reff='$posl' AND account='5502000-$project' ";
//echo $sql;
$sqlq=mysqli_query($db, $sql);
$sqlr=mysqli_fetch_array($sqlq);
return $sqlr[totalAmount];

}
*/
?>
<? 
function showIow($iowdata){
	global $db;
$sql="SELECT * from iow where iowId='$iowdata'";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $iowdt = $rr[iowCode];
  return $iowdt; 

}
function showSubIow($siowdata){
	global $db;
$sql="SELECT * from siow where siowId='$siowdata'";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $siowdt = $rr[siowName];
  return $siowdt; 
}

?>
<?
/* return approved item of a iow*/
function subWork_dmaqty($itemCode,$iow,$siow){
	global $db;
$sql="SELECT dmaQty 
FROM dma 
where itemCode='$itemCode' AND dmaiow='$iow' AND dmasiow='$siow'";
$sqlq=mysqli_query($db, $sql);
$sqlr=mysqli_fetch_array($sqlq);
$dmaQty = $sqlr[dmaQty];
}
?>
<? 
/* return tota work done in a siow*/
function subWork_siow($itemCode,$iow,$siow){
	global $db;
$sql="SELECT SUM(qty) as totalQty 
from subut 
WHERE itemCode='$itemCode' AND iow='$iow' AND siow='$siow'";
//echo '<br>'.$sql.'<br>';
$sqlq=mysqli_query($db, $sql);
$sqlf=mysqli_fetch_array($sqlq);
return $sqlf[totalQty];
}
?>
<? 
/* return tota work done in a siow*/
function subWork_issued($itemCode,$siow){
	global $db;
$sql="SELECT SUM(qty) as totalQty from subut WHERE itemCode='$itemCode' AND siow='$siow'";
//echo $sql;
$sqlq=mysqli_query($db, $sql);
$sqlf=mysqli_fetch_array($sqlq);
return $sqlf[totalQty];
}
?>

<? 
/* return tota work done in a siow in  date*/
function subWork_dailyIssued($itemCode,$siow,$d){
	global $db;
$sql="SELECT SUM(qty) as totalQty 
from subut 
WHERE itemCode='$itemCode' AND siow='$siow' AND edate='$d'";
//echo $sql;
$sqlq=mysqli_query($db, $sql);
$sqlf=mysqli_fetch_array($sqlq);
return $sqlf[totalQty];
}
?>

<? 
/* return tota work done in a porder*/
function subWork_Po($itemCode,$posl){
	global $db;
	$sql="SELECT round(SUM(qty),3) as totalQty 
	from subut 
	WHERE itemCode='$itemCode' AND posl='$posl'";
	//echo $sql;
	$sqlq=mysqli_query($db, $sql);
	$sqlf=mysqli_fetch_array($sqlq);
	if($sqlf[totalQty]>0)return $sqlf[totalQty];
	else return 0;
}
?>

<? 
/* return tota remain work in a posl of a item*/
function subWork_Poremain($itemCode,$posl){
	global $db;
	$sql="select qty from porder WHERE itemCode='$itemCode' AND posl='$posl'";
	// echo $sql;
	$sqlq=mysqli_query($db, $sql);
	$sqlf=mysqli_fetch_array($sqlq);
	$poqty=$sqlf[qty];
	$sql="SELECT SUM(qty) as totalQty 
	from subut 
	WHERE itemCode='$itemCode' AND posl='$posl'";
	//echo $sql;
	$sqlq=mysqli_query($db, $sql);
	$sqlf=mysqli_fetch_array($sqlq);
	$remainQty=$poqty-$sqlf[totalQty];
	// echo "<br>$poqty=$sqlf[totalQty]<br>";
	return round($remainQty,3);
}
?>

<? 
/* return tota work done of a porder all item*/
function subWorkTotalReceive_Po($posl){
	global $db;
$sql="SELECT itemCode,ROUND(rate,2) as rate,ROUND(qty,3) as qty 
from subut 
WHERE posl='$posl'";
//echo $sql;
$sqlq=mysqli_query($db, $sql);
while($sqlf=mysqli_fetch_array($sqlq)){
$subAmount+=$sqlf[rate]*$sqlf[qty];
//echo "**$sqlf[itemCode]=$subAmount**<br>";
}
return $subAmount;
}
?>

<? 
/* return tota work done of a porder , in a perticular date of a item*/
function subWork_dailyPo($itemCode,$posl,$d){
	global $db;
$sql="SELECT SUM(qty) as totalQty 
from subut 
WHERE itemCode='$itemCode' AND posl='$posl' AND edate='$d'";
// echo $sql;
$sqlq=mysqli_query($db, $sql);
$sqlf=mysqli_fetch_array($sqlq);
return $sqlf[totalQty];
}
?>
<? 
/* return tota work done of a porder till a perticular date of a item*/
function subWork_receive($itemCode,$posl,$d){
	global $db;
$sql="SELECT SUM(qty) as totalQty 
from subut 
WHERE itemCode='$itemCode' AND posl='$posl' AND edate<='$d'";
//echo $sql;
$sqlq=mysqli_query($db, $sql);
$sqlf=mysqli_fetch_array($sqlq);
return $sqlf[totalQty];
}
?>
<?
/* return siow per day requirment of an item in a siow */
function sub_perdayRequired($siow,$itemCode,$dat,$pp){
	global $db;
 $siowDaysGan=siowDaysGan($siow,$dat);

 if($siowDaysGan==0){ 
 $approvedQty=approvedQty($siow,$itemCode);
 $siowDuration=siowDuration($siow);
 $issuedQty=subWork_issued($itemCode,$siow);
 $remainQty= $approvedQty-$issuedQty; 
 $siowPerDayReq=siowdmaPerDay($siowDuration,$remainQty);
  return  $siowPerDayReq;
 }
 else if($siowDaysGan>0){
  $siowDaysRem=siowDaysRem($siow,$dat); 
	if($siowDaysRem>0){
		$approvedQty=approvedQty($siow,$itemCode);
		$issuedQty=subWork_issued($itemCode,$siow);
		$remainQty= $approvedQty-$issuedQty; 
		$siowPerDayReq=siowdmaPerDay($siowDaysRem,$remainQty);
    return $siowPerDayReq;
	}//remain
	else{
		$approvedQty=approvedQty($siow,$itemCode);
		$issuedQty=subWork_issued($itemCode,$siow);
		$remainQty= $approvedQty-$issuedQty; 	
		$siowPerDayReq=$remainQty;
    return $siowPerDayReq;
	}
 } 
}
 


?>
<? 
/* return actual invoice maturity date*/
function sub_Receive_Po($itemCode,$qty,$posl,$pp){
	global $db;
$dat='0000-00-00';
$sql1="SELECT qty,edate 
from  `subut` 
where  itemCode ='$itemCode' AND posl='$posl' AND pcode='$pp' 
ORDER by edate ASC ";
//echo "$sql1<br>";
 $sqlQuery1=mysqli_query($db, $sql1);
 while($remainQty1=mysqli_fetch_array($sqlQuery1)){
 $remainQty+= $remainQty1[qty];
 if(round($remainQty,3) >= round($qty,3)) {$dat=$remainQty1[edate];break;}
 }
 //echo '='.$remainQty.'==';
 return $dat;
}
?>
<?
/* return total receive in indirect IOW*/
function sub_TotalReceive_indirect($pcode, $fromDate,$toDate){
 global $db;
$sql1="SELECT SUM(qty*rate) as amount,posl,edate 
from subut,iow 
WHERE  subut.edate BETWEEN '$fromDate' AND '$toDate' 
AND iow.iowId=subut.iow  AND pcode='$pcode'  AND iow.iowType='2' 
GROUP by subut.edate,posl Order by subut.edate ASC";
//echo $sql1;
$sqlq1=mysqli_query($db, $sql1);
$i=0;
while($st=mysqli_fetch_array($sqlq1)){
$sub_TotalReceive_indirect+=$st[amount];
}
return $sub_TotalReceive_indirect;
}?>
 <? 
 /* return total  receive in invoiceable and noninvoiceable $iowType=1 & $iowType=2 iow*/
function sub_po_directReceive($pcode,$fromDate,$toDate){
	global $db;

	if(!$_GET["iowType"])$iowType=1;
	else $iowType=$_GET["iowType"];

$sql2="SELECT SUM(subut.qty*subut.rate) as amount,subut.posl,subut.edate 
from subut,iow 
WHERE subut.edate BETWEEN '$fromDate' AND '$toDate' 
AND iow.iowId=subut.iow  AND pcode='$pcode'  AND iow.iowType='$iowType' 
GROUP by pcode";    
// echo $sql2;
 $sqlq2=mysqli_query($db, $sql2) ; 
$po=mysqli_fetch_array($sqlq2);
//echo "total=$total<br>";
return $po[amount];
}
?>
 <? 
 /* return total receive in indirect IOW*/
function sub_po_indirectReceive($pcode,$fromDate,$toDate){
global $db;
$sql2="SELECT SUM(qty*rate) as amount,posl,edate from subut,iow WHERE 
 subut.edate BETWEEN '$fromDate' AND '$toDate' AND iow.iowId=subut.iow  AND pcode='$pcode' 
 AND iow.iowType='2' GROUP by pcode";    
//echo $sql2;
 $sqlq2=mysqli_query($db, $sql2) ; 
$po=mysqli_fetch_array($sqlq2);
//echo "total=$total<br>";
return $po[amount];
}
?>
 <? 
 /*return total amount receive of a purchase order between time period */
function sub_po_Receive($from,$to,$p){
	global $db;
$sql="SELECT SUM(qty*rate) as totalAmount 
from subut 
WHERE  pcode='$p' AND edate BETWEEN '$from' AND '$to'";
	//echo $sql;
	$sqlq=mysqli_query($db, $sql);
	$sqlf=mysqli_fetch_array($sqlq);
	$total+=$sqlf[totalAmount];
	//echo "$po[posl]=$sqlf[totalQty]**<br>";
//}
return $total;
}
?>
<? 
/* return total sub contractor work receive in project in a given time period*/
function total_sub_issueAmount_date($pcode,$from,$to){
global $db;
$sql="select SUM(qty*rate) as amount 
from `subut` 
WHERE pcode='$pcode' AND edate between '$from' and '$to'";  
 // echo $sql.'<br>';
  $sqlQ=mysqli_query($db, $sql);
  $re=mysqli_fetch_array($sqlQ);
  return $re[amount];
}
?>


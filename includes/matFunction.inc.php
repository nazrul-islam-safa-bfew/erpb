<? 

/* return per day total issued quentity of a perticular item in a perticular dat and in a siow*/
function dailyIssue($d,$item,$p,$siow){
	global $db;
 $sql="SELECT SUM(issuedQty) as totalIssued 
 From issue$p 
 where itemCode='$item' AND siowId=$siow AND issueDate='$d'";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
if(mysqli_affected_rows($db)<=0)return false;
 $rr=mysqli_fetch_array($sqlQuery);
 $totalIssued=$rr[totalIssued];
 return $totalIssued;
}?>

<? 
/* return per day total issued quentity of a perticular item in a date range and in a siow*/
function actual_issue_s_to_e($s,$e,$item,$p,$siow){
	global $db;
 $sql="SELECT SUM(issuedQty) as totalIssued 
 From issue$p 
 where itemCode='$item' AND siowId=$siow AND issueDate BETWEEN '$s' AND '$e'";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $totalIssued=$rr[totalIssued];
 if($totalIssued>0) return $totalIssued;
  else return 0;
}?>

<? 
/* return total receive of a porder in a given date of a item */
function dailyReceive($d,$item,$p,$posl){
	global $db;
 $sql="SELECT SUM(receiveQty) as totalReceive
  From store$p where itemCode='$item' AND todat='$d' 
  AND paymentSL='$posl'";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $totalReceive=$rr[totalReceive];
 return $totalReceive>0 ? $totalReceive : 0 ;

}

?>
<? 
/* return total qty of given item in cneter store*/
function cstore_stock_athand($item){
	global $db;
 $sql="SELECT SUM(currentQty) as totalqty 
 From store 
 where itemCode='$item'";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 return $rr[totalqty];
}
?>

<?
/*---------------------------
return date of receive completion of a porder , itemcode of given qty
---------------------------------*/
function mat_receive($itemCode,$qty,$posl,$pp){
$qty=str_replace(",","",number_format($qty,3) ); 
	global $db;
$dat='0000-00-00';
$p=explode('_',$posl);
if($p[3]=='99'){
 $sql1="SELECT receiveQty,todat 
 from  `storet$pp` 
 where  itemCode ='$itemCode' AND reference='$posl' 
 ORDER by  todat ASC ";
//echo "$sql1<br>";
 $sqlQuery1=mysqli_query($db, $sql1);
 while($remainQty1=mysqli_fetch_array($sqlQuery1)){
 $remainQty+= $remainQty1[receiveQty];
 if($remainQty>=$qty) {$dat=$remainQty1[todat];break;}
 }
}else{
 $sql1="SELECT receiveQty,todat 
 from  `store$pp` 
 where  itemCode ='$itemCode' AND paymentSl='$posl' 
 ORDER by  todat ASC ";
//echo "$sql1<br>";
 $sqlQuery1=mysqli_query($db, $sql1);
 while($remainQty1=mysqli_fetch_array($sqlQuery1)){
 $remainQty+=$remainQty1[receiveQty];
$remainQty=str_replace(",","",number_format($remainQty,3) ); 
 if($remainQty >= $qty) {$dat=$remainQty1[todat];break;}
 }
 }	
//echo $sql1;
 return $dat;
}


/*---------------------------
return date of receive completion of a porder , itemcode of given qty
---------------------------------*/
function po_mat_receive($itemCode,$posl,$pp){
	global $db;
	
$p=explode('_',$posl);
if($p[3]=='99'){
 $sql1="SELECT receiveQty,todat 
 from  `storet$pp` 
 where  itemCode ='$itemCode' AND reference='$posl' 
 ORDER by  todat ASC ";
// echo "$sql1<br>";
 $sqlQuery1=mysqli_query($db, $sql1);
 while($remainQty1=mysqli_fetch_array($sqlQuery1)){
 $remainQty+=$remainQty1[receiveQty];
 }
}else{
 $sql1="SELECT receiveQty*rate as amount 
 from  `store$pp` 
 where  itemCode ='$itemCode' AND paymentSl='$posl' ";
//echo "$sql1<br>";
 $sqlQuery1=mysqli_query($db, $sql1);
 while($remainQty1=mysqli_fetch_array($sqlQuery1)){
 $amount+=$remainQty1[amount];
 }
 }	
//echo $sql1;
 return $amount;
}


/*---------------------------
return date of receive completion of a porder , itemcode of given qty
---------------------------------*/
function po_mat_receiveExt($itemCode,$posl,$pp){
	global $db;
	
$p=explode('_',$posl);
if($p[3]=='99'){
 $sql1="SELECT receiveQty*rate amount,todat 
 from  `storet$pp` 
 where  itemCode ='$itemCode' AND reference='$posl' 
 ORDER by  todat ASC ";
// echo "$sql1<br>";
 $sqlQuery1=mysqli_query($db, $sql1);
 while($remainQty1=mysqli_fetch_array($sqlQuery1)){
 $amount+=$remainQty1[amount];
 }
}else{
 $sql1="SELECT receiveQty*rate as amount 
 from  `store$pp` 
 where  itemCode ='$itemCode' AND paymentSl='$posl' ";
//echo "$sql1<br>";
 $sqlQuery1=mysqli_query($db, $sql1);
 while($remainQty1=mysqli_fetch_array($sqlQuery1)){
 $amount+=$remainQty1[amount];
 }
 }	
//echo $sql1;
 return $amount;
}


function totalRemainQty($posl,$itemCode){
	global $db;	
	$psql="SELECT (sum(p.qty)) as remainQty FROM porder as p WHERE p.itemCode='$itemCode' and p.posl='$posl'";
	$pq=mysqli_query($db,$psql);
	$prow=mysqli_fetch_array($pq);
	
	
	$sql="SELECT (sum(s.receiveQty)) as remainQty FROM `store206` as s WHERE s.paymentSL='$posl' and s.itemCode='$itemCode'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	
	
 $sqlf = "SELECT sum(receiveQty) as totalReturn FROM `storet` where  itemCode='$itemCode' AND returnFrom='$posl'";
//echo $sqlf.'<br>';
$sqlQ= mysqli_query($db, $sqlf);
$sqlQf=mysqli_fetch_array($sqlQ);
$totalReturn=$sqlQf[totalReturn];
	
	
	$remain=($prow[remainQty]-$row[remainQty]-$totalReturn)>=0 ? ($prow[remainQty]-$row[remainQty]-$totalReturn) : 0;
	return number_format($remain,3);
}



function mat_receive_ep($d,$item,$p){
	global $db;
 $sql="SELECT SUM(receiveQty) as totalReceive
  From store$p where itemCode='$item' AND todat='$d' 
  AND paymentSL like 'ep_%'";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $totalReceive=$rr[totalReceive];
 return $totalReceive>0 ? $totalReceive : 0 ;
}
?>


<?
function qtyatHand($item,$pp,$ed){
	global $db;
/*
 $sql1="SELECT sum(currentQty) as total 
 from  `store$pp` 
 where  itemCode ='$item' AND  todat <='$ed' ";
//echo "$sql1<br>";
 $sqlQuery1=mysqli_query($db, $sql1);
 $remainQty1=mysqli_fetch_array($sqlQuery1);
 $remainQty= $remainQty1[total];
 return $remainQty;
 */
$sqlf = "SELECT SUM(receiveQty) as totalReceive  FROM `store$pp` WHERE itemCode='$item'";
//echo $sqlf.'<br>';
$sqlQ= mysqli_query($db, $sqlf);
if(mysqli_affected_rows($db)<=0)return false;
$sqlQf=mysqli_fetch_array($sqlQ);
$receiveQty=$sqlQf[totalReceive];

 $sqlf = "SELECT sum(issuedQty) as totalIssued FROM `issue$pp` where  itemCode='$item'";
//echo $sqlf.'<br>';
$sqlQ= mysqli_query($db, $sqlf);
$sqlQf=mysqli_fetch_array($sqlQ);
$issuedQty=$sqlQf[totalIssued];


 $sqlf = "SELECT sum(receiveQty) as totalReturn FROM `storet` where  itemCode='$item' AND returnFrom='$pp'";
//echo $sqlf.'<br>';
$sqlQ= mysqli_query($db, $sqlf);
$sqlQf=mysqli_fetch_array($sqlQ);
$totalReturn=$sqlQf[totalReturn];

$remainQty=$receiveQty-$issuedQty-$totalReturn;
//echo "## $receiveQty-$issuedQty##";
return $remainQty;
 
}
?>

<?
function qtyatHandTemp($item,$pp,$ed){
	global $db;
/*
 $sql1="SELECT sum(currentQty) as total 
 from  `store$pp` 
 where  itemCode ='$item' AND  todat <='$ed' ";
//echo "$sql1<br>";
 $sqlQuery1=mysqli_query($db, $sql1);
 $remainQty1=mysqli_fetch_array($sqlQuery1);
 $remainQty= $remainQty1[total];
 return $remainQty;
 */
$sqlf = "SELECT SUM(receiveQty) as totalReceive  FROM `store$pp` WHERE itemCode='$item'";
//echo $sqlf.'<br>';
$sqlQ= mysqli_query($db, $sqlf);
if(mysqli_affected_rows($db)<=0)return false;
$sqlQf=mysqli_fetch_array($sqlQ);
$receiveQty=$sqlQf[totalReceive];
// 	echo "<br>ReceiveQty: $receiveQty<br>";
if($pp!="004")
 $sqlf = "SELECT sum(issuedQtyTemp) as totalIssued FROM `issue$pp` where  itemCode='$item'";
// echo $sqlf.'<br>';

$sqlQ= mysqli_query($db, $sqlf);
$sqlQf=mysqli_fetch_array($sqlQ);
$issuedQty=$sqlQf[totalIssued];
// 	echo "<br>IssueQty: $issuedQty<br>";
	

	 $sqlf = "SELECT sum(issuedQty) as totalIssued FROM `issue$pp` where  itemCode='$item'";
	// echo $sqlf.'<br>';
	$sqlQ= mysqli_query($db, $sqlf);
	$sqlQf=mysqli_fetch_array($sqlQ);
	$issuedQty+=$sqlQf[totalIssued];
// 	echo "<br>totalIssued: $issuedQty<br>";



 $sqlf = "SELECT sum(receiveQty) as totalReturn FROM `storet` where  itemCode='$item' AND returnFrom='$pp'";
//echo $sqlf.'<br>';
$sqlQ= mysqli_query($db, $sqlf);
$sqlQf=mysqli_fetch_array($sqlQ);
$totalReturn=$sqlQf[totalReturn];
// 	echo "<br>totalReturn: $totalReturn<br>";

$remainQty=$receiveQty-$issuedQty-$totalReturn;
// echo "## $remainQty=$receiveQty-$issuedQty-$totalReturn##";
return $remainQty;
 
}
?>
<?
/*---------------------------
return total qty issued in a siow and iow of given item
---------------------------------*/

function qtyissued($item,$pp,$iow,$siow){
	global $db;
$issuedQty=0;;

 $sql1="SELECT sum(issuedQty) as total 
 from  `issue$pp` 
 where  itemCode ='$item' AND iowid=$iow AND siowid=$siow ";
//echo $sql1;
 $sqlQuery1=mysqli_query($db, $sql1);
 $remainQty1=mysqli_fetch_array($sqlQuery1);
  if($remainQty1[total]) 
  $issuedQty= $remainQty1[total];
   else $issuedQty=0;
 return $issuedQty;
}
?>

<?
/*---------------------------
return remain qty to use in a siow

---------------------------------*/

function siow_qtyRemain($item,$pp,$siow,$app){
	global $db;
$issuedQty=0;;
 $sql1="SELECT sum(issuedQty) as total 
 from  `issue$pp` 
 where  itemCode ='$item' AND siowid=$siow ";
//echo $sql1;
 $sqlQuery1=mysqli_query($db, $sql1);
if(mysqli_affected_rows($db)<=0)return false;
 $re1=mysqli_fetch_array($sqlQuery1);
 $issuedQty= $re1[total];

return $app-$issuedQty;
}?>
<?
/*---------------------------
return remain qty to use in a siow

---------------------------------*/

function siow_qtyRemainTemp($item,$pp,$siow,$app){
	global $db;
$issuedQty=0;;
 $sql1="SELECT (sum(issuedQtyTemp)+sum(issuedQty)) as total 
 from  `issue$pp` 
 where  itemCode ='$item' AND siowid=$siow ";
// echo $sql1;
 $sqlQuery1=mysqli_query($db, $sql1);
if(mysqli_affected_rows($db)<=0)return false;
 $re1=mysqli_fetch_array($sqlQuery1);
 $issuedQty= $re1[total];

return $app-$issuedQty;
}?>
<?
function matTotalRequired($project,$itemCode){
	global $db;
	$sql="select sum(dmaQty) dmaQty from dma where dmaProjectCode='$project' and dmaItemCode='$itemCode'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row["dmaQty"];
}

/*--------------------------------
return total stock qty between given date of an item
---------------------------------*/
function mat_stock($p,$item,$fromDate,$toDate){
	global $db;
//echo "**$p,$item,$fromDate,$toDate**";
if($p==''){
	$sqlf = "SELECT SUM(currentQty) as totalReceive  
	FROM `store` 
	WHERE sdate <= '$fromDate'
	 AND itemCode='$item'";
	//echo $sqlf.'<br>';
	$sqlQ= mysqli_query($db, $sqlf);
	$sqlQf=mysqli_fetch_array($sqlQ);
	$receiveQty=$sqlQf[totalReceive];
	return $receiveQty;
}else{
	$sqlf = "SELECT SUM(receiveQty) as totalReceive  
	FROM `store$p` 
	WHERE ";
	if($fromDate)$sqlf .="todat <= '$fromDate' AND ";
	$sqlf .="  itemCode='$item'";
// 	echo $sqlf.'<br>';
	$sqlQ= mysqli_query($db, $sqlf);
	$sqlQf=mysqli_fetch_array($sqlQ);
	$receiveQty=$sqlQf[totalReceive];

	$sqlf = "SELECT sum(issuedQty) as totalIssued FROM `issue$p` where  itemCode='$item'  ";
	if($fromDate)$sqlf .=" AND issueDate <= '$fromDate'";
// 	echo $sqlf.'<br>';
	$sqlQ= mysqli_query($db, $sqlf);
	$sqlQf=mysqli_fetch_array($sqlQ);
	$issuedQty=$sqlQf[totalIssued];
	 $sqlf = "SELECT sum(receiveQty) as totalReturn FROM `storet` where  itemCode='$item' AND returnFrom='$p'";
	if($fromDate)$sqlf .=" AND edate <= '$fromDate'";
// 	echo $sqlf.'<br>';
	$sqlQ= mysqli_query($db, $sqlf);
	$sqlQf=mysqli_fetch_array($sqlQ);
	$totalReturn=$sqlQf[totalReturn];
	$remainQty=round($receiveQty,4)-round($issuedQty,4)-round($totalReturn,4);
// 	echo "Qt=$item=$remainQty=$receiveQty-$issuedQty-$totalReturn;<br>";
	//echo "## $receiveQty-$issuedQty##";
	return $remainQty;
}
}


/*--------------------------------
return total stock qty between given date of an item
---------------------------------*/
function mat_stock_pending($p,$item,$fromDate,$toDate){
	global $db;
//echo "**$p,$item,$fromDate,$toDate**";
if($p==''){
	$sqlf = "SELECT SUM(receiveQtyTemp) as totalReceive  
	FROM `store` 
	WHERE sdate <= '$fromDate'
	 AND itemCode='$item'";
	//echo $sqlf.'<br>';
	$sqlQ= mysqli_query($db, $sqlf);
	$sqlQf=mysqli_fetch_array($sqlQ);
	$receiveQty=$sqlQf[totalReceive];
	return $receiveQty;
}else{
	$sqlf = "SELECT SUM(receiveQtyTemp) as totalReceive  
	FROM `store$p` 
	WHERE ";
	if($fromDate)$sqlf .="todat <= '$fromDate' AND ";
	$sqlf .="  itemCode='$item'";
// 	echo $sqlf.'<br>';
	$sqlQ= mysqli_query($db, $sqlf);
	$sqlQf=mysqli_fetch_array($sqlQ);
	$receiveQty=$sqlQf[totalReceive];

	$sqlf = "SELECT sum(issuedQtyTemp) as totalIssued FROM `issue$p` where  itemCode='$item'  ";
	if($fromDate)$sqlf .=" AND issueDate <= '$fromDate'";
// 	echo $sqlf.'<br>';
	$sqlQ= mysqli_query($db, $sqlf);
	$sqlQf=mysqli_fetch_array($sqlQ);
	$issuedQty=$sqlQf[totalIssued];
  

	$remainQty=array("store"=>round($receiveQty,4),"issue"=>round($issuedQty,4));
// 	echo "Qt=$item=$remainQty=$receiveQty-$issuedQty-$totalReturn;<br>";
	//echo "## $receiveQty-$issuedQty##";
	return $remainQty;
}
}
?>

<?
/*--------------------------------
return total stock value between given date of an item
---------------------------------*/
function mat_stock_rate($p,$item,$toDate){
global $db;
//echo "ppppppp=$p ++<br>";
if($p==''){
$sqlf = "SELECT SUM(currentQty*rate) as totalReceive  
FROM `store` 
WHERE sdate <= '$toDate'  AND itemCode='$item'";
//echo $sqlf.'<br>';
$sqlQ= mysqli_query($db, $sqlf);
$sqlQf=mysqli_fetch_array($sqlQ);
$receiveQty=$sqlQf[totalReceive];
return $receiveQty;
}
else{
$sqlf = "SELECT SUM(receiveQty*rate) as totalReceive  
FROM `store$p` 
WHERE todat <= '$toDate'  AND itemCode='$item'";
// echo $sqlf.'*******<br>';
$sqlQ= mysqli_query($db, $sqlf);
$sqlQf=mysqli_fetch_array($sqlQ);
$receiveQty=$sqlQf[totalReceive];

 $sqlf = "SELECT sum(issuedQty*issueRate) as totalIssued 
 FROM `issue$p` 
 where  itemCode='$item' AND issueDate <= '$toDate'";
// echo $sqlf.'###<br>';
$sqlQ= mysqli_query($db, $sqlf);
$sqlQf=mysqli_fetch_array($sqlQ);
$issuedQty=$sqlQf[totalIssued];
//echo "**$receiveQty-$issuedQty**";
 $sqlf = "SELECT sum(receiveQty*rate) as totalReturn 
 FROM `storet` where  itemCode='$item' AND returnFrom='$p' AND edate<='$toDate'";
// echo $sqlf.'<br>';
$sqlQ= mysqli_query($db, $sqlf);
$sqlQf=mysqli_fetch_array($sqlQ);
$totalReturn=$sqlQf[totalReturn];

$remainQty=$receiveQty-$issuedQty-$totalReturn;
// echo "RA=$item=$remainQty=$receiveQty-$issuedQty-$totalReturn;<br>";
//echo "$remainQty++";
return $remainQty;
}
}
?>
<?
/*--------------------------------

return total stock value between given date
---------------------------------*/
function store_stock_rate($fromDate,$toDate,$p){
	global $db;

$sqlf = "SELECT SUM(receiveQty*rate) as totalReceive  
FROM `store$p` 
WHERE todat between '$fromDate' AND '$toDate' ";
//echo $sqlf.'*******<br>';
$sqlQ= mysqli_query($db, $sqlf);
$sqlQf=mysqli_fetch_array($sqlQ);
$receiveQty=$sqlQf[totalReceive];

 $sqlf = "SELECT sum(issuedQty*issueRate) as totalIssued 
 FROM `issue$p` 
 where  issueDate between '$fromDate' AND '$toDate' ";
//echo $sqlf.'###<br>';
$sqlQ= mysqli_query($db, $sqlf);
$sqlQf=mysqli_fetch_array($sqlQ);
$issuedQty=$sqlQf[totalIssued];
//echo "**$receiveQty-$issuedQty**";
	$sql3="SELECT SUM(receiveQty*rate) as subbalance3 
	from storet 
	WHERE returnFrom='$p' 
	AND edate between '$fromDate' AND '$toDate' ";
//echo $sql3.'<br>';
	$sqlQ3=mysqli_query($db, $sql3);
	$re3=mysqli_fetch_array($sqlQ3);
	$transferQty=$re3[subbalance3];

//echo "** $receiveQty * $issuedQty * $transferQty ** ";
$remainQty=$receiveQty-($issuedQty+$transferQty);
//echo "$remainQty++";
return $remainQty;

}
?>
<?
/*--------------------------------
return total stock value of item between given date
---------------------------------*/
function mat_itemstockAmount($p,$item,$toDate,$fromDate){
	global $db;
$sqlf = "SELECT SUM(receiveQty*rate) as totalReceive  
FROM `store$p` 
WHERE todat between '$fromDate' AND '$toDate' AND itemCode='$item'";
//echo $sqlf.'<br>';
$sqlQ= mysqli_query($db, $sqlf);
$sqlQf=mysqli_fetch_array($sqlQ);
$receiveQty=$sqlQf[totalReceive];

 $sqlf = "SELECT sum(issuedQty*issueRate) as totalIssued 
 FROM `issue$p` 
 where  itemCode='$item' AND issueDate between '$fromDate' AND '$toDate'";
//echo $sqlf.'<br>';
$sqlQ= mysqli_query($db, $sqlf);
$sqlQf=mysqli_fetch_array($sqlQ);
$issuedQty=$sqlQf[totalIssued];

$remainQty=$receiveQty-$issuedQty;
return $remainQty;
}
?>
<?
/*--------------------------------
return total stock qty of item between given date
---------------------------------*/
function mat_itemstockQty($p,$item,$toDate,$fromDate){
	global $db;
$sqlf = "SELECT SUM(receiveQty) as totalReceive  
FROM `store$p` 
WHERE todat between '$fromDate' AND '$toDate' AND itemCode='$item'";
//echo $sqlf.'<br>';
$sqlQ= mysqli_query($db, $sqlf);
$sqlQf=mysqli_fetch_array($sqlQ);
$receiveQty=$sqlQf[totalReceive];

 $sqlf = "SELECT sum(issuedQty) as totalIssued 
 FROM `issue$p`  
 where  itemCode='$item' AND issueDate between '$fromDate' AND '$toDate'";
//echo $sqlf.'<br>';
$sqlQ= mysqli_query($db, $sqlf);
$sqlQf=mysqli_fetch_array($sqlQ);
$issuedQty=$sqlQf[totalIssued];

$remainQty=$receiveQty-$issuedQty;
return $remainQty;
}
?>

<?
/*--------------------------------
return max value of a item in center store
---------------------------------*/
function centrelStoreItemRate($item){
	global $db;
$sqlf = "SELECT MAX(rate) as itemRate  
FROM `store` 
WHERE itemCode='$item' AND currentQty > 0";
//echo $sqlf.'<br>';
$sqlQ= mysqli_query($db, $sqlf);
$sqlQf=mysqli_fetch_array($sqlQ);
$itemRate=$sqlQf[itemRate];
return $itemRate;
}
?>

<?
/*--------------------------------
return max value of a item in center store
---------------------------------*/
function centrelStoreItemRate_EQ($item){
	global $db;
$sqlf = "SELECT avg(rate) as itemRate  
FROM `store` 
WHERE itemCode='$item' AND currentQty > 0";
//echo $sqlf.'<br>';
$sqlQ= mysqli_query($db, $sqlf);
$sqlQf=mysqli_fetch_array($sqlQ);
$itemRate=$sqlQf[itemRate];
return $itemRate;
}
?>
<?
/* return per day material requirement in a siow*/

function mat_perdayRequired($siow,$itemCode,$dat,$pp){
	global $db;
 $siowDaysGan=siowDaysGan($siow,$dat);

 if($siowDaysGan==0){ 
 $approvedQty=approvedQty($siow,$itemCode);
 $siowDuration=siowDuration($siow);
 $issuedQty=issuedQty1($siow,$itemCode,$pp);
 $remainQty= $approvedQty-$issuedQty; 
 $siowPerDayReq=siowdmaPerDay($siowDuration,$remainQty);
  return  $siowPerDayReq;
 }
 else if($siowDaysGan>0){
    $siowDaysRem=siowDaysRem($siow,$dat); 
	if($siowDaysRem>0){
		$approvedQty=approvedQty($siow,$itemCode);
		$issuedQty=issuedQty1($siow,$itemCode,$pp);
		$remainQty= $approvedQty-$issuedQty; 
		$siowPerDayReq=siowdmaPerDay($siowDaysRem,$remainQty);
        return  $siowPerDayReq;
		}//remain
	else {
		$approvedQty=approvedQty($siow,$itemCode);
		$issuedQty=issuedQty1($siow,$itemCode,$pp);
		$remainQty= $approvedQty-$issuedQty; 	
		$siowPerDayReq=$remainQty;
        return  $siowPerDayReq;
	}		
 } 
}

?>

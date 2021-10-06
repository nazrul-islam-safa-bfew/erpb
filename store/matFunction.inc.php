<?
/*---------------------------
input: itemCode Code
output: total quotation Found
---------------------------------*/

function qtyatHand($item,$pp,$ed){
 include("config.inc.php");
 //include("session.inc.php"); 
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);


 $sql1="SELECT sum(currentQty) as total from  `store$pp` where  itemCode ='$item' AND  todat <='$ed' ";
//echo "$sql1<br>";
 $sqlQuery1=mysql_query($sql1);
 $remainQty1=mysql_fetch_array($sqlQuery1);
 $remainQty= $remainQty1[total];

 return $remainQty;
}
?>

<?
/*---------------------------
input: itemCode Code
output: total quotation issued Qty.
---------------------------------*/

function qtyissued($item,$pp,$iow,$siow){
$issuedQty=0;;
 include("config.inc.php");
 //include("session.inc.php"); 
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);


 $sql1="SELECT sum(issuedQty) as total from  `issue$pp` where  itemCode ='$item' AND iowid=$iow AND siowid=$siow ";
//echo $sql1;
 $sqlQuery1=mysql_query($sql1);
 $remainQty1=mysql_fetch_array($sqlQuery1);
  if($remainQty1[total]) 
 $issuedQty= $remainQty1[total];

 return $issuedQty;
}
?>

<?
/*---------------------------
input: itemCode Code
output: total quotation issued Qty.
---------------------------------*/

function siow_qtyRemain($item,$pp,$siow,$app){
$issuedQty=0;;
 include("config.inc.php");
 //include("session.inc.php"); 
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
 
 $sql1="SELECT sum(issuedQty) as total from  `issue$pp` where  itemCode ='$item' AND siowid=$siow ";
//echo $sql1;
 $sqlQuery1=mysql_query($sql1);
 $re1=mysql_fetch_array($sqlQuery1);
 $issuedQty= $re1[total];

return $app-$issuedQty;

}
?>


<?
/*--------------------------------
---------------------------------*/
function mat_stock($p,$item,$fromDate,$toDate){
//echo "**$p,$item,$fromDate,$toDate**";
if($p==''){
$sqlf = "SELECT SUM(currentQty) as totalReceive  
FROM `store` 
WHERE sdate < '$fromDate'  AND itemCode='$item'";
//echo $sqlf.'<br>';
$sqlQ= mysql_query($sqlf);
$sqlQf=mysql_fetch_array($sqlQ);
$receiveQty=$sqlQf[totalReceive];
return $receiveQty;
}
else{
$sqlf = "SELECT SUM(receiveQty) as totalReceive  
FROM `store$p` 
WHERE todat <= '$fromDate'  AND itemCode='$item'";
//echo $sqlf.'<br>';
$sqlQ= mysql_query($sqlf);
$sqlQf=mysql_fetch_array($sqlQ);
$receiveQty=$sqlQf[totalReceive];

 $sqlf = "SELECT sum(issuedQty) as totalIssued FROM `issue$p` where  itemCode='$item' AND issueDate <= '$fromDate'";
//echo $sqlf.'<br>';
$sqlQ= mysql_query($sqlf);
$sqlQf=mysql_fetch_array($sqlQ);
$issuedQty=$sqlQf[totalIssued];

$remainQty=$receiveQty-$issuedQty;
//echo "## $receiveQty-$issuedQty##";
return $remainQty;
}
}
?>

<?
/*--------------------------------
---------------------------------*/
function mat_stock_rate($p,$item,$toDate){
//echo "ppppppp=$p ++<br>";
if($p==''){
$sqlf = "SELECT SUM(currentQty*rate) as totalReceive  FROM `store` WHERE sdate <= '$toDate'  AND itemCode='$item'";
//echo $sqlf.'<br>';
$sqlQ= mysql_query($sqlf);
$sqlQf=mysql_fetch_array($sqlQ);
$receiveQty=$sqlQf[totalReceive];
return $receiveQty;
}
else{
$sqlf = "SELECT SUM(receiveQty*rate) as totalReceive  FROM `store$p` WHERE todat <= '$toDate'  AND itemCode='$item'";
//echo $sqlf.'*******<br>';
$sqlQ= mysql_query($sqlf);
$sqlQf=mysql_fetch_array($sqlQ);
$receiveQty=$sqlQf[totalReceive];

 $sqlf = "SELECT sum(issuedQty*issueRate) as totalIssued FROM `issue$p` where  itemCode='$item' AND issueDate <= '$toDate'";
//echo $sqlf.'###<br>';
$sqlQ= mysql_query($sqlf);
$sqlQf=mysql_fetch_array($sqlQ);
$issuedQty=$sqlQf[totalIssued];
//echo "**$receiveQty-$issuedQty**";

$remainQty=$receiveQty-$issuedQty;
//echo "$remainQty++";
return $remainQty;
}
}
?>
<?
/*--------------------------------
---------------------------------*/
function mat_itemstockAmount($p,$item,$toDate,$fromDate){
$sqlf = "SELECT SUM(receiveQty*rate) as totalReceive  FROM `store$p`
 WHERE todat between '$fromDate' AND '$toDate' AND itemCode='$item'";
//echo $sqlf.'<br>';
$sqlQ= mysql_query($sqlf);
$sqlQf=mysql_fetch_array($sqlQ);
$receiveQty=$sqlQf[totalReceive];

 $sqlf = "SELECT sum(issuedQty*issueRate) as totalIssued FROM `issue$p`
  where  itemCode='$item' AND issueDate between '$fromDate' AND '$toDate'";
//echo $sqlf.'<br>';
$sqlQ= mysql_query($sqlf);
$sqlQf=mysql_fetch_array($sqlQ);
$issuedQty=$sqlQf[totalIssued];

$remainQty=$receiveQty-$issuedQty;
return $remainQty;
}
?>
<?
/*--------------------------------
---------------------------------*/
function mat_itemstockQty($p,$item,$toDate,$fromDate){
$sqlf = "SELECT SUM(receiveQty) as totalReceive  FROM `store$p`
 WHERE todat between '$fromDate' AND '$toDate' AND itemCode='$item'";
//echo $sqlf.'<br>';
$sqlQ= mysql_query($sqlf);
$sqlQf=mysql_fetch_array($sqlQ);
$receiveQty=$sqlQf[totalReceive];

 $sqlf = "SELECT sum(issuedQty) as totalIssued FROM `issue$p`
  where  itemCode='$item' AND issueDate between '$fromDate' AND '$toDate'";
//echo $sqlf.'<br>';
$sqlQ= mysql_query($sqlf);
$sqlQf=mysql_fetch_array($sqlQ);
$issuedQty=$sqlQf[totalIssued];

$remainQty=$receiveQty-$issuedQty;
return $remainQty;
}
?>

<?
/*--------------------------------
---------------------------------*/
function centrelStoreItemRate($item){
$sqlf = "SELECT MAX(rate) as itemRate  FROM `store` WHERE itemCode='$item' AND currentQty > 0";
//echo $sqlf.'<br>';
$sqlQ= mysql_query($sqlf);
$sqlQf=mysql_fetch_array($sqlQ);
$itemRate=$sqlQf[itemRate];
return $itemRate;
}
?>
<?
function mat_perdayRequired($siow,$itemCode,$dat,$pp){
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

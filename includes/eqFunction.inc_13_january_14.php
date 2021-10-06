<? 
/* return equipment total group value*/
function groupValue($d){
 $sql="SELECT SUM(price) as total FROM `equipment` WHERE itemCode = '$d'";
//echo $sql;
 $sqlQuery=mysql_query($sql);
 $rr=mysql_fetch_array($sqlQuery);
 $totalRate = $rr[total];
 return $totalRate;
 }
?>

<? 
/* total equipment value*/ 
function allEquipmetValue(){
 $sql="SELECT SUM(price) as total FROM `equipment` ";
//echo $sql;
 $sqlQuery=mysql_query($sql);
 $rr=mysql_fetch_array($sqlQuery);
 $totalRate = $rr[total];
 return $totalRate;
 }
?>

<? 
/* return total utilization of given equipment*/
function eqTodayWork($asId,$itemCode,$dat){
 $sql="SELECT SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime))) as duration FROM `equt` WHERE assetId LIKE '$asId' AND itemCode='$itemCode' AND iow<>'' AND edate='$dat' GROUP by edate";
//echo $sql;
 $sqlQuery=mysql_query($sql);
 $rr=mysql_fetch_array($sqlQuery);
 $totalRate = $rr[duration];
 return abs($totalRate);
 }
?>
<? 
function eqTodayWorksiow($itemCode,$dat,$siow){

 include("config.inc.php");
 $db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

 $sql="SELECT SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime))+60) as duration FROM `equt` WHERE itemCode = '$itemCode' AND siow='$siow' AND edate='$dat' GROUP by edate";
//echo $sql;
 $sqlQuery=mysql_query($sql);
 $rr=mysql_fetch_array($sqlQuery);
 $duration = $rr[duration];
 return abs($duration);
 }
?>

<? 
function eqBreakBown($asId,$itemCode,$dat){

 include("config.inc.php");
 $db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

 $sql="SELECT SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime))) as duration FROM `equt` WHERE eqId LIKE '$asId' AND itemCode = '$itemCode'AND iow='' AND edate='$dat' GROUP by edate";
//echo $sql;
 $sqlQuery=mysql_query($sql);
 $rr=mysql_fetch_array($sqlQuery);
 $totalRate = $rr[duration];
 return abs($totalRate);
 }
?>

<? 
function eqTotalWorkhr($asId,$itemCode,$dat){

 include("config.inc.php");
 $db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

 $sql="SELECT * FROM `eqproject` WHERE assetId ='$asId' AND itemCode='$itemCode' AND status='1' ORDER by id";
//echo $sql;
 $sqlQuery=mysql_query($sql);
 $rr=mysql_fetch_array($sqlQuery);
 $sdate = $rr[sdate];

 include("config.inc.php");
 $db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

 $sql="SELECT SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime))) as duration FROM `equt` WHERE assetId ='$asId' AND itemCode ='$itemCode' AND iow<>'' AND edate BETWEEN '$sdate' AND '$dat'";
//echo $sql;
 $sqlQuery=mysql_query($sql);
 $rr=mysql_fetch_array($sqlQuery);
 $totalRate = $rr[duration];
 return abs($totalRate);

 }
?>
<? 
function empTotalWorkhrsiow($itemCode,$dat,$siow){

 include("config.inc.php");
 $db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

 $sql="SELECT SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime))+60) as duration FROM `emput`".
	 " WHERE designation ='$itemCode' AND siow='$siow' ";
//echo $sql;
 $sqlQuery=mysql_query($sql);
 $rr=mysql_fetch_array($sqlQuery);
 $totalRate = $rr[duration];
 return abs($totalRate);

 }
?>



<? 
function eqTotalBreakhr($asId,$itemCode,$dat){

 include("config.inc.php");
 $db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

 $sql="SELECT * FROM `eqproject` WHERE assetId LIKE '$asId' AND status='1' ORDER by id";
//echo $sql;
 $sqlQuery=mysql_query($sql);
 $rr=mysql_fetch_array($sqlQuery);
 $sdate = $rr[sdate];

 include("config.inc.php");
 $db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

 $sql="SELECT SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime))) as duration FROM `equt` WHERE assetId = '$asId' AND itemCode ='$itemCode' AND iow='' AND edate BETWEEN '$sdate' AND '$dat'";
//echo $sql;
 $sqlQuery=mysql_query($sql);
 $rr=mysql_fetch_array($sqlQuery);
 $totalRate = abs($rr[duration]);
 return abs($totalRate);

 }
?>

<? 
function eqDuration($asId,$itemCode,$dat){

 include("config.inc.php");
 $db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

 $sql="SELECT (to_days('$dat')-to_days(sdate)) as totalDays FROM `eqproject` WHERE assetId='$asId' AND itemCode='$itemCode' AND status='1' ";
//echo $sql;
 $sqlQuery=mysql_query($sql);
 $rr=mysql_fetch_array($sqlQuery);

 $estimatedHr=($rr[totalDays]+1)*8*3600;
 return $estimatedHr;
 }
?>



<? 
function eq_perdayPl_req($project,$itemCode,$edat1){
$sqls = "SELECT * from `dma` WHERE dmaProjectCode='$project' AND dmaItemCode ='$itemCode' ORDER by dmasiow ASC ";
//echo $sqls;
$sql1=mysql_query($sqls); 
while($dmar=mysql_fetch_array($sql1)){
$siowDuration=siowDuration($dmar[dmasiow]);

$siowDaysRem=siowDaysRem($dmar[dmasiow],$edat1);
$siowDaysGan=siowDaysGan($dmar[dmasiow],$edat1);

if($siowDaysGan)
{ 
 if($siowDaysRem){
  $siowdmaPerDay =siowdmaPerDay($siowDuration,$dmar[dmaQty])*$siowDaysGan;
  $eqTotalWorkhrsiow= (eqTotalWorkhrsiow($itemCode,$edat1,$dmar[dmasiow])/3600);
  $remainQty=$siowdmaPerDay-$eqTotalWorkhrsiow;
  $perdayRemainQty= $remainQty/$siowDaysRem;
  }
  else {
  $siowdmaPerDay =$dmar[dmaQty];      
  $eqTotalWorkhrsiow= (eqTotalWorkhrsiow($itemCode,$edat1,$dmar[dmasiow])/3600);
  $remainQty=$siowdmaPerDay-$eqTotalWorkhrsiow;
  $perdayRemainQty=$remainQty;
  }
  $perDayAmount=($perdayRemainQty)*($dmar[dmaRate]);  
}
else {$perDayAmount =0;$perdayRemainQty=0;}
$perDayQtyTotal = $perDayQtyTotal+$perdayRemainQty;
$siowdmaPerDayTotal=$siowdmaPerDayTotal+$perDayAmount;
//echo "**$dmar[dmasiow]=$eqTotalWorkhrsiow=$perdayRemainQty**<br>";
$perdayRemainQty=0;
$perDayAmount=0;
$eqTotalWorkhrsiow=0;
 }//while

return $perDayQtyTotal;
}
?>
<? //total work in iow 
function eq_act_total_qty($project,$itemCode,$dat,$t){

$sql="SELECT SUM(60+ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime))) as duration FROM `equt` 
WHERE itemCode ='$itemCode' AND pcode='$project' AND iow <> '0' ";
if($t==1) $sql.=" AND edate = '$dat'";
if($t==2) $sql.=" AND edate <= '$dat'";
//echo $sql.'<br>';
 $sqlQuery=mysql_query($sql);
 $rr=mysql_fetch_array($sqlQuery);
 $totalQty = $rr[duration];
 return abs($totalQty);

}

?>
<? 
function eq_toDaypresent_total($project,$itemCode,$edate){
 include("config.inc.php");
 $db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

$sql="select (SUM(60+ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)))) as duration
	from eqattendance
	WHERE location='$project' AND itemCode= '$itemCode' AND edate='$edate' ";
//echo '<br>'.$sql.'<br>';
 $sqlQuery=mysql_query($sql);
 $rr=mysql_fetch_array($sqlQuery);
 return $rr[duration];
}
?>

<? 
function eqTotalWorkhrsiow($itemCode,$dat,$siow){
 include("config.inc.php");
 $db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

 $sql="SELECT SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime))+60) as duration FROM `equt` WHERE".
 " itemCode ='$itemCode' AND siow='$siow' AND edate <= '$dat'";
//echo $sql.'<br>';
 $sqlQuery=mysql_query($sql);
 $rr=mysql_fetch_array($sqlQuery);
 $totalRate = $rr[duration];
 return abs($totalRate);

 }
?>
<? 
function eqTotalWorkhriow($itemCode,$dat,$iow){
 include("config.inc.php");
 $db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

 $sql="SELECT SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime))+60) as duration FROM `equt` WHERE".
 " itemCode ='$itemCode' AND iow='$iow' AND edate <= '$dat'";
//echo $sql.'<br>';
 $sqlQuery=mysql_query($sql);
 $rr=mysql_fetch_array($sqlQuery);
 $totalRate = $rr[duration];
 return abs($totalRate);

 }
?>
<? 
function eqP_qtyDes($sitemCode,$vid){
$sql="SELECT quotation.*,eqquotation.* FROM quotation,eqquotation
 where quotation.itemCode='$sitemCode' AND quotation.qid=eqquotation.qid AND quotation.vid=$vid";
//echo "$sql<br>";
$sqlq=mysql_query($sql);
$re=mysql_fetch_array($sqlq);

 $temp=explode('_',$re[teqSpec]);
$model=$temp[0];
$brand=$temp[1];
$manuby=$temp[2];
$madein=$temp[3];
$speci=$temp[4];
$designCap=$temp[5];
$currentCap=$temp[6];
$yearManu=$temp[7];
$t=vendorName($re[vid]);

echo 'Model <font class=out>'.$model.'</font>;<br> ';
echo 'Brand <font class=out>'.$brand.'</font>; <br>';
echo 'Manufactured by <font class=out>'.$manuby.'</font>;<br> ';
echo 'Made in <font class=out>'.$madein.'</font>; <br>';
//echo 'Specification <font class=out>' .$specin.'</font>; <br>';
echo 'Design Capacity <font class=out>'.$designCap.'</font>; <br>'; 
echo 'Current Capacity <font class=out>'.$currentCap.'</font>; <br>';
echo 'Year of Manufacture  <font class=out>'.$yearManu.'</font>; <br>'; 
echo 'Life  <font class=out>'.$re[life].' year(s)</font>; <br>'; 	
echo 'Condition  <font class=out>'.eqCondition($re[condition]).'</font>; <br>'; 		
 
}

?>

<? function eqPlanReceiveAmount($sDate,$inDate,$rate,$qty){
//echo strtotime($inDate).'-'.strtotime($sDate).'<br>';

$duration=1+((strtotime($inDate)-strtotime($sDate))/86400);
//echo "$sDate,$inDate,$rate,$qty<br>";
$totalAmount=$duration*8*$rate*$qty;
//echo "$sDate,$inDate=$duration*8*$rate*$qty<br>";
return $totalAmount;
}?>

<?
/*
 function eqpoActualReceiveAmount($posl){
$p=explode('_',$posl);
$pcode=$p[1];

	$sql="select eqId,itemCode,posl,
	(SUM(60+ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)))) as duration
	from eqattendance
	WHERE posl='$posl' AND
	location ='$pcode' GROUP by itemCode,posl  ";
	echo "$sql<br>";
$sqlq=mysql_query($sql);
while($r=mysql_fetch_array($sqlq)){
	$sql2="select (SUM(60+ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)))) as duration
	from equt
	WHERE  posl='$r[posl]' AND itemCode='$r[itemCode]' AND 
	pcode ='$pcode' GROUP by itemCode,posl  ";
	//echo "$sql2<br>";
	$sqlq2=mysql_query($sql2);
	$re=mysql_fetch_array($sqlq2);
	$actualPresent=($r[duration]-$re[duration]);
	$rate=eqpoRate($r[itemCode],$r[posl]);
	$amount+=$actualPresent*$rate;
	//echo "actualPresent=$actualPresent<br>";

}
	return $amount;
}
*/

 function eqpoActualReceiveAmount($posl){
$p=explode('_',$posl);
$pcode=$p[1];

	$sql="select COUNT(*) As totalPresent,itemCode,posl from eqattendance
	WHERE posl='$posl' AND	location ='$pcode' GROUP by itemCode ";
	//echo "$sql<br>";
$sqlq=mysql_query($sql);
while($r=mysql_fetch_array($sqlq)){

	$rate=eqpoRate($r[itemCode],$r[posl]);
	$amount+=$r[totalPresent]*$rate;
	//echo "<br>$r[itemCode]==$r[totalPresent]*$rate<br>";

}
	return $amount;
}
?>
<? 
function eqpoActualReceiveAmount_date($posl,$fromdate,$todate){

	$sql="select COUNT(*) As totalPresent,itemCode,posl from eqattendance
	WHERE posl='$posl' AND edate >'$fromdate' AND edate <='$todate' GROUP by itemCode ";
//echo "$sql<br>";
$sqlq=mysql_query($sql);
while($r=mysql_fetch_array($sqlq)){

	$rate=eqpoRate($r[itemCode],$r[posl]);
	$amount+=$r[totalPresent]*$rate;
	//echo "$r[totalPresent]*$rate<br>";

}
	return $amount;
}
?>

<? function eqActualReceiveAmount($sDate,$inDate,$rate,$posl,$itemCode,$project){
$pcode=$project;
$from=$sDate;
$to=$inDate;

	$sql="select itemCode,posl,
	(SUM(60+ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)))) as duration
	from eqattendance
	WHERE posl='$posl' AND edate between '$from' and '$to' AND itemCode='$itemCode' AND 
	location ='$pcode' GROUP by itemCode,posl  ";
$sqlq=mysql_query($sql);
while($r=mysql_fetch_array($sqlq)){
	$sql2="select (SUM(60+ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)))) as duration
	from equt
	WHERE edate between '$from' and '$to' 
	AND posl='$r[posl]' AND itemCode='$r[itemCode]' 
	AND pcode ='$pcode' GROUP by itemCode,posl  ";
	//echo "$sql2<br>";
	$sqlq2=mysql_query($sql2);
	$re=mysql_fetch_array($sqlq2);
	$actualPresent=($r[duration]-$re[duration]);
	$rate=eqpoRate($r[itemCode],$r[posl]);
	$amount+=$actualPresent*$rate;
	//echo "actualPresent=$actualPresent<br>";

}
	return $amount;
}?>

<?
function eq_autoAttendance($todat,$keyDate){

$duration= (strtotime($todat)-strtotime($keyDate))/86400;

$sql="SELECT * FROM eqproject where status='1'";
$sqlq=mysql_query($sql);
while($re=mysql_fetch_array($sqlq)){

for($i=0;$i<=$duration;$i++){	 
$edat=date("Y-m-d",strtotime($keyDate)+(86400*$i));
$eq_planReceiveDate=eq_planReceiveDate($re[posl],$re[itemCode]);

if(strtotime($edat)>=strtotime($eq_planReceiveDate)){	

$sql4="select action from eqattendance where eqId='$re[assetId]' AND itemCode='$re[itemCode]' and posl='$re[posl]' order by edate DESC";
$sqlq4=mysql_query($sql4);
$ro4=mysql_affected_rows();	
if($ro4>0){$r4=mysql_fetch_array($sqlq4);$action=$r4[action];} else $action='P';

 $sql="INSERT INTO eqattendance(`id` , `eqId`,itemCode, `edate` ,`action` , `stime` , `etime` , `todat` , `location`,posl )
 VALUES ('', '$re[assetId]','$re[itemCode]', '$edat', '$action', '09:00:00','17:59:00','$todat','$re[pCode]','$re[posl]' )";

//echo $sql.'<br>';
	$sqlq1=mysql_query($sql);
$ro=mysql_affected_rows();	
if($ro=='1')
 {	
	$sql2 = "INSERT INTO `equt` ( `id` , `eqId` ,`itemCode`, `iow` , `siow` ,
	 `stime` , `etime` , `details` , `edate`,pcode,posl ) 
	 VALUES ('', '$re[assetId]','$re[itemCode]', '', '', 
	'13:00', '13:59', 'Lunch', '$edat','$re[pCode]','$re[posl]')";
	//echo $sql2.'<br>';
	$sqlq2=mysql_query($sql2);
	}//if ro
    }//if
   }//for
 }//while

}

?>

<?
function eq_perdayRequired($siow,$itemCode,$dat,$pp){
 $siowDaysGan=siowDaysGan($siow,$dat);

 if($siowDaysGan==0){ 
 $approvedQty=approvedQty($siow,$itemCode);
 $siowDuration=siowDuration($siow);
 $issuedQty=issuedQty1($siow,$itemCode,$pp);
 
 $issuedQty = eqTotalWorkhrsiow($itemCode,$dat,$siow)/3600;
 
 $remainQty= $approvedQty-$issuedQty; 
 $siowPerDayReq=siowdmaPerDay($siowDuration,$remainQty);
  return  $siowPerDayReq;
 }
 else if($siowDaysGan>0){
    $siowDaysRem=siowDaysRem($siow,$dat); 
	if($siowDaysRem>0){
		$approvedQty=approvedQty($siow,$itemCode);
		$issuedQty = eqTotalWorkhrsiow($itemCode,$dat,$siow)/3600;
		$remainQty= $approvedQty-$issuedQty; 
		$siowPerDayReq=siowdmaPerDay($siowDaysRem,$remainQty);
        return  $siowPerDayReq;
		}//remain
	else {
		$approvedQty=approvedQty($siow,$itemCode);
        $issuedQty = eqTotalWorkhrsiow($itemCode,$dat,$siow)/3600;
		$remainQty= $approvedQty-$issuedQty; 	
		$siowPerDayReq=$remainQty;
        return  $siowPerDayReq;
	}	
	
 }
/* $approvedQty=approvedQty($siow,$itemCode);
 $siowDaysRem=siowDaysRem($siow,$d);
 $siowDaysGan=siowDaysGan($siow,$d);
 $siowDuration=siowDuration($siow);
 $siowdmaPerDay=siowdmaPerDay($duration,$qty);
 $issuedQty1=issuedQty1($siow,$item,$pp);
 */
 
}

?>
<? 
function eq_force_dispatch($todat){

$sql="SELECT * FROM eqproject where status=1";
//echo "<br> $sql<br>";
$sqlq=mysql_query($sql);
putenv ('TZ=Asia/Dacca'); 
while($eq=mysql_fetch_array($sqlq)){
	$planDispatchDate=planDispatchDate($eq[posl],$eq[itemCode]);
    if(strtotime($todat)>=strtotime($planDispatchDate))
		{
		$sqlp = "UPDATE `eqproject` set edate='$planDispatchDate',status='2' WHERE id='$eq[id]'";
		//echo $planDispatchDate.'=='.$sqlp.'<br>';
		mysql_query($sqlp);
		}
		
	  }//while
}

?>
<?
function eq_planReceiveDate($posl,$itemCode){
$sql="select dstart from porder where posl='$posl' and itemCode='$itemCode' ";
//echo $sql.'<br>';
$sqlq=mysql_query($sql);
$sqlr=mysql_fetch_array($sqlq);
return $sqlr[dstart];
}
?>

<?
function planDispatchDate($posl,$itemCode){
$sql="select sdate from poschedule where posl='$posl' and itemCode='$itemCode'";
//echo $sql.'<br>';
$sqlq=mysql_query($sql);
$sqlr=mysql_fetch_array($sqlq);
return $sqlr[sdate];
}
?>

<? /* total worked in SIOW human */
function eqExTime($eqId,$itemCode,$eqType,$edate){

 include("config.inc.php");
 $db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

$sql="SELECT HOUR(stime) as eh,MINUTE(stime) as em,HOUR(etime) as xh,MINUTE(etime) as xm FROM `eqattendance`".
 " WHERE eqId= '$eqId' AND itemCode= '$itemCode' AND edate='$edate'";

//echo $sql;
 $sqlQuery=mysql_query($sql);
 $rr=mysql_fetch_array($sqlQuery);
if($rr[eh]<10) $rr[eh]="0$rr[eh]";
if($rr[em]<10) $rr[em]="0$rr[em]";
$eqTime= array("eh"=>$rr[eh],"em"=>$rr[em],'xh'=>$rr[xh],'xm'=>$rr[xm]);
	 return $eqTime; 
 }
?>

<?
function eqTotalPresentHr($fromd,$tod,$eqId,$itemCode,$type,$project){
$sql="SELECT count(*) as totalPresent from eqattendance WHERE
 eqId='$eqId' AND itemCode='$itemCode' AND location='$project'";
//echo $sql;
$sqlq=mysql_query($sql);
$sqlf=mysql_fetch_array($sqlq);
return $sqlf[totalPresent];
}
?>


<?
/* ---------------------------
  Input the eqCode Code
 return the equipment Id
-------------------------------*/

function eqpId($eqpId,$itemCode)
{
$tempf=explode('-',$itemCode);

if($eqpId<10) return "$tempf[0]-$tempf[1]-00$eqpId";
else if($eqpId<100) return "$tempf[0]-$tempf[1]-0$eqpId";
/*else if($eqpId<1000) return "$tempf[0]-$tempf[1]-00$eqpId";
else if($eqpId<10000) return "$tempf[0]-$tempf[1]-0$eqpId";
*/
else return "$tempf[0]-$tempf[1]-$eqpId";

}
 ?>

<?
/* ---------------------------
  Input the eqCode Code
 return the equipment Id
-------------------------------*/

function eqpId_local($eqpId,$itemCode)
{
$tempf1=explode('-',$itemCode);
 return "$tempf1[0]-$tempf1[1]-$eqpId";

}
 ?>

<? /* total worked in SIOW human */
function eqTotalWorksiow($itemCode,$siow,$d,$c){

 include("config.inc.php");
 $db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 
if($c){
 $sql="SELECT SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as duration FROM `equt`".
 " WHERE itemCode = '$itemCode' AND siow='$siow' AND edate='$d'";
 }
 else {
 $sql="SELECT SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as duration FROM `equt`".
 " WHERE itemCode = '$itemCode' AND siow='$siow' AND edate<='$d'";
 
 }
//echo $sql;
 $sqlQuery=mysql_query($sql);
 $rr=mysql_fetch_array($sqlQuery);
 $totalTime = $rr[duration];
 return abs($totalTime);
 }
?>

<? /* total worked in SIOW human */
function eqTotalWorkiow($itemCode,$iow,$d,$c){

 include("config.inc.php");
 $db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 
if($c){
 $sql="SELECT SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as duration FROM `equt`".
 " WHERE itemCode = '$itemCode' AND iow='$iow' AND edate='$d'";
 }
 else {
 $sql="SELECT SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as duration FROM `equt`".
 " WHERE itemCode = '$itemCode' AND iow='$iow' AND edate<='$d'";
 
 }
//echo $sql;
 $sqlQuery=mysql_query($sql);
 $rr=mysql_fetch_array($sqlQuery);
 $totalTime = $rr[duration];
 return abs($totalTime);
 }
?>
<? 
function eq_isUtilized($asId,$itemCode,$dat,$t1,$t2){

 include("config.inc.php");
 $db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 
/*
 $sql="SELECT * FROM `equt` WHERE eqId='$asId' AND itemCode='$itemCode' 
 AND edate='$dat' AND ((TIME_TO_SEC('$t1') between TIME_TO_SEC(stime) AND TIME_TO_SEC(etime)) 
  OR (TIME_TO_SEC(stime)<= TIME_TO_SEC('$t1') AND TIME_TO_SEC(etime) >= TIME_TO_SEC('$t1'))) ORDER by id "
  */
   $sql="SELECT * FROM `equt` WHERE eqId='$asId' AND itemCode='$itemCode'
  AND edate='$dat' AND ((TIME_TO_SEC(stime) BETWEEN TIME_TO_SEC('$t1') AND TIME_TO_SEC('$t2')) 
  OR (TIME_TO_SEC(stime)<= TIME_TO_SEC('$t1') AND TIME_TO_SEC(etime) >= TIME_TO_SEC('$t1'))) ORDER by id ";

//echo $sql.'<br>';
 $sqlQuery=mysql_query($sql);
$num_rows = mysql_num_rows($sqlQuery);
//echo "<br>num_rows: $num_rows<br>";
if($num_rows>=1) return 1;
 else return 0;
 }
?>
<? 
function eq_RemainHr($itemCode,$iow,$siow){
//if($iow==0 OR $siow==0) return 1;
 include("config.inc.php");
 $db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

 $sql="SELECT dmaQty From dma where dmaiow='$iow' AND dmasiow='$siow' AND dmaItemCode='$itemCode'";
//echo $sql.'<br>';
 $sqlQuery=mysql_query($sql);
 $rr=mysql_fetch_array($sqlQuery);
 $dmaQty=$rr[dmaQty]*3600;
 //echo "dmaQty: $dmaQty---";

 $sql1="SELECT SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as duration".
 " FROM `equt` WHERE itemCode = '$itemCode' AND iow='$iow' AND siow='$siow'";
//echo $sql1.'<br>';
 $sqlQuery1=mysql_query($sql1);
 $rr1=mysql_fetch_array($sqlQuery1);
 $totalWork = $rr1[duration]; 
 //echo "totalWork :$totalWork---";
  $remainingQty=$dmaQty-$totalWork;
  return round($remainingQty); 
 }
?>
<? 
function eq_isConflictUtilizedAtt($asId,$itemCode,$dat,$t1,$t2,$eqType){

 include("config.inc.php");
 $db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

$sql = "SELECT MIN(stime) as stime,MAX(etime) as etime".
" FROM `equt`".
 " WHERE eqId='$asId' AND itemCode='$itemCode'".
 " AND edate='$dat' GROUP by edate";


/* $sql="SELECT MAX(etime) as etime,MAX(stime) as stime ,".
 " TIME_TO_SEC(stime)-TIME_TO_SEC('$t1') as err1,".
 " TIME_TO_SEC(etime)-TIME_TO_SEC('$t2') as err2". 
 " FROM `emput` WHERE empId='$asId' AND designation='$itemCode'".
 " AND edate='$dat' AND empType='$empType' GROUP by edate";
 */
//echo $sql.'<br>';
 $sqlQuery=mysql_query($sql);
$nu = mysql_fetch_array($sqlQuery);

 $sql2="SELECT ".
 " TIME_TO_SEC('$nu[stime]')-TIME_TO_SEC('$t1') as err1,".
 " TIME_TO_SEC('$t2')-TIME_TO_SEC('$nu[etime]') as err2". 
 " FROM `equt` WHERE eqId='$asId' AND itemCode='$itemCode'".
 " AND edate='$dat'  GROUP by edate";
//echo $sql2.'<br>';
 $sqlQuery2=mysql_query($sql2);
$nu2 = mysql_fetch_array($sqlQuery2);


if($nu2[err1]<0 OR $nu2[err2]<0)
//echo "<br>num_rows: $num_rows<br>";
 return 1;
 else return 0;
 }
?>



<? 
function eqRemainHr($itemCode,$iow,$siow){

 include("config.inc.php");
 $db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

 $sql="SELECT dmaQty From dma where dmaiow=$iow AND dmasiow=$siow AND dmaItemCode='$itemCode'";
//echo $sql;
 $sqlQuery=mysql_query($sql);
 $rr=mysql_fetch_array($sqlQuery);
 $dmaQty=$rr[dmaQty]*3600;
 //echo "dmaQty: $dmaQty---";

 $sql1="SELECT SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime))) as duration FROM `equt` WHERE itemCode = '$itemCode' AND iow=$iow AND siow=$siow";
//echo $sql;
 $sqlQuery1=mysql_query($sql1);
 $rr1=mysql_fetch_array($sqlQuery1);
 $totalWork = $rr1[duration]; 
 //echo "totalWork :$totalWork---";
  $remainingQty=$dmaQty-$totalWork;
  return round($remainingQty); 
 }
?>

<?
/*--------------------------------
enter employee ID
return is Present?
---------------------------------*/
function eq_transferSL(){

 $sqlf = "SELECT * FROM `eqproject`";
//echo $sqlf.'<br>';
$sqlQ= mysql_query($sqlf);
$num_rows = mysql_num_rows($sqlQ);
if($num_rows<10) $num_rows="000$num_rows";
elseif($num_rows<100) $num_rows="00$num_rows";
elseif($num_rows<1000) $num_rows="0$num_rows";
else $num_rows;
 return $num_rows;
}
?>


<?
/*--------------------------------
enter employee ID
return is Present?
---------------------------------*/
function eq_isPresent($eqId,$itemCode,$df){

 $sqlf = "SELECT * FROM `eqattendance` WHERE eqId='$eqId' AND itemCode='$itemCode' AND edate='$df' AND action='P'";
//echo $sqlf.'<br>';
$sqlQ= mysql_query($sqlf);
$num_rows = mysql_num_rows($sqlQ);
if($num_rows==1) return 1;
 else return 0;
}
?>

<?
/*--------------------------------
enter employee ID
return is Present?
---------------------------------*/
function eq_isHPresent($eqId,$itemCode,$df){

 $sqlf = "SELECT * FROM `eqattendance` WHERE eqId='$eqId' AND itemCode='$itemCode' AND edate='$df' AND action='HP'";
//echo $sqlf.'<br>';
$sqlQ= mysql_query($sqlf);
$num_rows = mysql_num_rows($sqlQ);
 return $num_rows;
}
?>





<?
/*---------------------------
input: 
output: 
---------------------------------*/

function eq_dailywork($eqId,$itemCode,$d,$eqType,$pcode){
$work=0;
 include("config.inc.php");
 //include("session.inc.php"); 
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

 $sql1="SELECT  SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as total from  `equt`".
 " where  eqId ='$eqId' AND itemCode='$itemCode'  AND edate ='$d' AND pcode=$pcode AND iow>='1' ";
//echo $sql1;
 $sqlQuery1=mysql_query($sql1);
 $remainQty1=mysql_fetch_array($sqlQuery1);
 if($remainQty1[total]) 
 $work= $remainQty1[total];
 return $work;
}
?>
<?
/*---------------------------
input: 
output: 
---------------------------------*/

function eq_dailyworkTotal($eqId,$itemCode,$d,$d1,$eqType,$pcode){
$work=0;
 include("config.inc.php");
 //include("session.inc.php"); 
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

 $sql1="SELECT  SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as total from  `equt`".
 " where  eqId ='$eqId' AND itemCode='$itemCode'  AND edate between '$d' and '$d1' AND pcode=$pcode AND iow>='1' ";
//echo $sql1;
 $sqlQuery1=mysql_query($sql1);
 $remainQty1=mysql_fetch_array($sqlQuery1);
 if($remainQty1[total]) 
 $work= $remainQty1[total];
 return $work;
}
?>

<? 
function eq_toDaypresent($eqId,$itemCode,$edate,$eqType){
 include("config.inc.php");
 $db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

$sql="select (SUM(60+ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)))) as duration
	from eqattendance
	WHERE eqId= '$eqId' AND itemCode= '$itemCode' AND edate='$edate' ";
//echo '<br>'.$sql.'<br>';
 $sqlQuery=mysql_query($sql);
 $rr=mysql_fetch_array($sqlQuery);
 return $rr[duration];
}
?>
<? 
function eq_toDaypresent1($eqId,$itemCode,$fromDate,$toDate,$eqType,$pcode){
 include("config.inc.php");
 $db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

 $sql="select (SUM(60+ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)))) as duration
	from eqattendance
	WHERE eqId= '$eqId' AND itemCode= '$itemCode' AND edate between '$fromDate' and '$toDate'";
//echo '<br>'.$sql.'<br>';
 $sqlQuery=mysql_query($sql);
 $rr=mysql_fetch_array($sqlQuery);
 return $rr[duration];
}
?>

<? 
function new_eq_toDaypresent($over1,$over2,$over3,$over4){

$empTime= (($over1*60+$over2)-($over3*60+$over4))*60;
return abs($empTime)+60; 
}
?>
<?
/*---------------------------
input: 
output: 
---------------------------------*/

function eq_dailyworkBreak($eqId,$itemCode,$d,$eqType,$pcode){
$work=0;
 include("config.inc.php");
 //include("session.inc.php"); 
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

 $sql1="SELECT  SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as total from  `equt`".
 " where  eqId ='$eqId' AND itemCode='$itemCode' AND edate ='$d' AND pcode=$pcode AND iow='0' AND siow='0' ";
//echo '<br>'.$sql1.'<br>';
 $sqlQuery1=mysql_query($sql1);
 $remainQty1=mysql_fetch_array($sqlQuery1);
  if($remainQty1[total]) 
 $work= $remainQty1[total];

 return $work;
}
?>
<?
/*---------------------------
input: 
output: 
---------------------------------*/

function eq_dailyworkBreakTotal($eqId,$itemCode,$d,$d1,$eqType,$pcode){
$work=0;
 include("config.inc.php");
 //include("session.inc.php"); 
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

 $sql1="SELECT  SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as total from  `equt`".
 " where  eqId ='$eqId' AND itemCode='$itemCode'  AND edate between '$d' and '$d1' AND pcode=$pcode AND iow='0' AND siow='0' ";
//echo $sql1;
 $sqlQuery1=mysql_query($sql1);
 $remainQty1=mysql_fetch_array($sqlQuery1);
 if($remainQty1[total]) 
 $work= $remainQty1[total];
 return $work;
}
?>

<?
/*---------------------------
input: 
output: 
---------------------------------*/

function eq_dailyBreakDown($eqId,$itemCode,$d,$eqType,$pcode){
$work=0;
 include("config.inc.php");
 //include("session.inc.php"); 
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

 $sql1="SELECT  SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as total from  `equt`".
 " where  eqId ='$eqId' AND itemCode='$itemCode' AND edate ='$d' AND pcode=$pcode AND iow='-1' AND siow='-1' ";
//echo $sql1;
 $sqlQuery1=mysql_query($sql1);
 $remainQty1=mysql_fetch_array($sqlQuery1);
  if($remainQty1[total]) 
 $work= $remainQty1[total];

 return $work;
}
?>
<?
/*---------------------------
input: 
output: 
---------------------------------*/

function eq_dailyBreakDownTotal($eqId,$itemCode,$d,$d1,$eqType,$pcode){
$work=0;
 include("config.inc.php");
 //include("session.inc.php"); 
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

 $sql1="SELECT  SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as total from  `equt`".
 " where  eqId ='$eqId' AND itemCode='$itemCode'  AND edate between '$d' and '$d1' AND pcode=$pcode AND iow='-1' AND siow='-1' ";
//echo $sql1;
 $sqlQuery1=mysql_query($sql1);
 $remainQty1=mysql_fetch_array($sqlQuery1);
 if($remainQty1[total]) 
 $work= $remainQty1[total];
 return $work;
}

?>

<? 
/*-------------------------------
input equipment Id
output rent rate
---------------------------------*/
function eqRate($eqCode){

 include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 
$temp=explode("-",$eqCode);

 $sql="SELECT * FROM equipment WHERE itemCode ='$eqCode' ORDER by price DESC";
 //echo $sql;
 $sql=mysql_query($sql); 

 $pn=mysql_fetch_array($sql);
 $cost=$pn[price];
 $salvageValue=$pn[salvageValue];
 $life=$pn[life];
 $days=$pn[days];
 $hours=$pn[hours];
 

if($cost AND $salvageValue AND $life AND $days AND $hours){
	$dep = ($cost-$salvageValue)/$life ; // as Straigth Line method

	$rateY= $dep; // per Year
//	$rateD=number_format(6* ($rateY/365)); // per Day
	$rateD=6* ($rateY/365); // per Day
  
	if($rateD<0) $rateD="eq_0";
	else $rateD='eq_'.$rateD;
	return $rateD;
}
else {
	return eqVendorRate($eqCode);
	}
}
?>

<? 
/*-------------------------------
input equipment Id
output work per day
---------------------------------*/
function eqwork($eqCode){

 include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

 $sqlf="SELECT * FROM equipment WHERE assetId LIKE '$eqCode' ";
 //echo $sqlf;
 $sqlqf=mysql_query($sqlf); 
 $pn=mysql_fetch_array($sqlqf);
 return $pn[hours];
}
?>
<?
/*-------------------------------
input project Code and Item Code
return Ordered Quantity
---------------------------------*/
function eqorderQty($p,$itemCode){
$orderQtyf=0;
 include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 
$sqlf="SELECT poid,posl,SUM(qty) as orderQtyf,dstart from porder WHERE location='$p' and itemCode='$itemCode' GROUP by itemCode";
//echo '<br>'.$sqlf.'<br>';
 $sqlQueryf=mysql_query($sqlf);
 $sqlRunf=mysql_fetch_array($sqlQueryf);
 if($sqlRunf){
 $orderQtyf=$sqlRunf[orderQtyf];
 $sdate = $sqlRunf[dstart];
 
$sqlp1 = "SELECT * from  `poschedule` WHERE posl='$sqlRunf[posl]' AND itemCode='$itemCode'";
//echo '<br>'.$sqlp1.'<br>';
$sqlrunp1= mysql_query($sqlp1);
$typel2= mysql_fetch_array($sqlrunp1);
$edate = $typel2[sdate];
$duration =1+(strtotime($edate)-strtotime($sdate))/86400;
// echo $duration;
$orderQtyf=$orderQtyf*$duration*8; 
 if($orderQtyf>0) return $orderQtyf;
  else return 0;
  }
  else return 0;
}
?>
<?
/*---------------------------
input: posl, eqCode Code
output: total remain Qty
---------------------------------*/

function eqremainQty($posl,$item,$pp){
 include("config.inc.php");
 //include("session.inc.php"); 
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

 $sql="SELECT * from  porder where posl = '$posl' AND itemCode ='$item'";
//echo '<br>'.$sql.'<br>';
 $sqlQuery=mysql_query($sql);
 $remainQty0=mysql_fetch_array($sqlQuery);
 
$order=  $remainQty0[qty];


// $sql1="SELECT count(*) as total from  `eqproject` where posl = '$posl' AND itemCode ='$item' AND (status=1 OR status=2)";
 $sql1="SELECT count(*) as total from  `eqproject` where posl = '$posl' AND itemCode ='$item'";
//echo '<br>'.$sql1.'<br>';
 $sqlQuery1=mysql_query($sql1);
 $remainQty1=mysql_fetch_array($sqlQuery1);
 $remainQty= $order- $remainQty1[total];

 return $remainQty;
}
?>

<? 
/*---------------------------
input: equipment Code
output: equipment  Rate from vendor
---------------------------------*/
function eqVendorRate($eqCode){
 include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

 $sql="SELECT quotation.*, vendor.vid from quotation,vendor where".
 " quotation.itemCode = '$eqCode'  AND quotation.vid= vendor.vid order by point ASC";
 //echo $sql;
 $sqlQuery=mysql_query($sql);
     $pn=mysql_fetch_array($sqlQuery);
	 $eqRate = $pn[vid].'_'.($pn[rate]);
	 return $eqRate;
}
?>

<?
/* ---------------------------
  Input the hrCode Code
 return the designation and Name
-------------------------------*/

function eqIowCode($p)
{
 include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

$sqlff="SELECT iowId FROM iow where iowCode LIKE '".$p."_%'";
//echo $sqlff;
$sqlf=mysql_query($sqlff);
$r=mysql_num_rows($sqlf)+1;
 return $p.'_'.$r;
}
 ?>

<?
/* ---------------------------
  Input the hrCode Code
 return the designation and Name
-------------------------------*/

function eqReceiveDate($itemCode,$assetId)
{
 include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

$sqlff="SELECT sdate FROM eqproject where itemCode ='$itemCode' AND assetId='$assetId' ORDER by sdate DESC";
//echo $sqlff;
$sqlf=mysql_query($sqlff);
$r=mysql_fetch_array($sqlf);
 return $r[sdate];
}
 ?>
<?
/* ---------------------------
  Input the hrCode Code
 return the designation and Name
-------------------------------*/

function eqpoRate($itemCode,$posl)
{
 include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

$sqlff="SELECT rate FROM porder where itemCode ='$itemCode' AND posl='$posl'";
//echo $sqlff;
$sqlf=mysql_query($sqlff);
$r=mysql_fetch_array($sqlf);
// return $r[rate]/(8*3600);
 return $r[rate];
}
 ?>
 
<?
function eqType($eqId){
$intValue=ord($eqId{0}) ;
//echo 
if($intValue>=65 AND $intValue<=122)
 return 'L';
 else return 'H';
}
?>
<? 
/* return total equipment isued in a project*/
function total_eq_issueAmount_date($pcode,$from,$to){
	
	$sql="select eqId,itemCode,posl,(SUM(60+ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)))) as duration
	from eqattendance
	WHERE edate between '$from' and '$to' AND
	location ='$pcode' GROUP by itemCode,posl  ";
//echo "<br>$sql<br>";	
$sqlq=mysql_query($sql);
while($r=mysql_fetch_array($sqlq)){
$actualPresent=0;$rate=0;
	$sql2="select (SUM(60+ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)))) as duration
	from equt
	WHERE edate between '$from' and '$to' 
	AND posl='$r[posl]' 
	AND equt.itemCode='$r[itemCode]' 
	AND pcode ='$pcode' 
	AND iow='0' ";
	//echo "$sql2<br>";
	$sqlq2=mysql_query($sql2);
	$re=mysql_fetch_array($sqlq2);	
	$actualPresent=($r[duration]-$re[duration])/(8*3600);
	
	//echo "<br>$r[itemCode],$r[posl]=$actualPresent=($r[duration]-$re[duration]);";
	$rate=eqpoRate($r[itemCode],$r[posl]);
	$amount+=$actualPresent*$rate;
	//echo "actualPresent=$actualPresent<br>";

}
	return $amount;
 }
  ?>
<?
/* ---------------------------
  Input the hrCode Code
 return the designation and Name
-------------------------------*/

function eqPurchaseReceive($posl)
{
 include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

$sqlff="SELECT sum(price) as amount FROM equipment where  reference='$posl'";
//echo $sqlff;
$sqlf=mysql_query($sqlff);
$r=mysql_fetch_array($sqlf);
// return $r[rate]/(8*3600);
 return $r[amount];
}
 ?>

<? function eqPlanReceiveAmount($sDate,$inDate,$rate,$qty){
//echo strtotime($inDate).'-'.strtotime($sDate).'<br>';

$duration=1+((strtotime($inDate)-strtotime($sDate))/86400);
//echo "$sDate,$inDate,$rate,$qty<br>";
$totalAmount=$duration*8*$rate*$qty;
//echo "$duration*8*$rate*$qty<br>";
return $totalAmount;
}?>

<? function eqActualReceiveAmount($sDate,$inDate,$rate,$posl,$itemCode,$project){
//echo strtotime($inDate).'-'.strtotime($sDate).'<br>';

//echo "($sDate,$inDate,$rate,$posl,$itemCode,$project)<br>";
$sql="SELECT * from eqproject where posl='$posl' AND itemCode='$itemCode'";
$sqlq=mysqli_query($db, $sql);
while($eq=mysqli_fetch_array($sqlq)){
$eqId=$eq[assetId];
$itemCode=$eq[itemCode];
//echo "<br>eqId=$eqId<br>";

 if($eqId{0}=='A') $eqType='L';
 else  $eqType='H';


$sqlut = "SELECT DISTINCT edate FROM equt WHERE".
" eqId='$eqId' AND itemCode='$itemCode' AND pcode='$project'".
" AND edate BETWEEN '$sDate' AND '$inDate'".
" ORDER by edate ASC";
//echo $sqlut;
$sqlqut= mysqli_query($db, $sqlut);
$i=1;
$sqlr=mysql_num_rows($sqlqut);
 while($reut= mysqli_fetch_array($sqlqut))
{
//echo "$eqId,$itemCode,$reut[edate],$eqType,$project";

	$dailyworkBreakt=eq_dailyworkBreak($eqId,$itemCode,$reut[edate],$eqType,$project);
    //$dailyBreakDownt=eq_dailyBreakDown($eqId,$itemCode,$reut[edate],$eqType,$project);
		
	$toDaypresent=eq_toDaypresent($eqId,$itemCode,$reut[edate],$eqType,$project);
  // echo "**$toDaypresent-$dailyworkBreakt-$dailyBreakDownt**<br>";	
    $toDaypresent=$toDaypresent-$dailyworkBreakt;	

	
	/*$workt= eq_dailywork($eqId,$itemCode,$reut[edate],$eqType,$project);

	$overtimet = $toDaypresent-(8*3600);
	
	if($overtimet<0) $overtimet=0;
	$idlet=$toDaypresent-$workt-$dailyBreakDownt;
	  if($idlet<0) $idlet=0;
	  */
	$totalTime+=$toDaypresent;

  }

  $totalAmount=$totalTime*($rate/3600);
 }//while 
  return $totalAmount;
}?>

<?
function eq_autoAttendance($todat,$keyDate){

$duration= (strtotime($todat)-strtotime($keyDate))/86400;

$sql="SELECT * FROM eqproject where status=1";
$sqlq=mysqli_query($db, $sql);
while($re=mysqli_fetch_array($sqlq)){

if($re[assetId]{0}=='A')  { $type='L';}
		else { $type='H'; }

for($i=0;$i<=$duration;$i++){	 
$edat=date("Y-m-d",strtotime($keyDate)+(86400*$i));
$eq_planReceiveDate=eq_planReceiveDate($re[posl],$re[itemCode]);
if(strtotime($edat)>=strtotime($eq_planReceiveDate)){	
	$sql="INSERT INTO eqattendance(id, eqId,itemCode,eqType, edate, action, text, over1,over2,over3,over4, todat,location )"."
	VALUES ('', '$re[assetId]','$re[itemCode]','$type', '$edat', 'P', '', '08','00','16','59','$todat','$re[pCode]' )";
	
	//echo $sql.'<br>';
	$sqlq1=mysqli_query($db, $sql);
	
	$sql2 = "INSERT INTO `equt` ( `id` , `eqId` ,`eqType`,`itemCode`, `iow` , `siow` , `stime` , `etime` , `details` , `edate`,pcode ) ".
	"VALUES ('', '$re[assetId]','$type','$re[itemCode]', '', '', '13:00', '13:59', 'Lunch', '$edat','$re[pCode]')";
	
	//echo $sql2.'<br>';
	$sqlq2=mysqli_query($db, $sql2);
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
$sqlq=mysqli_query($db, $sql);

while($eq=mysqli_fetch_array($sqlq)){
	$planDispatchDate=planDispatchDate($eq[posl],$eq[itemCode]);
    if(strtotime($todat)>=strtotime($planDispatchDate))
		{
		$sqlp = "UPDATE `eqproject` set edate='$todat',status=2 WHERE id=$eq[id]";
		//echo $planDispatchDate.'=='.$sqlp.'<br>';
		mysqli_query($db, $sqlp);
		}
		
	  }//while
}

?>
<?
function eq_planReceiveDate($posl,$itemCode){
$sql="select dstart from porder where posl='$posl' and itemCode='$itemCode' ";
//echo $sql.'<br>';
$sqlq=mysqli_query($db, $sql);
$sqlr=mysqli_fetch_array($sqlq);
return $sqlr[dstart];
}
?>

<?
function planDispatchDate($posl,$itemCode){
$sql="select sdate from poschedule,porder where posl='$posl' and itemCode='$itemCode' AND porder.poid=poschedule.poid";
//echo $sql.'<br>';
$sqlq=mysqli_query($db, $sql);
$sqlr=mysqli_fetch_array($sqlq);
return $sqlr[sdate];
}
?>

<? /* total worked in SIOW human */
function eqExTime($eqId,$itemCode,$eqType,$edate){

 include("config.inc.php");
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

if($eqType=='H') $sql="SELECT over1,over2,over3,over4 FROM `eqattendance`".
 " WHERE eqId= '$eqId' AND itemCode= '$itemCode' AND edate='$edate'";
else if($eqType=='L') $sql="SELECT over1,over2,over3,over4 FROM `eqattendance`".
 " WHERE eqId= '$eqId' AND itemCode= '$itemCode' AND edate='$edate'";

//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);

$eqTime= array("eh"=>$rr[over1],"em"=>$rr[over2],'xh'=>$rr[over3],'xm'=>$rr[over4]);
	 return $eqTime; 
 }
?>

<?
function eqTotalPresentHr($fromd,$tod,$eqId,$itemCode,$type,$project){
$sql="SELECT count(*) as totalPresent from eqattendance WHERE".
" eqId='$eqId' AND itemCode='$itemCode' AND eqtype='$type' AND location='$project'";
//echo $sql;
$sqlq=mysqli_query($db, $sql);
$sqlf=mysqli_fetch_array($sqlq);
return $sqlf[totalPresent];
}
?>

<? 
function eqTotalWorkhrsiow($itemCode,$dat,$siow){

 include("config.inc.php");
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

 $sql="SELECT * FROM `eqproject` WHERE itemCode LIKE '$itemCode' AND status='1' ORDER by id";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $sdate = $rr[sdate];

 include("config.inc.php");
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

 $sql="SELECT SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime))) as duration FROM `equt` WHERE".
 " itemCode ='$itemCode' AND siow='$siow' AND edate BETWEEN '$sdate' AND '$dat'";
//echo $sql.'<br>';
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $totalRate = $rr[duration];
 return abs($totalRate);

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
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 
if($c){
 $sql="SELECT SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as duration FROM `equt`".
 " WHERE itemCode = '$itemCode' AND siow='$siow' AND edate='$d'";
 }
 else {
 $sql="SELECT SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as duration FROM `equt`".
 " WHERE itemCode = '$itemCode' AND siow='$siow' AND edate<='$d'";
 
 }
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $totalTime = $rr[duration];
 return abs($totalTime);
 }
?>

<? /* total worked in SIOW human */
function eqTotalWorkiow($itemCode,$iow,$d,$c){

 include("config.inc.php");
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 
if($c){
 $sql="SELECT SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as duration FROM `equt`".
 " WHERE itemCode = '$itemCode' AND iow='$iow' AND edate='$d'";
 }
 else {
 $sql="SELECT SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as duration FROM `equt`".
 " WHERE itemCode = '$itemCode' AND iow='$iow' AND edate<='$d'";
 
 }
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $totalTime = $rr[duration];
 return abs($totalTime);
 }
?>
<? 
function eq_isUtilized($asId,$itemCode,$dat,$t1,$t2){

 include("config.inc.php");
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

 $sql="SELECT * FROM `equt` WHERE eqId='$asId' AND itemCode='$itemCode' AND edate='$dat' AND ((TIME_TO_SEC('$t1') between TIME_TO_SEC(stime) AND TIME_TO_SEC(etime))".
 " OR (TIME_TO_SEC('$t2') between TIME_TO_SEC(stime) AND TIME_TO_SEC(etime))) ORDER by id";
//echo $sql.'<br>';
 $sqlQuery=mysqli_query($db, $sql);
$num_rows = mysql_num_rows($sqlQuery);
//echo "<br>num_rows: $num_rows<br>";
if($num_rows>=1) return 1;
 else return 0;
 }
?>
<? 
function eq_RemainHr($itemCode,$iow,$siow){

 include("config.inc.php");
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

 $sql="SELECT dmaQty From dma where dmaiow=$iow AND dmasiow=$siow AND dmaItemCode='$itemCode'";
//echo $sql.'<br>';
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $dmaQty=$rr[dmaQty]*3600;
 //echo "dmaQty: $dmaQty---";

 $sql1="SELECT SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as duration".
 " FROM `equt` WHERE itemCode = '$itemCode' AND iow=$iow AND siow=$siow";
//echo $sql.'<br>';
 $sqlQuery1=mysqli_query($db, $sql1);
 $rr1=mysqli_fetch_array($sqlQuery1);
 $totalWork = $rr1[duration]; 
 //echo "totalWork :$totalWork---";
  $remainingQty=$dmaQty-$totalWork;
  return round($remainingQty); 
 }
?>
<? 
function eq_isConflictUtilizedAtt($asId,$itemCode,$dat,$t1,$t2,$eqType){

 include("config.inc.php");
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

$sql = "SELECT MIN(stime) as stime,MAX(etime) as etime".
" FROM `equt`".
 " WHERE eqId='$asId' AND itemCode='$itemCode'".
 " AND edate='$dat' AND eqType='$eqType' GROUP by edate";


/* $sql="SELECT MAX(etime) as etime,MAX(stime) as stime ,".
 " TIME_TO_SEC(stime)-TIME_TO_SEC('$t1') as err1,".
 " TIME_TO_SEC(etime)-TIME_TO_SEC('$t2') as err2". 
 " FROM `emput` WHERE empId='$asId' AND designation='$itemCode'".
 " AND edate='$dat' AND empType='$empType' GROUP by edate";
 */
//echo $sql.'<br>';
 $sqlQuery=mysqli_query($db, $sql);
$nu = mysqli_fetch_array($sqlQuery);

 $sql2="SELECT ".
 " TIME_TO_SEC('$nu[stime]')-TIME_TO_SEC('$t1') as err1,".
 " TIME_TO_SEC('$t2')-TIME_TO_SEC('$nu[etime]') as err2". 
 " FROM `equt` WHERE eqId='$asId' AND itemCode='$itemCode'".
 " AND edate='$dat' AND eqType='$eqType' GROUP by edate";
//echo $sql2.'<br>';
 $sqlQuery2=mysqli_query($db, $sql2);
$nu2 = mysqli_fetch_array($sqlQuery2);


if($nu2[err1]<0 OR $nu2[err2]<0)
//echo "<br>num_rows: $num_rows<br>";
 return 1;
 else return 0;
 }
?>



<? 
function eqRemainHr($itemCode,$iow,$siow){

 include("config.inc.php");
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

 $sql="SELECT dmaQty From dma where dmaiow=$iow AND dmasiow=$siow AND dmaItemCode='$itemCode'";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $dmaQty=$rr[dmaQty]*3600;
 //echo "dmaQty: $dmaQty---";

 $sql1="SELECT SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime))) as duration FROM `equt` WHERE itemCode = '$itemCode' AND iow=$iow AND siow=$siow";
//echo $sql;
 $sqlQuery1=mysqli_query($db, $sql1);
 $rr1=mysqli_fetch_array($sqlQuery1);
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
$sqlQ= mysqli_query($db, $sqlf);
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
$sqlQ= mysqli_query($db, $sqlf);
$num_rows = mysql_num_rows($sqlQ);
 return $num_rows;
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
$sqlQ= mysqli_query($db, $sqlf);
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
$work=0;;
 include("config.inc.php");
 //include("session.inc.php"); 
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

 $sql1="SELECT  SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as total from  `equt`".
 " where  eqId ='$eqId' AND itemCode='$itemCode' AND eqType='$eqType' AND edate ='$d' AND pcode=$pcode AND iow>='1' ";
//echo $sql1;
 $sqlQuery1=mysqli_query($db, $sql1);
 $remainQty1=mysqli_fetch_array($sqlQuery1);
  if($remainQty1[total]) 
 $work= $remainQty1[total];

 return $work;
}
?>
<? 
function eq_toDaypresent($eqId,$itemCode,$edate,$eqType){
 include("config.inc.php");
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

if($eqType=='H') $sql="SELECT over1,over2,over3,over4 FROM `eqattendance`".
 " WHERE eqId= '$eqId' AND itemCode= '$itemCode' AND edate='$edate'";
 
if($eqType=='L') $sql="SELECT over1,over2,over3,over4 FROM `eqattendance`".
 " WHERE eqId= '$eqId' AND itemCode= '$itemCode' AND edate='$edate'";

//echo '<br>'.$sql.'<br>';
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 if($rr){
/*
echo "$rr[over1]=$rr[over2]=$rr[over3]=$rr[over4]=";

$t1=$rr[over1]*60+$rr[over2];
echo $t1;
$t2=$rr[over3]*60+$rr[over4];
echo '='.$t2;
$t= $t2-$t1;
echo "** $t**";
*/
$empTime= (($rr[over1]*60+$rr[over2])-($rr[over3]*60+$rr[over4]))*60;
return abs($empTime)+60; 
}
else return 0;
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
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

 $sql1="SELECT  SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as total from  `equt`".
 " where  eqId ='$eqId' AND itemCode='$itemCode' AND eqType='$eqType' AND edate ='$d' AND pcode=$pcode AND iow='' AND siow='' ";
//echo '<br>'.$sql1.'<br>';
 $sqlQuery1=mysqli_query($db, $sql1);
 $remainQty1=mysqli_fetch_array($sqlQuery1);
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
$work=0;;
 include("config.inc.php");
 //include("session.inc.php"); 
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

 $sql1="SELECT  SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as total from  `equt`".
 " where  eqId ='$eqId' AND itemCode='$itemCode' AND eqType='$eqType' AND edate ='$d' AND pcode=$pcode AND iow='-1' AND siow='-1' ";
//echo $sql1;
 $sqlQuery1=mysqli_query($db, $sql1);
 $remainQty1=mysqli_fetch_array($sqlQuery1);
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
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 
$temp=explode("-",$eqCode);

 $sql="SELECT * FROM equipment WHERE itemCode ='$eqCode' ORDER by price DESC";
 //echo $sql;
 $sql=mysqli_query($db, $sql); 

 $pn=mysqli_fetch_array($sql);
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
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

 $sqlf="SELECT * FROM equipment WHERE assetId LIKE '$eqCode' ";
 //echo $sqlf;
 $sqlqf=mysqli_query($db, $sqlf); 
 $pn=mysqli_fetch_array($sqlqf);
 return $pn[hours];
}
?>
<?
/*-------------------------------
input project Code and Item Code
return Ordered Quantity
---------------------------------*/
function eqorderQty($p,$q){
$orderQtyf=0;
 include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 
$sqlf="SELECT poid,SUM(qty) as orderQtyf,dstart from porder WHERE location='$p' and itemCode='$q' GROUP by itemCode";
//echo '<br>'.$sqlf.'<br>';
 $sqlQueryf=mysqli_query($db, $sqlf);
 $sqlRunf=mysqli_fetch_array($sqlQueryf);
 if($sqlRunf){
 $orderQtyf=$sqlRunf[orderQtyf];
 $sdate = $sqlRunf[dstart];
 
$sqlp1 = "SELECT * from  `poschedule` WHERE poid=$sqlRunf[poid]";
//echo '<br>'.$sqlp1.'<br>';
$sqlrunp1= mysqli_query($db, $sqlp1);
$typel2= mysqli_fetch_array($sqlrunp1);
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
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

 $sql="SELECT * from  porder where posl = '$posl' AND itemCode ='$item'";
//echo '<br>'.$sql.'<br>';
 $sqlQuery=mysqli_query($db, $sql);
 $remainQty0=mysqli_fetch_array($sqlQuery);
 
$order=  $remainQty0[qty];


// $sql1="SELECT count(*) as total from  `eqproject` where posl = '$posl' AND itemCode ='$item' AND (status=1 OR status=2)";
 $sql1="SELECT count(*) as total from  `eqproject` where posl = '$posl' AND itemCode ='$item'";
//echo '<br>'.$sql1.'<br>';
 $sqlQuery1=mysqli_query($db, $sql1);
 $remainQty1=mysqli_fetch_array($sqlQuery1);
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
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

 //$sql=" SELECT rate FROM `quotation` WHERE itemCode='$eqCode' order by rate DESC";
 $sql="SELECT quotation.*, vendor.vid from quotation,vendor where quotation.itemCode = '$eqCode'  AND quotation.vid= vendor.vid order by point ASC";
 //echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
     $pn=mysqli_fetch_array($sqlQuery);
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
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

$sqlff="SELECT iowId FROM iow where iowCode LIKE '".$p."_%'";
//echo $sqlff;
$sqlf=mysqli_query($db, $sqlff);
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
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

$sqlff="SELECT sdate FROM eqproject where itemCode ='$itemCode' AND assetId='$assetId' ORDER by sdate DESC";
//echo $sqlff;
$sqlf=mysqli_query($db, $sqlff);
$r=mysqli_fetch_array($sqlf);
 return $r[sdate];
}
 ?>

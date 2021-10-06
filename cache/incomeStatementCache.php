<?php
error_reporting(1);
header('Content-Type: text/html; charset=ISO-8859-1');
session_start();
$_SESSION['loginUname']="Robot";
include("../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
include("../includes/myFunction.php"); // some general function
include_once("../includes/myFunction1.php"); // some general function
include_once("../includes/accFunction.php"); //all accounts function
include_once("../includes/empFunction.inc.php"); //manpower function
include_once("../includes/eqFunction.inc.php"); // equipment function
include_once("../includes/subFunction.inc.php"); // sub contracts function
include_once("../includes/matFunction.inc.php"); // material function
include_once('../includes/vendoreFunction.inc.php'); // vendor related function
include_once('../employee/wages_calc.php'); // wages function
require('./iFunction.php'); // vendor related function
include('../project/siteDailyReport.f.php');



$fromDate='2014-01-1';
$toDate=$_GET[toDate];
$fromDate1= date('Y-m-j',mktime(0, 0, 0, date("m",strtotime($toDate)), 1,   date("Y",strtotime($toDate))));
$pcode=$_GET[pcode];







  
function is6802000($pcode,$fromDate,$toDate,$iowType=1){
global $db;
$ch = curl_init();
$headers["Content-Length"] = strlen($postString);
$headers["User-Agent"] = "Curl/1.0";

curl_setopt($ch, CURLOPT_URL, $requestUrl);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, 'admin:');
curl_setopt($ch,CURLOPT_TIMEOUT,960000000);
$response = curl_exec($ch);
curl_close($ch);
//set_time_limit(0);
ini_set("memory_limit","6000M");
ini_set("max_execution_time","9600000000");
	
$iowType=$_GET["iowType"]>0 ? $_GET["iowType"] : 1;

		 $overtimeAmountTotal=0;
		 $regularAmountTotalat=0;
		 $normalDayAmountTotal=0;

	
	$sqlp = "SELECT DISTINCT e.itemCode, MAX(d.dmaRate) as rate from `dma` as d, eqattendance as e Where d.dmaProjectCode='$pcode' AND d.dmaItemCode=e.itemCode and e.itemCode >= '50-00-000' AND e.itemCode < '70-00-000' AND e.location='$pcode'";

	if($iowType==1){
		$sqlp .=" and d.dmaiow in (select iowId from iow where iowType=1) ";
	}elseif($iowType==2){
		$sqlp .=" and d.dmaiow in (select iowId from iow where iowType=2) ";
	}elseif($iowType=="all"){
		$sqlp .="";
	}

	$sqlp .=" group by e.itemCode ORDER by e.itemCode ASC";

// 	echo $sqlp;

$sqlrunp= mysqli_query($db, $sqlp);
while($typel= mysqli_fetch_array($sqlrunp)){

		$workedgTotal=0;
		 $overtimetat=0;
		 $toDaypresentat=0;
		 $idletat=0;

		 $itemCode1=$typel[itemCode];
		 $rate=$typel[rate];

		// print "<br>";
		  $sqlquery="SELECT distinct eqId FROM eqattendance".
		" where eqattendance.location='$pcode' AND itemCode='$itemCode1'".
		" and eqattendance.edate >='$fromDate' and eqattendance.edate <='$toDate'".
		" AND action in('P','HP') ORDER by itemCode ASC";
		 $sql= mysqli_query($db, $sqlquery);
//		 print mysqli_num_rows($sql)." ";
		 while($r=mysqli_fetch_array($sql)){
//BETWEEN '$fromDate' and '$toDate'
			 /*
			 Feture work please delete while it has been finished.(eq_dailywork1)
			 EQ daily work should be iow type specific.
			 (Invoiceable or Noninvoiceable)
			 */
			$workt=eq_dailywork1($r[eqId],$itemCode1,$fromDate,$toDate,'H',$pcode);
			$dailyworkBreakt=eq_dailyworkBreak1($r[eqId],$itemCode1,$fromDate,$toDate,'H',$pcode);

			$dailyBreakDown=eq_dailyBreakDown1($r[eqId],$itemCode1,$fromDate,$toDate,'H',$pcode);
			$toDaypresent=eq_toDaypresent2($r[eqId],$itemCode1,$fromDate,$toDate,'H',$pcode);

			$toDaypresents=$toDaypresent-$dailyworkBreakt;	
			$toDaypresentat=$toDaypresentat+$toDaypresents;

			// echo $toDaypresents.">";

			$workts=$workt-$dailyworkBreakt;
			 $workedgTotal=$workedgTotal+$workt;
			if($workedgTotal<0)
			$workedgTotal=0;
			$overtimet = $toDaypresents-8*3600;
			if($overtimet<0) $overtimet=0;
			$overtimetat=$overtimetat+$overtimet;
			
			$idlet=$toDaypresents-$workt;
			  if($idlet<0) $idlet=0;
			  $idletat=$idletat+$idlet; 
			}
	
	$amount+=($idlet/3600)*$rate;
// echo "loop>>";
// echo $workedgTotal.">".$rate."??";
	 $totalWorkingTaka+=($workedgTotal/3600)*$rate; 
	 $b=($overtimetat/3600)*$rate;
	 $c=(($toDaypresentat-$overtimetat)/3600)*$rate;

	$normalDayAmountTotal=$normalDayAmountTotal+$a; 
	$regularAmountTotalat=$regularAmountTotalat+$c;

	$overtimeAmountTotal=$overtimeAmountTotal+$b;
  
	}
 return '{"utilizedAmount":"'.($totalWorkingTaka ? $totalWorkingTaka : 0).'","idleAmount":"'.($amount ? $amount : 0).'"}';
}


// 68010000
// input $fromDate,$toDate,$pcode,$fromDate1
// output 
function get6801000($fromDate,$toDate,$pcode,$fromDate1){
  $amountR=total_mat_directissueAmount_date($pcode, $fromDate,$toDate);  // range
  $amountC=total_mat_directissueAmount_date($pcode, $fromDate1,$toDate);  // to month
  
  return '{"toMonth":"'.($amountC ? $amountC : 0).'","toRange":"'.($amountR ? $amountR : 0).'"}';
}

// 6802000X
// input $fromDate,$toDate,$pcode,$fromDate1
// output 
function get680200X($fromDate,$toDate,$pcode,$fromDate1){
  $amountR=is6802000($pcode, $fromDate,$toDate,$_GET["iowType"]);  // range
  $amountC=is6802000($pcode, $fromDate1,$toDate,$_GET["iowType"]);  // to month  
  return '{"toMonth":'.$amountC.',"toRange":'.$amountR.'}';
}

// 6803000
// input $fromDate,$toDate,$pcode,$fromDate1
// output 
function get6803000($fromDate,$toDate,$pcode,$fromDate1,$iowType=1){
  $amountR=sub_po_directReceive($pcode, $fromDate,$toDate);  // range
  $amountC=sub_po_directReceive($pcode, $fromDate1,$toDate);  // to month  
   return '{"toMonth":"'.($amountC ? $amountC : 0).'","toRange":"'.($amountR ? $amountR : 0).'"}';
}

// 6803000
// input $fromDate,$toDate,$pcode,$fromDate1
// output 
function get6804000($fromDate,$toDate,$pcode,$fromDate1){
ini_set("memory_limit","6000M");
ini_set("max_execution_time","960000");
	if($pcode==205 || $pcode==200){ //cache memory
		$amountR=redirect_wage_calc($pcode,$fromDate,$toDate);  // range
		$amountC=redirect_wage_calc($pcode,$fromDate1,$toDate);  // to month  
	}else{
		$amountR=getWagesAmount($fromDate,$toDate,$pcode);  // range
		$amountC=getWagesAmount($fromDate1,$toDate,$pcode);  // to month
	}
// 	json encode from amount array
	$amountR='{"utilizedAmount":"'.$amountR[1].'","idleAmount":"'.$amountR[0].'"}';
	$amountC='{"utilizedAmount":"'.$amountC[1].'","idleAmount":"'.$amountC[0].'"}';
// 	end of json encode
	
   return '{"toMonth":'.$amountC.',"toRange":'.$amountR.'}';
}

// getTWP
// input $fromDate,$toDate,$pcode,$fromDate1
// output 
function getTWP($fromDate,$toDate,$pcode,$fromDate1){
ini_set("memory_limit","6000M");
ini_set("max_execution_time","9600000000");
	global $db;
	$TWP=0;
$sql = "SELECT * from `iow` WHERE 1
 AND iowProjectCode= '$pcode' and iowStatus!='noStatus' 
 AND iowType='1' ORDER by iowId ASC";

$ed=$toDate;
// echo $sql;
$sqlrunp=mysqli_query($db, $sql);
$i=1;
// echo mysqli_affected_rows($db);
	 while($iow=mysqli_fetch_array($sqlrunp)){
// 		 echo "<br>iowID=$iow[iowId]<br>";
// 		 $WP2=WP2($iow[iowId],$iow[iowProjectCode],$ed,$iow[iowQty],$iow[iowUnit],0);
		 	 $unit=$iow[iowUnit];
			 if($unit=='L.S' OR $unit=='LS' OR $unit=='l.s' OR $unit=='l.s') {}
			else  
				if($unit=='')$unit=0;
		 $WP2=$unit;
		 
		if($WP2=='LS' || $WP2=='L.S' || $WP2=='l.s' || $WP2=='l.s')
		{
			$workComplited1 = WP1($iow[iowId],$iow[iowProjectCode],$ed,$iow[iowQty],$iow[iowUnit],0); //echo "--";
			$workComplited=number_format($workComplited1,2,'.','');
// 	echo "iow=$iow[iowId]; workComplited: $workComplited<br>";
			$invoicedQty1=invoicedQty($iow[iowId]); //echo "--";
			$invoicedQty=number_format($invoicedQty1,2,'.','');
// 	echo "<br>invoice qty=$invoicedQty;<br>";
			$rate=$iow[iowPrice]; //echo "--#";

			$calculatedvalue=((($workComplited-$invoicedQty)*$rate)/100); //echo "<br>"; //TWP= total work in progress
// echo "calculate value=$calculatedvalue<br>";
			//print "<br>";
			$TWP+=$calculatedvalue;
//	print "<br>";
// 	if($calculatedvalue<0)echo "<hr style='border:2px solid red'>";
// 	echo "<hr>";
		}else{
			 $workComplited3 = WP1($iow[iowId],$iow[iowProjectCode],$ed,$iow[iowQty],$iow[iowUnit],0); 
				$workComplited2=number_format($workComplited3,2,'.','');
// echo "iow=$iow[iowId]; workComplited2: $workComplited2<br>";
			 $invoicedQty3=invoicedQty($iow[iowId]); //echo "--";
				$invoicedQty2=number_format($invoicedQty3,2,'.','');
			  $rate2=$iow[iowPrice];
// echo "Invoice Qty=$invoicedQty2; rate=$rate2<br>";
				$calculatedvalue2=($workComplited2-$invoicedQty2)*$rate2; //echo "==";
// echo "calculate value=$calculatedvalue2<br>";
				$TWP+=$calculatedvalue2; //echo "<br>";	
		}
// 	if($calculatedvalue2<0)echo "<hr style='border:2px solid red'>";
		/* if($kk++>2)
		 exit;else*/ //echo "<hr>";
	}	
	$_SESSION["TWP"]=$TWP;
  return '{"TWP":'.$TWP.'}';
}

function getIowCount($pcode){
	global $db;
	$sql="select count(*) as iows from iow where iowProjectCode='$pcode' and iowStatus!='noStatus' 
 AND iowType='1' ";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row[iows];
}


if($_GET["6801000"])
  echo get6801000($fromDate,$toDate,$pcode,$fromDate1);
if($_GET["680200X"])
  echo get680200X($fromDate,$toDate,$pcode,$fromDate1);
if($_GET["6803000"])
  echo get6803000($fromDate,$toDate,$pcode,$fromDate1);
if($_GET["6804000"])
  echo get6804000($fromDate,$toDate,$pcode,$fromDate1);
if($_GET["TWP"])
  echo getTWP($fromDate,$toDate,$pcode,$fromDate1);
if($_GET["IOW_COUNT"])
	echo getIowCount($pcode);
if($_GET["user"])
	echo count(glob(session_save_path() . '/*'));
?>
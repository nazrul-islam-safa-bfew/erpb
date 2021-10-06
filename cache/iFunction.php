<?php
function eq_dailywork1($eqId,$itemCode,$d1,$d2,$eqType,$pcode){
global $db;
$work=0;
  $sql1="SELECT  SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as total from  `equt`".
 " where  eqId ='$eqId' AND itemCode='$itemCode'  AND edate BETWEEN '$d1' and '$d2' AND pcode=$pcode AND iow>='1' ";
	
	$iowType=$_GET["iowType"]>0 ? $_GET["iowType"] : 1;
	if($iowType==1){
		$sql1 .=" and iow in (select iowId from iow where iowType=1) ";
	}elseif($iowType==2){
		$sql1 .=" and iow in (select iowId from iow where iowType=2) ";
	}elseif($iowType=="all"){
		$sql1 .="";
	}
//echo $sql1;

 $sqlQuery1=mysqli_query($db, $sql1);
 $remainQty1=mysqli_fetch_array($sqlQuery1);
 if($remainQty1[total]) 
 $work= $remainQty1[total];
 return $work;
}
function eq_dailyworkBreak1($eqId,$itemCode,$d1,$d2,$eqType,$pcode){
$work=0;
global $db;
  $sql1="SELECT  SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as total from  `equt`".
 " where  eqId ='$eqId' AND itemCode='$itemCode' AND edate BETWEEN '$d1' and '$d2' AND pcode=$pcode AND iow='0' AND siow='0' ";
//echo '<br>'.$sql1.'<br>';

 $sqlQuery1=mysqli_query($db, $sql1);
 $remainQty1=mysqli_fetch_array($sqlQuery1);
  if($remainQty1[total]) 
 $work= $remainQty1[total];

 return $work;
}

function eq_dailyBreakDown1($eqId,$itemCode,$d1,$d2,$eqType,$pcode){global $db;
$work=0;
  $sql1="SELECT  SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as total from  `equt`".
 " where  eqId ='$eqId' AND itemCode='$itemCode' AND edate BETWEEN '$d1' and '$d2' AND pcode=$pcode AND iow='-1' AND siow='-1' ";
//echo $sql1;
 $sqlQuery1=mysqli_query($db, $sql1);
 $remainQty1=mysqli_fetch_array($sqlQuery1);
  if($remainQty1[total]) 
 $work= $remainQty1[total];

 return $work;
}
function eq_toDaypresent2($eqId,$itemCode,$d1,$d2,$eqType,$pcode){global $db;
 $sql="select (SUM(60+ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)))) as duration
	from eqattendance
	WHERE eqId= '$eqId' AND itemCode= '$itemCode' AND edate BETWEEN '$d1' and '$d2' AND location='$pcode'";
//echo '<br>'.$sql.'<br>';
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 return $rr[duration];
}

///////////////////////////////////////////////////////////
	 function WP1($iow,$p,$ed,$totalQty,$unit,$c){
// 		 echo "<br>iow=$iow; p=$p; toDate=$ed; totalQty=$totalQty; unit=$unit; c=$c;</br>";
		$ed=formatDate($ed,'Y-m-j');
		$approvedTotalAmount=iowApprovedCost($iow);
// 		echo "<br>**iowApprovedCost=$approvedTotalAmount**<br>";
		
		$totalMaretialCost=totalMaretialCost($iow,$p,$ed,$c);
// 		echo "<br>**totalMaretialCost=$totalMaretialCost**<br>";
		$totalempCost=totalempCost($iow,$p,$ed,$c);
		$totalSubconCost=totalSubconCost($iow,$p,$ed,$c);
		
// 		echo "<br>**totalempCost=$totalempCost**<br>";
		$totalSubconCost=totalSubconCost($iow,$p,$ed,$c);
// 		echo "<br>**totalSubconCost=$totalSubconCost**<br>";
		
		$totaleqCost=totaleqCost($iow,$p,$ed,$c);
// 		echo "<br>**totaleqCost=$totaleqCost**<br>";
		
		$actualTotalAmount=$totalMaretialCost+$totalempCost+$totalSubconCost+$totaleqCost;
		
		 $progressp1=($actualTotalAmount*100)/$approvedTotalAmount;
		 $progressp=number_format($progressp1);
		 $progressQty1=($totalQty*$progressp1)/100;
		 $progressQty=number_format($progressQty1,2,'.','');
		 if($unit=='L.S' OR $unit=='LS' OR $unit=='l.s' OR $unit=='l.s') 
			return $progressp;
		else  
			/*if($unit=='Days' || $unit=='Month' || $unit=='Km' || $unit=='Ton'|| $unit=='m' || $unit=='Joint' || $unit=='No') return $progressQty; else  return $unit; */
			return $progressQty;
		}
 
 
			function WP2($iow,$p,$ed,$totalQty,$unit,$c){
			//$ed=formatDate($ed,'Y-m-j');
			$approvedTotalAmount=iowApprovedCost($iow);
			
			$totalMaretialCost=totalMaretialCost($iow,$p,$ed,$c);
			//echo "<br>**totalMaretialCost=$totalMaretialCost**<br>";
			$totalempCost=totalempCost($iow,$p,$ed,$c);
			$totalSubconCost=totalSubconCost($iow,$p,$ed,$c);
			
			//echo "<br>**totalempCost=$totalempCost**<br>";
			//$totalSubconCost=totalSubconCost($iow,$p,$ed,$c);
			//echo "<br>**totalSubconCost=totalSubconCost**<br>";
			
			$totaleqCost=totaleqCost($iow,$p,$ed,$c);
			//echo "<br>**totaleqCost=$totaleqCost**<br>";
			
			$actualTotalAmount=$totalMaretialCost+$totalempCost+$totalSubconCost+$totaleqCost;
			
			 $progressp=($actualTotalAmount*100)/$approvedTotalAmount;
			
			 $progressQty=($totalQty*$progressp)/100;
			
			 if($unit=='L.S' OR $unit=='LS' OR $unit=='l.s' OR $unit=='l.s') 
				return $unit;
			else  
				if($unit=='')return $unit=0; else  return $unit;
			}


?>
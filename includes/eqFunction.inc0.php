<?
function equipment_counter($itemCode){
  global $db;
  $sql="select count(*) as rows from equipment where itemCode='$itemCode'";
  $q=mysqli_query($db,$sql);
  $row=mysqli_fetch_array($q);
  return $row["rows"];
}

function get_max_consumption($assetId,$itemCode){
	global $db;
	$sql="select * from eqconsumption where eqItemCode='$itemCode' and eqId='$assetId'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);	
}

function get_max_acEqconsumption($assetId,$itemCode){
	global $db;
	$sql="select max(km) as km from accEqConsumption where eqItemCode='$itemCode' and eqId='$assetId'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row['km'];
}

function getPOapprovedStatus($posl){
  
	global $db;
	$sql="select `status` from porder where posl='$posl'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row["status"];
}

function generateIowCode($iowCode){
	global $db;
	$iowCodeTemp=$iowCode=getLastIowCode($iowCode);
	$availableIowCode=isIowCodeAvailable($iowCode);
	$i=0;
	while($availableIowCode==false){
		$i++;
		$iowCodeTemp=$iowCode.$i;
		$availableIowCode=isIowCodeAvailable($iowCodeTemp);
	}
	return $iowCodeTemp;
}

function getLastIowCode($iowCode){
	global $db;
	$sql="select iowCode from iow where iowCode='$iowCode' order by iowId desc limit 1";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	if($row["iowCode"])return $row["iowCode"];
	return $iowCode;
}


/*
return true if iowCode available
return false if iowCode not available
*/
function isIowCodeAvailable($iowCode){
	global $db;
	$sql="select count(*) rows from iowtemp where iowCode='$iowCode'";
	$q=mysqli_query($db,$sql);
	$rowT=mysqli_fetch_array($q);
	
	$sql="select count(*) rows from iow where iowCode='$iowCode'";
	$q=mysqli_query($db,$sql);
	$rowA=mysqli_fetch_array($q);	
	
	if($rowT["rows"]>0 || $rowA["rows"]>0)return false;
	return true;
}

function preventiveReplication(){
	global $db;
	$debug=0;
	
	$iowProjectCode="004";
	$i=1;
	$sqlIow="select e.eqItemCode,e.maintenanceFrequency,i.* from eqmaintenance e,iow i where e.maintenanceType='p' and e.iowCode in (select iowCode from iow where iowProjectCode='004') and e.iowCode=i.iowCode and isNull(e.references_iowCode)";
	if($debug)$sqlIow.=" and e.eqitemCode='51-05-000'";
	$qI=mysqli_query($db,$sqlIow);
	echo "<h1>Preventive iow found: ".mysqli_affected_rows($db)."</h1>";
	echo "$sqlIow <br><br>";
	
	while($rowI=mysqli_fetch_array($qI)){
		$i++;
		$iowTotal=$rowI[iowPrice]*$rowI[iowQty];
		$iowType="2";
		$iowProjectCode="004";
		$headPos=getUpperHeadPosition($rowI[position]);
		
		$eSql="select * from equipment where itemCode='$rowI[eqItemCode]' and itemCode not in (select eqItemCode from eqmaintenance where references_iowCode!='' and references_iowCode='$rowI[iowCode]')";
// 	if($debug)$eSql.=" and itemCode='51-06-000'";
		$eQ=mysqli_query($db,$eSql);
		echo "<h2>Preventive iow equipment found: ".mysqli_affected_rows($db)."</h2>";
		echo "$eSql <br><br>";
		while($eRow=mysqli_fetch_array($eQ)){
			$availablePos=generateNewPosition($headPos,$iowProjectCode);
			$todat=todat();
			$sqliowEQ="INSERT INTO eqmaintenance (pcode, iowCode, iowDes, eqItemCode, maintenanceType, edate, maintenanceFrequency, measureUnit, attachPDF, attachIMG, eqmStatus, position, dt, references_iowCode)
	 VALUES ('$iowProjectCode', '$rowI[iowCode] $i', '$rowI[iowDes]', '$eRow[itemCode]', 'p', '$todat',  '$rowI[maintenanceFrequency]', '$eRow[measureUnit]', '$eRow[attachPDF]', '$eRow[attachIMG]', 'Not Ready', '$availablePos','$_SESSION[diagonosisID]', '$rowI[iowCode]')";
		echo "<h3>Preventive iow eqmaintenance inserted: ".mysqli_affected_rows($db)."</h3>";
		echo "$sqliowEQ <br><br>";
// 		mysqli_query($db, $sqliowEQ);
			
			$sqliow="INSERT INTO iow (iowProjectCode,itemCode, iowCode, iowDes, iowQty, iowUnit,
		 iowPrice, iowTotal, iowType, iowSdate, iowCdate, iowStatus, iowDate, Prepared, Checked, Approved, revision, position)
	 VALUES ('$iowProjectCode', '$rowI[itemCode]','$rowI[iowCode] $i', '$rowI[iowDes]', '$rowI[iowQty]', '$rowI[iowUnit]',
			'$rowI[iowPrice]', '$iowTotal', '$iowType', '$rowI[iowSdate]', '$rowI[iowCdate]', 'Approved by MD', '$rowI[iowDate]', '', '', 'y','0','$availablePos')";
			echo "<h4>Preventive new iow inserted: ".mysqli_affected_rows($db)."</h4>";
			echo "$sqliow <br><br>";
// 		mysqli_query($db, $sqliow);
			
// 			siow insert
			$siowSql="SELECT  `siowId`,`siowPcode`, `iowId`, `siowCode`, `siowName`, `siowQty`, `siowUnit`, `analysis`, `siowDate`, `siowSdate`, `siowCdate`, `revisionNo` FROM `siow` WHERE iowId=$rowI[iowId]";
			$siowQ=mysqli_query($db,$siowSql);
			echo "<h5>Preventive siow found: ".mysqli_affected_rows($db)."</h5>";
			echo "$siowSql <br><br>";
			while($siowRow=mysqli_fetch_array($siowQ)){
				$siow="insert into siow (`siowPcode`, `iowId`, `siowCode`, `siowName`, `siowQty`, `siowUnit`, `analysis`, `siowDate`, `siowSdate`, `siowCdate`, `revisionNo`) values
('$siowRow[siowPcode]','$siowRow[iowId]','$siowRow[siowCode]','$siowRow[siowName]','$siowRow[siowQty]','$siowRow[siowUnit]','$siowRow[analysis]','$siowRow[siowDate]','$siowRow[siowSdate]','$siowRow[siowCdate]','$siowRow[revisionNo]')";
			echo "<h6>Preventive new siow inserted: ".mysqli_affected_rows($db)."</h6>";
				echo "$siow <br><br>";
// 				mysqli_query($siow);
				
// 			resources dma
				$dmaSql="SELECT `dmaProjectCode`, `dmaiow`, `dmasiow`, `dmaItemCode`, `dmaQty`, `dmaRate`, `dmaVid`, `dmaDate`, `dmaType`, `revisionNo` FROM `dma` WHERE dmasiow='$siowRow[siowId]'";
				$dmaQ=mysqli_query($db,$dmaSql);
				echo "<h6>Preventive dma found: ".mysqli_affected_rows($db)."</h6>";
				echo "$dmaSql <br><br>";
				while($dmaRow=mysqli_fetch_array($dmaQ)){
					$dmaiow="insert into dma (`dmaProjectCode`, `dmaiow`, `dmasiow`, `dmaItemCode`, `dmaQty`, `dmaRate`, `dmaVid`, `dmaDate`, `dmaType`, `revisionNo`) values ('$dmaRow[dmaProjectCode]','$dmaRow[dmaiow]','$dmaRow[dmasiow]','$dmaRow[dmaItemCode]','$dmaRow[dmaQty]','$dmaRow[dmaRate]','$dmaRow[dmaVid]','$dmaRow[dmaDate]','$dmaRow[dmaType]','$dmaRow[revisionNo]')";
					//mysqli_query($dmaiow);
					echo "<h6>Preventive dma inserted: ".mysqli_affected_rows($db)."</h6>";
					echo "$dmaiow <br><br>";
					
				}
			}
		} // eq while
	} //iow while
}

function equipmentChangeCondition($eqID, $itemCode, $eqCondition){
	global $db;
	if(!$eqID || !$itemCode || !$eqCondition)return false;
	
	$eqConditionCode=eqConditionChecker($eqCondition,null);
	
	$sql="update equipment set `condition`='$eqConditionCode' where assetId='$eqID' and itemCode='$itemCode'";
	mysqli_query($db,$sql);
	return mysqli_affected_rows($db)>0 ? true : false;
}

function isEquipmentAsset($eqID,$itemCode){ //is bfew owner of this equipment
	global $db;
	$sql="select count(*) as rows from equipment where assetId='$eqID' and itemCode='$itemCode'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row["rows"] > 0 ? true : false;
}


function short2longEqCondition($sortByC){
	switch($sortByC){
		case "r":
			$typeTxt=array("1"=>"running");
			break;
		case "b":
			$typeTxt=array("3"=>"breakdown");
			break;
		case "tr":
			$typeTxt=array("9"=>"troubledRunning");
			break;
		case "p":
			$typeTxt=array("2"=>"preventive");
			break;
		case "u":
			$typeTxt=array("4"=>"unrepairable");
			break;
	}
	return $typeTxt;
}

function short2longEqConditionOld($sortByC){
	switch($sortByC){
		case "r":
			$typeTxt=array("1"=>"running");
			break;
		case "m":
			$typeTxt=array("3"=>"breakdown");
			break;
		case "tr":
			$typeTxt=array("9"=>"troubledRunning");
			break;
		case "p":
			$typeTxt=array("2"=>"preventive");
			break;
		case "u":
			$typeTxt=array("4"=>"unrepairable");
			break;
	}
	return $typeTxt;
}



function getEquipmentConditions($code=false,$oneDimension=false,$fullText=false){
	if($code && !$fullText)
		return array('1'=> 'running','2'=> 'periodicMaintenence',
	'3'=> 'breakdown','4'=> 'unrepairable',
	'5'=> 'new','6'=> 'Re-conditioned','7'=> 'used','8'=> 'sold','9'=> 'troubledRunning'
	);
	elseif($code && $fullText)
	return array('1'=> 'Running','2'=> 'Periodic Maintenence',
	'3'=> 'Breakdown','4'=> 'Unrepairable',
	'5'=> 'New','6'=> 'Re-conditioned','7'=> 'Used','8'=> 'Sold','9'=> 'Troubled Running'
	);
	
	if($oneDimension)
			return array("running","idle","breakdown","troubledRunning");
	
	return array("running"=>"Running","idle"=>"Idle","breakdown"=>"Breakdown","troubledRunning"=>"Troubled Running");
}

function findAllProjectEquipment($eqID,$itemCode,$foundOnly=false,$projectCode="004"){
	global $db;
	$sql="select * from equipment where assetID='$eqID' and itemCode='$itemCode'";
	$q=mysqli_query($db,$sql);
	if($foundOnly)return mysqli_affected_rows($db)>0 ? true : false;
	return mysqli_fetch_array($q);
}


function getEquipmentCurrentFrequency($eqID,$itemCode){
	global $db;
	$sql="";
}

function getEquipmentCurrentConsumption($eqID,$itemCode){
	global $db;
	foreach(getAllProjectCode() as $pcode){
		if($pcode[0])
			$sql="select * from equipment where location='$pcode[0]'";
	}
}


function allMaintenanceItem($maintenanceType=null){
	$posP=["888.001.000.000","888.002.000.000","888.003.000.000","888.004.000.000"];
	if($maintenanceType=="all")return $posP;
	
	if($maintenanceType=="b")
		return $posP[0];
	elseif($maintenanceType=="o")
		return $posP[1];
	elseif($maintenanceType=="p")
		return $posP[2];
	elseif($maintenanceType=="tr")
		return $posP[3];	
}

function getEqDetailsByItemCode($itemCode){
	global $db;
	$sql="select * from equipment where itemCode='$itemCode' limit 1";
	$q=mysqli_query($db,$sql);
	while($row=mysqli_fetch_array($q)){
		return $row;
		break;
	}
	return false;
}

function getEqDetailsByEQID($itemCode,$eqID){
	global $db;
	$sql="select * from equipment where itemCode='$itemCode' and assetId='$eqID' limit 1";
	$q=mysqli_query($db,$sql);
	while($row=mysqli_fetch_array($q)){
		return $row;
		break;
	}
	return false;
}

function getEqDetailsByDate($eqID,$itemCode,$edate){
	global $db;
	$sql="select details from equt where eqId='$eqID' and itemCode='$itemCode' and edate='$edate' and iow='-1' and siow='-1' ";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row;
}

function eqAttendanceStatus($eqID,$itemCode){
	global $db;
	if(strpos($eqID,"R")>0)return false;
	$sql="select count(*) as rows from eqattendance where eqID='$eqID' and  itemCode='$itemCode' and solved!='1' and type='maintenance'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row[rows];
}

function checkIsIOWavailable2start($iowID,$pcode){
	if(!$iowID || !$pcode)return false;
	global $db;
// issue
	$sql="select count(*) as rows from issue$pcode where iowId='$iowID'";
	$q=mysqli_query($db,$sql);
	$rowIssue=mysqli_fetch_array($q)[rows];
	if($rowIssue)return false;
	
// subut
	$sql="select count(*) as rows from subut where iow='$iowID' and pcode='$pcode'";
	$q=mysqli_query($db,$sql);
	$rowSubut=mysqli_fetch_array($q)[rows];
	if($rowSubut)return false;
	
//equt
	$sql="select count(*) as rows from equt where iow='$iowID' and pcode='$pcode'";
	$q=mysqli_query($db,$sql);
	$rowEqut=mysqli_fetch_array($q)[rows];
	if($rowEqut)return false;	
	
	return true;
}


function generateNewPosition($headPosition,$pcode){
	global $db;
	$theDot=count_dot_number($headPosition);
	$thePos=position_dot_exploder($headPosition);
	$sqlPosition=sql_position_maker($headPosition);
	$sql="select position from iowtemp where position!='$headPosition' and iowProjectCode='$pcode' and position!='' and position like '$sqlPosition' order by position desc limit 1";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	
	$sqlN="select position from iow where position!='$headPosition' and iowProjectCode='$pcode' and position!='' and position like '$sqlPosition' order by position desc limit 1";
	$qN=mysqli_query($db,$sqlN);
	$rowN=mysqli_fetch_array($qN);
	$row[position]=$row[position] >= $rowN[position] ? $row[position] : $rowN[position];
	
	$lastPosition=position_dot_exploder($row[position]);
	$incrementPos=position_number_format_reverse($lastPosition[$theDot]+1);	
	return positionMakerByReplace($headPosition,$incrementPos,$theDot);	
}



function positionExploder($currentPosition){
	return $positionArray=explode(".",$currentPosition);
}



function getEQmaintenanceAge($edate){
	global $db;
}


function getEqLocalUnit($itemCode){
	global $db;
	$sql="select measureUnit,count(*) as rows from eqconsumsion where eqitemCode='$itemCode' group by measureUnit";
// 	echo $sql;
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	if($row[measureUnit]>1){echo "Error in equipment measure unit.";exit;}
	return $row[measureUnit];
}




/* return equipment total group value*/
function groupValue($d){
 global $db; 
 $sql="SELECT SUM(price) as total FROM `equipment` WHERE itemCode = '$d'";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $totalRate = $rr[total];
 return $totalRate;
 }

function getXdaysAgoDate($toDate,$range){
	if($toDate && $range)
	return $theDate=date("Y-m-d",(strtotime($toDate)-(86400*$range))); //X day ago
}

function get_machine_km_hr($toDate,$range,$pcode,$itemCode,$eqID,$rateMode=false){
	global $db;
	$fromDate=getXdaysAgoDate($toDate,$range);
	$extraSql=" issueDate between '$fromDate' and '$toDate'";
	$lastExtra=" and eqID='$eqID"."_"."$itemCode'";
	
	$fuelRow=item2itemCode4Eq(null,null,null,null,true); //get all fuel itemcodes
	$listedItemCodeSql=" and itemCode in (".implode(",",$fuelRow).") ";
	
	// Total issued from range
	$sql="select sum(issuedQty) as issuedQty,sum(issueRate) as issueRate from issue$pcode where $extraSql $lastExtra $listedItemCodeSql";
// 	echo $sql;
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	$issedQty=$row[issuedQty];
	$issueRate=$row[issueRate];
	
	// Total km from range max
	$sqlk_max="SELECT km_h_qty,issueDate FROM issue$pcode where $extraSql $lastExtra $listedItemCodeSql order by issueDate desc limit 1";
// 	echo $sqlk_max;
	$qk_max=mysqli_query($db,$sqlk_max);
	$rowk_max=mysqli_fetch_array($qk_max);
// 	print_r($rowk_max);
		
	// Total km from range min
	$sqlk_min="SELECT km_h_qty,issueDate FROM issue$pcode where $extraSql $lastExtra $listedItemCodeSql order by issueDate asc limit 1";
// 	echo $sqlk_min;
	$qk_min=mysqli_query($db,$sqlk_min);
	$rowk_min=mysqli_fetch_array($qk_min);
// 	print_r($rowk_min);
	
// 	echo $difference="$rowk_max[km_h_qty]-$rowk_min[km_h_qty]";
// 	if($rowk_max[km_h_qty]==$rowk_min[km_h_qty])
// 		$rowk_min[km_h_qty]=getStartupReading($eqID,$itemCode);
// 	echo $issueRate."<br>";
// 	echo $issedQty."<br>";
  
	$difference=$rowk_max[km_h_qty]-$rowk_min[km_h_qty];
// 	echo "//$rowk_max[km_h_qty]-$rowk_min[km_h_qty]>dif=$difference//isQty=$issedQty";
//   echo round($issedQty/$difference,2);
  
	if($rateMode)
		return round($issueRate/$difference,2);	
	else
		return round($issedQty/$difference,2);	
}


function getEqAccConsumtion($toDate,$range,$itemCode,$eqID,$type="km"){
	global $db;
	$fromDate=getXdaysAgoDate($toDate,$range);
	$extraSql=" edate between '$fromDate' and '$toDate'";
	$lastExtra=" and eqID='$eqID' and eqItemCode='$itemCode'";
	
	$sql="select max(km)-min(km) as differ,sum(amount) as amount from accEqConsumption where $extraSql $lastExtra";
// 	echo $sql;
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
// print_r($row);
	if($type=="ue"){
		$sql="select SUM(ABS(60+TIME_TO_SEC(etime)-TIME_TO_SEC(stime)))/3600 as duration from equt where eqId='$eqID' and itemCode='$itemCode' and edate between '$fromDate' and '$toDate'";
// 		echo $sql;
		$q1=mysqli_query($db,$sql);
		$row1=mysqli_fetch_array($q1);
		return round($row["amount"]/$row1["duration"],2);
	}elseif($type=="km" || $type=="mh"){
		return round($row["amount"]/$row["differ"],2);
	}
}


/*
input todate, from
output hour of ut
*/
function get_erp_per_hr_ltr($eqID,$itemCode,$toDate,$range,$pcode,$rateMode=false){
	global $db;
	$fromDate=getXdaysAgoDate($toDate,$range);
	$extraSql=" issueDate between '$fromDate' and '$toDate'";
	$lastExtra=" and eqID='$eqID"."_"."$itemCode'";
	
	$fuelRow=item2itemCode4Eq(null,null,null,null,true); //get all fuel itemcodes
	$listedItemCodeSql=" and itemCode in (".implode(",",$fuelRow).") ";
	
	// Total issued from range
	$sql="select sum(issuedQty) as issuedQty,sum(issueRate) as issueRate from issue$pcode where $extraSql $lastExtra $listedItemCodeSql";
// 	echo $sql;
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	$issedQty=$row[issuedQty];
	$issueRate=$row[issueRate];
	
	
	$sql="select SUM(ABS(60+TIME_TO_SEC(etime)-TIME_TO_SEC(stime)))/3600 as duration from equt where eqId='$eqID' and itemCode='$itemCode' and edate between '$fromDate' and '$toDate'";
// 	echo $sql;
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	
	$difference=$issedQty/$row["duration"];
	
	if($rateMode)
		$difference=$issueRate/$row["duration"];	
	else
		$difference=$issedQty/$row["duration"];
	
// 	echo $issedQty."/$row[duration]<br>";
	
	return $difference ? round($difference,2) : 0.00 ;
}


function getTheMeasureRow($eqID,$itemCode,$edate,$pcode,$col=null){
	global $db;
	if(!$col)
		$sql="select * from issue$pcode where eqID='$eqID"."_"."$itemCode' and issueDate='$edate'";
	else	
		$sql="select $col from issue$pcode where eqID='$eqID"."_"."$itemCode' and issueDate='$edate'";
// 	echo $sql;
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	if(!$col)return $row;
	else return $row[$col];
}


function getStartupReading($eqID,$itemCode){
	global $db;
	global $SESS_DBNAME;
	if(!$eqID || !$itemCode){echo $eqID.$itemCode;return false;}
	$sql="select startup from equipment where assetId='".trim($eqID)."' and itemCode='".trim($itemCode)."' ";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	$fastIssuedQty=$row[startup];
	if(!$fastIssuedQty){
		$sql="select km from accEqConsumption where eqID='".trim($eqID)."' and eqItemCode='".trim($itemCode)."' having min(edate) ";
		$q1=mysqli_query($db,$sql);
		$row1=mysqli_fetch_array($q1);
		if($row1[km]<$fastIssuedQty || $fastIssuedQty<=0){
			$fastIssuedQty=$row1[km];
		}
		$columnName="Tables_in_".$SESS_DBNAME;
		$tableSql="show tables where $columnName like 'issue2%'";
		$tableQ=mysqli_query($db,$tableSql);
		while($tableRow=mysqli_fetch_array($tableQ)){
			$sql="select km_h_qty,issueDate from $tableRow[$columnName] where eqID='".trim($eqID)."_".trim($itemCode)."' having min(issueDate)";
			$q2=mysqli_query($db,$sql);
			$row2=mysqli_fetch_array($q2);
			if(($row2[km_h_qty]<$fastIssuedQty || $fastIssuedQty<=0) && $row2[km_h_qty]>0){
				$fastIssuedQty=$row2[km_h_qty];
			}
		}
	}
	return $fastIssuedQty>0 ? $fastIssuedQty : 0;
}



function getUsageofEQ($itemCode,$eqID,$edate){
	global $db;
// 	total usage without break
	$sql="select sum(((time_to_sec(etime)-time_to_sec(stime))+60)/3600) as total,etime,stime from equt where itemCode='".trim($itemCode)."' and edate<='$edate' and iow>0 and eqId='".trim($eqID)."'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
// 	break info
	$bsql="select sum(((time_to_sec(etime)-time_to_sec(stime))+60)/3600) as total,etime,stime from equt where itemCode='$itemCode' and edate<='$edate' and iow<=0 and eqId='$eqID'";
	$bq=mysqli_query($db,$bsql);
	$brow=mysqli_fetch_array($bq);
	
	if(($row[total]-$brow[total])>0){
		$sec=($row[total]-$brow[total]);
		return sec2hms($sec,true);
	}else 0;	
}


?>


<?php

function eqReceiveQty($posl,$itemCode){
	global $db;
	$sql="select count(*) as totalReceived from equipment where reference='$posl' and itemCode='$itemCode'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row[totalReceived];
}


function eqRemainQty1($posl,$itemCode){
	global $db;
	$sql="select count(*) as totalReceived from equipment where reference='$posl' and itemCode='$itemCode'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	
	$psql="select sum(qty) as totalQty from porder where posl='$posl' and itemCode='$itemCode'";
	$pq=mysqli_query($db,$psql);
	$prow=mysqli_fetch_array($pq);
	
	return $prow[totalQty]-$row[totalReceived];
}


?>


<? 
/* total equipment value*/ 
function allEquipmetValue(){
	global $db; 
 $sql="SELECT SUM(price) as total FROM `equipment` ";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $totalRate = $rr[total];
 return $totalRate;
 }
?>

<? 
function getLastQty($pcode,$eqID,$itemCode){
	global $db;
	$sql="select issuedQty from issue$pcode where eqID='".trim($eqID)."' and itemCode='".trim($itemCode)."'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row[issuedQty]>0 ? $row[issuedQty] : "0";
}



/* return total utilization of given equipment*/
function eqTodayWork($asId,$itemCode,$dat){
	global $db; 
 $sql="SELECT SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime))) as duration FROM `equt` WHERE assetId LIKE '$asId' AND itemCode='$itemCode' AND iow<>'' AND edate='$dat' GROUP by edate";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $totalRate = $rr[duration];
 return abs($totalRate);
 }
?>
<? 
function eqTodayWorksiow($itemCode,$dat,$siow){
 include("config.inc.php");
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

 $sql="SELECT SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime))+60) as duration FROM `equt` WHERE itemCode = '$itemCode' AND siow='$siow' AND edate='$dat' GROUP by edate";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $duration = $rr[duration];
 return abs($duration);
 }
?>

<? 
function eqBreakBown($asId,$itemCode,$dat){

 include("config.inc.php");
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

 $sql="SELECT SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime))) as duration FROM `equt` WHERE eqId LIKE '$asId' AND itemCode = '$itemCode'AND iow='' AND edate='$dat' GROUP by edate";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $totalRate = $rr[duration];
 return abs($totalRate);
 }
?>

<? 
function eqTotalWorkhr($asId,$itemCode,$dat){
 global $db; 
 if(!$asId || !$itemCode || !$dat)return false;
 $sql="SELECT * FROM `eqproject` WHERE assetId ='$asId' AND itemCode='$itemCode' AND status='1' ORDER by id";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $sdate = $rr[sdate];
 $sql="SELECT SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime))) as duration FROM `equt` WHERE eqId ='$asId' AND itemCode ='$itemCode' AND iow<>'' AND edate BETWEEN '$sdate' AND '$dat'";
// echo $sql;
	
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $totalRate = $rr[duration];
 return abs($totalRate);
 }

?>
<? 
function empTotalWorkhrsiow($itemCode,$dat,$siow){

 include("config.inc.php");
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

 $sql="SELECT SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime))+60) as duration FROM `emput`".
	 " WHERE designation ='$itemCode' AND siow='$siow' ";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $totalRate = $rr[duration];
 return abs($totalRate);

 }
?>



<? 
function eqTotalBreakhr($asId,$itemCode,$dat){

 include("config.inc.php");
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

 $sql="SELECT * FROM `eqproject` WHERE assetId LIKE '$asId' AND status='1' ORDER by id";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $sdate = $rr[sdate];

 include("config.inc.php");
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

 $sql="SELECT SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime))) as duration FROM `equt` WHERE assetId = '$asId' AND itemCode ='$itemCode' AND iow='' AND edate BETWEEN '$sdate' AND '$dat'";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $totalRate = abs($rr[duration]);
 return abs($totalRate);

 }
?>

<? 
function eqDuration($asId,$itemCode,$dat){
global $db;	 

 $sql="SELECT (to_days('$dat')-to_days(sdate)) as totalDays FROM `eqproject` WHERE assetId='$asId' AND itemCode='$itemCode' AND status='1' ";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);

 $estimatedHr=($rr[totalDays]+1)*8*3600;
 return $estimatedHr;
 }
?>



<? 
function eq_perdayPl_req($project,$itemCode,$edat1){
	global $db; 
$sqls = "SELECT * from `dma` WHERE dmaProjectCode='$project' AND dmaItemCode ='$itemCode' ORDER by dmasiow ASC ";
//echo $sqls;
$sql1=mysqli_query($db, $sqls); 
while($dmar=mysqli_fetch_array($sql1)){
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
global $db; 
$sql="SELECT SUM(60+ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime))) as duration FROM `equt` 
WHERE itemCode ='$itemCode' AND pcode='$project' AND iow <> '0' ";
if($t==1) $sql.=" AND edate = '$dat'";
if($t==2) $sql.=" AND edate <= '$dat'";
//echo $sql.'<br>';
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $totalQty = $rr[duration];
 return abs($totalQty);

}

?>
<? 
function eq_toDaypresent_total($project,$itemCode,$edate){
 include("config.inc.php");
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

$sql="select (SUM(60+ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)))) as duration
	from eqattendance
	WHERE location='$project' AND itemCode= '$itemCode' AND edate='$edate' ";
//echo '<br>'.$sql.'<br>';
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 return $rr[duration];
}
?>

<? 
function eqTotalWorkhrsiow($itemCode,$dat,$siow,$exactDate=false){
 include("config.inc.php");
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

 $sql="SELECT SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime))+60) as duration FROM `equt` WHERE".
 " itemCode ='$itemCode' AND siow='$siow'";
	if($exactDate==false)$sql.=" AND edate <= '$dat'";
	elseif($exactDate==true)$sql.=" AND edate = '$dat'";
// echo $sql.'<br>';
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $totalRate = $rr[duration];
 return abs($totalRate);

 }
?>
<? 
function eqTotalWorkhriow($itemCode,$dat,$iow){
 include("config.inc.php");
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

 $sql="SELECT SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime))+60) as duration FROM `equt` WHERE".
 " itemCode ='$itemCode' AND iow='$iow' AND edate <= '$dat'";
// echo $sql.'<br>';
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $totalRate=$rr[duration];
 return abs($totalRate);

 }
?>
<? 
function findQuotation($posl,$itemCode){
	global $db;
	$sql="select qid from porderHelper where posl='$posl' and itemCode='$itemCode'";
	$q=mysqli_query($db,$sql);
	if(mysqli_affected_rows($db)<1){
		$exp=explode("_",$posl);
		return getLastQuotation($itemCode,$exp[1]);
	}
	$row=mysqli_fetch_array($q);	
	return $row[qid];
}


function getLastQuotation($itemCode,$pcode){
	global $db;
	$sql="select qid from quotation where itemCode='$itemCode' and pCode='$pcode' order by qid desc";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row[qid];
}

function eqP_qtyDes($sitemCode,$vid,$posl=null){
	if(!$posl){echo "<h1>Quotation problem, please contact with procurement officer.</h1>";exit;}
	global $db;

$qid=findQuotation($posl,$sitemCode);

$sql="SELECT quotation.*,eqquotation.* FROM quotation,eqquotation
 where quotation.itemCode='$sitemCode' AND quotation.qid=eqquotation.qid AND quotation.vid=$vid";
if($qid)
	$sql.=" and quotation.qid='$qid'";
// echo "$sql<br>";
$sqlq=mysqli_query($db, $sql);
$re=mysqli_fetch_array($sqlq);

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
$sqlq=mysqli_query($db, $sql);
while($r=mysqli_fetch_array($sqlq)){
	$sql2="select (SUM(60+ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)))) as duration
	from equt
	WHERE  posl='$r[posl]' AND itemCode='$r[itemCode]' AND 
	pcode ='$pcode' GROUP by itemCode,posl  ";
	//echo "$sql2<br>";
	$sqlq2=mysqli_query($db, $sql2);
	$re=mysqli_fetch_array($sqlq2);
	$actualPresent=($r[duration]-$re[duration]);
	$rate=eqpoRate($r[itemCode],$r[posl]);
	$amount+=$actualPresent*$rate;
	//echo "actualPresent=$actualPresent<br>";

}
	return $amount;
}
*/

 function eqpoActualReceiveAmount($posl){global $db; 
$p=explode('_',$posl);
$pcode=$p[1];

	$sql="select COUNT(*) As totalPresent,itemCode,posl from eqattendance
	WHERE posl='$posl' AND	location ='$pcode' GROUP by itemCode ";
	//echo "$sql<br>";
$sqlq=mysqli_query($db, $sql);
while($r=mysqli_fetch_array($sqlq)){

	$rate=eqpoRate($r[itemCode],$r[posl]);
	$amount+=$r[totalPresent]*$rate;
	//echo "<br>$r[itemCode]==$r[totalPresent]*$rate<br>";

}
	return $amount;
}
 function eqpoActualReceiveAmountItemCode($posl,$itemCode){
	 global $db; 
$p=explode('_',$posl);
$pcode=$p[1];

	$sql="select COUNT(*) As totalPresent,posl from eqattendance
	WHERE posl='$posl' AND	location ='$pcode' and itemCode='$itemCode' GROUP by itemCode ";
	//echo "$sql<br>";
$sqlq=mysqli_query($db, $sql);
$r=mysqli_fetch_array($sqlq);

	$rate=eqpoRate($itemCode,$r[posl]);
	$amount=$r[totalPresent]*$rate;
	//echo "<br>$r[itemCode]==$r[totalPresent]*$rate<br>";
	return $amount;
}
?>
<? 
function eqpoActualReceiveAmount_date($posl,$fromdate,$todate){
	global $db;
	$sql="select COUNT(*) As totalPresent,itemCode,posl from eqattendance
	WHERE posl='$posl' AND edate >='$fromdate' AND edate <'$todate' GROUP by itemCode ";
// echo "$sql<br>";
$sqlq=mysqli_query($db, $sql);
while($r=mysqli_fetch_array($sqlq)){

	$rate=eqpoRate($r[itemCode],$r[posl]);
	$amount+=$r[totalPresent]*$rate;
// 	echo "$r[totalPresent]*$rate<br>";
}
	return $amount;
}


function getEquipmentRow($eqID,$itemCode){
	global $db;
	$sql="select * from equipment where assetId='$eqID' and itemCode='$itemCode'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row;
}


?>

<? function eqActualReceiveAmount($sDate,$inDate,$rate,$posl,$itemCode,$project){global $db; 
$pcode=$project;
$from=$sDate;
$to=$inDate;

	$sql="select itemCode,posl,
	(SUM(60+ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)))) as duration
	from eqattendance
	WHERE posl='$posl' AND edate between '$from' and '$to' AND itemCode='$itemCode' AND 
	location ='$pcode' GROUP by itemCode,posl  ";
$sqlq=mysqli_query($db, $sql);
while($r=mysqli_fetch_array($sqlq)){
	$sql2="select (SUM(60+ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)))) as duration
	from equt
	WHERE edate between '$from' and '$to' 
	AND posl='$r[posl]' AND itemCode='$r[itemCode]' 
	AND pcode ='$pcode' GROUP by itemCode,posl  ";
	//echo "$sql2<br>";
	$sqlq2=mysqli_query($db, $sql2);
	$re=mysqli_fetch_array($sqlq2);
	$actualPresent=($r[duration]-$re[duration]);
	$rate=eqpoRate($r[itemCode],$r[posl]);
	$amount+=$actualPresent*$rate;
	//echo "actualPresent=$actualPresent<br>";

}
	return $amount;
}?>

<?
function eq_autoAttendance($todat,$keyDate){global $db; 

$duration= (strtotime($todat)-strtotime($keyDate))/86400;

$sql="SELECT * FROM eqproject where status='1'";
$sqlq=mysqli_query($db, $sql);
while($re=mysqli_fetch_array($sqlq)){

for($i=0;$i<=$duration;$i++){	 
$edat=date("Y-m-d",strtotime($keyDate)+(86400*$i));
$eq_planReceiveDate=eq_planReceiveDate($re[posl],$re[itemCode]);

if(strtotime($edat)>=strtotime($eq_planReceiveDate)){	

$sql4="select action from eqattendance where eqId='$re[assetId]' AND itemCode='$re[itemCode]' and posl='$re[posl]' order by edate DESC";
$sqlq4=mysqli_query($db, $sql4);
$ro4=mysqli_affected_rows();	
if($ro4>0){$r4=mysqli_fetch_array($sqlq4);$action=$r4[action];} else $action='P';

 $sql="INSERT INTO eqattendance(`id` , `eqId`,itemCode, `edate` ,`action` , `stime` , `etime` , `todat` , `location`,posl )
 VALUES ('', '$re[assetId]','$re[itemCode]', '$edat', '$action', '09:00:00','17:59:00','$todat','$re[pCode]','$re[posl]' )";

//echo $sql.'<br>';
	$sqlq1=mysqli_query($db, $sql);
$ro=mysqli_affected_rows();	
if($ro=='1')
 {	
	$sql2 = "INSERT INTO `equt` ( `id` , `eqId` ,`itemCode`, `iow` , `siow` ,
	 `stime` , `etime` , `details` , `edate`,pcode,posl ) 
	 VALUES ('', '$re[assetId]','$re[itemCode]', '', '', 
	'13:00', '13:59', 'Lunch', '$edat','$re[pCode]','$re[posl]')";
	//echo $sql2.'<br>';
	$sqlq2=mysqli_query($db, $sql2);
	}//if ro
    }//if
   }//for
 }//while

}

?>

<?
function eq_perdayRequired($siow,$itemCode,$dat,$pp){global $db; 
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
function eq_force_dispatch($todat){global $db; 

$sql="SELECT * FROM eqproject where status=1";
//echo "<br> $sql<br>";
$sqlq=mysqli_query($db, $sql);
putenv ('TZ=Asia/Dacca'); 
while($eq=mysqli_fetch_array($sqlq)){
	$planDispatchDate=planDispatchDate($eq[posl],$eq[itemCode]);
    if(strtotime($todat)>=strtotime($planDispatchDate))
		{
		$sqlp = "UPDATE `eqproject` set edate='$planDispatchDate',status='2' WHERE id='$eq[id]'";
		//echo $planDispatchDate.'=='.$sqlp.'<br>';
		mysqli_query($db, $sqlp);
		}
		
	  }//while
}

?>
<?
function eq_planReceiveDate($posl,$itemCode){global $db; 
$sql="select dstart from porder where posl='$posl' and itemCode='$itemCode' ";
//echo $sql.'<br>';
$sqlq=mysqli_query($db, $sql);
$sqlr=mysqli_fetch_array($sqlq);
return $sqlr[dstart];
}
?>

<?
function planDispatchDate($posl,$itemCode){global $db; 
$sql="select sdate from poschedule where posl='$posl' and itemCode='$itemCode'";
//echo $sql.'<br>';
$sqlq=mysqli_query($db, $sql);
$sqlr=mysqli_fetch_array($sqlq);
return $sqlr[sdate];
}
?>

<? /* total worked in SIOW human */
function eqExTime($eqId,$itemCode,$eqType,$edate){global $db; 

 include("config.inc.php");
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

$sql="SELECT HOUR(stime) as eh,MINUTE(stime) as em,HOUR(etime) as xh,MINUTE(etime) as xm FROM `eqattendance`".
 " WHERE eqId= '$eqId' AND itemCode= '$itemCode' AND edate='$edate'";

//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
if($rr[eh]<10) $rr[eh]="0$rr[eh]";
if($rr[em]<10) $rr[em]="0$rr[em]";
$eqTime= array("eh"=>$rr[eh],"em"=>$rr[em],'xh'=>$rr[xh],'xm'=>$rr[xm]);
	 return $eqTime; 
 }
?>

<?
function eqTotalPresentHr($fromd,$tod,$eqId,$itemCode,$type,$project){global $db; 
$sql="SELECT count(*) as totalPresent from eqattendance WHERE
 eqId='$eqId' AND itemCode='$itemCode' AND location='$project'";
//echo $sql;
$sqlq=mysqli_query($db, $sql);
$sqlf=mysqli_fetch_array($sqlq);
return $sqlf[totalPresent];
}
?>
<?
function eqMonthlyPresentHr($fromd,$eqId,$itemCode,$project,$posl){
global $db; 
$sql="SELECT SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as totalPresent from eqattendance WHERE
 eqId like '$eqId' and edate like '$fromd%' AND itemCode like '$itemCode' AND location='$project' and posl='$posl'";
// echo $sql;
$sqlq=mysqli_query($db, $sql);
$sqlf=mysqli_fetch_array($sqlq);
$eqRate=eqpoRate($itemCode,$posl);
return ($sqlf[totalPresent]/3600)*($eqRate/8);
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
	 
/*
 $sql="SELECT * FROM `equt` WHERE eqId='$asId' AND itemCode='$itemCode' 
 AND edate='$dat' AND ((TIME_TO_SEC('$t1') between TIME_TO_SEC(stime) AND TIME_TO_SEC(etime)) 
  OR (TIME_TO_SEC(stime)<= TIME_TO_SEC('$t1') AND TIME_TO_SEC(etime) >= TIME_TO_SEC('$t1'))) ORDER by id "
  */
   $sql="SELECT * FROM `equt` WHERE eqId='$asId' AND itemCode='$itemCode'
  AND edate='$dat' AND ((TIME_TO_SEC(stime) BETWEEN TIME_TO_SEC('$t1') AND TIME_TO_SEC('$t2')) 
  OR (TIME_TO_SEC(stime)<= TIME_TO_SEC('$t1') AND TIME_TO_SEC(etime) >= TIME_TO_SEC('$t1'))) ORDER by id ";
// echo $sql.'<br>';
 $sqlQuery=mysqli_query($db, $sql);
$num_rows = mysqli_num_rows($sqlQuery);
//echo "<br>num_rows: $num_rows<br>";
if($num_rows>=1) return 1;
 else return 0;
 }
?>
<? 
function eq_RemainHr($itemCode,$iow,$siow){
//if($iow==0 OR $siow==0) return 1;
 include("config.inc.php");
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

 $sql="SELECT dmaQty From dma where dmaiow='$iow' AND dmasiow='$siow' AND dmaItemCode='$itemCode'";
//echo $sql.'<br>';
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $dmaQty=$rr[dmaQty]*3600;
 //echo "dmaQty: $dmaQty---";

 $sql1="SELECT SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as duration".
 " FROM `equt` WHERE itemCode = '$itemCode' AND iow='$iow' AND siow='$siow'";
//echo $sql1.'<br>';
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
 " AND edate='$dat' GROUP by edate";


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
 " AND edate='$dat'  GROUP by edate";
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
global $db; 
 $sqlf = "SELECT * FROM `eqproject`";
//echo $sqlf.'<br>';
$sqlQ= mysqli_query($db, $sqlf);
$num_rows = mysqli_num_rows($sqlQ);
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
global $db; 
 $sqlf = "SELECT * FROM `eqattendance` WHERE eqId='$eqId' AND itemCode='$itemCode' AND edate='$df' AND action='P'";
//echo $sqlf.'<br>';
$sqlQ= mysqli_query($db, $sqlf);
$num_rows = mysqli_num_rows($sqlQ);
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
global $db; 
 $sqlf = "SELECT * FROM `eqattendance` WHERE eqId='$eqId' AND itemCode='$itemCode' AND edate='$df' AND action='HP'";
//echo $sqlf.'<br>';
$sqlQ= mysqli_query($db, $sqlf);
$num_rows = mysqli_num_rows($sqlQ);
 return $num_rows;
}
?>


<?php
function get_machine_last_km_hour($pcode,$itemCode,$assetId,$edate=null){
	$sql="select km_h_qty from issue$pcode where itemCode='$itemCode' and assetId='$assetId'";
	if($edate)$sql.=" and edate='$edate' ";
	$sql.=" order by edate desc limit 1";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row[km_h_qty];
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
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);	 

 $sql1="SELECT  SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as total from  `equt`".
 " where  eqId ='$eqId' AND itemCode='$itemCode'  AND edate ='$d' AND pcode=$pcode AND iow>='1' ";
// echo $sql1;
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

function eq_dailyworkTotal($eqId,$itemCode,$d,$d1,$eqType,$pcode){
$work=0;
 include("config.inc.php");
 //include("session.inc.php"); 
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

 $sql1="SELECT  SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as total from  `equt`".
 " where  eqId ='$eqId' AND itemCode='$itemCode'  AND edate between '$d' and '$d1' AND pcode=$pcode AND iow>='1' ";
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
	 

$sql="select (SUM(60+ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)))) as duration
	from eqattendance
	WHERE eqId= '$eqId' AND itemCode= '$itemCode' AND edate='$edate' ";
// echo '<br>'.$sql.'<br>';
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
//	print_r($rr);
 return $rr[duration];
}
?>
<? 
function eq_toDaypresent1($eqId,$itemCode,$fromDate,$toDate,$eqType,$pcode){
 include("config.inc.php");
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

 $sql="select (SUM(60+ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)))) as duration
	from eqattendance
	WHERE eqId= '$eqId' AND itemCode= '$itemCode' AND edate between '$fromDate' and '$toDate'";
//echo '<br>'.$sql.'<br>';
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 return $rr[duration];
}
?>

<? 
function new_eq_toDaypresent($over1,$over2,$over3,$over4){
global $db; 
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
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

 $sql1="SELECT  SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as total from  `equt`".
 " where  eqId ='$eqId' AND itemCode='$itemCode' AND edate ='$d' AND pcode=$pcode AND iow='0' AND siow='0' ";
//echo '<br>'.$sql1.'<br>';
 $sqlQuery1=mysqli_query($db, $sql1);
 $remainQty1=mysqli_fetch_array($sqlQuery1);
  if($remainQty1[total]) 
 $work= $remainQty1[total];

 return $work;
}


function eq_monthlyWorkBreak($eqId="%",$itemCode="%",$d,$pcode,$posl){
$work=0;
include("config.inc.php");
//include("session.inc.php"); 
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);	 

$sql1="SELECT  SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as total,edate,itemCode,eqId from  `equt`".
 " where  eqId like '$eqId' AND itemCode like '$itemCode' AND edate like '$d%' AND pcode=$pcode AND iow='-1' AND siow='-1' and posl='$posl' group by edate,itemCode,eqId ";
	
// if($d=="2016-11")
// 	echo '<br>'.$sql1.'<br>';
	
 $sqlQuery1=mysqli_query($db, $sql1);
	
	while($eqRow=mysqli_fetch_array($sqlQuery1)){
		if(($eqRow[total]/3600)<4)continue;
		$eqRate=eqpoRate($eqRow[itemCode],$posl);
	
		$work+=$eqRate;
// 	echo $d;
//  echo "=======". $data[$i][1]."========"; 
	}
// 	echo "$d==$work<br>";
	
 return $work;
}

function eq_monthlyWork($eqId="%",$itemCode="%",$d,$pcode,$posl){
$work=0;
include("config.inc.php");
 //include("session.inc.php"); 
$db=mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);	 

 $sql1="SELECT  SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as total,edate,itemCode,eqId from  `equt`".
 " where  eqId like '$eqId' AND itemCode like '$itemCode' AND edate like '$d%' AND pcode=$pcode AND iow>'1' AND siow>'1' and posl='$posl' group by edate,itemCode,eqId ";
	
// if($d=="2016-10")
// 	echo '<br>'.$sql1.'<br>';
	
 $sqlQuery1=mysqli_query($db, $sql1);
	
	while($eqRow=mysqli_fetch_array($sqlQuery1)){
		if(($eqRow[total]/3600)<4)continue;
		$eqRate=eqpoRate($eqRow[itemCode],$posl);
		$work+=($eqRate/8)*($eqRow[total]/3600);
// 	echo $d;
//  echo "=======". $data[$i][1]."========"; 
	}
// 	echo "$d==$work<br>";
 return $work;
}
?>

<?php
function getEqPresentRow($eqId,$itemCode,$d,$eqType,$pcode){
 include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

 $sql1="SELECT * from  `eqattendance`".
 " where  eqId ='$eqId' AND itemCode='$itemCode' AND edate ='$d' AND location=$pcode";
	$q=mysqli_query($db,$sql1);	
	return mysqli_fetch_array($q);
}

?>
<?php
function getUtilizationRow($eqId,$itemCode,$d,$eqType,$pcode){
 include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

 $sql1="SELECT * FROM equt WHERE eqId='$eqId' AND itemCode='$itemCode' AND edate ='$d' AND pcode=$pcode  and iow>0 and siow>0";
	
	$q=mysqli_query($db,$sql1);	
	while($row=mysqli_fetch_array($q)){
		$time[]=$row[stime]." - ". $row[etime];
	}
	return $time;
}

?>
<?php
function getEqWorkBreakRow($eqId,$itemCode,$d,$eqType,$pcode){
 include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

 $sql1="SELECT * from  `equt`".
 " where  eqId ='$eqId' AND itemCode='$itemCode' AND edate ='$d' AND pcode=$pcode AND iow='0' AND siow='0' ";
	$q=mysqli_query($db,$sql1);	
	return mysqli_fetch_array($q);
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
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

 $sql1="SELECT  SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as total from  `equt`".
 " where  eqId ='$eqId' AND itemCode='$itemCode'  AND edate between '$d' and '$d1' AND pcode=$pcode AND iow='0' AND siow='0' ";
//echo $sql1;
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
$work=0;
 include("config.inc.php");
 //include("session.inc.php"); 
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

 $sql1="SELECT  SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as total from  `equt`".
 " where  eqId ='$eqId' AND itemCode='$itemCode' AND edate ='$d' AND pcode=$pcode AND iow='-1' AND siow='-1' ";
//echo $sql1;
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

function eq_dailyBreakDownTotal($eqId,$itemCode,$d,$d1,$eqType,$pcode){
$work=0;
 include("config.inc.php");
 //include("session.inc.php"); 
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

 $sql1="SELECT  SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as total from  `equt`".
 " where  eqId ='$eqId' AND itemCode='$itemCode'  AND edate between '$d' and '$d1' AND pcode=$pcode AND iow='-1' AND siow='-1' ";
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
//  echo $sql;
 $sql=mysqli_query($db, $sql); 

 $pn=mysqli_fetch_array($sql);
 $cost=$pn[price];
 $salvageValue=$pn[salvageValue];
 $life=$pn[life];
 $days=$pn[days];
 $hours=$pn[hours];
 

if($cost AND $salvageValue AND $life AND $days AND $hours){
	$dep = ($cost-$salvageValue)/$life ; // as Straigth Line method
//Old rule change by suvro january_14_14
 /*         
	$rateY= $dep; // per Year
//	$rateD=number_format(6* ($rateY/365)); // per Day
	$rateD=6* ($rateY/365); // per Day
     */     
//end of old rule
          
          
          $rateY= $dep; // per Year
	$rateD=((6*($rateY/$days))/30); // old per Day
          
          
          
  
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
function eqorderQty($p,$itemCode){
$orderQtyf=0;
 include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 
$sqlf="SELECT poid,posl,SUM(qty) as orderQtyf,dstart from porder WHERE location='$p' and itemCode='$itemCode' GROUP by itemCode";
//echo '<br>'.$sqlf.'<br>';
 $sqlQueryf=mysqli_query($db, $sqlf);
 $sqlRunf=mysqli_fetch_array($sqlQueryf);
 if($sqlRunf){
 $orderQtyf=$sqlRunf[orderQtyf];
 $sdate = $sqlRunf[dstart];
 
$sqlp1 = "SELECT * from  `poschedule` WHERE posl='$sqlRunf[posl]' AND itemCode='$itemCode'";
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
	 

 $sql="SELECT quotation.*, vendor.vid from quotation,vendor where".
 " quotation.itemCode = '$eqCode'  AND quotation.vid= vendor.vid order by point ASC";
//  echo $sql;
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
$r=mysqli_num_rows($sqlf)+1;
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
<?
/* ---------------------------
  Input the hrCode Code
 return the designation and Name
-------------------------------*/

function eqpoRate($itemCode,$posl)
{
 include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

$sqlff="SELECT rate FROM porder where itemCode ='$itemCode' AND posl='$posl'";
//echo $sqlff;
$sqlf=mysqli_query($db, $sqlff);
$r=mysqli_fetch_array($sqlf);
// return $r[rate]/(8*3600);
 return $r[rate];
}
 ?>
 
<?
function eqType($eqId){
$intValue=ord($eqId{0});
// echo $intValue.">>".$eqId{0};
if($intValue>=65 AND $intValue<=122)
 return 'L';
else return 'H';
}
?>
<? 
/* return total equipment isued in a project*/
function total_eq_issueAmount_date($pcode,$from,$to){
	global $db; 
	$sql="select eqId,itemCode,posl,(SUM(60+ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)))) as duration
	from eqattendance
	WHERE edate between '$from' and '$to' AND
	location ='$pcode' GROUP by itemCode,posl  ";
//echo "<br>$sql<br>";	
$sqlq=mysqli_query($db, $sql);
while($r=mysqli_fetch_array($sqlq)){
$actualPresent=0;$rate=0;
	$sql2="select (SUM(60+ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)))) as duration
	from equt
	WHERE edate between '$from' and '$to' 
	AND posl='$r[posl]' 
	AND equt.itemCode='$r[itemCode]' 
	AND pcode ='$pcode' 
	AND iow='0' ";
	//echo "$sql2<br>";
	$sqlq2=mysqli_query($db, $sql2);
	$re=mysqli_fetch_array($sqlq2);	
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
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

$sqlff="SELECT sum(price) as amount FROM equipment where  reference='$posl'";
//echo $sqlff;
$sqlf=mysqli_query($db, $sqlff);
$r=mysqli_fetch_array($sqlf);
// return $r[rate]/(8*3600);
 return $r[amount];
}
 ?>

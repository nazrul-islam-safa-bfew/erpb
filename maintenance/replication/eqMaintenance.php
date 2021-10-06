<?php

function deleteGeneratedPreventiveIow(){
	global $db;
	$sql="delete from dma where dmaiow in (select iowId from iow where iowCode in (select iowCode from eqmaintenance where !isNull(references_iowCode) and maintenanceType='p'));

delete from siow where iowId in (select iowId from iow where iowCode in (select iowCode from eqmaintenance where !isNull(references_iowCode) and maintenanceType='p'));

delete from iow where iowCode in (select iowCode from eqmaintenance where !isNull(references_iowCode) and maintenanceType='p');

delete from eqmaintenance where !isNull(references_iowCode) and maintenanceType='p';

	";
	$q=mysqli_query($db,$sql);
	echo mysqli_error($db);
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
		$iowTotal=$rowI["iowPrice"]*$rowI["iowQty"];
		$iowType="2";
		$iowProjectCode="004";
		$headPos=getUpperHeadPosition($rowI["position"]);
		$newIowCode=generateIowCode($rowI["iowCode"]);

		$eSql="select * from equipment where itemCode='$rowI[eqItemCode]' and itemCode not in (select eqItemCode from eqmaintenance where references_iowCode!='' and references_iowCode='$rowI[iowCode]')";
// 	if($debug)$eSql.=" and itemCode='51-06-000'";
		$eQ=mysqli_query($db,$eSql);
		echo "<h2>Preventive iow equipment found: ".mysqli_affected_rows($db)."</h2>";
		echo "$eSql <br><br>";
		while($eRow=mysqli_fetch_array($eQ)){
			$availablePos=generateNewPosition($headPos,$iowProjectCode);
			$todat=todat();
			$sqliowEQ="INSERT INTO eqmaintenance (pcode, iowCode, iowDes, eqItemCode, maintenanceType, edate, maintenanceFrequency, measureUnit, attachPDF, attachIMG, eqmStatus, position, dt, references_iowCode)
	 VALUES ('$iowProjectCode', '$newIowCode', '$rowI[iowDes]', '$eRow[itemCode]', 'p', '$todat',  '$rowI[maintenanceFrequency]', '$eRow[measureUnit]', '', '', 'Not Ready', '$availablePos','', '$rowI[iowCode]')";
		echo "<h3>Preventive iow eqmaintenance inserted: ".mysqli_affected_rows($db)."</h3>";
		echo "$sqliowEQ <br><br>";
		if(!$debug)
			mysqli_query($db, $sqliowEQ);
			
			$sqliow="INSERT INTO iow (iowProjectCode,itemCode, iowCode, iowDes, iowQty, iowUnit,
		 iowPrice, iowTotal, iowType, iowSdate, iowCdate, iowStatus, iowDate, Prepared, Checked, Approved, revision, position)
	 VALUES ('$iowProjectCode', '$rowI[itemCode]','$newIowCode', '$rowI[iowDes]', '$rowI[iowQty]', '$rowI[iowUnit]',
			'$rowI[iowPrice]', '$iowTotal', '$iowType', '$rowI[iowSdate]', '$rowI[iowCdate]', 'Approved by MD', '$rowI[iowDate]', '', '', 'y','0','$availablePos')";
			echo "<h4>Preventive new iow inserted: ".mysqli_affected_rows($db)."</h4>";
			echo "$sqliow <br><br>";
			if(!$debug)
				mysqli_query($db, $sqliow);
			$newIowId=mysqli_insert_id($db);
			
// 			siow insert
			$siowSql="SELECT  `siowId`,`siowPcode`, `iowId`, `siowCode`, `siowName`, `siowQty`, `siowUnit`, `analysis`, `siowDate`, `siowSdate`, `siowCdate`, `revisionNo` FROM `siow` WHERE iowId=$rowI[iowId]";
			$siowQ=mysqli_query($db,$siowSql);
			echo "<h5>Preventive siow found: ".mysqli_affected_rows($db)."</h5>";
			echo "$siowSql <br><br>";
			while($siowRow=mysqli_fetch_array($siowQ)){
				$siow="insert into siow (`siowPcode`, `iowId`, `siowCode`, `siowName`, `siowQty`, `siowUnit`, `analysis`, `siowDate`, `siowSdate`, `siowCdate`, `revisionNo`) values
('$siowRow[siowPcode]','$newIowId','$siowRow[siowCode]','$siowRow[siowName]','$siowRow[siowQty]','$siowRow[siowUnit]','$siowRow[analysis]','$siowRow[siowDate]','$siowRow[siowSdate]','$siowRow[siowCdate]','$siowRow[revisionNo]')";
			echo "<h6>Preventive new siow inserted: ".mysqli_affected_rows($db)."</h6>";
				echo "$siow <br><br>";
				if(!$debug)
					mysqli_query($db,$siow);
			$newSIowId=mysqli_insert_id($db);
				
// 			resources dma
				$dmaSql="SELECT `dmaProjectCode`, `dmaiow`, `dmasiow`, `dmaItemCode`, `dmaQty`, `dmaRate`, `dmaVid`, `dmaDate`, `dmaType`, `revisionNo` FROM `dma` WHERE dmasiow='$siowRow[siowId]'";
				$dmaQ=mysqli_query($db,$dmaSql);
				echo "<h6>Preventive dma found: ".mysqli_affected_rows($db)."</h6>";
				echo "$dmaSql <br><br>";
				while($dmaRow=mysqli_fetch_array($dmaQ)){
					$dmaiow="insert into dma (`dmaProjectCode`, `dmaiow`, `dmasiow`, `dmaItemCode`, `dmaQty`, `dmaRate`, `dmaVid`, `dmaDate`, `dmaType`, `revisionNo`) values ('$dmaRow[dmaProjectCode]','$newIowId','$newSIowId','$dmaRow[dmaItemCode]','$dmaRow[dmaQty]','$dmaRow[dmaRate]','$dmaRow[dmaVid]','$dmaRow[dmaDate]','$dmaRow[dmaType]','$dmaRow[revisionNo]')";
					if(!$debug)
						mysqli_query($db,$dmaiow);
					echo "<h6>Preventive dma inserted: ".mysqli_affected_rows($db)."</h6>";
					echo "$dmaiow <br><br>";
					
				}
			}
		} // eq while
	} //iow while
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
	$row["position"]=$row["position"] >= $rowN["position"] ? $row["position"] : $rowN["position"];
	
	$lastPosition=position_dot_exploder($row["position"]);
	$incrementPos=position_number_format_reverse($lastPosition[$theDot]+1);	
	return positionMakerByReplace($headPosition,$incrementPos,$theDot);	
}


function count_dot_number($val){
	$i=$j=0;
	$valArry=explode(".",$val);
	foreach($valArry as $valSingle){
		$i++;
		if($valSingle>0)$j=$i;
	}
	return $j;
}


//input 0 & it produce like 000 this
function position_number_format_reverse($val){ 
	if(strlen($val)==3)return $val;
	elseif(strlen($val)==2)return "0".$val;
	elseif(strlen($val)==1)return "00".$val;
}


//dot explode and return array
function position_dot_exploder($val){
	$valArry=explode(".",$val);
	//print_r($valArry);
	return count($valArry)>1?$valArry:$val;
}


function positionMakerByReplace($head,$position,$dotNo){
	$posArray=position_dot_exploder($head);
	if($dotNo==3)return $posArray[0].".".$posArray[1].".".$posArray[2].".".$position;
	elseif($dotNo==2)return $posArray[0].".".$posArray[1].".".$position.".".$posArray[3];
	elseif($dotNo==1)return $posArray[0].".".$position.".".$posArray[2].".".$posArray[3];
	elseif($dotNo==0)return $position.".".$posArray[1].".".$posArray[2].".".$posArray[3];
}


//input XXX.XXX.XXX.XXX output XXX.___.XXX.XXX for main head other similar like that
function sql_position_maker($pos){
	$c=count_dot_number($pos);
	$posArry=explode(".",$pos);
	switch($c){
		case "1":
			return $posArry[0].".___.".$posArry[2].".".$posArry[3];
		case "2":
			return $posArry[0].".".$posArry[1].".___.".$posArry[3];
		case "3":
			return $posArry[0].".".$posArry[1].".".$posArry[2].".___";
	}
}



function getUpperHeadPosition($position){
	$posLine="";
	$zeroLineMaker="";
	$iowPos=count_dot_number($position)-1;
	$posArry=position_dot_exploder($position);
	for($i=0;$i<$iowPos;$i++){
		$posLine.=$posArry[$i].".";
	}
	
	if($iowPos<1)return $position; //if position is main head
	
	while($iowPos<4){
		$zeroLineMaker.=".000";
		$iowPos++;
	}
	$posLine=trim($posLine,".").$zeroLineMaker; // posline may have xxx.xxx and zerolinemaker may have 000.000
	return trim($posLine,".");
}
function todat(){
//putenv ('TZ=Asia/Dacca');
date_default_timezone_set('Asia/Dhaka');
return date("Y-m-d");
}
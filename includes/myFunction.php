<?php
function get_quotation_rating($itemCode=null,$pcode=null){
	global $db;
	$sql="select sum(advance_req+credit_facility) as total_rating from quotation where itemCode='$itemCode' and pCode='$pcode'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row["total_rating"];
}
function get_vendor_rating($vid=null){
	global $db;
	$sql="select sum(quality+reliability+availability+experienceM+experienceB+service) as total_vendor_rating from vendor where vid='$vid'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row["total_vendor_rating"];
}
function cash_payment_iow_expecess($iow_id){
  global $db;
  $sql="select sum(total) as total from cash_purchase_temp where id in (select cash_payment_temp_id from cash_payment_iow where iowId='$iow_id')";
  $q=mysqli_query($db,$sql);
  $row=mysqli_fetch_array($q);
  return $row["total"];
}

/*
Return true if qualified
false = disqualified
*/
function is_vendor_qualified($vid=null){
	$sql="select quality, reliability, availability, experienceM, experienceB, service from vendor where vid='$vid'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	if($row["quality"]==-10){
		return false;
	}
	if($row["reliability"]==-10){
		return false;
	}
	if($row["availability"]==-10){
		return false;
	}
	if($row["experienceM"]==-10){
		return false;
	}
	if($row["experienceB"]==-10){
		return false;
	}
	if($row["service"]==-10){
		return false;
	}
	return true;
}

function insted_vendor($itemCode){
	global $db;
	
}
function all_item_matched_vendor($itemCode=null,$pdate=null){
	global $db;
	$sql="select vid from quotation where itemcode='$itemCode' and valid<='$pdate'";
	$q=mysqli_query($q);
	while($row[]=mysqli_fetch_array($q)){}
	return $row;
}
function all_itemCode_in_line_sql($itemCodes){
	$itemCode_line="";
	foreach($itemCodes as $itemCode){
		$itemCode_line.="'$itemCode',";
	}
	$itemCode_line=trim($itemCode_line,",");
	return $itemCode_line;
}

function itemcode_combaination($itemCodes){
	$itemCode_line_all=all_itemCode_in_line_sql($itemCodes);
	
// 	decrement one combination
	for($i=0;$i<count($itemCodes);$i++){
		
		for($j=$i;$j<count($itemCodes)-$i;$j++){
			
		}
		
	}
}

function get_eq_hours($eqId=null,$itemCode=null,$edate=null){
	global $db;
	$sql="select stime,etime from eqattendance where eqId='$eqId' and itemCode='$itemCode' and edate='$edate'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row;
}

function get_emp_hours($empId=null,$edate=null){
	global $db;
	$sql="select stime,etime from attendance where empId='$empId' and edate='$edate'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row;
}

function is_iow_qty_changed($iow_id){
	global $db;
	$sql="select iowQty from iow where iowId='$iow_id'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	$row_old_qty=$row[iowQty];
	
	$sql="select iowQty from iowtemp where iowId='$iow_id'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	$row_new_qty=$row[iowQty];
	
	if($row_old_qty!=$row_new_qty)return true; //means qty has been changed
	return false;
}

function get_po_itemcode_in_receive_mood($itemCode,$pcode){
	global $db;
	$sql="select sum(receiveQtyTemp) as receiveQtyTemp from store$pcode where itemcode='$itemCode'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row["receiveQtyTemp"];
}

function get_project_create_date($pcode,$formated=false){
	global $db;
	$sql="select sdate from project where pcode='$pcode'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	if($formated)return date("d/m/Y",strtotime($row[sdate]));
	return $row[sdate];
}

function compare_startdate($pcode,$com_date){ //return compared date (true)
	$project_start_date=get_project_create_date($pcode);
	if($com_date<=$project_start_date)return true;
	return false;
}

function get_last_row_of_salary_allocation($empID){
	global $db;
	$sql="select * from Monthly_salary_adjustment where empID='$empID' order by msID desc limit 1";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row;	
}


function get_eqid_from_iowcode($iowCode){
	global $db;
	echo $sql="select eqItemCode from eqmaintenance where iowCode='$iowCode'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row[eqItemCode];
}

function get_eqid_from_iowcode_eng($iowCode){
	global $db;
	$sql="select dmaItemCode from dma where iowCode='$iowCode'";
// 	echo $sql;
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row[eqItemCode];
}

function getPoStatus($posl){
	global $db;
	$sql="select `status` from porder where posl='$posl' limit 1";
	$q=mysqli_query($db,$sql);
// 	echo $sql;
	$row=mysqli_fetch_array($q);
	if(mysqli_affected_rows($db) > 0){
		$status=$row[status];
		return $status;
	}else{
		$sql="select `status` from pordertemp where posl='$posl' limit 1";
		$q=mysqli_query($db,$sql);
		$row=mysqli_fetch_array($q);
		return mysqli_affected_rows($db) > 0 ? $row[status] : false;
	}
	return false;
}

function print_po_status($posl){
	global $db;
	$status=getPoStatus($posl);
	if($status==-1){
		echo "<center>Draft</center>";
	}elseif($status==1){
// 		echo "<center>Receiving in progress</center>";
	}elseif($status==2){
		echo "<center>Receiving Completed</center>";
	}elseif($status==0){
		echo "<center>Draft</center>";
	}
}

/*
	return discount amount from posl
*/
function calculateDirectCost($pcode,$iow=null,$numberFormat=true,$which=null,$temp=""){
	global $db;
	$type=2;
	$sql="select * from iow$temp where iowProjectCode='$pcode' and position like '999.%' and iowType='$type'";
	if($iow)$sql.=" and iowid='$iow'";
// 	echo $sql;
	$q = mysqli_query($db,$sql);
	$materialCost = $equipmentCost=$humanCost=$directCost=0;
	
	while($row=mysqli_fetch_array($q)){
		if(!$which){
			$materialCost=materialCost($row[iowId],$temp);
			$equipmentCost=equipmentCost($row[iowId],$temp);
			$humanCost=humanCost($row[iowId],$temp);
			$directCost+=$materialCost+$equipmentCost+$humanCost;
		}else{
			if($which=="m")
				$materialCost=materialCost($row[iowId],$temp);
			if($which=="e")
				$equipmentCost=equipmentCost($row[iowId],$temp);
			if($which=="h")
				$humanCost=humanCost($row[iowId],$temp);
			$directCost+=$materialCost+$equipmentCost+$humanCost;
		}
	}
	$sqlcont = "SELECT contact_amount,workingCapital,paymentTerms,projectDuration from project where pcode ='$pcode'";
	$sqlruncont = mysqli_query($db, $sqlcont);
	$resultcont = mysqli_fetch_array($sqlruncont);
	$contact = $directCost/($resultcont['contact_amount']/100);
	$directCost = $numberFormat ? number_format($directCost) : $directCost;
	$contact = $numberFormat ? number_format($contact,2) : $contact;
	return array($directCost,$contact);
}

function getPosl2Invoice($posl){
	global $db;
	$sql="select pdf from verify_vendor_payable where posl='$posl'";

// 	echo $sql;
	$q=mysqli_query($db, $sql);
	while($row[]=mysqli_fetch_array($q)){}
	return $row;
}

function getChalanBillDoc($posl,$mr=""){
	global $db;
	if(!$posl)return false;
	$pcode=posl2Pcode($posl);
	$sql="select pdf_files,todat from store$pcode where paymentSL='$posl' and reference='$mr'";
	$q=mysqli_query($db,$sql);
	while($row[]=mysqli_fetch_array($q)){}
	return $row;
}
function posl2Pcode($posl=""){
	if(!$posl)return false;
	$poslArr=explode("_",$posl);
	if($poslArr[1])return $poslArr[1];
	return false;
}


function getFuelConsumsionRowAssigned($eqCode,$fuelCode,$temp=false){
	global $db;
	$table="eqconsumsion";
	if($temp==true)$table="eqconsumsiontemp";
	$sql="select * from $table where eqitemCode='$eqCode' and uitemCode='$fuelCode'";
	$q=mysqli_query($db,$sql);
	//if(mysqli_affected_rows($db))	echo $sql;
	$row=mysqli_fetch_array($q);
	return $row;
}


// true=lock
function isEqPresentRequiredToLock($posl,$invoiceDate){
	global $db;
	$sql="select count(*) as rows from verify_vendor_payable where posl='$posl' and invoiceDate>='$invoiceDate'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
// 	if($row["rows"]>0)echo $sql;
	return $row["rows"]>0 ? true : false;
}

function getPoRevision($posl){
	global $db;
	$sql="select revisionNo from po_revison where posl='$posl' order by revisionNo desc limit 1";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row[revisionNo];
}
function getDiscountAmount($posl){
	global $db;
	$sql="select amount from poDiscount where posl='$posl'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	if($row[amount]>0)return $row[amount];
	return 0;
}

function getLastEntryTxtIntoEQpresent($edate,$eqID,$itemCode){
	global $db;
	$sql="select details from eqattendance where eqId='$eqID' and itemCode='$itemCode' and edate<'$edate' and details!='' order by edate desc limit 1";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row[details];
}

function checkPoType($itemCode){
	$itemCodeAr=explode("-",$itemCode);
	if($itemCodeAr[0]<"50")$potype=1;
	elseif($itemCodeAr[0]>"50" && $itemCodeAr[0]<="69")$potype=2;
	if($itemCodeAr[0]=="99")$potype=3;
	return $potype;	
}

function dateFormat($date,$CurrentFormat="d/m/Y",$separator="/",$reverse=true){
	$data=explode($separator,$date);
	if($reverse)
		return $data[2]."-".$data[1]."-".$data[0];
	return $data[0]."-".$data[1]."-".$data[2];
}

function getTroubleTrackerRows($tasksuperID="null",$iow=null,$datelineOnly=null){
	global $db;
	if($tasksuperID)
		$sql="select * from troubleTracker where (isnull(closedOn) or  closedOn='0000-00-00') and userID='$tasksuperID'";
	elseif($iow)
		$sql="select * from troubleTracker where iowID='$iow'";
	if($datelineOnly)
		$sql.=" and isnull(closedOn) ";
// 	echo $sql;
	$q=mysqli_query($db,$sql);
	while($row[]=mysqli_fetch_array($q)){}
	return $row;
}

function getBillingDocRows($iow=null,$limit=null){
	global $db;
	if(!$iow)return false;
	
	if($iow)
		$sql="select * from billingDoc where iowID='$iow' order by bID desc";
	if($limit)
		$sql.=" limit $limit";
// 	echo $sql;
	$q=mysqli_query($db,$sql);
	while($row[]=mysqli_fetch_array($q)){}
	return $row;
}

function solidFileName($fileWithPath){
	if(!$fileWithPath)return false;
	$f=explode("/",$fileWithPath);
	return $f[count($f)-1];
}

function getLastDateOfEqEdit($eqID,$itemCode){
	global $db;
	$sql="select * from equipment where assetId='$eqID' and itemCode='$itemCode'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row[edate];
}



function diagonosis2Eqmaintenance($eqID=null,$itemCode=null,$iowCode=null){
	global $db;
	$sql="select * from eqmaintenance e,diagonosis_info d where d.dia=e.dt";
	if($eqID && $itemCode)$sql.=" and e.eqID='$eqID' and itemCode='$itemCode' limit 1  ";
	if($iowCode){
		$sql.=" and e.iowCode='$iowCode'";
	}
// 	echo $sql;
	$q=mysqli_query($db,$sql);
	while($row=mysqli_fetch_array($q)){
		return $row;
	}
}

function getLastReason($eqID,$itemCode,$type="troubledRunning"){
	global $db;
	$sql="select details,edate from eqattendance where type='$type' and eqId='$eqID' and itemCode='$itemCode' and details!='' group by details limit 5";
	$q=mysqli_query($db,$sql);
	while($row=mysqli_fetch_array($q)){
		$lr[]=array($row[edate],$row[details]);
	}
	if(mysqli_affected_rows($db)>0)
		return $lr;
	return false;
}

function getEquipmentCurrentSituation($eqID,$itemCode){
	global $db;
	$sql="select `condition` from equipment where assetId='$eqID' and itemCode='$itemCode'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row[condition];
}

function getIOWinfo($iowCode){
	global $db;
	$sql="select iowDes from iow where iowCode='$iowCode' and position like '888.%'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row[iowDes];	
}

function getEqmaintenancePcode($iowCode,$pcode=null){
	global $db;
	$sql="select pcode from eqmaintenance where iowCode='$iowCode'";
	if($pcode)$sql.=" and pcode='$pcode' ";
// 	echo 	$sql;

	$q=mysqli_query($db,$sql);
	if($pcode)return mysqli_affected_rows($db)>0 ? true : false;
	$row=mysqli_fetch_array($q);
	return $row[pcode];
}

function getEquipmentFrequencyEqCode($iowCode){
	global $db;
	$sql="select maintenanceFrequency,eqItemCode,measureUnit from eqmaintenance where iowCode='$iowCode'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return array("maintenanceFrequency"=>$row[maintenanceFrequency],"eqItemCode"=>$row[eqItemCode],"measureUnit"=>$row[measureUnit]);
}


function getIowItemCode2EqMaintenanceInfo($iowCode,$selected=null){
	global $db;
	
	if($selected)
		$extra=" $selected ";
	else
		$extra=" * ";
	
	$sql="select $extra from eqmaintenance where iowCode='$iowCode'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row;
}

function uniqueMaintenanceIOW_code($iowCode){
	if(!$iowCode)return false;
	
	$iowCodeA=explode("-",$iowCode);
	$allDash=count($iowCodeA);
	if($allDash<1)return false;
	$allDash-=1;
	$i=0;
	while($allDash>$i){
		$codeGenerator[]=$iowCodeA[$i++];
	}
	return implode("-",$codeGenerator);
}

function getAllProjectCode(){
	global $db;
	$sql="SELECT pcode FROM project WHERE pcode!='' order by pcode asc";
	$q=mysqli_query($db,$sql);
	while($row[]=mysqli_fetch_array($q)){}
	return $row;
}


function getAllProblemData($problemDataSingle=null){
	$problemData=array("Engine problem","Gearbox problem","Brake/clutch problem","Abnormal tire wear","Electric problem","Suspension/chassis/differential problem","Hydraulic problem","Denting & painting problem");
	if($problemDataSingle){
		foreach($problemData as $problemD){
			if($problemD==$problemDataSingle)return true;
		}
		return false;
	}
	return $problemData;
}


function viewRevisionPOSL($posl,$style='',$escape=null){
	global $db;
	$sql="select * from po_revision where posl='$posl' and revisionStatus='accepted' and revisionNo!='$escape'";
	$q=mysqli_query($db,$sql);
	$i=1;
	while($row=mysqli_fetch_array($q)){
		echo "<a style='$style' target='_blank' href='./index.php?keyword=Forwardfor+Approval+Revision&posl=$row[posl]&revision=$row[revisionNo]'>[R".$i++."]</a>";
	}
}

function getEQlastAttendance($posl,$itemCode,$pcode){
	global $db;
	$sql="select todat from eqattendance where itemCode='$itemCode' and posl='$posl' and location='$pcode' and action in ('P','HP') order by todat desc limit 1";
// 	echo $sql;
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return mysqli_affected_rows($db)>0 ? $row[todat] : false;
}

function clear_aged_vendor_payment_aux($pcode){
	if(!isset($pcode))return false;
	$sqlD="delete from auxiliary_vendorpayment where posl like '%_$pcode_%'";
	mysqli_query($db,$sqlD);
	return true;
}

function summationOfAgedVendorPaymentAmount($pcode,$type="all",$poType="all"){
	global $db;
	if(!isset($pcode))return false;
	if(!isset($type))return false;
	
	$centralStore=99;
	$equipmentSection=85;
	
	$notLikeCenrtralStore=" posl not like '%_99' ";
	$notLikeEquipmentSection=" posl not like '%_85' ";
	
	$likeCenrtralStore=" posl like '%_99' ";
	$likeEquipmentSection=" posl like '%_85' ";
	
	if($type=="all")
		$sqlD="select sum(amount) as amount from auxiliary_vendorpayment where posl like 'PO_$pcode%' or  posl like 'EQ_$pcode%' or  posl like 'EQP_$pcode%'";
	elseif($type=="debtor")
		$sqlD="select sum(amount) as amount from auxiliary_vendorpayment where (posl like 'PO_$pcode%' or  posl like 'EQ_$pcode%' or  posl like 'EQP_$pcode%') and $notLikeCenrtralStore and $notLikeEquipmentSection";
	elseif($type=="es")
		$sqlD="select sum(amount) as amount from auxiliary_vendorpayment where (posl like 'PO_$pcode%' or  posl like 'EQ_$pcode%' or  posl like 'EQP_$pcode%') and  $likeEquipmentSection";
	elseif($type=="cs")
		$sqlD="select sum(amount) as amount from auxiliary_vendorpayment where (posl like 'PO_$pcode%' or  posl like 'EQ_$pcode%' or  posl like 'EQP_$pcode%') and $likeCenrtralStore";
	
	if($poType=="sup"){
		$sqlD.=" and posl in (select posl from porder where itemcode < '99-01-001')";
	}elseif($poType=="sub"){
		$sqlD.=" and posl in (select posl from porder where itemcode like '99-%')";
	}
// 		echo $sqlD;
	$q=mysqli_query($db,$sqlD);
	$row=mysqli_fetch_array($q);
	return $row[amount]>0 ? $row[amount] : 0;	
}

function clear_current_auxiliary_vendorpayment_data($pcode){
	if(strlen($pcode)==3){
		$sqlD="delete from auxiliary_vendorpayment where posl like '%_$pcode_%'";
		mysqli_query($db,$sqlD);
	}
}


function insert_aged_vendor_payment_aux($posl,$amount,$invoiceDate){
	global $db;
	global $amountAllCollection;
	$amountAllCollection+=$amount;
	$currentDate=todat();
	if($invoiceDate=="%")$invoiceDate="%";
	$sqlD="delete from auxiliary_vendorpayment where posl='$posl'";
	if($invoiceDate!="Forced Closed")$sqlD.=" and invoiceDate like '$invoiceDate'";
	mysqli_query($db,$sqlD);
	
	if($amount<=0)return false;
	
	$sql="insert into auxiliary_vendorpayment (posl,amount,invoiceDate,edate) values ('$posl','$amount','$invoiceDate','$currentDate');";
	mysqli_query($db,$sql);
// 	echo "<h1>========$sqlD=====$amountAllCollection</h1><br>";
	return mysqli_affected_rows($db)>0 ? true : false;
}



function redirect_wage_calc($pcode,$fdat,$tdat){
	global $db;
	$sql="select sum(amountIDLE) as amountIDLE, sum(amountUTILIZE) as amountUTILIZE from auxiliary_wages where location='$pcode' and edate between '$fdat' and '$tdat'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return array($row[amountIDLE],$row[amountUTILIZE]);
}

function isCaseWagesFound($pcode){
	global $db;
	$sql="select count(*) rows from auxiliary_wages  where location='$pcode'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row;
}



function maintenanceHead($type="all"){
	$position=array("b"=>"888.001.000.000","o"=>"888.002.000.000","p"=>"888.003.000.000");
	if($type=="all")return $position;
	elseif($type)return $position[$type];
}

function maintenanceHeadSql($firstOctetOnly=false,$like=false,$prefix="",$delimiter=","){
	$ee = $prefix."'".explode(".",$mntnc);
	$dd= explode(".",$mntnc);
	foreach(maintenanceHead() as $mntnc){
		if($firstOctetOnly){
			if($like)
				$mntncAr[]=$ee[0].".%'";
			else
				$mntncAr[]=$dd[0];
		}
		else
			$mntncAr[]=$mntnc;
	}
	return implode($delimiter,$mntncAr);
}


function btnPDFstyle($extra="float: right;"){
	return "<style>
	.btnPDF{
	  display: inline-block;
    margin-right: 5px;
    border: 1px solid;
    padding: 2px;
    border-radius: 5px;
		$extra
	}
	</style>";
}

/*
provide $issueSL,$pcode
return true if issue pending
*/
function is_isssue_pending($issueSL,$pcode){
	$sql="select issuedQtyTemp from issue$pcode where issueSL='$issueSL'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row[issuedQtyTemp] > 0 ? true : false;
}

function pdf_json_files_viewer($json_string,$btn_NotEmbaded=1){
	$jsonD=json_decode($json_string);
	if($btn_NotEmbaded==1)
		foreach($jsonD as $jsonC){
			$returnData.="<a href='.$jsonC' target='_blank' class='btnPDF'>PDF</a>";
		}
	elseif($btn_NotEmbaded==2)
		foreach($jsonD as $jsonC){
			$returnData.="<embed src=\".$jsonC\" width=\"100%\" height=\"600\" />";
		}		
	else
		$returnData=implode(",",$jsonD);
	return $returnData;
}


/*
pdfUpload_function("pdf",$_FILES[file]["tmp_name"],"/folder","I_am_file");
return file name with location if successfully uploaded
otherwise return 0
*/

function pdfUpload_function($extension,$testTemp,$loc,$fName){
// 	echo $testTemp;
// 	echo "<br>";
	$extension=$extension ? ".".$extension : "";
	$filemain="$loc/$fName$extension";
@unlink(".".$filemain);
	if(move_uploaded_file($testTemp, ".".$filemain)>0){
	   return $filemain;
	}else{
	   return 0;
	}
}


function creditFacilityDays($posl){
	global $db;
	$sql="select creditFacility from porder where posl='$posl'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row[creditFacility]>0 ? $row[creditFacility] : 0;
}

function pOAdvanceAdjustment($amount,$parcent,$advanceAmount,$advanceType=null,$posl=null){

	if(!$advanceType)
		if($posl)$advanceType=getVendorAdvanceType($posl);
		else return false;

// 	echo $advanceType;
	if($advanceType=="start"){
		$remain=$amount-$advanceAmount;
		return $remain>=0 ? $remain : $amount;
	}
	$amount=floatval($amount);
	$parcent=floatval($parcent);
	if($parcent<=0 || $amount<=0)return $amount;
	return round(($amount*$parcent)/100,2);
}

function getVendorAdvanceType($posl=null,$vid=null){
	global $db;	
	if($posl){
		$poslInfo=explode("_",$posl);		
		$vid=$poslInfo[2];
	}
	elseif(!$posl && !$vid)return;
	echo $sql="select advanceType from vendor where vid='$vid'";	
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row["advanceType"];
}

function getPOadvanceinfo($posl){
	global $db;
	$sql="select `condition` from pcondition where posl='$posl'";
	$q=mysqli_query($db,$sql);
	if(mysqli_affected_rows($db)<1)return false;
	$row=mysqli_fetch_array($q);
	$potype=poType($posl);
	return $conditionRow=extractAdvanceCondition($row["condition"],$potype);
}
function getVendoradvanceinfo($vid){
	global $db;
	$sql="select `advanceText` from vendor where vid='$vid'";
	$q=mysqli_query($db,$sql);
	if(mysqli_affected_rows($db)<1)return false;
	$row=mysqli_fetch_array($q);
	return $row[advanceText];
}
function getVendoradvanceinfo_v2($vid,$itemCode){
	global $db;
	$sql="select `advance_req_val` from quotation where vid='$vid' and itemCode='$itemCode' and valid>'".date("Y-m-d")."' order by qid desc";
	// echo $sql;
	$q=mysqli_query($db,$sql);
	if(mysqli_affected_rows($db)<1)return false;
	$row=mysqli_fetch_array($q);
	return $row[advance_req_val];
}
function extractAdvanceCondition($condition,$type="2"){
	$conA=explode("_",$condition);
	if($type=="2")return array("parcent"=>$conA[25],"amount"=>solidNumber($conA[26])); //eq
	elseif($type=="1")return array("parcent"=>$conA[30],"amount"=>solidNumber($conA[31])); //mat
	elseif($type=="3")return array("parcent"=>$conA[30],"amount"=>solidNumber($conA[31])); //sub
}

function solidNumber($val,$extra=","){
	foreach(array($extra) as $char)
		$val=str_replace($char,"",$val);
	return $val;
}


function getPoSchedule($posl,$itemCode){
	global $db;
	$sql="select o.activeDate sdate,s.sdate edate from poschedule s,porder o where o.posl='$posl' and s.posl=o.posl and s.itemCode='$itemCode' and s.itemCode=o.itemCode";
	$q=mysqli_query($db,$sql);
// 	echo $sql;
	while($row=mysqli_fetch_array($q)){
		$data[]=array("sdate"=>$row["sdate"],"edate"=>$row["edate"]);
	}
	if($data)return $data;
}

function getXdaysAgo($ago,$format="Y-m-d"){
	return date($format,strtotime("-$ago days"));
}

function is_eq_can_consumtion($eqID,$itemCode,$fuelCode){
	global $db;
	$sql="select count(*) as row from eqconsumsion where  eqItemCode='$itemCode' and uItemCode='$fuelCode'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row["row"]>0 ? true : false;
}

function getEquipmentDetails($eqID,$itemCode){
	global $db;
	$sql="select teqSpec from equipment where assetId='$eqID' and itemCode='$itemCode'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	if(mysqli_affected_rows($db)>0)
		return $row[teqSpec];
	else
		return false;
}


function getEquipmentDetailsByRquirement($eqID=null,$itemCode=null,$req=null,$eqDetails=null){
	global $db;
	if(!$eqDetails)$eqDetails=getEquipmentDetails($eqID,$itemCode);
	$detailsArr=explode("_",$eqDetails);
	if($req>-1)
		return $detailsArr[$req];
	else
		return $detailsArr;
}


function getLastUsageofEQ($eqID,$pcode,$itemCode){
	global $db;
	$sql="select km_h_qty from issue$pcode where km_h_qty>0 and eqID like '".$eqID."_".$itemCode."' order by issueDate desc limit 1";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row[km_h_qty]>0 ? $row[km_h_qty] : getStartupReading($eqID,$itemCode);
}
function getLastUsageofEQbyDate($eqID,$pcode,$itemCode,$edate){
	global $db;
	$sql="select km_h_qty from issue$pcode where km_h_qty>0 and eqID like '".$eqID."_".$itemCode."' and issueDate='$edate'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row[km_h_qty]>0 ? $row[km_h_qty] : getStartupReading($eqID,$itemCode);
}

function siow2iowID($siow){
	global $db;
	$sql="select iowId from siow where siowId='$siow'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row[iowId];
}

function eqconsumsionOilRow($itemCode,$type=""){
	global $db;
	$sql="select * from eqOL where eqitemcode='$itemCode'";
	return mysqli_query($db,$sql);
}

function eqconsumsionOilData($itemCode,$all=false,$unit=false){
	global $db;
	$fuelCode=item2itemCode4Eq(null,null,null,null,true);
	$fuelCodeLine=implode(",",$fuelCode);
	$sql="select * from eqconsumsion where eqitemCode='$itemCode'";
	if($all)$sql.=" and uitemCode not in ($fuelCodeLine) ";
	$sql.=" order by uitemCode asc";
	
	$q=mysqli_query($db,$sql);
	while($row=mysqli_fetch_array($q)){
		$itemDes=itemDes($row[uitemCode]);
		if($unit)
			$collector[]=array($row[uitemCode]=>array($itemDes[des],$itemDes[unit]) );
		else
			$collector[]=array($row[uitemCode]=>$itemDes[des]);
	}
	return $collector;
}

function getEQmeasureUnit($itemCode){
	global $db;
	$sql="select measureUnit from eqconsumsion where eqitemCode='$itemCode' limit 1";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row[measureUnit];
}

/*
$oilType=all
$oilType=f
$oilType=ol
*/
function eqconsumsionFuelRowData($itemCode,$munit=false,$noItemCode=false,$oilType="all",$extra=""){
	global $db;
	$sql="select uitemCode,measureUnit from eqconsumsion where eqitemCode='$itemCode'";
	if($oilType=="f"){
		$item2itemCode=implode(",",item2itemCode4Eq(null,null,null,null,1));
		$sql.=" and uitemCode in ($item2itemCode) ";
	}elseif($oilType=="ol"){
		$item2itemCode=implode(",",item2itemCode4Eq(null,null,null,null,1));
		$sql.=" and uitemCode not in ($item2itemCode) ";
	}
// 	echo $sql;
	$q=mysqli_query($db,$sql);
	while($rows=mysqli_fetch_array($q)){
		$itemDes=itemDes($rows[uitemCode]);
		$itemSpc=$itemDes[spc] ? ", ".$itemDes[spc] : "";
		if($noItemCode)
			$r[]=$itemDes[des].$itemSpc;
		else
			$r[]=$rows[uitemCode].": ".$itemDes[des].$itemSpc;
		$unit=$rows[measureUnit];
	}
	$unit=measuerUnti();
	$u = $unit[unit];
	if($u)
		return $munit ? implode(", $extra",$r).", ".$u : implode(",  $extra",$r);
	return false;
}

function eqconsumsionFuelRow($itemCode){
	global $db;
	$sql="select * from eqconsumsion where eqitemCode='$itemCode'";
	return mysqli_query($db,$sql);
}

function eqconsumsionOilRowData($eqID,$itemCode,$all=false){
	global $db;
	$fuelCode=item2itemCode4Eq(null,null,null,null,true);
	$fuelCodeLine=implode(",",$fuelCode);
	$sql="select uitemCode from eqconsumsion where eqitemCode='$itemCode' and uitemCode not in ($fuelCodeLine)";
	$q=mysqli_query($db,$sql);
	while($rows=mysqli_fetch_array($q)){
		$itemDes=itemDes($rows[uitemCode]);
		$r[]=$rows[uitemCode].": ".$itemDes[des];
	}
	return implode(", ",$r);
}

function isIssueFeture($pcode,$itemCode,$toDate,$iowID=null,$siowID=null,$format=1){
	global $db;
// 	if($pcode==207)return false;
	if($siowID && !$iowID)$iowID=siow2iowID($siowID);
	$sql="select count(*) as found,issueDate from issue$pcode where itemCode='$itemCode' and issueDate>'$toDate' and issuedQty>0 and iowId='$iowID' order by issueDate asc";
// 	echo $sql;
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row[found]>0 ? ($format ? date("d-m-Y",strtotime($row[issueDate])) : $row[issueDate] ) : 0;
}


function poDailyReceive($theDate,$remainQty,$lastDate){
	global $db;
	$remainQty=str_replace(",","",$remainQty);
	
	if((strtotime($lastDate)-strtotime($theDate))<=0)return "0";
	$date1=date_create($theDate);
	$date2=date_create($lastDate);
	$differTimeObj=date_diff($date1,$date2);	
	$difDay=$differTimeObj->days;
	return $remainQty/$difDay;	
}


// (null,$equipment_fuelArray[2])
function item2itemCode4Eq($item=null,$itemCode=null,$allItemCode=null,$allItemCodeDesc=null,$allItemCodeString=null){
	if($item){
		$item=strtolower($item);
		switch($item){
			case "petrol" : return "11-02-101";break;
			case "octane" : return "11-02-050";break;
			case "cng" : return "13-07-050";break;
			case "diesel" : return "11-02-025";break;
			default: return false;
		}
	}
 	if($itemCode)
		switch($itemCode){
			case "11-02-101" : return "Petrol";break;
			case "11-02-050" : return "Octane";break;
			case "13-07-050" : return "CNG";break;
			case "11-02-025" : return "Diesel";break;
			default: return false;
		}
	if($allItemCode)
		return array("11-02-101","11-02-050","13-07-050","11-02-025");
	
	if($allItemCodeString)
		return array("'11-02-101'","'11-02-050'","'13-07-050'","'11-02-025'");
	
	if($allItemCodeDesc)
		return array("11-02-101"=>"Petrol","11-02-050"=>"Octane","13-07-050"=>"CNG","11-02-025"=>"Diesel");
}




function measuerUnti($unit=null){	
	$allUnit=array("km"=>"Km","mh"=>"Hour","ue"=>"Utilization hour in ERP");
	if($unit)
		if(in_array($unit,$allUnit) && $unit)return true;
		elseif($unit)return false;
	return $allUnit;
}
function measuerUnti2OriginalUnit($unit=null){
	$allUnit=array("km"=>"Km","mh"=>"Hr","ue"=>"null");
	return $allUnit[$unit];
}

function measuerUnti2Des($unit=null){
	if(!$unit)return false;
	$allUnit=measuerUnti();
	return $allUnit[$unit];
}

function allUnitJsObj($unit=null){
					$allUnit=measuerUnti();
					foreach($allUnit as $key=>$val)
						$unitArray[]="$key:'$val'";
					return implode(",",$unitArray);
}

function allMatItemCode($all=false,$itemCodeVisiable=true){ //all true if onl2br y lubricants & oil
	global $db;
	$fuelCode=item2itemCode4Eq(null,null,null,null,true);
	$fuelCodeLine=implode(",",$fuelCode);
	$sql="select itemCode,itemDes,itemSpec,itemUnit from itemlist where itemCode like '11-__-___'";
	if($all)$sql.=" and itemCode not in ($fuelCodeLine) ";
	$sql.=" order by itemCode asc";
	$q=mysqli_query($db,$sql);
	while($row=mysqli_fetch_array($q)){
		$visiableText= $itemCodeVisiable==true ? "$row[itemCode] $row[itemDes] $row[itemSpec] ($row[itemUnit])" : "$row[itemDes] $row[itemSpec] ($row[itemUnit])";
		echo "<option value='$row[itemCode]' unit='$row[itemUnit]'>$visiableText</option>";
	}
}

function itemCode2Des($itemCode){
	global $db;
	$sql="select itemDes from itemlist where itemCode='$itemCode'";
// 	echo $sql;
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row[itemDes];
}

function accountDes($accCode){
	global $db;
	$sql="select description from accounts where accountID='$accCode'";
// 	echo $sql;
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row[description];
}

function itemCode2Unit($itemCode){
	global $db;
	$sql="select itemUnit from itemlist where itemCode='$itemCode'";
// 	echo $sql;
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row[itemUnit];
}


function isMaintenanceBreakSkipTheDay($posl,$eqID,$edate,$itemCode){
	global $db;
	$sql="SELECT id,sum((TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)/3600) as maintenanceBreakHour,edate as toDate FROM `equt` WHERE `eqId`='$eqID' and posl='$posl' AND `itemCode`='$itemCode' and iow=-1 and siow=-1 and edate='$edate' group by edate having maintenanceBreakHour>4";
	$q=mysqli_query($db,$sql);
	return mysqli_affected_rows($db) > 0 ? true : false;
}

function dmaUpdate($qty=0,$dmaID){
	global $db;
	if($dmaID)return false;
	if(!$qty)$qty=0;
	$sql="update dma set dmaQty='$qty' where dmaId='$dmaID' limit 1";
	mysqli_query($db,$sql);
	return (mysqli_affected_rows($db)>0) ? "Successful" : "Failed";
}


/*
is employee has full present
input empID, month (month format 2016-12)
output boolean
*/
function timeConvert($time){
	$timeArray=explode(":",$time);
	$convertTime=$timeArray[0].":".$timeArray[1];
	return $convertTime;
}

function isEmployeeHasFullMonthPresent($empID,$month){
	if(!$empID || !$month)return false;
	global $db;
	$sdate=$month."-01";
	$fullDate=daysofmonth($sdate);
	$sql="select count(*) as attend from attendance where empId=$empID and edate like '$month-%'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	if($row[attend]==$fullDate && $row[attend]>0)return true;
	return false;
}
/*
is Employee Has HRD permission
input empID,month (month format 2016-12-01)
output boolean
*/
function isEmployeeHasHRDpermission($empID,$month){
	global $db;	
	$sql="select count(*) as record from Monthly_salary_adjustment where empID=$empID and forMonth='$month' ";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	if($row[record]>0)return true;
	return false;
}
/*
hr Salary Permissoin ROW
input empID,month (month format 2016-12-01)
output ROW array
*/
function hrSalaryPermissoinROW($empID,$month){
	global $db;	
	$sql="select * from Monthly_salary_adjustment where empID=$empID and forMonth='$month' ";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	if(mysqli_affected_rows($db)>0)return $row;
	return false;
}

function empPaymentExploder($amount){
 	$amountArr=explode(",T:",$amount);
	$amountArr2=explode(",B:",$amountArr[1]);

	$cash=str_replace("C:","",$amountArr[0]);
	$tax=$amountArr2[0];
	$bank=$amountArr2[1];

	return array("C"=>$cash,"T"=>$tax,"B"=>$bank);
}

function totalAmountCalc($amountArr){
	$finalAmount=0;
	foreach($amountArr as $amount){
 		$finalAmount+=$amount;
	}
	return $finalAmount;
}

function totalAmountCalcPartial($amountArray,$exfor,$loginProject){
	$finalAmount=0;
	foreach($amountArray as $key=>$amount){
		if($loginProject=="000" && $exfor!="000" && ($key=="B" || $key=="T"))
 			$finalAmount+=$amount;
		elseif($key=="C" && $loginProject!="000" && $exfor!="000" )
 			$finalAmount+=$amount;
		elseif($loginProject=="000" && $exfor=="000" )
 			$finalAmount+=$amount;
	}
	return $finalAmount;
}

function empPayment4mHR($empID,$month){
	global $db;
	$sql="select amount from Monthly_salary_adjustment where empID='$empID' and forMonth='$month'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	if(mysqli_affected_rows($db)<1)return false;
	return empPaymentExploder($row[amount]);
}

function errorCheck($t=0){
	if(!$_SESSION["errorCode"])
		$_SESSION["errorCode"]=0;
	
	if($_SESSION["errorCode"]>$_SESSION["errorLimit"]){
		echo "<h1 style='color:#f00;'>You have extended your wrong limit. <a href='./index.php?keyword=log+off'>Login</a></h1><p>Your maximum wrong limit is 10 time.</p>";		
		session_destroy();
		header("Refresh: 10; url=./index.php");
		exit();
	}
	if($t==0)
  	$_SESSION["errorCode"]++;
}

function poTypeCC($type){
	if($type==2)return "Cash Purchase";
}

function getPoTypePOSL($posl){
	global $db;
	$sql="select potype from porder where posl='$posl' limit 1";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row[potype] ? $row[potype] : 1;
}

function datFormat($dat){
	$exp=explode("/",$dat);
	return $newFormat=$exp[2]."-".$exp[1]."-".$exp[0];	
}

//include('global_hack.php'); 
require_once('global_hack.php'); 

function verifiedSwitch($s){
	
	return $s>=1 ? '<p style="padding:5px; margin:3px; color:#fff; background:#007100; border-radius:5px;">Verified</p>':'<p style="padding:5px; margin:3px; color:#fff; background:#f00; border-radius:5px;">Pending</p>';
}


function getAverageExtraEqAmount($itemCode){
	global $db;
	$sql="select * from eqconsumsion where eqitemCode='$itemCode' ";
	$q=mysqli_query($db,$sql);
	
}


/*
input: row number
return: set row color
*/
if($SESS_DBNAME && $SESS_DBPASS && $SESS_DBUSER && $SESS_DBHOST)
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);

function the_iow_counter($r3,$selectedPcode,$iow,$status,$maintenance=false){
	global $db;
	if($r3){
		$sqlp="SELECT * from `iow` WHERE 1";
		if($selectedPcode) $sqlp.= " AND iowProjectCode= '$selectedPcode'";
		if($iow) $sqlp.= " AND iowCode= '$iow'";
		if($status) $sqlp.= " AND (iowStatus LIKE '%$status%')";
		if(!$maintenance)$sqlp.= "  and position not like '888.%'";
		$sqlp.= " ORDER By position ASC ";
	//echo $sqlp;
		$sqlrunp= mysqli_query($db, $sqlp);
	}else{
		$sqlp = "SELECT * from `iowtemp` WHERE 1";
		if($selectedPcode) $sqlp.= " AND iowProjectCode= '$selectedPcode'";
		if($iow) $sqlp.= " AND iowCode= '$iow'";
		if($status) $sqlp.= " AND (iowStatus LIKE '%$status%')";
		if(!$maintenance)$sqlp.= "  and position not like '888.%'";
		$sqlp.= "  ORDER By position ASC ";
	//echo $sqlp;
		$sqlrunp= mysqli_query($db, $sqlp);
	}
	echo $sqlp;
	return mysqli_affected_rows($db)>0 ? mysqli_affected_rows($db) : 0;
}
function the_iow_counter_maintenance_v2($r3,$selectedPcode,$iow,$status,$maintenance=false){
	global $db;
	if($r3){
		$sqlp="SELECT * from `iow` WHERE 1";
		if($selectedPcode) $sqlp.= " AND iowProjectCode= '$selectedPcode'";
		if($iow) $sqlp.= " AND iowCode= '$iow'";
		if($status) $sqlp.= " AND (iowStatus LIKE '%$status%')";
		if(!$maintenance)$sqlp.= "  and position not like '888.%'";
		$sqlp.=" and iowCode in (select iowCode from eqmaintenance where pcode='$selectedPcode')  ";
		$sqlp.= " ORDER By position ASC ";
	//echo $sqlp;
		$sqlrunp= mysqli_query($db, $sqlp);
	}else{
		$sqlp = "SELECT * from `iowtemp` WHERE 1";
		if($selectedPcode) $sqlp.= " AND iowProjectCode= '$selectedPcode'";
		if($iow) $sqlp.= " AND iowCode= '$iow'";
		if($status) $sqlp.= " AND (iowStatus LIKE '%$status%')";
		if(!$maintenance)$sqlp.= "  and position not like '888.%'";
		$sqlp.=" and iowCode in (select iowCode from eqmaintenance where pcode='$selectedPcode')  ";
		$sqlp.= "  ORDER By position ASC ";
	//echo $sqlp;
		$sqlrunp= mysqli_query($db, $sqlp);
	}
	echo $sqlp;
	return mysqli_affected_rows($db)>0 ? mysqli_affected_rows($db) : 0;
}
function the_iow_counter_eqMaintenance($r3,$selectedPcode,$iow,$status){
global $db;
if($r3){
	$sqlp = "SELECT * from `eqmaintenance` WHERE 1";
	if($selectedPcode) $sqlp.= " AND pcode= '$selectedPcode'";
	if($iow) $sqlp.= " AND iowCode= '$iow'";
	if($status) $sqlp.= " AND iowCode in (select iowCode from iow where iowStatus LIKE '%$status%') and position like '888.%'";
// 	echo $sqlp;
	$sqlrunp= mysqli_query($db, $sqlp);
}
else{
	$sqlp="SELECT * from `eqmaintenance` WHERE 1";
	if($selectedPcode) $sqlp.=" AND pcode= '$selectedPcode'";
	if($iow) $sqlp.= " AND iowCode= '$iow'";
	if($status) $sqlp.= " AND iowCode in (select iowCode from iowtemp where iowStatus LIKE '%$status%') and position like '888.%' GROUP by iowCode";
// echo $sqlp;
	$sqlrunp= mysqli_query($db, $sqlp);
}
// echo $sqlp;
	return mysqli_affected_rows($db)>0 ? mysqli_affected_rows($db) : 0;
}


function is_JSON(){
	$a = func_get_args();
    call_user_func_array('json_decode',$a);
   // return (json_last_error()===JSON_ERROR_NONE);
}

function related_quotation($itemCode,$pcode=null,$vendorElse){
	global $db;
	if($pcode)$pcodeExtra=" and q.pCode='$pcode' ";
	$sql="select q.*,v.vname,v.point from quotation as q, vendor as v where q.itemCode='$itemCode' $pcodeExtra and v.vid=q.vid and v.vid!='$vendorElse' group by v.vid order by q.qdate asc limit 0,10";
	$q=mysqli_query($db,$sql);
	return mysqli_affected_rows($db)>0 ? $q : 0;	
}
function related_po($itemCode,$notPosl){
	global $db;
	$sql="select p.posl,p.rate,v.vname from porder as p, vendor as v where p.itemCode='$itemCode' and p.`status`=1 and v.vid=p.vid and p.posl!='$notPosl' order by p.posl asc";
	$q=mysqli_query($db,$sql);
	return mysqli_affected_rows($db)>0 ? $q : 0;	
}





function vendor_payable_approved_counter($vid,$pcode,$type="cr"){
	global $db;
	$sql="select * from vendorPaymentApproval where vid='$vid' and location='$pcode'";
	
	 if($type=="cp")
	  $sql.=" and posl in (SELECT posl FROM `porder` WHERE `cc` not LIKE '1')";
 elseif($type=="cr")
	  $sql.=" and posl in (SELECT posl FROM `porder` WHERE `cc` LIKE '1')";
	
	mysqli_query($db, $sql);
	return mysqli_affected_rows($db)>0 ? mysqli_affected_rows($db) : 0;
}

function is_vendor_payable_approved($posl,$indate,$type=null){
	global $db;
	if(!$posl || ($indate && $type))return 0;
	
	$sql="select * from verify_vendor_payable where posl='$posl' and invoiceDate='$indate'";
	if($type)
		$sql.=" and type='$type'";
// 	echo $sql;
	mysqli_query($db, $sql);
	return mysqli_affected_rows($db)>0 ? 1 : 0;
}
function vendor_payable_approval_pdf($posl,$invoiceDate=null,$type=null){
	global $db;
	if(!$invoiceDate && !$type)return false;
	$sql="select pdf from verify_vendor_payable where posl='$posl' and invoiceDate='$invoiceDate'";
	
	if($type)
		$sql.=" and type='$type'";
// 	echo $sql;
	$q=mysqli_query($db, $sql);
	$row=mysqli_fetch_array($q);
	return mysqli_affected_rows($db)>0 ? $row["pdf"] : 0;
}


function check_posl_approved2($posl){
	global $db;
	$sql="select * from verify_vendor_payable where posl='$posl' and pdf!=''";
	mysqli_query($db, $sql);
	return mysqli_affected_rows($db)>0 ? true : false;
}

function get_posl_approved_row2($posl){
	global $db;
	$sql="select * from verify_vendor_payable where posl='$posl' and pdf!=''";
	$q=mysqli_query($db, $sql);
	$row=mysqli_fetch_array($q);
	return mysqli_affected_rows($db)>0 ? $row[pdf] : false;
}


function check_posl_approved($posl,$bool=true){
	global $db;
	$sql="select pdf from porder_approval where posl='$posl' and pdf!='' limit 1";
	$q=mysqli_query($db, $sql);
	$row=mysqli_fetch_array($q);
	if($bool==false)return $row[pdf];
	return mysqli_affected_rows($db)>0 ? true : false;
}

function get_posl_approved_row($posl){
	global $db;
	$sql="select * from porder_approval where posl='$posl' and pdf!=''";
	$q=mysqli_query($db, $sql);
	$row=mysqli_fetch_array($q);
	return mysqli_affected_rows($db)>0 ? $row[pdf] : false;
}

function iowID2IowDaily($iowID,$edate){
	global $db;
	$sql="select * from iowdaily where iowId='$iowID' and edate='$edate'";
	$q=mysqli_query($db,$sql);
	return mysqli_affected_rows($db)>0 ? mysqli_fetch_array($q) : false;
}
function iowID2IowDailyBefore($iowID,$edate){
	global $db;
	$sql="select * from iowdaily where iowId='$iowID' and edate<'$edate' and auto_save_info!='' order by edate desc limit 1";
	$q=mysqli_query($db,$sql);
	return mysqli_affected_rows($db)>0 ? mysqli_fetch_array($q) : false;
}

function posl2vendorDetails($posl){
	global $db;
	$sql="select v.* from porder as p, vendor as v where p.posl='$posl' and v.vid=p.vid";
	$q=mysqli_query($db, $sql);
	$row=mysqli_fetch_array($q);
	if(mysqli_affected_rows($db)>0)
		return $row;
	
	$sql="select v.* from pordertemp as p, vendor as v where p.posl='$posl' and v.vid=p.vid";
	$q=mysqli_query($db, $sql);
	$row=mysqli_fetch_array($q);
	return mysqli_affected_rows($db)>0 ? $row : false;
}


function md_IOW_headerFormat($val){
	if($val<=1)return false;
	for($i=2;$i<=$val;$i++){
		$equal.="=";
		$greater.=">";
	}
	$e_g_line=$equal.$greater;
	return $e_g_line;
}
function md_IOW_headerFormat_blank($val){
	if($val<=1)return false;
	for($i=2;$i<=$val;$i++){
		$equal.="|-";
		$greater.="";
	}
	$e_g_line=$equal.$greater;
	return $e_g_line;
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

function getUpperHeadPosition($position){
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


function is_position_already_used($position,$pcode,$notIn=null){
	$sql="select * from iow where position='$position' and iowProjectCode='$pcode' ";
	if($notIn)$sql.=" and iowId!='$notIn' ";
// 	echo $sql;
	global $db; 
	mysqli_query($db, $sql);
	return mysqli_affected_rows($db)>0 ? 1 : 0;
}
function is_position_already_used_in_temp($position,$pcode,$notIn=null){
	$sql="select * from iowtemp where position='$position' and iowProjectCode='$pcode' ";
	if($notIn)$sql.=" and iowId!='$notIn' ";
// 	echo $sql;
	global $db; 
	mysqli_query($db, $sql);
	return mysqli_affected_rows($db)>0 ? 1 : 0;
}





//position pcode to return boolean head/subhead or not
function isHeadorSubhead($position,$pcode){
	$sql="select * from iowtemp where position='$position' and iowProjectCode='$pcode' and iowStatus='noStatus'";
	global $db; 
	mysqli_query($db, $sql);
	return mysqli_affected_rows($db)>0 ? 1 : 0;
}

//position pcode to return boolean head/subhead or not
function isHeadorSubhead_in_iow($position,$pcode){
	$sql="select * from iow where position='$position' and iowProjectCode='$pcode' and iowStatus='noStatus'";
	global $db; 
	mysqli_query($db, $sql);
	return mysqli_affected_rows($db)>0 ? 1 : 0;
}

//position pcode to return boolean head/subhead or not
function isHeadorSubhead_from_iowID($iowID,$pcode){
	$sql="select * from iow where iowId='$iowID' and iowStatus='noStatus'";
	global $db; 
	mysqli_query($db, $sql);
	return mysqli_affected_rows($db)>0 ? 1 : 0;
}


//input 000.000.000.000 & it produce like 0.0.0.0 this
function position_number_format($val){ 
	$valArry=explode(".",$val);
	foreach($valArry as $valSingle){
		$valLine.=intval($valSingle).".";
	}	
	return trim($valLine,".");
}

//input 0 & it produce like 000 this
function position_number_format_reverse($val){ 
	if(strlen($val)==3)return $val;
	elseif(strlen($val)==2)return "0".$val;
	elseif(strlen($val)==1)return "00".$val;
}

function positionMakerByReplace($head,$position,$dotNo){
	$posArray=position_dot_exploder($head);
	if($dotNo==3)return $posArray[0].".".$posArray[1].".".$posArray[2].".".$position;
	elseif($dotNo==2)return $posArray[0].".".$posArray[1].".".$position.".".$posArray[3];
	elseif($dotNo==1)return $posArray[0].".".$position.".".$posArray[2].".".$posArray[3];
	elseif($dotNo==0)return $position.".".$posArray[1].".".$posArray[2].".".$posArray[3];
}


//dot explode and return array
function position_dot_exploder($val){
	$valArry=explode(".",$val);
	//print_r($valArry);
	return count($valArry)>1?$valArry:$val;
}



function itemCodeApprovalCounter(){
	global $db;
	$sql="select count(*) as rows from eqconsumsiontemp group by eqitemCode";
// 	echo $sql;
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);	
	return mysqli_affected_rows($db)>0 ? mysqli_affected_rows($db) : 0;
}



function vendorApprovalCounter($type="cr"){
 include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	global $db; 
	$sql="select * from vendorPaymentApproval where isNull(approved)";
	
 if($type=="cp")
	  $sql.=" and posl in (SELECT posl FROM `porder` WHERE `cc` not LIKE '1')";
 elseif($type=="cr")
	  $sql.=" and posl in (SELECT posl FROM `porder` WHERE `cc` LIKE '1')";
//  echo $sql;
	
	mysqli_query($db, $sql);
	return mysqli_affected_rows($db);
}


function vendorApprovalCounterProject($pcode,$type="cr"){
 global $db;
 $sql="select * from vendorPaymentApproval where location='$pcode' and isNull(approved)";

 if($type=="cp")
	  $sql.=" and posl in (SELECT posl FROM `porder` WHERE `cc` not LIKE '1')";
 elseif($type=="cr")
	  $sql.=" and posl in (SELECT posl FROM `porder` WHERE `cc` LIKE '1')";
//  echo $sql;
// 	exit;
 mysqli_query($db, $sql);
 return mysqli_affected_rows($db);
}


function trColor($i){
if($i%2) return " bgcolor=#E1E1FF ";
else return " bgcolor=#FFFFFF ";
}

?>
<?
/* 
return the store item group
*/
function itemGroup($d){
$itemGroups=array('01'=>'CONSTRUCTION MATERIALS',
'02'=>'PLUMBING,SANITARY & BATHROOM FITTINGS',
'03'=>'TIMBER AND BAMBOO',
'04'=>'DOOR WINDOW AND BOARD',
'05'=>'RAW MATERIALS AND CHEMICALS',
'06'=>'GENERAL HARDWARE',
'07'=>'PACKING,GASKETS AND INSULATING MATERIALS',
'08'=>'PIPES,TUBES,HOSEES AND FITTING',
'09'=>'IRON,STEEL AND NON-FERROUS METAL',
'10'=>'PAINT AND VARNISHES',
'11'=>'FUEL,OIL AND LUBRICANTS',
'12'=>'ELECTRODE',
'13'=>'GAS,DISC AND WELDING ACCESSARIES',
'14'=>'BRUSH,EMERY,BROOM ETC',
'15'=>'CORDS,ROPES AND CHAINS',
'16'=>'SAFETY MATERIALS',
'17'=>'COMSUMABLE TOOLS',
'18'=>'ELECTRIC CABLES & WIRE',
'19'=>'ELECTRICAL FITTINGS',
'20'=>'STATIONERY MATERIALS',
'21'=>'OFFICE STATIONERY TOOL',
'22'=>'FURNITURE AND FIXTURE',
'23'=>'KITCHEN WARE, CROCKERIES AND CUTLARIES',
'24'=>'MICSCELLANEOUS',
'25'=>'TRANSPORT & MACHINERIES SPARES',
'35'=>'WELDING TOOLS',
'36'=>'PAINT & SAND BLASTING TOOLS',
'37'=>'CUTTING TOOLS',
'38'=>'MEASURING TOOLS',
'39'=>'GRINDER,PULLER,VICE,DRILL TOOLS',
'40'=>'SCREW DRIVER,HAMMER ETC',
'41'=>'FILE TOOLS',
'42'=>'CRIMPING TOOLS',
'50'=>'Cutting,Drilling & Grinding Equipment',
'51'=>'Power Equipment',
'52'=>'Welding Equipments',
'54'=>'Transport Vehicles',
'55'=>'Workshop Machineries',
'56'=>'Civil Construction Machineries & Plants',
'57'=>'Earth  Excavation Equipment',
'58'=>'Road Construction Macheniries & Plants',
'59'=>'Material Handling Machineries',
'60'=>'Pipeline Contruction Machineries',
'61'=>'Testing Equipments',
'62'=>'Elecrical Instrumental Tools',
'63'=>'Instrument Erection Equipment',
'64'=>'Survey Equipments',
'65'=>'Piling Equipments',
'66'=>'Office Equipment');

return $itemGroups[$d];;
}
?>


<?
/* ---------------------------
 Input date yyyy-mm-dd
 return number of days
------------------------------*/
function daysofmonth($d){
//echo "DDDD=$d";
return date("t",strtotime($d));
}
?>
<?
/* ---------------------------
 Input date Range
 return start date and end date of all month 
------------------------------*/
/* function getMonth_sd_ed($from,$to){

2006-10-12
2007-02-25


2006-10-12 2006-10-31

2006-11-01 2006-11-30
2006-12-01 2006-12-31
2007-01-01 2007-01-31

2007-02-01 2007-02-2endor_payable where posl='$posl' and invoiceDate='$invoiceDate'";
	
	if($type)
		$sql.=" and type='$type'";
// 	echo $sql;
	$q=mysqli_query($db, $sql);
	$row=mysqli_fetch_array($q);
	return mysqli_affected_rows($db)>0 ? $row["pdf"] : 0;
}


function check_posl_approved2($posl){
	global $db;
	$sql="select * from verify_vendor_payable where posl='$posl' and pdf!=''";
	mysqli_query($db, $sql);
	return mysqli_affected_rows($db)>0 ? true : false;
}

function get_posl_approved_row2($posl){
	global $db;
	$sql="select * from verify_vendor_payable where posl='$posl' and pdf!=''";
	$q=mysqli_query($db, $sql);
	$row=mysqli_fetch_array($q);
	return mysqli_affected_rows($db)>0 ? $row[pdf] : false;
}


function check_posl_approved($posl,$bool=true){
	global $db;
	$sql="select pdf from porder_approval where posl='$posl' and pdf!='' limit 1";
	$q=mysqli_query($db, $sql);
	$row=mysqli_fetch_array($q);
	if($bool==false)return $row[pdf];
	return mysqli_affected_rows($db)>0 ? true : false;
}

function get_posl_approved_row($posl){
	global $db;
	$sql="select * from porder_approval where posl='$posl' and pdf!=''";
	$q=mysqli_query($db, $sql);
	$row=mysqli_fetch_array($q);
	return mysqli_affected_rows($db)>0 ? $row[pdf] : false;
}

function iowID2IowDaily($iowID,$edate){
	global $db;
	$sql="select * from iowdaily where iowId='$iowID' and edate='$edate'";
	$q=mysqli_query($db,$sql);
	return mysqli_affected_rows($db)>0 ? mysqli_fetch_array($q) : false;
}
function iowID2IowDailyBefore($iowID,$edate){
	global $db;
	$sql="select * from iowdaily where iowId='$iowID' and edate<'$edate' and auto_save_info!='' order by edate desc limit 1";
	$q=mysqli_query($db,$sql);
	return mysqli_affected_rows($db)>0 ? mysqli_fetch_array($q) : false;
}

function posl2vendorDetails($posl){
	global $db;
	$sql="select v.* from porder as p, vendor as v where p.posl='$posl' and v.vid=p.vid";
	$q=mysqli_query($db, $sql);
	$row=mysqli_fetch_array($q);
	if(mysqli_affected_rows($db)>0)
		return $row;
	
	$sql="select v.* from pordertemp as p, vendor as v where p.posl='$posl' and v.vid=p.vid";
	$q=mysqli_query($db, $sql);
	$row=mysqli_fetch_array($q);
	return mysqli_affected_rows($db)>0 ? $row : false;
}


function md_IOW_headerFormat($val){
	if($val<=1)return false;
	for($i=2;$i<=$val;$i++){
		$equal.="=";
		$greater.=">";
	}
	$e_g_line=$equal.$greater;
	return $e_g_line;
}
function md_IOW_headerFormat_blank($val){
	if($val<=1)return false;
	for($i=2;$i<=$val;$i++){
		$equal.="|-";
		$greater.="";
	}
	$e_g_line=$equal.$greater;
	return $e_g_line;
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

function getUpperHeadPosition($position){
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


function is_position_already_used($position,$pcode,$notIn=null){
	$sql="select * from iow where position='$position' and iowProjectCode='$pcode' ";
	if($notIn)$sql.=" and iowId!='$notIn' ";
// 	echo $sql;
	global $db; 
	mysqli_query($db, $sql);
	return mysqli_affected_rows($db)>0 ? 1 : 0;
}
function is_position_already_used_in_temp($position,$pcode,$notIn=null){
	$sql="select * from iowtemp where position='$position' and iowProjectCode='$pcode' ";
	if($notIn)$sql.=" and iowId!='$notIn' ";
// 	echo $sql;
	global $db; 
	mysqli_query($db, $sql);
	return mysqli_affected_rows($db)>0 ? 1 : 0;
}





//position pcode to return boolean head/subhead or not
function isHeadorSubhead($position,$pcode){
	$sql="select * from iowtemp where position='$position' and iowProjectCode='$pcode' and iowStatus='noStatus'";
	global $db; 
	mysqli_query($db, $sql);
	return mysqli_affected_rows($db)>0 ? 1 : 0;
}

//position pcode to return boolean head/subhead or not
function isHeadorSubhead_in_iow($position,$pcode){
	$sql="select * from iow where position='$position' and iowProjectCode='$pcode' and iowStatus='noStatus'";
	global $db; 
	mysqli_query($db, $sql);
	return mysqli_affected_rows($db)>0 ? 1 : 0;
}

//position pcode to return boolean head/subhead or not
function isHeadorSubhead_from_iowID($iowID,$pcode){
	$sql="select * from iow where iowId='$iowID' and iowStatus='noStatus'";
	global $db; 
	mysqli_query($db, $sql);
	return mysqli_affected_rows($db)>0 ? 1 : 0;
}


//input 000.000.000.000 & it produce like 0.0.0.0 this
function position_number_format($val){ 
	$valArry=explode(".",$val);
	foreach($valArry as $valSingle){
		$valLine.=intval($valSingle).".";
	}	
	return trim($valLine,".");
}

//input 0 & it produce like 000 this
function position_number_format_reverse($val){ 
	if(strlen($val)==3)return $val;
	elseif(strlen($val)==2)return "0".$val;
	elseif(strlen($val)==1)return "00".$val;
}

function positionMakerByReplace($head,$position,$dotNo){
	$posArray=position_dot_exploder($head);
	if($dotNo==3)return $posArray[0].".".$posArray[1].".".$posArray[2].".".$position;
	elseif($dotNo==2)return $posArray[0].".".$posArray[1].".".$position.".".$posArray[3];
	elseif($dotNo==1)return $posArray[0].".".$position.".".$posArray[2].".".$posArray[3];
	elseif($dotNo==0)return $position.".".$posArray[1].".".$posArray[2].".".$posArray[3];
}


//dot explode and return array
function position_dot_exploder($val){
	$valArry=explode(".",$val);
	//print_r($valArry);
	return count($valArry)>1?$valArry:$val;
}







function vendorApprovalCounter(){
 include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	global $db; 
	
	mysqli_query($db, "select * from vendorPaymentApproval");
	return mysqli_affected_rows($db);
}


function vendorApprovalCounterProject($pcode){
 include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	global $db; 
	
	mysqli_query($db, "select * from vendorPaymentApproval where location='$pcode'");
	return mysqli_affected_rows($db);
}


function trColor($i){
if($i%2) return " bgcolor=#E1E1FF ";
else return " bgcolor=#FFFFFF ";
}

?>
<?
/* 
return the store item group
*/
function itemGroup2($d){
$itemGroups=array('01'=>'CONSTRUCTION MATERIALS',
'02'=>'PLUMBING,SANITARY & BATHROOM FITTINGS',
'03'=>'TIMBER AND BAMBOO',
'04'=>'DOOR WINDOW AND BOARD',
'05'=>'RAW MATERIALS AND CHEMICALS',
'06'=>'GENERAL HARDWARE',
'07'=>'PACKING,GASKETS AND INSULATING MATERIALS',
'08'=>'PIPES,TUBES,HOSEES AND FITTING',
'09'=>'IRON,STEEL AND NON-FERROUS METAL',
'10'=>'PAINT AND VARNISHES',
'11'=>'FUEL,OIL AND LUBRICANTS',
'12'=>'ELECTRODE',
'13'=>'GAS,DISC AND WELDING ACCESSARIES',
'14'=>'BRUSH,EMERY,BROOM ETC',
'15'=>'CORDS,ROPES AND CHAINS',
'16'=>'SAFETY MATERIALS',
'17'=>'COMSUMABLE TOOLS',
'18'=>'ELECTRIC CABLES & WIRE',
'19'=>'ELECTRICAL FITTINGS',
'20'=>'STATIONERY MATERIALS',
'21'=>'OFFICE STATIONERY TOOL',
'22'=>'FURNITURE AND FIXTURE',
'23'=>'KITCHEN WARE, CROCKERIES AND CUTLARIES',
'24'=>'MICSCELLANEOUS',
'25'=>'TRANSPORT & MACHINERIES SPARES',
'35'=>'WELDING TOOLS',
'36'=>'PAINT & SAND BLASTING TOOLS',
'37'=>'CUTTING TOOLS',
'38'=>'MEASURING TOOLS',
'39'=>'GRINDER,PULLER,VICE,DRILL TOOLS',
'40'=>'SCREW DRIVER,HAMMER ETC',
'41'=>'FILE TOOLS',
'42'=>'CRIMPING TOOLS',
'50'=>'Cutting,Drilling & Grinding Equipment',
'51'=>'Power Equipment',
'52'=>'Welding Equipments',
'54'=>'Transport Vehicles',
'55'=>'Workshop Machineries',
'56'=>'Civil Construction Machineries & Plants',
'57'=>'Earth  Excavation Equipment',
'58'=>'Road Construction Macheniries & Plants',
'59'=>'Material Handling Machineries',
'60'=>'Pipeline Contruction Machineries',
'61'=>'Testing Equipments',
'62'=>'Elecrical Instrumental Tools',
'63'=>'Instrument Erection Equipment',
'64'=>'Survey Equipments',
'65'=>'Piling Equipments',
'66'=>'Office Equipment');

return $itemGroups[$d];;
}
?>


<?
/* ---------------------------
 Input date yyyy-mm-dd
 return number of days
------------------------------*/
function daysofmonth2($d){
//echo "DDDD=$d";
return date("t",strtotime($d));
}
?>
<?
/* ---------------------------
 Input date Range
 return start date and end date of all month 
------------------------------*/
 function getMonth_sd_ed($from,$to){
/*
2006-10-12
2007-02-25


2006-10-12 2006-10-31

2006-11-01 2006-11-30
2006-12-01 2006-12-31
2007-01-01 2007-01-31

2007-02-01 2007-02-25
*/
list($year1, $month1, $day1) = explode('-', $from);
list($year2, $month2, $day2) = explode('-',$to);
         
$month = ($year2 * 12 + $month2) - ($year1 * 12 + $month1)+1;

if($month==1){
$d[0][0]=$from;
$d[0][1]=$to;
}
else{
	for($i=1;$i<=$month;$i++){
	if($i==1)
	{
	$daysofmonth=daysofmonth($from);
	$d[$i][0]=$from; 
	$d[$i][1]=date("Y-m-d",mktime(0,0,0,date('m',strtotime($from)),$daysofmonth,date('Y',strtotime($from))));
	}
	elseif($i==$month)
	{
	$j=$i-1;
	$d[$i][0]=date("Y-m-d",strtotime($d[$j][1])+86400);
	$d[$i][1]=$to;
	 }	
	 else{
	    $j=$i-1;
		$d[$i][0]=date("Y-m-d",strtotime($d[$j][1])+86400);
 	    $daysofmonth=daysofmonth($d[$i][0]);		
		$d[$i][1]=date("Y-m-d",mktime(0,0,0,date('m',strtotime($d[$i][0])),$daysofmonth,date('Y',strtotime($d[$i][0]))));
	 }
	 
	 //echo $d[$i][0].'=='.$d[$i][1]."<br>";
	}//for
}//else
//print_r ($d);
return $d;
}
//print_r (getMonths('2006-10-12','2007-02-25'));

?>
<?php
/* ---------------------------
 return Current date as Dhaka
------------------------------*/
function todat(){
//putenv ('TZ=Asia/Dacca');
date_default_timezone_set('Asia/Dhaka');
return date("Y-m-d");
}
?>


<?php
/* ---------------------------
 return Current date as Dhaka custome formate
------------------------------*/
function todat_new_format($date_formate){
//putenv ('TZ=Asia/Dacca'); 
date_default_timezone_set('Asia/Dhaka');
return date($date_formate,  mktime(date('H'),date('i'),date('s'),date('n'),date('j'),date('Y')));
}
?>


<?php
/* ---------------------------

 return current Year as Dhaka
------------------------------*/
function thisYear(){
putenv ('TZ=Asia/Dacca'); 
return date("Y");
//return "2006";
}
?>
<? 
/*
return TRUE if given year is leapyear

*/
function isLeapyear($year)
{
if($year % 400 == 0)
{ return true; }
else if($year % 4 == 0 && $year % 100 != 0)
{ return true; }
else
{ return false; }
}
?>

<?
/* ---------------------------
 Input the Project Code
 return the project Name
------------------------------*/

function myprojectName($p)
{
	$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
	include($localPath."/includes/config.inc.php"); //datbase_connection
 $sql=mysqli_query($db, " SELECT pname FROM project where pcode= '$p' ORDER by pcode ASC") ;
	
 $row=mysqli_num_rows($sql);
 if($row>0){ $pn=mysqli_fetch_array($sql);
	   $pname = "$pn[pname]";
  	   return $pname;
	   }
	 return $p;
}
 ?>

<?
/* --------------------------- 
Input the Iow Code
return the IOw Name
---------------------------------*/

 function iowCode($iow)
{
 /*include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
*/
	 global $db; 
 $sqlf=mysqli_query($db, " SELECT iowCode FROM iowtemp where iowId= '$iow'") ;
 $rowf=mysqli_num_rows($sqlf);
 if($rowf){ $f=mysqli_fetch_array($sqlf);
	   $iowName= "$f[iowCode]";
  	   return $iowName;
	   }
else {
 $sqlf=mysqli_query($db, " SELECT iowCode FROM iow where iowId= '$iow'") ;
 $rowf=mysqli_num_rows($sqlf);
 if($rowf){ $f=mysqli_fetch_array($sqlf);
	   $iowName= "$f[iowCode]";
  	   return $iowName;
	   }
} //else
	 return 0;
}
 ?>
<?
/* --------------------------- 
Input the Iow Code
return the IOw Name
---------------------------------*/

 function iowName($iow)
{
 /*include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
*/
global $db; 
 $sqlf=mysqli_query($db, " SELECT iowDes FROM iowtemp where iowId= '$iow'") ;
 $rowf=mysqli_num_rows($sqlf);
 if($rowf){ $f=mysqli_fetch_array($sqlf);
	   $iowDes= "$f[iowDes]";
  	   return $iowDes;
	   }
else {
 $sqlf=mysqli_query($db, " SELECT iowDes FROM iow where iowId= '$iow'") ;
 $rowf=mysqli_num_rows($sqlf);
 if($rowf){ $f=mysqli_fetch_array($sqlf);
	   $iowDes= "$f[iowDes]";
  	   return $iowDes;
	   }

	 else return 0;
	 }
}
 ?>

<?
/* --------------------------- 
Input the Iow Code
return the SIOw Code
---------------------------------*/

 function siowCode($iow){
	 global $db; 
	 $sqlq=" SELECT siowCode FROM siowtemp where iowId='$iow' ORDER by siowId DESC limit 1";
	 //echo  $sqlq;
	 $sqlf=mysqli_query($db, $sqlq);
	 $rowf=mysqli_fetch_array($sqlf);
	 
	 if($rowf[siowCode] && !is_numeric($rowf[siowCode]))$inv=ord($rowf[siowCode]);
	 elseif(is_numeric($rowf[siowCode]))$inv=$rowf[siowCode];
	 else $inv=0;
	 if($inv<1)$inv=0;
// 	 echo $inv;
	 $siowCode=$inv+1;
	 //echo $inv;
	 //return chr($siowCode);
	 return ($siowCode);
}
?>
<?
/* --------------------------- 
Input the siow Code
return the  SIOw Name
---------------------------------*/

 function viewsiowCode($siow)
{
global $db; 
 $sqlf=mysqli_query($db, " SELECT siowCode FROM siowtemp where siowId= '$siow'") ;
 $rowf=mysqli_num_rows($sqlf);
 if($rowf){ $f=mysqli_fetch_array($sqlf);
	   $siowCode= "$f[siowCode]";
  	   return $siowCode;
	   }
else {
 $sqlf=mysqli_query($db, " SELECT siowCode FROM siow where siowId= '$siow'") ;
 $rowf=mysqli_num_rows($sqlf);
 if($rowf){ $f=mysqli_fetch_array($sqlf);
	   $siowCode= "$f[siowCode]";
  	   return $siowCode;
	   }
	 else return 0;
	 }
}
 ?>
<?
/* --------------------------- 
Input the Iow Code
return the View SIOw Name
---------------------------------*/

 function viewiowCode($iow)
{
global $db; 
 $sqlf=mysqli_query($db, " SELECT iowCode FROM iowtemp where iowId= '$iow'") ;
 $rowf=mysqli_num_rows($sqlf);
 if($rowf){ $f=mysqli_fetch_array($sqlf);
	   $iowCode= "$f[iowCode]";
  	   return $iowCode;
	   }
else{
 $sqlf=mysqli_query($db, " SELECT iowCode FROM iow where iowId= '$iow'") ;
 $rowf=mysqli_num_rows($sqlf);
 if($rowf){ $f=mysqli_fetch_array($sqlf);
	   $iowCode= "$f[iowCode]";
  	   return $iowCode;
	   }
   else 	 return 0;	   
  }	   

}
 ?>

<?
/* --------------------------- 
Input the Iow Code
return the IOW Quantity and Unit
---------------------------------*/

 function iowQty($iow)
{
global $db; 
 $sqlff=" SELECT iowQty,iowUnit FROM iowtemp where iowId= '$iow'" ;
 //echo $sqlff;
 $sqlf=mysqli_query($db, $sqlff) ;
 $rowf=mysqli_num_rows($sqlf);
 if($rowf){ $f=mysqli_fetch_array($sqlf);
	   $iowQty= "$f[iowQty] $f[iowUnit]";
  	   return $iowQty;
	   }
 else {
 $sqlff=" SELECT iowQty,iowUnit FROM iow where iowId= '$iow'" ;
 //echo $sqlff;
 $sqlf=mysqli_query($db, $sqlff) ;
 $rowf=mysqli_num_rows($sqlf);
 if($rowf){ $f=mysqli_fetch_array($sqlf);
	   $iowQty= "$f[iowQty] $f[iowUnit]";
  	   return $iowQty;
	   }
  }
	 return 0;
}
 ?>

<?
/*-------------------------------
 Input the SIow Code
 return the SIOw Name
---------------------------------*/

 function siowName($siow)
{global $db; 
 $sqlf=mysqli_query($db, " SELECT siowName FROM siow where siowId= '$siow'") ;
 $rowf=mysqli_num_rows($sqlf);
 if($rowf){ $f=mysqli_fetch_array($sqlf);
	   $siowName= "$f[siowName]";
  	   return $siowName;
	   }

	 return 0;
}
 ?>


<?
/*-------------------------------
Input the SIow Code
return the days to go by material at hand
---------------------------------*/

 function siowDay($siow,$actual,$issued,$stock)
{global $db; 
 $sqlf=mysqli_query($db, " SELECT siowSdate,siowCdate FROM siow where siowId= '$siow'") ;
 $rowf=mysqli_num_rows($sqlf);
  
 if($rowf){ $f=mysqli_fetch_array($sqlf);
	   $sdate= strtotime($f[siowSdate]);
	   $edate= strtotime($f[siowCdate]);
	   $todat=time();
	   if($todat<$sdate)
	   $sdate=$sdate;
	   $sdate=$todat;	   
	   
	   $duration= $edate-$sdate;
	   
     $duration=floor($duration/(3600*24));// duration
	   
// echo "$duration,$actual,$issued,$stock";	   
 if($duration>0){
	   $remainingQty=$actual-$issued; // remaining Qty for 
	   $perDay=$remainingQty/$duration; // per day can be issued
	   $actualPerDay=$stock/$perDay; // actual

	   $siowDate=floor($actualPerDay);
  	   //return "duration: $duration,remainingQty: $remainingQty,perDay: $perDay,stock: $stock==$siowDate";
	   return $siowDate;
	   } // if
	 else return 0;	   
	 }// if  

	 else return 0;
}
 ?>


<?
/*--------------------------------
Input the SIow Code
return the SIOw Qty and Unit
---------------------------------*/

 function siowQty($siow)
{global $db; 
 $sqlf=mysqli_query($db, " SELECT siowQty,siowUnit FROM siow where siowId= '$siow'") ;
 $rowf=mysqli_num_rows($sqlf);
 if($rowf){ $f=mysqli_fetch_array($sqlf);
	   $siowQty= "$f[siowQty], $f[siowUnit]";
  	   return $siowQty;
	   }
	 return 0;
}
 ?>

<?
/*-------------------------------
Input Validation Date
return Font Color>> if over then red else Black
---------------------------------*/
function valid($d){
	$validTill = $d;
    $lastmonth = date("Y-m-j",mktime(0, 0, 0, date("m", strtotime($validTill))-1, date("d", strtotime($validTill)),   date("Y", strtotime($validTill)) ));
    $now = date("Y-m-j",mktime(0, 0, 0, date("m"), date("d"),   date("Y")));
	
	if($lastmonth < $now)
	{$c="<font style='color:#FF0000; TEXT-DECORATION: underline'>"; }
	else {$c="<font color=#000000>"; }
  return $c;
}

function valid1($d){
	$validTill = $d;
  $lastmonth = date("Y-m-j",mktime(0, 0, 0, date("m", strtotime($validTill)), date("d", strtotime($validTill)),   date("Y", strtotime($validTill)) ));
	
  $now = date("Y-m-d",mktime(0, 0, 0, date("m"), date("d"),   date("Y")));
	
	if($lastmonth < $now){$c=0;}
	else {$c=1;}

  return $c;
}

?>


<?
// Input  $n=selection name; $ex=extra; $s=selected project name
// return project list with selected project heighlited

function selectPlist($n,$ex,$s,$additional=null){
global $db; 
	
$sqlp = "SELECT `pcode`,pname from `project` ORDER by pcode ASC";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
 
$plist= "<select name='$n'> ";
$plist.=$additional;
 if(sizeof($ex)>1){
	 for($i=0; $i< sizeof($ex); $i++){
		 $plist.= "<option value='".$ex[$i]."'";
		 if($s==$ex[$i])  $plist.= " SELECTED";
			 $plist.= ">$ex[$i]</option>  ";
	 }
 }


 while($typel= mysqli_fetch_array($sqlrunp))
{
 $plist.= "<option value='".$typel[pcode]."'";
 if($s==$typel[pcode])  $plist.= " SELECTED";
 $plist.= ">$typel[pcode]--$typel[pname]</option>  ";
 }
 $plist.= '</select>';
 return $plist;
 }
?>


<?
// Input  $n=selection name; $ex=extra; $s=selected project name
// return project list with selected project heighlited

function selectPlistProject($n,$ex,$s){
global $db; 
	
$sqlp = "SELECT `pcode`,pname from `project` where pcode='$s' ORDER by pcode ASC";
//$sqlp = "SELECT `pcode`,pname from `project` ORDER by pcode ASC";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
 
$plist= "<select name='$n'> ";
 if(sizeof($ex)>1){
 for($i=0; $i< sizeof($ex); $i++){
 $plist.= "<option value='".$ex[$i]."'";
 if($s==$ex[$i])  $plist.= " SELECTED";
 $plist.= ">$ex[$i]</option>  ";
 }
 }


 while($typel= mysqli_fetch_array($sqlrunp))
{
 $plist.= "<option value='".$typel[pcode]."'";
 if($s==$typel[pcode])  $plist.= " SELECTED";
 $plist.= ">$typel[pcode]--$typel[pname]</option>  ";
 }
 $plist.= '</select>';
 return $plist;
 }
?>

<?
/*
formate date like "dd-mm-yyyy"
 Input  Date Y-m-j
 return Date d-m-Y
*/
function myDate($d){
if(!$d)return false;
return date("d-m-Y", strtotime($d));
}
?>

<?
/*-------------------------------
Input the ItemCode Code
return the Item Description
---------------------------------*/

function connection(){
	if(file_exists("../../includes/config.inc.php")){
	include("../../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	}
	else if(file_exists("../includes/config.inc.php")){
	include("../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);		
	}
	else if(file_exists("config.inc.php")){
	include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);		
	}
	else{
		global $db;
	}	
	return $db;
}

function itemDes($p){
//if(!$p)return false;
 global $db;
 $sqlf="SELECT * FROM itemlist where itemCode='$p'";
//  echo  $sqlf;	
 $sqlq=mysqli_query($db, $sqlf); 
 $pn=mysqli_fetch_array($sqlq);
 if(mysqli_affected_rows($db)<1)return array("des"=>"<font color=#f00>Item code not found. Please contact to the MIS department.</font>","spc"=>$pn[itemSpec],'unit'=>$pn[itemUnit]);
 $itemDescription= array("des"=>$pn[itemDes],"spc"=>$pn[itemSpec],'unit'=>$pn[itemUnit]);
 return $itemDescription;
}
?>
 

<?
/*--------------------------------
 Input the ItemCode Code
 return the Item Type
---------------------------------*/

function itemType($a){
	global $db; 
 $sql="SELECT itemType FROM itemlist WHERE itemCode = '$a'";
//echo '<br>'.$sql.'<br>';
 $sql=mysqli_query($db, $sql); 
 $pn=mysqli_fetch_array($sql);
 
return $pn[itemType];
}
?>

<?
/*-------------------------------
calculate equipment rent rate

 Input the cost,salvageValue,life,uses
 return rent Rate
 ---------------------------------*/

function rentRate($cost,$salvageValue,$life,$days,$hours){
//echo "cost:$cost,salvageValue:$salvageValue,life:$life,days:$days,hours:$hours<br>";
if($cost AND $salvageValue AND $life AND $days AND $hours){
	$dep = ($cost-$salvageValue)/$life ; // as Straigth Line method

	$rateY= $dep/12; // per month
	 $rateM= ($rateY*$days); // per Month
	/* month column called days in database.*/
	 $rateH= $rateM/240; // per Hour	 
	 $rateD= $rateH*$hours; // per Hour	 
	 
	if($rateD<0) return '0';
	else {
    $rateD+=($rateD/100)*25; //maintenance cost 25% included
	  return number_format($rateD);
  }
}
return '0';
}
?>

<? 
function isMaxVendorQuotationValid($itemCode,$pcode){
	global $db;
	
	$todat=todat();
	$sql="select * from quotation q, vendor v where q.itemCode='$itemCode' and q.pCode='$pcode' and q.vid=v.vid order by v.point desc limit 1";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);	
	return mysqli_affected_rows($db)>0 ? ($row["valid"]>$todat ? 1 : 0) : 0;
}
function isMaxVendorQuotationValid1($itemCode,$pcode){
	global $db;
	
	$todat=todat();
	$sql="select * from quotation q, vendor v where q.itemCode='$itemCode' and q.pCode='$pcode' and q.vid=v.vid order by v.point desc limit 1";
	$q=mysqli_query($db,$sql);
return	$row=mysqli_fetch_array($q);	
}


/*-------------------------------
calculate tool rate

first try to calculate tool rate from bfew center store tool if tool is not available then

input tool code
output rent rate
---------------------------------*/
function toolRate($toolCode){

global $db; 
	
	

$sql="SELECT avg(rate) as rate from store where itemCode='$toolCode'";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
     $pn=mysqli_fetch_array($sqlQuery);
	 $toolRate = $pn[rate];
	 $vendor='99';
/*if tool does not find in store search in quotation*/	 
if($toolRate<=0){
 $sql="SELECT quotation.*, vendor.vid from quotation,vendor where".
 " quotation.itemCode = '$toolCode'  AND quotation.vid= vendor.vid order by point DESC";
// echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
     $pn=mysqli_fetch_array($sqlQuery);
	 $toolRate = $pn[rate];
	 $vendor=$pn[vid];
}
/* now calculate per hour rate of tool*/
 $sql1="SELECT * FROM toolrate WHERE itemCode ='$toolCode' ";
//echo '<br>'.$sql1.'<br>';
 $sql1=mysqli_query($db, $sql1); 
 $pn1=mysqli_fetch_array($sql1);
 $cost=$toolRate;
 $salvageValue=$cost*($pn1[salvageValue]/100);
 $life=$pn1[life];
 
if($cost AND $life){
	$dep = ($cost-$salvageValue)/($life*30) ; // as Straigth Line method rate per day
	$rateD= 2*$dep;
	$rateH= $rateD/8;	//rate per hour

	if($rateH<0) $rateH="$vendor_0";
	else $rateH=$vendor.'_'.$rateH;
	return $rateH;
}
	else return 0;

return $vendor.'_'.$toolRate;	
}
?>
<? 
/*---------------------------
input: equipment Code
output: equipment  Rate from vendor
---------------------------------*/
function toolVendorRate($code){
	global $db; 
 $sql="SELECT quotation.*, vendor.vid 
 from quotation,vendor 
 where quotation.itemCode = '$code'  
 AND quotation.vid= vendor.vid order by point DESC";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
     $pn=mysqli_fetch_array($sqlQuery);

     $ftemp = toolSalvage($code);	 
	 $rate=($pn[rate]-($pn[rate]*$ftemp[salvageValue]))/$ftemp[life];
	 //$rate= $pn[rate];
	  $eqRate = $pn[vid].'_'.$rate*4;
	 return $eqRate;
}
?>

<? 
/*---------------------------
input: code
output: salvage value
---------------------------------*/
function toolSalvage($Code){
	global $db; 
 $sql="SELECT * from toolrate where itemCode = '$Code'";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
     $pn=mysqli_fetch_array($sqlQuery);	 
	 $salvageValue=$pn[salvageValue]/100;
	 $life=$pn[life]*30;
	 $salvage=array('salvageValue'=>$salvageValue,'life'=>$life);
	 return $salvage;
}
?>


<?
function getEqLastReason($eqID,$itemCode,$type){
	global $db;
	$sql="select details from eqattendance where eqId='$eqID' and itemCode='$itemCode' and type='$type' order by edate desc limit 1";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row[details];
}

/*----------------------------------
 Input the equipment Code
 return the equipment Condation
---------------------------------*/
function eqCondition($a=null,$formated=true){
	$condition = array('1'=> 'Good','2'=> 'Periodic Maintenence',
	'3'=> 'Breakdown','4'=> 'Unrepairable',
	'5'=> 'New','6'=> 'Re-conditioned','7'=> 'Used','8'=> 'Sold','9'=> 'Troubled Running'
	);
	if($formated)
		return '<font color="#FF3333">'.$condition[$a].'</font>';
	elseif($a)
		return $condition[$a];
	return $condition;
}

function eqConditionChecker($text=null,$code=null){
	if(!$text && !$code)return false;
	$allCondition=getEquipmentConditions(true);

	if($text){ 
		foreach($allCondition as $key=>$sCondition){
			if($sCondition==$text)return $key;
		}
	}else{
		foreach($allCondition as  $key=>$sCondition){
			if($key==$code)return $sCondition;
		}
	}
}
?>

<?
// error message genarotor

function errMsg($m){
$errorMsg= "<table width=400 align=center border=1 cellspacing=0 cellpading=0 style='border-collapse: collapse' bordercolor=#FF0000>";
$errorMsg.="<tr><td background=../images/tbl_error.png><font color=#FFFFFF> ERROR</font></td></tr>";
$errorMsg.="<tr><td>";
$errorMsg.="<p><font face=Verdana size=1 color=red><b> $m </font><b><p>";
$errorMsg.="</td>";
$errorMsg.="</tr>";
$errorMsg.="</table>";
return $errorMsg;
}
?>

<?
// error message genarotor

function inerrMsg($m){
$errorMsg= "<table width=400 align=center border=1 cellspacing=0 cellpading=0 style='border-collapse: collapse' bordercolor=#FF0000>";
$errorMsg.="<tr><td background=./images/tbl_error.png><font color=#FFFFFF> ERROR</font></td></tr>";
$errorMsg.="<tr><td>";
$errorMsg.="<p><font face=Verdana size=1 color=red><b> $m </font><b><p>";
$errorMsg.="</td>";
$errorMsg.="</tr>";
$errorMsg.="</table>";
return $errorMsg;
}
?>

<?
/*----------------------------------
INPUT: mysql query
OUTPUT: mysql result seet
---------------------------------*/

function safeQuery($query){
	global $db; 
		
	//echo $sqlf;
	$sqlrunf= mysqli_query($db,$query)
			  or die("query failed:"
					 
					 ."<li>query=".$query
		) ;
	return $sqlrunf;
	}
// function safeQuery($query){
// 	global $db; 
		
// 	//echo $sqlf;
// 	$sqlrunf= mysqli_query($db,$query)
// 			  or die("query failed:"
// 					 ."<li>errorno=".mysqli_errno()
// 					 ."<li>error=".mysqli_error()
// 					 ."<li>query=".$query
// 		) ;
// 	return $sqlrunf;
// 	}


// function safeQuery($query){
// global $db; 
// $localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
// include($localPath."/includes/config.inc.php"); //datbase_connection
// $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
// //echo $sqlf
// $sqlrunf= mysqli_query($db,$query)
//           or die("query failed:"
// 		         ."<li>errorno=".mysql_errno()
// 				 ."<li>error=".mysql_error()
// 				 ."<li>query=".$query
// 	) ;
// return $sqlrunf;
// }

?>

<? 
/*-------------------------------
INPUT: dd/mm/yyyy
OUTPUT: formate date
---------------------------------*/
function formatDate($date,$format){
  	$regs = explode("/", $date);
    $the_date = date($format, strtotime($regs[2].'-'.$regs[1].'-'.$regs[0]));
    return $the_date;
  }
?>
<? 
/*-------------------------------
INPUT: dd/mm/yyyy
OUTPUT: formate date
---------------------------------*/
function formatDateV2($date,$format){
$regs=explode("-",$date);
	return date($format, mktime(0,0,0,$regs[1], $regs[0], $regs[2]));

}
?>


<?
/*---------------------------------
INPUT : project code; vemdor id; puchase order type
type 1: material and sub contract
type 2: equipment rent
tyoe 4: equipment purchase
OUTPUT: perchase order serial NO
---------------------------------*/
function posl($p,$v,$t){
global $db;

if($t==1){ $sql="SELECT posl FROM `pordertemp` WHERE posl Like 'PO_%' AND potype IN ('1','3')";

$posl='PO_';
}
if($t==2) {
 $sql=" SELECT posl FROM `pordertemp` WHERE posl Like 'EQ_%' AND potype='2'";
 $posl='EQ_';
}
if($t==4) { $sql="SELECT posl FROM `pordertemp` 
WHERE posl Like 'EQP_%' AND potype='4'";
$posl='EQP_';
}
	
if($p)
	$sql.=" and posl like '$posl$p"."_%"."'";

$sql.=" ORDER by posl DESC limit 1";

// echo "$sql";
 $sqlQuery=mysqli_query($db, $sql);
 $sqlf=mysqli_fetch_array($sqlQuery);
 //echo $sqlf[posl].'<br>';
 $tpo=explode('_',$sqlf[posl]);

 $pn=mysqli_num_rows($sqlQuery)+1;
// echo $pn;
 $pn=$tpo[2]+1; // increment by 1
 if($pn < 10) $pn="0000$pn";
 else if($pn < 100) $pn="000$pn";
 else if($pn < 1000) $pn="00$pn"; 
 else if($pn < 10000) $pn="0$pn"; 

$posl=$posl.$p.'_'.$pn.'_'.$v ; // format purchase order
/*
$sql="select posl from `pordertemp` where posl='$posl' ";
$sqlq=mysqli_query($db, $sql);
$num_rows = mysqli_num_rows($sqlq);
if($num_rows>=1) {echo "There is may be some ERROR..<br>please Contact with ERP administrator.."; exit;}
else return $posl;
*/
return $posl;
}
?>
<?
/*---------------------------------
INPUT: project code
OUTPUT: store teturn serial no.
---------------------------------*/
function storeReturnsl($p){

global $db; 
	

$sql=" SELECT rsl FROM `storet` WHERE rsl LIKE 'SR_".$p."_%' ORDER by rsl DESC";
//echo "<br>$sql<br>";

$sqlQuery=mysqli_query($db, $sql);
$sqlf=mysqli_fetch_array($sqlQuery);

$t=explode('_',$sqlf[rsl]);

	 $num_rows=$t[2]+1;
	 if($num_rows<10) $po="0000$num_rows";
	 else if($num_rows<100) $po="000$num_rows";	 
	 else if($num_rows<1000) $po="00$num_rows";	 	 
	 else if($num_rows<10000) $po="0$num_rows";	 	 
	  else $po=$num_rows;
	  $sl="SR_".$p."_".$po;	 	 
return $sl;
}
?>

<?
/*-------------------------------
input: project Code and Item Code
return: total purchase Ordered Quantity
---------------------------------*/
function orderQty($p,$q){
$orderQtyf=0;
global $db;
	
$sqlf="SELECT SUM(qty) as orderQtyf from pordertemp WHERE location='$p' and itemCode='$q'";
// echo $sqlf;
 $sqlQueryf=mysqli_query($db, $sqlf);
 $sqlRunf=mysqli_fetch_array($sqlQueryf);
 $orderQtyf1=$sqlRunf[orderQtyf];
 
$sqlf="SELECT SUM(qty) as orderQtyf from porder WHERE location='$p' and itemCode='$q' AND posl LIKE 'EP_%'";
// echo $sqlf;
 $sqlQueryf=mysqli_query($db, $sqlf);
 $sqlRunf=mysqli_fetch_array($sqlQueryf);
 $orderQtyf2=$sqlRunf[orderQtyf];
 
 $orderQty=$orderQtyf1+$orderQtyf2;
 
 if($orderQty>0) return $orderQty;
  else return 0;
}
?>
<?
/*-------------------------------
input: project Code and Item Code
return: total purchase order qty in purchase order revesion/create mode 

calculate total purchase order qty except give porder 
---------------------------------*/
function orderQty_temp($p,$q,$posl){
$orderQtyf=0;
global $db; 
	
$sqlf="SELECT SUM(qty) as orderQtyf from pordertemp WHERE location='$p' and itemCode='$q' AND posl <>'$posl'";
//echo $sqlf;
 $sqlQueryf=mysqli_query($db, $sqlf);
 $sqlRunf=mysqli_fetch_array($sqlQueryf);
 $orderQtyf1=$sqlRunf[orderQtyf];
 
$sqlf="SELECT SUM(qty) as orderQtyf from porder WHERE location='$p' and itemCode='$q' AND posl LIKE 'EP_%'";
//echo $sqlf;
 $sqlQueryf=mysqli_query($db, $sqlf);
 $sqlRunf=mysqli_fetch_array($sqlQueryf);
 $orderQtyf2=$sqlRunf[orderQtyf];
 
 $orderQty=$orderQtyf1+$orderQtyf2;
 
 if($orderQty>0) return $orderQty;
  else return 0;
}
?>


<? 
/*-------------------------------
input: project Code and Item Code
return: total approved Quantity in iow of given project and itemCode
---------------------------------*/

function totaldmaQty($p,$ic){
	global $db;
$totalQtyf=0;
$sqlf="SELECT SUM(dmaQty) as dmaTotal 
from dma 
WHERE  dmaItemCode='$ic' AND dmaProjectCode='$p' AND dmaRate <>0";


/*$sqlf="SELECT SUM(dmaQty) as dmaTotal from dma,iow WHERE 
 iowStatus IN ('Approved by Mngr P&C','Approved by MD') AND iow.iowId=dma.dmaiow 
AND dmaItemCode='$ic' AND dmaProjectCode='$p' AND dmaRate <>0";
*/
//	echo "<br>$sqlf<br>";
 $sqlQueryf=mysqli_query($db, $sqlf);
 $sqlRunf=mysqli_fetch_array($sqlQueryf);
 $totalQtyf=$sqlRunf[dmaTotal];
 if($totalQtyf>0) return $totalQtyf;
  else return 0;
}
?>

<? 
/*-------------------------------
input: project Code and Item Code
return: total approved Quantity in iow of given project and itemCode
---------------------------------*/
//created function by salma
function dRate($ic){
$sqlf="SELECT MAX(dmaRate) as dmaRate from dma WHERE  dmaItemCode='$ic' order by dmaDate desc limit 0,1";
global $db; 

/*$sqlf="SELECT SUM(dmaQty) as dmaTotal from dma,iow WHERE 
 iowStatus IN ('Approved by Mngr P&C','Approved by MD') AND iow.iowId=dma.dmaiow 
AND dmaItemCode='$ic' AND dmaProjectCode='$p' AND dmaRate <>0";
*/
//	echo "<br>$sqlf<br>";
 $sqlQueryf=mysqli_query($db, $sqlf);
 $sqlRunf=mysqli_fetch_array($sqlQueryf);
	//print_r($sqlRunf);
 $drate=$sqlRunf[dmaRate];
 if($drate>0) return $drate;
  else return 0;
}
?>

<?
/*---------------------------------
input vendor ID 
 output vendor Name and rating
 ---------------------------------*/
function vendorName($v){
	global $db; 
if(!empty($v)){
 $vendor = "SELECT * FROM vendor WHERE vid=$v";
// echo '<br>'.$vendor.'<br>';
$sqlrunvendor= mysqli_query($db, $vendor);
$ven= mysqli_fetch_array($sqlrunvendor);

$vendor=array('vname'=>$ven[vname],'rating'=>$ven[point]);
return $vendor;
}
 else return 'Not found';
}
?>
<?
/*---------------------------------
input vendor ID 
 output vendor Name
 ---------------------------------*/
function vName($v){
	global $db; 
 $vendor = "SELECT vname FROM vendor WHERE vid=$v";
//echo $vendor.'<br>';
$sqlrunvendor= mysqli_query($db, $vendor);
$ven= mysqli_fetch_array($sqlrunvendor);
return $ven[vname];
}
?>

<?
/*---------------------------------
enter iow Code
return total material Cost of that Iow
---------------------------------*/
function iowCost($iow,$temp=""){
	global $db; 
 $sqlf = "SELECT SUM(dmaRate*dmaQty) as iowCost 
 FROM `dma$temp` WHERE dmaiow=$iow";
// echo $sqlf.'<br>';
$sqlQ= mysqli_query($db, $sqlf);
$sqlRunf= mysqli_fetch_array($sqlQ);
return $sqlRunf[iowCost];
}
?>


<?
/*---------------------------------
enter iow Code
return total material Cost of that Iow
---------------------------------*/
function materialCost($iow,$temp=""){
	global $db; 
 $sqlf = "SELECT SUM(dmaRate*dmaQty) as materialRate 
 FROM `dma$temp` WHERE dmaiow=$iow AND  dmaItemCode between '01-00-000' AND '34-99-999'";
// echo $sqlf.'<br>';
$sqlQ= mysqli_query($db, $sqlf);
$sqlRunf= mysqli_fetch_array($sqlQ);
return $sqlRunf[materialRate];
}
?>
<?
/*-------------------------------
enter iow Code
return total equipment Cost of that Iow
---------------------------------*/
function equipmentCost($iow,$temp=""){
	global $db; 
 $sqlf = "SELECT SUM(dmaRate*dmaQty) as equipmentRate 
 FROM `dma$temp` WHERE dmaiow=$iow AND  dmaItemCode between '50-00-000' AND '69-99-999'";
//echo $sqlf.'<br>';
$sqlQ= mysqli_query($db, $sqlf);
$sqlRunf= mysqli_fetch_array($sqlQ);
return $sqlRunf[equipmentRate];
}
?>

<?
/*--------------------------------
enter iow Code
return total human Cost of that Iow
---------------------------------*/
function humanCost($iow,$temp=""){
  global $db; 
  $sqlf = "SELECT SUM(dmaRate*dmaQty) as humanRate FROM `dma$temp` WHERE dmaiow=$iow AND  dmaItemCode between '70-00-000' AND '99-99-999'";
  //echo $sqlf.'<br>';
  $sqlQ= mysqli_query($db, $sqlf);
  $sqlRunf= mysqli_fetch_array($sqlQ);
  return $sqlRunf[humanRate];
}
?>

<?
/*---------------------------------
enter siow Code
return total material Cost of that sIow
---------------------------------*/
function siow_materialCost($siow){
global $db; 
$sqlf = "SELECT SUM(dmaRate*dmaQty) as materialRate FROM `dma` WHERE dmasiow=$siow AND  dmaItemCode between '01-00-000' AND '39-99-999'";
//echo $sqlf.'<br>';
$sqlQ= mysqli_query($db, $sqlf);
$sqlRunf= mysqli_fetch_array($sqlQ);
return $sqlRunf[materialRate];
}
?>
<?
/*-------------------------------
enter siow Code
return total equipment Cost of that sIow
---------------------------------*/
function siow_equipmentCost($siow){
global $db;
$sqlf = "SELECT SUM(dmaRate*dmaQty) as equipmentRate FROM `dma` WHERE dmasiow=$siow AND  dmaItemCode between '50-00-000' AND '69-99-999'";
//echo $sqlf.'<br>';
$sqlQ= mysqli_query($db, $sqlf);
$sqlRunf= mysqli_fetch_array($sqlQ);
return $sqlRunf[equipmentRate];
}
?>

<?
/*--------------------------------
enter siow Code
return total human Cost of that sIow
---------------------------------*/
function siow_humanCost($siow){
	global $db; 
 $sqlf = "SELECT SUM(dmaRate*dmaQty) as humanRate FROM `dma` WHERE dmasiow=$siow AND  dmaItemCode between '70-00-000' AND '99-99-999'";
//echo $sqlf.'<br>';
$sqlQ= mysqli_query($db, $sqlf);
$sqlRunf= mysqli_fetch_array($sqlQ);
return $sqlRunf[humanRate];
}
?>

<? 
/*---------------------------
input: itemCode Code
output: total quotation Found
---------------------------------*/
function quotationNo($itemCode,$p){
	global $db; 
if($p=='0'){
//$sql="SELECT * from quotation where quotation.itemCode = '$itemCode' AND type='1'"; // old rule i dont know why use type=1 
if($_SESSION[loginDesignation]=="Procurement Executive")
	$location=$_SESSION[loginProject];
$sql="SELECT * from quotation where itemCode = '$itemCode' and pCode='$location' and type='1' group by vid order by valid desc"; // new rule by suvro
// echo $sql.'AAAA';
 $sqlQuery=mysqli_query($db, $sql);
 $pn=mysqli_num_rows($sqlQuery);
 $qutNo =  $pn;

}
elseif($p=='1'){

 $sql="SELECT * from quotation where quotation.itemCode = '$itemCode'";
//echo $sql.'AAAA';
 $sqlQuery=mysqli_query($db, $sql);
 $pn=mysqli_num_rows($sqlQuery);
 $qutNo =  $pn;

}
else{
 $sql="SELECT * from quotation where quotation.itemCode = '$itemCode' AND pCode in ( '$p','000')";
 //echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $pn=mysqli_num_rows($sqlQuery);
 $qutNo =  $pn;
  
 $sql="SELECT itemCode from equipment where itemCode = '$itemCode' ";
 //echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $pn=mysqli_num_rows($sqlQuery);
 if($pn>0)  $qutNo += 1;

 $sql="SELECT itemCode from store where itemCode = '$itemCode' ";
 //echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $pn=mysqli_num_rows($sqlQuery);
 if($pn>0)  $qutNo += 1;
}
 return $qutNo;
}
?>

<? 
/*---------------------------
input: itemCode Code
output: total quotation Found
---------------------------------*/
function isquotationNo($itemCode){
global $db; 
	  
 $sql="SELECT itemCode from equipment where itemCode = '$itemCode' ";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $pn=mysqli_num_rows($sqlQuery);
 if($pn>0)  $qutNo = 1;

 $sql="SELECT itemCode from store where itemCode = '$itemCode' ";
 //echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $pn=mysqli_num_rows($sqlQuery);
 if($pn>0)  $qutNo = 1;

 return $qutNo;
}
?>


<?
/*---------------------------
input: seconds
output: h:m:s
---------------------------------*/

function sec2hms($sec,$padHours=false)
{
 $sec;
$sec=$sec*3600;
//holdes formated string
$hms="";
//there are 360 seconds in an hour,so if we divide total seconds by 3600 and throw away the remainder, we've got the number of hours
$hours=intval($sec/3600);
//echo $hours.'<br>';
// add to $hms, with a leading 0 if asked for
$hms.=($padHours)? str_pad($hours,2, "0", STR_PAD_LEFT).':' : $hours.':';
//dividing the total seconds by 60 will givesus the number of minutes, but we're interested in minutes past the hour: to get that, we need to divided by 60 again and keep the remainder
$minutes = intval(($sec / 60) % 60);
//echo $minutes.'<br>';
// then add to $hms (with a leading 0 if needed)
$hms.= str_pad($minutes,2, "0", STR_PAD_LEFT);

//seconds are simple- just divided the total seconds by 60 and keep the remainder

//$seconds=intval($sec % 60);
// add to $hms, again a leading 0 if needed
//$hms.= str_pad($seconds,2, "0", STR_PAD_LEFT);
return $hms;
}

?>

<?
/*---------------------------
input: posl, itemCode Code, project
output: total remain Qty in this proder
---------------------------------*/

function remainQty6($posl,$item,$pp){
 include("config.inc.php");
 //include("session.inc.php"); 
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$sql="SELECT * from  porder where posl = '$posl' AND itemCode ='$item'";
//echo '<br>'.$sql.'<br>';
 $sqlQuery=mysqli_query($db, $sql);
 $remainQty0=mysqli_fetch_array($sqlQuery);
 
$order=  $remainQty0[qty];

 $sql1="SELECT sum(receiveQty) as total from  `store` where itemCode ='$item'";
//echo '<br>'.$sql1.'<br>';
 $sqlQuery1=mysqli_query($db, $sql1);
 $remainQty1=mysqli_fetch_array($sqlQuery1);
 $remainQty1[total];
$remainQty= $order- $remainQty1[total];

 return $remainQty;
}


function remainQty($posl,$item,$pp){
 global $db;	

 $sql="SELECT * from porder where posl = '$posl' AND itemCode ='$item'";
// echo '<br>'.$sql.'<br>';
 $sqlQuery=mysqli_query($db, $sql);
 $remainQty0=mysqli_fetch_array($sqlQuery);
 
$order=$remainQty0[qty];
  $sql1="SELECT sum(receiveQty) as total from `store$pp` where paymentSL = '$posl' AND itemCode ='$item'";
// $sql1="SELECT sum(receiveQty) as ROUND(total,3) from  `store$pp` where paymentSL = '$posl' AND itemCode ='$item'";
//  echo '<br>'.$sql1.'<br>';
 $sqlQuery1=mysqli_query($db, $sql1);
 $remainQty1=mysqli_fetch_array($sqlQuery1);
 $remainQty= $order- $remainQty1[total];

// 	echo "========$posl ===== $order-".$remainQty1[total]."===<br>";
	
 return round($remainQty,3);
}
?>
<?
function completePO($posl="PO_%"){
	global $db;
	$sqlPP="SELECT posl from porder where posl LIKE '$posl' and status='1' and posl like 'PO_%'";
	$sqlQQ=mysqli_query($db,$sqlPP);
	while($sqlROW=mysqli_fetch_array($sqlQQ)){
			$sqlpo="SELECT * from porder where posl LIKE '$sqlROW[posl]'";
			$sqlqpo=mysqli_query($db, $sqlpo);
			while($rr=mysqli_fetch_array($sqlqpo)){
			 if(remainQty($posl,$rr[itemCode],$loginProject)!=0){
					$ok=0; break;
				}else $ok=1;
			  //echo "<br>ok:$ok<br>";
			}
		 if($ok){
			 //print "199";
			 $sqlitem1 = "UPDATE `porder` SET status='2' WHERE posl='$sqlROW[posl]' ";
// 		 echo $sqlitem1.'<br>';
			 $query= mysqli_query($db, $sqlitem1);
			}
	} // sqlPP
}





/*---------------------------
input: posl, itemCode Code
output: total remain equipment 
---------------------------------*/

function eqp_remainQty($posl,$item){
 $sql="SELECT * from  porder where posl = '$posl' AND itemCode ='$item'";
//echo '<br>'.$sql.'<br>';
 $sqlQuery=mysqli_query($db, $sql);
 $remainQty0=mysqli_fetch_array($sqlQuery);
 $order=  $remainQty0[qty];

 $sql1="SELECT COUNT(eqid) as total from  `equipment` where reference = '$posl' AND itemCode ='$item'";
//echo '<br>'.$sql1.'<br>';
 $sqlQuery1=mysqli_query($db, $sql1);
 $remainQty1=mysqli_fetch_array($sqlQuery1);
 $remainQty= $order- $remainQty1[total];
 return $remainQty;
}
?>

<?
/*---------------------------
input: posl, itemCode Code
output: total remain Qty for receive from store in transit to store
---------------------------------*/

function remainQty_storet($posl,$item,$pp){
 include("config.inc.php");
 //include("session.inc.php"); 
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

 $sql="SELECT * from  porder where posl = '$posl' AND itemCode ='$item'";
//echo '<br>'.$sql.'<br>';
 $sqlQuery=mysqli_query($db, $sql);
 $remainQty0=mysqli_fetch_array($sqlQuery);
 
$order=  $remainQty0[qty];

 $sql1="SELECT sum(receiveQty) as total from  `storet$pp` where reference = '$posl' AND itemCode ='$item'";
//echo '<br>'.$sql1.'<br>';
 $sqlQuery1=mysqli_query($db, $sql1);
 $remainQty1=mysqli_fetch_array($sqlQuery1);
 $remainQty= $order- $remainQty1[total];

 return $remainQty;
}
?>


<?
/*---------------------------
input: posl, itemCode Code
output: total remain Qty
---------------------------------*/
/*
function cstoreRemainQty($posl,$item,$pp){
 include("config.inc.php");
 //include("session.inc.php"); 
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

 $sql="SELECT * from  sporder where sposl = '$posl' AND itemCode ='$item'";
//echo '<br>'.$sql.'<br>';
 $sqlQuery=mysqli_query($db, $sql);
 $remainQty0=mysqli_fetch_array($sqlQuery);
 
$order=  $remainQty0[qty];

 $sql1="SELECT sum(receiveQty) as total from  `store$pp` where paymentSL = '$posl' AND itemCode ='$item'";
//echo '<br>'.$sql1.'<br>';
 $sqlQuery1=mysqli_query($db, $sql1);
 $remainQty1=mysqli_fetch_array($sqlQuery1);
 $remainQty= $order- $remainQty1[total];

 return $remainQty;
}
*/
?>






<?
/*---------------------------------
INPUT: project code , iow status
OUTPUT:  total iow in that status
---------------------------------*/
function countiow($d,$p,$keyword="mdview IOW",$des=""){
 global $db;
 $sql="SELECT count(*) as total FROM `iowtemp` WHERE ";
	if($des!="MD")$sql.=" iowProjectCode LIKE '%$p%' AND ";
	$sql.="  iowStatus LIKE '%$d%' ";
	if($keyword=="mdview IOW")
		$sql.=" and position not like '888.%' ";
	elseif($keyword=="mdview IOW maintenance")
		$sql.=" and position like '888.%' ";
 //echo $sql;
	
	 $sqlQuery=mysqli_query($db, $sql);
	 $rr=mysqli_fetch_array($sqlQuery);
	 return $rr[total];
}
/*---------------------------------
INPUT: project code , iow status
OUTPUT:  total iow in that status
---------------------------------*/
function countiow_maintenance($d,$p){
 global $db;
 $sql="SELECT count(*) as total FROM `iowtemp` WHERE iowProjectCode LIKE '%$p%' AND iowStatus LIKE '%$d%' and position like '888.%'";
 $sql.=" AND iowCode in (select iowCode from eqmaintenance) ";
 //$sql.=" AND iowCode in (select iowCode from eqmaintenance where pcode='$p')  ";
// echo $sql;
	
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 return $rr[total];
}
function countiow_maintenance_eqc($d){
 global $db;
	if($d=="Approved by MD" || $d=="Completed")
 $sql="SELECT count(*) as total FROM `iow` WHERE iowProjectCode LIKE '004' AND iowStatus LIKE '%$d%' and position like '888.%'";
	else
 $sql="SELECT count(*) as total FROM `iowtemp` WHERE iowProjectCode LIKE '004' AND iowStatus LIKE 'Forward to MD' and position like '888.%'";
// echo $sql;
	
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 return $rr[total];
}
?>
<?
/*---------------------------------
INPUT: project code , iow status
OUTPUT:  total approved iow
---------------------------------*/
function countapviow($d,$p){global $db; 
 $sql="SELECT count(*) as total FROM `iow` WHERE iowProjectCode LIKE '%$p%' AND iowStatus LIKE '%$d%'";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 return $rr[total];
}
/*---------------------------------
INPUT: project code , iow status
OUTPUT:  total approved iow
---------------------------------*/
function countapviow_maintenance($d,$p){global $db; 
 $sql="SELECT count(*) as total FROM `iow` WHERE iowProjectCode LIKE '%$p%' AND iowStatus LIKE '%$d%' and position like '888.%'";
// echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 return $rr[total];
}
?>

<?
/*---------------------------------
INPUT: invoiceStatus
OUTPUT:  total invoice number in that Status
---------------------------------*/
function countInvoice($d){

 include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

 $sql="SELECT DISTINCT invoiceNo FROM `invoice` WHERE invoiceStatus='$d' ";
//echo $sql;
 $sqlQuery=mysqli_query($db,$sql);
 $rr=mysqli_num_rows($sqlQuery);
return $rr;
}

/*---------------------------------
INPUT: invoiceStatus
OUTPUT:  total invoice number in that Status
---------------------------------*/
function countVoucher($d){

 include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

 $sql="SELECT COUNT(id) as total FROM `voucher` WHERE voucherStatus='$d' ";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
return $rr[total];
}

?>
<?
/*
function iowProgress_preport($d,$id){
//echo "-DAYY$d-";
//$d=formatDate($d,'Y-m-d');
 include("config.inc.php");
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

 $sql="SELECT * FROM `iow` WHERE iowId=$id";
//echo $sql.'<br>';
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $sd=$rr[iowSdate];
 $cd=$rr[iowCdate]; 
//echo "$d<=$cd<br>";
if($sd<=$d){
	 if($d<=$cd){
	 $duration=round((strtotime($cd)-strtotime($sd))/(86400));
	 $qty=$rr[iowQty];
	 
	 if($rr[iowUnit]=='L.S' OR $rr[iowUnit]=='LS' OR $rr[iowUnit]=='l.s' OR $rr[iowUnit]=='l.s') $qty=100;
	
	 $perdayWork=$qty/$duration;
	 $dayesGone=abs(round((strtotime($d)-strtotime($sd)-86400)/(86400)));
	 $tillyesterdayWork=round($dayesGone*$perdayWork);
	 $ptillyesterdayWork = round(($tillyesterdayWork*100)/$qty);

	 if($rr[iowUnit]=='L.S' OR $rr[iowUnit]=='LS' OR $rr[iowUnit]=='l.s' OR $rr[iowUnit]=='l.s') $tillyesterdayWork='';	 

return "Planned $tillyesterdayWork <font class=out>$rr[iowUnit]</font> ($ptillyesterdayWork%), ";	 
	}
	else 
return "Planned $rr[iowQty]$rr[iowUnit] <font class=out> (100%)</font>, ";	 
}
else 
return "Planned 0 $rr[iowUnit] <font class=out>(0%)</font>, ";	 
}
?>
<?

function iowActualProgress_preport($d,$id,$p){
$worked=0;
//echo $d;
//$d=formatDate($d,'Y-m-j');
 include("config.inc.php");
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

 $sql="SELECT SUM(qty) as total FROM `iowdaily` WHERE iowId=$id AND edate<='$d'";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
if($rr[total]) $worked = $rr[total];
 
  $sql1="SELECT iowQty,iowUnit FROM `iow` WHERE iowId=$id";
//echo $sql;
 $sqlQuery1=mysqli_query($db, $sql1);
 $rr1=mysqli_fetch_array($sqlQuery1);
 
 if($rr1[iowUnit]=='L.S' OR $rr1[iowUnit]=='LS' OR $rr1[iowUnit]=='l.s' OR $rr1[iowUnit]=='l.s') 
{
 $pworked= $worked;
 $worked= ''; 
} 
else {
 $qt=$rr1[iowQty];
 if($qt>0) $pworked= round(($worked*100)/$qt);
}
//  echo "$worked  <font class=out>$rr1[iowUnit]</font> ($pworked%)";
  
 if($p) return "Actual ".$worked." ".$rr1[iowUnit]." <font class=out>(".$pworked."%)</font>";
 //printiowActualProgress_preport($rr1[iowUnit],$worked,$pworked);
else return $worked;  

}
function printiowActualProgress_preport($unit,$worked,$qt)
{
return "Actual $worked $unit <font class=out>($qt%)</font>;";	 
}
*/
?>




<?
function iowProgress_row($d,$id){
//echo "-DAYY$d-";
	global $db; 
$d=formatDate($d,'Y-m-d');

 $sql="SELECT * FROM `iow` WHERE iowId=$id";
// echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $sd=$rr[iowSdate];
 $cd=$rr[iowCdate]; 
//echo "$d<=$cd<br>";
	if($sd<=$d){
		 if($d<=$cd){
			 $duration=round((strtotime($cd)-strtotime($sd))/(84000));
			 $qty=$rr[iowQty];	 
// 			 echo "///$duration///";
			 if($rr[iowUnit]=='L.S' OR $rr[iowUnit]=='LS' OR $rr[iowUnit]=='l.s' OR $rr[iowUnit]=='l.s') $qty=100;
			 $perdayWork=$qty/$duration;
			 $dayesGone=abs(round((strtotime($d)-strtotime($sd)-86400)/(86400)));
			 
// 			 echo "///$dayesGone///";
			 $tillyesterdayWork=round($dayesGone*$perdayWork);
			 $ptillyesterdayWork = round(($tillyesterdayWork*100)/$qty);
			 if($rr[iowUnit]=='L.S' OR $rr[iowUnit]=='LS' OR $rr[iowUnit]=='l.s' OR $rr[iowUnit]=='l.s') $tillyesterdayWork='';
			 return "$ptillyesterdayWork";	 
			//echo  $tillyesterdayWork.'  <font class=out>'.$rr[iowUnit].'</font>'.' ('.$ptillyesterdayWork.'%) ';
		}
		else
			return "100";
		//echo  $rr[iowQty].'  <font class=out>'.$rr[iowUnit].'</font>'.' (100%) ';
	}
else 
	return "0";
//echo  '00  <font class=out>'.$rr[iowUnit].'</font>'.' (0%) ';
}
?>


<?
function iowProgress_row_edited($d,$id){
//echo "-DAYY$d-";
	global $db; 
$d=formatDate($d,'Y-m-d');

 $sql="SELECT * FROM `iow` WHERE iowId=$id";
// echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $sd=$rr[iowSdate];
 $cd=$rr[iowCdate]; 
//echo "$d<=$cd<br>";
	if($sd<=$d){
		 if($d<=$cd){
			 $duration=round((strtotime($cd)-strtotime($sd))/(84000));
			 $qty=$rr[iowQty];	 
// 			 echo "///$duration///";
			 if($rr[iowUnit]=='L.S' OR $rr[iowUnit]=='LS' OR $rr[iowUnit]=='l.s' OR $rr[iowUnit]=='l.s') $qty=100;
			 $perdayWork=$qty/$duration;
			 $dayesGone=abs(round((strtotime($d)-strtotime($sd)-86400)/(86400)));
			 
// 			 echo "///$dayesGone///";
			 $tillyesterdayWork=round($dayesGone*$perdayWork);
			 $ptillyesterdayWork = round(($tillyesterdayWork*100)/$qty);
			 if($rr[iowUnit]=='L.S' OR $rr[iowUnit]=='LS' OR $rr[iowUnit]=='l.s' OR $rr[iowUnit]=='l.s') $tillyesterdayWork='';
			 return array($tillyesterdayWork,$ptillyesterdayWork);
			//echo  $tillyesterdayWork.'  <font class=out>'.$rr[iowUnit].'</font>'.' ('.$ptillyesterdayWork.'%) ';
		}
		else
			return "100";
		//echo  $rr[iowQty].'  <font class=out>'.$rr[iowUnit].'</font>'.' (100%) ';
	}
else 
	return "0";
//echo  '00  <font class=out>'.$rr[iowUnit].'</font>'.' (0%) ';
}
?>

<?
function iowProgress($d,$id){
//echo "-DAYY$d-";
	global $db; 
$d=formatDate($d,'Y-m-d');

 $sql="SELECT * FROM `iow` WHERE iowId=$id";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $sd=$rr[iowSdate];
 $cd=$rr[iowCdate]; 
//echo "$d<=$cd<br>";
if($sd<=$d){
	 if($d<=$cd){
	 $duration=round((strtotime($cd)-strtotime($sd))/(84000));
	 $qty=$rr[iowQty];
	 
	 if($rr[iowUnit]=='L.S' OR $rr[iowUnit]=='LS' OR $rr[iowUnit]=='l.s' OR $rr[iowUnit]=='l.s') $qty=100;
	
	 $perdayWork=$qty/$duration;
	 $dayesGone=abs(round((strtotime($d)-strtotime($sd)-86400)/(86400)));
	 $tillyesterdayWork=round($dayesGone*$perdayWork);
	 $ptillyesterdayWork = round(($tillyesterdayWork*100)/$qty);

	 if($rr[iowUnit]=='L.S' OR $rr[iowUnit]=='LS' OR $rr[iowUnit]=='l.s' OR $rr[iowUnit]=='l.s') $tillyesterdayWork='';	 

echo "
<table width=100% cellpadding=1 cellspacing=0 >
<tr>
 <td width=70% align=right> $tillyesterdayWork $rr[iowUnit]</td>
 <td width=30% align=right> <font class=out>($ptillyesterdayWork%)</font></td> 
</tr>
</table>
";	 
	//echo  $tillyesterdayWork.'  <font class=out>'.$rr[iowUnit].'</font>'.' ('.$ptillyesterdayWork.'%) ';
	}
	else 
echo "
<table width=100% cellpadding=1 cellspacing=0 >
<tr>
 <td width=70% align=right> $rr[iowQty] $rr[iowUnit]</td>
 <td width=30% align=right> <font class=out>(100%)</font></td> 
</tr>
</table>
";	 
	
	//echo  $rr[iowQty].'  <font class=out>'.$rr[iowUnit].'</font>'.' (100%) ';
}
else 
echo "
<table width=100% cellpadding=1 cellspacing=0 >
<tr>
 <td width=70% align=right> 0 $rr[iowUnit]</td>
 <td width=30% align=right> <font class=out>(0%)</font></td> 
</tr>
</table>
";	 

//echo  '00  <font class=out>'.$rr[iowUnit].'</font>'.' (0%) ';
}
?>

<?
function iowProgress_return_val($d,$id){
//echo "-DAYY$d-";
	global $db; 
//$d=formatDate($d,'Y-m-d');

 $sql="SELECT * FROM `iow` WHERE iowId=$id";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $sd=$rr[iowSdate];
 $cd=$rr[iowCdate]; 
//echo "$d<=$cd<br>";
if($sd<=$d){
	 if($d<=$cd){
	 $duration=round((strtotime($cd)-strtotime($sd))/(84000));
	 $qty=$rr[iowQty];
	 
	 if($rr[iowUnit]=='L.S' OR $rr[iowUnit]=='LS' OR $rr[iowUnit]=='l.s' OR $rr[iowUnit]=='l.s') $qty=100;
	
	 $perdayWork=$qty/$duration;
	 $dayesGone=abs(round((strtotime($d)-strtotime($sd)-86400)/(86400)));
	 $tillyesterdayWork=round($dayesGone*$perdayWork);
	  $ptillyesterdayWork = round(($tillyesterdayWork*100)/$qty);

	 if($rr[iowUnit]=='L.S' OR $rr[iowUnit]=='LS' OR $rr[iowUnit]=='l.s' OR $rr[iowUnit]=='l.s') $tillyesterdayWork='';	 

 
 return $ptillyesterdayWork."% (".$tillyesterdayWork." ".$rr[iowUnit].")";	 
	//echo  $tillyesterdayWork.'  <font class=out>'.$rr[iowUnit].'</font>'.' ('.$ptillyesterdayWork.'%) ';
	}
	else 
	return $rr[iowQty]." ".$rr[iowUnit];	 
	
}
else 
return  "0 ".$rr[iowUnit];	 


}
?>
<?
function iowProgress_income_statement($d,$id){
//echo "-DAYY$d-";
	global $db; 
$d=formatDate($d,'Y-m-d');

  $sql="SELECT * FROM `iow` WHERE iowId=$id";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $sd=$rr[iowSdate];
 $cd=$rr[iowCdate]; 
//echo "$d<=$cd<br>";
if($sd<=$d){
	 if($d<=$cd){
	 $duration=round((strtotime($cd)-strtotime($sd))/(84000));
	 $qty=$rr[iowQty];
	 
	 if($rr[iowUnit]=='L.S' OR $rr[iowUnit]=='LS' OR $rr[iowUnit]=='l.s' OR $rr[iowUnit]=='l.s') $qty=100;
	
	 $perdayWork=$qty/$duration;
	 $dayesGone=abs(round((strtotime($d)-strtotime($sd)-86400)/(86400)));
	 $tillyesterdayWork=round($dayesGone*$perdayWork);
	  $ptillyesterdayWork = round(($tillyesterdayWork*100)/$qty);

	 if($rr[iowUnit]=='L.S' OR $rr[iowUnit]=='LS' OR $rr[iowUnit]=='l.s' OR $rr[iowUnit]=='l.s') $tillyesterdayWork='';	 

 return $ptillyesterdayWork	; 
	//echo  $tillyesterdayWork.'  <font class=out>'.$rr[iowUnit].'</font>'.' ('.$ptillyesterdayWork.'%) ';
	}
	else 
return 100;
	
	//echo  $rr[iowQty].'  <font class=out>'.$rr[iowUnit].'</font>'.' (100%) ';
}
else 
return 0;

//echo  '00  <font class=out>'.$rr[iowUnit].'</font>'.' (0%) ';

}
?>

<?
function iowProgress_for_incomestatement($d,$id)
{
/*
$d=formatDate($d,'Y-m-d');

 $sql="SELECT * FROM `iow` WHERE iowId=$id";
 $sqlQuery=mysqli_query($db, $sql);
  $ppper=0;
 while($rr=mysqli_fetch_array($sqlQuery))
 {
 $sd=$rr[iowSdate];
 $cd=$rr[iowCdate]; 
if($sd<=$d)
{
	 if($d<=$cd)
	 {
		 $duration=round((strtotime($cd)-strtotime($sd))/(84000));
		 $qty=$rr[iowQty];
		 
		 if($rr[iowUnit]=='L.S' OR $rr[iowUnit]=='LS' OR $rr[iowUnit]=='l.s' OR $rr[iowUnit]=='l.s') $qty=100;
		
		 $perdayWork=$qty/$duration;
		 $dayesGone=abs(round((strtotime($d)-strtotime($sd)-86400)/(86400)));
		 $tillyesterdayWork=round($dayesGone*$perdayWork);
		 $ptillyesterdayWork = ($tillyesterdayWork*100)/$qty; ///ai logic a dhuktasa?
		 
		 $ppper+=round($ptillyesterdayWork);
	
			 
	}
	else 
		echo "<font class=out>(100%)</font>";	 
}
else 
	echo " <font class=out>(0%)</font>";	 
}
echo "<font class=out>($ppper%)</font>";*/
}
?>
<?

function iowActualProgress1($d,$id,$p){
$worked=0;
$d=formatDate($d,'Y-m-j');
 include("config.inc.php");
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

 $sql="SELECT SUM(qty) as total FROM `iowdaily` WHERE iowId=$id AND edate<='$d'";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $worked = $rr[total];
 
  $sql1="SELECT iowQty,iowUnit FROM `iow` WHERE iowId=$id";
//echo $sql;
 $sqlQuery1=mysqli_query($db, $sql1);
 $rr1=mysqli_fetch_array($sqlQuery1);
 
 if($rr1[iowUnit]=='L.S' OR $rr1[iowUnit]=='LS' OR $rr1[iowUnit]=='l.s' OR $rr1[iowUnit]=='l.s') 
{
 $pworked= $worked;
 $worked= ''; 
} 
else {

 $qt=$rr1[iowQty];
 if($qt>0) $pworked= round(($worked*100)/$qt);
}
//  echo "$worked  <font class=out>$rr1[iowUnit]</font> ($pworked%)";
  
 if($p) printiowActualProgress1($rr1[iowUnit],$worked,$pworked);
  
//return  0;
}
function printiowActualProgress1($unit,$worked,$qt)
{
echo "
<table width=100% cellpadding=1 cellspacing=0 >
<tr>
 <td width=70% align=right>  </td>
 <td width=30% align=right> $qt%</td> 
</tr>
</table>";	 
}
?>

<?

function siowProgress($d,$id){
//echo "-DAYY$d-";
$d=formatDate($d,'Y-m-d');
 include("config.inc.php");
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

 $sql="SELECT * FROM `siow` WHERE siowId=$id";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $sd=$rr[siowSdate];
 $cd=$rr[siowCdate]; 
//echo "$d<=$cd<br>";
if($sd<=$d){
	 if($d<=$cd){
	 $duration=round((strtotime($cd)-strtotime($sd))/(84000));
	 $qty=$rr[siowQty];
	 
	 if($rr[siowUnit]=='L.S' OR $rr[iowUnit]=='LS' OR $rr[iowUnit]=='l.s' OR $rr[iowUnit]=='l.s') $qty=100;
	
	 $perdayWork=$qty/$duration;
	 $dayesGone=abs(round((strtotime($d)-strtotime($sd)-84000)/(84000)));
	 $tillyesterdayWork=round($dayesGone*$perdayWork);
	 $ptillyesterdayWork = round(($tillyesterdayWork*100)/$qty);

	 if($rr[siowUnit]=='L.S' OR $rr[siowUnit]=='LS' OR $rr[siowUnit]=='l.s' OR $rr[siowUnit]=='l.s') $tillyesterdayWork='';	 

echo "
<table width=100% cellpadding=1 cellspacing=0 >
<tr>
 <td width=70% align=right> $tillyesterdayWork $rr[siowUnit]</td>
 <td width=30% align=right> <font class=out>($ptillyesterdayWork%)</font></td> 
</tr>
</table>
";	 
	//echo  $tillyesterdayWork.'  <font class=out>'.$rr[iowUnit].'</font>'.' ('.$ptillyesterdayWork.'%) ';
	}
	else 
echo "
<table width=100% cellpadding=1 cellspacing=0 >
<tr>
 <td width=70% align=right> $rr[siowQty] $rr[siowUnit]</td>
 <td width=30% align=right> <font class=out>(100%)</font></td> 
</tr>
</table>
";	 
	
	//echo  $rr[iowQty].'  <font class=out>'.$rr[iowUnit].'</font>'.' (100%) ';
}
else 
echo "
<table width=100% cellpadding=1 cellspacing=0 >
<tr>
 <td width=70% align=right> 0 $rr[siowUnit]</td>
 <td width=30% align=right> <font class=out>(0%)</font></td> 
</tr>
</table>
";	 

//echo  '00  <font class=out>'.$rr[iowUnit].'</font>'.' (0%) ';

}

?>

<?
/*---------------------------------
INPUT: status 
OUTPUT:  total number in that status
---------------------------------*/
function countpo($p){

 include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

if($p==-1)  $sql="SELECT count(distinct posl) as total FROM `pordertemp` WHERE status='$p' AND posl not like 'EP_%'"; 
elseif($p==-2)  $sql="SELECT count(distinct posl) as total FROM `pordertemp` WHERE status='$p' AND posl not like 'EP_%'"; 
else if($p==0)  $sql="SELECT count(distinct posl) as total FROM `pordertemp` WHERE status='$p' AND posl not like 'EP_%'"; 
else if($p==3)  $sql="SELECT count(distinct posl) as total FROM `pordertemp` WHERE status='$p' AND posl not like 'EP_%'"; 
else $sql="SELECT count(distinct posl) as total FROM `porder` WHERE status='$p' AND posl not like 'EP_%' "; 

// 	print_r($_SESSION);
 if($_SESSION["loginDesignation"]=="Procurement Executive")$sql.=" and location='".$_SESSION["loginProject"]."'";
	//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
//echo $empId;
return $rr[total];
}
?>


<?php 
function iowID2iow($id){
	global $db;
	$sql="select * from iow where iowId='$id'";
	$q=mysqli_query($db, $sql);
	return mysqli_fetch_array($q);
}

?>

<?php 
function siowIdID2siow($id){
	global $db;
	$sql="select * from siow where siowId='$id'";
	$q=mysqli_query($db, $sql);
	return mysqli_fetch_array($q);
}

?>

<?php 
function siteEngID2SiteEng($id){
	global $db;
	$sql="select * from user where uname='$id'";
	$q=mysqli_query($db, $sql);
	return mysqli_fetch_array($q);
}

function userID2userInfo($id,$col="*"){
	if($id<0 || empty($id))return "No user found";
	global $db;
	echo $sql="select $col from user where id='$id'";
	$q=mysqli_query($db, $sql);
	$row=mysqli_fetch_array($q);
	if(mysqli_affected_rows($db)<1)return "invalid user";
	return $col!="*" ? $row[$col]."u" : $row;
}

function empID2empInfo($id,$col="*"){
	if($id<0 || empty($id))return "No user found";
	global $db;
	$sql="select $col from employee where empId='$id'";
	$q=mysqli_query($db, $sql);
	$row=mysqli_fetch_array($q);
	if(mysqli_affected_rows($db)<1)return "invalid user";
	
	return $col!="*" ? $row[$col] : $row;
}

?>


<?
// error message genarotor

function inwornMsg($m){
$errorMsg= "<table width=400 align=center border=2 cellspacing=0 cellpading=0 style='border-collapse: collapse' bordercolor=#FF0000>";
$errorMsg.="<tr><td><img src='./images/s_warn.png'><b>$m</b></td></tr>";
$errorMsg.="</table>";
return $errorMsg;
}
?>
<?
// in ok message genarotor

function inokMsg($m){
$errorMsg= "<table width=400 align=center border=2 cellspacing=0 cellpading=0 style='border-collapse: collapse' bordercolor=#99FF99>";
$errorMsg.="<tr><td><img src='./images/s_okay.png'>   <b>$m</b></td></tr>";
$errorMsg.="</table>";
return $errorMsg;
}
?>
<?
// worning message genarotor

function wornMsg($m){
$errorMsg= "<table width=400 align=center border=2 cellspacing=0 cellpading=0 style='border-collapse: collapse' bordercolor=#FF0000>";
$errorMsg.="<tr><td><img src='../images/s_warn.png'><b>$m</b></td></tr>";
$errorMsg.="</table>";
return $errorMsg;
}
?>
<?
// ok message genarotor

function okMsg($m){
$errorMsg= "<table width=400 align=center border=2 cellspacing=0 cellpading=0 style='border-collapse: collapse' bordercolor=#009933>";
$errorMsg.="<tr><td><img src='../images/s_okay.png'>   <b>$m</b></td></tr>";
$errorMsg.="</table>";
return $errorMsg;
}
?>

<?
/* 
input referrence and project code
return emmergency purchase date*/
function ep_purchaseDate($reff,$pcode){
	global $db; 
$sql="SELECT todat from storet$pcode WHERE paymentSL='$reff'";
//echo "$sql";
$sqlq=mysqli_query($db, $sql);
$r=mysqli_fetch_array($sqlq);
return $r[todat];
}
?>
<? 
/* ---------------------------
  Input iow ID
 return revision list with printable format page link
-------------------------------*/
function getRevisionList($iowId){
	global $db; 
$sql="select distinct revisionNo from iowback where iowId='$iowId' ORDER by revisionNo DESC";
$sqlq=mysqli_query($db, $sql);
$i=0;
while($r=mysqli_fetch_array($sqlq)){
if($i) echo "[ <a target='_blank' href='./print/print_iow.php?iowId=$iowId&r=$r[revisionNo]'>$r[revisionNo]</a> ]";
$i=1;
 }//while

}?>
<?
/* ---------------------------
  Input the posl
 return the activation date of purchase order
-------------------------------*/

function poDate($posl)
{
	
 include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$sqlff="SELECT activeDate FROM porder where posl='$posl'";
//echo $sqlff;
$sqlf=mysqli_query($db, $sqlff);
$r=mysqli_fetch_array($sqlf);
 return $r[activeDate];
}

/* ---------------------------
  Input the posl
 return the activation date of purchase order
-------------------------------*/
 

//Site rate function 
function siteRate($itemCode){
	include("config.inc.php");
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	$sql="SELECT * from siterate WHERE itemcode = '$itemCode'";
	$sqlt=mysqli_query($db,$sql);
	$rateS=mysqli_fetch_assoc($sqlt);		
	return $rateS['amount'];
}


function is_po_closed($posl){
	include("config.inc.php");
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	$sqlp = "SELECT * FROM `po_force_close_approval` WHERE is_complete =1 and posl = '$posl'";
	//echo $sqlp;
	$sqlrunp= mysqli_query($db, $sqlp);
	$typel= mysqli_fetch_array($sqlrunp);
	return $typel;
}


function is_po_in_fc_list($posl){
	global $db;
	$sql="select count(*) as rr from po_force_close_approval where posl='$posl'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row["rr"]>0 ? true : false;
}
function is_po_in_fc_text($posl){
	global $db;
	$sql="select text from po_force_close_approval where posl='$posl'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row["text"];
}

function is_po_sch_fail($p,$posl){
	global $db;
	$sqlp1="SELECT s.itemCode,sum(s.qty) qty,p.rate rate, sum(s.qty)*sum(p.rate) total,s.sdate, s.invoice,p.advanceType , p.activeDate
	FROM poschedule s, porder p where p.posl='$posl' and s.posl=p.posl and p.itemCode=s.itemCode and p.itemCode=s.itemCode group by s.sdate ORDER by s.sdate,s.itemCode DESC";
    //echo $sqlp1;
	$sqlq=mysqli_query($db, $sqlp1); 
	while($re=mysqli_fetch_array($sqlq)){
		$invoice_quantity = $re['qty'];
		$itemCode = $re['itemCode'];
		$invoice_date = $re['sdate'];
	    $totalRecieve = totalReceive(date('Y-m-d'),$p,$posl,$itemCode);
	    //$totalRecieve = 210;
		//$invoice_quantity;
		//return $totalRecieve;
		//return $invoice_date;
		//die();
		if(strtotime(date("Y-d-m")) > strtotime($invoice_date)){
			if($totalRecieve < $invoice_quantity){
	    			return 1;
			}
				
	}
    }
	}

// function is_po_schedule_fail($posl,$pp){
//     //$todat = date("Y-m-d");
// 	global $db; 
	
// 	$sqlp1="SELECT s.itemCode,sum(s.qty) qty,p.rate rate, sum(s.qty)*sum(p.rate) total,s.sdate, s.invoice,p.advanceType 
// 	FROM poschedule s, porder p where p.posl='$posl'
// 	and s.posl=p.posl and p.itemCode=s.itemCode and p.itemCode=s.itemCode group by s.sdate ORDER by s.sdate,s.itemCode DESC";

// 	$sqlq=mysqli_query($db, $sqlp1);
// 	$r=mysqli_fetch_array($sqlq);	

// 	$sql="SELECT * FROM porder where posl='$posl' AND qty>0 ORDER by itemCode ASC";
// 	//echo "$sql";
// 	$sqlq=mysqli_query($db, $sql);
// 	while($re=mysqli_fetch_array($sqlq)){
// 		$po_mat_recieve = po_mat_receiveExt($re[itemCode],$posl,$pp);
// 		$potype = $re[potype];
		
// 		if($potype=1)
// 		$totalReceive=totalReceive('9999-00-00',$pp,$posl,$re[itemCode]);
// 		else if($potype=3)
// 		$totalReceive= subWork_Po($re[itemCode],$posl);
// 	}
// 	 //return $totalReceive;
// 	 //return $po_mat_recieve;
     
// 	 $recieve_quantity = ($po_mat_recieve/$totalReceive);
// 	 $invoice_quantity = $r[qty];
    
// 	 //return $recieve_quantity;  //9112.56
// 	 //return $invoice_quantity;  //6.2
	
// 	 if($recieve_quantity < $invoice_quantity){
// 		return 1;
// 	}
// 	else 
// 	return 0;
// }

 ?>
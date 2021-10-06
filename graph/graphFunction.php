<? 
session_start();
error_reporting(0);

function count_dot_number($val){
	$i=$j=0;
	$valArry=explode(".",$val);
	foreach($valArry as $valSingle){
		$i++;
		if($valSingle>0)$j=$i;
	}
	return $j;
}

//input XXX.XXX.XXX.XXX output XXX.___.___.___ for main head other similar like that
function sql_position_maker($pos){
	$c=count_dot_number($pos);
	$posArry=explode(".",$pos);
	switch($c){
		case "1":
			return $posArry[0].".___.___.___";
		case "2":
			return $posArry[0].".".$posArry[1].".___.___";
		case "3":
			return $posArry[0].".".$posArry[1].".".$posArry[2].".___";
	}
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


function jsDateExploder($dt){
	
	$d_array=explode("-",$dt);
	if(!$d_array[2] || $d_array[2]<2010)$d_array[2]=2016;
	if(!$d_array[1])$d_array[1]=01;
	if(!$d_array[0])$d_array[0]=01;
	return "$d_array[2],$d_array[1],$d_array[0]";
}

function project_duration($pcode){
	global $db;
	$sql="SELECT min(iowSdate) as start, max(iowCdate) as finish from iow where iowprojectCode='$pcode'  and iowStatus!='noStatus'  and iowSdate>'0000-00-00' and iowCdate>'0000-00-00'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row;
}

function head_duration($pcode,$pos){	
	global $db;
	$position=sql_position_maker($pos);
	
	

$iowType=" and iowType=1 ";
		if($pcode=="004" && $_GET["maintenance"]==1){
			$iowType=" ";
		}
	
// 	echo $pos;
	$sql="SELECT min(iowSdate) as start, max(iowCdate) as finish from iow where iowprojectCode='$pcode'  and iowStatus!='noStatus' and position like '$position' and position!='$pos' $iowType and position!='999.000.000.000' and iowSdate>'0000-00-00' and iowCdate>'0000-00-00'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
// 	print_r($row);
// 	echo $sql;
// 	exit;
	return $row;
}

function date2dateRange($sdat,$edat){
	return floor((strtotime($edat)-strtotime($sdat))/(60*60*24));
}



function gp_iowActualProgress($iow,$p,$ed,$totalQty,$unit,$c){
global $db;
$approvedTotalAmount=iowApprovedCost($iow);
$totalMaretialCost=totalMaretialCost($iow,$p,$ed,$c);
// echo "<br>++$totalMaretialCost++<br>";
$totalempCost=totalempCost($iow,$p,$ed,$c);
$totalSubconCost=totalSubconCost($iow,$p,$ed,$c);
// echo "<br>-----$totalSubconCost----<br>";

$totaleqCost=totaleqCost($iow,$p,$ed,$c);


$actualTotalAmount=$totalMaretialCost+$totalempCost+$totalSubconCost+$totaleqCost;
// echo "<br>$actualTotalAmount=$approvedTotalAmount<br>";
$progressp=($actualTotalAmount*100)/$approvedTotalAmount;

$progressQty=($totalQty*$progressp)/100;
if($progressp>100) return '100';
	else return round($progressp);
}


function allIOWStatus($position,$pcode){
	global $db;
	$sql_position=sql_position_maker($position);
	$sql="select * from iow where position like '$sql_position' and iowProjectCode='$pcode'";
	$q=mysqli_query($db,$sql);
	$totalFound=mysqli_affected_rows($db);
	while($row=mysqli_fetch_array($q)){
		
	}
}
function totalMaretialCost($iow,$p,$ed,$c){
$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
include($localPath."/includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

if($c)
$sqlm = "SELECT sum(issuedQty*issueRate) as totalMaterialCost from issue$p WHERE iowId=$iow AND issueDate='$ed'";
else 
$sqlm = "SELECT sum(issuedQty*issueRate) as totalMaterialCost from issue$p WHERE iowId=$iow AND issueDate<='$ed'";
//echo "$sqlm<br>";
$sqlmq=mysqli_query($db, $sqlm);
$sqlmr=mysqli_fetch_array($sqlmq);
$totalMaterialCost=$sqlmr[totalMaterialCost];
if($totalMaterialCost>0)return $totalMaterialCost;
else return 0;
}
function totalempCost($iow,$p,$ed,$c){
$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
include($localPath."/includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$sql="SELECT distinct dmaItemCode from dma where".
" dmaiow=$iow AND dmaItemCode between '70-00-000' AND '98-99-999'".
" Order by dmaItemCode ASC";

$sqlq=mysqli_query($db, $sql);
while($sqlr=mysqli_fetch_array($sqlq))
	{
	$empTotalWorkiow=empTotalWorkiow($sqlr[dmaItemCode],$iow,$ed,$c);
	$hrApprovedRate=hrApprovedRate($sqlr[dmaItemCode],$iow)/3600;
	$subtotalHumanCost=$empTotalWorkiow*$hrApprovedRate;
	$totalHumanCost=$totalHumanCost+$subtotalHumanCost;
	}
	return $totalHumanCost;
}
function hrApprovedRate($itemCode,$iow){
$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
include($localPath."/includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$sql="SELECT AVG(dmaRate) as hrRate from dma where dmaItemCode='$itemCode' AND dmaiow='$iow'";
$sqlq=mysqli_query($db, $sql);
$sqlr=mysqli_fetch_array($sqlq);
return $sqlr[hrRate];
}
function totalSubconCost($iow,$p,$ed,$c){
$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
include($localPath."/includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$sql="SELECT distinct dmaItemCode from dma where".
" dmaiow=$iow AND dmaItemCode between '99-00-000' AND '99-50-999' Order by dmaItemCode ASC";
$sqlq=mysqli_query($db, $sql);
if($c)
{

while($sqlr=mysqli_fetch_array($sqlq))
{

	$sqlm = "SELECT sum(qty*rate) as totalSubconCost from subut".
	" WHERE edate='$ed' AND iow=$iow AND itemCode='$sqlr[dmaItemCode]'";
	$sqlmq=mysqli_query($db, $sqlm);
	$sqlmr=mysqli_fetch_array($sqlmq);
	$subtotalSubconCost=$sqlmr[totalSubconCost];
	$totalSubconCost=$totalSubconCost+$subtotalSubconCost;
}	
}
else {
while($sqlr=mysqli_fetch_array($sqlq))
{
	$sqlm = "SELECT sum(qty*rate) as totalSubconCost from subut".
	" WHERE edate<='$ed' AND iow=$iow AND itemCode='$sqlr[dmaItemCode]'";

	$sqlmq=mysqli_query($db, $sqlm);
	$sqlmr=mysqli_fetch_array($sqlmq);
	$subtotalSubconCost=$sqlmr[totalSubconCost];
	$totalSubconCost=$totalSubconCost+$subtotalSubconCost;
}	
}
return $totalSubconCost;
}
function totaleqCost($iow,$p,$ed,$c){
$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
include($localPath."/includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$sql="SELECT distinct dmaItemCode from dma where".
" dmaiow=$iow AND dmaItemCode between '50-00-000' AND '69-99-999' Order by dmaItemCode ASC";
$sqlq=mysqli_query($db, $sql);
while($sqlr=mysqli_fetch_array($sqlq))
	{
	$empTotalWorkiow=eqTotalWorkiow($sqlr[dmaItemCode],$iow,$ed,$c);
	$hrApprovedRate=eqApprovedRate($sqlr[dmaItemCode],$iow);  
	$subtotalHumanCost=$empTotalWorkiow*$hrApprovedRate;
	$totalHumanCost=$totalHumanCost+$subtotalHumanCost;
	}
return $totalHumanCost;
}
function eqApprovedRate($itemCode,$iow){
$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
include($localPath."/includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sql="SELECT AVG(dmaRate) as eqRate from dma where dmaItemCode='$itemCode' AND dmaiow='$iow'";
$sqlq=mysqli_query($db, $sql);
$sqlr=mysqli_fetch_array($sqlq);
//return $sqlr[eqRate]/(8*3600); //per sec rate
return $sqlr[eqRate]/3600; 
}

function iowApprovedCost($iow){
$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
include($localPath."/includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$sqlm = "SELECT sum(dmaQty*dmaRate) as totalCost from dma WHERE dmaiow=$iow ";

$sqlmq=mysqli_query($db, $sqlm);
$sqlmr=mysqli_fetch_array($sqlmq);
$totalCost=$sqlmr[totalCost];
return $totalCost;
}
function gp_siowActualProgress($siow,$p,$ed,$totalQty,$unit,$c,$progressp){

//echo "<br>$siow,$p,$ed,$totalQty,$unit,$c<br>";
$approvedTotalAmount=siowApprovedCost($siow);

//echo "<br>``````````$approvedTotalAmount`````````<br>";
$totalMaretialCost=siowtotalMaretialCost($siow,$p,$ed,$c);

$totalempCost=siowtotalempCost($siow,$p,$ed,$c);
$totalSubconCost=siowtotalSubconCost($siow,$p,$ed,$c);


$totaleqCost=totaleqCost($siow,$p,$ed,$c);


$actualTotalAmount=$totalMaretialCost+$totalempCost+$totalSubconCost+$totaleqCost;
if($approvedTotalAmount>0) 
$progressp=($actualTotalAmount*100)/$approvedTotalAmount;
else $progressp==0;
$progressQty=($totalQty*$progressp)/100;
return round($progressp);
}

function siowtotalMaretialCost($siow,$p,$ed,$c){
$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
include($localPath."/includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

if($c)$sqlm = "SELECT sum(issuedQty*issueRate) as totalMaterialCost from issue$p WHERE siowId=$siow AND issueDate='$ed'";
else $sqlm = "SELECT sum(issuedQty*issueRate) as totalMaterialCost from issue$p WHERE siowId=$siow AND issueDate<='$ed'";

$sqlmq=mysqli_query($db, $sqlm);
$sqlmr=mysqli_fetch_array($sqlmq);
$totalMaterialCost=$sqlmr[totalMaterialCost];
return $totalMaterialCost;
}
function siowtotalempCost($siow,$p,$ed,$c){
$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
include($localPath."/includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$sql="SELECT distinct dmaItemCode from dma where".
" dmasiow=$siow AND dmaItemCode between '70-00-000' AND '98-99-999'".
" Order by dmaItemCode ASC";

$sqlq=mysqli_query($db, $sql);
while($sqlr=mysqli_fetch_array($sqlq))
	{
	$empTotalWorkiow=empTotalWorksiow($sqlr[dmaItemCode],$siow,$ed,$c);
	$hrApprovedRate=hrApprovedRatesiow($sqlr[dmaItemCode],$siow)/3600;
	$subtotalHumanCost=$empTotalWorksiow*$hrApprovedRatesiow;
	$totalHumanCost=$totalHumanCost+$subtotalHumanCost;
	}
	return $totalHumanCost;
}
function hrApprovedRatesiow($itemCode,$siow){
$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
include($localPath."/includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$sql="SELECT AVG(dmaRate) as hrRate from dma where dmaItemCode='$itemCode' AND dmasiow='$siow'";
$sqlq=mysqli_query($db, $sql);
$sqlr=mysqli_fetch_array($sqlq);
return $sqlr[hrRate];
}
function siowtotalSubconCost($siow,$p,$ed,$c){
$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
include($localPath."/includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$sql="SELECT distinct dmaItemCode from dma where".
" dmasiow=$siow AND dmaItemCode between '99-00-000' AND '99-50-999' Order by dmaItemCode ASC";
$sqlq=mysqli_query($db, $sql);
if($c){
while($sqlr=mysqli_fetch_array($sqlq))
{
	$sqlm = "SELECT sum(qty*rate) as totalSubconCost from subut WHERE edate='$ed' AND siow=$siow AND itemCode='$sqlr[dmaItemCode]'";
	$sqlmq=mysqli_query($db, $sqlm);
	$sqlmr=mysqli_fetch_array($sqlmq);
	$subtotalSubconCost=$sqlmr[totalSubconCost];
	$totalSubconCost=$totalSubconCost+$subtotalSubconCost;
}	
}
else {
while($sqlr=mysqli_fetch_array($sqlq))
{
	$sqlm = "SELECT sum(qty*rate) as totalSubconCost from subut WHERE edate<='$ed' AND siow=$siow AND itemCode='$sqlr[dmaItemCode]'";
	$sqlmq=mysqli_query($db, $sqlm);
	$sqlmr=mysqli_fetch_array($sqlmq);
	$subtotalSubconCost=$sqlmr[totalSubconCost];
	$totalSubconCost=$totalSubconCost+$subtotalSubconCost;
}	
}
return $totalSubconCost;
}
function siowtotaleqCost($iow,$p,$ed,$c){
$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
include($localPath."/includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$sql="SELECT distinct dmaItemCode from dma where".
" dmasiow=$siow AND dmaItemCode between '50-00-000' AND '69-99-999' Order by dmaItemCode ASC";
$sqlq=mysqli_query($db, $sql);
while($sqlr=mysqli_fetch_array($sqlq))
	{
	$empTotalWorksiow=eqTotalWorksiow($sqlr[dmaItemCode],$siow,$ed,$c);
	$hrApprovedRate=eqApprovedRatesiow($sqlr[dmaItemCode],$siow)/3600;
	$subtotalHumanCost=$empTotalWorksiow*$hrApprovedRate;
	$totalHumanCost=$totalHumanCost+$subtotalHumanCost;
	}
	return $totalHumanCost;
}
function eqApprovedRatesiow($itemCode,$iow){
$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
include($localPath."/includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$sql="SELECT AVG(dmaRate) as eqRate from dma where dmaItemCode='$itemCode' AND dmasiow='$siow'";
$sqlq=mysqli_query($db, $sql);
$sqlr=mysqli_fetch_array($sqlq);
return $sqlr[eqRate];
}
function siowApprovedCost($siow){
$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
include($localPath."/includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$sqlm = "SELECT sum(dmaQty*dmaRate) as totalCost from dma WHERE dmasiow=$siow ";
$sqlmq=mysqli_query($db, $sqlm);
$sqlmr=mysqli_fetch_array($sqlmq);
$totalCost=$sqlmr[totalCost];
return $totalCost;
}
function formatDate($date,$format){

if (ereg ("([0-9]{2})/([0-9]{2})/([0-9]{4})", $date, $regs)) {
	return date($format, mktime(0,0,0,$regs[2], $regs[1], $regs[3]));
  }
}
function eqTotalWorkiow($itemCode,$iow,$d,$c){
$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
include($localPath."/includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

if($c){
 $sql="SELECT SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as duration FROM `equt`".
 " WHERE itemCode = '$itemCode' AND iow='$iow' AND edate='$d'";
 }
 else {
 $sql="SELECT SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as duration FROM `equt`".
 " WHERE itemCode = '$itemCode' AND iow='$iow' AND edate<='$d'";
 
 }

 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $totalTime = $rr[duration];
 return abs($totalTime);
 }
function empTotalWorkiow($itemCode,$iow,$d,$c){

$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
include($localPath."/includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

if($c)
{
 $sql="SELECT SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as duration FROM `emput`".
 " WHERE designation = '$itemCode' AND iow='$iow' AND edate='$d'";
}
else {
 $sql="SELECT SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as duration FROM `emput`".
 " WHERE designation = '$itemCode' AND iow='$iow' AND edate<='$d'";
 }

 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $totalTime = $rr[duration];
 return abs($totalTime);
 }
 
 function empTotalWorksiow($itemCode,$siow,$d,$c){

$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
include($localPath."/includes/config.inc.php");
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

if($c)
{
 $sql="SELECT SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as duration FROM `emput`".
 " WHERE designation = '$itemCode' AND siow='$siow' AND edate='$d'";
}
else {
 $sql="SELECT SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as duration FROM `emput`".
 " WHERE designation = '$itemCode' AND siow='$siow' AND edate<='$d'";
 }
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $totalTime = $rr[duration];
 return abs($totalTime);
 }
?>
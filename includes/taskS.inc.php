<?php



function iowApprovedCost($iow){
global $db;
	

$sqlm = "SELECT sum(dmaQty*dmaRate) as totalCost from dma WHERE dmaiow=$iow ";

$sqlmq=mysqli_query($db, $sqlm);
$sqlmr=mysqli_fetch_array($sqlmq);
$totalCost=$sqlmr[totalCost];
return $totalCost;
  
  
}

function totalMaretialCost($iow,$p,$ed,$c){
global $db;

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
include("../includes/config.inc.php");
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


function totalSubconCost($iow,$p,$ed,$c){
include("../includes/config.inc.php");
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
include("../includes/config.inc.php");
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





?>
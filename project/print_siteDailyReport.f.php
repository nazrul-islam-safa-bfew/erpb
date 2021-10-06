<?
function gp_iowActualProgress($iow,$p,$ed,$totalQty,$unit,$c){
//$ed=formatDate($ed,'Y-m-j');
$approvedTotalAmount=iowApprovedCost($iow);

$totalMaretialCost=totalMaretialCost($iow,$p,$ed,$c);
//echo "<br>**totalMaretialCost=$totalMaretialCost**<br>";
$totalempCost=totalempCost($iow,$p,$ed,$c);
$totalSubconCost=totalSubconCost($iow,$p,$ed,$c);

//echo "<br>**totalempCost=$totalempCost**<br>";
$totalSubconCost=totalSubconCost($iow,$p,$ed,$c);
//echo "<br>**totalSubconCost=totalSubconCost**<br>";

$totaleqCost=totaleqCost($iow,$p,$ed,$c);
//echo "<br>**totaleqCost=$totaleqCost**<br>";

$actualTotalAmount=$totalMaretialCost+$totalempCost+$totalSubconCost+$totaleqCost;

$progressp=($actualTotalAmount*100)/$approvedTotalAmount;

$progressQty=($totalQty*$progressp)/100;
/* if($unit=='L.S' OR $unit=='LS' OR $unit=='l.s' OR $unit=='l.s') 
	return $unit.' <font class=out>('.number_format($progressp).'%)</font>'; 
else  
	return number_format($progressQty).' '.$unit.' <font class=out>('.number_format($progressp).'%)</font>';
	*/
	return $progressp;
}
?>
<?
function iowActualProgress($iow,$p,$ed,$totalQty,$unit,$c){
//$ed=formatDate($ed,'Y-m-j');
//echo "**$iow,$p,$ed,$totalQty,$unit,$c**";
$approvedTotalAmount=iowApprovedCost($iow);

$totalMaretialCost=totalMaretialCost($iow,$p,$ed,$c);
//echo "<br>**totalMaretialCost=$totalMaretialCost**<br>";
$totalempCost=totalempCost($iow,$p,$ed,$c);
$totalSubconCost=totalSubconCost($iow,$p,$ed,$c);

//echo "<br>**totalempCost=$totalempCost**<br>";
$totalSubconCost=totalSubconCost($iow,$p,$ed,$c);
//echo "<br>**totalSubconCost=totalSubconCost**<br>";

$totaleqCost=totaleqCost($iow,$p,$ed,$c);
//echo "<br>**totaleqCost=$totaleqCost**<br>";

$actualTotalAmount=$totalMaretialCost+$totalempCost+$totalSubconCost+$totaleqCost;

$progressp=($actualTotalAmount*100)/$approvedTotalAmount;

$progressQty=($totalQty*$progressp)/100;
 if($unit=='L.S' OR $unit=='LS' OR $unit=='l.s' OR $unit=='l.s') 
	return $unit.' <font class=out>('.number_format($progressp).'%)</font>'; 
else  
	return number_format($progressQty).' '.$unit.' <font class=out>('.number_format($progressp).'%)</font>';
}
?>
<?
function totalMaretialCost($iow,$p,$ed,$c){
include("../includes/config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
if($c)
$sqlm = "SELECT sum(issuedQty*issueRate) as totalMaterialCost from issue$p WHERE iowId=$iow AND issueDate='$ed'";
else 
$sqlm = "SELECT sum(issuedQty*issueRate) as totalMaterialCost from issue$p WHERE iowId=$iow AND issueDate<='$ed'";
//echo $sqlm;
$sqlmq=mysql_query($sqlm);
$sqlmr=mysql_fetch_array($sqlmq);
$totalMaterialCost=$sqlmr[totalMaterialCost];
return $totalMaterialCost;
}
?>
<? 
function totalempCost($iow,$p,$ed,$c){


$sql="SELECT distinct dmaItemCode from dma where".
" dmaiow=$iow AND dmaItemCode between '70-00-000' AND '98-99-999'".
" Order by dmaItemCode ASC";
//echo $sql;
$sqlq=mysql_query($sql);
while($sqlr=mysql_fetch_array($sqlq))
	{
	$empTotalWorkiow=empTotalWorkiow($sqlr[dmaItemCode],$iow,$ed,$c);
	$hrApprovedRate=hrApprovedRate($sqlr[dmaItemCode],$iow)/3600;
	$subtotalHumanCost=$empTotalWorkiow*$hrApprovedRate;
	$totalHumanCost=$totalHumanCost+$subtotalHumanCost;
	}
	return $totalHumanCost;
}
?>
<?
function hrApprovedRate($itemCode,$iow){
$sql="SELECT AVG(dmaRate) as hrRate from dma where dmaItemCode='$itemCode' AND dmaiow='$iow'";
$sqlq=mysql_query($sql);
$sqlr=mysql_fetch_array($sqlq);
return $sqlr[hrRate];
}
?>
<?
function totalSubconCost($iow,$p,$ed,$c){
include("../includes/config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);

$sql="SELECT distinct dmaItemCode from dma where".
" dmaiow=$iow AND dmaItemCode between '99-00-000' AND '99-50-999' Order by dmaItemCode ASC";
$sqlq=mysql_query($sql);
if($c)
{

while($sqlr=mysql_fetch_array($sqlq))
{
	$sqlm = "SELECT sum(qty*rate) as totalSubconCost from subut".
	" WHERE edate='$ed' AND iow=$iow AND itemCode='$sqlr[dmaItemCode]'";
//echo $sqlm ;
	$sqlmq=mysql_query($sqlm);
	$sqlmr=mysql_fetch_array($sqlmq);
	$subtotalSubconCost=$sqlmr[totalSubconCost];
	$totalSubconCost=$totalSubconCost+$subtotalSubconCost;
}	
}
else {
while($sqlr=mysql_fetch_array($sqlq))
{
	$sqlm = "SELECT sum(qty*rate) as totalSubconCost from subut".
	" WHERE edate<='$ed' AND iow=$iow AND itemCode='$sqlr[dmaItemCode]'";
//echo $sqlm ;
	$sqlmq=mysql_query($sqlm);
	$sqlmr=mysql_fetch_array($sqlmq);
	$subtotalSubconCost=$sqlmr[totalSubconCost];
	$totalSubconCost=$totalSubconCost+$subtotalSubconCost;
}	
}//else 
return $totalSubconCost;
}
?>
<? 
function totaleqCost($iow,$p,$ed,$c){

$sql="SELECT distinct dmaItemCode from dma where".
" dmaiow=$iow AND dmaItemCode between '50-00-000' AND '69-99-999' Order by dmaItemCode ASC";
$sqlq=mysql_query($sql);
while($sqlr=mysql_fetch_array($sqlq))
	{
	$empTotalWorkiow=eqTotalWorkiow($sqlr[dmaItemCode],$iow,$ed,$c);
	$hrApprovedRate=eqApprovedRate($sqlr[dmaItemCode],$iow)/3600;
	$subtotalHumanCost=$empTotalWorkiow*$hrApprovedRate;
	$totalHumanCost=$totalHumanCost+$subtotalHumanCost;
	}
	return $totalHumanCost;
}
?>
<?
function eqApprovedRate($itemCode,$iow){
$sql="SELECT AVG(dmaRate) as eqRate from dma where dmaItemCode='$itemCode' AND dmaiow='$iow'";
$sqlq=mysql_query($sql);
$sqlr=mysql_fetch_array($sqlq);
return $sqlr[eqRate];
}
?>

<?
function iowApprovedCost($iow){
include("../includes/config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sqlm = "SELECT sum(dmaQty*dmaRate) as totalCost from dma WHERE dmaiow=$iow ";
//echo $sqlm;
$sqlmq=mysql_query($sqlm);
$sqlmr=mysql_fetch_array($sqlmq);
$totalCost=$sqlmr[totalCost];
return $totalCost;
}
?>
<!-- SIOW-->
<?
function siowActualProgress($siow,$p,$ed,$totalQty,$unit,$c){
//$ed=formatDate($ed,'Y-m-j');
//echo "<br>($siow,$p,$ed,$totalQty,$unit)<br>";

$approvedTotalAmount=siowApprovedCost($siow);
//echo "<br>**$approvedTotalAmount**<br>";
$totalMaretialCost=siowtotalMaretialCost($siow,$p,$ed,$c);
//echo "<br>**totalMaretialCost=$totalMaretialCost**<br>";
$totalempCost=siowtotalempCost($siow,$p,$ed,$c);
$totalSubconCost=siowtotalSubconCost($siow,$p,$ed,$c);

//echo "<br>**totalempCost=$totalempCost**<br>";
//$totalSubconCost=siowtotalSubconCost($siow,$p,$ed);
//echo "<br>**totalSubconCost=totalSubconCost**<br>";

$totaleqCost=totaleqCost($siow,$p,$ed,$c);
//echo "<br>**totaleqCost=$totaleqCost**<br>";

$actualTotalAmount=$totalMaretialCost+$totalempCost+$totalSubconCost+$totaleqCost;

$progressp=($actualTotalAmount*100)/$approvedTotalAmount;

$progressQty=($totalQty*$progressp)/100;
//echo "<br>$totalQty*$progressp==$progressQty<br>";
 if($unit=='L.S' OR $unit=='LS' OR $unit=='l.s' OR $unit=='l.s') 
	return $unit.' <font class=out>('.number_format($progressp).'%)</font>'; 
else
return number_format($progressQty).' '.$unit.' <font class=out>('.number_format($progressp).'%)</font>';
}

?>
<?
function siowtotalMaretialCost($siow,$p,$ed,$c){
include("../includes/config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
if($c)$sqlm = "SELECT sum(issuedQty*issueRate) as totalMaterialCost from issue$p WHERE siowId=$siow AND issueDate='$ed'";
else $sqlm = "SELECT sum(issuedQty*issueRate) as totalMaterialCost from issue$p WHERE siowId=$siow AND issueDate<='$ed'";
//echo $sqlm;
$sqlmq=mysql_query($sqlm);
$sqlmr=mysql_fetch_array($sqlmq);
$totalMaterialCost=$sqlmr[totalMaterialCost];
return $totalMaterialCost;
}
?>
<? 
function siowtotalempCost($siow,$p,$ed,$c){

$sql="SELECT distinct dmaItemCode from dma where".
" dmasiow=$siow AND dmaItemCode between '70-00-000' AND '98-99-999'".
" Order by dmaItemCode ASC";
//echo $sql;
$sqlq=mysql_query($sql);
while($sqlr=mysql_fetch_array($sqlq))
	{
	$empTotalWorkiow=empTotalWorksiow($sqlr[dmaItemCode],$siow,$ed,$c);
	$hrApprovedRate=hrApprovedRatesiow($sqlr[dmaItemCode],$siow)/3600;
	$subtotalHumanCost=$empTotalWorksiow*$hrApprovedRatesiow;
	$totalHumanCost=$totalHumanCost+$subtotalHumanCost;
	}
	return $totalHumanCost;
}
?>
<?
function hrApprovedRatesiow($itemCode,$siow){
$sql="SELECT AVG(dmaRate) as hrRate from dma where dmaItemCode='$itemCode' AND dmasiow='$siow'";
$sqlq=mysql_query($sql);
$sqlr=mysql_fetch_array($sqlq);
return $sqlr[hrRate];
}
?>
<?
function siowtotalSubconCost($siow,$p,$ed,$c){
include("../includes/config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);

$sql="SELECT distinct dmaItemCode from dma where".
" dmasiow=$siow AND dmaItemCode between '99-00-000' AND '99-50-999' Order by dmaItemCode ASC";
$sqlq=mysql_query($sql);
if($c){
while($sqlr=mysql_fetch_array($sqlq))
{
	$sqlm = "SELECT sum(qty*rate) as totalSubconCost from subut WHERE edate='$ed' AND siow=$siow AND itemCode='$sqlr[dmaItemCode]'";
//echo $sqlm ;
	$sqlmq=mysql_query($sqlm);
	$sqlmr=mysql_fetch_array($sqlmq);
	$subtotalSubconCost=$sqlmr[totalSubconCost];
	$totalSubconCost=$totalSubconCost+$subtotalSubconCost;
}	
}
else {
while($sqlr=mysql_fetch_array($sqlq))
{
	$sqlm = "SELECT sum(qty*rate) as totalSubconCost from subut WHERE edate<='$ed' AND siow=$siow AND itemCode='$sqlr[dmaItemCode]'";
//echo $sqlm ;
	$sqlmq=mysql_query($sqlm);
	$sqlmr=mysql_fetch_array($sqlmq);
	$subtotalSubconCost=$sqlmr[totalSubconCost];
	$totalSubconCost=$totalSubconCost+$subtotalSubconCost;
}	
}//else 
return $totalSubconCost;
}
?>
<? 
function siowtotaleqCost($iow,$p,$ed,$c){

$sql="SELECT distinct dmaItemCode from dma where".
" dmasiow=$siow AND dmaItemCode between '50-00-000' AND '69-99-999' Order by dmaItemCode ASC";
$sqlq=mysql_query($sql);
while($sqlr=mysql_fetch_array($sqlq))
	{
	$empTotalWorksiow=eqTotalWorksiow($sqlr[dmaItemCode],$siow,$ed,$c);
	$hrApprovedRate=eqApprovedRatesiow($sqlr[dmaItemCode],$siow)/3600;
	$subtotalHumanCost=$empTotalWorksiow*$hrApprovedRate;
	$totalHumanCost=$totalHumanCost+$subtotalHumanCost;
	}
	return $totalHumanCost;
}
?>
<?
function eqApprovedRatesiow($itemCode,$iow){
$sql="SELECT AVG(dmaRate) as eqRate from dma where dmaItemCode='$itemCode' AND dmasiow='$siow'";
$sqlq=mysql_query($sql);
$sqlr=mysql_fetch_array($sqlq);
return $sqlr[eqRate];
}
?>

<?
function siowApprovedCost($siow){
include("../includes/config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sqlm = "SELECT sum(dmaQty*dmaRate) as totalCost from dma WHERE dmasiow=$siow ";
//echo $sqlm;
$sqlmq=mysql_query($sqlm);
$sqlmr=mysql_fetch_array($sqlmq);
$totalCost=$sqlmr[totalCost];
return $totalCost;
}
?>
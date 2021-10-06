<?

function gp_iowActualProgress($iow,$p,$ed,$totalQty,$unit,$c){
//$ed=formatDate($ed,'Y-m-j');
	global $db;
	if(!$db){
include("config.inc.php");
if($SESS_DBNAME)
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	}
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
/* if($unit=='L.S' OR $unit=='LS' OR $unit=='l.s' OR $unit=='l.s') 
	return $unit.' <font class=out>('.number_format($progressp).'%)</font>'; 
else  
	return number_format($progressQty).' '.$unit.' <font class=out>('.number_format($progressp).'%)</font>';
	*/
	return $progressp;
}
?>
<?
function iowActualProgressnew($iow,$p,$ed,$totalQty,$unit,$c){
//$ed=formatDate($ed,'Y-m-j');

	global $db;
	if(!$db){
include("config.inc.php");
if($SESS_DBNAME)
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	}
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
	return ' <font class=out>'.$progressp.'%</font>'; 
else  
	return $progressQty.' '.$unit.' <font class=out></font>';
}
?>
<?
function iowActualProgress($iow,$p,$ed,$totalQty,$unit,$c){
//$ed=formatDate($ed,'Y-m-j');

	global $db;
	if(!$db){
include("config.inc.php");
if($SESS_DBNAME)
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	}
	
$approvedTotalAmount=iowApprovedCost($iow);

// echo "<br>**approvedTotalAmount=$approvedTotalAmount**<br>";
$totalMaretialCost=totalMaretialCost($iow,$p,$ed,$c);
// echo "<br>**totalMaretialCost=$totalMaretialCost**<br>";
$totalempCost=totalempCost($iow,$p,$ed,$c);
// echo "<br>**totalempCost=$totalempCost**<br>";
$totalSubconCost=totalSubconCost($iow,$p,$ed,$c);
// echo "<br>**totalSubconCost=$totalSubconCost**<br>";

//echo "<br>**totalempCost=$totalempCost**<br>";
//$totalSubconCost=totalSubconCost($iow,$p,$ed,$c);
//echo "<br>**totalSubconCost=totalSubconCost**<br>";

$totaleqCost=totaleqCost($iow,$p,$ed,$c);
// echo "<br>**totaleqCost=$totaleqCost**<br>";

$actualTotalAmount=$totalMaretialCost+$totalempCost+$totalSubconCost+$totaleqCost;

// echo "<br>**actualTotalAmount=$actualTotalAmount**<br>";

$progressp=($actualTotalAmount*100)/$approvedTotalAmount;

$progressQty=($totalQty*$progressp)/100;
	
$_SESSION["progress_qty"]=round($progressp).'% ('.round($progressQty)." $unit)";
	
if($unit=='L.S' OR $unit=='LS' OR $unit=='l.s' OR $unit=='l.s') 
	return $unit.' <font class=out>('.number_format($progressp).'%)</font>'; 
else  
	return number_format($progressQty).' '.$unit.' <font class=out>('.number_format($progressp).'%)</font>';
}
?>
<?
function iowActualProgressRange($iow,$p,$todat,$ed,$totalQty,$unit,$c){
//$ed=formatDate($ed,'Y-m-j');

	global $db;
	if(!$db){
include("config.inc.php");
if($SESS_DBNAME)
		$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	}
	
$approvedTotalAmount=iowApprovedCost($iow);

// echo "<br>**approvedTotalAmount=$approvedTotalAmount**<br>";
$totalMaretialCost=totalMaretialCostRange($iow,$p,$todat,$ed,$c);
// echo "<br>**totalMaretialCost=$totalMaretialCost**<br>";
$totalempCost=totalempCostRange($iow,$p,$todat,$ed,$c);
// echo "<br>**totalempCost=$totalempCost**<br>";
$totalSubconCost=totalSubconCostRange($iow,$p,$todat,$ed,$c);
// echo "<br>**totalSubconCost=$totalSubconCost**<br>";

//echo "<br>**totalempCost=$totalempCost**<br>";
//$totalSubconCost=totalSubconCost($iow,$p,$ed,$c);
//echo "<br>**totalSubconCost=totalSubconCost**<br>";

$totaleqCost=totaleqCostRange($iow,$p,$todat,$ed,$c);
// echo "<br>**totaleqCost=$totaleqCost**<br>";

$actualTotalAmount=$totalMaretialCost+$totalempCost+$totalSubconCost+$totaleqCost;

// echo "<br>**$todat >>> $ed  actualTotalAmount=$actualTotalAmount**<br>";

$progressp=abs(($actualTotalAmount*100)/$approvedTotalAmount);

$progressQty=abs(($totalQty*$progressp)/100);
 if($unit=='L.S' OR $unit=='LS' OR $unit=='l.s' OR $unit=='l.s') 
	return $unit.' <font class=out>('.number_format($progressp).'%)</font>'; 
else  
	return number_format($progressp,2).'% ('.number_format($progressQty)." $unit)";
}
?>

<?
//created function by salma
function iowActualProgressP($iow,$p,$ed,$totalQty,$unit,$c){
//$ed=formatDate($ed,'Y-m-j');

	global $db;
	if(!$db){
include("config.inc.php");
if($SESS_DBNAME)
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	}
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
	return ' <font class=out>'.number_format($progressp).'%</font>'; 
else  
	return ' <font class=out>'.number_format($progressp).'%</font>';
}
?>

<?
function totalMaretialCost($iow,$p,$ed,$c){
include("config.inc.php");
if($SESS_DBNAME)
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
else
	global $db;
	
if($c)
$sqlm = "SELECT sum(issuedQty*issueRate) as totalMaterialCost from issue$p WHERE iowId=$iow AND issueDate='$ed'";
else 
$sqlm = "SELECT sum(issuedQty*issueRate) as totalMaterialCost from issue$p WHERE iowId=$iow AND issueDate<='$ed'";
// echo $sqlm;
$sqlmq=mysqli_query($db, $sqlm);
if(mysqli_affected_rows($db)<=0)return false;
$sqlmr=mysqli_fetch_array($sqlmq);
$totalMaterialCost=$sqlmr[totalMaterialCost];

return $totalMaterialCost;
}
?>
<?
function totalMaretialCostRange($iow,$p,$todat,$ed,$c){
include("config.inc.php");
if($SESS_DBNAME)
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
else
	global $db;
	
if($c)
$sqlm = "SELECT sum(issuedQty*issueRate) as totalMaterialCost from issue$p WHERE iowId=$iow AND issueDate<='$ed' AND issueDate>='$todat'";
else 
$sqlm = "SELECT sum(issuedQty*issueRate) as totalMaterialCost from issue$p WHERE iowId=$iow AND issueDate<='$ed' AND issueDate>='$todat'";
// echo $sqlm;
$sqlmq=mysqli_query($db, $sqlm);
if(mysqli_affected_rows($db)<=0)return false;
$sqlmr=mysqli_fetch_array($sqlmq);
$totalMaterialCost=$sqlmr[totalMaterialCost];

return $totalMaterialCost;
}
?>
<? 
function totalempCost($iow,$p,$ed,$c){

	global $db;
	if(!$db){
include("config.inc.php");
if($SESS_DBNAME)
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	}
	
$sql="SELECT distinct dmaItemCode from dma where".
" dmaiow=$iow AND dmaItemCode between '70-00-000' AND '94-99-999'".
" Order by dmaItemCode ASC";
//echo $sql;
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
?>
<? 
function totalempCostRange($iow,$p,$todat,$ed,$c){

	global $db;
	if(!$db){
include("config.inc.php");
if($SESS_DBNAME)
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	}
	
$sql="SELECT distinct dmaItemCode from dma where".
" dmaiow=$iow AND dmaItemCode between '70-00-000' AND '94-99-999'".
" Order by dmaItemCode ASC";
//echo $sql;
$sqlq=mysqli_query($db, $sql);
while($sqlr=mysqli_fetch_array($sqlq))
	{
		$empTotalWorkiow=empTotalWorkiow($sqlr[dmaItemCode],$iow,$todat,$c)-empTotalWorkiow($sqlr[dmaItemCode],$iow,$ed,$c);
		$hrApprovedRate=hrApprovedRate($sqlr[dmaItemCode],$iow)/3600;
		$subtotalHumanCost=$empTotalWorkiow*$hrApprovedRate;
		$totalHumanCost=$totalHumanCost+$subtotalHumanCost;
	}
	return $totalHumanCost;
}
?>
<?
function hrApprovedRate($itemCode,$iow){
	global $db;
	if(!$db){
include("config.inc.php");
if($SESS_DBNAME)
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	}
$sql="SELECT AVG(dmaRate) as hrRate from dma where dmaItemCode='$itemCode' AND dmaiow='$iow'";
$sqlq=mysqli_query($db, $sql);
$sqlr=mysqli_fetch_array($sqlq);
return $sqlr[hrRate];
}
?>
<?
function totalSubconCost($iow,$p,$ed,$c){
	include("config.inc.php");
	if($SESS_DBNAME)
		$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	else
		global $db;

	 $sql="SELECT distinct dmaItemCode from dma where".
	" dmaiow=$iow AND dmaItemCode between '95-00-000' AND '99-99-999' Order by dmaItemCode ASC";
	$sqlq=mysqli_query($db, $sql);

// 		echo $sql;
	if($c){
		while($sqlr=mysqli_fetch_array($sqlq))
		{
			$sqlm = "SELECT sum(qty*rate) as totalSubconCost from subut".
			" WHERE edate='$ed' AND iow=$iow AND itemCode='$sqlr[dmaItemCode]'";
		//echo $sqlm ;
			$sqlmq=mysqli_query($db, $sqlm);
			$sqlmr=mysqli_fetch_array($sqlmq);
			$subtotalSubconCost=$sqlmr[totalSubconCost];
			$totalSubconCost=$totalSubconCost+$subtotalSubconCost;
		}
	}else{
		while($sqlr=mysqli_fetch_array($sqlq))
		{
			$sqlm = "SELECT sum(qty*rate) as totalSubconCost from subut".
			" WHERE edate<='$ed' AND iow=$iow AND itemCode='$sqlr[dmaItemCode]'";
// 		echo $sqlm ;
			$sqlmq=mysqli_query($db, $sqlm);
			$sqlmr=mysqli_fetch_array($sqlmq);
			$subtotalSubconCost=$sqlmr[totalSubconCost];
			$totalSubconCost=$totalSubconCost+$subtotalSubconCost;
		}	
	}//else 
	return $totalSubconCost;
}
?>
<?
function totalSubconCostRange($iow,$p,$todat,$ed,$c){
	include("config.inc.php");
	if($SESS_DBNAME)
		$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	else
		global $db;

	 $sql="SELECT distinct dmaItemCode from dma where".
	" dmaiow=$iow AND dmaItemCode between '95-00-000' AND '99-99-999' Order by dmaItemCode ASC";
	$sqlq=mysqli_query($db, $sql);

// 		echo $sql;
	if($c){
		while($sqlr=mysqli_fetch_array($sqlq))
		{
			$sqlm = "SELECT sum(qty*rate) as totalSubconCost from subut".
			" WHERE edate<='$ed' and edate>='$todat' AND iow=$iow AND itemCode='$sqlr[dmaItemCode]'";
		//echo $sqlm ;
			$sqlmq=mysqli_query($db, $sqlm);
			$sqlmr=mysqli_fetch_array($sqlmq);
			$subtotalSubconCost=$sqlmr[totalSubconCost];
			$totalSubconCost=$totalSubconCost+$subtotalSubconCost;
		}
	}else{
		while($sqlr=mysqli_fetch_array($sqlq))
		{
			$sqlm = "SELECT sum(qty*rate) as totalSubconCost from subut".
			" WHERE edate>='$ed' and edate>='$todat' AND iow=$iow AND itemCode='$sqlr[dmaItemCode]'";
// 		echo $sqlm ;
			$sqlmq=mysqli_query($db, $sqlm);
			$sqlmr=mysqli_fetch_array($sqlmq);
			$subtotalSubconCost=$sqlmr[totalSubconCost];
			$totalSubconCost=$totalSubconCost+$subtotalSubconCost;
		}	
	}//else 
// 	echo $sqlm ;
	return $totalSubconCost;
}
?>
<? 
function totaleqCost($iow,$p,$ed,$c){
	global $db;
	if(!$db){
include("config.inc.php");
if($SESS_DBNAME)
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	}
$sql="SELECT distinct dmaItemCode from dma where".
" dmaiow=$iow AND dmaItemCode between '50-00-000' AND '69-99-999' Order by dmaItemCode ASC";
$sqlq=mysqli_query($db, $sql);
while($sqlr=mysqli_fetch_array($sqlq))
	{
	$empTotalWorkiow=eqTotalWorkiow($sqlr[dmaItemCode],$iow,$ed,$c);
	$hrApprovedRate=eqApprovedRate($sqlr[dmaItemCode],$iow)/3600;
// 	echo "<br>$sqlr[dmaItemCode]=$empTotalWorkiow*$hrApprovedRate;</br>";
	$subtotalHumanCost=$empTotalWorkiow*$hrApprovedRate;
	$totalHumanCost=$totalHumanCost+$subtotalHumanCost;
	
	}
	return $totalHumanCost;
}
?>
<? 
function totaleqCostRange($iow,$p,$todat,$ed,$c){

	global $db;
	if(!$db){
include("config.inc.php");
if($SESS_DBNAME)
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	}
$sql="SELECT distinct dmaItemCode from dma where".
" dmaiow=$iow AND dmaItemCode between '50-00-000' AND '69-99-999' Order by dmaItemCode ASC";
$sqlq=mysqli_query($db, $sql);
while($sqlr=mysqli_fetch_array($sqlq)){
	$empTotalWorkiow=eqTotalWorkiow($sqlr[dmaItemCode],$iow,$todat,$c)-eqTotalWorkiow($sqlr[dmaItemCode],$iow,$ed,$c);
	$hrApprovedRate=eqApprovedRate($sqlr[dmaItemCode],$iow)/3600;
// 	echo "<br>$sqlr[dmaItemCode]=$empTotalWorkiow*$hrApprovedRate;</br>";
	$subtotalHumanCost=$empTotalWorkiow*$hrApprovedRate;
	$totalHumanCost=$totalHumanCost+$subtotalHumanCost;
	
	}
	return $totalHumanCost;
}
?>
<?
function eqApprovedRate($itemCode,$iow){

	global $db;
	if(!$db){
include("config.inc.php");
if($SESS_DBNAME)
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	}
$sql="SELECT AVG(dmaRate) as eqRate from dma where dmaItemCode='$itemCode' AND dmaiow='$iow'";
// echo $sql;
$sqlq=mysqli_query($db, $sql);
$sqlr=mysqli_fetch_array($sqlq);
return $sqlr[eqRate];
}
?>

<?
function iowApprovedCost($iow){
include("config.inc.php");
if($SESS_DBNAME)
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
else
	global $db;
	
$sqlm = "SELECT sum(dmaQty*dmaRate) as totalCost from dma WHERE dmaiow=$iow ";
//echo $sqlm;
$sqlmq=mysqli_query($db, $sqlm);
$sqlmr=mysqli_fetch_array($sqlmq);
$totalCost=$sqlmr[totalCost];
return $totalCost;
}
?>

<?
//<!-- SIOW-->
function siowActualProgress($siow,$p,$ed,$totalQty,$unit,$c){
//$ed=formatDate($ed,'Y-m-j');
//echo "<br>($siow,$p,$ed,$totalQty,$unit)<br>";

$approvedTotalAmount=siowApprovedCost($siow);
// echo "<br>**$approvedTotalAmount**<br>";
$totalMaretialCost=siowtotalMaretialCost($siow,$p,$ed,$c);
// echo "<br>**totalMaretialCost=$totalMaretialCost**<br>";
$totalempCost=siowtotalempCost($siow,$p,$ed,$c);
$totalSubconCost=siowtotalSubconCost($siow,$p,$ed,$c);

// echo "<br>**totalempCost=$totalempCost**<br>";
// $totalSubconCost=siowtotalSubconCost($siow,$p,$ed);
// echo "<br>**totalSubconCost=$totalSubconCost**<br>";

$totaleqCost=siowtotaleqCost($siow,$p,$ed,$c);
// echo "<br>**totaleqCost=$totaleqCost**<br>";

$actualTotalAmount=$totalMaretialCost+$totalempCost+$totalSubconCost+$totaleqCost;

if($approvedTotalAmount)
{
	$progressp=($actualTotalAmount*100)/$approvedTotalAmount;
}
else $progressp=0;

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
include("config.inc.php");
if($SESS_DBNAME)
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
else
	global $db;
	
if($c)$sqlm = "SELECT sum(issuedQty*issueRate) as totalMaterialCost from issue$p WHERE siowId=$siow AND issueDate='$ed'";
else  $sqlm = "SELECT sum(issuedQty*issueRate) as totalMaterialCost from issue$p WHERE siowId=$siow AND issueDate<='$ed'";
//echo $sqlm;
$sqlmq=mysqli_query($db, $sqlm);
if(mysqli_affected_rows($db)<=0)return false;
$sqlmr=mysqli_fetch_array($sqlmq);
$totalMaterialCost=$sqlmr[totalMaterialCost];
return $totalMaterialCost;
}
?>
<? 
function siowtotalempCost($siow,$p,$ed,$c){

	global $db;
	if(!$db){
include("config.inc.php");
if($SESS_DBNAME)
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	}
$sql="SELECT distinct dmaItemCode from dma where".
" dmasiow=$siow AND dmaItemCode between '70-00-000' AND '94-99-999'".
" Order by dmaItemCode ASC";
//echo $sql;
$sqlq=mysqli_query($db, $sql);
while($sqlr=mysqli_fetch_array($sqlq))
	{
	$empTotalWorksiow=empTotalWorksiow($sqlr[dmaItemCode],$siow,$ed,$c);
	$hrApprovedRatesiow=hrApprovedRatesiow($sqlr[dmaItemCode],$siow)/3600;
	$subtotalHumanCost=$empTotalWorksiow*$hrApprovedRatesiow;
	$totalHumanCost=$totalHumanCost+$subtotalHumanCost;
	
	}
	return $totalHumanCost;
}
?>
<?
function hrApprovedRatesiow($itemCode,$siow){
include("config.inc.php");
if($SESS_DBNAME)
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
else
	global $db;
$sql="SELECT AVG(dmaRate) as hrRate from dma where dmaItemCode='$itemCode' AND dmasiow='$siow'";
$sqlq=mysqli_query($db, $sql);
$sqlr=mysqli_fetch_array($sqlq);
return $sqlr[hrRate];
}
?>
<?
function siowtotalSubconCost($siow,$p,$ed,$c){
include("config.inc.php");
if($SESS_DBNAME)
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
else
	global $db;
	

$sql="SELECT distinct dmaItemCode from dma where".
" dmasiow=$siow AND dmaItemCode between '95-00-000' AND '99-99-999' Order by dmaItemCode ASC";
$sqlq=mysqli_query($db, $sql);
if($c){
while($sqlr=mysqli_fetch_array($sqlq))
{
	$sqlm = "SELECT sum(qty*rate) as totalSubconCost from subut WHERE edate='$ed' AND siow=$siow AND itemCode='$sqlr[dmaItemCode]'";
//echo $sqlm ;
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
//echo $sqlm ;
	$sqlmq=mysqli_query($db, $sqlm);
	$sqlmr=mysqli_fetch_array($sqlmq);
	$subtotalSubconCost=$sqlmr[totalSubconCost];
	$totalSubconCost=$totalSubconCost+$subtotalSubconCost;
}	
}//else 
return $totalSubconCost;
}
?>
<? 
function siowtotaleqCost($siow,$p,$ed,$c){

	global $db;
	if(!$db){
include("config.inc.php");
if($SESS_DBNAME)
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	}

 $sql="SELECT distinct dmaItemCode from dma where".
" dmasiow=$siow AND dmaItemCode between '50-00-000' AND '69-99-999' Order by dmaItemCode ASC";
$sqlq=mysqli_query($db, $sql);
while($sqlr=mysqli_fetch_array($sqlq))
	{
		$empTotalWorksiow=eqTotalWorksiow($sqlr[dmaItemCode],$siow,$ed,$c);
		$hrApprovedRate=eqApprovedRatesiow($sqlr[dmaItemCode],$siow)/3600;
		$subtotalHumanCost=$empTotalWorksiow*$hrApprovedRate;
// 		echo "<br>$subtotalHumanCost=$empTotalWorksiow*$hrApprovedRate<br>";
		$totalHumanCost=$totalHumanCost+$subtotalHumanCost;
	}
	return $totalHumanCost;
}
?>
<?
function eqApprovedRatesiow($itemCode,$siow){
	
	global $db;
	if(!$db){
include("config.inc.php");
if($SESS_DBNAME)
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	}
$sql="SELECT AVG(dmaRate) as eqRate from dma where dmaItemCode='$itemCode' AND dmasiow='$siow'";
$sqlq=mysqli_query($db, $sql);
$sqlr=mysqli_fetch_array($sqlq);
return $sqlr[eqRate];
}
?>

<?
function siowApprovedCost($siow){
include("config.inc.php");
if($SESS_DBNAME)
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
else
	global $db;
	
$sqlm = "SELECT sum(dmaQty*dmaRate) as totalCost from dma WHERE dmasiow=$siow ";
//echo $sqlm;
$sqlmq=mysqli_query($db, $sqlm);
$sqlmr=mysqli_fetch_array($sqlmq);
$totalCost=$sqlmr[totalCost];
return $totalCost;
}
?>
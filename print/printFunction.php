<?
/*---------------------------------
enter iow Code
return total material Cost of that Iow
---------------------------------*/
function print_materialCost($iow,$r){
global $db;
 $sqlf = "SELECT SUM(dmaRate*dmaQty) as materialRate FROM `dmaback` WHERE dmaiow=$iow  AND revisionNO='$r' AND  dmaItemCode between '01-00-000' AND '39-99-999'";
//echo $sqlf.'<br>';
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
function print_equipmentCost($iow,$r){
global $db;
 $sqlf = "SELECT SUM(dmaRate*dmaQty) as equipmentRate FROM `dma` WHERE dmaiow=$iow  AND revisionNO='$r' AND  dmaItemCode between '50-00-000' AND '69-99-999'";
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
function print_humanCost($iow,$r){
global $db;
 $sqlf = "SELECT SUM(dmaRate*dmaQty) as humanRate FROM `dma` WHERE dmaiow=$iow   AND revisionNO='$r' AND  dmaItemCode between '70-00-000' AND '99-99-999'";
//echo $sqlf.'<br>';
$sqlQ= mysqli_query($db, $sqlf);
$sqlRunf= mysqli_fetch_array($sqlQ);
return $sqlRunf[humanRate];
}
?>

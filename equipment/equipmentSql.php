<? include("../includes/session.inc.php");
include("../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);?>
<? include("../includes/myFunction.php");?>
<? include("../includes/myFunction1.php");?>
<? include("../includes/eqFunction.inc.php");?>


<? if($d){	
//$sql = "DELETE FROM equipment WHERE eqid='$eqid'";
$sql="UPDATE `equipment` SET  status='9' WHERE eqid='$eqid'";
//echo $sql;
$sqlQuery = mysqli_query($db, $sql);
echo "Information Deleted ...";
	echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=equipment+details&page=$page\">";
}?>

<? if($save){
//include('../session.inc.php');
include("../includes/config.inc.php");
$time=mktime(0,0,0, date("m"),date("d"),date("y"));
$todat = date("Y-m-d",$time);
$mnfPro = formatDate($mnfPro,"Y-m-d");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

//$itemCode= $itemCode1.'-'.$itemCode2.'-'.$itemCode3;

if($eqid){
		
$teqSpec=$model.'_'.$brand.'_'.$manuby.'_'.$madein.'_'.$speci.'_'.$designCap.'_'.$currentCap.'_'.$yearManu;

$sqlitem = "UPDATE `equipment` SET  ".
									" `mnfPro`='$mnfPro' , `teqSpec`='$teqSpec' , `exp`='$exp' , `price`='$price' , `life`='$life' ,".
									" `salvageValue`='$salvageValue' , `days`='$days',`hours`='$hours' ,`reference`='$reference' , `location`='$currentLocation' ,/*`condition`='$condition',*/ `edate`='$todat',startup='$startup_reading',lastMaintenance='$lastMaintenance',measureUnit='$measureUnit' "." WHERE eqid=$eqid";
	
		
$sqlrunItem= mysqli_query($db, $sqlitem);
$row=mysqli_affected_rows($db);

}
elseif($posl){
$teqSpec=$model.'_'.$brand.'_'.$manuby.'_'.$madein.'_'.$speci.'_'.$designCap.'_'.$currentCap.'_'.$yearManu;
$temp=explode('-',$itemCode);

if(!$assetId){
	$assetId=newAssetID($itemCode,"N","004");
// 	echo $assetId;
// 	exit;
}
// 	quantity check
	$remainQty=eqRemainQty1($reference,$itemCode);
	if($remainQty<1){echo "<p>Available quantity not found.</p>";exit;}


$sqlitem = "INSERT INTO `equipment` ( `eqid` , `assetId`, `itemCode`,".
									" `mnfPro` , `teqSpec` ,`exp` , `price` , `life` ,".
									" `salvageValue` , `days`, `hours`,`reference` , `location` ,`condition`, `edate`,startup,lastMaintenance,measureUnit )"." VALUES ( '' ,  '$assetId' , '$itemCode' ,".
									" '$mnfPro' , '$teqSpec' , '$exp' , '$price' , '$life' ,".
									" '$salvageValue' ,'$days','$hours' ,'$reference' , '$currentLocation' ,'$condition' , '$todat','$startup_reading','$lastMaintenance','$measureUnit' ) ";
	
	
$sqlrunItem= mysqli_query($db, $sqlitem);
$row=mysqli_affected_rows($db);
	
if($remainQty==1){	//if available quantity is the last one then turn off the po
	$sqlitem1 = "UPDATE `porder` SET status='2' WHERE posl='$posl' AND itemCode='$itemCode'";
	mysqli_query($db, $sqlitem1);
}
}
// echo $sqlitem;exit;

if($row<1 && !($assetId || $eqid)){
	$msg= "Your informations can't be saved...<br> <font >Please check the inputes May be Asset Id conflict #111";
	echo errMsg($msg);
	echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"5; URL=../index.php?keyword=equipment+entry\">";
}else{	
	echo "Your informations are saving...<br> Wait Please...... ";
	echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=equipment+details&page=$page\">";
	}
}

if($addRequisition){
include("../config.inc.php");
$time=mktime(0,0,0, date("m"),date("d"),date("y"));
$todat = date("Y-m-d",$time);
$rdate = formatDate($rdate,"Y-m-d");
$ddate = formatDate($ddate,"Y-m-d");

$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
for($i=0;$i<$quantity;$i++){
$sql="INSERT INTO `equipmentreq` ( `eqreid` ,`pcode`, `eqCode`  , `rdate` , `ddate` , `receiveDate`,`posl`,`reff`,`assetId` ) ".
                   "VALUES ( '' , '$loginProject', '$eqCode'  , '$rdate' , '$ddate' , '','','','' )";
//  echo $sql;
$sqlrun= mysqli_query($db, $sql);
}
$row=mysqli_affected_rows($db);

if($row<1)
{
	$msg= "Your informations can't be saved...<br> <font >Please check the inputes May be Asset Id conflict #122";

	echo errMsg($msg);
	echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"5; URL=../index.php?keyword=equipment+entry\">";
}
else {
	echo "Your informations are saving...<br> Wait Please...... ";
	echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=equipment+details\">";
	}
}


if($appRequisition){
include("../config.inc.php");
$time=mktime(0,0,0, date("m"),date("d"),date("y"));
$todat = date("Y-m-d",$time);
$rdate = formatDate($rdate,"Y-m-d");
$ddate = formatDate($ddate,"Y-m-d");

$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
for($i=0;$i<$no;$i++){
$sql="UPDATE `equipmentreq` SET assetId='${assetId.$i}' WHERE eqreid='${id.$i}'";
//echo $sql;
$sqlrun= mysqli_query($db, $sql);


$sql11="UPDATE `equipment` SET location='${pp.$i}', status='1' WHERE assetId='${assetId.$i}'";
//echo $sql11.'<br>';
$sqlrun11= mysqli_query($db, $sql11);

}
$row=mysqli_affected_rows($db);

if($row<1)
{
	$msg= "Your informations can't be saved...<br> <font >Please check the inputes May be Asset Id conflict ";

	echo errMsg($msg);
	echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"5; URL=../index.php?keyword=equipment+entry\">";
}
else {
	echo "Your informations are saving...<br> Wait Please...... ";
	echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=equipment+details\">";
	}
	echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php\">";
}



?>

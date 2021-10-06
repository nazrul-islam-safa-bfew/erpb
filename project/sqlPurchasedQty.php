<?
include("../session.inc.php");
include("../config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
mysql_select_db($SESS_DBNAME,$db);

$todat = date("Y-m-d");
if($reqActQty)
{
$sql="SELECT * FROM requisition Where reqpCode='$pcode' AND reqItemCode='$itemCode'";
//echo $sql;

 $sqlQuary=mysql_query($sql);
 $totalRow=mysql_num_rows($sqlQuary);
 $i=1;
 while($sqlre=mysql_fetch_array($sqlQuary)){
 $reqId=$sqlre[reqId];
 $reqFund=$sqlre[reqFund];
 $reqPurQty=round(($reqActQty*$reqFund)/$reqTotlaFund);


$totalPurchase = $totalPurchase + $sqlre[totalPurchase];
//echo "$totalRow==$i";
 $reqRemQty=$sqlre[reqFund]-$reqPurQty;

 $sqlp = "UPDATE `requisition` SET `reqFund`='$reqRemQty',`reqActQty`='$reqPurQty', `unitPrice`='$unitRate', reqDate='$todat', totalPurchase='$totalPurchase' WHERE `reqId`='$reqId'";
echo "$sqlp<br>";
$sqlrunp= mysql_query($sqlp);

$sql1="INSERT INTO purchase (`prId`, `prpcode`, `prItemCode`, `prQty`, `prDate`, `reqId`) VALUES ('', '$pcode', '$itemCode','$reqActQty','$todat', '$reqId')";
echo $sql1;
$sqlQuary11=mysql_query($sql1);

$i++;
}

}

/*save in fundAllocation Table END*/
//echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=purchase+requisition\">";
?>
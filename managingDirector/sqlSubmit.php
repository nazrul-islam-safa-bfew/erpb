<?
include("../session.inc.php");
include("../config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
 
$t_req=$REMOTE_ADDR;
$todat = date("Y-m-d"); 


$i=1;
while($i< $rowNo ){
$reqQty=${'reqQty'.$i};
$fundQty=${'fund'.$i};
$remainingReqQty=$reqQty-$fundQty;
$idNew="reqId$i";
$loc=${'reqLoc'.$i};
if($fundQty)
{
 $sqlp = "UPDATE `requisition` SET `reqQty`='$remainingReqQty', `reqFund`='$fundQty',`reqLoc`='$loc', reqDate='$todat' WHERE `reqId`='${$idNew}'";
//echo "$sqlp<br>";
$sqlrunp= mysqli_query($db, $sqlp);
}

/*save in fundAllocation Table END*/
$i++;
}
echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=mdfund+allocation\">";
?>
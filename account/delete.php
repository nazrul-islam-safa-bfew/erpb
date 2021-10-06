<html>
 <head>
	<LINK href="../style/indexstyle.css" type=text/css rel=stylesheet> 
	<style>
	BODY {
	MARGIN-TOP: 0px; MARGIN-LEFT: 5px;MARGIN-RIGHT: 5px; PADDING-TOP: 0px; margin-bottom: 0px; 
	font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; background-color: #FFFFFF;background-image: none;
}

	</style>
 </head>
  <body bgcolor="#FFFFFF" >
 <? include('../includes/config.inc.php'); ?>
 <? include('../includes/myFunction.php');?>
 <? include('../includes/accFunction.php');?> 


 <?
 
 $d=$_GET['d'];
 $p=$_GET['p'];
if($d){
include("../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$temp=explode('_',$p);
//echo "$p==$temp[0]";


if($temp[0]=='client'){
	$sql="select * from receivecash where receiveSL = '$p'";
	//echo "<br>$sql<br>";
	$sqlq=mysqli_query($db, $sql);
	while($r=mysqli_fetch_array($sqlq)){
	$invoiceno=$r[reff];
	$receiveAmount=$r[receiveAmount];
	
	$sql32="DELETE from receivecash where receiveSL ='$p'";
	//echo "<br>$sql32<br>";
	mysqli_query($db, $sql32);
	//$r=mysqli_affected_rows($db);
	
	
	$sql3="UPDATE invoice set receiveAmount=receiveAmount-$receiveAmount,invoiceStatus='1' WHERE invoiceNo='$invoiceno'";
	//echo "<br>$sql3<br>";
	mysqli_query($db, $sql3);
    	
	
}//while

}
if($temp[0]=='other'){
	$sql32="DELETE from receivecash where receiveSL ='$p'";
	//echo "<br>$sql32<br>";
	mysqli_query($db, $sql32);
	//$r=mysqli_affected_rows($db);
}
if($temp[0]=='lender'){
	$sql32="DELETE from receivecash where receiveSL ='$p'";
	//echo "<br>$sql32<br>";
	mysqli_query($db, $sql32);
	//$r=mysqli_affected_rows($db);
}

if($temp[0]=='WP' OR $temp[0]=='SP' ){

$sql32="DELETE from empsalary where paymentSL LIKE '$p'";
echo "<br>$sql32<br>";
mysqli_query($db, $sql32);

$r=mysqli_affected_rows($db);
if($r>0){
$sql3="DELETE from purchase where paymentSL LIKE '$p'";
echo "<br>$sql3<br>Y";
mysqli_query($db, $sql3);
}


}


else if($temp[0]=='PP' OR $temp[0]=='pp'){
include("../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$sql="select * from vendorpayment where paymentSL like '$p'";
echo "<br>$sql<br>";
$sqlq=mysqli_query($db, $sql);
while($r=mysqli_fetch_array($sqlq)){
$amount=$r[paidAmount];
$sql2="DELETE from vendorpayment where vpid=$r[vpid]";
echo "<br>$sql2<br>";
mysqli_query($db, $sql2);


$sql21="UPDATE popayments set paidAmount=paidAmount-$amount WHERE posl LIKE '$r[posl]'";
echo "<br>$sql21<br>";
mysqli_query($db, $sql21);
$rr=mysqli_affected_rows($db);
echo "RRRRR=$rr;****";
}//while
if($rr>0)
{$sql3="DELETE from purchase where paymentSL LIKE '$p'";
echo "<br>$sql3<br>";
mysqli_query($db, $sql3);
}
}
else if($temp[0]=='EP'){ 
$temp=explode('_',$p);
$pcode=$temp[1];

$ssql="DELETE from storet$pcode where paymentSL LIKE '$p'";
//echo "<br>$ssql<br>";
mysqli_query($db, $ssql);
$ssql="DELETE from store$pcode where paymentSL LIKE '$p'";
//echo "<br>$ssql<br>";
mysqli_query($db, $ssql);
$sql = "DELETE FROM purchase WHERE paymentSL='$p'";
//	echo $sql;
	$sqlQuery = mysqli_query($db, $sql);

}
else{
include("../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$sql = "DELETE FROM ex130 WHERE paymentSL='$p'";
//echo $sql;
$sqlQuery = mysqli_query($db, $sql);
	if(mysqli_affected_rows($db)>0){
	$sql = "DELETE FROM purchase WHERE paymentSL='$p'";
	//echo $sql;
	$sqlQuery = mysqli_query($db, $sql);
	}
}
}
?>

<form name="sear" action="./delete.php" method="post">
<table width="100%" border="1"  cellpadding="0" cellspacing="0" style="border-collpase:collapse">
<tr>
 <td>
  Payment SL:
   <input type="text" name="paymentSL" value="<? echo $paymentSL;?>">
   <input type="submit" name="search" value="search">
 </td>
</tr>
</table>
</form>
<? if($paymentSL){ // echo $paymentSL;?>
<table width="100%" border="1" bordercolor="#000000" cellpadding="5" cellspacing="0" style=" border_collapse:collapse">
<tr>
 <th>Payment SL</th>
 <th>Paid Amount</th> 
</tr>
 <?
include("../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sql = "SELECT * FROM purchase WHERE paymentSL LIKE '$paymentSL'";
//echo $sql;
$sqlQuery = mysqli_query($db, $sql);
while($sqlResult=mysqli_fetch_array($sqlQuery)){?>


<tr>
 <td><? echo $sqlResult[paymentSL];?></td>
 <td><? echo $sqlResult[paidAmount];?><a href="<? echo $PHP_SELF;?>?d=1&p=<? echo $sqlResult[paymentSL];?>">Delete</a></td>
 </tr>

<? }

?>
</table>
<table width="100%" border="1" bordercolor="#000000" cellpadding="5" cellspacing="0" style=" border_collapse:collapse">
<tr>
 <th>Receive SL</th>
 <th>Receive Amount</th> 
</tr>
 <?
include("../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sql = "SELECT * FROM receivecash WHERE receiveSL LIKE '$paymentSL'";
//echo $sql;
$sqlQuery = mysqli_query($db, $sql);
while($sqlResult=mysqli_fetch_array($sqlQuery)){?>


<tr>
 <td><? echo $sqlResult[receiveSL];?></td>
 <td><? echo $sqlResult[receiveAmount];?><a href="<? echo $PHP_SELF;?>?d=1&p=<? echo $sqlResult[receiveSL];?>">Delete</a></td>
 </tr>

<? }
}
?>
</table>

</body>
</html>

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
 <? include('../includes/myFunction.php');?>
 <? include('../includes/accFunction.php');?> 


 <?
 
 $d=$_GET['d'];
 $p=$_GET['p'];
if($p){
include("../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$sql3="DELETE from purchase where paymentSL LIKE '$p'";
echo "<br>$sql3<br>";
mysqli_query($db, $sql3);
$done=mysqli_affected_rows($db);
if($done=='1')echo "$p has been deleted."; else echo "$p has not been deleted.";

}
?>
<p style="color:#f00; font-weight:bold;">Warning: Please first try norman delete.</p>
<p style="color:#006633; font-weight:bold;">After that try this one.</p>
<form name="sear" action="./delete special.php" method="post">
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

<?
$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
include($localPath."/includes/session.inc.php"); 
if($loginUname){?>
 <? 
 $localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
 include($localPath."/includes/config.inc.php"); 
if($d){
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysqli_select_db($SESS_DBNAME,$db);
	
$sql="SELECT * FROM porder WHERE posl='$posl'";
$sq= mysqli_query($db , $sql);
while($s=mysqli_fetch_array($sq)){
$vendor = "DELETE FROM poschedule  WHERE poid='$s[poid]'";
//echo $vendor;
$sqlr= mysqli_query($db ,$vendor);
}	
$vendor = "DELETE FROM porder  WHERE posl='$posl'";
//echo $vendor;
$sqlr= mysqli_query($db ,$vendor);

$vendor1 = "DELETE FROM popayments  WHERE posl='$posl'";
//echo $vendor;
$sqlr1= mysqli_query($db,$vendor1);

$vendor1 = "DELETE FROM pcondition  WHERE posl='$posl'";
//echo $vendor1;
$sqlr1= mysqli_query($db,$vendor1);
}
else{  
	$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
include($localPath."/includes/myFunction.php"); 

$todat=todat();
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysqli_select_db($SESS_DBNAME,$db);
$vendor = "UPDATE porder SET status='1',dat='$todat' WHERE posl='$posl'";
//echo $vendor;
$sqlr= mysqli_query($db ,$vendor);

$po="SELECT sum(qty*rate) as amount from porder where posl = '$posl'";
$poq=mysqli_query($db,$po);
$por=mysqli_fetch_array($poq);
$totalAmount=ceil($por['amount']);
	$sqlpo = "INSERT INTO popayments(popID, posl, acctPayable,totalAmount,receiveAmount, paidAmount)"."
	 VALUES ('','$posl','2400000','$totalAmount','','')";
	//echo $sqlpo;
	$sqlQuerypo = mysqli_query($db,$sqlpo);

}
echo "Your Information is Updating.......";
echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=purchase+order+report&s=0\">";
}
?>

<? 
error_reporting(0);
include_once("../includes/session.inc.php");

include_once("../includes/myFunction1.php");
include_once("../includes/myFunction.php");
include_once("../includes/accFunction.php");
include_once("../includes/eqFunction.inc.php");
/*include_once("../includes/empFunction.inc.php");

include_once("../includes/subFunction.inc.php");
include_once("../includes/matFunction.inc.php");
*/
	
	
$todat=todat();
?>
<html>
<head>

<LINK href="../style/print.css" type=text/css rel=stylesheet>



<meta http-equiv="Content-Language" content="en-us">
<meta name="author" content="<? echo $mauthor;?>">
<meta name="copyright" content="<? echo $tt;?>">
<meta name="keywords" content="<? echo $kword;?>">
<META NAME="description" CONTENT="<? echo $des;?>">
<title>BFEW :: Print </title>
</head>
<body  topmargin="1" leftmargin="5" rightmargin="5" bgcolor="#FFFFFF" >
<a name="top"></a>
<table width="700" border="0"  align="center" cellpadding="5" cellspacing="5">
<tr>
 <th bgcolor="#3366FF"><h1>Bangladesh Foundry and Engineering Works Ltd.</h1></th>
</tr>
<!--<tr>
 <th>Detail Report of <? echo myProjectName($project);?> at project &nbsp;<? echo myProjectName($project);?></th>
</tr>
-->
</table>
<br>
<br>


<br>
<br>

<? 
if($vid=='') $vid='%';
if($pcode=='') $pcode='%';


include("../config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);



?>
<table align="center" width="95%" border="0" bordercolor="#0099FF" 
cellpadding="0" cellspacing="0" style="border-collapse:collapse" class="dblue">
<tr bgcolor="#0099FF">
 <td height="30" class="englishhead">Date</td>
 <td class="englishhead">Purchase Order Details</td>
 <td class="englishhead">MR/Payment SL.</td> 
 <td class="englishhead">Mat. Receive Tk.</td> 
 <td class="englishhead">Amount Paid</td> 
 <td class="englishhead">Balance</td> 
</tr>

<? 
if($posl){
$sql="SELECT DISTINCT posl,location,vid,poType,activeDate from porder 
WHERE posl ='$posl'";
}else{
$sql="SELECT DISTINCT posl,location,vid,poType,activeDate from porder 
WHERE location LIKE '$pcode' 
AND vid LIKE '$vid' AND posl not Like 'EP_%'";
$sql=$sql." ORDER by posl ASC";}

// echo $sql;

$sqlq1=mysqli_query($db, $sql);
while($mr=mysqli_fetch_array($sqlq1)){

$data=array();

$tt=1;
$location=$mr[location];
$vid=$mr[vid];
$posl=$mr[posl];
$poType=$mr[poType];

?>
<tr><td colspan="6" height="10"></td></tr>
<tr><td colspan="6" height="2" bgcolor="#0099FF"></td></tr>
<tr bgcolor="#CCE6FF">
 <td colspan="6"> <? $vtemp=vendorName($vid);
  echo viewPosl($mr[posl]).' '.$vtemp[vname]; ?>
 <br>PO Amount: <? echo  number_format(poTotalAmount($mr[posl]),2).' dated '.mydate($mr[activeDate]);?></td>
 
</tr>

<? 
if($poType==1 OR $poType==2 OR $poType==3 OR $poType==4 ){
if($poType==1){
 if($vid=='99') $sql1="SELECT SUM(receiveQty*rate) as subAmount,todat,reference,paymentSL from storet$location WHERE
 reference='$posl' GROUP by reference ORDER by reference ASC";
  else $sql1="SELECT SUM(receiveQty*rate) as subAmount,todat,reference from store$location WHERE
 paymentSL='$posl' GROUP by reference ORDER by reference ASC";
	
	
	
	$q=mysqli_query($db,"SELECT count(*) as prob from store$location WHERE
 paymentSL='$posl' and (todat='0000-00-00' or todat='')");
	$row=mysqli_fetch_array($q);
	if($row[prob]>0)echo "<center><h1>Some item contain has blank date problem. In this case may be not payable</h1></center>";
	

}

else if($poType==2){
	$sql1="select edate as todat,itemCode,posl,eqId from eqattendance
	WHERE posl='$posl' ORDER by itemCode";
// 	echo "$sql1<br>";
}

else if($poType==3){
 $sql1="SELECT SUM(qty*rate) as subAmount,edate as todat from subut WHERE".
" posl='$posl' GROUP by edate ORDER by edate ASC";
}
else if($poType==4){
 $sql1="SELECT SUM(price) as subAmount,edate,assetId as todat from equipment WHERE".
" reference LIKE '$posl' GROUP by edate ORDER by edate ASC";
}
// echo $sql1.'<br>'.$poType;
$sqlq1=mysqli_query($db, $sql1);
$i=0;
while($st=mysqli_fetch_array($sqlq1)){

$data[$i][0]=$st[todat];
$data[$i][1]='';
if($vid=='99')$data[$i][2]=$st[paymentSL];
else $data[$i][2]=$st[reference];
if($poType==2){

	$rate=eqpoRate($st[itemCode],$st[posl]);	
	

	$amount=eq_monthlyWorkBreak("%","$st[itemCode]",$st[todat],$location,$posl);

	$data[$i][6]="";
	$present=eq_toDaypresent($st[eqId],$st[itemCode],$st[todat],$eqType);
	$break=eq_dailyworkBreak($st[eqId],$st[itemCode],$st[todat],$eqType,$location);
	$worked=($present-$break)/3600;
	$rate=($rate/8)*$worked;
	
	if(!$amount){$data[$i][3]=$rate;}
	else {$data[$i][3]=0;$data[$i][6]="<font style='background: #f00;color: #fff;padding: 1px 1px;border-radius: 5px;'>Breakdown</font>";}
	
	$itemDes=itemDes($st[itemCode]);
// 	$itemDes.="Breakdown: ".eq_dailyBreakDown($st[eqId],$st[itemCode],$st[todat],$eqType,$location);

	
	$data[$i][5]=$st[itemCode].$st[eqId].", ".$itemDes['des']." ".$itemDes['spc'];
	$st[subAmount]=$rate;	
}else $data[$i][3]=$st[subAmount];
$data[$i][4]='1';

$totoalAmount=$totoalAmount+$st[subAmount];
$i++;


 }
}
?>
<?
$sqlv="select * from vendorpayment WHERE posl='$posl' order by paymentDate ASC";
//echo "<br>$sqlv<br>";
$sqlqv=mysqli_query($db, $sqlv);
$i++;
while($vp=mysqli_fetch_array($sqlqv)){

$data[$i][0]=$vp[paymentDate];
$data[$i][1]='';
$data[$i][2]=$vp[paymentSL];
$data[$i][3]=$vp[paidAmount];
$data[$i][4]='2';
$totalPaid+=$vp[paidAmount];
$i++;
 }?> 
 <? 
// print_r($data);
 
 sort($data);
 //echo "Size of".sizeof($data).'*<br>';
	?>
<style>
	.dreamColor:nth-child(odd){background:#eee; margin-bottom:2px;}	
	.dreamColor:hover{background:#ccc;}	
</style>
	<?
 for($i=0;$i<sizeof($data);$i++){?>
 
<tr class='dreamColor'>
 <td><?
				echo myDate($data[$i][0]);
				echo !empty($data[$i][5])? ", ".($data[$i][5]) : "";
	 			echo $data[$i][6];
	 ?>
</td>
 <td></td>  
 <td><? echo $data[$i][2];?></td>
 <? if($data[$i][4]=='1'){?> <td align="right"><? echo !empty($data[$i][3])? number_format($data[$i][3],2) : "";?></td><td></td><? }?>
 <? if($data[$i][4]=='2'){?> <td></td><td align="right"><? echo number_format($data[$i][3],2);?></td> <? }?>
</tr> 

<?  }//for  ?>
 
<tr bgcolor="#FFFFCC">
 <td colspan="4" align="right"><? echo number_format($totoalAmount,2);?></td>
 <td align="right"><? echo number_format($totalPaid,2);?></td> 
 <td align="right"><? echo number_format($totoalAmount-$totalPaid,2);?></td>  
</tr>
<tr><td colspan="6" height="2" bgcolor="#0099FF"></td></tr>


<?
 $gtotoalAmount+=$totoalAmount;
 $totoalAmount=0;
 $gttotalPaid+=$totalPaid;
 $totalPaid=0;
}//while?>

<tr bgcolor="#DFFFDF">
 <td colspan="4" align="right" height="30"><? echo number_format($gtotoalAmount,2);?></td>
 <td align="right" height="30"><? echo number_format($gttotalPaid,2);?></td> 
 <td align="right" height="30"><? echo number_format($gtotoalAmount-$gttotalPaid,2);?></td>  
</tr>

</table>




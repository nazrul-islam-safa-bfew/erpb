<?
header('Content-Type: text/html; charset=ISO-8859-1');
include("../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);
include_once("../includes/myFunction1.php");
include_once("../includes/myFunction.php");
include_once("../includes/empFunction.inc.php");
include_once("../includes/eqFunction.inc.php");
include_once("../includes/subFunction.inc.php");
include_once("../includes/matFunction.inc.php");
include_once("./printFunction.php");
include_once("../includes/accFunction.php");

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
<title>BFEW :: Print IOW</title>
</head>
<body  topmargin="1" leftmargin="5" rightmargin="5" bgcolor="#FFFFFF" >

<?
	

$sqliow = "SELECT * from `iowback` where iowId='$iowId' AND revisionNO='$r'";
//echo $sqliow;
$sqlruniow= mysqli_query($db, $sqliow);
$resultiow=mysqli_fetch_array($sqlruniow);
?>
<table width="600"  align="center" border="1" bordercolor="#9999CC" bgcolor="#9999CC" cellpadding="0" cellspacing="0" style="border-collapse:collapse" >
 <tr > <td >
<table width="100%"  align="center"  bgcolor="#FFFFFF" border="0" cellpadding="5" cellspacing="0">
<tr>
  <td colspan="4" bgcolor="#9999CC" align="center" class="englishhead">Details of Item Of Work (IOW)</td>
</tr>

<tr>
  <td colspan="4">Project: <font class="out"> <? echo $resultiow[iowProjectCode];?></font></td>
</tr>
<tr>
  <td colspan="4">Item of Work:<font class="out"> <? echo "$resultiow[iowCode]</b> [ <i>$resultiow[iowDes]</i>]";?></font></td>
</tr>
<tr>
  <td width="21%">Quantity:<font class="out"><? echo $resultiow[iowQty];?></font> <? echo $resultiow[iowUnit];?></td>
  <td width="21%">Rate:<font class="out"><? echo number_format($resultiow[iowPrice],2);?></font></td>
  <td width="42%">IOW Total:<font class="out"><? echo  number_format($resultiow[iowQty]*$resultiow[iowPrice],2);?></font> Taka</td>
</tr>
<? 
$materialCost=print_materialCost($resultiow[iowId],$r);
$equipmentCost=print_equipmentCost($resultiow[iowId],$r);
$humanCost=print_humanCost($resultiow[iowId],$r);

$totalCost=$resultiow[iowQty]*$resultiow[iowPrice];
$directCost=$materialCost+$equipmentCost+$humanCost;

$pmaterialCost=($materialCost/$totalCost)*100;
$pequipmentCost=($equipmentCost/$totalCost)*100;
$phumanCost=($humanCost/$totalCost)*100;

?>
<tr><td colspan="4" bgcolor="#DDDDFF">Estimated Direct Expenses: Total Tk. <? echo number_format($directCost);?>(<font class="out"><? echo number_format(($directCost/$totalCost)*100);?>%</font>)
</td></tr>
<tr><td colspan="4" bgcolor="#DDDDFF" ><p style="margin-left:10px">- Material Tk. <? echo number_format($materialCost);?>(<font class="out"><? echo number_format($pmaterialCost);?>%</font>); Equipment Tk. <? echo number_format($equipmentCost);?> (<font class="out"><? echo number_format($pequipmentCost);?>%</font>); Labour Tk.<? echo number_format($humanCost);?> (<font class="out"><? echo number_format($phumanCost);?>%</font>)</td></tr>
<tr><td colspan="4" bgcolor="#FFFFCC">Unit Direct Expense <font class="out">Tk. <? echo number_format($directCost/$resultiow[iowQty],2).'/'.$resultiow[iowUnit];?></font>
</td></tr>

<tr>
  <td colspan="2">Date of Starting: <font class="out"><? echo date('j-m-Y',strtotime($resultiow[iowSdate]));?></font></td>
  <td colspan="2">Date of Completion: <font class="out"><? echo date('j-m-Y',strtotime($resultiow[iowCdate]));?></font></td>
</tr>
<tr>
<td colspan="4"><? echo 'Rev. '.$resultiow[revisionNo];?> <b>Raised at</b> <? echo $resultiow[Prepared];?><br>
<? echo 'Rev. '.$resultiow[revisionNo];?> <? echo $resultiow[Checked];?><br>
<? echo 'Rev. '.$resultiow[revisionNo];?> <? echo $resultiow[Approved];?>
</td>
</tr>

</table>
</td></tr>
</table>
<br>
<a href="./graph/viewGraph.php?iowId=<? echo $resultiow[iowId];?>&iowStatus=<? echo $iowStatus;?>" target="_blank" title="Click For View Graphical Presentation">[ GRAPH ]</a>
<?
$sqlsiow = "SELECT * from `siowback` where `iowId` = '$iowId' AND revisionNO='$r'";
//echo $sqlsiow;
$sqlrunsiow= mysqli_query($db, $sqlsiow);
?>
<form name="check" action="./index.php?keyword=pmview+dma&selectedPcode=<? echo $selectedPcode;?>&iow=<? echo $iow;?>" method="post">
<table  align="center" width="98%" border="1" bordercolor="#E4E4E4" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <? while($siow=mysqli_fetch_array($sqlrunsiow)){?>
  <tr bgcolor="#EEEEEE">
    <td height="30"  width="300" align="left"><b>SIOW: </b><a href="./graphReport.php?siow=<? echo $siow[siowId];?>"><? echo $siow[siowName];?></a><br>
		Start: <? echo myDate($siow[siowSdate]);?>; Finish: <? echo myDate($siow[siowCdate]);?>; Duration: <? echo siowDuration($siow[siowId]);?> days
	</td>
    <td width="200" align="left">Total Qty: <? echo number_format($siow[siowQty],3);?> <? echo $siow[siowUnit];?></td>
  </tr>
  <tr>
  <td colspan="6">
<?
$sqlp ="SELECT * FROM `dmaback` WHERE `dmasiow` = '$siow[siowId]' AND revisionNO='$r' order by dmaItemCode ASC";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
?>

<table  align="center" width="98%" border="1" bordercolor="#CCCCCC" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr bgcolor="#DDDDDD">
    <td height="10" width="100" align="center"><b>Item Code</b></td>
    <td width="300" align="center"><b>Item Description</b></td>
    <td align="center"><b>Unit</b></td>
    <td align="center"><b>Qty</b></td>
    <td align="center"><b>Rate</b></td>
    <td align="center"><b>Amount</b></td>
  </tr>

  <? $i=1;$totalAmount=0;
   while($iowResult=mysqli_fetch_array($sqlrunp))
  { 
  $temp=itemDes($iowResult[dmaItemCode]);
  
  $ii=explode("-",$iowResult[dmaItemCode]);
    //if($ii[0]>=35 AND $ii[0]<70) {$bg=" bgcolor=#FFFFCC"; $unit='Hr.';}
	if($ii[0]>=35 AND $ii[0]<99) {$bg=" bgcolor=#F0FEE";$unit='Hr.';}
	 else {$bg=" bgcolor=#FFFFFF";$unit=$temp[unit];}
  ?>
  <tr <? echo $bg;?>>
    <td align="center" ><? echo $iowResult[dmaItemCode];?></td>
    <td align="left" width="300"><? 
	
	echo "$temp[des], $temp[spc]";?></td>
    <td align="center"><? echo $unit;?></td>
    <td align="right"><?
	if($ii[0]>=35 AND $ii[0]<99)
	 echo sec2hms($iowResult[dmaQty],$padHours=false);
	else 
	 echo number_format($iowResult[dmaQty],3);?></td>
    <td align="right"><? echo number_format($iowResult[dmaRate],2);?></td>
    <td align="right"><? $amount=$iowResult[dmaRate]*$iowResult[dmaQty]; echo number_format($amount,2);?></td>
  </tr>
  <? $totalAmount+= $amount; $i++; } ?>
  <tr  bgcolor="#AAAADD"><td colspan="3" align="center" ><? echo "SIOW Unit Direct Expense: Tk.".number_format( $totalAmount/$siow[siowQty],2).'/'.$siow[siowUnit];?></td>
     <td colspan="3" align="right"><? echo "Sub Total Amount: Tk.".number_format($totalAmount,2);?></td>

 </tr>
<!--   <tr><td  colspan="6">
   <img src="./graphReport.php?siow=<? echo $siow[siowId];?>">
  </td></tr>
-->
</table><br>

  <? } ?>
  					   <input type="hidden" name="tid" value="<? echo $i;?>">
  </td></tr>
   


  </table>
</form>
<br>
  <br>
<? include('../bottom.php');?>
</body>

</html>
 
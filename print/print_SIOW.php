<? include_once("../includes/myFunction1.php");
include("../includes/config.inc.php");
include_once("../includes/myFunction.php");
$todat=todat();
?>
<html>
<head>

<LINK href="style/indexstyle.css" type=text/css rel=stylesheet>
<link href="style/basestyles.css" rel="stylesheet" type="text/css">
<link href="js/fValidate/screen.css" rel="stylesheet" type="text/css">

<meta http-equiv="Content-Language" content="en-us">
<meta name="author" content="<? echo $mauthor;?>">
<meta name="copyright" content="<? echo $tt;?>">
<meta name="keywords" content="<? echo $kword;?>">
<META NAME="description" CONTENT="<? echo $des;?>">
<title>BFEW :: Print IOW</title>
</head>
<body  topmargin="1" leftmargin="5" rightmargin="5" bgcolor="#FFFFFF" >
<a name="top"></a>
<table width="500" border="0"  align="center" cellpadding="5" cellspacing="5">
<tr>
 <th>Bangladesh Foundry and Engineering Works Ltd.</th>
</tr>
<tr>
 <th>IOW detail Report of &nbsp;<? echo date('D',strtotime($todat)).'  '; echo mydate($todat); ?></th>
</tr>
</table>
<br>
<br>
<?
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);

$sqliow = "SELECT * from `iow` where `iowProjectCode` = '$selectedPcode'  AND `iowId` = '$iow'";
//echo $sqliow;
$sqlruniow= mysql_query($sqliow);
$resultiow=mysql_fetch_array($sqlruniow);
?>
<table width="600"  align="center" border="1" bordercolor="#999999" bgcolor="#9999CC" cellpadding="0" cellspacing="0" style="border-collapse:collapse" >
 <tr > <td >
<table width="100%"  align="center"  bgcolor="#FFFFFF" border="0" cellpadding="5" cellspacing="0">
<tr>
  <td colspan="4" bgcolor="#FFFFCC" align="center"><b>Details of Item Of Work (IOW)</b></td>
</tr>

<tr>
  <td colspan="4">Project: <font class="out"> <? echo $selectedPcode;?></font> [ <? echo myprojectName($selectedPcode);?> ]</td>
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
$materialCost=materialCost($resultiow[iowId]);
$equipmentCost=equipmentCost($resultiow[iowId]);
$humanCost=humanCost($resultiow[iowId]);
$totalCost=$resultiow[iowQty]*$resultiow[iowPrice];
$directCost=$materialCost+$equipmentCost+$humanCost;

$pmaterialCost=($materialCost/$totalCost)*100;
$pequipmentCost=($equipmentCost/$totalCost)*100;
$phumanCost=($humanCost/$totalCost)*100;

?>
<tr><td colspan="4" >Estimated Direct Expenses: Total Tk. <? echo number_format($directCost);?>(<font class="out"><? echo number_format(($directCost/$totalCost)*100);?>%</font>)
</td></tr>
<tr><td colspan="4" ><p style="margin-left:10px">- Material Tk. <? echo number_format($materialCost);?>(<font class="out"><? echo number_format($pmaterialCost);?>%</font>); Equipment Tk. <? echo number_format($equipmentCost);?> (<font class="out"><? echo number_format($pequipmentCost);?>%</font>); Labour Tk.<? echo number_format($humanCost);?> (<font class="out"><? echo number_format($phumanCost);?>%</font>)</td></tr>
<tr><td colspan="4">Unit Direct Expense <font class="out">Tk. <? echo number_format($directCost/$resultiow[iowQty],2).'/'.$resultiow[iowUnit];?></font>
</td></tr>

<tr>
  <td colspan="2">Date of Starting: <font class="out"><? echo date('j-m-Y',strtotime($resultiow[iowSdate]));?></font></td>
  <td colspan="2">Date of Completion: <font class="out"><? echo date('j-m-Y',strtotime($resultiow[iowCdate]));?></font></td>
</tr>
<tr>
<td colspan="4"><b>Raised at</b> <? echo $resultiow[Prepared];?><br>
<? echo $resultiow[Checked];?><br>
<? echo $resultiow[Approved];?>
</td>
</tr>

</table>
</td></tr>
</table>
<br>

<?
$sqlsiow = "SELECT * from `siow` where `iowId` = '$iow' ";
//echo $sqlsiow;
$sqlrunsiow= mysql_query($sqlsiow);
?>
<table  align="center" width="98%" border="0" bordercolor="#E4E4E4" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <? while($siow=mysql_fetch_array($sqlrunsiow)){?>
  <tr >
    <td height="30"  width="300" align="left"><b>SIOW: </b><? echo $siow[siowName];?><br>
		Start: <? echo myDate($siow[siowSdate]);?>; Finish: <? echo myDate($siow[siowCdate]);?>; Duration: <? echo siowDuration($siow[siowId]);?> days
	</td>
    <td width="200" align="left">Total Qty: <? echo number_format($siow[siowQty],3);?> <? echo $siow[siowUnit];?></td>
  </tr>
  <tr>
  <td colspan="6">
<?
$sqlp ="SELECT * FROM `dma` WHERE `dmasiow` = '$siow[siowId]' order by dmaItemCode ASC";
//echo $sqlp;
$sqlrunp= mysql_query($sqlp);
?>

<table  align="center" width="98%" border="1" bordercolor="#CCCCCC" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr >
    <td height="10" width="100" align="center"><b>Item Code</b></td>
    <td width="300" align="center"><b>Item Description</b></td>
    <td align="center"><b>Unit</b></td>
    <td align="center"><b>Qty</b></td>
    <td align="center"><b>Rate</b></td>
    <td align="center"><b>Amount</b></td>
  </tr>

  <? $i=1;$totalAmount=0;
   while($iowResult=mysql_fetch_array($sqlrunp))
  { 
  $temp=itemDes($iowResult[dmaItemCode]);
  
  $ii=explode("-",$iowResult[dmaItemCode]);
    //if($ii[0]>=35 AND $ii[0]<70) {$bg=" bgcolor=#FFFFCC"; $unit='Hr.';}
	if($ii[0]>=35 AND $ii[0]<99) {$bg=" bgcolor=#F0FEE";$unit='Hr.';}
	 else {$bg=" bgcolor=#FFFFFF";$unit=$temp[unit];}
  ?>
  <tr >
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
  <tr  bgcolor="#FFFFCC"><td colspan="3" align="center" ><? echo "SIOW Unit Direct Expense: Tk.".number_format( $totalAmount/$siow[siowQty],2).'/'.$siow[siowUnit];?></td>
     <td colspan="3" align="right"><? echo "Sub Total Amount: Tk.".number_format($totalAmount,2);?></td>

 </tr>

</table><br>

  <? } ?>
  </td></tr>



  </table>
  <br>
  <br>
<? include('../bottom.php');?>
</body>

</html>
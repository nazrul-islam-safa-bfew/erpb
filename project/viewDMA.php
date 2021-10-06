<?
if($Save){
include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);

$time=mktime(0,0,0, date("m"),date("d"),date("y"));
$updatetime = date("j-m-Y",$time);

if($check=='Forward to MD')$Checked="<b>Forword to MD</b> at $updatetime by $loginFullName [$loginDesignation]<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i>because $checkMesg</i>";
else { $approve="<b>Approved at</b> $updatetime by $loginFullName [$loginDesignation]" ;
       $Checked="<b>Checked at</b> $updatetime by $loginFullName [$loginDesignation]";
	   for($i=1; $i<$tid; $i++)
	      {
		   $rate=${"rate".$i};
		   $id=${"id".$i};
		   $sql="UPDATE dma SET dmaRate='$rate' WHERE dmaId='$id' ";
		   //echo $sql."<br>";
		   $sqlrun=mysql_query($sql);
		  }
	   
	   }

$sqlup=" UPDATE iow SET Checked='$Checked',Approved='$approve', iowStatus='$check' WHERE iowCode='$iow' AND iowProjectCode='$selectedPcode' ";
//echo $sqlup;
$sqlupdate=mysql_query($sqlup);

//echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=index.php?keyword=ongoing+project+main\">";
}//save


include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);

$sqliow = "SELECT * from `iow` where `iowProjectCode` = '$selectedPcode'  AND `iowCode` = '$iow'";
//echo $sqliow;
$sqlruniow= mysql_query($sqliow);
$resultiow=mysql_fetch_array($sqlruniow);
?>
<table width="600"  align="center" border="1" bordercolor="#9999CC" bgcolor="#9999CC" cellpadding="0" cellspacing="0" style="border-collapse:collapse" >
 <tr > <td >
<table width="100%"  align="center"  bgcolor="#FFFFFF" border="0" cellpadding="5" cellspacing="0">
<tr>
  <td colspan="4" bgcolor="#9999CC" align="center" class="englishhead">Details of Item Of Work (IOW)</td>
</tr>

<tr>
  <td colspan="4">Project:  <b><? echo $selectedPcode;?></b></td>
</tr>
<tr>
  <td colspan="4">Item of Work:<b>  <? echo "$resultiow[iowCode]</b> [ <i>$resultiow[iowDes]</i>]";?></td>
</tr>
<tr>
  <td width="21%">Quantity:<b><? echo $resultiow[iowQty];?></b></td>
  <td width="16%">Unit:<b><? echo $resultiow[iowUnit];?></b></td>
  <td width="21%">Price:<b><? echo floatval($resultiow[iowPrice]);?></b></td>
  <td width="42%">Total Quotation Price:<b><? echo floatval($resultiow[iowTotal]);?></b></td>
</tr>
<tr><td colspan="4">Estimated Direct Expenses: Tk. <? $ede=($resultiow[iowTotal] * $resultiow[iowDirect])/100; echo $ede;?> </td></tr>
<tr>
  <td colspan="2">Date of Starting: <b><? echo date('j-m-Y',strtotime($resultiow[iowSdate]));?></b></td>
  <td colspan="2">Date of Completion: <b><? echo date('j-m-Y',strtotime($resultiow[iowCdate]));?></b></td>
</tr>
<tr>
<td colspan="4"><b>Prepared at</b> <? echo $resultiow[Prepared];?><br>
<? echo $resultiow[Checked];?><br>
<? echo $resultiow[Approved];?>
</td>
</tr>

</table>
</td></tr>
</table>
<br>
<?
$sqlsiow = "SELECT * from `siow` where `siowCode` = '$iow' ";
//echo $sqlsiow;
$sqlrunsiow= mysql_query($sqlsiow);
?>
<form name="check" action="./index.php?keyword=view+dma&selectedPcode=<? echo $selectedPcode;?>&iow=<? echo $iow;?>" method="post">
<table  align="center" width="98%" border="1" bordercolor="#E4E4E4" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <? while($siow=mysql_fetch_array($sqlrunsiow)){?>
  <tr bgcolor="#EEEEEE">
    <td height="30"  width="300" align="left"><b>SIOW: </b><? echo $siow[siowName];?></td>
    <td width="200" align="left">Total Qty: <? echo $siow[siowQty];?> <? echo $siow[siowUnit];?></td>
  </tr>
  <tr>
  <td colspan="6">
<?
$sqlp ="SELECT * FROM `dma` WHERE `dmasiow` LIKE '$siow[siowName]'";
//echo $sqlp;
$sqlrunp= mysql_query($sqlp);
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

  <? $i=1;
   while($iowResult=mysql_fetch_array($sqlrunp))
  {
  $sqlitem = "SELECT itemlist.*,itemrate.* from itemlist,itemrate where itemlist.itemCode = '$iowResult[dmaItemCode]' AND itemrate.rateItemCode = '$iowResult[dmaItemCode]' ";
	//echo $sqlitem;
	$sqlruni= mysql_query($sqlitem);
	$resultItem=mysql_fetch_array($sqlruni);
  ?>
  <tr>
    <td align="center"><? echo $iowResult[dmaItemCode];?></td>
    <td align="left" width="300"><? echo "$resultItem[itemDes], $resultItem[itemSpec]";?></td>
    <td align="center"><? echo $resultItem[itemUnit];?></td>
    <td align="right"><? echo sprintf("%.2f",$iowResult[dmaQty]);?></td>
    <td align="right"><? echo sprintf("Tk.%.2f",$resultItem[rate]);?>
	                   <input type="hidden" name="rate<? echo $i;?>" value="<? echo $resultItem[rate]?>">
					   <input type="hidden" name="id<? echo $i;?>" value="<? echo $iowResult[dmaId]?>">
					   </td>
    <td align="right"><? $amount=$resultItem[rate]*$iowResult[dmaQty]; echo sprintf("Tk.%.2f",$amount);?></td>
  </tr>
  <? $totalAmount+= $amount; $i++; } ?>
  <tr><td colspan="3" align="center" bgcolor="#AAAADD"><? echo "<b>".sprintf("SIOW Unit Rate: Tk.%.2f/ %s", $totalAmount,$siow[siowUnit])."</b>";?></td>
     <td colspan="4" align="right" bgcolor="#AAAADD"><? echo "<b>".sprintf("Sub Total Amount: Tk.%.2f", $totalAmount)."</b>";?></td>
 </tr>
</table><br>

  <? } ?>					   <input type="hidden" name="tid" value="<? echo $i;?>">
  </td></tr>
  <? if( $resultiow[iowStatus]=='Not Ready'){?>

  <tr><td align="center" colspan="4"> 
     <? include("./project/action.php");?>
  </td></tr>
  <? }?>

  </table>
</form>
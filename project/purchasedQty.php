
<form name="reqPurchase" action="./project/sqlPurchasedQty.php" method="post">
<? include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
?>
<?

$sqlpur1="SELECT SUM(reqFund) as totalQty FROM `requisition` where reqpCode='$pcode' AND reqItemCode='$itemCode'";
//echo $sqlpur1.'<br>';
$sqlrunpur1= mysql_query($sqlpur1);
$resultpur1=mysql_fetch_array($sqlrunpur1);

$sqlitem = "SELECT itemlist.*, itemrate.* from itemlist, itemrate WHERE itemlist.itemCode='$itemCode' AND itemrate.rateItemCode='$itemCode' AND rateProjectCode=$pcode";
//echo $sqlitem;
$sqlrunitem= mysql_query($sqlitem);
$resultitem=mysql_fetch_array($sqlrunitem);
?>

<table align="center" width="400" border="1" bordercolor="#99CC99" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
<tr>
 <td width="227" align="left" bgcolor="#99CC99"><b><font color="#FFFFFF">Purchased By <? echo $loginFullName;?></font></b></td>
 <td align="right" bgcolor="#99CC99"><b><font color="#FFFFFF"><? echo $resultpur1[reqpCode];?></font></b></td></tr> 
 <tr><td >Item Code</td><td width="167"><? echo $itemCode;?></td></tr>
 <tr><td >Item Description</td><td width="167"><? echo $resultitem[itemDes] .', '.$resultitem[itemSpec];?></td></tr> 
 <tr><td >Approved Requisition</td><td align="center" width="167"> <? echo $resultpur1[totalQty];?><? echo "  $resultitem[itemUnit]";?></td></tr>		
 <tr><td >Actual Purchased</td><td > <input type="text" name="reqActQty" style="text-align:right"onBlur="document.reqPurchase.reqRemQty.value=subMe(reqPurchase,<? echo $resultpur1[totalQty];?>,reqActQty.value)"> <? echo "$resultitem[itemUnit]";?></td></tr>		
 <tr><td >Remaining Purchase-in-process</td><td ><input type="text" name="reqRemQty" style="text-align:right">  <? echo "$resultitem[itemUnit]";?></td></tr>
 <tr><td >Price</td>    <td> <input type="text" name="reqPurRate" value="<? echo sprintf("%.2f",$resultitem[rate]);?>" style="text-align:right" onBlur="document.reqPurchase.temp.value=multipleMe(reqPurchase,reqActQty.value,reqPurRate.value)"></td></tr>
 <tr><td >Amount</td>	<td > <input type="text" name="temp"  style="text-align:right"></td>	</tr>	
 <tr><td >Vendor</td>    <td ><? echo "$resultitem[rateVen]";?></td></tr>
 <tr><td align="center" colspan="2"><input type="submit" name="purchase" value="Purchased">
<input type="hidden" name="pcode" value="<? echo $pcode;?>">
<input type="hidden" name="itemCode" value="<? echo $itemCode;?>">
<input type="hidden" name="reqTotlaFund" value="<? echo $resultpur1[totalQty];?>"></td></tr>

</table>

</form>
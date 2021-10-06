
<? include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
?>
<table align="center" width="90%" border="1" bordercolor="#99CC99" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr>
 <td align="left" colspan="4" bgcolor="#99CC99"><b><font color="#FFFFFF">Purchase Order to <? echo $loginFullName;?></font></b></td>
 <td align="right" colspan="3" bgcolor="#99CC99">Short by: Project Code<b><font color="#FFFFFF"></font></b></td></tr> 
 <tr>
    <td align="center"><b>Item Code</b></td>	
    <td align="center"><b>Item Description</b></td>		
    <td align="center"><b>Project</b></td>		
    <td align="center"><b>Qty</b></td>
    <td align="center"><b>Price</b></td>		
    <td align="center"><b>Amount</b></td>		
    <td align="center"><b>Vendor</b></td></tr>
<?
$sqlpur1="SELECT SUM(reqFund) as totalQty, reqItemCode, reqpCode, reqId FROM requisition where reqFund <> 0 GROUP BY reqItemCode, reqpCode";
//echo $sqlpur1;
$sqlrunpur1= mysql_query($sqlpur1);
$totalAmount=0;
while($resultpur1=mysql_fetch_array($sqlrunpur1)){

$sqlitem = "SELECT itemlist.*, itemrate.* from itemlist, itemrate WHERE itemlist.itemCode='$resultpur1[reqItemCode]' AND itemrate.rateItemCode='$resultpur1[reqItemCode]' AND rateProjectCode=$resultpur1[reqpCode]";
//echo $sqlitem;
$sqlrunitem= mysql_query($sqlitem);
$resultitem=mysql_fetch_array($sqlrunitem);
?>
 <tr>
    <td><a href="./index.php?keyword=purchased+qty&itemCode=<? echo $resultpur1[reqItemCode];?>&pcode=<? echo $resultpur1[reqpCode];?>"> <? echo $resultpur1[reqItemCode];?></a></td>
    <td align="left" ><? echo $resultitem[itemDes].', '.$resultitem[itemSpec];?></td>
    <td align="center" ><? echo $resultpur1[reqpCode];?></td>	
    <td align="right"><? echo $resultpur1[totalQty].' '. $resultitem[itemUnit];?></td>		
    <td align="right"><? echo sprintf("%.2f",$resultitem[rate]);?></td>
    <td align="right"><? $amount=$resultitem[rate]*$resultpur1[totalQty]; echo number_format($amount,2);?></td>	
    <td ><? echo "$resultitem[rateVen]";?></td></tr>
<? $totalAmount+=$amount?>
<? }?>
<tr><td height="5" align="right" colspan="6" bgcolor="#CEF2DE">Total Fund Allocated by Mr. K. Rahmatullah, Managing Director is Tk. <? echo number_format($totalAmount,2);?></td><td bgcolor="#CEF2DE"></td></tr>
<tr><td  height="10" colspan="7">&nbsp;</td></tr>
</table>


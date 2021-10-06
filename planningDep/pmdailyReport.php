<? 
include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

//$sqlp22 = "SELECT distinct `reqpCode` from `requisition`  ORDER BY `reqpCode`";
$sqlp22 = "SELECT distinct `reqpCode`, `pname` FROM `requisition`, project WHERE reqpCode=pcode ORDER BY `reqpCode` DESC"; 
//echo $sqlp22;
$sqlrunp22= mysql_query($sqlp22);

 while($dmaRun22= mysql_fetch_array($sqlrunp22)){
?>
  <table  align="center" width="98%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="0"  style="border-collapse:collapse" >
    <tr> 
      <td bgcolor="#DDDDDD" height="25" colspan="6"   >Project Name: <b><? echo $dmaRun22[pname];?></b></td>
    </tr>

<?
$sqlp = "SELECT `*` from `requisition` WHERE reqpCode='$dmaRun22[reqpCode]' ORDER BY `reqIow`";
//echo $sqlp;
$sqlrunp= mysql_query($sqlp);

 while($dmaRun= mysql_fetch_array($sqlrunp)){
 if($dmaRun[reqIow]!=$last){
?>
    <tr bgcolor="#EEEEEE"> 
      <td >IOW Code: <i> <font color="#FF6633"><? echo $dmaRun[reqIow];?></font></i></td>
      <td >Total Qty: <i><font color="#FF6633"><? echo $runp[dmasiow];?></font></i></td>
      <td >Work Done Qty: <i><? echo $runp[pname];?></i></td>
      <td >Invoiced Qty: <i><? echo $runp[pname];?></i></td>
    </tr>
    <tr bgcolor="#EEEEEE"> 
      <td colspan="6" >IOW Description: <font color="#FF6633"><? echo $dmaRun[reqIow];?></font></td>
    </tr>
    <tr bgcolor="#EEEEEE"> 
      <td ><b>Budget Expenses</b> : Material Exp: </td>      <td >Equip. Exp: </td>      <td >Labour Exp: </td>      <td >Total Exp: </td>
    </tr>
    <tr bgcolor="#EEEEEE"> 
      <td ><b>Up-to-date Expenses</b>: Material Exp: </td>      <td >Equip. Exp: </td>      <td >Labour Exp: </td>      <td >Total Exp: </td>
    </tr>

<? } $last=$dmaRun[reqIow];?>	
    <tr>
      <td height="10" colspan="5" bgcolor="#FFFFFF">
        <table  align="center" width="98%" border="1" bordercolor="#CCCCCC" bgcolor="#FEFEFA" cellspacing="0" cellpadding="5"  style="border-collapse:collapse" >

<? $sqlItem = "SELECT itemlist.*,itemrate.*, dma.* from `itemlist`,`itemrate`,`dma` where itemCode='$dmaRun[reqItemCode]' AND rateItemCode='$dmaRun[reqItemCode]' AND dmaItemCode='$dmaRun[reqItemCode]'";
//echo $sqlItem;
$sqlrunItem= mysql_query($sqlItem);
$itemResult=mysql_fetch_array($sqlrunItem);
?>
          <tr>
		     <td colspan="4">Item Code: <b><font color="#FF6633"><? echo "$dmaRun[reqItemCode]($itemResult[itemDes])";?></font></b></td>
		  </tr>
          <tr>
		     <td>Approved: <font color="#FF6633"><? echo number_format($itemResult[dmaQty],2)."</font> $itemResult[itemUnit]";?></td>
		     <td>Purchased :<font color="#FF6633"><? echo "$dmaRun[totalPurchase] </font>$itemResult[itemUnit]";?></b></td>
		     <td>Purchase in Process:<font color="#FF6633"> <? echo "$dmaRun[reqFund] </font>$itemResult[itemUnit]";?></b></td>
		     <td>Issued Qty: </td>			 
		  </tr>
          <tr>
		     <td>Received at Store: </td>
		     <td>Used for other IOW: </td>
		     <td>Stock for this IOW:</td>
			 <td>Total Stock: </td></tr>		  		  
		  <tr><td>Surplus in <? echo $dmaRun[reqpCode];?>:</td>
		      <td>Available in Central Store:</td>
			  <td colspan="2">Surplus in Other Projects:</td></tr>
		  <tr>
		      <td colspan="4"> Estimated Rate:<font color="#FF6633"><? echo "$itemResult[dmaRate]/$itemResult[itemUnit]";?></font></td></tr>
		  <tr>
		      <td colspan="4">Current Rate:<font color="#FF6633"><? echo "$itemResult[rate]/$itemResult[itemUnit], Enter by: $itemResult[enterBy] at $itemResult[rateDate]";?></font></td>                  </tr>

		  <tr><td width="250">Current Requirement: <font color="#FF6633"><? echo "$dmaRun[reqQty] </font>$itemResult[itemUnit]";?></b></td>
		  	   <td>Purchase Location: <font color="#FF6633"><? echo $dmaRun[reqLoc]?></font></td></tr>
	  </table>
	  </td>
<tr><td height="10" colspan="4"></td></tr>	  
    </tr>

<? }?>
<tr><td height="30" colspan="4"></td></tr>
  </table>
<? }?>
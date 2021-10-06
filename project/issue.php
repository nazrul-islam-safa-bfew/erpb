Material Issue Form
<? if(!$iowName){?>
<? 
echo "<b><u>Item Of Work List for </u></b>";
echo "Project Code: <u>$loginProject</u><br><br>";
include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sqlp = "SELECT distinct reqIow from `requisition` where `reqpCode` LIKE '$loginProject' ";
//echo $sqlp;
$sqlrunp= mysql_query($sqlp);

?>

<table  align="center" width="50%" border="1" bordercolor="#E0E0E0" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#EEEEEE">
 <td height="30" width="100"><b>IOW code</b></td>
 <td  align="center"><b>Daily Report</b></td>  
</tr>
<? while($iow=mysql_fetch_array($sqlrunp)){?>
<tr>
 <td><? echo $iow[reqIow];?></td>
 <td align="right"><? echo "<a href='./index.php?keyword=issue&iowName=$iow[reqIow]'>Daily Report</a> ";?>
 </td>
</tr>
<? } ?>
</table>
<? }?>
<!-- ISSUE-->
<? if($iowName){?>
<? 
include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);

//$sqlp22 = "SELECT distinct `reqpCode` from `requisition`  ORDER BY `reqpCode`";
?>
  <table  align="center" width="98%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="0"  style="border-collapse:collapse" >
<?
$sqlp = "SELECT `*` from `requisition` WHERE reqIow='$iowName' ORDER BY `reqItemCode`";
//echo $sqlp;
$sqlrunp= mysql_query($sqlp);

 while($dmaRun= mysql_fetch_array($sqlrunp)){
 if($dmaRun[reqIow]!=$last){
?>
    <tr bgcolor="#EEEEEE"> 
      <td >IOW Code: <i> <font color="#FF6633"><? echo $dmaRun[reqIow];?></font></i></td>
      <td >Total Qty: <i><font color="#FF6633"><? echo $runp[dmasiow];?></font></i></td>
      <td >Work Done Qty: <i><? echo $runp[pname];?></i></td>
      <td >Today's Work Qty: <input type="text"></td>
    </tr>
    <tr bgcolor="#EEEEEE"> 
      <td colspan="6" >IOW Description: <font color="#FF6633"><? echo $dmaRun[reqIow];?></font></td>
    </tr>
<? } $last=$dmaRun[reqIow];?>	
    <tr>
      <td height="10" colspan="5" bgcolor="#FFFFFF">
        <table  align="center" width="98%" border="1" bordercolor="#CCCCCC" bgcolor="#FFFFFF" cellspacing="1" cellpadding="0"  style="border-collapse:collapse" >

<? $sqlItem = "SELECT itemlist.*,itemrate.*, dma.* from `itemlist`,`itemrate`,`dma` where itemCode='$dmaRun[reqItemCode]' AND rateItemCode='$dmaRun[reqItemCode]' AND dmaItemCode='$dmaRun[reqItemCode]'";
//echo $sqlItem;
$sqlrunItem= mysql_query($sqlItem);
$itemResult=mysql_fetch_array($sqlrunItem);
?>
          <tr>
		     <td colspan="4">Item Code: <b><font color="#FF6633"><? echo "$dmaRun[reqItemCode]( $itemResult[itemDes])";?></font></b></td>
		  </tr>
          <tr>
		     <td>Approved: <font color="#FF6633"><? echo "$itemResult[dmaQty] </font>$itemResult[itemUnit]";?></td>
		     <td>Stock for this IOW:</td>
			 <td>Total Stock: </td>			 
		  </tr>
          <tr>
		     <td>Up-to-date Issued: </td>
		     <td>Current Issue: <input type="text"> </td>
		  </tr>		  
	  </table>
	  </td>
<tr><td height="10" colspan="4"></td></tr>	  
    </tr>

<? }?>
<tr><td height="30" colspan="4"></td></tr>
<tr><td colspan="4">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr> <td> Change Order Received</td><td><input type="radio" checked> NO <input type="radio"> Yes <input type="text"></td></tr>	
    <tr> <td> Time loss because of Weather</td><td><input type="radio" checked> NO <input type="radio"> Yes <input type="text"></td></tr>	
    <tr> <td> Time loss because of Equipment Brakedown</td><td><input type="radio" checked> NO <input type="radio"> Yes <input type="text"></td></tr>		
    <tr> <td> Time loss because of Accident</td><td><input type="radio" checked> NO <input type="radio"> Yes <input type="text"></td></tr>		
    <tr> <td> Time loss because of Other Reasons</td><td><input type="radio" checked> NO <input type="radio"> Yes <input type="text"></td></tr>		
    <tr> <td> Attach Picture Of the Day</td><td><input type="radio" checked> NO <input type="radio"> Yes <input type="file"></td></tr>		
  </table>
</td></tr>
  </table>
<? }?>
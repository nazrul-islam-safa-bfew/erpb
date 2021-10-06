<? 
echo "<b><u>Item Of Work List for </u></b>";
echo "Project Code: <u>$selectedPcode</u><br><br>";
include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sqlp = "SELECT * from `iow` where `iowProjectCode` LIKE '$selectedPcode' ";
//echo $sqlp;
$sqlrunp= mysql_query($sqlp);

?>

<table  align="center" width="98%" border="1" bordercolor="#E0E0E0" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#EEEEEE">
 <td height="30" width="100"><b>Item of Work Code</b></td>
 <td width="200"><b>Item of Work Description</b></td>
 <td><b>Total Qty</b> </td> 
 <td><b>Unit</b></td>  
 <td><b>Total Amount</b></td>
 <td><b>Status</b></td>  
 <td width="120"><b>ACTION</b></td>  
</tr>
<? while($iow=mysql_fetch_array($sqlrunp)){?>
<tr>
 <td><? echo $iow[iowCode];?></td>
 <td width="200"><? echo $iow[iowDes];?></td> 
 <td><? echo $iow[iowQty];?></td> 
 <td><? echo $iow[iowUnit];?></td> 
 <td><? echo $iow[iowTotal];?></td> 
 <td><? echo $iow[iowStatus];?></td> 
 <td width="120">
     <? echo "<a href='./index.php?keyword=view+dma&selectedPcode=$selectedPcode&iow=$iow[iowId]'>Detail</a> || ";?>
     <? echo "<a href='./index.php?keyword=editIOW&selectedPcode=$selectedPcode&iowId=$iow[iowId]'>Edit</a>";?> 
 </td>
</tr>
<? } ?>
</table>
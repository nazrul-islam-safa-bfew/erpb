<table align="center" width="95%" border="3"  bordercolor="CC9999" cellpadding="2" cellspacing="0" style="border-collapse:collapse">
<tr>
 <td bgcolor="#DDAAAA">Select report mode</td>
 <td>
   <input <? if($keyword=='store histore report') echo 'checked';?>  type="radio" name="c" onClick="window.location='./index.php?keyword=store+histore+report&itemCode=<? echo $itemCode;?>&itemDes=<? echo $itemDes;?>';" >  Stock History Report &nbsp;&nbsp;&nbsp;&nbsp;
 </td>
 <td>
   <input <? if($keyword=='store transfer report') echo 'checked';?>  type="radio" name="c" onClick="window.location='./index.php?keyword=store+transfer+report&itemCode=<? echo $itemCode;?>&itemDes=<? echo $itemDes;?>';" > Store Transfer Report    &nbsp;&nbsp;&nbsp;&nbsp; 
 </td>
 <td>
   <input <? if($keyword=='store item detail') echo 'checked';?>  type="radio" name="c" onClick="window.location='./index.php?keyword=store+item+detail&itemCode=<? echo $itemCode;?>&itemDes=<? echo $itemDes;?>';" >  Store Receive Report    &nbsp;&nbsp;&nbsp;&nbsp; 
 </td>
</tr>
</table>


<br>
<br>

<table align="center" width="95%" border="3"  bordercolor="CC9999" cellpadding="2" cellspacing="0" style="border-collapse:collapse">
  <tr bgcolor="#CC9999"> 
    <td colspan="6" align="right" valign="top"><? echo $itemCode.' '. $itemDes;?><font class='englishhead'> 
      item transfer report</font></td>
  </tr>
  <tr > 
    <th align="center" >Transfer To</th>
    <th align="center" > Transfer Reference</th>
    <th align="center" > Transfer Date</th>
    <th align="center" >Transfer Quantity</th>
    <th align="center" >Rate</th>
  </tr>
  <? include("./config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sql="SELECT store.*,itemlist.*,storetransfer.* FROM store,itemlist, storetransfer where store.itemCode = itemlist.itemCode AND itemlist.itemCode = '$itemCode' AND store.rsid = storetransfer.rsid ORDER by sdate";	
//echo $sql;
$sqlquery=mysql_query($sql);	
while($sqlresult=mysql_fetch_array($sqlquery)){
	?>
  <tr > 
    <td > <? echo $sqlresult[transferTo];?></td>
    <td ><? echo $sqlresult[transferRef];?></td>
    <td  align="center"><? echo mydate($sqlresult[tdate]);?></td>
    <td align="right" ><? echo $sqlresult[transferQty].' '.$sqlresult[itemUnit];?></td>
    <td  align="right"><? echo number_format($sqlresult[rate],2);?></td>
  </tr>
  <? }?>
</table>

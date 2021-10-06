<table align="center" width="90%" border="3"  bordercolor="CC9999" cellpadding="2" cellspacing="0" style="border-collapse:collapse">
	<tr>
		 <td bgcolor="#EECCCC">Select report mode</td>
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
 <td colspan="5" align="right" valign="top"><? echo $itemCode.' '. $itemDes;?><font class='englishhead'> item stock report</font></td>
</tr>
<tr >
 <th align="center" >Receive / Transfer  </th>
 <th align="center" >Quality Remarks</th> 
 <th align="center" > Reference</th>
 <th align="center" > Date</th> 
 <th align="center" >Quantity</th>  
</tr>
<? include("./config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sql="SELECT store.*,itemlist.* FROM store,itemlist where store.itemCode = itemlist.itemCode AND store.itemCode = '$itemCode' ORDER by sdate";	
//echo $sql;
$sqlquery=mysql_query($sql);	
while($sqlresult=mysql_fetch_array($sqlquery)){
	?>
<tr bgcolor="#FFDDDD" >
 <td ></td>
 <td ></td>
 <td ></td> 
 <td ></td>  
 <td ></td>
</tr>

<tr bgcolor="#FFDDDD" >
 <td > <? echo $sqlresult[receiveFrom];?></td>
 <td ><?  echo $sqlresult[remark];?></td>
 <td ><? echo $sqlresult[reference];?></td> 
 <td align="center" ><? echo mydate($sqlresult[sdate]);?></td>  
 <td align="right" ><? echo $sqlresult[receiveQty].' '.$sqlresult[itemUnit];?></td>
</tr>
<?
$sqlt="SELECT * FROM storetransfer where  rsid = '$sqlresult[rsid]' ORDER by tdate";	
//echo $sql;
$sqlqueryt=mysql_query($sqlt);	
while($stransfer=mysql_fetch_array($sqlqueryt)){
	?>
<tr bgcolor="#FFF8F8" >
 <td > <? echo $stransfer[transferTo];?></td>
 <td ></td> 
 <td > <? echo $stransfer[transferRef];?></td>

 <td align="center" ><? echo mydate($stransfer[tdate]);?></td>  
 <td align="right" ><? echo '( '.$stransfer[transferQty].' ) '.$sqlresult[itemUnit];?></td>
</tr>
<? }?>
<tr><td colspan="5"></td></tr>
<tr><td><br></td></tr>
<? }?>
</table>
<? if(!$show){?>
<form name="store" action="./index.php?keyword=store+transfer" method="post">
<table align="center" width="400" border="3"  bordercolor="CC9999" cellpadding="2" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td colspan="2" align="right" valign="top"><font class='englishhead'> stock transfer form</font></td>
</tr>
<tr><td>Item Code</td>
    <td>
	<input name="itemCode1" onKeyUp="return autoTab(this, 2, event);" size="2" maxlength="2"> - 
    <input name="itemCode2" onKeyUp="return autoTab(this, 2, event);" size="2" maxlength="2"> - 
    <input name="itemCode3" onKeyUp="return autoTab(this, 3, event);" size="3" maxlength="3" >
	</td>
</tr>

<tr >
	<td >To</td>
	<td><?  
		$ex = array('Sell','Scrap','Stolen');
		echo selectPlist("transferTo",$ex,'')?>	</td>
</tr>

<tr >
	<td >Transportation Reference</td>
	<td><input type="text" name="transferRef"></td>
</tr>


<tr><td colspan="2" align="center" ><input type="submit" name="show" value="Show Stock" class="store" ></td></tr>
</table>
</form>
<? }?>	
<? if($show){?>
<table align="center" width="400" border="3"  bordercolor="CC9999" cellpadding="2" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td colspan="2" align="right" valign="top"><font class='englishhead'> stock transfer form</font></td>
</tr>
<tr><td>Item Code</td>  <td ><? echo $itemCode1.'-'.$itemCode2.'-'.$itemCode3;?> </td></tr>
<tr><td>Item Description</td>  <td ><? echo itemDes("$itemCode1-$itemCode2-$itemCode3");?> </td></tr>

<tr >
	<td >Transfer To </td>
	<td><? echo  myprojectName($transferTo );?> </td>
</tr>

<tr >
	<td >Transportation Reference</td>
	<td><? echo $transferRef;?></td>
</tr>

</table>
<? }?>
	<br>
<? if($show){?>
<form  name="Transfer" action="./store/storeSql.php" method="post">
<table align="center" width="95%" border="3"  bordercolor="CC9999" cellpadding="2" cellspacing="0" style="border-collapse:collapse">
  <tr bgcolor="#CC9999"> 
    <td>
	<? 
	include("./config.inc.php");
	$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
	
     $result = mysql_query("SELECT * FROM storetransfer");
     $num_rows = mysql_num_rows($result);
 if($num_rows<10) $t1="0000$num_rows";
 elseif($num_rows<100) $t1="000$num_rows";
 elseif($num_rows<1000) $t1="00$num_rows"; 
  elseif($num_rows<10000) $t1="0$num_rows"; 
  $stn="$loginProject-$transferTo-$t1";
	 echo $stn;
	?>
	
	</td>
    <td colspan="6" align="right" valign="top"><font class='englishhead'> item stock report</font></td>
  </tr>
  <tr > 
    <th align="center" >SL</th>
    <th align="center" >Quality Remarks</th>
    <th align="center" > Receive Reference</th>
    <th align="center" > Received at</th>
    <th align="center" >Quantity</th>
    <th align="center" >Transfer Qty</th>	
    <th align="center" >Rate</th>	
  </tr>
  <tr><td></td></tr>
  <? include("./config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
	
$itemCode= $itemCode1.'-'.$itemCode2.'-'.$itemCode3;	
$sql="SELECT store.*,itemlist.* FROM store,itemlist where store.itemCode = itemlist.itemCode AND store.itemCode = '$itemCode' ORDER by sdate";	
$sqlquery=mysql_query($sql);
$i=1;	
while($sqlresult=mysql_fetch_array($sqlquery)){
	?>
  <tr > 
    <td><? echo $i;?></td>
    <td ><? echo $sqlresult[remark];?></td>
    <td ><? echo $sqlresult[reference];?></td>
    <td  align="center"><? echo mydate($sqlresult[sdate]);?></td>
    <td align="right" ><? echo $sqlresult[currentQty].'<font class=out> '.$sqlresult[itemUnit].'</font>';?>
	<input type="hidden" name="quantity<? echo $i;?>" value="<? echo $sqlresult[currentQty];?>">
	</td>
    <td  align="right"><input type="text" name="transferQty<? echo $i;?>"></td>
	<input type="hidden" name="rsid<? echo $i;?>" value="<? echo $sqlresult[rsid];?>">
    <td  align="right"><? echo number_format($sqlresult[rate],2);?></td>
  </tr>
  <? $i++; }?>
   <input type="hidden" name="t" value="<? echo $i;?>">
   <input type="hidden" name="transferTo" value="<? echo $transferTo ;?>">   
   <input type="hidden" name="transferRef" value="<? echo $transferRef ;?>">      
   <input type="hidden" name="stn" value="<? echo $stn;?>">      
  <tr><td colspan="6" align="center"><input type="submit" name="transfer" value="Transfer"></td></tr>
</table>
</form>
<? }?>
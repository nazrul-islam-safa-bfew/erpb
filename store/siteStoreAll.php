 <form name="sitestore" action="index.php?keyword=site+store+all" method="post">
<table align="center" width="500" border="3"  bordercolor="CC9999" cellpadding="2" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td colspan="2" align="right" valign="top"><font class='englishhead'>site store Search form</font></td>
</tr>
<tr>	
   <td>Item Type</td>
   <td ><select name='type' size="1" >
<option value="">Select Type</option>
<option value="01" <? if($type=='01') echo 'selected';?> >01-00-000 CONSTRUCTION MATERIALS</option>
<option value="02" <? if($type=='02') echo 'selected';?>>02-00-000	PLUMBING,SANITARY & BATHROOM FITTINGS</option>
<option value="03" <? if($type=='03') echo 'selected';?>>03-00-000	TIMBER AND BAMBOO</option>
<option value="04" <? if($type=='04') echo 'selected';?>>04-00-000	DOOR WINDOW AND BOARD</option>
<option value="05" <? if($type=='05') echo 'selected';?>>05-00-000	RAW MATERIALS AND CHEMICALS</option>
<option value="06" <? if($type=='06') echo 'selected';?>>06-00-000	GENERAL HARDWARE</option>
<option value="07" <? if($type=='07') echo 'selected';?>>07-00-000	PACKING,GASKETS AND INSULATING MATERIALS</option>
<option value="08" <? if($type=='08') echo 'selected';?>>08-00-000	PIPES,TUBES,HOSEES AND FITTING</option>
<option value="09" <? if($type=='09') echo 'selected';?>>09-00-000	IRON,STEEL AND NON-FERROUS METAL</option>
<option value="10" <? if($type=='10') echo 'selected';?>>10-00-000	PAINT AND VARNISHES</option>
<option value="11" <? if($type=='11') echo 'selected';?>>11-00-000	FUEL,OIL AND LUBRICANTS</option>
<option value="12" <? if($type=='12') echo 'selected';?>>12-00-000	ELECTRODE.</option>
<option value="13" <? if($type=='13') echo 'selected';?>>13-00-000	GAS,DISC AND WELDING ACCESSARIES</option>
<option value="14" <? if($type=='14') echo 'selected';?>>14-00-000	BRUSH,EMERY,BROOM ETC</option>
<option value="15" <? if($type=='15') echo 'selected';?>>15-00-000	CORDS,ROPES AND CHAINS</option>
<option value="16" <? if($type=='16') echo 'selected';?>>16-00-000	SAFETY MATERIALS</option>
<option value="17" <? if($type=='17') echo 'selected';?>>17-00-000	COMSUMABLE TOOLS</option>
<option value="18" <? if($type=='18') echo 'selected';?>>18-00-000	ELECTRIC CABLES & WIRE</option>
<option value="19" <? if($type=='19') echo 'selected';?>>19-00-000	ELECTRICAL FITTINGS</option>
<option value="20" <? if($type=='20') echo 'selected';?>>20-00-000	STATIONERY MATERIALS</option>
<option value="21" <? if($type=='21') echo 'selected';?>>21-00-000	OFFICE STATIONERY TOOL</option>
<option value="22" <? if($type=='22') echo 'selected';?>>22-00-000	FURNITURE AND FIXTURE</option>
<option value="23" <? if($type=='23') echo 'selected';?>>23-00-000	KITCHEN WARE, CROCKERIES AND CUTLARIES</option>
<option value="24" <? if($type=='24') echo 'selected';?>>24-00-000	MICSCELLANEOUS</option>
<option value="25" <? if($type=='25') echo 'selected';?>>25-00-000	TRANSPORT & MACHINERIES SPARES</option>
<option value="35" <? if($type=='35') echo 'selected';?>>35-00-000	WELDING TOOLS</option>
<option value="36" <? if($type=='36') echo 'selected';?>>36-00-000	PAINT & SAND BLASTING TOOLS</option>
<option value="37" <? if($type=='37') echo 'selected';?>>37-00-000	CUTTING TOOLS</option>
<option value="38" <? if($type=='38') echo 'selected';?>>38-00-000	MEASURING TOOLS</option>
<option value="39" <? if($type=='39') echo 'selected';?>>39-00-000	GRINDER,PULLER,VICE,DRILL TOOLS</option>
<option value="40" <? if($type=='40') echo 'selected';?>>40-00-000	SCREW DRIVER,HAMMER ETC.</option>
<option value="41" <? if($type=='41') echo 'selected';?>>41-00-000	FILE TOOLS</option>
<option value="42" <? if($type=='42') echo 'selected';?>>42-00-000	CRIMPING TOOLS</option>	
 </select></td>
</tr>
<tr><td>Item Code</td>
    <td >
	<input name="itemCode1" onKeyUp="return autoTab(this, 2, event);" size="2" maxlength="2" > - 
    <input name="itemCode2" onKeyUp="return autoTab(this, 2, event);" size="2" maxlength="2"> - 
    <input name="itemCode3" onKeyUp="return autoTab(this, 3, event);" size="3" maxlength="3" >
	</td>
</tr>
<tr>
 <td colspan="2" align="center">
	<input type="radio" name="radioCh" value="1"  onClick="location.href='./index.php?keyword=site+store'">Stocks at Hand 
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="radio" name="radioCh" value="2" checked onClick="location.href='./index.php?keyword=site+store+all'">All Approved Items</td> 
</tr>
<tr><td colspan="2" align="center" ><input type="submit" name="search" value="Search" class="store" ></td></tr>
</table>
</form>

<table align="center" width="95%" border="3"  bordercolor="CC9999" cellpadding="2" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td colspan="8" align="right" valign="top"><font class='englishhead'>site store status</font></td>
</tr>
<tr >
 <td align="center" ><b>Item Code</b></td>
 <td align="center" ><b>Item Description</b></td> 
 <td align="center" ><b>Unit</b></td> 
 <td align="center" ><b>Quantity</b></td>  
 <td align="center" ><b>Rate</b></td>   
 <td align="center" ><b>Amount</b></td>   
</tr>
<? include("./config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);

//$sql="SELECT SUM(currentQty) as qty, AVG(rate) as rate,itemCode FROM store".$loginProject." WHERE 1 AND currentQty <> 0 ";	

$sql="SELECT dmaItemCode,SUM(dmaQty) as dmaTotal,iow.iowId from dma,iow".
		 " WHERE  iowStatus IN ('Approved by Mngr P&C','Approved by MD')".
		 " AND iow.iowId=dma.dmaiow AND dmaProjectCode='$loginProject'".
		 " Group by dmaItemCode ORDER by dmaItemCode";	

/*if($type){	
$sql.=" AND itemCode LIKE '$type-%' ";	
}

if($itemCode1 ){
$itemCode=$itemCode1.'-'.$itemCode2.'-'.$itemCode3;	
$sql.=" AND itemCode='$itemCode'";	
}

$sql.=" group By store".$loginProject.".itemCode";

*/
//echo $sql.'<br>';


$sqlquery=mysql_query($sql);
$i=0;
$total=0;	
while($sqlresult=mysql_fetch_array($sqlquery)){
	?>
<? 
$pieces = explode("-", $sqlresult[dmaItemCode]);
$key= $pieces[0]; 

if($pkey!=$key && $i>0 )echo "<tr><TD  align='right' bgcolor='#FFFFEE' colspan='7'>Stock Value of <b><font color=#FF6666>".itemGroup($pkey)."</font></b> in Taka : <b>".number_format($subtotal,2)."</b></TD></tr>";?>
<tr >
 <td align="center" ><a href="./store/siteDailyRequirment.php?project=<? echo $loginProject;?>&itemCode=<? echo $sqlresult[dmaItemCode];?>" target="_blank"><? echo $sqlresult[dmaItemCode];?></a></td>
 <td ><? 
 $temp=itemDes($sqlresult[dmaItemCode]);
 echo $temp[des].', '.$temp[spc];?></td>
 <td  align="center"><? echo $temp[unit];?></td>
 <td  align="right"><?
$sqls="SELECT SUM(currentQty) as qty, AVG(rate) as rate,itemCode".
	  " FROM store".$loginProject." WHERE itemCode='$sqlresult[dmaItemCode]' AND currentQty <> 0 ".
	  " group By store".$loginProject.".itemCode";	
//echo $sqls;
 $sqlqs = mysql_query($sqls);
 $results = mysql_fetch_array($sqlqs);
 
  echo number_format($results[qty],3);?></td>
 <td align="right" ><? echo number_format($results[rate],2);?></td>
 <td align="right" ><? echo number_format(round($results[qty] * $results[rate]),2);?></td>
<? 

if($pkey!=$key){$subtotal=0; }
$subtotal += round($results[qty] * $results[rate]);
$total+=round($results[qty] * $results[rate]);

//if($pkey!=$key ){
//echo "<TD  align='right' bgcolor='#FFFFEE'>".number_format($subtotal,2)."</TD>";
//}
$pkey= $key;
?>

<? $i++;

}

?>
</tr>
<tr>
<TD  align='right' bgcolor='#FFFFEE' colspan="7"> <? echo "Stock Value of <b><font color=#FF6666>".itemGroup($pkey)."</font></b> in Taka: <b>"; echo number_format($subtotal,2);?></b></TD>
</tr >
<tr>
<TD  align='right' bgcolor='#FFFFDD' colspan="7"> <? echo "Total Stock Value Taka: <b>"; echo number_format($total,2);?></b></TD>
</tr >

</table>
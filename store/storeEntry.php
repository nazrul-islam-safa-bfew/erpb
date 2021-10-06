<? if($rid){

 include("./config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sql="SELECT * FROM store where rsid=$rid";	
//echo $sql;
$sqlquery=mysql_query($sql);	
$sqlresult=mysql_fetch_array($sqlquery);
}
	?>

<form name="store" action="./store/storeSql.php" method="post">
<table align="center" width="500" border="3"  bordercolor="CC9999" cellpadding="2" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td colspan="2" align="right" valign="top"><font class='englishhead'>central store receive form</font></td>
</tr>
<tr>	
   <td>Item Type</td>
   <td >
  <? if($rid){$teemp=explode('-',$sqlresult[itemCode]); $type=$teemp[0];}      ?>
   <select name='type' size="1" onChange="location.href='index.php?keyword=store+entry&type='+store.type.options[document.store.type.selectedIndex].value";>
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
<option value="24" <? if($type=='24') echo 'selected';?>>24-00-000 MICSCELLANEOUS</option>
<option value="25" <? if($type=='25') echo 'selected';?>>25-00-000	TRANSPORT & MACHINERIES SPARES</option>
<option value="26" <? if($type=='26') echo 'selected';?>>26-00-000 OLD PIPES,TUBES,HOSEES AND FITTING</option>
<option value="27" <? if($type=='27') echo 'selected';?>>27-00-000 OLD IRON,STEEL AND NON-FERROUS METAL</option>
<option value="33" <? if($type=='33') echo 'selected';?>>33-00-000 OFFICE TOOLS</option>

<option value="34" <? if($type=='34') echo 'selected';?>>34-00-000 SAFETY TOOLS</option>
<option value="35" <? if($type=='35') echo 'selected';?>>35-00-000	WELDING TOOLS</option>
<option value="36" <? if($type=='36') echo 'selected';?>>36-00-000	PAINT & SAND BLASTING TOOLS</option>
<option value="37" <? if($type=='37') echo 'selected';?>>37-00-000	CUTTING TOOLS</option>
<option value="38" <? if($type=='38') echo 'selected';?>>38-00-000	MEASURING TOOLS</option>
<option value="39" <? if($type=='39') echo 'selected';?>>39-00-000	GRINDER,PULLER,VICE,DRILL TOOLS</option>
<option value="40" <? if($type=='40') echo 'selected';?>>40-00-000	SCREW DRIVER,HAMMER ETC.</option>
<option value="41" <? if($type=='41') echo 'selected';?>>41-00-000	FILE TOOLS</option>
<option value="42" <? if($type=='42') echo 'selected';?>>42-00-000	CRIMPING TOOLS</option>
<option value="43" <? if($type=='43') echo 'selected';?>>43-00-000	SCAFFOLDING TOOLS</option>	
<option value="44" <? if($type=='44') echo 'selected';?>>44-00-000	WRENCH TOOLS</option>	
<option value="45" <? if($type=='45') echo 'selected';?>>45-00-000	LABORATORY TOOLS</option>	
<option value="46" <? if($type=='46') echo 'selected';?>>46-00-000	HANDELLING TOOLS</option>	
<option value="49" <? if($type=='49') echo 'selected';?>>49-00-000	MISCELLANEOUS TOOLS</option>	
	
 </select></td>
</tr>

<tr><td>Item Code</td>
<? if($rid){?>
   <td ><input type="text" size="10" name="itemCode" value="<? echo $sqlresult[itemCode];?>"></td>
   <? } else {?>
    <td >
<!-- 	<input name="itemCode1" onKeyUp="return autoTab(this, 2, event);" size="2" maxlength="2"> - 
    <input name="itemCode2" onKeyUp="return autoTab(this, 2, event);" size="2" maxlength="2"> - 
    <input name="itemCode3" onKeyUp="return autoTab(this, 3, event);" size="3" maxlength="3" >
 -->

<? 
include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sqlp = "SELECT itemCode,itemDes,itemSpec,itemUnit from `itemlist` WHERE itemCode LIKE '$type-%'";
//echo $sqlp;
$sqlrunp= mysql_query($sqlp) or die();

$plist= "<select name='itemCode'> ";
$plist.= "<option value='0'>Select One</option> ";
 while($typel= mysql_fetch_array($sqlrunp))
{
 $plist.= "<option value='".$typel[itemCode]."'";
 $plist.= ">$typel[itemCode]--$typel[itemDes]--$typel[itemSpec]--$typel[itemUnit]</option>  ";
 }
 $plist.= '</select>';
 echo $plist.'</td></tr>';
 ?>
	
	</td>

<? }//else?>
</tr>
<tr>	
   <td>Quantity</td>
   <td ><input type="text" size="10" name="receiveQty" value="<? echo $sqlresult[receiveQty];?>"></td>
</tr>
<tr>	
   <td>Unit Rate</td>
   <td ><input type="text" size="10" name="rate"value="<? echo $sqlresult[rate];?>"></td>
</tr>

<tr >
	<td >Source</td>
	  <td>Opening Balance on 01-07-2006
	  
	  <input type="hidden" name="receiveFrom" value="Opening Balance" readonly=""> 
      </td>
</tr>

<tr>	
   <td>Quality Remarks</td>
   <td ><input type="text" size="40" name="remark" value="<? echo $sqlresult[remark];?>"></td>
</tr>
<? if($rid){?>
<tr><td colspan="2" align="center" >
<input type="hidden" name="rsid" value="<? echo $rid;?>"  >
<input type="submit" name="update" value="Update" class="store" ></td></tr>
<? } else{?>
<tr><td colspan="2" align="center" ><input type="submit" name="save" value="Save" class="store" ></td></tr>
<? }?>
</table>
</form>
	

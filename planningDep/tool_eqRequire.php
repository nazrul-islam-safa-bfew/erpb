	<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
<?  

if($eqid){
include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);

 $sql=@mysql_query("SELECT * FROM equipment WHERE eqid=$eqid") or die('Please try later!!');
 $eqresult= mysql_fetch_array($sql);

}

?>
<form name="equipment" onsubmit="return validateForm( this, 0, 1, 0, 0, 15 );" action="./equipment/equipmentSql.php" method="post">
<table align="center" width="600" border="3"  bordercolor="CC9999" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td align="right" valign="top"><font class='englishhead'>equipment req form</font></td>
</tr>
<tr>
 <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="3">

<? if(!$eqresult[assetId]){?>
<tr><td>Euipment Group</td>
<td>
 <select name="eqGroup" onChange="location.href='index.php?keyword=tool_eq+require&eqGroup='+equipment.eqGroup.options[document.equipment.eqGroup.selectedIndex].value";>
  <option value="">Select One</option>
  <option value="50-%" <? if($eqGroup=="50-%") echo 'SELECTED';?>>Cutting, Drilling & Grinding Equipments</option>
  <option value="51-%" <? if($eqGroup=="51-%") echo 'SELECTED';?>>Power Equipments</option>  
  <option value="52-%" <? if($eqGroup=="52-%") echo 'SELECTED';?>>Welding Equipments</option>  
  <option value="54-%" <? if($eqGroup=="54-%") echo 'SELECTED';?>>Transport Vehicles</option>  
  <option value="55-%" <? if($eqGroup=="55-%") echo 'SELECTED';?>>Workshop Machineries</option>  
  <option value="56-%" <? if($eqGroup=="56-%") echo 'SELECTED';?>>Civil Construction Machineries & Plants</option>    
  <option value="58-%" <? if($eqGroup=="58-%") echo 'SELECTED';?>>Road Construction Macheniries & Plants</option>    
  <option value="59-%" <? if($eqGroup=="59-%") echo 'SELECTED';?>>Material Handling Machineries</option>        
  <option value="60-%" <? if($eqGroup=="60-%") echo 'SELECTED';?>>Pipeline Contruction Machineries</option>    
  <option value="61-%" <? if($eqGroup=="61-%") echo 'SELECTED';?>>Testing Equippments</option>     
  <option value="62-%" <? if($eqGroup=="62-%") echo 'SELECTED';?>>Elecric Erection Tools</option>    
  <option value="63-%" <? if($eqGroup=="63-%") echo 'SELECTED';?>>Instrument Erection Equipment</option>      
  <option value="64-%" <? if($eqGroup=="64-%") echo 'SELECTED';?>>Survey Equipments</option>    
  <option value="65-%" <? if($eqGroup=="65-%") echo 'SELECTED';?>>Piling Equipments</option> 
  <option value="68-%" <? if($eqGroup=="68-%") echo 'SELECTED';?>>Office Equipments</option> 
  <option value="69-%" <? if($eqGroup=="69-%") echo 'SELECTED';?>>Miscullineous Equipments</option>   
 </select>
</td>	
</tr>
<? }?>
<? 
$temp=itemDes($eqresult[itemCode]);
if($eqresult[assetId]){ echo '<tr><td>AssetId</td><td>'.eqpId($eqresult[assetId],$eqresult[itemCode]).'</td></tr>';
echo '<tr bgcolor=#FFEEEE><td>Description:</td><td>'.$temp[des].', '.$temp[spc].'</td></tr>';
}

else {
echo '<tr bgcolor=#FFEEEE><td>Item Code</td><td>';
include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sqlp = "SELECT itemCode,itemDes,itemSpec from `itemlist` WHERE itemCode LIKE '$eqGroup'";
//echo $sqlp;
$sqlrunp= mysql_query($sqlp) or die();

$plist= "<select name='itemCode'> ";
$plist.= "<option value='0'>Select One</option> ";
 while($typel= mysql_fetch_array($sqlrunp))
{
 $plist.= "<option value='".$typel[itemCode]."'";
 $plist.= ">$typel[itemCode]--$typel[itemDes]--$typel[itemSpec]</option>  ";
 }
 $plist.= '</select>';
 echo $plist.'</td></tr>';
 }
 ?>
	<SCRIPT LANGUAGE="JavaScript">
	var now = new Date(); 
	var cal = new CalendarPopup("testdiv1");
    	//cal.showNavigationDropdowns();
		cal.setWeekStartDay(6); // week is Monday - Sunday
		cal.addDisabledDates(null,formatDate(now,"yyyy-MM-dd")); 
		cal.setCssPrefix("TEST");		
		cal.offsetX = 200;
		cal.offsetY = 0;
		
	</SCRIPT>


<? $temp=explode('_',$eqresult[teqSpec]);
$model=$temp[0];
$brand=$temp[1];
$manuby=$temp[2];
$madein=$temp[3];
$speci=$temp[4];
$designCap=$temp[5];
$currentCap=$temp[6];
$yearManu=$temp[7];
?>
<tr>
   <td>Model</td>
   <td ><input type="text" name="model" value="<? echo $model;?>" size="50" <? if($r) echo 'readonly';?>></td>
</tr>
<tr bgcolor="#FFEEEE">
   <td>Brand</td>
   <td ><input type="text" name="brand" value="<? echo $brand;?>" size="50" <? if($r) echo 'readonly';?>></td>
</tr>
<tr>
   <td>Manufactured by</td>
   <td ><input type="text" name="manuby" value="<? echo $manuby;?>"  size="50" <? if($r) echo 'readonly';?>></td>
</tr>
<tr bgcolor="#FFEEEE">
   <td>Made in</td>
   <td ><input type="text" name="madein" value="<? echo $madein;?>"  size="50" <? if($r) echo 'readonly';?>></td>
</tr>
<tr>
   <td>Specification</td>
   <td ><input type="text" name="speci" value="<? echo $speci;?>"  size="50" <? if($r) echo 'readonly';?>></td>
</tr>
<tr bgcolor="#FFEEEE">
   <td>Design Capacity</td>
   <td ><input type="text" name="designCap" value="<? echo $designCap;?>"  size="50" <? if($r) echo 'readonly';?>></td>
</tr>
<tr>
   <td>Current Capacity</td>
   <td ><input type="text" name="currentCap" value="<? echo $currentCap;?>"  size="50" <? if($r) echo 'readonly';?>></td>
</tr>
<tr bgcolor="#FFEEEE">
   <td>Year of Manufacture</td>
   <td ><input type="text" name="yearManu" value="<? echo $yearManu;?>" <? if($r) echo 'readonly';?>></td>
</tr>

<tr bgcolor="#FFEEEE">
   <td>Hourly outputs experienced in BFEW</td> 
   <td ><input type="text" size="50" name="exp"value="<? echo $eqresult[exp];?>" <? if($r) echo 'readonly';?>></td>
</tr>

<tr>
   <td><label for="price">Price</label></td> 
   <td ><input type="text" size="20" name="price"value="<? echo $eqresult[price];?>" alt="number|1" emsg="<br>Enter Price" <? if($r) echo 'readonly';?>> Tk.</td>
</tr>
<tr bgcolor="#FFEEEE">
   <td><label for="life">Life</label></td>
   <td ><input type="text" size="10" name="life" value="<? echo $eqresult[life];?>" alt="number|1" emsg="<br>Enter Life" <? if($r) echo 'readonly';?>> years</td>
</tr>
<tr>
   <td><label for="salvageValue">Salvage Value</label></td>
   <td ><input type="text" size="20" name="salvageValue" value="<? echo $eqresult[salvageValue];?>" alt="number|1" emsg="<br>Enter Salvage Value" <? if($r) echo 'readonly';?>> Tk.</td>
</tr>
<tr bgcolor="#FFEEEE">
   <td>Expected Use per Year</td>
   <td ><input type="text" size="5" name="days" value="<? echo $eqresult[days];?>" <? if($r) echo 'readonly';?>> Months
   </td>
</tr>
<tr>
   <td>Daily Working Hours</td>
   <td ><input type="text" size="5" name="hours" value="<? echo $eqresult[hours];?>" <? if($r) echo 'readonly';?>> Hours
   </td>
</tr>

<tr><td colspan="2" align="center" ><input type="submit" name="save" value="Save" class="store"  <? if($r) echo 'disabled';?> ></td></tr>
	</table>
 </td>
</tr>
</table>
<input type="hidden" name="eqid" value="<? echo $eqid;?>">
</form>
	
<div id=testdiv1
      style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
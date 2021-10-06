<?
/* Account Information*/
$allItemClass=array('Stock Item','Non Stock Item','Current Asset','Fixed Asset','Wages','Salary');

class itemCode{
	public function __construct($itemCode){
		$this->itemCode=$itemCode;
	}
	public function split(){
		$itemArray=explode("-",$this->itemCode);
		return [$itemArray[0],$itemArray[1],$itemArray[2]];
	}
	public function first(){
		return $this->split()[0];
	}
	public function second(){
		return $this->split()[1];
	}
	public function third(){
		return $this->split()[2];
	}
	public function full(){
		return $this->itemCode;
	}
}
$ic=new itemCode($itemCode);
?>
<? if($updateItem){
include("./config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
	$itemCode="$itemCode1-$itemCode2-%";	
$sqlitem = "UPDATE `itemlist` SET resourceType='$resourceType' WHERE itemCode like '$itemCode'";
//echo $sqlitem;
$sqlrunItem= mysqli_query($db, $sqlitem);


}
?>
<?
if($e==1){
	$sql1="SELECT * from itemlist where itemCode='$itemCode' ";
	if($s>=35 AND $s<50){
		$sql1="SELECT itemlist.*,toolrate.* from itemlist,toolrate where itemlist.itemCode='$itemCode' AND toolrate.itemCode='$itemCode' ";
}
//echo $sql1;
$sqlrunItem1= mysqli_query($db, $sql1);
$sqlrun= mysqli_fetch_array($sqlrunItem1);
	if(!$sqlrun){
		$sql1="SELECT * from itemlist where itemCode='$itemCode' ";
		$sqlrunItem1= mysqli_query($db, $sql1);
		$sqlrun=mysqli_fetch_array($sqlrunItem1);
	}
}
if(!$p AND $s){
?>
<form name="newItem" action="./index.php?keyword=rate+Item+type" method="post">
<table border="1" align="center" width="600" cellpadding="0" cellspacing="0" bordercolor="#E4E4E4" style="border-collapse:collapse">
<tr><td colspan="2" bgcolor="#EEEEEE" align="center"><b><? if($e==1) echo "Edit Item"; else echo "Enter New Item";?></b></td></tr>
	
	<tr>
		<td>Item Code</td><td><? $temp=explode('-',$sqlrun[itemCode]);?>
		<input name="itemCode1" onKeyUp="return autoTab(this, 2, event);" size="3" maxlength="2" value="<? echo $s;?>" readonly=""> - 
		<input name="itemCode2" onKeyUp="return autoTab(this, 2, event);" size="3" maxlength="2" readonly="" value="<? echo $temp[1]?>">
		</td>
	</tr>
	

			<style>
				#itemContainer li{border:1px solid #ccc;transition:all .5s linear;}
				#itemContainer li:hover{border:1px solid #00f;}
			</style>
			
			<tr>
				<td>Acure At</td>
				<td>
					<select name="resourceType" id="resourceType">
						<option value="start">Started</option>
						<option value="prorated">Prorated</option>
<!-- 						<option value="end">Ended</option> -->
					</select>
				</td>
			</tr>
<?php } // ?>
	
<tr>
  <td colspan="2" align="center"> 
        <? if($e==1) {?>
        	<input type="submit" name="updateItem" value="Update">
        <? } ?>
   </td>
</tr>
</table>	
<input type="hidden" name="s" value="<? echo $s;?>">
</form>


<form name="itm" action="#" method="post">
  <select name="items" size="1" 
onChange="location.href='index.php?keyword=rate+Item+type&s='+itm.items.options[document.itm.items.selectedIndex].value";>
    <option value="">Select One Group</option>
    <option value="01" <? if($s=='01') echo 'selected';?> >01-00-000 CONSTRUCTION 
    MATERIALS</option>
    <option value="02" <? if($s=='02') echo 'selected';?>>02-00-000 PLUMBING,SANITARY 
    & BATHROOM FITTINGS</option>
    <option value="03" <? if($s=='03') echo 'selected';?>>03-00-000 TIMBER AND 
    BAMBOO</option>
    <option value="04" <? if($s=='04') echo 'selected';?>>04-00-000 DOOR WINDOW 
    AND BOARD</option>
    <option value="05" <? if($s=='05') echo 'selected';?>>05-00-000 RAW MATERIALS 
    AND CHEMICALS</option>
    <option value="06" <? if($s=='06') echo 'selected';?>>06-00-000 GENERAL HARDWARE</option>
    <option value="07" <? if($s=='07') echo 'selected';?>>07-00-000 PACKING,GASKETS 
    AND INSULATING MATERIALS</option>
    <option value="08" <? if($s=='08') echo 'selected';?>>08-00-000 PIPES,TUBES,HOSEES AND FITTING</option>
    <option value="09" <? if($s=='09') echo 'selected';?>>09-00-000 IRON,STEEL AND NON-FERROUS METAL</option>
    <option value="10" <? if($s=='10') echo 'selected';?>>10-00-000 PAINT AND 
    VARNISHES</option>
    <option value="11" <? if($s=='11') echo 'selected';?>>11-00-000 FUEL,OIL AND 
    LUBRICANTS</option>
    <option value="12" <? if($s=='12') echo 'selected';?>>12-00-000 ELECTRODE.</option>
    <option value="13" <? if($s=='13') echo 'selected';?>>13-00-000 GAS,DISC AND 
    WELDING ACCESSARIES</option>
    <option value="14" <? if($s=='14') echo 'selected';?>>14-00-000 BRUSH,EMERY,BROOM 
    ETC</option>
    <option value="15" <? if($s=='15') echo 'selected';?>>15-00-000 CORDS,ROPES 
    AND CHAINS</option>
    <option value="16" <? if($s=='16') echo 'selected';?>>16-00-000 SAFETY MATERIALS</option>
    <option value="17" <? if($s=='17') echo 'selected';?>>17-00-000 COMSUMABLE 
    TOOLS</option>
    <option value="18" <? if($s=='18') echo 'selected';?>>18-00-000 ELECTRIC CABLES 
    & WIRE</option>
    <option value="19" <? if($s=='19') echo 'selected';?>>19-00-000 ELECTRICAL 
    FITTINGS</option>
    <option value="20" <? if($s=='20') echo 'selected';?>>20-00-000 STATIONERY 
    MATERIALS</option>
    <option value="21" <? if($s=='21') echo 'selected';?>>21-00-000 OFFICE STATIONERY 
    TOOL</option>
    <option value="22" <? if($s=='22') echo 'selected';?>>22-00-000 FURNITURE 
    AND FIXTURE</option>
    <option value="23" <? if($s=='23') echo 'selected';?>>23-00-000 KITCHEN WARE, 
    CROCKERIES AND CUTLARIES</option>
    <option value="24" <? if($s=='24') echo 'selected';?>>24-00-000 MICSCELLANEOUS</option>
    <option value="25" <? if($s=='25') echo 'selected';?>>25-00-000 TRANSPORT & MACHINERIES SPARES</option>
    <option value="26" <? if($s=='26') echo 'selected';?>>26-00-000 MOBILE SET & ACCESSORIES</option>
    <option value="27" <? if($s=='27') echo 'selected';?>>27-00-000 OLD IRON,STEEL AND NON-FERROUS METAL</option>
	
    <option value="33" <? if($s=='33') echo 'selected';?>>33-00-000 OFFICE TOOLS</option>
    <option value="34" <? if($s=='34') echo 'selected';?>>34-00-000 SAFETY TOOLS</option>
    <option value="35" <? if($s=='35') echo 'selected';?>>35-00-000 WELDING TOOLS</option>
    <option value="36" <? if($s=='36') echo 'selected';?>>36-00-000 PAINT & SAND 
    BLASTING TOOLS</option>
    <option value="37" <? if($s=='37') echo 'selected';?>>37-00-000 CUTTING TOOLS</option>
    <option value="38" <? if($s=='38') echo 'selected';?>>38-00-000 MEASURING 
    TOOLS</option>
    <option value="39" <? if($s=='39') echo 'selected';?>>39-00-000 GRINDER,PULLER,VICE,DRILL 
    TOOLS</option>
    <option value="40" <? if($s=='40') echo 'selected';?>>40-00-000 SCREW DRIVER,HAMMER 
    ETC.</option>
    <option value="41" <? if($s=='41') echo 'selected';?>>41-00-000 FILE TOOLS</option>
    <option value="42" <? if($s=='42') echo 'selected';?>>42-00-000 CRIMPING TOOLS</option>
    <option value="43" <? if($s=='43') echo 'selected';?>>43-00-000 SCAFFOLDING 
    TOOLS</option>
    <option value="44" <? if($s=='44') echo 'selected';?>>44-00-000 WRENCH TOOLS</option>
    <option value="45" <? if($s=='45') echo 'selected';?>>45-00-000 LABORATORY 
    TOOLS</option>
    <option value="46" <? if($s=='46') echo 'selected';?>>46-00-000 HANDELLING 
    TOOLS</option>
    <option value="49" <? if($s=='49') echo 'selected';?>>49-00-000 MISCELLANEOUS 
    TOOLS</option>
    <option value="50" <? if($s=='50') echo 'selected';?>>50-00-000 Cutting,Drilling 
    & Grinding Equipment </option>
    <option value="51" <? if($s=='51') echo 'selected';?>>51-00-000 Power Equipment</option>
    <option value="52" <? if($s=='52') echo 'selected';?>>52-00-000 Welding Equipments</option>
    <option value="54" <? if($s=='54') echo 'selected';?>>54-00-000 Transport 
    Vehicles</option>
    <option value="55" <? if($s=='55') echo 'selected';?>>55-00-000 Workshop Machineries</option>
    <option value="56" <? if($s=='56') echo 'selected';?>>56-00-000 Civil Construction 
    Machineries & Plants</option>
    <option value="57" <? if($s=='57') echo 'selected';?>>57-00-000 Earth Excavation 
    Equipment</option>
    <option value="58" <? if($s=='58') echo 'selected';?>>58-00-000 Road Construction 
    Macheniries & Plants</option>
    <option value="59" <? if($s=='59') echo 'selected';?>>59-00-000 Material Handling 
    Machineries</option>
    <option value="60" <? if($s=='60') echo 'selected';?>>60-00-000 Pipeline Contruction 
    Machineries</option>
    <option value="61" <? if($s=='61') echo 'selected';?>>61-00-000 Testing Equipments</option>
    <option value="62" <? if($s=='62') echo 'selected';?>>62-00-000 Elecrical 
    Instrumental Tools</option>
    <option value="63" <? if($s=='63') echo 'selected';?>>63-00-000 Instrument 
    Erection Equipment</option>
    <option value="64" <? if($s=='64') echo 'selected';?>>64-00-000 Survey Equipments</option>
    <option value="65" <? if($s=='65') echo 'selected';?>>65-00-000 Piling Equipments</option>
    <option value="66" <? if($s=='66') echo 'selected';?>>66-00-000 Office Equipment</option>
    <option value="69" <? if($s=='69') echo 'selected';?>>69-00-000 MISCULLINEOUS 
    EQUIPMENT</option>
    <option value="70" <? if($s=='70') echo 'selected';?>>70-00-000 Indirect Labour</option>
    <option value="71" <? if($s=='71') echo 'selected';?>>71-00-000 Indirect Labour</option>	
    <option value="72" <? if($s=='72') echo 'selected';?>>72-00-000 Indirect Labour</option>
    <option value="73" <? if($s=='73') echo 'selected';?>>73-00-000 Indirect Labour</option>	
    <option value="74" <? if($s=='74') echo 'selected';?>>74-00-000 Indirect Labour</option>
    <option value="75" <? if($s=='75') echo 'selected';?>>75-00-000 Indirect Labour</option>	
    <option value="76" <? if($s=='76') echo 'selected';?>>76-00-000 Indirect Labour</option>
    <option value="77" <? if($s=='77') echo 'selected';?>>77-00-000 Indirect Labour</option>	
    <option value="78" <? if($s=='78') echo 'selected';?>>78-00-000 Indirect Labour</option>
    <option value="79" <? if($s=='79') echo 'selected';?>>79-00-000 Indirect Labour</option>	
    <option value="80" <? if($s=='80') echo 'selected';?>>80-00-000 Indirect Labour</option>
    <option value="81" <? if($s=='81') echo 'selected';?>>81-00-000 Indirect Labour</option>
    <option value="82" <? if($s=='82') echo 'selected';?>>82-00-000 Indirect Labour</option>
    <option value="83" <? if($s=='83') echo 'selected';?>>83-00-000 Indirect Labour</option>
    <option value="84" <? if($s=='84') echo 'selected';?>>84-00-000 Indirect Labour</option>
    <option value="85" <? if($s=='85') echo 'selected';?>>85-00-000 Indirect Labour</option>
    <option value="86" <? if($s=='86') echo 'selected';?>>86-00-000 Direct Labour</option>
    <option value="87" <? if($s=='87') echo 'selected';?>>87-00-000 Direct Labour</option>
    <option value="88" <? if($s=='88') echo 'selected';?>>88-00-000 Direct Labour Skilled Monthly Basis</option>
    <option value="89" <? if($s=='89') echo 'selected';?>>89-00-000 Direct Labour Semi Skilled Monthly Basis</option>
    <option value="90" <? if($s=='90') echo 'selected';?>>90-00-000 Direct Labour Skilled Daily Basis</option>
    <option value="91" <? if($s=='91') echo 'selected';?>>91-00-000 Direct Labour Unskilled Daily Basis</option>
    <option value="92" <? if($s=='92') echo 'selected';?>>92-00-000 Direct Labour Semi Skilled Daily Basis</option>
    <option value="93" <? if($s=='93') echo 'selected';?>>93-00-000 Direct Labour</option>
    <option value="94" <? if($s=='94') echo 'selected';?>>94-00-000 Direct Labour</option>
    <option value="95" <? if($s=='95') echo 'selected';?>>95-00-000 Sub Contructor Civil Works</option>
    <option value="96" <? if($s=='96') echo 'selected';?>>96-00-000 Sub Contructor Mechanical Works</option>
    <option value="97" <? if($s=='97') echo 'selected';?>>97-00-000 Sub Contructor Electrical Works</option>
    <option value="98" <? if($s=='98') echo 'selected';?>>98-00-000 Finished Goods(Invoice Items)</option>
    <option value="99" <? if($s=='99') echo 'selected';?>>99-00-000 Sub Contructor Others</option>
  </select>
	
</form>
















<br>
<? if($s){?>
<table border="0" align="center" width="95%" cellpadding="0" cellspacing="3" bordercolor="#E4E4E4" style="border-collapse:collapse">
<!-- <tr>
    <td colspan="6" height="50"><b> Item Group : <? echo itemGroup($s);?></b></td>
</tr>
 --><tr bgcolor="#E4E4E4" ><td height="30" width="100">CODE</td>
<td>ITEM DESCRIPTION</td>
<td>ITEM CAPACITY/OUTPUT</td>
<td>Acure At</td>
<? if($s>=49 && $s<=69){ ?>
	<td>Fuel &amp; Measurement Unit</td>
<?php } ?>
<td>UNIT</td>
<td align="center" >ACTION</td></tr>
<? include("./config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
//if($s>=70) {$s=$s/10;}
 $sqlitem = "SELECT * FROM `itemlist` WHERE itemCode LIKE '$s%' ORDER by itemCode ASC";
//echo $sqlitem;
$sqlrunItem= mysqli_query($db, $sqlitem);
$i=1;
while($result=mysqli_fetch_array($sqlrunItem)){
if($i%2==0)echo "<tr bgcolor=#EFEFEF>";
else echo "<tr>";?>
<td align="center"><? echo $result[itemCode];?></td>
<td><? echo $result[itemDes];?></td>
<td><? echo $result[itemSpec];?></td>	
	<? if($s>=49 && $s<=69){
	echo "<td>";
	echo "".eqconsumsionFuelRowData($result[itemCode],true,true);
	echo "</td>	";
} ?>
	
<td align="center"><? echo $result[resourceType];?></td>
<td align="center"><? echo $result[itemUnit];?></td>
<? echo "<td align=center><a href='./index.php?keyword=rate+Item+type&e=1&s=$s&itemCode=$result[itemCode]'>Edit</a>";?>
|| <a href='#' onClick="if (confirm('Do you want to delete Item Code <? echo $result[itemCode]?> ?')) location.href='./index.php?keyword=rate+Item&d=1<? echo "&s=$s&itemCode=$result[itemCode]";?>'" >Delete</a>
<? //if($s>=35 AND $s<=50) echo "|| <a href='./index.php?keyword=tool+rate&itemCode=$result[itemCode]'>Rate</a>";
?>
<? echo "</td></tr>";
$i++;}?>
</table>
<? }?>
<?
/* Account Information*/
$allItemClass=array('Stock Item','Non Stock Item','Current Asset','Fixed Asset','Wages','Salary');

class itemCode{
	public function __construct($itemCode){
		$this->itemCode=$itemCode;
	}
	public function split(){
		$itemArray=explode("-",$this->itemCode);
		return array($itemArray[0],$itemArray[1],$itemArray[2]);
	}
	// public function first(){
		
	// 	return $this->split()[0];
	// }
	// public function second(){
	// 	return $this->split()[1];
	// }
	// public function third(){
	// 	return $this->split()[2];
	// }
	// public function full(){
	// 	return $this->itemCode;
	// }

	
	// public function first(){

	// 	return $this->split()[0];
	// }
	// public function second(){
	// 	return $this->split()[1];
	// }
	// public function third(){
	// 	return $this->split()[2];
	// }
	// public function full(){
	// 	return $this->itemCode;
	// }
}
$ic=new itemCode($itemCode);
?>

<? if($newItem){
include("./config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$itemCode="$itemCode1-$itemCode2-$itemCode3";
$sqlitem = "INSERT INTO `itemlist` (itemCode, itemDes, itemSpec, itemUnit, iowSales,GLsit,GLsales,GLinventory, GLcost,itemType)".
 "VALUES ('$itemCode', '$itemDes', '$itemSpec', '$itemUnit', '$iowSales','$GLsit','$GLsales', '$GLinventory', '$GLcost','$itemClass')";
// echo  $sqlitem;
$sqlrunItem= mysqli_query($db, $sqlitem);

if($s>=35 AND $s<50){
	$sql="INSERT INTO toolrate (id,itemCode,averageValue,salvageValue,life) Values ('','$itemCode','','10','6')";
	echo $sql;
	$sqlrunItem1= mysqli_query($db, $sql);
}

if($s>=70 AND $s<98){
if($itemCode1=='74') $level='Level 3';
elseif($itemCode1=='76' AND $itemCode1<='78') $level='Level 4';
elseif($itemCode1=='79'AND $itemCode1<='80') $level='Level 5';
elseif($itemCode1>='81' AND $itemCode1<='85') $level='Level 6';
elseif($itemCode1>='86' AND $itemCode1<='90') $level='Level 7';
elseif($itemCode1>='90' AND $itemCode1<='98') $level='Level 8';
	{$sql="INSERT INTO jobdetails (id,itemCode,jobTitle,level) Values ('','$itemCode','$itemDes','$level')";
	//echo '<br>'.$sql;
	$sqlrunItem1= mysqli_query($db, $sql);
	}
 }
}?>
<? if($updateItem){
include("./config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
	$itemCode="$itemCode1-$itemCode2-$itemCode3";	
	$itemCodef="$itemCode1-$itemCode2-";	
    echo $sqlitem = "UPDATE `itemlist` SET itemCode='$itemCode', itemDes='$itemDes', itemSpec='$itemSpec', itemUnit='$itemUnit', GLsit='$GLsit',GLsales='$GLsales',GLinventory='$GLinventory',GLcost='$GLcost',itemType='$itemClass' WHERE (itemCode='$itemCodef' OR itemCode='$itemCode')";
//echo $sqlitem;
$sqlrunItem= mysqli_query($db, $sqlitem);

if($s>=35 AND $s<50){
$sqlitemtool = "UPDATE `toolrate` SET salvageValue='$salvageValue',life='$life' WHERE itemCode='$itemCode'";
//echo $sqlitemtool;
$sqlrunItemtool= mysqli_query($db, $sqlitemtool);
$sql="INSERT INTO toolrate (id,itemCode,averageValue,salvageValue,life) Values ('','$itemCode','','10','6')";
//	echo $sql;
	$sqlrunItem1= mysqli_query($db, $sql);
 }
}






if($newItem || $updateItem){
		$lo=$_POST["n"];
		$mUnit=$_POST["mUnit"];
// 	delete previous fuel & oil & lubricants
		mysqli_query($db,"delete from eqconsumsiontemp where eqitemCode='$itemCode'");
// 	delete previous fuel & oil & lubricants end

		$sqle="insert into eqconsumsiontemp (eqitemCode, uitemCode, measureUnit, consumption, consumptionUnit) values ";
	// consumable part

		if($lo)
			foreach($lo as $slo){
				$des=itemDes($slo);
				$conUnit=$des[unit];
				$conFuel=$_POST["CON_".$slo];
				$sqleq[]="('$itemCode','$slo','$mUnit','$conFuel','$conUnit')";
			}

		$Petrol=$_POST["11-02-101"];
		$conFuel=$_POST["fuel_con_11-02-101"];
		$des=itemDes('11-02-101');
		$conUnit=$des[unit];
		if($Petrol)$sqleq[]="('$itemCode','11-02-101','$mUnit','$conFuel','$conUnit')";

				$des=itemDes('11-02-050');
				$conUnit=$des[unit];
		$conFuel=$_POST["fuel_con_11-02-050"];
		$Octane=$_POST["11-02-050"];
		if($Octane)$sqleq[]="('$itemCode','11-02-050','$mUnit','$conFuel','$conUnit')";

				$des=itemDes('13-07-050');
				$conUnit=$des[unit];
		$conFuel=$_POST["fuel_con_13-07-050"];
		$Cng=$_POST["13-07-050"];
		if($Cng)$sqleq[]="('$itemCode','13-07-050','$mUnit','$conFuel','$conUnit')";

				$des=itemDes('11-02-025');
				$conUnit=$des[unit];
		$conFuel=$_POST["fuel_con_11-02-025"];
		$Diesel=$_POST["11-02-025"];
		if($Diesel)$sqleq[]="('$itemCode','11-02-025','$mUnit','$conFuel','$conUnit')";
	
// 		echo $sqle.implode(",",$sqleq);
// 	exit;
		mysqli_query($db,$sqle.implode(",",$sqleq));
	// end of consumable part

}



?>




<?php
$list=departmentList();
?>
<form name="itm" action="#" method="post">
  <select name="items" size="1" 
onChange="location.href='index.php?keyword=rate+Item&s='+itm.items.options[document.itm.items.selectedIndex].value";>
    <option value="">Select One Group</option>		
	
		<?php	if($loginDesignation!="Equipment Co-ordinator"){ ?>
		
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
		<?php } ?>
		
		<?php	if($loginDesignation=="Equipment Co-ordinator" || 1==1){ ?>
    <option value="50" <? if($s=='50') echo 'selected';?>>50-00-000 Cutting,Drilling 
    & Grinding Equipment </option>
    <option value="51" <? if($s=='51') echo 'selected';?>>51-00-000 Power Equipment</option>
    <option value="52" <? if($s=='52') echo 'selected';?>>52-00-000 Welding Equipments</option>
    <option value="53" <? if($s=='53') echo 'selected';?>>53-00-000 Bulldozer Vehicles</option>
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
		<?php } //Equipment Co-ordinator  ?>
		
		
		
		<?php	if($loginDesignation!="Equipment Co-ordinator"){ ?>
		<?php
		$dpmList=departmentList();
		foreach($dpmList as $key=>$dpm){
			echo "<option value=\"$key\" ";
			if($s==$key) echo 'selected';
			echo ">$dpm[code] $dpm[designation]</option>";
		}
		?>    
    <option value="86" <? if($s=='86') echo 'selected';?>>86-00 Direct Labour Semi-Skilled(Civil)</option>
    <option value="87" <? if($s=='87') echo 'selected';?>>87-00 Direct Labour High Skilled(Mechanical & Electrical)</option>
    <option value="88" <? if($s=='88') echo 'selected';?>>88-00 Direct Labour Skilled(Mechanical & Electrical)</option>
    <option value="89" <? if($s=='89') echo 'selected';?>>89-00 Direct Labour Semi-Skilled(Mechanical & Electrical)</option>
    <option value="90" <? if($s=='90') echo 'selected';?>>90-00 Direct Labour High Skilled(Equipment & Machine Operator)</option>
    <option value="91" <? if($s=='91') echo 'selected';?>>91-00 Direct Labour Skilled(Equipment & Machine Operator)</option>
    <option value="92" <? if($s=='92') echo 'selected';?>>92-00 Direct Labour Semi-Skilled(Equipment & Machine Operator)</option>
    <option value="93" <? if($s=='93') echo 'selected';?>>93-00 Direct Labour</option>
    <option value="94" <? if($s=='94') echo 'selected';?>>94-00 Direct Labour</option>
    <option value="95" <? if($s=='95') echo 'selected';?>>95-00 Sub Contructor Civil Works</option>
    <option value="96" <? if($s=='96') echo 'selected';?>>96-00 Sub Contructor Mechanical Works</option>
    <option value="97" <? if($s=='97') echo 'selected';?>>97-00 Sub Contructor Electrical Works</option>
    <option value="98" <? if($s=='98') echo 'selected';?>>98-00 Finished Goods(Invoice Items)</option>
    <option value="99" <? if($s=='99') echo 'selected';?>>99-00 Sub Contructor Others</option>
			
		<?php	} ?>
  </select>
	
</form>
















<br>
<?php
if(($s>=01 && $s<=69) || $s==99){
	$des="Item Description";
	$cap="Item Capacity/Output";
	$style="style='display:none'";
}else{
	$des="Designation";
	$cap="Department";
	$style="";	
}


// if($d==1){
// $sqld="DELETE from itemlist where itemCode='$itemCode' ";
// //echo $sqld;
// $sqlrunItemd= mysqli_query($db, $sqld);
// }
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
<form name="newItem" action="./index.php?keyword=rate+Item" method="post">
<table border="1" align="center" width="800" cellpadding="0" cellspacing="0" bordercolor="#E4E4E4" style="border-collapse:collapse">
<tr><td colspan="2" bgcolor="#EEEEEE" align="center"><b><? if($e==1) echo "Edit Item"; else echo "Enter New Item";?></b></td></tr>
	
<tr><td>Item Code</td> <td><? $temp=explode('-',$sqlrun[itemCode]);?>
	<input name="itemCode1" onKeyUp="return autoTab(this, 2, event);" size="3" maxlength="2" value="<? echo $s;?>" readonly=""> - 
    <input name="itemCode2" onKeyUp="return autoTab(this, 2, event);" size="3" maxlength="2" value="<? echo $temp[1]?>"> - 
    <input name="itemCode3" onKeyUp="return autoTab(this, 3, event);" size="4" maxlength="3" value="<? echo $temp[2] ? $temp[2] : '000';?>" <?php echo ($s>=50 && $s<=69) ? "readonly" : ""; ?> >
</td></tr>
	
<tr><td>Item Description</td> <td><input type="text" name="itemDes" size="40" value="<? echo $sqlrun[itemDes];?>"></td></tr>
<tr><td>Item Capacity/Output</td> <td><input type="text" name="itemSpec" value="<? echo $sqlrun[itemSpec];?>"></td></tr>
<tr><td>Item Unit</td> <td><input type="text" name="itemUnit" value="<? echo $sqlrun[itemUnit];?>"></td></tr>
<!-- <tr><td>Item Class</td><td> <select name="itemClass">
        <option <? if($sqlrun[itemType]=='Stock Item') echo " SELECTED"; ?> >Stock Item</option>
        <option <? if($sqlrun[itemType]=='Non-stock Item') echo " SELECTED"; ?>>Non-stock Item</option>  
        <option <? if($sqlrun[itemType]=='Asset Item') echo " selected "; ?>>Asset Item</option>  
        <option <? if($sqlrun[itemType]=='Service') echo " SELECTED"; ?>>Service</option>  
        <option <? if($sqlrun[itemType]=='Labor') echo " SELECTED"; ?>>Labor</option>  
        <option <? if($sqlrun[itemType]=='Assembly') echo " SELECTED"; ?>>Assembly</option>  
        <option <? if($sqlrun[itemType]=='Activity item') echo " SELECTED"; ?>>Activity item</option>  
        <option <? if($sqlrun[itemType]=='Charge item') echo " SELECTED"; ?>>Charge item</option>  
      </select></td>
 </tr>
 -->
	
	



<?php 
if($s>=49 && $s<=69){ ?>
<!-- 	new option for equipment  -->
	
	<?php
// 		get consumation row
			$q=eqconsumsionFuelRow($ic->full());
			while($row=mysqli_fetch_array($q)){
				$ConsumRows[]=$row["uitemCode"];
				$mUnit=$row["measureUnit"];
			}
// 		end of get consumation row
?>
	
			<tr>
				<td>Fuel</td>
				<td>
					<table border=0>
						
					<?php
					$allFuel=item2itemCode4Eq(null,null,null,1);
					if($ConsumRows)$locked=true;
					else $locked=false;
	
	$locked=false;
	
					if($allFuel)
						foreach($allFuel as $itemCode=>$fuel){

							if($itemCode && $ConsumRows)
								$extra=in_array($itemCode,$ConsumRows)>0 ? " checked " : "";
							else
								$extra="";
							
							
							
							$consumision=getFuelConsumsionRowAssigned($ic->full(),$itemCode);
							$consumisionTemp=getFuelConsumsionRowAssigned($ic->full(),$itemCode,true);
							$consumisionTempRow="";
							if($consumisionTemp)$consumisionTempRow=" <i>($consumisionTemp[consumption] $consumisionTemp[consumptionUnit]/$consumisionTemp[measureUnit])</i>";
							


							$fuelItemCollection[]="'$itemCode'";
							$fuelItemCollectionDes[$itemCode]=itemCode2Des($itemCode);
							$conUnit=itemCode2Unit($itemCode);
							
							if(!$locked){
								echo "<tr><td><input type='checkbox' name='$itemCode' value=1 $extra > $fuel </td><td><input align=right type='text' name='fuel_con_$itemCode' value='$consumision[consumption]'></td><td>$conUnit/<span class='measureUnitTxt'>$mUnit</span>$consumisionTempRow</td></tr>";
							}else{
								echo "<tr><td><input type='hidden' name='$itemCode' value=1 $extra > $fuel</td><td></td><td>$conUnit/<span class='measureUnitTxt'>$mUnit</span>$consumisionTempRow</td></tr>";
							}
						}
					?>
					</table>
					</td>
			</tr>	
	
	

			<tr>
				<td>Lubricants &amp; Oil</td>
				<td style="">
						<ol id="itemContainer" style="padding: 0; list-style: none; margin: 0; margin-bottom: 5px; cursor:no-drop;">
						</ol>
					<select id="oil">
						<option value=""></option>
						<?php allMatItemCode(true); ?>
					</select>
				</td>
			</tr>	
			<script>
				$(document).ready(function(){
					var itemContainer=$("#itemContainer");
					function changeOL(item){
						var dsc=item.find("option[value='"+item.val()+"']");
						dsc.hide();
						itemContainer.append("<li ondblclick='this.remove()' style='height: 21px;'>"+dsc.html()+"<input type='hidden' value='"+item.val()+"' name='n[]'><span style='float:right'><input type='text' name='lo_con_"+item.val()+"' placeholder=''>"+dsc.attr("unit")+"/<span id='measureUnitTxt'><?php echo $mUnit; ?></span></span></li>");
						item.val("");
					}
					var oil;
<?php
	$eqOilData=eqconsumsionOilData($ic->full(),true,true);
	
	if(!$locked)$clickFn='this.remove()';
	else $clickFn='';

			if($eqOilData)
				foreach($eqOilData as $eqOilSdata)
					foreach($eqOilSdata as $itemCodeFuel=>$fuelItem){
						
							$consumision=getFuelConsumsionRowAssigned($ic->full(),$itemCodeFuel);
							$consumisionTemp=getFuelConsumsionRowAssigned($ic->full(),$itemCodeFuel,true);
							$consumisionTempRow="";
							if($consumisionTemp)$consumisionTempRow=" <i>($consumisionTemp[consumption] $consumisionTemp[consumptionUnit]/$consumisionTemp[measureUnit])</i>";
							
						echo 'itemContainer.append("<li onClick=\'$clickFn\'>'.$itemCodeFuel." ".$fuelItem[0].'<input type=\'hidden\' value=\''.$itemCodeFuel.'\' name=\'n[]\'><span style=\'float:right\'><input type=\'text\' name=\'CON_'.$itemCodeFuel.'\' placeholder=\'\' value=\''.$consumision[consumption].'\'> '.$fuelItem[1].'/<span id=\'measureUnitTxt\'>'.$mUnit.'</span></span>'.$consumisionTempRow.'</li>");';
						echo '$("#oil").find("option[value=\''.$itemCodeFuel.'\']").hide();';
					}
					?>
					var selectedUnit=$("#selectedUnit");
					var allUnit={<?php echo allUnitJsObj();?>};
					selectedUnit.html(allUnit["km"]);
					
					$("#oil").change(function(){
						var item=$(this);
						changeOL(item);
					});
					
					$("#itemCodeSelect").change(function(){
						var item=$(this);
						window.location.href="./index.php?keyword=equipment+entry&itemCodeSelect="+item.val();
					});
					var startup_reading=$("#startup_reading");
					var startup_reading_row=$("#startup_reading_row");
					$("#mUnit").change(function(){
						var mUnit=$(this);
						if(mUnit.val()=="ue"){
							startup_reading_row.hide();
						}else{
							startup_reading_row.show();
							selectedUnit.html(allUnit[mUnit.val()]);
						}
					});
				});
			</script>
			<style>
				#itemContainer li{border:1px solid #ccc;transition:all .5s linear;    min-height: 20px;
    padding: 2px;}
				#itemContainer li:hover{border:1px solid #00f;}
			</style>
			
			<tr>
				<td>Work measurement unit</td>
				<td>
					<?php	
						$allMunit=measuerUnti();
					?>
					<select name="mUnit" id="mUnit" >
					<?php
						foreach(measuerUnti() as $val=>$mUnits){
							echo "<option value='$val'";
							echo ($mUnit==$val && $mUnit) ? " selected " : ($mUnit ? ' disabled ' : '');
							echo ">$mUnits</option>";
						}
					?>
					</select>
				</td>
			</tr>
	
	
	
<?php } // ?>
	
	
	
	
	
	
	
	
	

<!-- <tr><td>Item Class</td> <td><input type="text" name="GLsit"  value="<? echo $itemClass;?>" readonly size="40" ></td></tr> -->
<? 
$iowSales=$sqlrun[iowSales];
$GLsit=$sqlrun[GLsit];
$GLinventory=$sqlrun[GLinventory];
$GLcost=$sqlrun[GLcost];
$GLsales=$sqlrun[GLsales];
?>
<tr><td>GL IOW Sales</td> <td><input type="text" name="iowSales"  value="<? echo $iowSales;?>" readonly> <? echo accountName($iowSales);?></td></tr>
<tr><td>GL STORE in TRASIT</td> <td><input type="text" name="GLsit"  value="<? echo $GLsit;?>" readonly> <? echo accountName($GLsit);?></td></tr>
<tr><td>GL Inventory Acct</td> <td><input type="text" name="GLinventory"  value="<? echo $GLinventory;?>" readonly> <? echo accountName($GLinventory);?></td></tr>
<tr><td>GL Cost of Sales Acct</td> <td><input type="text" name="GLcost"  value="<? echo $GLcost;?>" readonly > <? echo accountName($GLcost);?></td></tr>
<tr><td>GL Sales Acct</td> <td><input type="text" name="GLsales"  value="<? echo $GLsales;?>" readonly> <? echo accountName($GLsales);?></td></tr>
<? if($s>=35 AND $s<50){?>
<tr><td>Salvage Value</td> <td><input type="text" name="salvageValue" value="<? echo $sqlrun[salvageValue]?>" size="5"> %</td></tr>
<tr><td>Life</td> <td><input type="text" name="life" value="<? echo $sqlrun[life]?>" size="5"> months (effective use is estimated 4 hours/day)</td></tr>
<? }?>
<tr>
      <td colspan="2" align="center"> 
        <? if($e==1) {?>
        <input type="submit" name="updateItem" value="Update">
        <? } else {?>
        <input type="submit" name="newItem" value="Enter"><? }?>
   </td>
</tr>
</table>
	

	

	





	
<input type="hidden" name="s" value="<? echo $s;?>">
</form>
	<? }?>
<? if($s){?>
<table border="0" align="center" width="95%" cellpadding="0" cellspacing="3" bordercolor="#E4E4E4" style="border-collapse:collapse">
<!-- <tr>
    <td colspan="6" height="50"><b> Item Group : <? echo itemGroup($s);?></b></td>
</tr>
 -->
	

<?php
if(($s>=01 && $s<=69) || $s==99){
?>
	<tr bgcolor="#E4E4E4" ><td height="30" width="100">CODE</td>
<td>ITEM DESCRIPTION</td>
<td>ITEM CAPACITY/OUTPUT</td>
<? if($s>=49 && $s<=69){ ?>
	<td>Fuel &amp; Measurement Unit</td>
<?php } ?>
<td>UNIT</td>
<td align="center" >ACTION</td></tr>
<?php } 

else{
?>
<tr bgcolor="#E4E4E4" >
	<td height="30" width="100">CODE</td>
	<td>Designation</td>
	<td>Department</td>
	<td align="center" >ACTION</td>
</tr>
<?php } ?>

	
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
<?php
if(($s>=01 && $s<=69) || $s==99){
?>	
<td align="center"><? echo $result[itemUnit];?></td>
<?php } ?>
<? echo "<td align=center><a href='./index.php?keyword=rate+Item&e=1&s=$s&itemCode=$result[itemCode]'>Edit</a>";?>
|| <a href='#' onClick="if (confirm('Do you want to delete Item Code <? echo $result[itemCode]?> ?')) location.href='./index.php?keyword=rate+Item&d=1<? echo "&s=$s&itemCode=$result[itemCode]";?>'" >Delete</a>
<? //if($s>=35 AND $s<=50) echo "|| <a href='./index.php?keyword=tool+rate&itemCode=$result[itemCode]'>Rate</a>";
?>
<? echo "</td></tr>";
$i++;}?>
</table>
<? }?>
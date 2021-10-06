<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
<? 
include("./includes/config.inc.php");
$eqid= $_GET['eqid'];
error_reporting(0);
if($eqid){
	
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
$sql=@mysqli_query($db, "SELECT * FROM equipment WHERE eqid=$eqid") or die('Please try later!!');
 $eqresult= mysqli_fetch_array($sql);

}

?>
<form name="equipment" onsubmit="return validateForm( this, 0, 1, 0, 0, 15 );" action="./equipment/equipmentSql.php" method="post"> <!--?page=<? echo $page;?>-->
<table align="center" width="600" border="3"  bordercolor="CC9999" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td align="right" valign="top"><font class='englishhead'>equipment entry form</font></td>
</tr>
<tr>
 <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="3">
<? if(!$eqresult[assetId]){?>
<tr><td>Euipment Group</td>
<td>
 <select name="eqGroup" onChange="location.href='index.php?keyword=equipment+entry&eqGroup='+equipment.eqGroup.options[document.equipment.eqGroup.selectedIndex].value";>
  <option value="">Select One</option>
  <option value="50" <? if($eqGroup=="50") echo 'SELECTED';?>>50-Cutting, Drilling & Grinding Equipments</option>
  <option value="51" <? if($eqGroup=="51") echo 'SELECTED';?>>51-Power Equipments</option>  
  <option value="52" <? if($eqGroup=="52") echo 'SELECTED';?>>52-Welding Equipments</option>  
  <option value="54" <? if($eqGroup=="54") echo 'SELECTED';?>>54-Transport Vehicles</option>  
  <option value="55" <? if($eqGroup=="55") echo 'SELECTED';?>>55-Workshop Machineries</option>  
  <option value="56" <? if($eqGroup=="56") echo 'SELECTED';?>>56-Civil Construction Machineries & Plants</option>  
  <option value="57" <? if($eqGroup=="57") echo 'selected';?>>57-00-000 Earth Excavation Equipment</option>    
  <option value="58" <? if($eqGroup=="58") echo 'SELECTED';?>>58-Road Construction Macheniries & Plants</option>    
  <option value="59" <? if($eqGroup=="59") echo 'SELECTED';?>>59-Material Handling Machineries</option>        
  <option value="60" <? if($eqGroup=="60") echo 'SELECTED';?>>60-Pipeline Contruction Machineries</option>    
  <option value="61" <? if($eqGroup=="61") echo 'SELECTED';?>>61-Testing Equippments</option>     
  <option value="62" <? if($eqGroup=="62") echo 'SELECTED';?>>62-Elecric Erection Tools</option>    
  <option value="63" <? if($eqGroup=="63") echo 'SELECTED';?>>63-Instrument Erection Equipment</option>      
  <option value="64" <? if($eqGroup=="64") echo 'SELECTED';?>>64-Survey Equipments</option>    
  <option value="65" <? if($eqGroup=="65") echo 'SELECTED';?>>65-Piling Equipments</option> 
  <option value="66" <? if($eqGroup=="66") echo 'SELECTED';?>>66-Office Equipments</option> 
  <option value="69" <? if($eqGroup=="69") echo 'SELECTED';?>>69-Miscullineous Equipments</option>   
 </select>
</td>	
</tr>
<? }?>
<? 
//$temp=itemDes($eqresult[itemCode]);  //stop by salma
 $q1="select itemDes,itemSpec from itemlist where itemCode='".$eqresult[itemCode]."'";
$r1=mysqli_query($db, $q1);
if($r1)
{

while($row=mysqli_fetch_array($r1))
{
	$itemDes=$row['itemDes'];
	$itemSpec=$row['itemSpec'];
}
}

if($eqresult[assetId]){
echo '<tr bgcolor=#FFEEEE><td>Item Code, Description:</td><td><b>'.$eqresult[itemCode]."</b>: ".$itemDes.', '.$itemSpec.'</td></tr>';
	echo '<tr><td>AssetId</td><td>'.$eqid.'</td></tr>';

//if($eqresult[assetId]){ echo '<tr><td>AssetId</td><td>'.eqpId($eqresult[assetId],$eqresult[itemCode]).'</td></tr>';
//echo '<tr bgcolor=#FFEEEE><td>Description:</td><td>'.$temp[des].', '.$temp[spc].'</td></tr>';
}

else {
echo '<tr bgcolor=#FFEEEE><td>Item Code</td><td>';
include("../config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT itemCode,itemDes,itemSpec from `itemlist` WHERE itemCode LIKE '$eqGroup-%'";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp) or die();

$plist= "<select name='itemCode'> ";
$plist.= "<option value='0'>Select One</option> ";
 while($typel= mysqli_fetch_array($sqlrunp))
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
			
// 			readonly all field
			$qt=1;
			
?>
<tr>
   <td>Model</td>
   <td ><input type="text" name="model" value="<? echo $model;?>" size="50" <? if($r || $qt) echo 'readonly';?>></td>
</tr>
<tr bgcolor="#FFEEEE">
   <td>Brand</td>
   <td ><input type="text" name="brand" value="<? echo $brand;?>" size="50" <? if($r || $qt) echo 'readonly';?>></td>
</tr>
<tr>
   <td>Manufactured by</td>
   <td ><input type="text" name="manuby" value="<? echo $manuby;?>"  size="50" <? if($r || $qt) echo 'readonly';?>></td>
</tr>
<tr bgcolor="#FFEEEE">
   <td>Made in</td>
   <td ><input type="text" name="madein" value="<? echo $madein;?>"  size="50" <? if($r || $qt) echo 'readonly';?>></td>
</tr>
<tr>
   <td>Specification</td>
   <td ><input type="text" name="speci" value="<? echo $speci;?>"  size="50" <? if($r || $qt) echo 'readonly';?>></td>
</tr>
<tr bgcolor="#FFEEEE">
   <td>Design Capacity</td>
   <td ><input type="text" name="designCap" value="<? echo $designCap;?>"  size="50" <? if($r || $qt) echo 'readonly';?>></td>
</tr>
<tr>
   <td>Current Capacity</td>
   <td ><input type="text" name="currentCap" value="<? echo $currentCap;?>"  size="50" <? if($r || $qt) echo 'readonly';?>></td>
</tr>
<tr bgcolor="#FFEEEE">
   <td>Year of Manufacture</td>
   <td ><input type="text" name="yearManu" value="<? echo $yearManu;?>" <? if($r || $qt) echo 'readonly';?>></td>
</tr>
			
			
			
<tr >
   <td>Condition when purchased</td>
   <td ><select name="condition" size="1" <? if($r || $qt) echo 'disabled'; ?> >
         <option value="5">New</option>
         <option value="6">Re-conditioned</option>		 
         <option value="1">Used, Running Condition</option>
<!--          <option value="2">Under Periodic Maintenence</option>
         <option value="3">Under Breakdown Maintenence</option>
         <option value="4">Unrepairable</option>		 		 		  -->
   </select></td>
</tr>
			
			
<tr>
   <td><label for="mnfPro">Date of Procurement</label></td>
      <td><input type="text" maxlength="10" name="mnfPro" value="<? echo date("j/m/Y",strtotime($eqresult[mnfPro]));?>" alt="date|dd/mm/yyyy" emsg="<br>Enter Date of Procument" <? if($r || $qt) echo 'readonly';?>>
<!-- 	  <a id="anchor" href="#"
   onClick="cal.select(document.forms['equipment'].mnfPro,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a>  -->
      </td> 
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
<tr bgcolor="#FFEEEE">
   <td>Purchase Reference</td>
   <td ><input type="text" size="50" name="reference" value="<? echo $eqresult[reference];?>" <? if($r) echo 'readonly';?>></td>
</tr>
			
			
			
			<!-- 	new option for equipment  -->
			<tr>
				<td>Fuel</td>
				<td>
					<?php
					$allFuel=item2itemCode4Eq(null,null,null,1);
					foreach($allFuel as $itemCode=>$fuel){
						echo "<input type='checkbox' name='$itemCode' value=1> $fuel";
					}
					?>
					</td>
			</tr>			
			
			<tr>
				<td>Lubricants &amp; Oil</td>
				<td style="">
						<ol id="itemContainer" style="    padding: 0;
    list-style: none;
    margin: 0;
    margin-bottom: 5px; cursor:no-drop;">
						</ol>
					<select id="oil">
						<?php allMatItemCode(); ?>
					</select>
				</td>
			</tr>	
			<script>
				$(document).ready(function(){
					var itemContainer=$("#itemContainer");
					$("#oil").change(function(){
						var item=$(this);
						var dsc=item.find("option[value='"+item.val()+"']").html();
						itemContainer.append("<li onClick='this.remove()'>"+dsc+"<input type='hidden' value='"+item.val()+"' name='n[]'></li>");
					});
				});
			</script>
			<style>
				#itemContainer li{border:1px solid #ccc;transition:all .5s linear;}
				#itemContainer li:hover{border:1px solid #00f;}
			</style>
			
			<tr>
				<td>Consumables</td>
				<td><?php ?></td>
			</tr>
			
			<tr>
				<td></td>
				<td><?php ?></td>
			</tr>			
			
			<tr>
				<td>Work measurement unit</td>
				<td><select name="mUnit">
					<?php
					$allMunit=measuerUnti();
					foreach(measuerUnti() as $mUnit)
						echo "<option value='$mUnit'>$mUnit</option>";
					
					?>
					</select>
					<?php ?></td>
			</tr>			
			
			<tr>
				<td>Startup reading</td>
				<td><?php ?></td>
			</tr>
			
			
			
			
			
			
			
<tr >
	<td >Current Location</td>
	<td><input type="hidden" name="currentLocation" value="004">004
	<? //$ex=0; echo selectPlist("currentLocation",$ex,$eqresult[location])?>	</td>
</tr>
<tr >
	<td >Current price</td>
		<td>
		
		
		<?php

$price=$eqresult[price];
$purchase_date=$eqresult[mnfPro];
$life=$eqresult[life]*365;
$salvage_value=$eqresult[salvageValue];

$per_day_rate=($price-$salvage_value)/$life;

$total_time_y=date("Y",strtotime($purchase_date))+$eqresult[life];
$total_time_md=date("m-d",strtotime($purchase_date));

$total_time= $total_time_y."-".$total_time_md;

$today1=strtotime(date("Y-m-d"));

$different1=abs(strtotime($total_time)-$today1);

$final=$different1/86400;

$now_the_value=$final*$per_day_rate;

if($total_time>date("Y-m-d"))
echo number_format($now_the_value,2)." Taka";
else
echo number_format($salvage_value,2)." Taka"; 
?>
</td>
</tr>

			<?php if($per_day_rate>0){ ?>
			<tr>
				<td>Perday rate</td>
				<td><?php echo round($per_day_rate,2); ?> Taka</td>
			</tr>
			<?php } ?>
			
			

			
			


<tr><td colspan="2" align="center" ><?  if($r || 1==1)/* all time accepted*/ { ?><input type="submit" name="save" value="Save" class="store"   ><?php } ?></td></tr>
	</table>
 </td>
</tr>
</table>
<input type="hidden" name="eqid" value="<? echo $eqid;?>">
</form>
	
<div id=testdiv1
      style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
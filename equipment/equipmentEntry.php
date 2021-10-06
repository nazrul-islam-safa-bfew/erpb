<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
<? 
include("./includes/config.inc.php");
	
$db=mysqli_connect($SESS_DBHOST,$SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

$pdo=new PDO("mysql:host=$SESS_DBHOST;dbname=$SESS_DBNAME",$SESS_DBUSER,$SESS_DBPASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$s=$pdo->prepare("select p.posl,p.itemCode,p.qty,i.itemDes from porder as p, itemlist as i where p.posl like 'EQP_%' and i.itemCode=p.itemCode and p.status=1 order by p.itemCode,p.posl desc");
$s->execute();
$s->setFetchMode(PDO::FETCH_ASSOC);
?>
<form name="equipment" onsubmit="return validateForm( this, 0, 1, 0, 0, 15 );" action="./equipment/equipmentSql.php" method="post"> <!--?page=<? echo $page;?>-->
<table align="center" width="600" border="3"  bordercolor="CC9999" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td align="right" valign="top"><font class='englishhead'>equipment entry form</font></td>
</tr>
<tr>
 <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="3">
		
			
<?php 
echo '<tr bgcolor=#FFEEEE><td>PO</td><td>';
$plist= " <select name='itemCodeSelect' id='itemCodeSelect'> ";
			$plist.= "<option value=''></option>";
foreach($s->fetchAll() as $po){
	$totalReceived=eqReceiveQty($po[posl],$po[itemCode]);
	$currentQty=$po[qty]-$totalReceived;
	
	$remainTxt="";
	if($currentQty>0)$remainTxt=" ($currentQty)";
	else continue;
	
	if($itemCodeSelect=="$po[itemCode]:$po[posl]")$extra=" selected ";
	else $extra="";
	$plist.= "<option value='$po[itemCode]:$po[posl]' $extra>$po[itemCode]: $po[itemDes]$remainTxt $po[posl]</option>";
}	
$plist.= '</select>';
echo $plist.'</td></tr>';
?>
			
<tr>
   <td><label for="mnfPro">Date of Procurement</label></td>
      <td><input type="text" maxlength="10" name="mnfPro" value="<? echo date("j/m/Y",strtotime($eqresult[mnfPro] ? $eqresult[mnfPro] : date("Y-m-d")));?>" alt="date|dd/mm/yyyy" emsg="<br>Enter Date of Procument" <? if($r || $qt) echo 'readonly';?>>
	  <a id="anchor" href="#" onClick="cal.select(document.forms['equipment'].mnfPro,'anchor','dd/MM/yyyy'); return false;" name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a></td> 
</tr>			
			

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


<?
list($itemCode,$posl)=explode(":",$itemCodeSelect);

$qidArray=findQuotation($posl,$itemCode);

$sql="SELECT quotation.*,eqquotation.* FROM quotation,eqquotation
 where quotation.itemCode='$itemCode' AND quotation.qid=eqquotation.qid and quotation.qid='$qidArray'";
// echo $sql;
$quo=$pdo->prepare($sql);
$quo->execute();
$quo->setFetchMode(PDO::FETCH_ASSOC);
$quotation=$quo->fetch();

// if($quotation[rate])
// 	$eqresult[price]=$quotation[rate];

$temp=explode('_',$quotation[teqSpec]);
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

			echo "<input type='hidden' value='$posl' name='posl'><input type='hidden' value='$itemCode' name='itemCode'>";
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
   <td><input type="text" name="madein" value="<? echo $madein;?>"  size="50" <? if($r || $qt) echo 'readonly';?>></td>
</tr>
<tr>
   <td>Specification</td>
   <td><input type="text" name="speci" value="<? echo $speci;?>"  size="50" <? if($r || $qt) echo 'readonly';?>></td>
</tr>
<tr bgcolor="#FFEEEE">
   <td>Design Capacity</td>
   <td ><input type="text" name="designCap" value="<? echo $designCap;?>"  size="50" <? if($r || $qt) echo 'readonly';?>></td>
</tr>
<tr>
   <td>Current Capacity</td>
   <td><input type="text" name="currentCap" value="<? echo $currentCap;?>"  size="50" <? if($r || $qt) echo 'readonly';?>></td>
</tr>
<tr bgcolor="#FFEEEE">
   <td>Year of Manufacture</td>
   <td><input type="text" name="yearManu" value="<? echo $yearManu;?>" <? if($r || $qt) echo 'readonly';?>></td>
</tr>



<tr>
   <td>Condition when purchased</td>
   <td><select name="condition" size="1" <? if($r || $qt) echo 'disabled'; ?> >
         <option value="5">New</option>
         <option value="6">Re-conditioned</option>		 
         <option value="1">Used, Running Condition</option>
<!--     <option value="2">Under Periodic Maintenence</option>
         <option value="3">Under Breakdown Maintenence</option>
         <option value="4">Unrepairable</option>	-->
   </select></td>
</tr>

<tr bgcolor="#FFEEEE">
   <td>Hourly outputs experienced in BFEW</td> 
   <td ><input type="text" size="50" name="exp"value="<? echo $eqresult[exp];?>" <? if($r) echo 'readonly';?>></td>
</tr>

<tr>
   <td><label for="price">Price</label></td> 
   <td ><input type="text" size="20" name="price" value="<? echo $eqresult[price];?>" alt="number|1" emsg="<br>Enter Price" <? if($r || !$r and 1==2) echo 'readonly';?>> Tk.</td>
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
   <td ><input type="text" size="50" name="reference" value="<? echo $eqresult[reference] ? $eqresult[reference] : $posl;?>" <? if($r || !$r) echo 'readonly';?>></td>
</tr>
			
			
			
			<!-- 	new option for equipment  -->
<!-- 			<tr>
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
			 -->
<!-- 			<tr>
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
			</tr>	 -->
			<script>
				$(document).ready(function(){
					
					var selectedUnit=$("#selectedUnit");
					var allUnit={<?php echo allUnitJsObj();	?>};
					selectedUnit.html(allUnit["km"]);
					
					var itemContainer=$("#itemContainer");
					$("#oil").change(function(){
						var item=$(this);
						var dsc=item.find("option[value='"+item.val()+"']").html();
						itemContainer.append("<li onClick='this.remove()'>"+dsc+"<input type='hidden' value='"+item.val()+"' name='n[]'></li>");
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
				#itemContainer li{border:1px solid #ccc;transition:all .5s linear;}
				#itemContainer li:hover{border:1px solid #00f;}
			</style>
			
<!-- 			<tr>
				<td>Consumables</td>
				<td><?php ?></td>
			</tr> -->
			
<!-- 			<tr>
				<td></td>
				<td><?php ?></td>
			</tr>			 -->
			
<!-- 			<tr>
				<td>Work measurement unit</td>
				<td><select name="mUnit" id="mUnit">
					<?php
					$allMunit=measuerUnti();
					foreach(measuerUnti() as $val=>$mUnit)
						echo "<option value='$val'>$mUnit</option>";
					
					?>
					</select>
					<?php ?></td>
			</tr>			 -->
			
			<tr id='startup_reading_row'>
				<td>Startup reading</td>
				<td><input type='' name='startup_reading' id='startup_reading' value='<?php echo $startup_reading; ?>' <?php if($startup_reading)echo " readonly "; ?>> <span id="selectedUnit"></span></td>
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
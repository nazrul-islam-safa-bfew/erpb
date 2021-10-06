<table   width="600" align="center" border="2" bordercolor="#999999" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
<caption>Note: Non cost of sales equipment only.</caption>
 <tr>
   <th colspan=2>
		 <input type="hidden" name="account1" value="6909000">6909000--Vehicle- Octane, Diesal, CNG, Petrol by Meter.</th>
 </tr>
	<tr>
   <td align=right>
			Equipment:
			</td>
	 <td align=left>
		<select style="margin:1px;" name="equipment_fuel" id="equipment_fuel" required>
		<option value=""></option>
<?php
		$sql="select ep.*,i.itemDes,ec.uitemCode from eqconsumsion ec, eqproject ep, itemlist i where ec.eqitemCode=ep.itemCode and ec.measureUnit='km' and ep.itemCode=i.itemCode and ep.pCode='$loginProject' group by ep.itemCode,ep.assetId order by ep.itemCode,ep.assetId asc";
			// echo $sql;
		$q=mysqli_query($db,$sql);
		while($eq_row=mysqli_fetch_array($q)){
			$itemDes=itemCode2Des($eq_row[uitemCode]);
			$EQidFull=eqpId($eq_row[assetId],$eq_row[itemCode]);
			$max_consumption=get_max_consumption($eq_row[assetId],$eq_row[itemCode]);
			echo "<option assetId='$eq_row[assetId]' value='$eq_row[assetId]"."_"."$eq_row[itemCode]"."_"."$eq_row[uitemCode]' max_unit='$max_consumption' max_unit_beauty='".number_format($max_consumption)."' itemCode='$eq_row[itemCode]'>$EQidFull: $eq_row[itemDes]</option>";
		}
		?>
		<?php
	if($loginProject=="000"){
		$sql="select ep.*,i.itemDes,ec.uitemCode,ep.teqSpec from eqconsumsion ec, equipment ep, itemlist i where ec.eqitemCode=ep.itemCode and ec.measureUnit='km' and ep.itemCode=i.itemCode and ep.location='$loginProject' group by ep.itemCode,ep.assetId order by ep.itemCode,ep.assetId asc";
// 			echo $sql;
		$q=mysqli_query($db,$sql);
		while($eq_row=mysqli_fetch_array($q)){
			$itemDes=itemCode2Des($eq_row[uitemCode]);
			$teqSpec=getEquipmentDetailsByRquirement(null,null,6,$eq_row[teqSpec]);
			$max_consumption=get_max_acEqconsumption($eq_row[assetId],$eq_row[itemCode]);
			echo "<option assetId='$eq_row[assetId]' itemCode='$eq_row[itemCode]' value='$eq_row[assetId]"."_"."$eq_row[itemCode]"."_"."$eq_row[uitemCode]' max_unit='$max_consumption' max_unit_beauty='".number_format($max_consumption)."'>$eq_row[itemCode]$eq_row[assetId]: $eq_row[itemDes] ($teqSpec) </option>";
		}
	}
		?>
			</select>
		
	</td>
 </tr>
	
	<tr>
   <td align=right>
			Fuel Type:
			</td>
		<td align=left>
			<select name="fuelType" id="fuelType">
				<?php
				$allFuel=item2itemCode4Eq(null,null,null,true);
				foreach($allFuel as $fuelCode=>$fuel){
					echo "<option value='$fuelCode'>$fuel</option>";
				}
				echo "<option disabled>-----------</option>";
				allMatItemCode(true,false);
				?>
			</select> 
		</td>
	</tr>
	
	<tr id="mKmRow">
   <td align=right>
		Machine Km:
	 </td>
	 <td align=left><input type="number" name="mKm" id="mKm"style="width:100px;text-align: right;"> Km. <i id='change_able_text'>(Must be above 0 km)</i>
	 </td>
 </tr>
	
	<tr>
   <td align=right>
		Fuel Qty:
	 </td>
	 <td align=left> <input type="number" name="fQty" id="fQty" style="width:100px;text-align: right;">
		 Ltr.
	 </td>
	</tr>
 <tr>
   <td align=right>
		 Description:
			</td>
		<td align=left>
			<input type="text" size="30" name="exdes1" value="<? if($expencess) echo ''; else echo $exdes1;?>">
	  </td>
 </tr>
	
	<tr>
   <td align=right>
		Amount:
			</td>
		<td align=left> <input type="number" size="10"  name="examount1" id="examount1" alt="cal"  class="number" onchange="disableSave(this.form);"> Tk.
	 </td>
 </tr>

  <tr>
    <td bgcolor="#FFFFCC" colspan=2>
	<input type="text" readonly="" name="total" id="total" style=" border:0;background: #FFFFCC;text-align:right" id="total">
	</td>
 </tr>
	
  <tr>
    <td colspan="1" align="right">
			<input type="button" value="calculate" name="calculate" id="calculate" onClick="">
			</td><td align=center>
			<input type="button" value="Save" disabled="disabled" name="save"  id="saveBtn" 
	onClick="">
		</td>
		<input type="hidden" name="expencess" value="0">
		<input type="hidden" name="calculate" value="0">
 </tr>
 </table>

<script>
function isRequiredToSubmit(){
	$(document).ready(function(){
	var equipment_fuel=$("#equipment_fuel");
	var mKm=$("#mKm");
	var saveBtn=$("#saveBtn");
	var fQty=$("#fQty");
	var examount1=$("#examount1");
	var total=$("#total");
	var form=$("form");
	var fuelType=$("#fuelType");
	var isLubricantVal;
	var isNotLubricant;
		
		isLubricantVal=$.inArray(fuelType.val(),[<?php echo implode(",",item2itemCode4Eq(null,null,null,null,true)); ?>]);
		if(isLubricantVal===0 || isLubricantVal>0){
			isNotLubricant=true;
		}else{
			isNotLubricant=false;
		}
		
		if(!fuelType.val() || !equipment_fuel.val() || !examount1.val() || !total.val() || total.val()<0 || !fQty.val() || (!mKm.val() && isNotLubricant)){
			alert("Please input all value.");
			return false;
		}
			
		form.submit();
	});
}
$(document).ready(function(){
	var equipment_fuel=$("#equipment_fuel");
	var fuelType=$("#fuelType");
	var isLubricantVal;
	var mKmRow=$("#mKmRow");
	
	
	fuelType.change(function(){
		isLubricantVal=$.inArray(fuelType.val(),[<?php echo implode(",",item2itemCode4Eq(null,null,null,null,true)); ?>]);
		if(isLubricantVal===0 || isLubricantVal>0){
			mKmRow.show();
		}else{
			mKmRow.hide();			
		}
			
  });
	var last_qty=0;
	equipment_fuel.change(function(){
		var equipment_fuel_opt=$(this).find(":selected");
// 		if(equipment_fuel_opt){
// 			fuelType.html("<option value='"+equipment_fuel_opt.attr("rel")+"'>"+equipment_fuel_opt.attr("attr")+"<option>");
// 		}
		
		var fuel_url_report="equipment/eqReport.php?month=6&assetID="+equipment_fuel_opt.attr("assetId")+"&itemCode="+equipment_fuel_opt.attr("itemCode")+"&pcode=<?= $loginProject ?>";
		last_qty=equipment_fuel_opt.attr("max_unit");
		$("#change_able_text").html("(Must be above "+equipment_fuel_opt.attr("max_unit_beauty")+" Km) <a href='"+fuel_url_report+"' target='_blank'>Report</a>");	
	});
	
	$("input#calculate").click(function(){
		var mKm=$("#mKm");
		var fQty=$("#fQty");
		var examount1=$("#examount1");
		
		if(!fQty.val()>0 || !examount1.val()>0){
			alert("Please field up all input fields");
			return 0;
		}
		
		if(parseInt(last_qty)>=parseInt(mKm.val())){
			$("#change_able_text").css("background","red");
			return 0;
		}else
		{
			calc(this.form);twoDigitConversation(this.form,'total');
			if(checkrequired(payments)) {
	payments.expencess.value=1;payments.calculate.value=0;
			isRequiredToSubmit();
			
			}
			return 0;
		}
	});
	
});
</script>

<?php


$paidAmount=$extotal;
?>
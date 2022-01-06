
<? if($vid) echo '<form name="ven" onsubmit="return validateForm( this, 0, 1, 0, 0, 15 );" action="./vendor/vendorupdate.sql.php?vid='.$vid.'" method="post" enctype="multipart/form-data">';
 else echo '<form name="ven" onsubmit="return validateForm( this, 0, 1, 0, 0, 15 );" action="./index.php?keyword=vendor" method="post" enctype="multipart/form-data">';?>
<table   class="vendorTable" align="center"  width="95%"   >
  
  



<tr>
    <td  class="vendorTdl">Ability</td>
	<td>
	
	  <div style="margin:5px 0px;" class="radio_group" >
        <p><input type="radio" name="mngCulture" onchange="selector4Cul(document.ven,this.value)" value="10" <? if($vendor[ManagementCulture]=='10') echo 'CHECKED';?>>
        Able to meet supply schedule, able to meet contingency events (10 points)</p>
        <p><input type="radio" name="mngCulture" onchange="selector4Cul(document.ven,this.value)" value="0" <? if($vendor[ManagementCulture]=='0') echo 'CHECKED';?>>
        Able to meet supply schedule, limited ability to meet contingency events (0 points)</p>
       <p><input type="radio" name="mngCulture" onchange="selector4Cul(document.ven,this.value)" value="-10" <? if($vendor[ManagementCulture]=='-10') echo 'CHECKED';?>>
       Insufficient ability to meet supply schedule (<span style="color:red">Disqualified</span>)</p>
        
      </div></td>
	<td><input type="text" name="mngCultureTxt" id="mngCultureTxt" value="<? echo $vendor[ManagementCultureTxt];?>" disabled class="disabled"  style="width:470px"></td>
</tr>
  
  
<tr>
    <td  class="vendorTdl" > Advance Required</td>    
  <td colspan="2" id="credit01"> 
   <? if($vendor[advance]=='-5') $c1='CHECKED';
      else $c='CHECKED';?>
      <input type="radio" name="advance" value="0"  id="advance0" <? echo $c;?> rel="0"> No (0 points)
      <span>| Yes (-('X%' * 0.2) point): <input type="radio" name="advance"  id="advance5" value="05" <? echo $c1;?> rel="5"> 5% </span>
      <span><input type="radio" name="advance" id="advance10" value="10" <? echo $c1;?> rel="10"> 10% </span>
      <span><input type="radio" name="advance" id="advance15" value="15" <? echo $c1;?> rel="15"> 15% </span>
      <span><input type="radio" name="advance" id="advance20" value="20" <? echo $c1;?> rel="20"> 20% </span>
      <span><input type="radio" name="advance" id="advance25" value="25" <? echo $c1;?> rel="25"> 25% </span>
      <span><input type="radio" name="advance" id="advance30" value="30" <? echo $c1;?> rel="30"> 30% </span>
      <span><input type="radio" name="advance" id="advance45" value="45" <? echo $c1;?> rel="45"> 45% </span>
      <span><input type="radio" name="advance" id="advance50" value="50" <? echo $c1;?>  rel="50"> 50% </span>
      <span><input type="radio" name="advance" id="advance60" value="60" <? echo $c1;?> rel="60"> 60% </span>
      <span><input type="radio" name="advance" id="advance75" value="75" <? echo $c1;?> rel="75"> 75% </span>
      <span><input type="radio" name="advance" id="advance100" value="100" <? echo $c1;?> rel="100"> 100%</span>
	
	
	<input type="hidden" name="advanceText" value="" id="advanceText"/>
	
	</td>
	<script type="text/javascript">
	$(document).ready(function(){
		
		advanceText=$("#advanceText");
		cfacilityText=$("#cfacilityText");
		
	$("#credit01 input:radio").click(function(){
		rel=$(this).attr("rel");
		advanceText.val(rel);
	});
		
	$("#credit02 input:radio").click(function(){
		rel=$(this).attr("rel");
		cfacilityText.val(rel);
	});
		
		
		<?php		
		if($vendor[advanceText]>-1){ ?>
			$("#advance<?php echo $vendor[advanceText]; ?>").prop("checked",true);
		<?php		}		
		?>
		<?php		
		if($vendor[cfacilityText]>-1){ ?>
			$("#cfacility<?php echo $vendor[cfacilityText]; ?>").prop("checked",true);
		<?php		}		
		?>
		
		var advTypeRow=$("#advTypeRow");
		for(adc=0;adc<=100;adc+=5)
			$("#advance"+adc).change(function(){
				var adcThis=$(this);
				if(adcThis.val()>0){
					$("#advType:first").prop("checked",true);
					advTypeRow.show();
				}else{
					advTypeRow.hide();
					$("#advType").prop("checked",false);
				}
			});
		
});
	</script>
</tr>  
<tr id="advTypeRow" style="<?php echo $vendor[advanceType] ? "" : "display:none"; ?>">
  <td  class="vendorTdl"> Advance Type</td>  
  <td>
		<input type="radio" id="advType" name="advType" value="start" <?php echo $vendor[advanceType]=="start" ? "checked" : ""; ?>> Start
		<input type="radio" id="advType" name="advType" value="prorated" <?php echo $vendor[advanceType]=="prorated" ? "checked" : ""; ?>> Prorated
	</td> 
</tr>

<tr>
    <td  class="vendorTdl" > Credit Facility</td>    
  <td colspan="2"  id="credit02">
     <? if($vendor[cfacility]=='10') $c2='CHECKED';
	    elseif($vendor[cfacility]=='0') $c3='CHECKED';		
        // else $c1='CHECKED';?>

 
  <input type="radio" name="cfacility" id="cfacility0" value="20" <? echo $c3;?> rel="0"> Bill-to-Bill (20 points)
    | Yes ((X days * 0.25) points) :
  <input type="radio" name="cfacility" id="cfacility7" value="7" rel="7">7 days, 
<input type="radio" name="cfacility" id="cfacility14" value="14"  rel="14"> 14 days, 
<input type="radio" name="cfacility" id="cfacility21" value="21" rel="21"> 21 days, 
<input type="radio" name="cfacility" id="cfacility30" value="30" rel="30"> 30 days, 
<input type="radio" name="cfacility" id="cfacility45" value="45" rel="45"> 45 days, 
<input type="radio" name="cfacility" id="cfacility60" value="60" rel="60"> 60 days, 
<input type="radio" name="cfacility" id="cfacility75" value="75" rel="75"> 75 days, 
<input type="radio" name="cfacility" id="cfacility90" value="90" rel="90"> 90 days

			<input type="hidden" name="cfacilityText" value="" id="cfacilityText"/>
  </td>
</tr> 
</table>
</form>	
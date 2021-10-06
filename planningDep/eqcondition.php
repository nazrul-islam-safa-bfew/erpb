<? 


	 
$sqlp1 = "SELECT * from  `pcondition` WHERE posl='$posl'";
//echo $sqlp1;
$sqlrunp1= mysqli_query($db, $sqlp1);
$typel2= mysqli_fetch_array($sqlrunp1);
//echo $typel2[condition];
$extra=$typel2[extra];
$extra1=$typel2[extra1];
$extra2=$typel2[extra2];
$extra3=$typel2[extra3];
$extra4=$typel2[extra4];
$temp=explode('_',$typel2[condition]);
$ch1=0;$ch2=0;$ch3=0;$ch4=0;$ch5=0;
$ch6=0;$ch7=0;$ch8=0;$ch9=0;$ch10=0;
$ch11=0;$ch12=0;$ch13=0;$ch14=0;$ch15=0;

for($k=0;$k<sizeof($temp);$k++){
  if($temp[$k]=='ch1') {$ch1=1;}
  if($temp[$k]=='ch2') {$ch2=1;}
  if($temp[$k]=='ch3') {$ch3=1;}
  if($temp[$k]=='ch4') {$ch4=1;}
  if($temp[$k]=='ch5') {$ch5=1;}
  if($temp[$k]=='ch6') {$ch6=1;}
  if($temp[$k]=='ch7') {$ch7=1;}
  if($temp[$k]=='ch8') {$ch8=1;}
  if($temp[$k]=='ch9') {$ch9=1;}                
  if($temp[$k]=='ch10') {$ch10=1;}  
  if($temp[$k]=='ch11') {$ch11=1;}
  if($temp[$k]=='ch12') {$ch12=1;}
  if($temp[$k]=='ch13') {$ch13=1;}
  if($temp[$k]=='ch14') {$ch14=1;}                
  if($temp[$k]=='ch15') {$ch15=1;}  
  if($temp[$k]=='ch16') {$ch16=1;}    
  if($temp[$k]=='ch23') {$ch23=1;}  
  if($temp[$k]=='ch24') {$ch24=1;}  
  if($temp[$k]=='ch25') {$ch25=1;}    
  if($temp[$k]=='ch26') {$ch26=1;}    
  if($temp[$k]=='ch27') {$ch27=1;}  
  if($temp[$k]=='ch28') {$ch28=1;}    
  if($temp[$k]=='ch29') {$ch29=1;}      
  
}
$tch6=$temp[16];
$tch13=$temp[17];
$tch251=$temp[19];

$tch141=$temp[31]; //old terms
$tch141=intval($vendor[advanceText]); //new terms

$tch142=$temp[26];

?>


  <table align="center" width="95%" border="0"  cellspacing="5" cellpadding="5" style="border-collapse:collapse">
<tr>
  <td colspan="2">Terms & Conditions:</td>
</tr>
<tr>
<td><input type="checkbox" name="ch1" value="ch1" <? if($ch1) echo 'checked';?>></td>
<td>All Equipments are to be supplied as per Standard Quality maintaining Delivery Schedule. </td>
</tr>
<tr>
<td><input type="checkbox" name="ch2" value="ch2" <? if($ch2) echo 'checked';?>></td>
<td>Any Equipment not conforming to the Standard Quality or Delivery Schedule will be removed by the supplier immediately at supplier's risk and cost.</td>
</tr>

<tr>
 <td><input type="checkbox" name="ch3" value="ch3"  <? if($ch3) echo 'checked';?>></td>
 <td>In case supplier fails to delivery equipment from his yard on schedule date but BFEW agrees to receive the Equipment, two days bill will be deducted for each day of delay.</td>
</tr>
<tr>
 <td><input type="checkbox" name="ch4" value="ch4" checked></td>
<td>In case BFEW is to incur expenditure in relation to Equipment not conforming the Quality or Delivery Schedule, BFEW will make required adjustment in the supplier's bill.</td>
</tr>
<tr>
 <td><input type="checkbox" name="ch14" value="ch14"  <? if($tch141) echo 'checked';else echo "disabled";?>></td>
<td>Advance <input type="text" name="tch141" value="<? echo $tch141;?>" <?php if(!$tch141)echo "disabled"; ?> size="5" onBlur="tch142.value=<? echo "($totalAmount*tch141.value)/100";?>"  readonly>
      % of the Work Order amount which is Tk. 
      <input type="text" name="tch142" value="<? echo ($tch141*$totalAmount)/100;?>" size="10" readonly="" style="border:0">  will be paid along with this Work Order. Advanced Amount will be adjusted on prorate basis from every bill.</td>
</tr>
<tr>
<tr>
 <td><input type="checkbox" name="ch5" value="ch5"  <? if($ch5) echo 'checked';?>></td>
<td>Running bills will be submitted at the end of every month.</td>
</tr>
		
		
<tr>
 <td><input type="checkbox" name="ch30" value="ch30"  <? if($ch30) echo 'checked';?> ></td>
 <td>Overtime rate will be <input type="text" name="tch13" value="<? echo $tch13;?>" width="5" size="5">X compare to regular hourly rate. </td>
</tr>

<tr>
 <td><input type="checkbox" name="ch32" value="ch32"  <? if($ch32) echo 'checked';?> ></td>
 <td>Friday working rate will be <input type="text" name="tch13" value="<? echo $tch13;?>" width="5" size="5">X compare to regular hourly rate.</td>
</tr>
		
<tr>
 <td><input type="checkbox" name="ch33" value="ch33"  <? if($ch33) echo 'checked';?> ></td>
 <td>Public holiday working rate will be <input type="text" name="tch13" value="<? echo $tch13;?>" width="5" size="5">X compare to regular hourly rate.</td>
</tr>
		
<tr>
 <td><input type="checkbox" name="ch34" value="ch34"  <? if($ch34) echo 'checked';?> ></td>
 <td>Eid holiday working rate will be <input type="text" name="tch13" value="<? echo $tch13;?>" width="5" size="5">X compare to regular hourly rate.</td>
</tr>

		
<!-- <tr>
 <td><input type="checkbox" name="ch6" value="ch6"  <? if($ch6)echo 'checked';?>></td>
 <td>Overtime Rate will be  -->
	 <input type="hidden" name="tch6" size="4" width="4" maxlength="3">
<!-- 		% Extra per hour</td>
</tr> -->
		
		
<tr>
 <td><input type="checkbox" name="ch7" value="ch7"  checked></td>
<td>Supplier will collect all payments from Head Office of BFEW Ltd after proper certification of Quality & Quantity from the concerned stores.</td>
</tr>
<tr>
 <td><input type="checkbox" name="ch10" value="ch10"  checked></td>
 <td>If Equipment is unable to work for more than 1 hour at stretch in a day, thouse hours will be treated as breakdown.</td>
</tr>
<tr>
 <td><input type="checkbox" name="ch8" value="ch8"  checked></td>
 <td>If Equipment is under breakdown for 4 hours and above, No rent will be incur that day.</td>
</tr>
<tr>
 <td><input type="checkbox" name="ch9" value="ch9" checked></td>
 <td>If Equipment is under breakdown for 2 times and above, No rent will be incur that day.</td>
</tr>

<tr>
 <td><input type="checkbox" name="ch25" value="ch25"  <? if($ch25) echo 'checked';?>></td>
<td> Contractor will receive 
<input type="text" name="tch251"value="<? echo $tch251;?>" size="3">% of the Work Completed amount as Daily Progress Payment.</td>
</tr>

<tr>
 <td><input type="checkbox" name="ch11" value="ch11"></td>
 <td>During mobilization if equipment leave supplier's yard after 12 am, no rent will be incur that day.</td>
</tr>
<tr>
 <td><input type="checkbox" name="ch12" value="ch12"></td> 
 <td>During demobilization if equipment reach supplier's yard before 12 am, no rent will be incur that day.</td>
</tr>
<tr>
 <td><input type="checkbox" name="ch13" value="ch13" checked></td>
 <td><input type="text" name="tch13" value="<? echo $tch13;?>" width="5" size="5"> %  will be deducted from every running bill as Retention money.</td>
</tr>

<tr>
  <td><input type="checkbox" name="ch24" value="ch24"  checked ></td>
  <td>Supplier must comply with the Health, Environment and Safety rules and regulations maintained by the Project Authority & BFEW Ltd.</td>
</tr>
<tr>
  <td><input type="checkbox" name="ch23" value="ch23"  <? if($ch23) echo 'checked';?>></td>
  <td><input name="extra" type="text" size="100" maxlength="2000" value="<? echo $extra;?>" ></td>
</tr>
<tr>
  <td><input type="checkbox" name="ch26" value="ch26"  <? if($ch26) echo 'checked';?>></td>
  <td><input name="extra1" type="text" size="100" maxlength="2000" value="<? echo $extra1;?>" ></td>
</tr><tr>
  <td><input type="checkbox" name="ch27" value="ch27"  <? if($ch27) echo 'checked';?>></td>
  <td><input name="extra2" type="text" size="100" maxlength="2000" value="<? echo $extra2;?>" ></td>
</tr><tr>
  <td><input type="checkbox" name="ch28" value="ch28"  <? if($ch28) echo 'checked';?>></td>
  <td><input name="extra3" type="text" size="100" maxlength="2000" value="<? echo $extra3;?>" ></td>
</tr><tr>
  <td><input type="checkbox" name="ch29" value="ch29"  <? if($ch29) echo 'checked';?>></td>
  <td><input name="extra4" type="text" size="100" maxlength="2000" value="<? echo $extra4;?>" ></td>
</tr>


<tr>
 <td><input type="checkbox" name="ch16" value="ch16"  <? if($ch16) echo 'checked';?> checked></td>
 <td>As to the Quality of the Supply or for all other technical matters, BFEW decision will be final, binding and conclusive. </td>
</tr>

<tr>
 <td colspan="2"></td>
</tr>

<tr>
 <td colspan="2">
  <table width="100%">
    <tr><td colspan="2" height="50"></td></tr>
	<tr>
	 <td width="50%" align="left" >Authorized Signature<br>  
					   Bangladesh Foundry & Engg. Works Ltd.
	
	 </td>
	
	 <td width="50%" align="right" ><br>Understood and agreed <br>
						Authorized Signature<br>  
						For <? echo $vendor[vname];?>
	
	 </td>
	</tr>
  
  </table>
 
 </td>
</tr>


</table>

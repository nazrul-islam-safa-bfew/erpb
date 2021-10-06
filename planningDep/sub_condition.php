<? 

$sqlp1 = "SELECT * from  `pcondition` WHERE posl='$posl'";
//echo $sqlp1;
$sqlrunp1= mysqli_query($db,$sqlp1);
$typel2= mysqli_fetch_array($sqlrunp1);
//echo $typel2[condition];
$extra=$typel2[extra];
$extra1=$typel2[extra1];
$extra2=$typel2[extra2];
$extra3=$typel2[extra3];
$extra4=$typel2[extra4];
$temp=explode('_',$typel2[condition]);

// print_r($temp);
$ch1=0;$ch2=0;$ch3=0;$ch4=0;$ch5=0;
$ch6=0;$ch7=0;$ch8=0;$ch9=0;$ch10=0;
$ch11=0;$ch12=0;$ch13=0;$ch14=0;$ch15=0;
$ch16=0;$ch17=0;$ch18=0;$ch19=0;$ch20=0;
$ch21=0;$ch22=0;

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
  if($temp[$k]=='ch17') {$ch17=1;}
  if($temp[$k]=='ch18') {$ch18=1;}
  if($temp[$k]=='ch19') {$ch19=1;}
  if($temp[$k]=='ch20') {$ch20=1;}                
  if($temp[$k]=='ch21') {$ch21=1;}  
  if($temp[$k]=='ch22') {$ch22=1;}    
  if($temp[$k]=='ch23') {$ch23=1;}  
  if($temp[$k]=='ch24') {$ch24=1;}    
  if($temp[$k]=='ch25') {$ch25=1;}      
  if($temp[$k]=='ch26') {$ch26=1;}    
  if($temp[$k]=='ch27') {$ch27=1;}  
  if($temp[$k]=='ch28') {$ch28=1;}    
  if($temp[$k]=='ch29') {$ch29=1;}      

}
$tch51=$temp[25];
$tch81=$temp[26];
$tch82=$temp[27];
$tch111=$temp[28];
$tch112=$temp[29];
$tch131=$temp[30];
$tch141=$temp[30];
$tch142=$temp[31];
$tch151=$temp[33];
$tch171=$temp[34];
$tch181=$temp[35];
$tch251=$temp[36];

if(!$tch131){
	$ch14=1;
	// $tch141=getVendoradvanceinfo($vid);//v1 backdated
	$tch141=getVendoradvanceinfo_v2($vid,$itemCode); //v2
}
?>


  <table align="center" width="95%" border="0"  cellspacing="5" cellpadding="5" style="border-collapse:collapse">
<tr>
  <td colspan="2">Terms & Conditions: </td>
</tr>
<tr>
<td><input type="checkbox" name="ch1" value="ch1" <? if($ch1) echo 'checked';?>  ></td>
<td>All Work have to be done as per Approved Quality maintaining Delivery Schedule. </td>
</tr>

<tr>
 <td><input type="checkbox" name="ch5" value="ch5"  <? if($ch5) echo 'checked';?>></td>
<td>In case supplier fails to maintain schedule but BFEW agrees to accept that work, <input type="text" name="tch51" value="<? echo $tch51;?>" size="5">% amount will be deducted from the Bill amount on account of contractor's failure to supply the quantity as per Schedule.</td>
</tr>
<tr>
 <td><input type="checkbox" name="ch6" value="ch6"  <? if($ch6) echo 'checked';?>></td>
 <td>In case BFEW is to incur expenditure in relation to work not conforming the Quality or Delivery Schedule,
  BFEW will make required adjustment in the contractor's bill.</td>
</tr>

<tr>
<td><input type="checkbox" name="ch14" value="ch14" <?php if(!$tch141)echo 'disabled="disabled"'; elseif($ch14)echo 'checked'; else echo 'checked'; ?> readonly="readonly"></td>
<td>Advance <input type="text" name="tch141" value="<? echo $tch141;?>" size="5" onBlur="tch142.value=<? echo "($totalAmount*tch141.value)/100";?>" readonly>
      % of the Work Order amount which is Tk. 
      <input type="text" name="tch142" value="<? echo (($totalAmount*$tch141)/100); ?>" size="10" readonly="" style="border:0"> will be paid along with this Work Order.
	   Advanced Amount will be adjusted on prorate basis from every Bill and Progress Payment.</td>
</tr>
<tr>

<tr>
 <td><input type="checkbox" name="ch25" value="ch25"  <? if($ch25) echo 'checked';?>></td>
<td> Contractor will receive 
<input type="text" name="tch251"value="<? echo $tch251;?>" size="3">% of the Work Completed amount as Daily Progress Payment.</td>
</tr>
<script>
function security_deposit(ch1,ch2,ch3,k) {
var total = 0;
var chname1=ch1.name;
var chname2=ch2.name;
var chname3=ch3.name;
//alert(ch1.name);
//alert(chn.length);
	
if (eval("document.purchaseOrder."+chname1+".checked") == true) 
{
		//alert('AA');
	if(k==1){ 
	 box = eval("document.purchaseOrder."+chname2);
	 box.disabled=false;
	 box = eval("document.purchaseOrder."+chname3);
	 box.disabled=false;

	box = eval("document.purchaseOrder."+chname2);
	 box.checked = true; 
	 }//k=1
	else if(k==2 ){
		if (eval("document.purchaseOrder."+chname2+".checked") == true  ) 
			{
			//alert('AA');
			 box = eval("document.purchaseOrder."+chname2);
			 box.checked = true; 
			 box = eval("document.purchaseOrder."+chname3);
			 box.checked = false; 
			// break;
			 }
	}//k==2
	else if(k==3 )
	{
		if (eval("document.purchaseOrder."+chname3+".checked") == true  ) 
			{
			//alert('AA');
			 box = eval("document.purchaseOrder."+chname2);
			 box.checked = false; 
			 box = eval("document.purchaseOrder."+chname3);
			 box.checked = true; 
			// break;
			 }
		 
	 }//k=3
	if (eval("document.purchaseOrder."+chname2+".checked") == false   && eval("document.purchaseOrder."+chname3+".checked") == false  ) 	 
	{box = eval("document.purchaseOrder."+chname2);
		 box.checked = true; }
}	 
	 else {
	 
	 
	 box = eval("document.purchaseOrder."+chname2);
	 box.checked = false; box.disabled=true;
	 box = eval("document.purchaseOrder."+chname3);
	 box.checked = false; box.disabled=true;

	 }
}	 
</script>
 <td><input type="checkbox" name="ch11" value="ch11"  <? if($ch11) echo 'checked';?> onClick="security_deposit(ch11,ch12,ch13,1)"></td>
 <td>Contractor is required to pay
  Security deposit <input type="text" name="tch111"value="<? echo $tch111;?>" size="5" onBlur="tch112.value=<? echo "($totalAmount*tch111.value)/100";?>">% of the Work Order amount,
  equivalent to Tk. <input type="text" name="tch112" value="<? echo $tch112;?>" size="10" style="border:0" readonly="">  in form of Bank draft/Pay Order in favour of BFEW on receiving letter of intent but before issue of Work Order.</td>
</tr>
<tr>
 <td><input type="checkbox" name="ch12" value="ch12"  <? if($ch12) echo 'checked';?> disabled onClick="security_deposit(ch11,ch12,ch13,2)"></td>
<td>Security Deposit will be returned with the Final payment.</td>
</tr>
<tr>
 <td><input type="checkbox" name="ch13" value="ch13"  <? if($ch13) echo 'checked';?> disabled onClick="security_deposit(ch11,ch12,ch13,3)"></td>
 <td>Security Deposit will be returned within 
      <input type="text" name="tch131" value="<? echo $tch131;?>" size="10"> days after sattlement of Final payment.</td>
</tr>

<tr>
 <td><input type="checkbox" name="ch15" value="ch15"  <? if($ch15) echo 'checked';?> onClick="security_deposit(ch15,ch16,ch17,1)"></td>
 <td><input type="text" name="tch151" value="<? echo $tch151;?>" size="10"> %  amount will be deducted from every running bill as Retention money.</td>
</tr>

<tr>
 <td><input type="checkbox" name="ch16" value="ch16"  <? if($ch16) echo 'checked';?> disabled onClick="security_deposit(ch15,ch16,ch17,2)"></td>
<td>Retention money will be paid with the Final payment.</td>
</tr>
<tr>
 <td><input type="checkbox" name="ch17" value="ch17"  <? if($ch17) echo 'checked';?> disabled onClick="security_deposit(ch15,ch16,ch17,3)"></td>
    <td>Retention money will be paid within 
      <input type="text" name="tch171" value="<? echo $tch171;?>" size="10"> days after settlement of Final payment.</td>
</tr>
<!--
<tr>
 <td><input type="checkbox" name="ch18" value="ch18"  <? if($ch18) echo 'checked';?>></td>
 <td>Running bills will be raised after every <input type="text" name="tch181" value="<? echo $tch181;?>" size="5">% completion of supply.</td>
</tr>
<tr>
 <td><input type="checkbox" name="ch19" value="ch19"  <? if($ch19) echo 'checked';?>></td>
<td>Running Bills will be submitted at the end of every month.</td>
</tr>
-->
<tr>
 <td><input type="checkbox" name="ch20" value="ch20"  <? if($ch20) echo 'checked';?>></td>
<td>No Running Bill will be accepted, Bill will be submitted only after completion of Supply.</td>
</tr>
<tr>
 <td><input type="checkbox" name="ch21" value="ch21"  <? if($ch21) echo 'checked';?>></td>
 <td>Contractor  will collect all payments from Head Office of BFEW Ltd after proper certification of Quality & Quantity from the concerned stores.</td>
</tr>

<tr>
 <td><input type="checkbox" name="ch22" value="ch22"  <? if($ch22) echo 'checked';?> checked></td>
<td>Contractor  must comply with the Health, Environment and Safety rules and regulations maintained by the Project Authority & BFEW.</td>
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
 <td><input type="checkbox" name="ch24" value="ch24"  <? if($ch24) echo 'checked';?> checked></td>
 <td>As to the Quality of the Work or for all other technical matters, BFEW decision will be final, binding and conclusive. </td>
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

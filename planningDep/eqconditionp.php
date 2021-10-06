<? 

$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 
$sqlp1 = "SELECT * from  `pcondition` WHERE posl='$posl'";
//echo $sqlp1;
$sqlrunp1= mysql_query($sqlp1);
$typel2= mysql_fetch_array($sqlrunp1);
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
  if($temp[$k]=='ch25') {$ch25=1;}    
  if($temp[$k]=='ch26') {$ch26=1;}    
  if($temp[$k]=='ch27') {$ch27=1;}  
  if($temp[$k]=='ch28') {$ch28=1;}    
  if($temp[$k]=='ch29') {$ch29=1;} 
}
$tch6=$temp[16];
$tch13=$temp[17];
$tch251=$temp[19];
$ll=1;
?>

 <table align="left" width="600" border="0"  cellspacing="5" cellpadding="5" style="border-collapse:collapse">
<tr>
  <td colspan="2">Terms & Conditions:</td>
</tr>
<? if($ch1){?>
<tr>
<td><? echo $ll++;?>.</td><td>All Equipments are to be supplied as per Standard Quality maintaining Delivery Schedule. </td>
</tr>
<? }?>
<? if($ch2){?>
<tr>
<td><? echo $ll++;?>.</td><td>Any Equipment not conforming to the Standard Quality or Delivery Schedule will be removed by the supplier immediately at supplier's risk and cost.</td>
</tr>
<? }?>
<? if($ch3){?>
<tr>
<td> <? echo $ll++;?>.</td> <td>In case supplier fails to delivery equipment from his yard on schedule date but BFEW agrees to receive the Equipment, two days bill will be deducted for each day of delay.</td>
</tr>
<? }?>
<? if($ch4){?>
<tr>
<td><? echo $ll++;?>.</td><td>In case BFEW is to incur expenditure in relation to Equipment not conforming the Quality or Delivery Schedule, BFEW will make required adjustment in the supplier's bill.</td>
</tr>
<? }?>
<? if($ch5){?>
<tr>
<td><? echo $ll++;?>.</td>
<td>Running bills will be submitted at the end of every month.</td>
</tr>
<? }?>
<? if($ch6){?>
<tr>
<td><? echo $ll++;?>.</td> <td>Overtime Rate will be <? echo $tch6;?> % Extra per hour</td>
</tr>
<? }?>
<? if($ch7){?>
<tr>
<td><? echo $ll++;?>.</td>
<td>Supplier will collect all payments from Head Office of BFEW Ltd after proper certification of Quality & Quantity from the concerned stores.</td>
</tr>
<? }?>

<? if($ch25){?>
<tr>
<td><? echo $ll++;?>.</td>
<td> Contractor will receive <? echo $tch251;?>% of the Work Completed amount as Daily Progress Payment.</td>
</tr>
<? }?>

<? if($ch10){?>
<tr>
 <td><? echo $ll++;?>.</td>
 <td>If Equipment is unable to work for more than 1 hour at stretch in a day, it will be treated as breakdown.</td>
</tr>
<? }?>

<? if($ch8){?>
<tr>
 <td><? echo $ll++;?>.</td> 
 <td>If Equipment is under breakdown for 4 hours and above, No rent will be incur that day.</td>
</tr>
<? }?>
<? if($ch9){?>
<tr>
 <td><? echo $ll++;?>.</td>
 <td>If Equipment is under breakdown for 2 times and above, No rent will be incur that day.</td>
</tr>
<? }?>
<? if($ch13){?>
<tr>
 <td><? echo $ll++;?>.</td>
 <td><? echo $tch13;?> %  will be deducted from every running bill as Retention money.</td>
</tr>
<? }?>


<? if($ch11){?>
<tr>
 <td><? echo $ll++;?>.</td>
 <td>During mobilization if equipment leave supplier's yard after 12 am, no rent will be incur that day.</td>
</tr>
<? }?>
<? if($ch12){?>
<tr>
 <td><? echo $ll++;?>.</td>
 <td>During demobilization if equipment reach supplier's yard before 12 am, no rent will be incur that day.</td>
</tr>
<? }?>
<? if($ch14){?>
<tr>
 <td><? echo $ll++;?>.</td> 
 <td>Supplier must comply with the Health, Environment and Safety rules and regulations maintained by the Project Authority & BFEW Ltd.</td>
</tr>
<? }?>
<? if($ch23){?>
<tr>
 <td><? echo $ll++;?>.</td>
 <td><? echo $extra;?></td>
</tr>
<? }?>
<? if($ch26){?>
<tr>
<td valign="top"><? echo $l++;?></td>
  <td><? echo $extra1;?></td>
</tr>
<? }?>
<? if($ch27){?>
<tr>
<td valign="top"><? echo $l++;?></td>
  <td><? echo $extra2;?></td>
</tr>
<? }?>
<? if($ch28){?>
<tr>
<td valign="top"><? echo $l++;?></td>
  <td><? echo $extra3;?></td>
</tr>
<? }?>
<? if($ch29){?>
<tr>
<td valign="top"><? echo $l++;?></td>
  <td><? echo $extra4;?></td>
</tr>
<? }?>

<? if($ch16){?>
<tr>
 <td><? echo $ll++;?>.</td>
 <td>As to the Quality of the Supply or for all other technical matters, BFEW decision will be final, binding and conclusive. </td>
</tr>
<? }?>
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

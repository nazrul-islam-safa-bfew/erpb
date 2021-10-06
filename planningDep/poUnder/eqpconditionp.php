<?
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sqlp1 = "SELECT * from  `pconditiontemp` WHERE posl='$posl'";
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
$l=1;
?>

  <table align="left" width="600" border="0"  cellspacing="5" cellpadding="5" style="border-collapse:collapse">
<tr>
  <td colspan="2">Terms & Conditions:</td>
</tr>
<? if($ch1){?>
<tr>
<td valign="top"><? echo $l++;?></td>
<td>All Equipments are to be supplied as per Approved Quality maintaining Delivery Schedule. </td>
</tr>
<? }?>
<? if($ch2){?>
<tr>
<td valign="top"><? echo $l++;?></td>
<td>All Equipments are to be supplied as per Standard Quality maintaining Delivery Schedule.</td>
</tr>
<? }?>
<? if($ch3){?>
<tr>
<td valign="top"><? echo $l++;?></td>
 <td>All Equipments are to be supplied as per suppliers approved Sample maintaining Delivery Schedule.</td>
</tr>
<? }?>
<? if($ch4){?>
<tr>
<td valign="top"><? echo $l++;?></td>
<td>Any Equipments not conforming to the approved Quality or Delivery Schedule will be removed by the supplier immediately at supplier's risk and cost.</td>
</tr>
<? }?>
<? if($ch5){?>
<tr>
<td valign="top"><? echo $l++;?></td>
<td>In case supplier fails to maintain schedule but BFEW agrees to accept that supply, <? echo $tch51;?>% amount will be deducted from the Bill amount on account of supplier's failure to supply the quantity as per Schedule.</td>
</tr>
<? }?>
<? if($ch6){?>
<tr>
<td valign="top"><? echo $l++;?></td>
 <td>In case BFEW is to incur expendiuter in relation to Equipments not conforming the Quality or Delivery Schedule, BFEW will make required adjustment in the supplier's bill.</td>
</tr>
<? }?>
<? if($ch7){?>
<tr>
<td valign="top"><? echo $l++;?></td>
<td>All Equipments are to be supplied at Project site at different locations in different quantities as per instruction of BFEW representative.</td>
</tr>
<? }?>
<? if($ch8){?>
<tr>
<td valign="top"><? echo $l++;?></td>
 <td>No Delivery will be receive between <? echo $tch81;?> to <? echo $tch82;?></td>
</tr>
<? }?>
<? if($ch9){?>
<tr>
<td valign="top"><? echo $l++;?></td>
<td>No Delivery will be receive in Friday.</td>
</tr>
<? }?>
<? if($ch10){?>
<tr>
<td valign="top"><? echo $l++;?></td>
<td>No Delivery will be receive in Public Holiday.</td>
</tr>
<? }?>
<? if($ch11){?>
<tr>
<td valign="top"><? echo $l++;?></td>
 <td>Supplier is required to pay Security deposit <? echo $tch111;?>% of the Work Order amount,
  equivalent to Tk. <? echo $tch112;?> in form of Bank draft/Pay Order in favour of BFEW on receiving letter of intent but before issue of Work Order.</td>
</tr>
<? }?>
<? if($ch12){?>
<tr>
<td valign="top"><? echo $l++;?></td>
<td>Security Deposit will be returned with the Final payment.</td>
</tr>
<? }?>
<? if($ch13){?>
<tr>
<td valign="top"><? echo $l++;?></td>
    <td>Security Deposit will be returned within <? echo $tch131;?> days after settlement of Final payment.</td>
</tr>
<? }?>
<? if($ch14){?>
<tr>
<td valign="top"><? echo $l++;?></td>
<td>Advance <? echo $tch141;?> % of the Work Order amount which is Tk.<? echo $tch142;?>  will be paid along with this Work Order. Advanced Amount will be adjusted on prorate basis from every bill.</td>
</tr>
<? }?>
<? if($ch15){?>
<tr>
<td valign="top"><? echo $l++;?></td>
 <td><? echo $tch151;?> %  amount will be deducted from every running bill as Retention money.</td>
</tr>
<? }?>
<? if($ch16){?>
<tr>
<td valign="top"><? echo $l++;?></td>
 <td>Retention money will be paid with the Final payment.</td>
</tr>
<? }?>
<? if($ch17){?>
<tr>
<td valign="top"><? echo $l++;?></td>
 <td>Retention money will be paid within <? echo $tch171;?> days after settlement of Final payment.</td>
</tr>
<? }?>

<? if($ch18){?>
<tr>
<td valign="top"><? echo $l++;?></td>
 <td>Running bills will be raised after every <? echo $tch181;?> % completion of supply.</td>
</tr>
<? }?>
<? if($ch19){?>
<tr>
<td valign="top"><? echo $l++;?></td>
<td>Running Bills will be submitted at the end of every month.</td>
</tr>
<? }?>
<? if($ch20){?>
<tr>
<td valign="top"><? echo $l++;?></td>
<td>No Running Bill will be accepted, Bill will be submitted only after completion of Supply.</td>
</tr>
<? }?>
<? if($ch21){?>
<tr>
<td valign="top"><? echo $l++;?></td>
 <td>Supplier will collect all payments from Head Office of BFEW Ltd after proper certification of Quality & Quantity from the concerned stores.</td>
</tr>
<? }?>
<? if($ch22){?>
<tr>
<td valign="top"><? echo $l++;?></td>
<td>Supplier must comply with the Health, Environment and Safety rules and regulations maintained by the Project Authority & BFEW.</td>
</tr>
<? }?>
<? if($ch23){?>
<tr>
<td valign="top"><? echo $l++;?></td>
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

<? if($ch24){?>
<tr>
<td valign="top"><? echo $l++;?></td>
 <td>As to the Quality of the Supply or for all other technical matters, BFEW decision will be final, binding and conclusive. </td>
</tr>
<? }?>
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

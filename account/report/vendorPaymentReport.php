<form name="searchBy" action="./index.php?keyword=vendor+payment+report" method="post">

<table width="600" align="center" bgcolor="#CEEFFF">
 <tr>
   <th width="200">Select Vendor</th>
 <td colspan="3">
<select name="vid">
 <option value="">All Vendor</option>
<?
include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT distinct vendor.vid,vendor.vname,porder.vid from `vendor`,porder WHERE vendor.vid=porder.vid ORDER by vendor.vname ASC ";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

 while($typel= mysqli_fetch_array($sqlrunp))
{
 echo "<option value='".$typel[vid]."'";
 if($vid==$typel[vid]) echo " SELECTED ";
 echo ">$typel[vname]</option>  ";
 }
?>
	</select>
</td>
<td rowspan="3"><input type="submit" name="search" value="Search" style="height:50px;width:100"></td>

 </tr>
  <tr>
   <th width="200">Select Project</th>
 <td colspan="3">
<select name="pcode">
 <option value="">All Project</option>
<?
	include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT `pcode`,pname from `project` ORDER by pcode ASC";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
 while($typel= mysqli_fetch_array($sqlrunp))
{
 echo "<option value='".$typel[pcode]."'";
 if($pcode==$typel[pcode])  echo " SELECTED";
 echo ">$typel[pcode]--$typel[pname]</option>  ";
 }
?>
	</select>
</td>
 </tr>
<tr>
 <td><input type="radio" name="type" value="PO" <? if($type=='PO') echo ' checked ';?>>Material & Labour</td>
 <td><input type="radio" name="type" value="EQ" <? if($type=='EQ') echo ' checked ';?> >Equipment</td> 
</tr> 
</table>
</form>
<table align="center" width="100%" border="3"  bordercolor="CC9999" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td align="right" valign="top" colspan="5"><font class='englishhead'>Vendore Payment Report</font></td>
</tr>
<tr bgcolor="#FFCCCC">
 <th width="200">Perchase Order SL.</th>
 
 <th width="100" >Payment NO.</th> 
 <th width="300">Planned Maturity</th>  
 <th width="300">Actual Maturity</th>   
 </tr>
<? 
/* $sql="select distinct posl,vid,activeDate from `porder` WHERE".
  "  (posl LIKE 'PO_".$pcode."%_".$vid."' OR posl LIKE 'EQ_".$pcode."%_".$vid."')". 
  " AND status >=1 order by vid,poid ASC ";    
*/

if($pcode=='') $pcode='%';
if($vid=='') $vid='%';
 $sql="select distinct posl,vid,activeDate from `porder` WHERE".
   "  posl LIKE '".$type."_%' AND ". 
  "  location LIKE '".$pcode."' AND vid LIKE '$vid' AND posl not LIKE 'EP_%'". 
  " AND status >=1 order by vid,poid ASC ";    

//echo $sql;
  $sqlQ=mysqli_query($db, $sql);
  $i=1;
  $bg=1;
  while($re=mysqli_fetch_array($sqlQ)){ $sl=1;?>
<?  if(poFullPaid($re[posl])){
 $poAdvance=0;
  $payableAmountTotal=0;
  $actualReceivePO=0;
$popaymentPaid=0;  
$payableAmount=0;
?>
  <tr <? if($bg%2==0) echo "bgcolor=#F4F4F4";?> >
    <td width="200" valign="top"><? echo viewPosl($re[posl]);?><br><br><? echo vName($re[vid]); ?>
	<? $exp=explode('_',$re[posl]);
 $p=$exp[1];
 $actualReceivePO = actualReceivePO($re[posl],$p);

  $popaymentPaid=popaymentPaid($re[posl]);
  
  ?></td>
	<td colspan="3">
	<table width="100%" border="1" bordercolor="#CCCCCC" cellpadding="2" cellspacing="0"  style="border-collapse:collapse">
<? if(poAdvance($re[posl])){?>
	<tr>
	  <td width="100">Payment <? echo $sl++;?>:</td>
      <td width="300">
		  <table width="100%" height="100%" cellspacing="5">
			<tr>
			 <td width="100">Advance</td>
			 <td  align="right"><?  $poAdvance=poAdvance($re[posl]); echo number_format($poAdvance,2);?></td>
			</tr>
			<tr>
			 <td>Panelty</td>
			 <td></td>
			</tr>
			 <tr><td height="2" bgcolor="#0099FF" colspan="2"></td></tr>	
			 <tr>
                <td height="21">Payable at 
                  <?    echo myDate($re[activeDate]);?>
                </td>
                <td align="right"><? $payableAmount=$poAdvance; echo number_format($payableAmount,2);?></td></tr>
				
		  </table>
	</td>
	
      <td width="300">
		  <table width="100%" height="100%" cellspacing="5">
			<tr>
			 <td width="100">Advance</td>
			 <td  align="right"><?  $poAdvance=poAdvance($re[posl]); echo number_format($poAdvance,2);?></td>
			</tr>
			<tr>
			 <td>Panelty</td>
			 <td></td>
			</tr>

				<tr>
				  <td>Amount Paid</td>
				  <td align="right"><? 
	  if($popaymentPaid){
	  $popaymentPaid0=$popaymentPaid-$poAdvance;
	 // echo "** $popaymentPaid-$amountGt**";
	  if($popaymentPaid0>=0) $popaymentPaid0=$poAdvance;
		  else $popaymentPaid0=$popaymentPaid;
		  echo '(<font class=out>'.number_format($popaymentPaid0,2).'</font>)';		  
	  $popaymentPaid=$popaymentPaid-$poAdvance;		 
	  }
	  else echo "00,00";
	  ?></td>
				</tr>
			
			 <tr><td height="2" bgcolor="#0099FF" colspan="2"></td></tr>	
			 <? if($payableAmount==$popaymentPaid0){?>	
			<tr bgcolor="#FFFFCC"><th colspan="2"> Payment Completed</th></tr>
			<? } else {?>
			 <tr><td>Payable at <?    echo myDate($re[activeDate]);?></td><td align="right"><? $payableAmount=$poAdvance; echo number_format($payableAmount,2);?></td></tr>
			<? }?>
		  </table>
	</td>

	</tr>

<? }//advance?>	
<? include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT * from  `porder` WHERE posl='$re[posl]'";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

$totalAmount=0;
$i;
$poids="'0'";
$i=1;
$poidl=array();
 while($typel1= mysqli_fetch_array($sqlrunp))
{ $poids = $poids.",'".$typel1[poid]."'";
$itemp[$i]=$typel1[itemCode];
$itempRate[$i]=$typel1[rate];
$poidl[$i]=$typel1[poid];
$i++;
}



?>	
<? 
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp1 = "SELECT distinct sdate from  `poschedule` WHERE posl ='$re[posl]' AND invoice=1 ORDER by sdate ASC; ";
//echo $sqlp1;
$sqlrunp1= mysqli_query($db, $sqlp1);
$j=1;
$dd=array();
$dd[0]=$typel1[dstart];

 while($typel2= mysqli_fetch_array($sqlrunp1))
{
$dd[$j]=$typel2[sdate];
$j++;
} //
?>
<? for($i=1;$i<sizeof($dd);$i++){?>
<tr>
 <td width="100"> Payment <? echo $sl++; $amount=0;?>:  </td>
 <td width="300">
  <table width="100%" height="100%" cellspacing="5">

    <tr>
	  <td>Item Receivable</td>
	  <td align="right">
   <? 
 for($k=1;$k<=sizeof($poidl);$k++){
 if(scheduleReceiveperInvoice($poidl[$k],$dd[$i])){
 $amount=scheduleReceiveperInvoice($poidl[$k],$dd[$i])*$itempRate[$k];
 $amountGt+=$amount;
 }
 
 }
 echo number_format($amountGt,2);
 

 ?>
 </td>
 </tr>
    <tr>
	 <td width="100">Advance</td>
	 <td  align="right"><?  ${poAdvanceCut.$i} = poAdvanceCut($j,$poAdvance); if(${poAdvanceCut.$i}>0) echo '(<font class=out>'.number_format(${poAdvanceCut.$i},2).'</font>)'; else echo '00.00';?></td>
	</tr>
    <tr>
	 <td>Security</td>
	 <td></td>
	</tr>
    
    <tr>
	 <td>Panelty</td>
	 <td></td>
	</tr>
<? ${retentionAmount.$i}=retentionAmount($amountGt,$re[posl]);
if(${retentionAmount.$i}){
?>	
    <tr>
	 <td>Retention</td>
	 <td align="right"><?  if(${retentionAmount.$i}>0) echo '(<font class=out>'.number_format(${retentionAmount.$i},2).'</font>)'; else echo '00.00';?></td>
	</tr> 
<? }?>	
 <tr><td height="2" bgcolor="#0099FF" colspan="2"></td></tr>	
 <tr><td>Payable at <?    echo myDate($dd[$i]);?></td><td align="right">
 <? $payableAmount=$amountGt-${poAdvanceCut.$i}-${retentionAmount.$i}; 
 $payableAmountTotal+=$payableAmount;
 echo number_format($payableAmount,2);?></td></tr>
   </table>

</td>
<? $amount=0;
$amountGt=0;?>
 <td width="300">
  <table width="100%" height="100%" cellspacing="2">

    <tr>
	  <td>Item Received</td>
	  <td align="right">
   <? 
 for($k=1;$k<=sizeof($poidl);$k++){
 if(scheduleReceiveperInvoice($poidl[$k],$dd[$i])){
 $amount=scheduleReceiveperInvoice($poidl[$k],$dd[$i])*$itempRate[$k];
 $amountGt+=$amount;
 } 
 }
// echo number_format($amountGt,2);
if($actualReceivePO>0){
  ${amountRec.$i}=$actualReceivePO-$amountGt;
  if(${amountRec.$i}>0)
  ${amountRec.$i}=$amountGt;
  else ${amountRec.$i}=$actualReceivePO;
  echo number_format(${amountRec.$i},2);
  $actualReceivePO=$actualReceivePO-$amountGt;
  }
  else echo '00.00';
 ?>
 </td>
 </tr>
    <tr>
	 <td width="100">Advance</td>
	 <td  align="right"><?  ${poAdvanceCut.$i} = poAdvanceCut($j,$poAdvance); if(${poAdvanceCut.$i}>0) echo '(<font class=out>'.number_format(${poAdvanceCut.$i},2).'</font>)'; else echo '00.00';?></td>
	</tr>
    <tr>
	 <td>Security</td>
	 <td></td>
	</tr>
    
    <tr>
	 <td>Panelty</td>
	 <td></td>
	</tr>

<? ${retentionAmount.$i}=retentionAmount($amountGt,$re[posl]);
if(${retentionAmount.$i}){
?>	
    <tr>
	 <td>Retention</td>
	 <td align="right"><?  if(${retentionAmount.$i}>0) echo '(<font class=out>'.number_format(${retentionAmount.$i},2).'</font>)'; else echo '00.00';?></td>
	</tr> 
<? }?>	
	<tr>
	  <td>Amount Paid</td>
	  <td align="right"><? 
	  if($popaymentPaid>0){
	  ${popaymentPaid.$i}=$popaymentPaid-$amountGt;
	 // echo "** $popaymentPaid-$amountGt**";
	  if(${popaymentPaid.$i}>=0) ${popaymentPaid.$i}=$amountGt;
		  else ${popaymentPaid.$i}=$popaymentPaid;
		 echo '(<font class=out>'.number_format(${popaymentPaid.$i},2).'</font>)';
		$popaymentPaid=$popaymentPaid-$amountGt;		 		  
	  }
	  else echo "00.00";
	  ?></td>
	</tr>
 <tr><td height="2" bgcolor="#0099FF" colspan="2"></td></tr>
<?  if($mdata=PO_maturityDate($re[posl], $payableAmountTotal,$p)){
$payableAmount=$amountGt-${poAdvanceCut.$i}-${retentionAmount.$i};
 if($payableAmount==${popaymentPaid.$i}){?>
 <tr bgcolor="#FFFFCC"><th colspan="2"> Payment Completed</th></tr>
 <? }
 else {
?>
 <tr><td>Payable at <? 

    echo myDate($mdata);?></td><td align="right"><?  echo number_format($payableAmount,2);?></td></tr>
<? }
 }//else
?>	
   </table>

</td>

</tr>
 <? $amount=0;
$amountGt=0; }?>
</table>	
	
	</td>	
  </tr>
<? $bg++; }
}//paid?>
</table>
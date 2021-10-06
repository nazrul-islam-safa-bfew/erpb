<form name="searchBy" action="./index.php?keyword=mdvendor+payment" method="post">

<table width="600" align="center" bgcolor="#CEEFFF">
 <tr>
   <th width="200">Select Vendor</th>
 <td colspan="3">
 <!-- <select name="vid" onChange="location.href='index.php?keyword=vendor+payment+report&vid='+searchBy.vid.options[document.searchBy.vid.selectedIndex].value";>-->
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
<td rowspan="2"><input type="submit" name="search" value="Search" style="height:50px;width:100"></td>

 </tr>
  <tr>
   <th width="200">Select Project</th>
 <td colspan="3">
 <!-- <select name="pcode" onChange="location.href='index.php?keyword=vendor+payment+report&pcode='+searchBy.pcode.options[document.searchBy.pcode.selectedIndex].value";>-->
<select name="pcode">
<?php if(!$loginProject){ ?>
 <option value="">All Project</option>
<?
}
	include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 
$sqlp = "SELECT `pcode`,pname from `project` ORDER by pcode ASC";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

if(!$loginProject)
 while($typel= mysqli_fetch_array($sqlrunp))
{
	 echo "<option value='".$typel[pcode]."'";
	 if($pcode==$typel[pcode])  echo " SELECTED";
	 echo ">$typel[pcode]--$typel[pname]</option>  ";
 }
 else
 {
	while($typel= mysqli_fetch_array($sqlrunp))
		{
			if($loginProject==$typel[pcode])
			{
				 echo "<option value='".$loginProject."'";
					if($pcode==$loginProject)  echo " SELECTED";
				 echo ">$typel[pcode]--$typel[pname]</option>  ";
			}
		}
 }
?>
	</select>
</td>

 </tr>
</table>
</form>
<? if($search){?>
<table align="center" width="100%" border="3"  bordercolor="CC9999" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td align="right" valign="top" colspan="5"><font class='englishhead'>Vendore Payment Report</font></td>
</tr>
<tr bgcolor="#FFCCCC">
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
 $sql="select distinct posl,vid,activeDate,potype,location from `porder` WHERE".
  "  location LIKE '".$pcode."' AND vid LIKE '$vid' AND posl NOT LIKE 'EP_%'". 
  " AND status >=1 order by vid,poid ASC ";    

//echo $sql;
  $sqlQ=mysqli_query($db, $sql);
  $i=1;
  $bg=1;
  while($re=mysqli_fetch_array($sqlQ))
  { $sl=1;
    $potype=$re[potype]; 
	$project=$re[location]; 
  if(poFullPaid($re[posl])){
 $poAdvance=0;
  $payableAmountTotal=0;
  $actualReceivePO=0;
$popaymentPaid=0;  
$payableAmount=0;
?>

  <tr>
	<td colspan="3">
	<table width="100%" border="1" bordercolor="#CCCCCC" cellpadding="2" cellspacing="0"  style="border-collapse:collapse">
  <tr <? if($bg%2==0) echo "bgcolor=#F4F4F4";?> >
    <td valign="top" colspan="3" >
	<a href="./planningDep/printpurchaseOrder1.php?posl=<? echo $re[posl]?>" target="_blank"><? echo viewPosl($re[posl]);?></a>
	 <? echo '     <b>'.vName($re[vid]).'</b>;'; ?>
	<? 
	echo '   Total PO Amount Tk. '.number_format(poTotalAmount($re[posl]),2);
	?>
	<? $exp=explode('_',$re[posl]);
 $p=$exp[1];
 if($potype=='1')$actualReceivePO = actualReceivePO($re[posl],$p);
 if($potype=='3')$actualReceivePO = subWorkTotalReceive_Po($re[posl]); 
//echo "actualReceivePO=$actualReceivePO";
  $popaymentPaid=popaymentPaid($re[posl]);
//  echo "++popaymentPaid=$popaymentPaid<br>";
  ?></td>
  </tr>	
<? if($potype=='1')
{?>  
<? if(poAdvance($re[posl])){?>
	<tr>
	  <td width="100">Payment <? echo $sl++;?>: </td>
      <td width="300">
		  <table width="100%" height="100%" cellspacing="5">
			<tr>
			 <td >Advance Payable</td>
			 <td  align="right"><?  $poAdvance=poAdvance($re[posl]);
			  echo '(<font class=out>'.number_format($poAdvance,2).'</font>)';?></td>
			</tr>
			<!--
			<tr>
			 <td>Panelty</td>
			 <td></td>
			</tr>
			-->
			 <tr><td height="2" bgcolor="#0099FF" colspan="2"></td></tr>	
			 <tr>
                <td height="21">Payable at 
                  <?    echo myDate($re[activeDate]);?>
                </td>
                <td align="right"><? $payableAmount=$poAdvance; 
				echo '(<font class=out>'.number_format($payableAmount,2).'</font>)';?></td>
				</tr>
				
		  </table>
	</td>
	
      <td width="300">
		  <table width="100%" height="100%" cellspacing="5">
			<!--
			<tr>
			 <td width="100">Advance Paid</td>
			 <td  align="right"><?  $poAdvance=poAdvance($re[posl]); echo number_format($poAdvance,2);?></td>
			</tr>
			-->
			<!--
			<tr>
			 <td>Panelty</td>
			 <td></td>
			</tr>
            -->
				<tr>
				  <td>Advance Paid</td>
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
			 <tr><td>Matured on <?    echo myDate($re[activeDate]);?></td>
			 <td align="right"><? //$payableAmount=$poAdvance;
			 $payableAmount=$payableAmount-$popaymentPaid0;
			  echo '(<font class=out>'.number_format($payableAmount,2).'</font>)';?>
			 </td></tr>
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
	 
$sqlp1 = "SELECT distinct sdate from  `poschedule` WHERE posl='$re[posl]' AND invoice=1 ORDER by sdate ASC; ";
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
<? for($i=1;$i<sizeof($dd);$i++){
$amountGtp=0;
?>
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
 
${amountGt.$i}=$amountGt;
 ?>
 </td>
 </tr>
 <?  ${poAdvanceCut.$i} = poAdvanceCut($j,$poAdvance); 
		 if(${poAdvanceCut.$i}>0) 
		 {
		 ?>
    <tr>
	 <td >Advance Adjustment</td>
	 <td  align="right"><? echo '(<font class=out>'.number_format(${poAdvanceCut.$i},2).'</font>)'; ?>
	 </td>
	</tr>
	<? }?>
	<!--
    <tr>
	 <td>Security Amount</td>
	 <td></td>
	</tr>

    <tr>
	 <td>Panelty Amount</td>
	 <td></td>
	</tr>
	    -->
<? ${retentionAmount.$i}=retentionAmount($amountGt,$re[posl]);
if(${retentionAmount.$i}){
?>	
    <tr>
	 <td>Retention Amount</td>
	 <td align="right"><?  if(${retentionAmount.$i}>0) 
	 echo '(<font class=out>'.number_format(${retentionAmount.$i},2).'</font>)';
	 else echo '00.00';?>
	 </td>
	</tr> 
<? }?>	
 <tr><td height="2" bgcolor="#0099FF" colspan="2"></td></tr>	
 <tr><td>Payable at <?    echo myDate($dd[$i]);?></td><td align="right">
 <? $payableAmount=$amountGt-${poAdvanceCut.$i}-${retentionAmount.$i}; 
 $payableAmountTotal+=$payableAmount;
 echo '(<font class=out>'.number_format($payableAmount,2).'</font>)';?></td></tr>
   </table>

</td>
<? $amount=0;
$amountGt=0;
${popaymentPaid.$i}=0;?>
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
 //echo number_format($amountGt,2).'***'.number_format($actualReceivePO,2).'--';
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
 <?  ${poAdvanceCut.$i} = poAdvanceCut($j,$poAdvance);
	  if(${poAdvanceCut.$i}>0)
	  {
	  
	  ?>
    <tr>
	 <td >Advance Adjusted</td>
 <td  align="right"><? 
	 if(${poAdvanceCut.$i}==$popaymentPaid0)
	  echo '(<font class=out>'.number_format(${poAdvanceCut.$i},2).'</font>)';
	  else echo '(<font class=out>'.number_format($popaymentPaid0,2).'</font>)';
	   ?>
	  
	  </td>
	</tr>
	<? }?>
	<!--
    <tr>
	 <td>Security Received</td>
	 <td></td>
	</tr>
   
    <tr>
	 <td>Panelty Adjusted</td>
	 <td></td>
	</tr>
 -->
<? ${retentionAmount.$i}=retentionAmount($amountGt,$re[posl]);
if(${retentionAmount.$i}){
?>	
    <tr>
	 <td>Retention Adjusted</td>
	 <td align="right"><?  if(${retentionAmount.$i}>0) 
	 echo '(<font class=out>'.number_format(${retentionAmount.$i},2).'</font>)'; 
	 else echo '00.00';?></td>
	</tr> 
<? }?>	
<?
$payableAmount=$amountGt-${poAdvanceCut.$i}-${retentionAmount.$i};
 $mdata=PO_maturityDate($re[posl], $payableAmountTotal,$p);
//echo "<br>mdata=$mdata<br>";
if($i>=1){
$m=$i-1;
$amountGtp=0;
$amountGtp=${amountGt.$m};
if($mdata=='') $mdata1=todat();
else $mdata1=$mdata;
//echo ">>".todat();
$overPayment=overPayment($mdata1,$re[posl]);
if($overPayment)$overPayment=$overPayment-$amountGtp;
$popaymentPaid=$popaymentPaid-$overPayment;
}
else $overPayment=overPayment($mdata,$re[posl]);
//echo "<br>$i===overPayment=$overPayment-$amountGtp<br>";

if($overPayment>0){
if($popaymentPaid0){$overPayment=$overPayment-$popaymentPaid0;
$popaymentPaid0=0;
}
?>
	<tr bgcolor="#FF0000" class="outw">
	  <td>Paid before Maturity</td>
	  <td align="right"><? 
		 echo number_format($overPayment,2);
		//$popaymentPaid=$popaymentPaid-$amountGt;		 		  	  
	  ?></td>
	</tr>
<? }?>	

	  <? 
	  if($popaymentPaid>0){
	  ${popaymentPaid.$i}=$popaymentPaid-$amountGt;
	 // echo "** $popaymentPaid-$amountGt**";
	  if(${popaymentPaid.$i}>=0) ${popaymentPaid.$i}=$amountGt;
		  else ${popaymentPaid.$i}=$popaymentPaid;
	if((${popaymentPaid.$i}-$overPayment)>0){
	  ?>
 	<tr>
	  <td>Paid after Maturity</td>
       <td align="right">
		  <? 
		 // echo "**${popaymentPaid.$i}-$overPayment**";
		  $paidAfterMaturity=${popaymentPaid.$i}-$overPayment;
		 // echo "** $paidAfterMaturity=${popaymentPaid.$i}-$overPayment**";
		   echo '(<font class=out>'.number_format($paidAfterMaturity,2).'</font>)';
			$popaymentPaid=$popaymentPaid-$amountGt;?>
	   </td>
	</tr>
	<? }
	 }?>
  <tr><td height="2" bgcolor="#0099FF" colspan="2"></td></tr>
<?  if($mdata=PO_maturityDate($re[posl], $payableAmountTotal,$p)){
$payableAmount=$amountGt-${poAdvanceCut.$i}-${retentionAmount.$i};
 if($payableAmount==${popaymentPaid.$i}){?>
 <tr bgcolor="#FFFFCC"><th colspan="2"> Payment Completed</th></tr>
 <? }
 else if(${amountRec.$i}>=$payableAmount){
?>
 <tr><td>Matured on <? 
  if(strtotime($dd[$i])>strtotime($mdata)){
 $mdata=$dd[$i];
 }

    echo myDate($mdata);?></td>
	<td align="right"><?  
	$payableAmount_temp=$payableAmount-${popaymentPaid.$i};
	 echo '(<font class=out>'.number_format($payableAmount_temp,2).'</font>)';?>
	 </td>
	 </tr>
	
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
<?
}//if PO
elseif($potype=='2') {include('./managingDirector/eqvendorPayment.php');}
elseif($potype=='3') {include('./managingDirector/subvendorPayment.php');}
 $bg++; }
}//paid?>

</table>
<? }//search?>
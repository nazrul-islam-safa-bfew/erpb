<? if($loginProject=='000'){?>
<table   width="600" align="center" border="2" bordercolor="#999999" cellspacing="0" cellpadding="5" style="border-collapse:collapse">
 <tr bgcolor="#EEEEEE">
   <th>Purchase Order SL</th>
   <th>PO Total Amount (Tk.)</th>   
   <th>Material/Service received (Tk.)</th>
   <th>Amount Paid (Tk.)</th>
   <th>Payable Amount (Tk.)</th>   
   <th>Current Amount (Tk.)</th>   
 </tr>
 <?
include("./includes/config.inc.php");

$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
if($loginProject AND $vid){

$sqlp = "SELECT * from `popayments` WHERE 
(posl LIKE 'PO_".$exfor."_______$vid' 
OR posl LIKE 'EQ_".$exfor."_______$vid' 
OR posl LIKE 'EQP_".$exfor."_______$vid' ) 
AND (paidAmount < totalAmount) order by popID ASC ";

//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

$i=1;
while($re=mysqli_fetch_array($sqlrunp)){
$potype=poType($re[posl]);
//echo "** potype=$potype **";
$t=explode('_',$re[posl]);
$receiveAmount=0;
if($potype==1) $receiveAmount=poTotalreceive($re[posl],$t[1]);
if($potype==2) $receiveAmount=eqpoActualReceiveAmount($re[posl]);
if($potype==3) $receiveAmount=subWorkTotalReceive_Po($re[posl]);
if($potype==4) $receiveAmount=eqPurchaseReceive($re[posl]);
$paid=poPaidAmount($re[posl]);
?>
<? ${remainAmount.$i}=round($re[totalAmount]-$re[paidAmount],2);?>
 <tr>
   <td align="center">
   <a target="_blank" href="./planningDep/printpurchaseOrder1.php?posl=<? echo $re[posl];?>">
   <? echo viewPosl($re[posl]);?></a>
   <input type="hidden" name="posl<? echo $i;?>" value="<? echo $re[posl];?>">  </td>
   <td align="right"><? echo number_format($re[totalAmount],2);?> </td>   
   <td align="right"><? echo number_format($receiveAmount,2);?> </td>
   <td align="right"><? echo number_format($paid,2);?> </td>  
   <td align="right"><? ${poPayableAmount.$i}=poPayableAmount($re[posl],$todat,$re[totalAmount],$paid,$exfor,$potype); 
   ${poPayableAmount.$i}=round(${poPayableAmount.$i},2);
   if(${poPayableAmount.$i}>$re[totalAmount])  ${poPayableAmount.$i}=$re[totalAmount];
   
	echo number_format(${poPayableAmount.$i},2);
	if($potype=='4') ${poPayableAmount.$i}=$re[totalAmount];
	?></td> 
   <td align="right">
 
<!--   <input type="text" size="10" alt="cal"  name="amountPaid<? echo $i;?>"   style="text-align:right"  
   onBlur="if(<? echo 'amountPaid'.$i;?>.value > <? echo ${remainAmount.$i};?>)
    {alert('Amount exceeds PO Total'); <? echo 'amountPaid'.$i;?>.value=0;}">  
-->
  
   
  <input type="text" size="10" alt="cal"  name="amountPaid<? echo $i;?>"    
  style="text-align:right"  <? if(${poPayableAmount.$i}<=0 )echo ' disabled ';?>
   onBlur="if(<? echo 'amountPaid'.$i;?>.value > <? echo round(${poPayableAmount.$i},2);?>)
    {alert('Amount exceeds PO Total'); <? echo 'amountPaid'.$i;?>.value=0;}" onchange="disableSave(this.form);" >  

  <!-- <input type="text" size="10" alt="cal"  name="amountPaid<? echo $i;?>"   style="text-align:right" >  -->
	  
   <input type="hidden" name="<? echo 'remainAmount'.$i;?>"  value="<? echo ${remainAmount.$i};?>">
    </td>
 </tr>
 <?
  	$paymentpototal+=${amountPaid.$i};
  $i++;} //while?>
  <input type="hidden" name="n" value="<? echo $i;?>">
    <tr>
    <td colspan="6" align="right" bgcolor="#FFFFCC"> 	<input type="text" readonly="" name="total" style=" border:0;background: #FFFFCC;text-align:right"></td>
 </tr>

  <tr>
    <td  align="center" colspan="3"><input type="button" value="calculate" name="calculate" onClick="calc(this.form);"></td>
      <td colspan="2" align="center"><input type="submit" value="Save" name="save" disabled="disabled"
	  onClick="if(checkrequired(payments)){payments.POpayment.value=1;payments.submit();}" >
	<input type="hidden" name="POpayment" value="0">
	<input type="hidden" name="btnvid" value="<? echo $vid;?>">	</td>
 </tr>
 <? }?>
 </table>
<? 
$paidAmount=$paymentpototal;
}
else{
?>

<table   width="600" align="center" border="2" bordercolor="#999999" cellspacing="0" cellpadding="5" style="border-collapse:collapse">
 <tr bgcolor="#EEEEEE">
   <th>Purchase Order SL</th>
   <th>PO Total Amount (Tk.)</th>   
   <th>Service received (Tk.)</th>
   <th>Amount Paid (Tk.)</th>
   <th>Current Payable (Tk.)</th>   
   <th>Current Amount (Tk.)</th>   
 </tr>
 <?
include("./includes/config.inc.php");

$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
if($loginProject AND $vid){
$sqlp = "SELECT * from `popayments` WHERE (posl LIKE 'PO_".$loginProject."_______$vid') AND (paidAmount < totalAmount) order by popID ASC ";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

$i=1;
while($re=mysqli_fetch_array($sqlrunp)){
$potype=poType($re[posl]);
$t=explode('_',$re[posl]);
if($potype==1) $receiveAmount=poTotalreceive($re[posl],$t[1]);
if($potype==2) $receiveAmount=eqpoActualReceiveAmount($re[posl]);
if($potype==3) $receiveAmount=subWorkTotalReceive_Po($re[posl]);
$paid=poPaidAmount($re[posl]);
?>
 <tr>
   <td align="center">
   <a target="_blank" href="./planningDep/printpurchaseOrder1.php?posl=<? echo $re[posl];?>">
   <? echo viewPosl($re[posl]);?></a>
   <input type="hidden" name="posl<? echo $i;?>" value="<? echo $re[posl];?>">  </td>
   <td align="right"><? echo number_format($re[totalAmount],2);?> </td>   
   <td align="right"><? echo number_format($receiveAmount,2);?> </td>
   <td align="right"><? echo number_format($paid,2);?> </td>   
   <td align="right"><? $currentPayable=foodinfAmount($re[totalAmount],$receiveAmount,$paid,$re[posl]); 
   $currentPayable=round($currentPayable,2);
   echo number_format($currentPayable,2);?> 
   <input type="hidden" name="currentPayable<? echo $i;?>" value="<? echo $currentPayable;?>">
   </td>      
   <td align="right">
   <input type="text" size="10" alt="cal"  name="amountPaid<? echo $i;?>" <? if($currentPayable<=0 )echo ' disabled ';?>   value="<? if($POpayment) echo ''; else echo ${amountPaid.$i};?>"  style="text-align:right"  
   onBlur="if(<? echo 'amountPaid'.$i;?>.value > <? echo $currentPayable;?>) {alert('Amount exceeds payable Amount'); <? echo 'amountPaid'.$i;?>.value=0;}" onchange="disableSave(this.form);">  
    </td>
 </tr>
 <?
  	$paymentpototal+=${amountPaid.$i};
  $i++;} //while?>
  <input type="hidden" name="n" value="<? echo $i;?>">
    <tr>
    <td colspan="6" align="right" bgcolor="#FFFFCC"> 	<input type="text" readonly="" name="total" style=" border:0;background: #FFFFCC;text-align:right"></td>
 </tr>

  <tr>
    <td  align="center" colspan="3"><input type="button" value="calculate" name="calculate" onClick="calc(this.form);"></td>
      <td colspan="2" align="center">	  
	<input type="button" value="Save" name="save" disabled="disabled"
		onClick="if(checkrequired(payments)) {
	payments.POpayment.value=1;
	payments.submit();}">
		  
	<input type="hidden" name="POpayment" value="0">
	<input type="hidden" name="btnvid" value="<? echo $vid;?>"></td>
 </tr>
 <? }?>
 </table>
<? 
$paidAmount=$paymentpototal;
}
?>

<table   width="600" align="center" border="2" bordercolor="#999999" cellspacing="0" cellpadding="2" style="border-collapse:collapse">
 <tr bgcolor="#EEEEEE">
   <th>Purchased Qty</th>
   <th>Item</th>
   <th>Unit Price</th>
   <th>Amount</th>
 </tr>
 <? 
include("./includes/config.inc.php");

$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
if($loginProject){
$sqlp = "SELECT poid,qty,itemCode,rate from `porder` WHERE posl LIKE 'EP_".$exfor."%' AND status='1' and qty>0 order by itemCode ASC ";
// echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
$i=1;
while($re=mysqli_fetch_array($sqlrunp)){
 $temp= itemDes($re[itemCode]);
 ?>
 <tr>
   <td style="	border-bottom: 0px;" >
   <!--<input type="checkbox" name="poqty<? echo $i;?>" value="<? echo $re[poid];?>" 
   onclick="payments.cpunitPrice<? echo $i;?>.value=divMe(examount<? echo $i;?>.value,<? echo $re[qty];?>);" />-->
   <input type="checkbox" name="poqty<? echo $i;?>" value="<? echo $re[poid];?>" 
   onclick="/*document.getElementById('txtHint<?php print $i; ?>').innerHTML=divMe(examount<? echo $i;?>.value,<? echo $re[qty];?>);*/" />
   <? echo $re[qty].' '.$temp[unit];	 ?>
   </td>
   <td style="	border-bottom: 0px;" width="150" align="center"><? echo $re[itemCode];?></td>

   <td style="	border-bottom: 0px;" align="right">
   <?


   if($re['rate'] AND $re[qty]) 
    {
       $cpunitPrice[$i]=$re['rate']*$re['qty']; 
       echo $re['rate'];
    }
    $extotal+=$re['rate']*$re[qty]; 
        
        
        ?>
		<div id="txtHint<?php print $i; 
    
    
    ?>"></div>
		<!--<input type="text" size="10"  name="cpunitPrice<? echo $i;?>" value="" readonly="" style=" border:0;background: #FFFFFF;text-align:right" >-->
		</td>
   <td style="	border-bottom: 0px;" align="right"><input type="text" size="10" alt="cal" onchange="disableSave(this.form);" name="examount<? echo $i;?>" value="<? echo $re['rate']*$re[qty];?>" style="text-align:right"
    onBlur="if(payments.poqty<? echo $i;?>.checked)payments.cpunitPrice<? echo $i;?>.value=divMe(examount<? echo $i;?>.value,<? echo $re[qty];?>);"  ></td>
 </tr>
 <tr bgcolor="#FFFFEE">
   <td colspan="5" style="	border-top: 0px;"><font class="out"><?    echo $temp[des].', '.$temp[spc];	?></font></td>
 </tr>
<? 
$i++;
}// while?>
  <tr>
    <td colspan="5" align="right" bgcolor="#FFFFCC">
	<input type="text" readonly="" name="total" id="total" style=" border:0;background: #FFFFCC;text-align:right">
	</td>
 </tr>
  <tr>
    <td colspan="2" align="center"><input type="button" value="calculate" name="calculate" onClick="calc(this.form);twoDigitConversation(this.form,'total');"></td>
    <td colspan="2" align="center"><input type="button" value="Paid" name="save" disabled="disabled" onClick="if(checkrequired(payments)){ payments.cashPurchase.value=1;payments.submit();}"></td>
	<input type="hidden" name="cashPurchase" value="0">
	<input type="hidden" name="calculate" value="1">
	<input type="hidden" name="n" value="<? echo $i;?>"	>
 </tr>
 <? }?>
 </table>

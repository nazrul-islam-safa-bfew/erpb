<table   width="600" align="center" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5" style="border-collapse:collapse">
 <tr bgcolor="#EEEEEE">
   <th>Purchase Order SL</th>
   <th>PO Total Amount (Tk.)</th>
   <th>Amount receivable (Tk.)</th>
 </tr>
 <?
include("./includes/config.inc.php");

$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
if($loginProject AND $vid){
$sqlp = "SELECT * from `popayments` WHERE posl LIKE 'PO_".$loginProject."_%_$vid'  order by popID ASC ";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

$i=1;
while($re=mysqli_fetch_array($sqlrunp)){

?>
 <tr>
   <td align="center"><? echo $re[posl];?>
   <input type="hidden" name="posl<? echo $i;?>" value="<? echo $re[posl];?>">
   </td>
   <td align="right"><? echo number_format($re[totalAmount],2);?> </td>
   <td align="right"><? echo number_format($re[paidAmount],2);?> </td>   
 </tr>
 <? 
 	$paymentpototal+=${amountPaid.$i};
 $i++;} //while?>
  <input type="hidden" name="n" value="<? echo $i;?>">
  <tr>
    <td colspan="3" align="right" bgcolor="#FFFFCC"> <?	 echo number_format($paymentpototal,2);?></td>
 </tr>

  <tr>
    <td  align="center" ><input type="submit" value="Calculate" name="POprepaymentcal"></td>
    <td  align="center"><input type="submit" value="Save" name="POprepayment1"  
	onClick="payments.POprepayment.value=1;payments.POprepaymentcal.value=0;payments.submit();" >
	<input type="hidden" name="POprepayment" value="0">
	</td>
 </tr>
 <? }?>
 </table>

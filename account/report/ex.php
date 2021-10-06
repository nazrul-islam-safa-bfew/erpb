
 
  <table   width="600" align="center" border="2" bordercolor="#999999" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
 <tr bgcolor="#EEEEEE">
   <th>Description</th>
   <th>GL Account</th>
   <th>Amount</th>
 </tr>

 <tr>
   <td><input type="text" size="30" name="exdes1" value="<? if($expencess) echo ''; else echo $exdes1;?>"></td>
   <td> <? 	 echo cp_selectAlist('account1',$loginProject,$account1);   ?>  </td>
   <td align="right"><input type="text" size="10"  name="examount1" alt="cal"  class="number" onchange="disableSave(this.form);"></td>
 </tr>
 <tr>
   <td><input type="text" size="30" name="exdes2" value="<? if($expencess) echo ''; else echo $exdes2;?>"  ></td>
   <td> <?  echo cp_selectAlist('account2',$loginProject,$account2); ?></td>
   <td align="right"><input type="text" size="10"  name="examount2" alt="cal"  class="number" onchange="disableSave(this.form);"></td>
 </tr>
  <tr>
    <td colspan="3" align="right" bgcolor="#FFFFCC">
	<input type="text" readonly="" name="total" style=" border:0;background: #FFFFCC;text-align:right" id="total">
	</td>
 </tr>
  <tr>
    <td colspan="1" align="center"><input type="button" value="calculate" name="calculate" onClick="calc(this.form);twoDigitConversation(this.form,'total');"></td>
    <td colspan="2" align="center"><input type="button" value="Save" disabled="disabled" name="save" 
	onClick="if(checkrequired(payments)) {
	payments.expencess.value=1;payments.calculate.value=0;payments.submit();}"></td>
	<input type="hidden" name="expencess" value="0">
	<input type="hidden" name="calculate" value="0">		
 </tr>
 </table>
<? 

$paidAmount=$extotal;
?>
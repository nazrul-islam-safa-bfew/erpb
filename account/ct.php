<table   width="600" align="center" border="2" bordercolor="#999999" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
 <tr bgcolor="#EEEEEE">
   <th>Description</th>
   <th>Amount</th>
 </tr>

 <tr>
   <td ><input type="text" size="30" name="exdes" value="" ></td>
   <td align="right"><input type="text" size="10" alt="cal"  name="examount" value="" class="number" onchange="disableSave(this.form);"></td>
 </tr>
 <tr>
    <td colspan="2" align="right" bgcolor="#FFFFCC">
	<input type="text" readonly="" name="total" id="total" style=" border:0;background: #FFFFCC;text-align:right">
	</td>
 </tr>
  <tr><td colspan="1" align="center"><input type="button" value="calculate" name="calculate" onClick="calc(this.form);twoDigitConversation(this.form,'total');"></td>
      <td align="center"><input type="button" value="Cash Tranfer" name="save" disabled="disabled" onClick="if(checkrequired(payments)){payments.submit();}"> 
        <input type="hidden" name="cashTransfer" value="1">
	</td>
 </tr>
 </table>

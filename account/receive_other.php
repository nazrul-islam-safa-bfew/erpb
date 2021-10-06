<table   width="600" align="center" border="2" bordercolor="#999999" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
 <tr bgcolor="#EEEEEE">
   <th>Description</th>
   <th>Amount</th>
 </tr>

 <tr>
   <td><input type="text" size="30" name="reff" value="" ></td>
   <td align="right"><input type="text" size="10"  name="receiveAmount" value="" style="text-align:right" ></td>
 </tr>
  <tr>
      
    <td colspan="3" align="center"><input type="button" value="Cash Receive" name="cashR" onClick="if(checkrequired(receive)){receive.submit();}"> 
      <input type="hidden" name="othercashReceive" value="1">
	</td>
 </tr>
 </table>

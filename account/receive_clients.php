<table align="center" width="98%" class="ablue">
 <tr bgcolor="#0099FF">
   <td class="englishhead">Sl No.</td>
   <td class="englishhead" align="center">Date</td>  
   <td class="englishhead" align="center">Type</td>  
   <td class="englishhead" align="center">Invoice Total</td>   
   <td class="englishhead" align="center">Retention</td>   
   <td class="englishhead" align="center">Tax</td>   
   <td class="englishhead" align="center">VAT</td>      
   <td class="englishhead" align="center">Amount Receive</td>
 </tr>
<? include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
	$sql="SELECT * from invoice where invoiceLocation='$client' and invoiceStatus='1'";
// 		 echo $sql;
	$sqlQ=mysqli_query($db, $sql);
	$i=1;
	while($in=mysqli_fetch_array($sqlQ)){?>
	 <tr <? if($in[invoiceNo]==$invoiceNo) echo "bgcolor=#FFFFCC";?> >
	   <td><? echo $in[invoiceNo];?>
	    <input type="hidden" name="reff<? echo $i;?>" value="<? echo $in[invoiceNo];?>">
	   </td>	   
	   <td align="center"><? echo myDate($in[invoiceDate]);?></td>	   
		<td align="right"><? echo viewInvoiceType($in[invoiceType]);?></td>	
	   <td align="center"><? echo number_format($in[subInvoice],2);?></font></td>	  
	   <td align="center"><font class="out">(<? echo number_format($in[retention],2);?>)</font></td>	  
	   <td align="center"><font class="out">(<? echo number_format($in[tax],2);?>)</font></td>	
	   <td align="center"><font class="out">(<? echo number_format($in[vat],2);?>)</font></td>	  			   
	   <td align="right">
			 <? ${remainAmount.$i}=$in[invoiceAmount];
	   echo number_format(${remainAmount.$i},2);?>
	   <input <? if(${receiveAmount.$i}) echo ' checked ';?> type="checkbox" name="receiveAmount<? echo $i;?>" value="<? echo ${remainAmount.$i};?>">
	   </td>  
	 </tr>
	 <tr><td colspan="10" height="1" bgcolor="#0099FF"></td></tr>
	<? 
		$totalAmount+=${receiveAmount.$i};
		$i++;
	}
	?>
    <tr>
    <td colspan="2" align="center"><input type="button" value="Save" name="cashReceive1" onClick="if(checkrequired(receive)){ receive.cashReceive.value=1;receive.submit();}"></td>	
    <td colspan="2" align="center"><input type="button" value="calculate" name="calculate" onClick="receive.cashReceive.value=0;receive.submit();"></td>
    <td align="right" colspan="4"><? echo number_format($totalAmount,2);?></td> 
	<input type="hidden" name="cashReceive" value="0">
	<input type="hidden" name="calculate" value="1">	
	<input type="hidden" name="n" value="<? echo $i;?>"	>
    </tr>	
</table>


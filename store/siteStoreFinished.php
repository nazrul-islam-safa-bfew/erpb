<? if($loginProject=='002'){?>
<table align="center" width="95%" border="3"  bordercolor="CC9999" cellpadding="2" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td colspan="8" align="right" valign="top"><font class='englishhead'>site store status</font></td>
</tr>
<tr >
 <th align="center" width="100" >IOW Code</th>
 <th align="center" >Item Description</th> 
 <th align="center" >Unit</th> 
 <th align="center" >Quantity</th>  
 <th align="center" >Rate</th>   
 <th align="center" >Amount</th>   
</tr>
<? $sql="SELECT itemCode,AVG(iowPrice) as iowPrice from iow where iowProjectCode='$loginProject' GROUP by itemCode";
echo $sql;
$sqlq=mysql_query($sql);
while($st=mysql_fetch_array($sqlq)){?>

<tr>
  <td ><? //echo $st[iowId]; 
  echo $st[itemCode];?></td>
  <td> <? $temp=itemDes($st[itemCode]);
 echo $temp[des].', '.$temp[spc];?></td>
</td>  
  <td align="center"><? echo $temp[unit];?></td>  
  <td align="right"> <?  $workshop_stock_athand=workshop_stock_athand($st[itemCode]);
  echo number_format($workshop_stock_athand);?></td>  
  <td align="right"><? echo number_format($st[iowPrice],2);?></td>  
  <td align="right"><? echo number_format($st[iowPrice]*$workshop_stock_athand,2);?></td>  
</tr>

<? $t=1;
$subtotal=$subtotal+$st[iowPrice]*$workshop_stock_athand;
}

?>
<? if($t){ $total=$total+$subtotal;?>
<tr>
<TD  align='right' bgcolor='#FFFFEE' colspan="6"> <? echo "Stock Value of <b><font color=#FF6666>Finished Products </font></b> is Taka: <b>"; echo number_format($subtotal,2);?></b></TD>
</tr >
<? }?>
<tr>
<TD  align='right' bgcolor='#FFFFDD' colspan="6"> <? echo "Total Stock Value Taka: <b>"; echo number_format($total,2);?></b></TD>
</tr >
</table>
<? } 


 else {?>
<table align="center" width="95%" border="3"  bordercolor="CC9999" cellpadding="2" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td colspan="8" align="right" valign="top"><font class='englishhead'>site store status</font></td>
</tr>
<tr >
 <th align="center" width="100" >IOW Code</th>
 <th align="center" >Item Description</th> 
 <th align="center" >Unit</th> 
 <th align="center" >Quantity</th>  
 <th align="center" >Rate</th>   
 <th align="center" >Amount</th>   
</tr>
<? $sql="SELECT * from iow where iowProjectCode='$loginProject'";
//echo $sql;
$sqlq=mysql_query($sql);
while($st=mysql_fetch_array($sqlq)){?>
<tr>
  <td ><? //echo $st[iowId]; 
  echo $st[iowCode];
  //echo $st[itemCode];?></td>
  <td><? echo "$st[iowDes]";?></td>  
  <td align="center"><? echo $st[iowUnit];?></td>  
  <td align="right"> <?  $iowActualProgress =iowActualProgress(date('d/m/Y',strtotime($todat)),$st[iowId],0); 
  echo number_format($iowActualProgress,3);  ?></td>  
  <td align="right"><? echo number_format($st[iowPrice],2);?></td>  
  <td align="right"><? echo number_format($st[iowPrice]*$iowActualProgress,2);?></td>  
</tr>

<? $t=1;
$subtotal=$subtotal+$st[iowPrice]*$iowActualProgress;
}

?>
<? if($t){ $total=$total+$subtotal;?>
<tr>
<TD  align='right' bgcolor='#FFFFEE' colspan="6"> <? echo "Stock Value of <b><font color=#FF6666>Finished Products </font></b> is Taka: <b>"; echo number_format($subtotal,2);?></b></TD>
</tr >
<? }?>
<tr>
<TD  align='right' bgcolor='#FFFFDD' colspan="6"> <? echo "Total Stock Value Taka: <b>"; echo number_format($total,2);?></b></TD>
</tr >
</table>
<? }?>
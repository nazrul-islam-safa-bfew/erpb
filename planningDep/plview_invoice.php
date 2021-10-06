<? 
if($d==1){
include("./includes/config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 
	$sql="DELETE from invoice where invoiceNo='$invoiceNo'";
		// echo $sql;
	$sqlQ=mysql_query($sql);
	}
?>

<table align="center" width="90%" border="1" bordercolor="#0099FF" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
 <tr bgcolor="#0099FF">
   <th>Project</th>
   <th>Invoice No</th>
   <th>Invoice Amount</th>
   <th>Invoice Date</th>   
   <th>Invoice Status</th>      
 </tr>
<? include("./includes/config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 
	$sql="SELECT * from invoice";
		 //echo $sql;
	$sqlQ=mysql_query($sql);
	while($in=mysql_fetch_array($sqlQ)){?>
	 <tr <? if($in[invoiceNo]==$invoiceNo) echo "bgcolor=#FFFFCC";?> >
	   <td><? echo $in[invoiceLocation];?></td>
	   <td><a href="./index.php?keyword=plview+invoice&invoiceNo=<? echo $in[invoiceNo];?>"><? echo $in[invoiceNo];?></a></td>	   
	   <td><? echo $in[invoiceAmount];?></td>	   
	   <td><? echo myDate($in[edate]);?></td>	   	 
	   <td><? echo viewInvoiceStatus($in[invoiceStatus]);
	          if($in[invoiceStatus]==0) echo "<a href=./index.php?keyword=plview+invoice&invoiceNo=7$in[invoiceNo]&d=1> <font color=#ff0000> DELETE</font></a>";
			  ?>
	   </td>	   	 	     
	 </tr>
	
	<? } ?>
 
</table>


<br><br><br>
<? if($invoiceNo) {?>
<form name="as" action="./project/invoice.sql.php?invoiceNo=<? echo $invoiceNo?>" method="post">
<table width="100%" border="1" bordercolor="#999999" cellpadding="0"  cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#DDDDDD">
  <th> IOW CODE</th>
  <th> Description</th>  
  <th> Total Qty</th>    
  <th> Invoiced Qty</th>    
  <th> Qty Completed</th>    
  <th> Invoice Qty</th>    
  <th> Rate</th>    
  <th> Amount</th>    
</tr>
<?

include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

	$sql="SELECT * FROM `invoicedetail` WHERE invoicedetail.invoiceNo='$invoiceNo' ";
	//echo $sql;
$sqlrunp= mysql_query($sql);
$i=1;
while($in=mysql_fetch_array($sqlrunp)){
$sql1="SELECT * FROM iow WHERE iowId=$in[iowId]";
$sql1q=mysql_query($sql1);
$iow=mysql_fetch_array($sql1q);
?>
<tr>
  <td bgcolor="#eeeeee"> <? echo $iow[iowCode];?></td>
  <td> <? echo $iow[iowDes];?></td>

  <td align="right"> <? 
  if($iow[iowUnit]!='L.S' AND $iow[iowUnit]!='LS' AND $iow[iowUnit]!='l.s' AND $iow[iowUnit]!='l.s')   
   echo $iow[iowQty];?>
    <? echo $iow[iowUnit];?></td>
  <td align="right"> <? //echo invoicedQty($iow[iowId]);?></td>    
  <td> <?  
    if($iow[iowUnit]=='L.S' OR $iow[iowUnit]=='LS' OR $iow[iowUnit]=='l.s' OR $iow[iowUnit]=='l.s')   
	echo iowActualProgress1($todate,$iow[iowId],1);
	else echo iowActualProgress($todate,$iow[iowId],1); ?></td>    
    <td align="center"><? echo $in[qty];?></td>    
  <td align="right"> <? echo number_format($iow[iowPrice],2);?> </td>
  <td align="right"> <?  $amount=$in[qty]*$in[rate];
  echo number_format($amount,2);?></td>    
</tr>
<? $i++;
$totalAmount=$totalAmount+$amount;
$amount=0;
}?>
<tr>
 <td colspan="4" align="center"></td>
 <td colspan="3" align="center"></td> 
 <td align="right"><? echo number_format($totalAmount,2);?></td>
</tr>
</table>
</form>
<? }?>
<? if($fromDate AND $toDate){
$i=0;
$sqlp = "SELECT * from `project` where status='0' ORDER by pcode ASC";
	//echo $sqlp;
	$sqlrunp= mysqli_query($db, $sqlp);
	
	 while($typel= mysqli_fetch_array($sqlrunp))
	{
	 $pcodeList[$i]=$typel[pcode];
	 $i++;
	 }
	 $pcodeListSize=sizeof($pcodeList);
?>
<table width="100%" border="1" bordercolor="#EEEEEE" cellpadding="5" cellspacing="0">
<tr>
 <td></td>
  <td colspan="2" align="center">Current Month</td>
  <td colspan="2" align="center">Range</td>
</tr>

<tr>
 <td bgcolor="#33FFCC">REVENUES</td> 
</tr>
<? 

 $fromDate=formatDate($fromDate,'Y-m-j');
 $toDate=formatDate($toDate,'Y-m-j'); 

 $fromDate1= date('Y-m-j',mktime(0, 0, 0, date("m",strtotime($toDate)), 1,   date("Y",strtotime($toDate))));
 $toDate1=$toDate;
 
 
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

  $sql="select * from `accounts` WHERE  accountType='21' ORDER by accountID ASC";

//echo $sql;
  $sqlQ=mysqli_query($db, $sql);
  $r=mysql_num_rows($sqlQ);
  while($re=mysqli_fetch_array($sqlQ)){
  if($re[accountID]=='6100000')
  {
	for($i=0;$i<$pcodeListSize;$i++)
	{
	$amount1=totalInvoiceAmount_date($pcodeList[$i], $fromDate1,$toDate1);
	$amount=totalInvoiceAmount_date($pcodeList[$i], $fromDate,$toDate);
//	echo "amount=$amount==$amount1<br>";
	
	$subtotalRevenues1+=$amount1;
	$subtotalRevenues+=$amount; 
	} 
	$totalRevenues1+=$subtotalRevenues1;
	$totalRevenues+=$subtotalRevenues; 
 }
else {$amount1=0;$amount=0;	}
  ?>
<tr>
 <td><? echo $re[accountID].' '.accountName($re[accountID]);?></td>
 <td align="right"><? echo number_format($subtotalRevenues1,2);?></td>
 <td>%</td>
 <td align="right"><? echo number_format($subtotalRevenues,2);?></td>
 <td>%</td>
</tr>  
<? $subtotalRevenues1=0;$subtotalRevenues=0;}?>
<tr bgcolor="#33FFCC">
 <td align="right">Total Revenues</td> 
 <td align="right"><? echo   number_format($totalRevenues1,2);?></td>
 <td></td>
  <td align="right"><? echo   number_format($totalRevenues,2);?></td>
 <td></td>  
</tr>
<tr><td height="20"></td></tr>
<tr bgcolor="#FFCCFF">
 <td >COST OF SALES</td> 
</tr>
<? 
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

  $sql="select * from `accounts` WHERE  accountType='23' ORDER by accountID ASC";

//echo $sql;


  $sqlQ=mysqli_query($db, $sql);
  $r=mysql_num_rows($sqlQ);
  while($re=mysqli_fetch_array($sqlQ)){
  if($re[accountID]=='6801000'){
	for($i=0;$i<$pcodeListSize;$i++)
	{
	$amount=total_mat_issueAmount_date($pcodeList[$i], $fromDate,$toDate);
	$subtotalCostofSales+=$amount;
	$amount0=0;
	
	$amount1=total_mat_issueAmount_date($pcodeList[$i], $fromDate1,$toDate1); 
	$subtotalCostofSales1+=$amount1;
	$amount1=0;
	
	} 
	//echo "$subtotalCostofSales=subtotalCostofSales1=$subtotalCostofSales1";
  }
  else if($re[accountID]=='6802000'){
	for($i=0;$i<$pcodeListSize;$i++)
	{  
	$amount=total_eq_issueAmount_date($pcodeList[$i], $fromDate,$toDate);
	$subtotalCostofSales+=$amount;
	$amount=0;	
	$amount1=total_eq_issueAmount_date($pcodeList[$i], $fromDate1,$toDate1);  
	$subtotalCostofSales1+=$amount1;
	$amount1=0;
	}
  }
  else if($re[accountID]=='6803000'){
	for($i=0;$i<$pcodeListSize;$i++)
	{
	$amount=total_sub_issueAmount_date($pcodeList[$i], $fromDate,$toDate);
	$subtotalCostofSales+=$amount;
	$amount=0;

	$amount1=total_sub_issueAmount_date($pcodeList[$i], $fromDate1,$toDate1);  
	$subtotalCostofSales1+=$amount1;
	$amount1=0;
	}
  }  
  else if($re[accountID]=='6804000'){
  $temp=getMonth_sd_ed( $fromDate,$toDate);
  $si=sizeof($temp);
	  for($j=1;$j<=$si;$j++){
		  for($i=0;$i<$pcodeListSize;$i++){
			  $fd=$temp[$j][0];
			  $td=$temp[$j][1];    
			  $subamount+=wagesAmount_date($pcodeList[$i],$fd,$td);
		  }//for
	  }
	  //echo "amount=$amount**<br>";
	  $subtotalCostofSales+=$subamount;
	  $subamount=0;

	  for($i=0;$i<$pcodeListSize;$i++){
	  $subamount1=wagesAmount_date($pcodeList[$i],$fromDate1,$toDate1);
	  
	  $subtotalCostofSales1+=$subamount1;
	  $amount1=0;
	  }
  }    
  else {$amount1=0;$amount=0;	}
  $totalCostofSales+=$subtotalCostofSales;
  $totalCostofSales1+=$subtotalCostofSales1;  
  ?>
<tr>
 <td><? echo $re[accountID].' '.accountName($re[accountID]);?></td>
 <td align="right"><? echo number_format($subtotalCostofSales1,2);$subtotalCostofSales1=0;?></td>
 <td>%</td>
 <td align="right"><? echo number_format($subtotalCostofSales,2); $subtotalCostofSales=0;?></td>
 <td>%</td>
</tr>  
<? }?>
<tr bgcolor="#FFCCFF">
 <td align="right">Total Cost of Sales</td> 
 <td align="right"><? echo   number_format($totalCostofSales1,2);?></td>
 <td></td>
  <td align="right"><? echo   number_format($totalCostofSales,2);?></td>
 <td></td>  
</tr>
<tr><td height="20"></td></tr>
<? 
$GrossProfit1=$totalRevenues1-$totalCostofSales1;
$GrossProfit=$totalRevenues-$totalCostofSales;
?>
<tr bgcolor="#FFFFCC" >
 <td>GROSS PROFIT</td> 
 <td align="right"><? echo   number_format($GrossProfit1,2);?></td>
 <td></td>
  <td align="right"><? echo   number_format($GrossProfit,2);?></td>
 <td></td>  
</tr>
<tr><td height="20"></td></tr>
<tr bgcolor="#99CCFF" >
 <td>EXPENSES</td> 
</tr>
<? 
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

  $sql="select * from `accounts` WHERE  accountType='24' ORDER by accountID ASC";

//echo $sql;
  $sqlQ=mysqli_query($db, $sql);
  $r=mysql_num_rows($sqlQ);
  while($re=mysqli_fetch_array($sqlQ)){
$subtotalExpenses1=0;
$subtotalExpenses=0;  

if($re[accountID]=='6901000'){ 
 for($i=0;$i<$pcodeListSize;$i++){
	$amount=total_salaryAmount_date($pcodeList[$i], $fromDate,$toDate);
	$amount1=total_salaryAmount_date($pcodeList[$i], $fromDate1,$toDate1);
	$subtotalExpenses1+=$amount1;
	$subtotalExpenses+=$amount;
	
	$amount=0;$amount1=0;	
	}//for
}  
elseif($re[accountID]=='6902000'){
 for($i=0;$i<$pcodeListSize;$i++){ 
	$amount=total_wagesAmount_date($pcodeList[$i], $fromDate,$toDate);
	$amount1=total_wagesAmount_date($pcodeList[$i], $fromDate1,$toDate1);
	$amount=0;$amount1=0;
	$subtotalExpenses1+=$amount1;
	$subtotalExpenses+=$amount;
		
  }//for
 }  
else {  
 for($i=0;$i<$pcodeListSize;$i++){ 
	$amount+=total_exAmount_date($pcodeList[$i], $fromDate,$toDate,$re[accountID]);
	$amount1+=total_exAmount_date($pcodeList[$i], $fromDate1,$toDate1,$re[accountID]);
	$subtotalExpenses1+=$amount1;
	$subtotalExpenses+=$amount;
	
	$amount=0;$amount1=0;
	}//for
}  
//echo $sql2;
$totalExpenses1+=$subtotalExpenses1;
$totalExpenses+=$subtotalExpenses;
  ?>
<tr>
 <td><? echo $re[accountID].' '.accountName($re[accountID]);?></td>
 <td align="right"><? echo number_format($subtotalExpenses1,2);?></td>
 <td>%</td>
 <td align="right"><? echo number_format($subtotalExpenses,2);?></td>
 <td>%</td>
</tr>  

<? $subtotalExpenses1=0;
$subtotalExpenses=0;
}?>
<tr bgcolor="#99CCFF">
 <td align="right">Total Expense</td>
 <td align="right"><? echo number_format($totalExpenses1,2);?></td>
 <td>%</td>
 <td align="right"><? echo number_format($totalExpenses,2);?></td>
 <td>%</td>
</tr>  
<tr><td height="20"></td></tr>
<? 
$netIncome1=$GrossProfit1-$totalExpenses1;
$netIncome=$GrossProfit-$totalExpenses;
?>
<tr  bgcolor="#FFFFCC">
 <td >NET PROFIT</td>
 <td align="right"><?
  echo number_format($netIncome1,2);?></td>
 <td>%</td>
 <td align="right"><? 
 echo number_format($netIncome,2);?></td>
 <td>%</td>
</tr>  

</table>
<? }//if($fromDate AND $toDate){?>
</form>

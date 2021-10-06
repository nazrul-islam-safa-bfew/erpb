<? 
set_time_limit(600);
 if($fromDate AND $toDate){
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
<div class="dialog">
<table  width="720" align="left" border="2" bordercolor="#CCCCFF" cellpadding="5" cellspacing="0"  style="border-collapse:collapse;font-size: 10px;" >
 <tr bgcolor="#EEEEFF">
   <th align="center" valign="top" width="70">Account ID</th>   
   <th align="center" valign="top" width="180">Description</th>  
   <th align="center" valign="top" width="150">Account Type</th>       
   <th align="right" valign="top" width="100">Debit Amount</th>   
   <th align="right" valign="top" width="100">Credit Amount</th> 
 </tr>
 <? 
 $fromDate=formatDate($fromDate,'Y-m-j');
 $toDate=formatDate($toDate,'Y-m-j');  
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
 ?>
 <? 
$sql="select * from `accounts` WHERE  accountType IN('16','19','12') ORDER by accountID ASC";
$i=1;
//echo $sql;
$sqlq=mysqli_query($db, $sql);
while($re=mysqli_fetch_array($sqlq)){
  $bg=" bgcolor=#F8F8F8";
 if(strtotime($fromDate)<=strtotime('2006-07-01')){ $baseOpening=baseOpening($re[accountID],'');}
  ?>
<tr <? if($i%2==0) echo $bg;?>>
	<td><? echo "$re[accountID]";?></td>
	<td><? echo accountName($re[accountID]);?></td>
	<td><? echo viewAccountType($re[accountID]);?></td> 
	<td align='right' >&nbsp;</td>
	<td align='right' ><?
	 $balance+=$baseOpening;
	 echo number_format($balance,2); $crAmount+=$balance;$balance=0;?></td>
</tr>
<? $i++;}//while re?>

<?  $sql="select * from `accounts` WHERE  accountType IN('100') ORDER by accountID ASC";
$c=1;
//echo $sql;
$sqlq=mysqli_query($db, $sql);
while($re=mysqli_fetch_array($sqlq)){
if($re[accountID]=='2401000'){
	for($i=0;$i<$pcodeListSize;$i++)
	{
	// if($fromDate<='2006-07-01'){ $baseOpening=baseOpening($ree[accountID],$pcodeList[$i]);}
	$mat_totalPaidAmount =mat_vanPayment($fromDate,$toDate,$pcodeList[$i]);
	$mat_TotalReceive= mat_po_Receive($fromDate,$toDate,$pcodeList[$i]);  
	$balance+=$mat_TotalReceive-$mat_totalPaidAmount;
	
	//echo "**balance=$balance**$pcodeList[$i]##<br>";
	}

  }//2401000
else if($re[accountID]=='2402000'){
	for($i=0;$i<$pcodeListSize;$i++)
	{
	$eq_TotalReceive=0;$eq_totalPaidAmount=0;
   $eq_totalPaidAmount =eq_vanPayment($fromDate,$toDate,$pcodeList[$i]);
   $eq_TotalReceive=total_eq_issueAmount_date($pcodeList[$i], $fromDate,$toDate);  
   $balance+=$eq_TotalReceive-$eq_totalPaidAmount;
   }
 }
else if($re[accountID]=='2403000'){
	for($i=0;$i<$pcodeListSize;$i++)
	{$sub_TotalReceive=0;
	$sub_totalPaidAmount=0;
   $sub_totalPaidAmount =sub_vanPayment($fromDate,$toDate,$pcodeList[$i]);
   $sub_TotalReceive=sub_po_Receive($fromDate,$toDate,$pcodeList[$i]);  
   $balance+=$sub_TotalReceive-$sub_totalPaidAmount;
   }
 } 
 else if($re[accountID]=='2404000'){
  $temp=getMonth_sd_ed( $fromDate,$toDate);
  $si=sizeof($temp);
 	for($i=0;$i<$pcodeListSize;$i++)
	{ $wages_totalPaidAmount=0;$wages_TotalReceive=0;
	  for($j=0;$j<=$si;$j++){
	  $fd=$temp[$j][0];
	  $td=$temp[$j][1];    
	  $wages_TotalReceive+=wagesAmount_date($pcodeList[$i],$fd,$td);
	  }
     $wages_totalPaidAmount=total_wagesAmount_date($pcodeList[$i],$fromDate,$toDate);
     $balance+=$wages_TotalReceive-$wages_totalPaidAmount;
	}//for
	$wagesDirectTotalCost=$wages_TotalReceive;
 }
 else if($re[accountID]=='2405000'){
  $temp=getMonth_sd_ed( $fromDate,$toDate);
 // print_r($temp);
  $si=sizeof($temp);
   	for($i=0;$i<$pcodeListSize;$i++)
	{$salary_TotalReceive=0;$salary_totalPaidAmount=0;
	  for($j=0;$j<=$si;$j++){
	  $fd=$temp[$j][0];
	  $td=$temp[$j][1];    
	  $salary_TotalReceive+=total_salaryReceived_date($pcodeList[$i],$fd,$td);
	  }
     $salary_totalPaidAmount=total_salaryPaid_date($pcodeList[$i],$fromDate,$toDate);
	$balance+=$salary_TotalReceive-$salary_totalPaidAmount;
	}//for pcode
 }

  //echo "$mat_TotalReceive-$mat_totalPaidAmount<br>";
  $bg=" bgcolor=#F8F8F8";
  ?>
<tr <? if($c%2==0) echo $bg;?>>
<td><? echo "$re[accountID]";?></td>
 <td><? echo accountName($re[accountID]);?></td>
  <td><? echo viewAccountType($re[accountID]);?></td> 
 <td align='right' >&nbsp;</td>
 <td align='right' ><? echo number_format($balance,2); $crAmount+=$balance;$balance=0;?></td>

</tr>
<? $c++;}//while re?>
<? 
 $sql="select * from `accounts` WHERE  accountType IN('5','8') ORDER by accountID ASC";
$i=1;
//echo $sql;
$sqlq=mysqli_query($db, $sql);
while($re=mysqli_fetch_array($sqlq)){
if($re[accountID]=='3301000' AND ($pcode=='004' OR $pcode=='1')){
  $total_equipment_value =total_equipment_value($fromDate,$toDate,'004');
  $balance=$total_equipment_value;
  }//3301000
if($re[accountID]=='3601000' AND ($pcode=='000' OR $pcode=='1')){
  $total_furniture_value =total_furniture_value($fromDate,$toDate,'000');
  $balance=$total_furniture_value;
  }//3301000
if($re[accountID]=='3900000' AND ($pcode=='000' OR $pcode=='1')){
  $total_tools_value =total_tools_value($fromDate,$toDate,'000');
  $balance=$total_tools_value;
  }//3301000
if($re[accountID]=='3804000' AND ($pcode=='000' OR $pcode=='1')){
  $total_officetools_value =total_officetools_value($fromDate,$toDate,'000');
  $balance=$total_officetools_value;
  }//3301000  
  
  $bg=" bgcolor=#F8F8F8";
  ?>
<tr <? if($i%2==0) echo $bg;?>>
<td><? echo "$re[accountID]";?></td>
 <td><? echo accountName($re[accountID]);?></td>
  <td><? echo viewAccountType($re[accountID]);?></td> 
 <td align='right' ><? echo number_format($balance,2); $crAmount+=$balance;$balance=0;?></td>
 <td align='right' >&nbsp;</td>
</tr>
<? $i++;
}//while re?>

<? 
for($i=0;$i<$pcodeListSize;$i++){$balance1=0;$balance2=0;
  $balance1=totalMaterialReceive($fromDate,$toDate,$pcodeList[$i]);
  $balance2=total_mat_issueAmount_date($pcodeList[$i], $fromDate,$toDate);
  $balance+=$balance1-$balance2;
}//for pcode
  ?>
<tr  >
<td><? echo "4701000";?></td>
 <td><? echo accountName('4701000');?></td>
  <td><? echo viewAccountType('4701000');?></td> 
 <td align='right' ><? echo number_format(abs($balance),2); $drAmount+=$balance; $balance=0;?></td>
 <td align='right' >&nbsp;</td>
</tr>
<?  $sql="select * from `accounts` WHERE  accountType IN('4') ORDER by accountID ASC";
$i=1;
//echo $sql;
$sqlq=mysqli_query($db, $sql);
while($re=mysqli_fetch_array($sqlq)){
  $bg=" bgcolor=#F8F8F8";
  ?>  
<? if($ree[accountID]=='5201000'){;}?>  
<tr <? if($i%2==0) echo $bg;?>>
<td><? echo "$re[accountID]";?></td>
 <td><? echo accountName($re[accountID]);?></td>
  <td><? echo viewAccountType($re[accountID]);?></td> 
 <td align='right' ><? echo number_format(abs($balance),2); $drAmount+=$balance;$balance=0;?></td>
 <td align='right' >&nbsp;</td>
</tr>
<? $i++;}//while re?>
<?  $sql="select * from `accounts` WHERE  accountType IN('0','3') ORDER by accountID ASC";
$i=1;
//echo $sql;
$sqlq=mysqli_query($db, $sql);
while($ree=mysqli_fetch_array($sqlq)){

	if($ree[accountID]=='5502000'){
		for($i=0;$i<$pcodeListSize;$i++){$balance1=0;$balance2=0;
		//$receiveCash=totalCT($fromDate,$toDate,$pcodeList[$i]);
		//$expenses=totalCP_site($fromDate,$toDate,$pcodeList[$i]);
		
		//$balance+=($receiveCash-$expenses);
		$balance+=cashonHand($pcodeList[$i],$fromDate,$toDate,'1');
		//echo '<br>'.$pcodeList[$i]."=".cashonHand($pcodeList[$i],$fromDate,$toDate,'1');
		}//for pcode
	}
	else{
		$sql="select SUM(paidAmount) as paidAmount from `purchase` WHERE 
		 paymentDate between '$fromDate' and '$toDate'  ";
	    if($ree[accountID]=='5501000')	$sql.=" AND account LIKE '5501000-000'";  
	    else 	$sql.=" AND account='$ree[accountID]'";  	 
		//echo "$sql<br>";
		$sqlQ=mysqli_query($db, $sql);
		
		$r=mysqli_fetch_array($sqlQ);
		$balance=$r[paidAmount];		
	}
	//if($balance){
	$bg=" bgcolor=#F8F8F8";
	?>
<tr <? if($i%2==0) echo $bg;?>>
	<td><? echo "$ree[accountID]";?></td>
	<td><? echo accountName($ree[accountID]);?></td>
	<td><? echo viewAccountType($ree[accountID]);?></td> 
	<? if($ree[accountID]=='5502000'){?>
	<td align="right"> <? echo number_format($balance,2);
	 $drAmount+=$balance; 	$balance=0; ?></td>
	<td  align='right' ></td>
	<? } else {?>
	<td> </td>
	<td  align='right' ><?
    if(strtotime($fromDate)<=strtotime('2006-07-01')){ $baseOpening=baseOpening($ree[accountID],'');}	
	$balance+=$baseOpening;
	 echo number_format($balance,2); 
	$crAmount+=$balance; $balance=0;?></td>
	<? }?>
</tr>
 <? $i++;}//while?>
 
<?  $sql="select * from `accounts` WHERE  accountType='23' ORDER by accountID ASC";
$c=1;
//echo $sql;
  $sqlQ=mysqli_query($db, $sql);
  $r=mysql_num_rows($sqlQ);
  while($re=mysqli_fetch_array($sqlQ)){
if($re[accountID]=='6801000')  
  {
	for($i=0;$i<$pcodeListSize;$i++){
	$balance+=total_mat_directissueAmount_date($pcodeList[$i], $fromDate,$toDate);
	$matDirectTotalCost=$balance;
	}//for pcode
  }
else if($re[accountID]=='6802000') { 
	for($i=0;$i<$pcodeListSize;$i++){
    $balance+=total_eq_direct_issueAmount_date($pcodeList[$i], $fromDate,$toDate);
	$eqDirectTotalCost=$balance;
	}//for pcode
	}
else if($re[accountID]=='6803000'){
	for($i=0;$i<$pcodeListSize;$i++){
	$balance+=sub_po_directReceive($fromDate,$toDate,$pcodeList[$i]); 
	$subDirectTotalCost=$balance;
	}//for pcode
}  
else if($re[accountID]=='6804000'){
/*	$balance=0;
	$temp=getMonth_sd_ed( $fromDate,$toDate);
	$si=sizeof($temp);
for($i=0;$i<$pcodeListSize;$i++){
	for($j=1;$j<=$si;$j++){
		$fd=$temp[$j][0];
		$td=$temp[$j][1];    
		$balance+=directwagesAmount_date($pcodeList[$i],$fd,$td);
	}
 $wagesDirectTotalCost=$balance;
 }//for pcode 
 */
$balance=$wagesDirectTotalCost;
}  
$bg=" bgcolor=#F8F8F8";
?>
<tr <? if($c%2==0) echo $bg;?>>
<td><? echo "$re[accountID]";?></td>
 <td><? echo accountName($re[accountID]);?></td>
  <td><? echo viewAccountType($re[accountID]);?></td> 
 <td align='right' ><? echo number_format(abs($balance),2); $drAmount+=$balance;$balance=0;?></td>
 <td align='right' >&nbsp;</td>
</tr>
<? $i++;}//while?>
<? 
$c=0;
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

  $sql="select * from `accounts` WHERE  accountType='24' ORDER by accountID ASC";

//echo $sql;
  $sqlQ=mysqli_query($db, $sql);
  $r=mysql_num_rows($sqlQ);
  while($re=mysqli_fetch_array($sqlQ)){

if($re[accountID]=='6901000'){ 
	for($i=0;$i<$pcodeListSize;$i++){
	$balance+=total_salaryAmount_date($pcodeList[$i], $fromDate,$toDate);
   }//for pcode
}  
elseif($re[accountID]=='6902000'){ 
	$balance=$wages_TotalReceive-$wagesDirectTotalCost;
	//echo "690200=$balance";
 }  
elseif($re[accountID]=='6902010'){ 
	for($i=0;$i<$pcodeListSize;$i++){
  $balanc+=total_mat_indirectissueAmount_date($pcodeList[$i], $fromDate,$toDate);
  }
 }  
 elseif($accountID=='6903010'){
	//echo "690310=$balance"; 
  $balance=$eq_TotalReceive-$eqDirectTotalCost;
 // echo "**$eqTotalCost-$eqDirectTotalCost***<br>";
  }
 elseif($accountID=='6903000'){
 //	echo "690300=$balance";
  $balance=$sub_TotalReceive-$subDirectTotalCost;
  }
else {  
	for($i=0;$i<$pcodeListSize;$i++){
	$balance+=total_exAmount_date($pcodeList[$i], $fromDate,$toDate,$re[accountID]);
	}//for pcode
}  
//echo $sql2;
//echo "$re[accountID]<br>";
?>

<? 
//if($balance){
$bg=" bgcolor=#F8F8F8";
?>
<tr <? if($c%2==0) echo $bg;?>>
 <td><? echo "$re[accountID]";?></td>
 <td><? echo accountName($re[accountID]);?></td>
 <td><? echo viewAccountType($re[accountID]);?></td> 
 <td align='right' ><? echo number_format($balance,2); $drAmount+=$balance; $balance=0;?></td>
 <td align='right' >&nbsp;</td>
</tr>

<?  
$amountDRt2=0; $amountCRt2=0;
 $i++;
 //}//balance
  }//while
?>

<tr><td colspan='8' height='3' bgcolor='#FFFFFF'></td></tr>
<tr><td colspan='8' height='1' bgcolor='#CCCCFF'></td></tr>
<tr><td colspan='8' height='3' bgcolor='#FFFFFF'></td></tr>
<tr><td colspan='8' height='1' bgcolor='#CCCCFF'></td></tr>

<tr bgcolor="#B8F3A9">
 <td colspan="2"></td>
 <td align="right"></td>
 <td align="right"><?  echo number_format($drAmount,2);?></td>
 <td bgcolor="#FFFF66" align="right"><? echo number_format($crAmount,2);?></td>
</tr>  
<tr><td colspan='8' height='3' bgcolor='#FFFFFF'></td></tr>
<tr><td colspan='8' height='1' bgcolor='#CCCCFF'></td></tr>
<tr><td colspan='8' height='3' bgcolor='#FFFFFF'></td></tr>
<tr><td colspan='8' height='1' bgcolor='#CCCCFF'></td></tr>

</table>
</div>
<? }?>
<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
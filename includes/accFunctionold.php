<?php 
/*invoice complete date*/
function invoiceCompleteDate($in){
$sql="SELECT receiveDate from receivecash WHERE reff='$in'";
//echo "$sql<br>";
$sqlq=mysql_query($sql);
$r=mysql_fetch_array($sqlq);
return myDate($r[receiveDate]);
}

function salaryAdvance_balance($fromDate,$toDate){
	/* slalry advance balance*/	
$sql1="SELECT * from purchase 
WHERE paymentDate  BETWEEN '$fromDate' AND '$toDate'  
AND paymentSL LIKE 'AS_%' Order by paymentDate ASC";
//echo $sql1;
$sqlq1=mysql_query($sql1);
while($st=mysql_fetch_array($sqlq1)){
$dr+=$st[paidAmount];
  }//while

$sql1="SELECT * from empsalaryadc 
WHERE pdate  BETWEEN '$fromDate' AND '$toDate'   
Order by pdate ASC";
//echo '<br>'.$sql1;
$sqlq1=mysql_query($sql1);
while($st=mysql_fetch_array($sqlq1)){
$cr+=$st[amount];
  }//while
return $dr-$cr;	
}


function balance_hcash($pcode, $fromDate,$toDate){
/*
  $sql="select * from `purchase` WHERE  paymentDate between '$fromDate' and '$toDate' 
  	    AND ((account='5501000-000' AND  exfor='$pcode' ) 
		OR (account='5501000-000' AND paymentSL like 'SP_%') 
		OR (account='5501000-000' AND paymentSL like 'WP_%'))
		 order by paymentDate ASC";  
		 
  $sqlQ=mysql_query($sql);
  while($re=mysql_fetch_array($sqlQ)){
  $temp=explode('_',$re[paymentSL]);
 if($temp[0]=="SP"){ $subAmount1+=sp_projectPaid($re[paymentSL],$pcode);   }
 else if($temp[0]=="WP" ){ $subAmount1+=mwp_projectPaid($re[paymentSL],$pcode);   } 
  else{ $subAmount1+=$re[paidAmount];}
}  //while


if($pcode=='000'){
  $sql="select * from `receivecash` WHERE  receiveDate between '$fromDate' and '$toDate' 
    AND receiveAccount='5501000'
    order by receiveDate ASC";  
}else {
  $sql="select * from `receivecash` WHERE  receiveDate between '$fromDate' and '$toDate' 
   AND  receiveFrom LIKE '%-$pcode' AND receiveAccount='5501000'
    order by receiveDate ASC";  
}
//echo "$sql<br>";
  $sqlQ=mysql_query($sql);
  while($re=mysql_fetch_array($sqlQ)){	$subReceiveAmount+=$re[receiveAmount];}  
 if($pcode=='000'){
$sql="select * from `ex130` WHERE  exdate between '$fromDate' and '$toDate' AND exgl='5501000' order by exDate ASC";  

//echo "$sql<br>";
  $sqlQ=mysql_query($sql);
  while($re=mysql_fetch_array($sqlQ)){$subExAmount+=$re[examount];}  
}//pcode
$drAmount=$subReceiveAmount;
$crAmount=$subAmount1;
return $drAmount-$crAmount;
*/
if($pcode==000){
  $sql="select * from `purchase` WHERE  paymentDate between '$fromDate' and '$toDate' 
       AND account='5501000-000' AND (paymentSL not LIKE 'ct_%') 
       order by paymentDate ASC";  
		 }
else{
  $sql="select * from `purchase` WHERE  paymentDate  between '$fromDate' and '$toDate' 
  	    AND ((account='5501000-000' AND  exfor='$pcode' ) 
		OR (account='5501000-000' AND paymentSL like 'SP_%') 
		OR (account='5501000-000' AND paymentSL like 'WP_%'))
		AND paymentSl not Like 'ct_%' 
		 order by paymentDate ASC";  	
}	
	$sqlQ=mysql_query($sql);
	$r=mysql_num_rows($sqlQ);
	$i=0;  
	$crAmount=0;
	$array_date=array();
	while($re=mysql_fetch_array($sqlQ)){
	$temp=explode('_',$re[paymentSL]);
	
	if($temp[0]=="SP" OR $temp[0]=="WP" ){
	if($temp[0]=="SP" )$paidAmount=sp_projectPaid($re[paymentSL],$pcode);
	else if($temp[0]=="WP")$paidAmount=mwp_projectPaid($re[paymentSL],$pcode);
	if($paidAmount){  
	$array_date[$i][3]=$paidAmount;
	$array_date[$i][4]=2;
	$i++;}//if($paidAmount)
	}
	else{
	$array_date[$i][3]=$re[paidAmount];
	$array_date[$i][4]=2;
	$i++; }
	
	}  
	/* cash transfer */
if($pcode=='000'){
   $sql2="select * from `ex130` WHERE  exDate   between '$fromDate' and '$toDate' 
        AND (paymentSL LIKE 'ct_%' OR paymentSL LIKE 'CT_%') 
  	    AND  (exgl='5501000-000' OR account='5501000-000')  
  	    order by exDate ASC";  
		$ckgl="5501000-000";
}
else {
   $sql2="select * from `ex130` WHERE  exDate   between '$fromDate' and '$toDate' 
        AND (paymentSL LIKE 'ct_%' OR paymentSL LIKE 'CT_%') 
  	    AND  ((exgl='5501000-000' OR account='5501000-000') AND 
		(exgl LIKE '%-$pcode' OR account LIKE '%-$pcode')) 
  	    order by exDate ASC";  
        //$ckgl="5502000-$pcode";
		$ckgl="5501000-000";		
}
//echo "$sql2<br>";
//echo "<br>$ckgl";
  $sqlQ=mysql_query($sql2);
  while($re=mysql_fetch_array($sqlQ)){
  $array_date[$i][3]=$re[examount];      
  if($re[exgl]==$ckgl) $array_date[$i][4]=1;  
   else  $array_date[$i][4]=2;          
  $i++;
  }//while
	
	/* edit for project receive*/
	
	if($pcode=='000'){
	$sql="select * from `receivecash` WHERE  receiveDate between '$fromDate' and '$toDate' 
	AND receiveAccount='5501000'
	order by receiveDate ASC";  
	}else {
	$sql="select * from `receivecash` WHERE  receiveDate between '$fromDate' and '$toDate' 
	AND  receiveFrom LIKE '%-$pcode' AND receiveAccount='5501000'
	order by receiveDate ASC";  
	}
	//echo "$sql<br>";
	$sqlQ=mysql_query($sql);
	$r=mysql_num_rows($sqlQ);
	$k=0;  
	$crAmount=0;
	while($re=mysql_fetch_array($sqlQ)){
	$array_date[$i][3]=$re[receiveAmount];
	$array_date[$i][4]=1;
	$i++;  
	}  
	//print_r($array_date);
	sort($array_date);
	$r=sizeof($array_date);
	
	for($i=0;$i<$r;$i++){
	if($array_date[$i][4]=='1'){$drAmount+=$array_date[$i][3]; }
	if($array_date[$i][4]=='2'){ $crAmount+=$array_date[$i][3];}
	}//for

return $drAmount-$crAmount;

}

function balance_t4($pcode,$accountID, $fromDate,$toDate){
$i=0;
if($pcode){	 
   $sql2="select * from `ex130` WHERE  exDate  between '$fromDate' and '$toDate' 
        AND (paymentSL LIKE 'ct_%' OR paymentSL LIKE 'CT_%')
  	    AND  (exgl='$accountID-$pcode' OR account='$accountID-$pcode') 
  	    order by exDate ASC";  
//echo "<br>$sql2<br>";
 $sqlQ=mysql_query($sql2);
  while($re=mysql_fetch_array($sqlQ)){
  $array_date[$i][3]=$re[examount];      
  if($re[exgl]=="$accountID-$pcode") $array_date[$i][4]=1;  
   else  $array_date[$i][4]=2;          
  $i++;
  }//while
    
 }//if
else{	 
   $sql2="select * from `ex130` WHERE  exDate between '$fromDate' and '$toDate'  
        AND (paymentSL LIKE 'ct_%' OR paymentSL LIKE 'CT_%') 
  	    AND (exgl='$accountID-%' OR account='$accountID-%') 
  	    order by exDate ASC";  
//echo "<br>$sql2<br>";
 $sqlQ=mysql_query($sql2);
  while($re=mysql_fetch_array($sqlQ)){
  $array_date[$i][3]=$re[examount];      
  if(substr($re[exgl],0,7)=="$accountID") $array_date[$i][4]=1;  
   else  $array_date[$i][4]=2;          
  $i++;
  }//while  
 }//else

  $r=sizeof($array_date); 
  for($i=0;$i<=$r;$i++){
   if($array_date[$i][4]==1) {  $drAmount+=$array_date[$i][3];}
   else if($array_date[$i][4]=='2') { $crAmount+=$array_date[$i][3];}
	}//for
	//echo "***** $drAmount-$crAmount; *********<br	>";
	return $drAmount-$crAmount;
	}
	
function balance_bank($pcode,$accountID, $fromDate,$toDate){
/*


*/
/*		$sql="select SUM(paidAmount) as paidAmount from `purchase` 
		WHERE  exFor='$pcode' AND paymentDate between '$fromDate' and '$toDate'
		AND paymentSL not LIKE 'SP_%' AND account='$accountID'";  	 
		//echo "$sql<br>";
		$sqlQ=mysql_query($sql);		
		$r=mysql_fetch_array($sqlQ);
		$paidAmount=$r[paidAmount];

		$sql1="select receiveAmount from `receivecash`
		WHERE receiveDate between '$fromDate' AND '$toDate' 
		AND receiveFrom ='$pcode' AND receiveAccount='$accountID' ";
		//echo $sql1.'<br>';
		//echo $sql1;
		$sqlq1=mysql_query($sql1);
		while($st=mysql_fetch_array($sqlq1)){$receiveAmount+=$st[receiveAmount];}
		//$receiveAmount=$st[receiveAmount];
		$balance=$receiveAmount-$paidAmount;
		//echo "<br>	$accountID===	$balance=$receiveAmount-$paidAmount; <br>";		
return $balance;
*/
if($pcode){
  $sql="select * from `purchase` WHERE   paymentDate between '$fromDate' and '$toDate' AND 
  	     account='$accountID' AND exfor='$pcode' AND paymentSL not LIKE 'CT_%' 
		 order by paymentDate ASC";  

//echo "$sql<br>";
  $sqlQ=mysql_query($sql);

$drAmount=0;
$crAmount=0;
$i=0;
  while($re=mysql_fetch_array($sqlQ)){
  $array_date[$i][3]=$re[paidAmount];      
  $array_date[$i][4]=2;        
  $i++;
  }//while

  $sql2="select * from `ex130` WHERE  exDate between '$fromDate' and '$toDate' 
        AND (paymentSL LIKE 'ct_%' OR paymentSL LIKE 'CT_%')
  	    AND  (exgl='$accountID' OR account='$accountID') 
  	    AND  (exgl LIKE '%-$pcode' OR account LIKE '%-$pcode') 		
		order by exDate ASC";  

//echo "$sql2<br>";
  $sqlQ=mysql_query($sql2);
  while($re=mysql_fetch_array($sqlQ)){
  $array_date[$i][3]=$re[examount];      
  if($re[exgl]==$accountID) $array_date[$i][4]=1;  
   else  $array_date[$i][4]=2;          
  $i++;
  }//while
  
$sql1="select * from `receivecash` WHERE receiveDate between '$fromDate' and '$toDate' 
       AND  receiveFrom LIKE '%-$pcode' AND receiveAccount='$accountID' ORDER by receiveDate ASC";
 //echo "<br>$sql1<br>";
//echo $sql1;
$sqlq1=mysql_query($sql1);
while($st=mysql_fetch_array($sqlq1)){
$array_date[$i][3]=$st[receiveAmount];
$array_date[$i][4]=1;
  $i++;
  }    
$r=sizeof($array_date);  
//print_r($array_date);
  for($i=0;$i<$r;$i++){
   if($array_date[$i][4]=='1') {  $drAmount+=$array_date[$i][3];}
   if($array_date[$i][4]=='2') { $crAmount+=$array_date[$i][3];}
	}//for
	
}
else {
  $sql="select * from `purchase` WHERE  paymentDate between '$fromDate' and '$toDate' AND 
  	     account='$accountID'  AND paymentSL not LIKE 'CT_%' 
		 order by paymentDate ASC";  

 //echo "$sql<br>";
  $sqlQ=mysql_query($sql);

$drAmount=0;
$crAmount=0;
$i=0;
  while($re=mysql_fetch_array($sqlQ)){
  $array_date[$i][3]=$re[paidAmount];      
  $array_date[$i][4]=2;        
  $i++;
  }//while

  $sql2="select * from `ex130` WHERE  exDate between '$fromDate' and '$toDate' 
        AND (paymentSL LIKE 'ct_%' OR paymentSL LIKE 'CT_%')
  	    AND  (exgl='$accountID' OR account='$accountID') 
  	    AND  (exgl LIKE '%' OR account LIKE '%') 		
		order by exDate ASC";  

//echo "$sql2<br>";
  $sqlQ=mysql_query($sql2);
  while($re=mysql_fetch_array($sqlQ)){
  $array_date[$i][3]=$re[examount];      
  if($re[exgl]==$accountID) $array_date[$i][4]=1;  
   else  $array_date[$i][4]=2;          
  $i++;
  }//while
  
$sql1="select * from `receivecash` WHERE receiveDate between '$fromDate' and '$toDate' 
       AND  receiveAccount='$accountID' ORDER by receiveDate ASC";
 //echo "<br>$sql1<br>";
//echo $sql1;
$sqlq1=mysql_query($sql1);
while($st=mysql_fetch_array($sqlq1)){
	$array_date[$i][3]=$st[receiveAmount];
	$array_date[$i][4]=1;
	$i++;
  }    
$r=sizeof($array_date);  
  for($i=0;$i<$r;$i++){
   if($array_date[$i][4]=='1') {  $drAmount+=$array_date[$i][3];}
   if($array_date[$i][4]=='2') { $crAmount+=$array_date[$i][3];}
	}//for
}	
return $drAmount-$crAmount;
}


function wagesPayable($pcode,$fromDate,$toDate){

$openingBalance=openingBalance('2404000',$fromDate,$pcode);
	
 $si=((strtotime($toDate)-strtotime($fromDate))/86400)+1;
$i=0;	
  for($j=0;$j<$si;$j++){
	$fd=date("Y-m-d",strtotime($fromDate)+(86400*$j));
	$td=$fd;    
	$wages_TotalReceive=wagesAmount_date($pcode,$fd,$td);
   if($wages_TotalReceive>0){	
	$amountReceive+=$wages_TotalReceive;  
	}//if($wages_TotalReceive>0)

  }
  
$sql1="select SUM(amount) as amount,pdate,paymentSL from `empsalary`
      WHERE pdate between '$fromDate' AND '$toDate' AND glCode LIKE '2404000-$pcode' GROUP by pdate";
 // echo $sql.'<br>';
//echo $sql1;
$sqlq1=mysql_query($sql1);
while($st=mysql_fetch_array($sqlq1)){
$amountPaid+=$st[amount];
  }
return $amountReceive-$amountPaid;
}
function wagesCostofsales($pcode,$fromDate,$toDate){

$openingBalance=openingBalance('2404000',$fromDate,$pcode);
	
 $si=((strtotime($toDate)-strtotime($fromDate))/86400)+1;
$i=0;	
  for($j=0;$j<$si;$j++){
	$fd=date("Y-m-d",strtotime($fromDate)+(86400*$j));
	$td=$fd;    
	$wages_TotalReceive=wagesAmount_date($pcode,$fd,$td);
   if($wages_TotalReceive>0){	
	$amountReceive+=$wages_TotalReceive;  
	}//if($wages_TotalReceive>0)

  }

return $amountReceive;
}
function salaryPayable($pcode,$fromDate,$toDate){

$openingBalance=openingBalance('2404000',$fromDate,$pcode);
	
 $si=((strtotime($toDate)-strtotime($fromDate))/86400)+1;
$i=0;	
  for($j=0;$j<$si;$j++){
	$fd=date("Y-m-d",strtotime($fromDate)+(86400*$j));
	$td=$fd;    
	$wages_TotalReceive=wagesAmount_date($pcode,$fd,$td);
   if($wages_TotalReceive>0){	
	$amountReceive+=$wages_TotalReceive;  
	}//if($wages_TotalReceive>0)

  }
  
$sql1="select SUM(amount) as amount,pdate,paymentSL from `empsalary`
      WHERE pdate between '$fromDate' AND '$toDate' AND glCode LIKE '6901000-$pcode' GROUP by pdate";
 // echo $sql.'<br>';
//echo $sql1;
$sqlq1=mysql_query($sql1);
while($st=mysql_fetch_array($sqlq1)){
$amountPaid+=$st[amount];
  }
return $amountReceive-$amountPaid;

}
function cashonBank($fromDate,$toDate){


$sql="select SUM(balance) as closingBalance from `accounts` 
 WHERE  accountID BETWEEN '5601001' AND '5609002'";  	 
		//echo "$sql<br>";
		$sqlQ=mysql_query($sql);
		$r=mysql_fetch_array($sqlQ);
		$closingBalance=$r[closingBalance];


$sql="select SUM(paidAmount) as paidAmount from `purchase` WHERE
   paymentDate between '$fromDate' and '$toDate' AND account BETWEEN '5601001' AND '5609002'";  	 
		//echo "$sql<br>";
		$sqlQ=mysql_query($sql);
		$r=mysql_fetch_array($sqlQ);
		$balance=$r[paidAmount];
		
$current=$closingBalance+$balance;		
		return $current;

}
function accountPayable($pcode,$fromDate,$toDate){
 $sql="select * from `accounts` WHERE  accountType IN('10') ORDER by accountID ASC";
$i=1;
//echo $sql;
$sqlq=mysql_query($sql);
while($re=mysql_fetch_array($sqlq)){
if($re[accountID]=='2401000'){
  $mat_totalPaidAmount =mat_vanPayment($fromDate,$toDate,$pcode);
  $mat_TotalReceive= mat_po_Receive($fromDate,$toDate,$pcode);  
  $balance=$mat_TotalReceive-$mat_totalPaidAmount;
  }//2401000
else if($re[accountID]=='2402000'){
   $eq_totalPaidAmount =eq_vanPayment($fromDate,$toDate,$pcode);
   $eq_TotalReceive=total_eq_issueAmount_date($pcode, $fromDate,$toDate);  
   $balance=$eq_TotalReceive-$eq_totalPaidAmount;
 }
else if($re[accountID]=='2403000'){
   $sub_totalPaidAmount =sub_vanPayment($fromDate,$toDate,$pcode);
   $sub_TotalReceive=sub_po_Receive($fromDate,$toDate,$pcode);  
   $balance=$sub_TotalReceive-$sub_totalPaidAmount;
 } 
 else if($re[accountID]=='2404000'){
  $temp=getMonth_sd_ed( $fromDate,$toDate);
  $si=sizeof($temp);
	  for($i=0;$i<=$si;$i++){
	  $fd=$temp[$i][0];
	  $td=$temp[$i][1];    
	  $wages_TotalReceive+=wagesAmount_date($pcode,$fd,$td);
	  }
     $wages_totalPaidAmount=total_wagesAmount_date($pcode,$fromDate,$toDate);
    
	$balance=$wages_TotalReceive-$wages_totalPaidAmount;
 }
 else if($re[accountID]=='2405000'){
  $temp=getMonth_sd_ed( $fromDate,$toDate);
 // print_r($temp);
  $si=sizeof($temp);
	  for($i=0;$i<=$si;$i++){
	  $fd=$temp[$i][0];
	  $td=$temp[$i][1];    
	  $wages_TotalReceive+=total_salaryReceived_date($pcode,$fd,$td);
	  }
     $wages_totalPaidAmount=total_salaryPaid_date($pcode,$fromDate,$toDate);
	$balance=$wages_TotalReceive-$wages_totalPaidAmount;
 }
 $totalbalance+=$balance;$balance=0;
}//while
return $totalbalance;
}
function accountReceivable($pcode,$fromDate,$toDate){
$receivedAmount=0;
$invoicedAmount=0;

  $sql="select SUM(invoiceAmount) as invoicedAmount 
  from `invoice` WHERE  invoiceDate between '$fromDate' and '$toDate'  
  AND  invoiceLocation='$pcode'"  ;  

//echo $sql;
  $sqlQ=mysql_query($sql);
  $re=mysql_fetch_array($sqlQ);  
  $invoicedAmount=$re[invoicedAmount];
  
$sql1="select * from `receivecash` WHERE receiveDate between '$fromDate' and '$toDate'
 AND receiveFrom LIKE '5000000-$pcode' ";
//echo $sql1.'<br>';
//echo $sql1;
$sqlq1=mysql_query($sql1);
//$st=mysql_fetch_array($sqlq1);
while($st=mysql_fetch_array($sqlq1)){
 $receivedAmount+=$st[receiveAmount];
// echo "receivedAmount=$st[receiveAmount]<br>";
 }
 
 $balance=$invoicedAmount-$receivedAmount;
//echo "**$balance=$invoicedAmount-$receivedAmount;**";

 return $balance;
}
function completedAmount($pcode,$fromDate,$toDate){
  $sql="select SUM(invoiceAmount) as invoicedAmount 
  from `invoice` WHERE  invoiceDate between '$fromDate' and '$toDate'  
  AND  invoiceLocation='$pcode'"  ;  

//echo $sql;
  $sqlQ=mysql_query($sql);
  $re=mysql_fetch_array($sqlQ);  
  $invoicedAmount=$re[invoicedAmount];
  
 $balance=$invoicedAmount;
 //echo "**$balance=$invoicedAmount-$receivedAmount;**";

 return $balance;
}
function totalAccountReceivable($accountID,$pcode,$fromDate,$toDate){
  $sql="select SUM(invoiceAmount) as invoicedAmount 
  from `invoice` WHERE  invoiceDate between '$fromDate' and '$toDate'  "  ;  

//echo $sql;
  $sqlQ=mysql_query($sql);
  $re=mysql_fetch_array($sqlQ);  
  $invoicedAmount=$re[invoicedAmount];
  
$sql1="select SUM(receiveAmount) as receivedAmount 
 from `receivecash` WHERE receiveDate between '$fromDate' and '$toDate'";
 //echo $sql1.'<br>';
//echo $sql1;
$sqlq1=mysql_query($sql1);
$st=mysql_fetch_array($sqlq1);
 $receivedAmount=$st[receivedAmount];
 
 $balance=$invoicedAmount-$receivedAmount;

 return $balance;
}
function baseOpening($account,$pcode){

if($account=='5501000' OR $account=='5502000' ){

$sql="SELECT opbalance from project where pcode='$pcode'";
//echo "$sql";
$sqlq=mysql_query($sql);
$r=mysql_fetch_array($sqlq);
$opening=$r[opbalance];
}
else{
$sql="SELECT balance from accounts where accountID='$account'";
//echo "$sql<br>";
$sqlq=mysql_query($sql);
$r=mysql_fetch_array($sqlq);
$opening=$r[balance];
}
return $opening;
}
function paid_in_capital(){

$sql="SELECT SUM(balance) as total from accounts where accountType='16'";
//echo "$sql<br>";
$sqlq=mysql_query($sql);
$r=mysql_fetch_array($sqlq);
$opening=$r[total];

return $opening;
}

function totalCT($fromDate,$toDate,$pcode){
$sql2="select SUM(paidAmount) as receiveAmount from `purchase` WHERE  exFor='$pcode' 
		AND paymentDate between '$fromDate' and '$toDate' 
		AND paymentSL LIKE 'CT_%'";  
		//echo $sql;
		$sqlQ2=mysql_query($sql2);
		$r=mysql_fetch_array($sqlQ2);
		$receiveCash= $r[receiveAmount];
	return $receiveCash;

}

function totalCP_site($fromDate,$toDate,$pcode){
	$sql2="select SUM(paidAmount) as expenses from `purchase` WHERE  exFor='$pcode' 
	AND paymentDate between '$fromDate' and '$toDate' 
	AND account='5502000-$pcode'";  
	//echo $sql;
	$sqlQ2=mysql_query($sql2);
	$r=mysql_fetch_array($sqlQ2);
	$expenses= $r[expenses];
	
	return $expenses;

}

function total_equipment_value($fromDate,$toDate,$pcode){
$sql="SELECT SUM(price) as total FROM equipment ";
//echo "$sql<br>";
$sqlq=mysql_query($sql);
$r=mysql_fetch_array($sqlq);
return $r[total];
}

function total_furniture_value($fromDate,$toDate,$pcode){
$sql="SELECT SUM(rate*receiveQty) as total FROM store where itemCode like '22-%'  ";
//echo "$sql<br>";
$sqlq=mysql_query($sql);
$r=mysql_fetch_array($sqlq);
return $r[total];
}

function total_tools_value($fromDate,$toDate,$pcode){
$sql="SELECT SUM(rate*receiveQty) as total FROM store where itemCode BETWEEN '35-000-000' AND '50-000-000'   ";
//echo "$sql<br>";
$sqlq=mysql_query($sql);
$r=mysql_fetch_array($sqlq);
return $r[total];
}

function total_officetools_value($fromDate,$toDate,$pcode){
$sql="SELECT SUM(rate*receiveQty) as total FROM store$pcode where itemCode LIKE '21-000-000' ";
//echo "$sql<br>";
$sqlq=mysql_query($sql);
$r=mysql_fetch_array($sqlq);
return $r[total];
}

function sp_projectPaid($paymentSL,$pcode){
$sql="SELECT SUM(amount) as total FROM empsalary 
where paymentSL like '$paymentSL' AND glCode LIKE '6901000-$pcode'";
//echo "$sql<br>";
$sqlq=mysql_query($sql);
$r=mysql_fetch_array($sqlq);
return $r[total];
}

function mwp_projectPaid($paymentSL,$pcode){
$sql="SELECT SUM(amount) as total FROM empsalary 
where paymentSL like '$paymentSL' AND glCode LIKE '2404000-$pcode'";
//echo "$sql<br>";
$sqlq=mysql_query($sql);
$r=mysql_fetch_array($sqlq);
return $r[total];
}

function balance_6430000($pcode,$fromDate,$toDate){
$i=1;
$array_date=array();
$sql1="select * from `receivecash` WHERE receiveDate between  '$fromDate'   AND '$toDate' 
       AND receiveFrom LIKE '6430000-$pcode' ORDER by receiveDate ASC";
 //echo $sql1.'<br>';
//echo $sql1;
$sqlq1=mysql_query($sql1);
while($st=mysql_fetch_array($sqlq1)){
$array_date[$i][3]=$st[receiveAmount];
$array_date[$i][4]=2;
  $i++;
  }  
//print_r($array_date);
 sort($array_date);
$r=sizeof($array_date);
 for($i=0;$i<$r;$i++){
 if($array_date[$i][4]=='1'){$drAmount+=$array_date[$i][3]; }
 if($array_date[$i][4]=='2'){$crAmount+=$array_date[$i][3];}

}//for

return $crAmount;
}//balance_6130000(

function balance_6435000($pcode,$fromDate,$toDate){
$i=1;
$array_date=array();
$sql1="select * from `receivecash` WHERE receiveDate between  '$fromDate'   AND '$toDate' 
       AND receiveFrom LIKE '6435000-$pcode' ORDER by receiveDate ASC";
 //echo $sql1.'<br>';
//echo $sql1;
$sqlq1=mysql_query($sql1);
while($st=mysql_fetch_array($sqlq1)){
$array_date[$i][3]=$st[receiveAmount];
$array_date[$i][4]=2;
  $i++;
  }  
//print_r($array_date);
 sort($array_date);
$r=sizeof($array_date);
 for($i=0;$i<$r;$i++){
 if($array_date[$i][4]=='1'){$drAmount+=$array_date[$i][3]; }
 if($array_date[$i][4]=='2'){$crAmount+=$array_date[$i][3];}

}//for

return $crAmount;
}//balance_6130000(

function balance_6425000($pcode,$fromDate,$toDate){
$i=1;
$array_date=array();
$sql1="select * from `receivecash` WHERE receiveDate between  '$fromDate'   AND '$toDate' 
       AND receiveFrom LIKE '6425000-$pcode' ORDER by receiveDate ASC";
 //echo $sql1.'<br>';
//echo $sql1;
$sqlq1=mysql_query($sql1);
while($st=mysql_fetch_array($sqlq1)){
$array_date[$i][3]=$st[receiveAmount];
$array_date[$i][4]=2;
  $i++;
  }  
//print_r($array_date);
 sort($array_date);
$r=sizeof($array_date);
 for($i=0;$i<$r;$i++){
 if($array_date[$i][4]=='1'){$drAmount+=$array_date[$i][3]; }
 if($array_date[$i][4]=='2'){$crAmount+=$array_date[$i][3];}

}//for

return $crAmount;
}//balance_6130000(

/* return opening balance */
function openingBalance($acc,$edate,$pcode){
if($acc=='2401000'){
$i=1;
$array_date=array();

	$sql="SELECT SUM( receiveQty * rate )as amount, todat,paymentSL, itemCode,reference 
	FROM `store$pcode` 
	WHERE todat < '$edate' 
	AND paymentSL LIKE 'PO%' 
	GROUP BY todat,`paymentSL` order by todat ASC ";
//echo $sql;
  $sqlQ=mysql_query($sql);
  $r=mysql_num_rows($sqlQ);
  while($st=mysql_fetch_array($sqlQ)){
  $array_date[$i][0]=$st[todat];
  $array_date[$i][1]=viewposl($st[paymentSL]);  
  $array_date[$i][2]=$st[reference];
  $array_date[$i][3]=$st[amount];  
  $array_date[$i][4]=2;  
  $i++;  
  }
  
	$sql="SELECT SUM( receiveQty * rate )as amount, todat,paymentSL, itemCode,reference ".
	" FROM `storet$pcode` WHERE todat < '$edate'  
	AND paymentSL LIKE 'ST_%'GROUP BY `paymentSL` order by todat ASC ";
	  
//echo $sql;
  $sqlQ=mysql_query($sql);
  $r=mysql_num_rows($sqlQ);

  while($st=mysql_fetch_array($sqlQ)){
  $array_date[$i][0]=$st[todat];
  $array_date[$i][1]=$st[paymentSL];  
  $array_date[$i][2]=$st[reference];
  $array_date[$i][3]=$st[amount];  
  $array_date[$i][4]=2;  
  $i++;  
  }  
$sql1="SELECT paidAmount as amount,paymentSL,paymentDate,posl from vendorpayment WHERE".
" paymentDate < '$edate'  AND posl LIKE 'PO_".$pcode."_%' Order by paymentDate ASC";
//echo $sql1;
$sqlq1=mysql_query($sql1);
while($st=mysql_fetch_array($sqlq1)){
if(poType($st[posl])==1){
$array_date[$i][0]=$st[paymentDate];
$array_date[$i][1]=$st[paymentSL];
$array_date[$i][2]='';
$array_date[$i][3]=$st[amount];
$array_date[$i][4]=1;
  $i++;
  }//if(poType($r[posl])==1)
  }
 sort($array_date);
$r=sizeof($array_date);
 for($i=0;$i<$r;$i++){
 if($array_date[$i][4]=='1'){$drAmount+=$array_date[$i][3]; }
 if($array_date[$i][4]=='2'){$crAmount+=$array_date[$i][3];}

}//for
return $drAmount-$crAmount;
  
 }//2401000 
if($acc=='2402000'){
$i=1;
$array_date=array();

$sql="select COUNT(id) as total,itemCode,posl 
	from eqattendance  
	WHERE edate <'$edate' 
	AND location ='$pcode' 
    group by posl,itemCode 
	order by edate ASC ";	
//echo $sql;
  $sqlQ=mysql_query($sql);
$i=0;  
  while($st=mysql_fetch_array($sqlQ)){
	$pamount=0;

	$rate=eqpoRate($st[itemCode],$st[posl]);
	$pamount=$st[total]*$rate;

  $array_date[$i][3]=$pamount;  
  $array_date[$i][4]=2;  
  $i++;  
  }//while st
  
$sql1="SELECT paidAmount as amount,paymentSL,paymentDate,posl 
from vendorpayment 
WHERE paymentDate < '$edate'  
AND posl LIKE 'EQ_".$pcode."_%' 
Order by paymentDate ASC";
//echo $sql1;
$sqlq1=mysql_query($sql1);
while($st=mysql_fetch_array($sqlq1)){
$array_date[$i][3]=$st[amount];
$array_date[$i][4]=1;
  $i++;
  }
// sort($array_date);
$r=sizeof($array_date);
 for($i=0;$i<$r;$i++){
 if($array_date[$i][4]=='1'){$drAmount+=$array_date[$i][3]; }
 if($array_date[$i][4]=='2'){$crAmount+=$array_date[$i][3];}

}//for
return $drAmount-$crAmount;
  
 }//2402000 
 
if($acc=='2403000'){
$i=1;
$array_date=array();

$sql="SELECT SUM( qty*rate )as amount, edate,posl ".
	" FROM `subut` WHERE edate < '$edate'
	 AND posl LIKE 'PO_".$pcode."_%' GROUP BY `posl`,edate order by edate ASC ";
//echo $sql;
  $sqlQ=mysql_query($sql);
  $r=mysql_num_rows($sqlQ);
  while($st=mysql_fetch_array($sqlQ)){
  $array_date[$i][0]=$st[edate];
  $array_date[$i][1]=$st[posl];  
  $array_date[$i][2]='received';
  $array_date[$i][3]=$st[amount];  
  $array_date[$i][4]=2;  
  $i++;  
  }
  
$sql1="SELECT paidAmount as amount,paymentSL,paymentDate,posl from vendorpayment WHERE".
" paymentDate < '$edate' AND posl LIKE 'PO_".$pcode."_%' Order by paymentDate ASC";
//echo $sql1;
$sqlq1=mysql_query($sql1);
while($st=mysql_fetch_array($sqlq1)){
if(poType($st[posl])==3){
$array_date[$i][0]=$st[paymentDate];
$array_date[$i][1]=$st[paymentSL];
$array_date[$i][2]='';
$array_date[$i][3]=$st[amount];
$array_date[$i][4]=1;
  $i++;
  }//if(poType($r[posl])==1)
  }
 sort($array_date);
$r=sizeof($array_date);
 for($i=0;$i<$r;$i++){
 if($array_date[$i][4]=='1'){$drAmount+=$array_date[$i][3]; }
 if($array_date[$i][4]=='2'){$crAmount+=$array_date[$i][3];}

}//for
return $drAmount-$crAmount;
  
 }//2403000 
 
if($acc=='2404000'){
$i=1;
$array_date=array();
 $si=((strtotime($edate)-strtotime('2006-07-01'))/86400)+1;
$i=0;	
  for($j=0;$j<$si;$j++){
	$fd=date("Y-m-d",strtotime($fromDate)+(86400*$j));
	$td=$fd;    
	$wages_TotalReceive=wagesAmount_date($pcode,$fd,$td);
   if($wages_TotalReceive>0){	
	$array_date[$i][0]=$fd;
	$array_date[$i][1]='';  
	$array_date[$i][2]='received';
	$array_date[$i][3]=$wages_TotalReceive;  
	$array_date[$i][4]=2;  $i++;
	}//if($wages_TotalReceive>0)

  }
  
$sql1="select SUM(amount) as amount,pdate,paymentSL from `empsalary`
      WHERE pdate < '$edate' 
	  AND glCode LIKE '2404000-$pcode' GROUP by paymentSL";
 // echo $sql.'<br>';
//echo $sql1;
$sqlq1=mysql_query($sql1);
while($st=mysql_fetch_array($sqlq1)){
$array_date[$i][0]=$st[pdate];
$array_date[$i][1]=$st[paymentSL];
$array_date[$i][2]='';
$array_date[$i][3]=$st[amount];
$array_date[$i][4]=1;
  $i++;
  }
 sort($array_date);
$r=sizeof($array_date);
 for($i=0;$i<$r;$i++){
 if($array_date[$i][4]=='1'){$drAmount+=$array_date[$i][3]; }
 if($array_date[$i][4]=='2'){$crAmount+=$array_date[$i][3];}

}//for
return $drAmount-$crAmount;
  
 }//2404000 
 
//echo "$acc*************************************$pcode";
if($acc=='6430000'){
$i=1;
$array_date=array();
$sql1="select * from `receivecash` WHERE receiveDate < '$edate'  
       AND receiveFrom LIKE '6430000-$pcode' ORDER by receiveDate ASC";
 //echo $sql1.'<br>';
//echo $sql1;
$sqlq1=mysql_query($sql1);
while($st=mysql_fetch_array($sqlq1)){
$array_date[$i][3]=$st[receiveAmount];
$array_date[$i][4]=2;
  $i++;
  }  
//print_r($array_date);
 sort($array_date);
$r=sizeof($array_date);
 for($i=0;$i<$r;$i++){
 if($array_date[$i][4]=='1'){$drAmount+=$array_date[$i][3]; }
 if($array_date[$i][4]=='2'){$crAmount+=$array_date[$i][3];}

}//for
return $drAmount-$crAmount;
}//6430000
if($acc=='5000000'){
	$sql="select * from `invoice` WHERE  invoiceDate < '$edate' 
	AND  invoiceLocation='$pcode'  
	order by invoiceDate ASC";  
	//echo $sql;
	$sqlQ=mysql_query($sql);
	$array_date=array();
	while($re=mysql_fetch_array($sqlQ)){
	$array_date[$i][3]=$re[invoiceAmount];
	$array_date[$i][4]=1;
	$i++;
	}  
	$sql1="select * from `receivecash` WHERE receiveDate < '$edate' 
	AND receiveFrom LIKE '5000000-$pcode' ORDER by receiveDate ASC";
	$sqlq1=mysql_query($sql1);
	while($st=mysql_fetch_array($sqlq1)){
	$array_date[$i][3]=$st[receiveAmount];
	$array_date[$i][4]=2;
	$i++;
	}  
	//print_r($array_date);
	sort($array_date);
	$r=sizeof($array_date);
	
	for($i=0;$i<$r;$i++){
	if($array_date[$i][4]=='1')$drAmount+=$array_date[$i][3]; 
	if($array_date[$i][4]=='2') $crAmount+=$array_date[$i][3];
	}//for
	//echo "<br>$drAmount-$crAmount; <br>";
	return $drAmount-$crAmount;

}//5000000
if($acc=='4701000'){	
	$sql="SELECT SUM( receiveQty * rate )as subbalance1 ".
	" FROM `store$pcode` WHERE todat < '$edate' ";
		
	//echo $sql;
	$sqlQ=mysql_query($sql);
	$re=mysql_fetch_array($sqlQ);
    $subbalance1=$re[subbalance1];
	
	$sql2="SELECT SUM(issuedQty*issueRate) as subbalance2 from issue$pcode WHERE".
	" issueDate < '$edate'";
	$sqlQ2=mysql_query($sql2);
	$re2=mysql_fetch_array($sqlQ2);
	$subbalance2=$re[subbalance2];
	
	$sql3="SELECT SUM(receiveQty*rate) as subbalance3 from storet WHERE returnFrom='$pcode' AND edate < '$edate' ";
//echo $sql1;
	$sqlQ3=mysql_query($sql3);
	$re3=mysql_fetch_array($sqlQ3);
	$subbalance3=$re[subbalance3];
	
	return $subbalance1-($subbalance2+$subbalance3);

}//'4701000'
if($acc=='4800000'){	

	$sql="SELECT SUM( receiveQty * rate )as subbalance1 ".
	" FROM `storet$pcode` WHERE todat < '$edate' ";
		
	//echo $sql;
	$sqlQ=mysql_query($sql);
	$re=mysql_fetch_array($sqlQ);
    $subbalance1=$re[subbalance1];
	
	$sql2="SELECT SUM( receiveQty * rate )as subbalance2 ".
	" FROM `store$pcode` WHERE todat < '$edate' ";
	$sqlQ2=mysql_query($sql2);
	$re2=mysql_fetch_array($sqlQ2);
	$subbalance2=$re[subbalance2];
	return $subbalance1-$subbalance2;

}//'4800000'
if($acc=='6801000'){	
	$sql="SELECT SUM(issuedQty*issueRate) as subbalance from issue$pcode WHERE".
	" issueDate < '$edate'";
    //echo $sql2;
	$sqlQ=mysql_query($sql);
	$re=mysql_fetch_array($sqlQ);
	$subbalance=$re[subbalance];
	return $subbalance;

}//'6801000'

if($acc=='5501000'){	//echo "$acc*************************************";

if($pcode==000){
  $sql="select * from `purchase` WHERE  paymentDate  < '$edate'  
       AND account='5501000-000' AND (paymentSL not LIKE 'ct_%') 
       order by paymentDate ASC";  
		 }
else{
  $sql="select * from `purchase` WHERE  paymentDate  < '$edate' 
  	    AND ((account='5501000-000' AND  exfor='$pcode' ) 
		OR (account='5501000-000' AND paymentSL like 'SP_%') 
		OR (account='5501000-000' AND paymentSL like 'WP_%'))
		AND paymentSl not Like 'ct_%' 
		 order by paymentDate ASC";  	
}	
	$sqlQ=mysql_query($sql);
	$r=mysql_num_rows($sqlQ);
	$i=0;  
	$crAmount=0;
	$array_date=array();
	while($re=mysql_fetch_array($sqlQ)){
	$temp=explode('_',$re[paymentSL]);
	
	if($temp[0]=="SP" OR $temp[0]=="WP" ){
	if($temp[0]=="SP" )$paidAmount=sp_projectPaid($re[paymentSL],$pcode);
	else if($temp[0]=="WP")$paidAmount=mwp_projectPaid($re[paymentSL],$pcode);
	if($paidAmount){  
	$array_date[$i][3]=$paidAmount;
	$array_date[$i][4]=2;
	$i++;}//if($paidAmount)
	}
	else{
	$array_date[$i][3]=$re[paidAmount];
	$array_date[$i][4]=2;
	$i++; }
	
	}  
	/* cash transfer */
if($pcode=='000'){
   $sql2="select * from `ex130` WHERE  exDate   < '$edate' 
        AND (paymentSL LIKE 'ct_%' OR paymentSL LIKE 'CT_%') 
  	    AND  (exgl='5501000-000' OR account='5501000-000')  
  	    order by exDate ASC";  
		$ckgl="5501000-000";
}
else {
   $sql2="select * from `ex130` WHERE  exDate   < '$edate' 
        AND (paymentSL LIKE 'ct_%' OR paymentSL LIKE 'CT_%') 
  	    AND  ((exgl='5501000-000' OR account='5501000-000') AND 
		(exgl LIKE '%-$pcode' OR account LIKE '%-$pcode')) 
  	    order by exDate ASC";  
        //$ckgl="5502000-$pcode";
		$ckgl="5501000-000";		
}
//echo "$sql2<br>";
//echo "<br>$ckgl";
  $sqlQ=mysql_query($sql2);
  while($re=mysql_fetch_array($sqlQ)){
  $array_date[$i][3]=$re[examount];      
  if($re[exgl]==$ckgl) $array_date[$i][4]=1;  
   else  $array_date[$i][4]=2;          
  $i++;
  }//while
	
	/* edit for project receive*/
	
	if($pcode=='000'){
	$sql="select * from `receivecash` WHERE  receiveDate < '$edate' 
	AND receiveAccount='5501000'
	order by receiveDate ASC";  
	}else {
	$sql="select * from `receivecash` WHERE  receiveDate < '$edate' 
	AND  receiveFrom LIKE '%-$pcode' AND receiveAccount='5501000'
	order by receiveDate ASC";  
	}
	//echo "$sql<br>";
	$sqlQ=mysql_query($sql);
	$r=mysql_num_rows($sqlQ);
	$k=0;  
	$crAmount=0;
	while($re=mysql_fetch_array($sqlQ)){
	$array_date[$i][3]=$re[receiveAmount];
	$array_date[$i][4]=1;
	$i++;  
	}  
	//print_r($array_date);
	sort($array_date);
	$r=sizeof($array_date);
	
	for($i=0;$i<$r;$i++){
	if($array_date[$i][4]=='1'){$drAmount+=$array_date[$i][3]; }
	if($array_date[$i][4]=='2'){ $crAmount+=$array_date[$i][3];}
	}//for
//echo "<br>** $drAmount-$crAmount **<br>";
return $drAmount-$crAmount;
}//'5501000-000'

if($acc=='5502000'){	
	$array_date=array();
   $i=1;  
	$drAmount=0;
	$crAmount=0;


	$sql="select * from `purchase` WHERE  paymentDate < '$edate'  
	AND account='5502000-$pcode' AND  paymentSL not LIKE 'ct_%'  AND exfor='$pcode' 
	order by paymentDate ASC";  
	//echo $sql;
	$sqlQ=mysql_query($sql);
	while($re=mysql_fetch_array($sqlQ)){
	$array_date[$i][3]=$re[paidAmount];
	$array_date[$i][4]=2;
	$i++;    
	}//while

	$sql2="select * from `ex130` WHERE  exDate  < '$edate'  
	AND (paymentSL LIKE 'ct_%' OR paymentSL LIKE 'CT_%') 
	AND  (exgl='5502000-$pcode' OR account='5502000-$pcode')  
	order by exDate ASC";  
	$ckgl="5502000-$pcode";
	//echo "$sql2<br>";
	//echo "<br>$ckgl";
	$sqlQ=mysql_query($sql2);
	while($re=mysql_fetch_array($sqlQ)){
	
	$array_date[$i][3]=$re[examount];      
	if($re[exgl]==$ckgl) $array_date[$i][4]=1;  
	else  $array_date[$i][4]=2;  
	
	$i++;
	}//while
 sort($array_date);
$r=sizeof($array_date);
	for($i=0;$i<$r;$i++){
	if($array_date[$i][4]=='1'){$drAmount+=$array_date[$i][3]; }
	if($array_date[$i][4]=='2'){ $crAmount+=$array_date[$i][3];}
	}//for
//echo "<br>** $drAmount-$crAmount **<br>";
return $drAmount-$crAmount;
}//'5502000-'
if($acc=='6901000'){	
	$sql="select SUM(amount) as balance from `empsalary` WHERE  pdate < '$edate'".
	" AND   glCode='$acc-$pcode'";	
	//echo $sql;
	$sqlQ=mysql_query($sql);
	$re=mysql_fetch_array($sqlQ);
    return $re[balance];
}//'5501000-000'
if($acc>=5101001 AND $acc<=5301000 ){
$i=0;
 if($acc=='5201000' AND pcode=='000'){
	/* slalry advance balance*/	
$sql1="SELECT * from purchase 
WHERE paymentDate < '$edate' 
AND paymentSL LIKE 'AS_%' Order by paymentDate ASC";
//echo $sql1;
$sqlq1=mysql_query($sql1);
while($st=mysql_fetch_array($sqlq1)){
$dr+=$st[paidAmount];
  }//while

$sql1="SELECT * from empsalaryadc 
WHERE pdate < '$edate'  
Order by pdate ASC";
//echo '<br>'.$sql1;
$sqlq1=mysql_query($sql1);
while($st=mysql_fetch_array($sqlq1)){
$cr+=$st[amount];
  }//while
return $dr-$cr;		
	}	
else {
if($pcode){	 
   $sql2="select * from `ex130` WHERE  exDate  < '$edate' 
        AND (paymentSL LIKE 'ct_%' OR paymentSL LIKE 'CT_%')
  	    AND  (exgl='$acc-$pcode' OR account='$acc-$pcode') 
  	    order by exDate ASC";  
//echo "<br>$sql2<br>";
 $sqlQ=mysql_query($sql2);
  while($re=mysql_fetch_array($sqlQ)){
  $array_date[$i][3]=$re[examount];      
  if($re[exgl]=="$acc-$pcode") $array_date[$i][4]=1;  
   else  $array_date[$i][4]=2;          
  $i++;
  }//while
  
 }//if
else{	 
   $sql2="select * from `ex130` WHERE  exDate  < '$edate' 
        AND (paymentSL LIKE 'ct_%' OR paymentSL LIKE 'CT_%')
  	    AND  (exgl='$acc-%' OR account='$acc-%') 
  	    order by exDate ASC";  
//echo "<br>$sql2<br>";
 $sqlQ=mysql_query($sql2);
  while($re=mysql_fetch_array($sqlQ)){
  $array_date[$i][3]=$re[examount];      
  if(substr($re[exgl],0,7)=="$acc") $array_date[$i][4]=1;  
   else  $array_date[$i][4]=2;          
  $i++;
  }//while
  
 }//else

  $r=sizeof($array_date); 
//  print_r($array_date);
  for($i=0;$i<$r;$i++){
   if($array_date[$i][4]=='1') {  $drAmount+=$array_date[$i][3];}
   if($array_date[$i][4]=='2') { $crAmount+=$array_date[$i][3];}
	}//for
//	echo "***** $drAmount-$crAmount; *********<br	>";
	return $drAmount-$crAmount;
	}//else
	}
	if($acc=='5700000'){
	$i=0;
   $sql2="select * from `ex130` WHERE  exDate  < '$edate' 
        AND (paymentSL LIKE 'ct_%' OR paymentSL LIKE 'CT_%')
  	    AND  (exgl='5700000-$pcode' OR account='5700000-$pcode') 
  	    order by exDate ASC";  
//echo "<br>$sql2<br>";
 $sqlQ=mysql_query($sql2);
  while($re=mysql_fetch_array($sqlQ)){
  $array_date[$i][3]=$re[examount];      
  if($re[exgl]=="5700000-$pcode") $array_date[$i][4]=1;  
   else  $array_date[$i][4]=2;          
  $i++;
  }//while
  $r=sizeof($array_date); 
 // print_r($array_date);
  for($i=0;$i<$r;$i++){
   if($array_date[$i][4]=='1') {  $drAmount+=$array_date[$i][3];}
   if($array_date[$i][4]=='2') { $crAmount+=$array_date[$i][3];}
	}//for
	//echo "***** $drAmount-$crAmount; *********<br	>";
	return $drAmount-$crAmount;
	}	
	if($acc>=5600000 AND $acc<=5699999 ){

if($pcode){
  $sql="select * from `purchase` WHERE   paymentDate < '$edate' AND 
  	     account='$acc' AND exfor='$pcode' AND paymentSL not LIKE 'CT_%' 
		 order by paymentDate ASC";  

//echo "$sql<br>";
  $sqlQ=mysql_query($sql);

$drAmount=0;
$crAmount=0;
$i=0;
  while($re=mysql_fetch_array($sqlQ)){
  $array_date[$i][3]=$re[paidAmount];      
  $array_date[$i][4]=2;        
  $i++;
  }//while

  $sql2="select * from `ex130` WHERE  exDate  < '$edate' 
        AND (paymentSL LIKE 'ct_%' OR paymentSL LIKE 'CT_%')
  	    AND  (exgl='$acc' OR account='$acc') 
  	    AND  (exgl LIKE '%-$pcode' OR account LIKE '%-$pcode') 		
		order by exDate ASC";  

//echo "$sql2<br>";
  $sqlQ=mysql_query($sql2);
  while($re=mysql_fetch_array($sqlQ)){
  $array_date[$i][3]=$re[examount];      
  if($re[exgl]==$acc) $array_date[$i][4]=1;  
   else  $array_date[$i][4]=2;          
  $i++;
  }//while
  
$sql1="select * from `receivecash` WHERE receiveDate <'$edate' 
       AND  receiveFrom LIKE '%-$pcode' AND receiveAccount='$acc' ORDER by receiveDate ASC";
 //echo "<br>$sql1<br>";
//echo $sql1;
$sqlq1=mysql_query($sql1);
while($st=mysql_fetch_array($sqlq1)){
$array_date[$i][0]=$st[receiveDate];
$array_date[$i][1]=$st[receiveSL];
$array_date[$i][2]='';
$array_date[$i][3]=$st[receiveAmount];
$array_date[$i][4]=1;
  $i++;
  }    
$r=sizeof($array_date);  
//print_r($array_date);
  for($i=0;$i<$r;$i++){
   if($array_date[$i][4]=='1') {  $drAmount+=$array_date[$i][3];}
   if($array_date[$i][4]=='2') { $crAmount+=$array_date[$i][3];}
	}//for
	
}
else {
  $sql="select * from `purchase` WHERE  paymentDate <'$edate' AND 
  	     account='$acc'  AND paymentSL not LIKE 'CT_%' 
		 order by paymentDate ASC";  

//echo "$sql<br>";
  $sqlQ=mysql_query($sql);

$drAmount=0;
$crAmount=0;
$i=0;
  while($re=mysql_fetch_array($sqlQ)){
  $array_date[$i][3]=$re[paidAmount];      
  $array_date[$i][4]=2;        
  $i++;
  }//while

  $sql2="select * from `ex130` WHERE  exDate <'$edate' 
        AND (paymentSL LIKE 'ct_%' OR paymentSL LIKE 'CT_%')
  	    AND  (exgl='$acc' OR account='$acc') 
  	    AND  (exgl LIKE '%' OR account LIKE '%') 		
		order by exDate ASC";  

//echo "$sql2<br>";
  $sqlQ=mysql_query($sql2);
  while($re=mysql_fetch_array($sqlQ)){
  $array_date[$i][3]=$re[examount];      
  if($re[exgl]==$acc) $array_date[$i][4]=1;  
   else  $array_date[$i][4]=2;          
  $i++;
  }//while
  
$sql1="select * from `receivecash` WHERE receiveDate <'$edate' 
       AND  receiveAccount='$acc' ORDER by receiveDate ASC";
 //echo "<br>$sql1<br>";
//echo $sql1;
$sqlq1=mysql_query($sql1);
while($st=mysql_fetch_array($sqlq1)){
$array_date[$i][0]=$st[receiveDate];
$array_date[$i][1]=$st[receiveSL];
$array_date[$i][2]='';
$array_date[$i][3]=$st[receiveAmount];
$array_date[$i][4]=1;
  $i++;
  }    
$r=sizeof($array_date);  
  for($i=0;$i<$r;$i++){
   if($array_date[$i][4]=='1') {  $drAmount+=$array_date[$i][3];}
   if($array_date[$i][4]=='2') { $crAmount+=$array_date[$i][3];}
	}//for
	


}	
//	echo "**$drAmount-$crAmount**";
return $drAmount-$crAmount;
}//if
if($acc>=1001002 AND $acc<=1603000){

$i=0;
   $sql2="select * from `ex130` WHERE  exDate  < '$edate' 
        AND (paymentSL LIKE 'ct_%' OR paymentSL LIKE 'CT_%')
  	    AND  (exgl='$acc' OR account='$acc') 
  	    order by exDate ASC";  
//echo "<br>$sql2<br>";
 $sqlQ=mysql_query($sql2);
  while($re=mysql_fetch_array($sqlQ)){
  $array_date[$i][3]=$re[examount];      
  if($re[exgl]=="$acc") $array_date[$i][4]=1;  
   else  $array_date[$i][4]=2;          
  $i++;
  }//while

  $r=sizeof($array_date); 
//  print_r($array_date);
  for($i=0;$i<$r;$i++){
   if($array_date[$i][4]=='1') {  $drAmount+=$array_date[$i][3];}
   if($array_date[$i][4]=='2') { $crAmount+=$array_date[$i][3];}
	}//for
//	echo "***** $drAmount-$crAmount; *********<br	>";
	return $drAmount-$crAmount;
	}
	else {	
	$sql="select sum(examount) as balance from `ex130` WHERE exDate <'$edate' ".
	" AND exgl = '$acc-$pcode' order by exDate ASC";
	//echo $sql;
	$sqlQ=mysql_query($sql);
	$re=mysql_fetch_array($sqlQ);
    return $re[balance];	
	}
}

/* return total cash in hand*/
function cashonHand($pcode,$fromDate,$toDate,$t){
if($t=='2')
  {
   if($pcode=='000'){
    $baseOpening=baseOpening("5501000",$pcode);
   	$sql2="select SUM(paidAmount) as receiveAmount from `purchase` WHERE  exFor='$pcode' 
	AND paymentDate between '$fromDate' and '$toDate'  AND paymentSL LIKE 'CT_%'";  
	//echo "$sql2<br>";
	$sqlQ2=mysql_query($sql2);
	$r=mysql_fetch_array($sqlQ2);
	$receiveCash= $r[receiveAmount]+$baseOpening;
	
	$sql2="select SUM(paidAmount) as expenses from `purchase` WHERE  exFor='$pcode' 
	AND paymentDate between '$fromDate' and '$toDate' AND account='5501000-$pcode'";  
	//echo $sql2;
	$sqlQ2=mysql_query($sql2);
	$r=mysql_fetch_array($sqlQ2);
	$expenses= $r[expenses];
	//echo "<br>**$pcode=$baseOpening-$receiveCash-$expenses;**<br>"; 
	$balance=$receiveCash-$expenses;
    }
   else {
   if($fromDate<'2006-07-01')   $baseOpening=baseOpening("5502000",$pcode);    
/*   
	$sql2="select SUM(paidAmount) as receiveAmount from `purchase` WHERE  exFor='$pcode' 
	AND paymentDate between '$fromDate' and '$toDate'  AND paymentSL LIKE 'CT_%'";  
	//echo "$sql2<br>";
	$sqlQ2=mysql_query($sql2);
	$r=mysql_fetch_array($sqlQ2);
	$receiveCash= $r[receiveAmount]+$baseOpening;
	
	$sql2="select SUM(paidAmount) as expenses from `purchase` WHERE  exFor='$pcode' 
	AND paymentDate between '$fromDate' and '$toDate' AND account='5502000-$pcode'";  
	//echo $sql2;
	$sqlQ2=mysql_query($sql2);
	$r=mysql_fetch_array($sqlQ2);
	$expenses= $r[expenses];
	//echo "<br>**$pcode=$baseOpening-$receiveCash-$expenses;**<br>"; 
	$balance=$receiveCash-$expenses;
	*/
	$array_date=array();
   $i=1;  
	$drAmount=0;
	$crAmount=0;


	$sql="select * from `purchase` WHERE  paymentDate between '$fromDate' and '$toDate'  
	AND account='5502000-$pcode' AND  paymentSL not LIKE 'ct_%'  AND exfor='$pcode' 
	order by paymentDate ASC";  
	//echo $sql;
	$sqlQ=mysql_query($sql);
	while($re=mysql_fetch_array($sqlQ)){
	$array_date[$i][3]=$re[paidAmount];
	$array_date[$i][4]=2;
	$i++;    
	}//while

	$sql2="select * from `ex130` WHERE  exDate  between '$fromDate' and '$toDate' 
	AND (paymentSL LIKE 'ct_%' OR paymentSL LIKE 'CT_%') 
	AND  (exgl='5502000-$pcode' OR account='5502000-$pcode')  
	order by exDate ASC";  
	$ckgl="5502000-$pcode";
	//echo "$sql2<br>";
	//echo "<br>$ckgl";
	$sqlQ=mysql_query($sql2);
	while($re=mysql_fetch_array($sqlQ)){
	
	$array_date[$i][3]=$re[examount];      
	if($re[exgl]==$ckgl) $array_date[$i][4]=1;  
	else  $array_date[$i][4]=2;  
	
	$i++;
	}//while
 sort($array_date);
$r=sizeof($array_date);
	for($i=0;$i<$r;$i++){
	if($array_date[$i][4]=='1'){$drAmount+=$array_date[$i][3]; }
	if($array_date[$i][4]=='2'){ $crAmount+=$array_date[$i][3];}
	}//for
//echo "<br>** $drAmount-$crAmount **<br>";
$balance=$drAmount-$crAmount;

	
    }
	
  }
else {	
	$sql2="select SUM(paidAmount) as receiveAmount from `purchase` WHERE  exFor='$pcode' 
	AND paymentDate between '$fromDate' and '$toDate'  AND paymentSL LIKE 'CT_%'";  
	//echo "$sql2<br>";
	$sqlQ2=mysql_query($sql2);
	$r=mysql_fetch_array($sqlQ2);
	$receiveCash= $r[receiveAmount]+$baseOpening;
	
	$sql2="select SUM(paidAmount) as expenses from `purchase` WHERE  exFor='$pcode' 
	AND paymentDate between '$fromDate' and '$toDate' AND account='5502000-$pcode'";  
	//echo $sql2;
	$sqlQ2=mysql_query($sql2);
	$r=mysql_fetch_array($sqlQ2);
	$expenses= $r[expenses];
	//echo "<br>**$pcode=$baseOpening-$receiveCash-$expenses;**<br>"; 
	$balance=$receiveCash-$expenses;
	
}	
return $balance;		
		
}

/* return false is salary paid*/
function isSalaryPaid($empId,$month,$year){
$sql="select empId from empsalary where empId='$empId' AND month='$year-$month-01'";
//echo $sql.'<br>';
$sqlq=mysql_query($sql);
$sqlr=mysql_num_rows($sqlq);
if($sqlr>=1) return 0;
else return 1;
}

/* update salary advance */
function updateSalaryAdv($empId,$designation,$reff,$paymentSL,$adAmount,$pmonth,$pdate){
 include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

    $sql2="INSERT INTO empsalaryadc (id,empId,designation,amount,pmonth,paymentSL,reff,pdate)".
	" values ('','$empId','$designation','$adAmount','$pmonth','$paymentSL','$reff','$pdate')"; 
	//echo "<br>$sql2<br>";
	$sqlq=mysql_query($sql2);

	$sql="Select SUM(amount) as salaryadc from empsalaryadc where reff LIKE '$reff' AND empId='$empId'";
	//echo "**<br>$sql<br>";
     $sqlq=mysql_query($sql);
     $sqlr=mysql_fetch_array($sqlq);  
	 $totalAdvCut=$sqlr[salaryadc];

	$sql1="select amount from empsalaryad where empId='$empId' AND paymentSL LIKE '$reff' AND empId='$empId'";
	//echo "<br>$sql1<br>";
	$sqlq1=mysql_query($sql1);
	$sqlr1=mysql_fetch_array($sqlq1);
    $totalAdv=$sqlr1[amount];   
     if($totalAdvCut==$totalAdv){
	   $sql3="UPDATE empsalaryad set status='3' WHERE paymentSL LIKE '$reff' AND empId='$empId'";
	   //echo "<br>$sql3<br>";
	   $sqlq=mysql_query($sql3);	   
	 }
	 
	 return 0;
}

/*---------------------------------
INPUT: empID and Month
OUTPUT: Salary amount payable
---------------------------------*/
function currentPayble($emp,$d){

 $sql=" SELECT SUM(amount)  as salary FROM `empsalary` WHERE empId='$emp' AND month='$d'";
 //echo $sql;
 $sqlQuery=mysql_query($sql);
 $rr=mysql_fetch_array($sqlQuery);

 $sql1=" SELECT SUM(amount)  as salaryadc FROM `empsalaryadc` WHERE empId='$emp' AND pmonth='$d'";
 //echo $sql;
 $sqlQuery1=mysql_query($sql1);
 $rr1=mysql_fetch_array($sqlQuery1); 
//echo $empId;
return $rr[salary]+$rr1[salaryadc];
}
/* generate payment sl*/
function generatePaymentSL($w,$p,$d){
//echo "**$w,$p,$d**";
if($w AND $p AND $d){
$d=formatDate($d,"Y-m-d");
 include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

$year=date('y',strtotime($d));
if($w==2)
	{
	  $searchKey='CP_'.$p.'_'.$year.'_%';
     $sql="SELECT paymentSL from purchase WHERE paymentSL LIKE '$searchKey' ORDER by prId DESC";
//	 echo $sql.'<br>';	
	 $sqlq=mysql_query($sql);
     $sqlr = mysql_fetch_array($sqlq);
     $t=explode('_',$sqlr[paymentSL]);

	 $num_rows=$t[3]+1;
	 if($num_rows<10) $po="0000$num_rows";
	 else if($num_rows<100) $po="000$num_rows";	 
	 else if($num_rows<1000) $po="00$num_rows";	 	 
	 else if($num_rows<10000) $po="0$num_rows";	 	 
	  else $po=$num_rows;
	  $sl="CP_".$p."_".$year."_".$po;	 	 
	}
else if($w==8)
	{
	  $searchKey='CT_'.$p.'_'.$year.'_%';
     $sql="SELECT paymentSL from purchase WHERE paymentSL LIKE '$searchKey' ORDER by prId DESC";
	// echo $sql.'<br>';	
	 $sqlq=mysql_query($sql);
     $sqlr = mysql_fetch_array($sqlq);
     $t=explode('_',$sqlr[paymentSL]);

	 $num_rows=$t[3]+1;
	 if($num_rows<10) $po="0000$num_rows";
	 else if($num_rows<100) $po="000$num_rows";	 
	 else if($num_rows<1000) $po="00$num_rows";	 	 
	 else if($num_rows<10000) $po="0$num_rows";	 	 
	  else $po=$num_rows;
	  $sl="CT_".$p."_".$year."_".$po;	 	 
	}	
else if($w==1)
	{
	  $searchKey='EP_'.$p.'_'.$year.'_%';
     $sql="SELECT paymentSL from purchase WHERE paymentSL LIKE '$searchKey' ORDER by prId DESC";
	// echo $sql.'<br>';	
	 $sqlq=mysql_query($sql);
     $sqlr = mysql_fetch_array($sqlq);
     $t=explode('_',$sqlr[paymentSL]);

	 $num_rows=$t[3]+1;
	 if($num_rows<10) $po="0000$num_rows";
	 else if($num_rows<100) $po="000$num_rows";	 
	 else if($num_rows<1000) $po="00$num_rows";	 	 
	 else if($num_rows<10000) $po="0$num_rows";	 	 
	  else $po=$num_rows;
	  $sl="EP_".$p."_".$year."_".$po;	 	 
	}	
else if($w==4)
	{
	  $searchKey='PP_'.$p.'_'.$year.'_%';
     $sql="SELECT paymentSL from purchase WHERE paymentSL LIKE '$searchKey' ORDER by prId DESC";
	// echo $sql.'<br>';	
	 $sqlq=mysql_query($sql);
     $sqlr = mysql_fetch_array($sqlq);
     $t=explode('_',$sqlr[paymentSL]);

	 $num_rows=$t[3]+1;
	 if($num_rows<10) $po="0000$num_rows";
	 else if($num_rows<100) $po="000$num_rows";	 
	 else if($num_rows<1000) $po="00$num_rows";	 	 
	 else if($num_rows<10000) $po="0$num_rows";	 	 
	  else $po=$num_rows;
	  $sl="PP_".$p."_".$year."_".$po;	 	 
	}	
else if($w==5)
	{
	  $searchKey='SP_'.$p.'_'.$year.'_%';
     $sql="SELECT paymentSL from purchase WHERE paymentSL LIKE '$searchKey' ORDER by prId DESC";
	// echo $sql.'<br>';	
	 $sqlq=mysql_query($sql);
     $sqlr = mysql_fetch_array($sqlq);
     $t=explode('_',$sqlr[paymentSL]);

	 $num_rows=$t[3]+1;
	 if($num_rows<10) $po="0000$num_rows";
	 else if($num_rows<100) $po="000$num_rows";	 
	 else if($num_rows<1000) $po="00$num_rows";	 	 
	 else if($num_rows<10000) $po="0$num_rows";	 	 
	  else $po=$num_rows;
	  $sl="SP_".$p."_".$year."_".$po;	 	 
	}	
else if($w==6)
	{
	  $searchKey='AS_'.$p.'_'.$year.'_%';
     $sql="SELECT paymentSL from purchase WHERE paymentSL LIKE '$searchKey' ORDER by prId DESC";
	// echo $sql.'<br>';	
	 $sqlq=mysql_query($sql);
     $sqlr = mysql_fetch_array($sqlq);
     $t=explode('_',$sqlr[paymentSL]);

	 $num_rows=$t[3]+1;
	 if($num_rows<10) $po="0000$num_rows";
	 else if($num_rows<100) $po="000$num_rows";	 
	 else if($num_rows<1000) $po="00$num_rows";	 	 
	 else if($num_rows<10000) $po="0$num_rows";	 	 
	  else $po=$num_rows;
	  $sl="AS_".$p."_".$year."_".$po;	 	 
	}	
else if($w==7)
	{
	  $searchKey='WP_'.$p.'_'.$year.'_%';
     $sql="SELECT paymentSL from purchase WHERE paymentSL LIKE '$searchKey' ORDER by prId DESC";
	// echo $sql.'<br>';	
	 $sqlq=mysql_query($sql);
     $sqlr = mysql_fetch_array($sqlq);
     $t=explode('_',$sqlr[paymentSL]);

	 $num_rows=$t[3]+1;
	 if($num_rows<10) $po="0000$num_rows";
	 else if($num_rows<100) $po="000$num_rows";	 
	 else if($num_rows<1000) $po="00$num_rows";	 	 
	 else if($num_rows<10000) $po="0$num_rows";	 	 
	  else $po=$num_rows;
	  $sl="WP_".$p."_".$year."_".$po;	 	 
	}	
else if($w=='51')
	{
	  $searchKey='WP_'.$p.'_'.$year.'_%';
     $sql="SELECT paymentSL from purchase WHERE paymentSL LIKE '$searchKey' ORDER by prId DESC";
	// echo $sql.'<br>';	
	 $sqlq=mysql_query($sql);
     $sqlr = mysql_fetch_array($sqlq);
     $t=explode('_',$sqlr[paymentSL]);

	 $num_rows=$t[3]+1;
	 if($num_rows<10) $po="0000$num_rows";
	 else if($num_rows<100) $po="000$num_rows";	 
	 else if($num_rows<1000) $po="00$num_rows";	 	 
	 else if($num_rows<10000) $po="0$num_rows";	 	 
	  else $po=$num_rows;
	  $sl="WP_".$p."_".$year."_".$po;	 	 
	}		
	return $sl;
	}
	else { echo "ERROR please try again"; exit;}
}
/* return remain salary advance amount*/
function remainAdv($empId){
	$sql="Select SUM(amount) as salaryadc from empsalaryadc where empId='$empId'";
//	echo "**<br>$sql<br>";
     $sqlq=mysql_query($sql);  
     $sqlr=mysql_fetch_array($sqlq);  
	 $totalAdvCut=$sqlr[salaryadc];

	$sql1="select sum(amount) as amount from empsalaryad where empId='$empId' AND empId='$empId'";
//	echo "<br>$sql1<br>";
	$sqlq1=mysql_query($sql1);
	$sqlr1=mysql_fetch_array($sqlq1);
    $totalAdv=$sqlr1[amount];   
  $remain=$totalAdv-$totalAdvCut;
  if($remain) return $remain;
  else return '';
}
/* employss advanced salary adjust*/

function advanceSadjust($empId,$month){
$sql="select * from empsalaryad where empId='$empId' AND pdate<'2010-".$month."-01' AND status='2'";
//echo "<br>$sql<br>";
$sqlq=mysql_query($sql);
$sqlr=mysql_fetch_array($sqlq);
if($sqlr[pmonth]){
$adCut=$sqlr[amount]/$sqlr[pmonth];

$remainAdv=remainAdv($empId);
if($remainAdv<$adCut)$adCut=$remainAdv;

return $adCut.'/'.$sqlr[paymentSL];
}
return '';
}
/* check is porder amount full paid !*/
function poFullPaid($posl){
$sql="SELECT (totalAmount-paidAmount) as isFullPaid from popayments WHERE posl='$posl'";
$sqlq=mysql_query($sql);
$sqlr=mysql_fetch_array($sqlq);
if($sqlr[isFullPaid]==0) return 0;
else return 1;
}
function chkReceiveSl($challanNo,$project){
$sql="select * from store$project";

}

/* return fooding amount in a porder*/
function foodinfAmount($poamount,$receiveAmount,$paidAmount,$posl){

$sqlp1 = "SELECT * from  `pcondition` WHERE posl='$posl'";
//echo $sqlp1;
$sqlrunp1= mysql_query($sqlp1);
$typel2= mysql_fetch_array($sqlrunp1);

$temp=explode('_',$typel2[condition]);
//print_r($temp);
$advanceAmountp=$temp[32];//amount;
$advanceCut=($receiveAmount*$advanceAmountp)/100;
$advance=$temp[33];
//echo "$advanceAmountp=$advance++";
//echo "<br>**ADVp=$advanceAmountp++advanceCut=$advanceCut**</br>";

$foodingp = $temp[36];//amount
$foodingAmount=($receiveAmount*$foodingp)/100;
//echo "<br>##$foodingp= $foodingAmount####<br>";
$payable=($advance+$foodingAmount)-$advanceCut;
//echo "##$payable=($advance+$foodingAmount)-$advanceCut;";
$actualPayable=$payable-$paidAmount;
//echo "**$retention**$amountGt**";
if($actualPayable>0) return $actualPayable;
else return 0;
}
/* duration between two dates*/
function duration($date1,$date2){
//echo "**$date2=$date1**";
  $duration = (strtotime($date2)-strtotime($date1))/86400;
  return $duration+1;
}

function accountType($f){
   $cr= array(10,6,16,19,16,21,14,12);
   $dr= array(1,0,23,24,5,2,8,4);

$type=array( "10"=>'Accounts Payable',"1"=>'Accounts Receivable',"6"=>'Accmulated Depreciation',"0"=>'Cash',"3"=>'Bank',"23"=>'Cost of Sales',
"16"=>'Equity-dosenot close',"19"=>'Equity gets closed',"18"=>'Equity-Retained Earnings',"24"=>'Expenses',"5"=>'Fixed Assets',
"21"=>'Income',"2"=>'Inventory',"14"=>'Long Term Liabilities',"8"=>'Other Assets',"4"=>'Other Current Assets',"12"=>'Other Current Liabilities');

   return $type[$f];
}
 
function viewAccountType($f){
$t=explode('-',$f);	
$f=$t[0];

$sql="select accountType from accounts where accountId='$f'";
$sqlq=mysql_query($sql);
$sqlr=mysql_fetch_array($sqlq);
   $cr= array(10,6,16,19,16,21,14,12);
   $dr= array(1,0,23,24,5,2,8,4);

$type=array( "10"=>'Accounts Payable',"1"=>'Accounts Receivable',"6"=>'Accmulated Depreciation',"0"=>'Cash',"3"=>'Bank',"23"=>'Cost of Sales',
"16"=>'Equity-dosenot close',"19"=>'Equity gets closed',"18"=>'Equity-Retained Earnings',"24"=>'Expenses',"5"=>'Fixed Assets',
"21"=>'Income',"2"=>'Inventory',"14"=>'Long Term Liabilities',"8"=>'Other Assets',"4"=>'Other Current Assets',"12"=>'Other Current Liabilities');

 return $type[$sqlr[accountType]];
}
 
function accountDrCr($f){
include("config.inc.php");
	$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 
	
$t=explode('-',$f);	
$f=$t[0];
$sql="SELECT accountType from accounts WHERE accountID='$f'";
//echo '<br>'.$sql.'<br>';
$sqlq=mysql_query($sql);
$sqlr=mysql_fetch_array($sqlq);
$acctype=$sqlr[accountType];
   $cr= array(10,6,16,19,16,18,21,14,12);
   $dr= array(1,0,3,23,24,5,2,8,4);

$type=array( "10"=>'cr',"1"=>'dr',"6"=>'cr',"0"=>'dr',"3"=>'dr',"23"=>'dr',
"16"=>'cr',"19"=>'cr',"18"=>'cr',"24"=>'dr',"5"=>'dr',
"21"=>'cr',"2"=>'dr',"14"=>'cr',"8"=>'dr',"4"=>'dr',"12"=>'cr');


 return $type[$acctype];
}

 
/* ---------------------------
 Input the GL 
 return the GL Name
------------------------------*/

function accountName($p)
{
 include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

$temp=explode('-',$p);

 $sql=" SELECT description,accountType  FROM accounts where accountID= '$temp[0]'" ;
// echo $sql.'<br>';
 $sql=mysql_query($sql) ; 
 $row=mysql_num_rows($sql);
 if($row){ $pn=mysql_fetch_array($sql);
	   $aname = "$pn[description]";
if($temp[0]=='5700000'){$aname=$aname.'-'.empName($temp[1]);}
if($pn[accountType]=='12'){$aname=$aname.'-'.landeName($temp[1]);}//if($pn[accountType]=='12')
   return $aname;
  }//if($row)
  return $p;
}

function landeName($id){
include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

 $sql=" SELECT *  FROM lander where id= '$id'" ;
// echo $sql.'<br>';
 $sql=mysql_query($sql) ; 
 $pn=mysql_fetch_array($sql);
 return $pn[landerName];
 }
/* ---------------------------
 Input the posl 
 return the amount Due
 not update
------------------------------*/
function poReeiveAmount($p)
{
 $sql=mysql_query(" SELECT receiveAmount FROM popayments where posl= '$p'") ;
  $pn=mysql_fetch_array($sql);
  $paymentDuef = "$pn[receiveAmount]";
   return $paymentDuef;
}
 
/* ---------------------------
 Input the posl 
 return the amount Due
 not update
------------------------------*/
function popaymentPaid($p)
{
 $sqlq=" SELECT paidAmount FROM popayments where posl= '$p'" ;
// echo  $sqlq;
 $sql=mysql_query($sqlq) ; 
  $pn=mysql_fetch_array($sql);
  $paymentPayf = "$pn[paidAmount]";
   return $paymentPayf;
}
/* ---------------------------
 Input the posl 
 return the amount Due
 not update
------------------------------*/
function popaymentReamin($p)
{
 $sqlq=" SELECT (totalAmount-paidAmount) remainAmount FROM popayments where posl= '$p'" ;
// echo  $sqlq;
 $sql=mysql_query($sqlq) ; 
  $pn=mysql_fetch_array($sql);
  $paymentPayf = $pn[remainAmount];
   return $paymentPayf;
}
 
/* return purchase order total amount*/
function poTotalAmount($posl){

$sqlp11 = "SELECT totalAmount from  `popayments` WHERE posl='$posl'";
//echo $sqlp11;
$sqlrunp11= mysql_query($sqlp11);
$typel21= mysql_fetch_array($sqlrunp11);
$amount = $typel21[totalAmount];
return $amount;
}
/*--------------------------------
 Input the ItemCode Code
 return the GLinventory
---------------------------------*/

function getitemGL($a){

 $sql="SELECT * FROM itemlist WHERE itemCode = '$a'";
//echo '<br>'.$sql.'<br>';
 $sql=mysql_query($sql); 
 $pn=mysql_fetch_array($sql);
  
return $pn[GLinventory];
}
/* ---------------------------
 Input the Account ID
 return the Account Balance
------------------------------*/
function acctBalance($p)
{
$balancef=0;
 include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

 $sql=mysql_query(" SELECT balance FROM accounts where accountID= '$p'") ;
  $pn=mysql_fetch_array($sql);
  $balancef = "$pn[balance]";
   return $balancef;
}
// Input  project selection name
// return project selectin

function selectAlist($n,$l,$s){
include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 
if($l=='*')
$sqlp = "SELECT * from `accounts` ORDER by accountID ASC";
else 
$sqlp = "SELECT * from `accounts` WHERE accountType in ($l)  ORDER by accountID ASC";
//echo $sqlp;
$sqlrunp= mysql_query($sqlp);
 
$plist= "<select name='$n'> ";

 while($typel= mysql_fetch_array($sqlrunp))
{
 $plist.= "<option value='".$typel[accountID]."'";
 if($s==$typel[accountID])  $plist.= " SELECTED";
 $plist.= ">$typel[accountID]--$typel[description]</option>  ";
 }
 $plist.= '</select>';
 return $plist;
 }
// Input  project selection name
// return project selectin

function cp_selectAlist($n,$l,$s){
include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 
if($l=='000') $sqlp = "SELECT * from `accounts` WHERE accountType in (1,3,5,8,12,16,19,10,4,24)".
" AND (accountID <> '1000000' AND accountID <> '1400000' AND accountID <> '1500000' AND accountID <> '1600000'".
" AND accountID <> '2200000' AND accountID <> '3100000' AND accountID <> '3200000' AND accountID <> '3300000'".
" AND accountID <> '3400000' AND accountID <> '3600000' AND accountID <> '3700000' AND accountID <> '3800000'".
" AND accountID <> '5000000' AND accountID <> '5100000' AND accountID <> '5200000' AND accountID <> '5500000'".
" AND accountID <> '5600000' AND accountID <> '5700000' AND accountID <> '6400000' ".
" AND accountID <> '6901000' AND accountID <> '6800000' AND accountID <> '6900000' AND accountID <> '7000000'".
" AND accountID <> '7900000' AND accountID <> '8500000' AND accountID <> '8600000') 
 ORDER by accountID ASC
";

else 
$sqlp = "SELECT * from `accounts` WHERE accountType in (24)
 AND (accountID <> '6901000' AND accountID <> '6800000' AND accountID <> '6900000' AND accountID <> '7000000'
  AND accountID <> '7900000' AND accountID <> '8500000' AND accountID <> '8600000')";
//echo $sqlp;
$sqlrunp= mysql_query($sqlp);


$sqlrunp= mysql_query($sqlp);

$plist= "<select name='$n'> ";
 while($typel= mysql_fetch_array($sqlrunp))
{
 $plist.= "<option value='".$typel[accountID]."'";
 if($s==$typel[accountID])  $plist.= " SELECTED";
 $plist.= ">$typel[accountID]--$typel[description]</option>  ";
 }
 $plist.= '</select>';
 return $plist;
 }
/*--------------------------------
 Input the ItemCode Code
 return the GLinventory
---------------------------------*/

function poAcct($a){

 $sql="SELECT acctPayable FROM popayments WHERE posl = '$a'";
//echo '<br>'.$sql.'<br>';
 $sql=mysql_query($sql); 
 $pn=mysql_fetch_array($sql);  
return $pn[acctPayable];
}
/* ---------------------------
 Input the posl 
 return the Total Receive
------------------------------*/
function poTotalreceive($posl,$p)
{
$t=explode('_',$posl);
$v=$t[3];
//echo "##VVVVVVVVVVVVVVVVVVV=$v ##";
if($v==99){
$sql2="SELECT DISTINCT paymentSL FROM storet$p WHERE reference='$posl'" ; 
//echo "$sql2<br>";
$sqlq2=mysql_query($sql2) ; 
while($r=mysql_fetch_array($sqlq2)){
	$sql="SELECT SUM(receiveQty*rate) as total FROM store$p WHERE paymentSL='$r[paymentSL]'" ; 
	//echo "$sql<br>";
	$sqlq=mysql_query($sql) ; 
	$pn=mysql_fetch_array($sqlq);
	$total+=round($pn[total],2);
  }
  return $total;
}//if($v==99)
else{
	$sql="SELECT SUM(receiveQty*rate) as total FROM store$p WHERE paymentSL='$posl'" ; 
	//echo $sql;
	$sqlq=mysql_query($sql) ; 
	$pn=mysql_fetch_array($sqlq);
	return round($pn[total],2);
  }//else
}
 function totalReceiveAmount($from,$to,$p){
 $totalSubworkReceive=totalSubworkReceive($from,$to,$p);
 $totalMaterialReceive=totalMaterialReceive($from,$to,$p);
 $totalequipmentReceive=totalequipmentReceive($from,$to,$p);
 return $totalSubworkReceive+$totalMaterialReceive+$totalequipmentReceive;
 } 
  /* return total paid amount of material porder*/
 function mat_vanPayment($from,$to,$p){
 $sql="SELECT posl,paidAmount 
 from vendorpayment  
 where paymentDate between '$from' and '$to' 
 AND posl LIKE '___".$p."_%'";
//echo "$sql<br>";
 $sqlq=mysql_query($sql);
 while($r=mysql_fetch_array($sqlq)){
 if(poType($r[posl])==1)$totalAmount+=$r[paidAmount];
 }//while
 return $totalAmount;
 }
 /* return total paid amount of equipment porder*/ 
 function eq_vanPayment($from,$to,$p){
 $sql="SELECT posl,paidAmount 
 from vendorpayment  
 where paymentDate between '$from' and '$to' 
 AND posl LIKE '___".$p."_%'";
//echo "$sql<br>";
 $sqlq=mysql_query($sql);
 while($r=mysql_fetch_array($sqlq)){
 if(poType($r[posl])=='2')$totalAmount+=$r[paidAmount];
 }//while
 return $totalAmount;
 }
 /* return total paid amount of subcontractor porder*/ 
 function sub_vanPayment($from,$to,$p){
 $sql="SELECT posl,paidAmount 
 from vendorpayment  
 where paymentDate between '$from' and '$to' 
 AND posl LIKE '___".$p."_%'";
//echo "$sql<br>";
 $sqlq=mysql_query($sql);
 while($r=mysql_fetch_array($sqlq)){
 if(poType($r[posl])=='3')$totalAmount+=$r[paidAmount];
 }//while
// echo "totalAmount=$totalAmount//";
 return $totalAmount;
 }
/* return total material receive from porder*/
function mat_po_Receive($from,$to,$p){
$sql="select SUM(receiveQty*rate) as amount 
from `store$p` 
WHERE paymentSL like 'PO_%' AND  todat between '$from' and '$to'";  
//echo "$sql";
$sqlq2=mysql_query($sql) ; 
$po=mysql_fetch_array($sqlq2);
$subAmount1=$po[amount];

$sql3="SELECT SUM( receiveQty * rate )as amount 
FROM `storet$p` 
WHERE paymentSL LIKE 'ST_%' AND todat between '$from' and '$to'  ";
$sqlq3=mysql_query($sql3) ; 
$po3=mysql_fetch_array($sqlq3);
$subAmount2=$po3[amount];
 return round($subAmount1+$subAmount2,2);
}
/* ---------------------------
 return total material receive in project
 -----------------------------*/
function totalMaterialReceive($from,$to,$p)
{
$sql="select SUM(receiveQty*rate) as amount 
from `store$p` 
WHERE todat between '$from' and '$to'";  
//echo "$sql";
$sqlq2=mysql_query($sql) ; 
$po=mysql_fetch_array($sqlq2);
$subAmount=$po[amount];
 return $subAmount;
}
/* ---------------------------
return total inventory in transit amount in a project
------------------------------*/
function current_Inventory_intransit($from,$to,$p)
{
$sql="select SUM(receiveQty*rate) as amount 
from `storet$p` 
WHERE todat between '$from' and '$to'";  
//echo "$sql";
$sqlq2=mysql_query($sql) ; 
$po=mysql_fetch_array($sqlq2);
$subAmount1=$po[amount];


$sql2="select SUM(receiveQty*rate) as amount 
from `store$p` 
WHERE (paymentSL LIKE 'cash_%' OR paymentSL LIKE 'EP_%' OR paymentSL LIKE 'ST_%')  
AND todat between '$from' and '$to'";  
//echo "$sql";
$sqlq2=mysql_query($sql2) ; 
$po2=mysql_fetch_array($sqlq2);
$subAmount2=$po2[amount];

//echo "**$subAmount1-$subAmount2**";
 return $subAmount1-$subAmount2;

}
/* ---------------------------
return current balance of center store
------------------------------*/
function centerStoreBalance()
{
$sql="select SUM(currentQty*rate) as amount from `store`";  
//echo "$sql";
$sqlq2=mysql_query($sql) ; 
$po=mysql_fetch_array($sqlq2);
$subAmount=$po[amount];
 return $subAmount;
}
/* ---------------------------
 Input the posl 
 return the Total Receive
------------------------------*/
function totalequipmentReceive($from,$to,$p)
{
 include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

$sql2="SELECT posl FROM porder WHERE  location= '$p' AND poType=2 AND status>1" ; 
// echo $sql;
 $sqlq2=mysql_query($sql2) ; 
  while($po=mysql_fetch_array($sqlq2)){
$sql="SELECT * FROM porder where posl='$po[posl]'";
//echo $sql;
$sqlq=mysql_query($sql);
while($r=mysql_fetch_array($sqlq)){
$itemCode=$r[itemCode];
$rate=$r[rate]/8;

$sql="SELECT * from eqproject where posl='$posl' AND itemCode='$itemCode'";
//echo $sql;
$sqlq=mysql_query($sql);
while($eq=mysql_fetch_array($sqlq)){
$eqId=$eq[assetId];
//$itemCode=$eq[itemCode];
//echo "<br>eqId=$eqId<br>";
$sDate=$eq[receiveDate];
if($eq[status]==1)
$inDate=todat();
else $inDate=$eq[edate];

 if($eqId{0}=='A') $eqType='L';
 else  $eqType='H';

$sqlut = "SELECT DISTINCT edate FROM eqattendance WHERE".
" eqId='$eqId' AND itemCode='$itemCode' AND location='$project'".
" AND edate BETWEEN '$sDate' AND '$inDate'".
" ORDER by edate ASC";
//echo $sqlut;
$sqlqut= mysql_query($sqlut);
$i=1;
$sqlr=mysql_num_rows($sqlqut);
 while($reut= mysql_fetch_array($sqlqut))
{
	$dailyworkBreakt=eq_dailyworkBreak($eqId,$itemCode,$reut[edate],$eqType,$project);
	$toDaypresent=eq_toDaypresent($eqId,$itemCode,$reut[edate],$eqType,$project);
    $toDaypresent=$toDaypresent-$dailyworkBreakt;	

	$totalTime+=$toDaypresent;

  }
//  echo sec2hms($toDaypresent,$padHours=false).'<br>';
  $totalAmount+=$totalTime*($rate/3600);
 }//while 
 }//while po
 }
  return $subAmount;
}
/* ---------------------------
 Input the Query 
 return the total Row
------------------------------*/

function insertedRows($q)
{
 $sql=$q;
// echo $sql;
  $sqlqf=mysql_query($sql) ; 
  $sqlr=mysql_fetch_array($sqlqf);
  $tt=explode('_',$sqlr[paymentSL]);
  $sln=$tt[2];
//  echo $sqlr[paymentSL];
 //$row=mysql_num_rows($sqlqf);
 return $sln+1;
}
/* ---------------------------
 Input the Query 
 return the total Row
------------------------------*/

function insertPurchase($paymentSL,$paymentDate, $paidTo, $account,$exFor,$paidAmount, $reff,$location)
{
$row=0;
 include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

$query="INSERT INTO purchase (prId, paymentSL, paymentDate, paidTo, account,exFor, paidAmount, reff,location)".
  "VALUES ('','$paymentSL','$paymentDate', '$paidTo', '$account','$exFor','$paidAmount', '$reff','$location')";
//echo $query.'<br>';
$qqf=mysql_query($query);

 return $row;
}
/* ---------------------------
return paymentSL of given refference
------------------------------*/
function paymentSL($id)
{
 $sqlf=" SELECT paymentSL FROM `purchase` where reff= '$id'" ;
//echo $sqlf;
 $sqlqf=mysql_query($sqlf) ; 
  $pn=mysql_fetch_array($sqlqf);
  $paymentDuef = "$pn[paymentSL]";
  return $paymentDuef;
}
/* ---------------------------
return payament details of a payment sl
------------------------------*/
function paymentDes($id)
{
 $sqlf=" SELECT paidTo FROM `purchase` where paymentSL= '$id'" ;
//echo $sqlf;
 $sqlqf=mysql_query($sqlf) ; 
  $pn=mysql_fetch_array($sqlqf);
  $paymentDuef = "$pn[paidTo]";
  return $paymentDuef;
}
/* ---------------------------
not update
------------------------------*/
function isProjectAccount($pl,$p)
{
 $sqlf=" SELECT account FROM `purchase` where paymentSL= '$pl'" ;
//echo $sqlf;
 $sqlqf=mysql_query($sqlf) ; 
 $pn=mysql_fetch_array($sqlqf);
 $acc=$pn[account];
 $acb="5502000-$p";
 
// echo $acc.'=='.$acb.'<br>';
 if($acc==$acb)  return 1;
  else return 0;
}
/* ---------------------------
not update
------------------------------*/
function isposl($pl,$l)
{
 $sqlf=" SELECT paymentSL FROM `purchase` where paymentSL LIKE '%_".$pl."_%' AND location='$l'" ;
//echo $sqlf;
 $sqlqf=mysql_query($sqlf) ; 
 $row=mysql_num_rows($sqlqf);
 //echo 'Row: '.$row;
 if($row>0) return 0;
  else return 1;
}
/* ---------------------------
return total emmergency purchase of a proder, item in a project
------------------------------*/
function epPurchased($posl,$item,$exfor)
{
 $sqlf=" SELECT sum(receiveQty) as total 
 FROM `storet$exfor` 
 where reference LIKE '$posl' AND itemCode='$item'" ;
//echo $sqlf;
 $sqlqf=mysql_query($sqlf) ; 
 $ref = mysql_fetch_array($sqlqf);
 return $ref[total];
}
/* ---------------------------
return total emmergency purchase in a project of an item
------------------------------*/
function epTotalPurchased($item,$exfor)
{
 $sqlf=" SELECT sum(receiveQty) as total 
 FROM `storet$exfor` 
 where itemCode='$item' AND (paymentSL LIKE 'EP_%' OR paymentSL LIKE 'cash_%')" ;
//echo $sqlf.'<br>';
 $sqlqf=mysql_query($sqlf) ; 
 $ref = mysql_fetch_array($sqlqf);

return $ref[total];
}
/* genetate receive serial no*/
function receiveSL($receiveSL,$w){
//echo "W=$w";
if($w==1) $s='client';
elseif($w==2) $s='lender';
elseif($w==3) $s='other';

$sqlf="select rid from receivecash WHERE receiveSL like '".$s."_%' order by rid DESC ";
//echo "$sqlf";
$sqlfq=mysql_query($sqlf);
$r=mysql_fetch_array($sqlfq);
$re=$r[rid]+1;

//$newReceiveSL=$s.'_'.$receiveSL;
$newReceiveSL=$s.'_'.$re;
return $newReceiveSL;

}
function checkReceiveSL($receiveSL,$w){
if($w==1) $s='client';
elseif($w==2) $s='lender';
elseif($w==3) $s='other';
$newReceiveSL=$s.'_'.$receiveSL;
$sqlf="select receiveSL from receivecash WHERE receiveSL='$newReceiveSL'";
//echo $sqlf;
$sqlfq=mysql_query($sqlf);
$r=mysql_num_rows($sqlfq);
if($r>=1) return 1;
else return 0;
}
function viewAccSL($sl){
$t=explode('_',$sl);
return $t[1];
}
/* return invoice tax */
function invoiceTax($p){
$sqlf="select tax from project WHERE pcode='$p'";
//echo $sqlf;
$sqlfq=mysql_query($sqlf);
$r=mysql_fetch_array($sqlfq);
$tax=$r[tax];
if($tax>0) return $tax;
else return 0;
}
/* return invoice date*/
function invoiceVat($p){
$sqlf="select vat from project WHERE pcode='$p'";
//echo $sqlf;
$sqlfq=mysql_query($sqlf);
$r=mysql_fetch_array($sqlfq);
$vat=$r[vat];
if($vat>0) return $vat;
else return 0;
}
/* return retention amount in a project*/
function invoiceRetention($p){
$sqlf="select retentionTaka from project WHERE pcode='$p'";
//echo $sqlf;
$sqlfq=mysql_query($sqlf);
$r=mysql_fetch_array($sqlfq);
$retentionPer=$r[retentionTaka];
if($retentionPer>0) return $retentionPer;
else return 0;
}
/* return advance remain in a invoice*/
function invoiceAdv_remain($invoiceNo,$Advamount){
$sqlf="select SUM(amount)  AS totalAdvAdj from invoiceadv WHERE reff='$invoiceNo'";
//echo $sqlf;
$sqlfq=mysql_query($sqlf);
$r=mysql_fetch_array($sqlfq);
$advAdj=$r[totalAdvAdj];
$balance=$Advamount-$advAdj;
//echo "**$balance=$Advamount-$advAdj**";
if($balance>0){
return $balance;
}
else return 0;
}
/* return retention date of a project*/
function invoiceRetention_date($p){
$retentionDate=0;
$sqlf="select * from invoice WHERE invoiceType='3'";
//echo $sqlf;
$sqlfq=mysql_query($sqlf);
$re=mysql_fetch_array($sqlfq);
$invoiceDate=$re[invoiceDate];

$r=mysql_num_rows($sqlfq);
if($r>=1){
	$sqlf="select DATE_ADD('$invoiceDate',INTERVAL retentionPer DAY) as retentionDate  from project WHERE pcode='$p'";
//echo "$sqlf";	
	$sqlfq=mysql_query($sqlf);
	$r=mysql_fetch_array($sqlfq);
	$retentionDate=$r[retentionDate];
}
if($retentionDate>0) return $retentionDate;
else return 0;
}
/* return invoice type*/
function viewInvoiceType($type){
switch($type){
	case 1: return 'Advance';
	case 2: return 'Running';
	case 3: return 'Final';
	case 4: return 'Retaintion';
	case 5: return 'Compansation';
	default: return 'Error';
	}
}
/* return total invoiced amount in a project*/
function totalInvoiceAmount_date($p,$from,$to){
$sqlf="select SUM(invoiceAmount) as totalInvoiceAmount 
from invoice 
WHERE invoiceDate between ' $from' AND '$to'  AND invoiceLocation='$p'";
//echo $sqlf.'<br>';
$sqlfq=mysql_query($sqlf);
$re=mysql_fetch_array($sqlfq);
$totalInvoiceAmount=$re[totalInvoiceAmount];

return $totalInvoiceAmount;
}
/* total amount receive from invoice */
function totalInvoiceReceive_date($p,$from,$to){
 $sqlf="select SUM(receiveAmount) as total 
 from `receivecash` 
 WHERE receiveDate between '$from' AND '$to' AND receiveFrom ='$p' ";
//echo $sqlf.'<br>';
$sqlfq=mysql_query($sqlf);
$re=mysql_fetch_array($sqlfq);
$total=$re[total];

return $total;
}
/* return total material issued amount in direct IOW in a project--6801000*/
function total_mat_directissueAmount_date($pcode,$from,$to){

$sql="select SUM(issuedQty*issueRate) as amount 
      from `issue$pcode`,iow 
	  WHERE issueDate between '$from' and '$to' 
	  AND iow.iowId=issue$pcode.iowId 
	  AND iow.iowType='1'";  
 // echo $sql.'<br>';
  $sqlQ=mysql_query($sql);
  $re=mysql_fetch_array($sqlQ);
  return $re[amount];
}
/* return total material issued amount in indirect IOW in a project--6902010*/
function total_mat_indirectissueAmount_date($pcode,$from,$to){

$sql="select SUM(issuedQty*issueRate) as amount 
      from `issue$pcode`,iow 
	  WHERE issueDate between '$from' and '$to' 
	  AND iow.iowId=issue$pcode.iowId 
	  AND iow.iowType='2'";  
 // echo $sql.'<br>';
  $sqlQ=mysql_query($sql);
  $re=mysql_fetch_array($sqlQ);
  return $re[amount];
}
/* return total material issued amount in a project*/
function total_mat_issueAmount_date($pcode,$from,$to){

$sql="select SUM(issuedQty*issueRate) as amount
 from `issue$pcode` WHERE 
 issueDate between '$from' and '$to'";  
  //echo $sql.'<br>';
  $sqlQ=mysql_query($sql);
  $re=mysql_fetch_array($sqlQ);
  return $re[amount];
}
/* return total amount equipment expend in a project --6802000 */
function total_eq_direct_issueAmount_date($pcode,$fromDate,$toDate){
  $sql="select COUNT(id) as total,itemCode,posl 
	from eqattendance  
	WHERE edate between '$fromDate' and '$toDate' 
	AND location ='$pcode' 
    group by posl,itemCode 
	order by edate ASC ";
	 
//echo $sql;
  $sqlQ=mysql_query($sql);
$i=1;  
  while($st=mysql_fetch_array($sqlQ)){
	$rate=eqpoRate($st[itemCode],$st[posl]);
	$pamount=$st[total]*$rate;
	$amount+=$pamount;
  }//while st

	return $amount;
 }
/* return total payable of 2402000     */
function eqCurrentPayable($pcode,$fromDate,$toDate){
$openingBalance=openingBalance('2402000',$fromDate,$pcode);

	
    /*$sql="select edate, posl from eqattendance".
	"  WHERE edate between '$fromDate' and '$toDate' AND location ='$pcode' GROUP by edate,posl order by edate ASC ";
	*/
 $sql="select COUNT(id) as total,itemCode,posl 
	from eqattendance  
	WHERE edate between '$fromDate' and '$toDate' 
	AND location ='$pcode' 
    group by posl,itemCode 
	order by edate ASC ";	
//echo $sql;
  $sqlQ=mysql_query($sql);
$i=0;  
  while($st=mysql_fetch_array($sqlQ)){
	$pamount=0;
	$rate=eqpoRate($st[itemCode],$st[posl]);
	$pamount=$st[total]*$rate;

   $totalRceive+=$pamount;  
  }//while st
  
  
 
$sql1="SELECT paidAmount as amount,paymentSL,paymentDate,posl from vendorpayment WHERE".
" paymentDate BETWEEN '$fromDate' AND '$toDate' AND posl LIKE 'EQ_".$pcode."_%' Order by paymentDate ASC";
//echo $sql1;
$sqlq1=mysql_query($sql1);
while($st=mysql_fetch_array($sqlq1)){
$totalPaid+=$st[amount];
  }
  
  return $totalRceive-$totalPaid;
 }

/* return total wages paid */
function total_monthlyWages_date($pcode,$from,$to){

$sql="select SUM(amount) as amount 
from `empsalary`      
WHERE pdate between '$from' AND '$to' AND glCode LIKE '2404000-$pcode'";
// echo $sql.'<br>';
  $sqlQ=mysql_query($sql);
  $re=mysql_fetch_array($sqlQ);
  return $re[amount];
}
/* return direct total wages paid*/
function total_wagesAmount_date($pcode,$fromDate,$toDate){
$sql="select SUM(examount) as amount 
from `ex130`  
WHERE exDate between '$fromDate' and '$toDate'  AND exgl like '6902000-$pcode' ";
	   
  $sqlQ=mysql_query($sql);
  $re=mysql_fetch_array($sqlQ);
  return $re[amount];
}
/* return direct total wages paid*/
function direct_total_wagesPaid_date($pcode,$from,$to){

$sql="select SUM(amount) as amount 
from `empsalary` 
WHERE pdate between '$from' AND '$to' AND glCode LIKE '6902000-$pcode' ";
 // echo $sql.'<br>';
  $sqlQ=mysql_query($sql);
  $re=mysql_fetch_array($sqlQ);
  return $re[amount];
}
/* return total salary paid*/
function total_salaryAmount_date($pcode,$from,$to){
$sql="select SUM(amount) as amount 
from `empsalary`      
WHERE pdate between '$from' AND '$to' AND glCode LIKE '6901000-$pcode' ";
// echo $sql.'<br>';
  $sqlQ=mysql_query($sql);
  $re=mysql_fetch_array($sqlQ);
  return $re[amount];
}
/* return total salary paid*/
function total_salaryPaid_date($pcode,$from,$to){

$sql="select SUM(amount) as amount 
from `empsalary` 
WHERE pdate between '$from' AND '$to' AND glCode LIKE '6901000-$pcode' ";
 // echo $sql.'<br>';
  $sqlQ=mysql_query($sql);
  $re=mysql_fetch_array($sqlQ);
  return $re[amount];
}
/* total direct wages amont receive*/
function directwagesAmount_date($pcode,$from,$to){//echo wagesAmount_date('002','2006-11-01','2006-11-30');


$sqlp="SELECT DISTINCT attendance.empId,designation,name,salary,allowance FROM attendance,employee".
" WHERE salaryType LIKE 'Wages%'".
" AND attendance.location='$pcode' AND attendance.action in ('P','HP')".
" AND attendance.edate between '$from' AND '$to'".
" AND attendance.empId=employee.empId";
//echo $sqlp.'<br>';
$sqlrunp= mysql_query($sqlp);
$b=1;
$totalAmount=0;

while($re=mysql_fetch_array($sqlrunp)){

$presentTotal=0;
$overtimeTotal=0;
$workedTotal=0;
$idleTotal=0;

$sqlquery1="SELECT * FROM attendance".
" where attendance.location='$pcode' ".
"AND attendance.edate BETWEEN '$from' AND '$to'".
" AND action in('P','HP') AND attendance.empId= $re[empId]";
//echo "$sqlquery1<br>";

 $sql1= mysql_query($sqlquery1);
 while($re1=mysql_fetch_array($sql1)){
  $workt=emp_direct_dailywork($re[empId],$re1[edate],'H',$pcode);
  $workedTotal=$workedTotal+$workt;
 }
 
$totalPresent = local_TotalPresentHr($from,$to,$re[empId],'H',$pcode); 
$atAmount=normalDayAmount($re[salary],$re[allowance],$from,$totalPresent)/86400;

$amount=$atAmount*$workedTotal;
$totalAmount+= $amount; 
//echo "**totalAmount=$amount**$atAmount##<br>";
$amount=0;
 }

return $totalAmount;
}
/* return total wages amount receive*/
function wagesAmount_date($pcode,$from,$to){//echo wagesAmount_date('002','2006-11-01','2006-11-30');


$sqlp="SELECT DISTINCT attendance.empId,designation,name,salary,allowance FROM attendance,employee".
" WHERE salaryType LIKE 'Wages%'".
" AND attendance.location='$pcode' AND attendance.action in ('P','HP')".
" AND attendance.edate between '$from' AND '$to'".
" AND attendance.empId=employee.empId";
//echo $sqlp.'<br>';
$sqlrunp= mysql_query($sqlp);
$b=1;
$totalAmount=0;

while($re=mysql_fetch_array($sqlrunp)){

$presentTotal=0;
$overtimeTotal=0;
$workedTotal=0;
$idleTotal=0;

$sqlquery1="SELECT * FROM attendance 
 where attendance.location='$pcode'  
 AND attendance.edate BETWEEN '$from' AND '$to'
 AND action in('P','HP') AND attendance.empId= '$re[empId]'";
//echo "$sqlquery1<br>";

 $sql1= mysql_query($sqlquery1);
 while($re1=mysql_fetch_array($sql1)){
 
 	$dailyworkBreakt=dailyworkBreak($re[empId],$re1[edate],'H',$pcode);	
	$toDaypresent=toDaypresent($re[empId],$re1[edate],'H',$pcode);	
	$toDaypresent=$toDaypresent-$dailyworkBreakt;	
	
//echo "<br>toDaypresent:$toDaypresent<br>";	
if(date('D',strtotime($re1[edate]))=='Fri')
 $overtimet = $toDaypresent-(4*3600);
else 
	$overtimet = $toDaypresent-(8*3600);

//	$overtimet = $toDaypresent-8*3600;
	if($overtimet<0) $overtimet=0;

$presentTotal=$presentTotal+$toDaypresent;   
$overtimeTotal=$overtimeTotal+$overtimet;
$workedTotal=$workedTotal+$workt;
 }
$totalPresent = local_TotalPresentHr($from,$to,$re[empId],'H',$pcode); 
$atAmount=normalDayAmount($re[salary],$re[allowance],$from,$totalPresent);
$otAmount=otRate($re[salary],$from)*($overtimeTotal/3600);
$amount=$otAmount+$atAmount;
$totalAmount+= $amount; 
/*echo "atAmount=$atAmount******otAmount=$otAmount";
 echo "totalAmount=$totalAmount**$amount<br>";
 */
 }
 //echo "$from,$to==$totalAmount<br>";
return $totalAmount;
}
/* return total salary amount receive form employee*/
function total_salaryReceived_date($pcode,$from,$to){//echo wagesAmount_date('002','2006-11-01','2006-11-30');

$sqlp="SELECT DISTINCT attendance.empId,designation,name,salary,allowance FROM attendance,employee 
 WHERE salaryType LIKE 'Salary' 
 AND attendance.location='$pcode' AND attendance.action in ('P') 
 AND attendance.edate between '$from' AND '$to' 
 AND attendance.empId=employee.empId ";
//echo $sqlp.'<br>';
$sqlrunp= mysql_query($sqlp);
$b=1;
$totalAmount=0;
$month=date("m",strtotime($from));
$year=date("Y",strtotime($from));
while($re=mysql_fetch_array($sqlrunp)){
 $totalPresent=emp_monthlyStay_project($re[empId],$month,$year,$pcode);
 $daysofmonth = daysofmonth($from);
 $perdaySalary=$re[salary]/$daysofmonth;
 $subTotal+=$totalPresent*$perdaySalary;
 
 //echo "";
 //echo "<br>$re[empId]==$subTotal=$totalPresent*$perdaySalary;**<br>";
 }
 //echo "$from,$to==$totalAmount<br>";
return $subTotal;
}
/* return tota expense in a project between given period of a code*/
function total_exAmount_date($pcode,$from,$to,$glCode){
$sql="SELECT SUM(examount) as amount 
FROM `ex130` 
WHERE exDate between '$from' AND '$to' AND exGL LIKE '$glCode-$pcode' 
GROUP by exgl ";  
	  
// echo $sql.'<br>';
  $sqlQ=mysql_query($sql);
  $re=mysql_fetch_array($sqlQ);
  return $re[amount];
}
?>

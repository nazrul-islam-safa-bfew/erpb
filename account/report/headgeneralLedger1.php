

<table  width="850" align="center" border="1" bordercolor="#F4F4F4" cellpadding="0" cellspacing="0"  style="border-collapse:collapse;font-size: 10px;" >
 <tr bgcolor="#CCFF99">
   <th align="center" valign="top" width="200">Account ID</th>   
   <th align="center" valign="top" width="100">Date</th>
   <th align="center" valign="top">Reference</th>
   <th align="center" valign="top">Jrnl</th>   
   <th align="center" valign="top" width="200">Description</th>   
   <th align="right" valign="top" width="100">Debit Amount</th>   
   <th align="right" valign="top" width="100">Credit Amount</th> 
   <th align="center" valign="top" width="100">Balance</th>
 </tr>
 
 <?  
if($pcode=='000')
{
$apcode=array();
$sql="SELECT `pcode` from `project` where `pcode`<>'000' ORDER by pcode ASC";
//echo "$sql<br>";
$sqlq=mysqli_query($db, $sql);
$i=1;
while($r=mysqli_fetch_array($sqlq)){
$apcode[$i]=$r[pcode];
$i++;
}
$spcode=--$i;

$sql="select * from `accounts` WHERE `accountType` IN('12','16') ORDER by accountID ASC";
$i=1;
//echo $sql;
$sqlq=mysqli_query($db, $sql);
while($ree=mysqli_fetch_array($sqlq)){
$array_date=array();
$openingBalance=0;
$baseOpening=0;
 if(myarray_search ($ree[accountID],  $accountId)){ $crAmount=0;$drAmount=0;
 
 $openingBalance=$baseOpening+openingBalance($ree[accountID],$fromDate,$pcode);

 ?> 
  <tr class="bg">
    <td colspan='7' align='left' >Opening Balance</td>
    <td  align='right' ><? echo number_format($openingBalance,2);?></td>
  </tr> 

 <?
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$sql1="select * from `receivecash` WHERE `receiveDate` between '$fromDate' AND '$toDate' 
       AND (`receiveFrom` LIKE '$ree[accountID]%' OR `receiveAccount` LIKE '$ree[accountID]%') ORDER by receiveDate ASC";
 //echo $sql1.'<br>';
//echo $sql1;
$sqlq1=mysqli_query($db, $sql1);
while($st=mysqli_fetch_array($sqlq1)){
$array_date[$i][0]=$st[receiveDate];
$array_date[$i][1]=$st[receiveSL];
$array_date[$i][2]=$st[reff];
$array_date[$i][3]=$st[receiveAmount];
if($st[receiveFrom] ='$ree[accountID]') $array_date[$i][4]=2;
else if($st[receiveAccount] ='$ree[accountID]') $array_date[$i][4]=1;
  $i++;
  }  

   $sql2="select * from `ex130` WHERE `exDate` between '$fromDate' and '$toDate' 
        AND (`paymentSL` LIKE 'ct_%' OR `paymentSL` LIKE 'CT_%')
  	    AND  (`exgl` LIKE '$ree[accountID]%' OR `account` LIKE '$ree[accountID]%') 
  	    order by exDate ASC";  

//echo "$sql2<br>";
  $sqlQ=mysqli_query($db, $sql2);
  while($re=mysqli_fetch_array($sqlQ)){
//  echo "<br>***$re[exgl]==$ree[accountID] ***<br>";
  $array_date[$i][0]=$re[exDate];
  $array_date[$i][1]=$re[paymentSL];  
  $array_date[$i][2]=$re[exDescription]; 
  $array_date[$i][3]=$re[examount];  
  if(substr($re[exgl],0,7)=="$ree[accountID]") $array_date[$i][4]=1;  
   else  $array_date[$i][4]=2;  
        
  $i++;
  }//while

  ?>
<? 
//print_r($array_date);
 sort($array_date);
$r=sizeof($array_date);
$ro=$r+1;?>
 <tr>
   <td valign="top" class="bg" <? echo " rowspan=$ro";?> > 
   	<? echo "$ree[accountID]<br>".accountName($ree[accountID]);?>
   </td>
 </tr>  
<? for($i=0;$i<$r;$i++){?>
 <tr>
   <td valign="top"><? echo mydate($array_date[$i][0]);?></td>
   <td valign="top"><? echo $array_date[$i][1];?></td>   
   <td valign="top"> CDJ</td>      
   <td valign="top" align="left"><? echo $array_date[$i][2];?></td> 
   <td valign="top" align="right"><? if($array_date[$i][4]=='1') {
   echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3];}?></td>   
   <td valign="top" align="right"><? if($array_date[$i][4]=='2') {
   echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?></td>   
 </tr>

<?   $k=1; }//for ?>


<tr class="bg">
 <td colspan='6' align='right' ><? echo number_format($drAmount,2); $drTotal+=$drAmount?></td>
 <td  align='right' ><? echo number_format($crAmount,2); $crTotal+=$crAmount?></td>
 <td  align="right"><? echo number_format($drAmount-$crAmount,2)?></td>
</tr>
<tr><td colspan='8' height='3' bgcolor='#FFCC66'></td></tr>
<tr  bgcolor='#66CCFF'>
 <td colspan='7' > Closing Balance</td>
<td bgcolor="#FFFF99" align="right"><? echo number_format($openingBalance+$drAmount-$crAmount,2)?></td>
</tr>
<tr><td colspan='8' height='3' bgcolor='#FFCC66'></td></tr>
<tr><td colspan='8' height='20' bgcolor='#FFFFFF'></td></tr>

<? 
}//if array search
}//while
  }//pcode=000?>
 
  <?
 if(myarray_search ('2401000',  $accountId)){ $crAmount=0;$drAmount=0;
 $k=0;

$openingBalance=0;

$array_date=array();
$baseOpening=baseOpening('2401000',$pcode);
$openingBalance=$baseOpening+openingBalance('2401000',$fromDate,$pcode);
  
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
	
	$sql="SELECT SUM( receiveQty * rate )as amount, `todat`,`paymentSL`, `itemCode`,`reference` 
	FROM `store$pcode` 
	WHERE `todat` between '$fromDate' and '$toDate' 
	AND `paymentSL` LIKE 'PO%' 
	GROUP BY todat,`paymentSL` order by todat ASC ";
//echo $sql;
  $sqlQ=mysqli_query($db, $sql);
  $r=mysql_num_rows($sqlQ);
$i=0;  
  while($st=mysqli_fetch_array($sqlQ)){ 
  $array_date[$i][0]=$st[todat];
  $array_date[$i][1]=viewposl($st[paymentSL]);  
  $array_date[$i][2]=$st[reference];
  $array_date[$i][3]=$st[amount];  
  $array_date[$i][4]=2;  
  $i++;  
  }
  
	$sql="SELECT SUM( receiveQty * rate )as amount, `todat`,`paymentSL`, `itemCode`,`reference` ".
	" FROM `storet$pcode` WHERE `todat` between '$fromDate' and '$toDate' 
	AND `paymentSL` LIKE 'ST_%'GROUP BY `paymentSL` order by todat ASC ";
	  
//echo $sql;
  $sqlQ=mysqli_query($db, $sql);
  $r=mysql_num_rows($sqlQ);

  while($st=mysqli_fetch_array($sqlQ)){
  $array_date[$i][0]=$st[todat];
  $array_date[$i][1]=$st[paymentSL];  
  $array_date[$i][2]=$st[reference];
  $array_date[$i][3]=$st[amount];  
  $array_date[$i][4]=2;  
  $i++;  
  }  
$sql1="SELECT `paidAmount` as amount,`paymentSL`,`paymentDate`,`posl` from `vendorpayment` WHERE".
" `paymentDate` BETWEEN '$fromDate' AND '$toDate' AND `posl` LIKE 'PO_".$pcode."_%' Order by paymentDate ASC";
//echo $sql1;
$sqlq1=mysqli_query($db, $sql1);
while($st=mysqli_fetch_array($sqlq1)){
if(poType($st[posl])==1){
$array_date[$i][0]=$st[paymentDate];
$array_date[$i][1]=$st[paymentSL];
$array_date[$i][2]='';
$array_date[$i][3]=$st[amount];
$array_date[$i][4]=1;
  $i++;
  }//if(poType($r[posl])==1)
  }
   ?>
   <? if($k==0){ ?>
  <tr class="bg">
    <td colspan='7' align='left' >Heeeee Opening Balance <br> <? echo "2401000-$pcode<br>".accountName('2401000');?></td>
    <td  align='right' ><? echo number_format($openingBalance,2);?></td>
  </tr> 
   <? $out=1; }?>
<?  
//print_r($array_date);
 sort($array_date);
$r=sizeof($array_date);

for($i=0;$i<$r;$i++){
?>
 <tr>
   <? if($k==0){ ?> <td valign="top"<? echo " rowspan=$r";?> class="bg"></td><? }?>
   <td valign="top"><? echo mydate($array_date[$i][0]);?></td>
   <td valign="top"><? echo $array_date[$i][1];?></td>   
   <td valign="top"><? // echo $re[reff];?></td>      
   <td> <? echo $array_date[$i][2];?></td>
   <td valign="top" align="right"><? if($array_date[$i][4]=='1'){echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3];}?></td>   
   <td valign="top" align="right"><? if($array_date[$i][4]=='2'){echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?></td>   
 </tr>
 <?  $k=1; }//for?>


<? if($out){?>
<tr class="bg">
 <td colspan='6' align='right' ><? echo number_format($drAmount,2); $drTotal+=$drAmount?></td>
 <td  align='right' ><? echo number_format($crAmount,2); $crTotal+=$crAmount?></td>
 <td  align="right"><? echo number_format($drAmount-$crAmount,2)?></td>
</tr>
<tr><td colspan='8' height='3' bgcolor='#FFCC66'></td></tr>
<tr  bgcolor='#66CCFF'>
 <td colspan='7' > Closing Balance</td>
<td bgcolor="#FFFF99" align="right"><? echo number_format($openingBalance+$drAmount-$crAmount,2)?></td>
</tr>
<tr><td colspan='8' height='3' bgcolor='#FFCC66'></td></tr>
<tr><td colspan='8' height='20' bgcolor='#FFFFFF'></td></tr>
<? }//out?>
<? 
//print_r($apcode);
for($pi=1;$pi<=$spcode;$pi++){
$k=0;
$openingBalance=0;
$baseOpening=0;
 $drAmount=0;
$crAmount=0;
$array_date=array();
$i=0;
$pcode=$apcode[$pi];

$sql1="SELECT vendorpayment.paidAmount as amount,vendorpayment.paymentSL,vendorpayment.paymentDate,vendorpayment.posl 
 from `vendorpayment`,`purchase` 
WHERE vendorpayment.paymentDate BETWEEN '$fromDate' AND '$toDate' 
AND vendorpayment.posl LIKE 'PO_".$pcode."_%' 
AND vendorpayment.paymentSL=purchase.paymentSL  
AND purchase.account not like '5502000-%' 
Order by vendorpayment.paymentDate ASC";
//echo $sql1;
$sqlq1=mysqli_query($db, $sql1);
while($st=mysqli_fetch_array($sqlq1)){
if(poType($st[posl])==1){
$array_date[$i][0]=$st[paymentDate];
$array_date[$i][1]=$st[paymentSL];
$array_date[$i][2]='';
$array_date[$i][3]=$st[amount];
$array_date[$i][4]=1;
  $i++;
  }//if(poType($r[posl])==1)
  }
   ?>
  <tr class="bg">
    <td colspan='7' align='left' valign="top" >Opening Balance<br><? echo "2401000-$pcode<br>".accountName('2401000');?></td>
    <td  align='right' ><? echo number_format($openingBalance,2);?></td>
  </tr> 
   <? $out=1; ?>
<?  
//print_r($array_date);
 sort($array_date);
$r=sizeof($array_date);

for($i=0;$i<$r;$i++){
?>
 <tr>
   <? if($k==0){ ?> <td valign="top"<? echo " rowspan=$r";?> class="bg"> </td><? }?>
   <td valign="top"><? echo mydate($array_date[$i][0]);?></td>
   <td valign="top"><? echo $array_date[$i][1];?></td>   
   <td valign="top"><? // echo $re[reff];?></td>      
   <td> <? echo $array_date[$i][2];?></td>
   <td valign="top" align="right"><? if($array_date[$i][4]=='1'){echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3];}?></td>   
   <td valign="top" align="right"><? if($array_date[$i][4]=='2'){echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?></td>   
 </tr>
 <?  $k=1; }//for?>


<? if($out){?>
<tr class="bg">
 <td colspan='6' align='right' ><? echo number_format($drAmount,2); $drTotal+=$drAmount?></td>
 <td  align='right' ><? echo number_format($crAmount,2); $crTotal+=$crAmount?></td>
 <td  align="right"><? echo number_format($drAmount-$crAmount,2)?></td>
</tr>
<tr><td colspan='8' height='3' bgcolor='#FFCC66'></td></tr>
<tr  bgcolor='#66CCFF'>
 <td colspan='7' > Closing Balance</td>
<td bgcolor="#FFFF99" align="right"><? echo number_format($openingBalance+$drAmount-$crAmount,2)?></td>
</tr>
<tr><td colspan='8' height='3' bgcolor='#FFCC66'></td></tr>
<tr><td colspan='8' height='20' bgcolor='#FFFFFF'></td></tr>
<? }//out?>
<? }?>
<? $pcode='000';}// if(myarray_search ('2401000',  $accountId)){
?>

<!-- equipment-->
 <?
  if(myarray_search ('2402000',  $accountId)){
 $k=0;
 $drAmount=0;
$crAmount=0;
$openingBalance=0;

$array_date=array();
$openingBalance=openingBalance('2402000',$fromDate,$pcode);
  
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
	
    $sql="select `edate`, `posl` from `eqattendance` ".
	"  WHERE `edate` between '$fromDate' and '$toDate' AND `location` ='$pcode' GROUP by edate,posl order by edate ASC ";
//echo $sql;
  $sqlQ=mysqli_query($db, $sql);
$i=0;  
  while($st=mysqli_fetch_array($sqlQ)){
	$pamount=0;
	$wamount=0;
	$dailyworkBreakt=0;
	$toDaypresent=0;
	$toDaypresent=0;
	$workt=0;
	$rate=0;

	$sql2="select * from `eqattendance` ".
	"  WHERE `edate` ='$st[edate]'".
	" AND posl='$st[posl]' order by eqId ASC ";
	//echo "$sql2<br>";
	$sqlQ2=mysqli_query($db, $sql2);
	while($re=mysqli_fetch_array($sqlQ2)){
		$dailyworkBreakt=eq_dailyworkBreak($re[eqId],$re[itemCode],$st[edate],$re[eqType],$pcode);
		//$dailyBreakDown=eq_dailyBreakDown($re[eqId],$re[itemCode],$st[edate],$re[eqType],$pcode);
		$toDaypresent=eq_toDaypresent($re[eqId],$re[itemCode],$st[edate],$re[eqType],$pcode);
		$toDaypresent=($toDaypresent-$dailyworkBreakt);
		$rate=eqpoRate($re[itemCode],$st[posl])/(8*3600);
		$pamount+=$toDaypresent*$rate;

		//$workt= eq_dailywork($re[eqId],$re[itemCode],$st[edate],$re[eqType],$pcode);	
		//$wamount+=$workt*$rate;		
		//echo "PP=$toDaypresent--$rate<br>";	
	}//while re

  $array_date[$i][0]=$st[edate];
  $array_date[$i][1]=$st[posl];  
  $array_date[$i][2]=' eq present';
  $array_date[$i][3]=$pamount;  
  $array_date[$i][4]=2;  
  $i++;  
  }//while st
  
$sql1="SELECT paidAmount as amount,`paymentSL`,`paymentDate`,`posl` from `vendorpayment` WHERE".
" `paymentDate` BETWEEN '$fromDate' AND '$toDate' AND `posl` LIKE 'EQ_".$pcode."_%' Order by paymentDate ASC";
//echo $sql1;
$sqlq1=mysqli_query($db, $sql1);
while($st=mysqli_fetch_array($sqlq1)){

$array_date[$i][0]=$st[paymentDate];
$array_date[$i][1]=$st[paymentSL];
$array_date[$i][2]='';
$array_date[$i][3]=$st[amount];
$array_date[$i][4]=1;
  $i++;
  }
    
  ?>
   <? if($k==0){ ?>
  <tr class="bg">
    <td colspan='7' align='left' >Opening Balance</td>
    <td  align='right' ><? echo number_format($openingBalance,2);?></td>
  </tr> 
   <? $out=1; }?>
<?   //sort($array_date);
$r=sizeof($array_date);
for($i=0;$i<$r;$i++){
?>
 <tr>
   <? if($k==0){ ?> <td valign="top"<? echo " rowspan=$r";?> class="bg"> <? echo "2402000-$pcode<br>".accountName('2402000');?></td><? }?>
   <td valign="top"><? echo mydate($array_date[$i][0]);?></td>
   <td valign="top"><? echo $array_date[$i][1];?></td>   
   <td valign="top"><? // echo $re[reff];?></td>      
   <td> <? echo $array_date[$i][2];?></td>
   <td valign="top" align="right"><? if($array_date[$i][4]=='1'){echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3];}?></td>   
   <td valign="top" align="right"><? if($array_date[$i][4]=='2'){echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?></td>   
 </tr>
 <?  $k=1; }//for?>


<? if($out){?>
<tr class="bg">
 <td colspan='6' align='right' ><? echo number_format($drAmount,2); $drTotal+=$drAmount?></td>
 <td  align='right' ><? echo number_format($crAmount,2); $crTotal+=$crAmount?></td>
 <td  align="right"><? echo number_format($drAmount-$crAmount,2)?></td>
</tr>
<tr><td colspan='8' height='3' bgcolor='#FFCC66'></td></tr>
<tr  bgcolor='#66CCFF'>
 <td colspan='7' > Closing Balance</td>
<td bgcolor="#FFFF99" align="right"><? echo number_format($openingBalance+$drAmount-$crAmount,2)?></td>
</tr>
<tr><td colspan='8' height='3' bgcolor='#FFCC66'></td></tr>
<tr><td colspan='8' height='20' bgcolor='#FFFFFF'></td></tr>
<? }//out?>


<? 
//print_r($apcode);
for($pi=1;$pi<=$spcode;$pi++){
$k=0;
$openingBalance=0;
$baseOpening=0;
 $drAmount=0;
$crAmount=0;
$array_date=array();
$i=0;
$pcode=$apcode[$pi];

$sql1="SELECT vendorpayment.paidAmount as amount,vendorpayment.paymentSL,vendorpayment.paymentDate,vendorpayment.posl from `vendorpayment` , `purchase` 
WHERE vendorpayment.paymentDate BETWEEN '$fromDate' AND '$toDate' 
AND (vendorpayment.posl LIKE 'EQ_".$pcode."_%' OR vendorpayment.posl LIKE 'EQP_".$pcode."_%') 
AND vendorpayment.paymentSL=purchase.paymentSL  
Order by vendorpayment.paymentDate ASC";
//echo $sql1;
$sqlq1=mysqli_query($db, $sql1);
while($st=mysqli_fetch_array($sqlq1)){

$array_date[$i][0]=$st[paymentDate];
$array_date[$i][1]=$st[paymentSL];
$array_date[$i][2]='';
$array_date[$i][3]=$st[amount];
$array_date[$i][4]=1;
  $i++;
  }
   ?>
  <tr class="bg">
    <td colspan='7' align='left' valign="top" >Opening Balance<br><? echo "2402000-$pcode<br>".accountName('2402000');?></td>
    <td  align='right' ><? echo number_format($openingBalance,2);?></td>
  </tr> 
   <? $out=1; ?>
<?  
//print_r($array_date);
 sort($array_date);
$r=sizeof($array_date);

for($i=0;$i<$r;$i++){
?>
 <tr>
   <? if($k==0){ ?> <td valign="top"<? echo " rowspan=$r";?> class="bg"> </td><? }?>
   <td valign="top"><? echo mydate($array_date[$i][0]);?></td>
   <td valign="top"><? echo $array_date[$i][1];?></td>   
   <td valign="top"><? // echo $re[reff];?></td>      
   <td> <? echo $array_date[$i][2];?></td>
   <td valign="top" align="right"><? if($array_date[$i][4]=='1'){echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3];}?></td>   
   <td valign="top" align="right"><? if($array_date[$i][4]=='2'){echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?></td>   
 </tr>
 <?  $k=1; }//for?>


<? if($out){?>
<tr class="bg">
 <td colspan='6' align='right' ><? echo number_format($drAmount,2); $drTotal+=$drAmount?></td>
 <td  align='right' ><? echo number_format($crAmount,2); $crTotal+=$crAmount?></td>
 <td  align="right"><? echo number_format($drAmount-$crAmount,2)?></td>
</tr>
<tr><td colspan='8' height='3' bgcolor='#FFCC66'></td></tr>
<tr  bgcolor='#66CCFF'>
 <td colspan='7' > Closing Balance</td>
<td bgcolor="#FFFF99" align="right"><? echo number_format($openingBalance+$drAmount-$crAmount,2)?></td>
</tr>
<tr><td colspan='8' height='3' bgcolor='#FFCC66'></td></tr>
<tr><td colspan='8' height='20' bgcolor='#FFFFFF'></td></tr>
<? }//out?>
<? }?>
<? $pcode='000';}// if(myarray_search ('2401000',  $accountId)){
?>


  <?
 if(myarray_search ('2403000',  $accountId)){
 $k=0;
 $drAmount=0;
$crAmount=0;
$openingBalance=0;

$array_date=array();
$openingBalance=openingBalance('2403000',$fromDate,$pcode);
  
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
	
	$sql="SELECT SUM( qty*rate )as amount, `edate`,`posl` ".
	" FROM `subut` WHERE `edate` between '$fromDate' and '$toDate'
	 AND `posl` LIKE 'PO_".$pcode."_%' GROUP BY `posl`,edate order by edate ASC ";
//echo $sql;
  $sqlQ=mysqli_query($db, $sql);
  $r=mysql_num_rows($sqlQ);
$i=0;  
  while($st=mysqli_fetch_array($sqlQ)){
  $array_date[$i][0]=$st[edate];
  $array_date[$i][1]=$st[posl];  
  $array_date[$i][2]='received';
  $array_date[$i][3]=$st[amount];  
  $array_date[$i][4]=2;  
  $i++;  
  }
  
$sql1="SELECT `paidAmount` as amount,`paymentSL`,`paymentDate`,`posl` from `vendorpayment` WHERE".
" `paymentDate` BETWEEN '$fromDate' AND '$toDate' AND `posl` LIKE 'PO_".$pcode."_%' Order by paymentDate ASC";
//echo $sql1;
$sqlq1=mysqli_query($db, $sql1);
while($st=mysqli_fetch_array($sqlq1)){
if(poType($st[posl])==3){
$array_date[$i][0]=$st[paymentDate];
$array_date[$i][1]=$st[paymentSL];
$array_date[$i][2]='';
$array_date[$i][3]=$st[amount];
$array_date[$i][4]=1;
  $i++;
  }//if(poType($r[posl])==1)
  }
   ?>
   <? if($k==0){ ?>
  <tr class="bg">
    <td colspan='7' align='left' >Opening Balance</td>
    <td  align='right' ><? echo number_format($openingBalance,2);?></td>
  </tr> 
 <tr>
   <td valign="top" class="bg"> 
   	<? echo "2403000-$pcode<br>".accountName('2403000');?>
   </td>
 </tr>    
   <? $out=1; }?>
<?  
//print_r($array_date);
 sort($array_date);
$r=sizeof($array_date);

for($i=0;$i<$r;$i++){
?>
 <tr>
    <td></td>
   <td valign="top"><? echo mydate($array_date[$i][0]);?></td>
   <td valign="top"><? echo $array_date[$i][1];?></td>   
   <td valign="top"><? // echo $re[reff];?></td>      
   <td> <? echo $array_date[$i][2];?></td>
   <td valign="top" align="right"><? if($array_date[$i][4]=='1'){echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3];}?></td>   
   <td valign="top" align="right"><? if($array_date[$i][4]=='2'){echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?></td>   
 </tr>
 <?  $k=1; }//for?>


<? if($out){?>
<tr class="bg">
 <td colspan='6' align='right' ><? echo number_format($drAmount,2); $drTotal+=$drAmount?></td>
 <td  align='right' ><? echo number_format($crAmount,2); $crTotal+=$crAmount?></td>
 <td  align="right"><? echo number_format($drAmount-$crAmount,2)?></td>
</tr>
<tr><td colspan='8' height='3' bgcolor='#FFCC66'></td></tr>
<tr  bgcolor='#66CCFF'>
 <td colspan='7' > Closing Balance</td>
<td bgcolor="#FFFF99" align="right"><? echo number_format($openingBalance+$drAmount-$crAmount,2)?></td>
</tr>
<tr><td colspan='8' height='3' bgcolor='#FFCC66'></td></tr>
<tr><td colspan='8' height='20' bgcolor='#FFFFFF'></td></tr>
<? }//out?>

<? 
//print_r($apcode);
for($pi=1;$pi<=$spcode;$pi++){
$k=0;
$openingBalance=0;
$baseOpening=0;
 $drAmount=0;
$crAmount=0;
$array_date=array();
$i=0;
$pcode=$apcode[$pi];

$sql1="SELECT vendorpayment.paidAmount as amount,vendorpayment.paymentSL,vendorpayment.paymentDate,vendorpayment.posl from `vendorpayment`,`purchase` 
WHERE vendorpayment.paymentDate BETWEEN '$fromDate' AND '$toDate' 
AND vendorpayment.posl LIKE 'PO_".$pcode."_%' 
AND vendorpayment.paymentSL=purchase.paymentSL  
AND purchase.account not like '5502000-%' 
Order by vendorpayment.paymentDate ASC";
//echo $sql1;
$sqlq1=mysqli_query($db, $sql1);
while($st=mysqli_fetch_array($sqlq1)){
if(poType($st[posl])==3){
$array_date[$i][0]=$st[paymentDate];
$array_date[$i][1]=$st[paymentSL];
$array_date[$i][2]='';
$array_date[$i][3]=$st[amount];
$array_date[$i][4]=1;
  $i++;
  }//if(poType($r[posl])==1)
  }
   ?>
  <tr class="bg">
    <td colspan='7' align='left' valign="top" >Opening Balance<br><? echo "2403000-$pcode<br>".accountName('2403000');?></td>
    <td  align='right' ><? echo number_format($openingBalance,2);?></td>
  </tr> 
   <? $out=1; ?>
<?  
//print_r($array_date);
 sort($array_date);
$r=sizeof($array_date);

for($i=0;$i<$r;$i++){
?>
 <tr>
   <? if($k==0){ ?> <td valign="top"<? echo " rowspan=$r";?> class="bg"> </td><? }?>
   <td valign="top"><? echo mydate($array_date[$i][0]);?></td>
   <td valign="top"><? echo $array_date[$i][1];?></td>   
   <td valign="top"><? // echo $re[reff];?></td>      
   <td> <? echo $array_date[$i][2];?></td>
   <td valign="top" align="right"><? if($array_date[$i][4]=='1'){echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3];}?></td>   
   <td valign="top" align="right"><? if($array_date[$i][4]=='2'){echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?></td>   
 </tr>
 <?  $k=1; }//for?>


<? if($out){?>
<tr class="bg">
 <td colspan='6' align='right' ><? echo number_format($drAmount,2); $drTotal+=$drAmount?></td>
 <td  align='right' ><? echo number_format($crAmount,2); $crTotal+=$crAmount?></td>
 <td  align="right"><? echo number_format($drAmount-$crAmount,2)?></td>
</tr>
<tr><td colspan='8' height='3' bgcolor='#FFCC66'></td></tr>
<tr  bgcolor='#66CCFF'>
 <td colspan='7' > Closing Balance</td>
<td bgcolor="#FFFF99" align="right"><? echo number_format($openingBalance+$drAmount-$crAmount,2)?></td>
</tr>
<tr><td colspan='8' height='3' bgcolor='#FFCC66'></td></tr>
<tr><td colspan='8' height='20' bgcolor='#FFFFFF'></td></tr>
<? }//out?>
<? }?>
<? $pcode='000';
?>

<? }// if(myarray_search ('2403000',  $accountId)){
?>
  <?
 if(myarray_search ('2404000',  $accountId)){
 $k=0;
 $drAmount=0;
$crAmount=0;
$openingBalance=0;
$array_date=array();

$openingBalance=openingBalance('2404000',$fromDate,$pcode);
  
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
	
 $si=((strtotime($toDate)-strtotime($fromDate))/86400)+1;
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
  
$sql1="select SUM(amount) as amount,`pdate`,`paymentSL` from `empsalary`
      WHERE `pdate` between '$fromDate' AND '$toDate' 
	  AND `glCode` LIKE '2404000-$pcode' GROUP by paymentSL";
 // echo $sql.'<br>';
//echo $sql1;
$sqlq1=mysqli_query($db, $sql1);
while($st=mysqli_fetch_array($sqlq1)){
$array_date[$i][0]=$st[pdate];
$array_date[$i][1]=$st[paymentSL];
$array_date[$i][2]='';
$array_date[$i][3]=$st[amount];
$array_date[$i][4]=1;
  $i++;
  }
   ?>
   <? if($k==0){ ?>
  <tr class="bg">
    <td colspan='7' align='left' >Opening Balance</td>
    <td  align='right' ><? echo number_format($openingBalance,2);?></td>
  </tr> 
   <tr>
   <td valign="top" class="bg"> 
   	<? echo "2404000-$pcode<br>".accountName('2404000');?>
   </td>
 </tr>    
   <? $out=1; }?>
<?  
//print_r($array_date);
 sort($array_date);
$r=sizeof($array_date);

for($i=0;$i<$r;$i++){
?>
 <tr>
   <td></td>
   <td valign="top"><? echo mydate($array_date[$i][0]);?></td>
   <td valign="top"><? echo $array_date[$i][1];?></td>   
   <td valign="top"><? // echo $re[reff];?></td>      
   <td> <? echo $array_date[$i][2];?></td>
   <td valign="top" align="right"><? if($array_date[$i][4]=='1'){echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3];}?></td>   
   <td valign="top" align="right"><? if($array_date[$i][4]=='2'){echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?></td>   
 </tr>
 <?  $k=1; }//for?>


<? if($out){?>
<tr class="bg">
 <td colspan='6' align='right' ><? echo number_format($drAmount,2); $drTotal+=$drAmount?></td>
 <td  align='right' ><? echo number_format($crAmount,2); $crTotal+=$crAmount?></td>
 <td  align="right"><? echo number_format($drAmount-$crAmount,2)?></td>
</tr>
<tr><td colspan='8' height='3' bgcolor='#FFCC66'></td></tr>
<tr  bgcolor='#66CCFF'>
 <td colspan='7' > Closing Balance</td>
<td bgcolor="#FFFF99" align="right"><? echo number_format($openingBalance+$drAmount-$crAmount,2)?></td>
</tr>
<tr><td colspan='8' height='3' bgcolor='#FFCC66'></td></tr>
<tr><td colspan='8' height='20' bgcolor='#FFFFFF'></td></tr>
<? }//out
}// if(myarray_search ('2403000',  $accountId)){
?>

 <? 
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
 $sql="SELECT * from accounts where accountType='8'";
 $sqlq=mysqli_query($db, $sql);
 
 while($acc=mysqli_fetch_array($sqlq)){
 $account=$acc[accountID];
$drAmount=0;
$crAmount=0;
$openingBalance=0;
if(myarray_search ($account,  $accountId)){
  $openingBalance=openingBalance($account,$fromDate,$pcode);?>
 <? 
  $sql="select * from `ex130` WHERE `exDate` between '$fromDate' and '$toDate' ".
  	   " AND `exgl` = '$account-$pcode' order by exDate ASC";
//echo $sql;
  $sqlQ=mysqli_query($db, $sql);
  $i=1;
  $r=mysql_num_rows($sqlQ);
$k=0;  
$out=0;
  while($re=mysqli_fetch_array($sqlQ)){?>
   <? if($k==0){ ?>
  <tr class="bg">
    <td colspan='7' align='left' >Opening Balance</td>
    <td  align='right' ><? echo number_format($openingBalance,2);?></td>
  </tr> 
 <tr>
   <td valign="top" class="bg"> 
   	<? echo "$account-$pcode<br>".accountName($account);?>
   </td>
 </tr>    
<? $out=1; }?>
 <tr>
	<td></td>
   <td valign="top"><? echo mydate($re[exDate]);?></td>
   <td valign="top"><? echo $re[paymentSL];?></td>   
   <td valign="top"> CDJ</td>      
   <td valign="top" align="left"><? echo $re[exDescription];?></td> 
   <td valign="top" align="right"><? echo number_format($re[examount],2);?></td>   
   <td valign="top" align="right"></td>   
 </tr>
<?   $k=1; $drAmount+=$re[examount]; }//while re?>

<? if($out){?>
<tr class="bg">
 <td colspan='6' align='right' ><? echo number_format($drAmount,2); $drTotal+=$drAmount?></td>
 <td  align='right' ><? echo number_format($crAmount,2); $crTotal+=$crAmount?></td>
 <td  align="right"><? echo number_format($drAmount-$crAmount,2)?></td>
</tr>
<tr><td colspan='8' height='3' bgcolor='#FFCC66'></td></tr>
<tr  bgcolor='#66CCFF'>
 <td colspan='7' > Closing Balance</td>
<td bgcolor="#FFFF99" align="right"><? echo number_format($openingBalance+$drAmount-$crAmount,2)?></td>
</tr>
<tr><td colspan='8' height='3' bgcolor='#FFCC66'></td></tr>
<tr><td colspan='8' height='20' bgcolor='#FFFFFF'></td></tr>
<? }//out
}//if array search
  }//while account
?>

  <?
  /*
 if(myarray_search ('2405000',  $accountId)){
 $k=0;
 $drAmount=0;
$crAmount=0;
$openingBalance=0;
$array_date=array();

$openingBalance=openingBalance('2405000',$fromDate,$pcode);
  
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
	
 $si=((strtotime($toDate)-strtotime($fromDate))/86400)+1;
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
      WHERE pdate between '$fromDate' AND '$toDate' 
	  AND glCode LIKE '6901000-$pcode' GROUP by pdate";
 // echo $sql.'<br>';
//echo $sql1;
$sqlq1=mysqli_query($db, $sql1);
while($st=mysqli_fetch_array($sqlq1)){
$array_date[$i][0]=$st[pdate];
$array_date[$i][1]=$st[paymentSL];
$array_date[$i][2]='';
$array_date[$i][3]=$st[amount];
$array_date[$i][4]=1;
  $i++;

  }
   ?>
   <? if($k==0){ ?>
  <tr class="bg">
    <td colspan='7' align='left' >Opening Balance</td>
    <td  align='right' ><? echo number_format($openingBalance,2);?></td>
  </tr> 
   <? $out=1; }?>
<?  
//print_r($array_date);
 sort($array_date);
$r=sizeof($array_date);

for($i=0;$i<$r;$i++){
?>
 <tr>
   <? if($k==0){ ?> <td valign="top"<? echo " rowspan=$r";?> class="bg"> <? echo "2405000-$pcode<br>".accountName('2405000');?></td><? }?>
   <td valign="top"><? echo mydate($array_date[$i][0]);?></td>
   <td valign="top"><? echo $array_date[$i][1];?></td>   
   <td valign="top"><? // echo $re[reff];?></td>      
   <td> <? echo $array_date[$i][2];?></td>
   <td valign="top" align="right"><? if($array_date[$i][4]=='1'){echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3];}?></td>   
   <td valign="top" align="right"><? if($array_date[$i][4]=='2'){echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?></td>   
 </tr>
 <?  $k=1; }//for
 
 ?>


<? if($out){?>
<tr class="bg">
 <td colspan='6' align='right' ><? echo number_format($drAmount,2); $drTotal+=$drAmount?></td>
 <td  align='right' ><? echo number_format($crAmount,2); $crTotal+=$crAmount?></td>
 <td  align="right"><? echo number_format($drAmount-$crAmount,2)?></td>
</tr>
<tr><td colspan='8' height='3' bgcolor='#FFCC66'></td></tr>
<tr  bgcolor='#66CCFF'>
 <td colspan='7' > Closing Balance</td>
<td bgcolor="#FFFF99" align="right"><? echo number_format($openingBalance+$drAmount-$crAmount,2)?></td>
</tr>
<tr><td colspan='8' height='3' bgcolor='#FFCC66'></td></tr>
<tr><td colspan='8' height='20' bgcolor='#FFFFFF'></td></tr>
<? }//out
}// if(myarray_search ('2403000',  $accountId)){

*/
?>

 <?
 if(myarray_search ('4701000',  $accountId)){
 $k=0;
 $drAmount=0;
$crAmount=0;
$openingBalance=0;

$array_date=array();
$openingBalance=openingBalance('4701000',$fromDate,$pcode);
  
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
	
	$sql="SELECT SUM( receiveQty * rate )as amount, `todat`,`paymentSL`, `itemCode`,`reference` ".
	" FROM `store$pcode` WHERE `todat` between '$fromDate' and '$toDate' GROUP BY `paymentSL` order by todat ASC ";
//echo $sql;
  $sqlQ=mysqli_query($db, $sql);
  $r=mysql_num_rows($sqlQ);
$i=0;  
  while($st=mysqli_fetch_array($sqlQ)){
  $array_date[$i][0]=$st[todat];
  $array_date[$i][1]=$st[paymentSL];  
  $array_date[$i][2]=$st[reference];
  $array_date[$i][3]=round($st[amount],2);  
  $array_date[$i][4]=1;  
  $i++;  
  }
  
$sql1="SELECT SUM(issuedQty*issueRate) as amount,`issueSL`,`issueDate` from `issue$pcode` WHERE".
//" issueDate BETWEEN '$fromDate' AND '$toDate'  GROUP by itemCode Order by issueDate ASC";
" `issueDate` BETWEEN '$fromDate' AND '$toDate' GROUP by issueSL Order by issueDate ASC";
//echo $sql1;
$sqlq1=mysqli_query($db, $sql1);
while($st=mysqli_fetch_array($sqlq1)){
$array_date[$i][0]=$st[issueDate];
$array_date[$i][1]=generate_ISsl($st[issueSL],$pcode);
$array_date[$i][2]='';
$array_date[$i][3]=round($st[amount],2);
$array_date[$i][4]=2;
  $i++;}
  
  
$sql1="SELECT SUM(receiveQty*rate) as amount,`rsl`,`edate` from `storet` 
WHERE `returnFrom`='$pcode'  
AND `edate` BETWEEN '$fromDate' AND '$toDate' 
GROUP by rsl Order by edate ASC";
//echo $sql1;
$sqlq1=mysqli_query($db, $sql1);
while($st=mysqli_fetch_array($sqlq1)){
$array_date[$i][0]=$st[edate];
$array_date[$i][1]=$st[rsl];
$array_date[$i][2]='';
$array_date[$i][3]=round($st[amount],2);
$array_date[$i][4]=2;
  $i++;}
  
  
 sort($array_date);
$r=sizeof($array_date);

   ?>
   <? if($k==0){ ?>
  <tr class="bg">
    <td colspan='7' align='left' >Opening Balance</td>
    <td  align='right' ><? echo number_format($openingBalance,2);?></td>
  </tr> 
 <tr>
   <td valign="top" class="bg" rowspan="<? echo $r+1;?>"> 
   	<? echo "4701000-$pcode<br>".accountName('4701000');?>
   </td>
 </tr>      
   <? $out=1; }?>
<?  
//print_r($array_date);

for($i=0;$i<$r;$i++){
?>
 <tr>
   <td valign="top"><? echo mydate($array_date[$i][0]);?></td>
   <td valign="top"><? echo $array_date[$i][1];?></td>   
   <td valign="top"><? // echo $re[reff];?></td>      
   <td> <? echo $array_date[$i][2];?></td>
   <td valign="top" align="right"><? if($array_date[$i][4]=='1'){echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3];}?></td>   
   <td valign="top" align="right"><? if($array_date[$i][4]=='2'){echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?></td>   
 </tr>
 <?  $k=1; }//for?>


<? if($out){?>
<tr class="bg">
 <td colspan='6' align='right' ><? echo number_format($drAmount,2); $drTotal+=$drAmount?></td>
 <td  align='right' ><? echo number_format($crAmount,2); $crTotal+=$crAmount?></td>
 <td  align="right"><? echo number_format($drAmount-$crAmount,2)?></td>
</tr>
<tr><td colspan='8' height='3' bgcolor='#FFCC66'></td></tr>
<tr  bgcolor='#66CCFF'>
 <td colspan='7' > Closing Balance</td>
<td bgcolor="#FFFF99" align="right"><? echo number_format($openingBalance+$drAmount-$crAmount,2)?></td>
</tr>
<tr><td colspan='8' height='3' bgcolor='#FFCC66'></td></tr>
<tr><td colspan='8' height='20' bgcolor='#FFFFFF'></td></tr>
<? }//out
}// if(myarray_search ('4701000',  $accountId)){
?>
 <?
  if(myarray_search ('4800000',  $accountId)){
 $k=0;
 $drAmount=0;
$crAmount=0;
$openingBalance=0;

$array_date=array();
$openingBalance=openingBalance('4800000',$fromDate,$pcode);
  
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
	
	$sql="SELECT SUM( receiveQty * rate )as amount, `todat`,`paymentSL`, `itemCode`,`reference` ".
	" FROM `storet$pcode` WHERE `todat` between '$fromDate' and '$toDate' GROUP BY `paymentSL` order by todat ASC ";
//echo $sql;
  $sqlQ=mysqli_query($db, $sql);
  $r=mysql_num_rows($sqlQ);
$i=0;  
  while($st=mysqli_fetch_array($sqlQ)){
  $array_date[$i][0]=$st[todat];
  $array_date[$i][1]=$st[paymentSL];  
  $array_date[$i][2]=$st[reference];
  $array_date[$i][3]=$st[amount];  
  $array_date[$i][4]=1;  
  $i++;  
  }
  
	$sql1="SELECT SUM( receiveQty * rate )as amount, `todat`,`paymentSL`, `itemCode`,`reference` ".
	" FROM `store$pcode` WHERE (`paymentSL` LIKE 'cash_%' OR `paymentSL` LIKE 'EP_%' OR `paymentSL` LIKE 'ST_%') AND `todat` between '$fromDate' and '$toDate' GROUP BY `paymentSL` order by todat ASC ";
//echo $sql1;
$sqlq1=mysqli_query($db, $sql1);
while($st=mysqli_fetch_array($sqlq1)){
$array_date[$i][0]=$st[todat];
$array_date[$i][1]=$st[paymentSL];
$array_date[$i][2]=$st[reference];
$array_date[$i][3]=$st[amount];
$array_date[$i][4]=2;
  $i++;}
   ?>
   <? if($k==0){ ?>
  <tr class="bg">
    <td colspan='7' align='left' >Opening Balance</td>
    <td  align='right' ><? echo number_format($openingBalance,2);?></td>
  </tr> 
 <tr>
   <td valign="top" class="bg"> 
   	<? echo "4800000-$pcode<br>".accountName('4800000');?>
   </td>
 </tr>        
   <? $out=1; }?>
<?   sort($array_date);
$r=sizeof($array_date);
for($i=0;$i<$r;$i++){
?>
 <tr>
   <td></td>
   <td valign="top"><? echo mydate($array_date[$i][0]);?></td>
   <td valign="top"><? echo $array_date[$i][1];?></td>   
   <td valign="top"><? // echo $re[reff];?></td>      
   <td> <? echo $array_date[$i][2];?></td>
   <td valign="top" align="right"><? if($array_date[$i][4]=='1'){echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3];}?></td>   
   <td valign="top" align="right"><? if($array_date[$i][4]=='2'){echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?></td>   
 </tr>
 <?  $k=1; }//for?>
<? if($out){
$drAmount=round($drAmount,2);
$crAmount=round($crAmount,2);
?>
<tr class="bg">
 <td colspan='6' align='right' ><? echo number_format($drAmount,2); $drTotal+=$drAmount;?></td>
 <td  align='right' ><? echo number_format($crAmount,2); $crTotal+=$crAmount;?></td>
 <td bgcolor="#FFFF99" align="right"><? echo number_format($drAmount-$crAmount,2)?></td>
</tr>
<tr><td colspan='8' height='3' bgcolor='#FFCC66'></td></tr>
<tr  bgcolor='#66CCFF'>
 <td colspan='7' > Closing Balance</td>
<td bgcolor="#FFFF99" align="right"><? echo number_format($openingBalance+$drAmount-$crAmount,2)?></td>
</tr>
<tr><td colspan='8' height='3' bgcolor='#FFCC66'></td></tr>
<tr><td colspan='8' height='20' bgcolor='#FFFFFF'></td></tr>
<? }//out
}// if(myarray_search ('4701000',  $accountId)){?>

 <? 
if(myarray_search ('5000000',  $accountId)){
$crAmount=0;$drAmount=0;
$out=1;
$array_date=array();
  $openingBalance=openingBalance('5000000',$fromDate,$pcode);?> 
  <tr class="bg" >
    <td colspan='7' align='left' >Opening Balance</td>
    <td  align='right' ><? echo number_format($openingBalance,2);?></td>
  </tr> 

 <?
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

  
  $sql="select * from `invoice` WHERE `invoiceDate` between '$fromDate' and '$toDate' 
  	    AND `invoiceLocation`='$pcode'  
		 order by invoiceDate ASC";  

//echo $sql;
  $sqlQ=mysqli_query($db, $sql);
  $r=mysql_num_rows($sqlQ);
$k=0;  

$array_date=array();
  while($re=mysqli_fetch_array($sqlQ)){
$array_date[$i][0]=$re[invoiceDate];
$array_date[$i][1]=$re[invoiceNo];
$array_date[$i][2]=viewInvoiceType($re[invoiceType]);
$array_date[$i][3]=$re[invoiceAmount];
$array_date[$i][4]=1;
  $i++;
  }  
$sql1="select * from `receivecash` WHERE `receiveDate` between '$fromDate' AND '$toDate' 
       AND `receiveFrom` LIKE '5000000-$pcode' ORDER by receiveDate ASC";
 //echo $sql1.'<br>';
//echo $sql1;
$sqlq1=mysqli_query($db, $sql1);
while($st=mysqli_fetch_array($sqlq1)){
$array_date[$i][0]=$st[receiveDate];
$array_date[$i][1]=$st[receiveSL];
$array_date[$i][2]=$st[reff];
$array_date[$i][3]=$st[receiveAmount];
$array_date[$i][4]=2;
  $i++;
  }  
  ?>
<?  
//print_r($array_date);
 sort($array_date);
$r=sizeof($array_date);
$ro=$r+1;
?>
 <tr>
   <td valign="top" class="bg" <? echo " rowspan=$ro";?> > 
   	<? echo "5000000<br>".accountName('5000000');?>
   </td>
 </tr>          
<? for($i=0;$i<$r;$i++){
?>
 <tr>
   <td valign="top"><? echo mydate($array_date[$i][0]);?></td>
   <td valign="top"><? echo $array_date[$i][1];?></td>   
   <td valign="top"><? // echo $re[reff];?></td>      
   <td> <? echo $array_date[$i][2];?></td>
   <td valign="top" align="right"><? if($array_date[$i][4]=='1'){echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3]; }?></td>   
   <td valign="top" align="right"><? if($array_date[$i][4]=='2'){echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?></td>   
 </tr>
 <?  $k=1; }//for?>


<? if($out){?>
<tr class="bg">
 <td colspan='6' align='right' ><? echo number_format($drAmount,2); $drTotal+=$drAmount?></td>
 <td  align='right' ><? echo number_format($crAmount,2); $crTotal+=$crAmount?></td>
 <td  align="right"><? echo number_format($drAmount-$crAmount,2)?></td>
</tr>
<tr><td colspan='8' height='3' bgcolor='#FFCC66'></td></tr>
<tr  bgcolor='#66CCFF'>
 <td colspan='7' > Closing Balance</td>
<td bgcolor="#FFFF99" align="right"><? echo number_format($openingBalance+$drAmount-$crAmount,2)?></td>
</tr>
<tr><td colspan='8' height='3' bgcolor='#FFCC66'></td></tr>
<tr><td colspan='8' height='20' bgcolor='#FFFFFF'></td></tr>
<? }//out
}// if(myarray_search ('2403000',  $accountId)){
?>

 <? 
if(myarray_search ('5201000',  $accountId)){
$crAmount=0;$drAmount=0;
$out=1;
$array_date=array();
  $openingBalance=openingBalance('5201000',$fromDate,$pcode);?> 
  <tr class="bg" >
    <td colspan='7' align='left' >Opening Balance</td>
    <td  align='right' ><? echo number_format($openingBalance,2);?></td>
  </tr> 

 <?
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

  
  $sql="select * from `empsalaryad` WHERE `pdate` between '$fromDate' and '$toDate' 
		 order by pdate ASC";  

//echo $sql;
  $sqlQ=mysqli_query($db, $sql);
  $r=mysql_num_rows($sqlQ);
$k=0;  

$array_date=array();
  while($re=mysqli_fetch_array($sqlQ)){
$array_date[$i][0]=$re[pdate];
$array_date[$i][1]=$re[paymentSL];
$array_date[$i][2]=empName($salary[empId]);
$array_date[$i][3]=$re[amount];
$array_date[$i][4]=1;
  $i++;
  }  
  
  $sql="select * from `empsalaryadc` WHERE `pdate` between '$fromDate' and '$toDate' 
		 order by pdate ASC";  

//echo $sql;
  $sqlQ=mysqli_query($db, $sql);
  $r=mysql_num_rows($sqlQ);

  while($re=mysqli_fetch_array($sqlQ)){
$array_date[$i][0]=$re[pdate];
$array_date[$i][1]=$re[paymentSL];
$array_date[$i][2]=empName($salary[empId]);
$array_date[$i][3]=$re[amount];
$array_date[$i][4]=2;
  $i++;
  }  
   ?>
<?  
//print_r($array_date);
 sort($array_date);
$r=sizeof($array_date);
$ro=$r+1;
?>
 <tr>
   <td valign="top" class="bg" <? echo " rowspan=$ro";?> > 
   	<? echo "5201000<br>".accountName('5201000');?>
   </td>
 </tr>          
<? for($i=0;$i<$r;$i++){
?>
 <tr>
   <td valign="top"><? echo mydate($array_date[$i][0]);?></td>
   <td valign="top"><? echo $array_date[$i][1];?></td>   
   <td valign="top"><? // echo $re[reff];?></td>      
   <td> <? echo $array_date[$i][2];?></td>
   <td valign="top" align="right"><? if($array_date[$i][4]=='1'){echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3]; }?></td>   
   <td valign="top" align="right"><? if($array_date[$i][4]=='2'){echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?></td>   
 </tr>
 <?  $k=1; }//for?>


<? if($out){?>
<tr class="bg">
 <td colspan='6' align='right' ><? echo number_format($drAmount,2); $drTotal+=$drAmount?></td>
 <td  align='right' ><? echo number_format($crAmount,2); $crTotal+=$crAmount?></td>
 <td  align="right"><? echo number_format($drAmount-$crAmount,2)?></td>
</tr>
<tr><td colspan='8' height='3' bgcolor='#FFCC66'></td></tr>
<tr  bgcolor='#66CCFF'>
 <td colspan='7' > Closing Balance</td>
<td bgcolor="#FFFF99" align="right"><? echo number_format($openingBalance+$drAmount-$crAmount,2)?></td>
</tr>
<tr><td colspan='8' height='3' bgcolor='#FFCC66'></td></tr>
<tr><td colspan='8' height='20' bgcolor='#FFFFFF'></td></tr>
<? }//out
}// if(myarray_search ('5201000',  $accountId)){
?>


 <? 
if(myarray_search ('5501000',  $accountId)){ $crAmount=0;$drAmount=0;
if($pcode=='000')$baseOpening=baseOpening('5501000',$pcode);
  $openingBalance=$baseOpening+openingBalance('5501000',$fromDate,$pcode);?> 
  <tr class="bg" >
    <td colspan='7' align='left' >Opening Balance</td>
    <td  align='right' ><? echo number_format($openingBalance,2);?></td>
  </tr> 

<?  $out=1; ?>
 <?
 
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
if($pcode==000){
  $sql="select * from `purchase` WHERE `paymentDate` between '$fromDate' and '$toDate' 
       AND `account`='5501000-000' AND (`paymentSL` not LIKE 'ct_%') 
       order by paymentDate ASC";  
		 }
else{
  $sql="select * from `purchase` WHERE `paymentDate` between '$fromDate' and '$toDate' 
  	    AND ((`account`='5501000-000' AND `exfor`='$pcode' ) 
		OR (`account`='5501000-000' AND `paymentSL` like 'SP_%') 
		OR (`account`='5501000-000' AND `paymentSL` like 'WP_%'))
		AND `paymentSl` not Like 'ct_%' 
		 order by paymentDate ASC";  
		 }		 
//echo $sql;

  $sqlQ=mysqli_query($db, $sql);
  $r=mysql_num_rows($sqlQ);
$k=0;  
$crAmount=0;
$array_date=array();
  while($re=mysqli_fetch_array($sqlQ)){
  $temp=explode('_',$re[paymentSL]);
  
  if($temp[0]=="SP" OR $temp[0]=="WP" ){
  if($temp[0]=="SP" )$paidAmount=sp_projectPaid($re[paymentSL],$pcode);
  else if($temp[0]=="WP")$paidAmount=mwp_projectPaid($re[paymentSL],$pcode);
if($paidAmount){  
 $array_date[$i][0]=$re[paymentDate];
$array_date[$i][1]=$re[paymentSL];
$array_date[$i][2]=$re[paidTo];
$array_date[$i][3]=$paidAmount;
$array_date[$i][4]=2;
  $i++;}//if($paidAmount)
   }
else{ $array_date[$i][0]=$re[paymentDate];
$array_date[$i][1]=$re[paymentSL];
$array_date[$i][2]=$re[paidTo];
$array_date[$i][3]=$re[paidAmount];
$array_date[$i][4]=2;
 $i++; }

}  

if($pcode=='000'){
   $sql2="select * from `ex130` WHERE `exDate` between '$fromDate' and '$toDate' 
        AND (`paymentSL` LIKE 'ct_%' OR `paymentSL` LIKE 'CT_%') 
  	    AND  (`exgl`='5501000-000' OR `account`='5501000-000')  
  	    order by exDate ASC";  
		$ckgl="5501000-$pcode";
}
else {
   $sql2="select * from `ex130` WHERE `exDate` between '$fromDate' and '$toDate' 
        AND (`paymentSL` LIKE 'ct_%' OR `paymentSL` LIKE 'CT_%') 
  	    AND  ((`exgl`='5501000-000' OR `account`='5501000-000') AND 
		(`exgl` LIKE '%-$pcode' OR `account` LIKE '%-$pcode')) 
  	    order by exDate ASC";  
        //$ckgl="5502000-$pcode";
		$ckgl="5501000-000";
}
//echo "$sql2<br>";
//echo "<br>$ckgl";
  $sqlQ=mysqli_query($db, $sql2);
  while($re=mysqli_fetch_array($sqlQ)){
//  echo "<br>***$re[exgl]==$ree[accountID] ***<br>";
  $array_date[$i][0]=$re[exDate];
  $array_date[$i][1]=$re[paymentSL];  
  $array_date[$i][2]=$re[exDescription]; 
  $array_date[$i][3]=$re[examount];      
  if($re[exgl]==$ckgl) $array_date[$i][4]=1;  
   else  $array_date[$i][4]=2;  
        
  $i++;
  }//while

/* sort($array_date);
print_r($array_date); 
echo "**************************************";
*/
/* edit for project receive*/

if($pcode=='000'){
  $sql="select * from `receivecash` WHERE `receiveDate` between '$fromDate' and '$toDate' 
    AND `receiveAccount`='5501000'
    order by receiveDate ASC";  
}else {
  $sql="select * from `receivecash` WHERE `receiveDate` between '$fromDate' and '$toDate' 
   AND `receiveFrom` LIKE '%-$pcode' AND `receiveAccount`='5501000'
    order by receiveDate ASC";  
}
//echo "$sql<br>";
  $sqlQ=mysqli_query($db, $sql);
  $r=mysql_num_rows($sqlQ);
$k=0;  
$crAmount=0;
  while($re=mysqli_fetch_array($sqlQ)){
$array_date[$i][0]=$re[receiveDate];
$array_date[$i][1]=$re[receiveSL];
$array_date[$i][2]=$re[reff];
$array_date[$i][3]=$re[receiveAmount];
$array_date[$i][4]=1;
  $i++;  
}  
/*
if($pcode=='000'){
$sql="select * from `ex130` 
WHERE  exdate between '$fromDate' and '$toDate' 
AND account LIKE '5501000-%' AND paymentSL not LIKE 'ct_%' order by exDate ASC";  

//echo "$sql<br>";
  $sqlQ=mysqli_query($db, $sql);
  $r=mysql_num_rows($sqlQ);
$k=0;  
$crAmount=0;
  while($re=mysqli_fetch_array($sqlQ)){
$array_date[$i][0]=$re[exDate];
$array_date[$i][1]=$re[paymentSL];
$array_date[$i][2]=$re[exDescription];
$array_date[$i][3]=$re[examount];
$array_date[$i][4]=2;
  $i++;  
}  //while
}//pcode
*/
?>
<?  

 sort($array_date);
//print_r($array_date); 
$r=sizeof($array_date);
$ro=$r+1;
?>
 <tr>
   <td valign="top" class="bg" <? echo " rowspan=$ro";?> > 
   	<? echo "5501000<br>".accountName('5501000');?>
   </td>
 </tr>            

<? for($i=0;$i<$r;$i++){?>
 <tr>
   <td valign="top"><? echo mydate($array_date[$i][0]);?></td>
   <td valign="top"><? echo $array_date[$i][1];?></td>   
   <td valign="top"><? // echo $re[reff];?></td>      
   <td> <? echo $array_date[$i][2];?></td>
   <td valign="top" align="right"><? if($array_date[$i][4]=='1'){echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3]; }?></td>   
   <td valign="top" align="right"><? if($array_date[$i][4]=='2'){echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?></td>   
 </tr>
 <?  $k=1; }//for?>

<? if($out){?>
<tr class="bg">
 <td colspan='6' align='right' ><? echo number_format($drAmount,2); $drTotal+=$drAmount?></td>
 <td  align='right' ><? echo number_format($crAmount,2); $crTotal+=$crAmount;?></td>
 <td  align="right"><? echo number_format($drAmount-$crAmount,2)?></td>
</tr>
<tr><td colspan='8' height='3' bgcolor='#FFCC66'></td></tr>
<tr  bgcolor='#66CCFF'>
 <td colspan='7' > Closing Balance</td>
<td bgcolor="#FFFF99" align="right"><? echo number_format($openingBalance+$drAmount-$crAmount,2)?></td>
</tr>
<tr><td colspan='8' height='3' bgcolor='#FFCC66'></td></tr>
<tr><td colspan='8' height='20' bgcolor='#FFFFFF'></td></tr>
<? }//out
}// ifarray search
?>

 <?  
 if(myarray_search ('5502000',  $accountId) ){ 
  for($pi=1;$pi<=$spcode;$pi++){
$openingBalance=0;
$baseOpening=0;
 $drAmount=0;
$crAmount=0;
$array_date=array();
$i=0;
$pcode=$apcode[$pi];

  

// $baseOpening=baseOpening('5502000',$pcode);
 //$openingBalance=$baseOpening+openingBalance('5502000',$fromDate,$pcode);?> 
  <tr class="bg">
    <td colspan='7' align='left' >Opening Balance</td>
    <td  align='right' ><? echo number_format($openingBalance,2);?></td>
  </tr> 
        
 <?

 $array_date=array();

$i=1;  
$drAmount=0;
$crAmount=0;

   $sql2="select * from `ex130` WHERE `exDate` between '$fromDate' and '$toDate' 
        AND (`paymentSL` LIKE 'ct_%' OR `paymentSL` LIKE 'CT_%') 
  	    AND (`exgl`='5502000-$pcode' OR `account`='5502000-$pcode')  
  	    order by exDate ASC";  
		$ckgl="5502000-$pcode";
//echo "$sql2<br>";
//echo "<br>$ckgl";
  $sqlQ=mysqli_query($db, $sql2);
  while($re=mysqli_fetch_array($sqlQ)){
//  echo "<br>***$re[exgl]==$ree[accountID] ***<br>";
  $array_date[$i][0]=$re[exDate];
  $array_date[$i][1]=$re[paymentSL];  
  $array_date[$i][2]=$re[exDescription]; 
  $array_date[$i][3]=$re[examount];      
  if($re[exgl]==$ckgl) $array_date[$i][4]=1;  
   else  $array_date[$i][4]=2;  
        
  $i++;
  }//while
 sort($array_date);
$r=sizeof($array_date);
$ro=$r+1;
  ?>
 <tr>
   <td valign="top" class="bg" rowspan="<? echo $ro;?>"> 
   	<? echo "5502000-$pcode<br>".accountName('5502000');?>
   </td>
 </tr>      
<? for($i=0;$i<$r;$i++){?>
 <tr>
   <td valign="top"><? echo mydate($array_date[$i][0]);?></td>
   <td valign="top"><? echo $array_date[$i][1];?></td>   
   <td valign="top"><? // echo $re[reff];?></td>      
   <td> <? echo $array_date[$i][2];?></td>
   <td valign="top" align="right"><? if($array_date[$i][4]=='1'){echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3]; }?></td>   
   <td valign="top" align="right"><? if($array_date[$i][4]=='2'){echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?></td>   
 </tr>
 <?  $k=1; }//for?>

<tr class="bg">
 <td colspan='6' align='right' ><? echo number_format($drAmount,2); $drTotal+=$drAmount?></td>
 <td  align='ri
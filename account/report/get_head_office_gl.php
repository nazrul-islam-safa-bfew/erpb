

 <?php
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
<?php
//print_r($array_date);
 sort($array_date);
$r=sizeof($array_date);
$ro=$r+1;
if($openingBalance!=0 || $r!=0)
{
?>

    
    <?php echo number_format($openingBalance,2);?>
  
  
 
    
   	<?php echo "$ree[accountID]<br>".accountName($ree[accountID]);?>
   
  
<?php for($i=0;$i<$r;$i++){?>
 
   <?php echo mydate($array_date[$i][0]);?>
   <?php echo $array_date[$i][1];?>   
    CDJ      
   <?php echo $array_date[$i][2];?> 
   <?php if($array_date[$i][4]=='1') {
   echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3];}?>   
   <?php if($array_date[$i][4]=='2') {
   echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?>   
 

<?php   $k=1; }//for ?>



 <?php echo number_format($drAmount,2); $drTotal+=$drAmount?>
 <?php echo number_format($crAmount,2); $crTotal+=$crAmount?>
 <?php echo number_format($drAmount-$crAmount,2)?>



 
<?php echo number_format($openingBalance+$drAmount-$crAmount,2)?>




<?php 
} //bypanna
}//if array search
}//while
  }//pcode=000?>
 
  <?php
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
   <?php
    sort($array_date);
	$r=sizeof($array_date);
	if($openingBalance!=0 || $r!=0)
	{
    if($k==0){ 
  
   ?>
   
  
     <br> <?php echo "2401000-$pcode<br>".accountName('2401000');?>
    <?php echo number_format($openingBalance,2);?>
  
   <?php $out=1; }?>
<?php  
//print_r($array_date);


for($i=0;$i<$r;$i++){
?>
 
   <?php if($k==0){ ?> <?php }?>
   <?php echo mydate($array_date[$i][0]);?>
   <?php echo $array_date[$i][1];?>   
   <?php // echo $re[reff];?>      
    <?php echo $array_date[$i][2];?>
   <?php if($array_date[$i][4]=='1'){echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3];}?>   
   <?php if($array_date[$i][4]=='2'){echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?>   
 
 <?php  $k=1; }//for?>


<?php if($out){

?>

 <?php echo number_format($drAmount,2); $drTotal+=$drAmount?>
 <?php echo number_format($crAmount,2); $crTotal+=$crAmount?>
 <?php echo number_format($drAmount-$crAmount,2)?>



 
<?php echo number_format($openingBalance+$drAmount-$crAmount,2)?>



<?php } //out
}
?>
<?php 
//print_r($apcode);
for($pi=1;$pi<=$spcode;$pi++)
	{
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
	while($st=mysqli_fetch_array($sqlq1))
		{
		if(poType($st[posl])==1)
			{
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
	if($openingBalance!=0 || $r!=0)
	{
   ?>
  	
    <?php echo "2401000-$pcode<br>".accountName('2401000');?>
    <?php echo number_format($openingBalance,2);?>
  	
   	<?php 
	$out=1; 
	
	for($i=0;$i<$r;$i++)
		{
		?>
 		
		   <?php if($k==0){ ?>  <?php }?>
		   <?php echo mydate($array_date[$i][0]);?>
		   <?php echo $array_date[$i][1];?>   
		   <?php // echo $re[reff];?>      
		    <?php echo $array_date[$i][2];?>
		   <?php if($array_date[$i][4]=='1'){echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3];}?>   
		   <?php if($array_date[$i][4]=='2'){echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?>   
		 
		 <?php  $k=1; 
		 }//for?>


		<?php if($out)
		{
		
		?>
			
			 <?php echo number_format($drAmount,2); $drTotal+=$drAmount?>
			 <?php echo number_format($crAmount,2); $crTotal+=$crAmount?>
			 <?php echo number_format($drAmount-$crAmount,2)?>
			
			
			
			 
			<?php echo number_format($openingBalance+$drAmount-$crAmount,2)?>
			
			
			
			<?php 
		}
		}//out?>
<?php }?>
<?php $pcode='000';}// if(myarray_search ('2401000',  $accountId)){
?>

<!-- equipment-->
 <?php
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
   <?php
   $r=sizeof($array_date);
   if($openingBalance!=0 || $r!=0)
	{
    if($k==0){ ?>
  
    
    <?php echo number_format($openingBalance,2);?>
  
   <?php $out=1; }?>
<?php   //sort($array_date);

for($i=0;$i<$r;$i++){
?>
 
   <?php if($k==0){ ?>  <?php echo "2402000-$pcode<br>".accountName('2402000');?><?php }?>
   <?php echo mydate($array_date[$i][0]);?>
   <?php echo $array_date[$i][1];?>   
   <?php // echo $re[reff];?>      
    <?php echo $array_date[$i][2];?>
   <?php if($array_date[$i][4]=='1'){echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3];}?>   
   <?php if($array_date[$i][4]=='2'){echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?>   
 
 <?php  $k=1; }//for?>


<?php if($out){?>

 <?php echo number_format($drAmount,2); $drTotal+=$drAmount?>
 <?php echo number_format($crAmount,2); $crTotal+=$crAmount?>
 <?php echo number_format($drAmount-$crAmount,2)?>



 
<?php echo number_format($openingBalance+$drAmount-$crAmount,2)?>



<?php }//out
}
?>


<?php 
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
   sort($array_date);
   $r=sizeof($array_date);
   if($openingBalance!=0 || $r!=0)
	{
   ?>
  
    <?php echo "2402000-$pcode<br>".accountName('2402000');?>
    <?php echo number_format($openingBalance,2);?>
  
   <?php $out=1; ?>
<?php  
//print_r($array_date);

for($i=0;$i<$r;$i++){
?>
 
   <?php if($k==0){ ?>  <?php }?>
   <?php echo mydate($array_date[$i][0]);?>
   <?php echo $array_date[$i][1];?>   
   <?php // echo $re[reff];?>      
    <?php echo $array_date[$i][2];?>
   <?php if($array_date[$i][4]=='1'){echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3];}?>   
   <?php if($array_date[$i][4]=='2'){echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?>   
 
 <?php  $k=1; }//for?>


<?php if($out){?>

 <?php echo number_format($drAmount,2); $drTotal+=$drAmount?>
 <?php echo number_format($crAmount,2); $crTotal+=$crAmount?>
 <?php echo number_format($drAmount-$crAmount,2)?>



 
<?php echo number_format($openingBalance+$drAmount-$crAmount,2)?>



<?php }//out
}
?>
<?php }?>
<?php $pcode='000';}// if(myarray_search ('2401000',  $accountId)){
?>


  <?php
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
   <?php
    sort($array_date);
	$r=sizeof($array_date);
	if($openingBalance!=0 || $r!=0)
	{
    if($k==0){ ?>
  
    
    <?php echo number_format($openingBalance,2);?>
  
 
   
   	<?php echo "2403000-$pcode<br>".accountName('2403000');?>
   
    
   <?php $out=1; }?>
<?php  
//print_r($array_date);


for($i=0;$i<$r;$i++){
?>
 
    
   <?php echo mydate($array_date[$i][0]);?>
   <?php echo $array_date[$i][1];?>   
   <?php // echo $re[reff];?>      
    <?php echo $array_date[$i][2];?>
   <?php if($array_date[$i][4]=='1'){echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3];}?>   
   <?php if($array_date[$i][4]=='2'){echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?>   
 
 <?php  $k=1; }//for?>


<?php if($out){?>

 <?php echo number_format($drAmount,2); $drTotal+=$drAmount?>
 <?php echo number_format($crAmount,2); $crTotal+=$crAmount?>
 <?php echo number_format($drAmount-$crAmount,2)?>



 
<?php echo number_format($openingBalance+$drAmount-$crAmount,2)?>



<?php }//out
}
?>

<?php 
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
  sort($array_date);
  $r=sizeof($array_date);
  if($openingBalance!=0 || $r!=0)
  {
   ?>
  
    <?php echo "2403000-$pcode<br>".accountName('2403000');?>
    <?php echo number_format($openingBalance,2);?>
  
   <?php $out=1; ?>
<?php  

for($i=0;$i<$r;$i++){
?>
 
   <?php if($k==0){ ?>  <?php }?>
   <?php echo mydate($array_date[$i][0]);?>
   <?php echo $array_date[$i][1];?>   
   <?php // echo $re[reff];?>      
    <?php echo $array_date[$i][2];?>
   <?php if($array_date[$i][4]=='1'){echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3];}?>   
   <?php if($array_date[$i][4]=='2'){echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?>   
 
 <?php  $k=1; }//for?>


<?php if($out){?>

 <?php echo number_format($drAmount,2); $drTotal+=$drAmount?>
 <?php echo number_format($crAmount,2); $crTotal+=$crAmount?>
 <?php echo number_format($drAmount-$crAmount,2)?>



 
<?php echo number_format($openingBalance+$drAmount-$crAmount,2)?>



<?php }//out
}
?>
<?php }?>
<?php $pcode='000';
?>

<?php }// if(myarray_search ('2403000',  $accountId)){
?>
  <?php
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
   <?php
   sort($array_date);
  $r=sizeof($array_date);
  if($openingBalance!=0 || $r!=0)
  {
    if($k==0){ ?>
  
    
    <?php echo number_format($openingBalance,2);?>
  
   
   
   	<?php echo "2404000-$pcode<br>".accountName('2404000');?>
   
    
   <?php $out=1; }?>
<?php  
//print_r($array_date);

for($i=0;$i<$r;$i++){
?>
 
   
   <?php echo mydate($array_date[$i][0]);?>
   <?php echo $array_date[$i][1];?>   
   <?php // echo $re[reff];?>      
    <?php echo $array_date[$i][2];?>
   <?php if($array_date[$i][4]=='1'){echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3];}?>   
   <?php if($array_date[$i][4]=='2'){echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?>   
 
 <?php  $k=1; }//for?>


<?php if($out){?>

 <?php echo number_format($drAmount,2); $drTotal+=$drAmount?>
 <?php echo number_format($crAmount,2); $crTotal+=$crAmount?>
 <?php echo number_format($drAmount-$crAmount,2)?>



 
<?php echo number_format($openingBalance+$drAmount-$crAmount,2)?>



<?php }//out

}
}// if(myarray_search ('2403000',  $accountId)){
?>

 <?php 
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
 <?php 
  $sql="select * from `ex130` WHERE `exDate` between '$fromDate' and '$toDate' ".
  	   " AND `exgl` = '$account-$pcode' order by exDate ASC";
//echo $sql;
  $sqlQ=mysqli_query($db, $sql);
  $i=1;
  $r=mysql_num_rows($sqlQ);
$k=0;  
$out=0;
  while($re=mysqli_fetch_array($sqlQ)){?>
   <?php
   sort($array_date);
  $r=sizeof($array_date);
  if($openingBalance!=0 || $r!=0)
  {
    if($k==0){ ?>
  
    
    <?php echo number_format($openingBalance,2);?>
  
 
   
   	<?php echo "$account-$pcode<br>".accountName($account);?>
   
    
<?php $out=1; }?>
 
	
   <?php echo mydate($re[exDate]);?>
   <?php echo $re[paymentSL];?>   
    CDJ      
   <?php echo $re[exDescription];?> 
   <?php echo number_format($re[examount],2);?>   
      
 
<?php   $k=1; $drAmount+=$re[examount]; }//while re?>

<?php if($out){?>

 <?php echo number_format($drAmount,2); $drTotal+=$drAmount?>
 <?php echo number_format($crAmount,2); $crTotal+=$crAmount?>
 <?php echo number_format($drAmount-$crAmount,2)?>



 
<?php echo number_format($openingBalance+$drAmount-$crAmount,2)?>



<?php }//out

}
}//if array search
  }//while account
?>

  <?php
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
   <?php if($k==0){ ?>
  
    
    <?php echo number_format($openingBalance,2);?>
  
   <?php $out=1; }?>
<?php  
//print_r($array_date);
 sort($array_date);
$r=sizeof($array_date);

for($i=0;$i<$r;$i++){
?>
 
   <?php if($k==0){ ?>  <?php echo "2405000-$pcode<br>".accountName('2405000');?><?php }?>
   <?php echo mydate($array_date[$i][0]);?>
   <?php echo $array_date[$i][1];?>   
   <?php // echo $re[reff];?>      
    <?php echo $array_date[$i][2];?>
   <?php if($array_date[$i][4]=='1'){echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3];}?>   
   <?php if($array_date[$i][4]=='2'){echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?>   
 
 <?php  $k=1; }//for
 
 ?>


<?php if($out){?>

 <?php echo number_format($drAmount,2); $drTotal+=$drAmount?>
 <?php echo number_format($crAmount,2); $crTotal+=$crAmount?>
 <?php echo number_format($drAmount-$crAmount,2)?>



 
<?php echo number_format($openingBalance+$drAmount-$crAmount,2)?>



<?php }//out
}// if(myarray_search ('2403000',  $accountId)){

*/
?>

 <?php
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

  if($openingBalance!=0 || $r!=0)
  {
   ?>
   <?php if($k==0){ ?>
  
    
    <?php echo number_format($openingBalance,2);?>
  
 
   <td valign="top" class="bg" rowspan="<?php echo $r+1;?>"> 
   	<?php echo "4701000-$pcode<br>".accountName('4701000');?>
   
      
   <?php $out=1; }?>
<?php  
//print_r($array_date);

for($i=0;$i<$r;$i++){
?>
 
   <?php echo mydate($array_date[$i][0]);?>
   <?php echo $array_date[$i][1];?>   
   <?php // echo $re[reff];?>      
    <?php echo $array_date[$i][2];?>
   <?php if($array_date[$i][4]=='1'){echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3];}?>   
   <?php if($array_date[$i][4]=='2'){echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?>   
 
 <?php  $k=1; }//for?>


<?php if($out){?>

 <?php echo number_format($drAmount,2); $drTotal+=$drAmount?>
 <?php echo number_format($crAmount,2); $crTotal+=$crAmount?>
 <?php echo number_format($drAmount-$crAmount,2)?>



 
<?php echo number_format($openingBalance+$drAmount-$crAmount,2)?>



<?php }//out
}
}// if(myarray_search ('4701000',  $accountId)){
?>
 <?php
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
   <?php
   sort($array_date);
  $r=sizeof($array_date);
  if($openingBalance!=0 || $r!=0)
  {
    if($k==0){ ?>
  
    
    <?php echo number_format($openingBalance,2);?>
  
 
   
   	<?php echo "4800000-$pcode<br>".accountName('4800000');?>
   
        
   <?php $out=1; }?>
<?php  
for($i=0;$i<$r;$i++){
?>
 
   
   <?php echo mydate($array_date[$i][0]);?>
   <?php echo $array_date[$i][1];?>   
   <?php // echo $re[reff];?>      
    <?php echo $array_date[$i][2];?>
   <?php if($array_date[$i][4]=='1'){echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3];}?>   
   <?php if($array_date[$i][4]=='2'){echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?>   
 
 <?php  $k=1; }//for?>
<?php if($out){
$drAmount=round($drAmount,2);
$crAmount=round($crAmount,2);
?>

 <?php echo number_format($drAmount,2); $drTotal+=$drAmount;?>
 <?php echo number_format($crAmount,2); $crTotal+=$crAmount;?>
 <?php echo number_format($drAmount-$crAmount,2)?>



 
<?php echo number_format($openingBalance+$drAmount-$crAmount,2)?>



<?php }//out
}
}// if(myarray_search ('4701000',  $accountId)){?>

 <?php 
if(myarray_search ('5000000',  $accountId)){
$crAmount=0;$drAmount=0;
$out=1;
$array_date=array();
  $openingBalance=openingBalance('5000000',$fromDate,$pcode);?> 
  

 <?php
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
  //add line 1135 to 1154 by salma
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
  if($pcode=='000'){
  $sql="select * from `receivecash` WHERE `receiveDate` between '$fromDate' and '$toDate' 
   AND `receiveFrom` LIKE '5000000-%' AND `receiveAccount`='5501000'
    order by receiveDate ASC";  
				}

//echo "$sql<br>";
  $sqlQ=mysqli_query($db, $sql);
  $r=mysql_num_rows($sqlQ);
$k=0;  
$crAmount=0;
while($re=mysqli_fetch_array($sqlQ))
{
$array_date[$i][0]=$re[receiveDate];
$array_date[$i][1]=$re[receiveSL];
$array_date[$i][2]=$re[reff];
$array_date[$i][3]=$re[receiveAmount];
$array_date[$i][4]=2;
  $i++;  
}   
////////////////////////////////////////////////////////////////////////////////////////////////////////////
  ?>
<?php  
//print_r($array_date);
 sort($array_date);
$r=sizeof($array_date);
$ro=$r+1;

  if($openingBalance!=0 || $r!=0)
  {
?>

    
    <?php echo number_format($openingBalance,2);?>
  
 
    
   	<?php echo "5000000<br>".accountName('5000000');?>
   
          
<?php for($i=0;$i<$r;$i++){
?>
 
   <?php echo mydate($array_date[$i][0]);?>
   <?php echo $array_date[$i][1];?>   
   <?php // echo $re[reff];?>      
    <?php echo $array_date[$i][2];?>
   <?php if($array_date[$i][4]=='1'){echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3]; }?>   
   <?php if($array_date[$i][4]=='2'){echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?>   
 
 <?php  $k=1; }//for?>


<?php if($out){?>

 <?php echo number_format($drAmount,2); $drTotal+=$drAmount?>
 <?php echo number_format($crAmount,2); $crTotal+=$crAmount?>
 <?php echo number_format($drAmount-$crAmount,2)?>



 
<?php echo number_format($openingBalance+$drAmount-$crAmount,2)?>



<?php }//out
}
}// if(myarray_search ('2403000',  $accountId)){
?>

 <?php 
if(myarray_search ('5201000',  $accountId)){
$crAmount=0;$drAmount=0;
$out=1;
$array_date=array();
  $openingBalance=openingBalance('5201000',$fromDate,$pcode);?> 
 

 <?php
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
<?php  
//print_r($array_date);
 sort($array_date);
$r=sizeof($array_date);
$ro=$r+1;
 if($openingBalance!=0 || $r!=0)
  {
?>
 
    
    <?php echo number_format($openingBalance,2);?>
  
 
    
   	<?php echo "5201000<br>".accountName('5201000');?>
   
          
<?php for($i=0;$i<$r;$i++){
?>
 
   <?php echo mydate($array_date[$i][0]);?>
   <?php echo $array_date[$i][1];?>   
   <?php // echo $re[reff];?>      
    <?php echo $array_date[$i][2];?>
   <?php if($array_date[$i][4]=='1'){echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3]; }?>   
   <?php if($array_date[$i][4]=='2'){echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?>   
 
 <?php  $k=1; }//for?>


<?php if($out){?>

 <?php echo number_format($drAmount,2); $drTotal+=$drAmount?>
 <?php echo number_format($crAmount,2); $crTotal+=$crAmount?>
 <?php echo number_format($drAmount-$crAmount,2)?>



 
<?php echo number_format($openingBalance+$drAmount-$crAmount,2)?>



<?php }//out
}
}// if(myarray_search ('5201000',  $accountId)){
?>


<?php
 
if(myarray_search ('5501000',$accountId)){ $crAmount=0;$drAmount=0;
if($pcode=='000')$baseOpening=baseOpening('5501000',$pcode);
  $openingBalance=$baseOpening+openingBalance('5501000',$fromDate,$pcode);?> 
  

<?php  $out=1; ?>
 <?php
 
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
<?php  

 sort($array_date);
//print_r($array_date); 
$r=sizeof($array_date);
$ro=$r+1;
 if($openingBalance!=0 || $r!=0)
  {
?>

    
    <?php  number_format($openingBalance,2);?>
  
 
    
   	<?php  "5501000<br>".accountName('5501000');?>
   
 

<?php for($i=0;$i<$r;$i++){?>
 
   <?php  mydate($array_date[$i][0]);?>
   <?php  $array_date[$i][1];?>   
   <?php // echo $re[reff];?>      
   <?php  $array_date[$i][2];?>
   <?php if($array_date[$i][4]=='1'){ number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3]; }?>   
   <?php if($array_date[$i][4]=='2'){ number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?>   
 
 <?php  $k=1; }//for?>

<?php if($out){ ?>

<?php number_format($drAmount,2); $drTotal+=$drAmount?>
<?php number_format($crAmount,2); $crTotal+=$crAmount;?>
 <?php number_format($drAmount-$crAmount,2)?>



<?php $the_head_office_amount=$openingBalance+$drAmount-$crAmount?>


<?php }//out
}
}// ifarray search
?>

 <?php
 
 if(myarray_search ('5502000',  $accountId) ){ 
  for($pi=1;$pi<=$spcode;$pi++){
$openingBalance=0;
$baseOpening=0;
 $drAmount=0;
$crAmount=0;
$array_date=array();
$i=0;
$pcode=$apcode[$pi];

 $baseOpening=baseOpening('5502000',$pcode);
 $openingBalance=$baseOpening+openingBalance('5502000',$fromDate,$pcode);?> 
  
        
 <?php

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
if($openingBalance!=0 || $r!=0)
  {
  ?>
   
    
    <?php number_format($openingBalance,2);?>
  
 
   
   	<?php echo "5502000-$pcode<br>".accountName('5502000');?>
   
      
<?php for($i=0;$i<$r;$i++){?>
 
   <?php echo mydate($array_date[$i][0]);?>
   <?php echo $array_date[$i][1];?>   
   <?php // echo $re[reff];?>      
    <?php echo $array_date[$i][2];?>
   <?php if($array_date[$i][4]=='1'){echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3]; }?>   
   <?php if($array_date[$i][4]=='2'){echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?>   
 
 <?php  $k=1; }//for?>


 <?php echo number_format($drAmount,2); $drTotal+=$drAmount?>
 <?php echo number_format($crAmount,2); $crTotal+=$crAmount?>
 <?php echo number_format($drAmount-$crAmount,2)?>



 
<?php echo number_format($openingBalance+$drAmount-$crAmount,2)?>




<?php }
}//pcodeall 
$pcode='000';}//if array search?>

 <?php  
$sql="select * from `accounts` WHERE `accountType` IN('4') AND `accountID`<>'5201000' ORDER by accountID ASC";
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
 

 <?php
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

//echo "<br>$sql2<br>";
//  $r=mysql_num_rows($sql2);
?>
 
<?php 
   $sql2="select * from `ex130` WHERE `exDate` between '$fromDate' and '$toDate' 
        AND (`paymentSL` LIKE 'ct_%' OR `paymentSL` LIKE 'CT_%')
  	    AND (`exgl`='$ree[accountID]-$pcode' OR `account`='$ree[accountID]-$pcode') 
  	    order by exDate ASC";  

//echo "$sql2<br>";
  $sqlQ=mysqli_query($db, $sql2);
  while($re=mysqli_fetch_array($sqlQ)){
//  echo "<br>***$re[exgl]==$ree[accountID] ***<br>";
  $array_date[$i][0]=$re[exDate];
  $array_date[$i][1]=$re[paymentSL];  
  $array_date[$i][2]=$re[exDescription]; 
  $array_date[$i][3]=$re[examount];      
  if($re[exgl]=="$ree[accountID]-$pcode") $array_date[$i][4]=1;  
   else  $array_date[$i][4]=2;  
        
  $i++;
  }//while
  ?>
<?php 
//print_r($array_date);
 sort($array_date);
$r=sizeof($array_date);
if($openingBalance!=0 || $r!=0)
  {
  ?>
   
    
    <?php echo number_format($openingBalance,2);?>
  
  
   
   	<?php echo "$ree[accountID]<br>".accountName($ree[accountID]);?>
   
  
  <?php
for($i=0;$i<$r;$i++){?>
 
    
   <?php echo mydate($array_date[$i][0]);?>
   <?php echo $array_date[$i][1];?>   
    CDJ      
   <?php echo $array_date[$i][2];?> 
   <?php if($array_date[$i][4]=='1') {
   echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3];}?>   
   <?php if($array_date[$i][4]=='2') {
   echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?>   
 

<?php   $k=1; }//for ?>



 <?php echo number_format($drAmount,2); $drTotal+=$drAmount?>
 <?php echo number_format($crAmount,2); $crTotal+=$crAmount?>
 <?php echo number_format($drAmount-$crAmount,2)?>



 
<?php echo number_format($openingBalance+$drAmount-$crAmount,2)?>




<?php 
}
}//if array search
}//while?>
 <?php  
$sql="select * from `accounts` WHERE `accountType` IN('3') ORDER by accountID ASC";
$i=1;
//echo $sql;
$sqlq=mysqli_query($db, $sql);
while($ree=mysqli_fetch_array($sqlq)){
$array_date=array();
$openingBalance=0;
$baseOpening=0;
 if(myarray_search ($ree[accountID],  $accountId)){
  $crAmount=0;$drAmount=0;
 $baseOpening=baseOpening($ree[accountID],$pcode);
 $openingBalance=$baseOpening+openingBalance($ree[accountID],$fromDate,$pcode);
 ?> 
  
 <?php
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
/*  $sql="select * from `purchase` WHERE  paymentDate between '$fromDate' and '$toDate' AND 
  	     account='$ree[accountID]' AND exfor='$pcode' AND paymentSL not LIKE 'CT_%' 
		 order by paymentDate ASC";  
*/
  $sql="select * from `purchase` WHERE `paymentDate` between '$fromDate' and '$toDate' AND 
  	     account='$ree[accountID]' AND `paymentSL` not LIKE 'CT_%' 
		 order by paymentDate ASC";  
		 
 //echo "$sql<br>";
  $sqlQ=mysqli_query($db, $sql);
  $r=mysql_num_rows($sqlQ);
?>
<?php 
$drAmount=0;
$crAmount=0;
$i=0;
  while($re=mysqli_fetch_array($sqlQ)){
  $tref=explode('_',$re[paymentSL]);
  $array_date[$i][0]=$re[paymentDate];
  $array_date[$i][1]=$re[paymentSL];  
  $array_date[$i][2]=$re[paidTo]; 
  $array_date[$i][3]=$re[paidAmount];      
  $array_date[$i][4]=2;        
  $i++;
  }//while

  $sql2="select * from `ex130` WHERE `exDate` between '$fromDate' and '$toDate' 
        AND (`paymentSL` LIKE 'ct_%' OR `paymentSL` LIKE 'CT_%')
  	    AND  (exgl='$ree[accountID]' OR account='$ree[accountID]') 
		order by exDate ASC";  

//echo "$sql2<br>";
  $sqlQ=mysqli_query($db, $sql2);
  while($re=mysqli_fetch_array($sqlQ)){
//  echo "<br>***$re[exgl]==$ree[accountID] ***<br>";
  $array_date[$i][0]=$re[exDate];
  $array_date[$i][1]=$re[paymentSL];  
  if($re[exgl]==$ree[accountID]){ $array_date[$i][2]=$re[exDescription]; $array_date[$i][4]=1;  }  
   else  {  $array_date[$i][2]=paymentDes($re[paymentSL]); $array_date[$i][4]=2;  }
  $array_date[$i][3]=$re[examount];      
        
  $i++;
  }//while

$sql1="select * from `receivecash` WHERE `receiveDate` between '$fromDate' AND '$toDate' 
       AND `receiveFrom` LIKE '%-$pcode' AND `receiveAccount`='$ree[accountID]' ORDER by receiveDate ASC";
 //echo $sql1.'<br>';
//echo $sql1;
$sqlq1=mysqli_query($db, $sql1);
while($st=mysqli_fetch_array($sqlq1)){
$array_date[$i][0]=$st[receiveDate];
$array_date[$i][1]=$st[receiveSL];
$array_date[$i][2]=$st[reff];
$array_date[$i][3]=$st[receiveAmount];
//echo "** $st[receiveAmount] **",round($st[receiveAmount],2);
$array_date[$i][4]=1;
  $i++;
  }    
  ?>
  
  
<?php 
//print_r($array_date);
 sort($array_date);
$r=sizeof($array_date);
$ro=$r+1;
if($openingBalance!=0 || $r!=0)
  {
?>

    
    <?php echo number_format($openingBalance,2);?>
  

 
   
   	<?php echo "$ree[accountID]<br>".accountName($ree[accountID]);?>
   
  

<?php for($i=0;$i<$r;$i++){?>
 
   <?php echo mydate($array_date[$i][0]);?>
   <?php echo $array_date[$i][1];?>   
    CDJ      
   <?php echo $array_date[$i][2];?> 
   <?php if($array_date[$i][4]=='1') {
   echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3];}?>   
   <?php if($array_date[$i][4]=='2') {
   echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?>   
 

<?php   $k=1; }//for ?>



 <?php echo number_format($drAmount,2); $drTotal+=$drAmount?>
 <?php echo number_format($crAmount,2); $crTotal+=$crAmount?>
 <?php echo number_format($drAmount-$crAmount,2)?>



 
<?php echo number_format($openingBalance+$drAmount-$crAmount,2)?>




<?php 
}
}//if array search
}//while?>

 <?php  
 // directors Account
 if(myarray_search ('5700000',  $accountId)){
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sql="select * from `employee` WHERE `designation` <='74-90-000' ORDER by designation ASC";
$i=1;
//echo $sql;
$sqlq=mysqli_query($db, $sql);
while($ree=mysqli_fetch_array($sqlq)){
$array_date=array();
$openingBalance=0;
$baseOpening=0;
 $crAmount=0;$drAmount=0;
  //$baseOpening=baseOpening(5700000,$ree[empId]);
 $openingBalance=$baseOpening+openingBalance(5700000,$fromDate,$ree[empId]);

 ?> 
   

 <?php
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

//echo "<br>$sql2<br>";

?>
 
<?php 
   $sql2="select * from `ex130` WHERE `exDate` between '$fromDate' and '$toDate' 
        AND (`paymentSL` LIKE 'ct_%' OR `paymentSL` LIKE 'CT_%')
  	    AND (`exgl`='5700000-$ree[empId]' OR `account`='5700000-$ree[empId]') 
  	    order by exDate ASC";  

//echo "$sql2<br>";
  $sqlQ=mysqli_query($db, $sql2);
  $r=mysql_num_rows($sqlQ)+1;
  ?>
 
<?php   while($re=mysqli_fetch_array($sqlQ)){
//  echo "<br>***$re[exgl]==$ree[accountID] ***<br>";
  $array_date[$i][0]=$re[exDate];
  $array_date[$i][1]=$re[paymentSL];  
  $array_date[$i][2]=$re[exDescription]; 
  $array_date[$i][3]=$re[examount];      
  if($re[exgl]=="5700000-$ree[empId]") $array_date[$i][4]=1;  
   else  $array_date[$i][4]=2;  
        
  $i++;
  }//while
  ?>
<?php 
//print_r($array_date);
 sort($array_date);
$r=sizeof($array_date);
$ro=$r+1;
if($openingBalance!=0 || $r!=0)
  {
  ?>
  
    
    <?php echo number_format($openingBalance,2);?>
  
  
   
   	<?php echo "5700000-$ree[empId]<br>".accountName("5700000-$ree[empId]");?>
   
   
  <?php
for($i=0;$i<$r;$i++){?>

 
   <?php echo mydate($array_date[$i][0]);?>
   <?php echo $array_date[$i][1];?>   
    CDJ      
   <?php echo $array_date[$i][2];?> 
   <?php if($array_date[$i][4]=='1') {
   echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3];}?>   
   <?php if($array_date[$i][4]=='2') {
   echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?>   
 

<?php   $k=1; }//for ?>



 <?php echo number_format($drAmount,2); $drTotal+=$drAmount?>
 <?php echo number_format($crAmount,2); $crTotal+=$crAmount?>
 <?php echo number_format($drAmount-$crAmount,2)?>



 
<?php echo number_format($openingBalance+$drAmount-$crAmount,2)?>




<?php 
}
}//if array search
}//while?>

<?php 
if(myarray_search ('6100000',  $accountId)){
$out=1;
$drAmount=0;
$crAmount=0;
  $openingBalance=openingBalance('6100000',$fromDate,$pcode);?> 
  
 <?php
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

  
  $sql="select * from `invoice` WHERE `invoiceDate` between '$fromDate' and '$toDate' 
  	    AND `invoiceLocation`='$pcode'  
		 order by invoiceDate ASC";  
		
   
//echo $sql;
  $sqlQ=mysqli_query($db, $sql);
  $r=mysql_num_rows($sqlQ);
$k=0;  
$i=1;
$crAmount=0;
$array_date=array();
  while($re=mysqli_fetch_array($sqlQ)){
$array_date[$i][0]=$re[invoiceDate];
$array_date[$i][1]=$re[invoiceNo];
$array_date[$i][2]=viewInvoiceType($re[invoiceType]);
$array_date[$i][3]=$re[invoiceAmount];
//$array_date[$i][3]=$re[receiveAccount];//added line by salma
$array_date[$i][4]=2;
  $i++;
  } 
  
/////////////////////////////////////////////////////////////////////
  if($pcode=='000'){
  $sql="select * from `receivecash` WHERE `receiveDate` between '$fromDate' and '$toDate' 
   AND `receiveFrom` LIKE '6100000-$pcode' AND `receiveAccount`='5501000'
    order by receiveDate ASC";  
				}

//echo "$sql<br>";
  $sqlQ=mysqli_query($db, $sql);
  $r=mysql_num_rows($sqlQ);
$k=0;  
$crAmount=0;
while($re=mysqli_fetch_array($sqlQ))
{
$array_date[$i][0]=$re[receiveDate];
$array_date[$i][1]=$re[receiveSL];
$array_date[$i][2]=$re[reff];
$array_date[$i][3]=$re[receiveAmount];
$array_date[$i][4]=2;
  $i++;  
}   
//////////////////////////////////////////////////////////////////////// 
  ?>
<?php  
//print_r($array_date);
 sort($array_date);
$r=sizeof($array_date);
$ro=$r+1;
if($openingBalance!=0 || $r!=0)
  {
?>

    
    <?php echo number_format($openingBalance,2);?>
  
 
    
   	<?php echo "6100000<br>".accountName(6100000);?>
   
          

<?php for($i=0;$i<$r;$i++){?>
 
   <?php echo mydate($array_date[$i][0]);?>
   <?php echo $array_date[$i][1];?>   
   <?php // echo $re[reff];?>      
    <?php echo $array_date[$i][2];?>
   <?php if($array_date[$i][4]=='1'){echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3]; }?>   
   <?php if($array_date[$i][4]=='2'){echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?>   
 
 <?php  $k=1; }//for?>
<?php if($out){?>

 <?php echo number_format($drAmount,2); $drTotal+=$drAmount?>
 <?php echo number_format($crAmount,2); $crTotal+=$crAmount?>
 <?php echo number_format($drAmount-$crAmount,2)?>



 
<?php echo number_format($openingBalance+$drAmount-$crAmount,2)?>



<?php }//out
}
}// if(myarray_search ('2403000',  $accountId)){
?>

<?php 
//added by panna 1916-1996
//print_r($apcode);
/*for($pi=1;$pi<=$spcode;$pi++)
	{
	$k=0;
	$openingBalance=0;
	$baseOpening=0;
	 $drAmount=0;
	$crAmount=0;
	$array_date=array();
	$i=0;
	$pcode=$apcode[$pi];
	
	$openingBalance=openingBalance('6100000',$fromDate,$pcode);
	
	$sql1="select * from `invoice` WHERE `invoiceDate` between '$fromDate' and '$toDate' 
  	    AND `invoiceLocation`='$pcode'  
		 order by invoiceDate ASC";
	//echo $sql1;
	$sqlq1=mysqli_query($db, $sql1);
	while($st=mysqli_fetch_array($sqlq1))
		{
		if(poType($st[posl])==1)
			{
			$array_date[$i][0]=$st[paymentDate];
			$array_date[$i][1]=$st[paymentSL];
			$array_date[$i][2]='';
			$array_date[$i][3]=$st[amount];
			$array_date[$i][4]=1;
			$i++;
			}//if(poType($r[posl])==1)
  		}
   ?>
  	
    <?php echo "6100000-$pcode<br>".accountName('6100000');?>
    <?php echo number_format($openingBalance,2);?>
  	
   	<?php $out=1; ?>
	<?php  
	//print_r($array_date);
	 sort($array_date);
	$r=sizeof($array_date);
	
	for($i=0;$i<$r;$i++)
		{
		?>
 		
		   <?php if($k==0){ ?>  <?php }?>
		   <?php echo mydate($array_date[$i][0]);?>
		   <?php echo $array_date[$i][1];?>   
		   <?php // echo $re[reff];?>      
		    <?php echo $array_date[$i][2];?>
		   <?php if($array_date[$i][4]=='1'){echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3];}?>   
		   <?php if($array_date[$i][4]=='2'){echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?>   
		 
		 <?php  $k=1; 
		 }//for?>


		<?php if($out)
		{?>
			
			 <?php echo number_format($drAmount,2); $drTotal+=$drAmount?>
			 <?php echo number_format($crAmount,2); $crTotal+=$crAmount?>
			 <?php echo number_format($drAmount-$crAmount,2)?>
			
			
			
			 
			<?php echo number_format($openingBalance+$drAmount-$crAmount,2)?>
			
			
			
			<?php 
		}//out?>
<?php } // by panna?>

 <?php */

  $sql="SELECT * from `accounts` where `accountType`='21' AND `accountID` not in ('6100000','6200000')";
 $sqlq=mysqli_query($db, $sql);
 
 while($acc=mysqli_fetch_array($sqlq)){
 $account=$acc[accountID];

if(myarray_search ($account,  $accountId)){
$crAmount=0;$drAmount=0;
$out=1;
$array_date=array();
  $openingBalance=openingBalance($account,$fromDate,$pcode);?> 
  

 <?php
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$i=1;
$sql1="select * from `receivecash` WHERE `receiveDate` between '$fromDate' AND '$toDate' 
       AND `receiveAccount` LIKE '5501000' AND `receiveFrom` LIKE '$account%' ORDER by receiveDate ASC";

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
<?php  
//print_r($array_date);
 sort($array_date);
$r=sizeof($array_date);
$ro=$r+1;
if($openingBalance!=0 || $r!=0)
  {
?>

    
    <?php echo number_format($openingBalance,2);?>
  
 
    
   	<?php echo $account."<br>".accountName($account);?>
   
          
<?php for($i=0;$i<$r;$i++){
?>
 
   <?php echo mydate($array_date[$i][0]);?>
   <?php echo $array_date[$i][1];?>   
   <?php // echo $re[reff];?>      
    <?php echo $array_date[$i][2];?>
   <?php if($array_date[$i][4]=='1'){echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3]; }?>   
   <?php if($array_date[$i][4]=='2'){echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?>   
 
 <?php  $k=1; }//for?>


<?php if($out){?>

 <?php echo number_format($drAmount,2); $drTotal+=$drAmount?>
 <?php echo number_format($crAmount,2); $crTotal+=$crAmount?>
 <?php echo number_format($drAmount-$crAmount,2)?>



 
<?php echo number_format($openingBalance+$drAmount-$crAmount,2)?>



<?php }//out
}
}// if(myarray_search ('2403000',  $accountId)){

}//acount
?>



 <?php 
if(myarray_search ('6402000',  $accountId)){
$out=1;
$drAmount=0;
$crAmount=0;
  $openingBalance=openingBalance('6402000',$fromDate,$pcode);?> 
  
 <?php
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$sql="select * from `receivecash` WHERE `receiveDate` between '$fromDate' AND '$toDate' 
       AND `receiveFrom` LIKE '6402000-$pcode' ORDER by receiveDate ASC";

//echo $sql;
  $sqlQ=mysqli_query($db, $sql);
  $r=mysql_num_rows($sqlQ);
$k=0;  
$i=1;
$crAmount=0;
$array_date=array();
  while($re=mysqli_fetch_array($sqlQ)){
$array_date[$i][0]=$re[receiveDate];
$array_date[$i][1]=$re[receiveSL];
//$array_date[$i][2]=viewInvoiceType($re[invoiceType]);
$array_date[$i][3]=$re[receiveAmount];
$array_date[$i][4]=2;
  $i++;
  }  
  ?>
<?php  
//print_r($array_date);
 sort($array_date);
$r=sizeof($array_date);
if($openingBalance!=0 || $r!=0)
  {
  ?>
  
    
    <?php echo number_format($openingBalance,2);?>
  
  <?php
for($i=0;$i<$r;$i++){
?>

 
   <?php if($k==0){ ?>  <?php echo "6402000-$pcode<br>".accountName('6402000');?><?php }?>
   <?php echo mydate($array_date[$i][0]);?>
   <?php echo $array_date[$i][1];?>   
   <?php // echo $re[reff];?>      
    <?php echo $array_date[$i][2];?>
   <?php if($array_date[$i][4]=='1'){echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3]; }?>   
   <?php if($array_date[$i][4]=='2'){echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?>   
 
 <?php  $k=1; }//for?>
<?php if($out){?>

 <?php echo number_format($drAmount,2); $drTotal+=$drAmount?>
 <?php echo number_format($crAmount,2); $crTotal+=$crAmount?>
 <?php echo number_format($drAmount-$crAmount,2)?>



 
<?php echo number_format($openingBalance+$drAmount-$crAmount,2)?>



<?php }//out
}
}// if(myarray_search ('2403000',  $accountId)){
?>
 <?php /*
if(myarray_search ('6425000',  $accountId)){
$crAmount=0;$drAmount=0;
$out=1;
$array_date=array();
  $openingBalance=openingBalance('6425000',$fromDate,$pcode);?> 
  
    
    <?php echo number_format($openingBalance,2);?>
  

 <?php
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$i=1;
$sql1="select * from `receivecash` WHERE receiveDate between '$fromDate' AND '$toDate' 
       AND receiveFrom LIKE '6425000-$pcode' ORDER by receiveDate ASC";
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
<?php  
//print_r($array_date);
 sort($array_date);
$r=sizeof($array_date);
$ro=$r+1;
?>
 
    
   	<?php echo "6425000<br>".accountName('6425000');?>
   
          
<?php for($i=0;$i<$r;$i++){
?>
 
   <?php echo mydate($array_date[$i][0]);?>
   <?php echo $array_date[$i][1];?>   
   <?php // echo $re[reff];?>      
    <?php echo $array_date[$i][2];?>
   <?php if($array_date[$i][4]=='1'){echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3]; }?>   
   <?php if($array_date[$i][4]=='2'){echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?>   
 
 <?php  $k=1; }//for?>


<?php if($out){?>

 <?php echo number_format($drAmount,2); $drTotal+=$drAmount?>
 <?php echo number_format($crAmount,2); $crTotal+=$crAmount?>
 <?php echo number_format($drAmount-$crAmount,2)?>



 
<?php echo number_format($openingBalance+$drAmount-$crAmount,2)?>



<?php }//out
}// if(myarray_search ('2403000',  $accountId)){
*/
?>

 <?php 
if(myarray_search ('6430000',  $accountId)){
$crAmount=0;$drAmount=0;
$out=1;
$array_date=array();
  $openingBalance=openingBalance('6430000',$fromDate,$pcode);?> 
 

 <?php
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$i=1;
$sql1="select * from `receivecash` WHERE `receiveDate` between '$fromDate' AND '$toDate' 
       AND `receiveFrom` LIKE '6430000-$pcode' ORDER by receiveDate ASC";
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
<?php  
//print_r($array_date);
 sort($array_date);
$r=sizeof($array_date);
$ro=$r+1;
if($openingBalance!=0 || $r!=0)
  {

?>
 
    
    <?php echo number_format($openingBalance,2);?>
  
 
    
   	<?php echo "6430000<br>".accountName('6430000');?>
   
          
<?php for($i=0;$i<$r;$i++){
?>
 
   <?php echo mydate($array_date[$i][0]);?>
   <?php echo $array_date[$i][1];?>   
   <?php // echo $re[reff];?>      
    <?php echo $array_date[$i][2];?>
   <?php if($array_date[$i][4]=='1'){echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3]; }?>   
   <?php if($array_date[$i][4]=='2'){echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?>   
 
 <?php  $k=1; }//for?>


<?php if($out){?>

 <?php echo number_format($drAmount,2); $drTotal+=$drAmount?>
 <?php echo number_format($crAmount,2); $crTotal+=$crAmount?>
 <?php echo number_format($drAmount-$crAmount,2)?>



 
<?php echo number_format($openingBalance+$drAmount-$crAmount,2)?>



<?php }//out
}
}// if(myarray_search ('2403000',  $accountId)){
?>
 <?php 
if(myarray_search ('6435000',  $accountId)){
$crAmount=0;$drAmount=0;
$out=1;
$array_date=array();
  $openingBalance=openingBalance('6435000',$fromDate,$pcode);?> 
  
 <?php
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$i=1;
$sql1="select * from `receivecash` WHERE `receiveDate` between '$fromDate' AND '$toDate' 
       AND `receiveFrom` LIKE '6435000-$pcode' ORDER by receiveDate ASC";
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
<?php  
//print_r($array_date);
 sort($array_date);
$r=sizeof($array_date);
$ro=$r+1;
if($openingBalance!=0 || $r!=0)
  {
?>

    
    <?php echo number_format($openingBalance,2);?>
  

 
    
   	<?php echo "6435000<br>".accountName('6435000');?>
   
          
<?php for($i=0;$i<$r;$i++){
?>
 
   <?php echo mydate($array_date[$i][0]);?>
   <?php echo $array_date[$i][1];?>   
   <?php // echo $re[reff];?>      
    <?php echo $array_date[$i][2];?>
   <?php if($array_date[$i][4]=='1'){echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3]; }?>   
   <?php if($array_date[$i][4]=='2'){echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?>   
 
 <?php  $k=1; }//for?>


<?php if($out){?>

 <?php echo number_format($drAmount,2); $drTotal+=$drAmount?>
 <?php echo number_format($crAmount,2); $crTotal+=$crAmount?>
 <?php echo number_format($drAmount-$crAmount,2)?>



 
<?php echo number_format($openingBalance+$drAmount-$crAmount,2)?>



<?php }//out
}
}// if(myarray_search ('6435000',  $accountId)){
?>
 <?php 
if(myarray_search ('6436000',  $accountId)){
$crAmount=0;$drAmount=0;
$out=1;
$array_date=array();
  $openingBalance=openingBalance('6436000',$fromDate,$pcode);?> 
 

 <?php
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$i=1;
$sql1="select * from `receivecash` WHERE `receiveDate` between '$fromDate' AND '$toDate' 
       AND `receiveFrom` LIKE '6436000-$pcode' ORDER by receiveDate ASC";
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
<?php  
//print_r($array_date);
 sort($array_date);
$r=sizeof($array_date);
$ro=$r+1;
if($openingBalance!=0 || $r!=0)
  {
?>
 
    
    <?php echo number_format($openingBalance,2);?>
  
 
    
   	<?php echo "6436000<br>".accountName('6436000');?>
   
          
<?php for($i=0;$i<$r;$i++){
?>
 
   <?php echo mydate($array_date[$i][0]);?>
   <?php echo $array_date[$i][1];?>   
   <?php // echo $re[reff];?>      
    <?php echo $array_date[$i][2];?>
   <?php if($array_date[$i][4]=='1'){echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3]; }?>   
   <?php if($array_date[$i][4]=='2'){echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?>   
 
 <?php  $k=1; }//for?>


<?php if($out){?>

 <?php echo number_format($drAmount,2); $drTotal+=$drAmount?>
 <?php echo number_format($crAmount,2); $crTotal+=$crAmount?>
 <?php echo number_format($drAmount-$crAmount,2)?>



 
<?php echo number_format($openingBalance+$drAmount-$crAmount,2)?>



<?php }//out
}
}// if(myarray_search ('6436000',  $accountId)){
?>

 <?php
  if(myarray_search ('6801000',  $accountId)){
 $k=0;
 $drAmount=0;
$crAmount=0;
$openingBalance=0;

$array_date=array();
$openingBalance=openingBalance('6801000',$fromDate,$pcode);
  
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
	
$sql1="SELECT SUM(issuedQty*issueRate) as amount,`issueSL`,`issueDate` from issue$pcode,`iow` WHERE 
 `issueDate` BETWEEN '$fromDate' AND '$toDate' AND iow.iowId=issue$pcode.iowId 
 AND iow.iowType='1' GROUP by issue$pcode.issueSL Order by issueDate ASC";
//echo $sql1;
$sqlq1=mysqli_query($db, $sql1);
$i=0;
while($st=mysqli_fetch_array($sqlq1)){
$array_date[$i][0]=$st[issueDate];
$array_date[$i][1]=generate_ISsl($st[issueSL],$pcode);
$array_date[$i][2]='';
$array_date[$i][3]=$st[amount];
$array_date[$i][4]=1;
  $i++;}
   ?>
   
   <?php 
   sort($array_date);
$r=sizeof($array_date);
if($openingBalance!=0 || $r!=0)
  {
   if($k==0){ ?>
  
    
    <?php echo number_format($openingBalance,2);?>
  
   <?php $out=1; }?>
<?php   
for($i=0;$i<$r;$i++){
?>
 
   <?php if($k==0){ ?>  <?php echo "6801000-$pcode<br>".accountName('6801000');?><?php }?>
   <?php echo mydate($array_date[$i][0]);?>
   <?php echo $array_date[$i][1];?>   
   <?php // echo $re[reff];?>      
    <?php echo $array_date[$i][2];?>
   <?php if($array_date[$i][4]=='1'){echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3];}?>   
   <?php if($array_date[$i][4]=='2'){echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?>   
 
 <?php  $k=1; }//for?>
<?php if($out){?>

 <?php echo number_format($drAmount,2); $drTotal+=$drAmount?>
 <?php echo number_format($crAmount,2); $crTotal+=$crAmount?>
 <?php echo number_format($drAmount-$crAmount,2)?>



 
<?php echo number_format($openingBalance+$drAmount-$crAmount,2)?>



<?php }//out
}
}


// if(myarray_search ('4701000',  $accountId)){?>
<!-- equipment-->
 <?php
  if(myarray_search ('6802000',  $accountId)){
 $k=0;
 $drAmount=0;
$crAmount=0;
$openingBalance=0;

$array_date=array();
$openingBalance=openingBalance('6802000',$fromDate,$pcode);
  
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
	
$sql="select `edate`, `posl` from `eqattendance`
 WHERE `edate` between '$fromDate' and '$toDate' 
 AND `location` ='$pcode' 
 GROUP by edate,posl order by edate ASC ";
 
//echo $sql;
  $sqlQ=mysqli_query($db, $sql);
$i=1;  
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
	" AND `posl`='$st[posl]' order by eqId ASC ";
	//echo "$sql2<br>";
	$sqlQ2=mysqli_query($db, $sql2);
	while($re=mysqli_fetch_array($sqlQ2)){
		$dailyworkBreakt=eq_dailyworkBreak($re[eqId],$re[itemCode],$st[edate],$re[eqType],$pcode);
		$toDaypresent=eq_toDaypresent($re[eqId],$re[itemCode],$st[edate],$re[eqType],$pcode);
		$toDaypresent=($toDaypresent-$dailyworkBreakt);
		$rate=eqpoRate($re[itemCode],$st[posl])/(8*3600);
		$pamount+=$toDaypresent*$rate;	
	}//while re
  $array_date[$i][0]=$st[edate];
  $array_date[$i][1]=$st[posl];  
  $array_date[$i][2]=' eq present';
  $array_date[$i][3]=$pamount;  
  $array_date[$i][4]=1;  
  $i++;  
  }//while st
  ?>
   <?php 
   if($openingBalance!=0 || $r!=0)
  {
   if($k==0){ ?>
 
    
    <?php echo number_format($openingBalance,2);?>
  
   <?php $out=1; }?>
<?php   //sort($array_date);
$r=sizeof($array_date);
for($i=1;$i<=$r;$i++){
?>
 
   <?php if($k==0){ ?>  <?php echo "6802000-$pcode<br>".accountName('6802000');?><?php }?>
   <?php echo mydate($array_date[$i][0]);?>
   <?php echo $array_date[$i][1];?>   
   <?php // echo $re[reff];?>      
    <?php echo $array_date[$i][2];?>
   <?php if($array_date[$i][4]=='1'){echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3];}?>   
   <?php if($array_date[$i][4]=='2'){echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?>   
 
 <?php  $k=1; }//for?>

<?php if($out){?>

 <?php echo number_format($drAmount,2); $drTotal+=$drAmount?>
 <?php echo number_format($crAmount,2); $crTotal+=$crAmount?>
 <?php echo number_format($drAmount-$crAmount,2)?>



 
<?php echo number_format($openingBalance+$drAmount-$crAmount,2)?>



<?php }//out
}
}// if(myarray_search ('4702000',  $accountId)){?>

 <!--  UPDATE -->
<!-- SubContract-->
 <?php
  if(myarray_search ('6803000',  $accountId)){
 $k=0;
 $drAmount=0;
$crAmount=0;
$openingBalance=0;

$array_date=array();
$openingBalance=openingBalance('6803000',$fromDate,$pcode);
  
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
	
$sql1="SELECT SUM(qty*rate) as amount,`posl`,`edate` from `subut`,`iow` WHERE 
 subut.edate BETWEEN '$fromDate' AND '$toDate' AND iow.iowId=subut.iow  AND `pcode`='$pcode' 
 AND iow.iowType='1' GROUP by subut.edate,posl Order by subut.edate ASC";
//echo $sql1;
$sqlq1=mysqli_query($db, $sql1);
$i=0;
while($st=mysqli_fetch_array($sqlq1)){
$array_date[$i][0]=$st[edate];
$array_date[$i][1]=$st[posl];
$array_date[$i][2]='';
$array_date[$i][3]=$st[amount];
$array_date[$i][4]=1;
  $i++;}
   ?>  
    
   <?php
   if($openingBalance!=0 || $r!=0)
  {
    if($k==0){ ?>
  
    
    <?php echo number_format($openingBalance,2);?>
  
   <?php $out=1; }?>
<?php   sort($array_date);
$r=sizeof($array_date);
for($i=0;$i<$r;$i++){
?>
 
   <?php if($k==0){ ?>  <?php echo "6803000-$pcode<br>".accountName('6803000');?><?php }?>
   <?php echo mydate($array_date[$i][0]);?>
   <?php echo $array_date[$i][1];?>   
   <?php // echo $re[reff];?>      
    <?php echo $array_date[$i][2];?>
   <?php if($array_date[$i][4]=='1'){echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3];}?>   
   <?php if($array_date[$i][4]=='2'){echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?>   
 
 <?php  $k=1; }//for?>
<?php if($out){?>

 <?php echo number_format($drAmount,2); $drTotal+=$drAmount?>
 <?php echo number_format($crAmount,2); $crTotal+=$crAmount?>
 <?php echo number_format($drAmount-$crAmount,2)?>



 
<?php echo number_format($openingBalance+$drAmount-$crAmount,2)?>



<?php }//out
}
}// if(myarray_search ('4701000',  $accountId)){?>


 
  <?php
 if(myarray_search ('6804000',  $accountId)){
 
 $k=0;
 $drAmount=0;
$crAmount=0;
$openingBalance=0;

$array_date=array();

$openingBalance=openingBalance('6804000',$fromDate,$pcode);
  
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
	
 $si=((strtotime($toDate)-strtotime($fromDate))/86400)+1;
$i=0;	
  for($j=0;$j<$si;$j++){
	$fd=date("Y-m-d",strtotime($fromDate)+(86400*$j));
	$td=$fd;    
	$wages_TotalReceive=wagesAmount_date($pcode,$fd,$td);
	//echo "	wages_TotalReceive=	$wages_TotalReceive<br>";
   if($wages_TotalReceive>0){	
	$array_date[$i][0]=$fd;
	$array_date[$i][1]='';  
	$array_date[$i][2]='consumed';
	$array_date[$i][3]=$wages_TotalReceive;  
	$array_date[$i][4]=1;  $i++;
	}//if($wages_TotalReceive>0)

  }
   ?>
   <?php 
   if($openingBalance!=0 || $r!=0)
  {
   if($k==0){ ?>
  
    
    <?php echo number_format($openingBalance,2);?>
  
   <?php $out=1; }?>
<?php  
//print_r($array_date);
 sort($array_date);
$r=sizeof($array_date);

for($i=0;$i<$r;$i++){
?>
 
   <?php if($k==0){ ?>  <?php echo "6804000-$pcode<br>".accountName('6804000');?><?php }?>
   <?php echo mydate($array_date[$i][0]);?>
   <?php echo $array_date[$i][1];?>   
   <?php // echo $re[reff];?>      
    <?php echo $array_date[$i][2];?>
   <?php if($array_date[$i][4]=='1'){echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3];}?>   
      
 
 <?php  $k=1; }//for?>


<?php if($out){?>

 <?php echo number_format($drAmount,2); $drTotal+=$drAmount?>
 <?php echo number_format($crAmount,2); $crTotal+=$crAmount?>
 <?php echo number_format($drAmount-$crAmount,2)?>



 
<?php echo number_format($openingBalance+$drAmount-$crAmount,2)?>



<?php }//out
}
}// if(myarray_search ('2403000',  $accountId)){
?>
  <?php
  
  
  if(myarray_search ('6902010',  $accountId)){
 $k=0;
 $drAmount=0;
$crAmount=0;
$openingBalance=0;

$array_date=array();
$openingBalance=openingBalance('6902010',$fromDate,$pcode);
  
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
	
$sql1="SELECT SUM(issuedQty*issueRate) as amount,`issueSL`,`issueDate` from issue$pcode,`iow` WHERE 
 `issueDate` BETWEEN '$fromDate' AND '$toDate' AND iow.iowId=issue$pcode.iowId 
 AND iow.iowType='2' GROUP by issue$pcode.issueSL Order by issueDate ASC";
//echo $sql1;
$sqlq1=mysqli_query($db, $sql1);
$i=0;
while($st=mysqli_fetch_array($sqlq1)){
$array_date[$i][0]=$st[issueDate];
$array_date[$i][1]=generate_ISsl($st[issueSL],$pcode);
$array_date[$i][2]='';
$array_date[$i][3]=$st[amount];
$array_date[$i][4]=1;
  $i++;}
   ?>
   
   <?php
   if($openingBalance!=0 || $r!=0)
  {
    if($k==0){ ?>
  
    
    <?php echo number_format($openingBalance,2);?>
  
   <?php $out=1; }?>
<?php   sort($array_date);
$r=sizeof($array_date);
for($i=0;$i<$r;$i++){
?>
 
   <?php if($k==0){ ?>  <?php echo "6902010-$pcode<br>".accountName('6902010');?><?php }?>
   <?php echo mydate($array_date[$i][0]);?>
   <?php echo $array_date[$i][1];?>   
   <?php // echo $re[reff];?>      
    <?php echo $array_date[$i][2];?>
   <?php if($array_date[$i][4]=='1'){echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3];}?>   
   <?php if($array_date[$i][4]=='2'){echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?>   
 
 <?php  $k=1; }//for?>
<?php if($out){?>

 <?php echo number_format($drAmount,2); $drTotal+=$drAmount?>
 <?php echo number_format($crAmount,2); $crTotal+=$crAmount?>
 <?php echo number_format($drAmount-$crAmount,2)?>



 
<?php echo number_format($openingBalance+$drAmount-$crAmount,2)?>



<?php }//out
}
}// if(myarray_search ('4701000',  $accountId)){?>
<!-- SubContract-->
 <?php
  if(myarray_search ('6903000',  $accountId)){
 $k=0;
 $drAmount=0;
$crAmount=0;
$openingBalance=0;

$array_date=array();
$openingBalance=openingBalance('6903000',$fromDate,$pcode);
  
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
	
$sql1="SELECT SUM(qty*rate) as amount,`posl`,`edate` from `subut`,`iow` WHERE 
 subut.edate BETWEEN '$fromDate' AND '$toDate' AND iow.iowId=subut.iow  AND `pcode`='$pcode' 
 AND iow.iowType='2' GROUP by subut.edate,posl Order by subut.edate ASC";
//echo $sql1;
$sqlq1=mysqli_query($db, $sql1);
$i=0;
while($st=mysqli_fetch_array($sqlq1)){
$array_date[$i][0]=$st[edate];
$array_date[$i][1]=$st[posl];
$array_date[$i][2]='';
$array_date[$i][3]=$st[amount];
$array_date[$i][4]=1;
  $i++;}
   ?>
   
   <?php 
   if($openingBalance!=0 || $r!=0)
  {
   if($k==0){ ?>
  
    
    <?php echo number_format($openingBalance,2);?>
  
   <?php $out=1; }?>
<?php   sort($array_date);
$r=sizeof($array_date);
for($i=0;$i<$r;$i++){
?>
 
   <?php if($k==0){ ?>  <?php echo "6903000-$pcode<br>".accountName('6903000');?><?php }?>
   <?php echo mydate($array_date[$i][0]);?>
   <?php echo $array_date[$i][1];?>   
   <?php // echo $re[reff];?>      
    <?php echo $array_date[$i][2];?>
   <?php if($array_date[$i][4]=='1'){echo number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3];}?>   
   <?php if($array_date[$i][4]=='2'){echo number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?>   
 
 <?php  $k=1; }//for?>
<?php if($out){?>

 <?php echo number_format($drAmount,2); $drTotal+=$drAmount?>
 <?php echo number_format($crAmount,2); $crTotal+=$crAmount?>
 <?php echo number_format($drAmount-$crAmount,2)?>



 
<?php echo number_format($openingBalance+$drAmount-$crAmount,2)?>



<?php }//out
}
}// if(myarray_search ('4701000',  $accountId)){?>

 
 <?php
 if(myarray_search ('6901000',  $accountId)){
 $k=0;
 $drAmount=0;
$crAmount=0;
$openingBalance=0;

$openingBalance=openingBalance('6901000',$fromDate,$pcode);
  
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
	
$sql="select `amount`,`paymentSL`,DATE_FORMAT(month, ' %M %Y') as month,`glCode`,`empId`,`designation`,`pdate` from `empsalary`
	WHERE `pdate` between '$fromDate' and '$toDate' 
	AND `glCode` = '6901000-$pcode' order by pdate ASC";
	  
//echo $sql;
  $sqlQ=mysqli_query($db, $sql);
  $r=mysql_num_rows($sqlQ);
  while($salary=mysqli_fetch_array($sqlQ)){ ?>
   <?php 
   if($openingBalance!=0 || $r!=0)
  {
   if($k==0){ ?>
  
    
    <?php echo number_format($openingBalance,2);?>
  
   <?php $out=1; }?>
  
 
   <?php if($k==0){ ?>  
   <?php echo "6901000-$pcode<br>".accountName('6901000');?><?php }?>
   <?php echo mydate($salary[pdate]);?>
   <?php echo $salary[paymentSL];?>   
   <?php // echo $re[reff];?>      
    <?php  echo $salary[month].', '.empName($salary[empId]);?>
   <?php echo number_format($salary[amount],2);?>   
         
 
 <?php  $k=1; $drAmount+=$salary[amount];}//while?>
<?php if($out){?>

 <?php echo number_format($drAmount,2); $drTotal+=$drAmount?>
 <?php echo number_format($crAmount,2); $crTotal+=$crAmount?>
 <?php echo number_format($drAmount-$crAmount,2)?>



 
<?php echo number_format($openingBalance+$drAmount-$crAmount,2)?>



<?php }//out
}
}//if array search?>


 <?php
 //created by 9900000 salma
 if(myarray_search ('9900000', $accountId)){
$drAmount=0;
$crAmount=0;
$openingBalance=0;
$baseOpening=baseOpening('9900000',$pcode);
$openingBalance=$baseOpening+openingBalance('9900000',$fromDate,$pcode);
  
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
	
 /* print $sql="select * from `ex130`,`accounts` 
        WHERE `exDate` between '$fromDate' and '$toDate' 
  	    AND `exgl` LIKE '$account-%'
		AND  accounts.accountID LIKE SUBSTRING(ex130.account,1,7) 
		AND (account='5501000-000' OR accountType='3')  
	   order by exDate ASC";
//echo $sql.'<br>';
  $sqlQ=mysqli_query($db, $sql);
  $i=1;
  $r=mysql_num_rows($sqlQ);
$k=0;  
$out=0;
  while($re=mysqli_fetch_array($sqlQ)){ ?>
   <?php
   if($openingBalance!=0 || $r!=0)
  {

    if($k==0){ */ ?>
  
    
    <?php echo number_format($openingBalance,2);?>
  
   <?php //$out=1; }?>
  
 
   <?php // if($k==0){ ?>  
   <?php echo "9900000-$pcode<br>".accountName('9900000');?><?php // }?>
  <!-- <?php echo mydate($salary[pdate]);?>
   <?php echo $salary[paymentSL];?>   
   <?php // echo $re[reff];?>      
    <?php  echo $salary[month].', '.empName($salary[empId]);?>
   <?php echo number_format($salary[amount],2);?>   
    -->     
 
 <?php //$k=1; $drAmount+=$salary[amount];}//while?>
<?php //if($out){?>

 <?php echo number_format($drAmount,2); $drTotal+=$drAmount?>
 <?php echo number_format($crAmount,2); $crTotal+=$crAmount?>
 <?php echo number_format($drAmount-$crAmount,2)?>



 
<?php echo number_format($openingBalance+$drAmount-$crAmount,2)?>



<?php //}//out
//}
}//if array search?>


 <?php 
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
 $sql="SELECT * from `accounts` where `accountType`='24'";
 $sqlq=mysqli_query($db, $sql);
 
 while($acc=mysqli_fetch_array($sqlq)){
 $account=$acc[accountID];
$drAmount=0;
$crAmount=0;
$openingBalance=0;
if(myarray_search ($account,  $accountId)){
  $openingBalance=openingBalance($account,$fromDate,$pcode);?>
 <?php 
  $sql="select * from `ex130`,`accounts` 
        WHERE `exDate` between '$fromDate' and '$toDate' 
  	    AND `exgl` LIKE '$account-%'
		AND  accounts.accountID LIKE SUBSTRING(ex130.account,1,7) 
		AND (account='5501000-000' OR accountType='3')  
	   order by exDate ASC";
//echo $sql.'<br>';
  $sqlQ=mysqli_query($db, $sql);
  $i=1;
  $r=mysql_num_rows($sqlQ);
$k=0;  
$out=0;
  while($re=mysqli_fetch_array($sqlQ)){?>
   <?php if($k==0){ ?>
  
    
    <?php echo number_format($openingBalance,2);?>
  
 
   
   	<?php echo "$account-$pcode<br>".accountName($account);?>
   
    
<?php $out=1; }?>
 
	
   <?php echo mydate($re[exDate]);?>
   <?php echo $re[paymentSL];?>   
    CDJ      
   <?php echo $re[exDescription];?> 
   <?php echo number_format($re[examount],2);?>   
      
 
<?php   $k=1; $drAmount+=$re[examount]; }//while re?>

<?php if($out){?>

 <?php echo number_format($drAmount,2); $drTotal+=$drAmount?>
 <?php echo number_format($crAmount,2); $crTotal+=$crAmount?>
 <?php echo number_format($drAmount-$crAmount,2)?>



 
<?php echo number_format($openingBalance+$drAmount-$crAmount,2)?>



<?php }//out
}//if array search
  }//while account

/*
 

<tr bgcolor="#33CC66">
 <td colspan="5">
 <?php  echo number_format($drTotal,2);?>
 <?php  echo number_format($crTotal,2);?>
 <td bgcolor="#FFFF66" align="right"><?php  number_format($drTotal-$crTotal,2)?>
 

</table>
*/
?>


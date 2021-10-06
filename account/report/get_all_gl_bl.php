
 <?php
 


 
 
if($pcode=='000')
{
$sql="select * from `accounts` WHERE  `accountType` IN('12','16') ORDER by accountID ASC";
$i=1;
// $sql;
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
	

$sql1="select * from `receivecash` WHERE `receiveDate` between '$fromDate' AND '$toDate' 
       AND (`receiveFrom` LIKE '$ree[accountID]%' OR `receiveAccount` LIKE '$ree[accountID]%') ORDER by receiveDate ASC";
 // $sql1.'<br>';
// $sql1;
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

   $sql2="select * from `ex130` WHERE  `exDate` between '$fromDate' and '$toDate' 
        AND (`paymentSL` LIKE 'ct_%' OR `paymentSL` LIKE 'CT_%')
  	    AND  (`exgl` LIKE '$ree[accountID]%' OR `account` LIKE '$ree[accountID]%') 
  	    order by exDate ASC";  

// "$sql2<br>";
  $sqlQ=mysqli_query($db, $sql2);
  while($re=mysqli_fetch_array($sqlQ)){
//   "<br>***$re[exgl]==$ree[accountID] ***<br>";
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
  
    
    <?php  number_format($openingBalance,2);?>
   
 
   
   	<?php  "$ree[accountID]<br>".accountName($ree[accountID]);?>
   
   
<?php for($i=0;$i<$r;$i++){?>
 
   <?php  mydate($array_date[$i][0]);?>
   <?php  $array_date[$i][1];?>   
    CDJ      
   <?php  $array_date[$i][2];?> 
  <?php if($array_date[$i][4]=='1') {
    number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3];}?>   
  <?php if($array_date[$i][4]=='2') {
    number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?>   
 

<?php   $k=1; }//for ?>



 <?php  number_format($drAmount,2); $drTotal+=$drAmount?>
 <?php  number_format($crAmount,2); $crTotal+=$crAmount?>
 <?php  number_format($drAmount-$crAmount,2)?>



 
<?php  number_format($openingBalance+$drAmount-$crAmount,2)?>



    
    


<?php
}//by panna 
}//if array search
}//while
  }//pcode=000?>
 
  






 <?php 
 //if(myarray_search ('5502000',  $accountId) AND $pcode!='000')
        
        { $crAmount=0;$drAmount=0;
 $baseOpening=baseOpening('5502000',$pcode);
 $openingBalance=$baseOpening+openingBalance('5502000',$fromDate,$pcode);?> 
 
        
 <?php
 
 $array_date=array();

 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
 
 
 
 $sql="select * from `purchase` WHERE `paymentDate` between '$fromDate' and '$toDate' 
   AND `account`='5502000-$pcode' AND `paymentSl` not LIKE 'ct_%' AND `exfor`='$pcode' 
   order by paymentDate ASC";

// $sql;
  $sqlQ=mysqli_query($db, $sql);

$i=1;  
$drAmount=0;
$crAmount=0;
  while($re=mysqli_fetch_array($sqlQ)){
$array_date[$i][0]=$re[paymentDate];
$array_date[$i][1]=$re[paymentSL];
$array_date[$i][2]=$re[paidTo];
$array_date[$i][3]=$re[paidAmount];
$array_date[$i][4]=2;
  $i++;    
  }//while

   $sql2="select * from `ex130` WHERE `exDate` between '$fromDate' and '$toDate' 
        AND (`paymentSL` LIKE 'ct_%' OR `paymentSL` LIKE 'CT_%') 
  	    AND  (`exgl`='5502000-$pcode' OR `account`='5502000-$pcode')  
  	    order by exDate ASC";  
		$ckgl="5502000-$pcode";
// "$sql2<br>";
// "<br>$ckgl";
  $sqlQ=mysqli_query($db, $sql2);
  while($re=mysqli_fetch_array($sqlQ)){
//   "<br>***$re[exgl]==$ree[accountID] ***<br>";
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
   
    
    <?php  number_format($openingBalance,2);?>
   
 
    
   	<?php  "5502000<br>".accountName('5502000');?>
   
       
<?php for($i=0;$i<$r;$i++){?>
 
   <?php  mydate($array_date[$i][0]);?>
   <?php  $array_date[$i][1];?>   
   <?php //  $re[reff];?>      
    <?php  $array_date[$i][2];?>
  <?php if($array_date[$i][4]=='1'){ number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3]; }?>   
  <?php if($array_date[$i][4]=='2'){ number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?>   
 
 <?php  $k=1; }//for?>


 <?php  number_format($drAmount,2); $drTotal+=$drAmount?>
 <?php  number_format($crAmount,2); $crTotal+=$crAmount?>
 <?php  number_format($drAmount-$crAmount,2)?>



 
<?php $the_bl_5100_amount=$openingBalance+$drAmount-$crAmount?>




<?php 
}
 }//if array search?>

 <?php  
$sql="select * from `accounts` WHERE `accountType` IN('4') ORDER by accountID ASC";
$i=1;
// $sql;
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
	

// "<br>$sql2<br>";
//  $r=mysql_num_rows($sql2);
?>

<?php 
   $sql2="select * from `ex130` WHERE `exDate` between '$fromDate' and '$toDate' 
        AND (`paymentSL` LIKE 'ct_%' OR `paymentSL` LIKE 'CT_%')
  	    AND  (`exgl`='$ree[accountID]-$pcode' OR `account`='$ree[accountID]-$pcode') 
  	    order by exDate ASC";  

// "$sql2<br>";
  $sqlQ=mysqli_query($db, $sql2);
  while($re=mysqli_fetch_array($sqlQ)){
//   "<br>***$re[exgl]==$ree[accountID] ***<br>";
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
   
    
    <?php  number_format($openingBalance,2);?>
  
   
   
   	<?php  "$ree[accountID]<br>".accountName($ree[accountID]);?>
   
   
<?php
for($i=0;$i<$r;$i++){?>
 
    
   <?php  mydate($array_date[$i][0]);?>
   <?php  $array_date[$i][1];?>   
    CDJ      
   <?php  $array_date[$i][2];?> 
  <?php if($array_date[$i][4]=='1') {
    number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3];}?>   
  <?php if($array_date[$i][4]=='2') {
    number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?>   
 

<?php   $k=1; }//for ?>



 <?php  number_format($drAmount,2); $drTotal+=$drAmount?>
 <?php  number_format($crAmount,2); $crTotal+=$crAmount?>
 <?php  number_format($drAmount-$crAmount,2)?>



 
<?php  number_format($openingBalance+$drAmount-$crAmount,2)?>




<?php 
}
}//if array search
}//while?>
 <?php  
$sql="select * from `accounts` WHERE `accountType` IN('3') ORDER by accountID ASC";
$i=1;
// $sql;
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
	
  $sql="select * from `purchase` WHERE `paymentDate` between '$fromDate' and '$toDate' AND 
  	     `account`='$ree[accountID]' AND `exfor`='$pcode' AND `paymentSL` not LIKE 'CT_%' 
		 order by paymentDate ASC";  
 // "$sql<br>";
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
  	    AND  (`exgl`='$ree[accountID]' OR `account`='$ree[accountID]') 
  	    AND  (`exgl` LIKE '%-$pcode' OR `account` LIKE '%-$pcode') 		
		order by exDate ASC";  

// "$sql2<br>";
  $sqlQ=mysqli_query($db, $sql2);
  while($re=mysqli_fetch_array($sqlQ)){
//   "<br>***$re[exgl]==$ree[accountID] ***<br>";
  $array_date[$i][0]=$re[exDate];
  $array_date[$i][1]=$re[paymentSL];  
  if($re[exgl]==$ree[accountID]){ $array_date[$i][2]=$re[exDescription]; $array_date[$i][4]=1;  }  
   else  {  $array_date[$i][2]=paymentDes($re[paymentSL]); $array_date[$i][4]=2;  }
  $array_date[$i][3]=$re[examount];      
        
  $i++;
  }//while

$sql1="select * from `receivecash` WHERE `receiveDate` between '$fromDate' AND '$toDate' 
       AND `receiveFrom` LIKE '%-$pcode' AND `receiveAccount`='$ree[accountID]' ORDER by receiveDate ASC";
 // $sql1.'<br>';
// $sql1;
$sqlq1=mysqli_query($db, $sql1);
while($st=mysqli_fetch_array($sqlq1)){
$array_date[$i][0]=$st[receiveDate];
$array_date[$i][1]=$st[receiveSL];
$array_date[$i][2]=$st[reff];
$array_date[$i][3]=$st[receiveAmount];
// "** $st[receiveAmount] **",round($st[receiveAmount],2);
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
  
    
    <?php  number_format($openingBalance,2);?>
  
 
    
   	<?php  "$ree[accountID]<br>".accountName($ree[accountID]);?>
   
   

<?php for($i=0;$i<$r;$i++){?>
 
   <?php  mydate($array_date[$i][0]);?>
   <?php  $array_date[$i][1];?>   
    CDJ      
   <?php  $array_date[$i][2];?> 
  <?php if($array_date[$i][4]=='1') {
    number_format($array_date[$i][3],2); $drAmount+=$array_date[$i][3];}?>   
  <?php if($array_date[$i][4]=='2') {
    number_format($array_date[$i][3],2); $crAmount+=$array_date[$i][3];}?>   
 

<?php   $k=1; }//for ?>



 <?php  number_format($drAmount,2); $drTotal+=$drAmount?>
 <?php  number_format($crAmount,2); $crTotal+=$crAmount?>
 <?php  number_format($drAmount-$crAmount,2)?>



 
<?php  number_format($openingBalance+$drAmount-$crAmount,2)?>




<?php 
}
}//if array search
}//while?>

















 




<?php //out
//if array search
  //while account
/*

 

<tr bgcolor="#33CC66">
  colspan="5">
 <?php   number_format($drTotal,2);?>
 <?php   number_format($crTotal,2);?>
  bgcolor="#FFFF66" align="right"><?php number_format($drTotal-$crTotal,2)?>
  
*/
?>



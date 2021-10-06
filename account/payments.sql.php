<?php

$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
include($localPath."/includes/session.inc.php");
include($localPath."/includes/config.inc.php");
include_once($localPath."/includes/myFunction.php");
include_once($localPath."/includes/myFunction1.php");
include_once($localPath."/includes/accFunction.php");
include_once($localPath."/includes/empFunction.inc.php");
include_once($localPath."/includes/eqFunction.inc.php");
include_once($localPath."/includes/subFunction.inc.php");
include_once($localPath."/includes/matFunction.inc.php");
include_once($localPath.'/includes/vendoreFunction.inc.php');
$toDate=todat();

// echo "<h1>Please make payment later. Payment system is currently under construction. Thank you</h1>"; exit();


  if(!empty($exfor) & $loginProject!='000')
	  $loginProject=$exfor;
	


$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
if(!$db){
   die('Please try later..' );
}
	
if($account1=="6909000" || $account1=="7036000" || $fuelType){}else{
	mysqli_query($db, "SET AUTOCOMMIT=0");
	mysqli_query($db, "START TRANSACTION");
}
$hcash_balance=balance_hcash('000', '2013-01-01',$toDate);
//created 23 no. line by salma
$hcash_balance=$hcash_balance+baseOpening('5501000','000');

if($hcash_balance<=0 AND 
($account=='5501000-000' OR $ct_from_account=='5501000-000')) {
echo wornMsg("No balance in head office cash!");
echo "<a href='../index.php?keyword=payments&w=$w'><--Go Back</a>";

}



if($hcash_balance<=0 AND 
($account=='5501000-000' OR $ct_from_account=='5501000-000')){
 //echo "$hcash_balance < $total";
 echo wornMsg( "STOP!!! You cannot spend from negative balance");
 echo "<a href='../index.php?keyword=payments&w=$w'><--Go Back</a>";
 exit;
}
//exit;
?>
<?  

$paymentSL=generatePaymentSL($w,$loginProject,$paymentDate); 

?>
<?
$paymentDate1=formatDate($paymentDate,"Y-m-d");

$edate = formatDate($edate,"Y-m-d");

//echo "$POpayment n=$n";
if($POpayment){
for($i=1;$i<=$n;$i++){
//$remainAmount=popaymentReamin(${posl.$i});

if($loginProject!='000'){${remainAmount.$i}= ${currentPayable.$i};}
//echo "${amountPaid.$i}>0 AND ${amountPaid.$i}<=${remainAmount.$i}";

$the_paid_amount=${amountPaid.$i};
$the_reamaing_amount=${remainAmount.$i};

  if(${amountPaid.$i}>0 & $the_paid_amoun<=$the_reamaing_amount){

$vpa[]=$_POST['vpa_'.${posl.$i}];
$vid=$_POST['vid_'.$i];
$description=$_POST['desc_'.$i];
	$amount=0;
   $reff=${posl.$i};
   $temp=vendorName($vid);
   $paidTo=$description;
	//$paidTo=$vid;
   $amount=${amountPaid.$i};

	
    print $sqlv="INSERT into vendorpayment (vpid,vid,paymentSL,posl,paidAmount,paymentDate) ".
	" VALUES('',$vid,'$paymentSL','${posl.$i}','$amount','$paymentDate1')";
	echo '<br>'.$sqlv.'******<br>';
	
	mysqli_query($db, $sqlv);
	
$ro=mysqli_affected_rows($db);
	if($ro>0){
	  $sql1 = "UPDATE popayments SET paidAmount=paidAmount+$amount WHERE posl='${posl.$i}'";
	echo $sql1.'<br>';
	$qqfcppurchase== mysqli_query($db, $sql1);
	$totalAmount+=${amountPaid.$i};
	}//ro
	}//if
 }//for


   $paidAmount=$totalAmount;
  if($paidAmount > 0){
 print "85";
  //insertPurchase($paymentSL,$paymentDate1, $paidTo, $account,$exfor,$paidAmount, $reff,$loginProject);//stop by salma
  print $query="INSERT INTO purchase (prId, paymentSL, paymentDate, paidTo, account,exFor, paidAmount, reff,location)".
  "VALUES ('','$paymentSL','$paymentDate1', '$paidTo', '$account','$exfor','$paidAmount', '$reff','$loginProject')";

$qqf=mysqli_query($db, $query);

  }
}//if $POprepayment

if($POprepayment){
for($i=1;$i<$n;$i++){
if(${amountPaid.$i}>0){
	 $amount=0;
   $reff=${posl.$i};
   $temp=vendorName($vid);
   $paidTo=$temp[vname];
   $paidAmount=${amountPaid.$i};
print "103";
//insertPurchase($paymentSL,$paymentDate1, $paidTo, $account,$exfor,$paidAmount, $reff,$loginProject);//stop by salma
print $query="INSERT INTO purchase (prId, paymentSL, paymentDate, paidTo, account,exFor, paidAmount, reff,location)".
 "VALUES ('','$paymentSL','$paymentDate1', '$paidTo', '$account','$exfor','$paidAmount', '$reff','$loginProject')";
$qqf=mysqli_query($db, $query);

	$amount=popaymentPaid(${posl.$i})+${amountPaid.$i};
	print $sql1 = "UPDATE popayments SET paidAmount='$amount' WHERE posl='${posl.$i}'";
	//echo $sql1.'<br>';
	$sqlQuery = mysqli_query($db, $sql1);
	$totalAmount+=${amountPaid.$i};
	
	$approvalSql="delete from vendorPaymentApproval where posl='${posl.$i}'";
	mysqli_query($db,$approvalSql);
	
		
}//if
 }//for
}//if $POprepayment


if($vnedorPrePayment){ //vendor advance payment
$paymentSL=generatePaymentSL($w,$loginProject,$paymentDate); 
for($i=1;$i<$n;$i++){
if(${amountPaid.$i}>0){
	$amount=0;
   $reff=${posl.$i};
   $temp=vendorName($vid);
   $paidTo=$temp[vname];
   $paidAmount=${amountPaid.$i};
print "203";
print $query="INSERT INTO purchase (prId, paymentSL, paymentDate, paidTo, account,exFor, paidAmount, reff,location)".
 "VALUES ('','$paymentSL','$paymentDate1', '$paidTo', '$account','$exfor','$paidAmount', '$reff','$loginProject')";
$qqf=mysqli_query($db, $query);

	if(!popaymentPaidExists(${posl.$i})){
		$sql="insert into popayment (select * from popaymentstemp where posl='${posl.$i}')";
		$q=mysqli_query($db,$sql);
		if(mysqli_affected_rows($db)<1){echo "<h1>Error while make transaction.<h1>";exit;}
		$amount=0;
	}
	else
		$amount=popaymentPaid(${posl.$i})+${amountPaid.$i};
	
// 	vendor payment
	$vendorSql="insert into vendorpayment (vid,paymentSL,posl,paidAmount,paymentDate) values ('$vid','$paymentSL','${posl.$i}','${amountPaid.$i}','$paymentDate1')";
	mysqli_query($db,$vendorSql);
	
	
	print $sql1="UPDATE popayments SET paidAmount='$amount' WHERE posl='${posl.$i}'";
	//echo $sql1.'<br>';
	$sqlQuery = mysqli_query($db, $sql1);
	$totalAmount+=${amountPaid.$i};
	}//if
 }//for
}//if $POprepayment


/* if Apply to Expencess*/
if($calculate){
for($i=1;$i<=2;$i++){
	${exitemCode0.$i}=${exitemCode1.$i}.'-'.${exitemCode2.$i}.'-'.${exitemCode3.$i};
   }
 }
if($cashPurchase){
for($i=1;$i<$n;$i++){
 if(${poqty.$i}){
	$amount=0;
//	$paidAmount=$paidAmount+${examount.$i};
 $sql="select * from porder where poid=${poqty.$i} AND status=1";
//echo "$sql<br>";
$sqlq=mysqli_query($db, $sql);
$r=mysqli_fetch_array($sqlq);

	${cpunitPrice.$i}=round(${examount.$i}/$r[qty],2);
	print "139";
	print $sqlitem1 = "INSERT INTO `storet$exfor` (rsid,itemCode, receiveQty,currentQty, rate, paymentSL, reference, remark,todat)".
	"VALUES ('','$r[itemCode]', '$r[qty]','$r[qty]', '${cpunitPrice.$i}', '$paymentSL', '$r[posl]', '$remark', '$paymentDate1')";
		//echo '<br>'.$sqlitem1.'<br>';
	$queryecpstoret= mysqli_query($db, $sqlitem1);
	mysqli_query($db, "UPDATE porder set status=2 where poid=${poqty.$i}");
	$paidAmount+=round(${cpunitPrice.$i}*$r[qty],2);
   }//$cpquantity.$i
 }//for
//echo $paidAmount;
 if($paidAmount > 0)
 {
 print "152";
 //insertPurchase($paymentSL,$paymentDate1, $paidTo, $account,$exfor,$paidAmount, $reff,$loginProject);//stop by salma
 print  $query="INSERT INTO purchase (prId, paymentSL, paymentDate, paidTo, account,exFor, paidAmount, reff,location)".
  "VALUES ('','$paymentSL','$paymentDate1', '$paidTo', '$account','$exfor','$paidAmount', '$reff','$loginProject')";

$qqfecppurchase=mysqli_query($db, $query);

}
}//if

if($expencess){	
$equIpmentDes="";
	if($account1=="6909000" || $account1=="7036000" || $fuelType){
		$sql="";
		$equipment_fuelArray=explode("_",$equipment_fuel);
		$equipment_fuelArray[2]=$_POST[fuelType];
		$fuelTypeCheck=item2itemCode4Eq(null,$equipment_fuelArray[2]) ? true : false;
		if(!$fuelTypeCheck){ // lubricant oil type account code changed & km should be empty
			$account1="7036000";
			$mKm="";
			$fuelTypePass=true;
		}elseif(!$mKm && $fuelTypeCheck){ // fuel type should contain has km/hour
			$fuelTypePass=false;
		}else
			$fuelTypePass=true;

		if(is_eq_can_consumtion($equipment_fuelArray[0], $equipment_fuelArray[1],$fuelType) && $fuelTypePass){
		$paymentSL=generatePaymentSL(2,$loginProject,$paymentDate);
		$sqlitem1ex="insert into accEqConsumption (eqID,gl,qty,km,edate,amount,eqItemCode,uItemCode) values ('$equipment_fuelArray[0]','$paymentSL','$fQty','$mKm','$paymentDate1','$examount1','$equipment_fuelArray[1]','$fuelType')";
		$qqtQ=mysqli_query($db, $sqlitem1ex);
		$qqt=mysqli_affected_rows($db);
		$qqtID=mysqli_insert_id($db);
		}else{
			echo "<br><h1>Fuel Type error.</h1>";
			exit;
		}
		
		if($qqt<1){
			echo "<br><h1>Error while saving item.</h1>";
			exit;
		}
$equIpmentArr=itemDes($equipment_fuelArray[1]);
if($equIpmentArr)$equIpmentDes="SL#$qqtID, ".$equIpmentArr[des]." EQ. #".$equipment_fuelArray[1].$equipment_fuelArray[0].", Consum.:".$mKm.", Qty.:".$fQty;
}
	
	
for($i=1;$i<=2;$i++){
		$exdes_0=${exdes.$i};
		$examount_0=${examount.$i};
		
  if($examount_0>0){
	  if($loginProject=='000'){
	  
		$account_0=${account.$i}.'-'.$exfor;
			  
	 print "165";
	 print $sqlitem1ex = "INSERT INTO `ex130` (exID,exDescription, exgl,examount,paymentSL,exDate,account)".
		 "VALUES ('','$exdes_0', '$account_0','$examount_0', '$paymentSL','$paymentDate1','$account')";
		 }
	  else{
	  print "170";
	  
		$account_1=${account.$i}.'-'.$loginProject;
	  
		 print $sqlitem1ex = "INSERT INTO `ex130` (exID,exDescription, exgl,examount,paymentSL,exDate,account)".
		 "VALUES ('','$exdes_0', '$account_1','$examount_0', '$paymentSL','$paymentDate1','$account')";
		}
		//echo $sqlitem1.'<br>';
		$querycpex= mysqli_query($db, $sqlitem1ex);
		$paidAmount+=${examount.$i};
   }
 }//for

  if($paidAmount > 0){
		$paidTo.=$paidTo ? "; ".$equIpmentDes : $equIpmentDes;
  print "182";
  //insertPurchase($paymentSL,$paymentDate1, $paidTo, $account,$exfor,$paidAmount, $reff,$loginProject);//stop by salma
  print $query="INSERT INTO purchase (prId, paymentSL, paymentDate, paidTo, account,exFor, paidAmount, reff,location)".
  "VALUES ('','$paymentSL','$paymentDate1', '$paidTo', '$account','$exfor','$paidAmount', '$reff','$loginProject')";

$qqfcppurchase=mysqli_query($db, $query);

 }

//$w='';
}//if

if($cashTransfer){
	
	if(!$paymentDate1){
		echo "Date not found!";
		exit;
	}
	
  if($examount>0){
  print "195";
	print $sqlitem1ex = "INSERT INTO `ex130` (exID,exDescription, exgl,examount,paymentSL,exDate,account)".
	 "VALUES ('','$exdes', '$ct_to_account','$examount', '$paymentSL','$paymentDate1','$ct_from_account')";
// 	echo $sqlitem1.'<br>';
	$queryctex= mysqli_query($db, $sqlitem1ex);
	$paidAmount=$examount;
   }
  if($paidAmount > 0){
  print "204";
  //insertPurchase($paymentSL,$paymentDate1, $paidTo, $ct_from_account,$exfor,$paidAmount, $reff,$loginProject);
   print $query="INSERT INTO purchase (prId, paymentSL, paymentDate, paidTo, account,exFor, paidAmount, reff,location)".
  "VALUES ('','$paymentSL','$paymentDate1', '$paidTo', '$ct_from_account','$exfor','$paidAmount', '$reff','$loginProject')";

$qqfctpurchase=mysqli_query($db, $query);
// echo $query;
// 		exit;
  }//$paidAmount

}
?>

<? 
if($salaryPay){
// echo "value of n= $n<br>";
if($w=='5'){
//echo "salaryPay: $salaryPay";
$salarymonth="$year-$month-01";
//echo "n: ".$n;
for($i=1;$i<$n;$i++){

  if(${ch.$i}){
		$paidTo=empID2empInfo(${empId.$i},"name");
		$PaymentMonthPaidTo=date("F Y",strtotime("$year-$month-01")).", ".$paidTo;	
// 	$paidTo
// echo "value of i= $i<br>";

		$kk=${sal.$i}; //project salary split
		$pp=${prr.$i}; //project code
		$adAmount=${adAmount.$i}; //advanced amount
		
         $amount1=round(${acc1.$i},2)>0 ? round(${acc1.$i},2) : 0; //cash account
         $amount2=${acc2.$i}>0 ? round(${acc2.$i},2) : 0; //bank account
         $tax=${tax.$i}>0 ? round(${tax.$i},2) : 0; //income tax

// income tax 
	$daysofmonth=daysofmonth($salarymonth);
	$dailyTax=$tax/$daysofmonth;	
//end of income tax
		
// 		echo "<br>Size fo: ".sizeof($kk);

	     for($j=0;$j<sizeof($kk);$j++)
			 {
// 				 echo "value of j= $j<br>";
   //echo "<br>CH:".${ch.$i};
	    // echo '>>>>>>>>>>>>>>>>'.$kk[$j].'>>>>>>>>>>>>>>>><br>';
      $amount=round($kk[$j],2);
			 
		 
		  //echo "<br>${empId.$i}==$amount=$kk[$j];$j<br>";
		  $glCode="6901000-".$pp[$j];
				
     if($amount1>0 && $amount>0){
			 
// 		 echo "value of amount= $amount<br>";
// 		 echo "value of amount2= $amount1<br>";
			
			 if($amount>=$amount1)$payAmount=$amount1;
			 if($amount<$amount1)$payAmount=$amount; 

			 
			 $sqlitem1 = "INSERT INTO `empsalary` (id,empId,designation,month,glCode,
			amount,paymentSL,pdate,account)
			VALUES ('','${empId.$i}','${designation.$i}','$salarymonth','$glCode',
			'$payAmount','$paymentSL','$paymentDate1','$account')";
// 			echo '<br>'.$sqlitem1.'<br>#1';
			$query= mysqli_query($db, $sqlitem1);
			if(mysqli_affected_rows($db)>0)	$paidAmount+=$payAmount;
			 
			$query="INSERT INTO purchase (prId, paymentSL, paymentDate, paidTo, account,exFor, paidAmount, reff,location)".
  "VALUES ('','$paymentSL','$paymentDate1', '$PaymentMonthPaidTo', '$account','$exfor','$payAmount', '$reff','$loginProject')";
			 

$qqf=mysqli_query($db, $query);
			 
		if($amount<$amount1)$amount1-=$amount; //amount2 = amount2 - amount
		else $amount1=0;
			 
			}
				 
     if($amount2>0 && $amount>0){
			 
// 		 echo "value of amount= $amount<br>";
// 		 echo "value of amount2= $amount2<br>";
			 
			 if($amount>=$amount2)$payAmount=$amount2;
			 if($amount<$amount2)$payAmount=$amount;			 
			 
			 			 
// 			 tax analysis			 
			 $presentProject=emp_monthlyStay_project(${empId.$i},$month,$year,$exfor);
			 
			 $projectTaxAmount=$presentProject*$dailyTax;
			 $payAmountWithTax=$payAmount+$projectTaxAmount; //project amount include with tax amount
// 			 end of tax analysis
			 
			 
// 			 echo "<br>Size fo: ".sizeof($kk); exit;
			 $paymentSL1=generatePaymentSL($w,$loginProject,$paymentDate); 
			 $paymentSL2=generatePaymentSL($w,$loginProject,$paymentDate); 
			 $sqlitem2 = "INSERT INTO `empsalary` (id,empId,designation,month,glCode,
			amount,paymentSL,pdate,account)
			VALUES ('','${empId.$i}','${designation.$i}','$salarymonth','$glCode',
			'$payAmount','$paymentSL1','$paymentDate1','$account1')";
// 			echo '<br>'.$sqlitem2.'<br>#2';
			$query_2= mysqli_query($db, $sqlitem2);
			if(mysqli_affected_rows($db)>0)	$paidAmount+=$payAmount;
			 
			$query="INSERT INTO purchase (prId, paymentSL, paymentDate, paidTo, account,exFor, paidAmount, reff,location)".
  "VALUES ('','$paymentSL1','$paymentDate1', '$PaymentMonthPaidTo', '$account1','$exfor','$payAmount', '$reff','$loginProject')";
$qqf=mysqli_query($db, $query);
				
			if($tax>0){
				$paymentSL2=generatePaymentSL($w,$loginProject,$paymentDate); 
				$sqlitem2 = "INSERT INTO `empsalary` (id,empId,designation,month,glCode,
			amount,paymentSL,pdate,account)
			VALUES ('','${empId.$i}','${designation.$i}','$salarymonth','$glCode',
			'$projectTaxAmount','$paymentSL2','$paymentDate1','$account1')";
			//echo '<br>'.$sqlitem2.'<br>#2';
			$query_2=mysqli_query($db, $sqlitem2);
			if(mysqli_affected_rows($db)>0)	$paidAmount+=$payAmount;	
			 	 $paymentSL2=generatePaymentSL($w,$loginProject,$paymentDate); 
				 $query="INSERT INTO purchase (prId, paymentSL, paymentDate, paidTo, account,exFor, paidAmount, reff,location) ".
  "VALUES ('','$paymentSL2','$paymentDate1', '$PaymentMonthPaidTo', '2216000-$exfor','$exfor','$projectTaxAmount', '$reff','$loginProject')";
			}
$qqf=mysqli_query($db, $query);
										
											 if($amount<$amount2)$amount2-=$amount; //amount2 = amount2 - amount
			 								 else $amount2=0;
			}				 
		}//for

		
	//advanced payment	
	//if($adAmount>0 && ($amount==$amount1+$amount2)){ //off for testing
	if($adAmount>0){
		updateSalaryAdv(${empId.$i},${designation.$i},${reff.$i},$paymentSL,${adAmount.$i},$salarymonth,$paymentDate1);		
		$paymentSL33=generatePaymentSL($w,$loginProject,$paymentDate); 
			$sqlitem1 = "INSERT INTO `empsalary` (id,empId,designation,month,glCode,
			amount,paymentSL,pdate,account)
			VALUES ('','${empId.$i}','${designation.$i}','$salarymonth','$glCode',
			'$adAmount','$paymentSL33','$paymentDate1','$account')";
			$query= mysqli_query($db, $sqlitem1);
	}
	//advanced payment
		
// 	 UPDATE termination
	   $sql22="UPDATE employee set status='-2' where empId='${empId.$i}' AND status='-1' and MONTH('$salarymonth')=MONTH(jobTer) ";
// 		echo "<br>".$sql22."<br>";
  	  mysqli_query($db, $sql22);
   }//if(${ch.$i})
 }//for

	 if($paidAmount > 0 && 1==2) //switch off this
  {
  print "257";
  //insertPurchase($paymentSL,$paymentDate1, $paidTo, $account,$exfor,$paidAmount, $reff,$loginProject);//stop by salma
  print $query="INSERT INTO purchase (prId, paymentSL, paymentDate, paidTo, account,exFor, paidAmount, reff,location)".
  "VALUES ('','$paymentSL','$paymentDate1', '$PaymentMonthPaidTo', '$account','$exfor','$paidAmount', '$reff','$loginProject')";

$qqf=mysqli_query($db, $query);

  }
}//w==5
elseif($w=='51'){
//echo "salaryPay: $salaryPay";
$salarymonth="$year-$month-01";
//echo "n: ".$n;
for($i=1;$i<$n;$i++){
  if(${ch.$i}){

        $kk=${sal.$i};
		$pp=${prr.$i};

		//echo "<br>Size fo: ".sizeof($kk);

	     for($j=0;$j<sizeof($kk);$j++){
   //echo "<br>CH:".${ch.$i};
	    // echo '>>>>>>>>>>>>>>>>'.$kk[$j].'>>>>>>>>>>>>>>>><br>';
          $amount=round($kk[$j],2);
		  $glCode="2404000-".$pp[$j];
     if($amount>0){
			 $sqlitem1 = "INSERT INTO `empsalary` (id,empId,designation,month,glCode,
			amount,paymentSL,pdate,account)
		    VALUES('','${empId.$i}','${designation.$i}','$salarymonth','$glCode',
			'$amount','$paymentSL','$paymentDate1','$account')";
			//echo '<br>'.$sqlitem1.'<br>';
			$query= mysqli_query($db, $sqlitem1);
			if(mysqli_affected_rows($db)>0)	$paidAmount+=$amount;
			}		
		}//for
	if(${adAmount.$i}>0)updateSalaryAdv(${empId.$i},${designation.$i},${reff.$i},$paymentSL,${adAmount.$i},$salarymonth,$paymentDate1);
	 /* UPDATE termination*/
	   $sql22="UPDATE employee set status='-2' where empId='${empId.$i}' AND status='-1' and MONTH('$salarymonth')=MONTH(jobTer) ";
  	  mysqli_query($db, $sql22);

   }//if(${ch.$i})
 }//for
  if($paidAmount > 0)
  {
  //insertPurchase($paymentSL,$paymentDate1, $paidTo, $account,$exfor,$paidAmount, $reff,$loginProject);//stop by salma
 print "302";
 print $query="INSERT INTO purchase (prId, paymentSL, paymentDate, paidTo, account,exFor, paidAmount, reff,location)".
  "VALUES ('','$paymentSL','$paymentDate1', '$paidTo', '$account','$exfor','$paidAmount', '$reff','$loginProject')";

$qqf=mysqli_query($db, $query);
}
}//w==51
  

}//ifif($salaryPay)

?>
<?
if($wagesPay){
//echo "salaryPay: $salaryPay";
$paidAmount=0;
$salarymonth="$year-$month-01";
//echo "n: ".$n;
for($i=1;$i<$n;$i++){
  if(${ch.$i})
		{
			$glCode="2404000-".$loginProject;

			 $sqlitem1 = "INSERT INTO `empsalary` (id,empId,designation,month,glCode,amount,paymentSL,pdate,account)
			VALUES ('','${ch.$i}','${designation.$i}','$salarymonth','$glCode',
			'${currentPayable.$i}','$paymentSL','$paymentDate1','$account')";
			//echo '<br>'.$sqlitem1.'<br>';
			$query= mysqli_query($db, $sqlitem1);
             $r=mysqli_affected_rows($db);
			 if($r>0){$paidAmount=$paidAmount+${currentPayable.$i};
		         //echo "paidAmount=$paidAmount<br>"; 
				 $r=0;}
		}
/* UPDATE termination*/
	   $sql22="UPDATE employee set status='-2' where empId='${empId.$i}' AND status='-1' and MONTH('$salarymonth')=MONTH(jobTer) ";
  	  mysqli_query($db, $sql22);		
 }//for
 if($paidAmount > 0){
 print "342";
 //echo "AAAAAAAAAAAAAAAA";
 //insertPurchase($paymentSL,$paymentDate1, $paidTo, $account,$exfor,$paidAmount, $reff,$loginProject);//stop by salma
 print $query="INSERT INTO purchase (prId, paymentSL, paymentDate, paidTo, account,exFor, paidAmount, reff,location)".
  "VALUES ('','$paymentSL','$paymentDate1', '$paidTo', '$account','$exfor','$paidAmount', '$reff','$loginProject')";

$qqf=mysqli_query($db, $query);

 }
 $paidAmount=0;
}//if wagesPay

?>

<?
if($adsalaryPayment){
$paidAmount=0;
	for($i=1;$i<$n;$i++){
		if(${ch.$i}){
				 $paidTo=empID2empInfo(${employee.$i},"name");
				 $PaymentMonthPaidTo=date("F Y",strtotime($paymentDate1)).", ".$paidTo;
				 $paidToAll.=", ".$PaymentMonthPaidTo;
				 $sql="UPDATE empsalaryad set status=2,pdate='$paymentDate1',account='$account',paymentSl='$paymentSL' 
				WHERE id=${ch.$i}";
				//echo $sql.'<br>';
				$sqlq=mysqli_query($db, $sql);
				$paidAmount+=${approvedAmount.$i};
			}//if(${ch.$i})
	}
 if($paidAmount > 0)
 {
	 $paidToAll=trim($paidToAll,",");
//insertPurchase($paymentSL,$paymentDate1, $paidTo, $account,$exfor,$paidAmount, $reff,$loginProject);//stop by salma
print "369";
	 $paidTo=empID2empInfo($employee,$col="name");
  print $query="INSERT INTO purchase (prId, paymentSL, paymentDate, paidTo, account,exFor, paidAmount, reff,location)".
  "VALUES ('','$paymentSL','$paymentDate1', '$paidToAll', '$account','$exfor','$paidAmount', '$reff','$loginProject')";

$qqf=mysqli_query($db, $query);
}

}/*
if($querycpex and $qqfcppurchase)
{
mysqli_query($db, "COMMIT;");
}
elseif($queryctex and $qqfctpurchase)
{
mysqli_query($db, "COMMIT;");
}
elseif($queryecpstoret and $qqfecppurchase)
{
mysqli_query($db, "COMMIT;");
}
else*/
{        
// mysqli_query($db, "ROLLBACK;");
}

echo "<br><h2>YOUR INFORMATION IS SAVING PLEASE WAIT....</h2>";


if($vpa){
	for($qq1=0;$qq1<=count($vpa);$qq1++)
		$qqq=$vpa[$qq1].", ".$qqq;
	echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=./delete_vendor_payment.php?qqq=$qqq\">";	
}
else
echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=payments&w=$w&year=$year&month=$month&vid=$vid&exfor=$exfor\">";




exit;
?>
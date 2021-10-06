<?
include("../includes/session.inc.php");
include("../includes/config.inc.php");
include_once("../includes/myFunction.php");
include_once("../includes/myFunction1.php");
include_once("../includes/accFunction.php");
include_once("../includes/empFunction.inc.php");
include_once("../includes/eqFunction.inc.php");
include_once("../includes/subFunction.inc.php");
include_once("../includes/matFunction.inc.php");
include_once('../includes/vendoreFunction.inc.php');
$toDate=todat();


  if(!empty($exfor) & $loginProject!='000')
	  $loginProject=$exfor;
	


$db = @mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
if (!$db) {
   die('Please try later..' );
}
	
	
mysqli_query($db, "SET AUTOCOMMIT=0");
mysqli_query($db, "START TRANSACTION");	
$hcash_balance=balance_hcash('000', '2013-01-01',$toDate);
//created 23 no. line by salma
$hcash_balance=$hcash_balance+baseOpening('5501000','000');

if($hcash_balance<=0 AND 
($account=='5501000-000' OR $ct_from_account=='5501000-000')) {
echo wornMsg("No balance in head office cash!");
echo "<a href='../index.php?keyword=payments&w=$w'><--Go Back</a>";
exit;
}

if($hcash_balance<=0 AND 
($account=='5501000-000' OR $ct_from_account=='5501000-000')) {

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
for($i=1;$i<$n;$i++){
//$remainAmount=popaymentReamin(${posl.$i});

if($loginProject!='000'){${remainAmount.$i}= ${currentPayable.$i};}
//echo "${amountPaid.$i}>0 AND ${amountPaid.$i}<=${remainAmount.$i}";

$the_paid_amount=${amountPaid.$i};
$the_reamaing_amount=${remainAmount.$i};

  if(${amountPaid.$i}>0 & $the_paid_amoun<=$the_reamaing_amount){


	$amount=0;
   $reff=${posl.$i};
   $temp=vendorName($vid);
   $paidTo=$temp[vname];
	//$paidTo=$vid;
   $amount=${amountPaid.$i};
	
    print $sqlv="INSERT into vendorpayment (vpid,vid,paymentSL,posl,paidAmount,paymentDate) ".
	" VALUES('',$vid,'$paymentSL','${posl.$i}','$amount','$paymentDate1')";
	echo '<br>'.$sqlv.'******<br>';
	mysqli_query($db, $sqlv);
	$ro=mysqli_affected_rows();
	if($ro>0){
	  $sql1 = "UPDATE popayments SET paidAmount=paidAmount+$amount WHERE posl='${posl.$i}'";
	echo $sql1.'<br>';
	$sqlQuery = mysqli_query($db, $sql1);
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
  print "182";
  //insertPurchase($paymentSL,$paymentDate1, $paidTo, $account,$exfor,$paidAmount, $reff,$loginProject);//stop by salma
  print $query="INSERT INTO purchase (prId, paymentSL, paymentDate, paidTo, account,exFor, paidAmount, reff,location)".
  "VALUES ('','$paymentSL','$paymentDate1', '$paidTo', '$account','$exfor','$paidAmount', '$reff','$loginProject')";

$qqfcppurchase=mysqli_query($db, $query);

 }

//$w='';
}//if

if($cashTransfer){
  if($examount>0){
  print "195";
	print $sqlitem1ex = "INSERT INTO `ex130` (exID,exDescription, exgl,examount,paymentSL,exDate,account)".
	 "VALUES ('','$exdes', '$ct_to_account','$examount', '$paymentSL','$paymentDate1','$ct_from_account')";
	//echo $sqlitem1.'<br>';
	$queryctex= mysqli_query($db, $sqlitem1ex);
	$paidAmount=$examount;
   }
  if($paidAmount > 0){
  print "204";
  //insertPurchase($paymentSL,$paymentDate1, $paidTo, $ct_from_account,$exfor,$paidAmount, $reff,$loginProject);
   print $query="INSERT INTO purchase (prId, paymentSL, paymentDate, paidTo, account,exFor, paidAmount, reff,location)".
  "VALUES ('','$paymentSL','$paymentDate1', '$paidTo', '$ct_from_account','$exfor','$paidAmount', '$reff','$loginProject')";

$qqfctpurchase=mysqli_query($db, $query);

  }//$paidAmount

}
?>

<?
if($salaryPay){

if($w=='5'){
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
		 // print_r($kk);
		  //echo "<br>${empId.$i}==$amount=$kk[$j];$j<br>";
		  $glCode="6901000-".$pp[$j];
     if($amount>0){
			 $sqlitem1 = "INSERT INTO `empsalary` (id,empId,designation,month,glCode,
			amount,paymentSL,pdate,account)
			VALUES ('','${empId.$i}','${designation.$i}','$salarymonth','$glCode',
			'$amount','$paymentSL','$paymentDate1','$account')";
			//echo '<br>'.$sqlitem1.'<br>';
			$query= mysqli_query($db, $sqlitem1);
			if(mysqli_affected_rows()>0)	$paidAmount+=$amount;
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
  print "257";
  //insertPurchase($paymentSL,$paymentDate1, $paidTo, $account,$exfor,$paidAmount, $reff,$loginProject);//stop by salma
  print $query="INSERT INTO purchase (prId, paymentSL, paymentDate, paidTo, account,exFor, paidAmount, reff,location)".
  "VALUES ('','$paymentSL','$paymentDate1', '$paidTo', '$account','$exfor','$paidAmount', '$reff','$loginProject')";

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
			if(mysqli_affected_rows()>0)	$paidAmount+=$amount;
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
             $r=mysqli_affected_rows();
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
				 $sql="UPDATE empsalaryad set status=2,pdate='$paymentDate1',account='$account',paymentSl='$paymentSL' 
				WHERE id=${ch.$i}";
				//echo $sql.'<br>';
				$sqlq=mysqli_query($db, $sql);
				$paidAmount+=${approvedAmount.$i};
			}//if(${ch.$i})
	}
 if($paidAmount > 0)
 {
//insertPurchase($paymentSL,$paymentDate1, $paidTo, $account,$exfor,$paidAmount, $reff,$loginProject);//stop by salma
print "369";
  print $query="INSERT INTO purchase (prId, paymentSL, paymentDate, paidTo, account,exFor, paidAmount, reff,location)".
  "VALUES ('','$paymentSL','$paymentDate1', '$paidTo', '$account','$exfor','$paidAmount', '$reff','$loginProject')";

$qqf=mysqli_query($db, $query);
}

}
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
else
{        
mysqli_query($db, "ROLLBACK;");
}

echo "YOUR INFORMATION IS SAVING PLEASE WAIT....";
echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=payments&w=$w&year=$year&month=$month&vid=$vid&exfor=$exfor\">";
exit;
?>
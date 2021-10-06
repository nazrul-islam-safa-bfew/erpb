<? 
error_reporting(0);
include("../includes/session.inc.php");
include("../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
include_once("../includes/myFunction.php");
$salaryPay=$_POST[salaryPay];
$w=$_POST[w];
$n=$_POST[n];
$exfor=$_POST[exfor];

// date
$year=$_POST[year];
$month=$_POST[month];

$empID=$_GET[empID];
$forMonth=$_GET[forMonth];
if($empID && $forMonth && $_GET[del]=="del"){
	$sql="delete from Monthly_salary_adjustment where empID=$empID and forMonth='$forMonth'";
	mysqli_query($db,$sql);
	$t=mysqli_affected_rows($db);		
}


if($year && $month && $salaryPay){ //save update

for($i=0;$i<=$n;$i++){
  ${empId.$i}=$_POST["empId".$i];  
  ${ch.$i}=$_POST["ch".$i];
  ${sal.$i}=$_POST["sal".$i];
  ${acc1.$i}=$_POST["acc1".$i];
  ${acc2.$i}=$_POST["acc2".$i];
  ${tax.$i}=$_POST["tax".$i];
}


$i=0;
$t=0;
if($salaryPay){ 

$salarymonth="$year-$month-01";
// echo "n: ".$n;
// echo "<br>i: ".$i;
for($i=1;$i<$n;$i++){
  if(${ch.$i}){
		
		
         $amount1=round(${acc1.$i},2)>0 ? round(${acc1.$i},2) : 0; //cash account
         $amount2=${acc2.$i}>0 ? round(${acc2.$i},2) : 0; //bank account
         $tax=${tax.$i}>0 ? round(${tax.$i},2) : 0; //income tax

			$amountMarge="C:".$amount1.",T:".$tax.",B:".$amount2;
		

      $amount=round($kk[$j],2);
      
      $sql="select *  from Monthly_salary_adjustment where empID='${empId.$i}' and forMonth='$salarymonth'";
      mysqli_query($db,$sql);
			if(mysqli_affected_rows($db)<1) { //entry not exists
         $sqlitem1 = "INSERT INTO `Monthly_salary_adjustment` (empID,forMonth,project,amount,account)
        VALUES ('${empId.$i}','$salarymonth','$exfor','$amountMarge','$account')";
        $query= mysqli_query($db, $sqlitem1);
      }elseif(mysqli_affected_rows($db)==1){
         $sqlitem1 = "update `Monthly_salary_adjustment` set amount='$amountMarge'
        where empID='${empId.$i}' and forMonth='$salarymonth'";
        $query= mysqli_query($db, $sqlitem1);        
      }
    if(mysqli_affected_rows($db)>0)$t++;

}
}
}
}//if save update

if($t>0)
  echo "YOUR INFORMATION IS SAVING PLEASE WAIT....";
else
  echo "Error";
echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=payments&w=5\">";
  ?>
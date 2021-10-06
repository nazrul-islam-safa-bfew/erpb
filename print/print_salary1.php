<? include_once("../includes/myFunction1.php");
include("../includes/config.inc.php");
include_once("../includes/myFunction.php");
include_once("../includes/empFunction.inc.php");
include_once("../includes/accFunction.php");

$todat=todat();
//$year=2007;
?>
<html>
<head>

<LINK href="../style/print.css" type=text/css rel=stylesheet>
<meta http-equiv="Content-Language" content="en-us">
<meta name="author" content="<? echo $mauthor;?>">
<meta name="copyright" content="<? echo $tt;?>">
<meta name="keywords" content="<? echo $kword;?>">
<META NAME="description" CONTENT="<? echo $des;?>">
<title>BFEW :: Print Salary</title>
</head>
<body  topmargin="1" leftmargin="5" rightmargin="5" bgcolor="#FFFFFF" >
<table width="500" border="0"  align="center" cellpadding="5" cellspacing="5">
<tr>
 <th><font class="englishheadBlack">Bangladesh Foundry and Engineering Works Ltd.</font></th>
</tr>
<tr>
 <th>Salary for the month of  <? echo date('F, Y',strtotime("$year-$month-01")).' '.myprojectName($exfor).' Project'; ?></th>
</tr>
</table>
<br>
<br>
<table   width="100%" align="center" border="2" bordercolor="#999999" cellspacing="0" cellpadding="5" style="border-collapse:collapse">
 <tr bgcolor="#EEEEEE">
   <th valign="top">SL</th>
   <th valign="top">EmployeeID,<br> Designation</th>
   <th valign="top">Employee Name</th>
   <th valign="top" width="100">Remarks</th>  
   <th valign="top">Basic</th>
   <th valign="top">H/Rent</th>   
   <th valign="top">Med</th>   
   <th valign="top">Conv</th>   
   <th valign="top">Salary Amount</th>   
   <th valign="top" width="100">Monthly Adjustment</th>      
   <th valign="top" width="100">Current Payble</th> 
   <th valign="top">Signature</th>    
 </tr>
 <tr><td colspan="12"></td></tr>
 <?
 $ck=explode('_',$chk);
 function isChecked($ck,$k){
  for($i=0;$i<sizeof($ck);$i++)
    if($ck[$i]==$k) return true;
 }
 
// $year=thisYear();
$sdate="$year-$month-01";
$daysofmonth = daysofmonth($sdate);
$edate="$year-$month-$daysofmonth";
include("../includes/config.inc.php");

$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
//$sqlp = "SELECT * from `employee` WHERE location='$exfor' AND empDate<='2006-$month-01' AND (salaryType='Salary' OR salaryType='Wages Monthly' )  order by designation ASC ";
$sqlp = "SELECT * from `employee` WHERE location='$exfor' AND empDate<='$year-$month-01' AND status<>'-2'".
"  AND (salaryType='Salary' OR salaryType='Wages Monthly' )".
"  order by designation ASC ";
//echo $sqlp;
$sqlrunp= mysql_query($sqlp);
$monthlyWork=monthlyWork($month,$year);

$b=1;
$k=1;
$totalAmount=0;
//$year=thisYear();
$daysofmonth = daysofmonth("$year-$month-01");
while($re=mysql_fetch_array($sqlrunp)){
$actualSalary=0;
$paid=0;
$withoutPayAmountTotal=0;
$terAmount=0;
$empStatus=$re[status];
$withoutPay=array();
$loc=array();
if(isChecked($ck,$re[empId])){
if(isSalaryPaid($re[empId],$month,$year)){
$advanceSadjust=0;
$advanceSadjustRef='';
$advanceSadjust1=explode('/',advanceSadjust($re[empId],$month));

$advanceSadjust=$advanceSadjust1[0];
$advanceSadjustRef=$advanceSadjust1[1];

$actualSalary=$re[salary]-$advanceSadjust;

?>
 <tr <? if($b%2==0) echo 'bgcolor=#FFFFEE';?> >
   <td valign="top" align="center"><? echo $b;?></td>
   <td valign="top" ><? echo '<font class=out>'.empId($re[empId],$re[designation]).'</font>';   
    echo '<br>'.hrDesignation($re[designation]);?> 
   <input  type="hidden" name="empId<? echo $b;?>" value="<? echo $re[empId];?>">
   <input  type="hidden" name="designation<? echo $b;?>" value="<? echo $re[designation];?>">   
   </td>
   <td valign="top" align="left"><? echo $re[name];?> </td>   
<td valign="top" > 
      <? 
 $sqlf = "SELECT DISTINCT location from attendance where empId='$re[empId]' AND 
  edate BETWEEN '$sdate' AND  '$edate' ORDER by location ASC ";
//echo $sqlf.'<br>';
$sqlQ= mysql_query($sqlf);
$rows=mysql_num_rows($sqlQ);

if($rows){
	$i=0;
	while($rr=mysql_fetch_array($sqlQ)){

	$loc[$i]=$rr[location];
	$pre[$i]=emp_monthlyPresent_project($re[empId],$month,$year,$rr[location]);
	$leave[$i]=emp_monthlyLeave_project($re[empId],$month,$year,$rr[location]);
	$absent[$i]=emp_monthlyAbsent_project($re[empId],$month,$year,$rr[location]);
	$withoutPay[$i]=withoutPay($re[empId],$month,$year,$rr[location]);
	$tp+=$pre[$i];
	$ta+=$absent[$i];	
	$workday[$i]=emp_monthlyStay_project($re[empId],$month,$year,$rr[location]);	
	echo "$loc[$i]-$pre[$i] P, $leave[$i] L, <font class=out>$absent[$i] A</font>"; 
if($withoutPay[$i]) echo ", <font class=out>$withoutPay[$i] NoPay</font>";echo "<br>";

$i++;
}
$withoutPay_perdaysalary=$actualSalary/$daysofmonth;
$perdaysalary=$withoutPay_perdaysalary;
$actualSalaryProject=0;

for($i=0;$i<sizeof($loc);$i++){
	$withoutPayAmount=round($withoutPay[$i]*$withoutPay_perdaysalary);
	//echo "**$withoutPayAmount==".$withoutPay[$i]."*$withoutPay_perdaysalary****<br>";	
	$ss=round($perdaysalary*$pre[$i])-$withoutPayAmount;	
	$actualSalaryProject+=$perdaysalary*$workday[$i];	
	//echo "** $actualSalaryProject+=$perdaysalary*$workday[$i];**	";
	//echo "L=$loc[$i]=> S=$ss<br>";	
	echo "<input type=hidden name=sal".$b.'['.$i."] value=$ss>";
	echo "<input type=hidden name=prr".$b.'['.$i."] value=$loc[$i]>";
     $withoutPayAmountTotal=$withoutPayAmountTotal+$withoutPayAmount; 

	 $withoutPayAmount=0;
	//echo "**".$loc[$i]."=$ss-$withoutPayAmount**<br>";
	}//for
 }//if size of loc
//}
if($empStatus=='-1') echo '<font class=outi>Terminate on '.myDate($re[jobTer]).'</font>';
 ?>
    </td>
	<? if($re[designation]<'75-00-000'){?>
	<td colspan="4" align="center">Consolidated</td>
	<? } else {?>
   <td valign="top" align="right" ><? $basic=basic($re[designation]); echo number_format($basic,2);?></td> 
   <td valign="top" align="right" ><? $houseRent=houseRent($re[designation],$basic); echo number_format($houseRent,2);?></td> 
   <td valign="top" align="right" ><? $medical=medical($re[designation],$basic); echo number_format($medical,2);?></td> 
   <td valign="top" align="right" ><? $convence=convence($re[designation],$basic); echo number_format($convence,2);?></td>          
   <? }//else?>

   <td valign="top" align="right"><? echo number_format($re[salary],2);?> </td>   
    <td valign="top" align="right">
	  <? if($advanceSadjust){ echo '-'.number_format($advanceSadjust,2);?>
  	  <input type="hidden" name="adAmount<? echo $b;?>" value="<? echo $advanceSadjust;?>">
	  <input type="hidden" name="reff<? echo $b;?>" value="<? echo $advanceSadjustRef;?>">	  
	  
         <? }?>
<? 
if($empStatus=='-1'){
	 $jobTer=$re[jobTer];
	  if(date('m',strtotime($jobTer))==$month)
	  {
	  
	 	$du=1+abs(strtotime("$year-$month-01")-strtotime($jobTer))/86400;

		$tre=$daysofmonth-$du;
		$terAmount=$withoutPay_perdaysalary*$tre;
		//echo "<br>***$du=$tre=terAmount=$terAmount<br>";
		}
	 }

?>		 
	  <? $incentive=incentive($re[empId],$year,$month); if($incentive)echo number_format($incentive,2);?><br>
	 
      <? if($withoutPayAmountTotal) echo ' <br>('.number_format($withoutPayAmountTotal,2).')'; 
	  	  if($terAmount)  echo ' <br>('.number_format($terAmount,2).')'; 
	  ?>
    </td>  
   <td valign="top" align="right"><? 	
	$paid=currentPayble($re[empId],"$year-$month-01");
		
	$payable=$actualSalaryProject-$paid-$withoutPayAmountTotal;
//echo "$actualSalaryProject-$paid-$withoutPayAmountTotal<br>";
	echo number_format($payable,2);	

	$withoutPayAmountTotal=0;
	?> 
	</td>     
   <td valign="top" align="center" width="100"></td>   	      
 </tr> 
 <? 
  $totalAmount+= $payable;

 $b++;
 $ta=0;
 }//if checked 
 }//if paid
 } //while?>
 <tr>
 <tr>
  <td colspan="11" align="right"> Total Amount:  <? echo number_format($totalAmount,2);?> </td>

 </tr>

 </table>
   <br>
  <br>
<? include('../bottom.php');?>
</body>

</html>
 

<? 
error_reporting(0);
include("../includes/session.inc.php");
include("../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

include_once("../includes/myFunction1.php");
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
<body  topmargin="1" leftmargin="7" rightmargin="7" bgcolor="#FFFFFF" style="margin-left: 7px; margin-right: 7px;" >
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


<table   width="100%" align="center" border="2" bordercolor="#000" cellspacing="0" cellpadding="5" style="border-collapse:collapse">
 <tr bgcolor="#EEEEEE">
   <th valign="top">SL</th>
   <th valign="top">EmployeeID,<br> Designation</th>
   <th valign="top">Employee Name</th>
   <th valign="top" width="100">Remarks</th>
  
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

//$sqlp = "SELECT * from `employee` WHERE location='$exfor' AND empDate<='2006-$month-01' AND (salaryType='Salary' OR salaryType='Wages Monthly' )  order by designation ASC ";
$sqlp = "SELECT * from `employee` WHERE location='$exfor' AND empDate<='$year-$month-$daysofmonth' AND status<>'-2'".
"  AND  salaryType in ('Salary','Wages Monthly','Consolidated' ) and empId in ($id)".
"  order by designation ASC";
// echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
$monthlyWork=monthlyWork($month,$year);

$b=1;
$k=1;
$totalAmount=0;
//$year=thisYear();
$daysofmonth = daysofmonth("$year-$month-01");
while($re=mysqli_fetch_array($sqlrunp)){
$actualSalary=0;
$paid=0;
$withoutPayAmountTotal=0;
$terAmount=0;
$empStatus=$re[status];
$withoutPay=array();
$loc=array();
if(isChecked($ck,$re[empId]) || 1==1){
if(isSalaryPaid($re[empId],$month,$year)){
$advanceSadjust=0;
$advanceSadjustRef='';
$advanceSadjust1=explode('/',advanceSadjust_v2($re[empId],$year."-".$month."-01"));

$advanceSadjust=$advanceSadjust1[0];
$advanceSadjustRef=$advanceSadjust1[1];

$actualSalary=$re[salary]-$advanceSadjust;
// echo $de =$re[designation]."ddddddddddddddddddddddd";
// $p = explode("-",$de );
// $po = $p[0]."-".$p[1]."-";
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
$sqlQ= mysqli_query($db, $sqlf);
$rows=mysqli_num_rows($sqlQ);

if($rows){
	$i=0;
	while($rr=mysqli_fetch_array($sqlQ)){

	$loc[$i]=$rr[location];
	$pre[$i]=emp_monthlyPresent_project($re[empId],$month,$year,$rr[location]);
	$leave[$i]=emp_monthlyLeave_project($re[empId],$month,$year,$rr[location]);
	$absent[$i]=emp_monthlyAbsent_project($re[empId],$month,$year,$rr[location]);
	$withoutPay[$i]=withoutPay($re[empId],$month,$year,$rr[location]);
	$tp+=$pre[$i];
	$ta+=$absent[$i];
	$workday[$i]=emp_monthlyStay_project($re[empId],$month,$year,$rr[location]);
	$holiday[$i]=emp_monthlyHoliday_project($re[empId],$month,$year,$rr[location]);
	echo "$loc[$i]-$pre[$i] P, $leave[$i] L, <font class=out>$absent[$i] A</font>";
	echo ", <font class=out>$holiday[$i] HP</font>";
	if($withoutPay[$i])echo ", <font class=out>$withoutPay[$i] NoPay</font>";
	echo "<br>";
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
	
   <td valign="top" align="right"><? echo number_format($re[salary],2);?> </td>   
    <td valign="top" align="right">
	  <? if($advanceSadjust){ echo "-".number_format($advanceSadjust,2);?>
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

	$hrRow=hrSalaryPermissoinROW($re[empId],"$year-$month-01");
	if(!is_array($hrRow)){
		$hrRow=get_last_row_of_salary_allocation($re[empId]);		
	}
	$amountArray=empPaymentExploder($hrRow[amount]);

	echo "Bank: ".number_format($amountArray[B],2);
	echo "<br>I.T: ".number_format($amountArray[T],2);
	echo "<br>Cash: ".number_format($amountArray[C],2);

	$withoutPayAmountTotal=0;
	?> 
	</td>     
   <td valign="top" align="center" width="100"></td>   
 </tr>
 <?

  // $totalAmount+= $payable;
  $totalAmount= $amountArray[B]+ $amountArray[C] + $amountArray[T];
  $grand_totalAmount+= $totalAmount;
	$lm_designation = $re['designation'];
 $b++;
 $ta=0;
 }//if checked 
 }//if paid
 } //while?>
 <tr>
 <tr>
  <td colspan="7" align="right"> Total Amount: <? echo number_format($grand_totalAmount,2);?> </td>

 </tr>

 </table>
 <br><br>
 <br><br>
 <br><br>
 <br><br>
 <br><br>
 <br><br>
 <br><br>
 <table width="100%" align="center">
 
    <tr>
		<th>
		    <ol style="list-style-type: none;">
				<li>Prepared by</li>
				<li style="color: red; text-decoration: underline;">Najifa Anjum </li>
				<li>HR Executive,</li>
				<li>Payroll management</li>
			</ol>	
		</th>
		<th>
		    <ol style="list-style-type: none;">
				<li>Checked & recommended by</li>
				<li style="color: red; text-decoration: underline;">
				<?
					$managerArr=getManager($lm_designation,$exfor);
					if (empty($managerArr)) {
						echo "<font color='#f00'>No Line manager found</font>";
					}
						else
						echo "<font color='#f00'>$managerArr[name]</font>";
				?>
			    </li>
				<li>
				<?
				$des = hrDesignation($managerArr[designation]);
						echo strlen($des)>0 ? $des : "No line manager designation found.";
				?>
				</li>
			</ol>	
		</th>
		<th>
		    <ol style="list-style-type: none;">
				<li>Approved by</li>
				<li style="color: red; text-decoration: underline;"> Mr.Harun Or Rashid </li>
				<li>HR Manager</li>
			</ol>	
		</th>
		<th>
		<th>
		    <ol style="list-style-type: none;">
				<li>Paid By</li>
				<li style="color: red; text-decoration: underline;">
					<? 
					$CashName = getCashierWages($exfor);
					$CashierName =$CashName['name'];
					if (empty($CashierName)) {
						echo "<font color='#f00'>No Cashier found</font>";
						}
					else
					echo $CashierName;          
					?>
				</li>		
				<!-- <li style="color: red; text-decoration: underline;"> Mr. Shahjahan  </li> -->
				<li>Cashier</li>
			</ol>	
		</th>
		    <!-- <ol style="list-style-type: none;">
				<li>Paid By</li>
				<li style="color: red; text-decoration: underline;"> Mr. Shahjahan  </li>
				<li>Cashier</li>
			</ol>	 -->
		</th>
    </tr>
 
 
 <!-- <tr>
		<th>Prepared by</th>
		<th>HR &amp; Admin Manager</th>  
		<th>Checked by Accounts</th>  
		<th>Manager MIS &amp; Accounts</th>  
		<th>Director Admin.</th>  
		<th>Managing Director</th> 
  </tr> -->
 </table>
<br>
<br>
<br>
<br>
<br><br>
<br><br>

<!-- Printed for Project 200 on August 23, 2016; 03:15PM by Md. Shajahan, Cashier -->
Printed for Project <?php echo myprojectName($exfor); ?> on <?php echo todat_new_format("M d, Y; h:iA"); ?>; <?php echo $_SESSION["loginFullName"]; ?>, <?php echo $_SESSION["loginDesignation"]; ?>
<? include('../bottom.php');?>
</body>

</html>
 

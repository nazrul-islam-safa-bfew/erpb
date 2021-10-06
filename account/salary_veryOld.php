<table   width="100%" align="center" border="2" class="dblue">
 <tr bgcolor="#EEEEEE">
   <th valign="top">SL</th>
   <th valign="top">EmployeeID,<br> Designation</th>
   <th valign="top">Employee Name</th>
   <th valign="top" width="200">Remarks</th>  
   <th valign="top">Basic</th>
   <th valign="top">H/Rent</th>   
   <th valign="top">Med</th>   
   <th valign="top">Conv</th>   
   <th valign="top">Salary Amount</th>   
   <th valign="top">Monthly Adjustment</th>      
   <th valign="top">Current Payble</th> 
   <th valign="top">Pay to</th>    
 </tr>
 <tr><td colspan="12"></td></tr>
 	<input type="hidden" name="p" value="100">	
 <?
include("./includes/config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
if($w==5){
$sqlp = "SELECT * from `employee` WHERE location='$exfor' AND empDate<='$year-$month-01' AND status<>'-2'".
"  AND salaryType='Salary' AND designation>='70-00-000' AND designation<='85-00-000'".
"  order by designation ASC ";
}
else if($w=='51'){
$sqlp = "SELECT * from `employee` WHERE location='$exfor' AND empDate<='$year-$month-01' AND status<>'-2' 
 AND salaryType='Consolidated' AND designation>='86-00-000' AND designation<'99-00-000'
 order by designation ASC";
}

//echo $sqlp;
$sqlrunp= mysql_query($sqlp);
$monthlyWork=monthlyWork($month,$year);
$b=1;
$totalAmount=0;

//$year=thisYear();
$sdate="$year-$month-01";
$daysofmonth = daysofmonth($sdate);
$edate="$year-$month-$daysofmonth";
while($re=mysql_fetch_array($sqlrunp)){
$valid=0;
$payable=0;
$loc=array();
$from=array();
$to=array();
$pre=array();
$holiday=array();
$leave=array();
$workday=array();
$ta=0;
$empStatus=$re[status];
if(isSalaryPaid($re[empId],$month,$year)){

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
$valid=1;	

	
	$loc[$i]=$rr[location];
	$pre[$i]=emp_monthlyPresent_project($re[empId],$month,$year,$rr[location]);
	$leave[$i]=emp_monthlyLeave_project($re[empId],$month,$year,$rr[location]);
	$absent[$i]=emp_monthlyAbsent_project($re[empId],$month,$year,$rr[location]);
	$holiday[$i]=emp_monthlyHoliday_project($re[empId],$month,$year,$rr[location]);	
	$withoutPay[$i]=withoutPay($re[empId],$month,$year,$rr[location]);
	$tp+=$pre[$i];
	$ta+=$absent[$i];
	$workday[$i]=emp_monthlyStay_project($re[empId],$month,$year,$rr[location]);	

	echo "$loc[$i]-$pre[$i] P, $leave[$i] L, $holiday[$i] HP, <font class=out>$absent[$i] A</font>"; 
if($withoutPay[$i]) echo ", <font class=out>$withoutPay[$i] NoPay</font>";echo "<br>";

$i++;
}
$withoutPay_perdaysalary=$actualSalary/$daysofmonth;
$perdaysalary=$withoutPay_perdaysalary;
$actualSalaryProject=0;
for($i=0;$i<sizeof($loc);$i++){
	$withoutPayAmount=round($withoutPay[$i]*$withoutPay_perdaysalary);
	$ss=round($perdaysalary*$workday[$i])-$withoutPayAmount;
	$actualSalaryProject+=$perdaysalary*$workday[$i];
	//echo "## $perdaysalary*$workday[$i]-$withoutPayAmount;##";
	echo "<input type=hidden name=sal".$b.'['.$i."] value=$ss>";
	echo "<input type=hidden name=prr".$b.'['.$i."] value=$loc[$i]>";
     $withoutPayAmountTotal=$withoutPayAmountTotal+$withoutPayAmount; $withoutPayAmount=0;
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
    <td valign="top" align="right" >
	  <? if($advanceSadjust){ echo '<font class=out>('.number_format($advanceSadjust,2).')</font>';?>
  	  <input type="hidden" name="adAmount<? echo $b;?>" value="<? echo round($advanceSadjust,2);?>">
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
	 }?>	  
	  <? $incentive=incentive($re[empId],$year,$month); if($incentive)echo number_format($incentive,2);?>
	  <br>
      <? if($withoutPayAmountTotal) echo '-'.$withoutPayAmountTotal; 
	  if($terAmount) echo "<br>-$terAmount";?>
    </td>  
   <td valign="top" align="right"><? 	
	$paid=currentPayble($re[empId],"$year-$month-01");	
	$payable=$actualSalaryProject-$paid-$withoutPayAmountTotal;		
//	$payable=$actualSalaryProject-$paid-$withoutPayAmountTotal-$terAmount;
//echo "$actualSalaryProject-$paid-$withoutPayAmountTotal-$terAmount;";
	//echo "**$actualSalary-$paid-$withoutPayAmountTotal-$terAmount;**";
	echo number_format($payable,2);
	$withoutPayAmountTotal=0;
	$terAmount=0;
	?> 
	<input type="hidden" name="currentPayable<? echo $b;?>" value="<? echo round($payable,2);?>" alt="">

	</td>  
	
	<td valign="top" align="center"><input type="checkbox" name="ch<? echo $b;?>" value="<? echo $re[empId];?>" <? if(${ch.$b}) echo 'checked';?> 
   <? 
   if($ta>0 || $payable==0 || $valid==0) echo ' disabled';?> onClick="if(this.checked==true){currentPayable<? echo $b;?>.alt='cal';p.value=p.value+'_<? echo $b;?>'} else {currentPayable<? echo $b;?>.alt=''}" onchange="disableSave(this.form);"></td>   	      
   
 </tr> 
 <?  if(${ch.$b}) $totalAmount+= $payable;

 $b++;
 $ta=0;
 }//if paid
 
 } //while?>
 <tr>
  <td colspan="11" align="right"> Total Amount:<input type="text" readonly="" name="total" id="total" style=" border:0;background: #FFFFCC;text-align:right"> </td>
  <td  align="center"><input type="button" value="calculate" name="calculate" onClick="calc(this.form);twoDigitConversation(this.form,'total');
  myOnclick('<? echo $exfor;?>','<? echo $month;?>',this.form);"></td>
 </tr>
  <input type="hidden" name="n" value="<? echo $b;?>">
  <tr>
    <td colspan="12" align="center"><input type="submit" value="Paid" name="save" disabled="disabled" onClick="payments.salaryPay.value=1;payments.submit();">
	<input type="hidden" name="salaryPay" value="0"></td>
 </tr>
 </table>
 <script language="JavaScript1.1">
 function mygoto(a,b,c,d){
//location.href='./print/print_salary.php?exfor='+a+'&month='+b+'&total='+c; 
window.open('./print/print_salary.php?exfor='+a+'&month='+b+'&chk='+c+'&year='+d);
 }
 
 function myOnclick(a,b,which) {
var out='';

for (i=0;i<which.length;i++) {
var tempobj=which.elements[i];
//alert(tempobj.type);
if (tempobj.type=="checkbox") {  
 if(tempobj.checked==true) out+='_'+tempobj.value;
  }

}
which.chk.value=out;
//alert(out);
//window.open('./print/print_salary.php?exfor='+a+'&month='+b+'&total='+out);
}
 </script>
<input type="hidden" name="chk">
 
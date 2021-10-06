<p style="color:red; text-align:right;">Note: Partial payment not allowed.</p>
<script type="text/javascript" src="./js/jquery-1.9.0.min.js"></script>
		 <script type="text/javascript">
		 $(document).ready(function(){
			 function numberFormat(val,len=2){
				 var str=val.toString().split(".");
				 try{
					 if(str[1].length > 2){
						 return str[0]+"."+str[1].substr(0,len);
					 }
				 }catch(e){
					 
				 }
				 return parseFloat(val);
			 }
			 
			 $("input:checkbox").change(function(){
				 var acc2=parseFloat($(this).parent().parent().find("input#acc2").val());
				 var acc1=parseFloat($(this).parent().parent().find("input#acc1").val());
				 var tax=parseFloat($(this).parent().parent().find("input#tax").val());
				 var tax=parseFloat($(this).parent().parent().find("input#tax").val());
				 if(isNaN(acc2))
				 	$(this).parent().parent().find("input#acc2").val("0.00");
				 if(isNaN(acc1))
				 	$(this).parent().parent().find("input#acc1").val("0.00");
				 if(isNaN(tax))
				 	$(this).parent().parent().find("input#tax").val("0.00");
			 });

			 $("input#tax").change(function(){
				 tax=parseFloat($(this).val());
				 acc2=parseFloat($(this).parent().find("input#acc2").val());
				 acc1=parseFloat($(this).parent().find("input#acc1").val());
				 total=$(this).parent().find(":hidden").val();

				 acc1=numberFormat(total-(acc2+tax),2);
				 if(acc1>0){
					 $(this).parent().find("input#acc1").val(acc1);
					 if(isNaN(tax))$(this).val(0);
					 if(isNaN(tax))$(this).parent().find("input#tax").val(0);
				 }
				 if( ((acc1+acc2+tax)-total)>.8 || acc1<0){
					 alert("Please check the amount. Conflict:"+((acc1+acc2+tax)-total));
					 $(this).val(0.00);
					 $(this).parent().find("input#sumAmount").val(acc2);
				 }else{
					 $(this).parent().find("input#sumAmount").val(acc1+acc2+tax);
				 }
			 });

			 $("input#acc1").change(function(){
				 acc1=parseFloat($(this).val());
				 acc2=parseFloat($(this).parent().find("input#acc2").val());
				 tax=parseFloat($(this).parent().find("input#tax").val());
				 total=$(this).parent().find(":hidden").val();
				 
				 if(isNaN(acc1))$(this).val(0);
				 if(isNaN(acc2))$(this).parent().find("input#acc2").val(0);
				 
				 
				 if((acc1+acc2+tax)-total){
					 alert("Please check the amount. Conflict:"+((acc1+acc2+tax)-total));
					 $(this).val(0.00);
					 $(this).parent().find("input#sumAmount").val(acc2);
				 }else{
					 $(this).parent().find("input#sumAmount").val(acc1+acc2+tax);
				 }
			 });
			 
			 $("input#acc2").change(function(){
				 acc2=parseFloat($(this).val());
				 acc1=parseFloat($(this).parent().find("input#acc1").val());
				 tax=parseFloat($(this).parent().find("input#tax").val());
				 total=$(this).parent().find(":hidden").val();
				 
				 acc1=(total-(acc2+tax));
				 
				 acc1=numberFormat(acc1,2);
				 if(acc1>=0){
					 $(this).parent().find("input#acc1").val(acc1);
					 if(isNaN(acc1))$(this).val(0);
					 if(isNaN(acc2))$(this).parent().find("input#acc2").val(0);
}
				 
// 				 console.log("acc1:"+acc1+", acc2:"+acc2+", Tax:"+tax+", total:"+total+", Sum:"+(acc1+acc2+tax));
				 if( ((acc1+acc2+tax)-total)>.8 || acc1<0 ){
					 alert("Please check the amount. Conflict:"+((acc1+acc2+tax)-total));
					 $(this).val(0.00);
					 $(this).parent().find("input#sumAmount").val(acc1);
				 }else{
					 $(this).parent().find("input#sumAmount").val(acc1+acc2+tax);
				 }
			 });
		 });
			 

		 </script>
<table width="100%" align="center" border="2" class="dblue">
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
   <th valign="top">Current Payable &amp; Accounts Selection</th> 
   <th valign="top">Pay to</th>  
 </tr>
 <tr><td colspan="12"></td></tr>
 <input type="hidden" name="p" value="100">
 <?
	
$sMonth="$year-$month";
$sdate="$year-$month-01";
$daysofmonth = daysofmonth($sdate);
include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
if($w==5){
$sqlp = "SELECT * from `employee` WHERE location='$exfor' AND empDate<='$year-$month-$daysofmonth' AND status<>'-2'".
"  AND salaryType='Salary' AND designation>'70-99-999' AND designation<='85-00-000'".
"  order by designation ASC ";
}
else if($w=='51'){
$sqlp = "SELECT * from `employee` WHERE location='$exfor' AND empDate<='$year-$month-$daysofmonth' AND status<>'-2' 
 AND salaryType='Consolidated' AND designation>='86-00-000' AND designation<'99-00-000'
 order by designation ASC";
}

// echo $sqlp;

$sqlrunp= mysqli_query($db, $sqlp);
$monthlyWork=monthlyWork($month,$year); 
$b=1;
$totalAmount=0;

//$year=thisYear();
$edate="$year-$month-$daysofmonth";
while($re=mysqli_fetch_array($sqlrunp)){ 
// if(isEmployeeHasFullMonthPresent($re[empId],$sMonth))continue; //this module
if(isTerminatedBefore($re[empId],$month,$year))continue;
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
$re[salary]+=getSalaryIncrements($re[empId],$sdate);//salary attached with increment amounts.
$salaryPaidRow=salaryPaidRow($re[empId],$month,$year);

if(isSalaryPaid($re[empId],$month,$year) || $re[salary]>$salaryPaidRow[amount]){

$advanceSadjust1=explode('/',advanceSadjust_v2($re[empId],$sdate));

$advanceSadjust=$advanceSadjust1[0];
$advanceSadjustRef=$advanceSadjust1[1];
	
	if(isCurrentMonthAdvancedAlreadyPaid($re[empId],$month)){
		$advanceSadjust=0;
		$advanceSadjustRef=0;
	}
// print_r( $advanceSadjust1);
// $actualSalary=$re[salary]-$advanceSadjust; rule off by suvro

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
 $sqlf="SELECT DISTINCT location from attendance where empId='$re[empId]' AND 
  edate BETWEEN '$sdate' AND  '$edate' ORDER by location ASC ";
//echo $sqlf.'<br>';
$sqlQ=mysqli_query($db, $sqlf);
$rows=mysqli_num_rows($sqlQ);

if($rows){
	$i=0;
while($rr=mysqli_fetch_array($sqlQ)){
	$valid=1;
	$loc[$i]=$rr[location];
	$pre[$i]=emp_monthlyPresent_project($re[empId],$month,$year,$rr[location]);
	$leave[$i]=emp_monthlyLeave_project($re[empId],$month,$year,$rr[location]);
	$absent[$i]=emp_monthlyAbsent_project($re[empId],$month,$year,$rr[location]);
	$holiday[$i]=emp_monthlyHoliday_project($re[empId],$month,$year,$rr[location]);
	$withoutPay[$i]=withoutPay($re[empId],$month,$year,$rr[location]);
	$withPay[$i]=withoutPay($re[empId],$month,$year,$rr[location],"1");
	$tp+=$pre[$i];
	$ta+=$absent[$i];
// print_r($holiday);
	$workday[$i]=emp_monthlyStay_project($re[empId],$month,$year,$rr[location],true);

	echo "$loc[$i]-$pre[$i] P, $leave[$i] L, $holiday[$i] HP, <font class=out>$absent[$i] A</font>"; 
	if($withoutPay[$i]) echo ", <font class=out>$withoutPay[$i] NoPay</font>";echo "<br>";
	$i++;
}
$withoutPay_perdaysalary=$re[salary]/$daysofmonth;
// advanced adj
$advanceSadjust_perday=$advanceSadjust/$daysofmonth;
// 	end of adj
$perdaysalary=$withoutPay_perdaysalary;
// echo "<br>PerdaySalary$daysofmonth:$perdaysalary<br>";
$adv_amount=$advanceSadjust;
$actualSalaryProject=0;
for($i=0;$i<sizeof($loc);$i++){
	// $adv_amount=$advanceSadjust_perday*$workday[$i];
// 	echo "<br>======$withoutPayAmount===</br>";
	$withoutPayAmount=round($withoutPay[$i]*$withoutPay_perdaysalary);
	$withPayAmount=($withPay[$i]*$withoutPay_perdaysalary);
	$ss=round($perdaysalary*$workday[$i])-$withoutPayAmount-round($adv_amount)+$withPayAmount;
	$ss=$ss-alreadyPaid($re[empId],$loc[$i],$month,$year);
	$actualSalaryProject+=($perdaysalary*$workday[$i])/*-$adv_amount*/+ $withPayAmount-$withoutPayAmount;
//  	echo "$$$actualSalaryProject+=($perdaysalary*$workday[$i])-$adv_amount##";
//  	echo "$$$actualSalaryProject## $perdaysalary*$workday[$i]-$withoutPayAmount;##";
	echo "<input type=hidden name=sal".$b.'['.$i."] value=$ss>";
	echo "<input type=hidden name=prr".$b.'['.$i."] value=$loc[$i]>";
     $withoutPayAmountTotal=$withoutPayAmountTotal+$withoutPayAmount; $withoutPayAmount=0;
     $withPayAmountTotal=$withPayAmountTotal+$withPayAmount;	$withPayAmount=0;
	}//for
 }//if size of loc
//}
if($empStatus=='-1') echo '<font class=outi>Terminate on '.myDate($re[jobTer]).'</font>';
if(getReleasedDate($re[empId]))
	echo "<span style='background: #f00;
    color: #fff;
    border-radius: 5px;
    padding: 1px 2px;'>Terminated</span>";
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
// 	echo $empStatus;
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
      <? if($withoutPayAmountTotal)echo '-'.$withoutPayAmountTotal; 
	  if($terAmount) echo "<br>-$terAmount";?>
    </td>  
  <td valign="top" align="right">Current Payable: <font color="#f00"><?
	//$paid=currentPayble($re[empId],"$year-$month-01");
	//echo "$payable=$actualSalaryProject-$paid-$withoutPayAmountTotal+$withPayAmountTotal;";
	$payable=$actualSalaryProject-$paid-$adv_amount;/*-$withoutPayAmountTotal+$withPayAmountTotal;*/
	//	$payable=$actualSalaryProject-$paid-$withoutPayAmountTotal-$terAmount;
	//echo "$actualSalaryProject-$paid-$withoutPayAmountTotal-$terAmount;";
	//echo "**$actualSalary-$paid-$withoutPayAmountTotal-$terAmount;**";
	
	//echo number_format($payable,2);
	$withoutPayAmountTotal=0;
	$withPayAmountTotal=0;
	$terAmount=0;
	
	echo $tk=number_format($payable,2);
	$paymentTk=str_replace(",","",$tk);
	
	$previous_range=get_last_row_of_salary_allocation($re[empId]);
	$previous_rangeAmount=empPaymentExploder($previous_range[amount]);
	$previous_total=$previous_rangeAmount[C]+$previous_rangeAmount[B]+$previous_rangeAmount[T];
	if($previous_total!=$payable)
		unset($previous_rangeAmount);
	
	
	?> </font>
	<input type="hidden" name="currentPayable<? echo $b;?>" id="currentPayable<? echo $b;?>" value="<?php  echo $paymentTk; ?>" alt="">
	<input type="hidden" name="sumAmount<? echo $b;?>" id="sumAmount" value="<?php  echo $paymentTk; ?>" alt="">
<br>	
	<span>Bank Acc.</span><input type="text" value="<?php  if(($exfor!="000" && $loginProject=='000') || $loginDesignation=='Human Resource Manager')echo ($previous_rangeAmount[B] ? $previous_rangeAmount[B] : (!$previous_total ? $paymentTk : "0.00"));else echo "0.00";  ?>" name="acc2<? echo $b;?>"  id="acc2" style="   text-align:right;  height: 10px;" alt="<? echo $b;?>"  <?php if($loginProject!='000')echo "readonly"; ?>><br>
	
	<span>Income Tax</span> 
		 <input type="number" name="tax<? echo $b;?>" value="0.0"  id="tax" style=" text-align:right;   height: 10px;" alt="" value="<?php echo $previous_rangeAmount[T] ? $previous_rangeAmount[T] : "0.00"; ?>"><br>
			 <span><?php echo $accountDesc . " Cash Acc."; ?></span>
			 <input type="text" name="acc1<? echo $b;?>"  id="acc1" style=" text-align:right;   height: 10px;" value="<?php  if(($exfor=="000" || $loginProject!='000') || $loginDesignation=='Human Resource Manager')echo $previous_rangeAmount[C] ? $previous_rangeAmount[C] : "0.00";else echo "0.00";  ?>" alt="<? echo $b;?>" <?php if($exfor!="000" && $loginProject=='000' || 1==1)echo "readonly"; ?>>
		 <br>
		 <div>
<?php 
	$registed=empPayment4mHR($re[empId],$sdate);
	if($registed){
		echo "Bank:<font color='#00f'><b>$registed[B]</b></font>, Tax:<font color='#00f'><b>$registed[T]</b></font>, Cash:<font color='#00f'><b>$registed[C]</b></font>";
		echo '<a href="./employee/monthly_salary_adjustment.sql.php?empID='.$re[empId].'&forMonth='.$sdate.'&del=del" style="padding:0 5px; background:#f00; color:#fff;"> Remove<a>';
	}
?>
	</div>
	</td>  
	<td valign="top" align="center">
		<?php   
	if(isSalaryPaid($re[empId],$month,$year)){
			//echo $ta; ?>
				<input type="checkbox" name="ch<? echo $b;?>" value="<? echo $re[empId];?>" <? if(${ch.$b}) echo 'checked';?> 
			 <?
			 if($ta>0 || $payable==0 || $valid==0) echo ' disabled';?> onClick="if(this.checked==true){currentPayable<? echo $b;?>.alt='cal';sumAmount<? echo $b;?>.alt='calc';p.value=p.value+'_<? echo $b;?>'} else {currentPayable<? echo $b;?>.alt='';sumAmount<? echo $b;?>.alt='';}">
				 <? 
			 if($ta>0 || $payable==0 || $valid==0){

			 }else{ ?>

		<!-- 	<br><br><a href='http://win4win.biz/erp/bfew/print/print_salary.php?exfor=<?php echo $exfor; ?>&year=<?php echo $year; ?>&month=<?php echo $month; ?>&id=<?php echo $re[empId]; ?>' style="padding:2px;" target="_blank">Print</a> -->
			 <?php }
}else{ //is paid
		echo "Paid";
	}
		?>
	 </td>
   
 </tr> 
 <?  if(${ch.$b}) $totalAmount+= $payable;

 $b++;
 $ta=0;
 }//if paid
 
 } //while?>
<!--  <tr>
  <td colspan="11" align="right">
<!-- 		Total Amount: -->
		<input type="hidden" readonly="" name="total" id="total" style=" border:0;background: #FFFFCC;text-align:right">
<!-- 	 </td>
  <td  align="center">
		<input type="button" value="calculate" name="calculate" onClick="calc(this.form,'calc');twoDigitConversation(this.form,'total');
  myOnclick('<? echo $exfor;?>','<? echo $month;?>',this.form);">
	 </td>
 </tr> -->
	
  <input type="hidden" name="n" value="<? echo $b;?>">
  <tr>
    <td colspan="12" align="center">
			<input type="submit" value="Save" name="save" onClick="calc(this.form,'calc');twoDigitConversation(this.form,'total');payments.salaryPay.value=1; payments.submit();"> 
			<input type="button" value="Print" id="print" onClick="">
			<input type="hidden" name="salaryPay" value="0">
		</td>
 </tr>
 </table>
<script type="text/javascript">
$(document).ready(function(){
	$("#print").click(function(){
		var c_k=[];
		var year=$("select[name='year']").val();
		var month=$("select[name='month']").val();
		var exfor=$("select[name='exfor']").val();
		$("input[type='checkbox']:checked").each(function(){
			c_k.push($(this).val());
		});
		window.location.href='./print/print_salary_multiple.php?id='+c_k+"&year="+year+"&month="+month+"&exfor="+exfor;
	});
});

</script>


 <script language="JavaScript1.1">
 function mygoto(a,b,c,d){
//location.href='./print/print_salary.php?exfor='+a+'&month='+b+'&total='+c; 
window.open('./print/print_salary.php?exfor='+a+'&month='+b+'&chk='+c+'&year='+d);
 }
 
function myOnclick(a,b,which){
	var out='';
	for (i=0;i<which.length;i++){
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
 
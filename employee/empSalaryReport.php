<center><h1>
	Wages Report
</h1></center>
<form name="payments" action="./index.php?keyword=empSalary+report" method="post">
<div>
Year:
	<select name="year" size="1">
		<option  value="">Select year</option>
		<option value="2021" <? if($year=='2021') echo 'selected';?>>2021</option>
		<option value="2020" <? if($year=='2020') echo 'selected';?>>2020</option>
		<option value="2019" <? if($year=='2019') echo 'selected';?>>2019</option>
		<option value="2018" <? if($year=='2018') echo 'selected';?>>2018</option>
		<option value="2017" <? if($year=='2017') echo 'selected';?>>2017</option>
		<option value="2016" <? if($year=='2016') echo 'selected';?>>2016</option>
		<option value="2015" <? if($year=='2015') echo 'selected';?>>2015</option>
	</select>
	<br>
Month:
	<select name="month" size="1">
		 <option value="">Select Month</option>
		 <option value="01" <? if($month=='01') echo 'selected';?>>January</option>
		 <option value="02" <? if($month=='02') echo 'selected';?>>February</option>
		 <option value="03" <? if($month=='03') echo 'selected';?>>March</option>
		 <option value="04" <? if($month=='04') echo 'selected';?>>April</option>
		 <option value="05" <? if($month=='05') echo 'selected';?>>May</option>
		 <option value="06" <? if($month=='06') echo 'selected';?>>June</option>
		 <option value="07" <? if($month=='07') echo 'selected';?>>July</option>
		 <option value="08" <? if($month=='08') echo 'selected';?>>August</option>
		 <option value="09" <? if($month=='09') echo 'selected';?>>September</option>
		 <option value="10" <? if($month=='10') echo 'selected';?>>October</option>
		 <option value="11" <? if($month=='11') echo 'selected';?>>November</option>
		 <option value="12" <? if($month=='12') echo 'selected';?>>December</option>
	</select>
</div>
Project :
<select name="exfor">
	<? 
	include("./includes/config.inc.php");
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	if($loginProject!="000")$sqlExt=" where pcode ='$loginProject' ";
	$sqlp = "SELECT `pcode`,pname from `project` $sqlExt ORDER by pcode ASC";
	//echo $sqlp;
	$sqlrunp= mysqli_query($db, $sqlp);
	 while($typel= mysqli_fetch_array($sqlrunp))
	{
	 echo "<option value='".$typel[pcode]."'";
	 if($exfor==$typel[pcode])  echo " SELECTED";
	 echo ">$typel[pcode]--$typel[pname]</option>  ";
	 }?>
 </select>
<!--  <input type="radio" name="w" value="5" <? if($w=='5') echo 'checked';?>>Salary Payment -->
 <!-- <input type="radio" name="w" value="51" <? if($w=='51') echo 'checked';?>> Monthly Wages-->
 <input type="hidden" name="w" value="7" <? if($w=='7') echo 'checked';?>><!--Wages Payment-->
 <input type="button" value="GO" onClick="payments.submit();">
</div>
<?
if($month){
if($w=='5' OR $w=='51'){
?>
<table width="100%" align="center" border="2" bordercolor="#999999" cellspacing="0" cellpadding="5" style="border-collapse:collapse">
 <tr bgcolor="#EEEEEE">
   <th valign="top">SL</th>
   <th valign="top">EmployeeID,<br> Designation</th>
   <th valign="top">Employee Name</th>
   <th valign="top" width="200">Remarks</th>  
 
   <th valign="top">Wages Amount</th>   
   <th valign="top">Monthly Adjustment</th>      
   <th valign="top">Current Payble</th> 
   <th valign="top">Pay to</th>    
 </tr>
 <tr><td colspan="12"></td></tr>
 	<input type="hidden" name="p" value="100">	
 <?
 //$year='2007';
include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
//$year=thisYear();
$sdate="$year-$month-01";
$daysofmonth = daysofmonth($sdate);
$edate="$year-$month-$daysofmonth";
	
if($w=='5'){
	$sqlp = "SELECT * from `employee` WHERE (location='$exfor' or empId in (SELECT empId from emptransfer where transferTo='$exfor')) AND designation!='70-01-000' AND empDate<='$year-$month-$daysofmonth' AND `status`<>'-2'".
" AND salaryType LIKE 'Salar%' group by empId order by designation ASC ";
// echo $sqlp;
}
else if($w=='51'){
	/*$sqlp = "SELECT * from `employee` WHERE location='$exfor' AND designation!='70-01-000' AND empDate<='$year-$month-01' AND status<>'-2' 
 AND salaryType LIKE 'Wages Monthly'  
 order by designation ASC ";*/
 $sqlp = "SELECT * from `employee` WHERE location='$exfor' AND designation!='70-01-000' AND empDate<='$year-$month-$daysofmonth' AND `status`<>'-2' 
 AND designation>='86-00-000' AND designation<'90-00-000'
 order by designation ASC "; 
}
// echo $sqlp;

$sqlrunp= mysqli_query($db, $sqlp);
$monthlyWork=monthlyWork($month,$year);
$b=1;
$totalAmount=0;
while($re=mysqli_fetch_array($sqlrunp))
{	
	if(empTransferRecord($re[empId],$sdate,true))
	{
	$transferArr=empTransferRecord($re[empId],$sdate);
// 		echo "<p>$transferArr[transferTo]</p>";
// // 	if($transferArr){
// // 		print_r($transferArr);
// // 		echo $re[empId];
// // 	}
	if($transferArr[transferTo]!=$exfor && !empty($transferArr[transferTo])){
// 		echo $re[empId]." >> ";
		continue;
	}
}
	
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
 $sqlf = " SELECT DISTINCT location from attendance where empId='$re[empId]' AND 
  edate BETWEEN '$sdate' AND '$edate' ORDER by location ASC ";
//echo $sqlf.'<br>';
$sqlQ= mysqli_query($db, $sqlf);
$rows=mysql_num_rows($sqlQ);

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
	$tp+=$pre[$i];
	$ta+=$absent[$i];
	$workday[$i]=emp_monthlyStay_project($re[empId],$month,$year,$rr[location]);
	echo "$loc[$i]-$pre[$i] P, $leave[$i] L, $holiday[$i] HP, <font class=out>$absent[$i] A</font>"; 
	if($withoutPay[$i]) echo ", <font class=out>$withoutPay[$i] NoPay</font>";echo "<br>";
	$i++;
}
$withoutPay_perdaysalary=$actualSalary/$daysofmonth;
$perdaysalary=$withoutPay_perdaysalary;
for($i=0;$i<sizeof($loc);$i++){
	$withoutPayAmount=round($withoutPay[$i]*$withoutPay_perdaysalary);
	$ss=round($perdaysalary*$workday[$i])-$withoutPayAmount;
	echo "<input type=hidden name=sal".$b.'['.$i."] value=$ss>";
	echo "<input type=hidden name=prr".$b.'['.$i."] value=$loc[$i]>";
     $withoutPayAmountTotal=$withoutPayAmountTotal+$withoutPayAmount; $withoutPayAmount=0;
	}//for
 }//if size of loc
//}
if($empStatus=='-1') echo '<font class=outi>Terminate on '.myDate($re[jobTer]).'</font>';
 ?>
    </td>
	
   <td valign="top" align="right"><? echo number_format($re[salary],2);?> </td>   
    <td valign="top" align="center" >
	  <? if($advanceSadjust){ echo '-'.number_format($advanceSadjust,2);?>
  	  <input type="hidden" name="adAmount<? echo $b;?>" value="<? echo round($advanceSadjust,2);?>">
	  <input type="hidden" name="reff<? echo $b;?>" value="<? echo $advanceSadjustRef;?>">	  
      <? }?>

	  <br>
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
     <? $incentive=incentive($re[empId],$year,$month); if($incentive)echo number_format($incentive,2);
	  if($withoutPayAmountTotal) echo '-'.$withoutPayAmountTotal; 
	  if($terAmount) echo "<br>-$terAmount";?>
    </td>  
   <td valign="top" align="right"><? 	
	$paid=currentPayble($re[empId],"$year-$month-01");
	
		
	$payable=$actualSalary-$paid-$withoutPayAmountTotal-$terAmount;
//	echo "$actualSalary-$paid-$withoutPayAmountTotal-$terAmount;";
	echo number_format($payable,2);
	$withoutPayAmountTotal=0;
	$terAmount=0;
	?> 
	<input type="hidden" name="currentPayable<? echo $b;?>" value="<? echo round($payable,2);?>" alt="">

	</td>  
	
	<td valign="top" align="center"><input type="checkbox" name="ch<? echo $b;?>" value="<? echo $re[empId];?>" <? if(${ch.$b}) echo 'checked';?> 
   <? 
   if($ta>0 || $payable==0 || $valid==0) echo ' disabled';?> onClick="if(this.checked==true){currentPayable<? echo $b;?>.alt='cal';p.value=p.value+'_<? echo $b;?>'} else {currentPayable<? echo $b;?>.alt=''}"></td>   	      
   
 </tr> 
 <?  if(${ch.$b}) $totalAmount+= $payable;

 $b++;
 $ta=0;
 }//if paid
 } //while?>
 <tr>
  <td colspan="7" align="right"> Total Amount:<input type="text" readonly="" name="total" style=" border:0;background: #FFFFCC;text-align:right"> </td>
  <td  align="center"><input type="button" value="calculate" name="calculate" onClick="calc(this.form);
  myOnclick('<? echo $exfor;?>','<? echo $month;?>',this.form);"></td>
 </tr>
  <input type="hidden" name="n" value="<? echo $b;?>">
  <tr>

	<input type="hidden" name="salaryPay" value="0"></td>
 </tr>
 </table>
 <script language="JavaScript1.1">
 function mygoto(a,b,c,d){
//location.href='./print/print_salary.php?exfor='+a+'&month='+b+'&total='+c; 
window.open('./print/print_salary.php?exfor='+a+'&month='+b+'&chk='+c+'&year='+d);
 }
 
 function myOnclick(a,b,which) {
//alert(a);
//alert(b);
//alert(which);
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
 <input type="button" value="Print" name="save"
  onClick="mygoto('<? echo $exfor;?>','<? echo $month;?>',payments.chk.value,'<? echo $year;?>');"><? }
 else {
	 
 
 include("./employee/empWagesReport.php");
 }
 } ?>
 </form>
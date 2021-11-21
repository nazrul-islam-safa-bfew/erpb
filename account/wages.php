<table   width="100%" align="center" border="2" bordercolor="#999999" cellspacing="0" cellpadding="5" style="border-collapse:collapse">
 <tr bgcolor="#EEEEEE">
   <th valign="top" rowspan="2" >SL</th>
   <th valign="top" width="100" rowspan="2" >EmployeeID,<br> Designation</th>
   <th valign="top" rowspan="2" >Employee Name</th>
   <th valign="top" rowspan="2" >Days <br>Present</th>
   <th valign="top" rowspan="2" >Total OT<br> Hours</th>      
   <th valign="top"  colspan="2"  >Salary</th>
   <th valign="top" rowspan="2" >OT Rate<br>per Hours</th>
   <th valign="top"  colspan="2" >Amount (Tk)</th>
   <th valign="top" rowspan="2" >Payable <br>Amount(Tk.)</th>
   <th valign="top" rowspan="2" >Pay to</th>
 </tr>
 <tr bgcolor="#EEEEEE">
   <th valign="top" >Basic</th>
   <th valign="top" >Allowance</th>
   <th valign="top" >Regular Time</th>
   <th valign="top" >Over Time</th>
 </tr> 
 <tr><td colspan="12"></td></tr>
  	<input type="hidden" name="p" value="100">
 <?
 
if(empty($_GET[exfor]))
{
	$exfor=$loginProject;
}
else
{
	$exfor=$_GET[exfor];
	$loginProject=$exfor;
}

	$fromD="$year-$month-01";
	$daysofmonth=daysofmonth($fromD);
	$toD="$year-$month-$daysofmonth";



include("./includes/config.inc.php");

$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
	
	 
	
$sqlp="SELECT DISTINCT attendance.empId,designation,name,salary,allowance FROM attendance,employee".
" WHERE employee.salaryType not like 'Salar%'".
" AND attendance.location='$exfor' AND attendance.action in ('P','HP') AND employee.designation>='71-00-000' AND employee.designation<='81-99-999'".
" AND attendance.edate between '$fromD' AND '$toD'".
" AND attendance.empId=employee.empId ORDER by employee.designation ASC";

// $sqlp="SELECT DISTINCT attendance.empId,designation,name,salary,allowance FROM attendance,employee".
// " WHERE employee.salaryType not like 'Salar%'".
// " AND attendance.location='$exfor' AND attendance.action in ('P','HP') AND employee.designation>='86-00-000' AND employee.designation<='99-00-000'".
// " AND attendance.edate between '$fromD' AND '$toD'".
// " AND attendance.empId=employee.empId ORDER by employee.designation ASC";
// echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
$b=1;
$totalAmount=0;





while($re=mysqli_fetch_array($sqlrunp)){
	//echo "HERE";
	//if(isPayable_wages($re[empId],$fromD,$toD)){
	if($b%2==0) $bg = "#E5E5E5";
	else $bg = "#D5D5D5";
?>
<tr>
   <td valign="top" align="center"><? echo $b;?></td>
   <td><? echo '<font class=out>'.empId($re[empId],$re[designation]).'</font>'; echo '<br>'.hrDesignation($re[designation]);?>
    <input type="hidden" name="designation<? echo $b;?>" value="<? echo $re[designation];?>">
   </td>
   <td align="left"><? echo $re[name];?></td> 
	<td align="center"> 
<? 
	//$wagesDate1=formatDate($wagesDate,'Y-m-d');
	$TotalPresentHr=TotalPresentHr($fromD,$toD,$re[empId],'H');
	
   $workedt=dailywork( $re[empId],$wagesDate1,'H',$loginProject);
   $worked=sec2hms($workedt/3600,$padHours=false);
   
   $overtimet=$workedt-(9*3600);
   if($overtimet<0) $overtimet=0;
   $overtime=sec2hms($overtimet/3600,$padHours=false);
   
   $idlet=(3600*8)-$workedt;
   
   if($idlet<0)  $idlet=0;
   $idle=sec2hms($idlet/3600,$padHours=false);

    $totalPresent = local_TotalPresentHr($fromD,$toD,$re[empId],'H',$loginProject); 
	echo $totalPresent;
	?>
    </td>
	<td align="right" ><? 
$presentTotal=0;
$overtimeTotal=0;
$workedTotal=0;
$idleTotal=0;

$sqlquery1="SELECT * FROM attendance".
" where attendance.location='$loginProject' ".
//"AND attendance.edate<='$todat'".
"AND attendance.edate BETWEEN '$fromD' AND '$toD'".
" AND action in('P','HP') AND attendance.empId= $re[empId]";
//echo $sqlquery1;




 $sql1= mysqli_query($db, $sqlquery1);
 while($re1=mysqli_fetch_array($sql1)){ 
   	$dailyworkBreakt=dailyworkBreak($re[empId],$re1[edate],'H',$loginProject);	
	$toDaypresent=toDaypresent($re[empId],$re1[edate],'H',$loginProject);	
    $toDaypresent=$toDaypresent-$dailyworkBreakt;

//echo "<br>toDaypresent:$toDaypresent<br>";

	$workt=dailywork($re[empId],$re1[edate],'H',$loginProject);
	
/*if(date('D',strtotime($re1[edate]))=='Fri')
 $overtimet = $toDaypresent-(4*3600);
else */
	$overtimet=$toDaypresent-(8*3600);

//	$overtimet = $toDaypresent-8*3600;
	if($overtimet<0) $overtimet=0;
		$idlet=$toDaypresent-$workt;
	if($idlet<0)$idlet=0;
	
	$presentTotal=$presentTotal+$toDaypresent;   
	$overtimeTotal=$overtimeTotal+$overtimet;
	$workedTotal=$workedTotal+$workt;
	$idleTotal=$idleTotal+$idlet; 
	
	//echo "<br>date:$re1[edate]= Present:$toDaypresent--worked:$workt--overtime:$overtimet--idle:$idlet***presentTotal:$presentTotal **<br>";
	
	$toDaypresent=0;
	$overtimet=0;
	$workt=0;
	$idlet=0;

}

?>
<?
	$presentTotal=sec2hms($presentTotal/3600,$padHours=false);
	$overtimeTotal1=sec2hms($overtimeTotal/3600,$padHours=false);
	$workedTotal=sec2hms($workedTotal/3600,$padHours=false);
	$idleTotal=sec2hms($idleTotal/3600,$padHours=false);
	//echo "<br>presentTotal:$presentTotal--idleTotal:$idleTotal<br>";
?>
<? echo $overtimeTotal1; ?>
	</td>
   <td align="right"><? echo number_format($re[salary],2);?></td> 
   <td align="right"><? echo number_format($re[allowance],2);?></td> 
   <td align="right"> <? echo number_format(otRate($re[salary],$fromD),2);?></td>   
   <td align="right">
  <?
		$atAmount=normalDayAmount($re[salary],$re[allowance],$fromD,$totalPresent);
		echo number_format($atAmount,2);
  ?>
  </td>

  <td align="right">
		<? 
	$desig=explode("-",$re[designation]);	
			if($desig[0]!='90' && $desig[0]!='91' && $desig[0]!='87'){
				$otAmount=otRate($re[salary],$fromD)*($overtimeTotal/3600);
				echo number_format($otAmount, 2);
			}else{
				$otAmount=0;
				echo number_format($otAmount, 2);
			}
		?>
	</td>

   <td align="right"> 
   <?
	  $amount=$otAmount+$atAmount;
	  $paid=currentWPayble($re[empId],"$year-$month-01",$loginProject);
	  $payable=$amount-$paid;
	  echo number_format($payable,2);
	  //echo "**$payable= $amount-$paid;**";
	?>
	 <input type="hidden" name="currentPayable<? echo $b;?>" value="<? echo round($payable,2);?>" alt="">
   </td>   
   <td valign="top" align="center">
   <? if($payable<=0){ echo " Paid "; }else{?>
   <input type="checkbox" name="ch<? echo $b;?>"    value="<? echo $re[empId];?>" <? if(${ch.$b}) echo 'checked';?> 
onClick="if(this.checked==true){currentPayable<? echo $b;?>.alt='cal';p.value=p.value+'_<? echo $b;?>'} else {currentPayable<? echo $b;?>.alt=''}" onchange="disableSave(this.form);"></td>   	      
 <? }//else?>
 </tr> 
 <? 

 if(${ch.$b}) $totalAmount+= $amount; $amount=0;

 $b++;
 $ta=0;
 //}
 } //while?>
 <tr>
  <td  align="center"><input type="button" value="calculate" name="calculate" onClick="calc(this.form);
  myOnclick('<? echo $exfor;?>','<? echo $month;?>',this.form);twoDigitConversation(this.form,'total');"></td>
   <td colspan="11" align="right"> Total Amount: <input type="text" readonly="" name="total" id="total" value='0' style=" border:0;background: #FFFFCC;text-align:right"></td>
 </tr>
  <tr>
    <td colspan="13" align="center"><input type="submit" value="Save" name="save" disabled="disabled" onClick="payments.wagesPay.value=1;payments.submit();">
		<input type="hidden" name="wagesPay" value="0">
    <input type="hidden" name="n" value="<? echo $b;?>">
	</td>
 </tr>

 </table>
  <script language="JavaScript1.1">
 function mygoto(a,b,c,d){
//location.href='./print/print_salary.php?exfor='+a+'&month='+b+'&total='+c; 
window.open('./print/print_wages.php?exfor='+a+'&month='+b+'&chk='+c+'&year='+d);
 }
 
 function myOnclick(a,b,which){
var out='';

for (i=0;i<which.length;i++) {
var tempobj=which.elements[i];
//alert(tempobj.type);
if (tempobj.type=="checkbox"){
 if(tempobj.checked==true) out+='_'+tempobj.value;
}

}
which.chk.value=out;
//alert(out);
//window.open('./print/print_salary.php?exfor='+a+'&month='+b+'&total='+out);
}
 </script>
<input type="hidden" name="chk">

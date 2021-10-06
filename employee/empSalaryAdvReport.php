<? 
if($mdsalaryPayment){
include("./includes/config.inc.php");

$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
for($i=1;$i<$n;$i++){
	if(${approveAmount.$i}>0){
		$sqlp = "INSERT INTO empsalaryad(id,empId,designation,amount,pmonth,paymentSL,pdate,approvedDate,account,status,approvedby)".
		" VALUES('','${empId.$i}','${designation.$i}','${approveAmount.$i}','${pmonth.$i}','','','$todat','','1','1')";
		//echo '<br>'.$sqlp.'<br>';
		$sqlq=mysqli_query($db, $sqlp);

	${approveAmount.$i}=0;
	${pmonth.$i}=0;	
	}//${approveAmount.$i}
}
$mdsalaryPayment=0;
//$mdsalaryPayment=0;
}//mdsalaryPayment
?>
<? if($mdsalaryPayment==0){?>
<form name="mdsalaryad" action="./index.php?keyword=mdsalary+advance" method="post">
<table   width="95%" align="center" border="3" bordercolor="#999999" cellspacing="0" cellpadding="5" style="border-collapse:collapse">
 <tr bgcolor="#EEEEEE">
   <th valign="top" >SL</th>
   <th valign="top"  width="100">EmployeeID,<br> Designation</th>
   <th valign="top" width="20%">Employee Name</th>
   <th valign="top" >Working<br> in BFEW</th>  
   <th valign="top" width="10%" >Payment Date</th>
   <th valign="top" >Salary Amount</th>   
   <th valign="top" >Advance paid</th>   
   <th valign="top" >Advance Remain</th>      
   <th valign="top" width="4%">Payback Period (Months) </th> 
 </tr>
 <?
include("./includes/config.inc.php");

$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
if($loginProject){
$sqlp = "SELECT empsalaryad.*,employee.name,employee.salary,employee.empDate from `empsalaryad`,`employee` WHERE".
" empsalaryad.empId=employee.empId AND empsalaryad.status=2 AND employee.designation!='70-01-000' order by designation ASC ";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

$i=1;
$totalAmount=0;
while($re=mysqli_fetch_array($sqlrunp)){

?>
 <tr <? if($i%2==0) echo 'bgcolor=#FFFFEE';?> >
   <td valign="top" align="center"><? echo $i;?>
   <input type="hidden" name="empId<? echo $i;?>" value="<? echo $re[empId];?>">
   <input type="hidden" name="designation<? echo $i;?>" value="<? echo $re[designation];?>">   </td>
   <td valign="top" ><? echo '<font class=out>'.empId($re[empId],$re[designation]).'</font>';
    echo '<br>'.hrDesignation($re[designation]);?>   </td>
   <td valign="top" align="right" width="150"><? echo $re[name];?> </td>   
   <td valign="top" align="right"><? $work=workYear($re[empDate]); echo $work.' years'; ?></td>
   <td valign="top" align="center"><? echo $re[pdate];?></td>
   <td valign="top" align="right"><? echo number_format($re[salary],2);?> </td>   
   <td valign="top" align="right"><? echo number_format($re[amount],2);?></td>  
   <td valign="top" align="right"><? $advancePaid=remainAdv($re[empId]); echo number_format($advancePaid,2);?></td>      
   <td valign="top" align="right"><? echo $re[pmonth]; ?></td>   
 </tr> 
 <? 
 $totalAmount+= ${approveAmount.$i};

 $i++;} //while?>
 <? }?>
 </table>
 <input type="hidden" name="n" value="<? echo $i;?>">
</form> 
Note:<br>
<ul>			
<li>No Advance is allowed for employees working less than 1 year.</li>			
<li>For All Employees excluding Directors:</li>			
<li>For the employees working 1 to 3 years in BFEW the Advance Amount Limit equivalent to 1 months salary and payable in 3 months.</li>
<li>For the employees working 4 to 6 years in BFEW the Advance Amount Limit equivalent to 3 months salary and payable in 6 months.</li>
<li>For the employees working above 7 years in BFEW the Advance Amount Limit equivalent to 4 months salary and payable in 8 months.</li>			
<li>Managers will approve Advance Amount to the executives working under them.</li>
<li>Directors will approve Advance Amount to the Managers working under them.</li>
<li>Managing Director will appove Advance Amount and Repayment duration (months) for the Directors.</li>
<li>Only Managing Director can approve any deviation in Advance Limit and payback period to any employee.</li>			
<li>No Adavnced will be allowed untill complete the repayment of current advance.</li>
<li>Employee will get 1 months gress period.</li>
</ul>
<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
<? }?>
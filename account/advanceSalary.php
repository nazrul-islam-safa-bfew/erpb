<table width="800" align="center" border="2" bordercolor="#999999" cellspacing="0" cellpadding="5" style="border-collapse:collapse">
 <tr bgcolor="#EEEEEE">
   <th valign="top" >SL</th>
   <th valign="top"  width="200">EmployeeID,<br> Designation</th>
   <th valign="top" >Employee Name</th>
   <th valign="top" >Payback in months </th> 
   <th valign="top" >Approved Amount</th>    
   <th valign="top" >Approved by</th>      
 </tr>
 <?
include("./includes/config.inc.php");

$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
if($loginProject){
	$sqlp = "SELECT * from `empsalaryad` WHERE status='1' order by designation ASC ";
	 // echo $sqlp;
	$sqlrunp= mysqli_query($db, $sqlp);
	//$monthlyWork=monthlyWork($month);
	$i=1;
	$totalAmount=0;
while($re=mysqli_fetch_array($sqlrunp)){

?>
 <tr <? if($i%2==0) echo 'bgcolor=#FFFFEE';?> >
   <td valign="top" align="center">
     <?php if($re[amount]>0){ ?><input type="checkbox" name="ch<? echo $i;?>" value="<? echo $re[id];?>" <? if(${ch.$i}) echo 'checked';?>
   onClick="if(this.checked==true){approvedAmount<? echo $i;?>.alt='cal'} else {approvedAmount<? echo $i;?>.alt=''}"
   ><?php } ?>
     <? echo $i;?></td>
   <td valign="top" ><? echo '<font class=out>'.empId($re[empId],$re[designation]).'</font>';
    echo '<br>'.hrDesignation($re[designation]);?> 
   </td>
	 <input type="hidden" name="employee<? echo $i;?>" value="<?php echo $re[empId]; ?>">
   <td valign="top" ><? echo empName($re[empId]);?> </td>   
   <td valign="top" align="right"><? echo $re[pmonth];?></td>     
   <td valign="top" align="right"><? echo number_format($re[amount],2);?>
   <input type="hidden" name="approvedAmount<? echo $i;?>" alt="" value="<? echo $re[amount];?>">
   </td>     
   <td valign="top" align="center"><? echo empName($re[approvedby]);?> <br>at <? echo myDate($re[approvedDate]);?></td>   	      
 </tr> 
 <? 
 if(${ch.$i}) $totalAmount+= $re[amount];

 $i++;} //while?>
 <tr>
  <td colspan="5" align="right"> Total Amount:<input type="text" readonly="" name="total" id="total" style=" border:0;background: #FFFFCC;text-align:right"> </td>
  <td  align="center"><input type="button" value="calculate" name="calculate" onClick="calc(this.form);twoDigitConversation(this.form,'total');"></td>
 </tr>
  	<input type="hidden" name="n" value="<? echo $i;?>">
  	<input type="hidden" name="paidAmount" value="<? echo $totalAmount;?>">
  <tr>
    <td colspan="10" align="center"><input type="submit" value="Paid" name="adsalaryPayment1" onClick="if(checkrequired(payments)){ payments.adsalaryPayment.value=1;payments.submit();}">
	<input type="hidden" name="adsalaryPayment" value="0"></td> 
 </tr>
 <? }?>
 </table>
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

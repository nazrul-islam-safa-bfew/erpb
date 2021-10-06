<table   width="800" align="center" border="2" bordercolor="#999999" cellspacing="0" cellpadding="5" style="border-collapse:collapse">
 <tr bgcolor="#EEEEEE">
   <th valign="top" >SL</th>
   <th valign="top"  width="200">EmployeeID,<br> Designation</th>
   <th valign="top" >Employee Name</th>
   <th valign="top" >Working in BFEW</th>  
   <th valign="top" >Salary Amount</th>   
   <th valign="top" >Remaining Advance payable</th>   
   <th valign="top" >Advance Limit</th>      
   <th valign="top" >Payback Period (Max.) </th> 
   <th valign="top" >Approved Amount</th>    
   <th valign="top" >Approved by</th>      
 </tr>
 <?
include("./includes/config.inc.php");

$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
if($loginProject){
$sqlp = "SELECT * from `employee` WHERE location='$loginProject' AND status='1' order by designation ASC ";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
$monthlyWork=monthlyWork($month);
$i=1;
$totalAmount=0;
while($re=mysqli_fetch_array($sqlrunp)){

?>
 <tr <? if($i%2==0) echo 'bgcolor=#FFFFEE';?> >
   <td valign="top" align="center"><input type="checkbox" name="ch<? echo $i;?>" value="<? echo $re[empId];?>" <? if(${ch.$i}) echo 'checked';?>><? echo $i;?></td>
   <td valign="top" ><? echo '<font class=out>'.empId($re[empId],$re[designation]).'</font>';
    echo '<br>'.hrDesignation($re[designation]);?> 
   </td>
   <td valign="top" align="right"><? echo $re[name];?> </td>   
   <td valign="top" align="left" width="150"><? $work=workYear($re[empDate]); echo $work.' years'; ?></td>
   <td valign="top" align="right"><? echo number_format($re[salary],2);?> </td>   
   <td valign="top" align="right"><? echo number_format($re[salary],2);?> </td>   
   <td valign="top" align="right"><? if($work<=3) echo number_format($re[salary],2);
                     else if($work>=4 AND $work<=6) echo number_format($re[salary]*3,2);
                     else if($work>=7) echo number_format($re[salary]*4,2);					 
     ?></td>

   <td valign="top" align="right"><? if($work<=3) echo '3 months';
                     else if($work>=4 AND $work<=6) echo '6 months';
                     else if($work>=7) echo '8 months';
     ?></td>

   <td valign="top" align="right"><input type="text" name="approveAmount<? echo $i;?>" size="10" width="10"> </td>     
   <td valign="top" align="center"></td>   	      
 </tr> 
 <? 
 if(${ch.$i}) $totalAmount+= $currentPayble;

 $i++;} //while?>
 <tr>
  <td colspan="9" align="right"> Total Amount:<input type="text" readonly="" name="total" style=" border:0;background: #FFFFCC;text-align:right"></td>
  <td  align="center"><input type="button" value="calculate" name="calculate" onClick="calc(this.form);"></td>
 </tr>
  <input type="hidden" name="n" value="<? echo $i;?>">
  <tr>
    <td colspan="10" align="center"><input type="submit" value="Save" name="salaryPayment"></td>
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

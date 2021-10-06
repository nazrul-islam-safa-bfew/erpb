<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
<div class="dialog">
<form name="gl" action="./index.php?keyword=htrial+balance" method="post">

<table  width="600" align="center" border="0" class="blue" >
 <tr bgcolor="#CCCCFF">
 <td align="right" valign="top" height="30" colspan="4"><font class='englishheadblack'>trial balance</font></td>
</tr>
 <tr>
 	<SCRIPT LANGUAGE="JavaScript">
	var now = new Date();
	var cal = new CalendarPopup("testdiv1");
    	cal.showNavigationDropdowns();
		cal.setWeekStartDay(6); // week is Monday - Sunday
		//cal.addDisabledDates(null,formatDate(now,"yyyy-MM-dd"));
		cal.setCssPrefix("TEST");
		cal.offsetX = 0;
		cal.offsetY = 0;

	</SCRIPT>
    <td>From </td>
      <td><input type="text" maxlength="10" name="fromDate" value="<? echo $fromDate;?>" > <a id="anchor" href="#"
   onClick="cal.select(document.forms['gl'].fromDate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a>
      </td>
    <td>To </td>
      <td><input type="text" maxlength="10" name="toDate" value="<? echo $toDate;?>" > <a id="anchor2" href="#"
   onClick="cal.select(document.forms['gl'].toDate,'anchor2','dd/MM/yyyy'); return false;"
   name="anchor2" ><img src="./images/b_calendar.png" alt="calender" border="0"></a>
      </td>
 </tr>
  <tr>
	   <td >Project: </td>
	   <td colspan="3">
 <select name="pcode" size="1">
	  <option value="0">Select Project</option>  
	  <option value="1">ALL BFEW</option>  	  
	<? 
	include("config.inc.php");
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
		
	$sqlp = "SELECT * from `project` order by pcode ASC";
	//echo $sqlp;
	$sqlrunp= mysqli_query($db, $sqlp);
	
	 while($typel= mysqli_fetch_array($sqlrunp))
	{
	 echo "<option value='".$typel[pcode]."'";
	 if($pcode==$typel[pcode]) echo "SELECTED";
	 echo ">$typel[pcode]--$typel[pname]</option>  ";
	 }
	 ?>
	</select>
	</td>
	</tr>

 <tr><td colspan="4" align="center"><input type="button" name="go" value="Go" onClick="gl.submit();"></td></tr>
</table>

<input type="hidden" name="ck" value="1">
</form>
</div>
<br>
<br>
<br>
<? if($pcode=='1') include('htrialBalanceAll.php');
else {?>

<?  if($fromDate AND $toDate){?>
<div class="dialog">
<table  width="720" align="left" border="2" bordercolor="#CCCCFF" cellpadding="5" cellspacing="0"  style="border-collapse:collapse;font-size: 10px;" >
 <tr bgcolor="#EEEEFF">
   <th align="center" valign="top" width="80">Account ID</th>   
   <th align="center" valign="top" width="180">Description</th>  
   <th align="center" valign="top" width="100">Account Type</th>       
   <th align="right" valign="top" width="100">Debit Amount</th>   
   <th align="right" valign="top" width="100">Credit Amount</th> 
 </tr>
 <? 
 $fromDate=formatDate($fromDate,'Y-m-j');
 $toDate=formatDate($toDate,'Y-m-j');  
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
 ?>
 
<?  $sql="select * from `accounts` WHERE  accountType IN('10') ORDER by accountID ASC";
$i=1;
//echo $sql;
$sqlq=mysqli_query($db, $sql);
while($re=mysqli_fetch_array($sqlq)){
if($re[accountID]=='2401000'){
  $mat_totalPaidAmount =mat_vanPayment($fromDate,$toDate,$pcode);
  $mat_TotalReceive= mat_po_Receive($fromDate,$toDate,$pcode);  
  $balance=$mat_TotalReceive-$mat_totalPaidAmount;
//  echo "<br>**$balance=$mat_TotalReceive-$mat_totalPaidAmount;**<br>";
  }//2401000
else if($re[accountID]=='2402000'){
/*   $eq_totalPaidAmount =eq_vanPayment($fromDate,$toDate,$pcode);
   $eq_TotalReceive=total_eq_issueAmount_date($pcode, $fromDate,$toDate);  
   $balance=$eq_TotalReceive-$eq_totalPaidAmount;
   */
  $balance= eqCurrentPayable($pcode,$fromDate,$toDate);
 }
else if($re[accountID]=='2403000'){
   $sub_totalPaidAmount =sub_vanPayment($fromDate,$toDate,$pcode);
   $sub_TotalReceive=sub_po_Receive($fromDate,$toDate,$pcode);  
   $balance=$sub_TotalReceive-$sub_totalPaidAmount;
   //echo "**$sub_TotalReceive-$sub_totalPaidAmount;**";
 } 
 else if($re[accountID]=='2404000'){
 $balance=wagesPayable($pcode,$fromDate,$toDate);
 /*
  $temp=getMonth_sd_ed( $fromDate,$toDate);
  $si=sizeof($temp);
	  for($i=0;$i<=$si;$i++){
	  $fd=$temp[$i][0];
	  $td=$temp[$i][1];    
	  $wages_TotalReceive+=wagesAmount_date($pcode,$fd,$td);
	  }
     $wages_totalPaidAmount=direct_total_wagesPaid_date($pcode,$fromDate,$toDate);
 
	$balance=$wages_TotalReceive-$wages_totalPaidAmount;
	//echo "**$wages_TotalReceive-$wages_totalPaidAmount;**";
	*/
	
 }
 else if($re[accountID]=='2405000'){
 
  //$balance=salaryPayable($pcode,$fromDate,$toDate);
/*  
  $temp=getMonth_sd_ed( $fromDate,$toDate);
 // print_r($temp);
  $si=sizeof($temp);
	  for($i=0;$i<=$si;$i++){
	  $fd=$temp[$i][0];
	  $td=$temp[$i][1];    
	  //$salary_TotalReceive+=total_salaryReceived_date($pcode,$fd,$td);
	  $salary_TotalReceive+=wagesAmount_date($pcode,$fd,$td);
	  }
     $salary_totalPaidAmount=total_salaryPaid_date($pcode,$fromDate,$toDate);
	$balance=$salary_TotalReceive-$salary_totalPaidAmount;
	echo "**$salary_TotalReceive-$salary_totalPaidAmount;**";
	*/
 }

  
  $bg=" bgcolor=#F8F8F8";
  ?>
<tr <? if($i%2==0) echo $bg;?>>
<td><? echo "$re[accountID]-$pcode";?></td>
 <td><? echo accountName($re[accountID]);?></td>
  <td><? echo viewAccountType($re[accountID]);?></td> 
	 <?
	if($balance<0){ $balance=abs($balance); ?>
	<td align="right">
	<? echo number_format($balance,2); $drAmount+=$balance; $balance=0;?></td>
	<td  align='right' ></td>
	<?  }?>
	<? if($balance>0){?>
	<td> </td>
	<td  align='right' ><? echo number_format($balance,2); $crAmount+=$balance; $balance=0;?></td>
	<? }?>
</tr>
<? $i++;}//while re?>
<?  $sql="select * from `accounts` WHERE  accountType IN('5','8') ORDER by accountID ASC";
$i=1;
//echo $sql;
$sqlq=mysqli_query($db, $sql);
while($re=mysqli_fetch_array($sqlq)){
if($re[accountID]=='3301000' AND $pcode=='004'){
  $total_equipment_value =total_equipment_value($fromDate,$toDate,$pcode);
  $balance=$total_equipment_value;
  }//3301000
if($re[accountID]=='3601000' AND $pcode=='000'){
  $total_furniture_value =total_furniture_value($fromDate,$toDate,$pcode);
  $balance=$total_furniture_value;
  }//3301000
if($re[accountID]=='3900000' AND $pcode=='000'){
  $total_tools_value =total_tools_value($fromDate,$toDate,$pcode);
  $balance=$total_tools_value;
  }//3301000
if($re[accountID]=='3804000'){
  $total_officetools_value =total_officetools_value($fromDate,$toDate,$pcode);
  $balance=$total_officetools_value;
  }//3301000  
  
  $bg=" bgcolor=#F8F8F8";
  ?>
<tr <? if($i%2==0) echo $bg;?>>
<td><? echo "$re[accountID]-$pcode";?></td>
 <td><? echo accountName($re[accountID]);?></td>
  <td><? echo viewAccountType($re[accountID]);?></td> 
	 <?
	if($balance<0){ $balance=abs($balance); ?>
	<td align="right">
	<? echo number_format($balance,2); $drAmount+=$balance; $balance=0;?></td>
	<td  align='right' ></td>
	<?  }?>
	<? if($balance>0){?>
	<td> </td>
	<td  align='right' ><? echo number_format($balance,2); $crAmount+=$balance; $balance=0;?></td>
	<? }?>
</tr>
<? $i++;
}//while re?>

<? 
  $balance1=totalMaterialReceive($fromDate,$toDate,$pcode);
  $balance2=total_mat_issueAmount_date($pcode, $fromDate,$toDate);
  $balance=$balance1-$balance2;

  ?>
<tr  >
<td><? echo "4701000-$pcode";?></td>
 <td><? echo accountName('4701000');?></td>
  <td><? echo viewAccountType('4701000');?></td> 
<? if($balance>0){?>
	<td align="right"> 	
	<? echo number_format($balance,2); $drAmount+=$balance; $balance=0;?></td>
	<td  align='right' ></td>
	<?  }?>
	<? if($balance<0){$balance=abs($balance);?>
	<td> </td>
	<td  align='right' ><? echo number_format($balance,2); $crAmount+=$balance; $balance=0;?></td>
	<? }?>
</tr>


<? 

  $balance=current_Inventory_intransit($fromDate,$toDate,$pcode);

  ?>
<tr  >
<td><? echo "4800000-$pcode";?></td>
 <td><? echo accountName('4800000');?></td>
  <td><? echo viewAccountType('4800000');?></td> 
 <? if($balance>0){?>
 	<td align="right">
 <? echo number_format($balance,2); $drAmount+=$balance; $balance=0;?></td>
	<td  align='right' ></td>
	<?  }?>
	<? if($balance<0){$balance=abs($balance);?>
	<td> </td>
	<td  align='right' ><? echo number_format($balance,2); $crAmount+=$balance; $balance=0;?></td>
	<? }?></tr>

<?  $sql="select * from `accounts` WHERE  accountType IN('1') ORDER by accountID ASC";
$i=1;
//echo $sql;
$sqlq=mysqli_query($db, $sql);
while($re=mysqli_fetch_array($sqlq)){
if($re[accountID]=='5000000') $balance=accountReceivable($pcode,$fromDate,$toDate);
  $bg=" bgcolor=#F8F8F8";
  ?>
<tr <? if($i%2==0) echo $bg;?>>
<td><? echo "$re[accountID]-$pcode";?></td>
 <td><? echo accountName($re[accountID]);?></td>
  <td><? echo viewAccountType($re[accountID]);?></td> 
 <?	if($balance>0){?>
	<td align="right">	
	<? echo number_format($balance,2); $drAmount+=$balance; $balance=0;?></td>
	<td  align='right' ></td>
	<?  }?>
	<? if($balance<0){$balance=abs($balance);?>
	<td> </td>
	<td  align='right' ><? echo number_format($balance,2); $crAmount+=$balance; $balance=0;?></td>
	<? }?></tr>

<? $i++;}//while re?>

<?  $sql="select * from `accounts` WHERE  accountType IN('4') ORDER by accountID ASC";
$i=1;
//echo $sql;
$sqlq=mysqli_query($db, $sql);
while($re=mysqli_fetch_array($sqlq)){
  $bg=" bgcolor=#F8F8F8";
  ?>
  
<? if($ree[accountID]=='5201000'){;}?>  
<tr <? if($i%2==0) echo $bg;?>>
<td><? echo "$re[accountID]-$pcode";?></td>
 <td><? echo accountName($re[accountID]);?></td>
  <td><? echo viewAccountType($re[accountID]);?></td> 
 <? if($balance>0){ ?>
	<td align="right">
	<? echo number_format($balance,2); $drAmount+=$balance; $balance=0;?></td>
	<td  align='right' ></td>
	<?  }?>
	<? if($balance<0){$balance=abs($balance);?>
	<td> </td>
	<td  align='right' ><? echo number_format($balance,2); $crAmount+=$balance; $balance=0;?></td>
	<? }?></tr>
<? $i++;}//while re?>

<?  $sql="select * from `accounts` WHERE  accountType IN('0','3') ORDER by accountID ASC";
$i=1;
//echo $sql;
$sqlq=mysqli_query($db, $sql);
while($ree=mysqli_fetch_array($sqlq)){

	if($ree[accountID]=='5501000'){	$balance=balance_hcash($pcode, $fromDate,$toDate);	
	}
	elseif($ree[accountID]=='5502000'){	$balance=cashonHand($pcode,$fromDate,$toDate,'2');	}
	else{$balance=balance_bank($pcode,$ree[accountID],$fromDate,$toDate);}
	//echo "balance=======$balance+++++++++++<br>";
	?>
<tr <? if($i%2==0) echo $bg;?>>
	<td><? if($ree[accountID]=='5502000') echo "$ree[accountID]-$pcode"; else echo "$ree[accountID]";?></td>
	<td><? echo accountName($ree[accountID]);?></td>
	<td><? echo viewAccountType($ree[accountID]);?></td> 
  <?  if($balance>0){  ?>	
	<td  align='right' ><? echo number_format($balance,2); $drAmount+=$balance; $balance=0;?></td>
	<td align="right"></td>
	  <? }//balance>0
	  else {  $balance=abs($balance);?>
	<td align="right"></td>
	<td  align='right' ><? echo number_format($balance,2); $crAmount+=$balance; $balance=0;?></td>	  
	  <? }?>


</tr>
 <? $i++;}//while?>
<? 

$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

  $sql="select * from `accounts` WHERE  accountType='21' ORDER by accountID ASC";

//echo $sql;
  $sqlQ=mysqli_query($db, $sql);
  $r=mysql_num_rows($sqlQ);
  while($re=mysqli_fetch_array($sqlQ)){

if($re[accountID]=='6100000'){ 
	$balance=completedAmount($pcode,$fromDate,$toDate);
}  
//echo $sql2;
//echo "$re[accountID]<br>";
?>

<? 
//if($balance){
$bg=" bgcolor=#F8F8F8";
?>
<tr <? if($i%2==0) echo $bg;?>>
 <td><? echo "$re[accountID]-$pcode";?></td>
 <td><? echo accountName($re[accountID]);?></td>
 <td><? echo viewAccountType($re[accountID]);?></td> 
 <?	if($balance<0){?>
	<td align="right">	
	<? $balance=abs($balance); echo number_format($balance,2); $drAmount+=$balance; $balance=0;?></td>
	<td  align='right' ></td>
	<?  }?>
	<? if($balance>0){?>
	<td> </td>
	<td  align='right' ><? echo number_format($balance,2); $crAmount+=$balance; $balance=0;?></td>
	<? }?>
</tr>

<?  
$amountDRt2=0; $amountCRt2=0;
 $i++;
 //}//balance
  }//while
  
?>
 
<?  $sql="select * from `accounts` WHERE  accountType='23' ORDER by accountID ASC";
$i=1;
//echo $sql;
  $sqlQ=mysqli_query($db, $sql);
  $r=mysql_num_rows($sqlQ);
  while($re=mysqli_fetch_array($sqlQ)){
if($re[accountID]=='6801000')  
  {$balance=total_mat_directissueAmount_date($pcode, $fromDate,$toDate);
	$matDirectTotalCost=$balance;
  }
else if($re[accountID]=='6802000') { 
    $balance=total_eq_direct_issueAmount_date($pcode, $fromDate,$toDate);
	$eqDirectTotalCost=$balance;
	
	}
	
else if($re[accountID]=='6803000'){
	$balance=sub_po_directReceive($pcode,$fromDate,$toDate); 
	$subDirectTotalCost=$balance;
	
}  
else if($re[accountID]=='6804000'){
	$balance=0;

 $balance=wagesCostofsales($pcode,$fromDate,$toDate);
	/*$temp=getMonth_sd_ed( $fromDate,$toDate);
	$si=sizeof($temp);
	for($i=1;$i<=$si;$i++){
		$fd=$temp[$i][0];
		$td=$temp[$i][1];    
		//	  $balance+=wagesAmount_date($pcode,$fd,$td);
		$balance+=directwagesAmount_date($pcode,$fd,$td);
	}
	$wagesDirectTotalCost=$balance;
	*/
}  
$bg=" bgcolor=#F8F8F8";
?>
<tr <? if($i%2==0) echo $bg;?>>
<td><? echo "$re[accountID]-$pcode";?></td>
 <td><? echo accountName($re[accountID]);?></td>
  <td><? echo viewAccountType($re[accountID]);?></td> 
	 <?	if($balance>0){ ?>
	<td align="right">
	<? echo number_format($balance,2); $drAmount+=$balance; $balance=0;?></td>
	<td  align='right' ></td>
	<?  }?>
	<? if($balance<0){$balance=abs($balance);?>
	<td> </td>
	<td  align='right' ><? echo number_format($balance,2); $crAmount+=$balance; $balance=0;?></td>
	<? }?>
</tr>
<? $i++;}//while?>
<? 
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

  $sql="select * from `accounts` WHERE  accountType='24' ORDER by accountID ASC";

//echo $sql;
  $sqlQ=mysqli_query($db, $sql);
  $r=mysql_num_rows($sqlQ);
  while($re=mysqli_fetch_array($sqlQ)){

if($re[accountID]=='6901000'){ 
	$balance=total_salaryAmount_date($pcode, $fromDate,$toDate);
}  
elseif($re[accountID]=='6902000'){ 
	$balance=$wages_TotalReceive-$wagesDirectTotalCost;
	//echo "690200=$balance";
 }  
elseif($re[accountID]=='6902010'){ 
  //$balance=$mat_TotalReceive-$matDirectTotalCost;
  $balance=total_mat_indirectissueAmount_date($pcode, $fromDate,$toDate);
	//echo "690210=$balance";  
  //echo "**$matTotalCost-$matDirectTotalCost***<br>";
 }  
 elseif($re[accountID]=='6903010'){
	//echo "690310=$balance"; 
  //$balance=$eq_TotalReceive-$eqDirectTotalCost;
 // echo "**$eqTotalCost-$eqDirectTotalCost***<br>";
 $balance=0;
  }
 elseif($re[accountID]=='6903000'){
 //	echo "690300=$balance";
 // $balance=$sub_TotalReceive-$subDirectTotalCost;
 
$sql1="SELECT SUM(qty*rate) as amount,posl,edate from subut,iow WHERE 
 subut.edate BETWEEN '$fromDate' AND '$toDate' AND iow.iowId=subut.iow  AND pcode='$pcode' 
 AND iow.iowType='2' GROUP by subut.edate,posl Order by subut.edate ASC";
//echo $sql1;
$sqlq1=mysqli_query($db, $sql1);
$i=0;
while($st=mysqli_fetch_array($sqlq1)){
$sub_TotalReceive_indirect+=$st[amount];
}

  $balance=$sub_TotalReceive_indirect;
  }
else {  
$balance=total_exAmount_date($pcode, $fromDate,$toDate,$re[accountID]);
}  
//echo $sql2;
//echo "$re[accountID]<br>";
?>

<? 
//if($balance){
$bg=" bgcolor=#F8F8F8";
?>
<tr <? if($i%2==0) echo $bg;?>>
 <td><? echo "$re[accountID]-$pcode";?></td>
 <td><? echo accountName($re[accountID]);?></td>
 <td><? echo viewAccountType($re[accountID]);?></td> 
 <?	if($balance>0){?>
	<td align="right">
	<?  echo number_format($balance,2); $drAmount+=$balance; $balance=0;?></td>
	<td  align='right' ></td>
	<?  }?>
	<? if($balance<0){$balance=abs($balance);?>
	<td> </td>
	<td  align='right' ><? echo number_format($balance,2); $crAmount+=$balance; $balance=0;?></td>
	<? }?>
</tr>

<?  
$amountDRt2=0; $amountCRt2=0;
 $i++;
 //}//balance
  }//while
?>

<tr><td colspan='8' height='3' bgcolor='#FFFFFF'></td></tr>
<tr><td colspan='8' height='1' bgcolor='#CCCCFF'></td></tr>
<tr><td colspan='8' height='3' bgcolor='#FFFFFF'></td></tr>
<tr><td colspan='8' height='1' bgcolor='#CCCCFF'></td></tr>

<tr bgcolor="#B8F3A9">
 <td colspan="2"></td>
 <td align="right"></td>
 <td align="right"><?  echo number_format($drAmount,2);?></td>
 <td bgcolor="#FFFF66" align="right"><? echo number_format($crAmount,2);?></td>
</tr>  
<tr><td colspan='8' height='3' bgcolor='#FFFFFF'></td></tr>
<tr><td colspan='8' height='1' bgcolor='#CCCCFF'></td></tr>
<tr><td colspan='8' height='3' bgcolor='#FFFFFF'></td></tr>
<tr><td colspan='8' height='1' bgcolor='#CCCCFF'></td></tr>

</table>
</div>
<? }?>
<? }//else pcode?>
<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
<? include('./project/siteDailyReport.f.php');?>
<form name="gl" action="./index.php?keyword=income+statement" method="post">
<table align="center"  width="500"  border="0" class="blue" >
 <tr bgcolor="#CCCCFF">
 <td align="right" valign="top" height="30" colspan="4"><font class='englishheadblack'>income statement</font></td>
</tr>

 <tr>
	   <td colspan="4">Project: 
<!-- 	  <select name='pcode' size='1' onChange="location.href='index.php?keyword=cash+disbursment&pcode='+cdj.pcode.options[document.cdj.pcode.selectedIndex].value+'&fromDate='+cdj.fromDate.value+'toDate='+cdj.toDate.value";> -->
      <select name="pcode" size="1">
	  <option value="0">Select Project</option>  
	  <option value="1" <? if($pcode==1) echo " SELECTED "?>>All BFEW</option>  	  
	<? 
	include("config.inc.php");
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
		
	$sqlp = "SELECT * from `project` ORDER by pcode ASC";
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

 <tr><td colspan="4" align="center"><input type="button" name="go" value="Go" onClick="gl.submit();"></td></tr>
</table>
<br>
<br>
<? if($pcode=='1') include('incomeStatementAll.php');
else {?>
<? if($fromDate AND $toDate){?>
<table align="center" width="750" class="vendorTable" border="1" >
<tr class="vendorAlertHd_small">
 <td>&nbsp;</td>
  <td colspan="2" align="center">Current Month</td>
  <td colspan="2" align="center">Range</td>
</tr>

<tr>
 <td bgcolor="#33FFCC" colspan="5">REVENUES</td>
</tr>
<? 

 $fromDate=formatDate($fromDate,'Y-m-j');
 $toDate=formatDate($toDate,'Y-m-j'); 

 $fromDate1= date('Y-m-j',mktime(0, 0, 0, date("m",strtotime($toDate)), 1,   date("Y",strtotime($toDate))));
 $toDate1=$toDate;
 
 
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

  $sql="select * from `accounts` WHERE  accountType='21' ORDER by accountID ASC";

//echo $sql;
  $sqlQ=mysqli_query($db, $sql);
  $r=mysql_num_rows($sqlQ);
  while($re=mysqli_fetch_array($sqlQ)){
  if($re[accountID]=='6100000')
  {$amount1=totalInvoiceAmount_date($pcode, $fromDate1,$toDate1);
  $amount=totalInvoiceAmount_date($pcode, $fromDate,$toDate);
  $totalRevenues1+=$amount1;
  $totalRevenues+=$amount;  
    }
else {$amount1=0;$amount=0;	}
  ?>
<? if( $amount !=0){?><tr>
 <td><? echo $re[accountID].' '.accountName($re[accountID]);?></td>
 <td align="right"><? echo number_format($amount1,2);?></td>
 <td><div align="right">%</div></td>
 <td align="right"><? echo number_format($amount,2);?></td>
 <td><div align="right">%</div></td>
</tr>  
<? }}?>
<tr bgcolor="#33FFCC">
 <td align="right">Total Revenues</td> 
 <td align="right"><? echo   number_format($totalRevenues1,2);?></td>
 <td></td>
  <td align="right"><? echo   number_format($totalRevenues,2);?></td>
 <td></td>  
</tr>
<tr><td height="20">&nbsp;</td></tr>
<tr bgcolor="#FFCCFF">
 <td colspan="5">COST OF SALES</td> 
</tr>
<? 
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

  $sql="select * from `accounts` WHERE  accountType='23' ORDER by accountID ASC";

//echo $sql;
  $sqlQ=mysqli_query($db, $sql);
  $r=mysql_num_rows($sqlQ);
  while($re=mysqli_fetch_array($sqlQ)){
  if($re[accountID]=='6801000'){
  $amount=total_mat_directissueAmount_date($pcode, $fromDate,$toDate);
  $amount1=total_mat_directissueAmount_date($pcode, $fromDate1,$toDate1);  
  }
  elseif($re[accountID]=='6802000'){
 $amount=total_eq_direct_issueAmount_date($pcode, $fromDate,$toDate); 
 $amount1=total_eq_direct_issueAmount_date($pcode, $fromDate1,$toDate1); 
// $amount=eq_ex_idle($pcode,$fromDate,$toDate);
 //$amount1=eq_ex_idle($pcode,$fromDate1,$toDate1);

 }  

 elseif($re[accountID]=='6802001')
   {
   
 $amount=eq_ex_utilized($pcode, $fromDate,$toDate); // range  
$amount1=eq_ex_utilized($pcode, $fromDate1,$toDate1); //current month
   }
  //////////////////////////////
  
  elseif($re[accountID]=='6803000'){
  //echo "test";
  $amount=sub_po_directReceive($pcode, $fromDate,$toDate);
  $amount1=sub_po_directReceive($pcode, $fromDate1,$toDate1);  
  }  
  elseif($re[accountID]=='6804000'){
/*  
  $temp=getMonth_sd_ed( $fromDate,$toDate);
  $si=sizeof($temp);
	  for($i=0;$i<=$si;$i++){
	  $fd=$temp[$i][0];
	  $td=$temp[$i][1];    
	  $subamount+=wagesAmount_date($pcode,$fd,$td);
	  }
	  $amount =$subamount;
	  $amount1=wagesAmount_date($pcode,$fromDate1,$toDate1);
*/
 $amount=wagesCostofsales($pcode,$fromDate,$toDate);
 $amount1=wagesCostofsales($pcode,$fromDate1,$toDate1); 
 	  
  }    
  else {$amount1=0;$amount=0;	}
  $totalCostofSales+=$amount;
  $totalCostofSales1+=$amount1;  
  ?>
<? // if( $amount !=0 ){ //stop if by salma ?><tr>
 <td><? echo $re[accountID].' '.accountName($re[accountID]);?></td>
 <td align="right"><? echo number_format($amount1,2);?></td>
 <td><div align="right">%</div></td>
 <td align="right"><? echo number_format($amount,2);?></td>
 <td><div align="right">%</div></td>
</tr>  
<? //}
}?>
<tr bgcolor="#FFCCFF">
 <td align="right">Total Cost of Sales</td> 
 <td align="right"><? echo   number_format($totalCostofSales1,2);?></td>
 <td></td>
  <td align="right"><? echo   number_format($totalCostofSales,2);?></td>
 <td></td>  
</tr>
<tr><td height="20">&nbsp;</td></tr>
<? 
$GrossProfit1=$totalRevenues1-$totalCostofSales1;
$GrossProfit=$totalRevenues-$totalCostofSales;
?>
<tr bgcolor="#FFFFCC" >
 <td>GROSS PROFIT</td> 
 <td align="right"><? echo   number_format($GrossProfit1,2);?></td>
 <td></td>
  <td align="right"><? echo   number_format($GrossProfit,2);?></td>
 <td></td>  
</tr>
<tr><td height="20">&nbsp;</td></tr>
<tr bgcolor="#99CCFF" >
 <td colspan="5">EXPENSES</td> 
</tr>
<? 
$data=array();
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

  $sql="select * from `accounts` WHERE  accountType='24' ORDER by accountID ASC";

//echo $sql;
  $sqlQ=mysqli_query($db, $sql);
  $r=mysql_num_rows($sqlQ);
$i=1;  
  while($re=mysqli_fetch_array($sqlQ)){

if($re[accountID]=='6901000'){ 
	$amount=total_salaryAmount_date($pcode, $fromDate,$toDate);
	$amount1=total_salaryAmount_date($pcode, $fromDate1,$toDate1);
}  
elseif($re[accountID]=='6902000'){ 
	$amount=total_wagesAmount_date($pcode, $fromDate,$toDate);
	$amount1=total_wagesAmount_date($pcode, $fromDate1,$toDate1);

 }  
elseif($re[accountID]=='6902010'){ 
  $amount=total_mat_indirectissueAmount_date($pcode, $fromDate,$toDate);
  $amount1=total_mat_indirectissueAmount_date($pcode, $fromDate1,$toDate1);  
 }   
elseif($re[accountID]=='6903000'){ 
  $amount=sub_po_indirectReceive($pcode, $fromDate,$toDate);
  $amount1=sub_po_indirectReceive($pcode, $fromDate1,$toDate1);  
 }    
elseif($re[accountID]=='6903010'){ 
  $amount=0;
  $amount1=0;  
  /*$amount=total_eq_issueAmount_date($pcode, $fromDate,$toDate);
  $amount1=total_eq_issueAmount_date($pcode, $fromDate1,$toDate1);  
  */
 }    
else {  
$amount=total_exAmount_date($pcode, $fromDate,$toDate,$re[accountID]);
$amount1=total_exAmount_date($pcode, $fromDate1,$toDate1,$re[accountID]);
}  
//echo $sql2;
$totalExpenses1+=$amount1;
$totalExpenses+=$amount;
$data[$i][0]=$re[accountID].' '.accountName($re[accountID]);
$data[$i][1]=$amount1;
$data[$i][2]=$amount;
$i++;
}
$rr=sizeof($data);
if($totalExpenses1<=0) $totalExpenses1=1;
if($totalExpenses<=0) $totalExpenses=1;
for($i=1;$i<=$rr;$i++){
  ?>
<? if( $data[$i][2]!=0 ){ ?><tr>
 <td><? echo $data[$i][0];?></td>
 <td align="right"><? echo number_format($data[$i][1],2);?></td>
 <td align="right" class="tsilver"><? echo round(($data[$i][1]*100)/$totalExpenses1);?>%</td>
 <td align="right"><? echo number_format($data[$i][2],2);?></td>
 <td align="right" class="tsilver"><? echo round(($data[$i][2]*100)/$totalExpenses);?>%</td>
</tr>  

<? } }//for?>
<tr bgcolor="#99CCFF">
 <td align="right">Total Expense</td>
 <td align="right"><? echo number_format($totalExpenses1,2);?></td>
 <td align="right">100%</td>
 <td align="right"><? echo number_format($totalExpenses,2);?></td>
 <td align="right">100%</td>
</tr>  
<tr><td height="20">&nbsp;</td></tr>
<? 
$netIncome1=$GrossProfit1-$totalExpenses1;
$netIncome=$GrossProfit-$totalExpenses;
?>
<tr  bgcolor="#FFFFCC">
 <td ><b>NET PROFIT</b></td>
 <td align="right"><?
  echo number_format($netIncome1,2);?></td>
 <td><div align="right">%</div></td>
 <td align="right"><? 
 echo number_format($netIncome,2);?></td>
 <td><div align="right">%</div></td>
</tr> 

<tr><td height="20">&nbsp;</td></tr>
<?

$crAmount=0;$drAmount=0;
$out=1;
$array_date=array();
$openingBalance=openingBalance('5000000',$fromDate,$pcode);


$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	  

  
  $sql="select * from `invoice` WHERE  `invoiceDate` between '$fromDate' and '$toDate' 
  	    AND  `invoiceLocation`='$pcode'  
		 order by invoiceDate ASC";  

//echo $sql;
  $sqlQ=mysqli_query($db, $sql);
  $r=mysql_num_rows($sqlQ);
$k=0;  

$array_date=array();
  while($re=mysqli_fetch_array($sqlQ)){
$array_date[$i][0]=$re[invoiceDate];
$array_date[$i][1]=$re[invoiceNo];
$array_date[$i][2]=viewInvoiceType($re[invoiceType]);
$array_date[$i][3]=$re[invoiceAmount];
$array_date[$i][4]=1;
  $i++;
  }  
$sql1="select * from `receivecash` WHERE `receiveDate` between '$fromDate' AND '$toDate' 
       AND `receiveFrom` LIKE '5000000-$pcode' ORDER by receiveDate ASC";
 //echo $sql1.'<br>';
//echo $sql1;
$sqlq1=mysqli_query($db, $sql1);
while($st=mysqli_fetch_array($sqlq1)){
$array_date[$i][0]=$st[receiveDate];
$array_date[$i][1]=$st[receiveSL];
$array_date[$i][2]=$st[reff];
$array_date[$i][3]=$st[receiveAmount];
$array_date[$i][4]=2;
  $i++;
  }  
 sort($array_date);
$r=sizeof($array_date);

for($i=0;$i<$r;$i++){
					if($array_date[$i][4]=='1'){ $drAmount+=$array_date[$i][3]; }
					if($array_date[$i][4]=='2'){ $crAmount+=$array_date[$i][3];}
					$k=1;
					} 
?>
<tr bgcolor="#B1F28A">
 <td colspan="5" align="right"><div align="left"><b>Other relevent up-to-date Project Informations</b></div></td> </tr> 
<tr bgcolor="#B1F28A">

 <td colspan="5" align="right"><div align="left"><b><u>Current Assets</u></b></div></td>
 </tr>  

<? 
//$netIncome1=$GrossProfit1-$totalExpenses1;
//$netIncome=$GrossProfit-$totalExpenses;
?>
<tr  bgcolor="">
 <td >Accounts Receivable </td>
 <td align="right"><?
 // echo number_format($netIncome1,2);?></td>
 <td>&nbsp;</td>
 <td align="right"><? 
 $TCA=$openingBalance+$drAmount-$crAmount; //TCA= total current asset ?><? echo number_format($TCA,2);  ?></td>
 <td>&nbsp;</td>
</tr> 
<?
		 function WP1($iow,$p,$ed,$totalQty,$unit,$c){
		//$ed=formatDate($ed,'Y-m-j');
		$approvedTotalAmount=iowApprovedCost($iow);
		
		$totalMaretialCost=totalMaretialCost($iow,$p,$ed,$c);
		//echo "<br>**totalMaretialCost=$totalMaretialCost**<br>";
		$totalempCost=totalempCost($iow,$p,$ed,$c);
		$totalSubconCost=totalSubconCost($iow,$p,$ed,$c);
		
		//echo "<br>**totalempCost=$totalempCost**<br>";
		$totalSubconCost=totalSubconCost($iow,$p,$ed,$c);
		//echo "<br>**totalSubconCost=totalSubconCost**<br>";
		
		$totaleqCost=totaleqCost($iow,$p,$ed,$c);
		//echo "<br>**totaleqCost=$totaleqCost**<br>";
		
		$actualTotalAmount=$totalMaretialCost+$totalempCost+$totalSubconCost+$totaleqCost;
		
		$progressp=($actualTotalAmount*100)/$approvedTotalAmount;
		
		$progressQty=($totalQty*$progressp)/100;
		 if($unit=='L.S' OR $unit=='LS' OR $unit=='l.s' OR $unit=='l.s') 
			return $progressp;
		else  
			/*if($unit=='Days' || $unit=='Month' || $unit=='Km' || $unit=='Ton'|| $unit=='m' || $unit=='Joint' || $unit=='No') return $progressQty; else  return $unit; */
			return $progressQty;
		}
 
 
			function WP2($iow,$p,$ed,$totalQty,$unit,$c){
			//$ed=formatDate($ed,'Y-m-j');
			$approvedTotalAmount=iowApprovedCost($iow);
			
			$totalMaretialCost=totalMaretialCost($iow,$p,$ed,$c);
			//echo "<br>**totalMaretialCost=$totalMaretialCost**<br>";
			$totalempCost=totalempCost($iow,$p,$ed,$c);
			$totalSubconCost=totalSubconCost($iow,$p,$ed,$c);
			
			//echo "<br>**totalempCost=$totalempCost**<br>";
			$totalSubconCost=totalSubconCost($iow,$p,$ed,$c);
			//echo "<br>**totalSubconCost=totalSubconCost**<br>";
			
			$totaleqCost=totaleqCost($iow,$p,$ed,$c);
			//echo "<br>**totaleqCost=$totaleqCost**<br>";
			
			$actualTotalAmount=$totalMaretialCost+$totalempCost+$totalSubconCost+$totaleqCost;
			
			$progressp=($actualTotalAmount*100)/$approvedTotalAmount;
			
			$progressQty=($totalQty*$progressp)/100;
			 if($unit=='L.S' OR $unit=='LS' OR $unit=='l.s' OR $unit=='l.s') 
				return $unit;
			else  
				if($unit=='')return $unit=0; else  return $unit;
			}
			 
 
 
 
 
 
 $TWP=0;
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	  


$sql = "SELECT * from `iow` WHERE 1
 AND iowProjectCode= '$pcode' 
 AND iowType='1'  ORDER by iowId ASC";

$ed=$todat;
//echo $sql;
$sqlrunp= mysqli_query($db, $sql);
$i=1;



?>


<tr  bgcolor="">
 <td >Work in Progress </td>
 <td colspan="2" align="right"><?  
 
 
 while($iow=mysqli_fetch_array($sqlrunp)){

		
	if(WP2($iow[iowId],$iow[iowProjectCode],$ed,$iow[iowQty],$iow[iowUnit],0)=='LS' || WP2($iow[iowId],$iow[iowProjectCode],$ed,$iow[iowQty],$iow[iowUnit],0)=='L.S' || WP2($iow[iowId],$iow[iowProjectCode],$ed,$iow[iowQty],$iow[iowUnit],0)=='l.s' || WP2($iow[iowId],$iow[iowProjectCode],$ed,$iow[iowQty],$iow[iowUnit],0)=='l.s'){
		
		 $workComplited = WP1($iow[iowId],$iow[iowProjectCode],$ed,$iow[iowQty],$iow[iowUnit],0); //echo "--";
			
		 $invoicedQty=invoicedQty($iow[iowId]); //echo "--";
			
		 $rate=$iow[iowPrice]; //echo "--#";
			
		 $TWP+=((($workComplited-$invoicedQty)*$rate)/100); //echo "<br>"; //TWP= total work in progress
		}
		
		else
		{
		 $workComplited2 = WP1($iow[iowId],$iow[iowProjectCode],$ed,$iow[iowQty],$iow[iowUnit],0); //echo "--";
			
		 $invoicedQty2=invoicedQty($iow[iowId]); //echo "--";
			
		 $rate2=$iow[iowPrice]; //echo "--|";
		//echo $cl3=$workComplited2-$invoicedQty2; echo "(";
		//echo $cal4=($workComplited2-$invoicedQty2)*$rate2; echo ")";
		
		 $calculatedvalue=($workComplited2-$invoicedQty2)*$rate2; //echo "==";
			
		 $TWP+=$calculatedvalue; //echo "<br>";
		}
}
 
 ?></td>
 <td align="right"><? echo number_format($TWP,2);  ?></td>
 <td>&nbsp;</td>
</tr> 

<tr  bgcolor="">
  <td >Other Current Assets </td>
  <td align="right">&nbsp;</td>
  <td>&nbsp;</td>
  <td align="right">&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<? 
//$fromDate=formatDate($fromDate,'Y-m-j');
 //$toDate=formatDate($toDate,'Y-m-j');  
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

$i=1;
 ?>
 
<?  $sql3="select * from `accounts` ORDER by accountID ASC";
$sqlq=mysqli_query($db, $sql3);
while($re=mysqli_fetch_array($sqlq)){
if($re[accountID]=='5502000'){	$balanceSideCash=cashonHand($pcode,$fromDate,$toDate,'2');	}


}

?>

<tr  bgcolor="">
  <td >Site Cash </td>
  <td align="right">&nbsp;</td>
  <td>&nbsp;</td>
  <td align="right"><? echo number_format($balanceSideCash,2); ?></td>
  <td>&nbsp;</td>
</tr>
<?
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

//$sql="SELECT DISTINCT itemCode FROM store$pcode WHERE 1 AND currentQty <> 0 ";	
$sql="SELECT DISTINCT itemCode FROM store$pcode WHERE itemCode between '0101001' and '2999999' ";
$TI=0;
$sqlquery=mysqli_query($db, $sql);
$i=0;
$total=0;	
while($sqlresult=mysqli_fetch_array($sqlquery)){	

$amount=mat_stock_rate($pcode,$sqlresult[itemCode],$toDate);

$TI+=$amount;    //TI = total inventory
}




?>

<tr  bgcolor="">
  <td >Raw Material Inventory </td>
  <td align="right">&nbsp;</td>
  <td>&nbsp;</td>
  <td align="right"><? echo number_format($TI,2); ?></td>
  <td>&nbsp;</td>
</tr>

<tr  bgcolor="#B1F28A">
  <td  align="right"><b>Total Current Assets </b></td>
  <td align="right">&nbsp;</td>
  <td>&nbsp;</td>
  <td align="right"><b><? echo number_format($TCA+$TWP+$TI+$balanceSideCash,2); ?></b></td>
  <td>&nbsp;</td>
</tr>

<tr  bgcolor="#B1F28A">
  <td colspan="5"  align="right">&nbsp;</td>
  </tr>
  
  <tr  bgcolor="#B1F28A">
    <td colspan="5" ><u><b>Current Liabilities</b></u></td>
    </tr>
	<?
	 $crAmount=0;
	 $drAmount=0;
 $k=0;

$openingBalance=0;

$array_date=array();
$baseOpening=baseOpening('2401000',$pcode);
$openingBalance=$baseOpening+openingBalance('2401000',$fromDate,$pcode);
  
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
	
	$sql="SELECT SUM( receiveQty * rate )as amount, `todat`,`paymentSL`, `itemCode`,`reference` 
	FROM `store$pcode` 
	WHERE `todat` between '$fromDate' and '$toDate' 
	AND `paymentSL` LIKE 'PO%' 
	GROUP BY todat,`paymentSL` order by todat ASC ";
//echo $sql;
  $sqlQ=mysqli_query($db, $sql);
  $r=mysql_num_rows($sqlQ);
$i=0;  
  while($st=mysqli_fetch_array($sqlQ)){
  $array_date[$i][0]=$st[todat];
  $array_date[$i][1]=viewposl($st[paymentSL]);  
  $array_date[$i][2]=$st[reference];
  $array_date[$i][3]=$st[amount];  
  $array_date[$i][4]=2;  
  $i++;  
  }
  
	$sql="SELECT SUM( receiveQty * rate )as amount, `todat`,`paymentSL`, `itemCode`,`reference` ".
	" FROM `storet$pcode` WHERE `todat` between '$fromDate' and '$toDate' 
	AND `paymentSL` LIKE 'ST_%'GROUP BY `paymentSL` order by todat ASC ";
	  
//echo $sql;
  $sqlQ=mysqli_query($db, $sql);
  $r=mysql_num_rows($sqlQ);

  while($st=mysqli_fetch_array($sqlQ)){
  $array_date[$i][0]=$st[todat];
  $array_date[$i][1]=$st[paymentSL];  
  $array_date[$i][2]=$st[reference];
  $array_date[$i][3]=$st[amount];  
  $array_date[$i][4]=2;  
  $i++;  
  }  
$sql1="SELECT `paidAmount` as amount,`paymentSL`,`paymentDate`,`posl` from `vendorpayment` WHERE".
" `paymentDate` BETWEEN '$fromDate' AND '$toDate' AND `posl` LIKE 'PO_".$pcode."_%' Order by paymentDate ASC";
//echo $sql1;
$sqlq1=mysqli_query($db, $sql1);
while($st=mysqli_fetch_array($sqlq1)){
if(poType($st[posl])==1){
$array_date[$i][0]=$st[paymentDate];
$array_date[$i][1]=$st[paymentSL];
$array_date[$i][2]='';
$array_date[$i][3]=$st[amount];
$array_date[$i][4]=1;
  $i++;
  }//if(poType($r[posl])==1)
  }
	
	$r=sizeof($array_date);
for($i=0;$i<$r;$i++){
if($array_date[$i][4]=='1'){ $drAmount+=$array_date[$i][3];}
if($array_date[$i][4]=='2'){ $crAmount+=$array_date[$i][3];}

					}
	
	$totalmaterial=$openingBalance+$drAmount-$crAmount;
	
	
	//equipment
	
	$drAmount=0;
$crAmount=0;
$openingBalance=0;

$array_date=array();
//$openingBalance=openingBalance('2402000',$fromDate,$pcode);
$openingBalance=0;
	
    $sql="select COUNT(id) as total,`itemCode`,`posl` 
	from `eqattendance`  
	WHERE `edate` between '$fromDate' and '$toDate' 
	AND `location` ='$pcode' 
    group by posl,itemCode 
	order by edate ASC ";
//echo "$sql<b><br>";
  $sqlQ=mysqli_query($db, $sql);
$i=0;  
  while($st=mysqli_fetch_array($sqlQ)){
	$pamount=0;
	$wamount=0;
	$dailyworkBreakt=0;
	$toDaypresent=0;
	$toDaypresent=0;
	$workt=0;
	$rate=0;
	
	$rate=eqpoRate($st[itemCode],$st[posl]);
	$pamount=$st[total]*$rate;

  $array_date[$i][0]=$st[edate];
  $array_date[$i][1]=$st[posl];  
  $array_date[$i][2]=' eq present';
  $array_date[$i][3]=$pamount;  
  $array_date[$i][4]=2;  
  $i++;  
  }//while st
  
  $sql1="SELECT `paidAmount` as amount,`paymentSL`,`paymentDate`,`posl` 
from `vendorpayment` 
WHERE `paymentDate` BETWEEN '$fromDate' AND '$toDate' 
AND `posl` LIKE 'EQ_".$pcode."_%' 
Order by paymentDate ASC";
//echo $sql1;
$sqlq1=mysqli_query($db, $sql1);
while($st=mysqli_fetch_array($sqlq1)){

$array_date[$i][0]=$st[paymentDate];
$array_date[$i][1]=$st[paymentSL];
$array_date[$i][2]='';
$array_date[$i][3]=$st[amount];
$array_date[$i][4]=1;
  $i++;
  }
  
  $r=sizeof($array_date);
for($i=0;$i<$r;$i++){

if($array_date[$i][4]=='1'){ $drAmount+=$array_date[$i][3];}
if($array_date[$i][4]=='2'){ $crAmount+=$array_date[$i][3];}

					}
	
	$totaleqpment=$openingBalance+$drAmount-$crAmount;
	
	
//sub contract

$drAmount=0;
$crAmount=0;
$openingBalance=0;

$array_date=array();
$openingBalance=openingBalance('2403000',$fromDate,$pcode);
  
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
	
	$sql="SELECT SUM( qty*rate )as amount, `edate`,`posl` ".
	" FROM `subut` WHERE `edate` between '$fromDate' and '$toDate'
	 AND `posl` LIKE 'PO_".$pcode."_%' GROUP BY `posl`,`edate` order by edate ASC ";
//echo $sql;
  $sqlQ=mysqli_query($db, $sql);
  $r=mysql_num_rows($sqlQ);
$i=0;  
  while($st=mysqli_fetch_array($sqlQ)){
  $array_date[$i][0]=$st[edate];
  $array_date[$i][1]=$st[posl];  
  $array_date[$i][2]='received';
  $array_date[$i][3]=$st[amount];  
  $array_date[$i][4]=2;  
  $i++;  
  }
  
$sql1="SELECT `paidAmount` as amount,`paymentSL`,`paymentDate`,`posl` from `vendorpayment` WHERE".
" `paymentDate` BETWEEN '$fromDate' AND '$toDate' AND `posl` LIKE 'PO_".$pcode."_%' Order by paymentDate ASC";
//echo $sql1;
$sqlq1=mysqli_query($db, $sql1);
while($st=mysqli_fetch_array($sqlq1)){
if(poType($st[posl])==3){
$array_date[$i][0]=$st[paymentDate];
$array_date[$i][1]=$st[paymentSL];
$array_date[$i][2]='';
$array_date[$i][3]=$st[amount];
$array_date[$i][4]=1;
  $i++;
  }//if(poType($r[posl])==1)
  }
 	
	
	$r=sizeof($array_date);
for($i=0;$i<$r;$i++){

if($array_date[$i][4]=='1'){ $drAmount+=$array_date[$i][3];}
if($array_date[$i][4]=='2'){ $crAmount+=$array_date[$i][3];}

					}
	
	$totalsubcontract=$openingBalance+$drAmount-$crAmount;
	
	
	?>
	<tr  bgcolor="">
    <td >Accounts Payable </td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><? echo number_format($totalmaterial+$totaleqpment+$totalsubcontract,2);?></td>
    <td>&nbsp;</td>
  </tr>
    <tr  bgcolor="">
      <td >Other Current Liabilities </td>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr  bgcolor="#B1F28A">
  <td ><div align="right"><b>Total Current Liabilities </b></div></td>
  <td align="right">&nbsp;</td>
  <td>&nbsp;</td>
  <td align="right"><b><? echo number_format($totalmaterial+$totaleqpment+$totalsubcontract,2);?></b></td>
  <td>&nbsp;</td>
</tr>
</table>
<?  }//if($fromDate AND $toDate){?>
</form>
<? }//else pcode?>
<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
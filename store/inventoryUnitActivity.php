<!-- <h1>	Under Construction.</h1> -->
<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
<form name="gl" action="./index.php?keyword=inventory+activity" method="post">
<table  width="80%" align="center" border="0" class="blue" >
<tr bgcolor="#CCCCFF">
 <td align="right" valign="top" height="30" colspan="4"><font class='englishheadblack'>Inventory</font></td>
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
 <td>ItemCode</td>
 <td >
	<input name="itemCode11" value="<? echo $itemCode11;?>" onKeyUp="return autoTab(this, 2, event);" size="2" maxlength="2" > - 
    <input name="itemCode12" value="<? echo $itemCode12;?>" onKeyUp="return autoTab(this, 2, event);" size="2" maxlength="2"> - 
    <input name="itemCode13" value="<? echo $itemCode13;?>" onKeyUp="return autoTab(this, 3, event);" size="3" maxlength="3" >
	</td>
 <td>ItemCode</td> 
<td >
	<input name="itemCode21" value="<? echo $itemCode21;?>" onKeyUp="return autoTab(this, 2, event);"  size="2" maxlength="2" > - 
    <input name="itemCode22" value="<? echo $itemCode22;?>" onKeyUp="return autoTab(this, 2, event);" size="2" maxlength="2"> - 
    <input name="itemCode23" value="<? echo $itemCode23;?>" onKeyUp="return autoTab(this, 3, event);" size="3" maxlength="3" >
	</td> 
 </tr>
<?  
	if($loginDesignation=='Store Officer' || $loginDesignation=='Procurement Executive') {

	$pcode=$loginProject;}
	else{?>
   <tr>
	   <td >Project: </td>
	   <td colspan="3">
      <select name="pcode" size="1">
	  <option value="0">Select Project</option>  
	  <option value="">Central Store</option>
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
	<? 
	}?>

 <tr><td colspan="4" align="center"><input type="button" name="go" value="Go" onClick="gl.submit();"></td></tr>
</table>

<input type="hidden" name="ck" value="1">
</form>
<? if($fromDate AND $toDate){
  $fromDate=formatDate($fromDate,'Y-m-d');
  $toDate=formatDate($toDate,'Y-m-d'); 
  }

?>
<table align="center" width="95%" border="1" bordercolor="#ADA5F8" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#D2D2FF">
 <th height="30">ItemID</th>
 <th>Date</th>
 <th>Reffenence</th>
 <th>Recived Qty</th>
 <th>Issued Qty</th> 
 <th>Amount</th> 
</tr>
<? 

$itemCode1="$itemCode11-$itemCode12-$itemCode13";
$itemCode2="$itemCode21-$itemCode22-$itemCode23";

if($pcode=='004'){
$sql="SELECT DISTINCT store$pcode.itemCode,itemlist.itemDes,itemlist.itemSpec from store$pcode,itemlist WHERE".
" store$pcode.itemCode between '$itemCode1' ". 
" AND '$itemCode2' AND itemlist.itemCode=store$pcode.itemCode".
" ORDER by store$pcode.itemCode ASC";
}
else {
$sql="SELECT DISTINCT store$pcode.itemCode,itemlist.itemDes,itemlist.itemSpec from store$pcode,itemlist WHERE".
" store$pcode.itemCode between '$itemCode1' ". 
" AND '$itemCode2' AND itemlist.itemCode=store$pcode.itemCode".
" ORDER by store$pcode.itemCode,store$pcode.todat ASC";
}
// echo $sql;
$sqlq=mysqli_query($db, $sql);
while($re=mysqli_fetch_array($sqlq)){
$openingBalance=0;
$openingBalanceRate=0;
$array_date=array();
if($pcode){
// 		print_r($re);
if(!$firstStartDate)
	$startDate=strtotime($firstStartDate);
else	
	$firstStartDate=$startDate=strtotime($fromDate);

$endDate=strtotime($toDate);
$i=0;
	echo "<br>$re[itemCode]  >>  $startDate<$endDate  e-s=".($endDate-$startDate)."</br>";
while($startDate<$endDate){
	$startDateFormated=date("Y-m-d",$startDate);
	$startDate=strtotime("+1 day",$startDate);
	
	$fromDate=$toDate=$startDateFormated;
	
$sql1="SELECT todat,reference,receiveQty,receiveQty*rate as amount 
from store$pcode WHERE itemCode='$re[itemCode]' AND 
todat BETWEEN '$fromDate' AND '$toDate' Order by todat ASC";
// echo $sql1;
$sqlq1=mysqli_query($db, $sql1);
while($st=mysqli_fetch_array($sqlq1)){
	$array_date[$i][0]=$st[todat];
	//$array_date[$i][1]=$st[reference];
	$array_date[$i][1]=$st[reference]; //generate_MRsl($st[rsid],$pcode);
	$array_date[$i][2]=number_format($st[receiveQty],3);
	$array_date[$i][3]=number_format($st[amount],2);
	$array_date[$i][4]=1;

	$i++;
	$totalReQty=$totalReQty+$st[receiveQty];
	$totalReQtyAmount=$totalReQtyAmount+$st[amount];
}
$sql1="SELECT * from issue$pcode WHERE itemCode='$re[itemCode]' 
 AND issueDate BETWEEN '$fromDate' AND '$toDate' Order by issueDate ASC,issueSL ASC";
//echo $sql1;
$sqlq1=mysqli_query($db, $sql1);
while($st=mysqli_fetch_array($sqlq1)){
	$array_date[$i][0]=$st[issueDate];
	$array_date[$i][1]=generate_ISsl($st[issueSL],$pcode);
	$array_date[$i][2]='<font class=out>('.number_format($st[issuedQty],3).')</font>';
	$array_date[$i][3]='<font class=out>('.number_format($st[issuedQty]*$st[issueRate],2).')</font>';
	$array_date[$i][4]=2;
	$array_date[$i][5]=$st[issuedQtyTemp];
	$i++;
	$totalIssueQty=$totalIssueQty+$st[issuedQty];
	$totalIssueQtyAmount=$totalIssueQtyAmount+($st[issuedQty]*$st[issueRate]);
}
	$sql1="SELECT * from storet WHERE itemCode='$re[itemCode]' AND returnFrom ='$pcode'
		AND edate BETWEEN '$fromDate' AND '$toDate' ";
	//echo $sql1.'<br>';
	$sqlq1=mysqli_query($db, $sql1);
	while($st=mysqli_fetch_array($sqlq1)){
		$array_date[$i][0]=$st[edate];
		$array_date[$i][1]=$st[rsl];
		$array_date[$i][2]='<font class=out>('.number_format($st[receiveQty],3).')</font>';
		$array_date[$i][3]='<font class=out>('.number_format($st[receiveQty]*$st[rate],2).')</font>';
		$array_date[$i][4]=2;
		$i++;
		$totalIssueQty=$totalIssueQty+$st[receiveQty];
		$totalIssueQtyAmount=$totalIssueQtyAmount+($st[receiveQty]*$st[rate]);
	}//while
	$ro=$i+3;
	}//date range
$fromDate=date("Y-m-d",$firstStartDate);
} //end of pcode if
else { //else of pcode
$sql1="SELECT sdate,reference,receiveQty,receiveQty*rate as amount 
from store$pcode WHERE itemCode='$re[itemCode]' AND 
sdate BETWEEN '$fromDate' AND '$toDate' Order by sdate ASC";
//echo $sql1;
$sqlq1=mysqli_query($db, $sql1);
$i=0;
while($st=mysqli_fetch_array($sqlq1)){
$array_date[$i][0]=$st[sdate];
//$array_date[$i][1]=$st[reference];
$array_date[$i][1]=$st[reference]; //generate_MRsl($st[rsid],$pcode);
$array_date[$i][2]=number_format($st[receiveQty],3);
$array_date[$i][3]=number_format($st[amount],2);
$array_date[$i][4]=1;

$i++;
$totalReQty=$totalReQty+$st[receiveQty];
$totalReQtyAmount=$totalReQtyAmount+$st[amount];
}

$sqlp112 = "SELECT * from `project` order by pcode ASC";
	//echo $sqlp;
	$sqlrunp112= mysqli_query($db, $sqlp112);
	
while($type112= mysqli_fetch_array($sqlrunp112)){
	
	$tpcode=$type112[pcode];
	$sql1="SELECT * from storet$tpcode WHERE itemCode='$re[itemCode]' AND paymentSL LIKE 'ST_%'
	AND todat BETWEEN '$fromDate' AND '$toDate' ";
	//echo $sql1.'<br>';
	$sqlq1=mysqli_query($db, $sql1);
	while($st=mysqli_fetch_array($sqlq1)){
	$array_date[$i][0]=$st[todat];
	$array_date[$i][1]=$st[paymentSL];
	$array_date[$i][2]='<font class=out>('.number_format($st[receiveQty],3).')</font>';
	$array_date[$i][3]='<font class=out>('.number_format($st[receiveQty]*$st[rate],2).')</font>';
	$array_date[$i][4]=2;
	$i++;
	$totalIssueQty=$totalIssueQty+$st[receiveQty];
	$totalIssueQtyAmount=$totalIssueQtyAmount+($st[receiveQty]*$st[rate]);
	}//while storet
} //while all project
} //pcode else
$ro=$i+3;
?>
<tr bgcolor="#D5FFD5">
 <th rowspan="<? echo $ro;?>" ><? echo $re[itemCode];?><br><? echo $re[itemDes].', '.$re[itemSpec];?></th>
 <td align="center"><? echo date('d-m-Y',($firstStartDate)-86400);?></td>
 <td height="25">Opening Balance</td>
 <td align="right"><? $openingBalance=mat_stock($pcode,$re[itemCode],date("Y-m-d",$firstStartDate),$toDate);
   echo number_format($openingBalance,3); ?></td>
 <td></td>
 <td align="right"><? $openingBalanceRate=mat_stock_rate($pcode,$re[itemCode],date("Y-m-d",$firstStartDate),$toDate);
   echo number_format($openingBalanceRate,2); 
 ?></td>

</tr>

<?
// sort($array_date);
//print_r ($array_date);
for($i=0;$i<sizeof($array_date);$i++){
	echo "<tr>";
	echo "<td align=center>".myDate($array_date[$i][0])."</td>";//date
	echo "<td >".$array_date[$i][1];//reff
	echo $array_date[$i][5]>0 ? "<font color='#f00'> (Verification Pending) </font>" : "";
	echo "</td>";//reff
	if($array_date[$i][4]==1){
		echo "<td align=right>".$array_date[$i][2]."</td>";//MR qty
		echo "<td></td>";
	}
	else {
		echo "<td></td>";
		echo "<td align=right>".$array_date[$i][2]."</td>";//ISS qty
	}
	echo "<td align=right>".$array_date[$i][3]."</td>";//amount
	echo "</tr>";
}
?>
<? 
 $MRclosingBalance=($openingBalance+$totalReQty);
 $ISclosingBalance=$totalIssueQty; 
 $closingBalanceRate=($openingBalanceRate+$totalReQtyAmount)-$totalIssueQtyAmount;
 
// echo "<br>$closingBalanceRate=(openingBalanceRate=$openingBalanceRate+totalReQtyAmount=$totalReQtyAmount)-totalIssueQtyAmount=$totalIssueQtyAmount<br>";
 ?>
<tr bgcolor="#D5FFD5" >
 <td align="center" ><? echo date('d-m-Y',strtotime($toDate));?></td>
 <td align="center">Sub Total </td>
 <td align="right"><? echo number_format($MRclosingBalance,3); ?></td>
 <td align="right"><font class=out>(<? echo number_format($ISclosingBalance,3); ?>)</font></td>
 <td align="right"></td>

</tr>

<tr bgcolor="#FFFFCC">
 <td align="center" height="25"><? echo date('d-m-Y',strtotime($toDate));?></td>
 <td>Closing Balance</td>
 <td align="right"><? echo number_format($MRclosingBalance-$ISclosingBalance,3); ?></td>
 <td align="right"></td>
 <td align="right"><? echo number_format($closingBalanceRate,2); 
 ?></td>

</tr>
<? 
$totalReQtyAmountGT=$totalReQtyAmountGT+$totalReQtyAmount;
$closingBalance=0; 
$closingBalanceRate=0;
$totalIssueQtyAmount=0;
$totalIssueQty=0;
$totalReQty=0;
$totalReQtyAmount=0;
}
	?>
<!--<tr><td align="right" colspan="6"><? echo $totalReQtyAmountGT;?></td></tr>-->
</table>
<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>

<br><br><a target="_blank" href="./print/print_inventoryUnitActivity.php?fromDate=<? echo $fromDate;?>&
toDate=<? echo $toDate;?>&
itemCode11=<? echo $itemCode11;?>&
itemCode12=<? echo $itemCode12;?>&
itemCode13=<? echo $itemCode13;?>&
itemCode21=<? echo $itemCode21;?>&
itemCode22=<? echo $itemCode22;?>&
itemCode23=<? echo $itemCode23;?>
 ">Print</a>
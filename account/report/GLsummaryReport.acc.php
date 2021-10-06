
<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
<form name="gl" action="./index.php?keyword=gl+summary+report" method="post">
<table  width="400" align="center" border="0" class="blue" >
 <tr bgcolor="#CCCCFF">
 <td align="right" valign="top" height="30" colspan="4"><font class='englishheadblack'>general ledger</font></td>
</tr>
 <tr>
 	<SCRIPT LANGUAGE="JavaScript">
	var now = new Date();
	var cal = new CalendarPopup("testdiv1");
    	//cal.showNavigationDropdowns();
		cal.setWeekStartDay(6); // week is Monday - Sunday
		//cal.addDisabledDates(null,formatDate(now,"yyyy-MM-dd"));
		cal.setCssPrefix("TEST");
		cal.offsetX = 0;
		cal.offsetY = -150;

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

<input type="hidden" name="ck" value="1">
</form>
<? if($fromDate AND $toDate){
  $fromDate=formatDate($fromDate,'Y-m-d');
  $toDate=formatDate($toDate,'Y-m-d'); 
?>

<table  width="90%" align="center" border="0" cellpadding="5" cellspacing="0" style="font-size: 10px;" >
 <tr bgcolor="#CCFF99">
   <th align="center" valign="top">Account ID</th>   
   <th align="right" valign="top" >Debit Amount</th>   
   <th align="right" valign="top" >Credit Amount</th> 
   <th align="center" valign="top" >Balance</th>
 </tr>

   <?
     $sql="SELECT * FROM accounts ORDER by accountID ASC";
	 //echo $sql;
	 $sqlq=mysqli_query($db, $sql);
	 $j=1;
	 while($re=mysqli_fetch_array($sqlq)){?>
 <tr> 
   <td><? 
   echo $re[accountID].'-'.$loginProject; echo '<br>'.accountName($re[accountID]);
   ?></td>
   <td><? if($re[accountID]=='6800000'){
    $sql1="SELECT SUM(issuedQty*issueRate) as amount from issue137 where issueDate between '$fromDate' AND '$toDate'";
    // echo "$sql1";
	 $sqlq1=mysqli_query($db, $sql1);
	 $sqlf=mysqli_fetch_array($sqlq1);
	 echo number_format($sqlf[amount],2);
	 }	 
	 if($re[accountID]=='4700000'){
    $sql1="SELECT SUM(receiveQty*rate) as amount from store137 where todat between '$fromDate' AND '$toDate'";
    // echo "$sql1";
	 $sqlq1=mysqli_query($db, $sql1);
	 $sqlf=mysqli_fetch_array($sqlq1);
	 echo number_format($sqlf[amount],2);
	 	 $v4700000DR=$sqlf[amount];
	 }	 
	 
?></td>
   <td align="right">
   <? if($re[accountID]=='5502000'){
    $sql1="SELECT SUM(paidAmount) as amount from purchase where account LIKE '5502000-137' and paymentDate between '$fromDate' AND '$toDate'";
     //echo "$sql1";
	 $sqlq1=mysqli_query($db, $sql1);
	 $sqlf=mysqli_fetch_array($sqlq1);
	 echo number_format($sqlf[amount],2);
	 }
	 if($re[accountID]=='4800000'){
    $sql1="SELECT SUM(receiveQty*rate) as amount from storet137 where todat between '$fromDate' AND '$toDate'";
     //echo "$sql1";
	 $sqlq1=mysqli_query($db, $sql1);
	 $sqlf=mysqli_fetch_array($sqlq1);
	 echo number_format($sqlf[amount],2);
	 }
    if($re[accountID]=='4700000'){
    $sql1="SELECT SUM(issuedQty*issueRate) as amount from issue137 where issueDate between '$fromDate' AND '$toDate'";
    // echo "$sql1";
	 $sqlq1=mysqli_query($db, $sql1);
	 $sqlf=mysqli_fetch_array($sqlq1);
	 echo number_format($sqlf[amount],2);
	 $v4700000CR=$sqlf[amount];
	 }	 
	 ?></td>
   <td align="right"><? if($re[accountID]=='4700000'){ $v4700000B=$v4700000DR-$v4700000CR; echo number_format($v4700000B,2);}?></td>      
</tr>

<tr>
 <td colspan="8" bgcolor="#FF9999" height="2"></td>
</tr>	 
<? } }?>
</table>


<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
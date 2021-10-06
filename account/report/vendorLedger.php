<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
<form name="gl" action="./index.php?keyword=vendor+ledger" method="post">
<table  width="400" align="center" border="0" class="blue" >
 <tr bgcolor="#CCCCFF">
 <td align="right" valign="top" height="30" colspan="4"><font class='englishheadblack'>Vendor ledger</font></td>
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

</form>
<input type="hidden" name="ck" value="1">
</form>
<table  width="850" align="center" border="0" cellpadding="5" cellspacing="0" style="font-size: 10px;" >
 <tr bgcolor="#CCFF99">
   <th align="center" valign="top" width="200">Account ID</th>   
   <th align="center" valign="top" width="100">Date</th>
   <th align="center" valign="top">Reference</th>
   <th align="center" valign="top">Jrnl</th>   
   <th align="center" valign="top" width="200">Description</th>   
   <th align="right" valign="top" width="100">Debit Amount</th>   
   <th align="right" valign="top" width="100">Credit Amount</th> 
   <th align="center" valign="top" width="100">Balance</th>         
   
 </tr>
 <tr><td colspan="8" height="3" bgcolor="#FFCC66"></td></tr>
 <?
  $fromDate=formatDate($fromDate,'Y-m-j');
 $toDate=formatDate($toDate,'Y-m-j'); 

 $amount=0;
 $exc=0;
 $cash=0;
 $pre=0;
 $pp=0; 
 $ss=0;
 $account=array();
 $date=array();
 $paidTo=array(); 
 $amount=array(); 
 
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

  $sql="select * from `purchase` WHERE  paymentDate between '$fromDate' and '$toDate' AND account='5502000-$loginProject' order by account,paymentDate DESC";  
 echo $sql;
  $sqlQ=mysqli_query($db, $sql);
  $i=1;
  while($re=mysqli_fetch_array($sqlQ)){
  $account[$i]=$re[account];
  $date[$i]=$re[paymentDate];
  $reff[$i]=$re[paymentSL];
  $paidTo[$i]=$re[paidTo];
  $amount[$i]=$re[paidAmount];

 if( $exc==0 OR $cash==0 OR $pre==0 OR $pp==0 OR $ss==0){
 $temp=explode('_',$re[paymentSL]);
 if($temp[0]=='ex') $exc=1;
 else if($temp[0]=='cash') $cash=1;
 else if($temp[0]=='pre') $pre=1;
  else if($temp[0]=='pp') $pp=1; 
    else if($temp[0]=='ss') $ss=1; 
   }//if
  $i++;
  }//while
  ?>
 <? for($i=1;$i<=sizeof($account);$i++){?>
 <tr>
   <td> <? if($amountCRt1==0) echo $account[$i].'<br>'.accountName($account[$i]);?></td>
   <td valign="top"><? echo mydate($date[$i]);?></td>
   <td valign="top"><? $temp=explode('_',$reff[$i]); echo $temp[1];?></td>   
   <td valign="top"> CDJ<?  // echo $re[reff];?></td>      
   <td valign="top" align="left"><? echo $paidTo[$i];?></td> 
   <td></td>      
   <td valign="top" align="right"><? echo number_format($amount[$i],2);?></td>   
 </tr>
 <? 
 $amountCRt1+=$amount[$i];
 $amountCR1+=$amount[$i];
?>
<? 
   //$amountDRt1+=$re[paidAmount];
  if($account[$i]!=$account[$i+1]){
?>
<tr bgcolor='#66CCFF'>
 <td colspan='6' align='right' ><? echo number_format($amountDRt1,2);?></td>
 <td  align='right' ><? echo number_format($amountCRt1,2);?></td>
<td bgcolor="#FFFF99" align="right"><? echo number_format($amountDRt1-$amountCRt1,2)?></td>
</tr>
<tr><td colspan='8' height='3' bgcolor='#FFCC66'></td></tr>
<?  
$amountCRt1=0; $amountDRt1=0;
 }//if

}//for?>


 <tr><td colspan="8" height="3" bgcolor="#FFCC66"></td></tr>

<tr bgcolor="#33CC66">
 <td colspan="5"></td>
 <td align="right"><? 
 $totalDR=$amountDR1+$amountDR2+$amountDR3+$amountDR4+$amountDR5;
 echo number_format($totalDR,2);?></td>
 <td align="right"><? 
 $totalCR=$amountCR1+$amountCR2+$amountCR3+$amountCR4+$amountCR5;
 echo number_format($totalCR,2);?></td>
 <td bgcolor="#FFFF66" align="right"><? echo number_format($totalDR-$totalCR,2)?></td>
</tr>  

</table>
<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
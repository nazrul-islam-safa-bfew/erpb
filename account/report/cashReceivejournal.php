<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>

<form name="cdj" action="./index.php?keyword=cash+receivejournal" method="post">
<table  width="600" align="center" border="0" class="blue" >
 <tr bgcolor="#CCCCFF">
 <td align="right" valign="top" height="30" colspan="4"><font class='englishheadblack'>cash receive journal</font></td>
</tr>

 <tr>
	   <td colspan="4">Project: 
      <select name="pcode" size="1">
	  <option value="%" <? if($pcode=='%') echo ' SELECTED ';?>>Select Project</option>  
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
 <tr><td>Select Type</td>
  <td> <select name="type">
  <option>all</option>
  <option>cash</option>
  <option>bank</option>  
  </select></td>
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
   onClick="cal.select(document.forms['cdj'].fromDate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a>
      </td>
    <td>To </td>
      <td><input type="text" maxlength="10" name="toDate" value="<? echo $toDate;?>" > <a id="anchor2" href="#"
   onClick="cal.select(document.forms['cdj'].toDate,'anchor2','dd/MM/yyyy'); return false;"
   name="anchor2" ><img src="./images/b_calendar.png" alt="calender" border="0"></a>
      </td>
 </tr>

<tr><td colspan="4" align="center"><input type="button" name="go" value="Go" onClick="cdj.submit();"></td></tr>
</table>

</form>
<br>
<br>
<? //echo 'Report for Project: <b>'.myprojectName($pcode).'</b>('.$pcode.') From <b>'.$fromDate.'</b> To <b>'.$toDate.'</b>';?>
<table  width="850" align="center" border="0" cellpadding="5" cellspacing="2" style="font-size: 10px;" >
 <tr bgcolor="#CCFF99">
   <th align="center" valign="top" width="100">Date</th>
   <th align="center" valign="top">Reference</th>
   <th align="center" valign="top" width="200">Account ID</th>   
   <th align="center" valign="top" width="200">Description</th>   
   <th align="right" valign="top" width="100">Debit Amount</th>   
   <th align="right" valign="top" width="100">Credit Amount</th> 
 </tr>
  <tr><td colspan="8" height="3" bgcolor="#FFCC66"></td></tr>
 <?
 
 $fromDate=formatDate($fromDate,'Y-m-j');
 $toDate=formatDate($toDate,'Y-m-j'); 

 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
if($pcode=='000'){
if($type=='cash'){
$sql="SELECT * FROM receivecash 
where receiveAccount LIKE '5501000' 
AND receiveDate BETWEEN '$fromDate' AND '$toDate' ORDER by receiveDate ASC ";	
}
else if($type=='bank'){
$sql="SELECT * FROM receivecash 
where receiveAccount <> '5501000' 
AND receiveDate BETWEEN '$fromDate' AND '$toDate' ORDER by receiveDate ASC ";	
}
else{
$sql="SELECT * FROM receivecash 
where receiveDate BETWEEN '$fromDate' AND '$toDate' ORDER by receiveDate ASC ";	
}

}
else{
$sql="SELECT * FROM receivecash 
where receiveAccount LIKE '5502000' 
AND receiveDate BETWEEN '$fromDate' AND '$toDate' ORDER by receiveDate ASC ";	
}
$sqlq=mysqli_query($db, $sql);
while($re=mysqli_fetch_array($sqlq)){

?>
 <tr>
   <td valign="top"><? echo mydate($re[receiveDate]);?></td>
   <td valign="top"><? echo $re[receiveSL];?></td>   
   <td> <?  echo $re[receiveFrom].'<br>'.accountName($re[receiveFrom]);?></td>
   <td valign="top"><? echo $re[reff];?></td>   
   <td></td>      
   <td valign="top" align="right"><? echo number_format($re[receiveAmount],2); $crtotal+=$re[receiveAmount];?></td> 
 </tr>
 <tr>
   <td valign="top"></td>
   <td valign="top"></td>
   <td> <?  echo $re[receiveAccount].'<br>'.accountName($re[receiveAccount]);?></td>
   <td valign="top"><? echo $re[reff];?></td>  
   <td align="right"> <?  echo number_format($re[receiveAmount],2); $drtotal+=$re[receiveAmount];?></td>
   <td></td>      
 </tr>
   <?
     $drtotal+=$exre[examount];
    }//while 
?>
<tr>
 <td colspan="4"></td>
 <td bgcolor="#FF6600"></td>
 <td bgcolor="#FF6600"></td>
</tr>
<tr>
 <td colspan="6" bgcolor="#FFFFFF"></td>
</tr>
<tr>
 <td colspan="4"></td>
 <td bgcolor="#FF6600"></td>
 <td bgcolor="#FF6600"></td>
</tr>


<tr>
  <td colspan="4" align="right">total</td>
  <td align="right"><? echo number_format($drtotal,2);?>  </td>
  <td align="right"><? echo number_format($crtotal,2);?>  </td>  
</tr>

<tr>
 <td colspan="4"></td>
 <td bgcolor="#FF6600"></td>
 <td bgcolor="#FF6600"></td>
</tr>
<tr>
 <td colspan="6" bgcolor="#FFFFFF"></td>
</tr>
<tr>
 <td colspan="4"></td>
 <td bgcolor="#FF6600"></td>
 <td bgcolor="#FF6600"></td>
</tr>

 </table>
 
 
  <div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
<form name="mr" action="./index.php?keyword=mr+report" method="post">
<table  width="80%" align="center" border="0" class="blue" >
 <tr bgcolor="#CCCCFF">
 <td align="right" valign="top" height="30" colspan="4"><font class='englishheadblack'>MR report</font></td>
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
   onClick="cal.select(document.forms['mr'].fromDate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a>
      </td>
    <td>To </td>
      <td><input type="text" maxlength="10" name="toDate" value="<? echo $toDate;?>" > <a id="anchor2" href="#"
   onClick="cal.select(document.forms['mr'].toDate,'anchor2','dd/MM/yyyy'); return false;"
   name="anchor2" ><img src="./images/b_calendar.png" alt="calender" border="0"></a>
      </td>
 </tr>
<?  if($loginDesignation!='Store Officer'){?>
   <tr>
	   <td >Project: </td>
	   <td colspan="3">
      <select name="pcode" size="1">
<? 
	include("config.inc.php");
	$db =  mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);
		 
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
	} else {

	$pcode=$loginProject;}?> 
 <tr>
   <td>Select Vendor</td>
   <td>
<select name="vid"> 
<option value="">Select Vendor</option>
<?
include("config.inc.php");
$db =  mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);
	 

$sqlp = "SELECT vid, vname from `vendor` ORDER by vname ASC ";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

 while($typel= mysqli_fetch_array($sqlrunp))
{
 echo "<option value='".$typel[vid]."'";
 if($vid==$typel[vid]) echo "SELECTED";
 echo ">$typel[vname]</option>  ";
 }
?>

	 </select>
	</td>

 </tr>
 <tr><td colspan="4" align="center"><input type="button" name="go" value="Go" onClick="mr.submit();"></td></tr>
</table>

<input type="hidden" name="ck" value="1">
</form>
<? if($fromDate AND $toDate){
  $fromDate=formatDate($fromDate,'Y-m-d');
  $toDate=formatDate($toDate,'Y-m-d'); 

?>

<table align="center" width="95%" border="1" bordercolor="#ADA5F8" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<? 
//$sql="SELECT DISTINCT reference,todat,paymentSL from store$pcode WHERE".
$sql="SELECT DISTINCT reference from store$pcode WHERE".
" store$pcode.todat between '$fromDate' ". 
" AND '$toDate'";
if($vid){
 if($vid==5) $sql.=" AND paymentSL like 'EP_%'";
 else if($vid==99) $sql.=" AND paymentSL like 'ST_%'";
 else
 $sql.=" AND paymentSL like 'PO_".$pcode."_______$vid'";

}
$sql.=" ORDER by store$pcode.reference ASC";
// echo $sql.'<br>';
$sqlq=mysqli_query($db, $sql);
while($mr=mysqli_fetch_array($sqlq)){
$tt=1;
?>
<!--<tr bgcolor="#D2D2FF">
 <th height="30">Date</th>
 <th>MR no</th>
 <th>Posl</th>
</tr>
-->

<? $sql1="SELECT * from store$pcode WHERE".
" reference='$mr[reference]'
AND paymentSL like 'PO_".$pcode."_______$vid'
 ORDER by store$pcode.itemCode ASC";

// echo $sql1.'<br>';
$sqlq1=mysqli_query($db, $sql1);
while($st=mysqli_fetch_array($sqlq1)){
$temp=itemDes($st[itemCode]);
?>
<? if($tt==1){?>
<tr bgcolor="#D2D2FF">
<td colspan="2" ><? echo '<font class=out>'.myDate($st[todat]).'</font>';?>;
<? $p=explode('_',$st[paymentSL]);
if($p[0]=='PO') 
	{ 
	$vtemp=vendorName($p[3]);

	echo viewPosl($st[paymentSL]).' '.$vtemp[vname];
	}
elseif($p[0]=='ST') echo $st[paymentSL].' Store transfer from center store';	
else echo $st[paymentSL].' Emergency Purchase';	
?>
</td>
<th align="center" ><a target="_blank" href="./print/print_mrReport.php?mrreference=<? echo $mr[reference];?>&mrDate=<? echo $mr[todat];?>&mrpaymentSL=<? echo $mr[paymentSL];?>&project=<? echo $pcode;?>">
<? echo $mr[reference];?></a></th>
</tr>
<? $tt=0;}///if tt
?>
<tr>
  <td><? echo $st[itemCode].' '.$temp[des].', '.$temp[spc];  ?></td>      
  <td align="right"><? echo number_format($st[receiveQty],3).' '.$temp[unit];?></td>   
  <td align="right"><? $subAmount=$st[receiveQty]*$st[rate]; echo number_format($subAmount,2);
  $totoalAmount=$totoalAmount+$subAmount;  
  $subAmount=0;
  ?></td>          

</tr>
<? }?>

<tr bgcolor="#FFFFCC">
 <td colspan="3" align="right"> Total Amount: <? echo number_format($totoalAmount,2);?></td>
</tr>

<?
 $gtotoalAmount+=$totoalAmount;
 $totoalAmount=0;

}//while?>

<tr bgcolor="#DFFFDF">
 <td colspan="3" align="right" height="30"> Total Amount: <? echo number_format($gtotoalAmount,2);?></td>
</tr>

</table>
<? }//if date?>

<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>

<a target="_blank" href="./print/print_mrReport_all.php?fromDate=<? echo $fromDate;?>&toDate=<? echo $toDate;?>">Print</a>


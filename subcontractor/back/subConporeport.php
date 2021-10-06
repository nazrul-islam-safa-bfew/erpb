<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
<form name="mr" action="./index.php?keyword=subCon+poreport" method="post">
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
		cal.offsetY = -150;

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
 <tr>
   <td>Select Vendor</td>
   <td>
<select name="vid"> 
<option value="">Select Vendor</option>
<?
include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);

$sqlp = "SELECT vid, vname from `vendor` ORDER by vname ASC ";
//echo $sqlp;
$sqlrunp= mysql_query($sqlp);

 while($typel= mysql_fetch_array($sqlrunp))
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
//$sql="SELECT DISTINCT reference,todat,paymentSL from store$loginProject WHERE".
$sql="SELECT DISTINCT posl from subut WHERE pcode='$loginProject' AND 
 subut.edate between '$fromDate'  AND '$toDate'";
if($vid){
 $sql.=" AND posl like 'PO_".$loginProject."_______$vid'";
}
$sql.=" ORDER by posl ASC";
//echo $sql.'<br>';
$sqlq=mysql_query($sql);
while($mr=mysql_fetch_array($sqlq)){
$tt=1;
$p=explode('_',$mr[posl]);
$vtemp=vendorName($p[3]);
?>

<? $sql1="SELECT * from subut WHERE".
" posl='$mr[posl]' ORDER by edate,itemCode ASC";

//echo $sql1.'<br>';
$sqlq1=mysql_query($sql1);
while($st=mysql_fetch_array($sqlq1)){
$temp=itemDes($st[itemCode]);
?>
<? if($tt==1){?>
<tr bgcolor="#D2D2FF">
<td colspan="4" ><? echo viewPosl($st[posl]).' '.$vtemp[vname];?>
</td>
<th align="center" ><a target="_blank" href="./print/print_mrReport.php?mrreference=<? echo $mr[reference];?>&mrDate=<? echo $mr[todat];?>&mrpaymentSL=<? echo $mr[paymentSL];?>&project=<? echo $loginProject;?>">
<? echo $mr[reference];?></a></th>
</tr>
<? $tt=0;}///if tt
?>
<tr <? if($c%2==0) echo "bgcolor='#EEEEEE'";?>>
  <td colspan="2" ><? echo '<font class=out>'.myDate($st[edate]).'</font>';?></td>
  <td><? echo $st[itemCode].' '.$temp[des].', '.$temp[spc];  ?></td>      
  <td align="right"><? echo number_format($st[qty],3).' '.$temp[unit];?></td>   
  <td align="right"><? $subAmount=$st[qty]*$st[rate]; echo number_format($subAmount,2);
  $totoalAmount=$totoalAmount+$subAmount;  
  $subAmount=0;
  ?></td>          

</tr>
<? $c++;}?>

<tr bgcolor="#FFFFCC">
 <td colspan="5" align="right"> Total Amount: <? echo number_format($totoalAmount,2);?></td>
</tr>

<?
 $gtotoalAmount+=$totoalAmount;
 $totoalAmount=0;

}//while?>

<tr bgcolor="#DFFFDF">
 <td colspan="5" align="right" height="30"> Total Amount: <? echo number_format($gtotoalAmount,2);?></td>
</tr>

</table>
<? }//if date?>

<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>

<a target="_blank" href="./print/print_mrReport_all.php?fromDate=<? echo $fromDate;?>&toDate=<? echo $toDate;?>">Print</a>


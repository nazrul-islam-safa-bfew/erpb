<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="./js/myValidation.js"></SCRIPT>
	
<form name="issue" action="./store/site_issue.sql.php" method="post"  >
	<SCRIPT LANGUAGE="JavaScript">
	var now = new Date(); 
	var cal = new CalendarPopup("testdiv1");
    	//cal.showNavigationDropdowns();
		cal.setWeekStartDay(6); // week is Monday - Sunday
		//cal.addDisabledDates(null,formatDate(now,"yyyy-MM-dd")); 
		cal.setCssPrefix("TEST");		
		cal.offsetX = 0;
		cal.offsetY = 0;		
	</SCRIPT>
Issue Date: 
 <input class="yel" type="text" maxlength="10" name="edate"  value="<? echo $edate;?>" alt="req" title="Issue Date" > <a id="anchor" href="#"
   onClick="cal.select(document.forms['issue'].edate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 

<br>

Select Item: <select name="itemCode" onChange="location.href='index.php?keyword=issue&itemCode='+issue.itemCode.options[document.issue.itemCode.selectedIndex].value+'&edate='+document.issue.edate.value">
<option value="">Select one</option>
<?
$i=1;
include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sqlp = "SELECT distinct store$loginProject.itemCode,itemlist.itemDes, itemlist.itemSpec from `store$loginProject`, itemlist WHERE store$loginProject.itemCode=itemlist.itemCode AND currentQty<>0 ORDER by store$loginProject.itemCode ASC";

$sqlrunp= mysql_query($sqlp);

 while($typel= mysql_fetch_array($sqlrunp))
{
 echo "<option value='".$typel[itemCode]."'";
 if($itemCode==$typel[itemCode]) echo "SELECTED";
 echo ">$typel[itemCode] $typel[itemDes], $typel[itemSpec]</option>  ";
 }
?>
	</select>
<? echo '  Quantity at Hand: ';
$qtyatHand=qtyatHand($itemCode,$loginProject);
echo $qtyatHand;
$temp=itemDes($itemCode);
echo ' '.$temp[unit];
?>	
<br>
<br>
<table  align="center" width="98%" border="3" bordercolor="#AAAADD" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#AAAADD">
 <th>SIOW Code</th>
 <th>Description</th>
 <th>Quantity Approved</th>
 <th>Quantity Issued</th>
 <th>Current Issue Qty</th>
</tr>
<? 
include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sqlp1 = "SELECT * from dma WHERE dmaItemCode='$itemCode' AND dmaProjectCode='$loginProject'";
//echo $sqlp1;
$sqlrunp1= mysql_query($sqlp1);
$i=1;
 while($re= mysql_fetch_array($sqlrunp1)){
?>
 <tr>
 <td><? echo viewiowCode($re[dmaiow]).viewsiowCode($re[dmasiow]);?>
 <input type="hidden" name="iowId<? echo $i;?>" value="<? echo $re[dmaiow];?>">
 <input type="hidden" name="siowId<? echo $i;?>" value="<? echo $re[dmasiow];?>"> 
 </td>
 <td><? echo siowName($re[dmasiow]);?></td>
 <td align="right"><? echo $re[dmaQty].' '.$temp[unit];?></td>
 <td align="right"><? 
 $qtyissued= qtyissued($itemCode,$loginProject,$re[dmaiow],$re[dmasiow]).' '.$temp[unit];
 echo $qtyissued;
 $remainQty=$re[dmaQty]-$qtyissued;
 ?></td>
 <td align="right"><input type="text" name="issuedQty<? echo $i;?>" onBlur="if(this.value><? echo $qtyatHand?> || this.value><? echo $remainQty?>) {alert('Your Given value is more then Qty at hand OR Approved Qty!! '); this.value='';}"></td> 
 </tr>
<? $i++; }?>
<tr><td align="center" colspan="5"> <input type="button" value="Save" name="issueSave" onClick="if(checkrequired(issue)) {issue.submit();}"></td></tr>
<input type="hidden" name="n" value="<? echo $i;?>">
</table>
</form>

<div id=testdiv1
      style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
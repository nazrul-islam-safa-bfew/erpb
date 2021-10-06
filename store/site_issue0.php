<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
	
<?
$supervisor=$loginUname;
echo "<br>Supervisor Id:$supervisor<br>";
?>	
	<script>
function issuedexceed(k,qtyathnd){
//alert('aaa'+k);
var total=0;

var val=0;
for(var i=1;i<k;i++ ){
//alert(i);
var id = "issuedQty" + i;
var elm = document.getElementById(id);
//alert(elm);
//alert(elm.value);
 val = parseInt(elm.value);
// alert(val);			
/* if (isNaN(elm.value)==false) 
 val=0;*/
 if(val>0) total=total+val;
// alert(val);
}
//alert('total'+total);
//alert('qt'+qtyathnd);
if(total>qtyathnd) { alert(' Your Given value is more then Qty at hand!!');return 0;}
else return 1;
}
</script>	
<? if($edate) $ed=formatDate($edate,'Y-m-d');?>
<form name="issue1" onSubmit="return checkrequired(issue1);" action="./index.php?keyword=issue" method="post"  >
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

Select IOW: <select name="siow"> <option value="">All IOW</option>
<?
include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sqlp = "SELECT iow.iowId,iowCode,siowId,siowName from `iow`,siow
 WHERE iowProjectCode='$loginProject'
 AND supervisor='$supervisor' AND iowStatus <> 'Not Ready' AND siow.iowId=iow.iowId";

$sqlrunp= mysql_query($sqlp);

 while($typel= mysql_fetch_array($sqlrunp))
{
 echo "<option value='".$typel[siowId]."'";
 if($siow==$typel[siowId]) echo " selected ";
 echo ">$typel[iowCode]--$typel[siowName]</option>  ";
 }?>
 </select>
<? //echo $sqlp;?>
Issue Date: 
 <input class="yel" type="text" maxlength="10" name="edate"  value="<? echo $edate;?>" alt="req" title="Issue Date" readonly="" > <a id="anchor" href="#"
   onClick="cal.select(document.forms['issue1'].edate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 

<br>
<input type="submit" name="btn_issue" value="Search">
</form>
<br>
<br>
<form name="iss" action="./store/site_issue.sql.php" method="post">
<table align="center" width="90%" border="0" style="border-collapse:collapse" cellspacing="1">
<tr bgcolor="#0066FF">
 <th height="30"><font class="englishheadsmall">ItemCode</font></th>
 <th><font class="englishheadsmall">At hand Qty</font></th> 
 <th><font class="englishheadsmall">Approved Qty</font></th> 
 <th><font class="englishheadsmall">Issued Qty</font></th> 
 <th><font class="englishheadsmall">Issue Qty</font></th>   
</tr>
<? 
$i=1;
$sql="SELECT * from dma where dmasiow='$siow' AND 
dmaItemCode between '00-00-000' AND '49-99-999' 
ORDER by dmaItemCode ASC";
//echo "$sql<br>";
$sqlq=mysql_query($sql);
while($re=mysql_fetch_array($sqlq)){
$siow=$re[dmasiow];
$iow=$re[dmaiow];

$qtyatHand=qtyatHand($re[dmaItemCode],$loginProject,$ed);

$qtyissued= qtyissued($re[dmaItemCode],$loginProject,$re[dmaiow],$re[dmasiow]);
$remainQty=$re[dmaQty]-$qtyissued;
$ck=isExpiredSIOW($re[dmasiow],$ed);
//echo " $re[dmaItemCode]=$qtyatHand<br>";
//echo " $re[dmaItemCode]=$remainQty<br>";
if($remainQty>0){

$temp=itemDes($re[dmaItemCode]);


?>
<tr>
 <td><? echo $re[dmaItemCode];?>
 <input type="hidden" name="itemCode<? echo $i;?>" value="<? echo $re[dmaItemCode];?>" />
  <? echo ' '.$temp[des].', '.$temp[spc];?>
  </td>
  
 <td align="right"><? echo number_format($qtyatHand,3);?> <? echo ' '.$temp[unit];?> </td>
  
 <td align="right"><? echo number_format($re[dmaQty],3);?> <? echo ' '.$temp[unit];?>
  <input type="hidden" name="dmaQty<? echo $i;?>" value="<? echo $re[dmaQty];?>">  
 </td>
 <td align="right"><? echo number_format($qtyissued,3);?> <? echo ' '.$temp[unit];?></td> 
 <td align="right"><? if($ck) echo "<font class=out> Completion Date Expired.</font>";
 elseif($qtyatHand<=0) echo "<font class=outg> There is no Qty at hand.</font>";
 else {?><input type="text" name="issuedQty<? echo $i;?>" onblur="if(this.value><? echo $remainQty;?> || this.value><? echo $qtyatHand;?>){ alert('Exceding!!!!'); this.value=0;}" >  <? echo ' '.$temp[unit];?><?  }?>
 </td>   
</tr>
<tr><td colspan="6" bgcolor="#CCCCCC" height="1"></td></tr>
<? $i++;
}
 }

?>
<tr>
 <td colspan="6" align="center">
	<input type="hidden" name="edate" value="<? echo $edate;?>" />
	<input type="hidden" name="n" value="<? echo $i;?>" />
	<input type="hidden" name="iow" value="<? echo $iow;?>" />	
	<input type="hidden" name="siow" value="<? echo $siow;?>" />	
	<input type="button" name="save" value="Save" onclick="iss.submit();" /></td>
</tr>
</table>
</form>
<div id=testdiv1
      style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
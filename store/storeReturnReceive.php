<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>

<? 
$edate1=formatDate($edate, 'Y-m-d');
//echo "N=$n";
for($i=1;$i<=2;$i++){
	if(${ck.$i}){
		$sql="UPDATE storet set currentQty=0 where rsl='$rsl' and itemCode='${ck.$i}'";
		//echo "$sql<br>";
		mysqli_query($db, $sql);
		$sql2="INSERT INTO store (rsid,itemCode,receiveQty,currentQty,rate,receiveFrom,reference,remark,sdate) ".
		" values ('','${ck.$i}','${qty.$i}','${qty.$i}','${rate.$i}','$receiveFrom','$rsl','${remark.$i}','$edate1')";
		//echo "$sql2<br>";
		mysqli_query($db, $sql2);
	}
}

?>

<form name="sreturn" action="./index.php?keyword=store+return+receive" method="post">
<table align="center" width="400" border="3"  bordercolor="CC9999" cellpadding="2" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td colspan="2" align="right" valign="top"><font class='englishhead'>material receive form</font></td>
</tr>
<tr>
<td>Refference : <select name="rsl2" onChange="location.href='index.php?keyword=store+return+receive&rsl='+sreturn.rsl2.options[document.sreturn.rsl2.selectedIndex].value">
<option value="">Select one</option>
<?
$i=1;
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);
	
//$sqlp = "SELECT distinct posl from `porder` WHERE posl LIKE 'PO_".$loginProject."_%'  AND status=1";
$sqlp = "SELECT distinct rsl,edate from `storet` WHERE currentQty > 0";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

 while($typel= mysqli_fetch_array($sqlrunp))
{
 echo "<option value='".$typel[rsl]."'";
 if($rsl==$typel[rsl]) echo " SELECTED";
 echo ">".$typel[rsl].'-'.mydate($typel[edate])."</option>  ";
 }
?>
	</select>
	
</td>
<td>
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
<input class="yel" type="text" maxlength="10" name="edate"  value="<? echo $edate;?>"> <a id="anchor" href="#"
   onClick="cal.select(document.forms['sreturn'].edate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> </td>
</tr>
</table>

<br>
<br>
<table width="90%" align="center" border="1" bordercolor="#CCCCCC" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#EEEEEE">
 <th height="35">ItemCode</th>
 <th>Description</th> 
 <th>Unit</th>
 <th>Quality</th>
 <th>Quantity</th>
</tr>
<? 
$i=1;
include("./config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);
	
$sql="SELECT SUM(currentQty) as currnetQty,itemCode,remark,rate,returnFrom from storet WHERE currentQty > 0 AND rsl='$rsl' GROUP by ItemCode";
//echo $sql;	
$sqlq=mysqli_query($db, $sql);
while($re=mysqli_fetch_array($sqlq)){
$temp=itemDes($re[itemCode]);
?>
<tr>
	<td><? echo $re[itemCode];?></td>
	<td><? echo $temp[des].', '.$temp[spc];?></td>
	<td align="center"><? echo $temp[unit];?></td>
	<td align="center"><? echo $re[remark];?>
	<input type="hidden" name="remark<? echo $i;?>" value="<? echo $re[remark];?>">
	</td>
	<td align="right"><? echo number_format($re[currnetQty],3);?>
	<input type="hidden" name="qty<? echo $i;?>" value="<? echo $re[currnetQty];?>">
	<input type="hidden" name="rate<? echo $i;?>" value="<? echo $re[rate];?>">		
	<input type="checkbox" name="ck<? echo $i;?>" value="<? echo $re[itemCode];?>">
	</td>

	
</tr>
<? 
$returnFrom=$re[returnFrom];
$i++;}?>
<tr><td colspan="6" align="center">
<input type="hidden" name="rsl" value="<? echo $rsl;?>">
<input type="hidden" name="receiveFrom" value="<? echo $returnFrom;?>">
<input type="hidden" name="n" value="<? echo $i;?>">
<input type="button" name="save" value="Save" onClick="sreturn.submit();">
</td></tr>
</table>

</form>
<div id=testdiv1
      style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
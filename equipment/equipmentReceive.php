<?
if($Receive){
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$dat=formatDate($edate,"Y-m-d");
	for($i=0;$i<$n;$i++){	
		if(${chk.$i}){$sqlp = "UPDATE `eqproject` set dispatchDate='$dat',dispatch='$dispatchTxt',status=3 WHERE id=${chk.$i}";
		//echo $sqlp.'<br>';
		mysqli_query($db, $sqlp);
		}
	}
}
 ?>

	<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>

<form name="eq" action="./index.php?keyword=equipment+receive&e=<? echo $e;?>" method="post">
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

<table align="center" width="95%" border="3"  bordercolor="CC9999" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
<td >
Receive Date: 
 <input class="yel" type="text" maxlength="10" name="edate"  value="<? echo $edate;?>"> <a id="anchor" href="#"
   onClick="cal.select(document.forms['eq'].edate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
 </td>
</tr>

<tr>
 <td >
<table align="center" width="100%" border="1"  bordercolor="CC9999" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr>
  <th>Posl</th>
  <th width="100">Equipment ID</th>
  <th >Equipment Description</th>
</tr>
<? 

$dat=formatDate($edate,"Y-m-d");

include("./config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$sql = "SELECT * FROM eqproject WHERE status='2' AND reff LIKE 'EQT_%' ORDER BY posl asc";
//echo $sql;
//echo $loginProject;
$sqlq = mysqli_query($db, $sql);
$i=0;
while($re=mysqli_fetch_array($sqlq)){
if($re[assetId]{0}!='A')  {
?>
<tr>
  <td><? echo viewPosl($re[posl]);?></td>
  <td><input type="checkbox" name="chk<? echo $i;?>" value="<? echo $re[id];?>">
<? if($re[assetId]{0}=='A')  { echo eqpId_local($re[assetId],$re[itemCode]); $type='L';}
		else {echo eqpId($re[assetId],$re[itemCode]); $type='H'; }
 ?> 	   
</td>
  <td > <?
  $temp = itemDes($re[itemCode]); echo $temp[des].', '.$temp[spc];
  ?>
   </td>

</tr>

<? 

$i++; 
}} //while?>
<tr><td colspan="4">Challan No. & Delivary Details: <input type="text" name="dispatchTxt" width="100" size="100"></td></tr>
</table>
</td>
</tr>

<input type="hidden" name="n" value="<? echo $i;?>">
</table>
<p align="center"><input  type="submit" name="Receive" value="Received"></p>
</form>
<div id=testdiv1
      style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
<script>
	function countCh(form,cho,chn,c) {
	var total = 0;
	//var chname=chn.name;
	//alert(chn.name);
	//alert(chn.length);
	var chname=cho.name;
	for(var idx = 0; idx<chn.length ; idx++){
		if (eval("document.eqtt."+chname+"[" + idx + "].checked") == true){
			total += 1;
			 if(total>c){
					 alert('You are tyring to give more than the requirement'); 
					 box = eval("document.eqtt."+chname+"[" + idx + "]"); 
					 if (box.checked == true) box.checked = false;
					 break; 
				 }
			 }
		}
	}
</script>
<form name="eqt" action="#" method="post">
<table align="center" width="400" border="3"  bordercolor="CC9999" cellpadding="2" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td colspan="2" align="right" valign="top"><font class='englishhead'>material transfer form</font></td>
</tr>
<tr>
<td>PO Ref.: <select name="sposl" onChange="location.href='index.php?keyword=store+transfer&posl='+eqt.sposl.options[document.eqt.sposl.selectedIndex].value">
<option value="">Select one</option>
<?
$i=1;
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);
	
//$sqlp = "SELECT distinct posl from `porder` WHERE posl LIKE 'PO_".$loginProject."_%'  AND status=1";
$sqlp = "SELECT distinct posl from `porder` WHERE posl LIKE 'PO_$loginProject%_99' AND status=1";
//echo $sqlp;
$sqlrunp= mysqli_query($db,  $sqlp);

 while($typel= mysqli_fetch_array($sqlrunp))
{
 echo "<option value='".$typel[posl]."'";
 if($posl==$typel[posl]) echo "SELECTED";
 echo ">".viewPosl($typel[posl])."</option>  ";
 }
?>
</select>
	
<? 
//echo $sqlp;
if($posl){
$temppo=explode("_",$posl);
$tempp= myprojectName($temppo[1]);
echo "For $tempp";
$eqtsl=$temppo[2];
}?>	
</td>
</tr>
</table>
</form>

<br><br>

<form name="eqtt" action="./store/storeTransferForm.sql.php?posl=<? echo $posl;?>" method="post">
<table align="center" width="90%" border="3"  bordercolor="CC9999" cellpadding="2" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
<td colspan="2">
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

Transfer Date: 
 <input class="yel" type="text" maxlength="10" name="edate"  value="<? echo $edate;?>"> <a id="anchor" href="#"
   onClick="cal.select(document.forms['eqtt'].edate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
</td>
<td colspan="2">Transfer SL#: <? /*$eqtsl= "MT_$loginProject_$temppo[1]_0001"; echo $eqtsl; */?>
 <input  type="text" name="eqtsl" value="<? echo $eqtsl;?>">
 </td>

 <td colspan="3" align="right" valign="top"><font class='englishhead'>material transfer form</font></td>
</tr>
<tr>
 <th width="100">Code</th>
 <th>description</th>
 <th width="100">unit</th> 
 <th>stock at hand</th> 
 <th>Po Qty.</th> 
 <th>Remaining Qty.</th>  
 <th>delivery Qty.</th> 
</tr>
<?
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);
	
$sqlp12 = "SELECT porder.* from `porder` WHERE posl='$posl' AND status=1 ";
//echo $sqlp12;
$sqlrunp12= mysqli_query($db,  $sqlp12);
$i=1;
 while($typel12= mysqli_fetch_array($sqlrunp12))
{
$temp=itemDes($typel12[itemCode]);
$remainQty = remainQty_storet($posl,$typel12[itemCode],$temppo[1]);?>
 <tr <? if($i%2==0) echo " bgcolor=#FFDDDD";?> >
    <td width="100" align="center"><? echo $typel12[itemCode];?> 	
    <input  type="hidden" name="itemCode<? echo $i;?>" value="<? echo $typel12[itemCode];?>">
	<input  type="hidden" name="rate<? echo $i;?>" value="<? echo $typel12[rate];?>">		
	</td>
    <td > <? echo $temp[des].', '.$temp[spc]; ?> </td>
    <td align="center" > <? echo $temp[unit]; ?> </td>	
	<td align="right"><? echo number_format(cstore_stock_athand($typel12[itemCode]),3);?></td>
	<td align="right"><? echo $typel12[qty];?></td>
	<td align="right"><? echo number_format($remainQty,3);?>
	<input type="hidden" name="remainQty<? echo $i;?>" value="<? echo $remainQty;?>" size="12">
	</td>
    <td align="right"> <input type="text" name="dqty<? echo $i;?>"></td>
</tr>
<input  type="hidden" name="m<? echo $i;?>" value="<? echo $j?>">
<?  $i++; } //while?>
</table>
  <input type="submit" value="Save" name="Save">
<input  type="hidden" name="n" value="<? echo $i?>">
<input  type="hidden" name="project" value="<? echo $temppo[1];?>">
<input  type="hidden" name="vid" value="<? echo $temppo[3];?>">
</form>
<div id=testdiv1
      style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
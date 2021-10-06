<? $posl=$_GET[posl]; ?>
	<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
<script>
function countCh(form,cho,chn,c,ch) {
var total = 0;
//var chname=chn.name;
//alert(chn.name);
//alert(chn.length);
var chname=cho.name;
for (var idx = 0; idx<chn.length ; idx++) {
	if(eval("document.eqtt."+chname+"[" + idx + "].checked") == true){
		total += 1;
		ch.value=1;
	   if(total>c) {
		   alert('You are tyring to give more than the requirement'); 
		   box = eval("document.eqtt."+chname+"[" + idx + "]"); 
		   if (box.checked == true) {box.checked = false; ch.value=0; }
		   break; 
		 }
	}


}
}
</script>
<form name="eqt" action="#" method="post">
<table align="center" width="400" border="3"  bordercolor="CC9999" cellpadding="2" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td colspan="2" align="right" valign="top"><font class='englishhead'>equipment transfer form</font></td>
</tr>
<tr>
<td>PO Ref.: <select name="sposl" onChange="location.href='index.php?keyword=equipment+transfer&posl='+eqt.sposl.options[document.eqt.sposl.selectedIndex].value">
<option value="">Select one</option>
<?
$i=1;
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
//$sqlp = "SELECT distinct posl from `porder` WHERE posl LIKE 'PO_".$loginProject."_%'  AND status=1";
$sqlp = "SELECT distinct posl from `porder` WHERE posl LIKE 'EQ_%_85' AND status=1";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

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
}?>	
</td>
</tr>
</table>
</form>

<br><br>

<form name="eqtt" action="./equipment/equipmentTransfer.sql.php?posl=<? echo $posl;?>" method="post">
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
        Transfer Date:<br> 
        <input class="yel" type="text" maxlength="10" name="edate"  value="<? echo $edate;?>" readonly="">
        <a id="anchor" href="#"
   onClick="cal.select(document.forms['eqtt'].edate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
      </td>
<td>Transfer SL#: <?
$sln=eq_transferSL();
$eqtsl= "EQT_$temppo[1]_$sln";
 echo $eqtsl; ?>
 <input  type="hidden" name="eqtsl" value="<? echo $eqtsl;?>">
 </td>

 <td colspan="3" align="right" valign="top"><font class='englishhead'>equipment transfer form</font></td>
</tr>
<?
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp12 = "SELECT porder.* from `porder` WHERE posl='$posl' AND status=1 ";
// echo $sqlp12;
$sqlrunp12= mysqli_query($db, $sqlp12);
$i=1;
 while($typel12= mysqli_fetch_array($sqlrunp12))
{
$temp=itemDes($typel12[itemCode]);
$remainQty = eqremainQty($posl,$typel12[itemCode],$loginProject);
if($remainQty){
 ?>
 <tr bgcolor="#FFDDDD">
    <td width="100"><? echo $typel12[itemCode];?> 
      <input  type="hidden" name="itemCode<? echo $i;?>" value="<? echo $typel12[itemCode];?>">
	<input  type="hidden" name="rate<? echo $i;?>" value="<? echo $typel12[rate];?>">	
	</td>
    <td colspan="2"> <? echo $temp[des].', '.$temp[spc]; ?> </td>
	<td align="right">Delivery deadline: <? echo myDate($typel12[dstart]);?></td>
    <td align="right"> <input type="hidden" name="remainQty<? echo $i;?>" value="<? echo $remainQty;?>" size="12">
	<? echo $remainQty;?> <? echo $temp[unit];?>	</td>
</tr>
<tr>
  <td colspan="5" bgcolor="#FFDDDD">Delivery Details: <? echo $typel12[deliveryDetails];?> </td>
</tr>
<tr >
 <th align="center" >Asset Id</th>
 <th align="center" colspan="3" >Asset Description</th> 
 <th align="center" >Location</th>   
</tr>

<?  

 $sql="SELECT equipment.* FROM equipment 
 WHERE itemCode = '$typel12[itemCode]' 
 AND location='004' AND `condition` IN ('1','5')";
//  echo $sql;
 $sqlq=mysqli_query($db, $sql);  
 $j=1;   
  while($eq= mysqli_fetch_array($sqlq)){
?>

<tr >
<td align="center" width="200" >
<input type="checkbox" name="ckbox<? echo $i;?>"  value="0"
onClick="countCh(eqtt,this,ckbox<? echo $i.','.$remainQty;?>,<? echo 'pch'.$i.'_'.$j;?>); if(this.checked== true){<? echo 'pch'.$i.'_'.$j;?>.value=1; }else <? echo 'pch'.$i.'_'.$j;?>.value=0 ">
<input type="hidden" name="<? echo 'pch'.$i.'_'.$j;?>" value="0">
<? echo eqpId($eq[assetId],$eq[itemCode]);?>
<input type="hidden" name="<? echo 'assetId'.$i.'_'.$j;?>" value="<? echo $eq[assetId];?>">
</td>
 <td colspan="3" >
 <? $temp=explode('_',$eq[teqSpec]);
$model=$temp[0];
$brand=$temp[1];
$manuby=$temp[2];
$madein=$temp[3];
$speci=$temp[4];
$designCap=$temp[5];
$currentCap=$temp[6];
$yearManu=$temp[7];
?>

 <? if($model) echo 'Model <font class=out>'.$model.'</font>; ';
	if($brand) echo 'Brand <font class=out>'.$brand.'</font>; ';
    if($manuby) echo 'Manufactured by <font class=out>'.$manuby.'</font>; ';
 	if($madein) echo 'Made in <font class=out>'.$madein.'</font>; ';
	if($specin) echo 'Specification <font class=out>' .$specin.'</font>; ';
	if($designCap) echo 'Design Capacity <font class=out>'.$designCap.'</font>; '; 
	if($currentCap) echo 'Current Capacity <font class=out>'.$currentCap.'</font>; ';
	if($yearManu) echo 'Year of Manufacture  <font class=out>'.$yearManu.'</font>; '; 
 
 ?>
 
 </td>
 <td align="center"><? echo $eq[location];?></td>
</tr>
<?  $j++;?>
<input  type="hidden" name="m<? echo $i;?>" value="<? echo $j?>">

<? 
 } //while
$i++;
}
} //while

?>

</table>
<p align="center">
<input type="submit" value="Equipment Dispatched" name="Save"></p>
<input  type="hidden" name="n" value="<? echo $i?>">
<input  type="hidden" name="pCode" value="<? echo $temppo[1];?>">

</form>
<div id=testdiv1
      style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
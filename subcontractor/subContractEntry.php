<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>

<? 

$format="Y-m-j";
$edat1 = formatDate($edat,$format);
?>
<form name="subut" action="#" method="post">
<table align="center" width="95%" border="3"  bordercolor="CC9999" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
<td align="left" >
<? 
if($loginUname=='s000'){?>
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
	<input type="text" maxlength="10" name="edat" value="<? echo $edat;?>"> 
        <a id="anchor" href="#"
   onClick="cal.select(document.forms['subut'].edat,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
      <? 
$ex = array('Select one','');
echo selectPlist('project',$ex,$project);
?>
      <input type="button" name="go" value="Go" onClick="location.href='./index.php?keyword=sub+con+pro+entry&edat='+document.subut.edat.value+'+&project='+document.subut.project.value">
<? } else { $project=$loginProject;?>
   	<? if($edat==date("d/m/Y",(strtotime($todat)-86400))) {$t2='checked'; $t1='';}
	  else {$edat=date("d/m/Y",strtotime($todat)); $t1='checked'; $t2='';}
	  //else {$err=1;}
	?>
	<input type="radio" name="sd" value="<? echo date("d/m/Y",strtotime($todat));?>"  onClick="edat.value=this.value;" <? echo $t1;?>> Today, <? echo date("D, d/m/Y",strtotime($todat));?>	
    <input type="radio" name="sd" value="<? echo date("d/m/Y",(strtotime($todat)-86400));?>" onClick="edat.value=this.value;"  <? echo $t2;?>> Yesterday, <? echo date("D, d/m/Y",(strtotime($todat)-86400));?>

   <input type="hidden" maxlength="10" name="edat" value="<? if($edat) echo $edat; else echo date("d/m/Y",strtotime($todat));?>" >

        <input type="button" name="go" value="Go" onClick="location.href='./index.php?keyword=sub+con+pro+entry&edat='+document.subut.edat.value"> 
   <? $project=$loginProject; }?>
      </td>
      <td align="right" colspan="4" ><font class='englishhead'>sub contractor progress attendance</font></td>
    </tr>
	<? if($edat AND $err==0){ //echo $edat;?>
<tr>
<th>Vendor</th>
<th>ItemCode</th>
<th>Unit</th>
<th>PO Qty.</th>
<th>PO Remain Qty</th>
</tr>
<? 

$sql="SELECT * from porder where status='1' AND 
itemCode between '99-00-000' AND '99-99-999' AND location='$project'
 ORDER by itemCode ASC";
//echo $sql;
$sqlq=mysql_query($sql);
$i=1;
while($sb=mysql_fetch_array($sqlq)){
$temp=itemDes($sb[itemCode]);
?>
<tr <? if($i%2==0) echo ' bgcolor=#EEDDDD';?> >
 <td> <? echo viewPosl($sb[posl]);
 $temppo=explode("_",$sb[posl]);
$tempv=vendorName($temppo[3]);
echo '<br>'.$tempv[vname];
 ?></td>
 <td valign="top"> <? echo $sb[itemCode];?><br> <? echo $temp[des].', '.$temp[spc];?></td>  
 <td valign="top" align="center"> <? echo $temp[unit];?></td>   
 <td valign="top" align="right">
  <? echo number_format($sb[qty],3);?></a></td>
 <td valign="top" align="right"><? $subWork_Po=subWork_Po($sb[itemCode],$sb[posl]);
   $poRemain=$sb[qty]-$subWork_Po;?>
<a target="_blank" href="./subcontractor/subConUtilization.php?&itemCode=<? echo $sb[itemCode];?>&posl=<? echo $sb[posl];?>&edate=<? echo $edat;?>&rate=<? echo $sb[rate];?>&poremain=<? echo $poRemain;?>">
<?   echo number_format($poRemain,3); ?></a></td>	
</tr>
<? $i++; }?>

	<? } else echo '<tr><td colspan=3><dir align=center>'.inerrMsg('You are trying to do Illegal thing!!').'</dir></td></tr>';?>
</table>
</form>
<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
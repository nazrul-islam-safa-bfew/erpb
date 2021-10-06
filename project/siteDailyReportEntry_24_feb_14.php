	<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
<? include('./project/siteDailyReportEntry.f.php');?>	
<form name="goo" action="./index.php?keyword=site+daily+report+entry"	 method="post">

<table align="center" width="98%" border="1" bordercolor="#99CC99" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
<tr>
      <td colspan="2" >		
   	<? 
	if($edate2==date("d/m/Y",(strtotime($todat)-86400))) {$t2='checked'; $t1='';}
	  else {$edate2=date("d/m/Y",strtotime($todat)); $t1='checked'; $t2='';}
	  //else {$err=1;}
	?>
	<input type="radio" name="sd" value="<? echo date("d/m/Y",strtotime($todat));?>"  onClick="edate2.value=this.value;" <? echo $t1;?>> Today, <? echo date("D, d/m/Y",strtotime($todat));?>	
    <input type="radio" name="sd" value="<? echo date("d/m/Y",(strtotime($todat)-86400));?>" onClick="edate2.value=this.value;"  <? echo $t2;?>> Yesterday, <? echo date("D, d/m/Y",(strtotime($todat)-86400));?>

   <input type="hidden" maxlength="10" name="edate2" 
   value="<? if($edate2) echo $edate2; else echo date("d/m/Y",strtotime($todat));?>" >

<input type="submit" name="go" value="Go">	 
</td>
</tr>
</table>
</form>

<form name="iowdaily" action="./project/siteDailyReportEntry.sql.php" method="post">
<table align="center" width="98%" border="1" bordercolor="#99CC99" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<input type="hidden" name="submitted" value="<? echo $loginUname;?>" />
<tr><td colspan="6">Brief Description of Day's Operations:<br> 
<input type="text" name="operation" width="100" size="100" maxlength="200"></td></tr>
<tr><td colspan="6">Weather Condition:<br> 
<input type="text"  name="weather" width="100"  size="100" maxlength="200" value="Progress of Work did not hampered because of weather." style="color:#FF3333"></td></tr>
<tr><td colspan="6">Accident Record:<br>
 <input type="text" name="accident" width="100" size="100" maxlength="200" value="No accident happened." style="color:#FF3333"></td></tr>
<tr><td colspan="6">Visitors detail with comments received:<br> 
<input type="text" name="vcomments" width="100" size="100" maxlength="200" value="Nobody from Head Office or Client's side have visited the site." style="color:#FF3333"><br><br></td></tr>
 <tr bgcolor="#B8F3A9">
 <th rowspan="2">IOW Code</th>
 <th rowspan="2">IOW description</th>
  <td colspan="2" align="center">Cumulative Progress Till <? echo date('j-m-Y',strtotime(formatDate($edate2,'Y-m-j'))-(84000));?></td>
  <td  align="center" rowspan="2">Progress of <? echo date('j-m-Y',strtotime(formatDate($edate2,'Y-m-j')));?></td>  
 </tr>
 <tr bgcolor="#B8F3A9">
 <th>Planned </th>
 <th>Actual</th>
 </tr>
 <tr><td colspan="6" height="2"></td></tr>
<? include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sqlp = "SELECT * from `iow` where `iowProjectCode` LIKE '$loginProject' AND iowStatus <> 'Not Ready' ";
if($iow) $sqlp.=" AND iowId=$iow";
 $sqlp.=" ORDER by iowId ASC";

$sqlrunp= mysql_query($sqlp);
$i=1;

while($re=mysql_fetch_array($sqlrunp)){
$j=$i;
?>
<tr bgcolor="#F0FEE2">
  <td  ><? echo $re[iowCode];?>
  <input type="hidden" name="iowid<? echo $i;?>" value="<? echo $re[iowId];?>">
  </td>
  <td><? echo $re[iowDes];?></td> 
  <td> <? $iowProgress =iowProgress($edate2,$re[iowId]); echo $iowProgress;?> </td> 
      <td align="right"> <? 
	 
	  	$ed=formatDate($edate2,'Y-m-j');
		$ed=date("Y-m-j",strtotime($ed));
	echo iowActualProgress($re[iowId],$loginProject,$ed,$re[iowQty],$re[iowUnit],0);

	  // $iowActualProgress=iowActualProgress($edate2,$re[iowId],1); echo $iowActualProgress;?></td> 
<!--   <td align="right"> <?// echo iowTargetProgress($edate2,$re[iowId],1);?></td>   -->
  <td align="right">
	<? 
	
	$ed=formatDate($edate2,'Y-m-j');
	echo iowActualProgress($re[iowId],$loginProject,$ed,$re[iowQty],$re[iowUnit],1);?>
</td>     
</tr>

<? $i++;
$sqlp1 = "SELECT * from `siow` where `iowId` = $re[iowId] ORDER by siowCode ASC";
//echo $sqlp;
$sqlrunp1= mysql_query($sqlp1);

while($res=mysql_fetch_array($sqlrunp1)){
?>

<tr>
  <td  align="center" ><? echo $res[siowCode];?>
  <input type="hidden" name="siowid<? echo $i;?>" value="<? echo $res[siowId];?>">
  </td>
  <td><? echo $res[siowName];?></td> 
  <td> <? echo siowProgress($edate2,$res[siowId]); ?> </td> 
      <td align="right"> 
        <? 
    
	  	$ed=formatDate($edate2,'Y-m-j');
		$ed=date("Y-m-j",strtotime($ed));
	echo siowActualProgress($res[siowId],$loginProject,$ed,$res[siowQty],$res[siowUnit],0);

 // echo siowActualProgress($edate2,$res[siowId],1); ?>
      </td> 
<!--   <td align="right"> <? //echo siowTargetProgress($edate2,$res[siowId],1);?></td>   -->
  <td align="right">
<?
	$ed=formatDate($edate2,'Y-m-j');
echo siowActualProgress($res[siowId],$loginProject,$ed,$res[siowQty],$res[siowUnit],1);?>
  </td>     
</tr>

<? $i++;} //siow?>
<tr><td colspan="5" height="5" >
<b>Supervisor:</b>
<?  echo supervisorDetails($re[supervisor]);?>
</td></tr>

<tr>
<td  colspan="6" bgcolor="#FFFFCC">
Reasons of IOW Progress variance at <? echo date('j-m-Y',strtotime(formatDate($edate2,'Y-m-j')));?>
: <input type="text" width="100" size="100" name="des<? echo $j;?>" value="Work Progress and Resource Consumption matched 100% with the plan."style="color:#FF3333">

<input type="hidden" name="supervisor<? echo $j;?>" value="<?  echo $re[supervisor];?>">

</td></tr>
<tr>
<td  colspan="6" bgcolor="#FFFFCC">
Change Order/Work Instruction Received from Client at <? echo date('j-m-Y',strtotime(formatDate($edate2,'Y-m-j')));?>
: <input type="text" width="100" size="100" name="clientdes<? echo $j;?>" value="No Change Order or Work Instruction received."style="color:#FF3333">

</td></tr>

 <tr><td colspan="6" height="5" bgcolor="#FFFFFF"></td></tr>
<? $j++;}//iow
?>
<tr> 
<td colspan="4">Submitted by: <? echo supervisorDetails($loginUname);?> 

</td>
<td align="center"><input type="button" name="save" value="Save" onClick="iowdaily.submit();"></td></tr>
</table>
<input type="hidden" name="n" value="<? echo $i;?>">
<input type="hidden" name="edate" value="<? echo $edate2;?>" >
</form>
<div id=testdiv1
      style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
<? include('./project/siteMaterialReport.f.php');?>

<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
<form name="goo" action="./index.php?keyword=site+daily+report"	 method="post">
<table align="center" width="98%" border="1" bgcolor="#FEF5F1" bordercolor="#99CC99" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
<tr>
<? if($loginDesignation=='Manager Planning & Control' OR $loginDesignation=='Managing Director' OR $loginDesignation=='Director') {?>
<td >Project: <select name="project"><?
include("config.inc.php");


$sqlpp = "SELECT * from `project` ";
//echo $sqlp;
$sqlrunpp= mysql_query($sqlpp);

 while($typelp= mysql_fetch_array($sqlrunpp))
{
 echo "<option value='".$typelp[pcode]."'";
 if($project==$typelp[pcode]) echo " selected ";
 echo ">$typelp[pcode]--$typelp[pname]</option>  ";
 }
?>
 </select>
</td>
<? }
else $project=$loginProject;
?>
<td >Select IOW: <select name="iow"> <option value="">All IOW</option>
<?
include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sqlp = "SELECT iowId,`iowCode` from `iow` WHERE iowProjectCode='$project' AND iowStatus <> 'Not Ready'";
//echo $sqlp;
$sqlrunp= mysql_query($sqlp);

 while($typel= mysql_fetch_array($sqlrunp))
{
 echo "<option value='".$typel[iowId]."'";
 if($iow==$typel[iowId]) echo " selected ";
 echo ">$typel[iowCode]</option>  ";
 }
?>

 </select>
 </td>
 <td align="center">
<input type="submit" name="go" value="View Numeric Report">	 
</td>
</tr>
<tr>
<td><input type="checkbox">Change Order</td>
<td><input type="checkbox"></td>
</tr>
</table>
</form>
<? if($edate){?>
<table align="center" width="98%" border="1" bordercolor="#99CC99" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
 <tr bgcolor="#D9F9D0">
 <th>IOW Code</th>
 <th>IOW description</th>
 <th>Planned Progress</th>
 <th>Actual Progress</th> 
 </tr>
 <tr><td colspan="4" height="2"></td></tr>
<? include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sqlp = "SELECT * from `iow` where `iowProjectCode` LIKE '$project' AND iowStatus <> 'Not Ready' ";
//$sqlp = "SELECT * from `iow` where `iowProjectCode` LIKE '$project'";
if($iow) $sqlp.=" AND iowId=$iow";
 $sqlp.=" ORDER by iowId ASC";
//echo $sqlp;
$sqlrunp= mysql_query($sqlp);
while($re=mysql_fetch_array($sqlrunp)){
?>
<tr bgcolor="#F0FEE2">
  <td ><? echo $re[iowCode];?></td>
  <td><? echo $re[iowDes];?></td> 
  <td> <? iowProgress($edate,$re[iowId]); ?> </td> 
  <td> <? iowActualProgress($edate,$re[iowId],1); ?> </td> 
</tr>

<? 
if($chk1 OR $chk2 OR $chk3 OR $chk4){
$ed=formatDate($edate,'Y-m-d');
$sqlp1 = "SELECT siowId,siowCode,siowName,(to_days(siowCdate)-to_days(siowSdate)) as duration, (to_days('$ed')-to_days(siowSdate)) as pass".
" from `siow` where `iowId` = $re[iowId] ORDER by siowCode ASC";
//echo $sqlp1;
$sqlrunp1= mysql_query($sqlp1);
$i=1;
while($res=mysql_fetch_array($sqlrunp1)){
?>

<tr>
  <td  align="right" ><? echo $res[siowCode];?>  </td>
  <td><? echo $res[siowName];?></td> 
  <td> <? echo siowProgress($edate,$res[siowId]);?> </td> 
  <td> <? echo siowActualProgress($edate,$res[siowId],'1'); ?> </td> 
</tr>

<? if($chk2 OR $chk3 OR $chk4){?>
<tr>
    <td> </td>
	<td colspan="3">
	<table width="100%" style="border-collapse:collapse" cellspacing="2">
	 <tr><td colspan="4" bgcolor="#6699FF" height="2"></td></tr>
	 <tr><td colspan="4" bgcolor="#6699FF" height="2"></td></tr>
	 <tr>
	   <th width="40">ItemCode</th>
	   <th width="20%">Planned Consumption</th>
	   <th width="20%">Actual Consumption</th>
	   <th width="20%">Actual Expense</th>	   
	 </tr>
	 <tr><td colspan="4" bgcolor="#6699FF" height="2"></td></tr>
	 <tr><td colspan="4" bgcolor="#6699FF" height="2"></td></tr> 
	  <? if($chk2){ materialReport($res[siowId],$res[pass],$res[duration],$project);
	   materialReport_summary($res[siowId],$res[pass],$res[duration],$project,$edate);
	  }?>
	  <? if($chk3){equipmentReport($res[siowId],$res[pass],$res[duration],$project);
	  equipmentReport_summary($res[siowId],$res[pass],$res[duration],$project,$edate);
	  }?>
	  <? if($chk4){ humanReport($res[siowId],$res[pass],$res[duration],$project);
	   humanReport_summary($res[siowId],$res[pass],$res[duration],$project,$edate);
	  }
	  ?>
     </table>	
	
	 </td>
 </tr>
 <? }//material?>
<? } //siow
}
?>
<tr><td colspan="5" height="5" ></td></tr>
<? }//iow
?>
</table>

<? }//if edate?>

<div id=testdiv1
      style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
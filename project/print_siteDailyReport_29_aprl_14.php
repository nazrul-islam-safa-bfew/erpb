<?
include("../includes/session.inc.php");
include("../includes/config.inc.php");
include_once("../includes/myFunction.php");
include_once("../includes/myFunction1.php");
include_once("../includes/accFunction.php");
include_once("../includes/empFunction.inc.php");
include_once("../includes/eqFunction.inc.php");
include_once("../includes/subFunction.inc.php");
include_once("../includes/matFunction.inc.php");
include_once('../includes/vendoreFunction.inc.php');
include('../project/print_siteMaterialReport.f.php');
include('../project/print_siteDailyReport.f.php');
//require_once( "./includes/trans.php" );
require_once("../keys.php");
//echo "<!----".$au."---->";
//$t_req=$REMOTE_ADDR;
/*$time=mktime(0,0,0, date("m"),date("d"),date("y"));
$todat = date("Y-m-d",$time);
*/
$todat=todat();
//echo $todat;
?>
<html>

<head>



<link href="../style/print.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Language" content="en-us">
<meta name="author" content="<? echo $mauthor;?>">
<meta name="copyright" content="<? echo $tt;?>">
<meta name="keywords" content="<? echo $kword;?>">
<META NAME="description" CONTENT="<? echo $des;?>">


<title>BFEW :: <? if($keyword){echo $keyword;}else{ echo "Home";}?></title>
</head>
<body  topmargin="1" leftmargin="5" rightmargin="5" bgcolor="#FFFFFF" >

<table width="98%" align="center">
<tr>
 <th>Bangladesh Foundry and Engineering Works Ltd.</th>
</tr>
<tr>
 <th>Progress Report of &nbsp;<? echo myProjectName($project);?>&nbsp; at &nbsp; <? echo date('D',strtotime($edate)).'  '; echo $edate; //echo mydate($edate); ?></th>
</tr>
</table>


<?
include("../includes/config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);

?>
<?

$btn_sql1=stripslashes($btn_sql1);
//echo $btn_sql1.'<br>';
$sqlq=mysql_query($btn_sql1);

$sqlr=mysql_fetch_array($sqlq);

?>
<table width="95%" align="center">
<tr><td colspan="2">Brief Description of Day's Operations :<i><? echo $sqlr[operation];?></i></td></tr>
<tr><td colspan="2">Weather Condition: <i><? echo $sqlr[weather];?></i></td></tr>
<tr><td colspan="2">Accident: <i><? echo $sqlr[accident];?> </i></td></tr>
<tr><td colspan="2">Visitors detail with comments received:<i> <? echo $sqlr[vcomments];?></i> </td></tr>
</table>
<br>
<table align="center" width="98%" border="1" bordercolor="#99CC99" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
 <tr bgcolor="#D9F9D0">
 <th>IOW Code</th>
 <th>IOW description</th>
 <th>Planned Progress</th>
 <th>Actual Progress</th>
 </tr>
 <tr><td colspan="4" height="2"></td></tr>
<?


$btn_sql2=stripslashes($btn_sql2);
//echo $btn_sql2.'<br>*******************************<br>';
$sqlrunp= mysql_query($btn_sql2);
$ed=formatDate($edate,'Y-m-j');
while($re=mysql_fetch_array($sqlrunp)){
?>


<tr bgcolor="#F0FEE2">
  <th align="left" ><? echo $re[iowCode];?></th>
  <th align="left"><? echo $re[iowDes];?></th>
  <th align="right"> <? iowProgress($edate,$re[iowId]); ?> </th>
  <td align="right"> <? echo iowActualProgress($re[iowId],$project,$ed,$re[iowQty],$re[iowUnit],0);?> 
  </td>
</tr>

<?
$ed=formatDate($edate,'Y-m-d');
if($chk1 OR $chk2 OR $chk3 OR $chk4){
/*$sqlp1 = "SELECT siowId,siowCode,siowName,(to_days(siowCdate)-to_days(siowSdate)) as duration, (to_days('$ed')-to_days(siowSdate)) as pass".
" from `siow` where `iowId` = $re[iowId] ORDER by siowCode ASC";
*/
$sqlp1 = "SELECT siowId,siowCode,siowName,siowQty,siowUnit,".
" (to_days(siowCdate)-to_days(siowSdate)) as duration, (to_days('$ed')-to_days(siowSdate)) as pass".
" from `siow` where `iowId` = $re[iowId] ORDER by siowCode ASC";
//echo $sqlp1;

//$btn_sql3=stripslashes($btn_sql3);
//echo $btn_sql3.'<br>*******************************<br>';

$sqlrunp1= mysql_query($sqlp1);
$i=1;
while($res=mysql_fetch_array($sqlrunp1)){
?>

<tr>
  <td  align="right" ><? echo $res[siowCode];?>  </td>
  <td><? echo $res[siowName];?></td>
  <td align="right"> <? echo siowProgress($edate,$res[siowId]);?> </td>
  <td align="right"> <? // echo siowActualProgress($edate,$res[siowId],'1'); 
   echo siowActualProgress($res[siowId],$project,$ed,$res[siowQty],$res[siowUnit],0);?> </td>
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
	  <? if($chk2){ materialReport($res[siowId],$res[pass],$res[duration],$project,$ed);
	  // materialReport_summary($res[siowId],$res[pass],$res[duration],$project,$edate);
	  }?>
	  <? if($chk3){equipmentReport($res[siowId],$res[pass],$res[duration],$project,$ed);
	//  equipmentReport_summary($res[siowId],$res[pass],$res[duration],$project,$edate);
	  }?>
	  <? if($chk4){ humanReport($res[siowId],$res[pass],$res[duration],$project,$ed);
	  // humanReport_summary($res[siowId],$res[pass],$res[duration],$project,$edate);
	   subcontractorReport($res[siowId],$res[pass],$res[duration],$project,$ed);
	  }
	  ?>
     </table>

	 </td>
 </tr>
 <? }//material?>
<? } //siow
}
?>
<?


//echo "$chk5 OR $chk6";

 if($chk5 OR $chk6 ){
$sqld="select des,clientdes,edate from iowdaily where iowId=$re[iowId] AND edate<='$ed' ORDER by edate DESC";
//echo $sqld;
$sqlqd=mysql_query($sqld);
while($d=mysql_fetch_array($sqlqd)){

		if($chk6 AND $d[des])echo "<tr><td colspan=5><b>".myDate($d[edate])."</b> Progress: <i>$d[des]</i></td></tr>";
		if($chk5 AND  $d[clientdes])echo "<tr><td colspan=5><b>".myDate($d[edate])."</b> CO/WI: <i>$d[clientdes]</i></td></tr>";

}//while
?>

<? }//if($chk5 OR $chk6 ){
else {?>

<tr><td colspan="5" height="5" >
<b>CO/WI: </b>
<? echo iow_progerss_changeOrder($re[iowId],$ed);?>
</td></tr>


<tr><td colspan="5" height="10" ></td></tr>
<? }//else
}//iow
?>
</table>




<?
include("../includes/session.inc.php");
include_once("../includes/myFunction.php");
include_once("../includes/myFunction1.php");
require_once("../keys.php");
//echo "<!----".$au."---->";
$t_req=$REMOTE_ADDR;
/*$time=mktime(0,0,0, date("m"),date("d"),date("y"));
$todat = date("Y-m-d",$time);
*/
$todat=todat();
//echo $todat;
$edate1=formatDate($edate,'Y-m-d');	
?>
<html>

<head>
<SCRIPT language=JavaScript src="../js/shimul.js" type=text/JavaScript></SCRIPT>
<meta http-equiv="Content-Language" content="en-us">
<meta name="author" content="<? echo $mauthor;?>">
<meta name="copyright" content="<? echo $tt;?>">
<meta name="keywords" content="<? echo $kword;?>">
<META NAME="description" CONTENT="<? echo $des;?>">

<title>BFEW :: equipment utilization </title>
<style type="text/css">
BODY {
	MARGIN-TOP: 0px; MARGIN-LEFT: 5px;MARGIN-RIGHT: 5px; PADDING-TOP: 0px; margin-bottom: 0px; 
	font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; background-color: #EEEEEE;background-image: none;
}
.englishhead {
	FONT-SIZE: 16px; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; COLOR:#FFFFFF;  letter-spacing: 2;text-transform: capitalize
}


</style>
</head>
<body  topmargin="1" leftmargin="5" rightmargin="5" bgcolor="#FFFFFF" >

<? 
if($chk==1){
/* include("../includes/config.inc.php");
 require_once("../includes/myFunction.php"); 
 require_once("../includes/myFunction1.php");  
 */
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

if($h1 AND $m1 AND $h2 AND $m2){
	$stime=$h1.':'.$m1.':00';
	$etime=$h2.':'.$m2.':00';
	if(!isUtilized($assetId,$itemCode,$edate1,$stime,$etime)){
		$sql = "INSERT INTO `equt` ( `id` , `assetId` , `itemCode`,`iow` , `siow` , `stime` , `etime` , `details` , `edate`,`pcode` ) ".
						   "VALUES ('', '$assetId', '$itemCode','', '', '$stime', '$etime', '$remark', '$edate1','$loginProject')";
		//echo $sql.'<br>';
		mysqli_query($db, $sql);
	}		
	else $err=1;
}//if



}
?>

<form name="equt" action="./eqBreakDown1.php?<? echo "assetId=$assetId&itemCode=$itemCode&edate=$edate";?>" method="post">
Break Down Date: <? echo $edate;?>
<br>

Selected Equipment: <? echo eqpId($assetId,$itemCode);?>
<table align="center" width="600" border="3"  bordercolor="CC9999" cellpadding="2" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td colspan="2" align="right" valign="top"><font class='englishhead'>equipment breakdown entry form</font></td>
</tr>
<tr>
 <th>From</th>
 <th>To</th> 

</tr>
<tr <? if($err) echo "bgcolor=#DDBBBB";?> >
  <td align="center">
	  <input name="h1" value=""  size="2" maxlength="2" onKeyUp="return autoTab(this, 2, event);"> :
	  <input name="m1" value=""  size="2" maxlength="2" onKeyUp="return autoTab(this, 2, event);"> 
  </td>
  <td align="center">
	  <input name="h2" value="" size="2" maxlength="2" onKeyUp="return autoTab(this, 2, event);"> :
	  <input name="m2" value=""  size="2" maxlength="2" onKeyUp="return autoTab(this, 2, event);"> 
  </td>
 </tr>
</table>
<p align="center"><input type="button" name="Save" value="Save" onClick="equt.chk.value=1; equt.submit(); "></p>
<input type="hidden" name="chk" value="0">
</form>

<table align="center" width="600" border="3" bgcolor="#FFFFFF"  bordercolor="CC9999" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td colspan="5" align="right" valign="top"><font class='englishhead'>equipment utilization report of <? echo $edate1;?></font></td>
</tr>
<tr>
 <th>From</th>
 <th>To</th> 
 <th>IOW Name</th>
 <th>SIOW Name</th>
</tr>
<? 
$temp=explode('-',$assetId);
include("../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
	

$sqlut = "SELECT * FROM equt WHERE assetId='$assetId' AND itemCode='$itemCode' AND edate='$edate1' ORDER by stime ASC";
//echo $sqlut;
$sqlqut= mysqli_query($db, $sqlut);
$i=1;
 while($reut= mysqli_fetch_array($sqlqut))
{?>
<tr <? if($i%2==0) echo "bgcolor=#EFEFEF";?> >
  <td align="center"> <? echo $reut[stime]?> </td>
  <td align="center"> <? echo $reut[etime]?> </td>
  <td align="left"> <? 
  if($reut[iow]){echo '<font color=006600>'.iowCode($reut[iow]).'</font> ';
  echo iowName($reut[iow]);}?> </td>
  <td align="left"> <? if($reut[siow]){ echo '<font color=006600>'.viewsiowCode($reut[siow]).'</font> '.siowName($reut[siow]);}?> </td>
 </tr>
 <? $i++;}?>
</table>
</body>
</html>
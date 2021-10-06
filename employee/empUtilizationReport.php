<?

include("../includes/session.inc.php");
include("../includes/myFunction1.php");
include("../includes/myFunction.php");
include("../includes/empFunction.inc.php");
require_once("../keys.php");
//echo "<!----".$au."---->";

/*$time=mktime(0,0,0, date("m"),date("d"),date("y"));
$todat = date("Y-m-d",$time);
*/

//echo $todat;
?>
<html>

<head>
<link href="../style/basestyles.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Language" content="en-us">
<meta name="author" content="<? echo $mauthor;?>">
<meta name="copyright" content="<? echo $tt;?>">
<meta name="keywords" content="<? echo $kword;?>">
<META NAME="description" CONTENT="<? echo $des;?>">

<title>BFEW :: employee utilization </title>
</head>
<body  topmargin="1" leftmargin="5" rightmargin="5" bgcolor="#FFFFFF" >

<br>
<table align="center" width="95%" border="3" bgcolor="#FFFFFF"  bordercolor="CC9999" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td colspan="5" align="right" valign="top"><font class='englishhead'>employee utilization report </font> of <? if($empType=='L') echo local_empId($empId,$empD).', '.local_empName($empId).', '.hrDesignation($empD);
 else echo empId($empId,$empD).', '.empName($empId).', '.hrDesignation($empD);
?></td>
</tr>
<tr>
 <th width="100">Date</th>
 <th>From</th>
 <th>To</th> 
 <th>IOW Name</th>
 <th>SIOW Name</th>
</tr>
<? 
$temp=explode('-',$assetId);
include("../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
	

//$sqlut = "SELECT * FROM emput WHERE empId='$empId' AND designation='$empD' AND edate='$edate1' AND pcode='$loginProject' ORDER by stime ASC";
$sqlut = "SELECT * FROM emput WHERE empId='$empId' AND designation='$empD'  AND pcode='$loginProject' ORDER by edate,stime ASC";
//echo $sqlut;
$sqlqut= mysqli_query($db, $sqlut);
$i=1;
 while($reut= mysqli_fetch_array($sqlqut))
{?>
<tr <? if($i%2==0) echo "bgcolor=#EFEFEF";?> >
  <td align="center"> <? echo myDate($reut[edate]);?> </td>
  <td align="center"> <? echo $reut[stime];?> </td>
  <td align="center"> <? echo $reut[etime];?> </td>
  <td align="left"> <? 
  if($reut[iow]){
  echo '<font color=006600>'.iowCode($reut[iow]).'</font> ';
  echo iowName($reut[iow]);
  }
  echo "Break";
  ?> </td>
  <td align="left"> <? 
    if($reut[iow]){
  echo '<font color=006600>'.viewsiowCode($reut[siow]).'</font> '.siowName($reut[siow]);}
  else echo $reut[details];
  
  ?> </td>
 </tr>
 <? $i++;}?>
</table>
</body>	  
</html>
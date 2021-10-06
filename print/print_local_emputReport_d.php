<? include_once("../includes/myFunction1.php");
include("../includes/config.inc.php");
include_once("../includes/myFunction.php");
include_once("../includes/empFunction.inc.php");
include_once("../includes/eqFunction.inc.php");
include_once("../includes/subFunction.inc.php");
include_once("../includes/matFunction.inc.php");

$todat=todat();
?>
<html>
<head>

<LINK href="../style/print.css" type=text/css rel=stylesheet>



<meta http-equiv="Content-Language" content="en-us">
<meta name="author" content="<? echo $mauthor;?>">
<meta name="copyright" content="<? echo $tt;?>">
<meta name="keywords" content="<? echo $kword;?>">
<META NAME="description" CONTENT="<? echo $des;?>">
<title>BFEW :: Print </title>
</head>
<body  topmargin="1" leftmargin="5" rightmargin="5" bgcolor="#FFFFFF" >
<a name="top"></a>
<table width="500" border="0"  align="center" cellpadding="5" cellspacing="5">
<tr>
 <th>Bangladesh Foundry and Engineering Works Ltd.</th>
</tr>
<tr>
 <th>Labour Report of &nbsp;<? echo myProjectName($project);?>&nbsp; at &nbsp; <? echo date('D',strtotime($edate)).'  '; echo mydate($edate); ?></th>
</tr>
</table>
<br>
<br>


<table align="center" width="95%" border="3" bgcolor="#FFFFFF"  bordercolor="CC9999" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#EEEEEE">
 <td colspan="5" align="right" valign="top"><font class='englishheadBlack'>employee utilization report</font></td>
</tr>
<? //echo $sqlp.'<br>';?>
<tr>
 <th width="100">Date</th>
 <th>Present</th>
 <th>Worked</th>
 <th>Over time</th> 
 <th>Idle</th>
</tr>
<? 
if($month){

$fromD="2006-$month-01";
$daysofmonth=daysofmonth($fromD);
$toD="2006-$month-$daysofmonth";

include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
	

//$sqlut = "SELECT * FROM emput WHERE empId='$empId' AND designation='$empD' AND edate='$edate1' AND pcode='$project' ORDER by stime ASC";
$sqlut = "SELECT DISTINCT edate FROM emput WHERE".
" empId='$empId' AND pcode='$project'".
" AND edate BETWEEN '$fromD' AND '$toD'".
" ORDER by edate ASC";
//echo $sqlut;
$sqlqut= mysql_query($sqlut);
$i=1;
$sqlr=mysql_num_rows($sqlqut);
 while($reut= mysql_fetch_array($sqlqut))
{?>
<tr <? if(date('D',strtotime($reut[edate]))=='Fri') echo "bgcolor=#FFFFCC"; elseif($i%2==0) echo "bgcolor=#EFEFEF";?> >
  <td align="center" ><a href='./employee/local_emputReport_byEmp_detail.php?empId=<? echo $empId;?>&empType=H&edate=<? echo $reut[edate];?>' target='_blank'>
  <? echo myDate($reut[edate]);?></a>

  <?
 $dailyworkBreakt=dailyworkBreak($empId,$reut[edate],'H',$project);

$toDaypresent=toDaypresent($empId,$reut[edate],'H',$project)-$dailyworkBreakt;

$workt= dailywork($empId,$reut[edate],'H',$project);
if(date('D',strtotime($reut[edate]))=='Fri')
 $overtimet = $toDaypresent-(4*3600);
else 
	$overtimet = $toDaypresent-(8*3600);

if($overtimet<0) $overtimet=0;
$idlet=$toDaypresent-$workt;
  if($idlet<0) $idlet=0;
?>

</td>
  <td align="center"> <?   $preset= sec2hms($toDaypresent/3600,$padHours=false);   echo $preset.' Hrs.';  $totalPresent=$totalPresent+$toDaypresent;?></td>
  <td align="center"> <?   $work= sec2hms($workt/3600,$padHours=false);   echo $work.' Hrs.';  $totalWork=$totalWork+$workt;?></td>
  <td align="center"> <?  $overtime=sec2hms($overtimet/3600,$padHours=false);  echo $overtime.' Hrs.';  $totalOverTime=$totalOverTime+$overtimet;?></td>
  <td align="center"> <?  $idle=sec2hms($idlet/3600,$padHours=false);  echo $idle.' Hrs.';   $totalIdel=$totalIdel+$idlet;?></td>
 </tr>
 <? $i++;}?>
 <? }?>
 <? if($sqlr){ ?>
 <tr bgcolor="#CC9999">
  <td align="center"> <? echo $sqlr;?> days</td>
  <td align="center"> <? echo sec2hms($totalPresent/3600,$padHours=false); ?> Hrs.</td>  
  <td align="center"> <? echo sec2hms($totalWork/3600,$padHours=false);?> Hrs. (<? echo round(($totalWork*100)/$totalPresent);?> %)</td>  
  <td align="center"> <? echo sec2hms($totalOverTime/3600,$padHours=false); ?> Hrs. (<? echo round(($totalOverTime*100)/$totalPresent);?> %)</td>  
  <td align="center"> <? echo sec2hms($totalIdel/3600,$padHours=false);?> Hrs. (<? echo round(($totalIdel*100)/$totalPresent);?> %)</td>        
 </tr>
 <? }?>
</table>

  <br>
  <br>
<? include('../bottom.php');?>
</body>

</html>
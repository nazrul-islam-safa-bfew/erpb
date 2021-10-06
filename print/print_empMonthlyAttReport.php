<? include_once("../includes/myFunction1.php");
include("../includes/config.inc.php");
include_once("../includes/myFunction.php");
include_once("../includes/empFunction.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
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
<table width="600" border="3" bgcolor="#FFFFFF"  bordercolor="CC9999" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
<tr >
 <td colspan="2">
  Selected Month:
 <? if($month=='01') echo 'January';?>
<? if($month=='02') echo 'February';?>
<? if($month=='03') echo 'March';?>
<? if($month=='04') echo 'April';?>
<? if($month=='05') echo 'May';?>
<? if($month=='06') echo 'June';?>
<? if($month=='07') echo 'July';?>
<? if($month=='08') echo 'August';?>
<? if($month=='09') echo 'September';?>
<? if($month=='10') echo 'October';?>
<? if($month=='11') echo 'November';?>
<? if($month=='12') echo 'December';?>


 </td>
 <td colspan="2" align="right" valign="top">employee utilization report <? 

$sql="select * from employee where empId='$empId'";
$sqlq=mysql_query($sql);
$rr=mysql_fetch_array($sqlq);
$designation=$rr[designation];
$name=$rr[name];

 echo $name;?><br>
  <?  echo hrDesignation($designation).'<br>'.empId($empId,$designation);?></td>
</tr>

<tr>
 <th width="100">Date</th>
 <th>Action</th>
 <th>Remarks</th>
</tr>
<? 
if($month){
$fromD="2007-$month-01";
$daysofmonth=daysofmonth($fromD);
$toD="2007-$month-$daysofmonth";
}



$sqlut = "SELECT * FROM attendance WHERE".
" empId='$empId'".
" AND edate BETWEEN '$fromD' AND '$toD'".
" ORDER by edate ASC";
//echo $sqlut;


$sqlqut= mysql_query($sqlut);
$i=1;
$sqlr=mysql_num_rows($sqlqut);
 while($reut= mysql_fetch_array($sqlqut))
{?>
<tr <? if(date('D',strtotime($reut[edate]))=='Fri') echo " bgcolor=#FFFFCC "; elseif($i%2==0) echo " bgcolor=#EFEFEF ";?> >
  <td align="center" > <? echo myDate($reut[edate]);?></td>
	<td align="center">
   <? if($reut[action]=='P' OR $reut[action]=='HP') echo "Present<br>$reut[stime]";
        else if($reut[action]=='L') echo 'Leave';
		   else { echo '<font color=#FF0000>Absent</font>';}?>
	</td>
  <td align="center"> <? echo view_AttRemarks($reut[id])?> </td>
 </tr>

 <? $i++; }?>

</table>
</body>

</html>

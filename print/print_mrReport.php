<? 
include_once("../includes/session.inc.php");
include_once("../includes/myFunction1.php");
include("../includes/config.inc.php");
include_once("../includes/myFunction.php");
include_once("../includes/empFunction.inc.php");
include_once("../includes/eqFunction.inc.php");
include_once("../includes/subFunction.inc.php");
include_once("../includes/matFunction.inc.php");


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
<a name="top"></a>
<table width="700" border="0"  align="center" cellpadding="5" cellspacing="5">
<tr>
 <th><h1>Bangladesh Foundry and Engineering Works Ltd.</h1></th>
</tr>
<tr>
 <th>Material Receiving Report of &nbsp;<? echo myProjectName($project);?>&nbsp; at &nbsp; <? echo date('D',strtotime($mrDate)).'  '; echo mydate($mrDate); ?></th>
</tr>
</table>
<br>
<br>


<br>
<br>
<table align="center" width="95%" border="1" bordercolor="#ADA5F8" cellpadding="0" cellspacing="0" style="border-collapse:collapse">

<tr bgcolor="#D2D2FF">
<td colspan="2" ><? echo '<font class=out>'.myDate($mrDate).'</font>';?>;
<? $p=explode('_',$mrpaymentSL);

if($p[0]=='PO') 
	{ 
	$vtemp=vendorName($p[3]);
	echo viewPosl($mrpaymentSL).' '.$vtemp[vname];
	}
else echo $mrpaymentSL.' Emergency Purchase';	
?>
</td>
<th align="center" ><? echo $mrreference;?></th>
</tr>
<? $sql1="SELECT * from store$project WHERE".
" reference='$mrreference' ORDER by store$project.itemCode ASC";

//echo $sql1.'<br>';
$sqlq1=mysql_query($sql1);
while($st=mysql_fetch_array($sqlq1)){
$temp=itemDes($st[itemCode]);
?>
<tr>
  <td>
<a onClick='if(confirm("You are going to DELETE this Receive. Are you sure ?"))
 window.location="../store/deleteMR.sql.php?rsid=<? echo $st[rsid];?>&p=<? echo $project;?>"' title="Click to Delete Project">
  <? echo $st[itemCode].' '.$temp[des].', '.$temp[spc];  ?> </a></td>      
  <td align="right"><? echo number_format($st[receiveQty],3).' '.$temp[unit];?></td>   
  <td align="right"><? $subAmount=$st[receiveQty]*$st[rate]; echo number_format($subAmount,2);
  $totoalAmount=$totoalAmount+$subAmount;  
  $subAmount=0;
  ?></td>          
</tr>
<? }?>

<tr bgcolor="#FFFFCC">
 <td colspan="3" align="right"> Total Amount: <? echo number_format($totoalAmount,2);?></td>
</tr>

<? $totoalAmount=0;?>


</table>
  <br>
  <br>
<? include('../bottom.php');?>
</body>

</html>


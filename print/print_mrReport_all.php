<? 
$localPath = $_SERVER["DOCUMENT_ROOT"]."/erp";
include($localPath."/includes/session.inc.php");
include($localPath."/includes/config.inc.php");
include($localPath."/includes/myFunctionTest.php");
include($localPath."/includes/myFunction.php"); // some general function
include_once($localPath."/includes/myFunction1.php"); // some general function
include_once($localPath."/includes/accFunction.php"); //all accounts function
include_once($localPath."/includes/empFunction.inc.php"); //manpower function
include_once($localPath."/includes/eqFunction.inc.php"); // equipment function
include_once($localPath."/includes/subFunction.inc.php"); // sub contracts function
include_once($localPath."/includes/matFunction.inc.php"); // material function

// include_once("../includes/session.inc.php");
// include_once("../includes/myFunction1.php");
// include("../includes/config.inc.php");
// include_once("../includes/myFunction.php");
// include_once("../includes/empFunction.inc.php");
// include_once("../includes/eqFunction.inc.php");
// include_once("../includes/subFunction.inc.php");
// include_once("../includes/matFunction.inc.php");


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
 <th>Material Receiving Report of &nbsp;<? echo myProjectName($loginProject);?>&nbsp; at &nbsp; <? echo date('D',strtotime($todate)).'  '; echo mydate($todate); ?></th>
</tr>
</table>
<br>
<br>


<br>
<br>
<table align="center" width="95%" border="1" bordercolor="#ADA5F8" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<? 
$sql="SELECT DISTINCT reference,todat,paymentSL from store$loginProject WHERE".
" store$loginProject.todat between '$fromDate' ". 
" AND '$toDate'".
" ORDER by store$loginProject.todat ASC";
//echo $sql.'<br>';
$sqlq=mysql_query($sql);
while($mr=mysql_fetch_array($sqlq)){
?>
<tr bgcolor="#D2D2FF">
<td colspan="2" ><? echo '<font class=out>'.myDate($mr[todat]).'</font>';?>;
<? $p=explode('_',$mr[paymentSL]);
if($p[0]=='PO') 
	{ 
	$vtemp=vendorName($p[3]);

	echo viewPosl($mr[paymentSL]).' '.$vtemp[vname];
	}
else echo $mr[paymentSL].' Emergency Purchase';	
?>
</td>
<th align="center" ><? echo $mr[reference];?></th>
</tr>
<? $sql1="SELECT * from store$loginProject WHERE".
" reference='$mr[reference]' ORDER by store$loginProject.itemCode ASC";

//echo $sql1.'<br>';
$sqlq1=mysql_query($sql1);
while($st=mysql_fetch_array($sqlq1)){
$temp=itemDes($st[itemCode]);
?>
<tr>
  <td><? echo $st[itemCode].' '.$temp[des].', '.$temp[spc];  ?></td>      
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

<? $totoalAmount=0;

}//while?>
</table>
  <br>
  <br>
<? include('../bottom.php');?>
</body>

</html>


<? include("../session.inc.php");
include("../config.inc.php");
include("../keys.php");
echo "<!----".$au."---->";
$t_req=$REMOTE_ADDR;
$time=mktime(0,0,0, date("m"),date("d"),date("y"));
$today = date("d/m/Y",$time);
//echo $today;
?>
<html>

<head>

<meta http-equiv="Content-Language" content="en-us">
<meta name="author" content="<? echo $mauthor;?>">
<meta name="copyright" content="<? echo $tt;?>">
<meta name="keywords" content="<? echo $kword;?>">
<META NAME="description" CONTENT="<? echo $des;?>">
<title>BFEW :: </title>

<style type="text/css" title="print">
BODY {
	MARGIN-TOP:50px; MARGIN-LEFT: 5px; MARGIN-RIGHT: 5px; PADDING-TOP: 0px; margin-bottom: 0px;
	 font-family: Times New Roman, Times, serif, Arial, Helvetica, sans-serif; font-size: 11px; background="#FFFFFF"
}
table {  font-family: Arial, Helvetica, sans-serif; font-size: 11px; color:#000000}
@media print
{
DIV.dontprint {display:none}
}
@page {size: 21cm 29.7cm; margin:0cm;}
@page:first {size:portrait;}
</style>

</head>
<body >
<table width="750px" align="left" border="0"  cellspacing="0" cellpadding="0">
<tr><td align="center"><font style="font-size:16">Bangladesg Foundry & Engineering Works Ltd.</font></td> </tr>
<tr><TD align="center"><u><font style="font-size:11">PURCHASE REQUISITION FORM</font></u><br><br></TD></tr>

<? 
include("../config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
mysql_select_db($SESS_DBNAME,$db);

 $sqlp =  stripslashes($myquary);

//echo $sqlp;
$sqlrunp= mysql_query($sqlp);
$i=1;
while($prin=mysql_fetch_array($sqlrunp)){

include("../config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
mysql_select_db($SESS_DBNAME,$db);
 $sqlshow="SELECT * from `project` where `pcode` like '$prin[projectCode]'";
 //echo $sqlshow;
 $sqlshowrun=mysql_query($sqlshow);
 $pr=mysql_fetch_array($sqlshowrun);
//if($i%1==0) echo "<div STYLE='page-break-after: right'>"; else echo "<div >";
?>

<tr>
 <td>
    <table width="100%" border="1" bordercolor="#000000" cellpadding="3" cellspacing="0" style="border-collapse:collapse">
 <tr bgcolor="#EEEEEE">
	<td colspan="2">Project Name:  <b><u><? echo $pr[pname];?></u></b></td>
	<td >Req No. <? printf("%04d",$prin[prId]);?></td>
	<td align="right"> Raised on: <? echo date("j/m/Y ", strtotime("$prin[dater]"));?></td>
 </tr>
<? include("../config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
mysql_select_db($SESS_DBNAME,$db);
 $sqlitem="SELECT * from `itemlist` where `itemCode` like '$prin[itemCode]'";
 //echo $sqlshow;
 $sqlitemrun=mysql_query($sqlitem);
 $item=mysql_fetch_array($sqlitemrun);
?>
	   <tr> 
		  <td width="180" > Item Code No. :<? echo $prin[itemCode];?></td>
		  <td colspan="3"> Item Description : <? echo $item[itemDes];?></td>		  
	   </tr>
	   <tr> 
		  <td> Stock in Hand : </td>		  
		  <td> Total Requirement: <? echo "$prin[currentReq] $item[itemUnit]";?></td>
		  <td> Unit Price Tk.: <? echo $prin[unitPrice];?></td>		  
		  <td> Total Price: <? echo $prin[totalPrice];?></td>
	   </tr>
		<tr>
			<td colspan="2">Requsition Status:  <u><? echo $prin[approvalStatus];?></td> 
			<td >Fund Allocated for:  <? 
			$mo=$prin[currentReq]-$prin[allocatedQty];
			echo " $mo $item[itemUnit]" ;?></td> 			
  	        <td  align="right">Receiving Deadline.<? echo date("j/m/Y ", strtotime(" $prin[deadLine]"));?></td> 
	  </tr>
	   
	   <tr> 
		  <td colspan="3"> Item of Work : <? echo $prin[itemofWork];?></td>		  
		  <td > Preferred Source: <? echo $prin[preferredSouce];?></td>

	   </tr>
	</table><br><br>
</td></tr>

<? $i++; }?>
<tr><td><? echo "<b>Printed By:</b> $loginFullName  || <b>Date: </b> $today"; ?></td></tr>
<tr><td>
<div  class="dontprint"><input type="button"  value="Print"onClick="window.print();"></div>
</td></tr>
</div>
</table>
</font>
</body>
</html>

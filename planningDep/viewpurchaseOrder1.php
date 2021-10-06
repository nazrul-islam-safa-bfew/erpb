<?
include("../session.inc.php");
include("../config.inc.php");
include("../includes/myFunction.php");
include("../includes/myFunction1.php");
include("../keys.php");
?>

<html>
 <head>
    <LINK href="../style/print.css" type=text/css rel=stylesheet media="print">
	<meta http-equiv="Content-Language" content="en-us">
	<meta name="author" content="<? echo $mauthor;?>">
	<meta name="copyright" content="<? echo $tt;?>">
	<meta name="keywords" content="<? echo $kword;?>">
	<META NAME="description" CONTENT="<? echo $des;?>">
	<?
$temp= explode('_',$posl);
$project=$temp[1];
$vid=$temp[3];
	  include("../includes/config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sqlp = "SELECT * from  `porder` WHERE posl='$posl'";
//echo $sqlp;
$sqlrunp= mysql_query($sqlp);
$fsql=mysql_fetch_array($sqlrunp);
$podate=mydate($fsql[activeDate]);
?>
<title class="noPrint" >SL: <? echo viewPosl($posl);?></title>
</head>

<body   bgcolor="#FFFFFF" >

<? include('../includes/vendoreFunction.inc.php');?>
<?   if($temp[0]=='PO'){
?>
<table width="98%" align="center" cellspacing="0"  >
<tr>
 <td>
 
  <table align="left" width="98%" border="0" bordercolor="#000000" bgcolor="#FFFFEE" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
    <tr bgcolor="#FFFFCC"> 
      <td align="left" height="30" > SL: <? echo viewPosl($posl);?> </td>
      <td align="right"> <?  echo $podate;// putenv ('TZ=Asia/Dacca');  echo date("F d, Y.");?> </td>	  
    </tr>
	<tr>	  <td colspan="2" ><br><br>    </td>	  </tr>
	 <?
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$vendor = "SELECT * from `vendor` WHERE vid=$vid";
//echo $sqlp;
$sqlr= mysql_query($vendor);
$vendor = mysql_fetch_array($sqlr);
?>
 <TR >
  <TD colspan="2"><b> <? echo $vendor[vname];?></b></TD>
 </TR>
 <TR >
  <TD colspan="2"><? echo $vendor[address];?></TD>
 </TR>
 <TR>
  <TD colspan="2"><br><br>Subject: <b>Work Order for Supply of Material at <? echo myprojectName($project);?></b><br><br>
  </TD>  
 </TR>
	  
</table>
 </td>
 </tr>
 <tr>
  <td>
  <table align="left" width="98%" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
    <tr> 
	  <th>Item No</th>
      <th>BFEW's Store Code</th>
      <th>Description</th>
      <th>Quantity</th>	  
      <th>Unit</th>	  
      <th>Rate</th>
      <th>Amount</th>	  
      <th>Quotation date</th>	  
    </tr>
    <? 
if($vid){

$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sqlp = "SELECT * from  `porder` WHERE posl='$posl' ORDER by itemCode ASC";
//echo $sqlp;
$sqlrunp= mysql_query($sqlp);

$i=1;
 while($typel1= mysql_fetch_array($sqlrunp))
{
if($typel1[itemCode]>='99-00-000')$type=3;
$status=$typel1[status];
$temp=itemDes($typel1[itemCode]);
?>
    <tr> 
	   <td align="center"><? echo $i;?>.</td>
      <td align="center"><? echo $typel1[itemCode];?></td>
      <td>  <?  echo $temp[des].', '.$temp[spc];?>    </td>
      <td align="right"><? echo number_format($typel1[qty],3);?></td>
      <td align="center"><?  echo $temp[unit];?> </td>	  
      <td align="right">Tk.<? echo number_format($typel1[rate],2)?>    </td>
      <td align="right">Tk.<? echo number_format($typel1[rate]*$typel1[qty],2)?>    </td>	  
      <td ><?  echo $typel1[qref];?> </td>	  	  
    </tr>
    <?
$i++;
$totalAmount+=$typel1[rate]*$typel1[qty];
} //while

}//if?>
<tr>
<td colspan="7" align="right" bgcolor="#FFCCCC"><? echo number_format($totalAmount,2);?></td>
</tr>
	 </table>
  </td>
 </tr>

 <tr>
   <td>
   

  <table align="left" width="98%" border="0" bordercolor="#000000" bgcolor="F8F8F8" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
 <tr>
   <td align="center" colspan="2" bgcolor="#E4E4E4" height="30">Receiving Schedule</td>
 </tr>
 <? 
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sqlp = "SELECT * from  `porder` WHERE posl='$posl' ORDER by itemCode ASC";
//echo $sqlp;
$sqlrunp= mysql_query($sqlp);

$totalAmount=0;
 while($typel1= mysql_fetch_array($sqlrunp))
{
$temp=itemDes($typel1[itemCode]);
?>
    <tr> 
      <td align="left" bgcolor="#EEEEEE" colspan="2"><b><? echo "$typel1[itemCode] $temp[des] $temp[spc]";?> </b></td>
    </tr>
<? 
$dd=array();
$qt=array();

$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sqlp1 = "SELECT * from  `poschedule` WHERE posl='$posl' AND itemCode='$typel1[itemCode]' ORDER by sdate ASC";
//echo '-------'.$sqlp1.'----------';
$sqlrunp1= mysql_query($sqlp1);
$j=1;

$dd[0]=$typel1[dstart];

 while($typel2= mysql_fetch_array($sqlrunp1))
{
$dd[$j]=$typel2[sdate];
$qt[$j]=$typel2[qty];
$j++;
} //
for($l=0,$m=1;$l<sizeof($qt);$l++,$m=$l+1){
?>	
    <tr>
	  <td> <? echo $m;?>. </td>
	  <td >Supply <b><? echo number_format($qt[$m]);?> </b><? echo $temp[unit]?> between <?	  
	  if($l==0) echo date("d-m-Y",strtotime($dd[0]));
	   else  echo date("d-m-Y",strtotime($dd[$l])+86400);?> to	   
	    <? echo date("d-m-Y",strtotime($dd[$m]));?></td>	  
	</tr> 
<?  } //for?>
 <tr>
 	<td > </td>
 	<td >Supply Details: <? echo $typel1[deliveryDetails];?></td>
</tr>	
 <tr>
   <td height="20"></td>
 </tr>

 <? } //while?>
 <tr>
   <td></td>
 </tr>
</table>
   </td>
 </tr>
 
 <tr>
  <td>
  <table align="left" width="98%" border="0" bordercolor="#000000" bgcolor="F8F8F8"  cellpadding="0" style="border-collapse:collapse">
 <tr>
   <td align="center" colspan="3" bgcolor="#E4E4E4" height="30">Invoice Schedule</td>
 </tr>

<? $dat=poInvoiceDate($posl);
for($i=1;$i<=sizeof($dat);$i++){
?>
<tr>
<td>
 <? echo "Invoice $i:  Raise after supply completion ";
 $invtemp=scheduleReceiveperInvoice($posl,$dat[$i]);
 for($j=1;$j<=sizeof($invtemp);$j++){
 $temp=itemDes($invtemp[$j][0]);
 echo ' '.$invtemp[$j][1].' '.$temp[unit].' of item '.$j.', ';
 }//for j
 ?>
</td>
</tr>

	
 <? }// for?>
 <tr>
   <td></td>
 </tr>
</table>
  
  </td>
 </tr>
 <tr>
   <td>
   <? if($type==3) include('./poUnder/sub_conditionp.php');  else  include('conditionp.php');  ?>
   
   </td>
 </tr> 
</table>
<? } else {?>
<table width="100%" align="center" cellspacing="0"  cellpadding="10">
<tr>
 <td>
 
  <table align="left" width="98%" border="0" bordercolor="#000000" bgcolor="#FFFFEE" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
    <tr bgcolor="#FFFFCC"> 
      <td align="left" height="30" > Purchase Order No.: <? echo viewPosl($posl);?> </td>
      <td align="right"> <?  echo $podate;//echo date("F d, Y.");?> </td>	  
    </tr>
	<tr>	  <td colspan="2" height="10" > </td>	  </tr>
	 <? include("../includes/config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$vendor = "SELECT * from `vendor` WHERE vid=$vid";
//echo $sqlp;
$sqlr= mysql_query($vendor);
$vendor = mysql_fetch_array($sqlr);
?>
 <TR >
  <TD colspan="2"><b> <? echo $vendor[vname];?></b></TD>
 </TR>
 <TR >
  <TD colspan="2"><? echo $vendor[address];?></TD>
 </TR>
 <TR>
  <TD colspan="2"><br><br>Subject: <b>Work Order for Supply of Equipment at <? echo myprojectName($project);?></b><br><br>
  </TD>  
 </TR>
	  
</table>
 </td>
 </tr>
 <tr>
  <td>
  <table align="left" width="98%" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
    <tr> 
	  <th>SL.#</th>
      <th>BFEW's Store Code</th>
      <th>Description</th>
      <th>Quantity</th>	  
      <th>Duration</th>	  
      <th>Unit Rate</th>
    </tr>
    <? 
if($vid){


$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sqlp = "SELECT * from  `porder` WHERE posl='$posl'";
//echo $sqlp;
$sqlrunp= mysql_query($sqlp);

$i=1;
 while($typel1= mysql_fetch_array($sqlrunp))
{
$sdate = $typel1[dstart];
$status=$typel1[status];
$temp=itemDes($typel1[itemCode]);
?>
<? 

$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sqlp1 = "SELECT * from  `poschedule` WHERE posl='$posl'";
//echo $sqlp;
$sqlrunp1= mysql_query($sqlp1);
$typel2= mysql_fetch_array($sqlrunp1);
$edate = $typel2[sdate];
$itemDes[$i]=$temp[des];
$deliveryDetails[$i]=$typel1[deliveryDetails];
$dstart[$i]=$typel1[dstart];
$qty[$i]=$typel1[qty];
$itemUnit[$i]=$temp[unit];
 ?>

    <tr> 
	   <td align="center"><? echo $i;?>.</td>
      <td align="center"><a href="./index.php?keyword=purchase+order+vendor&project=<? echo $project;?>&itemCode=<? echo $typel1[itemCode];?>" target="_blank" title="View All Related vendor"><? echo $typel1[itemCode];?></a> </td>
      <td>  <?  echo $temp[des];?>    </td>
          <td align="right"> <a href="./planningDep/eqdailyRequirment.php?project=<? echo $typel1[location];?>&itemCode=<? echo $typel1[itemCode];?>" target="_blank"> 
            <? echo number_format($typel1[qty],3);?> Nos</a> </td>
      <td align="right"><?  $duration =1+(strtotime($edate)-strtotime($sdate))/86400; echo round($duration); ?> days</td>	  
      <td align="right">Tk.<? echo number_format($typel1[rate],2)?> /nos/day   </td>
    </tr>
    <?
$i++;
} //while

}//if?>
	 </table>
  </td>
 </tr>

 <tr>
   <td>
   

  <table align="left" width="98%" border="0" bordercolor="#000000" bgcolor="F8F8F8" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
 <tr>
   <td align="center" colspan="2" bgcolor="#E4E4E4" height="30">Receiving Schedule</td>
 </tr>
 <? 
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sqlp = "SELECT * from  `porder` WHERE posl='$posl'";
//echo $sqlp;
$sqlrunp= mysql_query($sqlp);

$totalAmount=0;
 while($typel1= mysql_fetch_array($sqlrunp))
{
$temp=itemDes($typel1[itemCode]);
?>
    <tr> 
      <td align="left" bgcolor="#EEEEEE" colspan="2"><b><? echo "$typel1[itemCode] $temp[des] $temp[spc]";?> </b></td>
    </tr>
<? 
$dd=array();
$qt=array();
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sqlp1 = "SELECT * from  `poschedule` WHERE posl='$posl' AND itemCode='$typel1[itemCode]' ORDER by sdate ASC";
//echo '-------'.$sqlp1.'----------';
$sqlrunp1= mysql_query($sqlp1);
$j=1;

$dd[0]=$typel1[dstart];

 while($typel2= mysql_fetch_array($sqlrunp1))
{
$dd[$j]=$typel2[sdate];
$qt[$j]=$typel2[qty];
$j++;
} //
for($l=0,$m=1;$l<sizeof($qt);$l++,$m=$l+1){
?>	
    <tr>
	  <td> <? echo $m;?>. </td>
	  <td >Supply <b><? echo number_format($qt[$m]);?> </b><? echo $temp[unit]?> between <?	  
	  if($l==0) echo date("d-m-Y",strtotime($dd[0]));
	   else  echo date("d-m-Y",strtotime($dd[$l])+86400);?> to	   
	    <? echo date("d-m-Y",strtotime($dd[$m]));?></td>	  
	</tr> 
<?  } //for?>
 <tr>
 	<td > </td>
 	<td >Supply Details: <? echo $typel1[deliveryDetails];?></td>
</tr>	
 <tr>
   <td height="20"></td>
 </tr>

 <? } //while?>
 <tr>
   <td></td>
 </tr>
</table>
   </td>
 </tr>
 
 <tr>
  <td>
  <table align="left" width="98%" border="0" bordercolor="#000000" bgcolor="F8F8F8"  cellpadding="0" style="border-collapse:collapse">
 <tr>
   <td align="center" colspan="3" bgcolor="#E4E4E4" height="30">Invoice Schedule</td>
 </tr>

<? $dat=poInvoiceDate($posl);
for($i=1;$i<=sizeof($dat);$i++){
?>
<tr>
<td>
 <? echo "Invoice $i:  Raise after supply completion ";
 $invtemp=scheduleReceiveperInvoice($posl,$dat[$i]);
 for($j=1;$j<=sizeof($invtemp);$j++){
 $temp=itemDes($invtemp[$j][0]);
 echo ' '.$invtemp[$j][1].' '.$temp[unit].' of item '.$j.', ';
 }//for j
 ?>
</td>
</tr>

	
 <? }// for?>
 <tr>
   <td></td>
 </tr>
</table>
  
  </td>
 </tr>
 <tr>
   <td></td>
 </tr>
</table>
   </td>
 </tr>
 <tr>
   <td><?  include('eqconditionp.php');  ?>
   </td>
 </tr> 
</table>
<? }?>
<? if($status=='-1' AND $loginDesignation=='Accounts Manager'){?><input type="button" onClick="location.href='./planningDep/poUnder/forwardforApproval.sql.php?posl=<? echo $posl?>&status=<? echo $status?>'" name="approved" value="Forward for Approval"><? }?>
<? if($status=='0' AND $loginDesignation=='Managing Director'){?><input type="button" onClick="location.href='./planningDep/poUnder/pobackforedit.sql.php?posl=<? echo $posl?>&status=<? echo $status?>'" name="approved" value="Back for Edit">
<input type="button" onClick="location.href='./planningDep/poUnder/poApprove.sql.php?posl=<? echo $posl?>&status=<? echo $status?>'" name="approved" value="Approve">
<? }?>
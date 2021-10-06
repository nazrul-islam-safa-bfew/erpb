<form name="searchIOW" action="./index.php?keyword=pmview+IOW" method="post">
<table width="90%"  align="center" border="1" bordercolor="#9999CC" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" style="border-collapse:collapse" >
 <tr><td>
 <table width="100%"  align="center" border="0" bordercolor="#9999CC" bgcolor="#FFFFFF" cellpadding="3" cellspacing="0" style="border-collapse:collapse" >
 <tr><td bgcolor="#9999CC" colspan="5" align="center"><font color="#FFFFFF" size="+1">All Item of Work (IOW) details </font></td></tr>
 <tr>
 <? 
 if($status=='Forward to MD') $r1='checked';
 else if($status=='Raised by PM') $r2='checked'; 
  else if($status=='Approved') $r3='checked';  
    else if($status=='Completed') $r4='checked'; 
      else if($status=='Not Ready') $r5='checked';  

// Approved by MD Approved by Mngr P&C
 ?>
     <td><input type="radio" name="status" <? echo $r1;?> value="Forward to MD">Waiting for MD's Approval (<? echo countiow("Forward to MD",'');?> nos)</td>
     <td><input type="radio" name="status" <? echo $r3;?> value="Approved">Approved (<? echo countapviow("Approved",'');?> nos)</td>
     <td><input type="radio" name="status" <? echo $r4;?> value="Completed">Completed (<? echo countapviow("Completed",'');?> nos)</td>

</tr>
<tr>
     <td><input type="radio" name="status" <? echo $r2;?> value="Raised by PM">Waiting for Mngr. P&C's Checking (<? echo countiow("Raised by PM",'');?> nos)</td>
     <td><input type="radio" name="status" <? echo $r5;?> value="Not Ready">Under Preparation (<? echo countiow("Not Ready",'');?> nos)</td>
</tr>


 <tr><td colspan="2">Select Project: <select name="selectedPcode">
<?php if($loginProject=="000"){ ?>
 <option value="">All Project</option>
<?
}
include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 
$sqlp = "SELECT `pcode`,pname from `project`";
//echo $sqlp;
$sqlrunp= mysql_query($sqlp);

if($loginProject=="000")
 while($typel= mysql_fetch_array($sqlrunp))
{
	 echo "<option value='".$typel[pcode]."'";
	 if($pcode==$typel[pcode])  echo " SELECTED";
	 echo ">$typel[pcode]--$typel[pname]</option>  ";
 }
 else
 {
	while($typel= mysql_fetch_array($sqlrunp))
		{
			if($loginProject==$typel[pcode])
			{
				 echo "<option value='".$loginProject."'";
					if($pcode==$loginProject)  echo " SELECTED";
				 echo ">$typel[pcode]--$typel[pname]</option>  ";
			}
		}
 }
?> </select>
</td>
 <td><input type="submit" name="search" value="Search"></td>	 
 </tr>
 <tr>
</table>   
</td></tr></table>
</form>
<?
include("./includes/config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 
if($r3 OR $r4){
$sqlp = "SELECT * from `iow` WHERE 1";
if($selectedPcode) $sqlp.= " AND iowProjectCode= '$selectedPcode'";
if($iow) $sqlp.= " AND iowCode= '$iow'";
if($status) $sqlp.= " AND iowStatus LIKE '%$status%'";
$sqlp.= " ORDER By iowProjectCode, iowId ASC";
//echo $sqlp;
$sqlrunp= mysql_query($sqlp);

}
else {
$sqlp = "SELECT * from `iowtemp` WHERE 1";
if($selectedPcode) $sqlp.= " AND iowProjectCode= '$selectedPcode'";
if($iow) $sqlp.= " AND iowCode= '$iow'";
if($status) $sqlp.= " AND iowStatus LIKE '%$status%'";
$sqlp.= " ORDER By iowProjectCode, iowId ASC";
//echo $sqlp;
$sqlrunp= mysql_query($sqlp);
}
?>

<table  align="center" width="98%" border="1" bordercolor="#E0E0E0" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#EEEEEE">
 <td align="center" height="30"><b>Project</b> </td> 
 <td align="center"><b>IOW Code</b></td>
 <td align="center"><b>Item of Work Description</b></td>
 <td align="center"><b>Qty</b> </td>
 <td align="center"><b>Unit</b> </td> 
 <td align="center"><b>Rate</b> </td>  
 <td align="center"><b>Amount</b></td>
</tr>
<? while($iow=mysql_fetch_array($sqlrunp)){?>
<tr>
 <td><? echo $iow[iowProjectCode];?></td>
 <td>
 <? 
  if($status=='Approved' OR $status=='Completed' )
	echo "<a href='./index.php?keyword=pmview+dma&selectedPcode=$iow[iowProjectCode]&iow=$iow[iowId]&iowStatus=$iow[iowStatus]'>";
 elseif($status=='Not Ready')    echo "<a href='./index.php?keyword=pmview+under+dma&selectedPcode=$iow[iowProjectCode]&iow=$iow[iowId]'>";
  else echo "<a href='./index.php?keyword=pmview+temp+dma&selectedPcode=$iow[iowProjectCode]&iow=$iow[iowId]'>"; 
 ?>

 <? echo $iow[iowCode].' (R:'.$iow[revisionNo].')';?> </a>
 <? getRevisionList($iow[iowId]);?>
 </td>
 <td ><? echo $iow[iowDes];?></td> 
 <td align="right"><? echo number_format($iow[iowQty]);?></td> 
 <td align="right"><? echo $iow[iowUnit];?></td>  
 <td align="right"><? echo number_format($iow[iowPrice],2);?></td> 
 <td align="right"><? echo number_format($iow[iowQty]*$iow[iowPrice],2);?>
 <? if($iow[iowStatus]=='Not Ready' AND $r5) {echo "<a href='./index.php?keyword=editIOW&selectedPcode=$iow[iowProjectCode]&iowId=$iow[iowId]'>Edit</a>"; }
   echo " [ ";
    if($status=="Approved"){echo "<a href='./print/print_approvedSIOW.php?selectedPcode=$iow[iowProjectCode]&iow=$iow[iowId]' target=_blank>Print</a>";} 
	elseif($status=="Not Ready"){echo "<a href='./print/print_underSIOW.php?selectedPcode=$iow[iowProjectCode]&iow=$iow[iowId]' target=_blank>Print</a>";}
	else{echo "<a href='./print/print_tempSIOW.php?selectedPcode=$iow[iowProjectCode]&iow=$iow[iowId]' target=_blank>Print</a>";}	
   echo " ] ";
   
$materialCost=materialCost($iow[iowId]);
$equipmentCost=equipmentCost($iow[iowId]);
$humanCost=humanCost($iow[iowId]);
$totalCost=$iow[iowQty]*$iow[iowPrice];
$directCost=$materialCost+$equipmentCost+$humanCost;

 ?>
 <br><font class="out">Dir. Exp. <? echo number_format(($directCost/$totalCost)*100);?>% </font>	
		
	</td>
</tr>
<? }   ?>
</table>
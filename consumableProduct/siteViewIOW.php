<form name="searchIOW" action="./index.php?keyword=site+iow+detail" method="post">
<table width="90%"  align="center" border="1" bordercolor="#9999CC" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" style="border-collapse:collapse" >
 <tr><td bgcolor="#9999CC" colspan="5" align="center"><font color="#FFFFFF" size="+1">All Item of Work (IOW) details</font></td></tr>
 <tr>
 <? 
 if($status=='Forward to MD') $r1='checked';
	 else if($status=='Forward to PM') $r2='checked';
		else if($status=='Approved'){ $r3='checked'; $eqStatus='Approved by MD';}
			else if($status=='Completed') $r4='checked';
				else if($status=='Not Ready') $r5='checked';
					else if($status=='revision') $r6='checked';
						else if($status=='Raised by CM') $r7='checked';

// Approved by MD Approved by Mngr P&C
 ?>
     <td><input type="radio" name="status" <? echo $r1;?> value="Forward to MD">Waiting for MD's Approval (<? echo countiow("Forward to MD",$loginProject);?> nos)</td>
     <td><input type="radio" name="status" <? echo $r3;?> value="Approved">Approved (<? if($loginDesignation=='Equipment Co-ordinator')echo countiow_maintenance_eqc("Approved by MD"); else echo countapviow("Approved",$loginProject);?> nos)</td>
     <td><input type="radio" name="status" <? echo $r4;?> value="Completed">Completed (<? echo countapviow("Completed",trim($loginProject));?> nos)</td>

</tr>
<tr>
     <td><input type="radio" name="status" <? echo $r2;?> value="Forward to PM">Waiting for Mngr. P&C's Checking (<? echo countiow("Forward to PM",trim($loginProject));?> nos)</td>
     <td><input type="radio" name="status" <? echo $r7;?> value="Raised by CM">Waiting for Mngr. C.M's Checking (<?  if($loginDesignation=='Equipment Co-ordinator')echo countiow_maintenance_eqc("Raised by CM",trim($loginProject)); else echo countiow("Raised by CM",trim($loginProject));?> nos)</td>
     <td><input type="radio" name="status" <? echo $r5;?> value="Not Ready">Under Preparation (<? if($loginDesignation=='Equipment Co-ordinator')echo countiow_maintenance_eqc("Not Ready",trim($loginProject)); else echo countiow("Not Ready",trim($loginProject));?> nos)</td>
</tr>
<tr>
	<td colspan="1" align="left" >
		<?php
if($loginDesignation=='Equipment Co-ordinator'){
	$psql="select pcode,pname from project order by pcode asc";
	$pQ=mysqli_query($db,$psql);
	echo "Select Project: <select name='pcode'>";
	while($pR=mysqli_fetch_array($pQ)){
		echo "<option value='$pR[pcode]'";
		echo $pR['pcode']==$pcode ? " selected " : "";
		echo ">$pR[pcode] - $pR[pname]</option>";
	}
	echo "</select>";
}
?>
	</td>
      <td colspan="2" align="left" >&nbsp; <input type="submit" name="search" value="Search"></td>
    </tr>
</table>
</form>


<?
if($c){
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp11 = "UPDATE iow SET siow='$c' where `iowCode` = '".trim($iow)."' ";
//echo $sqlp11;
$sqlrunp11= mysqli_query($db, $sqlp11);

}
echo "<b><u>Item Of Work List for </u></b>";
if($loginDesignation=='Equipment Co-ordinator'){
	echo "<u>$pcode</u><br><br>";
}
else
	echo "<u>$loginProject</u><br><br>";
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

//$sqlp = "SELECT * from `iow` where `iowProjectCode` LIKE '$selectedPcode' ";
//echo $sqlp;if($status) $sqlp.= " AND (iowStatus LIKE '%$status%' or iowStatus='noStatus')";
if($r3 || $r4){
	if($loginDesignation=='Equipment Co-ordinator'){
		$sqlp="SELECT * from `iow` WHERE ";
		if($eqStatus) $sqlp.=" iowStatus like '$eqStatus' ";
		 $sqlp.=" and iowProjectCode='004' and position like '888.%' ORDER BY position ASC";
		$sqlrunp= mysqli_query($db, $sqlp);
	}else{
		$sqlp = "SELECT * from `iow` WHERE  iowProjectCode='".trim($loginProject)."'";
		if($status) $sqlp.= " AND (iowStatus LIKE '%$status%' or iowStatus='noStatus')";
		$sqlp.=" ORDER BY position ASC";
		$sqlrunp= mysqli_query($db, $sqlp);
	}	
}
else{
	if($loginDesignation=='Equipment Co-ordinator'){
		$sqlp = "SELECT * from `iowtemp` WHERE iowProjectCode='$pcode'";
		//if($status) $sqlp.= " and (iowStatus='$status' or iowStatus='noStatus')
		//and ( ".maintenanceHeadSql(true,true," position like "," or ").")";
		if($r2)$sqlp.= " and (iowStatus like 'Raised by PM' or iowStatus='noStatus') ";
		if($r5)$sqlp.= " and (iowStatus like 'maintenance' or iowStatus='Not Ready' or iowStatus='noStatus') ";
		$sqlp.=" ORDER BY position ASC";
		$sqlrunp= mysqli_query($db, $sqlp);
	}else{
$sqlp = "SELECT * from `iowtemp` WHERE  iowProjectCode= '".trim($loginProject)."'";
if($status=='Approved') $sqlp.= " AND (iowStatus LIKE '%$status%' OR status = 'revision' or iowStatus='noStatus')";
else if($status) $sqlp.= " AND (iowStatus LIKE '%$status%' or iowStatus='noStatus')";
$sqlp.=" ORDER BY position ASC";
$sqlrunp= mysqli_query($db, $sqlp);
}
}
// echo "$sqlp<br>";
// echo mysqli_affected_rows($db);
// echo mysqli_error($db);
?>

<table  align="center" width="98%" border="1" bordercolor="#E0E0E0" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#EEEEEE">
 <td width="100"><b>IOW code</b></td>
 <td><b>Item of Work Description</b></td>
 <td width="100" align="center"><b>Total Qty</b> </td> 
 <td  width="10"align="center"><b>Unit</b></td>  
 <td align="center" width="100"><b>Total Amount</b></td>
 <td align="center" width="100"><b>IOW Supervisor</b></td> 
 <td width="130" align="center"><b>ACTION</b></td>  
</tr>
<? while($iow=mysqli_fetch_array($sqlrunp)){?>
<tr <? if($iow["iowStatus"]=='noStatus')echo "style='background:#ffc;font-weight: bold;'";?>>
 <td><? if($iow["iowStatus"]!='noStatus')echo $iow['iowCode'].' (R:'.$iow['revisionNo'].')';?></td>
 <td><? echo $iow['iowDes'];?></td> 
 <td align="right"><? if($iow["iowStatus"]!='noStatus')echo number_format($iow['iowQty']);?></td> 
 <td align="center"><? if($iow["iowStatus"]!='noStatus')echo $iow['iowUnit'];?></td> 
 <td align="right"><? if($iow["iowStatus"]!='noStatus')echo number_format($iow['iowQty']*$iow['iowPrice'],2);?></td> 
 <td align="center"><? if($iow["iowStatus"]!='noStatus'){ if($iow['supervisor']) echo supervisorDetails($iow['supervisor']);}?>
<? if($status!='Completed' && $iow["iowStatus"]!='noStatus'){?>
<br><a href="./consumableProduct/assignSupervisor.php?iow=<? echo "$iow[iowId]&iowProjectCode=$loginProject";?>">Assign/Change Supervisor</a>
 <? }?>
 </td>
    <td align="center"> 
      <? 
		 if($iow['iowStatus']=='Not Ready' || ($iow['iowStatus']=='maintenance' && $loginDesignation=='Equipment Co-ordinator')){
	    echo "<a href='./index.php?keyword=enter+sub+item+work&iow=$iow[iowId]&revisionNo=$iow[revisionNo]&iowStatus=$iow[iowStatus]'>SIOW</a> || ";
        echo "<a href='./index.php?keyword=site+view+dma&iow=$iow[iowId]&iowStatus=$iow[iowStatus]'>Detail</a>";
		}
		else{
			if($iow["iowStatus"]!='noStatus'){
				if(($status=='Approved' OR $status=='Completed'))
							echo "<a href='./index.php?keyword=pmview+dma&iow=$iow[iowId]&selectedPcode=$iow[iowProjectCode]&iowStatus=$iow[iowStatus]'>Detail</a>";		
					else 
							echo "<a href='./index.php?keyword=pmview+temp+dma&iow=$iow[iowId]&selectedPcode=$iow[iowProjectCode]&iowStatus=$iow[iowStatus]'>Detail</a>";	
			 }
	}
	if($iow["iowStatus"]!='noStatus'){
		 echo " [ ";
    if($status=="Approved"){echo "<a href='./print/print_approvedSIOW.php?selectedPcode=$iow[iowProjectCode]&iow=$iow[iowId]' target=_blank>
	<img src='./images/b_print.png' border=0></a>";} 
	elseif($status=="Not Ready"){echo "<a href='./print/print_underSIOW.php?selectedPcode=$iow[iowProjectCode]&iow=$iow[iowId]' target=_blank><img src='./images/b_print.png' border=0></a>";} 
	else{echo "<a href='./print/print_tempSIOW.php?selectedPcode=$iow[iowProjectCode]&iow=$iow[iowId]' target=_blank><img src='./images/b_print.png' border=0></a>";} 
   echo " ] ";
	}
?>
    </td>
</tr>
<? } ?>
</table>
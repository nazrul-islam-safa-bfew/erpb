<?php
$width=$width ? $width : 600;
?>
<table width="<?php echo $width; ?>"  align="center" border="1" bordercolor="#9999CC" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
	<tr><td colspan="2"  bgcolor="#9999CC">Revision History</td></tr>
	<?php
	$listdata=array();
	function printRevisionTxt($no=null,$txt=null,$bk=null){
		if(!$txt)return false;
		if(is_JSON($txt)){
			$txtJson=json_decode($txt);
			foreach($txtJson as $key=>$val){}
			if($key!="_empty_"){
				if($key=="MD")
					$key="<b>BfR by $key<b>";
				elseif(strpos($key,"CM")>-1 || trim($key)=="PM")
					$key="<b>BfR by $key:</b>";
				else
					$key="$key";
			}else
				$key="";
			
		}else{
			$val=$txt;
		}
		
		
		$valDate=substr($val,0,10);
		if(intval($valDate)>0){
			$val=substr($val,10,strlen($val));
		}
		else{
			$valDate="";
		}
		global $listdata;
		if($bk)
			$bk="<span style='border:1px solid #fff;border-radius: 5px; background: #f00; color: #fff; padding:1px;'>$bk</span>";
		$listdata[]=array($valDate,"<tr><td width=\"110\">R:$no, <small>$valDate</small> </td><td><font class=\"\">$key $bk</font> <font class=\"\"> $val</font></td></tr>");
	}
	
	$revSql="select revisionTxt,revisionNo,mdRevisionTxt from iowtemp where iowId='$iow' and (CHAR_LENGTH(revisionTxt)>0 or CHAR_LENGTH(mdRevisionTxt)>0) order by revisionNo desc";
// 	echo $revSql;
	$revQ=mysqli_query($db,$revSql);
	while($revRow=mysqli_fetch_array($revQ)){
		printRevisionTxt($revRow['revisionNo'],$revRow['mdRevisionTxt'],"BfR by MD");
		printRevisionTxt($revRow['revisionNo'],$revRow['revisionTxt']);
	}
	$iowBack=mysqli_affected_rows($db);
	$revSql="select revisionTxt,revisionNo,mdRevisionTxt from iowback where iowId='$iow' and (CHAR_LENGTH(revisionTxt)>0 or CHAR_LENGTH(mdRevisionTxt)>0) order by revisionNo desc";
// 	echo $revSql;
	$revQ=mysqli_query($db,$revSql);
	while($revRow=mysqli_fetch_array($revQ)){
		printRevisionTxt($revRow['revisionNo'],$revRow['mdRevisionTxt'],"BfR by MD");
		printRevisionTxt($revRow['revisionNo'],$revRow['revisionTxt']);
	}
	
	$sqlDailty="select clientdes,todat from iowdaily where iowId='$iow' and char_length(clientdes)>1 order by id desc limit 10";
	$qDaily=mysqli_query($db,$sqlDailty);
	while($rowDaily=mysqli_fetch_array($qDaily)){
		$strDate=date("d/m/Y",strtotime($rowDaily['todat']));
		$listdata[]=array($strDate,"<tr><td width=\"110\"><small>$strDate</small> </td><td><b class=\"\">Site Engn:</b> <font class=\"\"> $rowDaily[clientdes]</font></td></tr>");
	}
	
		asort($listdata);
		foreach($listdata as $lData){
			echo $lData[1];
		}
	
	if(mysqli_affected_rows($db)<1 && $iowBack<1){
		echo '<tr><td colspan="2"  align="center">No history found!</td></tr>';
	}
	?>
</table>
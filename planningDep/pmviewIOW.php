<?php
if($_SESSION['jQuery']!=1){
	$_SESSION['jQuery']=1;
	header("Refresh");
}
$loginProject = trim($loginProject);
?>
<script type="text/javascript" src="./js/jquery.mask.js"></script>
<form name="searchIOW" action="./index.php?keyword=pmview+IOW" method="post">
<table width="90%"  align="center" border="1" bordercolor="#9999CC" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" style="border-collapse:collapse" >
 <tr><td>
 <table width="100%"  align="center" border="0" bordercolor="#9999CC" bgcolor="#FFFFFF" cellpadding="3" cellspacing="0" style="border-collapse:collapse" >
 <tr><td bgcolor="#9999CC" colspan="5" align="center"><font color="#FFFFFF" size="+1">All Item of Work (IOW) details</font></td></tr>
 <tr>
 <? 
 if($status=='Forward to MD') $r1='checked';
 else if($status=='Forward to PM') $r2='checked'; 
  else if($status=='Approved') $r3='checked';  
    else if($status=='Completed') $r4='checked'; 
      else if($status=='Not Ready') $r5='checked';  
					else if($status=='Raised by CM') $r7='checked';

// Approved by MD Approved by Mngr P&C
 ?>
     <td><input type="radio" name="status" <? echo $r1;?> value="Forward to MD">Waiting for MD's Approval (<? echo countiow("Forward to MD",'');?> nos)</td>
     <td><input type="radio" name="status" <? echo $r3;?> value="Approved">Approved (<? echo countapviow("Approved",'');?> nos)</td>
     <td><input type="radio" name="status" <? echo $r4;?> value="Completed">Completed (<? echo countapviow("Completed",'');?> nos)</td>

</tr>
<tr>
     <td><input type="radio" name="status" <? echo $r2;?> value="Forward to PM">Waiting for Mngr. P&C's Checking (<? echo countiow("Forward to PM",'');?> nos)</td>
     <td><input type="radio" name="status" <? echo $r7;?> value="Raised by CM">Waiting for Mngr. C.M's Checking (<? echo countiow("Raised by CM",'');?> nos)</td>
     <td><input type="radio" name="status" <? echo $r5;?> value="Not Ready">Under Preparation (<? echo countiow("Not Ready",'');?> nos)</td>
</tr>


 <tr><td colspan="2">Select Project: <select name="selectedPcode">
<?php if($loginProject=="000" || ($r3 && $loginDesignation=="Project Engineer")){ ?>
 <option value="">All Project </option>
<?
}
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 
$sqlp = "SELECT `pcode`,pname from `project` order by pcode";
//echo $sqlp;
$sqlrunp=mysqli_query($db,$sqlp);

if($loginProject=="000" && $loginDesignation!='Project Engineer')
 while($typel= mysqli_fetch_array($sqlrunp))
{
	 echo "<option value='".$typel['pcode']."'";
	 if($selectedPcode==$typel['pcode'])  echo " SELECTED ";
	 echo ">$typel[pcode]--$typel[pname]</option>  ";
 }
 else
 {
	if(!$r3)$selectedPcode=$loginProject;

	while($typel= mysqli_fetch_array($sqlrunp)){
			if($loginProject==$typel['pcode']){
				 echo "<option value='".$loginProject."'";
					if($pcode==$loginProject)  echo " SELECTED";
				 echo ">$typel[pcode]--$typel[pname]</option>  ";
			}
		}
 }
?></select>
</td>
<td>
	 <input type="submit" name="search" value="Search">
</td>
 </tr>
 <tr>
</table>   
</td></tr></table>
</form>
<?
$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
include($localPath."/includes/config.inc.php"); //datbase_connection
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

if($r3 OR $r4){
		if($loginDesignation=='Equipment Co-ordinator'){
	$sqlp = "SELECT * from `iow` WHERE iowProjectCode='$selectedPcode'";

// 			if($r3)$sqlp.= " and (iowStatus like 'Raised by PM' or iowStatus='noStatus') ";
			if($r3)$sqlp.= " and (iowStatus like 'Approved by MD' or iowStatus='noStatus') ";
			if($r5)$sqlp.= " and (iowStatus like 'maintenance' or iowStatus='Not Ready' or iowStatus='noStatus') ";

	$sqlp.= " and (".maintenanceHeadSql(true,true," position like "," or ").")";
	$sqlp.= " ORDER By position ASC";
}else{

	$sqlp = "SELECT * from `iow` WHERE 1";
	if($selectedPcode) $sqlp.= " AND iowProjectCode='$selectedPcode'";
	if($loginDesignation=='Project Engineer')if(!$r3)$sqlp.= " or iowProjectCode!='' ";
	if($iow) $sqlp.= " AND iowCode= '$iow'";
	if($status) $sqlp.= " AND (iowStatus LIKE '%$status%' or iowStatus='noStatus')";

	if($loginDesignation=='Project Engineer')$sqlp.= "  ORDER By iowProjectCode,position ASC";
	else $sqlp.= "  ORDER By position ASC";
// 	echo $sqlp;
	$sqlrunp= mysqli_query($db, $sqlp);

	}

}
else{
		if($loginDesignation=='Equipment Co-ordinator'){
$sqlp = "SELECT * from `iowtemp` WHERE iowProjectCode='$selectedPcode'";
if($status) $sqlp.= " "; // Xhead
			
			
		if($r2)$sqlp.= " and (iowStatus like 'Raised by PM' or iowStatus='noStatus') ";
		if($r5)$sqlp.= " and (iowStatus like 'maintenance' or iowStatus='Not Ready' or iowStatus='noStatus') ";
			
$sqlp.= " and (".maintenanceHeadSql(true,true," position like "," or ").")";
$sqlp.= " ORDER By position ASC";
}else{
	$sqlp = "SELECT * from `iowtemp` WHERE 1";
	if($selectedPcode) $sqlp.= " AND iowProjectCode='$selectedPcode'";
	if($iow) $sqlp.= " AND iowCode='$iow'";
	if($status) $sqlp.= " AND (iowStatus LIKE '%$status%' or iowStatus='noStatus')";
	$sqlp.= " ORDER By position ASC";
}
// echo $sqlp;

}
// echo $sqlp;
if($sqlp)
	$sqlrunp=mysqli_query($db, $sqlp);
// echo $sqlp;
?>
<style>
	.numbering_cell{padding:0 5px; color:#555;}
	.noStatus{    background: #ffc;    font-weight: 700;}
	.thisEditor{display:none;}
	.edited{background:#fff; animation:success 2s; -webkit-animation:success 2s;}
	.successTxt{color:#000; font-weight:800;}
	
	/* Chrome, Safari, Opera */
@-webkit-keyframes success {
    0% {background-color: white;}
    50% {background-color: red;}
    60% {background-color: white;}
    80% {background-color: red;}
    100% {background-color: white;}
}

/* Standard syntax */
@keyframes success {
    0% {background-color: white;}
    50% {background-color: red;}
    60% {background-color: white;}
    80% {background-color: red;}
    100% {background-color: white;}
}
	
</style>
<table  align="center" width="98%" border="1" bordercolor="#E0E0E0" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#EEEEEE">
<?php
	if($loginDesignation=='Project Engineer' or $loginDesignation=='Equipment Co-ordinator'){
		?>
	<td align="center"></td>
	<td align="center"></td>
	<td align="center"></td>
	<td align="center"></td>
	<?php } ?>
 <td align="center" height="30"><b>Project</b> </td> 
 <td align="center"><b>IOW Code</b></td>
 <td align="center"><b>Item of Work Description</b></td>
 <td align="center"><b>Qty</b></td>
 <td align="center"><b>Unit</b></td> 
 <td align="center"><b>Rate</b></td>  
 <td align="center" <?php ?>><b>Amount</b></td>
</tr>
<? 
	
while($iow=mysqli_fetch_array($sqlrunp)){
	$position=count_dot_number($iow['position']);
	$firstPos=$secondPos=$thirdPos=$fourthPos=null; //assign all variable init is null
	$iow_position_new_format=(position_number_format($iow['position'])); //position input format 000.000.000.000 & assign output in array like [0]=>0,[0]=>10,[0]=>2,[0]=>1

	if($position=="1")$firstPos=$iow_position_new_format;
	if($position=="2")$secondPos=$iow_position_new_format;
	if($position=="3")$thirdPos=$iow_position_new_format;
	if($position=="4")$fourthPos=$iow_position_new_format;
?>
<tr  class="<?php echo $iow['iowStatus'];?>" style="<? if($iow["position"]=="999.000.000.000")echo "background:#f00;color:#fff;"; ?>">
	<?php if($loginDesignation=='Project Engineer' || $loginDesignation=='Equipment Co-ordinator'){ ?>
	<td align="left" class="numbering_cell"><?php echo $firstPos; ?>
		<?php if($selectedPcode){ ?><input size="15" rel="<?php echo $iow['iowId']; ?>" type="text" name="thisEditor" class="thisEditor" value="<?php echo $iow['position']; ?>"><?php } ?>
	</td>
	<?php if($iow['iowStatus']=='noStatus')echo "";?>
	<td align="left" class="numbering_cell"><?php echo $secondPos; ?></td>
	<td align="left" class="numbering_cell"><?php echo $thirdPos; ?></td>
	<td align="left" class="numbering_cell"><?php echo $fourthPos; ?></td>
	<?php } ?>
 <td><? if($iow['iowStatus']!='noStatus')echo $iow['iowProjectCode'];?></td>
	
 <td>
 <? 
	if($iow['iowStatus']!='noStatus')
		if($status=='Approved' OR $status=='Completed')
		echo "<a href='./index.php?keyword=pmview+dma&selectedPcode=$iow[iowProjectCode]&iow=$iow[iowId]&iowStatus=$iow[iowStatus]'>";
	 elseif($status=='Not Ready')echo "<a href='./index.php?keyword=pmview+under+dma&selectedPcode=$iow[iowProjectCode]&iow=$iow[iowId]'>";
		else echo "<a href='./index.php?keyword=pmview+temp+dma&selectedPcode=$iow[iowProjectCode]&iow=$iow[iowId]'>"; 
 ?>

 <? 
	
	if($iow['iowStatus']!='noStatus')echo $iow['iowCode'].' (R:'.$iow['revisionNo'].')';?> </a>
 <? 
	if($iow['iowStatus']!='noStatus')getRevisionList($iow['iowId']);?>
 </td>
 <td <?php if($iow['iowStatus']=='noStatus')echo "colspan='4'"; ?>><? echo $iow['iowDes'];?></td> 
<?php if($iow['iowStatus']!='noStatus'){

?>

 <td align="right"><? 
	if($iow['iowStatus']!='noStatus') echo number_format($iow['iowQty']);?></td> 
 <td align="right"><? 
	if($iow['iowStatus']!='noStatus') echo $iow['iowUnit'];?></td>  
 <td align="right"><? 
	if($iow['iowStatus']!='noStatus') echo number_format($iow['iowPrice'],2);?></td> 
 <td align="right"><? 
	if($iow['iowStatus']!='noStatus') echo number_format($iow['iowQty']*$iow['iowPrice'],2);?>
 <? 
	if($iow['iowStatus']!='noStatus'){ if(($iow['iowStatus']=='Not Ready' || $iow['iowStatus']=='maintenance') AND $r5) {echo "<a href='./index.php?keyword=editIOW&selectedPcode=$iow[iowProjectCode]&iowId=$iow[iowId]'>Edit</a>";}
   echo " [ ";
	}
	if($iow['iowStatus']!='noStatus'){
    if($status=="Approved"){echo "<a href='./print/print_approvedSIOW.php?selectedPcode=$iow[iowProjectCode]&iow=$iow[iowId]' target=_blank>Print</a>	";
if($loginDesignation=='Project Engineer' || $loginDesignation=='Equipment Co-ordinator'){echo "| <input type=button value='Copy' onClick=\"window.open('./pickIOW.php?iow=".$iow['iowId']."','Iow picker','width=450,height=400')\"; />";}
	
} 
	elseif($status=="Not Ready"){echo "<a href='./print/print_underSIOW.php?selectedPcode=$iow[iowProjectCode]&iow=$iow[iowId]' target=_blank>Print</a>";}
	else{echo "<a href='./print/print_tempSIOW.php?selectedPcode=$iow[iowProjectCode]&iow=$iow[iowId]' target=_blank>Print</a>";}
   echo " ] ";
		
  }
	
	
$materialCost=materialCost($iow['iowId']);
$equipmentCost=equipmentCost($iow['iowId']);
$humanCost=humanCost($iow['iowId']);
$totalCost=$iow['iowQty']*$iow['iowPrice'];
$directCost=$materialCost+$equipmentCost+$humanCost;

if($iow['iowStatus']!='noStatus'){
 ?>
 <br><font class="out">Dir. Exp. <? echo number_format(($directCost/$totalCost)*100);?>% </font>	
	<?php }
?>
	 
	 	 
<?php if($iow["iowType"]=="2"){
		$amountC=calculateDirectCost($iow['iowProjectCode'],$iow['iowId']);
	 ?>
	 <div align=right style="display:inline-block; float:right; font-weight:100; min-width:350px;">
		Tk. <span><?php echo $amountC[0]; ?></span> is <span><?php echo $amountC[1]; ?></span>% of Bid Total
	 </div>
<?php } ?>
	 
	</td>
<?php } //if header http://win4win.biz/erp/bfew/copyThat.php?iowId=
	if($iow['iowStatus']=='noStatus'){ echo "<td align='right'> 
	<a href='./copyThat.php?iowId=$iow[iowId]' target='_blank'>Copy</a> ";
	
	
														
	 
 if($iow["position"]=="999.000.000.000"){
		$amountC=calculateDirectCost($iow['iowProjectCode']);
	 ?>
	 <div align=right style="display:inline-block; float:right; font-weight:100;">
		Approved + Completed amount Tk. <span><?php echo $amountC[0]; ?></span> is <span><?php echo $amountC[1]; ?></span>% of Bid Total
	 </div>
<?php  }
	
	echo "
	<!--<a href='./index.php?keyword=editIOW&iowDelete=$iow[iowId]' onClick='if(confirm(\"Are you sure, you want to delete?\")!=true)return false;' >Delete</a>	-->
	</td>"; }
	

		
		

?>

</tr>
<? 
//sub shorting group option

}   ?>
</table>
<?php  if($selectedPcode && $loginDesignation=="Project Engineer" && $r3){ ?>
<script type='text/javascript'>

$(document).ready(function(){

  $('input.thisEditor').mask("999.999.999.999");// 	masking
	
	$(".numbering_cell").click(function(){
		$("input.thisEditor").hide();
	  var target=$(this);
		var thisEditor=target.parent().find("input.thisEditor");
		thisEditor.show();
	}).keydown(function(e){
		if(e.which=="13"){
	  	var target=$(this);			
			target.parent().removeClass("edited");
			var thisEditor=target.parent().find("input.thisEditor");
			var url="./iowPosEditor.php";
			var errorTxt="<p class=\"successTxt\">Error while sent position.</p>";
			if(thisEditor.val().length==15)
				$.post(url,{posID:thisEditor.attr("rel"),posVal:thisEditor.val()},function(data){
					if(data && data!="0"){
						thisEditor.hide();
						var successTxt='<p class="successTxt">New position: '+data+'</p>';
						thisEditor.parent().append(successTxt);
						target.parent().addClass("edited");
					}else{
						thisEditor.parent().append(errorTxt);
						alert("Error in network connection");
					}					
				});
			else{
				alert("Please input correct position.");
				return false;
			}
		}
		
	});
});
</script>
<?php } ?>
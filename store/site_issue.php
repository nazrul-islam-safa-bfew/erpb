<?
header('Content-Type: text/html; charset=ISO-8859-1');
include("../includes/session.inc.php");
include("../includes/config.inc.php");
$db=mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

include_once("../includes/myFunction.php");
include_once("../includes/myFunction1.php");
include_once("../includes/matFunction.inc.php");
include_once("../includes/eqFunction.inc.php");
require_once("../keys.php");
if($loginUname==''){echo "Please login again"; exit;}
$supervisor=$loginUname;
echo "<br>Supervisor Id:$supervisor<br>";

if($itemCode=='11-02-025' || $itemCode=='11-02-050' || $itemCode=='11-02-101' || $itemCode=='13-07-050')$isFuelType=true;


//echo "<!----".$au."---->";
$t_req=$REMOTE_ADDR;
/*$time=mktime(0,0,0, date("m"),date("d"),date("y"));
$todat = date("Y-m-d",$time);
*/
$todat=todat();

if($delete){
	$sql="DELETE from issue$loginProject WHERE issueSL='$issueSL'";
	//echo "$sql<br>";
	mysqli_query($db, $sql);
	$sql= "UPDATE store$loginProject set currentQty=currentQty+$issuedQty 
	where reference='$reference' AND itemCode='$itemCode' ";
		//		echo $sql.'<br>';
	$sqlqq=mysqli_query($db, $sql);

	echo "Issue deleting...<br> wait Please.. ";
	echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=site_issue.php?siow=$siow&itemCode=$itemCode&edate=$edate\">";
	exit;
}
//echo $todat;
$isf=isIssueFeture($loginProject,${itemCode.$i},$edate,null,$siow);
if($isf!=0){
	echo "<h1>This item issued at $isf.</h1>";
	exit;
}
$qtyatHand=qtyatHand($itemCode,$loginProject,$edate);
echo "qtyatHand=$qtyatHand<br>";
 if($qtyatHand>0){
  if($chk){
  //echo 'chk<br>';
	$remainQty=siow_qtyRemain($itemCode,$loginProject,$siow,$dmaQty);
  if($issuedQty<=$remainQty){
    if($remainQty>0){ $issuedQty=round($issuedQty,3);

			$itemCodeAr=explode("-",$itemCode);
			$selectedEq=explode("_",$selected_eq);
			if($selectedEq[2]!='ue' && !$km_h_qty && $isFuelType){echo '  <h1>Machine km/hour required</h1> ';exit;}
 if($issuedQty>0){

// 	 echo "<marquee><h1>Under construction. Please check later</h1></marquee>";exit();
	    $sqls="SELECT * from store$loginProject where itemCode='$itemCode' AND currentQty > 0 ORDER by rsid ASC";
// 		echo "$sqls<br>";
		$sqlsq=mysqli_query($db, $sqls);
		while($sr=mysqli_fetch_array($sqlsq) AND ${issuedQty.$i}>0){
		  if($issuedQty <= $sr["currentQty"]){
        $sqlp = "INSERT INTO issue$loginProject (issueSL, itemCode, iowId, siowId, issuedQtyTemp,issueRate, issueDate,reference,supervisor,  eqID,km_h_qty,unit)
        VALUES ('', '$itemCode', '$iow', '$siow', '$issuedQty', $sr[rate],'$edate','$sr[reference]','$supervisor', '$selectedEq[0]_$selectedEq[1]','$km_h_qty','$selectedEq[2]')";
//     echo $sqlp.'<br>';
        $sqlrunp= mysqli_query($db, $sqlp);

        $sql= "UPDATE store$loginProject set currentQty=($sr[currentQty]-$issuedQty) where rsid=$sr[rsid] ";
  // 			echo $sql.'<br>';
        $sqlqq=mysqli_query($db, $sql);
        $issuedQty=0;
		 }//if
		  else if($issuedQty > $sr[currentQty])
		  {
			$sqlp = "INSERT INTO issue$loginProject (issueSL, itemCode, iowId, siowId, issuedQtyTemp,issueRate, issueDate,reference,supervisor,  eqID,km_h_qty,unit)".
			"VALUES ('', '$itemCode', '$iow', '$siow', '$sr[currentQty]', $sr[rate],'$edate','$sr[reference]','$supervisor', '$selectedEq[0]_$selectedEq[1]','$km_h_qty','$selectedEq[2]')";
			//echo $sqlp.'<br>';
			$sqlrunp= mysqli_query($db, $sqlp);
			$issuedQty=$issuedQty-$sr[currentQty];
			
			$sql= "UPDATE store$loginProject set currentQty='0' where rsid=$sr[rsid] ";
			//echo $sql.'<br>';
			$sqlqq=mysqli_query($db, $sql);	
 		  }//else if
		}//while
		
		}//if
		}else {echo wornMsg('Your Infromation is saved and there is no Remaining Qty in this IOW');}
		
	}else{
		$temp=itemDes($itemCode);
		echo "<h1 style='color: red;text-align: center;text-decoration: blink;'>Check your remaining quantity <i>$remainQty</i> $temp[unit], You have wanted to issue <i>$issuedQty</i> $temp[unit]</h1>";
	}
}
}else {echo wornMsg('Not available in store');}
?>
<html>

<head>
<SCRIPT language=JavaScript src="../js/shimul.js" type=text/JavaScript></SCRIPT>
<link href="../style/basestyles.css" rel="stylesheet" type="text/css">
<link href="../style/indexstyle.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Language" content="en-us">
<meta name="author" content="<? echo $mauthor;?>">
<meta name="copyright" content="<? echo $tt;?>">
<meta name="keywords" content="<? echo $kword;?>">
<META NAME="description" CONTENT="<? echo $des;?>">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<title>BFEW :: material issue </title>

</head>
<body  topmargin="1" leftmargin="5" rightmargin="5" bgcolor="#FFFFFF" >

<form name="equt" id="equt" action="./site_issue.php?<? echo "itemCode=$itemCode&edate=$edate";?>" method="post">
Utilization Date: <? echo $edate;?>
<br>

Selected itemCode: <? $temp=itemDes($itemCode); echo $itemCode.', '.$temp[des].', '.$temp[unit];?>
<br>
<table align="center" width="98%" border="3"  bgcolor="#FFFFFF" bordercolor="CC9999" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td colspan="5" align="right" valign="top"><font class='englishhead'>material issue entry form of <? echo myDate($edate1);?></font></td>
</tr>
<tr>
 <th width="100">Work done Qty</th>
 <th >Work Remain Qty</th>  
 <th >Qty. on <? echo myDate($edate);?></th>   
 <th>IOW Code</th>
</tr>

<? 
	
	$itemCodeAr=explode("-",$itemCode);

$sqlppg="SELECT iow.*,siow.*,dma.dmasiow,dma.dmaQty from iow,`siow`,dma 
WHERE iow.iowprojectCode='$loginProject'
AND siow.siowId=dma.dmasiow AND dmaItemCode='$itemCode'
AND iow.supervisor='$supervisor'  AND siow.siowId='$siow' 
AND  siow.iowId=iow.iowId AND iowStatus LIKE 'Approved%'";
// echo '<br>'.$sqlppg.'<br>';
$sqlrunppg= mysqli_query($db, $sqlppg);
$i=1;
while($typelpg= mysqli_fetch_array($sqlrunppg)){
	$iow=$typelpg[iowId];
	$reQty=0;
	$reQty=$remainQty=siow_qtyRemainTemp($itemCode,$loginProject,$siow,$typelpg[dmaQty]);
	$qtyatHand=qtyatHandTemp($itemCode,$loginProject,$edate);
	$reQty=round($reQty,3);
// 	echo "$reQty>0 AND $qtyatHand>0";
if($reQty>0 AND $qtyatHand>0){
	
	$startItemCode='50-00-000';
	$endItemCode='69-99-999';
	
	$eq_sql="select eq.*,il.itemDes,ec.measureUnit from eqattendance eq,itemlist il, eqconsumsion ec, dma d where    
	eq.itemCode>='$startItemCode'
	and eq.itemCode<='$endItemCode'
	
	and il.itemCode=eq.itemCode
	
";
if($loginProject!="004")
	$eq_sql.="and eq.location='$loginProject'";
	
// 	$eq_row=get_eqid_from_iowcode_eng($typelpg[iowCode]);
	
	$eq_sql.=" and eq.action in ('P','HP')
	and eq.edate='$edate'	
	and ec.eqitemCode=il.itemCode ";
	
// 	$eq_sql.=" and ec.uitemCode='$eq_row' ";
	
	$eq_sql.=" and d.dmaItemCode=ec.eqitemCode
	and d.dmaiow='$iow'
	group by eq.itemCode,eq.eqId";
	$eq_q=mysqli_query($db,$eq_sql);
// echo $eq_sql;
}

	?>	
<tr>
  <td>
		
		<?php 
		if($itemCodeAr[0]=="11"){ ?>
		
		<span>
			Equipment: <select name='selected_eq' id='selected_eq' required>
			<option value=''></option>
			<?php
			$dat=todat();
			while($eq_row=mysqli_fetch_array($eq_q)){
				echo "<option attr='";
				echo measuerUnti2OriginalUnit($eq_row[measureUnit]);
				echo "' rel='";
				$lastUsage_val=getLastUsageofEQ($eq_row[eqId],$loginProject,$eq_row[itemCode]);
					echo $eq_row[measureUnit]!="ue" ? $lastUsage_val : "0";
					echo "' data-last-usage=' ";
						echo  $eq_row[measureUnit]!="ue" ? getLastQty($loginProject,$eq_row[eqId],$eq_row[itemCode]) : 
					getUsageofEQ($eq_row[itemCode],$eq_row[eqId],$dat)." Hr. on:".date("d/m/Y",strtotime($dat));
				echo "' value='$eq_row[eqId]_$eq_row[itemCode]_$eq_row[measureUnit]'>$eq_row[itemCode]$eq_row[eqId]: $eq_row[itemDes] ("
					.measuerUnti2Des($eq_row[measureUnit]).
					") </option>";
			}
			?>
			</select>
		</span>
		<?php if($isFuelType){ ?> 
		<br>
		<span id="unitHolderRow">
			Last Usage: &nbsp; <input type="text" readonly value="" id="last_usage" style="border:none;width:220px;">
		<br>
		</span>
		<span id="km_h_qty_row">
			Current Usage: &nbsp; <input type="number" name="km_h_qty" id="km_h_qty" value="" > <span id="unitHolder"></span>
		</span>
		<?php } //is fuel only ?>
		<br>
	<?php	} //is 11 code ?>
		
		Quantity: &nbsp; <input type="number" name="issuedQty" id="issuedQty" size="10"  onBlur="if(this.value><? echo $reQty;?> || this.value><? echo $qtyatHand;?>) {alert('You are Exceding remaining Qty!!'); this.value=0;}" class="number"> <? echo $temp[unit];?></td>
  <td align="right"><? echo number_format($reQty,3);?>
   <input type="hidden" name="reQty" value="<? echo $reQty;?>">
   <input type="hidden" name="dmaQty" value="<? echo $typelpg[dmaQty];?>">
  <? echo $temp[unit];?></td>
  <td align="right"><? echo number_format($qtyatHand,3)?>  <? echo $temp[unit];?></td>
  <td>  
<? echo "<font color=006600>$typelpg[iowCode]</font>  $typelpg[iowDes]";
echo "<br><font color=006600>$typelpg[siowCode]</font>  $typelpg[siowName]";
?>
  <input type="hidden" name="iow" value="<? echo $typelpg[iowId];?>">
  <input type="hidden" name="siow" value="<? echo $typelpg[siowId];?>"> 
    </td>  
 </tr>
 <? $i++;
 }
	
	?>
</table>


<input type="hidden" name="chk" value="1">
<p align="center"><input type="button" name="Save" value="Save" id="submitBtn"></p>

</form>
<table align="center" width="98%" border="3" bgcolor="#FFFFFF"  bordercolor="CC9999" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td colspan="5" align="right" valign="top"><font class='englishhead'>material issue report of <? echo myDate($edate1);?></font></td>
</tr>
<tr>
 <th>Issued SL</th>
 <th>Issued Qty</th>
 <th>Equipment</th>
 <th>Date</th> 
<!--  <th width="100">Action</th> -->
</tr>
<? 
$sqlut="SELECT * FROM issue$loginProject 
WHERE itemCode='$itemCode' /*AND  supervisor='$supervisor'*/ AND siowId='$siow' ORDER by issueDate DESC,issueSL ASC /*limit 0,100*/";
//echo $sqlut;
$sqlqut=mysqli_query($db, $sqlut);
$i=1;
	if(mysqli_affected_rows($db)>0)
 while($reut=mysqli_fetch_array($sqlqut))
{ // echo "$reut[issueDate]==$edate"; 
?>
<tr <? if($reut[issueDate]==$edate) echo " bgcolor=#EFEFEF ";?> >
 <td>
		<?php if($reut[issuedQtyTemp]>0){ ?>
  <a onClick='if(confirm("You are going to DELETE this Receive. Are you sure ?"))
 window.location="site_issue.php?delete=1&issueSL=<? echo $reut[issueSL];?>&reference=<? echo $reut[reference];?>
 &issuedQty=<? echo $reut[issuedQtyTemp];?>&siow=<? echo $siow;?>&itemCode=<? echo $itemCode;?>&edate=<? echo $edate;?>"' 
 title="Click to Delete Issue">
 <img src="../images/b_drop.png">
 </a>
<?php } ?>
  <? echo generate_ISsl($reut[issueSL],$loginProject);?></td> 
  <td align="center"> <? echo number_format(($reut[issuedQtyTemp]+$reut[issuedQty]),3).'  '.$temp[unit]; echo $reut[issuedQtyTemp]>0 ? verifiedSwitch(0) : "";  ?> </td>

  <td align="left">
	<? /*
  if($reut[iowId]){
  echo '<font color=006600>'.iowCode($reut[iowId]).'</font> ';
  echo iowName($reut[iowId]);
  } else echo 'Work Break';?> </td>
  <td align="left"> <? 
  if($reut[siowId]){
  echo '<font color=006600>'.viewsiowCode($reut[siowId]).'</font> ';
  echo siowName($reut[siowId]);
  }else echo $reut[details];*/
 
 $eqAr=explode("_",$reut[eqID]);
 $eqID_A=$eqAr[0];
 if($eqID_A){
	 $last_usage_report=$reut[unit]=="ue" ? getUsageofEQ($eqAr[1],$eqAr[0],$reut[issueDate]) : getLastUsageofEQbyDate($eqAr[0],$loginProject,$eqAr[1],$reut[issueDate]) ;
	 $last_usage_report=$reut[unit]!="km" ? sec2hms($last_usage_report) : $last_usage_report;
	 echo "<b>".$eqAr[1].$eqAr[0]."</b>: ".itemCode2Des($eqAr[1]).", <font color='#00f'>".$last_usage_report."</font> ".(measuerUnti()[$reut[unit]]);
 }
 ?>
		
	
	</td>

<!--  <td align="center"><a href="<? echo $PHP_SELF."?itemCode=$itemCode&edate=$edate&delete=1&id=$reut[id]&dqty=$reut[qty]&rate=$rate&posl=$posl&poremain=$poremain";?>">[ Delete ]</a></td>  
-->
	<td><? echo myDate($reut[issueDate]);?></td>
 </tr>
 <? $i++;}?>
</table>
</body>
	
	<script>
	$(document).ready(function(){
		var selected_eq=$("#selected_eq");
		var last_usage=$("#last_usage");
		var unitHolder=$("#unitHolder");
		var unitHolderRow=$("#unitHolderRow");
		var equt=$("#equt");
		var submitBtn=$("#submitBtn");
		var km_h_qty=$("#km_h_qty");
		var km_h_qty_row=$("#km_h_qty_row");
		var issuedQty=$("#issuedQty");
		selected_eq.change(function(){
			var selEQ=$(this).find(":selected");
				unitHolderRow.show();
				km_h_qty_row.show();
				
				if(selEQ.attr("attr")!="null"){
					last_usage.val(selEQ.attr("rel")+" "+selEQ.attr("attr"));
					unitHolder.html(selEQ.attr("attr"));
					km_h_qty.prop("readonly",false).prop("disabled",false).val("");
				}
				else{
					unitHolder.html("Hr");
					last_usage.val(selEQ.attr("data-last-usage"));
					km_h_qty.prop("readonly",true).prop("disabled",true).val("");
				}
					
			
		});
		submitBtn.click(function(){
			var selected_eq_opt=selected_eq.find(":selected");
			
			<?php
			
			$itemCodeAr=explode("-",$itemCode);
			if($itemCodeAr[0]=="11"){
			?>
			if(selected_eq_opt.attr("attr")!="null" && parseFloat(km_h_qty.val())<=parseFloat(selected_eq_opt.attr("rel"))){
				alert("Current usage quantity should not be less then last quantity.");
				return false;
			}
			
			if((!selected_eq.val() || km_h_qty.val()<1) && selected_eq_opt.attr("attr")!="null"){
				alert("Please select your equipment & input your matchine km/hour.");
				return false;
			}
			else <?php } ?>
				if(issuedQty.val()>0)
					equt.submit();
				else
					alert("Please input quantity.");
		});
	});
	</script>
</html>
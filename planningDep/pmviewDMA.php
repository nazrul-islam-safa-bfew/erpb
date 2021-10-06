<? 
include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
if($com=='1' && $selectedPcode ){
	include("./includes/taskS.inc.php");
// 	check is it exits in under preparation
  $checkSql="select count(*) as found from iowtemp where iowId='$iow'";
	$chkQuery=mysqli_query($db,$checkSql);
	$chkRow=mysqli_fetch_array($chkQuery);
	
	//check it stay in under preparation also
	if($chkRow[found]>0){
		echo "<h1>Task stay in under preparation!</h1>";
		echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=index.php?keyword=pmview+IOW&status=Not+Ready\">";
		exit;
	} 
$todat=todat();	
$c=1;

	$iowSql="select * from iow where iowId='$iow'";
	$iowQ=mysqli_query($db,$iowSql);
	$iowRow=mysqli_fetch_array($iowQ);
	
	if($iowRow[iowStatus]=="Completed"){
		echo "<h1>Task Description: $iowRow[iowCode]: $iowRow[iowDes]</h1>
					<h1>Error, Your selected task already completed!</h1>";
		exit;
	}
	
// 	siow
	?>
<style>
								.hourGlass{
									width: 100%;
									border-collapse:collapse;
								}
								table.hourGlass ,.hourGlass td,.hourGlass tr,.hourGlass th{
									border: 1px solid #ccc;
								}
								.hourGlass td:last-child{
									text-align:right;
								}
								.hourGlass tr:nth-child(even){
									background:#eee;
								}
		</style>
		<table class='hourGlass'>
			<caption><h1>
				Task Description: <?php echo $iowRow[iowCode].": ".$iowRow[iowDes]; ?>
				</h1></caption>
		<tr>
			<th>Itemcode</th>
			<th>Approved</th>
			<th>Placed</th>
			<th>Differ</th>
			<th>Status</th>
		</tr>
	<?
	$matSiowSql="select siowId from siow where iowId='$iow' having max(revisionNo)";
	$matSiowQ=mysqli_query($db,$matSiowSql);
	while($matSiowRow=mysqli_fetch_array($matSiowQ)){
		$siow=$matSiowRow[siowId];
// 		resource
		$matDmaSql="select dmaItemCode,dmaQty,dmaId from dma where dmasiow='$siow' group by dmaItemCode having max(revisionNo)";
		$dmaMatQ=mysqli_query($db,$matDmaSql);
		while($dmaMatRow=mysqli_fetch_array($dmaMatQ)){
			$itemCode=$dmaMatRow[dmaItemCode];
			$dmaID=$dmaMatRow[dmaId];
// 		issue
			if($itemCode>='01-00-000' && $itemCode<='49-99-999'){ //material
				$issueMatSql="select sum(issuedQty) as issuedQty from issue$selectedPcode where siowId='$siow' and itemCode='$itemCode'";
				$issueMatQ=mysqli_query($db,$issueMatSql);
				while($issueMatRow=mysqli_fetch_array($issueMatQ)){
					$matQty=$issueMatRow[issuedQty];
					echo "<tr><td>$itemCode</td><td>$dmaMatRow[dmaQty]</td><td>$matQty</td><td>".($dmaMatRow[dmaQty]-$matQty)."</td><td>".dmaUpdate($matQty,$dmaID)."</td></tr>";
				}
			}
			elseif($itemCode>='50-01-001' && $itemCode<='69-99-999'){ //equipment
				$issueEQSql="select sum((abs(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60))/3600) as totalHour from eqattendance where siowId='$siow' and itemCode='$itemCode'";
				$issueEqQ=mysqli_query($db,$issueEQSql);
				while($issueEQRow=mysqli_fetch_array($issueEqQ)){
					$eqQty=$issueEQRow[totalHour];
					echo "<tr><td>$itemCode</td><td>$dmaMatRow[dmaQty]</td><td>$eqQty</td><td>".($dmaMatRow[dmaQty]-$eqQty)."</td><td>".dmaUpdate($eqQty,$dmaID)."</td></tr>";
				}
			}
			elseif($itemCode>='70-00-000' && $itemCode<'99-00-000'){ //labour
				$issueEmpSql="select sum((abs(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60))/3600) as totalHour from emput where siow='$siow' and designation='$itemCode'";
				$issueEmpQ=mysqli_query($db,$issueEmpSql);
				while($issueEmpRow=mysqli_fetch_array($issueEmpQ)){
					$empQty=$issueEmpRow[totalHour];
					echo "<tr><td>$itemCode</td><td>$dmaMatRow[dmaQty]</td><td>$empQty</td><td>".($dmaMatRow[dmaQty]-$empQty)."</td><td>".dmaUpdate($empQty,$dmaID)."</td></tr>";
				}
			}
			elseif($itemCode>='99-01-001' && $itemCode<='99-99-999'){ //subcontractor
				$issueSubconSql="select sum(qty) as qty from subut where siow='$siow' and itemCode='$itemCode'";
				$issueConQ=mysqli_query($db,$issueSubconSql);
				while($issueSubconRow=mysqli_fetch_array($issueConQ)){
					$subconQty=$issueSubconRow[qty];
					echo "<tr><td>$itemCode</td><td>$dmaMatRow[dmaQty]</td><td>$subconQty</td><td>".($dmaMatRow[dmaQty]-$subconQty)."</td><td>".dmaUpdate($subconQty,$dmaID)."</td></tr>";
				}
			}
			else{
				echo "<tr><td>Unrecognized item".$itemCode." Task not completed! <br>";
				exit;
			}
		}
	}
	echo "</table>";
echo "<p><a href='./index.php?keyword=pmview+dma'>Back</a></p>";
	

$sql="UPDATE iow set iowStatus='Completed',supervisor='',iowCdate='$todat' WHERE iowId=$iow";
// echo "$sql<br>";
mysqli_query($db, $sql);
$sql="UPDATE iowtemp set iowStatus='Completed',supervisor='',iowCdate='$todat' WHERE iowId=$iow";
// echo "$sql<br>";
mysqli_query($db, $sql);
exit;
}


?>
<?

 if($Revision2){
	 if(!$revisionTxt){die("<h1>Revision reason not found!</h1>");}
	 $revisionTxt=date("d/m/Y")." ".$revisionTxt;
include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

$sql="UPDATE iow set revision='1',iowStatus='Approved by MD' WHERE iowId=$iow";
//echo $sql.'<br>';
$sqlq=mysqli_query($db, $sql);

$sql11="INSERT INTO iowtemp (select * from iow where iowId='$iow')";
//echo $sql11.'<br>';
$sqlq=mysqli_query($db, $sql11);
$iow_check[]=mysqli_affected_rows($db);
$iow_check[]=mysqli_error($db);
	 
$sql2="INSERT INTO siowtemp (select * from siow where iowId='$iow')";
//echo "$sql<br>";
$sqlq=mysqli_query($db, $sql2);
$siow_check[]=mysqli_affected_rows($db);
$siow_check[]=mysqli_error($db);

$sql4="INSERT INTO dmatemp (select * from dma where dmaiow='$iow')";
//echo "$sql<br>";
$sqlq=mysqli_query($db, $sql4);
$res_check[]=mysqli_affected_rows($db);
$res_check[]=mysqli_error($db);

$sql5="UPDATE iowtemp set iowStatus='Not Ready',Prepared='',Checked='',Approved='',revisionNo=revisionNo+1, revisionTxt='$revisionTxt' WHERE iowId=$iow";
//echo $sql5.'<br>';
$sqlq=mysqli_query($db, $sql5);
$iow_status[]=mysqli_affected_rows($db);
$iow_status[]=mysqli_error($db);

$sq=mysqli_query($db, "select revisionNo from iowtemp where iowId='$iow'");
$r=mysqli_fetch_array($sq);
$get_revision[]=mysqli_affected_rows($db);
$get_revision[]=mysqli_error($db);

$revision=$r[revisionNo];

$sql="UPDATE siowtemp set revisionNo=$revision WHERE iowId='$iow'";
//echo $sql.'<br>';
$sqlq=mysqli_query($db, $sql);
$siow_revision_push[]=mysqli_affected_rows($db);
$siow_revision_push[]=mysqli_error($db);

//status of action
echo "<p style='color:red'>";
echo $iow_check[0]>0 ? "iow copy successfully." : "Error while iow copy: ".$iow_check[1] ;
echo "<br>";	 
echo $siow_check[0]>0 ? "Siow copy successfully." : "Error while Siow copy: ".$siow_check[1] ;
echo "<br>";	 
echo $res_check[0]>0 ? "Resource copy successfully." : "Error while resource copy: ".$res_check[1] ;
echo "<br>";	 
echo $iow_status[0]>0 ? "Update iow status." : "Error while update iow status: ".$iow_status[1] ;
echo "<br>";	 
echo $get_revision[0]>0 ? "Get existing revision." : "Error while get existing revision: ".$get_revision[1] ;
echo "<br>";	 
echo $siow_revision_push[0]>0 ? "New revision has been pushed." : "Error while revision push: ".$siow_revision_push[1] ;
echo "<br>";
echo "</p>";
//end status of action
	 
echo '<a href="http://'.$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI].'&trouble=1">Try Troubleshooting</a>';

//echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=index.php?keyword=site+iow+detail&status=Not+Ready\">";
}
if($_GET["trouble"]==1){
	$sql11="select * from iow where iowId='$iow'";
//echo $sql11.'<br>';
$sqlq=mysqli_query($db, $sql11);
$iow=mysqli_fetch_array($sqlq);
$del=mysqli_query($db, "delete from iowtemp where iowProjectCode='$_SESSION[loginProject]' and iowCode='".$iow["iowCode"]."'");

	/*
$sql2="select * from siow where iowId='$iow'";
$sqlq=mysqli_query($db, $sql2);
$siow=mysqli_fetch_array($sqlq);
$del=mysqli_query($db, "delete from siowtemp where siowPcode='$_SESSION[loginProject]' and siowCode='".$siow["siowCode"]."'");
echo mysqli_error($db);*/
	/*
$sql4="select * from dma where dmaiow='$iow'";
$sqlq=mysqli_query($db, $sql4);
$iow=mysqli_fetch_array($sqlq);
$del=mysqli_query($db, "delete from dmatemp where dmaProjectCode='$_SESSION[loginProject]' and dmaItemCode='".$iow["dmaItemCode"]."'");
echo mysqli_error($db);*/
}

?>

<?
if($Save){
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

$time=mktime(0,0,0, date("m"),date("d"),date("y"));

$updatetime = date('d-m-Y',strtotime(todat()));	


if($check=='Forward to MD'){
	$Checked="<b>Forword to MD</b> at $updatetime by $loginFullName [$loginDesignation]<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i>because $checkMesg</i>";
	$sqlup=" UPDATE iowtemp SET Checked='$Checked',Approved='$approve', iowStatus='$check'";
	$sqlup.=" WHERE iowId='$iow' AND iowProjectCode='$selectedPcode' ";
	$sqlupdate=mysqli_query($db, $sqlup);
}
elseif($check=='Approved by Mngr P&C') {
	 $approve="<b>Approved at</b> $updatetime by $loginFullName [$loginDesignation]" ;
	$sqlup=" UPDATE iowtemp SET Checked='$Checked',Approved='$approve', iowStatus='$check'";
	$sqlup.=" WHERE iowId='$iow' AND iowProjectCode='$selectedPcode' ";
	$sqlupdate=mysqli_query($db, $sqlup);
}
elseif($check=='Not Ready') { 
	$sqldma=" UPDATE dmatemp SET dmaRate='' WHERE dmaiow=$iow ";
	mysqli_query($db, $sqldma);
	
$sqlup=" UPDATE iowtemp SET Checked='',Approved='', iowStatus='Not Ready',Prepared=''";
$sqlup.=" WHERE iowId='$iow' AND iowProjectCode='$selectedPcode' ";
$sqlupdate=mysqli_query($db, $sqlup);
}

//echo $sqlup;

//echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=index.php?keyword=pmview+IOW&status=Raised+by+PM\">";
}//save


include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

$sqliow = "SELECT * from `iow` where `iowProjectCode` = '$selectedPcode'  AND `iowId` = '$iow'";
//echo $sqliow;
$sqlruniow= mysqli_query($db, $sqliow);
$resultiow=mysqli_fetch_array($sqlruniow);
?>
<table width="600"  align="center" border="1" bordercolor="#9999CC" bgcolor="#9999CC" cellpadding="0" cellspacing="0" style="border-collapse:collapse" >
 <tr > <td >
<table width="100%"  align="center"  bgcolor="#FFFFFF" border="0" cellpadding="5" cellspacing="0">
<tr>
  <td colspan="4" bgcolor="#9999CC" align="center" class="englishhead">Details of Item Of Work (IOW)</td>
</tr>

<tr>
  <td colspan="4">Project: <font class="out"> <? echo $selectedPcode;?></font></td>
</tr>
<tr>
  <td colspan="4">Item of Work:<font class="out"> <? echo "$resultiow[iowCode]</b> [ <i>$resultiow[iowDes]</i>]";?></font></td>
</tr>
<? 
$materialCost=materialCost($resultiow[iowId]);
$equipmentCost=equipmentCost($resultiow[iowId]);
$humanCost=humanCost($resultiow[iowId]);

$directCost=$materialCost+$equipmentCost+$humanCost;
if($resultiow[iowType]==1)
	$totalCost=$resultiow[iowQty]*$resultiow[iowPrice];
else{
	$totalCost=$directCost;
	$resultiow[iowPrice]=$totalCost/$resultiow[iowQty];
}

$pmaterialCost=($materialCost/$totalCost)*100;
$pequipmentCost=($equipmentCost/$totalCost)*100;
$phumanCost=($humanCost/$totalCost)*100;

?>
	
<tr>
  <td width="21%">Quantity:<font class="out"><? echo $resultiow[iowQty];?></font> <? echo $resultiow[iowUnit];?></td>
  <td width="21%">Rate:<font class="out"><? echo number_format($resultiow[iowPrice],2);?></font></td>
  <td width="42%">IOW Total:<font class="out"><? echo  number_format($resultiow[iowQty]*$resultiow[iowPrice],2);?></font> Taka</td>
</tr>
	
<tr><td colspan="4" bgcolor="#DDDDFF">Estimated Direct Expenses: Total Tk. <? echo number_format($directCost);?>(<font class="out"><? echo number_format(($directCost/$totalCost)*100);?>%</font>)
</td></tr>
<tr><td colspan="4" bgcolor="#DDDDFF" ><p style="margin-left:10px">- Material Tk. <? echo number_format($materialCost);?>(<font class="out"><? echo number_format($pmaterialCost);?>%</font>); Equipment Tk. <? echo number_format($equipmentCost);?> (<font class="out"><? echo number_format($pequipmentCost);?>%</font>); Labour Tk.<? echo number_format($humanCost);?> (<font class="out"><? echo number_format($phumanCost);?>%</font>)</td></tr>
<tr><td colspan="4" bgcolor="#FFFFCC">Unit Direct Expense <font class="out">Tk. <? echo number_format($directCost/$resultiow[iowQty],2).'/'.$resultiow[iowUnit];?></font>
</td></tr>

<tr>
  <td colspan="2">Date of Starting: <font class="out"><? echo date('j-m-Y',strtotime($resultiow[iowSdate]));?></font></td>
  <td colspan="2">Date of Completion: <font class="out"><? echo date('j-m-Y',strtotime($resultiow[iowCdate]));?></font></td>
</tr>
<tr>
<td colspan="4"><? echo 'Rev. '.$resultiow[revisionNo];?> <b>Raised at</b> <? echo $resultiow[Prepared];?><br>
<? echo 'Rev. '.$resultiow[revisionNo];?> <? echo $resultiow[Checked];?><br>
<? echo 'Rev. '.$resultiow[revisionNo];?> <? echo $resultiow[Approved];?>
<? if($iowStatus=='Completed') echo "<br>[ <b><font class=out> Completed </font></b> ]";?>
</td>
</tr>

</table>
</td></tr>
</table>
			
			
<br>
<?php include("revisionHistory.php"); ?>
<br>
			
<br>
<a href="./graph/viewGraph.php?iowId=<? echo $resultiow[iowId];?>&iowStatus=<? echo $iowStatus;?>&gproject=<? echo $selectedPcode;?>" target="_blank" title="Click For View Graphical Presentation">[ GRAPH ]</a>
<? if($iowStatus=='Approved by MD'){?>
<a href="./index.php?keyword=pmview+dma&iow=<? echo $resultiow[iowId];?>&selectedPcode=<? echo $selectedPcode;?>&iowStatus=Completed&com=1">[ Completed ]</a>
<? }?>

<?
			
include("./project/auxiliary_iow_report.php");
			$diagonosis_info=getIowItemCode2EqMaintenanceInfo($resultiow[iowCode],$selected="dt");
include("./maintenance/eqMaintenanceReport.php");
			
$sqlsiow = "SELECT * from `siow` where `iowId` = '$iow' ";
//echo $sqlsiow;
$sqlrunsiow= mysqli_query($db, $sqlsiow);
?>

<form name="check" action="./index.php?keyword=pmview+dma&selectedPcode=<? echo $selectedPcode;?>&iow=<? echo $iow;?>&revisionTxt=" method="post">
<table  align="center" width="98%" border="1" bordercolor="#E4E4E4" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <? while($siow=mysqli_fetch_array($sqlrunsiow)){?>
  <tr bgcolor="#EEEEEE">
    <td height="30"  width="300" align="left"><b>SIOW: </b><a href="./graphReport.php?siow=<? echo $siow[siowId];?>"><? echo $siow[siowName];?></a><br>
		Start: <? echo myDate($siow[siowSdate]);?>; Finish: <? echo myDate($siow[siowCdate]);?>; Duration: <? echo siowDuration($siow[siowId]);?> days
	</td>
    <td width="200" align="left">Total Qty: <? echo number_format($siow[siowQty],3);?> <? echo $siow[siowUnit];?></td>
  </tr>
  <tr>
  <td colspan="6">
<?
$sqlp ="SELECT * FROM `dma` WHERE `dmasiow` = '$siow[siowId]' order by dmaItemCode ASC";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
?>

<table  align="center" width="98%" border="1" bordercolor="#CCCCCC" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr bgcolor="#DDDDDD">
    <td height="10" width="100" align="center"><b>Item Code</b></td>
    <td width="300" align="center"><b>Item Description</b></td>
    <td align="center"><b>Unit</b></td>
    <td align="center"><b>Qty</b></td>
    <td align="center"><b>Rate</b></td>
    <td align="center"><b>Amount</b></td>
  </tr>

  <? $i=1;$totalAmount=0;
   while($iowResult=mysqli_fetch_array($sqlrunp))
  { 
  $temp=itemDes($iowResult[dmaItemCode]);
  
  $ii=explode("-",$iowResult[dmaItemCode]);
    //if($ii[0]>=35 AND $ii[0]<70) {$bg=" bgcolor=#FFFFCC"; $unit='Hr.';}
	if($ii[0]>=35 AND $ii[0]<98) {$bg=" bgcolor=#F0FEE";$unit='Hr.';}
	 else {$bg=" bgcolor=#FFFFFF";$unit=$temp[unit];}
  ?>
  <tr <? echo $bg;?>>
    <td align="center" ><? echo $iowResult[dmaItemCode];?></td>
    <td align="left" width="300"><? 
	
	echo "$temp[des], $temp[spc]";?></td>
    <td align="center"><? echo $unit;?></td>
    <td align="right"><?
	if($ii[0]>=35 AND $ii[0]<98)
	 echo sec2hms($iowResult[dmaQty],$padHours=false);
	else 
	 echo number_format($iowResult[dmaQty],3);?></td>
    <td align="right"><? echo number_format($iowResult[dmaRate],2);?></td>
    <td align="right"><? $amount=$iowResult[dmaRate]*$iowResult[dmaQty]; echo number_format($amount,2);?></td>
  </tr>
  <? $totalAmount+= $amount; $i++; } ?>
  <tr  bgcolor="#AAAADD"><td colspan="3" align="center" ><? echo "SIOW Unit Direct Expense: Tk.".number_format( $totalAmount/$siow[siowQty],2).'/'.$siow[siowUnit];?></td>
     <td colspan="3" align="right"><? echo "Sub Total Amount: Tk.".number_format($totalAmount,2);?></td>

 </tr>
<!--   <tr><td  colspan="6">
   <img src="./graphReport.php?siow=<? echo $siow[siowId];?>">
  </td></tr>
-->
</table><br>

  <? } ?>
  					   <input type="hidden" name="tid" value="<? echo $i;?>">
  </td></tr>
    <? 
	
	if($loginDesignation=="Equipment Co-ordinator" &&  checkIsIOWavailable2start($iow,$selectedPcode)){
		
		if($start || $iowResult[iowSdate]==todat()){
			$extraBTNtxt=" disabled ";		
			$sql="update iow set iowSdate='".todat()."' where iowId='$iow' and (".maintenanceHeadSql(true,true," position like "," or ").")";
			mysqli_query($db,$sql);
	}
		
		echo "<div style='    position: absolute;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,.5);
    left: 0;
    top: 0;
    text-align: center;
    margin: auto;'><div style='
    width: 200px;
    padding: 20px;
    border: 1px solid #ddd;
    background: #fff;
    margin: 200px auto auto auto;
    box-shadow: 0px 0px 20px 5px #000'><center>Start Maintenance to press start button below.<br><input type='button' value='Start' onClick='window.location=window.location.href+\"&start=1\";' $extraBTNtxt></center></div></div>";
	}
	
	
	if( ($resultiow[iowStatus]=='Approved by PM' OR $resultiow[iowStatus]=='Approved by MD') AND ($loginDesignation=='Project Manager' OR $loginDesignation=='Project Engineer')){?>
  <tr>
	  <td align="center" colspan="4"><input type="button"  id="revisionBTN" value="Back for revision" >
		<input type="hidden" name="Revision2" id="Revision2" value="">
		</td>
  </tr>
  <? }?>
    <? if( $resultiow[iowStatus]=='Completed' AND $loginDesignation=='Manager Planning & Control' ){?>
  <tr>
	  <td align="center" colspan="4">
			<input type="hidden" name="Revision2" id="Revision2" value="">
			<input type="button" name="Revision2"  id="revisionBTN" value="Make Incomplete">
		</td>
  </tr>
  <? }?>
  </table>
</form>
			<script>
				$(document).ready(function(){
					var revisionBTN=$("input#revisionBTN");
					var fullScreenBlack=$("div.fullScreenBlack");
					var dialog=$("div#dialog");
					var closeBTN=$("button#closeBTN");
					var revSubmitBTN=$("input#revSubmitBTN");
					var revisionTxt=$("textarea#revisionTxt");
					var errorMsg=$("div.errorMsg");
					var form=$("form[name='check']");
					var Revision2=$("#Revision2");
					revisionBTN.click(function(){
						fullScreenBlack.fadeIn();
						return false;
					});
					closeBTN.click(function(){
						fullScreenBlack.hide();
					});

					revSubmitBTN.click(function(){
						var revisionData=revisionTxt.val();
						if(revisionData.length>15){
							errorMsg.html("");
							Revision2.val("1");
							form.attr("action",form.attr("action")+revisionData);
							form.submit();
						}else{
							var msg="Revision reason should be minimum 15 character."
							errorMsg.html(msg);
						}
					});
				});
			</script>
			<div class="fullScreenBlack" style="background:rgba(0,0,0,.8); width:100%; height:100%; left:0;top:0;position:fixed; overflow:hidden; display:none">
				<div style="display: block;    width: 320px;    height: 240px;    background: white;
    margin: auto;    margin-top: 20vh;    padding: 3px;    border-radius: 4px;">
					<div id="dialog" title="Reason of revision">
						<div class="ui-dialog-titlebar ui-corner-all ui-widget-header ui-helper-clearfix ui-draggable-handle"><span id="ui-id-1" class="ui-dialog-title">Reason of revision</span><button type="button" class="ui-button ui-corner-all ui-widget ui-button-icon-only ui-dialog-titlebar-close" title="Close" style="    float: right;" id="closeBTN"><span class="ui-button-icon ui-icon ui-icon-closethick"></span><span class="ui-button-icon-space"> </span>Close</button></div>
						<div class="">
						<div class="errorMsg" style=" color: #f00;    font-size: 12px;    font-weight: 800;">
							
						</div>
							<textarea name="revisionTxt" id="revisionTxt" style="margin: 0px; width: 98%; height: 117px; 1px solid rgb(176, 174, 174)"></textarea>
							<input type="button" value="submit" id="revSubmitBTN">
						</div>
						
					</div>
				</div>
			</div>
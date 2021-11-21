<?
include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
$itemCode2=$_POST[itemCode2];
$itemCode=$_POST[itemCode];
if($search){
	$_SESSION[itemCode]="";
	$_SESSION[itemCode2]="";
}

if($itemCode && $itemCode2){
	$_SESSION[itemCode]=$itemCode;
	$_SESSION[itemCode2]=$itemCode2;
}else if($_SESSION[itemCode] && $_SESSION[itemCode2]){
	$itemCode=$_SESSION[itemCode];
	$itemCode2=$_SESSION[itemCode2];
}

$sql="SELECT posl from porder where posl LIKE 'EP_".$loginProject."_%' order by poid desc limit 1";
//echo $sql;
$sqlq = mysqli_query($db, $sql);
$data_ep = mysqli_fetch_row($sqlq);


$exp_data = explode("_",$data_ep[0]);


$row = $exp_data[2]+1;

$posl='EP_'.$loginProject.'_0000'.$row.'_5';
$posl0='EP_'.$loginProject.'_0000'.$row;

// echo "POSL: <b>$posl0</b>";
// exit;

if($_POST['approved']){
 include('./consumableProduct/siteItemRequired.sql.php');} 
 ?>
<p>

</p>
<form name="search" action="./index.php?keyword=site+item+required&page=1" method="post">
<table width="300" align="center" border="1" bordercolor="#00aaFF" cellpadding="3" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#0099FF">
	<td colspan=2 height=2></td>
	</tr>
 <tr bgcolor="">
   <th class="">Itemcode</th>
   <th class="th1">
		<input type='text' value='<?php echo $itemCode_0; ?>' name='itemCode_0' style="float:left; text-align:center; width: 70px;" placeholder='01-01-001'> &nbsp;
		<input type='text' value='<?php echo $itemCode_1; ?>' name='itemCode_1' style="float:left; text-align:center;width: 70px;" placeholder='01-01-999'>
		 <br>
		 <br>
		<input type="submit" value="Search" name='search' style="float:left">
	 </th>
 </tr>
		
</table>
</form>
<form name="openPO" action="./index.php?keyword=site+item+required<?php if($page) print "?page=$page"; ?>" method="post">
	<br>
	<br>
<table width="98%" align="center" border="1" bordercolor="#00aaFF" cellpadding="3" cellspacing="0" style="border-collapse:collapse">
 <tr bgcolor="#0099FF">
   <th class="th1">Itemcode</th>
   <th class="th1">Description</th>
   <th class="th1">Max. Pur. Qty</th>
   <th class="th1">Unit</th>
   <th class="th1">Current Req.</th>   
   <th class="th1">Rate</th>      
   <th class="th1">Amount Tk.</th>      
 </tr>
 <?
 include("config.inc.php");
$db11 = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
/*	
$sql="SELECT dmaItemCode,dmaProjectCode,dmaRate,SUM(dmaQty) as dmaTotal from dma,iow 
	WHERE dmaItemCode <'50-00-000' 
	AND  iowStatus IN ('Approved by Mngr P&C','Approved by MD') AND iow.iowId=dma.dmaiow
	AND dmaProjectCode='$loginProject' 
	AND dmaRate>0 
	Group by dmaItemCode ";
*/
	$sql="SELECT dmaItemCode,dmaProjectCode,dmaRate,SUM(dmaQty) as dmaTotal from dma  
	WHERE dmaItemCode <'50-00-000' 
	AND dmaProjectCode='$loginProject' 
	AND dmaRate>0  AND dmaItemCode between '$itemCode_0' AND '$itemCode_1'
	Group by dmaItemCode";
	$r=mysqli_query($db, $sql);
	$totalrow=mysqli_num_rows($r);
	$rowperpage=10000;
	if($page<2){
		$startrow=0;
	}else{
		$startrow=round($page*$rowperpage);
	}

	$fetureDate=date("Y-m-d",strtotime(todat())+(86400*10));

	$sql="SELECT dmaItemCode,dmaProjectCode,dmaRate,SUM(dmaQty) as dmaTotal from dma  
	WHERE dmaItemCode <'50-00-000' 
	AND dmaProjectCode='$loginProject' 
	AND dmaRate>0 and dmaDate<'$fetureDate' and dmaItemCode between '$itemCode_0' AND '$itemCode_1'
	Group by dmaItemCode limit $startrow, $rowperpage";

// echo $sql;
// exit;
	$sqlquery=mysqli_query($db, $sql);
	$i=1; $totalAmount=0;
while($sqlresult=mysqli_fetch_array($sqlquery)){
	$temp=itemDes($sqlresult[dmaItemCode]);

 $order=orderQty($sqlresult[dmaProjectCode],$sqlresult[dmaItemCode]);
  $current=$sqlresult[dmaTotal]-$order;
//10 day ep code
// 	$estimatdTotalIssue=nextXdaysReq(todat(),$fetureDate,$sqlresult[dmaItemCode],$sqlresult[dmaProjectCode],10,true);

// 	$current=$estimatdTotalIssue-$order; 
// 	$current=$order; 
//echo "<br>$sqlresult[dmaItemCode]==	$current=$sqlresult[dmaTotal]-$order; ";

// if($current>0) //10 day ep code end
{
	?>
 <tr>
   <td align="center"><? echo $sqlresult[dmaItemCode];?>
     <input type="hidden" name="itemCode<? echo $i;?>" value="<? echo $sqlresult[dmaItemCode];?>">
   </td>
   <td><? echo $temp[des].', '.$temp[spc];?></td>
      <td align="right"> 
        <? echo number_format($current,3);?>      </td>
   <td align="center"><? echo $temp[unit];?></td>
   <td align="center"><input type="text" name="currentQty<? echo $i;?>" value="<? if($approved==0) echo ${currentQty.$i};?>" onBlur="if(this.value > <? echo $current;?>) {alert('Check value'); this.value=0}" size="10" width="10"></td>
   <td align="right"><? echo number_format($sqlresult[dmaRate],2);?>

   </td>
   <td align="right"><?  if($approved==0){ $amount=$sqlresult[dmaRate]*${currentQty.$i}; $totalAmount+=$amount; echo number_format($amount,2);}?></td>
 </tr>


<? 
$i++;  }//if damTotal>0

} ?>
<tr>
	<style>
		.current{
			font-size:13px;
			background:#00f;
			color:#fff !important;
		}
	</style>
<td colspan="3" align="left" bgcolor="#FFFFCC"><b>Page: 
	<?php
	for($j=1;$j<floor($totalrow/$rowperpage);$j++){
		if($j==$page)$extra="class='current'";else $extra="";
		echo " <a href=\"./index.php?keyword=site+item+required&page=$j\" $extra>$j</a> |";
	}
	?>
	
	</b>
</td>
<td colspan="4" align="right" bgcolor="#FFFFCC"><b><?  if($approved==0){ echo number_format($totalAmount,2);}?></b></td></tr>
 <tr>

    <td colspan="6" align="center"><input type="button" value="Approve Purchase" name="save" onClick="openPO.approved.value=1;openPO.submit();"></td>
    <td align="center">
		<!-- <input type="button" value="calculate" name="calculate" onClick="openPO.approved.value=0;openPO.submit();"> -->
	</td>
	<input type="hidden" name="approved" value="0">
	<input type="hidden" name="n" value="<? echo $i;?>">
 </tr>

</table>
</form>
<table width="90%" border="1" bordercolor="#000000" cellpadding="5" cellspacing="0" style="border-collapse:collapse" >
<tr bgcolor="#EEEEEE">
<td>ItemCode</td>
<td>Description</td>
<td>Qty</td>
</tr>
<? 
include("config.inc.php");
$db11 = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);


$sql="SELECT poid,itemCode,qty from porder where posl LIKE 'EP_".$loginProject."_%' AND status='1' and qty!='0' ORDER by itemCode ASC";
//echo $sql;
$sqlq=mysqli_query($db, $sql);
while($r=mysqli_fetch_array($sqlq)){
$temp=itemDes($r[itemCode]);
?>
<tr>
<td><? echo $r[itemCode];?></td>
<td><? echo $temp[des].', '.$temp[spc];?></td>
<td align="right"><? echo $r[qty];?><a href="#" onClick='if(confirm("Are you sure ?")) window.location="./consumableProduct/epDelete.php?poid=<? echo $r[poid];?>"'><img src="./images/b_drop.png" border="0" align="absbottom"></a>
</td>
</tr>
<? }//while?>
</table>
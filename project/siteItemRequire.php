<? 

 $pcode=$loginProject;
 $theDays=!empty($_POST["sVal"]) ? $_POST["sVal"] : 10;
$page=intval($_GET[page]);
$type=!$_GET[type] ? "mat" : $_GET[type];
 if($pcode){?>
<form method="post">
	<table width="350" align="center" border="1" bordercolor="#00aaFF" cellpadding="3" cellspacing="0" style="border-collapse:collapse">
		 <tr bgcolor="#0099FF">
		 <th class="th1" height=10 ></th>
	 </tr>
		<tr>
			<td><center>Requisition for: <input type="text" size="2" name="sVal" value="<?php echo $theDays; ?>"> Day's <input type="submit" name="search" value="Search"></center></td>
		</tr>
	</table>
</form><br><br>
<table width="98%" align="center" border="1" bordercolor="#00aaFF" cellpadding="3" cellspacing="0" style="border-collapse:collapse">
 <tr bgcolor="#0099FF">
   <th class="th1">Project</th>
   <th class="th1">Itemcode</th>
   <th class="th1">Description</th>
   <th class="th1">Approved</th>   
   <th class="th1">PO Given</th>
   <th class="th1">Unit</th>
   <th class="th1">10 days Req.</th>   
 </tr>
 <?
 include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

	
$sql="SELECT dmaItemCode,dmaProjectCode,SUM(dmaQty) as dmaTotal,iowStatus,iow.iowId from dma,iow WHERE".
"  iowStatus IN ('Approved by Mngr P&C','Approved by MD') AND iow.iowId=dma.dmaiow AND dmaProjectCode='$pcode'";

if($type=='mat')
$sql.=" AND dmaItemCode BETWEEN '01-00-000' AND '49-99-999' ";

if($type=='eqp')
$sql.=" AND dmaItemCode BETWEEN '50-00-000' AND '69-99-999' ";

if($type=='lab')
$sql.=" AND dmaItemCode BETWEEN '70-00-000' AND '99-99-999' ";

$sql.=" Group by dmaItemCode ";

//echo $sql;
	$sqlquery=mysqli_query($db, $sql);
		$totalrow=mysqli_num_rows($sqlquery);
$perpage=10;
$currentPos=($perpage*$page);
	
$sql="SELECT dmaItemCode,dmaProjectCode,SUM(dmaQty) as dmaTotal,iowStatus,iow.iowId from dma,iow WHERE".
"  iowStatus IN ('Approved by Mngr P&C','Approved by MD') AND iow.iowId=dma.dmaiow AND dmaProjectCode='$pcode'";

if($type=='mat')
$sql.=" AND dmaItemCode BETWEEN '01-00-000' AND '49-99-999' Group by dmaItemCode limit $currentPos, $perpage";
else
$sql.=" Group by dmaItemCode limit $currentPos, $perpage";
//   	 echo $sql;
$sqlquery=mysqli_query($db, $sql); 
	while($sqlresult=mysqli_fetch_array($sqlquery)){
	$temp=itemDes($sqlresult[dmaItemCode]);
    $tt = explode( '-',$sqlresult[dmaItemCode] );
		
		
		
		if($tt[0]<50){	
				$nextten = date('Y-m-d',strtotime($todat)+(86400*$theDays)); 
				$estimatdTotalIssue = nextXdaysReq($todat,$nextten,$sqlresult[dmaItemCode],$sqlresult[dmaProjectCode],$theDays);
		 }elseif($tt[0]>=50 AND $tt[0]<70){
	    $nextten = date('Y-m-d',strtotime($todat)+(86400*$theDays)); 
    	$estimatdTotalIssue = eqnextXdaysReq($sqlresult[dmaItemCode],$sqlresult[dmaProjectCode],$theDays);
		 }elseif($tt[0]>=70 AND $tt[0]<99){
	    $nextten = date('Y-m-d',strtotime($todat)+(86400*$theDays)); 
    	$estimatdTotalIssue = empnextXdaysReq($sqlresult[dmaItemCode],$sqlresult[dmaProjectCode],$theDays);}
	
if($estimatdTotalIssue<1)continue; //stop if quantity lessthen 1

	
    //echo $sqlresult[dmaItemCode].'--'.$sqlresult[dmaTotal].'-<font class=out>'.$order.'</font>='; 
	if($tt[0]<50 OR $tt[0]==99){
	    $order=orderQty($sqlresult[dmaProjectCode],$sqlresult[dmaItemCode]);
		$current=$sqlresult[dmaTotal]-$order; 
		}
	if($tt[0]>=50 AND $tt[0]<=70) {
		 $order=eqorderQty($sqlresult[dmaProjectCode],$sqlresult[dmaItemCode]);
		 $current=($sqlresult[dmaTotal]*3600)-($order*3600); 	
    	 }

	if($tt[0]>=70 AND $tt[0]<=97) {   
		 $order=emporderQty($sqlresult[dmaProjectCode],$sqlresult[dmaItemCode]);
		 $current=($sqlresult[dmaTotal]*3600)-($order*3600); 	
    	 }

	 //else $current=$sqlresult[dmaTotal]-$order; 

	
	
		

	if(($current>0 AND $tt[0]<50) OR $tt[0]>=50){
   if($tt[0]<50) $bg=' bgcolor=#FFFFFF';
     else if($tt[0]<70) $bg=' bgcolor= #FFDDDD';
	  else $bg=' bgcolor = #DDDDFF';
	?>				
 <tr <? echo $bg;?>>
   <td align="center"><? echo $sqlresult[dmaProjectCode];?></td>
   <td align="center" width="100"><? echo $sqlresult[dmaItemCode];?></td>
   <td><? echo $temp[des].', '.$temp[spc];?></td>
	<td align="right"><? if($tt[0]>=50 AND $tt[0]<99) {echo sec2hms( $sqlresult[dmaTotal],$padHours=false); }
	 else echo number_format($sqlresult[dmaTotal],3); ?> 
	</td>
    <td align="right"> <? /*
	if($tt[0]>=50 AND $tt[0]<99) {echo sec2hms($current/3600,$padHours=false); //echo "<br>**$sqlresult[dmaTotal]==$order**</br>";
	 else echo number_format($current); */?> 
<? 	 	if($tt[0]>=50 AND $tt[0]<98) {echo sec2hms( $order,$padHours=false); }
	 else echo number_format($order,3); ?>   
	 </td>


   <td align="center"><?    if($tt[0]>=50 AND $tt[0]<99) echo 'Hr.';
    else 
   echo $temp[unit];?>
   </td>
   <td align="right">
   <?
   if($tt[0]<50){?>
	<a href="./planningDep/dailyRequirment.php?project=<? echo $sqlresult[dmaProjectCode];?>&itemCode=<? echo $sqlresult[dmaItemCode];?>" target="_blank">
    <?  echo number_format($estimatdTotalIssue);?> </a>
	 <? }
	// elseif($tt[0]>=50 AND $tt[0]<70 AND $tt[0]==52 AND $tt[1]==11 ){
	 elseif($tt[0]>=50 AND $tt[0]<70){
	?>
    <a href="./planningDep/eqdailyRequirment.php?project=<? echo $sqlresult[dmaProjectCode];?>&itemCode=<? echo $sqlresult[dmaItemCode];?>" target="_blank">		
    <?  echo $estimatdTotalIssue;?></a>

	 <? }
	 elseif($tt[0]>=70 AND $tt[0]<99){
	?>
   <a href="./planningDep/empdailyRequirment.php?project=<? echo $sqlresult[dmaProjectCode];?>&itemCode=<? echo $sqlresult[dmaItemCode];?>" target="_blank">		
   <? echo $estimatdTotalIssue;?></a>
	 <? }  
   elseif($tt[0]==99){
   $nextten = date('Y-m-d',strtotime($todat)+(86400*$theDays));
     $estimatdTotalIssue = subnextXdaysReq($todat,$nextten,$sqlresult[dmaItemCode],$sqlresult[dmaProjectCode],$theDays);?>
	<a href="./planningDep/subdailyRequirment.php?project=<? echo $sqlresult[dmaProjectCode];?>&itemCode=<? echo $sqlresult[dmaItemCode];?>" target="_blank">
    <?  echo number_format($estimatdTotalIssue);?> </a>
	 <? }  ?>	 
	 
   </td>
	 
 </tr>

<? 
  }//if damTotal>0
$order=0;} 
//}//iow
?>
</table>
<? }//pcode?>
<b>
<?php 
if($page>1){
?>
<a href="./index.php?keyword=site+item+require&type=<?php echo $type."&page=".($page-1); ?>">Previous</a>
<?php } 
if($totalrow/$perpage>($page+1)){
?>
  <a href="./index.php?keyword=site+item+require&type=<?php echo $type."&page=".($page+1); ?>" >Next</a>
<? } ?>
</b>
<div style="float: right;
    padding: 5px 10px;
    margin-right: 5px;">
	<a href="#" onClick="window.print()">Print</a>
</div>
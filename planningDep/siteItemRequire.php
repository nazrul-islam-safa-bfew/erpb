<? 
 $pcode=$loginProject;
 if($pcode){?>
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
$db11 = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
	
$sql="SELECT dmaItemCode,dmaProjectCode,SUM(dmaQty) as dmaTotal,iowStatus,iow.iowId from dma,iow WHERE".
"  iowStatus IN ('Approved by Mngr P&C','Approved by MD') AND iow.iowId=dma.dmaiow AND dmaProjectCode='$pcode'";

if($type=='mat')
$sql.=" AND dmaItemCode BETWEEN '01-00-000' AND '49-99-999' ";

if($type=='eqp')
$sql.=" AND dmaItemCode BETWEEN '50-00-000' AND '69-99-999' ";

if($type=='lab')
$sql.=" AND dmaItemCode BETWEEN '70-00-000' AND '97-99-999' ";

$sql.=" Group by dmaItemCode ";

//echo $sql;
	$sqlquery=mysql_query($sql);
	while($sqlresult=mysql_fetch_array($sqlquery)){
	$temp=itemDes($sqlresult[dmaItemCode]);
    $tt = explode( '-',$sqlresult[dmaItemCode] );

	
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
<? 	 	if($tt[0]>=50 AND $tt[0]<99) {echo sec2hms( $order,$padHours=false); }
	 else echo number_format($order,3); ?>   
	 </td>


   <td align="center"><?    if($tt[0]>=50 AND $tt[0]<99) echo 'Hr.';
    else 
   echo $temp[unit];?>
   </td>
   <td align="right">
   <?
   if($tt[0]<50){
   $nextten = date('Y-m-d',strtotime($todat)+(86400*10));
 
    $estimatdTotalIssue = next10daysReq($todat,$nextten,$sqlresult[dmaItemCode],$sqlresult[dmaProjectCode]);?>
	<a href="./planningDep/dailyRequirment.php?project=<? echo $sqlresult[dmaProjectCode];?>&itemCode=<? echo $sqlresult[dmaItemCode];?>" target="_blank">
    <?  echo number_format($estimatdTotalIssue);?> </a>
	 <? }
	// elseif($tt[0]>=50 AND $tt[0]<70 AND $tt[0]==52 AND $tt[1]==11 ){
	 elseif($tt[0]>=50 AND $tt[0]<70){
	    $nextten = date('Y-m-d',strtotime($todat)+(86400*10));
 
    $estimatdTotalIssue = eqnext10daysReq($sqlresult[dmaItemCode],$sqlresult[dmaProjectCode]);
	?>
    <a href="./planningDep/eqdailyRequirment.php?project=<? echo $sqlresult[dmaProjectCode];?>&itemCode=<? echo $sqlresult[dmaItemCode];?>" target="_blank">		
    <?  echo $estimatdTotalIssue;?></a>

	 <? }
	 elseif($tt[0]>=70 AND $tt[0]<99){
	    $nextten = date('Y-m-d',strtotime($todat)+(86400*10));
 
    $estimatdTotalIssue = empnext10daysReq($sqlresult[dmaItemCode],$sqlresult[dmaProjectCode]);
	?>
   <a href="./planningDep/empdailyRequirment.php?project=<? echo $sqlresult[dmaProjectCode];?>&itemCode=<? echo $sqlresult[dmaItemCode];?>" target="_blank">		
   <? echo $estimatdTotalIssue;?></a>
	 <? }  
   elseif($tt[0]==99){
   $nextten = date('Y-m-d',strtotime($todat)+(86400*10));
     $estimatdTotalIssue = subnext10daysReq($todat,$nextten,$sqlresult[dmaItemCode],$sqlresult[dmaProjectCode]);?>
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
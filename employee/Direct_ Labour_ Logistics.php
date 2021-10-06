<table width="98%" align="center" border="1" bordercolor="#00aaFF" cellpadding="3" cellspacing="0" style="border-collapse:collapse">
 <tr bgcolor="#0099FF">
   <th class="th1">Project</th>
   <th class="th1">Itemcode</th>
   <th class="th1">Description</th>
   <th class="th1">PO Qty</th>
   <th class="th1">Unit</th>
   <th class="th1">10 days Req.</th>   
 </tr>
 <?
 include("config.inc.php");
$db11 = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sql="SELECT dmaItemCode,dmaProjectCode,SUM(dmaQty) as dmaTotal,iowStatus,iow.iowId from dma,iow".
" WHERE  dmaItemCode BETWEEN '87-00-000' AND '97-99-999' AND".
" iowStatus IN ('Approved by Mngr P&C','Approved by MD') AND iow.iowId=dma.dmaiow ".
//" AND dmaProjectCode='137'".
"  Group by dmaProjectCode,dmaItemCode ";
//echo $sql;
	$sqlquery=mysqli_query($db, $sql);
	while($sqlresult=mysqli_fetch_array($sqlquery)){
	$temp=itemDes($sqlresult[dmaItemCode]);
   $tt = explode( '-',$sqlresult[dmaItemCode] );
    //$order=orderQty($sqlresult[dmaProjectCode],$sqlresult[dmaItemCode]);
	
    //echo $sqlresult[dmaItemCode].'--'.$sqlresult[dmaTotal].'-<font class=out>'.$order.'</font>='; 
	$current=($sqlresult[dmaTotal]*3600)-($order*8*3600);	

	if($current>0){
	   $bg=' bgcolor = #FFFFFF';
	?>				
 <tr <? echo $bg;?>>
   <td align="center"><? echo $sqlresult[dmaProjectCode];?></td>
   <td align="center">
			<a href="./planningDep/empdailyRequirment.php?project=<? echo $sqlresult[dmaProjectCode];?>&itemCode=<? echo $sqlresult[dmaItemCode];?>" target="_blank">		
	<?  echo $sqlresult[dmaItemCode];?></a>
   </td>
   <td><? echo $temp[des].', '.$temp[spc];?></td>
    <td align="right"> <?  echo sec2hms($current/3600,$padHours=false);?>   </td>
   <td align="center"><?   echo 'Hr.';?>  </td>
   <td align="right"><?   
    $nextten = date('Y-m-d',strtotime($todat)+(86400*10)); 
    $estimatdTotalIssue = empnext10daysReq($sqlresult[dmaItemCode],$sqlresult[dmaProjectCode]);
    echo $estimatdTotalIssue;
   ?>
   </td>
  </tr>

<? 
  }//if damTotal>0

}//iow
?>
</table>
<br>
<br>

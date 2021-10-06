<form name="fpcode" action="./index.php?keyword=item+require" method="post">
<table width="500" align="center" class="ablue">
<tr><td class="ablueAlertHd_small" colspan="3">create purchase order</td></tr>
<tr><td>Project</td>
<td colspan="2">
 <select name="pcode"  onChange="location.href='./index.php?keyword=item+require&pcode='+fpcode.pcode.options[document.fpcode.pcode.selectedIndex].value";>
<?	include("./includes/config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 
$sqlp = "SELECT `pcode`,pname from `project` ORDER by pcode ASC";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
 while($typel= mysqli_fetch_array($sqlrunp))
{
 echo "<option value='".$typel[pcode]."'";
 if($pcode==$typel[pcode])  echo " SELECTED";
 echo ">$typel[pcode]--$typel[pname]</option>  ";
 }?>
 </select>
 </td>
 </tr>
<tr><td>Type</td>
<td colspan="2">
 <select  name="type">

<?
if($pcode=='004')
{
?>
  <option value="mat" <? if($type=='mat') echo ' selected ';?> >Material</option>
  <option value="matp" <? if($type=='matp') echo ' selected ';?> >Material Purchase for CenterStore</option>  
  <option value="eqp"  <? if($type=='eqp') echo ' selected ';?> >Equipment Rent</option>  
  <option value="eqpp"  <? if($type=='eqpp') echo ' selected ';?> >Equipment Purchase</option>    
  <option value="lab"  <? if($type=='lab') echo ' selected ';?> >Labour</option>  
 <?
 }
 else{
 ?>
  <option value="mat" <? if($type=='mat') echo ' selected ';?> >Material</option>
  <option value="eqp"  <? if($type=='eqp') echo ' selected ';?> >Equipment Rent</option>  
  <option value="lab"  <? if($type=='lab') echo ' selected ';?> >Labour</option>  
  <?
  }
  ?>
</select>

</td></tr>
<tr><td>Item Code</td>
    <td >
	<input name="itemCode11" onKeyUp="return autoTab(this, 2, event);" size="2" maxlength="2" value="<?php echo $_POST[itemCode11];?>" > - 
    <input name="itemCode12" onKeyUp="return autoTab(this, 2, event);" size="2" maxlength="2" value="<?php echo $_POST[itemCode12];?>"> - 
    <input name="itemCode13" onKeyUp="return autoTab(this, 3, event);" size="3" maxlength="3" value="<?php echo $_POST[itemCode13];?>" >
	</td>
    <td >
	<input name="itemCode21" onKeyUp="return autoTab(this, 2, event);" size="2" maxlength="2" value="<?php echo $_POST[itemCode21];?>" > - 
    <input name="itemCode22" onKeyUp="return autoTab(this, 2, event);" size="2" maxlength="2" value="<?php echo $_POST[itemCode22];?>"> - 
    <input name="itemCode23" onKeyUp="return autoTab(this, 3, event);" size="3" maxlength="3" value="<?php echo $_POST[itemCode23];?>" >
	</td>

</tr>
<tr class="ablueAlertHd_small"><td align="right" colspan="3" > 
<input type="submit" name="Search" value="Search" class='ablue_btn' onmouseover="this.className='ablue_btnhover'" onmouseout="this.className='ablue_btn'" >
</td></tr>
</table>
 
 </form>
 <? 
 
 $total_per_page=5;
  if($type=='eqpp'){?>
 <table width="98%" align="center" border="1" bordercolor="#00aaFF" 
 cellpadding="3" cellspacing="0" style="border-collapse:collapse">
 <tr bgcolor="#0099FF">
   <th class="th1">Itemcode</th>
   <th class="th1">Description</th>
   <th class="th1">Unit</th>
   <th class="th1">Quotation<br> at Hand</th>   
 </tr>
<?   include("config.inc.php");
$db11 = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 
	
$sql="SELECT * FROM quotation where itemCode BETWEEN '50-00-000' AND '69-99-999' AND type='1' ORDER by itemCode ASC";
//echo "$sql<br>";	
$sqlq=mysqli_query($db, $sql);
while($re=mysqli_fetch_array($sqlq)){
$t=itemDes($re[itemCode]);
?>
<tr>
<td><? echo $re[itemCode];?></td>
<td><? echo "$t[des], $t[spc]";?></td>
<td>nos</td>
<td>
<a href="./index.php?keyword=purchase+order+vendor&type=eqpp&project=004&itemCode=<? echo $re[itemCode];?>">
<? echo quotationNo($re[itemCode],'0');?></a></td>
</tr>
<? }//while?>	 
</table>
 <? } 
  elseif($type=='matp'){?>
 <table width="98%" align="center" border="1" bordercolor="#00aaFF" 
 cellpadding="3" cellspacing="0" style="border-collapse:collapse">
 <tr bgcolor="#0099FF">
   <th class="th1">Itemcode</th>
   <th class="th1">Description</th>
   <th class="th1">Unit</th>
   <th class="th1">Quotation<br> at Hand</th>   
 </tr>
<?   include("config.inc.php");
$db11 = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 
	
$sql="SELECT DISTINCT itemCode
FROM quotation where itemCode BETWEEN '00-00-000' AND '49-99-999' ORDER by itemCode ASC ";//echo "$sql<br>";	
$sqlq=mysqli_query($db, $sql);
while($re=mysqli_fetch_array($sqlq)){
$t=itemDes($re[itemCode]);
?>
<tr>
<td><? echo $re[itemCode];?></td>
<td><? echo "$t[des], $t[spc]";?></td>
<td>nos</td>
<td>
<a href="./index.php?keyword=purchase+order+vendor&type=matp&project=004&itemCode=<? echo $re[itemCode];?>">
<? echo quotationNo($re[itemCode],'1');?></a></td>
</tr>
<? }//while?>	 
</table>
 <? } 
 else if($pcode){?>
<table width="98%" align="center" border="1" bordercolor="#00aaFF" cellpadding="3" cellspacing="0" style="border-collapse:collapse">
 <tr bgcolor="#0099FF">
   <th class="th1">Project</th>
   <th class="th1">Itemcode</th>
   <th class="th1">Description</th>
   <th class="th1">Approved</th>   
   <th class="th1">PO Given</th>
   <th class="th1">Unit</th>
   <th class="th1">10 days Req.</th>   
   <th class="th1">Quotation<br> at Hand</th>   
 </tr>
 <?
 include("config.inc.php");
$db11 = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

/*$sql="SELECT dmaItemCode,dmaProjectCode,SUM(dmaQty) as dmaTotal,iowStatus,iow.iowId from dma,iow WHERE".
"  iowStatus IN ('Approved by Mngr P&C','Approved by MD') AND iow.iowId=dma.dmaiow AND dmaProjectCode='$pcode' ";
*/
if($type=='mat'){
if($itemCode11 AND $itemCode12 AND $itemCode13)$itemCode1="$itemCode11-$itemCode12-$itemCode13";
 elseif($itemCode1=='') $itemCode1="01-00-000";
if($itemCode21 AND $itemCode22 AND $itemCode23)$itemCode2="$itemCode21-$itemCode22-$itemCode23";
 elseif($itemCode2=='') $itemCode2="49-99-999";
 }
if($type=='eqp'){
if($itemCode11 AND $itemCode12 AND $itemCode13)$itemCode1="$itemCode11-$itemCode12-$itemCode13";
 elseif($itemCode1=='') $itemCode1="50-00-000";
if($itemCode21 AND $itemCode22 AND $itemCode23)$itemCode2="$itemCode21-$itemCode22-$itemCode23";
 elseif($itemCode2=='') $itemCode2="69-99-999";
 }
if($type=='lab'){
if($itemCode11 AND $itemCode12 AND $itemCode13)$itemCode1="$itemCode11-$itemCode12-$itemCode13";
 elseif($itemCode1=='') $itemCode1="70-00-000";
if($itemCode21 AND $itemCode22 AND $itemCode23)$itemCode2="$itemCode21-$itemCode22-$itemCode23";
 elseif($itemCode2=='') $itemCode2="97-99-999";
 }

$sql="SELECT dmaItemCode,dmaProjectCode,SUM(dmaQty) as dmaTotal from dma WHERE  dmaProjectCode='$pcode' ";

$sql.=" AND dmaItemCode BETWEEN '$itemCode1' AND '$itemCode2' ";

$sql.=" Group by dmaItemCode ";
//echo $sql;
$sqlrunq= mysqli_query($db, $sql);
/* PAge */
$total_result=mysqli_affected_rows();
$total_per_page=15;

if($page<=0)
	{
	$page=1;
	}
$curr=($page-1)*$total_per_page;
$sql.=" LIMIT $curr,$total_per_page";
//echo " <br>$sql<br>";
	$sqlquery=mysqli_query($db, $sql);
	while($sqlresult=mysqli_fetch_array($sqlquery)){
	$order=0;
	$current=0;
	//if($sqlresult[dmaItemCode]=='01-02-001') exit;
	
	$temp=itemDes($sqlresult[dmaItemCode]);
    $tt = explode( '-',$sqlresult[dmaItemCode] );

	
//    echo $sqlresult[dmaItemCode].'--'.$sqlresult[dmaTotal].'-<font class=out>'.$order.'</font>='; 

	if($tt[0]<50 OR $tt[0]=='99'){
	    $order=round(orderQty($sqlresult[dmaProjectCode],$sqlresult[dmaItemCode]),3);
		$approvedQty=round($sqlresult[dmaTotal],3);
		$current=$approvedQty-$order; 
		/*echo "<br>$sqlresult[dmaItemCode]=$current=$approvedQty-$order<br>";
		if($sqlresult[dmaItemCode]=='19-01-006') exit;
		*/
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

if(($current>0 AND ($tt[0]<50) OR $tt[0]>=50)){
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
	<td align="right"><? 	 	if($tt[0]>=50 AND $tt[0]<98) {echo sec2hms( $order,$padHours=false); }
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
   <td align="center">
   <? if($p==1){?>
   <? echo quotationNo($sqlresult[dmaItemCode],$sqlresult[dmaProjectCode]).'nos';}
   else {
   ?>
   <a href="./index.php?keyword=purchase+order+vendor&type=<? echo $type;?>&project=<? echo $sqlresult[dmaProjectCode];?>&itemCode=<? echo $sqlresult[dmaItemCode];?>&dmaTotal=<? echo $sqlresult[dmaTotal];?>&poTotal=<? echo $order; ?>">
   <? echo quotationNo($sqlresult[dmaItemCode],$sqlresult[dmaProjectCode])?> nos</a>
   <? }//else?>
   </td>
 </tr>

<? 
  }//if damTotal>0
$order=0;} 
//}//iow
?>
</table>
<? }//pcode?>
<br>
<br>


 <?php

        include("./includes/PageNavigation.php");

        $totalResults= $total_result;
        $resultsPerPage= $total_per_page;
        $page= $_GET[page];
        $startHTML= "<b>Showing Page {page} of {pages}</b>: Go to Page ";
        $appendSearch= "&pcode=$pcode&type=$type&itemCode1=$itemCode1&itemCode2=$itemCode2";
        $range= 5;
		$rootLink="./index.php?keyword=item+require";
        $link_on= "<a href='$rootLink&page={num}{appendSearch}' class='hd'><b>{num}</b></a>";
        $link_off= "<a href='$rootLink&page={num}{appendSearch}'>{num}</a>";
        $back= " <a href='$rootLink&page=1{appendSearch}'><<</a> ";
        $forward= " <a href='$rootLink&page={pages}{appendSearch}'>>></a> ";

        $myNavigation = New PageNavigation($totalResults, $resultsPerPage, $page, $startHTML, $appendSearch, $range, $link_on, $link_off, $back, $forward);

        echo $myNavigation->getHTML();

?>
<br>
<a href="./print/print_itemRequire.php?pcode=<? echo $pcode;?>" target="_blank">Print</a>
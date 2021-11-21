<?php 
error_reporting(0);
// if($loginProject=="004" && $loginDesignation=="Procurement Executive"){
// 	include("itemRequire_eq.php");
// 	exit;
// }
?>
<form name="fpcode" action="./index.php?keyword=item+require" method="post" class="noPrint">
<table width="500" align="center" class="ablue">
<tr><td class="ablueAlertHd_small" colspan="3"><? if($loginDesignation=='Managing Director' || $loginDesignation=='Project Engineer' || $loginDesignation=='Chairman & Managing Director') echo "Site Requisitions"; else echo "Create Purchase Order"; ?></td></tr>
<tr>
<td>Project</td>
<td colspan="2">
	<select name="pcode" onChange="location.href='./index.php?keyword=item+require&pcode='+fpcode.pcode.options[document.fpcode.pcode.selectedIndex].value";>
		<?
		if($loginDesignation!="Chairman & Managing Director")
			$pcode=$_SESSION[loginProject];

		include("./includes/config.inc.php");
		$db=mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

		if($_POST['requisition']!="")
			$requisition=$_POST['requisition'];
		if($_GET['req']!="")
			$requisition=$_GET['req'];

		$sqlp = "SELECT `pcode`,pname from `project`";
		if($loginDesignation=='Project Engineer' || $loginDesignation=='Procurement Executive')
			 $sqlp.=" where pcode='$pcode' ";
		$sqlp.="  ORDER by pcode ASC";
		//echo $sqlp;
		$sqlrunp=mysqli_query($db, $sqlp);
		while($typel=mysqli_fetch_array($sqlrunp))
		{
		 echo "<option value='".$typel[pcode]."'";
		 if($loginDesignation=="Procurement Executive" && $_SESSION["loginProject"]!=$typel[pcode])echo " style='display:none;' disabled ";
		 if($pcode==$typel[pcode])echo " SELECTED";
		 echo ">$typel[pcode]--$typel[pname]</option> ";
		}?>
	</select>
 </td>
 </tr>
<tr>
	<td>Type</td>
	<td colspan="2">
	 <select  name="type">
		<?
		if($pcode=='004'){
		?>
			<option value="mat" <? if($type=='mat') echo ' selected ';?> >01-01-001 to 49-99-999 Material</option>
			<option value="matp" <? if($type=='matp') echo ' selected ';?> >Material Purchase for CenterStore</option>  
			<option value="eqp"  <? if($type=='eqp') echo ' selected ';?> >50-01-001 to 69-99-999 Equipment Rent</option>  
			<option value="eqpp"  <? if($type=='eqpp') echo ' selected ';?> >Equipment Purchase</option>    
			<option value="lab"  <? if($type=='lab') echo ' selected ';?> >70-01-001 to 97-99-999 Labour</option> 
			<option value="mat_s" <? if($type=='mat_s') echo ' selected ';?> >99-01-001 to 99-99-999 Sub-contractor</option> 
		 <?
		 }
		 else{
		 ?>
			<option value="mat" <? if($type=='mat') echo ' selected ';?> >01-01-001 to 49-99-999 Material </option>
			<option value="eqp"  <? if($type=='eqp') echo ' selected ';?> >50-01-001 to 69-99-999 Equipment Rent</option>  
			<option value="lab"  <? if($type=='lab') echo ' selected ';?> >70-01-001 to 97-99-999 Labour</option>  
			<option value="mat_s" <? if($type=='mat_s') echo ' selected ';?> >99-01-001 to 99-99-999 Sub-contractor</option>
			<?
		}
			?>
		</select>
</td></tr>
<tr>
  <td>Requisition for</td>
  <td colspan="2"><input type="text" name="requisition" size="2" value="<?php echo $requisition ? $requisition : 10; ?>"> Days (Maximum 23 day's)</td>
</tr>

<tr><td>Item Code</td>
    <td >
	<input name="itemCode11" onKeyUp="return autoTab(this, 2, event);" size="2" maxlength="2" value="<?php echo $itemCode11; ?>" > - 
    <input name="itemCode12" onKeyUp="return autoTab(this, 2, event);" size="2" maxlength="2" value="<?php echo $itemCode12; ?>" > - 
    <input name="itemCode13" onKeyUp="return autoTab(this, 3, event);" size="3" maxlength="3" value="<?php echo $itemCode13; ?>" >
	</td>
    <td>
	<input name="itemCode21" onKeyUp="return autoTab(this, 2, event);" size="2" maxlength="2" value="<?php echo $itemCode21; ?>" > - 
    <input name="itemCode22" onKeyUp="return autoTab(this, 2, event);" size="2" maxlength="2" value="<?php echo $itemCode22; ?>"> - 
    <input name="itemCode23" onKeyUp="return autoTab(this, 3, event);" size="3" maxlength="3" value="<?php echo $itemCode23; ?>" >
	</td>
</tr>
<tr class="ablueAlertHd_small"><td align="left" colspan="2" >
	<div style="text-align:left; display:inline-block;"><input type="checkbox" name="zeroQ" <?php echo !empty($zeroQ) ? "checked" : ""; ?>>Show items with 0 quantity.</div>
	</td>
	<td align="right">
<input type="submit" name="Search" value="Search" class='ablue_btn' onmouseover="this.className='ablue_btnhover'" onmouseout="this.className='ablue_btn'" >
</td></tr>
</table> 
</form>

<table width="100%" border="0" class="hideIT printIT" style="width:100% !important;">
	<tr align="center">
	 <th><font class="englishheadBlack">Bangladesh Foundry and Engineering Works Ltd.</font></th>
	</tr>
	<tr align="center">
	 <th>Requisition for <?php echo $loginProject."-".myprojectName($loginProject); ?></th>
	</tr>
	<tr align="right">
	 <th>Report date <?php echo date("d/m/Y"); ?></th>
	</tr>
</table>


<style>
	.errorClass{animation:errorAnim 1s linear; font-size:35px;}
	
	/* Chrome, Safari, Opera */
@-webkit-keyframes errorAnim {
		0%{color:#000; font-size:35px;}
		50%{color:#f00; font-size:40px;}
		100%{color:#fff; font-size:35px;}
}

/* Standard syntax */
@keyframes errorAnim {
		0%{color:#000; font-size:35px;}
		50%{color:#f00; font-size:40px;}
		100%{color:#fff; font-size:35px;}
}
</style>
 <? 
// item code verfication
if(!$itemCode1 || !$itemCode2 || !$type || !$requisition){
		if($type=='mat_s')
			if(($itemCode11!="99" || $itemCode21!="99")){
				{
				 echo "<center><h1 style='color:#f00;' class='errorClass'>Sub-contractor code should be 99-01-001 to 99-99-999</h1></center>"; 
				 exit;
				}
			}
	if($type=='mat')if(($itemCode11<"01" || $itemCode11>"49" || $itemCode21<"01" || $itemCode21>"49"))
		{echo "<center><h1 style='color:#f00;' class='errorClass'>Material code should be 01-01-001 to 49-99-999</h1></center>"; exit;}
	
	if($type=='eqp')if($itemCode11<"50" || $itemCode11>"69" || $itemCode21<"50" || $itemCode21>"69"){echo "<center><h1 style='color:#f00;' class='errorClass'>Equipment code should be 50-01-001 to 69-99-999</h1></center>";exit;}
	
	if($type=='lab')if($itemCode11<"70" || $itemCode11>"97" || $itemCode21<"70" || $itemCode21>"97"){echo "<center><h1 style='color:#f00;' class='errorClass'>Material code should be 70-01-001 to 97-99-999</h1></center>";exit;}
}
// end of item code verification
	 if($type=="mat_s")$type="mat";

 $total_per_page=100;
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
$db11 = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);	 
	
$sql="SELECT * FROM quotation where itemCode BETWEEN '50-00-000' AND '69-99-999' AND type='1' ORDER by itemCode ASC";
// echo "$sql<br>";	
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
$db11 = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 
	
$sql="SELECT DISTINCT itemCode
FROM quotation where itemCode BETWEEN '00-00-000' AND '49-99-999' ORDER by itemCode ASC ";
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
<a href="./index.php?keyword=purchase+order+vendor&type=matp&project=004&itemCode=<? echo $re[itemCode];?>">
<? echo quotationNo($re[itemCode],'1');?></a></td>
</tr>
<? }//while?>	 
</table>
 <? } 
 else if($pcode){?>
<table width="98%" align="center" border="1" bordercolor="#00aaFF" cellpadding="3" cellspacing="0" style="border-collapse:collapse">
 <tr bgcolor="#0099FF">
	 	 <?php if($loginDesignation=="Procurement Executive" || 1==1){ ?>
	 <th class="th1 noPrint">Print</th>
	 <?php } ?>
   <th class="th1 noPrint">Project</th>
   <th class="th1">Itemcode</th>
   <th class="th1">Description</th>
   <th class="th1 noPrint">Approved</th>   
   <th class="th1 noPrint">PO Given</th>
<!--    <th class="th1 hideIT printCenter" align="center">Quantity at Hand</th> -->
   <th class="th1">Unit</th>
   <th class="th1">Quantity at Hand</th>
   <th class="th1">
	 <? if($requisition!="") echo $requisition; else echo "10"; ?> Days Req.</th>   
   <th class="th1">Budget</th>
   <th class="th1">Fuel Consumption</th>
   <th class="th1 noPrint">Quotation<br> at Hand</th>
 </tr>
 <?
	 

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

$sql="SELECT dmaItemCode,dmaProjectCode,SUM(dmaQty) as dmaTotal,avg(dmaRate) as dmaRate from dma WHERE dmaProjectCode='$pcode' ";

$sql.=" AND dmaItemCode>='$itemCode1' AND dmaItemCode<='$itemCode2' ";

$sql.=" Group by dmaItemCode ";
//echo $sql;
$sqlrunq= mysqli_query($db, $sql);
/* PAge */
$total_result=mysqli_affected_rows($db);
$total_per_page=500;

if($page<=0)
	{
	$page=1;
	}
$curr=($page-1)*$total_per_page;
$sql.=" LIMIT $curr,$total_per_page";
// echo " <br>$sql<br>";exit;
$zeroItem=0;$requiredItem=0; //init zero item counter and required item counter
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
	//   print_r($order);
		$approvedQty=round($sqlresult[dmaTotal],3);
		$current=$approvedQty-$order; 
		// echo "<br>$sqlresult[dmaItemCode]=$current=$approvedQty-$order<br>";
		/*
		if($sqlresult[dmaItemCode]=='19-01-006') exit;
		*/
		}
	if($tt[0]>=50 AND $tt[0]<=70){
		 $order=eqorderQty($sqlresult[dmaProjectCode],$sqlresult[dmaItemCode]);
		 $current=($sqlresult[dmaTotal]*3600)-($order*3600);
  }if($tt[0]>=70 AND $tt[0]<=97){ 
		 $order=emporderQty($sqlresult[dmaProjectCode],$sqlresult[dmaItemCode]);
		 $current=($sqlresult[dmaTotal]*3600)-($order*3600);
  }
	//else $current=$sqlresult[dmaTotal]-$order; 	

if(($current>0 AND ($tt[0]<50) OR $tt[0]>=50)){
   if($tt[0]<50) $bg=' bgcolor=#FFFFFF';
     else if($tt[0]<70) $bg=' bgcolor= #FFDDDD';
	  else $bg=' bgcolor = #DDDDFF';
	
	

   if($tt[0]<50){
	   
	 if($requisition=="")   
   	 $nextten = date('Y-m-d',strtotime($todat)+(86400*10));
	 else
	  $nextten = date('Y-m-d',strtotime($todat)+(86400*$requisition));
		$estimatdTotalIssue=nextXdaysReq($todat,$nextten,$sqlresult[dmaItemCode],$sqlresult[dmaProjectCode],$requisition,true);
		// print_r($estimatdTotalIssue);
 }
	 elseif($tt[0]>=50 AND $tt[0]<70){
		 if($requisition=="")  
	     $nextten = date('Y-m-d',strtotime($todat)+(86400*10));
		 else
		 $nextten = date('Y-m-d',strtotime($todat)+(86400*$requisition)); 
    $estimatdTotalIssue=eqnextXdaysReq($sqlresult[dmaItemCode],$sqlresult[dmaProjectCode],$requisition);
//     $estimatdTotalIssue = eqnext10daysReq($sqlresult[dmaItemCode],$sqlresult[dmaProjectCode]);

 }
	 elseif($tt[0]>=70 AND $tt[0]<99){
		if($requisition=="")
	    $nextten = date('Y-m-d',strtotime($todat)+(86400*10));
		else
			$nextten = date('Y-m-d',strtotime($todat)+(86400*$requisition));
    $estimatdTotalIssue=empnext10daysReq($sqlresult[dmaItemCode],$sqlresult[dmaProjectCode]);
	}elseif($tt[0]==99){
	  if($requisition=="")
   		$nextten = date('Y-m-d',strtotime($todat)+(86400*10));
		else
			$nextten = date('Y-m-d',strtotime($todat)+(86400*$requisition));
		
//$estimatdTotalIssue = subnext10daysReq($todat,$nextten,$sqlresult[dmaItemCode],$sqlresult[dmaProjectCode]);
   $estimatdTotalIssue=subnextXdaysReq($todat,$nextten,$sqlresult[dmaItemCode],$sqlresult[dmaProjectCode],$requisition);
 }
	if(!$estimatdTotalIssue){$zeroItem++; if(empty($zeroQ))continue;}else $requiredItem++;
	?>

 <tr <? echo $bg;?> class="noPrint">
	<?php if($loginDesignation=="Procurement Executive" || 1==1){ ?>
	<td class="noPrint"><input type="checkbox" name="" id="" class="printRowSelection"></td>
	<?php } ?>
  <td align="center" class="noPrint"><? echo $sqlresult[dmaProjectCode];?></td>
  <td align="center" width="100"><? echo $sqlresult[dmaItemCode];?></td>
  <td><? echo $temp[des].', '.$temp[spc];?></td>
	<td align="right" class="noPrint">
		<? 
		if($tt[0]>=50 AND $tt[0]<99){
			echo sec2hms( $sqlresult[dmaTotal],$padHours=false);
		}
		else
			echo number_format($sqlresult[dmaTotal],3);
		?>
	</td>
	<td align="right" class="noPrint"><? 
	if($tt[0]>=50 AND $tt[0]<98){
		echo sec2hms( $order,$padHours=false); 
	}
	else
		echo number_format($order,3);
	?>   
	 </td>
   <td align="center"><? if($tt[0]>=50 AND $tt[0]<99) echo 'Hr.';
    else 
   echo $temp[unit];?>
   </td>
	 <td align="right" class="">
	<?php
	$matStock=mat_stock($sqlresult[dmaProjectCode],$sqlresult[dmaItemCode],$todat,$todat);
	echo number_format($matStock,3);
	?>
	 </td>
   <td align="right">  
		<a href="./planningDep/subdailyRequirment.php?project=<? echo $sqlresult[dmaProjectCode];?>&itemCode=<? echo $sqlresult[dmaItemCode];?>" target="_blank">
    <?  echo number_format($estimatdTotalIssue,3);?></a>
   </td>
	<td align="right" class=""><?php
	if($tt[0]<50 || ($tt[0]>70 && $tt[0]<=99)){
		echo number_format($sqlresult[dmaRate]*$estimatdTotalIssue,2);
	}
	?>
	</td>
	 
	 
	 <td>
	<table width=100%  style='border: 1px solid #db7a7a;
    border-collapse: collapse;' border=1>
	<?php	
	$dmaQty=$sqlresult[dmaTotal];
  $Fsql="select e.uitemCode,e.measureUnit,e.consumption,e.consumptionUnit,i.itemDes,i.itemSpec from  eqconsumsion e, itemlist i where e.eqitemCode='$sqlresult[dmaItemCode]' and i.itemCode=e.uitemCode";
  $Fq=mysqli_query($db,$Fsql);
	while($Frow=mysqli_fetch_array($Fq)){
		echo "<tr><td>$Frow[uitemCode] $Frow[itemDes]</td><td align=right>$Frow[consumption] $Frow[consumptionUnit]/".measuerUnti2OriginalUnit($Frow[measureUnit])."</td><td align=right><b>".$dmaQty*$Frow[consumption]."</b> $Frow[consumptionUnit]</td></tr>";
	}
	?>
		 </table>
	 </td>
	 
  <td align="center" class="noPrint">
   <?
	if($p==1 || $loginDesignation=='Project Engineer' || $loginDesignation=='Chairman & Managing Director'){?>
   <? echo quotationNo($sqlresult[dmaItemCode],$sqlresult[dmaProjectCode]).' nos';}
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

	<div style="text-align: center;
    margin-top: 5px;
    color: #888;" class="noPrint"><?php echo "Requisition 0 quantity found: $zeroItem & quantity found: $requiredItem & total: ".($zeroItem+$requiredItem)." itemcode."; ?></div>
<? }//pcode?>
<br>
<br>

<div  class="noPrint">
	
 <?php
        include("./includes/PageNavigation.php");

        $totalResults= $total_result;
        $resultsPerPage= $total_per_page;
        $page= $_GET[page];
        $startHTML= "<b>Showing Page {page} of {pages}</b>: Go to Page ";
        $appendSearch= "&pcode=$pcode&requisition=$requisition&type=$type&itemCode1=$itemCode1&itemCode2=$itemCode2&zeroQ=$zeroQ";
        $range= 5;
		$rootLink="./index.php?keyword=item+require";
        $link_on= "<a href='$rootLink&page={num}{appendSearch}' class='hd'><b>{num}</b></a>";
        $link_off= "<a href='$rootLink&page={num}{appendSearch}'>{num}</a>";
        $back= " <a href='$rootLink&page=1{appendSearch}'><<</a> ";
        $forward= " <a href='$rootLink&page={pages}{appendSearch}'>>></a> ";

        $myNavigation = New PageNavigation($totalResults, $resultsPerPage, $page, $startHTML, $appendSearch, $range, $link_on, $link_off, $back, $forward);

        echo $myNavigation->getHTML();
?>
</div>
<br>
<div class="hideIT printIT bottom" style="margin-left:20px;">
	Print by: <?php 
	$empInfo=siteEngID2SiteEng($_SESSION["loginUname"]);
	echo $empInfo[fullName]."; ".$empInfo[designation]."; ".date("d/m/Y h:i:s");
	?>
</div>
<!-- <a href="./print/print_itemRequire.php?pcode=<? echo $pcode;?>" target="_blank">Print</a> -->
<input type="button" id="printBTN" value="Print" class="noPrint">
<script type="text/javascript">
	$(document).ready(function(){
		$("#printBTN").click(function(){
			window.print();
			return false;
		});
		$("input.printRowSelection").change(function(){
			var tr=$(this).parent().parent();
			if(tr.hasClass("noPrint")==false){
				tr.addClass("noPrint");
			}
			else
				tr.removeClass("noPrint");
		});
	});
</script>
<style>
	.hideIT{
		display:none;
	}
	@media print {
  .noPrint{
    display: none !important;
  }
		.printIT{
			display:table !important;
		}
		.printCenter{
			display:table-cell !important;
		}
}
	.bottom{
		top:95%;
		position:absolute;
	}

</style>
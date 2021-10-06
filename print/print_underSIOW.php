<?
error_reporting(0);
include("../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
include_once("../includes/myFunction1.php");
include_once("../includes/myFunction.php");
include_once("../includes/empFunction.inc.php");
include_once("../includes/eqFunction.inc.php");
include_once("../includes/subFunction.inc.php");
include_once("../includes/matFunction.inc.php");

$todat=todat();
?>
<html>
<head>

<LINK href="style/indexstyle.css" type=text/css rel=stylesheet>
<link href="style/basestyles.css" rel="stylesheet" type="text/css">
<link href="js/fValidate/screen.css" rel="stylesheet" type="text/css">

<meta http-equiv="Content-Language" content="en-us">
<meta name="author" content="<? echo $mauthor;?>">
<meta name="copyright" content="<? echo $tt;?>">
<meta name="keywords" content="<? echo $kword;?>">
<META NAME="description" CONTENT="<? echo $des;?>">
<title>BFEW :: Print IOW</title>
</head>
<body  topmargin="1" leftmargin="5" rightmargin="5" bgcolor="#FFFFFF" >
<a name="top"></a>
<table width="500" border="0"  align="center" cellpadding="5" cellspacing="5">
<tr>
 <th>Bangladesh Foundry and Engineering Works Ltd.</th>
</tr>
<tr>
 <th>IOW detail Report of &nbsp;<? echo date('D',strtotime($todat)).'  '; echo mydate($todat); ?></th>
</tr>
</table>
<br>
<br>

<? 


$sqliow = "SELECT * from `iowtemp` where `iowProjectCode` = '$selectedPcode'  AND `iowId` = '$iow'";
//echo $sqliow;
$sqlruniow= mysqli_query($db,$sqliow);
$resultiow=mysqli_fetch_array($sqlruniow);
?>
<table width="600"  align="center" border="1" bordercolor="#9999CC" bgcolor="#9999CC" cellpadding="0" cellspacing="0" style="border-collapse:collapse" >
 <tr > <td >
<table width="100%"  align="center"  bgcolor="#FFFFFF" border="0" cellpadding="5" cellspacing="0">
<tr>
  <td colspan="4" align="center"><b> Details of Item Of Work (IOW)</b> </td>
</tr>

<tr>
  <td colspan="4">Project:  <font class="out"><? echo myprojectName($selectedPcode);?></font></td>
</tr>
<tr>
  <td colspan="4">Item of Work:<font class="out">  <? echo "$resultiow[iowCode]</b> [ <i>$resultiow[iowDes]</i>]";?></font></td>  
</tr>
<tr>
  <td width="21%">Quantity:<font class="out"><? echo number_format($resultiow[iowQty]);?></font> <? echo $resultiow[iowUnit];?></td>
  <td width="24%">Rate:<font class="out">Tk. <? echo number_format($resultiow[iowPrice],2); ?></font></td>
  <td width="42%">Quotation Price:<font class="out"><? echo number_format($resultiow[iowQty]*$resultiow[iowPrice],2); $totalCost=$resultiow[iowQty]*$resultiow[iowPrice];?></font></td>
</tr>
<tr>
  <td colspan="2">Date of Starting: <font class="out"><? echo date("j-m-Y", strtotime($resultiow[iowSdate]));?></font></td>
  <td colspan="2">Expected Date of Completion: <font class="out"><? echo date("j-m-Y", strtotime($resultiow[iowCdate]));?></font></td>
</tr>

</table>
</td></tr>
</table>
<br>

<?
$tt=0;
$sqlsiow = "SELECT * from `siowtemp` where `iowId` = '$iow' ORDER BY siowId ASC";
//echo $sqlsiow;
$sqlrunsiow= mysqli_query($db,$sqlsiow);
	
$approvedtotalcost=0;
?>
<table  align="center" width="98%" border="0" bordercolor="#E4E4E4" cellpadding="0" cellspacing="0" style="border-collapse:collapse">

  <?
   $i=1;
   while($siow=mysqli_fetch_array($sqlrunsiow)){
   ?>
<a name="go<? echo $siow[siowId];?>"></a>
  <tr bgcolor="#EEEEEE">
    <td height="30"   align="left" colspan="2"><b>SIOW: </b><? echo $siow[siowName];?>
	Start: <? echo myDate($siow[siowSdate]);?>; Finish: <? echo myDate($siow[siowCdate]);?>; Duration:
	<? echo round((strtotime($siow[siowCdate])-strtotime($siow[siowSdate]))/86400)+1;?> days
	
	
	
	</td>
    </tr>
  <tr>
  <td colspan="6">
<?
$sqlp ="SELECT * FROM `dmatemp` WHERE  `dmasiow` LIKE '$siow[siowId]' order by dmaItemCode ASC";
//echo $sqlp;
$sqlrunp= mysqli_query($db,$sqlp);
$totalAmount='';
?>

<table  align="center" width="98%" border="1" bordercolor="#666666" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr bgcolor="#F8F8F8">
    <td height="10" width="100" align="center" rowspan="2"><b>Code</b></td>
    <td width="300" align="center" rowspan="2"><b>Item Description</b></td>
    <td align="center" rowspan="2"><b>Unit</b></td>
    <td align="center">Approved qty <? echo number_format(approvedsiowQty($siow[siowId]));?> <? echo $siow[siowUnit];?></td>
    <td align="center" rowspan="2"><b>Issued<br> Qty</b></td>	
    <td align="center"><font color="#FF0000" >Revise qty <? echo number_format($siow[siowQty]);?> <? echo $siow[siowUnit];?></font></td>		
  </tr>

  <tr bgcolor="#F4F4F4">
    <td align="center">
	 <table border="1" width="100%" bordercolor="#AAAAAA" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
	   <tr>
	   <th width="25%">Qty </th>
	   <th width="25%">Rate </th>
	   <th width="50%">Amount </th>	   	   
	   </tr>
	 </table>
	</td>
    <td align="center">
	 <table border="1" width="100%" bordercolor="#AAAAAA" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
	   <tr>
	   <th width="25%">Qty </th>
	   <th width="25%">Rate </th>
	   <th width="50%">Amount </th>	   	   
	   </tr>
	 </table>
	</td>
  </tr>

  <? while($iowResult=mysqli_fetch_array($sqlrunp))
  {  $test=explode("-",$iowResult[dmaItemCode]);
    if( $test[0]>=35 AND  $test[0]<70) $bg=" bgcolor=#FFFFCC"; 
	else if( $test[0]>=70 AND  $test[0]<=99) $bg=" bgcolor=#F0FEE0";
	 else $bg=" bgcolor=#FFFFFF";
	 
   	if($test[0]>='50' AND $test[0]<='98'){	$itemCode="$test[0]-$test[1]-000";}
     else {$itemCode=$iowResult[dmaItemCode];}


  $sqlitem = "SELECT quotation.*, vendor.vid from itemlist,quotation,vendor where quotation.itemCode = '$itemCode' AND quotation.pCode IN ('$iowResult[dmaProjectCode]','000') AND quotation.vid= vendor.vid order by point DESC";
	//echo $sqlitem;
	$sqlruni= mysqli_query($db,$sqlitem);
	$resultItem=mysqli_fetch_array($sqlruni);
  ?>
  <tr >
    <td align="center"><? echo $itemCode;?></td>
    <td align="left" width="300"><? $temp=itemDes($itemCode); echo $temp[des].', '.$temp[spc];?></td>
    <td align="center"><?
    //$test=explode("-",$iowResult[dmaItemCode]);
	 //if($test[0]>='35' AND $test[0]<'50') echo "Nos";
	 if($test[0]>='35' AND $test[0]<'99') echo "Hr";
	  else  echo $temp[unit];?>
	  </td>

	     <td align="center">
	 <table border="1" width="100%" bordercolor="#AAAAAA" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
	   <tr>
	   <td width="25%" align="right">	<? $approvedQty =approvedQty($siow[siowId],$itemCode); 
	   if($test[0]>='35' AND $test[0]<'99')  echo sec2hms($approvedQty,$padHours=false);
	   else  echo number_format($approvedQty); ?> </td>
	   <td width="25%" align="right">	<? $approvedRate =approvedRate($siow[siowId],$itemCode); echo number_format($approvedRate,2); ?> </td>
	   <td width="50%" align="right"><?
		 $approvedAmount=$approvedQty*$approvedRate; echo number_format($approvedAmount,2);
		 if($test[0]>='01' AND $test[0]<'35'){$approvedmaterialCost+=$approvedAmount;}
		 elseif($test[0]>='35' AND $test[0]<'70'){$approvedequipmentCost+=$approvedAmount;}
		 elseif($test[0]>='70'){$approvedhumanCost+=$approvedAmount;}
		 $approveddirectCost+=$approvedAmount;	 	 
		 $approvedtotalcost=$approvedtotalcost+$approvedAmount;
		 ?></td>
	   
	   	   	   
	   </tr>
	 </table>
	</td>	

    <td align="right"><? issuedQty1($siow[siowId],$itemCode,$selectedPcode) ?></td>
	 <td>
	 <table border="1" width="100%" bordercolor="#AAAAAA" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
	   <tr>
       <td align="right"  width="25%"><? echo $iowResult[dmaQty];?></td>		
    <td align="right" width="25%"><? 
	if($test[0]>='35' AND $test[0]<'50'){
	   //$temp=explode('_',eqVendorRate($itemCode));
	   $temp=explode('_',toolRate($itemCode));	   
	   $rate=$temp[1];
	   $vid=$temp[0];
	   }

	else if($test[0]>='50' AND $test[0]<'70'){
	   //$temp=explode('_',eqVendorRate($itemCode));
	   $temp=explode('_',eqRate($itemCode));	   
	   $rate=$temp[1]/8;
	   $vid=$temp[0];
	   }
	else if($test[0]>='70' AND $test[0]<'99'){
	   $rate=hrRate($itemCode);
	   $vid='hm';
	   }
	else {
	 //$resultItem[rate]);
	$rate=$resultItem[rate];
	$vid=$resultItem[vid];
	if($rate==0){
		$rate=centrelStoreItemRate($itemCode);
		$vid='99';
		}	
	}
	echo number_format($rate,2);
	//echo $rate;
	?>
	<input type="hidden" name="dmaRate<? echo $i;?>" value="<? echo $rate?>">
	<input type="hidden" name="dmaVid<? echo $i;?>" value="<? echo $vid?>">
	<input type="hidden" name="dmaId<? echo $i?>" value="<? echo $iowResult[dmaId];?>"	>
	</td>

    <td align="right" width="50%"><?
	 $amount=$rate*$iowResult[dmaQty]; echo number_format($amount,2);
	 if($test[0]>='01' AND $test[0]<'35'){$materialCost+=$amount;}
	 elseif($test[0]>='35' AND $test[0]<'70'){$equipmentCost+=$amount;}
	 elseif($test[0]>='70'){$humanCost+=$amount;}
	 $directCost+=$amount;	 
	 if($amount==0) {$tt=1; }
	 $totalAmount+= $amount;
	 ?></td>

	   </tr>
	 </table>
	 </td>
  </tr>
  <? 
 $i++; } ?>
  <tr ><td colspan="2" align="center" >Apporved SIOW Direct Expenses Rate Tk. 
  <? if($approvedtotalcost) echo number_format($approvedtotalcost/$siow[siowQty],2).'/'.$siow[siowUnit]."</b>";?></td>
     <td colspan="2" align="right" ><? echo "Sub Total Amount: Tk.".number_format($approvedtotalcost,2);?></td>
	 <td colspan="2" ></td>
 </tr>
 
  <tr bgcolor="#FFFFCC"><td colspan="2" align="center" >Revised SIOW Direct Expenses Rate Tk. 
  <? if($totalAmount)echo number_format($totalAmount/$siow[siowQty],2).'/'.$siow[siowUnit]."</b>";?></td>
     <td colspan="4" align="right" ><? echo "Sub Total Amount: Tk.".number_format($totalAmount,2);?></td>
 </tr>

</table><br>
  <? }?>
  </td></tr> 
  <tr>
      <td colspan="7"> 
	  <table width="100%">
	 <?	$approvedtotalcost=approvedtotalcost($iow);
		if($approvedtotalcost>0){?>

          <tr>
            <td  colspan="3">Estimated Direct Expenses: Total Tk. <? echo number_format($approveddirectCost);?>
			(<font class="out"><? echo number_format(($approveddirectCost/$approvedtotalcost)*100);?>%</font>)</td>
          </tr>
          <tr>
            <td>Material Tk. <? echo number_format($approvedmaterialCost);?>
			(<font class="out"><? echo number_format(($approvedmaterialCost/$approvedtotalcost)*100);?>%</font>); 
            </td>
            <td>Equipment and Tools Tk. <? echo number_format($approvedequipmentCost);?> 
              (<font class="out"><? echo number_format(($approvedequipmentCost/$approvedtotalcost)*100);?>%</font>); 
            </td>
            <td>Labour Tk.<? echo number_format($approvedhumanCost);?> (<font class="out"><? echo number_format(($approvedhumanCost/$approvedtotalcost)*100);?>%</font>) 
            </td>
          </tr>
          <tr>
            <td colspan="3">Estimated Item of Work Direct Expense is <font class="out">Tk.<? echo number_format($approveddirectCost/$resultiow[iowQty],2).'/'.$resultiow[iowUnit]; ?> 
              </font></td>
          </tr>
		  <? }?>
          <tr>
            <td height="30"></td>
          </tr>
          <tr bgcolor="#FFFFCC">
            <td><font color="#FF0000">Revised Estimate</font></td>
          </tr>
          <tr  bgcolor="#FFFFCC">
            <td  colspan="3">Estimated Direct Expenses: Total Tk. <? echo number_format($directCost);?>(<font class="outr"><? echo number_format(($directCost/$totalCost)*100);?>%</font>)</td>
          </tr>
          <tr  bgcolor="#FFFFCC">
            <td>Material Tk. <? echo number_format($materialCost);?>(<font class="outr"><? echo number_format(($materialCost/$totalCost)*100);?>%</font>); 
            </td>
            <td>Equipment and Tools Tk. <? echo number_format($equipmentCost);?> 
              (<font class="outr"><? echo number_format(($equipmentCost/$totalCost)*100);?>%</font>); 
            </td>
            <td>Labour Tk.<? echo number_format($humanCost);?> (<font class="outr"><? echo number_format(($humanCost/$totalCost)*100);?>%</font>) 
            </td>
          </tr>
          <tr bgcolor="#FFFFCC">
            <td colspan="3">Estimated Item of Work Direct Expense is <font class="outr">Tk.<? echo number_format($directCost/$resultiow[iowQty],2).'/'.$resultiow[iowUnit]; ?> 
              </font></td>
          </tr>
        </table></td>
    </tr>

  <br><br>
  </td></tr> 
  </table>


  <br>
  <br>
<? include('../bottom.php');?>
</body>

</html>
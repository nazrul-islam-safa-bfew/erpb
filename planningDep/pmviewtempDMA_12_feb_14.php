<?
if($Save){
include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

$time=mktime(0,0,0, date("m"),date("d"),date("y"));

$updatetime = date('d-m-Y',strtotime(todat()));	


if($check=='Forward to MD'){
	$Checked="<b>Checked </b> at $updatetime by $loginFullName [$loginDesignation]";
	$sqlup=" UPDATE iowtemp SET Checked='$Checked',Approved='$approve', iowStatus='$check'";
	$sqlup.=" WHERE iowId='$iow' AND iowProjectCode='$selectedPcode' ";
	$sqlupdate=mysql_query($sqlup);
}
elseif($check=='Approved by Mngr P&C') {
	 $approve="<b>Approved at</b> $updatetime by $loginFullName [$loginDesignation]" ;
	$sqlup=" UPDATE iowtemp SET Checked='$Checked',Approved='$approve', iowStatus='$check'";
	$sqlup.=" WHERE iowId='$iow' AND iowProjectCode='$selectedPcode' ";
	$sqlupdate=mysql_query($sqlup);
}
elseif($check=='Not Ready') { 
	$sqldma=" UPDATE dmatemp SET dmaRate='' WHERE dmaiow=$iow ";
	mysql_query($sqldma);
	
$sqlup=" UPDATE iowtemp SET Checked='',Approved='', iowStatus='Not Ready',Prepared=''";
$sqlup.=" WHERE iowId='$iow' AND iowProjectCode='$selectedPcode' ";
$sqlupdate=mysql_query($sqlup);
}

//echo $sqlup;

echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=index.php?keyword=pmview+IOW&status=Raised+by+PM\">";
}//save
?>
<?
if($check){

include("./includes/config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 



$updatetime = date('d-m-Y',strtotime(todat()));
//echo $check;
if($check=='Back to Planning Department'){
$status="Raised by PM" ; $approve="" ; 
$sqlup=" UPDATE iowtemp SET Approved='$approve', iowStatus='$status',Checked='' WHERE iowId=$iow ";
$sqlupdate=mysql_query($sqlup);
}
elseif($check=='Approve'){
$status="Approved by MD" ; $approve="<b>Approved at</b> $updatetime by $loginFullName [$loginDesignation]" ;

$sqlup=" UPDATE iowtemp SET Approved='$approve', iowStatus='$status',revision='0' WHERE iowId=$iow ";
//echo $sqlup;
$sqlupdate=mysql_query($sqlup);

$sql="DELETE from iow where iowId=$iow";
$sqlq=mysql_query($sql);

$sql="DELETE from siow where iowId=$iow";
$sqlq=mysql_query($sql);

$sql="DELETE from dma where dmaiow=$iow";
$sqlq=mysql_query($sql);


$sql="INSERT INTO iow (select * from iowtemp where iowId=$iow)";
$sqlq=mysql_query($sql);
$t1=mysql_affected_rows();

$sql="INSERT INTO siow (select * from siowtemp where iowId=$iow)";
$sqlq=mysql_query($sql);
$t2=mysql_affected_rows();

$sql="INSERT INTO dma (select * from dmatemp where dmaiow=$iow)";
$sqlq=mysql_query($sql);
$t3=mysql_affected_rows();

if($t1>=1 AND $t2>=1 AND $t3>=1){
$sql="INSERT INTO iowback (select * from iowtemp where iowId=$iow)";
$sqlq=mysql_query($sql);
$sql="INSERT INTO siowback (select * from siowtemp where iowId=$iow)";
$sqlq=mysql_query($sql);
$sql="INSERT INTO dmaback (select * from dmatemp where dmaiow=$iow)";
$sqlq=mysql_query($sql);

$sql="DELETE from iowtemp where iowId=$iow";
$sqlq=mysql_query($sql);

$sql="DELETE from siowtemp where iowId=$iow";
$sqlq=mysql_query($sql);

$sql="DELETE from dmatemp where dmaiow=$iow";
$sqlq=mysql_query($sql);
 }//if

}
	   /*for($i=1; $i<$tid; $i++)
	      {
		   $rate=${"rate".$i};
		   $id=${"id".$i};
		   $sql="UPDATE dma SET dmaRate='$rate' WHERE dmaId='$id' ";
		   //echo $sql."<br>";
		   $sqlrun=mysql_query($sql);
		  }*/


//echo $sqlup;


echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=index.php?keyword=mdview+IOW&status=Forward%20to%20MD\">";
}//save
?>

<? 
if($check)exit();
include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

$sqliow = "SELECT * from `iowtemp` where `iowProjectCode` = '$selectedPcode'  AND `iowId` = '$iow'";
//echo $sqliow;
$sqlruniow= mysql_query($sqliow);
$resultiow=mysql_fetch_array($sqlruniow);
?>
<table width="600"  align="center" border="1" bordercolor="#9999CC" bgcolor="#9999CC" cellpadding="0" cellspacing="0" style="border-collapse:collapse" >
 <tr > <td >
<table width="100%"  align="center"  bgcolor="#FFFFFF" border="0" cellpadding="5" cellspacing="0">
<tr>
  <td colspan="4" bgcolor="#9999CC" align="center"><b><font color="#FFFFFF"> Details of Item Of Work (IOW)</font></b> </td>
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
<tr>
<td colspan="4"><? echo 'Rev. '.$resultiow[revisionNo];?> <b>Raised at</b> <? echo $resultiow[Prepared];?><br>
<? echo 'Rev. '.$resultiow[revisionNo];?> <? echo $resultiow[Checked];?><br>
<? echo 'Rev. '.$resultiow[revisionNo];?> <? echo $resultiow[Approved];?>
</td>
</tr>

</table>
</td></tr>
</table>
<br>

<?
$tt=0;
$sqlsiow = "SELECT * from `siowtemp` where `iowId` = '$iow' ORDER BY siowId ASC";
//echo $sqlsiow;
$sqlrunsiow= mysql_query($sqlsiow);
?>
<form name="dma" action="./index.php?keyword=pmview+temp+dma&selectedPcode=<? echo $selectedPcode?>&iow=<? echo $iow;?>" method="post">
<table  align="center" width="98%" border="1" bordercolor="#E4E4E4" cellpadding="0" cellspacing="0" style="border-collapse:collapse">

  <?
   $i=1;
   while($siow=mysql_fetch_array($sqlrunsiow)){
$approvedtotalcost=0;
   ?>
<a name="go<? echo $siow[siowId];?>"></a>
  <tr bgcolor="#EEEEEE">
    <td height="30"   align="left"><b>SIOW: </b><a href="./graphReport.php?siow=<? echo $siow[siowId];?>"><? echo $siow[siowName];?></a>
    <?php if($loginDesignation!='General Manager') {?>
	[ <a href="index.php?keyword=edit+sub+item+work&iow=<? echo $iow;?>&siow=<? echo $siow[siowId];?>"> edit</a>]
	<!--[ <a href="./consumableProduct/deleteSIOW.php?iow=<? echo $iow;?>&siowId=<? echo $siow[siowId];?>&project=<? echo $selectedPcode;?>"> delete</a>]-->	
    <?php }?>
    <br>
	Start: <? echo myDate($siow[siowSdate]);?>; Finish: <? echo myDate($siow[siowCdate]);?>; Duration:
	<? echo round((strtotime($siow[siowCdate])-strtotime($siow[siowSdate]))/86400)+1;?> days
	</td>
    <td width="100" align="right">Qty: <? echo number_format($siow[siowQty]);?> <? echo $siow[siowUnit];?>
	
	</td>
    <td><? if($resultiow[iowStatus]=='revision' || $resultiow[iowStatus]=='Hold by MD'){?>
	<a href="./consumableProduct/saveItem.php?iow=<? echo $iow;?>&siow=<? echo $siow[siowId];?>&ana=<? echo $siow[siowQty]/$siow[analysis];?>" target="_blank">Add Resources</a><? }?>
	</td>	
  </tr>
  <tr>
  <td colspan="6">
<?
$sqlp ="SELECT * FROM `dmatemp` WHERE  `dmasiow` LIKE '$siow[siowId]' order by dmaItemCode ASC";
//echo $sqlp;
$sqlrunp= mysql_query($sqlp);
$totalAmount='';
?>

<table  align="center" width="98%" border="1" bordercolor="#666666" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr bgcolor="#E0E0E0">
    <td height="10" width="100" align="center" rowspan="2"><b>Code</b></td>
    <td width="300" align="center" rowspan="2"><b>Item Description</b></td>
    <td align="center" rowspan="2"><b>Unit</b></td>
    <td align="center"><b>Approved</b></td>
    <td align="center" rowspan="2"><b>Issued<br> Qty</b></td>	
    <td align="center"><font color="#FF0000" ><b>Revised</b></font></td>		
  </tr>

  <tr bgcolor="#E0E0E0">
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

  <? while($iowResult=mysql_fetch_array($sqlrunp))
  {  $approvedAmount=0;
  
  $test=explode("-",$iowResult[dmaItemCode]);
    if( $test[0]>=35 AND  $test[0]<70) $bg=" bgcolor=#FFFFCC"; 
	else if( $test[0]>=70 AND  $test[0]<=99) $bg=" bgcolor=#F0FEE0";
	 else $bg=" bgcolor=#FFFFFF";
	 
   	if($test[0]>='50' AND $test[0]<='98'){	$itemCode="$test[0]-$test[1]-000";}
     else {$itemCode=$iowResult[dmaItemCode];}

  ?>
  <tr <? echo $bg; ?>>
    <td align="center"><? echo $itemCode;?></td>
    <td align="left" width="300"><? $temp=itemDes($itemCode); echo $temp[des].', '.$temp[spc];?></td>
    <td align="center"><?
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
	$rate=$iowResult[dmaRate];
	echo number_format($rate,2);
	//echo $rate;
	?>
	<input type="hidden" name="dmaRate<? echo $i;?>" value="<? echo $rate?>">
	<!--<input type="hidden" name="dmaVid<? echo $i;?>" value="<? echo $vid?>">-->
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
  <tr bgcolor="#AAAADD"><td colspan="2" align="center" >SIOW Direct Expenses Rate Tk. 
  <? if($approvedtotalcost) echo number_format($approvedtotalcost/$siow[siowQty],2).'/'.$siow[siowUnit]."</b>";?></td>
     <td colspan="2" align="right" ><? echo "Sub Total Amount: Tk.".number_format($approvedtotalcost,2);?></td>
	 <td colspan="2" bgcolor="#FFCC99" ></td>
 </tr>
 
  <tr bgcolor="#FFCC99"><td colspan="2" align="center" >SIOW Direct Expenses Rate Tk. 
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
          <tr bgcolor="#FFCC99">
            <td><font color="#FF0000">Revised Estimate</font></td>
          </tr>
          <tr bgcolor="#FFCC99">
            <td  colspan="3">Estimated Direct Expenses: Total Tk. <? echo number_format($directCost);?>(<font class="outr"><? echo number_format(($directCost/$totalCost)*100);?>%</font>)</td>
          </tr>
          <tr bgcolor="#FFCC99">
            <td>Material Tk. <? echo number_format($materialCost);?>(<font class="outr"><? echo number_format(($materialCost/$totalCost)*100);?>%</font>); 
            </td>
            <td>Equipment and Tools Tk. <? echo number_format($equipmentCost);?> 
              (<font class="outr"><? echo number_format(($equipmentCost/$totalCost)*100);?>%</font>); 
            </td>
            <td>Labour Tk.<? echo number_format($humanCost);?> (<font class="outr"><? echo number_format(($humanCost/$totalCost)*100);?>%</font>) 
            </td>
          </tr>
          <tr bgcolor="#FFCC99">
            <td colspan="3">Estimated Item of Work Direct Expense is <font class="outr">Tk.<? echo number_format($directCost/$resultiow[iowQty],2).'/'.$resultiow[iowUnit]; ?> 
              </font></td>
          </tr>
        </table></td>
    </tr>

  <? if( $resultiow[iowStatus]=='Raised by PM' AND ($loginDesignation=='Manager Planning & Control' OR $loginDesignation=='Project Manager' OR $loginDesignation=='Construction Manager')){?>
  <tr><td align="center" colspan="7"> 
     <? include("./planningDep/action.php");?>
  </td></tr>
  <? }?>
  <? if( $resultiow[iowStatus]=='Forward to MD' AND $loginDesignation=='Managing Director'){?>
  <tr>
  <td align="center" ><input type="submit" name="check" value="Approve"  style="width:200; color:006633; font-size:16px; font-weight:bold" ></td>
  <td align="center" ><input type="submit" name="check" value="Back to Planning Department"  style="width:300; color:FF0000; font-size:16px; font-weight:bold" ></td>
</tr>
  <? }?>
  
  <br><br>
  </td></tr> 
  </table>
  <input type="hidden" name="n" value="<? echo $i;?>">
 </form>

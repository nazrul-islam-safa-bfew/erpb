<?
error_reporting(0);
/*
  $ch = curl_init();
$headers["Content-Length"] = strlen($postString);
$headers["User-Agent"] = "Curl/1.0";

curl_setopt($ch, CURLOPT_URL, $requestUrl);
    curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, 'admin:');
curl_setopt($ch,CURLOPT_TIMEOUT,5000);
$response = curl_exec($ch);
curl_close($ch);
//set_time_limit(0);
*/
ini_set("memory_limit","1000M");
ini_set("max_execution_time","5000");
ini_set('max_input_vars', 5000);

$iow=$_GET['iow'];


if($update){




	for($i=1;$i<$n;$i++){
	if(${revQty.$i}){
	
	$te=explode('-',${dmaRate.$i});	   
 	$rate=round($te[0],2);
 	$vid=round($te[1],3);	
 	$dId=$te[2];	
// print ${dmaRate.$i}."<br>";
   $sqlUpdate="UPDATE `dmatemp` SET `dmaQty`='${revQty.$i}',`dmaRate`='$rate',dmaVid='$vid' WHERE `dmaId`='$dId'";

	//${dmaRate.$i}=round(${dmaRate.$i},2);
	//${revQty.$i}=round(${revQty.$i},3);
		
//	$sqlUpdate="UPDATE `dmatemp` SET `dmaQty`='${revQty.$i}',".
//	" `dmaRate`='${dmaRate.$i}',dmaVid='${dmaVid.$i}' WHERE `dmaId`='${dmaId.$i}'";
//	echo $sqlUpdate.'<br>';
	$sqlRunUpdate=mysql_query($sqlUpdate);
	}//if
	else {
		$te=explode('-',${dmaRate.$i});	 
		$dId=$te[2]; 
	    $sqlDelete="DELETE FROM `dmatemp` WHERE `dmaId`='$dId'";
		//echo $sqlDelete.'<br>';
		mysql_query($sqlDelete);
		}	
  }//for
}

if($dmaDelete=='1'){
include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sqlDelete="DELETE FROM `dmatemp` WHERE `dmaId`='$r'";
//echo $sqlDelete;
$sqlRunDelete=mysql_query($sqlDelete);
}

if($PMapproved){
include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
	
	
$updatetime = date('d-m-Y',strtotime(todat()));
// update dma information
	for($i=1;$i<$n;$i++){
	if(${revQty.$i}){
	
	$te=explode('-',${dmaRate.$i});	   
 	$rate=round($te[0],2);
 	$vid=round($te[1],3);	
 	$dId=$te[2];	
	//${dmaRate.$i}=round(${dmaRate.$i},2);
	//${revQty.$i}=round(${revQty.$i},3);
	
	/*$sqlUpdate="UPDATE `dmatemp` SET `dmaQty`='${revQty.$i}',".
	" `dmaRate`='${dmaRate.$i}',dmaVid='${dmaVid.$i}'".
	" WHERE `dmaId`='${dmaId.$i}'";*/
	$sqlUpdate="UPDATE `dmatemp` SET `dmaQty`='${revQty.$i}',`dmaRate`='$rate',dmaVid='$vid' WHERE `dmaId`='$dId'";

	//echo $sqlUpdate.'<br>';
	$sqlRunUpdate=mysql_query($sqlUpdate);
	}//if
	else {
		$te=explode('-',${dmaRate.$i});	 
		$dId=$te[2]; 
	    $sqlDelete="DELETE FROM `dmatemp` WHERE `dmaId`='$dId'";
		//echo $sqlDelete.'<br>';
		$sqlRunDelete=mysql_query($sqlDelete);
		}	
  }//for

$sq=mysql_query("select revisionNo from iowtemp where iowId='$iow'");
$r=mysql_fetch_array($sq);

$revision=$r[revisionNo];

$sql="UPDATE dmatemp set revisionNo='$revision' WHERE dmaiow=$iow";
//echo $sql.'<br>';
$sqlq=mysql_query($sql);

	
$sqlUpdate="UPDATE `iowtemp` SET `Prepared`=' $updatetime by $loginFullName [$loginDesignation]',".
" `iowStatus`='Raised by PM' WHERE `iowId`='$iow'";

//echo $sqlUpdate;
$sqlRunUpdate=mysql_query($sqlUpdate);
echo "Your Information is Updating.. Please wait..";
	 
echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=./index.php?keyword=site+iow+detail&status=Not+Ready\">";
exit();
}

include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
if($iowStatus=='Approved by MD')
$sqliow = "SELECT * from `iow` where `iowProjectCode` = '$loginProject'  AND `iowId` = '$iow'";
else 
$sqliow = "SELECT * from `iowtemp` where `iowProjectCode` = '$loginProject'  AND `iowId` = '$iow'";
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
  <td colspan="4">Project:  <font class="out"><? echo $loginProjectName;?></font></td>
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
<td colspan="4"><b>Raised at</b> <? echo $resultiow[Prepared];?><br>
<? echo $resultiow[Checked];?><br>
<? echo $resultiow[Approved];?>
</td>
</tr>

</table>
</td></tr>
</table>
<br>

<a href="./graph/viewGraph.php?iowId=<? echo $resultiow[iowId];?>&iowStatus=<? echo $iowStatus;?>&gproject=<? echo $loginProject;?>" target="_blank" title="Click For View Graphical Presentation">[ GRAPH ]</a>
<?
$tt=0;
if($iowStatus=='Approved by MD')
 $sqlsiow = "SELECT * from `siow` where `iowId` = '$iow' ORDER BY siowId ASC";
else 
 $sqlsiow = "SELECT * from `siowtemp` where `iowId` = '$iow' ORDER BY siowId ASC";
//echo $sqlsiow;
$sqlrunsiow= mysql_query($sqlsiow);
?>
<form name="dma" action="./index.php?keyword=site+view+dma&iow=<? echo $iow;?>&iowStatus=<? echo $iowStatus;?>" method="post">
<table  align="center" width="98%" border="1" bordercolor="#E4E4E4" cellpadding="0" cellspacing="0" style="border-collapse:collapse">

  <?
   $i=1;
   while($siow=mysql_fetch_array($sqlrunsiow)){

   ?>
<a name="go<? echo $siow[siowId];?>"></a>
  <tr bgcolor="#EEEEEE">
    <td height="30"   align="left"><b>SIOW: <? echo $resultiow[iowCode].'<font class=out>'.$siow[siowCode].'</font>';?> </b><? echo $siow[siowName];?>
	[ <a href="index.php?keyword=edit+sub+item+work&iow=<? echo $iow;?>&siow=<? echo $siow[siowId];?>&iowStatus=<? echo $iowStatus;?>"> edit</a>]
	[ <a href="./consumableProduct/deleteSIOW.php?iow=<? echo $iow;?>&siowId=<? echo $siow[siowId];?>&project=<? echo $loginProject;?>"> delete</a>]	<br>
	Start: <? echo myDate($siow[siowSdate]);?>; Finish: <? echo myDate($siow[siowCdate]);?>; Duration: 
	<? echo round((strtotime($siow[siowCdate])-strtotime($siow[siowSdate]))/86400)+1;?> days	</td>
    <td width="100" align="right">Qty: <? echo number_format($siow[siowQty]);?> <? echo $siow[siowUnit];?>	</td>
    <td><? if($resultiow[iowStatus]=='Not Ready' || $resultiow[iowStatus]=='Hold by MD'){?>
	<a href="./consumableProduct/saveItem.php?iow=<? echo $iow;?>&siow=<? echo $siow[siowId];?>&ana=<? echo $siow[siowQty]/$siow[analysis];?>" target="_blank">Add Resources</a><? }?>	</td>	
  </tr>
  <tr>
  <td colspan="6">
<?
if($iowStatus=='Approved by MD')
 $sqlp ="SELECT * FROM `dma` WHERE  `dmasiow` LIKE '$siow[siowId]' order by dmaItemCode ASC LIMIT 0,490";
else 
 $sqlp ="SELECT * FROM `dmatemp` WHERE  `dmasiow` LIKE '$siow[siowId]' order by dmaItemCode ASC LIMIT 0,490";
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
    <td align="center" bgcolor="#FFCC99"><font color="#FF0000" ><b>Revised</b></font></td>		
  </tr>

  <tr bgcolor="#E0E0E0">
    <td align="center">
	 <table border="1" width="100%" bordercolor="#AAAAAA" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
	   <tr>
	   <th width="25%">Qty </th>
	   <th width="25%">Rate </th>
	   <th width="50%">Amount </th>	   	   
	   </tr>
	 </table>	</td>
    <td align="center">
	 <table border="1" width="100%" bordercolor="#AAAAAA" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
	   <tr>
	   <th width="25%">Qty </th>
	   <th width="25%">Rate </th>
	   <th width="50%">Amount </th>	   	   
	   </tr>
	 </table>	</td>
  </tr>

  <? while($iowResult=mysql_fetch_array($sqlrunp))
  {  $test=explode("-",$iowResult[dmaItemCode]);
    if( $test[0]>=35 AND  $test[0]<70) $bg=" bgcolor=#FFFFCC"; 
	else if( $test[0]>=70 AND  $test[0]<=97) $bg=" bgcolor=#F0FEE0";
	 else $bg=" bgcolor=#FFFFFF";
	 
   	if($test[0]>='50' AND $test[0]<'98'){	$itemCode="$test[0]-$test[1]-000";}
     else {$itemCode=$iowResult[dmaItemCode];}

  $sqlitem = "SELECT quotation.*, vendor.vid from quotation,vendor".
  " where quotation.itemCode = '$itemCode' AND quotation.pCode IN ('$iowResult[dmaProjectCode]','000')".
  " AND quotation.vid= vendor.vid order by point DESC";	
	//echo $sqlitem;
	$sqlruni= mysql_query($sqlitem);
	$resultItem=mysql_fetch_array($sqlruni);
	$temp=itemDes($itemCode);
  ?>
  <tr <? echo $bg; ?>>
    <td align="center"><? echo $itemCode;?>	</td>
    <td align="left" width="300"><?  echo $temp[des].', '.$temp[spc];?></td>
    <td align="center"><?
    //$test=explode("-",$iowResult[dmaItemCode]);
	 //if($test[0]>='35' AND $test[0]<'50') echo "Nos";
	 if($test[0]>='35' AND $test[0]<'98') echo "Hr";
	  else  echo $temp[unit];?>	  </td>

	     <td align="center">
	 <table border="1" width="100%" bordercolor="#AAAAAA" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
	   <tr>
	   <td width="25%" align="right">	<? $approvedQty =approvedQty($siow[siowId],$itemCode); 
	   if($test[0]>='35' AND $test[0]<'98')  echo sec2hms($approvedQty,$padHours=false);
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
	 </table>	</td>	

    <td align="right"><?  $issuedQtyp=0;$issuedQty=0; 
		if($test[0]>='01' AND $test[0]<'50'){
	 $issuedQty=0; 
	 $issuedQtyp=0;
	 $issuedQty=issuedQty1($siow[siowId],$itemCode,$loginProject); 
	 $issuedQtyp=$issuedQty;
	 }
	 else if($test[0]>='50' AND $test[0]<'69'){
	 $issuedQty=0; $issuedQty=eqTotalWorksiow($itemCode,$siow[siowId],$todat,0)/3600;
     $issuedQtyp=sec2hms($issuedQty,$padHours=false);
	 }
	 else if($test[0]>='70' AND $test[0]<'98'){
	 $issuedQty=0; $issuedQty=empTotalWorksiow($itemCode,$siow[siowId],$todat,0)/3600;
     $issuedQtyp=sec2hms($issuedQty,$padHours=false);
	 }
	 else if($test[0]=='99'){
	 $issuedQty=0; $issuedQty=subWork_issued($itemCode,$siow[siowId]);
     $issuedQtyp=$issuedQty;
	 }	 
 echo $issuedQtyp;
	 ?></td>
	 <td>
	 <table border="1" width="100%" bordercolor="#AAAAAA" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
	   <tr>
       <td align="right"  width="25%"><input type="text" name="revQty<? echo $i;?>" value="<? echo $iowResult[dmaQty];?>" size="2" width="3" style="text-align:right" onBlur="if(this.value<<? echo $issuedQty;?>) {alert('Error!! Revised Qty cannot be less than Issued Qty.'); this.value=<? echo $issuedQty;?>;}"></td>		
    <td align="right" width="25%"><? 
	if($test[0]>='35' AND $test[0]<'50'){
	   //$temp=explode('_',eqVendorRate($itemCode));
	   $temp=explode('_',toolRate($itemCode));	   
	   $rate=$temp[1];
	   $vid=$temp[0];
	   }
/*
	else if($test[0]>='50' AND $test[0]<'70' AND $test[0]!='60'){
	   //$temp=explode('_',eqVendorRate($itemCode));
	   $temp=explode('_',eqRate($itemCode));
	   $rate=$temp[1]/8;
	   $vid=$temp[0];
	   }
 */            
              else if($test[0]>='50' AND $test[0]<'70'){                 
                	 //$resultItem[rate]);
	$rate=$resultItem[rate]/8;
	$vid=$resultItem[vid];
	
          if($rate==0){
              $temp=explode('_',eqRate($itemCode));
	   $rate=$temp[1]/8;
	   $vid=$temp[0]; 
          }
          
              
              if($rate==0){
              
		$rate=centrelStoreItemRate($itemCode);
		$vid='99';
		}
	 
             }
             
	else if($test[0]>='70' AND $test[0]<'98'){
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
          
          
          
          //code from suvro      
          
          
        $vag = explode(".", $rate);
        $the_last_two_point = $vag[1][0] . $vag[1][1];

        if ($vag[1][2] > 0) {
            $new_rate = $the_last_two_point + 1;
            $new_rate = $vag[0] . "." . $new_rate;
        } else {
            $new_rate = $vag[0] . "." . $the_last_two_point;
        }


        $rate = $new_rate;
        //end of code
          
	echo number_format($rate,2);
	//echo $rate;
	if($rate<0) $tt=0;
	?>
	<input type="hidden" name="dmaRate<? echo $i;?>" value="<? echo $rate."-".$vid."-".$iowResult[dmaId];?>">
<!--
	<input type="hidden" name="dmaVid<? echo $i;?>" value="<? echo $vid;?>">
	<input type="hidden" name="dmaId<? echo $i?>" value="<? echo $iowResult[dmaId];?>"	>  -->	</td>

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
	 </table>	 </td>
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
  <? $approvedtotalcost=0; }?>  </td></tr> 
  <? if($iowStatus=='Not Ready') {?>
 <tr>
   <td align="center" colspan="8"><input type="button" name="update1" value="Update" onClick="dma.update.value=1;dma.submit();">
    <input type="hidden" name="update" value="0"> 
    <input type="hidden" name="n" value="<? echo $i;?>">
    <? //echo "<a  href='./index.php?keyword=site+view+dma1&iow=$iow&iowStatus=".$_GET['iowStatus']."' >SECOND PAGE</a>"?> </td></tr>
<? }?>
  <tr>
      <td colspan="7"> <table width="100%">
	    <? 
		$approvedtotalcost=approvedtotalcost($iow);
		if($approvedtotalcost>0){
		
		?>
          <tr>
            <td  colspan="3">Estimated Direct Expenses: Total Tk. <? echo number_format($approveddirectCost);?> 
              (<font class="out"><? echo number_format(($approveddirectCost/$approvedtotalcost)*100);?>%</font>)</td>
          </tr>
          <tr>
            <td>Material Tk. <? echo number_format($approvedmaterialCost);?>
			(<font class="out"><? echo number_format(($approvedmaterialCost/$approvedtotalcost)*100);?>%</font>);            </td>
            <td>Equipment and Tools Tk. <? echo number_format($approvedequipmentCost);?> 
              (<font class="out"><? echo number_format(($approvedequipmentCost/$approvedtotalcost)*100);?>%</font>);            </td>
            <td>Labour Tk.<? echo number_format($approvedhumanCost);?> (<font class="out"><? echo number_format(($approvedhumanCost/$approvedtotalcost)*100);?>%</font>)            </td>
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
            <td>Material Tk. <? echo number_format($materialCost);?>(<font class="outr"><? echo number_format(($materialCost/$totalCost)*100);?>%</font>);            </td>
            <td>Equipment and Tools Tk. <? echo number_format($equipmentCost);?> 
              (<font class="outr"><? echo number_format(($equipmentCost/$totalCost)*100);?>%</font>);            </td>
            <td>Labour Tk.<? echo number_format($humanCost);?> (<font class="outr"><? echo number_format(($humanCost/$totalCost)*100);?>%</font>)            </td>
          </tr>
          <tr bgcolor="#FFCC99">
            <td colspan="3">Estimated Item of Work Direct Expense is <font class="outr">Tk.<? echo number_format($directCost/$resultiow[iowQty],2).'/'.$resultiow[iowUnit]; ?> 
              </font></td>
          </tr>
        </table></td>
    </tr>
  <? 
  if($resultiow[iowStatus]=='Not Ready') {?><tr><td colspan="7" align="center"><br><br>
        <? if($tt) {   
  $errorMsg= "<table width=400 align=center border=1 cellspacing=0 cellpading=0 style='border-collapse: collapse' bordercolor=#FF0000>";
$errorMsg.="<tr><td background=./images/tbl_error.png align=center><font color=#FFFFFF> IOW IS NOT READY FOR SUBMIT</font></td></tr>";
$errorMsg.="<tr><td align=center>";
$errorMsg.="<p align=center><font face=Verdana size=1 color=red><b>Quantity Or Rate Not Found.</font><b><p>";
$errorMsg.="</td>";
$errorMsg.="</tr>";
$errorMsg.="</table>";
 echo   $errorMsg;
  } else {?>
        <input type="submit" name="PMapproved" value="Submit by PM"> 
        <? }?>
        <br>
        <br>
  </td></tr> <? }?>
  </table>
  
  <input type="hidden" name="n" value="<? echo $i;?>">
</form>

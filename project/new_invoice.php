<?
include('./project/siteMaterialReport.f.php');?>
<? include('./project/siteDailyReport.f.php');?>

<? 
//echo " 5555555555555555555555555: ".$invoiceType;
include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);
if($ck){
	

	
$edate1=formatDate($edate,'Y-m-j');
//echo "invoiceType=$invoiceType<br>";
if($invoiceType=='1'){
//print "14";
 $sql2 = "INSERT INTO `invoice` ( inId,invoiceNo ,invoiceType,subInvoice,advanceAdj,retention,tax,vat, invoiceAmount , receiveAmount , invoiceDate,invoiceStatus,invoiceLocation,invoiceDes)". 
" VALUES ('','$invoiceNO' ,'$invoiceType','$subInvoice','$advanceAdj','','$tax','$vat', '$invoiceAmount' , '','$edate1' , '1','$selectedPcode','$invoiceDes')";
// echo $sql2.'<br>';
$sqlrunp11= mysqli_query($db, $sql2);

 }//ifinvoice type=1
else if($invoiceType=='5'){

 $sql2 = "INSERT INTO `invoice` ( inId,invoiceNo ,invoiceType,subInvoice,advanceAdj,retention,tax,vat, invoiceAmount , receiveAmount , invoiceDate,invoiceStatus,invoiceLocation,invoiceDes)". 
" VALUES ('','$invoiceNO' ,'$invoiceType',$subInvoice,'','',$tax,$vat, '$invoiceAmount' , '','$edate1' , '1','$selectedPcode','$invoiceDes')";
//echo $sql2.'<br>';
$sqlrunp11= mysqli_query($db, $sql2);

 }//ifinvoice type=1
if($invoiceType=='2'){
 $sql2 = "INSERT INTO `invoice` ( inId,invoiceNo ,invoiceType,subInvoice,advanceAdj,retention,tax,vat, invoiceAmount , receiveAmount , invoiceDate,invoiceStatus,invoiceLocation,invoiceDes)". 
" VALUES ('','$invoiceNO' ,'$invoiceType','$subInvoice','$totaladvanceAdj','$retention','$tax','$vat', '$invoiceAmount' , '','$edate1' , '1','$selectedPcode','$invoiceDes')";
//echo $sql2.'<br>';
mysqli_query($db, $sql2);
$r=mysqli_affected_rows($db);
if($r>0){
for($i=1;$i<$n;$i++){
	
	if(${currentQty.$i}){
	
	 $sql11 = "INSERT INTO `invoicedetail` ( `id` ,`iowId` ,pCode, `invoiceNo` , `qty` , `rate` , edate,`des` )". 
	" VALUES ('','${iowId.$i}' ,'$project' ,'$invoiceNO' , '${currentQty.$i}' , '${rate.$i}' ,'$edate1' ,'')";
	//echo $sql11.'<br>';
	$sqlrunp11= mysqli_query($db, $sql11);
	}//if
}
for($i=1;$i<$a;$i++){
	if(${advanceAdj.$i}>0){
	
	 $sql11 = "INSERT INTO `invoiceadv` ( `id` ,`invoiceNO` ,reff, `amount`,edate )". 
	" VALUES ('','$invoiceNO','${advanceAdjInv.$i}','${advanceAdj.$i}','$edate1' )";
	//echo $sql11.'<br>';
	mysqli_query($db, $sql11);	
	}
}//for
}//r

}//if invoiceType==2
}//if ck
?>
	<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
<div style="background:#FFEEEE;width:600px;" class="divBorder" >
<form name="searchIOW" action="./index.php?keyword=new+invoice" method="post">
<table>
<tr>
<?
include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);
	

/*if($loginDesignation=='Project Manager') {?>
<td>Project Name:</td>
<td>
<? 
$sqlp = "SELECT `pcode`,pname from `project` where pcode='$loginProject'";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

while($typel= mysqli_fetch_array($sqlrunp))
{
	//echo "$typel[pcode]--$typel[pname]";
	echo "dashdjh";
}
?>
</td>
<? } ?>

<? else { */?>
<td>Select Project:</td>
<td><select name="selectedPcode">
<!-- <option value="" ><? if($loginDesignation!='Project Manager') echo "All Project";?> </option>-->
<?
if($loginDesignation=='Project Manager')
$sqlp = "SELECT `pcode`,pname from `project` where pcode='$loginProject'";
else
$sqlp = "SELECT `pcode`,pname from `project` ORDER by pcode ASC";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

 while($typel= mysqli_fetch_array($sqlrunp))
{
 echo "<option value='".$typel[pcode]."'";
 if($typel[pcode]==$selectedPcode) echo " selected ";
 echo ">$typel[pcode]--$typel[pname]</option>  ";
 }
?> </select>
</td> 
<? // } ?>
</tr>

<tr><td>Type:</td>
<td>
<select name="invoiceType">
<option value="1" <? if($invoiceType==1) echo 'selected';?> >Advance</option>
<option value="2" <? if($invoiceType==2) echo 'selected';?>>Running Invoice</option>
<!-- <option value="3" <? if($invoiceType==3) echo 'selected';?>>Final Invoice</option>
<option value="4" <? if($invoiceType==4) echo 'selected';?>>Retaintion Money Invoice</option>
<option value="5" <? if($invoiceType==5) echo 'selected';?>>Compansation Invoice</option> -->

</select>
</td>
</tr> 
<tr><td colspan="2" align="center">
  <input type="submit" name="search" value="Search">
  </td></tr>
</table>

</form>


</div>
<br>
<br>
<? if($selectedPcode){
$taxp=invoiceTax($selectedPcode);
$vatp=invoiceVat($selectedPcode);
$retentionp=invoiceRetention($selectedPcode);
//$advanceAdjp=invoiceAdv_Adj($selectedPcode);
?>
<div style="background:#EEEEFF;width:1000px;" class="divBorder" >
<form name="invoice" action="index.php?keyword=new+invoice" method="post">

 <input type="hidden" name="invoiceType"  value="<? echo $invoiceType;?>">  
Project: <? echo $selectedPcode.'  '.myprojectName($selectedPcode);?> 
<input type="hidden" name="selectedPcode" value="<? echo $selectedPcode;?>">
<br>
INVOICE no: 
<input type="text" name="invoiceNO" value="<? echo $invoiceNO;?>" alt="req" title="invoice N0">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Date:

	<SCRIPT LANGUAGE="JavaScript">
	var now = new Date(); 
	var cal = new CalendarPopup("testdiv1");
    	//cal.showNavigationDropdowns();
		cal.setWeekStartDay(6); // week is Monday - Sunday
		//cal.addDisabledDates(null,formatDate(now,"yyyy-MM-dd")); 
		cal.setCssPrefix("TEST");		
		cal.offsetX = 0;
		cal.offsetY = 0;		
	</SCRIPT>
  
  <input class="yel" type="text" maxlength="10" name="edate" value="<? echo $edate;?>" alt="req" title="invoice Date"> <a id="anchor" href="#"
   onClick="cal.select(document.forms['invoice'].edate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
<br><br>
<? if($invoiceType==1){?>

<table width="100%" align="center">

<tr>
 <td>Description</td>
      <td><textarea name="invoiceDes" cols="75" rows="5"></textarea></td>
</tr>
<tr>
 <td>Advance Amount</td><td><input type="number" name="subInvoice" class="number" 
 onBlur1="tax.value=(this.value*<? echo $taxp?>)/100;vat.value=(this.value*<? echo $vatp?>)/100;
 invoiceAmount.value=subInvoice.value-tax.value-vat.value">  Tk. </td>
</tr>


<!-- <tr>
 <td>Advance adjustable @ </td><td><input type="text" name="advanceAdj" class="number"> % of Running Invoice Amount</td>
</tr> -->

<tr>
 <td>Tax on Amount 
<!-- 	 (<font class="out"><? echo $taxp;?>%</font>) -->
	</td><td><input type="number" name="tax" class="number">  Tk. </td>
</tr><tr>
 <td>VAT on Amount 
<!-- 	 (<font class="out"><? echo $vatp;?>%</font>) -->
	</td><td><input type="number" name="vat" class="number">  Tk. </td>
</tr>
<tr>
 <td>Total Invoice Amount</td><td><input type="number" name="invoiceAmount"  class="number">  Tk. </td>
</tr>
<tr>
 <td colspan="2" align="center"><input type="button" name="save" value="Invoice Raised" 
 onClick="if(checkrequired(invoice)) {invoice.ck.value=1;invoice.submit();}">
 <input type="hidden" name="ck"  value="0">
 <input type="hidden" name="project"  value="<? echo $selectedPcode;?>">
 </td> 
</tr>
</table>
<? } else if($invoiceType==4){
$invoiceRetention_date=invoiceRetention_date($selectedPcode);
echo "Plan Invoice Date: ".myDate($invoiceRetention_date);
?>
<table width="100%" align="center">
<tr>
<th>Invoice No</th>
<th>Invoice Date</th>
<th align="right">Invoice Amount</th>
<th align="right" >Invoice Retention Amount</th>
</tr>
<? include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);
	
	$sql="SELECT * from invoice WHERE invoiceType IN ('2','3')";
		 //echo $sql;
	$sqlQ=mysqli_query($db, $sql);
	while($in=mysqli_fetch_array($sqlQ)){?>
	 <tr>
	   <td align="center"> <?  echo $in[invoiceNo];?></td>	   
	   <td align="center"><? echo myDate($in[invoiceDate]);?></td>	   	 
	   <td align="right" ><? echo number_format($in[invoiceAmount],2);?></td>	 
	   
      <td align="right" >
        <? 
			$subRetention=round(($in[invoiceAmount]*$retentionp)/100,2);
			echo number_format($subRetention,2);
			$Totalretention+=$subRetention;
	   ?>
      </td>	 	   
	   
	 </tr>
	
	<? } ?>
<tr>
 <td>Total Amount </td>
 <td><? echo number_format($Totalretention,2);?><input type="hidden" name="Totalretention" value="<? echo $Totalretention;?>" >  Tk. </td>
</tr>	
<tr>
 <td>Tax on Amount <? echo $taxp;?>%</td>
 <td><? $tax=($Totalretention*$taxp)/100; echo '<font class=out>('.number_format($tax,2).')</font>';?>
 <input type="hidden" name="tax" value="<? echo $tax;?>" >  Tk. </td>
</tr><tr>
 <td>VAT on Amount <? echo $vatp;?>%</td>
 <td><? $vat=($Totalretention*$vatp)/100; echo '<font class=out>('.number_format($vat,2).')</font>';?><input type="hidden" name="vat" value="<? echo $vat;?>">  Tk. </td>
</tr>
<tr>
 <td>Total Invoice Amount</td>
 <td>
<? $invoiceAmount=$Totalretention-($tax+$vat);
   $invoiceAmount=round($invoiceAmount,2);
   echo number_format($invoiceAmount,2);
?>
 <input type="hidden"  name="invoiceAmount"  value="<? echo $invoiceAmount;?>">  Tk. </td>
</tr>
 <? if($invoiceRetention_date){?>
<tr>
 <td colspan="3" align="center"><input type="button" name="save" value="Invoice Raised" 
 onClick="if(checkrequired(invoice)) {invoice.ck.value=1;invoice.submit();}">
 <input type="hidden" name="ck"  value="0">
 <input type="hidden" name="project"  value="<? echo $selectedPcode;?>">
 <input type="hidden" name="invoiceType"  value="<? echo $invoiceType;?>">  
 </td> 
</tr>
<? }?>
</table>
</div>
<? } else if($invoiceType==5){?>
<table width="100%" align="center">

<tr>
 <td>Description</td>
      <td><textarea name="invoiceDes" cols="75" rows="5"></textarea></td>
</tr>
<tr>
 <td>Compansation Amount</td><td><input type="text" name="subInvoice" class="number" 
 onBlur="tax.value=(this.value*<? echo $taxp?>)/100;vat.value=(this.value*<? echo $vatp?>)/100;
 invoiceAmount.value=subInvoice.value-tax.value-vat.value">  Tk. </td>
</tr>

<tr>
 <td>Tax on Amount (<font class="out"><? echo $taxp;?>%</font>)</td><td><input type="text" name="tax" readonly="" class="number">  Tk. </td>
</tr><tr>
 <td>VAT on Amount (<font class="out"><? echo $vatp;?>%</font>)</td><td><input type="text" name="vat" readonly="" class="number">  Tk. </td>
</tr>
<tr>
 <td>Total Invoice Amount</td><td><input type="text" name="invoiceAmount" readonly="" class="number">  Tk. </td>
</tr>
<tr>
 <td colspan="2" align="center"><input type="button" name="save" value="Invoice Raised" 
 onClick="if(checkrequired(invoice)) {invoice.ck.value=1;invoice.submit();}">
 <input type="hidden" name="ck"  value="0">
 <input type="hidden" name="project"  value="<? echo $selectedPcode;?>">
 <input type="hidden" name="invoiceType"  value="<? echo $invoiceType;?>">  
 </td> 
</tr>
</table>
</div>

<?  } else if($invoiceType==2){?>
<table width="100%" border="1" bordercolor="#999999" cellpadding="0"  cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#DDDDDD">
  <th> IOW CODE</th>
  <th> Description</th>  
  <th> Total Qty</th>    
  <th colspan="2" width="20%"> Work Completed</th>    
  <th width="10%"> Invoice Raised </th>    
  <th> Current Invoice </th>      
  <th> Rate</th>    
  <th width="150"> Amount</th>    
</tr>
<tr>
  <th>&nbsp;</th>
  <th>&nbsp;</th>  
  <th>&nbsp;</th>    
  <th>Qty</th>    
  <th>%</th>
  <th>Qty</th>    
  <th>Qty</th>      
  <th>&nbsp;</th>    
  <th width="150">&nbsp;</th>    
</tr>
<?

include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);
	


if($selectedPcode) {
/*
 $sql = "SELECT * from `iow` WHERE 1
 AND iowProjectCode= '$selectedPcode' 
 AND iowType='1' AND iowStatus LIKE '%Approve%' 
 ORDER by iowId ASC";
*/
 
$sql = "SELECT * from `iow` WHERE 
  iowProjectCode= '$selectedPcode' 
 AND iowType='1' and iowStatus!='noStatus'  ORDER by iowId ASC";

} 
// echo $sql;
$sqlrunp= mysqli_query($db, $sql);
$i=1;
$amount=0;
while($iow=mysqli_fetch_array($sqlrunp)){

?>
<tr>
  <td bgcolor="#eeeeee" style="padding-right:5px;padding-left:2px;"> <? echo $iow[iowCode];?>
   <input type="hidden" name="iowId<? echo $i?>" value="<? echo $iow[iowId];?>">  </td>
  <td width="20%" style="padding-right:5px"> <? echo $iow[iowDes];?></td>
  <td align="right" width="10%" style="padding-right:5px"> <? 
  if($iow[iowUnit]!='L.S' AND $iow[iowUnit]!='LS' AND $iow[iowUnit]!='l.s' AND $iow[iowUnit]!='l.s')   
   {echo $iow[iowQty];
   $unitRate=$iow[iowPrice];
   }
   else {$unitRate=$iow[iowPrice]/100;}?>
    <? echo $iow[iowUnit];?></td>
  <td align="right" style="padding-right:5px"> <? 
  $ed=$todat;
		$workqty=iowActualProgressnew($iow[iowId],$iow[iowProjectCode],$ed,$iow[iowQty],$iow[iowUnit],0);
		echo number_format($workqty,2);
	
  //  echo invoicedQty($iow[iowId]);?></td>    
  
  <td align="right" style="padding-right:5px"><? 
  $ed=$todat;
		echo iowActualProgressP($iow[iowId],$iow[iowProjectCode],$ed,$iow[iowQty],$iow[iowUnit],0);
	
  //  echo invoicedQty($iow[iowId]);?></td>
  <td align="right" style="padding-right:5px"> <? 
   $invoicedQty=invoicedQty($iow[iowId]);
  echo number_format($invoicedQty);
  
  //$invoiceRemQty=invoiceRemQty($iow[iowId],$iow[iowQty],$iow[iowUnit]); //stop by salma
  $invoiceRemQty = $workqty-$invoicedQty;
//print $invoiceRemQty;
  ?>
    <?
	  if($iow[iowUnit]!='L.S' AND $iow[iowUnit]!='LS' AND $iow[iowUnit]!='l.s' AND $iow[iowUnit]!='l.s')   
	 echo $iow[iowUnit];
	 else
	print '<font class=out>%</font>';
	 ?>  
	 </td>      
  <td align="center" style="padding-right:5px;padding-left:5px"> 
  <!--<input type="text" name="currentQty<? echo $i;?>" value="<? echo ${currentQty.$i};?>" size="10" width="10"
   onBlur="if(this.value><? echo invoiceRemQty($iow[iowId],$iow[iowQty],$iow[iowUnit])?>) {alert('your invoice qty exceed remaining Qty!!'); this.value='';}"></td>    
  -->
<input type="text" name="currentQty<? echo $i;?>" value="<? if($ck==0)echo ${currentQty.$i};?>" class="right"
   onchange="if(this.value ><? echo $invoiceRemQty;?>) {alert('your invoice qty exceed remaining Qty!!'); this.value='';}"></td>    

  <td align="right" style="padding-right:5px"> <? echo number_format($iow[iowPrice],2);?>
   <input type="hidden" name="rate<? echo $i;?>" value="<? echo $unitRate;?>">  </td>
  <td align="right" style="padding-right:5px"> <? 
  $amount=${currentQty.$i}*$unitRate;
  echo number_format($amount,2);?></td>    
</tr>
<? $i++;
$subAmount=$subAmount+$amount;

$subAmount=round($subAmount,2);
}?>
<tr bgcolor="#FFFFD2" >
 <td align="right" colspan="8" >Sub Total</td>
<td align="right"><? echo number_format($subAmount,2);?> 
<input type="hidden" name="subInvoice" value="<? echo round($subAmount,2);?>"></td>
</tr>
<? 
$sqladv="SELECT * FROM invoice where invoiceStatus='2' AND invoiceType='1' AND invoiceLocation='$selectedPcode' ORDER by inId ASC";
//echo "$sqladv<br>";
$sqlqadv=mysqli_query($db, $sqladv);
$a=1;
while($r=mysqli_fetch_array($sqlqadv)){
$advanceAdjp==0;
$advanceAdjp=$r[advanceAdj];
$advAmount=$r[invoiceAmount];

$invoiceAdv_remain=invoiceAdv_remain($r[invoiceNo],$advAmount);
if($invoiceAdv_remain<=0) continue;
?>
<tr bgcolor="#FFFFD2" >
 <td align="right" colspan="8" >Advance Adjustment 
<!-- 	 <? echo  $advanceAdjp;?>% -->
	</td>
 <td align="right">
<!--  <? 
	//$advanceAdjTemp=($subAmount*$advanceAdjp)/100; 
  if($advanceAdjTemp>$invoiceAdv_remain)$advanceAdjTemp=$invoiceAdv_remain;
 $advanceAdjTemp=round($advanceAdjTemp,2);
 echo '<font class=out>('.number_format($advanceAdjTemp,2).'</font>';
 $advanceAdj+=$advanceAdjTemp;
 ?> -->
 <input type="number" style="text-align:right" name="advanceAdj<? echo $a;?>" value="<? echo round($advanceAdjTemp,2);?>">
 <input type="hidden" name="advanceAdjInv<? echo $a;?>" value="<? echo $r[invoiceNo];?>"> </td>
</tr>
<? $a++;}//while?>
<tr bgcolor="#FFFFD2" >
      <td align="right" colspan="8" >Retaintion Adjustment 
<!-- 				<? echo  $retentionp;?>% -->
	</td>
 <td align="right">
<!-- 	 <? 
	//$retention=($subAmount*$retentionp)/100; 
 //$retention=round($retention,2);
 echo '<font class=out>('.number_format($retention,2).')</font>';?> -->
 <input type="number" style="text-align:right" name="retention" value="<? echo round($retention,2);?>"> </td>
</tr>
<tr bgcolor="#FFFFEE" >
 <td align="right" colspan="8" height="30" >Total</td>
 <td align="right">
<!-- 	 <? 
 $totalInvoice=$subAmount-($advanceAdj+$retention);
 $totalInvoice=round($totalInvoice,2);
 echo number_format($totalInvoice,2);?> -->
 <input type="number" style="text-align:right" name="totalInvoice" value="<? echo round($totalInvoice,2);?>"> </td>
</tr>

<tr bgcolor="#FFFFD2" >
      <td align="right" colspan="8" >Tax on total 
<!-- 				<? echo $taxp;?>% -->
	</td>
 <td align="right">
<!-- 	 <? //$tax=($totalInvoice*$taxp)/100; $tax=round($tax,2); 
 echo '<font class=out>('.number_format($tax,2).')</font>';?> -->
 <input type="number" style="text-align:right" name="tax" value="<? echo round($tax,2);?>"> </td>
</tr>
<tr bgcolor="#FFFFD2" >
 <td align="right" colspan="8" >VAT on total  
<!-- 	 <? echo $vatp;?>% -->
	</td>
  <td align="right">
<!-- 		<? 
	//$vat=($totalInvoice*$vatp)/100; $vat=round($vat,2);
  echo '<font class=out>('.number_format($vat,2).')</font>';?> -->
 <input type="number" name="vat" style="text-align:right" value="<? echo round($vat,2);?>"> </td>
</tr>
<tr bgcolor="#EEFFEE" >
 <td align="right" colspan="8" height="30" >Grand Total</td>
 <td align="right">
<!-- 	 <? 
 $invoiceAmount=$totalInvoice-($tax+$vat);
 $invoiceAmount=round($invoiceAmount,2);
 echo number_format($invoiceAmount,2);?> -->
 <input type="number" style="text-align:right" name="invoiceAmount" value="<? echo round($invoiceAmount,2);?>"> </td>
</tr>

 <td colspan="5" align="center"><input type="button" name="save" value="Invoice Raised" 
 onClick="if(checkrequired(invoice)) {invoice.ck.value=1;invoice.submit();}">
 <input type="hidden" name="ck"  value="0">
 <input type="hidden" name="project"  value="<? echo $selectedPcode;?>">
 <input type="hidden" name="invoiceType"  value="<? echo $invoiceType;?>"> 
 <input type="hidden" name="totaladvanceAdj"  value="<? echo $advanceAdj;?>">  
<input type="hidden" name="n" value="<? echo $i;?>">
        <input type="hidden" name="a" value="<? echo $a;?>"> </td> 
 <td colspan="4" align="center"><input type="button" name="calculate" value="Calculate" onClick="invoice.submit();"></td>
 <td align="right" colspan="2"></td>
</tr>
</table>
<table>
  <tr> 
    <td>Sales Code:</td>
	<td>6100000 INCOME FROM COMPLETED JOBS</td>
  </tr>
  <tr> 
    <td>Accounts Receivable Code:</td>
	<td>5000000 SUNDRY DEBTORS</td>
  </tr>

</table>
</div>
<? } else if($invoiceType==3){?>
<table width="100%" border="1" bordercolor="#999999" cellpadding="0"  cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#DDDDDD">
  <th> IOW CODE</th>
  <th> Description</th>  
  <th> Total Qty</th>    
  <th colspan="2" width="20%"> Work Completed</th>    
  <th> Invoice Raised</th>    
  <th> Current Invoice </th>      
  <th> Rate</th>    
  <th width="150"> Amount</th>    
</tr>
<tr>
  <th>&nbsp;</th>
  <th>&nbsp;</th>  
  <th>&nbsp;</th>    
  <th>Qty</th>    
  <th>%</th>
  <th>Qty</th>    
  <th>Qty</th>      
  <th>&nbsp;</th>    
  <th width="150">&nbsp;</th>    
</tr>
<?

include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);
	


if($selectedPcode) {
/*
$sql = "SELECT * from `iow` WHERE 
  iowProjectCode= '$selectedPcode' 
 AND iowType='1' AND iowStatus LIKE '%Approve%' 
 ORDER by iowId ASC";
 */
 

$sql = "SELECT * from `iow` WHERE 
  iowProjectCode= '$selectedPcode' and iowStatus!='noStatus'  
 AND iowType='1' ORDER by iowId ASC";
 
} 
//echo $sql;
$sqlrunp= mysqli_query($db, $sql);
$i=1;
while($iow=mysqli_fetch_array($sqlrunp)){

?>
<tr>
  <td bgcolor="#eeeeee" style="padding-right:5px;padding-left:2px;"> <? echo $iow[iowCode];?>
   <input type="hidden" name="iowId<? echo $i?>" value="<? echo $iow[iowId];?>">  </td>
  <td width="20%" style="padding-right:5px"> <? echo $iow[iowDes];?></td>
  <td align="right" width="10%" style="padding-right:5px"> <? 
  if($iow[iowUnit]!='L.S' AND $iow[iowUnit]!='LS' AND $iow[iowUnit]!='l.s' AND $iow[iowUnit]!='l.s')   
   {echo $iow[iowQty];
   $unitRate=$iow[iowPrice];
   }
   else {$unitRate=$iow[iowPrice]/100;}?>
    <? echo $iow[iowUnit];?></td>
  <td align="right" style="padding-right:5px"> <? 
  $ed=$todat;
		echo iowActualProgressnew($iow[iowId],$iow[iowProjectCode],$ed,$iow[iowQty],$iow[iowUnit],0);
	
  //  echo invoicedQty($iow[iowId]);?></td>    
  <td align="right" style="padding-right:5px"><? 
  $ed=$todat;
		echo iowActualProgressP($iow[iowId],$iow[iowProjectCode],$ed,$iow[iowQty],$iow[iowUnit],0);
	
  //  echo invoicedQty($iow[iowId]);?></td>
  <td align="right" style="padding-right:5px"> <? 
   $invoicedQty=invoicedQty($iow[iowId]);
  echo $invoicedQty;
  $invoiceRemQty=invoiceRemQty($iow[iowId],$iow[iowQty],$iow[iowUnit]);
  ?></td>      
  <td align="center" style="padding-left:5px; padding-right:5px;"> 
  <!--<input type="text" name="currentQty<? echo $i;?>" value="<? echo ${currentQty.$i};?>" size="10" width="10"
   onBlur="if(this.value><? echo invoiceRemQty($iow[iowId],$iow[iowQty],$iow[iowUnit])?>) {alert('your invoice qty exceed remaining Qty!!'); this.value='';}"></td>    
  -->
<input type="text" name="currentQty<? echo $i;?>" value="<? if($ck==0)echo ${currentQty.$i};?>" size="10" width="10" class="right"
   onChange="if(this.value><? echo $invoiceRemQty;?>) {alert('your invoice qty exceed remaining Qty!!'); this.value='';}"></td>    

  <td align="right" style="padding-right:5px"> <? echo number_format($iow[iowPrice],2);?>
   <input type="hidden" name="rate<? echo $i;?>" value="<? echo $unitRate;?>">  </td>
  <td align="right" style="padding-right:5px"> <? 
  $amount=${currentQty.$i}*$unitRate;
  echo number_format($amount,2);?></td>    
</tr>
<? $i++;
$subAmount=$subAmount+$amount;
$amount=0;
}?>
<tr bgcolor="#FFFFD2" >
 <td align="right" colspan="8" >Sub total 1</td>
<td align="right"><? echo number_format($subAmount,2);?> 
<input type="hidden" name="subInvoice" value="<? echo round($subAmount,2);?>"></td>
</tr>
<? 
$sqladv="SELECT * FROM invoice where invoiceStatus='2' AND invoiceType='1' AND invoiceLocation='$selectedPcode' ORDER by inId ASC";
//echo "$sqladv<br>";
$sqlqadv=mysqli_query($db, $sqladv);
$a=1;
while($r=mysqli_fetch_array($sqlqadv)){
$advanceAdjp==0;
$advanceAdjp=$r[advanceAdj];
$advAmount=$r[invoiceAmount];

$invoiceAdv_remain=invoiceAdv_remain($r[invoiceNo],$advAmount);
if($invoiceAdv_remain<=0) continue;
?>
<tr bgcolor="#FFFFD2" >
 <td align="right" colspan="8" >Advance Adjustment <? echo  $advanceAdjp;?>%</td>
 <td align="right">
 <? $advanceAdjTemp=($subAmount*$advanceAdjp)/100; 
  if($advanceAdjTemp>$invoiceAdv_remain)$advanceAdjTemp=$invoiceAdv_remain;
 echo "<font class=out>(".number_format($advanceAdjTemp,2).')</font>';
 $advanceAdj+=$advanceAdjTemp;
 ?>
 <input type="hidden" name="advanceAdj<? echo $a;?>" value="<? echo round($advanceAdjTemp,2);?>">
 <input type="hidden" name="advanceAdjInv<? echo $a;?>" value="<? echo $r[invoiceNo];?>"> </td>
</tr>
<? $a++;}//while?>
<tr bgcolor="#FFFFD2" >
 <td align="right" colspan="8" >Retention Adjustment  <? echo  $retentionp;?>%</td>
 <td align="right"><? $retention=($subAmount*$retentionp)/100; echo number_format($retention,2);?>
 <input type="hidden" name="retention" value="<? echo round($retention,2);?>"> </td>
</tr>

<tr bgcolor="#FFFFD2" >
 <td align="right" colspan="8" >Tax on subtotal  <? echo $taxp;?>%</td>
 <td align="right"><? $tax=($subAmount*$taxp)/100; echo number_format($tax,2);?>
 <input type="hidden" name="tax" value="<? echo round($tax,2);?>"> </td>
</tr>
<tr bgcolor="#FFFFD2" >
 <td align="right" colspan="8" >VAT on subtotal  <? echo $vatp;?>%</td>
  <td align="right"><? $vat=($subAmount*$vatp)/100; echo number_format($vat,2);?>
 <input type="hidden" name="vat" value="<? echo round($vat,2);?>"> </td>
</tr>
<tr bgcolor="#FFFFEE" >
 <td align="right" colspan="8" height="30" >Grand Total</td>
 <td align="right"><? 
 $invoiceAmount=$subAmount-($advanceAdj+$retention+$tax+$vat);
 echo number_format($invoiceAmount,2);?>
 <input type="hidden" name="invoiceAmount" value="<? echo round($invoiceAmount,2);?>"> </td>
</tr>

 <td colspan="5" align="center"><input type="button" name="save" value="Invoice Raised" 
 onClick="if(checkrequired(invoice)) {invoice.ck.value=1;invoice.submit();}">
 <input type="hidden" name="ck"  value="0">
 <input type="hidden" name="project"  value="<? echo $selectedPcode;?>">
 <input type="hidden" name="invoiceType"  value="<? echo $invoiceType;?>"> 
 <input type="hidden" name="totaladvanceAdj"  value="<? echo $advanceAdj;?>">  
<input type="hidden" name="n" value="<? echo $i;?>">
        <input type="hidden" name="a" value="<? echo $a;?>"> </td> 
 <td colspan="4" align="center"><input type="button" name="calculate" value="Calculate" onClick="invoice.submit();"></td>
 <td align="right" colspan="2"></td>
</tr>
</table>
<br><br>



<br><br>
<table>
  <tr> 
    <td>Sales Code:</td>
	<td>6100000 INCOME FROM COMPLETED JOBS</td>
  </tr>
  <tr> 
    <td>Accounts Receivable Code:</td>
	<td>5000000 SUNDRY DEBTORS</td>
  </tr>

</table>
</div>
<? }?>
</form>
	  <? }//if selectedPcode?>
<div id=testdiv1
      style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
	  

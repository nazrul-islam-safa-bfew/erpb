
<script language="JavaScript1.2">
function formCheck(ch){
if(ch) {
if (confirm("Are you sure ?")) {
alert ("Ok, your data are going to save ");
return true;
}
else {
alert ("hmm..");
return false;
   }

}
 else { alert( 'please click on check box for save your data');return false;}
}
</script>

<table align="center" width="50%" border="0" cellpadding="0" cellspacing="0">
<tr>
  <td>Short by:</td>
  <? if($op==1) $c2='checked'; else $c1='checked';?>
  <td><input type="radio" name="op" <? echo $c1;?>>Item Code</td>
  <td><input type="radio" name="op" <? echo $c2;?>>IOW</td>    
</tr>
</table>
<form name="fundAllocate" action="./managingDirector/sqlSubmit.php" method="post" onSubmit="return formCheck(this.chk.checked);">
<? 
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 


$sqlp22 = "SELECT distinct `reqpCode` from `requisition`  ORDER BY `reqpCode`";
//echo $sqlp;
$sqlrunp22= mysqli_query($db, $sqlp22);

 while($dmaRun22= mysqli_fetch_array($sqlrunp22)){
?>
  <table  align="center" width="98%" border="1" bordercolor="#CCCCCC" cellspacing="1" cellpadding="0"  style="border-collapse:collapse" >
    <tr> 
      <td bgcolor="#DDDDDD" height="25"  colspan="9"  >Project Name: <? echo $dmaRun22[reqpCode];?></td>
    </tr>

<? 
$sqlp = "SELECT `*` from `requisition` WHERE reqpCode='$dmaRun22[reqpCode]' AND reqQty <> 0 ORDER BY `reqItemCode`";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
$i=1; $j=0; 
 while($dmaRun= mysqli_fetch_array($sqlrunp)){
 
 $tiow=explode("+", $dmaRun[reqIow]);
 
 ?>

<? $sqlItem = "SELECT itemlist.*, itemrate.*, dma.* from `itemlist`,`itemrate`,`dma` where itemCode='$dmaRun[reqItemCode]' AND rateItemCode='$dmaRun[reqItemCode]' AND dmaItemCode='$dmaRun[reqItemCode]' AND dmasiow LIKE '$tiow[1]' AND dmaiow LIKE '$tiow[0]'";
//echo $sqlItem;
$sqlrunItem= mysqli_query($db, $sqlItem);
$itemResult=mysqli_fetch_array($sqlrunItem);
?>

<? if($pre!=$dmaRun[reqItemCode]){?>


<? if($i!=1){?>
    <tr bgcolor="#FFCC99"> 
      <td colspan="4" bgcolor="#FFCC99"  height="30" align="right">Sub Total: </td>
      <td height="30" align="right"><? echo $subTotal;  $subTotal=0;?></td>

	  <td align="right"><input type="text" name="subqty<? echo $j;?>" value="0" size="10" style="text-align : right; border:0; background:#FFCC99;" readonly></td>
	  <td colspan="1"></td>	  
	  <td align="right"><input type="text" name="sub<? echo $j;?>" value="0" size="10" style="text-align : right; border:0; background:#FFCC99;" readonly></td>
	  <td colspan="1"></td>	  
    </tr>
    <tr> 
      <td colspan="9" bgcolor="#FFFFFF"  height="20"></td>
    </tr>

<? $j++;}?>
    <tr> 
      <td colspan="9" bgcolor="#CCFF99" height="20">Item Code:<? echo "$dmaRun[reqItemCode]( $itemResult[itemDes], $itemResult[itemSpec])";?> </td>
    </tr>

    <tr bgcolor="#EEEEEE"> 
      <td >IOW Code</td>
	  <td align="center"> Unit</td>
	  <td align="center"> Approved</td>
	  <td align="center"> Purchased</td>
	  <td align="center"> Current Req.</td>
	  <td align="center"> Fund Allocate for qty</td>
	  <td align="center"> Rate</td>
	  <td align="center">Amount (Tk.)</td>
	  <td align="center">Purchase Location: </td>	  
	  </tr>

<? }?>	  

    <tr > 
      <td ><a href="./managingDirector/mdIOW.php?reqpCode=<? echo $dmaRun22[reqpCode];?>&iow=<? echo $dmaRun[reqIow];?>" target="_blank"><? echo $dmaRun[reqIow];?></a></td>
	  <td align="right"> <? echo $itemResult[itemUnit];?></td>
	  <td align="right"> <? echo $itemResult[dmaQty];?></td>
	  <td align="right"> <? echo $dmaRun[reqActQty];?></td>
	  <td align="right"> <? echo $dmaRun[reqQty];?></td>
	  <td align="right"> <input type="text" name="fund<? echo $i;?>" size="10" value="0" style="text-align : right;" onClick="if(fundAllocate.cl.value=='true' ){subqty<? echo $j;?>.value=subMe(fundAllocate, <? echo 'subqty'.$j;?>.value,<? echo 'fund'.$i;?>.value); sub<? echo $j;?>.value=subMe(fundAllocate, <? echo 'sub'.$j;?>.value, <? echo 'total'.$i;?>.value);} fundAllocate.cl.value='false'; " 
	    onBlur="if(<? echo 'fund'.$i;?>.value > <? echo $dmaRun[reqQty]?>) {alert('your funded qty is more'); <? echo 'fund'.$i;?>.value=0;}<? echo 'total'.$i;?>.value=multipleMe(fundAllocate,<? echo 'fund'.$i;?>.value,<? echo $itemResult[rate]?>); sub<? echo $j;?>.value=addMe(fundAllocate, <? echo 'total'.$i;?>.value, <? echo 'sub'.$j;?>.value); subqty<? echo $j;?>.value=addMe(fundAllocate, <? echo 'fund'.$i;?>.value, <? echo 'subqty'.$j;?>.value); fundAllocate.cl.value='true';"> 
        <input type="hidden" name="reqQty<? echo $i;?>" value="<? echo $dmaRun[reqQty];?>">
		  <input type="hidden" name="reqId<? echo $i;?>" value="<? echo $dmaRun[reqId];?>"> </td>
	
	  <td align="right"> <? echo number_format($itemResult[rate],2);?></td>
	  <td><input type="text" name="total<? echo $i;?>" readonly="readonly" maxlength="10" size="10" value="0" style="text-align : right; border:0; background:#FFFFFF;"></td>
	  <td>	  <? if($dmaRun[reqLoc]=='Local') $l2='checked'; else $l1='checked';?>
	  <input type="radio" <? echo $l1;?>  value="HO" name="reqLoc<? echo $i;?>"> HO <input type="radio" <? echo $l2;?> value="Local" name="reqLoc<? echo $i;?>"> PO <input type="radio" <? echo $l2;?> value="Local" name="reqLoc<? echo $i;?>"> Vendor 
	  </td></tr>

<? $pre=$dmaRun[reqItemCode]; $subTotal+=$dmaRun[reqQty];?>
<? $i++; }?>
    <tr bgcolor="#FFCC99"> 
      <td colspan="4" bgcolor="#FFCC99"  height="30" align="right">Sub Total: </td>
      <td height="30" align="right"><? echo $subTotal;  $subTotal=0;?></td>
	  <td align="right"><input type="text" name="subqty<? echo $j;?>" value="0" size="10" style="text-align : right; border:0; background:#FFCC99;" readonly></td>
	  <td colspan="1"></td>	  
	  <td align="right"><input type="text" name="sub<? echo $j;?>" value="0" size="10" style="text-align : right; border:0; background:#FFCC99;" readonly></td>
	  <td colspan="1"></td>	  
    </tr>
    <tr> 
      <td colspan="9" bgcolor="#FFFFFF"  height="20"></td>
    </tr>

  </table>
<? }?>
<input type="hidden" name="rowNo" value="<? echo $i;?>">
if want to save please check it <input type="checkbox" name="chk" >
<input type="submit" name="savefund" value="Save" >
<input type="hidden" name="cl" value="true">

</form>

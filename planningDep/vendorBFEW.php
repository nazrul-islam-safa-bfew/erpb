<? 
session_start();
$loginDesignation = $_SESSION['loginDesignation'];
include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
if($itemCode >'50-00-000' AND $itemCode <'70-00-000')
$sqlv = "SELECT * from `vendor` WHERE vid='85' ";
elseif($itemCode >'00-00-000' AND $itemCode <'50-00-000')
 $sqlv = "SELECT * from `vendor` WHERE vid='99' ";

//echo '**************'.$sqlv.'*************************';
	$sqlrunq= mysqli_query($db,$sqlv);

$vendor= mysqli_fetch_array($sqlrunq);
?>

<table align="center" width="98%"   border="2" bordercolor="#E8E8E8" cellspacing="0" cellpadding="0" style="border-collapse:collapse">

 <tr>
  <td  colspan="8">
    <table align="center" width="100%"   border="1" bordercolor="#E8E8E8" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
     <tr>
	  <td colspan="2">
   		<table width="100%"  cellpadding="3" cellspacing="0" style="border-collapse:collapse">
	     <tr bgcolor="#EEEEEE">
		  <TD width="100%"  >Vendore Name: <a class="hd" href="./index.php?keyword=vendor&vid=<? echo $vendor[vid];?>"> <? echo $vendor[vname];?></a></TD>
		  <TD width="200" align="right">
			  <table  width="250" border="2" bgcolor="#FFFFFF" bordercolor="#FF0000" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
    			<tr><td align="center">Vendor Rating: <font color="#FF0000" size="+2"><? echo $vendor[point];?> </font>Points
				<a href="<? echo $vendor[att];?>"><img src="./images/pdf_icon.jpg" width="30" height="30" border="0" ></a>
				</td></tr>
			   </table>

		  </TD>
	 	</tr>
   	   </table>
     </td>
    </TR>
	 <TR >
	  <TD colspan="2" >Address :<font class="out"><? echo $vendor[address];?></font></TD>

	 </TR>

	 <TR>
	  <TD colspan="2" >Contact Name: <font class="out"><? echo $vendor[contactName];?></font> , <font class="out"><? echo $vendor[designation];?></font> , <font class="out"><? echo $vendor[mobile];?></font></TD>
	 </TR>
	 <TR>
	  <TD >Accounts Information: <font class="out"><? echo $vendor[accInfo];?></font></TD>
	 </TR>
	 <TR>
	  <TD width="50%" >Vendor Type: <font class="out"><? echo vendorRating($vendor[type],1);?></font></TD>
	  <TD  width="50%">Quality Image: <font class="out"><? echo vendorRating($vendor[quality],2);?></font></TD>
	 </TR>
	 <TR>
	  <TD >Reliability: <font class="out"><? echo vendorRating($vendor[reliability],2);?></font>

		  <? if($vendor[reliabilityText]){?><br><font class="outi"><? echo $vendor[reliabilityText];?></font><? }?>
		</TD>
	  <TD >Availability: <font class="out"><? echo vendorRating($vendor[availability],2);?></font>
		  <? if($vendor[availabilityText]){?><br><font class="outi"><? echo $vendor[availabilityText];?></font><? }?>
	  </TD>
	 </TR>
	 <TR>
	  <TD >Experience in the market: <font class="out"><? echo vendorRating($vendor[experienceM],3);?></font>
		  <? if($vendor[experienceMText]){?><br><font class="outi"><? echo $vendor[experienceMText];?></font><? }?></TD>
	  <TD >Experience with BFEW: <font class="out"><? echo vendorRating($vendor[experienceB],3);?></font>
		  <? if($vendor[experienceBText]){?><br><font class="outi"><? echo $vendor[experienceBText];?></font><? }?></TD>
	 </TR>
	 <TR>
	  <TD >After Sales service: <font class="out"><? echo vendorRating($vendor[service],2);?></font>
		  <? if($vendor[serviceText]){?><br><font class="outi"><? echo $vendor[serviceText];?></font><? }?></TD>
	  <TD >Advance Required: <font class="out"><? echo vendorRating($vendor[advance],4);?></font></TD>
	 </TR>
	 <TR>
	  <TD colspan="2" >Credit Facility: <font class="out"><? echo vendorRating($vendor[cfacility],4);?></font>; </TD>
	 </TR>
	</table>
   </td>
 </tr>
        <tr bgcolor="#EEEEFF">
          <td align="center" height="30" width="10%" > Project</td>
          <td align="center" > Item</td>
          <td align="center" > Description</td>
          <td align="center" > Delivery Details</td>
          <td align="center" > Rate </td>
          <td align="center" > Unit</td>		  
          <td align="center" > Quotation Ref.</td>
          <td align="center" > Valid Till</td>
</TR>
<? 
if($itemCode >'50-00-000'){
//$sqlv = "SELECT equipment.itemCode, equipment.assetId,MAX((((price-salvageValue)/life)/365)*days) as rate,itemlist.* from `equipment`, itemlist".
//" WHERE equipment.itemCode= itemlist.itemCode AND equipment.itemCode='$itemCode' GROUP by equipment.itemCode";

//new rule from 13_january_14

    $sqlv = "SELECT equipment.itemCode, equipment.assetId,MAX((((((price-salvageValue)/life)/12)*days)/240)*hours) as rate,itemlist.* from `equipment`, itemlist".
" WHERE equipment.itemCode= itemlist.itemCode AND equipment.itemCode='$itemCode' GROUP by equipment.itemCode";
    
    
//$sqlv = "SELECT equipment.assetId, equipment.itemCode,MAX(((((price-salvageValue)/life)/days)*3)/30) as rate,itemlist.* from `equipment`, itemlist WHERE equipment.itemCode= itemlist.itemCode ";
//$sqlv.= " GROUP by equipment.itemCode ORDER BY equipment.itemCode ASC";

}
else {
$sqlv = "SELECT store.itemCode, avg(store.rate) as rate,itemlist.* from `store`, itemlist".
" WHERE store.itemCode= itemlist.itemCode  GROUP by store.itemCode";
}

// echo $sqlv;
$sqlrunq= mysqli_query($db,$sqlv);

while($store= mysqli_fetch_array($sqlrunq)){
?>
<TR>
          <td align="center" width="10%" > <? echo '000';?></td>
          <td align="center" width="10%" > <? 
		  
  if($itemCode<'50-00-000'){
  $unit=$store[itemUnit];
  if($loginDesignation=='Managing Director')
echo $store[itemCode];
else
 {
	  ?>
	  <a href="./index.php?keyword=purchase+order&vid=99&project=<? echo $project;?>&itemCode=<? echo $store[itemCode];?>&dmatotal=<?php echo $dmaTotal;?>&pototal=<? echo $poTotal;?> "><? echo $store[itemCode];?></a>
	  <? 
	  }
	  }//itemCode
	  else if($itemCode>'50-00-000') {
	    $unit='day';
		if($loginDesignation=='Managing Director')
		echo $store[itemCode];
		else
		{
	  ?>
	  <a href="./index.php?keyword=eqpurchase+order&vid=85&project=<? echo $project;?>&itemCode=<? echo $store[itemCode];?>&dmatotal=<?php echo $dmaTotal;?>&pototal=<? echo $poTotal;?> "><? echo $store[itemCode];?></a>
	  <?  
	  }
	  } ?>
	  </td>
          <td align="left" width="20%" > <? echo $store[itemDes].', '.$store[itemSpec];?></td>
          <td align="left" width="20%" ><? echo "from Equipment Section";?></td>
          <td  align="right" width="10%" > <? echo number_format($store[rate],2);?></td>
          <td  align="center" width="10%" > <? echo $unit;?></td>
          <td align="center" width="10%" > </td>
           <td align="center" width="12%" > </td>

</TR>

<?  }?>
 </table>

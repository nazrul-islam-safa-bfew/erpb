<html>
<head>

<script language="JavaScript">
<!--
// Add the selected items in the parent by calling method of parent
function addSelectedItemsToParent() {

 //alert(radio_form.ch.length);
for (counter = 0; counter < radio_form.ch.length; counter++)
{
if (radio_form.ch[counter].checked)
{
//alert(radio_form.ch[counter].value);
radio_choice = radio_form.ch[counter].value; 

if(radio_form.ra[counter].checked) radio_rate = radio_form.ra[counter].value; 
else if(radio_form.ra[counter+1].checked) radio_rate = radio_form.ra[counter+1].value; 
}
}
//alert(radio_rate);
self.opener.addToParentList(radio_choice,radio_rate);
window.close();

}

// End -->
</SCRIPT>
</head>
<body>

<? 
function value($v,$t){
	if($t=='1'){
	if($v=='5') $out='Sole Importer / Distributor';
	else if($v=='4') $out='Manufacturer';
	else if($v=='3') $out='Wholesaler';
	else if($v=='2') $out='Local Vendor';
	else if($v=='1') $out='Importer';
	else if($v=='0') $out='Retailer';
	}
	if($t=='2'){
	if($v=='5') $out='Outstanding';
	else if($v=='3') $out='Good';
	else if($v=='0') $out='Unknown';
	else if($v=='-2') $out='Unsatisfactory';
	}
	if($t=='3'){
	if($v=='5') $out='5 years above';
	else if($v=='3') $out='1 - 5 years';
	else if($v=='0') $out='Less then 1 years';
	else if($v=='-2') $out='NIL';	
	}
	if($t=='4'){
	if($v=='5') $out='Bill-to-Bill';
	else if($v=='4') $out='Yes';	
	else if($v=='0') $out='No';
	}

	return $out;
}
?>

<?  include_once('../managingDirector/mdvendorSearch.php');?>
<form method="POST" name="radio_form">
<?  include("../managingDirector/config.inc.php");
$db11 = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlv = "SELECT vendor.*, quotation.*,itemlist.* from `vendor`,`quotation`, itemlist WHERE quotation.vid=vendor.vid AND quotation.itemCode= itemlist.itemCode ";

if($vid) $sqlv .=" AND vendor.vid='$vid'";
if($project) $sqlv .=" AND pCode IN ('$project', '000')";
if($itemCode1 || $itemCode2 ||$itemCode3) $itemCode="$itemCode1-$itemCode2-$itemCode3";
if($itemCode) $sqlv .=" AND quotation.itemCode='$itemCode'";
$sqlv.= " ORDER BY vendor.vid";
//echo $sqlv;
$sqlrunq= mysqli_query($db, $sqlv);
$num_rows = mysql_num_rows($sqlrunq);
if($num_rows>1){
while($vendor= mysqli_fetch_array($sqlrunq)){

?>

<table align="center" width="98%"   border="2" bordercolor="#E8E8E8" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
<? if($pre!=$vendor[vname]){?>
<br>
 <tr>
  <td  colspan="8">
    <table align="center" width="100%"   border="1" bordercolor="#E8E8E8" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
     <tr>	 
	  <td colspan="2">
   		<table width="100%"  cellpadding="0" cellspacing="0" style="border-collapse:collapse">
	     <tr>
		  <TD width="100%"  ><input type="radio" name="ch" value="<? echo $vendor[vname];?>" > Vendore Name: <? echo $vendor[vname];?></TD>
		  <TD width="200" align="right">
			  <table  width="200" border="2" bgcolor="#FFFFFF" bordercolor="#FF0000" cellpadding="0" cellspacing="0" style="border-collapse:collapse"> 
    			<tr><td align="center">Vendor Rating: <font color="#FF0000" size="+2"><? echo $vendor[point];?> </font>Points</td></tr>
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
	  <TD colspan="2" >Accounts Information: <font class="out"><? echo $vendor[accInfo];?></font></TD>  
	 </TR>
	 <TR>
	  <TD width="50%" >Vendor Type: <font class="out"><? echo value($vendor[type],1);?></font></TD>  
	  <TD  width="50%">Quality Image: <font class="out"><? echo value($vendor[quality],2);?></font></TD>      
	 </TR>
	 <TR>
	  <TD >Reliability: <font class="out"><? echo value($vendor[reliability],2);?></font>
		  
		  <? if($vendor[reliabilityText]){?><br><font class="outi"><? echo $vendor[reliabilityText];?></font><? }?>
		</TD>  
	  <TD >Availability: <font class="out"><? echo value($vendor[availability],2);?></font>
		  <? if($vendor[availabilityText]){?><br><font class="outi"><? echo $vendor[availabilityText];?></font><? }?>
	  </TD>      
	 </TR>
	 <TR>
	  <TD >Experience in the market: <font class="out"><? echo value($vendor[experienceM],3);?></font>
		  <? if($vendor[experienceMText]){?><br><font class="outi"><? echo $vendor[experienceMText];?></font><? }?></TD>  
	  <TD >Experience with BFEW: <font class="out"><? echo value($vendor[experienceB],3);?></font>
		  <? if($vendor[experienceBText]){?><br><font class="outi"><? echo $vendor[experienceBText];?></font><? }?></TD>      
	 </TR>
	 <TR>
	  <TD >After Sales service: <font class="out"><? echo value($vendor[service],2);?></font>
		  <? if($vendor[serviceText]){?><br><font class="outi"><? echo $vendor[serviceText];?></font><? }?></TD>  
	  <TD >Advance Required: <font class="out"><? echo value($vendor[advance],4);?></font></TD>      
	 </TR>
	 <TR>
	  <TD colspan="2" >Credit Facility: <font class="out"><? echo value($vendor[cfacility],4);?></font>; 
	   Max. Credit Amount: Tk. <font class="out"><? echo number_format($vendor[camount],2);?></font>
		  Max. Credit Duration: <font class="out"><? echo $vendor[cduration];?></font> days</TD>      
	 </TR>
	</table>
   </td>
 </tr>
        <tr bgcolor="#EEEEFF"> 
          <td align="center" height="30" width="10%" > Project</td>
          <td align="center" > Item</td>
          <td align="center" > Description</td>
          <td align="center" > Supply Details</td>
          <td align="center" > Rate (Cash)</td>
          <td align="center" > Rate (Credit)</td>
          <td align="center" > Quotation Ref.</td>
          <td align="center" > Valid Till</td>
</TR>
 <? }?>	
<TR>
          <td align="center" width="10%" > <? echo $vendor[pCode];?></td>
          <td align="center" width="10%" > <? echo $vendor[itemCode];?></td>
          <td align="left" width="10%" > <? echo $vendor[itemDes].', '.$vendor[itemSpec];?></td>
          <td align="left" width="20%" > <? if($vendor[includeCar]=='Yes') echo 'Price include Carrying Cost; '; else echo 'Price exclude Carrying Cost; '; echo $vendor[sDetail];?></td>
          <td  align="right" width="10%" > <input type="radio" name="ra" value="<? echo $vendor[rate];?>"><? echo number_format($vendor[rate],2);?></td>
          <td align="right" width="10%" ><input type="radio" name="ra" value="<? echo $vendor[creRate];?>"> <? echo number_format($vendor[creRate],2);?></td>
          <td align="center" width="20%" > <? echo $vendor[qRef];?></td>
          <td align="center" width="10%" > <? echo date("d-m-Y",strtotime($vendor[valid]));?> 
            <a href="<? echo $vendor[att];?>"><img src="../images/pdf_icon.jpg" width="30" height="30" border="0" align="absbottom" ></a>              
          </td>
</TR>


 </table>
<? $pre=$vendor[vname];

}
}//if
else {echo "NO Option!!"; exit();}
?>
<input type="button" value="Done" onClick = "javascript:addSelectedItemsToParent()">
</form>
<br>
<? include("../vendor/pointChart.php");?>
</body>
</html>
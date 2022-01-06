<? 
include("../includes/session.inc.php");
include("../includes/config.inc.php");
include("../includes/myFunction.php");
include("../keys.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
?>

<html>
 <head>
 <LINK href="../style/print.css" type=text/css rel=stylesheet media="print">
<meta http-equiv="Content-Language" content="en-us">
<meta name="author" content="<? echo $mauthor;?>">
<meta name="copyright" content="<? echo $tt;?>">
<meta name="keywords" content="<? echo $kword;?>">
<META NAME="description" CONTENT="<? echo $des;?>">
<title>BFEW :: Print Vendor Details</title>
</head>
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


<!--<body   bgcolor="#FFFFFF" onLoad="window.print();" >-->
<body   bgcolor="#FFFFFF" onLoad="window.print();" >
<? $sqlv = "SELECT * from `vendor` WHERE vid='$vid' ";
//echo $sqlv;
	$sqlrunq= mysql_query($sqlv);

$vendor= mysql_fetch_array($sqlrunq);
?>
<table>
 <tr>
  <td>
     <table align="left" width="600"   border="2" bordercolor="#000000" cellspacing="0" cellpadding="5" style="border-collapse:collapse">
     <tr>
	  <td colspan="2">
   		<table width="100%"  cellpadding="3" cellspacing="0" style="border-collapse:collapse">
	     <tr bgcolor="#EEEEEE">
		  <TD width="100%"  >Vendore Name: <? echo $vendor[vname];?></TD>
		  <TD width="200" align="right">
			  <table  width="250" border="2" bgcolor="#FFFFFF" bordercolor="#FF0000" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
    			<tr><td align="center">Vendor Rating: <font color="#FF0000" size="+2"><? echo $vendor[point];?> </font>Points
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
	  <? if($vendor[cfacility]==4){?>
	   Max. Credit Amount: Tk. <font class="out"><? if(!empty($vendor[camount]))echo number_format($vendor[camount],2);else echo "0.00";?></font>
		  Max. Credit Duration: <font class="out"><? echo $vendor[cduration];?></font> days</TD>
		  <? }?>
	 </TR>
</table>
  </td>
 </tr>
<tr><td>
<table width="600" align="left" border="1" bordercolor="#000000" style="border-collapse:collapse">
        <tr bgcolor="#EEEEFF">
          <td align="center" height="30" width="10%" > Project</td>
          <td align="center" width="100"> Item</td>
          <td align="center" > Description</td>
          <td align="center" > Delivery Details</td>
          <td align="center" > <? if($vendor[cfacility]==0) echo "Rate (Cash)"; else echo "Rate (Credit)"; ?></td>
          <td align="center" > Unit</td>		  
          <td align="center" > Quotation Ref.</td>
          <td align="center" > Valid Till</td>
</TR>
<?
$sql= "SELECT quotation.*,itemlist.* FROM quotation,itemlist WHERE vid=$vid and quotation.itemCode=itemlist.itemCode";
$sqlq=mysql_query($sql);
while($qq=mysql_fetch_array($sqlq)){
?>
        <tr bgcolor="#FFFFFF">
          <td align="center" height="30" width="10%" > <? echo $qq[pCode]?></td>
          <td align="center" > <? echo $qq[itemCode]?></td>
          <td align="center" > <? echo $qq[itemDes]?></td>
          <td align="center" >		  <? if($qq[delivery]=='To') echo "To ".myprojectName($qq[deliveryLoc]).";" ; else echo "From $qq[deliveryLoc];"; ?>
		   <? echo $qq[sDetail];?></td>
          <td align="center" > <? echo number_format($qq[rate],2);?></td>
          <td align="center" > <? echo $qq[itemUnit]?></td>
          <td align="center" > <? echo $qq[qRef];?></td>
          <td align="center" > <? echo $qq[valid];?></td>
		</TR>


<? }
?>
</table>
  </td>
 </tr>
</table>

<input type="button" name="print" value="Print" onClick="window.print();" class="noPrint"  > 
</body>
</html>
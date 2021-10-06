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

<? include_once('vendorSearch.php');?>
<?  include("config.inc.php");
$db11 = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 
$sqlp11 = "SELECT * from `vendor` WHERE 1";
if($vid) $sqlp11 .=" AND vid='$vid'";

//echo $sqlp;
$sqlrunp11= mysqli_query($db, $sqlp11);

//$sqlrunp11= mysqli_query($db, $sq);

$total_result=mysqli_affected_rows();
$total_per_page=20;

if($page<=0)
	{
	$page=1;
	}
$curr=($page-1)*$total_per_page;

$sqlp11.=" LIMIT $curr,$total_per_page";
//echo $sqlp11;
	$sqlrunp11= mysqli_query($db, $sqlp11);



while($vendor= mysqli_fetch_array($sqlrunp11)){
?>

<table align="center" width="95%"   border="2" bordercolor="#E8E8E8" cellspacing="0" cellpadding="3" style="border-collapse:collapse">
 <TR bgcolor="#EEEEEE">
		  <TD width="50%"  >Vendore Name:<b> <? echo $vendor[vname];?></b></TD>
		  <TD  align="right">
			  <table  width="250" border="2" bgcolor="#FFFFFF" bordercolor="#FF0000" cellpadding="0" cellspacing="0" style="border-collapse:collapse"> 
    			<tr><td align="center">Vendor Rating: <font color="#FF0000" size="+2"><? echo $vendor[point];?> </font>Points 				
				<a href="<? echo $vendor[att];?>"><img src="./images/pdf_icon.jpg" width="30" height="30" border="0" ></a>
				</td></tr>
			   </table>
			   
		  </TD>        	 

 </TR>
 <TR >
  <TD colspan="2">Address :<font class="out"><? echo $vendor[address];?></font></TD>
 </TR>

 <TR>
  <TD colspan="2">Contact Name: <font class="out"><? echo $vendor[contactName];?></font> , <font class="out"><? echo $vendor[designation];?></font> , <font class="out"><? echo $vendor[mobile];?></font></TD>      
 </TR>
 <TR>
  <TD colspan="2" >Accounts Information: <font class="out"><? echo $vendor[accInfo];?></font></TD>  
 </TR>
 <TR>
  <TD>Vendor Type: <font class="out"><? echo value($vendor[type],1);?></font></TD>  
  <TD>Quality Image: <font class="out"><? echo value($vendor[quality],2);?></font></TD>      
 </TR>
 <TR>
  <TD>Reliability: <font class="out"><? echo value($vendor[reliability],2);?></font>
      
	  <? if($vendor[reliabilityText]){?><br><font class="outi"><? echo $vendor[reliabilityText];?></font><? }?>
    </TD>  
  <TD>Availability: <font class="out"><? echo value($vendor[availability],2);?></font>
  	  <? if($vendor[availabilityText]){?><br><font class="outi"><? echo $vendor[availabilityText];?></font><? }?>
  </TD>      
 </TR>
 <TR>
  <TD>Experience in the market: <font class="out"><? echo value($vendor[experienceM],3);?></font>
  	  <? if($vendor[experienceMText]){?><br><font class="outi"><? echo $vendor[experienceMText];?></font><? }?></TD>  
  <TD>Experience with BFEW: <font class="out"><? echo value($vendor[experienceB],3);?></font>
  	  <? if($vendor[experienceBText]){?><br><font class="outi"><? echo $vendor[experienceBText];?></font><? }?></TD>      
 </TR>
 <TR>
  <TD>After Sales service: <font class="out"><? echo value($vendor[service],2);?></font>
  	  <? if($vendor[serviceText]){?><br><font class="outi"><? echo $vendor[serviceText];?></font><? }?></TD>  
  <TD>Advance Required: <font class="out"><? echo value($vendor[advance],4);?></font></TD>      
 </TR>
	 <TR>
	  <TD colspan="2" >Credit Facility: <font class="out"><? echo value($vendor[cfacility],4);?></font>; 
	  <? if($vendor[cfacility]==4){?>
	   Max. Credit Amount: Tk. <font class="out"><? echo number_format($vendor[camount],2);?></font>
		  Max. Credit Duration: <font class="out"><? echo $vendor[cduration];?></font> days</TD>      
		  <? }?>
	 </TR>
<TR><TD colspan="2">
   <table align="center" width="100%" border="1" bordercolor="#CCCCFF" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
        <tr bgcolor="#EEEEFF"> 
          <td align="center" height="30"> Project</td>
          <td align="center" width="80"> Item</td>
          <td align="center"> Description</td>
          <td align="center" > Delivery Details</td>
          <td align="center" > <? if($vendor[cfacility]==0) echo "Rate (Cash)"; else echo "Rate (Credit)"; ?></td>
          <td align="center" > Unit</td>		  
		  <td align="center"> Quotation Ref.</td>
          <td align="center"> Valid Till</td>
        </tr>
        <? include("config.inc.php");
$dbq = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 
$sqlq = "SELECT quotation.*,itemlist.* from `quotation`, itemlist WHERE vid=$vendor[vid] ";
if($project) $sqlq .=" AND pCode=$project";
if($itemCode1) $sqlq .=" AND quotation.itemCode='$itemCode1-$itemCode2-$itemCode3'";
$sqlq .=" AND quotation.itemCode= itemlist.itemCode";
//echo $sqlq;
$sqlrunq= mysqli_query($db, $sqlq);
while($qresult= mysqli_fetch_array($sqlrunq)){
?>
        <tr > 
          <td align="center"> <? echo $qresult[pCode];?></td>
          <td align="center" width="80"> <a href="./index.php?keyword=enter+Quotation&Go=1&vid=<? echo $qresult[vid];?>&edit=1&qid=<? echo $qresult[qid];?>&visible=1 #edit" ><? echo $qresult[itemCode];?></a></td>
          <td align="left"> <? echo $qresult[itemDes].', '.$qresult[itemSpec];?></td>
          <td align="left"> <? echo $qresult[sDetail];?></td>
          <td  align="right"> <? echo number_format($qresult[rate],2);?></td>
          <td align="center" width="8%" > <? echo $qresult[itemUnit];?></td>		  
          <td align="center"> <? echo $qresult[qRef];?></td>
          <td align="center" width="12%" > <? // echo date("d-m-Y",strtotime($vendor[valid]));
		  	 echo  valid($qresult[valid]).date("d-m-Y",strtotime($qresult[valid])).' </font>';
		  ?>
		  
		   </td>
        </tr>
        <? }?>
      </table>
</TD></TR>
<TR><TD height="3" colspan="2" bgcolor="#EEEEEE" ></TD></TR>
 </table>
 <br><br>
<? }?>

<br>
<? include("./vendor/pointChart.php");?>

 <?php

        include("./includes/PageNavigation.php");

        $totalResults= $total_result;
        $resultsPerPage= $total_per_page;
        $page= $_GET[page];
        $startHTML= "<b>Showing Page {page} of {pages}</b>: Go to Page ";
        $appendSearch= "&a=1&b=2";
        $range= 5;
		$rootLink="./index.php?keyword=vendor+Report";
        $link_on= "<a href='$rootLink&page={num}{appendSearch}'><b>{num}</b></a>";
        $link_off= "<a href='$rootLink&page={num}{appendSearch}'>{num}</a>";
        $back= " <a href='$rootLink&page=1{appendSearch}'><<</a> ";
        $forward= " <a href='$rootLink&page={pages}{appendSearch}'>>></a> ";

        $myNavigation = New PageNavigation($totalResults, $resultsPerPage, $page, $startHTML, $appendSearch, $range, $link_on, $link_off, $back, $forward);

        echo $myNavigation->getHTML();

?>
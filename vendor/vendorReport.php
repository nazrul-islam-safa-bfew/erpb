<? include_once('vendorSearch.php');?>
<? if($vid=='99' )include_once('vendorBFEW_Cstore.php');?>
<? if($vid=='85' ) include_once('vendorBFEW_eq.php');?>
<? if($vid<>'85' OR $vid<>'99'){?>
<?  include("config.inc.php");
$db11 = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sqlv = "SELECT vendor.*, quotation.*,itemlist.* from `vendor`,`quotation`, itemlist WHERE quotation.vid=vendor.vid AND quotation.itemCode= itemlist.itemCode ";
$sqlv .= " AND ( vendor.vid!='85' AND vendor.vid!='99') ";
if($vid) $sqlv .=" AND vendor.vid='$vid'  ";
if($project) $sqlv .=" AND pCode=$project";
if($itemCode1) $sqlv .=" AND quotation.itemCode='$itemCode1-$itemCode2-$itemCode3'";
//$sqlv.= " ORDER BY point DESC";
//echo $sqlv;
$sqlrunq= mysql_query($sqlv);
/* PAge */
$total_result=mysql_affected_rows();
$total_per_page=50;

if($page<=0)
	{
	$page=1;
	}
$curr=($page-1)*$total_per_page;

//$sqlv.=" ORDER by vendor.vid DESC LIMIT $curr,$total_per_page";
//$sqlv.=" ORDER by vendor.point DESC,quotation.itemCode ASC LIMIT $curr,$total_per_page";
$sqlv.=" ORDER by vendor.point DESC,vendor.vid DESC,quotation.itemCode ASC LIMIT $curr,$total_per_page";
//$sqlp11.=" ";
//echo $sqlp11;
	$sqlrunq= mysql_query($sqlv);
/* END */
//echo $sqlv;
while($vendor= mysql_fetch_array($sqlrunq)){

?>

<table align="center" width="98%"   border="2" bordercolor="#E8E8E8" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
<? if($pre!=$vendor[vname]){?>
<br>
 <tr>
  <td  colspan="8">
    <table align="center" width="100%"   border="1" bordercolor="#E8E8E8" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
     <tr>
	  <td colspan="2">
   		<table width="100%"  cellpadding="3" cellspacing="0" style="border-collapse:collapse">
	     <tr bgcolor="#EEEEEE">
		  <TD width="100%"  >Vendore Name: <a class="hd" href="./index.php?keyword=vendor&vid=<? echo $vendor[vid];?>"> <? echo $vendor[vname];?></a></TD>
		  <TD width="200" align="right">
<!-- 			  <table  width="200" border="2" bgcolor="#FFFFFF" bordercolor="#FF0000" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
    			<tr><td align="center">Vendor Rating: <font color="#FF0000" size="+2"><? echo $vendor[point];?> </font>Points</td></tr>
			   </table>
 -->			  <table  width="250" border="2" bgcolor="#FFFFFF" bordercolor="#FF0000" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
    			<tr><td align="center">Vendor Rating: <font color="#FF0000" size="+2"><? echo $vendor[point];?> </font>Points
				<a href="<? echo $vendor[att];?>"><img src="./images/pdf_icon.jpg" width="30" height="30" border="0" ></a>
				<a href="./vendor/print_vendor.php?vid=<? echo $vendor[vid];?>" target="_blank"><img src="./images/b_print.png" width="16" height="16" border="0" ></a>				
				
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
	  <? $sqlr="select * from vendorrating where vid=$vendor[vid]"; 
// echo $sqlr;
 $sqlrq=mysql_query($sqlr);
 while($vr=mysql_fetch_array($sqlrq)){ ?>
 <tr bgcolor="#FFFFCC">
 <td colspan="2" align="left">

<?  echo "Rated <b><font class=out>".$vr[point]."</font></b> points at ".mydate($vr[datev])." by ".empName($vr[ratedBy]).', '.hrDesignation(hrDesignationCode($vr[ratedBy])); ?>
  [ <a href="<? echo $vr[att];?>"> Click for Scanned copy</a> ]
 </td>
 </tr>
  
<?  }?>			   

	 <TR>
	  <TD width="50%" >Vendor Type: <font class="out"><? echo vendorRating($vendor[8],1);?></font></TD>
	  <TD  width="50%">Position: <font class="out"><? echo vendorRating($vendor[quality],2);?></font></TD>
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
	  <TD colspan="2" >Credit Facility: <font class="out"><? echo vendorRating($vendor[cfacility],4);?></font>;
	  <? if($vendor[cfacility]==4){?>
	   Max. Credit Amount: Tk. <font class="out"><? echo number_format($vendor[camount],2);?></font>
		  Max. Credit Duration: <font class="out"><? echo $vendor[cduration];?></font> days</TD>
		  <? }?>
	 </TR>
	</table>
   </td>
 </tr>
        <tr bgcolor="#EEEEFF">
          <td align="center" height="30" width="10%" > Project</td>
          <td align="center" > Item</td>
          <td align="center" > Description</td>
          <td align="center" > Delivery Details</td>
          <td align="center" > <? if($vendor[cfacility]==0) echo "Rate (Cash)"; else echo "Rate (Credit)"; ?></td>
          <td align="center" > Unit</td>		  
          <td align="center" > Quotation Ref.</td>
          <td align="center" > Valid Till</td>
</TR>
 <? }?>
<TR>
          <td align="center" width="10%" > <? echo $vendor[pCode];?></td>
          <td align="center" width="10%" > <a href="./index.php?keyword=enter+Quotation&Go=1&vid=<? echo $vendor[vid];?>&edit=1&qid=<? echo $vendor[qid];?>&visible=1 #edit" ><? echo $vendor[itemCode];?></a></td>
          <td align="left" width="20%" > <? echo $vendor[itemDes].', '.$vendor[itemSpec];?></td>
          <td align="left" width="20%" >		  <? if($vendor[delivery]=='To') echo "To ".myprojectName($vendor[deliveryLoc]).";" ; else echo "From $vendor[deliveryLoc];"; ?>
		   <? echo $vendor[sDetail];?></td>

          <td  align="right" width="10%" > <? echo number_format($vendor[rate],2);?></td>
          <td  align="center" width="10%" > <? 
		  if($vendor[itemCode]<'50-00-000' OR $vendor[itemCode]>='99-00-000'){  $unit=$vendor[itemUnit];} else $unit='day';
		  echo $unit;?></td>
          <td align="center" width="10%" > <? echo $vendor[qRef];?></td>
           <td align="center" width="12%" > <? // echo $vendor[valid];
		  	 echo  valid($vendor[valid]).date("d-m-Y",strtotime($vendor[valid])).' </font>';
		  ?>

</TR>


 </table>
<? $pre=$vendor[vname];

}?>

<br>


 <?php

        include("./includes/PageNavigation.php");

        $totalResults= $total_result;
        $resultsPerPage= $total_per_page;
        $page= $_GET[page];
        $startHTML= "<b>Showing Page {page} of {pages}</b>: Go to Page ";
        $appendSearch= "&vid=$vid&b=2";
        $range= 5;
		$rootLink="./index.php?keyword=vendor+Report";
        $link_on= "<a href='$rootLink&page={num}{appendSearch}'><b>{num}</b></a>";
        $link_off= "<a href='$rootLink&page={num}{appendSearch}'>{num}</a>";
        $back= " <a href='$rootLink&page=1{appendSearch}'><<</a> ";
        $forward= " <a href='$rootLink&page={pages}{appendSearch}'>>></a> ";

        $myNavigation = New PageNavigation($totalResults, $resultsPerPage, $page, $startHTML, $appendSearch, $range, $link_on, $link_off, $back, $forward);

        echo $myNavigation->getHTML();

?>
<? //include("pointChart.php");
}// if vid not eqal to 85,95
?>
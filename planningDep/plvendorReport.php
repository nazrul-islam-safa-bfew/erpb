<? 
session_start();
$loginDesignation = $_SESSION['loginDesignation'];


 $type=$_GET[type];
 $project=$_GET[project];
 $itemCode=$_GET[itemCode];
  $dmaTotal=$_GET[dmaTotal];
  $poTotal=$_GET[poTotal];

if($itemCode <'99-00-000' AND $type!='eqpp') include_once('vendorBFEW.php');
?>

<?  include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);


// $sqlv = "SELECT vendor.*, quotation.*,itemlist.* from `vendor`,`quotation`, `itemlist`,quotation_root as qr WHERE
//   quotation.itemCode= itemlist.itemCode ";
// if($type=='eqpp'){ $sqlv .=" AND quotation.type='1' and vendor.vid=qr.vid and qr.qrId=quotation.qrId"; }
// else { $sqlv .=" AND quotation.vid=vendor.vid  AND quotation.type='0' "; }

// if($vid) $sqlv .=" AND vendor.vid='$vid'";
// if($project) $sqlv .=" AND pCode IN ('$project')";
// if($itemCode1){$itemCode="$itemCode1-$itemCode2-$itemCode3";}
// if($itemCode){
// $sqlv .=" AND quotation.itemCode='$itemCode'";
// }


$sqlv = "SELECT v.*,i.*, q.* from `vendor` as v,`quotation` as q, itemlist as i, quotation_root as qr WHERE 
  i.itemCode=q.itemCode and qr.qrId=q.qrId ";

if($project) $sqlv .=" AND q.pCode IN ('$project')  and v.point!='Disqualified' ";
if($itemCode1){$itemCode="$itemCode1-$itemCode2-$itemCode3";}
if($itemCode){
	$sqlv .=" AND q.itemCode='$itemCode' ";
}

if($type=='eqpp'){ $sqlv .=" AND q.type='1' "; }
else { $sqlv .=" AND v.vid=q.vid  AND q.type='0' "; }

if($vid) $sqlv .=" AND v.vid='$vid' and q.vid='$vid' ";

//$sqlv.= " ORDER BY vendor.point DESC";
// $sqlv= "SELECT v.*,i.*, q.* from `vendor` as v,`quotation` as q, itemlist as i, quotation_root as qr WHERE qr.qrId=q.qrId and q.itemCode=i.itemCode and q.vid=v.vid AND q.type='0' AND q.pCode IN ('200') AND q.itemCode='01-01-001'";
//    echo $sqlv;
$sqlrunq= mysqli_query($db, $sqlv);
/* PAge */
 $total_result=mysqli_affected_rows($db);

$total_per_page=200;

if($page<=0)
	{
		$page=1;
	}
$curr=($page-1)*$total_per_page;

$sqlv.=" order by v.vid desc LIMIT $curr,$total_per_page";
//$sqlp11.=" ";
//echo $sqlp11;
 	$sqlrunq1= mysqli_query($db, $sqlv);
/* END */
//      echo $sqlv;
while($vendor= mysqli_fetch_array($sqlrunq1)){
// print_r($vendor);
// 	exit;
?>

<table align="center" width="98%"   border="2" bordercolor="#E8E8E8" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
<? if($pre!=$vendor[vid]){?>
<br>
 <tr>
  <td colspan="8">
    <table align="center" width="100%" border="1" bordercolor="#E8E8E8" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
   <tr>
	  <td colspan="2">
   		<table width="100%"  cellpadding="3" cellspacing="0" style="border-collapse:collapse">
	     <tr bgcolor="#EEEEEE">
		  <TD width="100%">Vendore Name: <? echo $vendor[vname];?></TD>
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
      <TD width="50%" height="22" >Vendor Type: <font class="out"><? echo vendorRating($vendor[type],1);?></font></TD>
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
	  <TD >Advance Require: <font class="out"><? echo vendorRating($vendor[advance],4);?></font></TD>
	 </TR>
	 <TR>
	  <TD colspan="2" >Credit Facility: <font class="out"><? echo vendorRating($vendor[cfacility],4);?></font>;
	  <? if($vendor[cfacility]==4){?>
              Max. Credit Amount: Tk. <font class="out"><? if(!empty($vendor[camount]))echo number_format($vendor[camount],2);?></font>
		  Max. Credit Duration: <font class="out"><? echo $vendor[cduration];?></font> days</TD>
		  <? } ?>
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

          <td align="center" width="80">
		  
		 <? if(valid1($vendor[valid])){

				  if($type=='mat' OR $type=='lab'){  $unit=$store[itemUnit];
				  
				  if($loginDesignation=='Managing Director')
				  	echo $vendor[itemCode];
				  else{
			  ?>
 			  <a href="./index.php?keyword=purchase+order&vid=<? echo $vendor[vid];?>&project=<? echo $project;?>&itemCode=<? echo $vendor[itemCode];?>"><? echo $vendor[itemCode];?></a>
			  <? }
			  }//itemCode
				 elseif($type=='matp'){  $unit=$store[itemUnit];
				 
				 if($loginDesignation=='Managing Director')
				 echo $vendor[itemCode];
				 else
			  ?>
 			  <a href="./index.php?keyword=matpurchase+order&vid=<? echo $vendor[vid];?>&project=<? echo $project;?>&itemCode=<? echo $vendor[itemCode];?>&type=matp"><? echo $vendor[itemCode];?></a>
			  <?
			  }//itemCode

			  elseif($type=='eqpp'){  $unit='no.'; 
			  if($loginDesignation=='Managing Director')
			  echo $vendor[itemCode];
			  else
			  ?>
				<a href="./index.php?keyword=equipment+purchase&vid=<? echo $vendor[vid];?>&project=<? echo $project;?>&itemCode=<? echo $vendor[itemCode];?> "><? echo $vendor[itemCode];?></a>
			  <? }
			  elseif($type=='eqp') {$unit='day';
			  if($loginDesignation=='Managing Director')
			  echo $vendor[itemCode];
			  else
			  ?>
			  <a href="./index.php?keyword=eqpurchase+order&vid=<? echo $vendor[vid];?>&project=<? echo $project;?>&dmaTotal=<? echo $dmaTotal;?>&poTotal=<? echo $poTotal;?>&itemCode=<? echo $vendor[itemCode];?> "><? echo $vendor[itemCode];?></a>
			  <? }?>
			  <?  
			  }?>
		  </td>

		  <td align="left" width="20%" > <? echo $vendor[itemDes].', '.$vendor[itemSpec];?></td>
          <td align="left" width="20%" > <? if($vendor[delivery]=='To') echo "To ".myprojectName($vendor[deliveryLoc]).";" ;
		  else echo "From $vendor[deliveryLoc];"; ?>
		   <? echo $vendor[sDetail];?></td>

          <td  align="right" width="10%" > <? echo number_format($vendor[rate],2);?></td>
		  <td   align="center" ><? echo $unit;?></td>
          <td align="center" width="10%" > <? echo $vendor[qRef];?></td>
      <td align="center" width="12%" > <?
		  if(!valid1($vendor[valid])) {
		  $c="<font style='color:#FF0000; TEXT-DECORATION: underline'>"; }
	      else {$c="<font color=#000000>";}
		  echo $c.date("d-m-Y",strtotime($vendor[valid])).' </font>';
		  ?>
		   </td>

</TR>


 </table>
<? $pre=$vendor[vid];}?>

<br>
<?php

        include("./includes/PageNavigation.php");

        $totalResults= $total_result;
        $resultsPerPage= $total_per_page;
        $page= $_GET[page];
        $startHTML= "<b>Showing Page {page} of {pages}</b>: Go to Page ";
        $appendSearch= "&project=$project&itemCode=$itemCode";
        $range= 5;
		$rootLink="./index.php?keyword=purchase+order+vendor";
        $link_on= "<a href='$rootLink&page={num}{appendSearch}'><b>{num}</b></a>";
        $link_off= "<a href='$rootLink&page={num}{appendSearch}'>{num}</a>";
        $back= " <a href='$rootLink&page=1{appendSearch}'><<</a> ";
        $forward= " <a href='$rootLink&page={pages}{appendSearch}'>>></a> ";

        $myNavigation = New PageNavigation($totalResults, $resultsPerPage, $page, $startHTML, $appendSearch, $range, $link_on, $link_off, $back, $forward);

        echo $myNavigation->getHTML();

?>

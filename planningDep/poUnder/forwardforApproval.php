<?
$temp= explode('_',$posl);
$project=$temp[1];
$vid=$temp[3];
include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

$sqlp = "SELECT * from `pordertemp` WHERE posl='$posl'";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
$fsql=mysqli_fetch_array($sqlrunp);
$podate=mydate($fsql[activeDate]);
$type=$fsql[potype];
if($type=='1' OR $type=='3' OR $type=='4'){
?>
<table width="98%" align="center" cellspacing="0">
<tr>
 <td>
  <table align="left" width="98%" border="0" bordercolor="#000000" bgcolor="#FFFFEE" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
    <tr bgcolor="#FFFFCC">
      <td align="left" height="30" > SL: <? echo viewPosl($posl);?>
				<?php if(poTypeCC($fsql[cc])){ ?>
				<p style="border: 1px solid #ccc;border-radius: 10px;
    display:inline-block;padding: 5px;background: #ff2d2d;color: #fff;"><?php echo poTypeCC($fsql[cc]); ?></p>
			<?php } ?>
			</td>
      <td align="right"><? echo $podate;// putenv ('TZ=Asia/Dacca');  echo date("F d, Y.");?></td>
    </tr>
	<tr><td colspan="2" ><br></td></tr>

<tr>
	<td colspan="2"><h1>
		<i><?php 
	echo print_po_status($posl); ?></i>
		</h1></td>
	</tr>
		
		
	<tr><td colspan="2" >
<?php
error_reporting(1);
if(file_exists("./planningDep/poUnder/porevision.php")){
	include("./planningDep/poUnder/porevision.php");
	$poRevision->print_revision($posl);
}
?>
		</td></tr>
		
	 <?
$vendor = "SELECT * from `vendor` WHERE vid=$vid";
//echo $sqlp;
$sqlr= mysqli_query($db, $vendor);
$vendor = mysqli_fetch_array($sqlr);
?>
 <TR >
  <TD colspan="2"><b> <? echo $vendor[vname];?></b></TD>
 </TR>
 <TR >
  <TD colspan="2"><? echo $vendor[address];?></TD>
 </TR>
<!-- 		vendor rating info -->
 <TR >
  <TD colspan="2" style="padding-top:20px;">
<?php
	$ven_sql="select * from vendorrating where vid='$vendor[vid]' limit 10";
	$ven_q=mysqli_query($db,$ven_sql);

  while($ven_row=mysqli_fetch_array($ven_q)){
		echo "<p style='padding: 0;    margin: 0;    line-height: 20px;'>Rated <span style='color:#f00'><b>$ven_row[point]</b></span> points at ".date("d/m/Y",strtotime($ven_row[datev]))." by ".empID2empInfo($ven_row[ratedBy],"name").", ".hrDesignation(empID2empInfo($ven_row[ratedBy],"designation"))."</p>";
	}
?>
	 
	 
	 </TD>
 </TR>
<!-- 		vendor rating info -->		
		
 <TR>
  <TD colspan="2"><br><br>Subject: 
		<?php 

		if($type=='3')
			echo "<b>Work Order for ";
		elseif($type=='1')
			echo "<b>Work Order for Supply of Material at";

			 echo myprojectName($project);?></b><br><br>
  </TD>  
 </TR>
	  
</table>
 </td>
 </tr>
 <tr>
  <td>
  <table align="left" width="98%" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
    <tr> 
	  <th>Item No</th>
      <th>BFEW's Store Code</th>
      <th>Description</th>
      <th>Quantity</th>	  
      <th>Unit</th>	  
      <th>Rate</th>
      <th>Amount</th>	  
<!--       <th>Quotation Date</th>	   -->
      <th>Rating, Name,<br>Rate, Validity</th>	  
      <th>Qty at hand</th>	  
    </tr>
    <? 
if($vid){

include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT * from  `pordertemp` WHERE posl='$posl' ORDER by itemCode ASC";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

$i=1;
 while($typel1= mysqli_fetch_array($sqlrunp))
{

$status=$typel1[status];
$revision=$typel1[revision];
$temp=itemDes($typel1[itemCode]);
?>
    <tr> 
	   <td align="center"><? echo $i;?>.a</td>
      <td align="center"><a href="./index.php?keyword=purchase+order+vendor&project=<? echo $project;?>&itemCode=<? echo $typel1[itemCode];?>" target="_blank" title="View All Related vendor"><? echo $typel1[itemCode];?></a> </td>
    <td><? echo $temp[des].', '.$temp[spc].'<br>';
	  if($type=='4')eqP_qtyDes($typel1[itemCode],$vid,$posl);?></td>
    <td align="right">  <a href="./planningDep/dailyRequirment.php?project=<? echo $typel1[location];?>&itemCode=<? echo $typel1[itemCode];?>" target="_blank">
	  <? echo number_format($typel1[qty],3);?></a> 	
	  </td>
    <td align="center"><? if($typel1[potype]=='4') echo 'Nos'; else echo $temp[unit]; ?> </td>	  
      <td align="right">Tk.<? echo number_format($typel1[rate],2)?><br>
      Aprv Rate:  
<?php
$sql_dma="select * from dma where dmaItemCode='$typel1[itemCode]' and dmaProjectCode='$typel1[location]' order by dmaDate desc limit 1";
// print_r($sql_dma);
$sqlrunp_dma= mysqli_query($db, $sql_dma);
while($typel1_dma= mysqli_fetch_array($sqlrunp_dma)){
	echo "<font color=\"#00f\">".number_format($typel1_dma[dmaRate],2)."</font>";
}

?>
      


        </td>
      <td align="right">Tk.<? echo number_format($typel1[rate]*$typel1[qty],2)?>    </td>  
<!--       <td ><?  echo $typel1[qref];?> </td>-->
      <td style="font-size: 10px;"> 
				
<?php $q=related_quotation($typel1[itemCode],$project,$vendor[vid]);
	if($q!=0){
		while($q_row=mysqli_fetch_array($q)){
			echo "<p style='line-height: 10px;padding: 0;margin: 5px;'>R $q_row[point]: $q_row[vname] <span style='color:#f00'><b>Tk. $q_row[rate]</b></span> (".date("d/m/Y",strtotime($q_row[valid])).")</p>";
		}
	}
?> 
	<hr>			
<?php $q=related_po($typel1[itemCode],$posl);
	if($q!=0){
		while($q_row=mysqli_fetch_array($q)){
			$temp_posl= explode('_',$q_row[posl]);
			echo "<p style='line-height: 10px;padding: 0;margin: 5px;'><b>".$temp_posl[0]."_"."$temp_posl[1]_$temp_posl[2]</b> $q_row[vname] <span style='color:#f00'><b>Tk. $q_row[rate]</b></span></p>";
		}
	}
?> 
			
			</td>
			<td align=right>
	<?php	
	 
	 $todat=todat();
		$matStock=mat_stock($project,$typel1[itemCode],$todat,$todat); 
	 if($matStock)
		 echo number_format($matStock,3);
	?>
			</td>
    </tr>
    <?
	$total+=$typel1[qty]*$typel1[rate];
$i++;
} //while

}//if?>
<tr><td colspan="7" bgcolor="#FFCCCC" height="40" align="right">Total Amount: <? echo number_format($total,2);?></td></tr>
	 </table>
  </td>
 </tr>

 <tr>
   <td>
   

  <table align="left" width="98%" border="0" bordercolor="#000000" bgcolor="F8F8F8" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
 <tr>
   <td align="center" colspan="2" bgcolor="#E4E4E4" height="30">Receiving Schedule</td>
 </tr>
 <? include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT * from  `pordertemp` WHERE posl='$posl' ORDER by itemCode ASC";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

$totalAmount=0;
 while($typel1= mysqli_fetch_array($sqlrunp))
{
$temp=itemDes($typel1[itemCode]);
?>
    <tr> 
      <td align="left" bgcolor="#EEEEEE" colspan="2"><b><? echo "$typel1[itemCode] $temp[des] $temp[spc]";?> </b></td>
    </tr>
<? 
$dd=array();
$qt=array();
	
$sqlp1 = "SELECT * from  `poscheduletemp` WHERE posl='$posl' AND itemCode='$typel1[itemCode]' ORDER by sdate ASC";
//echo '-------'.$sqlp1.'----------';
$sqlrunp1= mysqli_query($db, $sqlp1);
$j=1;

$dd[0]=$typel1[dstart];

while($typel2= mysqli_fetch_array($sqlrunp1)){
	$dd[$j]=$typel2[sdate];
	$qt[$j]=$typel2[qty];
	$j++;
} //
for($l=0,$m=1;$l<sizeof($qt);$l++,$m=$l+1){
?>	
    <tr>
	  <td> <? echo $m;?>. <?php //echo "L=".$l." // M=".$m; ?> </td>
	  <td >Supply <b><? echo number_format($qt[$m]);?> </b><? echo $temp[unit]?> between <?	  
	  if($l==0) echo date("d-m-Y",strtotime($dd[$l])); //l type
	   else echo date("d-m-Y",strtotime($dd[$l])+86400);?> to
	    <?

	if($type==4)
		if($l!=0)  echo date("d-m-Y",strtotime($dd[$m]));
			else echo date("d-m-Y",strtotime($dd[0])); //l type
	else
		if($l!=0)echo date("d-m-Y",strtotime($dd[$m]));
			else echo date("d-m-Y",strtotime($dd[$m]));
			
?></td>	  
	</tr> 
<?  } //for?>
 <tr>
 	<td > </td>
 	<td >Supply Details: <? echo $typel1[deliveryDetails];?></td>
</tr>	
 <tr>
   <td height="20"></td>
 </tr>

 <? } //while?>
 <tr>
   <td></td>
 </tr>
</table>
   </td>
 </tr>
 
 <tr>
  <td>
  <table align="left" width="98%" border="0" bordercolor="#000000" bgcolor="F8F8F8"  cellpadding="0" style="border-collapse:collapse">
 <tr>
   <td align="center" colspan="3" bgcolor="#E4E4E4" height="30">Invoice Schedule</td>
 </tr>

<? $dat=poInvoiceDate_under($posl);
for($i=1;$i<=sizeof($dat);$i++){
?>
<tr>
<td>
 <? echo "Invoice $i: Raise after";

if($type==3)echo " work";
elseif($type==1)echo " supply";
	echo " completion ";
 $invtemp=scheduleReceiveperInvoice_under($posl,$dat[$i]);
 for($j=1;$j<=sizeof($invtemp);$j++){
 $temp=itemDes($invtemp[$j][0]);
 echo ' '.$invtemp[$j][1].' '.$temp[unit].' of item '.$j.', ';
 }//for j
 ?>
</td>
</tr>

	
 <? }// for?>
 <tr>
   <td></td>
 </tr>
</table>
  
  </td>
 </tr>
 <tr>
   <td>
   <? if($type==3){ include('sub_conditionp.php');}  elseif($type==4)  include('eqpconditionp.php'); else include('conditionp.php');  ?>
   
   </td>
 </tr> 
</table>
<? } else {?>
<table width="100%" align="center" cellspacing="0"  cellpadding="10">
<tr>
 <td>
 
  <table align="left" width="98%" border="0" bordercolor="#000000" bgcolor="#FFFFEE" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
    <tr bgcolor="#FFFFCC"> 
      <td align="left" height="30" > Purchase Order No.: <? echo viewPosl($posl);?>
			
											<?php if(poTypeCC($fsql[cc])){ ?>
				<p style="border: 1px solid #ccc;    border-radius: 10px;
    display: inline-block;    padding: 5px;    background: #ff2d2d;    color: #fff;"><?php echo poTypeCC($fsql[cc]); ?></p>
			<?php } ?>
			
			</td>
      <td align="right"> <?  echo $podate;//echo date("F d, Y.");?> </td>	  
    </tr>
	<tr>	  <td colspan="2" height="10" > </td>	  </tr>
	 <? include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$vendor = "SELECT * from `vendor` WHERE vid=$vid";
//echo $sqlp;
$sqlr= mysqli_query($db, $vendor);
$vendor = mysqli_fetch_array($sqlr);
?>
 <TR >
  <TD colspan="2"><b> <? echo $vendor[vname];?></b></TD>
 </TR>
 <TR >
  <TD colspan="2"><? echo $vendor[address];?></TD>
 </TR>
 <TR>
  <TD colspan="2"><br><br>Subject: <b>Work Order for Supply of Equipment at <? echo myprojectName($project);?></b><br><br>
  </TD>  
 </TR>
	  
</table>
 </td>
 </tr>
 <tr>
  <td>
  <table align="left" width="98%" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
    <tr> 
	  <th>SL.#</th>
      <th>BFEW's Store Code</th>
      <th>Description</th>
      <th>Quantity</th>	  
      <th>Duration</th>	  
      <th>Unit Rate</th>
    </tr>
    <? 
if($vid){

include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT * from  `pordertemp` WHERE posl='$posl'";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

$i=1;
 while($typel1= mysqli_fetch_array($sqlrunp))
{
$sdate = $typel1[dstart];
$status=$typel1[status];
$temp=itemDes($typel1[itemCode]);
?>
<? 
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp1 = "SELECT * from  `poscheduletemp` WHERE posl='$posl' AND itemCode='$typel1[itemCode]' ORDER by sdate ASC";
//echo $sqlp;
$sqlrunp1= mysqli_query($db, $sqlp1);
$typel2= mysqli_fetch_array($sqlrunp1);
$edate = $typel2[sdate];
$itemDes[$i]=$temp[des];
$deliveryDetails[$i]=$typel1[deliveryDetails];
$dstart[$i]=$typel1[dstart];
$qty[$i]=$typel1[qty];
$itemUnit[$i]=$temp[unit];
 ?>

    <tr> 
	   <td align="center"><? echo $i;?>.</td>
      <td align="center"><a href="./index.php?keyword=purchase+order+vendor&project=<? echo $project;?>&itemCode=<? echo $typel1[itemCode];?>" target="_blank" title="View All Related vendor"><? echo $typel1[itemCode];?></a> </td>
      <td>  <?  echo $temp[des];
				if($typel1[potype]==2)
					echo "; ".$temp[spc];
				?>    </td>
          <td align="right"> <a href="./planningDep/eqdailyRequirment.php?project=<? echo $typel1[location];?>&itemCode=<? echo $typel1[itemCode];?>" target="_blank"> 
            <? echo number_format($typel1[qty],3);?> Nos</a> </td>
      <td align="right"><?  $duration =1+(strtotime($edate)-strtotime($sdate))/86400; echo round($duration); ?> days</td>	  
      <td align="right">Tk.<? echo number_format($typel1[rate],2)?> /nos/day   </td>
    </tr>
    <?
$i++;
} //while

}//if?>
	 </table>
  </td>
 </tr>

 <tr>
   <td>
   

  <table align="left" width="98%" border="0" bordercolor="#000000" bgcolor="F8F8F8" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
 <tr>
   <td align="center" colspan="2" bgcolor="#E4E4E4" height="30">Receiving Schedule</td>
 </tr>
 <? include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT * from  `pordertemp` WHERE posl='$posl'";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

$totalAmount=0;
 while($typel1= mysqli_fetch_array($sqlrunp))
{
$temp=itemDes($typel1[itemCode]);
?>
    <tr> 
      <td align="left" bgcolor="#EEEEEE" colspan="2"><b><? echo "$typel1[itemCode] $temp[des] $temp[spc]";?> </b></td>
    </tr>
<? 
$dd=array();
$qt=array();
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp1 = "SELECT * from  `poscheduletemp` WHERE posl='$posl' AND itemCode='$typel1[itemCode]' ORDER by sdate ASC";
//echo '-------'.$sqlp1.'----------';
$sqlrunp1= mysqli_query($db, $sqlp1);
$j=1;

$dd[0]=$typel1[dstart];

 while($typel2= mysqli_fetch_array($sqlrunp1))
{
$dd[$j]=$typel2[sdate];
$qt[$j]=$typel2[qty];
$j++;
} //
for($l=0,$m=1;$l<sizeof($qt);$l++,$m=$l+1){
?>	
    <tr>
	  <td> <? echo $m;?>. </td>
	  <td >Supply <b><? echo number_format($qt[$m]);?> </b><? echo $temp[unit]?> between <?	  
	  if($l==0) echo date("d-m-Y",strtotime($dd[0]));
	   else  echo date("d-m-Y",strtotime($dd[$l])+86400);?> to	   
	    <? echo date("d-m-Y",strtotime($dd[$m]));?></td>	  
	</tr> 
<?  } //for?>
 <tr>
 	<td > </td>
 	<td >Supply Details: <? echo $typel1[deliveryDetails];?></td>
</tr>	
 <tr>
   <td height="20"></td>
 </tr>

 <? } //while?>
 <tr>
   <td></td>
 </tr>
</table>
   </td>
 </tr>
 
 <tr>
  <td>
  <table align="left" width="98%" border="0" bordercolor="#000000" bgcolor="F8F8F8"  cellpadding="0" style="border-collapse:collapse">
 <tr>
   <td align="center" colspan="3" bgcolor="#E4E4E4" height="30">Invoice Schedule</td>
 </tr>

<? $dat=poInvoiceDate_under($posl);
for($i=1;$i<=sizeof($dat);$i++){
?>
<tr>
<td>
 <? echo "Invoice $i:  Raise after supply completion ";
 $invtemp=scheduleReceiveperInvoice_under($posl,$dat[$i]);
 for($j=1;$j<=sizeof($invtemp);$j++){
 $temp=itemDes($invtemp[$j][0]);
 echo ' '.$invtemp[$j][1].' '.$temp[unit].' of item '.$j.', ';
 }//for j
 ?>
</td>
</tr>
	
 <? } //while?>
 <tr>
   <td></td>
 </tr>
</table>
   </td>
 </tr>
 <tr>
   <td><?  include('eqconditionp.php'); ?>
   </td>
 </tr> 
</table>
<? }

if($loginDesignation=='Chairman & Managing Director')
	$text="Revision Text";
else
	$text="Forward Text";
?>
<?php
if($status<1){
	echo $text; ?>:<br><textarea name="revisionTxt" id="revisionTxt" placeholder="<?php echo $text; ?>" style="width:98%"></textarea><br>
	<? if($status=='-1' OR $status=='3'  AND $loginDesignation=='Accounts Manager'){?><input type="button" onClick="location.href='./planningDep/poUnder/forwardforApproval.sql.php?posl=<? echo $posl?>&status=<? echo $status?>&revisionTxt='+document.getElementById('revisionTxt').value;" name="approved" value="Forward for Approval"><? }?>
	<? if($status=='0' AND $loginDesignation=='Chairman & Managing Director'){?>
	<input type="button" onClick="location.href='./planningDep/poUnder/pobackforedit.sql.php?posl=<? echo $posl?>&status=<? echo $status;?>&revision=<? echo $revision;?>&revisionTxt='+document.getElementById('revisionTxt').value;" name="approved" value="Back for Edit" style="float:left; background:#f00; color:#fff;">
	<input type="button" onClick="location.href='./planningDep/poUnder/poApprove.sql.php?posl=<? echo $posl?>&status=<? echo $status;?>&revision=<? echo $revision;?>'" name="approved" value="Approve" style="float:right; background:#00f; margin-right:2%; color:#fff;">
	<? }	
	if($status=='-2' AND $loginDesignation=='Procurement Manager'){?>
	<input type="button" onClick="location.href='./planningDep/poUnder/pobackforedit.sql.php?posl=<? echo $posl?>&status=<? echo $status;?>&revision=<? echo $revision;?>&revisionTxt='+document.getElementById('revisionTxt').value;" name="approved" value="Back for Edit" style="float:left; background:#f00; color:#fff;">
	<input type="button" onClick="location.href='./planningDep/poUnder/poApprove.sql.php?posl=<? echo $posl?>&status=<? echo $status;?>&revision=<? echo $revision;?>'" name="approved" value="Forward" style="float:right; background:#00f; margin-right:2%; color:#fff;">
	<? }
}
?>
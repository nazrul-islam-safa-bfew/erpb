<?php
	include("./includes/config.inc.php");

$theVid=$vid; // get vendor id from the post method user input
	
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 
$grand_amount=0;
$jjj=0; //for serial no.
			
if($_POST['total_row'])
{
	$all_row=$_POST['total_row'];
	$location=$_POST[location];	
		
	for($kkk=1;$kkk<=$all_row;$kkk++)
	{
		$vid_temp=$_POST["vid_".$kkk];
		$amount=$_POST["approved_amount_".$kkk];
		$posl=$_POST["posl_".$kkk];
		

		$seven=$_POST['seven'.$kkk];
		$fifteen=$_POST['fifteen'.$kkk];
		$thirty=$_POST['thirty'.$kkk];
		$sixty=$_POST['sixty'.$kkk];
		$ninty=$_POST['ninty'.$kkk];
		$ninetyone=$_POST['nintyone'.$kkk];
		
	
		

		
	if($_POST['approved']=='Approved')
		if($amount)
		{		
			
			mysqli_query($db, "select * from vendorPaymentApproval where posl='$posl' and vid='$vid_temp'");
			if(mysqli_affected_rows()<1)
				$approval_sql="insert into vendorPaymentApproval (
								`vid` ,
								`amount` ,
								`location` ,
								`posl` ,
								`7` ,
								`15` ,
								`30` ,
								`60` ,
								`90` ,
								`91`) value ('$vid_temp','$amount','$location','$posl','$seven','$fifteen','$thirty','$sixty','$ninty','$ninetyone')";
			
			else
			  $approval_sql="update vendorPaymentApproval set

								`amount`='$amount' ,
								`7`= '$seven',
								`15`= '$fifteen',
								`30`= '$thirty',
								`60`= '$sixty',
								`90`= '$ninty',
								`91`='$ninetyone' where vid='$vid_temp' and posl='$posl'";

			mysqli_query($db, $approval_sql);
		}//end of if amount
	

		
	if($_POST['d_approved']=='Discard Approved')
	{
		
		$approval_sql="delete from vendorPaymentApproval where posl='$posl' and vid='$vid_temp'";
		mysqli_query($db, $approval_sql);
	}
		
}	//end of for
}//total row


function check_theValue($posl,$vid,$column, $SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME)
{
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 
	
	$sql="select * from vendorPaymentApproval where posl='$posl' and vid='$vid'";
	$res=mysqli_query($db, $sql);
	$row=mysqli_fetch_array($res);
	//return $row;
	if($row['amount'])
		return $row;
	else
		return 0;
}

$r=0;	
?>

	<script type="text/javascript">
		the_row_data_switch = new Array();
	</script>

	<form name="searchBy" action="./index.php?keyword=aged+vendor+payable+approval" method="post">

	<table width="600" align="center" class="ablue">
		<tr>
			<td colspan="3" align="right" class="ablueAlertHd">vendor payment</td>
		</tr>
		<?
if($Status=='Short by date') $r1='checked';
else if($Status=='Short by vendor') $r2='checked'; 
else if($Status=='Short by PO') $r3='checked'; 

?>
			<tr>
				
						 <td colspan="3">
		 Shrot by: PO No.<input type="radio"  name="Status" <? echo !$r1 || !$r2 ? ' checked ' : "";?>  value="Short by PO"/> 
		 Date<input type="radio"  name="Status" <? echo $r1;?>  value="Short by date"/> 
		 Vendor<input type="radio"  name="Status" <? echo $r2;?> value="Short by vendor" />
		 </td>
			</tr>
		
		
		<tr>
   <th width="200">Select Vendor</th>
 <td >

<select name="vid">
 <option value="">All Vendor</option>
<?
include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT distinct vendor.vid,vendor.vname,porder.vid from `vendor`,porder WHERE vendor.vid=porder.vid ORDER by vendor.vname ASC ";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

 while($typel= mysqli_fetch_array($sqlrunp))
{
 echo "<option value='".$typel[vid]."'";
 if(vendor_payable_approved_counter($typel[vid],$_POST["pcode"])>0)echo " style=\"background:#ddd; color:red; font-size:14px;\" ";
 if($vid==$typel[vid]) echo " SELECTED ";
 echo ">$typel[vname] --(".vendor_payable_approved_counter($typel[vid],$_POST["pcode"])." nos) </option>  ";
 }
?>
	</select>
</td>
<td rowspan="2"><input type="submit" name="search" value="Search" style="height:50px;width:100"></td>

 </tr>
		
		
<!-- 		
			<tr>
				<th width="200" height="10"></th>
				<td>


				</td>
				<td rowspan="2"><input type="submit" name="search" value="Search" style="height:50px;width:100; margin:5px;"></td>



			</tr> -->
			<tr>
				<th width="200">Select Project</th>
				<td>

					<select name="pcode">
<?



$sqlp = "SELECT `pcode`,pname from `project` ORDER by pcode ASC";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
 while($typel= mysqli_fetch_array($sqlrunp))
{
 echo "<option value='".$typel[pcode]."'";
 if($pcode==$typel[pcode])  echo " SELECTED";
 if(vendorApprovalCounterProject($typel[pcode])>0)echo " style=\"background:#ddd; color:red; font-size:14px;\" ";
 echo ">$typel[pcode]--$typel[pname]         --(".vendorApprovalCounterProject($typel[pcode])." nos)  </option>  ";
 }
?>
	</select>
				</td>

			</tr>

	</table>
</form>
	<? if($search){
if($vid=='') {$theVid=$vid='%';}
if($pcode=='') $pcode='%';
?>
		<form action="" method="post">
			<input type="hidden" name="location" value="<?php echo $pcode;?>" /> <input type="hidden" name="seven28" value="1" />
			<table class="ablue" width="90%" border="1" cellpadding="0" cellspacing="0">
				<tr class="ablueAlertHd" align="center">
					<td height="30">Vendor</td>
					<td>
						<7 days </td>
							<td>8-15 days</td>
							<td>16-30 days</td>
							<td>31-60 days</td>
							<td>61-90 days</td>
							<td>>91 days</td>
							<td>Progress Payable
								<br>from Site</td>
							<td>Approved Amount</td>
				</tr>
				
					<tr>
				<td colspan=9><center><h2>
					Cash Purchase Approval
					</h2></center></td>
				</tr>

				<? 
$todat=todat();
$sdate[1][0]=$todat;
$sdate[1][1]=date("Y-m-d",(strtotime($todat)-(8*24*3600)));
$sdate[2][0]=date("Y-m-d",(strtotime($todat)-(9*24*3600)));
$sdate[2][1]=date("Y-m-d",(strtotime($todat)-(16*24*3600)));
$sdate[3][0]=date("Y-m-d",(strtotime($todat)-(17*24*3600)));
$sdate[3][1]=date("Y-m-d",(strtotime($todat)-(30*24*3600)));
$sdate[4][0]=date("Y-m-d",(strtotime($todat)-(31*24*3600)));
$sdate[4][1]=date("Y-m-d",(strtotime($todat)-(60*24*3600)));
$sdate[5][0]=date("Y-m-d",(strtotime($todat)-(61*24*3600)));
$sdate[5][1]=date("Y-m-d",(strtotime($todat)-(90*24*3600)));
$sdate[6][0]=date("Y-m-d",(strtotime($todat)-(91*24*3600)));
$sdate[6][1]='0000-00-00';

//print_r($sdate);
//AND posl like 'PO_142_00302_208'

$sql="SELECT DISTINCT posl,location,vid,poType,activeDate,cc from porder 
WHERE location LIKE '$pcode' 
AND vid LIKE '$vid' AND posl NOT Like 'EP_%'  and porder.cc='2' ";


if($Status=="Short by vendor")$sql="SELECT DISTINCT porder.posl,porder.location,porder.vid,porder.poType,porder.activeDate from porder left join vendor on porder.vid=vendor.vid  WHERE porder.location LIKE '$pcode' 
 AND porder.posl NOT Like 'EP_%' and porder.cc='2' ";

if($Status=="Short by vendor")$sql.=" ORDER by field(porder.vid, '99','85') asc ,vendor.vname ASC";
if($Status=="Short by PO")$sql.=" ORDER by porder.posl asc";
elseif($Status=="Short by date")$sql.="  ORDER BY `porder`.`activeDate` ASC";
else $sql.=" ORDER by porder.posl ASC"; //if($Status=="Short by date")
//   echo $sql.'<br>';
$sqlq=mysqli_query($db, $sql);
$cp_count=mysqli_affected_rows($db);
$ii=1;
while($mr=mysqli_fetch_array($sqlq)){
if(isFullpaid($mr[posl])) continue;

 $potype=poType($mr[posl]); 
$data=array();

$tt=1;
 $location=$mr[location]; 
 $vid=$mr[vid]; 
 $posl=$mr[posl]; 
 $poType=$mr[poType]; 

 //echo "<br>===================$posl=======================<br>";
 
$dat=poInvoiceDate($posl);
//print_r($dat);
$fromDate='0000-00-00';
$this_item_is_not_complete=null;
for($i=1,$k=0;$i<=sizeof($dat);$i++,$k++){
if($poType=='2'){
$pdate=$dat[$i];

 $diff=(strtotime($todat)-strtotime($pdate))/86400;

 $data[$i][0]=$pdate;
 $data[$i][1]=eqpoActualReceiveAmount_date($posl,$fromDate,$dat[$i]);

 if($diff>=91) $st6+=$data[$i][1]; 
 elseif($diff>=61) $st5+=$data[$i][1];
  elseif($diff>=31) $st4+=$data[$i][1];
    elseif($diff>=16) $st3+=$data[$i][1];
	  elseif($diff>=8) $st2+=$data[$i][1];
	    else $st1+=$data[$i][1];
 $fromDate=$pdate;
}else{
 $invtemp=scheduleReceiveperInvoice($posl,$dat[$i]);
 $pdate='0000-00-00';
 for($j=1;$j<=sizeof($invtemp);$j++){
 if($invtemp[$j][1]==0) continue;
 //echo $invtemp[$j][0];
 //echo '='.$invtemp[$j][1];
 if($poType=='1')$rdate=mat_receive($invtemp[$j][0],$invtemp[$j][1],$posl,$location);
 if($poType=='3')$rdate=sub_Receive_Po($invtemp[$j][0],$invtemp[$j][1],$posl,$location);
 if($rdate=='0000-00-00'){ 
     $this_item_is_not_complete[]=$invtemp[$j][0]; //item code
     break; 
 }
//echo '='.$rdate;
 if($rdate>$pdate) $pdate=$rdate;
//echo '='.$pdate; 
//echo "<br>";
 }//for j
 
 
 if(count($this_item_is_not_complete)>0){
      $item_receiving_completation=0; //flag say item not receiving completed.
 }
 else {
      $item_receiving_completation=1;
 }

if($pdate!='0000-00-00' && $item_receiving_completation==1 ){ //if receive some things then paid.
 $diff=(strtotime($todat)-strtotime($pdate))/86400;

 $data[$i][0]=$pdate;
 $data[$i][1]=scheduleReceiveperInvoiceAmount($posl,$dat[$i]); 
 

 if($diff>=91) $st6+=$data[$i][1]; 
 elseif($diff>=61) $st5+=$data[$i][1];
  elseif($diff>=31) $st4+=$data[$i][1];
    elseif($diff>=16) $st3+=$data[$i][1];
	  elseif($diff>=8) $st2+=$data[$i][1];
	    else $st1+=$data[$i][1];
 
}
 }//else
 //echo "=====================$diff=====================<br>";
  //echo $data[$i][0].' = '.$data[$i][1];
// echo "<br>==========================================<br>"; 
}//for i

//print_r($data);
 $poPaidAmount=poPaidAmount($posl);
// echo "<br>poPaidAmount=$poPaidAmount<br>";
 if($poPaidAmount>0){
 if($st6>0){
	if( $poPaidAmount>=$st6) {$poPaidAmount-=$st6;$st6=0;}
	 else  {$st6-=$poPaidAmount;$poPaidAmount=0;}
 }//if($st6>0)
  if($st5>0 AND $poPaidAmount>0){
	if( $poPaidAmount>=$st5) {$poPaidAmount-=$st5;$st5=0;}
	 else  {$st5-=$poPaidAmount;$poPaidAmount=0;}
 }//if($st5>0)
  if($st4>0 AND $poPaidAmount>0){
	if( $poPaidAmount>=$st4) {$poPaidAmount-=$st4;$st4=0;}
	 else  {$st4-=$poPaidAmount;$poPaidAmount=0;}
 }//if($st4>0)
  if($st3>0 AND $poPaidAmount>0){
	if( $poPaidAmount>=$st3) {$poPaidAmount-=$st3;$st3=0;}
	 else  {$st3-=$poPaidAmount;$poPaidAmount=0;}
 }//if($st3>0)
  if($st2>0 AND $poPaidAmount>0){
	if( $poPaidAmount>=$st2) {$poPaidAmount-=$st2;$st2=0;}
	 else  {$st2-=$poPaidAmount;$poPaidAmount=0;}
 }//if($st2>0)
  if($st1>0 AND $poPaidAmount>0){
	if( $poPaidAmount>=$st1) {$poPaidAmount-=$st1;$st1=0;}
	 else  {$st1-=$poPaidAmount;$poPaidAmount=0;}
 }//if($st1>0)

}

if($st1+$st2+$st3+$st4+$st5+$st6>0){$jjj++;
?>

					<tr id="ro1_<?php echo $r; ?>">
						<td colspan="9" height="10" bgcolor="#FFFFE8"></td>
					</tr>
					<tr id="ro2_<?php echo $r; ?>">
						<td colspan="9" height="2" bgcolor="#0099FF"></td>
					</tr>
					<tr id="ro_<?php echo $r; ?>">
						<td>
							<? echo $jjj.")";?> [
								<a target="_blank" href="./planningDep/printpurchaseOrder1.php?posl=<? echo $mr[posl];?>">
									<? echo viewPosl($mr[posl]);?>
								</a>]

								<? $vtemp=vendorName($vid);
  echo $vtemp[vname];
  $r++; //added by suvro
?>
									[<a target="_blank" href="./print/print_poLedger.php?posl=<? echo $mr[posl];?>&project=<? echo $location;?>&potype=<? echo $poType;?>&vname=<? echo $vtemp[vname];?>">Detail</a>]



									<?php
																	
			if(($_SESSION["loginDesignation"]=="Accounts Executive" || $_SESSION["loginDesignation"]=="Chairman & Managing Director") && check_posl_approved($mr[posl])){				
				echo "<a href='".get_posl_approved_row($mr[posl])."' target='_blank' class='pdf_class'><img src='./images/pdf.png'></a>";
				echo "<div style='background: #077900;color: #fff;display: inline-block;padding: 3px;border-radius: 5px;float: right;font-size: 12px; margin-top:2px;'>Verified</div>";
			}
	
	?>
										<style>
											.pdf_class {
												float: right;
												padding-left: 5px;
												padding-right: 5px;
												background: #fff;
												text-decoration: none;
												border: none;
												transition: background .5s;
											}
											
											.pdf_class:hover {
												background: #c1c1c1;
												border: none;
											}
										</style>

										<br>PO Amount:
										<? echo  number_format(poTotalAmount($mr[posl]),2).' dated '.mydate($mr[activeDate]);?>
						</td>
						<td align="right" id="<?php echo $r.'7'; ?>" <?php if(check_posl_approved($posl)){ ?>
							onclick="add_this_in_function(
							<?php echo str_replace(',','',number_format($st1,2)).','.$r.',the_row_data_switch['.$r.'7],'.$r.'7'.',7'; ?>)"
							<?php } ?> >
							<? if($st1)echo number_format($st1,2)?>
								<input type="hidden" name="vid_<?php echo $r;?>" value="<?php echo $vid; ?>" />
								<input type="hidden" name="posl_<?php echo $r;?>" value="<?php echo $mr[posl]; ?>" />

								<?php $get_row_data=check_theValue($posl,$vid,'7', $SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME); ?>
								<input type="hidden" value="<?php echo $get_row_data[5]; ?>" name="<?php echo 'seven'.$r; ?>" id="<?php echo $r.'__7'; ?>" />

						</td>

						<td align="right" id="<?php echo $r.'15'; ?>" <?php if(check_posl_approved($posl)){ ?> onclick="add_this_in_function(
							<?php echo str_replace(',','',number_format($st2,2)).','.$r.',the_row_data_switch['.$r.'15],'.$r.'15'.',15'; ?>)"
							<?php } ?>>
							<? if($st2)echo number_format($st2,2)?>
								<input type="hidden" value="<?php echo $get_row_data[6]; ?>" name="<?php echo 'fifteen'.$r; ?>" id="<?php echo $r.'__15'; ?>" /> </td>



						<td align="right" id="<?php echo $r.'30'; ?>" <?php if(check_posl_approved($posl)){ ?> onclick="add_this_in_function(
							<?php echo str_replace(',','',number_format($st3,2)).','.$r.',the_row_data_switch['.$r.'30],'.$r.'30'.',30'; ?>)"
							<?php } ?>>
							<? if($st3)echo number_format($st3,2)?>
								<input type="hidden" value="<?php echo $get_row_data[7]; ?>" name="<?php echo 'thirty'.$r; ?>" id="<?php echo $r.'__30'; ?>" /> </td>

						<td align="right" id="<?php echo $r.'60'; ?>" <?php if(check_posl_approved($posl)){ ?> onclick="add_this_in_function(
							<?php echo str_replace(',','',number_format($st4,2)).','.$r.',the_row_data_switch['.$r.'60],'.$r.'60'.',60'; ?>)"
							<?php } ?>>
							<? if($st4)echo number_format($st4,2)?>
								<input type="hidden" value="<?php echo $get_row_data[8]; ?>" name="<?php echo 'sixty'.$r; ?>" id="<?php echo $r.'__60'; ?>" /> </td>

						<td align="right" id="<?php echo $r.'90'; ?>" <?php if(check_posl_approved($posl)){ ?> onclick="add_this_in_function(
							<?php echo str_replace(',','',number_format($st5,2)).','.$r.',the_row_data_switch['.$r.'90],'.$r.'90'.',90'; ?>)"
							<?php } ?>>
							<? if($st5)echo number_format($st5,2)?>
								<input type="hidden" value="<?php echo $get_row_data[9]; ?>" name="<?php echo 'ninty'.$r; ?>" id="<?php echo $r.'__90'; ?>" /> </td>

						<td align="right" id="<?php echo $r.'91'; ?>" <?php if(check_posl_approved($posl)){ ?> onclick="add_this_in_function(
							<?php echo str_replace(',','',number_format($st6,2)).','.$r.',the_row_data_switch['.$r.'91],'.$r.'91'.',91'; ?>)"
							<?php } ?>>
							<? if($st6)echo number_format($st6,2)?>
								<input type="hidden" value="<?php echo $get_row_data[10]; ?>" name="<?php echo 'nintyone'.$r; ?>" id="<?php echo $r.'__91'; ?>" /></td>

						<td align="right">
							<?

$sqlp = "SELECT * from `popayments` WHERE (posl LIKE '". $mr[posl]."') AND (paidAmount < totalAmount) order by popID ASC ";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
//echo mysql_error();
while($re_s=mysqli_fetch_array($sqlrunp)){


if($pcode AND $vid){


$potype=poType($re_s[posl]);
$t=explode('_',$re_s[posl]);
if($potype==1) $receiveAmount=poTotalreceive($re_s[posl],$t[1]);
if($potype==2) $receiveAmount=eqpoActualReceiveAmount($re_s[posl]);
if($potype==3) $receiveAmount=subWorkTotalReceive_Po($re_s[posl]);
$paid=poPaidAmount($re_s[posl]);

?>

								<? $currentPayable=foodinfAmount($re_s[totalAmount],$receiveAmount,$paid,$re_s[posl]); 
   $currentPayable=round($currentPayable,2);
  
  } 
  

 echo number_format($currentPayable,2)."<br>";
   }?>
						</td>


						<td align="right"><input type="text" style="text-align:right" id="approved_amount_<?php echo $r; ?>" name="approved_amount_<?php echo $r; ?>" value="<?php if($get_row_data['amount']){echo $get_row_data['amount'];$grand_amount=$get_row_data['amount']+$grand_amount;} else echo 0;?>"
								<?php if(!check_posl_approved($posl))echo "readonly"; ?> /></td>
					</tr>

					<tr>
						<td colspan="9" height="2" bgcolor="#0099FF"></td>
					</tr>
		


					<script type="text/javascript">
						<?php  if($st1+$st2+$st3+$st4+$st5+$st6==0)
		{ 
		$all_js='
		document.getElementById("ro_'.($r-1).'").style.display="none";'.$all_js;
	 } ?>


						function add_this_in_function_load(row, get_the_switch_value, the_row_and_col, col) {
							document.getElementById(the_row_and_col).style.background = "#ccc";
							the_row_data_switch[the_row_and_col] = 1;
							document.getElementById(row + '__' + col).value = 1;
						}


						<?php

		
			 if($get_row_data['7']==1)
	 	echo "add_this_in_function_load(".$r.',0,'.$r.'7'.',7'.");";
	 if($get_row_data['15']==1)
	 	echo "add_this_in_function_load(".$r.',0,'.$r.'15'.',15'.");";
	 if($get_row_data['30']==1)
	 	echo "add_this_in_function_load(".$r.',0,'.$r.'30'.',30'.");";
	 if($get_row_data['60']==1)
	 	echo "add_this_in_function_load(".$r.',0,'.$r.'60'.',60'.");";
	 if($get_row_data['90']==1)
	 	echo "add_this_in_function_load(".$r.',0,'.$r.'90'.',90'.");";
	 if($get_row_data['91']==1)
	 	echo "add_this_in_function_load(".$r.',0,'.$r.'91'.',91'.");";
		
		
	?>
					</script>



					<? $st1=$st2=$st3=$st4=$st5=$st6=0;$poPaidAmount=0;}
$ii++;
 }//while
				
				
				
			if($cp_count==0)	{
				echo "<tr><td colspan=9><center><h4>Cash purchase order not found</h4></center></td></tr>";
				}
				?>
				
				
				
				
				
				
<!-- 		============================================================================	cc=1 credit purchase		 -->	
				
				<tr>
				<td colspan=9><center><h2>
					Credit Purchase Approval
					</h2></center></td>
				</tr>
				
				
				<? 
$todat=todat();
$sdate[1][0]=$todat;
$sdate[1][1]=date("Y-m-d",(strtotime($todat)-(8*24*3600)));
$sdate[2][0]=date("Y-m-d",(strtotime($todat)-(9*24*3600)));
$sdate[2][1]=date("Y-m-d",(strtotime($todat)-(16*24*3600)));
$sdate[3][0]=date("Y-m-d",(strtotime($todat)-(17*24*3600)));
$sdate[3][1]=date("Y-m-d",(strtotime($todat)-(30*24*3600)));
$sdate[4][0]=date("Y-m-d",(strtotime($todat)-(31*24*3600)));
$sdate[4][1]=date("Y-m-d",(strtotime($todat)-(60*24*3600)));
$sdate[5][0]=date("Y-m-d",(strtotime($todat)-(61*24*3600)));
$sdate[5][1]=date("Y-m-d",(strtotime($todat)-(90*24*3600)));
$sdate[6][0]=date("Y-m-d",(strtotime($todat)-(91*24*3600)));
$sdate[6][1]='0000-00-00';

//print_r($sdate);
//AND posl like 'PO_142_00302_208'

$sql="SELECT DISTINCT posl,location,vid,poType,activeDate,cc from porder 
WHERE location LIKE '$pcode' 
AND vid LIKE '$theVid' AND posl NOT Like 'EP_%' and (porder.cc='1' or porder.cc='') ";


if($Status=="Short by vendor")$sql="SELECT DISTINCT porder.posl,porder.location,porder.vid,porder.poType,porder.activeDate from porder left join vendor on porder.vid=vendor.vid  WHERE porder.location LIKE '$pcode' 
 AND porder.posl NOT Like 'EP_%'  and (porder.cc='1' or porder.cc='')  ";
	
	

if($Status=="Short by vendor")$sql.=" ORDER by field(porder.vid, '99','85') asc ,vendor.vname ASC";
if($Status=="Short by PO")$sql.=" ORDER by porder.posl asc";
elseif($Status=="Short by date")$sql.="  ORDER BY `porder`.`activeDate` ASC";
else $sql.=" ORDER by porder.posl ASC"; //if($Status=="Short by date")
//    echo $sql.'<br>';
$sqlq=mysqli_query($db, $sql);
$ii=1;
while($mr=mysqli_fetch_array($sqlq)){
if(isFullpaid($mr[posl])) continue;
 $potype=poType($mr[posl]); 
$data=array();

$tt=1;
 $location=$mr[location]; 
 $vid=$mr[vid]; 
 $posl=$mr[posl]; 
 $poType=$mr[poType]; 

//  echo "<br>===================$posl=======================<br>";
 
$dat=poInvoiceDate($posl);
// print_r($dat);//============================================================================
$fromDate='0000-00-00';
$this_item_is_not_complete=null;
for($i=1,$k=0;$i<=sizeof($dat);$i++,$k++){
if($poType=='2'){
$pdate=$dat[$i];

 $diff=(strtotime($todat)-strtotime($pdate))/86400;

 $data[$i][0]=$pdate;
 $data[$i][1]=eqpoActualReceiveAmount_date($posl,$fromDate,$dat[$i]);

 if($diff>=91) $st6+=$data[$i][1]; 
 elseif($diff>=61) $st5+=$data[$i][1];
  elseif($diff>=31) $st4+=$data[$i][1];
    elseif($diff>=16) $st3+=$data[$i][1];
	  elseif($diff>=8) $st2+=$data[$i][1];
	    else $st1+=$data[$i][1];
 $fromDate=$pdate;
}else{
 $invtemp=scheduleReceiveperInvoice($posl,$dat[$i]);
 $pdate='0000-00-00';
 for($j=1;$j<=sizeof($invtemp);$j++){
 if($invtemp[$j][1]==0) continue;
//  echo $invtemp[$j][0];
 //echo '='.$invtemp[$j][1];
 if($poType=='1')$rdate=mat_receive($invtemp[$j][0],$invtemp[$j][1],$posl,$location);
 if($poType=='3')$rdate=sub_Receive_Po($invtemp[$j][0],$invtemp[$j][1],$posl,$location);
 if($rdate=='0000-00-00'){ 
     $this_item_is_not_complete[]=$invtemp[$j][0]; //item code
     break; 
 }
//echo '='.$rdate;
 if($rdate>$pdate) $pdate=$rdate;
//echo '='.$pdate; 
//echo "<br>";
 }//for j
 
 
 if(count($this_item_is_not_complete)>0){
      $item_receiving_completation=0; //flag say item not receiving completed.
 }
 else {
      $item_receiving_completation=1;
 }

if($pdate!='0000-00-00' && $item_receiving_completation==1 ){ //if receive some things then paid.
 $diff=(strtotime($todat)-strtotime($pdate))/86400;

 $data[$i][0]=$pdate;
 $data[$i][1]=scheduleReceiveperInvoiceAmount($posl,$dat[$i]); 
 

 if($diff>=91) $st6+=$data[$i][1]; 
 elseif($diff>=61) $st5+=$data[$i][1];
  elseif($diff>=31) $st4+=$data[$i][1];
    elseif($diff>=16) $st3+=$data[$i][1];
	  elseif($diff>=8) $st2+=$data[$i][1];
	    else $st1+=$data[$i][1];
 
}
 }//else
 //echo "=====================$diff=====================<br>";
  //echo $data[$i][0].' = '.$data[$i][1];
// echo "<br>==========================================<br>"; 
}//for i

// print_r($data);
 $poPaidAmount=poPaidAmount($posl);
//  echo "<br>poPaidAmount=$poPaidAmount<br>";
 if($poPaidAmount>0){
 if($st6>0){
	if( $poPaidAmount>=$st6) {$poPaidAmount-=$st6;$st6=0;}
	 else  {$st6-=$poPaidAmount;$poPaidAmount=0;}
 }//if($st6>0)
  if($st5>0 AND $poPaidAmount>0){
	if( $poPaidAmount>=$st5) {$poPaidAmount-=$st5;$st5=0;}
	 else  {$st5-=$poPaidAmount;$poPaidAmount=0;}
 }//if($st5>0)
  if($st4>0 AND $poPaidAmount>0){
	if( $poPaidAmount>=$st4) {$poPaidAmount-=$st4;$st4=0;}
	 else  {$st4-=$poPaidAmount;$poPaidAmount=0;}
 }//if($st4>0)
  if($st3>0 AND $poPaidAmount>0){
	if( $poPaidAmount>=$st3) {$poPaidAmount-=$st3;$st3=0;}
	 else  {$st3-=$poPaidAmount;$poPaidAmount=0;}
 }//if($st3>0)
  if($st2>0 AND $poPaidAmount>0){
	if( $poPaidAmount>=$st2) {$poPaidAmount-=$st2;$st2=0;}
	 else  {$st2-=$poPaidAmount;$poPaidAmount=0;}
 }//if($st2>0)
  if($st1>0 AND $poPaidAmount>0){
	if( $poPaidAmount>=$st1) {$poPaidAmount-=$st1;$st1=0;}
	 else  {$st1-=$poPaidAmount;$poPaidAmount=0;}
 }//if($st1>0)

}

if($st1+$st2+$st3+$st4+$st5+$st6>0){$jjj++;
?>

					<tr id="ro1_<?php echo $r; ?>">
						<td colspan="9" height="10" bgcolor="#FFFFE8"></td>
					</tr>
					<tr id="ro2_<?php echo $r; ?>">
						<td colspan="9" height="2" bgcolor="#0099FF"></td>
					</tr>
					<tr id="ro_<?php echo $r; ?>">
						<td>
							<? echo $jjj.")";?> [
								<a target="_blank" href="./planningDep/printpurchaseOrder1.php?posl=<? echo $mr[posl];?>">
									<? echo viewPosl($mr[posl]);?>
								</a>]

								<? $vtemp=vendorName($vid);
  echo $vtemp[vname];
  $r++; //added by suvro
?>
									[<a target="_blank" href="./print/print_poLedger.php?posl=<? echo $mr[posl];?>&project=<? echo $location;?>&potype=<? echo $poType;?>&vname=<? echo $vtemp[vname];?>">Detail</a>]



									<?php
			if(is_vendor_payable_approved($posl) && ($_SESSION["loginDesignation"]=="Accounts Executive" || $_SESSION["loginDesignation"]=="Chairman & Managing Director")){				
				echo "<a href='".vendor_payable_approval_pdf($posl)."' target='_blank' class='pdf_class'><img src='./images/pdf.png'></a>";
				echo "<div style='background: #077900;color: #fff;display: inline-block;padding: 3px;border-radius: 5px;float: right;font-size: 12px; margin-top:2px;'>Verified</div>";
			}
	
	?>
										<style>
											.pdf_class {
												float: right;
												padding-left: 5px;
												padding-right: 5px;
												background: #fff;
												text-decoration: none;
												border: none;
												transition: background .5s;
											}
											
											.pdf_class:hover {
												background: #c1c1c1;
												border: none;
											}
										</style>

										<br>PO Amount:
										<? echo  number_format(poTotalAmount($mr[posl]),2).' dated '.mydate($mr[activeDate]);?>
						</td>
						<td align="right" id="<?php echo $r.'7'; ?>" <?php if(is_vendor_payable_approved($posl)){ ?>
							onclick="add_this_in_function(
							<?php echo str_replace(',','',number_format($st1,2)).','.$r.',the_row_data_switch['.$r.'7],'.$r.'7'.',7'; ?>)"
							<?php } ?> >
							<? if($st1)echo number_format($st1,2)?>


								<input type="hidden" name="vid_<?php echo $r;?>" value="<?php echo $vid; ?>" />
								<input type="hidden" name="posl_<?php echo $r;?>" value="<?php echo $mr[posl]; ?>" />

								<?php $get_row_data=check_theValue($posl,$vid,'7', $SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME); ?>
								<input type="hidden" value="<?php echo $get_row_data[5]; ?>" name="<?php echo 'seven'.$r; ?>" id="<?php echo $r.'__7'; ?>" />

						</td>

						<td align="right" id="<?php echo $r.'15'; ?>" <?php if(is_vendor_payable_approved($posl)){ ?> onclick="add_this_in_function(
							<?php echo str_replace(',','',number_format($st2,2)).','.$r.',the_row_data_switch['.$r.'15],'.$r.'15'.',15'; ?>)"
							<?php } ?>>
							<? if($st2)echo number_format($st2,2)?>
								<input type="hidden" value="<?php echo $get_row_data[6]; ?>" name="<?php echo 'fifteen'.$r; ?>" id="<?php echo $r.'__15'; ?>" /> </td>



						<td align="right" id="<?php echo $r.'30'; ?>" <?php if(is_vendor_payable_approved($posl)){ ?> onclick="add_this_in_function(
							<?php echo str_replace(',','',number_format($st3,2)).','.$r.',the_row_data_switch['.$r.'30],'.$r.'30'.',30'; ?>)"
							<?php } ?>>
							<? if($st3)echo number_format($st3,2)?>
								<input type="hidden" value="<?php echo $get_row_data[7]; ?>" name="<?php echo 'thirty'.$r; ?>" id="<?php echo $r.'__30'; ?>" /> </td>

						<td align="right" id="<?php echo $r.'60'; ?>" <?php if(is_vendor_payable_approved($posl)){ ?> onclick="add_this_in_function(
							<?php echo str_replace(',','',number_format($st4,2)).','.$r.',the_row_data_switch['.$r.'60],'.$r.'60'.',60'; ?>)"
							<?php } ?>>
							<? if($st4)echo number_format($st4,2)?>
								<input type="hidden" value="<?php echo $get_row_data[8]; ?>" name="<?php echo 'sixty'.$r; ?>" id="<?php echo $r.'__60'; ?>" /> </td>

						<td align="right" id="<?php echo $r.'90'; ?>" <?php if(is_vendor_payable_approved($posl)){ ?> onclick="add_this_in_function(
							<?php echo str_replace(',','',number_format($st5,2)).','.$r.',the_row_data_switch['.$r.'90],'.$r.'90'.',90'; ?>)"
							<?php } ?>>
							<? if($st5)echo number_format($st5,2)?>
								<input type="hidden" value="<?php echo $get_row_data[9]; ?>" name="<?php echo 'ninty'.$r; ?>" id="<?php echo $r.'__90'; ?>" /> </td>

						<td align="right" id="<?php echo $r.'91'; ?>" <?php if(is_vendor_payable_approved($posl)){ ?> onclick="add_this_in_function(
							<?php echo str_replace(',','',number_format($st6,2)).','.$r.',the_row_data_switch['.$r.'91],'.$r.'91'.',91'; ?>)"
							<?php } ?>>
							<? if($st6)echo number_format($st6,2)?>
								<input type="hidden" value="<?php echo $get_row_data[10]; ?>" name="<?php echo 'nintyone'.$r; ?>" id="<?php echo $r.'__91'; ?>" /></td>

						<td align="right">
							<?

$sqlp = "SELECT * from `popayments` WHERE (posl LIKE '". $mr[posl]."') AND (paidAmount < totalAmount) order by popID ASC ";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
//echo mysql_error();
while($re_s=mysqli_fetch_array($sqlrunp)){


if($pcode AND $vid){


$potype=poType($re_s[posl]);
$t=explode('_',$re_s[posl]);
if($potype==1) $receiveAmount=poTotalreceive($re_s[posl],$t[1]);
if($potype==2) $receiveAmount=eqpoActualReceiveAmount($re_s[posl]);
if($potype==3) $receiveAmount=subWorkTotalReceive_Po($re_s[posl]);
$paid=poPaidAmount($re_s[posl]);

?>

								<? $currentPayable=foodinfAmount($re_s[totalAmount],$receiveAmount,$paid,$re_s[posl]); 
   $currentPayable=round($currentPayable,2);
  
  } 
  

 echo number_format($currentPayable,2)."<br>";
   }?>
						</td>


						<td align="right"><input type="text" style="text-align:right" id="approved_amount_<?php echo $r; ?>" name="approved_amount_<?php echo $r; ?>" value="<?php if($get_row_data['amount']){echo $get_row_data['amount'];$grand_amount=$get_row_data['amount']+$grand_amount;} else echo 0;?>"
								<?php if(!is_vendor_payable_approved($posl))echo "readonly"; ?> /></td>
					</tr>

					<tr>
						<td colspan="9" height="2" bgcolor="#0099FF"></td>
					</tr>



					<script type="text/javascript">
						<?php if($st1+$st2+$st3+$st4+$st5+$st6==0)
		{ 
		$all_js='
		document.getElementById("ro_'.($r-1).'").style.display="none";'.$all_js;
	 } ?>


						function add_this_in_function_load(row, get_the_switch_value, the_row_and_col, col) {
							document.getElementById(the_row_and_col).style.background = "#ccc";
							the_row_data_switch[the_row_and_col] = 1;
							document.getElementById(row + '__' + col).value = 1;
						}


						<?php

		
			 if($get_row_data['7']==1)
	 	echo "add_this_in_function_load(".$r.',0,'.$r.'7'.',7'.");";
	 if($get_row_data['15']==1)
	 	echo "add_this_in_function_load(".$r.',0,'.$r.'15'.',15'.");";
	 if($get_row_data['30']==1)
	 	echo "add_this_in_function_load(".$r.',0,'.$r.'30'.',30'.");";
	 if($get_row_data['60']==1)
	 	echo "add_this_in_function_load(".$r.',0,'.$r.'60'.',60'.");";
	 if($get_row_data['90']==1)
	 	echo "add_this_in_function_load(".$r.',0,'.$r.'90'.',90'.");";
	 if($get_row_data['91']==1)
	 	echo "add_this_in_function_load(".$r.',0,'.$r.'91'.',91'.");";
		
		
	?>
					</script>



					<? $st1=$st2=$st3=$st4=$st5=$st6=0;$poPaidAmount=0;}
$ii++;
 }//while?>

						<tr>
							<td colspan="5"></td>
							<td align="right"><input type="submit" value="Discard Approved" name="d_approved" id="d_approved" onclick="document.getElementById('approved_button').value='';" /></td>
							<td align="right"><input type="submit" value="Approved" id="approved_button" name="approved" <?php if($grand_amount>0)echo 'disabled="disabled"'; ?> onclick="document.getElementById('d_approved').value='';" />
								<input type="hidden" value="<?php echo $r; ?>" name="total_row" />
							</td>
							<td>&nbsp;<span>Total:</span><strong style="color:#FF0000; text-align:center; margin-left:50px; text-align:right" id="final_total_amount"><?php if($grand_amount)echo $grand_amount; else echo 0;?></strong></td>
						</tr>

						<script type="text/javascript">
							<?php

echo $all_js;
?>



							function add_this_in_function(amount, row, get_the_switch_value, the_row_and_col, col) {



								if (get_the_switch_value == 1) {
									document.getElementById(the_row_and_col).style.background = "#fff";
									the_row_data_switch[the_row_and_col] = 0;
									document.getElementById('approved_amount_' + row).value = (parseFloat(document.getElementById('approved_amount_' + row).value) - parseFloat(amount)).toFixed(2);
									document.getElementById(row + '__' + col).value = 0;
								} else {
									document.getElementById(the_row_and_col).style.background = "#ccc";
									the_row_data_switch[the_row_and_col] = 1;
									document.getElementById('approved_amount_' + row).value = (parseFloat(amount) + parseFloat(document.getElementById('approved_amount_' + row).value)).toFixed(2);
									document.getElementById(row + '__' + col).value = 1;
								}
								final_amount = 0;
								for (nn = 1; nn <= <?php echo $r;?>; nn++) {
									final_amount = parseFloat(document.getElementById('approved_amount_' + nn).value) + final_amount;
								}

								document.getElementById('final_total_amount').innerHTML = final_amount.toFixed(2);




							}
						</script>


			</table>
		</form>
		<? }//if?>
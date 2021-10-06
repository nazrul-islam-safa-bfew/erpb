<? include('./includes/session.inc.php')?>
<? function materialReport_summary($siow,$dayesGone,$duration,$project,$edate){
$ed=formatDate($edate,'Y-m-d');
$sqls1 = "SELECT sum(issuedQty*issueRate) as totalAmount from `issue$project` WHERE siowId='$siow' AND issueDate<='$ed' ";
//echo $sqls1;
$sqlruns1= mysqli_query($db, $sqls1);
$out = mysqli_fetch_array($sqlruns1);
if($out[totalAmount])echo "<tr><td colspan=4 align=right><b>Total Expense till $edate is Tk. ".number_format($out[totalAmount],2)."</b></td></tr>";
}
?>
<? function equipmentReport_summary($siow,$dayesGone,$duration,$project,$edate){
include("config.inc.php");
if($SESS_DBNAME)
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
else
	global $db;
	
$sqls = "SELECT * from `dma` WHERE dmasiow='$siow' AND dmaItemCode BETWEEN '50-00-000' AND '69-99-999'";
//echo $sqlp;
$sqlruns= mysqli_query($db, $sqls);

 while($redma= mysqli_fetch_array($sqlruns)){ 
    //$d=formatDate($d,'Y-m-d');

   	 $duration=$duration;//round((strtotime($cd)-strtotime($sd))/(84000));
	// echo $duration.'-';
	// echo $dayesGone.'-';
	 $dayesGone=$dayesGone;//abs(round((strtotime($d)-strtotime($sd))/(84000)));
	 if($dayesGone>$duration){
	// echo $redma[dmaQty].' Hr. (100%)';
	 }
	 else if($dayesGone<0)	  echo "0 Hr. (0%)";
      else{    
   	 $perdayQty=$redma[dmaQty]/$duration;
	 $qty=round($dayesGone*$perdayQty);
	 $pqty = round(($qty*100)/$redma[dmaQty]); 
    // echo "$qty Hr. ( $pqty% )";
	 }
   
   $eqTotalWorkhrsiow = eqTotalWorkhrsiow($redma[dmaItemCode],$todat,$siow);
   $eqTotalWorksiowp=(($eqTotalWorksiow*100)/3600)/$redma[dmaQty];
   
   $eqTotalWorksiowtk =$eqpTotalWorksiow*$redma[dmaRate];
   $eqTotalWorksiowptk=($eqTotalWorksiowtk*100)/( $redma[dmaQty]*$redma[dmaRate]);
   
   $eqTotalWorksiow = sec2hms($eqTotalWorksiow/3600,$padHours=false);
   //$eqTotalWorksiowp = sec2hms($eqTotalWorksiowp/3600,$padHours=false);   
  // echo "$eqTotalWorksiow Hr. (".number_format($eqTotalWorksiowp)." %)";
   
   $GteqTotalWorksiowtk=$GteqTotalWorksiowtk+$eqTotalWorksiowtk;
   $GteqTotalWorksiowptk=   $GteqTotalWorksiowptk+$eqTotalWorksiowptk;
   
} //function
if($GteqTotalWorksiowtk)echo "<tr bgcolor=#FFDDDD><td colspan=4 align=right><b>Total Expense till $edate is Tk. ".number_format($GteqTotalWorksiowtk,2)."</b></td></tr>";
}?>
<? function humanReport_summary($siow,$dayesGone,$duration,$project){
include("config.inc.php");
if($SESS_DBNAME)
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
else
	global $db;
	
$sqls = "SELECT * from `dma` WHERE dmasiow='$siow' AND dmaItemCode BETWEEN '70-00-000' AND '99-99-999'";
//echo $sqlp;
$sqlruns= mysqli_query($db, $sqls);

 while($redma= mysqli_fetch_array($sqlruns)){ 

   	 $duration=$duration;//round((strtotime($cd)-strtotime($sd))/(84000));
	// echo $duration.'-';
	// echo $dayesGone.'-';
	 $dayesGone=$dayesGone;//abs(round((strtotime($d)-strtotime($sd))/(84000)));
	 if($dayesGone>$duration){
//	 echo $redma[dmaQty].' Hr. (100%)';
	 }
	 else if($dayesGone<0)	 ;// echo "0 Hr. (0%)";
      else{    
   	 $perdayQty=$redma[dmaQty]/$duration;
	 $qty=round($dayesGone*$perdayQty);
	 $pqty = round(($qty*100)/$redma[dmaQty]); 
//     echo "$qty Hr. ( $pqty% )";
	 }

   //$empTotalWorksiow =empTotalWorksiow($redma[dmaItemCode],$siow);
   $empTotalWorksiowp=(($empTotalWorksiow*100)/3600)/$redma[dmaQty];
   
  // $empTotalWorksiowtk =empTotalWorksiow($redma[dmaItemCode],$siow)*$redma[dmaRate];
   $empTotalWorksiowtk =($empTotalWorksiow/3600)*$redma[dmaRate];
   $empTotalWorksiowptk=($empTotalWorksiowtk*100)/( $redma[dmaQty]*$redma[dmaRate]);
   
   $empTotalWorksiow = sec2hms($empTotalWorksiow/3600,$padHours=false);
   //$empTotalWorksiowp = sec2hms($empTotalWorksiowp/3600,$padHours=false);   
//   echo "$empTotalWorksiow Hr. (".number_format($empTotalWorksiowp)." %)";
   
     
  // echo "Tk. ".number_format($empTotalWorksiowtk)." (".number_format($empTotalWorksiowptk)." %)";
   $GtempTotalWorksiowtk=$GtempTotalWorksiowtk+$empTotalWorksiowtk;
   $GtempTotalWorksiowptk=   $GtempTotalWorksiowptk+$empTotalWorksiowptk;
   
} //function
if($GtempTotalWorksiowtk)echo "<tr bgcolor=#DDDDFF><td colspan=4 align=right><b>Total Expense till $edate is Tk. ".number_format($GtempTotalWorksiowtk,2)."</b></td></tr>";
 } //function?>

<?
function materialReport($siow,$dayesGone,$duration,$project,$ed){
include("config.inc.php");
if($SESS_DBNAME)
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
else
	global $db;
$sqls = "SELECT * from `dma` WHERE dmasiow='$siow' AND dmaItemCode<'50-00-000'";
// echo $sqls;
$sqlruns= mysqli_query($db, $sqls);

 while($redma= mysqli_fetch_array($sqlruns)){ 
?>
   <tr>
		 <td></td>
   <td  ><? echo '<font class=out>'.$redma[dmaItemCode].'</font>';
   $temp = itemDes($redma[dmaItemCode]);
   echo '  <i>'.$temp[des].', '.$temp[spc].'</i>';
   ?></td>
   <td align="right"><? //echo $redma[dmaQty],'=';
    //$d=formatDate($d,'Y-m-d');

   	 $duration=$duration;//round((strtotime($cd)-strtotime($sd))/(84000));
	// echo $duration.'-';
	// echo $dayesGone.'-';
	 $dayesGone=$dayesGone;//abs(round((strtotime($d)-strtotime($sd))/(84000)));
	 if($dayesGone>$duration){
	 echo round($redma[dmaQty]).' '.$temp[unit].' (100%)';
	 }
	 else if($dayesGone<0)	  echo "0 $temp[unit] (0%)";
      else{
		if($duration>0){	$perdayQty=$redma[dmaQty]/$duration;} else $perdayQty=0;
		 $qty=round($dayesGone*$perdayQty);
		 $pqty = round(($qty*100)/$redma[dmaQty]); 
		 echo round($qty)." $temp[unit] ($pqty%)";
	 }
	 ?>
	</td>
   <td align="right"><? 

echo $issuedQty=issuedQty($siow,$redma[dmaItemCode],$redma[dmaQty],$temp[unit],$project,$ed);
		
		 ?></td>
   <td align="right"><? 
																						echo issuedEx($siow,$redma[dmaItemCode],$redma[dmaQty],$temp[unit],$project,$ed);?></td>
	<?php
		global $chk7;
		if($chk7){?>
			<td align="right">
		 		<?php echo issuedQty($siow,$redma[dmaItemCode],$redma[dmaQty],$temp[unit],$project,$ed,true); ?>
		 </td>
		<?php }	 ?>
		 
   </tr>
 
<? }?>

<?  } //function?>


<? function equipmentReport($siow,$dayesGone,$duration,$project,$ed){?>
<? 
		 include("config.inc.php");
if($SESS_DBNAME)
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
else
	global $db;
	
$sqls = "SELECT * from `dma` WHERE dmasiow='$siow' AND dmaItemCode BETWEEN '50-00-000' AND '69-99-999'";
//echo $sqls;
$sqlruns= mysqli_query($db, $sqls);

 while($redma= mysqli_fetch_array($sqlruns)){ 
?>
   <tr bgcolor="#FFDDDD">
		 <td></td>
   <td ><? echo '<font class=out>'.$redma[dmaItemCode].'</font>';
   $temp = itemDes($redma[dmaItemCode]);
   echo '  <i>'.$temp[des].', '.$temp[spc].'</i>';
   ?></td>
   <td align="right"><? //echo $redma[dmaQty],'=';
    //$d=formatDate($d,'Y-m-d');

   	 $duration=$duration;//round((strtotime($cd)-strtotime($sd))/(84000));
	// echo $duration.'-';
	// echo $dayesGone.'-';
	 $dayesGone=$dayesGone;//abs(round((strtotime($d)-strtotime($sd))/(84000)));
	 if($dayesGone>$duration){
	 echo $redma[dmaQty].' Hr. (100%)';
	 }
	 else if($dayesGone<0)	  echo "0 Hr. (0%)";
      else{    
		if($duration>0){ $perdayQty=$redma[dmaQty]/$duration;} else $perdayQty=0;	  
		 $qty=round($dayesGone*$perdayQty);
		 $pqty = round(($qty*100)/$redma[dmaQty]); 
		 echo "$qty Hr. ($pqty%)";
	 }
	 ?>
	</td>
   <td align="right"><?
   
   $eqTotalWorksiow = eqTotalWorkhrsiow($redma[dmaItemCode],$ed,$siow);
   
   $eqTotalWorksiowp=(($eqTotalWorksiow*100)/3600)/$redma[dmaQty];
   
   $eqTotalWorksiowtk =($eqTotalWorksiow/3600)*$redma[dmaRate];
//   echo "+++ ($eqTotalWorksiow/3600)*$redma[dmaRate]; ++";
   $eqTotalWorksiowptk=($eqTotalWorksiowtk*100)/( $redma[dmaQty]*$redma[dmaRate]);
   
   $eqTotalWorksiow = sec2hms($eqTotalWorksiow/3600,$padHours=false);
   //$eqTotalWorksiowp = sec2hms($eqTotalWorksiowp/3600,$padHours=false);   
   echo "$eqTotalWorksiow Hr. (".number_format($eqTotalWorksiowp)."%)";
?>
   </td>
   <td align="right"><? //echo issuedEx($siow,$redma[dmaItemCode],$redma[dmaQty],'Hr.',$project);
   
   echo "Tk. ".number_format($eqTotalWorksiowtk)." (".number_format($eqTotalWorksiowptk)."%)";
   
   ?></td>
		<?php
		global $chk7;
		if($chk7){?>
			<td align="right">
		 		<?php 
				
				  
   $eqTotalWorksiow = eqTotalWorkhrsiow($redma[dmaItemCode],$ed,$siow,true);
   
   $eqTotalWorksiowp=(($eqTotalWorksiow*100)/3600)/$redma[dmaQty];
   
   $eqTotalWorksiowtk =($eqTotalWorksiow/3600)*$redma[dmaRate];
//   echo "+++ ($eqTotalWorksiow/3600)*$redma[dmaRate]; ++";
   $eqTotalWorksiowptk=($eqTotalWorksiowtk*100)/( $redma[dmaQty]*$redma[dmaRate]);
   
   $eqTotalWorksiow = sec2hms($eqTotalWorksiow/3600,$padHours=false);
   //$eqTotalWorksiowp = sec2hms($eqTotalWorksiowp/3600,$padHours=false);   
   echo "$eqTotalWorksiow Hr. (".number_format($eqTotalWorksiowp)."%)";
							
				?>
		 </td>
		<?php }	 ?>

   </tr> 
<? }?>


<? } //function?>

<? function iow_equipmentReport($iow,$project,$ed){
 include("config.inc.php");
if($SESS_DBNAME)
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
else
	global $db;
	
$sqls = "SELECT * from `dma` WHERE dmaiow='$iow' AND dmaItemCode BETWEEN '50-00-000' AND '69-99-999' Order by dmaItemCode ASC";
//echo $sqls;
$sqlruns= mysqli_query($db, $sqls);

 while($redma= mysqli_fetch_array($sqlruns)){
   $eqTotalWorkiow = eqTotalWorkhriow($redma[dmaItemCode],$ed,$iow);
//    echo "<br>$redma[dmaItemCode]=".($eqTotalWorkiow/3600)."*$redma[dmaRate]<br>";
   $eqTotalWorkiowtk+=($eqTotalWorkiow/3600)*$redma[dmaRate];
   }
   return $eqTotalWorkiowtk;
 } //function?>
 
 <? function siow_equipmentReport($siow,$project,$ed){
 include("config.inc.php");
if($SESS_DBNAME)
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
else
	global $db;
	
$sqls = "SELECT * from `dma` WHERE dmasiow='$siow' AND dmaItemCode BETWEEN '50-00-000' AND '69-99-999'";
//echo $sqls;
$sqlruns= mysqli_query($db, $sqls);

 while($redma= mysqli_fetch_array($sqlruns)){ 
   $eqTotalWorksiow = eqTotalWorkhrsiow($redma[dmaItemCode],$ed,$siow);
   $eqTotalWorksiowtk+=($eqTotalWorksiow/3600)*$redma[dmaRate];
   }
   return $eqTotalWorksiowtk;
 } //function?>
 
 
<? function humanReport($siow,$dayesGone,$duration,$project,$ed){
include("config.inc.php");
if($SESS_DBNAME)
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
else
	global $db;
	
$sqls = "SELECT * from `dma` WHERE dmasiow='$siow' AND dmaItemCode BETWEEN '70-00-000' AND '97-99-999'";
//echo $sqlp;
$sqlruns= mysqli_query($db, $sqls);

 while($redma= mysqli_fetch_array($sqlruns)){ 
?>
   <tr bgcolor="#DDDDFF">
		 <td></td>
   <td ><? echo '<font class=out>'.$redma[dmaItemCode].'</font>';
   $temp = itemDes($redma[dmaItemCode]);
   echo '  <i>'.$temp[des].', '.$temp[spc].'</i>';
   ?></td>
   <td align="right"><? //echo $redma[dmaQty],'=';
    //$d=formatDate($d,'Y-m-d');

   	 $duration=$duration;//round((strtotime($cd)-strtotime($sd))/(84000));
	// echo $duration.'-';
	// echo $dayesGone.'-';
	 $dayesGone=$dayesGone;//abs(round((strtotime($d)-strtotime($sd))/(84000)));
	 if($dayesGone>$duration){
	 echo $redma[dmaQty].' Hr. (100%)';
	 }
	 else if($dayesGone<0)	  echo "0 Hr. (0%)";
      else{   
	  if($duration>0){ $perdayQty=$redma[dmaQty]/$duration; } else $perdayQty=0;	  

	 $qty=round($dayesGone*$perdayQty);
	 $pqty = round(($qty*100)/$redma[dmaQty]); 
     echo round($qty)." Hr. ($pqty%)";
	 }
	 ?>
	</td>
   <td align="right"><?
   $empTotalWorksiow =empTotalWorksiow($redma[dmaItemCode],$siow,$ed,0);
   $empTotalWorksiowp=(($empTotalWorksiow*100)/3600)/$redma[dmaQty];
   
  // $empTotalWorksiowtk =empTotalWorksiow($redma[dmaItemCode],$siow)*$redma[dmaRate];
   $empTotalWorksiowtk =($empTotalWorksiow/3600)*$redma[dmaRate];
   $empTotalWorksiowptk=($empTotalWorksiowtk*100)/( $redma[dmaQty]*$redma[dmaRate]);
   
   $empTotalWorksiow = sec2hms($empTotalWorksiow/3600,$padHours=false);
   //$empTotalWorksiowp = sec2hms($empTotalWorksiowp/3600,$padHours=false);   
   echo "$empTotalWorksiow Hr. (".number_format($empTotalWorksiowp)." %)";
   
   // echo issuedQty($siow,$redma[dmaItemCode],$redma[dmaQty],'Hr.',$project);?></td>
   <td align="right"><? //echo issuedEx($siow,$redma[dmaItemCode],$redma[dmaQty],'Hr.',$project);
   
   echo "Tk. ".number_format($empTotalWorksiowtk)." (".number_format($empTotalWorksiowptk)." %)";
   
   ?></td>
		 <?php
		global $chk7;
		if($chk7){?>
			<td align="right">
		 		<?php 
				
				  $empTotalWorksiow =empTotalWorksiow($redma[dmaItemCode],$siow,$ed,1);
   $empTotalWorksiowp=(($empTotalWorksiow*100)/3600)/$redma[dmaQty];
   
			
   $empTotalWorksiowtk =($empTotalWorksiow/3600)*$redma[dmaRate];
   $empTotalWorksiowptk=($empTotalWorksiowtk*100)/( $redma[dmaQty]*$redma[dmaRate]);
   
   $empTotalWorksiow = sec2hms($empTotalWorksiow/3600,$padHours=false);
			
   echo "$empTotalWorksiow Hr. (".number_format($empTotalWorksiowp)." %)";
   
   
				
				?>
		 </td>
		<?php }	 ?>
   </tr>
<?  }?>


<? } //function?>

<? function iow_humanReport($iow,$project,$ed){
	
include("config.inc.php");
if($SESS_DBNAME)
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
else
	global $db;
	
$sqls = "SELECT * from `dma` WHERE dmaiow='$iow' AND dmaItemCode BETWEEN '70-00-000' AND '97-99-999' group by dmaItemCode";
//echo $sqlp;
$sqlruns= mysqli_query($db, $sqls);

 while($redma= mysqli_fetch_array($sqlruns)){ 
   $empTotalWorkiow =empTotalWorkiow($redma[dmaItemCode],$iow,$ed,0);
   
  // $empTotalWorksiowtk =empTotalWorksiow($redma[dmaItemCode],$siow)*$redma[dmaRate];
   $empTotalWorkiowtk+=($empTotalWorkiow/3600)*$redma[dmaRate];
 }
 
 return $empTotalWorkiowtk;
} //function?>
<? function siow_humanReport($siow,$project,$ed){
include("config.inc.php");
if($SESS_DBNAME)
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
else
	global $db;
	
$sqls = "SELECT * from `dma` WHERE dmasiow='$siow' AND dmaItemCode BETWEEN '70-00-000' AND '97-99-999'";
//echo $sqlp;
$sqlruns= mysqli_query($db, $sqls);

 while($redma= mysqli_fetch_array($sqlruns)){ 
   $empTotalWorksiow =empTotalWorksiow($redma[dmaItemCode],$siow,$ed,0);
   
  // $empTotalWorksiowtk =empTotalWorksiow($redma[dmaItemCode],$siow)*$redma[dmaRate];
   $empTotalWorksiowtk+=($empTotalWorksiow/3600)*$redma[dmaRate];
 }
 
 return $empTotalWorksiowtk;
} //function?>

<? function subcontractorReport($siow,$dayesGone,$duration,$project,$ed){
 include("config.inc.php");
if($SESS_DBNAME)
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
else
	global $db;
	
$sqls = "SELECT * from `dma` WHERE dmasiow='$siow' AND dmaItemCode BETWEEN '95-00-000' AND '99-99-999'";
//echo $sqls;
$sqlruns= mysqli_query($db, $sqls);
 while($redma= mysqli_fetch_array($sqlruns)){ 
?>
   <tr bgcolor="#DDDDFF">
		 <td></td>
   <td  ><? echo '<font class=out>'.$redma[dmaItemCode].'</font>';
   $temp = itemDes($redma[dmaItemCode]);
   echo '  <i>'.$temp[des].', '.$temp[spc].'</i>';
   ?></td>
   <td align="right"><? //echo $redma[dmaQty],'=';
    //$d=formatDate($d,'Y-m-d');

   	 $duration=$duration;//round((strtotime($cd)-strtotime($sd))/(84000));
	// echo $duration.'-';
	// echo $dayesGone.'-';
	 $dayesGone=$dayesGone;//abs(round((strtotime($d)-strtotime($sd))/(84000)));
	 if($dayesGone>$duration){
	 echo $redma[dmaQty].' '.$temp[unit].' (100%)';
	 }
	 else if($dayesGone<0)	  echo "0 $temp[unit] (0%)";
      else{    
		if($duration>0){ $perdayQty=$redma[dmaQty]/$duration;} else $perdayQty=0;	  
   	 
		 $qty=round($dayesGone*$perdayQty);
		 $pqty = round(($qty*100)/$redma[dmaQty]); 
		 echo round($qty)." $temp[unit] ($pqty%)";
	 }
	 ?>
	</td>
   <td align="right"><? echo subContractorissuedQty($siow,$redma[dmaItemCode],$redma[dmaQty],$temp[unit],$project,$ed);?></td>
   <td align="right"><? echo subContractorissuedEx($siow,$redma[dmaItemCode],$redma[dmaQty],$temp[unit],$project,$ed);?></td>
		 <?php
		global $chk7;
		if($chk7){?>
			<td align="right">
		 		<? echo subContractorissuedQty($siow,$redma[dmaItemCode],$redma[dmaQty],$temp[unit],$project,$ed,true);?>
		 </td>
		<?php }	 ?>
   </tr>
<? }?>

<? } //function?>
<? 
function subContractorissuedQty($siow,$item,$qty,$unit,$pp,$ed,$exactDate=false){
$iss=0;
$issQty=0;
include("config.inc.php");
if($SESS_DBNAME)
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
else
	global $db;
	
$sqls1 = "SELECT sum(qty) as total from `subut` WHERE siow='$siow' AND itemCode='$item' and pcode='$pp'";	
if($exactDate==false)$sqls1.=" AND edate<='$ed'";
elseif($exactDate==true) $sqls1.=" AND edate='$ed'";
// echo $sqls1;
$sqlruns1= mysqli_query($db, $sqls1);
$out = mysqli_fetch_array($sqlruns1);
if($out[total]>0){
	$iss=$out[total];
	$issQty = number_format(($iss*100)/$qty);
	}
// echo "===$iss*100/==$qty======<br>";
return number_format($iss)." $unit ($issQty %)";
}

?>
<? 

function iow_subContractorissuedEx($iow,$pp,$ed){
$iss=0;
$issQty=0;

include("config.inc.php");
if($SESS_DBNAME)
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
else
	global $db;
	
$sqls1 = "SELECT sum(qty*rate) as total from `subut` WHERE iow='$iow' and pcode='$pp' AND edate<='$ed'";
//echo $sqls1;
$sqlruns1= mysqli_query($db, $sqls1);
$out = mysqli_fetch_array($sqlruns1);
$iss=$out[total];
return $iss;
}
function siow_subContractorissuedEx($siow,$pp,$ed){
$iss=0;
$issQty=0;

include("config.inc.php");
if($SESS_DBNAME)
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
else
	global $db;
	
$sqls1 = "SELECT sum(qty*rate) as total from `subut` WHERE siow='$siow' and pcode='$pp' AND edate<='$ed'";
//echo $sqls1;
$sqlruns1= mysqli_query($db, $sqls1);
$out = mysqli_fetch_array($sqlruns1);
$iss=$out[total];
return $iss;
}


function subContractorissuedEx($siow,$item,$qty,$unit,$pp,$ed){
$iss=0;
$issQty=0;

include("config.inc.php");
if($SESS_DBNAME)
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
else
	global $db;
	
$sqls1 = "SELECT sum(qty*rate) as total from `subut` WHERE siow='$siow' AND itemCode='$item' and pcode='$pp' AND edate<='$ed'";
//echo $sqls1;
$sqlruns1= mysqli_query($db, $sqls1);
$out = mysqli_fetch_array($sqlruns1);
if($out[total]>0){
	$iss=$out[total];
	}
//echo "*iss:$iss*";
$sqls11 = "SELECT (dmaQty*dmaRate) as total from `dma` WHERE dmasiow='$siow' AND dmaItemCode='$item'";
//echo $sqls11;
$sqlruns11= mysqli_query($db, $sqls11);
$outp = mysqli_fetch_array($sqlruns11);
if($outp[total]>0){
	$issp=$outp[total];
//	echo "*issp=$issp*";
   $issp=number_format(($iss*100)/$issp);	
	}	

return "Tk. ".number_format($iss)." ($issp %)";
}
?>
<? 
function issuedQty($siow,$item,$qty,$unit,$pp,$ed,$exactDate=false){
$iss=0;
$issQty=0;

include("config.inc.php");
if($SESS_DBNAME)
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
else
	global $db;
	
$sqls1 = "SELECT sum(issuedQty) as total from `issue$pp` WHERE siowId='$siow' AND itemCode='$item'";
$sqls1.=$exactDate==false ? " AND issueDate<='$ed'" :  " AND issueDate='$ed'" ;
// echo $sqls1;
$sqlruns1= mysqli_query($db, $sqls1);
$out = mysqli_fetch_array($sqlruns1);
if($out[total]>0){
	$iss=$out[total];
	$issQty = number_format(($iss*100)/$qty);
	}
	
// 	echo "<br>($iss*100)/$qty)<br>";
	
	global $zeroDecimal;
	if($zeroDecimal==1){
		$iss=number_format($iss);
		return $iss." $unit ($issQty%)";
	}else
		return round($iss)." $unit ($issQty%)";
}

?>

<? 
function iow_issuedEx($iow,$pp,$ed){
$iss=0;
$issQty=0;

include("config.inc.php");
if($SESS_DBNAME)
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
else
	global $db;
	
$sqls1 = "SELECT sum(issuedQty*issueRate) as total from `issue$pp` WHERE iowId='$iow' AND issueDate<='$ed'";
//echo $sqls1;
$sqlruns1= mysqli_query($db, $sqls1);
$out = mysqli_fetch_array($sqlruns1);
$iss=$out[total];
return $iss;
}
function siow_issuedEx($siow,$pp,$ed){
$iss=0;
$issQty=0;

include("config.inc.php");
if($SESS_DBNAME)
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
else
	global $db;
	
$sqls1 = "SELECT sum(issuedQty*issueRate) as total from `issue$pp` WHERE siowId='$siow' AND issueDate<='$ed'";
//echo $sqls1;
$sqlruns1= mysqli_query($db, $sqls1);
$out = mysqli_fetch_array($sqlruns1);
$iss=$out[total];
return $iss;
}

function issuedEx($siow,$item,$qty,$unit,$pp,$ed){
$iss=0;
$issQty=0;
	global $db;
	
$sqls1 = "SELECT sum(issuedQty*issueRate) as total from `issue$pp` WHERE siowId='$siow' AND itemCode='$item' AND issueDate<='$ed'";
// echo $sqls1;
$sqlruns1= mysqli_query($db, $sqls1);
$out = mysqli_fetch_array($sqlruns1);
if($out[total]>0){
	$iss=$out[total];
	}
//echo "*iss:$iss*";
$sqls11 = "SELECT (dmaQty*dmaRate) as total from `dma` WHERE dmasiow='$siow' AND dmaItemCode='$item'";
// echo $sqls11;
$sqlruns11= mysqli_query($db, $sqls11);
$outp = mysqli_fetch_array($sqlruns11);
if($outp[total]>0){
	$issp=$outp[total];
//	echo "*issp=$issp*";
// 	echo "<br>($iss*100)/$issp)<br>";
   $issp=number_format(($iss*100)/$issp);	
	}	

return "Tk. ".number_format($iss)." ($issp%)";
}
?>
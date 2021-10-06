
<? function materialReport($siow,$dayesGone,$duration,$project,$ed){
include('../includes/config.inc.php');
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sqls = "SELECT * from `dma` WHERE dmasiow='$siow' AND dmaItemCode<'50-00-000'";
//echo $sqls;
$sqlruns= mysql_query($sqls);

 while($redma= mysql_fetch_array($sqlruns)){ 
?>
   <tr>
   <td  ><? echo '<font class=out>'.$redma[dmaItemCode].'</font>';
   $temp = itemDes($redma[dmaItemCode]);
   echo '  '.$temp[des].', '.$temp[spc].'';
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
   	 $perdayQty=$redma[dmaQty]/$duration;
	 $qty=round($dayesGone*$perdayQty);
	 $pqty = round(($qty*100)/$redma[dmaQty]); 
     echo "$qty $temp[unit] ( $pqty% )";
	 }
	 ?>
	</td>
   <td align="right"><? echo issuedQty($siow,$redma[dmaItemCode],$redma[dmaQty],$temp[unit],$project,$ed);?></td>
   <td align="right"><? echo issuedEx($siow,$redma[dmaItemCode],$redma[dmaQty],$temp[unit],$project,$ed);?></td>
   </tr>
 <tr><td colspan="4" bgcolor="#AACCFF" height="2"></td></tr>   
<? }?>

<? } //function?>


<? function equipmentReport($siow,$dayesGone,$duration,$project,$ed){?>
<? include('../includes/config.inc.php');
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sqls = "SELECT * from `dma` WHERE dmasiow='$siow' AND dmaItemCode BETWEEN '50-00-000' AND '69-99-999'";
//echo $sqlp;
$sqlruns= mysql_query($sqls);

 while($redma= mysql_fetch_array($sqlruns)){ 
?>
   <tr bgcolor="#FFDDDD">
   <td ><? echo '<font class=out>'.$redma[dmaItemCode].'</font>';
   $temp = itemDes($redma[dmaItemCode]);
   echo '  '.$temp[des].', '.$temp[spc].'';
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
   	 $perdayQty=$redma[dmaQty]/$duration;
	 $qty=round($dayesGone*$perdayQty);
	 $pqty = round(($qty*100)/$redma[dmaQty]); 
     echo "$qty Hr. ( $pqty% )";
	 }
	 ?>
	</td>
   <td align="right"><?
   
   $eqTotalWorksiow = eqTotalWorkhrsiow($redma[dmaItemCode],$ed,$siow);
   $eqTotalWorksiowp=(($eqTotalWorksiow*100)/3600)/$redma[dmaQty];
   
   $eqTotalWorksiowtk =($eqTotalWorksiow/3600)*$redma[dmaRate];
   $eqTotalWorksiowptk=($eqTotalWorksiowtk*100)/( $redma[dmaQty]*$redma[dmaRate]);
   
   $eqTotalWorksiow = sec2hms($eqTotalWorksiow/3600,$padHours=false);
   //$eqTotalWorksiowp = sec2hms($eqTotalWorksiowp/3600,$padHours=false);   
   echo "$eqTotalWorksiow Hr. (".number_format($eqTotalWorksiowp)."%)";
?>
   </td>
   <td align="right"><? //echo issuedEx($siow,$redma[dmaItemCode],$redma[dmaQty],'Hr.',$project);
   
   echo "Tk. ".number_format($eqTotalWorksiowtk)." (".number_format($eqTotalWorksiowptk)."%)";
   
   ?></td>

   </tr>
 <tr><td colspan="4" bgcolor="#AACCFF" height="2"></td></tr>   
<? }?>


<? } //function?>


<? function humanReport($siow,$dayesGone,$duration,$project,$ed){
include('../includes/config.inc.php');
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sqls = "SELECT * from `dma` WHERE dmasiow='$siow' AND dmaItemCode BETWEEN '70-00-000' AND '89-99-999'";
//echo $sqlp;
$sqlruns= mysql_query($sqls);

 while($redma= mysql_fetch_array($sqlruns)){ 
?>
   <tr bgcolor="#DDDDFF">
   <td ><? echo '<font class=out>'.$redma[dmaItemCode].'</font>';
   $temp = itemDes($redma[dmaItemCode]);
   echo '  '.$temp[des].', '.$temp[spc].'';
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
   	 $perdayQty=$redma[dmaQty]/$duration;
	 $qty=round($dayesGone*$perdayQty);
	 $pqty = round(($qty*100)/$redma[dmaQty]); 
     echo "$qty Hr. ( $pqty% )";
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
   </tr>
 <tr><td colspan="4" bgcolor="#AACCFF" height="2"></td></tr>   
<? }?>


<? } //function?>
<? function subcontractorReport($siow,$dayesGone,$duration,$project,$ed){
include('../includes/config.inc.php');
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sqls = "SELECT * from `dma` WHERE dmasiow='$siow' AND dmaItemCode BETWEEN '95-00-000' AND '99-99-999'";
//echo $sqls;
$sqlruns= mysql_query($sqls);
 while($redma= mysql_fetch_array($sqlruns)){ 
?>
   <tr bgcolor="#DDDDFF">
   <td  ><? echo '<font class=out>'.$redma[dmaItemCode].'</font>';
   $temp = itemDes($redma[dmaItemCode]);
   echo '  '.$temp[des].', '.$temp[spc].'';
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
   	 $perdayQty=$redma[dmaQty]/$duration;
	 $qty=round($dayesGone*$perdayQty);
	 $pqty = round(($qty*100)/$redma[dmaQty]); 
     echo "$qty $temp[unit] ( $pqty% )";
	 }
	 ?>
	</td>
   <td align="right"><? echo subContractorissuedQty($siow,$redma[dmaItemCode],$redma[dmaQty],$temp[unit],$project,$ed);?></td>
   <td align="right"><? echo subContractorissuedEx($siow,$redma[dmaItemCode],$redma[dmaQty],$temp[unit],$project,$ed);?></td>
   </tr>
 <tr><td colspan="4" bgcolor="#AACCFF" height="2"></td></tr>   
<? }?>

<? } //function?>
<? 
function subContractorissuedQty($siow,$item,$qty,$unit,$pp,$ed){
$iss=0;
$issQty=0;

include('../includes/config.inc.php');
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sqls1 = "SELECT sum(qty) as total from `subut` WHERE siow='$siow' AND itemCode='$item' and pcode='$pp' AND edate<='$ed'";
//echo $sqls1;
$sqlruns1= mysql_query($sqls1);
$out = mysql_fetch_array($sqlruns1);
if($out[total]>0){
	$iss=$out[total];
	$issQty = number_format(($iss*100)/$qty,2);
	}
return "$iss $unit ($issQty %)";
}

?>
<? 
function subContractorissuedEx($siow,$item,$qty,$unit,$pp,$ed){
$iss=0;
$issQty=0;

include('../includes/config.inc.php');
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sqls1 = "SELECT sum(qty*rate) as total from `subut` WHERE siow='$siow' AND itemCode='$item' and pcode='$pp' AND edate<='$ed'";
//echo $sqls1;
$sqlruns1= mysql_query($sqls1);
$out = mysql_fetch_array($sqlruns1);
if($out[total]>0){
	$iss=$out[total];
	}
//echo "*iss:$iss*";
$sqls11 = "SELECT (dmaQty*dmaRate) as total from `dma` WHERE dmasiow='$siow' AND dmaItemCode='$item'";
//echo $sqls11;
$sqlruns11= mysql_query($sqls11);
$outp = mysql_fetch_array($sqlruns11);
if($outp[total]>0){
	$issp=$outp[total];
//	echo "*issp=$issp*";
   $issp=number_format(($iss*100)/$issp);	
	}	

return "Tk. ".number_format($iss)." ($issp %)";
}
?>
<? 
function issuedQty($siow,$item,$qty,$unit,$pp,$ed){
$iss=0;
$issQty=0;

include('../includes/config.inc.php');
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sqls1 = "SELECT sum(issuedQty) as total from `issue$pp` WHERE siowId='$siow' AND itemCode='$item' AND issueDate<='$ed'";
//echo $sqls1;
$sqlruns1= mysql_query($sqls1);
$out = mysql_fetch_array($sqlruns1);
if($out[total]>0){
	$iss=$out[total];
	$issQty = number_format(($iss*100)/$qty);
	}
return "$iss $unit ($issQty%)";
}

?>

<? 
function issuedEx($siow,$item,$qty,$unit,$pp,$ed){
$iss=0;
$issQty=0;

include('../includes/config.inc.php');
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sqls1 = "SELECT sum(issuedQty*issueRate) as total from `issue$pp` WHERE siowId='$siow' AND itemCode='$item' AND issueDate<='$ed'";
//echo $sqls1;
$sqlruns1= mysql_query($sqls1);
$out = mysql_fetch_array($sqlruns1);
if($out[total]>0){
	$iss=$out[total];
	}
//echo "*iss:$iss*";
$sqls11 = "SELECT (dmaQty*dmaRate) as total from `dma` WHERE dmasiow='$siow' AND dmaItemCode='$item'";
//echo $sqls11;
$sqlruns11= mysql_query($sqls11);
$outp = mysql_fetch_array($sqlruns11);
if($outp[total]>0){
	$issp=$outp[total];
//	echo "*issp=$issp*";
   $issp=number_format(($iss*100)/$issp);	
	}	

return "Tk. ".number_format($iss)." ($issp%)";
}
?>
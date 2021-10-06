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
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);
	
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
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);
	
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
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);
	
$sqls = "SELECT * from `dma` WHERE dmasiow='$siow' AND dmaItemCode<'35-00-000'";
// echo $sqls;
$sqlruns= mysqli_query($db, $sqls);

 while($redma= mysqli_fetch_array($sqlruns)){
?>
   <tr>
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
		if($duration>0){	$perdayQty=$redma[dmaQty]/$duration;} else $perdayQty=0;
		 $qty=round($dayesGone*$perdayQty);
		 $pqty = round(($qty*100)/$redma[dmaQty]); 
		 echo "$qty $temp[unit] ( $pqty% )";
	 }
	 ?>
	</td>
   <td align="right"> <? echo issuedQty($siow,$redma[dmaItemCode],$redma[dmaQty],$temp[unit],$project,$ed);?></td>
  <!-- <td align="right"><? echo issuedEx($siow,$redma[dmaItemCode],$redma[dmaQty],$temp[unit],$project,$ed);?></td>-->
  <td align="right">
	<?php
		$isf=isIssueFeture($project,$redma[dmaItemCode],$ed,$redma[dmaiow]);
// if(( || $siow!='3861'))
if($isf!=0){
	echo "<i>Updated $isf.</i>";
}else{
?>
  	<a target="_blank" href="./store/site_issue.php?siow=<? echo $siow;?>&itemCode=<? echo $redma[dmaItemCode];?>&edate=<? echo $ed;?>"> issue</a>
<?php } ?>		 
	</td>
   
   </tr>
 <tr><td colspan="4" bgcolor="#AACCFF" height="1"></td></tr>   
<? }?>

<? } //function?>


<? function equipmentReport($siow,$dayesGone,$duration,$project,$ed){?>
<? include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);
	
$sqls = "SELECT * from `dma` WHERE dmasiow='$siow' AND dmaItemCode BETWEEN '50-00-000' AND '69-99-999'";
//echo $sqls;
$sqlruns= mysqli_query($db, $sqls);

 while($redma= mysqli_fetch_array($sqlruns)){ 
?>
   <tr bgcolor="#FFDDDD">
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
   
   //echo "Tk. ".number_format($eqTotalWorksiowtk)." (".number_format($eqTotalWorksiowptk)."%)";
if($project=='002'){
;

}
else  { 
$sqlquery="SELECT * from eqproject 
where pCode='$project' AND itemCode='$redma[dmaItemCode]' 
 AND  status>=1 AND (('$ed' BETWEEN receiveDate AND edate) OR ('$ed' >= receiveDate AND edate='0000-00-00' ))
 ORDER by assetId ASC ";
//echo $sqlquery.'<br>';
 $sql= mysqli_query($db, $sqlquery);
 while($re=mysqli_fetch_array($sql)){ 
  $type=eqType($re[assetId]);
 if(eq_isPresent($re[assetId],$re[itemCode],$ed)>=1){   
echo "<a target=_blank href='./equipment/eqUtilization.php?siow=$siow&eqId=$re[assetId]
&itemCode=$re[itemCode]&eqType=$type&edate=$ed&posl=$re[posl]'>";
  if($type=='L')  { echo eqpId_local($re[assetId],$re[itemCode]); $type='L';}
		else {echo eqpId($re[assetId],$re[itemCode]); $type='H'; }
echo "</a><br>";
}//if Present
}//while
}

?>
   </td>

   </tr>
 <tr><td colspan="4" bgcolor="#AACCFF" height="2"></td></tr>   
<? }?>


<? } //function?>


<? function humanReport($siow,$dayesGone,$duration,$project,$ed){
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);
	
$sqls = "SELECT * from `dma` WHERE dmasiow='$siow' AND dmaItemCode BETWEEN '70-00-000' AND '97-99-999'";
//echo $sqlp;
$sqlruns= mysqli_query($db, $sqls);

 while($redma= mysqli_fetch_array($sqlruns)){ 
?>
   <tr bgcolor="#DDDDFF">
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
   
   //echo "Tk. ".number_format($empTotalWorksiowtk)." (".number_format($empTotalWorksiowptk)." %)";
   
$sqlquery="SELECT attendance.*,employee.designation FROM attendance,employee".
" where attendance.location='$project' AND attendance.edate='$ed'".
" AND action in('P','HP') AND attendance.empId=employee.empId".
" AND employee.designation='$redma[dmaItemCode]' ORDER by designation ASC ";
//echo "$sqlquery<br>";
 $sql= mysqli_query($db, $sqlquery);
 while($re=mysqli_fetch_array($sql)){
 $designation =$re[designation];
 $empId=empId($re[empId],$designation);?>
<a target="_blank" href="./employee/empUtilization.php?siow=<? echo $siow;?>&empId=<? echo $re[empId];?>
&empD=<? echo $re[designation];?>&empType=H&edate=<? echo $ed;?>">
<? echo  empName($re[empId]).'</a><br>';
}   
   
   ?></td>
   </tr>
 <tr><td colspan="4" bgcolor="#AACCFF" height="2"></td></tr>   
<? }?>


<? } //function?>
<? function subcontractorReport($siow,$dayesGone,$duration,$project,$ed){

 include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);
	
$sqls = "SELECT * from `dma` WHERE dmasiow='$siow' AND dmaItemCode BETWEEN '99-00-000' AND '99-99-999'";
// echo $sqls;
$sqlruns= mysqli_query($db, $sqls);
$f=1;
 while($redma= mysqli_fetch_array($sqlruns)){ 
 if($f==1)
 echo " <tr><td colspan=4 bgcolor=#9900FF height=10 align=center><font class=englishhead>Sub-Contract</font></td></tr>";  
 $f=2; 
?>
   <tr>
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
		 echo "$qty $temp[unit] ( $pqty% )";
	 }
	 ?>
	</td>
   <td align="right"><? echo subContractorissuedQtyRound($siow,$redma[dmaItemCode],$redma[dmaQty],$temp[unit],$project,$ed);?></td>
   <!--<td align="right"><? echo subContractorissuedEx($siow,$redma[dmaItemCode],$redma[dmaQty],$temp[unit],$project,$ed);?></td> -->
   <td align="right"> 
<?    $sql="SELECT * from porder where status='1' AND 
TRIM(`itemCode`) ='$redma[dmaItemCode]' AND location='$project'
 ORDER by posl ASC";
// echo $sql;
$sqlq=mysqli_query($db, $sql);
$i=1;
while($sb=mysqli_fetch_array($sqlq)){
	$qty=subWork_Poremain($redma[dmaItemCode],$sb[posl]);
	if($qty<=0)continue;
		 ?>
<a target="_blank" href="./subcontractor/subConUtilization.php?siow=<? echo $siow;?>
&itemCode=<? echo $sb[itemCode];?>&posl=<? echo $sb[posl];?>&edate=<? echo $ed;?>
&rate=<? echo $sb[rate];?>"><? echo poVendorName($sb[posl]).'-'.viewPosl($sb[posl]); ?></a>
<br>
<? }?>
   </td>
   </tr>
 <tr><td colspan="4" bgcolor="#9900FF" height="1"></td></tr>   
<? }?>

<? } //function?>
<? 
function subContractorissuedQty($siow,$item,$qty,$unit,$pp,$ed){
$iss=0;
$issQty=0;

include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);
	
$sqls1 = "SELECT sum(qty) as total from `subut` WHERE siow='$siow' AND itemCode='$item' and pcode='$pp' AND edate<='$ed'";
//echo $sqls1;
$sqlruns1= mysqli_query($db, $sqls1);
$out = mysqli_fetch_array($sqlruns1);
if($out[total]>0){
	$iss=$out[total];
	$issQty = number_format(($iss*100)/$qty,2);
	}
return "$iss $unit ($issQty %)";
}

function subContractorissuedQtyRound($siow,$item,$qty,$unit,$pp,$ed){
$iss=0;
$issQty=0;

include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);
	
$sqls1 = "SELECT sum(qty) as total from `subut` WHERE siow='$siow' AND itemCode='$item' and pcode='$pp' AND edate<='$ed'";
//echo $sqls1;
$sqlruns1= mysqli_query($db, $sqls1);
$out = mysqli_fetch_array($sqlruns1);
if($out[total]>0){
	$iss=$out[total];
	$issQty = number_format(($iss*100)/$qty,2);
	}
return round($iss,0) ." $unit ($issQty %)";
}

?>
<? 
function subContractorissuedEx($siow,$item,$qty,$unit,$pp,$ed){
$iss=0;
$issQty=0;

include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);
	
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
function issuedQty($siow,$item,$qty,$unit,$pp,$ed){
$iss=0;
$issQty=0;
global $viewTemp;
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);
	
$sqls1 = "SELECT sum(issuedQty) as total, sum(issuedQtyTemp) as totalTemp from `issue$pp` WHERE siowId='$siow' AND itemCode='$item' AND issueDate<='$ed'";
// echo $sqls1;
$sqlruns1= mysqli_query($db, $sqls1);
$out = mysqli_fetch_array($sqlruns1);
	
if($out[total]>0){
	$iss=number_format($out[total]);
	$original_issue=$out[total];
	$issQty = number_format(($original_issue*100)/$qty);
	}
if($viewTemp==1 && $out[totalTemp]>0)return "$iss $unit ($issQty%)<br>".'<p style="padding:5px; margin:3px; color:#fff; background:#f00; border-radius:5px;display: inline-block;">Pending</p>'." $out[totalTemp] $unit (".number_format(($out["totalTemp"]*100)/$qty)."%)";
return "$iss $unit ($issQty%)";
}

?>

<? 
function issuedEx($siow,$item,$qty,$unit,$pp,$ed){
$iss=0;
$issQty=0;

include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);
	
$sqls1 = "SELECT sum(issuedQty*issueRate) as total from `issue$pp` WHERE siowId='$siow' AND itemCode='$item' AND issueDate<='$ed'";
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

return "Tk. ".number_format($iss)." ($issp%)";
}
?>
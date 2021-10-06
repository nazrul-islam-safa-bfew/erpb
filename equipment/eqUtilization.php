<?
if(!$_GET[posl]){
	echo "<h1>Error, POSL Not Found!</h1>";
	exit;
}

include("../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
include("../includes/session.inc.php");
include_once("../includes/myFunction.php");
include_once("../includes/myFunction1.php");
include_once("../includes/eqFunction.inc.php");
require_once("../keys.php");
//echo "<!----".$au."---->";
$t_req=$REMOTE_ADDR;
$supervisor=$loginUname;
echo "<br>Supervisor/Equipment Co-Ordinator Id:$supervisor<br>";

/*$time=mktime(0,0,0, date("m"),date("d"),date("y"));
$todat = date("Y-m-d",$time);
*/
$todat=todat();
//echo $todat;

$edate1=$edate;//  $edate1=formatDate($edate,'Y-m-d');
$invoiceLock=isEqPresentRequiredToLock($_GET[posl],$_GET[edate]); // true=lock
	 
if($invoiceLock){
	echo "<span style='color: #fff;background: #00f;border-radius: 10px;    display: inline-block;padding: 2px;'>Invoice Verified</span>";
	exit;
}
?>
<html>

<head>
<SCRIPT language=JavaScript src="../js/shimul.js" type=text/JavaScript></SCRIPT>
<link href="../style/basestyles.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Language" content="en-us">
<meta name="author" content="<? echo $mauthor;?>">
<meta name="copyright" content="<? echo $tt;?>">
<meta name="keywords" content="<? echo $kword;?>">
<META NAME="description" CONTENT="<? echo $des;?>">

<title>BFEW :: equipment utilization </title>
<script language="JavaScript">
function checkMe(remainTime,h1,m1,h2,m2,eh,em,xh,xm){
/*alert(h1.value);
alert(m1.value);
*/
//alert(eh.value);
//alert('Remain:'+remainTime);
if(h1.value && m1.value && h2.value && m2.value && eh.value && em.value && xh.value && xm.value )
{
var hv1=parseInt(h1.value) ;
var mv1=parseInt(m1.value) ;
var hv2=parseInt(h2.value) ;
var mv2=parseInt(m2.value) ;

var eh1=parseInt(eh.value) ;
var em1=parseInt(em.value) ;
var xh1=parseInt(xh.value) ;
var xm1=parseInt(xm.value) ;


//alert('Eh'+eh1+'Em'+em1+'Xh'+xh1+'Xm'+xm1);

//alert('h'+hv1+'m'+mv1+'Xh'+hv2+'Xm'+mv2);

var totaletime=eh1*60+em1;
var totalxtime=xh1*60+xm1;

var totaletime1=hv1*60+mv1;
var totalxtime1=hv2*60+mv2;

//alert(totaletime1+'='+totaletime);

if(totaletime1<totaletime && totaletime1>totalxtime ) { 
alert('err1='+totaletime1+'='+totaletime);
}
else if(totalxtime1>totalxtime && totalxtime1<totaletime) { 
alert('err2='+totalxtime1+'='+totalxtime);
}
else {
var t1=hv1*3600+mv1*60;
var t2=hv2*3600+mv2*60;
var timeDuration=t2-t1;

//alert('timeDuration:'+timeDuration);

if(timeDuration>remainTime){
 alert('Time exceeds');
 h1.value=m1.value=h2.value=m2.value='';
 }
}
//else alert('Please Fill all fields');

// var totalPrice = parseFloat(f11) + parseFloat(f12);
}
}

</script>
</head>
<body  topmargin="1" leftmargin="5" rightmargin="5" bgcolor="#FFFFFF" >

<? 
	
$edate1=$edate;//  $edate1=formatDate($edate,'Y-m-d');
?>
<? if($delete==1){$sql="DELETE from equt where id=$id";
//echo $sql;



mysqli_query($db, $sql);
}
else {
?>

<? 
if($chk==1){
$rr=0;
//$edate1=formatDate($edate,'Y-m-d');
$edate1=$edate;
/*------------*/

$stime=$eh.':'.$em;
$etime=$xh.':'.$xm;

if(eq_isConflictUtilizedAtt($eqId,$itemCode,$edate1,$stime,$etime,$eqType)){
echo errMsg('Your ');
$rr=1;
}
$beganing="$eh:$em:00";
$ending="$xh:$xm:00";
	for($i=1;$i<$n;$i++){
		if(${h1.'_'.$i}){
				$stime=${h1.'_'.$i}.':'.${m1.'_'.$i};
				$etime=${h2.'_'.$i}.':'.${m2.'_'.$i};
   			if(eq_isUtilized($eqId,$itemCode,$edate1,$stime,$etime,$eqType)){
					$err[$i]=1;  $rr=1;continue; 
				}
			  // echo "<br>******$stime--$etime******<br>";
             if((strtotime($etime)-strtotime($stime))<0)  {$err[$i]=1; $rr=1;}		 
             if( (strtotime($stime)< strtotime($beganing)) OR  (strtotime($etime) > strtotime($ending)) )  {$err[$i]=1;	$rr=1; }		 			 
			  $t=60+(strtotime($etime)-strtotime($stime));
	  		
			if(${iow.$i}=='-1' OR ${iow.$i}=='0' OR ${iow.$i}=='')$reQty=86400;
			else $reQty= eq_RemainHr($itemCode,${iow.$i},${siow.$i});
            // if($t>${reQty.$i})  {
			
			 if($t>$reQty)  {
			  //echo '<br>********'.${reQty.$i}.'********<br>'; 
			  $err[$i]=1;	$rr=1; 			  
			  }		 
			for($j=$i+1;$j<$n;$j++){
				$stime1=${h1.'_'.$j}.':'.${m1.'_'.$j};
				$etime1=${h2.'_'.$j}.':'.${m2.'_'.$j};

				 if(strtotime($stime)>=strtotime($stime1) AND strtotime($stime)<=strtotime($etime1)
				   OR strtotime($etime)>=strtotime($stime1) AND strtotime($etime)<=strtotime($etime1)){ 
						 $err[$i]=1;$rr=1; 
				   }
				}	//for j	
		}
  }//for i
/*****************/

$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	


	
//echo "RRR:$rr";
$j=1;
if($rr!=1)	{ 
	for($i=1;$i<$n;$i++){
	 
		if(${h1.'_'.$i}){
		
		$stime=${h1.'_'.$i}.':'.${m1.'_'.$i};
		$etime=${h2.'_'.$i}.':'.${m2.'_'.$i};

    	  // echo "<br>IOW==${iow.$i}==$i<br>";
			  		
		if(${iow.$i}>=1){

		if(eq_isUtilized($eqId,$itemCode,$edate1,$stime,$etime,$eqType)){
		echo "there is some Problem please click back... <a href='javascript: history.go(-1)'>Back</a>";
		 exit; }		
		
		$reQty= eq_RemainHr($itemCode,${iow.$i},${siow.$i});
		if($reQty<=0)break;
		$sql = "INSERT INTO `equt` ( `id`,`eqId`,`itemCode`,`iow` ,`siow` ,`stime`,`etime`,`details`,
		`edate`,pcode,posl,supervisor) 
		VALUES ('', '$eqId','$itemCode', '${iow.$i}', '${siow.$i}', '$stime', '$etime', '${details.$i}',
		 '$edate1','$loginProject','$posl','$supervisor')";
		//echo $sql.'<br>';
		}
        elseif(${iow.$i}=='-1'){  $sql = "INSERT INTO `equt` ( `id` , `eqId` ,`itemCode`, `iow` , `siow` , `stime` , 
		`etime` , `details` , `edate`,pcode,posl,supervisor ) 
		VALUES ('', '$eqId','$itemCode', '-1', '-1', '$stime', '$etime',
		 '${details.$i}', '$edate1','$loginProject','$posl','$supervisor')";
		//echo $sql.'<br>';
		}
		else{
		$sql = "INSERT INTO `equt` ( `id` , `eqId` ,`itemCode`, `iow` , `siow` , `stime` , `etime` , `details` ,
		 `edate`,pcode,posl,supervisor ) 
		 VALUES ('', '$eqId','$itemCode', '', '', '$stime', '$etime', '${details.$i}',
		  '$edate1','$loginProject','$posl','$supervisor')";
		//echo $sql.'<br>';
		} 
		//echo $sql.'<br>';
		mysqli_query($db, $sql);
	
		}//if
	}//for
	
	$sql="UPDATE `eqattendance` SET `stime` = '$eh:$em:00',`etime` = '$xh:$xm:00' WHERE".
	" `eqId` ='$eqId' AND itemCode='$itemCode'AND `edate` = '$edate1'" ;
    //echo $sql.'<br>';
	$sqlq=mysqli_query($db, $sql);
	
}//if
}//top if
}//else
?>
<form name="equt" action="./eqUtilization.php?<? echo "siow=$siow&eqId=$eqId&itemCode=$itemCode&edate=$edate&eqType=$eqType&posl=$posl";?>" method="post">
Utilization Date: <? echo date("d-m-Y",strtotime($edate));?>
<br>

Selected equipment: <?
if($eqType=='H')
 echo eqpId($eqId,$itemCode); 
else if($eqType=='L')
 echo eqpId_local($eqId,$itemCode); 
 
 $tt=itemDes($itemCode);
 echo ' , '.$tt[des].' '.$tt[spc];
  ?>
<table align="center" width="98%" border="3"  bgcolor="#FFFFFF" bordercolor="CC9999" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td colspan="5" align="right" valign="top"><font class='englishhead'>equipment utilization entry form</font></td>
</tr>
<tr>
 <th width="100">From</th>
 <th width="380">To</th> 
 <th width="100">Remaining Time</th>  
 <th>SIOW Code</th>
</tr>

<tr bgcolor="#FFFFCC" >
      <td align="center"> 
        <? if(!$chk){$t=eqExTime($eqId,$itemCode,$eqType,$edate1);
      $eh= $t[eh];
      $em= $t[em];
      $xh= $t[xh];
      $xm= $t[xm];	  	  	  
  }
   ?>
        <input name="eh" value="<? echo $eh;?>"  size="2" maxlength="2" onKeyUp="return autoTab(this, 2, event);" <?php if($_SESSION["loginDesignation"]=="Task Supervisor")echo "readonly='readonly'"; ?>> :
	  <input name="em" value="<? echo $em;?>"  size="2" maxlength="2" onKeyUp="return autoTab(this, 2, event);" <?php if($_SESSION["loginDesignation"]=="Task Supervisor")echo "readonly='readonly'"; ?>>
  </td>
  <td align="center">
	  <input name="xh" value="<? echo $xh;?>" size="2" maxlength="2" onKeyUp="return autoTab(this, 2, event);" <?php if($_SESSION["loginDesignation"]=="Task Supervisor")echo "readonly='readonly'"; ?>> :
	  <input name="xm" value="<? echo $xm;?>"  size="2" maxlength="2" <?php if($_SESSION["loginDesignation"]=="Task Supervisor")echo "readonly='readonly'"; ?>>
  </td>
  <td align="right"> </td>  
  <td>Total Present </td>  
 </tr>

<? include("../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$temp=explode('-',$assetId);
$sqlppg = "SELECT iow.*,siow.*,dma.dmasiow from iow,`siow`,dma WHERE siow.siowId=$siow AND ".
"iow.iowprojectCode='$loginProject' AND siow.siowId=dma.dmasiow AND".
" dmaItemCode='$itemCode' AND  siow.iowId=iow.iowId AND iowStatus LIKE 'Approved%'
 AND supervisor='$supervisor' ORDER by iow.iowId ASC";
//echo $sqlppg;
$sqlrunppg= mysqli_query($db, $sqlppg);
$i=1;
 while($typelpg= mysqli_fetch_array($sqlrunppg))
{
$ck=isExpiredSIOW($typelpg[siowId],$ed);
$reQty=eq_RemainHr($itemCode,$typelpg[iowId],$typelpg[siowId]);
//echo $typelpg[siowId].'RemainQty: '.$reQty;
//$reQty=1;
if($reQty>0){
//echo "C=$chk=R:$rr";
?>
<tr <? if($ck) echo  " bgcolor=#FFFFD5";?> <? if($err[$i]==1) echo "bgcolor=#FFCCCC";?>>
<? if($ck) echo "<td colspan=2 align=center><font class=out> Completion Date Expired.</font></td>";else {?>
  <td align="center">
	  <input name="h1_<? echo $i?>" value="<? if($chk && $rr) echo ${h1.'_'.$i};?>"  size="2" maxlength="2" onKeyUp="return autoTab(this, 2, event);"> :
	  <input name="m1_<? echo $i?>" value="<? if($chk && $rr) echo ${m1.'_'.$i};?>"  size="2" maxlength="2" onKeyUp="return autoTab(this, 2, event);">
  </td>
  <td align="center">
		<div style="display:inline-block;">
			<input name="h2_<? echo $i?>" value="<? if($chk && $rr) echo ${h2.'_'.$i};?>" size="2" maxlength="2" onKeyUp="return autoTab(this, 2, event);"> :
			<input name="m2_<? echo $i?>" value="<? if($chk && $rr) echo ${m2.'_'.$i};?>"  size="2" maxlength="2">
		</div>	
		<div align="right" style="display:inline-block;">Details: <input type="text" name="details<?php echo $i; ?>" width="100" size="25" value="" placeholder="Which part of work?"></input></div> 
  </td>
  <input type="hidden" name="iow<? echo $i;?>" value="<? echo $typelpg[iowId];?>">
  <input type="hidden" name="siow<? echo $i;?>" value="<? echo $typelpg[siowId];?>">  
  <input type="hidden" name="reQty<? echo $i;?>" value="<? echo $reQty;?>">    
	<? $i++;}?>    
	<td align="right">
		<? echo sec2hms($reQty/3600,$padHours=false);?> Hrs.</div>
	</td>  

  <td>
<? echo "<font color=006600>$typelpg[iowCode]</font>  $typelpg[iowDes]";
echo "<br><font color=006600>$typelpg[siowCode]</font>  $typelpg[siowName]";
?>

    </td>  
 </tr>
 <? 
 }
 }
	
if($_SESSION["loginDesignation"]!="Task Supervisor"){
	?>

 <tr bgcolor="#99CCFF">
  <td align="center">
	  <input name="h1_<? echo $i?>" value="<? if($chk && $rr) echo ${h1.'_'.$i};?>"  size="2" maxlength="2" onKeyUp="return autoTab(this, 2, event);"> :
	  <input name="m1_<? echo $i?>" value="<? if($chk && $rr) echo ${m1.'_'.$i}; ?>"  size="2" maxlength="2" onKeyUp="return autoTab(this, 2, event);">
  </td>
  <td align="center">
	  <input name="h2_<? echo $i?>" value="<? if($chk && $rr) echo ${h2.'_'.$i};?>" size="2" maxlength="2" onKeyUp="return autoTab(this, 2, event);"> :
	  <input name="m2_<? echo $i?>" value="<? if($chk && $rr) echo ${m2.'_'.$i};?>"  size="2" maxlength="2">
  </td>
  
  <td align="right">Work Break</td>  
  <td><input type="text" name="details<? echo $i;?>" width="100" size="40" value="Lunch">
    <input type="hidden" name="iow<? echo $i;?>" value="0">
  <input type="hidden" name="siow<? echo $i;?>" value="0">  
</td>  
 </tr>
 <? } //not task supervisor
	$i++;?>
<?  if($loginDesignation=='Site Equipment Co-ordinator'){?>
 <tr bgcolor="#FF9999">
  <td align="center">
	  <input name="h1_<? echo $i?>" value="<? if($chk && $rr) echo ${h1.'_'.$i};?>"  size="2" maxlength="2" onKeyUp="return autoTab(this, 2, event);"> :
	  <input name="m1_<? echo $i?>" value="<? if($chk && $rr) echo ${m1.'_'.$i};?>"  size="2" maxlength="2" onKeyUp="return autoTab(this, 2, event);">
  </td>
  <td align="center">
	  <input name="h2_<? echo $i?>" value="<? if($chk && $rr) echo ${h2.'_'.$i};?>" size="2" maxlength="2" onKeyUp="return autoTab(this, 2, event);"> :
	  <input name="m2_<? echo $i?>" value="<? if($chk && $rr) echo ${m2.'_'.$i};?>"  size="2" maxlength="2">
  </td>

  <td align="right">Maintenence Break</td>  
  <td><input type="text" name="details<? echo $i;?>" width="100" size="40" value="Maintenence Break">
  <input type="hidden" name="iow<? echo $i;?>" value="-1">
  <input type="hidden" name="siow<? echo $i;?>" value="-1">  
  
  </td>  
 </tr>
<? }?>
</table>
<p align="center"><input type="button" name="Save" value="Save" onClick="if(eh.value!='00' && eh.value!='0') {equt.chk.value=1; equt.submit();} else alert('ERROR'); "></p>
<input type="hidden" name="n" value="<? echo ++$i;?>">
<input type="hidden" name="chk" value="0">
</form>
<table align="center" width="98%" border="3" bgcolor="#FFFFFF"  bordercolor="CC9999" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td colspan="5" align="right" valign="top"><font class='englishhead'> utilization report of <? echo myDate($edate1);?></font></td>
</tr>
<tr>
 <th>From</th>
 <th>To</th> 
 <th>IOW Name</th>
 <th>SIOW Name</th>
  <th width="100">Action</th> 
</tr>
<? 
$temp=explode('-',$assetId);
include("../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

$sqlut = "SELECT * FROM equt WHERE eqId='$eqId' AND itemCode='$itemCode' AND edate='$edate1' AND pcode='$loginProject' ORDER by stime ASC";
//echo $sqlut;
$sqlqut= mysqli_query($db, $sqlut);
$i=1;
 while($reut= mysqli_fetch_array($sqlqut))
{?>
<tr <? if($i%2==0) echo "bgcolor=#EFEFEF";?> >
  <td align="center"> <? echo $reut[stime]?> </td>
  <td align="center"> <? echo $reut[etime]?> </td>
  <td align="left"> <? 
	  if($reut[iow]>=1){
	  echo '<font color=006600>'.iowCode($reut[iow]).'</font> ';
	  echo iowName($reut[iow]);
	  } 
	  elseif($reut[iow]==-1) echo 'Maintenence Break';
	  else echo 'Work Break';
	  ?> 
  </td>
  <td align="left"> <? 
  if($reut[siow]>=1){
  echo '<font color=006600>'.viewsiowCode($reut[siow]).'</font> ';
  echo siowName($reut[siow]);
  }else echo $reut[details];?> </td>
  <td align="center">
		<?php  if(($reut["iow"]>0 && $_SESSION["loginDesignation"]=="Task Supervisor") || ($reut["iow"]<1 && $_SESSION["loginDesignation"]=="Site Equipment Co-ordinator")){ ?>
		<a href="<? echo $PHP_SELF."?siow=$siow&eqId=$eqId&itemCode=$itemCode&edate=$edate&delete=1&id=$reut[id]&eqType=$eqType&posl=$posl";?>">[ Delete ]</a></td>  
		<?php } ?>
 </tr>
 <? $i++;}?>
</table>
<p align="center">
<? 
$dailyworkBreakt=eq_dailyworkBreak($eqId,$itemCode,$edate1,$eqType,$loginProject);
$dailyBreakDown=eq_dailyBreakDown($eqId,$itemCode,$edate1,$eqType,$loginProject);

$toDaypresent=eq_toDaypresent($eqId,$itemCode,$edate1,$eqType,$loginProject)-$dailyworkBreakt;

$workt=eq_dailywork($eqId,$itemCode,$edate1,$eqType,$loginProject);
if(date('D',strtotime($edate1))=='Fri')
 $overtimet = $toDaypresent-(4*3600);
else 
	$overtimet = $toDaypresent-(8*3600);

if($overtimet<0) $overtimet=0;
$idlet=$toDaypresent-$workt-$dailyBreakDown;
  if($idlet<0) $idlet=0;
?>
Present: <?   echo sec2hms($toDaypresent/3600,$padHours=false);?>
 Worked: <?   $work= sec2hms($workt/3600,$padHours=false);   echo $work.' Hrs.,    ';  ?>
 (Break Down: <font class=out><?   $dailyBreakDown= sec2hms($dailyBreakDown/3600,$padHours=false);  
  echo $dailyBreakDown.' Hrs.,    ';  ?> </font> Feature module)
 Overtime: <?  $overtime=sec2hms($overtimet/3600,$padHours=false);  echo $overtime;  ?>; 
 Idle: <?  $idle=sec2hms($idlet/3600,$padHours=false);  echo $idle.' Hrs.,   ';  ?>
 </p>

</body>	  
</html>
<?
include("../includes/session.inc.php");
include_once("../includes/myFunction.php");
include_once("../includes/myFunction1.php");
include_once("../includes/empFunction.inc.php");
require_once("../keys.php");
$supervisor=$loginUname;
echo "<br>Supervisor Id:$supervisor<br>";
//echo "<!----".$au."---->";
$t_req=$REMOTE_ADDR;
/*$time=mktime(0,0,0, date("m"),date("d"),date("y"));
$todat = date("Y-m-d",$time);
*/
$todat=todat();
//echo $todat;
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

<title>BFEW :: employee utilization </title>
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

<? /*
  require_once("../includes/myFunction.php"); 
  require_once("../includes/myFunction1.php");   */
  $edate1=formatDate($edate,'Y-m-d');

?>
<? if($delete==1){ $sql="DELETE from emput where id=$id";
//echo $sql;
mysqli_query($db, $sql);
}
else {
?>

<? 
if($chk==1){
$edate1=formatDate($edate,'Y-m-d');
/*------------*/

$stime=$eh.':'.$em;
$etime=$xh.':'.$xm;

if(isConflictUtilizedAtt($empId,$empD,$edate1,$stime,$etime,$empType)){
	echo errMsg('Your ');
	$rr=1;
}
			
$beganing="$eh:$em:00";
$ending="$xh:$xm:00";
//echo "N=$n<br>";
	for($i=1;$i<$n;$i++){
		if(${h1.'_'.$i}){
				$stime=${h1.'_'.$i}.':'.${m1.'_'.$i};
				$etime=${h2.'_'.$i}.':'.${m2.'_'.$i};
   			if(emp_isUtilized($empId,$empD,$edate1,$stime,$etime,$empType)){$err[$i]=1; $rr=1;continue; }
			  // echo "<br>******$stime--$etime******<br>";
             if((strtotime($etime)-strtotime($stime))<0)  {$err[$i]=1;	$rr=1;}		 
             if( (strtotime($stime)< strtotime($beganing)) OR  (strtotime($etime) > strtotime($ending)) )  {$err[$i]=1;	$rr=1;}		 			 
			  $t=60+(strtotime($etime)-strtotime($stime));
			  $reQty= empRemainHr($empD,${iow.$i},${siow.$i});
             //if($t>${reQty.$i})  {
			 if($t>$reQty)  {
			  //echo '<br>********'.${reQty.$i}.'********<br>'; 
			  $err[$i]=1;	$rr=1;			  
			  }		 
			for($j=$i+1;$j<$n;$j++){
				$stime1=${h1.'_'.$j}.':'.${m1.'_'.$j};
				$etime1=${h2.'_'.$j}.':'.${m2.'_'.$j};

				 if(strtotime($stime)>=strtotime($stime1) AND strtotime($stime)<=strtotime($etime1)
				   OR strtotime($etime)>=strtotime($stime1) AND strtotime($etime)<=strtotime($etime1))
				   {//echo "<br>Error: $stime1--$etime1--<br>";
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
		if(${iow.$i}){
		$reQty= empRemainHr($empD,${iow.$i},${siow.$i});
		if($reQty<=0) break;
		$sql = "INSERT INTO `emput` ( `id` , `empId` ,`empType`,`designation`, 
		`iow` , `siow` , `stime` , `etime` , `details` , `edate`,pcode, supervisor)
		 VALUES ('', '$empId','$empType','$empD', '${iow.$i}', '${siow.$i}', 
		 '$stime', '$etime', '', '$edate1','$loginProject','$supervisor')";
		//echo $sql.'<br>';
		}
		else{
		$sql = "INSERT INTO `emput` ( `id` , `empId` ,`empType`,`designation`, 
		`iow` , `siow` , `stime` , `etime` , `details` , `edate`,pcode,supervisor ) ".
						   "VALUES ('', '$empId','$empType','$empD', '', '', 
						   '$stime', '$etime', '$details', '$edate1','$loginProject','$supervisor')";
		//echo 'ele :'.$sql.'<br>';
		} 
		mysqli_query($db, $sql);
	
		}//if
	}//for
	
	$sql="UPDATE `attendance` SET `stime` = '$eh:$em:00',`etime` = '$xh:$xm:00' WHERE `empId` =$empId AND `edate` = '$edate1'" ;
    //echo $sql.'<br>';
	$sqlq=mysqli_query($db, $sql);
}//if
}//top if
}//else
?>

<form name="equt" action="./empUtilization.php?<? echo "empId=$empId&empD=$empD&edate=$edate&empType=$empType";?>" method="post">
Utilization Date: <? echo $edate;?>
<br>

Selected employee: <? if($empType=='L') echo local_empId($empId,$empD).', '.local_empName($empId).', '.hrDesignation($empD);
 else echo empId($empId,$empD).', '.empName($empId).', '.hrDesignation($empD);
?>
<table align="center" width="98%" border="3"  bgcolor="#FFFFFF" bordercolor="CC9999" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td colspan="5" align="right" valign="top"><font class='englishhead'>employee utilization entry form</font></td>
</tr>
<tr>
 <th width="100">From</th>
 <th width="100">To</th> 
 <th width="100">Remaining Time</th>  
 <th>SIOW Code</th>
</tr>

<tr bgcolor="#FFFFCC" >
  <td align="center">
  <? if(!$chk){$t=empExTime($empId,$empType,$edate1);
      $eh= $t[eh];
      $em= $t[em];
      $xh= $t[xh];
      $xm= $t[xm];	  	  	  
  }
   ?>
	  <input name="eh" value="<? echo $eh;?>"  size="2" maxlength="2" onKeyUp="return autoTab(this, 2, event);"> :
	  <input name="em" value="<? echo $em;?>"  size="2" maxlength="2" onKeyUp="return autoTab(this, 2, event);">
  </td>
  <td align="center">
	  <input name="xh" value="<? echo $xh;?>" size="2" maxlength="2" onKeyUp="return autoTab(this, 2, event);"> :
	  <input name="xm" value="<? echo $xm;?>"  size="2" maxlength="2">
  </td>
  <td align="right"> </td>  
  <td>Total Present </td>  
 </tr>

<? include("../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$temp=explode('-',$assetId);
$sqlppg = "SELECT iow.*,siow.*,dma.dmasiow from iow,`siow`,dma".
" WHERE iow.iowprojectCode='$loginProject' AND siow.siowId=dma.dmasiow AND dmaItemCode='$empD'".
" AND  siow.iowId=iow.iowId AND iowStatus LIKE 'Approved%' AND supervisor='$supervisor' ORDER by iow.iowId ASC";
//echo $sqlppg;
$sqlrunppg= mysqli_query($db, $sqlppg);
$i=1;
 while($typelpg= mysqli_fetch_array($sqlrunppg))
{
$ed=formatDate($edate,'Y-m-d');
$ck=isExpiredSIOW($typelpg[siowId],$ed);
$reQty= empRemainHr($empD,$typelpg[iowId],$typelpg[siowId]);
//echo $typelpg[siowId].'RemainQty: '.$reQty;
//$reQty=1;
if($reQty>0){
//echo "C=$chk=R:$rr";
?>
<tr <? if($ck) echo  " bgcolor=#FFFFD5";?> <? if($err[$i]==1) echo "bgcolor=#FFCCCC";?>>
<? if($ck) echo "<td colspan=2 align=center><font class=out> Completion Date Expired.</font></td>";else {?>
  <td align="center" >
	  <input name="h1_<? echo $i?>" value="<? if($chk && $rr) echo ${h1.'_'.$i};?>"  size="2" maxlength="2" onKeyUp="return autoTab(this, 2, event);"> :
	  <input name="m1_<? echo $i?>" value="<? if($chk && $rr) echo ${m1.'_'.$i};?>"  size="2" maxlength="2" onKeyUp="return autoTab(this, 2, event);">
  </td>
  <td align="center">
	  <input name="h2_<? echo $i?>" value="<? if($chk && $rr) echo ${h2.'_'.$i};?>" size="2" maxlength="2" onKeyUp="return autoTab(this, 2, event);"> :
	  <input name="m2_<? echo $i?>" value="<? if($chk && $rr) echo ${m2.'_'.$i};?>"  size="2" maxlength="2">
  </td>
  <input type="hidden" name="iow<? echo $i;?>" value="<? echo $typelpg[iowId];?>">
  <input type="hidden" name="siow<? echo $i;?>" value="<? echo $typelpg[siowId];?>"> 
  <input type="hidden" name="reQty<? echo $i;?>" value="<? echo $reQty;?>">  
	<? $i++;}?>  
  <td align="right"><? echo sec2hms($reQty/3600,$padHours=false);?> Hrs.

  </td>  

  <td >
<? echo "<font color=006600>$typelpg[iowCode]</font>  $typelpg[iowDes]";
echo "<br><font color=006600>$typelpg[siowCode]</font>  $typelpg[siowName]";
?>

    </td>  

 </tr>
 <? 
 }
 }?>
 <tr bgcolor="#99CCFF">
  <td align="center">
	  <input name="h1_<? echo $i?>" value="<? if($chk && $rr) echo ${h1.'_'.$i};?>"  size="2" maxlength="2" onKeyUp="return autoTab(this, 2, event);"> :
	  <input name="m1_<? echo $i?>" value="<? if($chk && $rr) echo ${m1.'_'.$i};?>"  size="2" maxlength="2" onKeyUp="return autoTab(this, 2, event);">
  </td>
  <td align="center">
	  <input name="h2_<? echo $i?>" value="<? if($chk && $rr) echo ${h2.'_'.$i};?>" size="2" maxlength="2" onKeyUp="return autoTab(this, 2, event);"> :
	  <input name="m2_<? echo $i?>" value="<? if($chk && $rr) echo ${m2.'_'.$i};?>"  size="2" maxlength="2">
  </td>
  <td align="right">Work Break</td>  
  <td><input type="text" name="details" width="100" size="40" value="Lunch"></td>  
 </tr>
</table>
<p align="center"><input type="button" name="Save" value="Save" onClick="if(eh.value!='00' && eh.value!='0') {equt.chk.value=1; equt.submit();} else alert('ERROR'); "></p>
<input type="hidden" name="n" value="<? echo ++$i;?>">
<input type="hidden" name="chk" value="0">
</form>
<table align="center" width="98%" border="3" bgcolor="#FFFFFF"  bordercolor="CC9999" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td colspan="5" align="right" valign="top"><font class='englishhead'>employee utilization report of <? echo myDate($edate1);?></font></td>
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
	
	

$sqlut = "SELECT * FROM emput WHERE empId='$empId' AND designation='$empD' AND edate='$edate1' AND pcode='$loginProject' ORDER by stime ASC";
//echo $sqlut;
$sqlqut= mysqli_query($db, $sqlut);
$i=1;
 while($reut= mysqli_fetch_array($sqlqut))
{?>
<tr <? if($i%2==0) echo "bgcolor=#EFEFEF";?> >
  <td align="center"> <? echo $reut[stime]?> </td>
  <td align="center"> <? echo $reut[etime]?> </td>
  <td align="left"> <? 
  if($reut[iow]){
  echo '<font color=006600>'.iowCode($reut[iow]).'</font> ';
  echo iowName($reut[iow]);
  } else echo 'Work Break';?> </td>
  <td align="left"> <? 
  if($reut[siow]){
  echo '<font color=006600>'.viewsiowCode($reut[siow]).'</font> ';
  echo siowName($reut[siow]);
  }else echo $reut[details];?> </td>
  <td align="center"><a href="<? echo $PHP_SELF."?empId=$empId&empD=$empD&edate=$edate&delete=1&id=$reut[id]&empType=$empType";?>">[ Delete ]</a></td>  
 </tr>
 <? $i++;}?>
</table>
<p align="center">
<? 
$dailyworkBreakt=dailyworkBreak($empId,$edate1,$empType,$loginProject);

$toDaypresent=toDaypresent($empId,$edate1,$empType,$loginProject)-$dailyworkBreakt;

$workt= dailywork($empId,$edate1,$empType,$loginProject);
if(date('D',strtotime($edate1))=='Fri')
 $overtimet = $toDaypresent-(4*3600);
else 
	$overtimet = $toDaypresent-(8*3600);

if($overtimet<0) $overtimet=0;
$idlet=$toDaypresent-$workt;
  if($idlet<0) $idlet=0;
?>
Present: <?   echo sec2hms($toDaypresent/3600,$padHours=false);?>
 Worked: <?   $work= sec2hms($workt/3600,$padHours=false);   echo $work.' Hrs.,    ';  ?>
 Overtime: <?  $overtime=sec2hms($overtimet/3600,$padHours=false);  echo $overtime;  ?>; 
 Idle: <?  $idle=sec2hms($idlet/3600,$padHours=false);  echo $idle.' Hrs.,   ';  ?>
 </p>

</body>	  
</html>
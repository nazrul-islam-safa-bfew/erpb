<?
header('Content-Type: text/html; charset=ISO-8859-1');
include("../includes/session.inc.php");
include("../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
include_once("../includes/myFunction.php");
include_once("../includes/myFunction1.php");
include_once("../includes/subFunction.inc.php");
require_once("../keys.php");
if($loginUname==''){ echo "Please login again"; exit;}
$supervisor=$loginUname;
echo "<br>Supervisor Id:$supervisor<br>";


$poremainQty=$poremain=subWork_Poremain($itemCode,$posl);
if($poremainQty<=0) {
		$sqlpo = "UPDATE porder SET status=2 WHERE posl='$posl' AND itemCode='$itemCode'";
		//echo $sqlpo;
		$sqlQuerypo = mysqli_query($db, $sqlpo);

 echo wornMsg('Your Infromation is saved and there is no Remaining Qty');exit;
 
 }
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
<link href="../style/indexstyle.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Language" content="en-us">
<meta name="author" content="<? echo $mauthor;?>">
<meta name="copyright" content="<? echo $tt;?>">
<meta name="keywords" content="<? echo $kword;?>">
<META NAME="description" CONTENT="<? echo $des;?>">

<title>BFEW :: sub Contractor utilization </title>

</head>
<body  topmargin="1" leftmargin="5" rightmargin="5" bgcolor="#FFFFFF" >

<? /*
  require_once("../includes/myFunction.php"); 
  require_once("../includes/myFunction1.php");   */
 // echo "++Edate=$edate+++<br>";
//  $edate1=formatDate($edate,'Y-m-d');
$edate1=$edate;
?>
<? if($delete==1){ 
$sql="DELETE from subut where id=$id";
//echo $sql;
mysqli_query($db, $sql);

$damount=$dqty*$rate;
$poremain=$poremain+$dqty;

$sqlpo = "UPDATE popayments SET receiveAmount=receiveAmount-'$damount' WHERE posl='$posl'";
//echo $sqlpo;
 mysqli_query($db, $sqlpo);

	if(subWork_Poremain($itemCode,$posl)>0){
		$sqlpo = "UPDATE porder SET status='1' WHERE posl='$posl' AND itemCode='$itemCode' ";
		//echo $sqlpo;
		 mysqli_query($db, $sqlpo);
	}
		

}
elseif($chk) {
	for($i=1;$i<$n;$i++){
	     ${qty.$i}=round(${qty.$i},3);
	     $total+=${qty.$i};
			}
	 if($total>$poremain)	{echo errMsg('Your given Qty is exceeding PO remain qty');}
	 else {	
	for($i=1;$i<$n;$i++){
		if(${qty.$i}){
		
		$reQty=${dmaQty.$i}-subWork_siow($itemCode,${iow.$i},${siow.$i});
		if($reQty<=0) break;
		
			$sql="INSERT INTO `subut` ( `id` ,`posl` ,`qty` , `rate`,`itemCode` , `iow` , `siow` , `details` , `edate` , `pcode`,supervisor ) ".
			" VALUES ('', '$posl','${qty.$i}','$rate' ,'$itemCode', '${iow.$i}'  ,'${siow.$i}' , '', '$edate1', '$loginProject','$supervisor')";
			//echo '<br>'.$sql.'<br>';
			mysqli_query($db, $sql);
		}
	}//for
	 $totalAmount=round($total*$rate,2);
	 //echo "<br>$total==$rate++TotlaAmount=$totalAmount**<br>";

		$sqlpo = "UPDATE popayments SET receiveAmount=receiveAmount+'$totalAmount' WHERE posl='$posl'";
		//echo $sqlpo;
		$sqlQuerypo = mysqli_query($db, $sqlpo);
	 $poremain=$poremain-$total;
	}//else
}
	
?>
<? 
$poremainQty=subWork_Poremain($itemCode,$posl);
if($poremainQty<=0) {
		$sqlpo = "UPDATE porder SET status=2 WHERE posl='$posl' AND itemCode='$itemCode'";
		//echo $sqlpo;
		$sqlQuerypo = mysqli_query($db, $sqlpo);
		echo wornMsg('Your Infromation is saved and there is no Remaining Qty');exit;		
 }
?>
<form name="equt" action="./subConUtilization.php?<? echo "itemCode=$itemCode&edate=$edate&posl=$posl&poremain=$poremain";?>" method="post">
Utilization Date: <? echo $edate;?>
<br>

Selected itemCode: <? $temp=itemDes($itemCode); echo $itemCode.', '.$temp[des].', '.$temp[unit];?>
<br>
PO remaining Qty=<b><?
$poremainQty=subWork_Poremain($itemCode,$posl);
 echo $poremainQty.'</b> '.$temp[unit];
 
?>
<table align="center" width="98%" border="3"  bgcolor="#FFFFFF" bordercolor="CC9999" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td colspan="5" align="right" valign="top"><font class='englishhead'>sub contractor utilization entry form</font></td>
</tr>
<tr>
 <th width="100">Work done Qty</th>
 <th width="100">Work Remain Qty</th>  
 <th>IOW Code</th>
</tr>

<?

$sqlppg = "SELECT iow.*,siow.*,dma.dmasiow,dma.dmaQty from iow,`siow`,dma 
WHERE iow.iowprojectCode='$loginProject'
AND siow.siowId=dma.dmasiow AND dmaItemCode='$itemCode'
AND iow.supervisor='$supervisor'  AND siow.siowId='$siow' 
AND  siow.iowId=iow.iowId AND iowStatus LIKE 'Approved%'";
//echo '<br>'.$sqlppg.'<br>';
$sqlrunppg= mysqli_query($db, $sqlppg);
$i=1;
 while($typelpg= mysqli_fetch_array($sqlrunppg))
{
$reQty=0;
//$reQty= subRemainQty($itemCode,$typelpg[iowId],$typelpg[siowId]);
$reQty=$typelpg[dmaQty]-subWork_siow($itemCode,$typelpg[iowId],$typelpg[siowId]);
$poremainQty=subWork_Poremain($itemCode,$posl);
$reQty=round($reQty,3);
//echo $typelpg[siowId].'RemainQty: '.$reQty;
//$reQty=1;
if($reQty>0){
//echo "C=$chk=R:$rr";
?>
<tr>
  <td><input type="text" name="qty<? echo $i;?>" size="10"  onBlur="if(this.value><? echo $reQty;?> || this.value><? echo $poremainQty;?>) {alert('You are Exceding remaining Qty!!'); this.value=0;}" class="number"></td>
  <td align="right"><? echo $reQty;?>
   <input type="hidden" name="reQty<? echo $i;?>" value="<? echo $reQty;?>">
   <input type="hidden" name="dmaQty<? echo $i;?>" value="<? echo $typelpg[dmaQty];?>">
  <? echo $temp[unit];?></td>  

  <td>
<? echo "<font color=006600>$typelpg[iowCode]</font>  $typelpg[iowDes]";
echo "<br><font color=006600>$typelpg[siowCode]</font>  $typelpg[siowName]";
?>
  <input type="hidden" name="iow<? echo $i;?>" value="<? echo $typelpg[iowId];?>">
  <input type="hidden" name="siow<? echo $i;?>" value="<? echo $typelpg[siowId];?>"> 
    </td>  
 </tr>
 <? $i++;
 }
 }?>
</table>
<p align="center"><input type="button" name="Save" value="Save" onClick="equt.chk.value=1; equt.submit();"></p>
<input type="hidden" name="n" value="<? echo ++$i;?>">
<input type="hidden" name="chk" value="0">
<input type="hidden" name="rate" value="<? echo $rate;?>">
<input type="hidden" name="poremain" value="<? echo $poremain;?>">

</form>
<table align="center" width="98%" border="3" bgcolor="#FFFFFF"  bordercolor="CC9999" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td colspan="5" align="right" valign="top"><font class='englishhead'>subContractor utilization report of <? echo myDate($edate1);?></font></td>
</tr>
<tr>
 <th>Work</th>
 <th>IOW Name</th>
 <th>SIOW Name</th>
  <th width="100">Action</th> 
</tr>
<? 
$temp=explode('-',$assetId);
include("../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
	

$sqlut = "SELECT * FROM subut WHERE itemCode='$itemCode' AND edate='$edate1' AND pcode='$loginProject' ORDER by id ASC";
//echo $sqlut;
$sqlqut= mysqli_query($db, $sqlut);
$i=1;
 while($reut= mysqli_fetch_array($sqlqut))
{?>
<tr <? if($i%2==0) echo "bgcolor=#EFEFEF";?> >
  <td align="center"> <? echo $reut[qty].'  '.$temp[unit];  ?> </td>

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
  <td align="center"><a href="<? echo $PHP_SELF."?itemCode=$itemCode&edate=$edate&delete=1&id=$reut[id]&dqty=$reut[qty]&rate=$rate&posl=$posl&poremain=$poremain";?>">[ Delete ]</a></td>  
 </tr>
 <? $i++;}?>
</table>

</body>	  
</html>
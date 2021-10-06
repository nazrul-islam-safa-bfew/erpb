<form name="searchIOW" action="./index.php?keyword=mddaily+report" method="post">
<table width="60%"  align="center" border="2" bordercolor="#9999CC" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" style="border-collapse:collapse" >
 <tr><td bgcolor="#9999CC" colspan="5" align="center"><font color="#FFFFFF" size="+1">Search</font></td></tr>

 <tr><td>Select Project: 
 <? 
 $ex = array('ALL project');
 echo selectPlist('selectedPcode',$ex,'');
 ?>

</td>
<td >Select IOW: <select name="iow"> <option value="">All IOW</option>
<?
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 
$sqlp = "SELECT `iowCode` from `iow`";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

 while($typel= mysqli_fetch_array($sqlrunp))
{
 echo "<option value='".$typel[iowCode]."'";
 echo ">$typel[iowCode]</option>  ";
 }
?>

	 </select>
</td></tr>
 <? 
 if($status=='') $r3='checked';
 else if($status=='Approved') $r2='checked'; 
 else if($status=='Forward to MD') $r0='checked';  
   else $r1='checked'; 
 
 ?>
 <tr>
 <td  style="border-right: 1px solid #FFFFFF;" ><input type="radio" name="status" <? echo $r1;?> value="Hold">IOW Lagging 10 days</td>
  <td ><input type="radio" name="status" <? echo $r0;?> value="Forward to MD">IOW Lagging 15 days</td>
 </tr>
 <tr>
 <td  style="border-right: 1px solid #FFFFFF;" ><input type="radio" name="status" <? echo $r2;?> value="Approved">Numeric</td>
	 <td><input type="radio" name="status" <? echo $r3;?> value="">Graphic </td>
</tr> 
 <tr>
 <td  style="border-right: 1px solid #FFFFFF;" ><input type="radio" name="status" <? echo $r2;?> value="Approved">IOW Progress</td>
	 <td><input type="radio" name="status" <? echo $r3;?> value="">Resource at hand</td>
</tr> 

 <tr>
 <td colspan="2" align="center" ><input type="submit" name="search" value="Search"></td></tr>
 <tr>
</table>
</form>
<table width="97%"  align="center" border="2" bordercolor="#9999CC" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" style="border-collapse:collapse" >
 <tr bgcolor="#9999CC">
  <th>IOW</th>
  <th>Unit</th>  
  <th>Qty Total</th>  
  <th>Workdone Qty</th>    
  <th>Invoiced Qty</th>      
  <th>Date Start</th>  
  <th>Date Finish</th>    
  <th>Progress</th>    
 </tr>

<? include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

$sql = "SELECT iow.* from `iow` where `iowProjectCode` = '$selectedPcode'  AND `iowCode` = '$iow' ";
//echo $sqliow;
$sqlrun= mysqli_query($db, $sql);
$resultiow=mysqli_fetch_array($sqlrun);
?>

 <tr bgcolor="#EEEEFF">
  <td><? echo $resultiow[iowCode];?></td>
  <td><? echo $resultiow[iowUnit];?></td>
  <td><? echo $resultiow[iowQty];?></td>
  <td>700</td>  
  <td></td>      
  <td><? echo $resultiow[iowSdate];?></td>
  <td><? echo $resultiow[iowCdate];?></td>
  <th>Progress</th>    
 </tr>
<?
$sqlsiow = "SELECT * from `siow` where `siowCode` = '$iow' ";
//echo $sqlsiow;
$sqlrunsiow= mysqli_query($db, $sqlsiow);
while($resultsiow=mysqli_fetch_array($sqlrunsiow)){
?>
 <tr >
  <td><? echo $resultsiow[siowName];?></td>
  <td><? echo $resultsiow[siowUnit];?></td>
  <td><? echo $resultsiow[siowQty];?></td>
  <td>1000</td>  
  <td></td>      
  <td><? echo $resultsiow[siowSdate];?></td>
  <td><? echo $resultsiow[siowCdate];?></td>
  <th>Progress</th>    
 </tr>
 <tr><td colspan="8">
  <table align="right" width="90%" border="1" bordercolor="#FFAAFF" bgcolor="#FFFFFF" cellpadding="3" cellspacing="0" style="border-collapse:collapse" >

<tr bgcolor="#FFEEFF">
  <td>Item Code</td>
  <td>Approved Qty</td>
  <td>Actual Issue Qty</td>  
  <td>Qty at hand</td>    
  <td>Resource at Hand</td>  
</tr>

 <?
$sqlp ="SELECT * FROM `dma` WHERE `dmasiow` LIKE '$resultsiow[siowName]'";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
 while($dmaresult=mysqli_fetch_array($sqlrunp)){
?>
<tr bgcolor="#FFEEFF">
  <td><? echo $dmaresult[dmaItemCode];?></td>
  <td><? echo $dmaresult[dmaQty];?></td>
<? 
$duration = date("j",strtotime($resultsiow[siowCdate])- strtotime($resultsiow[siowSdate]));
$daygone = date("j",strtotime($todat)-strtotime($resultsiow[siowSdate])) - 1;
$dayleft = date("j",strtotime($resultsiow[siowCdate]) - strtotime($todat));

$perday=  $resultsiow[siowQty]/ $duration;
 //echo "duration: $duration<br>DayGone: $daygone <br>Dayleft : $dayleft<br>";
$tilluse = $perday*$daygone;
// echo "perday: $perday<br> Till use: $tilluse";
 
?>

  <td><? $actualissue=133000; echo $actualissue;?></td>
  <td><? $athand=20000; echo $athand;?></td>
  <? 
  $remainingQty= $dmaresult[dmaQty]- $actualissue;
 // echo "remainingQty: $remainingQty<br>";
  $rateIssue = $remainingQty/$dayleft;
 // echo "rateIssue: $rateIssue<br>";  
  $days=  $athand/$rateIssue;
  ?>

  <td> <? printf("%.1f days",$days);  ?></td>  
</tr>
 <? } // damsiow?>
  
  </table>
 </td></tr>
<? }?>
</table>


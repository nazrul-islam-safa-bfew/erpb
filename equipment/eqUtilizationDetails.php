<table align="center" width="600" border="3" bgcolor="#FFFFFF"  bordercolor="CC9999" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td colspan="5" align="right" valign="top"><font class='englishhead'>equipment utilization report of <? echo eqpId($assetId,$itemCode);?></font><br>
<? $temp = itemDes($itemCode); echo $temp[des].', '.$temp[spc];
echo "; Received at ".myDate(eqReceiveDate($itemCode,$assetId));

?>
 </td>
</tr>
<tr>
 <th>Date</th>
 <th>Worked</th> 
 <th>Breakdown</th>
 <th>Idle</th>
</tr>
<? 
$temp=explode('-',$assetId);
include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
	

$sqlut = "SELECT DISTINCT edate FROM equt WHERE assetId='$assetId' AND itemCode='$itemCode' ORDER by edate DESC";
//echo $sqlut;
$sqlqut= mysqli_query($db, $sqlut);
$i=1;
 while($reut= mysqli_fetch_array($sqlqut))
{
  $workt= eqTodayWork($assetId,$itemCode,$reut[edate]);
  $breakDownt=eqBreakBown($assetId,$itemCode,$reut[edate]);

  $work= sec2hms($workt/3600,$padHours=false);
  $breakDown=sec2hms($breakDownt/3600,$padHours=false);
  $idlet=(8*3600)-($workt+$breakDownt);
  if($idlet<0) $idlet=0;
  $idle=sec2hms($idlet/3600,$padHours=false);

?>
<tr <? if($i%2==0) echo "bgcolor=#EFEFEF";?> >
  <td align="center"> <? echo myDate($reut[edate]);?> </td>
  <td align="right"> <? echo $work;?> hrs.</td>
  <td align="right"> <? echo $breakDown;?> hrs.</td>
  <td align="right"> <? echo $idle;?> hrs.</td>
 </tr>
 <? $i++;}?>
</table>

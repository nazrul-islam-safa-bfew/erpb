<table align="center" width="95%" border="3" bgcolor="#FFFFFF"  bordercolor="CC9999" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td colspan="3">
 <form action="./index.php?keyword=local+emp+ut+report+byEmp"  method="post">
  <select name="month" size="1" >
   <option value="" >Select Month</option>
   <option value="01" <? if($month=='01') echo 'selected';?> >January</option>
   <option value="02" <? if($month=='02') echo 'selected';?>>February</option>
   <option value="03" <? if($month=='03') echo 'selected';?>>March</option>
   <option value="04" <? if($month=='04') echo 'selected';?>>April</option>
   <option value="05" <? if($month=='05') echo 'selected';?>>May</option>
   <option value="06" <? if($month=='06') echo 'selected';?>>June</option>
   <option value="07" <? if($month=='07') echo 'selected';?>>July</option>
   <option value="08" <? if($month=='08') echo 'selected';?>>August</option>
   <option value="09" <? if($month=='09') echo 'selected';?>>September</option>
   <option value="10" <? if($month=='10') echo 'selected';?>>October</option>
   <option value="11" <? if($month=='11') echo 'selected';?>>November</option>
   <option value="12" <? if($month=='12') echo 'selected';?>>December</option>
</select>

<select name='empId' size='1'>
<option value="">Select Employee</option>
<? 
include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT itemlist.itemCode,itemlist.itemDes,employee.empId,employee.name from".
" employee,`itemlist` Where itemCode >= '87-00-000' AND itemCode < '99-01-000' AND itemCode=designation AND location='$loginProject' ORDER by designation,empId ASC";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

 while($typel= mysqli_fetch_array($sqlrunp))
{
 echo "<option value='".$typel[empId]."'";

 if($empId==$typel[empId]) echo "SELECTED";
 echo ">".empId($typel[empId],$typel[itemCode])."--$typel[itemDes]--$typel[name]</option>  ";
 }
 ?>
</select>

<input type="submit" value="Go">
</form>

 </td>
 <td colspan="2" align="right" valign="top"><font class='englishhead'>employee utilization report</font></td>
</tr>
<? //echo $sqlp.'<br>';?>
<tr>
 <th width="100">Date</th>
 <th>Present</th>
 <th>Worked</th>
 <th>Over time</th> 
 <th>Idle</th>
</tr>
<? 
if($month){

$fromD="2006-$month-01";
$daysofmonth=daysofmonth($fromD);
$toD="2006-$month-$daysofmonth";

include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
	

//$sqlut = "SELECT * FROM emput WHERE empId='$empId' AND designation='$empD' AND edate='$edate1' AND pcode='$loginProject' ORDER by stime ASC";
$sqlut = "SELECT DISTINCT edate FROM emput WHERE".
" empId='$empId' AND pcode='$loginProject'".
" AND edate BETWEEN '$fromD' AND '$toD'".
" ORDER by edate ASC";
//echo $sqlut;
$sqlqut= mysqli_query($db, $sqlut);
$i=1;
 while($reut= mysqli_fetch_array($sqlqut))
{?>
<tr <? if(date('D',strtotime($reut[edate]))=='Fri') echo "bgcolor=#FFFFCC"; elseif($i%2==0) echo "bgcolor=#EFEFEF";?> >
  <td align="center" ><a href='./employee/local_emputReport_byEmp_detail.php?empId=<? echo $empId;?>&empType=H&edate=<? echo $reut[edate];?>' target='_blank'>
  <? echo myDate($reut[edate]);?></a>

  <?
 $dailyworkBreakt=dailyworkBreak($empId,$reut[edate],'H',$loginProject);

$toDaypresent=toDaypresent($empId,$reut[edate],'H',$loginProject)-$dailyworkBreakt;

$workt= dailywork($empId,$reut[edate],'H',$loginProject);
if(date('D',strtotime($reut[edate]))=='Fri')
 $overtimet = $toDaypresent-(4*3600);
else 
	$overtimet = $toDaypresent-(8*3600);

if($overtimet<0) $overtimet=0;
$idlet=$toDaypresent-$workt;
  if($idlet<0) $idlet=0;
?>

</td>
  <td align="center"> <?   $preset= sec2hms($toDaypresent/3600,$padHours=false);   echo $preset.' Hrs.';  ?></td>
  <td align="center"> <?   $work= sec2hms($workt/3600,$padHours=false);   echo $work.' Hrs.';  ?></td>
  <td align="center"> <?  $overtime=sec2hms($overtimet/3600,$padHours=false);  echo $overtime.' Hrs.';  ?>  </td>
  <td align="center"> <?  $idle=sec2hms($idlet/3600,$padHours=false);  echo $idle.' Hrs.';  ?></td>
 </tr>
 <? $i++;}?>
 <? }?>
</table>

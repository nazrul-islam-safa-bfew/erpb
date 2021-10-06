
<table align="center" width="95%" border="3" bgcolor="#FFFFFF"  bordercolor="CC9999" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td colspan="2">
 <form action="./index.php?keyword=month+attendance+report"  method="post">
 <select name="year">
 <option <? if($year=='2010') echo ' selected ';?> >2010</option>
 <option <? if($year=='2009') echo ' selected ';?> >2009</option>
 <option <? if($year=='2008') echo ' selected ';?> >2008</option>
 <option <? if($year=='2007') echo ' selected ';?> >2007</option>
 <option <? if($year=='2006') echo ' selected ';?> >2006</option>
 </select>
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
	
$sqlp = "SELECT itemlist.itemCode,itemlist.itemDes,employee.empId,employee.name,status from
 employee,`itemlist` Where itemCode >= '70-00-000' AND itemCode < '99-01-000'
 AND itemCode=designation ORDER by designation,empId ASC";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

 while($typel= mysqli_fetch_array($sqlrunp))
{
 echo "<option value='".$typel[empId]."'";

 if($empId==$typel[empId]) echo "SELECTED";
 if($typel[status]=='-2') echo ' class=out ';
 echo " >".empId($typel[empId],$typel[itemCode])."--$typel[itemDes]--$typel[name]</option>  ";
 }
 ?>
</select>

<input type="submit" name="search" value="Go">
</form>

 </td>
 <td colspan="2" align="right" valign="top"><font class='englishhead'>employee utilization report</font></td>
</tr>
<? //echo $sqlp.'<br>';?>
<tr>
 <th width="100">Date</th>
 <th>Action</th>
 <th>Remarks</th>
 <th>Location</th> 
</tr>
<? 
if($search){
if($month){
$fromD="$year-$month-01";
$daysofmonth=daysofmonth($fromD);
$toD="$year-$month-$daysofmonth";
}
else{
$fromD="$year-01-01";
$daysofmonth=daysofmonth($fromD);
$toD="$year-12-31";
}
include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$sqlut = "SELECT * FROM attendance WHERE".
" empId='$empId'".
" AND edate BETWEEN '$fromD' AND '$toD'".
" ORDER by edate ASC";
//echo $sqlut;
$sqlqut= mysqli_query($db, $sqlut);
$i=1;
$sqlr=mysql_num_rows($sqlqut);
 while($reut= mysqli_fetch_array($sqlqut))
{?>
<tr<? if(date('D',strtotime($reut[edate]))=='Fri') echo " bgcolor=#FFFFCC  "; elseif($i%2==0) echo " bgcolor=#EFEFEF ";?> >
	<td align="center" > <? echo myDate($reut[edate]);?></td>
	<td align="center">
   <?
   if($reut[action]=='HA' OR $reut[action]=='HP') echo "<font color=forestgreen font-weight=900>HOLYDAY</font><br>";
    if($reut[action]=='P' OR $reut[action]=='HP') echo "Present<br>$reut[stime]";
        else if($reut[action]=='L') echo 'Leave';
		   else { echo '<font color=#FF0000>Absent</font>';}?>
	</td>
	<td align="center"> <? echo view_AttRemarks($reut[id])?> </td>
	<td><? echo $reut[location];?></td>
</tr>

 <? $i++; 

 }?>

<? }?>
</table>
<a href="./print/print_empMonthlyAttReport.php?project=<? echo $project;?>&month=<? echo $month;?>&empId=<? echo $empId;?>" target="_blank">Print</a>
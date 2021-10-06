
<table align="center" width="95%" border="3" bgcolor="#FFFFFF"  bordercolor="CC9999" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td colspan="2">
 <form action="./index.php?keyword=month+attendance+report"  method="post">
 <select name="year">
	 <option <? if($year=='2020') echo ' selected ';?> >2020</option>
	 <option <? if($year=='2019') echo ' selected ';?> >2019</option>
	 <option <? if($year=='2018') echo ' selected ';?> >2018</option>
	 <option <? if($year=='2017') echo ' selected ';?> >2017</option>
	 <option <? if($year=='2016') echo ' selected ';?> >2016</option>
	 <option <? if($year=='2015') echo ' selected ';?> >2015</option>
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
	
$sqlp = "SELECT itemlist.itemCode,itemlist.itemDes,employee.empId,employee.name,employee.status,employee.location from
 employee,`itemlist` Where itemCode >= '70-00-000' AND itemCode < '99-01-000'
 AND itemCode=designation";
	
if($loginDesignation=="Human Resource Executive")
	$sqlp.=" and employee.location='$loginProject' ";
	
$sqlp.=" ORDER by location,designation,empId ASC";
// echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

 while($typel= mysqli_fetch_array($sqlrunp))
{
if($typel[location]%2 ==1)
	$style="color:#f00";
else
  $style="color:#00f";


 echo "<option style='$style' value='".$typel[empId]."'";
 if($empId==$typel[empId]) echo "SELECTED";
 if($typel[status]=='-2') echo ' class=out ';
 echo " >$typel[location] &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;".empId($typel[empId],$typel[itemCode])."--$typel[itemDes]--$typel[name]</option>  ";
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
 <th width="100">Action</th>
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
	

$sqlut = "SELECT * FROM attendance WHERE".
" empId='$empId'".
" AND edate BETWEEN '$fromD' AND '$toD'".
" ORDER by edate ASC";
//echo $sqlut;
$sqlqut= mysqli_query($db, $sqlut);
$i=1;
$sqlr=mysqli_num_rows($sqlqut);

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
 <? 
 $i++;
 }?>

<? }?>
</table>
<!-- <a href="./print/print_empMonthlyAttReport.php?project=<? echo $project;?>&month=<? echo $month;?>&empId=<? echo $empId;?>" target="_blank">Print</a> -->
<a href="#" target="_blank" onClick='window.print()'>Print</a>
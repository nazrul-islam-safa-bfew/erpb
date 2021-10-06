<table align="center"  width="500" class="human"><tr><td class="humanHd" colspan="2" > attendance report</td></tr>
<? //echo todat();

if($year=='') $year=thisYear();

if($loginProject=='000'){?>


<form action="index.php?keyword=attendance+report" method="post">
<tr><td>select year </td>
<td>
	<select name="year">
<?php
$start = date('Y') - 6;
$end = date('Y');
for($i=$start;$i<=$end;$i++){
echo '<option value="'.$i.'"'.($year == $i ? ' selected="selected"' : '').'>' . $i . '</option>';
}
?>	           
</select>
</td></tr>
<tr><td>Project :</td>
<td>
<select name="project">
<? 
 include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT `pcode`,pname from `project` ORDER by pcode ASC";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
 while($typel= mysqli_fetch_array($sqlrunp))
{
 echo "<option value='".$typel[pcode]."'";
 if($project==$typel[pcode])  echo " SELECTED";
 echo ">$typel[pcode]--$typel[pname]</option>  ";
 }?>
 </select>

</td>
</tr>
<!--
<tr><td>sort by</td><td>
<input type="radio" <? if($s==1 ) echo 'checked';?>  value="1" name="s" >Designation &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" <? if($s==2 || $s=='') echo 'checked';?> value="2" name="s" >Location
</td>
-->
<tr><td class="humanHd_small" colspan="2" align="right"><input type="submit" value="view report" class="human_btn" onmouseover="this.className='human_btnhover'" onmouseout="this.className='human_btn'"></td></tr>
</form>
<? }
else{?>
<form action="index.php?keyword=attendance+report" method="post">
<tr><td>select year</td><td>
<select name="year">
<!--<option <? if($year=='2010') echo ' selected ';?> >2010</option>
<option <? if($year=='2009') echo ' selected ';?> >2009</option>
<option <? if($year=='2008') echo ' selected ';?> >2008</option>
<option <? if($year=='2007') echo ' selected ';?> >2007</option>
<option <? if($year=='2006') echo ' selected ';?> >2006</option>-->
<?php
$start = date('Y');
$end = date('2000');
for($i=$start;$i>=$end;$i--){
echo '<option value="'.$i.'"'.($year == $i ? ' selected="selected"' : '').'>' . $i . '</option>';
}
?>
</select>
</td></tr>
<tr><td class="humanHd_small" colspan="2" align="right"><input type="submit" value="view report" class="human_btn" onmouseover="this.className='human_btnhover'" onmouseout="this.className='human_btn'"></td></tr>

</form>

<? }

?>
</table>
<br /><br />
<table align="center" width="98%" class="human">
<tr >
 <td height="30" class="humanHd_small">employee</td> 
 <td align=center class="humanHd_small">Leave</td> 
 <td align=center class="humanHd_small">Absent</td> 
<?  if($loginProject=='000') echo " <td align=center class=humanHd_small>Current Location</td>"; ?>
</tr>
<?
$from=date("Y-m-d",mktime(0,0,0,1,1,$year));
$temp=explode('-',$todat);
$toyear=$temp[0];
if($toyear!=$year){$todat="$year-12-31";}




include("./config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$sql="SELECT * FROM employee 
WHERE   salaryType in ('salary','Wages Monthly','Wages Monthly Master Roll') 
AND status=0";

if($loginProject=='000') 
$sql.=" AND location='$project'";
else $sql.=" AND location='$loginProject'";

if($s==1 AND $loginProject='000') $sql.=" ORDER by designation ASC"; 

else  $sql.=" ORDER by location,designation ASC ";  
  
//echo $sql.'<br>';
$sqlquery=mysqli_query($db, $sql);
$i=1;
while($sqlresult=mysqli_fetch_array($sqlquery)){

//$dd = date('Y-m-d',time()-84600);
//$dd = date('Y-m-d',time());
//$todat=todat();
$totalWorking=totalWork($from,$todat,$sqlresult[location]);
$totalPresent = totalPresent($sqlresult[empId],$from,$todat);
$totalAbsent = totalAbsent($sqlresult[empId],$from,$todat);
$leaveTaken=totalLeave($sqlresult[empId],$from,$todat);
$totalHolidayWork = totalHolidatWork($sqlresult[empId],$from,$todat);

?>

<tr <? if($i%2==0) echo 'bgcolor=#E9D1D1';?> >
 <td> <? echo empId($sqlresult[empId],$sqlresult[designation]);?><br>

	 <a target="_blank" href="./index.php?keyword=emp+attendance+report&year=<? echo $year;?>&empId=<? echo $sqlresult[empId];?>"><? echo $sqlresult[name];?></a><br />

<? 
   echo '<i>'.hrDesignation($sqlresult[designation]).'</i>';?>
</td> 

 <td align="right"><? if($leaveTaken>=29)echo '<font class=out>'.$leaveTaken.' days</font>'; else echo $leaveTaken.' days';?> </td> 
 <td align="right"><? if($totalAbsent)echo '<font class=out>'.$totalAbsent.' days</font>'; else echo $totalAbsent.' days';
 //echo '<br>WW:'.$totalWorking.'PP'.$totalPresent.'HH'.$totalHolidayWork;?> </td> 
<?  if($loginProject=='000') echo "<td align=center>".myprojectName($sqlresult[location])."</td>";?>
</tr>
<? $i++;}?>
</table>



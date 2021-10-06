<table align="center" width="95%" border="3"  bordercolor="CC9999" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td colspan="3" align="right" valign="top"><font class='englishhead'>human resource status</font></td>
</tr>
<? include("./config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
$sql="SELECT appraisal.*,employee.* FROM appraisal,employee WHERE appraisal.empId=employee.empId";
	if($loginDesignation=="Chairman & Managing Director")
		$sql.=" AND astatus=2 ";
	else
		$sql.=" AND astatus=0 ";
// echo $sql;
	$sqlquery= mysqli_query($db, $sql);
/* END */

$i=0;
while($sqlresult=mysqli_fetch_array($sqlquery)){
$designation = hrDesignationCode($sqlresult[empId]);?>
<tr bgcolor=#EEEEEE><td height=10 colspan=3></td></tr>
<tr>
 <td align="left" > Designation: 
 <? echo '<b>'.hrDesignation($designation).'</b>';?>
</td>
  <td  bgcolor="#CCCCFF" valign="middle" align="center">
	 <a target="_blank" href="./employee/putAppraisalAction.php?empId=<? echo $sqlresult[empId];?>&appId=<? echo $sqlresult[appId];?>&reason=<? echo $sqlresult[reason];?>">Action by Managing Director</a>	
	 </td>
</tr>
<tr>
  <td colspan="3"><? if($a){ echo 'ID:'.empId($sqlresult[empId],$sqlresult[designation]).
  ' <font class="out">'.$sqlresult[name].'</font>; ';}
  else {?>
	  <a href="./index.php?keyword=employee+entry&id=<? echo $sqlresult[empId];?>"> <? echo $sqlresult[name];?></a>
	  <? echo "<br> ID: ".empId($sqlresult[empId],$sqlresult[designation]); ?>
	<? }?>

<?	  

$de=explode(',', $sqlresult[addJob]);
  if($sqlresult[addJob]) 
  { 
  	for($l=0;$l<sizeof($de);$l++)  
	{ echo ';<br>'; echo hrDesignation($de[$l]);}
	 
  }//if
?>

	<? echo $sqlresult[salaryType];?>:  Tk. <? echo number_format($sqlresult[salary],2);?>

	 <? if($a==10){?><a href="./employee/employeeSql.php?save=1&delete=1&id=<? echo $sqlresult[id];?>">Delete</a><? }?>
	 </td>

</tr>

<tr>
 <td colspan="3" >
 As of <? echo date("d-m-Y", strtotime($todat));

 $year=thisyear();
 $from=date("Y-m-d",mktime(0,0,0,1,1,$year));

$totalWorking=totalWork($year,$todat);
$totalPresent = totalPresent($sqlresult[empId],$from,$todat);
$totalAbsent = totalAbsent($sqlresult[empId],$from,$todat);
$leaveTaken=totalLeave($sqlresult[empId],$from,$todat); 
$totalHolidayWork = totalHolidatWork($sqlresult[empId],$from,$todat); 


 ?>
 Leave Taken <font class="out"><? echo $leaveTaken;?></font> days;
 Absent <font class="out"><? echo $totalAbsent;?></font> days;
 Holiday Worked <font class="out"><? echo $totalHolidayWork;?></font> days;
 Total Working Days <font class="out"><? echo $totalWorking?></font>;
 </td> 
 </tr>
<tr>
 <td colspan="3">Experience: <?  echo empExperience($sqlresult[empId],1);?>
 In BFEW:  <?  echo empExperience($sqlresult[empId],2);?>
 In Current Designation:  <?  echo empExperience($sqlresult[empId],3);?> 
</td>
</tr>
<?
$sqla="SELECT * from appraisal WHERE empId=$sqlresult[empId]  AND astatus=0 ORDER by appDate DESC";
$sqlaq=mysqli_query($db, $sqla);
while($app=mysqli_fetch_array($sqlaq)){
 $temp=appraisal2($sqlresult[empId],$app[appId]);
  
  ?>
<tr bgcolor="#FFD5BF">
  <td colspan="3" >
  Reason for review: <? echo $temp[reason];?>; 
  Overall Rating:
  <a target="_blank" href="./employee/appraisalReport.php?empId=<? echo $sqlresult[empId];?>&appId=<? echo $app[appId];?>"><? echo $temp[rate];?></a>
  <i>Appraised by <? echo $temp[supervisor];?> on <? if($app[appDate]!='0000-00-00')echo date("F d, Y",strtotime($app[appDate]));?></i>
  
  <a href="./employee/appraisalDelete.php?appId=<? echo $app[appId];?>">[ DELETE]</a>
  </td>
</tr>
<? }//app?>
<?
   $i++;
$testp= $test;
}?>

</table>
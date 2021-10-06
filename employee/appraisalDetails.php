<?
if($appactionID)
{
  
  
// copy employee at release_employee
$sqlp = "select empId from appaction where id=$appactionID";
// echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
$row=mysqli_fetch_array($sqlrunp);

  

$sqlp = "insert into release_employee (select * from employee where empId=$row[empId])";
// echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
// Delete from original source
$sqlp = "delete from employee where empId=$row[empId]";
// echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

// update appaction status
$sqlp = "UPDATE appaction set actionStatus=0 WHERE id=$appactionID";
// echo $sqlp;
mysqli_query($db, $sqlp);
}


function appraisal($empId,$appId){
$reason=array('1'=>'Annual','2'=>'Promotion', '3'=>'Unsatisfactory Performance','4'=>'Training need assesment','5'=>'End Probation Period', '6'=>'End of Project','7'=>'Other');
$rating=array('100'=>'Outstanding','90'=> 'Very Good','80'=>'Good','50'=>'Improvement Needed','-400'=>'Unsatisfactory','55'=>'Not Rated');

include("./config.inc.php");
   $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
   $sql1="SELECT * FROM appraisal WHERE empId='$empId' AND appId='$appId' ORDER BY appDate DESC";
   $sqlQ1=mysqli_query($db, $sql1);
   $sqlapp=mysqli_fetch_array($sqlQ1);
   $rate=$sqlapp[quality]+$sqlapp[productivity]+$sqlapp[productivity]+$sqlapp[reliability]+$sqlapp[availability]+$sqlapp[independence]+$sqlapp[reporting]+$sqlapp[teamwork];

	$re= array("reason"=>$reason[$sqlapp[reason]],"quality"=>$rating[$sqlapp[quality]],"productivity"=>$rating[$sqlapp[productivity]], 'jobknowledge'=>$rating[$sqlapp[jobknowledge]],'reliability'=>$rating[$sqlapp[reliability]], 'availability'=>$rating[$sqlapp[availability]],'independence'=>$rating[$sqlapp[independence]], 'reporting'=>$rating[$sqlapp[reporting]],'teamwork'=>$rating[$sqlapp[teamwork]],'supervisor'=>$sqlapp[supervisor],'appDate'=>$sqlapp[appDate]);
//echo "<br>Rate=$empId,$appId== $rate<br>";
  $rate=$rate/8;
	if($rate>=95) $rate=100;
	else if($rate>=85) $rate=90;	
	else if($rate>=75) $rate=80;		
	else  $rate=50;		
	
	$re[rate]=$rating[$rate];
	$re[summarize]=$sqlapp[summarize];	
	
   return $re;
}
?>
<form name="store" action="index.php?keyword=appraisal+action+md1&page=1" method="post">
<table align="center" width="400" class="human" >
<tr  >
 <td colspan="2" align="right" valign="top" class="humanHd">employee release report</td>
</tr>
<tr><td>Designation: </td>
    <td >
<? 	include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
			
$managerFound=false;
$getItemDesCode=getItemDesCode($_SESSION[loginDesignation]);
if(managerList($getItemDesCode)){
	$managerFound=true;
	$managerPcode=$_SESSION[loginProject];
}
	
if($loginDesignation=='Manager Planning & Control')$sqlp = "SELECT * from `itemlist` WHERE itemCode BETWEEN '76-00-000' AND '97-99-999'";
else $sqlp = "SELECT * from `itemlist` WHERE itemCode BETWEEN '70-00-000' AND '97-99-999'";

if($loginDesignation=='Construction Manager')$sqlp.=" and itemcode in (select designation from employee where ccr='$getItemDesCode' and location='$managerPcode') ";
$sqlp.=" and itemDes!='' and itemCode in (select designation from employee where empId in (select empId from appaction where action='1')) ";
// echo $sqlp;
			
$sqlrunp= mysqli_query($db, $sqlp);

$plist= "<select name='itemCode'> ";
$plist.= "<option value=''>Select One</option> ";

 while($typel= mysqli_fetch_array($sqlrunp))
{
	 if(!$typel[itemDes])continue;
 $plist.= "<option value='".$typel[itemCode]."'";
 if($itemCode==$typel[itemCode])  $plist.= " SELECTED";
 $plist.= ">$typel[itemCode]--$typel[itemDes]</option>  ";
 }
 $plist.= '</select>';
echo $plist;
 ?>
 	</td>
</tr>

<!-- <tr><td>Location</td>
<td>
	<? 
		if($loginProject=='000'){
			$ex = array('Select one','');
			echo selectPlist('location',$ex,$location);
		}
		else 
			echo $loginProject." ($loginProjectName)";
	?>
</td>
</tr> -->
<tr><td colspan="2" align="center"><input type="submit" name="search" value="Search" class="store" ></td></tr>
</table>
<input type="hidden" name="a" value="<? echo $a;?>">
</form>
	
<table align="center" width="98%" class="human"> 
<tr>
 <td colspan="3" valign="top" class="humanHd_small" align="right" >human resource status</td>
</tr>
<? include("./config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
   $sql="SELECT * FROM employee WHERE status=0";
//if($b) $sql.=" AND  empId > '84-00-000'";  
if($loginDesignation=='Manager Planning & Control') $sql.=" AND  designation BETWEEN '76-00-000' AND '97-99-999' ";  
else $sql.=" AND  designation BETWEEN '71-00-000' AND '97-99-999' ";  
if($loginProject!='000') $location=$loginProject;
if($location AND $location!='Select one'){ $sql.=" AND employee.location=$location";}
	
if($managerFound && $loginDesignation!='Chairman & Managing Director') $sql.=" AND employee.ccr='$getItemDesCode' ";

if($itemCode){
		$sql.=" AND employee.designation LIKE '$itemCode'";
}
$sql.=" and empId in (select empId from appaction where actionStatus='1' and action='1' and date1!='') ";
$sql.=" ORDER by designation ASC";
// echo $sql.'<br>';
$sqlquery=mysqli_query($db, $sql);
/* PAge */
$total_result=mysqli_affected_rows($db);
$total_per_page=30;

if($page<=0)
	{
	$page=1;
	}
$curr=($page-1)*$total_per_page;

$sql.=" LIMIT $curr,$total_per_page";
//$sql=" ";
//echo $sql;
	$sqlquery= mysqli_query($db, $sql);
/* END */

$i=0;	
while($sqlresult=mysqli_fetch_array($sqlquery)){
	if(isEmployeeReleased($sqlresult[empId]))continue;
?>
<?php
$temp = explode('-',$sqlresult[designation]);
$tempId =  $temp[0].'-'.$temp[1];
$test = $sqlresult[designation];
?>	

<tr bgcolor="#E9D1D1">
 <td align="left" height="20" > Designation: 
 <?   echo '<b>'.(hrDesignation($sqlresult[designation]) ? hrDesignation($sqlresult[designation]) : "<font color='#f00'>Not Found</font>").'</b>';?>
</td>
<td>
<a target="_blank" href="./print/print_createJob.php?designation=<? echo $test;?>">Job Description</a>
</td> 
<td>
<?php
// 	$sql="SELECT a.*,e.* FROM appaction a,employee e WHERE a.empId=e.empId AND a.actionStatus=1 and a.action=$aa and e.empId='$sqlresult[empId]' ";
// // echo $sql;
// 	$sqlquery= mysqli_query($db, $sql);
// /* END */
// 	$sqlresult2=mysqli_fetch_array($sqlquery);
?>
	
<!-- <? if(!$a){?> <a href="./index.php?keyword=employee+cv&empId=<? echo $sqlresult[empId];?>">CV</a>
	<? }?>
<? if(empType($sqlresult[empId])=='Wages Monthly Master Roll'){?> [<a href="./index.php?keyword=job+termination&id=<? echo $sqlresult[empId];?>"> Job Termination</a>] <? }?>	 -->
</td>
</tr>
<tr>
  <td colspan="3">
		<?php if($loginDesignation=='Human Resource Manager'){?>
  <a href="./index.php?keyword=employee+entry&id=<? echo $sqlresult[empId]?>">
  	<?  echo 'ID:'.empId($sqlresult[empId],$sqlresult[designation]).
  ' <font class="out">'.$sqlresult[name].'</font>; ';
	}else{
		echo '<font color="#00f">ID:'.empId($sqlresult[empId],$sqlresult[designation]).
		'</font> <font class="out">'.$sqlresult[name].'</font>; ';
	}
	?>
	</a>
<?	  
/*
$de=explode(',', $sqlresult[addJob]);
  if($sqlresult[addJob]) 
  { 
  	for($l=0;$l<sizeof($de);$l++)  
	{ echo ';<br>'; echo hrDesignation($de[$l]);}
	 
  }//if*/
?>
<?php
// 	if($loginDesignation=='Human Resource Manager'){
	
		echo $sqlresult[salaryType];?>:  Tk. <? echo number_format($sqlresult[salary],2);?>;
	 Increment achieved <? echo totalIncrement($sqlresult[empId]);?> times.
	 <? if($a==10){?><a href="./employee/employeeSql.php?save=1&delete=1&id=<? echo $sqlresult[id];?>">Delete</a><? }
// 	}
?>
	 </td>
</tr>

<tr>
 <td colspan="3" >
 As of <? echo date("d-m-Y", strtotime($todat));
 $year=thisyear();
 $from=date("Y-m-d",mktime(0,0,0,1,1,$year));

$totalWorking=totalWork($from,$todat);
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
 LOCATION: <? echo $sqlresult[location];?>
</td>
</tr>
<?
$sqla="SELECT * from appaction WHERE empId=$sqlresult[empId] AND actionStatus>0 limit 1";
$sqlaq=mysqli_query($db, $sqla);
while($app=mysqli_fetch_array($sqlaq)){
 $temp=appraisal3($sqlresult[empId],$app[appId])?>
<tr bgcolor="#E9D1D1">
  <td colspan="2" >
		<b><? echo date("M d, Y",strtotime($app[todat]));?></b> by Appraised by <b><font color='#f00'><? echo $temp[supervisor];?></font></b>
		Reason for review: <b><font color='#f00'><? echo $temp[reason];?></font></b>; 
  Overall Rating:
  	<a target="_blank" href="./employee/appraisalReport.php?empId=<? echo $sqlresult[empId];?>&appId=<? echo $app[appId];?>"><? echo $temp[rate];?></a>  
<!--   	<a target="_blank" href="./index.php?keyword=appraisal&appId=<? echo$app[appId];?>&p=1"><? echo $temp[rate];?></a>   -->
  </td>
	<td>
		<a href="./index.php?keyword=appraisal+action+md1&aa=<?php echo $aa; ?>&appactionID=<?php echo $app[id]; ?>" onClick="if(confirm('<?php echo $app[name]; ?> will be <?php echo appraisalData($aa,null); ?> from employment from <?   echo date("d/m/Y",strtotime($app[date1]));?>')!=true)return false;">Approved</a>
	</td>
</tr>
<? }//app?>
<?
$sqla="SELECT * from appraisal WHERE empId=$sqlresult[empId] AND astatus=0 ORDER by appDate DESC";
$sqlaq=mysqli_query($db, $sqla);
while($app=mysqli_fetch_array($sqlaq)){
$temp=appraisal3($sqlresult[empId],$app[appId]); ?>
<tr bgcolor="#E9D1D1">
  <td colspan="3" >
		<i><? echo date("M d, Y",strtotime($app[todat]));?> by Appraised by <b><font color='#f00'><? echo $temp[supervisor];?></font></b> </i>
		Reason for review: <b><font color='#f00'><? echo $temp[reason];?></font></b>; 
  Overall Rating:
  <a target="_blank" href="./employee/appraisalReport.php?empId=<? echo $sqlresult[empId];?>&appId=<? echo$app[appId];?>"><? echo $temp[rate];?></a>
  
  </td>
</tr>
<? }//app?>
	
	
<tr bgcolor=#E9D1D1><td height=2 colspan=3></td></tr>
<tr bgcolor=#FFFFFF><td height=10 colspan=3></td></tr>

<? $i++;
$testp= $test;
}?>

</table>
<?php
include("./includes/PageNavigation.php");
$totalResults= $total_result;
$resultsPerPage= $total_per_page;
$page= $_GET[page];
$startHTML= "<b>Showing Page {page} of {pages}</b>: Go to Page ";
$appendSearch= "&a=$a&location=$location&itemCode=$itemCode";
$range=5;
$rootLink="./index.php?keyword=appraisal+action+md1";
$link_on= "<a href='$rootLink&page={num}{appendSearch}'><b>{num}</b></a>";
$link_off= "<a href='$rootLink&page={num}{appendSearch}'>{num}</a>";
$back= " <a href='$rootLink&page=1{appendSearch}'><<</a> ";
$forward= " <a href='$rootLink&page={pages}{appendSearch}'>>></a> ";
$myNavigation = New PageNavigation($totalResults, $resultsPerPage, $page, $startHTML, $appendSearch, $range, $link_on, $link_off, $back, $forward);
echo $myNavigation->getHTML();
?>

<? include("../includes/session.inc.php");
 include("../includes/myFunction.php");
 include("../includes/myFunction1.php"); 
 include("../includes/empFunction.inc.php"); 
  include("../includes/eqFunction.inc.php");
?>
<html>
 <title>Item Requirement Details</title>
 <head>
  <style type="text/css">
/*BODY {
	MARGIN-TOP: 0px; MARGIN-LEFT: 5px;MARGIN-RIGHT: 5px; PADDING-TOP: 0px; margin-bottom: 0px; 
	font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8px; background-color: #EEEEEE;background-image: none;
}*/
body {margin-left: 0px;margin-top: 0px;margin-right: 0px;margin-bottom: 0px;	background-color:#C5CDDE}
.englishhead {
	FONT-SIZE: 16px; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; COLOR:#FFFFFF;  letter-spacing: 2;text-transform: capitalize
}
.englishheadsmall {
	FONT-SIZE: 11px; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; COLOR:#FFFFFF;  letter-spacing: 2;text-transform: capitalize
}

.table{font-family:  Arial, Helvetica, sans-serif; 
font-size: 9px; line-height: 18px; color: #000000} 

a {font-family: Verdana, Arial, Helvetica, sans-serif; color: #336699;text-decoration:none}
a:hover {color:#6699CC}

.outs {
	COLOR:#FF6666;
}
/*table {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color:#000000}*/
th{  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px; line-height: 18px;color:#000000}
td{  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px; line-height: 18px;color:#000000}
</style>

 </head>
<body bgcolor="#FFFFFF">

<?

// echo $loginUname;
if($loginUname=='') exit();
 include("../includes/config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 
?>
<h1>Project :<? echo myprojectName($project)." ($project)";?></h1>
<h2>Item Code :<? 
$temp = itemDes($itemCode);
echo $itemCode.', '.$temp[des].', '.$temp[spc].', '.$temp[unit];
?></h2>
<table width="2500" border="2" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" bordercolor="#336699" style="border-collapse:collapse">
<? 
putenv ('TZ=Asia/Dacca'); 
$myTime=strtotime(todat());
$toalQty=array();
$dates=array();	
for($j=0,$i=-7;$j<30;$i++,$j++){
//$padd = $myTime+(84600*$i);
putenv ('TZ=Asia/Dacca'); 
$padd = time()+(86400*$i);
$dates[$j]=date('Y-m-d', $padd);
}//for
?>

<? 
echo "<tr>";
echo "<td align=center bgcolor=336699 ><font class=englishhead>Item of Work</font></td>";
echo "<td align=center bgcolor=336699 ><font class=englishheadsmall>Start</font></td>";
echo "<td align=center bgcolor=336699 ><font class=englishheadsmall>Finish</font></td>";
echo "<td align=center bgcolor=336699 ><font class=englishheadsmall>Duration</font></td>";
echo "<td align=center bgcolor=336699 ><font class=englishheadsmall>Quantity</font></td>";
echo "<td width='1px' bgcolor=#336699> </td>";

for($i=0;$i<30;$i++){
if($i<7)echo "<th bgcolor='#C5CDDE'>".date('d-m-Y',strtotime($dates[$i]))."</th>";
	else {
		if($i==7)echo "<td width='1px'  bgcolor=#FF3333></td>";
	echo "<th bgcolor='#DDDDDD'>".date('d-m-Y',strtotime($dates[$i]))."</th>";
	}
}
echo "</tr>";
?>
<?
$sql1="SELECT * from iow where iowProjectCode='$project'".
        "   AND (((iowSdate BETWEEN '$dates[0]' AND '$dates[29]') OR (iowCdate BETWEEN '$dates[0]' AND '$dates[29]'))". 
        "   OR (('$dates[0]' BETWEEN  iowSdate AND iowCdate) OR ('$dates[29]' BETWEEN  iowSdate AND iowCdate)) )". 		
		"	AND  iowStatus IN ('Approved by Mngr P&C','Approved by MD')";
		
//echo $sql1.'<br>';

$sqlq11=mysql_query($sql1);
$r=1;
while($iow=mysql_fetch_array($sqlq11)){
//echo $r;
$siows=array();
$siowsid=array();	

$sqls00 = "SELECT siow.siowId,siow.siowCode,siow.siowName,siow.siowSdate,siow.siowCdate,dma.dmaQty,iow.iowCode from siow,dma,iow WHERE ".
        "   (((siow.siowSdate BETWEEN '$dates[0]' AND '$dates[29]') OR (siow.siowCdate BETWEEN '$dates[0]' AND '$dates[29]')) ".
        "   OR (('$dates[0]' BETWEEN  siow.siowSdate AND siow.siowCdate) OR ('$dates[29]' BETWEEN  siow.siowSdate AND siow.siowCdate)) )". 				
		"AND". 

 		" iow.iowId='$iow[iowId]' AND siow.iowId='$iow[iowId]' AND dmaItemCode='$itemCode' AND siow.iowId=dma.dmaiow AND siow.siowId=dma.dmasiow";

//echo '<br>*****<br>'.$sqls00.'<br>';

 $sqlruns= mysql_query($sqls00);
 $i=0;
 while($siow=mysql_fetch_array($sqlruns)){
 $siows[$i]="$siow[iowCode].$siow[siowCode]. ($siow[siowName])";
// echo "$siow[iowCode].$siow[siowCode]. ($siow[siowName])<br>";
 $siowsid[$i]=$siow[siowId]; 
 $siowsd[$i]=$siow[siowSdate];  
 $siowcd[$i]=$siow[siowCdate];   
 $dmaQty[$i]=$siow[dmaQty];     
 $i++;}
//print_r($siows);
?>

<? 
for($j=0;$j<sizeof($siows);$j++){
$emp_perdayRequired=emp_perdayRequired($siowsid[$j],$itemCode,$dates[7],$project);

/*$actualTotalIssue = empTotalWorkhrsiow($itemCode,$dates[6],$siowsid[$j]);
$remainForIssue = ($actualTotalIssue)/3600;
*/
	if($r%2==0)echo "<tr bgcolor=#F8F8F8 >";
	  else echo "<tr>";

		echo "<td><b><a href='#' title='".iowName($iow[iowId]).'_'.$iow[iowId].'_'.$siowsid[$j]."'>".$siows[$j]."</a></b></td>";
		echo "<td align=center>".myDate($siowsd[$j])."</td>";
		echo "<td align=center>".myDate($siowcd[$j])."</td>";
		echo "<td align=right>".siowDuration($siowsid[$j])." days</td>";
		echo "<td align=right>".$dmaQty[$j]." hrs.</td>";
		echo "<td width='1px' bgcolor=#336699> </td>";

		for($i=0;$i<sizeof($dates);$i++){
		if($i<7){
		echo "<td align=right>";
		$dailyIssue=empTodayWorksiow($itemCode,$dates[$i],$siowsid[$j]);
		if($dailyIssue>0) {$dailyIssue1=sec2hms($dailyIssue/3600,$padHours=false); echo $dailyIssue1;}
	 		else if((strtotime($siowsd[$j])<=strtotime($dates[$i])) AND (strtotime($siowcd[$j])>=strtotime($dates[$i]))){	echo "00:00";}
		$totalQty[$i]+=$dailyIssue;
		echo "</td>";
		}
		else {
		 if($i==7) echo "<td width='1px' bgcolor=#FF3333></td>";
		 echo "<td align=right>";
		     if(isValidDate($siowsd[$j],$siowcd[$j],$dates[$i]))
             {	echo sec2hms($emp_perdayRequired/3600,$padHours=false);
			    $totalQty[$i]+=$emp_perdayRequired;
			  }
			 else echo '';
		echo "</td>";
		//echo 
		 }//if i<7	
		}//siows
	echo "</tr>";	
}//dates

$r++;}//iow
?>

<? 
echo "<tr bgcolor=#FFFFDD>";
echo "<td height=25 bgcolor=#FF9933 colspan=5><font class=englishHead>Actual/ Planned Issue Qty. </font></td>";
echo "<td width='1px' bgcolor=#336699> </td>";

for($i=0;$i<30;$i++){
if($i==7)echo "<td width='1px'  bgcolor=#FF0000></td>";
echo "<th align=right>".sec2hms(($totalQty[$i])/3600,$padHours=false)."</th>";
}
echo "</tr>";
echo "<tr bgcolor=#C5CDDE><td height=50 colspan=37></td></tr>";
?>

<? 

$sql1="SELECT distinct attendance . empId  from employee , attendance where".
" designation = '$itemCode' AND attendance.empId=employee.empId AND".
" attendance . location = '$project' AND attendance . edate between '$dates[0]' AND '$dates[29]'".
"  AND status = 0  ORDER BY `attendance` . `empId` ASC";
//echo $sql1;
$sqlq1=mysql_query($sql1);
while($em=mysql_fetch_array($sqlq1)){
$duration=0;
$empReportDate=empReportDate($em[empId]);
$empStayDate=empStayDate($em[empId]);
$duration=1+((strtotime($empStayDate)-strtotime($empReportDate))/(86400));
$duration=round($duration);
$hour=$duration*8;
echo "<tr>";
 echo "<td>".empId($em[empId],$itemCode).' '.empName($em[empId])."</td>";
 echo '<td>'.myDate($empReportDate).'</td>';
 echo '<td>'.myDate($empStayDate).'</td>'; 
 echo '<td align=right>'.$duration.' days</td>';  
 echo '<td align=right>'.$hour.':00 hrs.</td>';   
 echo "<td width='1px' bgcolor=#336699> </td>"; 
 
	for($i=0;$i<sizeof($dates);$i++){
		if($i<7){
		 $workt= dailywork($em[empId],$dates[$i],'H',$project);
		 $pototalQty[$i]+= $workt;
		 echo '<td align=right>'.sec2hms($workt/3600,$padHours=false).'</td>';
		}		
		else {
		if($i==7)echo "<td width='1px'  bgcolor=#FF0000></td>";		 
		 if(strtotime($empStayDate)>=strtotime($dates[$i]) AND strtotime($empReportDate)<=strtotime($dates[$i]))
		  {
		 echo '<td align=right>08:00</td>';		  
		  $pototalQty[$i]+=8*3600;
		   }
		  else echo '<td align=right></td>';		  
		}//else
	
	}//for
echo "<tr>";
}//while

?>
<? 
echo "<tr bgcolor=#DDDDFF>";

echo "<td height=25 bgcolor=#9999FF colspan=5><font class=englishHead>Actual/ Planned Receive Qty.</font></td>";
echo "<td width='1px' bgcolor=#336699> </td>";

for($i=0;$i<30;$i++){
if($i==7)echo "<td width='1px'  bgcolor=#FF3333></td>";
echo "<th align=right>".sec2hms($pototalQty[$i]/3600,$padHours=false)."</th>";
}
echo "</tr>";
?>

<? 
echo "<tr bgcolor=#FFFFFF><td height=50 colspan=36></td></tr>";

echo "<tr bgcolor=#FFCCFF>";
echo "<td height=25 bgcolor=#FF99FF colspan=5><font class=englishHead>Stocks at Hand</font></td>";
echo "<td width='1px' bgcolor=#336699> </td>";

for($i=0;$i<30;$i++){
if($i==7)echo "<td width='1px'  bgcolor=#FF0000></td>";
$remainTotal = $pototalQty[$i]-$totalQty[$i];
//echo "--$remainTotal = $pototalQty[$i]-$totalQty[$i]--";
$remainQty[$i]=$remainTotal;
if($remainTotal<0){
$remainTotal = abs($remainTotal);
echo "<th align=right><font class=outs>( ".sec2hms($remainTotal/3600,$padHours=false)." )</font></th>";
}
else echo "<th align=right>".sec2hms($remainTotal/3600,$padHours=false)."</th>";
//sec2hms(($siow[perday]*3600)/3600,$padHours=false);
}
echo "</tr>";

?>
</table>
</body>
</html>
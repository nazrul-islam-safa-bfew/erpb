<? 
include("../includes/session.inc.php");
include("../includes/myFunction.php");
include("../includes/myFunction1.php"); 
include("../includes/eqFunction.inc.php"); 
?>
<html>
 <title>Item Requirement Details</title>
 <head>
<style type="text/css">
body {margin-left: 5px;margin-top: 5px;margin-right: 5px;margin-bottom: 5px;	background-color:#C5CDDE}
.englishhead {
	FONT-SIZE: 16px; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; COLOR:#FFFFFF;  letter-spacing: 2;text-transform: capitalize
}
.englishheadsmall {
	FONT-SIZE: 12px; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; COLOR:#FFFFFF;  letter-spacing: 2;text-transform: capitalize
}

.table{font-family:  Arial, Helvetica, sans-serif; 
font-size: 11px; line-height: 18px; color: #000000} 

a {font-family: Verdana, Arial, Helvetica, sans-serif; color: #336699;text-decoration:none}
a:hover {color:#6699CC}

.outs {
	COLOR:#FF6666;
}
th{  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px; line-height: 18px;color:#000000}
td{  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px; line-height: 18px;color:#000000}
h1{ font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14px; line-height: 18px;color:#000000}
h2{ font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; line-height: 18px;color:#000000}

</style>

 </head>
<body bgcolor="#FFFFFF">

<?
if($loginUname=='') exit();
	 include("../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 
?>
<h1>Project :<? echo myprojectName($project)." ($project)";?></h1>
<h2>Item Code :<? 
$temp = itemDes($itemCode);
echo $itemCode.', '.$temp[des].', '.$temp[spc].', '.$temp[unit];
?></h2>
<table width="2500" border="2" cellpadding="5" cellspacing="0" bgcolor="#FFFFFF" bordercolor="#336699" style="border-collapse:collapse">
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
//print_r($dates);
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

$sqlq11=mysqli_query($db, $sql1);
$r=1;
while($iow=mysqli_fetch_array($sqlq11)){
//echo $r;
$siows=array();
$siowsid=array();	

$sqls00 = "SELECT siow.siowId,siow.siowCode,siow.siowName,siow.siowSdate,siow.siowCdate,dma.dmaQty,iow.iowCode from siow,dma,iow WHERE ".
        "   (((siow.siowSdate BETWEEN '$dates[0]' AND '$dates[29]') OR (siow.siowCdate BETWEEN '$dates[0]' AND '$dates[29]')) ".
        "   OR (('$dates[0]' BETWEEN  siow.siowSdate AND siow.siowCdate) OR ('$dates[29]' BETWEEN  siow.siowSdate AND siow.siowCdate)) )". 				
		" AND iow.iowId='$iow[iowId]' AND siow.iowId='$iow[iowId]' AND dmaItemCode='$itemCode' AND siow.iowId=dma.dmaiow AND siow.siowId=dma.dmasiow";

//echo $sqls00.'<br>';

 $sqlruns= mysqli_query($db, $sqls00);
 $i=0;
 while($siow=mysqli_fetch_array($sqlruns))
 {
	$siows[$i]="$siow[iowCode].$siow[siowCode]. ($siow[siowName])";
	$siowsid[$i]=$siow[siowId]; 
	$siowsd[$i]=$siow[siowSdate];  
	$siowcd[$i]=$siow[siowCdate];   
	$dmaQty[$i]=$siow[dmaQty];    
	$i++;
 }

?>

<? 
for($j=0;$j<sizeof($siows);$j++){
$eq_perdayRequired=eq_perdayRequired($siowsid[$j],$itemCode,$dates[7],$project);
	if($r%2==0)echo "<tr bgcolor=#F8F8F8 >";
	  else echo "<tr>";
		echo "<td><b><a href='#' title='".iowName($iow[iowId])."'>".$siows[$j].'SIOW'.$siowsid[$j]."</a></b></td>";
		echo "<td align=center>".myDate($siowsd[$j])."</td>";
		echo "<td align=center>".myDate($siowcd[$j])."</td>";
		echo "<td align=right>".siowDuration($siowsid[$j])." days</td>";
		echo "<td align=right>".sec2hms($dmaQty[$j],$padHours=false)." hrs.</td>";
		echo "<td width='1px' bgcolor=#336699> </td>";
		
		for($i=0;$i<sizeof($dates);$i++){
		if($i<7){
		echo "<td align=right>";
		$dailyIssue=eqTodayWorksiow($itemCode,$dates[$i],$siowsid[$j]);
		if($dailyIssue>0) {$dailyIssue1=sec2hms($dailyIssue/3600,$padHours=false); echo $dailyIssue1;}
 		else if((strtotime($siowsd[$j])<=strtotime($dates[$i])) AND (strtotime($siowcd[$j])>=strtotime($dates[$i]))){	echo "00:00";}		
		$totalQty[$i]+=$dailyIssue;
		echo "</td>";
		$issuedQty+=$dailyIssue;
		}
		else {
			if($i==7) echo "<td width='1px' bgcolor=#FF3333></td>";
		echo "<td align=right>";
		     if(isValidDate($siowsd[$j],$siowcd[$j],$dates[$i]))
             {echo sec2hms($eq_perdayRequired,$padHours=false); 
			 $totalQty[$i]+=$eq_perdayRequired*3600;}
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
				if($i==7) echo "<td width='1px' bgcolor=#FF3333></td>";
echo "<th align=right>".sec2hms(($totalQty[$i])/3600,$padHours=false)."</th>";
}
echo "</tr>";
echo "<tr bgcolor=#C5CDDE><td height=50 colspan=37></td></tr>";
?>

<? 
$sqlpo1="SELECT * from eqproject where pCode='$loginProject' AND itemCode='$itemCode' AND status<>0 ";
//echo $sqlpo1;
$sqlqpo1=mysqli_query($db, $sqlpo1);
while($po1=mysqli_fetch_array($sqlqpo1)){

if($po1[status]==2){ 
	$planReceiveDate=$po1[receiveDate]; 
	$planDispatchDate=$po1[edate];
}
else if($po1[status]==3){
	$planReceiveDate=$po1[receiveDate];  
	$planDispatchDate=$po1[dispatchDate];
	}
else {
	$planReceiveDate=eq_planReceiveDate($po1[posl],$itemCode); 
	$planDispatchDate=planDispatchDate($po1[posl],$itemCode); 
	}



if((strtotime($planReceiveDate)>=strtotime($dates[0])) OR (strtotime($planDispatchDate)<=strtotime($dates[29]))){

echo "<tr>";
 echo "<td> ";
 if($po1[assetId]{0}=='A'){  echo eqpId_local($po1[assetId],$itemCode); $type='L';  }
   else {echo eqpId($po1[assetId],$itemCode); $type='H'; }
   
 $tt= explode('_',$po1[posl]);
 $temp = vendorName($tt[3]);
echo ' : '.$temp[vname];
echo "</td>";
 echo "<td align=center>".myDate($planReceiveDate)."</td>";
 echo "<td align=center>".myDate($planDispatchDate)."</td>";
 $duration=(strtotime($planDispatchDate)-strtotime($planReceiveDate))/(24*3600);
 $duration= $duration+1;
 $hour=$duration*8;
 echo "<td align=right>".$duration." days</td>"; 
 echo "<td align=right>".$hour.":00 hrs.</td>"; 
 echo "<td width='1px' bgcolor=#336699> </td>";

for($i=0;$i<sizeof($dates);$i++){
		if($i<7){
		echo "<td align=right>";
			if(strtotime($planReceiveDate) <= strtotime($dates[$i]))
			 {$workt= eq_dailywork($po1[assetId],$itemCode,$dates[$i],$type,$loginProject);			
			  echo sec2hms($workt/3600,$padHours=true);
			  }
			  else "00:00";
			$pototalQty[$i]+=$workt;			
		echo "</td>";		
		}
		else if($i==7) {
				echo "<td width='1px' bgcolor=#FF3333></td>";
				echo "<td align=right>";
				
				if(strtotime($planDispatchDate)>=strtotime($dates[$i]))				
				{
					echo "08:00</td>";				
					$pototalQty[$i]+=8*3600;
				}
			  }
             else { 
				echo "<td align=right>";
				 if(strtotime($planDispatchDate)>=strtotime($dates[$i]))				
					{echo "08:00</td>";				
					$pototalQty[$i]+=8*3600;
					}
				}//else

}//for
echo "</tr>";
}//if
}//while
?>
<? 
echo "<tr bgcolor=#DDDDFF>";

echo "<td height=25 bgcolor=#9999FF colspan=5><font class=englishHead>Actual/ Planned Receive Qty.</font></td>";
echo "<td width='1px' bgcolor=#336699> </td>";
for($i=0;$i<30;$i++){
				if($i==7) echo "<td width='1px' bgcolor=#FF3333></td>";
echo "<th align=right>".sec2hms($pototalQty[$i]/3600,$padHours=false)."</th>";
}
echo "</tr>";
?>

<? 
echo "<tr bgcolor=#FFFFFF><td height=50 colspan=37></td></tr>";

echo "<tr bgcolor=#FFCCFF>";
echo "<td height=25 bgcolor=#FF99FF colspan=5><font class=englishHead>Daily Total</font></td><td width='1px' bgcolor=#336699> </td>";
for($i=0;$i<30;$i++){
if($i==7) echo "<td width='1px' bgcolor=#FF3333></td>";
	$remainTotal = $pototalQty[$i]-$totalQty[$i];
	$remainQty[$i]=$remainTotal;
if($remainTotal<0){
$remainTotal = abs($remainTotal);
echo "<th align=right><font class=outs>( ".sec2hms($remainTotal/3600,$padHours=false)." )</font></th>";
}
else echo "<th align=right>".sec2hms($remainTotal/3600,$padHours=false)."</th>";
}
echo "</tr>";
?>
</table>
</body>
</html>
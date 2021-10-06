<? include("../includes/session.inc.php");
 include("../includes/myFunction.php");
 include("../includes/myFunction1.php"); 
?>
<html>
 <title>Item Requires Deratails</title>
 <head>
  <style type="text/css">
/*BODY {
	MARGIN-TOP: 0px; MARGIN-LEFT: 5px;MARGIN-RIGHT: 5px; PADDING-TOP: 0px; margin-bottom: 0px; 
	font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8px; background-color: #EEEEEE;background-image: none;
}*/
body {margin-left: 0px;margin-top: 0px;margin-right: 0px;margin-bottom: 0px;	background-color:#C5CDDE}
.englishhead {
	FONT-SIZE: 12px; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; COLOR:#FFFFFF;  letter-spacing: 2;text-transform: capitalize
}
.englishheadsmall {
	FONT-SIZE: 12px; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; COLOR:#FFFFFF;  letter-spacing: 2;text-transform: capitalize
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
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
?>
<h1>Project :<? echo myprojectName($project)." ($project)";?></h1>
<h2>Item Code :<? 
$temp = itemDes($itemCode);
echo $itemCode.', '.$temp[des].', '.$temp[spc].', '.$temp[unit];
?></h2>
<table width="2500" border="2" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" bordercolor="#336699" style="border-collapse:collapse">
<? 
$toalQty=array();
$dates=array();	
for($j=0,$i=-7;$j<30;$i++,$j++){
$padd = time()+(84600*$i);
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
//$sql1="SELECT * from iow where iowProjectCode='$project' AND ('$dates[0]' BETWEEN iowSdate AND iowCdate)";

$sql1="SELECT * from iow where iowProjectCode='$project'".
        "   AND ((iowSdate BETWEEN '$dates[0]' AND '$dates[29]') OR (iowCdate BETWEEN '$dates[0]' AND '$dates[29]'))". 
		"	AND  iowStatus IN ('Approved by Mngr P&C','Approved by MD')";
//echo $sql1.'<br>';

$sqlq11=mysqli_query($db, $sql1);
$r=1;
while($iow=mysqli_fetch_array($sqlq11)){
//echo $r;
$siows=array();
$siowsid=array();	

/* $sqls = "SELECT siow.siowId,siow.siowCode,dma.dmaQty,iow.iowCode from siow,dma,iow WHERE  ('$dates[0]' BETWEEN siowSdate AND siowCdate) AND ".
 		" iow.iowId='$iow[iowId]' AND siow.iowId='$iow[iowId]' AND dmaItemCode='$itemCode' AND siow.iowId=dma.dmaiow AND siow.siowId=dma.dmasiow";
 */

$sqls00 = "SELECT siow.siowId,siow.siowCode,siow.siowName,siow.siowSdate,siow.siowCdate,dma.dmaQty,iow.iowCode from siow,dma,iow WHERE ".
        "   ((siow.siowSdate BETWEEN '$dates[0]' AND '$dates[29]') OR (siow.siowCdate BETWEEN '$dates[0]' AND '$dates[29]')) AND". 
 		" iow.iowId='$iow[iowId]' AND siow.iowId='$iow[iowId]' AND dmaItemCode='$itemCode' AND siow.iowId=dma.dmaiow AND siow.siowId=dma.dmasiow";

//echo $sqls00.'<br>';

 $sqlruns= mysqli_query($db, $sqls00);
 $i=0;
 while($siow=mysqli_fetch_array($sqlruns)){
 $siows[$i]="$siow[iowCode].$siow[siowCode]. ($siow[siowName])";
 $siowsid[$i]=$siow[siowId]; 
 $siowsd[$i]=$siow[siowSdate];  
 $siowcd[$i]=$siow[siowCdate];   
 $dmaQty[$i]=$siow[dmaQty];    
 $i++;}

?>

<? 
for($j=0;$j<sizeof($siows);$j++){

//$estimatdTotalIssue = estimated_issue_s_to_e($siowsd[$j],$dates[6],$itemCode1,$siowsid[$j])*3600;
//echo "<br>estimatdTotalIssue: $estimatdTotalIssue";
$actualTotalIssue = eqTotalWorkhrsiow($itemCode,$dates[6],$siowsid[$j]);
//echo "$siowsid[$j]<br>actualTotalIssue: $actualTotalIssue";
//$remainForIssue = ($estimatdTotalIssue-$actualTotalIssue)/3600;
$remainForIssue = ($actualTotalIssue)/3600;
//echo "<br>remainForIssue: $remainForIssue";
//$remainForIssue=0;
	if($r%2==0)echo "<tr bgcolor=#F8F8F8 >";
	  else echo "<tr>";
		//echo "<th>".$siows[$j].'Iss:'.estimated_issue_s_to_e($dates[0],$dates[6],$itemCode,$siowsid[$j])."</th>";
		echo "<td><b><a href='#' title='".iowName($iow[iowId])."'>".$siows[$j]."</a></b></td>";
		echo "<td><b>".myDate($siowsd[$j])."</b></td>";
		echo "<td><b>".myDate($siowcd[$j])."</b></td>";
		echo "<td align=right><b>".siowDuration($siowsid[$j])." days</b></td>";
		echo "<td align=right><b>".sec2hms($dmaQty[$j],$padHours=false)." hr.</b></td>";
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
		 $sqls = "SELECT siowCdate, siowSdate,(to_days(siowCdate)-to_days('$dates[7]')) as duration,".
		 "((dmaQty-$issuedQty)/((to_days(siowCdate)-to_days('$dates[7]'))+1)) as perday,dmaQty from siow,dma ".
		  " WHERE ('$dates[$i]' BETWEEN siowSdate AND siowCdate) AND siowId=$siowsid[$j]".
		  " AND dmasiow=$siowsid[$j] AND dmaItemCode='$itemCode'";

/*		 $sqls = "SELECT siowCdate, siowSdate,(to_days(siowCdate)-to_days(siowSdate)) as duration,".
		 "((dmaQty)/(to_days(siowCdate)-to_days(siowSdate))) as perday,dmaQty from siow,dma ".
		  " WHERE ('$dates[$i]' BETWEEN siowSdate AND siowCdate) AND siowId=$siowsid[$j]".
		  " AND dmasiow=$siowsid[$j] AND dmaItemCode='$itemCode'";
*/
		//echo $sqls;
		//echo 'aa';		
		 $sqlruns= mysqli_query($db, $sqls);
		 $siow=mysqli_fetch_array($sqlruns);
         if($siow[perday]<=0) echo '';
		  else  echo sec2hms($siow[perday],$padHours=false);
		echo "</td>";
		$totalQty[$i]+=$siow[perday]*3600;
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
$sqlpo1="SELECT * from porder where posl LIKE 'EQ_".$project."_%' AND itemCode='$itemCode' AND status<>0 AND dstart BETWEEN '$dates[0]' AND '$dates[29]'";
//echo $sqlpo1;
$sqlqpo1=mysqli_query($db, $sqlpo1);
while($po1=mysqli_fetch_array($sqlqpo1)){

echo "<tr>";
 $tt= explode('_',$po1[posl]);
 $temp = vendorName($tt[3]);
 echo "<td> ".$tt[0].'_'.$tt[1].'_'.$tt[2].' : '.$temp[vname]."</td>";
 echo "<td colspan=4></td>";
 echo "<td width='1px' bgcolor=#336699> </td>";
 
 
for($i=0;$i<sizeof($dates);$i++){
		if($i<7){
		echo "<td align=right>";
			//$dailyReceive = eqdailyReceive($dates[$i],$itemCode,$project,$po1[posl]);

			$dailyReceive= eqTodayWork('%',$itemCode,$dates[$i]);
			
			$dailyBreak = eqBreakBown('%',$itemCode,$dates[$i]);
			$available = $dailyReceive-$dailyBreak;
			
			if($dailyReceive>0)	echo sec2hms($available/3600,$padHours=false);		
			 else echo '';
 	  	    $pototalQty[$i]+=$available;
			$pre=$dailyReceive;
		echo "</td>";		
		}
		else if($i==7) {
						 echo "<td width='1px' bgcolor=#FF3333></td>";
		        $posdate=$po1[dstart]; 
				//$estimated_Receive = eqestimated_Receive_s_to_e($posdate,$dates[6],$po1[poid]);
				$actual_Receive = eqactual_Receive_s_to_e($posdate,$dates[6],$itemCode,$project,$po1[posl]);
				//$overHead = $estimated_Receive-$actual_Receive;
				$overHead=$actual_Receive;

				$current= $overHead;
				echo "<td align=right>";
				if($current>0)echo sec2hms($current*8,$padHours=false);
				 else echo '';

				echo "</td>";				
				$pototalQty[$i]+=$current*8*3600;
				$pre=$current;				

		  }
             else { 
				/*$sqlpo="SELECT * from poschedule where poid = '$po1[poid]' AND sdate='$dates[$i]'";
				echo $sqlpo;				
				$sqlqpo=mysqli_query($db, $sqlpo);
				$po=mysqli_fetch_array($sqlqpo);*/
				$dailyReceive = eqdailyReceive($dates[$i],$itemCode,$project,$po1[posl]);
				$pre=$dailyReceive;

				echo "<td align=right>";
				if($pre>0)echo sec2hms($pre*8,$padHours=false);
				 else echo '';
				$pototalQty[$i]+=$pre*8*3600;
				echo "</td>";		

		}//else

}//for
echo "</tr>";

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
echo "<td height=25 bgcolor=#FF99FF colspan=5><font class=englishHead>Stocks at Hand</font></td><td width='1px' bgcolor=#336699> </td>";
for($i=0;$i<30;$i++){
				if($i==7) echo "<td width='1px' bgcolor=#FF3333></td>";
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
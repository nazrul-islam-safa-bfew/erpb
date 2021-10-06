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
	FONT-SIZE: 16px; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; COLOR:#FFFFFF;  letter-spacing: 2;text-transform: capitalize
}
.table{font-family:  Arial, Helvetica, sans-serif; 
font-size: 11px; line-height: 18px; color: #000000} 

a {font-family: Verdana, Arial, Helvetica, sans-serif; color: #336699;text-decoration:none}
a:hover {color:#6699CC}

.outs {
	COLOR:#FF6666;
}
/*table {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color:#000000}*/
th{  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px; line-height: 18px;color:#000000}
</style>

 </head>
<body bgcolor="#FFFFFF">

<?

// echo $loginUname;
if($loginUname=='') exit();
 include("../includes/config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
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
echo "<td align=center bgcolor=336699 ><font class=englishhead>Item of Work</font></td><td width='1px' bgcolor=#336699> </td>";
for($i=0;$i<30;$i++){
if($i<7)echo "<th bgcolor='#C5CDDE'>".date('d-m-Y',strtotime($dates[$i]))."</th>";
	else echo "<th bgcolor='#DDDDDD'>".date('d-m-Y',strtotime($dates[$i]))."</th>";
}
echo "</tr>";
?>
<?
//$sql1="SELECT * from iow where iowProjectCode='$project' AND ('$dates[0]' BETWEEN iowSdate AND iowCdate)";

$sql1="SELECT * from iow where iowProjectCode='$project'".
        "   AND ((iowSdate BETWEEN '$dates[0]' AND '$dates[29]') OR (iowCdate BETWEEN '$dates[0]' AND '$dates[29]'))". 
		"	AND  iowStatus IN ('Approved by Mngr P&C','Approved by MD')";
//echo $sql1.'<br>';

$sqlq11=mysql_query($sql1);
$r=1;
while($iow=mysql_fetch_array($sqlq11)){
//echo $r;
$siows=array();
$siowsid=array();	

/* $sqls = "SELECT siow.siowId,siow.siowCode,dma.dmaQty,iow.iowCode from siow,dma,iow WHERE  ('$dates[0]' BETWEEN siowSdate AND siowCdate) AND ".
 		" iow.iowId='$iow[iowId]' AND siow.iowId='$iow[iowId]' AND dmaItemCode='$itemCode' AND siow.iowId=dma.dmaiow AND siow.siowId=dma.dmasiow";
 */

$sqls00 = "SELECT siow.siowId,siow.siowCode,siow.siowName,siow.siowSdate,dma.dmaQty,iow.iowCode from siow,dma,iow WHERE ".
        "   ((siow.siowSdate BETWEEN '$dates[0]' AND '$dates[29]') OR (siow.siowCdate BETWEEN '$dates[0]' AND '$dates[29]')) AND". 
 		" iow.iowId='$iow[iowId]' AND siow.iowId='$iow[iowId]' AND dmaItemCode='$itemCode' AND siow.iowId=dma.dmaiow AND siow.siowId=dma.dmasiow";

 //echo $sqls00.'<br>';

 $sqlruns= mysql_query($sqls00);
 $i=0;
 while($siow=mysql_fetch_array($sqlruns)){
 $siows[$i]="$siow[iowCode].$siow[siowCode]. ($siow[siowName])";
 $siowsid[$i]=$siow[siowId]; 
 $siowsd[$i]=$siow[siowSdate];  
 $i++;}

?>

<? 
for($j=0;$j<sizeof($siows);$j++){

$estimatdTotalIssue = estimated_issue_s_to_e($siowsd[$j],$dates[6],$itemCode,$siowsid[$j]);
$actualTotalIssue = actual_issue_s_to_e($siowsd[$j],$dates[6],$itemCode,$project,$siowsid[$j]);
$remainForIssue = $estimatdTotalIssue-$actualTotalIssue;
	if($r%2==0)echo "<tr bgcolor=#F8F8F8 >";
	  else echo "<tr>";
		//echo "<th>".$siows[$j].'Iss:'.estimated_issue_s_to_e($dates[0],$dates[6],$itemCode,$siowsid[$j])."</th>";
		echo "<td><b><a href='#' title='".iowName($iow[iowId])."'>".$siows[$j]."</a></b></td><td width='1px' bgcolor=#336699> </td>";
		for($i=0;$i<sizeof($dates);$i++){
		if($i<7){
		echo "<td align=right>";
		$dailyIssue=dailyIssue($dates[$i],$itemCode,$project,$siowsid[$j]);
		echo $dailyIssue;
		$totalQty[$i]+=$dailyIssue;
		echo "</td>";		
		}
		else {
		
		echo "<td align=right>";
		 $sqls = "SELECT siowCdate, siowSdate,(to_days(siowCdate)-to_days(siowSdate)) as duration,".
		 "((dmaQty+$remainForIssue)/(to_days(siowCdate)-to_days(siowSdate))) as perday,dmaQty from siow,dma ".
		  " WHERE ('$dates[$i]' BETWEEN siowSdate AND siowCdate) AND siowId=$siowsid[$j]".
		  " AND dmasiow=$siowsid[$j] AND dmaItemCode='$itemCode'";

/*		 $sqls = "SELECT siowCdate, siowSdate,(to_days(siowCdate)-to_days(siowSdate)) as duration,".
		 "((dmaQty)/(to_days(siowCdate)-to_days(siowSdate))) as perday,dmaQty from siow,dma ".
		  " WHERE ('$dates[$i]' BETWEEN siowSdate AND siowCdate) AND siowId=$siowsid[$j]".
		  " AND dmasiow=$siowsid[$j] AND dmaItemCode='$itemCode'";
*/
		//echo $sqls;
		//echo 'aa';		
		 $sqlruns= mysql_query($sqls);
		 $siow=mysql_fetch_array($sqlruns);
         if($siow[perday]<=0) echo '';
		  else  echo number_format($siow[perday],3);
		echo "</td>";
		$totalQty[$i]+=$siow[perday];
		 }//if i<7	
		}//siows
	echo "</tr>";	
}//dates

$r++;}//iow
?>

<? 
echo "<tr bgcolor=#FFFFDD>";
echo "<td height=25 bgcolor=#FF9933><font class=englishHead>Actual/ Planned Issue Qty. </font></td><td width='1px' bgcolor=#336699> </td>";
for($i=0;$i<30;$i++){
echo "<th align=right>".number_format($totalQty[$i],3)."</th>";
}
echo "</tr>";
echo "<tr bgcolor=#C5CDDE><td height=50 colspan=31></td></tr>";
?>

<? 
$sqlpo1="SELECT * from porder where posl LIKE 'PO_".$project."_%' AND itemCode='$itemCode' AND status=1";// AND dstart BETWEEN '$dates[0]' AND '$dates[29]'";
//echo $sqlpo1;
$sqlqpo1=mysql_query($sqlpo1);
while($po1=mysql_fetch_array($sqlqpo1)){

echo "<tr>";
 $tt= explode('_',$po1[posl]);
 $temp = vendorName($tt[3]);
 echo "<td> ".$tt[0].'_'.$tt[1].'_'.$tt[2].' : '.$temp[vname]."</td><td width='1px' bgcolor=#336699> </td>";
 
for($i=0;$i<sizeof($dates);$i++){
		if($i<7){
		echo "<td align=right>";
			$dailyReceive = dailyReceive($dates[$i],$itemCode,$project,$po1[posl]);
			echo $dailyReceive;
		  $pototalQty[$i]+=$dailyReceive;
					
		echo "</td>";		
		}
		else if($i==7) {
		        $posdate=$po1[dstart]; 
				$estimated_Receive = estimated_Receive_s_to_e($posdate,$dates[6],$po1[poid]);
				$actual_Receive = actual_Receive_s_to_e($posdate,$dates[6],$itemCode,$project,$po1[posl]);
				$overHead = $estimated_Receive-$actual_Receive;
				
				$sqlpo="SELECT * from poschedule where poid = '$po1[poid]' AND sdate='$dates[$i]'";
				//echo $sqlpo;
				$sqlqpo=mysql_query($sqlpo);
				$po=mysql_fetch_array($sqlqpo);
				$current= $po[qty]+$overHead;
				echo "<td align=right>";
                echo $current;
				echo "</td>";				
				$pototalQty[$i]+=$po[qty]+$overHead;				

		  }
             else { 
				$sqlpo="SELECT * from poschedule where poid = '$po1[poid]' AND sdate='$dates[$i]'";
				//echo $sqlpo;
				$sqlqpo=mysql_query($sqlpo);
				$po=mysql_fetch_array($sqlqpo);

				echo "<td align=right>";
				echo $po[qty];
				$pototalQty[$i]+=$po[qty];
				echo "</td>";		

		}//else

}//for
echo "</tr>";

}//while
?>
<? 
echo "<tr bgcolor=#DDDDFF>";

echo "<td height=25 bgcolor=#9999FF><font class=englishHead>Actual/ Planned Receive Qty.</font></td><td width='1px' bgcolor=#336699> </td>";
for($i=0;$i<30;$i++){
echo "<th align=right>".number_format($pototalQty[$i],3)."</th>";
}
echo "</tr>";
?>

<? /*
echo "<tr bgcolor=#FFFFFF><td height=50 colspan=30></td></tr>";

echo "<tr bgcolor=#FFCCFF>";
echo "<td>Stocks at Hand/day</td>";
for($i=0;$i<30;$i++){
$remainTotal = $pototalQty[$i]-$totalQty[$i];
$remainQty[$i]=$remainTotal;
if($remainTotal<0){
$remainTotal = abs($remainTotal);
echo "<th align=right><font class=outs>( ".number_format($remainTotal,3)." )</font></th>";
}
else echo "<th align=right>".number_format($remainTotal,3)."</th>";
}
echo "</tr>";
*/
?>


<? 
$remainTotal = $pototalQty[0]-$totalQty[0];
echo "<tr bgcolor=#C5CDDE><td height=50 colspan=31></td></tr>";

echo "<tr bgcolor=#FFEEFF>";
echo "<td height=25 bgcolor=#FF99FF><font class=englishHead>Stocks at Hand</font></td><td width='1px' bgcolor=#336699> </td>";

				$sqlpor="SELECT SUM(receiveQty-currentQty) as  remainQty from store$project where todat < '$dates[0]'";
				//echo $sqlpor;
				$sqlqpor=mysql_query($sqlpor);
				$por=mysql_fetch_array($sqlqpor);
                $remainTotal+= $por[remainQty];
echo "<td valign=bottom><b>$remainTotal</b></td>";
for($i=1;$i<30;$i++){
$remainTotal = ($remainTotal+$pototalQty[$i])-$totalQty[$i];

//echo "<th align=right> ".number_format($remainTotal,3)." </th>";

if($remainTotal<0){
$remainTotal1 = abs($remainTotal);
echo "<td align=right valign=bottom><b><font class=outs>( ".number_format($remainTotal1,3)." )</font></b></td>";
}
else echo "<td align=right valign=bottom><b>".number_format($remainTotal,3)."</b></td>";

}
echo "</tr>";
?>

</table>
</body>
</html>
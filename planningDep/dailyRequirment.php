<?
	include("../includes/session.inc.php");
header('Content-Type: text/html; charset=ISO-8859-1');
	include("../includes/myFunction.php");
	include("../includes/myFunction1.php"); 
	include("../includes/matFunction.inc.php"); 
?>
<html>
 <title>Item Requirement Details</title>
 <head>

  <style type="text/css">
/*BODY {
	MARGIN-TOP: 0px; MARGIN-LEFT: 5px;MARGIN-RIGHT: 5px; PADDING-TOP: 0px; margin-bottom: 0px; 
	font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8px; background-color: #EEEEEE;background-image: none;
}*/
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
/*table {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color:#000000}*/
th{  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px; line-height: 18px;color:#000000}
td{  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px; line-height: 18px;color:#000000}
h1{ font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14px; line-height: 18px;color:#000000}
h2{ font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; line-height: 18px;color:#000000}
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
<table width="3000" border="2" cellpadding="5" cellspacing="0" bgcolor="#FFFFFF" bordercolor="#336699" style="border-collapse:collapse">
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
	echo "<th bgcolor='#DDDDDD'>".date('d-m-Y',strtotime($dates[$i]))."</th>";}
}
echo "</tr>";
?>
<?
//$sql1="SELECT * from iow where iowProjectCode='$project' AND ('$dates[0]' BETWEEN iowSdate AND iowCdate)";

$sql1="SELECT * from iow where iowProjectCode='$project'".
//        "   AND ((iowSdate BETWEEN '$dates[0]' AND '$dates[29]') OR (iowCdate BETWEEN '$dates[0]' AND '$dates[29]'))". 
        "   AND (('$dates[0]' BETWEEN iowSdate AND iowCdate) OR ('$dates[29]' BETWEEN iowSdate AND iowCdate))". 		
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

$sqls00 = "SELECT siow.siowId,siow.siowCode,siow.siowName,siow.siowSdate,siow.siowCdate,dma.dmaQty,iow.iowCode from siow,dma,iow WHERE ((siow.siowSdate BETWEEN '$dates[0]' AND '$dates[29]') OR (siow.siowCdate BETWEEN '$dates[0]' AND '$dates[29]') OR  
  ('$dates[0]' BETWEEN siow.siowSdate AND siow.siowCdate) OR ('$dates[29]' BETWEEN siow.siowSdate AND siow.siowCdate)) AND 
 iow.iowId='$iow[iowId]' AND siow.iowId='$iow[iowId]' AND dmaItemCode='$itemCode' AND siow.iowId=dma.dmaiow AND siow.siowId=dma.dmasiow";

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
$mat_perdayRequired=mat_perdayRequired($siowsid[$j],$itemCode,$dates[7],$project);

	if($r%2==0)echo "<tr bgcolor=#F8F8F8 >";
	  else echo "<tr>";
		//echo "<th>".$siows[$j].'Iss:'.estimated_issue_s_to_e($dates[0],$dates[6],$itemCode,$siowsid[$j])."</th>";
		echo "<td><b><a href='#' title='".iowName($iow[iowId]).$iow[iowId]."'>".$siows[$j]."</a></b></td>";
		echo "<td align=center>".myDate($siowsd[$j])."</td>";
		echo "<td align=center>".myDate($siowcd[$j])."</td>";
		echo "<td align=right>".siowDuration($siowsid[$j])." days</td>";
		echo "<td align=right>".number_format($dmaQty[$j],3).' '.$temp[unit]."</td>";
		echo "<td width='1px' bgcolor=#336699> </td>";

		for($i=0;$i<sizeof($dates);$i++){
		if($i<7){
		echo "<td align=right>";
		$dailyIssue=dailyIssue($dates[$i],$itemCode,$project,$siowsid[$j]);
		if($dailyIssue)	echo number_format($dailyIssue,3);
	 		else if((strtotime($siowsd[$j])<=strtotime($dates[$i])) AND (strtotime($siowcd[$j])>=strtotime($dates[$i]))){	echo "0";}		
		$totalQty[$i]+=$dailyIssue;
		echo "</td>";		
		}
		else {
		if($i==7) echo "<td width='1px' bgcolor=#FF3333></td>";
		 echo "<td align=right>";
		     if(isValidDate($siowsd[$j],$siowcd[$j],$dates[$i]))
             {echo number_format($mat_perdayRequired,3);
			  $totalQty[$i]+=$mat_perdayRequired;}
			 else echo '';
		echo "</td>";
		
		 }//if i<7	
		}//siows
	echo "</tr>";	
}//dates

$r++;}//iow
?>

<? 
echo "<tr bgcolor=#FFFFDD>";
echo "<td height=25 bgcolor=#FF9933 colspan=5 ><font class=englishHead>Actual/ Planned Issue Qty. </font></td>";
 echo "<td width='1px' bgcolor=#336699> </td>";
for($i=0;$i<30;$i++){
if($i==7)echo "<td width='1px'  bgcolor=#FF3333></td>";
echo "<th align=right>".number_format($totalQty[$i],3)."</th>";
}
echo "</tr>";
echo "<tr bgcolor=#C5CDDE><td height=50 colspan=37></td></tr>";
?>

<? 
$sqlpo1="SELECT * from porder where posl LIKE 'PO_".$project."_%' AND itemCode='$itemCode' AND status=1";// AND dstart BETWEEN '$dates[0]' AND '$dates[29]'";

//echo $sqlpo1;
$sqlqpo1=mysqli_query($db, $sqlpo1);
while($po1=mysqli_fetch_array($sqlqpo1)){

echo "<tr>";
 $tt= explode('_',$po1[posl]);
 $temp = vendorName($tt[3]);
 echo "<td colspan=5> ".$tt[0].'_'.$tt[1].'_'.$tt[2].' : '.$temp[vname]."</td>"; 
 echo "<td width='1px' bgcolor=#336699> </td>";
 
for($i=0;$i<sizeof($dates);$i++){
		if($i<7){
		echo "<td align=right>";
			$dailyReceive = dailyReceive($dates[$i],$itemCode,$project,$po1[posl]);
			if($dailyReceive>=0) echo number_format($dailyReceive,3);

			
		  $pototalQty[$i]+=$dailyReceive;
					
		echo "</td>";		
		}
		else if($i==7) {
		       echo "<td width='1px'  bgcolor=#FF3333></td>";
		        $posdate=$po1[dstart]; 
				$estimated_Receive = estimated_Receive_s_to_e($posdate,$dates[6],$po1[posl],$itemCode);
				$actual_Receive = actual_Receive_s_to_e($posdate,$dates[6],$itemCode,$project,$po1[posl]);
				$overHead = $estimated_Receive-$actual_Receive;
				if($overHead<0) $overHead=0;
				
				$sqlpo="SELECT * from poschedule where posl = '$po1[posl]' AND itemCode='$itemCode' AND sdate='$dates[$i]'";
				//echo $sqlpo;
				$sqlqpo=mysqli_query($db, $sqlpo);
				$po=mysqli_fetch_array($sqlqpo);
				$current= $po[qty]+$overHead;
				echo "<td align=right>";
               if($current) echo number_format($current,3);
				echo "</td>";				
				$pototalQty[$i]+=$po[qty]+$overHead;				

		  }
             else { 
				$sqlpo="SELECT * from poschedule where posl = '$po1[posl]' AND itemCode='$itemCode' AND sdate='$dates[$i]'";
				//echo $sqlpo;
				$sqlqpo=mysqli_query($db, $sqlpo);
				$po=mysqli_fetch_array($sqlqpo);

				echo "<td align=right>";
				if($po[qty])echo number_format($po[qty],3);
				$pototalQty[$i]+=$po[qty];
				echo "</td>";		

		}//else

}//for
echo "</tr>";

}//while
?>

<? 
echo "<tr>";

echo "<td height=25 colspan=5>Emergency Purchase</td>"; 
echo"<td width='1px' bgcolor=#336699> </td>";
for($i=0;$i<sizeof($dates);$i++){
//for($i=0;$i<8;$i++){
	if($i<7){
		$epPurchaseQty=epPurchaseQty($itemCode,$dates[$i],$project);
		$pototalQty[$i]=$pototalQty[$i]+$epPurchaseQty;
		echo "<td align=right>".number_format($epPurchaseQty,3)."</td>";
	}
	else if($i==7){
		echo "<td width='1px'  bgcolor=#FF3333></td>";
		$epPurchaseQty =epPurchasableQty($itemCode,$dates[$i],$project);
		$pototalQty[$i]=$pototalQty[$i]+$epPurchaseQty;
		echo "<td align=right>".number_format($epPurchaseQty,3)."</td>";
	}
	else echo "<td align=right></td>";
}
echo "</tr>";

?>

<? 
echo "<tr bgcolor=#DDDDFF>";

echo "<td height=25 bgcolor=#9999FF colspan=5><font class=englishHead>Actual/ Planned Receive Qty.</font></td>"; 
echo"<td width='1px' bgcolor=#336699> </td>";
for($i=0;$i<30;$i++){
if($i==7)echo "<td width='1px'  bgcolor=#FF3333></td>";
echo "<th align=right>".number_format($pototalQty[$i],3)."</th>";
}
echo "</tr>";
?>



<? 
$remainTotal = $pototalQty[0]-$totalQty[0];
echo "<tr bgcolor=#C5CDDE><td height=50 colspan=37></td></tr>";

echo "<tr bgcolor=#FFEEFF>";
echo "<td height=25 bgcolor=#FF99FF colspan=5><font class=englishHead>Stocks at Hand</font></td>";
echo "<td width='1px' bgcolor=#336699> </td>";

/*$sqlpor="SELECT SUM(currentQty) as  totalCurrentQty from store$project 
where todat < '$dates[0]' AND itemCode='$itemCode'";
//echo $sqlpor;
$sqlqpor=mysqli_query($db, $sqlpor);
$por=mysqli_fetch_array($sqlqpor);
$remainTotal+= $por[totalCurrentQty];
*/

$remainTotal+=mat_stock($project,$itemCode,$dates[0],'');

echo "<td valign=bottom align=right><b>".number_format($remainTotal,3)."</b></td>";
for($i=1;$i<30;$i++){
if($i==7)echo "<td width='1px'  bgcolor=#FF0000></td>";
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
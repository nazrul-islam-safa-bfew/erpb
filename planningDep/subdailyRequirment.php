<? include("../includes/session.inc.php");
header('Content-Type: text/html; charset=ISO-8859-1');
 include("../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);
 include("../includes/myFunction.php");
 include("../includes/myFunction1.php"); 
  include("../includes/subFunction.inc.php"); 
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

	
		if($itemCode){
			$itemCodeArray=explode("-",$itemCode);
		}
			
	
// echo $loginUname;
if($loginUname=='') exit();
?>
<h1>Project :<? echo myprojectName($project)." ($project)";?></h1>
<h2>Item Code :<? 
$temp = itemDes($itemCode);
$unit=$temp[unit];
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

/* 
$sqls="SELECT siow.siowId,siow.siowCode,dma.dmaQty,iow.iowCode from siow,dma,iow WHERE  ('$dates[0]' BETWEEN siowSdate AND siowCdate) AND ".
 		" iow.iowId='$iow[iowId]' AND siow.iowId='$iow[iowId]' AND dmaItemCode='$itemCode' AND siow.iowId=dma.dmaiow AND siow.siowId=dma.dmasiow";
 */

$sqls00="SELECT siow.siowId,siow.siowCode,siow.siowName,siow.siowSdate,siow.siowCdate,dma.dmaQty,iow.iowCode from siow,dma,iow WHERE ".
        " ((siow.siowSdate BETWEEN '$dates[0]' AND '$dates[29]') OR (siow.siowCdate BETWEEN '$dates[0]' AND '$dates[29]') OR". 
        "   ('$dates[0]' BETWEEN siow.siowSdate AND siow.siowCdate) OR ('$dates[29]' BETWEEN siow.siowSdate AND siow.siowCdate)) AND ". 
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
	 $i++;
 }

?>

<? 

for($j=0;$j<sizeof($siows);$j++){
	$sub_perdayRequired=sub_perdayRequired($siowsid[$j],$itemCode,$dates[7],$project);

	if($r%2==0)echo "<tr bgcolor=#F8F8F8 >";
	  else echo "<tr>";
		//echo "<th>".$siows[$j].'Iss:'.estimated_issue_s_to_e($dates[0],$dates[6],$itemCode,$siowsid[$j])."</th>";
		echo "<td><b><a href='#' title='".iowName($iow[iowId])."'>".$siows[$j]."</a></b></td>";
		echo "<td align=center>".myDate($siowsd[$j])."</td>";
		echo "<td align=center>".myDate($siowcd[$j])."</td>";
		echo "<td align=right>".siowDuration($siowsid[$j])." days</td>";
		echo "<td align=right>".number_format($dmaQty[$j],3).' '.$temp[unit]."</td>";
		echo "<td width='1px' bgcolor=#336699> </td>";

		for($i=0;$i<sizeof($dates);$i++){
		if($i<7){
		echo "<td align=right>";			
		if($itemCodeArray[0]=="99") //subcontractor ut
			$dailyIssue=subWork_dailyIssued($itemCode,$siowsid[$j],$dates[$i]);
			
		elseif($itemCodeArray[0]>="01" && $itemCodeArray[0]<="49") // mat ut
			$dailyIssue=dailyIssue($dates[$i],$itemCode,$project,$siowsid[$j]);
			
		elseif($itemCodeArray[0]>="50" && $itemCodeArray[0]<="69") //eq ut
			$dailyIssue=subWork_dailyIssued($itemCode,$siowsid[$j],$dates[$i]);
			
			
		if($dailyIssue)	echo number_format($dailyIssue,3);
	 		else if((strtotime($siowsd[$j])<=strtotime($dates[$i])) AND (strtotime($siowcd[$j])>=strtotime($dates[$i]))){echo "0";}
		$totalQty[$i]+=$dailyIssue;
		echo "</td>";
		}
		else {
		if($i==7) echo "<td width='1px' bgcolor=#FF3333></td>";
		 echo "<td align=right>";
		    if(isValidDate($siowsd[$j],$siowcd[$j],$dates[$i])){
					echo number_format($sub_perdayRequired,3);
			  	$totalQty[$i]+=$sub_perdayRequired;
			  }
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
//if resource type start
if(getResourceType($itemCode)=="start"){
	if($i==7){
		$remainTotal=$epPurchaseQty+resourceTypeStart($itemCode,$project);
		echo "<th align=right>".number_format($remainTotal,3)."</th>";
		$totalQty[$i]=$remainTotal;
	//end of resource type
	}else {
					$totalQty[$i]=$remainTotal=0;
					echo "<th align=right>".number_format($remainTotal,3)."</th>";
				}
}
	else
		echo "<th align=right>".number_format($totalQty[$i],3)."</th>";
	

	
}
echo "</tr>";
echo "<tr bgcolor=#C5CDDE><td height=50 colspan=37></td></tr>";
?>

<? 
$sqlpo1="SELECT * from porder where posl LIKE 'PO_".$project."_%' AND itemCode='$itemCode' AND status>=1";// AND dstart BETWEEN '$dates[0]' AND '$dates[29]'";

//echo $sqlpo1;
$sqlqpo1=mysqli_query($db, $sqlpo1);
while($po1=mysqli_fetch_array($sqlqpo1)){
	$remainQty=totalRemainQty($po1[posl],$itemCode);
	if($remainQty<=0)continue;
echo "<tr>";
 $tt= explode('_',$po1[posl]);
 $temp = vendorName($tt[3]);
 echo "<td colspan=5> <a href='./printpurchaseOrder1.php?posl=$po1[posl]' target='_blank'>".$tt[0].'_'.$tt[1].'_'.$tt[2].' : '.$temp[vname]."</a> Remain qty: <a href=''>$remainQty</a> $unit </td>"; 
 echo "<td width='1px' bgcolor=#336699></td>";
 
for($i=0;$i<sizeof($dates);$i++){
		if($i<7){
		echo "<td align=right>";
			
		if($itemCodeArray[0]=="99") //subcontractor ut  
			$dailyReceive=subWork_dailyPo($itemCode,$po1[posl],$dates[$i]);
			
		elseif($itemCodeArray[0]>="01" && $itemCodeArray[0]<="49") // mat ut
			$dailyReceive=dailyReceive($dates[$i],$itemCode,$project,$po1[posl]);
			
		elseif($itemCodeArray[0]>="50" && $itemCodeArray[0]<="69") //eq ut
			$dailyReceive=subWork_dailyPo($itemCode,$po1[posl],$dates[$i]);
			
			$poStartDate=$po1[dstart];
			
			
		if($dailyReceive){
	 	 echo "<font color='#00f'>".number_format($dailyReceive,3)."</font>";
     $pototalQty[$i]+=$dailyReceive;
		 }else echo number_format(0,3);
	   echo "</td>";
		}else{
		     if($i==7)  echo "<td width='1px'  bgcolor=#FF3333></td>";
				$sqlpo="SELECT * from poschedule where posl = '$po1[posl]' AND sdate>='$dates[$i]' and iteamCode='$iteamCode'";
 //				echo $sqlpo;
				$sqlqpo=mysqli_query($db, $sqlpo);
				$po=mysqli_fetch_array($sqlqpo);
// 				print_r($po);
				$lastReceiveDate=$po[sdate];
			
				
				$dailyQty=poDailyReceive($dates[$i],$remainQty,$lastReceiveDate);
			
				echo "<td align=right>";
				if($dailyQty)echo "<font color='#00f'>".number_format($dailyQty,3)."</font>";
				$pototalQty[$i]+=$dailyQty;
				echo "</td>";
		}//else
}//for
echo "</tr>";
}//while
?>
	
<? 
echo "<tr>";
echo "<td height=25 colspan=5>Emergency Purchase</td>";
echo"<td width='1px' bgcolor=#336699></td>";
for($i=0;$i<sizeof($dates);$i++){
//for($i=0;$i<8;$i++){
	if($i<7){
		$epPurchaseQty=epPurchaseQty($itemCode,$dates[$i],$project);
		$pototalQty[$i]=$pototalQty[$i]+$epPurchaseQty;
		echo "<td align=right>".number_format($epPurchaseQty,3)."</td>";
	}else
		if($i==7){
		echo "<td width='1px'  bgcolor=#FF3333></td>";
		$epPurchaseQty=epPurchasableQty($itemCode,$dates[$i],$project);
		$pototalQty[$i]=$pototalQty[$i]+$epPurchaseQty;
		echo "<td align=right><font color='#00f'>".number_format($epPurchaseQty,3)."</font></td>";
	}
	else 
		echo "<td align=right></td>";
}
echo "</tr>";
?>

<? 
echo "<tr bgcolor=#DDDDFF>";
echo "<td height=25 bgcolor=#9999FF colspan=5><font class=englishHead>Actual/ Planned Receive Qty.</font></td>"; 
echo"<td width='1px' bgcolor=#336699></td>";
for($i=0;$i<30;$i++){
if($i==7)
	echo "<td width='1px'  bgcolor=#FF3333></td>";
	echo "<th align=right>".number_format($pototalQty[$i],3)."</th>";
}
echo "</tr>";
?>

<? 
$remainTotal=$remainTotalG=$pototalQty[0]-$totalQty[0]+mat_stock($project,$itemCode,$dates[0],$dates[0]);
echo "<tr bgcolor=#C5CDDE><td height=50 colspan=37></td></tr>";

echo "<tr bgcolor=#FFEEFF>";
echo "<td height=25 bgcolor=#FF99FF colspan=5><font class=englishHead>Stocks at Hand</font></td>";
echo "<td width='1px' bgcolor=#336699></td>";
/*
				$sqlpor="SELECT SUM(currentQty) as  totalCurrentQty from store$project where todat < '$dates[0]' AND itemCode='$itemCode'";
				//echo $sqlpor;
				$sqlqpor=mysqli_query($db, $sqlpor);
				$por=mysqli_fetch_array($sqlqpor);*/
	

	
if($remainTotalG<0){
	$remainTotal1 = abs($remainTotalG);
	echo "<td align=right valign=bottom><b><font class=outs>( ".number_format($remainTotal1,3).")</font></b></td>";
}else 
	echo "<td align=right valign=bottom><b>".number_format($remainTotal,3)."</b></td>";
	
for($i=1;$i<30;$i++){
if($i==7)echo "<td width='1px'  bgcolor=#FF0000></td>";
// $datatt="($remainTotal+$pototalQty[$i])-$totalQty[$i]";	
$remainTotal=($remainTotal+$pototalQty[$i])-$totalQty[$i];
//echo "<th align=right> ".number_format($remainTotal,3)."</th>";

	
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
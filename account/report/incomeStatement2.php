<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
<? 
session_start();
///////////////////////
include('./project/siteDailyReport.f.php');

function eq_dailywork1($eqId,$itemCode,$d1,$d2,$eqType,$pcode){

$work=0;
  $sql1="SELECT  SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as total from  `equt`".
 " where  eqId ='$eqId' AND itemCode='$itemCode'  AND edate BETWEEN '$d1' and '$d2' AND pcode=$pcode AND iow>='1' ";
//echo $sql1;

 $sqlQuery1=mysqli_query($db, $sql1);
 $remainQty1=mysqli_fetch_array($sqlQuery1);
 if($remainQty1[total]) 
 $work= $remainQty1[total];
 return $work;
}

function eq_dailyworkBreak1($eqId,$itemCode,$d1,$d2,$eqType,$pcode){
$work=0;

  $sql1="SELECT  SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as total from  `equt`".
 " where  eqId ='$eqId' AND itemCode='$itemCode' AND edate BETWEEN '$d1' and '$d2' AND pcode=$pcode AND iow='0' AND siow='0' ";
//echo '<br>'.$sql1.'<br>';

 $sqlQuery1=mysqli_query($db, $sql1);
 $remainQty1=mysqli_fetch_array($sqlQuery1);
  if($remainQty1[total]) 
 $work= $remainQty1[total];

 return $work;
}

function eq_dailyBreakDown1($eqId,$itemCode,$d1,$d2,$eqType,$pcode){
$work=0;
  $sql1="SELECT  SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as total from  `equt`".
 " where  eqId ='$eqId' AND itemCode='$itemCode' AND edate BETWEEN '$d1' and '$d2' AND pcode=$pcode AND iow='-1' AND siow='-1' ";
//echo $sql1;
 $sqlQuery1=mysqli_query($db, $sql1);
 $remainQty1=mysqli_fetch_array($sqlQuery1);
  if($remainQty1[total]) 
 $work= $remainQty1[total];

 return $work;
}
function eq_toDaypresent2($eqId,$itemCode,$d1,$d2,$eqType,$pcode){
 $sql="select (SUM(60+ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)))) as duration
	from eqattendance
	WHERE eqId= '$eqId' AND itemCode= '$itemCode' AND edate BETWEEN '$d1' and '$d2' AND location='$pcode'";
//echo '<br>'.$sql.'<br>';
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 return $rr[duration];
}


function total_eq_direct_issueAmount_date1($pcode,$fromDate,$toDate){

  $ch = curl_init();
$headers["Content-Length"] = strlen($postString);
$headers["User-Agent"] = "Curl/1.0";

curl_setopt($ch, CURLOPT_URL, $requestUrl);
    curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, 'admin:');
curl_setopt($ch,CURLOPT_TIMEOUT,6000);
$response = curl_exec($ch);
curl_close($ch);
//set_time_limit(0);
ini_set("memory_limit","256M");
ini_set("max_execution_time","6000");


		 $overtimeAmountTotal=0;
		 $regularAmountTotalat=0;
		 $normalDayAmountTotal=0;

//$sqlp = "SELECT DISTINCT itemCode, MAX(dmaRate) as rate from `dma`, eqattendance Where dmaProjectCode='$pcode' AND dmaItemCode =itemCode and itemCode >= '50-00-000' AND itemCode < '70-00-000' AND location='$pcode' group by itemCode ORDER by itemCode ASC";
//	$sqlrunp= mysqli_query($db, $sqlp);
$n=sizeof($_SESSION['itemdata1']);
// while($typel= mysqli_fetch_array($sqlrunp))
for($i=0;$i<$n;$i++)
		{
		
		$workedgTotal=0;
		 $overtimetat=0;
		 $toDaypresentat=0;
		 $idletat=0;

		 //$itemCode1=$typel[itemCode];
		 //$rate=$typel[rate];
		 
		 $itemCode1=$_SESSION['itemdata1'][$i];
		 $rate=$_SESSION['itemdata2'][$i];
		// print "<br>";
		 $sqlquery="SELECT distinct eqId FROM eqattendance".
		" where eqattendance.location='$pcode' AND itemCode='$itemCode1'".
		" AND action in('P','HP') ORDER by itemCode ASC ";
		 $sql= mysqli_query($db, $sqlquery);
//		 print mysql_num_rows($sql)." ";
		 while($r=mysqli_fetch_array($sql))
		 	{
//BETWEEN '$fromDate' and '$toDate'
			$workt= eq_dailywork1($r[eqId],$itemCode1,$fromDate,$toDate,'H',$pcode);
			$dailyworkBreakt=eq_dailyworkBreak1($r[eqId],$itemCode1,$fromDate,$toDate,'H',$pcode);

			$dailyBreakDown=eq_dailyBreakDown1($r[eqId],$itemCode1,$fromDate,$toDate,'H',$pcode);
			$toDaypresent=eq_toDaypresent2($r[eqId],$itemCode1,$fromDate,$toDate,'H',$pcode);
			
			$toDaypresents=$toDaypresent-$dailyworkBreakt;	
			$toDaypresentat=$toDaypresentat+$toDaypresents;
			
			
			$workts=$workt-$dailyworkBreakt;
			 $workedgTotal=$workedgTotal+$workts;
			if($workedgTotal<0)
			$workedgTotal=0;
			$overtimet = $toDaypresents-8*3600;
			if($overtimet<0) $overtimet=0;
			$overtimetat=$overtimetat+$overtimet;
			
			$idlet=$toDaypresent-$workt;
			  if($idlet<0) $idlet=0;
			  $idletat=$idletat+$idlet; 
			}

	//$sqls = "SELECT MAX(dmaRate) as rate from `dma` WHERE dmaProjectCode='$pcode' AND dmaItemCode ='$itemCode1' ";
	//$sql1=mysqli_query($db, $sqls); 
	//$sqlr=mysqli_fetch_array($sql1);
	//$rate=$sqlr[rate];
	 $a=($workedgTotal/3600)*$rate; 
	 $b=($overtimetat/3600)*$rate;
	 $c=(($toDaypresentat-$overtimetat)/3600)*$rate;
	
	$normalDayAmountTotal=$normalDayAmountTotal+$a; 
	//print number_format($normalDayAmountTotal);
	//print "<br>";
	$regularAmountTotalat=$regularAmountTotalat+$c;
	//print number_format($regularAmountTotalat);
	//print "<br>";

	$overtimeAmountTotal=$overtimeAmountTotal+$b;
	//print number_format($overtimeAmountTotal);
	//print "<br>";
	
//	print "<br>$itemCode1 ; $workedgTotal ; $a";
   $amount=(($overtimeAmountTotal+$regularAmountTotalat) - $normalDayAmountTotal);
	}

///////////////////////////////////
 $_SESSION['utilization']=$normalDayAmountTotal;
return $amount;
}

function eq_ex_utilized1($pcode,$fromDate,$toDate)
  {
  $ch = curl_init();
$headers["Content-Length"] = strlen($postString);
$headers["User-Agent"] = "Curl/1.0";

curl_setopt($ch, CURLOPT_URL, $requestUrl);
    curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, 'admin:');
curl_setopt($ch,CURLOPT_TIMEOUT,6000);
$response = curl_exec($ch);
curl_close($ch);
//set_time_limit(0);
ini_set("memory_limit","256M");
ini_set("max_execution_time","6000");

 // print $fromDate." ".$toDate;"<br>";
 $normalDayAmountTotal=0;
 
// $sqlp = "SELECT DISTINCT itemlist.itemCode,itemlist.itemDes,itemlist.itemSpec  from eqattendance,`itemlist` Where itemlist.itemCode >= '50-00-000' AND itemlist.itemCode < '70-00-000' AND itemlist.itemCode=eqattendance.itemCode AND location='$pcode' ORDER by itemlist.itemCode,eqId ASC";
//	$sqlrunp= mysqli_query($db, $sqlp);
$n=sizeof($_SESSION['itemdata1']);
// while($typel= mysqli_fetch_array($sqlrunp))
for($i=0;$i<$n;$i++)
		{
		
		$workedgTotal=0;
//		 $itemCode1=$typel[itemCode];
		 
		  $itemCode1=$_SESSION['itemdata1'][$i];
		  $rate=$_SESSION['itemdata2'][$i];
	
	
		// $sqlquery="SELECT eqattendance.* FROM eqattendance".
//" where eqattendance.location='$pcode' AND eqattendance.edate='$toDate' AND itemCode='$itemCode1'".
//" AND action in('P','HP') ORDER by itemCode ASC ";

		 $sqlquery="SELECT distinct eqid FROM eqattendance where eqattendance.location='$pcode' AND itemCode='$itemCode1'".
		" AND action in('P','HP') ORDER by itemCode ASC ";
		//print "<br>";
		 $sql= mysqli_query($db, $sqlquery);
		
		 while($r=mysqli_fetch_array($sql))
		 	{
			 $workt= eq_dailywork1($r[eqId],$itemCode1,$fromDate,$toDate,'H',$pcode);
			 $dailyworkBreakt=eq_dailyworkBreak1($r[eqId],$itemCode1,$fromDate,$toDate,'H',$pcode);
			 $workts=$workt-$dailyworkBreakt;
			 $workedgTotal=$workedgTotal+$workts;
			 
			}
		if($workedgTotal<0)
			 $workedgTotal=0;
/*	 $sqls = "SELECT MAX(dmaRate) as rate from `dma` WHERE dmaProjectCode='$pcode' AND dmaItemCode ='$itemCode1' ";
	$sql1=mysqli_query($db, $sqls); 
	$sqlr=mysqli_fetch_array($sql1);
	$rate=$sqlr[rate];
*/	 
	 $a=($workedgTotal/3600)*$rate; 
	 $normalDayAmountTotal=$normalDayAmountTotal+$a;
	
	 //echo number_format($normalDayAmountTotal);
	 //echo "<br>";
	//print "<br>$itemCode1 ; $workedgTotal ; $a";
	}
return $normalDayAmountTotal;
  }
  //echo $loginDesignation;

?>
<form name="gl" action="./index.php?keyword=income+statement" method="post">
<table align="center"  width="500"  border="0" class="blue" >
 <tr bgcolor="#CCCCFF">
 <td align="right" valign="top" height="30" colspan="4"><font class='englishheadblack'>income statement</font></td>
</tr>

 <tr>
	   <td colspan="4">Project: 
<!-- 	  <select name='pcode' size='1' onChange="location.href='index.php?keyword=cash+disbursment&pcode='+cdj.pcode.options[document.cdj.pcode.selectedIndex].value+'&fromDate='+cdj.fromDate.value+'toDate='+cdj.toDate.value";> -->
      <select name="pcode" size="1">
	  <option value="0">Select Project</option>
	  <?
	  
	  if($loginDesignation=='Manager Planning & Control'){} else { ?>
	  <option value="1" <? if($pcode==1) echo " SELECTED "?>>All BFEW</option>
	  <? } ?>	  
	<? 
	include("config.inc.php");
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
		
	$sqlp = "SELECT * from `project` ORDER by pcode ASC";
	//echo $sqlp;
	$sqlrunp= mysqli_query($db, $sqlp);
	$skip_first_number=0;
	 while($typel= mysqli_fetch_array($sqlrunp))
	{
	
	 if($loginDesignation=='Manager Planning & Control')
		 {
			 if($skip_first_number>0)
			 {
				 echo "<option value='".$typel[pcode]."'";
				 if($pcode==$typel[pcode]) echo "SELECTED";
				 echo ">$typel[pcode]--$typel[pname]</option>  ";
			 }
			 $skip_first_number+=1;
			 
		 }
	 else
		 {
		 	echo "<option value='".$typel[pcode]."'";
			if($pcode==$typel[pcode]) echo "SELECTED";
			echo ">$typel[pcode]--$typel[pname]</option>  ";
		 }
		 
	 }
	 ?>
	</select>
	</td> 
 </tr>
 <tr>
 	<SCRIPT LANGUAGE="JavaScript">
	var now = new Date();
	var cal = new CalendarPopup("testdiv1");
    	cal.showNavigationDropdowns();
		cal.setWeekStartDay(6); // week is Monday - Sunday
		//cal.addDisabledDates(null,formatDate(now,"yyyy-MM-dd"));
		cal.setCssPrefix("TEST");
		cal.offsetX = 0;
		cal.offsetY = 0;

	</SCRIPT>
    <td>From </td>
      <td><input type="text" maxlength="10" name="fromDate" value="<? echo $fromDate;?>" > <a id="anchor" href="#"
   onClick="cal.select(document.forms['gl'].fromDate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a>
      </td>
    <td>To </td>
      <td><input type="text" maxlength="10" name="toDate" value="<? echo $toDate;?>" > <a id="anchor2" href="#"
   onClick="cal.select(document.forms['gl'].toDate,'anchor2','dd/MM/yyyy'); return false;"
   name="anchor2" ><img src="./images/b_calendar.png" alt="calender" border="0"></a>
      </td>
 </tr>

 <tr><td colspan="4" align="center"><input type="button" name="go" value="Go" onClick="gl.submit();"></td></tr>
</table>
<br>


<!--<table align="center" width="600" border="3"  bgcolor="#CCCCCC" cellpadding="2" cellspacing="0" style="border-collapse:collapse">
<tr>	
   <td width=250>Group</td>
      <td >-->
<?php
//ini_set("memory_limit","256M");
//ini_set("max_execution_time","1000");
//echo ini_get("memory_limit")."\n";

//echo ini_get("max_execution_time")."\n";

/*if(!ini_get('safe_mode')) {
    set_time_limit(240);
    ini_set('memory_limit', '16M');
    ini_set('upload_max_filesize', '10M');
    ini_set('post_max_size', '10M');
    ini_set('max_input_time', 300);
}
*/
/*$fromDate=formatDate($fromDate,'Y-m-j');
 $toDate=formatDate($toDate,'Y-m-j'); 

$normalDayAmountTotal=0;
       $sqlp = "SELECT DISTINCT itemlist.itemCode,itemlist.itemDes,itemlist.itemSpec  from".
" eqattendance,`itemlist` Where itemlist.itemCode >= '50-00-000' AND itemlist.itemCode < '70-00-000'".
" AND itemlist.itemCode=eqattendance.itemCode AND location='$pcode' ORDER by itemlist.itemCode,eqId ASC";
	$sqlrunp= mysqli_query($db, $sqlp);

 while($typel= mysqli_fetch_array($sqlrunp))
		{
		
		$workedgTotal=0;
		 $itemCode1=$typel[itemCode];
	//$itemCode1=$itemCode[$k];
$goitemCode=$goitemCode.'_'.$itemCode1;
 if($itemCode1){
 $perDayQtyTotal=0;
 $siowdmaPerDayTotal=0;
 $perDayQtyTotal0=0;
 $siowdmauptoTotal0=0;
 $perDayQtyTotal=0;
 $siowdmauptoTotal=0;
 $worktat=0;
 $workat=0;
 $normalDayAmountTotal=0;
 $mworkedgTotal=0;
 $workedgTotal=0;
 $normalDayAmountgTotalup=0;
 $regularAmountTotalat=0;
 $mpresentasReggAmountTotal=0;
 $toDaypresentat=0;
 $idletat=0;
 $overtimeAmountTotal=0;
 $presentgTotal=0;
 $overtimegAmountTotal=0;
 $mnormalDayAmountgTotalup=0;
$presentasReggAmountTotal=0; 
$presentasReggTotal=0;
$mpresentasReggTotal=0;
$midlegTotal=0;
$movertimegAmountTotal=0;
$idlegTotal=0;
$mpresentgTotal=0;
$overtimegTotal=0;

$totalDay=0;
$totalMonth=0;
$totalProject=0;
$tem=itemDes($itemCode1);*/

/* till todate start*/
/*$sqlquery="SELECT eqattendance.* FROM eqattendance".
" where eqattendance.location='$pcode' AND eqattendance.edate BETWEEN '$fromDate' AND '$toDate' AND itemCode='$itemCode1'".
" AND action in('P','HP') ORDER by itemCode ASC ";
//echo $sqlquery;
 $sql= mysqli_query($db, $sqlquery);
 $i=1;


 while($re=mysqli_fetch_array($sql)){

	$dailyworkBreakt=eq_dailyworkBreak($re[eqId],$re[itemCode],$re[edate],'H',$pcode);
	
	$toDaypresent=eq_toDaypresent($re[eqId],$re[itemCode],$re[edate],'H',$pcode);
	
    $toDaypresent=$toDaypresent-$dailyworkBreakt;	
	$presentgTotal=$presentgTotal+$toDaypresent;
	
	$workt= eq_dailywork($re[eqId],$re[itemCode],$re[edate],'H',$pcode)-$dailyworkBreakt;
//	$workt= eq_dailywork($re[eqId],$re[itemCode],$edat1,'H',$project)-$dailyworkBreakt;
	$workedgTotal=$workedgTotal+$workt;
	if($workedgTotal<0)
	$workedgTotal=0;
	
	$overtimet = $toDaypresent-8*3600;
	if($overtimet<0) $overtimet=0;
	$overtimegTotal=$overtimegTotal+$overtimet;
	
	$idlet=$toDaypresent-$workt;
	  if($idlet<0) $idlet=0;
	$idlegTotal=$idlegTotal+$idlet; 
	
$presentasReggTotal=$presentasReggTotal+($toDaypresent-$overtimet);
      
}
/* till todate end*/
/* rate*/
/*$sqls = "SELECT MAX(dmaRate) as rate from `dma` WHERE dmaProjectCode='$pcode' AND dmaItemCode ='$itemCode1' ";
//echo $sqls;
$sql1=mysqli_query($db, $sqls); 
$sqlr=mysqli_fetch_array($sql1);
$rate=$sqlr[rate];
/* 
$normalDayAmountTotal=($workat/3600)*$rate; 
$mnormalDayAmountgTotalup=($mworkedgTotal/3600)*$rate;
$normalDayAmountgTotalup=($workedgTotal/3600)*$rate; */

// echo sec2hms($workat/3600,$padHours=false).' hrs.';
?> <!--</td>
 <td align="right">Tk.<? echo number_format($normalDayAmountTotal); $totalDay=$totalDay+$normalDayAmountTotal;?> </td> 
 <td align="right"><? echo sec2hms($mworkedgTotal/3600,$padHours=false).' hrs.';?></td>
 <td align="right">Tk.<? echo number_format($mnormalDayAmountgTotalup); $totalMonth=$totalMonth+$mnormalDayAmountgTotalup;?> </td>
 <td align="right"><? echo sec2hms($workedgTotal/3600,$padHours=false).' hrs.';?></td>
 <td align="right">Tk.<? echo number_format($normalDayAmountgTotalup); $totalProject=$totalProject+$normalDayAmountgTotalup;?></td>
</tr>

<tr>
 <td align="right">Present as Regular</td>
 <td align="right"><? 
 $regularAmountTotalat=(($toDaypresentat-$overtimetat)/3600)*$rate;
 $mpresentasReggAmountTotal=($mpresentasReggTotal/3600)*$rate;
 $presentasReggAmountTotal=($presentasReggTotal/3600)*$rate;
 
  echo sec2hms($toDaypresentat/3600,$padHours=false).' hrs.';?></td>
 <td align="right">Tk.<? echo number_format($regularAmountTotalat); ?></td>
 <td align="right"><? echo sec2hms($mpresentasReggTotal/3600,$padHours=false).' hrs.';?></td>
 <td align="right">Tk.<? echo number_format($mpresentasReggAmountTotal);?></td> 
 <td align="right"><? echo sec2hms($presentasReggTotal/3600,$padHours=false).' hrs.';?></td>
 <td align="right">Tk.<? echo number_format($presentasReggAmountTotal);?></td> 
</tr>
<tr>
 <td align="right">Present as Overtime</td>
 <td align="right"><? 
 $overtimeAmountTotal=($overtimetat/3600)*$rate;
 $movertimegAmountTotal=($movertimegTotal/3600)*$rate;
 $overtimegAmountTotal=($overtimegTotal/3600)*$rate;
 
 echo sec2hms($overtimetat/3600,$padHours=false).' hrs.';?></td>
 <td align="right">Tk.<? echo number_format($overtimeAmountTotal);?></td>
 <td align="right"><? echo sec2hms($movertimegTotal/3600,$padHours=false).' hrs.';?></td>
 <td align="right">Tk.<? echo number_format($movertimegAmountTotal)?></td> 
 <td align="right"><? echo sec2hms($overtimegTotal/3600,$padHours=false).' hrs.';?></td>
 <td align="right">Tk.<? echo number_format($overtimegAmountTotal)?></td> 
 <? $movertimegTotal=0;$overtimetat=0;?>
</tr> 

<tr bgcolor="#FFFFCC">
 <td >Total Present</td>
 <td align="right"><? 
 
  echo sec2hms($toDaypresentat/3600,$padHours=false).' hrs.';?></td>
 <td align="right">Tk.<? echo number_format($overtimeAmountTotal+$regularAmountTotalat);?></td>
 <td align="right"><?  echo sec2hms($mpresentgTotal/3600,$padHours=false).' hrs.';?></td>
 <td align="right">Tk.<? echo number_format($mpresentasReggAmountTotal+$movertimegAmountTotal);?></td> 
 <td align="right"><?  echo sec2hms($presentgTotal/3600,$padHours=false).' hrs.';?></td>
 <td align="right">Tk.<? echo number_format($overtimegAmountTotal+$presentasReggAmountTotal);?></td> 
</tr>
<tr >
 <td align="center"><font class="out">IDLE</font></td>
 <td align="right"><font class="out"><? echo sec2hms($idletat/3600,$padHours=false).' hrs.';?></font></td>
 <td align="right">Tk.<font class="out"><? echo number_format((($overtimeAmountTotal+$regularAmountTotalat) -$normalDayAmountTotal));?></font></td>
 <td align="right"><font class="out"><? echo sec2hms($midlegTotal/3600,$padHours=false).' hrs.';?></font></td>
 <td align="right">Tk.<font class="out"><? echo number_format((($movertimegAmountTotal+$mpresentasReggAmountTotal) -$mnormalDayAmountgTotalup));?></font></td> 
 <td align="right"><font class="out"><? echo sec2hms($idlegTotal/3600,$padHours=false).' hrs.';?></font></td>
 <td align="right">Tk.<font class="out"><? echo number_format((($overtimegAmountTotal+$presentasReggAmountTotal) -$normalDayAmountgTotalup));?></font></td> 
</tr>

<tr><td colspan="7" height="30"></td></tr>-->
<? //}
//}//designation
?>
<!--</table><br />-->
<?php //print "Day Total: ".$totalDay." Month Total: ".$totalMonth." Project Total:".$totalProject." of Actual Consumption"; ?>

<br>
<? if($pcode=='1') include('incomeStatementAll.php');
else {?>
<? if($fromDate AND $toDate){?>
<table align="center" width="750" class="vendorTable" border="1" >
<tr class="vendorAlertHd_small">
 <td>&nbsp;</td>
  <td colspan="2" align="center">Current Month</td>
  <td colspan="2" align="center">Range</td>
</tr>

<tr>
 <td bgcolor="#33FFCC" colspan="5">REVENUES</td>
</tr>
<? 

 $fromDate=formatDate($fromDate,'Y-m-j');
 $toDate=formatDate($toDate,'Y-m-j'); 

 $fromDate1= date('Y-m-j',mktime(0, 0, 0, date("m",strtotime($toDate)), 1,   date("Y",strtotime($toDate))));
 $toDate1=$toDate;
 
 
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

  $sql="select * from `accounts` WHERE  accountType='21' ORDER by accountID ASC";

//echo $sql;
  $sqlQ=mysqli_query($db, $sql);
  $r=mysql_num_rows($sqlQ);
  while($re=mysqli_fetch_array($sqlQ)){
  if($re[accountID]=='6100000')
  {$amount1=totalInvoiceAmount_date($pcode, $fromDate1,$toDate1);
  $amount=totalInvoiceAmount_date($pcode, $fromDate,$toDate);
  $totalRevenues1+=$amount1;
  $totalRevenues+=$amount;  
    }
else {$amount1=0;$amount=0;	}
  ?>
<? if( $amount !=0){?><tr>
 <td><? echo $re[accountID].' '.accountName($re[accountID]);?></td>
 <td align="right"><? echo number_format($amount1,2);?></td>
 <td><div align="right">%</div></td>
 <td align="right"><? echo number_format($amount,2);?></td>
 <td><div align="right">%</div></td>
</tr>  
<? }}?>
<tr bgcolor="#33FFCC">
 <td align="right">Total Revenues</td> 
 <td align="right"><? echo   number_format($totalRevenues1,2);?></td>
 <td></td>
  <td align="right"><? echo   number_format($totalRevenues,2);?></td>
 <td></td>  
</tr>
<tr><td height="20">&nbsp;</td></tr>
<tr bgcolor="#FFCCFF">
 <td colspan="5">COST OF SALES</td> 
</tr>
<? 
$data1=array();
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

  $sql="select * from `accounts` WHERE  accountType='23' ORDER by accountID ASC";

//echo $sql;
  $sqlQ=mysqli_query($db, $sql);
  $r=mysql_num_rows($sqlQ);
  $j=1;
  while($re=mysqli_fetch_array($sqlQ)){
  if($re[accountID]=='6801000'){
  $amount=total_mat_directissueAmount_date($pcode, $fromDate,$toDate);
  $amount1=total_mat_directissueAmount_date($pcode, $fromDate1,$toDate1);  
  }
  elseif($re[accountID]=='6802000')
  {
 $amount=0;
 $amount1=0; 
//get all itemCode and rate
 $sqlp = "SELECT itemCode, MAX(dmaRate) as rate from `dma`, eqattendance Where dmaProjectCode='$pcode' AND dmaItemCode =itemCode and itemCode >= '50-00-000' AND itemCode < '70-00-000' AND location='$pcode' group by itemCode ORDER by itemCode ASC";
	$sqlrunp= mysqli_query($db, $sqlp);
$i=0;
 while($typel= mysqli_fetch_array($sqlrunp))
		{
		 $itemdata1[$i]=$typel[itemCode];
		 $itemdata2[$i]=$typel[rate];
		 $i++;
		 }
		$_SESSION['itemdata1']=$itemdata1;
		$_SESSION['itemdata2']=$itemdata2;

  $amount=total_eq_direct_issueAmount_date1($pcode, $fromDate,$toDate); 
  $_SESSION['utiamt']=$_SESSION['utilization'];
  $amount1=total_eq_direct_issueAmount_date1($pcode, $fromDate1,$toDate1); 
  $_SESSION['utiamt1']=$_SESSION['utilization'];

// $amount=eq_ex_idle($pcode,$fromDate,$toDate);
 //$amount1=eq_ex_idle($pcode,$fromDate1,$toDate1);

 }  

 elseif($re[accountID]=='6802001')
   {
   
  $amount=$_SESSION['utiamt'];//eq_ex_utilized1($pcode, $fromDate,$toDate); // range  
 $amount1=$_SESSION['utiamt1'];//eq_ex_utilized1($pcode, $fromDate1,$toDate1); //current month
   }
  //////////////////////////////
  
  elseif($re[accountID]=='6803000'){
  //echo "test";
  $amount=sub_po_directReceive($pcode, $fromDate,$toDate);
  $amount1=sub_po_directReceive($pcode, $fromDate1,$toDate1);  
  }  
  elseif($re[accountID]=='6804000'){
/*  
  $temp=getMonth_sd_ed( $fromDate,$toDate);
  $si=sizeof($temp);
	  for($i=0;$i<=$si;$i++){
	  $fd=$temp[$i][0];
	  $td=$temp[$i][1];    
	  $subamount+=wagesAmount_date($pcode,$fd,$td);
	  }
	  $amount =$subamount;
	  $amount1=wagesAmount_date($pcode,$fromDate1,$toDate1);
*/
 $amount=wagesCostofsales($pcode,$fromDate,$toDate);
 $amount1=wagesCostofsales($pcode,$fromDate1,$toDate1); 
 	  
  }    
  else {$amount1=0;$amount=0;	}
  //echo $sql2;
$totalCostofSales1+=$amount1;
$totalCostofSales+=$amount;
$data1[$j][0]=$re[accountID].' '.accountName($re[accountID]);
$data1[$j][1]=$amount1;
$data1[$j][2]=$amount;
$j++;
}
$rr1=sizeof($data1);
if($totalCostofSales1<=0) $totalCostofSales1=1;
if($totalCostofSales<=0) $totalCostofSales=1;
for($j=1;$i<=$rr1;$j++){

  
 //$totalCostofSales+=$amount; stop 2 line by salma
  //$totalCostofSales1+=$amount1;  
  ?>
<? // if( $amount !=0 ){ //stop if by salma ?><tr>
 <td><? echo $re[accountID].' '.accountName($re[accountID]);?></td>
 <td align="right"><? //echo number_format($amount1,2);
 echo number_format($data1[$j][1],2);
 ?></td>
 <td><div align="right"><? echo round(($data1[$j][2]*100)/$totalCostofSales1);?>%</div></td>
 <td align="right"><? 
 echo number_format($data1[$j][2],2);
 //echo number_format($amount,2);?></td>
 <td><div align="right"><? echo round(($data1[$j][2]*100)/$totalCostofSales);?>%</div></td>
</tr>  
<? } //}
}?>
<tr bgcolor="#FFCCFF">
 <td align="right">Total Cost of Sales</td> 
 <td align="right"><? echo   number_format($totalCostofSales1,2);?></td>
 <td></td>
  <td align="right"><? echo   number_format($totalCostofSales,2);?></td>
 <td></td>  
</tr>
<tr><td height="20">&nbsp;</td></tr>
<? 
$GrossProfit1=$totalRevenues1-$totalCostofSales1;
$GrossProfit=$totalRevenues-$totalCostofSales;
?>
<tr bgcolor="#FFFFCC" >
 <td>GROSS PROFIT</td> 
 <td align="right"><? echo   number_format($GrossProfit1,2);?></td>
 <td></td>
  <td align="right"><? echo   number_format($GrossProfit,2);?></td>
 <td></td>  
</tr>
<tr><td height="20">&nbsp;</td></tr>
<tr bgcolor="#99CCFF" >
 <td colspan="5">EXPENSES</td> 
</tr>
<? 
$data=array();
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

  $sql="select * from `accounts` WHERE  accountType='24' ORDER by accountID ASC";

//echo $sql;
  $sqlQ=mysqli_query($db, $sql);
  $r=mysql_num_rows($sqlQ);
$i=1;  
  while($re=mysqli_fetch_array($sqlQ)){

if($re[accountID]=='6901000'){ 
	$amount=total_salaryAmount_date($pcode, $fromDate,$toDate);
	$amount1=total_salaryAmount_date($pcode, $fromDate1,$toDate1);
}  
elseif($re[accountID]=='6902000'){ 
	$amount=total_wagesAmount_date($pcode, $fromDate,$toDate);
	$amount1=total_wagesAmount_date($pcode, $fromDate1,$toDate1);

 }  
elseif($re[accountID]=='6902010'){ 
  $amount=total_mat_indirectissueAmount_date($pcode, $fromDate,$toDate);
  $amount1=total_mat_indirectissueAmount_date($pcode, $fromDate1,$toDate1);  
 }   
elseif($re[accountID]=='6903000'){ 
  $amount=sub_po_indirectReceive($pcode, $fromDate,$toDate);
  $amount1=sub_po_indirectReceive($pcode, $fromDate1,$toDate1);  
 }    
elseif($re[accountID]=='6903010'){ 
  $amount=0;
  $amount1=0;  
  /*$amount=total_eq_issueAmount_date($pcode, $fromDate,$toDate);
  $amount1=total_eq_issueAmount_date($pcode, $fromDate1,$toDate1);  
  */
 }    
else {  
$amount=total_exAmount_date($pcode, $fromDate,$toDate,$re[accountID]);
$amount1=total_exAmount_date($pcode, $fromDate1,$toDate1,$re[accountID]);
}  
//echo $sql2;
$totalExpenses1+=$amount1;
$totalExpenses+=$amount;
$data[$i][0]=$re[accountID].' '.accountName($re[accountID]);
$data[$i][1]=$amount1;
$data[$i][2]=$amount;
$i++;
}
$rr=sizeof($data);
if($totalExpenses1<=0) $totalExpenses1=1;
if($totalExpenses<=0) $totalExpenses=1;
for($i=1;$i<=$rr;$i++){
  ?>
<? if( $data[$i][2]!=0 ){ ?><tr>
 <td><? echo $data[$i][0];?></td>
 <td align="right"><? echo number_format($data[$i][1],2);?></td>
 <td align="right" class="tsilver"><? echo round(($data[$i][1]*100)/$totalExpenses1);?>%</td>
 <td align="right"><? echo number_format($data[$i][2],2);?></td>
 <td align="right" class="tsilver"><? echo round(($data[$i][2]*100)/$totalExpenses);?>%</td>
</tr>  

<? } }//for?>
<tr bgcolor="#99CCFF">
 <td align="right">Total Expense</td>
 <td align="right"><? echo number_format($totalExpenses1,2);?></td>
 <td align="right">100%</td>
 <td align="right"><? echo number_format($totalExpenses,2);?></td>
 <td align="right">100%</td>
</tr>  
<tr><td height="20">&nbsp;</td></tr>
<? 
$netIncome1=$GrossProfit1-$totalExpenses1;
$netIncome=$GrossProfit-$totalExpenses;
?>
<tr  bgcolor="#FFFFCC">
 <td ><b>NET PROFIT</b></td>
 <td align="right"><?
  echo number_format($netIncome1,2);?></td>
 <td><div align="right">%</div></td>
 <td align="right"><? 
 echo number_format($netIncome,2);?></td>
 <td><div align="right">%</div></td>
</tr> 

<tr><td height="20">&nbsp;</td></tr>
<?

$crAmount=0;$drAmount=0;
$out=1;
$array_date=array();
$openingBalance=openingBalance('5000000',$fromDate,$pcode);


$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	  

  
  $sql="select * from `invoice` WHERE  `invoiceDate` between '$fromDate' and '$toDate' 
  	    AND  `invoiceLocation`='$pcode'  
		 order by invoiceDate ASC";  

//echo $sql;
  $sqlQ=mysqli_query($db, $sql);
  $r=mysql_num_rows($sqlQ);
$k=0;  

$array_date=array();
  while($re=mysqli_fetch_array($sqlQ)){
$array_date[$i][0]=$re[invoiceDate];
$array_date[$i][1]=$re[invoiceNo];
$array_date[$i][2]=viewInvoiceType($re[invoiceType]);
$array_date[$i][3]=$re[invoiceAmount];
$array_date[$i][4]=1;
  $i++;
  }  
$sql1="select * from `receivecash` WHERE `receiveDate` between '$fromDate' AND '$toDate' 
       AND `receiveFrom` LIKE '5000000-$pcode' ORDER by receiveDate ASC";
 //echo $sql1.'<br>';
//echo $sql1;
$sqlq1=mysqli_query($db, $sql1);
while($st=mysqli_fetch_array($sqlq1)){
$array_date[$i][0]=$st[receiveDate];
$array_date[$i][1]=$st[receiveSL];
$array_date[$i][2]=$st[reff];
$array_date[$i][3]=$st[receiveAmount];
$array_date[$i][4]=2;
  $i++;
  }  
 sort($array_date);
$r=sizeof($array_date);

for($i=0;$i<$r;$i++){
					if($array_date[$i][4]=='1'){ $drAmount+=$array_date[$i][3]; }
					if($array_date[$i][4]=='2'){ $crAmount+=$array_date[$i][3];}
					$k=1;
					} 
?>
<tr bgcolor="#B1F28A">
 <td colspan="5" align="right"><div align="left"><b>Other relevent up-to-date Project Informations</b></div></td> </tr> 
<tr bgcolor="#B1F28A">

 <td colspan="5" align="right"><div align="left"><b><u>Current Assets</u></b></div></td>
 </tr>  

<? 
//$netIncome1=$GrossProfit1-$totalExpenses1;
//$netIncome=$GrossProfit-$totalExpenses;
?>
<tr  bgcolor="">
 <td >Accounts Receivable </td>
 <td align="right"><?
 // echo number_format($netIncome1,2);?></td>
 <td>&nbsp;</td>
 <td align="right"><? 
 $TCA=$openingBalance+$drAmount-$crAmount; //TCA= total current asset ?><? echo number_format($TCA,2);  ?></td>
 <td>&nbsp;</td>
</tr> 
<?
		 function WP1($iow,$p,$ed,$totalQty,$unit,$c){
		//$ed=formatDate($ed,'Y-m-j');
		$approvedTotalAmount=iowApprovedCost($iow);
		
		$totalMaretialCost=totalMaretialCost($iow,$p,$ed,$c);
		//echo "<br>**totalMaretialCost=$totalMaretialCost**<br>";
		$totalempCost=totalempCost($iow,$p,$ed,$c);
		$totalSubconCost=totalSubconCost($iow,$p,$ed,$c);
		
		//echo "<br>**totalempCost=$totalempCost**<br>";
		//$totalSubconCost=totalSubconCost($iow,$p,$ed,$c);
		//echo "<br>**totalSubconCost=totalSubconCost**<br>";
		
		$totaleqCost=totaleqCost($iow,$p,$ed,$c);
		//echo "<br>**totaleqCost=$totaleqCost**<br>";
		
		$actualTotalAmount=$totalMaretialCost+$totalempCost+$totalSubconCost+$totaleqCost;
		
		$progressp=($actualTotalAmount*100)/$approvedTotalAmount;
		
		$progressQty=($totalQty*$progressp)/100;
		 if($unit=='L.S' OR $unit=='LS' OR $unit=='l.s' OR $unit=='l.s') 
			return $progressp;
		else  
			/*if($unit=='Days' || $unit=='Month' || $unit=='Km' || $unit=='Ton'|| $unit=='m' || $unit=='Joint' || $unit=='No') return $progressQty; else  return $unit; */
			return $progressQty;
		}
 
 
			function WP2($iow,$p,$ed,$totalQty,$unit,$c){
			//$ed=formatDate($ed,'Y-m-j');
			$approvedTotalAmount=iowApprovedCost($iow);
			
			$totalMaretialCost=totalMaretialCost($iow,$p,$ed,$c);
			//echo "<br>**totalMaretialCost=$totalMaretialCost**<br>";
			$totalempCost=totalempCost($iow,$p,$ed,$c);
			$totalSubconCost=totalSubconCost($iow,$p,$ed,$c);
			
			//echo "<br>**totalempCost=$totalempCost**<br>";
			//$totalSubconCost=totalSubconCost($iow,$p,$ed,$c);
			//echo "<br>**totalSubconCost=totalSubconCost**<br>";
			
			$totaleqCost=totaleqCost($iow,$p,$ed,$c);
			//echo "<br>**totaleqCost=$totaleqCost**<br>";
			
			$actualTotalAmount=$totalMaretialCost+$totalempCost+$totalSubconCost+$totaleqCost;
			
			$progressp=($actualTotalAmount*100)/$approvedTotalAmount;
			
			$progressQty=($totalQty*$progressp)/100;
			 if($unit=='L.S' OR $unit=='LS' OR $unit=='l.s' OR $unit=='l.s') 
				return $unit;
			else  
				if($unit=='')return $unit=0; else  return $unit;
			}
			 
 
 
 
 
 
 $TWP=0;
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	  


$sql = "SELECT * from `iow` WHERE 1
 AND iowProjectCode= '$pcode' 
 AND iowType='1'  ORDER by iowId ASC";

$ed=$todat;
//echo $sql;
$sqlrunp= mysqli_query($db, $sql);
$i=1;



?>


<tr  bgcolor="">
 <td >Work in Progress </td>
 <td colspan="2" align="right"><?  
 
 
 while($iow=mysqli_fetch_array($sqlrunp)){

		
	if(WP2($iow[iowId],$iow[iowProjectCode],$ed,$iow[iowQty],$iow[iowUnit],0)=='LS' || WP2($iow[iowId],$iow[iowProjectCode],$ed,$iow[iowQty],$iow[iowUnit],0)=='L.S' || WP2($iow[iowId],$iow[iowProjectCode],$ed,$iow[iowQty],$iow[iowUnit],0)=='l.s' || WP2($iow[iowId],$iow[iowProjectCode],$ed,$iow[iowQty],$iow[iowUnit],0)=='l.s'){
		
		 $workComplited = WP1($iow[iowId],$iow[iowProjectCode],$ed,$iow[iowQty],$iow[iowUnit],0); //echo "--";
			
		 $invoicedQty=invoicedQty($iow[iowId]); //echo "--";
			
		 $rate=$iow[iowPrice]; //echo "--#";
			
		 $TWP+=((($workComplited-$invoicedQty)*$rate)/100); //echo "<br>"; //TWP= total work in progress
		}
		
		else
		{
		 $workComplited2 = WP1($iow[iowId],$iow[iowProjectCode],$ed,$iow[iowQty],$iow[iowUnit],0); //echo "--";
			
		 $invoicedQty2=invoicedQty($iow[iowId]); //echo "--";
			
		 $rate2=$iow[iowPrice]; //echo "--|";
		//echo $cl3=$workComplited2-$invoicedQty2; echo "(";
		//echo $cal4=($workComplited2-$invoicedQty2)*$rate2; echo ")";
		
		 $calculatedvalue=($workComplited2-$invoicedQty2)*$rate2; //echo "==";
			
		 $TWP+=$calculatedvalue; //echo "<br>";
		}
}
 
 ?></td>
 <td align="right"><? echo number_format($TWP,2);  ?></td>
 <td>&nbsp;</td>
</tr> 

<tr  bgcolor="">
  <td >Other Current Assets </td>
  <td align="right">&nbsp;</td>
  <td>&nbsp;</td>
  <td align="right">&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<? 
//$fromDate=formatDate($fromDate,'Y-m-j');
 //$toDate=formatDate($toDate,'Y-m-j');  
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

$i=1;
 ?>
 
<?  $sql3="select * from `accounts` ORDER by accountID ASC";
$sqlq=mysqli_query($db, $sql3);
while($re=mysqli_fetch_array($sqlq)){
if($re[accountID]=='5502000'){	$balanceSideCash=cashonHand($pcode,$fromDate,$toDate,'2');	}


}

?>

<tr  bgcolor="">
  <td >Site Cash </td>
  <td align="right">&nbsp;</td>
  <td>&nbsp;</td>
  <td align="right"><? echo number_format($balanceSideCash,2); ?></td>
  <td>&nbsp;</td>
</tr>
<?
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

//$sql="SELECT DISTINCT itemCode FROM store$pcode WHERE 1 AND currentQty <> 0 ";	
$sql="SELECT DISTINCT itemCode FROM store$pcode WHERE itemCode between '01-01-001' and '99-99-999' ";
$TI=0;
$sqlquery=mysqli_query($db, $sql);
$i=0;
$total=0;	
while($sqlresult=mysqli_fetch_array($sqlquery)){	

$amount=mat_stock_rate($pcode,$sqlresult[itemCode],$toDate);

$TI+=$amount;    //TI = total inventory
}




?>

<tr  bgcolor="">
  <td >Raw Material Inventory </td>
  <td align="right">&nbsp;</td>
  <td>&nbsp;</td>
  <td align="right"><? echo number_format($TI,2); ?></td>
  <td>&nbsp;</td>
</tr>

<tr  bgcolor="#B1F28A">
  <td  align="right"><b>Total Current Assets </b></td>
  <td align="right">&nbsp;</td>
  <td>&nbsp;</td>
  <td align="right"><b><? echo number_format($TCA+$TWP+$TI+$balanceSideCash,2); ?></b></td>
  <td>&nbsp;</td>
</tr>

<tr  bgcolor="#B1F28A">
  <td colspan="5"  align="right">&nbsp;</td>
  </tr>
  
  <tr  bgcolor="#B1F28A">
    <td colspan="5" ><u><b>Current Liabilities</b></u></td>
    </tr>
	<?
	 $crAmount=0;
	 $drAmount=0;
 $k=0;

$openingBalance=0;

$array_date=array();
$baseOpening=baseOpening('2401000',$pcode);
$openingBalance=$baseOpening+openingBalance('2401000',$fromDate,$pcode);
  
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
	
	$sql="SELECT SUM( receiveQty * rate )as amount, `todat`,`paymentSL`, `itemCode`,`reference` 
	FROM `store$pcode` 
	WHERE `todat` between '$fromDate' and '$toDate' 
	AND `paymentSL` LIKE 'PO%' 
	GROUP BY todat,`paymentSL` order by todat ASC ";
//echo $sql;
  $sqlQ=mysqli_query($db, $sql);
  $r=mysql_num_rows($sqlQ);
$i=0;  
  while($st=mysqli_fetch_array($sqlQ)){
  $array_date[$i][0]=$st[todat];
  $array_date[$i][1]=viewposl($st[paymentSL]);  
  $array_date[$i][2]=$st[reference];
  $array_date[$i][3]=$st[amount];  
  $array_date[$i][4]=2;  
  $i++;  
  }
  
	$sql="SELECT SUM( receiveQty * rate )as amount, `todat`,`paymentSL`, `itemCode`,`reference` ".
	" FROM `storet$pcode` WHERE `todat` between '$fromDate' and '$toDate' 
	AND `paymentSL` LIKE 'ST_%'GROUP BY `paymentSL` order by todat ASC ";
	  
//echo $sql;
  $sqlQ=mysqli_query($db, $sql);
  $r=mysql_num_rows($sqlQ);

  while($st=mysqli_fetch_array($sqlQ)){
  $array_date[$i][0]=$st[todat];
  $array_date[$i][1]=$st[paymentSL];  
  $array_date[$i][2]=$st[reference];
  $array_date[$i][3]=$st[amount];  
  $array_date[$i][4]=2;  
  $i++;  
  }  
$sql1="SELECT `paidAmount` as amount,`paymentSL`,`paymentDate`,`posl` from `vendorpayment` WHERE".
" `paymentDate` BETWEEN '$fromDate' AND '$toDate' AND `posl` LIKE 'PO_".$pcode."_%' Order by paymentDate ASC";
//echo $sql1;
$sqlq1=mysqli_query($db, $sql1);
while($st=mysqli_fetch_array($sqlq1)){
if(poType($st[posl])==1){
$array_date[$i][0]=$st[paymentDate];
$array_date[$i][1]=$st[paymentSL];
$array_date[$i][2]='';
$array_date[$i][3]=$st[amount];
$array_date[$i][4]=1;
  $i++;
  }//if(poType($r[posl])==1)
  }
	
	$r=sizeof($array_date);
for($i=0;$i<$r;$i++){
if($array_date[$i][4]=='1'){ $drAmount+=$array_date[$i][3];}
if($array_date[$i][4]=='2'){ $crAmount+=$array_date[$i][3];}

					}
	
	$totalmaterial=$openingBalance+$drAmount-$crAmount;
	
	
	//equipment
	
	$drAmount=0;
$crAmount=0;
$openingBalance=0;

$array_date=array();
//$openingBalance=openingBalance('2402000',$fromDate,$pcode);
$openingBalance=0;
	
    $sql="select COUNT(id) as total,`itemCode`,`posl` 
	from `eqattendance`  
	WHERE `edate` between '$fromDate' and '$toDate' 
	AND `location` ='$pcode' 
    group by posl,itemCode 
	order by edate ASC ";
//echo "$sql<b><br>";
  $sqlQ=mysqli_query($db, $sql);
$i=0;  
  while($st=mysqli_fetch_array($sqlQ)){
	$pamount=0;
	$wamount=0;
	$dailyworkBreakt=0;
	$toDaypresent=0;
	$toDaypresent=0;
	$workt=0;
	$rate=0;
	
	$rate=eqpoRate($st[itemCode],$st[posl]);
	$pamount=$st[total]*$rate;

  $array_date[$i][0]=$st[edate];
  $array_date[$i][1]=$st[posl];  
  $array_date[$i][2]=' eq present';
  $array_date[$i][3]=$pamount;  
  $array_date[$i][4]=2;  
  $i++;  
  }//while st
  
  $sql1="SELECT `paidAmount` as amount,`paymentSL`,`paymentDate`,`posl` 
from `vendorpayment` 
WHERE `paymentDate` BETWEEN '$fromDate' AND '$toDate' 
AND `posl` LIKE 'EQ_".$pcode."_%' 
Order by paymentDate ASC";
//echo $sql1;
$sqlq1=mysqli_query($db, $sql1);
while($st=mysqli_fetch_array($sqlq1)){

$array_date[$i][0]=$st[paymentDate];
$array_date[$i][1]=$st[paymentSL];
$array_date[$i][2]='';
$array_date[$i][3]=$st[amount];
$array_date[$i][4]=1;
  $i++;
  }
  
  $r=sizeof($array_date);
for($i=0;$i<$r;$i++){

if($array_date[$i][4]=='1'){ $drAmount+=$array_date[$i][3];}
if($array_date[$i][4]=='2'){ $crAmount+=$array_date[$i][3];}

					}
	
	$totaleqpment=$openingBalance+$drAmount-$crAmount;
	
	
//sub contract

$drAmount=0;
$crAmount=0;
$openingBalance=0;

$array_date=array();
$openingBalance=openingBalance('2403000',$fromDate,$pcode);
  
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
	
	$sql="SELECT SUM( qty*rate )as amount, `edate`,`posl` ".
	" FROM `subut` WHERE `edate` between '$fromDate' and '$toDate'
	 AND `posl` LIKE 'PO_".$pcode."_%' GROUP BY `posl`,`edate` order by edate ASC ";
//echo $sql;
  $sqlQ=mysqli_query($db, $sql);
  $r=mysql_num_rows($sqlQ);
$i=0;  
  while($st=mysqli_fetch_array($sqlQ)){
  $array_date[$i][0]=$st[edate];
  $array_date[$i][1]=$st[posl];  
  $array_date[$i][2]='received';
  $array_date[$i][3]=$st[amount];  
  $array_date[$i][4]=2;  
  $i++;  
  }
  
$sql1="SELECT `paidAmount` as amount,`paymentSL`,`paymentDate`,`posl` from `vendorpayment` WHERE".
" `paymentDate` BETWEEN '$fromDate' AND '$toDate' AND `posl` LIKE 'PO_".$pcode."_%' Order by paymentDate ASC";
//echo $sql1;
$sqlq1=mysqli_query($db, $sql1);
while($st=mysqli_fetch_array($sqlq1)){
if(poType($st[posl])==3){
$array_date[$i][0]=$st[paymentDate];
$array_date[$i][1]=$st[paymentSL];
$array_date[$i][2]='';
$array_date[$i][3]=$st[amount];
$array_date[$i][4]=1;
  $i++;
  }//if(poType($r[posl])==1)
  }
 	
	
	$r=sizeof($array_date);
for($i=0;$i<$r;$i++){

if($array_date[$i][4]=='1'){ $drAmount+=$array_date[$i][3];}
if($array_date[$i][4]=='2'){ $crAmount+=$array_date[$i][3];}

					}
	
	$totalsubcontract=$openingBalance+$drAmount-$crAmount;
	
	
	?>
	<tr  bgcolor="">
    <td >Accounts Payable </td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><? echo number_format($totalmaterial+$totaleqpment+$totalsubcontract,2);?></td>
    <td>&nbsp;</td>
  </tr>
    <tr  bgcolor="">
      <td >Other Current Liabilities </td>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr  bgcolor="#B1F28A">
  <td ><div align="right"><b>Total Current Liabilities </b></div></td>
  <td align="right">&nbsp;</td>
  <td>&nbsp;</td>
  <td align="right"><b><? echo number_format($totalmaterial+$totaleqpment+$totalsubcontract,2);?></b></td>
  <td>&nbsp;</td>
</tr>
</table>
<?  }//if($fromDate AND $toDate){?>
</form>
<? }//else pcode?>
<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
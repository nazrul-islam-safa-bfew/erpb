
<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
<link href="./style/thePrinter.css" />
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
ini_set("memory_limit","512M");
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
ini_set("memory_limit","512M");
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
//include "employee/local_emputReport_c_for_income_satement1.php";

function count_normal_day_differently($toDate,$fromDate,$pcode){
$ch = curl_init();
$headers["Content-Length"] = strlen($postString);
$headers["User-Agent"] = "Curl/1.0";

curl_setopt($ch, CURLOPT_URL, $requestUrl);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, 'admin:');
curl_setopt($ch,CURLOPT_TIMEOUT,60000);
$response = curl_exec($ch);
curl_close($ch);
//set_time_limit(0);
ini_set("memory_limit","512M");
ini_set("max_execution_time","60000");
	
	include "employee/local_emputReport_c_for_income_satement.php";	
	$total_idle_amount_with_usages[0]=$total_idle_amount;
	$total_idle_amount_with_usages[1]=$normalDayAmountgTotalup_finual;
	
		return $total_idle_amount_with_usages;
		
	}

/*
 $new_fromDate=formatDate($fromDate,'Y-m-j');
 $new_toDate=formatDate($toDate,'Y-m-j');
*/

function all_list_of_data($toDate,$fromDate,$pcode){
	//echo $fromDate;
	
	//if($fromDate<='2014-01-31' & $toDate>='2014-02-01')
	{
		 $total_idle_amount_with_usages=count_normal_day_differently(date("d/m/Y",strtotime($toDate)),date("d/m/Y",strtotime($fromDate)),$pcode);
		 $normal_dday=0;


	/*
	$new_fromDate='2014-02-01';
	

	$si=((strtotime($toDate)-strtotime($new_fromDate))/86400)+1;
	$i=0;
  for($j=0;$j<$si;$j++){
	  
	$fd=date("Y-m-d",strtotime($new_fromDate)+(86400*$j));	
	$td=$fd;  	
	$my_fdate=date("d/m/Y",strtotime($new_fromDate)+(86400*$j));	
	
	$normal_dday=get_normalDayAmountgTotalup_finual_for_report($my_fdate,$my_fdate,$pcode);	
	$idle_amount+=$normal_dday[0];
	$utilize+=$normal_dday[1];	
	
	
  }// end of for
  
  */
  
  $idle_amount+=$total_idle_amount_with_usages[0];
  $utilize+=$total_idle_amount_with_usages[1];
  
}//end of if
//else
//{
	/*	
	$normal_dday=0;
	$si=((strtotime($toDate)-strtotime($fromDate))/86400)+1;
	$i=0;
  for($j=0;$j<$si;$j++){
	  
	$fd=date("Y-m-d",strtotime($fromDate)+(86400*$j));	
	$td=$fd;  	
	$my_fdate=date("d/m/Y",strtotime($fromDate)+(86400*$j));	
	
	$normal_dday=get_normalDayAmountgTotalup_finual_for_report($my_fdate,$my_fdate,$pcode);
	
	$idle_amount+=$normal_dday[0];
	$utilize+=$normal_dday[1];
	
  }//end of for
	
}//end of else
*/

  
  $the_all_amount[]=$idle_amount+$total_idle_amount_with_usages[0];
  $the_all_amount[]=$utilize+$total_idle_amount_with_usages[1];
  return $the_all_amount;
  
}//end of function


function get_ready_wages_data($toDate,$fromDate,$pcode){
	
$sql="select sum(idle) as idle_amount,sum(utilize) as utilize_amount from direct_labour_work where working_date>='$fromDate' and working_date<='$toDate' and location='$pcode'";	
	//echo $sql="select sum(idle) as idle_amount,sum(utilize) as utilize_amount from direct_labour_work where working_date>='2013-12-01' and working_date<='2013-12-31' and location='193'";
	$res=mysqli_query($db, $sql);
	$row=mysql_fetch_row($res);
	return $row;
	
}



?>
<form name="gl" action="./index.php?keyword=income+statement" method="post">
<table align="center"  width="500"  border="0" class="blue print_width" >
 <tr bgcolor="#CCCCFF">
 <td align="right" valign="top" height="30" colspan="4"><font class='englishheadblack'>income statement</font></td>
</tr>

 <tr>
	   <td colspan="4">Project: 
<!-- 	  <select name='pcode' size='1' onChange="location.href='index.php?keyword=cash+disbursment&pcode='+cdj.pcode.options[document.cdj.pcode.selectedIndex].value+'&fromDate='+cdj.fromDate.value+'toDate='+cdj.toDate.value";> -->
      <select name="pcode" size="1">
	  <? if($loginDesignation!='Project Manager'){ ?><option value="0">Select Project</option> 
     <option value="1" <? if($pcode==1) echo " SELECTED "?>>All BFEW</option>  	  
	<? 
	 }
	include("config.inc.php");
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
		
	if($loginDesignation=='Project Manager')
	$sqlp = "SELECT `pcode`,pname from `project` where pcode='$loginProject'";
	else
	$sqlp = "SELECT * from `project` ORDER by pcode ASC";
	//echo $sqlp;
	$sqlrunp= mysqli_query($db, $sqlp);
	
	 while($typel= mysqli_fetch_array($sqlrunp))
	{
	 echo "<option value='".$typel[pcode]."'";
	 if($pcode==$typel[pcode]) echo "SELECTED";
	 echo ">$typel[pcode]--$typel[pname]</option>  ";
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

 <tr class="noPrint"><td colspan="4" align="center"><input type="button" name="go" value="Go" onClick="gl.submit();" class="noPrint"></td></tr>
</table>
<br>


<!--<table align="center" width="600" border="3"  bgcolor="#CCCCCC" cellpadding="2" cellspacing="0" style="border-collapse:collapse">
<tr>	
   <td width=250>Group</td>
      <td >-->
 <!--</td>
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
 
  echo sec2
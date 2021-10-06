<div id="spinContainer">
	<div id="spinLoader">
	</div>
	<div id="StatusTxt">
	</div>
</div>
<!-- <h1>
	<center>Under construction.</center>
</h1> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="./js/spiner.js"></script>
<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
<script type="text/javascript">
var opts = {
  lines: 13 // The number of lines to draw
, length: 0 // The length of each line
, width: 2 // The line thickness
, radius: 14 // The radius of the inner circle
, scale: 2.5 // Scales overall size of the spinner
, corners: 0 // Corner roundness (0..1)
, color: '#fff' // #rgb or #rrggbb or array of colors
, opacity: 0.1 // Opacity of the lines
, rotate: 0 // The rotation offset
, direction: 1 // 1: clockwise, -1: counterclockwise
, speed: 0.8 // Rounds per second
, trail: 56 // Afterglow percentage
, fps: 20 // Frames per second when using setTimeout() as a fallback for CSS
, zIndex: 2e9 // The z-index (defaults to 2000000000)
, className: 'spinner' // The CSS class to assign to the spinner
, top: '50%' // Top position relative to parent
, left: '50%' // Left position relative to parent
, shadow: true // Whether to render a shadow
, hwaccel: true // Whether to use hardware acceleration
, position: 'absolute' // Element positioning
};

var target = document.getElementById('spinLoader');
var spinner = new Spinner(opts).spin(target);
	
	$(document).ready(function(){
	var spinContainer=$("#spinContainer");
	var StatusTxt=$("#StatusTxt");
			
	var StatusTxt=$("#StatusTxt");
		$("#go").click(function(){
			var toDate=$("#toDate").val();
			var pcode=$("#pcode").val();
			var iow_url="./cache/incomeStatementCache.php?IOW_COUNT=1&pcode="+pcode;
				if(!toDate || !pcode){alert("Please select a project and To Date.");return false;}
				spinContainer.show();
				StatusTxt.html("Processing: Work in progress amount.");
				$.get(iow_url,function(data){
					if(data){
						StatusTxt.append("<br><div>Total Task Found: <span style='color:red; font-weidth:800;'>"+data+"</span></div>");
					}
				});
			var twp_url="./cache/incomeStatementCache.php?TWP=1&toDate="+toDate+"&pcode="+pcode;
				$.get(twp_url,function(data){
					if(data){
						var jason_data=JSON.parse(data);
					}
					StatusTxt.html("Processing: Accounts Payable.");
					var agedVendorPayableReportURL="./index.php?keyword=aged+vendor+payables&pcode="+pcode+"&search=1";
					$.get(agedVendorPayableReportURL,function(data){
						spinContainer.hide();
						gl.submit();
					});
				});
			});
		});
</script>
<style>
	#spinContainer{
		display:none;
		width: 100%;
    height: 100%;
    background: rgba(10,10,10,.7);
    position: fixed;
    left: 0;
    top: 0;
	}
	#StatusTxt{
		top: 80%;
    width: 100%;
    height: 100%;
    position: absolute;
    color: #fff;
    text-align: center;
	}
</style>
<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
<link href="./style/thePrinter.css" rel="stylesheet" type="text/css"/>
<?php
session_start();
error_reporting(0);

ini_set("memory_limit","4000M");
ini_set("max_execution_time","960000000000");

include('./project/siteDailyReport.f.php');

function eq_dailywork1($eqId,$itemCode,$d1,$d2,$eqType,$pcode){
global $db;
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
global $db;
  $sql1="SELECT  SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as total from  `equt`".
 " where  eqId ='$eqId' AND itemCode='$itemCode' AND edate BETWEEN '$d1' and '$d2' AND pcode=$pcode AND iow='0' AND siow='0' ";
//echo '<br>'.$sql1.'<br>';

 $sqlQuery1=mysqli_query($db, $sql1);
 $remainQty1=mysqli_fetch_array($sqlQuery1);
  if($remainQty1[total]) 
 $work= $remainQty1[total];

 return $work;
}

function eq_dailyBreakDown1($eqId,$itemCode,$d1,$d2,$eqType,$pcode){global $db;
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
function eq_toDaypresent2($eqId,$itemCode,$d1,$d2,$eqType,$pcode){global $db;
 $sql="select (SUM(60+ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)))) as duration
	from eqattendance
	WHERE eqId= '$eqId' AND itemCode= '$itemCode' AND edate BETWEEN '$d1' and '$d2' AND location='$pcode'";
//echo '<br>'.$sql.'<br>';
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 return $rr[duration];
}



function total_eq_direct_issueAmount_date1($pcode,$fromDate,$toDate){global $db;
 $ch = curl_init();
$headers["Content-Length"] = strlen($postString);
$headers["User-Agent"] = "Curl/1.0";

curl_setopt($ch, CURLOPT_URL, $requestUrl);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, 'admin:');
curl_setopt($ch,CURLOPT_TIMEOUT,960000);
$response = curl_exec($ch);
curl_close($ch);
//set_time_limit(0);
ini_set("memory_limit","4000M");
ini_set("max_execution_time","960000");
		
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
		" and eqattendance.edate >='$fromDate' and eqattendance.edate <='$toDate'".
		" AND action in('P','HP') ORDER by itemCode ASC ";
		 $sql= mysqli_query($db, $sqlquery);
//		 print mysqli_num_rows($sql)." ";
		 while($r=mysqli_fetch_array($sql))
		 	{
//BETWEEN '$fromDate' and '$toDate'
			$workt= eq_dailywork1($r[eqId],$itemCode1,$fromDate,$toDate,'H',$pcode);
			$dailyworkBreakt=eq_dailyworkBreak1($r[eqId],$itemCode1,$fromDate,$toDate,'H',$pcode);

			$dailyBreakDown=eq_dailyBreakDown1($r[eqId],$itemCode1,$fromDate,$toDate,'H',$pcode);
			$toDaypresent=eq_toDaypresent2($r[eqId],$itemCode1,$fromDate,$toDate,'H',$pcode);
			
			$toDaypresents=$toDaypresent-$dailyworkBreakt;	
			$toDaypresentat=$toDaypresentat+$toDaypresents;
			
			// echo $workt.">>>";
			
			$workts=$workt-$dailyworkBreakt;
			 $workedgTotal=$workedgTotal+$workts;
			if($workedgTotal<0)
			$workedgTotal=0;
			$overtimet = $toDaypresents-8*3600;
			if($overtimet<0) $overtimet=0;
			$overtimetat=$overtimetat+$overtimet;
			
			$idlet=$toDaypresents-$workt;
			  if($idlet<0) $idlet=0;
			  $idletat=$idletat+$idlet; 
			}
//	echo $idlet.">>>";
	//echo $toDaypresent."::".$toDaypresents."br>>";

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
//	echo "::".$rate."||";
//	print "<br>$itemCode1 ; $workedgTotal ; $a";
   $amount=(($overtimeAmountTotal+$regularAmountTotalat) - $normalDayAmountTotal);
	}

///////////////////////////////////
 $_SESSION['utilization']=$normalDayAmountTotal;
//	echo $normalDayAmountTotal."\ ".$amount."br>>";
return $amount;
}

function total_eq_direct_issueAmount_date2($pcode,$fromDate,$toDate){global $db;
 $ch = curl_init();
$headers["Content-Length"] = strlen($postString);
$headers["User-Agent"] = "Curl/1.0";

curl_setopt($ch, CURLOPT_URL, $requestUrl);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, 'admin:');
curl_setopt($ch,CURLOPT_TIMEOUT,960000);
$response = curl_exec($ch);
curl_close($ch);
//set_time_limit(0);
ini_set("memory_limit","4000M");
ini_set("max_execution_time","960000");
		
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
		" and eqattendance.edate >='$fromDate' and eqattendance.edate <='$toDate'".
		" AND action in('P','HP') ORDER by itemCode ASC ";
		 $sql= mysqli_query($db, $sqlquery);
//		 print mysqli_num_rows($sql)." ";
		 while($r=mysqli_fetch_array($sql))
		 	{
//BETWEEN '$fromDate' and '$toDate'
			$workt= eq_dailywork1($r[eqId],$itemCode1,$fromDate,$toDate,'H',$pcode);
			$dailyworkBreakt=eq_dailyworkBreak1($r[eqId],$itemCode1,$fromDate,$toDate,'H',$pcode);

			$dailyBreakDown=eq_dailyBreakDown1($r[eqId],$itemCode1,$fromDate,$toDate,'H',$pcode);
			$toDaypresent=eq_toDaypresent2($r[eqId],$itemCode1,$fromDate,$toDate,'H',$pcode);
			
			$toDaypresents=$toDaypresent-$dailyworkBreakt;	
			$toDaypresentat=$toDaypresentat+$toDaypresents;
			
			// echo $toDaypresents.">";
			
			$workts=$workt-$dailyworkBreakt;
			 $workedgTotal=$workedgTotal+$workt;
			if($workedgTotal<0)
			$workedgTotal=0;
			$overtimet = $toDaypresents-8*3600;
			if($overtimet<0) $overtimet=0;
			$overtimetat=$overtimetat+$overtimet;
			
			$idlet=$toDaypresents-$workt;
			  if($idlet<0) $idlet=0;
			  $idletat=$idletat+$idlet; 
			}
	
	$amount+=($idlet/3600)*$rate;
// 	echo "loop>>";
 //	echo $workedgTotal.">".$rate."??";
	 $totalWorkingTaka+=($workedgTotal/3600)*$rate; 
	 $b=($overtimetat/3600)*$rate;
	 $c=(($toDaypresentat-$overtimetat)/3600)*$rate;
	
	$normalDayAmountTotal=$normalDayAmountTotal+$a; 
	$regularAmountTotalat=$regularAmountTotalat+$c;

	$overtimeAmountTotal=$overtimeAmountTotal+$b;
  
	}
	 
 $_SESSION['utilization']=$totalWorkingTaka;
return $amount;
}

function eq_ex_utilized1($pcode,$fromDate,$toDate)
  {global $db;

$ch = curl_init();
$headers["Content-Length"] = strlen($postString);
$headers["User-Agent"] = "Curl/1.0";

curl_setopt($ch, CURLOPT_URL, $requestUrl);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, 'admin:');
curl_setopt($ch,CURLOPT_TIMEOUT,960000);
$response = curl_exec($ch);
curl_close($ch);
//set_time_limit(0);
ini_set("memory_limit","4000M");
ini_set("max_execution_time","960000");

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

function count_normal_day_differently($toDate,$fromDate,$pcode){global $db;
$ch = curl_init();
$headers["Content-Length"] = strlen($postString);
$headers["User-Agent"] = "Curl/1.0";

curl_setopt($ch, CURLOPT_URL, $requestUrl);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, 'admin:');
curl_setopt($ch,CURLOPT_TIMEOUT,960000);
$response = curl_exec($ch);
curl_close($ch);
//set_time_limit(0);
ini_set("memory_limit","4000M");
ini_set("max_execution_time","960000");
// 	include "employee/local_emputReport_c_for_income_satement.php";	
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
	{global $db;
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


function get_ready_wages_data($toDate,$fromDate,$pcode){global $db;
	
$sql="select sum(idle) as idle_amount,sum(utilize) as utilize_amount from direct_labour_work where working_date>='$fromDate' and working_date<='$toDate' and location='$pcode'";	
	//echo $sql="select sum(idle) as idle_amount,sum(utilize) as utilize_amount from direct_labour_work where working_date>='2013-12-01' and working_date<='2013-12-31' and location='193'";
// echo $sql; exit;
	$res=mysqli_query($db, $sql);
	$row=mysqli_fetch_row($res);
	return $row;
	
}



?>
<form name="gl" id="gl" action="./index.php?keyword=income+statement" method="post">
<table align="center"  width="500"  border="0" class="blue print_width" >
 <tr bgcolor="#CCCCFF">
 <td align="right" valign="top" height="30" colspan="4"><font class='englishheadblack'>income statement</font></td>
</tr>

 <tr>
	   <td colspan="4">Project: 
<!-- 	  <select name='pcode' size='1' onChange="location.href='index.php?keyword=cash+disbursment&pcode='+cdj.pcode.options[document.cdj.pcode.selectedIndex].value+'&fromDate='+cdj.fromDate.value+'toDate='+cdj.toDate.value";> -->
      <select name="pcode" id="pcode" size="1">
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
    <td><input readonly="readonly" type="text" maxlength="10" name="fromDate" value="01/01/2014<? //echo $fromDate;?>" > <!--<a id="anchor" href="#"
   onClick="cal.select(document.forms['gl'].fromDate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a>-->
      </td>
    <td>To </td>
      <td><input type="text" maxlength="10" name="toDate" id="toDate" value="<? echo $toDate;?>" > <a id="anchor2" href="#"
   onClick="cal.select(document.forms['gl'].toDate,'anchor2','dd/MM/yyyy'); return false;"
   name="anchor2" ><img src="./images/b_calendar.png" alt="calender" border="0"></a>
      </td>
 </tr>

 <tr class="noPrint">
	 <td colspan="4" align="center">
	 		<input type="button" name="go" id="go" value="Go" class="noPrint">	 		
	 </td></tr>
</table>
</form>
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
<? if($pcode=='1'){ include('incomeStatementAll.php');}
else {
	if($fromDate AND $toDate){


if($_SESSION["TWP"]<0){
// 	echo "<h2><center>Work in progress amount should not be less then 0. Please try again.</center></h1>";$pcode=$toDate=$toDate1=null;
}
?>

<table align="center" width="750" border="0">
	<tr class="">
  <td><input type="button" name="" value="Print" style="float:right;" onClick="window.print();" class="noPrint"></td>
  </tr>
	</table>
	
	 
	
<table align="center" width="750" class="vendorTable" border="1" >

	
	<tr class="vendorAlertHd_small">
 <td>&nbsp;</td>
 
  <td  align="center">Month To Date</td>
  <td colspan="2" align="center">Range</td>
  </tr>

<tr>
 <td bgcolor="#33FFCC" colspan="4">REVENUES</td>
</tr>
<? 
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	  
///////////////////////////////////////////////////////////////////////////////
$IOWapproved=0;
$ManExpApp=0;
$EqExpApp=0;
$MatExpApp=0;
$sqliow="SELECT * from iow where iowProjectCode ='$pcode' AND iowType='1'";

$sqlruniow= mysqli_query($db, $sqliow);
while($resultiow=mysqli_fetch_array($sqlruniow))
{
$IOWapproved+=$resultiow[iowQty]*$resultiow[iowPrice];
$iow=$resultiow[iowId];
	
	 $sqlf = "SELECT SUM(dmaRate*dmaQty) as humanRate FROM dma WHERE dmaiow='$iow' AND dmaItemCode between '86-00-000' AND '94-99-999'";
	 $sqlQ= mysqli_query($db, $sqlf);
	 while($sqlRunf= mysqli_fetch_array($sqlQ))
	 {
	 	$ManExpApp+=$sqlRunf[humanRate];
	 }
	 
	$sqlf1 = "SELECT SUM(dmaRate*dmaQty) as equipmentRate FROM dma WHERE dmaiow='$iow' AND dmaItemCode between '50-00-000' AND '69-99-999'";
	$sqlQ1= mysqli_query($db, $sqlf1);
	while($sqlRunf1= mysqli_fetch_array($sqlQ1))
	{
		$EqExpApp+=$sqlRunf1[equipmentRate];
	}
	$sqlf2 = "SELECT SUM(dmaRate*dmaQty) as materialRate FROM dma WHERE dmaiow='$iow' AND dmaItemCode between '01-00-000' AND '35-99-999'";
	$sqlQ2= mysqli_query($db, $sqlf2);
	while($sqlRunf2= mysqli_fetch_array($sqlQ2))
	{
		$MatExpApp+=$sqlRunf2[materialRate];
	}
	 $sqlf3 = "SELECT SUM(dmaRate*dmaQty) as SubConRate FROM dma WHERE dmaiow='$iow' AND dmaItemCode between '95-00-000' AND '99-99-999'";
	 $sqlQ3= mysqli_query($db, $sqlf3);
	 while($sqlRunf3= mysqli_fetch_array($sqlQ3))
	 {
	 	$SubConExpApp+=$sqlRunf3[SubConRate];
	 }
}

$ManExpAppPer=($ManExpApp*100)/$IOWapproved;
$EqExpAppPer=($EqExpApp*100)/$IOWapproved;
$MatExpAppPer=($MatExpApp*100)/$IOWapproved;
$SubConExpAppPer=($SubConExpApp*100)/$IOWapproved;
$TotalExpAppPer=$MatExpAppPer+$EqExpAppPer+$ManExpAppPer+$SubConExpAppPer;	  
/////////////////////////////////////////////////////////////////////////////

 $fromDate=formatDate($fromDate,'Y-m-j');
 $toDate=formatDate($toDate,'Y-m-j'); 

 $fromDate1= date('Y-m-j',mktime(0, 0, 0, date("m",strtotime($toDate)), 1,   date("Y",strtotime($toDate))));
	
 $toDate1=$toDate;
 




						
// Assign TWP (Total Work in Progress) from session
$TWP=$_SESSION["TWP"];

 
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$Ttotal=0;
  $sql="select * from `accounts` WHERE  accountType='21' ORDER by accountID ASC";

//echo $sql;
  $sqlQ=mysqli_query($db, $sql);
  $r=mysqli_num_rows($sqlQ);
  while($re=mysqli_fetch_array($sqlQ)){
  if($re[accountID]=='6100000')
  {
		$amount1=totalInvoiceAmount_date($pcode,$fromDate1,$toDate1);
  	$amount=totalInvoiceAmount_date($pcode,$fromDate,$toDate);
  	$totalRevenues1+=$amount1;
  	$totalRevenues+=$amount;
  }
else {$amount1=0;$amount=0;}
//$TWP=$TWP1-$totalRevenues;
$GRNDTOT=$TWP+$totalRevenues;
$GRNDTOTwithoutWP=$totalRevenues;
		
if($GRNDTOT<0)$GRNDTOT = $GRNDTOT * -1;
 
 if($tt++==0){
	 ?>
	<script type="text/javascript">


var GrandTotalAmount=<?php echo $GRNDTOT>0 ? $GRNDTOT : 0; ?>;
var GrandTotalAmountwithoutWP=<?php echo $GRNDTOTwithoutWP>0 ? $GRNDTOTwithoutWP : 0; ?>;
var pcode='<?php echo !empty($pcode) ? $pcode : ""; ?>';
var toDate='<?php echo $toDate; ?>';
var workingCapitalAmountVal=0;

$(document).ready(function(){
	
<?php if($pcode && $toDate){ ?>
	
var totalPercentage=0;
var totalToMonth=0;
var totalToRange=0;
	
var totalToMonthn=0;
var totalToRangen=0;
var totalPercentagen=0;
	
var netProfit=$("#netProfit");
var netProfitP=$("#netProfitP");
var DtExpenseM=$("#tExpenseM");
var DtExpense=$("#tExpense");
var DtExpenseP=$("#tExpenseP");
var grossProfit=0;
var grossProfitpercentage=0;
	
	var spinContainer=$("#spinContainer");
	spinContainer.show();
	
	var StatusTxt=$("#StatusTxt");
	
	var url_6801000="./cache/incomeStatementCache.php?6801000=1&toDate="+toDate+"&iowType=1&pcode="+pcode;
	var url_680200X="./cache/incomeStatementCache.php?680200X=1&toDate="+toDate+"&iowType=1&pcode="+pcode;
	var url_6803000="./cache/incomeStatementCache.php?6803000=1&toDate="+toDate+"&iowType=1&pcode="+pcode;
	var url_6804000="./cache/incomeStatementCache.php?6804000=1&toDate="+toDate+"&iowType=1&pcode="+pcode;	
	
	var url_6801000n="./cache/incomeStatementCache.php?6801000=1&toDate="+toDate+"&iowType=2&pcode="+pcode;
	var url_680200Xn="./cache/incomeStatementCache.php?680200X=1&toDate="+toDate+"&iowType=2&pcode="+pcode;
	var url_6803000n="./cache/incomeStatementCache.php?6803000=1&toDate="+toDate+"&iowType=2&pcode="+pcode;
	var url_6804000n="./cache/incomeStatementCache.php?6804000=1&toDate="+toDate+"&iowType=2&pcode="+pcode;
	
	
	function toDigit(val){
		if($.isNumeric(val))
			 return parseFloat(val).toFixed(2);
		return val;
	}	
	function convert2Digit(a){
		a=a.toString();
		var ans=0;
		var dt=a.split(".");
		
		try{
			if(dt[1].length>2)
				ans=dt[0]+"."+dt[1][0]+""+dt[1][1];
			else
				ans=toDigit(a);
		}catch(e){
			
		}
		return ans;
	}
	
	//=================================================   6801000
	StatusTxt.html("Cost of Sales- Material");
	var ajax_6801000=$.get(url_6801000,function(data){
		if(data){
			var dt=JSON.parse(data);
			var toMonth=toDigit(dt.toMonth);
			var toRange=toDigit(dt.toRange);
			var percentage=toDigit(((toRange)*100)/GrandTotalAmount); //calculate percentage
			$("#6801000P").html(percentage);
			$("#6801000M").html(parseFloat(toMonth).toLocaleString(undefined, { minimumFractionDigits: 2 }));
			$("#6801000R").html(parseFloat(toRange).toLocaleString(undefined, { minimumFractionDigits: 2 }));

			totalToMonth+=parseFloat(toMonth);
			totalToRange+=parseFloat(toRange);
			totalPercentage+=parseFloat(parseFloat(percentage));
			StatusTxt.html("Cost of Sales- Equipment Expense");
		}
	}).fail(function(){
			alert("Error while get 'Cost of Sales- Material'");
	}).always(function(){
	//=================================================   680200X
	$.get(url_680200X,function(data){
			if(data){
				var dt=JSON.parse(data);
				//=============================idle amount
				var toMonth=toDigit(dt.toMonth.idleAmount);
				var toRange=toDigit(dt.toRange.idleAmount);
				var percentage=toDigit(((toRange)*100)/GrandTotalAmount); //calculate percentage
				$("#6802000P").html(percentage);
				$("#6802000M").html(parseFloat(toMonth).toLocaleString(undefined, { minimumFractionDigits: 2 }));
				$("#6802000R").html(parseFloat(toRange).toLocaleString(undefined, { minimumFractionDigits: 2 }));			
				totalToMonth+=parseFloat(toMonth);
				totalToRange+=parseFloat(toRange);
				totalPercentage+=parseFloat(percentage);
				
				//=========================utilized amount
				var toMonth=toDigit(dt.toMonth.utilizedAmount);
				var toRange=toDigit(dt.toRange.utilizedAmount);
				var percentage=toDigit(((toRange)*100)/GrandTotalAmount); //calculate percentage
				$("#6802001P").html(percentage);
				$("#6802001M").html(parseFloat(toMonth).toLocaleString(undefined, { minimumFractionDigits: 2 }));
				$("#6802001R").html(parseFloat(toRange).toLocaleString(undefined, { minimumFractionDigits: 2 }));

				totalToMonth+=parseFloat(toMonth);
				totalToRange+=parseFloat(toRange);
				totalPercentage+=parseFloat(percentage);
				StatusTxt.html("Cost of Sales- Equipment Expense");
			}
		});
	}).fail(function(){
			alert("Error while get 'Cost of Sales- Equipment Expense'");
	}).always(function(){
	//=================================================   6803000
	$.get(url_6803000,function(data){
			if(data){
				var dt=JSON.parse(data);
				var toMonth=toDigit(dt.toMonth);
				var toRange=toDigit(dt.toRange);
				var percentage=toDigit(((toRange)*100)/GrandTotalAmount); //calculate percentage
				console.log(percentage);
				$("#6803000P").html(percentage);
				$("#6803000M").html(parseFloat(toMonth).toLocaleString(undefined, { minimumFractionDigits: 2 }));
				$("#6803000R").html(parseFloat(toRange).toLocaleString(undefined, { minimumFractionDigits: 2 }));
				
				console.log(totalPercentage);
				totalToMonth+=parseFloat(toMonth);
				totalToRange+=parseFloat(toRange);
				totalPercentage+=parseFloat(percentage);
				StatusTxt.html("Cost of Sales- Direct Labor Expense");
				console.log(totalPercentage);
			}
		});
	}).fail(function(){
			alert("Error while get 'Cost of Sales- Direct Labor Expense'");
	}).always(function(){
	//=================================================   6804000
	$.get(url_6804000,function(data){
			if(data){
				var dt=JSON.parse(data);
				//=============================idle amount
				var toMonth=toDigit(dt.toMonth.utilizedAmount);
				var toRange=toDigit(dt.toRange.utilizedAmount);
				var percentage=toDigit(((toRange)*100)/GrandTotalAmount); //calculate percentage
				$("#6804000P").html(percentage);
				$("#6804000M").html(parseFloat(toMonth).toLocaleString(undefined, { minimumFractionDigits: 2 }));
				$("#6804000R").html(parseFloat(toRange).toLocaleString(undefined, { minimumFractionDigits: 2 }));

				totalToMonth+=parseFloat(toMonth);
				totalToRange+=parseFloat(toRange);
				totalPercentage+=parseFloat(percentage);
				//=========================utilized amount
				var toMonth=toDigit(dt.toMonth.idleAmount);
				var toRange=toDigit(dt.toRange.idleAmount);
				var percentage=toDigit(((toRange)*100)/GrandTotalAmount); //calculate percentage
				$("#6805000P").html(percentage);
				$("#6805000M").html(parseFloat(toMonth).toLocaleString(undefined, { minimumFractionDigits: 2 }));
				$("#6805000R").html(parseFloat(toRange).toLocaleString(undefined, { minimumFractionDigits: 2 }));
				
				totalToMonth+=parseFloat(toMonth);
				totalToRange+=parseFloat(toRange);
				totalPercentage+=parseFloat(percentage);

	$("#COS_M").html(totalToMonth.toLocaleString(undefined, { minimumFractionDigits: 2 }));
	$("#COS_R").html(totalToRange.toLocaleString(undefined, { minimumFractionDigits: 2 }));

 workingCapitalAmountVal=parseInt(parseFloat($("#workingCapitalAmountBox").attr("rel"))-totalToRange);



console.log(workingCapitalAmountVal);

	$("#COS_P").html(totalPercentage.toFixed(2)+"%");

				grossProfit=parseFloat(GrandTotalAmountwithoutWP)-parseFloat(totalToRange);
				grossProfitpercentage=100-parseFloat(totalPercentage);
				
// 				console.log(GrandTotalAmountwithoutWP);
// 				console.log(grossProfit);
// 				console.log(totalToRange);
				
				var currentGrossProfit;
				currentGrossProfit=grossProfit.toLocaleString(undefined,{minimumFractionDigits:2});
				//currentGrossProfit=convert2Digit(currentGrossProfit);
				$("#GrossProfit").html(currentGrossProfit);
				$("#GrossProfitP").html(grossProfitpercentage.toFixed(2)+"%");

				 var tExpense=parseFloat(DtExpense.attr("rel"));
				 var tExpenseP=parseFloat(DtExpenseP.attr("rel"));
				
				netProfit.attr("rel", (parseFloat(grossProfit)-parseFloat(tExpense)) );
				netProfitP.attr("rel", (100-(parseFloat(totalPercentage)+parseFloat(tExpenseP))) );	
				
				DtExpense.attr("netProfit",parseFloat(grossProfit)-parseFloat(tExpense));
				DtExpenseP.attr("netProfitP",parseFloat(totalPercentage)+parseFloat(tExpenseP));
			}
		});
	}).fail(function(){
			alert("Error while get 'Cost of Sales- Direct Labor Expense'");
	}).always(function(){
//=================================================   6801000n
	StatusTxt.html("Indirect- Material");
	$.get(url_6801000n,function(data){
			if(data){
				var dt=JSON.parse(data);
				//============================= amount
				var toMonth=toDigit(dt.toMonth);
				var toRange=toDigit(dt.toRange);
				var percentage=toDigit(((toRange)*100)/GrandTotalAmount); //calculate percentage
				$("#ex6801000p").html(percentage+"%");
				$("#ex6801000m").html(parseFloat(toMonth).toLocaleString(undefined, { minimumFractionDigits: 2 }));
				$("#ex6801000r").html(parseFloat(toRange).toLocaleString(undefined, { minimumFractionDigits: 2 }));		
				
				totalToMonthn+=parseFloat(toMonth);
				totalToRangen+=parseFloat(toRange);
				totalPercentagen+=parseFloat(percentage);	
			}
		}).always(function(){ //url_6801000n
			//=================================================   680200Xn
	$.get(url_680200Xn,function(data){
			StatusTxt.html("Indirect- Equipment Expense");
			if(data){
				var dt=JSON.parse(data);
				//=========================utilized amount
				var toMonth=toDigit(dt.toMonth.utilizedAmount);
				var toRange=toDigit(dt.toRange.utilizedAmount);
				var percentage=toDigit(((toRange)*100)/GrandTotalAmount); //calculate percentage
				$("#ex6802001p").html(percentage+"%");
				$("#ex6802001m").html(parseFloat(toMonth).toLocaleString(undefined, { minimumFractionDigits: 2 }));
				$("#ex6802001r").html(parseFloat(toRange).toLocaleString(undefined, { minimumFractionDigits: 2 }));


				totalToMonthn+=parseFloat(toMonth);
				totalToRangen+=parseFloat(toRange);
				totalPercentagen+=parseFloat(percentage);	
			}
		}).always(function(){ //url_680200Xn
		//=================================================   6803000
	StatusTxt.html("Indirect- Sub Contractor Expense");
	$.get(url_6803000n,function(data){
			if(data){
				var dt=JSON.parse(data);
				var toMonth=toDigit(dt.toMonth);
				var toRange=toDigit(dt.toRange);
				var percentage=toDigit(((toRange)*100)/GrandTotalAmount); //calculate percentage
				$("#ex6803000p").html(percentage+"%");
				$("#ex6803000m").html(parseFloat(toMonth).toLocaleString(undefined, { minimumFractionDigits: 2 }));
				$("#ex6803000r").html(parseFloat(toRange).toLocaleString(undefined, { minimumFractionDigits: 2 }));
				
				totalToMonthn+=parseFloat(toMonth);
				totalToRangen+=parseFloat(toRange);
				totalPercentagen+=parseFloat(percentage);
			}
	}).always(function(){
		
	//=================================================   6804000n
	$.get(url_6804000n,function(data){
			if(data){
				var dt=JSON.parse(data);
				//=========================utilized amount
				var toMonth=toDigit(dt.toMonth.utilizedAmount);
				var toRange=toDigit(dt.toRange.utilizedAmount);
				var percentage=toDigit(((toRange)*100)/GrandTotalAmount); //calculate percentage
				$("#ex6804000p").html(percentage+"%");
				$("#ex6804000m").html(parseFloat(toMonth).toLocaleString(undefined, { minimumFractionDigits: 2 }));
				$("#ex6804000r").html(parseFloat(toRange).toLocaleString(undefined, { minimumFractionDigits: 2 }));
				
				totalToMonthn+=parseFloat(toMonth);
				totalToRangen+=parseFloat(toRange);
				totalPercentagen+=parseFloat(percentage);


				var cExM=DtExpenseM.attr("rel");
				var cEx=DtExpense.attr("rel");
				var cExp=DtExpenseP.attr("rel");

var currentDtExpenseM=(parseFloat(cExM)+parseFloat(totalToMonthn)).toLocaleString(undefined,{minimumFractionDigits:2});
DtExpenseM.html(convert2Digit(currentDtExpenseM));

console.log(workingCapitalAmountVal);
workingCapitalAmountVal=workingCapitalAmountVal-(parseFloat(cEx)+parseFloat(totalToRangen));
				
				
	if(workingCapitalAmountVal<0)workingCapitalAmountVal="("+(workingCapitalAmountVal*(-1)).toLocaleString(undefined,{minimumFractionDigits:2})+")";
	else workingCapitalAmountVal=workingCapitalAmountVal.toLocaleString(undefined,{minimumFractionDigits:2});
				
$("#workingCapitalAmountBox").html(workingCapitalAmountVal);
console.log(workingCapitalAmountVal);

var currentDtExpense=(parseFloat(cEx)+parseFloat(totalToRangen)).toLocaleString(undefined,{minimumFractionDigits:2});
DtExpense.html(currentDtExpense);


var currentDTExpenseP=(parseFloat(cExp)+parseFloat(totalPercentagen)).toLocaleString(undefined,{minimumFractionDigits:2});
DtExpenseP.html(convert2Digit(currentDTExpenseP));

				DtExpenseM.attr("rel",(parseFloat(cExM)+parseFloat(totalToMonthn)));
				DtExpense.attr("rel",(parseFloat(cEx)+parseFloat(totalToRangen)));
				DtExpenseP.attr("rel",(parseFloat(cExp)+parseFloat(totalPercentagen)));

				cExM=DtExpenseM.attr("rel");
				cEx=DtExpense.attr("rel");
				cExp=DtExpenseP.attr("rel");
var currentProfit=(parseFloat(grossProfit)-parseFloat(cEx)).toLocaleString(undefined,{minimumFractionDigits:2});
var currentProfitP=(((parseFloat(grossProfitpercentage)-parseFloat(cExp))).toFixed(2));
				
				currentProfit=convert2Digit(currentProfit);
				currentProfitP=convert2Digit(currentProfitP);
				
				netProfit.html(currentProfit);
				netProfitP.html(currentProfitP);

spinContainer.hide();
			}
		});
	});  //url_680400Xn always

		});  //url_680200Xn always
		}); //url_6801000n always
	}); //6801000n always
<?php } //if pcode and toDate ?>
});



</script>
	
	<?php
 }
	
		
		
  ?>
<? if( $amount !=0){?><tr>
 <td><? echo $re[accountID].' '.accountName($re[accountID]);?></td>
 <td align="right"><? echo number_format($amount1,2);?></td>
 <!--<td><div align="right"><? echo number_format((($amount1*100)/$GRNDTOT),2);?>%</div></td>-->
 <td align="right"><? echo number_format($amount,2);?></td>
 <td><div align="right"><?  $tot=($amount*100)/$GRNDTOT;
 echo number_format($tot,2);
 ?>%</div></td>
</tr>
<? }
 $Ttotal=$Ttotal+$tot;
}?>
<tr bgcolor="#33FFCC">
 <td align="right">Total Revenues</td> 
 <td align="right"><strong><? echo   number_format($totalRevenues1,2);?></strong></td>
 <!--<td></td>-->
  <td align="right"><strong><? echo   number_format($totalRevenues,2);?></strong></td>
 <td><!--<div align="right">
 <? 

 echo number_format($Ttotal,2); 
 ?>%</div>--></td>  
</tr>
<tr><td height="20">&nbsp;</td></tr>
<tr bgcolor="#FFCCFF">
 <td colspan="4">COST OF SALES</td> 
</tr>
<? 
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$Ttotalcostofsales=0;
  $sql="select * from `accounts` WHERE  accountType='23' ORDER by accountID ASC";

//echo $sql;
  $sqlQ=mysqli_query($db, $sql);
  $r=mysqli_num_rows($sqlQ);
  while($re=mysqli_fetch_array($sqlQ)){
  if($re[accountID]=='6801000'){
  }
  elseif($re[accountID]=='6802000')
  {


 }  

 elseif($re[accountID]=='6802001')
   {
   
 
   }
  //////////////////////////////
  
  elseif($re[accountID]=='6803000'){
 
  }   
  else {$amount1=0;$amount=0;	}
  
   if($re[accountID]=='6805000') //for idle amount
 {
	
 }
 elseif($re[accountID]=='6804000') // for utilize amount
 {
 }
  
  
  $totalCostofSales+=$amount;
  $totalCostofSales1+=$amount1;  
  ?>
<?


 
 
{
 ?>
 <tr>
 <td><? 
 if($re[accountID]!='6804000' & $re[accountID]!='6805000') 
 echo $re[accountID].' '.accountName($re[accountID]);
 else
 echo $re[accountID].' '.accountName($re[accountID])."";
 
 
 ?>
 </td>
 <td align="right">
  <? if($re[accountID]=='6802000'|| $re[accountID]=='6805000')
  {
	  echo "<font color='#FF0000' id='".$re[accountID]."M'>";
	 echo number_format($amount1,2);
	 echo "</font>";
  }
  else{
	  echo "<font color='#000' id='".$re[accountID]."M'>";
   echo number_format($amount1,2);
	 echo "</font>";
	}
 ?>
 </td>
 <!--<td><div align="right" class="suvro"><? echo $GRNDTOT; ?>%</div></td>-->

 <td align="right"><?
 
 if($re[accountID]!='6804000' & $re[accountID]!='6805000')
 {
	 if($re[accountID]=='6802000')
	 {
		 echo "<font color='#FF0000' id='".$re[accountID]."R'>";
		 echo number_format($amount,2);
		 echo "</font>";
	 }
	 else{
	  echo "<font color='#000' id='".$re[accountID]."R'>";
	  echo number_format($amount,2);
		echo "</font>";
	 }
 }
 elseif($re[accountID]=='6805000')
 {
	  echo "<font color='#FF0000' id='".$re[accountID]."R'>";
	 $amount=$_SESSION[idle_amount];
	 echo number_format($amount,2);
	  echo "</font>";
	//$amount=$total_idle_amount;
 }
 elseif($re[accountID]=='6804000')
 {
	  echo "<font color='#000' id='".$re[accountID]."R'>";
	 echo number_format($amount,2);
	  echo "</font>";
 }


 ?></td>
 <td><div align="right">
 <?
 
 
  if($re[accountID]!='6804000' & $re[accountID]!='6805000')
  {
	
	 $tcostofsales=($amount*100)/$GRNDTOT;
	  if($re[accountID]=='6802000')
  		{
	 		echo "<font color='#FF0000' id='".$re[accountID]."P'>";
			echo number_format($tcostofsales,2);
			echo "</font>";
		}
		else{
	 		echo "<font color='' id='".$re[accountID]."P'>";
			echo number_format($tcostofsales,2);
			echo "</font>";
		}
  }
  elseif($re[accountID]=='6805000')
  {
	 $tcostofsales=($amount*100)/$GRNDTOT; //total_idle_amount
	 echo "<font color='#FF0000' id='".$re[accountID]."P'>";
	 echo number_format($tcostofsales,2);
	 echo "</font>";
  }
  elseif($re[accountID]=='6804000')
  {
	 $tcostofsales=($amount*100)/$GRNDTOT; //normalDayAmountgTotalup_finual
	 echo "<font color='' id='".$re[accountID]."P'>";
	 echo number_format($tcostofsales,2);
	 echo "</font>";
  } 
  
 
 ?>%</div></td>
 
<? }
 $Ttotalcostofsales=$Ttotalcostofsales+$tcostofsales;
 
 
}?></tr> 
<tr bgcolor="#FFCCFF">
 <td align="right">Total Cost of Sales</td> 
 <td align="right"><strong id="COS_M"><? echo   number_format($totalCostofSales1,2);?></strong></td>
 <!--<td></td>-->
  <td align="right"><strong id="COS_R"><? echo   number_format($totalCostofSales,2);?></strong></td>
 <td><strong><div align="right" id="COS_P">
 <?
$storeCostofsales=$totalCostofSales;
 echo number_format($Ttotalcostofsales,2); 
 ?>%</div></strong>
 </td>  
</tr>
<tr><td height="20">&nbsp;</td></tr>
<? 
$GrossProfit1=$totalRevenues1-$totalCostofSales1;
$GrossProfit=($totalRevenues+$TWP)-$totalCostofSales;
?>
<tr bgcolor="#FFFFCC" >
 <td>GROSS PROFIT (Revenue - COS)</td> 
 <td align="right"><? //echo   number_format($GrossProfit1,2);?></td>
 <!--<td></td>-->
  <td align="right"><strong id="GrossProfit"><? echo   number_format($GrossProfit1,2);?></strong></td>
 <td><strong><div align="right" id="GrossProfitP"><?
 $Gprofit=100-$Ttotalcostofsales;
//  echo number_format($Gprofit,2);?>0.00%</div></strong></td>  
</tr>
<tr><td height="20">&nbsp;</td></tr>
<tr bgcolor="#99CCFF" >
 <td colspan="4">EXPENSES</td> 
</tr>
	
	<tr>
		<td>6801000 Indirect- Material Expense</td> 
		<td id="ex6801000m" align=right></td>
		<td id="ex6801000r" align=right></td>
		<td id="ex6801000p" align=right style="font-size:9px;"></td>
	</tr>	
	<tr>
		<td>6802001 Indirect- Equipment Expense</td> 
		<td id="ex6802001m" align=right></td>
		<td id="ex6802001r" align=right></td>
		<td id="ex6802001p" align=right style="font-size:9px;"></td>
	</tr>
	<tr>
		<td>6803000 Indirect- Sub Contractor Expense</td> 
		<td id="ex6803000m" align=right></td>
		<td id="ex6803000r" align=right></td>
		<td id="ex6803000p" align=right style="font-size:9px;"></td>
	</tr>
	<tr>
		<td>6804000 Indirect- Labor Expense</td>
		<td id="ex6804000m" align=right></td>
		<td id="ex6804000r" align=right></td>
		<td id="ex6804000p" align=right style="font-size:9px;"></td>
	</tr>
	
<? 
$data=array();
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$Ttexpense=0;
$sql="select * from `accounts` WHERE  accountType='24' ORDER by accountID ASC";

// echo $sql;

// exit;
  $sqlQ=mysqli_query($db, $sql);
  $r=mysqli_num_rows($sqlQ);
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
	elseif($re[accountID]=='6902010' && 1==2){//stop by suvro through sir
	$amount=total_mat_indirectissueAmount_date($pcode, $fromDate,$toDate);
	$amount1=total_mat_indirectissueAmount_date($pcode, $fromDate1,$toDate1);  
	}
	elseif($re[accountID]=='6903000' && 2==1){//stop by suvro through sir
	$amount=sub_po_indirectReceive($pcode, $fromDate,$toDate);
	$amount1=sub_po_indirectReceive($pcode, $fromDate1,$toDate1);  
	}
		
		
		
	elseif($re[accountID]=='7024000'){ //TAX
	$amount1=0;
	$amount=getInvoiceTax($pcode, $fromDate1,$toDate1);  
	}	
	elseif($re[accountID]=='7026000'){ //VAT
	$amount1=0;
	$amount=getInvoiceVat($pcode, $fromDate1,$toDate1);
	}
		
		
		
		
	elseif($re[accountID]=='6903010'){
	$amount=0;
	$amount1=0;
	/*
		$amount=total_eq_issueAmount_date($pcode, $fromDate,$toDate);
		$amount1=total_eq_issueAmount_date($pcode, $fromDate1,$toDate1);
	*/
	}
	else{
		$amount=total_exAmount_date($pcode, $fromDate,$toDate,$re[accountID]);
		$amount1=total_exAmount_date($pcode, $fromDate1,$toDate1,$re[accountID]);
	}
	//echo $sql2;
	$totalExpenses1+=$amount1;
	$totalExpenses+=$amount;
	$data[$i][0]=$re[accountID].' '.accountName($re[accountID]);
	$data[$i][1]=$amount1 ? $amount1 : 0;
	$data[$i][2]=$amount ? $amount : 0;
	// $data[$i][1]=0;
	// $data[$i][2]=90;
	$i++;

	// if("7013000"==$re[accountID]){
	// 	// print_r($data);
	// 	echo "7013000: <br>";
	// 	print_r($data[$i][1],	$data[$i][2]);
	// 	exit;
	// }
}

// print_r($data);
// exit;

$rr=sizeof($data);
if($totalExpenses1<=0)$totalExpenses1=1;
if($totalExpenses<=0)$totalExpenses=1;
for($i=1;$i<=$rr;$i++){
  ?>
<? if( $data[$i][2]!=0 ){ ?><tr>
 <td><? echo $data[$i][0];?></td>
 <td align="right"><? echo number_format($data[$i][1],2);?></td>
 <!--<td align="right" class="tsilver"><? echo number_format((($data[$i][1]*100)/$GRNDTOT),2);?>%</td>-->
 <td align="right"><? echo number_format($data[$i][2],2);?></td>
 
 <td align="right" class="tsilver">
 <?
 $texpense=($data[$i][2]*100)/$GRNDTOT;
 if($texpense<0){
	$texpense = $texpense * -1;
 }
 echo number_format($texpense,2);
  $Ttexpense=$Ttexpense+$texpense;
 ?>%</td>

</tr>  


<? } }//for
	
?>
<tr bgcolor="#99CCFF">
 <td align="right">Total Expense</td>
 <td align="right"><strong id="tExpenseM" rel="<? echo $totalExpenses1;?>"><? echo number_format($totalExpenses1,2);?></strong></td>
<!-- <td align="right">100%</td>-->
 <td align="right"><strong id="tExpense" rel="<? echo $totalExpenses;?>"><? echo number_format($totalExpenses,2);?></strong></td>
 <td align="right"><strong id="tExpenseP" rel="<? echo $Ttexpense;?>"><? 

 echo number_format($Ttexpense,2);
 ?></strong>%</td>
</tr>  
<tr><td height="20">&nbsp;</td></tr>
<? 
$netIncome1=$GrossProfit1-$totalExpenses1;
$netIncome=$GrossProfit-$totalExpenses;
?>
<tr  bgcolor="#FFFFCC">
 <td><b>NET PROFIT</b></td>
 <td align="right"><?
 // echo number_format($netIncome1,2);?></td>
 <!--<td><div align="right">%</div></td>-->
 <td align="right"><strong  id="netProfit"><? 
//  echo number_format($netIncome,2);?></strong></td>
 <td><strong><div align="right"><span id="netProfitP"></span><? 
//  $Nprofit=100-$Ttexpense-$Ttotalcostofsales;
//  echo number_format($Nprofit,2);
 ?>%</div></strong></td>
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
  $r=mysqli_num_rows($sqlQ);
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
 <td colspan="4" align="right"><div align="left"><b>Other relevent up-to-date Project Informations</b></div></td> </tr> 
	
<tr>
<td><strong>Contact Amount</strong></td>
<td></td>
<td align="right"><? 
$sqlcont = "SELECT contact_amount,workingCapital,paymentTerms,projectDuration from project where pcode ='$pcode'";
$sqlruncont= mysqli_query($db, $sqlcont);
$resultcont=mysqli_fetch_array($sqlruncont);
echo number_format($resultcont[contact_amount],2);
?>
</td>
<td></td>
</tr>
	
		
<tr>
<td><strong>Working Capital Amount (<i><font color="#00f">Actual</font></i>/Estimated)</strong></td>
<td align="right">
	<font color="#00f"><i id="workingCapitalAmountBox"></i></font>
</td>
<td align="right">
<?
	echo "<font color='#f00'>(".number_format($resultcont[workingCapital],2).")</font>";
	$projectDuration=$resultcont[projectDuration];
	$paymentTerms=$resultcont[paymentTerms];
?>
</td>
<td></td>
</tr>
	
	
<tr>
<td><strong>IOW Approved</strong></td>
<td></td>
<td align="right">
<?
echo number_format($IOWapproved,2);
?>
</td>
<td></td>
</tr>
<tr>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Approved Cost of Sales Direct Labour</td>
<td></td>
<td align="right">
<?
echo  number_format($ManExpApp,2);
?>
</td>
<td align="right"><?

echo  number_format($ManExpAppPer,2);
?>
%</td>
</tr>

<tr>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Approved Cost of Sales&nbsp;Equipment </td>
<td></td>
<td align="right">
<?
echo  number_format($EqExpApp,2);
?></td>
<td align="right"><?

echo  number_format($EqExpAppPer,2);
?>
%</td>
</tr>

<tr>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Approved Cost of Sales Material</td>
<td></td>
<td align="right"><?
echo  number_format($MatExpApp,2);?>
</td>
<td align="right"><?

echo  number_format($MatExpAppPer,2);
?>
%</td>
</tr>
<tr>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Approved Cost of Sales Sub Contructor</td>
<td></td>
<td align="right">
<?
echo  number_format($SubConExpApp,2);
?>
</td>
<td align="right"><?

echo  number_format($SubConExpAppPer,2);
?>
%</td>
</tr>

<tr>
<td><strong>Total Cost of Sales Approved</strong></td>
<td></td>
<td align="right"><strong><? 
$TotalExpApp=$ManExpApp+$EqExpApp+$MatExpApp+$SubConExpApp;
echo  number_format($TotalExpApp,2);
?></strong></td>
<td align="right"><strong><?

echo  number_format($TotalExpAppPer,2);
?>
%</strong></td>
</tr>
<tr>
<td height="20" colspan="4">
<? 
$sql = "SELECT * from iow WHERE  iowProjectCode='$pcode' ORDER by iowId ASC";
$sqlrunp= mysqli_query($db, $sql);
$edate=date("d/m/Y");
//$Pprgper=0;
$Tplnprgtk=0;

 while($iow=mysqli_fetch_array($sqlrunp))
 {
	 $iowId=$iow[iowId];

	$plnprgper=iowProgress_income_statement($edate,$iow[iowId]);
	
  	//$Pprgper+= $plnprgper;
	 $sql1 = "SELECT * from iow WHERE iowId='$iowId'";
	$sqlrunp1= mysqli_query($db, $sql1);
	
	 while($iow1=mysqli_fetch_array($sqlrunp1))
	 {
	  	$tk=$iow1['iowQty']*$iow1['iowPrice'];
	   	$tkk=($tk*$plnprgper)/100;
		$Tplnprgtk+=$tkk;
		
	 }
 
 }
 $TplnprgtkPer=($Tplnprgtk*100)/$IOWapproved;
?>
As of <font class="out"><? echo date("d-m-Y");?></font> Planned Progress is Tk. <? echo number_format($Tplnprgtk); ?> (<font class="out"><? echo number_format($TplnprgtkPer,2); ?>%</font>) and Actual Progress is Tk. 
<? echo number_format($GRNDTOT); ?>
(<font class="out"><?
echo number_format((($GRNDTOT*100)/$IOWapproved),2);?>%</font>)
</td>
</tr>

<tr bgcolor="#B1F28A">
 <td colspan="4" align="right"><div align="left"><b><u>Current Assets</u></b></div></td>
</tr>

<? 
//$netIncome1=$GrossProfit1-$totalExpenses1;
//$netIncome=$GrossProfit-$totalExpenses;
?>
<tr  bgcolor="">
 <td >Accounts Receivable </td>
 <td align="right"><?
 // echo number_format($netIncome1,2);?></td>
 <!--<td>&nbsp;</td>-->
 <td align="right"><? 
 $TCA=$openingBalance+$drAmount-$crAmount; //TCA= total current asset ?><? echo number_format($TCA,2);  ?></td>
 <td>&nbsp;</td>
</tr> 
<?
		
			 

?>


<tr  bgcolor="">
 <td>Work in Progress</td>
 <td  align="right">&nbsp;</td>
 <td align="right"><? 
 
 echo number_format($TWP,2);  ?></td>
 <td><div align="right"><? echo number_format((($TWP*100)/$GRNDTOT),2);?>%</div></td>
</tr> 

<tr bgcolor="">
  <td >Other Current Assets </td>
  <td align="right">&nbsp;</td>
  <!--<td>&nbsp;</td>-->
  <td align="right"><?
  $sql="select * from `accounts` WHERE  accountType='4' ORDER by accountID ASC";
  $sqlQ=mysqli_query($db, $sql);
  $r=mysqli_num_rows($sqlQ);
 
	while($re=mysqli_fetch_array($sqlQ)){
			$balance+=total_exAmount_date($pcode, $fromDate,$toDate,$re[accountID]);  
	}
	echo number_format($balance,2);?>
	</td>
	<td>&nbsp;</td>
</tr>
<? 
//$fromDate=formatDate($fromDate,'Y-m-j');
//$toDate=formatDate($toDate,'Y-m-j');  
$db=mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
$i=1;
?>

<?
	$balanceSideCash = 0;

	$sql3="select * from `accounts` ORDER by accountID ASC";
	$sqlq=mysqli_query($db, $sql3);
	while($re=mysqli_fetch_array($sqlq))
	{
		if($re[accountID]=='5501000'){
			// 		$baseOpening=baseOpening('5501000',$pcode);
			// 		echo $openingBalance=$baseOpening+openingBalance('5501000',$fromDate,$pcode);
			// 		echo "<br>";
			// 		echo $balanceSideCash1=cashonHand($pcode,$fromDate,$toDate,'2');
			// 			exit;
			if($pcode=="000"){
					$baseOpening=baseOpening('5501000',$pcode);
					$openingBalance=$baseOpening+openingBalance('5501000',date("Y-m-d",strtotime($toDate)+86400),$pcode);
			}else{
					$baseOpening=baseOpening('5502000',$pcode);
					$openingBalance=$baseOpening+openingBalance('5502000',date("Y-m-d",strtotime($toDate)+86400),$pcode);	
			}
			$balanceSideCash+=$openingBalance;
		}
	}
?>

<tr bgcolor="">
  <td>Site Cash</td>
  <td align="right">&nbsp;</td>
  <!--<td>&nbsp;</td>-->
  <td align="right" id="siteCash" rel="<?php echo $balanceSideCash; ?>"><? echo number_format($balanceSideCash,2); ?></td>
  <td>&nbsp;</td>
</tr>
<?
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

//$sql="SELECT DISTINCT itemCode FROM store$pcode WHERE 1 AND currentQty <> 0 ";	
$sql="SELECT DISTINCT itemCode FROM store$pcode WHERE itemCode between '01-01-001' and '35-99-999' ";
$TI=0;
$sqlquery=mysqli_query($db, $sql);
$i=0;
$total=0;	
while($sqlresult=mysqli_fetch_array($sqlquery))
{
	$amount=mat_stock_rate($pcode,$sqlresult[itemCode],$toDate);
	$TI+=$amount;    //TI = total inventory
}
?>

<tr bgcolor="">
  <td>Raw Material Inventory</td>
  <td align="right">&nbsp;</td>
  <!--<td>&nbsp;</td>-->
  <td align="right" id="rawMaterialInventory" rel="<? echo $TI; ?>"><? echo number_format($TI,2); ?></td>
  <td>&nbsp;</td>
</tr>

<?php
	$baseOpening=baseOpening('5209000',$pcode);
	$openingBalance=$baseOpening+openingBalance('5209000',$fromDate,$pcode);
	$balanceSideCash1=invoiceRetentionAmount($pcode);
	$Retention=$openingBalance+$balanceSideCash1;
?>

<tr bgcolor="">
  <td>Retention Money</td>
  <td align="right"></td>
  <td align="right" id="retention" rel="<?php echo $Retention; ?>"><? echo number_format($Retention,2); ?></td>
 <td>&nbsp;</td>
</tr> 

<tr bgcolor="#B1F28A">
  <td  align="right"><b>Total Current Assets </b></td>
  <td align="right">&nbsp;</td>
 <!-- <td>&nbsp;</td>-->
  <td align="right"  ><b><? echo number_format($TCA+$TWP+$TI+$balanceSideCash+$Retention,2); ?></b></td>
  <td>&nbsp;</td>
</tr>

	
<tr  bgcolor="#B1F28A">
  <td colspan="4"  align="right">&nbsp;</td>
  </tr>
  
  <tr  bgcolor="#B1F28A">
    <td colspan="4" ><u><b>Current Liabilities</b></u></td>
    </tr>
<?
	/* $crAmount=0;
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
// echo $sql;
  $sqlQ=mysqli_query($db, $sql);
  $r=mysqli_num_rows($sqlQ);
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
// echo $sql;
  $sqlQ=mysqli_query($db, $sql);
  $r=mysqli_num_rows($sqlQ);

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
// echo $sql1;
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
	
	$totalmaterial=$openingBalance+($crAmount-$drAmount);
	//equipment
	
$drAmount=0;
$crAmount=0;
$openingBalance=0;

$array_date=array();
//$openingBalance=openingBalance('2402000',$fromDate,$pcode);
//$openingBalance=0;
	
    $sql="select COUNT(id) as total,`itemCode`,`posl` 
	from `eqattendance`  
	WHERE `edate` between '$fromDate' and '$toDate' 
	AND `location` ='$pcode' 
    group by posl,itemCode 
	order by edate ASC ";
// echo "$sql<b><br>";
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
// echo $sql1;
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
	
	$totaleqpment=$openingBalance+($crAmount-$drAmount);
	
	
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
// echo $sql;
  $sqlQ=mysqli_query($db, $sql);
  $r=mysqli_num_rows($sqlQ);
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
// echo $sql1;
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
	
	$totalsubcontract=$openingBalance+($crAmount-$drAmount);
	
*/
		
		$AccountsPayableOtherDebtorsSup=summationOfAgedVendorPaymentAmount($pcode,"debtor","sup");
		$AccountsPayableOtherDebtorsSub=summationOfAgedVendorPaymentAmount($pcode,"debtor","sub");
		$AccountsPayableEquipmentSection=summationOfAgedVendorPaymentAmount($pcode,"es");
		$AccountsPayableCentralStore=summationOfAgedVendorPaymentAmount($pcode,"cs");
		
		
		$AccountsPayable+=$AccountsPayableOtherDebtorsSup+$AccountsPayableOtherDebtorsSub+$AccountsPayableEquipmentSection+$AccountsPayableCentralStore;
	?>
	<tr bgcolor="">
    <td>Accounts Payable - Supplier</td>
    <td align="right">&nbsp;</td>
   <!-- <td>&nbsp;</td>-->
    <td align="right">
			<?
				//echo "<br>$totalmaterial+$totaleqpment+$totalsubcontract<br>";
				echo number_format($AccountsPayableOtherDebtorsSup,2);
			?>
		</td>
    <td>&nbsp;</td>
  </tr>
	<tr bgcolor="">
    <td >Accounts Payable - Sub-contractor</td>
    <td align="right">&nbsp;</td>
   <!-- <td>&nbsp;</td>-->
    <td align="right"><?
// 		echo "<br>$totalmaterial+$totaleqpment+$totalsubcontract<br>";
		echo number_format($AccountsPayableOtherDebtorsSub,2);?></td>
    <td>&nbsp;</td>
  </tr>
	
	
	<tr bgcolor="">
    <td >Accounts Payable - Salary</td>
    <td align="right">&nbsp;</td>
   <!-- <td>&nbsp;</td>-->
    <td align="right"><?
// 		echo "<br>$totalmaterial+$totaleqpment+$totalsubcontract<br>";
		echo number_format(0,2);?></td>
    <td>&nbsp;</td>
  </tr>
	<tr bgcolor="">
    <td >Accounts Payable - Wages</td>
    <td align="right">&nbsp;</td>
   <!-- <td>&nbsp;</td>-->
    <td align="right"><?
// 		echo "<br>$totalmaterial+$totaleqpment+$totalsubcontract<br>";
		echo number_format(0,2);?></td>
    <td>&nbsp;</td>
  </tr>
	
	
	
	
	<tr bgcolor="">
    <td >Accounts Payable - BFEW Equipment Section</td>
    <td align="right">&nbsp;</td>
   <!-- <td>&nbsp;</td>-->
    <td align="right"><?
// 		echo "<br>$totalmaterial+$totaleqpment+$totalsubcontract<br>";
		echo number_format($AccountsPayableEquipmentSection,2);?></td>
    <td>&nbsp;</td>
  </tr>
	<tr bgcolor="">
    <td >Accounts Payable - BFEW Central Store</td>
    <td align="right">&nbsp;</td>
   <!-- <td>&nbsp;</td>-->
    <td align="right"><?
// 		echo "<br>$totalmaterial+$totaleqpment+$totalsubcontract<br>";
		echo number_format($AccountsPayableCentralStore,2);?></td>
    <td>&nbsp;</td>
  </tr>
	
	
	
    <tr  bgcolor="">
      <td>Other Current Liabilities </td>
      <td align="right">&nbsp;</td>
      <!--<td>&nbsp;</td>-->
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
<tr  bgcolor="#B1F28A">
  <td ><div align="right"><b>Total Current Liabilities </b></div></td>
  <td align="right">&nbsp;</td>
 <!-- <td>&nbsp;</td>-->
  <td align="right"><b><? echo number_format($AccountsPayable,2);?></b></td>
  <td>&nbsp;</td>
</tr>
	
	
<script type="text/javascript">
	
$(document).ready(function(){
	var forWorkingCapitalAmount="<?php 
		 $workingCapital = $totalRevenues- ($TI+$Retention+($storeCostofsales-$AccountsPayable)+$balanceSideCash);
		echo round($workingCapital); ?>";
	$("#workingCapitalAmountBox").attr("rel",forWorkingCapitalAmount);
	console.log(forWorkingCapitalAmount+"// <?php echo "$totalRevenues-($TI+$Retention+($storeCostofsales-$AccountsPayable)+$balanceSideCash)"; ?> (Total -Expenses,-COS left) ");
});
</script>
	
	
	<tr>
		<td height="10"></td>
	</tr>
<tr  bgcolor="">
  <td colspan=4><div align="left"><b>Payment Terms:</b> <?php echo $paymentTerms;?></div></td>
</tr>
<tr  bgcolor="">
  <td colspan=4><div align="left"><b>Project Duration:</b> <?php echo $projectDuration; ?> Months</div></td>
</tr>
	
<tr bgcolor="">
  <td colspan=4><div align="left"><b>Actual Working Capital Amount</b> = Revenue - ((COS - Current Liabilities) + Expenses + Other Current Assets + Raw Material Inventory + Retention Money + Site Cash)</div></td>
</tr>
</table>
<?  }//if($fromDate AND $toDate){?>
</form>
<? }//else pcode
$_SESSION["TWP"]="-1"; //unset TWP
?>
<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
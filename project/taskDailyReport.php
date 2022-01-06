<?
	echo $supervisor=$_SESSION[loginUname];
	echo "<br>Supervisor Id:$supervisor<br>$loginDesignation";
?>
<!--
<form name="gooo" action="./graph/alliow.g.php"	 method="post" target="_blank">
<table align="center" width="98%" border="0" bgcolor="#FFCCCC" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
<tr>
<td>Progress Report in Graph</td>
<? if($loginDesignation=='Manager Planning & Control' OR $loginDesignation=='Managing Director'){?>
<td >Project: <select name="gproject"> 
<?
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

$sqlppg = "SELECT * from `project` ORDER  by pcode ASC";
//echo $sqlp;
$sqlrunppg=mysqli_query($db, $sqlppg);

while($typelpg= mysqli_fetch_array($sqlrunppg)){
	 echo "<option value='".$typelpg[pcode]."'";
	 if($projectg==$typelpg[pcode]) echo " selected ";
	 echo ">$typelpg[pcode]--$typelpg[pname]</option>";
}?>
 </select>
</td>
<? }
else
	echo "<input type=hidden name=gproject value='$loginProject'>";
?>
<td><input type="radio" name="r" value="1" checked>ALL IOW</td>
<td><input type="radio" name="r" value="2">ALL IOW with SIOW</td>
<td >
<input type="submit" name="go" value="View Graph">	 
</td>
</tr>
</table>
</form>
-->
<?
error_reporting(1);
include('./project/siteMaterialReport.f.php');
?>
<? 
include('./project/siteDailyReport.f.php');
?>

	<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
<form name="goo" action="./index.php?keyword=task+daily+report"	 method="post">
<table align="center" width="98%" border="1" bgcolor="#FEF5F1" bordercolor="#99CC99" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
<tr>
	<SCRIPT LANGUAGE="JavaScript">
	var now = new Date(); 
	//now.setDate(now.getDate()-15)
	var cal = new CalendarPopup("testdiv1");
		cal.showNavigationDropdowns();
		cal.setWeekStartDay(6); // week is Monday - Sunday
		//cal.addDisabledDates(null,formatDate(now,"yyyy-MM-dd")); 
		cal.setCssPrefix("TEST");
		cal.offsetX = 0;
		cal.offsetY = 0;
	</SCRIPT>
    
    
<!--        <td>
    	<? 
	if($edate2==date("d/m/Y",(strtotime($todat)-86400))) {$t2='checked'; $t1='';}
	  else {$edate2=date("d/m/Y",strtotime($todat)); $t1='checked'; $t2='';}
	  //else {$err=1;}
	?>
	<input type="radio" name="edate" value="<? echo date("d/m/Y",strtotime($todat));?>"  onClick="edate2.value=this.value;" <? echo $t1;?>> Today, <? echo date("D, d/m/Y",strtotime($todat));?>	
    <input type="radio" name="edate" value="<? echo date("d/m/Y",(strtotime($todat)-86400));?>" onClick="edate2.value=this.value;"  <? echo $t2;?>> Yesterday, <? echo date("D, d/m/Y",(strtotime($todat)-86400));?>

   <input type="hidden" maxlength="10" name="edate2" 
   value="<? if($edate2) echo $edate2; else echo date("d/m/Y",strtotime($todat));?>" >
    
    </td>-->
    
    
    
     <td colspan="1" >Date: <input class="yel" type="text" maxlength="10" name="edate" value="<? if($edate==''){echo date("d/m/Y");} else echo $edate;?>" readonly="" > <a id="anchor" href="#"
   onClick="cal.select(document.forms['goo'].edate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
      </td>
      
      
       
<? if($loginDesignation=='Manager Planning & Control' OR $loginDesignation=='Managing Director') {?>	  
<td >Project: <select name="project"> 
<?
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$sqlpp = "SELECT * from `project`  ORDER  by  pcode ASC";
//echo $sqlp;
$sqlrunpp= mysqli_query($db, $sqlpp);

while($typelp= mysqli_fetch_array($sqlrunpp)){
 echo "<option value='".$typelp[pcode]."'";
 if($project==$typelp[pcode]) echo " selected ";
 echo ">$typelp[pcode]--$typelp[pname]</option>  ";
}
?>

 </select>
</td>
<? }
else $project=$loginProject;

echo "Login project: ".$project;
?>
<td >Select IOW: <select name="iow" id="goooD">
<!-- <option value="">All IOW</option>-->
<?
$get_n_i=1;

include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT iowId,`iowCode`,iowDes from `iow` WHERE supervisor='$supervisor' AND iowStatus <> 'Not Ready' order by iowCode asc";
// echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
while($typel= mysqli_fetch_array($sqlrunp)){
 echo "<option value='".$typel[iowId]."'";
 if($iow==$typel[iowId]) {echo " selected title='$get_n_i' "; $selected_get_n_i=$get_n_i;}
 echo ">$typel[iowCode]-$typel[iowDes]</option>";
 $get_n_i=$get_n_i+2;
}
?>
 </select>
 </td>
 <td align="center">
	<input type="submit" name="go" value="View Numeric Report">
 </td>
</tr>
<tr>
<? 
//echo $sqlp;
if($loginDesignation=='Manager Planning & Control' OR $loginDesignation=='Managing Director') {?>	 
	<td colspan="4" bgcolor="#FEF5F1">
	<? } else {?>
	 <td colspan="3" bgcolor="#FEF5F1">
	 <? }?>
 	<!--<input type="checkbox"  name="chk1" <? if($chk1 OR $chk2 OR $chk3 OR $chk4 ) echo 'checked'; ?>>SIOW Details
 	<input type="checkbox" name="chk2" <? if($chk2) echo 'checked'; ?> >Materials Details 
 	<input type="checkbox" name="chk3" <? if($chk3) echo 'checked'; ?> >Equipments Details
 	<input type="checkbox" name="chk4" <? if($chk4) echo 'checked'; ?> >Labour Details
 	<input type="checkbox" name="chk5" <? if($chk5) echo 'checked'; ?> >Change Order	
 	<input type="checkbox" name="chk6" <? if($chk6) echo 'checked'; ?> >Progress Details-->
	<? $chk1=1; $chk2=1; $chk3=1; $chk4=1;?>		
	</td>
 </tr>
</table>
</form>
<? if($edate){?>
<?
$ed1=formatDate($edate,'Y-m-d');
//if($project=='') $project=$loginProject;
 $sql="SELECT * FROM dailyreport WHERE edate='$ed1' AND pcode='$project'";

//echo $sql;
$sqlq=mysqli_query($db, $sql);
$sqlr=mysqli_fetch_array($sqlq);
$btn_sql1=$sql;
?>
<table width="95%" align="center">
<tr><td colspan="2">Brief Description of Day's Operations :<i><? echo $sqlr[operation];?></i></td></tr>
<tr><td colspan="2">Weather Condition: <i><? echo $sqlr[weather];?></i></td></tr>
<tr><td colspan="2">Accident: <i><? echo $sqlr[accident];?> </i></td></tr>
<tr><td colspan="2">Visitors detail with comments received:<i> <? echo $sqlr[vcomments];?></i> </td></tr>
</table>
<br>
<? 
	include("./project/auxiliary_iow_report.php");
	$diagonosis_info=getIowItemCode2EqMaintenanceInfo($resultiow[iowCode],$selected="dt");
?>
<br>

<?php
$width="98%";
?>
<?php include("./planningDep/revisionHistory.php"); ?>
<br>
<table align="center" width="98%" border="1" bordercolor="#99CC99" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
 <tr bgcolor="#D9F9D0">
	 <th>IOW</th>
	 <th>IOW description</th>
	 <th>Planned Progress</th>
	 <th>Daily Issue</th> 
 </tr>
 <tr><td colspan="4" height="2"></td></tr>
<? include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT * from `iow` where `iowProjectCode` LIKE '$project' 
AND '$ed1' BETWEEN iowSdate AND iowCdate 
AND iowStatus <> 'Not Ready' ";

if($iow) $sqlp.=" AND iowId=$iow ";
 $sqlp.=" ORDER by iowId ASC";
// echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
$btn_sql2=$sqlp;

if(mysqli_affected_rows($db)<1){
$sqlp="SELECT * from `iow` where `iowProjectCode` LIKE '$project' AND iowStatus <> 'Not Ready' ";
$sqlrunpp= mysqli_query($db, $sqlp);
$ree=mysqli_fetch_array($sqlrunpp);
// print_r($ree);
echo $sqlp;
?>	
<tr>
	<td colspan=4 align=center>
	<?php
		echo "Iow date: ".date("d/m/Y",strtotime($ree[iowSdate]))." to ".date("d/m/Y",strtotime($ree[iowCdate]));
		if(strtotime($ree[iowCdate])<strtotime($ed1))	echo "<span style='background:#f00;color:#fff; padding:2px;margin:2px;border-radius:5px;'>Expired</span>";
	?>
	</td>
</tr>
<? }
while($re=mysqli_fetch_array($sqlrunp)){
?>
<tr bgcolor="#F0FEE2">
  <th align="left" ><? echo $re[iowCode];?></th>
  <th align="left"><? echo $re[iowDes];?></th> 
  <td align="left"> <? iowProgress($edate,$re[iowId]);
?></td> 
  <td align="right"> 
<?
	$ed=formatDate($edate,'Y-m-j');
	echo iowActualProgress($re[iowId],$project,$ed,$re[iowQty],$re[iowUnit],0);
  //iowActualProgress($edate,$re[iowId],1);
		?>
    </td> 
</tr>

<?  //echo $re[iowId];
$ed=formatDate($edate,'Y-m-d');
if($chk1 OR $chk2 OR $chk3 OR $chk4){

$sqlp1 = "SELECT siowId,siowCode,siowName,siowQty,siowUnit,siowCdate,siowSdate, 
 (to_days(siowCdate)-to_days(siowSdate)) as duration, (to_days('$ed')-to_days(siowSdate)) as pass 
 from `siow` where `iowId` = $re[iowId] AND '$ed1' BETWEEN siowSdate AND siowCdate ORDER by siowCode ASC";
// echo $sqlp1;
$btn_sql3=$sqlp1;
$sqlrunp1= mysqli_query($db, $sqlp1);
$i=1;
while($res=mysqli_fetch_array($sqlrunp1)){
?>

<tr>
  <td  align="right" bgcolor="#F0FEE2"><? echo $res[siowCode];?>  </td>
  <td><? echo $res[siowName];?> <? echo '[Start Date: '.myDate($res[siowSdate]).', Finished Date: '.myDate($res[siowCdate]).'] ';?></td> 
  <td> <? echo siowProgress($edate,$res[siowId]);?> </td> 
  <td align="right">
	<?
		echo siowActualProgress($res[siowId],$project,$ed,$res[siowQty],$res[siowUnit],0);  
		//echo siowActualProgress($edate,$res[siowId],'1');
	?>
	</td> 
</tr>

<? if($chk2 OR $chk3 OR $chk4){?>
<tr>
    <td bgcolor="#F0FEE2"> </td>
	<td colspan="3">
	<table width="100%" style="border-collapse:collapse" cellspacing="2">
	 <tr><td colspan="4" bgcolor="#6699FF" height="2"></td></tr>
	 <tr><td colspan="4" bgcolor="#6699FF" height="2"></td></tr>
	 <tr>
	   <th width="40">ItemCode</th>
	   <th width="20%">Planned Consumption</th>
	   <th width="20%">Actual Consumption</th>
	   <th width="20%">Daily Issue</th>	   
	 </tr>
	 <tr><td colspan="4" bgcolor="#6699FF" height="2"></td></tr>
	 <tr><td colspan="4" bgcolor="#6699FF" height="2"></td></tr> 
	  <? if($chk2){ $viewTemp=1; materialReport($res[siowId],$res[pass],$res[duration],$project,$ed);
	  // materialReport_summary($res[siowId],$res[pass],$res[duration],$project,$edate);
	  }?>
	  <? if($chk3){equipmentReport($res[siowId],$res[pass],$res[duration],$project,$ed);
	//  equipmentReport_summary($res[siowId],$res[pass],$res[duration],$project,$edate);
	  }?>
	  <? if($chk4){ humanReport($res[siowId],$res[pass],$res[duration],$project,$ed);
	  // humanReport_summary($res[siowId],$res[pass],$res[duration],$project,$edate);
	   subcontractorReport($res[siowId],$res[pass],$res[duration],$project,$ed);
	  }
	  ?>
     </table>	
	
	 </td>
 </tr>
 <? }//material?>
<? } //siow
}
?>
<? if($chk5 OR $chk6 ){
$sqld="select des,clientdes,edate,supervisor from iowdaily where iowId=$re[iowId] AND edate<='$ed' ORDER by edate DESC";
//echo $sqld;
$sqlqd=mysqli_query($db, $sqld);
while($d=mysqli_fetch_array($sqlqd)){

		if($chk6 AND $d[des]){
			$btn_chk6=1;
			echo "<tr><td colspan=5><b>".myDate($d[edate])."</b> Progress: <i>$d[des]</i></td></tr>";
		}
		
		if($chk5 AND  $d[clientdes]){$btn_chk5=1; echo "<tr><td colspan=5><b>".myDate($d[edate])."</b> CO/WI: <i>$d[clientdes]</i></td></tr>";}
}
?>

<? } 
else {?>
<tr><td colspan="5" height="5" >
<b>Supervisor:</b>
<? 
echo supervisorDetails($loginUname);

$ed=formatDate($edate,'Y-m-j');
$ed=date("Y-m-j",strtotime($ed));

// echo $re[iowQty];
$some_code=iowActualProgress($re[iowId],$loginProject,$ed,$re[iowQty],$re[iowUnit],0);
//$some_code=str_replace("(","",$some_code);
$some_code=str_replace(")","",$some_code);
$some_code=explode("(",$some_code);
$some_code[1]=str_replace(" ","",$some_code[1]);
// 	echo "<br>$some_code[1]<br>";
// 	print_r($some_code);

$exPP[0]=intval(strip_tags($some_code[1]));
$exPP[1]=intval(strip_tags($some_code[0]));
//print_r($exPP);

$currentQty=str_replace("(","",str_replace(")","",$exPP[1]));
$currentQty=str_replace(",","",$currentQty);
$currentQty=intval($currentQty);
$date_differ=(strtotime($re[iowCdate])-strtotime(date("Y-m-d",strtotime("yesterday"))))/86400;
$leftProgress=100-$exPP[0];
$leftQty=$re[iowQty]-$currentQty;

$dailyNeededP=($leftProgress/$date_differ);
$dailyNeededQty=($leftQty/$date_differ);

// echo "///$leftQty/$date_differ///";
	{
$perPercent=($leftQty/$leftProgress);
$perDayQty=$perPercent*$dailyNeededP;
		
	}

$iowProgressRange=iowActualProgressRange($re[iowId],$project,date("Y-m-d",strtotime("yesterday")),$ed,$re[iowQty],$re[iowUnit],1);
//$test= iowActualProgressRange($re[iowId],$project,date("Y-m-d",strtotime($d[edate])),date("Y-m-d",strtotime($d[edate])),$re[iowQty],$re[iowUnit],1);
$iowProgress=iowActualProgress($re[iowId],$project,$ed,$re[iowQty],$re[iowUnit],0);
	
// 	echo "//($re[iowId],$project,$ed,$re[iowQty],$re[iowUnit],1)";
$planned_progress_arr=iowProgress_row_edited($edate,$re[iowId]);
$some_note_data="R$re[revisionNo] Planned Progress: ".$planned_progress_arr[1]."% (".round($planned_progress_arr[0])." $re[iowUnit]), Actual Progress: ".$_SESSION["progress_qty"];
$some_note[1]="Planned Progress: ".$planned_progress_arr[1]."% (".round($planned_progress_arr[0])." $re[iowUnit]), Actual Progress: ".$iowProgress;

/*R3 Planned Progress: 85% (6588 RM), Actual Progress: 57% (4,450 RM )*/

//$extra="Planned progress of ".date("d/m/Y",strtotime($ed))." was rrr ".$dailyNeededP."% (".round($perPercent)." $re[iowUnit]), workdone ";
$extra="On date planned progress testtt ".number_format($dailyNeededP,2)."% (".round($dailyNeededQty)." $re[iowUnit]), workdone ";

echo ' <font color="#FF0000" style="text-align:right; text-transform:capitalize; font-stretch:wider">'.$some_note[1].'</font>, ';
echo $extra;
echo iowActualProgressRange($re[iowId],$project,date("Y-m-d",strtotime($ed)),date("Y-m-d",strtotime($ed)),$re[iowQty],$re[iowUnit],1);
// $some_note[1]=$extra;
?>
</td>
</tr>
<form action="./project/siteDailyReportEntry.sql.php" method="post" name="iowdaily" id="iowdaily" target="_blank">	
<input type="hidden" id="hidden_code" size="100" name="hidden_code" value="<?php echo date("M d,Y", strtotime($ed)).": ".$some_note_data; ?>" />
<tr>
  <td colspan="5" height="5">
	<b>Reason for Progress Variance:</b>
	<input type="hidden" name="n" value="<? echo $selected_get_n_i+2;?>">
	<input type="hidden" name="edate" value="<?php echo $edate;?>" />
	<input type="hidden" name="iowid<? echo $selected_get_n_i;?>" value="<?php echo $iow; ?>" />
	<input type="hidden" name="supervisor<? echo $selected_get_n_i;?>" value="<?  echo $loginUname;?>">
	<input type="hidden" name="taskDailyReport" value="1" />
<?php
// 	$get_the_dec=explode(") ",str_replace("(","",iow_progerss_variance($re[iowId],$ed)));
	$get_the_dec=iow_progerss_variance($re[iowId],$ed);
?>
<input type="text"  id="iow_progress" width="200" size="150" align="right" name="des<? echo $selected_get_n_i;?>" value="<? echo $get_the_dec;?>"style="color:#FF3333">
</td></tr>
<!-- <tr><td colspan="5" height="5" >
<b>Issues may hamper progress:</b>
<input type="text"  id="hamperProgress" width="150" size="143" align="right" name="hamperProgress" value="" style="color:#FF3333; width:60% !important;">

<b>Dateline:</b>
<span>
	<input type="text"  id="dateline" width="20" size="20" align="right" name="dateline" value="" style="color:#FF3333; width:5% !important;" readonly>
	 <a id="anchor1" href="#"
   onClick="cal.select(document.forms['iowdaily'].dateline,'anchor1','dd/MM/yyyy'); return false;"
   name="anchor1" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
</span>
	</td></tr> -->
<?php 
//if(1==2) //stoped
			foreach(getTroubleTrackerRows($loginUname) as $rows){
				if(!$rows[dateline])continue;
				echo '<tr><td colspan="5" height="5" >';
	echo "ISSUE $rows[trID](<font color='#00f'>".date("d/m/Y",strtotime($rows[raisedOn]))."</font>) D/L <font color='#00f'>".date("d/m/Y",strtotime($rows[dateline]))."</font>: <i><font color='#f00'>".$rows[troubleTxt]."</font></i>";
	
echo '<span>
	<input type="hidden"  id="closedOn_'.$rows[trID].'" width="20" size="20" align="right" name="closedOn_'.$rows[trID].'" id="closedOn_'.$rows[trID].'" value="" style="color:#FF3333" readonly>';
			echo '<input type="button" value="Close Today" onClick="document.getElementById(\'closedOn_'.$rows[trID].'\').value=\''.todat().'\'; this.style.color=\'#00f\';document.getElementById(\'iowdaily\').submit(); ">';
			echo '</td></tr>';
}
?>

<!-- <tr><td colspan="5" height="5" >
<b>Progress improvement proposal by Site Engineer:</b>
<input type="text" width="200" size="171" name="co<? echo $selected_get_n_i;?>" value="<? echo iow_progerss_changeOrder($re[iowId],$ed,"co");?>"style="color:#FF3333">
</td></tr> -->

<?php
$sql="select * from iowdaily where type='co' and closed='0' and iowId='$re[iowId]' order by edate asc limit 1";
$q=mysqli_query($db,$sql);
while($row=mysqli_fetch_array($q)){
	if($row[clientdes])
		echo " <tr><td colspan=\"5\" height=\"5\">
	<b>".date("d-m-Y",strtotime($row[edate]))."</b>: $row[clientdes] &nbsp;
	<!--<a href=\"././project/siteDailyReportEntry.sql.php?id=$row[id]&action=closed\" target='_blank'>Close</a>-->
</td></tr> ";
}
?>

<!-- <tr><td colspan="5" height="5">
<b>Change order received: </b>
	<input type="text" width="200" size="171" name="wi<? echo $selected_get_n_i;?>" value="<? echo iow_progerss_changeOrder($re[iowId],$ed,"wi");?>"style="color:#FF3333">
</td></tr>
 -->
<?php
$sql="select * from iowdaily where type='wi' and closed='0' order by edate asc limit 1";
$q=mysqli_query($db,$sql);
while($row=mysqli_fetch_array($q)){
	if($row[clientdes])
		echo "<tr><td colspan=\"5\" height=\"5\">
	<b>".date("d-m-Y",strtotime($row[edate]))."</b>: $row[clientdes] &nbsp;
	<!--<a href=\"././project/siteDailyReportEntry.sql.php?id=$row[id]&action=closed\" target='_blank'>Close</a>-->
</td></tr>";
}
?>
	
	
	
<tr><td colspan="5" height="5" >
<b>Billing document status:</b>
<!-- <span> -->
	<input type="hidden"  id="bilingDocP" size="2" align="right" name="bilingDocP" value="0" style="color:#FF3333;width:50px;">
<!-- 	% ready.</span> -->
<span>
	<select  id="bilingDoc" width="80" align="right" name="bilingDoc">
		<option value="Up-to-date 0%: Documentation work not started">Up-to-date 0%: Documentation work not started</option>
		<option value="Up-to-date 10%: All pre-work documents at hand.">Up-to-date 10%: All pre-work documents at hand.</option>
		<option value="Up-to-date 25%: All quality documents up-to-date.">Up-to-date 25%: All quality documents up-to-date.</option>
		<option value="Up-to-date 50%: All quantity documents up-to-date.">Up-to-date 50%: All quantity documents up-to-date.</option>
		<option value="Up-to-date 75% : All Post-work documents up-to-date.">Up-to-date 75% : All Post-work documents up-to-date.</option>
		<option value="Up-to-date 100% : All documents accepted by the client.">Up-to-date 100% : All documents accepted by the client.</option>
	</select>	
	</span>
</td></tr>

<? } //else chk5?>
<tr>
<td colspan="4">

<!-- <input type="button" align="middle" name="save" value="Save" onClick="document.getElementById('iow_progress').value='( '+document.getElementById('hidden_code').value+') '+document.getElementById('iow_progress').value;iowdaily.submit();"> </td> -->
	
<input type="button" align="middle" name="save" value="Save" onClick="iowdaily.submit();"> </td>
  </tr>
<? }//iow
?>
</form>
	
	
	
<?php
	foreach(getTroubleTrackerRows(null,$iow) as $rows){
		if(!$rows[closedOn])continue;
		echo '<tr><td colspan="5" height="5">';
	echo "ISSUE $rows[trID](<font color='#00f'>".date("d/m/Y",strtotime($rows[raisedOn]))."</font>) D/L <font color='#00f'>".date("d/m/Y",strtotime($rows[dateline]))."</font>: <i><font color='#f00'>".$rows[troubleTxt]."</font></i>	
	</td></tr>";
}	
	?>	
<tr bgcolor="#f5f5f5"><td colspan="5" height="1"></td></tr>	
	
<?php
	$billing_doc=getBillingDocRows($iow);
	if(count($billing_doc)>0){
		foreach($billing_doc as $rows){
				if(!$rows[bParcent] || !$rows[edate])continue;
				echo '<tr><td colspan="5" height="5">';
			echo "Billing document status: $rows[bParcent]% (<font color='#00f'>".date("d/m/Y",strtotime($rows[edate]))."</font>): <i><font color='#f00'>".$rows[bDes]."</font></i>	
			</td></tr>";
		}	
	}
	else{
			echo '<tr><td colspan="5" height="5">';
			echo "Billing document status: 0%: <i><font color='#f00'>Up-to-date 0%: Not yet initiated</font></i>	
			</td></tr>";
	}
	?>
	
	
</table>

<? }//if edate?>
<form name="print" method="post" action="./project/print_siteDailyReport.php" target="_blank">
	<input type="hidden" name="btn_sql1" value="<? echo $btn_sql1;?>">
	<input type="hidden" name="btn_sql2" value="<? echo $btn_sql2;?>">
	<input type="hidden" name="btn_sql3" value="<? echo $btn_sql3;?>">

	<input type="hidden" name="edate" value="<? echo $edate?>">
	<input type="hidden" name="chk1" value="<? echo $chk1?>">
	<input type="hidden" name="chk2" value="<? echo $chk2?>">
	<input type="hidden" name="chk3" value="<? echo $chk3?>">
	<input type="hidden" name="chk4" value="<? echo $chk4?>">
	<input type="hidden" name="chk5" value="<? echo $chk5?>">
	<input type="hidden" name="chk6" value="<? echo $chk6?>">
	<input type="hidden" name="chk7" value="<? echo $chk7?>">
	<input type="hidden" name="chk8" value="<? echo $chk8?>">
	<input type="hidden" name="project" value="<? echo $project?>">

	<input type="submit" name="btn_print" value="Print">
</form>
<div id=testdiv1
      style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
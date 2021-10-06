<form name="gooo" action="./graph/alliow.g.php"	 method="post" target="_blank">
<table align="center" width="98%" border="0" bgcolor="#FFCCCC" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
<tr>
<td>Progress Report in Graph</td>
<? if($loginDesignation=='Manager Planning & Control' OR $loginDesignation=='Managing Director' OR $loginDesignation=='Director') {?>	  
<td >Project: <select name="gproject"> 
<?
include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);

$sqlppg = "SELECT * from `project` ORDER  by pcode ASC";
//echo $sqlp;
$sqlrunppg= mysql_query($sqlppg);

 while($typelpg= mysql_fetch_array($sqlrunppg))
{
 echo "<option value='".$typelpg[pcode]."'";
 if($projectg==$typelpg[pcode]) echo " selected ";
 echo ">$typelpg[pcode]--$typelpg[pname]</option>  ";
 }
?>
 </select>
</td>
<? }
else echo "<input type=hidden name=gproject value=$loginProject>";

?>

<td><input type="radio" name="r" value="1" checked>ALL IOW</td>
<td><input type="radio" name="r" value="2">ALL IOW with SIOW</td>
<td >
<input type="submit" name="go" value="View Graph">	 
</td>
</tr>
</table>
</form>
<? include('./project/siteMaterialReportEntry.f.php');?>
<? include('./project/siteDailyReport.f.php');?>
<? include('./project/findProject.f.php');?>

	<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
<form name="goo" action="./index.php?keyword=site+daily+report"	 method="post">
<table align="center" width="98%" border="1" bgcolor="#FEF5F1" bordercolor="#99CC99" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
<tr>
	<SCRIPT LANGUAGE="JavaScript">
	var now = new Date(); 
	var cal = new CalendarPopup("testdiv1");
    	//cal.showNavigationDropdowns();
		cal.setWeekStartDay(6); // week is Monday - Sunday
		//cal.addDisabledDates(null,formatDate(now,"yyyy-MM-dd")); 
		cal.setCssPrefix("TEST");		
		cal.offsetX = 0;
		cal.offsetY = 0;		
	</SCRIPT>
	<? if($loginDesignation=='Manager Planning & Control' OR $loginDesignation=='Managing Director' OR $loginDesignation=='Director') {?>
      <td colspan="1" >
 
	  Project: <select name="project" 
onChange="location.href='index.php?keyword=site+daily+report&project='+goo.project.options[document.goo.project.selectedIndex].value+'&Status='+goo.Status.options[document.goo.Status.selectedIndex].value";>
<?
include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);

$sqlpp = "SELECT * from `project`  ORDER  by  pcode ASC";
//echo $sqlp;
$sqlrunpp= mysql_query($sqlpp);

 while($typelp= mysql_fetch_array($sqlrunpp))
{
 echo "<option value='".$typelp[pcode]."'";
 if($project==$typelp[pcode]) echo " selected ";
 echo ">$typelp[pcode]--$typelp[pname]</option>  ";
 }
?>

 </select><br />
  Status:&nbsp;&nbsp;<select name="Status">
			<option value="">All</option>
			<option value="Started" <? if($Status=='Started') echo " selected "; ?>>Active</option>
			<option value="Not-Started" <? if($Status=='Not-Started') echo " selected "; ?>>Inactive</option>
			<option value="completed" <? if($Status=='completed') echo " selected "; ?>>Completed</option>
			
</select><input type="button" onclick="location.href='index.php?keyword=site+daily+report&project='+goo.project.options[document.goo.project.selectedIndex].value+'&Status='+goo.Status.options[document.goo.Status.selectedIndex].value" value="Page Reload" /><br /></td> 
<? }
else $project=$loginProject;
?>	  
<td >&nbsp;
<?
if($loginDesignation=='Project Manager')
{?>
Status:<select name="Status">
			<option value="">All</option>
			<option value="Started" <? if($Status=='Started') echo " selected "; ?>>Active</option>
			<option value="Not-Started" <? if($Status=='Not-Started') echo " selected "; ?>>Inactive</option>
			<option value="completed" <? if($Status=='completed') echo " selected "; ?>>Completed</option>
			
</select>
<input name="button" type="button" onclick="location.href='index.php?keyword=site+daily+report&Status='+goo.Status.options[document.goo.Status.selectedIndex].value" value="Page Reload" />
<br />

<?
}


?>



<? 
if($Status=='Not-Started'){
			include("config.inc.php");
			$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
				  mysql_select_db($SESS_DBNAME,$db);
			$sqlp = "SELECT iowId,`iowCode` from `iow` WHERE iowProjectCode='$project' and iowStatus !='Completed' ";
			$sqlrunp= mysql_query($sqlp);
			$ind=0;
			$text=array();
			while($typel2= mysql_fetch_array($sqlrunp))
			{
			 //echo $typel2[iowId]."=".A($typel2[iowId],$project,date("Y-m-j"))."=".B($typel2[iowId],$project,date("Y-m-j"))."=".C($typel2[iowId],$project,date("Y-m-j"))."=".D($typel2[iowId],$project,date("Y-m-j"))."=".$typel2[iowCode]."<br>";
			 
			//echo found($typel2[iowId],$project,date("Y-m-j"))."-".$typel2[iowCode]."<br>";
			
			
			$jack=found($typel2[iowId],$project,date("Y-m-j"));
			$test[$ind]=$jack;
			
			//echo "array condition".print_r($text)."<br>";
			$ind++;
			 }
			 //echo "present array data is".print_r(array_diff($tast,array(" ")))."<br>";
			 $remove_null_number = true;
			$new_array = remove_array_empty_values($test, $remove_null_number);
			
			//echo "two ND present array data is".print_r($new_array)."<br>";
			  
  }
  
  if($Status=='Started'){
 // echo " yea i am in started";
			include("config.inc.php");
			$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
				  mysql_select_db($SESS_DBNAME,$db);
			$sqlp2 = "SELECT iowId,`iowCode` from `iow` WHERE iowProjectCode='$project' and iowStatus !='Completed'  ";
			$sqlrunp= mysql_query($sqlp2);
			$ind=0;
			$text=array();
			while($typel2= mysql_fetch_array($sqlrunp))
			{

			//echo foundf($typel2[iowId],$project,date("Y-m-j"))."-"."<br>";
			
			
			$jack=foundf($typel2[iowId],$project,date("Y-m-j"));
			$test2[$ind]=$jack;
			
			//echo "array condition".print_r($text)."<br>";
			$ind++;
			 }
			 //echo "present array data is".print_r(array_diff($tast,array(" ")))."<br>";
			 $remove_null_number = true;
			$new_array2 = remove_array_empty_values($test2, $remove_null_number);
			
			//echo "two ND present array data is".print_r($new_array2)."<br>";
			  
  }
 //
 include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sqlp = "SELECT iowId,`iowCode` from `iow` WHERE iowProjectCode='$project' ";
if($Status=='completed'){$sqlp.=" AND iowStatus ='Completed' ";}

if($Status=='Not-Started'){
$sqlp.=" AND iowStatus != 'Completed' and";
for($i=0; $i< $c=sizeof($new_array); $i++ )
{
							$sqlp.="  iowId=$new_array[$i] "; if($i<($c-1)) $sqlp.=" OR  "; else $sqlp.="";
							//echo "<br>".$c."<br>";
							}			
				 			$sqlp.=" ORDER by iowId ASC";


}

if($Status=='Started'){
 /*if($new_array2==true)*/ $sqlp.=" AND iowStatus != 'Completed' and ";
for($i=0; $i< $c=sizeof($new_array2); $i++ )
{
							$sqlp.="  iowId=$new_array2[$i] "; if($i<($c-1)) $sqlp.=" OR  "; else $sqlp.="";
							//echo "<br>".$c."<br>";
							}			
				 			$sqlp.=" ORDER by iowId ASC";


}

//echo $sqlp;

?></td>

<td valign="top" >Select IOW: <br><select name="iow[]" multiple="multiple" size="7"> <option value="all">All IOW</option>
<?

//
$sqlrunp= mysql_query($sqlp);

 while($typel= mysql_fetch_array($sqlrunp))
{
 echo "<option value='".$typel[iowId]."'";
 if($iow==$typel[iowId]) echo " selected ";
 echo ">$typel[iowCode]</option>  ";
 }
?>

 </select> </td>
 <td align="left">
 Date.: <br><input class="yel" type="text" maxlength="10" name="edate" value="<? if($edate=='') echo date("d/m/Y"); else echo $edate;?>" > <a id="anchor" href="#"
   onClick="cal.select(document.forms['goo'].edate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a><br>
<input type="submit" name="go" value="Numeric Report"></td>
</tr>
<tr>
<? if($loginDesignation=='Manager Planning & Control' OR $loginDesignation=='Managing Director') {?>	 
	<td colspan="4" bgcolor="#FEF5F1">
	<? } else {?>
	 <td colspan="3" bgcolor="#FEF5F1">
	 <? }?>
 	<input type="checkbox"  name="chk1" <? if($chk1 OR $chk2 OR $chk3 OR $chk4 ) echo 'checked'; ?>>SIOW Details
 	<input type="checkbox" name="chk2" <? if($chk2) echo 'checked'; ?> >Materials Details 
 	<input type="checkbox" name="chk3" <? if($chk3) echo 'checked'; ?> >Equipments Details
 	<input type="checkbox" name="chk4" <? if($chk4) echo 'checked'; ?> >Labour Details
 	<input type="checkbox" name="chk5" <? if($chk5) echo 'checked'; ?> >Change Order	
 	<input type="checkbox" name="chk6" <? if($chk6) echo 'checked'; ?> >Progress Details	</td>
 </tr>
</table>
</form>
<? if($edate){?>
<?
$ed1=formatDate($edate,'Y-m-d');
//if($project=='') $project=$loginProject;
 $sql="SELECT * FROM dailyreport WHERE edate='$ed1' AND pcode='$project'";

//echo $sql;
$sqlq=mysql_query($sql);
$sqlr=mysql_fetch_array($sqlq);
$btn_sql1=$sql;
?>
<table width="95%" align="center">
<tr><td colspan="2">Brief Description of Day's Operations :<i><? echo $sqlr[operation];?></i></td></tr>
<tr><td colspan="2">Weather Condition: <i><? echo $sqlr[weather];?></i></td></tr>
<tr><td colspan="2">Accident: <i><? echo $sqlr[accident];?> </i></td></tr>
<tr><td colspan="2">Visitors detail with comments received:<i> <? echo $sqlr[vcomments];?></i> </td></tr>
</table>
<br>
<table align="center" width="98%" border="1" bordercolor="#99CC99" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
 <tr bgcolor="#D9F9D0">
 <th>IOW Code</th>
 <th>IOW description</th>
 <th>Planned Progress</th>
 <th>Actual Progress</th>
 <th>Actual Expenses</th>  
 </tr>
 <tr><td colspan="5" height="2"></td></tr>
<? include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);

	
	$sqlp = "SELECT * from `iow` where `iowProjectCode` LIKE '$project' ";
	
if($Status=='completed' && $iow[0]=='all'){$sqlp.=" AND iowStatus ='Completed' ";}	
			
if($Status=='Started' && $iow[0]=='all'){
			/*if($new_array2==true)*/ $sqlp.=" AND iowStatus <> 'Completed' and ";
			for($i=0; $i< $c=sizeof($new_array2); $i++ )
			{
				$sqlp.="  iowId=$new_array2[$i] "; if($i<($c-1)) $sqlp.=" OR  "; else $sqlp.="";
				//echo "<br>".$c."<br>";
				}			
				//$sqlp.=" ORDER by iowId ASC";
			}
			
	
if($Status=='Not-Started' && $iow[0]=='all')
{
			$sqlp.=" AND iowStatus <> 'Completed' and ";
			for($i=0; $i< $c=sizeof($new_array); $i++ )
			{
				$sqlp.="  iowId=$new_array[$i] "; if($i<($c-1)) $sqlp.=" OR  "; else $sqlp.="";
										//echo "<br>".$c."<br>";
			}			
										//$sqlp.=" ORDER by iowId ASC";
			
			
}
if ($iow[0] !="all" && sizeof($iow)>0)
{
			
				$sqlp .= " AND ";
							
				for($i=0; $i< $c=count($iow); $i++ )
							{
							$sqlp.="  iowId=$iow[$i] "; if($i<($c-1)) $sqlp.=" OR  "; else $sqlp.="";
							//echo "<br>".$c."<br>";
							}				
}		
$sqlp.=" ORDER by iowId ASC";

//echo $sqlp;
$sqlrunp= mysql_query($sqlp);
$btn_sql2=$sqlp;
while($re=mysql_fetch_array($sqlrunp)){
?>


<tr bgcolor="#F0FEE2">
  <th align="left" ><? echo $re[iowCode];?> </th>
  <th align="left"><i><? echo $re[iowDes];?>  </i>
    <? echo '['.myDate($re[iowSdate]).' to '.myDate($re[iowCdate]).'] ';?>
  <? /*

$materialCost=materialCost($re[iowId]);
$equipmentCost=equipmentCost($re[iowId]);
$humanCost=humanCost($re[iowId]);
$directCost=$materialCost+$equipmentCost+$humanCost;
$totalCost=$re[iowQty]*$re[iowPrice];
echo ' ['.number_format($directCost);
echo '<font class=out> ('.number_format(($directCost/$totalCost)*100).'%) </font> ] ';
*/
  ?>  </th> 
  <td align="left"> <? iowProgress($edate,$re[iowId]); ?> </td> 
  <td align="right"> 
      <? 

	$ed=formatDate($edate,'Y-m-j');
	 echo $iowActualProgress=iowActualProgress($re[iowId],$project,$ed,$re[iowQty],$re[iowUnit],0);
	// echo number_format($iowActualProgress);
  //iowActualProgress($edate,$re[iowId],1); ?>    </td> 
<td align="right"><? 
     $iow_subContractorissuedEx=iow_subContractorissuedEx($re[iowId],$project,$ed);	
	//echo $siow_subContractorissuedEx;
	 $iow_issuedEx=iow_issuedEx($re[iowId],$project,$ed);
	//echo "<br>$siow_issuedEx";
	 $iow_equipmentReport=iow_equipmentReport($re[iowId],$project,$ed);
	//echo "<br>".number_format($siow_equipmentReport);
	 $iow_humanReport=iow_humanReport($re[iowId],$project,$ed);
	//echo "<br>".$siow_humanReport;
	
	 $actualTotalEx=$iow_subContractorissuedEx+$iow_issuedEx+$iow_equipmentReport+$iow_humanReport;
	
$materialCost=materialCost($re[iowId]);
$equipmentCost=equipmentCost($re[iowId]);
$humanCost=humanCost($re[iowId]);
$directCost=$materialCost+$equipmentCost+$humanCost;
	

	$actualTotalExp=($actualTotalEx/$directCost)*100;

	echo number_format($actualTotalEx).'<font class=out>('.number_format($actualTotalExp).'%)</font>';
	$actyalTotalEx=0;
	$actualTotalExp=0;
	$iow_subContractorissuedEx=$iow_issuedEx=$iow_equipmentReport=$iow_humanReport=0;
	?></td>	
</tr>

<? 
$ed=formatDate($edate,'Y-m-d');
if($chk1 OR $chk2 OR $chk3 OR $chk4){

$sqlp1 = "SELECT siowId,siowCode,siowName,siowQty,siowUnit,siowCdate,siowSdate, 
 (to_days(siowCdate)-to_days(siowSdate)) as duration, (to_days('$ed')-to_days(siowSdate)) as pass 
 from `siow` where `iowId` = $re[iowId] ORDER by siowCode ASC";
//echo $sqlp1;
$btn_sql3=$sqlp1;
$sqlrunp1= mysql_query($sqlp1);
$i=1;
while($res=mysql_fetch_array($sqlrunp1)){
?>

<tr>
  <td  align="right" ><? echo $res[siowCode];?>  </td>
  <td><i><? echo $res[siowName];?></i> <? echo '['.myDate($res[siowSdate]).' to '.myDate($res[siowCdate]).'] ';?></td> 
  <td> <? echo siowProgress($edate,$res[siowId]);?> </td> 
  <td align="right"> <? 
  echo siowActualProgress($res[siowId],$project,$ed,$res[siowQty],$res[siowUnit],0);
  
  //echo siowActualProgress($edate,$res[siowId],'1'); ?> </td> 
	<td align="right"><? 
	 $siow_subContractorissuedEx=siow_subContractorissuedEx($res[siowId],$project,$ed);
	
	//echo $siow_subContractorissuedEx;
	 $siow_issuedEx=siow_issuedEx($res[siowId],$project,$ed);
	//echo "<br>$siow_issuedEx";
	 $siow_equipmentReport=siow_equipmentReport($res[siowId],$project,$ed);
	//echo "<br>".number_format($siow_equipmentReport);
  	$siow_humanReport=siow_humanReport($res[siowId],$project,$ed);
	//echo "<br>".$siow_humanReport;
	
	 $actualTotalEx=$siow_subContractorissuedEx+$siow_issuedEx+$siow_equipmentReport+$siow_humanReport;
	
$materialCost=siow_materialCost($res[siowId]);
$equipmentCost=siow_equipmentCost($res[siowId]);
$humanCost=siow_humanCost($res[siowId]);

$directCost=$materialCost+$equipmentCost+$humanCost;
//echo "** directCost=$actualTotalEx  ;; $directCost **";
	$actualTotalExp=($actualTotalEx/$directCost)*100;

	echo number_format($actualTotalEx).'<font class=out>('.number_format($actualTotalExp).'%)</font>';	

	$actualTotalEx=0;
	$siow_subContractorissuedEx=$siow_issuedEx=$siow_equipmentReport=$siow_humanReport=0;
	?></td>
</tr>

<? if($chk2 OR $chk3 OR $chk4){?>
<tr>
    <td> </td>
	<td colspan="4">
	<table width="100%" style="border-collapse:collapse" cellspacing="2">
	 <tr><td colspan="4" bgcolor="#6699FF" height="2"></td></tr>
	 <tr><td colspan="4" bgcolor="#6699FF" height="2"></td></tr>
	 <tr>
	   <th width="40">ItemCode</th>
	   <th width="20%">Planned Consumption</th>
	   <th width="20%">Actual Consumption</th>
	   <th width="20%">Actual Expense</th>	   
	 </tr>
	 <tr><td colspan="4" bgcolor="#6699FF" height="2"></td></tr>
	 <tr><td colspan="4" bgcolor="#6699FF" height="2"></td></tr> 
	  <? if($chk2){ materialReport($res[siowId],$res[pass],$res[duration],$project,$ed);
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
     </table>    </td>
 </tr>
 <? }//material?>
<? } //siow
}
?>
<? if($chk5 OR $chk6 ){
$sqld="select des,clientdes,edate,supervisor from iowdaily where iowId=$re[iowId] AND edate<='$ed' ORDER by edate DESC";
//echo $sqld;
$sqlqd=mysql_query($sqld);
while($d=mysql_fetch_array($sqlqd)){

		if($chk6 AND $d[des])
		{$btn_chk6=1;echo "<tr><td colspan=5><b>".myDate($d[edate])."</b> Progress: <i>$d[des]</i></td></tr>";}
		
		if($chk5 AND  $d[clientdes]){$btn_chk5=1; echo "<tr><td colspan=5><b>".myDate($d[edate])."</b> CO/WI: <i>$d[clientdes]</i></td></tr>";}
}
?>

<? } 
else {?>
<tr><td colspan="5" height="5" >
<b>Supervisor:</b>
<? //echo iow_progerss_supervisor($re[iowId],$ed);
$sql1="SELECT * from employee where designation like '75-%-000' and location='$project' AND status='0'";
//echo "$sql<br>";
$sqlq1=mysql_query($sql1);
while($re1=mysql_fetch_array($sqlq1))
{
echo $re1['name'];
echo ", ";
$deg=hrDesignation($re1[designation]);
echo $deg;
}
?>
</td></tr>

<tr><td colspan="5" height="5" >
<b>Progress:</b>
<? echo iow_progerss_variance($re[iowId],$ed);?>
</td></tr>

<tr><td colspan="5" height="5" >
<b>CO/WI: </b>
<? echo iow_progerss_changeOrder($re[iowId],$ed);?>
</td></tr>

<? } //else chk5?>
<tr>
    <td colspan="5" height="11" ></td>
  </tr>
<? }//iow
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
<input type="hidden" name="Status" value="<? echo $Status?>">
<input type="hidden" name="project" value="<? echo $project?>">

<input type="submit" name="btn_print" value="Print">


</form>
<div id=testdiv1
      style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
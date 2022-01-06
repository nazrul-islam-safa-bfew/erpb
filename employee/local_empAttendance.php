<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>

	<?
	include("./includes/config.inc.php");
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
	?>
<form name="att" action="./employee/local_empAttendance.sql.php" method="post">
	<table align="center" width="98%" border="3"  bordercolor="#CC9999" cellpadding="2" cellspacing="0" style="border-collapse:collapse">
	 <tr bgcolor="#CC9999">
	     <td align="left" width="50%">
<?
if($loginDesignation=='Human Resource Manager' || $loginDesignation=='Human Resource Executive'){?>
	<SCRIPT LANGUAGE="JavaScript">
      var now = new Date(); 
      var cal = new CalendarPopup("testdiv1");
      cal.showNavigationDropdowns();
      cal.setWeekStartDay(6); //week is Monday - Sunday
      //cal.addDisabledDates(null,formatDate(now,"yyyy-MM-dd")); 
      cal.setCssPrefix("TEST");
      cal.offsetX = 0;
      cal.offsetY = 0;
	</SCRIPT>
<?
$ex=array('Select One','');
//if($loginDesignation=='Human Resource Manager')
echo selectPlist('project',$ex,$project);
//echo selectPlistProject('project',"",$loginProject);
?>
	<input type="text" maxlength="10" name="edat" value="<? echo $edat;?>">
	<a id="anchor" href="#" onClick="cal.select(document.forms['att'].edat,'anchor','dd/MM/yyyy'); return false;" name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
	<input type="button" name="go" value="Go" onClick="location.href='./index.php?keyword=local+emp+attendance&edat='+document.att.edat.value+'&project='+document.att.project.value"> 
	<?}else{?>
	  	<? 
if($edat==date("d/m/Y",(strtotime($todat)-86400))){$t2='checked';$t1='';}
else{$edat=date("d/m/Y",strtotime($todat)); $t1='checked'; $t2='';}
	  //else {$err=1;}
	?>
	<input type="radio" name="sd" value="<? echo date("d/m/Y",strtotime($todat));?>"  onClick="edat.value=this.value;" <? echo $t1;?>> Today, <? echo date("D, d/m/Y",strtotime($todat));?>	
	   <input type="radio" name="sd" value="<? echo date("d/m/Y",(strtotime($todat)-86400));?>" onClick="edat.value=this.value;"  <? echo $t2;?>> Yesterday, <? echo date("D, d/m/Y",(strtotime($todat)-86400));?>

	  <input type="hidden" maxlength="10" name="edat" value="<? if($edat) echo $edat; else echo date("d/m/Y",strtotime($todat));?>" >

	       <input type="button" name="go" value="Go" onClick="location.href='./index.php?keyword=local+emp+attendance&edat='+document.att.edat.value"> 
	  <? $project=$loginProject; }?>
	     </td>
	     <td align="right" colspan="3" ><font class='englishhead'>human resource attendance</font></td>
	   </tr>
	<? echo $err; if($edat AND $err==0){ //echo $edat;?>
	   <tr> 
	     <th width="200">Employee ID</th>
	     <th>Name</th>
	     <th>Comment For The Day</th>	  
	     <th>Dispatch Date</th>	  
	   </tr>
<?
//Iow requirement      
 
	$format="Y-m-j";
	$edat11 = formatDate($edat,$format);
  $j=1;
//   $sql_dma="select dmaItemCode,dmaiow,dmaQty from dma where dmaItemCode >= '90-01-000' AND dmaItemCode <= '92-99-999' and dmaProjectCode='$project' group by dmaItemCode";
//   echo $sql_dma;
//   $q_dma=mysqli_query($db,$sql_dma);
//   while($r_dma=mysqli_fetch_array($q_dma)){
    // $iow_remaining_days=get_iow_remaining_days($r_dma["dmaItemCode"],$edat11);
    // if($iow_remaining_days<=0)continue;
    
    // $total_approved_hr=$r_dma[dmaQty];
    // $attendance_hr=get_attendance_of_particular_empId($r_dma["dmaItemCode"],$project);    
    // $today_req=($total_approved_hr-$attendance_hr)/$iow_remaining_days;
    
    // $today_req_today=round($today_req/8,2);
    // if( $today_req_today<1 && $today_req_today>0 )$today_req_today=1;
//   End of iow requirement
    // $today_req=sec2hms($today_req);
    
    // echo "<tr><td colspan=5 person='$today_req_today' class='head_row'>Today requirement $today_req hr. for $r_dma[dmaItemCode] You can engaged $today_req_today person. 
    
    //   <a href='http://win4win.biz/erp/bfew/planningDep/subdailyRequirment.php?project=$project&itemCode=$r_dma[dmaItemCode]' target='_blank' style='color:#fff; font-weight:800; background:#00f'>Approved qty in graph</a>
      
    // </td><tr>";
        
	$sqlquery="SELECT * FROM employee where
	designation >= '82-01-000' AND designation <= '92-99-999'
	AND location='$project'  AND status='0' ORDER by designation ASC/* limit $today_req_today*/";
	// echo $sqlquery;
	$sql= mysqli_query($db, $sqlquery);

	
	$format="Y-m-j";
	$edat11 = formatDate($edat,$format);
    
  
	while($emp=mysqli_fetch_array($sql)){


    
    
$empStayDate=empStayDesigntaionDate($emp[empId],$emp[designation]);

if($emp[designation]>='90-01-000' && empty($empStayDate) && $emp[designation]<='92-99-999')
$empStayDate=todat_new_format("d-m-Y");

					
			   
		   
//echo "sty". $empStayDate;
 
	$remanDate=(strtotime($empStayDate)-strtotime($edat11))/86400;
	$remanDate = 1;
	
	if($remanDate<=0) $bg="#FF9999";
	 else if($remanDate<=10) $bg="#FFFFCC";
	  else  $bg="#FFFFFF";	
	?>
	<tr <? echo " bgcolor=$bg";?><? if($remanDate<=0 AND $emp[designation]=='90-01-000') echo ' style="display:none;"';?> >
	 <td  valign="top">
	<?
	$format="Y-m-d";
	/*if(isPresent($emp[empId],formatDate($edat,$format)) OR isHPresent($emp[empId],formatDate($edat,$format)))$t=" checked";
	else $t="";
*/
	$t='';
	$sql1="select * from attendance WHERE empId='$emp[empId]' and edate='$edat11'";
	//echo $sql1;
	$sqlqq=mysqli_query($db, $sql1);
	$sqlq1=mysqli_fetch_array($sqlqq);
	$act= $sqlq1[action];
          
	if($act=='P' OR $act=='HP' ) $t=" CHECKED ";
	?>
<input type="checkbox" name="ch<? echo $j;?>" <? echo "$t";?> <? if($remanDate<=0 OR $act == 'L' )echo " disabled=disabled";?>>
<? echo empId($emp[empId],$emp[designation]); echo ', '.hrDesignation($emp[designation]); //  echo "$emp[empId]==$remanDate"; ?> 
		<input type="hidden" name="empId<? echo $j;?>" value="<? echo $emp[empId];?>">
		<input type="hidden" name="designation<? echo $j;?>" value="<? echo $emp[designation];?>">
	  </td>
	     <td  valign="top" ><? echo $emp[name];?> </td>
	<td>
	<input type="text" name="remarks<? echo $j;?>" value="<? echo view_AttRemarks($sqlq1[id]);?>">			  
	</td>
	     <td  valign="top" align="center" ><? echo myDate($empStayDate);?> </td>	  
	   </tr>
	   <? $j++;
	} //while
    
//} //iow while  ?>  
    
	<tr><td colspan="2" height="10"> </td></tr>	

	   <tr> 
	     <td align="center" colspan="3"><input type="submit" name="attendance" value="Present">
	  <input type="hidden" name="project1" value="<? echo $project;?>">
	  </td>
	   </tr>

	<? } else echo '<tr><td colspan=3><dir align=center>'.inerrMsg('You are trying to do Illegal thing!!').'</dir></td></tr>';?>
	 </table>
	<input type="hidden" name="n" value="<? echo $i;?>">
	<input type="hidden" name="m" value="<? echo $j;?>">
	</form>

<?

$dateFormat = $year."-".$month."-01";
echo "weekend".   weekend('2021-11-01',$project);
echo "<br>";
$format="Y-m-j";
$edat1=$edat;
$edat = formatDate($edat,$format);
echo "Holiday".isHoliday('2021-11-26');

echo '<br>';

?>


<script>
$(document).ready(function(){
  $("input:checkbox").click(function(){
    $("tr.head_row").each(function(){
      var tt=0;
      var total=intval($(this).attr("person"));
      $("input:checkbox").each(function(){
        tt+=1
        if(tt>total){
          return false;
        }
      });      
    });
  });
});
</script>

	<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>

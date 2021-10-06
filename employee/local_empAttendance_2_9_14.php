	<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>

	<? 

	include("./includes/config.inc.php");
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
	?>
	<form name="att" action="./employee/local_empAttendance.sql.php" method="post">
	 <table align="center" width="98%" border="3"  bordercolor="#CC9999" cellpadding="2" cellspacing="0" style="border-collapse:collapse">
	   <tr bgcolor="#CC9999"> 

	     <td align="left"  width="50%">
	<? 

	if($loginDesignation=='Human Resource Manager'){?>
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
	       <? 
	$ex = array('Select one','');
	echo selectPlist('project',$ex,$project);
	?>

	       <input type="text" maxlength="10" name="edat" value="<? echo $edat;?>">
	       <a id="anchor" href="#"
	  onClick="cal.select(document.forms['att'].edat,'anchor','dd/MM/yyyy'); return false;"
	  name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
	<input type="button" name="go" value="Go" onClick="location.href='./index.php?keyword=local+emp+attendance&edat='+document.att.edat.value+'&project='+document.att.project.value"> 
	<? } else {?>
	  	<? if($edat==date("d/m/Y",(strtotime($todat)-86400))) {$t2='checked'; $t1='';}
	  else {$edat=date("d/m/Y",strtotime($todat)); $t1='checked'; $t2='';}
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
             
	$sqlquery="SELECT * FROM employee where designation = '90-01-000' 
	AND location='$project' AND status='0' ORDER by designation ASC ";
	//echo $sqlquery;
	$sql= mysqli_query($db, $sqlquery);

	$j=1;
	$format="Y-m-j";
	$edat11 = formatDate($edat,$format);

	while($emp=mysqli_fetch_array($sql)){
             
	
           $empStayDate=empStayDesigntaionDate($emp[empId],$emp[designation]);
		   
           if($emp[designation]=='90-01-000' && empty($empStayDate))
			 $empStayDate=todat_new_format("d-m-Y");

					
			   
		   
//echo "sty". $empStayDate;
 
	$remanDate=(strtotime($empStayDate)-strtotime($edat11))/86400;
	
	if($remanDate<=0) $bg="#FF9999";
	 else if($remanDate<=10) $bg="#FFFFCC";
	  else  $bg="#FFFFFF";	
	?>
	<tr <? echo " bgcolor=$bg";?><? if($remanDate<=0 OR $act == 'L' AND $emp[designation]=='90-01-000') echo ' style="display:none;"';?> >
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
          
	if($act=='P' OR $act=='HP') $t=" CHECKED ";
	?>
	  <input   type="checkbox" name="ch<? echo $j;?>" <? echo "$t";?> <? if($remanDate<=0 OR $act == 'L' ) echo " disabled=disabled";?> > 
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
	} //while?>	
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

	<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>

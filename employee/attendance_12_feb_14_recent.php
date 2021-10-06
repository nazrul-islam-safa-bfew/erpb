	<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>

<form name="attendance" action="./employee/attendance.sql.php" method="post">
<table align="center" width="90%" border="3"  bordercolor="CC9999" cellpadding="3" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
   <? 
if($loginProject=='000'){
?>
	<SCRIPT LANGUAGE="JavaScript">
	var now = new Date(); 

	//now.setDate(now.getDate()-2);
	//alert(now);
	var cal = new CalendarPopup("testdiv1");
    	cal.showNavigationDropdowns();
		cal.setWeekStartDay(6); // week is Monday - Sunday
	//	cal.addDisabledDates(null,formatDate(now,"yyyy-MM-dd")); 
		cal.setCssPrefix("TEST");		
		cal.offsetX = 0;
		cal.offsetY = 30;		
	</SCRIPT>
 <td colspan="5"><input type="text" maxlength="10" name="d" value="<? echo $d?>"  > <a id="anchor" href="#"
   onClick="cal.select(document.forms['attendance'].d,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
   <? } else {?>
	<td colspan="3">
	<? if($d==date("d/m/Y",(strtotime($todat)-86400))) {$t2='checked'; $t1='';}
	  else  { $d==date("d/m/Y",strtotime($todat)); $t1='checked'; $t2='';}
	?>
	<input type="radio" name="sd" value="<? echo date("d/m/Y",strtotime($todat));?>"  onClick="d.value=this.value;" <? echo $t1;?>> Today, <? echo date("D, d/m/Y",strtotime($todat));?>	
    <input type="radio" name="sd" value="<? echo date("d/m/Y",(strtotime($todat)-86400));?>" onClick="d.value=this.value;"  <? echo $t2;?>> Yesterday, <? echo date("D, d/m/Y",(strtotime($todat)-86400));?>
   <input type="hidden" maxlength="10" name="d" value="<? if($d) echo $d; else echo date("d/m/Y",strtotime($todat));?>" >
   <? }?>
   <? 
if($loginProject=='000'){
$ex = array('Select one','');
echo selectPlist('project',$ex,$project);
?>
   <input type="button" name="go" value="Go" onClick="location.href='./index.php?keyword=attendance&d='+document.attendance.d.value+'&project='+document.attendance.project.value">
<? }
else { echo "<input type=hidden name=project value=$loginProject>";
?>
   <input type="button" name="go" value="Go" onClick="location.href='./index.php?keyword=attendance&d='+document.attendance.d.value">
   <? }?>
  </td> 

  <td width="160" align="right" valign="top" ><font class='englishhead'>attendance</font></td>
</tr>
<? if($d){
?>
<tr>
 <th width="100">Emp Id</th>
 <th width="44">Name</th>
 <th width="147">Attendance</th>
<th width="103">Report</th>
<th width="103">Exit</th>
 <th>Remarks</th>
</tr>

<? 
$format="Y-m-j";
$dd = formatDate($d,$format);
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
if($loginProject!='000') $project=$loginProject;
 $sqlq="SELECT * FROM employee WHERE designation < '90-00-000' AND designation!='70-01-000' AND location='$project' AND status=0 AND empDate<='$dd' and empId not in (select empId from appaction where action='1' and details='Termination from Job') ORDER by designation";
// echo $sqlq;
 $sql=mysqli_query($db, $sqlq);



 // navigration coded by suvro
 $page_counter=0;
 $page="";
 $total_row=mysqli_affected_rows();
 if($total_row>99) 
 for($az=$total_row;$az>100;$az-=100)
 {
	$page_counter+=1;
 }
 $get_page_loc=$_GET['page'];
 if($page_counter>0 & $get_page_loc<=$page_counter){
 for($pl=0;$pl<=$page_counter;$pl++){
 $page.='<a href="" onmousemove="this.href=\'./index.php?keyword=attendance&project='.$project.'&d=\'+document.attendance.d.value+\'&page='.$pl.'\'">'.($pl+1)."</a> | ";}
	
	$last_one=(100+(100*$get_page_loc));
	$new_sql=$sqlq." limit ".$get_page_loc*100 ." ,100 ";


 $sql=mysqli_query($db, $new_sql);
 }
 

 //end of code
 
 
 
 
 $i=0;
 while($typel= mysqli_fetch_array($sql)){?>
<tr <? if($i%2==0) echo  "bgcolor=#f4f4f4";?>>
 <td><? echo empId($typel[empId],$typel[designation]);?><br>
  <?  echo hrDesignation($typel[designation]);?>
     <input type="hidden" name="empId<? echo $i;?>" value="<? echo $typel[empId];?>"  >
 </td>
 <td><? echo $typel[name];?></td>

<?

if(isHoliday($dd,$project)){
$acv1='HA';
$acv2='HP';
}
else {
$acv1='A';
$acv2='P';
}

$sql1="select * from attendance WHERE empId='$typel[empId]' and edate='$dd'";
//echo $sql1;
 $sqlqq=mysqli_query($db, $sql1);
 $sqlq1=mysqli_fetch_array($sqlqq);
 $act= $sqlq1[action] ;
 $t='';  $t1='';
 if($act==$acv1) $t=" CHECKED ";
 else if($act==$acv2) $t1=" CHECKED ";
  else $t=" CHECKED ";

?>
 <td>
 	<input type="radio" name="action<? echo $i;?>" value="<? echo $acv1?>"  <? echo $t;?> onClick="attendance.remarks<? echo $i;?>.disabled=true; attendance.remarks<? echo $i;?>.className='disabled'">Absent 
 	<input type="radio" name="action<? echo $i;?>" value="<? echo $acv2?>" <? echo $t1;?> onClick="attendance.remarks<? echo $i;?>.disabled=false;attendance.remarks<? echo $i;?>.className=''" >Present
</td>
  <td align="center">
  <? $t=empExTime($typel[empId],'H',$dd);
      $eh= $t[eh];
      $em= $t[em];
      $xh= $t[xh];
	  
	  if($t[xh]=="00")
          $xh="17";
      
      $xm= $t[xm];
      
      if($t[xm]=="00")
          $xm="59";
	  
   ?>
	  <input name="eh<? echo $i;?>" value="<? echo $eh;?>"  size="2" maxlength="2" onKeyUp="return autoTab(this, 2, event);" class="number"> :
	  <input name="em<? echo $i;?>" value="<? echo $em;?>"  size="2" maxlength="2" onKeyUp="return autoTab(this, 2, event);" class="number">
  </td>	  
  <td>
	  <input name="xh<? echo $i;?>" value="<? echo $xh;?>"  size="2" maxlength="2" onKeyUp="return autoTab(this, 2, event);" class="number"> :
	  <input name="xm<? echo $i;?>" value="<? echo $xm;?>"  size="2" maxlength="2" onKeyUp="return autoTab(this, 2, event);" class="number">

  </td>
 <td><input type="text" name="remarks<? echo $i;?>" disabled  class="disabled" value="<? echo view_AttRemarks($sqlq1[id]);?>"></td>
</tr>

<? $i++;}?>
<input type="hidden" name="n" value="<? echo $i;?>">
<tr><td colspan="4" align="center"><input type="submit" name="save" value="Save"></td></tr>
<?   }//if d?>
</table>
</form><p id="page_nav_area" style=" margin:auto;width:89%; text-align:right; border:1px #999 solid; border-bottom:3px #999 solid; border-top:3px inset; padding:5px 10px;">Page: <?php echo $page; ?></p>
<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
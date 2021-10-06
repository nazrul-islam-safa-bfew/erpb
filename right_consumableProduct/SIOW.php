	<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>

<?
if($siow){
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$format="Y-m-j";
$siowSdate = formatDate($siowSdate,$format);
$siowCdate = formatDate($siowCdate,$format);


$sqliow = "INSERT INTO siowtemp (siowId, siowPcode, iowId ,siowCode, siowName, siowQty,siowUnit, analysis, siowDate, siowSdate, siowCdate,revisionNo)".
                    "VALUES ('', '$loginProject', '$iow', '$siowCode','$siowName', '$siowQty', '$siowUnit','$analysis','$todat', '$siowSdate', '$siowCdate','$revisionNo')";

// echo $sqliow;
// 	exit;
$sqlruniow= mysqli_query($db, $sqliow);
if($siow=='SAVE and Return to IOW')
echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=./index.php?keyword=site+iow+detail&status=$iowStatus\">";
}
if($siow!='SAVE and Return to IOW'){
 ?>

<form name="form_siow" action="./index.php?keyword=enter+sub+item+work&iow=<? echo $iow;?>&iowStatus=<? echo $iowStatus;?>" method="post">
<table align="center" width="450"  border="1" bordercolor="#BFDBFF" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#BFDBFF">  
 <th align="center" colspan="2"><font class="englishHdblack">Enter New Sub Item of Work  (SIOW)</font></th>
</tr> 

<tr>
 <td width="250">Project Name</td>
  <td><? echo $loginProjectName;?></td>
</tr> 
<?
if($iow){
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqliow = "SELECT * from iowtemp where iowId= $iow";
//echo $sqliow;
$sqlruniow= mysqli_query($db, $sqliow);
$iowR= mysqli_fetch_array($sqlruniow);
}
 ?>

<tr>
  <td>Item of Work </td> 
  <td><? echo $iowR[iowDes];?></td>
</tr>

<tr>
  <td>Duration </td> 
  <td><? echo date("j-m-Y", strtotime($iowR[iowSdate]));?> TO  <? echo date("j-m-Y", strtotime($iowR[iowCdate]));?></td>
</tr>
<tr>
  <td>Sub Item of Work Code</td> 
  <td><? echo $iowR[iowCode].'<b><font class=out>'.siowCode($iowR[iowId]).'</font></b>';?>
    <input type="hidden" name="siowCode"  value="<? echo siowCode($iowR[iowId]);?>">
  </td>
</tr>

<tr>
  <td>Sub Item of Work Name</td> <td><input name="siowName"></td> 
</tr>
<tr>
  <td>Quantity</td> <td><input name="siowQty"></td> 
</tr>

<tr>
  <td>Unit</td> <td><input name="siowUnit"></td> 
</tr>

<tr>
  <td>Analysis Considering </td> <td><input name="analysis"> unit</td> 
</tr>

	<SCRIPT LANGUAGE="JavaScript">
	var now = new Date(); 
	var cal = new CalendarPopup("testdiv1");
    	cal.showNavigationDropdowns();
		cal.setWeekStartDay(6); // week is Monday - Sunday
		//cal.addDisabledDates(null,formatDate(now,"yyyy-MM-dd")); 
		cal.setCssPrefix("TEST");		
		cal.offsetX = 25;
		cal.offsetY = -120;
		
	</SCRIPT>

<tr>
  <td>Planned Date of Starting</td> 
      <td><input type="text" maxlength="10" name="siowSdate" value="" readonly="" alt="req" title="Planned Date of Starting"> <a id="anchor" href="#"
   onClick="cal.select(document.forms['form_siow'].siowSdate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
      </td> 
</tr>


<tr>
  <td>Planned Date of Completion</td> 
  <td><input name="siowCdate" maxlength="10" value="" readonly="" alt="req" title="Planned Date of Completion"> <a id="anchor11" href="#"
   onClick="cal.select(document.forms['form_siow'].siowCdate,'anchor11','dd/MM/yyyy'); return false;"
   name="anchor2"><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
  
   </td> 
</tr>

<tr bgcolor="#F4FaFF">
  <td align="center" colspan="2" >

 <input type="button" name="btnsiow" value="ADD more SIOW" 
  onClick="if(checkrequired(form_siow)) {form_siow.siow.value='ADD more SIOW';form_siow.submit();}">
  
 <input type="button" name="btnsiow" value="SAVE and Return to IOW" 
  onClick="if(checkrequired(form_siow)) {form_siow.siow.value='SAVE and Return to IOW';form_siow.submit();}">

  <input type="hidden" name="siow" value="0">  
  <input type="hidden" name="revisionNo" value="<? echo $revisionNo;?>">  

  
  </td> 
</tr>
<tr bgcolor="#BFDBFF">  
 <td align="center" colspan="2" height="5"></td>
</tr> 

</table>

</form>
<? }?>
<div id=testdiv1
      style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
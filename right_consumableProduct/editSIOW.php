	<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>

<?
if($editsiow){


$format="Y-m-j";
$siowSdate=$_POST['siowSdate'];

$siowSdate1 = formatDate($siowSdate,$format);
$siowCdate1 = formatDate($siowCdate,$format);

if($siowSdate1!="")
  $siowDate_data=",siowSdate='".$siowSdate1."'";

include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqliow = "UPDATE siowtemp SET siowName='$siowName', siowQty='$siowQty',siowUnit='$siowUnit', analysis='$analysis', siowDate='$todat'".
                  "$siowDate_data , siowCdate='$siowCdate1' WHERE siowid=$siow";

//echo $sqliow;
$sqlruniow= mysqli_query($db, $sqliow);

echo "Your Information is Updating.. Please wait..";
	 
//echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=./index.php?keyword=site+view+dma&iow=$iow&iowStatus=$iowStatus\">";
echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=./index.php\">";

}
 ?>

<form name="form_siow" action="./index.php?keyword=edit+sub+item+work&siow=<? echo $siow;?>&iow=<? echo $iow;?>&iowStatus=<? echo $iowStatus;?>" method="post">
<table align="center" width="500"  border="1" bordercolor="#BFDBFF" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#BFDBFF">  
 <td align="center" colspan="2" class="englishheadBlack">Edit Sub Item of Work  (SIOW)</td>
</tr> 

<tr>
 <td>Project Name</td>
  <td><? echo $loginProjectName;?></td>
</tr> 
<?
if($siow){
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqliow = "SELECT * from siowtemp where siowId= $siow";
//echo $sqliow;
$sqlruniow= mysqli_query($db, $sqliow);
$iowR= mysqli_fetch_array($sqlruniow);
}
 ?>

<tr>
  <td>Sub Item of Work Code</td> 
  <td><? echo iowCode($iowR[iowId]).'<b><font class=out>'.$iowR[siowCode].'</font></b>';?></td>
</tr>
<tr>
  <td>IOW Qty</td> 
  <td><? echo  iowQty($iowR[iowId]);?></td>
</tr>
<tr>
  <td>Sub Item of Work Name</td> <td><input name="siowName" value="<? echo $iowR[siowName];?>" size="40"></td> 
</tr>
<tr>
  <td>Quantity</td> <td><input name="siowQty" value="<? echo $iowR[siowQty];?>"></td> 
</tr>

<tr>
  <td>Unit</td> <td><input name="siowUnit" value="<? echo $iowR[siowUnit];?>"></td> 
</tr>

<tr>
  <td>Analysis Considering </td> <td><input name="analysis" value="<? echo $iowR[analysis];?>"> unit</td> 
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
      <td>


<input type="text" name="siowSdate" maxlength="10" value="<? echo date("j/m/Y",strtotime($iowR[siowSdate]));?>" readonly="" title="Planned Date of Start">	  
	  
<? if($loginDesignation=='admin' or $loginDesignation=='Manager Planning & Control' or $loginDesignation=='Project Manager' or $loginDesignation=='Project Engineer'){?><a id="anchor1" href="#"
   onClick="cal.select(document.forms['form_siow'].siowSdate,'anchor1','dd/MM/yyyy'); return false;"
   name="anchor1"><img src="./images/b_calendar.png" alt="calender" border="0"></a> 	  
   <? }?>	  
	     </td> 
</tr>

<tr>
  <td>Planned Date of Completion</td> 
  <td><input name="siowCdate" maxlength="10" value="<? echo date("j/m/Y",strtotime($iowR[siowCdate]));?>" readonly="" alt="req" title="Planned Date of Completion"> <a id="anchor11" href="#"
   onClick="cal.select(document.forms['form_siow'].siowCdate,'anchor11','dd/MM/yyyy'); return false;"
   name="anchor2"><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
   </td> 
</tr>

<tr bgcolor="#F4FaFF">
<td align="center" colspan="2">  
  <input type="button" name="btneditsiow" value="Edit Sub Item of Work" 
  onClick="form_siow.editsiow.value='Edit Sub Item of Work';form_siow.submit();">
  <input type="hidden" name="editsiow" value="0">
  </td> 
</tr>
<tr bgcolor="#BFDBFF">  
 <td align="center" colspan="2" height="5"></td>
</tr> 

</table>

<input type="hidden" name="siowCode" value="<? echo $iowR[iowCode];?>">
</form>
<div id=testdiv1
      style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
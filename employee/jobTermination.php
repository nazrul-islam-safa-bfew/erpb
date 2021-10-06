<? 
if($jobT){
$format="Y-m-j";
$tdate = formatDate($d1,$format);

$sql1="DELETE FROM attendance WHERE empId=$id AND edate >'$tdate'";
//echo $sql1.'<br>';
$sqlq1=mysqli_query($db, $sql1);

$sql="UPDATE employee set jobTer='$tdate',status='-2' where empId=$id";
//echo $sql.'<br>';
$sqlq=mysqli_query($db, $sql);
echo " Informatin Updating now...........";
echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=./index.php?keyword=employee+details\">";
}
?>

<? 
if(!$jobT){
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

 $sql1="SELECT * FROM employee WHERE empId='$id'";
 //echo $sql1;
 $sqlq1=@mysqli_query($db, $sql1) or die('Please try later!!');
 $emp= mysqli_fetch_array($sqlq1);
?>
	<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
<form name="jobTermination" action="./index.php?keyword=job+termination&id=<? echo $id;?>" method="post">
<table align="center" width="500" border="3"  bordercolor="CC9999" cellpadding="3" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td align="right" valign="top" colspan="2"><font class='englishhead'>job termination form</font></td>
</tr>

<tr>
 <td>Name</td>
 <td><? echo $emp[name];?></td> 
</tr>
<tr>
 <td>Designation</td>
 <td><? 
$designation=$emp[designation];
 echo hrDesignation($emp[designation]);
 ?></td> 
</tr>
	<SCRIPT LANGUAGE="JavaScript">
	var now = new Date(); 
	var cal = new CalendarPopup("testdiv1");
    	//cal.showNavigationDropdowns();
		cal.setWeekStartDay(6); // week is Monday - Sunday
		//cal.addDisabledDates(null,formatDate(now,"yyyy-MM-dd")); 
		cal.setCssPrefix("TEST");		
		cal.offsetX = -300;
		cal.offsetY = -80;
		
	</SCRIPT>
<tr>
 <td>Terminate From </td>
 <td><input type="text" maxlength="10" name="d1" > <a id="anchor" href="#"
   onClick="cal.select(document.forms['jobTermination'].d1,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
  </td> 
 
</tr>
<tr><td colspan="2" align="center"><input type="button" name="Save"  value="Terminate" onClick="jobT.value=1;jobTermination.submit();">
 <input type="hidden" name="jobT" value="0">
</td></tr>
</table>
</form>
<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
<? }?>
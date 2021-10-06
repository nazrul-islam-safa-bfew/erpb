	<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
<?  

if($id){
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

 $sql=@mysqli_query($db, "SELECT * FROM employee WHERE id=$id") or die('Please try later!!');
 $eqresult= mysqli_fetch_array($sql);

}

?>
<form name="employe" onsubmit="return validateForm( this, 0, 1, 0, 0, 15 );" action="./employee/localempEntry.sql.php" method="post">
<table align="center" width="500" border="3"  bordercolor="CC9999" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td align="right" valign="top" height="30"><font class='englishhead'>local employee recruit</font></td>
</tr>
<tr>
 <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>	
   <td>Designation</td>
  <td>
  <select name='designation' size='1' >
<? 
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT * from `itemlist` Where itemCode >= '86-01-000' AND itemCode < '99-01-000'";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

 while($typel= mysqli_fetch_array($sqlrunp))
{
 echo "<option value='".$typel[itemCode]."'";
if($eqresult[designation]){$designation=$eqresult[designation];}

 if($designation==$typel[itemCode]) echo "SELECTED";
 echo ">$typel[itemCode]--$typel[itemDes]</option>  ";
 }
 ?>
</select>
</td>
</tr>

<tr bgcolor="#FFEEEE">
   <td><LABEL for=name>Name</LABEL></td>
   <td ><input type="text" size="30"  name="name" value="<? echo $eqresult[name];?>" alt="blank" emsg="<br>Enter Name" ></td>
</tr>
	<SCRIPT LANGUAGE="JavaScript">
	var now = new Date(); 
	var cal = new CalendarPopup("testdiv1");
    	//cal.showNavigationDropdowns();
		cal.setWeekStartDay(6); // week is Monday - Sunday
		cal.addDisabledDates(null,formatDate(now,"yyyy-MM-dd")); 
		cal.setCssPrefix("TEST");		
		cal.offsetX = 25;
		cal.offsetY = -120;
		
	</SCRIPT>

<tr bgcolor="#FFEEEE">
   <td>Join Date</td>
      <td><input type="text" maxlength="10" name="gdate" value="<? echo $gdate;?>" > <a id="anchor1" href="#"
   onClick="cal.select(document.forms['employe'].gdate,'anchor1','dd/MM/yyyy'); return false;"
   name="anchor1" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
      </td> 
</tr>
<tr bgcolor="#FFEEEE">
   <td><LABEL for=salary>Wages</LABEL></td>
   <td ><input type="text" name="salary" value="<? echo $eqresult[salary];?>"  alt="number" emsg="<br>Enter Wages" >/ day</td>
</tr>
<tr><td colspan="2" align="center" ><input type="submit" name="save" value="Save" class="store" ></td></tr>
</table>
 </td>
</tr>
</table>
<input type="hidden" name="id" value="<? echo $id;?>">
</form>
	
<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
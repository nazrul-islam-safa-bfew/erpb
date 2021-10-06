<br><br><br><br>
<script type="text/javascript">
			 function ShowDiv(divName){   
			 var divmain = document.getElementById(divName);        		 
			   divmain.className= "visible";
			  // document.getElementById('av1').checked=true;
			   }
			 function hidDiv(divName){           		 
			 var divmain = document.getElementById(divName);        		 
			   divmain.className= "hidden";
			 }
</script>

	<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
<?  

if($id){
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

 $sql=mysqli_query($db, "SELECT * FROM employee WHERE empId=$id") or die('Please try later!!');
 $eqresult= mysqli_fetch_array($sql);

}

?>
<form name="employe" onsubmit="return checkrequired(this);" action="./employee/local_empEntry.sql.php" method="post">
<table align="center" width="500" border="3"  bordercolor="CC9999" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td align="right" valign="top" height="30"><font class='englishhead'>human resource entry form</font></td>
</tr>
<tr>
 <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="3">

<tr>	
   <td width=250>Designation</td>
  <td >
  <select name='designation' size='1' onChange="location.href='index.php?keyword=local+emp+recruit&designation='+employe.designation.options[document.employe.designation.selectedIndex].value";>
<? 
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT * from `itemlist` Where itemCode >= '86-01-000' AND itemCode < '98-01-000'";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

if(!$loginDesignation='Human Resource Executive')
 while($typel= mysqli_fetch_array($sqlrunp))
{
 echo "<option value='".$typel[itemCode]."'";
if($eqresult[designation]){$designation=$eqresult[designation];}

 if($designation==$typel[itemCode]) echo "SELECTED";
 echo ">$typel[itemCode]--$typel[itemDes]</option>  ";
 }
else
{
	$sqlp2 = "SELECT * from `itemlist` Where itemCode >= '90-00-000' AND itemCode < '92-99-999'";
	//echo $sqlp;
	$sqlrunp2= mysqli_query($db, $sqlp2);
	while($typel= mysqli_fetch_array($sqlrunp2)){	
			echo "<option value='".$typel[itemCode]."'";
			if($eqresult[designation]){$designation=$eqresult[designation];}
			if($designation==$typel[itemCode]) echo "SELECTED";
 			echo ">$typel[itemCode]--$typel[itemDes]</option>  ";
	}
}
 ?>
</select>
<? //echo $eqresult[designation];?>
</td>
</tr>

<tr bgcolor="#FFEEEE">
   <td><LABEL for=name>Name</LABEL></td>
   <td ><input type="text" size="30"  name="name" value="<? echo $eqresult[name];?>" alt="req" title="Name"  ></td>
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
<tr >
   <td>Career Started in</td>
      <td><input type="text" maxlength="10" name="creDate" value="<? if($eqresult[creDate]=='') echo date("d/m/Y"); else echo date("d/m/Y",strtotime($eqresult[creDate]));?>" readonly="" alt="req" title="Career Started in"> <a id="anchor" href="#"
   onClick="cal.select(document.forms['employe'].creDate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
      </td> 
</tr>

<tr bgcolor="#FFEEEE">
   <td>Joined BFEW in</td>
      <td><input type="text" maxlength="10" name="empDate" value="<? if($eqresult[empDate]=='') echo date("d/m/Y"); else echo date("d/m/Y",strtotime($eqresult[empDate]));?>" readonly="" alt="req" title="Joined BFEW in"> <a id="anchor1" href="#"
   onClick="cal.select(document.forms['employe'].empDate,'anchor1','dd/MM/yyyy'); return false;"
   name="anchor1" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
      </td> 
</tr>

<tr >
  <td ><LABEL for=salary>Wages</LABEL></td>
  <td ><input type="text" name="salary" value="<? echo $eqresult[salary];?>"  alt="req" title="Enter Wages" > Tk./ Day</td>
</tr>

<tr><td colspan="2" align="center" ><input type="submit" name="save" value="Save" class="store" ></td></tr>
	</table>
 </td>
</tr>
</table>
<input type="hidden" name="id" value="<? echo $id;?>">
</form>
	
<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
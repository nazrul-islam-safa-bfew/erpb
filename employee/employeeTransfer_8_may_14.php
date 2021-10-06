	<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>

<form name="empTransfer" action="./employee/empTransfer.sql.php" method="post">
<table align="center" width="90%" border="3"  bordercolor="CC9999" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td colspan="2" align="right" valign="top" height="30"><font class='englishhead'>human resource transfer form</font></td>
</tr>
<tr><td>Transfer From</td>
    <td>
	<select name="transferFrom" onChange="location.href='index.php?keyword=employee+transfer&transferFrom='+empTransfer.transferFrom.options[document.empTransfer.transferFrom.selectedIndex].value";>
    <option value="0">Select One</option>
	<? 
	include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT `pcode`,pname from `project` ORDER by pcode ASC";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
 while($typel= mysqli_fetch_array($sqlrunp))
{
echo "<option value='".$typel[pcode]."'";
 if($transferFrom==$typel[pcode])  echo " SELECTED";
 echo ">$typel[pcode]--$typel[pname]</option>  ";
 }?>
 </select>
 </td> 

</tr>

<? if($transferFrom){?>
<tr><td>Transfer To</td>
    <td>
	<select name="transferTo" >
	<? 
	include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT `pcode`,pname from `project` ORDER by pcode ASC";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
 while($typel= mysqli_fetch_array($sqlrunp))
{
echo "<option value='".$typel[pcode]."'";
 //if($transferFrom==$typel[pcode])  echo " SELECTED";
 echo ">$typel[pcode]--$typel[pname]</option>  ";
 }?>
 </select>
 </td> 
</tr>

<tr>
  <td>Transfer Referance</td>
  <td><input type="text" name="transferRef" size="40" maxlength="100"></td>
</tr>
<tr>
 <td>Report Date</td>
 <td>
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

	<input type="text" maxlength="10" name="reportDate" value="" > <a id="anchor" href="#"
	   onClick="cal.select(document.forms['empTransfer'].reportDate,'anchor','dd/MM/yyyy'); return false;"
	   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 	
  </td>
</tr>
<tr>
 <td>Will Stay Till</td>
 <td>
	<input type="text" maxlength="10" name="stayDate" value="" > <a id="anchor1" href="#"
	   onClick="cal.select(document.forms['empTransfer'].stayDate,'anchor1','dd/MM/yyyy'); return false;"
	   name="anchor1" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 	
  </td>
</tr>

<tr>
 <td colspan="2">
  <table width="100%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="5" style="border-collapse:collapse">
    <tr>
	  <th>EmpID</th>
	  <th>Name</th>
	</tr>
	<tr><td colspan="2"></td></tr>
<? include("config.inc.php");

$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$sqlp = "SELECT * from `employee` WHERE location='$transferFrom' AND designation!='70-01-000' AND status=0 order by designation ASC ";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
$i=1;
while($emp=mysqli_fetch_array($sqlrunp)){
$empId=empId($emp[empId],$emp[designation]);
$c=isSupervisor($empId);

	?>
	<tr <? if($i%2==0) echo  "bgcolor=#EEEEEE";?>>
	  <td align="left"><input type="checkbox" name="ech<? echo $i;?>" value="<? echo $emp[empId];?>" <? if($c) echo " disabled"; ?>>
	  <input type="hidden" name="designation<? echo $i;?>"  value="<? echo $emp[designation]?>">
	  <? 
                
	  echo empId($emp[empId],$emp[designation]).', '.hrDesignation($emp[designation]);
	  $temp1 =  empTransfer($emp[empId]);
	 // print_r($temp1); 
	 
	 if($temp1[status]==0) 
	 {
		 echo '<br>Transfered From  <font class=out> '.$temp1[transferFrom].'</font> To <font class=out>'.$temp1[transferTo].'</font>';
		 echo ' from ' .mydate($temp1[reportDate]).' to '.mydate($temp1[stayDate]);
 	     echo "<a href='./employee/empTransfer.sql.php?tid=$temp1[tid]'>[ DELETE ]</a>";		 
	 } 
	  else if($temp1[status]==2) {echo '<br>Transfered From ' .mydate($temp1[reportDate]).' to '.mydate($temp1[stayDate]);}
	    ?>
		<input type="hidden" name="plocation<? echo $i;?>" value="<? echo $temp1[transferTo];?>" />
		<input type="hidden" name="tid<? echo $i;?>" value="<? echo $temp1[tid];?>" />

	  </td>
	  <td align="left"><? echo $emp[name];?>
	  <? if($c) echo "<br>Assigned as Task Supervisor [ <font class=out>Cann't transfer</font>]";?>
	  </td>
</tr>
<? $i++;}//while?>	
  </table>
 </td>
</tr>
<input type="hidden" name="n" value="<? echo $i;?>">
<tr><td colspan="2" align="center"><input type="button" name="teansfer" value="Transfer" onClick="empTransfer.submit();"></td></tr>
<? } //if $transferTo?>
</table>
</form>

<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>

<!--<a href="./employee/updateempTransfer.sql.php">Click for update transfer</a>-->
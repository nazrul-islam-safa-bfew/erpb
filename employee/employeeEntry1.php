			 <script type="text/jscript">
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
	

 $sql=@mysqli_query($db, "SELECT * FROM employee WHERE empId=$id") or die('Please try later!!');
 $eqresult= mysqli_fetch_array($sql);

}

?>
<form name="employe" onsubmit="return checkrequired(this);" action="./employee/employeeSql.php" method="post">
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
  <select name='designation' size='1' onChange="location.href='index.php?keyword=employee+entry&designation='+employe.designation.options[document.employe.designation.selectedIndex].value";>
<? 
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT * from `itemlist` Where itemCode >= '70-01-000' AND itemCode < '98-01-000'";
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
<? if($id){?>
<tr >
  <td>Career Started in</td>
  <td><? echo $eqresult[creDate];?></td> 
</tr>
<tr bgcolor="#FFEEEE">
   <td>Joined BFEW in</td>
   <td><? echo $eqresult[empDate];?></td> 
</tr>

<? } else{?>
<tr >
   <td>Career Started in</td>
      <td><input type="text" maxlength="10" name="creDate" value="<?  if($eqresult[creDate]=='') echo date("d/m/Y"); else echo date("d/m/Y",strtotime($eqresult[creDate])); ?>" readonly="" alt="req" title="Career Started in"> <a id="anchor" href="#"
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
<? }?>
<!--
<tr >
   <td>Last Promoted in</td>
      <td><input type="text" maxlength="10" name="proDate" value="<? echo date("d/m/Y",strtotime($eqresult[proDate]));?>" readonly="" alt="req" title="Last Promoted in"  > <a id="anchor2" href="#"
   onClick="cal.select(document.forms['employe'].proDate,'anchor2','dd/MM/yyyy'); return false;"
   name="anchor2" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
      </td> 
</tr>
-->
<!-- 
<tr bgcolor="#FFEEEE">
   <td>Type of Employment</td>
   <td ><select name="pament">
        <option <? if($eqresult[pament]=='Permanent') echo 'selected';?> >Permanent</option>
        <option <? if($eqresult[pament]=='Contract Basis') echo 'selected';?> >Contract Basis</option>		
   </select></td>
</tr>
 --><!-- <tr >
   <td>Payment Type</td>
   <td ><select name="salaryType">
        <option <? if($eqresult[salaryType]=='Salary') echo 'selected';?>>Salary</option>
        <option <? if($eqresult[salaryType]=='Wages') echo 'selected';?>>Wages</option>		
   </select></td>
</tr>
 -->
 <? if($designation<'87-00-000'){?>
<tr bgcolor="#FFEEEE">
   <td><LABEL for=salary>Salary</LABEL></td>
   <td ><input type="text" name="salary" value="<? echo $eqresult[salary];?>"  alt="req" title="Salary" >
   <input type="hidden" name="salaryType" value="Salary"> 
   </td>
</tr>

 <? }
 else { 
 if($eqresult[salaryType]=='Wages Monthly') $c1=' checked ';
 elseif($eqresult[salaryType]=='Wages Monthly Master Roll') $c2=' checked ';
 
// echo "*********$eqresult[salaryType]******";
 ?>
 
<tr bgcolor="#FFEEEE">
   <td><LABEL for=salary>Wages Type</LABEL></td>
   <td >
	   <input type="radio" name="salaryType" value="Wages Monthly" <? echo $c1;?> 
	    onClick="hidDiv('div1');hidDiv('div2');"> Monthly Consolidated <br>
       <input type="radio" name="salaryType" value="Wages Monthly Master Roll" <? echo $c2;?> 
	   onClick="ShowDiv('div1');ShowDiv('div2');">Wages Monthly Master Roll </td>
</tr>

<tr >
  <td ><LABEL for=salary>Wages</LABEL></td>
  <td ><input type="text" name="salary" value="<? echo $eqresult[salary];?>"  alt="req" title="Enter Wages" > Tk.</td>
</tr>

<tr >
   <td width=250 ><DIV  id=div1 class=hidden ><LABEL for=salary>Allowence</LABEL></div></td>
   <td ><DIV  id=div2 class=hidden ><input type="text" name="allowance" value="<? echo $eqresult[allowance];?>"  title="Enter Allowence" > Tk.  </div></td>
</tr>
<!--<tr>
 <td colspan="2"><DIV  id=div1 class=visible >
    <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse">
		<tr >
		   <td width="52%"><LABEL for=salary>Monthly Wages</LABEL></td>
		   <td width="48%" ><input type="text" name="salary" value="<? echo $eqresult[salary];?>"  alt="number" emsg="<br>Enter Wages" > Tk.
		   </td>
		</tr>	
	</table>
</div></td>
</tr>
-->
<? }?>
<tr bgcolor="#FFEEEE">	
   <td>Additional Responsibilities and Skills</td>
  <td><? 
$pi = explode(",",$eqresult[addJob]);   
$plist= "<select name='additional[]' size='5' multiple >";
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT * from `itemlist` where itemCode >= '72-01-000' AND itemCode < '98-01-000' ORDER BY itemCode ASC";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

 while($typel= mysqli_fetch_array($sqlrunp))
{
 $plist.= "<option value='".$typel[itemCode]."'";

foreach($pi as $d2){
  if($d2 == $typel[itemCode]) $plist.= "SELECTED";
}
 $plist.= ">$typel[itemCode]-$typel[itemDes]</option>  ";
 }
 $plist.= '</select>';
 echo $plist;
 ?>
</td>
</tr>
<tr><td colspan="2" align="center" ><input type="submit" name="save" value="Save" class="store" ></td></tr>
	</table>
 </td>
</tr>
</table>
<input type="hidden" name="id" value="<? echo $id;?>">
</form>
	
<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
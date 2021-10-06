	<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
	
<form name="eqre" action="./employee/employeeSql.php"  method="post">
<table align="center" width="500" border="3"  bordercolor="CC9999" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td align="right" valign="top" colspan="2"><font class='englishhead'>Employee Requisition Form</font></td>
</tr>
 <tr>
   <td> Employee Id</td><td><? echo $eqid;?>
    <input type="hidden" name="eqCode" value="<? echo $eqid;?>">
   </td>   
 </tr>
<tr bgcolor="#FFEEEE">
   <td> Employee Description</td><td><? $test = itemDes($eqid); echo $test[des].', '.$test[spc];?></td>   
 </tr>

<tr >
   <td> Quantity</td><td><input type="text" name="quantity" size="5" ></td>   
 </tr>
	<SCRIPT LANGUAGE="JavaScript">
	var now = new Date(); 
	var cal = new CalendarPopup("testdiv1");
    	//cal.showNavigationDropdowns();
		cal.setWeekStartDay(6); // week is Monday - Sunday
		//cal.addDisabledDates(null,formatDate(now,"yyyy-MM-dd")); 
		cal.setCssPrefix("TEST");		
		cal.offsetX = 0;
		cal.offsetY = 0;		
	</SCRIPT>
 
<tr bgcolor="#FFEEEE">
   <td>Last date of Receiving  at Site</td>
     <td><input type="text" maxlength="10" name="rdate" value="<? echo date("j/m/Y",strtotime($eqresult[mnfPro]));?>" > <a id="anchor" href="#"
   onClick="cal.select(document.forms['eqre'].rdate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
      </td> 
  
 </tr>
 <tr>
   <td>Planned Date of Dispatch form Site </td>
     <td><input type="text" maxlength="10" name="ddate" value="<? echo date("j/m/Y",strtotime($eqresult[mnfPro]));?>" > <a id="anchor1" href="#"
   onClick="cal.select(document.forms['eqre'].ddate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor1" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
      </td> 
 </tr>
  <tr>
   <td colspan="2" align="center"><input type="submit" value="Add Requisition" name="addRequisition"></td>
 </tr>

</table>
</form>
<div id=testdiv1
      style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
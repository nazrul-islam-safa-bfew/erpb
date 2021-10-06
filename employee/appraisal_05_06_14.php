			 <script type="text/jscript">
			 function ShowDiv(divName){   
			 var divmain = document.getElementById(divName);        		 
			   divmain.className= "visible";
			   document.getElementById('av1').checked=true;
			   }
			 function hidDiv(divName){           		 
			 var divmain = document.getElementById(divName);        		 
			   divmain.className= "hidden";
			   }
			</script>

	<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>

<? 	include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT * from `employee` WHERE empId=$id";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
$typel= mysqli_fetch_array($sqlrunp);
?>
<br /><br /><br /><br /><br /><br /><br />
<form name="app" action="./employee/appraisal.sql.php" method="post">
<table align="center" width="700" border="3"  bordercolor="CC9999" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
	<tr bgcolor="#CC9999">
			<SCRIPT LANGUAGE="JavaScript">
	var now = new Date(); 
	var cal = new CalendarPopup("testdiv1");
    	//cal.showNavigationDropdowns();
		cal.setWeekStartDay(6); // week is Monday - Sunday
		//cal.addDisabledDates(null,formatDate(now,"yyyy-MM-dd")); 
		cal.setCssPrefix("TEST");		
		cal.offsetX = 25;
		cal.offsetY = -120;
		
	</SCRIPT>
	  <td align="left">Appraisal Date:
			  <input type="text" maxlength="10" name="appDate" value=""><a id="anchor" href="#"
		   onClick="cal.select(document.forms['app'].appDate,'anchor','dd/MM/yyyy'); return false;"
		   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
	  </td>

	 <td align="right" valign="top"><font class='englishhead'>performance appraisal</font></td>
	</tr>
	<tr>
	 <td width="50%">Employee Name: <? echo $typel[name];?></td>
	 <td width="50%">Designation: <?  echo hrDesignation($typel[designation]);?>
	 </td>	 
	</tr>
	<tr>
	 <td>Department: </td> 
	 <td>Employee ID: <? echo empId($typel[empId],$typel[designation]);?>
	 	   <input type="hidden" name="empId" value="<? echo $typel[empId];?>"></td>	 
	</tr>
    <tr>
	</tr>
	<tr>
	  <td colspan="2" bgcolor="#f8f8f8">
	     <table width="100%"  cellpadding="0" cellspacing="0" style="border-collapse:collapse">
            <tr><td bgcolor="#f8f8f8" colspan="3">Reason for Review:</td></tr> 
			<tr>
			 <td><input type="radio" name="reason" value="1" checked onClick="hidDiv('div1'); ShowDiv('div2');">Annual</td>
			 <td><input type="radio" name="reason" value="2" onClick="hidDiv('div1'); ShowDiv('div2');">Promotion/ Increment/ Bonus </td>	 
			 <td><input type="radio" name="reason" value="3" onClick="ShowDiv('div1'); ShowDiv('div2');">Unsatisfactory Performance</td> 
			 </tr>
			 <tr>
			 <td><input type="radio" name="reason" value="4" onClick="hidDiv('div1'); ShowDiv('div2');">Training need assesment</td>	 
			 <td><input type="radio" name="reason" value="5" onClick="hidDiv('div1'); ShowDiv('div2');">End Probation Period</td> 
			 <td><input type="radio" name="reason" value="6" onClick="hidDiv('div1'); ShowDiv('div2');">End of Project</td> 			 
			 </tr>
			 <tr>
			  <td colspan="3"><input type="radio" name="reason" value="7"  onClick="ShowDiv('div1');ShowDiv('div2');">Other <input type="text" size="70"></td>	 	 	 
			</tr>
			<tr>
			
			 <td colspan="3"><DIV  id=div1 class=hidden >
			  <table border="2" bordercolor="#FF6666"  cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td>
					<p align="center"><input type="radio" name="onsite" id="av1" value="1" checked onClick="ShowDiv('div2');">In Presence of Employee
						<input type="radio" name="onsite" id="av2" value="2" onClick="hidDiv('div2');">In Absence of Employee</p></td>
				</tr>
			  </table>
				</div>			
			</td></tr>
			
		 </table>
	  </td>
	</tr>
	<tr>
	  <td colspan="2">
	  Instructions: Carefully evaluate employee's work performance in relation to current job requirements. Check rating box to indicate the employee's performance. Points will be totaled and averaged for an overall performance score. 
	  </td>
	</tr>
	<tr>
	  <td colspan="2" align="center" bgcolor="#FFFFCC"> Rating Identification</td>
	</tr>
	<tr>
	  <td><b><font class="out">O</font></b>-<b>Outstanding</b>-Performance is exceptional in all areas and is recognizable as being far superior to others (<i>100 points</i>). </td>
	  <td><b><font class="out">I</font></b>-<b>Improvement Needed</b>-Performance is deficient in certain areas. Improvement is necessary(<i>50 points</i>). </td>
	</tr>
	<tr>
	  <td><b><font class="out">V</font></b>-<b>Very Good</b>-Results clearly exceed most position requirements, Performance is of high quality and is achieved on a consistent basis (<i>90 points</i>). </td>
	  <td><b><font class="out">U</font></b>-<b>Unsatisfactory</b>-Results are 
        unacceptable. No merit increase should be granted to individuals with 
        this rating (<i>0 points</i>). </td>
	</tr>
	<tr>
	<td><b><font class="out">G</font></b>-<b>Good</b>-Competent and dependable level of performance Meets performance standards of the job (<i>80 points</i>). </td>
	  <td><b><font class="out">N</font></b>-<b>Not Rated-</b>Not enough informaton 
        available to judge performance (<i>55 points</i>). </td>
	</tr>
	<tr>
	  <td colspan="2">
	   <table width="100%" border="2" bordercolor="#CC99FF" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
	     <tr bgcolor="#eeeeff">
		   <th width="40%">GENERAL FACTORS</th>
		   <th width="10%">RATING</th>
		   <th width="50%">SUPPORTIVE DETAILS</th>
		 </tr>
<!--		 
		 <tr>
		   <td><b>Quality</b>- The accuracy, thoroughness and acceptability of work performed</td>
		   <td><input type="radio" name="quality" value="100">O<br>
		   <input type="radio" name="quality" value="90">V<br>
		   <input type="radio" name="quality" value="80">G<br>
		   <input type="radio" name="quality" value="50">I<br>
		   <input type="radio" name="quality" value="0">U<br>
		   <input type="radio" name="quality" value="55" checked>N</td>
		   <td><textarea cols="45" rows="6" name="text_quality"></textarea></td>
		 </tr>
-->		 
		 <tr><td colspan="3" bgcolor="#9966CC"></td></tr>
		 <tr bgcolor="#eeeeff">
		   <td><b>Productivity</b> - The quantity and efficiency of work produced in a specified period of time.</td>
		   <td><input type="radio" name="productivity" value="100">O<br>
		   <input type="radio" name="productivity" value="90">V<br>
		   <input type="radio" name="productivity" value="80">G<br>
		   <input type="radio" name="productivity" value="50">I<br>
		   <input type="radio" name="productivity" value="0">U<br>
		   <input type="radio" name="productivity" value="55" checked>N</td>
		   <td><textarea cols="45" rows="6" name="text_productivity"></textarea></td>
		 </tr>
		 <tr><td colspan="3" bgcolor="#9966CC"></td></tr>		 
		 <tr>
		   <td><b>Job Knowledge and Innovativeness</b>-The practical/technical skills and information used on the job.</td>
		   <td><input type="radio" name="jobknowledge" value="100">O<br>
		   <input type="radio" name="jobknowledge" value="90">V<br>
		   <input type="radio" name="jobknowledge" value="80">G<br>
		   <input type="radio" name="jobknowledge" value="50">I<br>
		   <input type="radio" name="jobknowledge" value="0">U<br>
		   <input type="radio" name="jobknowledge" value="55" checked>N</td>
		   <td><textarea cols="45" rows="6" name="text_jobknowledge"></textarea></td>
		 </tr>
		 <tr><td colspan="3" bgcolor="#9966CC"></td></tr>
		 <tr bgcolor="#eeeeff">
		   <td><b>Reliability</b>-The extent to which an employee can be relied upon regarding task completion and follow up.</td>
		   <td><input type="radio" name="reliability" value="100">O<br>
		   <input type="radio" name="reliability" value="90">V<br>
		   <input type="radio" name="reliability" value="80">G<br>
		   <input type="radio" name="reliability" value="50">I<br>
		   <input type="radio" name="reliability" value="0">U<br>
		   <input type="radio" name="reliability" value="55" checked>N</td>
		   <td><textarea cols="45" rows="6" name="text_reliability"></textarea></td>
		 </tr>
		 <tr><td colspan="3" bgcolor="#9966CC"></td></tr>		 
		 <tr>
		   <td><b>Punctuality</b>-The extent to which an employee is punctual, observes prescribed work break/ meal periods and the overall attendance record. </td>
		   <td><input type="radio" name="availability" value="100">O<br>
		   <input type="radio" name="availability" value="90">V<br>
		   <input type="radio" name="availability" value="80">G<br>
		   <input type="radio" name="availability" value="50">I<br>
		   <input type="radio" name="availability" value="0">U<br>
		   <input type="radio" name="availability" value="55" checked>N</td>
		   <td><textarea cols="45" rows="6" name="text_availability"></textarea></td>
		 </tr>
		 <tr><td colspan="3" bgcolor="#9966CC"></td></tr>
		 <tr bgcolor="#eeeeff">
		   <td><strong>Trust worthy </strong>-The extent to which an employee is faithful to the company in saving  money, information or any other resources.</td>
		   <td><input type="radio" name="independence" value="100">O<br>
		   <input type="radio" name="independence" value="90">V<br>
		   <input type="radio" name="independence" value="80">G<br>
		   <input type="radio" name="independence" value="50">I<br>
		   <input type="radio" name="independence" value="0">U<br>
		   <input type="radio" name="independence" value="55" checked>N</td>
		   <td><textarea cols="45" rows="6" name="text_independence"></textarea></td>
		 </tr>
		 		 <tr><td colspan="3" bgcolor="#9966CC"></td></tr>
		 <tr>
		   <td><b>Reporting</b>-The extent of which employee reports for and remain of work as required. </td>
		   <td><input type="radio" name="reporting" value="100">O<br>
		   <input type="radio" name="reporting" value="90">V<br>
		   <input type="radio" name="reporting" value="80">G<br>
		   <input type="radio" name="reporting" value="50">I<br>
		   <input type="radio" name="reporting" value="0">U<br>
		   <input type="radio" name="reporting" value="55" checked>N</td>
		   <td><textarea cols="45" rows="6" name="text_reporting"></textarea></td>
		 </tr>
		 <tr><td colspan="3" bgcolor="#9966CC"></td></tr>
		 <tr bgcolor="#eeeeff">
		   <td><b>Teamwork Attitude</b> (as a Member or Leader)-The extent of which employee get along and cooperate with co-workers on the job.</td>
		   <td><input type="radio" name="teamwork" value="100">O<br>
		   <input type="radio" name="teamwork" value="90">V<br>
		   <input type="radio" name="teamwork" value="80">G<br>
		   <input type="radio" name="teamwork" value="50">I<br>
		   <input type="radio" name="teamwork" value="0">U<br>
		   <input type="radio" name="teamwork" value="55" checked>N</td>
		   <td><textarea cols="45" rows="6" name="text_teamwork"></textarea></td>
		 </tr>

	   </table>
	  </td>
	</tr>
	<tr><td colspan="2" bgcolor="#FFFFCC"></td></tr>
	<tr>
	  <td colspan="2">Describe any specific actions employee needs to take to improve job performance:
	    <textarea cols="100" rows="4" name="action"></textarea>
	  </td>
	</tr>
	<tr>
	  <td colspan="2">Summarize this employee's overall job performance as determined in your joint discussion<br>
	  	    <textarea cols="100" rows="4" name="summarize"></textarea>
	  </td>
	</tr>
	<tr><td colspan="2"></td></tr>
	<tr>
	  <td colspan="2">
	     <table>
		   <tr>
			 <td height="50" width="250" valign="top" >
			 <font style="font-size:10px">This report is based on my observation and knowledge of both the employee and the job.</font><br>
			 <u> <? echo $loginFullName." ($loginDesignation)" ;?></u><br>
			 <input type="hidden" name="supervisor" value="<? echo $loginFullName;?>">	 
			 </td>
			 <td height="50" width="250"  valign="top" >
		<DIV  id=div2 class=visible >
			 <font style="font-size:10px">My signature indicates that I have reviewed this appraisal. It does not mean that I agree with the results.</font><br>
			 Employee:<u> <? echo $typel[name];?></u><br>
			 </DIV>
			 </td>
			 <td height="50" width="200"  valign="top" >
			 HR Representative:<br><input type="text" name="hrsupervisor">
			 </td>		   
		   </tr>
		 </table>
	  </td>
	 </tr>
	 <tr><td colspan="2" align="center"> <input type="submit" name="save" value="Submit to HR Department"></td></tr>
 </table>
 </form>
<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
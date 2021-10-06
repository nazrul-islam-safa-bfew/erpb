<?
include_once("../includes/myFunction1.php");
include("../includes/config.inc.php");
include_once("../includes/myFunction.php");
include_once("../includes/empFunction.inc.php");
include_once("../includes/eqFunction.inc.php");
include_once("../includes/subFunction.inc.php");
include_once("../includes/matFunction.inc.php");
$todat=todat();
if($update){
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	$sqlp = "UPDATE appraisal set astatus=1 WHERE appId=$appId";
	//echo $sqlp;
	$sqlrunp= mysqli_query($db, $sqlp);
}
?>
<html>
<head>

<LINK href="style/indexstyle.css" type="text/css" rel="stylesheet">

<link href="style/basestyles.css" rel="stylesheet" type="text/css">
<LINK href="../style/print.css" type="text/css" rel="stylesheet">
<link href="js/fValidate/screen.css" rel="stylesheet" type="text/css">

<meta http-equiv="Content-Language" content="en-us">
<meta name="author" content="<? echo $mauthor;?>">
<meta name="copyright" content="<? echo $tt;?>">
<meta name="keywords" content="<? echo $kword;?>">
<META NAME="description" CONTENT="<? echo $des;?>">
<title>BFEW :: Print IOW</title>
</head>
<body  topmargin="1" leftmargin="5" rightmargin="5" bgcolor="#FFFFFF" >
<? 	
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT employee.*,appraisal.* 
from `employee`,appraisal 
WHERE employee.empId=$empId AND appraisal.empId=employee.empId AND appId=$appId";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
$typel= mysqli_fetch_array($sqlrunp);
?>
<div style=" position:relative;width:650px; height:2000px; margin:auto;"> 
<div style="position:relative; width:100%; height:1600px">
<table align="left" width="100%" border="3"  bordercolor="CC9999" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
	<tr bgcolor="#CC9999">
	  <td align="left">Appraisal Date:<? echo myDate($typel[appDate]);?></td>

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
			 <td><input type="radio" name="reason" value="1" disabled <? if($typel[reason]==1) echo 'checked';?> >Annual (November 1<sup>st</sup> -2<sup>nd</sup> week)</td>
			 <td><input type="radio" name="reason" value="2" disabled  <? if($typel[reason]==2) echo 'checked';?> >Disciplinary action </td>	 
			 <td><input type="radio" name="reason" value="3" disabled  <? if($typel[reason]==3) echo 'checked';?> >Resign/Retirement/Layoff</td> 
			 </tr>
			 <tr>
			 <td><input type="radio" name="reason" value="4" disabled  <? if($typel[reason]==4) echo 'checked';?> >Unsatisfactory performance</td>	 
			 <td><input type="radio" name="reason" value="5" disabled  <? if($typel[reason]==5) echo 'checked';?>  >Probation period (quarterly)</td> 
			 <td><input type="radio" name="reason" value="6" disabled  <? if($typel[reason]==6) echo 'checked';?>  >Training need assessment</td>
				</tr>
<!-- 	Demo  -->
			<tr>
				 <td><input type="radio" name="reason" disabled  value="6" onClick="hidDiv('div1'); ShowDiv('div2');">New recruit (before attendance)</td>
				 <td><input type="radio" name="reason" disabled  value="6" onClick="hidDiv('div1'); ShowDiv('div2');">Notable achievement</td>
				 <td><input type="radio" name="reason" disabled  value="6" onClick="hidDiv('div1'); ShowDiv('div2');">Promotion (evaluate against <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;proposed designation)</td>
			 </tr>
			 <tr>
			  <td colspan="3"><input type="radio" name="reason" disabled  value="7" disabled    <? if($typel[reason]==7) echo 'checked';?> >Other <input type="text" size="70" disabled ></td>	 	 	 
			</tr>
			<? if($typel[onsite] AND ($typel[reason]==6 OR $typel[reason]==3)){?>
			<tr>
			 <td colspan="3">
			  <table border="2" bordercolor="#FF6666"  cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td>
					<p align="center"><input type="radio" name="av" id="av1" value="1" <? if($typel[onsite]==1) echo 'checked';?> disabled  >In Presence of Employee
						<input type="radio" name="av" id="av2" value="2" disabled   <? if($typel[onsite]==2) echo 'checked';?>>In Absence of Employee</p></td>
				</tr>
			  </table>
			</td>
			</tr>
			<? }//onsite?>
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
<!-- 	  <td><b><font class="out">O</font></b>-<b>Outstanding</b>-Performance is exceptional in all areas and is recognizable as being far superior to others (<i>100 points</i>). </td> -->

	  <td><strong> <font color="#000000">E</font></strong>-<strong>Excellent</strong> -Performance clearly exceeds position requirements and is achieved on a consistent basis. </td>
	  <td><b><font class="out">I</font></b>-<b>Improvement Needed</b>-Performance is deficient in certain areas. Improvement is necessary.</td>
		
	</tr>
	<tr>
	<td><b><font class="out">G</font></b>-<b>Good</b>-Competent and dependable level of performance meets performance standards of the job.</td>
	  <td><b><font class="out">U</font></b>-<b>Unsatisfactory</b>-Results are unacceptable. No merit increase should be granted to individuals with this rating. </td>
<!-- 	  <td><b><font class="out">N</font></b>-<b>Not Rated-</b>Not enough informaton 
        available to judge performance (<i>55 points</i>). </td> -->
	</tr>
<!-- 	<tr>
	<td><b><font class="out">G</font></b>-<b>Good</b>-Competent and dependable level of performance Meets performance standards of the job (<i>80 points</i>). </td>
	  <td><b><font class="out">N</font></b>-<b>Not Rated-</b>Not enough informaton 
        available to judge performance (<i>55 points</i>). </td>
	</tr> -->
	<tr>
	  <td colspan="2">
	   <table width="100%" border="2" bordercolor="#CC99FF" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
	     <tr bgcolor="#eeeeff">
		   <th width="300">GENERAL FACTORS</th>
		   <th>RATING</th>
		   <th>SUPPORTIVE DETAILS</th>
		 </tr>
<!--		 
		 <tr>
		   <td width="300"><b>Quality</b>- The accuracy, thoroughness and acceptability of work performed</td>
		   <td>
		   <input type="radio" name="quality" value="100"  <? if($typel[quality]==100) echo 'checked';?>>O<br>
		   <input type="radio" name="quality" value="90"  <? if($typel[quality]==90) echo 'checked';?>>V<br>
		   <input type="radio" name="quality" value="80"  <? if($typel[quality]==80) echo 'checked';?>>G<br>
		   <input type="radio" name="quality" value="50"  <? if($typel[quality]==50) echo 'checked';?>>I<br>
		   <input type="radio" name="quality" value="-300"  <? if($typel[quality]==-300) echo 'checked';?>>U<br>
		   <input type="radio" name="quality" value="55"  <? if($typel[quality]==55) echo 'checked';?>>N</td>
		   <td><textarea cols="35" rows="6" name="text_quality"  ><? echo $typel[text_quality];?></textarea></td>
		 </tr>
-->		 
		 <tr><td colspan="3" bgcolor="#9966CC"></td></tr>
		 <tr bgcolor="#eeeeff">
		   <td><b>Personality Traits </b> -Habitual patterns of behavior, temperament and emotion.</td>
		   <td>
<!-- 				 <input type="radio" name="productivity" value="100"  <? if($typel[productivity]==100) echo 'checked';?>>O<br> -->
		   <input type="radio" name="productivity" value="100" disabled   <? if($typel[productivity]==100) echo 'checked';?>>E<br>
		   <input type="radio" name="productivity" value="50" disabled  <? if($typel[productivity]==50) echo 'checked';?>>G<br>
		   <input type="radio" name="productivity" value="0"  disabled <? if($typel[productivity]==0) echo 'checked';?>>I<br>
		   <input type="radio" name="productivity" value="-400"  disabled <? if($typel[productivity]==-400) echo 'checked';?>>U<br>
<!-- 		   <input type="radio" name="productivity" value="55" <? if($typel[productivity]==55) echo 'checked';?>>N -->
			 </td>
		   <td><textarea cols="35" rows="6" name="text_productivity"   disabled ><? echo $typel[text_productivity];?></textarea></td>
		 </tr>
		 <tr><td colspan="3" bgcolor="#9966CC"></td></tr>		 
		 <tr>
		   <td><b>Knowledge </b>- Familiarity, awareness or understanding of someone or something which is acquired through education, experience and experiments. </td>
		   <td>
<!-- 				 <input type="radio" name="jobknowledge" value="100" <? if($typel[jobknowledge]==100) echo 'checked';?>>O<br> -->
		   <input type="radio" name="jobknowledge" value="90"  disabled  <? if($typel[jobknowledge]==100) echo 'checked';?>>E<br>
		   <input type="radio" name="jobknowledge" value="80"  disabled  <? if($typel[jobknowledge]==50) echo 'checked';?>>G<br>
		   <input type="radio" name="jobknowledge" value="50"  disabled  <? if($typel[jobknowledge]==0) echo 'checked';?>>I<br>
		   <input type="radio" name="jobknowledge" value="-400"   disabled  <? if($typel[jobknowledge]==-400) echo 'checked';?>>U<br>
<!-- 		   <input type="radio" name="jobknowledge" value="55" <? if($typel[jobknowledge]==55) echo 'checked';?>>N -->
			 </td>
		   <td><textarea cols="35" rows="6" name="text_jobknowledge"  disabled  ><? echo $typel[text_jobknowledge];?></textarea></td>
		 </tr>
		 <tr><td colspan="3" bgcolor="#9966CC"></td></tr>
		 <tr bgcolor="#eeeeff">
		   <td><b>Skills</b>- Learned expertise to perform certain action successfully.</td>
		   <td>
<!-- 				 <input type="radio" name="reliability" value="100" <? if($typel[reliability]==100) echo 'checked';?>>O<br> -->
		   <input type="radio" name="reliability" value="100"  disabled   <? if($typel[reliability]==100) echo 'checked';?>>E<br>
		   <input type="radio" name="reliability" value="80"  disabled   <? if($typel[reliability]==50) echo 'checked';?>>G<br>
		   <input type="radio" name="reliability" value="50"  disabled   <? if($typel[reliability]==0) echo 'checked';?>>I<br>
		   <input type="radio" name="reliability" value="-400"  disabled   <? if($typel[reliability]==-400) echo 'checked';?>>U<br>
<!-- 		   <input type="radio" name="reliability" value="55" <? if($typel[reliability]==55) echo 'checked';?>>N -->
			 </td>
		   <td><textarea cols="35" rows="6" name="text_reliability"  disabled  ><? echo $typel[text_reliability];?></textarea></td>
		 </tr>
		 <tr><td colspan="3" bgcolor="#9966CC"></td></tr>		 
		 <tr>
		   <td><b>Ability- </b>Capacity to ensure pre-defined result by performing various tasks in a specific job. </td>
		   <td>
<!-- 				 <input type="radio" name="availability" value="100" <? if($typel[availability]==100) echo 'checked';?>>O<br> -->
		   <input type="radio" name="availability" value="90"  disabled   <? if($typel[availability]==100) echo 'checked';?>>E<br>
		   <input type="radio" name="availability" value="80"  disabled   <? if($typel[availability]==50) echo 'checked';?>>G<br>
		   <input type="radio" name="availability" value="50"  disabled   <? if($typel[availability]==0) echo 'checked';?>>I<br>
		   <input type="radio" name="availability" value="-400"  disabled   <? if($typel[availability]==-400) echo 'checked';?>>U<br>
<!-- 		   <input type="radio" name="availability" value="55" <? if($typel[availability]==55) echo 'checked';?>>N -->
			 </td>
		   <td><textarea cols="35" rows="6" name="text_availability"  disabled  ><? echo $typel[text_availability];?></textarea></td>
		 </tr>
			 
<!-- 			 
		 <tr><td colspan="3" bgcolor="#9966CC"></td></tr>
		 <tr bgcolor="#eeeeff">
		   <td><b>Independence</b>-The extent of work performed with little or no supervision.</td>
		   <td><input type="radio" name="independence" value="100" <? if($typel[independence]==100) echo 'checked';?>>O<br>
		   <input type="radio" name="independence" value="90" <? if($typel[independence]==90) echo 'checked';?>>V<br>
		   <input type="radio" name="independence" value="80" <? if($typel[independence]==80) echo 'checked';?>>G<br>
		   <input type="radio" name="independence" value="50" <? if($typel[independence]==50) echo 'checked';?>>I<br>
		   <input type="radio" name="independence" value="-300" <? if($typel[independence]==-400) echo 'checked';?>>U<br>
		   <input type="radio" name="independence" value="55" <? if($typel[independence]==55) echo 'checked';?>>N</td>
		   <td><textarea cols="35" rows="6" name="text_independence"><? echo $typel[text_independence];?></textarea></td>
		 </tr>
		 		 <tr><td colspan="3" bgcolor="#9966CC"></td></tr>
		 <tr>
		   <td><b>Reporting</b>-The extent of which employee reports for and remain of work as required. </td>
		   <td><input type="radio" name="reporting" value="100"  <? if($typel[reporting]==100) echo 'checked';?>>O<br>
		   <input type="radio" name="reporting" value="90"  <? if($typel[reporting]==90) echo 'checked';?>>V<br>
		   <input type="radio" name="reporting" value="80"  <? if($typel[reporting]==80) echo 'checked';?>>G<br>
		   <input type="radio" name="reporting" value="50"  <? if($typel[reporting]==50) echo 'checked';?>>I<br>
		   <input type="radio" name="reporting" value="-300"  <? if($typel[reporting]==-400 or $typel[productivity]==0) echo 'checked';?>>U<br>
		   <input type="radio" name="reporting" value="55"  <? if($typel[reporting]==55) echo 'checked';?>>N</td>
		   <td><textarea cols="35" rows="6" name="text_reporting"><? echo $typel[text_reporting];?></textarea></td>
		 </tr>
		 <tr><td colspan="3" bgcolor="#9966CC"></td></tr>
		 <tr bgcolor="#eeeeff">
		   <td><b>Teamwork Attitude</b> (as a Member or Leader)-The extent of which employee get along and cooperate with co-workers on the job.</td>
		   <td><input type="radio" name="teamwork" value="100"  <? if($typel[teamwork]==100) echo 'checked';?>>O<br>
		   <input type="radio" name="teamwork" value="90" <? if($typel[teamwork]==90) echo 'checked';?>>V<br>
		   <input type="radio" name="teamwork" value="80" <? if($typel[teamwork]==80) echo 'checked';?>>G<br>
		   <input type="radio" name="teamwork" value="50" <? if($typel[teamwork]==50) echo 'checked';?>>I<br>
		   <input type="radio" name="teamwork" value="-300" <? if($typel[teamwork]==-400) echo 'checked';?>>U<br>
		   <input type="radio" name="teamwork" value="55" <? if($typel[teamwork]==55) echo 'checked';?>>N</td>
		   <td><textarea cols="35" rows="6" name="text_teamwork"><? echo $typel[text_teamwork];?></textarea></td>
		 </tr> -->

	   </table>
	  </td>
	</tr>
	<tr><td colspan="2" bgcolor="#FFFFCC"></td></tr>
	<tr>
	  <td colspan="2">Describe any specific actions employee needs to take to improve job performance:
	    <textarea cols="50" rows="4" name="action"  disabled  ><?php echo $typel[action]; ?></textarea>
	  </td>
	</tr>
	<tr>
	  <td colspan="2">Summarize this employee's overall job performance as determined in your joint discussion<br>
	  	    <textarea cols="50" rows="4" name="summarize"  disabled  ><?php echo $typel[summarize]; ?></textarea>
	  </td>
	</tr>
	<tr><td colspan="2"></td></tr>
	<tr>
	  <td colspan="2">
	     <table>
		   <tr>
			 <td height="50" width="250" valign="top" >
			 <font style="font-size:10px">This report is based on my observation and knowledge of both the employee and the job.</font><br>
			 <u> <? 
			 echo $typel[supervisor];
			 echo $loginFullName;?></u><br>
			 <input type="hidden" name="supervisor" value="<? echo $loginFullName;?>" readonly >	 
			 </td>
			 <td height="50" width="250"  valign="top" >
		<DIV  id=div2 class=visible >
			 <font style="font-size:10px">My signature indicates that I have reviewed this appraisal. It does not mean that I agree with the results.</font><br>
			 Employee:<u> <? echo $typel[name];?></u><br>
			 </DIV>
			 </td>
			 <td height="50" width="200"  valign="top" >HR Representative:<br><? echo $typel[hrsupervisor];?></td>		   
		   </tr>
		 </table>
	  </td>

	 </tr>
<? if($typel[astatus]==0){?>
	 <tr><td colspan="2" align="center">
	  <input type="button" name="save" value="Publish to Web" onClick="location.href='appraisalReport.php?empId=<? echo $empId;?>&appId=<? echo $appId;?>&update=1'">
	  </td></tr>
	  <? }?>
 </table>
<br>


</div>
<div style="position:relative" ><? include('../bottom.php');?></div>
</div>
</body>

</html>
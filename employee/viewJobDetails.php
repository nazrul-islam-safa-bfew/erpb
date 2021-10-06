<? include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT * from `jobdetails` WHERE itemCode='$designation'";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

$typel= mysqli_fetch_array($sqlrunp);
?>

<table align="center" width="600" border="3"  bordercolor="CC9999" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
	<tr bgcolor="#CC9999">
		<td align="right" colspan="2"><font class='englishhead'> Job Description</font></td>
	</tr>
    <tr><td width="200">Designation: </td>
    <td><? echo $typel[itemCode];?></td>
	<tr>
	<td width="200">Job Title </td>
    <td><? echo $typel[jobTitle];?></td>
	</tr>
	<tr>
	<td width="200">Job Level </td>
	<td><? echo $typel[level];?></td>
	</tr>
	<tr>
	<td width="200">Job Summary</td>
	    <td><? echo $typel[summary];?></td>
	</tr>
	<tr>
	<td colspan="2">Job Requirements
	 <table width="100%">
	   <tr>
	     <td width="200"><li>Education</li></td>	    <td><? echo $typel[education];?></td>
	   </tr>
	   <tr>
	     <td width="200"><li>Experience</li></td>	    <td><? echo $typel[experience];?></td>
	   </tr>
	   <tr>
	     <td width="200"><li>Special training</li></td>	    <td><? echo $typel[training];?></td>
	   </tr>
	   <tr>
	     <td width="200" valign="top"><li>Special skills</li></td>	    <td><? echo $typel[skills];?></td>
	   </tr>
	 </table>
	</td>
	</tr>
	   <tr>
	     <td width="200">Authority of incumbent</td>	    <td><? echo $typel[incumbent].' ('. hrDesignation($typel[incumbent]).' )'; ?></td>
	   </tr>
	<tr>
	<td colspan="2">Limits of Authority
	 <table width="100%">
	   <tr>
	     <td width="200"><li>Administrative</li></td>	    <td><? echo $typel[administrative];?></td>
	   </tr>
	   <tr>
	     <td width="200"><li>Financial</li></td>	    <td><? echo $typel[financial];?></td>
	   </tr>
	 </table>
	</td>
	</tr>
   <tr>
	 <td width="200">Standard of Performance</td>	    <td><? echo $typel[performance];?></td>
   </tr>
   <tr>
	 <td width="200">Working condition</td>	    <td><? echo $typel[condition];?></td>
   </tr>
   <tr>
	 <td width="200">Job nature</td>
	 <td>
		<? 

		if($typel[nature]=='Temporary') echo 'Temporary/'; else echo '<strike>Temporary</strike>/';
		   if($typel[nature]=='Part-time')  echo 'Part-time/'; else echo '<strike>Part-time</strike>/';
		   if($typel[nature]=='Project')  echo 'Project/'; else echo '<strike>Project</strike>/';
 		   if($typel[nature]=='Permanent')  echo 'Permanent'; else echo '<strike>Permanent</strike>';
		   ?>
   </td>
   </tr>
	<tr>
	<td colspan="2">Job Duties
	 <table width="100%">
	   <tr>
	     <td width="200"><li>Daily Duties</li></td>	    <td><? echo $typel[dduties];?></td>
	   </tr>
	   <tr>
	     <td width="200"><li>Periodic Duties</li></td>	    <td><? echo $typel[pduties];?></td>
	   </tr>
	   <tr>
	     <td width="200"><li>Duties Performed at Irregular Intervals</li></td>	    <td><? echo $typel[iduties];?></td>
	   </tr>

	 </table>
	</td>
	</tr>	

</table>

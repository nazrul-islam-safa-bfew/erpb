<? include_once("../includes/myFunction1.php");
include("../includes/config.inc.php");
include_once("../includes/myFunction.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$todat=todat();
?>
<html>
<head>

<LINK href="../style/print.css" type=text/css rel=stylesheet>
<meta http-equiv="Content-Language" content="en-us">
<meta name="author" content="<? echo $mauthor;?>">
<meta name="copyright" content="<? echo $tt;?>">
<meta name="keywords" content="<? echo $kword;?>">
<META NAME="description" CONTENT="<? echo $des;?>">
<title>BFEW :: Print IOW</title>
</head>
<body  topmargin="1" leftmargin="5" rightmargin="5" bgcolor="#FFFFFF" >
<div class="dialog">
<table width="500" border="0"  align="left" cellpadding="5" cellspacing="5">
<tr>
 <th><font class="englishheadBlack">Bangladesh Foundry and Engineering Works Ltd.</font></th>
</tr>

</table>
</div>
<br>
<br>
<div class="dialog">
<?
$sql="SELECT * FROM empcv where empId='$empId'";
$sqlq=mysql_query($sql);
$sqlr=mysql_fetch_array($sqlq);
?>

<table width="700" align="center">
<tr>
<td>
	<fieldset class="border"><legend class="englishheadBlue">General</legend>
	<table width="100%" border="0" cellpadding="0" cellspacing="5" style="border-collapse:collapse">
		<tr>
		<td>Name</td><td><input type="text" name="empName" size="50" maxlength="200" value="<? echo $sqlr[empName];?>" ></td>
		<td rowspan="4"><img width="150px" height="150px" src="../employee/empPhoto/<? echo "$empId.jpg";?>"></td>
		</tr>
		<tr>
		<td>Father's Name</td><td><input type="text" name="empFName" size="50" maxlength="200"  value="<? echo $sqlr[empFName];?>"></td>		
		</tr>
		<tr>
		<td>Mother's Name</td><td><input type="text" name="empMName" size="50" maxlength="200"  value="<? echo $sqlr[empMName];?>"></td>		
		</tr>
		<tr>
		<td>Permanent Address</td><td><input type="text"  name="empPaddress" size="50" maxlength="200"  value="<? echo $sqlr[empPaddress];?>"></td>		
		</tr>
		<tr>
		<td>Current Address</td>
		<td><input type="text" name="empCaddress" size="50" maxlength="200" value="<? echo $sqlr[empCaddress];?>"></td>		
		</tr>
		
	</table>

</fieldset>
<br>
<br>
	<fieldset class="border"><legend class="englishheadBlue">Education</legend>
	<table width="100%" border="0" cellpadding="0" cellspacing="5" style="border-collapse:collapse">
		<tr>
		<th align="left">Degree Achieved</th>
		<th>Education Institute</th>
		<th>Result</th>
		<th align="right">Year</th>
		</tr>
<?
$sql="SELECT * FROM empedu where empId='$empId'";
$sqlq=mysql_query($sql);
$sqlre=mysql_fetch_array($sqlq);
?>		
	<tr>
	<td align="left" ><input type="text" name="degreeAchieved1" value="<? echo $sqlre[degreeAchieved];?>"></td>
	<td align="center"><input type="text" name="degreeInstitute1" size="50" maxlength="200" value="<? echo $sqlre[degreeInstitute];?>"></td>
	<td align="center"><input type="text" name="degreeResult1" size="4" maxlength="4" value="<? echo $sqlre[degreeResult];?>"></td>
	<td align="right"><input type="text" name="degreeYear1" size="4" maxlength="4" value="<? echo $sqlre[degreeYear];?>"></td>
	</tr>
	<tr>
<? $sqlre=mysql_fetch_array($sqlq);?>		
	<tr>
	<td align="left" ><input type="text" name="degreeAchieved2" value="<? echo $sqlre[degreeAchieved];?>"></td>
	<td align="center"><input type="text" name="degreeInstitute2" size="50" maxlength="200" value="<? echo $sqlre[degreeInstitute];?>"></td>
	<td align="center"><input type="text" name="degreeResult2" size="4" maxlength="4" value="<? echo $sqlre[degreeResult];?>"></td>
	<td align="right"><input type="text" name="degreeYear2" size="4" maxlength="4" value="<? echo $sqlre[degreeYear];?>"></td>
	</tr>
<? $sqlre=mysql_fetch_array($sqlq);?>		
	<tr>
	<td align="left" ><input type="text" name="degreeAchieved3" value="<? echo $sqlre[degreeAchieved];?>"></td>
	<td align="center"><input type="text" name="degreeInstitute3" size="50" maxlength="200" value="<? echo $sqlre[degreeInstitute];?>"></td>
	<td align="center"><input type="text" name="degreeResult3" size="4" maxlength="4" value="<? echo $sqlre[degreeResult];?>"></td>
	<td align="right"><input type="text" name="degreeYear3" size="4" maxlength="4" value="<? echo $sqlre[degreeYear];?>"></td>
	</tr>
	
</table>
</fieldset>
<br>
<br>

<fieldset class="border"><legend class="englishheadBlue">Experience</legend>
<?
$sql="SELECT * FROM empexp where empId='$empId'";
$sqlq=mysql_query($sql);
$sqlrex=mysql_fetch_array($sqlq);
?>		

<table width="100%" border="0" cellpadding="0" cellspacing="5" style="border-collapse:collapse">
	<tr>
		<td>Company</td>
		<td><input type="text" name="expcompany1" size="50" maxlength="200" value="<? echo $sqlrex[expcompany];?>"> </td>
	</tr>
		<tr><td>Position</td>
		<td ><input type="text" name="expposition1" size="50" maxlength="200" value="<? echo $sqlrex[expposition];?>"> </td>
	</tr>
	<tr>
		<td>From to </td>
		<td ><input type="text" name="expFromto1" size="50" maxlength="200" value="<? echo $sqlrex[expFromto];?>"> </td>
	</tr>
	<tr>
		<td>Job Responsibilities</td>
		<td ><input type="text" name="expJobRes1" size="50" maxlength="200" value="<? echo $sqlrex[expJobRes];?>"> </td>
	</tr>
<? $sqlre=mysql_fetch_array($sqlq);?> 
 	<tr>
		<td>Company</td>
		<td><input type="text" name="expcompany2" size="50" maxlength="200" value="<? echo $sqlrex[expcompany];?>"> </td>
	</tr>
		<tr><td>Position</td>
		<td ><input type="text" name="expposition2" size="50" maxlength="200" value="<? echo $sqlrex[expposition];?>"> </td>
	</tr>
	<tr>
		<td>From to </td>
		<td ><input type="text" name="expFromto2" size="50" maxlength="200" value="<? echo $sqlrex[expFromto];?>"> </td>
	</tr>
	<tr>
		<td>Job Responsibilities</td>
		<td ><input type="text" name="expJobRes2" size="50" maxlength="200" value="<? echo $sqlrex[expJobRes];?>"> </td>
	</tr>
 <tr><td colspan="2" ><br><br></td></tr>
<? $sqlre=mysql_fetch_array($sqlq);?> 
 	<tr>
		<td>Company</td>
		<td><input type="text" name="expcompany3" size="50" maxlength="200" value="<? echo $sqlrex[expcompany];?>"> </td>
	</tr>
		<tr><td>Position</td>
		<td ><input type="text" name="expposition3" size="50" maxlength="200" value="<? echo $sqlrex[expposition];?>"> </td>
	</tr>
	<tr>
		<td>From to </td>
		<td ><input type="text" name="expFromto3" size="50" maxlength="200" value="<? echo $sqlrex[expFromto];?>"> </td>
	</tr>
	<tr>
		<td>Job Responsibilities</td>
		<td ><input type="text" name="expJobRes3" size="50" maxlength="200" value="<? echo $sqlrex[expJobRes];?>"> </td>
	</tr>
<? $sqlre=mysql_fetch_array($sqlq);?> 
 	<tr>
		<td>Company</td>
		<td><input type="text" name="expcompany2" size="50" maxlength="200" value="<? echo $sqlrex[expcompany];?>"> </td>
	</tr>
		<tr><td>Position</td>
		<td ><input type="text" name="expposition2" size="50" maxlength="200" value="<? echo $sqlrex[expposition];?>"> </td>
	</tr>
	<tr>
		<td>From to </td>
		<td ><input type="text" name="expFromto2" size="50" maxlength="200" value="<? echo $sqlrex[expFromto];?>"> </td>
	</tr>
	<tr>
		<td>Job Responsibilities</td>
		<td ><input type="text" name="expJobRes2" size="50" maxlength="200" value="<? echo $sqlrex[expJobRes];?>"> </td>
	</tr>
 <tr><td colspan="2" ><br><br></td></tr>
<? $sqlre=mysql_fetch_array($sqlq);?> 
 	<tr>
		<td>Company</td>
		<td><input type="text" name="expcompany3" size="50" maxlength="200" value="<? echo $sqlrex[expcompany];?>"> </td>
	</tr>
		<tr><td>Position</td>
		<td ><input type="text" name="expposition3" size="50" maxlength="200" value="<? echo $sqlrex[expposition];?>"> </td>
	</tr>
	<tr>
		<td>From to </td>
		<td ><input type="text" name="expFromto3" size="50" maxlength="200" value="<? echo $sqlrex[expFromto];?>"> </td>
	</tr>
	<tr>
		<td>Job Responsibilities</td>
		<td ><input type="text" name="expJobRes3" size="50" maxlength="200" value="<? echo $sqlrex[expJobRes];?>"> </td>
	</tr>
	
	</table>
</fieldset>
<br>
<br>

<fieldset class="border"><legend class="englishheadBlue">Others</legend>
	<table width="100%" border="0" cellpadding="0" cellspacing="5" style="border-collapse:collapse">
		<tr>
		<td>Extra Curriculum activities:</td>
		<td><input type="text" name="othersextra" size="50" maxlength="200" value="<? echo $sqlr[othersextra];?>"  ></td>
		</tr>
		<tr>
		<td>Awards achieved</td>
		<td><input type="text" name="othersAward" size="50" maxlength="200" value="<? echo $sqlr[othersAward];?>"  ></td>
		</tr>
		<tr>
		<td>Other Skills</td>
		<td><input type="text" name="othersSkill" size="50" maxlength="200" value="<? echo $sqlr[othersSkill];?>"  ></td>
		</tr>
		<tr>
		<td>Hobbies</td><td><input type="text"  name="othersHobbie" size="50" maxlength="200" value="<? echo $sqlr[othersHobbie];?>"  ></td>
		</tr>
		<tr>
		<td>Reference 1</td>
		<td><input type="text" name="otherRef1" size="50" maxlength="200" value="<? echo $sqlr[otherRef1];?>"  ></td>
		</tr>
		<tr>
		<td>Reference 2</td>
		<td><input type="text" name="otherRef2" size="50" maxlength="200" value="<? echo $sqlr[otherRef2];?>"  ></td>
		</tr>
		<tr>
		<td>Guarantor
(Applicable for the post of Cashier)
</td><td><input type="text" name="otherGuarantor" size="50" maxlength="200" value="<? echo $sqlr[otherGuarantor];?>"  ></td>
		</tr>
		
	</table>
</fieldset>
<br>
<br>
</td>
</tr>
</table>
<br>


</p>

</div>

 <br>
  <br>
<? include('../bottom.php');?>
</body>

</html>

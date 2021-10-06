<?
$sql="SELECT * FROM empcv where empId='$empId'";
$sqlq=mysqli_query($db, $sql);
$sqlr=mysqli_fetch_array($sqlq);
?>
<form name="frmCV" enctype="multipart/form-data" action="./employee/empCV.sql.php?empId=<? echo $empId;?>" method="post">
<table width="700" align="center">
<tr>
<td>
	<fieldset class="border"><legend class="englishheadBlue">General</legend>
	<table width="100%" border="0" cellpadding="0" cellspacing="5" style="border-collapse:collapse">
		<tr>
		<td>Name</td><td><input type="text" name="empName" size="50" maxlength="200" value="<? echo $sqlr[empName];?>" ></td>
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
$sqlq=mysqli_query($db, $sql);
$sqlre=mysqli_fetch_array($sqlq);
?>		
	<tr>
	<td align="left" ><input type="text" name="degreeAchieved1" value="<? echo $sqlre[degreeAchieved];?>"></td>
	<td align="center"><input type="text" name="degreeInstitute1" size="50" maxlength="200" value="<? echo $sqlre[degreeInstitute];?>"></td>
	<td align="center"><input type="text" name="degreeResult1" size="4" maxlength="4" value="<? echo $sqlre[degreeResult];?>"></td>
	<td align="right"><input type="text" name="degreeYear1" size="4" maxlength="4" value="<? echo $sqlre[degreeYear];?>"></td>
	</tr>
	<tr>
<? $sqlre=mysqli_fetch_array($sqlq);?>		
	<tr>
	<td align="left" ><input type="text" name="degreeAchieved2" value="<? echo $sqlre[degreeAchieved];?>"></td>
	<td align="center"><input type="text" name="degreeInstitute2" size="50" maxlength="200" value="<? echo $sqlre[degreeInstitute];?>"></td>
	<td align="center"><input type="text" name="degreeResult2" size="4" maxlength="4" value="<? echo $sqlre[degreeResult];?>"></td>
	<td align="right"><input type="text" name="degreeYear2" size="4" maxlength="4" value="<? echo $sqlre[degreeYear];?>"></td>
	</tr>
<? $sqlre=mysqli_fetch_array($sqlq);?>		
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
$sqlq=mysqli_query($db, $sql);
$sqlrex=mysqli_fetch_array($sqlq);
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
 <tr><td colspan="2" ><br><br></td></tr>
<? $sqlre=mysqli_fetch_array($sqlq);?> 
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
<? $sqlre=mysqli_fetch_array($sqlq);?> 
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

<fieldset class="border"><legend class="englishheadBlue">PhotoGraph</legend>
	<table width="100%" border="0" cellpadding="0" cellspacing="5" style="border-collapse:collapse">
		<tr>
		<td>Upload Photo</td><td><input type="file" name="empPhoto"></td>
		</tr>

		
	</table>
</fieldset>

</td>
</tr>
</table>
<br>
<p align="center"><input type="button" name="saveCV" value="Save" onClick="frmCV.submit();">

</p>
</form>	

<a target="_blank" href="./print/print_empCV.php?empId=<? echo $empId;?>">Print</a>
<? 
if($e==1){
	include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT * from `jobdetails` WHERE itemCode='$itemCode'";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
$app= mysqli_fetch_array($sqlrunp);
}
?>
<form name="job" action="./employee/createJob.sql.php" method="post">
<table align="center" width="95%" border="3"  bordercolor="CC9999" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
	<tr bgcolor="#CC9999">
		<td align="right" colspan="2"><font class='englishhead'> Job Description</font></td>
	</tr>
    <tr><td width="200">Designation: </td>
<? if($e==1){?>
    <td >
<select name='itemCode' onChange="location.href='index.php?keyword=create+job&e=1&itemCode='+job.itemCode.options[document.job.itemCode.selectedIndex].value";>
<option value=''>Select One</option>
	
<? 	include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT * from `itemlist` WHERE itemCode BETWEEN '71-00-000' AND '96-99-999'";

//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);


 while($typel= mysqli_fetch_array($sqlrunp))
{
 echo  "<option value='".$typel[itemCode]."'";
 if($itemCode==$typel[itemCode]) { echo " SELECTED"; $designation=$typel[itemDes];}
 echo ">$typel[itemCode]--$typel[itemDes]</option>  ";
 }
  ?>
</select>
	</td>
<? }//if e==1
 else{
?>	
    <td><input type="text" size="3" maxlength="2" name="itemCode1">-<input type="text" size="3" maxlength="2" name="itemCode2">-000 	</td>
	<? }//else ?>
	</tr>
	<tr>
	<td width="200">Job Title </td>
	<td><input type="text" size="50" name="jobTitle" value="<? echo $designation;?>"></td>
	</tr>
	<tr>
	<td width="200">Job Level </td>
	<td>
	<select name="level">
		<option <? if($app[level]=='Level 1') echo ' selected';?>>Level 1</option>
		<option <? if($app[level]=='Level 2') echo ' selected';?>>Level 2</option>	
		<option <? if($app[level]=='Level 3') echo ' selected';?>>Level 3</option>
		<option <? if($app[level]=='Level 4') echo ' selected';?>>Level 4</option>	
		<option <? if($app[level]=='Level 5') echo ' selected';?>>Level 5</option>
		<option <? if($app[level]=='Level 6') echo ' selected';?>>Level 6</option>	
		<option <? if($app[level]=='Level 7') echo ' selected';?>>Level 7</option>
		<option <? if($app[level]=='Level 8') echo ' selected';?>>Level 8</option>
	</select>
</td>
	</tr>
	<tr>
	<td width="200" valign="top">Job Summary</td>
    <td><textarea cols="110" rows="7" name="summary"	><? echo $app[summary];?></textarea></td>
	</tr>
	<tr>
	<td colspan="2" >Job Duties
	 <table width="100%">
	   <tr>
	     <td width="200" valign="top"><li>Job Tasks</li></td>	<td><textarea  cols="110" rows="7" name="dduties"><? echo $app[dduties];?></textarea></td>
	   </tr>
	   <tr>
	     <td width="200" valign="top"><li>Job Activities</li></td><td><textarea  cols="110" rows="7" name="pduties"><? echo $app[pduties];?></textarea></td>
	   </tr>

	 </table>
	</td>
	</tr>	
	
	<tr>
	<td colspan="2">Job Requirements
	 <table width="100%">
	   <tr>
	     <td width="200" valign="top"><li>Education</li></td>	<td><textarea  cols="110" rows="3" name="education"><? echo $app[education];?></textarea></td>
	   </tr>
	   <tr>
	     <td width="200" valign="top"><li>Experience</li></td>	<td><textarea  cols="110" rows="7" name="experience"><? echo $app[experience];?></textarea></td>
	   </tr>
	   <tr>
	     <td width="200" valign="top"><li>Knowledge</li></td>	<td><textarea  cols="110" rows="7" name="training"><? echo $app[training];?></textarea></td>
	   </tr>
	   <tr>
	     <td width="200" valign="top"><li>Skills</li></td><td><textarea  cols="110" rows="7" name="skill"><? echo $app[skill];?></textarea></td>
	   </tr>
	   <tr>
	     <td width="200" valign="top"><li>Ability</li></td><td><textarea  cols="110" rows="7" name="ability"><? echo $app[ability];?></textarea></td>
	   </tr>

	 </table>
	</td>
	</tr>
	   <tr>
	     <td width="200">Authority of incumbent</td>		 
		     <td >
				<select name='incumbent' >
				<? 
				include("./includes/config.inc.php");
				$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
					
					$lev=explode(' ',$app[level]);
					$level = $lev[1]-1;
					$level="Level $level";
				$sqlp = "SELECT * from `jobdetails` WHERE level LIKE '$level'";
				
				
				$sqlrunp= mysqli_query($db, $sqlp);
								
				 while($typel= mysqli_fetch_array($sqlrunp))
				{
				 echo  "<option value='".$typel[itemCode]."'";
				 if($typel[itemCode]==$app[incumbent]) { echo " SELECTED";}
				 echo ">$typel[itemCode]--$typel[jobTitle]</option>  ";
				 }
				  ?>
				</select>
        <? //echo $sqlp;?> </td>

	   </tr>
	<tr>
	<td colspan="2">Limits of Authority
	 <table width="100%">
	   <tr>
	     <td width="200" valign="top"><li>Administrative</li></td><td><textarea cols="110" rows="3" name="administrative"><? echo $app[administrative];?></textarea></td>
	   </tr>
	   <tr>
	     <td width="200" valign="top"><li>Financial</li></td><td><textarea cols="110" rows="3" name="financial"><? echo $app[financial];?></textarea></td>
	   </tr>
	 </table>
	</td>
	</tr>
   <tr>
	 <td width="200" valign="top">Standard of Performance</td><td><textarea  cols="110" rows="7" name="performance"><? echo $app[performance];?></textarea></td>
   </tr>
   <tr>
	 <td width="200" valign="top">Working condition</td><td><textarea  cols="110" rows="3" name="conditions"><? echo $app[conditions];?></textarea></td>
   </tr>
   <tr>
	 <td width="200" valign="top">Job nature</td>
	 <td>
	 <? if($app[nature]=='') $ck1=' checked';
	 else if($app[nature]=='Temporary') $ck1=' checked';
	  else  if($app[nature]=='Part-time') $ck2=' checked';
	    else if($app[nature]=='Project') $ck3=' checked';
		  else if($app[nature]=='Permanent') $ck4=' checked';
	 ?>
	 <input type="radio" name="nature" value="Temporary" <?  echo $ck1;?>  >Temporary 
	 <input type="radio" name="nature" value="Part-time" <?  echo $ck2;?>>Part-time
	 <input type="radio" name="nature" value="Project" <?  echo $ck3;?>>Project
	 <input type="radio" name="nature" value="Permanent" <?  echo $ck4;?>>Permanent</td>
   </tr>
	<!--<tr>
	 <td colspan="2"><br>
	 <table width="95%">
	   <tr> <td width="200">Starting Basic</td><td><input name="startingBasic" value="<? echo $app[startingBasic];?>" type="text" width="10" size="10"> Tk. per Month</td> </tr>
	   <tr> <td>House Rent</td><td><input name="houseRent" value='<? echo $app[houseRent];?>' type="text" width="3" size="10" maxlength="3"> % of Basic per Month</td> </tr>
	   <tr> <td>Medical</td><td><input name="medical" value="<? echo $app[medical];?>" type="text" width="3" size="10" maxlength="3"> % of Basic per Month</td> </tr>
	   <tr> <td>Convence</td><td><input name="convence" value="<? echo $app[convence];?>" type="text" width="3" size="10" maxlength="3"> % of Basic per Month</td> </tr>	   	  
	   <tr> <td>Provident Fund Deduction</td><td><input name="proFund" value="<? echo $app[proFund];?>" type="text" width="3" size="10" maxlength="3"> % of Basic per Month</td> </tr>
	   <tr> <td>Increment</td><td><input name="increment" value="<? echo $app[increment];?>" type="text" width="10" size="10"> Tk. per Increment</td> </tr>	   	  	 
	   <tr> <td>Maximum Increment</td><td> <input name="maxIncrement" value="<? echo $app[maxIncrement];?>" type="text" width="10" size="10"> numbers</td> </tr>	   	  	     	  	   
	 </table>
	 </td>
	</tr>-->
	<tr><td colspan="2" align="center"><input type="button" value="Save" name="save"  onClick="job.submit();"></td></tr>
</table>
</form>
<a target="_blank" href="./print/print_createJob.php?designation=<? echo $itemCode;?>">Print</a>
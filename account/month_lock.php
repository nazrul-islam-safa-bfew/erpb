<form name="form1" method="post" action="" style="border:1px #CCCCCC solid; margin:0px auto; margin-top:50px; width:500px;">
	<table border="0" align="center">
	<tr>
		<th style="background:#6C6CFF; color:#fff; height:30px;" colspan="2">
			BFEW | ACCOUNTS LOCKER
		</th>
	</tr>
	<tr>
		<td>
		</td>
		<td>
		</td>
	</tr>
		<tr>
			
			<td>
				<label>Project</label>
			</td>
			
			<td>
				<p>
					<select name="pcode" id="pcode">
						<?php
							 	$pcode=$_GET['pcode'];
							 	$year=$_GET['year'];
								
								include("./includes/config.inc.php");
								$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
								
								$sqlp = "SELECT `pcode`,pname from `project` ORDER by pcode ASC";
								//echo $sqlp;
								$sqlrunp= mysqli_query($db, $sqlp);
								 while($typel= mysqli_fetch_array($sqlrunp))
								{
									 echo "<option value='".$typel[pcode]."'";
									 if($pcode==$typel[pcode])  echo " SELECTED";
									 echo ">$typel[pcode]--$typel[pname]</option>";
								}
								 
								 //locking code
									
								
									$jan=$_POST['jan'];
									$feb=$_POST['feb'];
									$mar=$_POST['mar'];
									$apr=$_POST['apr'];
									$may=$_POST['may'];
									$jun=$_POST['jun'];
									$jul=$_POST['jul'];
									$aug=$_POST['aug'];
									$sep=$_POST['sep'];
									$oct=$_POST['oct'];
									$nov=$_POST['nov'];
									$dec=$_POST['dec'];
								
								 if($_POST['save']=='SAVE'){
								 	mysqli_query($db, "select * from account_locker where pcode='$pcode' and l_year='$year'");
									if(mysqli_affected_rows($db)==0)
									{
								 		 $sql="INSERT INTO `account_locker` (
																			`pcode` ,
																			`l_year` ,
																			`ja` ,
																			`feb` ,
																			`mar` ,
																			`apr` ,
																			`may` ,
																			`jun` ,
																			`jul` ,
																			`aug` ,
																			`sep` ,
																			`oct` ,
																			`nov` ,
																			`dec`
																			)
																			VALUES (
																			 '$pcode',  '$year',  '$jan',  '$feb',  '$mar',  '$apr',  '$may',  '$jun',  '$jul',  '$aug',  '$sep',  '$oct',  '$nov',  '$dec')";

								

								 	}//end of insert
									else{
									 $sql="update `account_locker` set `ja`='$jan' ,
																				`feb`='$feb',
																				`mar`='$mar',
																				`apr`='$apr',
																				`may`='$may',
																				`jun`='$jun',
																				`jul`='$jul',
																				`aug`='$aug',
																				`sep`='$sep',
																				`oct`='$oct',
																				`nov`='$nov',
																				`dec`='$dec'
																				 where pcode='$pcode' and l_year='$year'";
									}//end of update									
									mysqli_query($db, $sql);	
								
								 
								} // end of locking code
									
									$all_selected_month_sql="select * from account_locker where pcode='$pcode' and l_year='$year'";
									$all_selected_month_query=mysqli_query($db, $all_selected_month_sql);
									$all_selected_month_row=mysqli_fetch_array($all_selected_month_query);
								 // end of checkbox selector code
						?>
					</select>
				</p>
			</td>
		</tr>
		<tr>	
			<td>
				<label>Year</label>
			</td>
	<td>
		<p>
			<select name="year" onchange="location.href='./index.php?keyword=accounts+locker&pcode='+document.getElementById('pcode').value+'&year='+this.value;">
				<option value="2012" <?php if($year=='2012')echo ' selected="selected"'; ?>>2012</option>
				<option value="2013" <?php if($year=='2013')echo ' selected="selected"' ?>>2013</option>
				<option value="2014" <?php if($year=='2014')echo ' selected="selected"' ?>>2014</option>
				<option value="2015" <?php if($year=='2015')echo ' selected="selected"' ?>>2015</option>
				<option value="2016" <?php if($year=='2016')echo ' selected="selected"'; ?>>2016</option>
				<option value="2017" <?php if($year=='2017')echo ' selected="selected"'; ?>>2017</option>
			</select>
		</p>
	</td>
</tr>

<tr>
	<td>
			<p>Month</p>
	</td>
	<td>

		<p>
				<input type="checkbox" value="01" name="jan" <?php if($all_selected_month_row[3])echo "checked"; ?> /> <label>Janury</label> |
				<input type="checkbox" value="02" name="feb" <?php if($all_selected_month_row[4])echo "checked"; ?> /><label>February</label> |
				<input type="checkbox" value="03" name="mar" <?php if($all_selected_month_row[5])echo "checked"; ?> /><label>March</label> |
				<input type="checkbox" value="04" name="apr" <?php if($all_selected_month_row[6])echo "checked"; ?> /><label>April</label> |<br /><br />


				<input type="checkbox" value="05" name="may" <?php if($all_selected_month_row[7])echo "checked"; ?> /><label>May</label> |
				<input type="checkbox" value="06" name="jun" <?php if($all_selected_month_row[8])echo "checked"; ?> /> <label>June</label> |
				<input type="checkbox" value="07" name="jul" <?php if($all_selected_month_row[9])echo "checked"; ?> /><label>July</label> |
				<input type="checkbox" value="08" name="aug" <?php if($all_selected_month_row[10])echo "checked"; ?> /><label>August</label> |<br /><br />


				<input type="checkbox" value="09" name="sep" <?php if($all_selected_month_row[11])echo "checked"; ?> /><label>September</label> |
				<input type="checkbox" value="10" name="oct" <?php if($all_selected_month_row[12])echo "checked"; ?> /><label>October</label> |
				<input type="checkbox" value="11" name="nov" <?php if($all_selected_month_row[13])echo "checked"; ?> /><label>November</label> |
				<input type="checkbox" value="12" name="dec" <?php if($all_selected_month_row[14])echo "checked"; ?> /><label>December</label>
		</p>
	</td>
</tr>
<tr>
	<td>
		<p><input type="submit" value="SAVE" name="save"/></p>
	</td>
</tr>	
	</table>
	
</form>

<?php



?>
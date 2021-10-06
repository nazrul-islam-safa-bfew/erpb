<form>
  <p align="center">
  
    <label>
      <input type="radio" name="1" value="1" id="11" onclick="show_that(1);"  />
      Add New Lander</label>
    <br />
    <br />
    <label>
      <input type="radio" name="1" value="2" id="12" onclick="show_that(2);"/>
      Delete Lander</label>
    <br />
  </p>
</form>


<?
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
if($landerName){
  $sql="INSERT INTO `lander` (`id`, `landerName`,accountId) VALUES ('', '$landerName','$accountId')";
  $adduserdb = mysqli_query($db, $sql);
  //echo $sql;
  echo "lander ADD..";
}

if($_POST['landeraccountId'])
{
	$landeraccountId=$_POST['landeraccountId'];
	//echo $del_sql="";
	mysqli_query($db, "delete from lander where id='$landeraccountId'");
				if(mysqli_affected_rows($db)>0)
				 	echo "Lander Deleted.";
				else
					echo "Error 404! Lander is not found.";
}

//signup ends

//echo " <meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../member/redirect.php?usern=$un&password=$password\">";
?>
<form name="cerateUser" action="<? $PHP_SELF;?>" method="post" id="add_lander">
<table align="center"  class="dblue">
<tr>
    <td colspan="2" align="center" bgcolor="#E4E4E4" class="englishheadBlack"> Create New Lander</td>
</tr>	
<tr>
    <td > Lander Name</td> <td ><input name="landerName" type="text"  maxlength="100" ></td>
</tr>	
<tr>
<td>type</td>
<td><select name='accountId'>
<?  

	$sqlp = "SELECT * from `accounts` WHERE accountType IN('12')";
	//echo $sqlp;
	$sqlrunp= mysqli_query($db, $sqlp);
	while($typel= mysqli_fetch_array($sqlrunp))
	{
	echo  "<option value='".$typel[accountID]."'";
	echo  ">$typel[accountID]-$typel[description]</option>";
	}//while1
?>
</select>
</td></tr>
<tr>
<td colspan="2" align="center"><input type="submit" name="createNewUser" value="Create New Lander"></td>
</tr>	
</table>
</form>	
<form name="deleteUser" action="<? $PHP_SELF;?>" method="post" id="delete_lander">
<table align="center"  class="dblue">
<tr>
    <td colspan="2" align="center" bgcolor="#E4E4E4" class="englishheadBlack"> Delete Lander</td>
</tr>	
<tr>
    <td> Lander Id</td> <td ><select name='landeraccountId'>
<?  
 	$sqlp = "SELECT * from `accounts` WHERE accountType IN('12')  order by accountId ASC";
	//echo $sqlp;
	$sqlrunp= mysqli_query($db, $sqlp);
	while($typel= mysqli_fetch_array($sqlrunp))
	{
		$sqlp2 = "SELECT * from `lander` where accountId='$typel[accountID]' order by landerName ASC";
		//echo $sqlp;
		$sqlrunp2= mysqli_query($db, $sqlp2);
		while($typel2= mysqli_fetch_array($sqlrunp2))
		{
			$sql_2nd="select * from `ex130` WHERE (paymentSL LIKE 'ct_%' OR paymentSL LIKE 'CT_%') AND (exgl LIKE '$typel2[accountId]-$typel2[id]' OR account LIKE '$typel2[accountId]-$typel2[id]') order by exDate ASC";
			$res_2nd=mysqli_query($db, $sql_2nd);
			
			if(mysqli_fetch_row($res_2nd)<=0)
			{
		echo  "<option name='landeraccountId' value='".$typel2[id]."'";
		if($account=="$typel2[accountId]-$typel2[id]")  echo  " SELECTED";
		echo  ">$typel2[accountId]-$typel2[id]-$typel[description]-$typel2[landerName]</option>";
		}}//while2
	}//while1
?>
</select>
</td></tr>
<tr>
<td colspan="2" align="center"><input type="submit" name="createNewUser" value="Delete Lander"></td>
</tr>	
</table>
</form>	

<script type="text/javascript">

	function show_that(get_val)
	{
		document.getElementById("delete_lander").style.display="none";	
		document.getElementById("add_lander").style.display="none";
		if(get_val==1)
		{
			document.getElementById("add_lander").style.display="list-item";
		}
		else
			document.getElementById("delete_lander").style.display="list-item";
	}
	document.getElementById("delete_lander").style.display="none";	
		document.getElementById("add_lander").style.display="none";
			
</script>


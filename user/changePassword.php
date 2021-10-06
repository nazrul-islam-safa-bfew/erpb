<html>
<title> BFEW:: Change Password</title>
<body>

<? 
// die()
if($_POST[changePass] and $_POST[uname] and $_POST[password])
{
	include("../includes/myFunction.php");
	include("../includes/config.inc.php");
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS ,$SESS_DBNAME);

	$user = $_POST[uname];
	$password = $_POST[password];

	$sql1="SELECT * From user WHERE uname='$uname' AND password='$password'";

	$sqlQur1=mysqli_query($db, $sql1);
	$sqlresult=mysqli_fetch_array($sqlQur1);
	$dbpassword=$sqlresult[password];

	if($npassword1==$npassword2 AND $password=$dbpassword )
	{
		$sqlUp= "UPDATE `user` SET `password`='$npassword1' WHERE uname='$uname'";
		$sqlQurup=mysqli_query($db, $sqlUp);
		echo okMsg("your record is updating....<br> Please login in with new password [ $npassword1 ]");
		echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php\">";
	}
	else {
		$changePass='';
		echo wornMsg('Your given password doesn\'t match.');
	}
}
?>

<? if($changePass==''){?>
	<form name="cerateUser" action="./changePassword.php" method="post">
		<table align="center" width="600" border="1"  bordercolor="#E4E4E4" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
			<tr>
				<td colspan="2" align="center" bgcolor="#EEEEEE"><b> Edit User</b></td>
			</tr>	
			<tr>
				<td >User Name</td> <td><input name="uname" type="text" maxlength="20" value=""></td>
			</tr>	

			<tr>
				<td > Old Password</td> <td><input name="password" type="password" maxlength="20" value=""></td>
			</tr>	

			<tr>
				<td > New Password</td> <td><input name="npassword1" type="password" maxlength="20" value=""></td>
			</tr>	
			<tr>
				<td > Confirm Password</td> <td><input name="npassword2" type="password" maxlength="20" value=""></td>
			</tr>	

			<tr>
				<td colspan="2" align="center"><input type="submit" name="changePass" value="Change Password">
					<input type="hidden" name="loginUname" value="<? echo $loginUname;?>">
				</td>
			</tr>	

		</table>
	</form>	
	<? }//$loginUname='';?>
</body>
</html>

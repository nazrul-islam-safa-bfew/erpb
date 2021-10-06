<?
if($_POST['submit'])
{
session_start();

$_SESSION["loginUname"]="as";$_SESSION["loginUid"]=$_POST["uid"];$_SESSION["loginDesignation"]=$_POST["deg"];
$_SESSION["loginProject"]=$_POST["logProj"];$_SESSION["loginFullName"]="sdsd";$_SESSION["loginProjectName"]="";

session_register("loginUname");
session_register("loginUid");
session_register("loginDesignation");
session_register("loginProject");
//echo session_id();
session_register("loginFullName");
session_register("loginProjectName");
//echo $_SESSION["loginFullName"];
header("Location: index.php");
}
?>
<form method="post">
	<input name="uid" value="2121" />
	<input name="deg" value="Manager Planning & Control" />
	<input name="logProj" value="000" />
	<input type="submit" name="submit" />
</form>
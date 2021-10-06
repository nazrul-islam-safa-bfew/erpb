<?
error_reporting(1);
session_start();
include('../includes/config.inc.php');
include('../includes/session.inc.php');
?>

<?

if($_POST['un'] AND $_POST['up'])
	{
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS ,$SESS_DBNAME);
	
	echo mysqli_connect_error();
	$un = ($_POST['un']);
	$up = ($_POST['up']);
	
	 $result = mysqli_query($db, "SELECT *  FROM user where uname=\"$un\"");
	//echo "SELECT user.*,project.*  FROM user,project where uname=\"$un\" AND project.pcode=user.projectCode ";
	 //exit;
 //mysqli_affected_rows();
	$myrow = mysqli_fetch_array($result);
	//	print_r($up."//".$myrow['password']);
	
	
	//echo $myrow[uname];
	if($myrow['password']!=$up)
		{
		echo "<table width=400 align=center border=1 cellspacing=0 cellpading=0 style='border-collapse: collapse' bordercolor=#FF0000><tr><td background=../images/tbl_error.png><font color=#FFFFFF> ERROR</font></td>".
"</tr>".
"<tr><td>$usern<br>".
"<p><font face=Verdana size=1 color=red><b> Please enter your proper login,<br> may be password is not Correct?</font><b><p>";
"</td>".
"</tr>".
"</table>";
echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php\">";

		exit();
		}
	else
		{
		$_SESSION['loginUname']=$myrow['uname'];
		$_SESSION['loginUid']=$myrow['id'];
		$_SESSION['loginDesignation']=$myrow['designation'];
		$_SESSION['loginProject']=$myrow['projectCode'];
		$_SESSION['loginFullName']=$myrow['fullName'];
		$_SESSION['loginProjectName']=$myrow['pname'];

	echo " Login Success.. <br>Collecting User Information.. Please wait...";
/*	if($loginDesignation=='Project Accountant'){	$keyword_go= "..index.php?keyword=spr+NIOW";}
	else if($loginDesignation=='Store Manager'){	$keyword_go= "../index.php?keyword=store+entry";}
	else if($loginDesignation=='Manager Planning & Control'){	$keyword_go= "../index.php?keyword=pmview+IOW&status=Raised+by+PM";}
	//else if($loginDesignation=='Managing Director'){	$keyword_go= "../index.php?keyword=mdview+IOW&status=Forward+to+MD";}
	else if($loginDesignation=='Accounts Manager'){	$keyword_go= "../index.php?keyword=cash+disbursment";}
	//else if($loginDesignation=='Purchase Manager'){	$keyword_go= "../index.php?keyword=rate+DMA";}
	else if($loginDesignation=='Human Resource Manager'){	$keyword_go= "../index.php?keyword=employee+entry";}
	else if($loginDesignation=='Task Supervisor')	{	$keyword_go= "../index.php?keyword=task+daily+report";}
	else 	$keyword_go= "../index.php";
	//echo $keyword_go;
	*/
	if($loginDesignation=='Task Supervisor')	{	$keyword_go= "../index.php?keyword=task+daily+report";}	
	  else $keyword_go= "../index.php";
	echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=$keyword_go\">";
    }
}//first if
else
{
echo "<table align=center border=1 cellspacing=0 cellpading=0 style='border-collapse: collapse' bordercolor=#FF0000><tr><td background=../images/tbl_error.png><font color=#FFFFFF> ERROR</font></td>".
"</tr>".
"<tr><td>$un<br>".
"Please enter your proper login information".
"</td>".
"</tr>".
"</table>";
echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php\">";
}
?>

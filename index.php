<?php
//error_reporting(1);
header('Content-Type: text/html; charset=ISO-8859-1');
$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
include($localPath."/includes/config.inc.php"); //datbase_connection
include($localPath."/includes/session.inc.php");
include($localPath."/includes/myFunction.php"); // some general function
//echo "erp";
if($_GET["S"])
	$_SESSION["S"]=1;
// echo $_SESSION["S"];
// log work
$sql="insert into log values ('','IP:".$_SERVER['REMOTE_ADDR'].", Proxy:".$_SERVER['HTTP_X_FORWARDED_FOR']."','123')";
mysqli_query($db,$sql);
// end log work

include_once($localPath."/includes/myFunction1.php"); // some general function
include_once($localPath."/includes/accFunction.php"); //all accounts function
include_once($localPath."/includes/empFunction.inc.php"); //manpower function
include_once($localPath."/includes/eqFunction.inc.php"); // equipment function

include_once($localPath."/includes/subFunction.inc.php"); // sub contracts function

include_once($localPath."/includes/matFunction.inc.php"); // material function

include_once($localPath.'/includes/vendoreFunction.inc.php'); // vendor related function
require_once($localPath."/keys.php"); // created and powered by function and link

//echo "<h1>Under Construction. Please Check later.</h2>";
//error_reporting(0);

$todat=todat();
?>
<!DOCTYPE html>
<html>
<head>
<LINK href="style/indexstyle.css" type=text/css rel=stylesheet>
<link href="style/basestyles.css" rel="stylesheet" type="text/css">
<link href="js/fValidate/screen.css" rel="stylesheet" type="text/css">

<meta http-equiv="Content-Language" content="en-us">
<meta name="author" content="<? echo $mauthor;?>">
<meta name="copyright" content="<? echo $tt;?>">
<meta name="keywords" content="<? echo $kword;?>">
<META NAME="description" CONTENT="<? echo $des;?>">
<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">

<SCRIPT language=JavaScript src="./js/shimul.js" type=text/JavaScript></SCRIPT>
<!--  ALL form validation function START-->
<SCRIPT language=JavaScript src="./js/fValidate/fValidate.config.js" type=text/JavaScript></SCRIPT>
<SCRIPT language=JavaScript src="./js/fValidate/fValidate.core.js" type=text/JavaScript></SCRIPT>
<SCRIPT language=JavaScript src="./js/fValidate/fValidate.lang-enUS.js" type=text/JavaScript></SCRIPT>
<SCRIPT language=JavaScript src="./js/fValidate/fValidate.validators.js" type=text/JavaScript></SCRIPT>
<SCRIPT LANGUAGE="Javascript" SRC="./js/myValidation.js"></SCRIPT>
	
<?php
	// conditional query
	$_SESSION[jQuery]=1;
	if($_SESSION[jQuery]==1){
		echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>';
		echo '<script src="./js/jquery-ui.min.js"></script>
		
<link href="./style/jquery-ui.min.css" rel="stylesheet" type="text/css">';
	}
?>
<!--  ALL form validation function END-->
<title>BFEW :: <? if($keyword){echo $keyword;}else{ echo "Home";}?></title>
</head>
<body  topmargin="1" leftmargin="5" rightmargin="5" bgcolor="#FFFFFF" >
<a name="top"></a>

 <div align="center">
    <center>
  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bgcolor="#FFFFFF" width="100%" >
    <tr>
      <td  bgcolor="#EEEEEE" > <!--  add head items-->
 <div style="position:absolute"> [ <a href="#" onClick="ShowHead('head');" title="click to SHOW/HIDE heading"><font color="#0066FF">HEAD</font></a> ]</div>
  <DIV  id=head <? if($keyword)echo ' class=hidden '; else echo ' class=visible ';?> style="position:absolute;z-index:1;" onClick="ShowHead('head');"> 	  
        <? include('head.php'); // add header items, links?>
		</DIV>
	  </td>
	</tr>
	<tr>
	  <td  onClick="HideHead('head');"> <!-- all contains goes to here-->
        <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="100%" height="1">
          <tr>
		  <td height="500" width="1" valign="top" bgcolor="#EEEEEE"></td>
		   <td valign="top" height="1" bgcolor="#FFFFFF">
            <br>

<? //middle
/*
if logged in
get the php file location under given keyword from `linkt` taable

*/
if($_SESSION['loginUname']){
	if($_GET['keyword'])
	{	
	  $keyword = $_GET['keyword'];
		if($keyword=="site item required?page=1")
		{
			$keyword="site item required";
			$page=1;
		}
		else if($keyword=="site item required?page=2")
		{
			$keyword="site item required";
			$page=2;
		}

		$sqlf = "select * FROM `linkt` where `keyw` = '$keyword'";
		$pagelinf = safeQuery($sqlf);
		$pagelink= mysqli_fetch_array($pagelinf);
		$keyword_middle= $pagelink[gotop]; 
		$pageTitle= $pagelink[title];
	}
	else{
		$keyword_middle='main.php';
	}
}
else{
	$keyword_middle='./user/login.php'; 
	$pageTitle="User Login";
}

?>
<!--<h1><? echo $pageTitle;?></h1>-->
<script>var thelinkedurl="<?php echo $keyword_middle; ?>";</script>
<? include($keyword_middle);?><br><br>
            </td>

          </tr>
        </table>
      </td>
    </tr>
    <tr>
     <td  bgcolor="#EEEEEE">
           <? include('bottom.php'); // add footer ?>
     </td>
    </tr>
    </table>
    </center>
  </div>
</body>

<script>
	console.log("<?= $keyword_middle ?>");
</script>

</html>
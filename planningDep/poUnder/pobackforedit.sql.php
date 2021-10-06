<?
include("../../includes/session.inc.php");
include("../../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

 mysqli_query($db,"UPDATE pordertemp set status='-1' WHERE posl='$_GET[posl]'");

if(file_exists("./porevision.php")){
	include("./porevision.php");
  if($_GET["revisionTxt"]){
    $todat=date("Y-m-d");
    $loginDesignation=$_SESSION["loginDesignation"];
    $poRevision->insertRevision($_GET[posl],$todat,$loginDesignation,$_GET["revisionTxt"]);
  }
}

echo "<h2>Information updated</h2><meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../../index.php?keyword=purchase+order+report&s=0\">";

?>
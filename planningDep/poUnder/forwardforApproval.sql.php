<?
include("../../includes/session.inc.php");
include("../../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

$posl=$_GET['posl'];
mysqli_query($db, " UPDATE pordertemp set `status`='-2' WHERE posl='$posl'");
// echo " UPDATE pordertemp set `status`='-2' WHERE posl='$posl'";
// exit;
if(file_exists("./porevision.php")){
	include("./porevision.php");
  if($_GET["revisionTxt"]){
    $todat=date("Y-m-d");
    $loginDesignation=$_SESSION["loginDesignation"];
    $poRevision->insertRevision($posl,$todat,$loginDesignation,$_GET["revisionTxt"]);
  }
}

echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../../index.php?keyword=purchase+order+report&s=0\">";




?>
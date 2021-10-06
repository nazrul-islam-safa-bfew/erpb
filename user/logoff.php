<?
include('./includes/session.inc.php');

session_destroy();
echo "You are logged out.... ";
echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=./index.php\">";
?>
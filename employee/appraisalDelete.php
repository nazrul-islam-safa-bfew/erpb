<?	include("../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$sql="DELETE from appraisal where appId=$appId";	
mysqli_query($db, $sql);
 echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=appraisal+action&a=1\">";
	?>
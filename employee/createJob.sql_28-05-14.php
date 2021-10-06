<?
function textok($text){
//$keyword=array("/'/",'/"/');
//$replacement=array("\'",'&quot;');
$search = array('"', "'",";");
$replace = array("&#34", "&#39","&#59");
$result = str_replace($search, $replace, $text); 
//$refineText=preg_replace($search,$replace,$text);
return $result;
}
?>
<? 	
include("../includes/global_hack.php");
include("../includes/session.inc.php");
include("../includes/config.inc.php");




$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

/*$sqlp=" UPDATE jobdetails set jobTitle='".mysqli_real_escape_string($_POST['jobTitle'])."', level='".$_POST['level']."' , summary='".mysqli_real_escape_string($_POST['summary'])."',education='".$_POST['education']."', experience='".$_POST['experience']."', training='".$_POST['training']."', skill='".$_POST['skill']."' , ability='".$_POST['ability']."', incumbent='".$_POST['incumbent']."', administrative='".$_POST['administrative']."', financial='".$_POST['financial']."', performance='".$_POST['performance']."', conditions='".$_POST['conditions']."', nature='".$_POST['nature']."',dduties='".$_POST['dduties']."', pduties='".$_POST['pduties']."',iduties='".$_POST['iduties']."', startingBasic='".$_POST['startingBasic']."', houseRent='".$_POST['houseRent']."', medical ='".$_POST['medical']."', convence='".$_POST['convence']."', proFund='".$_POST['proFund']."', increment ='".$_POST['increment']."', maxIncrement='".$_POST['maxIncrement']."' WHERE itemCode='".$_POST['itemCode']."' ";
*/

$sqlp=" UPDATE `jobdetails` set `jobTitle`='".textok(jobTitle)."', `level`='".textok($level)."', `summary`='".textok($summary)."', `education`='".textok($education)."',  `experience`='".textok($experience)."', `training`='".textok($training)."', `skill`='".textok($skill)."', `ability`='".textok($ability)."', `incumbent`='".textok($incumbent)."',  `administrative`='".textok($administrative)."', `financial`='".textok($financial)."', `performance`='".textok($performance)."', `conditions`='".textok($conditions)."',  `nature`='".textok($nature)."', `dduties`='".textok($dduties)."', `pduties`='".textok($pduties)."', `iduties`='".textok($iduties)."', `startingBasic`='$startingBasic', `houseRent`='$houseRent', `medical`='$medical', `convence`='$convence', `proFund`='$proFund', `increment`='$increment',  `maxIncrement`='$maxIncrement' WHERE `itemCode`='$itemCode' "; 
//echo $sqlp."<br>";
//$sqlp=mysql_real_escape_string($sqlp);
$sqlrunp= mysqli_query($db, $sqlp);
//$sqlrunp2= mysqli_query($db, $sqlp2);
//$sqlrunp3= mysqli_query($db, $sqlp3);
//echo $sqlp;

 echo "Updating.....<br>";
 //echo $info=phpinfo();
//echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?\">";
echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=create+job&e=1\">";
?>

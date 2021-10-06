<?php
include("./includes/session.inc.php");
include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
include("./includes/myFunction.php");


$iowID=intval($_POST["posID"]);
$position=$_POST["posVal"];

   if(is_position_already_used($position,$loginProject,$iowID) ||  is_position_already_used_in_temp($position,$loginProject)){
     echo $position." failed! Position already exists.";
     errorCheck(); //error check
     exit();
   }

	$upper_position=getUpperHeadPosition($position);
  $isUpperPossitionHead=isHeadorSubhead_in_iow($upper_position,$loginProject); //you can't make place a iow into another iow. find head or sub head to assign it.
  $isHead=isHeadorSubhead_from_iowID($iowID,$loginProject);
	if(!$isUpperPossitionHead && !$isHead){
		echo $position." failed! Please find a appropriate head to assign a iow.";
    errorCheck(); //error check
    exit;
	}

if(strlen($position)!=15 and substr_count($position)!=4 and $iowID>0){echo "0"; errorCheck(); exit;}
	
		$sqliow = "update iowtemp SET  position='$position' where iowId='$iowID'";	//save as iow description
		$sqlruniow= mysqli_query($db, $sqliow);
    $f1=mysqli_affected_rows($db);

		$sqliow = "update iow SET position='$position' where iowId='$iowID'";	//save as iow description
		$sqlruniow= mysqli_query($db, $sqliow);
    $f2=mysqli_affected_rows($db);
	
if($f2==1 || ($f1==1 && $f2==1))echo $position;
else echo 0;

?>
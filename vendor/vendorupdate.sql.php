<?
error_reporting(1);
include("../includes/session.inc.php");
include("../includes/global_hack.php");
putenv('TZ=Asia/Dhaka'); 
//echo "<br>Bangladesh Time: ". date("h:i:s"). "\n"; 
$todat= date("Y-m-d");
?>
<?
function myUpload($test,$testTemp,$loc,$qid){
   //echo "Still Here";
	$filemain = ".$loc/$qid.$test";
	echo $filemain.'<br>';
	//echo $test.'<br>';
	//echo $testTemp.'<br>';	
	if (move_uploaded_file($testTemp, $filemain)) {
	   echo "File is valid, and was successfully uploaded.\n";
	   $filemain = "$loc/$qid.$test";
	   return $filemain;
	} else {
	   echo "Possible file upload attack!\n";
	   return 0;
	}
}
?>

<? 

include("../config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);
	
	
	$advance=$advance!=0 ? - number_format($advance*0.2 , 2) : 0;	// advanced either 0 or - (x * .2)
  $cfacility=$cfacility==20 ? 20 : $cfacility * 0.25;	 //credit facility either 0 or (X * .25)

  $advanceType=$advType ? $advType : "";
	
	$point= $type + $quality + $reliability + $availability+ $experienceM + $experienceB + $service + $advance + $cfacility+$mngCulture+$orgBehavior;
	
	if($type==-10 || $quality==-10 || $orgBehavior==-10 || $mngCulture==-10 || $experienceM==-10 || $experienceB==-10 || $cfacility==-10 || $advance==-10)
		 $point="Disqualified";




     $sql = "UPDATE `vendor` SET `vname`='$vname', `address`='$address', `contactName`='$contactName', `designation`='$designation'";
	 $sql .=", `mobile`='$mobile', `accInfo`='$accInfo', `vGL`='$vGL',`type`='$type', `quality`='$quality', `qualityText`='$qualityText', `reliability`='$reliability'";
	 $sql .=", `reliabilityText`='$reliabilityText', `availability`='$availability', `availabilityText`='$availabilityText', `experienceM`='$experienceM'";
	 $sql .=", `experienceMText`='$experienceMText', `experienceB`='$experienceB', `experienceBText`='$experienceBText', `service`='$service', `serviceText`='$serviceText'";
	 $sql .=", `advance`='$advance', `advanceText`='$_POST[advanceText]', `cfacility`='$cfacility', `cfacilityText`='$_POST[cfacilityText]', `camount`='$camount', `cduration`='$cduration', `datev`='$datev', `point`='$point' ";
	 $sql .=", att='$uploadFile'";
	 $sql .=", advanceType='$advanceType'"; //advance type
	 $sql.=",ManagementCulture='$mngCulture'	 ,ManagementCultureTxt='$mngCultureTxt'	 ,OrganizationBehavior='$orgBehavior' ,OrganizationBehaviorTxt='$orgBehaviorTxt' ";
     $sql .=" WHERE vid=$vid"; 
    // echo "$sql<br>"; 	 

	$adduserdb = mysqli_query($db, $sql);
	
    $sql = "INSERT INTO `vendorrating` (`id`,`vid`,`quality`, `qualityText`, `reliability`, `reliabilityText`, `availability`, `availabilityText`, `experienceM`, `experienceMText`, `experienceB`, `experienceBText`, `service`, `serviceText`, `advance`, `advanceText`, `cfacility`, `cfacilityText`, `camount`, `cduration`, `datev`, `point`,`ratedBy`
	    
   ,`ManagementCulture`
   ,`ManagementCultureTxt` 
   ,`OrganizationBehavior`
   ,`OrganizationBehaviorTxt`
   ,`advanceType`
	 )";
	
    $sql.= " VALUES ('','$vid', '$quality', '$qualityText', '$reliability', '$reliabilityText', '$availability', '$availabilityText', '$experienceM', '$experienceMText', '$experienceB', '$experienceBText', '$service', '$serviceText', '$advance', '$_POST[advanceText]', '$cfacility', '$_POST[cfacilityText]', '$camount', '$cduration', '$todat', '$point','$ratedBy'
	 	 
	 ,'$mngCulture'
	 ,'$mngCultureTxt'
	 ,'$orgBehavior'
	 ,'$orgBehaviorTxt'
	 ,'$advanceType'
	 )";
	// echo "$sql"; 
	
	// exit;

	$adduserdb = mysqli_query($db, $sql);
  $qid= mysqli_insert_id($db);

$fileName=$_FILES['quoUpload']['name'];
if($fileName){
$fileTemp=$_FILES['quoUpload']['tmp_name'];
$uploadFile= myUpload($fileName, $fileTemp, './vendor/attachment', $qid);
//echo $uploadFile;
}
	if($uploadFile)
	{ 
	$sql ="UPDATE `vendor` SET att='$uploadFile' WHERE vid=$vid";
	//echo "<br>$sql";
	$sqlrunp= mysqli_query($db, $sql);
	$sql ="UPDATE `vendorrating` SET att='$uploadFile' WHERE id=$qid";
	//echo "<br>$sql";
	$sqlrunp= mysqli_query($db, $sql);
	}

/*if($uploadFile){$sql .=", att='$uploadFile'";}
$sql .=" WHERE vid=$vid"; 
*/
echo "<div id='msg'>Your information has been updated.. </div>";


	//echo $sql;
echo " <meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=vendor+Report\">";	
?>
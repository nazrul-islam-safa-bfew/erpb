<?
//formate date function

include("../includes/global_hack.php");


// echo $teqSpec=$model.'_'.$brand.'_'.$manuby.'_'.$madein.'_'.$speci.'_'.$designCap.'_'.$currentCap.'_'.$yearManu;

// echo "<h1>Under Construction. Please try later</h1>";
// exit();


$advance=$advance!=0 ? - number_format($advance*0.2 , 2) : 0;	// advanced either 0 or - (x * .2)
$cfacility=$cfacility==20 ? 20 : $cfacility * 0.25;	 //credit facility either 0 or (X * .25)



include("../includes/session.inc.php");
include("../includes/config.inc.php");

function formatDate($date,$format){
	$date_new_format = explode('/',$date);
	return $date_new_format[2].'-'.$date_new_format[1].'-'.$date_new_format[0];
	// return 333;
// if (preg_match("([0-9]{2})/([0-9]{2})/([0-9]{4})", $date, $regs)) {
// 	return date($format, mktime(0,0,0,$regs[2], $regs[1], $regs[3]));
//   }
}
?>
<? //file upload 
function myUpload($test,$testTemp,$loc,$qid){
   //echo "Still Here";
	$filemain = ".$loc/$qid.$test";
	//echo $filemain.'<br>';
	//echo $test.'<br>';
	//echo $testTemp.'<br>';	
	if (move_uploaded_file($testTemp, $filemain)) {
	   //echo "File is valid, and was successfully uploaded.\n";
	   $filemain = "$loc/$qid.$test";
	   return $filemain;
	} else {
	   echo "Possible file upload attack!\n";
	   return 0;
	}
}
?>
<? // Delete
if($delete){
include("../config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
	
$sql = "Delete From quotation WHERE qid=$qid"; 
//echo $sql;
$sqlrunp= mysqli_query($db, $sql);

$sql = "Delete From eqquotation WHERE qid=$qid"; 
//echo $sql;
$sqlrunp= mysqli_query($db, $sql);

}
?>

<? // save 
if($qotSave){
$format="Y-m-j";
$valid = formatDate($valid,$format);

$zone=3600*6; //GMT +6
$qdate=gmdate("Y-m-j", time() + $zone);


include("../config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
	
//$itemCode=$itemCode1.'-'.$itemCode2.'-'.$itemCode3;

if($delivery=='To')$deliveryLoc = $deliveryTo;
else if($delivery=='From')$deliveryLoc = $deliveryFrom;
if($qtOption!='1') $qtOption='0';
if(!$_SESSION['last_q_id']){
	
		
	//invalid all existing quotation
	$inv_sql="update quotation set valid='$qdate' where pCode='$pCode' and vid='$vid' and valid>'$qdate' and itemCode='$itemCode'";
	mysqli_query($db, $inv_sql);
	echo mysqli_affected_rows($db)>0 ? "<p>#".mysqli_affected_rows($db)." Existing Quotation Just Valid For Today.</p>" : "<p>Existing Quotation Not Found!</p>";
	$inv_root_sql="UPDATE `quotation_root` SET valid='$qdate' WHERE vid='$vid' and valid>'$qdate'";	
	mysqli_query($db, $inv_root_sql);
	echo mysqli_affected_rows($db)>0 ? "<p>#".mysqli_affected_rows($db)." Existing Quotation Head Updated.</p>" : "<p>Existing Quotation Head Not Found!</p>";	
	//end invalid code
	
	
$sql = "insert into quotation_root (vid, delivery, deliveryLoc, qRef, valid, qdate) values ('$vid','$delivery', '$deliveryLoc','$qRef', '$valid', '$qdate') ";
$sqlrunp= mysqli_query($db, $sql);

$last_q_id=mysqli_insert_id($db);
}
else
$last_q_id=$_SESSION['last_q_id'];


	
// 	echo $advance;

$sql = "INSERT INTO `quotation` (`qid`, `pCode`, `itemCode`, `sDetail`, `rate`,`type`, `delivery`,`deliveryLoc`, `qRef`, `valid`, `qdate`, `vid`, `qrId`, advance_req, credit_facility, advance_req_val, credit_facility_val)".
 " VALUES ('', '$pCode', '$itemCode', '$sDetail', '$rate','$qtOption', '$delivery', '$deliveryLoc','$qRef', '$valid', '$qdate', '$vid', '$last_q_id', '$advance', '$cfacility', '$point_of_advance', '$point_of_cf')";
echo "$sql<br>";
  // exit;
$sqlrunp= mysqli_query($db, $sql);
$qid= mysqli_insert_id($db);

$_SESSION['last_q_id']=$last_q_id;
$_SESSION['pCode']=$pCode;
$_SESSION['sDetail']=$sDetail;
$_SESSION['delivery']=$delivery;
$_SESSION['deliveryLoc']=$deliveryLoc;
$_SESSION['qRef']=$qRef;
$_SESSION['valid']=$valid;
$_SESSION['qdate']=$qdate;




$fileName=$_FILES['quoUpload']['name'];
if($fileName)
 {
	$fileTemp=$_FILES['quoUpload']['tmp_name'];
	$uploadFile= myUpload($fileName, $fileTemp, './vendor/attachment', $last_q_id);
//	echo $uploadFile;
	if($uploadFile)
	  { 
	  $last_qid=mysqli_insert_id($db);
	   $sql ="UPDATE `quotation_root` SET att='$uploadFile' WHERE qrId=$last_q_id";
	 // echo "<br>$sql";
	   $sqlrunp= mysqli_query($db, $sql);
	   }
  }

//$sql = "UPDATE `quotation` SET vid='', sVid='$vid' WHERE vid='$vid' and qid!='$last_q_id'";
//$sqlrunp= mysqli_query($db, $sql);




if($itemCode>='50-00-000'){
  $teqSpec=$model.'_'.$brand.'_'.$manuby.'_'.$madein.'_'.$speci.'_'.$designCap.'_'.$currentCap.'_'.$yearManu;
  $sqlitem = "INSERT INTO `eqquotation` ( `qid` , `itemCode` , `teqSpec`  , `life` ,
                     `salvageValue` , `days`, `hours` ,`condition`, `edate` )
                              VALUES ( '$qid'  , '$itemCode' , '$teqSpec' , '$life' ,
                 '$salvageValue' ,'$days','$hours'  ,'$condition' , '$qdate' )";
  echo "$sqlitem <br>";
  mysqli_query($db, $sqlitem);
}//if
}
?>

<? // Edit & save 

if($qotEdit){
$format="Y-m-j";
$valid = formatDate($valid,$format);

$zone=3600*6; //GMT +6
$qdate=gmdate("Y-m-j ", time() + $zone);

include("../config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
	
//$itemCode=$itemCode1.'-'.$itemCode2.'-'.$itemCode3;

	
if($delivery=='To')$deliveryLoc = $deliveryTo;
else if($delivery=='From')$deliveryLoc = $deliveryFrom;

$sql = "UPDATE `quotation` SET pCode='$pCode', itemCode='$itemCode',
 sDetail='$sDetail', rate='$rate', delivery='$delivery',deliveryLoc='$deliveryLoc',qRef='$qRef', 
 valid='$valid', qdate='$qdate', vid='$vid' WHERE qid=$qid"; 


$sql = "INSERT INTO `quotation` (`qid`, `pCode`, `itemCode`, `sDetail`, `rate`,`type`, `delivery`,`deliveryLoc`, `qRef`, `valid`, `qdate`, `vid`)".
 "VALUES ('', '$pCode', '$itemCode', '$sDetail', '$rate','$qtOption', '$delivery', '$deliveryLoc','$qRef', '$valid', '$qdate', '$vid')"; 
//echo $sql;

$sqlrunp= mysqli_query($db, $sql);




}
echo "Information Updated";
echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=enter+Quotation&Go=1&vid=$vid\">";
?>

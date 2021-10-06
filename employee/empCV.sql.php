<? 	include("../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$sqlp=" INSERT INTO empcv (id,empId,empName,empFName,empMName,empPaddress,
empCaddress,othersextra,othersAward,othersSkill,othersHobbie,otherRef1,otherRef2,otherGuarantor)
VALUES('','$empId','$empName','$empFName','$empMName','$empPaddress','$empCaddress'
,'$othersextra','$othersAward','$othersSkill','$othersHobbie','$otherRef1','$otherRef2','$otherGuarantor')";
//echo "$sqlp<br>";
$sqlrunp= mysqli_query($db, $sqlp);
$r=mysqli_affected_rows();
if($r<=0){
$sqlp="UPDATE empcv set empName='$empName',empFName='$empFName',empMName='$empMName',empPaddress='$empPaddress',
empCaddress='$empCaddress',othersextra='$othersextra',othersAward='$othersAward',othersSkill='$othersSkill',
othersHobbie='$othersHobbie',otherRef1='$otherRef1',otherRef2='$otherRef2',otherGuarantor='$otherGuarantor' where empId='$empId'";
$sqlpq=mysqli_query($db, $sqlp);
}

for($i=1;$i<=3;$i++){
if(${degreeAchieved.$i}){
$sqlp=" INSERT INTO empedu (id,empId,degreeAchieved,degreeInstitute,degreeResult,degreeYear)
VALUES ('','$empId','${degreeAchieved.$i}','${degreeInstitute.$i}','${degreeResult.$i}','${degreeYear.$i}')";
//echo "$sqlp<br>";
$sqlrunp= mysqli_query($db, $sqlp);
$r=mysqli_affected_rows();
if($r<=0){
$sqlp_up="UPDATE empedu set degreeAchieved='${degreeAchieved.$i}',degreeInstitute='${degreeInstitute.$i}',
degreeResult='${degreeResult.$i}',degreeYear='${degreeYear.$i}' where empId='$empId'";
//echo "$sqlp_up<br>";
mysqli_query($db, $sqlp_up);
$r=0;
}//r
}//${degreeAchieved.$i}
}
for($i=1;$i<=3;$i++){
if(${expcompany.$i}){
$sqlp=" INSERT INTO empexp (id,empId,expcompany,expposition,expFromto,expJobRes)
VALUES ('','$empId','${expcompany.$i}','${expposition.$i}','${expFromto.$i}','${expJobRes.$i}')";
//echo "$sqlp<br>";
$sqlrunp= mysqli_query($db, $sqlp);
$r=mysqli_affected_rows();
if($r<=0){
$sqlp_up="UPDATE empexp set expcompany='${expcompany.$i}',expposition='${expposition.$i}',
expFromto='${expFromto.$i}',expJobRes='${expJobRes.$i}' where empId='$empId'";
mysqli_query($db, $sqlp_up);
}//r

}//${expcompany.$i}
}



echo "Update Complete<br>";


 /******* START for upload image *******/


 if($_FILES['empPhoto']['name'])
	{
	
				
/*	echo "filename: ".$_FILES['empPhoto']['name']."<br>";
	echo "filesize: ".$_FILES['empPhoto']['size']."<br>";
	echo "filetype: ".$_FILES['empPhoto']['type']."<br>";
*/

$maxFileSize=200;//KByte
$acceptable_file_types = "image/jpeg|image/pjpeg";
	
$fileSize=$_FILES['empPhoto']['size']/1024;
$fileType=$_FILES['empPhoto']['type'];

if($fileSize>$maxFileSize) 
{
//echo "<br>***$fileSize>$maxFileSize*******<br>";
$error=1;
echo "File Size excedding!!<br>Please try after reduce file size";
}

if($fileType!='image/jpeg' AND $fileType!='image/pjpeg' ) 
{
$error=1;
echo "File Type does not supported<br>Please try after changing file type to JPG";

}
if(!$error){	
	$img_name=$empId.".jpg"; // name of the image
	
	$uploaddir = "empPhoto/"; //uploadeing directory name
	$fileupload = $uploaddir .$img_name;
	if (! move_uploaded_file($_FILES['empPhoto']['tmp_name'], $fileupload))
	{
	print ("failed to upload $file...<br>\n");
	}
	else {echo "Thank you! The image was successfully uploaded." ; }//else
	}//error
   
	}//if file name
//if($error) {//echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?\">";}
 /******* end of uploade image *******/
 
echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=employee+details&page=1\">";

?>


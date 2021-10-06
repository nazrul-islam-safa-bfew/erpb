<? 
include("../includes/session.inc.php");
include("../includes/myFunction.php");?>
<? 
include("../includes/config.inc.php");
$time=mktime(0,0,0, date("m"),date("d"),date("y"));
$todat = date("Y-m-d",$time);

$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);	
?>
<?
if($save){
$format="Y-m-j";
$empDate = formatDate($empDate,$format);
$creDate = formatDate($creDate,$format);
$proDate = formatDate($proDate,$format);
if($additional){
	foreach ($additional as $value)
				{
				$additional =$additional.",".$value;
				$addJob=substr($additional,6);
				}
}
if($id){
	if($delete){
	$sqlitem = "UPDATE `employee` SET status=1 WHERE empId=$id";}
	else {
	/*$sqlitem = "UPDATE `employee` SET  `name`='$name' ,".
					" `addJob`='$addJob', `proDate`='$proDate' ,".
					" `pament`='$pament' , `salaryType`='$salaryType' , `salary`='$salary' ,`allowance`='$allowance' ,`edate`='$todat' ".
					" WHERE empId=$id"; 
					*/
	 $sqlitem = "UPDATE `employee` SET  name='$name',`salary`='$salary' ,`nationalid`='$nationalid' ,`allowance`='$allowance',email_personal='$email_personal', email_office='$email_office', phone_personal='$phone_personal', phone_office='$phone_office',designation='$designation',ccr='$mc'  WHERE empId=$id";
	}
}
else{
$sqlitem = "INSERT INTO `employee` ( `empId` , `name`, `nationalid` , `designation` ,`addJob` , `empDate` ,`creDate` ,`proDate` ,`jobTer`,".
									" `pament` , `salaryType` , `salary` ,`allowance`,`edate`, `location`, `status`,
									email_personal,email_office,phone_personal,phone_office,ccr)".
                            "VALUES ( '' , '$name' , '$_POST[nationalid]' , '$designation' ,'$addJob', '$empDate' ,'$creDate' ,'$proDate','',".
									" '$pament' , '$salaryType' , '$salary' , '$allowance' ,'$todat' ,'$_POST[pcode]','0','$email_personal','$email_office','$phone_personal','$phone_office','$mc')";

  
}
//echo $sqlitem;
$sqlrunItem= mysqli_query($db, $sqlitem);
$row=mysqli_affected_rows($db);
//echo $row;

if($row<1)
{
	$msg= "Your informations can't be saved...<br> <font >Please check the inputes May be Employee Id conflict ";

	echo errMsg($msg);
echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=employee+entry\">";	
}
else {
	echo "Your informations are saving...<br> Wait Please...... ";
	echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=employee+details\">";
	}
}

?> 
<? 
if($addhr){
$sqldma = "INSERT INTO dma (dmaId, dmaProjectCode, dmaiow,dmasiow, dmaItemCode, dmaQty, dmaDate  )".
				"VALUES ('', '$loginProject', '$iow','$siow', '$designation', '$qty', '$todat'  )";
//echo $sqldma;
$sqlQuery =mysqli_query($db, $sqldma);

	echo "Your informations are saving...<br> Wait Please...... ";
	echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=site+view+dma&iow=$iow\">";
				
}	



if($addRequisition){
include("../config.inc.php");
$time=mktime(0,0,0, date("m"),date("d"),date("y"));
$todat = date("Y-m-d",$time);
$rdate = formatDate($rdate,"Y-m-d");
$ddate = formatDate($ddate,"Y-m-d");

$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
for($i=0;$i<$quantity;$i++){	
$sql="INSERT INTO `employeereq` ( `emreid` ,`pcode`, `emCode`  , `rdate` , `ddate` , `date` )". 
                   "VALUES ( '' , '$loginProject', '$eqCode'  , '$rdate' , '$ddate' , '$todat' )";
  //echo $sql;
$sqlrun= mysqli_query($db, $sql);
}
$row=mysqli_affected_rows($db);

if($row<1)
{
	$msg= "Your informations can't be saved...<br> <font >Please check the inputes May be Asset Id conflict ";

	echo errMsg($msg);
	echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=employee+entry\">";	
}
else {
	echo "Your informations are saving...<br> Wait Please...... ";
	echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=employee+details\">";
	}

}


if($appRequisition){
include("../config.inc.php");
$time=mktime(0,0,0, date("m"),date("d"),date("y"));
$todat = date("Y-m-d",$time);
$rdate = formatDate($rdate,"Y-m-d");
$ddate = formatDate($ddate,"Y-m-d");

$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
for($i=0;$i<$no;$i++){	
$sql="UPDATE `employeereq` SET empId='${assetId.$i}' WHERE emreid='${id.$i}'";
  //echo $sql.'<br>';
$sqlrun= mysqli_query($db, $sql);
$sql="UPDATE `employee` SET location='${pp.$i}', status='1' WHERE empId='${assetId.$i}'";
  //echo $sql;
$sqlrun= mysqli_query($db, $sql);

}
$row=mysqli_affected_rows($db);

if($row<1)
{
	$msg= "Your informations can't be saved...<br> <font >Please check the inputes May be Asset Id conflict ";

	echo errMsg($msg);
	echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"5; URL=../index.php?keyword=employee+entry\">";	
}
else {
	echo "Your informations are saving...<br> Wait Please...... ";
	echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=employee+details\">";
	}

}

		
?>				

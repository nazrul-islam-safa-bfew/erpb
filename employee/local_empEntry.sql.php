<? 
include("../includes/session.inc.php");
include("../includes/myFunction.php");?>
<? 
include("../config.inc.php");
$time=mktime(0,0,0, date("m"),date("d"),date("y"));
$todat = date("Y-m-d",$time);

$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
	
?>
<? if($save){

	

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
	$sqlitem = "UPDATE `employee` SET  `name`='$name' ,".
					" `addJob`='$addJob', `proDate`='$proDate' ,".
					" `pament`='$pament' , `salaryType`='$salaryType' , `salary`='Wages Monthly Master Roll' ,`allowance`='$allowance' ,`edate`='$todat' ".
					" WHERE empId=$id"; 
	}
}
else{	
$sqlitem = "INSERT INTO `employee` ( `empId` , `name` , `designation` ,`addJob` , `empDate` ,`creDate` ,`proDate` ,`jobTer`,".
									" `pament` , `salaryType` , `salary` ,`allowance`,`edate`, `location`, `status`)".
                            "VALUES ( '' , '$name' , '$designation' ,'$addJob', '$empDate' ,'$creDate' ,'$proDate','',".
									" '$pament' , 'Wages Monthly Master Roll' , '$salary' , '$allowance' ,'$todat' ,'$loginProject','0')";

  
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
	echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php\">";
	}

}

?>

		
			

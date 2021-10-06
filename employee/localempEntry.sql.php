<? 
include("../session.inc.php");
include("../includes/myFunction.php");?>
<? 
include("../config.inc.php");
$time=mktime(0,0,0, date("m"),date("d"),date("y"));
$todat = date("Y-m-d",$time);

$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
?>
<? if($save){

$format="Y-m-j";
$gdate = formatDate($gdate,$format);
if($additional){
	foreach ($additional as $value)
				{
				$additional =$additional.",".$value;
				$addJob=substr($additional,6);
				}
}
if($id){
	if($delete){
	$sqlitem = "DELETE FROM employee WHERE id=$id";}
	else {
	$sqlitem = "UPDATE `employee` SET  `name`='$name' ,".
					" `designation`='$designation' , `addJob`='$addJob', `empDate`='$empDate' ,`creDate`='$creDate' ,`proDate`='$proDate' ,".
					" `pament`='$pament' , `salaryType`='$salaryType' , `salary`='$salary' ,`edate`='$todat', `location`='000' ".
					" WHERE id=$id"; 
	}
}
else{


$empId=localemp($loginProject,$designation);
$sqlitem = "INSERT INTO `localemp` ( `id` ,`empId`,`designation`, `name` , `salary` ,".
									" `gdate` , `location`, `status`)".
                            "VALUES ( '' , '$empId','$designation','$name','$salary' ,".
									" '$gdate' ,'$loginProject','0')";

  
}
//echo $sqlitem;
$sqlrunItem= mysqli_query($db, $sqlitem);
$row=mysqli_affected_rows();
//echo $row;

if($row<1)
{
	$msg= "Your informations can't be saved...<br> <font >Please check the inputes May be Asset Id conflict ";

	echo errMsg($msg);
	echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"5; URL=../index.php?keyword=local+emp+recruit\">";	
}
else {
	echo "Your informations are saving...<br> Wait Please...... ";
	echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=local+emp+recruit\">";
	}
}

?>
	  

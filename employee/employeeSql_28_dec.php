<? 
include("../session.inc.php");
include("../includes/myFunction.php");?>
<? 
include("../config.inc.php");
$time=mktime(0,0,0, date("m"),date("d"),date("y"));
$todat = date("Y-m-d",$time);

$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
	
?>
<? if($save)
{
if(substr($designation,0,2)=="71")
 $deg=substr($designation,0,5);
else
 $deg=substr($designation,0,2);
 
 $sql="select * from salary where itemCode like '$deg%'";
 $r=mysqli_query($db, $sql);
 $row=mysqli_fetch_array($r);
 $txtbasic=$row[initbasic];
 $inc=$row[inc];
 $house=$row[houserent];
 $prof=10;
 $curbasic=$txtbasic;
 for($i=2;$i<=$txtincrement;$i++)
	{
		$curbasic=round($curbasic+($curbasic*$inc/100));
	}
$houserent=round($curbasic*($house/100));
$profund=round($curbasic*($prof/100));

if(substr($designation,0,5)=="71-01")
{
$med=0;
$trn=0;
$txtmedical="Global Family Health and Life Insurance";
$txttransport="Car Personal and Family Use, 1st Class Travel and 5 Star Hotel";
}
elseif((substr($designation,0,5)=="71-20")||(substr($designation,0,5)=="71-21")||(substr($designation,0,5)=="71-22"))
{
$med=0;
$trn=0;
$txtmedical="Premium Insurance";
$txttransport="Car Full time";
}

elseif(substr($designation,0,2)=="72")
{
	if($txtincrement>=32 and $txtincrement<=40)
	{
		$med=0;
		$trn=0;
		$txtmedical="Health Insurance";
		$txttransport="Car Personal Use";
	}
	elseif($txtincrement>=28 and $txtincrement<=31)
	{
		$med=0;
		$trn=0;
		$txtmedical="Health Insurance";
		$txttransport="Car Office Use";
	}
	elseif($txtincrement>=23 and $txtincrement<=27)
	{
		$med=2000;
		$trn=0;
		$txtmedical="2000";
		$txttransport="Car Office Use";
	}
	elseif($txtincrement>=21 and $txtincrement<=22)
	{
		$med=1000;
		$trn=0;
		$txtmedical="1000";
		$txttransport="Car Office Use";
	}
	elseif($txtincrement>=1 and $txtincrement<=20)
	{
		$med=1000;
		$trn=1000;
		$txtmedical="1000";
		$txttransport="1000";
	}
}
//elseif((substr($designation,0,2)=="73") || (substr($designation,0,2)=="74"))
elseif((substr($designation,0,2)=="73") || (substr($designation,0,2)=="74") || (substr($designation,0,2)=="75"))

{
	if($txtincrement>=47 and $txtincrement<=50)
	{
		$med=0;
		$trn=0;
		$txtmedical="Health Insurance";
		$txttransport="Car Personal Use";
	}
	elseif($txtincrement>=31 and $txtincrement<=46)
	{
		$med=0;
		$trn=0;
		$txtmedical="Health Insurance";
		$txttransport="Car office use";
	}
	elseif($txtincrement>=28 and $txtincrement<=30)
	{
		$med=0;
		$trn=1000;
		$txtmedical="Health Insurance";
		$txttransport="1000";
	}
	elseif($txtincrement>=23 and $txtincrement<=27)
	{
		$med=2000;
		$trn=1000;
		$txtmedical="2000";
		$txttransport="1000";
	}
	elseif($txtincrement>=1 and $txtincrement<=22)
	{
		$med=1000;
		$trn=1000;
		$txtmedical="1000";
		$txttransport="1000";
	}
	
}
elseif(substr($designation,0,2)=="76")
{
	if($txtincrement>=21 and $txtincrement<=25)
	{
		$med=800;
		$trn=500;
		$txtmedical="800";
		$txttransport="500";
	}
	elseif($txtincrement>=10 and $txtincrement<=20)
	{
		$med=750;
		$trn=500;
		$txtmedical="750";
		$txttransport="500";
	}
	elseif($txtincrement>=1 and $txtincrement<=9)
	{
		$med=500;
		$trn=500;
		$txtmedical="500";
		$txttransport="500";
	}
}
elseif((substr($designation,0,2)=="87") || (substr($designation,0,2)=="88") || (substr($designation,0,2)=="89")|| (substr($designation,0,2)=="90"))
{
	if($txtincrement>=22 and $txtincrement<=50)
	{
		$med=1000;
		$trn=0;
		$txtmedical="1000";
		$txttransport="-";
	}
	elseif($txtincrement>=11 and $txtincrement<=21)
	{
		$med=750;
		$trn=0;
		$txtmedical="750";
		$txttransport="-";
	}
	elseif($txtincrement>=1 and $txtincrement<=10)
	{
		$med=500;
		$trn=0;
		$txtmedical="500";
		$txttransport="-";
	}
}
$salary=round(($curbasic+$houserent+$med+$trn)-$profund);
	
$format="Y-m-j";
$empDate = formatDate($empDate,$format);
$creDate = formatDate($creDate,$format);
$proDate = formatDate($proDate,$format);
if($additional)
{
	foreach ($additional as $value)
				{
				$additional =$additional.",".$value;
				$addJob=substr($additional,6);
				}
}
if($id)
{

	if($delete)
	{
	$sqlitem = "UPDATE `employee` SET status=1 WHERE empId=$id";
	}
	else 
	{
/*$sqlitem = "UPDATE `employee` SET  `name`='$name' ,".
					" `addJob`='$addJob', `proDate`='$proDate' ,".
					" `pament`='$pament' , `salaryType`='$salaryType' , `salary`='$salary' ,`allowance`='$allowance' ,`edate`='$todat' ".
					" WHERE empId=$id"; 
*/	
if($_POST['salaryType']=="Salaried")
 {	
			
print $sqlitem = "UPDATE `employee` SET `name`='$name',`nationalid`='$nationalid',`designation`='$designation',`salaryType`='$salaryType',`salary`='$salary',initbasic=$txtbasic,increment=$txtincrement,curbasic=$curbasic,houserent=$houserent,
medical='$txtmedical', transport='$txttransport',profund=$profund,incometax='As per Govt. Rule' WHERE empId=$id";	
}
if($_POST['salaryType']=="Consolidated")
{
print $sqlitem = "UPDATE `employee` SET `name`='$name',`nationalid`='$nationalid',`designation`='$designation',`salaryType`='$salaryType',`salary`='$salary',initbasic='',increment='',curbasic='',houserent='',
medical='', transport='',profund='',incometax='' WHERE empId=$id";	

}
}
}
else
{
if($_POST['salaryType']=="Salaried")
{	
//print "$txtbasic, $inc, $curbasic, $houserent, $profund, $salary";
print $sqlitem = "INSERT INTO `employee` (`name` ,`nationalid`,`designation` ,`addJob` , `empDate` ,`creDate` ,`proDate` ,`jobTer`,".
									" `pament` , `salaryType` , `salary` ,`allowance`,`edate`, `location`, `status`,`initbasic`,increment,curbasic,houserent,medical,transport,profund,incometax)".
                            "VALUES ('$name' ,'$nationalid', '$designation' ,'$addJob', '$empDate' ,'$creDate' ,'$proDate','',".
									" '$pament' , '$salaryType' , '$salary' , '$allowance' ,'$todat' ,'000','0','$txtbasic','$txtincrement',$curbasic,$houserent,'$txtmedical','$txttransport',$profund,'As per Govt. Rule')";

}
if($_POST['salaryType']=="Consolidated")
{	
print $sqlitem = "INSERT INTO `employee` ( `name` ,`nationalid`, `designation` ,`addJob` , `empDate` ,`creDate` ,`proDate` ,`jobTer`,".
									" `pament` , `salaryType` , `salary` ,`allowance`,`edate`, `location`, `status`,`initbasic`,increment,curbasic,houserent,medical,transport,profund,incometax)".
                            "VALUES ('$name' ,'$nationalid', '$designation' ,'$addJob', '$empDate' ,'$creDate' ,'$proDate','',".
									" '$pament' , '$salaryType' , '$txtsalary' , '$allowance' ,'$todat' ,'000','0','','','','','','','','')";

}
}
  
}

$sqlrunItem= mysqli_query($db, $sqlitem);
$row=mysqli_affected_rows();
//echo $row;

if($row<1)
{
	$msg= "Your informations can't be saved...<br> <font >Please check the inputs May be Employee Id conflict ";

	echo errMsg($msg);
//echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=employee+entry\">";	
}
else {
	echo "Your informations are saving...<br> Wait Please...... ";
	echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=employee+details\">";
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
$row=mysqli_affected_rows();

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
$row=mysqli_affected_rows();

if($row<1)
{
	$msg= "Your informations can't be saved...<br> <font >Please check the inputs May be Asset Id conflict ";

	echo errMsg($msg);
	echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"5; URL=../index.php?keyword=employee+entry\">";	
}
else {
	echo "Your informations are saving...<br> Wait Please...... ";
	echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=employee+details\">";
	}

}

		
?>				

<? 
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$txtincrement=$_GET[p];
$designation=$_GET[q];
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
		 $curbasic=($curbasic+($curbasic*$inc/100));
	}
//print $curbasic;
 $houserent=$curbasic*($house/100);
 $profund=$curbasic*($prof/100);

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
elseif((substr($designation,0,2)=="73") || (substr($designation,0,2)=="74") || (substr($designation,0,2)=="75")|| (substr($designation,0,2)=="76")|| (substr($designation,0,2)=="77")|| (substr($designation,0,2)=="78")|| (substr($designation,0,2)=="79"))
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
elseif((substr($designation,0,2)=="80") || (substr($designation,0,2)=="81") || (substr($designation,0,2)=="82") || (substr($designation,0,2)=="83") || (substr($designation,0,2)=="84") || (substr($designation,0,2)=="85") || (substr($designation,0,2)=="86"))
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
elseif((substr($designation,0,2)=="90") || (substr($designation,0,2)=="95") || (substr($designation,0,2)=="96")|| (substr($designation,0,2)=="97")|| (substr($designation,0,2)=="98"))
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
print $salary=round(($curbasic+$houserent+$med+$trn)-$profund);
?>
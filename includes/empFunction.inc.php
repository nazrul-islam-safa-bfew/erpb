<?php

function get_iow_remaining_days($itemCode,$edat){
  global $db;
  $sql="select datediff(iowCdate,'".$edat."') iow_duration,iowId from iow where iowId in (select dmaiow from dma where dmaItemCode='$itemCode') and iowCdate>'".$edat."' group by iowId";
  $q=mysqli_query($db,$sql);
  while($row=mysqli_fetch_array($q)){
    $iow_dutation+=$row[iow_duration];
  }
  return $iow_dutation;
}

function get_attendance_of_particular_empId($itemCode,$pcode){
  global $db;
  $sql="select sum((etime-stime)/86400) as total_duration from attendance where empId in (select empId from employee where designation='$itemCode') and action in ('P','HP') and location='$pcode'";
  
  $q=mysqli_query($db,$sql);
  $row=mysqli_fetch_array($q);
  return $row[total_duration];
}


function getLastAttendance($empId){
	global $db;
	$sql="select edate from attendance where empId='$empId'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row["edate"];
}

function empId2Designation($empId){
	global $db;
	$sql="select designation from employee where empId='$empId'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row[designation];
}

function getManager($designation,$pcode){
	global $db;
	$sql="select * from employee where location='$pcode' and designation=(select ccr from employee where designation='$designation' and location='$pcode' limit 1)";
	$q=mysqli_query($db,$sql);
	
	if(mysqli_affected_rows($db)<1)return false;
	
	$row=mysqli_fetch_array($q);
	return $row;
}

function getDepartment($empId){
	global $db;
}
function getEmployeeItemCodeRange(){
	$arr=array("start"=>"71-01-000","end"=>"85-99-999");
	return $arr;
}
function departmentList($selected=null){ //backdated
	  $designationList=array(
			'71'=>array("code"=>"71-00-000","designation"=>"Director"),
			'72'=>array("code"=>"72-00-000","designation"=>"Construction & Engineering Department"),
			'73'=>array("code"=>"73-00-000","designation"=>"Manager & Executive"), //Design & Estimation Department
			'74'=>array("code"=>"74-00-000","designation"=>""), //Accounts & MIS Department
			'75'=>array("code"=>"75-00-000","designation"=>"Office Assistant"), //Human Resource Department
			'76'=>array("code"=>"76-00-000","designation"=>""), //Procurement Department
			'77'=>array("code"=>"77-00-000","designation"=>"Foreman & Supervisor"), //Store & Logistic Department
			'78'=>array("code"=>"78-00-000","designation"=>"High Skill Labor"), //Business Development & Marketing Department
			'79'=>array("code"=>"79-00-000","designation"=>""), //Project Department
			'80'=>array("code"=>"80-00-000","designation"=>"Construction Department"),
			'81'=>array("code"=>"81-00-000","designation"=>"Workshop"),
			'82'=>array("code"=>"82-00-000","designation"=>""), //Equipment & Rental Sevices Department
			'83'=>array("code"=>"83-00-000","designation"=>""),
			'84'=>array("code"=>"84-00-000","designation"=>""),
			'85'=>array("code"=>"85-00-000","designation"=>"")
		);
	if($selected)return $designationList[$selected];
	return $designationList;
}

function managerList($managerCode=null){
	$managerList = (array(
		'73-13-001'=>"Assistant Manager",
		'73-12-000'=>"Deputy Manager",
		'73-12-001'=>'Deputy Project Manager',
		'73-11-000'=>'Manager',
		'73-11-001'=>'Manager, Accounts & MIS',
		'73-11-002'=>'Manager, Finance & Investment',
		'73-11-003'=>'Manager, Land officer & GM',
		'73-11-004'=>'HR Coordinator',
		'73-11-005'=>'Coordinator, Procurement',
		'73-11-006'=>'Manager, Store',
		'73-11-007'=>'Manager, Marketing & Brand Establishment',
		'73-11-008'=>'Business Development Manager(Building Project)',
		'73-11-009'=>'Business Development Manager(Plant Construction Project)',
		'73-11-010'=>'Business Development Manager(Infrastructure Constructoin Project)',
		'73-11-011'=>'Poject Manager',
		'73-11-012'=>'Construction Manager',
		'73-11-013'=>'Workshop Manager',
		'73-11-014'=>'Maintanance Manager',
		'73-10-001'=>'Sr. Manager'
	));
	if($managerCode)
		return $managerList[$managerCode];
	return $managerList;
}



function getSubordinate($managerCode=null,$extra=" order by designation desc "){
	global $db;
	$sql="select * from employee where ccr='$managerCode' $extra";
	$q=mysqli_query($db,$sql);
	while($row[]=mysqli_fetch_array($q)){}
	return $row;
}

function getIncumbent($empId=null){
	global $db;
	$sql="select ccr from employee where empId='$empId'";
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row["ccr"];
}



function appraisalData($key=null,$type="noun"){
	if($type=="noun")
		$data=array(1=>"Termination",2=>"Suspention",3=>"Promotion",4=>"Increment",5=>"Bonus",6=>"Incentive");
	elseif($type=="text")	$data=array(1=>"Release from employment",2=>"Suspention",3=>"Promotion",4=>"Increment",5=>"Bonus",6=>"Incentive");
	else	$data=array(1=>"released",2=>"Suspend",3=>"Promot",4=>"Increment",5=>"Bonus",6=>"Incentive");

	if($key)
		return $data[$key];
	return $data;
}


function appraisalActionCounter($type=null){
	global $db;
	$sql="select count(*) ass from appaction where `action`=$type and actionStatus='1' and empId in (select empId from employee)";
	// echo $sql;
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row["ass"]>0 ? $row["ass"] : 0;
}


function appraisal2($empId,$appId){
	$reason=array('1'=>'Annual','2'=>'Promotion', '3'=>'Unsatisfactory Performance','4'=>'Training need assesment','5'=>'End Probation Period', '6'=>'End of Project','7'=>'Other');
	$rating=array('100'=>'Outstanding','90'=> 'Very Good','80'=>'Good','50'=>'Improvement Needed','0'=>'Unsatisfactory','55'=>'Not Rated');

	global $db;
	
  $sql1="SELECT * FROM appraisal WHERE empId='$empId' AND appId='$appId' ORDER BY appDate DESC";
  $sqlQ1=mysqli_query($db, $sql1);
  $sqlapp=mysqli_fetch_array($sqlQ1);
//   print_r($sqlapp);
  $low=$sqlapp[quality] ? $sqlapp[quality] : 0;
  
  if($sqlapp[productivity]<$low){
    $low=$sqlapp[productivity];
  }
  if($sqlapp[reliability]<$low && $sqlapp[reliability]){
    $low=$sqlapp[reliability];
  }
  if($sqlapp[availability]<$low && $sqlapp[availability]){
    $low=$sqlapp[availability];
  }
  if($sqlapp[independence]<$low && $sqlapp[independence]){
    $low=$sqlapp[independence];
  }
  if($sqlapp[reporting]<$low && $sqlapp[reporting]){
    $low=$sqlapp[reporting];
  }
  if($sqlapp[teamwork]<$low && $sqlapp[teamwork]){
    $low=$sqlapp[teamwork];
  }
//   echo $low."<br>";
  if($low==-400){
    $re[rate]=$rating[0];
  }
  if($low==0){
    $re[rate]=$rating[50];  
  }
  if($low==50){
    $re[rate]=$rating[80]; 
  }
  if($low==100){
    $re[rate]=$rating[100]; 
  }
  $re[summarize]=$sqlapp[summarize];  
  return $re;
  
  
  
  $rate=$sqlapp[quality]+$sqlapp[productivity]+$sqlapp[productivity]+$sqlapp[reliability]+$sqlapp[availability]+$sqlapp[independence]+$sqlapp[reporting]+$sqlapp[teamwork];
   
	$re= array("reason"=>$reason[$sqlapp[reason]],"quality"=>$rating[$sqlapp[quality]],"productivity"=>$rating[$sqlapp[productivity]], 'jobknowledge'=>$rating[$sqlapp[jobknowledge]],'reliability'=>$rating[$sqlapp[reliability]], 'availability'=>$rating[$sqlapp[availability]],'independence'=>$rating[$sqlapp[independence]], 'reporting'=>$rating[$sqlapp[reporting]],'teamwork'=>$rating[$sqlapp[teamwork]],'supervisor'=>$sqlapp[supervisor],'appDate'=>$sqlapp[appDate]);
// echo "<br>Rate=$empId,$appId== $rate<br>";
  $rate=$rate/8;
	if($rate>=95) $rate=100;
	else if($rate>=85) $rate=90;
	else if($rate>=75) $rate=80;
	else $rate=50;
	
	$re[rate]=$rating[$rate];
	$re[summarize]=$sqlapp[summarize];	
  return $re;
}

function appraisal3($empId,$appId){
	$reason=array('1'=>'Annual','2'=>'Disciplinary action', '3'=>'Resign/Retirement/Layoff','4'=>'Unsatisfactory performance','5'=>'Probation period (quarterly)', '6'=>'Training need assessment','7'=>'New recruit (before attendance)','8'=>'Notable achievement','8'=>'Promotion (evaluate against 
     proposed designation)');
	$rating=array('101'=>'Excellent','100'=>'Good','50'=>'Improvement Needed','-400'=>'Unsatisfactory');

	global $db;
	
   $sql1="SELECT * FROM appraisal WHERE empId='$empId' AND appId='$appId' ORDER BY appDate DESC";
   $sqlQ1=mysqli_query($db, $sql1);
   $sqlapp=mysqli_fetch_array($sqlQ1);
   $rate=$sqlapp[quality]+$sqlapp[productivity]+$sqlapp[reliability]+$sqlapp[availability]+$sqlapp[independence]+$sqlapp[reporting]+$sqlapp[teamwork];
   
	$re= array("reason"=>$reason[$sqlapp[reason]],"quality"=>$rating[$sqlapp[quality]],"productivity"=>$rating[$sqlapp[productivity]], 'jobknowledge'=>$rating[$sqlapp[jobknowledge]],'reliability'=>$rating[$sqlapp[reliability]], 'availability'=>$rating[$sqlapp[availability]],'independence'=>$rating[$sqlapp[independence]], 'reporting'=>$rating[$sqlapp[reporting]],'teamwork'=>$rating[$sqlapp[teamwork]],'supervisor'=>$sqlapp[supervisor],'appDate'=>$sqlapp[appDate]);
// echo "<br>Rate=$empId,$appId== $rate<br>";
//   $rate=$rate/8;
	if($rate>=101) $rate=101; //excellent
	else if($rate<=50 && $rate>=0) $rate=50; //improvement needed
	else if($rate<0)$rate=-400; //unsatisfactory
	else if($rate<=100 && $rate>=51)$rate=100; //good
	
	$re[rate]=$rating[$rate];
	$re[summarize]=$sqlapp[summarize];
  return $re;
}



function empTransferRecord($empId,$searchDate=null,$boolean=false,$pcode=null,$limit=1){
	global $db;
	$sql="select reportDate,stayDate,transferTo from emptransfer where empId='$empId' and `status`='2' and stayDate!='0000-00-00'";
//if($pcode)$sql.=" and transferTo='$pcode' ";
	if($searchDate)$sql.=" and stayDate<='$searchDate' ";
	$sql.=" order by stayDate desc limit $limit ";
	$q=mysqli_query($db,$sql);
// if(mysqli_affected_rows($db)>0)
// 		echo $sql;

if($boolean==true)return mysqli_affected_rows($db)>0 ? true : false;
	if($limit==1)return mysqli_fetch_array($q);
	
	while($row[]=mysqli_fetch_array($q)){}
	return $row;
}



function getEmployeeByDesignation($designation){
	global $db;
	foreach($designation as $deseg){
		$match[]="designation like '$deseg'";
	}
	$allMatch=implode(" or ",$match);
	echo $sql="select * from employee where $allMatch order by designation";
	$q=mysqli_query($db,$sql);
	while($row=mysqli_fetch_array($q)){
		$employee[]=$row;
	}
	return $employee;
}

//check leave form that if employ is present then dont take entry, if absent or etc then take entry.
function checkAttandance($empId,$sdate,$edate){
	include("config.inc.php");
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 
	//$format="Y-m-j";
 	//$sdate = formatDate($d1,$format);
	//$edate = formatDate($d2,$format);

	$sqlf = "SELECT distinct action FROM `attendance` WHERE empId='$empId' AND `edate` between '$sdate' and '$edate' ";
	$sqlQ= mysqli_query($db, $sqlf);
	$empatt=array();
	$i=0;
	while($r=mysqli_fetch_array($sqlQ)){
										//echo $r['action'];
										//if($r['action']=='P') return '0'; else return '1';
										$empatt[$i]=$r['action'];
										$i++;
									  }
	if(in_array('P',$empatt)) return "notok"; else return "ok";
}

//check leave form ,it shows the dates and date status why they are not insert in the leave form becaus there is P or present

function showCheckedAttandanceEmp($empId,$sdate,$edate){
	include("config.inc.php");
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 
	//$format="Y-m-j";
 	//$sdate = formatDate($d1,$format);
	//$edate = formatDate($d2,$format);

	$sqlf = "SELECT * FROM `attendance` WHERE empId='$empId' AND `edate` between '$sdate' and '$edate' ";
	$sqlQ= mysqli_query($db, $sqlf);
	//echo $dd=mysqli_num_rows($sqlQ);
	echo "<table border=1><tr><th>Dates</th><th>Date Status</th></tr>";
	while($r=mysqli_fetch_array($sqlQ)){
	echo "<tr><td>".$r['edate']."</td><td>".$r['action']."</td></tr>";
	}
	echo "</table>";
}







function project_wholiday($pcode){
	global $db;
$sqlq=mysqli_query($db, "select wholiday from project where pcode='$pcode'");
$r=mysqli_fetch_array($sqlq);
return $r[wholiday];
}


/* return total emp  receive in a given period*/

function empdailyReceive($d,$item,$p){
//$d=formatDate($d,'Y-m-d');
 include("config.inc.php");
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

 $sql="SELECT COUNT(*) as totalReceive From emptransfer where designation='$item' AND reportDate<='$d' AND transferTo='$p'";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $totalReceive=$rr[totalReceive];
 return $totalReceive;

}


/*
function local_empdailyReceive($d,$item,$p){
 $sql="SELECT COUNT(*) as totalReceive From emplocal where designation='$item' AND type='monthly'  AND location='$p'";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $totalReceive=$rr[totalReceive];
 return $totalReceive;

}
*/


/* return total utilizatin of given designation */
function empactualReceive($d,$item,$p){global $db;
$sql="SELECT  attendance.empId,attendance.over1,attendance.over2,attendance.over3,attendance.over4, 
SUM((((attendance.over1*60+attendance.over2)-(attendance.over3*60+attendance.over4))*60)+60) as totalPresent, 
employee.designation 
FROM attendance,employee 
where attendance.location='$p' AND attendance.edate='$d' AND action in('P','HP') 
AND attendance.empId=employee.empId AND employee.designation='$item' 
group by employee.designation";

 $sqlQuery=mysqli_query($db, $sql);
 $sqlr=mysqli_fetch_array($sqlQuery);
// $rr=mysqli_num_rows($sqlQuery);
 $totalPresent=$sqlr[totalPresent];
 
$sqlb="SELECT  SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as totalBreak from  `emput`
 where  designation ='$item'  AND edate ='$d' AND pcode=$p AND iow='' AND siow='' 
 GROUP BY designation";
//echo $sql1;

 $sqlbq=mysqli_query($db, $sqlb);
 $sqlbr=mysqli_fetch_array($sqlbq);
 $totalBreak=$sqlbr[totalBreak];
 
 $actualPresent=abs($totalPresent)-abs($totalBreak);

  return abs($totalPresent);

}
function isSupervisor($empId){global $db;
//$sql="SELECT supervisor from iowtemp WHERE supervisor='$empId'";
$sql="SELECT supervisor from iow WHERE supervisor='$empId'";
//echo $sql;
$result=mysqli_query($db, $sql);
$num_rows = mysqli_num_rows($result);
//echo "num_rows=$num_rows<br>";
if($num_rows>=1) return 1;
 else return 0;

}

function supervisorDetails($supId){global $db;
$tt=explode('-',$supId);
//echo $supId.'<br>'.empName($tt[2]).'<br>'.hrDesignation("$tt[0]-$tt[1]-000");

$tt[2]=substr($tt[2],3);
echo $supId.', '.empName($tt[2]).', '.hrDesignation("$tt[0]-$tt[1]-$tt[2]");
}
function supervisorDetails_simple($supId){
$tt=explode('-',$supId);
//echo $supId.'<br>'.empName($tt[2]).'<br>'.hrDesignation("$tt[0]-$tt[1]-000");
echo empName($tt[2]).', '.hrDesignation("$tt[0]-$tt[1]-000");
}

function fullDesignationToEmpID($designation){
	$designationArr=explode("-",$designation);
	$lastOctet=substr($designationArr[2],3,strlen($designationArr[2]));
	
	return array($designationArr[0],$designationArr[1],$lastOctet);
}

function supervisorDetails_withcontact($supId){
global $db;
$tt=fullDesignationToEmpID($supId);
$sql="SELECT * from employee where empId='$tt[2]'";
$sqlq1=mysqli_query($db, $sql);
$re1=mysqli_fetch_array($sqlq1);

echo $re1['name'];
echo ", ";
echo hrDesignation("$tt[0]-$tt[1]-000").", ";
echo $re1['phone_office'] ? "Phone Office: <a href='tel:$re1[phone_office]'>".$re1['phone_office']."</a>, " : "";
	
echo $re1['phone_personal'] ? "Phone Personal:  <a href='tel:$re1[phone_personal]'>".$re1['phone_personal']."</a>, " : "";
	
echo $re1['email_office'] ? "Email Office: <a href='mailto:$re1[email_office]'>".$re1['email_office']."</a>, " : "";

echo $re1['email_personal'] ? "Email Personal:  <a href='mailto:$re1[email_personal]'>".$re1['email_personal']."</a>" : "";


}

function appStatus($appId){global $db;
$sql="SELECT astatus from appraisal WHERE appId='$appId'";
//echo $sql;
$sqlq=mysqli_query($db, $sql);
$r=mysqli_fetch_array($sqlq);
return $r[astatus];
}

function empType($empId){global $db;
$sql="SELECT salaryType from employee where empId='$empId'";
//echo $sql;
$sqlq=mysqli_query($db, $sql);
$r=mysqli_fetch_array($sqlq);
return $r[salaryType];
}


function totalIncrement($empId){global $db;
$sql="SELECT details from appaction where empId='$empId' AND action='4' Order by id DESC";
$sqlq=mysqli_query($db, $sql);
$r=mysqli_fetch_array($sqlq);
return $r[details];
}

function incentive($empId,$year,$month){global $db;
$sql="SELECT * from appaction where empId='$empId' AND action='6' AND '$year-$month-01' Between date1 AND date2 Order by id DESC";
$sqlq=mysqli_query($db, $sql);
$r=mysqli_fetch_array($sqlq);
return $r[details];
}

/*
INPUT: ItemCode
OUTPUR: basic
*/

function basic($itemCode ){global $db;
$sql="select startingBasic from jobdetails WHERE itemCode='$itemCode'";
//echo "<br>$sql<br>";
$sqlq=mysqli_query($db, $sql);
$sqlr=mysqli_fetch_array($sqlq);
return $sqlr[startingBasic];
}

/*
INPUT: ItemCode
OUTPUR: basic
*/

function empBasic($itemCode,$empId ){global $db;
$sql="select startingBasic,increment from jobdetails WHERE itemCode='$itemCode'";
//echo "<br>$sql<br>";
$sqlq=mysqli_query($db, $sql);
$sqlr=mysqli_fetch_array($sqlq);
$basic=$sqlr[startingBasic];
$increment=$sqlr[increment];
$totalIncrement=totalIncrement($empId);

return ($basic+($increment*$totalIncrement));
}

/*
INPUT: ItemCode
OUTPUR: basic
*/

function houseRent($itemCode,$basic){global $db;
$sql="select startingBasic,houseRent from jobdetails WHERE itemCode='$itemCode'";
//echo "<br>$sql<br>";
$sqlq=mysqli_query($db, $sql);
$sqlr=mysqli_fetch_array($sqlq);
$amount=($basic*$sqlr[houseRent])/100;

//$amount=($sqlr[startingBasic]*$sqlr[houseRent])/100;
return $amount;
}

/*
INPUT: ItemCode
OUTPUR: basic
*/

function medical($itemCode,$basic ){global $db;
$sql="select startingBasic,medical  from jobdetails WHERE itemCode='$itemCode'";
//echo "<br>$sql<br>";
$sqlq=mysqli_query($db, $sql);
$sqlr=mysqli_fetch_array($sqlq);
$amount=($basic*$sqlr[medical])/100;
return $amount;

}

/*
INPUT: ItemCode
OUTPUR: basic
*/

function convence($itemCode,$basic ){global $db;
$sql="select startingBasic,convence from jobdetails WHERE itemCode='$itemCode'";
//echo "<br>$sql<br>";
$sqlq=mysqli_query($db, $sql);
$sqlr=mysqli_fetch_array($sqlq);
$amount=($basic*$sqlr[convence])/100;
return $amount;

}

/*
INPUT: ATTENDANCE ID
OUTPUR: THAT DAY'S REMARKS
*/

function view_AttRemarks($attId){global $db;
if($attId=='') return '';
$sql="select remarks from attremarks WHERE attId='$attId'";
//echo "<br>$sql<br>";
$sqlq=mysqli_query($db, $sql);
$sqlr=mysqli_fetch_array($sqlq);
return $sqlr[remarks];
}

/*
INPUT: EMPLOYEE DESIGNATION AND BASIC SALARY
OUTPUT: HOUSE RENT PER MONTH
*/
function empHousRent($designation,$basic){global $db;
$sql="select (houseRent*$basic)/100 as houseRent from jobdetails WHERE itemCode='$designation'";
//echo "<br>$sql<br>";
$sqlq=mysqli_query($db, $sql);
$sqlr=mysqli_fetch_array($sqlq);

return $sqlr[houseRent];
}

/*
INPUT: EMPLOYEE DESIGNATION AND BASIC SALARY
OUTPUT: MEDIACL PER MONTH
*/


function empMedicalRent($designation,$basic){global $db;
$sql="select (medical*$basic)/100 as medical from jobdetails WHERE itemCode='$designation'";
//echo "<br>$sql<br>";
$sqlq=mysqli_query($db, $sql);
$sqlr=mysqli_fetch_array($sqlq);
return $sqlr[medical];
}

/*
INPUT: EMPLOYEE DESIGNATION AND BASIC SALARY
OUTPUT: CONVENCE PER MONTH
*/


function empConvenceRent($designation,$basic){global $db;
$sql="select (convence*$basic)/100 as convence from jobdetails WHERE itemCode='$designation'";
//echo "<br>$sql<br>";
$sqlq=mysqli_query($db, $sql);
$sqlr=mysqli_fetch_array($sqlq);
return $sqlr[convence];
}

/*
INPUT: PROJECT CODE AND DESIGNATION
OUTPUT: TOTAL HOUR AVAILABLE IN THAT PROJECT AND DESIGNATION
*/

function emporderQty($project,$itemCode){global $db;
$sql="select SUM((to_days(stayDate)-to_days(reportDate))+1) as duration FROM emptransfer 
WHERE transferTo='$project' AND designation='$itemCode'";
//echo $sql;
$sqlq=mysqli_query($db, $sql);
$emp=mysqli_fetch_array($sqlq);
$totalPo=$emp[duration];

return $totalPo*8;
}



/*
INPUT: SIOW,ITEMCODE,ATE,PROJECT CODE
OUTPUT: PER DAY REQUERMENT OF THAT SIOW
*/
function emp_perdayRequired($siow,$itemCode,$dat,$pp){
 $siowDaysGan=siowDaysGan($siow,$dat);

 if($siowDaysGan==0){ 
 $approvedQty=approvedQty($siow,$itemCode)*3600;
 $siowDuration=siowDuration($siow);

 $issuedQty= empTotalWorkhrsiow($itemCode,$dat,$siow);//issuedQty1($siow,$itemCode,$pp);
 $remainQty= $approvedQty-$issuedQty; 
 $siowPerDayReq=siowdmaPerDay($siowDuration,$remainQty);
  return  $siowPerDayReq;
 }
 else if($siowDaysGan>0){
    $siowDaysRem=siowDaysRem($siow,$dat); 
	if($siowDaysRem>0){
		$approvedQty=approvedQty($siow,$itemCode)*3600;
 $issuedQty= empTotalWorkhrsiow($itemCode,$dat,$siow);//issuedQty1($siow,$itemCode,$pp);
		$remainQty= $approvedQty-$issuedQty; 
		$siowPerDayReq=siowdmaPerDay($siowDaysRem,$remainQty);
        return  $siowPerDayReq;
		}//remain
	else {
		$approvedQty=approvedQty($siow,$itemCode)*3600;
 $issuedQty= empTotalWorkhrsiow($itemCode,$dat,$siow);//issuedQty1($siow,$itemCode,$pp);
		$remainQty= $approvedQty-$issuedQty; 	
		$siowPerDayReq=$remainQty;
        return  $siowPerDayReq;
	}		
 } 
}


/*
INPUT: EMPLOYEE ID
OUTPUT: DISPATCH DATE
*/
function empStayDate($empId){global $db;
$sql="SELECT stayDate from emptransfer where empId='$empId' AND status='2' ORDER BY tid DESC";
//echo $sql;
$sqlq=mysqli_query($db, $sql);
$sqlr=mysqli_fetch_array($sqlq);
return $sqlr[stayDate];
}


/*
INPUT: EMPLOYEE ID, Designation
OUTPUT: EMPLOYEE Satydate DATE
*/
function empStayDesigntaionDate($empId,$empDesig){
global $db;
$sql="SELECT stayDate from emptransfer where empId='$empId' AND status='2' AND designation='$empDesig' ORDER BY tid DESC";
//echo $sql;
$sqlq=mysqli_query($db, $sql);
$sqlr=mysqli_fetch_array($sqlq);
if(mysqli_affected_rows($db)<0){
	return date("Y-m-d", strtotime("-1 day"));
}
return $sqlr[stayDate];
}

/*
INPUT: EMPLOYEE ID
OUTPUT: REPORT DATE
*/
function empReportDate($empId){global $db;
$sql="SELECT reportDate from emptransfer where empId='$empId' AND status='2' ORDER BY tid DESC";
//echo $sql;
$sqlq=mysqli_query($db, $sql);
$sqlr=mysqli_fetch_array($sqlq);
return $sqlr[reportDate];
}

/*
INPUT: EMPLOYEE ID, ITEMCODE, DATE, STIME, ETIME,EMPLOYEE TYPE
OUTPUT: TRUE IF CONFLICT OR FALSE IF NOT CONFLICT IN GIVEN TIME PERIOD
*/
function emp_isUtilized($empId,$itemCode,$dat,$t1,$t2,$empType){

 include("config.inc.php");
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

 $sql="SELECT * FROM `emput` WHERE empId='$empId' AND designation='$itemCode'
  AND edate='$dat' AND empType='$empType' AND ((TIME_TO_SEC(stime) BETWEEN TIME_TO_SEC('$t1') AND TIME_TO_SEC('$t2')) 
  OR (TIME_TO_SEC(stime)<= TIME_TO_SEC('$t1') AND TIME_TO_SEC(etime) >= TIME_TO_SEC('$t1'))) ORDER by id ";

//echo "<br>$sql<br>";
$sqlQuery=mysqli_query($db, $sql);
$num_rows = mysqli_num_rows($sqlQuery);
if($num_rows>=1) return 1;
 else return 0;
}

function isConflictUtilizedAtt($asId,$itemCode,$dat,$t1,$t2,$empType){

 include("config.inc.php");
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

$sql = "SELECT MIN(stime) as stime,MAX(etime) as etime  FROM `emput` 
 WHERE empId='$asId' AND designation='$itemCode' 
 AND edate='$dat' AND empType='$empType' GROUP by edate";

 $sqlQuery=mysqli_query($db, $sql);
$nu = mysqli_fetch_array($sqlQuery);

 $sql2="SELECT 
 TIME_TO_SEC('$nu[stime]')-TIME_TO_SEC('$t1') as err1, 
 TIME_TO_SEC('$t2')-TIME_TO_SEC('$nu[etime]') as err2  
 FROM `emput` WHERE empId='$asId' AND designation='$itemCode' 
 AND edate='$dat' AND empType='$empType' GROUP by edate";
//echo $sql2.'<br>';
 $sqlQuery2=mysqli_query($db, $sql2);
$nu2 = mysqli_fetch_array($sqlQuery2);


if($nu2[err1]<0 OR $nu2[err2]<0)
//echo "<br>num_rows: $num_rows<br>";
 return 1;
 else return 0;
 }

/*
INPUT: ITEMCODE, IOW,SIOW
OUTPUT: REMAINING HOUR 
*/
function empRemainHr($itemCode,$iow,$siow){
if($iow AND $siow){
 include("config.inc.php");
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

 $sql="SELECT dmaQty From dma where dmaiow='$iow' AND dmasiow='$siow' AND dmaItemCode='$itemCode'";
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $dmaQty=$rr[dmaQty]*3600;

 $sql1="SELECT SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as duration".
 " FROM `emput` WHERE designation = '$itemCode' AND iow='$iow' AND siow='$siow'";

 $sqlQuery1=mysqli_query($db, $sql1);
 $rr1=mysqli_fetch_array($sqlQuery1);
 $totalWork = $rr1[duration]; 
 $remainingQty=$dmaQty-$totalWork;
 return round($remainingQty); 
  }
  else return 100000;
 }

/*---------------------------------
INPUT: project Code and LEAVE Status
OUTPUT:  total LEAVE in given Status and Project
---------------------------------*/
function countLeave($p,$project){
if($p==0){
$sql="SELECT count(leave.id) as total 
 FROM `leave`, `employee` WHERE leave.empId=employee.empId AND location='$project' 
 AND leave.status=$p ";
}
else   $sql="SELECT count(id) as total FROM `leave` WHERE status=$p"; 
//echo "$sql<br>";

	include("config.inc.php");
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);

return $rr[total];
}

/*--------------------------------
INPUT: employee ID, LEAVE START DATE AND LEAVE END DATE
OUTPUT: TRUE IF NOT CONFLICT OR FALSE IF CONFLICT
---------------------------------*/
function leaveConflict($empId,$sd,$ed){global $db;
$leave=0;
 $sqlf = "SELECT * FROM `attendance` WHERE empId='$empId' AND
  edate between '$sd' AND '$ed' AND action not in ('A','HA')";
// echo "<br>$sqlf<br>";
 $sqlQ= mysqli_query($db, $sqlf);
 $sqlr=mysqli_num_rows($sqlQ);
 if($sqlr>=1) return 0;
 else return 1;
}

/*--------------------------------
INPUT: employee ID
OUTPUT: total Leave taken
---------------------------------*/
function leaveTaken($empId){global $db;
$leave=0;
 $sqlf = "SELECT SUM(leavePeriod) as leaveTaken FROM `leave` WHERE empId='$empId' AND status=3";
//echo $sqlf.'<br>';

$sqlQ= mysqli_query($db, $sqlf);
$sqlRunf= mysqli_fetch_array($sqlQ);
if($sqlRunf[leaveTaken]) $leave=$sqlRunf[leaveTaken];
return $leave;
}

/*--------------------------------
enter employee ID
return is Present?
---------------------------------*/
function isPresent($empId,$df){
global $db;
 $sqlf = "SELECT * FROM `attendance` WHERE empId='$empId' AND edate='$df' AND action='P'";
//echo $sqlf.'<br>';
$sqlQ= mysqli_query($db, $sqlf);
$num_rows = mysqli_num_rows($sqlQ);
 return $num_rows;
}

/*--------------------------------
INPUT: employee ID
OUTPUT: ACTION (A,P,L,HA,HP) // absent, present, leave, holiday absent, holiday present
---------------------------------*/
function emp_daily_att($empId,$df){
global $db;
 $sqlf = "SELECT action FROM `attendance` WHERE empId='$empId' AND edate='$df' ";
 $sqlQ= mysqli_query($db, $sqlf);
 $num_rows = mysqli_num_rows($sqlQ);
  
  if($num_rows){
  $r=mysqli_fetch_array($sqlQ);
  return $r[action];
}
else return "0";
}

/*--------------------------------
enter employee ID
return is Present?
---------------------------------*/
function isPresent_local($empId,$df){
global $db;
 $sqlf = "SELECT * FROM `emplocalatt` WHERE empId='$empId' AND edat='$df' ";
//echo $sqlf.'<br>';
$sqlQ= mysqli_query($db, $sqlf);
$num_rows = mysqli_num_rows($sqlQ);
 return $num_rows;
}

/*--------------------------------
enter employee ID
return is HOLIDAY Present?
---------------------------------*/
function isHPresent($empId,$df){global $db;
$sqlf = "SELECT * FROM `attendance` WHERE empId='$empId' AND edate='$df' AND action='HP'";
$sqlQ= mysqli_query($db, $sqlf);
$num_rows = mysqli_num_rows($sqlQ);
return $num_rows;
}

/*--------------------------------
enter employee ID
return is LEAVE?
---------------------------------*/
function isLeave($empId,$df){global $db;
$sqlf = "SELECT * FROM `attendance` WHERE empId='$empId' AND edate='$df' AND action='L'";
$sqlQ= mysqli_query($db, $sqlf);
$num_rows = mysqli_num_rows($sqlQ);
return $num_rows;
}

/*--------------------------------
enter employee ID
return is ABSENT
---------------------------------*/
function isAbsent($empId,$df){global $db;
$sqlf = "SELECT * FROM `attendance` WHERE empId='$empId' AND edate='$df' AND action='A'";
$sqlQ= mysqli_query($db, $sqlf);
$num_rows = mysqli_num_rows($sqlQ);
return $num_rows;
}

/*--------------------------------
enter employee ID, MONTH, PROJECT CODE
return total MONTHLY Present
---------------------------------*/
function emp_monthlyPresent_project($empId,$month,$year,$pcode){global $db;
//$year=thisYear();
$sdate="$year-$month-01";
$daysofmonth = daysofmonth($sdate);
$edate="$year-$month-$daysofmonth";

 $sqlf = "SELECT * FROM `attendance` WHERE 
 empId='$empId' AND edate BETWEEN '$sdate' AND  '$edate'
  AND action='P' AND location='$pcode'";
// echo $sqlf.'<br>';
$sqlQ= mysqli_query($db, $sqlf);
$num_rows = mysqli_num_rows($sqlQ);

 return $num_rows;
}

/*--------------------------------
enter employee ID, MONTH, PROJECT CODE
return total MONTHLY stay in project
---------------------------------*/
function emp_monthlyStay_project($empId,$month,$year,$pcode,$presentOnly=false){
global $db;
//$year=thisYear();
$sdate="$year-$month-01";
$daysofmonth = daysofmonth($sdate);
$edate="$year-$month-$daysofmonth";

$sqlf = "SELECT * FROM `attendance` WHERE 
	empId='$empId' AND edate BETWEEN '$sdate' AND  '$edate'
	AND location='$pcode' ";
if($presentOnly)
	$sqlf.=" and action in ('P','HP','HA') ";
// echo $sqlf.'<br>';
$sqlQ= mysqli_query($db, $sqlf);
$num_rows = mysqli_num_rows($sqlQ);
return $num_rows;
}
function isTerminatedBefore($empId,$month,$year){
	global $db;
	$released=getReleasedDate($empId);
	if($released){
		$releasedArr=explode("-",$released);
		if($releasedArr[0]<=$year && $releasedArr[1]<$month)
			return true;
	}
	return false;
}
/*--------------------------------
enter employee ID, MONTH, PROJECT CODE
return total MONTHLY ABSENT
---------------------------------*/
function emp_monthlyAbsent_project($empId,$month,$year,$pcode){global $db;
//$year=thisYear();
$sdate="$year-$month-01";
$daysofmonth = daysofmonth($sdate);
$released=getReleasedDate($empId);

$edate="$year-$month-$daysofmonth";
if($released){
	$releasedArr=explode("-",$released);
	$releasedYearMonth=$releasedArr[0]."-".$releasedArr[1];
	if($releasedYearMonth==$year."-".$month)
		$edate=date("Y-m-d",strtotime($released)-86400);
}

 $sqlf = "SELECT * FROM `attendance` WHERE 
 empId='$empId' AND edate BETWEEN '$sdate' AND  '$edate'
  AND action='A' AND location='$pcode'";
// echo $sqlf.'<br>';
$sqlQ= mysqli_query($db, $sqlf);
$num_rows = mysqli_num_rows($sqlQ);
if($num_rows<10) $num_rows="0$num_rows";
 return $num_rows;
}
function getReleasedDate($empID){
	global $db;
	$sql="select date1 from appaction where empId='$empID' and actionStatus='0'";
// 	echo $sql;
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row[date1];
}
function isEmployeeReleased($empID){
	global $db;
	$sql="select date1 from appaction where empId='$empID' and actionStatus='0'";
// 	echo $sql;
	$q=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($q);
	return $row[date1] ? true : false;
}
/*--------------------------------
enter employee ID, MONTH, PROJECT CODE
return total MONTHLY ABSENT
---------------------------------*/
function emp_monthlyHoliday_project($empId,$month,$year,$pcode){global $db;
//$year=thisYear();
$sdate="$year-$month-01";
$daysofmonth = daysofmonth($sdate);
$edate="$year-$month-$daysofmonth";

 $sqlf = "SELECT * FROM `attendance` WHERE 
 empId='$empId' AND edate BETWEEN '$sdate' AND  '$edate'
  AND action='HP' AND location='$pcode'";
//echo $sqlf.'<br>';
$sqlQ= mysqli_query($db, $sqlf);
$num_rows = mysqli_num_rows($sqlQ);
if($num_rows<10) $num_rows="0$num_rows";
 return $num_rows;
}

/*--------------------------------
enter employee ID, MONTH, PROJECT CODE
return total MONTHLY LEAVE
---------------------------------*/
function emp_monthlyLeave_project($empId,$month,$year,$pcode){global $db;
//$year=thisYear();
$sdate="$year-$month-01";
$daysofmonth = daysofmonth($sdate);
$edate="$year-$month-$daysofmonth";

 $sqlf = "SELECT * FROM `attendance` WHERE 
 empId='$empId' AND edate BETWEEN '$sdate' AND  '$edate'
  AND action='L' AND location='$pcode'";
//echo $sqlf.'<br>';
$sqlQ= mysqli_query($db, $sqlf);
$num_rows = mysqli_num_rows($sqlQ);
if($num_rows<10) $num_rows="0$num_rows";
 return $num_rows;
}


/*--------------------------------
enter employee ID
return total Leave taken
---------------------------------*/
/*
function monthlyleaveTaken($empId,$month){
$leaveday=array();
$leaveDays=0;
$month1 = $month; // Month
$month2 = $month1+1; // Month
$year1 = 2006; // Year
$year2 = $year1; // Year
if($month1==12) {$month2=1;$year2 = 2007;} // Year
$days= (int)(mktime (0,0,0,$month2,1,$year2)-mktime (0,0,0,$month1,1,$year1))/86400;
$sdate=date("Y-m-j",mktime (0,0,0,$month1,1,$year1));
$edate=date("Y-m-j",mktime (0,0,0,$month2,1,$year2));


 $sqlf = "SELECT * FROM `leave` WHERE empId='$empId' and (sdate>='$sdate' OR edate<='$edate')";
//echo $sqlf.'a<br>';
$sqlQ= mysqli_query($db, $sqlf);
$j=0;
	while($sqlRunf= mysqli_fetch_array($sqlQ))
	{
		$d1=$sqlRunf[sdate];
		$d2=$sqlRunf[edate];
		$d=(strtotime($d2)-strtotime($d1))/86400;
		$d0=strtotime($sqlRunf[sdate]);
		for($i=0;$i<=$d;$i++,$j++)
		{ 
		$leaveday[$j]=date("Y-m-j",$d0);
		$d0+=86400;
		}
		
	}

//print_r($leaveday);

//echo $days.'<br>';
for($i=1;$i<=$days;$i++){
  $df=date('Y-m-j',mktime (0,0,0,$month1,$i,$year1));  
  foreach ($leaveday as $value) {   if($value==$df) $leaveDays++;		}
 }//for
//echo $workDays;
return $leaveDays;
}
*/

// not update
/*--------------------------------

---------------------------------*/
function locDays($empId,$month){global $db;
$leave=0;
$loc=array();
$rep=array();
 $sqlf = "SELECT * FROM `emptransfer` WHERE empId='$empId' ORDER by tid DESC ";
//echo $sqlf.'<br>';
$sqlQ= mysqli_query($db, $sqlf);
$i=1;
while($rr=mysqli_fetch_array($sqlQ)){
$loc[$i]=$rr[transferTo];
$rep[$i]=$rr[reportDate];
$i++;
}
print_r($loc);
print_r($rep);
return $loc;
}

// not update
/*--------------------------------
enter employee ID
return is leave
---------------------------------*/
function isLeave1($empId,$df,$month){
global $db;
$leaveday=array();
$leaveDays=0;
$month1 = $month; // Month
$month2 = $month1+1; // Month
$year1 = 2006; // Year
$year2 = $year1; // Year
if($month1==12) {$month2=1;$year2 = 2007;} // Year
$days= (int)(mktime (0,0,0,$month2,1,$year2)-mktime (0,0,0,$month1,1,$year1))/86400;
$sdate=date("Y-m-j",mktime (0,0,0,$month1,1,$year1));
$edate=date("Y-m-j",mktime (0,0,0,$month2,1,$year2));


 $sqlf = "SELECT * FROM `leave` WHERE empId='$empId' and (sdate>='$sdate' OR edate<='$edate')";
//echo $sqlf.'a<br>';
$sqlQ= mysqli_query($db, $sqlf);
$j=0;
	while($sqlRunf= mysqli_fetch_array($sqlQ))
	{
		$d1=$sqlRunf[sdate];
		$d2=$sqlRunf[edate];
		$d=(strtotime($d2)-strtotime($d1))/86400;
		$d0=strtotime($sqlRunf[sdate]);
		for($i=0;$i<=$d;$i++,$j++)
		{ 
		$leaveday[$j]=date("Y-m-j",$d0);
		$d0+=86400;
		}	
	}
	//print_r($leaveday);

foreach ($leaveday as $value) {
//echo "$value==$df<br><br>";
   if($value==$df) return 1;
 
}
//echo '++++++++++++'.sizeof($leaveday);
 return 0;
}


/*--------------------------------
enter DATE and pcode
return is Holiday
---------------------------------*/
function isHoliday($df,$pcode='000'){
 include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 
		
$sql2="select hdate from projectcalender where hdate='$df' AND pcode='$pcode'";
//echo "$sql2<br>";
$sqlq2=mysqli_query($db, $sql2);
$r=mysqli_num_rows($sqlq2);
if($r>0) return 1;

$wholiday=project_wholiday($pcode);

$t=date("D", strtotime($df));
  
if($t=="Sat" && $pcode=="000")return 1; //sat special holiday for head office.

//echo "$t==$df<br>";
if($t==$wholiday) return 1;

}

/*
function isHoliday($df){
$holiday=array('2008-02-21','2008-03-26','2008-04-14','2008-05-01','2008-08-17',
'2008-08-24','2008-09-28','2008-10-01','2008-10-02','2008-10-09','2008-12-08',
'2008-12-09','2008-12-10','2008-12-16','2008-12-25');

 $t=date("D", strtotime($df));
//echo "$t==$df<br>";
if($t=='Fri') $t1=1; else $t1=0;
//echo "<br>**********************<br>";
foreach ($holiday as $value) {
// echo "<br>$value==$df<br>";
   if(strtotime($value)==strtotime($df)) {$t2=1;  break;}
}
if($t1 || $t2)  $a=1;  else $a=0;
//elseif($t2)  $a=2;
//echo $a;
//echo "<br> $df *$a*<br>";
return $a;
}
*/

/*--------------------------------
enter DATE
return is Holiday LOCALY
---------------------------------*/
function isHolidaySite($df,$pcode){global $db;
	return isHoliday($df,$pcode);
/*	
$holiday=array('2008-02-21','2008-03-26','2008-04-14','2008-05-01','2008-08-17',
'2008-08-24','2008-09-28','2008-10-01','2008-10-02','2008-10-09','2008-12-08',
'2008-12-09','2008-12-10','2008-12-16','2008-12-25');

foreach ($holiday as $value) {
   if($value==$df) $t2=1; 
}
if($t2)  $a=1;
//elseif($t2)  $a=2;
 else $a=0;
return $a;
*/
}


/* not update */
/*--------------------------------
enter starting Date and End Date
return is Total working Date
---------------------------------*/
function site_totalWork($sf,$df,$project){global $db;
//echo "$sf,$df";
$a=0;
$startDate=strtotime($sf);
$endDate=strtotime($df);
$duration=($endDate-$startDate)/(24*3600); // days

for($i=0; $i<=$duration;$i++)
  { 
   $t=isHolidaySite(date("Y-m-j",$startDate),$project);  
   $startDate=$startDate+(24*3600);
   if(!$t) $a++;
  }
return $a;
}

/*--------------------------------
enter month and year
return is Total working Date  of that month in that year
---------------------------------*/
function monthlyWork($month,$year,$project='000'){global $db;
/*
$month1 = $month; // Month
$month2 = $month1+1; // Month
$year1 = 2006; // Year
$year2 = $year1; // Year
if($month1==12) {$month2=1;$year2 = 2007;} // Year
$workDays=0;

$days= (int)(mktime (0,0,0,$month2,1,$year2)-mktime (0,0,0,$month1,1,$year1))/86400;
echo $days.'<br>';
*/
$sd="$year-$month-01";
//echo "*************$sd";
$days= daysofmonth($sd);
//echo ">>$days";
for($i=1;$i<=$days;$i++){
  //if(date('D',mktime (0,0,0,$month1,$i,$year1))!='Fri') 
  $df=date('Y-m-j',mktime (0,0,0,$month,$i,$year));
//  echo '='.date('Y-m-j',mktime (0,0,0,$month1,$i,$year1));
//echo " $df<br>";
  if(!isHoliday($df,$project)) { $workDays++;}

}
//echo $workDays;
return $workDays;
}

/*--------------------------------
enter employee ID
return total Leave
---------------------------------*/
function totalLeave($empId,$fromdat,$todat){
  global $db;
  $leave=0;
  //$fromdat=thisYear().'-01-01';
   $sqlf = "SELECT id FROM `attendance` 
   WHERE empId='$empId' AND edate BETWEEN '$fromdat' AND '$todat' AND action='L'";
//   echo $sqlf.'<br>';
  $sqlQ= mysqli_query($db, $sqlf);
  $num_rows = mysqli_num_rows($sqlQ);
  return $num_rows;
}

function leaveType($type,$revers=0){
	if($revers==1){
		switch($type){
			case 'CASUAL':
				return 1;
			case 'SICK':
				return 2;
			case 'EARNED':
				return null;
			default:
				return -1;
		}
	}
	
	
	if($type==1)
		return 'CASUAL';
	else if($type==2)
		return 'SICK';
	else
		return 'EARNED';
}


/*--------------------------------
enter employee ID
return total Leave Splitly
1 = casual
2 = sick
null= earned

---------------------------------*/
// test leave id 2372
function LeaveSplitly($empId,$fromdat,$todat,$type){

  global $db;
  $leave=0;
  // $fromdat=thisYear().'-01-01';
  $fromdat=date("Y",strtotime($fromdat));
  //  $sqlf = "SELECT id FROM `attendance` 
  //  WHERE empId='$empId' AND edate BETWEEN '$fromdat' AND '$todat' AND action='L'";
  //echo $sqlf.'<br>';
  $sqlf="SELECT l.*,e.empId,e.name,e.designation,sum(leavePeriod) as rows FROM `leave` as l,employee as e WHERE l.empId=e.empId and l.leaveApplied='$type' and l.edate like '".$fromdat."%' and l.status in (4,3) and e.empId=".$empId;
  	// echo $sqlf;

  $sqlQ= mysqli_query($db, $sqlf);

  //   $num_rows = mysqli_num_rows($sqlQ);  
//   return $num_rows;
  while($row=mysqli_fetch_array($sqlQ)){
     $total+=$row["rows"];
  }
//   print_r($row);
  return $total;
}

/*--------------------------------
enter employee ID
return TOTAL HOLIDAY Present
---------------------------------*/
function totalHolidatWork($empId,$fromdat,$todat){global $db;
$sqlf = "SELECT * FROM `attendance` 
WHERE empId='$empId' AND edate BETWEEN '$fromdat' AND '$todat' AND action='HP'";
$sqlQ= mysqli_query($db, $sqlf);
$rn=mysqli_num_rows($sqlQ);
return $rn;
}

/*--------------------------------
enter employee ID
return joining date in BFEW
---------------------------------*/
function empJoinDate($empId){global $db;
$leave=0;
 $sqlf = "SELECT empDate FROM `employee` WHERE empId='$empId'";
//echo $sqlf.'<br>';

$sqlQ= mysqli_query($db, $sqlf);
$r = mysqli_fetch_array($sqlQ);
return $r[empDate];
}

/*--------------------------------
enter employee ID
return total absent
---------------------------------*/
function totalAbsent($empId,$fromdat,$todat){
global $db;
$sqlf = "SELECT id FROM `attendance` 
WHERE empId='$empId' AND edate BETWEEN '$fromdat' AND '$todat' AND action='A'";
//echo $sqlf.'<br>';

$sqlQ= mysqli_query($db, $sqlf);
$num_rows = mysqli_num_rows($sqlQ);

return $num_rows;
}

/* ---------------------------
 Input employee joining Date
 return total year working in BFEW
------------------------------*/
function dailyPresent($e,$x){global $db;
$enter=strtotime($e);
$exit=strtotime($x);
$work= abs($exit-$enter)/3600;
return $work;
}

/* ---------------------------
 Input employee joining Date
 return total year working in BFEW
------------------------------*/
function workYear($y){
$now= time();
$join=strtotime($y);
$work= ($now-$join)/(3600*24*365);
return round($work);
}


/* ---------------------------
 Input EMPLOYEE ID
 return ARRAY of transfer information
------------------------------*/

function empTransfer($p)
{
 include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

 $sql1=" SELECT * FROM emptransfer where empId= '$p' ORDER by tid DESC " ;
 //echo  $sql1;
 $sql=mysqli_query($db, $sql1) ;
 $pn=mysqli_fetch_array($sql);
 $empTransfer = array('transferFrom'=>$pn[transferFrom],'transferTo'=>$pn[transferTo],
 'reportDate'=>$pn[reportDate],'stayDate'=>$pn[stayDate],'status'=>$pn[status],'tid'=>$pn[tid]);
  return $empTransfer;
}
 
/* ---------------------------
  Input the hrCode Code
 return the designation and Name
-------------------------------*/

function hrName($p)
{
 include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 
$t=explode('-',$p);
$tt="$t[0]-$t[1]-000";
$sqlff="SELECT itemlist.itemDes,employee.name FROM itemlist,employee where itemlist.itemCode='$tt' AND empId='$p'";
echo $sqlff;
$sqlf=mysqli_query($db, $sqlff);
     $pn=mysqli_fetch_array($sqlf);
	 $hrNamef = array('designation'=>$pn[itemDes],'name'=>$pn[name]);
	 
	 return $hrNamef;
}
 

// not used
/* ---------------------------
Input the hrCode Code
 return the designation and Name
-------------------------------*/

function hrLocal($p)
{
global $db;
$tt="$t[0]-$t[1]-000";
$sqlff="SELECT itemlist.itemDes,localemp.name FROM itemlist,localemp where itemlist.itemCode='$tt' AND empId='$p'";
//echo $sqlff;
$sqlf=mysqli_query($db, $sqlff);
     $pn=mysqli_fetch_array($sqlf);
	 $hrNamef = array('designation'=>$pn[itemDes],'name'=>$pn[name]);	 
	 return $hrNamef;
}
  //hr Rate
function hrRate($hrCode){
	global $db;
	$hrf=explode('-',$hrCode);
	$searchCode=$hrf[0].'-'.$hrf[1];
	$sql=" SELECT AVG(salary+allowance)  as avgSalary  FROM `employee` WHERE `designation` LIKE '$hrCode'  and (edate like '".date("Y-")."%' or edate like '".(date("Y-")-1)."%') and location='$_SESSION[loginProject]'";
	// echo $sql;
	$sqlQuery=mysqli_query($db, $sql);
		$pn=mysqli_fetch_array($sqlQuery);
		$hrSalary = $pn[avgSalary]/(8);
		return round($hrSalary,3);
}


function hrRate_project($hrCode){
	global $db;
	$hrf=explode('-',$hrCode);
	$searchCode=$hrf[0].'-'.$hrf[1];
	$sql=" SELECT AVG(salary+allowance)  as avgSalary  FROM `employee` WHERE `designation` LIKE '$hrCode'  and (edate like '".date("Y-")."%' or edate like '".(date("Y-")-1)."%') and location='$_SESSION[loginProject]'";
	// echo $sql;
	$sqlQuery=mysqli_query($db, $sql);
		$pn=mysqli_fetch_array($sqlQuery);

		if($pn[avgSalary] < 2000){
			$hrSalary = $pn[avgSalary]/(8);
		}else{
			$hrSalary = $pn[avgSalary]/30/(8);
		}

		return round($hrSalary,3);
}

/*--------------------------------
enter employee ID
return is in LEAVE?
---------------------------------*/
function isLeave0($empId,$df){
global $db;
 $sqlf = "SELECT * FROM `leave` WHERE empId='$empId'";
//echo $sqlf.'<br>';
$sqlQ= mysqli_query($db, $sqlf);
	while($sqlRunf= mysqli_fetch_array($sqlQ))
	{
		$d1=$sqlRunf[sdate];
		$d2=$sqlRunf[edate];

		if($df>=$d1 AND $df<=$d2)	return 1;
	}
  return 0;
}

/*---------------------------------
INPUT: empID and Month
OUTPUT: Salary amount payable
---------------------------------*/
function currentWPayble($emp,$d,$p){

include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

 $sql=" SELECT SUM(amount)  as salary FROM `empsalary` WHERE empId='$emp' AND month='$d' AND glCode='2404000-$p'";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);

 $sql1=" SELECT SUM(amount)  as salaryadc FROM `empsalaryadc` WHERE empId='$emp' AND pmonth='$d'";
 //echo $sql;
 $sqlQuery1=mysqli_query($db, $sql1);
 $rr1=mysqli_fetch_array($sqlQuery1); 
 //echo $empId;
 return $rr[salary]+$rr1[salaryadc];
}


// not used
function isPayable_wages($empId,$fromD,$toD){
global $db;
$sqlquery="SELECT * FROM attendance WHERE 1 ".
"AND attendance.edate BETWEEN '$fromD' AND '$toD'".
" AND action in('P','HP') AND attendance.empId= $empId";
//echo $sqlquery.'<br>';
 $sql= mysqli_query($db, $sqlquery);
 $nubmer_row=mysqli_num_rows($sql);
//  echo "nubmer_row:$nubmer_row";
 if($nubmer_row>=1){
   $sqlquery1="SELECT empId FROM empsalary WHERE month='$fromD' AND empId=$empId";
//echo $sqlquery1.'<br>';
 $sql1= mysqli_query($db, $sqlquery1);
 $nubmer_row1=mysqli_num_rows($sql1); 
 //echo "nubmer_row1:$nubmer_row1";
 if($nubmer_row1>0) return 0;
 else return 1;
 }
 else return 0;
}


/*************************************
enter BASIC,DATE
return OVERTIME RATE HOURLY
************************************/
function otRate($basic,$month){
global $db;
//$daysofmonth = daysofmonth($month);
$daysofmonth = 30;
//echo "**daysofmonth=$daysofmonth**<br>";
// $otRate=2*($basic/($daysofmonth*8)); old rule 
$otRate=($basic/($daysofmonth*8));
$otRate*=2;

return round($otRate,2);
}

 
/*************************************
enter BASIC,DATE
return OVERTIME RATE SECOND
************************************/
function otRateSec($basic,$month){

$daysofmonth = daysofmonth($month);

//$otRate=(2*($basic/($daysofmonth*8)))/3600; old rule
$otRate=(($basic/($daysofmonth*8)))/3600;

return $otRate;
}


/*************************************
enter basic,allowance,month,present
return TOTAL MONTHLY NORMAL AMOUNT
************************************/
function normalDayAmount($basic,$allowance,$month,$present){

// $daysofmonth = 30;
$daysofmonth = daysofmonth($month);
$atRate=(($basic+$allowance)/$daysofmonth)*$present;
return round($atRate,2);
}


/*************************************
enter basic,allowance,month,present
return TOTAL MONTHLY NORMAL AMOUNT
************************************/
function normalDayAmountSec($basic,$allowance,$month){
$daysofmonth = daysofmonth($month);
$atRate=(($basic+$allowance)/($daysofmonth*8*3600));
return $atRate;
}

/*************************************
enter EMPLOYEE ID, DATE, TYPE, PROJECT
return DAILY CONSUMED WORK BREAK
************************************/
function dailyworkBreak($empId,$d,$empType,$pcode){
$work=0;;
$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
include($localPath."/includes/config.inc.php"); //datbase_connection
$sql1="SELECT  SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as total from  `emput`".
 " where  empId ='$empId' AND empType='$empType' AND edate ='$d' AND pcode=$pcode AND iow='' AND siow='' ";
// echo $sql1;
 $sqlQuery1=mysqli_query($db, $sql1);
 $remainQty1=mysqli_fetch_array($sqlQuery1);
 if($remainQty1['total']) 
   $work=$remainQty1['total'];
 return $work;
}

/*************************************
enter EMPLOYEE ID, DATE, TYPE, PROJECT
return DAILY TOTAL WORKED
************************************/

function dailywork($empId,$d,$empType,$pcode){
$work=0;;
$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
include($localPath."/includes/config.inc.php"); //datbase_connection
 $sql1="SELECT  SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as total from  `emput`".
 " where  empId ='$empId' AND empType='$empType' AND edate ='$d' AND pcode='$pcode' AND iow<>'' ";

	if($_GET["iowType"])$sql1.=" and iow in (select iowId from iow where iowType='$_GET[iowType]') ";

// 	echo $sql1;

 $sqlQuery1=mysqli_query($db, $sql1);
 $remainQty1=mysqli_fetch_array($sqlQuery1);
 if($remainQty1[total]) 
	 $work= $remainQty1[total];
 return $work;
}

/*************************************
enter EMPLOYEE ID, DATE, TYPE, PROJECT
return DAILY TOTAL WORKED in direct IOW
************************************/

function emp_direct_dailywork($empId,$d,$empType,$pcode){
$work=0;;
 include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

 $sql1="SELECT  SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as total from  `emput`,iow
 where  empId ='$empId' AND empType='$empType' 
 AND edate ='$d' AND pcode='$pcode' AND emput.iow=iow.iowId AND iow.iowType='1' ";

//echo "***$sql1***<br>";
 $sqlQuery1=mysqli_query($db, $sql1);
 $remainQty1=mysqli_fetch_array($sqlQuery1);
 if($remainQty1[total]) 
	 $work= $remainQty1[total];
 return $work;
}

// not used
/*---------------------------
input: 
output: 
---------------------------------*/

function local_emptotalwork($empId,$d,$empType,$pcode){
$work=0;;
 include("config.inc.php");
 //include("session.inc.php"); 
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 


 $sql1="SELECT  SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime))) as total from  `emput`".
 " where  empId ='$empId' AND empType='$empType' AND edate BETWEEN '2007-01-01'AND '$d' AND pcode=$pcode ";
//echo $sql1;
 $sqlQuery1=mysqli_query($db, $sql1);
 $remainQty1=mysqli_fetch_array($sqlQuery1);
  if($remainQty1[total]) 
 $work= $remainQty1[total];

 return $work;
}

//not used
/*---------------------------------
OUTPUT: 
---------------------------------*/
function localemp($p,$d){

 include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

 $sql=" SELECT designation FROM `localemp` WHERE location='$p' AND designation='$d'";
 echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $pn=mysqli_num_rows($sqlQuery)+1;
 
  if($pn < 10) $pn="00$pn";
  else if($pn < 100) $pn="0$pn";  


$tt=explode('-',$d);

 $empId=$tt[0].'-'.$tt[1].'-'.$pn.'-L';
//echo $empId;
return $empId;
}

/*--------------------------------
enter employee ID
return total Present
---------------------------------*/
function TotalPresentHr($sdate,$edate,$empId,$type){
	global $db;
 $sqlf = "SELECT id FROM `attendance` 
 WHERE empId='$empId' AND edate BETWEEN '$sdate' AND '$edate' AND action IN ('P','HP')";
//echo $sqlf.'<br>';

$sqlQ= mysqli_query($db, $sqlf);
$num_rows = mysqli_num_rows($sqlQ);
return $num_rows*8;
}

//not use
/*--------------------------------
enter employee ID
return total Present
---------------------------------*/
function local_TotalPresentHr($sdate,$edate,$empId,$type,$location){
global $db;
if($type=='H'){
 $sqlf = "SELECT id FROM `attendance` WHERE empId='$empId'".
 " AND edate BETWEEN '$sdate' AND '$edate'".
 " AND action IN ('P','HP') AND location='$location'";
//echo $sqlf.'<br>';

$sqlQ= mysqli_query($db, $sqlf);
$num_rows = mysqli_num_rows($sqlQ);
return $num_rows;
}//H
}

/*--------------------------------
enter employee ID
return total Present
---------------------------------*/
function totalPresent($empId,$fromdat,$todat){global $db;
$leave=0;
 $sqlf = "SELECT id FROM `attendance` 
 WHERE empId='$empId' AND edate BETWEEN '$fromdat' AND '$todat' AND action='P'";
//echo $sqlf.'<br>';

$sqlQ= mysqli_query($db, $sqlf);
$num_rows = mysqli_num_rows($sqlQ);
return $num_rows;
}

/*--------------------------------
enter starting Date and End Date
return is Total working Date
---------------------------------*/
function totalWork($sf,$df,$project='000'){global $db;
//echo "==$sf,$df==<br>";
$a=0;
$startDate=strtotime($sf);
$endDate=strtotime($df);

$duration=round((($endDate-$startDate)/(24*3600))); // days
//echo  "duration:$duration<br>";
for($i=0; $i<=$duration;$i++)
  { 
   $t=isHoliday(date("Y-m-j",$startDate),$project);  
  // echo date("Y-m-j",$startDate); 
   $startDate=$startDate+(24*3600);

   /*if(!$t){echo "W<br>"; $a++;}
   else echo "H<br>";*/
   if(!$t){$a++;}
  }
/*  echo "WW".$a."WW";
  exit;
  */
return $a;
}

/* ---------------------------
return salary 
-------------------------------*/

function hrSalary($p)
{global $db;
$sqlff="SELECT salary FROM employee where empId='$p'";
//echo $sqlff;
$sqlf=mysqli_query($db, $sqlff);
     $pn=mysqli_fetch_array($sqlf);
	 $hrSalary = $pn[salary]; 
	 return $hrSalary;
}
 
/* ---------------------------
return joining date in BFEW
-------------------------------*/

function hrJoinDate($p,$d)
{global $db;
 include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

$sqlff="SELECT empDate FROM employee where empId='$p' AND empDate <= '$d'";
//echo $sqlff;
$sqlf=mysqli_query($db, $sqlff);
     $pn=mysqli_fetch_array($sqlf);
	 $empDate = $pn[empDate]; 
	 return $empDate;
}
 
/*return employee designation text*/
function hrDesignation($p)
{
	global $db;
$sqlff="SELECT itemDes FROM itemlist where itemCode='$p'";
// echo $sqlff;
$sqlf=mysqli_query($db, $sqlff);
     $pn=mysqli_fetch_array($sqlf);
	 $hrDesignation=$pn[itemDes];	 
	 return $hrDesignation;
} 
/*return employee designation code*/
function getItemDesCode($p)
{
	global $db;
	$sqlff="SELECT itemcode FROM itemlist where itemDes='$p'";
	// echo $sqlff;
	$sqlf=mysqli_query($db, $sqlff);
	$pn=mysqli_fetch_array($sqlf);
	$hrDesignation=$pn[itemcode];
	return $hrDesignation;
}
 
/* ---------------------------
return employee designation code
-------------------------------*/

function hrDesignationCode($p)
{global $db;
$sqlff="SELECT designation FROM employee where empId='$p'";
//echo $sqlff;
$sqlf=mysqli_query($db, $sqlff);
     $pn=mysqli_fetch_array($sqlf);
	 $hrDesignationCode=$pn[designation];	 
	 return $hrDesignationCode;
}
 
/* ---------------------------
return employee name
-------------------------------*/

function empName($p)
{global $db;
$sqlff="SELECT name FROM employee where empId='$p'";
//echo $sqlff;
$sqlf=mysqli_query($db, $sqlff);
     $pn=mysqli_fetch_array($sqlf);
	 $empName=$pn[name];	 
	 return $empName;
}
 
/* not uese*/
/* ---------------------------
  Input the hrCode Code
 return the designation and Name
-------------------------------*/

function local_empName($p)
{
 include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 


$sqlff="SELECT name FROM emplocal where id='$p'";
//echo $sqlff;
$sqlf=mysqli_query($db, $sqlff);
     $pn=mysqli_fetch_array($sqlf);
	 $empName=$pn[name];	 
	 return $empName;
}
 
/* ---------------------------
return employee experience
------------------------------*/

function empExperience($p,$c)
{global $db;
$todat = todat();
if($c==1)$sqlff="SELECT (to_days('$todat')-to_days(creDate)) as duration  FROM employee where empId='$p'";//experience
if($c==2)$sqlff="SELECT (to_days('$todat')-to_days(empDate)) as duration  FROM employee where empId='$p'";//in BFEW
if($c==3)$sqlff="SELECT (to_days('$todat')-to_days(proDate)) as duration  FROM employee where empId='$p'";//in This Post
//echo $sqlff;
$sqlf=mysqli_query($db, $sqlff);
     $pn=mysqli_fetch_array($sqlf);

	 $experienceYear=intval($pn[duration] / 365);	 
	 $experienceMonth=intval(($pn[duration] % 365)/30);	 	 
	 return '<font class="out">'.$experienceYear.' Years '.$experienceMonth.' Months </font>';
}
 
/* ---------------------------
generate employee ID
-------------------------------*/

function empId($empId,$designation){
	$tempf=explode('-',$designation);

// 	if($empId<10) 
return "$tempf[0]-$tempf[1]-$tempf[2]$empId";
// 	else if($empId<100) return "$tempf[0]-$tempf[1]-000$empId";
// 	else if($empId<1000) return "$tempf[0]-$tempf[1]-00$empId";
// 	else if($empId<10000) return "$tempf[0]-$tempf[1]-0$empId";
// 	else return "$tempf[0]-$tempf[1]-$empId";
}
 
/* not used any more*/
/* ---------------------------
  Input the hrCode Code
 return the employee Id
-------------------------------*/

function local_empId($empId,$designation)
{

$tempf=explode('-',$designation);

if($empId<10) return "$tempf[0]-$tempf[1]-L0000$empId";
else if($empId<100) return "$tempf[0]-$tempf[1]-L000$empId";
else if($empId<1000) return "$tempf[0]-$tempf[1]-L00$empId";
else if($empId<10000) return "$tempf[0]-$tempf[1]-L0$empId";
else return "$tempf[0]-$tempf[1]-L$empId";
}
 
/* total worked in SIOW human  in a date*/
function empTodayWorksiow($itemCode,$dat,$siow){global $db;
 $sql="SELECT SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as duration 
 FROM `emput`  
 WHERE designation = '$itemCode' AND siow='$siow' AND edate='$dat' GROUP by edate";
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $totalRate = $rr[duration];
 return abs($totalRate);
 }
 /* total worked in SIOW human  till date*/
function empTotalWorksiow($itemCode,$siow,$d,$c){global $db;
if($c)// if c==1 then in a perticular day
{
 $sql="SELECT SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as duration 
 FROM `emput`  
 WHERE designation = '$itemCode' AND siow='$siow' AND edate='$d'";
}
else { // till given day
 $sql="SELECT SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as duration 
 FROM `emput`  
 WHERE designation = '$itemCode' AND siow='$siow' AND edate<='$d'";
 }
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $totalTime = $rr[duration];
 return abs($totalTime);
 }
 /* total worked in IOW human  till date*/
function empTotalWorkiow($itemCode,$iow,$d,$c){
global $db;
if($c) // if c==1 then in a particular day
{
 $sql="SELECT SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as duration 
 FROM `emput`  
 WHERE designation = '$itemCode' AND iow='$iow' AND edate='$d'";
}
else{ // till given day
 $sql="SELECT SUM(ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60)) as duration 
 FROM `emput` 
 WHERE designation = '$itemCode' AND iow='$iow' AND edate<='$d'";
}
//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 $totalTime = $rr[duration];
 return abs($totalTime);
 }
 /* return entrance and exit time in a day */
function empExTime($empId,$empType,$edate){global $db;

 $sql="SELECT HOUR(stime) as eh,MINUTE(stime) as em,HOUR(etime) as xh,MINUTE(etime) as xm 
 FROM `attendance` 
 WHERE empId= '$empId' AND edate='$edate'";

//echo $sql;
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
if($rr[eh]==0){
$eh=9;
$em=0;
$xh=0;
$xm=0;
}
else {
$eh=$rr[eh];
$em=$rr[em];
$xh=$rr[xh];
$xm=$rr[xm];

}
//echo "**$eh**";
if($eh<'10') $eh="0$eh";
if($em<'10') $em="0$em";
if($xh<'10') $xh="0$xh";
if($xm<'10') $xm="0$xm";

$empTime= array("eh"=>$eh,"em"=>$em,'xh'=>$xh,'xm'=>$xm);
//print_r($empTime);
	 return $empTime; 
 }

/* daily update apprisal status*/
function updateApp($todat){global $db;
$sql="SELECT * FROM appaction where actionStatus='0' and date1<='$todat'";
$sqlq=mysqli_query($db, $sql);
while($r=mysqli_fetch_array($sqlq)){
	if($r[action]=='6') {$sql_up="UPDATE appaction set actionStatus='1' where id='$r[id]'"; mysqli_query($db, $sql_up);}
	if($r[action]=='5') {$sql_up="UPDATE appaction set actionStatus='1' where id='$r[id]'"; mysqli_query($db, $sql_up);}
	if($r[action]=='4') {$sql_up="UPDATE appaction set actionStatus='1' where id='$r[id]'"; mysqli_query($db, $sql_up);}
	if($r[action]=='3') {
	 	$sql_up="UPDATE employee set designation='$r[details]' where empId='$r[empId]'"; mysqli_query($db, $sql_up);
		$sql_up="UPDATE appaction set actionStatus='1' where id='$r[id]'"; mysqli_query($db, $sql_up);
		}
	if($r[action]=='1'){
		$sqld="select date1 from appaction where id='$r[id]'";
		//echo "$sqld<br>";
		$sqlq2=mysqli_query($db, $sqld);
		$rr=mysqli_fetch_array($sqlq2);
		$dd=$rr[date1];
		$empId=$rr[empId];
 		$sql_up="DELETE from attendance where empId='$r[empId]' AND edate>'$dd'"; mysqli_query($db, $sql_up);

		$sql_up="UPDATE employee set status='-1', jobTer='$dd' where empId='$r[empId]'"; mysqli_query($db, $sql_up);		
		//echo "$sql_up<br>";
		$sql_up="UPDATE appaction set actionStatus='1' where id='$r[id]'"; mysqli_query($db, $sql_up);
		//echo "$sql_up<br>";
     /*  adjust tranfer start   */
		$sqld3="select tid from emptransfer where empId='$empId' ORDER by tid DESC";
		//echo "$sqld<br>";
		$sqlq3=mysqli_query($db, $sqld3);
		$rr3=mysqli_fetch_array($sqlq3);
		$tid=$rr[tid];
		
		
		$sql_up="UPDATE emptransfer set stayDate='$dd' where tid='$tid'"; mysqli_query($db, $sql_up);
		//echo "$sql_up<br>";
		     /*  adjust tranfer end   */
		}
	 else{ 		$sql_up="UPDATE appaction set actionStatus='1' where id='$r[id]'"; mysqli_query($db, $sql_up);}	
 }//while
}


/* update daily actions*/
function check($todat){
include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 

$sql= "SELECT detail FROM `keys` ORDER by func ASC";
//echo $sql;
$sqlq=mysqli_query($db, $sql);
$rr=mysqli_fetch_array($sqlq);
//echo strtotime($rr[detail])."<=". strtotime($todat);

if(strtotime($rr[detail])< strtotime($todat))
{
updateApp($todat);

$duration= (strtotime($todat)-strtotime($rr[detail]))/86400;
//echo "duration: ".$duration;

$sql="select * from employee where salaryType in ('Salary','Wages Monthly') AND status='0'";
$sqlqm=mysqli_query($db, $sql);
putenv ('TZ=Asia/Dacca'); 
while($re=mysqli_fetch_array($sqlqm)){
	 
for($i=0;$i<$duration;$i++){	 
$edate=date("Y-m-d",strtotime($rr[detail])+(86400*$i));
if(strtotime($edate)>=strtotime($re[empDate])){
if(isHoliday($edate,$re[location])){
 $sql="INSERT INTO attendance(`id` , `empId`, `edate` ,`action` , `stime` , `etime` , `todat` , `location` )".
 " VALUES ('', '$re[empId]', '$edate', 'HA','','','$todat','$re[location]' )";

}
else
 $sql="INSERT INTO attendance(`id` , `empId`, `edate` ,`action` , `stime` , `etime` , `todat` , `location` )".
 " VALUES ('', '$re[empId]', '$edate', 'A','','','$todat','$re[location]')";

//	 echo $sql.'<br>';
    $sqlq1=mysqli_query($db, $sql);
}//empdate	
      }//for
	}//while
	
//$sql="UPDATE keys set detail='$todat'";

$sqleq="SELECT eqid,assetId,itemCode FROM `equipment` WHERE location='002'";
//echo $sqleq;
$sqlqeq=mysqli_query($db, $sqleq);	
while($eq=mysqli_fetch_array($sqlqeq)){

if(eq_isPresent($eq[assetId],$eq[itemCode],$todat) OR eq_isHPresent($eq[assetId],$eq[itemCode],$todat)){
//echo 's';
;}
else 
{
$sql1="UPDATE equipment set location='004' where eqid=$eq[eqid]";
//echo $sql1;
mysqli_query($db, $sql1);
}
  }//whi;e
  
/**/
$sql="Select * FROM emptransfer WHERE reportDate<='$todat' AND status='0'";
//echo '<br>'.$sql.'<br>';
$sqlq= mysqli_query($db, $sql);
while($re=mysqli_fetch_array($sqlq)){
$sql1="UPDATE emptransfer set status='2' WHERE tId='$re[tid]'";
//echo '<br>'.$sql1.'<br>';
$sqlq1 = mysqli_query($db, $sql1);

$sql2="UPDATE employee set location='$re[transferTo]' WHERE empId='$re[empId]'";
//echo '<br>'.$sql2.'<br>';
$sqlq2 = mysqli_query($db, $sql2);
$sql21="UPDATE user set projectCode='$re[transferTo]' WHERE id='$re[empId]'";
//echo '<br>'.$sql2.'<br>';
mysqli_query($db, $sql21);

}

/**/  
/*Equipment Dispatch start*/
eq_force_dispatch($todat);
/* end*/
/*Equipment AutoAttendance start*/ 
 eq_autoAttendance($todat,$rr[detail]);
/* end*/ 
$sql= "UPDATE `keys` SET `detail` = '$todat' WHERE `func` = 'aaa' ";
$sqlq=mysqli_query($db, $sql);
//echo $sql;
  }	//if

}
 
/* return total hour present in a day*/
function toDaypresent($empId,$edate,$empType){
global $db;
 $sql="SELECT ABS(TIME_TO_SEC(etime)-TIME_TO_SEC(stime)+60) as duration 
 FROM `attendance` 
 WHERE empId= '$empId' AND edate='$edate'";
//echo $sql;	

	
 $sqlQuery=mysqli_query($db, $sql);
 $rr=mysqli_fetch_array($sqlQuery);
 if($rr){

$empTime= $rr[duration];
return $empTime;
}
else return 0;
}

 
/* without pay amount */
function withoutPay($empId,$month,$year,$pcode,$pay="0")
{
	include("config.inc.php");
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

		$dt="$year-$month-01";
		$days=daysofmonth($dt);
		//echo $days;
		$sdate1="$year-$month-01";
		$edate1="$year-$month-$days";

	$sqlq=" SELECT SUM(withoutPay) as withoutPay,sum(pay) as pay FROM `leave` 
	where empId='$empId' AND (sdate between '$sdate1' AND '$edate1') 
	 AND status='3' AND pcode like '$pcode'" ;
	if($pay=="0")$sqlq.=" AND withoutPay>0 ";
	if($pay=="1")$sqlq.=" AND pay>0 ";
// echo  $sqlq.'<br>';
	$sql=mysqli_query($db, $sqlq); 
	$pn=mysqli_fetch_array($sql);
	if($pay=="1"){
		if($pn[pay]==null && $pn[withoutPay]==null)
		{	
			$sqlq=" SELECT sum(leavePeriod) as pay FROM `leave` 
	where empId='$empId' AND (sdate between '$sdate1' AND '$edate1') 
	 AND status='3' AND pcode='$pcode'" ;
// 			echo $sqlq;
			$sql=mysqli_query($db, $sqlq); 
			$pn=mysqli_fetch_array($sql);
		}
		return $pn[pay];
	}
  return $pn[withoutPay];
   }


/* without pay amount
   $type_cs = casual(1) or sick(2)
*/

function withoutPay_yearly($empId,$pcode,$without_pay_year,$type_cs)
{
	include("config.inc.php");
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

	$pay="0";
	$sdate1="$without_pay_year-01-01";
	$edate1="$without_pay_year-12-31";	

	$sqlq=" SELECT SUM(withoutPay) as withoutPay,sum(pay) as pay FROM `leave` 
	where empId='$empId' AND (sdate between '$sdate1' AND '$edate1') 
	 AND status in (3,4) AND pcode like '$pcode' and leaveApplied='$type_cs'" ;
	if($pay=="0")$sqlq.=" AND withoutPay>0 ";
	if($pay=="1")$sqlq.=" AND pay>0 ";
// echo  $sqlq.'<br>';
	$sql=mysqli_query($db, $sqlq); 
	$pn=mysqli_fetch_array($sql);
	if($pay=="1"){
		if($pn[pay]==null && $pn[withoutPay]==null)
		{	
			$sqlq=" SELECT sum(leavePeriod) as pay FROM `leave` 
	where empId='$empId' AND (sdate between '$sdate1' AND '$edate1') 
	 AND status='3' AND pcode='$pcode'" ;
// echo $sqlq;
			$sql=mysqli_query($db, $sqlq); 
			$pn=mysqli_fetch_array($sql);
		}
		return $pn[pay];
	}
  return $pn[withoutPay];
   }
?>

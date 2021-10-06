<?

/*
$_GET variable empID=12,debug=1
*/
function getWagesAmount($fdat1,$edat1,$project){
	$finalWork=0;
	$final=0;
	global $db;
	ini_set("memory_limit","4000M");
	ini_set("max_execution_time","96000000000000000000");

  // end of date split
	$designationStart="86-00-000";
	// $designationStart="89-01-000";
	$designationEnd="94-99-999";
	// end init

	$sqlquery="SELECT DISTINCT attendance.empId,employee.designation,employee.salary,employee.allowance FROM attendance,employee".
	" where attendance.location='$project'"; 
	
if($_GET["debug"] && $_GET["empID"])
	$sqlquery.=" AND attendance.empId='$_GET[empID]' ";
else
	$sqlquery.=" AND attendance.edate>='$fdat1' AND attendance.edate<='$edat1' ";
	
	$sqlquery.=" AND action in('P','HP') AND attendance.empId=employee.empId".
	" AND employee.designation>='$designationStart' and employee.designation<='$designationEnd' ";

	if($_GET["debug"])
		$sqlquery.=" and employee.salary>0  ";

		$sqlquery.=" ORDER by designation,empId ASC";
	if($_GET["debug"])
	$sqlquery.=" limit $_GET[start],10";
	// " AND employee.designation in ('$designationStart','88-30-000') and employee.salary>0 ORDER by designation,empId ASC";// limit 0,3";
// 	echo $sqlquery;
// 	exit;
	

$sql= mysqli_query($db, $sqlquery);


while($re=mysqli_fetch_array($sql)){
	$presentasReg=0;
	$presentTotal=0;
	$overtimeTotal=0;
	$workedTotal=0;
	$idleTotal=0;

	 $perDayQtyTotal=0;
	 $siowdmaPerDayTotal=0;
	 $perDayQtyTotal0=0;
	 $siowdmauptoTotal0=0;
	 $perDayQtyTotal=0;
	 $siowdmauptoTotal=0;
	 $worktat=0;
	 $normalDayAmountTotal=0;
	 $mworkedgTotal=0;
	 $workedgTotal=0;
	 $normalDayAmountgTotalup=0;
	 $regularAmountTotalat=0;
	 $mpresentasReggAmountTotal=0;
	 $toDaypresentat=0;
	 $idletat=0;
	 $overtimeAmountTotal=0;
	 $presentgTotal=0;
	 $overtimegAmountTotal=0;
	 $mnormalDayAmountgTotalup=0;
	$presentasReggAmountTotal=0; 
	$presentasReggTotal=0;
	$mpresentasReggTotal=0;
	$midlegTotal=0;
	$movertimegAmountTotal=0;
	$idlegTotal=0;
	$mpresentgTotal=0;
	$overtimegTotal=0;

	$normalDayRate=normalDayAmountSec($re[salary],$re[allowance],$edat1);
	//echo "<br>normalRate:$normalDayAmount";
	$otRate=otRateSec($re[salary],$edat1);

	$sqlquery1="SELECT * FROM attendance where attendance.location='$project' ";
	

	$sqlquery1.=" AND attendance.edate>='$fdat1' AND attendance.edate<='$edat1'";
	
	$sqlquery1.=" AND action in('P','HP') AND attendance.empId=$re[empId]";
// 	echo $sqlquery1;

	 $sql1= mysqli_query($db, $sqlquery1);
	 while($re1=mysqli_fetch_array($sql1)){

			$dailyworkBreakt=dailyworkBreak($re[empId],$re1[edate],'H',$project);

		$toDaypresent=toDaypresent($re[empId],$re1[edate],'H',$project);

			$toDaypresent=$toDaypresent-$dailyworkBreakt;

		$workt= dailywork($re[empId],$re1[edate],'H',$project);

	/*if(date('D',strtotime($re1[edate]))=='Fri'){
					if($workt>4*3600){
			$workafter8hour=$workt-(4*3600);
			$workin8hour=$workt-$workafter8hour;
			$otAmount=$workafter8hour*$otRate;
			}
			 else $workin8hour=$workt;
				$normalDayAmount =$normalDayRate*$workin8hour;
	}
					else*/{
				if($workt>8*3600){
					$workafter8hour=$workt-(8*3600);
					$workin8hour=$workt-$workafter8hour;
					$otAmount=$workafter8hour*$otRate;
				}
				else $workin8hour=$workt;
				$normalDayAmount=$normalDayRate*$workin8hour;
			}

			$normalDayAmountTotalup=$normalDayAmountTotalup+$normalDayAmount+$otAmount; 
			$normalDayAmount=0; 
			$otAmount=0;

	/*if(date('D',strtotime($re1[edate]))=='Fri')
	 $overtimet = $toDaypresent-(4*3600);
	else */
	$overtimet=$toDaypresent-(8*3600);

	if($overtimet<0) $overtimet=0;
	$idlet=$toDaypresent-$workt;
	if($idlet<0) $idlet=0;

	$presentTotal=$presentTotal+$toDaypresent;   
	$overtimeTotal=$overtimeTotal+$overtimet;
	$presentasReg=$presentasReg+($toDaypresent-$overtimet);

	$workedTotal=$workedTotal+$workt;
	$idleTotal=$idleTotal+$idlet; 

// Temp
	$finalTemp=$idlet; //idle
	$finalWorkTemp=$workt; //utilized
// Temp End

	$toDaypresent=0;
	$overtimet=0;
	$workt=0;
	$idlet=0;


		if($_GET["debug"]){
		if($finalTemp>0  || $finalWorkTemp>0){
			$sqlD="insert into auxiliary_wages (empID,designation,amountIDLE,amountUTILIZE,location,edate) values ('$re[empId]','$re[designation]','".($finalTemp*$normalDayRate)."','".($finalWorkTemp*$normalDayRate)."','$project','$re1[edate]');";
			mysqli_query($db,$sqlD);
			if(mysqli_affected_rows($db)<1){
// 				echo "Error Insert: ".$sqlD.mysqli_error($db);

$sqlD="update auxiliary_wages set amountIDLE='".($finalTemp*$normalDayRate)."', amountUTILIZE='".($finalWorkTemp*$normalDayRate)."' where empID='$re[empId]' and designation='$re[designation]' and location='$project' and edate='$re1[edate]'";

			mysqli_query($db,$sqlD);
			}
		}
//if($ikk++>=1000)exit;else echo "<br>";
		}
}



	$presentgTotal=$presentgTotal+$presentTotal; 
	$presentasReggTotal=$presentasReggTotal+$presentasReg;
	//if($presentasReg)
	//echo " <br>$re[empId]=$presentasReg";
	$presentasReggAmountTotal=$presentasReggAmountTotal+$presentasReg*$normalDayRate;

	$overtimegTotal=$overtimegTotal+$overtimeTotal;
	$overtimegAmountTotal=$overtimegAmountTotal+$overtimeTotal*$otRate;
	$workedgTotal=$workedgTotal+$workedTotal;
	$idlegTotal=$idlegTotal+$idleTotal;


	$normalDayAmountgTotalup=$normalDayAmountgTotalup+$normalDayAmountTotalup;
	$normalDayAmountTotalup=0;
	$presentTotal=0;
	$overtimeTotal=0;
	$workedTotal=0;
	$idleTotal=0;
	$presentasReg=0;
	$normalDayRate=0;

	$final+=($overtimegAmountTotal+$presentasReggAmountTotal)-$normalDayAmountgTotalup; //idle
	$finalWork+=$normalDayAmountgTotalup; //utilized


	 }
		$finalArray=array($final,$finalWork);
	
	

	
	
	
		return $finalArray;
// 	tips	return array(idle amount, utilized amount)
}
		?>


 



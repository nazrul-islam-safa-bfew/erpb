<?
$edat=$toDate;
/*$the_date="01/01/2014";
$edat=$the_date;
*/

$project=$pcode;




if($loginProject=='000'){?>

<?
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sql="select * from project order by pcode ASC";
$sqlq=mysqli_query($db, $sql);
while($sqlr=mysqli_fetch_array($sqlq)){ "<option value=$sqlr[pcode]";
if($project==$sqlr[pcode]) {}; ">"; "$sqlr[pcode]--$sqlr[pname]</option>";
}
?>

<? } //loginProject?>

<? if($loginDesignation!='Site Engineer'){?>



<? }?>

<?

$format="Y-m-j";
$edat1 = formatDate($edat,$format);

?>


	
   
       
          <? 
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT DISTINCT employee.designation,itemlist.* from `itemlist`,employee Where itemCode >= '86-00-000' AND itemCode <= '99-00-000'".
" AND employee.designation=itemlist.itemCode AND employee.location='$project' ORDER by employee.designation ASC";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

 while($typel= mysqli_fetch_array($sqlrunp))
{
	$designationall[]=$typel[itemCode]; 
}
 ?>
 <? //echo $sqlp;?>
<?
//$designationall[]="88-40-000";
for($k=0;$k<=sizeof($designationall);$k++)
{

$designation=$designationall[$k];
$godesignation=$godesignation.'_'.$designation;
 if($designation){
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
 ?>

 <? $designation.', '.hrDesignation($designation);?>
  <? $edat;?>
 <? $edat;?>
 <? $edat;?> 

    <? $sqlquery="SELECT DISTINCT attendance.empId,employee.designation,employee.salary,employee.allowance".
		" FROM attendance,employee".
" where attendance.location='$project' AND attendance.edate='$edat1'".
" AND action in('P','HP') AND attendance.empId=employee.empId".
" AND employee.designation='$designation' ORDER by designation,empId ASC";// limit 0,3";
//echo $sqlquery;

 $sql= mysqli_query($db, $sqlquery);
 $i=1;
 while($re=mysqli_fetch_array($sql)){
 $toDaypresent=0;

	if(isPresent($re[empId],$edat1) OR isHPresent($re[empId],$edat1)){
	
		$dailyworkBreakt=dailyworkBreak($re[empId],$edat1,'H',$project);
		$toDaypresent=toDaypresent($re[empId],$edat1,'H',$project);

		$toDaypresent=$toDaypresent-$dailyworkBreakt;
        
		$normalDayRate= normalDayAmountSec($re[salary],$re[allowance],$edat1);

		$otRate = otRateSec($re[salary],$edat1);

		$toDaypresentat=$toDaypresentat+$toDaypresent;// hour
		
		
		$workt= dailywork($re[empId],$edat1,'H',$project);
		$worktat=$worktat+$workt; //total work Hour

if(date('D',strtotime($edat1))=='Fri'){
        if($workt>4*3600){
		$workafter8hour=$workt-(4*3600);
		$workin8hour=$workt-$workafter8hour;
		$otAmount=$workafter8hour*$otRate;
		}
		 else $workin8hour=$workt;
	    $normalDayAmount =$normalDayRate*$workin8hour;
}
        else{
			if($workt>8*3600){
			$workafter8hour=$workt-(8*3600);
			$workin8hour=$workt-$workafter8hour;
			$otAmount=$workafter8hour*$otRate;
			}
			 else $workin8hour=$workt;
			$normalDayAmount =$normalDayRate*$workin8hour;
		}
		$normalDayAmountTotal=$normalDayAmountTotal+$normalDayAmount+$otAmount; 
		$normalDayAmount=0;
		$otAmount=0;
		if(date('D',strtotime($edat1))=='Fri')
		$overtimet = $toDaypresent-(4*3600);
		else 
		$overtimet = $toDaypresent-(8*3600);
		
		if($overtimet<0) $overtimet=0;
		$overtimeAmount=$overtimet*$otRate;

		$overtimeAmountTotal=$overtimeAmountTotal+$overtimeAmount;

		$overtimetat=$overtimetat+$overtimet; //total over time
		$regularat =  $toDaypresent-$overtimet;
		$regularAmountat = $regularat*$normalDayRate;

		$regularAmountTotalat = $regularAmountTotalat+$regularAmountat;
		$regularAmountat=0;
		
		$idlet=$toDaypresent-$workt;

		if($idlet<0) $idlet=0;
		$idletat=$idletat+$idlet; //total idle Hour		
		} //is present
		else {
		$toDaypresent=0;
		$workt=0;
		$overtimet=0;
		$idlet=0;
		}$toDaypresent=0;
		}//while
		?>
<? 
$sqlquery="SELECT DISTINCT attendance.empId,employee.designation,employee.salary,employee.allowance FROM attendance,employee".
" where attendance.location='$project' AND attendance.edate<='$edat1'".
" AND action in('P','HP') AND attendance.empId=employee.empId".
" AND employee.designation='$designation' ORDER by designation,empId ASC";// limit 0,3";
//echo $sqlquery;

 $sql= mysqli_query($db, $sqlquery);

 while($re=mysqli_fetch_array($sql)){
$presentasReg=0;
$presentTotal=0;
$overtimeTotal=0;
$workedTotal=0;
$idleTotal=0;

		$normalDayRate= normalDayAmountSec($re[salary],$re[allowance],$edat1);
		//echo "<br>normalRate:$normalDayAmount";
		$otRate = otRateSec($re[salary],$edat1);


$sqlquery1="SELECT * FROM attendance".
" where attendance.location='$project' ".
"AND attendance.edate<='$edat1'".
" AND action in('P','HP') AND attendance.empId= $re[empId]";
//echo $sqlquery1;

 $sql1= mysqli_query($db, $sqlquery1);
 while($re1=mysqli_fetch_array($sql1)){
 
   	$dailyworkBreakt=dailyworkBreak($re[empId],$re1[edate],'H',$project);
	
	$toDaypresent=toDaypresent($re[empId],$re1[edate],'H',$project);
	
    $toDaypresent=$toDaypresent-$dailyworkBreakt;	
	
	$workt= dailywork($re[empId],$re1[edate],'H',$project);

if(date('D',strtotime($re1[edate]))=='Fri'){
        if($workt>4*3600){
		$workafter8hour=$workt-(4*3600);
		$workin8hour=$workt-$workafter8hour;
		$otAmount=$workafter8hour*$otRate;
		}
		 else $workin8hour=$workt;
	    $normalDayAmount =$normalDayRate*$workin8hour;
}
        else{
			if($workt>8*3600){
			$workafter8hour=$workt-(8*3600);
			$workin8hour=$workt-$workafter8hour;
			$otAmount=$workafter8hour*$otRate;
			}
			 else $workin8hour=$workt;
			$normalDayAmount =$normalDayRate*$workin8hour;
		}

		$normalDayAmountTotalup=$normalDayAmountTotalup+$normalDayAmount+$otAmount; 
         $normalDayAmount=0; 
		 $otAmount=0;
	
if(date('D',strtotime($re1[edate]))=='Fri')
 $overtimet = $toDaypresent-(4*3600);
else 
	$overtimet = $toDaypresent-(8*3600);

	if($overtimet<0) $overtimet=0;
	$idlet=$toDaypresent-$workt;
	  if($idlet<0) $idlet=0;

$presentTotal=$presentTotal+$toDaypresent;   
$overtimeTotal=$overtimeTotal+$overtimet;
$presentasReg=$presentasReg+($toDaypresent-$overtimet);

$workedTotal=$workedTotal+$workt;
$idleTotal=$idleTotal+$idlet; 

$toDaypresent=0;
$overtimet=0;
$workt=0;
$idlet=0;

 }
?>	
 <?
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
 } //while
 ?>
<? //till month--start

$month=date('m',strtotime($edat1));
$year=date('Y');
$from="$year-$month-01";

$sqlquery="SELECT DISTINCT attendance.empId,employee.designation,employee.salary,employee.allowance FROM attendance,employee".
" where attendance.location='$project' AND attendance.edate <='$edat1'".
" AND action in('P','HP') AND attendance.empId=employee.empId".
" AND employee.designation='$designation' ORDER by designation,empId ASC";// limit 0,3";
//echo $sqlquery;

 $sql= mysqli_query($db, $sqlquery);

 //echo "totalPresent:$totalPresent";
 $i=1;
 
 while($re=mysqli_fetch_array($sql)){
$presentasReg=0;
$presentTotal=0;
$overtimeTotal=0;
$workedTotal=0;
$idleTotal=0;

		$normalDayRate= normalDayAmountSec($re[salary],$re[allowance],$edat1);
		//echo "<br>normalRate:$normalDayAmount";
		$otRate = otRateSec($re[salary],$edat1);


$sqlquery1="SELECT * FROM attendance".
" where attendance.location='$project' ".
"AND attendance.edate BETWEEN '$from' AND '$edat1'".
" AND action in('P','HP') AND attendance.empId= $re[empId]";
//echo $sqlquery1;

 $sql1= mysqli_query($db, $sqlquery1);
 while($re1=mysqli_fetch_array($sql1)){
 
   	$dailyworkBreakt=dailyworkBreak($re[empId],$re1[edate],'H',$project);
	
	$toDaypresent=toDaypresent($re[empId],$re1[edate],'H',$project);
	
    $toDaypresent=$toDaypresent-$dailyworkBreakt;	

	$workt= dailywork($re[empId],$re1[edate],'H',$project);

if(date('D',strtotime($re1[edate]))=='Fri'){
        if($workt>4*3600){
		$workafter8hour=$workt-(4*3600);
		$workin8hour=$workt-$workafter8hour;
		$otAmount=$workafter8hour*$otRate;
		}
		 else $workin8hour=$workt;
	    $mnormalDayAmount =$normalDayRate*$workin8hour;
}
        else{
			if($workt>8*3600){
			$workafter8hour=$workt-(8*3600);
			$workin8hour=$workt-$workafter8hour;
			$otAmount=$workafter8hour*$otRate;
			}
			 else $workin8hour=$workt;
			$mnormalDayAmount =$normalDayRate*$workin8hour;
		}
		$mnormalDayAmountTotalup=$mnormalDayAmountTotalup+$mnormalDayAmount+$otAmount; 
         $normalDayAmount=0; 
		 $otAmount=0;
	
if(date('D',strtotime($re1[edate]))=='Fri')
 $overtimet = $toDaypresent-(4*3600);
else 
	$overtimet = $toDaypresent-(8*3600);

	if($overtimet<0) $overtimet=0;
	$idlet=$toDaypresent-$workt;
	  if($idlet<0) $idlet=0;

$mpresentTotal=$mpresentTotal+$toDaypresent;   
$movertimeTotal=$movertimeTotal+$overtimet;
$mpresentasReg=$mpresentasReg+($toDaypresent-$overtimet);

$mworkedTotal=$mworkedTotal+$workt;
$midleTotal=$midleTotal+$idlet; 

$toDaypresent=0;
$overtimet=0;
$workt=0;
$idlet=0;

 }
$mpresentgTotal=$mpresentgTotal+$mpresentTotal; 
$mpresentasReggTotal=$mpresentasReggTotal+$mpresentasReg;
$mpresentasReggAmountTotal=$mpresentasReggAmountTotal+$mpresentasReg*$normalDayRate;

$movertimegTotal=$movertimegTotal+$movertimeTotal;
$movertimegAmountTotal=$movertimegAmountTotal+$movertimeTotal*$otRate;
$mworkedgTotal=$mworkedgTotal+$mworkedTotal;
$midlegTotal=$midlegTotal+$midleTotal;


$mnormalDayAmountgTotalup=$mnormalDayAmountgTotalup+$mnormalDayAmountTotalup;
$mnormalDayAmountTotalup=0;
$mpresentTotal=0;
$movertimeTotal=0;
$mworkedTotal=0;
$midleTotal=0;
$mpresentasReg=0;
$mnormalDayRate=0;

 } //while
 ?>

<?
$sqls = "SELECT * from `dma` WHERE dmaProjectCode='$project' AND dmaItemCode ='$designation' ";
//echo $sqls;
$sql1=mysqli_query($db, $sqls); 
while($dmar=mysqli_fetch_array($sql1)){
$siowDuration=siowDuration($dmar[dmasiow]);

$siowDaysRem=siowDaysRem($dmar[dmasiow],$edat1);
$siowDaysGan=siowDaysGan($dmar[dmasiow],$edat1);
//echo "*$dmar[dmasiow]==$siowDaysRem==$siowDaysGan*";
if($siowDaysGan)
{ 
 if($siowDaysRem){
  $siowdmaPerDay =siowdmaPerDay($siowDuration,$dmar[dmaQty])*$siowDaysGan;

  $empTotalWorkhrsiow= (empTotalWorkhrsiow($designation,$edat1,$dmar[dmasiow])/3600);
  $remainQty=$siowdmaPerDay-$empTotalWorkhrsiow;
  $perdayRemainQty= $remainQty/$siowDaysRem;
  }
  else {
  $siowdmaPerDay =$dmar[dmaQty]; 
     
  $empTotalWorkhrsiow= (empTotalWorkhrsiow($designation,$edat1,$dmar[dmasiow])/3600);
  

  $remainQty=$siowdmaPerDay-$empTotalWorkhrsiow;
  $perdayRemainQty=$remainQty;
  }
  $perDayAmount=($perdayRemainQty)*($dmar[dmaRate]);  
}
else {$perDayAmount =0;$perdayRemainQty;}
if($perdayRemainQty>0)$perDayQtyTotal = $perDayQtyTotal+$perdayRemainQty;
//if($perdayRemainQty<0)echo "*$dmar[dmasiow]=$siowdmaPerDay#$empTotalWorkhrsiow==$perdayRemainQty**$siowDaysRem=$siowDaysGan##";
$siowdmaPerDayTotal=$siowdmaPerDayTotal+$perDayAmount;
$perdayRemainQty=0;
$perDayAmount=0;
 }//while
 ?>
<? sec2hms($perDayQtyTotal,$padHours=false).' hrs.';?>



 
 <?
 $perDayQtyTotal=0;
 $siowdmaPerDayTotal=0;
 $perdayRemainQty=0;
 $perDayAmount=0;
 $siowDuration=0;
 $siowDaysRem=0;
 $siowDaysGan=0;
 $siowdmaPerDay=0; 
 $perDayQtyTotal=0;
$siowdmauptoTotal=0;
$perDayQtyTotal0=0;
$siowdmauptoTotal=0;
$sqls = "SELECT * from `dma` WHERE dmaProjectCode='$project' AND dmaItemCode ='$designation' ";
//echo $sqls;
$sql1=mysqli_query($db, $sqls); 
while($dmar=mysqli_fetch_array($sql1)){
$siowDuration=siowDuration($dmar[dmasiow]);

$siowDaysRem=siowDaysRem($dmar[dmasiow],$edat1);
$siowDaysGan=siowDaysGan($dmar[dmasiow],$edat1);

if($siowDaysGan)
{ 
 if($siowDaysRem){
  $siowdmaPerDay =siowdmaPerDay($siowDuration,$dmar[dmaQty])*$siowDaysGan;
  }
  else {  $siowdmaPerDay =$dmar[dmaQty];     }
  
  $perDayAmount=($siowdmaPerDay)*($dmar[dmaRate]);  
}
else {$perDayAmount =0;$siowdmaPerDay=0;}

$perDayQtyTotal = $perDayQtyTotal+$siowdmaPerDay;
$siowdmauptoTotal=$siowdmauptoTotal+$perDayAmount;
$perdayRemainQty=0;
$perDayAmount=0;
 }//while


 $perdayRemainQty=0;
 $perDayAmount=0;
 $siowDuration=0;
 $siowDaysRem=0;
 $siowDaysGan=0;
 $siowdmaPerDay=0; 


$yesterday  = mktime(0, 0, 0, date("m",strtotime($from))  , date("d",strtotime($from))-1, date("Y",strtotime($from)));

$from1=date("Y-m-d",$yesterday);


$sqls = "SELECT * from `dma` WHERE dmaProjectCode='$project' AND dmaItemCode ='$designation' ";
//echo $sqls;
$sql1=mysqli_query($db, $sqls); 
while($dmar=mysqli_fetch_array($sql1)){
$siowDuration=siowDuration($dmar[dmasiow]);

$siowDaysRem=siowDaysRem($dmar[dmasiow],$from1);
$siowDaysGan=siowDaysGan($dmar[dmasiow],$from1);

if($siowDaysGan)
{ 
 if($siowDaysRem){
  $siowdmaPerDay =siowdmaPerDay($siowDuration,$dmar[dmaQty])*$siowDaysGan;
  }
  else {
  $siowdmaPerDay =$dmar[dmaQty];      
  }
  $perDayAmount=($siowdmaPerDay)*($dmar[dmaRate]);  
}
else {$perDayAmount =0;$siowdmaPerDay=0;}

$perDayQtyTotal1 = $perDayQtyTotal1+$siowdmaPerDay;

$siowdmauptoTotal1=$siowdmauptoTotal1+$perDayAmount;
$siowdmaPerDay=0;
$perDayAmount=0;
 }//while
$perDayQtyTotal0=$perDayQtyTotal-$perDayQtyTotal1;
$siowdmauptoTotal0=$siowdmauptoTotal-$siowdmauptoTotal1;

 ?>
 <font color="#336666">
 <? sec2hms($perDayQtyTotal0,$padHours=false).' hrs.';
 $perDayQtyTotal=0;
 $perDayQtyTotal1=0;
 $perDayQtyTotal0=0;
 $siowdmauptoTotal=0;
 $siowdmauptoTotal1=0
 ?>
 

<? number_format($siowdmauptoTotal0)?>
 <?
 $perDayQtyTotal=0;
 $siowdmaPerDayTotal=0;
 $perdayRemainQty=0;
 $perDayAmount=0;
 $siowDuration=0;
 $siowDaysRem=0;
 $siowDaysGan=0;
 $siowdmaPerDay=0; 
 $perDayQtyTotal=0;
$siowdmauptoTotal=0;

$sqls = "SELECT * from `dma` WHERE dmaProjectCode='$project' AND dmaItemCode ='$designation' ";
//echo $sqls;
$sql1=mysqli_query($db, $sqls); 
while($dmar=mysqli_fetch_array($sql1)){
$siowDuration=siowDuration($dmar[dmasiow]);

$siowDaysRem=siowDaysRem($dmar[dmasiow],$edat1);
$siowDaysGan=siowDaysGan($dmar[dmasiow],$edat1);

if($siowDaysGan)
{ 
 if($siowDaysRem){
  $siowdmaPerDay =siowdmaPerDay($siowDuration,$dmar[dmaQty])*$siowDaysGan;
  }
  else {  $siowdmaPerDay =$dmar[dmaQty];  }
  
  $perDayAmount=($siowdmaPerDay)*($dmar[dmaRate]);  
}
else {$perDayAmount =0;$siowdmaPerDay=0;}

$perDayQtyTotal = $perDayQtyTotal+$siowdmaPerDay;
$siowdmauptoTotal=$siowdmauptoTotal+$perDayAmount;
$perdayRemainQty=0;
$perDayAmount=0;
 }//while
 
 ?>

 <? sec2hms($perDayQtyTotal,$padHours=false).' hrs.'; 
 
	$grand_total_of_approved=$grand_total_of_approved+$siowdmauptoTotal;
	
	
 ?>
 
 

 <? sec2hms($worktat/3600,$padHours=false).' hrs.';?>
 <? number_format($normalDayAmountTotal);?>
 <? sec2hms($mworkedgTotal/3600,$padHours=false).' hrs.';?> <? number_format($mnormalDayAmountgTotalup);?>
 <? sec2hms($workedgTotal/3600,$padHours=false).' hrs.';?> <?  number_format($normalDayAmountgTotalup);?>
<?php $normalDayAmountgTotalup_finual= $normalDayAmountgTotalup_finual+$normalDayAmountgTotalup ?>



<?php $normalDayAmountgTotalup; 
//Present as Regular.

?>
 <?  sec2hms(($toDaypresentat-$overtimetat)/3600,$padHours=false).' hrs.';?>
  <? number_format($regularAmountTotalat); ?>
<? sec2hms($mpresentasReggTotal/3600,$padHours=false).' hrs.';?>
<? number_format($mpresentasReggAmountTotal);?>
<? sec2hms($presentasReggTotal/3600,$padHours=false).' hrs.';?>
<? number_format($presentasReggAmountTotal);?> 
<? $mpresentasReggTotal=0;?>




 <? sec2hms($overtimetat/3600,$padHours=false).' hrs.';?> <? number_format($overtimeAmountTotal);?> 
 <? sec2hms($movertimegTotal/3600,$padHours=false).' hrs.';?> <? number_format($movertimegAmountTotal)?> 
 <? sec2hms($overtimegTotal/3600,$padHours=false).' hrs.';?>
<? number_format($overtimegAmountTotal)?>
<? $movertimegTotal=0;$overtimetat=0;?>


 <? $get_all_idle_amount=$overtimegAmountTotal+$presentasReggAmountTotal; ?>



 
  <? sec2hms($toDaypresentat/3600,$padHours=false).' hrs.';?> <? number_format($overtimeAmountTotal+$regularAmountTotalat);?> 
  <? sec2hms($mpresentgTotal/3600,$padHours=false).' hrs.';?> <? number_format($mpresentasReggAmountTotal+$movertimegAmountTotal);?> 
  <? sec2hms($presentgTotal/3600,$padHours=false).' hrs.';?> <? $get_all_idle_amount=$overtimegAmountTotal+$presentasReggAmountTotal; number_format($overtimegAmountTotal+$presentasReggAmountTotal);?> 



 
 <? sec2hms($idletat/3600,$padHours=false).' hrs.';?> <? number_format((($overtimeAmountTotal+$regularAmountTotalat) -$normalDayAmountTotal));?> 
 <? sec2hms($midlegTotal/3600,$padHours=false).' hrs.';?> <? number_format((($movertimegAmountTotal+$mpresentasReggAmountTotal) -$mnormalDayAmountgTotalup));?> 
      <? sec2hms($idlegTotal/3600,$padHours=false).' hrs.';?> <? 
	  
	  
	  
 $idle_amount=(($overtimegAmountTotal+$presentasReggAmountTotal) -$normalDayAmountgTotalup);
 $total_idle_amount=$total_idle_amount+$idle_amount;
 

	  
	  ?> 

<? }
}
//designation
//echo $normalDayAmountgTotalup_finual." // idle=<br>";
//echo $total_idle_amount;
?>

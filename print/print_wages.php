<? 
include("../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
include_once("../includes/myFunction1.php");
include_once("../includes/myFunction.php");
include_once("../includes/empFunction.inc.php");
include_once("../includes/accFunction.php");
$todat=todat();
?>
<html>
<head>

<LINK href="../style/print.css" type=text/css rel=stylesheet>
<meta http-equiv="Content-Language" content="en-us">
<meta name="author" content="<? echo $mauthor;?>">
<meta name="copyright" content="<? echo $tt;?>">
<meta name="keywords" content="<? echo $kword;?>">
<META NAME="description" CONTENT="<? echo $des;?>">
<title>BFEW :: Print Wages</title>
	<style>
		font,td{font-size:14px;}
	</style>
</head>
<body  topmargin="1" leftmargin="5" rightmargin="5" bgcolor="#FFFFFF" >
<table width="800" border="0"  align="center" cellpadding="5" cellspacing="5">
<tr>
 <th><font class="englishheadBlack" style="    font-size: 24px;">Bangladesh Foundry and Engineering Works Ltd.</font></th>
</tr>
<tr>
 <th style="    font-size: 14px;">Wages for the month of  <? echo date('F, Y',strtotime("$year-$month-01")).' '.myprojectName($exfor).' Project-'.$exfor; ?></th>
</tr>
</table>
<br>
<br>

<table   width="100%" align="center" border="2" bordercolor="#000" cellspacing="0" cellpadding="5" style="border-collapse:collapse">
 <tr bgcolor="#EEEEEE">
   <th valign="top" width="50" rowspan="2" >SL</th>
   <th valign="top" width="100" rowspan="2" >EmployeeID,<br> Designation</th>
   <th valign="top" rowspan="2" >Employee Name</th>
    <th valign="top" width="50" rowspan="2" >Days <br>Present</th>
   <th valign="top" rowspan="2" >Total OT<br> Hours</th>      
   <th valign="top" width="50" colspan="2"  >Wages</th>
   <th valign="top" width="50" rowspan="2" >OT Rate<br>/ Hour</th>
   <th valign="top"  colspan="2" >Amount (Tk)</th>
   <th valign="top" rowspan="2" >Payable <br>Amount(Tk.)</th>
   <th valign="top" rowspan="2" width="250" >Signature</th>       
 </tr>
 <tr bgcolor="#EEEEEE">
   <th valign="top" >Basic</th>
   <th valign="top" >Allowance</th>
   <th valign="top" width="50"  >Normal day</th>
   <th valign="top" width="50"  >Over Time</th>
 </tr> 
 <tr><td colspan="12"></td></tr>
 <?
 $ck=explode('_',$chk);
 function isChecked($ck,$k){
  for($i=0;$i<sizeof($ck);$i++)
    if($ck[$i]==$k)return true;
 }

//$year=thisYear();

	$fromD="$year-$month-01";
$daysofmonth=daysofmonth($fromD);
	$toD="$year-$month-$daysofmonth";


	
//$sqlp = "SELECT * from `employee` WHERE location='$exfor' AND salaryType='Wages Monthly Master Roll' order by designation,empId ASC";// LIMIT 0,3";
$sqlp="SELECT DISTINCT attendance.empId,designation,name,salary,allowance FROM attendance,employee
 WHERE salaryType like 'Wages%' 
 AND attendance.location='$exfor' 
 AND attendance.edate between '$fromD' AND '$toD' 
 AND attendance.empId=employee.empId 
 ORDER by designation ASC";
// echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
$b=1;
$totalAmount=0;

while($re=mysqli_fetch_array($sqlrunp)){
if(isChecked($ck,$re[empId])){
// 	print_r($re);
//if(isPayable_wages($re[empId],$fromD,$toD)){

if($b%2==0) $bg = "#E5E5E5";
else $bg = "#D5D5D5";

?>
<tr style="height:60px; ">
   <td align="center" ><? echo $b;?></td>
   <td ><? echo '<font class=out>'.empId($re[empId],$re[designation]).'</font>'; echo '<br>'.hrDesignation($re[designation]);?>
    <input type="hidden" name="designation<? echo $b;?>" value="<? echo $re[designation];?>">
    </td>
   <td  align="left" > <? echo $re[name];?>  </td> 
	<td align="center" > 
      <? 
	//$wagesDate1=formatDate($wagesDate,'Y-m-d');
$TotalPresentHr=TotalPresentHr($fromD,$toD,$re[empId],'H');
	
   $workedt=dailywork( $re[empId],$wagesDate1,'H',$exfor);
   $worked=sec2hms($workedt/3600,$padHours=false);
   
   $overtimet=$workedt-(9*3600);
   if($overtimet<0) $overtimet=0;
   $overtime=sec2hms($overtimet/3600,$padHours=false);
   
   $idlet=(3600*8)-$workedt;
   
   if($idlet<0)  $idlet=0;
   $idle=sec2hms($idlet/3600,$padHours=false);

    $totalPresent = local_TotalPresentHr($fromD,$toD,$re[empId],'H',$exfor); 
	echo $totalPresent;
	?>
    </td>
	<td align="right" ><? 
$presentTotal=0;
$overtimeTotal=0;
$workedTotal=0;
$idleTotal=0;

$sqlquery1="SELECT * FROM attendance".
" where attendance.location='$exfor' ".
//"AND attendance.edate<='$todat'".
"AND attendance.edate BETWEEN '$fromD' AND '$toD'".
" AND action in('P','HP') AND attendance.empId= '$re[empId]'";
//echo $sqlquery1;

 $sql1= mysqli_query($db, $sqlquery1);
 while($re1=mysqli_fetch_array($sql1)){
 
	$dailyworkBreakt=dailyworkBreak($re[empId],$re1[edate],'H',$exfor);

	$toDaypresent=toDaypresent($re[empId],$re1[edate],'H',$exfor);

	$toDaypresent=$toDaypresent-$dailyworkBreakt;	

//echo "<br>toDaypresent:$toDaypresent<br>";
	
	$workt= dailywork($re[empId],$re1[edate],'H',$exfor);
	
	// if(date('D',strtotime($re1[edate]))=='Fri')
	//  $overtimet = $toDaypresent-(4*3600);
	// else 
		$overtimet = $toDaypresent-(8*3600);

//	$overtimet = $toDaypresent-8*3600;
	if($overtimet<0) $overtimet=0;
	$idlet=$toDaypresent-$workt;
	  if($idlet<0) $idlet=0;

$presentTotal=$presentTotal+$toDaypresent;   
$overtimeTotal=$overtimeTotal+$overtimet;
$workedTotal=$workedTotal+$workt;
$idleTotal=$idleTotal+$idlet; 

//echo "<br>date:$re1[edate]= Present:$toDaypresent--worked:$workt--overtime:$overtimet--idle:$idlet***presentTotal:$presentTotal **<br>";
$toDaypresent=0;
$overtimet=0;
$workt=0;
$idlet=0;

 }
?>	
	<? 
	$presentTotal=sec2hms($presentTotal/3600,$padHours=false);
	$overtimeTotal1=sec2hms($overtimeTotal/3600,$padHours=false);
	$workedTotal=sec2hms($workedTotal/3600,$padHours=false);
	$idleTotal=sec2hms($idleTotal/3600,$padHours=false);
	//echo "<br>presentTotal:$presentTotal--idleTotal:$idleTotal<br>";		
	?>
<? echo $overtimeTotal1;?>
	 </td>
   <td  align="right" ><? echo number_format($re[salary],2);?> </td> 
   <td  align="right" ><? echo number_format($re[allowance],2);?> </td> 
   <td  align="right" > <? echo number_format(otRate($re[salary],$fromD),2);?></td>   
    <td  align="right" >
      <? $atAmount=normalDayAmount($re[salary],$re[allowance],$fromD,$totalPresent);
    echo number_format($atAmount,2);
   ?></td>

   <td align="right" >        <? 
  $desig=explode("-",$re[designation]); 
      if($desig[0]!='90' && $desig[0]!='91' && $desig[0]!='87'){
        $otAmount=otRate($re[salary],$fromD)*($overtimeTotal/3600);
        echo number_format($otAmount,2);
      }else{
        $otAmount=0;
        echo number_format($otAmount,2);
      }
    ?></td>

    <td align="right"> 
      <? $amount=$otAmount+$atAmount; 
	  
	  $paid=currentWPayble($re[empId],"$year-$month-01",$exfor);
	  $payable= $amount-$paid;
	  //echo "**$loginProject**	  $payable= $amount-$paid; +++";
	  echo number_format($payable,2);
	  $totalAmount+=$payable;
	  ?>
      <input type="hidden" name="amount<? echo $b;?>" alt="" value="<? echo round($amount,2);?>">
	  
   </td>   
  <td></td>
 </tr> 
 <? 
 if(${ch.$b}) $totalAmount+= $amount; $amount=0;
 $b++;
 $ta=0;
// }
 }//chk
 } //while?>
 <tr>
    <td colspan="11" align="right"> Total Amount: <? echo number_format($totalAmount,2);?></td>
  <td></td>
 </tr>
 </table>
 <br><br>
 <br><br>
 <br><br>
 <br><br>
 <table width="100%" align="center">
  <tr>
		<th>Prepared by HR</th>
		<th>Site Engr/Foreman</th>   
		<th>Project Manager</th>  
		<th>HR &amp; Admin Manager</th>  
		<th>Director Planning &amp; Control</th>  
		<th>Director Admin.</th>  
		<th>Managing Director</th>  
  </tr>
 </table>
  <br>
  <br>
<? include('../bottom.php');?>
</body>

</html>
 

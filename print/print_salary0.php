<? include_once("../includes/myFunction1.php");
include("../includes/config.inc.php");
include_once("../includes/myFunction.php");
include_once("../includes/empFunction.inc.php");
include_once("../includes/eqFunction.inc.php");
include_once("../includes/subFunction.inc.php");
include_once("../includes/matFunction.inc.php");
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
<title>BFEW :: Print IOW</title>
</head>
<body  topmargin="1" leftmargin="5" rightmargin="5" bgcolor="#FFFFFF" >
<table width="500" border="0"  align="center" cellpadding="5" cellspacing="5">
<tr>
 <th><font class="englishheadBlack">Bangladesh Foundry and Engineering Works Ltd.</font></th>
</tr>
<tr>
 <th>Salary for the month of  <? echo date('F, Y',strtotime("2006-$month-01")).' '.myprojectName($exfor).' Project'; ?></th>
</tr>
</table>
<br>
<br>
<table   width="100%" align="center" border="2" bordercolor="#999999" cellspacing="0" cellpadding="5" style="border-collapse:collapse">
 <tr bgcolor="#EEEEEE">
   <th valign="top">SL</th>
   <th valign="top">EmployeeID,<br> Designation</th>
   <th valign="top">Employee Name</th>
   <th valign="top" width="100">Remarks</th>  
   <th valign="top">Basic</th>
   <th valign="top">H/Rent</th>   
   <th valign="top">Med</th>   
   <th valign="top">Conv</th>   
   <th valign="top">Salary Amount</th>   
   <th valign="top" width="100">Monthly Adjustment</th>      
   <th valign="top" width="100">Current Payble</th> 
   <th valign="top">Signature</th>    
 </tr>
 <tr><td colspan="12"></td></tr>
 <?
 $ck=explode('_',$chk);
 function isChecked($ck,$k){
  for($i=0;$i<sizeof($ck);$i++)
    if($ck[$i]==$k) return true;
 }
include("../includes/config.inc.php");

$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
//$sqlp = "SELECT * from `employee` WHERE location='$exfor' AND empDate<='2006-$month-01' AND (salaryType='Salary' OR salaryType='Wages Monthly' )  order by designation ASC ";
$sqlp = "SELECT * from `employee` WHERE location='$exfor' AND empDate<='2006-$month-01' AND status<>'-2'".
"  AND (salaryType='Salary' OR salaryType='Wages Monthly' )".
"  order by designation ASC ";
//echo $sqlp;
$sqlrunp= mysql_query($sqlp);
$monthlyWork=monthlyWork($month);

$b=1;
$k=1;
$totalAmount=0;
$year=thisYear();
$daysofmonth = daysofmonth("$year-$month-01");
while($re=mysql_fetch_array($sqlrunp)){
$actualSalary=0;
$paid=0;
$withoutPayAmountTotal=0;
$terAmount=0;
$empStatus=$re[status];
if(isChecked($ck,$re[empId])){
if(isSalaryPaid($re[empId],$month)){

$advanceSadjust1=explode('/',advanceSadjust($re[empId],$month));

$advanceSadjust=$advanceSadjust1[0];
$advanceSadjustRef=$advanceSadjust1[1];

$actualSalary=$re[salary]-$advanceSadjust;

?>
 <tr <? if($b%2==0) echo 'bgcolor=#FFFFEE';?> >
   <td valign="top" align="center"><? echo $b;?></td>
   <td valign="top" ><? echo '<font class=out>'.empId($re[empId],$re[designation]).'</font>';   
    echo '<br>'.hrDesignation($re[designation]);?> 
   <input  type="hidden" name="empId<? echo $b;?>" value="<? echo $re[empId];?>">
   <input  type="hidden" name="designation<? echo $b;?>" value="<? echo $re[designation];?>">   
   </td>
   <td valign="top" align="left"><? echo $re[name];?> </td>   
    <td valign="top" > 
      <? //echo date("j/m/Y", time());
//locDays($re[empId],$month);
/*---------------------------------------*/
$loc=array();
$from=array();
$to=array();
$pre=array();
$holiday=array();
$leave=array();
$workday=array();

 $sqlf = "SELECT * FROM `emptransfer` WHERE empId='$re[empId]'".
 		 " AND reportDate BETWEEN '2006-$month-01' AND '2006-$month-$daysofmonth' ORDER by tid ASC ";
//echo $sqlf.'<br>';
$sqlQ= mysql_query($sqlf);
$rows=mysql_num_rows($sqlQ);

if($rows){
	$i=0;
	while($rr=mysql_fetch_array($sqlQ)){
	$loc[$i]=$rr[transferTo];
	$from[$i]=$rr[reportDate];
	$i++;
	//echo $sqlf.'<br>';
	}

}

else{
 $sqlf = "SELECT * FROM `emptransfer` WHERE empId='$re[empId]'  AND reportDate <= '2006-$month-01' ORDER by tid DESC ";
//echo $sqlf.'<br>';
$sqlQ= mysql_query($sqlf);
$rows=mysql_num_rows($sqlQ);
if($rows){
	$rr=mysql_fetch_array($sqlQ);
	$loc[0]=$rr[transferTo];
	$from[0]="2006-$month-01";
	//echo $sqlf.'<br>';
	}
}
//print_r($loc);
//print_r($rep);
for($i=0,$j=1;$i<sizeof($loc);$i++,$j++){
$to[$i]=date("Y-m-j",strtotime($from[$j])-86400);
}
$i--;
$as="2006-$month-01";
$to[$i]="2006-$month-".date('t',strtotime($as));

if(sizeof($loc)>0){
for($i=0;$i<sizeof($loc);$i++){
	if($loc[$i]=='000') 
	  {
	   $d1=$from[$i];
	   $d2=$to[$i];	   
	   $days= 1+(int)(strtotime($d2)-strtotime($d1))/86400;

	  //echo "totalWork: ".totalWork($d1,$d2).'--';
	  
	   $startDate=strtotime($d1);
	   for($j=0; $j<$days;$j++)
		  { 
		   if(isPresent($re[empId],(date("Y-m-j",$startDate)))) $p++ ;  
		   if(isAbsent($re[empId],(date("Y-m-j",$startDate)))) $a++;
		   if(isHoliday(date("Y-m-j",$startDate))=='1') $h++ ;  		   
		   if(isLeave1($re[empId],(date("Y-m-j",$startDate)),$month)=='1') $l++ ;
		   $startDate=$startDate+(24*3600);
		  }
	  }
	else if($loc[$i]!='000') 
	  {
	   $d1=$from[$i];
	   $d2=$to[$i];	   
	   $days=1+ (int)(strtotime($d2)-strtotime($d1))/86400;
	   //echo $days;
	  //echo "Site_totalWork: ".site_totalWork($d1,$d2).'--';
	  
	   $startDate=strtotime($d1);
	   for($j=0; $j<$days;$j++)
		  { 
		   if(isPresent($re[empId],(date("Y-m-j",$startDate)))) $p++ ;  
		   if(isAbsent($re[empId],(date("Y-m-j",$startDate)))) $a++;		   
   		   if(isHolidaySite(date("Y-m-j",$startDate))=='1') $h++ ;  
		   if(isLeave1($re[empId],(date("Y-m-j",$startDate)),$month)=='1') $l++ ;
		   $startDate=$startDate+(24*3600);
		  }
	  }

	  $pre[$i]=$p;
	  $holiday[$i]=$h;
	  $workday[$i]= $days-$h;
	  $absent[$i]= $a;	  
	  $leave[$i]=$l;
	  $withoutPay[$i]=withoutPay($re[empId],$month,$loc[$i]);
	  $p=0;$h=0;$l=0;$a=0;
//        echo '====='.withoutPay($re[empId],$month,$loc[$i])."========$withoutPay[$i]====";
// 
}

$tw=0;
$tp=0;
$tl=0;

for($i=0;$i<sizeof($loc);$i++){
//echo "L=$loc[$i]=>$from[$i] -- $to[$i]<br>W-$workday[$i]==P-$pre[$i]==H-$holiday[$i]==L-$leave[$i]<br>";
echo "$loc[$i]-$pre[$i] P, $leave[$i] L, <font class=out>$absent[$i] A</font>"; 
if($withoutPay[$i]) echo ", <font class=out>$withoutPay[$i] NoPay</font>";echo "<br>";

$tw+=$workday[$i];
$tp+=$pre[$i];
$tl+=$leave[$i];
$ta+=$absent[$i];
}
//$ta=$tw-$tp;
//isPresent($empId,$df)

$withoutPay_perdaysalary=$actualSalary/$daysofmonth;
if($tp)$perdaysalary=$actualSalary/$tp;
else $perdaysalary=0;
//echo "++$perdaysalary/$tp++";
for($i=0;$i<sizeof($loc);$i++){
	$withoutPayAmount=round($withoutPay[$i]*$withoutPay_perdaysalary);	
	$ss=round($perdaysalary*$pre[$i])-$withoutPayAmount;	
	//echo "L=$loc[$i]=> S=$ss<br>";	
	echo "<input type=hidden name=sal".$b.'['.$i."] value=$ss>";
	echo "<input type=hidden name=prr".$b.'['.$i."] value=$loc[$i]>";
     $withoutPayAmountTotal=$withoutPayAmountTotal+$withoutPayAmount; $withoutPayAmount=0;
	//echo "**$loc[$i]=$ss-$withoutPayAmount**$withoutPay[$i]<br>";
	}//for
 }//if size of loc
//}

 ?>
      <? // $withoutPay=withoutPay($re[empId],$month,$exfor);  echo $withoutPay;?>
    </td>
   <td valign="top" align="center" colspan="4">  Consolidated </td> 
   <td valign="top" align="right"><? echo number_format($re[salary],2);?> </td>   
    <td valign="top" align="center" >
	  <? if($advanceSadjust){ echo '-'.number_format($advanceSadjust,2);?>
  	  <input type="hidden" name="adAmount<? echo $b;?>" value="<? echo $advanceSadjust;?>">
	  <input type="hidden" name="reff<? echo $b;?>" value="<? echo $advanceSadjustRef;?>">	  
	  
         <? }?>

	  <br>
      <? if($withoutPayAmountTotal) echo '-'.$withoutPayAmountTotal; ?>
    </td>  
   <td valign="top" align="right"><? /*$perdaySalary = $re[salary]/25; 
    $currentPayble=$perdaySalary*$monthlyPresent;  
	echo  number_format($currentPayble,2);*/
	//echo number_format($re[salary],2);
	
	
	$paid=currentPayble($re[empId],"2006-$month-01");
if($empStatus=='-1'){
	 $jobTer=$re[jobTer];
	  if(date('m',strtotime($jobTer))==$month)
	  {
	  
	 	$du=1+abs(strtotime("2006-$month-01")-strtotime($jobTer))/86400;

		$tre=$daysofmonth-$du;
		$terAmount=$withoutPay_perdaysalary*$tre;
		//echo "<br>***$du=$tre=terAmount=$terAmount<br>";
		}
	 }
		
	$payable=$actualSalary-$paid-$withoutPayAmountTotal-$terAmount;
	echo number_format($payable,2);	

	$withoutPayAmountTotal=0;
	?> 
	</td>     
   <td valign="top" align="center" width="100"></td>   	      
 </tr> 
 <? 
  $totalAmount+= $payable;

 $b++;
 $ta=0;
 }//if checked 
 }//if paid
 } //while?>
 <tr>
 <tr>
  <td colspan="11" align="right"> Total Amount:  <? echo number_format($totalAmount,2);?> </td>

 </tr>

 </table>
   <br>
  <br>
<? include('../bottom.php');?>
</body>

</html>
 

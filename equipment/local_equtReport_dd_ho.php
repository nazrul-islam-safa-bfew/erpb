<?
if($edat1){
$hoSQL="select * from equipment where location='$project' order by itemCode,assetId asc";
// 	echo $hoSQL;
$hoQ=mysqli_query($db,$hoSQL);
}
while($re=mysqli_fetch_array($hoQ)){
	 $re[eqId]=$re[assetId];
 ?>
 <tr <? if($i%2==0) echo "bgcolor=#EEEEEE";?> >
      <td width="100"><? 
 echo eqpId_local($re[assetId],$re[itemCode]); $type='L';?>
		</td>
  <td><?
	$temp=itemDes($re[itemCode]); echo $temp[des].', '.$temp[spc];
	
	$itemSpec=getEquipmentDetails($re[eqId],$re[itemCode]);
	echo "<br>";
	
	$gED6=getEquipmentDetailsByRquirement(null,null,6,$itemSpec);
	if($gED6)echo $gED6." <br>";
	 
	$gED0=getEquipmentDetailsByRquirement(null,null,0,$itemSpec);
	if($gED0)echo $gED0."; ";
	 
	$gED7=getEquipmentDetailsByRquirement(null,null,7,$itemSpec);
	if($gED7)echo " YoM: ".$gED7;
	?>
	<?  $totalPresent = eqTotalPresentHr('2013-01-01',$edat1,$re[eqId],$re[itemCode],$type,$project);
	   echo "<p align=right style='margin:0;'>Worked : <font class='out'>$totalPresent </font>days<br>";
	 /* 
	 Equipment Meter: 50:00 hrs
	 ERP Meter: hrs.
	 Milage: km.*/
	 
	$measuringUnit=getEQmeasureUnit($re[itemCode]);
// 	 echo $measuringUnit;
	if($measuringUnit=="km"){
		$d30=getEqAccConsumtion($edat1,30,$re[itemCode],$re[eqId]); //km 
		$d90=getEqAccConsumtion($edat1,90,$re[itemCode],$re[eqId]); //km 
		$d180=getEqAccConsumtion($edat1,180,$re[itemCode],$re[eqId]); //km 
	
	   echo " <b>Average Fuel Consumption:</b> <a href='./equipment/eqReport.php?month=1&assetID=$re[eqId]&itemCode=$re[itemCode]&pcode=$project' target='_blank'>1 month</a>: <font color='#00f'>$d30</font> Tk./$measuringUnit.<br> <a href='./equipment/eqReport.php?month=3&assetID=$re[eqId]&itemCode=$re[itemCode]&pcode=$project' target='_blank'>3 months</a>: <font color='#00f'>$d90</font> Tk./$measuringUnit.<br> <a href='./equipment/eqReport.php?month=6&assetID=$re[eqId]&itemCode=$re[itemCode]&pcode=$project' target='_blank'>6 months</a>: <font color='#00f'>$d180</font> Tk./$measuringUnit.</p>";
	
	}elseif($measuringUnit=="mh"){

		$d30=getEqAccConsumtion($edat1,30,$re[itemCode],$re[eqId]); // hr
		$d90=getEqAccConsumtion($edat1,90,$re[itemCode],$re[eqId]); // hr
		$d180=getEqAccConsumtion($edat1,180,$re[itemCode],$re[eqId]); // hr
		
			$d30=sec2hms($d30);
			$d90=sec2hms($d90);
			$d180=sec2hms($d180);
		
	   echo " <b>Average Fuel Consumption:</b> <a href='./equipment/eqReport.php?month=1&assetID=$re[eqId]&itemCode=$re[itemCode]&pcode=$project' target='_blank'>1 month</a>: <font color='#00f'>$d30</font> Tk./hrs.<br> <a href='./equipment/eqReport.php?month=3&assetID=$re[eqId]&itemCode=$re[itemCode]&pcode=$project' target='_blank'>3 months</a>: <font color='#00f'>$d90</font> Tk./hrs.<br> <a href='./equipment/eqReport.php?month=6&assetID=$re[eqId]&itemCode=$re[itemCode]&pcode=$project' target='_blank'>6 months</a>: <font color='#00f'>$d180</font> Tk./hrs.</p>";		
		
	}elseif($measuringUnit=="ue"){
		
		$d30=get_erp_per_hr_ltr($re[eqId],$re[itemCode],$edat1,30,$project); //erp hr
		$d90=get_erp_per_hr_ltr($re[eqId],$re[itemCode],$edat1,90,$project); //erp hr
		$d180=get_erp_per_hr_ltr($re[eqId],$re[itemCode],$edat1,180,$project); //erp hr
		
			$d30=sec2hms($d30);
			$d90=sec2hms($d90);
			$d180=sec2hms($d180);
		
	   echo " <b>Average Fuel Consumption:</b> <a href='./equipment/eqReport.php?month=1&assetID=$re[eqId]&itemCode=$re[itemCode]&pcode=$project' target='_blank'>1 month</a>: <font color='#00f'>$d30</font> Ltr./hrs.<br> <a href='./equipment/eqReport.php?month=3&assetID=$re[eqId]&itemCode=$re[itemCode]&pcode=$project' target='_blank'>3 months</a>: <font color='#00f'>$d90</font> Ltr./hrs.<br> <a href='./equipment/eqReport.php?month=6&assetID=$re[eqId]&itemCode=$re[itemCode]&pcode=$project' target='_blank'>6 months</a>: <font color='#00f'>$d180</font> Ltr./hrs.</p>";
	}
	 
	 		$d30="";
			$d90="";
			$d180="";

	 
	   ?>	  
	  </td>  
	<td>
   <? 
	$dailyworkBreakt=eq_dailyworkBreak($re[eqId],$re[itemCode],$edat1,$type,$project);
    $dailyBreakDownt=eq_dailyBreakDown($re[eqId],$re[itemCode],$edat1,$type,$project);
	$toDaypresent=eq_toDaypresent($re[eqId],$re[itemCode],$edat1,$type,$project);
	
    $toDaypresent=$toDaypresent-$dailyworkBreakt;	
	
	$workt= eq_dailywork($re[eqId],$re[itemCode],$edat1,$type,$project);
	$overtimet = $toDaypresent-8*3600;
	if($overtimet<0) $overtimet=0;
	$idlet=$toDaypresent-$workt-$dailyBreakDownt;
	  if($idlet<0) $idlet=0;
      
    ?>
	<? echo ' Present: '.sec2hms($toDaypresent/3600,$padHours=true).' hrs.';?><br>
	<? echo '  Worked: '.sec2hms($workt/3600,$padHours=true).' hrs.';?><br>
	<? echo ' Overtime: '.sec2hms($overtimet/3600,$padHours=true).' hrs.';?><br>
	<? echo ' BreakDown: '.sec2hms($dailyBreakDownt/3600,$padHours=true).' hrs.';?><br>		
    <? echo ' Idle '.sec2hms($idlet/3600,$padHours=true).' hrs.';?>
	</td>
	<td>
<? 
$presentTotal=0;
$overtimeTotal=0;
$workedTotal=0;
$idleTotal=0;
$idleTotalp=0;
$breakDownTotal=0;
$breakDownTotalp=0;
$overtimeTotalp=0;
$workedTotalp=0;

$sqlquery1="SELECT eqattendance.* FROM eqattendance".
" where eqattendance.location='$project'".
"AND eqattendance.edate BETWEEN '$from' AND '$edat1'".
" AND action in('P','HP')  AND eqattendance.eqId='$re[eqId]'  AND eqattendance.itemCode='$re[itemCode]'";
//echo $sqlquery1;

 $sql1= mysqli_query($db, $sqlquery1);
 while($re1=mysqli_fetch_array($sql1)){

  $dailyworkBreakt=eq_dailyworkBreak($re[eqId],$re[itemCode],$re1[edate],$type,$project);
  $dailyBreakDownt=eq_dailyBreakDown($re[eqId],$re[itemCode],$re1[edate],$type,$project);	
	$toDaypresent=eq_toDaypresent($re[eqId],$re[itemCode],$re1[edate],$type,$project);
	
  $toDaypresent=$toDaypresent-$dailyworkBreakt;
	
	$workt= eq_dailywork($re[eqId],$re[itemCode],$re1[edate],$type,$project);

if(date('D',strtotime($re1[edate]))=='Fri')
 $overtimet = $toDaypresent-(4*3600);
else 
	$overtimet = $toDaypresent-(8*3600);


	if($overtimet<0) $overtimet=0;
	$idlet=$toDaypresent-$workt-$dailyBreakDownt;
	if($idlet<0) $idlet=0;  

$presentTotal=$presentTotal+$toDaypresent;   
$overtimeTotal=$overtimeTotal+$overtimet;
$workedTotal=$workedTotal+$workt;
$breakDownTotal=$breakDownTotal+$dailyBreakDownt; 
$idleTotal=$idleTotal+$idlet; 

//echo "<br>date:$re1[edate]= Present:$toDaypresent--worked:$workt--overtime:$overtimet--idle:$idlet***presentTotal:$presentTotal **<br>";

$toDaypresent=0;
$overtimet=0;
$workt=0;
$idlet=0;

}
?>

	<? 
	if($presentTotal){
	$workedTotalp=number_format(($workedTotal*100)/($presentTotal));
	$overtimeTotalp=number_format(($overtimeTotal*100)/($presentTotal));
	$breakDownTotalp=number_format(($breakDownTotal*100)/($presentTotal));
	$idleTotalp=number_format(($idleTotal*100)/($presentTotal));
}
	//echo "<br>presentTotal:$presentTotal--idleTotal:$idleTotal<br>";
		
	$presentTotal=sec2hms($presentTotal/3600,$padHours=false);
	$overtimeTotal=sec2hms($overtimeTotal/3600,$padHours=false);
	$workedTotal=sec2hms($workedTotal/3600,$padHours=false);
	$breakDownTotal=sec2hms($breakDownTotal/3600,$padHours=false);	
	$idleTotal=sec2hms($idleTotal/3600,$padHours=false);
	//echo "<br>presentTotal:$presentTotal--idleTotal:$idleTotal<br>";
	?>


	<? echo 'Present: '.$presentTotal.' hrs.';
	//   echo " (<font class=out>$presentTotalp %</font>) "; 
	?><br>	
	<? echo 'Worked: '.$workedTotal.' hrs.';
	   echo " (<font class=out>$workedTotalp %</font>) "; 
	?><br>	
	<? echo 'Overtime: '.$overtimeTotal.' hrs.';
	   echo " (<font class=out>$overtimeTotalp %</font>)"; 
	?> <br>
	<? echo 'BreakDown: '.$breakDownTotal.' hrs.';
	   echo " (<font class=out>$breakDownTotalp %</font>)"; 
	?> <br>
    <? echo 'Idle: '.$idleTotal.' hrs.';
	   echo " (<font class=out>$idleTotalp %</font>)"; 	
	?>
	</td>
	<td>	
<? 
$presentTotal=0;
$workedTotal=0;
$workedTotalp=0;
$idleTotal=0;
$idleTotalp=0;
$breakDownTotal=0;
$breakDownTotalp=0;
$overtimeTotal=0;
$overtimeTotalp=0;


$sqlquery1="SELECT eqattendance.* FROM eqattendance".
" where eqattendance.location='$project'".
"AND eqattendance.edate <='$edat1'".
" AND action in('P','HP')  AND eqattendance.eqId='$re[eqId]'  AND eqattendance.itemCode='$re[itemCode]'";
//echo $sqlquery1;

 $sql1= mysqli_query($db, $sqlquery1);
 while($re1=mysqli_fetch_array($sql1)){

  $dailyworkBreakt=eq_dailyworkBreak($re[eqId],$re[itemCode],$re1[edate],$type,$project);
  $dailyBreakDownt=eq_dailyBreakDown($re[eqId],$re[itemCode],$re1[edate],$type,$project);	
	$toDaypresent=eq_toDaypresent($re[eqId],$re[itemCode],$re1[edate],$type,$project);
	
    $toDaypresent=$toDaypresent-$dailyworkBreakt;	
	
	$workt= eq_dailywork($re[eqId],$re[itemCode],$re1[edate],$type,$project);
//echo $workt.">>";
if(date('D',strtotime($re1[edate]))=='Fri')
 $overtimet = $toDaypresent-(4*3600);
else 
	$overtimet = $toDaypresent-(8*3600);


	if($overtimet<0) $overtimet=0;
	$idlet=$toDaypresent-$workt-$dailyBreakDownt;
	  if($idlet<0) $idlet=0;	  
//echo $idlet."::>>".$re[itemCode]."//";
$presentTotal=$presentTotal+$toDaypresent;   
$overtimeTotal=$overtimeTotal+$overtimet;
$workedTotal=$workedTotal+$workt;
$breakDownTotal=$breakDownTotal+$dailyBreakDownt; 
$idleTotal=$idleTotal+$idlet; 

//echo "<br>date:$re1[edate]= Present:$toDaypresent--worked:$workt--overtime:$overtimet--idle:$idlet***presentTotal:$presentTotal **<br>";
$toDaypresent=0;
$overtimet=0;
$workt=0;
$idlet=0;
$breakDownt=0;

 }
?>	

	<? 
	if($presentTotal){
	$workedTotalp=number_format(($workedTotal*100)/($presentTotal));
	$overtimeTotalp=number_format(($overtimeTotal*100)/($presentTotal));
	$breakDownTotalp=number_format(($breakDownTotal*100)/($presentTotal));
	$idleTotalp=number_format(($idleTotal*100)/($presentTotal));
}
	//echo "<br>presentTotal:$presentTotal--idleTotal:$idleTotal<br>";
		
	$presentTotal=sec2hms($presentTotal/3600,$padHours=false);
	$overtimeTotal=sec2hms($overtimeTotal/3600,$padHours=false);
	$workedTotal=sec2hms($workedTotal/3600,$padHours=false);
	$breakDownTotal=sec2hms($breakDownTotal/3600,$padHours=false);	
	$idleTotal=sec2hms($idleTotal/3600,$padHours=false);
	//echo "<br>presentTotal:$presentTotal--idleTotal:$idleTotal<br>";
	?>


	<? echo 'Present: '.$presentTotal.' hrs.';
	//   echo " (<font class=out>$presentTotalp %</font>) ";
	?><br>
	<? echo 'Worked: '.$workedTotal.' hrs.';
	   echo " (<font class=out>$workedTotalp %</font>)"; 
	?><br>
	<? echo 'Overtime: '.$overtimeTotal.' hrs.';
	   echo " (<font class=out>$overtimeTotalp %</font>)";
	?> <br>
	<? echo 'BreakDown: '.$breakDownTotal.' hrs.';
	   echo " (<font class=out>$breakDownTotalp %</font>)"; 
	?> <br>
    <? echo 'Idle: '.$idleTotal.' hrs.';
	   echo " (<font class=out>$idleTotalp %</font>)"; 	
	?>
	</td>

 </tr>
 <? $i++;
 
$overtimeTotal=0;
$workedTotal=0;
$idleTotal=0;

 } //while?>
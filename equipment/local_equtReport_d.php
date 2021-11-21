<?
error_reporting(E_ERROR | E_PARSE);
?>
<? if($loginProject=='000'){?>
<table width="95%" align=center>
	<tr>
		<td></td>
		<td>
</td>
	</tr>
</table>
<? } //loginProject
if($project=='') $project=$loginProject;?>
<script>
$(document).ready(function(){
	var changeMonth=$("#changeMonth");
});
</script>

<table align="center" width="95%" border="3" bgcolor="#FFFFFF"  bordercolor="CC9999" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
	<tr>
		<td colspan=6 bgcolor="#CC9999">
		<form name="pro" method="post" >
<font color="#fff">Select Project:</font> <select name="project" onChange="location.href='index.php?keyword=local+eq+ut+report+d&project='+pro.project.options[document.pro.project.selectedIndex].value";>
<option value="">Select Project</option>
<?
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sql="select * from project";
$sqlq=mysqli_query($db, $sql);
while($sqlr=mysqli_fetch_array($sqlq)){
echo "<option value=$sqlr[pcode]";
if($project==$sqlr[pcode]) echo " SELECTED ";
 echo ">";
echo "$sqlr[pcode]--$sqlr[pname]</option>";
}
?>
</select>
</form>
		</td>
		<td bgcolor="#CC9999" align=right><font class='englishhead'>equipment log report</font></td>
	</tr>
<tr bgcolor="#CC9999" <?php if($project=="")echo "style='display:none'"; ?>>
 <td colspan="5">
 <form action="./index.php?keyword=local+eq+ut+report+d&project=<? echo $project;?>"  method="post" id="myForm">
	<select name="year" size=1 id="changeYear">
		<?php
		$year=date("Y");
		$i=$year;
		while($year-5<$i){
			echo "<option value='$i'>$i</option>";
			$i--;
		}
		?>
	 </select>
	 
  <select name="month" size="1" id="changeMonth" >
   <option value="" >Select Month</option>
   <option value="01" <? if($month=='01') echo 'selected';?> >January</option>
   <option value="02" <? if($month=='02') echo 'selected';?>>February</option>
   <option value="03" <? if($month=='03') echo 'selected';?>>March</option>
   <option value="04" <? if($month=='04') echo 'selected';?>>April</option>
   <option value="05" <? if($month=='05') echo 'selected';?>>May</option>
   <option value="06" <? if($month=='06') echo 'selected';?>>June</option>
   <option value="07" <? if($month=='07') echo 'selected';?>>July</option>
   <option value="08" <? if($month=='08') echo 'selected';?>>August</option>
   <option value="09" <? if($month=='09') echo 'selected';?>>September</option>
   <option value="10" <? if($month=='10') echo 'selected';?>>October</option>
   <option value="11" <? if($month=='11') echo 'selected';?>>November</option>
   <option value="12" <? if($month=='12') echo 'selected';?>>December</option>
</select>

<select name='eqId' size='1'>
<option value="">Select Equipment</option>
<? 
include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT distinct eqattendance.eqId,itemlist.itemCode,itemlist.itemDes,itemlist.itemSpec  from".
" eqattendance,`itemlist` Where itemlist.itemCode>='50-00-000' AND itemlist.itemCode < '70-00-000' ";
if($year && $month){
	$selectedMonth="$year-$month-%";
	$sqlp.=" and eqattendance.edate like '$selectedMonth' ";
}
$sqlp .=" AND itemlist.itemCode=eqattendance.itemCode AND eqattendance.location='$project' and eqattendance.eqId!='' ORDER by itemlist.itemCode,eqattendance.eqId ASC";
// echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

 while($typel= mysqli_fetch_array($sqlrunp))
{
if(eqType($typel[eqId])=='H')
$eqIds=eqpId($typel[eqId],$typel[itemCode]);
else if(eqType($typel[eqType])=='L')
$eqIds=eqpId_local($typel[eqId],$typel[itemCode]);
else continue;

 echo "<option value='".$eqIds."'";

 if($eqId==$eqIds) echo "SELECTED";
 echo ">".$eqIds."--$typel[itemDes]--$typel[itemSpec]</option>  ";
}
 ?>
</select>
<input type="submit" value="Go" onClick="this.name='submit'">
</form>
	 <script type="text/javascript">
	 $(document).ready(function(){
		 $("#changeMonth").change(function(){
			 $("#myForm").submit();
		 });
		 $("#changeYear").change(function(){
			 $("#myForm").submit();
		 });
	 });
	 </script>
<? //echo $sqlp;?>
 </td>
 <td colspan="2" align="right" valign="top"></td>
</tr>
	
	
<? //echo $sqlp.'<br>';?>
<tr>
 <th width="100">Date</th>
 <th>Start - Finish = Present</th>
 <th>Worked</th>
 <th>Over time</th> 
 <th>Break Down</th>
 <th>Idle</th>
 <th>Fuel Consumption</th>
</tr>
<? 
if($month){
//echo "****$eqId******";
$t=explode('-',$eqId);
 if($t[2]{0}=='A')                 
 {  $eqId=$t[2]; $eqType='L';}
else   
{ $eqId=0+$t[2];
  $eqType='H';
}
$itemCode="$t[0]-$t[1]-000";

$year=date("Y");
$fromD="$year-$month-01";
$daysofmonth=daysofmonth($fromD);
$toD="$year-$month-$daysofmonth";

include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

/*$fromD='2006-03-29';
$toD='2006-03-31';
*/
/*$sqlut = "SELECT DISTINCT edate FROM equt WHERE".
" eqId='$eqId' AND itemCode='$itemCode' AND pcode='$project'".
" AND edate BETWEEN '$fromD' AND '$toD'".
" ORDER by edate ASC";
*/
if($submit)
echo $sqlut="SELECT DISTINCT edate FROM eqattendance WHERE".
" eqId='$eqId' AND itemCode='$itemCode' AND location='$project'".
" AND edate BETWEEN '$fromD' AND '$toD'".
" ORDER by edate ASC";

//echo $sqlut;
$sqlqut= mysqli_query($db, $sqlut);
$i=1;
$sqlr=mysqli_num_rows($sqlqut);
while($reut= mysqli_fetch_array($sqlqut)){?>
	<tr <? if(date('D',strtotime($reut[edate]))=='Fri') echo "bgcolor=#FFFFCC"; elseif($i%2==0) echo "bgcolor=#EFEFEF";?>>
		<td align="center">
			<a href='./equipment/local_equtReport_byEq_detail.php?eqId=<? echo $eqId;?>&itemCode=<? echo $itemCode;?>&eqType=<? echo $eqType;?>&edate=<? echo $reut[edate];?>' target='_blank'> 
		       <font color="#00f"><? echo myDate($reut[edate]);?></font>
 			</a> 
			<?
		$dailyworkBreakt=eq_dailyworkBreak($eqId,$itemCode,$reut[edate],$eqType,$project);
		$dailyBreakDownt=eq_dailyBreakDown($eqId,$itemCode,$reut[edate],$eqType,$project);

		$toDaypresent=eq_toDaypresent($eqId,$itemCode,$reut[edate],$eqType,$project);

		$toDaypresent=$toDaypresent-$dailyworkBreakt;
		//$workt= eq_dailywork($eqId,$itemCode,$edate,'H',$loginProject);
		$workt= eq_dailywork($eqId,$itemCode,$reut[edate],$eqType,$project)-$dailyworkBreakt;
		
		if($workt<0)$workt=0;
	
		$overtimet = $toDaypresent-(8*3600);

		if($overtimet<0) $overtimet=0;
		$idlet=$toDaypresent-$workt-$dailyBreakDownt;
			if($idlet<0) $idlet=0;
	?>
</td>
		
  <td align="center"> <? 
$hour_row=get_eq_hours($eqId,$itemCode,$reut[edate]);
echo $hour_row[stime]." - ".$hour_row[etime]. " = ";
																					
$preset= sec2hms($toDaypresent/3600,$padHours=false);   echo $preset.' Hrs.'; 
   $totalPresent=$totalPresent+$toDaypresent;?>
   </td>
  <td align="center"> <? echo $work= sec2hms($workt/3600,$padHours=false);?>
   </td>
  <td align="center"> <?  $overtime=sec2hms($overtimet/3600,$padHours=false);  echo $overtime.' Hrs.';  
  $totalOverTime=$totalOverTime+$overtimet;?>
  </td>
  <td align="center"> <?  $breakDown=sec2hms($dailyBreakDownt/3600,$padHours=false);  echo $breakDown.' Hrs.';  
   $totalBreakDown=$totalBreakDown+$dailyBreakDownt;?>
   </td>
  <td align="center"> <?  $idle=sec2hms($idlet/3600,$padHours=false);  echo $idle.' Hrs.'; 
    $totalIdel=$totalIdel+$idlet;?>
	</td>
	
	<td>		
		<?php
			$assetID=$eqId;
			$xDaysAgo=$reut[edate];
			//    From utilization
			$eq_sql="select issueDate,km_h_qty,issuedQty,issueRate,unit,itemCode from issue$project where eqID='$assetID"."_"."$itemCode' and issueDate='$xDaysAgo' order by km_h_qty desc";
			//   echo $eq_sql;
			$eq_q=mysqli_query($db,$eq_sql);   
			while($eq_row=mysqli_fetch_array($eq_q)){
				
				if($eq_row["unit"]=="ue")$eq_row["km_h_qty"]=getUsageofEQ($itemCode,$assetID,$xDaysAgo); //erp hr
				//print_r($eq_row);
			$measureUnit=$eq_row["unit"]=="ue" ? "Hour " : "";
				
			if($eq_row["km_h_qty"]>0)
				if($eq_row["unit"]!="km" && $eq_row["unit"]!="ue")
				$eq_row["km_h_qty"]=sec2hms(round($eq_row["km_h_qty"],2));
				elseif($eq_row["unit"]=="km")$eq_row["km_h_qty"]=round($eq_row["km_h_qty"]);
					
				$itemDesC=itemDes($eq_row[itemCode]);

				$a = measuerUnti();
				$b = $eq_row["unit"];
				$c = $a[$b];
				if($eq_row["km_h_qty"])
				$rowAA[]=array("<font color='#00f'>".number_format($eq_row["km_h_qty"],2)."</font> ".$c

			,"<b>".$itemDesC[des]."</b>: <font color='#00f'>".number_format($eq_row["issuedQty"],2)."</font> Ltr");  
			}
			//  End of utilization
										
			//  Accounts payment start
			$eqacc_sql="select edate,km,qty,amount,uItemCode from accEqConsumption where eqID='$assetID' and eqItemCode='$itemCode' and edate='$xDaysAgo' order by km desc";
			//    echo $eqacc_sql;
			$eqacc_q=mysqli_query($db,$eqacc_sql);  
			$amount=0;
			while($eqacc_row=mysqli_fetch_array($eqacc_q)){
				$itemDesC=itemDes($eqacc_row[uItemCode]);
				$eqDes=itemDes($itemCode);    
				
			//     Get equipment measurement unit
				$sql_eq_con="select measureUnit from eqconsumsion where eqitemCode='$itemCode' limit 1";
				$q_eq_con=mysqli_query($db,$sql_eq_con);
				$row_eq=mysqli_fetch_array($q_eq_con); 
				$measureUnit=$row_eq[measureUnit]=="ue" ? "Hour " : ($row_eq[measureUnit]=="km" ? "Km" : "");        
				
				if($eqacc_row["qty"])
				$rowAA[]=array("Meter: <font color='#00f'>".number_format($eqacc_row["km"],2)." $measureUnit</font>, <b>".$itemDesC[des]."</b> ". number_format($eqacc_row["qty"],2)   .", $itemDesC[unit]: <font color='#00f'>Tk. ".number_format($eqacc_row["amount"],2)."</font>");
			}
													
			echo "<table width='100%'>";
			foreach($rowAA as $rowAA_){
				echo "<tr><td>$rowAA_[0]</td><td>$rowAA_[1]</td></tr>";
			}
			unset($rowAA);
			echo "</table>";
		?>
    </td>
		
 </tr>
 <? $i++;
}?>
 <? }?>
 <? if($sqlr){ ?>
 <tr bgcolor="#CC9999">
  <td align="center"> <? echo $sqlr;?> days</td>
  <td align="center"> <? echo sec2hms($totalPresent/3600,$padHours=false); ?> Hrs.</td>  
  <td align="center"> <? echo sec2hms($totalWork/3600,$padHours=false);?> Hrs. (<? echo round(($totalWork*100)/$totalPresent);?> %)</td>  
  <td align="center"> <? echo sec2hms($totalOverTime/3600,$padHours=false); ?> Hrs. (<? echo round(($totalOverTime*100)/$totalPresent);?> %)</td>  
  <td align="center"> <? echo sec2hms($totalBreakDown/3600,$padHours=false);?> Hrs. (<? echo round(($totalBreakDown*100)/$totalPresent);?> %)</td>        
  <td align="center"> <? echo sec2hms($totalIdel/3600,$padHours=false);?> Hrs. (<? echo round(($totalIdel*100)/$totalPresent);?> %)</td>        
 </tr>
 <? }?>
	
	
	
	
<tr>
 <td colspan=2 align=right><b>Average Fuel Consumption</b></td>
	<td colspan=5><?php 
/* 
	 Equipment Meter: 50:00 hrs
	 ERP Meter: hrs.
	 Milage: km.*/
	 
	$measuringUnit=getEQmeasureUnit($itemCode);	
	if($measuringUnit=="km" || $measuringUnit=="mh"){
		
		$accd30=getEqAccConsumtion($toD,30,$itemCode,$eqId); //km 
		$accd90=getEqAccConsumtion($toD,90,$itemCode,$eqId); //km 
		$accd180=getEqAccConsumtion($toD,180,$itemCode,$eqId); //km
		
		if($accd30){
			$rateMode=true;
			$d30=get_machine_km_hr($toD,30,$project,$itemCode,$eqId,$rateMode); //km
		}
		else{
			$rateMode=false;
			$d30=get_machine_km_hr($toD,30,$project,$itemCode,$eqId); //km
		}
			
		if($accd30 && $d30)
			$d30=($accd30+$d30)/2;
		elseif($accd30 && !$d30)
			$d30=$accd30;
		
		if($accd90){
			$rateMode=true;
			$d90=get_machine_km_hr($toD,90,$project,$itemCode,$eqId,$rateMode); //km
		}
		else{
			$rateMode=false;
			$d90=get_machine_km_hr($toD,90,$project,$itemCode,$eqId); //km
		}
			
		if($accd90 && $d90)
			$d90=($accd90+$d90)/2;
		elseif($accd90 && !$d90)
			$d90=$accd90;
		
		if($accd180){
			$rateMode=true;
			$d180=get_machine_km_hr($toD,180,$project,$itemCode,$eqId,$rateMode); //km
		}
		else{
			$rateMode=false;
			$d180=get_machine_km_hr($toD,180,$project,$itemCode,$eqId); //km
		}
			
		if($accd180 && $d180)
			$d180=($accd180+$d180)/2;
		elseif($accd180 && !$d180)
			$d180=$accd180;
		
	
	 if($measuringUnit=="mh"){
		
			$d30=sec2hms($d30);
			$d90=sec2hms($d90);
			$d180=sec2hms($d180);
		 
		 	$MesureUnit="Tk.";  //depend upto amount or ltr or tk.
		 
	   echo "<p>  <a href='./equipment/eqReport.php?month=1&assetID=$eqId&itemCode=$itemCode&pcode=$project' target='_blank'>1 month</a>: <font color='#00f'>$d30</font> $MesureUnit/hrs. | <a href='./equipment/eqReport.php?month=3&assetID=$eqId&itemCode=$itemCode&pcode=$project' target='_blank'>3 months</a>: <font color='#00f'>$d90</font> $MesureUnit/hrs. | <a href='./equipment/eqReport.php?month=6&assetID=$eqId&itemCode=$itemCode&pcode=$project' target='_blank'>6 months</a>: <font color='#00f'>$d180</font> $MesureUnit/hrs.</p>";
	}else{
		 	$MesureUnit=$rateMode ? "Tk." : "Ltr.";  //depend upto amount or ltr or tk.
	   echo "<p>  <a href='./equipment/eqReport.php?month=1&assetID=$eqId&itemCode=$itemCode&pcode=$project' target='_blank'>1 month</a>: <font color='#00f'>$d30</font> $MesureUnit/$measuringUnit. | <a href='./equipment/eqReport.php?month=3&assetID=$eqId&itemCode=$itemCode&pcode=$project' target='_blank'>3 months</a>: <font color='#00f'>$d90</font> $MesureUnit/$measuringUnit. | <a href='./equipment/eqReport.php?month=6&assetID=$eqId&itemCode=$itemCode&pcode=$project' target='_blank'>6 months</a>: <font color='#00f'>$d180</font> $MesureUnit/$measuringUnit.</p>"; 
	 }
	}elseif($measuringUnit=="ue"){
		
		$accd30=getEqAccConsumtion($toD,30,$itemCode,$eqId,$measuringUnit); //ue 
		$accd90=getEqAccConsumtion($toD,90,$itemCode,$eqId,$measuringUnit); //ue 
		$accd180=getEqAccConsumtion($toD,180,$itemCode,$eqId,$measuringUnit); //ue 
		
		if($accd30){
			$rateMode=true;
			$d30=get_erp_per_hr_ltr($eqId,$itemCode,$toD,30,$project,$rateMode); //issue and erp hr
		}
		else{
			$rateMode=false;
			$d30=get_erp_per_hr_ltr($eqId,$itemCode,$toD,30,$project); //issue and erp hr
		}
			
		if($accd30 && $d30)
			$d30=($accd30+$d30)/2;
		elseif($accd30 && !$d30)
			$d30=$accd30;
		
		
		
		
		if($accd90){
			$rateMode=true;
			$d90=get_erp_per_hr_ltr($eqId,$itemCode,$toD,90,$project,$rateMode); //issue and erp hr
		}
		else{
			$rateMode=false;
			$d90=get_erp_per_hr_ltr($eqId,$itemCode,$toD,90,$project); //issue and erp hr
		}
		if($accd90 && $d90)
			$d90=($accd90+$d90)/2;
		elseif($accd90 && !$d90)
			$d90=$accd90;
		

		
		if($accd180){
			$rateMode=true;
			$d180=get_erp_per_hr_ltr($eqId,$itemCode,$toD,180,$project,$rateMode); //issue and erp hr
		}
		else{
			$rateMode=false;
			$d180=get_erp_per_hr_ltr($eqId,$itemCode,$toD,180,$project); //issue and erp hr
		}
			
		if($accd180 && $d180)
			$d180=($accd180+$d180)/2;
		elseif($accd180 && !$d180)
			$d180=$accd180;
		  
		
		 	$MesureUnit=$rateMode ? "Tk." : "Ltr.";  //depend upto amount or ltr or tk.
		
			$d30=sec2hms($d30);
			$d90=sec2hms($d90);
			$d180=sec2hms($d180);
		
	   echo "<p>  <a href='./equipment/eqReport.php?month=1&assetID=$eqId&itemCode=$itemCode&pcode=$project' target='_blank'>1 month</a>: <font color='#00f'>$d30</font> $MesureUnit/hrs. | <a href='./equipment/eqReport.php?month=3&assetID=$eqId&itemCode=$itemCode&pcode=$project' target='_blank'>3 months</a>: <font color='#00f'>$d90</font> $MesureUnit/hrs. | <a href='./equipment/eqReport.php?month=6&assetID=$eqId&itemCode=$itemCode&pcode=$project' target='_blank'>6 months</a>: <font color='#00f'>$d180</font> $MesureUnit/hrs.</p>";
}
	 
	 		$d30="";
			$d90="";
			$d180="";

	   
?></td>
</tr>
	
	
	
	
</table>
<!-- <a href="./print/print_local_equtReport_d.php?project=<? echo $project;?>&month=<? echo $month;?>&itemCode=<? echo $itemCode;?>&eqId=<? echo $eqId;?>" target="_blank">Print</a> -->
<a href="#" onClick="window.print();">Print</a>
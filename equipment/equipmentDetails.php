<?php
    error_reporting(E_ERROR | E_PARSE);
?>
<form name="store" action="index.php?keyword=equipment+Details&a=<? echo $a;?>" method="post">
<table align="center" width="500" class="vendorTable">
<tr class="vendorAlertHdt">
 <td colspan="2" align="right" valign="top">equipment store Search form</td>
</tr>
<tr><td>Item Code</td>
<td >
  <style>
    option{}
    option:nth-child(odd){background:#ececec;}
  </style>
<?
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

$sqlp = "SELECT itemCode,itemDes,itemSpec,itemUnit from `itemlist` WHERE itemCode BETWEEN '50-00-000' AND '69-99-000' ORDER by itemCode ASC";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp) or die();
$plist= "<select name='itemCode'> ";
$plist.= "<option value='0'>Select One</option> ";
 while($typel= mysqli_fetch_array($sqlrunp))
{
 $plist.= "<option value='".$typel[itemCode]."'";
 if($typel[itemCode]==$itemCode) $plist.= " SELECTED ";
 $plist.= ">$typel[itemCode]--$typel[itemDes]--$typel[itemSpec] --  ".equipment_counter($typel[itemCode])." Nos</option>  ";
 }
 $plist.= '</select>';
 echo $plist;
 ?>
	
<!--	<input name="itemCode1" onKeyUp="return autoTab(this, 2, event);" size="2" maxlength="2" > - 
    <input name="itemCode2" onKeyUp="return autoTab(this, 2, event);" size="2" maxlength="2"> - 000
	-->
	</td>
</tr>

<tr><td>Location</td>
<td><? 
	
$ex = array('All BFEW');
if($loginDesignation!="Project Engineer")
	$additional='<option value="">All BFEW</option>';
	
if($loginDesignation=="Project Engineer"){
	echo "<option value='$loginProject'>$loginProject</option>";
	echo "<input type='hidden' name='location' value='$loginProject'>";
}
else
	echo selectPlist('location',$ex,$location,$additional);
?></td>
</tr>
	
<tr><td>Sort by condition:</td>
	<td>
		<?php
		$sqlExtra=" and equipment.condition in ";
		if($sortByC=="r") {$extraR=" checked "; $sqlExtra.="(1,5,6) ";}
		elseif($sortByC=="m") {$extraM=" checked "; $sqlExtra.="(2,3) ";}
		elseif($sortByC=="tr") {$extraTr=" checked "; $sqlExtra.="(9) ";}
		elseif($sortByC=="u") {$extraU=" checked "; $sqlExtra.="(4) ";}
		elseif($sortByC=="a") {$extraA=" checked "; $sqlExtra="";}
		elseif($sortByC=="p") {$extraP=" checked "; $sqlExtra="";}
		
		if(!$extraR && !$extraM && !$extraTr && !$extraU && !$extraA && !$extraP){
			$extraA=" checked "; $sqlExtra="";
		}
		?>
		<input type="radio" name="sortByC" value="a" <?php echo $extraA; ?>>All
		<input type="radio" name="sortByC" value="r" <?php echo $extraR; ?>>Running
		<input type="radio" name="sortByC" value="m" <?php echo $extraM; ?>>Breakdown 
		<input type="radio" name="sortByC" value="tr" <?php echo $extraTr; ?>>Troubled Running 
		<input type="radio" name="sortByC" value="p" <?php echo $extraP; ?>>Preventive
		<input type="radio" name="sortByC" value="u" <?php echo $extraU; ?>>Unrepairable
	</td>
</tr>	
<tr><td>Sort by:</td>
	<td>
		
		<select name='sortByDays'>
			<option value='' <?php echo $sortByDays=="" ? "selected" : ""; ?> >Asset Id</option>
			<option value='asc' <?php echo $sortByDays=="asc" ? "selected" : ""; ?>>ASC Days</option>
			<option value='desc' <?php echo $sortByDays=="desc" ? "selected" : ""; ?>>DESC Days</option>
		</select>
	</td>
</tr>
<tr><td colspan="2" align="center" ><input type="submit" name="search" value="Search" class="vendorAlertHdt" ></td></tr>
</table>
</form>
	
<table align="center" width="95%" class="vendorTable">
<tr class="vendorAlertHdt">
 <td align="center" >Asset Id</td>
 <td width="500" align="center" >Asset Description</td> 
 <td width="500" align="center" >Productivity</td>  
	<td align="center" >
<? if($loginProject=='000' OR $loginProject=='002' or ($loginDesignation=="Construction Manager" && $loginProject=="004")) echo  'Rent Rate to BFEW<br>'; ?>
 Average Fuel, Oil, Lub. Consumption</td>
 <td width="176" align="center" >Location</td>  
	<?php if($loginDesignation!='Chairman & Managing Director'){ ?>
 <td width="95"></td>
 <? }
	//if(!$a){ echo "<th align='center' >Schedule</th>";     }?>
</tr>
<? include("./config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
   $sql="SELECT equipment.* FROM equipment WHERE 1 $sqlExtra ";
if($location AND $location!='Select one'){ $sql.=" AND equipment.location=$location";}

if($itemCode){ 
	$sql.=" AND equipment.itemCode LIKE '$itemCode'";
}
$sqlquery=mysqli_query($db, $sql);
$total_result=mysqli_affected_rows($db);
$total_per_page=100;

if($page<=0)
	{
	$page=1;
	}
$curr=($page-1)*$total_per_page;
	
// 	sort by condition	
	$sql.=" $sqlExtra ";
// 	end of sort by condition
if(!$sortByDays)
	$sql.=" ORDER by equipment.itemCode,equipment.assetId ASC LIMIT $curr,$total_per_page";
elseif($sortByDays)
	$sql.=" ORDER by edate $sortByDays LIMIT $curr,$total_per_page";
// echo $sql;
$sqlquery=mysqli_query($db, $sql);
$i=0;	
while($sqlresult=mysqli_fetch_array($sqlquery)){
$eqId=eqpId($sqlresult[assetId],$sqlresult[itemCode]);
	?>
<? 
$temp = explode('-',$sqlresult[assetId]);
$test =  $sqlresult[itemCode];
$temp = itemDes($sqlresult[itemCode]);

if($test!=$testp && $i>0 ){
if($loginDesignation=='Managing Director') echo "<tr class=vendorAlertHd_lite>
 <td height=10 colspan=6 align=right >
 Purchase Value of ". $temp[des].', '.$temp[spc]." is Tk. ". number_format(groupValue($test),2)."
 </td></tr>";  
echo '<tr class="vendorAlertHdt" height="2"><td colspan="10" align="right" valign="top"></td></tr>';
  }
echo '<tr class="vendorAlertHdt" height="1"><td colspan="10" align="right" valign="top"></td></tr>';
?>	


<tr>
<td align="center" width="100" valign="top">
<? if($a==0){?>
<a href="./index.php?keyword=equipment+entry&eqid=<? echo $sqlresult[eqid];?>&page=<? echo $page;?>"> <? echo $eqId ;?></a>
<!--<br><a href="./index.php?keyword=enter+eq+item+work&eqid=<? echo $sqlresult[eqid];?>&assetId=<? echo $eqId;?>"> IOW </a>-->
<? }
elseif($a==2){ ?>
	
<a href="./equipment/equipmentedit.php?eqid=<? echo $sqlresult[eqid];?>&r=1&d=2" target="_blank" > <? echo $eqId;?></a>
<? }
else{ echo  $eqId;}
?>


 <?  
 
 
 ?></td> 
 <td >
 <? 
$temp=explode('_',$sqlresult[teqSpec]);
$model=$temp[0];
$brand=$temp[1];
$manuby=$temp[2];
$madein=$temp[3];
$speci=$temp[4];
$designCap=$temp[5];
$currentCap=$temp[6];
$yearManu=$temp[7];
?>
<?
$a= itemDes($sqlresult[itemCode]);
$b = itemDes($sqlresult[itemCode]);
  if(isset($a[des]))echo '<b><font color="#00f">'.$b[des].'</font>:</b> ';
	if($currentCap) echo '<font class=out>'.$currentCap.'</font>; '; //identification
  if($model) echo 'Model <font class=out>'.$model.'</font>; ';
	if($brand) echo 'Brand <font class=out>'.$brand.'</font>; ';
  if($manuby) echo 'Manufactured by <font class=out>'.$manuby.'</font>; ';
 	if($madein) echo 'Made in <font class=out>'.$madein.'</font>; ';
	if($specin) echo 'Specification <font class=out>' .$specin.'</font>; ';
	if($designCap) echo 'Design Capacity <font class=out>'.$designCap.'</font>; '; 
	if($yearManu) echo 'Year of Manufacture <font class=out>'.$yearManu.'</font>; ';
	
	echo "<br><b>Fuel:</b> ".$eqc=eqconsumsionFuelRowData($sqlresult[itemCode],false,false,"f","<br>");
	echo "<br><b>Oil & Lub.:</b> ".$eqc=eqconsumsionFuelRowData($sqlresult[itemCode],false,false,"ol","<br>");

	
	// $typeTxtArr=short2longEqConditionOld($sortByC);
	// foreach($typeTxtArr as $key=>$typeTxt){}
	 	
if($key && $typeTxt)
	$reason=getEqLastReason($sqlresult[assetId],$sqlresult[itemCode],$typeTxt);
if($reason){
	$fullText=getEquipmentConditions($key,null,true);
	echo "<br><b><font color='#f00'>$fullText[$key]:</font></b> ";
	echo $reason;
}	
  ?> 
 </td>
<td align="center"><? echo $sqlresult[exp];?></td>
<td  align="right">
<? if($loginProject=='000' OR $loginProject=='002' or ($loginDesignation=="Construction Manager" && $loginProject=="004")){?>
	Rent Tk. 
			<? echo $cRate= rentRate($sqlresult[price],$sqlresult[salvageValue],$sqlresult[life],$sqlresult[days],$sqlresult[hours]);?>/ 
      day<br>
 <? }?>	
		
		
		<?php 
	$eqId=$sqlresult[assetId];
	$itemCode=$sqlresult[itemCode];
	$project=$sqlresult[location];
	$toD=todat();
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
		

		if($accd30 && $d30 && !is_nan($d30))
			$d30=($accd30+$d30)/2;
		elseif($accd30 && (!$d30 || is_nan($d30)) )
			$d30=$accd30;

		
		if($accd90){
			$rateMode=true;
			$d90=get_machine_km_hr($toD,90,$project,$itemCode,$eqId,$rateMode); //km
		}
		else{
			$rateMode=false;
			$d90=get_machine_km_hr($toD,90,$project,$itemCode,$eqId); //km
		}
    
   

			
   if($accd90 && $d90 && !is_nan($d90))
			$d90=($accd90+$d90)/2;
elseif($accd90 && (!$d90 || is_nan($d90)) )
			$d90=$accd90;
		
		
		
		if($accd180){
			$rateMode=true;
			$d180=get_machine_km_hr($toD,180,$project,$itemCode,$eqId,$rateMode); //km
		}
		else{
			$rateMode=false;
			$d180=get_machine_km_hr($toD,180,$project,$itemCode,$eqId); //km
		}

		

			
		if($accd180 && $d180 && !is_nan($d180))
			$d180=($accd180+$d180)/2;
		elseif($accd180 && (!$d180 || is_nan($d180)) )
			$d180=$accd180;
		
	
	 if($measuringUnit=="mh"){
		
			$d30=sec2hms($d30);
			$d90=sec2hms($d90);
			$d180=sec2hms($d180);
		 
     
     if($rateMode)     
		  $MesureUnit="Tk.";  //depend upto amount or ltr or tk.
     else
		  $MesureUnit="ltr.";  //depend upto amount or ltr or tk.
		 
	   echo "<p>  <a href='./equipment/eqReport.php?month=1&assetID=$eqId&itemCode=$itemCode&pcode=$project' target='_blank'>1 month</a>: <font color='#00f'>$d30</font> $MesureUnit/hrs. <br> <a href='./equipment/eqReport.php?month=3&assetID=$eqId&itemCode=$itemCode&pcode=$project' target='_blank'>3 months</a>: <font color='#00f'>$d90</font> $MesureUnit/hrs. <br> <a href='./equipment/eqReport.php?month=6&assetID=$eqId&itemCode=$itemCode&pcode=$project' target='_blank'>6 months</a>: <font color='#00f'>$d180</font> $MesureUnit/hrs.</p>";
	}else{
		 	$MesureUnit=$rateMode ? "Tk." : "Ltr.";  //depend upto amount or ltr or tk.
	   echo "<p>  <a href='./equipment/eqReport.php?month=1&assetID=$eqId&itemCode=$itemCode&pcode=$project' target='_blank'>1 month</a>: <font color='#00f'>$d30</font> $MesureUnit/$measuringUnit. <br> <a href='./equipment/eqReport.php?month=3&assetID=$eqId&itemCode=$itemCode&pcode=$project' target='_blank'>3 months</a>: <font color='#00f'>$d90</font> $MesureUnit/$measuringUnit. <br> <a href='./equipment/eqReport.php?month=6&assetID=$eqId&itemCode=$itemCode&pcode=$project' target='_blank'>6 months</a>: <font color='#00f'>$d180</font> $MesureUnit/$measuringUnit.</p>"; 
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
		
	    echo "<p>  <a href='./equipment/eqReport.php?month=1&assetID=$eqId&itemCode=$itemCode&pcode=$project' target='_blank'>1 month</a>: <font color='#00f'>$d30</font> $MesureUnit/hrs. <br> <a href='./equipment/eqReport.php?month=3&assetID=$eqId&itemCode=$itemCode&pcode=$project' target='_blank'>3 months</a>: <font color='#00f'>$d90</font> $MesureUnit/hrs. <br> <a href='./equipment/eqReport.php?month=6&assetID=$eqId&itemCode=$itemCode&pcode=$project' target='_blank'>6 months</a>: <font color='#00f'>$d180</font> $MesureUnit/hrs.</p>";
}
	 		$d30="";
			$d90="";
			$d180="";	   
?>
		
	
	</td>
<td align="center">
	 <? echo myprojectName($sqlresult[location]);?>,<br> <? echo eqCondition($sqlresult[condition]);

if($sqlresult[condition]=="2" || $sqlresult[condition]=="3"){
echo "; ";
	echo $toalDay=number_format((strtotime(todat())-strtotime($sqlresult[edate]))/86400);
	echo " days";
	echo "<br>Productivity loss: Tk. <font color='#f00'>".number_format(str_replace(",","",$toalDay) * str_replace(",","",$cRate));
	echo "</font>";
}
	?>
	
</td>
 <!--create code by salma-->
 <?
	
 if($loginDesignation=='Accounts Manager')
 {
 ?>
<!-- | <a href='./equipment/equipmentSql.php?eqid=$sqlresult[eqid];&d=1'> DELETE</a> //stop by salma--> 
 
 <? if(!$a){ echo "<td><a href='./equipment/equipmentSql.php?eqid=$sqlresult[eqid];&d=1'> DELETE</a>
 
 </td>";}
 }
 else
 {
	if($loginDesignation != 'MIS')
if(!$a){ echo "<td><a href='./equipment/equipmentedit.php?eqid=$sqlresult[eqid]&d=2'> EDIT </a>
</td>";}
}
 
 ?>
<? $i++;
 echo "</tr>"; 
$testp= $test;
}
if($loginDesignation=='Managing Director'){
  $test1=$test;
  $temp = itemDes($test1);
 echo "<tr class=vendorAlertHd_lite>
 <td height=10 colspan=6 align=right >
 Purchase Value of ". $temp[des].', '.$temp[spc]." is Tk. ". number_format(groupValue($test),2)."
 </td></tr>";  

?>
<tr class="vendorAlertHdt" height="25">
 <td colspan="10" align="right" valign="top">Purchase Value of all Equipments is TK. 
 <? echo number_format(allEquipmetValue(),2)?> </td>
</tr>
<? } ?>

</table>
 <?php

        include("./includes/PageNavigation.php");
        $totalResults= $total_result;
        $resultsPerPage= $total_per_page;
        $page= $_GET[page];
        $startHTML= "<b>Showing Page <font class=out>{page}</font> of {pages}</b>: Go to Page ";
        $appendSearch= "&a=$a";
        $range= 5;
		$rootLink="./index.php?keyword=equipment+details&sortByC=$sortByC";
        $link_on= "<a href='$rootLink&page={num}{appendSearch}'><b><font class=larg>{num}</larg></b></a>";
        $link_off= "<a href='$rootLink&page={num}{appendSearch}'>{num}</a>";
        $back= " <a href='$rootLink&page=1{appendSearch}'><<</a> ";
        $forward= " <a href='$rootLink&page={pages}{appendSearch}'>>></a> ";

        $myNavigation = New PageNavigation($totalResults, $resultsPerPage, $page, $startHTML, $appendSearch, $range, $link_on, $link_off, $back, $forward);

        echo $myNavigation->getHTML();

?>

<a href="./equipment/print_equipmentDetails.php" target="_blank" >Print</a>
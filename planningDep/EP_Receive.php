<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
<?
// print_r($_POST);
$temppo1=explode("_",$posl);
$vid=$temppo1[3];
if($epreceive){
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

$edate=formatDate($edate,"Y-m-d");

$totalReceiveAmount=0;
for($i=1;$i<$n;$i++){
//echo "eqPOtype=$eqPOtype<br>";
if($eqPOtype=='1'){
		$assetId=${assetId.$i};
	if(!$assetId){echo "<h1>Asset id not found.</h1>";exit;}
		 $pCode=$temppo1[1];
		 if($temppo1[3]=='85')
		// print "25";
		  $sqlp = "UPDATE `eqproject` set dispatchDate='$edate',status=3".
		 " WHERE assetId='$assetId' AND pCode='$pCode' AND itemCode='${itemCode.$i}'";
		//echo $sqlp.'<br>';
		//mysqli_query($db, $sqlp);
		
		//$assetId="V_$temppo1[3]_".${assetId.$i};

		$sdate = formatDate(${sdate.$i},"Y-m-d");
		//print "34";
    	  $sql="INSERT INTO `eqproject` ( `id` , `itemCode` , `assetId` , `pCode` , `sdate` ,
		 `edate` , `receiveDate` , `posl` , `reff`,status,dispatch,dispatchDate )".
			" VALUES ('', '${itemCode.$i}', '$assetId', '$pCode', '$edate', '', 
			'$edate', '$posl', '$eqtsl','1','','')";
  	    //$query= mysqli_query($db, $sql);			
		//echo $sql.'<br>';
	  $remainQty = eqremainQty($posl,${itemCode.$i},$temppo1[1]);
		if($remainQty<=0)
			{
			//print "43";
			  $sqlitem1 = "UPDATE `porder` SET status='2' WHERE posl='$posl' AND itemCode='${itemCode.$i}'";
			//echo $sqlitem1.'<br>';
			$query= mysqli_query($db, $sqlitem1);
			}
}
else {
   if(${ch.$i}){
   
   	if($temppo1[3]!='85')
		{ $pCode=$temppo1[1];
		//$assetId="V_$temppo1[3]_".${assetId.$i};
		$assetId=${assetId.$i};
		$sdate = formatDate(${sdate.$i},"Y-m-d");
	if(!$assetId){echo "<h1>Asset id not found.</h1>";exit;}
		//print "58";
    	 $sql="INSERT INTO `eqproject` ( `id` , `itemCode` , `assetId` , `pCode` , `sdate` , 
		`edate` , `receiveDate` , `posl` , `reff`,status,dispatch,dispatchDate )".
			" VALUES ('', '${itemCode.$i}', '$assetId', '$pCode', '$edate', '', 
			'$sdate', '$posl', '$eqtsl','1','','')";
  	    $query= mysqli_query($db, $sql);			
		//echo $sql.'<br>';
	  $remainQty = eqremainQty($posl,${itemCode.$i},$temppo1[1]);
		if($remainQty<=0)
			{
			//print "68";
			 $sqlitem1 = "UPDATE `porder` SET status='2' WHERE posl='$posl' AND itemCode='${itemCode.$i}'";
			//echo $sqlitem1.'<br>';
			$query= mysqli_query($db, $sqlitem1);
			}
	}

	if($temppo1[3]=='85'){
	//print "76";
	 $sqlitem = "UPDATE `eqproject` SET sdate='$edate',status='1' WHERE id='${ch.$i}'";	
	//echo $sqlitem.'<br>';
	$query= mysqli_query($db, $sqlitem);	
    $remainQty = eqremainQty($posl,${itemCode.$i},$temppo1[1]);
		if($remainQty<=0)
			{
			//print "83";
			 $sqlitem1 = "UPDATE `porder` SET status='2' WHERE posl='$posl' AND itemCode='${itemCode.$i}'";
			//echo $sqlitem1.'<br>';
			$query= mysqli_query($db, $sqlitem1);
			}

	}

    }//if
	}//else eqPOtype
  } //for
  
  /*	$sqlpo = "UPDATE popayments SET receiveAmount='$totalReceiveAmount' WHERE posl='$sposl'";
	//echo $sqlpo;
	$sqlQuerypo = mysqli_query($db, $sqlpo);*/
//$todat=todat();
//eq_autoAttendance($todat,$edate);
}//if
?>

<?
if(isset($_POST['storeReceive']) || $epreceive00){
$edate = formatDate($edate,"Y-m-d");
	if(strtotime($edate)<strtotime('2015-01-01')){
		echo "<h1>Invalid date.</h1>";
		exit;
	}
	
	$pdf_files_arr=$_FILES["pdf_file"];
$loc="/store_pdf";
	foreach($pdf_files_arr["type"] as $fType)
		if($fType!="application/pdf"){
			echo "<h1>Please upload pdf file</h1>";
			exit;
		}
	
	foreach($pdf_files_arr["tmp_name"] as $pdf_file_single){
		$fName=$posl."_".todat()."_".rand(rand(10,99),999);
		$uploadFile=pdfUpload_function("pdf",$pdf_file_single,$loc,$fName);		
		if($uploadFile)$uploadFileArr[]=$uploadFile;
	}
	if(count($uploadFileArr)<1){
		echo "<h1>File not found! Please retry</h1>";
		exit;
	}
	$pdf_files_json=json_encode($uploadFileArr);
}
//check if store receive or ep receive



if(isset($_POST['storeReceive'])){
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$poType=poType($posl);
//print $loginDesignation;
//print $poType;
if($poType=='6' && $loginDesignation=="Store Manager")
{

for($i=1; $i<$n;$i++)
	{
$rem=${remainQty.$i}-${number.$i};
$sql2="INSERT INTO store (rsid,itemCode,receiveQty,currentQty,rate,receiveFrom,reference,remark,sdate) ".
		" values ('','${exitemCode.$i}','${number.$i}','$rem','${rate.$i}','','','','$edate')";
		//echo "$sql2<br>";
		mysqli_query($db, $sql2);
			if($rem<=0)
			{
			 $sqlitem1 = "UPDATE `porder` SET status='2' WHERE posl='$posl' AND itemCode='${exitemCode.$i}'";
			//echo $sqlitem1.'<br>';
			$query= mysqli_query($db, $sqlitem1);
			}

	}
}
//exit;
else if($poType=='4'){
	
//$challanNo=get_MRsl($loginProject);

for($i=1; $i<$n;$i++){
    $sql="SELECT quotation.*,eqquotation.* FROM quotation,eqquotation
 where quotation.itemCode='${exitemCode.$i}' AND quotation.qid=eqquotation.qid AND quotation.vid=$vid";
//echo "$sql<br>";
	$sqlq=mysqli_query($db, $sql);
	$r=mysqli_fetch_array($sqlq);

	$price=$r[rate];
	$life=$r[life];
	$salvageValue=$r[salvageValue];	
	$currentLocation='004';
	$condition=$r[condition];
	$teqSpec=$r[teqSpec];	
	$reference=$posl;				
	
	for($j=1; $j<=${totalQty.$i};$j++){
	$sql = mysqli_query($db, "SELECT assetId FROM equipment WHERE itemCode LIKE '${exitemCode.$i}'");
	//echo "$sql<br>";
	$rid=mysqli_num_rows($sql)+1;
	$assetId="$rid";
	if(!$assetId){echo "<h1>Asset id not found.</h1>";exit;}
	//print "134";
	   $sqlitem = "INSERT INTO `equipment` ( `eqid` , `assetId`, `itemCode`, `mnfPro` , `teqSpec` ,`exp` , `price` , `life` ,
	`salvageValue` , `days`, `hours`,`reference` , `location` ,`condition`, `edate` ) 
	VALUES ( '' ,  '$assetId' , '${exitemCode.$i}' ,'$mnfPro' , '$teqSpec' , '$exp' , '$price' , '$life' , 
	'$salvageValue' ,'$days','$hours' ,'$reference' , '$currentLocation' ,'$condition' , '$edate' )";
	//echo "<br>$sqlitem<br>";
	mysqli_query($db, $sqlitem);
	}//for
	if(eqp_remainQty($posl,${exitemCode.$i})==0) {
	//print "143";
	   $sqlitem1 = "UPDATE `porder` SET status='2' WHERE posl='$posl' AND itemCode='${exitemCode.$i}'";
	//echo $sqlitem1.'<br>';
	mysqli_query($db, $sqlitem1);
	
	}//if
	
  }//for
}
else{
// if(chkReceiveSl($challanNo,$loginProject))
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);	

$challanNo=get_MRsl($loginProject);

for($i=1; $i<$n;$i++){
$exAmount=${totalQty.$i}* ${rate.$i};
if(${totalQty.$i}>0){

if(!strtotime($edate))
$edate=formatDate($edate,"Y-m-d");

$edateTime=strtotime($edate);
$getCurrentSchedule=getPoSchedule($sposl,${exitemCode.$i});
foreach($getCurrentSchedule as $cSchedule){
	$startDate=strtotime($cSchedule[sdate]);
	$endDate=strtotime($cSchedule[edate]);
	if($startDate<=$edateTime && $edateTime<=$endDate && $passed!=1)$passed=1;
}
	if(!$passed){
		echo "<h1>Please receive again, your receiving date is not in between receiving schedule.</h1>";
		exit;
	}

	//$itemType=itemType(${exitemCode.$i});
	//echo $itemType;
	//if($itemType=='Stock Item'){	}//if
	
	//print "172";
	 $sqlitem = "INSERT INTO `store$loginProject` (rsid,itemCode, receiveQtyTemp,rate, paymentSL, reference, remark, todat, pdf_files) ".
	 "VALUES ('','${exitemCode.$i}', '${totalQty.$i}', '${rate.$i}', '$sposl', '$challanNo', '$remark', '$edate','$pdf_files_json')";
// 	echo $sqlitem.'<br>';
	$query= mysqli_query($db, $sqlitem);
	  
	$totalCost+=round(${totalQty.$i}* ${rate.$i});
    }//if
  } //for
    $temppo=explode("_",$posl);
    $pay=poReeiveAmount($posl);
	$amountDue=$pay+$totalCost;
	//print "184";
  	 $sqlpo="UPDATE popayments SET receiveAmount='$amountDue' WHERE posl='$posl'";
	//echo $sqlpo;
	$sqlQuerypo = mysqli_query($db, $sqlpo);
	
      $sqlpo="SELECT * from porder where posl LIKE '$posl'";
	  $sqlqpo=mysqli_query($db, $sqlpo);
	  while($rr=mysqli_fetch_array($sqlqpo)){
     if(remainQty($posl,$rr[itemCode],$loginProject)!=0){
				$ok=0; break;
			}
	  else $ok=1;
	  //echo "<br>ok:$ok<br>";
	  }
      if($ok){
	 //print "199";
    $sqlitem1 = "UPDATE `porder` SET status='2' WHERE posl='$posl' ";
	    //echo $sqlitem1.'<br>';
	   $query= mysqli_query($db, $sqlitem1);
    }
	}//else potype

}//if
?>
<?
if($epreceive00){
$challanNo=get_MRsl($loginProject);
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

if(!strtotime($edate))
$edate=formatDate($edate,"Y-m-d");
	
for($i=1;$i<$n;$i++){
if(${totalQty.$i}>0){
	$sql1="SELECT * from storet$loginProject WHERE itemCode='${exitemCode.$i}' AND currentQty <> 0 AND paymentSL='$posl' ORDER by  rsid ASC";
		//echo $sql1;
		$sqlq1=mysqli_query($db, $sql1);
		while($ras=mysqli_fetch_array($sqlq1)){
			
			if((strtotime($edate)-strtotime($ras[todat]))<0 && 1==2){
				echo "<h1>Entry date incorrect!</h1>";
				exit;
			}
			
			if($ras[currentQty]==${totalQty.$i}){
					$sqlup="UPDATE storet$loginProject set currentQty=0 WHERE rsid=$ras[rsid] ";
					//echo '<br> ss1='.$sqlup.'<br>';
					$qq = mysqli_query($db, $sqlup);
					//print "225";
					 $sqlitem = "INSERT INTO `store$loginProject` (rsid,itemCode, receiveQtyTemp, rate, paymentSL, reference, remark,todat,pdf_files)".
					" VALUES ('','${exitemCode.$i}', '${totalQty.$i}', '$ras[rate]', '$sposl', '$challanNo', '$remark', '$edate','$pdf_files_json')";
// 					echo $sqlitem.'<br>';
					$query= mysqli_query($db, $sqlitem);
			break;
			}
			else if($ras[currentQty]>${totalQty.$i}){
					//print "233";
					$sqlup="UPDATE storet$loginProject set currentQty=currentQty-".${totalQty.$i}." WHERE rsid=$ras[rsid] ";
					//echo '<br>ss2='.$sqlup.'<br>';
					$qq = mysqli_query($db, $sqlup);
					//print "237";
					 $sqlitem = "INSERT INTO `store$loginProject` (rsid,itemCode, receiveQtyTemp, rate, paymentSL, reference, remark,todat,pdf_files)".
					"VALUES ('','${exitemCode.$i}', '${totalQty.$i}', '$ras[rate]', '$sposl', '$challanNo', '$remark', '$edate','$pdf_files_json')";
// 					echo $sqlitem.'<br>';
					$query= mysqli_query($db, $sqlitem);
			break;
			}
			else if($ras[currentQty]<${totalQty.$i}){
			//print "245";
					  $sqlup="UPDATE storet$loginProject set currentQty=0 WHERE rsid=$ras[rsid] ";
					//echo '<br>ss3='.$sqlup.'<br>';
					$qq = mysqli_query($db, $sqlup);
					//print "249";
					 $sqlitem = "INSERT INTO `store$loginProject` (rsid,itemCode, receiveQty, rate, paymentSL, reference, remark,todat,pdf_files)".
					"VALUES ('','${exitemCode.$i}', '$ras[currentQty]', '$ras[rate]', '$sposl', '$challanNo', '$remark', '$edate','$pdf_files_json')";
					//echo $sqlitem.'<br>';
					$query= mysqli_query($db, $sqlitem);
					
					${totalQty.$i}=${totalQty.$i}-$ras[currentQty];
			}			

		}//while
	}//totalQty
  }//for
} 
?>

<table width="90%" border="0" align="center">
<tr><td align="center"><h2>BFEW LTD</h2></td></tr>
<tr><td align="center"><U>RECEIVING FORM</U></td></tr>
<tr><td align="center"><U><? echo $loginProjectName;?></U></td></tr>
<tr><td align="right"><? echo date("l F d, Y h:i:s A");?></td></tr>
</table>

<br>

<? include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
//echo get_MRsl($loginProject);	
?>
<form name="srf" action="./index.php?keyword=ep+receive" method="post" enctype="multipart/form-data">
<table align="center" width="50%" border="3" bordercolor="#99CC99" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr><td  align="center" bgcolor="#99CC99" height="30"><font class="englishHeadBlack">Store Receive Form</font></td></tr>
<tr>
<td>PO Ref.: 
        <select name="sposl" onChange="location.href='index.php?keyword=ep+receive&posl='+srf.sposl.options[document.srf.sposl.selectedIndex].value">
          <option value="">Select one</option>
          <?
$i=1;
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

if($loginDesignation=="Site Equipment Co-ordinator")
$sqlp = "SELECT distinct posl from `porder` WHERE posl LIKE  'EQ_".$loginProject."_%' AND status=1";
if($loginDesignation=="Store Manager")
$sqlp = "SELECT distinct posl from `porder` WHERE potype='6' and location='004'  AND vid<>'99' AND status=1 and posl not LIKE 'EQP_%'";
if($loginDesignation=="Store Officer")
$sqlp = "SELECT distinct posl, sum(qty)  as qty from `porder` WHERE potype in ('1','4')  AND location='$loginProject' AND vid<>'99' AND  status=1 and posl not LIKE 'EQP_%' group by posl";

$sqlrunp= mysqli_query($db, $sqlp);

// echo $sqlp;

while($typel= mysqli_fetch_array($sqlrunp)){
 echo "<option value='".$typel[posl]."' ";
 if($posl==$typel[posl]) echo " SELECTED ";
 echo check_posl_approved($typel[posl])==false ? " disabled ".">(Pending) " : ">";
 echo viewPosl($typel[posl])."</option> ";
}
?>
<? 
if($loginDesignation=="Store Officer" || $loginDesignation=='Project Purchase Officer'){
$sqlp22 = "SELECT distinct paymentSL, sum(currentQty)  as qty from `storet$loginProject` GROUP by paymentSL HAVING qty >0  ";
if($loginDesignation=="Project Purchase Officer")$sqlp22 .=" and paymentSL like 'EP_%'";
//        "( select SUM(curretnQty) as qt from `storet$loginProject` group by paymentSL ) <> 0";
// echo $sqlp22;
$sqlrunp= mysqli_query($db, $sqlp22);

 while($typel= mysqli_fetch_array($sqlrunp)){
	 $temppo=explode("_",$typel[paymentSL]);
	 echo "<option value='".$typel[paymentSL]."'";

	 if($posl==$typel[paymentSL]) echo " SELECTED";

	 if($temppo[3]==117) 
		 echo ">".viewPosl($typel[paymentSL])."</option>  ";

	else if($temppo[1]==99)
		echo ">".$typel[paymentSL]."</option>";

	 else   
	 echo ">". $typel[paymentSL]."</option>  ";
	}
}
?>
        </select>
        <? 
		
//echo $sqlp;
//echo $loginDesignation;
if($posl){
	$temppo=explode("_",$posl);
	if($temppo[0]=='EP') echo "Emergency Purchase";
else {
	$temp=vendorName($temppo[3]);
	echo $temp[vname];
}
}?>
	 <a target="_blank" href="./planningDep/printpurchaseOrder1.php?posl=<?php echo $posl; ?>">View PO</a>
      </td>
</tr>
</table>
<br><br>
<? if(($temppo[0]=='PO' OR $temppo[0]=='EQP') AND $temppo[3]!='99' AND $temppo[3]!='117' ){?>

<table align="center" width="98%" border="3" bordercolor="#99CC99" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#99CC99">
	<SCRIPT LANGUAGE="JavaScript">
	var now = new Date(); 
	var cal = new CalendarPopup("testdiv1");
    	//cal.showNavigationDropdowns();
		cal.setWeekStartDay(6); // week is Monday - Sunday
		//cal.addDisabledDates(null,formatDate(now,"yyyy-MM-dd")); 
		cal.setCssPrefix("TEST");		
		cal.offsetX = 0;
		cal.offsetY = 0;		
	</SCRIPT>

 <td colspan="7" >Receiving Date:
   <input class="yel" type="text" maxlength="10" name="edate" alt="req" title="Receiving Date" readonly="" > <a id="anchor" href="#"
   onClick="cal.select(document.forms['srf'].edate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
      </td> 
	  <td colspan="2"><? echo mydate(poDate($posl));?></td>
</tr>

 <tr>
    <td align="center" width="100" ><b>Item</b></td>
    <td align="center" ><b>Description</b></td>
    <td align="center" ><b>Receivable Qty.</b></td>	
    <td align="center" ><b>Number</b></td>
    <td align="center" >Length (m)</td>
    <td align="center" >Height (m)</td>
    <td align="center" >Width (m)</td>
    <td align="center" ><b>Volumn (m3)</b></td>
    <td align="center" ><b>Total Qty</b></td>
 </tr>

<?
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

/*if($temppo[3]=='99')
$sqlp12 = "SELECT sporder.* from `sporder` WHERE sposl='$posl' AND status=1 ";
else 
$sqlp12 = "SELECT porder.* from `porder` WHERE posl='$posl' AND status=1 ";
*/
$sqlp12 = "SELECT porder.* from `porder` WHERE posl='$posl' AND status=1";
//echo $sqlp12;
$sqlrunp12=mysqli_query($db, $sqlp12);
$i=1;
 while($typel12= mysqli_fetch_array($sqlrunp12))
{
$temp=itemDes($typel12[itemCode]);
?>
<?
$poType=poType($posl); 
if((remainQty($posl,$typel12[itemCode],$loginProject)>0 && $poType!=6) || (remainQty6($posl,$typel12[itemCode],$loginProject)>0 && $poType==6)){?>
 <tr>
    <td width="260">
			<? echo $typel12[itemCode];?>
			<?php $getCurrentSchedule=getPoSchedule($posl,$typel12["itemCode"]);
			foreach($getCurrentSchedule as $cSchedule){
				$startDate=date("d-m-Y",strtotime($cSchedule[sdate]));
				$endDate=date("d-m-Y",strtotime($cSchedule[edate]));
				echo "<p style=\"margin: 0;font-size:9px;font-style: italic;\" class='dateRange'>You can receive in between <b>".$startDate."</b> to <b>".$endDate."</b></p>";
			}
			?>
	  <input  type="hidden" name="exitemCode<? echo $i;?>" value="<? echo $typel12[itemCode];?>">
		<input  type="hidden" name="rate<? echo $i;?>" value="<? echo $typel12[rate];?>">	
	</td>
    <td> <? echo $temp[des].','.$temp[spc]; ?> </td>
    <td align="right"> <input type="hidden" name="remainQty<? echo $i;?>" value="<? if($poType==6) echo remainQty6($posl,$typel12[itemCode],$loginProject); else echo remainQty($posl,$typel12[itemCode],$loginProject);?>" size="12">
	<? 
	if($temppo[0]=='EQP') eqp_remainQty($posl,$typel12[itemCode]);
	if($temppo[3]=='85') echo cstoreRemainQty($posl,$typel12[itemCode],$loginProject);
	else 
		{
		if($poType==6) echo remainQty6($posl,$typel12[itemCode],$loginProject); else echo remainQty($posl,$typel12[itemCode],$loginProject);
		}

	
	?>
	<font class="out"> <? echo $temp[unit];?></font>
	</td>
    <td align="right"> <input type="text"  size="5" width="5" name="number<? echo $i;?>" value=""  onBlur="multipleMe(srf,<? echo 'number'.$i;?>,<? echo 'length'.$i;?>,<? echo 'height'.$i;?>,<? echo 'width'.$i;?>,<? echo 'volumn'.$i;?>,<? echo 'totalQty'.$i;?>,<? echo 'remainQty'.$i;?>); "></td>
    <td align="right"> <input type="text" name="length<? echo $i;?>" style="text-align:right" value="" onBlur="multipleMe(srf,<? echo 'number'.$i;?>,<? echo 'length'.$i;?>,<? echo 'height'.$i;?>,<? echo 'width'.$i;?>,<? echo 'volumn'.$i;?>,<? echo 'totalQty'.$i;?>,<? echo 'remainQty'.$i;?>); "size="5" width="5"></td>
    <td align="right"> <input type="text" name="height<? echo $i;?>" style="text-align:right" value="" onBlur="multipleMe(srf,<? echo 'number'.$i;?>,<? echo 'length'.$i;?>,<? echo 'height'.$i;?>,<? echo 'width'.$i;?>,<? echo 'volumn'.$i;?>,<? echo 'totalQty'.$i;?>,<? echo 'remainQty'.$i;?>); "size="5" width="5"></td>
    <td align="right"> <input type="text" name="width<? echo $i;?>" style="text-align:right" value="" onBlur="multipleMe(srf,<? echo 'number'.$i;?>,<? echo 'length'.$i;?>,<? echo 'height'.$i;?>,<? echo 'width'.$i;?>,<? echo 'volumn'.$i;?>,<? echo 'totalQty'.$i;?>,<? echo 'remainQty'.$i;?>); "size="5" width="5"></td>
    <td align="right"> <input type="text" name="volumn<? echo $i;?>" style="text-align:right" value="" size="5" readonly="" width="5" ></td>
    <td align="right"> <input type="text" name="totalQty<? echo $i;?>" value="" size="5" style="text-align:right"  readonly="" onBlur="" width="5" ></td>
</tr>
<? $i++;}?>
<? }//remainQTY?>
<tr>
	<td colspan="2">Chalan Files: <input type="file" name="pdf_file[]" multiple></td>
	<td colspan="4">Transportation Details:
<textarea cols="60" rows="2"></textarea></td>
</tr>
<tr><td colspan="9" align="center">

<input type="button" value="Receive by" name="btnstoreReceive" onClick="if(checkrequired(srf)) {srf.storeReceive.value=1;srf.submit();}">

<input type="hidden" name="posl" value="<? echo $posl;?>">
<input type="hidden" name="n" value="<? echo $i;?>">
<input type="hidden" name="storeReceive" value="0">
</td></tr>
</table>
<br><br>
<? 
}
else if($temppo[0]=='cash' OR $temppo[0]=='EP' OR $temppo[0]=='ST' OR $temppo[3]=='99' OR $temppo[3]=='117'  ){?>

<table align="center" width="98%" border="3" bordercolor="#99CC99" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#99CC99">
	<SCRIPT LANGUAGE="JavaScript">
	var now = new Date(); 
	var cal = new CalendarPopup("testdiv1");
    	cal.showNavigationDropdowns();
		cal.setWeekStartDay(6); // week is Monday - Sunday
		//cal.addDisabledDates(null,formatDate(now,"yyyy-MM-dd")); 
		cal.setCssPrefix("TEST");		
		cal.offsetX = 0;
		cal.offsetY = 0;		
	</SCRIPT>
 <td colspan="6">Receiving Date:
 <input class="yel" type="text" maxlength="10" name="edate" alt="req" title="Receiving Date" readonly="" > <a id="anchor" href="#"
   onClick="cal.select(document.forms['srf'].edate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
      </td> 
  <td colspan="6" align="right"><? echo myDate(ep_purchaseDate($posl,$loginProject));?></td>	  
</tr>

 <tr >
    <td align="center" width="100" ><b>Item</b></td>
    <td align="center" ><b>Description</b></td>
    <td align="center" ><b>Receivable Qty.</b></td>	
    <td align="center" ><b>Number</b></td>
    <td align="center" >Length (m)</td>
    <td align="center" >Height (m)</td>
    <td align="center" >Width (m)</td>
    <td align="center" ><b>Volumn (m3)</b></td>
    <td align="center" ><b>Total Qty</b></td>
 </tr>

<?
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$sqlp12 = "SELECT rsid,itemCode,sum(currentQty) as remainQty,rate from `storet$loginProject` WHERE paymentSL='$posl' GROUP by rsid ";
// echo $sqlp12;
$sqlrunp12= mysqli_query($db, $sqlp12);
$i=1;
 while($typel12= mysqli_fetch_array($sqlrunp12))
{
if($typel12[remainQty]>0){
$temp=itemDes($typel12[itemCode]);

 ?>

 <tr>
    <td width="100"><? echo $typel12[itemCode];?> 
	<input  type="hidden" name="exitemCode<? echo $i;?>" value="<? echo $typel12[itemCode];?>">
	<input  type="hidden" name="rate<? echo $i;?>" value="<? echo $typel12[rate];?>">
	<input type="hidden" name="rsid<? echo $i;?>"	 value="<? echo $typel12[rsid];?>">
	</td>
    <td> <? echo $temp[des].','.$temp[spc]; ?> </td>
    <td align="right"> <input type="hidden" name="remainQty<? echo $i;?>" value="<? echo $typel12[remainQty];?>" size="12">
	<? echo number_format($typel12[remainQty],3);?>
	<font class="out"> <? echo $temp[unit];?></font>
	</td>
    <td align="right"> <input type="text" name="number<? echo $i;?>" value=""  onBlur="multipleMe(srf,<? echo 'number'.$i;?>,<? echo 'length'.$i;?>,<? echo 'height'.$i;?>,<? echo 'width'.$i;?>,<? echo 'volumn'.$i;?>,<? echo 'totalQty'.$i;?>,<? echo 'remainQty'.$i;?>); "size="10" width="10"></td>
    <td align="right"> <input type="text" name="length<? echo $i;?>" style="text-align:right" value="" onBlur="multipleMe(srf,<? echo 'number'.$i;?>,<? echo 'length'.$i;?>,<? echo 'height'.$i;?>,<? echo 'width'.$i;?>,<? echo 'volumn'.$i;?>,<? echo 'totalQty'.$i;?>,<? echo 'remainQty'.$i;?>); " size="10" width="10"></td>
    <td align="right"> <input type="text" name="height<? echo $i;?>" style="text-align:right" value="" onBlur="multipleMe(srf,<? echo 'number'.$i;?>,<? echo 'length'.$i;?>,<? echo 'height'.$i;?>,<? echo 'width'.$i;?>,<? echo 'volumn'.$i;?>,<? echo 'totalQty'.$i;?>,<? echo 'remainQty'.$i;?>); " size="10" width="10"></td>
    <td align="right"> <input type="text" name="width<? echo $i;?>" style="text-align:right" value="" onBlur="multipleMe(srf,<? echo 'number'.$i;?>,<? echo 'length'.$i;?>,<? echo 'height'.$i;?>,<? echo 'width'.$i;?>,<? echo 'volumn'.$i;?>,<? echo 'totalQty'.$i;?>,<? echo 'remainQty'.$i;?>); " size="10" width="10"></td>
    <td align="right"> <input type="text" name="volumn<? echo $i;?>" style="text-align:right" value="" size="10" width="10" readonly="" ></td>
    <td align="right"> <input type="text" name="totalQty<? echo $i;?>" value="" size="10" width="10" style="text-align:right"  readonly="" onBlur="" ></td>
</tr>
<?
 $i++;}
 }//qty?>
<tr>
	<td colspan="2">
		Chalan Files:<input type="file" name="pdf_file[]" multiple>
	</td>
	<td colspan="4">Transportation Details:
		<textarea cols="60" rows="2"></textarea>
	</td>
</tr>
<tr>
	<td colspan="9" align="center">
		<input type="button" value="Receive by" name="btnstoreReceive" onClick="if(checkrequired(srf)) {srf.epreceive00.value=1;srf.submit();}">
		<input type="hidden" name="posl" value="<? echo $posl;?>">
		<input type="hidden" name="n" value="<? echo $i;?>">
		<input type="hidden" name="epreceive00" value="0">
	</td>
</tr>
</table>


<? 
}// if potype==1
if($temppo[0]=='EQ' AND $temppo[3]=='85'){?>

<table align="center" width="98%" border="1" bordercolor="#99CC99" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
<tr>
	<SCRIPT LANGUAGE="JavaScript">
	var now = new Date(); 
	var cal = new CalendarPopup("testdiv1");
    	//cal.showNavigationDropdowns();
		cal.setWeekStartDay(6); // week is Monday - Sunday
		//cal.addDisabledDates(null,formatDate(now,"yyyy-MM-dd")); 
		cal.setCssPrefix("TEST");		
		cal.offsetX = -250;
		cal.offsetY = 0;
		
	</SCRIPT>
      <td colspan="2" ></td>

 <td colspan="2" align="right" >Receiving Date: 
 <input class="yel" type="text" maxlength="10" name="edate" alt="req" title="Receiving Date" readonly="" > <a id="anchor" href="#"
   onClick="cal.select(document.forms['srf'].edate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0">   
      </td> 

</tr>
<tr>
    <th align="center" width="100" >Item</th>
    <th align="center" >Description</th>
    <th align="center" >Dispatch From Source</th>	
	<th>Equipment ID</th>
</tr>
<? include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
if($temppo[3]=='85'	)
$sqlp12 = "SELECT * from `eqproject` WHERE posl LIKE '$posl' AND reff LIKE 'EQT_$loginProject%' and status=0";
//echo $sqlp12;
$sqlrunp12= mysqli_query($db, $sqlp12);
$i=1;
 while($typel12= mysqli_fetch_array($sqlrunp12))
{ 
$temp=itemDes($typel12[itemCode]);
 ?>

 <tr>
    <td width="100">
	<input type="checkbox" name="ch<? echo $i;?>"  value="<? echo $typel12[id];?>">	<? echo $typel12[itemCode];?>
	<input  type="hidden" name="itemCode<? echo $i;?>" value="<? echo $typel12[itemCode];?>">
	<input  type="hidden" name="rate<? echo $i;?>" value="<? echo $typel12[rate];?>">	
	<input  type="hidden" name="totalQty<? echo $i;?>" value="<? echo $typel12[receiveQty];?>">	
	</td>
    <td> <? echo $temp[des].', '.$temp[spc]; ?> </td>
	<td align="center">	 <? echo myDate($typel12[receiveDate]);?></td>
	<td align="center">	 <? echo eqpId($typel12[assetId],$typel12[itemCode]);?>
		 <input type="hidden" name="assetId<? echo $i;?>" value="<? echo $typel12[assetId];?>" >
	</td>
</tr>
<? $i++;}?>

<? $sqlp12 = "SELECT * from `porder` WHERE posl = '$posl'  and status='1'";
//echo $sqlp12;
$sqlrunp12= mysqli_query($db, $sqlp12);

 while($typel12= mysqli_fetch_array($sqlrunp12))
{ $temp=itemDes($typel12[itemCode]);

 $sq="SELECT * from eqproject where pcode='$loginProject' AND itemCode='$typel12[itemCode]' and status=2";
 //echo "<br>$sq<br>";
 $sqlqq=mysqli_query($db, $sq);
 while($re=mysqli_fetch_array($sqlqq)){
?>
 <tr bgcolor="#CCCCCC">
    <td width="100">
	<input type="checkbox" name="ch<? echo $i;?>"  value="<? echo $typel12[poid];?>">
		<? echo $typel12[itemCode];?>
	<input type="hidden" name="assetId<? echo $i;?>" value="<? echo $re[assetId];?>"  >
    <input  type="hidden" name="itemCode<? echo $i;?>" value="<? echo $typel12[itemCode];?>">		
	</td>
    <td> <? echo $temp[des].', '.$temp[spc]; ?> </td>
	<td align="center">	</td>
	<td align="center">	 
	<? if($re[assetId]{0}=='A')  { echo eqpId_local($re[assetId],$re[itemCode]); $type='L';}
		else {echo eqpId($re[assetId],$re[itemCode]); $type='H'; }
		
	 ?> 
	 <input type="hidden" name="assetId<? echo $i;?>" value="<? echo $re[assetId];?>" >		
</td>
</tr>
  <? $i++;}?>
<!--<input type="hidden" name="eqPOtype" value="1">-->
<? }?>
<tr>
	<td colspan="6">Transportation Details:
<textarea cols="60" rows="2"></textarea></td>
</tr>

<tr >
<input type="hidden" name="n" value="<? echo $i;?>">
	
	<td colspan="2">
<!-- 		Chalan Files:<input type="file" name="pdf_file[]" multiple> -->
	</td>
      <td align="center" colspan="2"> <input type="button" value="Received by <? echo $loginFullName;?>" name="epreceive1" onClick="if(checkrequired(srf)) {srf.submit(); srf.epreceive.value=1;}"> 
				
        <input type='hidden' name="epreceive" value="1">
<input type="hidden" name="posl" value="<? echo $posl;?>">
<input type="hidden" name="n" value="<? echo $i;?>">

</td></tr>
</table>

<?
 }// if posl

?>
<?
if($temppo[0]=='EQ' AND $temppo[3]!='85'){?>

<table align="center" width="98%" border="1" bordercolor="#99CC99" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
<tr>
	<SCRIPT LANGUAGE="JavaScript">
	var now = new Date(); 
	var cal = new CalendarPopup("testdiv1");
    	//cal.showNavigationDropdowns();
		cal.setWeekStartDay(6); // week is Monday - Sunday
		//cal.addDisabledDates(null,formatDate(now,"yyyy-MM-dd")); 
		cal.setCssPrefix("TEST");		
		cal.offsetX = -250;
		cal.offsetY = 0;
		
	</SCRIPT>
      <td colspan="2" ></td>

 <td colspan="2" align="right">Receiving Date: 
 <input class="yel" type="text" maxlength="10" name="edate" readonly="" > <a id="anchor" href="#"
   onClick="cal.select(document.forms['srf'].edate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
      </td> 

</tr>
<tr>
    <th align="center" width="100" >Item</th>
	<th>Equipment ID</th>
    <th align="center" >Description</th>
<!--     <th align="center" >Dispatch From Source</th>	 -->
</tr>
<? include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp12 = "SELECT * from `porder` WHERE posl = '$posl'  and status=1";
//echo $sqlp12;
$sqlrunp12= mysqli_query($db, $sqlp12);
$i=1;
 while($typel12= mysqli_fetch_array($sqlrunp12))
{
$temp=itemDes($typel12[itemCode]);
$remainQty = eqremainQty($posl,$typel12[itemCode],$temppo[1]);
//echo $remainQty;
 //for($i=1;$i<=$remainQty;$i++){
 ?>

 <tr>
      <td width="100"> <input type="checkbox" name="ch<? echo $i;?>"  value="<? echo $typel12[poid];?>">
        <? echo $typel12[itemCode];?> 
        <input  type="hidden" name="itemCode<? echo $i;?>" value="<? echo $typel12[itemCode];?>">
	<input  type="hidden" name="rate<? echo $i;?>" value="<? echo $typel12[rate];?>">	
	<input  type="hidden" name="totalQty<? echo $i;?>" value="<? echo $typel12[receiveQty];?>">	
	</td>
	 <?php
	$newAssetID=newAssetID($typel12[itemCode],"R",$loginProject);
	?>
	<td align="center">	<input type="text" name="assetId<? echo $i;?>" size="4" width="4" maxlength="4" readonly value="<?php echo $newAssetID; ?>" align="right" ></td>
	 
    <td> <? echo $temp[des].', '.$temp[spc]; ?> </td>
<!-- 	  <td align="right">
		<input class="yel" type="text" maxlength="10" name="sdate<? echo $i;?>" alt="req" title="Dispatch From Source Date" readonly="" > <a id="anchor<? echo $i;?>" href="#"
		onClick="cal.select(document.forms['srf'].sdate<? echo $i;?>,'anchor<? echo $i;?>','dd/MM/yyyy'); return false;"
		name="anchor<? echo $i;?>" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 	  
	  </td> -->
</tr>
<? //}//for
$i++;}?>
<tr>	
	<td colspan="2">
<!-- 		Chalan Files:<input type="file" name="pdf_file[]" multiple> -->
	</td>
	  <td colspan="4">Transportation Details: 
        <textarea name="textarea" cols="60" rows="2"></textarea>
	  </td>
</tr>

<tr >
<input type="hidden" name="n" value="<? echo $i;?>">
      <td align="center" colspan="4"><input type="button" value="Received by <? echo $loginFullName;?>" name="epreceive1" onClick="if(checkrequired(srf)) {srf.epreceive.value=1;srf.submit(); }"> 
        <input type='hidden' name="epreceive" value="1">
<input type="hidden" name="posl" value="<? echo $posl;?>">

<input type="hidden" name="n" value="<? echo $i;?>">

</td></tr>
</table>

<?
 }// if posl

?>

</form>
<?php if($posl){

	$rSql="select * from store$loginProject where paymentSL='$posl' and receiveQtyTemp>0";
	$rQ=mysqli_query($db,$rSql);
if(mysqli_affected_rows($db)>0){
?>
<div>
	<?php echo btnPDFstyle(); ?>
		<table align="center" width="98%" border="3" bordercolor="#99CC99" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
<tbody>
	<tr bgcolor="#99CC99">
		<td colspan=5 align=center><b>Waiting For Acceptance</b></td>
	</tr>
	<tr bgcolor="#99CC99">
		<td>Receiving Date</td>
		<td>ItemCode</td>
		<td>Reference</td>
		<td>Quantity</td>
		<td>Attachment Files</td>
	</tr>
	<?php
	while($rRow=mysqli_fetch_array($rQ)){
	echo '<tr>
					<td>'.date("d/m/Y",strtotime($rRow[todat])).'</td>
					<td>'.$rRow[itemCode].'</td>
					<td>'.$rRow[reference].'</td>
					<td>'.number_format($rRow[receiveQtyTemp],3).'</td>
					<td>'.pdf_json_files_viewer($rRow[pdf_files]).'</td>
				</tr>';
	}
	?>
	</table>
</div>
<?php } } ?>
<div id=testdiv1
      style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
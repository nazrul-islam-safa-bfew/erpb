<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
	

<?
if($epreceive){
include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$edate = formatDate($edate,"Y-m-d");

$totalReceiveAmount=0;

$temppo1=explode("_",$posl);

for($i=1;$i<$n;$i++){
if($eqPOtype==1){
				$assetId=${assetId.$i};
		 $pCode=$temppo1[1];
		 if($temppo1[3]=='85')
		 
		 $sqlp = "UPDATE `eqproject` set dispatchDate=edate,status=3".
		 " WHERE assetId=$assetId AND pCode='$pCode' AND itemCode='${itemCode.$i}'";
		//echo $sqlp.'<br>';
		mysql_query($sqlp);
		
		//$assetId="V_$temppo1[3]_".${assetId.$i};

		$sdate = formatDate(${sdate.$i},"Y-m-d");
    	$sql="INSERT INTO `eqproject` ( `id` , `itemCode` , `assetId` , `pCode` , `sdate` , `edate` , `receiveDate` , `posl` , `reff`,status,dispatch,dispatchDate )".
			" VALUES ('', '${itemCode.$i}', '$assetId', '$pCode', '$edate', '', '$edate', '$posl', '$eqtsl','1','','')";
  	    $query= mysql_query($sql);			
		//echo $sql.'<br>';
	  $remainQty = eqremainQty($posl,${itemCode.$i},$temppo1[1]);
		if($remainQty==0)
			{
			$sqlitem1 = "UPDATE `porder` SET status='2' WHERE posl='$posl'";
			//echo $sqlitem1.'<br>';
			$query= mysql_query($sqlitem1);
			}

}
else {
   if(${ch.$i}){
   
   	if($temppo1[3]!='85')
		{ $pCode=$temppo1[1];
		//$assetId="V_$temppo1[3]_".${assetId.$i};
		$assetId=${assetId.$i};
		$sdate = formatDate(${sdate.$i},"Y-m-d");
    	$sql="INSERT INTO `eqproject` ( `id` , `itemCode` , `assetId` , `pCode` , `sdate` , `edate` , `receiveDate` , `posl` , `reff`,status,dispatch,dispatchDate )".
			" VALUES ('', '${itemCode.$i}', '$assetId', '$pCode', '$edate', '', '$sdate', '$posl', '$eqtsl','1','','')";
  	    $query= mysql_query($sql);			
		//echo $sql.'<br>';
	  $remainQty = eqremainQty($posl,${itemCode.$i},$temppo1[1]);
		if($remainQty==0)
			{
			$sqlitem1 = "UPDATE `porder` SET status='2' WHERE posl='$posl'";
			//echo $sqlitem1.'<br>';
			$query= mysql_query($sqlitem1);
			}
	}

	if($temppo1[3]=='85') {	
	$sqlitem = "UPDATE `eqproject` SET sdate='$edate',status=1 WHERE id='${ch.$i}'";	
	//echo $sqlitem.'<br>';
	$query= mysql_query($sqlitem);	
    $remainQty = eqremainQty($posl,${itemCode.$i},$temppo1[1]);
		if($remainQty==0)
			{
			$sqlitem1 = "UPDATE `porder` SET status='2' WHERE posl='$posl'";
			//echo $sqlitem1.'<br>';
			$query= mysql_query($sqlitem1);
			}

	}

    }//if
	}//else eqPOtype
  } //for
  
  /*	$sqlpo = "UPDATE popayments SET receiveAmount='$totalReceiveAmount' WHERE posl='$sposl'";
	//echo $sqlpo;
	$sqlQuerypo = mysql_query($sqlpo);*/

}//if
?>

<?
if($storeReceive){
// if(chkReceiveSl($challanNo,$loginProject))
include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
	
$challanNo=get_MRsl($loginProject);

$edate = formatDate($edate,"Y-m-d");


for($i=1; $i<$n;$i++){
$exAmount=${totalQty.$i}* ${rate.$i};
	if(${totalQty.$i}>0){

	//$itemType=itemType(${exitemCode.$i});
	//echo $itemType;
	//if($itemType=='Stock Item'){	}//if
	
	
	$sqlitem = "INSERT INTO `store$loginProject` (rsid,itemCode, receiveQty,currentQty, rate, paymentSL, reference, remark,todat)".
	 "VALUES ('','${exitemCode.$i}', '${totalQty.$i}','${totalQty.$i}', '${rate.$i}', '$sposl', '$challanNo', '$remark', '$edate')";
	//echo $sqlitem.'<br>';
	$query= mysql_query($sqlitem);
	  
	$totalCost+=round(${totalQty.$i}* ${rate.$i});
    }//if
  } //for
    $temppo=explode("_",$posl);
    $pay=poReeiveAmount($posl);
	$amountDue=$pay+$totalCost;
  	$sqlpo = "UPDATE popayments SET receiveAmount='$amountDue' WHERE posl='$posl'";
	//echo $sqlpo;
	$sqlQuerypo = mysql_query($sqlpo);
	
      $sqlpo="SELECT * from porder where posl LIKE '$posl'";
	  $sqlqpo=mysql_query($sqlpo);
	  while($rr=mysql_fetch_array($sqlqpo)){
     if(remainQty($posl,$rr[itemCode],$loginProject)!=0){
	    $ok=0; break;
	  }
	  else $ok=1;
	  //echo "<br>ok:$ok<br>";
	  }
      if($ok){
   		$sqlitem1 = "UPDATE `porder` SET status='2' WHERE posl='$posl' ";
	    //echo $sqlitem1.'<br>';
	   $query= mysql_query($sqlitem1);
         }
	

}//if
?>
<? 
if($epreceive00){
$challanNo=get_MRsl($loginProject);
include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$edate = formatDate($edate,"Y-m-d");
for($i=1; $i<$n;$i++){
if(${totalQty.$i}>0){
		$sql1="SELECT * from storet$loginProject WHERE itemCode='${exitemCode.$i}' AND currentQty <> 0 AND paymentSL='$posl' ORDER by  rsid ASC";
		//echo $sql1;
		$sqlq1=mysql_query($sql1);
		while($ras=mysql_fetch_array($sqlq1)){
			if($ras[currentQty]==${totalQty.$i}){
					$sqlup="UPDATE storet$loginProject set currentQty=0 WHERE rsid=$ras[rsid] ";
					//echo '<br> ss1='.$sqlup.'<br>';
					$qq = mysql_query($sqlup);
					
					$sqlitem = "INSERT INTO `store$loginProject` (rsid,itemCode, receiveQty,currentQty, rate, paymentSL, reference, remark,todat)".
					"VALUES ('','${exitemCode.$i}', '${totalQty.$i}','${totalQty.$i}', '$ras[rate]', '$sposl', '$challanNo', '$remark', '$edate')";
					//echo $sqlitem.'<br>';
					$query= mysql_query($sqlitem);
			break;
			}
			else if($ras[currentQty]>${totalQty.$i}){
					$sqlup="UPDATE storet$loginProject set currentQty=currentQty-".${totalQty.$i}." WHERE rsid=$ras[rsid] ";
					//echo '<br>ss2='.$sqlup.'<br>';
					$qq = mysql_query($sqlup);
					
					$sqlitem = "INSERT INTO `store$loginProject` (rsid,itemCode, receiveQty,currentQty, rate, paymentSL, reference, remark,todat)".
					"VALUES ('','${exitemCode.$i}', '${totalQty.$i}','${totalQty.$i}', '$ras[rate]', '$sposl', '$challanNo', '$remark', '$edate')";
					//echo $sqlitem.'<br>';
					$query= mysql_query($sqlitem);
			break;
			}
			else if($ras[currentQty]<${totalQty.$i}){
					$sqlup="UPDATE storet$loginProject set currentQty=0 WHERE rsid=$ras[rsid] ";
					//echo '<br>ss3='.$sqlup.'<br>';
					$qq = mysql_query($sqlup);

					$sqlitem = "INSERT INTO `store$loginProject` (rsid,itemCode, receiveQty,currentQty, rate, paymentSL, reference, remark,todat)".
					"VALUES ('','${exitemCode.$i}', '$ras[currentQty]','$ras[currentQty]', '$ras[rate]', '$sposl', '$challanNo', '$remark', '$edate')";
					//echo $sqlitem.'<br>';
					$query= mysql_query($sqlitem);
					
					${totalQty.$i}=${totalQty.$i}-$ras[currentQty];
			}			

		}//while
	}//totalQty
  }//for
}
?>

<table width="90%" border="0" align="center" >
<tr><td align="center"><h2>BFEW LTD</h2></td></tr>
<tr><td align="center"><U>RECEIVING FORM</U></td></tr>
<tr><td align="center"><U><? echo $loginProjectName;?></U></td></tr>
<tr><td align="right"><? echo date("l F d, Y h:i:s A");?></td></tr>
</table>

<br>

<? include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
//echo get_MRsl($loginProject);	
?>
<form name="srf" action="./index.php?keyword=purchase+order+receive" method="post">
<table align="center" width="50%" border="3" bordercolor="#99CC99" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr><td  align="center" bgcolor="#99CC99" height="30"><font class="englishHeadBlack"> Store Receive Form</font></td></tr>
<tr>
      <td>PO Ref.: 
        <select name="sposl" onChange="location.href='index.php?keyword=purchase+order+receive&posl='+srf.sposl.options[document.srf.sposl.selectedIndex].value">
          <option value="">Select one</option>
          <?
$i=1;
include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);

if($loginDesignation=="Site Equipment Co-ordinator")
$sqlp = "SELECT distinct posl from `porder` WHERE   posl LIKE  'EQ_".$loginProject."_%' AND status=1";
if($loginDesignation=="Store Officer")
$sqlp = "SELECT distinct posl from `porder` WHERE".
" (itemCode NOT BETWEEN '99-00-000'  AND '99-49-999')".
" AND posl LIKE 'PO_".$loginProject."_%'  AND vid<>'99' AND  status=1";

//echo $sqlp;
$sqlrunp= mysql_query($sqlp);

 while($typel= mysql_fetch_array($sqlrunp))
{
 echo "<option value='".$typel[posl]."'";
 if($posl==$typel[posl]) echo " SELECTED ";
 echo ">".viewPosl($typel[posl])."</option>  ";
 }
?>
          <? 
if($loginDesignation=="Store Officer"){
$sqlp = "SELECT distinct paymentSL, sum(currentQty)  as qty from `storet$loginProject` GROUP by paymentSL HAVING qty >0  ";
//        "( select SUM(curretnQty) as qt from `storet$loginProject` group by paymentSL ) <> 0";

$sqlrunp= mysql_query($sqlp);

 while($typel= mysql_fetch_array($sqlrunp))
{
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
      </td>
</tr>
</table>
<br><br>
<? if($temppo[0]=='PO' AND $temppo[3]!='99' AND $temppo[3]!='117' ){?>

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
	  <td colspan="2"><? echo 	mydate(poDate($posl));?></td>
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
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);

/*if($temppo[3]=='99')
$sqlp12 = "SELECT sporder.* from `sporder` WHERE sposl='$posl' AND status=1 ";
else 
$sqlp12 = "SELECT porder.* from `porder` WHERE posl='$posl' AND status=1 ";
*/
$sqlp12 = "SELECT porder.* from `porder` WHERE posl='$posl' AND status=1 ";
//echo $sqlp12;
$sqlrunp12= mysql_query($sqlp12);
$i=1;
 while($typel12= mysql_fetch_array($sqlrunp12))
{
$temp=itemDes($typel12[itemCode]);
 ?>
<? if(remainQty($posl,$typel12[itemCode],$loginProject)){?>
 <tr>
    <td width="100"><? echo $typel12[itemCode];?>
	<input  type="hidden" name="exitemCode<? echo $i;?>" value="<? echo $typel12[itemCode];?>">
	<input  type="hidden" name="rate<? echo $i;?>" value="<? echo $typel12[rate];?>">	
	</td>
    <td> <? echo $temp[des]; ?> </td>
    <td align="right"> <input type="hidden" name="remainQty<? echo $i;?>" value="<? echo remainQty($posl,$typel12[itemCode],$loginProject);?>" size="12">
	<? 
	if($temppo[3]=='85') echo cstoreRemainQty($posl,$typel12[itemCode],$loginProject);
	else echo remainQty($posl,$typel12[itemCode],$loginProject);?>
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
	<td colspan="6">Transportation Details:
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
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);

$sqlp12 = "SELECT rsid,itemCode,sum(currentQty) as remainQty,rate from `storet$loginProject` WHERE paymentSL='$posl' GROUP by itemCode ";
//echo $sqlp12;
$sqlrunp12= mysql_query($sqlp12);
$i=1;
 while($typel12= mysql_fetch_array($sqlrunp12))
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
    <td> <? echo $temp[des]; ?> </td>
    <td align="right"> <input type="hidden" name="remainQty<? echo $i;?>" value="<? echo $typel12[remainQty];?>" size="12">
	<? echo $typel12[remainQty];?>
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
	<td colspan="6">Transportation Details:
<textarea cols="60" rows="2"></textarea></td>
</tr>
<tr><td colspan="9" align="center">

<input type="button" value="Receive by" name="btnstoreReceive" onClick="if(checkrequired(srf)) {srf.epreceive00.value=1;srf.submit();}">

<input type="hidden" name="posl" value="<? echo $posl;?>">
<input type="hidden" name="n" value="<? echo $i;?>">
<input type="hidden" name="epreceive00" value="0">

</td></tr>
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
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
if($temppo[3]=='85'	)
$sqlp12 = "SELECT * from `eqproject` WHERE posl LIKE '$posl' AND reff LIKE 'EQT_$loginProject%' and status=0";
//echo $sqlp12;
$sqlrunp12= mysql_query($sqlp12);
$i=1;
 while($typel12= mysql_fetch_array($sqlrunp12))
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
	<td align="center">	 <? echo eqpId($typel12[assetId],$typel12[itemCode]);?></td>
</tr>
<? $i++;}?>

<? $sqlp12 = "SELECT * from `porder` WHERE posl = '$posl'  and status=1";
//echo $sqlp12;
$sqlrunp12= mysql_query($sqlp12);

 while($typel12= mysql_fetch_array($sqlrunp12))
{ $temp=itemDes($typel12[itemCode]);

 $sq="SELECT * from eqproject where itemCode='$typel12[itemCode]' and status=2";
 $sqlqq=mysql_query($sq);
 while($re=mysql_fetch_array($sqlqq)){
?>
 <tr>
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
</td>
</tr>
  <? $i++;}?>
<input type="hidden" name="eqPOtype" value="1">
<? }?>
<tr>
	<td colspan="6">Transportation Details:
<textarea cols="60" rows="2"></textarea></td>
</tr>

<tr >
<input type="hidden" name="n" value="<? echo $i;?>">
      <td align="center" colspan="4"> <input type="button" value="Received by <? echo $loginFullName;?>" name="epreceive1" onClick="if(checkrequired(srf)) {srf.submit(); srf.epreceive.value=1;}"> 
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

 <td colspan="2" align="right" >Receiving Date: 
 <input class="yel" type="text" maxlength="10" name="edate" readonly="" > <a id="anchor" href="#"
   onClick="cal.select(document.forms['srf'].edate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
      </td> 

</tr>
<tr>
    <th align="center" width="100" >Item</th>
    <th align="center" >Description</th>
    <th align="center" >Dispatch From Source</th>	
	<th>Equipment ID</th>
</tr>
<? include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sqlp12 = "SELECT * from `porder` WHERE posl = '$posl'  and status=1";
//echo $sqlp12;
$sqlrunp12= mysql_query($sqlp12);

 while($typel12= mysql_fetch_array($sqlrunp12))
{
$temp=itemDes($typel12[itemCode]);
$remainQty = eqremainQty($posl,$typel12[itemCode],$temppo[1]);
//echo $remainQty;
 for($i=1;$i<=$remainQty;$i++){
 ?>

 <tr>
      <td width="100"> <input type="checkbox" name="ch<? echo $i;?>"  value="<? echo $typel12[poid];?>">
        <? echo $typel12[itemCode];?> 
        <input  type="hidden" name="itemCode<? echo $i;?>" value="<? echo $typel12[itemCode];?>">
	<input  type="hidden" name="rate<? echo $i;?>" value="<? echo $typel12[rate];?>">	
	<input  type="hidden" name="totalQty<? echo $i;?>" value="<? echo $typel12[receiveQty];?>">	
	</td>
    <td> <? echo $temp[des].', '.$temp[spc]; ?> </td>
	  <td align="center">
		<input class="yel" type="text" maxlength="10" name="sdate<? echo $i;?>" alt="req" title="Dispatch From Source Date" readonly="" > <a id="anchor<? echo $i;?>" href="#"
		onClick="cal.select(document.forms['srf'].sdate<? echo $i;?>,'anchor<? echo $i;?>','dd/MM/yyyy'); return false;"
		name="anchor<? echo $i;?>" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 	  
	  </td>
	<td align="center">	<input type="text" name="assetId<? echo $i;?>" size="3" width="3" maxlength="3"  ></td>
</tr>
<? }//for
}?>
<tr>
	  <td colspan="6">Transportation Details: 
        <textarea name="textarea" cols="60" rows="2"></textarea>
		</td>
</tr>

<tr >
<input type="hidden" name="n" value="<? echo $i;?>">
      <td align="center" colspan="4"> <input type="button" value="Received by <? echo $loginFullName;?>" name="epreceive1" onClick="if(checkrequired(srf)) {srf.submit(); srf.epreceive.value=1;}"> 
        <input type='hidden' name="epreceive" value="1">
<input type="hidden" name="posl" value="<? echo $posl;?>">

<input type="hidden" name="n" value="<? echo $i;?>">

</td></tr>
</table>

<?
 }// if posl

?>

</form>
<div id=testdiv1
      style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
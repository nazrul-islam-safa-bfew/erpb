<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
<?

if($save){

$format="Y-m-j";
//echo "N: $n";
include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 
$activeDate1 = formatDate($activeDate,$format);
	if($posl){
		$condition=$ch1.'_'.$ch2.'_'.$ch3.'_'.$ch4.'_'.$ch5.'_'.$ch6.'_'.$ch7.'_'.$ch8.'_'.$ch9.'_'.$ch10.'_'.
		$ch11.'_'.$ch12.'_'.$ch13.'_'.$ch14.'_'.$ch15.'_'.$ch16.'_'.$ch17.'_'.$ch18.'_'.$ch19.'_'.$ch20.'_'.
		$ch21.'_'.$ch22.'_'.$ch23.'_'.$ch24.'_'.$tch51.'_'.$tch81.'_'.$tch82.'_'.$tch111.'_'.$tch112.'_'.
		$tch131.'_'.$tch141.'_'.$tch142.'_'.$tch151.'_'.$tch171.'_'.$tch181.'_'.
		$ch25.'_'.$tch251.'_'.$ch26.'_'.$ch27.'_'.$ch28.'_'.$ch29;

	   	 $sql="INSERT INTO `pconditiontemp`(`id`, `posl`, `condition`,`extra`,`extra1`,`extra2`,`extra3`,`extra4`)".
		" VALUES('', '$posl','$condition','$extra','$extra1','$extra2','$extra3','$extra4')";
		echo $sql.'<br>';
		$sqlQ=mysql_query($sql);
		$r=mysql_affected_rows();
		}
		print $r."if(posl)";
if($r>0){
	  $totalAmount=0;
	for($i=1;$i<=$n;$i++)
	{
	  //echo
	 if(${porderQty.$i}>0 )
	 {
	 $d=formatDate($dstart,$format);

	 if(${itemCode.$i}<'50-00-000' && $type!='matp')$potype=1;
	 
//	 elseif(${itemCode.$i}<'50-00-000' && $type=='matp')$potype=6; //this rule is changed at feb/10/14.

	 	 elseif(${itemCode.$i}<'50-00-000' && $type=='matp')$potype=1; //this rule is changed at feb/10/14.

     else if(${itemCode.$i}>='50-00-000' AND ${itemCode.$i}<'70-00-000')$potype=2;	 
	 else if(${itemCode.$i}>='99-00-000')$potype=3;

	 ${rate.$i}=round(${rate.$i},2);
	 ${porderQty.$i}=round(${porderQty.$i},3);
	 
	  $sqlp = "INSERT INTO `pordertemp` (`poid`, `posl`, `poacc`,`location`, `itemCode`, `qty`, `rate`,`vid`,`status`,`qref`,`deliveryDetails`,`dstart`,`activeDate`,`dat`,`potype`)".
	  " VALUES ('','$posl','$acctPayable','$project','${itemCode.$i}','${porderQty.$i}','${rate.$i}', '$vid','-1','${qref.$i}','${deliveryDetails.$i}','$d','$activeDate1','$todat','$potype')";
	// echo "$sqlp<br>";
	//else echo "<br>t$i=".${t.$i};
	$sqlrunp= mysql_query($sqlp);
	$poid1 = mysql_insert_id();
	$totalAmount+= ${porderQty.$i}*${rate.$i};

	$poid = mysql_insert_id();
	 for($k=1;$k<7;$k++){
		if(${qty.$k.'_'.$i}){
			 $d=formatDate(${sdate.$k},$format);
			 if(${invoice.$k}) $inv=1; else $inv=0;
/*		 $sqls = "INSERT INTO poscheduletemp(pos, poid, sdate, qty,invoice)".
		 " VALUES ('','$poid', '$d', '${qty.$k.'_'.$i}','$inv')";
		 */
		  $sqls = "INSERT INTO `poscheduletemp`(`pos`, `posl`,`itemCode`, `sdate`, `qty`,`invoice`)".
		 " VALUES ('','$posl','${itemCode.$i}' ,'$d', '${qty.$k.'_'.$i}','$inv')";
		 
		$sqlrunp= mysql_query($sqls);
		//echo $sqls.'<br>';
		}//if
	   }//for
	  }//if
	}//for

	if($posl){
	$poRef=poCredit($vid);
	
	  $sqlpo = "INSERT INTO `popaymentstemp`(`popID`, `posl`, `acctPayable`,`totalAmount`,`receiveAmount`, `paidAmount`,`poRef`)".
	" VALUES ('','$posl','$acctPayable','$totalAmount','','','$poRef')";
	//echo $sqlpo;
	$sqlQuerypo = mysql_query($sqlpo);
	}
	echo "Please wait.......";
echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=./index.php?keyword=item+require\">";
 }
}

?>

<form name="purchaseOrder" action="./index.php?keyword=matpurchase+Order&vid=<? echo $vid;?>&project=<? echo $project;?>&itemCode=<? echo $itemCode;?>&type=<? echo $type;?>"  method="post">
	<SCRIPT LANGUAGE="JavaScript">
	var now = new Date();
	var cal = new CalendarPopup("testdiv1");
    	//cal.showNavigationDropdowns();
		cal.setWeekStartDay(6); // week is Monday - Sunday
		//cal.addDisabledDates(null,formatDate(now,"yyyy-MM-dd"));
		cal.setCssPrefix("TEST");
		cal.offsetX = 25;
		cal.offsetY = -120;

	</SCRIPT>

  <table align="center" width="95%" border="1" bordercolor="#CCCCFF" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
    <tr bgcolor="#CCCCFF">
	<td>Accounts payable: <? echo selectAlist('acctPayable','10',$acctPayable);?>
	
	<br>Purchase Order Release date: <input type="text" name="activeDate" size="10" value="<? echo $activeDate;?>">
  <a id="anchor" href="#"
   onClick="cal.select(document.forms['purchaseOrder'].activeDate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a>
	</td>

        <? $posl=posl($project,$vid,1); //$posl='p'.$vid.'_000001';?>
         <input type="hidden" name="posl" value="<? echo $posl;?>">

      <td align="right" colspan="6" height="30" >purchase order</font> for <? echo myprojectName($project);?></td>
    </tr>
	<tr>
	  <td colspan="7">

	 <? include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 
$vendor = "SELECT * from `vendor` WHERE vid=$vid";
//echo $sqlp;
$sqlr= mysql_query($vendor);
$vendor = mysql_fetch_array($sqlr);
?>
	  <table align="center" width="95%"   border="2" bordercolor="#E8E8E8" cellspacing="0" cellpadding="3" style="border-collapse:collapse">
 <TR bgcolor="#EEEEEE">
		  <TD width="50%"  >Vendor Name:<b> <? echo $vendor[vname];?></b></TD>
		  <TD  align="right">
			  <table  width="250" border="2" bgcolor="#FFFFFF" bordercolor="#FF0000" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
    			<tr><td align="center">Vendor Rating: <font color="#FF0000" size="+2"><? echo $vendor[point];?> </font>Points
				<a href="<? echo $vendor[att];?>"><img src="./images/pdf_icon.jpg" width="30" height="30" border="0" ></a>
				</td></tr>
			   </table>

		  </TD>

 </TR>
 <TR >
  <TD colspan="2">Address :<font class="out"><? echo $vendor[address];?></font></TD>
 </TR>

 <TR>
  <TD colspan="2">Contact Name: <font class="out"><? echo $vendor[contactName];?></font> , <font class="out"><? echo $vendor[designation];?></font> , <font class="out"><? echo $vendor[mobile];?></font></TD>
 </TR>
 <TR>
  <TD colspan="2" >Accounts Information: <font class="out"><? echo $vendor[accInfo];?></font></TD>
 </TR>
 <TR>
  <TD>Vendor Type: <font class="out"><? echo vendorRating($vendor[type],1);?></font></TD>
  <TD>Position: <font class="out"><? echo vendorRating($vendor[quality],2);?></font></TD>
 </TR>
 <TR>
  <TD>Reliability: <font class="out"><? echo vendorRating($vendor[reliability],2);?></font>

	  <? if($vendor[reliabilityText]){?><br><font class="outi"><? echo $vendor[reliabilityText];?></font><? }?>
    </TD>
  <TD>Availability: <font class="out"><? echo vendorRating($vendor[availability],2);?></font>
  	  <? if($vendor[availabilityText]){?><br><font class="outi"><? echo $vendor[availabilityText];?></font><? }?>
  </TD>
 </TR>
 <TR>
  <TD>Experience in the market: <font class="out"><? echo vendorRating($vendor[experienceM],3);?></font>
  	  <? if($vendor[experienceMText]){?><br><font class="outi"><? echo $vendor[experienceMText];?></font><? }?></TD>
  <TD>Experience with BFEW: <font class="out"><? echo vendorRating($vendor[experienceB],3);?></font>
  	  <? if($vendor[experienceBText]){?><br><font class="outi"><? echo $vendor[experienceBText];?></font><? }?></TD>
 </TR>
 <TR>
  <TD>After Sales service: <font class="out"><? echo vendorRating($vendor[service],2);?></font>
  	  <? if($vendor[serviceText]){?><br><font class="outi"><? echo $vendor[serviceText];?></font><? }?></TD>
  <TD>Advance Required: <font class="out"><? echo vendorRating($vendor[advance],4);?></font></TD>
 </TR>
	 <TR>
	  <TD >Credit Facility: <font class="out"><? echo vendorRating($vendor[cfacility],4);?></font>;
	  <? if($vendor[cfacility]==4){?>
	   Max. Credit Amount: Tk. <font class="out"><? echo number_format($vendor[camount],2);?></font>
		  Max. Credit Duration: <font class="out"><? echo $vendor[cduration];?></font> days</TD>
		  <? }?>
 	 <TD>Credit Received:</TD>
	 </TR>
</table>

	  </td>
	</tr>

    <tr>
      <td colspan="7" height="5" bgcolor="#CCCCFF"></td>
    </tr>
    <tr>
	 <td colspan="7">
	   <table width="100%" border="1" bordercolor="#CCCCCC" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
	     <tr>
      <th height="23">Quantity</th>
      <th width="100">Item Code</th>
      <th>Description</th>
      <th>Rate</th>
      <th>Amount</th>
      <th>Quotation Ref.</th>
	  </tr>


    <?
if($vid){

include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 
if($vid==99)$sqlp = "SELECT itemCode, avg(rate) as rate from  `store` GROUP by itemCode order by itemCode ASC";
else	
$sqlp = "SELECT * from  `quotation` WHERE vid=$vid and pCode IN ('$project' ,'000') AND valid>'$todat' order by itemCode ASC";
//echo $sqlp;
$sqlrunp= mysql_query($sqlp);
$i=1;
$totalAmount=0;
while($typel1= mysql_fetch_array($sqlrunp))
{
$temp=itemDes($typel1[itemCode]);
//$order=orderQty($project,$typel1[itemCode]); 
//echo "**$typel1[itemCode]=order:$order**";
//$totalQty = round(totaldmaQty($project,$typel1[itemCode]),3);
//echo "totalQty=$totalQty<br>";

// $ex= $totalQty-$order;
$ex=999999999999999999;
if($ex>0){
?>
    <tr>
	
      <td>
	  <? if(valid1($typel1[valid])){ ?>
	  <input type="text" name="porderQty<? echo $i;?>" value="<? echo ${porderQty.$i};?>" style="text-align:right" size="10"
	   onBlur="if(this.value > <? echo $ex;?> || <? echo 'porderQty'.$i;?>.value < 0 ) {alert('Purchase Order quantity exceeding Estimated Quantity is not acceptable.'); this.value=0;}">
	   <?  echo $temp[unit];?>
	   <? } else echo " Validation date Expired!!"?>
        
      </td>
      <td align="center"><? echo $typel1[itemCode]?> <input type="hidden" name="itemCode<? echo $i;?>" value="<? echo $typel1[itemCode]?>">
	    <input type="hidden" name="deliveryDetails<? echo $i;?>" value="<?  echo $typel1[delivery].' '.myprojectName($typel1[deliveryLoc]).' '.$typel1[sDetail] ;?>">
      </td>
      <td>
        <?  echo $temp[des].','.$temp[spc];?>
      </td>
      <td align="right"><? echo $typel1[rate]?> <input type="hidden" name="rate<? echo $i;?>" value="<? echo $typel1[rate]?>">
      </td>
      <td align="right"><? echo number_format(round($typel1[rate]*${porderQty.$i}),2)?></td>
      <td align="center"><? echo $typel1[qRef]?>
	   <input type="hidden" name="qref<? echo $i;?>" value="<? echo $typel1[qRef]?>">
	  </td>
    </tr>
	<?  } //if Ex?>
    <?
 $totalAmount+=round($typel1[rate]*${porderQty.$i});
 $i++;
} //while
?>
    <input type="hidden" name="n" value="<? echo $i;?>">
<? 
}//if?>
	   </table>
	 </td>
    </tr>

    <tr>
      <td colspan="3" style="border-color=#FFFFFF" align="center">
	   <input type="button"  value="Calculate" name="calculate1" onClick="calculate.value=1; purchaseOrder.submit();">
	   <input type="hidden"  value="0" name="calculate">	   
	  </td>
      <td colspan="2" align="right" bgcolor="#FFFF00">Total: Tk.<? echo number_format($totalAmount,2);?></td>
    </tr>
  </table>
<br><br><br>
  <? if($calculate){?>
  <table align="center" width="1000" border="1" bordercolor="#0099FF" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
    <tr> 
      <td width="300">Receiving will start at 
        <input type="text" name="dstart" size="10"> <a id="anchor0" href="#"
   onClick="cal.select(document.forms['purchaseOrder'].dstart,'anchor0','dd/MM/yyyy'); return false;"
   name="anchor0" ><img src="./images/b_calendar.png" alt="calender" border="0"></a></td>
   
      <td  > <input type="text" name="sdate1"  size="10"><a id="anchor12" href="#"
   onClick="cal.select(document.forms['purchaseOrder'].sdate1,'anchor12','dd/MM/yyyy'); return false;"
   name="anchor12" ><img src="./images/b_calendar.png" alt="calender" border="0"></a></td>
      <td  > <input type="text" name="sdate2"  size="10"><a id="anchor2" href="#"
   onClick="cal.select(document.forms['purchaseOrder'].sdate2,'anchor2','dd/MM/yyyy'); return false;"
   name="anchor2" ><img src="./images/b_calendar.png" alt="calender" border="0"></a></td>
      <td  > <input type="text" name="sdate3"  size="10"><a id="anchor3" href="#"
   onClick="cal.select(document.forms['purchaseOrder'].sdate3,'anchor3','dd/MM/yyyy'); return false;"
   name="anchor3" ><img src="./images/b_calendar.png" alt="calender" border="0"></a></td>
      <td > <input type="text" name="sdate4"  size="10"><a id="anchor4" href="#"
   onClick="cal.select(document.forms['purchaseOrder'].sdate4,'anchor4','dd/MM/yyyy'); return false;"
   name="anchor4" ><img src="./images/b_calendar.png" alt="calender" border="0"></a></td>
      <td  > <input type="text" name="sdate5"  size="10"><a id="anchor5" href="#"
   onClick="cal.select(document.forms['purchaseOrder'].sdate5,'anchor5','dd/MM/yyyy'); return false;"
   name="anchor5" ><img src="./images/b_calendar.png" alt="calender" border="0"></a></td>
      <td > <input type="text" name="sdate6"  size="10"><a id="anchor<? echo $j;?>1" href="#"
   onClick="cal.select(document.forms['purchaseOrder'].sdate6,'anchor6','dd/MM/yyyy'); return false;"
   name="anchor6" ><img src="./images/b_calendar.png" alt="calender" border="0"></a></td>
      <td > <input type="text" name="sdate7"  size="10"><a id="anchor7" href="#"
   onClick="cal.select(document.forms['purchaseOrder'].sdate7,'anchor7','dd/MM/yyyy'); return false;"
   name="anchor7" ><img src="./images/b_calendar.png" alt="calender" border="0"></a></td>
    </tr>
    <?

if($vid){
include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 
if($vid==99)$sqlp = "SELECT itemCode, avg(rate) as rate from  `store` GROUP by itemCode order by itemCode ASC";
else		
$sqlp = "SELECT * from  `quotation` WHERE vid=$vid and pCode in ('$project','000') AND valid>'$todat' order by itemCode ASC";
//echo $sqlp;
$sqlrunp= mysql_query($sqlp);
 $j=1;
 while($typel1= mysql_fetch_array($sqlrunp))
{
$temp=itemDes($typel1[itemCode]);

if(${porderQty.$j}){
?>
    <tr <? if($j%2==1) echo "bgcolor=#EEEEEE";?> > 
      <td width="200" >
        <? $temp=itemDes($typel1[itemCode]); echo $temp[des];?>
        <br>
        Delivery Details: 
        <?  echo $typel1[delivery].' '.myprojectName($typel1[deliveryLoc]).' '.$typel1[sDetail] ;?>
      </td>
      <td><input type="text" name="qty1_<? echo $j;?>" value="<? echo ${porderQty.$j}; ?>" onBlur="purchaseOrder.qty2_<? echo $j;?>.value = <? echo ${porderQty.$j}; ?> - purchaseOrder.qty1_<? echo $j;?>.value ;" style="text-align:right" size="10"> 
        <? echo $temp[unit];?></td>
      <td><input type="text" name="qty2_<? echo $j;?>" onBlur="purchaseOrder.qty3_<? echo $j;?>.value = <? echo ${porderQty.$j}; ?> - purchaseOrder.qty1_<? echo $j;?>.value- purchaseOrder.qty2_<? echo $j;?>.value ;" style="text-align:right" size="10"> 
        <? echo $temp[unit];?></td>
      <td><input type="text" name="qty3_<? echo $j;?>" onBlur="purchaseOrder.qty4_<? echo $j;?>.value = <? echo ${porderQty.$j}; ?> - purchaseOrder.qty1_<? echo $j;?>.value- purchaseOrder.qty2_<? echo $j;?>.value- purchaseOrder.qty3_<? echo $j;?>.value ;" style="text-align:right" size="10"> 
        <? echo $temp[unit];?></td>
      <td><input type="text" name="qty4_<? echo $j;?>" onBlur="purchaseOrder.qty5_<? echo $j;?>.value = <? echo ${porderQty.$j}; ?> - purchaseOrder.qty1_<? echo $j;?>.value- purchaseOrder.qty2_<? echo $j;?>.value- purchaseOrder.qty3_<? echo $j;?>.value- purchaseOrder.qty4_<? echo $j;?>.value ;" style="text-align:right" size="10"> 
        <? echo $temp[unit];?></td>
      <td><input type="text" name="qty5_<? echo $j;?>" onBlur="purchaseOrder.qty6_<? echo $j;?>.value = <? echo ${porderQty.$j}; ?> - purchaseOrder.qty1_<? echo $j;?>.value- purchaseOrder.qty2_<? echo $j;?>.value- purchaseOrder.qty3_<? echo $j;?>.value- purchaseOrder.qty4_<? echo $j;?>.value- purchaseOrder.qty5_<? echo $j;?>.value ;" style="text-align:right" size="10"> 
        <? echo $temp[unit];?></td>
      <td><input type="text" name="qty6_<? echo $j;?>" onBlur="purchaseOrder.qty7_<? echo $j;?>.value = <? echo ${porderQty.$j}; ?> - purchaseOrder.qty1_<? echo $j;?>.value- purchaseOrder.qty2_<? echo $j;?>.value- purchaseOrder.qty3_<? echo $j;?>.value- purchaseOrder.qty4_<? echo $j;?>.value- purchaseOrder.qty5_<? echo $j;?>.value- purchaseOrder.qty6_<? echo $j;?>.value ;" style="text-align:right" size="10"> 
        <? echo $temp[unit];?></td>
      <td><input type="text" name="qty7_<? echo $j;?>" style="text-align:right" size="10"> 
        <? echo $temp[unit];?></td>
    </tr>
    <tr>
      <td height="5" bgcolor="#0099FF" colspan="8"></td>
    </tr>
    <? }
$j++;
} //while
}//if
?>
    <tr>
      <td>Invoice Raising Dates</td>
      <td><input type="checkbox" name="invoice1" onClick="if(sdate1.value){this.value=sdate1.value;}
	   else {alert('no date'); sdate1.focus();this.checked=false;}"></td>
	   
      <td><input type="checkbox" name="invoice2" onClick="if(sdate2.value){this.value=sdate2.value;}
	   else {alert('no date'); sdate2.focus();this.checked=false;}"></td>

      <td><input type="checkbox" name="invoice3" onClick="if(sdate3.value){this.value=sdate3.value;}
	   else {alert('no date'); sdate3.focus();this.checked=false;}"></td>

      <td><input type="checkbox" name="invoice4" onClick="if(sdate4.value){this.value=sdate4.value;}
	   else {alert('no date'); sdate4.focus();this.checked=false;}"></td>

      <td><input type="checkbox" name="invoice5" onClick="if(sdate5.value){this.value=sdate5.value;}
	   else {alert('no date'); sdate5.focus();this.checked=false;}"></td>

      <td><input type="checkbox" name="invoice6" onClick="if(sdate6.value){this.value=sdate6.value;}
	   else {alert('no date'); sdate6.focus();this.checked=false;}"></td>

      <td><input type="checkbox" name="invoice7" onClick="if(sdate7.value){this.value=sdate7.value;}
	   else {alert('no date'); sdate7.focus();this.checked=false;}"></td>
    </tr>
    <tr>
      <td colspan="8">
        <? 
		if($itemCode<'99-00-000')
		include('condition.php');
		else 
		include('sub_condition.php');		
		?>
      </td>
    </tr>
    <tr>
      <td colspan="8">
	  <input type="button" name="save1" value="Save PO" onClick="save.value=1; purchaseOrder.submit();">
	  <input type="hidden" name="save" value="0">	  
	  
	  </td>
    </tr>
    <? }//Calculate?>
  </table>
</form>

<div id=testdiv1
      style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
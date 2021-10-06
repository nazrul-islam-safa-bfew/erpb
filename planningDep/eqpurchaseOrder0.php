
	<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>


<? function value($v,$t){
	if($t=='1'){
	if($v=='5') $out='Sole Importer / Distributor';
	else if($v=='4') $out='Manufacturer';
	else if($v=='3') $out='Wholesaler';
	else if($v=='2') $out='Local Vendor';
	else if($v=='1') $out='Importer';
	else if($v=='0') $out='Retailer';
	}
	if($t=='2'){
	if($v=='5') $out='Outstanding';
	else if($v=='3') $out='Good';
	else if($v=='0') $out='Unknown';
	else if($v=='-2') $out='Unsatisfactory';
	}
	if($t=='3'){
	if($v=='5') $out='5 years above';
	else if($v=='3') $out='1 - 5 years';
	else if($v=='0') $out='Less then 1 years';
	else if($v=='-2') $out='NIL';
	}
	if($t=='4'){
	if($v=='5') $out='Bill-to-Bill';
	else if($v=='4') $out='Yes';
	else if($v=='0') $out='No';
	}

	return $out;
}
?>

<?
if($save){

$format="Y-m-j";

//echo "N: $n";
include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

	for($i=1;$i<=$n;$i++)
	{
	  //echo
	 if(${eqch.$i})
	 {
	  $sqlp = "INSERT INTO porder (poid, posl, poacc,location, itemCode, qty, rate,vid,status,qref,deliveryDetails,dstart,dat,potype)".
	  " VALUES ('','$posl','$acctPayable','$project','${itemCode.$i}','1','${rate.$i}', '$vid','0','${qref.$i}','${deliveryDetails.$i}','${sd.$i}','$todat','${eqch.$i}')";
	 //echo "<br>$sqlp";
	 //else echo "<br>t$i=".${t.$i};
	 $sqlrunp= mysql_query($sqlp);
	 $poid = mysql_insert_id();

	 $sqls = "INSERT INTO poschedule(pos, poid, sdate, qty) VALUES ('','$poid', '${ed.$i}', '1')";
		 $sqlrunp= mysql_query($sqls);
		//echo '<br>'.$sqls;
	  }//if
	}//for
	if($posl){
		$condition=$ch1.'_'.$ch2.'_'.$ch3.'_'.$ch4.'_'.$ch5.'_'.$ch6.'_'.$ch7.'_'.$ch8.'_'.$ch9.'_'.$ch10.'_'.$ch11.'_'.$ch12.'_'.$ch13.'_'.
		$ch14.'_'.$ch15.'_'.$ch16.'_'.$ch17.'_'.$ch18.'_'.$ch19.'_'.$ch20.'_'.$ch21.'_'.$ch22.'_'.
		$tch51.'_'.$tch81.'_'.$tch82.'_'.$tch111.'_'.$tch112.'_'.$tch121.'_'.$tch122.'_'.$tch131.'_'.$tch141.'_'.$tch151;

	   	$sql="INSERT INTO pcondition(id, posl, condition,extra) VALUES('', '$posl','$condition','$extra')";
		//echo '<br>'.$sql;
		$sqlQ=mysql_query($sql);
		}

	if($posl){
	$sqlpo = "INSERT INTO popayments(popID, posl, acctPayable,totalAmount,receiveAmount, paidAmount) VALUES ('','$posl','$acctPayable','$totalAmount','','')";
	//echo '<br>'.$sqlpo;
	$sqlQuerypo = mysql_query($sqlpo);
	}

}

?>

<form name="purchaseOrder" action="./index.php?keyword=eqpurchase+Order&vid=<? echo $vid;?>&project=<? echo $project;?>&itemCode=<? echo $itemCode;?>"  method="post">

  <table align="center" width="95%" border="1" bordercolor="#CCCCFF" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
    <tr bgcolor="#CCCCFF">
	<td>Accounts payable: <? echo selectAlist('acctPayable','10',$acctPayable);?></td>

        <? $posl=posl($project,$vid); //$posl='p'.$vid.'_000001';?>
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
		  <TD width="50%"  >Vendore Name:<b> <? echo $vendor[vname];?></b></TD>
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
  <TD>Vendor Type: <font class="out"><? echo value($vendor[type],1);?></font></TD>
  <TD>Quality Image: <font class="out"><? echo value($vendor[quality],2);?></font></TD>
 </TR>
 <TR>
  <TD>Reliability: <font class="out"><? echo value($vendor[reliability],2);?></font>

	  <? if($vendor[reliabilityText]){?><br><font class="outi"><? echo $vendor[reliabilityText];?></font><? }?>
    </TD>
  <TD>Availability: <font class="out"><? echo value($vendor[availability],2);?></font>
  	  <? if($vendor[availabilityText]){?><br><font class="outi"><? echo $vendor[availabilityText];?></font><? }?>
  </TD>
 </TR>
 <TR>
  <TD>Experience in the market: <font class="out"><? echo value($vendor[experienceM],3);?></font>
  	  <? if($vendor[experienceMText]){?><br><font class="outi"><? echo $vendor[experienceMText];?></font><? }?></TD>
  <TD>Experience with BFEW: <font class="out"><? echo value($vendor[experienceB],3);?></font>
  	  <? if($vendor[experienceBText]){?><br><font class="outi"><? echo $vendor[experienceBText];?></font><? }?></TD>
 </TR>
 <TR>
  <TD>After Sales service: <font class="out"><? echo value($vendor[service],2);?></font>
  	  <? if($vendor[serviceText]){?><br><font class="outi"><? echo $vendor[serviceText];?></font><? }?></TD>
  <TD>Advance Required: <font class="out"><? echo value($vendor[advance],4);?></font></TD>
 </TR>
	 <TR>
	  <TD >Credit Facility: <font class="out"><? echo value($vendor[cfacility],4);?></font>;
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
      <th>Equipment Code</th>
      <th>Description</th>
      <th>Duration</th>	  
      <th>Rate/ day</th>
	  <th>Amount</th>
      <th>Quotation Ref.</th>
    </tr>
	<SCRIPT LANGUAGE="JavaScript">
	var now = new Date();
	var cal = new CalendarPopup("testdiv1");
    	//cal.showNavigationDropdowns();
		cal.setWeekStartDay(6); // week is Monday - Sunday
		cal.addDisabledDates(null,formatDate(now,"yyyy-MM-dd"));
		cal.setCssPrefix("TEST");
		cal.offsetX = 25;
		cal.offsetY = -120;

	</SCRIPT>


    <?
if($vid){

include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 
$totalAmount=0;
$sqlp2 = "SELECT * from  `quotation` WHERE vid=$vid and pCode IN ('$project' ,'000') and itemCode BETWEEN '50-00-000' AND '69-99-999'";
//echo $sqlp2;
$sqlrunp2= mysql_query($sqlp2);
$i=1;
while($typel2= mysql_fetch_array($sqlrunp2)){

$sqlp = "SELECT * from  `equipmentreq` WHERE  pCode ='$project' AND eqCode='$typel2[itemCode]' AND posl=''";
//$sqlp = "SELECT * from  `quotation` WHERE vid=$vid and pCode IN ('$project' ,'000') AND valid>'$todat'";
echo $sqlp;
$sqlrunp= mysql_query($sqlp);


 while($typel1= mysql_fetch_array($sqlrunp))
{
$temp=itemDes($typel1[eqCode]);
?>
    <tr>
      <td align="center"  width="100">
	  <input type="checkbox" name="eqch<? echo $i;?>" value="<? echo $typel1[eqreid] ;?>" <? if(${eqch.$i}) echo 'checked';?> >
	  <? echo $typel1[eqCode];?> <input type="hidden" name="itemCode<? echo $i;?>" value="<? echo $typel1[eqCode]?>">
	    <input type="hidden" name="deliveryDetails<? echo $i;?>" value="<?  echo $typel2[delivery].' '.myprojectName($typel2[deliveryLoc]).' '.$typel2[sDetail] ;?>">
        <?  echo $temp[unit];?>
      </td>
      <td> <?  echo $temp[des];?></td>
       <td align="center"><? echo '<font color=#FF3333>'.myDate($typel1[rdate]).'</font> to <font color=#FF3333>'.myDate($typel1[ddate]).'</font>';
           $duration=(strtotime($typel1[ddate])- strtotime($typel1[rdate]))/(3600*24); echo ' ('.$duration.' days)';
      ?>
	  <input type="hidden" name="sd<? echo $i;?>"  value="<? echo $typel1[rdate];?>">
	  <input type="hidden" name="ed<? echo $i;?>"  value="<? echo $typel1[ddate];?>">
	  </td>  
	  
      <td align="right"><? echo $typel2[rate]?> <input type="hidden" name="rate<? echo $i;?>" value="<? echo $typel2[rate];?>"></td>
      <td align="right"><? echo number_format($typel2[rate]*$duration,2);?></td>
      <td align="center"><? echo $typel2[qRef]?>
	   <input type="hidden" name="qref<? echo $i;?>" value="<? echo $typel2[qRef]?>">
	  </td>
    </tr>
    <input type="hidden" name="n" value="<? echo $i;?>">
    <?
 if(${eqch.$i}) $totalAmount+=$typel2[rate]*$duration;
 
 $i++;
} //while

} //while

}//if vid?>
    <tr>
      <td colspan="3" style="border-color=#FFFFFF" align="center"> <input type="submit"  value="Calculate" name="calculate"></td>
      <td colspan="2" align="right" bgcolor="#FFFF00">Total: Tk.<? echo number_format($totalAmount,2);?>
	  <input type="hidden" name="totalAmount" value="<? echo $totalAmount;?>">
	  </td>
    </tr>
  </table>
<br><br><br>
<? if($calculate){?>
<table align="center" width="95%" border="1" bordercolor="#0099FF" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
<tr>
  <th >Item</th>
  <th width="25%" >Date</th>
  <th  width="25%">Quantity</th>
</tr>


<?

if($vid){
include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 
$sqlp = "SELECT * from  `quotation` WHERE vid=$vid and pCode in ('$project','000') AND valid>'$todat'";
//echo $sqlp;
$sqlrunp= mysql_query($sqlp);
 $j=1;
 while($typel1= mysql_fetch_array($sqlrunp))
{
$temp=itemDes($typel1[itemCode]);


if(${porderQty.$j}){
?>
<tr>
  <td rowspan="7" ><? $temp=itemDes($typel1[itemCode]); echo $temp[des];?>
  <br>Delivery Details: <?  echo $typel1[delivery].' '.myprojectName($typel1[deliveryLoc]).' '.$typel1[sDetail] ;?>
  <br><br> Receiving will start at <input type="text" name="dstart<? echo $j;?>" size="10">
  <a id="anchor<? echo $j;?>" href="#"
   onClick="cal.select(document.forms['purchaseOrder'].dstart<? echo $j;?>,'anchor<? echo $j;?>','dd/MM/yyyy'); return false;"
   name="anchor<? echo $j;?>" ><img src="./images/b_calendar.png" alt="calender" border="0"></a>
  </td>
  <td align="center">Till  <input type="text" name="sdate<? echo $j;?>1"  size="10">
    <a id="anchor<? echo $j;?>1" href="#"
   onClick="cal.select(document.forms['purchaseOrder'].sdate<? echo $j;?>1,'anchor<? echo $j;?>1','dd/MM/yyyy'); return false;"
   name="anchor<? echo $j;?>1" ><img src="./images/b_calendar.png" alt="calender" border="0"></a>

  </td>
  <td><input type="text" name="qty<? echo $j;?>1" value="<? echo ${porderQty.$j}; ?>" onBlur="purchaseOrder.qty<? echo $j;?>2.value = <? echo ${porderQty.$j}; ?> - purchaseOrder.qty<? echo $j;?>1.value ;document.purchaseOrder.sdate<? echo $j;?>2.focus();" style="text-align:right" size="10"> <? echo $temp[unit];?></td>
</tr>
<tr>
  <td align="center">Till  <input type="text" name="sdate<? echo $j;?>2" size="10">
      <a id="anchor<? echo $j;?>2" href="#"
   onClick="cal.select(document.forms['purchaseOrder'].sdate<? echo $j;?>2,'anchor<? echo $j;?>2','dd/MM/yyyy'); return false;"
   name="anchor<? echo $j;?>2" ><img src="./images/b_calendar.png" alt="calender" border="0"></a>

  </td>
  <td><input type="text" name="qty<? echo $j;?>2" onBlur="purchaseOrder.qty<? echo $j;?>3.value = <? echo ${porderQty.$j}; ?> - purchaseOrder.qty<? echo $j;?>2.value - purchaseOrder.qty<? echo $j;?>1.value ;document.purchaseOrder.sdate<? echo $j;?>3.focus();" style="text-align:right" size="10"> <? echo $temp[unit];?></td>
</tr>
<tr>
  <td align="center">Till  <input type="text" name="sdate<? echo $j;?>3" size="10">
      <a id="anchor<? echo $j;?>3" href="#"
   onClick="cal.select(document.forms['purchaseOrder'].sdate<? echo $j;?>3,'anchor<? echo $j;?>3','dd/MM/yyyy'); return false;"
   name="anchor<? echo $j;?>3" ><img src="./images/b_calendar.png" alt="calender" border="0"></a>

  </td>
  <td><input type="text" name="qty<? echo $j;?>3" onBlur="purchaseOrder.qty<? echo $j;?>4.value = <? echo ${porderQty.$j}; ?> - purchaseOrder.qty<? echo $j;?>3.value- purchaseOrder.qty<? echo $j;?>2.value - purchaseOrder.qty<? echo $j;?>1.value ;document.purchaseOrder.sdate<? echo $j;?>4.focus();" style="text-align:right" size="10"> <? echo $temp[unit];?></td>
</tr>
<tr>
  <td align="center">Till  <input type="text" name="sdate<? echo $j;?>4" size="10">
      <a id="anchor<? echo $j;?>4" href="#"
   onClick="cal.select(document.forms['purchaseOrder'].sdate<? echo $j;?>4,'anchor<? echo $j;?>4','dd/MM/yyyy'); return false;"
   name="anchor<? echo $j;?>4" ><img src="./images/b_calendar.png" alt="calender" border="0"></a>

  </td>
  <td><input type="text" name="qty<? echo $j;?>4" onBlur="purchaseOrder.qty<? echo $j;?>5.value = <? echo ${porderQty.$j}; ?> - purchaseOrder.qty<? echo $j;?>4.value - purchaseOrder.qty<? echo $j;?>3.value- purchaseOrder.qty<? echo $j;?>2.value - purchaseOrder.qty<? echo $j;?>1.value ;document.purchaseOrder.sdate<? echo $j;?>5.focus();" style="text-align:right" size="10"> <? echo $temp[unit];?></td>
</tr>
<tr>
  <td align="center">Till  <input type="text" name="sdate<? echo $j;?>5" size="10">
      <a id="anchor<? echo $j;?>5" href="#"
   onClick="cal.select(document.forms['purchaseOrder'].sdate<? echo $j;?>5,'anchor<? echo $j;?>5','dd/MM/yyyy'); return false;"
   name="anchor<? echo $j;?>5" ><img src="./images/b_calendar.png" alt="calender" border="0"></a>

  </td>
  <td><input type="text" name="qty<? echo $j;?>5" onBlur="purchaseOrder.qty<? echo $j;?>6.value = <? echo ${porderQty.$j}; ?> - purchaseOrder.qty<? echo $j;?>5.value- purchaseOrder.qty<? echo $j;?>4.value - purchaseOrder.qty<? echo $j;?>3.value- purchaseOrder.qty<? echo $j;?>2.value - purchaseOrder.qty<? echo $j;?>1.value ;document.purchaseOrder.sdate<? echo $j;?>6.focus();" style="text-align:right" size="10"> <? echo $temp[unit];?></td>
</tr>
<tr>
  <td align="center">Till  <input type="text" name="sdate<? echo $j;?>6" size="10">
      <a id="anchor<? echo $j;?>6" href="#"
   onClick="cal.select(document.forms['purchaseOrder'].sdate<? echo $j;?>6,'anchor<? echo $j;?>6','dd/MM/yyyy'); return false;"
   name="anchor<? echo $j;?>6" ><img src="./images/b_calendar.png" alt="calender" border="0"></a>

  </td>
  <td><input type="text" name="qty<? echo $j;?>6" onBlur="purchaseOrder.qty<? echo $j;?>7.value = <? echo ${porderQty.$j}; ?> - purchaseOrder.qty<? echo $j;?>6.value- purchaseOrder.qty<? echo $j;?>5.value- purchaseOrder.qty<? echo $j;?>4.value - purchaseOrder.qty<? echo $j;?>3.value- purchaseOrder.qty<? echo $j;?>2.value - purchaseOrder.qty<? echo $j;?>1.value ;document.purchaseOrder.sdate<? echo $j;?>7.focus();" style="text-align:right" size="10"> <? echo $temp[unit];?></td>
</tr>
<tr>
  <td align="center">Till  <input type="text" name="sdate<? echo $j;?>7" size="10">
      <a id="anchor<? echo $j;?>7" href="#"
   onClick="cal.select(document.forms['purchaseOrder'].sdate<? echo $j;?>7,'anchor<? echo $j;?>7','dd/MM/yyyy'); return false;"
   name="anchor<? echo $j;?>7" ><img src="./images/b_calendar.png" alt="calender" border="0"></a>

  </td>
  <td><input type="text" name="qty<? echo $j;?>7" size="10"> <? echo $temp[unit];?></td>
</tr>
<tr><td height="5" bgcolor="#0099FF" colspan="3"></td></tr>
<? }
$j++;
} //while
}//if
?>
<tr><td colspan="3"><? include('condition.php');?></td></tr>
<tr><td colspan="3"><input type="submit" name="save" value="Save"></td></tr>
<? }//Calculate?>
</table>
</form>

<div id=testdiv1
      style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
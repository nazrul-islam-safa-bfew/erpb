<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>

<?
 $dmaTotal=$_GET[dmaTotal];
 $poTotal=$_GET[poTotal];
?>

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
	 if(${porderQty.$i}>0)
	 {
	 $d=formatDate(${dstart.'_'.$i},$format);
	  $sqlp = "INSERT INTO porder (poid, posl, poacc,location, itemCode, qty, rate,vid,status,qref,deliveryDetails,dstart,dat) VALUES ('','$posl','$acctPayable','$project','${itemCode.$i}','${porderQty.$i}','${rate.$i}', '$vid','0','${qref.$i}','${deliveryDetails.$i}','$d','$todat')";
	 //echo "<br>** $sqlp **<br>";
	 //else echo "<br>t$i=".${t.$i};
	$sqlrunp= mysql_query($sqlp);
	$poid = mysql_insert_id();

		 $fd=strtotime($d)+${porderDay.$i}*86400-1;
		 $fd=date('Y-m-d',$fd);
		 $sqls = "INSERT INTO poschedule(pos, poid, sdate, qty) VALUES ('','$poid', '$fd', '${porderQty.$i}')";
		$sqlrunp= mysql_query($sqls);
		//echo '<br>--'.$sqls;

	  }//if
	}//for
	if($posl){
		$condition=$ch1.'_'.$ch2.'_'.$ch3.'_'.$ch4.'_'.$ch5.'_'.$ch6.'_'.$ch7.'_'.$ch8.'_'.$ch9.'_'.$ch10.'_'.$ch11.'_'.$ch12.'_'.$ch13.'_'.
		$ch14.'_'.$ch15.'_'.$ch16.'_'.$ch17.'_'.$ch18.'_'.$ch19.'_'.$ch20.'_'.$ch21.'_'.$ch22.'_'.
		$tch51.'_'.$tch81.'_'.$tch82.'_'.$tch111.'_'.$tch112.'_'.$tch121.'_'.$tch122.'_'.$tch131.'_'.$tch141.'_'.$tch151;

	   	$sql="INSERT INTO pcondition(id, posl, condition,extra) VALUES('', '$posl','$condition','$extra')";
		//echo '<br>++ '.$sql.' ++</br>';
		$sqlQ=mysql_query($sql);
		}

	if($posl){
	$sqlpo = "INSERT INTO popayments(popID, posl, acctPayable,totalAmount,receiveAmount, paidAmount) VALUES ('','$posl','$acctPayable','$totalAmount','','')";
	//echo $sqlpo;
	$sqlQuerypo = mysql_query($sqlpo);
	}

}

?>

<form name="purchaseOrder" action="./index.php?keyword=eqpurchase+Order&vid=<? echo $vid;?>&project=<? echo $project;?>&itemCode=<? echo $itemCode;?>"  method="post">

  <table align="center" width="95%" border="1" bordercolor="#CCCCFF" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
    <tr bgcolor="#CCCCFF">
	<td colspan="3">Accounts payable: <? echo selectAlist('acctPayable','10',$acctPayable);?></td>

        <? $posl=posl($project,$vid,2); //$posl='p'.$vid.'_000001';?>
         <input type="hidden" name="posl" value="<? echo $posl;?>">

      <td align="right" colspan="5" height="30" >purchase order</font> for <? echo myprojectName($project);?></td>
    </tr>
	<tr>
	  <td colspan="8">

	 <? include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 
$vendor = "SELECT * from `vendor` WHERE vid=$vid";
//echo $vendor;
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
      <td colspan="8" height="5" bgcolor="#CCCCFF"></td>
    </tr>
    <tr>
      <th >Item Code</th>
      <th>Description</th>
      <th>Rate</th>
      <th >Quantity</th>
      <th >Duration</th>	  
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
	 

//new rule by suvro 13 january 14
 //if($vid==85)$sqlp = "SELECT itemCode,salvageValue,life,days,hours,MAX(((((price-salvageValue)/life)/days)*3)/30) as rate from  `equipment` GROUP by itemCode order by itemCode ASC";
          
 if($vid==85)$sqlp = "SELECT itemCode,salvageValue,life,days,hours,MAX(((((price-salvageValue)/life)/days)*6)/30) as rate from  `equipment` GROUP by itemCode order by itemCode ASC";

else
$sqlp = "SELECT * from  `quotation` WHERE vid=$vid and pCode IN ('$project' ,'000') AND valid>'$todat' order by itemCode ASC";
//echo $sqlp;
$sqlrunp= mysql_query($sqlp);
$i=1;
$totalAmount=0;
 while($typel1= mysql_fetch_array($sqlrunp))
{
$temp=itemDes($typel1[itemCode]);
$order=orderQty($project,$typel1[itemCode]); $totalQty = totaldmaQty($project,$typel1[itemCode]); $ex= $totalQty-$order;
if($ex>0){
$sql="SELECT SUM(dmaQty) as dmaTotal from dma WHERE  dmaProjectCode='$project' AND dmaItemCode = '".$typel1[itemCode]."'";
$sqlrunq= mysql_query($sql);
$row=mysql_fetch_array($sqlrunq);
$approv=$row[dmaTotal];

$totalPO=emporderQty($_GET[project],$typel1[itemCode]);
$total=$approv-$totalPO;


?>
    <tr>
      <td align="center"><? echo $typel1[itemCode]?> <input type="hidden" name="itemCode<? echo $i;?>" value="<? echo $typel1[itemCode]?>">
	    <input type="hidden" name="deliveryDetails<? echo $i;?>" value="<?  echo $typel1[delivery].' '.myprojectName($typel1[deliveryLoc]).' '.$typel1[sDetail] ;?>">
      </td>
      <td>
        <?  echo $temp[des].' ,'.$temp[spc];?>
      </td>
      <td align="right">
	  <?  /*if($vid=='85')$rentRate= rentRate($typel1[rate],$typel1[salvageValue],$typel1[life],$typel1[days],$typel1[hours]);
	      else $rentRate=$typel1[rate];
		  */
	  echo number_format($typel1[rate],2);
	  ?>
	  <input type="hidden" name="rate<? echo $i;?>" value="<? echo $typel1[rate];?>">
      </td>
      <!--<td width="100"><input type="text" name="porderQty<? echo $i;?>" value="<? echo ${porderQty.$i};?>" style="text-align:right" size="3" maxlength="3" width="4"
	   onBlur="if(<? echo 'porderQty'.$i;?>.value > <? echo $ex;?> || <? echo 'porderQty'.$i;?>.value < 0 ) {alert('Purchase Order quantity exceeding Estimated Quantity is not acceptable.'); <? echo 'porderQty'.$i;?>.value=0;}">-->
	   
		<td width="116"><? if($total>0){?><input type="text"  name="porderQty<? echo $i;?>" value="<? echo ${porderQty.$i};?>" style="text-align:right" size="3" maxlength="3" width="4" >

        <?  echo $temp[unit];?>
		}
      </td>
	<!--  <td ><input name="porderDay<? echo $i;?>" type="text" value="<? echo ${porderDay.$i};?>" size="3" maxlength="3" width="4"> Days</td>--> 
	
	<td ><input name="porderDay<? echo $i;?>" type="text" value="<? echo ${porderDay.$i};?>" size="3" maxlength="3" width="4" onBlur="duration=<? echo 'porderDay'.$i;?>.value; qty=<? echo 'porderQty'.$i;?>.value; tot=duration*qty*8; if(tot><? echo $total;?>) {  alert('Purchase Order quantity exceeding Estimated Quantity is not acceptable.\nEstimated quantity is: <? echo $total;?>\nNew Purchase order quantity(Qty*Duration*8) is: '+ tot); <? echo 'porderDay'.$i;?>.value=0; <? echo 'porderQty'.$i;?>.value=0;}"> Days</td>
	  
      <td align="right"><? echo number_format(round($typel1[rate]*${porderQty.$i}*${porderDay.$i}),2);
	  
	  ?></td>
      <td align="center"><? echo $typel1[qRef]?>
	   <input type="hidden" name="qref<? echo $i;?>" value="<? echo $typel1[qRef]?>">
	  </td>
    </tr>
	<?  } //if Ex?>
    <input type="hidden" name="n" value="<? echo $i;?>">
    <?

 $totalAmount+=round($typel1[rate]*${porderQty.$i}*${porderDay.$i});
 $i++;
} //while

}//if?>
    <tr>
      <td colspan="4" style="border-color=#FFFFFF" align="center"> <input type="submit"  value="Calculate" name="calculate"></td>
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
  <th width="50%" >Date</th>
</tr>


<?

if($vid){
include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 


if($vid==85)$sqlp = "SELECT itemCode, price as rate from  `equipment` GROUP by itemCode order by itemCode ASC";
else
$sqlp = "SELECT * from  `quotation` WHERE vid=$vid and pCode IN ('$project' ,'000') AND valid>'$todat' order by itemCode ASC";
//echo $sqlp;
$sqlrunp= mysql_query($sqlp);
 $j=1;
 while($typel1= mysql_fetch_array($sqlrunp))
{
$temp=itemDes($typel1[itemCode]);


if(${porderQty.$j}){
?>
<tr>
  <td ><? $temp=itemDes($typel1[itemCode]); echo $temp[des].' ,'.$temp[spc];?>
  <br>Delivery Details: <?  echo $typel1[delivery].' '.myprojectName($typel1[deliveryLoc]).' '.$typel1[sDetail] ;?>
  <br><br> 
  </td>
  <td align="center">
  Receive date from vendor <input type="text" name="dstart_<? echo $j;?>" size="10">
  <a id="anchor_<? echo $j;?>" href="#"
   onClick="cal.select(document.forms['purchaseOrder'].dstart_<? echo $j;?>,'anchor_<? echo $j;?>','dd/MM/yyyy'); return false;"
   name="anchor_<? echo $j;?>" ><img src="./images/b_calendar.png" alt="calender" border="0"></a>
  </td>
</tr>
<tr><td height="5" bgcolor="#0099FF" colspan="3"></td></tr>
<? }
$j++;
} //while
}//if
?>
<tr><td colspan="3"><? include('eqcondition.php');?></td></tr>
<tr><td colspan="3"><input type="submit" name="save" value="Save"></td></tr>
<? }//Calculate?>
</table>
</form>

<div id=testdiv1
      style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
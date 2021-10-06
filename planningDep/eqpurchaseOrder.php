<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
<?
 $dmaTotal=$_GET[dmaTotal];
 $poTotal=$_GET[poTotal];

if($save){

$format="Y-m-j";

//echo "N: $n";
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
$activeDate1=formatDate($activeDate,$format);
	if($posl){
		$condition=$ch1.'_'.$ch2.'_'.$ch3.'_'.$ch4.'_'.$ch5.'_'.$ch6.'_'.$ch7.'_'.$ch8.'_'.$ch9.'_'.
		$ch10.'_'.$ch11.'_'.$ch12.'_'.$ch13.'_'.$ch14.'_'.
		$ch15.'_'.$ch16.'_'.$tch6.'_'.$tch13.'_'.$ch25.'_'.$tch251.'_'.$ch26.'_'.$ch27.'_'.
		$ch28.'_'.$ch29.'_'.$ch23.'_'.$ch24.'_'.$tch141.'_'.$tch142;

	    $sql="INSERT INTO pconditiontemp(id, posl,`condition`,extra,extra1,extra2,extra3,extra4)".
		" VALUES('', '$posl','$condition','$extra','$extra1','$extra2','$extra3','$extra4')";

// 		echo '<br>++ '.$sql.' ++</br>';
		$sqlQ=mysqli_query($db, $sql);
		$r=mysqli_affected_rows($db);
	}
if($r>=0){
	for($i=1;$i<=$n;$i++)
	{
	  //echo
	 if(${porderQty.$i}>0)
	 {
	 $d=formatDate(${dstart.'_'.$i},$format);
	   $sqlp="INSERT INTO pordertemp (poid, posl, poacc,location, itemCode, qty, rate,vid,status,qref,deliveryDetails,dstart,activeDate,dat,potype,cc)". 
	  " VALUES ('','$posl','$acctPayable','$project','${itemCode.$i}','${porderQty.$i}','${rate.$i}', '$vid','-1','${qref.$i}','${deliveryDetails.$i}','$d','$activeDate1','$todat','2','$cc')";
// 	 echo "<br>** $sqlp **<br>";
	// exit;
	 //else echo "<br>t$i=".${t.$i};
	$sqlrunp= mysqli_query($db, $sqlp);
	$poid = mysqli_insert_id($db);

		 $fd=strtotime($d)+${porderDay.$i}*86400-1;
		 $fd=date('Y-m-d',$fd);
		  $sqls = "INSERT INTO poscheduletemp(pos, posl,itemCode, sdate, qty)".
		 " VALUES ('','$posl','${itemCode.$i}' ,'$fd', '${porderQty.$i}')";
		$sqlrunp= mysqli_query($db, $sqls);
// 		echo '<br>--'.$sqls;

	  }//if
	}//for

	if($posl){
	 $sqlpo = "INSERT INTO popaymentstemp(popID, posl, acctPayable,totalAmount,receiveAmount, paidAmount)".
	" VALUES ('','$posl','$acctPayable','$totalAmount','','')";
	//echo $sqlpo;
	$sqlQuerypo = mysqli_query($db, $sqlpo);
	}
    }
}

?>

<form name="purchaseOrder" action="./index.php?keyword=eqpurchase+Order&vid=<? echo $vid;?>&project=<? echo $project;?>&itemCode=<? echo $itemCode;?>"  method="post">

  <table align="center" width="95%" border="1" bordercolor="#CCCCFF" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
    <tr bgcolor="#CCCCFF">
	<td colspan="3">
        <? $posl=posl($project,$vid,2); echo $posl.'<br>';?>
         <input type="hidden" name="posl" value="<? echo $posl;?>">
	
	Accounts payable: <? echo selectAlist('acctPayable','10',$acctPayable);?>
	<br>Purchase Order Release date: <input type="text" name="activeDate" size="10" value="<? echo $activeDate;?>">
  <a id="anchor" href="#"
   onClick="cal.select(document.forms['purchaseOrder'].activeDate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a>
				<div style="display: inline-block;   padding-left: 20px;">				
					Credit Purchase: <input type="radio" name="cc" value=1 checked>
					Cash Purchase: <input type="radio" name="cc" value=2>
				</div><br>
	</td>
      <td align="right" colspan="5" height="30" >purchase order</font> for <? echo myprojectName($project);?></td>
    </tr>
	<tr>
	  <td colspan="8">
<?
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);	 
$vendor = "SELECT * from `vendor` WHERE vid=$vid";
//echo $sqlp;
$sqlr= mysqli_query($db, $vendor);
$vendor = mysqli_fetch_array($sqlr);
?>
	  <table align="center" width="95%"   border="2" bordercolor="#E8E8E8" cellspacing="0" cellpadding="3" style="border-collapse:collapse">
 <TR bgcolor="#EEEEEE">
		  <TD width="50%">Vendore Name:<b> <? echo $vendor[vname];?></b></TD>
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
  <TD>Quality Image: <font class="out"><? echo vendorRating($vendor[quality],2);?></font></TD>
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
      <td colspan="8" height="5" bgcolor="#CCCCFF"></td>
    </tr>
    <tr>
      <th width="206" >Item Code</th>
      <th width="377">Description</th>

      <th width="124">Rate</th>
      <th >Quantity</th>
      <th width="116" >Duration</th>	  
	  <th width="107">Amount</th>

      <th width="207">Quotation Ref.</th>

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
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 
	
$sql="SELECT dmaItemCode,dmaProjectCode,SUM(dmaQty) as dmaTotal from dma WHERE  dmaProjectCode='$project' ";
//old rule has been changed by suvro 13_january 14



//if($vid==85)$sqlp = "SELECT itemCode,salvageValue,life,days,hours,MAX((((price-salvageValue)/life)/365)*days) as rate from  `equipment` GROUP by itemCode order by itemCode ASC";
if($vid==85)$sqlp = "SELECT itemCode,salvageValue,life,days,hours,MAX((((((price-salvageValue)/life)/12)*days)/240)*hours) as rate from `equipment` GROUP by itemCode order by itemCode ASC"; /* Month column called days in database.*/
else
$sqlp = "SELECT quotation.*,itemlist.* from `quotation`, itemlist WHERE vid=$vid AND quotation.itemCode= itemlist.itemCode and quotation.pCode IN ('$project' ,'000') AND quotation.valid>'$todat' order by quotation.itemCode ASC";
// echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
$i=1;
 //$j=1;
$totalAmount=0;
 while($typel1= mysqli_fetch_array($sqlrunp))
{
	 
$temp=itemDes($typel1[itemCode]);
$order=orderQty($project,$typel1[itemCode]);
$totalQty=totaldmaQty($project,$typel1[itemCode]);

if(totaldmaQty($project,$itemCode)<=0){echo "<h1>Quantity not found</h1>";exit;}

$ex= $totalQty-$order;
	//$j++;
if($ex>0){
$sql_2="SELECT SUM(dmaQty) as dmaTotal from dma WHERE  dmaProjectCode='$project' AND dmaItemCode = '".$typel1[itemCode]."'";

$sql="SELECT dmaItemCode,dmaRate,dmaDate from dma WHERE  dmaProjectCode='$project' AND dmaItemCode = '".$typel1[itemCode]."' ORDER BY  `dma`.`dmaDate` DESC ";

$sqlrunq= mysqli_query($db, $sql);
$row=mysqli_fetch_array($sqlrunq);
 $temp=itemDes($row[dmaItemCode]);
  $ii=explode("-",$row[dmaItemCode]);

  $sqlrunq_2= mysqli_query($db, $sql_2);
$row_2=mysqli_fetch_array($sqlrunq_2);

$row[dmaTotal]=$row_2[dmaTotal];
   
	if($ii[0]>=35 AND $ii[0]<99) {$unit='Day.';}
	 else {$unit=$temp[unit];}

$approv=$row[dmaTotal];
$dmarate=$row[dmaRate]*8;
$totalPO=eqorderQty($_GET[project],$typel1[itemCode]);
$total=$approv-$totalPO;
$dmatotalrate=$dmarate*$approv;

?>
    <tr>
      <td align="center"><? echo $typel1[itemCode]; //print " ". $approv." ".$totalPO;?>  <input type="hidden" name="itemCode<? echo $i;?>" value="<? echo $typel1[itemCode]?>">
	    <input type="hidden" name="deliveryDetails<? echo $i;?>" value="<?  echo $typel1[delivery].' '.myprojectName($typel1[deliveryLoc]).' '.$typel1[sDetail] ;?>">
      </td>
      <td>
        <?  echo $temp[des].' ,'.$temp[spc];?>
      </td>
	

      <td align="right">
	  <? 
		  echo "Quotation Rate is: <strong>";
	
	
// 	if($vid=='85')$rentRate=$typel1[rate]= rentRate($typel1[price],$typel1[salvageValue],$typel1[life],$typel1[days],$typel1[hours]);
// 	      else $rentRate=$typel1[rate];
		  
	
	  echo number_format($typel1[rate],2);echo '/'.$typel1[itemUnit];
	  print "</strong>";
	  print "<br><font color='#FF0000'>IOW Approved Rate is: <strong>";
	  print number_format($dmarate,2).'/'.$unit;
	  print "</strong></font>";
	  ?>
	  <input type="hidden" name="rate<? echo $i;?>" value="<? echo round($typel1[rate],2);?>">
      </td>
	 
      <td width="116"> 
      <input type="text" name="porderQty<? echo $i;?>" value="<? echo ${porderQty.$i};?>" style="text-align:right" size="3" maxlength="3" width="4"
	   onblur="if(<? echo 'porderQty'.$i;?>.value &gt; <? echo $ex;?> || <? echo 'porderQty'.$i;?>.value &lt; 0 ) {alert('Purchase Order quantity exceeding Estimated Quantity is not acceptable.'); <? echo 'porderQty'.$i;?>.value=0;}" />
      <?  echo $temp[unit];?>

	  <!--<? if(($total>0) AND ($dmarate>=$typel1[rate])){?><input type="text"  name="porderQty<? echo $i;?>" value="<? echo ${porderQty.$i};?>" style="text-align:right" size="3" maxlength="3" width="4" >
        <?  echo $temp[unit];
		}
		?>-->
<!--<? $sdate=${dstart.$i};$edate=strtotime($sdate)+${porderDay.$i}*86400-1; $dd=1+(strtotime($edate)-strtotime($sdate))/86400; print $date; ?>-->
     </td>
	  <td >
	  
	  <!--<? if(($total>0) AND ($dmarate>=$typel1[rate])){?><input name="porderDay<? echo $i;?>" type="text" value="<? echo ${porderDay.$i};?>" size="3" maxlength="3" width="4" onBlur="duration=<? echo 'porderDay'.$i;?>.value; qty=<? echo 'porderQty'.$i;?>.value; rate=<? echo 'rate'.$i;?>.value;tot=duration*qty*8; totalrate=rate*duration*qty; if(tot><? echo $total;?> ||totalrate><? echo $dmatotalrate; ?>) {  alert('Purchase Order quantity exceeding Estimated Quantity is not acceptable.\nEstimated quantity is: <? echo $total;?>\nNew Purchase order quantity(Qty*Duration*8) is: '+ tot); <? echo 'porderDay'.$i;?>.value=0; <? echo 'porderQty'.$i;?>.value=0;}"> Days <? } ?> 
     -->
      <input name="porderDay<? echo $i;?>" type="text" value="<? echo ${porderDay.$i};?>" size="3" maxlength="3" width="4" />
Days</td>

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
      <td colspan="4" style="border-color=#FFFFFF" align="center"> 	   <input type="button"  value="Calculate" name="calculate1" onClick="calculate.value=1; purchaseOrder.submit();">
	   <input type="hidden"  value="0" name="calculate">	   

	  </td>
      <td colspan="2" align="right" bgcolor="#FFFF00">Total: Tk.<? echo number_format($totalAmount,2);?>
	   <input type="hidden" name="totalAmount" value="<? echo $totalAmount;?>">
	  </td>
    </tr>
  </table>
<br><br><br>
<? if($calculate){?>
<table align="center" width="95%" border="1" bordercolor="#0099FF" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
<tr>
  <th align="left">Item</th>
  <th width="50%" >Date</th>

</tr>


<?

if($vid){
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 


if($vid==85)$sqlp = "SELECT itemCode, price as rate from  `equipment` GROUP by itemCode order by itemCode ASC";
else
$sqlp = "SELECT * from  `quotation` WHERE vid=$vid and pCode IN ('$project' ,'000') AND valid>'$todat' order by itemCode ASC";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
 $j=1;
 while($typel1= mysqli_fetch_array($sqlrunp))
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
<tr><td colspan="3">	  <input type="button" name="save1" value="Save PO" onClick="save.value=1; purchaseOrder.submit();">
	  <input type="hidden" name="save" value="0">	  
</td></tr>
<? }//Calculate?>
</table>
</form>

<div id=testdiv1
      style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
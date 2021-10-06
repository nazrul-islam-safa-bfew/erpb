<?
$temp= explode('_',$posl);
$project=$temp[1];
$vid=$temp[3];
include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

$sqlp = "SELECT * from  `porder` WHERE posl='$posl'";
// echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
$fsql=mysqli_fetch_array($sqlrunp);
$podate=mydate($fsql[activeDate]);

   if($temp[0]=='PO'){
?>
<table width="98%" align="center" cellspacing="0"  >
<tr>
 <td>
 
  <table align="left" width="98%" border="0" bordercolor="#000000" bgcolor="#FFFFEE" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
    <tr bgcolor="#FFFFCC"> 
      <td align="left" height="30" > SL: <? echo viewPosl($posl);?> </td>
      <td align="right"> <?  echo $podate;// putenv ('TZ=Asia/Dacca');  echo date("F d, Y.");?> </td>	  
    </tr>
	<tr><td colspan="2" ><br><br></td></tr>
<?
$vendor = "SELECT * from `vendor` WHERE vid=$vid";
// echo $sqlp;
$sqlr=mysqli_query($db, $vendor);
$vendor = mysqli_fetch_array($sqlr);
?>
 <TR>
  <TD colspan="2"><b> <? echo $vendor[vname];?></b></TD>
 </TR>
 <TR >
  <TD colspan="2"><? echo $vendor[address];?></TD>
 </TR>
 <TR>
  <TD colspan="2"><br><br>Subject: <b>Work Order for Supply of Material at <? echo myprojectName($project);?></b><br><br>
  </TD>  
 </TR>
	  
</table>
 </td>
 </tr>
 <tr>
  <td>
  <table align="left" width="98%" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
    <tr> 
	 		<th>Item No</th>
      <th>BFEW's Store Code</th>
      <th>Description</th>
      <th>Quantity</th>
      <th>Unit</th>
      <th>Rate</th>
			<th>Reference</th>
    </tr>
    <? 
if($vid){

include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT * from  `porder` WHERE posl='$posl'";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

$i=1;
while($typel1= mysqli_fetch_array($sqlrunp)){
if($typel1[itemCode]>='99-00-000')$type=3;
$status=$typel1[status];
$temp=itemDes($typel1[itemCode]);
?>
    <tr> 
	   	<td align="center"><? echo $i;?>.</td>
      <td align="center"><a href="./index.php?keyword=purchase+order+vendor&project=<? echo $project;?>&itemCode=<? echo $typel1[itemCode];?>" target="_blank" title="View All Related vendor"><? echo $typel1[itemCode];?></a> </td>
      <td><? echo $temp[des].', '.$temp[spc];?></td>
      <td align="right">  <a href="./planningDep/dailyRequirment.php?project=<? echo $typel1[location];?>&itemCode=<? echo $typel1[itemCode];?>" target="_blank">
	  <? echo number_format($typel1[qty],3);?></a> 	
	  </td>
      <td align="center"><?  echo $temp[unit];?> </td>	  
      <td align="right">Tk.<? echo number_format($typel1[rate],2)?>    </td>
      <td ><?  echo $typel1[qref];?> </td>	  	  
    </tr>
    <?
$i++;
} //while

}//if?>
	 </table>
  </td>
 </tr>

 <tr>
   <td>
   

  <table align="left" width="98%" border="0" bordercolor="#000000" bgcolor="F8F8F8" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
 <tr>
   <td align="center" colspan="2" bgcolor="#E4E4E4" height="30">Receiving Schedule</td>
 </tr>
 <? include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT * from  `porder` WHERE posl='$posl'";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

$totalAmount=0;
 while($typel1= mysqli_fetch_array($sqlrunp))
{
$temp=itemDes($typel1[itemCode]);
?>
    <tr> 
      <td align="left" bgcolor="#EEEEEE" colspan="2"><b><? echo "$typel1[itemCode] $temp[des] $temp[spc]";?> </b></td>
    </tr>
<? 
$dd=array();
$qt=array();
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp1 = "SELECT * from  `poschedule` WHERE poid=$typel1[poid] ORDER by sdate ASC";
//echo '-------'.$sqlp1.'----------';
$sqlrunp1= mysqli_query($db, $sqlp1);
$j=1;

$dd[0]=$typel1[dstart];

 while($typel2= mysqli_fetch_array($sqlrunp1))
{
$dd[$j]=$typel2[sdate];
$qt[$j]=$typel2[qty];
$j++;
} //
for($l=0,$m=1;$l<sizeof($qt);$l++,$m=$l+1){
?>	
    <tr>
	  <td> <? echo $m;?>. </td>
	  <td >Supply <b><? echo number_format($qt[$m]);?> </b><? echo $temp[unit]?> between <?	  
	  if($l==0) echo date("d-m-Y",strtotime($dd[0]));
	   else  echo date("d-m-Y",strtotime($dd[$l])+86400);?> to	   
	    <? echo date("d-m-Y",strtotime($dd[$m]));?></td>	  
	</tr> 
<?  } //for?>
 <tr>
 	<td > </td>
 	<td >Supply Details: <? echo $typel1[deliveryDetails];?></td>
</tr>	
 <tr>
   <td height="20"></td>
 </tr>

 <? } //while?>
 <tr>
   <td></td>
 </tr>
</table>
   </td>
 </tr>
 
 <tr>
  <td>
  <table align="left" width="98%" border="0" bordercolor="#000000" bgcolor="F8F8F8"  cellpadding="0" style="border-collapse:collapse">
 <tr>
   <td align="center" colspan="3" bgcolor="#E4E4E4" height="30">Invoice Schedule</td>
 </tr>
 <? include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT * from  `porder` WHERE posl='$posl'";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

$totalAmount=0;
$i;
$poids="'0'";
$i=1;
 while($typel1= mysqli_fetch_array($sqlrunp))
{ $poids = $poids.",'".$typel1[poid]."'";
$itemp[$i]=$typel1[itemCode];
$poidl[$i]=$typel1[poid];
$i++;
}



?>
<? 
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp1 = "SELECT distinct sdate from  `poschedule` WHERE poid in ($poids) AND invoice=1;";
//echo $sqlp1;
$sqlrunp1= mysqli_query($db, $sqlp1);
$j=1;
$dd=array();
$dd[0]=$typel1[dstart];

 while($typel2= mysqli_fetch_array($sqlrunp1))
{
$dd[$j]=$typel2[sdate];
$j++;
} //
?>
<? for($i=1;$i<sizeof($dd);$i++){?>
<tr>
<td>
 <? echo "Invoice $i:  Raise after supply completion ";?> 
 
 <? 
 for($k=1;$k<=sizeof($poidl);$k++){
// echo "**$poidl[$k]**";
 if(scheduleReceiveperInvoice($poidl[$k],$dd[$i])){
 $temp=itemDes($itemp[$k]);

/* echo ' '.scheduleReceiveperInvoice($poidl[$k],$dd[$i]).' '.$temp[unit].' ';
 echo $temp[des].', '.$temp[spc].', ';
 */
 echo ' '.scheduleReceiveperInvoice($poidl[$k],$dd[$i]).' '.$temp[unit].' of item '.$k.', ';
 }
 }
 ?>
</td>
</tr>
 <? }?>

	
 <? //} //while?>
 <tr>
   <td></td>
 </tr>
</table>
  
  </td>
 </tr>
 <tr>
   <td>
   <? if($type==3) include('sub_conditionp.php');  else  include('conditionp.php');  ?>
   
   </td>
 </tr> 
</table>
<? } else {?>
<table width="100%" align="center" cellspacing="0"  cellpadding="10">
<tr>
 <td>
 
  <table align="left" width="98%" border="0" bordercolor="#000000" bgcolor="#FFFFEE" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
    <tr bgcolor="#FFFFCC"> 
      <td align="left" height="30" > Purchase Order No.: <? echo viewPosl($posl);?> </td>
      <td align="right"> <?  echo $podate;//echo date("F d, Y.");?> </td>	  
    </tr>
	<tr>	  <td colspan="2" height="10" > </td>	  </tr>
	 <? include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$vendor = "SELECT * from `vendor` WHERE vid=$vid";
//echo $sqlp;
$sqlr= mysqli_query($db, $vendor);
$vendor = mysqli_fetch_array($sqlr);
?>
 <TR >
  <TD colspan="2"><b> <? echo $vendor[vname];?></b></TD>
 </TR>
 <TR >
  <TD colspan="2"><? echo $vendor[address];?></TD>
 </TR>
 <TR>
  <TD colspan="2"><br><br>Subject: <b>Work Order for Supply of Equipment at <? echo myprojectName($project);?></b><br><br>
  </TD>  
 </TR>
	  
</table>
 </td>
 </tr>
 <tr>
  <td>
  <table align="left" width="98%" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
    <tr> 
	  <th>SL.#</th>
      <th>BFEW's Store Code</th>
      <th>Description</th>
      <th>Quantity</th>	  
      <th>Duration</th>	  
      <th>Unit Rate</th>
    </tr>
    <? 
if($vid){

include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT * from  `porder` WHERE posl='$posl'";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

$i=1;
 while($typel1= mysqli_fetch_array($sqlrunp))
{
$sdate = $typel1[dstart];
$status=$typel1[status];
$temp=itemDes($typel1[itemCode]);
?>
<? 
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp1 = "SELECT * from  `poschedule` WHERE poid=$typel1[poid]";
//echo $sqlp;
$sqlrunp1= mysqli_query($db, $sqlp1);
$typel2= mysqli_fetch_array($sqlrunp1);
$edate = $typel2[sdate];
$itemDes[$i]=$temp[des];
$deliveryDetails[$i]=$typel1[deliveryDetails];
$dstart[$i]=$typel1[dstart];
$qty[$i]=$typel1[qty];
$itemUnit[$i]=$temp[unit];
 ?>

    <tr> 
	   <td align="center"><? echo $i;?>.</td>
      <td align="center"><a href="./index.php?keyword=purchase+order+vendor&project=<? echo $project;?>&itemCode=<? echo $typel1[itemCode];?>" target="_blank" title="View All Related vendor"><? echo $typel1[itemCode];?></a> </td>
      <td>  <?  echo $temp[des];?>    </td>
          <td align="right"> <a href="./planningDep/eqdailyRequirment.php?project=<? echo $typel1[location];?>&itemCode=<? echo $typel1[itemCode];?>" target="_blank"> 
            <? echo number_format($typel1[qty],3);?> Nos</a> </td>
      <td align="right"><?  $duration =1+(strtotime($edate)-strtotime($sdate))/86400; echo round($duration); ?> days</td>	  
      <td align="right">Tk.<? echo number_format($typel1[rate],2)?> /nos/day   </td>
    </tr>
    <?
$i++;
} //while

}//if?>
	 </table>
  </td>
 </tr>

 <tr>
   <td>
   

  <table align="left" width="98%" border="0" bordercolor="#000000" bgcolor="F8F8F8" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
 <tr>
   <td align="center" colspan="2" bgcolor="#E4E4E4" height="30">Receiving Schedule</td>
 </tr>
 <? include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT * from  `porder` WHERE posl='$posl'";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

$totalAmount=0;
 while($typel1= mysqli_fetch_array($sqlrunp))
{
$temp=itemDes($typel1[itemCode]);
?>
    <tr> 
      <td align="left" bgcolor="#EEEEEE" colspan="2"><b><? echo "$typel1[itemCode] $temp[des] $temp[spc]";?> </b></td>
    </tr>
<? 
$dd=array();
$qt=array();
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp1 = "SELECT * from  `poschedule` WHERE poid=$typel1[poid] ORDER by sdate ASC";
//echo '-------'.$sqlp1.'----------';
$sqlrunp1= mysqli_query($db, $sqlp1);
$j=1;

$dd[0]=$typel1[dstart];

 while($typel2= mysqli_fetch_array($sqlrunp1))
{
$dd[$j]=$typel2[sdate];
$qt[$j]=$typel2[qty];
$j++;
} //
for($l=0,$m=1;$l<sizeof($qt);$l++,$m=$l+1){
?>	
    <tr>
	  <td> <? echo $m;?>. </td>
	  <td >Supply <b><? echo number_format($qt[$m]);?> </b><? echo $temp[unit]?> between <?	  
	  if($l==0) echo date("d-m-Y",strtotime($dd[0]));
	   else  echo date("d-m-Y",strtotime($dd[$l])+86400);?> to	   
	    <? echo date("d-m-Y",strtotime($dd[$m]));?></td>	  
	</tr> 
<?  } //for?>
 <tr>
 	<td > </td>
 	<td >Supply Details: <? echo $typel1[deliveryDetails];?></td>
</tr>	
 <tr>
   <td height="20"></td>
 </tr>

 <? } //while?>
 <tr>
   <td></td>
 </tr>
</table>
   </td>
 </tr>
 
 <tr>
  <td>
  <table align="left" width="98%" border="0" bordercolor="#000000" bgcolor="F8F8F8"  cellpadding="0" style="border-collapse:collapse">
 <tr>
   <td align="center" colspan="3" bgcolor="#E4E4E4" height="30">Invoice Schedule</td>
 </tr>
 <? include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT * from  `porder` WHERE posl='$posl'";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

$totalAmount=0;
$i;
$poids="'0'";
$i=1;
 while($typel1= mysqli_fetch_array($sqlrunp))
{ $poids = $poids.",'".$typel1[poid]."'";
$itemp[$i]=$typel1[itemCode];
$poidl[$i]=$typel1[poid];
$i++;
}



?>
<? 
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp1 = "SELECT distinct sdate from  `poschedule` WHERE poid in ($poids) AND invoice=1;";
//echo $sqlp1;
$sqlrunp1= mysqli_query($db, $sqlp1);
$j=1;
$dd=array();
$dd[0]=$typel1[dstart];

 while($typel2= mysqli_fetch_array($sqlrunp1))
{
$dd[$j]=$typel2[sdate];
$j++;
} //
?>
<? for($i=1;$i<sizeof($dd);$i++){?>
<tr>
<td>
 <? echo "Invoice $i:  Raise after supply completion ";?> 
 
 <? 
 for($k=1;$k<=sizeof($poidl);$k++){
// echo "**$poidl[$k]**";
 if(scheduleReceiveperInvoice($poidl[$k],$dd[$i])){
 $temp=itemDes($itemp[$k]);

/* echo ' '.scheduleReceiveperInvoice($poidl[$k],$dd[$i]).' '.$temp[unit].' ';
 echo $temp[des].', '.$temp[spc].', ';
 */
 echo ' '.scheduleReceiveperInvoice($poidl[$k],$dd[$i]).' '.$temp[unit].' of item '.$k.', ';
 }
 }
 ?>
</td>
</tr>
 <? }?>

	
 <? //} //while?>
 <tr>
   <td></td>
 </tr>
</table>
   </td>
 </tr>
 <tr>
   <td><?  include('eqconditionp.php');  ?>
   </td>
 </tr> 
</table>
<? }?>
<? if($status==0 AND $loginDesignation=='Managing Director'){?><input type="button" onClick="location.href='./planningDep/poapprovedSql.php?posl=<? echo $posl?>'" name="approved" value="Approved">
<? }?>
<? if($status==1){?><a href="./planningDep/printpurchaseOrder1.php?posl=<? echo $posl?>" target="_blank">Print</a><? }?>

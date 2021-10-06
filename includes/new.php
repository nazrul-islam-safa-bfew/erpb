<?php 

function voucherStatus($voucherStatus){
$voucherArray=array('-1'=>'Disapproved','Submitted','Approved','Paid');
return $voucherArray[$voucherStatus];
}
function isBooked($d,$t,$l){
if(strlen($t)<8){
	if($t<10) $t='0'.$t;
	$t=$t.":00:00";
}
$sql="SELECT id from batchdetails where scheduleDate='$d' and scheduleTime='$t' AND lab='$l'";
//echo "$sql<br>";
$sqlq=mysql_query($sql);
$num_rows = mysql_num_rows($sqlq);
$r=mysql_fetch_array($sqlq);
if($num_rows>0) return $r[id];
 else  return 0;
}

function batchId($id){
$sql="SELECT batchId from batchdetails where id='$id'";
//echo "$sql<br>";
$sqlq=mysql_query($sql);
$num_rows = mysql_num_rows($sqlq);
$r=mysql_fetch_array($sqlq);
if($num_rows>0) return $r[batchId];
 else  return 0;
}

function viewBatchName($id){
$sql="SELECT batchName from batch where id='$id'";
//echo "$sql<br>";
$sqlq=mysql_query($sql);
$r=mysql_fetch_array($sqlq);
 return $r[batchName];
}
function itemClass($itemCode)
{
 include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

$sqlff="SELECT  itemClass FROM itemlist where itemCode='$iteCode'";
//echo $sqlff;
$sqlf=mysql_query($sqlff);
$r=mysql_fetch_array($sqlf);
 return $r[itemClass];
}

function viewItemClass($itemClass){
$allItemClass=array('','Stock Item','Service Purchased','Labour-Waged','Employee-Salaried',
'','Assembly Item','Service Sell','','Training Coures');

return $allItemClass[$itemClass];
}
function completeJob($assemblyCode){
$completeJob=0;
$sql="SELECT SUM(assemblyQty) as totalQty from assembly where assemblyCode='$assemblyCode'";
//echo $sql;
$sqlq=mysql_query($sql);
$r=mysql_fetch_array($sqlq);
if($r[totalQty])$completeJob=$r[totalQty];

return $completeJob;
}

function remainJob($assemblyCode){
$reaminJob=0;
$sql="SELECT SUM(assemblyQty) as totalCompleteQty from assembly where assemblyCode='$assemblyCode'";
//echo $sql.'<br>';
$sqlq=mysql_query($sql);
$r=mysql_fetch_array($sqlq);
$totalCompleteQty=$r[totalCompleteQty];

$sql="SELECT SUM(qty) as totalSellQty 
from invoicedetail where sellItemCode='$assemblyCode'";
//echo $sql;
$sqlq=mysql_query($sql);
$r=mysql_fetch_array($sqlq);
$totalSellJob=$r[totalSellQty];

$remainJob=$totalCompleteQty-$totalSellJob;
 return $remainJob;
}


function materialonHandView($assemblyCode){
$qtybuild=4;
?>
<table border="1" width="500" bordercolor="#000000" style="border-collapse:collapse">
<tr>
 <th rowspan="2">sl</th>
 <th rowspan="2">ItemCode</th>
 <th colspan="2">Approved</th>
 <th colspan="2">Current</th> 
</tr>
<tr>
 <th>Qty</th> 
 <th>Rate</th>
 <th>Qty</th> 
 <th>Rate</th>

</tr>
<? 
echo "Qty to build=".$qtybuild.'<br>';
$assReq=array();
include("../config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 
$i=1;
$sql="SELECT * from dma where assemblyCode='$assemblyCode'";
echo "$sql<br>";
$sqlq=mysql_query($sql);
while($r=mysql_fetch_array($sqlq)){
$assReq[$i][0]=$r[dmaItemCode];
$assReq[$i][1]=$r[dmaItemDes];
$assReq[$i][2]=$r[dmaQty];
$assReq[$i][3]=$r[dmaRate];
$i++;
}
$assReqTemp=$assReq;
?>
<? 

for($i=1;$i<=sizeof($assReq);$i++){
${assHave.$assReq[$i][0]}=array();
$j=1;

	$sql2="SELECT * from store011 
	where itemCode='".$assReq[$i][0]."' AND currentQty>0 
	ORDER by rsid ASC";
	echo "<br>$sql2<br>";
	$sqlq2=mysql_query($sql2);

	while($r2=mysql_fetch_array($sqlq2)){
		${assHave.$assReq[$i][0]}[$j][0]=$r2[rsid];
		${assHave.$assReq[$i][0]}[$j][1]=$r2[itemCode];
		${assHave.$assReq[$i][0]}[$j][2]=$r2[currentQty];
		${assHave.$assReq[$i][0]}[$j][3]=$r2[rate];
		$j++;
	}//while
print_r(${assHave.$assReq[$i][0]}).'<br>';
}//for i
?>

<?
for($k=1;$k<=$qtybuild;$k++){
$assReqAmount=0;
$assHaveAmount=0;


$assReq=$assReqTemp;
?>
<tr><td colspan="6" bgcolor="#00FF00"><? echo "Assembly Item :$k";?></td></tr>
<?  for($i=1;$i<=sizeof($assReq);$i++){
$complete=0;
$check=0;
?>
 
<tr bgcolor="#FFFF00">
 <td><?php echo $i;?></td>
 <td><?php echo $assReq[$i][0];?></td>
 <td><?php echo $assReq[$i][2];?></td>
 <td><?php echo $assReq[$i][3];?></td>
 <td></td>
 <td></td>
</tr>
<? 
$assReqAmount+= $assReq[$i][2]*$assReq[$i][3];


 for($j=1;$j<=sizeof(${assHave.$assReq[$i][0]});$j++){
 if(${assHave.$assReq[$i][0]}[$j][2]<=0) continue;
 ?>
<tr>
 <td><? echo ${assHave.$assReq[$i][0]}[$j][0];?></td>
 <td><?php echo ${assHave.$assReq[$i][0]}[$j][1];?></td>
 <td></td>
 <td></td>
 <td><?php   echo ${assHave.$assReq[$i][0]}[$j][2].'==';
 if($assReq[$i][2]>${assHave.$assReq[$i][0]}[$j][2]) {
 $assReq[$i][2]-=${assHave.$assReq[$i][0]}[$j][2];
 $complete+=${assHave.$assReq[$i][0]}[$j][2];
 $assHaveAmount+=${assHave.$assReq[$i][0]}[$j][2]*${assHave.$assReq[$i][0]}[$j][3];
 ${assHave.$assReq[$i][0]}[$j][2]=0; 
 echo ${assHave.$assReq[$i][0]}[$j][2];
 echo "</td><td>".${assHave.$assReq[$i][0]}[$j][3]."</td>";
 }
 
  elseif($assReq[$i][2]<=${assHave.$assReq[$i][0]}[$j][2]){ 
  ${assHave.$assReq[$i][0]}[$j][2]-=$assReq[$i][2]; 
   $complete+=$assReq[$i][2];
   $assHaveAmount+=$assReq[$i][2]*${assHave.$assReq[$i][0]}[$j][3];
  echo ${assHave.$assReq[$i][0]}[$j][2];
  echo "</td><td>".${assHave.$assReq[$i][0]}[$j][3]."</td>";
  break;}   
   ?>
</tr>
<? }//for j?>
<? if($assReqTemp[$i][2]==$complete) $check=1;
 }//for i?>
<? if($check){?>
<tr bgcolor="#00CCFF">
<td  align="right"> <? echo "Done";?></td>
<td></td>
<td colspan="2" align="right"><? echo $assReqAmount;?></td>
<td colspan="2" align="right"><? echo $assHaveAmount;?></td>
</tr>
<? }else {?>
<tr bgcolor="#FF0000">
<td  colspan="6" > <? echo "Requirement is not available";?></td>
</tr>

<? break;}//else ?>
<? }//for k?>
<tr><td colspan="2"><input type="submit"  name="save" value="save"/></td></tr>
</table>


<? }
?>
<? 
function materialonHand($assemblyCode){
$qtybuild=4;
$completeQty=0;
//echo "Qty to build=".$qtybuild.'<br>';
$assReq=array();
include("../config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 
$i=1;
$sql="SELECT * from dma where assemblyCode='$assemblyCode'";
//echo "$sql<br>";
$sqlq=mysql_query($sql);
while($r=mysql_fetch_array($sqlq)){
$assReq[$i][0]=$r[dmaItemCode];
$assReq[$i][1]=$r[dmaItemDes];
$assReq[$i][2]=$r[dmaQty];
$assReq[$i][3]=$r[dmaRate];
$i++;
}
$assReqTemp=$assReq;

for($i=1;$i<=sizeof($assReq);$i++){
${assHave.$assReq[$i][0]}=array();
$j=1;

	$sql2="SELECT * from store011 
	where itemCode='".$assReq[$i][0]."' AND currentQty>0 
	ORDER by rsid ASC";
	//echo "<br>$sql2<br>";
	$sqlq2=mysql_query($sql2);

	while($r2=mysql_fetch_array($sqlq2)){
		${assHave.$assReq[$i][0]}[$j][0]=$r2[rsid];
		${assHave.$assReq[$i][0]}[$j][1]=$r2[itemCode];
		${assHave.$assReq[$i][0]}[$j][2]=$r2[currentQty];
		${assHave.$assReq[$i][0]}[$j][3]=$r2[rate];
		$j++;
	}//while
}//for i

for($k=1;$k<=$qtybuild;$k++){
$assReqAmount=0;
$assHaveAmount=0;


$assReq=$assReqTemp;

for($i=1;$i<=sizeof($assReq);$i++){
$complete=0;
$check=0;

$assReqAmount+= $assReq[$i][2]*$assReq[$i][3];
 for($j=1;$j<=sizeof(${assHave.$assReq[$i][0]});$j++){
 if(${assHave.$assReq[$i][0]}[$j][2]<=0) continue;
 if($assReq[$i][2]>${assHave.$assReq[$i][0]}[$j][2]) {
 $assReq[$i][2]-=${assHave.$assReq[$i][0]}[$j][2];
 $complete+=${assHave.$assReq[$i][0]}[$j][2];
 $assHaveAmount+=${assHave.$assReq[$i][0]}[$j][2]*${assHave.$assReq[$i][0]}[$j][3];
 ${assHave.$assReq[$i][0]}[$j][2]=0; 
 }
  elseif($assReq[$i][2]<=${assHave.$assReq[$i][0]}[$j][2]){ 
  ${assHave.$assReq[$i][0]}[$j][2]-=$assReq[$i][2]; 
   $complete+=$assReq[$i][2];
   $assHaveAmount+=$assReq[$i][2]*${assHave.$assReq[$i][0]}[$j][3];
  break;}   
 }//for j
 if($assReqTemp[$i][2]==$complete) {$check=1;}
 }//for i
 if($check){//echo "Done";  
 $completeQty++;} 
 else {//echo "Requirement is not available"; 
 break;}//else 
 }//for k
 
 return $completeQty;
 }
?>
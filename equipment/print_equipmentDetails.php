<?
include("../session.inc.php");
include("../config.inc.php");
include("../includes/myFunction.php");
include("../keys.php");
function assetDetails($des){
 $temp=explode('_',$des);
$model=$temp[0];
$brand=$temp[1];
$manuby=$temp[2];
$madein=$temp[3];
$speci=$temp[4];
$designCap=$temp[5];
$currentCap=$temp[6];
$yearManu=$temp[7];
 if($model) echo '<b>Model:</b> '.$model.'; ';
	if($brand) echo '<b>Brand </b>'.$brand.'; ';
    if($manuby) echo '<b>Manufactured by </b>'.$manuby.'; ';
 	if($madein) echo '<b>Made in </b>'.$madein.'; ';
	if($specin) echo '<b>Specification </b>' .$specin.'; ';
	if($designCap) echo '<b>Design Capacity </b>'.$designCap.'; '; 
	if($currentCap) echo '<b>Current Capacity </b>'.$currentCap.'; ';
	if($yearManu) echo '<b>Year of Manufacture  </b>'.$yearManu.'; '; 
} 
 ?>

<html>
 <head>
 <LINK href="../style/print.css" type=text/css rel=stylesheet>
<meta http-equiv="Content-Language" content="en-us">
<meta name="author" content="<? echo $mauthor;?>">
<meta name="copyright" content="<? echo $tt;?>">
<meta name="keywords" content="<? echo $kword;?>">
<META NAME="description" CONTENT="<? echo $des;?>">
<title>BFEW :: Print Purchase Order</title>
</head>
<body>

<table align="left" width="90%" border="1"  bordercolor="999999" cellpadding="2" cellspacing="0" style="border-collapse:collapse">
  <tr bgcolor="#EEEEEE">
    <td colspan="9" align="right" valign="top"><font class='englishhead'>equipment section status</font></td>
  </tr>
  <tr >
    <th align="center" width="10%" >Asset Id</th>
    <th align="center" width="20%" >Item Description</th>
    <th align="center" width="30%" >Asset Description</th>
    <th align="center" width="30%" >Rent Rate to BFEW</th>
    <th align="center" width="10%" >Location</th>
  </tr>
  <? include("../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
   $sql="SELECT equipment.* FROM equipment WHERE 1 ";
   $sql.=" ORDER by equipment.itemCode,equipment.assetId ASC";
//echo $sql;
$sqlquery=mysqli_query($db, $sql);
$i=0;
while($sqlresult=mysqli_fetch_array($sqlquery)){

$test = $sqlresult[itemCode];
if($test!=$testp and $i>0)
 echo "<tr bgcolor=#EEEEEE><td height=10 colspan=6 ></td></tr>";
?>
  <tr >
    <td align="center" width="10%" ><? echo eqpId($sqlresult[assetId],$sqlresult[itemCode]);?></td>
    <td width="20%" > 
      <? $temp = itemDes($sqlresult[itemCode]);  echo $temp[des].', '.$temp[spc]; ?>
    </td>
    <td  width="30%"><? echo assetDetails($sqlresult[teqSpec]);?></td>
    <td  align="left" abbr="30%">
	Price: Tk. <? echo number_format($sqlresult[price],2);?><br>
	Life: <? echo $sqlresult[life];?> years<br>
	S.Value: Tk. <? echo number_format($sqlresult[salvageValue],2);?><br>
	Overhead, Maintanance & Profit: <? echo '200%';?><br>	
	Expected Use per Year: <? echo $sqlresult[days];?> Month<br>
	Expected Use per Day: <? echo $sqlresult[hours];?> Hr.<br>	
	
	<? 
	$rentRate = rentRate($sqlresult[price],$sqlresult[salvageValue],$sqlresult[life],$sqlresult[days],$sqlresult[hours]);
	echo 'Rental Charge: Tk. '.$rentRate ?>/ day<br>
	<? echo 'Usage Cost: Tk. '.number_format($rentRate/$sqlresult[hours],2);?>/ Hour<br>
	</td>
    <td  width="10%" > <? echo myprojectName($sqlresult[location]);?>,<br> <? echo eqCondition($sqlresult[condition]);?></td>
    <?  echo "</tr>";
$testp= $test;
$i++;
}

?>
</table>
<input type="button" name="print"  value="Print" onClick="window.print()">
</body>
</html>

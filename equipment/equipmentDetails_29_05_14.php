<form name="store" action="index.php?keyword=equipment+Details&a=<? echo $a;?>" method="post">
<table align="center" width="500" class="vendorTable">
<tr class="vendorAlertHdt">
 <td colspan="2" align="right" valign="top">equipment store Search form</td>
</tr>
<tr><td>Item Code</td>
    <td >
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
 $plist.= ">$typel[itemCode]--$typel[itemDes]--$typel[itemSpec]</option>  ";
 }
 $plist.= '</select>';
 echo $plist;
 ?>
	
<!--	<input name="itemCode1" onKeyUp="return autoTab(this, 2, event);" size="2" maxlength="2" > - 
    <input name="itemCode2" onKeyUp="return autoTab(this, 2, event);" size="2" maxlength="2"> - 000
	-->
	</td>
</tr>

<tr ><td >Location</td>
<td><? 
$ex = array('Select one');
echo selectPlist('location',$ex,$location);?>	</td>
</tr>
<tr><td colspan="2" align="center" ><input type="submit" name="search" value="Search" class="vendorAlertHdt" ></td></tr>
</table>
</form>
	
<table align="center" width="95%" class="vendorTable">
<tr class="vendorAlertHdt">
 <td align="center" >Asset Id</td>
 <td width="500" align="center" >Asset Description</td> 
 <td width="500" align="center" >Hourly outputs experienced in BFEW</td>  
<? if($loginProject=='000' OR $loginProject=='002') echo  '<td align="center" >Rent Rate to BFEW</td>'; ?>
 <td width="176" align="center" >Location</td>   
 <td width="95"></td>
 <? //if(!$a){ echo "<th align='center' >Schedule</th>";     }?>
</tr>
<? include("./config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
   $sql="SELECT equipment.* FROM equipment WHERE 1 AND status !=9 ";
if($location AND $location!='Select one'){ $sql.=" AND equipment.location=$location";}

if($itemCode){ 
	$sql.=" AND equipment.itemCode LIKE '$itemCode'";
}
$sqlquery=mysqli_query($db, $sql);
$total_result=mysqli_affected_rows();
$total_per_page=50;

if($page<=0)
	{
	$page=1;
	}
$curr=($page-1)*$total_per_page;

$sql.=" ORDER by equipment.itemCode,equipment.assetId ASC LIMIT $curr,$total_per_page";
//echo $sql;
$sqlquery=mysqli_query($db, $sql);
$i=0;	
while($sqlresult=mysqli_fetch_array($sqlquery)){
$eqId = eqpId($sqlresult[assetId],$sqlresult[itemCode]);
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


<tr >
<td align="center" width="100" valign="top" >
<? if($a==0){?>
<a href="./index.php?keyword=equipment+entry&eqid=<? echo $sqlresult[eqid];?>&page=<? echo $page;?>"> <? echo $eqId ;?></a>
<!--<br><a href="./index.php?keyword=enter+eq+item+work&eqid=<? echo $sqlresult[eqid];?>&assetId=<? echo $eqId;?>"> IOW </a>-->
<? }
elseif($a==2){ ?>
<a href="./index.php?keyword=equipment+entry&r=1&eqid=<? echo $sqlresult[eqid];?>"> <? echo $eqId;?></a>
<? }
else{ echo  $eqId;}
?>


 <?  /*
 $temp = itemDes($sqlresult[itemCode]); 
 echo $temp[des].', '.$temp[spc];
 */
 ?></td> 
 <td >
 <? $temp=explode('_',$sqlresult[teqSpec]);
$model=$temp[0];
$brand=$temp[1];
$manuby=$temp[2];
$madein=$temp[3];
$speci=$temp[4];
$designCap=$temp[5];
$currentCap=$temp[6];
$yearManu=$temp[7];
?>

 <? if($model) echo 'Model <font class=out>'.$model.'</font>; ';
	if($brand) echo 'Brand <font class=out>'.$brand.'</font>; ';
    if($manuby) echo 'Manufactured by <font class=out>'.$manuby.'</font>; ';
 	if($madein) echo 'Made in <font class=out>'.$madein.'</font>; ';
	if($specin) echo 'Specification <font class=out>' .$specin.'</font>; ';
	if($designCap) echo 'Design Capacity <font class=out>'.$designCap.'</font>; '; 
	if($currentCap) echo 'Current Capacity <font class=out>'.$currentCap.'</font>; ';
	if($yearManu) echo 'Year of Manufacture  <font class=out>'.$yearManu.'</font>; '; 
  ?> 
 </td>
 <td align="center"><? echo $sqlresult[exp];?></td>
<? if($loginProject=='000' OR $loginProject=='002'){?>
    <td  align="right"><? echo rentRate($sqlresult[price],$sqlresult[salvageValue],$sqlresult[life],$sqlresult[days],$sqlresult[hours]);?>/ 
      day</td>
 <? }?>
 <td align="center"> <? echo myprojectName($sqlresult[location]);?>,<br> <? echo eqCondition($sqlresult[condition]);?></td>
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
if(!$a){ echo "<td><a href='./equipment/equipmentedit.php?eqid=$sqlresult[eqid]&d=2'> EDIT</a>
 
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
		$rootLink="./index.php?keyword=equipment+details";
        $link_on= "<a href='$rootLink&page={num}{appendSearch}'><b><font class=larg>{num}</larg></b></a>";
        $link_off= "<a href='$rootLink&page={num}{appendSearch}'>{num}</a>";
        $back= " <a href='$rootLink&page=1{appendSearch}'><<</a> ";
        $forward= " <a href='$rootLink&page={pages}{appendSearch}'>>></a> ";

        $myNavigation = New PageNavigation($totalResults, $resultsPerPage, $page, $startHTML, $appendSearch, $range, $link_on, $link_off, $back, $forward);

        echo $myNavigation->getHTML();

?>

<a href="./equipment/print_equipmentDetails.php" target="_blank" >Print</a>
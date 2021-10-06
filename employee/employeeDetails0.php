

<form name="store" action="index.php?keyword=employee+Details" method="post">
<table align="center" width="400" border="3"  bordercolor="CC9999" cellpadding="2" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td colspan="2" align="right" valign="top"><font class='englishhead'>human resource Search form</font></td>
</tr>
<tr><td>Item Code</td>
    <td >
<? 	include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT `*` from `itemlist` WHERE itemCode BETWEEN '74-00-000' AND '90-99-999'";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

$plist= "<select name='itemCode'> ";
$plist.= "<option value=''>Select One</option> ";

 while($typel= mysqli_fetch_array($sqlrunp))
{
 $plist.= "<option value='".$typel[itemCode]."'";
 if($itemCode==$typel[itemCode])  $plist.= " SELECTED";
 $plist.= ">$typel[itemCode]--$typel[itemDes]</option>  ";
 }
 $plist.= '</select>';
echo $plist;
 ?>
 	</td>
</tr>

<tr ><td >Location</td>
<td><? 
$ex = array('Select one');
echo selectPlist('location',$ex,'');?>	</td>
</tr>
<tr><td colspan="2" align="center" ><input type="submit" name="search" value="Search" class="store" ></td></tr>
</table>
</form>
	
<table align="center" width="95%" border="3"  bordercolor="CC9999" cellpadding="2" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td colspan="10" align="right" valign="top"><font class='englishhead'>human resource status</font></td>
</tr>
<tr >
 <th align="center"  >Name</th> 
 <th align="center" >Designation</th>
 <th align="center" >Employment Type</th> 
<?  if(!$b){?>
 <th align="center" >Salary/ month</th>    
 <? }?>
 <th align="center" >Location</th> 
</tr>
<? include("./config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
   $sql="SELECT * FROM employee WHERE 1 ";
if($b) $sql.=" AND  empId > '84-00-000'";  
if($location AND $location!='Select one'){ $sql.=" AND employee.location=$location";}

if($itemCode){ 
		$sql.=" AND employee.designation LIKE '$itemCode'";
}
$sql.=" ORDER by empId";
//echo $sql.'<br>';
$sqlquery=mysqli_query($db, $sql);
$i=0;	
while($sqlresult=mysqli_fetch_array($sqlquery)){
	?>
<? 
$temp = explode('-',$sqlresult[empId]);
$test =  $temp[0].'-'.$temp[1];
if($test!=$testp and $i>0)
 echo "<tr bgcolor=#EEEEEE><td height=10 colspan=5></td></tr>";
?>	

<tr >
<td align="center" >
<? if($a){ echo $sqlresult[name];} else {?>
<a href="./index.php?keyword=employee+entry&id=<? echo $sqlresult[id];?>"> <? echo $sqlresult[name];?></a>
<? }?>
<? echo '<br> ID: '.$sqlresult[empId];?>
<a href="./index.php?keyword=appraisal&id=<? echo $sqlresult[id];?>"> Appraisal</a>
</td>
 <td align="center"> <? 
 
 $temp1=hrName($sqlresult[empId]);
   echo $temp1[designation];
   
  $de=explode(',', $sqlresult[addJob]);
  if($sqlresult[addJob]) 
  {
  	for($l=0;$l<sizeof($de);$l++)  
	{ echo ';<br>'; $temp11=hrName($de[$l]); echo $temp11[designation];}
	 
  }//if
  
  ?></td> 
 <td align="center" ><? echo $sqlresult[pament];?></td>
 <?  if(!$b){?><td  align="right"><? echo number_format($sqlresult[salary],2);?></td> <? }?>
 <td align="center" ><? echo myprojectName($sqlresult[location]);?><br>
 <? if(!$a){?><a href="./employee/employeeSql.php?save=1&delete=1&id=<? echo $sqlresult[id];?>">Delete</a><? }?></td>
 
<? $i++;
 echo "</tr>";

$testp= $test;
}?>
</tr>

</table>
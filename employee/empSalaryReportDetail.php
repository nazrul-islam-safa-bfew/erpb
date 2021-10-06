<form name="employee">
  <select name='empId' size='1' onChange="location.href='index.php?keyword=empSalary+report+detail&empId='+employee.empId.options[document.employee.empId.selectedIndex].value";>
<? 
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT * from `employee` Where designation!='70-01-000' ORDER by designation ASC";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

while($typel= mysqli_fetch_array($sqlrunp)){
echo "<option value='".$typel[empId]."'";
 if($eqresult[designation]){$designation=$eqresult[designation];}

 if($empId==$typel[empId]) echo "SELECTED";
 echo ">".empId($typel[empId],$typel[designation])."--$typel[name]</option>  ";
}
 ?>
</select>
</form>

<? 
$sql="select * from empsalary where empId='$empId'";
// echo "$sql<br>";

$sqlq=mysqli_query($db, $sql);

?>
<table  align="center"width="90%" style="border-collapse:collapse">
<tr bgcolor="#ccc">
	<th><font class="englishheadSmall">month</font></th>
	<th><font class="englishheadSmall">Amount</font></th>
	<th><font class="englishheadSmall">payment date</font></th>
	<th><font class="englishheadSmall">payment SL</font></th>
</tr>
<?
	while($re=mysqli_fetch_array($sqlq)){
	?>
<tr>
<td ><? echo date('F,y',strtotime($re[month]));?></td>
<td align="right"><? echo number_format($re[amount],2);?></td>
<td align="center"><? echo myDate($re[pdate]);?></td>
<td align="center"><? echo $re[paymentSL];?></td>
</tr>
<tr bgcolor="#CCCCCC"><td colspan="4" height="1"></td></tr>
<? }?>
</table>
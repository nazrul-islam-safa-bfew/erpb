<?

 include("../includes/config.inc.php");
 include("../includes/empFunction.inc.php");
 
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
		
$iow=$_GET['iow'];	
$iowProjectCode=$_GET['iowProjectCode'];
	
//$sql="SELECT * from employee where location='$iowProjectCode' AND status='0'";	//stop by salma
$sql="SELECT * from employee where designation like '73-22-%' and location='$iowProjectCode' AND status='0'";
// echo "$sql<br>";
$sqlq=mysqli_query($db, $sql);

?>
<form name="sup" action="./assignSupervisor.sql.php?<? echo "iow=$iow"?>" method="post">
<table width="500" border="1" bordercolor="#000000" style="border-collapse:collapse" >

<tr bgcolor="#CCCCCC">
 <td colspan="2"> Assign Supervisor</td>
</tr>
<tr>
 <td>Select One</td>
 <td><select name="empId">
 <? while($re=mysqli_fetch_array($sqlq)){?>
 <option value="<? echo $re[empId];?>"><? echo empId($re[empId],$re[designation]).'-'. hrDesignation($re[designation]).'-'.$re[name];?></option>
 <? }?>
 </select></td>
</tr>
<tr><td colspan="2"><input type="submit" value="Save" /></td></tr>
</table>
</form>
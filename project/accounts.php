<table width="90%" border="1" cellspacing="0" cellpadding="0" >
<tr>
  <td>Central Accounts</td>
</tr>
<? include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sqlpur1="SELECT SUM(reqFund) as totalQty, reqpCode FROM requisition  GROUP BY  reqpCode";	
$sql=mysql_query($sqlpur1);
while($result=mysql_fetch_array($sql){?>
<tr>
 <td><? echo $result[reqpCode];?></td> <td><? echo $result[totalQty];?></td>
</tr> 	
<? }?>

</table>
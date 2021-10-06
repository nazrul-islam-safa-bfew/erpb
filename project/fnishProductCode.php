<table border="1" bordercolor="#000000" cellpadding="0" cellspacing="5">
<tr>
 <td>Finished Product Code </td>
 <td>Description</td>
</tr>

<? 
include("../config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sql1="SELECT * from itemlist where itemCode LIKE '98-%' ";
$sqlrunItem1= mysql_query($sql1);
while($sqlrun= mysql_fetch_array($sqlrunItem1)){?>
<tr>
 <td><? echo $sqlrun[itemCode];?> </td>
 <td><? echo $sqlrun[itemDes];?> </td>
</tr>
<? }//while?>
</table>
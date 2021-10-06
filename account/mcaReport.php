<table  class="blue" width="600" align="center">
 <tr>
   <td class="blueAlertHd" colspan="4">Report Chart of Accounts</td>
 </tr>
 <tr >
   <th class="blue">Account ID</th>
   <th class="blue">Account Description</th>   
   <th class="blue">Active?</th>   
   <th class="blue">Account Type</th>      
 </tr>
 <?
include("./config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sql = "SELECT * FROM accounts ORDER by accountID";
//echo $sql;
$sqlQuery = mysqli_query($db, $sql);

while($sqlResult=mysqli_fetch_array($sqlQuery)){?>
 <tr>
   <td align="center">
   <? if($_SESSION['loginDesignation']=="MIS Manager" or $_SESSION['loginDesignation'] == "MIS") 
   		{
   		echo $sqlResult[accountID];
		}
	else
		{
		?>
   <a href="./index.php?keyword=mca&ID=<? echo $sqlResult[ID];?>" ><? echo $sqlResult[accountID];?></a>
   <? } ?>
   </td>
   <td><? echo $sqlResult[description];?></td>
   <td align="center"><? if($sqlResult[active]) echo "Yes"; else echo 'No';?></td>
   <td><? echo accountType($sqlResult[accountType]);?></td>
 </tr>
<? }
?>
</table>
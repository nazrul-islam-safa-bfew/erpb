<?
include("./config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sql = "SELECT * FROM accounts WHERE ID='$ID'";
//echo $sql;
$sqlQuery = mysqli_query($db, $sql);
$sqlResult=mysqli_fetch_array($sqlQuery)?>

<form action="./account/mca.sql.php?ID=<? echo $ID;?>" name="mca" method="post">
<table  class="blue" width="500" align="center">
 <tr>
   <td class="blueAlertHd" colspan="2">Maintain Chart of Accounts</td>
 </tr>
 <tr>
   <td>Account ID</td>
   <td><input type="text" name="accountID" value="<? echo $sqlResult[accountID];?>"></td>
 </tr>
 <tr>
   <td>Description</td>
   <td><input type="text" name="description" size="45"value="<? echo $sqlResult[description];?>"></td>
 </tr>
 <tr>
   <td>Opening Balance</td>
   <td><input type="text" name="balance" size="10"value="<? echo $sqlResult[balance];?>"> 
   at Jan 01, 2013.</td>
 </tr>
 
 <tr>
   <td>Active</td>
   <td>
   <input type="radio" name="active" value="1" checked> Activie
   <input type="radio" name="active" value="0"> Inactivie
   </td>
 </tr>
 <tr>
   <td>Account Type</td>
   <td>
   <? 
    $cr= array(10,6,16,19,16,21,14,12);
   $dr= array(1,0,23,24,5,2,8,4);

   ?>
   <select name="accountType" size="1">
       <option value="10" <?  if($sqlResult[accountType]=='10') echo 'selected';?> >Accounts Payable</option>	   
       <option value="1" <?  if($sqlResult[accountType]=='1') echo 'selected';?>>Accounts Receivable</option>	   
       <option value="6" <?  if($sqlResult[accountType]=='6') echo 'selected';?>>Accmulated Depreciation</option>	   	   	   	   
       <option value="0" <?  if($sqlResult[accountType]=='0') echo 'selected';?>>Cash</option>
       <option value="3" <?  if($sqlResult[accountType]=='3') echo 'selected';?>>Bank</option>	   	   
       <option value="23" <?  if($sqlResult[accountType]=='23') echo 'selected';?>>Cost of Sales</option>	   
       <option value="16" <?  if($sqlResult[accountType]=='16') echo 'selected';?>>Equity-dosen't close</option>	   
       <option value="19" <?  if($sqlResult[accountType]=='19') echo 'selected';?>>Equity gets closed</option>	   
       <option value="18" <?  if($sqlResult[accountType]=='18') echo 'selected';?>>Equity-Retained Earnings</option>	   	   	   	   
       <option value="24" <?  if($sqlResult[accountType]=='24') echo 'selected';?>>Expenses</option>	   
       <option value="5" <?  if($sqlResult[accountType]=='5') echo 'selected';?>>Fixed Assets</option>	   
       <option value="21" <?  if($sqlResult[accountType]=='21') echo 'selected';?>>Income</option>	   	   	   	   
       <option value="2" <?  if($sqlResult[accountType]=='2') echo 'selected';?>>Inventory</option>	   
       <option value="14" <?  if($sqlResult[accountType]=='14') echo 'selected';?>>Long Term Liabilities</option>	   
       <option value="8" <?  if($sqlResult[accountType]=='8') echo 'selected';?>>Other Assets</option>	
       <option value="4" <?  if($sqlResult[accountType]=='4') echo 'selected';?>>Other Current Assets</option>	   
       <option value="12" <?  if($sqlResult[accountType]=='12') echo 'selected';?>>Other Current Liabilities</option>	   	   	   	   
   </select>
   </td>
 </tr>
 <tr>
 <? if($ID){?>
      <td colspan="2" align="center"><input type="submit" value="Update" name="update">
	  <input type="submit" value="Delete" name="delete">
	  </td>
   <? } else {?>
   <td colspan="2" align="center"><input type="submit" value="Save" name="save"></td>   
   <? }?>
 </tr> 
</table>
</form>

<a href="./index.php?keyword=mca+report"> Report</a>
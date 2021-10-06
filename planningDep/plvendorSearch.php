<form name="store" action="index.php?keyword=purchase+order+vendor" method="post">
<table   class="vendorTable" align="center"  width="400"   >
<tr >
 <td colspan="2" class="vendorAlertHd" >Vendor Search form</td>
</tr>

<tr >
      <td >Project</td>
<td>
<select name="project"> 
<option value="">ALL</option>
<?
include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

$sqlp = "SELECT `pcode`,pname from `project`";
//echo $sqlp;
$sqlrunp= mysql_query($sqlp);

 while($typel= mysql_fetch_array($sqlrunp))
{
 echo "<option value='".$typel[pcode]."'";
  if($project==$typel[pcode]) echo "SELECTED";
 echo ">$typel[pcode]--$typel[pname]</option>  ";
 }
?>

	 </select>
	</td>
</tr>
<tr >
      <td >Vendor</td>
<td>
<select name="vid"> 
<option value="">Select Vendor</option>
<?
include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

$sqlp = "SELECT vid, vname from `vendor`";
//echo $sqlp;
$sqlrunp= mysql_query($sqlp);

 while($typel= mysql_fetch_array($sqlrunp))
{
 echo "<option value='".$typel[vid]."'";
 if($vid==$typel[vid]) echo "SELECTED";
 echo ">$typel[vname]</option>  ";
 }
?>

	 </select>
	</td>
</tr>
<tr ><td width="40%">Item Code</td>
    <td  width="60%" >
	<input name="itemCode1" onKeyUp="return autoTab(this, 2, event);" size="2" maxlength="2" value="<? echo $itemCode1;?>" > - 
    <input name="itemCode2" onKeyUp="return autoTab(this, 2, event);" size="2" maxlength="2" value="<? echo $itemCode2;?>" > - 
    <input name="itemCode3" onKeyUp="return autoTab(this, 3, event);" size="3" maxlength="3" value="<? echo $itemCode3;?>" >
	</td>
</tr>

<tr><td colspan="2" align="center" ><input type="submit" name="search" value="Search" class="vendor" onMouseOver="this.className='vendorhov'" onMouseOut="this.className='vendor'"></td></tr>
</table>
</form>

<form name="search" action="./index.php?keyword=mdshow+all+requisition" method="post">
<table  align="center" width="600" border="1" bordercolor="#EEEEFF" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
 <tr bgcolor="#EEEEFF"><td colspan="3"  >SEARCH for 
<select name="pname"> <option value="">Select Project</option>
<?
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	 
$sqlp = "SELECT `pcode`,pname from `project`";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

 while($typel= mysqli_fetch_array($sqlrunp))
{
 echo "<option value='".$typel[pcode]."'";
 echo ">$typel[pcode]--$typel[pname]</option>  ";
 }
?>

	 </select>
	</td>
</tr>
 <tr>
 	<td width="31%">
	<input type="checkbox" name="cat1" value="" >ALL Items<br>
	<input type="checkbox" name="cat2" value="Forwarded to HO">Forwarded to HO<br>
	<input type="checkbox" name="cat4" value="Hold By Mngr. P&C">Hold By Mngr. P&C <br>
	</td>
	<td width="37%">
	<input type="checkbox" name="cat5" value="Approved By Mngr. P&C">Approved By Mngr. P&C <br>
	<input type="checkbox" name="cat6" value="Rejected By Mngr. P&C">Rejected By Mngr. P&C <br>
	<input type="checkbox" name="cat7" value="Forwarded to MD">Forwarded to MD
	</td>
	<td>
	<input type="checkbox" name="cat8" value="Approved by MD">Approved by MD<br>
	<input type="checkbox" name="cat9" value="Hold By MD">Hold By MD<br>
	<input type="checkbox" name="cat10" value="Rejected By MD">Rejected By MD
	</td>
	</tr>
	<tr>
	<td colspan="2">Requisition Submission Date:  
	<select name="dd">
	<option value="">day</option>
	<option value="01">1</option>
	<option value="02">2</option>
	<option value="03">3</option>
	<option value="04">4</option>
	<option value="05">5</option>
	<option value="06">6</option>
	<option value="07">7</option>
	<option value="08">8</option>
	<option value="09">9</option>
	<option value="10">10</option>
	<option value="11">11</option>
	<option value="12">12</option>
	<option value="13">13</option>
	<option value="14">14</option>
	<option value="15">15</option>
	<option value="16">16</option>
	<option value="17">17</option>
	<option value="18">18</option>
	<option value="19">19</option>
	<option value="20">20</option>
	<option value="21">21</option>
	<option value="22">22</option>
	<option value="23">23</option>
	<option value="24">24</option>
	<option value="25">25</option>
	<option value="26">26</option>
	<option value="27">27</option>
	<option value="28">28</option>
	<option value="29">29</option>
	<option value="30">30</option>
	<option value="31">31</option>
	</select>
	 <select name="mm">	<option value="">Month</option>
	<option value="01">1</option>
	<option value="02">2</option>
	<option value="03">3</option>
	<option value="04">4</option>
	<option value="05">5</option>
	<option value="06">6</option>
	<option value="07">7</option>
	<option value="08">8</option>
	<option value="09">9</option>
	<option value="10">10</option>
	<option value="11">11</option>
	<option value="12">12</option>
   </select>
	<select name="yyyy"><option value="">year</option><option value="2004">2004</option><option value="2005">2005</option></select>
  	</td>
     <td><input type="checkbox" name="priority" value="2">High Priority Items</td>
 </tr>
 <tr>
     <td><input type="radio" name="fund" value="'cash allocated','credit allocated'">Fund Allocated</td>
     <td><input type="radio" name="fund" value="'fund required'">Fund Not Allocated</td>
  </tr>
 <tr>
      <td align="center" colspan="3"><input type="submit" name="search" value="Search"></td>
    </tr>
</table>
</form>
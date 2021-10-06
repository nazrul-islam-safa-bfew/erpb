<form name="as" action="./employee/employeeSql.php" method="post">
<table align="center" width="95%" border="3"  bordercolor="CC9999" cellpadding="2" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td colspan="10" align="right" valign="top"><font class='englishhead'>employee requisition details</font></td>
</tr>
<tr >
 <th align="center" >Project</th>
 <th align="center" >Employee Id</th>
 <th align="center" >Item Description</th> 
 <th align="center" >Requisition Date</th> 
 <th align="center" >Employee/ Quotation at hand</th>

</tr>
<? include("./config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
if($a){   $sql="SELECT * FROM `employeereq` WHERE pcode='$loginProject' ORDER BY `emCode` ASC ";}
else {   $sql="SELECT * FROM `employeereq` WHERE empId='' ORDER BY `emCode` ASC ";}
//echo $sql;
$sqlquery=mysqli_query($db, $sql);
$i=0;	
while($sqlresult=mysqli_fetch_array($sqlquery)){
	?>
 <tr>
   <td><? echo $sqlresult[pcode]?>
     <input type="hidden" name="pp<? echo $i;?>" value="<? echo $sqlresult[pcode]?>">
   </td>
   <td align="center"><? echo $sqlresult[emCode]?></td>
   <td><? $temp = itemDes($sqlresult[emCode]); echo $temp[des].', '.$temp[spc];?></td>
   <td align="center"><? echo '<font color=#FF3333>'.myDate($sqlresult[rdate]).'</font> to <font color=#FF3333>'.myDate($sqlresult[ddate]).'</font>';?></td>  
   <td>
   <? if($a){ echo  $sqlresult[empId]; $temp= hrName($sqlresult[empId]); echo '  '.$temp[name];} else {?>
     <select name="assetId<? echo $i;?>" size="1">
	   <option value="">Select one</option>
	    <? $ck=0;
		 $temp = explode('-',$sqlresult[emCode]);
		 $t = $temp[1]+1;
		 if($t<10) $t="0$t";
		 $to = "$temp[0]-$t-000";
		 $sql1="SELECT * FROM `employee` WHERE empId BETWEEN '$sqlresult[emCode]' AND '$to'  AND status = '0' ORDER BY `empId` ASC ";
		
		$sqlquery1=mysqli_query($db, $sql1);
		while($sqlresult1=mysqli_fetch_array($sqlquery1)){
		 echo "<option value='$sqlresult1[empId]'>$sqlresult1[empId],".myprojectName($sqlresult1[location]).",</option>";
		$ck=1;
		}
		if(!$ck) echo "<option value='0'>NO Employee Found<option>";
		?>
	 </select>	 
	 <? }//else 
	 //echo $sql1;?>
	 
   </td>
 </tr>
<input type="hidden" name="id<? echo $i;?>" value="<? echo $sqlresult[emreid];?>">
<? $i++; }?>
<input type="hidden" name="no" value="<? echo $i;?>">

<? if(!$a){?><tr><td align="center" colspan="6"><input type="submit" value="Save" name="appRequisition"></td></tr><? }?>
</table>
</form>

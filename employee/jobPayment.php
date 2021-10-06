<?
if($save){
 	include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
for($i=1;$i<$n;$i++){
$sqlp=" UPDATE jobdetails set ".
" startingBasic='${startingBasic.$i}'".
",houseRent='${houseRent.$i}',medical ='${medical.$i}',".
"convence='${convence.$i}',proFund='${proFund.$i}',increment ='${increment.$i}',maxIncrement='${maxIncrement.$i}' ".
" WHERE itemCode='${itemCode.$i}' ";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

//echo $sqlp;
}//for
}//if save

?>
<form name="jobPayment" action="./index.php?keyword=job+payment" method="post">
<table width="95%" border="1" bordercolor="#CCCCCC" cellpadding="0" cellspacing="0">
<tr bgcolor="#CCCCCC">
 <th rowspan="2">Designation</th>
 <th colspan="7">Salary Structure:</th>
</tr>
<tr>
	<td>Starting Basic</td>
	<td>House Rent</td>  
	<td>Medical</td>
	<td>Convence</td> 
	<td>Provident Fund Deduction</td> 
	<td>Increment</td>
	<td>Max. Increment </td>
 </tr>
 <?
 	include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT * from `jobdetails` order by itemCode ASC";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
$i=1;
while($app= mysqli_fetch_array($sqlrunp)){
?>
 <tr>
    <td><? echo $app[itemCode].'<br><font class=outi>'.$app[jobTitle].'</font>';?>
	<input type="hidden" name="itemCode<? echo $i;?>" value="<? echo  $app[itemCode];?>">
	</td>
 	<td align="center">Tk. <input name="startingBasic<? echo $i;?>" value="<? echo $app[startingBasic];?>" type="text" width="10" size="10" class="number"> </td>
 	<td align="center"><input name="houseRent<? echo $i;?>" value='<? echo $app[houseRent];?>' type="text" width="3" size="4" maxlength="3" class="number"> %</td>
 	<td align="center"><input name="medical<? echo $i;?>" value="<? echo $app[medical];?>" type="text" width="3" size="4" maxlength="3" class="number"> %</td>
 	<td align="center"><input name="convence<? echo $i;?>" value="<? echo $app[convence];?>" type="text" width="3" size="4" maxlength="3" class="number"> % </td>
 	<td align="center"><input name="proFund<? echo $i;?>" value="<? echo $app[proFund];?>" type="text" width="3" size="4" maxlength="3" class="number"> %</td>
 	<td align="center">Tk. <input name="increment<? echo $i;?>" value="<? echo $app[increment];?>" type="text" width="10" size="10" class="number"></td>
 	<td align="center"> <input name="maxIncrement<? echo $i;?>" value="<? echo $app[maxIncrement];?>" type="text" width="4" size="4" class="number"> nos</td> 
 </tr>	   	  	     	  	   
	    	   
<? $i++;}// while?>
</table>
<input type="hidden" name="n" value="<? echo $i;?>">
<p align="center"><input type="button" name="save1" value="Save" onClick="jobPayment.submit();"></p>
<input type="hidden" name="save" value="1">
</form>
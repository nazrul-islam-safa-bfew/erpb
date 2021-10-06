<form name="as" action="./equipment/equipmentSql.php" method="post">
<table align="center" width="98%" border="3"  bordercolor="CC9999" cellpadding="2" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td colspan="10" align="right" valign="top"><font class='englishhead'>equipment requisition details</font></td>
</tr>
<tr >
 <th align="center" >Project</th>
 <th align="center" >Equipment Id</th>
 <th align="center" >Item Description</th> 
 <th align="center" >Requisition Date</th> 
 <th align="center">Quotation<br> at Hand</th>   
</tr>
<? include("./config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sql="SELECT * FROM `equipmentreq` WHERE posl='' ORDER BY `eqCode` ASC ";
//echo $sql;
$sqlquery=mysqli_query($db, $sql);
$i=0;	
while($sqlresult=mysqli_fetch_array($sqlquery)){
	?>
 <tr>
   <td><? echo $sqlresult[pcode]?></td>
   <td align="center">
   <a href="./index.php?keyword=purchase+order+vendor&project=<? echo $sqlresult[pcode];?>&itemCode=<? echo $sqlresult[eqCode];?>">
   <? echo $sqlresult[eqCode]?></a></td>
   <td><? $temp = itemDes($sqlresult[eqCode]); echo $temp[des].', '.$temp[spc];?></td>
   <td align="center"><? echo '<font color=#FF3333>'.myDate($sqlresult[rdate]).'</font> to <font color=#FF3333>'.myDate($sqlresult[ddate]).'</font>';
           $duration=(strtotime($sqlresult[ddate])- strtotime($sqlresult[rdate]))/(3600*24); echo ' ('.$duration.' days)';
   ?></td>  
   <td align="center"><? echo quotationNo($sqlresult[eqCode],$sqlresult[pCode])?> nos</td>
 </tr>
<? }?>
</table>
</form>

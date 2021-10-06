
Weekly Holiday :<?
$pcode=$loginProject;
 echo project_wholiday($pcode);?>
<br /><br />
<table width="50%" class="blue" border="1">
<tr>
 <th>SL#</th>
 <th>Date</th>
 <th>description</th> 
</tr>
<? $sql="SELECT * FROM projectcalender 
WHERE pcode='$pcode'
ORDER by hdate ASC";
$sqlq=mysql_query($sql);
$i=1;
while($r=mysql_fetch_array($sqlq)){?>
<tr>
 <td><? echo $i;?></td>
 <td><? echo $r[hdate];?></td> 
 <td><? echo $r[des];?></td>  
</tr>
<? $i++;}//while
?>
</table>

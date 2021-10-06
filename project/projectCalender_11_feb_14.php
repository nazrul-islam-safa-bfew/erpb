<?php 
if($_GET[pcode]) $pcode=$_GET[pcode];
if($_POST[pcode]) $pcode=$_POST[pcode];


if($_GET[id]){mysql_query("DELETE from projectcalender where id='$_GET[id]'");
echo "information updating.....";
echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=./index.php?keyword=project+calender&pcode=$pcode\">";

}
if($_POST[des] AND $_POST[hdate]){
	
	$hdate=$_POST[hdate];
	$des = $_POST[des];
	
$format="Y-m-j";
$hdate = formatDate($hdate,$format);

$sql="INSERT INTO projectcalender (`id`,hdate,des,pcode) 
VALUES ('','$hdate','$des','$pcode')";
//echo "$sql<br>";
$sqlq=mysql_query($sql);

echo "information updating.....";
echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=./index.php?keyword=project+calender&pcode=$pcode\">";

}
?>

Select Project <select name="projectName" onchange="location.href='index.php?keyword=project+calender&pcode='+this.options[this.options.selectedIndex].value">
<?php 	echo "<option>select One</option>";	
	$sqlp = "SELECT `pcode`,pname from `project` ORDER by pcode ASC";
	//echo $sqlp;
	$sqlrunp= mysql_query($sqlp);
	while($typel= mysql_fetch_array($sqlrunp))
	{
	echo "<option value='".$typel[pcode]."'";
	if($pcode==$typel[pcode])  echo " SELECTED";
	echo ">$typel[pcode]--$typel[pname]</option>  ";
	}

?>
</select>
<?php if($pcode){?>
	<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
	<SCRIPT LANGUAGE="JavaScript">
	var now = new Date();
	var cal = new CalendarPopup("testdiv1");
    	cal.showNavigationDropdowns();
		cal.setWeekStartDay(6); // week is Monday - Sunday
		//cal.addDisabledDates(null,formatDate(now,"yyyy-MM-dd"));
		cal.setCssPrefix("TEST");
		cal.offsetX = 25;
		cal.offsetY = 0;

	</SCRIPT>
<br /><br />	
Weekly Holiday :<?php echo project_wholiday($pcode);?>

<form name="form_pcalender" action="./index.php?keyword=project+calender&pcode=<?php echo $pcode;?>" method="post">
<table class="blue">
<tr>
 <td>Description </td>
 <td><textarea name="des"></textarea></td>
</tr>
<tr><td>date </td>
 <td><input type="text" class="s" name="hdate"  readonly="" alt="req" title=" Date"> <a id="anchor" href="#"
   onClick="cal.select(document.forms['form_pcalender'].hdate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a>
</td>
</tr>

<tr><td colspan="2"><input type="button" value="Update" onclick="this.form.submit();" /></td></tr>
</table>
</form>
<br /><br />
<table width="50%" class="blue" border="1">
<tr>
 <th>SL#</th>
 <th>Date</th>
 <th>description</th> 
 <td align="right">action</td>
</tr>
<?php $sql="SELECT * FROM projectcalender 
WHERE pcode='$pcode'
ORDER by hdate ASC";
$todate=date("Y-m-j");
$sqlq=mysql_query($sql);
$i=1;
while($r=mysql_fetch_array($sqlq)){?>
<tr>
 <td><?php echo $i;?></td>
 <td><?php echo $r[hdate];?></td> 
 <td><?php echo $r[des];?></td>  
 <td align="right"><?php if(strtotime($r[hdate])<=strtotime($todate)) echo "irreversible"; else 
 echo "<a href=./index.php?keyword=project+calender&pcode=$pcode&id=$r[id]>Delete</a>";?></td>   
</tr>
<?php $i++;}//while
?>
</table>

<div id=testdiv1
      style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
<?php }?>	  
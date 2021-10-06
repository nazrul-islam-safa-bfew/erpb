<script type="text/jscript">
			 function ShowDiv(divName){   
			 var divmain = document.getElementById(divName);        		 
			   divmain.className= "visible";
			  // document.getElementById('av1').checked=true;
			   }
			 function hidDiv(divName){           		 
			 var divmain = document.getElementById(divName);        		 
			   divmain.className= "hidden";
			   }
function salary(a,b)
{
var xmlhttp;
if (a.length==0)
  {
  document.getElementById("s").innerHTML="";
  return;
  }
if (window.XMLHttpRequest)
  {
  // code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("s").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","calsalary.php?p="+a+"&q="+b,true);
xmlhttp.send();

}
function salarystructure(sa)
{
var xmlhttp;
if (sa.length==0)
  {
  document.getElementById("s1").innerHTML="";
  return;
  }
if (window.XMLHttpRequest)
  {
  // code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("s1").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","salarystructure.php?p1="+sa,true);
xmlhttp.send();

}

</script>

	<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
<?  

if($id){
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

 $sql=@mysqli_query($db, "SELECT * FROM employee WHERE empId=$id") or die('Please try later!!');
 $eqresult= mysqli_fetch_array($sql);

}

?>
<form name="employe" onsubmit="return checkrequired(this);" action="./employee/employeeSql.php" method="post">
<table align="center" width="500" border="3"  bordercolor="CC9999" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td align="right" valign="top" height="30"><font class='englishhead'>Human Resource Entry Form</font></td>
</tr>
<tr>
 <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="3">

<tr>	
   <td width=250>Designation</td>
  <td >
  <!--<select name='designation' size='1' onChange="location.href='index.php?keyword=employee+entry&designation='+employe.designation.options[document.employe.designation.selectedIndex].value";>-->
  <!-- created by Salma line43
  <select name='designation' size='1' onChange="location.href=./index.php?keyword=employee+entry&id=<? echo $sqlresult[empId]?>&designation='+employe.designation.options[document.employe.designation.selectedIndex].value";>-->
<select name='designation' size='1' onChange="//salarystructure(this.value)">

<? 
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT * from `itemlist` Where itemCode >= '71-01-000' AND itemCode < '98-01-000'";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

 while($typel= mysqli_fetch_array($sqlrunp))
{
 echo "<option value='".$typel[itemCode]."'";
if($eqresult[designation]){$designation=$eqresult[designation];}

 if($designation==$typel[itemCode]) echo "SELECTED";
 echo ">$typel[itemCode]--$typel[itemDes]</option>  ";
 }
 ?>
</select>
<? //echo $eqresult[designation];?>
</td>
</tr>
<tr bgcolor="#FFEEEE">
   <td><LABEL for=name>Name</LABEL></td>
   <td ><input type="text" size="30"  name="name" value="<? echo $eqresult[name];?>" alt="req" title="Name"  ></td>
</tr>
<tr bgcolor="#FFEEEE">
   <td><LABEL for=nationalid>National ID</LABEL></td>
   <td ><input type="text" size="30"  name="nationalid" value="<? echo $eqresult[nationalid];?>" alt="req" title="NationalID"  ></td>
</tr>

<? // if($id){?>
<!--<tr bgcolor="#FFEEEE">
   <td><LABEL for=name>User Code</LABEL></td>
   <td ><input type="text" size="30"  name="code" value="<? echo $eqresult[empId];?>" alt="req" ></td>
</tr>--> <? //} ?>
	<SCRIPT LANGUAGE="JavaScript">
	var now = new Date(); 
	var cal = new CalendarPopup("testdiv1");
    	cal.showNavigationDropdowns();
		cal.setWeekStartDay(6); // week is Monday - Sunday
		//cal.addDisabledDates(null,formatDate(now,"yyyy-MM-dd")); 
		cal.setCssPrefix("TEST");		
		cal.offsetX = 25;
		cal.offsetY = -120;
		
	</SCRIPT>
<? if($id){?>
<tr >
  <td>Career Started in</td>
  <td><? echo $eqresult[creDate];?></td> 
</tr>
<tr bgcolor="#FFEEEE">
   <td>Joined BFEW in</td>
   <td><? echo $eqresult[empDate];?></td> 
</tr>

<? } else{?>
<tr >
   <td>Career Started in</td>
      <td><input type="text" maxlength="10" name="creDate" value="<?  if($eqresult[creDate]=='') echo date("d/m/Y"); else echo date("d/m/Y",strtotime($eqresult[creDate])); ?>" readonly="" alt="req" title="Career Started in"> <a id="anchor" href="#"
   onClick="cal.select(document.forms['employe'].creDate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
      </td> 
</tr>

<tr bgcolor="#FFEEEE">
   <td>Joined BFEW in</td>
      <td><input type="text" maxlength="10" name="empDate" value="<? if($eqresult[empDate]=='') echo date("d/m/Y"); else echo date("d/m/Y",strtotime($eqresult[empDate]));?>" readonly="" alt="req" title="Joined BFEW in"> <a id="anchor1" href="#"
   onClick="cal.select(document.forms['employe'].empDate,'anchor1','dd/MM/yyyy'); return false;"
   name="anchor1" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
      </td> 
</tr>
<? }?>
<!--<tr>
   <td>Salary Type </td>
    <td><input name="salarytype" type="radio" value="Salaried" <? if($_GET['salarytype']=="Salaried") echo "checked"; ?> onClick="location.href='./index.php?keyword=employee+entry&salarytype=Salaried'"/>
          Salaried
          <input name="salarytype" type="radio" value="Consolidated" <? if($_GET['salarytype']=="Consolidated") echo "checked"; ?> onClick="location.href='./index.php?keyword=employee+entry&salarytype=Consolidated'"/>
          Consolidated</td> 
</tr>
<? if($_GET['salarytype']=="Salaried") { ?>
<tr bgcolor="#FFEEEE">
   <td>Level</td>
      <td><select name='txtincrement'>
        <option value=''>Select One</option>
        <?
		   for($i=1;$i<=50;$i++)
		   {
		   ?>
        <option value="<? echo $i?>"><? echo $i?></option>
        <? } ?>
      </select></td> 
</tr>
<?  } ?>
<? if($_GET['salarytype']=="Consolidated") { ?>

<tr bgcolor="#FFEEEE">
   <td>Salary</td>
      <td><input type="text" name="txtsalary" /></td> 
</tr>-->
<?  } ?>

<!-- <tr >
   <td>Payment Type</td>
   <td ><select name="salaryType">
        <option <? if($eqresult[salaryType]=='Salary') echo 'selected';?>>Salary</option>
        <option <? if($eqresult[salaryType]=='Wages') echo 'selected';?>>Wages</option>		
   </select></td>
</tr>
 -->
 <? //if($designation<'87-00-000'){?>
<!--<tr>
   <td><LABEL for=salary>Monthly Payable </LABEL></td>
   <td ><input type="text" name="salary" value="<? echo $eqresult[salary];?>"  alt="req" title="Salary" >
   <input type="hidden" name="salaryType" value="Salary"> 
   </td>
</tr>-->

 <? // }
 //else { 
 if($eqresult[salaryType]=='Salaried') $c1=' checked ';
 elseif($eqresult[salaryType]=='Consolidated') $c2=' checked ';
 
// echo "*********$eqresult[salaryType]******";
 ?>
<tr>
   <td><LABEL for=salary>Salary Type</LABEL></td>
   <td >
	   <input type="radio" name="salaryType" value="Salaried" <? echo $c1;?> 
	    onClick="ShowDiv('div1');ShowDiv('div2');hidDiv('div3');hidDiv('div4');">Salaried <br>
       <input type="radio" name="salaryType" value="Consolidated" <? echo $c2;?> 
	   onClick="ShowDiv('div3');ShowDiv('div4');hidDiv('div1');hidDiv('div2');">Consolidated </td>
</tr>

<!--<tr  bgcolor="#FFEEEE">
  <td ><LABEL for=salary>Wages</LABEL></td>
  <td ><input type="text" name="salary" value="<? echo $eqresult[salary];?>"  alt="req" title="Enter Wages" > Tk.</td>
</tr>-->

<? if($eqresult[salaryType]=='Salaried')
{
?>
<tr bgcolor="#FFEEEE">
   <td width=250 ><DIV  id=div1><LABEL for=increment>Salary</LABEL></div></td>
  <td ><DIV  id=div2>
 <!-- <input type="text" name="salary" value="<? echo $eqresult[salary];?>"  title="Enter Allowence" > Tk.  
 <select name='txtincrement'>
        <option value=''><? echo $eqresult[increment];?></option>
        <?
		   for($i=1;$i<=50;$i++)
		   {
		   ?>
        <option value="<? echo $i?>"><? echo $i?></option>
        <? } ?>
      </select>-->
        <input type="text" name="salary" value="<? echo $eqresult[salary];?>"  title="Enter Allowence" > Tk.  
  </div></td>
</tr>
<? } else {?>
<tr bgcolor="#FFEEEE">
   <td width=250 ><DIV  id=div1 class=hidden ><LABEL for=increment>Salary</LABEL></div></td>
  <td ><DIV  id=div2 class=hidden >
 <!-- <input type="text" name="salary" value="<? echo $eqresult[salary];?>"  title="Enter Allowence" > Tk. 
 <select name='txtincrement' onchange="salary(this.value,employe.designation.value);">
        <option value=''>Select One</option>
        <?
		   for($i=1;$i<=50;$i++)
		   {
		   ?>
        <option value="<? echo $i?>"><? echo $i?></option>
        <? } ?>
      </select> -->
          
          <input type="text" name="salary" value="<? echo $eqresult[salary];?>"  title="Enter Allowence" > Tk.  
	  <div id="s">
	  </div>
  </div></td>
</tr>

<? } ?>
<? if($eqresult[salaryType]=='Consolidated')
{
?>
<tr bgcolor="#FFEEEE">
   <td width=250 ><DIV  id=div3><LABEL for=salary>Salary</LABEL></div></td>
  <td ><DIV  id=div4><input type="text" name="txtsalary" value="<? echo $eqresult[salary];?>"  title="Enter Allowence" > Tk.  </div></td>
</tr>
<? } else { ?>
<tr bgcolor="#FFEEEE">
   <td width=250 ><DIV  id=div3 class=hidden ><LABEL for=salary>Salary</LABEL></div></td>
  <td ><DIV  id=div4 class=hidden ><input type="text" name="txtsalary" value="<? echo $eqresult[salary];?>"  title="Enter Allowence" > Tk.  </div></td>
</tr>
<? } ?>


<tr>
 <td colspan="2"><DIV  id=div1>
    <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse">
		<!--<tr >
		   <td width="52%"><LABEL for=salary>Monthly Wages</LABEL></td>
		   <td width="48%" ><input type="text" name="salary" value="<? echo $eqresult[salary];?>"  alt="number" emsg="<br>Enter Wages" > Tk.
		   </td>
		</tr>-->	
	</table>
</div></td>
</tr>
<? // }?>
<!--<tr>	
   <td>Additional Responsibilities and Skills</td>
  <td><? 
$pi = explode(",",$eqresult[addJob]);   
$plist= "<select name='additional[]' size='5' multiple >";
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT * from `itemlist` where itemCode >= '74-01-000' AND itemCode < '98-01-000' ORDER BY itemCode ASC";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

 while($typel= mysqli_fetch_array($sqlrunp))
{
 $plist.= "<option value='".$typel[itemCode]."'";

foreach($pi as $d2){
  if($d2 == $typel[itemCode]) $plist.= "SELECTED";
}
 $plist.= ">$typel[itemCode]-$typel[itemDes]</option>  ";
 }
 $plist.= '</select>';
 echo $plist;
 ?>
</td>
</tr>-->
<tr><td colspan="2" align="center" ><input type="submit" name="save" value="Save" class="store" ></td></tr>
	</table>
 </td>
</tr>
</table>
<input type="hidden" name="id" value="<? echo $id;?>">
</form>
<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
 <div id="s1">

	</div>

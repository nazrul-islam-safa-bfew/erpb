	<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>

<script>
   var counter=0;
   function newRow(tableid,n,se,io) {
     var loc='';
	 var ss=document.getElementById(se).value;
	 var io=document.getElementById(io).value;	 
      mynewrow = eval("document.all." + tableid + ".insertRow(" + loc+ ")");
      counter++;
      mynewrow.insertCell();
      mynewrow.insertCell();
      mynewrow.insertCell();	  
      mynewrow.insertCell();	  	  
	  	  	  
      mynewrow.cells(0).innerHTML = "<td><input type=text name=lname" + counter + " size=40></td>";
      mynewrow.cells(1).innerHTML ="<td><select name=designation"+counter+" size=1>"+ ss+"</td>";
      mynewrow.cells(2).innerHTML = "<td><input type=text name=rate" + counter + "size=10></td>";	
      mynewrow.cells(3).innerHTML ="<td >Enter<input name=etime01"+ counter+" size=2 maxlength=2> : "+
"<input name=etime02" + counter + " size=2 maxlength=2>"+"Exit <input name=xtime01"+counter+"  size=2 maxlength=2> : <input name=xtime02"+counter+"  size=2 maxlength=2></td>";

      mynewrow1 = eval("document.all." + tableid + ".insertRow(" + loc+ ")");
     /* mynewrow1.insertCell();
     mynewrow1.cells(0).innerHTML ="<td colspan=4><select name=designation"+counter+" size=1>"+ io+"</td><";*/

      var tt=mynewrow1.insertCell();
      tt.colSpan = 4;
      tt.innerHTML = "<td><select name=designation"+counter+" size=1>"+ io+"</td>";
	 
	  //alert(document.getElementById(n).value);
	  document.getElementById(n).value=counter;
	 // document.getElementById(n1).value=counter;
	   //alert(document.getElementById(se).value);
      } // newRow()...

   </script>

<form name="attlabour" action="./employee/dailyLabour.sql.php" method="post">
<table id=myTable name=myTable align="center" width="98%" border="3"  bordercolor="CC9999" cellpadding="2" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999"> 
	<td align="left">
	<SCRIPT LANGUAGE="JavaScript">
	var now = new Date(); 
	var cal = new CalendarPopup("testdiv1");
    	//cal.showNavigationDropdowns();
		cal.setWeekStartDay(6); // week is Monday - Sunday
		cal.addDisabledDates(null,formatDate(now,"yyyy-MM-dd")); 
		cal.setCssPrefix("TEST");		
		cal.offsetX = 0;
		cal.offsetY = 0;
		
	</SCRIPT>
      <input type="text" maxlength="10" name="edat" value="<? echo date("j/m/Y",strtotime($edat));?>"> <a id="anchor" href="#"
   onClick="cal.select(document.forms['att'].edat,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
      <!-- <input type="button" name="go" value="Go" onClick="location.href='./index.php?keyword=employee+attendance&edat='+document.att.edat.value"> -->
	  </td> 
	<td align="right" colspan="7" ><font class='englishhead'>daily labour attendance</font></td>
</tr>
<tr>
  <th>Labour Name</th>
  <th>Designation</th>
  <th>Wages/day</th>
  <th>Time</th>  
</tr>
<tr >  
  <td><input type="text" name="lname0" size="40"></td>
  <td>
<? 
echo "<select name='designation0' size='1' >";
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT * from `itemlist` Where itemCode between '87-00-000' AND '99-01-000'";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
$plist='';
 while($typel= mysqli_fetch_array($sqlrunp))
{
 $plist.= "<option value='".$typel[itemCode]."'";
 $plist.= ">$typel[itemDes]</option>  ";
 }
 $plist.= '</select>';
 echo $plist;
 ?>    
  </td>  
  <td><input type="text" name="rate0" size="10"></td>   
<td >Enter
<input name="etime010"   size="2" maxlength="2"> : 
<input name="etime020"  size="2" maxlength="2"> 
Exit
<input name="xtime010" size="2" maxlength="2"> : 
<input name="xtime020"  size="2" maxlength="2"> 
</td>
</tr>
<tr>
  <td colspan="4">
<? 
echo "<select name='iow' size='1' >";
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqla = "SELECT iow.iowCode,siow.* from iow,`siow` Where siowPcode='$loginProject' AND iowProjectCode='$loginProject'";
//echo $sqla;
$sqlrunpa= mysqli_query($db, $sqla);
$iow='';
 while($typela= mysqli_fetch_array($sqlrunpa))
{
 $iow.= '<option value='.$typela[siowId]."'";
 $iow.= '>'.$typela[iowCode].'--'.$typela[siowName].'</option>';
 }
 $iow.= '</select>';
 echo $iow;
 ?>    
  </td>  

</tr>

<tr><td colspan="4" height="10" bgcolor="#f4f4f4"></td></tr>
</table>
<a href="#" onClick="newRow('myTable','n','se','io')" >Add</a>
<input id="n" type="hidden" name="n" value="">
<input id="se" type="hidden" name="se" value="<? echo $plist?>">
<input id="io" type="hidden" name="io" value="<? //echo $iow?>" >
<input type="submit" >
</form>
<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
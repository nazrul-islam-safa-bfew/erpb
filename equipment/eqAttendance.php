<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>

<? 

include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
?>
<form name="att" action="./equipment/eqAttendance.sql.php" method="post">
	<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>

  <table align="center" width="98%" border="3"  bordercolor="#CC9999" cellpadding="2" cellspacing="0" style="border-collapse:collapse">
    <tr bgcolor="#CC9999"> 
      <td align="left"  width="50%">
<? 

if($loginUname=='eq000'){?>
 <SCRIPT LANGUAGE="JavaScript">
	var now = new Date(); 
	var cal = new CalendarPopup("testdiv1");
    	cal.showNavigationDropdowns();
		cal.setWeekStartDay(6); // week is Monday - Sunday
		//cal.addDisabledDates(null,formatDate(now,"yyyy-MM-dd")); 
		cal.setCssPrefix("TEST");		
		cal.offsetX = 0;
		cal.offsetY = 0;
		
	</SCRIPT>
        <? 
$ex = array('Select one','');
echo selectPlist('project',$ex,$project);
?>

        <input type="text" maxlength="10" name="edat" value="<? echo $edat;?>"> 
        <a id="anchor" href="#"
   onClick="cal.select(document.forms['att'].edat,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
 <input type="button" name="go" value="Go" onClick="location.href='./index.php?keyword=eq+attendance&edat='+document.att.edat.value+'&project='+document.att.project.value"> 
<? } else {?>
   	<? if($edat==date("d/m/Y",(strtotime($todat)-86400))) {$t2='checked'; $t1='';}
	  else {$edat=date("d/m/Y",strtotime($todat)); $t1='checked'; $t2='';}
	  //else {$err=1;}
	?>
	<input type="radio" name="sd" value="<? echo date("d/m/Y",strtotime($todat));?>"  onClick="edat.value=this.value;" <? echo $t1;?>> Today, <? echo date("D, d/m/Y",strtotime($todat));?>	
    <input type="radio" name="sd" value="<? echo date("d/m/Y",(strtotime($todat)-86400));?>" onClick="edat.value=this.value;"  <? echo $t2;?>> Yesterday, <? echo date("D, d/m/Y",(strtotime($todat)-86400));?>

   <input type="hidden" maxlength="10" name="edat" value="<? if($edat) echo $edat; else echo date("d/m/Y",strtotime($todat));?>" >

        <input type="button" name="go" value="Go" onClick="location.href='./index.php?keyword=eq+attendance&edat='+document.att.edat.value"> 
   <? $project=$loginProject; }?>
      </td>
      <td align="right" colspan="2" ><font class='englishhead'>human resource attendance</font></td>
    </tr>
	<? if($edat AND $err==0){ //echo $edat;?>
    <tr> 
      <th width="200">equipment ID</th>
      <th>description</th>
    </tr>
	
    <?	
 $sqlquery="SELECT * FROM eqproject where pcode='$project' AND status='1' ORDER by itemcode ASC ";
// echo $sqlquery;
 $sql= mysqli_query($db, $sqlquery);
	
$j=1;
 while($eq=mysqli_fetch_array($sql)){
 if($j%2==0) $bg = "#E5E5E5";
else $bg = "#D5D5D5";
?>
<tr onmouseover="setPointer(this, <? echo $j;?>, 'over', '<? echo $bg;?>', '#CCFFCC', '#FFCC99');" 
    onmouseout="setPointer(this, <? echo $j;?>, 'out', '<? echo $bg;?>', '#CCFFCC', '#FFCC99');"
    onmousedown="setPointer(this, <? echo $j;?>, 'click', '<? echo $bg;?>', '#CCFFCC', '#FFCC99');">
	

      <td  valign="top" onmousedown="setCheckboxColumn('ch<? echo $j;?>');" >
<? 
$format="Y-m-d";
if(eq_isPresent($eq[assetId],$eq[itemCode],formatDate($edat,$format)) OR isHPresent($emp[empId],formatDate($edat,$format)))$t=" checked";
else $t="";
  
?> 

	  
	  <input  type="checkbox" name="ch<? echo $j;?>" <? echo "$t";?>  onmousedown="setCheckboxColumn('ch<? echo $j;?>');">
        <? if($eq[assetId]{0}=='A')  { echo eqpId_local($eq[assetId],$eq[itemCode]); $type='L';}
		else {echo eqpId($eq[assetId],$eq[itemCode]); $type='H'; }
		 ?> 
		<input type="hidden" name="eqId<? echo $j;?>" value="<? echo $eq[assetId];?>">
		<input type="hidden" name="itemCode<? echo $j;?>" value="<? echo $eq[itemCode];?>">
		<input type="hidden" name="eqType<? echo $j;?>" value="<? echo $type;?>">
		<input type="hidden" name="posl<? echo $j;?>" value="<? echo $eq[posl];?>">						
	  </td>
      <td  valign="top" onmousedown="setCheckboxColumn('ch<? echo $j;?>');" >
<?  

$temp=itemDes($eq[itemCode]); echo $temp[des].', '.$temp[spc];

?>
</td>
    </tr>
    <? $j++;} //while?>	
<tr><td colspan="2" height="10"> </td></tr>	


    <tr> 
      <td align="center" colspan="2">
	  <input type="submit" name="attendance" value="Present"></td>
    </tr>

	<? } else echo '<tr><td colspan=3><dir align=center>'.inerrMsg('You are trying to do Illegal thing!!').'</dir></td></tr>';?>
  </table>
<input type="hidden" name="n" value="<? echo $i;?>">
<input type="hidden" name="m" value="<? echo $j;?>">
</form>

<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>

<script language=javascript> 
function callme(rno)
{
var tmp = document.getElementById(rno); 
if(tmp.className=='td1') tmp.className='td2'
else if(tmp.className=='td2') tmp.className='td1'
}
var marked_row = new Array;
function setPointer(theRow, theRowNum, theAction, theDefaultColor, thePointerColor, theMarkColor)
{
    var theCells = null;

    // 1. Pointer and mark feature are disabled or the browser can't get the
    //    row -> exits
    if ((thePointerColor == '' && theMarkColor == '')
        || typeof(theRow.style) == 'undefined') {
        return false;
    }

    // 2. Gets the current row and exits if the browser can't get it
    if (typeof(document.getElementsByTagName) != 'undefined') {
        theCells = theRow.getElementsByTagName('td');
    }
    else if (typeof(theRow.cells) != 'undefined') {
        theCells = theRow.cells;
    }
    else {
        return false;
    }

    // 3. Gets the current color...
    var rowCellsCnt  = theCells.length;
    var domDetect    = null;
    var currentColor = null;
    var newColor     = null;
    // 3.1 ... with DOM compatible browsers except Opera that does not return
    //         valid values with "getAttribute"
    if (typeof(window.opera) == 'undefined'
        && typeof(theCells[0].getAttribute) != 'undefined') {
        currentColor = theCells[0].getAttribute('bgcolor');
        domDetect    = true;
    }
    // 3.2 ... with other browsers
    else {
        currentColor = theCells[0].style.backgroundColor;
        domDetect    = false;
    } // end 3

    // 3.3 ... Opera changes colors set via HTML to rgb(r,g,b) format so fix it
    if (currentColor.indexOf("rgb") >= 0)
    {
        var rgbStr = currentColor.slice(currentColor.indexOf('(') + 1,
                                     currentColor.indexOf(')'));
        var rgbValues = rgbStr.split(",");
        currentColor = "#";
        var hexChars = "0123456789ABCDEF";
        for (var i = 0; i < 3; i++)
        {
            var v = rgbValues[i].valueOf();
            currentColor += hexChars.charAt(v/16) + hexChars.charAt(v%16);
        }
    }

    // 4. Defines the new color
    // 4.1 Current color is the default one
    if (currentColor == ''
        || currentColor.toLowerCase() == theDefaultColor.toLowerCase()) {
        if (theAction == 'over' && thePointerColor != '') {
            newColor              = thePointerColor;
        }
        else if (theAction == 'click' && theMarkColor != '') {
            newColor              = theMarkColor;
            marked_row[theRowNum] = true;
            // Garvin: deactivated onclick marking of the checkbox because it's also executed
            // when an action (like edit/delete) on a single item is performed. Then the checkbox
            // would get deactived, even though we need it activated. Maybe there is a way
            // to detect if the row was clicked, and not an item therein...
            // document.getElementById('id_rows_to_delete' + theRowNum).checked = true;
        }
    }
    // 4.1.2 Current color is the pointer one
    else if (currentColor.toLowerCase() == thePointerColor.toLowerCase()
             && (typeof(marked_row[theRowNum]) == 'undefined' || !marked_row[theRowNum])) {
        if (theAction == 'out') {
            newColor              = theDefaultColor;
        }
        else if (theAction == 'click' && theMarkColor != '') {
            newColor              = theMarkColor;
            marked_row[theRowNum] = true;
            // document.getElementById('id_rows_to_delete' + theRowNum).checked = true;
        }
    }
    // 4.1.3 Current color is the marker one
    else if (currentColor.toLowerCase() == theMarkColor.toLowerCase()) {
        if (theAction == 'click') {
            newColor              = (thePointerColor != '')
                                  ? thePointerColor
                                  : theDefaultColor;
            marked_row[theRowNum] = (typeof(marked_row[theRowNum]) == 'undefined' || !marked_row[theRowNum])
                                  ? true
                                  : null;
            // document.getElementById('id_rows_to_delete' + theRowNum).checked = false;
        }
    } // end 4

    // 5. Sets the new color...
    if (newColor) {
        var c = null;
        // 5.1 ... with DOM compatible browsers except Opera
        if (domDetect) {
            for (c = 0; c < rowCellsCnt; c++) {
                theCells[c].setAttribute('bgcolor', newColor, 0);
            } // end for
        }
        // 5.2 ... with other browsers
        else {
            for (c = 0; c < rowCellsCnt; c++) {
                theCells[c].style.backgroundColor = newColor;
            }
        }
    } // end 5

    return true;
} // end of the 'setPointer()' function
function setCheckboxColumn(theCheckbox){
    if (document.getElementById(theCheckbox)) {
        document.getElementById(theCheckbox).checked = (document.getElementById(theCheckbox).checked ? false : true);
        if (document.getElementById(theCheckbox + 'r')) {
            document.getElementById(theCheckbox + 'r').checked = document.getElementById(theCheckbox).checked;
        }
    } else {
        if (document.getElementById(theCheckbox + 'r')) {
            document.getElementById(theCheckbox + 'r').checked = (document.getElementById(theCheckbox +'r').checked ? false : true);
            if (document.getElementById(theCheckbox)) {
                document.getElementById(theCheckbox).checked = document.getElementById(theCheckbox + 'r').checked;
            }
        }
    }
}

function copyCheckboxesRange(the_form, the_name, the_clicked)
{
    if (typeof(document.forms[the_form].elements[the_name]) != 'undefined' && typeof(document.forms[the_form].elements[the_name + 'r']) != 'undefined') {
        if (the_clicked !== 'r') {
            if (document.forms[the_form].elements[the_name].checked == true) {
                document.forms[the_form].elements[the_name + 'r'].checked = true;
            }else {
                document.forms[the_form].elements[the_name + 'r'].checked = false;
            }
        } else if (the_clicked == 'r') {
            if (document.forms[the_form].elements[the_name + 'r'].checked == true) {
                document.forms[the_form].elements[the_name].checked = true;
            }else {
                document.forms[the_form].elements[the_name].checked = false;
            }
       }
    }
}

</script>

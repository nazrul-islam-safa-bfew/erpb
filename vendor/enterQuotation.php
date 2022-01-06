<?php
$i=1; //set quotation counter
if($clear || !$vid){
	$_SESSION['last_q_id']="";
	$_SESSION['pCode']="";
	$_SESSION['sDetail']="";
	$_SESSION['delivery']="";
	$_SESSION['deliveryLoc']="";
	$_SESSION['qRef']="";
	$_SESSION['valid']="";
	$_SESSION['qdate']="";
}
?>
<style>
#vendorTable_pdf td{
	display:none;
}
.the_vendor:first{border:1px solid #00f;}


</style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/jscript">
			 function ShowDiv(divName){   
			 var divmain = document.getElementById(divName);
			   divmain.className= "visible";
			 }
			 function hidDiv(divName){
			 	var divmain = document.getElementById(divName);
			 	divmain.className= "hidden";
			 }
			</script>
<? if(!$Go){
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT vid,vname from `vendor` ORDER by vname ASC";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
?>

<form name="selectProject" action="./index.php?keyword=enter+Quotation" method="post">
<table class="vendorTable" align="center" width="400">
<tr>
 <td class="vendorAlertHd" colspan="2">Enter Quotation</td>
</tr>
<tr> 
 <td>Select Vendor <select name="vid">
<? while($typel= mysqli_fetch_array($sqlrunp)){	
 echo "<option value='".$typel[vid]."'";
 echo ">$typel[vname]</option>  ";
}
?>
	</select>
</td>
 <td align="right" ><input type="submit" name="Go" value="go"></td>
</tr>
</table>
</form>
<? }?>
<? if($Go){

include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp11 = "SELECT * from `vendor` WHERE vid=$vid";
//echo $sqlp11;
$sqlrunp11= mysqli_query($db, $sqlp11);
$vendor= mysqli_fetch_array($sqlrunp11);
?>

<table align="center" width="98%" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr>
  <td >
    <table align="center" width="98%" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
		<tr>
		<td colspan="9" align="center"><h2> <? echo $vendor[vname];?></h2></td>
		</tr>
		<tr>
		<td colspan="9" align="center"> <? echo $vendor[address];?></td>
		</tr>
		<tr>
		<td colspan="9" align="center"> <? echo $vendor[contactName].', '.$vendor[mobile];?></td>
		</tr>	 
	</table>
  </td>
</tr>
<tr>
  <td colspan="9" align="center" height="50"></td>
</tr>
<tr>
 <td>
    <table   class="vendorTable" border="1" align="center"  width="98%"   >
        <tr > 
		  <td class="vendorAlertHdt">Quotation No.</td>
          <td class="vendorAlertHdt"> Project</td>
          <td class="vendorAlertHdt" width="80"> Item</td>
          <td class="vendorAlertHdt"> Item Description</td>		  
          <td class="vendorAlertHdt"> Delivery Details</td>
          <td class="vendorAlertHdt"> Rate </td>
          <td class="vendorAlertHdt"> Quotation Ref.</td>
          <td class="vendorAlertHdt"> Valid Till</td>
	  <td class="vendorAlertHdt">Pdf View</td>
        </tr>
<? include("config.inc.php");
$dbq = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

$extra="";
	if($loginProject!="000")$extra=" and pCode='$loginProject' ";
$qrsql="select * from quotation_root where vid=$vid order by qrId desc";
$qrq=mysqli_query($db, $qrsql);
while($qrRow=mysqli_fetch_array($qrq)){
	echo "<tr style='background:#E8E8E8;' class='the_vendor q_".$i++."'>
		<td>Quotation: ". $i ."</td>".' 
		<td></td>
		<td></td>
		<td></td><td>';
	 if($qrRow[delivery]=='To') echo "Delivery To ".myprojectName($qrRow[deliveryLoc]).";" ; else echo "Delivery From $qrRow[deliveryLoc];";
	echo '</td>
		<td></td>
		<td>'.$qrRow[qRef].'</td>
		<td>'.$qrRow[valid].'</td>
		<td><a href="#" id="" onClick="show_next('.$qrRow[qrId].')">SHOW</a> | <a href="#" onClick="hide_next('.$qrRow[qrId].')">HIDE</a></td>
	</tr>
	
	<tr id="vendorTable_pdf">
			<td colspan="8" id="pdf_'.$qrRow[qrId].'">
				<embed width="100%" height="500" name="plugin" src="'.$qrRow[att].'" type="application/pdf">			
			</td>
	</tr>';
$sqlq = "SELECT quotation.*,itemlist.* from `quotation`, itemlist WHERE vid=$vid AND quotation.itemCode= itemlist.itemCode AND quotation.qrId='$qrRow[qrId]' $extra order by quotation.qrId ";
//echo $sqlq;
$sqlrunq= mysqli_query($db, $sqlq);
while($qresult= mysqli_fetch_array($sqlrunq)){
?>
        <tr  <?php if($qresult[vid])echo "" ?> > 
			<td></td>
          <td align="center" > <? echo $qresult[pCode];?></td>
          <td  align="center"> <!--<a href="./index.php?keyword=enter+Quotation&Go=1&vid=<? echo $qresult[vid];?>&edit=1&qid=<? echo $qresult[qid];?>&visible=1 #edit" ></a>--><? echo $qresult[itemCode];?></td>
          <td align="left"><? echo $qresult[itemDes].', '.$qresult[itemSpec];?></td>
          <td align="left">
		  <!--<? if($qresult[delivery]=='To') echo "Delivery To ".myprojectName($qresult[deliveryLoc]).";" ; else echo "Delivery From $qresult[deliveryLoc];"; ?>-->
		   <? echo $qresult[sDetail];?></td>
          <td  align="right"> <? echo number_format($qresult[rate],2).' /'.$qresult[itemUnit];?></td>
          <td > <!--<? echo $qresult[qRef];?>--></td>
          <td ><!-- <? echo date("d-m-Y",strtotime($qresult[valid]));?> -->
            
          </td>
		  <td></td>
        </tr>
		<tr id="vendorTable_pdf">
			<td colspan="8" id="pdf_<?php echo $qresult[qid]; ?>">
			
			<embed width="100%" height="500" name="plugin" src="<?php echo $qresult[att]; ?>" type="application/pdf">
			
			
			</td>
		</tr>

        <? }
		
		}//quation loop
		?>
		
		
      </table>
 </td>
</tr>

<tr>
  <td colspan="9" align="center" height="50" bordercolor="#FFFFFF"></td>
</tr>
</table>
<?php
//$_SESSION['last_q_id']




//$_SESSION['valid']
//$_SESSION['qdate']


?>
<a href="./index.php?keyword=enter+Quotation&Go=1&vid=<? echo $vid;?>&visible=1#add" id="tigger">Add New Item <?php if($_SESSION['last_q_id'])echo "Existing Quotation"; ?></a><br>
 <?php if($_SESSION['last_q_id']){ ?>
<a href="./index.php?keyword=enter+Quotation&Go=1&vid=<? echo $vid;?>&clear=1">Clear Existing Quotation</a>
<?php }?>
<br><br>
<DIV  id=divAdd <? if($visible==1) echo  'class=visible'; else echo 'class=hidden' ;?>>
<a  href="#" name="edit"></a>
<a  href="#" name="add"></a>
<table align="center" width="700" class="blue" >
<tr><td colspan="2" class="blueAlertHd" ><font class="englishheadBlack"> add new item</font></td></tr>
<?
if($edit && qid){
include("config.inc.php");
$dbq1 = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

$sqlq1 = "SELECT * from `quotation` WHERE qid=$qid";
//echo $sqlp;
$sqlrunq1= mysqli_query($db, $sqlq1);
$qresult1= mysqli_fetch_array($sqlrunq1);
}
?>

<form name="quo" action="./vendor/quoSql.php" method="post" enctype="multipart/form-data">
<tr bgcolor="#EFEFFF">
<td> Item Code</td>  
<td>
<? if($edit){?>  
<input name="itemCode" type="hidden"  value="<? echo $qresult1[itemCode];?>"> <? echo $qresult1[itemCode];?>
<? } else {?>
<select name="itemCode" onChange="location.href='index.php?keyword=enter+Quotation&Go=1&vid=<? echo $vid;?>&visible=1&sitemCode='+
quo.itemCode.options[document.quo.itemCode.selectedIndex].value+'#add'">

<?
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

$sqlp = "SELECT itemCode,itemDes,itemSpec,itemUnit from `itemlist` ";
if($_SESSION['last_q_id']>0)
	$sqlp .= " where itemCode not in (select itemCode from quotation where qrId='".$_SESSION['last_q_id']."')";
$sqlp .= " ORDER by itemCode ASC";
// echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

while($typel= mysqli_fetch_array($sqlrunp))
{
echo "<option value='".$typel[itemCode]."'";
if($typel[itemCode]==$sitemCode) {echo " SELECTED "; $selected_unit=$typel[itemUnit];}
echo ">$typel[itemCode]--$typel[itemDes]-$typel[itemSpec]-$typel[itemUnit]</option>  ";
}
?>
</select>
<? }//else?></td>

</tr>
<input type="hidden" name="pCode" value="<?php echo $loginProject;  ?>">
<!--<tr>
<td width="184"> Purchase Location</td>
<td>
<select name="pCode">
<?
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

$sqlp = "SELECT pname, pcode from `project`";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

while($typel= mysqli_fetch_array($sqlrunp))
{
echo "<option value='".$typel[pcode]."'";
if($typel[pcode]==$qresult1[pCode]) {echo " SELECTED ";}
echo ">$typel[pcode]--$typel[pname]</option>  ";
}
?>
</select></td>
</tr>-->
<tr bgcolor="#EFEFFF">
<td> Delivery</td>    
<td> <? $tempCar=$qresult1[delivery];
if($tempCar=='From') $c1="CHECKED";
 else $c0="CHECKED";	
 
 if($qresult1[delivery]=='To')$deliveryLoc = $deliveryTo;
else if($qresult1[delivery]=='From')$deliveryLoc = $deliveryFrom;  
?>

<?php if($_SESSION['last_q_id']){ ?>

<input type="text" value="<?php echo $_SESSION['delivery']; ?>" name="delivery" readonly="readonly">

<?php } else{?>
<input type="radio" name="delivery" value="To" <? echo $c0;?> >For 
<select name="deliveryTo">
<?




include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

$sqlp = "SELECT pname, pcode from `project`";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

while($typel= mysqli_fetch_array($sqlrunp))
{
	if($typel[pcode]==$_SESSION[loginProject]){
		echo "<option value='".$typel[pcode]."'";
		if($typel[pcode]==$qresult1[deliveryLoc]) echo " SELECTED ";
		echo ">$typel[pcode]--$typel[pname]</option>  ";
	}
}
?>
</select>
<br>
<?php } //else ?>
<input type="radio" name="delivery" value="From" <? echo $c1;?>>From 
<input type="text" name="deliveryFrom"  value="<?  if($tempCar=='From'){ echo $qresult1[deliveryLoc];} else echo '';  if($_SESSION['last_q_id']){echo $_SESSION['deliveryLoc'];}?>" <?php if($_SESSION['last_q_id']) echo ' readonly' ?>></td>
</tr>  
<tr bgcolor="#EFEFFF">
<td> Other Delivery Details</td>  
<td> <textarea name="sDetail" cols="40" <?php if($_SESSION['last_q_id']) echo ' readonly' ?>><? echo $qresult1[sDetail];?><?php echo $_SESSION['sDetail']; ?></textarea></td>    
</tr>

<tr>
<td> Rate </td>    
<td> <input type="text" size="10" name="rate"  value="<? echo $qresult1[rate];?>"> /<?php echo ($selected_unit); ?>
<? if($sitemCode>='50-00-000'){?>
<input type="radio" name="qtOption" value="0" checked onClick="hidDiv('div1'); ">Rent/day
<input type="radio" name="qtOption" value="1" onClick="ShowDiv('div1');">Purchase/nos<? }?> </td>
</tr>  

<tr bgcolor="#EFEFFF">
<td> Quotation Reference</td>  
<td> <textarea name="qRef" <?php if($_SESSION['last_q_id']) echo ' readonly' ?> cols="40"><? echo $qresult1[qRef];?><?php echo $_SESSION['qRef']; ?></textarea></td> 
</tr>

<tr>
<td> Quotation Valid Till</td>  
<td>
<?php if(!$_SESSION['last_q_id']){ ?>
<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
<SCRIPT LANGUAGE="JavaScript">
var now = new Date(); 
//var cal = new CalendarPopup();
var cal = new CalendarPopup("testdiv1");
//cal.showNavigationDropdowns();
cal.setWeekStartDay(6); // week is Monday - Sunday
//cal.addDisabledDates(null,formatDate(now,"dd/MM/yyyy")); 
cal.setCssPrefix("TEST");		
cal.offsetX = -150;
cal.offsetY = -100;

</SCRIPT>
<?php } ?>
<input type="text" name="valid"size="10" maxlength="10" <?php if($_SESSION['last_q_id']) echo ' readonly' ?> value="<? if($qresult1[valid])echo date("j/m/Y",strtotime($qresult1[valid])); if($_SESSION['valid'])echo date("j/m/Y",strtotime($_SESSION['valid']));?>">

<a href="#"
onClick="cal.select(document.forms['quo'].valid,'anchor1','dd/MM/yyyy'); return false;"
name="anchor1" id="anchor1"><img src="./images/b_calendar.png" alt="calender" border="0"></a>
</td>
</tr>  
  
  	

<tr>
<td  class="vendorTdl"> Advance Required</td>    
	<td colspan="2"> 
		<? if($vendor[advance]=='-5') $c1='CHECKED';
		else $c='CHECKED';?>
		<input type="radio" name="advance" value="10" <? echo $c;?> onClick="change_advance(0);"> No
		<span>| Yes: <input type="radio" name="advance" value="-1" <? echo $c1;?> onClick="change_advance(5);"> 5% </span>
		<span><input type="radio" name="advance" value="-2" <? echo $c1;?> onClick="change_advance(10);"> 10% </span>
		<span><input type="radio" name="advance" value="-3" <? echo $c1;?> onClick="change_advance(15);"> 15% </span>
		<span><input type="radio" name="advance" value="-4" <? echo $c1;?> onClick="change_advance(20);"> 20% </span>
		<span><input type="radio" name="advance" value="-5" <? echo $c1;?> onClick="change_advance(25);"> 25% </span>
		<span><input type="radio" name="advance" value="-6" <? echo $c1;?> onClick="change_advance(30);"> 30% </span>
		<span><input type="radio" name="advance" value="-9" <? echo $c1;?> onClick="change_advance(45);"> 45% </span>
		<span><input type="radio" name="advance" value="-10" <? echo $c1;?> onClick="change_advance(50);"> 50% </span>
		<span><input type="radio" name="advance" value="-12" <? echo $c1;?> onClick="change_advance(60);"> 60% </span>
		<span><input type="radio" name="advance" value="-15" <? echo $c1;?> onClick="change_advance(75);"> 75% </span>
		<span><input type="radio" name="advance" value="-20" <? echo $c1;?> onClick="change_advance(100);"> 100%</span>
	</td>
  <input type="hidden" value="0" name="point_of_advance" id="point_of_advance">
</tr>
<tr>
<td  class="vendorTdl"> Credit Facility</td>    
<td colspan="2">
<? if($vendor[cfacility]=='10') $c2='CHECKED';
elseif($vendor[cfacility]=='0') $c3='CHECKED';
// else $c1='CHECKED';?>

<input type="radio" name="cfacility" value="20" <? echo $c3;?> onClick="credit();"> Bill-to-Bill
| Yes :
<input type="radio" name="cfacility" days='7' value="2" checked="" onclick="change_credit(7);">7 days, 
<input type="radio" name="cfacility" days='14' value="4" checked="" onclick="change_credit(14);"> 14 days, 
<input type="radio" name="cfacility" days='21' value="6" checked="" onclick="change_credit(21);"> 21 days, 
<input type="radio" name="cfacility" days='30' value="8" checked="" onclick="change_credit(30);"> 30 days, 
<input type="radio" name="cfacility" days='45' value="10" checked="" onclick="change_credit(45);"> 45 days, 
<input type="radio" name="cfacility" days='60' value="12" checked="" onclick="change_credit(60);"> 60 days, 
<input type="radio" name="cfacility" days='75' value="14" checked="" onclick="change_credit(75);"> 75 days, 
<input type="radio" name="cfacility" days='90' value="16" checked="" onclick="change_credit(90);"> 90 days
  
<input type="hidden" value="90" name="point_of_cf" id="point_of_cf">

</td>
</tr>
  <script type="text/javascript">
    function change_credit(val){
      document.getElementById("point_of_cf").value=val;
    }
    function change_advance(val){
      document.getElementById("point_of_advance").value=val;
    }
  </script>
	
	
	
<?php if(!$_SESSION['last_q_id']){ ?>
<tr>
<td class="vendorTdl"> Attachment</td>
<td><input type="file" id="pdf_file" name="quoUpload"></td>
</tr>
<?php } ?>
<? if($sitemCode>='50-00-000'){?>
<tr>

<td colspan="2">
<DIV  id=div1 class=hidden >
<table width="100%">
<tr>
<td>Model</td>
<td ><input type="text" name="model" value="<? echo $model;?>" size="50" <? if($r) echo 'readonly';?>></td>
</tr>

<tr bgcolor="#FFEEEE">
<td>Brand</td>
<td ><input type="text" name="brand" value="<? echo $brand;?>" size="50" <? if($r) echo 'readonly';?>></td>
</tr>
<tr>
<td>Manufactured by</td>
<td ><input type="text" name="manuby" value="<? echo $manuby;?>"  size="50" <? if($r) echo 'readonly';?>></td>
</tr>
<tr bgcolor="#FFEEEE">
<td>Made in</td>
<td ><input type="text" name="madein" value="<? echo $madein;?>"  size="50" <? if($r) echo 'readonly';?>></td>
</tr>
<tr>
<td>Specification</td>
<td ><input type="text" name="speci" value="<? echo $speci;?>"  size="50" <? if($r) echo 'readonly';?>></td>
</tr>
<tr bgcolor="#FFEEEE">
<td>Design Capacity</td>
<td ><input type="text" name="designCap" value="<? echo $designCap;?>"  size="50" <? if($r) echo 'readonly';?>></td>
</tr>
<tr>
<td>Current Capacity</td>
<td ><input type="text" name="currentCap" value="<? echo $currentCap;?>"  size="50" <? if($r) echo 'readonly';?>></td>
</tr>
<tr bgcolor="#FFEEEE">
<td>Year of Manufacture</td>
<td ><input type="text" name="yearManu" value="<? echo $yearManu;?>" <? if($r) echo 'readonly';?>></td>
</tr>
<!-- <tr bgcolor="#FFEEEE">
<td><label for="life">Life</label></td>
<td ><input type="text" size="10" name="life" value="<? echo $eqresult[life];?>" alt="number|1" emsg="<br>Enter Life" <? if($r) echo 'readonly';?>> years</td>
</tr>
<tr>
<td><label for="salvageValue">Salvage Value</label></td>
<td ><input type="text" size="20" name="salvageValue" value="<? echo $eqresult[salvageValue];?>" alt="number|1" emsg="<br>Enter Salvage Value" <? if($r) echo 'readonly';?>> Tk.</td>
</tr>
<tr bgcolor="#FFEEEE">
<td>Expected Use per Year</td>
<td ><input type="text" size="5" name="days" value="<? echo $eqresult[days];?>" <? if($r) echo 'readonly';?>> Months
</td>
</tr>
<tr>
<td>Daily Working Hours</td>
<td ><input type="text" size="5" name="hours" value="<? echo $eqresult[hours];?>" <? if($r) echo 'readonly';?>> Hours
</td>
</tr> -->



<tr >
<td>Condition</td>
<td ><select name="condition" size="1" <? if($r) echo 'disabled';?> >
 <option value="5">New</option>
 <option value="6">Re-conditioned</option>
 <option value="7">Used</option>		 		 
 <option value="1">Used, Running Condition</option>
 <option value="2">Under Periodic Maintenence</option>
 <option value="3">Under Breakdown Maintenence</option>
 <option value="4">Unrepairable</option>		 		 		 
</select></td>
</tr>

</table>
</td>
</tr>

<? }?>
<tr><td  colspan="2" align="center">
<? if(!$edit){?>  <input type="submit" value="Save" name="qotSave" <?php if(!$_SESSION['last_q_id']){ ?>onClick="if(checkThisOut()==0)return false;" <?php } ?>><? }?>
<? if($edit){?> <input type="submit" value="Edit & Save" name="qotEdit"><? }?>
</td>
</tr>	
<input type="hidden" name="vid" value="<? echo $vid;?>">
<input type="hidden" name="qid" value="<? echo $qid;?>">
</form>
	
	<tr>
	<td><b>Note:</b></td>
	<td>
		<style>
			.strip_table tr:nth-child(odd){background:#e1e1e1;}
		</style>
		
		<table class="strip_table" style="float:left; border:1px solid; margin-right: 20px; border-collapse: collapse;">
			<tr>
				<th colspan=2>Advance requirement: </th>
			</tr>
			<tr><td>0%</td>  <td>10 Points</td></tr>
			<tr><td>10%</td> <td>-1 Points</td></tr>
			<tr><td>20%</td> <td>-2 Points</td></tr>
			<tr><td>30%</td> <td>-3 Points</td></tr>
			<tr><td>40%</td> <td>-4 Points</td></tr>
			<tr><td>50%</td> <td>-5 Points</td></tr>
			<tr><td>60%</td> <td>-6 Points</td></tr>
			<tr><td>70%</td> <td>-9 Points</td></tr>
			<tr><td>80%</td> <td>-10 Points</td></tr>
			<tr><td>80%</td> <td>-12 Points</td></tr>
			<tr><td>90%</td> <td>-15 Points</td></tr>
			<tr><td>100%</td><td>-20 Points</td></tr>
		</table>
		
		
		<table class="strip_table"  style="float:left; border:1px solid; border-collapse: collapse;">
			<tr>
				<th colspan=2>Credit Facility: </th>
			</tr>
			<tr><td>Bill to Bill</td><td>20 Points</td></tr>
			<tr><td>7 days</td> 	<td>2 Points</td></tr>
			<tr><td>14 days</td> 	<td>4 Points</td></tr>
			<tr><td>21 days</td> 	<td>6 Points</td></tr>
			<tr><td>30 days</td> 	<td>8 Points</td></tr>
			<tr><td>45 days</td> 	<td>10 Points</td></tr>
			<tr><td>60 days</td> 	<td>12 Points</td></tr>
			<tr><td>75 days</td> 	<td>14 Points</td></tr>
			<tr><td>90+ days</td> <td>16 Points</td></tr>
		</table>
	</td>
	</tr>

</table>
 All Equipment's Unit will be <font class="out">Day</font> only.
<br><br>
<DIV id=testdiv1 
style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white;"></DIV>
<? }?>
</div>
<script type="text/javascript">
function show_next(val){
	the_id="pdf_"+val;
	the_row=document.getElementById(the_id);
	the_row.style.display="inherit";
}
function hide_next(val){
	the_id="pdf_"+val;
	the_row=document.getElementById(the_id);
	the_row.style.display="none";
}


function checkThisOut(){
pdf_file=document.getElementById("pdf_file");
file_name=pdf_file.value;
if(file_name){
file_ext=file_name.split(".").pop();
	if(file_ext!="pdf"){
		alert("Please attatch pdf file!");
		return 0;
	}
}

else{
alert("Please attatch pdf file!");
return 0;
}

}



</script>

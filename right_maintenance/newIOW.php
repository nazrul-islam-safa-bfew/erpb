<?php
error_reporting(1);
// preventiveReplication();
?>
<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
<?
$path="/maintenance/files";
$aa = explode("_",$equipmentID);
$bb = explode("_",$equipmentID);
if($equipmentID){
	$eqID=$aa[0];
	$eqItemCode=$bb[1];
}
if($iow){
$format="Y-m-j";
$iowSdate = formatDate($iowSdate,$format);
$iowCdate = formatDate($iowCdate,$format);

include("config.inc.php");
$db=mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
$temp=itemDes($itemCode);

include_once("./checkInventory.php");
$itemCode=$fullFormatCode;
$iowType=2; // assign all maintenance iow will be non-billable

$pcode=$iowProjectCode; // only eqmaintenance table hold real project code.
$iowProjectCode="004";  // all iow will be created for 004 equipment section only

	
$F_image_file=$_FILES["image_file"];
if($F_image_file)	$attachIMG=pdfUpload_function("jpg",$F_image_file["tmp_name"],$path,rand(11111111,999999999));

$F_pdf_file=$_FILES["pdf_file"];
if($F_pdf_file) $attachPDF=pdfUpload_function("pdf",$F_pdf_file["tmp_name"],$path,rand(11111111,999999999));
	

	$sqliow="INSERT INTO iowtemp (iowProjectCode,itemCode, iowCode, iowDes, iowQty, iowUnit,
 iowPrice, iowTotal, iowType, iowSdate, iowCdate, iowStatus, iowDate, Prepared, Checked, Approved,revision,position)
 VALUES ('$iowProjectCode', '$itemCode','$iowCode', '$iowDes', '$iowQty', '$iowUnit',
  '$iowPrice', '', '$iowType', '$iowSdate', '$iowCdate', 'maintenance', '$todat', '', '', 'y','0','$thePosition')";
$sqlrunItemData=mysqli_query($db, $sqliow);


	
if($maintenanceType=="p"){
	$equipmentItemCode=$equipmentItemCode ? $equipmentItemCode : $eqItemCode;
	$measureUnit=getEqLocalUnit($equipmentItemCode);
	
	$sqliow="INSERT INTO eqmaintenance (pcode, iowCode, iowDes, eqItemCode, maintenanceType, edate, maintenanceFrequency, measureUnit, attachPDF, attachIMG, eqmStatus, position, dt  )
	 VALUES ('$pcode', '$iowCode', '$iowDes', '$equipmentItemCode', '$maintenanceType', '$todat',  '$IterationFrequency', '$measureUnit', '$attachPDF', '$attachIMG', 'Not Ready', '$thePosition','$_SESSION[diagonosisID]')";
// 	echo $sqliow;
// 	exit;
	$sqlruniow=mysqli_query($db, $sqliow);
	
	
	
	
}

elseif($maintenanceType=="o" || $maintenanceType=="b" || $maintenanceType=="tr"){
	$breakDownSql="insert into eqmaintenance (pcode,iowCode,iowDes,eqItemCode,eqID,maintenanceType,edate,maintenanceFrequency,measureUnit,attachPDF,attachIMG,eqmStatus,position,dt) value ('$pcode', '$iowCode', '$iowDes', '$eqItemCode','$eqID', '$maintenanceType', '$todat', '$IterationFrequency', '$measureUnit', '$attachPDF', '$attachIMG', 'Not Ready', '$headPos','$_SESSION[diagonosisID]')";
	$sqlEQmaintenance=mysqli_query($db, $breakDownSql);
}


$sqlitem = "INSERT INTO `itemlist` (itemCode, itemDes, itemSpec, itemUnit, iowSales,GLsit,GLsales,GLinventory, GLcost,itemType)"." VALUES ('$itemCode', '$iowDes', '', '$iowUnit', '','','', '', '','')";
//echo  $sqlitem;
$sqlrunItem=mysqli_query($db, $sqlitem);
	
	
//echo $sqliow;
if(mysqli_affected_rows($db)>0)echo "<h1>IOW has been created.</h1>";
else echo "<h1>Error while create IOW</h1>";
}
?>
<?
if(!$Go){
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

if($loginDesignation=='Project Engineer')
 $sqlp = "SELECT pcode,pname from `project` where pcode='$loginProject'";
else
 $sqlp = "SELECT pcode,pname from `project` ORDER by pcode ASC";
 //echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
?>

<table align="center" width="800"  border="1" bordercolor="#E4E4E4" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
	<tr bgcolor="#EEEEEE">
 <td align="center" colspan="2"><b>Enter New Item of Work  (IOW)</b></td>
</tr>

<form action="./index.php?keyword=New+Maintenance+IOW" method="post">	
	<tr>
		<td>Maintenance Type: 
			<input type="radio" name="maintenanceType" value='b' id="mB" <?php echo ($maintenanceType=="b" || !$maintenanceType) ? "checked" : ""; ?>> Breakdown
			<input type="radio" name="maintenanceType" value='tr' id="mT" <?php echo $maintenanceType=="tr" ? "checked" : ""; ?>> Troubled Running
			<input type="radio" name="maintenanceType" value='o' id='mO' <?php echo $maintenanceType=="o" ? "checked" : ""; ?>> Overhauling
			<input type="radio" name="maintenanceType" value='p' id='mP' <?php echo $maintenanceType=="p" ? "checked" : ""; ?>> Preventive
		</td>
	 <td align="right" ><input type="submit" name="maintenanceTypeSelected" value="Show"></td>
	</tr>
</form>
	
</table>
<? } if($maintenanceType){ ?>
	<form name="selectEquipment" action="./index.php?keyword=New+Maintenance+IOW" method="post">
<?php echo "<input type='hidden' name='projectName' value='$projectName'>"; ?>

<table align="center" width="800"  border="1" bordercolor="#E4E4E4" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<?php  
if($maintenanceType=="p")$projectName="004";

if($maintenanceType!="p"){
?>
<form name="selectProject" action="./index.php?keyword=New+Maintenance+IOW" method="post">
<?php
	echo "<input type='hidden' name='maintenanceType' value='$maintenanceType'>";
?>
<tr>
 <td>Select Project <select name="projectName">
<? while($typel= mysqli_fetch_array($sqlrunp))
{
 echo "<option value='".$typel[pcode]."'";
echo $projectName==$typel[pcode] ? " selected " : "";
 echo ">$typel[pcode]--$typel[pname]</option>  ";
 }
?>
</select>
</td>
 <td align="right" ><input type="submit" name="pcode" value="Select Project"></td>
</tr>
</form>
<?php 
}
?>
<style>
tr#allEqBreakdown,tr#allEqRow,tr#allEqItemCodeRow{}
</style>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#b").change(function(){
				var b=$(this);
				var o=$(this);
				var p=$(this);
			});
		});
	</script>
<form name="selectEquipment" action="./index.php?keyword=New+Maintenance+IOW" method="post">
<?php
	echo "<input type='hidden' name='projectName' value='$projectName'>";
	echo "<input type='hidden' name='maintenanceType' value='$maintenanceType'>";
//if()
?>

<?php if($maintenanceType=="b" || $maintenanceType=="tr"){ ?>
<tr id="allEqBreakdown">
 <td>Select Equipment: <select name="equipmentID">
<?	
	$eqSql="select e.itemCode,e.assetId,i.itemDes from equipment e,itemlist i where location='$projectName' and i.itemCode=e.itemCode order by i.itemCode asc";
	$eqQ=mysqli_query($db,$eqSql);
// 	echo $eqSql;
while($eqRow= mysqli_fetch_array($eqQ))
{
 echo "<option value='$eqRow[assetId]"."_"."$eqRow[itemCode]'";
 echo ($equipmentID==$eqRow[assetId]."_".$eqRow[itemCode]) ? " selected " : "";
 echo ">$eqRow[itemCode]$eqRow[assetId]--$eqRow[itemDes]</option>  ";
}
?>
</select>
</td>
<td align="right">
<input type="submit" name="pcode" value="Select Equipment">
</td>
</tr>
<?php }if($maintenanceType=="o" || $maintenanceType=="p"){ ?>
<tr id="allEqRow">
 <td>Equipment <?php echo $maintenanceType=="p" ? "Group" : ""; ?>: <select name="equipmentID">
<?	
	$eqSql="select e.itemCode,e.assetId,i.itemDes,i.itemSpec from equipment e,itemlist i where /*location='$projectName' and*/ i.itemCode=e.itemCode group by e.itemCode";
$eqQ=mysqli_query($db,$eqSql);
// 	echo $eqSql;
while($eqRow= mysqli_fetch_array($eqQ)){ 
 echo "<option value='$eqRow[assetId]"."_"."$eqRow[itemCode]'";
 echo ($equipmentID==$eqRow[assetId]."_".$eqRow[itemCode]) ? " selected " : "";
 echo ">$eqRow[itemCode] - $eqRow[itemDes],  $eqRow[itemSpec]</option>";
}
?>
</select>
</td>
 <td align="right" ><input type="submit" name="pcode" value="Select Equipment"></td>
</tr>
<?php }
/* if($maintenanceType=="p"){ ?>
<tr id="allEqItemCodeRow">
 <td>Select Equipment Group: <select name="equipmentItemCode">
<?	
	$eqSql="select e.itemCode,i.itemDes from equipment e,itemlist i where i.itemCode=e.itemCode order by e.itemCode";
	$eqQ=mysqli_query($db,$eqSql);
// 	echo $eqSql;
while($eqRow= mysqli_fetch_array($eqQ))
{
 echo "<option value='$eqRow[itemCode]'";
 echo ($equipmentItemCode==$eqRow[itemCode]) ? " selected " : "";
 echo ">$eqRow[itemCode]--$eqRow[itemDes]</option>  ";
}
?>
</select>
</td>
 <td align="right" ><input type="submit" name="pcode" value="Select Equipment"></td>
</tr>
<?php }
*/ // 	=============================================== preventive
	?>
</table>
</form>
<?php
//maintenance has been selected
?>
<?php
}
if(($projectName || $maintenanceType=="p") && ($equipmentID || $equipmentItemCode)){ ?>
 <form name="selectEquipment" action="./index.php?keyword=New+Maintenance+IOW" method="post">
<?php	
	echo "<input type='hidden' name='projectName' value='$projectName'>";
	echo "<input type='hidden' name='maintenanceType' value='$maintenanceType'>";
	echo "<input type='hidden' name='equipmentID' value='$equipmentID'>";
	echo "<input type='hidden' name='equipmentItemCode' value='$equipmentItemCode'>";
	?>
<table align="center" width="800"  border="1" bordercolor="#E4E4E4" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr>
	<?php $allMaintenanceHead=allMaintenanceItem($maintenanceType); ?>
 <td>Head: <input type='text' name="headPos" value='<?php echo $allMaintenanceHead; ?>' readonly>

</select>
</td>
	<td align="right"><input type="submit" name="pcode" value="Select Head"></td>
</tr>
</table>
</form>
<?php } ?>
<?
		if(($projectName) && ($equipmentID || $equipmentItemCode) && $headPos){?>
<form name="form_iow" action="./index.php?keyword=New+Maintenance+IOW" method="post"  enctype="multipart/form-data">	
	<?php	
	echo "<input type='hidden' name='projectName' value='$projectName'>";
	echo "<input type='hidden' name='maintenanceType' value='$maintenanceType'>";
	echo "<input type='hidden' name='equipmentID' value='$equipmentID'>";
	echo "<input type='hidden' name='equipmentItemCode' value='$equipmentItemCode'>";
	echo "<input type='hidden' name='headPos' value='$headPos'>";
	?>	
<style>
h1, h1 a, h2, h2 a, h3, h3 a {
	margin: 0;
	text-decoration: none;
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	color: #444444;
}
h1 {
	letter-spacing: -3px;
	font-size: 2.6em;
}
h2 {
	letter-spacing: -2px;
	font-size: 2em;
}
h3 {
	font-size: 1em;
}
.form{
    width:800px;
	margin:0 auto;
	background: #FFF url(./project/images/img05.gif) repeat-x;
}
.form .title {
	background: url(./project/images/img07.gif) no-repeat right top;
	height:85px;
}
.form .title h2 {
	padding: 30px 30px 0 30px;
	background: url(./project/images/img06.gif) no-repeat;
	font-size: 2.2em;
}
.form .entry {
}
.form .links {
	margin: 0;
	padding: 20px;
	background: url(./project/images/img15.gif) no-repeat left bottom;
	height:60px;
	text-align:center;
	
}/*
.form input {
	padding: 0;

	height: 29px;
	background: #DFDFDF url(./project/images/img14.gif) repeat-x;
	font-weight: bold;
}*/
.form .s {
	padding: 5px;
	width: 150px;
	height: auto;
	background: #FEFEFE url(./project/images/img13.gif) repeat-x;
	border: 1px solid #626262;
	font: normal 1em Arial, Helvetica, sans-serif;
}

.form .s1 {
	padding: 5px;
	height: auto;
	background: #FEFEFE url(./project/images/img14.gif) repeat-x;
	border: 1px solid #626262;
	font-weight: bold;
}
</style>

<div class="form">
<div class="entry">
<table width="800" align="center"  class="1blue" border="0" cellpadding="5" >

<?php if($equipmentID){ ?>
<tr><td colspan="2" height="1" bgcolor="#F8F8F8"></td></tr>
<tr><td>Position: </td>
	<?php
	$iowProjectCode="004";
	$availablePos=generateNewPosition($headPos,$iowProjectCode);
?>
<td >
<?php
?>
<input type="text" name="thePosition" maxlength="15" value="<?php echo $availablePos; ?>" alt="req" title="Please input a position." class="s" readonly>
</td>
</tr>
<tr><td>Finished Product Inventory Code: </td>
	<?php include_once("./checkInventory.php"); ?>
    <td ><input type="text" name="itemCode" readonly value="<?php echo $fullFormatCode; ?>" alt="req" title="Finished Product Inventory Code" class="s"><a href="./project/fnishProductCode.php" target="_blank"> All code</a> <small style="color:#666;"><i>Inventory code may have been used!</i></small></td>
</tr>
<?php } ?>
	

<tr><td colspan="2" height="1" bgcolor="#F8F8F8"></td></tr>
<tr>
  <td>Maintenance IOW Code</td><td>
	<input type="text" name="iowCode" cols="35"  class="s">
	</td>
</tr>	

<tr><td colspan="2" height="1" bgcolor="#F8F8F8"></td></tr>
	
	<tr>
<td>
Is this a repeat Failure:
<select name='repeatFailure' id='repeatFailure' style="min-width: 44px;">
  <option value='no'>No</option>
  <option value='yes'>Yes</option>
</select>
	<p id="lastHappenContainer">
Last happened on:
  <select name="repeatFailureTxt" id="repeatFailureTxt">  
    <option value=''></option>  
    <?php
	if(count($eqIdCombo)>0){
    $eqID=explode("_",$eqIdCombo);
      $eqSql="select edate,iowCode,iowDes form eqmaintenance where eqItemCode='$eqID[1]' and eqID='$eqID[0]' and iowCode in (SELECT * FROM iow where iowStatus like '%completed%')";
      $eqQ=mysql_query($db,$eqSql);
      while($eqRow=mysqli_fetch_array($eqQ)){
        echo "<option value='$eqRow[edate]'>$eqRow[iowCode]: $eqRow[iowDes]</option>";
      } 
	} 
    ?>
  </select>
	</p>
</td>
</tr>
	
<tr>
  <td>Maintenance Work Name</td><td>
	<input type="text" name="iowDes" list="itemDes"  cols="35"  class="s">
	<datalist id="itemDes">
	<?php
	$sql_iow_des="select iowDes from iow where position like '999.100.___.___' and iowStatus!='noStatus'";
	$iow_q=mysqli_query($db,$sql_iow_des);
	while($iow_row=mysqli_fetch_array($iow_q)){
		echo "<option value=\"$iow_row[iowDes]\" data-val=\"$iow_row[iowDes]\">";
	}
	?>
	</datalist>
	</td>
</tr>


<?php if($equipmentID && $maintenanceType!="p"){?>
<tr><td colspan="2" height="1" bgcolor="#F8F8F8"></td></tr>
<tr>
  <td colspan='2' align=''><a href='./index.php?keyword=New+Diagnosis+INFO&eqIdCombo=<?php echo $equipmentID; ?>' target='_blank'>Diagnosis &amp; Treatment</a></td>
</tr>
<tr><td colspan="2" height="1" bgcolor="#F8F8F8"></td></tr>
<tr>
  <td>Attach PDF File</td><td>
	<input type="file" name="pdf_file" cols="35"  class="s">
	</td>
</tr>
<tr><td colspan="2" height="1" bgcolor="#F8F8F8"></td></tr>
<tr>
  <td>Attach Image</td><td>
	<input type="file" name="image_file" cols="35"  class="s">
	</td>
</tr>
<?php }?>	

<tr><td colspan="2" height="1" bgcolor="#F8F8F8"></td></tr>
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
<?php 
		if($equipmentItemCode)$mUnit=getEqLocalUnit($equipmentItemCode);
		elseif($eqItemCode)$mUnit=getEqLocalUnit($eqItemCode);
		
		if(!$mUnit){echo "<h1>This equipment has no production measurement unit.</h1>";exit;}
		$cc = measuerUnti();
		$mUnitFullname=$cc[$mUnit];
?>
	<input type="hidden" name="mUnit" value="<?php echo $mUnit; ?>">
	
<?php if($maintenanceType=="p"){ ?>
<tr>
  <td>Maintenance Frequency</td>
  <td>
		<input type="number" class="s" name="IterationFrequency"  alt="req" title=""> 
<?php echo $mUnitFullname; ?>
  </td>
</tr>
<tr><td colspan="2" height="1" bgcolor="#F8F8F8"></td></tr>
<?php }?>

<?php if($equipmentID){ ?>
<tr>
  <td>Expected Date of Starting</td>
      <td><input type="text" class="s" name="iowSdate"  readonly="" alt="req" title="IOW Start Date"> <a id="anchor" href="#"
   onClick="cal.select(document.forms['form_iow'].iowSdate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a>
      </td>
</tr>
<tr><td colspan="2" height="1" bgcolor="#F8F8F8"></td></tr>
<tr>
  <td>Expected Date of Completion</td>
  <td><input name="iowCdate" class="s" readonly="" alt="req" title="IOW Completion Date">
		<a id="anchor11" href="#"
   onClick="cal.select(document.forms['form_iow'].iowCdate,'anchor11','dd/MM/yyyy'); return false;"
   name="anchor2"><img src="./images/b_calendar.png" alt="calender" border="0"></a>
   </td>
</tr>
<tr><td colspan="2" height="1" bgcolor="#F8F8F8"></td></tr>
<!-- <tr>
  <td>Duration</td>
  <td><input name="duration" class="s" alt="req" title="Duration">
   </td>
</tr> -->
<?php } ?>
<!-- <tr>
 <td>IOW type</td>
 <td><input type="radio" name="iowType" value="1" checked>Invoiceable
 <input type="radio" name="iowType" value="2">Non Invoiceable</td>
</tr> -->
</table>
</div>
			<p class="links"><input type="button" name="btniow" value="Enter New Item of Work" 
  onClick="if(checkrequired(form_iow)) {form_iow.iow.value=1;form_iow.submit();}" class="s1">
  <input type="hidden" name="iow" value="0"></p>

</div>
<input type="hidden" name="iowProjectCode" value="<? echo $projectName;?>">
<input type="hidden" name="iowStatus" value="Not Ready">
</form>
<? }?>

<script type="text/javascript">
    $("#lastHappenContainer").hide(); 
  

  $("select#repeatFailure").change(function(){
		console.log($(this).attr("value"));
    if($(this).find("option:selected").attr("value")=="yes"){
      $("#lastHappenContainer").show();}
    else
      $("#lastHappenContainer").hide();      
  });
</script>



<div id=testdiv1
      style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
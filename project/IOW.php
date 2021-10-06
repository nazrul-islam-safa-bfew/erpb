<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
<?
if($iow){
	$format="Y-m-j";
	
	$sdate_exp=explode("/",$iowSdate);
	$iowSdate=$sdate_exp[2]."-".$sdate_exp[1]."-".$sdate_exp[0];
	
	$sdate_exp=explode("-",$iowCdate);
	$iowCdate=$sdate_exp[2]."-".$sdate_exp[1]."-".$sdate_exp[0];

	
if(compare_startdate($iowProjectCode,$iowSdate)){
	echo "<h1>IOW start date should not before the project start date.</h1>";
	exit;
}

include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

$temp=itemDes($itemCode);

include_once("./checkInventory.php");
$itemCode=$fullFormatCode;

$sqliow = "INSERT INTO iowtemp (iowProjectCode,itemCode, iowCode, iowDes, iowQty, iowUnit,
 iowPrice, iowTotal, iowType, iowSdate, iowCdate, iowStatus, iowDate, Prepared, Checked, Approved,revision  )
 VALUES ('$iowProjectCode', '$itemCode','$iowCode', '$iowDes', '$iowQty', '$iowUnit',
  '$iowPrice', '$iowPrice*$iowQty', '$iowType', '$iowSdate', '$iowCdate', '$iowStatus', '$todat', '', '', 'y','0'  )";
// echo $sqliow;
$sqlruniow= mysqli_query($db, $sqliow);

$sqlitem = "INSERT INTO `itemlist` (itemCode, itemDes, itemSpec, itemUnit, iowSales,GLsit,GLsales,GLinventory, GLcost,itemType)".
 "VALUES ('$itemCode', '$iowDes', '', '$iowUnit', '','','', '', '','')";
//echo  $sqlitem;
$sqlrunItem= mysqli_query($db, $sqlitem);
}
 ?>
<?
if(!$Go){
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
	
$loginProject = trim($loginProject);
	
if($loginDesignation=='Project Engineer')
 $sqlp = "SELECT pcode,pname from `project` where pcode='$loginProject'";
else
 $sqlp = "SELECT pcode,pname from `project` ORDER by pcode ASC";
echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
?>
<form name="selectProject" action="./index.php?keyword=enter+item+work" method="post">
<table align="center" width="450"  border="1" bordercolor="#E4E4E4" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#EEEEEE">
 <td align="center" colspan="2"><b>Enter New Item of Work  (IOW)</b></td>
</tr>
<tr>
 <td>Select Project <select name="projectName">
<? while($typel= mysqli_fetch_array($sqlrunp))
{
 echo "<option value='".$typel[pcode]."'";
 echo ">$typel[pcode]--$typel[pname]</option> ";
}

?>
	</select>
</td>
 <td align="right" ><input type="submit" name="Go" value="go"></td>
</tr>
</table>
</form>
<? }?>
<? if($Go){?>
<form name="form_iow" action="./index.php?keyword=enter+item+work" method="post">
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
    width:650px;
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
	padding: 20px 40px 0px 30px;
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
	<div class="title">
		<h2>Enter New Item of Work  (IOW)</h2>
	</div>
<div class="entry">
	<table width="600" align="center"  class="1blue" border="0" cellpadding="5" >
<tr>
 <td>Selected Project</td>
  <td><? echo myprojectName($projectName).' ['.$projectName.']';?></td>
</tr>
<tr><td colspan="2" height="1" bgcolor="#F8F8F8"></td></tr>
<tr>
  <td >Item of Work Code</td> <td><input name="iowCode" width="8" size="8"  maxlength="8" class="s"> Max. 8 digites</td>
</tr>
<tr><td colspan="2" height="1" bgcolor="#F8F8F8"></td></tr>
<tr><td>Finished Product Inventory Code: </td>
	<?php include_once("./checkInventory.php"); ?>
    <td ><input type="text" name="itemCode" readonly value="<?php echo $fullFormatCode; ?>" alt="req" title="Finished Product Inventory Code" class="s"><a href="./project/fnishProductCode.php" target="_blank">All code</a> <small style="color:#666;"><i>Inventory code may have expired!</i></small></td>
</tr>
<tr><td colspan="2" height="1" bgcolor="#F8F8F8"></td></tr>

<tr>
  <td>Item of Work Description</td> <td><textarea name="iowDes"  cols="35"  class="s" required></textarea></td>
</tr>
<tr><td colspan="2" height="1" bgcolor="#F8F8F8"></td></tr>
				
<tr>
 <td>IOW type</td>
<td><input type="radio" name="iowType" value="1" checked class="iowType" required>Invoiceable
 <input type="radio" name="iowType" value="2" class="iowType" required>Non Invoiceable</td>
</tr>
		
<tr><td colspan="2" height="1" bgcolor="#F8F8F8"></td></tr>
		
<tr>
  <td>Quantity</td> <td><input name="iowQty" class="s" required></td>
</tr>
<tr><td colspan="2" height="1" bgcolor="#F8F8F8" required></td></tr>
<tr>
  <td>Unit</td> <td><input name="iowUnit" class="s" required></td>
</tr>
<tr><td colspan="2" height="1" bgcolor="#F8F8F8"></td></tr>
<tr>
  <td>Price</td> <td><input name="iowPrice" id="iowPrice" class="s"></td>
</tr>
<tr><td colspan="2" height="1" bgcolor="#F8F8F8"></td></tr>
<tr>
  <td>Total</td> <td><input name="iowTotal" id="iowTotal" class="s"></td>
</tr>
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

<tr>
  <td>IOW Expected Date of Starting
		<br>
		<?php $project_date=get_project_create_date($projectName,true); ?><small>Project start date: <font color='#00f'><?= $project_date ?></font>
		</small></td>
				
      <td>
				<input type="text" class="s" name="iowSdate"  readonly="" alt="req" title="IOW Start Date"><a id="anchor" href="#"
   onClick="cal.select(document.forms['form_iow'].iowSdate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor"><img src="./images/b_calendar.png" alt="calender" border="0"></a>
      </td>
</tr>
<tr><td colspan="2" height="1" bgcolor="#F8F8F8"></td></tr>
<tr>
  <td>Expected Date of Completion</td>
  <td><input name="iowCdate" class="s" readonly="" alt="req" title="IOW Completion Date"> <a id="anchor11" href="#"
   onClick="cal.select(document.forms['form_iow'].iowCdate,'anchor11','dd/MM/yyyy'); return false;"
   name="anchor2"><img src="./images/b_calendar.png" alt="calender" border="0"></a>
   </td>
</tr>
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
<script>
$(document).ready(function(){
	$("input.iowType").click(function(){
		if($(this).val()==2){
			$("#iowPrice").prop("disabled",true).val("");
			$("#iowTotal").prop("disabled",true).val("");
		}else{
			$("#iowPrice").prop("disabled",false).val("");
			$("#iowTotal").prop("disabled",false).val("");			
		}
	});
});
</script>

<div id=testdiv1
      style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
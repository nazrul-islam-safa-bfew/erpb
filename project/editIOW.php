<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script type="text/javascript" src="./js/jquery.mask.js"></script>
<? 
$iowProjectCode=$_POST["iowPCode"];
$saveAsHeading=$_POST["saveAsHeading"];


	if($iowDelete){
		$sql="delete from iowtemp where iowId='$iowDelete' and iowStatus='noStatus' limit 1;";
		mysqli_query($db, $sql);
		$delete_row1=mysqli_affected_rows($db);
		$sql="delete from iow where iowId='$iowDelete' and iowStatus='noStatus' limit 1;";
		mysqli_query($db, $sql);
		$delete_row2=mysqli_affected_rows($db);
		
		if($delete_row1>0 || $delete_row2>0)echo "Delete successfully";
		echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=./index.php?keyword=pmview+IOW&status=Not+Ready\">";
		exit();
	}


if($editiow || ($iowProjectCode && $position && $iowDes)){
$format="Y-m-j";
$iowSdate1 = formatDate($iowSdate,$format);
$iowCdate1 = formatDate($iowCdate,$format);

include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

	
	if(strlen($position)!=15 and substr_count($position)!=4){echo "Iow Position not match."; exit;}
	
	   if((is_position_already_used($position,$iowProjectCode,$iowId) || is_position_already_used_in_temp($position,$iowProjectCode,$iowId))){
     echo $position." failed! Position already exists.";
     exit();
   }

	
if($iowProjectCode && $saveAsHeading){
	
	if((is_position_already_used($position,$iowProjectCode) || is_position_already_used_in_temp($position,$iowProjectCode))){
     echo $position." failed! Position already exists.";
     exit();
   }
	
	$sqliow = "insert into iow SET iowDes='$iowDes', iowProjectCode='$iowProjectCode',  position='$position', 	iowCode='$position', iowStatus='noStatus', siow=''";	//save as iow description
	$sqlruniow= mysqli_query($db, $sqliow);
	$sqliow = "insert into iowtemp SET iowDes='$iowDes', iowProjectCode='$iowProjectCode',  position='$position', 	iowCode='$position', iowStatus='noStatus', siow=''";	//save as iow description
	$sqlruniow= mysqli_query($db, $sqliow);
	if(mysqli_affected_rows($db)<1){
		$sqliow = "update iowtemp SET iowDes='$iowDes',   position='$position', 	iowStatus='noStatus', siow='' where iowProjectCode='$iowProjectCode' and iowCode='$position'";	//save as iow description
		$sqlruniow= mysqli_query($db, $sqliow);
		$sqliow = "update iow SET iowDes='$iowDes',   position='$position', 	iowStatus='noStatus', siow='' where iowProjectCode='$iowProjectCode' and iowCode='$position'";	//save as iow description
		$sqlruniow= mysqli_query($db, $sqliow);
	}
}else{
	 $upper_position=getUpperHeadPosition($position);
   $isHead=isHeadorSubhead($upper_position,$iowProjectCode); //you can't make place a iow into another iow. find head or sub head to assign it.
	if(!$isHead){
		echo "Please find a appropriate head to assign a iow.";
	  $sqliow=null;
	}
	else{
		$sqliow = "UPDATE iowtemp SET iowCode='$iowCode', iowQty='$iowQty', iowUnit='$iowUnit',iowDes='$iowDes',".
                          "iowPrice='$iowPrice', iowType='$iowType', iowSdate='$iowSdate1',iowCdate='$iowCdate1',".
						  "iowStatus='$iowStatus', iowDate='$todat', Prepared='', Checked='',".
						  "Approved='$Approved', position='$position' WHERE iowId=$iowId";
		//echo "$sqliow<br>";
		$expItemCode=explode("-",$itemCode);
		if($expItemCode[0]=="98"){
			$sqlruniow= mysqli_query($db, $sqliow);
			mysqli_query($db, "UPDATE itemlist set itemDes='$iowDes' where itemCode='$itemCode'");
		}
		
		$updateSql="UPDATE itemlist set itemDes=\'$iowDes\' where itemCode=\'$itemCode\'";	
		$tracSql="insert into tracing_history (des,sql_,date_time) values ('$loginDesignation, $iowId, $iowCode', '$updateSql', 'now()')";
		mysqli_query($db,$tracSql);
		
	
	}
}
//echo mysql_error();

	if(mysqli_affected_rows($db)>0){
		echo "Updating Please Wait.....";
	}
	echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=./index.php?keyword=pmview+IOW&status=Not+Ready\">";
	
}
 ?>

<? 
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

$sqliow = " SELECT * FROM iowtemp where iowId=$iowId";
//echo $sqliow;
$sqlruniow= mysqli_query($db, $sqliow) OR die(" Sorry Please try later!!");
$result= mysqli_fetch_array($sqlruniow);


?>
<form name="form_iow" action="./index.php?keyword=editIOW&iowId=<? echo $iowId;?>" method="post">
<table align="center"  class="blue" cellpadding="5" >
<tr bgcolor="#E4E4E4">
 <td align="center" colspan="2" class="blueAlertHd">Enter New Item of Work  (IOW)</td>
</tr>
<tr>
 <td>Selected Project</td>
  <td><? echo myprojectName($result[iowProjectCode]).' ['.$result[iowProjectCode].']';?></td>
	
  <input type="hidden" name="iowPCode" value="<?php echo $result[iowProjectCode]; ?>">
</tr>

<tr bgcolor="#F8F8F8">
  <td >Item of Work Code</td> <td><input type="text" name="iowCode" value="<? echo $result[iowCode];?>"></td> 
</tr>
<tr>
  <td>Finished Product Inventory Code: </td><td id="clear_code"><? echo $result[itemCode];?> <input type="hidden" name="itemCode" value="<? echo $result[itemCode];?>" /></td>
</tr>
<tr>
  <td>Item of Work Description</td> <td>
  <textarea name="iowDes"  cols="35"><? echo $result[iowDes];?></textarea></td>   
</tr>

<tr bgcolor="#F8F8F8">
  <td>Quantity</td> <td><input  type="text" name="iowQty" value="<? echo $result[iowQty];?>"></td> 
</tr>

<tr>
  <td>Unit</td> <td><input type="text" name="iowUnit" value="<? echo $result[iowUnit];?>"></td> 
</tr>
<!-- Noninvoiceable task should not be use iowPrice & iowTotal  -->
<?php if($result[iowType]=='1'){ ?> 
<tr bgcolor="#F8F8F8">
  <td>Price</td> <td><input type="text" name="iowPrice" value="<? echo $result[iowPrice];?>"></td> 
</tr>
<tr>
  <td>Total</td> <td><input type="text" name="iowTotal" value="<? echo $result[iowPrice]*$result[iowQty];?>"></td> 
</tr>
<?php }?>
	
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
  <td>Planned Date of Starting</td> 
      <td><input type="text" maxlength="10" name="iowSdate" value="<? echo date("j/m/Y",strtotime($result[iowSdate]));?>" readonly="">  
 <? if($loginDesignation=='admin' || $loginDesignation=='Manager Planning & Control' || $loginDesignation=='Project Engineer' || $loginDesignation=='Equipment Co-ordinator'){?><a id="anchor1" href="#" 
   onClick="cal.select(document.forms['form_iow'].iowSdate,'anchor1','dd/MM/yyyy'); return false;"
   name="anchor1"><img src="./images/b_calendar.png" alt="calender" border="0"></a> 	  
   <?  }?>
	   </td> 
</tr>

<tr>
  <td>Expected Date of Completion</td> 
  <td><input type="text" name="iowCdate" maxlength="10" value="<? echo date("j/m/Y",strtotime($result[iowCdate]));?>" readonly="" alt="req" title="IOW Completion Date"> <a id="anchor11" href="#"
   onClick="cal.select(document.forms['form_iow'].iowCdate,'anchor11','dd/MM/yyyy'); return false;"
   name="anchor2"><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
   </td> 
</tr>
<tr>
  <td>Position</td> 
  <td><input type="text" name="position" maxlength="21" value="<? echo $result[position]?$result[position]:"";?>" id="position" placeholder="999.999.999.999"> 
   </td> 
</tr>
<tr bgcolor="#F8F8F8">
 <td>IOW type</td>
 <td><input type="radio" name="iowType" value="1" <? if($result[iowType]=='1') echo "checked"; ?> >direct
 <input type="radio" name="iowType" value="2"  <? if($result[iowType]=='2') echo "checked"; ?> >indirect </td>
</tr>

<tr>
  <td align="center" colspan="2">  
  <input type="button" name="btneditiow" value="Edit Item of Work"  onClick="if(checkrequired(form_iow)) {form_iow.editiow.value=1;form_iow.submit();}">
  <input type="submit" name="saveAsHeading" value="Save As Heading"  onClick="">
  <input type="reset" name="reset" value="Clear" id="Clear">
  <input type="button" name="Delete" value="Delete" id="Delete" onclick="window.location.href='./index.php?keyword=editIOW&iowDelete=<?php echo $result[iowCode].";".$result[iowProjectCode].'&iowId='.$iowId;?>'">
  <input type="hidden" name="editiow" value="0">
  </td> 
</tr>
</table>
<input type="hidden" name="iowProjectCode" value="<? echo $projectName;?>">
<input type="hidden" name="iowStatus" value="Not Ready">
</form>

<div id=testdiv1
      style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>

<script type="text/javascript">
$(document).ready(function(){
  $('#position').mask("999.999.999.999");
	
	$("#Clear").click(function(){
		
		//console.log
		
		pos=$("input[name='position']").val();//get position		
		$("input[type='text']").val("");
		$("input[name='position']").val(pos); //assign position
		$("#clear_code").html("");
		$("input[type='radio']").prop("checked",false);
		
		
return false;
	});
	
});
	
	function clear_form(){
	
		
	
		
	}
</script>
<?php
error_reporting(0);
if($_SESSION[jQuery]!=1){
	$_SESSION[jQuery]=1;
	echo '<script type="text/javascript">window.location.reload();</script>';
}
// $iow[]=6613;
?>
<form name="gooo" action="./graph/alliow.g.php"	 method="post" target="_blank">
<table align="center" width="98%" border="0" bgcolor="#FFCCCC" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
<!-- <tr>
<td>Progress Report in Graph</td>
<? if($loginDesignation=='Manager Planning & Control' OR $loginDesignation=='Managing Director' OR $loginDesignation=='Director' OR $loginDesignation=='Chairman & Managing Director'){?>
<td >Project : <select name="gproject">
<?

$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
include($localPath."/includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$sqlppg = "SELECT * from `project` ORDER  by pcode ASC";
//echo $sqlp;
$sqlrunppg= mysqli_query($db, $sqlppg);
while($typelpg= mysqli_fetch_array($sqlrunppg))
{
 echo "<option value='".$typelpg[pcode]."'";
 if($projectg==$typelpg[pcode]) echo " selected ";
 echo ">$typelpg[pcode]--$typelpg[pname]</option> ";
}
?>
 </select>
</td>
<? }
else echo "<input type=hidden name=gproject value=$loginProject>";
?>

<td><input type="radio" name="r" value="1" checked>ALL Task</td>
<td><input type="radio" name="r" value="2">ALL Task with Sub Task</td>
<td >
<input type="submit" name="go" value="View Graph">	 
</td>
</tr> -->
</table>
</form>

<?php
$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
include($localPath.'/project/siteMaterialReportEntry.f.php');
include($localPath.'/project/siteDailyReport.f.php');
include($localPath.'/project/findProject.f.php');
?>

	<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
<form name="goo" action="./index.php?keyword=site+daily+report"	 method="post">
<table align="center" width="98%" border="1" bgcolor="#FEF5F1" bordercolor="#99CC99" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
<tr>
	<SCRIPT LANGUAGE="JavaScript">
	var now = new Date(); 
	var cal = new CalendarPopup("testdiv1");
    	//cal.showNavigationDropdowns();
		cal.setWeekStartDay(6); // week is Monday - Sunday
		//cal.addDisabledDates(null,formatDate(now,"yyyy-MM-dd")); 
		cal.setCssPrefix("TEST");
		cal.offsetX = 0;
		cal.offsetY = 0;
	</SCRIPT>
	<? if($loginDesignation=='Manager Planning & Control' OR $loginDesignation=='Chairman & Managing Director' OR $loginDesignation=='Managing Director' OR $loginDesignation=='Project Engineer' OR $loginDesignation=='Construction Manager' OR $loginDesignation=='Director') {?>
      <td colspan="1" >
 
	  Project: <select name="project" 
onChange="location.href='index.php?keyword=site+daily+report&project='+goo.project.options[document.goo.project.selectedIndex].value+'&Status='+goo.Status.options[document.goo.Status.selectedIndex].value";>

<?

$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
include($localPath."/includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
	$iowC=0;
	
function rec_all_data($position_setup,$project,$status){
	global $db;
	global $iowCoID;
	global $iowHeadID;
	global $iowC;
	$today=todat();
	$next_sql_pos=sql_position_maker($position_setup);
	$sql="select * from iow where iowProjectCode='$project' and position!='$position_setup' ";
	if(count($iowHeadID)>0)$sql.=" and iowId not in (".implode(",",$iowHeadID).")";
	
	if($status)$sql.=" and ((";
	if($status=="Not-Started")$sql.=" iowSdate>'$today' ";
	if($status=="Started")$sql.=" iowSdate<='$today' and iowStatus!='Completed'  ";
	if($status=="completed")$sql.=" iowStatus='Completed' ";
	if($status)$sql.=" ) or (iowStatus='noStatus')  )";

	$sql.=" and position like '$next_sql_pos' order by position"; 
// 	echo $sql;
	$q=mysqli_query($db,$sql);
	$iowC+=mysqli_affected_rows($db);
		while($pos_row=mysqli_fetch_array($q)){
			if(in_array($typel[iowId],$iowCoID))continue;
			$position=count_dot_number($pos_row[position]);
			$positionVal=md_IOW_headerFormat($position);
			$pos=explode(".",$pos_row[position]);
			$iowCoID[]=$pos_row[iowId];
			if($pos_row[noStatus]=="noStatus")$iowHeadID[]=$typel[iowId];
			
if($pos_row[iowStatus]=="noStatus"){
	echo "<li s1='$pos[0]' s2='$pos[1]' s3='$pos[2]' s4='$pos[3]' pos='$position'  class='heading' >$positionVal $pos_row[iowDes]</li>";
	rec_all_data($pos_row[position],$project,$status);
}else{
			echo "<li s1='$pos[0]' s2='$pos[1]' s3='$pos[2]' s4='$pos[3]' pos='$position' ";
// 			if($pos_row[iowStatus]=="noStatus")echo " class='heading' rel='$pos_row[iowId]' ";
// 			else 
				echo " class='child' rel='$pos_row[iowId]'  ";
			
				echo ">$positionVal <span style='color:#f00;'>$pos_row[iowCode]</span>: $pos_row[iowDes]</li>";

				// 		iow id collection
				$iowCoID[]=$pos_row[iowId];				
				if($pos_row[noStatus]=="noStatus")$iowHeadID[]=$typel[iowId];
				//		end of iow id collection
}			
		}
} //function rec_all_data
	
	
	
if($loginDesignation=='Project Engineer' OR $loginDesignation=='Construction Manager'){
	$project=$loginProject;
	$sqlpp = "SELECT * from `project` where pcode='$project'  ORDER  by  pcode ASC";
}else
	$sqlpp = "SELECT * from `project`  ORDER  by  pcode ASC";
//echo $sqlp;
$sqlrunpp= mysqli_query($db, $sqlpp);

 while($typelp= mysqli_fetch_array($sqlrunpp))
{
	if($typelp[pcode]=="004"){
		echo "<option value='".$typelp[pcode]."1'";
		if($project==$typelp[pcode]."1") echo " selected ";
		echo ">$typelp[pcode]--Equipment Maintenance Works</option>  ";
	}
 echo "<option value='".$typelp[pcode]."'";
 if($project==$typelp[pcode]) echo " selected ";
 echo ">$typelp[pcode]--";
	if($typelp[pcode]=="004")echo "Equipment Rentals & Non-invoiceable items</option>  ";
	else echo "$typelp[pname]</option>  ";
 }
	
	if($project==$typelp[pcode]."1"){
		$maintenanceExtraCode=" and position like '888.%' ";
		$project="004";
	}else{
		$maintenanceExtraCode="";
	}
?>

 </select>
	
				<input type="button" onclick="location.href='index.php?keyword=site+daily+report&project='+goo.project.options[document.goo.project.selectedIndex].value+'&Status='+goo.Status.options[document.goo.Status.selectedIndex].value" value="Page Reload" /><br />
	
Task Type:
<select name="Status" id="Status">
			<option value="">All Task (<?php echo  iowCounter($project,"",$extraC); ?> Nos)</option>
			<option value="Started" <? if($Status=='Started' || !$Status) echo " selected "; ?>>Active Task (<?php echo  iowCounter($project,"Started",$extraC); ?> Nos)</option>
			<option value="Not-Started" <? if($Status=='Not-Started') echo " selected "; ?>>Not Started Task (<?php echo  iowCounter($project,"Not-Started",$extraC); ?> Nos)</option>
			<option value="completed" <? if($Status=='completed') echo " selected "; ?>>Completed Task (<?php echo  iowCounter($project,"completed",$extraC); ?> Nos)</option>
</select>
	 <br>
			
		<style>
			.task_list{border:1px solid #ccc; width:100%; min-height:150px; background:#fff;}
			.task_list ul{margin: 0; padding:0px; }
			.task_list ul.nth{margin: 0; padding:0px 0px 0px 0px;}
			.task_list ul.nth1{margin: 0; padding:0px 0px 0px 0px;}
			.task_list ul.nth2{margin: 0; padding:0px 0px 0px 0px;}
			.task_list ul.nth3{margin: 0; padding:0px 0px 0px 0px;}
			.task_list ul:first-child{padding: 0px; margin: 0; max-height: 350px;      overflow-y: scroll; }
			.task_list li{list-style: none; cursor: pointer; padding:5px; transition:all .5s; padding:3px;}
/* 			.task_list li.child{display:none;} */
			.task_list li.heading{padding: 5px;    border-left: none;    border-right: none;    box-shadow: 0px 0px 1px 0px #ccc;    font-weight: 800; background: #ffc; color:#00f;  border:1px solid #A99600;}
			.task_list li:hover{background:#ffd7c5; color:#00f; padding-left:8px;}
			.task_list li.heading:hover{background:#fcc; color:#00f; padding-left:10px;}
			.task_list li.child:nth-child(odd){background:#E1E1FF;}
			.upBtn{
				background: url(./images/ud.png) no-repeat;
    background-size: 30px;
    width: 15px;
    height: 15px;
    display:inline-block;
		background-position: -8px -2px; transition:all .5s; cursor:pointer; }
			.downBtn{background:url(./images/ud.png) no-repeat;
    background-size: 30px;
    width: 15px;
    height: 8px;
    display: inline-block;
    background-position: -8px -17px;  transition:all .5s; cursor:pointer; }
			.upBtn:hover{background-size: 35px;}
			.downBtn:hover{background-size: 35px;}
			
			.childFn{    background: #f00 !important;
    color: #fff !important;
    font-weight: 600;
    padding-left: 20px !important;}
				</style>		
				
	<span><i class="upBtn" title="Collapsed"></i></span>  <span><i class="downBtn" title="Expand"></i></span> Select Task: <br>
				
				<div class="task_list">
					<ul>
						<li value="all">All Task</li>
<? 
if($Status=='Not-Started'){
	$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
	include($localPath."/includes/config.inc.php");
			$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
				  
			$sqlp = "SELECT iowId,`iowCode`,iowDes from `iow` WHERE iowProjectCode='$project' and ((iowStatus !='Completed' and iowSdate>'$today') or (iowStatus!='noStatus' and iowDate='0000-00-00' and iowCdate='0000-00-00')) ";
			$sqlrunp= mysqli_query($db, $sqlp);
			$ind=0;
			$text=array();
			while($typel2= mysqli_fetch_array($sqlrunp))
			{
			 //echo $typel2[iowId]."=".A($typel2[iowId],$project,date("Y-m-j"))."=".B($typel2[iowId],$project,date("Y-m-j"))."=".C($typel2[iowId],$project,date("Y-m-j"))."=".D($typel2[iowId],$project,date("Y-m-j"))."=".$typel2[iowCode]."<br>";
				
				//echo found($typel2[iowId],$project,date("Y-m-j"))."-".$typel2[iowCode]."<br>";
				
				$jack=found($typel2[iowId],$project,date("Y-m-j"));
				$test[$ind]=$jack;
				
				//echo "array condition".print_r($text)."<br>";
				$ind++;
			}
			//echo "present array data is".print_r(array_diff($tast,array(" ")))."<br>";
			$remove_null_number = true;
			$new_array = remove_array_empty_values($test, $remove_null_number,$Status);
			
			//echo "two ND present array data is".print_r($new_array)."<br>";
  }
	
	$extraC="";
		if($project=="004"){$extra=" and position not like '888.%' ";$eqM=0;$extraC=" and position not like '888.%' ";}
		elseif($project=="0041"){$project="004";$extra=" and position like '888.000.000.000' ";$eqM=1;$extraC=" and position like '888.%' ";}
		else{$extra=" and position like '___.000.000.000' ";$eqM=0;}
  
  if($Status=='Started'){
	$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
	include($localPath."/includes/config.inc.php");
		$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);


		if(!$eqM && $project!="004")
		{
			$sqlp2 = "SELECT iowId,`iowCode`,iowDes from `iow` WHERE iowProjectCode='$project' and iowStatus !='Completed'  or iowStatus='noStatus' $extra ";
// 		echo $sqlp2;
			$sqlrunp= mysqli_query($db, $sqlp2);
			$ind=0;
			$text=array();
			while($typel2= mysqli_fetch_array($sqlrunp))
			{
				//echo foundf($typel2[iowId],$project,date("Y-m-j"))."-"."<br>";
				$jack=foundf($typel2[iowId],$project,date("Y-m-j"));
				$test2[$ind]=$jack;
				//echo "array condition".print_r($text)."<br>";
				$ind++;
			}
		}  //$eqM
			 //echo "present array data is".print_r(array_diff($tast,array(" ")))."<br>";
			 $remove_null_number = true;
			 $new_array2 = remove_array_empty_values($test2, $remove_null_number);			 
			 //echo "two ND present array data is".print_r($new_array2)."<br>"; 
  }
$today=todat();
$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
include($localPath."/includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

$sqlp="SELECT iowId,iowCode,iowDes,position,iowStatus,iowType from `iow` WHERE iowProjectCode='$project'";
if($Status=='completed'){$sqlp.=" AND ((iowStatus ='Completed'  and iowType=1 and position not like '999%') or iowStatus = 'noStatus') ";}

if($Status=='Not-Started'){
$sqlp.=" AND iowStatus != 'Completed' $extra and ";
// 	if(sizeof($new_array)>0)$sqlp.=" iowId in( ".implode(",",$new_array).") and ";
/*for($i=0; $i< $c=sizeof($new_array); $i++ )
{
							$sqlp.="  iowId=$new_array[$i] "; if($i<($c-1)) $sqlp.=" OR  "; else $sqlp.="";
							//echo "<br>".$c."<br>";
							}	*/
				 			$sqlp.=" ((iowSdate>'$today'  and iowType=1 and position not like '999%') or iowStatus = 'noStatus') and position like '___.000.000.000' ORDER by position ASC ";
}

elseif($Status=='Started'){
/*if($new_array2==true)*/
//if($eqM)$sqlp.=" $extra and position like '___.___.000.000'  ";
$sqlp.=" $extra ";
	
if(sizeof($new_array2))$sqlp.=" and ";
	
for($i=0; $i< $c=sizeof($new_array2); $i++ )
{
							$sqlp.=" iowId=$new_array2[$i] "; if($i<($c-1)) $sqlp.=" OR  "; else $sqlp.="";
							//echo "<br>".$c."<br>";
}			
				 			$sqlp.=" and ((iowStatus != 'Completed' and iowSdate<='$today' and iowType=1 and position not like '999%') or iowStatus = 'noStatus')  ORDER by position ASC";
}
else{
	$sqlp.="  and iowType=1  and position not like '999%' ";
	$sqlp.=" $extra and iowStatus = 'noStatus' ";
	$sqlp.=" ORDER by position,iowStatus ASC";
}

// echo $sqlp;
// exit;
?>
<?

//
$sqlrunp= mysqli_query($db, $sqlp);
$oldPosition="1";
while($typel= mysqli_fetch_array($sqlrunp)){
	
// 	if($typel[iowStatus]=="noStatus")
	{
		$position=count_dot_number($typel[position]);
  	$positionVal=md_IOW_headerFormat($position);
		$pos=explode(".",$typel[position]);
		
		echo "<li s1='$pos[0]' s2='$pos[1]' s3='$pos[2]' s4='$pos[3]' pos='$position'  class='heading' >$positionVal $typel[iowDes]</li>";
			
// 		iow id collection
			$iowCoID[]=$typel[iowId];
			if($typel[noStatus]=="noStatus")$iowHeadID[]=$typel[iowId];
// 		end of iow id collection
	rec_all_data($typel[position],$project,$Status);
	}
 }	
?>
					</ul>
				</div>
				
				
				<script type="text/javascript">
				$(document).ready(function(){
					$(".upBtn").click(function(){
// 					hide element
					$("li[pos='2']").hide();
					$("li[pos='3']").hide();
					$("li[pos='4']").hide();
// 					end of hide element
					});
					$(".downBtn").click(function(){
// 					hide element
					$("li[pos='2']").show();
					$("li[pos='3']").show();
					$("li[pos='4']").show();
// 					end of hide element
					});
					
					
					$(".heading").each(function(){
						var head=$(this);
						
						  var n=0;
							var pos=head.attr("pos");
							var s1=head.attr("s1");
							var s2=head.attr("s2");
							var s3=head.attr("s3");
							var s4=head.attr("s4");

							if(pos==1)
								n=head.parent().find("li[s1='"+s1+"'][s3='000'][s4='000'][pos='"+(parseInt(pos)+1)+"']").length;
							if(pos==2)
								n=head.parent().find("li[s1='"+s1+"'][s2='"+s2+"'][s4='000'][pos='"+(parseInt(pos)+1)+"']").length;
							if(pos==3)
								n=head.parent().find("li[s1='"+s1+"'][s2='"+s2+"'][s3='"+s3+"'][pos='"+(parseInt(pos)+1)+"']").length;							
							
 							head.append("<small style='float:right'>"+n+"</small>");
							
						  if(n==0)
								head.css("color","#585858");

					});
					
					
// 					hide element
					$("li[pos='2']").hide();
					$("li[pos='3']").hide();
					$("li[pos='4']").hide();
// 					end of hide element
					
					$(".heading").click(function(){
						var pos=$(this).attr("pos");
						var s1=$(this).attr("s1");
						var s2=$(this).attr("s2");
						var s3=$(this).attr("s3");
						var s4=$(this).attr("s4");
						if(pos==1)
 							$(this).parent().find("li[s1='"+s1+"'][s3='000'][s4='000'][pos='"+(parseInt(pos)+1)+"']").toggle();
						if(pos==2)
 							$(this).parent().find("li[s1='"+s1+"'][s2='"+s2+"'][s4='000'][pos='"+(parseInt(pos)+1)+"']").toggle();
						if(pos==3)
 							$(this).parent().find("li[s1='"+s1+"'][s2='"+s2+"'][s3='"+s3+"'][pos='"+(parseInt(pos)+1)+"']").toggle();
						
					});
					
// 				checkbox
					$("li.heading input:checkbox").change(function(){
						
					});
					var iowCollection=$("#iowCollection");
					$("li.child").click(function(){ 
						var cli=$(this);
						cli.toggleClass("childFn");
						
						iowCollection.find("option[value='"+cli.attr("rel")+"']").prop("selected",cli.hasClass("childFn"));
					});
// 				end of checkbox
				});
				</script>
				
 	<?php //echo $iowC;?>			
				<select name="iow[]" multiple="multiple" size="7" style="display:none" id="iowCollection"> <option value="all">All Task</option>
<?

//

$sqlp="select iowId,iowCode from iow where iowProjectCode='$project' $extraC";
$sqlrunp= mysqli_query($db, $sqlp);

 while($typel= mysqli_fetch_array($sqlrunp))
{
 echo "<option value='".$typel[iowId]."'";
 if(in_array($typel[iowId],$iow)) echo " selected ";
 echo ">$typel[iowCode]</option>  ";
 }
?>

 </select>
</td> 
<? }
else $project=$loginProject;
?>	  
<td >&nbsp;
<?
if($loginDesignation=='Project Manager')
{?>
Status:<select name="Status">
			<option value="">All</option>
			<option value="Started" <? if($Status=='Started') echo " selected "; ?>>Active</option>
			<option value="Not-Started" <? if($Status=='Not-Started') echo " selected "; ?>>Inactive</option>
			<option value="completed" <? if($Status=='completed') echo " selected "; ?>>Completed</option>
			
</select>
<input name="button" type="button" onclick="location.href='index.php?keyword=site+daily+report&Status='+goo.Status.options[document.goo.Status.selectedIndex].value" value="Page Reload" />
<br />

<?
}


?>



</td>

<td align="left">
	 
<span>Date.:</span>  <input class="yel" type="text" maxlength="10" name="edate" value="<? if($edate=='') echo date("d/m/Y"); else echo $edate;?>" > <a id="anchor" href="#"
   onClick="cal.select(document.forms['goo'].edate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a><br>
	 <br>
<input type="submit" name="go" value="Numeric Report"><br>
	 <div style="padding: 10px;
    display: block;
    margin-top: 5px;
    border-radius: 5px;">
		 <b>Time scale: </b>
		  <input type="radio" name="dateType" value="d" id="dt_d"> Day
		  <input type="radio" name="dateType" value="w" id="dt_w" checked> Week
		  <input type="radio" name="dateType" value="m" id="dt_m"> Month
	 </div>
	 <div style="padding: 10px;
    border: 1px solid #ccc;
    display: inline-block;
    background: #ccc;
    margin-top: 5px;
    border-radius: 5px;
    color: #fff;">
	 <a type="button" name="go" value="" title="./graph/alliow.g.php?gproject=<?php echo $project; ?>" href='#' onClick="dt_=document.getElementById('dt_d').checked ? 'd' : (document.getElementById('dt_w').checked ? 'w' : 'm');window.open(this.title+'&dateType='+dt_+'&taskType='+document.getElementById('Status').value+'&maintenance=<?php echo $eqM; ?>');return false;" target="_blank" style="font-size: 14px;">Bar Chart</a></div>
	</td>
</tr>
<tr>
<? if($loginDesignation=='Manager Planning & Control' OR $loginDesignation=='Chairman & Managing Director' OR $loginDesignation=='Managing Director') {?>	 
 <td colspan="4" bgcolor="#FEF5F1">
	<? } else {?>
	 <td colspan="3" bgcolor="#FEF5F1">
	 <? }?>
		 

		 
		<input type="checkbox" name="chk14" <? if($chk14) echo 'checked'; ?> >Daywork description
		<input type="checkbox" name="chk15" <? if($chk15) echo 'checked'; ?> >Weather interruption
		<input type="checkbox" name="chk16" <? if($chk16) echo 'checked'; ?> >Accident records
		<input type="checkbox" name="chk17" <? if($chk17) echo 'checked'; ?> >Visitors &amp; non-task comments
		<input type="checkbox" name="chk19" <? if($chk19) echo 'checked'; ?> >Expenses
		 <br>
		<input type="checkbox"  name="chk1" <? if($chk1 OR $chk2 OR $chk3 OR $chk4 ) echo 'checked'; ?>>Sub Task Details
		<input type="checkbox" name="chk2" <? if($chk2) echo 'checked'; ?> >Materials Details 
		<input type="checkbox" name="chk3" <? if($chk3) echo 'checked'; ?> >Equipments Details
		<input type="checkbox" name="chk4" <? if($chk4) echo 'checked'; ?> >Labour Details
		<input type="checkbox" name="chk10" <? if($chk10) echo 'checked'; ?> >Change Orders	
<!-- 		<input type="checkbox" name="chk11" <? if($chk11) echo 'checked'; ?> >SE Proposals -->
		<input type="checkbox" name="chk6" <? if($chk6) echo 'checked'; ?> >IOW Progress with SE Remarks
<!-- 		<input type="checkbox" name="chk7" <? if($chk7) echo 'checked'; ?> >Progress by Date -->
<!-- 		<input type="checkbox" name="chk9" <? if($chk9) echo 'checked'; ?> >Overdue -->
	</td>
 </tr>
</table>
</form>
<? if($edate){?>
<?
 $ed1=formatDate($edate,'Y-m-d');
	
	
 //if($project=='') $project=$loginProject;
 $sql="SELECT * FROM dailyreport WHERE edate='".date("Y-m-d",strtotime($ed1)-86400)."' AND pcode='$project'";
//echo $sql;
$sqlq=mysqli_query($db, $sql);
$sqlr=mysqli_fetch_array($sqlq);
$btn_sql1=$sql;
?>
<?php
 //if($project=='') $project=$loginProject;
if($chk14 || $chk15 || $chk16 || $chk17){
	$tSql="SELECT * FROM dailyreport WHERE edate!='$ed1' and edate!='' and edate!='0000-00-00' AND pcode='$project' order by edate desc";;
	$qQ=mysqli_query($db, $tSql);
	while($cmActivity[]=mysqli_fetch_array($qQ)){}
}
?>

<table width="95%" align="center" style="text-size:10px;">
<tr><td colspan="2">
<!-- 	<b>Progress description of the day:</b> -->
	<?php
	list($approved,$actual_amount)=get_daily_iow_progress($ed1,$project);
	$approved_date=date("d/m/Y",strtotime($ed1)-86400);
	?>
	<i> At <?= $approved_date ?> Planned progress of approved tasks was Tk. <b><?= number_format($approved) ?></b> & actual progress Tk. <b><?= number_format($actual_amount) ?></b>; <font color='#00f'><? echo $sqlr[operation];?></font></i></td></tr>
<?php if($chk14){
	foreach($cmActivity as $cmDaily){
		if($cmDaily[operation])
			echo "<tr><td>".date("d/m/Y",strtotime($cmDaily[edate])).":</td><td> <i>$cmDaily[operation]</i></td></tr>";
	}
}?>
	
<tr><td colspan="2"><b>Weather interruption:</b> <i><? echo $sqlr[weather];?></i></td></tr>
<?php if($chk15){
	foreach($cmActivity as $cmDaily){
		if($cmDaily[weather])
			echo "<tr><td>".date("d/m/Y",strtotime($cmDaily[edate])).":</td><td> <i>$cmDaily[weather]</i></td></tr>";
	}
}?>
	
	
	
<tr><td colspan="2"><b>Accident records:</b> <i><? echo $sqlr[accident];?></i></td></tr>
<?php if($chk16){
	foreach($cmActivity as $cmDaily){
		if($cmDaily[accident])
			echo "<tr><td>".date("d/m/Y",strtotime($cmDaily[edate])).":</td><td> <i>$cmDaily[accident]</i></td></tr>";
	}
}?>

<tr><td colspan="2"><b>Visitors detail with comments received:</b> <i><? echo $sqlr[vcomments];?></i></td></tr>
<?php if($chk17){
	foreach($cmActivity as $cmDaily){
		if($cmDaily[vcomments])
			echo "<tr><td>".date("d/m/Y",strtotime($cmDaily[edate])).":</td><td> <i>$cmDaily[vcomments]</i></td></tr>";
	}
}?>

</table>
<br>








<table align="center" width="98%" border="1" bordercolor="#99CC99" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#D9F9D0">
 <th>Task Code</th>
 <th>Task description</th>
 <th>Planned Progress</th>
 <th>Actual Progress</th>
 <th>Actual Expenses</th>
<?php if($chk7){ ?> 
 <th>Progress on <?php echo $edate; ?> </th> 
<?php } ?>
</tr>
 <tr><td colspan="5" height="2"></td></tr>
<? $localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
include($localPath."/includes/config.inc.php");
// 	exit;
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
if(!$iow[0])$iow[0]="all";
	
	$sqlp = "SELECT * from `iow` where `iowProjectCode` LIKE '$project' ";
	
if($Status=='completed' && $iow[0]=='all'){$sqlp.=" AND (iowStatus ='Completed' or iowStatus='noStatus') ";}	
			
if($Status=='Started' && $iow[0]=='all'){
			/*if($new_array2==true)*/ $sqlp.=" AND iowStatus <> 'Completed' and iowSdate<='$today' and iowType=1 and position not like '999%' ";
// 			for($i=0; $i< $c=sizeof($new_array2); $i++ )
// 			{
// 				if($i==0)$sqlp.=" and ";
// 				$sqlp.="  iowId=$new_array2[$i] "; if($i<($c-1)) $sqlp.=" OR  "; else $sqlp.="";
// 				//echo "<br>".$c."<br>";
// 				}			
// 				//$sqlp.=" ORDER by iowId ASC";
			}
			
	
if($Status=='Not-Started' && $iow[0]=='all')
{
			$sqlp.=" AND iowStatus <> 'Completed'  and ((iowSdate>'$today' and iowType=1 and position not like '999%') or iowStatus='noStatus') ";
			for($i=0; $i< $c=sizeof($new_array); $i++ )
			{
				if($i==0)$sqlp.=" and (";
				$sqlp.="  iowId=$new_array[$i] "; if($i<($c-1)) $sqlp.=" OR  "; else $sqlp.="";
										//echo "<br>".$c."<br>";
}
	if(sizeof($new_array)>0)$sqlp.=" ) ";
										//$sqlp.=" ORDER by iowId ASC";
}
if($iow[0] !="all" && sizeof($iow)>0) //stoped
{
			
				$sqlp .= " AND ";
							
				for($i=0; $i< $c=count($iow); $i++ )
							{
								$sqlp.=" iowId=$iow[$i] "; if($i<($c-1)) $sqlp.=" OR  "; else $sqlp.="";
							//echo "<br>".$c."<br>";
							}
}		
$sqlp.=" $extraC ";
$sqlp.="  ORDER by position ASC";


	
 
$sqlrunp= mysqli_query($db, $sqlp);
$btn_sql2=$sqlp;
while($re=mysqli_fetch_array($sqlrunp)){

// if($re[iowStatus]!="noStatus")
// 	echo "<br>".$kk++."<br>";
// 	echo $sqlp;
	if($re[iowStatus]=="noStatus"){

	$position=count_dot_number($re[position]);
  $positionVal=md_IOW_headerFormat($position);
// 		echo $sqlp;
		?>
		
	<tr bgcolor="#F77">

  <th align="left" colspan="<?php echo $chk7 ? 6 : 5; ?>"><i style="
    color: #fff;
"><? echo  "<span style='color: #fff;
    font-weight: normal;
    font-size: 14px;'>".$positionVal."</span> ".$re[iowDes];?>  </i>		</th> 
	</tr>	
	<?php
		continue;
	}	
?>


<tr bgcolor="#F0FEE2">
  <th align="left" ><? echo $re[iowCode];?> </th>
  <th align="left"><i><? echo $re[iowDes];?>  </i>
<? 
  $expenses_tk=cash_payment_iow_expecess($re[iowId]);
  if($expenses_tk>0){
    echo "Expenses ".$expenses_tk;
    echo ' ['.myDate($re[iowSdate]).' to '.myDate($re[iowCdate]).'] ';
  }
?>
<? /*

$materialCost=materialCost($re[iowId]);
$equipmentCost=equipmentCost($re[iowId]);
$humanCost=humanCost($re[iowId]);
$directCost=$materialCost+$equipmentCost+$humanCost;
$totalCost=$re[iowQty]*$re[iowPrice];
echo ' ['.number_format($directCost);
echo '<font class=out> ('.number_format(($directCost/$totalCost)*100).'%) </font> ] ';
*/
?></th>
  <td align="left"> <? iowProgress($edate,$re[iowId]); ?> </td> 
  <td align="right">
<?
	$ed=formatDate($edate,'Y-m-j');
	// ====================================================================================================================
	echo $iowActualProgress=iowActualProgress($re[iowId],$project,$ed,$re[iowQty],$re[iowUnit],0);
	//echo number_format($iowActualProgress);
// 	echo "($re[iowId],$project,$ed,$re[iowQty],$re[iowUnit],0)";
  //iowActualProgress($edate,$re[iowId],1);
?></td>
<td align="right"><?
  $iow_subContractorissuedEx=iow_subContractorissuedEx($re[iowId],$project,$ed);	
// 	echo "Subcon: $iow_subContractorissuedEx";
	$iow_issuedEx=iow_issuedEx($re[iowId],$project,$ed);
// 	echo "<br>issued exp $iow_issuedEx";
	$iow_equipmentReport=iow_equipmentReport($re[iowId],$project,$ed);
// 	echo "<br>EQ".number_format($iow_equipmentReport);
	$iow_humanReport=iow_humanReport($re[iowId],$project,$ed);
// 	echo "<br>man".$iow_humanReport;

$actualTotalEx=$iow_subContractorissuedEx+$iow_issuedEx+$iow_equipmentReport+$iow_humanReport;
// 	echo "<br>actualTotalEx: $actualTotalEx<br>";
$materialCost=materialCost($re[iowId]);
$equipmentCost=equipmentCost($re[iowId]);
$humanCost=humanCost($re[iowId]);
$directCost=$materialCost+$equipmentCost+$humanCost;
	

	$actualTotalExp=($actualTotalEx/$directCost)*100;
// echo "ActualExp $actualTotalEx DirectCost:$directCost; ";
	echo number_format($actualTotalEx).'<font class=out>('.number_format($actualTotalExp).'%)</font>';
	$actyalTotalEx=0;
	$actualTotalExp=0;
	$iow_subContractorissuedEx=$iow_issuedEx=$iow_equipmentReport=$iow_humanReport=0;
	?></td>	
	<?php
	if($chk7){ ?>
		<td align="right">
	<?php
		echo iowActualProgress($re[iowId],$project,$ed,$re[iowQty],$re[iowUnit],1);
	?>
	</td>
	<?php }	?>
	
</tr>

<? 
$ed=formatDate($edate,'Y-m-d');
if($chk1 OR $chk2 OR $chk3 OR $chk4){

$sqlp1 = "SELECT siowId,siowCode,siowName,siowQty,siowUnit,siowCdate,siowSdate, 
 (to_days(siowCdate)-to_days(siowSdate)) as duration, (to_days('$ed')-to_days(siowSdate)) as pass 
 from `siow` where `iowId` = $re[iowId] ORDER by siowCode ASC";
//echo $sqlp1;
$btn_sql3=$sqlp1;
$sqlrunp1= mysqli_query($db, $sqlp1);
$i=1;
while($res=mysqli_fetch_array($sqlrunp1)){
?>

<tr>
  <td  align="right" ><? echo $res[siowCode];?>  </td>
  <td><i><? echo $res[siowName];?></i> <? echo '['.myDate($res[siowSdate]).' to '.myDate($res[siowCdate]).'] ';?></td> 
  <td> <? echo siowProgress($edate,$res[siowId]);?> </td> 
  <td align="right"><?
  echo siowActualProgress($res[siowId],$project,$ed,$res[siowQty],$res[siowUnit],0);
  
  //echo siowActualProgress($edate,$res[siowId],'1'); ?> </td> 
	<td align="right"><? 
	 $siow_subContractorissuedEx=siow_subContractorissuedEx($res[siowId],$project,$ed);
	
// 	echo "<br> subcon: $siow_subContractorissuedEx";
	 $siow_issuedEx=siow_issuedEx($res[siowId],$project,$ed);
// 	echo "<br>issue mat: $siow_issuedEx";
	 $siow_equipmentReport=siow_equipmentReport($res[siowId],$project,$ed);
// 	echo "<br>eq ".number_format($siow_equipmentReport);
  	$siow_humanReport=siow_humanReport($res[siowId],$project,$ed);
// 	echo "<br>Man: ".$siow_humanReport."<br>";
	
$actualTotalEx=$siow_subContractorissuedEx+$siow_issuedEx+$siow_equipmentReport+$siow_humanReport;
	
$materialCost=siow_materialCost($res[siowId]);
$equipmentCost=siow_equipmentCost($res[siowId]);
$humanCost=siow_humanCost($res[siowId]);

$directCost=$materialCost+$equipmentCost+$humanCost;
//echo "** directCost=$actualTotalEx  ;; $directCost **";
$actualTotalExp=($actualTotalEx/$directCost)*100;

echo number_format($actualTotalEx).'<font class=out>('.number_format($actualTotalExp).'%)</font>';	

	$actualTotalEx=0;
	$siow_subContractorissuedEx=$siow_issuedEx=$siow_equipmentReport=$siow_humanReport=0;
	?></td>
	 <?php
		global $chk7;
		if($chk7){?>
			<td align="right">
		 		<? 
  echo siowActualProgress($res[siowId],$project,$ed,$res[siowQty],$res[siowUnit],1);
			

				
				?>
		 </td>
		<?php } ?>
</tr>
<? if($chk2 OR $chk3 OR $chk4){?>
    <tr> 
			<td></td>
			<td></td>
	<td colspan="<?php echo $chk7 ? "4" : "3"; ?>">
<!-- 	 <tr>
	   <th width="40">ItemCode</th>
	   <th width="20%">Planned Consumption</th>
	   <th width="20%">Actual Consumption</th>
	   <th width="20%">Actual Expense</th>	   
	 </tr> -->
	  <?
			$zeroDecimal=1; //so that global variable is set 1 zero decimal number
			if($chk2){ materialReport($res[siowId],$res[pass],$res[duration],$project,$ed);
	  // materialReport_summary($res[siowId],$res[pass],$res[duration],$project,$edate);
	  }?>
	  <? if($chk3){equipmentReport($res[siowId],$res[pass],$res[duration],$project,$ed);
	//  equipmentReport_summary($res[siowId],$res[pass],$res[duration],$project,$edate);
								 
	  }?>
	  <? if($chk4){ humanReport($res[siowId],$res[pass],$res[duration],$project,$ed);
	  // humanReport_summary($res[siowId],$res[pass],$res[duration],$project,$edate);
	   subcontractorReport($res[siowId],$res[pass],$res[duration],$project,$ed);
	  }
		$zeroDecimal=0; //so that global variable is set 0 normal decimal number
	  ?>
		<td>
	</tr>
 <? }//material?>
<? } //siow
}
?>
<?
$ij=0;
if($chk5 OR $chk6){
$sqld="select des,clientdes,edate,supervisor,auto_save_info from iowdaily where iowId=$re[iowId] AND edate<='$ed' group by edate ORDER by edate DESC";
// echo $sqld;
// 	exit;
$sqlqd=mysqli_query($db, $sqld);
while($d=mysqli_fetch_array($sqlqd)){
$get_all_data=iow_progerss_variance($re[iowId],$d[edate]); 
		if($get_all_data || $d["auto_save_info"]){
			$btn_chk6=1;
			echo "<tr><td colspan=5>";
			if($d["auto_save_info"]){
				$infoAr=explode(":",$d["auto_save_info"]);
				$infoAr2=explode(" ",$infoAr[1]);
				echo	"<b>".date("M d,Y",strtotime($d[edate]))."</b>: <font color='#f00'>$infoAr2[1]</font> $infoAr2[2] $infoAr2[3] ".$infoAr[2].$infoAr[3]."; ";
			}else{
				echo "<b>".date("M d,Y",strtotime($d[edate]))."</b>: ";
			}
			
		$exPP=explode("%",$infoAr[3]);
		$currentQty=str_replace("(","",str_replace(")","",$exPP[1]));
		$currentQty=str_replace(",","",$currentQty);
		$currentQty=intval($currentQty);
		$date_differ=(strtotime($re[iowCdate])-strtotime(date("M d,Y",strtotime($d[edate]))))/86400;
		$leftProgress=100-$exPP[0];
		$leftQty=$re[iowQty]-$currentQty;

		$dailyNeededP=abs($leftProgress/$date_differ);
		$dailyNeededQty=abs($leftQty/$date_differ);
			
			
	// 	echo "$re[iowSdate] - $re[iowCdate] = $date_differ ($dailyNeeded)";
	echo "On date planned progress: ".number_format($dailyNeededP,2)."% (".round($dailyNeededQty,2)." $re[iowUnit]), workdone ";

	echo iowActualProgressRange($re[iowId],$project,date("Y-m-d",strtotime($d[edate])),date("Y-m-d",strtotime($d[edate])),$re[iowQty],$re[iowUnit],1);
				
				
// 			echo "select clientdes from iowdaily where edate='$d[edate]' and clientdes!=''";
				$clientdesQ=mysqli_query($db,"select clientdes from iowdaily where edate='$d[edate]' and clientdes!=''");
				$clientdesR=mysqli_fetch_array($clientdesQ);
			echo "; <i><font color='#00f'>".$clientdesR["clientdes"]."</font></i>";
echo "</td></tr>";

}
// if($chk5 AND  $d[clientdes]){
// 		$btn_chk5=1; echo "<tr><td colspan=5><b>".myDate($d[edate])."</b> CO/WI: <i>$d[clientdes]</i></td></tr>";
// }
}
?>
<? } else {?>
<tr><td colspan="<?php echo $chk7 ? "6" : "5"; ?>" height="5" >
<b>Site Engineer:</b>
<!--<? //echo iow_progerss_supervisor($re[iowId],$ed);
/*
$sql1="SELECT * from employee where designation like '75-%-000' and location='$project' AND status='0'";
// echo "$sql1<br>";
// exit;
$sqlq1=mysqli_query($db, $sql1);
while($re1=mysqli_fetch_array($sqlq1))

echo $re1['name'];
echo ", ";
echo $re1['phone_office'] ? "Phone Office: <a href='tel:$re1[phone_office]'>".$re1['phone_office']."</a>, " : "";
	
echo $re1['phone_personal'] ? "Phone Personal:  <a href='tel:$re1[phone_personal]'>".$re1['phone_personal']."</a>, " : "";
	
echo $re1['email_office'] ? "Email Office: <a href='mailto:$re1[email_office]'>".$re1['email_office']."</a>, " : "";

echo $re1['email_personal'] ? "Email Personal:  <a href='mailto:$re1[email_personal]'>".$re1['email_personal']."</a>," : "";

$deg=hrDesignation($re1[designation]);
echo $deg;
}*/
?>-->
<?php
if($re[supervisor])
echo supervisorDetails_withcontact($re[supervisor]);
?>
</td></tr>
<?
$previosData=iow_progerss_variance_before($re[iowId],$ed);
$get_all_data=explode(")",$previosData[0]);
$edate_coll[]=$previosData[1];
$previousIowDaily=iowID2IowDailyBefore($re[iowId],$ed);

	if($previousIowDaily["auto_save_info"]){
		echo '<tr><td colspan="'. ($chk7 ? "6" : "5") .'" height="5" >';
		$infoAr=explode(":",$previousIowDaily["auto_save_info"]);
		$infoAr2=explode(" ",$infoAr[1]);
		
		
	if(!$infoAr2[1])$infoAr2[1]="R0";
	if(strlen($infoAr2[1])>3){$infoAr2[2]=$infoAr2[1]." ".$infoAr2[2];$infoAr2[1]="R0";}
		
//echo $previosData[1];
	echo	"<b>".$infoAr[0]."</b>: <font color='#f00'>$infoAr2[1]</font> $infoAr2[2] $infoAr2[3] ".$infoAr[2].$infoAr[3].": ";
		
		$exPP=explode("%",$infoAr[3]);
		$currentQty=str_replace("(","",str_replace(")","",$exPP[1]));
		$currentQty=str_replace(",","",$currentQty);
		$currentQty=intval($currentQty);
		$date_differ=(strtotime($re[iowCdate])-strtotime(date("M d,Y",strtotime($ed))))/86400;
// 		echo "<br>";
		$leftProgress=100-$exPP[0];
		$leftQty=$re[iowQty]-$currentQty;

		$dailyNeededP=abs($leftProgress/$date_differ);
		$dailyNeededQty=abs($leftQty/$date_differ);

	// 	echo "$re[iowSdate] - $re[iowCdate] = $date_differ ($dailyNeeded)";
	echo	"On date planned progress ".number_format($dailyNeededP,2)."% (".round($dailyNeededQty)." $re[iowUnit]), workdone ";

	echo iowActualProgressRange($re[iowId],$project,date("Y-m-d",strtotime($ed)-86400),date("Y-m-d",strtotime($ed)-86400),$re[iowQty],$re[iowUnit],1);

		
			echo "; <i><font color='#00f'>".$previousIowDaily["des"]."</font></i>";
	//echo $get_all_data[0].$get_all_data[1];
	echo '</td></tr>';
}

if(1==2){ 
// 		previous date	
$get_all_data=explode(")",iow_progerss_variance($re[iowId],$ed));
$iowDaily=iowID2IowDaily($re[iowId],date("Y-m-d",strtotime($ed)-86400));
// print_r($iowDaily);
	if($iowDaily["auto_save_info"]){
		echo '
<tr><td colspan="'. ($chk7 ? "6" : "5") .'" height="5" >';
			$infoAr=explode(":",$iowDaily["auto_save_info"]);
			$infoAr2=explode(" ",$infoAr[1]);
			$infoAr[2]=str_replace("Actual Progress","",$infoAr[2]);
// 		print_r($infoAr);
		
		echo	"<b>".date("M d,Y",strtotime($ed)-86400)."</b>: <font color='#f00'>$infoAr2[1]</font> $infoAr2[2] $infoAr2[3] ".$infoAr[2].$infoAr[3].": ";
		
		$exPP=explode("%",$infoAr[3]);
		$currentQty=str_replace("(","",str_replace(")","",$exPP[1]));
		$currentQty=str_replace(",","",$currentQty);
		$currentQty=intval($currentQty);
		$date_differ=(strtotime($re[iowCdate])-strtotime(date("Y-m-d",strtotime($ed)-86400)))/86400;
		$leftProgress=100-$exPP[0];
		$leftQty=$re[iowQty]-$currentQty;
		
		$dailyNeededP=($leftProgress/$date_differ);
		$dailyNeededQty=($leftQty/$date_differ);
		
		if(!$infoAr2[1])$infoAr2[1]="R0";
		if(strlen($infoAr2[1])>3){$infoAr2[2]=$infoAr2[1]." ".$infoAr2[2];$infoAr2[1]="R0";}
		
// 		echo "$re[iowSdate] - $re[iowCdate] = $date_differ ($dailyNeeded)";
			echo	" Planned progress ".round($dailyNeededP)."% (".round($dailyNeededQty)." $re[iowUnit]), workdone ";
		
		echo iowActualProgressRange($re[iowId],$project,date("Y-m-d",strtotime($ed)-86400),$ed,$re[iowQty],$re[iowUnit],1);
		
			echo "; <i><font color='#00f'>".$iowDaily["des"]."</font></i>";
// 			echo $get_all_data[0].$get_all_data[1];
		echo '</td></tr>';
	}
}
	
// 		previous date	
$get_all_data=explode(")",iow_progerss_variance($re[iowId],$ed));
$iowDaily=iowID2IowDaily($re[iowId],date("Y-m-d",strtotime($ed)-(86400*2)));
// print_r($iowDaily);
	if($iowDaily["auto_save_info"]){
		
		echo '
<tr><td colspan="'. ($chk7 ? "6" : "5") .'" height="5" >';
			$infoAr=explode(":",$iowDaily["auto_save_info"]);
			$infoAr2=explode(" ",$infoAr[1]);
		$infoAr[2]=str_replace("Actual Progress","",$infoAr[2]);
// 		print_r($infoAr);
		
		echo	"<b>".date("M d,Y",strtotime($ed)-(86400*2))."</b>: <font color='#f00'>$infoAr2[1]</font> $infoAr2[2] $infoAr2[3] ".$infoAr[2]." Actual Progress ".$infoAr[3].": ";
		
		
		
		$exPP=explode("%",$infoAr[3]);
		$currentQty=str_replace("(","",str_replace(")","",$exPP[1]));
		$currentQty=str_replace(",","",$currentQty);
		$currentQty=intval($currentQty);
		$date_differ=(strtotime($re[iowCdate])-strtotime(date("Y-m-d",strtotime($ed)-(86400*2))))/86400;
		$leftProgress=100-$exPP[0];
		$leftQty=$re[iowQty]-$currentQty;
		
		$dailyNeededP=($leftProgress/$date_differ);
		$dailyNeededQty=($leftQty/$date_differ);
			
		if(strlen($infoAr2[1])>3)$infoAr2[1]="";
			
// 		echo "$re[iowSdate] - $re[iowCdate] = $date_differ ($dailyNeeded)";
			echo	" On date planned progress ".round($dailyNeededP)."% (".round($dailyNeededQty)." $re[iowUnit]), workdone ";
			
		echo iowActualProgressRange($re[iowId],$project,date("Y-m-d",strtotime($ed)-(86400*2)),date("Y-m-d",strtotime($ed)-(86400*2)),$re[iowQty],$re[iowUnit],1);
		
			echo "; <i><font color='#00f'>".$iowDaily["des"]."</font></i>";
// 			echo $get_all_data[0].$get_all_data[1];
		echo '</td></tr>';
// 		echo "<> $date_differ  <>$ed<>";
	}
	
?>
	
<?php $desC=iow_progerss_changeOrder_before($re[iowId],$ed);
if($desC[0]){ ?>
<tr bgcolor='#D9F9D0'><td colspan="<?php echo $chk7 ? "6" : "5"; ?>" height="5">
<? 
	echo date("M d Y",strtotime($desC[1]))." <b>CO/WI: </b>";
  echo $desC[0];
	?>
</td></tr>
<?php } ?>

<!-- <tr>
	<td colspan="<?php echo $chk7 ? "6" : "5"; ?>" height="5">
		<b>Issues may hamper progress and cost: </b>
	</td>
</tr> -->
<?php
if(1==2) //stoped
foreach(getTroubleTrackerRows(null,$re[iowId],$chk9) as $rows)
{ if(!$rows[dateline])continue;?>
	<tr>
		<td colspan="<?php echo $chk7 ? "6" : "5"; ?>" height="5" >
		<b><?php echo date("d/m/Y",strtotime($rows[raisedOn])); ?>
			<?php if($rows[dateline])echo " Dateline: ".date("d/m/Y",strtotime($rows[dateline])); ?>
			: </b>
		<? echo $rows[troubleTxt];



if(!$rows[closedOn]){
		if(strtotime($rows[dateline])<strtotime(todat())){
			echo "<span style='color: #fff;font-size: 11px;background: #f00;padding: 2px;border-radius: 5px; margin: 0 5px;'><font>Overdue</font>";
		}
}else{
	echo "<span style='color: #fff;font-size: 11px;background: #00f;padding: 2px;border-radius: 5px; margin: 0 5px;'><font>Closed on: ".
				date("d/m/Y",strtotime($rows[closedOn]))
				."</font>";
}
			?>
		</td>
	</tr>
<?php } ?>
	
	

<!-- <tr><td colspan="<?php echo $chk10 ? "6" : "5"; ?>" height="5" >
<b>Progress improvement proposal by Site Engineer: </b>
<?php
echo iow_progerss_changeOrder($re[iowId],$ed);?>
</td></tr> -->

<tr><td colspan="<?php echo $chk11 ? "6" : "5"; ?>" height="5" >
<b>Change order received: </b>
<?php
$change_order=iow_progerss_changeOrder($re[iowId],$ed);
	if($change_order){
		echo $change_order;
	}else{
		echo "<i>No change order received today.</i>";
	}
	?>
</td></tr>

<tr><td colspan="<?php echo $chk7 ? "6" : "5"; ?>" height="5">
<b>Billing document status:</b>
<? 
$billingArray=getBillingDocRows($re[iowId],1);
	foreach($billingArray as $billing){
		if($billing[edate])
			echo "<b>".date("d/m/Y",strtotime($billing[edate])).":</b> ";
		if($billing[bParcent])
			echo "<font color='#00f'>".$billing[bParcent]."%</font> ready. ";
		if($billing[bDes])
			echo $billing[bDes];
	}
if(count($billingArray)==1){
	echo "Up-to-date 0%: Documentation work not started";
}
?>
</td></tr>
	


<?  } //else chk5?>
<tr>
    <td colspan="<?php echo $chk7 ? "6" : "5"; ?>" height="11" ></td>
  </tr>
<? }//iow
?>
</table>

<? }//if edate?>
<form name="print" method="post" action="./project/print_siteDailyReport.php" target="_blank">
<input type="hidden" name="btn_sql1" value="<? echo $btn_sql1;?>">
<input type="hidden" name="btn_sql2" value="<? echo $btn_sql2;?>">
<input type="hidden" name="btn_sql3" value="<? echo $btn_sql3;?>">

<input type="hidden" name="edate" value="<? echo $edate?>">
<input type="hidden" name="chk1" value="<? echo $chk1?>">
<input type="hidden" name="chk2" value="<? echo $chk2?>">
<input type="hidden" name="chk3" value="<? echo $chk3?>">
<input type="hidden" name="chk4" value="<? echo $chk4?>">
<input type="hidden" name="chk5" value="<? echo $chk5?>">
<input type="hidden" name="chk6" value="<? echo $chk6?>">
<input type="hidden" name="chk7" value="<? echo $chk7?>">
<input type="hidden" name="chk8" value="<? echo $chk8?>">
<input type="hidden" name="chk9" value="<? echo $chk9?>">
<input type="hidden" name="Status" value="<? echo $Status?>">
<input type="hidden" name="project" value="<? echo $project?>">

<input type="submit" name="btn_print" value="Print">


</form>
<div id=testdiv1
      style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
<?php
error_reporting(0);
if($_SESSION[jQuery]!=1){
	$_SESSION[jQuery]=1;
	header("refresh:1");
}
	
?>
<form name="gooo" action="./graph/alliow.g.php"	 method="post" target="_blank">
<table align="center" width="98%" border="0" bgcolor="#FFCCCC" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
<tr>
<td>Progress Report in Graph</td>
<? if($loginDesignation=='Manager Planning & Control' OR $loginDesignation=='Managing Director' OR $loginDesignation=='Director' OR $loginDesignation=='Chairman & Managing Director') {?>
<td >Project: <select name="gproject">
<?

include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$sqlppg = "SELECT * from `project` ORDER  by pcode ASC";
//echo $sqlp;
$sqlrunppg= mysqli_query($db, $sqlppg);

 while($typelpg= mysqli_fetch_array($sqlrunppg))
{
 echo "<option value='".$typelpg[pcode]."'";
 if($projectg==$typelpg[pcode]) echo " selected ";
 echo ">$typelpg[pcode]--$typelpg[pname]</option>  ";
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
</tr>
</table>
</form>
<? include('./project/siteMaterialReportEntry.f.php');?>
<? include('./project/siteDailyReport.f.php');?>
<? include('./project/findProject.f.php');?>

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
	<? if($loginDesignation=='Manager Planning & Control' OR $loginDesignation=='Chairman & Managing Director' OR $loginDesignation=='Managing Director' OR $loginDesignation=='Director') {?>
      <td colspan="1" >
 
	  Project: <select name="project" 
onChange="location.href='index.php?keyword=site+daily+report&project='+goo.project.options[document.goo.project.selectedIndex].value+'&Status='+goo.Status.options[document.goo.Status.selectedIndex].value";>
<?
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$sqlpp = "SELECT * from `project`  ORDER  by  pcode ASC";
//echo $sqlp;
$sqlrunpp= mysqli_query($db, $sqlpp);

 while($typelp= mysqli_fetch_array($sqlrunpp))
{
 echo "<option value='".$typelp[pcode]."'";
 if($project==$typelp[pcode]) echo " selected ";
 echo ">$typelp[pcode]--$typelp[pname]</option>  ";
 }
?>

 </select>
				
	 				
  <select name="Status">
			<option value="">All Task</option>
			<option value="Started" <? if($Status=='Started' || !$Status) echo " selected "; ?>>Active Task</option>
			<option value="Not-Started" <? if($Status=='Not-Started') echo " selected "; ?>>Inactive Task</option>
			<option value="completed" <? if($Status=='completed') echo " selected "; ?>>Completed Task</option>
			
</select><input type="button" onclick="location.href='index.php?keyword=site+daily+report&project='+goo.project.options[document.goo.project.selectedIndex].value+'&Status='+goo.Status.options[document.goo.Status.selectedIndex].value" value="Page Reload" /><br />
				<br />
			
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
			include("config.inc.php");
			$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
				  
			$sqlp = "SELECT iowId,`iowCode`,iowDes from `iow` WHERE iowProjectCode='$project' and iowStatus !='Completed' or iowStatus!='noStatus' ";
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
			$new_array = remove_array_empty_values($test, $remove_null_number);
			
			//echo "two ND present array data is".print_r($new_array)."<br>";
			  
  }
  
  if($Status=='Started'){
 // echo " yea i am in started";
			include("config.inc.php");
			$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
				  
			$sqlp2 = "SELECT iowId,`iowCode`,iowDes from `iow` WHERE iowProjectCode='$project' and iowStatus !='Completed'  or iowStatus=='noStatus'  ";
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
			 //echo "present array data is".print_r(array_diff($tast,array(" ")))."<br>";
			 $remove_null_number = true;
			$new_array2 = remove_array_empty_values($test2, $remove_null_number);
			
			//echo "two ND present array data is".print_r($new_array2)."<br>";
			  
  }
 //
 include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$sqlp = "SELECT iowId,`iowCode`,iowDes,position,iowStatus,iowType from `iow` WHERE iowProjectCode='$project'  ";
if($Status=='completed'){$sqlp.=" AND iowStatus ='Completed' ";}

if($Status=='Not-Started'){
$sqlp.=" AND iowStatus != 'Completed' and";
for($i=0; $i< $c=sizeof($new_array); $i++ )
{
							$sqlp.="  iowId=$new_array[$i] "; if($i<($c-1)) $sqlp.=" OR  "; else $sqlp.="";
							//echo "<br>".$c."<br>";
							}	
				 			$sqlp.=" iowStatus = 'noStatus' and position like '___.000.000.000' ORDER by position ASC";
}

elseif($Status=='Started'){
 /*if($new_array2==true)*/ $sqlp.=" AND iowStatus != 'Completed' and ";
for($i=0; $i< $c=sizeof($new_array2); $i++ )
{
							$sqlp.="  iowId=$new_array2[$i] "; if($i<($c-1)) $sqlp.=" OR  "; else $sqlp.="";
							//echo "<br>".$c."<br>";
							}			
				 			$sqlp.="  iowStatus = 'noStatus' and position like '___.000.000.000' ORDER by position ASC";


}
	else{
		
				 			$sqlp.=" and iowStatus = 'noStatus' and position like '___.000.000.000' ";
				 			$sqlp.=" ORDER by position,iowStatus ASC";
		
	}

   echo $sqlp;

?>
						
						
					<?

//
$sqlrunp= mysqli_query($db, $sqlp);
$oldPosition="1";
 while($typel= mysqli_fetch_array($sqlrunp))
{
	
	if($typel[iowStatus]=="noStatus"){
		$position=count_dot_number($typel[position]);
  	$positionVal=md_IOW_headerFormat($position);
		$pos=explode(".",$typel[position]);		
		
		echo "<li s1='$pos[0]' s2='$pos[1]' s3='$pos[2]' s4='$pos[3]' pos='$position'  class='heading' >$positionVal $typel[iowDes]</li>";
		
		
// 		position setup
		$pp=0;
		$position_setup="";
		while($pp < 4){
			if($pp!=$position)
				$position_setup.=$pos[$pp].".";
			else
				$position_setup.="___.";		
			$pp++;
		}
		$position_setup=trim($position_setup,".");
// 		end position setup
		
// 		iow id collection
			$iowCoID[]=$typel[iowId];
// 		end of iow id collection
		
		$sql="select * from iow where position like '$position_setup' and  iowProjectCode='$project' and iowId not in (".implode(",",$iowCoID).") and position not like '___.000.000.000'  order by position";
		$q=mysqli_query($db,$sql);
		while($pos_row=mysqli_fetch_array($q)){
			$position=count_dot_number($pos_row[position]);
			$positionVal=md_IOW_headerFormat($position);
			$pos=explode(".",$pos_row[position]);
			
if($pos_row[iowStatus]=="noStatus"){
	echo "<li s1='$pos[0]' s2='$pos[1]' s3='$pos[2]' s4='$pos[3]' pos='$position'  class='heading' >$positionVal $pos_row[iowDes]</li>";
}else{
			echo "<li s1='$pos[0]' s2='$pos[1]' s3='$pos[2]' s4='$pos[3]' pos='$position' ";
// 			if($pos_row[iowStatus]=="noStatus")echo " class='heading' rel='$pos_row[iowId]' ";
// 			else 
				echo " class='child' rel='$pos_row[iowId]'  ";
			
				echo ">$positionVal <span style='color:#f00;'>$pos_row[iowCode]</span>: $pos_row[iowDes]</li>";

				// 		iow id collection
				$iowCoID[]=$pos_row[iowId];
				//		end of iow id collection
}			
		}		
	}	
 }
	
function rec_all_data($position_setup,$project,$iowCoID,$db){
	
	$sql="select * from iow where position like '$position_setup' and  iowProjectCode='$project' and iowId not in (".implode(",",$iowCoID).") and position not like '___.000.000.000'  order by position";
		$q=mysqli_query($db,$sql);
		while($pos_row=mysqli_fetch_array($q)){
			$position=count_dot_number($pos_row[position]);
			$positionVal=md_IOW_headerFormat($position);
			$pos=explode(".",$pos_row[position]);
			
if($pos_row[iowStatus]=="noStatus"){
	echo "<li s1='$pos[0]' s2='$pos[1]' s3='$pos[2]' s4='$pos[3]' pos='$position'  class='heading' >$positionVal $pos_row[iowDes]</li>";
}else{
			echo "<li s1='$pos[0]' s2='$pos[1]' s3='$pos[2]' s4='$pos[3]' pos='$position' ";
// 			if($pos_row[iowStatus]=="noStatus")echo " class='heading' rel='$pos_row[iowId]' ";
// 			else 
				echo " class='child' rel='$pos_row[iowId]'  ";
			
				echo ">$positionVal <span style='color:#f00;'>$pos_row[iowCode]</span>: $pos_row[iowDes]</li>";

				// 		iow id collection
				$iowCoID[]=$pos_row[iowId];
				//		end of iow id collection
}			
		}	
} //function rec_all_data
	
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
				
				
				<select name="iow[]" multiple="multiple" size="7" style="display:none" id="iowCollection"> <option value="all">All Task</option>
<?

//
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
	 
	 
 Date.: <br><input class="yel" type="text" maxlength="10" name="edate" value="<? if($edate=='') echo date("d/m/Y"); else echo $edate;?>" > <a id="anchor" href="#"
   onClick="cal.select(document.forms['goo'].edate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a><br>
<input type="submit" name="go" value="Numeric Report"><br>
<input type="submit" name="go" value="Graphical Report">
	</td>
</tr>
<tr>
<? if($loginDesignation=='Manager Planning & Control' OR $loginDesignation=='Chairman & Managing Director' OR $loginDesignation=='Managing Director') {?>	 
	<td colspan="4" bgcolor="#FEF5F1">
	<? } else {?>
	 <td colspan="3" bgcolor="#FEF5F1">
	 <? }?>
 	<input type="checkbox"  name="chk1" <? if($chk1 OR $chk2 OR $chk3 OR $chk4 ) echo 'checked'; ?>>Sub Task Details
 	<input type="checkbox" name="chk2" <? if($chk2) echo 'checked'; ?> >Materials Details 
 	<input type="checkbox" name="chk3" <? if($chk3) echo 'checked'; ?> >Equipments Details
 	<input type="checkbox" name="chk4" <? if($chk4) echo 'checked'; ?> >Labour Details
 	<input type="checkbox" name="chk5" <? if($chk5) echo 'checked'; ?> >Change Order	
 	<input type="checkbox" name="chk6" <? if($chk6) echo 'checked'; ?> >Progress Details
 	<input type="checkbox" name="chk7" <? if($chk7) echo 'checked'; ?> >Progress by Date
	</td>
 </tr>
</table>
</form>
<? if($edate){?>
<?
$ed1=formatDate($edate,'Y-m-d');
//if($project=='') $project=$loginProject;
 $sql="SELECT * FROM dailyreport WHERE edate='$ed1' AND pcode='$project'";

//echo $sql;
$sqlq=mysqli_query($db, $sql);
$sqlr=mysqli_fetch_array($sqlq);
$btn_sql1=$sql;
?>
<table width="95%" align="center">
<tr><td colspan="2">Brief Description of Day's Operations :<i><? echo $sqlr[operation];?></i></td></tr>
<tr><td colspan="2">Weather Condition: <i><? echo $sqlr[weather];?></i></td></tr>
<tr><td colspan="2">Accident: <i><? echo $sqlr[accident];?> </i></td></tr>
<tr><td colspan="2">Visitors detail with comments received:<i> <? echo $sqlr[vcomments];?></i> </td></tr>
</table>
<br>
<table align="center" width="98%" border="1" bordercolor="#99CC99" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
 <tr bgcolor="#D9F9D0">
 <th>Task Code</th>
 <th>Task description</th>
 <th>Planned Progress</th>
 <th>Actual Progress</th>
 <th>Actual Expenses</th>  
 </tr>
 <tr><td colspan="5" height="2"></td></tr>
<? include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

	
	$sqlp = "SELECT * from `iow` where `iowProjectCode` LIKE '$project' ";
	
if($Status=='completed' && $iow[0]=='all'){$sqlp.=" AND iowStatus ='Completed' ";}	
			
if($Status=='Started' && $iow[0]=='all'){
			/*if($new_array2==true)*/ $sqlp.=" AND iowStatus <> 'Completed' and ";
			for($i=0; $i< $c=sizeof($new_array2); $i++ )
			{
				$sqlp.="  iowId=$new_array2[$i] "; if($i<($c-1)) $sqlp.=" OR  "; else $sqlp.="";
				//echo "<br>".$c."<br>";
				}			
				//$sqlp.=" ORDER by iowId ASC";
			}
			
	
if($Status=='Not-Started' && $iow[0]=='all')
{
			$sqlp.=" AND iowStatus <> 'Completed' and ";
			for($i=0; $i< $c=sizeof($new_array); $i++ )
			{
				$sqlp.="  iowId=$new_array[$i] "; if($i<($c-1)) $sqlp.=" OR  "; else $sqlp.="";
										//echo "<br>".$c."<br>";
			}			
										//$sqlp.=" ORDER by iowId ASC";
			
			
}
if ($iow[0] !="all" && sizeof($iow)>0)
{
			
				$sqlp .= " AND ";
							
				for($i=0; $i< $c=count($iow); $i++ )
							{
							$sqlp.="  iowId=$iow[$i] "; if($i<($c-1)) $sqlp.=" OR  "; else $sqlp.="";
							//echo "<br>".$c."<br>";
							}				
}		
$sqlp.=" ORDER by position ASC";

// echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
$btn_sql2=$sqlp;
while($re=mysqli_fetch_array($sqlrunp)){
	
	if($re[iowStatus]=="noStatus"){
				
	 $position=count_dot_number($re[position]);
  $positionVal=md_IOW_headerFormat($position);
		?>
		
	<tr bgcolor="#F77">

  <th align="left" colspan=5><i style="
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
    <? echo '['.myDate($re[iowSdate]).' to '.myDate($re[iowCdate]).'] ';?>
  <? /*

$materialCost=materialCost($re[iowId]);
$equipmentCost=equipmentCost($re[iowId]);
$humanCost=humanCost($re[iowId]);
$directCost=$materialCost+$equipmentCost+$humanCost;
$totalCost=$re[iowQty]*$re[iowPrice];
echo ' ['.number_format($directCost);
echo '<font class=out> ('.number_format(($directCost/$totalCost)*100).'%) </font> ] ';
*/
  ?>  </th> 
  <td align="left"> <? iowProgress($edate,$re[iowId]); ?> </td> 
  <td align="right"> 
      <? 

	$ed=formatDate($edate,'Y-m-j');
	 echo $iowActualProgress=iowActualProgress($re[iowId],$project,$ed,$re[iowQty],$re[iowUnit],0);
	// echo number_format($iowActualProgress);
  //iowActualProgress($edate,$re[iowId],1); ?>    </td> 
<td align="right"><? 
     $iow_subContractorissuedEx=iow_subContractorissuedEx($re[iowId],$project,$ed);	
	//echo $siow_subContractorissuedEx;
	 $iow_issuedEx=iow_issuedEx($re[iowId],$project,$ed);
	//echo "<br>$siow_issuedEx";
	 $iow_equipmentReport=iow_equipmentReport($re[iowId],$project,$ed);
	//echo "<br>".number_format($siow_equipmentReport);
	 $iow_humanReport=iow_humanReport($re[iowId],$project,$ed);
	//echo "<br>".$siow_humanReport;
	
	 $actualTotalEx=$iow_subContractorissuedEx+$iow_issuedEx+$iow_equipmentReport+$iow_humanReport;
	
$materialCost=materialCost($re[iowId]);
$equipmentCost=equipmentCost($re[iowId]);
$humanCost=humanCost($re[iowId]);
$directCost=$materialCost+$equipmentCost+$humanCost;
	

	$actualTotalExp=($actualTotalEx/$directCost)*100;

	echo number_format($actualTotalEx).'<font class=out>('.number_format($actualTotalExp).'%)</font>';
	$actyalTotalEx=0;
	$actualTotalExp=0;
	$iow_subContractorissuedEx=$iow_issuedEx=$iow_equipmentReport=$iow_humanReport=0;
	?></td>	
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
  <td align="right"> <? 
  echo siowActualProgress($res[siowId],$project,$ed,$res[siowQty],$res[siowUnit],0);
  
  //echo siowActualProgress($edate,$res[siowId],'1'); ?> </td> 
	<td align="right"><? 
	 $siow_subContractorissuedEx=siow_subContractorissuedEx($res[siowId],$project,$ed);
	
	//echo $siow_subContractorissuedEx;
	 $siow_issuedEx=siow_issuedEx($res[siowId],$project,$ed);
	//echo "<br>$siow_issuedEx";
	 $siow_equipmentReport=siow_equipmentReport($res[siowId],$project,$ed);
	//echo "<br>".number_format($siow_equipmentReport);
  	$siow_humanReport=siow_humanReport($res[siowId],$project,$ed);
	//echo "<br>".$siow_humanReport;
	
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
</tr>

<? if($chk2 OR $chk3 OR $chk4){?>
<tr>
    <td> </td>
	<td colspan="4">
	<table width="100%" style="border-collapse:collapse" cellspacing="2">
	 <tr><td colspan="4" bgcolor="#6699FF" height="2"></td></tr>
	 <tr><td colspan="4" bgcolor="#6699FF" height="2"></td></tr>
	 <tr>
	   <th width="40">ItemCode</th>
	   <th width="20%">Planned Consumption</th>
	   <th width="20%">Actual Consumption</th>
	   <th width="20%">Actual Expense</th>	   
	 </tr>
	 <tr><td colspan="4" bgcolor="#6699FF" height="2"></td></tr>
	 <tr><td colspan="4" bgcolor="#6699FF" height="2"></td></tr> 
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
     </table>   </td>
 </tr>
 <? }//material?>
<? } //siow
}
?>
<? if($chk5 OR $chk6 ){
$sqld="select des,clientdes,edate,supervisor from iowdaily where iowId=$re[iowId] AND edate<='$ed' ORDER by edate DESC";
//echo $sqld;
$sqlqd=mysqli_query($db, $sqld);
while($d=mysqli_fetch_array($sqlqd)){

		if($chk6 AND $d[des])
		{$btn_chk6=1;echo "<tr><td colspan=5><b>".myDate($d[edate])."</b> Progress: <i>$d[des]</i></td></tr>";}
		
		if($chk5 AND  $d[clientdes]){$btn_chk5=1; echo "<tr><td colspan=5><b>".myDate($d[edate])."</b> CO/WI: <i>$d[clientdes]</i></td></tr>";}
}
?>

<? } 
else {?>
<tr><td colspan="5" height="5" >
<b>Task Supervisor:</b>
<!--<? //echo iow_progerss_supervisor($re[iowId],$ed);
$sql1="SELECT * from employee where designation like '75-%-000' and location='$project' AND status='0'";
//echo "$sql<br>";
$sqlq1=mysqli_query($db, $sql1);
while($re1=mysqli_fetch_array($sqlq1))
{
echo $re1['name'];
echo ", ";
$deg=hrDesignation($re1[designation]);
echo $deg;
}
?>-->
<?php
if($re[supervisor])
echo supervisorDetails_simple($re[supervisor]);
?>
</td></tr>

<tr><td colspan="5" height="5" ><b>Reason for Progress Varience:</b>
<? 
$get_all_data=explode(")",iow_progerss_variance($re[iowId],$ed));
echo $get_all_data[1];?>
</td></tr>

<tr><td colspan="5" height="5" >
<b>CO/WI: </b>
<? echo iow_progerss_changeOrder($re[iowId],$ed);?>
</td></tr>
	
<tr><td colspan="5" height="5" >
<? 
	$iowDaily=iowID2IowDaily($re[iowId],$ed);
	echo $iowDaily["auto_save_info"];
	?>
</td></tr>

<? } //else chk5?>
<tr>
    <td colspan="5" height="11" ></td>
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
<input type="hidden" name="Status" value="<? echo $Status?>">
<input type="hidden" name="project" value="<? echo $project?>">

<input type="submit" name="btn_print" value="Print">


</form>
<div id=testdiv1
      style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>
<?php
session_start();
error_reporting(1);
//include('./includes/project.inc');
include('./includes/session.inc.php');
include('./includes/config.inc.php');
require("./includes/locationController.php");
$lt=new locationController;

$sortby=$_REQUEST['sortby'];
$pid=$_GET['pid'];

$fromDate = date("Y-m-d", strtotime($_POST['fromDate']));
$toDate = date("Y-m-d", strtotime($_POST['toDate']));
if($_GET['d'])
{
 $sqlUp= "delete from new_prime_activity WHERE id = '".$_GET['id']."'";
 echo "  <p align=center><br><br><br><font face=Verdana size=1 color=#FF0000>record deleted</font></p>";
 //echo $sqlUp;
 $sqlQurup=mysqli_query($db, $sqlUp);
 echo " <meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=./index.php?keyword=allnewprimeactivities\">";
//exit;
}

// for user function		
$dsg="m";
//
?>
<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript">
		view=0;
		$(document).ready(function(){
			$("#print").click(function(){
				fromDateValue=$("#fromDate").val();
				toDateValue=$("#toDate").val();
				sortValue=$("#sortby").val();
				if(fromDateValue && toDateValue){
					pop_win=window.open("./print/print_marketing_report.php?fromDate="+fromDateValue+"&toDate="+toDateValue+"&sortby="+sortValue);
				}
			});
			
			
			$("input.btnComment").click(function(){
				 	btnComment=$(this);
					btnComment.parent().hide();
					btnComment.parent().parent().find("div.addCommentEntry").show();
				  view=1;
				});
			$("input#addBtn").click(function(){
				targeted_btn=$(this);				
				comment_val=targeted_btn.parent().find("textarea").val();
				if(!comment_val){
					alert("No comment text found.");
					$("div.addCommentEntry").hide();
					view=0;
					return false;
				}
				$("div.addCommentEntry").hide();
				targeted_cell=targeted_btn.parent().parent();				
				activityID=targeted_cell.attr("id");
				old_stored_data=targeted_cell.html();
				targeted_cell.addClass("loading").html("");
				$.get("./project/comment.php",{comment:comment_val,activityID:activityID},function(status){
					if(status){
						if(status==101){msg="Empty filed not allowed"; alert(msg); return false; targeted_cell.html(msg).removeClass("loading");}
						if(status==402){msg="Error while data store"; alert(msg); return false; targeted_cell.html(msg).removeClass("loading");}
						targeted_cell.html(status).removeClass("loading");
					}
					else{
						alert("Network problem! Error while data send.");
						targeted_cell.html(old_stored_data).removeClass("loading");						
					}
				});
				view=0;
			});
			isbdm=<?php echo $a_loginDesignation=="Sales Manager" ? 1 : 0; ?>;
			$("td.commentTd").hover(function(){
				if(view==0 && isbdm)
					$(this).find("div.commentDiv").show();
				},function(){
					$(this).find("div.commentDiv").hide();				
				});
		});
	</script>
	
<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
<style type="text/css">
.out {
	FONT-SIZE: 10px; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; COLOR:#FFFFFF;
}
	div.addCommentEntry{display:none;}
	div.commentDiv{display:none;}
	.commentTd{text-align:right;}
	.loading{background:#ffa url(./images/loading.gif) no-repeat center; padding: 20px 0px; transition:background .2 ease-in-out;}
</style>

<script language="JavaScript">
    var now = new Date();
    var cal = new CalendarPopup("testdiv1");
    cal.setWeekStartDay(6); //week is Monday - Sunday
    cal.setCssPrefix("TEST");
    cal.offsetX = 0;
    cal.offsetY = 0;
</script>

<script language="JavaScript">
        var now = new Date();
        var cal = new CalendarPopup("testdiv1");
        cal.showNavigationDropdowns();
       // cal.setWeekStartDay(6); // week is Monday - Sunday
       //cal.addDisabledDates(null,formatDate(now,"MM/dd/yyyy"));
      cal.setCssPrefix("TEST");
        //cal.offsetX = 25;
       // .offsetY = -120;
        </script>                                   
<form name="primeactivities" method="post" action="<? $PHP_SELF;?>">

<table width="100%" border="1" bordercolor="#999999" style="border-collapse:collapse">
   <?php //if($a_loginUname=='admin' or $a_loginDesignation=='Managing Director' or $a_loginDesignation=='Manager'){ ?>
   
     <tr>
       <td colspan="6" valign="top" height="35" style="padding-top:5px" width="25%">From
       <input type="text" maxlength="10" name="fromDate" id="fromDate" value="<? echo $_POST['fromDate'];?>" >       <a id="anchor" href="#"
   onClick="cal.select(document.forms['primeactivities'].fromDate,'anchor','d-M-yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a> 
<br>
   To
       <input type="text" maxlength="10" name="toDate" id="toDate" value="<? echo $_POST['toDate'];?>" ><a id="anchor2" href="#"
   onClick="cal.select(document.forms['primeactivities'].toDate,'anchor2','d-M-yyyy'); return false;"
   name="anchor2" ><img src="./images/b_calendar.png" alt="calender" border="0"></a><br>


	Sort By:
         <select name="sortby" id="sortby">
           <!--<option value="">Select</option>-->
		   <option value="edate" <? if ($_POST['sortby']=='edate') echo "selected";?>>Date</option>
		   <option value="pname" <? if ($_POST['sortby']=='pname') echo "selected";?>>Prospect</option>
            <?php
			if($a_loginDesignation=="Sales Manager")
			{
			?>
            <option value="name" <? if ($_POST['sortby']=='name') echo "selected";?>>Marketing Person</option>
          <?php } ?>
          </select>
	    <input type="submit" name="submit" value="GO" />
	    <!-- <input type="button" id="print" value="Print" /> -->
       </td>
	   <td width="35%" style="vertical-align:top">
	   <?
	   
	  $sql="select ptype, count(pid) as num_of_prospect from new_prime_activity where edate between '$fromDate' and '$toDate' and ptype like '1' $compay_id_sql group by ptype";
		$result=mysqli_query($db, $sql);
		if(mysqli_num_rows($result)>0)
		{
			while($row=mysqli_fetch_array($result))
			{
/*				$num_of_prospect=$row['num_of_prospect']; 

				$ptype=$row['ptype'];
				echo view_ptype($dsg.$ptype);
				echo ": <strong><font color='FF0000'>";
				echo $num_of_prospect;
				echo "</strong></font>, ";
				$totalpros=$totalpros+$num_of_prospect;*/
				
				
				$sql1="select count(distinct pid) as tpid from  new_prime_activity where edate between '$fromDate' and '$toDate' and ptype=$ptype $compay_id_sql ";
				$r1=mysqli_query($db, $sql1);
				while($row1=mysqli_fetch_array($r1))
				{
					/*echo "No. of Prospect: ";
					echo "<strong><font color='FF0000'>";
					echo $row1['tpid'];
					echo "</strong></font><br>";*/
				}
			}
		 }


if($a_loginDesignation=="Marketing Executive"){
	$agenda_info=unameToAgenda4MEv3($a_loginUname);
}elseif($a_loginDesignation=="Sales Manager"){
	$agenda_info=unameToAgendaV3($a_loginUname);
	$agenda_line=makeAgendaLine4Bdm($agenda_info);
}
			 
if($_POST['submit']){	
// m1	
if($a_loginDesignation=="Marketing Executive"){
	$activity_sql="select distinct pid,edate from new_prime_activity where edate between '$fromDate' AND '$toDate' and ptype='m1' and agendaID='$agenda_info[id]' $compay_id_sql ";
$activity_sql_a="select pid as num_of_prospect from new_prime_activity where edate between '$fromDate' AND '$toDate' and ptype='m1' and agendaID='$agenda_info[id]' $compay_id_sql ";
}
if($a_loginDesignation=="Sales Manager"){
	$activity_sql="select distinct pid,edate from new_prime_activity where edate between '$fromDate' AND '$toDate' and ptype='m1' and agendaID in ($agenda_line) $compay_id_sql";
$activity_sql_a="select pid as num_of_prospect from new_prime_activity where edate between '$fromDate' AND '$toDate' and ptype='m1' and agendaID in ($agenda_line) $compay_id_sql";
}
if($a_loginDesignation=="Marketing Manager" || $a_loginDesignation=="admin"){
	$activity_sql="select distinct pid,edate from new_prime_activity where edate between '$fromDate' AND '$toDate' and ptype='m1' $compay_id_sql";
}
$aw_q=mysqli_query($db, $activity_sql);
$aw_row=mysqli_fetch_array($aw_q);
$Awareness=mysqli_affected_rows($db);

if($a_loginDesignation=="Marketing Manager" || $a_loginDesignation=="admin")
	$activity_sql_a="select pid as num_of_prospect from new_prime_activity where edate between '$fromDate' AND '$toDate' and ptype='m1' $compay_id_sql";
	
$aw_q_a=mysqli_query($db, $activity_sql_a);
$aw_row_a=mysqli_fetch_array($aw_q_a);
$Awareness_activity=mysqli_affected_rows($db);



	
	// m2
if($a_loginDesignation=="Marketing Executive"){
	$activity_sql="select distinct pid,edate from new_prime_activity where edate between '$fromDate' AND '$toDate' and ptype='m2' and agendaID='$agenda_info[id]' $compay_id_sql";
		$activity_sql_a="select pid as num_of_prospect from new_prime_activity where edate between '$fromDate' AND '$toDate' and ptype='m2' and  agendaID='$agenda_info[id]' $compay_id_sql";
}
	if($a_loginDesignation=="Marketing Manager" || $a_loginDesignation=="admin" || $a_loginDesignation=="Sales Manager"){
		$activity_sql="select distinct pid,edate from new_prime_activity where edate between '$fromDate' AND '$toDate' and ptype='m2' $compay_id_sql";
		$activity_sql_a="select pid as num_of_prospect from new_prime_activity where edate between '$fromDate' AND '$toDate' and ptype='m2' and agendaID in ($agenda_line) $compay_id_sql";
	}
$aw_q=mysqli_query($db, $activity_sql);
$aw_row=mysqli_fetch_array($aw_q);
$Interest=mysqli_affected_rows($db);


	if($a_loginDesignation=="Marketing Manager" || $a_loginDesignation=="admin" || $a_loginDesignation=="Sales Manager")
		$activity_sql_a="select pid as num_of_prospect from new_prime_activity where edate between '$fromDate' AND '$toDate' and ptype='m2' $compay_id_sql ";
$aw_q_a=mysqli_query($db, $activity_sql_a);
$aw_row_a=mysqli_fetch_array($aw_q_a);
$Interest_activity=mysqli_affected_rows($db);



// m3
if($a_loginDesignation=="Marketing Executive"){
	$activity_sql="select distinct pid,edate from new_prime_activity where edate between '$fromDate' AND '$toDate' and ptype='m3' and agendaID='$agenda_info[id]' $compay_id_sql ";
	$activity_sql_a="select pid as num_of_prospect from new_prime_activity where edate between '$fromDate' AND '$toDate' and ptype='m3' and (`uid` IN (SELECT id FROM user WHERE roof_bdm =$a_loginUid) or uid='$a_loginUid') $compay_id_sql ";
}
if($a_loginDesignation=="Marketing Manager" || $a_loginDesignation=="admin" || $a_loginDesignation=="Sales Manager"){
	$activity_sql="select distinct pid,edate from new_prime_activity where edate between '$fromDate' AND '$toDate' and ptype='m3' $compay_id_sql ";
	$activity_sql_a="select pid as num_of_prospect from new_prime_activity where edate between '$fromDate' AND '$toDate' and ptype='m3' and agendaID in ($agenda_line) $compay_id_sql ";
}
$aw_q=mysqli_query($db, $activity_sql);
$aw_row=mysqli_fetch_array($aw_q);
$Desire=mysqli_affected_rows($db);

if($a_loginDesignation=="Marketing Manager" || $a_loginDesignation=="admin"){
	$activity_sql_a="select pid as num_of_prospect from new_prime_activity where edate between '$fromDate' AND '$toDate' and ptype='m3' $compay_id_sql ";
}
elseif($a_loginDesignation=="Marketing Executive"){
	$activity_sql_a="select pid as num_of_prospect from new_prime_activity where edate between '$fromDate' AND '$toDate' and ptype='m3' $compay_id_sql and agendaID='$agenda_info[id]' ";
}
$aw_q_a=mysqli_query($db, $activity_sql_a);
$aw_row_a=mysqli_fetch_array($aw_q_a);
$Desire_activity=mysqli_affected_rows($db);
	
	

//=============================================================BDM===================================================
//==================================================Upgradation/Dropouts:============================================
	if($a_loginDesignation=="Sales Manager"){
		$i_d_sql="select * from me_property where lastUpdate between '$fromDate' and '$toDate' and project_marketingTarget='i' and agenda_id in ($agenda_line) $compay_id_sql ";
		mysqli_query($db, $i_d_sql);
		$Interest_date_range=mysqli_affected_rows($db);

		$i_d_sql="select * from me_property where lastUpdate between '$fromDate' and '$toDate' and project_marketingTarget='d' and agenda_id in ($agenda_line) $compay_id_sql ";
		mysqli_query($db, $i_d_sql);
		$Desire_date_range=mysqli_affected_rows($db);

		$i_d_sql="select * from me_property where lastUpdate between '$fromDate' and '$toDate' and project_marketingTarget='s' and agenda_id in ($agenda_line) $compay_id_sql ";
		mysqli_query($db, $i_d_sql);
		$Sales_date_range=mysqli_affected_rows($db);

		$i_d_sql="select * from me_property where lastUpdate between '$fromDate' and '$toDate' and project_marketingTarget='a' and agenda_id in ($agenda_line) $compay_id_sql ";
		mysqli_query($db, $i_d_sql);
		$awareness_date_range=mysqli_affected_rows($db);

	}	//bdm

//=============================================================ME===================================================
//==================================================Upgradation/Dropouts:=========================================
	if($a_loginDesignation=="Marketing Executive"){
		$i_d_sql="select * from me_property where lastUpdate between '$fromDate' and '$toDate' and project_marketingTarget='i' and agenda_id='$agenda_info[id]' $compay_id_sql ";
		mysqli_query($db, $i_d_sql);
		$Interest_date_range=mysqli_affected_rows($db);

		$i_d_sql="select * from me_property where lastUpdate between '$fromDate' and '$toDate' and project_marketingTarget='d' and agenda_id='$agenda_info[id]' $compay_id_sql ";
		mysqli_query($db, $i_d_sql);
		$Desire_date_range=mysqli_affected_rows($db);

		$i_d_sql="select * from me_property where lastUpdate between '$fromDate' and '$toDate' and project_marketingTarget='s' and agenda_id='$agenda_info[id]' $compay_id_sql ";
		mysqli_query($db, $i_d_sql);
		$Sales_date_range=mysqli_affected_rows($db);

		$i_d_sql="select * from me_property where lastUpdate between '$fromDate' and '$toDate' and project_marketingTarget='a' and agenda_id='$agenda_info[id]' $compay_id_sql ";
		mysqli_query($db, $i_d_sql);
		$awareness_date_range=mysqli_affected_rows($db);
	}//me
}//submit condition
else{
	$Awareness=0;
	$Awareness_activity=0;
	
	$Interest=0;
	$Interest_activity=0;
	
	$Desire=0;
	$Desire_activity=0;
	
	//=========================================================
	$awareness_date_range=0;
	$Sales_date_range=0;
	$Desire_date_range=0;
	$Interest_date_range=0;
}?>
		   

		   
		   <p style="margin:0px; text-align:center; font-weight:700;">
			    Activity
		   </p>
		   <!---<p style="margin:0px;">
			   Address update: 0 prospects 
		   </p>	-->	  
		   <p style="margin:0px;">
			   Awareness generation <span style="color:#00f;"><?php echo $Awareness; ?></span> prospects, <span style="color:#00f;"><?php echo $Awareness_activity; ?></span> activities
		   </p>
		  
		   <p style="margin:0px;">
			  Interest development <span style="color:#00f;"><?php echo $Interest; ?></span> prospects, <span style="color:#00f;"><?php echo $Interest_activity; ?></span> activities
		   </p>

		   <p style="margin:0px;">
			  Sales motivation <span style="color:#00f;"><?php echo $Desire; ?></span> prospects, <span style="color:#00f;"><?php echo $Desire_activity; ?></span> activities
		   </p>
		  
<!-- 		   <p style="margin:0px;">
			   Desire creation <span style="color:#00f;"><?php echo $Desire; ?></span> prospects, <span style="color:#00f;"><?php echo $Desire_activity; ?></span> activities
		   </p> -->
	   </td>
		 <td width="35%">
			 <p style="margin:0px; text-align:center; font-weight:700;">
				 Upgradation/Dropouts:
			 </p>
<!-- 			 <p style="margin:0px;">
				 Desire created to <span style="color:#00f;"><?php echo $Desire_date_range; ?></span> prospects 
			 </p> -->
			 <p style="margin:0px;">
				 Sales motivated to <span style="color:#00f;"><?php  echo $Sales_date_range; ?></span> prospects, <span style="color:#00f;"><?php echo $a_loginDesignation=="Sales Manager" ? bidsCounter4BDM($a_loginUname) : bidsCounter4ME($a_loginUname); ?></span> Bids
			 </p>
			 <P	style="margin:0px;">
				 Interest developed to <span style="color:#00f;"><?php echo $Interest_date_range; ?></span> prospects 
			 </P>
			 <p style="margin:0px;">
				 Awareness created
				 <!-- Back to awareness -->
				  <span style="color:#00f;"><?php echo $awareness_date_range; ?></span> prospects
			 </p>
		 </td>
     </tr>
	</table>
	 <tr height="10"><td colspan="7">
	 <table width="100%" border="1" bordercolor="#999999" style="border-collapse:collapse">
	
     <?php // } ?>
<tr bgcolor="#999999">
	<td width="20%" height="30" align="center"><strong>Prospect</strong></td>
	<!--<td width="15%" align="center"><strong>Probability</strong></td>-->
	<?php if (($sortby!="name")) { ?>
	<td width="10%" align="center"><strong>Marketing Person</strong></td>
	<?php } 
if($sortby!="edate"){ ?>
	<td width="15%" align="center"><strong>Type</strong></td>
<?php } ?>
	<td width="30%" height="30" align="center"><strong>Activity Details</strong></td>
	<td width="10%" align="center"><strong>Report Date</strong></td>
	<td width="10%" align="right"><strong>Amount</strong></td>
	<td width="10%" align="right"><strong>Comment by SM</strong></td>
	<?php if($a_loginDesignation=="admin"){?>
	<td width="5%" align="right"><strong>Action</strong></td>
	<?php }?>
</tr>
 
<?php 
if($fromDate!="" and $toDate!="")
	$datecond="and new_prime_activity.edate between '$fromDate' AND '$toDate' ";
$sortby=$_POST['sortby'];	
if($sortby=="")
{
	$sql="SELECT project.id as pros_id,project.pname,project.purl, new_prime_activity.probability, new_prime_activity.name, new_prime_activity.repname,new_prime_activity.ptype,new_prime_activity.activity, new_prime_activity.edate, new_prime_activity.amount from new_prime_activity,project where new_prime_activity.pid=project.id and new_prime_activity.company_id='$a_company_id' ".$datecond. " order by new_prime_activity.edate DESC";

	// echo $sql;
	// print $sql="SELECT project.pname, new_prime_activity.probability, new_prime_activity.name, new_prime_activity.activity, new_prime_activity.edate, new_prime_activity.amount from new_prime_activity,project where new_prime_activity.name=$a_loginFullName and new_prime_activity.pid=project.id order by $sortby ASC";
	
	$tamout=0;
	$sqlq=mysqli_query($db, $sql);
	//if(mysqli_num_rows($sqlq)>0)
	//{
		while($re=mysqli_fetch_array($sqlq))
		{
			$repphone=$re[repphone];
			$reptelno=$re[reptelno];
			$repemail=$re[repemail];
		?>
			<tr>
			<td valign="top"><? echo "<font color='#FF0000'>"; echo $re['pname'];
			 echo " "; echo $re['project_name']; echo "</font><br>";// echo $re['probability'];

			echo "<a href='./org_map.php?id=$re[pros_id]' target='_blank'><img src='./img/org-map.jpg' style='width: 12px; padding: 0px 5px;' title='Organization map'></a>";

if($re[purl])echo "<a href='".(strpos("http",$re[purl])>-1 ? $re[purl] : "http://".$re[purl])."' target='_blank'><img src='./img/purl.jpg' style='width: 12px; padding: 0px 5px;' title='External Link'></a>";
			 
			 	echo "<font color=''>";
								// echo $buyingRole.": ";
								echo $re['repname'];
								echo ", ";
								echo $deg; echo " ";
								//echo "; <br> ";
								echo "</font>";
								echo "<br> ";
								echo "Cell: ".$repphone.", ".$reptelno;
								echo "<br> ";
								echo "Email: ".$repemail;
			 ?></td>
			<!--<td valign="top"><? echo $re['probability'];?></td>-->
           <?php
		   // if($a_loginDesignation!="Sales Manager")
		   {?>
			<td valign="top" align="center"><?php echo $re['name']; ?></td>
	<?php }?>
			<!-- <td valign="top" align="center"><?php echo view_ptype($re['ptype']);?></td> -->
			<td valign="top">
<!--
							<font color='#0000FF'>
								<?php echo $re['agenda_type'];  ?>
							</font><br>
-->
		<?php
			echo $re['activity'];
			if($re['repname'])
			{
				$sqlp2 = "SELECT repname.repdesignation,repname.buyingRole from repname,new_prime_activity WHERE repname.repName='".$re['repname']."' and new_prime_activity.company_id='$a_company_id' and repname.company_id='$a_company_id'";
				$sqlrunp2= mysqli_query($db, $sqlp2);
				while($row2=mysqli_fetch_array($sqlrunp2))
				{	
					$deg=$row2['repdesignation'];
					// $buyingRole=viewBuyingrole($row2['buyingRole']);
				}
				
				//echo "; <br> ";				
			}
			?></td>

			<td valign="top" align="center"><? echo date("d-m-Y", strtotime($re['edate']));?></td>
			<!--<td valign="top"><div align="right"><? echo $re[amount];?></div></td>
			<td>asdf</td>-->
			</tr>
			<?
			 $tamount=$tamount+$re[amount];
		} //while re
	//} //end num_rows
			?>
			<tr bgcolor="#CCCCCC"><td colspan="5" valign="top"><div align="right"><strong></strong></div></td>
			<td valign="top"><div align="right"><strong></strong></div></td>
			</tr>

<?php
} //end if

if($sortby=="edate")
{	
	// ======================================================================================== Marketing Manager || admin
	if($a_loginDesignation=="Marketing Manager" || $a_loginDesignation=="admin")
	$q1="select distinct edate from new_prime_activity where edate between '$fromDate' AND '$toDate'     $compay_id_sql  
						 order by edate DESC";	//if($a_loginDesignation=="Sales Manager")
	
	// ======================================================================================== Sales Manager
	elseif($a_loginDesignation=="Sales Manager"){
		$all_agenda=unameToAgendaV2($a_loginUname);
		foreach($all_agenda as $agenda){
			if($agenda["id"]){
				$agenda_line.=",".$agenda["id"];
			}
		}
		$agenda_line=trim($agenda_line,",");
		$q1="select distinct edate from new_prime_activity where edate between '$fromDate' AND '$toDate' and agendaID in ($agenda_line) $compay_id_sql  order by edate DESC";
	}
	// ======================================================================================== ME || SE
	else 
		$q1="select distinct edate from new_prime_activity where edate between '$fromDate' AND '$toDate'  and   
						new_prime_activity.`agendaID`='$agenda_info[id]' $compay_id_sql  order by edate DESC";

	// echo $q1."<br><br>";
	$user_name=$_SESSION["a_loginUname"];
	$user_territory_sql=$lt->me_to_territory($user_name);
	//else
	//$q1="select distinct edate from new_prime_activity where edate between '$fromDate' AND '$toDate' order by edate DESC";
			$r1=mysqli_query($db, $q1);
			
				while($row1=mysqli_fetch_array($r1))
				{
					$edate=$row1[edate];
					// echo $edate."<br>";
					$tamount=0;
					if($a_loginDesignation=="Marketing Executive")
					{
						$q2="SELECT project.id as pros_id, project.pname,project.project_name, new_prime_activity.agenda_type,new_prime_activity.id, new_prime_activity.uid,new_prime_activity.probability, new_prime_activity.uid, new_prime_activity.fullname,  new_prime_activity.repname,new_prime_activity.ptype,new_prime_activity.activity, new_prime_activity.edate, new_prime_activity.amount,new_prime_activity.pid, new_prime_activity.agendaID from new_prime_activity,project where new_prime_activity.`agendaID`='$agenda_info[id]' and new_prime_activity.pid=project.id and new_prime_activity.edate='$edate' and ptype in ('m1','m2','m3','b1','b2','b3') and new_prime_activity.company_id='$a_company_id' and project.company_id='$a_company_id' and $user_territory_sql order by new_prime_activity.edate DESC";
					}
					elseif($a_loginDesignation=="Sales Manager"){

						$all_me=get_me_from_sm($_SESSION["a_loginUid"]);
						foreach($all_me as $me){
							$all_me_id[]=$me["id"];
						}
						$me_id_line=trim(implode(",",$all_me_id),",");
						// print_r($me_id_line);
						$q2="SELECT project.id as pros_id,project.purl, project.pname,project.project_name, new_prime_activity.agenda_type, new_prime_activity.id,new_prime_activity.probability, new_prime_activity.uid, new_prime_activity.fullname, new_prime_activity.repname,new_prime_activity.ptype,new_prime_activity.activity, new_prime_activity.edate, new_prime_activity.amount,new_prime_activity.pid, new_prime_activity.agendaID from new_prime_activity,project where new_prime_activity.pid=project.id and new_prime_activity.edate='$edate' and ptype in ('m1','m2','m3','b1','b2','b3') and new_prime_activity.company_id='$a_company_id' and project.company_id='$a_company_id'/* and new_prime_activity.uid in ($me_id_line)*/ and new_prime_activity.agendaID in ($agenda_line) order by new_prime_activity.edate DESC";
				}else{
						$q2="SELECT project.id as pros_id,project.purl, project.pname, project.project_name, new_prime_activity.agenda_type, new_prime_activity.id, new_prime_activity.probability, new_prime_activity.uid, new_prime_activity.fullname, new_prime_activity.repname, new_prime_activity.ptype,new_prime_activity.activity, new_prime_activity.edate, new_prime_activity.amount,new_prime_activity.pid, new_prime_activity.agendaID from new_prime_activity,project where new_prime_activity.pid=project.id and new_prime_activity.edate='$edate' and new_prime_activity.company_id='$a_company_id' and project.company_id='$a_company_id' order by new_prime_activity.edate DESC";
				}
					// echo $q2;

					$r2=mysqli_query($db, $q2);
					$pid_collector=null;
					if(mysqli_num_rows($r2)>0)
					{
						while($re=mysqli_fetch_array($r2))
						{
							// print_r($re);
							$pid_collector[]=$re[pid];
							$tamount=$tamount+$re[amount];
							$qu="select fullName from user where id='$re[uid]' $compay_id_sql ";
							$ru=mysqli_query($db, $qu);
							$rowu=mysqli_fetch_array($ru);
			?>
							<tr>
							<td valign="top"><? 
							echo "<font color='#FF0000'>";echo $re['pname']; echo $re['project_name']."</font>";

							echo "<a href='./org_map.php?id=$re[pros_id]' target='_blank'><img src='./img/org-map.jpg' style='width: 12px; padding: 0px 5px;' title='Organization map'></a>";


if($re[purl])echo "<a href='".(strpos("http",$re[purl])>-1 ? $re[purl] : "http://".$re[purl])."' target='_blank'><img src='./img/purl.jpg' style='width: 12px; padding: 0px 5px;' title='External Link'></a>";


							$sql2="SELECT * from cbp where pid='$re[pros_id]' $compay_id_sql";
							$me_property_q=mysqli_query($db,$sql2);
							$me_property_row=mysqli_fetch_array($me_property_q);
							// echo $sql2;

							// print_r($me_property_row);	
							echo "<br>";
							if($me_property_row["cp_name"]){
								echo view_cp($me_property_row["cp_name"]);
								echo "; ";
							}
							if($me_property_row["org_culture"]){
								echo view_orgbhv($me_property_row["org_culture"]);
								echo "; ";
							}
							if($me_property_row["clp_name"]){
								echo view_lp($me_property_row["clp_name"]);
								echo "<br>";
							}

								$entry_agenda_id=$re["agendaID"];
								$entry_sql="select * from me_property where agenda_id='$entry_agenda_id' and pid='$re[pros_id]' $compay_id_sql";
								$entry_q=mysqli_query($db,$entry_sql);
								$cp_row=mysqli_fetch_array($entry_q);
								// print_r($cp_row);
								?>
				
				<?php echo view_b2b($cp_row["cbp_rtb"],"rtb",1); ?>
				<?php echo view_b2b($cp_row["cbp_pros"],"pros",1); ?>
				<?php echo view_b2b($cp_row["cbp_cust"],"cust",1); ?>
				<?php echo view_b2b($cp_row["futb"],"futb",1); ?>
				<?php echo view_b2b($cp_row["cbp_loy_cust"],"loy_cust",1); ?>
				<?php echo view_b2b($cp_row["cbp_pros_part"],"pros_part",1); ?>
				<?php echo view_b2b($cp_row["cbp_dis_c"],"cbp_dis_c",1); ?>
				<?php echo view_b2b($cp_row["cbp_n_b_c"],"cbp_n_b_c",1); ?> 
				<?php echo view_b2b($cp_row["cbp_loyal_cust2"],"cbp_loyal_cust2",1);
								echo "<br><small><i>"; ?>
				<?php echo $cp_row['cbp_des'];

							echo "</i></small><br><br>";
							echo "<font color=''>";
							
							if($re['repname'])
							{
								//$sqlp2 = "SELECT repname.repdesignation,repname.buyingRole from repname,new_prime_activity WHERE new_prime_activity.repname=repname.repName and repname.pid=new_prime_activity.pid";
						$sqlp2 = "SELECT distinct repname.repdesignation, repname.buyingRole, repname.repphone, repname.repphone, repname.repemail
								from repname WHERE repname.repName=trim('".$re['repname']."')";
								$sqlrunp2= mysqli_query($db, $sqlp2);
								if(mysqli_affected_rows($db)>0)
								while($row=mysqli_fetch_array($sqlrunp2))
								{
									$deg=$row['repdesignation'];
									//$buyingRole=viewBuyingrole($row['buyingRole']);
									//echo $row['buyingRole'];
									$repphone=$row[repphone];
									$reptelno=$row[reptelno];
									$repemail=$row[repemail];
								}
								else
								{
									$deg=$buyingRole="";
									$repphone="";
									$reptelno="";
									$repemail="";
								}
								//echo "<br>";
							}
								// echo $buyingRole.": ";
								echo trim($re['repname']);
								echo ", ";
								echo $deg; echo " ";
								echo "</font>";
								// echo "<br> ";
								// echo "Cell: ".$repphone.", ".$reptelno;
								// echo "<br> ";
								// echo "Email: ".$repemail;
							//echo "</font><br>"; echo $re['probability']; echo " % "; echo viewProbabilityText($re['probability'])//$re['probability'];?></td>
							<!--<td valign="top"><? echo $re['probability'];?></td>-->
                            <?php //if($a_loginDesignation!="Sales Manager")
		   					{?>
							<td valign="top" align="center"><? echo $re['fullname']; ?></td>
                      <?php }?>
							<!-- <td valign="top" align="center"></td> -->
							<td valign="top">
							<!--<font color='#0000FF'>
								<?php echo $re['agenda_type'];  ?>
							</font><br>-->

			<?
			if($re["ptype"]=="m2")
				echo "<font color='#008c00'>";
			else
				echo "<font color='#00f'>";
				echo view_ptype($re['ptype']);
				echo "</font>";
				echo "<br>";
				echo "<br>";
							echo "<i>".$re['activity']."</i>";
							?></td>
						
							<td valign="top" align="center"><? echo date("d-m-Y", strtotime($re['edate']));?></td>
							<td valign="top" align="right"><? echo number_format($re['amount'],2);?></td>

			

<td valign="top" class="commentTd" id="<?php echo $re['id'];?>"><div align="right"><? echo getLastComment($re[id]);?></div><div class="commentDiv"><input type="button" value="New Comment" class="btnComment"></div><div class='addCommentEntry'><textarea></textarea><br><input type='button' value='Add' id='addBtn'></div>
				</td>
                  <!--	            <input type="hidden" name="d" value="<? echo $re[id];?>">-->
							<?php if($a_loginDesignation=="admin"){?>
							<td align="right"><a href="index.php?keyword=allnewprimeactivities&id=<? echo $re[id];?>&d=1">[Delete]</a></td>
            				<?php }?>
							</tr>
							<? 
						}//while re
						
					}
					if(count($pid_collector)>0){
							$all_pid=implode(",",$pid_collector);
							if($a_loginDesignation=="Sales Manager")
								$sql="select count(distinct pid) as num_of_prospect from new_prime_activity where edate='$edate' and uid='$a_loginUid' and pid in ($all_pid) and ptype in ('m1','m2','m3','b1','b2','b3') 
								$compay_id_sql
								group by edate";
							else
								$sql="select count(distinct pid) as num_of_prospect from new_prime_activity where edate='$edate' and agendaID='$agenda_info[id]' and ptype in ('m1','m2','m3','b1','b2','b3') and pid in ($all_pid)
								$compay_id_sql
								 group by edate";
							$result=mysqli_query($db, $sql);
							while($re1=mysqli_fetch_array($result))
							{
								$num_of_prospect=$re1['num_of_prospect'];
								//$edate=$re1['edate'];					

							}
							
					}else{
						$num_of_prospect=0;
					}	
					?>
						<tr bgcolor="#CCCCCC"><td <?php 
					
						if($a_loginDesignation=="Sales Manager") { if($sortby=="edate")echo "colspan='3'";else echo "colspan='4'";}else {echo "colspan='4'" ;} ?>><? echo "No. of Prospect: "; echo "<font color='#FF0000'>"; echo $num_of_prospect; echo "</font>";echo "; ";
							?>
						<?
						if($a_loginDesignation=="Sales Manager")
							$sql="select ptype, count(pid) as num_of_prospect from new_prime_activity where edate='$edate' and ptype<>'' and ptype in ('m1','m2','m3','b1','b2','b3') /*and uid='$a_loginUid'*/ and pid in ($all_pid) $compay_id_sql group by ptype";
						else
							$sql="select ptype, count(pid) as num_of_prospect from new_prime_activity where edate='$edate' and ptype<>'' and ptype in ('m1','m2','m3','b1','b2','b3') and agendaID='$agenda_info[id]' and pid in ($all_pid) $compay_id_sql group by ptype";
						$result=mysqli_query($db, $sql);

if(count($pid_collector)>0){
						if(mysqli_num_rows($result)>0)
						{
							while($rowp=mysqli_fetch_array($result))
							{
								$num_of_prospect=$rowp['num_of_prospect']; 
								
								$ptype=$rowp['ptype'];
								echo view_ptype($dsg.$ptype);
								echo "Activity: <strong><font color='FF0000'>";
								echo $num_of_prospect;
								echo "</strong></font>, ";
								
								
							}
						}
}else{
								echo view_ptype($dsg.$ptype);
								echo "Activity: <strong><font color='FF0000'>";
								echo 0;
								echo "</strong></font>, ";
	
}
?>
						</td>
					<!--	<td  valign="top"><div align="right"><strong>Sub Total</strong></div></td>-->
						<td valign="top" colspan="3"><div align="right"></div></td>
						</tr>
			
 		<?
			} //while row1
					 if($a_loginDesignation=="Sales Manager")
					 	$q3="select sum(amount) as total from new_prime_activity where edate between '$fromDate' and '$toDate' and uid='$a_loginUid' $compay_id_sql ";
					 elseif($a_loginDesignation=="Marketing Executive")
					 	$q3="select sum(amount) as total from new_prime_activity where edate between '$fromDate' and '$toDate' and uid='$a_loginUid' $compay_id_sql "; 
					else
					 	$q3="select sum(amount) as total from new_prime_activity where edate between '$fromDate' and '$toDate' $compay_id_sql ";
						$r3=mysqli_query($db, $q3);
						while($row3=mysqli_fetch_array($r3))
						{
						 $t=$row3[total];
						}
						?>
						<tr bgcolor="#E87575" height="5">
							<td <?php if($a_loginDesignation=="Sales Manager") { 
			if($sortby=="edate")
				echo "colspan='5'";
			else
				echo "colspan='6'";
		} elseif($sortby=="edate"
){echo "colspan='5'" ;} else {echo "colspan='5'" ;} ?>></td>
						<td></td>
					<!--	<td valign="top" colspan="4"><div align="right"><strong><?php //echo number_format($t);?></strong></div></td>-->
						</tr>

<?php
} //end if

elseif($sortby=="name")
{
	
	
	
	$sql="select distinct new_prime_activity.uid from new_prime_activity,project where new_prime_activity.pid=project.id and 	 new_prime_activity.agendaID in ($agenda_line) and new_prime_activity.company_id='$a_company_id' and project.company_id='$a_company_id'";
	// echo $sql;
	$r=mysqli_query($db, $sql);
	while($row=mysqli_fetch_array($r))
	{
		$uid=$row['uid'];
			$sq="select designation,fullName from user where id='$uid' and designation not in('Sales Manager','admin','Marketing Manager','Director','Sales Executive') $compay_id_sql ";
			
			$qr=mysqli_query($db, $sq);
			$rw=mysqli_fetch_array($qr);
if(mysqli_affected_rows($db)>0){
	
				$sql="select count(distinct pid) as num_of_prospect from new_prime_activity where uid='$uid' AND edate between '$fromDate' AND '$toDate'  and 	 new_prime_activity.agendaID in ($agenda_line) $compay_id_sql ";
			$result=mysqli_query($db, $sql);
			while($re1=mysqli_fetch_array($result))
			{
				$num_of_prospect1=$re1['num_of_prospect'];
							
			}
				$sql="select ptype, count(pid) as num_of_prospect from new_prime_activity where edate between '$fromDate' AND '$toDate' AND uid='$uid'  and 	 new_prime_activity.agendaID in ($agenda_line) $compay_id_sql group by ptype";
			$result=mysqli_query($db, $sql);

			if(mysqli_num_rows($result)>0 || 1==1)
			{
			$str="";
				while($rowp=mysqli_fetch_array($result))
				{
					$ptype=$rowp['ptype'];
					if(!array_search($ptype,array("b1","b2","b3","b4","m1","m2","m3")))continue;
					$num_of_prospect=$rowp['num_of_prospect']; 
					$str.= view_ptype($ptype);
					$str.= ": <strong><font color='FF0000'>";
					$str.= $num_of_prospect;
					$str.= "</strong></font>, ";
					
					
				}
			 }
	else{
		$num_of_prospect1=0;
			$num_of_prospect=0;
	}
	
	
		print "<tr><td colspan='6'> <strong>$rw[designation]: <font color='#FF0000'> $rw[fullName]</strong>; </font>";
	 echo "No. of Prospect: ";  echo "<font color='#FF0000'>";  echo $num_of_prospect1; echo "</font>"; echo "; " ;echo $str;
	echo "</td></tr>";
		$tamount=0;
	 	 $sql="SELECT project.id as pros_id,project.purl,project.pname,project.project_name,new_prime_activity.id,  new_prime_activity.agenda_type, new_prime_activity.uid,new_prime_activity.probability,new_prime_activity.repname, new_prime_activity.ptype,new_prime_activity.activity, new_prime_activity.edate, new_prime_activity.amount from new_prime_activity,project where new_prime_activity.pid=project.id and new_prime_activity.uid='$uid' ".$datecond. "
 and new_prime_activity.company_id='$a_company_id' and project.company_id='$a_company_id'

		order by new_prime_activity.uid, new_prime_activity.edate DESC";
		// echo $sql;
		$sqlq=mysqli_query($db, $sql);
		if(mysqli_num_rows($sqlq)>0)
		{
			while($re=mysqli_fetch_array($sqlq))
			{
			?>
			<tr>
			<font class="out"><td valign="top">

				<? echo "<font color='#FF0000'>"; echo $re['pname']; echo "<br> ";
			 echo $re['project_name'];echo "</font>";



							echo "<a href='./org_map.php?id=$re[pros_id]' target='_blank'><img src='./img/org-map.jpg' style='width: 12px; padding: 0px 5px;' title='Organization map'></a>";
							
if($re[purl])echo "<a href='".(strpos("http",$re[purl])>-1 ? $re[purl] : "http://".$re[purl])."' target='_blank'><img src='./img/purl.jpg' style='width: 12px; padding: 0px 5px;' title='External Link'></a>";
			 
			 
			 if($re['repname'])
			{
				$sqlp2 = "SELECT repname.repdesignation,repname.buyingRole,
				
								repname.repphone,
								repname.repphone,
								repname.repemail
				
				from repname WHERE repname.repName='".trim($re['repname'])."'";
				$sqlrunp2= mysqli_query($db, $sqlp2);
				if(mysqli_affected_rows($db)>0)
				while($row=mysqli_fetch_array($sqlrunp2))
				{	
					$deg=$row['repdesignation'];
					// $buyingRole=viewBuyingrole($row['buyingRole']);
									$repphone=$row[repphone];
									$reptelno=$row[reptelno];
									$repemail=$row[repemail];
								}
								else
								{
									$deg=$buyingRole="";
									$repphone="";
									$reptelno="";
									$repemail="";
								}
			
			}
			 
								echo "<font color=''>";
								// echo $buyingRole.": ";
								echo $re['repname'];
								echo ", ";
								echo $deg; echo " ";
								//echo "; <br> ";
								echo "</font>";
								echo "<br> ";
								echo "Cell: ".$repphone.", ".$reptelno;
								echo "<br> ";
								echo "Email: ".$repemail;
			 
			 // echo $re['probability']; echo " % "; echo viewProbabilityText($re['probability']); ?></td></font>
			<!--<td valign="top"><? echo $re['probability']; echo " % "; echo viewProbabilityText($re['probability']);?></td>
			<td><? echo $re['name'];?></td>-->
			<td valign="top" align="center"><? echo view_ptype($re['ptype']);?></td>
			<td valign="top" width="30%" align="">
							<!--<font color='#0000FF'>
								<?php echo $re['agenda_type'];  ?>
							</font><br>-->
			
			<?
			 echo $re['activity'];
			
			
			?>
			
			</td>
			
			
			<td valign="top" align="center"> <? echo date("d-m-Y", strtotime($re['edate']));?></td>
							<td valign="top" align="right"><? echo $re['amount'];?></td>
			<td valign="top" class="commentTd" id="<?php echo $re['id'];?>"><div align="right"><? echo getLastComment($re[id]);?></div><div class="commentDiv">
				<input type="button" value="New Comment" class="btnComment">
				</div>
				<div class='addCommentEntry'><textarea></textarea><br><input type='button' value='Add' id='addBtn'></div>
				</td>
			 <?php if($a_loginDesignation=="admin"){?>
			<td align="right"><a href="index.php?keyword=allnewprimeactivities&id=<? echo $re[id];?>&d=1">[Delete]</a></td>
            <?php }?>
			</tr>
			<?
			}//while desg
			$tamount=$tamount+$re[amount];
			} //while re
			//here for $uname



		 
		 ?>
			<tr bgcolor="#CCCCCC" height="12">
			<td <?php
			if($sortby=="edate")
				echo "colspan='6'";
			else
				echo "colspan='4'";
			?>></td>
			<td ><div align="right"><strong></strong></div></td>
			<td><div align="right"><strong></strong></div></td>
			</tr>
	<?	
	
		}//end num_rows
	} //end while $row ?>
	<?
	 $q1="select sum(amount) as total from new_prime_activity where edate between '$fromDate' and '$toDate' $compay_id_sql ";
	 $r1=mysqli_query($db, $q1);
		while($row1=mysqli_fetch_array($r1))
		{
		 $t=$row1[total];
		}
	?>
	<tr bgcolor="#E87575"><td colspan="5" valign="top" ><div align="right"></div></td>
		<td valign="top"><div align="right">&nbsp;<?php //echo number_format($t);?></div></td></tr>
<? } //end elseif
elseif($sortby=="pname")
{
if($a_loginDesignation=="Sales Manager"){
	
	$sql="select distinct project.pname,project.project_name, new_prime_activity.agenda_type,new_prime_activity.pid,new_prime_activity.uid from new_prime_activity,project where new_prime_activity.pid=project.id and new_prime_activity.agendaID in ($agenda_line) and new_prime_activity.edate between '$fromDate' and '$toDate'  and new_prime_activity.company_id='$a_company_id' and project.company_id='$a_company_id' group by  new_prime_activity.pid";
	// echo ($sql);
}else{
	$agenda_line=unameToAgenda4MEv3($a_loginUname)[id];
	
	$sql="select distinct project.pname,project.project_name, new_prime_activity.agenda_type,new_prime_activity.pid from new_prime_activity,project where new_prime_activity.pid=project.id 
 and new_prime_activity.agendaID in ($agenda_line) and new_prime_activity.company_id='$a_company_id' and project.company_id='$a_company_id' ";
	
}
$r=mysqli_query($db, $sql);
while($row=mysqli_fetch_array($r))
	{
		$pname=$row[pname];
		$pid=$row[pid];
		//print "<tr><td colspan='6'> <font color='#FF0000'><strong> $pname </strong></font></td></tr>";
		if($a_loginDesignation=="Sales Manager")
		{
		$sql="SELECT new_prime_activity.id,project.pname,project.project_name,project.purl,new_prime_activity.probability, new_prime_activity.fullname, new_prime_activity.uid, new_prime_activity.repname,new_prime_activity.ptype, new_prime_activity.activity, new_prime_activity.edate, new_prime_activity.amount, new_prime_activity.agenda_type from new_prime_activity,project where new_prime_activity.agendaID in ($agenda_line) and new_prime_activity.pid=project.id and project.pname='$pname' ".$datecond. "order by project.pname, new_prime_activity.edate DESC";
		}
		else
		{
		$sql="SELECT project.id as pros_id,project.pname,project.purl,project.project_name,new_prime_activity.id, new_prime_activity.agenda_type,new_prime_activity.probability, new_prime_activity.uid, new_prime_activity.repname, new_prime_activity.fullname,new_prime_activity.ptype, new_prime_activity.activity, new_prime_activity.edate, new_prime_activity.amount from new_prime_activity,project where new_prime_activity.pid=project.id and project.pname='$pname' ".$datecond. " and new_prime_activity.agendaID in ($agenda_line) order by project.pname, new_prime_activity.edate DESC";
		}
		$tamount=0;
		$sqlq=mysqli_query($db, $sql);
		if(mysqli_num_rows($sqlq)>0)
		{
		while($re=mysqli_fetch_array($sqlq))
		{
			 $sq1="select fullName from user where id='$re[uid]'";
			$qr1=mysqli_query($db, $sq1);
			$rw1=mysqli_fetch_array($qr1);
			
			?>
			<tr>
			<td valign="top"><? echo "<font color='#FF0000'>"; echo $re['pname']; echo "<br> "; echo $re['project_name']."</font>"; 


							echo "<a href='./org_map.php?id=$re[pros_id]' target='_blank'><img src='./img/org-map.jpg' style='width: 12px; padding: 0px 5px;' title='Organization map'></a>";


if($re[purl])echo "<a href='".(strpos("http",$re[purl])>-1 ? $re[purl] : "http://".$re[purl])."' target='_blank'><img src='./img/purl.jpg' style='width: 12px; padding: 0px 5px;' title='External Link'></a>";

				echo "<font color=''>";
				
				
			if($re['repname'])
			{
				$sqlp2 = "SELECT repname.repdesignation,
								repname.buyingRole,
								repname.repphone,
								repname.repphone,
								repname.repemail from repname,new_prime_activity WHERE repname.repName=trim('".$re['repname']."')";
				$sqlrunp2= mysqli_query($db, $sqlp2);
				
				if(mysqli_affected_rows($db)>0)
					while($row2=mysqli_fetch_array($sqlrunp2))
					{	
						$deg=$row2['repdesignation'];
						// $buyingRole=viewBuyingrole($row2['buyingRole']);
									$repphone=$row2[repphone];
									$reptelno=$row2[reptelno];
									$repemail=$row2[repemail];
								}
								else
								{
									$deg=$buyingRole="";
									$repphone="";
									$reptelno="";
									$repemail="";
								}

			
			}
				
				
								// echo $buyingRole.": ";
								echo $re['repname'];
								echo ", ";
								echo $deg." ";
								//echo "; <br> ";
								echo "</font>";
								// echo "<br> ";
								// echo "Cell: ".$repphone.", ".$reptelno;
								// echo "<br> ";
								// echo "Email: ".$repemail;
			//echo "</font><br>";echo $re['probability']; echo " % "; echo viewProbabilityText($re['probability'])?></td>
			<!--<td valign="top"><? echo $re['probability']; echo " % "; echo viewProbabilityText($re['probability']);?></td>-->
            <?php //if($a_loginDesignation!="Sales Manager")
		   {?>
				<td valign="top"><? echo $re['fullname'];?></td>
     <?php }?>
			<td valign="top" align="center"><? echo view_ptype($re['ptype']);?></td>
			<td valign="top">
			
			<!--
							<font color='#0000FF'>
								<?php echo $re['agenda_type'];  ?>
							</font><br>
			-->
			<? echo $re['activity'];

		
			?></td>
			
			<td valign="top" align="center"><? echo date("d-m-Y", strtotime($re['edate']));?></td>
							<td valign="top" align="right"><? echo $re['amount'];?></td>
						<td valign="top" class="commentTd" id="<?php echo $re['id'];?>"><div align="right"><? echo getLastComment($re[id]);?></div><div class="commentDiv">
				<input type="button" value="New Comment" class="btnComment">
				</div>
				<div class='addCommentEntry'><textarea></textarea><br><input type='button' value='Add' id='addBtn'></div>
				</td>
            <?php if($a_loginDesignation=="admin"){?>
			<td align="right"><a href="index.php?keyword=allnewprimeactivities&id=<? echo $re[id];?>&d=1">[Delete]</a></td>
            <?php }?>
			</tr>
			<?
			$tamount=$tamount+$re[amount];
		} //while re
						//if($a_loginDesignation=="Sales Manager")
							 $sqlp="select ptype,uid, count(pid) as num_of_prospect from new_prime_activity where edate between '$fromDate' and '$toDate' and pid='$pid' and uid='$a_loginUid' group by ptype";
						//else
							$sqlp="select ptype, count(pid) as num_of_prospect from new_prime_activity where edate between '$fromDate' and '$toDate' and pid='$pid' group by ptype";
						$result=mysqli_query($db, $sqlp);
						
						if(mysqli_num_rows($result)>0)
						{
							$str="";
							while($rowp=mysqli_fetch_array($result))
							{
								$num_of_prospect=$rowp['num_of_prospect']; 
								$ptype=$rowp['ptype'];
								$str.= view_ptype($ptype);
								$str.= ": <strong><font color='FF0000'>";
								 $str.= $num_of_prospect;
								$str.= "</strong></font>, ";
							
							}
						}
						
		?>
		<tr bgcolor="#CCCCCC"><td <?php if($a_loginDesignation=="Sales Manager"){
			if($sortby=="edate")
				echo "colspan='3'";
			else
				echo "colspan='5'";
		}else{
			echo "colspan='4'" ;
		} ?>><? echo $str;?>		
		</td><td valign="top" ><div align="right"><strong></strong></div></td>
		<td valign="top"><div align="right"></div></td>
		</tr>
	<?	
	} //end num_rows
	} //end while $row 
	//if($a_loginDesignation=="Sales Manager")
		$q1="select uid,sum(amount) as total from new_prime_activity where edate between '$fromDate' and '$toDate' and uid='$a_loginUid'";
	//else
	 //	$q1="select sum(amount) as total from new_prime_activity where edate between '$fromDate' and '$toDate'";
		$r1=mysqli_query($db, $q1);
		while($row1=mysqli_fetch_array($r1))
		{
		 $t=$row1[total];
		}
	?>
	<tr bgcolor="#E87575"><td <?php if($a_loginDesignation=="Sales Manager") { echo "colspan='5'" ;} else {echo "colspan='5'" ;} ?> valign="top" ><div align="right"><strong></strong></div></td>
		<td valign="top"><div align="right"><?php //echo number_format($t);?></div></td></tr>
<?		
} //end else if
?>
</table>
 </td></tr>
</form>

<div id="testdiv1" style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white;
     layer-background-color: white"></div>
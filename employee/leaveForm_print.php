<?php
  $format="Y-m-j";
  $sdate1 = formatDate($d1,$format);
  $year1=date("Y",strtotime($sdate1));

  include("config.inc.php");
	$db=mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);       

  $sqlq=@mysqli_query($db, "SELECT * FROM `leave` WHERE id='$leave_id'");
  $row=mysqli_fetch_array($sqlq);
$empId=$row[empId];
?>
	<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>

  <table width=100%>
    <tr>
    <td><h1><center style="color:#000; font-size:20px;">    
      Bangladesh Foundry &amp; Engineering Works Ltd.</h1></center></td>
    </tr>
    <tr>
      <td>
        <p align=center style="font-size:18px;    margin-top: -10px;     text-decoration: underline;">
          Leave Application
        </p>
      </td>
    </tr>
  </table>
  <br>
	
  <form name="leaveForm" onsubmit="return checkrequired(this);" action="index.php?keyword=leave+form" method="post">
<table align="center" width="500" border="3"  bordercolor="CC9999" cellpadding="3" cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#CC9999">
 <td align="right" valign="top" colspan="2"><font class='englishhead'>Leave Application #<?php echo $row[id]; ?></font></td>
</tr>

<tr>
 <td>Employee ID</td>
  <td>
	<?
	$sql=@mysqli_query($db, "SELECT * FROM employee WHERE empId='$row[empId]'") or die('Please try later!!');
	 while($typel= mysqli_fetch_array($sql)){
	 $plist.= "<b>".empId($typel[empId],$typel[designation])."</b>  ";
	 }
	 echo $plist;
	?>
	</td>
</tr>

<tr>
  <td>Application Date</td>
  <td>
    <?php
//     print_r($row);
    echo $row[app_date]; ?>
  </td>
</tr>
<? include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

 $sql1="SELECT * FROM employee WHERE empId='$row[empId]'";
 //echo $sql1;
 $sqlq1=@mysqli_query($db, $sql1) or die('Please try later!!');
 $emp= mysqli_fetch_array($sqlq1);
 
?>

<tr>
 <td>Name</td>
 <td><? echo $emp[name];?>
 <input type="hidden" name="empDate" value="<? echo $emp[empDate]; ?>">
  </td> 
</tr>
<tr>
 <td>Designation</td>
 <td><? 
$designation=$emp[designation];
 echo hrDesignation($emp[designation]);
 ?></td> 
</tr>
  
  

<tr>
  <td>Leave applied for</td>
  <td>
    <?php if($row[leaveApplied]==1)echo  "CASUAL"; 
    elseif($row[leaveApplied]==2) echo "SICK";
    elseif($row[leaveApplied]==3)echo "EARNED"; ?>
  </td>
</tr>
	
	
<tr>
 <td>From </td>
 <td><?php echo date("d/m/Y",strtotime($row["sdate"])); ?>
  </td>
</tr>
<tr>
 <td>To</td>
 <td><?php echo date("d/m/Y",strtotime($row["edate"])); ?>
 </td> 
</tr>
	
<tr>
 <td>Leave status</td>
 <td><? 
 $year=date("Y"); 
 $fromdat="$year-01-01";
 $todat="$year-12-31";
 $CasualleaveTaken=LeaveSplitly($empId,$fromdat,$todat,1);
 $SickleaveTaken=LeaveSplitly($empId,$fromdat,$todat,2);
?>
	
	 	 <table>
		 <tr><td>Leave taken <font class=out><?php echo $CasualleaveTaken+$SickleaveTaken; ?></font> days, 
			 Due <font class=out><?php echo $balance=29-($CasualleaveTaken+$SickleaveTaken); ?></font>  days (out of 29 days)</td></tr>
		 <tr>
			 <td>Casual <font class=out><?php echo $CasualleaveTaken; ?></font> days (out of 14 days)</td>
		 </tr>
		 <tr>
			 <td>Sick <font class=out><?php echo $SickleaveTaken; ?></font> days (out of 15 days)</td>
		 </tr>
	 </table>
	</td> 
</tr>
<tr>
 <td>Cause of Leave </td>
 <td><?php echo $row[cause]; ?></td>
</tr>
<tr>
 <td>Work responsibility will be taken care by: </td>
 <td><?php echo $row[responsible_emp_des]; ?></td>
</tr>
<tr>
 <td>Leave address</td>
 <td><?php echo $row[leaveAddress]; ?></td>
</tr>
<tr>
 <td>Work responsibility will be taken care by:</td>
 <td><?php echo $row[recommended]; ?></td>
</tr>
<!--
<tr>
 <td>Approve by</td>
 <td>
 <? //echo $sql1;
if($balance<=0)
 echo "Mr. K. Rahmatullah, Managing Director";
 else {
?>

     <select name="approveBy" size="1" >
 
<? include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

$temp= explode('_',$designation);

if($temp[0]>= 75 AND $temp[0]<= 76){$s="70-00-000"; $e="74-99-999";}
elseif($temp[0]>= 77 AND $temp[0]<= 98){$s="75-00-000"; $e="76-99-999";}

 $sql1="SELECT * FROM employee WHERE designation BETWEEN '$s' AND '$e' AND salaryType='Salary' ORDER by designation";
 
 $sql11=mysqli_query($db, $sql1); 
 while($elist= mysqli_fetch_array($sql11)){
 $plist1.= "<option value='".$elist[empId]."'";
 $plist1.= ">".empId($elist[empId],$elist[designation])."--$elist[name]</option>  ";
 }
 echo $plist1;
?>
</select>
<? 
//echo $sql1;
}?>
 </td>
</tr>
<? //if($balance<=0){?>

<tr>
  <td>Holiday Worked</td>
  <td> days</td>
</tr>

<tr>
 <td>Payment Condition</td>
<td><input type="radio" name="pay" value="1" >Without Pay   <input type="radio" name="pay" value="0" checked>With Pay</td>
</tr>
-->
<? //}?>
 </table>
  <table style="width: 600px; margin:auto;    margin-top: 60px;    margin-bottom: 100px; text-align:center; font-weight:800; ">
    <tr>
      <td align=center><u>Applicant's Signature<br>with date</u></td>
      <td align=center><u>Checked by HRD</u></td>
      <td align=center>
        <?php
        $sql_emp="select ccr,designation from employee where empId='$empId'";
        $q=mysqli_query($db,$sql_emp);
        $row=mysqli_fetch_array($q);
        $emp_des=$row["designation"];
        $des=itemDes($row["ccr"]);
        $emp_exp=explode("-",$emp_des);
        if(!($emp_exp[0]=="73" && $emp_exp[1]<"20" && $emp_exp[1]>"01")){ //not manager
          
          if($emp_exp[0]=="73" && $emp_exp[1]>="20" && $emp_exp[1]<="22"){ //executive
            echo "<u>Sanction Authority<br>";
          }else{ //
            echo "<u>Sanction by<br>";            
            if($row["ccr"])
              echo $des[des];            
          }
        }else{ //manager
          echo "<u>Sanction by<br>";
          echo "Chairman & Managing Director";
        }
        ?>
        </u></td>
    </tr>
  </table>
</form>
<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>

<script>
$(document).ready(function(){
	$("#check").click(function(){
		var url="index.php?keyword=leave+form&empId="+leaveForm.empId.options[document.leaveForm.empId.selectedIndex].value+"&d1="+leaveForm.d1.value+"&d2="+leaveForm.d2.value+"&cause="+leaveForm.cause.value+"&leaveAddress="+leaveForm.leaveAddress.value+"&recommended="+leaveForm.recommended.value;
	
<?php 
		if(!$d1 || !$d2){
			echo 'window.location.href=url;';
		}
?>
		

		var d1=$("#d1").val();
		var d2=$("#d2").val();
		var year1=d1.split("/")[2];
		var year2=d2.split("/")[2];
		
		if(d1>d2 || year1!=year2){
			alert("Year is not same");
			return;
		}
			$("#save").attr("disabled",false);
	});
	
	$("input,select").change(function(){
		if($(this).hasClass("check")==false && $(this).hasClass("save")==false){
			$("#save").attr("disabled",true);
		}
	});
	
	
});
</script>
<br>

<!-- Printed for Project 200 on August 23, 2016; 03:15PM by Md. Shajahan, Cashier -->
Printed for Project <?php echo myprojectName($_SESSION["loginProject"]); ?> on <?php echo todat_new_format("M d, Y; h:iA"); ?>; <?php echo $_SESSION["loginDesignation"]; ?>

<? // include("./includes/handler.php");?>
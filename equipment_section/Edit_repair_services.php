<?php 
include("common.php");
CreateConnection();

//--------------------Retreiving Work_order number---------------
session_start();
$work_order_id=$_SESSION['workorder_id'];
//echo"$work_order_id";
//--------------------Retreiving Repair Type name---------------
$repair_type=$_SESSION['repair'];
//echo"$repair_type";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Work Worder (#<?php echo"$work_order_id"; ?>) - Edit Repair Form</title>

<!-- For Creting the Equipment Session ID by calling server.php file  -->
<script src="script.js" type="text/javascript"></script>
<!--    END -->
<!-- For Calender-->
<script type="text/javascript" language="JavaScript1.2" src="stm32.js"></script>
<script language="javascript" type="text/javascript" src="datetimepicker.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" type="text/javascript" SRC="timepicker.js"></SCRIPT>
<!--   end   -->
<script language="javascript">
/*function openpopup(){
var centerWidth=(screen.width/2)-(300/2);
var centerHeight=(screen.height/2)-(300/2);
winpops=window.open("AddPartsUsed.php","","height=230,width=500,top="+centerHeight+",left="+centerWidth+",toolbar=0,location=0,directories=0,status=0,scrollbars=0,menubar=0,resizable=0,");
}
*/

//--------------------------This Function Will be run when the page is loaded---------------
function addLoadEvent(func) {
  var oldonload = window.onload;
  if (typeof window.onload != 'function') {
    window.onload = func;
  } else {
    window.onload = function() {
      if (oldonload) {
        oldonload();
      }
      func();
    }
  }
}

addLoadEvent(function() {
var counter='<?php echo $_GET['count']; ?>';
if(counter==1)
{
document.form1.selectRepair.disabled=true;
}

});

//-------------------------------------END-------------------------------------------------------

//---------------------------Validating Wheathe a repair type is selected or not--------------------
function validate1(frm)
{
if(frm.selectRepair.value=="")
{
alert("Please Select Repair Task.");
frm.selectRepair.focus();
return false;
}
return true
}

//for add(Parts used section)
function goAdd(frm)
{
if(validate1(frm)==true)
{
document.form1.hidField.value=1;
document.form1.submit();
}
}

//----For Add Button(Labor used Section)
function goAddLabor(frm)
{
if(validate1(frm)==true)
{
document.form1.hidField.value=5;
document.form1.submit();
}
}

//---------------------------Disable the Combo After Selection--------------------
function goDisable()
{
//-----------For checking which function is call form which form------------------

document.form1.hidRepair.value=3;
var chk_id=document.form1.hidRepair.value;

//......................creating the combo's object to make it desable.........................
obj=document.getElementById("selectRepair");
obj.disabled=true;
//--------------------storing combo value to create the session.............
repair=document.getElementById("selectRepair").value;

//----------------------------Loading the server.php page to initiate the session
//var element = document.getElementById('answer');
xmlhttp.open("GET", 'server.php?chk_id=' + chk_id + '&repair=' + repair);
xmlhttp.send(null);
}
//---------------------------------------END--------------------------


//-------Tracking Rows OndbClick Event---Which fetch the information corresponding to the row------

function goClick(m)
{
document.form1.hidPartNo.value=m;
document.form1.hidField.value=2;
document.form1.submit();

}

//----------------------------Tracking Cancle Button OnClick Event-----------------------
function goCancel()
{
document.form1.hidField.value=4;
document.form1.submit();
}

//----------------------------Tracking Save Buttons OnClick Event and seving the record----------------------

//-------------------------Validating Form Imput & Then Save & Exit------------------------------

function validate(form1)
{
if(form1.selectRepair.value=="")
{
alert("Cannot Save The Record.You Should Add PM Task Befere Saving the Record.");
form1.selectID.focus();
return false;
}
else if(form1.txt_part_cost.value=="")
{
alert("Cannot Save The Record.You Should add atlest one part.");
//form1.txt_part_cost.focus();
return false;
}
else if(form1.txt_total_cost.value=="")
{
alert("Cannot Save The Record.You Should add atlest one part.");
//form1.txt_part_cost.focus();
return false;
}
return true;
}


function doFinish(form1)
{
if(validate(form1)==true)
{
document.form1.hidField.value=3;
document.form1.submit();
}
}



</script>

</head>

<body>
<form action="Edit_repair_services_EntryMedium.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <p>
    <input name="hidField" type="hidden" id="hidField" />
    <input name="hidPartNo" type="hidden" id="hidPartNo" />
    <input name="hidRepair" type="hidden" id="hidRepair" />
  </p>
  <table width="767" align="center" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
    
    <tr bgcolor="#33CC33">
      <td colspan="7">Work Order (#<?php echo"$work_order_id"; ?>) - Repair Entry </td>
    </tr>
    <tr>
      <td width="116">&nbsp;</td>
      <td colspan="3">&nbsp;</td>
      <td width="73">&nbsp;</td>
      <td width="169">&nbsp;</td>
      <td width="38">&nbsp;</td>
    </tr>
    <tr bgcolor="#FF99FF">
      <td>Repair </td>
      <td colspan="3">
	  	
		<select name="selectRepair" id="selectRepair" onchange="goDisable()">
        <option value="" selected="selected"></option>
       							
								 <?php  
								
														
														CreateConnection();
								
														$rs="SELECT item_repair FROM equipment_repair_setup";
																			
														$result = mysqli_query($db, $rs);
														while ($name_row = mysql_fetch_row($result)) {
														$item_repair=$name_row[0];
														echo"<option value='$item_repair'"; if($item_repair==$repair_type) echo ' SELECTED '; echo">$item_repair</option>";		
														}
														
																
														
														
									?>
      </select></td>
      <td><div align="left">Parts</div></td>
      <td><?php
							  	
								CreateConnection();
								$qry="SELECT part_extended_cost FROM new_work_order_repair_parts_used WHERE work_order_id='$work_order_id' AND repair_type='$repair_type'";
							  	
								$qryexecute=mysqli_query($db, $qry);
								
								while($rs=mysql_fetch_row($qryexecute))
								{
									$cost=$rs[0];
									$ext_cost=$ext_cost+$cost;
								}
								
							  ?>
          
        <div align="left">
          <input name="txt_part_cost" type="text" id="txt_part_cost" value="<?php echo"$ext_cost"; ?>" size="15" READONLY/>      
        </div></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    
    <tr bgcolor="#FF99FF">
      <td>Labor
	  
	  					        <?php // calculating total Labor cost for a Repair task
							  	
								$qry1="SELECT lobor_cost FROM new_work_order_repair_labor_used WHERE work_order_id='$work_order_id' AND item_repair='$repair_type'";
							  	
								$qryexecute1=mysqli_query($db, $qry1);
								
								while($rs1=mysql_fetch_row($qryexecute1))
								{
									$cost1=$rs1[0];
									$ext_cost_labor=$ext_cost_labor+$cost1;
								}
								
							  ?>

	  
	  </td>
      <td colspan="3"><input name="txt_labor_cost" type="text" id="txt_labor_cost" value="<?php echo"$ext_cost_labor"; ?>" size="15" READONLY/></td>
      <td>
	  
	  	<?php 
		//calculating total cost(Parts+labpr)---
		$total_part_labor_cost=$ext_cost+$ext_cost_labor;
		?>
	  
	  <div align="left">Total</div></td>
      <td>
        <div align="left">
          <input name="txt_total_cost" type="text" id="txt_total_cost" READONLY value="<?php echo"$total_part_labor_cost"; ?>" size="15"/>
        </div></td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <br />
  <table width="767" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
    <tr bgcolor="#33CC33">
      <td width="229">Psrts Used </td>
      <td width="133">&nbsp;</td>
      <td width="133">&nbsp;</td>
      <td width="133">&nbsp;</td>
      <td width="135">&nbsp;</td>
    </tr>
    <tr>
      <td>Part #</td>
      <td>Name</td>
      <td>Used</td>
      <td>Cost</td>
      <td>Extended</td>
    </tr>
    			
											<?php 
												
												CreateConnection();
												$qry="SELECT part_num,part_name,part_quantity,part_unit_cost,part_extended_cost FROM new_work_order_repair_parts_used WHERE work_order_id='$work_order_id' AND repair_type='$repair_type'";

												
												
												$qryexecute=mysqli_query($db, $qry);
							
							while($rs=mysql_fetch_row($qryexecute))
							{
								$part_num=$rs[0];
								$part_name=$rs[1];
								$part_quantity=$rs[2];
								$part_unit_cost=$rs[3];
								$part_extended_cost=$rs[4];
																								
								echo"<tr bgcolor=#FF99FF ondblclick='goClick($part_num)'>
								
									<td>$part_num</td>
									<td>$part_name</td>
									<td>$part_quantity</td>
									<td>$part_unit_cost</td>
									<td>$part_extended_cost</td>
									</tr>";
								
								}
							


											?>
				
    <tr>
      <td><label>
        <input type="button" name="Button" value="   Add   " onclick="goAdd(form1)" />
      </label></td>
      <td><label></label></td>
      <td><label></label></td>
      <td><div align="right">Total</div></td>
      <td><label>
                              <input name="txt_part_total" type="text" id="txt_part_total" value="<?php echo"$ext_cost"; ?>" size="15"/>
      </label></td>
    </tr>
  </table>
<br />
  <table width="767" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
    <tr bgcolor="#33CC33">
      <td width="154">Labor Details </td>
      <td width="220">&nbsp;</td>
      <td width="122">&nbsp;</td>
      <td width="133">&nbsp;</td>
      <td width="138">&nbsp;</td>
    </tr>
    <tr>
      <td>Technisian</td>
      <td>Description of Work </td>
      <td>Rate</td>
      <td>Hours</td>
      <td>Extended</td>
    </tr>
    												<?php
//-Assining Session value which store the Repair Name  initiated at the NewWorkOrder_Repair_Entry.php(by calling-server.php) page--
$repair_type=$_SESSION['repair'];
 
												$qry1="SELECT emp_id,desc_of_work,emp_labor_rate,work_hour,lobor_cost FROM new_work_order_repair_labor_used WHERE work_order_id='$work_order_id' AND item_repair='$repair_type'";
												
												$qryexecute1=mysqli_query($db, $qry1);
							
							while($rs1=mysql_fetch_row($qryexecute1))
							{
								$emp_id=$rs1[0];
								$desc_of_work=$rs1[1];
								$emp_labor_rate=$rs1[2];
								$work_hour=$rs1[3];
								$lobor_cost=$rs1[4];
								
								//retreiving employee name from add_new_employee table based on $emp_Name value
								$qry2="SELECT emp_Name FROM add_new_employee WHERE emp_id='$emp_id'";
								$qryexecute2=mysqli_query($db, $qry2);
								$employe_name=mysql_result($qryexecute2,0,0);
																								
								echo"<tr bgcolor=#FF99FF ondblclick='goClick1($emp_id)'>
								
									<td>$employe_name</td>
									<td>$desc_of_work</td>
									<td>$emp_labor_rate</td>
									<td>$work_hour</td>
									<td>$lobor_cost</td>
									</tr>";
								
								}
							


											?>
    
    <tr>
      <td><label>
        <input type="button" name="Submit4" value="   Add   " onclick="goAddLabor(form1)"/>
      </label></td>
      <td><label></label></td>
      <td><label></label></td>
      <td><div align="right">Total</div></td>
      <td><input name="txt_part_total2" type="text" id="txt_part_total2" value="<?php echo"$ext_cost_labor"; ?>" size="15"/></td>
    </tr>
  </table>
 <br />
  <table width="767" align="center" cellpadding="0" cellspacing="0" bgcolor="#FF6633">
    <tr bgcolor="#33CC33">
      <td width="37">&nbsp;</td>
      <td width="363"><center><input name="BSave" type="button" id="BSave" onclick="doFinish(form1)" value="   Save   "/>
      </center></td>
      <td width="200"><center><input name="BCancel" type="submit" id="BCancel" value="  Cencel  " onclick="goCancel()"/>
      </center></td>
      <td width="200">&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>
